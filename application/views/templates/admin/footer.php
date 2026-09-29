<?php
defined('BASEPATH') or exit('No direct script access allowed');

/* ============================================================================
   KERANGKA PANEL ADMIN — BAGIAN BAWAH
   ----------------------------------------------------------------------------
   Pesan sukses dan gagal dari controller (flashdata 'success' dan 'error')
   ditampilkan sebagai notifikasi melayang.

   Versi lama menaruh pesan itu langsung di dalam string JavaScript tanpa
   di-escape. Pesan galat unggahan dari CodeIgniter berisi tag <p>, sehingga
   skripnya rusak dan notifikasinya tidak pernah muncul — dan pesan berisi
   tanda kutip bisa menyuntikkan skrip. Sekarang dikirim lewat json_encode().
   ========================================================================== */

$pesan_sukses = (string) $this->session->flashdata('success');
$pesan_galat  = (string) $this->session->flashdata('error');
$this->session->unset_userdata(['success', 'error']);

$bersih = function ($s) {
    return trim(preg_replace('/\s+/u', ' ', html_entity_decode(strip_tags($s), ENT_QUOTES, 'UTF-8')));
};

$menu = isset($menu) ? $menu : '';
$pakai_editor = in_array($menu, ['berita', 'manajemen_konten', 'video_kegiatan'], TRUE);
$v_js = @filemtime(FCPATH . 'assets/admin/admin.js') ?: '1';
?>
        </main>

        <footer class="kaki">
            &copy; <?= date('Y'); ?> Yayasan Citra Bina Insan Mandiri &middot; Kupang, Nusa Tenggara Timur
        </footer>
    </div>
</div>

<script>
window.ADMIN_PESAN = <?= json_encode(['sukses' => $bersih($pesan_sukses), 'galat' => $bersih($pesan_galat)], JSON_HEX_TAG | JSON_HEX_AMP | JSON_HEX_APOS | JSON_HEX_QUOT); ?>;
</script>
<?php if ($pakai_editor): ?>
<script src="https://cdn.ckeditor.com/ckeditor5/41.0.0/classic/ckeditor.js"></script>
<?php endif; ?>
<script src="<?= base_url('assets/admin/admin.js?v=' . $v_js); ?>"></script>
</body>
</html>
