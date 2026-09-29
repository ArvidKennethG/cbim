<!-- ============================ HERO ============================ -->
<section class="tk-hero">
    <svg class="tk-awan tk-awan--1" viewBox="0 0 120 54" aria-hidden="true"><path d="M22 54c-12 0-22-8-22-19S10 16 22 16c3-9 12-16 22-16 12 0 22 8 25 19 12 1 21 9 21 19 0 9-9 16-21 16H22z"/></svg>
    <svg class="tk-awan tk-awan--2" viewBox="0 0 120 54" aria-hidden="true"><path d="M22 54c-12 0-22-8-22-19S10 16 22 16c3-9 12-16 22-16 12 0 22 8 25 19 12 1 21 9 21 19 0 9-9 16-21 16H22z"/></svg>

    <div class="tk-wadah tk-hero__teks">
        <h1>Penerimaan Siswa Baru</h1>
        <p class="tk-hero__sub">
            Tahun Ajaran 2026/2027 — Pendaftaran sudah dibuka. Yuk, daftarkan si kecil!
        </p>
        <div class="tk-hero__aksi">
            <a href="#formulir" class="tk-tombol tk-tombol--utama">Daftar Sekarang</a>
            <a href="<?= base_url('auth'); ?>"  class="tk-tombol tk-tombol--kedua">Login Pendaftar</a>
        </div>
    </div>

    <svg class="tk-bukit" viewBox="0 0 1200 210" preserveAspectRatio="none" aria-hidden="true">
        <path d="M0 118c150-34 260 14 400 8s210-46 360-38 190 46 290 40 150-22 150-22v104H0z" fill="#8FD3A3"/>
        <g fill="#57B979">
            <circle cx="150" cy="150" r="30"/><rect x="145" y="150" width="10" height="34"/>
            <circle cx="1010" cy="158" r="24"/><rect x="1006" y="158" width="8" height="28"/>
            <circle cx="640" cy="146" r="20"/><rect x="637" y="146" width="6" height="26"/>
        </g>
        <path d="M0 158c170-24 300 18 470 12s250-32 400-24 180 30 330 24v40H0z" fill="#57B979"/>
    </svg>
</section>

<?php
// PERBAIKAN: Tk::ppdb() sudah mengirim $success_msg / $error_msg (flashdata
// hasil Tk::submit_ppdb), tapi view ini dulu tidak menampilkannya.
?>
<?php if (!empty($success_msg) || !empty($error_msg)): ?>
<section class="tk-bagian" style="padding:28px 0 0">
    <div class="tk-wadah" style="max-width:860px">
        <?php if (!empty($success_msg)): ?>
            <div class="tk-notif tk-notif--sukses" role="status">
                <strong>Pendaftaran Berhasil!</strong>
                <p><?= $success_msg; ?></p>
            </div>
        <?php endif; ?>
        <?php if (!empty($error_msg)): ?>
            <div class="tk-notif tk-notif--galat" role="alert">
                <strong>Mohon Maaf!</strong>
                <p><?= html_escape($error_msg); ?></p>
            </div>
        <?php endif; ?>
    </div>
</section>
<?php endif; ?>

