<!-- =====================================================Created with patience by  (Ernest_PROWE)======================================= -->
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Katalog Buku - Yayasan Citra Bina Insan Mandiri</title>
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
        
        /* Search Bar */
        .search-container {
            position: relative;
            width: 300px;
        }
        
        .search-input {
            width: 100%;
            padding: 0.6rem 1rem 0.6rem 2.5rem;
            border-radius: 30px;
            border: none;
            background-color: rgba(255, 255, 255, 0.2);
            color: var(--white);
            font-family: 'Poppins', sans-serif;
            transition: var(--transition);
        }
        
        .search-input::placeholder {
            color: rgba(255, 255, 255, 0.7);
        }
        
        .search-input:focus {
            outline: none;
            background-color: rgba(255, 255, 255, 0.3);
            box-shadow: 0 0 0 2px var(--accent);
        }
        
        .search-icon {
            position: absolute;
            left: 1rem;
            top: 50%;
            transform: translateY(-50%);
            color: var(--white);
        }
        
        /* Hero Section */
        .hero {
            background: url('https://images.unsplash.com/photo-1524995997946-a1c2e315a42f?ixlib=rb-1.2.1&auto=format&fit=crop&w=1350&q=80') center/cover;
            color: var(--white);
            padding: 4rem 0;
            text-align: center;
            position: relative;
            margin-bottom: 3rem;
        }
        
        .hero::before {
            content: "";
            position: absolute;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background: rgba(0, 0, 0, 0.6);
        }
        
        .hero-content {
            position: relative;
            z-index: 1;
        }
        
        .hero h2 {
            font-size: 2.5rem;
            font-weight: 700;
            margin-bottom: 1rem;
            text-shadow: 0 2px 5px rgba(0,0,0,0.3);
        }
        
        .hero p {
            font-size: 1.2rem;
            max-width: 700px;
            margin: 0 auto 1.5rem;
            text-shadow: 0 1px 3px rgba(0,0,0,0.3);
        }
        
        /* Container */
        .container {
            max-width: 1200px;
            margin: 0 auto;
            padding: 0 1.5rem;
        }
        
        /* Filter Section */
        .filter-section {
            background-color: var(--white);
            padding: 1.5rem;
            border-radius: 10px;
            box-shadow: var(--shadow);
            margin-bottom: 2rem;
            display: flex;
            flex-wrap: wrap;
            gap: 1rem;
            align-items: center;
        }
        
        .filter-group {
            display: flex;
            flex-direction: column;
            min-width: 200px;
        }
        
        .filter-label {
            font-size: 0.9rem;
            margin-bottom: 0.5rem;
            font-weight: 500;
            color: var(--dark);
        }
        
        .filter-select {
            padding: 0.6rem 1rem;
            border-radius: 6px;
            border: 1px solid #ddd;
            font-family: 'Poppins', sans-serif;
            background-color: var(--white);
            transition: var(--transition);
        }
        
        .filter-select:focus {
            outline: none;
            border-color: var(--secondary);
            box-shadow: 0 0 0 2px rgba(52, 152, 219, 0.2);
        }
        
        /* Book Grid */
        .book-grid {
            display: grid;
            grid-template-columns: repeat(auto-fill, minmax(280px, 1fr));
            gap: 2rem;
            margin-bottom: 3rem;
        }
        
        .book-card {
            background: var(--white);
            border-radius: 10px;
            overflow: hidden;
            box-shadow: var(--shadow);
            transition: var(--transition);
            position: relative;
        }
        
        .book-card:hover {
            transform: translateY(-10px);
            box-shadow: 0 15px 30px rgba(0, 0, 0, 0.2);
        }
        
        .book-badge {
            position: absolute;
            top: 15px;
            right: 15px;
            background: var(--accent);
            color: var(--white);
            padding: 0.3rem 0.8rem;
            border-radius: 20px;
            font-size: 0.8rem;
            font-weight: 600;
            z-index: 1;
            box-shadow: 0 3px 10px rgba(0,0,0,0.1);
        }
        
        .book-cover-container {
            height: 320px;
            overflow: hidden;
            position: relative;
        }
        
        .book-cover {
            width: 100%;
            height: 100%;
            object-fit: cover;
            transition: var(--transition);
        }
        
        .book-card:hover .book-cover {
            transform: scale(1.05);
        }
        
        .book-info {
            padding: 1.5rem;
        }
        .book-actions {
    display: flex;
    flex-wrap: wrap;
    gap: 0.5rem; /* jarak antar tombol */
    margin-top: 1rem;
}

