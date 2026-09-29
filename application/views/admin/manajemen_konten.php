<?php
defined('BASEPATH') or exit('No direct script access allowed');

/* ============================================================================
   PROFIL YAYASAN (MANAJEMEN KONTEN)
   Data: $data_konten (id_konten, judul_konten, sub_judul_konten, isi_konten,
   jenis_konten). Aksi: admin/add_konten, admin/update_konten,
   admin/delete_konten.

   Kolom jenis_konten di database bertipe ENUM dengan tujuh nilai persis di
   bawah ini, dan controller menolak dua konten dengan jenis yang sama. Karena
   itu halaman ini disusun per jenis: tujuh kartu tetap, masing-masing terisi
   atau kosong. Admin langsung melihat bagian mana yang belum diisi, dan tidak
   akan tersandung pesan "jenis konten sudah ada".
   ========================================================================== */

$jenis = [
    'legalitas'   => ['Legalitas',   'Akta pendirian, pengesahan, dan perubahannya', 'Halaman Profil'],
    'visi'        => ['Visi',        'Arah jangka panjang yayasan',                  'Halaman Profil'],
    'misi'        => ['Misi',        'Langkah untuk mewujudkan visi',                'Halaman Profil'],
    'nilai'       => ['Nilai',       'Nilai-nilai yang dipegang, misalnya TESIS',    'Halaman Profil'],
    'operasional' => ['Operasional', 'Tata kelola dan cara yayasan dijalankan',      'Halaman Profil'],
    'kontak'      => ['Kontak',      'Telepon, surel, dan jam layanan',              'Halaman Kontak'],
    'alamat'      => ['Alamat',      'Alamat kantor yayasan',                        'Halaman Kontak'],
];

$per_jenis = [];
$rekam = [];
foreach ($data_konten as $k) {
    $per_jenis[$k['jenis_konten']] = $k;
    $rekam['k' . $k['id_konten']] = [
        'id_konten'        => $k['id_konten'],
        'judul_konten'     => html_entity_decode($k['judul_konten'], ENT_QUOTES | ENT_HTML5, 'UTF-8'),
        'sub_judul_konten' => html_entity_decode((string) $k['sub_judul_konten'], ENT_QUOTES | ENT_HTML5, 'UTF-8'),
        'isi_konten'       => $k['isi_konten'],
        'jenis_konten'     => $k['jenis_konten'],
    ];
}
$terisi = count(array_intersect_key($per_jenis, $jenis));
?>

<div class="kepala">
    <div class="kepala__teks">
        <p>Isi halaman Profil dan Kontak situs yayasan. Setiap bagian hanya boleh punya satu isi —
           <strong><?= $terisi; ?> dari <?= count($jenis); ?></strong> bagian sudah terisi.</p>
    </div>
</div>

<div class="daftar-konten">
    <?php foreach ($jenis as $kunci => $j):
        $k = isset($per_jenis[$kunci]) ? $per_jenis[$kunci] : NULL; ?>
        <?php if ($k): ?>
            <article class="konten">
                <div class="konten__kepala">
                    <span class="konten__ikon"><?= adm_ikon('konten', 17); ?></span>
                    <div style="min-width:0">
                        <small><?= adm_e($j[0]); ?> &middot; <?= adm_e($j[2]); ?></small>
                        <h3><?= adm_e($k['judul_konten']); ?></h3>
                    </div>
                </div>
                <div class="konten__isi">
                    <?php if (!in_array(trim((string) $k['sub_judul_konten']), ['', '-', '—'], TRUE)): ?>
                        <p style="margin:0 0 6px;color:var(--navy);font-weight:600"><?= adm_e($k['sub_judul_konten']); ?></p>
                    <?php endif; ?>
                    <p class="potong-2" style="margin:0;-webkit-line-clamp:4"><?= adm_e(adm_ringkas($k['isi_konten'], 260)); ?></p>
                </div>
                <div class="konten__kaki">
                    <span class="cap cap--hijau">Terisi</span>
                    <div class="aksi">
                        <button type="button" class="tbl tbl--garis tbl--kecil" data-buka="dialogUbah" data-rekam="k<?= (int) $k['id_konten']; ?>"><?= adm_ikon('ubah', 14); ?> Ubah</button>
                        <button type="button" class="ikon-tbl ikon-tbl--hapus" title="Hapus" aria-label="Hapus konten <?= adm_e($j[0]); ?>"
                                data-hapus="<?= base_url('admin/delete_konten/'); ?>"
                                data-kirim='<?= adm_e(adm_json(['id_konten' => $k['id_konten']])); ?>'
                                data-judul="Hapus isi bagian <?= adm_e($j[0]); ?>?"
                                data-ket="Bagian ini akan kosong di situs sampai diisi lagi."
                                data-nama="<?= adm_e($k['judul_konten']); ?>"><?= adm_ikon('hapus', 15); ?></button>
                    </div>
                </div>
            </article>
        <?php else: ?>
            <article class="konten konten--kosong">
                <div class="konten__kepala">
                    <span class="konten__ikon"><?= adm_ikon('konten', 17); ?></span>
                    <div>
                        <small><?= adm_e($j[2]); ?></small>
                        <h3><?= adm_e($j[0]); ?></h3>
                    </div>
                </div>
                <div class="konten__isi"><p style="margin:0"><?= adm_e($j[1]); ?>. Bagian ini belum diisi, jadi tidak tampil di situs.</p></div>
                <div class="konten__kaki">
                    <span class="cap">Belum diisi</span>
                    <button type="button" class="tbl tbl--utama tbl--kecil" data-buka="dialogTambah"
                            data-isi='<?= adm_e(adm_json(['jenis_konten' => $kunci, 'judul_konten' => $j[0]])); ?>'><?= adm_ikon('tambah', 14); ?> Isi sekarang</button>
                </div>
            </article>
        <?php endif; ?>
    <?php endforeach; ?>
