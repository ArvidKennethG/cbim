<?php
defined('BASEPATH') or exit('No direct script access allowed');
$K = function ($j, $b = 'isi') use ($konten) { return isset($konten[$j][$b]) ? $konten[$j][$b] : ''; };
?>

<!-- ============================ SAMPUL ============================ -->
<section class="sampul">
    <img class="sampul__cap" src="<?= base_url('assets/img/' . $unit['logo']); ?>" alt="" aria-hidden="true">
    <div class="wadah sampul__isi">
        <span class="kicir">Berdiri sejak 2007 &middot; Kota Kupang</span>
        <h1>Satu yayasan, dari pendidikan anak usia dini sampai perguruan tinggi</h1>
        <p>
            Yayasan Citra Bina Insan Mandiri menyelenggarakan pendidikan Kristen di Kota
            Kupang, mulai dari TK hingga universitas, serta layanan kesehatan dan pelatihan
            bagi masyarakat sekitar.
        </p>
        <div class="sampul__aksi">
            <a class="tbl tbl--emas" href="<?= base_url('jejaring'); ?>">Unit yang dinaungi</a>
            <a class="tbl tbl--terang" href="<?= base_url('profil'); ?>">Profil yayasan</a>
        </div>
    </div>
</section>

<!-- ============================ ANGKA ============================ -->
<?php if (!empty($angka)): ?>
<section class="blok blok--navy" style="padding-top:0;padding-bottom:0">
    <div class="wadah">
        <div class="statistik">
            <?php foreach ($angka as $a): ?>
                <div><strong><?= html_escape($a['nilai']); ?></strong><span><?= html_escape($a['keterangan']); ?></span></div>
            <?php endforeach; ?>
        </div>
    </div>
</section>
<?php endif; ?>

<!-- ============================ VISI & MISI ============================ -->
<section class="blok blok--putih">
    <div class="wadah">
        <div class="baris baris--2" style="gap:56px;align-items:start">
            <div class="masuk">
                <span class="kicir kicir--gelap">Arah lembaga</span>
                <h2><?= html_escape($K('visi', 'judul') ?: 'Visi'); ?></h2>
                <span class="garis-emas"></span>
                <div class="isi" style="font-size:1.12rem"><?= bersihkan_html($K('visi')); ?></div>
            </div>

            <div class="kotak kotak--aksen masuk">
                <div class="ikon-kotak"><?= ikon('target', 22); ?></div>
                <h3><?= html_escape($K('misi', 'judul') ?: 'Misi'); ?></h3>
                <div class="isi" style="font-size:.99rem"><?= bersihkan_html($K('misi')); ?></div>
            </div>
        </div>
    </div>
</section>

<!-- ============================ NILAI TESIS ============================ -->
<?php if ($K('nilai')): ?>
<section class="blok blok--krem">
    <div class="wadah">
        <div class="kepala-blok kepala-blok--tengah masuk">
            <span class="kicir kicir--gelap">Nilai yang kami pegang</span>
            <h2><?= html_escape($K('nilai', 'judul') ?: 'Nilai'); ?></h2>
            <span class="garis-emas"></span>
            <p><?= html_escape($K('nilai', 'sub_judul')); ?></p>
        </div>
        <div class="kotak masuk nilai" style="max-width:820px;margin-inline:auto">
            <div class="isi"><?= bersihkan_html($K('nilai')); ?></div>
        </div>
    </div>
</section>
<?php endif; ?>