.book-actions .btn {
    flex: 1 1 150px; /* minimal lebar tombol, sisanya fleksibel */
    min-width: 120px;
}
        
        .book-title {
            font-size: 1.2rem;
            font-weight: 600;
            margin-bottom: 0.5rem;
            color: var(--dark);
            display: -webkit-box;
            -webkit-line-clamp: 2;
            -webkit-box-orient: vertical;
            overflow: hidden;
        }
        
        .book-author {
            color: #7f8c8d;
            font-size: 0.9rem;
            margin-bottom: 0.5rem;
            display: flex;
            align-items: center;
        }
        
        .book-author i {
            margin-right: 0.5rem;
            color: var(--secondary);
        }
        
        .book-price {
            font-size: 1.3rem;
            font-weight: 700;
            color: var(--accent);
            margin: 1rem 0;
            display: flex;
            align-items: center;
        }
        
        .book-price::before {
            content: "Rp";
            font-size: 0.9rem;
            margin-right: 0.2rem;
        }
        
        .book-actions {
            display: flex;
            gap: 0.8rem;
        }
        :root {
    --warning: #f39c12;
    --danger: #e74c3c;
    --primary: #2980b9;
    --secondary: #3498db;
    --white: #ffffff;
    --transition: all 0.3s ease;
}

        
        .btn {
            padding: 0.6rem 1.2rem;
            border-radius: 8px;
            font-weight: 500;
            font-size: 0.9rem;
            cursor: pointer;
            transition: var(--transition);
            display: inline-flex;
            align-items: center;
            justify-content: center;
            border: none;
            text-decoration: none;
        }
        
        .btn-primary {
            background: var(--secondary);
            color: var(--white);
            flex: 1;
        }
        
        .btn-primary:hover {
            background: var(--primary);
            transform: translateY(-2px);
            box-shadow: 0 5px 15px rgba(52, 152, 219, 0.3);
        }
        
        .btn-secondary {
            background: var(--white);
            color: var(--secondary);
            border: 1px solid var(--secondary);
        }
        
        .btn-secondary:hover {
            background: rgba(52, 152, 219, 0.05);
        }
        /* WARNING BUTTON */
.btn-warning {
    background: var(--warning); /* Misalnya: kuning/oranye */
    color: var(--white);
    flex: 1;
}

.btn-warning:hover {
    background: darkorange;
    transform: translateY(-2px);
    box-shadow: 0 5px 15px rgba(255, 165, 0, 0.3);
}

/* DANGER BUTTON */
.btn-danger {
    background: var(--danger); /* Misalnya: merah */
    color: var(--white);
    flex: 1;
}

