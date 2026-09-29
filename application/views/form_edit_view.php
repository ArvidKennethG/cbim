<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Buku - Yayasan Citra Bina Insan Mandiri</title>
       <link rel="shortcut icon" href="<?= base_url(); ?>assets/templates/media/logos/logo-cbim.png" />
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
    <style>
        :root {
            --primary: #2c3e50;
            --secondary: #3498db;
            --accent: #e74c3c;
            --light: #ecf0f1;
            --dark: #2c3e50;
            --white: #ffffff;
            --shadow: 0 10px 20px rgba(0, 0, 0, 0.1);
            --transition: all 0.3s cubic-bezier(0.25, 0.8, 0.25, 1);
        }
        
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }
        
        body {
            font-family: 'Poppins', sans-serif;
            background-color: var(--light);
            color: var(--dark);
            min-height: 100vh;
        }
        
        /* Header Yayasan */
        .yayasan-header {
            background: linear-gradient(135deg, var(--primary) 0%, var(--secondary) 100%);
            color: var(--white);
            padding: 1rem 0;
            text-align: center;
            position: relative;
            box-shadow: var(--shadow);
        }
        
        .yayasan-logo {
            display: flex;
            align-items: center;
            justify-content: center;
            margin-bottom: 1rem;
        }
        
        .yayasan-logo img {
            height: 60px;
            margin-right: 15px;
        }
        
        .yayasan-title {
            text-align: center;
        }
        
        .yayasan-title h1 {
            font-size: 1.8rem;
            font-weight: 700;
            margin-bottom: 0.3rem;
        }
        
        .yayasan-title p {
            font-size: 0.9rem;
            opacity: 0.9;
        }
        
        /* Navigation */
        .main-nav {
            background-color: var(--primary);
            padding: 0.8rem 0;
        }
        
        .nav-container {
            display: flex;
            justify-content: space-between;
            align-items: center;
            max-width: 1200px;
            margin: 0 auto;
            padding: 0 1.5rem;
        }
        
        .nav-links {
            display: flex;
            gap: 1.5rem;
        }
        
        .nav-link {
            color: var(--white);
            text-decoration: none;
            font-weight: 500;
            transition: var(--transition);
            display: flex;
            align-items: center;
            gap: 0.5rem;
        }
        
        .nav-link:hover {
            color: var(--accent);
        }
        
        /* Container */
        .container {
            max-width: 1200px;
            margin: 0 auto;
            padding: 0 1.5rem;
        }
        
        /* Form Title */
        .form-page-title {
            text-align: center;
            margin: 2rem 0;
            color: var(--primary);
        }
        
        /* Book Form */
        .book-form {
            background-color: var(--white);
            padding: 2rem;
            border-radius: 10px;
            box-shadow: var(--shadow);
            max-width: 800px;
            margin: 0 auto 3rem;
        }
        
        .form-header {
            display: flex;
            align-items: center;
            gap: 0.8rem;
            margin-bottom: 1.5rem;
            color: var(--primary);
        }
        
        .form-header i {
            font-size: 1.5rem;
        }
        
        .form-header h2 {
            font-size: 1.5rem;
        }
        
        .form-grid {
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 1.5rem;
        }
        
        @media (max-width: 768px) {
            .form-grid {
                grid-template-columns: 1fr;
            }
        }
        
        .form-group {
            margin-bottom: 1.5rem;
        }
        
        .form-group.full-width {
            grid-column: 1 / -1;
        }
        
        .form-label {
            display: block;
            margin-bottom: 0.5rem;
            font-weight: 500;
            color: var(--dark);
        }
        
        .form-control {
            width: 100%;
            padding: 0.8rem 1rem;
            border: 1px solid #ddd;
            border-radius: 6px;
            font-family: 'Poppins', sans-serif;
            transition: var(--transition);
        }
        
        .form-control:focus {
            outline: none;
            border-color: var(--secondary);
            box-shadow: 0 0 0 2px rgba(52, 152, 219, 0.2);
        }
        
        textarea.form-control {
            min-height: 150px;
            resize: vertical;
        }
        
        .file-upload {
            position: relative;
            display: inline-block;
            width: 100%;
        }
        
        .file-upload-input {
            width: 100%;
            padding: 1rem;
            border: 1px dashed #ccc;
            border-radius: 6px;
            background-color: #f9f9f9;
            transition: var(--transition);
        }
        
        .file-upload-input:hover {
            border-color: var(--secondary);
            background-color: rgba(52, 152, 219, 0.05);
        }
        
        .file-upload-label {
            display: flex;
            flex-direction: column;
            align-items: center;
            justify-content: center;
            padding: 1.5rem;
            cursor: pointer;
            text-align: center;
        }
        
        .file-upload-label i {
            font-size: 2rem;
            color: var(--secondary);
            margin-bottom: 0.8rem;
        }
        
        .file-upload-label span {
            color: #666;
        }
        
        .file-upload-label strong {
            color: var(--secondary);
            font-weight: 500;
        }
        
        .file-name {
            margin-top: 0.5rem;
            font-size: 0.9rem;
            color: var(--secondary);
            font-weight: 500;
        }
        
        .current-cover {
            width: 100%;
            max-height: 200px;
            object-fit: contain;
            border-radius: 6px;
            border: 1px solid #eee;
            margin-bottom: 1rem;
        }
        
        .submit-btn {
            width: 100%;
            padding: 1rem;
            background-color: var(--secondary);
            color: var(--white);
            border: none;
            border-radius: 6px;
            font-family: 'Poppins', sans-serif;
            font-size: 1rem;
            font-weight: 500;
            cursor: pointer;
            transition: var(--transition);
            display: flex;
            align-items: center;
            justify-content: center;
            gap: 0.5rem;
            margin-top: 1rem;
        }
        
        .submit-btn:hover {
            background-color: var(--primary);
            transform: translateY(-2px);
            box-shadow: 0 5px 15px rgba(52, 152, 219, 0.3);
        }
        
        /* Preview Cover */
        .cover-preview {
            width: 100%;
            max-height: 200px;
            object-fit: contain;
            border-radius: 6px;
            border: 1px solid #eee;
            margin-top: 1rem;
            display: none;
        }
        
        /* Footer */
        .footer {
            background: var(--primary);
            color: var(--white);
            padding: 2rem 0;
            text-align: center;
            margin-top: 3rem;
        }
        
        .footer-content {
            display: flex;
            flex-direction: column;
            align-items: center;
        }
        
        .footer-logo {
            height: 50px;
            margin-bottom: 1rem;
        }
        
        .footer-info {
            margin-bottom: 1rem;
            line-height: 1.6;
        }
        
        .social-links {
            display: flex;
            gap: 1rem;
            margin-bottom: 1rem;
        }
        
        .social-link {
            color: var(--white);
            font-size: 1.2rem;
            transition: var(--transition);
        }
        
        .social-link:hover {
            color: var(--secondary);
            transform: translateY(-3px);
        }
        
        .copyright {
            font-size: 0.9rem;
            opacity: 0.8;
        }
    </style>
