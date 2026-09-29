-- phpMyAdmin SQL Dump
-- version 5.2.2
-- https://www.phpmyadmin.net/
--
-- Host: localhost:3306
-- Waktu pembuatan: 10 Agu 2026 pada 09.44
-- Versi server: 10.11.18-MariaDB-cll-lve
-- Versi PHP: 8.4.23

-- CATATAN REPOSITORI: dump ini sudah disanitasi (tanpa akun & tanpa log IP
-- pengunjung). Setelah import, jalankan juga migration_admin_tk_sd.sql dan
-- migration_tabel_tambahan.sql -- lihat README.md.

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `u1711594_yayasan_v2`
--

-- --------------------------------------------------------

--
-- Struktur dari tabel `auth`
--

CREATE TABLE `auth` (
  `id_user` int(11) NOT NULL,
  `username` varchar(255) NOT NULL,
  `password` varchar(255) NOT NULL,
  `role` enum('default','administrator','katalog') NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data untuk tabel `auth`
--

-- [DISANITASI] Baris akun sengaja DIKOSONGKAN di repositori publik ini.
-- Dump asli memuat akun lama 'admin123' dan 'adminbuku' dengan password yang sama
-- dengan username-nya (role 'default' = lolos semua pengecekan hak akses).
-- Buat akun administrator pertama setelah import dengan perintah CLI:
--   php index.php auth seed_admin
-- (seeder ini memang hanya berjalan bila tabel auth kosong -- lihat Auth.php)

-- --------------------------------------------------------

--
-- Struktur dari tabel `berita`
--

CREATE TABLE `berita` (
  `id_berita` int(11) NOT NULL,
  `judul_berita` text NOT NULL,
  `isi_berita` longtext NOT NULL,
  `tanggal_post` datetime NOT NULL DEFAULT '0000-00-00 00:00:00' ON UPDATE current_timestamp(),
  `tanggal_update` datetime DEFAULT NULL,
  `gambar` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data untuk tabel `berita`
--

INSERT INTO `berita` (`id_berita`, `judul_berita`, `isi_berita`, `tanggal_post`, `tanggal_update`, `gambar`) VALUES
(15, 'Seminar Nasional yang bertemakan &quot;Peranan Infrastruktur Jalan sebagai Konektivitas untuk Optimalisasi Daerah Tertinggal Menuju Indonesia Emas 2023&quot;', '<p>Universitas Citra Bangsa Menggelar Seminar Nasional dengan Tema Peranan Infrastruktur Jalan sebagai Konektivitas untuk Optimalisasi Daerah Tertinggal Menuju Indonesia Emas 2023</p><p>Selasa, 11 Juli 2023 - Pada hari Selasa, 11 Juli 2023, Universitas Citra Bangsa mengadakan Seminar Nasional yang bertemakan \"Peranan Infrastruktur Jalan sebagai Konektivitas untuk Optimalisasi Daerah Tertinggal Menuju Indonesia Emas 2023\". Acara ini diselenggarakan di kampus Universitas Citra Bangsa dan dihadiri oleh sejumlah peserta dari berbagai latar belakang terkait infrastruktur dan pembangunan daerah.</p><p>Salah satu pembicara utama dalam seminar ini adalah Direktur Bina Teknik Jalan dan Jembatan Kementerian Pekerjaan Umum dan Perumahan Rakyat (PUPR), Bapak Ir. Yudha Handita Pandjiriawan, MT., MBA. Dalam pidatonya, Bapak Yudha Handita Pandjiriawan membahas peran penting infrastruktur jalan dalam mengoptimalkan daerah tertinggal di Indonesia menuju Indonesia Emas 2023.</p><p>Dalam sambutannya, Bapak Yudha Handita Pandjiriawan menekankan pentingnya pembangunan infrastruktur jalan yang baik dan terkoneksi dengan baik sebagai kunci dalam mempercepat pembangunan dan pertumbuhan ekonomi di daerah-daerah tertinggal. Dia menjelaskan bahwa infrastruktur jalan yang memadai akan mempermudah mobilitas penduduk, transportasi barang, dan aksesibilitas menuju daerah-daerah tersebut.</p><p>Selain itu, Bapak Yudha Handita Pandjiriawan juga menyoroti pentingnya pembangunan jalan yang ramah lingkungan, berkelanjutan, dan mempertimbangkan aspek keberlanjutan dalam perencanaan dan pelaksanaannya. Dia menegaskan bahwa infrastruktur jalan yang baik harus mampu memperhatikan dampak lingkungan serta kebutuhan masyarakat yang berkelanjutan.</p><p>Seminar ini dihadiri oleh sejumlah peserta yang terdiri dari akademisi, praktisi, dan para pemangku kepentingan terkait pembangunan infrastruktur jalan. Diskusi dan tanya jawab antara peserta dan pembicara juga dilakukan untuk memperdalam pemahaman mengenai peranan infrastruktur jalan dalam mengoptimalkan daerah tertinggal.</p><p>Dalam penutup acara, Rektor Universitas Citra Bangsa menyampaikan terima kasih kepada semua peserta dan pembicara yang telah berpartisipasi dalam seminar ini. Dia berharap bahwa seminar ini dapat memberikan pemahaman yang lebih mendalam tentang pentingnya peran infrastruktur jalan dalam pembangunan daerah dan kontribusinya dalam mewujudkan visi Indonesia Emas 2023.</p><p>Seminar nasional ini diharapkan dapat menjadi sarana untuk bertukar informasi, pemikiran, dan pengalaman terkait pembangunan infrastruktur jalan yang berkelanjutan dan berdampak positif bagi daerah tertinggal&nbsp;di&nbsp;Indonesia.</p>', '2024-01-31 15:32:32', '2024-01-31 15:32:32', '1689065368_09fb70dd66e93785f12e1.jpg'),
(16, 'ALUMNI UCB YANG BERKESEMPATAN KERJA DI JEPANG', '<p>Yasinta Rindu, S.Kep., Ners, adalah salah satu alumni UNIVERSITAS CITRA BANGSA prodi Keperawatan yang berkesempatan bekerja di Jepang. Wanita yang biasa akrab di sapa Sinta ini merupakan&nbsp; alumni angkatan pertama UCB atau dulu disebut STIKES CHMK, yang mengambil jurusan Keperwatan dan Profesi Ners. Hari ini Sinta berkesempatan hadir dan bertemu dengan ketua Yayasan Citra Bina Insan Mandiri Bapak Ir. Benny Ndoenboey M,Si sembari bercerita berbagi pengalaman selama bekerja di Jepang. Dalam wawancara <i>(Senin, 3 Juli 2023)</i> Sinta bercerita tentang pengalamannya selama bekerja di Jepang sebagai seorang Perawat atau Ners.</p><p>Sinta bercerita bahwa ia mengikuti suatu program pemerintah pengiriman perawat yang disebut dengan Program <i><strong>G2G (Goverment to Goverment)&nbsp;</strong></i>dimana program ini memiliki dua kategori yaitu <i><strong>Kigo Fukusisi&nbsp;</strong></i>dan&nbsp;<i><strong>Kangusi</strong></i>. Program <i><strong>Kaigo Fukusisi</strong></i>&nbsp; sendiri merupakan program untuk perawatan khusus Lansia, sedangkan <i><strong>Kagusi</strong></i>&nbsp;&nbsp;merupakan program perawatan secara umum. Sinta&nbsp;sendiri mengikuti program <i><strong>Kangusi&nbsp;</strong></i>dan sudah bekerja selama empat tahun di Yoshimizu Hospital Japan sebagai seorang asisten perawat. Alasan kembalinya Sinta Ke Indonesia (NTT) karena masa kontrak kerja pertamnya telah habis sehingga Sinta berkesempatan pulang dan sekaligus berlibur bertemu dengan suami dan anak tercinta. Namum Sinta berencana untuk kembali mengabdi dan bekerja di Jepang sembari menunggu selesainya pengurusan Visa baru yang katanya membutuhkan waktu paling cepat lima bulan.</p>', '2024-01-31 15:33:15', '2024-01-31 15:33:15', '1688372672_5a6aebe1b91933d50d5f1.jpg'),
(17, 'PELEPASAN MURID TK KRISTEN CBM', '<p>Jumat, 16 Juni 2023, Pelepasan anak-anak TK Kristen Citra Bangsa Mandiri Tahun Ajaran 2022/2023 dengan tema “Aku Berarti Karena Yesus”. Dengan total 59 anak-anak telah berhasil menyelesaikan studi tahap awal dan bersiap untuk melanjutkan ke jenjang Sekolah Dasar, seperti yang disampaikan oleh Bapak Pdt. Amon Pangemanan dalam renungan Firman bahwa jika anak-anak selalu mengandalkan Tuhan dalam seluruh kehidupan mereka, maka mereka akan selalu berada dalam lindungan Tuhan, seperti ilustrasi ikan yang berada dalam kantung air, dimana ikan itu melambangkan kehidupan anak-anak dan kantung air melambangkan penyertaan Tuhan. Dalam kesempatan kali ini juga Sekertaris Dewan Pengurus Yayasan CBIM, Ibu Yesenia Liyanto berkesempatan hadir untuk membawakan sambutan kepada Kepala Sekolah, Guru, Siswa/I dan orang tua murid. Ibu Yesi menyampaikan rasa terima kasih kepada Orang Tua yang telah mempercayakan TK Kristen Citra Bangsa Mandiri sebagai tempat mereka bermain dan belajar dan menjadi anak-anak yang takut akan Tuhan, juga kepercayaan kembali kepada Sekolah Kristen Citra Bangsa karena Sebagian besar orang tua memilih menempatkan anak-anak untuk melanjutkan studi di SD Kristen Citra Bangsa Mandiri. Ketua Komite TK Kristen Citra Bangsa Mandiri juga turut hadir serta memberikan kata sambutan.</p>', '2024-01-31 15:33:48', '2024-01-31 15:33:48', '1687757345_e5cad6a939525d82b4751.jpg'),
(18, 'WORKSHOP VISI MISI MBKM UCB', '<p>Rabu 21 Juni 2023 Universitas Citra Bangsa mengadakan kegiatan workshop Visi Misi kurikulum meredeka belajar kampus merdeka yang berlangsung selama 3 hari yakni dari tanggal 21 - 23 Juni 2023 di Universitas Citra Bangsa. Dalam workshop ini para civitas akademik Universitas Citra Bangsa yang meliputi Rektor, Wakil Rektor, para Dekan Fakultas, Kaprodi, dan juga Dosen fungsional UCB pun turut hadir dalam workshop. Direktur Eksekutif Yayasan CBIM Bapak Dr. Ir. Semuel A.M Littik, M.Sc., MM turut hadri memberikan paparan materi tentang fungsi Yayasann terhadap tata kelola Universitas Citra Bangsa.</p>', '2024-01-31 15:34:11', '2024-01-31 15:34:11', '1687750662_330386a60d8874b0c87f1.jpg'),
(19, 'JEMBATAN DARI KUPANG KE SELURUH DUNIA', '<p>Kisah penganiayaan TKI-TKW asal NTT menggerakkan Bpk. Ir. Abraham Liyanto mendirikan &nbsp;Balai Latihan Kerja internasional di Kupang tahun 2005.</p><p>BLK ini mendidik tenaga pembantu rumah tangga.</p><p>Namun pak Abraham melihat bahwa pola BLK bukan untuk tenaga kerja profesional.</p><p>Tahun 2007 BLK dibekukan, dan didirikan Yayasan Citra Bina Insan Mandiri (CBIM). &nbsp;Hingga hari ini Bpk. Abraham sebagai Ketua Dewan Pembina Yayasan CBIM.<br>=====</p><p>Tahun 2007, Yayasan CBIM mendirikan Stikes CHMK yg sejak 2019 menjadi UCB. Kampus ini mendidik tenaga kesehatan strata satu bidang keperawatan, kebidanan dan farmasi.</p><p>Beberapa alumni Stikes CHMK bekerja sbg perawat di Australia, Jepang, Hongkong, Italia.<br>======</p><p>Idealisme, komitmen dan aksi membangun manusia NTT yang mandiri dan cerdas, itulah dasar pembangunan jembatan-jembatan dari Kupang ke seluruh bangsa.</p><p>NTT, Nyata Tuhan Tolong, amin</p><p>Sem Littik, jalan tol Kinki Expy dari Kobe ke Osaka.<br>20&nbsp;Juni&nbsp;2025</p>', '2025-06-20 09:17:29', '2025-06-20 09:17:29', 'WhatsApp_Image_2025-06-20_at_08_20_40_dde0554c.jpg');

-- --------------------------------------------------------

--
-- Struktur dari tabel `buku`
--

CREATE TABLE `buku` (
  `id` int(11) NOT NULL,
  `judul` varchar(255) DEFAULT NULL,
  `penulis` varchar(255) DEFAULT NULL,
  `isbn` varchar(50) DEFAULT NULL,
  `tahun` year(4) DEFAULT NULL,
  `deskripsi` text DEFAULT NULL,
  `harga` int(11) DEFAULT NULL,
  `cover` varchar(255) DEFAULT NULL,
  `kategori` char(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

--
-- Dumping data untuk tabel `buku`
--

INSERT INTO `buku` (`id`, `judul`, `penulis`, `isbn`, `tahun`, `deskripsi`, `harga`, `cover`, `kategori`) VALUES
(4, 'Panduan Pembinaan Karakter Kristen PAUD/TK Kristen Citra Bangsa Mandiri', 'Yane Mira Kore, S.Th,S.Pd. Febriana Fransiska Manubulu, S.Pd.,M.Pd. Maktelda M. Banu, S.Pd. Febby M. Liunesi, S.Pd', '', '2025', '', 0, '1000868217.png', 'pendidikan'),
(5, 'Panduan Pembinaan Karakter Kristen SD Kristen Citra Bangsa Mandiri', 'Dra Dihartati, MM. Febriana Fransiska Manubulu, S.Pd.,M.Pd. Lena Natalia, S.Th. Priska Marlindo Benu, S.Th. Yandri Barnabas Mooy, S.Pd. Rayno Yohanes Rumagit, S.Pd. Griselda Elisabeth Amtiran, S.Pd. Lunu Marista Biaf, S.Pd. Meitty Marisa Enok, S.Pd.,Gr', '', '2025', '', 0, '1000868213.png', 'pendidikan'),
(6, 'Panduan Pembinaan Karakter Kristen SMP Kristen Citra Bangsa Mandiri', 'Ev. Jublina Ga, STh, M.Pdk. Febriana Fransiska Manubulu, S.Pd.,M.Pd. Nius Napolion M. Alelang, M.Pd. Semarlica Alberthus, S.Pd.,M.Pd. Jimmy Enok. S.Pd. Ferdy Fernando Doh, S.Pd,K. Christin J.A. Benu, S.Psi. Suriyana Orplin Bey, S.Pd. ', '', '2025', '', 0, '1000868215.png', 'pendidikan'),
(7, 'Panduan Pembinaan Karakter Kristen SMA Kristen Citra Bangsa Mandiri', 'Pdt. Amon M. Pangemanan, S.Th., M.Pd. Febriana Fransiska Manubulu, S.Pd.,M.Pd. Bobi J. A. Manafe, S.Pd. Marlenda Thersiana Selan S.Psi. Johanis Ully, S.Pdk.  Mathilda P. Rinmalae, S.Psi. ', '', '2025', '', 0, '1000868219.png', 'pendidikan');

-- --------------------------------------------------------

--
-- Struktur dari tabel `galeri`
--

CREATE TABLE `galeri` (
  `id_foto` int(11) NOT NULL,
  `judul_foto` varchar(255) NOT NULL,
  `foto` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data untuk tabel `galeri`
--

INSERT INTO `galeri` (`id_foto`, `judul_foto`, `foto`) VALUES
(13, 'Open House Sekolah Kristen Citra Bangsa Mandiri', 'POSTER_OPEN_HOUSE_SEKOLAH_KRISTEN_CITRA_BANGSA_MANDIRI.png'),
(14, 'SPMB Universitas Citra Bangsa', 'SPMB.png'),
(15, 'Mari Bergabung Bersama Kami di Sekolah Kristen Citra Bangsa Mandiri &amp; Universitas Citra Bangsa', 'spanduk_SEKOLAH_UCB.png'),
(16, 'UCB SPMB', 'Brosur_A5_fix.jpg'),
(17, 'Klinik Pratama Citra Husada', 'Brosur_Klinik_PCH_(Ukuran_Lebar_15_cm_x_Tinggi_22_cm).png'),
(18, 'SPMB PROGRAM STUDI D4 PENGELOLAAN PERHOTELAN', 'Brosur_PMB_Pengelolaan_Perhotelan_2025.png'),
(19, 'STRUKTUR ORGANISASI YAYASAN CBIM', 'Struktur_Organisasi_Yayasan_CBIM.png'),
(20, 'Coming Soon!!', 'Coming_soon_Fakultas_Kedokteran_1.png');

-- --------------------------------------------------------

--
-- Struktur dari tabel `konten`
--

CREATE TABLE `konten` (
  `id_konten` int(11) NOT NULL,
  `judul_konten` varchar(255) NOT NULL,
  `sub_judul_konten` varchar(255) DEFAULT NULL,
  `isi_konten` longtext NOT NULL,
  `jenis_konten` enum('legalitas','visi','misi','nilai','operasional','kontak','alamat') NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data untuk tabel `konten`
--

INSERT INTO `konten` (`id_konten`, `judul_konten`, `sub_judul_konten`, `isi_konten`, `jenis_konten`) VALUES
(1, 'Legalitas', 'Legalitas Yayasan Citra Bina Insan Mandiri', '<p><strong>Yayasan Citra Bina Insan Mandiri (CBIM) </strong>adalah Yayasan yang didirikan berdasarkan berdasarkan Akta Pendirian Yayasan Citra Bina Insan Mandiri Nomor 77, tanggal 31 Juli 2007 sebagaimana yang telah beberapa kali diubah terakhir dengan Akta Notaris yang dibuat di hadapan Notaris Pengganti Oriance Bonbalan, S.H., yang menggantikan Notaris Albert Wilson Riwu Kore, S.H., Nomor 17 tanggal 28 Agustus 2023 tentang Perubahan Anggaran Dasar Yayasan Citra Bina Insan Mandiri serta telah diterima perubahan akta tersebut berdasarkan Surat Menteri Hukum Dan Hak Asasi Manusia Republik Indonesia tentang Penerimaan Perubahan Anggaran Dasar dan Data Yayasan Citra Bina Insan Mandiri No. AHU-AH.01.06-0041419 tanggal 30 Agustus 2023, berkedudukan di Jl. Manafe No.17, Kelurahan Kayu Putih, Kecamatan Oebobo, Kota Kupang.&nbsp;</p><p>Yayasan CBIM bertujuan untuk turut serta dalam pembangunan dan pengembangan masyarakat dan daerah Provinsi Nusa Tenggara Timur, khususnya di Kota Kupang, dengan menyelenggarakan pendidikan di sekolah Kristen Citra Bangsa Mandiri di tingkat TK/PAUD, SD, SMP, SMA dan Universitas Citra Bangsa, termasuk menyelenggarakan layanan kesehatan masyarakat pada Klinik Pratama Citra Husada, pelatihan bahasa asing (Inggris, Jepang, Mandarin) dan pengembangan kompetensi guru.</p>', 'legalitas'),
(5, 'Visi', '-', '<p><strong>Visi Yayasan</strong> <strong>CBIM</strong> adalah mewujudkan pendidikan yang humanis, profesional dan bermutu.</p>', 'visi'),
(6, 'Misi', '-', '<p>Misi Yayasan CBIM adalah menyelenggarakan pendidikan yang unggul dan berkualitas, membangun kemitraan dengan stakeholder dalam dan luar negeri, dan mengembangkan kapasitas kelembagaan secara berkesinambungan.</p>', 'misi'),
(7, 'Nilai', '-', '<ul><li><p><i><strong>Trust </strong></i><strong>(kepercayaan)</strong></p><p>Rasa saling percaya antar pimpinan dan karyawan serta antar warga organisasi dan para pemangku kepentingan.</p></li><li><p><i><strong>Energy </strong></i><strong>(energi)</strong></p><p>Partinya mengemban tugas dan tanggung jawab oleh setiap karyawan dengan semangat yang tinggi dan penuh energik.</p></li><li><p><i><strong>Simplicity </strong></i><strong>(sederhana)</strong></p><p>Adalah merupakan partinya membuat prosedur dan proses menjadi sederhana sehingga mudah di selesaikan.</p></li><li><p><i><strong>Intergrity </strong></i><strong>(integritas)</strong></p><p>Partinya memberi solusi masalah secara jujur, tulus dan ikhlas serta konsisten antara tindakan dan tutur kata.</p></li><li><p><i><strong>Sharing </strong></i><strong>(kebersamaan)</strong></p><p>Partinya berbagi gagasan yang kreatif dan inovatif dalam tim kerja dan organisasi untuk membangun sinergi.</p><p>&nbsp;</p></li></ul>', 'nilai'),
(8, 'Operasional', 'Tinjauan Operasional Singkat Yayasan CBIM', '<p>Pengurus Yayasan CBIM terdiridari Dewan Pembina (pendiri dan penentuarah pengembangan), Dewan Pengurus (pengendali implementasi arah pengembangan) dan Dewan Pengawas (menjamin pelaksanaan arah pengembangan). Pengelolaan operasional sehari-hari dilaksanakan oleh Unit Pelaksana Kegiatan (UPK) yang dipimpin oleh Dewan Direksi. Tugas utama UPK adalah secara langsung mendukung Unit Penyelenggara Pendidikan (sekolah dan universitas) dan Unit Layanan Masyarakat (klinik, pelatihan bahasa, keterampilan guru, kerjasama dalam dan luar negeri).</p><p><strong>Kemitraan domestik:</strong></p><p>PT Telkomsel Indonesia (jaringan internet dan telepon), PT ChitekIndolift Utama (layanan lift), PT Yanri Jaya Abadi (keamanan, cleaning service, catering, pemeliharaan fasilitas), Petra Computer Store (jaringan CCTV), PT Bank Pembangunan NTT, PT Bank BRI, PT Bank Mandiri, PT Bank BCA, Kantor Akuntan Publik Johan Malonda dan Rekan (auditor publik untuk akuntansi dan manajemen), PT SEVIMA (SistemInformasiAkademik Universitas, Sistem Informasi Akuntansi, SDM Sistem Informasi), Harper Hotel and Convention Kupang (pelaksanaan program D4 Manajemen Perhotelan, venue kegiatan), PT Citra Mandiri Property (pembangunan dan pemeliharaangedung, pelatihan keterampilan siswa, magang mahasiswa), CV Sarana Timur Sejahtera (pengembangan dan pemeliharaan website), CV Anugrah Abadi (seragam sekolah), PT Asuransi Sinar Mas (asuransi risiko bangunan dan properti), CV ARD Pratama (bahan kimia dan peralatan laboratorium), PT BLUD (penyediaan air bersih), PT Sagraha (pengelolaan limbah berbahaya), Balai Bahasa Propinsi NTT (uji kompetensi Bahasa).</p><p><strong>Kolaborasi internasional:</strong></p><p><i>Haleybury Schools Darwin Australia</i> (pertukaran pelajar, program bahasa Indonesia-Inggris), Kedutaan Besar Australia Jakarta (program <i>BRIDGE</i> untuk koneksi sekolah antara Indonesia dan Australia), <i>Palmerstone Elementary School Australia</i> (kelas online bersama untuk sekolah dasar), Majelis Pendidikan Kristen di Indonesia (pengembangan kompetensi guru, manajemen pendidikan), Konsulat Jenderal Republik Rakyat Tiongkok (peralatan pelatihan bahasa, program pelatihan bahasa Mandarin untuk siswa, mahasiswa, guru dan dosen), pelatihan bahasa dan budaya Jepang untuk ditempatkan sebagai perawat di Jepang: <i>Apri Co. Ltd., Incollex Co. Ltd., Yunagi Human Resources Nurturing Cooperative.</i></p><p><strong>Jejaring Sosial:</strong></p><p>Anggota Majelis Pendidikan Kristen (MPK) di Indonesia, anggota Badan Musyawarah Perguruan Swasta (BMPS) di Indonesia, anggota Asosiasi Perguruan Tinggi Swasta di Indonesia (APTISI).</p>', 'operasional'),
(10, 'Kontak', '-', '<p>Telepon (0380)8553961</p>', 'kontak'),
(11, 'Kantor Kami', '-', '<p>Jl. Manafe No.17 Kel. Kayu Putih, Kec. Oebobo Kota Kupang - NTT</p>', 'alamat');

-- --------------------------------------------------------

--
-- Struktur dari tabel `pesanan`
--

CREATE TABLE `pesanan` (
  `id` int(11) NOT NULL,
  `nama_pembeli` varchar(100) DEFAULT NULL,
  `alamat` text DEFAULT NULL,
  `total_harga` int(11) DEFAULT NULL,
  `tanggal` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

-- --------------------------------------------------------

--
-- Struktur dari tabel `pesanan_detail`
--

CREATE TABLE `pesanan_detail` (
  `id` int(11) NOT NULL,
  `pesanan_id` int(11) DEFAULT NULL,
  `buku_id` int(11) DEFAULT NULL,
  `jumlah` int(11) DEFAULT NULL,
  `subtotal` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

-- --------------------------------------------------------

--
-- Struktur dari tabel `struktur_organisasi`
--

CREATE TABLE `struktur_organisasi` (
  `id_struktur` int(11) NOT NULL,
  `foto` varchar(255) DEFAULT NULL,
  `nama` varchar(255) NOT NULL,
  `jabatan` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data untuk tabel `struktur_organisasi`
--

INSERT INTO `struktur_organisasi` (`id_struktur`, `foto`, `nama`, `jabatan`) VALUES
(23, '1.png', 'Ir. Abraham Paul Liyanto', 'Ketua Dewan Pembina'),
(24, '2.png', 'Dra. F. Anastasia Foe', 'Anggota (Dewan Pembina)'),
(25, '3.png', 'Yesenia I. Liyanto, B.Arts.,MIB,MDI', 'Sekretaris (Dewan Pembina)'),
(26, '4.png', 'Ir. Benny R. Ndoenboey, M.Si', 'Ketua Dewan Pengurus'),
(27, '5.png', 'Elizabeth Tiwu, A.Md', 'Sekertaris (Dewan Pengurus)'),
(31, '6.png', 'Hansel A. Liyanto, S.Si', 'Bendahara (Dewan Pengurus)'),
(32, '7.png', 'Prof. Ir. Frans Umbu Datta, M.App.Sc., Ph.D.', 'Ketua Dewan Pengawas'),
(33, '9.png', 'Drs. Jack J.M. Johannes, M.Si', 'Anggota (Dewan Pengawas)'),
(34, '8.png', 'Dr. Jeffrey Jap, drg.,M.Kes', 'Anggota (Dewan Pengawas)'),
(35, '11.png', 'Dr. Ir. Semuel A.M. Littik, M.Sc.,MM', 'Direktur Eksekutif'),
(36, '21.png', 'Antonetha A.A. Fina, S.H', 'Direktur Operasional'),
(37, '31.png', 'Vera C. Korroh, SST.,MM', 'Direktur Keuangan'),
(38, '41.png', 'Henderik Gunawan, S.Si', 'Direktur Sumber Daya Manusia &amp; Tenkologi Informasi');

-- --------------------------------------------------------

--
-- Struktur dari tabel `video_kegiatan`
--

CREATE TABLE `video_kegiatan` (
  `id_video` int(11) NOT NULL,
  `judul_video` text NOT NULL,
  `deskripsi` longtext NOT NULL,
  `link` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data untuk tabel `video_kegiatan`
--

INSERT INTO `video_kegiatan` (`id_video`, `judul_video`, `deskripsi`, `link`) VALUES
(7, 'Pelatihan Kepemimpinan cbim', '<h3>Pelatihan Kepemimpinan cbim</h3>', 'https://youtu.be/jk4mdjIdqrQ'),
(8, 'ARAHAN DIREKS KEPADA MAHASISWA PENERIMA BEASISWA AF (ABRAHAN FOUNDATION)', '<h3>ARAHAN DIREKS KEPADA MAHASISWA PENERIMA BEASISWA AF (ABRAHAN FOUNDATION)</h3>', 'https://youtu.be/Npjx9zQEhHs'),
(9, 'SIMULASI PENGGUNAAN LAB INSTITUT BAHASA CITRA MANDIRI', '<h3>SIMULASI PENGGUNAAN LAB INSTITUT BAHASA CITRA MANDIRI</h3>', 'https://youtu.be/mCEiIHoJb5E'),
(10, 'CBIM FOUNDATION COLABORATION', '<p>Kolaborasi Antara Yayasan Citra Bina Insan Mandiri bersama mitra di luar negeri</p>', 'https://drive.google.com/file/d/1mvcH-eMcwDLSpBEtIVxsookD6BLqMutz/view?usp=sharing'),
(11, 'SEKOLAH KRISTEN CITRA BANGSA MANDIRI', '', 'https://www.youtube.com/watch?v=_QsQCUoHCzU&t=1s'),
(12, 'NEO PRO UNIVERSITAS CITRA BANGSA', '<p>Keseruan Penutupan <strong>New Student Orientation Program (NEO PRO) </strong>Universitas Citra Bangsa yang digelar selama 3 hari</p>', 'https://www.youtube.com/watch?v=bqgQhNHe0pA'),
(13, 'GATHERING YAYASAN CBIM', '<p>Keseruan Gathering Keluarga Besar Yayasan CBIM di Nekamese</p>', 'https://www.youtube.com/watch?v=r6M2ETumfvg');

-- --------------------------------------------------------

--
-- Struktur dari tabel `visitor_logs`
--

CREATE TABLE `visitor_logs` (
  `id` int(11) NOT NULL,
  `ip_address` varchar(45) NOT NULL,
  `visit_date` date NOT NULL,
  `visit_month` varchar(7) NOT NULL,
  `visit_year` year(4) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3 COLLATE=utf8mb3_general_ci;

--
-- Dumping data untuk tabel `visitor_logs`
--

-- [DISANITASI] 19.455 baris log pengunjung (berisi alamat IP) dihapus dari
-- repositori publik. Struktur tabel tetap ada; statistik mulai dari nol.

--
-- Indexes for dumped tables
--

--
-- Indeks untuk tabel `auth`
--
ALTER TABLE `auth`
  ADD PRIMARY KEY (`id_user`);

--
-- Indeks untuk tabel `berita`
--
ALTER TABLE `berita`
  ADD PRIMARY KEY (`id_berita`);

--
-- Indeks untuk tabel `buku`
--
ALTER TABLE `buku`
  ADD PRIMARY KEY (`id`);

--
-- Indeks untuk tabel `galeri`
--
ALTER TABLE `galeri`
  ADD PRIMARY KEY (`id_foto`);

--
-- Indeks untuk tabel `konten`
--
ALTER TABLE `konten`
  ADD PRIMARY KEY (`id_konten`);

--
-- Indeks untuk tabel `pesanan`
--
ALTER TABLE `pesanan`
  ADD PRIMARY KEY (`id`);

--
-- Indeks untuk tabel `pesanan_detail`
--
ALTER TABLE `pesanan_detail`
  ADD PRIMARY KEY (`id`);

--
-- Indeks untuk tabel `struktur_organisasi`
--
ALTER TABLE `struktur_organisasi`
  ADD PRIMARY KEY (`id_struktur`);

--
-- Indeks untuk tabel `video_kegiatan`
--
ALTER TABLE `video_kegiatan`
  ADD PRIMARY KEY (`id_video`);

--
-- Indeks untuk tabel `visitor_logs`
--
ALTER TABLE `visitor_logs`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT untuk tabel yang dibuang
--

--
-- AUTO_INCREMENT untuk tabel `auth`
--
ALTER TABLE `auth`
  MODIFY `id_user` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=56;

--
-- AUTO_INCREMENT untuk tabel `berita`
--
ALTER TABLE `berita`
  MODIFY `id_berita` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=20;

--
-- AUTO_INCREMENT untuk tabel `buku`
--
ALTER TABLE `buku`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT untuk tabel `galeri`
--
ALTER TABLE `galeri`
  MODIFY `id_foto` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=21;

--
-- AUTO_INCREMENT untuk tabel `konten`
--
ALTER TABLE `konten`
  MODIFY `id_konten` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=13;

--
-- AUTO_INCREMENT untuk tabel `pesanan`
--
ALTER TABLE `pesanan`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT untuk tabel `pesanan_detail`
--
ALTER TABLE `pesanan_detail`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT untuk tabel `struktur_organisasi`
--
ALTER TABLE `struktur_organisasi`
  MODIFY `id_struktur` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=39;

--
-- AUTO_INCREMENT untuk tabel `video_kegiatan`
--
ALTER TABLE `video_kegiatan`
  MODIFY `id_video` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=16;

--
-- AUTO_INCREMENT untuk tabel `visitor_logs`
--
ALTER TABLE `visitor_logs`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=19462;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
