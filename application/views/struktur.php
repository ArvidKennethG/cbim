<?php
defined('BASEPATH') or exit('No direct script access allowed');
$keterangan = [
    'Dewan Pembina'  => 'Pendiri sekaligus penentu arah pengembangan yayasan.',
    'Dewan Pengurus' => 'Mengendalikan pelaksanaan arah pengembangan.',
    'Dewan Pengawas' => 'Menjamin arah pengembangan benar-benar dijalankan.',
    'Dewan Direksi'  => 'Memimpin Unit Pelaksana Kegiatan yang menjalankan operasional harian.',
];
?>
<section class="kepala-hal">
    <div class="wadah">
        <p class="remah"><a href="<?= base_url(); ?>">Beranda</a> &rsaquo; <a href="<?= base_url('profil'); ?>">Profil</a> &rsaquo; Struktur Organisasi</p>
        <h1>Struktur Organisasi</h1>
        <p>Tiga dewan dengan peran berbeda, dijalankan sehari-hari oleh Dewan Direksi.</p>
    </div>
</section>

<?php if (empty($struktur)): ?>
    <section class="blok blok--putih"><div class="wadah"><div class="hampa"><h3>Struktur belum diisi</h3><p>Admin dapat menambahkannya lewat panel, menu Struktur.</p></div></div></section>
<?php else: ?>
    <?php $i = 0; foreach ($struktur as $dewan => $orang): $i++; ?>
        <section class="blok <?= $i % 2 === 0 ? 'blok--krem' : 'blok--putih'; ?>" style="padding-top:58px;padding-bottom:58px">
            <div class="wadah">
                <div class="kepala-blok masuk">
                    <span class="kicir kicir--gelap">0<?= $i; ?></span>
                    <h2 style="font-size:clamp(1.4rem,2.8vw,1.95rem)"><?= html_escape($dewan); ?></h2>
                    <span class="garis-emas"></span>
                    <?php if (isset($keterangan[$dewan])): ?><p><?= html_escape($keterangan[$dewan]); ?></p><?php endif; ?>
                </div>

                <div class="baris baris--4">
                    <?php foreach ($orang as $o): $src = foto_struktur($o['foto']); ?>
                        <figure class="pengurus masuk">
                            <div class="pengurus__foto">
                                <?php if ($src !== ''): ?>
                                    <img src="<?= $src; ?>" alt="<?= html_escape($o['nama']); ?>" loading="lazy" decoding="async">
                                <?php else: ?>
                                    <span class="pengurus__kosong"><?= ikon('orang', 38); ?></span>
                                <?php endif; ?>
                            </div>
                            <figcaption>
                                <strong><?= html_escape($o['nama']); ?></strong>
                                <span><?= html_escape($o['jabatan']); ?></span>
                            </figcaption>
                        </figure>
                    <?php endforeach; ?>
                </div>
            </div>
        </section>
    <?php endforeach; ?>
<?php endif; ?>

<section class="blok blok--navy">
    <div class="wadah" style="text-align:center">
        <div class="masuk" style="max-width:600px;margin-inline:auto">
            <h2>Selengkapnya tentang yayasan</h2>
            <p style="margin-inline:auto">Legalitas, visi, misi, nilai, dan kemitraan ada di halaman profil.</p>
            <div class="sampul__aksi" style="justify-content:center">
                <a class="tbl tbl--emas" href="<?= base_url('profil'); ?>">Profil yayasan</a>
                <a class="tbl tbl--terang" href="<?= base_url('kontak'); ?>">Kontak</a>
            </div>
        </div>
    </div>
</section>
