<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Sitemap extends CI_Controller
{
    public function __construct()
    {
        parent::__construct();
        $this->load->model('m_data');
    }

    public function index()
    {
        $base = rtrim(base_url(), '/') . '/';

        $urls = [
            [
                'loc' => $base,
                'lastmod' => date('Y-m-d'),
                'changefreq' => 'daily',
                'priority' => '1.0'
            ],
            [
                'loc' => $base . 'page/berita',
                'lastmod' => date('Y-m-d'),
                'changefreq' => 'daily',
                'priority' => '0.9'
            ],
            [
                'loc' => $base . 'page/kegiatan',
                'lastmod' => date('Y-m-d'),
                'changefreq' => 'weekly',
                'priority' => '0.8'
            ],
            [
                'loc' => $base . 'page/galeri',
                'lastmod' => date('Y-m-d'),
                'changefreq' => 'weekly',
                'priority' => '0.8'
            ],
            [
                'loc' => $base . 'sd',
                'lastmod' => date('Y-m-d'),
                'changefreq' => 'weekly',
                'priority' => '0.8'
            ],
            [
                'loc' => $base . 'tk',
                'lastmod' => date('Y-m-d'),
                'changefreq' => 'weekly',
                'priority' => '0.8'
            ],
            // =================================================================
            // PATCH 2026-09-07 (BE-03)
            // Sebelumnya sitemap hanya memuat halaman depan /sd dan /tk. Empat
            // subhalaman masing-masing unit -- profil, fasilitas, kegiatan, dan
            // ppdb -- tidak pernah didaftarkan, padahal dokumen meminta sitemap
            // mencakup "semua URL: ... unit pendidikan". Halaman PPDB diberi
            // prioritas paling tinggi karena itulah tujuan konversi utama.
            // =================================================================
            [
                'loc' => $base . 'sd/profil',
                'lastmod' => date('Y-m-d'),
                'changefreq' => 'monthly',
                'priority' => '0.7'
            ],
            [
                'loc' => $base . 'sd/fasilitas',
                'lastmod' => date('Y-m-d'),
                'changefreq' => 'monthly',
                'priority' => '0.7'
            ],
            [
                'loc' => $base . 'sd/kegiatan',
                'lastmod' => date('Y-m-d'),
                'changefreq' => 'weekly',
                'priority' => '0.7'
            ],
            [
                'loc' => $base . 'sd/ppdb',
                'lastmod' => date('Y-m-d'),
                'changefreq' => 'weekly',
                'priority' => '0.9'
            ],
            [
                'loc' => $base . 'tk/profil',
                'lastmod' => date('Y-m-d'),
                'changefreq' => 'monthly',
                'priority' => '0.7'
            ],
            [
                'loc' => $base . 'tk/fasilitas',
                'lastmod' => date('Y-m-d'),
                'changefreq' => 'monthly',
                'priority' => '0.7'
            ],
            [
                'loc' => $base . 'tk/kegiatan',
                'lastmod' => date('Y-m-d'),
                'changefreq' => 'weekly',
                'priority' => '0.7'
            ],
            [
                'loc' => $base . 'tk/ppdb',
                'lastmod' => date('Y-m-d'),
                'changefreq' => 'weekly',
                'priority' => '0.9'
            ],
            [
                'loc' => $base . 'pendaftaran',
                'lastmod' => date('Y-m-d'),
                'changefreq' => 'weekly',
                'priority' => '0.9'
            ],
            [
                'loc' => $base . 'kebijakan-privasi',
                'lastmod' => date('Y-m-d'),
                'changefreq' => 'monthly',
                'priority' => '0.5'
            ],
            [
                'loc' => $base . 'katalog',
                'lastmod' => date('Y-m-d'),
                'changefreq' => 'weekly',
                'priority' => '0.8'
            ]
        ];

        // Fetch berita
        $berita = $this->m_data->get_data('berita')->result_array();
        foreach ($berita as $b) {
            $hex_id = bin2hex(base64_encode($b['id_berita']));
            $tgl = !empty($b['tanggal_update']) ? date('Y-m-d', strtotime($b['tanggal_update'])) : date('Y-m-d', strtotime($b['tanggal_post']));
            $urls[] = [
                'loc' => $base . 'page/berita/' . $hex_id,
                'lastmod' => $tgl,
                'changefreq' => 'monthly',
                'priority' => '0.7'
            ];
        }

        // Fetch video kegiatan
        $kegiatan = $this->m_data->get_data('video_kegiatan')->result_array();
        foreach ($kegiatan as $k) {
            $hex_id = bin2hex(base64_encode($k['id_video']));
            $urls[] = [
                'loc' => $base . 'page/kegiatan/' . $hex_id,
                'lastmod' => date('Y-m-d'),
                'changefreq' => 'monthly',
                'priority' => '0.6'
            ];
        }

        $xml = '<?xml version="1.0" encoding="UTF-8"?>' . "\n";
        $xml .= '<urlset xmlns="http://www.sitemaps.org/schemas/sitemap/0.9">' . "\n";

        foreach ($urls as $u) {
            $xml .= '  <url>' . "\n";
            $xml .= '    <loc>' . htmlspecialchars($u['loc']) . '</loc>' . "\n";
            $xml .= '    <lastmod>' . $u['lastmod'] . '</lastmod>' . "\n";
            $xml .= '    <changefreq>' . $u['changefreq'] . '</changefreq>' . "\n";
            $xml .= '    <priority>' . $u['priority'] . '</priority>' . "\n";
            $xml .= '  </url>' . "\n";
        }

        $xml .= '</urlset>';

        $this->output
            ->set_content_type('application/xml')
            ->set_output($xml);
    }
}
