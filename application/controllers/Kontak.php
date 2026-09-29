<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Kontak extends CI_Controller
{
    public function __construct()
    {
        parent::__construct();
        $this->load->model('m_data');
        $this->load->library('form_validation');
    }

    public function index()
    {
        $where_kontak = "jenis_konten='kontak'";
        $where_alamat = "jenis_konten='alamat'";
        $data_kontak = $this->m_data->get_data_where($where_kontak, 'konten')->result_array();
        $data_alamat = $this->m_data->get_data_where($where_alamat, 'konten')->result_array();

        $unit = [
            'logo' => 'logo-cbim.png',
            'nama' => 'Yayasan Citra Bina Insan Mandiri',
            'deskripsi' => 'Lembaga pendidikan terpadu di Nusa Tenggara Timur',
            'telepon' => !empty($data_kontak) ? strip_tags($data_kontak[0]['isi_konten']) : '(0380) 8553888',
            'email' => 'info@cbim.or.id',
            'alamat' => !empty($data_alamat) ? strip_tags($data_alamat[0]['isi_konten']) : 'Jl. Manafe No.17, Kel. Kayu Putih, Kec. Oebobo, Kota Kupang, NTT',
            'whatsapp' => '6281234567890'
        ];

        $pengaturan = [
            'facebook' => 'https://www.facebook.com/profile.php?id=100086189573438',
            'instagram' => 'https://www.instagram.com/yayasan_cbim/',
            'youtube' => 'https://www.youtube.com/@CBIMYayasan',
            'teks_footer' => 'Maju Bersama Generasi Unggul Nusa Tenggara Timur'
        ];
        
        $pendidikan = [
            ['internal' => true, 'slug_unit' => 'tk', 'jenjang' => 'TK', 'nama' => 'TK K Citra Bangsa', 'deskripsi' => 'Pendidikan anak usia dini.', 'tautan' => ''],
            ['internal' => true, 'slug_unit' => 'sd', 'jenjang' => 'SD', 'nama' => 'SD K Citra Bangsa', 'deskripsi' => 'Pendidikan dasar.', 'tautan' => ''],
            ['internal' => false, 'slug_unit' => 'smp', 'jenjang' => 'SMP', 'nama' => 'SMP K Citra Bangsa', 'deskripsi' => 'Pendidikan menengah pertama.', 'tautan' => 'http://smpkcitrabangsa.com/'],
            ['internal' => false, 'slug_unit' => 'sma', 'jenjang' => 'SMA', 'nama' => 'SMA K Citra Bangsa', 'deskripsi' => 'Pendidikan menengah atas.', 'tautan' => 'https://smakcitrabangsa.sch.id/'],
            ['internal' => false, 'slug_unit' => 'ucb', 'jenjang' => 'Universitas', 'nama' => 'Universitas Citra Bangsa', 'deskripsi' => 'Pendidikan tinggi unggul.', 'tautan' => 'https://ucb.ac.id/']
        ];

        $data = [
            'unit' => $unit,
            'pengaturan' => $pengaturan,
            'pendidikan' => $pendidikan,
            'judul_hal' => 'Hubungi Kami - Yayasan CBIM',
            'deskripsi' => 'Kontak dan Alamat Yayasan Citra Bina Insan Mandiri',
            'halaman' => 'kontak',
            'data_kontak' => $data_kontak,
            'data_alamat' => $data_alamat
        ];

        $this->load->view('./templates/pages/header', $data);
        $this->load->view('./pages/kontak', $data);
        $this->load->view('./templates/pages/footer', $data);
    }

    public function kirim()
    {
        $is_ajax = $this->input->is_ajax_request();

        // 1. Anti-spam honeypot check (hidden field)
        $honeypot = $this->input->post('cbim_hp_check');
        if (!empty($honeypot)) {
            // Silently discard bot submission
            if ($is_ajax) {
                echo json_encode(['status' => 'success', 'message' => 'Pesan Anda telah berhasil dikirim.']);
                return;
            }
            redirect(base_url('kontak'));
            return;
        }

        // 2. Rate limiting check (max 5 submissions per hour per IP)
        $ip = $this->input->ip_address();
        $one_hour_ago = date('Y-m-d H:i:s', strtotime('-1 hour'));
        $recent_count = $this->db->where('ip_address', $ip)
            ->where('created_at >=', $one_hour_ago)
            ->from('pesan_kontak')
            ->count_all_results();

        if ($recent_count >= 5) {
            $msg = 'Batas pengiriman tercapai (maks 5 pesan per jam). Silakan coba lagi nanti.';
            if ($is_ajax) {
                echo json_encode(['status' => 'error', 'message' => $msg]);
                return;
            }
            $this->session->set_flashdata('error', $msg);
            redirect(base_url('kontak'));
            return;
        }

        // 3. Form Validation
        $this->form_validation->set_rules('nama', 'Nama Lengkap', 'required|trim|min_length[3]|max_length[150]');
        $this->form_validation->set_rules('email', 'Alamat Email', 'required|trim|valid_email|max_length[150]');
        $this->form_validation->set_rules('subjek', 'Subjek', 'required|trim|min_length[3]|max_length[200]');
        $this->form_validation->set_rules('pesan', 'Pesan', 'required|trim|min_length[10]');

        if ($this->form_validation->run() == FALSE) {
            $errors = validation_errors('<li>', '</li>');
            if ($is_ajax) {
                echo json_encode(['status' => 'error', 'message' => $errors]);
                return;
            }
            $this->session->set_flashdata('error', 'Silakan periksa kembali isian formulir: <ul>' . $errors . '</ul>');
            redirect(base_url('kontak'));
            return;
        }

        // 4. Save to Database
        $nama = htmlspecialchars($this->input->post('nama', TRUE));
        $email = htmlspecialchars($this->input->post('email', TRUE));
        $subjek = htmlspecialchars($this->input->post('subjek', TRUE));
        $pesan = htmlspecialchars($this->input->post('pesan', TRUE));

        $data_insert = [
            'nama' => $nama,
            'email' => $email,
            'subjek' => $subjek,
            'pesan' => $pesan,
            'ip_address' => $ip,
            'status' => 'Belum Dibaca',
            'created_at' => date('Y-m-d H:i:s')
        ];

        $this->db->insert('pesan_kontak', $data_insert);

        // 5. Notification Email (Non-blocking fallback)
        $this->send_notification_email($data_insert);

        $success_msg = 'Terima kasih, pesan Anda telah berhasil dikirim. Tim kami akan segera merespons melalui email Anda.';
        if ($is_ajax) {
            echo json_encode(['status' => 'success', 'message' => $success_msg]);
            return;
        }

        $this->session->set_flashdata('success', $success_msg);
        redirect(base_url('kontak'));
    }

    private function send_notification_email($data)
    {
        // Try sending via CI Email library if configured, catch any error silently
        try {
            $this->load->library('email');
            $config['mailtype'] = 'html';
            $config['charset']  = 'utf-8';
            $config['newline']  = "\r\n";
            $this->email->initialize($config);

            $this->email->from('no-reply@cbim.or.id', 'Website Yayasan CBIM');
            $this->email->to('info@cbim.or.id');
            $this->email->subject('[Pesan Baru Website] ' . $data['subjek']);
            $this->email->message("
                <h3>Pesan Masuk dari Formulir Kontak Website</h3>
                <p><strong>Nama:</strong> {$data['nama']}</p>
                <p><strong>Email:</strong> {$data['email']}</p>
                <p><strong>Subjek:</strong> {$data['subjek']}</p>
                <p><strong>Pesan:</strong><br>" . nl2br($data['pesan']) . "</p>
                <hr>
                <small>Dikirim dari IP {$data['ip_address']} pada {$data['created_at']}</small>
            ");
            @$this->email->send();
        } catch (Exception $e) {
            log_message('error', 'Contact email notification error: ' . $e->getMessage());
        }
    }
}
