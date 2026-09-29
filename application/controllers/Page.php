<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Page extends CI_Controller
{
    public function __construct()
    {
        parent::__construct();
        $this->load->model('m_data');
        $this->load->model('visitors_log');
        $this->load->helper('yayasan');
        
        $ip_address = $this->input->ip_address();
        $this->visitors_log->log_visitor($ip_address);
    }

    private function _get_common_data($halaman, $judul_hal, $deskripsi)
    {
        $data_kontak = $this->m_data->get_data_where("jenis_konten='kontak'", 'konten')->result_array();
        $data_alamat = $this->m_data->get_data_where("jenis_konten='alamat'", 'konten')->result_array();

        $unit = [
            'logo' => 'logo-cbim.png',
            'nama' => 'Yayasan Citra Bina Insan Mandiri',
            'deskripsi' => 'Lembaga pendidikan terpadu di Nusa Tenggara Timur',
            'telepon' => !empty($data_kontak) ? strip_tags($data_kontak[0]['isi_konten']) : '(0380) 8553888',
            'email' => 'info@cbim.or.id',
            'alamat' => !empty($data_alamat) ? strip_tags($data_alamat[0]['isi_konten']) : 'Jl. Manafe No.17, Kel. Kayu Putih, Kec. Oebobo, Kota Kupang, NTT'
        ];

        $pengaturan = [
            'facebook' => 'https://www.facebook.com/profile.php?id=100086189573438',
            'instagram' => 'https://www.instagram.com/yayasan_cbim/',
            'youtube' => 'https://www.youtube.com/@CBIMYayasan',
            'teks_footer' => 'Maju Bersama Generasi Unggul Nusa Tenggara Timur'
        ];

        return [
            'unit' => $unit,
            'pengaturan' => $pengaturan,
            'judul_hal' => $judul_hal,
            'deskripsi' => $deskripsi,
            'halaman' => $halaman
        ];
    }

    private function _map_berita($data_berita)
    {
        $mapped = [];
        foreach ($data_berita as $b) {
            $slug = strtolower(trim(preg_replace('/[^A-Za-z0-9-]+/', '-', $b['judul_berita'])));
            $mapped[] = [
                'id' => $b['id_berita'],
                'slug' => $slug,
                'gambar' => $b['gambar'],
                'kategori' => 'umum',
                'judul' => $b['judul_berita'],
                'ringkasan' => strip_tags(substr($b['isi_berita'], 0, 150)),
                'isi' => $b['isi_berita'],
                'tanggal_post' => $b['tanggal_post'],
                'penulis' => ''
            ];
        }
        return $mapped;
    }

    public function index()
    {
        $data = $this->_get_common_data('beranda', 'Beranda - Yayasan CBIM', 'Beranda Yayasan CBIM Kupang');

        $konten_raw = $this->m_data->get_data('konten')->result_array();
        $konten = [];
        foreach ($konten_raw as $k) {
            $konten[$k['jenis_konten']] = [
                'judul' => ucfirst($k['jenis_konten']),
                'sub_judul' => $k['sub_judul_konten'] ?? '',
                'isi' => $k['isi_konten']
            ];
        }
        $data['konten'] = $konten;

        $data['angka'] = []; // Add stats here if available

        $data['pendidikan'] = [
            ['internal' => true, 'slug_unit' => 'tk', 'jenjang' => 'TK', 'nama' => 'TK K Citra Bangsa', 'deskripsi' => 'Pendidikan anak usia dini.', 'tautan' => ''],
            ['internal' => true, 'slug_unit' => 'sd', 'jenjang' => 'SD', 'nama' => 'SD K Citra Bangsa', 'deskripsi' => 'Pendidikan dasar.', 'tautan' => ''],
            ['internal' => false, 'slug_unit' => 'smp', 'jenjang' => 'SMP', 'nama' => 'SMP K Citra Bangsa', 'deskripsi' => 'Pendidikan menengah pertama.', 'tautan' => 'http://smpkcitrabangsa.com/'],
            ['internal' => false, 'slug_unit' => 'sma', 'jenjang' => 'SMA', 'nama' => 'SMA K Citra Bangsa', 'deskripsi' => 'Pendidikan menengah atas.', 'tautan' => 'https://smakcitrabangsa.sch.id/'],
            ['internal' => false, 'slug_unit' => 'ucb', 'jenjang' => 'Universitas', 'nama' => 'Universitas Citra Bangsa', 'deskripsi' => 'Pendidikan tinggi unggul.', 'tautan' => 'https://ucb.ac.id/']
        ];

        $data['layanan'] = [
            ['nama' => 'Layanan Kesehatan', 'deskripsi' => 'Klinik kesehatan yayasan'],
            ['nama' => 'Pelatihan Bahasa', 'deskripsi' => 'Kursus bahasa asing'],
            ['nama' => 'Pelatihan Guru', 'deskripsi' => 'Peningkatan kapasitas pendidik']
        ];

        $data_berita_terbaru = $this->db->select('*')->from('berita')->order_by('id_berita', 'DESC')->limit(3)->get()->result_array();
        $data['berita'] = $this->_map_berita($data_berita_terbaru);

        $data_galeri_terbaru = $this->db->select('*')->from('galeri')->order_by('id_foto', 'DESC')->limit(6)->get()->result_array();
        $galeri_mapped = [];
        foreach ($data_galeri_terbaru as $g) {
            $galeri_mapped[] = [
                'foto' => $g['foto'],
                'judul' => $g['judul_foto'],
                'keterangan' => '',
                'tanggal' => ''
            ];
        }
        $data['galeri'] = $galeri_mapped;

        $data_video_terbaru = $this->db->select('*')->from('video_kegiatan')->order_by('id_video', 'DESC')->limit(3)->get()->result_array();
        $video_mapped = [];
        foreach ($data_video_terbaru as $v) {
            preg_match('%(?:youtube(?:-nocookie)?\.com/(?:[^/]+/.+/|(?:v|e(?:mbed)?)/|.*[?&]v=)|youtu\.be/)([^"&?/\s]{11})%i', $v['link'], $match);
            $ytId = isset($match[1]) ? $match[1] : '';
            $video_mapped[] = [
                'id' => $v['id_video'],
                'thumb' => $ytId ? "https://img.youtube.com/vi/{$ytId}/hqdefault.jpg" : '',
                'judul' => $v['judul_video'],
                'deskripsi' => $v['deskripsi']
            ];
        }
        $data['video'] = $video_mapped;

        $this->load->view('templates/pages/header', $data);
        $this->load->view('index', $data);
        $this->load->view('templates/pages/footer', $data);
    }

    /**
     * PERBAIKAN: sebelumnya berita() tidak menerima parameter sama sekali, jadi
     * tautan berita/{id}/{slug} (daftar berita & beranda) berakhir 404 dan
     * tautan page/berita/{hex} (pencarian & sitemap) hanya menampilkan daftar.
     * Kini kedua format membuka halaman detail pages/baca.php, sama seperti
     * Tk::berita() dan Sd::berita().
     */
    public function berita($id = null, $slug = null)
    {
        $id_berita = $this->_id_berita($id);
        if ($id_berita !== null) {
            $this->_baca_berita($id_berita);
            return;
        }
        if ($id !== null) {
            $this->tidak_ditemukan();
            return;
        }

        $data = $this->_get_common_data('berita', 'Berita - Yayasan CBIM', 'Berita dan informasi terbaru');

        $kat_aktif = $this->input->get('kategori') ?? '';
        $hal = (int)($this->input->get('hal') ?? 1);
        if ($hal < 1) $hal = 1;
        
        $limit = 9;
        $offset = ($hal - 1) * $limit;

        $data_all_berita = $this->m_data->get_data('berita')->result_array();
        $semua_berita = $this->_map_berita($data_all_berita);
        
        $kat_terpakai = [];
        $kat_terpakai[''] = count($semua_berita);
        foreach ($semua_berita as $b) {
            if (!isset($kat_terpakai[$b['kategori']])) {
                $kat_terpakai[$b['kategori']] = 0;
            }
            $kat_terpakai[$b['kategori']]++;
        }
        
        $berita_filtered = [];
        foreach ($semua_berita as $b) {
            if ($kat_aktif === '' || $b['kategori'] === $kat_aktif) {
                $berita_filtered[] = $b;
            }
        }
        
        $total_hal = ceil(count($berita_filtered) / $limit);
        $data['berita'] = array_slice($berita_filtered, $offset, $limit);
        
        $data['kat_aktif'] = $kat_aktif;
        $data['kat_terpakai'] = $kat_terpakai;
        $data['hal'] = $hal;
        $data['total_hal'] = $total_hal;

        $this->load->view('templates/pages/header', $data);
        $this->load->view('pages/berita', $data);
        $this->load->view('templates/pages/footer', $data);
    }

    public function galeri()
    {
        $data = $this->_get_common_data('galeri', 'Galeri - Yayasan CBIM', 'Galeri foto kegiatan');

        $data_galeri = $this->m_data->get_data('galeri')->result_array();
        $galeri_mapped = [];
        foreach ($data_galeri as $g) {
            $galeri_mapped[] = [
                'foto' => $g['foto'],
                'judul' => $g['judul_foto'],
                'keterangan' => '',
                'tanggal' => ''
            ];
        }
        $data['galeri'] = $galeri_mapped;

        $this->load->view('templates/pages/header', $data);
        $this->load->view('pages/galeri', $data);
        $this->load->view('templates/pages/footer', $data);
    }

    public function kegiatan($params = null)
    {
        $data = $this->_get_common_data('kegiatan', 'Kegiatan - Yayasan CBIM', 'Kegiatan Yayasan CBIM Kupang');
        
        $data_all_video = $this->m_data->get_data('video_kegiatan')->result_array();
        $video_mapped = [];
        foreach ($data_all_video as $v) {
            preg_match('%(?:youtube(?:-nocookie)?\.com/(?:[^/]+/.+/|(?:v|e(?:mbed)?)/|.*[?&]v=)|youtu\.be/)([^"&?/\s]{11})%i', $v['link'], $match);
            $ytId = isset($match[1]) ? $match[1] : '';
            $video_mapped[] = [
                'id' => $v['id_video'],
                'youtube_id' => $ytId,
                'thumb' => $ytId ? "https://img.youtube.com/vi/{$ytId}/hqdefault.jpg" : '',
                'judul' => $v['judul_video'],
                'deskripsi' => $v['deskripsi'],
                'tanggal' => ''
            ];
        }
        $data['video'] = $video_mapped;

        $data_galeri = $this->m_data->get_data('galeri')->result_array();
        $galeri_mapped = [];
        foreach ($data_galeri as $g) {
            $galeri_mapped[] = [
                'foto' => $g['foto'],
                'judul' => $g['judul_foto']
            ];
        }
        $data['galeri'] = $galeri_mapped;
        
        $this->load->view('templates/pages/header', $data);
        $this->load->view('pages/kegiatan', $data);
        $this->load->view('templates/pages/footer', $data);
    }
    
    /**
     * Terima ID berita angka (berita/15/judul) atau hex-base64 dari Search.php &
     * Sitemap.php (page/berita/4d54553d -> "MTU=" -> 15). Selain itu null.
     */
    private function _id_berita($id)
    {
        if ($id === null || $id === '') {
            return null;
        }
        if (ctype_digit((string) $id)) {
            return (int) $id;
        }
        if (ctype_xdigit((string) $id) && strlen($id) % 2 === 0) {
            $dekode = base64_decode((string) hex2bin($id), TRUE);
            if ($dekode !== FALSE && ctype_digit($dekode)) {
                return (int) $dekode;
            }
        }
        return null;
    }

    private function _baca_berita($id_berita)
    {
        $row = $this->db->get_where('berita', ['id_berita' => $id_berita])->row_array();
        if (empty($row)) {
            $this->tidak_ditemukan();
            return;
        }

        $mapped = $this->_map_berita([$row]);
        $berita = $mapped[0];

        $lain = $this->db->where('id_berita !=', $id_berita)
            ->order_by('tanggal_post', 'DESC')
            ->limit(3)
            ->get('berita')->result_array();

        $data = $this->_get_common_data(
            'berita',
            $berita['judul'] . ' - Yayasan CBIM',
            potong($berita['isi'], 155)
        );
        $data['berita'] = $berita;
        $data['lain'] = $this->_map_berita($lain);

        $this->load->view('templates/pages/header', $data);
        $this->load->view('pages/baca', $data);
        $this->load->view('templates/pages/footer', $data);
    }

    /**
     * PERBAIKAN: tautan "Pendaftaran" di footer mengarah ke /daftar, dan view
     * pages/daftar.php (pengarah ke formulir PPDB tiap unit) sudah ada, tapi
     * rute & method-nya belum dibuat sehingga dulu 404.
     */
    public function daftar()
    {
        $data = $this->_get_common_data('daftar', 'Pendaftaran Siswa Baru - Yayasan CBIM', 'Pilih jenjang dan buka formulir pendaftaran unit pendidikan Yayasan CBIM.');
        // Daftar unit sama dengan di index() dan jejaring().
        $data['pendidikan'] = [
            ['internal' => true, 'slug_unit' => 'tk', 'jenjang' => 'TK', 'nama' => 'TK K Citra Bangsa', 'deskripsi' => 'Pendidikan anak usia dini.', 'tautan' => ''],
            ['internal' => true, 'slug_unit' => 'sd', 'jenjang' => 'SD', 'nama' => 'SD K Citra Bangsa', 'deskripsi' => 'Pendidikan dasar.', 'tautan' => ''],
            ['internal' => false, 'slug_unit' => 'smp', 'jenjang' => 'SMP', 'nama' => 'SMP K Citra Bangsa', 'deskripsi' => 'Pendidikan menengah pertama.', 'tautan' => 'http://smpkcitrabangsa.com/'],
            ['internal' => false, 'slug_unit' => 'sma', 'jenjang' => 'SMA', 'nama' => 'SMA K Citra Bangsa', 'deskripsi' => 'Pendidikan menengah atas.', 'tautan' => 'https://smakcitrabangsa.sch.id/'],
            ['internal' => false, 'slug_unit' => 'ucb', 'jenjang' => 'Universitas', 'nama' => 'Universitas Citra Bangsa', 'deskripsi' => 'Pendidikan tinggi unggul.', 'tautan' => 'https://ucb.ac.id/']
        ];
        $this->load->view('templates/pages/header', $data);
        $this->load->view('pages/daftar', $data);
        $this->load->view('templates/pages/footer', $data);
    }

    /**
     * Halaman 404 bergaya situs (dipasang lewat $route['404_override']).
     */
    public function tidak_ditemukan()
    {
        $this->output->set_status_header(404);
        $data = $this->_get_common_data('404', 'Halaman tidak ditemukan - Yayasan CBIM', 'Halaman yang Anda cari tidak ditemukan.');
        $this->load->view('templates/pages/header', $data);
        $this->load->view('pages/empat_nol_empat', $data);
        $this->load->view('templates/pages/footer', $data);
    }

    /**
     * PERBAIKAN: dulu memuat view pages/login.php yang tidak ada -> galat 500.
     * Login admin ada di /auth.
     */
    public function login()
    {
        redirect('auth');
    }

    public function kebijakan_privasi()
    {
        $data = $this->_get_common_data('kebijakan', 'Kebijakan Privasi', 'Kebijakan Privasi Yayasan');
        $this->load->view('templates/pages/header', $data);
        $this->load->view('pages/kebijakan_privasi', $data);
        $this->load->view('templates/pages/footer', $data);
    }

    public function struktur()
    {
        $data = $this->_get_common_data('struktur', 'Struktur Organisasi - Yayasan CBIM', 'Struktur Organisasi Yayasan Citra Bina Insan Mandiri');

        $data_struktur = $this->m_data->get_data('struktur_organisasi')->result_array();
        
        $struktur = [
            'Dewan Pembina' => [],
            'Dewan Pengurus' => [],
            'Dewan Pengawas' => [],
            'Dewan Direksi' => []
        ];
        
        foreach ($data_struktur as $s) {
            $jab = strtolower($s['jabatan']);
            if (strpos($jab, 'pembina') !== false) {
                $struktur['Dewan Pembina'][] = $s;
            } elseif (strpos($jab, 'pengurus') !== false) {
                $struktur['Dewan Pengurus'][] = $s;
            } elseif (strpos($jab, 'pengawas') !== false) {
                $struktur['Dewan Pengawas'][] = $s;
            } else {
                $struktur['Dewan Direksi'][] = $s;
            }
        }
        
        foreach ($struktur as $k => $v) {
            if (empty($v)) unset($struktur[$k]);
        }
        
        $data['struktur'] = $struktur;

        $this->load->view('templates/pages/header', $data);
        $this->load->view('struktur', $data);
        $this->load->view('templates/pages/footer', $data);
    }

    public function profil()
    {
        $data = $this->_get_common_data('profil', 'Profil Yayasan - Yayasan CBIM', 'Profil, Visi, Misi, dan Legalitas Yayasan CBIM');
        
        $konten_raw = $this->m_data->get_data('konten')->result_array();
        $konten = [];
        foreach ($konten_raw as $k) {
            $konten[$k['jenis_konten']] = [
                'judul' => ucfirst($k['jenis_konten']),
                'sub_judul' => $k['sub_judul_konten'] ?? '',
                'isi' => $k['isi_konten']
            ];
        }
        $data['konten'] = $konten;

        $this->load->view('templates/pages/header', $data);
        $this->load->view('pages/profil', $data);
        $this->load->view('templates/pages/footer', $data);
    }

    public function jejaring()
    {
        $data = $this->_get_common_data('jejaring', 'Unit Pendidikan & Layanan - Yayasan CBIM', 'Unit Pendidikan dan Layanan Masyarakat Yayasan CBIM');
        
        $data['pendidikan'] = [
            ['internal' => true, 'slug_unit' => 'tk', 'jenjang' => 'TK', 'nama' => 'TK K Citra Bangsa', 'deskripsi' => 'Pendidikan anak usia dini.', 'tautan' => ''],
            ['internal' => true, 'slug_unit' => 'sd', 'jenjang' => 'SD', 'nama' => 'SD K Citra Bangsa', 'deskripsi' => 'Pendidikan dasar.', 'tautan' => ''],
            ['internal' => false, 'slug_unit' => 'smp', 'jenjang' => 'SMP', 'nama' => 'SMP K Citra Bangsa', 'deskripsi' => 'Pendidikan menengah pertama.', 'tautan' => 'http://smpkcitrabangsa.com/'],
            ['internal' => false, 'slug_unit' => 'sma', 'jenjang' => 'SMA', 'nama' => 'SMA K Citra Bangsa', 'deskripsi' => 'Pendidikan menengah atas.', 'tautan' => 'https://smakcitrabangsa.sch.id/'],
            ['internal' => false, 'slug_unit' => 'ucb', 'jenjang' => 'Universitas', 'nama' => 'Universitas Citra Bangsa', 'deskripsi' => 'Pendidikan tinggi unggul.', 'tautan' => 'https://ucb.ac.id/']
        ];

        $data['layanan'] = [
            ['nama' => 'Layanan Kesehatan', 'deskripsi' => 'Klinik kesehatan yayasan', 'jenjang' => 'Umum'],
            ['nama' => 'Pelatihan Bahasa', 'deskripsi' => 'Kursus bahasa asing', 'jenjang' => 'Umum'],
            ['nama' => 'Pelatihan Guru', 'deskripsi' => 'Peningkatan kapasitas pendidik', 'jenjang' => 'Pendidik']
        ];

        $this->load->view('templates/pages/header', $data);
        $this->load->view('pages/jejaring', $data);
        $this->load->view('templates/pages/footer', $data);
    }
}
