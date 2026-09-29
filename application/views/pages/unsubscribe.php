<div class="container py-20 text-center">
    <div class="card shadow-sm border p-8 p-lg-12 bg-white rounded-3 max-w-600px mx-auto">
        <?php if (!empty($success)) : ?>
            <div class="symbol symbol-70px symbol-circle bg-light-warning mb-6 mx-auto">
                <i class="bi bi-envelope-slash-fill text-warning fs-2x p-4"></i>
            </div>
            <h2 class="fw-bolder text-dark mb-3">Berhenti Berlangganan</h2>
            <p class="text-muted fs-5 mb-8">
                Email Anda telah berhasil dihapus dari daftar penerima warta Yayasan CBIM. Anda tidak akan lagi menerima email rutin dari kami.
            </p>
        <?php else : ?>
            <div class="symbol symbol-70px symbol-circle bg-light-danger mb-6 mx-auto">
                <i class="bi bi-exclamation-octagon-fill text-danger fs-2x p-4"></i>
            </div>
            <h2 class="fw-bolder text-dark mb-3">Tautan Tidak Valid</h2>
            <p class="text-muted fs-5 mb-8">
                Tautan berhenti berlangganan tidak ditemukan atau sudah kedaluwarsa.
            </p>
        <?php endif; ?>

        <a href="<?= base_url(); ?>" class="btn btn-cbim-primary px-8 py-3">
            <i class="bi bi-house me-2"></i> Kembali ke Beranda
        </a>
    </div>
</div>
