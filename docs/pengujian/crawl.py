#!/usr/bin/env python3
"""
Crawler uji website CBIM.
- Mengunjungi daftar rute awal + seluruh tautan internal yang ditemukan (spider).
- Menandai halaman dengan status HTTP bukan 200 atau berisi pesan error PHP/CI/DB.
- Memeriksa semua aset lokal (CSS, JS, gambar) yang dimuat setiap halaman.
Pemakaian: crawl.py BASE_URL OUT_JSON [peran]
  peran: publik (default) | admin | admin_tk | admin_sd
"""
import sys, json, re, time
from urllib.parse import urljoin, urlparse, urldefrag
import requests
from bs4 import BeautifulSoup

BASE = sys.argv[1].rstrip('/') + '/'
OUT = sys.argv[2]
PERAN = sys.argv[3] if len(sys.argv) > 3 else 'publik'
PASS = 'Uji#12345'
MAX_HALAMAN = 400

POLA_ERROR = [
    'A PHP Error was encountered', 'A Database Error Occurred',
    'An uncaught Exception was encountered', 'Fatal error', 'Parse error',
    '404 Page Not Found', 'Unable to load the requested', 'Error Number:',
    'Stack trace:', 'Severity: Warning', 'Severity: Notice', 'Severity: Error',
    'Uncaught Error', 'Uncaught TypeError', 'Undefined variable', 'Undefined array key',
    'Undefined index', 'Trying to access array offset', 'Call to a member function',
]
# Tautan yang tidak boleh diikuti (aksi merusak / keluar sesi)
SKIP = re.compile(r'(logout|delete|hapus|remove|seed_admin|/backup/(run|database)|add_to_cart|proses_checkout|unsubscribe)', re.I)

s = requests.Session()
s.headers['User-Agent'] = 'CBIM-Uji/1.0'

SEED_PUBLIK = [
    '', 'profil', 'struktur', 'jejaring', 'berita', 'berita?hal=2', 'berita?kategori=umum',
    'kegiatan', 'galeri', 'kebijakan-privasi', 'kebijakan_privasi', 'kontak',
    'search?q=sekolah', 'search?q=ppdb', 'search?q=', 'pendaftaran', 'pendaftaran/sukses',
    'sitemap.xml', 'robots.txt', 'api/search?q=tk', 'api/units', 'newsletter/unsubscribe?token=salah',
    'tk', 'tk/profil', 'tk/program', 'tk/fasilitas', 'tk/kegiatan', 'tk/berita', 'tk/video_kegiatan',
    'tk/galeri', 'tk/ppdb',
    'sd', 'sd/profil', 'sd/fasilitas', 'sd/kegiatan', 'sd/berita', 'sd/video_kegiatan', 'sd/galeri',
    'sd/ppdb',
    'auth', 'admin-tk/login', 'admin-sd/login', 'page/login',
    'katalog', 'contact/submit',
    'daftar', 'page/berita/4d54553d', 'berita/99999/tidak-ada',
    'halaman-yang-tidak-ada',  # harus 404 (kontrol)
]
SEED_PERAN = {
    'admin': ['admin', 'admin/struktur_organisasi', 'admin/manajemen_konten', 'admin/video_kegiatan',
              'admin/berita', 'admin/galeri', 'admin/pendaftaran_sd', 'admin/pendaftaran_tk',
              'admin/pendaftaran_terpadu', 'admin/pendaftaran_terpadu?jenjang=TK',
              'admin/pendaftaran_terpadu?status=Baru', 'admin/export_pendaftaran_csv',
              'admin/pesan_kontak', 'admin/newsletter', 'admin/backup'],
    'admin_tk': ['admin-tk', 'admin-tk/profil'],
    'admin_sd': ['admin-sd', 'admin-sd/profil'],
}
LOGIN = {
    'admin': ('auth/login', 'uji_admin'),
    'admin_tk': ('admin-tk/login', 'uji_tk'),
    'admin_sd': ('admin-sd/login', 'uji_sd'),
}


def internal(url):
    u = urlparse(url)
    b = urlparse(BASE)
    return u.scheme in ('http', 'https') and u.netloc == b.netloc


def norm(url):
    url, _ = urldefrag(url)
    return url


def cek_error(teks):
    return [p for p in POLA_ERROR if p in teks]


