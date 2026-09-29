<div class="container py-12 py-lg-20 text-center">
    <div class="card shadow-sm border p-8 p-lg-12 bg-white rounded-3 max-w-700px mx-auto">
        <div class="symbol symbol-80px symbol-circle bg-light-success mb-6 mx-auto">
            <i class="bi bi-check-circle-fill text-success fs-3x p-4"></i>
        </div>

        <span class="badge badge-light-success fw-bolder px-4 py-2 mb-3">PENDAFTARAN BERHASIL</span>
        <h1 class="fs-2hx fw-bolder text-dark mb-4">Selamat! Data Anda Telah Diterima</h1>
        
        <p class="fs-5 text-muted mb-8">
            Formulir pendaftaran calon siswa/mahasiswa atas nama <strong><?= htmlspecialchars($pendaftaran['nama_lengkap']); ?></strong> telah berhasil tersimpan di sistem Yayasan CBIM.
        </p>

        <!-- Registration Voucher Card -->
        <div class="p-6 bg-light rounded-3 border border-dashed border-primary mb-8 text-start">
            <div class="row g-4 align-items-center">
                <div class="col-sm-8">
                    <div class="fs-7 text-muted text-uppercase fw-bold">Nomor Registrasi PPDB:</div>
                    <div class="fs-2 fw-bolder text-cbim-primary letter-spacing-1"><?= htmlspecialchars($pendaftaran['no_registrasi']); ?></div>
                    <div class="fs-6 text-dark mt-1">
                        Jenjang Dituju: <span class="badge bg-primary"><?= htmlspecialchars($pendaftaran['jenjang']); ?></span>
                    </div>
                </div>
                <div class="col-sm-4 text-sm-end">
                    <button type="button" class="btn btn-sm btn-outline-secondary" onclick="window.print()">
                        <i class="bi bi-printer me-1"></i> Cetak Bukti
                    </button>
                </div>
            </div>
        </div>

        <!-- Next Steps -->
        <div class="text-start mb-8">
            <h4 class="fw-bolder text-dark mb-3">Langkah Selanjutnya:</h4>
            <ol class="fs-6 text-muted lh-lg ps-4 mb-0">
                <li>Simpan atau catat <strong>Nomor Registrasi</strong> di atas sebagai bukti pendaftaran.</li>
                <li>Petugas administrasi unit <strong><?= htmlspecialchars($pendaftaran['jenjang']); ?></strong> akan menghubungi Anda melalui WhatsApp/Telepon ke nomor <strong><?= htmlspecialchars($pendaftaran['no_hp']); ?></strong> untuk jadwal verifikasi berkas dan wawancara.</li>
                <li>Anda juga dapat langsung melakukan konfirmasi cepat dengan mengklik tombol WhatsApp di bawah.</li>
            </ol>
        </div>

        <!-- WhatsApp Quick Confirm -->
        <div class="d-flex flex-column flex-sm-row justify-content-center gap-3">
            <a href="https://wa.me/6281234567890?text=Halo%20Admin%20PPDB%20Yayasan%20CBIM,%20saya%20telah%20mendaftar%20online%20dengan%20No%20Registrasi%20<?= urlencode($pendaftaran['no_registrasi']); ?>%20atas%20nama%20<?= urlencode($pendaftaran['nama_lengkap']); ?>" target="_blank" rel="noopener" class="btn btn-success fw-bolder py-3 px-6">
                <i class="bi bi-whatsapp me-2"></i> Konfirmasi ke WhatsApp Admin
            </a>
            <a href="<?= base_url(); ?>" class="btn btn-light py-3 px-6">
                <i class="bi bi-house me-1"></i> Kembali ke Beranda
            </a>
        </div>
    </div>
</div>
