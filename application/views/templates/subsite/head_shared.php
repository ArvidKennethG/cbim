<?php
/**
 * =============================================================================
 * PARTIAL BERSAMA UNTUK SUBSITE SD & TK  --  BARU (PATCH 2026-09-07)
 * =============================================================================
 * Disertakan tepat sebelum </head> di templates/sd/header.php dan
 * templates/tk/header.php:
 *
 *     <?php $this->load->view('templates/subsite/head_shared'); ?>
 *
 * Alasan file ini ada
 * -------------------
 * Portal utama memakai template Metronic (style.bundle.css + custom-cbim.css),
 * sedangkan subsite SD/TK hanya memuat Bootstrap 5.3 dari CDN. Akibatnya:
 *
 *   1. 107 pemakaian kelas seperti fs-7, fw-extrabold, leading-relaxed,
 *      hover-gold TIDAK ADA definisinya di subsite -- kelas-kelas itu milik
 *      Metronic/Tailwind. Efek paling terlihat: <h1 class="display-4
 *      fw-extrabold"> justru tampil TIPIS, karena Bootstrap menyetel
 *      .display-* ke font-weight:300 dan tidak ada yang menimpanya.
 *   2. GA4 tidak pernah dimuat di /sd dan /tk, sehingga kunjungan ke dua
 *      halaman itu -- justru halaman yang dituju orang tua calon pendaftar --
 *      tidak pernah tercatat di laporan bulanan (BE-04).
 *   3. Tidak ada og:*, canonical, maupun JSON-LD di subsite (BE-02).
 *
 * Semuanya diselesaikan di satu tempat agar SD dan TK tidak lagi menyimpang.
 *
 * Variabel opsional dari controller (semuanya punya nilai default):
 *   $subsite_meta = [
 *      'unit'        => 'sd' | 'tk',
 *      'nama'        => 'SD Kristen Citra Bangsa Mandiri',
 *      'deskripsi'   => 'meta description khusus halaman ini (maks 160 kar.)',
 *      'logo'        => 'sd.png',
 *      'jenjang'     => 'Sekolah Dasar',
 *   ];
 * =============================================================================
 */

// ---------- Nilai default yang aman bila controller belum dimutakhirkan ------
$unit = $this->uri->segment(1);
$unit = in_array($unit, ['sd', 'tk'], TRUE) ? $unit : 'sd';

$default_meta = [
    'sd' => [
        'unit'      => 'sd',
        'nama'      => 'SD Kristen Citra Bangsa Mandiri',
        'deskripsi' => 'SD Kristen Citra Bangsa Mandiri Kupang, sekolah dasar di bawah naungan Yayasan Citra Bina Insan Mandiri. Informasi profil, fasilitas, kegiatan, dan PPDB online.',
        'logo'      => 'sd.png',
        'jenjang'   => 'Sekolah Dasar',
    ],
    'tk' => [
        'unit'      => 'tk',
        'nama'      => 'TK & PAUD Kristen Citra Bangsa Mandiri',
        'deskripsi' => 'TK & PAUD Kristen Citra Bangsa Mandiri Kupang di bawah naungan Yayasan Citra Bina Insan Mandiri. Informasi profil, fasilitas, kegiatan, dan PPDB online.',
        'logo'      => 'paud-tk.png',
        'jenjang'   => 'Taman Kanak-Kanak / PAUD',
    ],
];

$meta = isset($subsite_meta) && is_array($subsite_meta)
    ? array_merge($default_meta[$unit], $subsite_meta)
    : $default_meta[$unit];

$og_image = base_url('assets/templates/media/logos/' . $meta['logo']);
$page_url = current_url();
$page_title = isset($title) ? $title : $meta['nama'];

// Ganti bila properti GA4 sudah final. Nilai ini disamakan dengan portal utama
// supaya traffic subsite masuk ke properti yang sama.
$ga4_id = 'G-CBIMGA401';
?>

