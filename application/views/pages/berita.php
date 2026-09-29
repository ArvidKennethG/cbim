<?php
defined('BASEPATH') or exit('No direct script access allowed');

if (!function_exists('url_saring')):
function url_saring($kat, $hal = 1)
{
    $q = [];
    if ($kat !== '') { $q['kategori'] = $kat; }
    if ($hal > 1)    { $q['hal'] = $hal; }
    return base_url('berita') . (empty($q) ? '' : '?' . http_build_query($q));
}
endif;
?>
<section class="kepala-hal">
    <div class="wadah">
        <p class="remah"><a href="<?= base_url(); ?>">Beranda</a> &rsaquo; Berita</p>
        <h1>Berita Yayasan</h1>
        <p>Kabar kegiatan, prestasi, dan pengumuman dari lingkungan yayasan.</p>
    </div>
</section>

<section class="blok blok--putih">
    <div class="wadah">
        <nav class="saring" aria-label="Saring berita menurut jenis">
            <a href="<?= url_saring(''); ?>"<?= $kat_aktif === '' ? ' aria-current="true"' : ''; ?>>
                Semua <b><?= (int) array_sum($kat_terpakai); ?></b>
            </a>
            <?php foreach (kategori_berita() as $kunci => $k):
                if (empty($kat_terpakai[$kunci])) { continue; } ?>
                <a href="<?= url_saring($kunci); ?>" class="kat-<?= $kunci; ?>"<?= $kat_aktif === $kunci ? ' aria-current="true"' : ''; ?>>
                    <?= html_escape($k['label']); ?> <b><?= (int) $kat_terpakai[$kunci]; ?></b>
                </a>
            <?php endforeach; ?>
        </nav>

        <?php if (empty($berita)): ?>
            <div class="hampa">
                <h3><?= $kat_aktif === '' ? 'Belum ada berita' : 'Belum ada berita di jenis ini'; ?></h3>
                <p><?= $kat_aktif === '' ? 'Berita akan muncul di sini begitu admin menuliskannya.' : 'Coba pilih jenis lain, atau lihat semuanya.'; ?></p>
                <?php if ($kat_aktif !== ''): ?>
                    <p style="margin-top:20px"><a class="tbl tbl--garis tbl--kecil" href="<?= url_saring(''); ?>">Lihat semua berita</a></p>
                <?php endif; ?>
            </div>
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
                            <p><?= html_escape(!empty($b['ringkasan']) ? $b['ringkasan'] : potong($b['isi'], 120)); ?></p>
                            <span class="pos__kaki">
                                <?= tanggal_id($b['tanggal_post']); ?><?php if (!empty($b['penulis'])): ?> &middot; <?= html_escape($b['penulis']); ?><?php endif; ?>
                            </span>
                        </div>
                    </a>
                <?php endforeach; ?>
            </div>

            <?php if ($total_hal > 1): ?>
                <nav class="nomor" aria-label="Halaman berita">
                    <?php if ($hal > 1): ?><a href="<?= url_saring($kat_aktif, $hal - 1); ?>" rel="prev" aria-label="Sebelumnya">&larr;</a><?php endif; ?>
                    <?php for ($i = 1; $i <= $total_hal; $i++): ?>
                        <?php if ($i === $hal): ?><span aria-current="page"><?= $i; ?></span>
                        <?php else: ?><a href="<?= url_saring($kat_aktif, $i); ?>"><?= $i; ?></a><?php endif; ?>
                    <?php endfor; ?>
                    <?php if ($hal < $total_hal): ?><a href="<?= url_saring($kat_aktif, $hal + 1); ?>" rel="next" aria-label="Berikutnya">&rarr;</a><?php endif; ?>
                </nav>
            <?php endif; ?>
        <?php endif; ?>
    </div>
</section>
