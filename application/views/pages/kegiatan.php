<?php
defined('BASEPATH') or exit('No direct script access allowed');
$pertama = !empty($video) ? $video[0] : NULL;
$jumlah  = count($video);
?>
<section class="kepala-hal">
    <div class="wadah">
        <p class="remah"><a href="<?= base_url(); ?>">Beranda</a> &rsaquo; Kegiatan</p>
        <h1>Kegiatan Yayasan</h1>
        <p>
            Rekaman acara, kunjungan, dan kegiatan di lingkungan yayasan.
            <?php if ($jumlah): ?><?= $jumlah; ?> video tersedia.<?php endif; ?>
        </p>
    </div>
</section>

<section class="blok blok--putih">
    <div class="wadah">
        <?php if (empty($video)): ?>
            <div class="hampa">
                <?= ikon('main', 44); ?>
                <h3>Belum ada video kegiatan</h3>
                <p>Video akan muncul di sini begitu admin menambahkannya lewat panel.</p>
                <?php if (!empty($pengaturan['youtube'])): ?>
                    <p style="margin-top:20px">
                        <a class="tbl tbl--garis tbl--kecil" href="<?= html_escape($pengaturan['youtube']); ?>"
                           target="_blank" rel="noopener">Kunjungi YouTube yayasan</a>
                    </p>
                <?php endif; ?>
            </div>

        <?php else: ?>
            <!-- Pemutar di kiri, daftar putar di kanan. Pengunjung bisa melihat
                 video apa saja yang tersedia tanpa menggulir ke bawah dulu. -->
            <div class="tonton" id="layarVideo">
                <div class="tonton__utama">
                    <div class="layar">
                        <iframe id="bingkaiVideo"
                                src="https://www.youtube-nocookie.com/embed/<?= html_escape($pertama['youtube_id']); ?>?rel=0"
                                title="Pemutar video kegiatan"
                                allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture"
                                allowfullscreen loading="lazy"></iframe>
                    </div>

                    <div class="tonton__meta">
                        <span class="kicir kicir--gelap" style="margin:0">Sedang diputar</span>
                        <?php if (!empty($pertama['tanggal'])): ?>
                            <span style="font-size:.88rem;color:var(--teks-redup)"><?= tanggal_id($pertama['tanggal']); ?></span>
                        <?php endif; ?>
                    </div>

                    <h2 id="judulVideo" style="font-size:1.5rem;margin-bottom:.35em"><?= html_escape($pertama['judul']); ?></h2>
                    <p id="deskripsiVideo" style="color:var(--teks-redup);max-width:none"><?= html_escape($pertama['deskripsi']); ?></p>
                </div>

                <?php if ($jumlah > 1): ?>
                <aside class="antrean">
                    <div class="antrean__kepala">
                        <strong>Daftar video</strong>
                        <span class="antrean__jumlah"><?= $jumlah; ?> video</span>
                    </div>
                    <div class="antrean__isi">
                        <?php foreach ($video as $i => $v): ?>
                            <button type="button" class="antre tayang"
                                    data-yt="<?= html_escape($v['youtube_id']); ?>"
                                    data-judul="<?= html_escape($v['judul']); ?>"
                                    data-deskripsi="<?= html_escape($v['deskripsi']); ?>"
                                    aria-current="<?= $i === 0 ? 'true' : 'false'; ?>">
                                <span class="antre__gambar">
                                    <img src="<?= html_escape($v['thumb']); ?>" alt="" loading="lazy" decoding="async">
                                    <span class="antre__main"><?= ikon('main', 20); ?></span>
                                </span>
                                <span class="antre__isi">
                                    <span class="antre__judul"><?= html_escape($v['judul']); ?></span>
                                    <span class="antre__no">Video <?= $i + 1; ?> dari <?= $jumlah; ?></span>
                                </span>
                            </button>
                        <?php endforeach; ?>
                    </div>
                </aside>
                <?php endif; ?>
            </div>
        <?php endif; ?>
    </div>
</section>

<?php if (!empty($galeri)): ?>
<section class="blok blok--krem">
    <div class="wadah">
        <div class="kepala-blok masuk" style="display:flex;justify-content:space-between;align-items:end;max-width:none;gap:20px;flex-wrap:wrap">
            <div>
                <span class="kicir kicir--gelap">Dokumentasi foto</span>
                <h2>Galeri kegiatan</h2>
                <span class="garis-emas"></span>
            </div>
            <a class="tbl tbl--garis tbl--kecil" href="<?= base_url('galeri'); ?>">Galeri lengkap</a>
        </div>

        <div class="galeri-bata">
            <?php foreach (array_slice($galeri, 0, 8) as $g): ?>
                <figure class="bingkai masuk" style="pointer-events:none">
                    <img src="<?= base_url('uploads/galeri/' . $g['foto']); ?>"
                         alt="<?= html_escape($g['judul']); ?>" loading="lazy" decoding="async">
                </figure>
            <?php endforeach; ?>
        </div>
    </div>
</section>
<?php endif; ?>
