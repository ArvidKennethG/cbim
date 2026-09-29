<div class="container py-12 py-lg-18">
    <!-- Search Form Header -->
    <div class="mb-10 text-center">
        <span class="badge badge-light-primary fw-bolder px-4 py-2 mb-3">PENCARIAN SITEWIDE</span>
        <h1 class="fs-2hx fw-bolder text-dark mb-4">Hasil Pencarian</h1>
        
        <form action="<?= base_url('search'); ?>" method="GET" class="max-w-700px mx-auto">
            <div class="input-group shadow-sm">
                <input type="text" name="q" value="<?= htmlspecialchars($query); ?>" class="form-control form-control-solid py-4 px-6 fs-5" placeholder="Ketik kata kunci pencarian..." required autofocus />
                <button type="submit" class="btn btn-cbim-primary px-8 fw-bold">
                    <i class="bi bi-search me-2"></i> Cari
                </button>
            </div>
            
            <!-- Category Filter Pills -->
            <div class="d-flex flex-wrap justify-content-center gap-2 mt-4">
                <a href="<?= base_url('search?q=' . urlencode($query) . '&category=semua'); ?>" class="btn btn-sm <?= ($category === 'semua') ? 'btn-cbim-primary' : 'btn-light'; ?>">
                    Semua (<?= $total; ?>)
                </a>
                <a href="<?= base_url('search?q=' . urlencode($query) . '&category=berita'); ?>" class="btn btn-sm <?= ($category === 'berita') ? 'btn-cbim-primary' : 'btn-light'; ?>">
                    Berita
                </a>
                <a href="<?= base_url('search?q=' . urlencode($query) . '&category=kegiatan'); ?>" class="btn btn-sm <?= ($category === 'kegiatan') ? 'btn-cbim-primary' : 'btn-light'; ?>">
                    Kegiatan
                </a>
                <a href="<?= base_url('search?q=' . urlencode($query) . '&category=galeri'); ?>" class="btn btn-sm <?= ($category === 'galeri') ? 'btn-cbim-primary' : 'btn-light'; ?>">
                    Galeri
                </a>
                <a href="<?= base_url('search?q=' . urlencode($query) . '&category=unit'); ?>" class="btn btn-sm <?= ($category === 'unit') ? 'btn-cbim-primary' : 'btn-light'; ?>">
                    Unit Pendidikan & Halaman
                </a>
            </div>
        </form>
    </div>

    <!-- Results List -->
    <div class="row justify-content-center">
        <div class="col-lg-9">
            <?php if (!empty($query)) : ?>
                <div class="d-flex justify-content-between align-items-center mb-6 pb-3 border-bottom">
                    <div class="fs-6 text-muted">
                        Menampilkan <strong><?= count($results); ?></strong> hasil untuk kata kunci <strong class="text-dark">"<?= htmlspecialchars($query); ?>"</strong>
                    </div>
                </div>

                <?php if (!empty($results)) : ?>
                    <div class="d-flex flex-column gap-4">
                        <?php foreach ($results as $item) : ?>
                            <div class="card shadow-sm border p-6 bg-white rounded-3 hover-elevate-up">
                                <div class="d-flex align-items-center gap-2 mb-2">
                                    <span class="badge bg-light-primary text-cbim-primary fw-bolder fs-8 text-uppercase">
                                        <?= htmlspecialchars($item['type']); ?>
                                    </span>
                                    <?php if ($item['date'] !== '-') : ?>
                                        <span class="text-muted fs-8">• <?= htmlspecialchars($item['date']); ?></span>
                                    <?php endif; ?>
                                </div>
                                <h3 class="fs-4 fw-bolder mb-2">
                                    <a href="<?= $item['url']; ?>" class="text-dark text-hover-primary">
                                        <?= htmlspecialchars($item['title']); ?>
                                    </a>
                                </h3>
                                <p class="text-muted fs-6 mb-3">
                                    <?= htmlspecialchars($item['snippet']); ?>
                                </p>
                                <div>
                                    <a href="<?= $item['url']; ?>" class="text-cbim-primary fw-bold fs-7 d-inline-flex align-items-center">
                                        Buka Selengkapnya <i class="bi bi-arrow-right ms-1"></i>
                                    </a>
                                </div>
                            </div>
                        <?php endforeach; ?>
                    </div>
                <?php else : ?>
                    <div class="card shadow-sm border p-12 text-center bg-white rounded-3">
                        <i class="bi bi-search fs-3x text-muted mb-4"></i>
                        <h4 class="fw-bolder text-dark mb-2">Tidak Ada Hasil Ditemukan</h4>
                        <p class="text-muted fs-6 mb-0">
                            Maaf, kami tidak menemukan data yang cocok dengan kata kunci "<?= htmlspecialchars($query); ?>". Silakan coba kata kunci lain seperti "UCB", "pendaftaran", atau "beasiswa".
                        </p>
                    </div>
                <?php endif; ?>

            <?php else : ?>
                <div class="card shadow-sm border p-12 text-center bg-white rounded-3">
                    <i class="bi bi-keyboard fs-3x text-muted mb-4"></i>
                    <h4 class="fw-bolder text-dark mb-2">Mulai Mencari</h4>
                    <p class="text-muted fs-6 mb-0">
                        Ketik kata kunci pada kotak pencarian di atas untuk menemukan berita, galeri, kegiatan, atau info unit pendidikan.
                    </p>
                </div>
            <?php endif; ?>
        </div>
    </div>
</div>
