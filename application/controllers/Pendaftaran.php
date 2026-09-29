<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Pendaftaran extends CI_Controller
{
    public function __construct()
    {
        parent::__construct();
        $this->load->model('m_data');
        $this->load->library('form_validation');
    }

    public function index()
    {
        $data = [
            'data_kontak' => $this->m_data->get_data_where("jenis_konten='kontak'", 'konten')->result_array(),
            'data_alamat' => $this->m_data->get_data_where("jenis_konten='alamat'", 'konten')->result_array()
        ];

        $this->load->view('./templates/pages/header');
        $this->load->view('./pages/pendaftaran', $data);
        $this->load->view('./templates/pages/footer');
    }

    public function submit()
    {
        $this->form_validation->set_rules('jenjang', 'Jenjang Pendidikan', 'required|in_list[TK,SD,SMP,SMA,UCB]');
        $this->form_validation->set_rules('nama_lengkap', 'Nama Lengkap Calon Siswa', 'required|trim|min_length[3]|max_length[200]');
        $this->form_validation->set_rules('jenis_kelamin', 'Jenis Kelamin', 'required|in_list[Laki-laki,Perempuan]');
        $this->form_validation->set_rules('nama_ortu', 'Nama Orang Tua / Wali', 'required|trim|min_length[3]|max_length[200]');
        $this->form_validation->set_rules('no_hp', 'Nomor HP / WhatsApp', 'required|trim|min_length[8]|max_length[25]');
        $this->form_validation->set_rules('alamat', 'Alamat Domisili', 'required|trim|min_length[5]');

        if ($this->form_validation->run() == FALSE) {
            $this->session->set_flashdata('error', validation_errors('<li>', '</li>'));
            redirect(base_url('pendaftaran'));
            return;
        }

        $jenjang = htmlspecialchars($this->input->post('jenjang', TRUE));
        $nama_lengkap = htmlspecialchars($this->input->post('nama_lengkap', TRUE));
        $nik_nisn = htmlspecialchars($this->input->post('nik_nisn', TRUE));
        $jenis_kelamin = htmlspecialchars($this->input->post('jenis_kelamin', TRUE));
        $tempat_lahir = htmlspecialchars($this->input->post('tempat_lahir', TRUE));
        $tgl_lahir = htmlspecialchars($this->input->post('tgl_lahir', TRUE));
        if (empty($tgl_lahir)) {
            $tgl_lahir = NULL;
        }
        $agama = htmlspecialchars($this->input->post('agama', TRUE));
        $nama_ortu = htmlspecialchars($this->input->post('nama_ortu', TRUE));
        $pekerjaan_ortu = htmlspecialchars($this->input->post('pekerjaan_ortu', TRUE));
        $no_hp = htmlspecialchars($this->input->post('no_hp', TRUE));
        $email = htmlspecialchars($this->input->post('email', TRUE));
        $alamat = htmlspecialchars($this->input->post('alamat', TRUE));
        $asal_sekolah = htmlspecialchars($this->input->post('asal_sekolah', TRUE));
        $catatan = htmlspecialchars($this->input->post('catatan', TRUE));

        // Generate Registration Number
        $random_suffix = strtoupper(substr(md5(uniqid(rand(), true)), 0, 4));
        $no_registrasi = 'REG-' . $jenjang . '-' . date('Ymd') . '-' . $random_suffix;

        $data_pendaftaran = [
            'no_registrasi' => $no_registrasi,
            'jenjang' => $jenjang,
            'nama_lengkap' => $nama_lengkap,
            'nik_nisn' => $nik_nisn,
            'jenis_kelamin' => $jenis_kelamin,
            'tempat_lahir' => $tempat_lahir,
            'tgl_lahir' => $tgl_lahir,
            'agama' => $agama,
            'nama_ortu' => $nama_ortu,
            'pekerjaan_ortu' => $pekerjaan_ortu,
            'no_hp' => $no_hp,
            'email' => $email,
            'alamat' => $alamat,
            'asal_sekolah' => $asal_sekolah,
            'catatan' => $catatan,
            'status' => 'Baru',
            'tanggal_daftar' => date('Y-m-d H:i:s')
        ];

        $this->db->insert('pendaftaran', $data_pendaftaran);

        // Backward compatibility sync with pendaftaran_sd or pendaftaran_tk
        if ($jenjang === 'SD') {
            $this->db->insert('pendaftaran_sd', [
                'nama_lengkap' => $nama_lengkap,
                'nisn' => $nik_nisn,
                'jenis_kelamin' => $jenis_kelamin,
                'tempat_lahir' => $tempat_lahir,
                'tgl_lahir' => $tgl_lahir ?: date('Y-m-d'),
                'nama_ortu' => $nama_ortu,
                'no_hp' => $no_hp,
                'alamat' => $alamat,
                'tanggal_daftar' => date('Y-m-d H:i:s'),
                'status' => 'Baru'
            ]);
        } elseif ($jenjang === 'TK') {
            $this->db->insert('pendaftaran_tk', [
                'nama_lengkap' => $nama_lengkap,
                'kelompok' => !empty($catatan) ? $catatan : 'TK A / TK B',
                'jenis_kelamin' => $jenis_kelamin,
                'tgl_lahir' => $tgl_lahir ?: date('Y-m-d'),
                'nama_ortu' => $nama_ortu,
                'no_hp' => $no_hp,
                'alamat' => $alamat,
                'tanggal_daftar' => date('Y-m-d H:i:s'),
                'status' => 'Baru'
            ]);
        }

        // Store registration info in session for success card
        $this->session->set_flashdata('pendaftaran_sukses', [
            'no_registrasi' => $no_registrasi,
            'jenjang' => $jenjang,
            'nama_lengkap' => $nama_lengkap,
            'no_hp' => $no_hp
        ]);

        redirect(base_url('pendaftaran/sukses'));
    }

    public function sukses()
    {
        $sukses_data = $this->session->flashdata('pendaftaran_sukses');
        if (empty($sukses_data)) {
            redirect(base_url('pendaftaran'));
            return;
        }

        $data = [
            'pendaftaran' => $sukses_data,
            'data_kontak' => $this->m_data->get_data_where("jenis_konten='kontak'", 'konten')->result_array(),
            'data_alamat' => $this->m_data->get_data_where("jenis_konten='alamat'", 'konten')->result_array()
        ];

        $this->load->view('./templates/pages/header');
        $this->load->view('./pages/pendaftaran_sukses', $data);
        $this->load->view('./templates/pages/footer');
    }
}
