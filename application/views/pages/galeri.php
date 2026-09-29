<?php defined('BASEPATH') or exit('No direct script access allowed'); ?>
<section class="kepala-hal">
    <div class="wadah">
        <p class="remah"><a href="<?= base_url(); ?>">Beranda</a> &rsaquo; Galeri</p>
        <h1>Galeri Foto</h1>
        <p>
            Dokumentasi kegiatan di lingkungan yayasan.
            <?php if (!empty($galeri)): ?>
                <?= count($galeri); ?> foto tersimpan. Klik salah satu untuk memperbesar.
            <?php endif; ?>
        </p>
    </div>
</section>

<section class="blok blok--putih">
    <div class="wadah">
        <?php if (empty($galeri)): ?>
            <div class="hampa">
                <?= ikon('gambar', 44); ?>
                <h3>Belum ada foto</h3>
                <p>Dokumentasi akan muncul di sini begitu admin mengunggahnya lewat panel.</p>
            </div>
        <?php else: ?>
            <!-- Tata letak batu bata: tiap foto mempertahankan bentuk aslinya,
                 jadi foto potret tidak terpotong kepalanya. -->
            <div class="galeri-bata">
                <?php foreach ($galeri as $i => $g): ?>
                    <button type="button" class="bingkai masuk"
                            data-indeks="<?= $i; ?>"
                            data-penuh="<?= base_url('uploads/galeri/' . $g['foto']); ?>"
                            data-judul="<?= html_escape($g['judul']); ?>"
                            data-keterangan="<?= html_escape($g['keterangan']); ?>"
                            aria-label="Perbesar foto: <?= html_escape($g['judul']); ?>">
                        <img src="<?= base_url('uploads/galeri/' . $g['foto']); ?>"
                             alt="<?= html_escape($g['judul']); ?>" loading="lazy" decoding="async">
                        <span class="bingkai__kaca" aria-hidden="true"><?= ikon('gambar', 17); ?></span>
                        <span class="bingkai__tirai">
                            <span class="bingkai__judul"><?= html_escape($g['judul']); ?></span>
                            <?php if (!empty($g['tanggal'])): ?>
                                <span class="bingkai__tanggal"><?= tanggal_id($g['tanggal']); ?></span>
                            <?php endif; ?>
                        </span>
                    </button>
                <?php endforeach; ?>
            </div>
        <?php endif; ?>
    </div>
</section>

<figure class="lightbox" id="lightbox" role="dialog" aria-modal="true" aria-label="Foto diperbesar">
    <button type="button" class="lightbox__tutup" aria-label="Tutup">&times;</button>
    <div class="lightbox__bingkai">
        <span class="lightbox__no" id="lightboxNo"></span>
        <button type="button" class="lightbox__nav lightbox__nav--mundur" id="lightboxMundur" aria-label="Foto sebelumnya">
            <svg width="22" height="22" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.9" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true"><path d="m15 18-6-6 6-6"/></svg>
        </button>
        <img src="" alt="">
        <button type="button" class="lightbox__nav lightbox__nav--maju" id="lightboxMaju" aria-label="Foto berikutnya">
            <svg width="22" height="22" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.9" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true"><path d="m9 18 6-6-6-6"/></svg>
        </button>
    </div>
    <figcaption></figcaption>
</figure>