<!-- ============================ JALUR PENDAFTARAN ============================ -->
<section class="tk-bagian">
    <div class="tk-wadah">
        <div class="tk-judul-bagian tk-judul-bagian--tengah tk-naik">
            <h2>Jalur Pendaftaran</h2>
            <svg class="tk-coret" viewBox="0 0 148 12" aria-hidden="true"><path d="M3 8c22-6 44 3 66-2s52 5 76-2" stroke="#FFC53D" stroke-width="7" stroke-linecap="round" fill="none"/></svg>
            <p>Pilih gelombang pendaftaran yang sedang aktif.</p>
        </div>

        <div class="tk-grid-2">
            <article class="tk-program tk-program--hijau tk-muncul tk-tunda-1">
                <span class="tk-label tk-label--hijau">✦ Buka</span>
                <h3>Gelombang 1</h3>
                <p>Pendaftaran awal dengan potongan biaya administrasi.</p>
                <div class="tk-info-tabel">
                    <div class="tk-info-tabel__baris">
                        <span class="tk-info-tabel__label">Pendaftaran</span>
                        <span class="tk-info-tabel__nilai">1 Jan – 31 Mar 2026</span>
                    </div>
                    <div class="tk-info-tabel__baris">
                        <span class="tk-info-tabel__label">Pengumuman</span>
                        <span class="tk-info-tabel__nilai">10 Apr 2026</span>
                    </div>
                </div>
                <a href="#formulir" class="tk-tombol tk-tombol--utama" style="width:100%; justify-content:center;">Pilih Jalur Ini</a>
            </article>

            <article class="tk-program tk-program--redup tk-muncul tk-tunda-2">
                <span class="tk-label tk-label--kuning">⏳ Segera Buka</span>
                <h3>Gelombang 2</h3>
                <p>Pendaftaran reguler menjelang tahun ajaran baru.</p>
                <div class="tk-info-tabel">
                    <div class="tk-info-tabel__baris">
                        <span class="tk-info-tabel__label">Pendaftaran</span>
                        <span class="tk-info-tabel__nilai">1 Mei – 30 Jun 2026</span>
                    </div>
                    <div class="tk-info-tabel__baris">
                        <span class="tk-info-tabel__label">Pengumuman</span>
                        <span class="tk-info-tabel__nilai">10 Jul 2026</span>
                    </div>
                </div>
                <span class="tk-tombol tk-tombol--kedua" style="width:100%; justify-content:center; opacity:.5; cursor:not-allowed;">Belum Dibuka</span>
            </article>
        </div>
    </div>
</section>

<svg class="tk-gunting" viewBox="0 0 1200 34" preserveAspectRatio="none" aria-hidden="true" style="color:#fff">
    <path d="M0 20q25-18 50 0t50 0 50 0 50 0 50 0 50 0 50 0 50 0 50 0 50 0 50 0 50 0 50 0 50 0 50 0 50 0 50 0 50 0 50 0 50 0 50 0 50 0 50 0 50 0V34H0z" fill="currentColor"/>
</svg>

<!-- ============================ ALUR PENDAFTARAN ============================ -->
<section class="tk-bagian tk-bagian--putih">
    <div class="tk-wadah">
        <div class="tk-judul-bagian tk-judul-bagian--tengah tk-naik">
            <h2>Alur Pendaftaran</h2>
            <svg class="tk-coret" viewBox="0 0 148 12" aria-hidden="true"><path d="M3 8c22-6 44 3 66-2s52 5 76-2" stroke="#2E9BD6" stroke-width="7" stroke-linecap="round" fill="none"/></svg>
            <p>Langkah mudah mendaftarkan putra-putri Anda.</p>
        </div>

        <div class="tk-langkah">
            <div class="tk-langkah__item tk-naik tk-tunda-1">
                <div class="tk-langkah__nomor tk-langkah__nomor--biru">1</div>
                <h3>Buat Akun</h3>
                <p>Mendaftar menggunakan email dan nomor telepon yang aktif.</p>
            </div>
            <div class="tk-langkah__item tk-naik tk-tunda-2">
                <div class="tk-langkah__nomor tk-langkah__nomor--biru">2</div>
                <h3>Isi Formulir</h3>
                <p>Melengkapi biodata anak dan orang tua pada sistem.</p>
            </div>
            <div class="tk-langkah__item tk-naik tk-tunda-3">
                <div class="tk-langkah__nomor tk-langkah__nomor--biru">3</div>
                <h3>Unggah Berkas</h3>
                <p>Mengunggah dokumen persyaratan dalam format gambar atau PDF.</p>
            </div>
            <div class="tk-langkah__item tk-naik tk-tunda-4">
                <div class="tk-langkah__nomor tk-langkah__nomor--hijau">4</div>
                <h3>Daftar Ulang</h3>
                <p>Melihat hasil pengumuman dan menyelesaikan biaya administrasi.</p>
            </div>
        </div>
    </div>
