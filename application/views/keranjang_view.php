<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Keranjang Belanja - Yayasan Citra Bina Insan Mandiri</title>
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
        
        /* Cart Title */
        .cart-title {
            text-align: center;
            margin: 2rem 0;
            color: var(--primary);
        }
        
        /* Cart Table */
        .cart-table {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 2rem;
            background-color: var(--white);
            border-radius: 10px;
            overflow: hidden;
            box-shadow: var(--shadow);
        }
        
        .cart-table th {
            background-color: var(--primary);
            color: var(--white);
            padding: 1rem;
            text-align: left;
        }
        
        .cart-table td {
            padding: 1rem;
            border-bottom: 1px solid #eee;
        }
        
        .cart-table tr:last-child td {
            border-bottom: none;
        }
        
        .cart-table tr:hover {
            background-color: rgba(52, 152, 219, 0.05);
        }
        
        .qty-control {
            display: flex;
            align-items: center;
            gap: 0.5rem;
        }
        
        .qty-btn {
            width: 30px;
            height: 30px;
            border-radius: 50%;
            background-color: var(--secondary);
            color: var(--white);
            border: none;
            display: flex;
            align-items: center;
            justify-content: center;
            cursor: pointer;
            transition: var(--transition);
        }
        
        .qty-btn:hover {
            background-color: var(--primary);
            transform: scale(1.1);
        }
        
        .remove-btn {
            color: var(--accent);
            background: none;
            border: none;
            cursor: pointer;
            font-size: 1.2rem;
            transition: var(--transition);
        }
        
        .remove-btn:hover {
            transform: scale(1.2);
        }
        
        /* Cart Summary */
        .cart-summary {
            background-color: var(--white);
            padding: 1.5rem;
            border-radius: 10px;
            box-shadow: var(--shadow);
            margin-bottom: 2rem;
            display: flex;
            justify-content: space-between;
            align-items: center;
        }
        
        .total-label {
            font-size: 1.2rem;
            font-weight: 600;
            color: var(--dark);
        }
        
        .total-amount {
            font-size: 1.5rem;
            font-weight: 700;
            color: var(--accent);
        }
        
        /* Cart Actions */
        .cart-actions {
            display: flex;
            justify-content: space-between;
            margin-bottom: 3rem;
        }
        
        .btn {
            padding: 0.8rem 2rem;
            border-radius: 8px;
            font-weight: 500;
            font-size: 1rem;
            cursor: pointer;
            transition: var(--transition);
            display: inline-flex;
            align-items: center;
            justify-content: center;
            text-decoration: none;
            border: none;
        }
        
        .btn-outline {
            background-color: var(--white);
            color: var(--secondary);
            border: 1px solid var(--secondary);
        }
        
        .btn-outline:hover {
            background-color: rgba(52, 152, 219, 0.1);
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
        
        /* Empty Cart */
        .empty-cart {
            text-align: center;
            padding: 3rem;
            background-color: var(--white);
            border-radius: 10px;
            box-shadow: var(--shadow);
            margin-bottom: 2rem;
        }
        
        .empty-cart i {
            font-size: 3rem;
            color: var(--secondary);
            margin-bottom: 1rem;
        }
        
        .empty-cart h3 {
            color: var(--dark);
            margin-bottom: 0.5rem;
        }
        
        .empty-cart p {
            color: #7f8c8d;
            margin-bottom: 1.5rem;
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
        
        /* Responsive */
        @media (max-width: 768px) {
            .yayasan-title h1 {
                font-size: 1.5rem;
            }
            
            .nav-container {
                flex-direction: column;
                gap: 1rem;
            }
            
            .cart-table {
                display: block;
                overflow-x: auto;
            }
            
            .cart-actions {
                flex-direction: column;
                gap: 1rem;
            }
            
            .btn {
                width: 100%;
                text-align: center;
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
        <h2 class="cart-title"><i class="fas fa-shopping-cart"></i> Keranjang Belanja</h2>
        
        <?php if ($this->cart->total_items() > 0): ?>
            <!-- Cart Table -->
            <table class="cart-table">
                <thead>
                    <tr>
                        <th>Judul Buku</th>
                        <th>Harga</th>
                        <th>Jumlah</th>
                        <th>Subtotal</th>
                        <th>Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($this->cart->contents() as $item): ?>
                    <tr>
                        <td><?= $item['name'] ?></td>
                        <td>Rp<?= number_format($item['price'],0,',','.') ?></td>
                        <td>
                            <div class="qty-control">
                                <!--<button class="qty-btn" onclick="updateQty('<?= $item['rowid'] ?>', <?= $item['qty'] - 1 ?>)">-->
                                <!--    <i class="fas fa-minus"></i>-->
                                <!--</button>-->
       
<?php foreach ($this->cart->contents() as $item): ?>
  <form method="post" action="<?= base_url('katalog/update_cart') ?>">
    <div class="qty-control">
      <input type="hidden" name="rowid" value="<?= $item['rowid'] ?>">
      <?php if($item['qty'] > 1): ?>
        <button class="qty-btn" type="submit" name="action" value="kurang">
          <i class="fas fa-minus"></i>
        </button>
      <?php else: ?>

        </button>
      <?php endif; ?>

      <span class="qty-display"><?= $item['qty'] ?></span>
      <input type="hidden" name="qty" value="<?= $item['qty'] ?>">

      <button class="qty-btn" type="submit" name="action" value="tambah">
        <i class="fas fa-plus"></i>
      </button>
    </div>
  </form>
<?php endforeach; ?>
                            </div>
                        </td>
                        <td>Rp<?= number_format($item['subtotal'],0,',','.') ?></td>
                        <td>
                            <form action="<?= site_url('katalog/remove_from_cart') ?>" method="post" onsubmit="return confirm('Hapus item ini?');">
    <input type="hidden" name="rowid" value="<?= $item['rowid'] ?>">
    <button  class="remove-btn" onclick="removeItem('<?= $item['rowid'] ?>' type="submit"><i class="fas fa-trash-alt"></i>Hapus</button>
</form>     </td>
                    </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
            
            <!-- Cart Summary -->
            <div class="cart-summary">
                <span class="total-label">Total Belanja:</span>
                <span class="total-amount">Rp<?= number_format($this->cart->total(),0,',','.') ?></span>
            </div>
            
            <!-- Cart Actions -->
            <div class="cart-actions">
                <a href="<?= site_url('katalog') ?>" class="btn btn-outline">
                    <i class="fas fa-arrow-left"></i> Lanjut Belanja
                </a>
                <a href="<?= site_url('katalog/checkout') ?>" class="btn btn-primary">
                    <i class="fas fa-credit-card"></i> Checkout Sekarang
                </a>
            </div>
        <?php else: ?>
            <!-- Empty Cart -->
            <div class="empty-cart">
                <i class="fas fa-shopping-cart"></i>
                <h3>Keranjang Belanja Kosong</h3>
                <p>Anda belum menambahkan buku ke keranjang belanja</p>
                <a href="<?= site_url('katalog') ?>" class="btn btn-primary">
                    <i class="fas fa-book-open"></i> Lihat Katalog Buku
                </a>
            </div>
        <?php endif; ?>
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
    
    <script>
        // Fungsi untuk mengupdate jumlah item
        function updateQty(rowid, newQty) {
            if (newQty < 1) {
                removeItem(rowid);
                return;
            }
            
            window.location.href = "<?= site_url('katalog/update_cart') ?>?rowid=" + rowid + "&qty=" + newQty;
        }
        
        // Fungsi untuk menghapus item
        function removeItem(rowid) {
            if (confirm('Apakah Anda yakin ingin menghapus item ini dari keranjang?')) {
                window.location.href = "<?= site_url('katalog/remove_from_cart') ?>?rowid=" + rowid;
            }
        }
    </script>
</body>
</html>