.btn-danger:hover {
    background: darkred;
    transform: translateY(-2px);
    box-shadow: 0 5px 15px rgba(231, 76, 60, 0.3);
}

        /* Empty State */
        .empty-state {
            grid-column: 1 / -1;
            text-align: center;
            padding: 3rem;
            background: var(--white);
            border-radius: 10px;
            box-shadow: var(--shadow);
        }
        
        .empty-state i {
            font-size: 3rem;
            color: var(--secondary);
            margin-bottom: 1rem;
        }
        
        .empty-state h3 {
            color: var(--dark);
            margin-bottom: 0.5rem;
        }
        
        .empty-state p {
            color: #7f8c8d;
            margin-bottom: 1.5rem;
        }
        
        /* Navigation */
        .nav-actions {
            display: flex;
            justify-content: center;
            gap: 1.5rem;
            margin: 3rem 0;
        }
        
        .nav-btn {
            padding: 0.8rem 2rem;
            border-radius: 8px;
            font-weight: 500;
            background: var(--white);
            color: var(--secondary);
            box-shadow: var(--shadow);
            transition: var(--transition);
            display: inline-flex;
            align-items: center;
            text-decoration: none;
            border: 1px solid var(--secondary);
        }
        
        .nav-btn:hover {
            transform: translateY(-3px);
            box-shadow: 0 10px 20px rgba(0, 0, 0, 0.15);
            background: var(--secondary);
            color: var(--white);
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
        
        /* Floating Button */
        .floating-btn {
            position: fixed;
            bottom: 2rem;
            right: 2rem;
            width: 60px;
            height: 60px;
            border-radius: 50%;
            background: var(--accent);
            color: var(--white);
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 1.5rem;
            box-shadow: 0 5px 20px rgba(231, 76, 60, 0.4);
            z-index: 100;
            transition: var(--transition);
            text-decoration: none;
        }
        
        .floating-btn:hover {
            transform: translateY(-5px) scale(1.1);
            background: #c0392b;
        }
        
        /* Responsive */
        @media (max-width: 768px) {
            .yayasan-title h1 {
                font-size: 1.5rem;
            }
            
            .hero h2 {
                font-size: 2rem;
            }
            
            .hero p {
                font-size: 1rem;
            }
            
            .nav-container {
                flex-direction: column;
                gap: 1rem;
            }
            
            .search-container {
                width: 100%;
            }
            
            .book-grid {
                grid-template-columns: repeat(auto-fill, minmax(240px, 1fr));
            }
            
            .nav-actions {
                flex-direction: column;
                align-items: center;
            }
            
            .filter-section {
                flex-direction: column;
                align-items: stretch;
            }
            
            .filter-group {
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
                 <?php if (!$this->session->userdata('role')) { ?>
                   <a href="<?= site_url('./') ?>" class="nav-link">
                    <i class="fas fa-home"></i> Kembali
                </a>
        <?php }else{ ?>
        
                <a href="<?= base_url('auth') ?>" class="nav-link">
                    <i class="fas fa-plus-circle"></i> Kembali Ke Admin
                </a>
                <?php }; ?>
             
                <a href="<?= site_url('katalog/cart') ?>" class="nav-link">
                    <i class="fas fa-shopping-cart"></i> Keranjang
                </a>
                 <?php if (!$this->session->userdata('role')) { ?>
        <?php }else{ ?>
        
                <a href="<?= site_url('katalog/tambah_buku') ?>" class="nav-link">
                    <i class="fas fa-plus-circle"></i> Tambah Buku
                </a>
                <?php }; ?>
                
            </div>
            <div class="search-container">
                <i class="fas fa-search search-icon"></i>
                <input type="text" class="search-input" placeholder="Cari judul, penulis, atau kategori..." id="searchInput">
            </div>
        </div>
    </nav>
    
    <!-- Hero Section -->
    <section class="hero">
        <div class="hero-content container">
            <h2>Koleksi Buku Yayasan CBIM</h2>
            <p>Temukan buku-buku berkualitas untuk menunjang pendidikan dan pengembangan diri</p>
            <a href="#katalog" class="btn btn-primary" style="padding: 0.8rem 2rem;">
                <i class="fas fa-book-open"></i> Lihat Katalog
            </a>
        </div>
    </section>
    
    <!-- Katalog Buku -->
    <div class="container" id="katalog">
        <!-- Filter Section -->
        <div class="filter-section">
            <div class="filter-group">
                <label for="categoryFilter" class="filter-label">Kategori</label>
                <select id="categoryFilter" class="filter-select">
                    <option value="">Semua Kategori</option>
                    <option value="pendidikan">Pendidikan</option>
                    <option value="novel">Novel</option>
                    <option value="bisnis">Bisnis</option>
                    <option value="anak">Buku Anak</option>
                </select>
            </div>
            <div class="filter-group">
                <label for="priceFilter" class="filter-label">Harga</label>
                <select id="priceFilter" class="filter-select">
                    <option value="">Semua Harga</option>
                    <option value="0-50000">Rp0 - Rp50.000</option>
                    <option value="50000-100000">Rp50.000 - Rp100.000</option>
                    <option value="100000-200000">Rp100.000 - Rp200.000</option>
                    <option value="200000">> Rp200.000</option>
                </select>
            </div>
            <div class="filter-group">
                <label for="sortBy" class="filter-label">Urutkan</label>
                <select id="sortBy" class="filter-select">
                    <option value="newest">Terbaru</option>
                    <option value="price-low">Harga Terendah</option>
                    <option value="price-high">Harga Tertinggi</option>
                    <option value="title">Judul (A-Z)</option>
                </select>
            </div>
        </div>
        
        <!-- Book Grid -->
        <div class="book-grid" id="bookGrid">
            <?php if (!empty($buku)): ?>
                <?php foreach ($buku as $b): ?>
                <div class="book-card" data-title="<?= strtolower($b->judul) ?>" data-author="<?= strtolower($b->penulis) ?>" data-category="<?= $b->kategori ?? 'pendidikan' ?>" data-price="<?= $b->harga ?>">
                    <div class="book-cover-container">
                        <img src="<?= base_url('uploads/' . $b->cover) ?>" alt="<?= $b->judul ?>" class="book-cover">
                        <?php if(isset($b->is_new) && $b->is_new): ?>
                        <span class="book-badge">BARU</span>
                        <?php endif; ?>
                    </div>
                    <div class="book-info">
                        <h3 class="book-title"><?= $b->judul ?></h3>
                        <p class="book-author"><i class="fas fa-user-edit"></i> <?= $b->penulis ?></p>
                        <div class="book-price"><?= number_format($b->harga,0,',','.') ?></div>
                        <div class="book-actions">
                            <a href="<?= site_url('katalog/add_to_cart/' . $b->id) ?>" class="btn btn-primary">
                                <i class="fas fa-cart-plus"></i> Beli
                            </a>
                            <a href="<?= site_url('katalog/detail_buku/' . $b->id) ?>" class="btn btn-secondary">
                                <i class="fas fa-info-circle"></i> Detail
                            </a>
                                    <?php if (!$this->session->userdata('role')) { ?>
        <?php }else{ ?>
                                <a href="<?= site_url('katalog/edit_buku/' . $b->id) ?>" class="btn btn-warning">
                                <i class="fas fa-pencil"></i> Edit
                            </a>
            
<a href="<?= site_url('katalog/hapus_buku/' . $b->id) ?>"  class="btn btn-danger" onclick="return confirm('Yakin hapus buku ini?')">🗑️ Hapus</a>
<?php }?>
                        </div>
                    </div>
                </div>
                <?php endforeach; ?>
            <?php else: ?>
                <div class="empty-state">
                    <i class="fas fa-book-open"></i>
                    <h3>Buku Belum Tersedia</h3>
                    <p>Maaf, saat ini belum ada buku yang tersedia dalam katalog.</p>
                     <?php if (!$this->session->userdata('role')) { ?>
        <?php }else{ ?>
                    <a href="<?= site_url('katalog/tambah_buku') ?>" class="btn btn-primary" style="padding: 0.8rem 2rem;">
                        <i class="fas fa-plus-circle"></i> Tambah Buku Pertama
                    </a>
                    <?php }?>
                </div>
            <?php endif; ?>
        </div>
        
        <?php if (!empty($buku)): ?>
        <div class="nav-actions">
            <a href="<?= site_url('katalog/cart') ?>" class="nav-btn">
                <i class="fas fa-shopping-cart"></i> Lihat Keranjang
            </a>
       
        </div>
        <?php endif; ?>
    </div>
    
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
    
    <?php if (!empty($buku)): ?>
    <a href="<?= site_url('katalog/cart') ?>" class="floating-btn">
        <i class="fas fa-shopping-cart"></i>
    </a>
    <?php endif; ?>
    
    <script>
        // Fungsi Pencarian
        document.getElementById('searchInput').addEventListener('input', function() {
            const searchTerm = this.value.toLowerCase();
            const bookCards = document.querySelectorAll('.book-card');
            
            bookCards.forEach(card => {
                const title = card.getAttribute('data-title');
                const author = card.getAttribute('data-author');
                
                if (title.includes(searchTerm) || author.includes(searchTerm)) {
                    card.style.display = 'block';
                } else {
                    card.style.display = 'none';
                }
            });
        });
        
        // Fungsi Filter Kategori
        document.getElementById('categoryFilter').addEventListener('change', function() {
            const selectedCategory = this.value;
            const bookCards = document.querySelectorAll('.book-card');
            
            bookCards.forEach(card => {
                const category = card.getAttribute('data-category');
                
                if (!selectedCategory || category === selectedCategory) {
                    card.style.display = 'block';
                } else {
                    card.style.display = 'none';
                }
            });
        });
        
        // Fungsi Filter Harga
        document.getElementById('priceFilter').addEventListener('change', function() {
            const selectedPrice = this.value;
            const bookCards = document.querySelectorAll('.book-card');
            
            bookCards.forEach(card => {
                const price = parseFloat(card.getAttribute('data-price'));
                
                let shouldShow = true;
                
                if (selectedPrice === '0-50000') {
                    shouldShow = price >= 0 && price <= 50000;
                } else if (selectedPrice === '50000-100000') {
                    shouldShow = price > 50000 && price <= 100000;
                } else if (selectedPrice === '100000-200000') {
                    shouldShow = price > 100000 && price <= 200000;
                } else if (selectedPrice === '200000') {
                    shouldShow = price > 200000;
                }
                
                card.style.display = shouldShow ? 'block' : 'none';
            });
        });
        
        // Fungsi Sortir
        document.getElementById('sortBy').addEventListener('change', function() {
            const sortBy = this.value;
            const bookGrid = document.getElementById('bookGrid');
            const bookCards = Array.from(document.querySelectorAll('.book-card'));
            
            bookCards.sort((a, b) => {
                if (sortBy === 'newest') {
                    return 0;
                } else if (sortBy === 'price-low') {
                    const priceA = parseFloat(a.getAttribute('data-price'));
                    const priceB = parseFloat(b.getAttribute('data-price'));
                    return priceA - priceB;
                } else if (sortBy === 'price-high') {
                    const priceA = parseFloat(a.getAttribute('data-price'));
                    const priceB = parseFloat(b.getAttribute('data-price'));
                    return priceB - priceA;
                } else if (sortBy === 'title') {
                    const titleA = a.getAttribute('data-title');
                    const titleB = b.getAttribute('data-title');
                    return titleA.localeCompare(titleB);
                }
                return 0;
            });
            
            // Hapus semua buku dari grid
            while (bookGrid.firstChild) {
                bookGrid.removeChild(bookGrid.firstChild);
            }
            
            // Tambahkan kembali buku yang sudah diurutkan
            bookCards.forEach(card => {
                bookGrid.appendChild(card);
            });
        });
        
        // Animasi scroll untuk floating button
        window.addEventListener('scroll', function() {
            const floatingBtn = document.querySelector('.floating-btn');
            if (window.scrollY > 300) {
                floatingBtn.style.transform = 'translateY(0)';
                floatingBtn.style.opacity = '1';
            } else {
                floatingBtn.style.transform = 'translateY(100px)';
                floatingBtn.style.opacity = '0';
            }
        });
        
        // Inisialisasi animasi saat halaman dimuat
        document.addEventListener('DOMContentLoaded', function() {
            const cards = document.querySelectorAll('.book-card');
            cards.forEach((card, index) => {
                card.style.opacity = '0';
                card.style.transform = 'translateY(20px)';
                card.style.transitionDelay = `${index * 0.1}s`;
                
                setTimeout(() => {
                    card.style.opacity = '1';
                    card.style.transform = 'translateY(0)';
                }, 100);
            });
        });
    </script>
</body>
</html>