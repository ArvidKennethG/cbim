<?php
/**
 * =============================================================================
 * BE-10: Banner Cookie Consent untuk Subsite SD & TK  --  BARU (PATCH 2026-09-07)
 * =============================================================================
 * Disertakan sebelum </body> di templates/sd/footer.php dan
 * templates/tk/footer.php:
 *
 *     <?php $this->load->view('templates/subsite/cookie_banner'); ?>
 *
 * Berdiri sendiri (hanya butuh Bootstrap 5) karena subsite tidak memuat
 * custom-cbim.js maupun Metronic. Kunci penyimpanan persetujuan sengaja
 * disamakan dengan portal utama -- 'cbim_cookie_consent' -- sehingga pengunjung
 * yang sudah memilih di halaman yayasan tidak ditanya lagi di /sd atau /tk,
 * dan sebaliknya.
 * =============================================================================
 */
?>
<style>
    .cbim-subsite-cookie {
        display: none;
        position: fixed;
        left: 1rem;
        right: 1rem;
        bottom: 1rem;
        z-index: 1070;
        max-width: 560px;
        margin-inline: auto;
        background: #ffffff;
        border-radius: 16px;
        border-top: 4px solid var(--cbim-primary, #890C25);
        box-shadow: 0 16px 40px rgba(17, 12, 45, 0.22);
        padding: 1.25rem;
    }
    @media (min-width: 768px) {
        .cbim-subsite-cookie { left: auto; right: 1.5rem; bottom: 1.5rem; }
    }
</style>

<div id="cbimSubsiteCookie" class="cbim-subsite-cookie" role="dialog" aria-live="polite" aria-label="Pemberitahuan Cookie">
    <div class="d-flex align-items-start gap-3">
        <i class="bi bi-shield-check fs-2" style="color: var(--cbim-primary);" aria-hidden="true"></i>
        <div>
            <h6 class="fw-bold mb-1 text-dark">Privasi &amp; Cookie</h6>
            <p class="text-muted mb-3" style="font-size: 0.9rem;">
                Kami menggunakan cookie untuk menganalisis lalu lintas website dan meningkatkan
                layanan pendaftaran. Anda dapat menolak tanpa kehilangan akses ke halaman ini.
                Selengkapnya di <a href="<?= base_url('kebijakan-privasi'); ?>" class="fw-bold" style="color: var(--cbim-primary);">Kebijakan Privasi</a>.
            </p>
            <div class="d-flex flex-wrap gap-2">
                <button type="button" id="cbimSubsiteAccept" class="btn btn-sm text-white fw-bold px-4" style="background: var(--cbim-primary);">
                    Setujui
                </button>
                <button type="button" id="cbimSubsiteReject" class="btn btn-sm btn-light border fw-bold px-4">
                    Tolak
                </button>
            </div>
        </div>
    </div>
</div>

<script>
(function () {
    var banner = document.getElementById('cbimSubsiteCookie');
    if (!banner) return;

    function readConsent() {
        try {
            var v = localStorage.getItem('cbim_cookie_consent');
            if (v) return v;
        } catch (e) { /* localStorage diblokir browser */ }
        var m = document.cookie.match(/(?:^|;\s*)cbim_cookie_consent=([^;]+)/);
        return m ? m[1] : null;
    }

    function storeConsent(value) {
        try { localStorage.setItem('cbim_cookie_consent', value); } catch (e) {}
        document.cookie = 'cbim_cookie_consent=' + value + ';path=/;max-age=31536000;SameSite=Lax';
    }

    function updateConsentMode(granted) {
        if (typeof gtag !== 'function') return;
        var state = granted ? 'granted' : 'denied';
        gtag('consent', 'update', {
            'ad_storage': state,
            'ad_user_data': state,
            'ad_personalization': state,
            'analytics_storage': state
        });
    }

    if (!readConsent()) {
        banner.style.display = 'block';
    }

    document.getElementById('cbimSubsiteAccept').addEventListener('click', function () {
        storeConsent('accepted');
        updateConsentMode(true);
        banner.style.display = 'none';
    });

    document.getElementById('cbimSubsiteReject').addEventListener('click', function () {
        storeConsent('rejected');
        updateConsentMode(false);
        banner.style.display = 'none';
    });
})();
</script>
