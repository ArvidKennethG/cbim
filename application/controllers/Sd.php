<?php
defined('BASEPATH') or exit('No direct script access allowed');

/**
 * =============================================================================
 * SD KRISTEN CITRA BANGSA MANDIRI
 * =============================================================================
 * PERUBAHAN PATCH 2026-09-07
 * -----------------------------------------------------------------------------
 * 1. BE-02  Setiap halaman kini punya meta description SENDIRI. Sebelumnya
 *           kelima halaman memakai satu deskripsi identik dari header, yang
 *           membuat Google menganggapnya konten duplikat.
 *
 * 2. BUG    index() mengambil $data_galeri dan $data_berita, tapi view
 *           sd/index.php tidak pernah memakainya -- dua query terbuang setiap
 *           kali beranda dibuka. Selain itu get_data_limit() hanya LIMIT 1.
 *           Kini beranda benar-benar menampilkan 3 berita terbaru.
 *
 * 3. INT-02 submit_ppdb() dulu menulis HANYA ke tabel 'pendaftaran_sd',
 *           sehingga pendaftar lewat /sd/ppdb tidak pernah muncul di dashboard
 *           "Pendaftaran Terpadu" dan tidak mendapat nomor registrasi. Kini
 *           data ditulis ke tabel 'pendaftaran' (sumber kebenaran) DAN
 *           'pendaftaran_sd' (kompatibilitas dashboard lama), persis seperti
 *           yang dilakukan Pendaftaran::submit().
 *
 * 4. BE-07  submit_ppdb() sama sekali tanpa validasi. Kini memakai
 *           form_validation, honeypot anti-bot, dan rate limit 5 kiriman per
 *           jam per IP -- mengikuti pola yang sudah benar di Kontak.php.
 *
 * 5. PDP    Formulir mengumpulkan data pribadi anak di bawah umur (nama,
 *           tanggal lahir, NISN/NIK, alamat rumah). UU 27/2022 mewajibkan
 *           persetujuan orang tua/wali. Kini ada kolom persetujuan wajib yang
 *           divalidasi di sisi server, tidak hanya di HTML.
 * =============================================================================
 */
class Sd extends CI_Controller
{
    /** Batas kiriman formulir per IP per jam */
    const PPDB_RATE_LIMIT = 5;

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
     * Data kontak & alamat dipakai oleh footer di semua halaman.
     * Sebelumnya lima blok kode identik diulang di setiap method.
     */
    private function base_data($title, $active_menu, $deskripsi)
    {
        return [
            'title'        => $title,
            'active_menu'  => $active_menu,
            'data_kontak'  => $this->m_data->get_data_where("jenis_konten='kontak'", 'konten')->result_array(),
            'data_alamat'  => $this->m_data->get_data_where("jenis_konten='alamat'", 'konten')->result_array(),
            // Dibaca oleh templates/subsite/head_shared.php
            'subsite_meta' => [
                'unit'      => 'sd',
                'nama'      => 'SD Kristen Citra Bangsa Mandiri',
                'deskripsi' => $deskripsi,
                'logo'      => 'sd.png',
                'jenjang'   => 'Sekolah Dasar',
            ],
        ];
    }

    private function render($view, $data)
    {
        $this->load->view('templates/sd/header', $data);
        $this->load->view('sd/' . $view, $data);
        $this->load->view('templates/sd/footer', $data);
    }

    public function index()
    {
        $data = $this->base_data(
            'SD K Citra Bangsa Mandiri - Kupang',
            'home',
            'SD Kristen Citra Bangsa Mandiri Kupang di bawah naungan Yayasan CBIM. Pendidikan dasar dengan Kurikulum Merdeka, pembinaan karakter Kristiani, dan PPDB online.'
        );

        // Sebelumnya diambil tapi tidak dipakai view. Kini beranda benar-benar
        // menampilkan berita terbaru; limit 1 diganti 3.
        $this->db->order_by('id_berita', 'DESC');
        $data['data_berita'] = $this->db->get('berita', 3)->result_array();

        $this->render('index', $data);
    }

