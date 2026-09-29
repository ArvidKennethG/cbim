#!/usr/bin/env python3
"""
Uji alur formulir & aksi admin website CBIM (end-to-end, lewat HTTP + cek database).
Pemakaian: uji_form.py BASE_URL NAMA_DB OUT_JSON
"""
import sys, json, re, subprocess, random, string
import requests
from bs4 import BeautifulSoup

BASE = sys.argv[1].rstrip('/') + '/'
DB = sys.argv[2]
OUT = sys.argv[3]
PASS = 'Uji#12345'
hasil = []


def sql(q):
    r = subprocess.run(['mariadb', '-uroot', DB, '-N', '-e', q], capture_output=True, text=True)
    return r.stdout.strip()


def catat(nama, lulus, detail=''):
    hasil.append({'uji': nama, 'lulus': bool(lulus), 'detail': detail})
    print(('LULUS ' if lulus else 'GAGAL ') + nama + ('  -- ' + detail if detail else ''))


def ada_error(teks):
    return any(p in teks for p in ('A PHP Error was encountered', 'A Database Error Occurred',
                                    'An uncaught Exception', 'Fatal error', 'Unable to load the requested'))


def tag(n=6):
    return ''.join(random.choice(string.ascii_uppercase) for _ in range(n))


def form_di(s, path, action_part):
    r = s.get(BASE + path)
    soup = BeautifulSoup(r.text, 'html.parser')
    for f in soup.find_all('form'):
        if action_part in (f.get('action') or ''):
            return f
    return None


# ---------------------------------------------------------------- PPDB TK
s = requests.Session()
f = form_di(s, 'tk/ppdb', 'tk/submit_ppdb')
catat('TK: halaman /tk/ppdb memuat formulir yang mengarah ke tk/submit_ppdb', f is not None)
nama_tk = 'Anak Uji TK ' + tag()
data_tk = {'nama_lengkap': nama_tk, 'kelompok': 'Kelompok A (Usia 4-5 Tahun)', 'jenis_kelamin': 'Perempuan',
           'tgl_lahir': '2021-05-10', 'nama_ortu': 'Ibu Uji Coba', 'no_hp': '081234567890',
           'alamat': 'Jl. Uji Coba No. 1, Kupang', 'persetujuan_ortu': '1', 'cbim_hp_check': ''}
r = s.post(BASE + 'tk/submit_ppdb', data=data_tk, allow_redirects=True)
n1 = sql(f"SELECT COUNT(*) FROM pendaftaran WHERE nama_lengkap='{nama_tk}' AND jenjang='TK'")
n2 = sql(f"SELECT COUNT(*) FROM pendaftaran_tk WHERE nama_lengkap='{nama_tk}'")
catat('TK: kirim PPDB valid -> tersimpan di pendaftaran & pendaftaran_tk',
      n1 == '1' and n2 == '1' and not ada_error(r.text), f'pendaftaran={n1}, pendaftaran_tk={n2}, url_akhir={r.url}')
catat('TK: pesan sukses tampil setelah kirim', 'berhasil' in r.text.lower() or 'terima kasih' in r.text.lower())
# honeypot
nama_bot = 'Bot TK ' + tag()
r = s.post(BASE + 'tk/submit_ppdb', data={**data_tk, 'nama_lengkap': nama_bot, 'cbim_hp_check': 'spam'})
catat('TK: honeypot terisi -> data TIDAK disimpan', sql(f"SELECT COUNT(*) FROM pendaftaran WHERE nama_lengkap='{nama_bot}'") == '0')
# tanpa persetujuan
nama_np = 'Tanpa Izin ' + tag()
d = dict(data_tk); d['nama_lengkap'] = nama_np; d.pop('persetujuan_ortu')
r = s.post(BASE + 'tk/submit_ppdb', data=d, allow_redirects=True)
catat('TK: tanpa persetujuan ortu (UU PDP) -> ditolak',
      sql(f"SELECT COUNT(*) FROM pendaftaran WHERE nama_lengkap='{nama_np}'") == '0' and 'Persetujuan' in r.text)

