<?php
defined('BASEPATH') or exit('No direct script access allowed');

if (!function_exists('aset')) {
    function aset($path)
    {
        $real_path = FCPATH . $path;
        if (file_exists($real_path)) {
            $ver = filemtime($real_path);
            return base_url($path) . '?v=' . $ver;
        }
        return base_url($path);
    }
}

if (!function_exists('ikon')) {
    function ikon($nama, $ukuran = 24)
    {
        $svg_buka = '<svg width="'.$ukuran.'" height="'.$ukuran.'" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true">';
        $svg_tutup = '</svg>';
        $isi = '';

        switch ($nama) {
            case 'target':
                $isi = '<circle cx="12" cy="12" r="10"></circle><circle cx="12" cy="12" r="6"></circle><circle cx="12" cy="12" r="2"></circle>';
                break;
            case 'kesehatan':
                $isi = '<path d="M20.84 4.61a5.5 5.5 0 0 0-7.78 0L12 5.67l-1.06-1.06a5.5 5.5 0 0 0-7.78 7.78l1.06 1.06L12 21.23l7.78-7.78 1.06-1.06a5.5 5.5 0 0 0 0-7.78z"></path>';
                break;
            case 'globe':
                $isi = '<circle cx="12" cy="12" r="10"></circle><line x1="2" y1="12" x2="22" y2="12"></line><path d="M12 2a15.3 15.3 0 0 1 4 10 15.3 15.3 0 0 1-4 10 15.3 15.3 0 0 1-4-10 15.3 15.3 0 0 1 4-10z"></path>';
                break;
            case 'buku':
                $isi = '<path d="M2 3h6a4 4 0 0 1 4 4v14a3 3 0 0 0-3-3H2z"></path><path d="M22 3h-6a4 4 0 0 0-4 4v14a3 3 0 0 1 3-3h7z"></path>';
                break;
            case 'dokumen':
                $isi = '<path d="M14 2H6a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V8z"></path><polyline points="14 2 14 8 20 8"></polyline><line x1="16" y1="13" x2="8" y2="13"></line><line x1="16" y1="17" x2="8" y2="17"></line><polyline points="10 9 9 9 8 9"></polyline>';
                break;
            case 'gambar':
                $isi = '<rect x="3" y="3" width="18" height="18" rx="2" ry="2"></rect><circle cx="8.5" cy="8.5" r="1.5"></circle><polyline points="21 15 16 10 5 21"></polyline>';
                break;
            case 'main':
                $isi = '<polygon points="5 3 19 12 5 21 5 3"></polygon>';
                break;
            case 'gedung':
                $isi = '<path d="M4 22h16"/><path d="M4 22V4a2 2 0 0 1 2-2h12a2 2 0 0 1 2 2v18"/><path d="M10 22v-7a2 2 0 0 1 2-2h0a2 2 0 0 1 2 2v7"/><path d="M10 7h4"/><path d="M10 11h4"/><path d="M10 15h4"/>';
                break;
            case 'telpon':
                $isi = '<path d="M22 16.92v3a2 2 0 0 1-2.18 2 19.79 19.79 0 0 1-8.63-3.07 19.5 19.5 0 0 1-6-6 19.79 19.79 0 0 1-3.07-8.67A2 2 0 0 1 4.11 2h3a2 2 0 0 1 2 1.72 12.84 12.84 0 0 0 .7 2.81 2 2 0 0 1-.45 2.11L8.09 9.91a16 16 0 0 0 6 6l1.27-1.27a2 2 0 0 1 2.11-.45 12.84 12.84 0 0 0 2.81.7A2 2 0 0 1 22 16.92z"/>';
                break;
            case 'surel':
                $isi = '<rect width="20" height="16" x="2" y="4" rx="2"/><path d="m22 7-8.97 5.7a1.94 1.94 0 0 1-2.06 0L2 7"/>';
                break;
            case 'orang':
                $isi = '<path d="M20 21v-2a4 4 0 0 0-4-4H8a4 4 0 0 0-4 4v2"></path><circle cx="12" cy="7" r="4"></circle>';
                break;
            default:
                // Default fallback circle
                $isi = '<circle cx="12" cy="12" r="10"></circle>';
                break;
        }

        return $svg_buka . $isi . $svg_tutup;
    }
}

if (!function_exists('bersihkan_html')) {
    function bersihkan_html($html)
    {
        return $html;
    }
}

if (!function_exists('tanggal_id')) {
    function tanggal_id($tanggal)
    {
        if (empty($tanggal)) return '';
        $bulan = ['Januari','Februari','Maret','April','Mei','Juni','Juli','Agustus','September','Oktober','November','Desember'];
        $ts = strtotime($tanggal);
        return date('d', $ts) . ' ' . $bulan[(int)date('m', $ts) - 1] . ' ' . date('Y', $ts);
    }
}

if (!function_exists('potong')) {
    function potong($teks, $panjang)
    {
        $teks = strip_tags($teks);
        if (strlen($teks) > $panjang) {
            return substr($teks, 0, $panjang) . '...';
        }
        return $teks;
    }
}

if (!function_exists('kategori_berita')) {
    function kategori_berita()
    {
        return [
            'umum' => ['label' => 'Umum'],
            'kegiatan' => ['label' => 'Kegiatan'],
            'pengumuman' => ['label' => 'Pengumuman']
        ];
    }
}

if (!function_exists('label_kategori')) {
    function label_kategori($kat)
    {
        $kategori = kategori_berita();
        return isset($kategori[$kat]) ? $kategori[$kat]['label'] : 'Umum';
    }
}

if (!function_exists('foto_struktur')) {
    function foto_struktur($foto)
    {
        if (empty($foto)) return '';
        if (file_exists(FCPATH . 'uploads/avatars/' . $foto)) {
            return base_url('uploads/avatars/' . $foto);
        }
        return '';
    }
}
