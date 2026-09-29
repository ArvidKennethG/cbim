<main id="konten">

<!-- ============================ HERO DETAIL BERITA ============================ -->
<section class="tk-hero" style="min-height: 40vh; padding-top: 100px;">
    <svg class="tk-awan tk-awan--1" viewBox="0 0 120 54" aria-hidden="true"><path d="M22 54c-12 0-22-8-22-19S10 16 22 16c3-9 12-16 22-16 12 0 22 8 25 19 12 1 21 9 21 19 0 9-9 16-21 16H22z"/></svg>
    <svg class="tk-awan tk-awan--2" viewBox="0 0 120 54" aria-hidden="true"><path d="M22 54c-12 0-22-8-22-19S10 16 22 16c3-9 12-16 22-16 12 0 22 8 25 19 12 1 21 9 21 19 0 9-9 16-21 16H22z"/></svg>

    <div class="tk-wadah tk-hero__teks">
        <span class="tk-label tk-label--kuning" style="margin-bottom: 12px; display:inline-block">
            <a href="<?= base_url('sd/berita'); ?>" style="color: inherit; text-decoration: none;">Berita</a>
        </span>
        <h1 style="font-size: clamp(1.6rem, 4vw, 2.6rem)"><?= html_escape($berita['judul']); ?></h1>
        <p class="tk-hero__sub" style="font-size: 0.95rem;">
            <?= tanggal_id($berita['tanggal_post']); ?>
            <?php if (!empty($berita['penulis'])): ?> &middot; <?= html_escape($berita['penulis']); ?><?php endif; ?>
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

<!-- ============================ ISI BERITA ============================ -->
<section class="tk-bagian">
    <div class="tk-wadah" style="max-width: 800px;">
        <?php if (!empty($berita['gambar'])): ?>
            <div class="tk-naik" style="margin-bottom: 32px; border-radius: 24px; overflow: hidden; border: 4px solid #fff; box-shadow: 0 12px 24px rgba(59,51,85,.12);">
                <img src="<?= base_url('uploads/berita/' . $berita['gambar']); ?>"
                     alt="<?= html_escape($berita['judul']); ?>"
                     style="width: 100%; display: block;"
                     fetchpriority="high" decoding="async">
            </div>
        <?php endif; ?>

        <article class="tk-kartu tk-naik" style="padding: 32px;">
            <div style="font-size: 1.05rem; line-height: 1.8; color: var(--tinta);">
                <?= bersihkan_html($berita['isi']); ?>
            </div>
        </article>

        <div style="margin-top: 32px; text-align: center;">
            <a href="<?= base_url('sd/berita'); ?>" class="tk-tombol tk-tombol--kedua">&larr; Semua Berita SD</a>
        </div>
    </div>
</section>

<!-- ============================ BERITA LAINNYA ============================ -->
<?php if (!empty($lain)): ?>
<section class="tk-bagian" style="background: var(--kertas-tua);">
    <div class="tk-wadah">
        <div class="tk-judul-bagian tk-judul-bagian--tengah tk-naik">
            <h2>Berita Lainnya</h2>
            <svg class="tk-coret" viewBox="0 0 148 12" aria-hidden="true"><path d="M3 8c22-6 44 3 66-2s52 5 76-2" stroke="#FFC53D" stroke-width="7" stroke-linecap="round" fill="none"/></svg>
        </div>

        <div class="tk-grid-3">
            <?php $delay = 1; foreach ($lain as $b): ?>
                <a href="<?= base_url('sd/berita/' . (int) $b['id'] . '/' . $b['slug']); ?>" class="tk-kartu tk-muncul tk-tunda-<?= $delay ?>" style="text-decoration: none; color: inherit; display: block;">
                    <div style="height: 180px; margin: -32px -32px 20px; overflow: hidden; border-radius: 32px 32px 0 0;">
                        <?php if (!empty($b['gambar'])): ?>
                            <img src="<?= base_url('uploads/berita/' . $b['gambar']); ?>" alt="" style="width: 100%; height: 100%; object-fit: cover;" loading="lazy" decoding="async">
                        <?php else: ?>
                            <div style="width: 100%; height: 100%; background: linear-gradient(135deg, var(--biru), var(--hijau)); display: flex; align-items: center; justify-content: center;">
                                <span style="font-size: 2.5rem;">📰</span>
                            </div>
                        <?php endif; ?>
                    </div>
                    <small style="color: var(--biru); font-weight: 700; display: block; margin-bottom: 4px;"><?= tanggal_id($b['tanggal_post']); ?></small>
                    <h3 style="font-size: 1.1rem; line-height: 1.3; margin-bottom: 8px;"><?= html_escape($b['judul']); ?></h3>
                    <p style="font-size: 0.9rem; color: var(--tinta-muda); margin-bottom: 0;">
                        <?= html_escape(!empty($b['ringkasan']) ? $b['ringkasan'] : potong($b['isi'], 100)); ?>
                    </p>
                </a>
            <?php $delay++; endforeach; ?>
        </div>
    </div>
</section>
<?php endif; ?>

</main>
