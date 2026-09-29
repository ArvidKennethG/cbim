<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Admin extends CI_Controller
{
    private $id_auth;

    public function __construct()
    {
        parent::__construct();
        if (!$this->session->userdata('role')) {
            redirect(base_url('auth'));
        }
        $this->id_auth = $this->session->userdata('id_auth');
        $this->load->model('m_data');
        $this->load->helper('date');
        $this->load->model('visitors_log');
        $ip_address = $this->input->ip_address();
        $this->visitors_log->log_visitor($ip_address);
    }

    public function log_visit()
    {
        // Log visitor's IP address
        $ip_address = $this->input->ip_address();
        $this->visitors_log->log_visitor($ip_address);
    }

    public function index()
    {
        $data['menu'] = 'dashboard';
        $data['daily_visits'] = $this->visitors_log->get_daily_visits();
        $data['monthly_visits'] = $this->visitors_log->get_monthly_visits();
        $data['yearly_visits'] = $this->visitors_log->get_yearly_visits();
        $this->load->view('./templates/admin/header', $data);
        $this->load->view('./admin/index');
        $this->load->view('./templates/admin/modals');
        $this->load->view('./templates/admin/footer');
    }

    // ================================================
    // ============= Struktur Organisasi ==============
    // ================================================

    public function struktur_organisasi()
    {
        $this->check_rbac(['administrator']);
        $data_struktur = $this->m_data->get_data('struktur_organisasi')->result_array();
        $data = [
            "menu" => 'struktur_organisasi',
            'data_struktur' => $data_struktur
        ];
        $this->load->view('./templates/admin/header', $data);
        $this->load->view('./admin/struktur_organisasi');
        $this->load->view('./templates/admin/modals');
        $this->load->view('./templates/admin/footer');
    }

    public function add_struktur()
    {
        $this->check_rbac(['administrator']);
        if ($this->input->method() === 'post') {
            $nama_pejabat = htmlspecialchars($this->input->post('nama_pejabat'));
            $jabatan = htmlspecialchars($this->input->post('jabatan'));
            $config['upload_path'] = FCPATH . '/uploads/avatars/';
            $config['allowed_types'] = 'jpg|jpeg|png';
            $this->load->library('upload', $config);

            if ($this->upload->do_upload('foto')) {
                $upload_data = $this->upload->data();
                $foto = $upload_data['file_name'];
                $data = array(
                    'foto' => $foto,
                    'nama' => $nama_pejabat,
                    'jabatan' => $jabatan,
                );

                $this->m_data->insert_data('struktur_organisasi', $data);
                redirect('admin/struktur_organisasi');
            } else {
                
                $upload_error = $this->upload->display_errors();
                
                $this->session->set_flashdata('error', $upload_error);
            }
        }
    }
    public function update_struktur()
    {
        $this->check_rbac(['administrator']);
        
        if ($this->input->method() === 'post') {
            $id_struktur = (int) $this->input->post('id_struktur');
            $nama_pejabat = htmlspecialchars($this->input->post('nama_pejabat'));
            $jabatan = htmlspecialchars($this->input->post('jabatan'));
            $where = "id_struktur=$id_struktur";

            if (!empty($_FILES['foto']['name'])) {
                $foto_lama = htmlspecialchars($this->input->post('foto_lama'));
                $old_photo_path = FCPATH . '/uploads/avatars/' . $foto_lama;
                if (file_exists($old_photo_path)) {
                    unlink($old_photo_path);
                }

                
                $config['upload_path'] = FCPATH . '/uploads/avatars/';
                $config['allowed_types'] = 'jpg|jpeg|png';
                $this->load->library('upload', $config);

                if ($this->upload->do_upload('foto')) {
                    $upload_data = $this->upload->data();
                    $foto = $upload_data['file_name'];
                    $data = array(
                        'foto' => $foto,
                        'nama' => $nama_pejabat,
                        'jabatan' => $jabatan,
                    );

                    $this->m_data->update_data($where, $data, 'struktur_organisasi');
                } else {
                    $upload_error = $this->upload->display_errors();
                    $this->session->set_flashdata('error', $upload_error);
                }
            } else {
                $foto_lama = htmlspecialchars($this->input->post('foto_lama'));
                $data = array(
                    'foto' => $foto_lama,
                    'nama' => $nama_pejabat,
                    'jabatan' => $jabatan,
                );
                $this->m_data->update_data($where, $data, 'struktur_organisasi');
            }
            redirect('admin/struktur_organisasi');
        }
    }

    public function delete_struktur()
    {
        $this->check_rbac(['administrator']);
        $id_struktur = (int) $this->input->post('id_struktur');
        $foto = htmlspecialchars($this->input->post('foto'));
        $where = "id_struktur=$id_struktur";
        if (!empty($id_struktur)) {
            $this->m_data->delete_data_wfoto($where, 'struktur_organisasi', $foto);
        }
        redirect('admin/struktur_organisasi');
    }

    // ================================================
    // ============= Manajemen Konten =================
    // ================================================

    public function manajemen_konten()
    {
        $this->check_rbac(['administrator']);
        $data_konten = $this->m_data->get_data('konten')->result_array();
        $data = [
            "menu" => 'manajemen_konten',
            'data_konten' => $data_konten
        ];
        $this->load->view('./templates/admin/header', $data);
        $this->load->view('./admin/manajemen_konten');
        $this->load->view('./templates/admin/modals');
        $this->load->view('./templates/admin/footer');
    }

    public function add_konten()
    {
        $this->check_rbac(['administrator']);

        if ($this->input->method() === 'post') {
            $judul_konten = htmlspecialchars($this->input->post('judul_konten'));
            $sub_judul_konten = htmlspecialchars($this->input->post('sub_judul_konten'));
            $isi_konten = $this->input->post('isi_konten');
            $jenis_konten = htmlspecialchars($this->input->post('jenis_konten'));
            $where_legalitas = "jenis_konten='$jenis_konten'";
            $data_legalitas = $this->m_data->get_data_where($where_legalitas, 'konten')->result_array();
            if (!empty($data_legalitas)) {
                $this->session->set_flashdata('error', 'Data tersebut sudah tersimpan sebelumnya!');
            } else {
                $data = array(
                    'judul_konten' => $judul_konten,
                    'sub_judul_konten' => $sub_judul_konten,
                    'isi_konten' => $isi_konten,
                    'jenis_konten' => $jenis_konten
                );
                $this->m_data->insert_data('konten', $data);
            }

            redirect('admin/manajemen_konten');
        }
    }
    public function update_konten()
    {
        $this->check_rbac(['administrator']);

        if ($this->input->method() === 'post') {
            $id_konten = (int) $this->input->post('id_konten');
            $judul_konten = htmlspecialchars($this->input->post('judul_konten'));
            $sub_judul_konten = htmlspecialchars($this->input->post('sub_judul_konten'));
            $isi_konten = $this->input->post('isi_konten');
            $jenis_konten = htmlspecialchars($this->input->post('jenis_konten'));
            $where = "id_konten=$id_konten";
            $where_legalitas = "jenis_konten='$jenis_konten' AND id_konten!='$id_konten'";
            $data_legalitas = $this->m_data->get_data_where($where_legalitas, 'konten')->result_array();
            if (!empty($data_legalitas)) {
                $this->session->set_flashdata('error', 'Tidak bisa menyimpan data dengan jenis konten yang sama!');
            } else {
                $data = array(
                    'judul_konten' => $judul_konten,
                    'sub_judul_konten' => $sub_judul_konten,
                    'isi_konten' => $isi_konten,
                    'jenis_konten' => $jenis_konten
                );

                $this->m_data->update_data($where, $data, 'konten');
            }

            redirect('admin/manajemen_konten');
        }
    }
    public function delete_konten()
    {
        $this->check_rbac(['administrator']);
        $id_konten = (int) $this->input->post('id_konten');
        $where = "id_konten=$id_konten";
        if (!empty($id_konten)) {
            $this->m_data->delete_data($where, 'konten');
        }
        redirect('admin/manajemen_konten');
    }

    // ================================================
    // ============= Video Kegiatan =================
    // ================================================

    public function video_kegiatan()
    {
        $this->check_rbac(['administrator']);
        $data_video = $this->m_data->get_data('video_kegiatan')->result_array();
        $data = [
            "menu" => 'video_kegiatan',
            'data_video' => $data_video
        ];
        $this->load->view('./templates/admin/header', $data);
        $this->load->view('./admin/video_kegiatan');
        $this->load->view('./templates/admin/modals');
        $this->load->view('./templates/admin/footer');
    }

    public function add_video()
    {
        $this->check_rbac(['administrator']);

        if ($this->input->method() === 'post') {
            $judul_video = htmlspecialchars($this->input->post('judul_video'));
            $deskripsi = $this->input->post('deskripsi');
            $youtubeLink = $this->input->post('link');

            $data = array(
                'judul_video' => $judul_video,
                'deskripsi' => $deskripsi,
                'link' => $youtubeLink
            );
            $this->m_data->insert_data('video_kegiatan', $data);

            redirect('admin/video_kegiatan');
        }
    }
    public function update_video()
    {
        $this->check_rbac(['administrator']);
        if ($this->input->method() === 'post') {
            $id_video = (int) $this->input->post('id_video');
            $judul_video = htmlspecialchars($this->input->post('judul_video'));
            $deskripsi = $this->input->post('deskripsi');
            $youtubeLink = $this->input->post('link');
            $where = "id_video=$id_video";

            $data = array(
                'judul_video' => $judul_video,
                'deskripsi' => $deskripsi,
                'link' => $youtubeLink
            );
            $this->m_data->update_data($where, $data, 'video_kegiatan');
            redirect('admin/video_kegiatan');
        }
    }

    public function delete_video()
    {
        $this->check_rbac(['administrator']);
        $id_video = (int) $this->input->post('id_video');
        $where = "id_video=$id_video";
        if (!empty($id_video)) {
            $this->m_data->delete_data($where, 'video_kegiatan');
        } else {
            return $this->session->set_flashdata('error', 'Tidak ada data yang dapat dihapus.');
        }
        redirect('admin/video_kegiatan');
    }

    // ================================================
    // ==================== Berita ====================
    // ================================================

    public function berita()
    {
        $this->check_rbac(['administrator']);
        $data_berita = $this->m_data->get_data('berita')->result_array();
        $data = [
            "menu" => 'berita',
            'data_berita' => $data_berita
        ];
        $this->load->view('./templates/admin/header', $data);
        $this->load->view('./admin/berita');
        $this->load->view('./templates/admin/modals');
        $this->load->view('./templates/admin/footer');
    }

    public function add_berita()
    {
        $this->check_rbac(['administrator']);

        if ($this->input->method() === 'post') {

            $judul_berita = htmlspecialchars($this->input->post('judul_berita'));
            $isi_berita = $this->input->post('isi_berita');

            $tanggal_post = date('Y-m-d H:i:s', now('Asia/Taipei'));

            // Upload photo
            $config['upload_path'] = FCPATH . '/uploads/berita/';
            $config['allowed_types'] = 'jpg|jpeg|png';
            $this->load->library('upload', $config);

            if ($this->upload->do_upload('gambar')) {
                $upload_data = $this->upload->data();
                $gambar = $upload_data['file_name'];

                $data = array(
                    'judul_berita' => $judul_berita,
                    'isi_berita' => $isi_berita,
                    'tanggal_post' => $tanggal_post,
                    'tanggal_update' => $tanggal_post,
                    'gambar' => $gambar
                );

                $this->m_data->insert_data('berita', $data);
            } else {
                $upload_error = $this->upload->display_errors();
                $this->session->set_flashdata('error', $upload_error);
            }

            redirect('admin/berita');
        }
    }

    public function update_berita()
    {
        $this->check_rbac(['administrator']);
        if ($this->input->method() === 'post') {

            $id_berita = (int) $this->input->post('id_berita');
            $judul_berita = htmlspecialchars($this->input->post('judul_berita'));
            $isi_berita = $this->input->post('isi_berita');
            $tanggal_post = htmlspecialchars($this->input->post('tanggal_post'));
            $tanggal_update = date('Y-m-d H:i:s', now('Asia/Taipei'));
            $where = "id_berita=$id_berita";

            if (!empty($_FILES['gambar']['name'])) {

                $gambar_lama = htmlspecialchars($this->input->post('gambar_lama'));
                $old_photo_path = FCPATH . '/uploads/berita/' . $gambar_lama;
                if (file_exists($old_photo_path)) {
                    unlink($old_photo_path);
                }

                $config['upload_path'] = FCPATH . '/uploads/berita/';
                $config['allowed_types'] = 'jpg|jpeg|png';
                $this->load->library('upload', $config);

                if ($this->upload->do_upload('gambar')) {
                    $upload_data = $this->upload->data();
                    $gambar = $upload_data['file_name'];

                    $data = array(
                        'judul_berita' => $judul_berita,
                        'isi_berita' => $isi_berita,
                        'tanggal_post' => $tanggal_post,
                        'tanggal_update' => $tanggal_update,
                        'gambar' => $gambar
                    );
                    $this->m_data->update_data($where, $data, 'berita');
                } else {

                    $upload_error = $this->upload->display_errors();
                    $this->session->set_flashdata('error', $upload_error);
                }
            } else {

                $gambar_lama = htmlspecialchars($this->input->post('gambar_lama'));
                $data = array(
                    'judul_berita' => $judul_berita,
                    'isi_berita' => $isi_berita,
                    'tanggal_post' => $tanggal_post,
                    'tanggal_update' => $tanggal_update,
                    'gambar' => $gambar_lama
                );
                $this->m_data->update_data($where, $data, 'berita');
            }
        }

        redirect('admin/berita');
    }
    public function delete_berita()
    {
        $this->check_rbac(['administrator']);
        $id_berita = (int) $this->input->post('id_berita');
        $where = "id_berita=$id_berita";
        if (!empty($id_berita)) {
            $this->m_data->delete_data($where, 'berita');
        } else {
            return $this->session->set_flashdata('error', 'Tidak ada data yang dapat dihapus.');
        }
        redirect('admin/berita');
    }

    // ================================================
    // ============= Galeri ==============
    // ================================================

    public function galeri()
    {
        $this->check_rbac(['administrator']);
        $data_galeri = $this->m_data->get_data('galeri')->result_array();
        $data = [
            "menu" => 'galeri',
            'data_galeri' => $data_galeri
        ];
        $this->load->view('./templates/admin/header', $data);
        $this->load->view('./admin/galeri');
        $this->load->view('./templates/admin/modals');
        $this->load->view('./templates/admin/footer');
    }

    public function add_foto()
    {
        $this->check_rbac(['administrator']);
        if ($this->input->method() === 'post') {
            $judul_foto = htmlspecialchars($this->input->post('judul_foto'));
            $config['upload_path'] = FCPATH . '/uploads/galeri/';
            $config['allowed_types'] = 'jpg|jpeg|png';
            $this->load->library('upload', $config);

            if ($this->upload->do_upload('foto')) {
                $upload_data = $this->upload->data();
                $foto = $upload_data['file_name'];
                $data = array(
                    'judul_foto' => $judul_foto,
                    'foto' => $foto
                );

                $this->m_data->insert_data('galeri', $data);
                redirect('admin/galeri');
            } else {
                $upload_error = $this->upload->display_errors();
                $this->session->set_flashdata('error', $upload_error);
            }
        }
    }
    public function update_foto()
    {
        $this->check_rbac(['administrator']);
        if ($this->input->method() === 'post') {
            $id_foto = (int) $this->input->post('id_foto');
            $judul_foto = htmlspecialchars($this->input->post('judul_foto'));
            $where = "id_foto=$id_foto";

            if (!empty($_FILES['foto']['name'])) {
                $foto_lama = htmlspecialchars($this->input->post('foto_lama'));
                $old_photo_path = FCPATH . '/uploads/galeri/' . $foto_lama;
                if (file_exists($old_photo_path)) {
                    unlink($old_photo_path);
                }

                $config['upload_path'] = FCPATH . '/uploads/galeri/';
                $config['allowed_types'] = 'jpg|jpeg|png';
                // $config['overwrite'] = true;
                $this->load->library('upload', $config);

                if ($this->upload->do_upload('foto')) {
                    $upload_data = $this->upload->data();
                    $foto = $upload_data['file_name'];
                    $data = array(
                        'judul_foto' => $judul_foto,
                        'foto' => $foto
                    );

                    $this->m_data->update_data($where, $data, 'galeri');
                } else {
                    $upload_error = $this->upload->display_errors();
                    $this->session->set_flashdata('error', $upload_error);
                }
            } else {
                $foto_lama = htmlspecialchars($this->input->post('foto_lama'));
                $data = array(
                    'judul_foto' => $judul_foto,
                    'foto' => $foto_lama
                );
                $this->m_data->update_data($where, $data, 'galeri');
            }
            redirect('admin/galeri');
        }
    }

    public function delete_foto()
    {
        $this->check_rbac(['administrator']);
        $id_foto = (int) $this->input->post('id_foto');
        $foto = htmlspecialchars($this->input->post('foto'));
        $where = "id_foto=$id_foto";
        if (!empty($id_foto)) {
            $this->m_data->delete_data_gfoto($where, 'galeri', $foto);
        }
        redirect('admin/galeri');
    }

    // ================================================
    // ============= PPDB SD Management ==============
    // ================================================

    public function pendaftaran_sd()
    {
        $this->check_rbac(['admin_sd']);
        $data_pendaftaran = $this->m_data->get_data('pendaftaran_sd')->result_array();
        $data = [
            "menu" => 'pendaftaran_sd',
            'data_pendaftaran' => $data_pendaftaran
        ];
        $this->load->view('./templates/admin/header', $data);
        $this->load->view('./admin/pendaftaran_sd');
        $this->load->view('./templates/admin/modals');
        $this->load->view('./templates/admin/footer');
    }

    public function update_status_sd()
    {
        $this->check_rbac(['admin_sd']);
        if ($this->input->method() === 'post') {
            $id_pendaftaran = (int) $this->input->post('id_pendaftaran');
            $status = htmlspecialchars($this->input->post('status'));
            $where = "id_pendaftaran=$id_pendaftaran";

            $data = ['status' => $status];
            $this->m_data->update_data($where, $data, 'pendaftaran_sd');
            redirect('admin/pendaftaran_sd');
        }
    }

    public function delete_pendaftaran_sd()
    {
        $this->check_rbac(['admin_sd']);
        $id_pendaftaran = (int) $this->input->post('id_pendaftaran');
        $where = "id_pendaftaran=$id_pendaftaran";
        if (!empty($id_pendaftaran)) {
            $this->m_data->delete_data($where, 'pendaftaran_sd');
        }
        redirect('admin/pendaftaran_sd');
    }

    // ================================================
    // ============= PPDB TK Management ==============
    // ================================================

    public function pendaftaran_tk()
    {
        $this->check_rbac(['admin_tk']);
        $data_pendaftaran = $this->m_data->get_data('pendaftaran_tk')->result_array();
        $data = [
            "menu" => 'pendaftaran_tk',
            'data_pendaftaran' => $data_pendaftaran
        ];
        $this->load->view('./templates/admin/header', $data);
        $this->load->view('./admin/pendaftaran_tk');
        $this->load->view('./templates/admin/modals');
        $this->load->view('./templates/admin/footer');
    }

    public function update_status_tk()
    {
        $this->check_rbac(['admin_tk']);
        if ($this->input->method() === 'post') {
            $id_pendaftaran = (int) $this->input->post('id_pendaftaran');
            $status = htmlspecialchars($this->input->post('status'));
            $where = "id_pendaftaran=$id_pendaftaran";

            $data = ['status' => $status];
            $this->m_data->update_data($where, $data, 'pendaftaran_tk');
            redirect('admin/pendaftaran_tk');
        }
    }

    public function delete_pendaftaran_tk()
    {
        $this->check_rbac(['admin_tk']);
        $id_pendaftaran = (int) $this->input->post('id_pendaftaran');
        $where = "id_pendaftaran=$id_pendaftaran";
        if (!empty($id_pendaftaran)) {
            $this->m_data->delete_data($where, 'pendaftaran_tk');
        }
        redirect('admin/pendaftaran_tk');
    }

    // =========================================================================
    // ============= INT-03: RBAC Helper =======================================
    // =========================================================================
    private function check_rbac($allowed_roles = [])
    {
        $role = $this->session->userdata('role');
        if ($role === 'administrator' || $role === 'default') {
            return true;
        }
        if (in_array($role, $allowed_roles)) {
            return true;
        }
        $this->session->set_flashdata('error', 'Anda tidak memiliki hak akses untuk halaman tersebut.');
        redirect(base_url('admin'));
        exit();
    }

    // =========================================================================
    // ============= INT-03: PPDB Terpadu Management ===========================
    // =========================================================================
    public function pendaftaran_terpadu()
    {
        $jenjang = $this->input->get('jenjang', TRUE);
        $status = $this->input->get('status', TRUE);

        $role = $this->session->userdata('role');
        // Auto filter for unit admins
        if ($role === 'admin_tk') $jenjang = 'TK';
        elseif ($role === 'admin_sd') $jenjang = 'SD';
        elseif ($role === 'admin_smp') $jenjang = 'SMP';
        elseif ($role === 'admin_sma') $jenjang = 'SMA';
        elseif ($role === 'admin_ucb') $jenjang = 'UCB';

        if (!empty($jenjang)) {
            $this->db->where('jenjang', $jenjang);
        }
        if (!empty($status)) {
            $this->db->where('status', $status);
        }

        $this->db->order_by('id_pendaftaran', 'DESC');
        $data_pendaftaran = $this->db->get('pendaftaran')->result_array();

        $data = [
            'menu' => 'pendaftaran_terpadu',
            'data_pendaftaran' => $data_pendaftaran,
            'filter_jenjang' => $jenjang,
            'filter_status' => $status
        ];

        $this->load->view('./templates/admin/header', $data);
        $this->load->view('./admin/pendaftaran_terpadu', $data);
        $this->load->view('./templates/admin/modals');
        $this->load->view('./templates/admin/footer');
    }

    public function update_status_pendaftaran()
    {
        if ($this->input->method() === 'post') {
            $id = (int)$this->input->post('id_pendaftaran');
            $status = htmlspecialchars($this->input->post('status'));
            $this->db->where('id_pendaftaran', $id)->update('pendaftaran', ['status' => $status]);
            $this->session->set_flashdata('success', 'Status pendaftaran berhasil diperbarui.');
            redirect('admin/pendaftaran_terpadu');
        }
    }

    public function delete_pendaftaran()
    {
        $this->check_rbac(['administrator']);
        if ($this->input->method() === 'post') {
            $id = (int)$this->input->post('id_pendaftaran');
            $this->db->where('id_pendaftaran', $id)->delete('pendaftaran');
            $this->session->set_flashdata('success', 'Data pendaftaran berhasil dihapus.');
            redirect('admin/pendaftaran_terpadu');
        }
    }

    public function export_pendaftaran_csv()
    {
        $this->load->dbutil();
        $this->load->helper('download');

        $query = $this->db->query("SELECT no_registrasi, jenjang, nama_lengkap, nik_nisn, jenis_kelamin, tempat_lahir, tgl_lahir, agama, nama_ortu, pekerjaan_ortu, no_hp, email, alamat, asal_sekolah, catatan, status, tanggal_daftar FROM pendaftaran ORDER BY id_pendaftaran DESC");
        $delimiter = ",";
        $newline = "\r\n";
        $enclosure = '"';

        $csv = $this->dbutil->csv_from_result($query, $delimiter, $newline, $enclosure);
        force_download('data_ppdb_cbim_' . date('Ymd_His') . '.csv', $csv);
    }

    // =========================================================================
    // ============= BE-07: Pesan Masuk Kontak Management =======================
    // =========================================================================
    public function pesan_kontak()
    {
        $this->check_rbac(['administrator']);

        $this->db->order_by('id_pesan', 'DESC');
        $data_pesan = $this->db->get('pesan_kontak')->result_array();

        $data = [
            'menu' => 'pesan_kontak',
            'data_pesan' => $data_pesan
        ];

        $this->load->view('./templates/admin/header', $data);
        $this->load->view('./admin/pesan_kontak', $data);
        $this->load->view('./templates/admin/modals');
        $this->load->view('./templates/admin/footer');
    }

    public function update_status_pesan()
    {
        $this->check_rbac(['administrator']);
        if ($this->input->method() === 'post') {
            $id = (int)$this->input->post('id_pesan');
            $status = htmlspecialchars($this->input->post('status'));
            $this->db->where('id_pesan', $id)->update('pesan_kontak', ['status' => $status]);
            $this->session->set_flashdata('success', 'Status pesan berhasil diperbarui.');
            redirect('admin/pesan_kontak');
        }
    }

    public function delete_pesan()
    {
        $this->check_rbac(['administrator']);
        if ($this->input->method() === 'post') {
            $id = (int)$this->input->post('id_pesan');
            $this->db->where('id_pesan', $id)->delete('pesan_kontak');
            $this->session->set_flashdata('success', 'Pesan berhasil dihapus.');
            redirect('admin/pesan_kontak');
        }
    }

    // =========================================================================
    // ============= INT-04: Newsletter Subscribers Management =================
    // =========================================================================
    public function newsletter()
    {
        $this->check_rbac(['administrator']);

        $this->db->order_by('id_subscriber', 'DESC');
        $subscribers = $this->db->get('newsletter_subscribers')->result_array();

        $data = [
            'menu' => 'newsletter',
            'subscribers' => $subscribers
        ];

        $this->load->view('./templates/admin/header', $data);
        $this->load->view('./admin/newsletter', $data);
        $this->load->view('./templates/admin/modals');
        $this->load->view('./templates/admin/footer');
    }

    public function delete_subscriber()
    {
        $this->check_rbac(['administrator']);
        if ($this->input->method() === 'post') {
            $id = (int)$this->input->post('id_subscriber');
            $this->db->where('id_subscriber', $id)->delete('newsletter_subscribers');
            $this->session->set_flashdata('success', 'Subscriber berhasil dihapus.');
            redirect('admin/newsletter');
        }
    }

    // =========================================================================
    // ============= BE-08: Backup Sistem Module ===============================
    // =========================================================================
    public function backup()
    {
        $this->check_rbac(['administrator']);

        $backup_dir = FCPATH . 'uploads/backups/';
        $backup_files = [];
        if (is_dir($backup_dir)) {
            $files = scandir($backup_dir);
            foreach ($files as $f) {
                if ($f !== '.' && $f !== '..' && $f !== 'index.html') {
                    $backup_files[] = [
                        'name' => $f,
                        'size' => round(filesize($backup_dir . $f) / 1024, 2) . ' KB',
                        'time' => date('Y-m-d H:i:s', filemtime($backup_dir . $f))
                    ];
                }
            }
        }

        $data = [
            'menu' => 'backup',
            'backup_files' => $backup_files
        ];

        $this->load->view('./templates/admin/header', $data);
        $this->load->view('./admin/backup', $data);
        $this->load->view('./templates/admin/modals');
        $this->load->view('./templates/admin/footer');
    }
}