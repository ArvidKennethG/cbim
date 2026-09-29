<main id="konten">

<!-- ============================ HERO VIDEO ============================ -->
<section class="tk-hero" style="min-height: 50vh; padding-top: 100px;">
    <svg class="tk-awan tk-awan--1" viewBox="0 0 120 54" aria-hidden="true"><path d="M22 54c-12 0-22-8-22-19S10 16 22 16c3-9 12-16 22-16 12 0 22 8 25 19 12 1 21 9 21 19 0 9-9 16-21 16H22z"/></svg>
    <svg class="tk-awan tk-awan--2" viewBox="0 0 120 54" aria-hidden="true"><path d="M22 54c-12 0-22-8-22-19S10 16 22 16c3-9 12-16 22-16 12 0 22 8 25 19 12 1 21 9 21 19 0 9-9 16-21 16H22z"/></svg>

    <span class="tk-dekorasi tk-dekorasi--1" aria-hidden="true">🎬</span>
    <span class="tk-dekorasi tk-dekorasi--2" aria-hidden="true">⚽</span>

    <div class="tk-wadah tk-hero__teks">
        <span class="tk-label tk-label--kuning" style="margin-bottom: 12px; display:inline-block">Dokumentasi Video</span>
        <h1 style="font-size: clamp(2rem, 5vw, 3rem)">Video Kegiatan SD</h1>
        <p class="tk-hero__sub">
            Rekaman kegiatan belajar, ekstrakurikuler, lomba, dan acara siswa SD K Citra Bangsa Mandiri.
            <?php if (!empty($video)): ?><?= count($video); ?> video tersedia.<?php endif; ?>
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

<!-- ============================ PEMUTAR VIDEO ============================ -->
<section class="tk-bagian">
    <div class="tk-wadah">
        <?php if (empty($video)): ?>
            <div style="max-width: 600px; margin: 0 auto; text-align: center; background: #fff; padding: 40px; border-radius: 32px; border: 4px solid var(--kuning); box-shadow: 0 12px 24px rgba(59,51,85,.12);">
                <span style="font-size: 3rem; display: block; margin-bottom: 16px;">🎬</span>
                <h3 style="margin-bottom: 16px;">Belum Ada Video</h3>
                <p>
                    Video kegiatan SD K Citra Bangsa Mandiri akan segera ditampilkan. Sementara itu, kunjungi kanal YouTube Yayasan CBIM.
                </p>
                <div style="display: flex; gap: 12px; justify-content: center; flex-wrap: wrap; margin-top: 24px;">
                    <a href="https://www.youtube.com/@CBIMYayasan" target="_blank" rel="noopener" class="tk-tombol tk-tombol--utama" style="font-size: 0.9rem; padding: 10px 16px;">YouTube Yayasan</a>
                    <a href="<?= base_url('sd'); ?>" class="tk-tombol tk-tombol--kedua" style="font-size: 0.9rem; padding: 10px 16px;">Kembali ke Beranda</a>
                </div>
            </div>

        <?php else: ?>
            <?php $pertama = $video[0]; $jumlah = count($video); ?>

            <!-- Pemutar utama -->
            <div class="tk-naik" style="max-width: 900px; margin: 0 auto;">
                <div style="position: relative; padding-bottom: 56.25%; height: 0; border-radius: 24px; overflow: hidden; border: 4px solid #fff; box-shadow: 0 16px 40px rgba(59,51,85,.15);">
                    <iframe id="bingkaiVideo"
                            src="https://www.youtube-nocookie.com/embed/<?= html_escape($pertama['youtube_id']); ?>?rel=0"
                            title="Pemutar video kegiatan SD"
                            allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture"
                            allowfullscreen loading="lazy"
                            style="position: absolute; top: 0; left: 0; width: 100%; height: 100%; border: 0;"></iframe>
                </div>

                <div style="margin-top: 20px;">
                    <span class="tk-label tk-label--biru" style="display: inline-block; margin-bottom: 8px;">Sedang Diputar</span>
                    <h2 id="judulVideo" style="font-size: 1.5rem; margin-bottom: 8px;"><?= html_escape($pertama['judul']); ?></h2>
                    <p id="deskripsiVideo" style="color: var(--tinta-muda);"><?= html_escape($pertama['deskripsi']); ?></p>
                </div>
            </div>

            <!-- Daftar video lainnya -->
            <?php if ($jumlah > 1): ?>
            <div style="margin-top: 48px;">
                <div class="tk-judul-bagian tk-judul-bagian--tengah tk-naik">
                    <h2>Semua Video</h2>
                    <svg class="tk-coret" viewBox="0 0 148 12" aria-hidden="true"><path d="M3 8c22-6 44 3 66-2s52 5 76-2" stroke="#FFC53D" stroke-width="7" stroke-linecap="round" fill="none"/></svg>
                    <p><?= $jumlah; ?> video tersedia</p>
                </div>

                <div class="tk-grid-3">
                    <?php $delay = 1; foreach ($video as $i => $v): ?>
                        <button type="button" class="tk-kartu tk-muncul tk-tunda-<?= $delay ?>" onclick="putarVideo('<?= html_escape($v['youtube_id']); ?>', '<?= html_escape(addslashes($v['judul'])); ?>', '<?= html_escape(addslashes($v['deskripsi'])); ?>')"
                                style="cursor: pointer; border: none; text-align: left; width: 100%;"
                                data-yt="<?= html_escape($v['youtube_id']); ?>"
                                aria-label="Putar video: <?= html_escape($v['judul']); ?>">
                            <div style="height: 180px; margin: -32px -32px 20px; overflow: hidden; border-radius: 32px 32px 0 0; position: relative;">
                                <img src="<?= html_escape($v['thumb']); ?>" alt="" style="width: 100%; height: 100%; object-fit: cover;" loading="lazy" decoding="async">
                                <div style="position: absolute; inset: 0; display: flex; align-items: center; justify-content: center; background: rgba(0,0,0,.3);">
                                    <span style="width: 50px; height: 50px; border-radius: 50%; background: var(--biru); display: flex; align-items: center; justify-content: center;">
                                        <svg width="22" height="22" viewBox="0 0 24 24" fill="#fff" aria-hidden="true"><polygon points="5 3 19 12 5 21 5 3"/></svg>
                                    </span>
                                </div>
                            </div>
                            <h3 style="font-size: 1.1rem; line-height: 1.3; margin-bottom: 4px;"><?= html_escape($v['judul']); ?></h3>
                            <small style="color: var(--tinta-muda);">Video <?= $i + 1; ?> dari <?= $jumlah; ?></small>
                        </button>
                    <?php $delay++; if ($delay > 3) $delay = 1; endforeach; ?>
                </div>
            </div>
            <?php endif; ?>
        <?php endif; ?>
    </div>