<!-- ============================ UNIT ============================ -->
<section class="blok blok--putih">
    <div class="wadah">
        <div class="kepala-blok masuk">
            <span class="kicir kicir--gelap">Yang kami naungi</span>
            <h2>Lima jenjang pendidikan, tiga unit layanan</h2>
            <span class="garis-emas"></span>
            <p>Seluruhnya berada di Kota Kupang, di bawah satu naungan yayasan.</p>
        </div>

        <div class="baris baris--3" style="margin-bottom:52px">
            <?php foreach ($pendidikan as $j): ?>
                <a class="unit-kartu masuk"
                   href="<?= $j['internal'] ? base_url($j['slug_unit']) : html_escape($j['tautan']); ?>"
                   <?= $j['internal'] ? '' : 'target="_blank" rel="noopener"'; ?>>
                    <span class="unit-kartu__tingkat"><?= html_escape($j['jenjang']); ?></span>
                    <h3><?= html_escape($j['nama']); ?></h3>
                    <p><?= html_escape($j['deskripsi']); ?></p>
                    <span class="unit-kartu__aksi">Kunjungi situs &rarr;</span>
                </a>
            <?php endforeach; ?>
        </div>

        <div class="baris baris--3">
            <?php $ikon_layanan = ['kesehatan', 'globe', 'buku']; ?>
            <?php foreach ($layanan as $n => $l): ?>
                <div class="kotak masuk">
                    <div class="ikon-kotak"><?= ikon($ikon_layanan[$n % 3], 22); ?></div>
                    <h3 style="font-size:1.15rem"><?= html_escape($l['nama']); ?></h3>
                    <p style="font-size:.95rem;color:var(--teks-redup);margin:0"><?= html_escape($l['deskripsi']); ?></p>
                </div>
            <?php endforeach; ?>
        </div>
    </div>
</section>

<!-- ============================ BERITA ============================ -->
<section class="blok blok--krem">
    <div class="wadah">
        <div class="kepala-blok masuk" style="display:flex;justify-content:space-between;align-items:end;max-width:none;gap:20px;flex-wrap:wrap">
            <div style="max-width:560px">
                <span class="kicir kicir--gelap">Informasi</span>
                <h2>Berita terbaru</h2>
                <span class="garis-emas"></span>
            </div>
            <a class="tbl tbl--garis tbl--kecil" href="<?= base_url('berita'); ?>">Semua berita</a>
        </div>

        <?php if (empty($berita)): ?>
            <div class="hampa"><h3>Belum ada berita</h3><p>Berita akan muncul di sini begitu admin menuliskannya.</p></div>
        <?php else: ?>
            <div class="baris baris--3">
                <?php foreach ($berita as $b): ?>
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
                            <p><?= html_escape(!empty($b['ringkasan']) ? $b['ringkasan'] : potong($b['isi'], 110)); ?></p>
                            <span class="pos__kaki"><?= tanggal_id($b['tanggal_post']); ?></span>
                        </div>
                    </a>
                <?php endforeach; ?>
            </div>
        <?php endif; ?>
    </div>
</section>

<!-- ============================ KEGIATAN & GALERI ============================ -->
<?php if (!empty($video) || !empty($galeri)): ?>
<section class="blok blok--putih">
    <div class="wadah">
        <div class="kepala-blok kepala-blok--tengah masuk">
            <span class="kicir kicir--gelap">Dokumentasi</span>
            <h2>Kegiatan yayasan</h2>
            <span class="garis-emas"></span>
        </div>

        <?php if (!empty($video)): ?>
            <div class="baris baris--3" style="margin-bottom:<?= empty($galeri) ? '0' : '44px'; ?>">
                <?php foreach ($video as $v): ?>
                    <a class="tayang masuk" style="text-decoration:none;color:inherit" href="<?= base_url('kegiatan'); ?>">
                        <div class="tayang__gambar">
                            <img src="<?= html_escape($v['thumb']); ?>" alt="" loading="lazy" decoding="async">
                            <span class="tayang__main"><span><?= ikon('main', 22); ?></span></span>
                        </div>
                        <div class="tayang__isi">
                            <h3><?= html_escape($v['judul']); ?></h3>
                            <p><?= html_escape(potong($v['deskripsi'], 70)); ?></p>
                        </div>
                    </a>
                <?php endforeach; ?>
            </div>
        <?php endif; ?>

        <?php if (!empty($galeri)): ?>
            <div class="galeri-bata">
                <?php foreach (array_slice($galeri, 0, 6) as $g): ?>
                    <figure class="bingkai masuk" style="pointer-events:none">
                        <img src="<?= base_url('uploads/galeri/' . $g['foto']); ?>"
                             alt="<?= html_escape($g['judul']); ?>" loading="lazy" decoding="async">
                    </figure>
                <?php endforeach; ?>
            </div>
        <?php endif; ?>

        <p style="text-align:center;margin:42px 0 0">
            <a class="tbl tbl--garis" href="<?= base_url('kegiatan'); ?>">Lihat semua kegiatan</a>
        </p>
    </div>