</head>
<body>
    <!-- Header Yayasan -->
    <header class="yayasan-header">
        <div class="container">
            <div class="yayasan-logo">
                <!-- Ganti dengan logo yayasan yang sesuai -->
                <img src="https://via.placeholder.com/60x60?text=CBIM" alt="Logo Yayasan Citra Bina Insan Mandiri">
                <div class="yayasan-title">
                    <h1>Yayasan Citra Bina Insan Mandiri</h1>
                    <p>Membangun Generasi Berkarakter dan Berprestasi</p>
                </div>
            </div>
        </div>
    </header>
    
    <!-- Navigation -->
    <nav class="main-nav">
        <div class="nav-container">
            <div class="nav-links">
                <a href="<?= site_url('katalog') ?>" class="nav-link">
                    <i class="fas fa-home"></i> Beranda
                </a>
                <a href="<?= site_url('katalog/cart') ?>" class="nav-link">
                    <i class="fas fa-shopping-cart"></i> Keranjang
                </a>
                <a href="<?= site_url('katalog/tambah_buku') ?>" class="nav-link">
                    <i class="fas fa-plus-circle"></i> Tambah Buku
                </a>
            </div>
        </div>
    </nav>
    
    <!-- Main Content -->
    <main class="container">
        <h2 class="form-page-title"><i class="fas fa-edit"></i> Edit Buku</h2>
        
        <form method="post" action="<?= site_url('katalog/edit_buku/' . $buku->id) ?>" enctype="multipart/form-data" class="book-form">
            <div class="form-header">
                <i class="fas fa-info-circle"></i>
                <h2>Informasi Buku</h2>
            </div>
            
            <div class="form-grid">
                <div class="form-group">
                    <label for="judul" class="form-label">Judul Buku</label>
                    <input type="text" id="judul" name="judul" class="form-control" value="<?= htmlspecialchars($buku->judul) ?>" required>
                </div>
                
                <div class="form-group">
                    <label for="penulis" class="form-label">Penulis</label>
                    <input type="text" id="penulis" name="penulis" class="form-control" value="<?= htmlspecialchars($buku->penulis) ?>" required>
                </div>
                
                <div class="form-group">
                    <label for="isbn" class="form-label">ISBN</label>
                    <input type="text" id="isbn" name="isbn" class="form-control" value="<?= htmlspecialchars($buku->isbn) ?>">
                </div>
                
                <div class="form-group">
                    <label for="tahun" class="form-label">Tahun Terbit</label>
                    <input type="number" id="tahun" name="tahun" class="form-control" min="1900" max="<?= date('Y') ?>" value="<?= htmlspecialchars($buku->tahun) ?>">
                </div>
                
                <div class="form-group">
                    <label for="harga" class="form-label">Harga (Rp)</label>
                    <input type="number" id="harga" name="harga" class="form-control" min="0" value="<?= htmlspecialchars($buku->harga) ?>" required>
                </div>
                
                <div class="form-group">
                    <label for="kategori" class="form-label">Kategori</label>
                    <select id="kategori" name="kategori" class="form-control">
                        <option value="pendidikan" <?= $buku->kategori == 'pendidikan' ? 'selected' : '' ?>>Pendidikan</option>
                        <option value="novel" <?= $buku->kategori == 'novel' ? 'selected' : '' ?>>Novel</option>
                        <option value="bisnis" <?= $buku->kategori == 'bisnis' ? 'selected' : '' ?>>Bisnis</option>
                        <option value="anak" <?= $buku->kategori == 'anak' ? 'selected' : '' ?>>Buku Anak</option>
                        <option value="lainnya" <?= $buku->kategori == 'lainnya' ? 'selected' : '' ?>>Lainnya</option>
                    </select>
                </div>
                
                <div class="form-group full-width">
                    <label for="deskripsi" class="form-label">Deskripsi</label>
                    <textarea id="deskripsi" name="deskripsi" class="form-control"><?= htmlspecialchars($buku->deskripsi) ?></textarea>
                </div>
                
                <div class="form-group full-width">
                    <label class="form-label">Cover Buku Saat Ini</label>
                    <img src="<?= base_url('uploads/' . $buku->cover) ?>" class="current-cover" alt="Cover Saat Ini">
                    
                    <label class="form-label">Ganti Cover (Opsional)</label>
                    <div class="file-upload">
                        <input type="file" id="cover" name="cover" class="file-upload-input" accept="image/*" onchange="previewCover(this)">
                        <label for="cover" class="file-upload-label">
                            <i class="fas fa-cloud-upload-alt"></i>
                            <span>Drag & drop file cover baru atau <strong>klik untuk memilih</strong></span>
                            <span class="file-name" id="file-name">Biarkan kosong jika tidak ingin mengganti cover</span>
                        </label>
                        <img id="cover-preview" class="cover-preview" alt="Preview Cover Baru">
                    </div>
                </div>
            </div>
            
            <button type="submit" class="submit-btn">
                <i class="fas fa-save"></i> Update Buku
            </button>
        </form>
    </main>
    
    <!-- Footer -->
    <footer class="footer">
        <div class="container footer-content">
            <img src="https://via.placeholder.com/50x50?text=CBIM" alt="Logo Yayasan" class="footer-logo">
            <div class="footer-info">
                <h3>Yayasan Citra Bina Insan Mandiri</h3>
         
            </div>
            <div class="social-links">
                <a href="#" class="social-link"><i class="fab fa-facebook-f"></i></a>
                <a href="#" class="social-link"><i class="fab fa-twitter"></i></a>
                <a href="#" class="social-link"><i class="fab fa-instagram"></i></a>
                <a href="#" class="social-link"><i class="fab fa-youtube"></i></a>
            </div>
            <p class="copyright">&copy; <?= date('Y') ?> Yayasan Citra Bina Insan Mandiri. All Rights Reserved.</p>
        </div>
    </footer>
    
    <script>
        // Fungsi untuk preview cover baru
        function previewCover(input) {
            const file = input.files[0];
            const fileName = document.getElementById('file-name');
            const preview = document.getElementById('cover-preview');
            
            if (file) {
                fileName.textContent = file.name;
                
                const reader = new FileReader();
                reader.onload = function(e) {
                    preview.src = e.target.result;
                    preview.style.display = 'block';
                }
                reader.readAsDataURL(file);
            } else {
                fileName.textContent = 'Biarkan kosong jika tidak ingin mengganti cover';
                preview.style.display = 'none';
            }
        }
    </script>
</body>
</html>