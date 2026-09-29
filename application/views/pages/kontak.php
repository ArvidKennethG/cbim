<?php
defined('BASEPATH') or exit('No direct script access allowed');
$peta = 'https://www.google.com/maps?q=' . rawurlencode($unit['alamat']) . '&output=embed';
?>
<section class="kepala-hal">
    <div class="wadah">
        <p class="remah"><a href="<?= base_url(); ?>">Beranda</a> &rsaquo; Kontak</p>
        <h1>Hubungi Kami</h1>
        <p>Kantor yayasan melayani pada hari kerja, Senin sampai Jumat.</p>
    </div>
</section>

<section class="blok blok--putih">
    <div class="wadah">
        <div class="baris baris--3" style="margin-bottom:44px">
            <?php if (!empty($unit['alamat'])): ?>
            <div class="kotak masuk">
                <div class="ikon-kotak"><?= ikon('peta', 22); ?></div>
                <h3 style="font-size:1.12rem">Alamat kantor</h3>
                <p style="font-size:.96rem;color:var(--teks-redup);margin:0"><?= html_escape($unit['alamat']); ?></p>
            </div>
            <?php endif; ?>

            <?php if (!empty($unit['telepon'])): ?>
            <div class="kotak masuk">
                <div class="ikon-kotak"><?= ikon('telepon', 22); ?></div>
                <h3 style="font-size:1.12rem">Telepon</h3>
                <p style="margin:0"><a href="tel:<?= preg_replace('/[^0-9+]/', '', $unit['telepon']); ?>" style="font-weight:600"><?= html_escape($unit['telepon']); ?></a></p>
                <p style="font-size:.9rem;color:var(--teks-redup);margin:.4rem 0 0">Jam kerja, Senin sampai Jumat.</p>
            </div>
            <?php endif; ?>

            <?php if (!empty($unit['email'])): ?>
            <div class="kotak masuk">
                <div class="ikon-kotak"><?= ikon('surel', 22); ?></div>
                <h3 style="font-size:1.12rem">Surel</h3>
                <p style="margin:0"><a href="mailto:<?= html_escape($unit['email']); ?>" style="font-weight:600"><?= html_escape($unit['email']); ?></a></p>
                <p style="font-size:.9rem;color:var(--teks-redup);margin:.4rem 0 0">Untuk surat resmi dan kerja sama.</p>
            </div>
            <?php endif; ?>
        </div>

        <?php if (!empty($unit['whatsapp'])): ?>
            <p style="text-align:center;margin-bottom:44px">
                <a class="tbl tbl--utama" href="https://wa.me/<?= html_escape($unit['whatsapp']); ?>" target="_blank" rel="noopener">Kirim pesan WhatsApp</a>
            </p>
        <?php endif; ?>

        <!-- Peta dimuat lazy supaya tidak memperlambat halaman. -->
        <div class="peta masuk">
            <iframe src="<?= html_escape($peta); ?>" title="Peta lokasi kantor yayasan"
                    loading="lazy" referrerpolicy="no-referrer-when-downgrade" allowfullscreen></iframe>
        </div>
    </div>
</section>

<?php if (!empty($pendidikan)): ?>
<section class="blok blok--krem">
    <div class="wadah">
        <div class="kepala-blok masuk">
            <span class="kicir kicir--gelap">Perlu menghubungi sekolahnya?</span>
            <h2>Pendaftaran ditangani masing-masing unit</h2>
            <span class="garis-emas"></span>
            <p>Kantor yayasan tidak menangani pendaftaran maupun urusan harian sekolah.</p>
        </div>
        <div class="baris baris--3">
            <?php foreach ($pendidikan as $j): ?>
                <a class="unit-kartu masuk"
                   href="<?= $j['internal'] ? base_url($j['slug_unit']) : html_escape($j['tautan']); ?>"
                   <?= $j['internal'] ? '' : 'target="_blank" rel="noopener"'; ?>>
                    <span class="unit-kartu__tingkat"><?= html_escape($j['jenjang']); ?></span>
                    <h3 style="font-size:1.1rem"><?= html_escape($j['nama']); ?></h3>
                    <span class="unit-kartu__aksi">Kunjungi situs &rarr;</span>
                </a>
            <?php endforeach; ?>
        </div>
    </div>
</section>
<?php endif; ?>
