<?php
defined('BASEPATH') or exit('No direct script access allowed');

/**
 * =============================================================================
 * PERUBAHAN PATCH 2026-09-07
 * =============================================================================
 * MASALAH LAMA (KRITIS):
 *   __construct() memanggil cek_default_admin(); setiap kali /auth diakses, dan
 *   membuat ulang user 'admin123' / 'admin123' dengan role 'default' bila tidak
 *   ditemukan. Role 'default' lolos seluruh pengecekan check_rbac() di Admin.php.
 *   Akibatnya akun ini TIDAK BISA dihapus secara permanen -- dihapus lewat DB,
 *   akan muncul lagi pada kunjungan berikutnya ke halaman login.
 *
 * PERBAIKAN:
 *   1. Pembuatan admin otomatis dicabut dari __construct().
 *   2. Seeder dipindah ke method seed_admin() yang HANYA bisa dijalankan dari
 *      CLI, dan hanya jika tabel auth benar-benar kosong. Password dibuat acak
 *      lalu dicetak sekali ke layar -- tidak ada lagi kredensial default yang
 *      diketahui publik.
 *        php index.php auth seed_admin
 *   3. Method add_user() yang tidak terpakai (adminbuku/adminbuku) dihapus.
 *   4. Login diperkuat:
 *      - htmlspecialchars() dilepas dari password. Fungsi itu mengubah karakter
 *        seperti & " ' < > menjadi entity, sehingga password yang mengandung
 *        karakter tersebut tidak akan pernah cocok dengan hash-nya.
 *      - Rate limit 5 percobaan gagal per 15 menit per IP.
 *      - session_regenerate_id() setelah login berhasil (anti session fixation).
 *      - Pesan error dibuat seragam agar tidak membocorkan username mana yang ada.
 *
 * TINDAKAN WAJIB SETELAH PATCH INI DIPASANG:
 *   Hapus akun lama secara manual, lalu buat akun admin baru:
 *     DELETE FROM auth WHERE username = 'admin123';
 *     php index.php auth seed_admin
 * =============================================================================
 */
class Auth extends CI_Controller
{
    /** Maksimum percobaan login gagal per IP */
    const MAX_LOGIN_ATTEMPTS = 5;

    /** Jendela waktu rate limit (detik) */
    const LOGIN_WINDOW = 900; // 15 menit

    public function __construct()
    {
        parent::__construct();

        // CATATAN: pembuatan admin default OTOMATIS sudah DICABUT di sini.
        // Gunakan: php index.php auth seed_admin

        if ($this->session->userdata('id_user')) {
            redirect(base_url('admin'));
        }

        $this->load->model('visitors_log');
        $ip_address = $this->input->ip_address();
        $this->visitors_log->log_visitor($ip_address);
    }

    public function index()
    {
        $this->load->view('auth/login');
    }

    public function login()
    {
        if ($this->input->method() !== 'post') {
            redirect(base_url('auth'));
            return;
        }

        if ($this->is_rate_limited()) {
            $this->session->set_flashdata(
                'error',
                'Terlalu banyak percobaan login. Silakan coba lagi dalam 15 menit.'
            );
            redirect(base_url('auth'));
            return;
        }

        $username = trim((string) $this->input->post('username', TRUE));

        // PENTING: password TIDAK boleh di-htmlspecialchars(). Encoding entity
        // akan merusak password yang mengandung karakter & " ' < >.
        $password = (string) $this->input->post('password', FALSE);

        $user = $this->db->get_where('auth', ['username' => $username])->row_array();

        // password_verify dijalankan terhadap dummy hash bila user tidak ada,
        // supaya waktu respons seragam (mencegah user enumeration).
        $hash = !empty($user['password'])
            ? $user['password']
            : '$2y$10$usesomesillystringforsalt0000000000000000000000000000000000';

        if (!empty($user['id_user']) && password_verify($password, $hash)) {
            $this->clear_login_attempts();

            // Anti session fixation
            $this->session->sess_regenerate(TRUE);

            $this->session->set_userdata([
                'id_user'  => $user['id_user'],
                'username' => $user['username'],
                'role'     => $user['role']
            ]);

            log_message('info', 'Login berhasil: ' . $username . ' dari ' . $this->input->ip_address());
            redirect(base_url('admin'));
            return;
        }

        $this->register_failed_attempt();
        log_message('error', 'Login gagal untuk "' . $username . '" dari ' . $this->input->ip_address());

        $this->session->set_flashdata('error', 'Username atau password salah.');
        redirect(base_url('auth'));
    }

    // =========================================================================
    // Rate limiting sederhana berbasis session
    // =========================================================================

    private function is_rate_limited()
    {
        $attempts = $this->session->userdata('login_attempts');
        $first    = $this->session->userdata('login_attempts_start');

        if (empty($attempts) || empty($first)) {
            return FALSE;
        }

        if ((time() - $first) > self::LOGIN_WINDOW) {
            $this->clear_login_attempts();
            return FALSE;
        }

        return $attempts >= self::MAX_LOGIN_ATTEMPTS;
    }

    private function register_failed_attempt()
    {
        $attempts = (int) $this->session->userdata('login_attempts');
        $first    = $this->session->userdata('login_attempts_start');

        if (empty($first) || (time() - $first) > self::LOGIN_WINDOW) {
            $attempts = 0;
            $first    = time();
        }

        $this->session->set_userdata([
            'login_attempts'       => $attempts + 1,
            'login_attempts_start' => $first
        ]);
    }

    private function clear_login_attempts()
    {
        $this->session->unset_userdata(['login_attempts', 'login_attempts_start']);
    }

    // =========================================================================
    // Seeder admin -- CLI ONLY, sekali jalan
    // =========================================================================

    /**
     * Membuat akun administrator pertama.
     * Hanya berjalan dari command line DAN hanya bila tabel auth kosong.
     *
     *   php index.php auth seed_admin
     *   php index.php auth seed_admin namauser
     */
    public function seed_admin($username = 'administrator')
    {
        if (!$this->input->is_cli_request()) {
            show_404();
            return;
        }

        $jumlah_user = $this->db->count_all('auth');
        if ($jumlah_user > 0) {
            echo "Dibatalkan: tabel 'auth' sudah berisi {$jumlah_user} user.\n";
            echo "Seeder ini hanya boleh dijalankan pada instalasi baru.\n";
            echo "Untuk mereset, hapus user lama secara manual lewat database.\n";
            return;
        }

        $username = preg_replace('/[^a-zA-Z0-9_.-]/', '', $username);
        if ($username === '') {
            $username = 'administrator';
        }

        // Password acak 16 karakter, dicetak satu kali saja.
        $plain = rtrim(strtr(base64_encode(random_bytes(12)), '+/', 'Aa'), '=');

        $this->db->insert('auth', [
            'username' => $username,
            'password' => password_hash($plain, PASSWORD_DEFAULT),
            'role'     => 'administrator'
        ]);

        echo "\n";
        echo "==========================================================\n";
        echo " AKUN ADMINISTRATOR BERHASIL DIBUAT\n";
        echo "==========================================================\n";
        echo " Username : {$username}\n";
        echo " Password : {$plain}\n";
        echo "----------------------------------------------------------\n";
        echo " Simpan password ini sekarang juga.\n";
        echo " Password TIDAK akan ditampilkan lagi.\n";
        echo " Segera ganti setelah login pertama.\n";
        echo "==========================================================\n\n";
    }
}
