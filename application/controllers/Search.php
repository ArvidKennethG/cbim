<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Search extends CI_Controller
{
    public function __construct()
    {
        parent::__construct();
        $this->load->model('m_data');
    }

    public function index()
    {
        $q = trim($this->input->get('q', TRUE));
        $category = trim($this->input->get('category', TRUE));
        if (empty($category)) {
            $category = 'semua';
        }

        $results = [];

        if (!empty($q)) {
            // 1. Berita
            if ($category === 'semua' || $category === 'berita') {
                $this->db->group_start();
                $this->db->like('judul_berita', $q);
                $this->db->or_like('isi_berita', $q);
                $this->db->group_end();
                $this->db->order_by('id_berita', 'DESC');
                $berita = $this->db->get('berita')->result_array();
                foreach ($berita as $b) {
                    $results[] = [
                        'type' => 'Berita',
                        'title' => $b['judul_berita'],
                        'snippet' => substr(strip_tags($b['isi_berita']), 0, 160) . '...',
                        'url' => base_url('page/berita/' . bin2hex(base64_encode($b['id_berita']))),
                        'date' => date('d M Y', strtotime($b['tanggal_post']))
                    ];
                }
            }

            // 2. Video Kegiatan
            if ($category === 'semua' || $category === 'kegiatan') {
                $this->db->group_start();
                $this->db->like('judul_video', $q);
                $this->db->or_like('deskripsi', $q);
                $this->db->group_end();
                $this->db->order_by('id_video', 'DESC');
                $kegiatan = $this->db->get('video_kegiatan')->result_array();
                foreach ($kegiatan as $k) {
                    $results[] = [
                        'type' => 'Kegiatan',
                        'title' => $k['judul_video'],
                        'snippet' => substr(strip_tags($k['deskripsi']), 0, 160) . '...',
                        'url' => base_url('page/kegiatan/' . bin2hex(base64_encode($k['id_video']))),
                        'date' => '-'
                    ];
                }
            }

            // 3. Galeri Foto
            if ($category === 'semua' || $category === 'galeri') {
                $this->db->like('judul_foto', $q);
                $galeri = $this->db->get('galeri')->result_array();
                foreach ($galeri as $g) {
                    $results[] = [
                        'type' => 'Galeri',
                        'title' => $g['judul_foto'],
                        'snippet' => 'Dokumentasi foto kegiatan Yayasan CBIM.',
                        'url' => base_url('page/galeri'),
                        'date' => '-'
                    ];
                }
            }

            // 4. Units & Pages
            if ($category === 'semua' || $category === 'unit') {
                $units = [
                    ['title' => 'Universitas Citra Bangsa (UCB)', 'snippet' => 'Perguruan tinggi swasta unggulan di Kota Kupang naungan Yayasan CBIM.', 'url' => 'https://ucb.ac.id/', 'type' => 'Unit Pendidikan', 'date' => '-'],
                    ['title' => 'SMA Kristen Citra Bangsa', 'snippet' => 'Pendidikan jenjang menengah atas berkarakter dan berprestasi di Kupang.', 'url' => 'https://smakcitrabangsa.sch.id/', 'type' => 'Unit Pendidikan', 'date' => '-'],
                    ['title' => 'SMP Kristen Citra Bangsa', 'snippet' => 'Sekolah menengah pertama Kristen dengan kurikulum terpadu.', 'url' => 'http://smpkcitrabangsa.com/', 'type' => 'Unit Pendidikan', 'date' => '-'],
                    ['title' => 'SD Kristen Citra Bangsa', 'snippet' => 'Sekolah dasar berstandar dengan fasilitas lengkap dan pembentukan karakter.', 'url' => base_url('sd'), 'type' => 'Unit Pendidikan', 'date' => '-'],
                    ['title' => 'PAUD / TK Kristen Citra Bangsa', 'snippet' => 'Pendidikan anak usia dini dan taman kanak-kanak yang ramah anak dan berlandaskan kasih.', 'url' => base_url('tk'), 'type' => 'Unit Pendidikan', 'date' => '-'],
                    ['title' => 'Portal Pendaftaran Siswa & Mahasiswa Baru (PPDB Online)', 'snippet' => 'Daftarkan putra-putri Anda secara online untuk seluruh jenjang di Yayasan CBIM.', 'url' => base_url('pendaftaran'), 'type' => 'Pendaftaran', 'date' => '-'],
                    ['title' => 'Katalog Buku & Terbitan Yayasan CBIM', 'snippet' => 'Koleksi buku, referensi bacaan, dan terbitan literasi Yayasan Citra Bina Insan Mandiri.', 'url' => base_url('katalog'), 'type' => 'Katalog Buku', 'date' => '-'],
                    ['title' => 'Struktur Organisasi Yayasan CBIM', 'snippet' => 'Informasi susunan pengurus dan pimpinan Yayasan Citra Bina Insan Mandiri.', 'url' => base_url('#struktur'), 'type' => 'Profil', 'date' => '-'],
                    ['title' => 'Visi dan Misi Yayasan CBIM', 'snippet' => 'Visi, misi, dan nilai-nilai luhur Yayasan Citra Bina Insan Mandiri.', 'url' => base_url('#visi-misi'), 'type' => 'Profil', 'date' => '-']
                ];

                foreach ($units as $u) {
                    if (stripos($u['title'], $q) !== FALSE || stripos($u['snippet'], $q) !== FALSE) {
                        $results[] = $u;
                    }
                }
            }
        }

        $data = [
            'query' => $q,
            'category' => $category,
            'results' => $results,
            'total' => count($results),
            'data_kontak' => $this->m_data->get_data_where("jenis_konten='kontak'", 'konten')->result_array(),
            'data_alamat' => $this->m_data->get_data_where("jenis_konten='alamat'", 'konten')->result_array()
        ];

        $this->load->view('./templates/pages/header');
        $this->load->view('./pages/search', $data);
        $this->load->view('./templates/pages/footer');
    }
}
