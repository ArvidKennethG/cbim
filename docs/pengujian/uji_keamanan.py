#!/usr/bin/env python3
"""
Uji tambahan untuk perbaikan keamanan/kebenaran.
Pemakaian: uji_keamanan.py BASE_URL NAMA_DB DOCROOT OUT_JSON
"""
import sys, json, subprocess, os, io, struct, zlib, random, string
import requests

BASE, DB, ROOT, OUT = sys.argv[1].rstrip('/') + '/', sys.argv[2], sys.argv[3], sys.argv[4]
PASS = 'Uji#12345'
hasil = []


def sql(q):
    return subprocess.run(['mariadb', '-uroot', DB, '-N', '-e', q], capture_output=True, text=True).stdout.strip()


def catat(nama, lulus, detail=''):
    hasil.append({'uji': nama, 'lulus': bool(lulus), 'detail': detail})
    print(('LULUS ' if lulus else 'GAGAL ') + nama + ('  -- ' + detail if detail else ''))


def png_kecil():
    raw = b'\x00\xff\x00\x00'
    def chunk(t, d):
        c = struct.pack('>I', len(d)) + t + d
        return c + struct.pack('>I', zlib.crc32(t + d) & 0xffffffff)
    return (b'\x89PNG\r\n\x1a\n' + chunk(b'IHDR', struct.pack('>IIBBBBB', 1, 1, 8, 2, 0, 0, 0))
            + chunk(b'IDAT', zlib.compress(raw)) + chunk(b'IEND', b''))


def tag(n=5):
    return ''.join(random.choice(string.ascii_lowercase) for _ in range(n))


def login(user, path='auth/login'):
    s = requests.Session()
    s.post(BASE + path, data={'username': user, 'password': PASS})
    return s


# --- data pendaftar TK & SD untuk uji hak akses
nt, ns = 'RBAC TK ' + tag(), 'RBAC SD ' + tag()
sql(f"INSERT INTO pendaftaran (no_registrasi,jenjang,nama_lengkap,jenis_kelamin,nama_ortu,no_hp,alamat,status,tanggal_daftar) VALUES "
    f"('REG-TK-X','TK','{nt}','Perempuan','Ortu','0812','Alamat uji','Baru',NOW()),('REG-SD-X','SD','{ns}','Laki-laki','Ortu','0812','Alamat uji','Baru',NOW())")
id_sd = sql(f"SELECT id_pendaftaran FROM pendaftaran WHERE nama_lengkap='{ns}'")

tk = login('uji_tk')
r = tk.get(BASE + 'admin/export_pendaftaran_csv')
catat('RBAC: CSV untuk admin_tk hanya berisi pendaftar TK', nt in r.text and ns not in r.text,
      f'memuat TK={nt in r.text}, memuat SD={ns in r.text}')
tk.post(BASE + 'admin/update_status_pendaftaran', data={'id_pendaftaran': id_sd, 'status': 'Ditolak'})
catat('RBAC: admin_tk tidak bisa mengubah status pendaftar SD', sql(f"SELECT status FROM pendaftaran WHERE id_pendaftaran={id_sd}") == 'Baru',
      'status SD sekarang: ' + sql(f"SELECT status FROM pendaftaran WHERE id_pendaftaran={id_sd}"))
adm = login('uji_admin')
r = adm.get(BASE + 'admin/export_pendaftaran_csv')
catat('RBAC: CSV untuk administrator berisi semua jenjang', nt in r.text and ns in r.text)

# --- sanitasi isi berita
judul = 'Berita XSS ' + tag()
isi = ('<p>Paragraf aman <strong>tebal</strong></p><script>alert(1)</script>'
       '<img src="x.png" onerror="alert(2)"><a href="javascript:alert(3)">tautan</a>'
       '<iframe src="https://contoh.invalid"></iframe><p onclick="alert(4)">klik</p>')
sql(f"INSERT INTO berita (judul_berita, isi_berita, tanggal_post, gambar) VALUES ('{judul}', '{isi}', NOW(), '')")
idb = sql(f"SELECT id_berita FROM berita WHERE judul_berita='{judul}'")
r = requests.get(BASE + f'berita/{idb}/uji')
body = r.text
catat('Sanitasi: halaman detail berita tampil (200)', r.status_code == 200)
catat('Sanitasi: <script>, on*, javascript:, <iframe> dibuang dari isi berita',
      '<script>alert(1)' not in body and 'onerror=' not in body and 'javascript:alert' not in body
      and 'contoh.invalid' not in body and 'onclick="alert(4)"' not in body,
      f"script={'<script>alert(1)' in body}, onerror={'onerror=' in body}, js={'javascript:alert' in body}, iframe={'contoh.invalid' in body}")
catat('Sanitasi: format biasa (p, strong, teks) tetap utuh', '<strong>tebal</strong>' in body and 'Paragraf aman' in body)
sql(f"DELETE FROM berita WHERE id_berita={idb}")

# --- galeri: hapus foto menghapus file di uploads/galeri
judul_f = 'Foto Uji ' + tag()
r = adm.post(BASE + 'admin/add_foto', data={'judul_foto': judul_f}, files={'foto': ('uji_galeri.png', png_kecil(), 'image/png')})
row = sql(f"SELECT CONCAT(id_foto,'|',foto) FROM galeri WHERE judul_foto='{judul_f}'")
if row:
    idf, nf = row.split('|')
    ada = os.path.isfile(os.path.join(ROOT, 'uploads/galeri', nf))
    adm.post(BASE + 'admin/delete_foto', data={'id_foto': idf, 'foto': nf})
    hilang = not os.path.isfile(os.path.join(ROOT, 'uploads/galeri', nf))
    catat('Galeri: hapus data juga menghapus file di uploads/galeri/', ada and hilang, f'file ada setelah upload={ada}, terhapus={hilang}')
else:
    catat('Galeri: hapus data juga menghapus file di uploads/galeri/', False, 'upload gagal')

# --- path traversal pada update_foto (foto_lama = ../../robots.txt)
judul_t = 'Foto Traversal ' + tag()
adm.post(BASE + 'admin/add_foto', data={'judul_foto': judul_t}, files={'foto': ('uji_t.png', png_kecil(), 'image/png')})
row = sql(f"SELECT CONCAT(id_foto,'|',foto) FROM galeri WHERE judul_foto='{judul_t}'")
target = os.path.join(ROOT, 'robots.txt')
sebelum = os.path.isfile(target)
if row:
    idf, nf = row.split('|')
    adm.post(BASE + 'admin/update_foto', data={'id_foto': idf, 'judul_foto': judul_t, 'foto_lama': '../../robots.txt'},
             files={'foto': ('uji_t2.png', png_kecil(), 'image/png')})
    sesudah = os.path.isfile(target)
    catat('Path traversal: foto_lama="../../robots.txt" TIDAK menghapus file di luar uploads/', sebelum and sesudah,
          f'robots.txt ada sebelum={sebelum}, sesudah={sesudah}')
    nf2 = sql(f"SELECT foto FROM galeri WHERE id_foto={idf}")
    adm.post(BASE + 'admin/delete_foto', data={'id_foto': idf, 'foto': nf2})
    for n in (nf, nf2):
        p = os.path.join(ROOT, 'uploads/galeri', n)
        if os.path.isfile(p):
            os.remove(p)

with open(OUT, 'w') as fh:
    json.dump(hasil, fh, indent=1, ensure_ascii=False)
print(f"\nRINGKASAN: {sum(h['lulus'] for h in hasil)}/{len(hasil)} lulus")