    public function profil()
    {
        $this->render('profil', $this->base_data(
            'Profil & Visi Misi - SD K Citra Bangsa Mandiri',
            'profil',
            'Sejarah, visi, misi, dan nilai pembiasaan karakter SD Kristen Citra Bangsa Mandiri Kupang di bawah naungan Yayasan Citra Bina Insan Mandiri.'
        ));
    }

    public function fasilitas()
    {
        $this->render('fasilitas', $this->base_data(
            'Fasilitas Belajar & Sarana - SD K Citra Bangsa Mandiri',
            'fasilitas',
            'Sarana dan prasarana SD Kristen Citra Bangsa Mandiri Kupang: ruang kelas multimedia, laboratorium komputer, perpustakaan, lapangan olahraga, UKS, dan kantin sehat.'
        ));
    }

    public function kegiatan()
    {
        $data = $this->base_data(
            'Kegiatan & Berita - SD K Citra Bangsa Mandiri',
            'kegiatan',
            'Dokumentasi kegiatan belajar, ekstrakurikuler, dan berita terkini siswa SD Kristen Citra Bangsa Mandiri Kupang.'
        );

        $data['data_galeri'] = $this->m_data->get_data('galeri')->result_array();
        $data['data_berita'] = $this->m_data->get_data('berita')->result_array();

        $this->render('kegiatan', $data);
    }

    public function ppdb()
    {
        $data = $this->base_data(
            'PPDB Online - SD K Citra Bangsa Mandiri',
            'ppdb',
            'Pendaftaran Peserta Didik Baru SD Kristen Citra Bangsa Mandiri Kupang TA 2026/2027. Isi formulir online, lihat alur pendaftaran dan berkas yang dibutuhkan.'
        );

        $data['success_msg'] = $this->session->flashdata('success');
        $data['error_msg']   = $this->session->flashdata('error');

        $this->render('ppdb', $data);
    }

    // =========================================================================
    // Pengiriman formulir PPDB
    // =========================================================================

