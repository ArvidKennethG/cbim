<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Newsletter extends CI_Controller
{
    public function __construct()
    {
        parent::__construct();
    }

    public function subscribe()
    {
        $email = htmlspecialchars(trim($this->input->post('email', TRUE)));
        $preferensi = htmlspecialchars(trim($this->input->post('preferensi', TRUE)));
        if (empty($preferensi)) {
            $preferensi = 'semua';
        }

        if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
            echo json_encode(['status' => 'error', 'message' => 'Format email tidak valid.']);
            return;
        }

        // Check if already subscribed
        $existing = $this->db->get_where('newsletter_subscribers', ['email' => $email])->row_array();
        if (!empty($existing)) {
            if ($existing['status'] === 'Aktif') {
                echo json_encode(['status' => 'info', 'message' => 'Email ini sudah terdaftar sebagai pelanggan warta CBIM.']);
                return;
            } else {
                // Re-activate
                $this->db->where('id_subscriber', $existing['id_subscriber'])->update('newsletter_subscribers', [
                    'status' => 'Aktif',
                    'preferensi' => $preferensi
                ]);
                echo json_encode(['status' => 'success', 'message' => 'Langganan warta Anda telah diaktifkan kembali!']);
                return;
            }
        }

        $token = bin2hex(random_bytes(16));
        $data = [
            'email' => $email,
            'preferensi' => $preferensi,
            'token_unsubscribe' => $token,
            'status' => 'Aktif',
            'created_at' => date('Y-m-d H:i:s')
        ];

        if ($this->db->insert('newsletter_subscribers', $data)) {
            echo json_encode(['status' => 'success', 'message' => 'Terima kasih! Anda telah berhasil berlangganan warta Yayasan CBIM.']);
        } else {
            echo json_encode(['status' => 'error', 'message' => 'Gagal mendaftarkan email. Silakan coba sesaat lagi.']);
        }
    }

    public function unsubscribe()
    {
        $token = htmlspecialchars(trim($this->input->get('token', TRUE)));
        $subscriber = null;

        if (!empty($token)) {
            $subscriber = $this->db->get_where('newsletter_subscribers', ['token_unsubscribe' => $token])->row_array();
            if (!empty($subscriber)) {
                $this->db->where('id_subscriber', $subscriber['id_subscriber'])->update('newsletter_subscribers', ['status' => 'Unsubscribed']);
            }
        }

        $data = [
            'data_kontak' => [],
            'data_alamat' => [],
            'success' => !empty($subscriber)
        ];

        $this->load->view('./templates/pages/header');
        $this->load->view('./pages/unsubscribe', $data);
        $this->load->view('./templates/pages/footer');
    }
}