</section>

<svg class="tk-gunting" viewBox="0 0 1200 34" preserveAspectRatio="none" aria-hidden="true" style="color:var(--kertas-tua)">
    <path d="M0 20q25-18 50 0t50 0 50 0 50 0 50 0 50 0 50 0 50 0 50 0 50 0 50 0 50 0 50 0 50 0 50 0 50 0 50 0 50 0 50 0 50 0 50 0 50 0 50 0 50 0V34H0z" fill="currentColor"/>
</svg>

<!-- ============================ PERSYARATAN ============================ -->
<section class="tk-bagian tk-bagian--kertas-tua">
    <div class="tk-wadah" style="max-width:750px">
        <div class="tk-judul-bagian tk-judul-bagian--tengah tk-naik">
            <h2>Persyaratan Dokumen</h2>
            <svg class="tk-coret" viewBox="0 0 148 12" aria-hidden="true"><path d="M3 8c22-6 44 3 66-2s52 5 76-2" stroke="#57B979" stroke-width="7" stroke-linecap="round" fill="none"/></svg>
        </div>

        <div class="tk-tempel tk-tempel--lurus tk-muncul">
            <ul class="tk-syarat">
                <li>
                    <span class="tk-syarat__cek">
                        <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="#57B979" stroke-width="3" stroke-linecap="round" stroke-linejoin="round"><path d="m5 12 5 5L19 7"/></svg>
                    </span>
                    Pas foto berwarna anak ukuran 3×4 (2 lembar)
                </li>
                <li>
                    <span class="tk-syarat__cek">
                        <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="#57B979" stroke-width="3" stroke-linecap="round" stroke-linejoin="round"><path d="m5 12 5 5L19 7"/></svg>
                    </span>
                    Fotokopi Akte Kelahiran anak (1 lembar)
                </li>
                <li>
                    <span class="tk-syarat__cek">
                        <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="#57B979" stroke-width="3" stroke-linecap="round" stroke-linejoin="round"><path d="m5 12 5 5L19 7"/></svg>
                    </span>
                    Fotokopi Kartu Keluarga terbaru (1 lembar)
                </li>
                <li>
                    <span class="tk-syarat__cek">
                        <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="#57B979" stroke-width="3" stroke-linecap="round" stroke-linejoin="round"><path d="m5 12 5 5L19 7"/></svg>
                    </span>
                    Usia minimal 4 tahun untuk kelompok A dan 5 tahun untuk kelompok B per bulan Juli
                </li>
            </ul>
        </div>
    </div>
</section>