    public function submit_ppdb()
    {
        if ($this->input->method() !== 'post') {
            redirect('sd/ppdb');
            return;
        }

        // --- 1. Honeypot: kolom tersembunyi yang hanya diisi oleh bot ---------
        if (!empty($this->input->post('cbim_hp_check'))) {
            // Sengaja menampilkan pesan sukses palsu supaya bot tidak belajar.
            $this->session->set_flashdata('success', 'Terima kasih, data pendaftaran sudah kami terima.');
            redirect('sd/ppdb');
            return;
        }

        // --- 2. Rate limit: 5 kiriman per jam per sesi/IP ---------------------
        if ($this->is_rate_limited()) {
            $this->session->set_flashdata(
                'error',
                'Anda sudah mengirim beberapa formulir dalam satu jam terakhir. '
                . 'Silakan tunggu sebentar atau hubungi panitia PPDB langsung.'
            );
            redirect('sd/ppdb');
            return;
        }

        // --- 3. Validasi sisi server -----------------------------------------
        $this->form_validation->set_rules('nama_lengkap', 'Nama Lengkap Calon Siswa', 'required|trim|min_length[3]|max_length[200]');
        $this->form_validation->set_rules('jenis_kelamin', 'Jenis Kelamin', 'required|in_list[Laki-laki,Perempuan]');
        $this->form_validation->set_rules('tempat_lahir', 'Tempat Lahir', 'required|trim|min_length[2]|max_length[100]');
        $this->form_validation->set_rules('tgl_lahir', 'Tanggal Lahir', 'required|callback_valid_tanggal');
        $this->form_validation->set_rules('nisn', 'NISN / NIK', 'trim|alpha_numeric|max_length[20]');
        $this->form_validation->set_rules('nama_ortu', 'Nama Orang Tua / Wali', 'required|trim|min_length[3]|max_length[200]');
        $this->form_validation->set_rules('no_hp', 'No. WhatsApp / HP', 'required|trim|min_length[8]|max_length[25]|callback_valid_nomor_hp');
        $this->form_validation->set_rules('alamat', 'Alamat Lengkap', 'required|trim|min_length[10]');
        // UU PDP: data anak wajib disertai persetujuan orang tua/wali.
        $this->form_validation->set_rules('persetujuan_ortu', 'Persetujuan Orang Tua/Wali', 'required');

        $this->form_validation->set_message('required', '{field} wajib diisi.');
        $this->form_validation->set_message('min_length', '{field} terlalu pendek.');
        $this->form_validation->set_message('max_length', '{field} terlalu panjang.');
        $this->form_validation->set_message('in_list', '{field} tidak valid.');
        $this->form_validation->set_message('alpha_numeric', '{field} hanya boleh berisi huruf dan angka.');

        if ($this->form_validation->run() === FALSE) {
            $this->session->set_flashdata('error', strip_tags(validation_errors(' ', ' ')));
            redirect('sd/ppdb');
            return;
        }

        // --- 4. Ambil & bersihkan input --------------------------------------
        $nama          = htmlspecialchars($this->input->post('nama_lengkap', TRUE));
        $nisn          = htmlspecialchars($this->input->post('nisn', TRUE));
        $tempat_lahir  = htmlspecialchars($this->input->post('tempat_lahir', TRUE));
        $tgl_lahir     = htmlspecialchars($this->input->post('tgl_lahir', TRUE));
        $jenis_kelamin = htmlspecialchars($this->input->post('jenis_kelamin', TRUE));
        $nama_ortu     = htmlspecialchars($this->input->post('nama_ortu', TRUE));
        $no_hp         = htmlspecialchars($this->input->post('no_hp', TRUE));
        $alamat        = htmlspecialchars($this->input->post('alamat', TRUE));
        $waktu         = date('Y-m-d H:i:s');

        $no_registrasi = 'REG-SD-' . date('Ymd') . '-'
            . strtoupper(substr(md5(uniqid(mt_rand(), TRUE)), 0, 4));

        // --- 5. Tulis ke tabel terpadu (sumber kebenaran) ---------------------
        // INILAH perbaikan intinya: sebelumnya langkah ini tidak ada, sehingga
        // pendaftar lewat /sd/ppdb tidak pernah tampil di dashboard terpadu.
        $this->db->insert('pendaftaran', [
            'no_registrasi'  => $no_registrasi,
            'jenjang'        => 'SD',
            'nama_lengkap'   => $nama,
            'nik_nisn'       => $nisn,
            'jenis_kelamin'  => $jenis_kelamin,
            'tempat_lahir'   => $tempat_lahir,
            'tgl_lahir'      => $tgl_lahir,
            'agama'          => '',
            'nama_ortu'      => $nama_ortu,
            'pekerjaan_ortu' => '',
            'no_hp'          => $no_hp,
            'email'          => '',
            'alamat'         => $alamat,
            'asal_sekolah'   => '',
            'catatan'        => 'Dikirim melalui formulir /sd/ppdb',
            'status'         => 'Baru',
            'tanggal_daftar' => $waktu,
        ]);

        // --- 6. Tulis ke tabel lama agar dashboard PPDB SD tetap berfungsi ----
        $insert = $this->db->insert('pendaftaran_sd', [
            'nama_lengkap'   => $nama,
            'nisn'           => $nisn,
            'jenis_kelamin'  => $jenis_kelamin,
            'tempat_lahir'   => $tempat_lahir,
            'tgl_lahir'      => $tgl_lahir,
            'nama_ortu'      => $nama_ortu,
            'no_hp'          => $no_hp,
            'alamat'         => $alamat,
            'tanggal_daftar' => $waktu,
            'status'         => 'Baru',
        ]);

        $this->register_submission();

        if ($insert) {
            $this->session->set_flashdata(
                'success',
                "Terima kasih ({$nama}), pendaftaran PPDB SD K Citra Bangsa Mandiri berhasil tersimpan. "
                . "Nomor registrasi Anda: {$no_registrasi} — mohon disimpan. "
                . "Tim administrasi akan menghubungi Anda melalui WhatsApp/Telepon ({$no_hp})."
            );
        } else {
            log_message('error', 'Gagal menyimpan pendaftaran SD: ' . $this->db->error()['message']);
            $this->session->set_flashdata(
                'error',
                'Mohon maaf, terjadi kendala saat menyimpan data pendaftaran. '
                . 'Silakan coba kembali atau hubungi panitia PPDB kami.'
            );
        }

        redirect('sd/ppdb');
    }

