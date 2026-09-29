<?php
defined('BASEPATH') or exit('No direct script access allowed');

/**
 * =============================================================================
 * BE-08 : Backup Otomatis Terjadwal
 * =============================================================================
 * PERUBAHAN PATCH 2026-09-07
 * -----------------------------------------------------------------------------
 * MASALAH LAMA (KRITIS):
 *   Backup ditulis ke FCPATH . 'uploads/backups/' -- yaitu DI DALAM web root.
 *   Aturan rewrite di .htaccess root hanya aktif bila file tidak ada
 *   (RewriteCond %{REQUEST_FILENAME} !-f), sehingga file .sql.gz yang sudah ada
 *   dilayani langsung oleh Apache. Nama filenya pun berpola tebakan:
 *   db_YYYY-MM-DD_HHMMSS.sql.gz
 *   Dampak: dump database lengkap (termasuk data pribadi anak dari PPDB)
 *   berpotensi diunduh siapa saja dari internet.
 *
 * PERBAIKAN:
 *   1. Backup ditulis ke luar web root: <root>/../cbim_backups/
 *      Bila direktori itu tidak bisa dibuat (mis. shared hosting yang mengunci
 *      level di atas public_html), sistem jatuh kembali ke lokasi lama TAPI
 *      otomatis menulis .htaccess "Require all denied" di sana.
 *   2. Nama file diberi sufiks acak sehingga tidak bisa ditebak.
 *   3. Rotasi 30 hari dipertahankan, tapi kini hanya menyentuh file db_*.sql.gz
 *      (versi lama menghapus SEMUA file di folder itu -- berbahaya bila folder
 *      dipakai bersama).
 *   4. Method database() untuk download manual kini TIDAK lagi menulis salinan
 *      ke disk web root. Ia hanya mengalirkan file ke browser admin.
 *   5. Pengecekan hak akses diperketat ke role administrator / default.
 *
 * TINDAK LANJUT (belum termasuk patch ini, butuh kredensial):
 *   - Unggah otomatis ke S3 / Google Cloud Storage
 *   - Laporan status backup harian via email
 *   - Uji restore terjadwal
 *
 * Cron harian:
 *   0 2 * * * cd /path/ke/yayasan && php index.php backup run >> /var/log/cbim-backup.log 2>&1
 * =============================================================================
 */
class Backup extends CI_Controller
{
    public function __construct()
    {
        parent::__construct();
        $this->load->dbutil();
        $this->load->helper('file');
        $this->load->helper('download');
    }

    /**
     * Menentukan direktori backup yang aman.
     *
     * Prioritas 1 : <parent dari web root>/cbim_backups/  -> tidak bisa diakses HTTP
     * Prioritas 2 : FCPATH uploads/backups/               -> dikunci .htaccess
     */
    private function backup_dir()
    {
        // ---------------------------------------------------------------------
        // LOKASI EKSPLISIT -- SESUAIKAN SATU BARIS DI BAWAH INI
        // ---------------------------------------------------------------------
        // Ini cara paling pasti untuk menaruh backup di luar jangkauan Apache.
        //
        //   Lokal (XAMPP)   : 'C:/xampp/cbim_backups/'
        //                     Apache hanya melayani C:/xampp/htdocs, jadi
        //                     C:/xampp/ sendiri tidak bisa diakses via browser.
        //   Produksi cPanel : '/home/NAMA_USER/cbim_backups/'
        //   Produksi VPS    : '/var/backups/cbim/'
        //
        // Kosongkan ('') bila ingin memakai deteksi otomatis di bawah.
        //
        // PENTING: jangan arahkan ke folder yang dilayani Apache. Di XAMPP,
        // 'C:/xampp/htdocs/cbim_backups/' TETAP bisa dibuka lewat
        // http://localhost/cbim_backups/ -- itu justru mengulang celah yang
        // sedang kita tutup.
        // ---------------------------------------------------------------------
        $explicit = 'C:/xampp/cbim_backups/';

        if (!empty($explicit)) {
            $explicit = rtrim(str_replace('\\', '/', $explicit), '/') . '/';
            if (is_dir($explicit) || @mkdir($explicit, 0700, TRUE)) {
                if (is_writable($explicit)) {
                    return $explicit;
                }
            }
            log_message('error', 'BACKUP: lokasi eksplisit tidak bisa dipakai (' . $explicit . '), beralih ke deteksi otomatis.');
        }

        // ---------------------------------------------------------------------
        // Deteksi otomatis: satu tingkat di atas web root.
        //
        // CATATAN: ini benar untuk hosting yang menaruh aplikasi tepat di
        // public_html/, tapi TIDAK aman bila aplikasi berada di subfolder yang
        // dilayani Apache -- contohnya XAMPP (htdocs/yayasan), di mana induknya
        // adalah htdocs dan masih bisa diakses browser. Karena itu, isi
        // $explicit di atas dan jangan bergantung pada bagian ini.
        // ---------------------------------------------------------------------
        $safe_dir = realpath(FCPATH . '..');

        if ($safe_dir !== FALSE && is_writable($safe_dir)) {
            $dir = rtrim($safe_dir, DIRECTORY_SEPARATOR) . DIRECTORY_SEPARATOR . 'cbim_backups' . DIRECTORY_SEPARATOR;
            if (is_dir($dir) || @mkdir($dir, 0700, TRUE)) {
                // Jaring pengaman: kalau ternyata folder induk masih dilayani
                // Apache (kasus XAMPP), .htaccess ini yang menahan.
                $this->ensure_htaccess_guard($dir);
                return $dir;
            }
        }

        // Fallback: tetap di dalam web root, tapi wajib dikunci.
        $dir = FCPATH . 'uploads' . DIRECTORY_SEPARATOR . 'backups' . DIRECTORY_SEPARATOR;
        if (!is_dir($dir)) {
            @mkdir($dir, 0700, TRUE);
        }
        $this->ensure_htaccess_guard($dir);

        log_message(
            'error',
            'BACKUP WARNING: tidak bisa menulis di luar web root, backup disimpan di ' . $dir .
            ' -- pastikan .htaccess proteksi aktif dan pertimbangkan memindahkan folder ini secara manual.'
        );

        return $dir;
    }

