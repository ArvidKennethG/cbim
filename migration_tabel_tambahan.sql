-- =============================================================================
-- MIGRATION: TABEL YANG DIPAKAI KODE TAPI TIDAK ADA DI DUMP u1711594_yayasan_v2.sql
-- =============================================================================
-- Dump database (10 Agustus 2026) hanya berisi 10 tabel. Kode aplikasi juga
-- membaca/menulis 6 tabel di bawah ini. Tanpa tabel-tabel ini, halaman berikut
-- gagal dengan "A Database Error Occurred ... Table ... doesn't exist":
--   - Formulir PPDB TK (/tk/ppdb) dan SD (/sd/ppdb), formulir /pendaftaran
--   - Formulir kontak (/kontak) dan langganan newsletter
--   - Admin: Pendaftaran, Pesan Kontak, Newsletter, Ekspor CSV
--   - API /api/units
--
-- Struktur kolom diturunkan langsung dari kode (insert/update/select di
-- controller dan view). Aman dijalankan berulang (IF NOT EXISTS).
--
-- Cara pakai (setelah import u1711594_yayasan_v2.sql):
--   mysql -u USER -p NAMA_DB < migration_tabel_tambahan.sql
-- atau lewat phpMyAdmin: pilih database > tab SQL > tempel isi file ini.
-- =============================================================================

-- Sumber kebenaran pendaftaran semua jenjang (dipakai Admin > Pendaftaran,
-- ekspor CSV, API units). Ditulis oleh Pendaftaran.php, Tk.php, Sd.php.
CREATE TABLE IF NOT EXISTS `pendaftaran` (
  `id_pendaftaran` INT(11) NOT NULL AUTO_INCREMENT,
  `no_registrasi`  VARCHAR(40)  NOT NULL,
  `jenjang`        VARCHAR(10)  NOT NULL,
  `nama_lengkap`   VARCHAR(200) NOT NULL,
  `nik_nisn`       VARCHAR(20)  NOT NULL DEFAULT '',
  `jenis_kelamin`  VARCHAR(20)  NOT NULL,
  `tempat_lahir`   VARCHAR(100) NOT NULL DEFAULT '',
  `tgl_lahir`      DATE NULL DEFAULT NULL,
  `agama`          VARCHAR(30)  NOT NULL DEFAULT '',
  `nama_ortu`      VARCHAR(200) NOT NULL,
  `pekerjaan_ortu` VARCHAR(100) NOT NULL DEFAULT '',
  `no_hp`          VARCHAR(25)  NOT NULL,
  `email`          VARCHAR(150) NOT NULL DEFAULT '',
  `alamat`         TEXT NOT NULL,
  `asal_sekolah`   VARCHAR(150) NOT NULL DEFAULT '',
  `catatan`        TEXT NULL,
  `status`         VARCHAR(30)  NOT NULL DEFAULT 'Baru',
  `tanggal_daftar` DATETIME NOT NULL,
  PRIMARY KEY (`id_pendaftaran`),
  KEY `idx_jenjang` (`jenjang`),
  KEY `idx_status` (`status`),
  KEY `idx_no_registrasi` (`no_registrasi`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- Tabel lama per jenjang (masih ditulis untuk kompatibilitas mundur).
CREATE TABLE IF NOT EXISTS `pendaftaran_sd` (
  `id_pendaftaran` INT(11) NOT NULL AUTO_INCREMENT,
  `nama_lengkap`   VARCHAR(200) NOT NULL,
  `nisn`           VARCHAR(20)  NOT NULL DEFAULT '',
  `jenis_kelamin`  VARCHAR(20)  NOT NULL,
  `tempat_lahir`   VARCHAR(100) NOT NULL DEFAULT '',
  `tgl_lahir`      DATE NULL DEFAULT NULL,
  `nama_ortu`      VARCHAR(200) NOT NULL,
  `no_hp`          VARCHAR(25)  NOT NULL,
  `alamat`         TEXT NOT NULL,
  `tanggal_daftar` DATETIME NOT NULL,
  `status`         VARCHAR(30)  NOT NULL DEFAULT 'Baru',
  PRIMARY KEY (`id_pendaftaran`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

CREATE TABLE IF NOT EXISTS `pendaftaran_tk` (
  `id_pendaftaran` INT(11) NOT NULL AUTO_INCREMENT,
  `nama_lengkap`   VARCHAR(200) NOT NULL,
  `kelompok`       VARCHAR(100) NOT NULL DEFAULT '',
  `jenis_kelamin`  VARCHAR(20)  NOT NULL,
  `tgl_lahir`      DATE NULL DEFAULT NULL,
  `nama_ortu`      VARCHAR(200) NOT NULL,
  `no_hp`          VARCHAR(25)  NOT NULL,
  `alamat`         TEXT NOT NULL,
  `tanggal_daftar` DATETIME NOT NULL,
  `status`         VARCHAR(30)  NOT NULL DEFAULT 'Baru',
  PRIMARY KEY (`id_pendaftaran`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- Formulir kontak /kontak (Kontak.php) + Admin > Pesan Kontak.
CREATE TABLE IF NOT EXISTS `pesan_kontak` (
  `id_pesan`   INT(11) NOT NULL AUTO_INCREMENT,
  `nama`       VARCHAR(150) NOT NULL,
  `email`      VARCHAR(150) NOT NULL,
  `subjek`     VARCHAR(200) NOT NULL,
  `pesan`      TEXT NOT NULL,
  `ip_address` VARCHAR(45)  NOT NULL,
  `status`     VARCHAR(30)  NOT NULL DEFAULT 'Belum Dibaca',
  `created_at` DATETIME NOT NULL,
  PRIMARY KEY (`id_pesan`),
  KEY `idx_ip_created` (`ip_address`, `created_at`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- Langganan warta (Newsletter.php) + Admin > Newsletter.
CREATE TABLE IF NOT EXISTS `newsletter_subscribers` (
  `id_subscriber`     INT(11) NOT NULL AUTO_INCREMENT,
  `email`             VARCHAR(150) NOT NULL,
  `preferensi`        VARCHAR(100) NOT NULL DEFAULT 'semua',
  `token_unsubscribe` VARCHAR(64)  NOT NULL,
  `status`            VARCHAR(20)  NOT NULL DEFAULT 'Aktif',
  `created_at`        DATETIME NOT NULL,
  PRIMARY KEY (`id_subscriber`),
  UNIQUE KEY `uniq_email` (`email`),
  KEY `idx_token` (`token_unsubscribe`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- Hanya dipakai controller Contact.php (/contact/submit), yang tidak ditautkan
-- dari halaman mana pun. Struktur diambil dari komentar di Contact_model.php.
CREATE TABLE IF NOT EXISTS `contact_messages` (
  `id`         INT(11) NOT NULL AUTO_INCREMENT,
  `nama`       VARCHAR(100) NOT NULL,
  `email`      VARCHAR(100) NOT NULL,
  `subjek`     VARCHAR(200) NOT NULL,
  `pesan`      TEXT NOT NULL,
  `ip_address` VARCHAR(45)  NOT NULL,
  `created_at` DATETIME NOT NULL,
  `status`     ENUM('unread','read','replied') DEFAULT 'unread',
  PRIMARY KEY (`id`),
  KEY `idx_ip_created` (`ip_address`, `created_at`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;