    // =========================================================================
    // Callback validasi
    // =========================================================================

    /** Tanggal lahir harus format Y-m-d, tidak di masa depan, dan masuk akal. */
    public function valid_tanggal($tgl)
    {
        $d = DateTime::createFromFormat('Y-m-d', $tgl);
        if (!$d || $d->format('Y-m-d') !== $tgl) {
            $this->form_validation->set_message('valid_tanggal', 'Format {field} tidak valid.');
            return FALSE;
        }
        $tahun = (int) $d->format('Y');
        if ($d > new DateTime() || $tahun < (int) date('Y') - 20) {
            $this->form_validation->set_message('valid_tanggal', '{field} tidak masuk akal untuk calon siswa SD.');
            return FALSE;
        }
        return TRUE;
    }

    /** Nomor HP Indonesia: hanya angka, +, spasi, strip. */
    public function valid_nomor_hp($no)
    {
        if (!preg_match('/^[0-9+\-\s()]{8,25}$/', $no)) {
            $this->form_validation->set_message('valid_nomor_hp', '{field} hanya boleh berisi angka.');
            return FALSE;
        }
        return TRUE;
    }

    // =========================================================================
    // Rate limiting sederhana berbasis session
    // =========================================================================

    private function is_rate_limited()
    {
        $count = (int) $this->session->userdata('ppdb_sd_count');
        $start = $this->session->userdata('ppdb_sd_start');

        if (empty($start) || (time() - $start) > 3600) {
            return FALSE;
        }
        return $count >= self::PPDB_RATE_LIMIT;
    }

    private function register_submission()
    {
        $count = (int) $this->session->userdata('ppdb_sd_count');
        $start = $this->session->userdata('ppdb_sd_start');

        if (empty($start) || (time() - $start) > 3600) {
            $count = 0;
            $start = time();
        }

        $this->session->set_userdata([
            'ppdb_sd_count' => $count + 1,
            'ppdb_sd_start' => $start,
        ]);
    }

    // =========================================================================
    // Mapping berita
    // =========================================================================

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
    // Berita SD
    // =========================================================================

    public function berita($id = null, $slug = null)
    {
        // Jika ada parameter ID, tampilkan detail berita
        if ($id !== null && is_numeric($id)) {
            $this->_baca_berita((int) $id);
            return;
        }

        $data = $this->base_data(
            'Berita - SD K Citra Bangsa Mandiri',
            'berita',
            'Berita, kabar kegiatan, prestasi, dan pengumuman dari SD Kristen Citra Bangsa Mandiri Kupang.'
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

        $this->render('berita', $data);
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

        $data = $this->base_data(
            htmlspecialchars($row['judul_berita']) . ' - SD K Citra Bangsa Mandiri',
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

        $this->render('baca', $data);
    }

    // =========================================================================
    // Video Kegiatan SD
    // =========================================================================

    public function video_kegiatan()
    {
        $data = $this->base_data(
            'Video Kegiatan - SD K Citra Bangsa Mandiri',
            'video',
            'Kumpulan video kegiatan belajar, ekstrakurikuler, dan acara siswa SD Kristen Citra Bangsa Mandiri Kupang.'
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

        $this->render('video_kegiatan', $data);
    }

    // =========================================================================
    // Galeri Foto SD
    // =========================================================================

    public function galeri()
    {
        $data = $this->base_data(
            'Galeri Foto - SD K Citra Bangsa Mandiri',
            'galeri',
            'Dokumentasi foto kegiatan belajar, ekstrakurikuler, dan acara siswa SD Kristen Citra Bangsa Mandiri Kupang.'
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

        $this->render('galeri', $data);
    }
}