    /**
     * Menulis .htaccess penolak akses bila belum ada.
     */
    private function ensure_htaccess_guard($dir)
    {
        $guard = $dir . '.htaccess';
        if (file_exists($guard)) {
            return;
        }

        $content = "<IfModule mod_authz_core.c>\n"
            . "    Require all denied\n"
            . "</IfModule>\n"
            . "<IfModule !mod_authz_core.c>\n"
            . "    Order deny,allow\n"
            . "    Deny from all\n"
            . "</IfModule>\n"
            . "Options -Indexes\n";

        @file_put_contents($guard, $content);
    }

    /**
     * Hanya administrator (atau CLI) yang boleh menyentuh backup.
     */
    private function guard_access()
    {
        if ($this->input->is_cli_request()) {
            return TRUE;
        }

        $role = $this->session->userdata('role');
        if ($role === 'administrator' || $role === 'default') {
            return TRUE;
        }

        if (!$role) {
            redirect(base_url('auth'));
        } else {
            show_error('Anda tidak memiliki hak akses ke modul backup.', 403, 'Akses Ditolak');
        }
        return FALSE;
    }

    private function backup_prefs()
    {
        return [
            'format' => 'gzip',
            'filename' => 'backup_yayasan_' . date('Ymd_His') . '.sql',
            'add_drop' => TRUE,
            'add_insert' => TRUE,
            'newline' => "\n"
        ];
    }

    /**
     * BE-08: Backup on-demand, langsung diunduh admin.
     * Tidak menyimpan salinan di web root.
     */
    public function database()
    {
        if (!$this->guard_access()) {
            return;
        }

        $backup = $this->dbutil->backup($this->backup_prefs());
        $file_name = 'backup_cbim_' . date('Y-m-d_His') . '.sql.gz';

        if (!$this->input->is_cli_request()) {
            force_download($file_name, $backup);
            return;
        }

        $dir = $this->backup_dir();
        write_file($dir . $file_name, $backup);
        @chmod($dir . $file_name, 0600);
        echo "Database backup saved to {$dir}{$file_name}\n";
    }

    /**
     * BE-08: Runner terjadwal -- php index.php backup run
     */
    public function run()
    {
        if (!$this->guard_access()) {
            return;
        }

        $backup_dir = $this->backup_dir();

        // 1. Dump database dengan nama yang tidak bisa ditebak
        $backup = $this->dbutil->backup($this->backup_prefs());
        $suffix = bin2hex(random_bytes(6));
        $db_file = $backup_dir . 'db_' . date('Y-m-d_His') . '_' . $suffix . '.sql.gz';

        write_file($db_file, $backup);
        @chmod($db_file, 0600);

        // 2. Rotasi: simpan 30 hari terakhir, HANYA menyentuh file dump kita sendiri
        $deleted = 0;
        $now = time();
        foreach (glob($backup_dir . 'db_*.sql.gz') as $filePath) {
            if (is_file($filePath) && ($now - filemtime($filePath) > 30 * 86400)) {
                @unlink($filePath);
                $deleted++;
            }
        }

        $status = 'Backup executed: ' . basename($db_file)
            . ' (' . number_format(filesize($db_file) / 1024, 1) . ' KB)'
            . '. Cleaned up ' . $deleted . ' old backups.';

        log_message('info', $status);
        echo $status . "\n";
    }
}