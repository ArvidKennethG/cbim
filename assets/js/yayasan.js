/* ============================================================================
   SITUS YAYASAN CBIM — JAVASCRIPT
   ----------------------------------------------------------------------------
   Tanpa kerangka kerja. Tiap bagian diperiksa keberadaan elemennya dulu, jadi
   berkas yang sama aman dimuat di semua halaman.
   ========================================================================== */
(function () {
    'use strict';

    var kurangiGerak = window.matchMedia('(prefers-reduced-motion: reduce)').matches;
    var layarSempit  = function () { return window.matchMedia('(max-width: 1020px)').matches; };

    /* ------------------------------------------------ MENU & LACI (DROPDOWN) */
    var menu    = document.getElementById('menu');
    var tombol  = document.getElementById('tombolMenu');
    var items   = Array.prototype.slice.call(document.querySelectorAll('[data-laci]'));

    var tutupSemuaLaci = function (kecuali) {
        items.forEach(function (it) {
            if (it === kecuali) { return; }
        var btn = it.querySelector('.menu__laci-toggle') || it.querySelector('.menu__tautan');
        var lac = it.querySelector('.laci');
        if (btn) { btn.setAttribute('aria-expanded', 'false'); }
            if (lac) { lac.removeAttribute('data-buka'); }
        });
    };

    items.forEach(function (item) {
        var btn = item.querySelector('.menu__laci-toggle') || item.querySelector('.menu__tautan');
        var lac = item.querySelector('.laci');
        if (!btn || !lac) { return; }

        btn.addEventListener('click', function (e) {
            e.stopPropagation();
            var buka = btn.getAttribute('aria-expanded') === 'true';
            tutupSemuaLaci(item);
            
            // Di layar lebar, jika tombol diklik, biarkan tetap terbuka (jangan ditutup)
            // karena pengguna mungkin mengklik untuk memastikan menu terbuka setelah di-hover.
            if (buka && layarSempit()) {
                btn.setAttribute('aria-expanded', 'false');
                lac.removeAttribute('data-buka');
            } else {
                btn.setAttribute('aria-expanded', 'true');
                lac.setAttribute('data-buka', '1');
            }
        });

        // Di layar lebar, laci ikut terbuka saat kursor lewat. Di layar sempit
        // tidak, karena di sana tidak ada kursor dan buka-tutupnya lewat ketukan.
        item.addEventListener('mouseenter', function () {
            if (layarSempit()) { return; }
            tutupSemuaLaci(item);
            btn.setAttribute('aria-expanded', 'true');
            lac.setAttribute('data-buka', '1');
        });
        item.addEventListener('mouseleave', function () {
            if (layarSempit()) { return; }
            btn.setAttribute('aria-expanded', 'false');
            lac.removeAttribute('data-buka');
        });
    });

    // Klik di luar menu menutup semua laci
    document.addEventListener('click', function (e) {
        if (menu && !menu.contains(e.target)) { tutupSemuaLaci(null); }
    });

    document.addEventListener('keydown', function (e) {
        if (e.key !== 'Escape') { return; }
        tutupSemuaLaci(null);
        if (menu && menu.classList.contains('terbuka')) {
            menu.classList.remove('terbuka');
            if (tombol) {
                tombol.setAttribute('aria-expanded', 'false');
                tombol.focus();
            }
        }
    });

    if (tombol && menu) {
        tombol.addEventListener('click', function () {
            var buka = menu.classList.toggle('terbuka');
            tombol.setAttribute('aria-expanded', buka ? 'true' : 'false');
            tombol.setAttribute('aria-label', buka ? 'Tutup menu' : 'Buka menu');
            if (!buka) { tutupSemuaLaci(null); }
        });
    }

    /* ------------------------------------------------------ BAYANGAN KEPALA */
    var kepala = document.getElementById('kepala');
    if (kepala) {
        var cek = function () { kepala.classList.toggle('melayang', window.scrollY > 8); };
        cek();
        window.addEventListener('scroll', cek, { passive: true });
    }

    /* --------------------------------------------------------- ANIMASI MASUK */
    var masuk = document.querySelectorAll('.masuk');
    if (kurangiGerak || !('IntersectionObserver' in window)) {
        Array.prototype.forEach.call(masuk, function (el) { el.classList.add('tampak'); });
    } else {
        var pengamat = new IntersectionObserver(function (entri) {
            entri.forEach(function (e) {
                if (e.isIntersecting) {
                    e.target.classList.add('tampak');
                    pengamat.unobserve(e.target);
                }
            });
        }, { rootMargin: '0px 0px -50px 0px' });
        Array.prototype.forEach.call(masuk, function (el) { pengamat.observe(el); });
    }

    /* ------------------------------------------------------------- LIGHTBOX */
    /* Bisa dipindah maju mundur dengan tombol panah, tombol keyboard, maupun
       usapan jari, jadi pengunjung tidak perlu menutup lalu membuka lagi
       untuk melihat foto berikutnya. */
    var kotak = document.getElementById('lightbox');
    if (kotak) {
        var gambar  = kotak.querySelector('img');
        var teks    = kotak.querySelector('figcaption');
        var tutupBt = kotak.querySelector('.lightbox__tutup');
        var noEl    = document.getElementById('lightboxNo');
        var mundurB = document.getElementById('lightboxMundur');
        var majuB   = document.getElementById('lightboxMaju');

        var daftar = Array.prototype.slice.call(document.querySelectorAll('.bingkai[data-penuh]'));
        var kini   = 0;
        var pemicu = null;

        var tampilkan = function (i) {
            if (!daftar.length) { return; }
            kini = (i + daftar.length) % daftar.length;   // berputar di ujung
            var t = daftar[kini];

            gambar.src = t.getAttribute('data-penuh');
            gambar.alt = t.getAttribute('data-judul') || '';

            var judul = t.getAttribute('data-judul') || '';
            var ket   = t.getAttribute('data-keterangan') || '';
            teks.textContent = ket ? judul + ' — ' + ket : judul;

            if (noEl) { noEl.textContent = (kini + 1) + ' / ' + daftar.length; }

            var satu = daftar.length < 2;
            if (mundurB) { mundurB.hidden = satu; }
            if (majuB)   { majuB.hidden = satu; }
        };

        var buka = function (i) {
            pemicu = daftar[i];
            tampilkan(i);
            kotak.setAttribute('open', '');
            document.body.style.overflow = 'hidden';
            tutupBt.focus();
        };

        var tutupKotak = function () {
            kotak.removeAttribute('open');
            gambar.removeAttribute('src');
            document.body.style.overflow = '';
            if (pemicu) { pemicu.focus(); }   // kembali ke foto yang tadi diklik
        };

        daftar.forEach(function (t, i) {
            t.addEventListener('click', function () { buka(i); });
        });

        if (mundurB) { mundurB.addEventListener('click', function (e) { e.stopPropagation(); tampilkan(kini - 1); }); }
        if (majuB)   { majuB.addEventListener('click', function (e) { e.stopPropagation(); tampilkan(kini + 1); }); }

        kotak.addEventListener('click', function (e) {
            if (e.target === kotak || e.target === tutupBt) { tutupKotak(); }
        });

        document.addEventListener('keydown', function (e) {
            if (!kotak.hasAttribute('open')) { return; }
            if (e.key === 'Escape')     { tutupKotak(); }
            if (e.key === 'ArrowLeft')  { tampilkan(kini - 1); }
            if (e.key === 'ArrowRight') { tampilkan(kini + 1); }
        });

        // Usapan jari di ponsel
        var xMulai = null;
        kotak.addEventListener('touchstart', function (e) {
            xMulai = e.touches[0].clientX;
        }, { passive: true });
        kotak.addEventListener('touchend', function (e) {
            if (xMulai === null) { return; }
            var geser = e.changedTouches[0].clientX - xMulai;
            if (Math.abs(geser) > 55) { tampilkan(kini + (geser < 0 ? 1 : -1)); }
            xMulai = null;
        });
    }

    /* -------------------------------------------------------- PEMUTAR VIDEO */
    var bingkai = document.getElementById('bingkaiVideo');
    if (bingkai) {
        var judulEl = document.getElementById('judulVideo');
        var deskEl  = document.getElementById('deskripsiVideo');
        var layar   = document.getElementById('layarVideo');

        Array.prototype.forEach.call(document.querySelectorAll('.tayang'), function (kartu) {
            kartu.addEventListener('click', function () {
                var id = kartu.getAttribute('data-yt');
                if (!id) { return; }

                // youtube-nocookie supaya tidak ada cookie pelacak sebelum
                // pengunjung benar-benar menonton.
                bingkai.src = 'https://www.youtube-nocookie.com/embed/' + id + '?autoplay=1&rel=0';

                Array.prototype.forEach.call(document.querySelectorAll('.tayang'), function (k) {
                    k.setAttribute('aria-current', k === kartu ? 'true' : 'false');
                });

                if (judulEl) { judulEl.textContent = kartu.getAttribute('data-judul') || ''; }
                if (deskEl)  { deskEl.textContent  = kartu.getAttribute('data-deskripsi') || ''; }
                if (layar)   { layar.scrollIntoView({ behavior: kurangiGerak ? 'auto' : 'smooth', block: 'center' }); }
            });
        });
    }

    /* --------------------------------------------------- KEMBALI KE ATAS */
    /* Tombol baru muncul setelah pengunjung menggulir kira-kira satu layar.
       Kalau ditampilkan sejak awal, dia hanya menutupi isi halaman padahal
       tombol "atas" belum ada gunanya. */
    var keAtas = document.getElementById('keAtas');
    if (keAtas) {
        var ambang = function () { return Math.max(320, window.innerHeight * 0.7); };
        var sedangCek = false;

        var perbarui = function () {
            var perlu = window.scrollY > ambang();
            if (perlu) {
                keAtas.hidden = false;
                // Ditunda satu frame supaya transisi opacity benar-benar jalan,
                // bukan langsung melompat ke keadaan akhir.
                requestAnimationFrame(function () { keAtas.classList.add('tampil'); });
            } else {
                keAtas.classList.remove('tampil');
            }
            sedangCek = false;
        };

        // Pemeriksaan dibatasi satu kali per frame, supaya menggulir tetap mulus
        // di ponsel yang tidak kencang.
        window.addEventListener('scroll', function () {
            if (sedangCek) { return; }
            sedangCek = true;
            requestAnimationFrame(perbarui);
        }, { passive: true });

        keAtas.addEventListener('transitionend', function (e) {
            if (e.propertyName === 'opacity' && !keAtas.classList.contains('tampil')) {
                keAtas.hidden = true;
            }
        });

        keAtas.addEventListener('click', function () {
            window.scrollTo({ top: 0, behavior: kurangiGerak ? 'auto' : 'smooth' });

            // Pengguna keyboard dikembalikan ke awal halaman, bukan dibiarkan
            // fokusnya tertinggal di tombol yang sebentar lagi menghilang.
            var awal = document.querySelector('.lewati') || document.body;
            awal.setAttribute('tabindex', '-1');
            awal.focus({ preventScroll: true });
        });

        perbarui();
    }


    /* ------------------------------------------------- DAFTAR ISI HALAMAN */
    /* Menandai bagian yang sedang dibaca, dan menggeser daftarnya sendiri agar
       tanda itu selalu terlihat di layar sempit. */
    var daftar = document.getElementById('daftarIsi');
    if (daftar && 'IntersectionObserver' in window) {
        var tautan = Array.prototype.slice.call(daftar.querySelectorAll('a'));
        var bagian = tautan
            .map(function (a) { return document.querySelector(a.getAttribute('href')); })
            .filter(Boolean);

        if (bagian.length) {
            var tandai = function (id) {
                tautan.forEach(function (a) {
                    var aktif = a.getAttribute('href') === '#' + id;
                    if (aktif) { a.setAttribute('aria-current', 'true'); }
                    else { a.removeAttribute('aria-current'); }
                });
            };

            var mata = new IntersectionObserver(function (entri) {
                entri.forEach(function (e) {
                    if (e.isIntersecting) { tandai(e.target.id); }
                });
            }, { rootMargin: '-140px 0px -65% 0px' });

            bagian.forEach(function (b) { mata.observe(b); });
        }
    }

})();