<!-- ========================= BE-02: Meta sosial & canonical ================= -->
<meta property="og:locale" content="id_ID" />
<meta property="og:type" content="website" />
<meta property="og:site_name" content="Yayasan Citra Bina Insan Mandiri" />
<meta property="og:title" content="<?= htmlspecialchars($page_title, ENT_QUOTES, 'UTF-8'); ?>" />
<meta property="og:description" content="<?= htmlspecialchars($meta['deskripsi'], ENT_QUOTES, 'UTF-8'); ?>" />
<meta property="og:url" content="<?= htmlspecialchars($page_url, ENT_QUOTES, 'UTF-8'); ?>" />
<meta property="og:image" content="<?= htmlspecialchars($og_image, ENT_QUOTES, 'UTF-8'); ?>" />
<meta name="twitter:card" content="summary_large_image" />
<meta name="twitter:title" content="<?= htmlspecialchars($page_title, ENT_QUOTES, 'UTF-8'); ?>" />
<meta name="twitter:description" content="<?= htmlspecialchars($meta['deskripsi'], ENT_QUOTES, 'UTF-8'); ?>" />
<meta name="twitter:image" content="<?= htmlspecialchars($og_image, ENT_QUOTES, 'UTF-8'); ?>" />
<meta name="robots" content="index, follow" />
<meta name="author" content="Yayasan Citra Bina Insan Mandiri (YCBIM)" />
<link rel="canonical" href="<?= htmlspecialchars($page_url, ENT_QUOTES, 'UTF-8'); ?>" />

<!-- ============ BE-02: JSON-LD Schema.org EducationalOrganization =========== -->
<script type="application/ld+json">
<?= json_encode([
    '@context' => 'https://schema.org',
    '@type'    => 'EducationalOrganization',
    'name'     => $meta['nama'],
    'alternateName' => $unit === 'sd' ? 'SD K Citra Bangsa Mandiri' : 'TK K Citra Bangsa Mandiri',
    'description'   => $meta['deskripsi'],
    'url'      => rtrim(base_url(), '/') . '/' . $unit,
    'logo'     => $og_image,
    'image'    => $og_image,
    'address'  => [
        '@type'           => 'PostalAddress',
        'streetAddress'   => 'Jl. Manafe No.17, Kel. Kayu Putih, Kec. Oebobo',
        'addressLocality' => 'Kota Kupang',
        'addressRegion'   => 'Nusa Tenggara Timur',
        'postalCode'      => '85111',
        'addressCountry'  => 'ID',
    ],
    'parentOrganization' => [
        '@type' => 'EducationalOrganization',
        'name'  => 'Yayasan Citra Bina Insan Mandiri (YCBIM)',
        'url'   => rtrim(base_url(), '/') . '/',
    ],
    'sameAs' => [
        'https://www.facebook.com/profile.php?id=100086189573438',
        'https://www.instagram.com/yayasan_cbim',
        'https://www.youtube.com/@CBIMYayasan',
    ],
], JSON_UNESCAPED_SLASHES | JSON_UNESCAPED_UNICODE | JSON_PRETTY_PRINT); ?>
</script>

<!-- ===================================================================== -->
<!-- BE-04 + BE-10: GA4 dengan Consent Mode v2                             -->
<!-- Sebelum patch ini, /sd dan /tk sama sekali tidak memuat GA4.           -->
<!-- Persetujuan cookie dibaca dari cookie yang sama dengan portal utama,   -->
<!-- jadi pengunjung tidak ditanya dua kali.                                -->
<!-- ===================================================================== -->
<script>
  window.dataLayer = window.dataLayer || [];
  function gtag(){dataLayer.push(arguments);}
  window.CBIM_GA4_ID = '<?= $ga4_id; ?>';

  gtag('consent', 'default', {
    'ad_storage':            'denied',
    'ad_user_data':          'denied',
    'ad_personalization':    'denied',
    'analytics_storage':     'denied',
    'functionality_storage': 'granted',
    'security_storage':      'granted',
    'wait_for_update':       500
  });

  (function () {
    var consent = null;
    try { consent = localStorage.getItem('cbim_cookie_consent'); } catch (e) {}
    if (!consent) {
      var m = document.cookie.match(/(?:^|;\s*)cbim_cookie_consent=([^;]+)/);
      if (m) consent = m[1];
    }
    if (consent === 'accepted') {
      gtag('consent', 'update', {
        'ad_storage': 'granted',
        'ad_user_data': 'granted',
        'ad_personalization': 'granted',
        'analytics_storage': 'granted'
      });
    }
  })();

  gtag('js', new Date());
  gtag('config', window.CBIM_GA4_ID, {
    'anonymize_ip': true,
    'content_group': '<?= $unit; ?>'
  });
</script>
<script async src="https://www.googletagmanager.com/gtag/js?id=<?= $ga4_id; ?>"></script>

