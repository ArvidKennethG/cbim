<?php defined('BASEPATH') or exit('No direct script access allowed'); ?>
<section class="kepala-hal">
    <div class="wadah sempit">
        <p class="remah"><a href="<?= base_url(); ?>">Beranda</a> &rsaquo; <a href="<?= base_url('berita'); ?>">Berita</a> &rsaquo; <?= html_escape(label_kategori($berita['kategori'])); ?></p>
        <h1 style="font-size:clamp(1.7rem,3.6vw,2.6rem)"><?= html_escape($berita['judul']); ?></h1>
        <p style="font-size:.94rem">
            <?= tanggal_id($berita['tanggal_post']); ?>
            <?php if (!empty($berita['penulis'])): ?> &middot; <?= html_escape($berita['penulis']); ?><?php endif; ?>
        </p>
    </div>
</section>

<section class="blok blok--putih">
    <div class="wadah sempit">
        <?php if (!empty($berita['gambar'])): ?>
            <img src="<?= base_url('uploads/berita/' . $berita['gambar']); ?>"
                 alt="<?= html_escape($berita['judul']); ?>"
                 style="width:100%;border-radius:var(--r-besar);border:1px solid var(--garis);margin-bottom:36px"
                 fetchpriority="high" decoding="async">
        <?php endif; ?>

        <div class="isi">
            <?php
            // Isi ditulis admin lewat panel. bersihkan_html() membuang blok
            // script, style, dan iframe beserta isinya, atribut on*, serta URL
            // berskema javascript: -- lihat helpers/cbim_helper.php
            echo bersihkan_html($berita['isi']);
            ?>
        </div>

        <p style="margin-top:40px"><a class="tbl tbl--garis tbl--kecil" href="<?= base_url('berita'); ?>">&larr; Semua berita</a></p>
    </div>
</section>

<?php if (!empty($lain)): ?>
<section class="blok blok--krem">
    <div class="wadah">
        <div class="kepala-blok masuk"><h2>Berita lainnya</h2><span class="garis-emas"></span></div>
        <div class="baris baris--3">
            <?php foreach ($lain as $b): ?>
                <a class="pos kat-<?= html_escape($b['kategori']); ?> masuk"
                   href="<?= base_url('berita/' . (int) $b['id'] . '/' . $b['slug']); ?>">
                    <div class="pos__gambar">
                        <?php if (!empty($b['gambar'])): ?>
                            <img src="<?= base_url('uploads/berita/' . $b['gambar']); ?>" alt="" loading="lazy" decoding="async">
                        <?php else: ?>
                            <div class="pos__polos"><?= ikon('dokumen', 34); ?></div>
                        <?php endif; ?>
                    </div>
                    <div class="pos__isi">
                        <span class="tag"><?= html_escape(label_kategori($b['kategori'])); ?></span>
                        <h3><?= html_escape($b['judul']); ?></h3>
                        <p><?= html_escape(!empty($b['ringkasan']) ? $b['ringkasan'] : potong($b['isi'], 100)); ?></p>
                        <span class="pos__kaki"><?= tanggal_id($b['tanggal_post']); ?></span>
                    </div>
                </a>
            <?php endforeach; ?>
        </div>
    </div>
</section>
<?php endif; ?>
