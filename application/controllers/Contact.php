<?php
defined('BASEPATH') or exit('No direct script access allowed');

/**
 * Contact Controller (BE-07)
 * 
 * REST API endpoint POST /api/contact
 * - Server-side validation
 * - Rate limiting (5 per hour per IP)
 * - Email notification to admin
 * - Logging to database
 */
class Contact extends CI_Controller
{
    public function __construct()
    {
        parent::__construct();
        $this->load->model('contact_model');
        $this->load->library('email');
        $this->load->helper('security');
    }

    /**
     * POST /api/contact
     * Accept contact form submissions
     */
    public function submit()
    {
        // Only allow POST
        if ($this->input->method() !== 'post') {
            $this->_json_response('error', 'Method not allowed.', 405);
            return;
        }

        $ip = $this->input->ip_address();

        // Rate limiting — max 5 submissions per hour per IP
        $count = $this->contact_model->get_submission_count($ip, 1); // 1 hour
        if ($count >= 5) {
            $this->_json_response('error', 'Terlalu banyak pengiriman. Silakan coba lagi nanti.', 429);
            return;
        }

        // Get and sanitize input
        $nama = $this->security->xss_clean(trim($this->input->post('nama', TRUE)));
        $email = $this->security->xss_clean(trim($this->input->post('email', TRUE)));
        $subjek = $this->security->xss_clean(trim($this->input->post('subjek', TRUE)));
        $pesan = $this->security->xss_clean(trim($this->input->post('pesan', TRUE)));

        // Validation
        $errors = [];
        if (empty($nama) || strlen($nama) < 2) {
            $errors[] = 'Nama harus diisi (minimal 2 karakter).';
        }
        if (empty($email) || !filter_var($email, FILTER_VALIDATE_EMAIL)) {
            $errors[] = 'Alamat email tidak valid.';
        }
        if (empty($subjek) || strlen($subjek) < 3) {
            $errors[] = 'Subjek harus diisi (minimal 3 karakter).';
        }
        if (empty($pesan) || strlen($pesan) < 10) {
            $errors[] = 'Pesan harus diisi (minimal 10 karakter).';
        }
        if (strlen($nama) > 100 || strlen($email) > 100 || strlen($subjek) > 200 || strlen($pesan) > 5000) {
            $errors[] = 'Input melebihi batas karakter yang diizinkan.';
        }

        if (!empty($errors)) {
            $this->_json_response('error', implode(' ', $errors), 422);
            return;
        }

        // Save to database
        $data = [
            'nama' => $nama,
            'email' => $email,
            'subjek' => $subjek,
            'pesan' => $pesan,
            'ip_address' => $ip,
            'created_at' => date('Y-m-d H:i:s'),
            'status' => 'unread'
        ];

        $saved = $this->contact_model->save_contact($data);

        if ($saved) {
            // Send email notification to admin
            $this->_send_notification($data);

            $this->_json_response('success', 'Pesan Anda berhasil terkirim. Terima kasih!');
        } else {
            $this->_json_response('error', 'Gagal menyimpan pesan. Silakan coba lagi.', 500);
        }
    }

    /**
     * Send email notification to admin
     */
    private function _send_notification($data)
    {
        // Configure email — adjust settings for your mail server
        $config = [
            'protocol' => 'smtp',
            'smtp_host' => 'localhost', // Change to your SMTP host
            'smtp_port' => 587,
            'smtp_crypto' => 'tls',
            'mailtype' => 'html',
            'charset' => 'utf-8',
            'newline' => "\r\n"
        ];

        $this->email->initialize($config);
        $this->email->from('noreply@cbim.or.id', 'Website CBIM');
        $this->email->to('admin@cbim.or.id'); // Change to actual admin email
        $this->email->subject('Pesan Baru dari Website: ' . $data['subjek']);

        $body = '<h3>Pesan Baru dari Formulir Kontak Website</h3>';
        $body .= '<table style="border-collapse:collapse;width:100%;">';
        $body .= '<tr><td style="padding:8px;border:1px solid #ddd;font-weight:bold;">Nama</td><td style="padding:8px;border:1px solid #ddd;">' . htmlspecialchars($data['nama']) . '</td></tr>';
        $body .= '<tr><td style="padding:8px;border:1px solid #ddd;font-weight:bold;">Email</td><td style="padding:8px;border:1px solid #ddd;">' . htmlspecialchars($data['email']) . '</td></tr>';
        $body .= '<tr><td style="padding:8px;border:1px solid #ddd;font-weight:bold;">Subjek</td><td style="padding:8px;border:1px solid #ddd;">' . htmlspecialchars($data['subjek']) . '</td></tr>';
        $body .= '<tr><td style="padding:8px;border:1px solid #ddd;font-weight:bold;">Pesan</td><td style="padding:8px;border:1px solid #ddd;">' . nl2br(htmlspecialchars($data['pesan'])) . '</td></tr>';
        $body .= '<tr><td style="padding:8px;border:1px solid #ddd;font-weight:bold;">IP Address</td><td style="padding:8px;border:1px solid #ddd;">' . $data['ip_address'] . '</td></tr>';
        $body .= '<tr><td style="padding:8px;border:1px solid #ddd;font-weight:bold;">Waktu</td><td style="padding:8px;border:1px solid #ddd;">' . $data['created_at'] . '</td></tr>';
        $body .= '</table>';

        $this->email->message($body);

        // Attempt to send, but don't fail the submission if email fails
        $this->email->send();
    }

    /**
     * Send JSON response
     */
    private function _json_response($status, $message, $http_code = 200)
    {
        $this->output
            ->set_status_header($http_code)
            ->set_content_type('application/json')
            ->set_output(json_encode([
                'status' => $status,
                'message' => $message
            ]));
    }
}
