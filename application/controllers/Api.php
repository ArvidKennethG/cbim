<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Api extends CI_Controller
{
    public function __construct()
    {
        parent::__construct();
        $this->load->model('m_data');
    }

    /**
     * INT-01: Quick Sitewide Search Endpoint
     */
    public function search()
    {
        $q = trim($this->input->get('q', TRUE));
        if (strlen($q) < 2) {
            echo json_encode(['status' => 'success', 'results' => [], 'total' => 0]);
            return;
        }

        $results = [];

        // 1. Search Berita
        $this->db->like('judul_berita', $q);
        $this->db->or_like('isi_berita', $q);
        $this->db->order_by('id_berita', 'DESC');
        $this->db->limit(5);
        $berita = $this->db->get('berita')->result_array();
        foreach ($berita as $b) {
            $hex_id = bin2hex(base64_encode($b['id_berita']));
            $results[] = [
                'category' => 'Berita',
                'title' => $b['judul_berita'],
                'url' => base_url('page/berita/' . $hex_id),
                'date' => date('d M Y', strtotime($b['tanggal_post']))
            ];
        }

        // 2. Search Kegiatan (Video)
        $this->db->like('judul_video', $q);
        $this->db->or_like('deskripsi', $q);
        $this->db->order_by('id_video', 'DESC');
        $this->db->limit(3);
        $kegiatan = $this->db->get('video_kegiatan')->result_array();
        foreach ($kegiatan as $k) {
            $hex_id = bin2hex(base64_encode($k['id_video']));
            $results[] = [
                'category' => 'Kegiatan',
                'title' => $k['judul_video'],
                'url' => base_url('page/kegiatan/' . $hex_id)
            ];
        }

        // 3. Search Galeri
        $this->db->like('judul_foto', $q);
        $this->db->limit(3);
        $galeri = $this->db->get('galeri')->result_array();
        foreach ($galeri as $g) {
            $results[] = [
                'category' => 'Galeri',
                'title' => $g['judul_foto'],
                'url' => base_url('page/galeri')
            ];
        }

        // 4. Static / Unit matches
        $units = [
            ['title' => 'Universitas Citra Bangsa (UCB)', 'category' => 'Unit Pendidikan', 'url' => 'https://ucb.ac.id/'],
            ['title' => 'SMA Kristen Citra Bangsa', 'category' => 'Unit Pendidikan', 'url' => 'https://smakcitrabangsa.sch.id/'],
            ['title' => 'SMP Kristen Citra Bangsa', 'category' => 'Unit Pendidikan', 'url' => 'http://smpkcitrabangsa.com/'],
            ['title' => 'SD Kristen Citra Bangsa', 'category' => 'Unit Pendidikan', 'url' => base_url('sd')],
            ['title' => 'PAUD / TK Kristen Citra Bangsa', 'category' => 'Unit Pendidikan', 'url' => base_url('tk')],
            ['title' => 'Portal Pendaftaran PPDB Online', 'category' => 'Pendaftaran', 'url' => base_url('pendaftaran')],
            ['title' => 'Struktur Organisasi Yayasan CBIM', 'category' => 'Informasi', 'url' => base_url('#struktur')],
            ['title' => 'Visi & Misi Yayasan CBIM', 'category' => 'Informasi', 'url' => base_url('#visi-misi')]
        ];

        foreach ($units as $u) {
            if (stripos($u['title'], $q) !== FALSE) {
                $results[] = $u;
            }
        }

        $this->output
            ->set_content_type('application/json')
            ->set_output(json_encode([
                'status' => 'success',
                'query' => $q,
                'total' => count($results),
                'results' => $results
            ]));
    }

    /**
     * BE-09: REST API Internal Sinkronisasi Data Unit (with 1h cache)
     */
    public function units()
    {
        $cache_file = APPPATH . 'cache/api_units_latest.json';
        $cache_lifetime = 3600; // 1 hour

        if (file_exists($cache_file) && (time() - filemtime($cache_file) < $cache_lifetime)) {
            $cached_data = file_get_contents($cache_file);
            $this->output
                ->set_content_type('application/json')
                ->set_header('X-Cache: HIT')
                ->set_output($cached_data);
            return;
        }

        // Aggregate units data
        $berita_terbaru = $this->db->order_by('id_berita', 'DESC')->limit(3)->get('berita')->result_array();
        $total_pendaftar_sd = $this->db->where('jenjang', 'SD')->from('pendaftaran')->count_all_results();
        $total_pendaftar_tk = $this->db->where('jenjang', 'TK')->from('pendaftaran')->count_all_results();

        $data = [
            'status' => 'success',
            'generated_at' => date('Y-m-d H:i:s'),
            'units' => [
                [
                    'code' => 'UCB',
                    'name' => 'Universitas Citra Bangsa',
                    'level' => 'Perguruan Tinggi',
                    'website' => 'https://ucb.ac.id/',
                    'status' => 'Aktif'
                ],
                [
                    'code' => 'SMA',
                    'name' => 'SMA Kristen Citra Bangsa',
                    'level' => 'Menengah Atas',
                    'website' => 'https://smakcitrabangsa.sch.id/',
                    'status' => 'Aktif'
                ],
                [
                    'code' => 'SMP',
                    'name' => 'SMP Kristen Citra Bangsa',
                    'level' => 'Menengah Pertama',
                    'website' => 'http://smpkcitrabangsa.com/',
                    'status' => 'Aktif'
                ],
                [
                    'code' => 'SD',
                    'name' => 'SD Kristen Citra Bangsa',
                    'level' => 'Dasar',
                    'total_pendaftar' => $total_pendaftar_sd,
                    'website' => base_url('sd'),
                    'status' => 'Aktif'
                ],
                [
                    'code' => 'TK',
                    'name' => 'TK Kristen Citra Bangsa',
                    'level' => 'Usia Dini',
                    'total_pendaftar' => $total_pendaftar_tk,
                    'website' => base_url('tk'),
                    'status' => 'Aktif'
                ]
            ],
            'latest_news' => array_map(function($b) {
                return [
                    'id' => $b['id_berita'],
                    'title' => $b['judul_berita'],
                    'date' => $b['tanggal_post'],
                    'url' => base_url('page/berita/' . bin2hex(base64_encode($b['id_berita'])))
                ];
            }, $berita_terbaru)
        ];

        $json = json_encode($data, JSON_PRETTY_PRINT);
        @file_put_contents($cache_file, $json);

        $this->output
            ->set_content_type('application/json')
            ->set_header('X-Cache: MISS')
            ->set_output($json);
    }
}