<!-- ============================ FORMULIR ============================ -->
<?php
// PERBAIKAN: halaman ini dulu tidak punya formulir sama sekali -- semua tombol
// "Daftar Sekarang" menuju formulir.php yang tidak ada (404), padahal
// Tk::submit_ppdb() sudah lengkap (validasi, honeypot, rate limit, simpan ke
// tabel pendaftaran + pendaftaran_tk). Nama field di bawah mengikuti aturan
// validasi di controller; tampilan memakai gaya .tk-formulir dari mock-up
// desain TK sebelumnya.
?>
<style>
    .tk-formulir { background:#fff; border-radius:var(--radius-l); padding:clamp(28px,5vw,50px); box-shadow:0 10px 0 rgba(59,51,85,.07); max-width:860px; margin-inline:auto; }
    .tk-formulir__judul { font-family:var(--font-judul); font-weight:700; font-size:1.2rem; color:var(--tinta); padding-bottom:12px; margin-bottom:24px; border-bottom:3px dashed rgba(59,51,85,.08); display:flex; align-items:center; gap:10px; }
    .tk-formulir__judul svg { flex-shrink:0; }
    .tk-formulir__grid { display:grid; grid-template-columns:repeat(auto-fit,minmax(260px,1fr)); gap:20px; margin-bottom:36px; }
    .tk-formulir__grid--lebar { grid-template-columns:1fr; }
    .tk-kolom label { display:block; font-family:var(--font-judul); font-weight:600; font-size:.92rem; color:var(--tinta-muda); margin-bottom:7px; }
    .tk-kolom label .wajib { color:var(--merah); }
    .tk-kolom input[type="text"], .tk-kolom input[type="date"], .tk-kolom input[type="tel"], .tk-kolom select, .tk-kolom textarea {
        width:100%; padding:12px 16px; font-family:var(--font-isi); font-size:1rem; color:var(--tinta); background:var(--kertas);
        border:2.5px solid rgba(59,51,85,.10); border-radius:var(--radius-m); transition:border-color .15s ease, box-shadow .15s ease; }
    .tk-kolom input:focus, .tk-kolom select:focus, .tk-kolom textarea:focus { outline:none; border-color:var(--biru); box-shadow:0 0 0 4px rgba(46,155,214,.15); }
    .tk-kolom input::placeholder, .tk-kolom textarea::placeholder { color:rgba(59,51,85,.35); }
    .tk-kolom textarea { resize:vertical; min-height:90px; }
    .tk-kolom select { cursor:pointer; }
    .tk-persetujuan { background:var(--kertas-tua); border:1px solid rgba(59,51,85,.1); padding:16px; border-radius:var(--radius-m); display:flex; gap:12px; align-items:flex-start; margin-bottom:28px; }
    .tk-persetujuan input { margin-top:6px; transform:scale(1.2); flex-shrink:0; }
    .tk-persetujuan label { font-size:.92rem; cursor:pointer; }
    .tk-formulir__aksi { display:flex; flex-wrap:wrap; justify-content:flex-end; gap:14px; padding-top:28px; border-top:3px dashed rgba(59,51,85,.08); }
    .tk-notif { border-radius:16px; padding:16px 20px; margin-bottom:12px; }
    .tk-notif p { margin:6px 0 0; font-size:.95rem; }
    .tk-notif--sukses { background:#eafaf1; border:1px solid #57B979; color:#2d6b43; }
    .tk-notif--galat { background:#fcecec; border:1px solid #EE5D4E; color:#a12f25; }
    .tk-hp { position:absolute; left:-9999px; width:1px; height:1px; overflow:hidden; }
    @media (max-width:640px) { .tk-formulir__aksi .tk-tombol { width:100%; justify-content:center; } }
</style>

<section class="tk-bagian" id="formulir">
    <div class="tk-wadah">
        <div class="tk-judul-bagian tk-judul-bagian--tengah tk-naik">
            <h2>Formulir Pendaftaran</h2>
            <svg class="tk-coret" viewBox="0 0 148 12" aria-hidden="true"><path d="M3 8c22-6 44 3 66-2s52 5 76-2" stroke="#EE5D4E" stroke-width="7" stroke-linecap="round" fill="none"/></svg>
            <p>Isi data di bawah ini. Panitia PPDB akan menghubungi Ayah/Bunda lewat WhatsApp untuk langkah berikutnya.</p>
        </div>

        <form action="<?= base_url('tk/submit_ppdb'); ?>" method="POST" class="tk-formulir">

            <div class="tk-formulir__judul">
                <svg width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="var(--biru)" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true"><circle cx="12" cy="8" r="4"/><path d="M4 20c0-4 4-7 8-7s8 3 8 7"/></svg>
                Data Calon Siswa
            </div>
            <div class="tk-formulir__grid">
                <div class="tk-kolom">
                    <label for="tk-nama">Nama Lengkap Ananda <span class="wajib">*</span></label>
                    <input type="text" id="tk-nama" name="nama_lengkap" placeholder="Sesuai akta kelahiran" required minlength="3" maxlength="200">
                </div>
                <div class="tk-kolom">
                    <label for="tk-tgl">Tanggal Lahir <span class="wajib">*</span></label>
                    <input type="date" id="tk-tgl" name="tgl_lahir" required>
                </div>
                <div class="tk-kolom">
                    <label for="tk-jk">Jenis Kelamin <span class="wajib">*</span></label>
                    <select id="tk-jk" name="jenis_kelamin" required>
                        <option value="">Pilih jenis kelamin</option>
                        <option value="Laki-laki">Laki-laki</option>
                        <option value="Perempuan">Perempuan</option>
                    </select>
                </div>
                <div class="tk-kolom">
                    <label for="tk-kelompok">Pilihan Kelompok</label>
                    <select id="tk-kelompok" name="kelompok">
                        <option value="">Pilih kelompok</option>
                        <option value="Kelompok A (usia 4-5 tahun)">Kelompok A (usia 4–5 tahun)</option>
                        <option value="Kelompok B (usia 5-6 tahun)">Kelompok B (usia 5–6 tahun)</option>
                    </select>
                </div>
            </div>

            <div class="tk-formulir__judul">
                <svg width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="var(--kuning)" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true"><path d="M17.5 12.5c1.4-1.2 3.5-.4 3.5 1.3 0 1.6-2 3-3.5 4.2-1.5-1.2-3.5-2.6-3.5-4.2 0-1.7 2.1-2.5 3.5-1.3z"/><circle cx="9" cy="8" r="3.2"/><path d="M3 20c0-3.3 2.7-6 6-6s6 2.7 6 6"/></svg>
                Data Orang Tua / Wali
            </div>
            <div class="tk-formulir__grid">
                <div class="tk-kolom">
                    <label for="tk-ortu">Nama Orang Tua / Wali <span class="wajib">*</span></label>
                    <input type="text" id="tk-ortu" name="nama_ortu" required minlength="3" maxlength="200">
                </div>
                <div class="tk-kolom">
                    <label for="tk-hp">No. WhatsApp / HP <span class="wajib">*</span></label>
                    <input type="tel" id="tk-hp" name="no_hp" placeholder="081234567890" required minlength="8" maxlength="25">
                </div>
            </div>
            <div class="tk-formulir__grid tk-formulir__grid--lebar">
                <div class="tk-kolom">
                    <label for="tk-alamat">Alamat Lengkap <span class="wajib">*</span></label>
                    <textarea id="tk-alamat" name="alamat" rows="3" required minlength="10"></textarea>
                </div>
            </div>

            <div class="tk-hp" aria-hidden="true">
                <label for="tk-cek">Jangan isi kolom ini</label>
                <input type="text" id="tk-cek" name="cbim_hp_check" tabindex="-1" autocomplete="off">
            </div>

            <div class="tk-persetujuan">
                <input type="checkbox" name="persetujuan_ortu" id="tk-setuju" value="1" required>
                <label for="tk-setuju">
                    Saya orang tua/wali ananda dan menyetujui data di atas diproses oleh TK K Citra Bangsa Mandiri
                    untuk keperluan PPDB, sesuai <a href="<?= base_url('kebijakan-privasi'); ?>" target="_blank" style="font-weight:bold">Kebijakan Privasi</a>.
                    <span style="color:var(--merah)">*</span>
                </label>
            </div>

            <div class="tk-formulir__aksi">
                <button type="submit" class="tk-tombol tk-tombol--utama">Kirim Pendaftaran</button>
            </div>
        </form>
    </div>
</section>

<!-- ============================ AJAKAN ============================ -->
<section style="background:var(--kertas-tua); padding-bottom:0">
    <div class="tk-wadah">
        <div class="tk-ajakan tk-zoom">
            <h2>Siap mendaftarkan si kecil?</h2>
            <p>Isi formulir dalam beberapa menit, atau hubungi kami dulu kalau masih ada yang ingin ditanyakan.</p>
            <a href="#formulir" class="tk-tombol tk-tombol--utama">Daftar sekarang</a>
        </div>
    </div>
</section>

