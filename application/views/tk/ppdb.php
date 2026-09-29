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
            <a href="formulir.php" class="tk-tombol tk-tombol--utama">Daftar Sekarang</a>
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
                <a href="formulir.php" class="tk-tombol tk-tombol--utama" style="width:100%; justify-content:center;">Pilih Jalur Ini</a>
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

<!-- ============================ AJAKAN ============================ -->
<section style="background:var(--kertas-tua); padding-bottom:0">
    <div class="tk-wadah">
        <div class="tk-ajakan tk-zoom">
            <h2>Siap mendaftarkan si kecil?</h2>
            <p>Isi formulir dalam beberapa menit, atau hubungi kami dulu kalau masih ada yang ingin ditanyakan.</p>
            <a href="formulir.php" class="tk-tombol tk-tombol--utama">Daftar sekarang</a>
        </div>
    </div>
</section>

