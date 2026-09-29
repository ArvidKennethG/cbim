<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Tk extends CI_Controller
{
    public function __construct()
    {
        parent::__construct();
        $this->load->model('m_data');
        $this->load->model('visitors_log');
        $this->load->library('form_validation');
        $this->load->helper('yayasan');
        $ip_address = $this->input->ip_address();
        $this->visitors_log->log_visitor($ip_address);
    }

    /**
     * Data dasar yang dipakai di semua halaman TK (kontak, alamat, subsite_meta).
     */
    private function _base_data($title, $active_menu, $deskripsi)
    {
        return [
            'title'        => $title,
            'active_menu'  => $active_menu,
            'data_kontak'  => $this->m_data->get_data_where("jenis_konten='kontak'", 'konten')->result_array(),
            'data_alamat'  => $this->m_data->get_data_where("jenis_konten='alamat'", 'konten')->result_array(),
            'subsite_meta' => [
                'unit'      => 'tk',
                'nama'      => 'TK & PAUD Kristen Citra Bangsa Mandiri',
                'deskripsi' => $deskripsi,
                'logo'      => 'paud-tk.png',
                'jenjang'   => 'Taman Kanak-Kanak / PAUD',
            ],
        ];
    }

    private function _render($view, $data)
    {
        $this->load->view('templates/tk/header', $data);
        $this->load->view('tk/' . $view, $data);
        $this->load->view('templates/tk/footer', $data);
    }

    /**
     * Mapping data berita mentah ke format yang dipakai view.
     */
    private function _map_berita($data_berita)
    {
        $mapped = [];
        foreach ($data_berita as $b) {
            $slug = strtolower(trim(preg_replace('/[^A-Za-z0-9-]+/', '-', $b['judul_berita'])));
            $mapped[] = [
                'id'           => $b['id_berita'],
                'slug'         => $slug,
                'gambar'       => $b['gambar'],
                'kategori'     => 'umum',
                'judul'        => $b['judul_berita'],
                'ringkasan'    => strip_tags(substr($b['isi_berita'], 0, 150)),
                'isi'          => $b['isi_berita'],
                'tanggal_post' => $b['tanggal_post'],
                'penulis'      => ''
            ];
        }
        return $mapped;
    }

    // =========================================================================
    // Halaman-halaman utama (yang sudah ada)
    // =========================================================================

    public function index()
    {
        $data = $this->_base_data(
            'TK & PAUD K Citra Bangsa Mandiri - Kupang',
            'home',
            'TK & PAUD Kristen Citra Bangsa Mandiri Kupang di bawah naungan Yayasan CBIM. Pendidikan anak usia dini yang ramah anak, kreatif, dan berlandaskan kasih.'
        );

        $data['data_galeri'] = $this->m_data->get_data('galeri')->result_array();

        $this->_render('index', $data);
    }

    public function profil()
    {
        $data = $this->_base_data(
            'Profil & Kurikulum - TK K Citra Bangsa Mandiri',
            'profil',
            'Sejarah, visi, misi, dan nilai pembiasaan TK & PAUD Kristen Citra Bangsa Mandiri Kupang di bawah naungan Yayasan Citra Bina Insan Mandiri.'
        );

        $this->_render('profil', $data);
    }

    public function program()
    {
        $data = $this->_base_data(
            'Program & Kurikulum - TK K Citra Bangsa Mandiri',
            'program',
            'Program pendidikan, kegiatan harian, kurikulum terpadu, dan ekstrakurikuler di TK & PAUD Kristen Citra Bangsa Mandiri Kupang.'
        );

        $this->_render('program', $data);
    }

    public function ppdb()
    {
        $data = $this->_base_data(
            'Pendaftaran Siswa Baru - TK K Citra Bangsa Mandiri',
            'ppdb',
            'Pendaftaran Peserta Didik Baru TK & PAUD Kristen Citra Bangsa Mandiri Kupang TA 2026/2027. Formulir online, alur pendaftaran, dan berkas yang dibutuhkan.'
        );

        $data['success_msg'] = $this->session->flashdata('success');
        $data['error_msg']   = $this->session->flashdata('error');

        $this->_render('ppdb', $data);
    }

    /**
     * =========================================================================
     * PATCH 2026-09-07 -- lihat catatan lengkap di Sd.php
     * Sebelumnya: tanpa validasi, tanpa honeypot, tanpa rate limit, dan hanya
     * menulis ke tabel 'pendaftaran_tk' sehingga pendaftar lewat /tk/ppdb tidak
     * pernah muncul di dashboard Pendaftaran Terpadu.
     * =========================================================================
     */
    public function submit_ppdb()
    {
        if ($this->input->method() !== 'post') {
            redirect('tk/ppdb');
            return;
        }

        // Honeypot anti-bot
        if (!empty($this->input->post('cbim_hp_check'))) {
            $this->session->set_flashdata('success', 'Terima kasih, data pendaftaran sudah kami terima.');
            redirect('tk/ppdb');
            return;
        }

        // Rate limit 5 kiriman per jam
        $count = (int) $this->session->userdata('ppdb_tk_count');
        $start = $this->session->userdata('ppdb_tk_start');
        if (!empty($start) && (time() - $start) <= 3600 && $count >= 5) {
            $this->session->set_flashdata('error', 'Anda sudah mengirim beberapa formulir dalam satu jam terakhir. Silakan tunggu sebentar atau hubungi panitia PPDB.');
            redirect('tk/ppdb');
            return;
        }

        // Validasi sisi server
        $this->form_validation->set_rules('nama_lengkap', 'Nama Lengkap Ananda', 'required|trim|min_length[3]|max_length[200]');
        $this->form_validation->set_rules('jenis_kelamin', 'Jenis Kelamin', 'required|in_list[Laki-laki,Perempuan]');
        $this->form_validation->set_rules('tgl_lahir', 'Tanggal Lahir', 'required');
        $this->form_validation->set_rules('nama_ortu', 'Nama Orang Tua / Wali', 'required|trim|min_length[3]|max_length[200]');
        $this->form_validation->set_rules('no_hp', 'No. WhatsApp / HP', 'required|trim|min_length[8]|max_length[25]');
        $this->form_validation->set_rules('alamat', 'Alamat Lengkap', 'required|trim|min_length[10]');
        // UU PDP: data anak wajib disertai persetujuan orang tua/wali
        $this->form_validation->set_rules('persetujuan_ortu', 'Persetujuan Orang Tua/Wali', 'required');
        $this->form_validation->set_message('required', '{field} wajib diisi.');

        if ($this->form_validation->run() === FALSE) {
            $this->session->set_flashdata('error', strip_tags(validation_errors(' ', ' ')));
            redirect('tk/ppdb');
            return;
        }

        $nama          = htmlspecialchars($this->input->post('nama_lengkap', TRUE));
        $kelompok      = htmlspecialchars($this->input->post('kelompok', TRUE));
        $tgl_lahir     = htmlspecialchars($this->input->post('tgl_lahir', TRUE));
        $jenis_kelamin = htmlspecialchars($this->input->post('jenis_kelamin', TRUE));
        $nama_ortu     = htmlspecialchars($this->input->post('nama_ortu', TRUE));
        $no_hp         = htmlspecialchars($this->input->post('no_hp', TRUE));
        $alamat        = htmlspecialchars($this->input->post('alamat', TRUE));
        $waktu         = date('Y-m-d H:i:s');

        $no_registrasi = 'REG-TK-' . date('Ymd') . '-'
            . strtoupper(substr(md5(uniqid(mt_rand(), TRUE)), 0, 4));

        // Tabel terpadu -- inilah yang dibaca dashboard Pendaftaran Terpadu
        $this->db->insert('pendaftaran', [
            'no_registrasi'  => $no_registrasi,
            'jenjang'        => 'TK',
            'nama_lengkap'   => $nama,
            'nik_nisn'       => '',
            'jenis_kelamin'  => $jenis_kelamin,
            'tempat_lahir'   => '',
            'tgl_lahir'      => $tgl_lahir,
            'agama'          => '',
            'nama_ortu'      => $nama_ortu,
            'pekerjaan_ortu' => '',
            'no_hp'          => $no_hp,
            'email'          => '',
            'alamat'         => $alamat,
            'asal_sekolah'   => '',
            'catatan'        => 'Kelompok: ' . $kelompok . ' (dikirim melalui formulir /tk/ppdb)',
            'status'         => 'Baru',
            'tanggal_daftar' => $waktu,
        ]);

        // Tabel lama untuk kompatibilitas dashboard PPDB TK
        $insert = $this->db->insert('pendaftaran_tk', [
            'nama_lengkap'   => $nama,
            'kelompok'       => $kelompok,
            'jenis_kelamin'  => $jenis_kelamin,
            'tgl_lahir'      => $tgl_lahir,
            'nama_ortu'      => $nama_ortu,
            'no_hp'          => $no_hp,
            'alamat'         => $alamat,
            'tanggal_daftar' => $waktu,
            'status'         => 'Baru',
        ]);

        if (empty($start) || (time() - $start) > 3600) {
            $count = 0;
            $start = time();
        }
        $this->session->set_userdata(['ppdb_tk_count' => $count + 1, 'ppdb_tk_start' => $start]);

        if ($insert) {
            $this->session->set_flashdata(
                'success',
                "Selamat! Pendaftaran Ananda ({$nama}) untuk kelas {$kelompok} di TK K Citra Bangsa Mandiri telah tersimpan. "
                . "Nomor registrasi: {$no_registrasi} — mohon disimpan. "
                . "Tim administrasi akan menghubungi Ayah/Bunda via WhatsApp ({$no_hp})."
            );
        } else {
            log_message('error', 'Gagal menyimpan pendaftaran TK: ' . $this->db->error()['message']);
            $this->session->set_flashdata('error', 'Mohon maaf, terjadi kendala saat menyimpan data pendaftaran. Silakan coba kembali atau hubungi panitia PPDB TK kami.');
        }

        redirect('tk/ppdb');
    }

    /**
     * PERBAIKAN: view tk/fasilitas.php dan tk/kegiatan.php tidak pernah ada,
     * sehingga /tk/fasilitas dan /tk/kegiatan dulu galat 500 ("Unable to load
     * the requested file") -- padahal keduanya tercantum di sitemap.xml.
     * Menu TK memakai "Program" dan "Galeri" untuk isi yang sama, jadi URL lama
     * dialihkan permanen (301) ke sana.
     */
    public function fasilitas()
    {
        redirect('tk/program', 'location', 301);
    }

    public function kegiatan()
    {
        redirect('tk/galeri', 'location', 301);
    }

    // =========================================================================
    // Berita TK
    // =========================================================================

    public function berita($id = null, $slug = null)
    {
        // Jika ada parameter ID, tampilkan detail berita
        if ($id !== null && is_numeric($id)) {
            $this->_baca_berita((int) $id);
            return;
        }

        $data = $this->_base_data(
            'Berita - TK K Citra Bangsa Mandiri',
            'berita',
            'Berita, kabar kegiatan, prestasi, dan pengumuman dari TK & PAUD Kristen Citra Bangsa Mandiri Kupang.'
        );

        $hal = (int)($this->input->get('hal') ?? 1);
        if ($hal < 1) $hal = 1;
        $limit  = 9;
        $offset = ($hal - 1) * $limit;

        $semua_berita = $this->_map_berita($this->m_data->get_data('berita')->result_array());

        $total_hal = max(1, ceil(count($semua_berita) / $limit));
        $data['berita']    = array_slice($semua_berita, $offset, $limit);
        $data['hal']       = $hal;
        $data['total_hal'] = $total_hal;

        $this->_render('berita', $data);
    }

    /**
     * Detail berita (dipanggil dari berita() ketika ada parameter $id).
     */
    private function _baca_berita($id)
    {
        $row = $this->db->get_where('berita', ['id_berita' => $id])->row_array();

        if (empty($row)) {
            show_404();
            return;
        }

        $data = $this->_base_data(
            htmlspecialchars($row['judul_berita']) . ' - TK K Citra Bangsa Mandiri',
            'berita',
            strip_tags(substr($row['isi_berita'], 0, 160))
        );

        $slug = strtolower(trim(preg_replace('/[^A-Za-z0-9-]+/', '-', $row['judul_berita'])));
        $data['berita'] = [
            'id'           => $row['id_berita'],
            'slug'         => $slug,
            'gambar'       => $row['gambar'],
            'kategori'     => 'umum',
            'judul'        => $row['judul_berita'],
            'isi'          => $row['isi_berita'],
            'tanggal_post' => $row['tanggal_post'],
            'penulis'      => ''
        ];

        // Berita lainnya (3 terakhir, kecuali yang sedang dibaca)
        $this->db->where('id_berita !=', $id)->order_by('id_berita', 'DESC')->limit(3);
        $data['lain'] = $this->_map_berita($this->db->get('berita')->result_array());

        $this->_render('baca', $data);
    }

    // =========================================================================
    // Video Kegiatan TK
    // =========================================================================

    public function video_kegiatan()
    {
        $data = $this->_base_data(
            'Video Kegiatan - TK K Citra Bangsa Mandiri',
            'video',
            'Kumpulan video kegiatan bermain, belajar, dan acara di TK & PAUD Kristen Citra Bangsa Mandiri Kupang.'
        );

        $data_all_video = $this->m_data->get_data('video_kegiatan')->result_array();
        $video_mapped = [];
        foreach ($data_all_video as $v) {
            preg_match('%(?:youtube(?:-nocookie)?\.com/(?:[^/]+/.+/|(?:v|e(?:mbed)?)/|.*[?&]v=)|youtu\.be/)([^"&?/\s]{11})%i', $v['link'], $match);
            $ytId = isset($match[1]) ? $match[1] : '';
            $video_mapped[] = [
                'id'         => $v['id_video'],
                'youtube_id' => $ytId,
                'thumb'      => $ytId ? "https://img.youtube.com/vi/{$ytId}/hqdefault.jpg" : '',
                'judul'      => $v['judul_video'],
                'deskripsi'  => $v['deskripsi'],
                'tanggal'    => ''
            ];
        }
        $data['video'] = $video_mapped;

        // Galeri foto untuk section bawah
        $data_galeri = $this->m_data->get_data('galeri')->result_array();
        $galeri_mapped = [];
        foreach ($data_galeri as $g) {
            $galeri_mapped[] = [
                'foto'  => $g['foto'],
                'judul' => $g['judul_foto']
            ];
        }
        $data['galeri'] = $galeri_mapped;

        $this->_render('video_kegiatan', $data);
    }

    // =========================================================================
    // Galeri Foto TK
    // =========================================================================

    public function galeri()
    {
        $data = $this->_base_data(
            'Galeri Foto - TK K Citra Bangsa Mandiri',
            'galeri',
            'Dokumentasi foto kegiatan bermain, belajar, dan acara di TK & PAUD Kristen Citra Bangsa Mandiri Kupang.'
        );

        $data_galeri = $this->m_data->get_data('galeri')->result_array();
        $galeri_mapped = [];
        foreach ($data_galeri as $g) {
            $galeri_mapped[] = [
                'foto'       => $g['foto'],
                'judul'      => $g['judul_foto'],
                'keterangan' => '',
                'tanggal'    => ''
            ];
        }
        $data['galeri'] = $galeri_mapped;

        $this->_render('galeri', $data);
    }
}

