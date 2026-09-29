<main id="konten">

<!-- ============================ HERO ============================ -->
<section class="tk-hero" style="min-height: 50vh; padding-top: 100px;">
    <svg class="tk-awan tk-awan--1" viewBox="0 0 120 54" aria-hidden="true"><path d="M22 54c-12 0-22-8-22-19S10 16 22 16c3-9 12-16 22-16 12 0 22 8 25 19 12 1 21 9 21 19 0 9-9 16-21 16H22z"/></svg>
    <svg class="tk-awan tk-awan--2" viewBox="0 0 120 54" aria-hidden="true"><path d="M22 54c-12 0-22-8-22-19S10 16 22 16c3-9 12-16 22-16 12 0 22 8 25 19 12 1 21 9 21 19 0 9-9 16-21 16H22z"/></svg>

    <!-- Floating Decorations -->
    <span class="tk-dekorasi tk-dekorasi--1" aria-hidden="true">📝</span>
    <span class="tk-dekorasi tk-dekorasi--2" aria-hidden="true">✏️</span>

    <div class="tk-wadah tk-hero__teks">
        <span class="tk-label tk-label--kuning" style="margin-bottom: 12px; display:inline-block">TA 2026/2027</span>
        <h1 style="font-size: clamp(2rem, 5vw, 3rem)">Pendaftaran Peserta Didik Baru (PPDB) Online</h1>
        <p class="tk-hero__sub">
            Bergabunglah bersama keluarga besar SD K Citra Bangsa Mandiri Kupang. Daftarkan putra-putri tercinta dengan mudah melalui formulir resmi di bawah ini.
        </p>
    </div>

    <!-- bukit -->
    <svg class="tk-bukit" viewBox="0 0 1200 210" preserveAspectRatio="none" aria-hidden="true">
        <path d="M0 118c150-34 260 14 400 8s210-46 360-38 190 46 290 40 150-22 150-22v104H0z" fill="#8FD3A3"/>
        <g fill="#57B979">
            <circle cx="150" cy="150" r="30"/><rect x="145" y="150" width="10" height="34"/>
            <circle cx="1010" cy="158" r="24"/><rect x="1006" y="158" width="8" height="28"/>
        </g>
        <path d="M0 158c170-24 300 18 470 12s250-32 400-24 180 30 330 24v40H0z" fill="#57B979"/>
    </svg>
</section>

