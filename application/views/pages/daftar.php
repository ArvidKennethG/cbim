<?php
defined('BASEPATH') or exit('No direct script access allowed');
/**
 * Pendaftaran di situs yayasan hanya berupa pengarah ke unit yang tepat.
 * Tidak ada formulir di sini, jadi tidak ada data anak yang dikumpulkan.
 */
?>
<section class="kepala-hal">
    <div class="wadah">
        <p class="remah"><a href="<?= base_url(); ?>">Beranda</a> &rsaquo; Pendaftaran</p>
        <h1>Pendaftaran Siswa Baru</h1>
        <p>Setiap jenjang membuka pendaftarannya sendiri. Pilih yang sesuai usia anak Anda.</p>
    </div>
</section>

<section class="blok blok--putih">
    <div class="wadah">
        <div class="kepala-blok masuk">
            <span class="kicir kicir--gelap">Langkah umum</span>
            <h2>Bagaimana prosesnya</h2>
            <span class="garis-emas"></span>
        </div>

        <ol class="jalur masuk" style="max-width:760px">
            <li>
                <span class="jalur__no">1</span>
                <h3>Pilih jenjang</h3>
                <p>Tentukan jenjang yang sesuai usia anak, lalu buka situs unitnya.</p>
            </li>
            <li>
                <span class="jalur__no">2</span>
                <h3>Tanyakan lebih dulu</h3>
                <p>Hubungi unit terkait untuk menanyakan daya tampung, biaya, dan jadwal tahun ajaran.</p>
            </li>
            <li>
                <span class="jalur__no">3</span>
                <h3>Datang melihat</h3>
                <p>Sekolah terbuka untuk dikunjungi pada jam belajar. Kabari sehari sebelumnya.</p>
            </li>
            <li>
                <span class="jalur__no">4</span>
                <h3>Lengkapi berkas</h3>
                <p>Siapkan akta kelahiran, kartu keluarga, dan foto anak sesuai permintaan unit.</p>
            </li>
        </ol>
    </div>
</section>

<section class="blok blok--krem">
    <div class="wadah">
        <div class="kepala-blok masuk">
            <span class="kicir kicir--gelap">Pilih unit</span>
            <h2>Mulai dari jenjang yang sesuai</h2>
            <span class="garis-emas"></span>
        </div>
        <div class="baris baris--3">
            <?php foreach ($pendidikan as $j): ?>
                <a class="unit-kartu masuk"
                   href="<?= $j['internal'] ? base_url($j['slug_unit'] . '/daftar') : html_escape($j['tautan']); ?>"
                   <?= $j['internal'] ? '' : 'target="_blank" rel="noopener"'; ?>>
                    <span class="unit-kartu__tingkat"><?= html_escape($j['jenjang']); ?></span>
                    <h3 style="font-size:1.1rem"><?= html_escape($j['nama']); ?></h3>
                    <p><?= html_escape($j['deskripsi']); ?></p>
                    <span class="unit-kartu__aksi">Cara mendaftar &rarr;</span>
                </a>
            <?php endforeach; ?>
        </div>
    </div>
</section>

<section class="blok blok--navy">
    <div class="wadah" style="text-align:center">
        <div class="masuk" style="max-width:600px;margin-inline:auto">
            <h2>Masih ragu memilih?</h2>
            <p style="margin-inline:auto">Hubungi kantor yayasan, kami arahkan ke unit yang tepat.</p>
            <div class="sampul__aksi" style="justify-content:center">
                <?php if (!empty($unit['whatsapp'])): ?>
                    <a class="tbl tbl--emas" href="https://wa.me/<?= html_escape($unit['whatsapp']); ?>" target="_blank" rel="noopener">WhatsApp yayasan</a>
                <?php endif; ?>
                <a class="tbl tbl--terang" href="<?= base_url('kontak'); ?>">Halaman kontak</a>
            </div>
        </div>
    </div>
</section>
