<main id="konten">

<!-- ============================ HERO KEGIATAN ============================ -->
<section class="tk-hero" style="min-height: 50vh; padding-top: 100px;">
    <svg class="tk-awan tk-awan--1" viewBox="0 0 120 54" aria-hidden="true"><path d="M22 54c-12 0-22-8-22-19S10 16 22 16c3-9 12-16 22-16 12 0 22 8 25 19 12 1 21 9 21 19 0 9-9 16-21 16H22z"/></svg>
    <svg class="tk-awan tk-awan--2" viewBox="0 0 120 54" aria-hidden="true"><path d="M22 54c-12 0-22-8-22-19S10 16 22 16c3-9 12-16 22-16 12 0 22 8 25 19 12 1 21 9 21 19 0 9-9 16-21 16H22z"/></svg>

    <!-- Floating Decorations -->
    <span class="tk-dekorasi tk-dekorasi--1" aria-hidden="true">🏆</span>
    <span class="tk-dekorasi tk-dekorasi--2" aria-hidden="true">⚽</span>

    <div class="tk-wadah tk-hero__teks">
        <span class="tk-label tk-label--kuning" style="margin-bottom: 12px; display:inline-block">Prestasi & Momentum</span>
        <h1 style="font-size: clamp(2rem, 5vw, 3rem)">Kegiatan & Prestasi Siswa SD</h1>
        <p class="tk-hero__sub">
            Dokumentasi ragam aktivitas belajar seru, pembinaan kepemimpinan, perlombaan akademik & non-akademik, serta keceriaan siswa SD K Citra Bangsa Mandiri.
        </p>
    </div>

    <!-- bukit -->
    <svg class="tk-bukit" viewBox="0 0 1200 210" preserveAspectRatio="none" aria-hidden="true">
        <path d="M0 118c150-34 260 14 400 8s210-46 360-38 190 46 290 40 150-22 150-22v104H0z" fill="#8FD3A3"/>
        <g fill="#57B979">
            <circle cx="150" cy="150" r="30"/><rect x="145" y="150" width="10" height="34"/>
            <circle cx="1010" cy="158" r="24"/><rect x="1006" y="158" width="8" height="28"/>
        </g>
        <path d="M0 158c170-24 300 18 470 12s250-32 400-24 180 30 330 24v40H0z" fill="#57B979"/>
    </svg>
</section>

<!-- ============================ AKTIVITAS BERKALA ============================ -->
<section class="tk-bagian">
    <div class="tk-wadah">
        <div class="tk-judul-bagian tk-judul-bagian--tengah tk-naik">
            <h2>Program Rutin & Momentum Tahunan</h2>
            <svg class="tk-coret" viewBox="0 0 148 12" aria-hidden="true"><path d="M3 8c22-6 44 3 66-2s52 5 76-2" stroke="#FFC53D" stroke-width="7" stroke-linecap="round" fill="none"/></svg>
            <p>Ajang pembentukan karakter mandiri, kerjasama, dan keberanian tampil di depan publik.</p>
        </div>

        <div class="tk-grid-3">
            <article class="tk-kartu tk-muncul tk-tunda-1">
                <div class="tk-kartu__ikon tk-kartu__ikon--merah">
                    <svg width="38" height="38" viewBox="0 0 24 24" fill="none" stroke="#EE5D4E" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                        <path d="M12 2v20"/><path d="M17 5H9.5a3.5 3.5 0 0 0 0 7h5a3.5 3.5 0 0 1 0 7H6"/>
                    </svg>
                </div>
                <h3>Outbound & Field Trip</h3>
                <p>Kunjungan belajar luar kelas ke museum, sentra pertanian hidroponik, dan observasi alam untuk memperluas wawasan kontekstual murid.</p>
            </article>

            <article class="tk-kartu tk-muncul tk-tunda-2">
                <div class="tk-kartu__ikon tk-kartu__ikon--kuning">
                    <svg width="38" height="38" viewBox="0 0 24 24" fill="none" stroke="#E0A81E" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                        <path d="M9 18V5l12-2v13"/><circle cx="6" cy="18" r="3"/><circle cx="18" cy="16" r="3"/>
                    </svg>
                </div>
                <h3>Pentas Seni & Budaya NTT</h3>
                <p>Pertunjukan tari tradisional khas NTT, ansambel musik daerah (sasando, suling, gitar), paduan suara, serta pameran karya seni rupa siswa.</p>
            </article>

            <article class="tk-kartu tk-muncul tk-tunda-3">
                <div class="tk-kartu__ikon tk-kartu__ikon--biru">
                    <svg width="38" height="38" viewBox="0 0 24 24" fill="none" stroke="#2E9BD6" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                        <path d="M20.84 4.61a5.5 5.5 0 0 0-7.78 0L12 5.67l-1.06-1.06a5.5 5.5 0 0 0-7.78 7.78l1.06 1.06L12 21.23l7.78-7.78 1.06-1.06a5.5 5.5 0 0 0 0-7.78z"/>
                    </svg>
                </div>
                <h3>Retret Rohani & Bakti Sosial</h3>
                <p>Penguatan iman dan rasa syukur melalui retreat kerohanian bersama pendeta serta aksi berbagi kasih kepada sesama yang membutuhkan.</p>
            </article>
        </div>
    </div>
