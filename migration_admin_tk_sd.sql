-- ============================================================================
-- MIGRASI DATABASE: Panel Admin TK & SD
-- ============================================================================
-- Jalankan query ini di phpMyAdmin atau tool database lainnya.
-- 
-- Yang dilakukan:
-- 1. Menambah role admin_tk dan admin_sd ke tabel auth
-- 2. Membuat tabel konten_tk untuk profil TK
-- 3. Membuat tabel konten_sd untuk profil SD
-- ============================================================================

-- 1. Ubah kolom role di tabel auth agar mendukung admin_tk dan admin_sd
--    (Sebelumnya: ENUM('default','administrator','katalog'))
ALTER TABLE `auth` 
MODIFY `role` VARCHAR(30) NOT NULL DEFAULT 'administrator';

-- 2. Buat tabel konten_tk
CREATE TABLE IF NOT EXISTS `konten_tk` (
    `id_konten` INT(11) NOT NULL AUTO_INCREMENT,
    `judul_konten` VARCHAR(255) NOT NULL,
    `sub_judul_konten` VARCHAR(255) DEFAULT NULL,
    `isi_konten` LONGTEXT NOT NULL,
    `jenis_konten` VARCHAR(50) NOT NULL,
    PRIMARY KEY (`id_konten`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- 3. Buat tabel konten_sd
CREATE TABLE IF NOT EXISTS `konten_sd` (
    `id_konten` INT(11) NOT NULL AUTO_INCREMENT,
    `judul_konten` VARCHAR(255) NOT NULL,
    `sub_judul_konten` VARCHAR(255) DEFAULT NULL,
    `isi_konten` LONGTEXT NOT NULL,
    `jenis_konten` VARCHAR(50) NOT NULL,
    PRIMARY KEY (`id_konten`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- 4. (OPSIONAL) Buat akun admin TK dan SD
--    Password: AdminTk2026! dan AdminSd2026!
--    Ganti hash di bawah dengan hasil password_hash() dari PHP jika ingin
--    password berbeda.
--
-- INSERT INTO `auth` (`username`, `password`, `role`) VALUES
-- ('admin_tk', '$2y$10$...hash...', 'admin_tk'),
-- ('admin_sd', '$2y$10$...hash...', 'admin_sd');

-- ============================================================================
-- CATATAN:
-- Tabel konten_tk dan konten_sd juga akan otomatis dibuat oleh controller
-- saat pertama kali halaman profil dibuka (lihat method _ensure_table()).
-- Jadi langkah 2 dan 3 di atas opsional — hanya untuk kejelasan.
-- 
-- Yang WAJIB dijalankan hanya langkah 1 (ALTER TABLE auth).
-- ============================================================================
