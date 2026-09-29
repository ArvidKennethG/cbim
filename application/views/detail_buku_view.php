<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
       <link rel="shortcut icon" href="<?= base_url(); ?>assets/templates/media/logos/logo-cbim.png" />
    <title><?= htmlspecialchars($buku->judul) ?> - Yayasan Citra Bina Insan Mandiri</title>
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
            margin: 2rem auto;
            padding: 0 1.5rem;
        }
        
        /* Book Detail */
        .book-detail {
            display: flex;
            gap: 3rem;
            background-color: var(--white);
            padding: 2rem;
            border-radius: 10px;
            box-shadow: var(--shadow);
        }
        
        @media (max-width: 768px) {
            .book-detail {
                flex-direction: column;
                gap: 2rem;
            }
        }
        
        .book-cover {
            flex: 0 0 300px;
            height: 400px;
            border-radius: 8px;
            overflow: hidden;
            box-shadow: var(--shadow);
        }
        
        .book-cover img {
            width: 100%;
            height: 100%;
            object-fit: cover;
        }
        
        .book-info {
            flex: 1;
        }
        
        .book-title {
            font-size: 1.8rem;
            margin-bottom: 1rem;
            color: var(--primary);
        }
        
        .book-meta {
            display: flex;
            flex-wrap: wrap;
            gap: 1.5rem;
            margin-bottom: 1.5rem;
        }
        
        .meta-item {
            display: flex;
            align-items: center;
            gap: 0.5rem;
        }
        
        .meta-item i {
            color: var(--secondary);
            font-size: 1.1rem;
        }
        
        .meta-label {
            font-weight: 500;
            color: var(--dark);
        }
        
        .meta-value {
            color: #555;
        }
        
        .price-tag {
            font-size: 1.5rem;
            font-weight: 700;
            color: var(--accent);
            margin: 1.5rem 0;
        }
        
        .price-tag::before {
            content: "Rp";
            font-size: 1rem;
            margin-right: 0.2rem;
        }
        
        .book-description {
            line-height: 1.6;
            color: #555;
            margin-bottom: 2rem;
        }
        
        .action-buttons {
            display: flex;
            gap: 1rem;
            margin-top: 2rem;
        }
        
        .btn {
            padding: 0.8rem 1.5rem;
            border-radius: 6px;
            font-weight: 500;
            text-decoration: none;
            transition: var(--transition);
            display: inline-flex;
            align-items: center;
            justify-content: center;
            gap: 0.5rem;
        }
        
        .btn-primary {
            background-color: var(--secondary);
            color: var(--white);
        }
        
        .btn-primary:hover {
            background-color: var(--primary);
            transform: translateY(-2px);
            box-shadow: 0 5px 15px rgba(52, 152, 219, 0.3);
        }
        
        .btn-outline {
            background-color: var(--white);
            color: var(--secondary);
            border: 1px solid var(--secondary);
        }
        
        .btn-outline:hover {
            background-color: rgba(52, 152, 219, 0.1);
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
                <img src="<?= base_url(); ?>assets/templates/media/logos/logo-cbim.png" alt="Logo Yayasan Citra Bina Insan Mandiri">
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
        <div class="book-detail">
            <div class="book-cover">
                <img src="<?= base_url('uploads/' . $buku->cover) ?>" alt="<?= htmlspecialchars($buku->judul) ?>">
            </div>
            
            <div class="book-info">
                <h1 class="book-title"><?= htmlspecialchars($buku->judul) ?></h1>
                
                <div class="book-meta">
                    <div class="meta-item">
                        <i class="fas fa-user-edit"></i>
                        <div>
                            <span class="meta-label">Penulis</span>
                            <span class="meta-value"><?= htmlspecialchars($buku->penulis) ?></span>
                        </div>
                    </div>
                    
                    <div class="meta-item">
                        <i class="fas fa-barcode"></i>
                        <div>
                            <span class="meta-label">ISBN</span>
                            <span class="meta-value"><?= htmlspecialchars($buku->isbn) ?></span>
                        </div>
                    </div>
                    
                    <div class="meta-item">
                        <i class="fas fa-calendar-alt"></i>
                        <div>
                            <span class="meta-label">Tahun Terbit</span>
                            <span class="meta-value"><?= htmlspecialchars($buku->tahun) ?></span>
                        </div>
                    </div>
                    
                    <div class="meta-item">
                        <i class="fas fa-tags"></i>
                        <div>
                            <span class="meta-label">Kategori</span>
                            <span class="meta-value"><?= ucfirst(htmlspecialchars($buku->kategori ?? 'Umum')) ?></span>
                        </div>
                    </div>
                </div>
                
                <div class="price-tag"><?= number_format($buku->harga, 0, ',', '.') ?></div>
                
                <div class="book-description">
                    <h3>Deskripsi Buku</h3>
                    <p><?= nl2br(htmlspecialchars($buku->deskripsi)) ?></p>
                </div>
                
                <div class="action-buttons">
                    <a href="<?= site_url('katalog/add_to_cart/' . $buku->id) ?>" class="btn btn-primary">
                        <i class="fas fa-cart-plus"></i> Tambah ke Keranjang
                    </a>
                    <a href="<?= site_url('katalog') ?>" class="btn btn-outline">
                        <i class="fas fa-arrow-left"></i> Kembali ke Katalog
                    </a>
                </div>
            </div>
        </div>
    </main>
    
    <!-- Footer -->
    <footer class="footer">
        <div class="container footer-content">
            <img src="<?= base_url(); ?>assets/templates/media/logos/logo-cbim.png" alt="Logo Yayasan" class="footer-logo">
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
</body>
</html>