<!-- ===================================================================== -->
<!-- SHIM UTILITAS CSS                                                      -->
<!-- Mendefinisikan kelas Metronic/Tailwind yang dipakai view SD & TK tapi  -->
<!-- tidak ada di Bootstrap 5.3. Nilainya disamakan dengan Metronic agar    -->
<!-- tampilan subsite konsisten dengan portal utama.                        -->
<!-- ===================================================================== -->
<style>
    /* --- Skala font Metronic (fs-7 dipakai 64x di view SD saja) --- */
    .fs-7  { font-size: 0.95rem !important; }
    .fs-8  { font-size: 0.85rem !important; }
    .fs-9  { font-size: 0.75rem !important; }

    /* --- Bobot font --- */
    .fw-extrabold  { font-weight: 800 !important; }
    .font-semibold { font-weight: 600 !important; }

    /* Bootstrap menyetel .display-* ke font-weight:300. Tanpa baris ini,
       judul hero <h1 class="display-4 fw-extrabold"> tampil tipis. */
    .display-1.fw-extrabold, .display-2.fw-extrabold, .display-3.fw-extrabold,
    .display-4.fw-extrabold, .display-5.fw-extrabold, .display-6.fw-extrabold {
        font-weight: 800 !important;
    }

    /* --- Utilitas gaya Tailwind yang dipakai di markup --- */
    .leading-relaxed { line-height: 1.75 !important; }
    .tracking-wider  { letter-spacing: 0.05em !important; }

    /* --- Warna hover pada tautan footer --- */
    .hover-red:hover  { color: var(--cbim-primary-light) !important; }
    .hover-gold:hover { color: var(--cbim-gold) !important; }

    /* --- Utilitas responsif --- */
    @media (min-width: 768px) {
        .fs-md-5 { font-size: 1.25rem !important; }
    }
    @media (min-width: 992px) {
        .py-lg-6 { padding-top: 4rem !important; padding-bottom: 4rem !important; }
    }

    /* ================================================================= */
    /* FE-02: Smooth scroll                                              */
    /* ================================================================= */
    html { scroll-behavior: smooth; }

    /* Hormati pengguna yang mematikan animasi di level sistem operasi */
    @media (prefers-reduced-motion: reduce) {
        html { scroll-behavior: auto; }
        .floating-badge { animation: none !important; }
        *, *::before, *::after {
            animation-duration: 0.01ms !important;
            transition-duration: 0.01ms !important;
        }
    }

    /* ================================================================= */
    /* FE-05: Aksesibilitas dasar (WCAG 2.1 AA)                          */
    /* ================================================================= */

    /* Skip link -- pengguna keyboard bisa lompat langsung ke konten */
    .skip-link {
        position: absolute;
        left: -9999px;
        top: 0;
        z-index: 1080;
        background: var(--cbim-primary);
        color: #fff;
        padding: 0.75rem 1.25rem;
        border-radius: 0 0 8px 0;
        font-weight: 700;
        text-decoration: none;
    }
    .skip-link:focus {
        left: 0;
        color: #fff;
        outline: 3px solid var(--cbim-gold);
    }

    /* Fokus keyboard yang terlihat jelas pada semua elemen interaktif */
    a:focus-visible,
    button:focus-visible,
    input:focus-visible,
    select:focus-visible,
    textarea:focus-visible,
    .btn:focus-visible {
        outline: 3px solid var(--cbim-gold-dark) !important;
        outline-offset: 2px !important;
        box-shadow: none !important;
    }

    /* Perbaikan kontras topbar.
       Gradien lama berakhir di #FFD80C (emas) tepat di sisi kanan, sementara
       tautan "Daftar Online" di sisi itu memakai .text-warning yang juga emas
       -- teks emas di atas latar emas praktis tidak terbaca. Gradien kini
       berhenti di crimson, dan emas dipakai sebagai garis aksen. */
    .topbar-sd, .topbar-tk {
        background: linear-gradient(90deg, #660519 0%, #890C25 55%, #B71A34 100%) !important;
        border-bottom: 2px solid var(--cbim-gold);
    }
    .topbar-sd .text-warning, .topbar-tk .text-warning {
        color: #FFE9A3 !important; /* rasio kontras > 7:1 terhadap crimson */
    }

    /* Target sentuh minimum 44x44px pada ikon sosial media (WCAG 2.5.5) */
    footer .btn.rounded-circle { min-width: 44px; min-height: 44px; }
</style>
