<!-- ============================ HERO GALERI ============================ -->
<section class="tk-hero" style="min-height: 50vh; padding-top: 100px;">
    <svg class="tk-awan tk-awan--1" viewBox="0 0 120 54" aria-hidden="true"><path d="M22 54c-12 0-22-8-22-19S10 16 22 16c3-9 12-16 22-16 12 0 22 8 25 19 12 1 21 9 21 19 0 9-9 16-21 16H22z"/></svg>
    <svg class="tk-awan tk-awan--2" viewBox="0 0 120 54" aria-hidden="true"><path d="M22 54c-12 0-22-8-22-19S10 16 22 16c3-9 12-16 22-16 12 0 22 8 25 19 12 1 21 9 21 19 0 9-9 16-21 16H22z"/></svg>

    <span class="tk-dekorasi tk-dekorasi--1" aria-hidden="true">📷</span>
    <span class="tk-dekorasi tk-dekorasi--2" aria-hidden="true">🌈</span>

    <div class="tk-wadah tk-hero__teks">
        <span class="tk-label tk-label--kuning" style="margin-bottom: 12px; display:inline-block">Dokumentasi Foto</span>
        <h1 style="font-size: clamp(2rem, 5vw, 3rem)">Galeri Foto TK</h1>
        <p class="tk-hero__sub">
            Dokumentasi kegiatan bermain, belajar, dan acara di TK & PAUD Kristen Citra Bangsa Mandiri.
            <?php if (!empty($galeri)): ?><?= count($galeri); ?> foto tersimpan. Klik untuk memperbesar.<?php endif; ?>
        </p>
    </div>

    <svg class="tk-bukit" viewBox="0 0 1200 210" preserveAspectRatio="none" aria-hidden="true">
        <path d="M0 118c150-34 260 14 400 8s210-46 360-38 190 46 290 40 150-22 150-22v104H0z" fill="#8FD3A3"/>
        <g fill="#57B979">
            <circle cx="150" cy="150" r="30"/><rect x="145" y="150" width="10" height="34"/>
            <circle cx="1010" cy="158" r="24"/><rect x="1006" y="158" width="8" height="28"/>
        </g>
        <path d="M0 158c170-24 300 18 470 12s250-32 400-24 180 30 330 24v40H0z" fill="#57B979"/>
    </svg>
</section>

<!-- ============================ GALERI ============================ -->
<section class="tk-bagian">
    <div class="tk-wadah">
        <?php if (empty($galeri)): ?>
            <div style="max-width: 600px; margin: 0 auto; text-align: center; background: #fff; padding: 40px; border-radius: 32px; border: 4px solid var(--kuning); box-shadow: 0 12px 24px rgba(59,51,85,.12);">
                <span style="font-size: 3rem; display: block; margin-bottom: 16px;">📷</span>
                <h3 style="margin-bottom: 16px;">Belum Ada Foto</h3>
                <p>
                    Dokumentasi foto TK & PAUD K Citra Bangsa Mandiri akan segera ditampilkan di halaman ini.
                </p>
                <a href="<?= base_url('tk'); ?>" class="tk-tombol tk-tombol--utama" style="margin-top: 16px;">Kembali ke Beranda</a>
            </div>
        <?php else: ?>
            <div class="tk-grid-3">
                <?php $delay = 1; foreach ($galeri as $i => $g): ?>
                    <button type="button" class="tk-kartu tk-muncul tk-tunda-<?= $delay ?> galeri-btn" style="cursor: pointer; border: none; text-align: left; width: 100%; padding: 0; overflow: hidden;"
                            data-indeks="<?= $i; ?>"
                            data-penuh="<?= base_url('uploads/galeri/' . $g['foto']); ?>"
                            data-judul="<?= html_escape($g['judul']); ?>"
                            data-keterangan="<?= html_escape($g['keterangan'] ?? ''); ?>"
                            aria-label="Perbesar foto: <?= html_escape($g['judul']); ?>">
                        <div style="height: 220px; overflow: hidden; position: relative;">
                            <img src="<?= base_url('uploads/galeri/' . $g['foto']); ?>"
                                 alt="<?= html_escape($g['judul']); ?>" loading="lazy" decoding="async"
                                 style="width: 100%; height: 100%; object-fit: cover; transition: transform .3s ease;">
                            <div style="position: absolute; inset: 0; background: linear-gradient(transparent 60%, rgba(59,51,85,.6)); display: flex; align-items: flex-end; padding: 16px;">
                                <span style="color: #fff; font-family: var(--font-judul); font-size: 1rem; font-weight: 700; text-shadow: 0 2px 8px rgba(0,0,0,.3);">
                                    <?= html_escape($g['judul']); ?>
                                </span>
                            </div>
                            <div style="position: absolute; top: 50%; left: 50%; transform: translate(-50%, -50%); opacity: 0; transition: opacity .3s ease;">
                                <span style="width: 50px; height: 50px; border-radius: 50%; background: rgba(255,255,255,.9); display: flex; align-items: center; justify-content: center;">
                                    <svg width="22" height="22" viewBox="0 0 24 24" fill="none" stroke="var(--tinta)" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><circle cx="11" cy="11" r="8"/><line x1="21" y1="21" x2="16.65" y2="16.65"/><line x1="11" y1="8" x2="11" y2="14"/><line x1="8" y1="11" x2="14" y2="11"/></svg>
                                </span>
                            </div>
                        </div>
                        <?php if (!empty($g['tanggal'])): ?>
                        <div style="padding: 12px 16px;">
                            <small style="color: var(--tinta-muda);"><?= tanggal_id($g['tanggal']); ?></small>
                        </div>
                        <?php endif; ?>
                    </button>
                <?php $delay++; if ($delay > 3) $delay = 1; endforeach; ?>
            </div>
        <?php endif; ?>
    </div>
