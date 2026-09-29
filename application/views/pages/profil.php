<?php
defined('BASEPATH') or exit('No direct script access allowed');
$K = function ($j, $b = 'isi') use ($konten) { return isset($konten[$j][$b]) ? $konten[$j][$b] : ''; };
?>
<section class="kepala-hal">
    <div class="wadah">
        <p class="remah"><a href="<?= base_url(); ?>">Beranda</a> &rsaquo; Profil</p>
        <h1>Profil Yayasan</h1>
        <p>Legalitas, arah lembaga, nilai yang dipegang, dan cara yayasan dijalankan.</p>
    </div>
</section>

<!-- Daftar isi yang menempel saat digulir. Halaman ini panjang, dan tanpa ini
     pembaca yang hanya mencari nomor akta harus menggulir melewati semuanya. -->
<nav class="daftar-isi" id="daftarIsi" aria-label="Bagian di halaman ini">
    <div class="wadah daftar-isi__isi">
        <span class="daftar-isi__label">Di halaman ini</span>
        <a href="#visi-misi">Visi &amp; Misi</a>
        <?php if ($K('nilai')): ?><a href="#nilai">Nilai</a><?php endif; ?>
        <?php if ($K('legalitas')): ?><a href="#legalitas">Legalitas</a><?php endif; ?>
        <?php if ($K('operasional')): ?><a href="#tata-kelola">Tata Kelola</a><?php endif; ?>
        <?php if ($K('kemitraan')): ?><a href="#kemitraan">Kemitraan</a><?php endif; ?>
    </div>
</nav>

<section class="blok blok--putih" id="visi-misi">
    <div class="wadah">
        <div class="baris baris--2" style="gap:56px;align-items:start">
            <div class="kotak kotak--aksen masuk">
                <div class="ikon-kotak"><?= ikon('kompas', 22); ?></div>
                <h2 style="font-size:1.5rem"><?= html_escape($K('visi', 'judul') ?: 'Visi'); ?></h2>
                <div class="isi" style="font-size:1.05rem"><?= bersihkan_html($K('visi')); ?></div>
            </div>
            <div class="kotak kotak--aksen masuk">
                <div class="ikon-kotak"><?= ikon('target', 22); ?></div>
                <h2 style="font-size:1.5rem"><?= html_escape($K('misi', 'judul') ?: 'Misi'); ?></h2>
                <div class="isi" style="font-size:1.05rem"><?= bersihkan_html($K('misi')); ?></div>
            </div>
        </div>
    </div>
</section>

<?php if ($K('nilai')): ?>
<section class="blok blok--krem" id="nilai">
    <div class="wadah">
        <div class="kepala-blok kepala-blok--tengah masuk">
            <span class="kicir kicir--gelap">Pedoman kerja</span>
            <h2><?= html_escape($K('nilai', 'judul') ?: 'Nilai'); ?></h2>
            <span class="garis-emas"></span>
            <p><?= html_escape($K('nilai', 'sub_judul')); ?></p>
        </div>
        <div class="kotak masuk nilai" style="max-width:820px;margin-inline:auto"><div class="isi"><?= bersihkan_html($K('nilai')); ?></div></div>
    </div>
</section>
<?php endif; ?>

<?php if ($K('legalitas')): ?>
<section class="blok blok--putih" id="legalitas">
    <div class="wadah sempit">
        <div class="kepala-blok masuk" style="max-width:none">
            <span class="kicir kicir--gelap">Dasar hukum</span>
            <h2><?= html_escape($K('legalitas', 'judul') ?: 'Legalitas'); ?></h2>
            <span class="garis-emas"></span>
            <p><?= html_escape($K('legalitas', 'sub_judul')); ?></p>
        </div>
        <div class="isi masuk"><?= bersihkan_html($K('legalitas')); ?></div>
    </div>
</section>
<?php endif; ?>

<?php if ($K('operasional')): ?>
<section class="blok blok--krem" id="tata-kelola">
    <div class="wadah sempit">
        <div class="kepala-blok masuk" style="max-width:none">
            <span class="kicir kicir--gelap">Tata kelola</span>
            <h2><?= html_escape($K('operasional', 'judul') ?: 'Tata kelola'); ?></h2>
            <span class="garis-emas"></span>
        </div>
        <div class="isi masuk"><?= bersihkan_html($K('operasional')); ?></div>
        <p style="margin-top:30px"><a class="tbl tbl--utama tbl--kecil" href="<?= base_url('struktur'); ?>">Lihat struktur organisasi</a></p>
    </div>
</section>
<?php endif; ?>

<?php if ($K('kemitraan')): ?>
<section class="blok blok--putih" id="kemitraan">
    <div class="wadah sempit">
        <div class="kepala-blok masuk" style="max-width:none">
            <span class="kicir kicir--gelap">Jaringan kerja sama</span>
            <h2><?= html_escape($K('kemitraan', 'judul') ?: 'Kemitraan'); ?></h2>
            <span class="garis-emas"></span>
        </div>
        <div class="isi masuk"><?= bersihkan_html($K('kemitraan')); ?></div>
    </div>
</section>
<?php endif; ?>

<section class="blok blok--navy">
    <div class="wadah" style="text-align:center">
        <div class="masuk" style="max-width:620px;margin-inline:auto">
            <h2>Mencari sekolah untuk anak Anda?</h2>
            <p style="margin-inline:auto">Setiap jenjang punya situs dan pendaftarannya sendiri.</p>
            <div class="sampul__aksi" style="justify-content:center">
                <a class="tbl tbl--emas" href="<?= base_url('jejaring'); ?>">Lihat semua unit</a>
                <a class="tbl tbl--terang" href="<?= base_url('kontak'); ?>">Hubungi yayasan</a>
            </div>
        </div>
    </div>
</section>