</section>

<!-- ============================ GALERI FOTO ============================ -->
<?php if (!empty($galeri)): ?>
<section class="tk-bagian" style="background: var(--kertas-tua);">
    <div class="tk-wadah">
        <div class="tk-judul-bagian tk-judul-bagian--tengah tk-naik" style="display: flex; justify-content: space-between; align-items: end; max-width: none; gap: 20px; flex-wrap: wrap;">
            <div>
                <h2>Galeri Foto</h2>
                <svg class="tk-coret" viewBox="0 0 148 12" aria-hidden="true"><path d="M3 8c22-6 44 3 66-2s52 5 76-2" stroke="#FFC53D" stroke-width="7" stroke-linecap="round" fill="none"/></svg>
            </div>
            <a href="<?= base_url('sd/galeri'); ?>" class="tk-tombol tk-tombol--kedua" style="font-size: 0.9rem; padding: 10px 16px;">Galeri Lengkap</a>
        </div>

        <div class="tk-grid-3">
            <?php $delay = 1; foreach (array_slice($galeri, 0, 6) as $g): ?>
                <div class="tk-kartu tk-muncul tk-tunda-<?= $delay ?>" style="padding: 0; overflow: hidden;">
                    <div style="height: 200px; overflow: hidden;">
                        <img src="<?= base_url('uploads/galeri/' . $g['foto']); ?>" alt="<?= html_escape($g['judul']); ?>" style="width: 100%; height: 100%; object-fit: cover;" loading="lazy" decoding="async">
                    </div>
                    <div style="padding: 16px;">
                        <h3 style="font-size: 1rem; margin-bottom: 0;"><?= html_escape($g['judul']); ?></h3>
                    </div>
                </div>
            <?php $delay++; if ($delay > 3) $delay = 1; endforeach; ?>
        </div>
    </div>
</section>
<?php endif; ?>

<script>
function putarVideo(ytId, judul, deskripsi) {
    var iframe = document.getElementById('bingkaiVideo');
    var judulEl = document.getElementById('judulVideo');
    var deskripsiEl = document.getElementById('deskripsiVideo');
    if (iframe) iframe.src = 'https://www.youtube-nocookie.com/embed/' + ytId + '?rel=0&autoplay=1';
    if (judulEl) judulEl.textContent = judul;
    if (deskripsiEl) deskripsiEl.textContent = deskripsi;
    document.getElementById('bingkaiVideo').closest('.tk-bagian').scrollIntoView({ behavior: 'smooth', block: 'start' });
}
</script>

</main>
