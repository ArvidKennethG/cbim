<div class="container py-12 py-lg-18">
    <!-- Header -->
    <div class="text-center mb-10">
        <span class="badge badge-light-primary fw-bolder px-4 py-2 mb-3">PENDAFTARAN PESERTA DIDIK BARU (PPDB)</span>
        <h1 class="fs-2hx fw-bolder text-dark mb-3">Portal Pendaftaran Online Yayasan CBIM</h1>
        <p class="fs-5 text-muted max-w-700px mx-auto">
            Daftarkan putra-putri Anda untuk jenjang PAUD/TK, SD, SMP, SMA Kristen Citra Bangsa, atau Universitas Citra Bangsa (UCB).
        </p>
    </div>

    <!-- Alert Messages -->
    <?php if ($this->session->flashdata('error')) : ?>
        <div class="alert alert-danger d-flex align-items-center p-5 mb-8 max-w-800px mx-auto">
            <i class="bi bi-exclamation-triangle fs-2x text-danger me-4"></i>
            <div class="d-flex flex-column">
                <h5 class="mb-1 text-dark">Mohon Lengkapi Formulir:</h5>
                <ul class="mb-0 ps-3"><?= $this->session->flashdata('error'); ?></ul>
            </div>
        </div>
    <?php endif; ?>

    <div class="row justify-content-center">
        <div class="col-lg-10">
            <!-- Stepper Indicator -->
            <div class="cbim-stepper mb-10">
                <div class="cbim-step active" id="stepIndicator1">
                    <div class="cbim-step-circle">1</div>
                    <div class="cbim-step-label">Jenjang & Biodata</div>
                </div>
                <div class="cbim-step" id="stepIndicator2">
                    <div class="cbim-step-circle">2</div>
                    <div class="cbim-step-label">Orang Tua / Wali</div>
                </div>
                <div class="cbim-step" id="stepIndicator3">
                    <div class="cbim-step-circle">3</div>
                    <div class="cbim-step-label">Asal Sekolah</div>
                </div>
                <div class="cbim-step" id="stepIndicator4">
                    <div class="cbim-step-circle">4</div>
                    <div class="cbim-step-label">Konfirmasi</div>
                </div>
            </div>

            <!-- Form Card -->
            <div class="card shadow-sm border p-8 p-lg-12 bg-white rounded-3">
                <form action="<?= base_url('pendaftaran/submit'); ?>" method="POST" id="ppdbForm">
                    <!-- ============================================== -->
                    <!-- STEP 1: Jenjang & Data Calon Siswa             -->
                    <!-- ============================================== -->
                    <div class="cbim-step-panel active" id="stepPanel1">
                        <h3 class="fw-bolder text-cbim-primary mb-6 d-flex align-items-center">
                            <span class="badge badge-circle badge-primary me-3">1</span> Pilihan Jenjang & Data Pribadi Calon Siswa
                        </h3>

                        <div class="mb-6">
                            <label class="form-label fw-bold required text-dark">Pilih Jenjang Pendidikan</label>
                            <div class="row g-3">
                                <div class="col-6 col-md">
                                    <input type="radio" class="btn-check" name="jenjang" id="jenjangTK" value="TK" checked>
                                    <label class="btn btn-outline btn-outline-dashed btn-outline-primary p-4 d-flex flex-column align-items-center w-100" for="jenjangTK">
                                        <i class="bi bi-stars fs-2x mb-1"></i>
                                        <span class="fw-bolder">PAUD / TK</span>
                                    </label>
                                </div>
                                <div class="col-6 col-md">
                                    <input type="radio" class="btn-check" name="jenjang" id="jenjangSD" value="SD">
                                    <label class="btn btn-outline btn-outline-dashed btn-outline-primary p-4 d-flex flex-column align-items-center w-100" for="jenjangSD">
                                        <i class="bi bi-book fs-2x mb-1"></i>
                                        <span class="fw-bolder">SD K</span>
                                    </label>
                                </div>
                                <div class="col-6 col-md">
                                    <input type="radio" class="btn-check" name="jenjang" id="jenjangSMP" value="SMP">
                                    <label class="btn btn-outline btn-outline-dashed btn-outline-primary p-4 d-flex flex-column align-items-center w-100" for="jenjangSMP">
                                        <i class="bi bi-mortarboard fs-2x mb-1"></i>
                                        <span class="fw-bolder">SMP K</span>
                                    </label>
                                </div>
                                <div class="col-6 col-md">
                                    <input type="radio" class="btn-check" name="jenjang" id="jenjangSMA" value="SMA">
                                    <label class="btn btn-outline btn-outline-dashed btn-outline-primary p-4 d-flex flex-column align-items-center w-100" for="jenjangSMA">
                                        <i class="bi bi-building fs-2x mb-1"></i>
                                        <span class="fw-bolder">SMA K</span>
                                    </label>
                                </div>
                                <div class="col-6 col-md">
                                    <input type="radio" class="btn-check" name="jenjang" id="jenjangUCB" value="UCB">
                                    <label class="btn btn-outline btn-outline-dashed btn-outline-primary p-4 d-flex flex-column align-items-center w-100" for="jenjangUCB">
                                        <i class="bi bi-award fs-2x mb-1"></i>
                                        <span class="fw-bolder">UCB (Univ)</span>
                                    </label>
                                </div>
                            </div>
                        </div>

                        <div class="row g-4 mb-5">
                            <div class="col-md-8">
                                <label class="form-label fw-bold text-dark required">Nama Lengkap Calon Siswa / Mahasiswa</label>
                                <input type="text" name="nama_lengkap" id="inputNama" class="form-control form-control-solid" placeholder="Nama sesuai Akta / Ijazah..." required />
                            </div>
                            <div class="col-md-4">
                                <label class="form-label fw-bold text-dark">NIK / NISN (Opsional)</label>
                                <input type="text" name="nik_nisn" id="inputNik" class="form-control form-control-solid" placeholder="Nomor Induk..." />
                            </div>
                        </div>

                        <div class="row g-4 mb-5">
                            <div class="col-md-4">
                                <label class="form-label fw-bold text-dark required">Jenis Kelamin</label>
                                <select name="jenis_kelamin" id="inputJk" class="form-select form-select-solid" required>
                                    <option value="Laki-laki">Laki-laki</option>
                                    <option value="Perempuan">Perempuan</option>
                                </select>
                            </div>
                            <div class="col-md-4">
                                <label class="form-label fw-bold text-dark">Tempat Lahir</label>
                                <input type="text" name="tempat_lahir" id="inputTempatLahir" class="form-control form-control-solid" placeholder="Kota / Kabupaten Lahir" />
                            </div>
                            <div class="col-md-4">
                                <label class="form-label fw-bold text-dark">Tanggal Lahir</label>
                                <input type="date" name="tgl_lahir" id="inputTglLahir" class="form-control form-control-solid" />
                            </div>
                        </div>

                        <div class="mb-5">
                            <label class="form-label fw-bold text-dark">Agama</label>
                            <select name="agama" id="inputAgama" class="form-select form-select-solid">
                                <option value="Kristen Protestan">Kristen Protestan</option>
                                <option value="Katolik">Katolik</option>
                                <option value="Islam">Islam</option>
                                <option value="Hindu">Hindu</option>
                                <option value="Buddha">Buddha</option>
                                <option value="Lainnya">Lainnya</option>
                            </select>
                        </div>

                        <div class="d-flex justify-content-end mt-8">
                            <button type="button" class="btn btn-cbim-primary px-8 py-3" onclick="nextStep(1)">
                                Selanjutnya: Data Orang Tua <i class="bi bi-arrow-right ms-2"></i>
                            </button>
                        </div>
                    </div>

                    <!-- ============================================== -->
                    <!-- STEP 2: Data Orang Tua / Wali                 -->
                    <!-- ============================================== -->
                    <div class="cbim-step-panel" id="stepPanel2">
                        <h3 class="fw-bolder text-cbim-primary mb-6 d-flex align-items-center">
                            <span class="badge badge-circle badge-primary me-3">2</span> Data Orang Tua / Wali & Kontak
                        </h3>

                        <div class="row g-4 mb-5">
                            <div class="col-md-6">
                                <label class="form-label fw-bold text-dark required">Nama Orang Tua / Wali</label>
                                <input type="text" name="nama_ortu" id="inputOrtu" class="form-control form-control-solid" placeholder="Nama Ayah, Ibu, atau Wali..." required />
                            </div>
                            <div class="col-md-6">
                                <label class="form-label fw-bold text-dark">Pekerjaan Orang Tua / Wali</label>
                                <input type="text" name="pekerjaan_ortu" id="inputPekerjaan" class="form-control form-control-solid" placeholder="PNS, Wiraswasta, Swasta, dll." />
                            </div>
                        </div>

                        <div class="row g-4 mb-5">
                            <div class="col-md-6">
                                <label class="form-label fw-bold text-dark required">Nomor HP / WhatsApp Aktif</label>
                                <input type="text" name="no_hp" id="inputNoHp" class="form-control form-control-solid" placeholder="Contoh: 08123456789" required />
                                <small class="text-muted">Untuk konfirmasi dan notifikasi status pendaftaran.</small>
                            </div>
                            <div class="col-md-6">
                                <label class="form-label fw-bold text-dark">Alamat Email (Opsional)</label>
                                <input type="email" name="email" id="inputEmail" class="form-control form-control-solid" placeholder="email@contoh.com" />
                            </div>
                        </div>

                        <div class="mb-5">
                            <label class="form-label fw-bold text-dark required">Alamat Lengkap Domisili</label>
                            <textarea name="alamat" id="inputAlamat" rows="3" class="form-control form-control-solid" placeholder="Jalan, RT/RW, Kelurahan, Kecamatan, Kota/Kabupaten..." required></textarea>
                        </div>

                        <div class="d-flex justify-content-between mt-8">
                            <button type="button" class="btn btn-light px-6 py-3" onclick="prevStep(2)">
                                <i class="bi bi-arrow-left me-2"></i> Kembali
                            </button>
                            <button type="button" class="btn btn-cbim-primary px-8 py-3" onclick="nextStep(2)">
                                Selanjutnya: Asal Sekolah <i class="bi bi-arrow-right ms-2"></i>
                            </button>
                        </div>
                    </div>

                    <!-- ============================================== -->
                    <!-- STEP 3: Asal Sekolah & Catatan                 -->
                    <!-- ============================================== -->
                    <div class="cbim-step-panel" id="stepPanel3">
                        <h3 class="fw-bolder text-cbim-primary mb-6 d-flex align-items-center">
                            <span class="badge badge-circle badge-primary me-3">3</span> Informasi Asal Sekolah & Keterangan
                        </h3>

                        <div class="mb-5">
                            <label class="form-label fw-bold text-dark">Asal Sekolah Sebelumnya</label>
                            <input type="text" name="asal_sekolah" id="inputAsalSekolah" class="form-control form-control-solid" placeholder="Contoh: TK Dharma Wanita Kupang / SMP Negeri 1 Kupang..." />
                            <small class="text-muted">Kosongkan jika baru pertama kali mendaftar PAUD/TK.</small>
                        </div>

                        <div class="mb-5">
                            <label class="form-label fw-bold text-dark">Catatan Khusus / Pilihan Peminatan / Jurusan</label>
                            <textarea name="catatan" id="inputCatatan" rows="3" class="form-control form-control-solid" placeholder="Contoh: Pilihan jurusan UCB / Kelompok TK A / Catatan kesehatan calon siswa..."></textarea>
                        </div>

                        <div class="d-flex justify-content-between mt-8">
                            <button type="button" class="btn btn-light px-6 py-3" onclick="prevStep(3)">
                                <i class="bi bi-arrow-left me-2"></i> Kembali
                            </button>
                            <button type="button" class="btn btn-cbim-primary px-8 py-3" onclick="nextStep(3)">
                                Selanjutnya: Review & Konfirmasi <i class="bi bi-arrow-right ms-2"></i>
                            </button>
                        </div>
                    </div>

                    <!-- ============================================== -->
                    <!-- STEP 4: Konfirmasi Ringkasan Data             -->
                    <!-- ============================================== -->
                    <div class="cbim-step-panel" id="stepPanel4">
                        <h3 class="fw-bolder text-cbim-primary mb-6 d-flex align-items-center">
                            <span class="badge badge-circle badge-primary me-3">4</span> Konfirmasi & Pengiriman Data
                        </h3>

                        <div class="alert alert-warning d-flex align-items-center p-4 mb-6">
                            <i class="bi bi-check2-circle fs-2x text-warning me-3"></i>
                            <div>
                                Pastikan seluruh informasi di bawah ini sudah benar sebelum mengirimkan formulir pendaftaran.
                            </div>
                        </div>

                        <!-- Summary Table -->
                        <div class="table-responsive mb-6">
                            <table class="table table-bordered align-middle">
                                <tbody>
                                    <tr>
                                        <th class="bg-light fw-bold w-30">Jenjang Dituju</th>
                                        <td id="revJenjang" class="fw-bolder text-primary"></td>
                                    </tr>
                                    <tr>
                                        <th class="bg-light fw-bold">Nama Calon Siswa</th>
                                        <td id="revNama" class="fw-bold"></td>
                                    </tr>
                                    <tr>
                                        <th class="bg-light fw-bold">Jenis Kelamin</th>
                                        <td id="revJk"></td>
                                    </tr>
                                    <tr>
                                        <th class="bg-light fw-bold">Nama Orang Tua</th>
                                        <td id="revOrtu"></td>
                                    </tr>
                                    <tr>
                                        <th class="bg-light fw-bold">Nomor HP / WhatsApp</th>
                                        <td id="revNoHp" class="fw-bold text-success"></td>
                                    </tr>
                                    <tr>
                                        <th class="bg-light fw-bold">Alamat</th>
                                        <td id="revAlamat"></td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>

                        <div class="form-check mb-8">
                            <input class="form-check-input" type="checkbox" id="checkAgree" required />
                            <label class="form-check-label text-dark fs-6" for="checkAgree">
                                Saya menyatakan bahwa seluruh data yang diisikan adalah benar dan dapat dipertanggungjawabkan sesuai ketentuan Yayasan CBIM.
                            </label>
                        </div>

                        <div class="d-flex justify-content-between mt-8">
                            <button type="button" class="btn btn-light px-6 py-3" onclick="prevStep(4)">
                                <i class="bi bi-arrow-left me-2"></i> Perbaiki Data
                            </button>
                            <button type="submit" class="btn btn-success fw-bolder px-8 py-3" id="btnSubmitPPDB">
                                <i class="bi bi-check-lg me-2"></i> Kirim Pendaftaran Sekarang
                            </button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

