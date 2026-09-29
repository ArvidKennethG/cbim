<?php defined('BASEPATH') or exit('No direct script access allowed'); ?>
<section class="blok blok--putih" style="padding-top:90px">
    <div class="wadah" style="text-align:center">
        <div style="max-width:560px;margin-inline:auto">
            <span class="kicir kicir--gelap">Galat 404</span>
            <h1>Halaman ini tidak ditemukan</h1>
            <span class="garis-emas" style="margin-inline:auto"></span>
            <p style="margin-inline:auto;color:var(--teks-redup)">
                Mungkin alamatnya salah ketik, atau halamannya sudah dipindahkan.
                Coba mulai lagi dari beranda.
            </p>
            <div class="sampul__aksi" style="justify-content:center">
                <a class="tbl tbl--utama" href="<?= base_url(); ?>">Beranda yayasan</a>
                <a class="tbl tbl--garis" href="<?= base_url('tk'); ?>">Situs TK</a>
                <a class="tbl tbl--garis" href="<?= base_url('sd'); ?>">Situs SD</a>
            </div>
        </div>
    </div>
</section>
