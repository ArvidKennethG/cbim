
</main>

<!-- ============================ FOOTER ============================ -->
<footer class="tk-footer">
    <div class="tk-wadah">
        <div class="tk-footer__grid">
            <div>
                <h4>Alamat sekolah</h4>
                <p>Kupang, Nusa Tenggara Timur.<br>Alamat lengkap dan nomor telepon menyusul.</p>
                <p style="margin-bottom:0">Jam sekolah: Senin–Jumat, 07.30–11.30 WITA.</p>
            </div>

            <div>
                <h4>Unit lain</h4>
                <a href="https://ucb.ac.id/" target="_blank" rel="noopener">Universitas Citra Bangsa</a>
                <a href="https://smakcitrabangsa.sch.id/" target="_blank" rel="noopener">SMA K Citra Bangsa</a>
                <a href="http://smpkcitrabangsa.com/" target="_blank" rel="noopener">SMP K Citra Bangsa</a>
                <a href="<?= base_url('sd'); ?>">SD K Citra Bangsa</a>
                <a href="<?= base_url('tk'); ?>">TK K Citra Bangsa</a>
            </div>

            <div>
                <h4>Ikuti kami</h4>
                <a href="https://www.facebook.com/profile.php?id=100086189573438" target="_blank" rel="noopener">
                    <img class="tk-ikon-sosial" src="<?= base_url(); ?>assets/templates/media/svg/brand-logos/facebook-4.svg" alt=""> Citra Bina Insan Mandiri
                </a>
                <a href="https://www.youtube.com/@CBIMYayasan" target="_blank" rel="noopener">
                    <img class="tk-ikon-sosial" src="<?= base_url(); ?>assets/templates/media/svg/brand-logos/youtube-play.svg" alt=""> Yayasan CBIM
                </a>
                <a href="https://www.instagram.com/yayasan_cbim?igsh=MTNwamlmZnl1dmo2" target="_blank" rel="noopener">
                    <img class="tk-ikon-sosial" src="<?= base_url(); ?>assets/templates/media/svg/brand-logos/instagram-2-1.svg" alt=""> yayasan_cbim
                </a>
            </div>
        </div>

        <div class="tk-footer__bawah">
            <a href="<?= base_url(); ?>" style="margin:0"><img src="<?= base_url(); ?>assets/templates/media/logos/logo-cbim.png" alt="Logo Yayasan CBIM"></a>
            <span>&copy; <?= date('Y'); ?> Yayasan Citra Bina Insan Mandiri — Kupang. Seluruh hak cipta dilindungi.</span>
        </div>
    </div>
</footer>

<button class="tk-keatas" id="keatas" aria-label="Kembali ke atas">
    <svg width="22" height="22" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true">
        <path d="M12 19V5"/><path d="m5 12 7-7 7 7"/>
    </svg>
</button>

<script>
(function () {
    /* ---------- menu di layar kecil ---------- */
    var burger = document.getElementById('burger');
    var nav = document.getElementById('nav');
    if (burger && nav) {
        burger.addEventListener('click', function () {
            var buka = nav.classList.toggle('terbuka');
            burger.setAttribute('aria-expanded', buka);
            burger.setAttribute('aria-label', buka ? 'Tutup menu' : 'Buka menu');
        });
    }

    /* ---------- bayangan header saat digulir ---------- */
    var header = document.getElementById('header');
    var keatas = document.getElementById('keatas');
    window.addEventListener('scroll', function () {
        if (header) header.classList.toggle('melayang', window.scrollY > 12);
        if (keatas) keatas.classList.toggle('tampil', window.scrollY > 500);
    }, { passive: true });

    if (keatas) {
        keatas.addEventListener('click', function () {
            window.scrollTo({ top: 0, behavior: 'smooth' });
        });
    }

    /* ---------- Animasi Scroll (Intersection Observer) ---------- */
    var animasiKelas = '.tk-naik, .tk-muncul, .tk-kiri, .tk-kanan, .tk-zoom';
    var gerakOk = !window.matchMedia('(prefers-reduced-motion: reduce)').matches;
    if (gerakOk && 'IntersectionObserver' in window) {
        var pengamat = new IntersectionObserver(function (entries) {
            entries.forEach(function (entry) {
                if (entry.isIntersecting) {
                    entry.target.classList.add('tk-tampil');
                    pengamat.unobserve(entry.target);
                }
            });
        }, { threshold: 0.12, rootMargin: '0px 0px -40px 0px' });

        document.querySelectorAll(animasiKelas).forEach(function (el) {
            pengamat.observe(el);
        });
    } else {
        document.querySelectorAll(animasiKelas).forEach(function (el) {
            el.classList.add('tk-tampil');
        });
    }
})();
</script>
</body>
</html>