<script>
function nextStep(current) {
    if (current === 1) {
        var nama = document.getElementById('inputNama').value.trim();
        if (!nama) {
            alert('Silakan masukkan nama lengkap calon siswa terlebih dahulu.');
            document.getElementById('inputNama').focus();
            return;
        }
    } else if (current === 2) {
        var ortu = document.getElementById('inputOrtu').value.trim();
        var hp = document.getElementById('inputNoHp').value.trim();
        var alamat = document.getElementById('inputAlamat').value.trim();
        if (!ortu || !hp || !alamat) {
            alert('Silakan lengkapi nama orang tua, nomor HP/WhatsApp, dan alamat domisili.');
            return;
        }
    } else if (current === 3) {
        // Populate step 4 review
        var jenjang = document.querySelector('input[name="jenjang"]:checked').value;
        document.getElementById('revJenjang').textContent = jenjang;
        document.getElementById('revNama').textContent = document.getElementById('inputNama').value;
        document.getElementById('revJk').textContent = document.getElementById('inputJk').value;
        document.getElementById('revOrtu').textContent = document.getElementById('inputOrtu').value;
        document.getElementById('revNoHp').textContent = document.getElementById('inputNoHp').value;
        document.getElementById('revAlamat').textContent = document.getElementById('inputAlamat').value;
    }

    document.getElementById('stepPanel' + current).classList.remove('active');
    document.getElementById('stepIndicator' + current).classList.remove('active');
    document.getElementById('stepIndicator' + current).classList.add('completed');

    var next = current + 1;
    document.getElementById('stepPanel' + next).classList.add('active');
    document.getElementById('stepIndicator' + next).classList.add('active');
    window.scrollTo({ top: 150, behavior: 'smooth' });
}

function prevStep(current) {
    document.getElementById('stepPanel' + current).classList.remove('active');
    document.getElementById('stepIndicator' + current).classList.remove('active');

    var prev = current - 1;
    document.getElementById('stepPanel' + prev).classList.add('active');
    document.getElementById('stepIndicator' + prev).classList.add('active');
    document.getElementById('stepIndicator' + prev).classList.remove('completed');
    window.scrollTo({ top: 150, behavior: 'smooth' });
}
</script>
