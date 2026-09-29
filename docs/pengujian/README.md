# Skrip Pengujian

Skrip yang dipakai untuk menguji website ini (hasilnya ada di Bagian 14 dokumentasi teknis).
Jalankan hanya terhadap salinan **lokal** — jangan terhadap situs produksi.

## Persiapan

1. Pasang situs secara lokal mengikuti `README.md` di akar repositori (dump + dua migrasi).
2. Buat tiga akun uji dengan password `Uji#12345`:
   ```bash
   H=$(php -r 'echo password_hash("Uji#12345", PASSWORD_DEFAULT);')
   mysql -u root NAMA_DB -e "INSERT INTO auth (username,password,role) VALUES
     ('uji_admin','$H','administrator'),('uji_tk','$H','admin_tk'),('uji_sd','$H','admin_sd');"
   ```
3. Jalankan server bawaan PHP dengan router yang meniru `.htaccess`:
   ```bash
   php -S 127.0.0.1:8080 -t /path/ke/cbim docs/pengujian/router.php
   ```
4. Python 3 dengan paket `requests` dan `beautifulsoup4`; `uji_form.py` dan `uji_keamanan.py`
   memeriksa hasil lewat perintah `mariadb -uroot` (atau `mysql`).

## Menjalankan

```bash
# Crawler halaman & aset, per peran: publik | admin | admin_tk | admin_sd
python3 crawl.py http://127.0.0.1:8080 hasil_publik.json publik

# 31 skenario formulir & aksi admin (menulis data uji ke database)
python3 uji_form.py http://127.0.0.1:8080 NAMA_DB hasil_form.json

# 8 skenario keamanan (PERHATIAN: pada kode lama, uji path traversal
# benar-benar menghapus robots.txt di folder situs)
python3 uji_keamanan.py http://127.0.0.1:8080 NAMA_DB /path/ke/cbim hasil_keamanan.json
```
