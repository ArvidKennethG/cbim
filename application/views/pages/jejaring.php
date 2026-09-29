<?php defined('BASEPATH') or exit('No direct script access allowed'); ?>
<section class="kepala-hal">
    <div class="wadah">
        <p class="remah"><a href="<?= base_url(); ?>">Beranda</a> &rsaquo; Unit</p>
        <h1>Unit yang Dinaungi</h1>
        <p>Lima jenjang pendidikan dan tiga unit layanan masyarakat di Kota Kupang.</p>
    </div>
</section>

<section class="blok blok--putih">
    <div class="wadah">
        <div class="baris baris--2" style="gap:56px;align-items:start">
            <div class="masuk">
                <span class="kicir kicir--gelap">Unit pendidikan</span>
                <h2>Satu jalur belajar tanpa pindah lembaga</h2>
                <span class="garis-emas"></span>
                <p>
                    Anak yang masuk di TK dapat menempuh seluruh jenjang sampai perguruan
                    tinggi tanpa pernah berpindah lembaga. Guru di jenjang berikutnya sudah
                    tahu apa yang dipelajari sebelumnya, dan nilai yang ditanamkan tidak
                    berubah-ubah di tengah jalan.
                </p>
            </div>

            <ol class="jalur masuk">
                <?php foreach ($pendidikan as $i => $j): ?>
                    <li>
                        <span class="jalur__no"><?= $i + 1; ?></span>
                        <h3><?= html_escape($j['nama']); ?></h3>
                        <p><?= html_escape($j['deskripsi']); ?></p>
                        <a class="tbl tbl--garis tbl--kecil"
                           href="<?= $j['internal'] ? base_url($j['slug_unit']) : html_escape($j['tautan']); ?>"
                           <?= $j['internal'] ? '' : 'target="_blank" rel="noopener"'; ?>>
                            <?= html_escape($j['jenjang']); ?> &middot; Kunjungi
                        </a>
                    </li>
                <?php endforeach; ?>
            </ol>
        </div>
    </div>
</section>

<?php if (!empty($layanan)): ?>
<section class="blok blok--krem" id="layanan">
    <div class="wadah">
        <div class="kepala-blok masuk">
            <span class="kicir kicir--gelap">Unit layanan masyarakat</span>
            <h2>Bukan hanya sekolah</h2>
            <span class="garis-emas"></span>
            <p>Yayasan juga menjalankan layanan yang terbuka untuk masyarakat sekitar.</p>
        </div>

        <div class="baris baris--3">
            <?php $ic = ['kesehatan', 'globe', 'buku']; ?>
            <?php foreach ($layanan as $n => $l): ?>
                <div class="kotak masuk">
                    <div class="ikon-kotak"><?= ikon($ic[$n % 3], 22); ?></div>
                    <h3 style="font-size:1.15rem"><?= html_escape($l['nama']); ?></h3>
                    <p style="font-size:.95rem;color:var(--teks-redup);margin-bottom:.6rem"><?= html_escape($l['deskripsi']); ?></p>
                    <small style="color:var(--teks-redup)"><?= html_escape($l['jenjang']); ?></small>
                </div>
            <?php endforeach; ?>
        </div>

        <p style="text-align:center;margin:44px 0 0">
            <a class="tbl tbl--utama" href="<?= base_url('kontak'); ?>">Tanyakan layanannya</a>
        </p>
    </div>
</section>
<?php endif; ?>