</div>

<script type="application/json" id="data-halaman"><?= adm_json($rekam); ?></script>

<dialog class="dialog dialog--lebar" id="dialogTambah" aria-labelledby="judulTambah">
    <form action="<?= base_url('admin/add_konten/'); ?>" method="post" data-kosongkan data-sukses="Bagian profil sudah diisi.">
        <?= adm_kepala_dialog('Isi bagian profil', '', 'judulTambah'); ?>
        <div class="dialog__isi">
            <div class="baris-bidang">
                <div class="bidang">
                    <label for="t_jenis">Bagian <span class="wajib">*</span></label>
                    <select id="t_jenis" name="jenis_konten" required>
                        <option value="">— Pilih bagian —</option>
                        <?php foreach ($jenis as $kunci => $j): ?>
                            <option value="<?= $kunci; ?>"<?= isset($per_jenis[$kunci]) ? ' disabled' : ''; ?>><?= adm_e($j[0]); ?><?= isset($per_jenis[$kunci]) ? ' (sudah terisi)' : ''; ?></option>
                        <?php endforeach; ?>
                    </select>
                </div>
                <div class="bidang">
                    <label for="t_judul">Judul <span class="wajib">*</span></label>
                    <input type="text" id="t_judul" name="judul_konten" required maxlength="250">
                </div>
            </div>
            <div class="bidang">
                <label for="t_sub">Subjudul <span class="wajib">*</span></label>
                <input type="text" id="t_sub" name="sub_judul_konten" required maxlength="250" placeholder="Kalimat singkat di bawah judul">
            </div>
            <div class="bidang">
                <label for="editorKonten">Isi <span class="wajib">*</span></label>
                <textarea id="editorKonten" name="isi_konten" data-editor data-wajib="Isi konten" rows="10"></textarea>
            </div>
        </div>
        <div class="dialog__kaki">
            <button type="button" class="tbl tbl--garis" data-tutup>Batal</button>
            <button type="submit" class="tbl tbl--utama">Simpan</button>
        </div>
    </form>
</dialog>

<dialog class="dialog dialog--lebar" id="dialogUbah" aria-labelledby="judulUbah">
    <form action="<?= base_url('admin/update_konten/'); ?>" method="post" data-sukses="Perubahan profil sudah disimpan.">
        <?= adm_kepala_dialog('Ubah bagian profil', '', 'judulUbah'); ?>
        <div class="dialog__isi">
            <input type="hidden" name="id_konten">
            <div class="baris-bidang">
                <div class="bidang">
                    <label for="u_jenis">Bagian <span class="wajib">*</span></label>
                    <select id="u_jenis" name="jenis_konten" required>
                        <?php foreach ($jenis as $kunci => $j): ?>
                            <option value="<?= $kunci; ?>"><?= adm_e($j[0]); ?></option>
                        <?php endforeach; ?>
                    </select>
                </div>
                <div class="bidang">
                    <label for="u_judul">Judul <span class="wajib">*</span></label>
                    <input type="text" id="u_judul" name="judul_konten" required maxlength="250">
                </div>
            </div>
            <div class="bidang">
                <label for="u_sub">Subjudul <span class="wajib">*</span></label>
                <input type="text" id="u_sub" name="sub_judul_konten" required maxlength="250">
            </div>
            <div class="bidang">
                <label for="editorKontenUbah">Isi <span class="wajib">*</span></label>
                <textarea id="editorKontenUbah" name="isi_konten" data-editor data-wajib="Isi konten" rows="10"></textarea>
            </div>
        </div>
        <div class="dialog__kaki">
            <button type="button" class="tbl tbl--garis" data-tutup>Batal</button>
            <button type="submit" class="tbl tbl--utama">Simpan perubahan</button>
        </div>
    </form>
</dialog>
