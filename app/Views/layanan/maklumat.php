<?= $this->extend('layouts/main') ?>

<?= $this->section('styles') ?>
<style>
    .hero-banner-container {
        background: linear-gradient(rgba(11, 15, 25, 0.7), rgba(11, 15, 25, 0.85)), url('https://images.unsplash.com/photo-1541829019-2592e157e1f3?q=80&w=1600') no-repeat center center;
        background-size: cover;
        border-radius: 16px;
        padding: 60px 40px;
        margin-bottom: 40px;
        border: 1px solid var(--border-color);
    }
    html[data-theme="light"] .hero-banner-container {
        background: linear-gradient(rgba(248, 250, 252, 0.8), rgba(248, 250, 252, 0.92)), url('https://images.unsplash.com/photo-1541829019-2592e157e1f3?q=80&w=1600') no-repeat center center;
        background-size: cover;
    }
    .maklumat-statement-box {
        background: #ffffff !important;
        color: #0f172a !important;
        border-radius: 16px;
        padding: 40px;
        box-shadow: 0 10px 40px rgba(0,0,0,0.15);
        border: 1px solid rgba(0,0,0,0.05);
        text-align: center;
        max-width: 900px;
        margin: -20px auto 40px auto;
        position: relative;
        z-index: 10;
    }
    html[data-theme="dark"] .maklumat-statement-box {
        background: rgba(255, 255, 255, 0.95) !important;
        color: #0f172a !important;
    }
</style>
<?= $this->endSection() ?>

<?= $this->section('content') ?>

<div class="py-2">
    <!-- Hero Banner with Background Image overlay -->
    <div class="hero-banner-container text-center text-lg-start">
        <div class="row align-items-center">
            <div class="col-lg-10 offset-lg-1">
                <span class="badge badge-custom-primary px-3 py-2 rounded-pill mb-3 font-heading" style="font-weight:600; letter-spacing: 0.5px;">MAKLUMAT PELAYANAN</span>
                <h1 class="display-4 fw-bold text-white font-heading mb-3">Maklumat Pelayanan</h1>
                <p class="lead text-muted mb-0" style="font-size: 1.15rem; line-height: 1.8;">
                    Maklumat pelayanan merupakan bentuk legalitas yang memberikan hak kepada masyarakat pengguna layanan untuk mendapatkan akses pelayanan publik yang sesuai dengan harapan dan kebutuhannya, perlindungan atau pengayoman, kepastian biaya dan waktu penyelesaian, mengajukan keluhan, pengaduan dan melakukan pengawasan.
                </p>
            </div>
        </div>
    </div>

    <!-- Floating Statement Card -->
    <div class="maklumat-statement-box">
        <h2 style="font-family: 'Outfit', sans-serif; font-weight: 800; font-size: 2.2rem; margin-bottom: 20px; color: #be123c;">Maklumat Pelayanan</h2>
        <p style="font-size: 1.2rem; line-height: 1.8; color: #334155; max-width: 800px; margin: 0 auto;" class="fw-medium">
            "Dengan ini kami menyatakan sanggup menyelenggarakan pelayanan administrasi Badan Kesatuan Bangsa dan Politik Kabupaten Sinjai dengan cepat, akurat, santun, transparan dan akuntabel sesuai dengan standar pelayanan yang telah ditetapkan."
        </p>
        <div class="mt-4 pt-3 border-top border-light d-flex justify-content-center gap-5">
            <div>
                <i class="fa-solid fa-circle-check text-success me-2"></i><strong>Transparan</strong>
            </div>
            <div>
                <i class="fa-solid fa-circle-check text-success me-2"></i><strong>Akuntabel</strong>
            </div>
            <div>
                <i class="fa-solid fa-circle-check text-success me-2"></i><strong>Tanpa Pungutan Liar (Pungli)</strong>
            </div>
        </div>
    </div>
</div>

<?= $this->endSection() ?>