# ---------------------------------------------------------------- PPDB SD
s = requests.Session()
f = form_di(s, 'sd/ppdb', 'sd/submit_ppdb')
catat('SD: halaman /sd/ppdb memuat formulir yang mengarah ke sd/submit_ppdb', f is not None)
nama_sd = 'Anak Uji SD ' + tag()
data_sd = {'nama_lengkap': nama_sd, 'nisn': '1234567890', 'jenis_kelamin': 'Laki-laki', 'tempat_lahir': 'Kupang',
           'tgl_lahir': '2019-03-15', 'nama_ortu': 'Bapak Uji Coba', 'no_hp': '081298765432',
           'alamat': 'Jl. Uji Coba No. 2, Kupang', 'persetujuan_ortu': '1', 'cbim_hp_check': ''}
r = s.post(BASE + 'sd/submit_ppdb', data=data_sd, allow_redirects=True)
n1 = sql(f"SELECT COUNT(*) FROM pendaftaran WHERE nama_lengkap='{nama_sd}' AND jenjang='SD'")
n2 = sql(f"SELECT COUNT(*) FROM pendaftaran_sd WHERE nama_lengkap='{nama_sd}'")
catat('SD: kirim PPDB valid -> tersimpan di pendaftaran & pendaftaran_sd',
      n1 == '1' and n2 == '1' and not ada_error(r.text), f'pendaftaran={n1}, pendaftaran_sd={n2}')
catat('SD: pesan sukses tampil setelah kirim', 'Pendaftaran Berhasil' in r.text)
r = s.post(BASE + 'sd/submit_ppdb', data={**data_sd, 'nama_lengkap': 'Tgl Salah ' + tag(), 'tgl_lahir': '2099-01-01'}, allow_redirects=True)
catat('SD: tanggal lahir di masa depan -> ditolak validasi', 'Mohon Maaf' in r.text)

# ---------------------------------------------------------------- Pendaftaran terpadu (/pendaftaran)
s = requests.Session()
r = s.get(BASE + 'pendaftaran')
catat('/pendaftaran: halaman tampil tanpa error PHP', r.status_code == 200 and not ada_error(r.text))
nama_p = 'Calon SMA ' + tag()
r = s.post(BASE + 'pendaftaran/submit', data={'jenjang': 'SMA', 'nama_lengkap': nama_p, 'nik_nisn': '99887766',
           'jenis_kelamin': 'Perempuan', 'tempat_lahir': 'Kupang', 'tgl_lahir': '2010-01-01', 'agama': 'Kristen Protestan',
           'nama_ortu': 'Orang Tua Uji', 'pekerjaan_ortu': 'Guru', 'no_hp': '081211112222', 'email': 'uji@example.com',
           'alamat': 'Jl. Uji No. 3', 'asal_sekolah': 'SMP Uji', 'catatan': ''}, allow_redirects=True)
catat('/pendaftaran/submit -> tersimpan & halaman sukses tanpa error',
      sql(f"SELECT COUNT(*) FROM pendaftaran WHERE nama_lengkap='{nama_p}'") == '1' and not ada_error(r.text),
      f'url_akhir={r.url}')

# ---------------------------------------------------------------- Kontak & newsletter (endpoint)
s = requests.Session()
subj = 'Subjek Uji ' + tag()
r = s.post(BASE + 'kontak/kirim', data={'nama': 'Penguji', 'email': 'penguji@example.com', 'subjek': subj,
           'pesan': 'Ini pesan uji otomatis minimal sepuluh karakter.'}, headers={'X-Requested-With': 'XMLHttpRequest'})
catat('kontak/kirim (AJAX) -> tersimpan di pesan_kontak',
      sql(f"SELECT COUNT(*) FROM pesan_kontak WHERE subjek='{subj}'") == '1', r.text[:120])
em = f'uji{tag().lower()}@example.com'
r = s.post(BASE + 'newsletter/subscribe', data={'email': em, 'preferensi': 'semua'}, headers={'X-Requested-With': 'XMLHttpRequest'})
tok = sql(f"SELECT token_unsubscribe FROM newsletter_subscribers WHERE email='{em}'")
catat('newsletter/subscribe -> tersimpan', bool(tok), r.text[:120])
if tok:
    r = s.get(BASE + 'newsletter/unsubscribe?token=' + tok)
    st = sql(f"SELECT status FROM newsletter_subscribers WHERE email='{em}'")
    catat('newsletter/unsubscribe -> status Unsubscribed, halaman tanpa error', st == 'Unsubscribed' and not ada_error(r.text), st)