</section>

<!-- ============================ GALERI ============================ -->
<section class="tk-bagian" style="background:var(--kertas-tua)">
    <div class="tk-wadah">
        <div class="tk-judul-bagian tk-judul-bagian--tengah tk-naik">
            <h2>Galeri Foto Sekolah</h2>
            <svg class="tk-coret" viewBox="0 0 148 12" aria-hidden="true"><path d="M3 8c22-6 44 3 66-2s52 5 76-2" stroke="#FFC53D" stroke-width="7" stroke-linecap="round" fill="none"/></svg>
            <p>Dokumentasi Visual</p>
        </div>

        <?php if (!empty($data_galeri)): ?>
            <div class="tk-grid-3">
                <?php $delay=1; foreach ($data_galeri as $galeri): ?>
                    <article class="tk-program tk-program--merah tk-muncul tk-tunda-<?= $delay ?>">
                        <div style="height:200px; margin:-32px -32px 24px; overflow:hidden; border-radius:32px 32px 0 0">
                            <img src="<?= base_url(); ?>assets/templates/media/galeri/<?= !empty($galeri['foto']) ? htmlspecialchars($galeri['foto']) : '150-2.jpg'; ?>" style="width:100%; height:100%; object-fit:cover" alt="<?= htmlspecialchars($galeri['judul_foto']); ?>">
                        </div>
                        <h3 style="font-size:1.2rem; line-height:1.3; margin-bottom:0"><?= htmlspecialchars($galeri['judul_foto']); ?></h3>
                    </article>
                <?php $delay++; endforeach; ?>
            </div>
        <?php else: ?>
            <div style="max-width: 600px; margin: 0 auto; text-align: center; background: #fff; padding: 40px; border-radius: 32px; border: 4px solid var(--kuning); box-shadow: 0 12px 24px rgba(59,51,85,.12);">
                <span style="font-size: 3rem; display: block; margin-bottom: 16px;">📷</span>
                <h3 style="margin-bottom: 16px;">Dokumentasi Sedang Kami Siapkan</h3>
                <p>
                    Foto-foto kegiatan dan prestasi siswa SD K Citra Bangsa Mandiri akan segera ditampilkan di halaman ini. Sementara itu, kegiatan terbaru sekolah dapat diikuti melalui kanal media sosial resmi Yayasan CBIM.
                </p>
                <div style="display: flex; gap: 12px; justify-content: center; flex-wrap: wrap; margin-top: 24px;">
                    <a href="https://www.instagram.com/yayasan_cbim" target="_blank" rel="noopener" class="tk-tombol tk-tombol--kedua" style="font-size:0.9rem; padding:10px 16px">Instagram Yayasan</a>
                    <a href="<?= base_url('sd/ppdb'); ?>" class="tk-tombol tk-tombol--utama" style="font-size:0.9rem; padding:10px 16px">Informasi PPDB</a>
                </div>
            </div>
        <?php endif; ?>
    </div>
</section>

<!-- ============================ BERITA LENGKAP ============================ -->
<?php if (!empty($data_berita)): ?>
<section class="tk-bagian" style="border-top: 1px dashed rgba(59,51,85,.1)">
    <div class="tk-wadah">
        <div class="tk-judul-bagian tk-naik">
            <span class="tk-label tk-label--kuning" style="margin-bottom:8px; display:inline-block">Warta & Kabar</span>
            <h2 style="margin:0">Berita Terkini Yayasan & Sekolah</h2>
        </div>

        <div class="tk-grid-2">
            <?php $delay=1; foreach ($data_berita as $berita): ?>
            <article class="tk-kartu tk-muncul tk-tunda-<?= $delay ?>" style="display: flex; gap: 16px; align-items: center; padding: 16px;">
                <div style="width: 120px; height: 120px; flex-shrink: 0; border-radius: 16px; overflow: hidden;">
                    <img src="<?= base_url(); ?>assets/templates/media/news/<?= !empty($berita['gambar']) ? htmlspecialchars($berita['gambar']) : '150-2.jpg'; ?>" style="width: 100%; height: 100%; object-fit: cover;" alt="">
                </div>
                <div>
                    <small style="color:var(--merah); font-weight:700; display:block; margin-bottom:4px"><?= date('d M Y', strtotime($berita['tanggal_post'])); ?></small>
                    <h3 style="font-size:1.1rem; line-height:1.2; margin-bottom:8px"><?= htmlspecialchars(strip_tags($berita['judul_berita'])); ?></h3>
                    <p style="font-size:0.9rem; margin-bottom:0">
                        <?= htmlspecialchars(mb_substr(trim(strip_tags($berita['isi_berita'])), 0, 80)); ?>&hellip;
                    </p>
                </div>
            </article>
            <?php $delay++; endforeach; ?>
        </div>
    </div>
</section>
<?php endif; ?>

</main>
