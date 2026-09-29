<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Pesanan Berhasil - Yayasan Citra Bina Insan Mandiri</title>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
    <style>
        :root {
            --primary: #2c3e50;
            --secondary: #3498db;
            --accent: #4CAF50;
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
            display: flex;
            flex-direction: column;
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
        
        /* Main Content */
        .container {
            max-width: 1200px;
            margin: 2rem auto;
            padding: 0 1.5rem;
            flex: 1;
            display: flex;
            flex-direction: column;
            justify-content: center;
        }
        
        /* Success Card */
        .success-card {
            background-color: var(--white);
            border-radius: 10px;
            padding: 3rem 2rem;
            text-align: center;
            box-shadow: var(--shadow);
            max-width: 600px;
            margin: 0 auto;
            position: relative;
            overflow: hidden;
        }
        
        .success-icon {
            width: 80px;
            height: 80px;
            background-color: rgba(76, 175, 80, 0.1);
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            margin: 0 auto 1.5rem;
            color: var(--accent);
            font-size: 2.5rem;
            animation: bounce 1s ease;
        }
        
        @keyframes bounce {
            0%, 20%, 50%, 80%, 100% {transform: translateY(0);}
            40% {transform: translateY(-20px);}
            60% {transform: translateY(-10px);}
        }
        
        .success-title {
            font-size: 2rem;
            margin-bottom: 1rem;
            color: var(--primary);
        }
        
        .success-message {
            font-size: 1.1rem;
            margin-bottom: 2rem;
            color: #555;
            line-height: 1.6;
        }
        
        .order-details {
            background-color: rgba(236, 240, 241, 0.5);
            border-radius: 8px;
            padding: 1.5rem;
            margin-bottom: 2rem;
            text-align: left;
        }
        
        .detail-item {
            display: flex;
            justify-content: space-between;
            margin-bottom: 0.8rem;
        }
        
        .detail-item:last-child {
            margin-bottom: 0;
        }
        
        .detail-label {
            font-weight: 500;
            color: var(--dark);
        }
        
        .detail-value {
            font-weight: 600;
            color: var(--accent);
        }
        
        .total-item {
            border-top: 1px solid #ddd;
            padding-top: 1rem;
            margin-top: 1rem;
            font-size: 1.1rem;
        }
        
        .action-buttons {
            display: flex;
            justify-content: center;
            gap: 1rem;
            margin-top: 2rem;
        }
        
        .btn {
            padding: 0.8rem 2rem;
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
            margin-top: auto;
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
        
        /* Responsive */
        @media (max-width: 768px) {
            .yayasan-title h1 {
                font-size: 1.5rem;
            }
            
            .success-card {
                padding: 2rem 1.5rem;
            }
            
            .success-title {
                font-size: 1.8rem;
            }
            
            .action-buttons {
                flex-direction: column;
            }
            
            .btn {
                width: 100%;
            }
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
        <div class="success-card">
            <div class="success-icon">
                <i class="fas fa-check"></i>
            </div>
            <h2 class="success-title">Pesanan Berhasil!</h2>
            <p class="success-message">Terima kasih, pesanan Anda telah kami terima dan sedang diproses. Detail pesanan telah dikirim ke email Anda.</p>
            
            <div class="order-details">
                <div class="detail-item">
                    <span class="detail-label">Nomor Pesanan:</span>
                    <span class="detail-value">#<?= rand(1000, 9999) ?></span>
                </div>
                <div class="detail-item">
                    <span class="detail-label">Tanggal:</span>
                    <span class="detail-value"><?= date('d/m/Y') ?></span>
                </div>
                <div class="detail-item">
                    <span class="detail-label">Total Pembayaran:</span>
                    <span class="detail-value">Rp<?= number_format($this->cart->total(),0,',','.') ?></span>
                </div>
                <div class="detail-item total-item">
                    <span class="detail-label">Metode Pembayaran:</span>
                    <span class="detail-value">Transfer Bank</span>
                </div>
            </div>
            
            <div class="action-buttons">
                <a href="<?= site_url('katalog') ?>" class="btn btn-primary">
                    <i class="fas fa-book-open"></i> Kembali ke Katalog
                </a>
                <a href="#" class="btn btn-outline">
                    <i class="fas fa-file-alt"></i> Lihat Invoice
                </a>
            </div>
        </div>
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
</body>
</html>