</section>

<!-- ============================ LIGHTBOX ============================ -->
<div id="lightbox" style="display: none; position: fixed; inset: 0; z-index: 9999; background: rgba(42,36,80,.92); backdrop-filter: blur(8px); align-items: center; justify-content: center; padding: 20px;" role="dialog" aria-modal="true" aria-label="Foto diperbesar">
    <button type="button" id="lightboxTutup" style="position: absolute; top: 20px; right: 20px; background: rgba(255,255,255,.2); border: none; color: #fff; font-size: 2rem; width: 48px; height: 48px; border-radius: 50%; cursor: pointer; display: flex; align-items: center; justify-content: center;" aria-label="Tutup">&times;</button>
    
    <button type="button" id="lightboxMundur" style="position: absolute; left: 16px; top: 50%; transform: translateY(-50%); background: rgba(255,255,255,.2); border: none; color: #fff; font-size: 1.5rem; width: 48px; height: 48px; border-radius: 50%; cursor: pointer; display: flex; align-items: center; justify-content: center;" aria-label="Foto sebelumnya">
        <svg width="22" height="22" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="m15 18-6-6 6-6"/></svg>
    </button>
    
    <div style="max-width: 90vw; max-height: 80vh; text-align: center;">
        <img id="lightboxImg" src="" alt="" style="max-width: 100%; max-height: 75vh; border-radius: 16px; box-shadow: 0 20px 50px rgba(0,0,0,.3);">
        <p id="lightboxCaption" style="color: #fff; margin-top: 16px; font-family: var(--font-judul); font-size: 1.1rem;"></p>
    </div>
    
    <button type="button" id="lightboxMaju" style="position: absolute; right: 16px; top: 50%; transform: translateY(-50%); background: rgba(255,255,255,.2); border: none; color: #fff; font-size: 1.5rem; width: 48px; height: 48px; border-radius: 50%; cursor: pointer; display: flex; align-items: center; justify-content: center;" aria-label="Foto berikutnya">
        <svg width="22" height="22" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="m9 18 6-6-6-6"/></svg>
    </button>
</div>

<style>
.galeri-btn:hover img { transform: scale(1.08); }
.galeri-btn:hover div:last-child { opacity: 1 !important; }
#lightbox[style*="flex"] { display: flex !important; }
</style>

<script>
(function () {
    var btns = document.querySelectorAll('.galeri-btn');
    var lb = document.getElementById('lightbox');
    var img = document.getElementById('lightboxImg');
    var cap = document.getElementById('lightboxCaption');
    var indeks = 0;
    var data = [];

    btns.forEach(function (b, i) {
        data.push({ src: b.dataset.penuh, judul: b.dataset.judul });
        b.addEventListener('click', function () {
            indeks = i;
            tampil();
        });
    });

    function tampil() {
        if (!data[indeks]) return;
        img.src = data[indeks].src;
        img.alt = data[indeks].judul;
        cap.textContent = data[indeks].judul;
        lb.style.display = 'flex';
        document.body.style.overflow = 'hidden';
    }

    function tutup() {
        lb.style.display = 'none';
        document.body.style.overflow = '';
    }

    document.getElementById('lightboxTutup').addEventListener('click', tutup);
    document.getElementById('lightboxMundur').addEventListener('click', function () {
        indeks = (indeks - 1 + data.length) % data.length;
        tampil();
    });
    document.getElementById('lightboxMaju').addEventListener('click', function () {
        indeks = (indeks + 1) % data.length;
        tampil();
    });

    lb.addEventListener('click', function (e) {
        if (e.target === lb) tutup();
    });

    document.addEventListener('keydown', function (e) {
        if (lb.style.display === 'none') return;
        if (e.key === 'Escape') tutup();
        if (e.key === 'ArrowLeft') { indeks = (indeks - 1 + data.length) % data.length; tampil(); }
        if (e.key === 'ArrowRight') { indeks = (indeks + 1) % data.length; tampil(); }
    });
})();
</script>