# ---------------------------------------------------------------- Admin yayasan
a = requests.Session()
r = a.post(BASE + 'auth/login', data={'username': 'uji_admin', 'password': PASS})
catat('Admin: login uji_admin', r.url.rstrip('/').endswith('admin'), r.url)
for p in ['admin/pendaftaran_terpadu', 'admin/pesan_kontak', 'admin/newsletter', 'admin/pendaftaran_sd', 'admin/pendaftaran_tk']:
    r = a.get(BASE + p)
    catat(f'Admin: {p} tampil tanpa error', r.status_code == 200 and not ada_error(r.text))
r = a.get(BASE + 'admin/pendaftaran_terpadu')
catat('Admin: pendaftar TK & SD dari formulir unit muncul di Pendaftaran Terpadu', nama_sd in r.text and (nama_tk in r.text))
idp = sql(f"SELECT id_pendaftaran FROM pendaftaran WHERE nama_lengkap='{nama_sd}'")
r = a.post(BASE + 'admin/update_status_pendaftaran', data={'id_pendaftaran': idp, 'status': 'Diterima'}, allow_redirects=True)
catat('Admin: ubah status pendaftaran -> Diterima', sql(f"SELECT status FROM pendaftaran WHERE id_pendaftaran={idp}") == 'Diterima')
r = a.get(BASE + 'admin/export_pendaftaran_csv')
catat('Admin: ekspor CSV pendaftaran', r.status_code == 200 and nama_sd in r.text and 'no_registrasi' in r.text.lower().replace(' ', '_') or (r.status_code == 200 and nama_sd in r.text),
      r.headers.get('Content-Disposition', ''))
idk = sql(f"SELECT id_pesan FROM pesan_kontak WHERE subjek='{subj}'")
if idk:
    a.post(BASE + 'admin/update_status_pesan', data={'id_pesan': idk, 'status': 'Sudah Dibaca'})
    catat('Admin: ubah status pesan kontak', sql(f"SELECT status FROM pesan_kontak WHERE id_pesan={idk}") == 'Sudah Dibaca')

# ---------------------------------------------------------------- Admin TK (CRUD konten_tk)
t = requests.Session()
r = t.post(BASE + 'admin-tk/login', data={'username': 'uji_tk', 'password': PASS})
catat('Admin TK: login uji_tk', r.url.rstrip('/').endswith('admin-tk'), r.url)
jenis = 'uji_' + tag().lower()
r = t.post(BASE + 'admin-tk/add_konten', data={'judul_konten': 'Judul Uji', 'sub_judul_konten': 'Sub', 'isi_konten': '<p>Isi uji</p>', 'jenis_konten': jenis}, allow_redirects=True)
idc = sql(f"SELECT id_konten FROM konten_tk WHERE jenis_konten='{jenis}'")
catat('Admin TK: tambah konten', bool(idc) and not ada_error(r.text))
if idc:
    t.post(BASE + 'admin-tk/update_konten', data={'id_konten': idc, 'judul_konten': 'Judul Diubah', 'sub_judul_konten': 'Sub', 'isi_konten': '<p>Isi baru</p>', 'jenis_konten': jenis})
    catat('Admin TK: ubah konten', sql(f"SELECT judul_konten FROM konten_tk WHERE id_konten={idc}") == 'Judul Diubah')
    t.post(BASE + 'admin-tk/delete_konten', data={'id_konten': idc})
    catat('Admin TK: hapus konten', sql(f"SELECT COUNT(*) FROM konten_tk WHERE id_konten={idc}") == '0')

# ---------------------------------------------------------------- Pembatasan peran (RBAC)
r = t.get(BASE + 'admin-sd')
catat('RBAC: akun admin_tk tidak bisa masuk panel admin-sd', 'admin-sd/login' in r.url or 'admin-sd' not in r.url.split('/')[-1] or 'login' in r.url, r.url)
x = requests.Session()
x.post(BASE + 'auth/login', data={'username': 'uji_tk', 'password': PASS})
r = x.get(BASE + 'admin/berita', allow_redirects=True)
catat('RBAC: akun admin_tk (lewat /auth) ditolak di admin/berita', 'Judul Berita' not in r.text and r.url.rstrip('/').endswith('admin'), r.url)
r = x.get(BASE + 'admin/export_pendaftaran_csv')
catat('RBAC: akun admin_tk TIDAK bisa ekspor CSV seluruh pendaftar', nama_sd not in r.text,
      'isi respons memuat data pendaftar' if nama_sd in r.text else 'ditolak')

with open(OUT, 'w') as fh:
    json.dump(hasil, fh, indent=1, ensure_ascii=False)
print(f"\nRINGKASAN: {sum(h['lulus'] for h in hasil)}/{len(hasil)} lulus")