def login():
    path, user = LOGIN[PERAN]
    r = s.post(BASE + path, data={'username': user, 'password': PASS}, allow_redirects=True)
    return {'peran': PERAN, 'url_akhir': r.url, 'status': r.status_code,
            'berhasil': ('login' not in r.url and 'auth' not in r.url)}


hasil = {'base': BASE, 'peran': PERAN, 'halaman': {}, 'aset': {}, 'login': None}
if PERAN != 'publik':
    hasil['login'] = login()

antrian = [BASE + p for p in (SEED_PUBLIK if PERAN == 'publik' else SEED_PERAN[PERAN])]
dilihat = set()
aset_ditemukan = {}

while antrian and len(dilihat) < MAX_HALAMAN:
    url = norm(antrian.pop(0))
    if url in dilihat:
        continue
    dilihat.add(url)
    try:
        r = s.get(url, allow_redirects=True, timeout=60)
    except Exception as e:
        hasil['halaman'][url] = {'status': 'EXC', 'error': [str(e)]}
        continue
    ctype = r.headers.get('Content-Type', '')
    teks = r.text if ('text' in ctype or 'json' in ctype or 'xml' in ctype) else ''
    info = {'status': r.status_code, 'url_akhir': r.url, 'tipe': ctype.split(';')[0],
            'ukuran': len(r.content), 'error': cek_error(teks)}
    if info['error']:
        # simpan cuplikan pesan error agar mudah dianalisis
        m = re.search(r'(A PHP Error was encountered|A Database Error Occurred|An uncaught Exception|Fatal error|404 Page Not Found)(.{0,900})', re.sub(r'<[^>]+>', ' ', teks), re.S)
        if m:
            info['cuplikan'] = re.sub(r'\s+', ' ', m.group(0))[:900]
    hasil['halaman'][url] = info

    if 'html' not in ctype:
        continue
    soup = BeautifulSoup(teks, 'html.parser')
    # tautan halaman
    for a in soup.find_all('a', href=True):
        href = a['href'].strip()
        if href.startswith(('mailto:', 'tel:', 'javascript:', '#', 'whatsapp:')):
            continue
        full = norm(urljoin(r.url, href))
        if internal(full) and not SKIP.search(full) and full not in dilihat:
            pth = urlparse(full).path
            if re.search(r'\.(jpg|jpeg|png|gif|webp|svg|pdf|css|js|ico|mp4|zip|gz)$', pth, re.I):
                aset_ditemukan.setdefault(full, url)
                continue
            if PERAN != 'publik' and not re.search(r'/(admin|admin-tk|admin-sd)(/|$|\?)', full):
                continue  # sesi admin: hanya jelajahi area admin
            antrian.append(full)
    # aset
    for tag, attr in (('link', 'href'), ('script', 'src'), ('img', 'src'), ('source', 'src'),
                      ('video', 'poster'), ('meta', 'content')):
        for el in soup.find_all(tag):
            v = el.get(attr)
            if not v:
                continue
            if tag == 'link' and not set(el.get('rel', [])) & {'stylesheet', 'icon', 'shortcut', 'apple-touch-icon', 'preload', 'manifest'}:
                continue
            if tag == 'meta' and not (el.get('property', '') in ('og:image', 'twitter:image') or el.get('name', '') in ('twitter:image',)):
                continue
            full = norm(urljoin(r.url, v.strip()))
            if internal(full):
                aset_ditemukan.setdefault(full, url)
    for m in re.finditer(r"url\(['\"]?([^'\")]+)['\"]?\)", teks):
        full = norm(urljoin(r.url, m.group(1)))
        if internal(full) and not full.startswith('data:'):
            aset_ditemukan.setdefault(full, url)

for a, asal in sorted(aset_ditemukan.items()):
    try:
        r = s.get(a, timeout=60, stream=True)
        st = r.status_code
        r.close()
    except Exception as e:
        st = 'EXC'
    hasil['aset'][a] = {'status': st, 'dari': asal}

with open(OUT, 'w') as f:
    json.dump(hasil, f, indent=1, ensure_ascii=False)

hal_err = {u: i for u, i in hasil['halaman'].items() if i['status'] != 200 or i['error']}
aset_err = {u: i for u, i in hasil['aset'].items() if i['status'] != 200}
print(f"[{PERAN}] {BASE}  login={hasil['login']}")
print(f"  halaman dikunjungi: {len(hasil['halaman'])}, bermasalah: {len(hal_err)}")
print(f"  aset diperiksa   : {len(hasil['aset'])}, bermasalah: {len(aset_err)}")