<!-- ============================ FORM PPDB ============================ -->
<section class="tk-bagian">
    <div class="tk-wadah">
        <div style="display:flex; flex-wrap:wrap; gap:40px">
            <!-- Kolom Kiri: Formulir -->
            <div style="flex:1; min-width:300px; background:#fff; border-radius:32px; padding:32px; border-top:6px solid var(--merah); box-shadow:0 12px 24px rgba(59,51,85,.12);">
                <div style="display:flex; gap:16px; align-items:center; margin-bottom:24px">
                    <div style="background:var(--merah); color:#fff; width:52px; height:52px; border-radius:12px; display:flex; align-items:center; justify-content:center">
                        <svg width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M11 4H4a2 2 0 0 0-2 2v14a2 2 0 0 0 2 2h14a2 2 0 0 0 2-2v-7"/><path d="M18.5 2.5a2.121 2.121 0 0 1 3 3L12 15l-4 1 1-4 9.5-9.5z"/></svg>
                    </div>
                    <div>
                        <h3 style="margin:0; font-size:1.5rem">Formulir Calon Siswa Baru</h3>
                        <p style="margin:0; font-size:0.9rem; color:var(--tinta-muda)">Isilah data ananda dan kontak orang tua dengan benar.</p>
                    </div>
                </div>

                <?php if ($this->session->flashdata('success')): ?>
                    <div style="background:#eafaf1; border:1px solid #57B979; padding:16px; border-radius:16px; margin-bottom:24px; color:#2d6b43">
                        <h4 style="margin:0 0 8px; font-size:1.1rem; display:flex; align-items:center; gap:8px">
                            <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M22 11.08V12a10 10 0 1 1-5.93-9.14"/><polyline points="22 4 12 14.01 9 11.01"/></svg>
                            Pendaftaran Berhasil!
                        </h4>
                        <p style="margin:0; font-size:0.9rem"><?= $this->session->flashdata('success'); ?></p>
                    </div>
                <?php endif; ?>

                <?php if ($this->session->flashdata('error')): ?>
                    <div style="background:#fcecec; border:1px solid #EE5D4E; padding:16px; border-radius:16px; margin-bottom:24px; color:#a12f25">
                        <h4 style="margin:0 0 8px; font-size:1.1rem; display:flex; align-items:center; gap:8px">
                            <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><circle cx="12" cy="12" r="10"/><line x1="12" y1="8" x2="12" y2="12"/><line x1="12" y1="16" x2="12.01" y2="16"/></svg>
                            Mohon Maaf!
                        </h4>
                        <p style="margin:0; font-size:0.9rem"><?= $this->session->flashdata('error'); ?></p>
                    </div>
                <?php endif; ?>

                <form action="<?= base_url('sd/submit_ppdb'); ?>" method="POST" style="display:flex; flex-direction:column; gap:20px">
                    <div>
                        <label style="display:block; font-weight:700; margin-bottom:8px">Nama Lengkap Calon Siswa <span style="color:var(--merah)">*</span></label>
                        <input type="text" name="nama_lengkap" style="width:100%; padding:12px; border:2px solid rgba(59,51,85,.1); border-radius:12px; font-family:inherit; font-size:1rem" placeholder="Contoh: Gracia Aurelia Manafe" required>
                    </div>

                    <div style="display:flex; gap:20px; flex-wrap:wrap">
                        <div style="flex:1; min-width:200px">
                            <label style="display:block; font-weight:700; margin-bottom:8px">NISN / NIK (Jika Ada)</label>
                            <input type="text" name="nisn" style="width:100%; padding:12px; border:2px solid rgba(59,51,85,.1); border-radius:12px; font-family:inherit; font-size:1rem" placeholder="Nomor NISN atau NIK">
                        </div>
                        <div style="flex:1; min-width:200px">
                            <label style="display:block; font-weight:700; margin-bottom:8px">Jenis Kelamin <span style="color:var(--merah)">*</span></label>
                            <select name="jenis_kelamin" style="width:100%; padding:12px; border:2px solid rgba(59,51,85,.1); border-radius:12px; font-family:inherit; font-size:1rem" required>
                                <option value="" disabled selected>-- Pilih Jenis Kelamin --</option>
                                <option value="Laki-laki">Laki-laki</option>
                                <option value="Perempuan">Perempuan</option>
                            </select>
                        </div>
                    </div>

                    <div style="display:flex; gap:20px; flex-wrap:wrap">
                        <div style="flex:1; min-width:200px">
                            <label style="display:block; font-weight:700; margin-bottom:8px">Tempat Lahir <span style="color:var(--merah)">*</span></label>
                            <input type="text" name="tempat_lahir" style="width:100%; padding:12px; border:2px solid rgba(59,51,85,.1); border-radius:12px; font-family:inherit; font-size:1rem" placeholder="Contoh: Kupang" required>
                        </div>
                        <div style="flex:1; min-width:200px">
                            <label style="display:block; font-weight:700; margin-bottom:8px">Tanggal Lahir <span style="color:var(--merah)">*</span></label>
                            <input type="date" name="tgl_lahir" style="width:100%; padding:12px; border:2px solid rgba(59,51,85,.1); border-radius:12px; font-family:inherit; font-size:1rem" required>
                        </div>
                    </div>

                    <div style="display:flex; gap:20px; flex-wrap:wrap">
                        <div style="flex:1; min-width:200px">
                            <label style="display:block; font-weight:700; margin-bottom:8px">Nama Orang Tua / Wali <span style="color:var(--merah)">*</span></label>
                            <input type="text" name="nama_ortu" style="width:100%; padding:12px; border:2px solid rgba(59,51,85,.1); border-radius:12px; font-family:inherit; font-size:1rem" placeholder="Contoh: Bapak Daniel Manafe" required>
                        </div>
                        <div style="flex:1; min-width:200px">
                            <label style="display:block; font-weight:700; margin-bottom:8px">No. WhatsApp Aktif <span style="color:var(--merah)">*</span></label>
                            <input type="tel" name="no_hp" style="width:100%; padding:12px; border:2px solid rgba(59,51,85,.1); border-radius:12px; font-family:inherit; font-size:1rem" placeholder="Contoh: 081234567890" required>
                        </div>
                    </div>

                    <div>
                        <label style="display:block; font-weight:700; margin-bottom:8px">Alamat Lengkap Tempat Tinggal <span style="color:var(--merah)">*</span></label>
                        <textarea name="alamat" style="width:100%; padding:12px; border:2px solid rgba(59,51,85,.1); border-radius:12px; font-family:inherit; font-size:1rem" rows="3" placeholder="Nama Jalan, RT/RW, Kelurahan, Kecamatan, Kota" required></textarea>
                    </div>

                    <div style="display:none" aria-hidden="true">
                        <label>Jangan isi kolom ini</label>
                        <input type="text" name="cbim_hp_check" tabindex="-1" autocomplete="off">
                    </div>

                    <div style="background:var(--kertas-tua); border:1px solid rgba(59,51,85,.1); padding:16px; border-radius:12px; display:flex; gap:12px; align-items:flex-start">
                        <input type="checkbox" name="persetujuan_ortu" id="persetujuanOrtu" value="1" required style="margin-top:6px; transform:scale(1.2)">
                        <label for="persetujuanOrtu" style="font-size:0.9rem; cursor:pointer">
                            Saya menyetujui data di atas diproses oleh SD K Citra Bangsa Mandiri untuk keperluan PPDB, sesuai
                            <a href="<?= base_url('kebijakan-privasi'); ?>" target="_blank" style="font-weight:bold">Kebijakan Privasi</a>.
                            <span style="color:var(--merah)">*</span>
                        </label>
                    </div>

                    <button type="submit" class="tk-tombol tk-tombol--utama" style="width:100%; justify-content:center; margin-top:10px; font-size:1.2rem">
                        Kirim Formulir Pendaftaran
                    </button>
                </form>
            </div>

            <!-- Kolom Kanan: Info -->
            <div style="flex:0 0 350px;">
                <!-- Alur -->
                <div style="background:#fff; border-radius:32px; padding:24px; border-top:6px solid var(--kuning); box-shadow:0 12px 24px rgba(59,51,85,.12); margin-bottom:24px">
                    <h4 style="margin-top:0; font-size:1.2rem; display:flex; align-items:center; gap:8px"><span style="color:var(--kuning)">📋</span> Alur Pendaftaran</h4>
                    <ul style="list-style:none; padding:0; margin:0; display:flex; flex-direction:column; gap:16px">
                        <li style="display:flex; gap:12px">
                            <div style="background:var(--merah); color:#fff; border-radius:50%; width:28px; height:28px; display:flex; align-items:center; justify-content:center; font-weight:bold; flex-shrink:0">1</div>
                            <div>
                                <strong style="display:block">Isi Formulir Online</strong>
                                <span style="font-size:0.85rem; color:var(--tinta-muda)">Lengkapi biodata calon murid.</span>
                            </div>
                        </li>
                        <li style="display:flex; gap:12px">
                            <div style="background:var(--merah); color:#fff; border-radius:50%; width:28px; height:28px; display:flex; align-items:center; justify-content:center; font-weight:bold; flex-shrink:0">2</div>
                            <div>
                                <strong style="display:block">Konfirmasi Panitia</strong>
                                <span style="font-size:0.85rem; color:var(--tinta-muda)">Panitia akan menghubungi Anda.</span>
                            </div>
                        </li>
                        <li style="display:flex; gap:12px">
                            <div style="background:var(--merah); color:#fff; border-radius:50%; width:28px; height:28px; display:flex; align-items:center; justify-content:center; font-weight:bold; flex-shrink:0">3</div>
                            <div>
                                <strong style="display:block">Observasi Wawancara</strong>
                                <span style="font-size:0.85rem; color:var(--tinta-muda)">Pengenalan sekolah yang ramah.</span>
                            </div>
                        </li>
                        <li style="display:flex; gap:12px">
                            <div style="background:var(--kuning); color:var(--tinta); border-radius:50%; width:28px; height:28px; display:flex; align-items:center; justify-content:center; font-weight:bold; flex-shrink:0">4</div>
                            <div>
                                <strong style="display:block">Daftar Ulang</strong>
                                <span style="font-size:0.85rem; color:var(--tinta-muda)">Pembagian seragam & selamat bergabung!</span>
                            </div>
                        </li>
                    </ul>
                </div>

                <!-- Dokumen -->
                <div style="background:#fff; border-radius:32px; padding:24px; border-top:6px solid var(--biru); box-shadow:0 12px 24px rgba(59,51,85,.12); margin-bottom:24px">
                    <h4 style="margin-top:0; font-size:1.2rem; display:flex; align-items:center; gap:8px"><span style="color:var(--biru)">📂</span> Dokumen Berkas</h4>
                    <ul style="list-style:none; padding:0; margin:0; display:flex; flex-direction:column; gap:12px; font-size:0.9rem">
                        <li style="display:flex; gap:8px"><span style="color:var(--merah)">✓</span> Fotokopi Akta Kelahiran (2x)</li>
                        <li style="display:flex; gap:8px"><span style="color:var(--merah)">✓</span> Fotokopi KK (2x)</li>
                        <li style="display:flex; gap:8px"><span style="color:var(--merah)">✓</span> Fotokopi KTP Orang Tua</li>
                        <li style="display:flex; gap:8px"><span style="color:var(--merah)">✓</span> Pas Foto 3x4 (3x)</li>
                        <li style="display:flex; gap:8px"><span style="color:var(--merah)">✓</span> Ijazah TK (Menyusul)</li>
                    </ul>
                </div>

                <!-- Bantuan -->
                <div style="background:var(--kertas-tua); border-radius:24px; padding:20px; text-align:center">
                    <span style="font-size:2.5rem; display:block; margin-bottom:12px">💬</span>
                    <h4 style="margin:0 0 8px">Butuh Bantuan?</h4>
                    <p style="font-size:0.9rem; margin-bottom:16px">Tim kami siap membantu pendaftaran ananda.</p>
                    <a href="https://api.whatsapp.com/send?phone=6281234567890" target="_blank" class="tk-tombol tk-tombol--kedua" style="font-size:0.9rem; padding:10px 16px">Chat Panitia via WA</a>
                </div>
            </div>
        </div>
    </div>
</section>

</main>