</section>
<?php endif; ?>

<!-- ============================ TATA KELOLA ============================ -->
<?php if ($K('operasional')): ?>
<section class="blok blok--krem">
    <div class="wadah">
        <div class="baris baris--2" style="gap:56px;align-items:start">
            <div class="masuk">
                <span class="kicir kicir--gelap">Tata kelola</span>
                <h2 style="display:flex;align-items:center;gap:12px;margin-bottom:8px">
                    <svg width="28" height="28" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true" style="color:var(--warna-utama);flex-shrink:0"><path d="M4 22h16"/><path d="M4 22V4a2 2 0 0 1 2-2h12a2 2 0 0 1 2 2v18"/><path d="M10 22v-7a2 2 0 0 1 2-2h0a2 2 0 0 1 2 2v7"/><path d="M10 7h4"/><path d="M10 11h4"/><path d="M10 15h4"/></svg>
                    <?= html_escape($K('operasional', 'judul') ?: 'Tata kelola'); ?>
                </h2>
                <span class="garis-emas" style="margin-bottom:24px"></span>
                <div class="isi" style="font-size:1.05rem;line-height:1.75;text-align:justify;color:var(--teks);margin-bottom:8px;column-width:260px;column-gap:32px;"><?= bersihkan_html($K('operasional')); ?></div>
                <div style="margin-top:26px;position:relative;z-index:10;">
                    <a class="tbl tbl--utama tbl--kecil" href="<?= base_url('struktur'); ?>" style="position:relative;display:inline-block">Struktur organisasi</a>
                </div>
            </div>

            <div class="kotak masuk" style="display:flex;flex-direction:column;">
                <div style="display:flex;align-items:center;gap:14px;margin-bottom:12px">
                    <div class="ikon-kotak" style="margin:0;flex-shrink:0"><?= ikon('gedung', 24); ?></div>
                    <h3 style="margin:0;line-height:1.2">Kantor yayasan</h3>
                </div>
                <p style="font-size:.96rem;color:var(--teks-redup);line-height:1.6"><?= html_escape($unit['alamat']); ?></p>
                
                <hr style="border:none;border-top:1px solid var(--garis);margin:18px 0">
                
                <div style="display:flex;flex-direction:row;flex-wrap:wrap;gap:24px;margin-bottom:24px">
                    <?php if (!empty($unit['telepon'])): ?>
                        <div style="display:flex;align-items:center;gap:12px;flex:1;min-width:140px">
                            <span style="display:flex"><?= ikon('telpon', 20); ?></span>
                            <div>
                                <span style="display:block;font-size:.75rem;text-transform:uppercase;letter-spacing:1px;color:var(--teks-redup)">Telepon</span>
                                <a href="tel:<?= preg_replace('/[^0-9+]/', '', $unit['telepon']); ?>" style="font-weight:600;text-decoration:none;color:inherit;font-size:.95rem"><?= html_escape($unit['telepon']); ?></a>
                            </div>
                        </div>
                    <?php endif; ?>
                    <?php if (!empty($unit['email'])): ?>
                        <div style="display:flex;align-items:center;gap:12px;flex:1;min-width:140px">
                            <span style="display:flex"><?= ikon('surel', 20); ?></span>
                            <div>
                                <span style="display:block;font-size:.75rem;text-transform:uppercase;letter-spacing:1px;color:var(--teks-redup)">Surel</span>
                                <a href="mailto:<?= html_escape($unit['email']); ?>" style="font-weight:600;text-decoration:none;color:inherit;font-size:.95rem"><?= html_escape($unit['email']); ?></a>
                            </div>
                        </div>
                    <?php endif; ?>
                </div>
                
                <div style="margin-top:auto">
                    <a class="tbl tbl--garis tbl--kecil" style="width:100%;text-align:center;justify-content:center;display:flex" href="<?= base_url('kontak'); ?>">Halaman kontak</a>
                </div>
            </div>
        </div>
    </div>
</section>
<?php endif; ?>
