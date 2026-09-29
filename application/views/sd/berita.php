<main id="konten">

<!-- ============================ HERO BERITA ============================ -->
<section class="tk-hero" style="min-height: 50vh; padding-top: 100px;">
    <svg class="tk-awan tk-awan--1" viewBox="0 0 120 54" aria-hidden="true"><path d="M22 54c-12 0-22-8-22-19S10 16 22 16c3-9 12-16 22-16 12 0 22 8 25 19 12 1 21 9 21 19 0 9-9 16-21 16H22z"/></svg>
    <svg class="tk-awan tk-awan--2" viewBox="0 0 120 54" aria-hidden="true"><path d="M22 54c-12 0-22-8-22-19S10 16 22 16c3-9 12-16 22-16 12 0 22 8 25 19 12 1 21 9 21 19 0 9-9 16-21 16H22z"/></svg>

    <span class="tk-dekorasi tk-dekorasi--1" aria-hidden="true">📰</span>
    <span class="tk-dekorasi tk-dekorasi--2" aria-hidden="true">🏫</span>

    <div class="tk-wadah tk-hero__teks">
        <span class="tk-label tk-label--kuning" style="margin-bottom: 12px; display:inline-block">Warta & Kabar</span>
        <h1 style="font-size: clamp(2rem, 5vw, 3rem)">Berita SD Citra Bangsa</h1>
        <p class="tk-hero__sub">
            Kabar kegiatan, prestasi akademik & non-akademik, dan pengumuman dari SD Kristen Citra Bangsa Mandiri Kupang.
        </p>
    </div>

    <svg class="tk-bukit" viewBox="0 0 1200 210" preserveAspectRatio="none" aria-hidden="true">
        <path d="M0 118c150-34 260 14 400 8s210-46 360-38 190 46 290 40 150-22 150-22v104H0z" fill="#8FD3A3"/>
        <g fill="#57B979">
            <circle cx="150" cy="150" r="30"/><rect x="145" y="150" width="10" height="34"/>
            <circle cx="1010" cy="158" r="24"/><rect x="1006" y="158" width="8" height="28"/>
        </g>
        <path d="M0 158c170-24 300 18 470 12s250-32 400-24 180 30 330 24v40H0z" fill="#57B979"/>
    </svg>
</section>

<!-- ============================ DAFTAR BERITA ============================ -->
<section class="tk-bagian">
    <div class="tk-wadah">
        <?php if (empty($berita)): ?>
            <div style="max-width: 600px; margin: 0 auto; text-align: center; background: #fff; padding: 40px; border-radius: 32px; border: 4px solid var(--kuning); box-shadow: 0 12px 24px rgba(59,51,85,.12);">
                <span style="font-size: 3rem; display: block; margin-bottom: 16px;">📰</span>
                <h3 style="margin-bottom: 16px;">Belum Ada Berita</h3>
                <p>
                    Berita dan informasi kegiatan SD K Citra Bangsa Mandiri akan segera ditampilkan di halaman ini.
                </p>
                <a href="<?= base_url('sd'); ?>" class="tk-tombol tk-tombol--utama" style="margin-top: 16px;">Kembali ke Beranda</a>
            </div>
        <?php else: ?>
            <div class="tk-grid-3">
                <?php $delay = 1; foreach ($berita as $b): ?>
                    <a href="<?= base_url('sd/berita/' . (int) $b['id'] . '/' . $b['slug']); ?>" class="tk-kartu tk-muncul tk-tunda-<?= $delay ?>" style="text-decoration: none; color: inherit; display: block;">
                        <div style="height: 200px; margin: -32px -32px 24px; overflow: hidden; border-radius: 32px 32px 0 0;">
                            <?php if (!empty($b['gambar'])): ?>
                                <img src="<?= base_url('uploads/berita/' . $b['gambar']); ?>" alt="" style="width: 100%; height: 100%; object-fit: cover;" loading="lazy" decoding="async">
                            <?php else: ?>
                                <div style="width: 100%; height: 100%; background: linear-gradient(135deg, var(--biru), var(--hijau)); display: flex; align-items: center; justify-content: center;">
                                    <span style="font-size: 3rem;">📰</span>
                                </div>
                            <?php endif; ?>
                        </div>
                        <small style="color: var(--biru); font-weight: 700; display: block; margin-bottom: 4px;">
                            <?= tanggal_id($b['tanggal_post']); ?>
                        </small>
                        <h3 style="font-size: 1.15rem; line-height: 1.3; margin-bottom: 8px;"><?= html_escape($b['judul']); ?></h3>
                        <p style="font-size: 0.92rem; color: var(--tinta-muda); margin-bottom: 0;">
                            <?= html_escape(!empty($b['ringkasan']) ? $b['ringkasan'] : potong($b['isi'], 120)); ?>
                        </p>
                    </a>
                <?php $delay++; if ($delay > 3) $delay = 1; endforeach; ?>
            </div>

            <?php if ($total_hal > 1): ?>
                <div style="display: flex; justify-content: center; gap: 8px; margin-top: 40px; flex-wrap: wrap;">
                    <?php if ($hal > 1): ?>
                        <a href="<?= base_url('sd/berita') . '?hal=' . ($hal - 1); ?>" class="tk-tombol tk-tombol--kedua" style="font-size: 0.9rem; padding: 8px 16px;">&larr; Sebelumnya</a>
                    <?php endif; ?>
                    <?php for ($i = 1; $i <= $total_hal; $i++): ?>
                        <?php if ($i === $hal): ?>
                            <span class="tk-tombol tk-tombol--utama" style="font-size: 0.9rem; padding: 8px 16px; cursor: default;"><?= $i; ?></span>
                        <?php else: ?>
                            <a href="<?= base_url('sd/berita') . '?hal=' . $i; ?>" class="tk-tombol tk-tombol--kedua" style="font-size: 0.9rem; padding: 8px 16px;"><?= $i; ?></a>
                        <?php endif; ?>
                    <?php endfor; ?>
                    <?php if ($hal < $total_hal): ?>
                        <a href="<?= base_url('sd/berita') . '?hal=' . ($hal + 1); ?>" class="tk-tombol tk-tombol--kedua" style="font-size: 0.9rem; padding: 8px 16px;">Berikutnya &rarr;</a>
                    <?php endif; ?>
                </div>
            <?php endif; ?>
        <?php endif; ?>
    </div>
</section>

</main>
