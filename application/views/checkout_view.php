<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Checkout - Yayasan Citra Bina Insan Mandiri</title>
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
        
        /* Checkout Title */
        .checkout-title {
            text-align: center;
            margin: 2rem 0;
            color: var(--primary);
        }
        
        /* Checkout Wrapper */
        .checkout-wrapper {
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 2rem;
            margin-bottom: 3rem;
        }
        
        @media (max-width: 768px) {
            .checkout-wrapper {
                grid-template-columns: 1fr;
            }
        }
        
        /* Checkout Form */
        .checkout-form {
            background-color: var(--white);
            padding: 2rem;
            border-radius: 10px;
            box-shadow: var(--shadow);
        }
        
        .form-title {
            font-size: 1.5rem;
            margin-bottom: 1.5rem;
            color: var(--primary);
            display: flex;
            align-items: center;
            gap: 0.5rem;
        }
        
        .form-group {
            margin-bottom: 1.5rem;
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
            min-height: 120px;
            resize: vertical;
        }
        
        /* Order Summary */
        .order-summary {
            background-color: var(--white);
            padding: 2rem;
            border-radius: 10px;
            box-shadow: var(--shadow);
            align-self: start;
        }
        
        .summary-title {
            font-size: 1.5rem;
            margin-bottom: 1.5rem;
            color: var(--primary);
            display: flex;
            align-items: center;
            gap: 0.5rem;
        }
        
        .order-items {
            margin-bottom: 1.5rem;
        }
        
        .order-item {
            display: flex;
            justify-content: space-between;
            padding: 0.8rem 0;
            border-bottom: 1px solid #eee;
        }
        
        .order-item:last-child {
            border-bottom: none;
        }
        
        .item-name {
            color: var(--dark);
        }
        
        .item-price {
            color: var(--accent);
            font-weight: 500;
        }
        
        .order-total {
            padding: 1rem 0;
            border-top: 2px solid var(--primary);
            margin-top: 1rem;
            display: flex;
            justify-content: space-between;
            font-size: 1.2rem;
            font-weight: 600;
        }
        
        .total-label {
            color: var(--dark);
        }
        
        .total-amount {
            color: var(--accent);
        }
        
        /* Payment Methods */
        .payment-methods {
            margin-top: 2rem;
        }
        
        .payment-title {
            font-size: 1.2rem;
            margin-bottom: 1rem;
            color: var(--dark);
        }
        
        .payment-option {
            display: flex;
            align-items: center;
            gap: 0.8rem;
            margin-bottom: 0.8rem;
            padding: 0.8rem;
            border: 1px solid #ddd;
            border-radius: 6px;
            cursor: pointer;
            transition: var(--transition);
        }
        
        .payment-option:hover {
            border-color: var(--secondary);
        }
        
        .payment-option input[type="radio"] {
            margin: 0;
        }
        
        /* Submit Button */
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
            margin-top: 1.5rem;
        }
        
        .submit-btn:hover {
            background-color: var(--primary);
            transform: translateY(-2px);
            box-shadow: 0 5px 15px rgba(52, 152, 219, 0.3);
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
        <h2 class="checkout-title"><i class="fas fa-credit-card"></i> Checkout</h2>
        
        <div class="checkout-wrapper">
            <!-- Checkout Form -->
            <form method="post" action="<?= site_url('katalog/proses_checkout') ?>" class="checkout-form">
                <h3 class="form-title"><i class="fas fa-user"></i> Informasi Pembeli</h3>
                
                <div class="form-group">
                    <label for="nama" class="form-label">Nama Lengkap</label>
                    <input type="text" id="nama" name="nama" class="form-control" required>
                </div>
                
                <div class="form-group">
                    <label for="email" class="form-label">Email</label>
                    <input type="email" id="email" name="email" class="form-control" required>
                </div>
                
                <div class="form-group">
                    <label for="telepon" class="form-label">Nomor Telepon</label>
                    <input type="tel" id="telepon" name="telepon" class="form-control" required>
                </div>
                
                <div class="form-group">
                    <label for="alamat" class="form-label">Alamat Lengkap</label>
                    <textarea id="alamat" name="alamat" class="form-control" required></textarea>
                </div>
                
                <div class="form-group">
                    <label for="catatan" class="form-label">Catatan (Opsional)</label>
                    <textarea id="catatan" name="catatan" class="form-control"></textarea>
                </div>
                
                <button type="submit" class="submit-btn">
                    <i class="fas fa-shopping-bag"></i> Proses Pembayaran
                </button>
            </form>
            
            <!-- Order Summary -->
            <div class="order-summary">
                <h3 class="summary-title"><i class="fas fa-receipt"></i> Ringkasan Pesanan</h3>
                
                <div class="order-items">
                    <?php foreach ($this->cart->contents() as $item): ?>
                    <div class="order-item">
                        <span class="item-name"><?= $item['name'] ?> (<?= $item['qty'] ?>x)</span>
                        <span class="item-price">Rp<?= number_format($item['subtotal'],0,',','.') ?></span>
                    </div>
                    <?php endforeach; ?>
                </div>
                
                <div class="order-total">
                    <span class="total-label">Total</span>
                    <span class="total-amount">Rp<?= number_format($this->cart->total(),0,',','.') ?></span>
                </div>
                
                <div class="payment-methods">
                    <h4 class="payment-title"><i class="fas fa-money-bill-wave"></i> Metode Pembayaran</h4>
                    
                    <div class="payment-option">
                        <input type="radio" id="transfer" name="payment_method" value="transfer" checked>
                        <label for="transfer">Transfer Bank</label>
                    </div>
                    
                    <div class="payment-option">
                        <input type="radio" id="cod" name="payment_method" value="cod">
                        <label for="cod">Cash on Delivery (COD)</label>
                    </div>
                    
                    <div class="payment-option">
                        <input type="radio" id="qris" name="payment_method" value="qris">
                        <label for="qris">QRIS</label>
                    </div>
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