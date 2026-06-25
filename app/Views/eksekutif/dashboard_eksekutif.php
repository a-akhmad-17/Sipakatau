<?= $this->extend('layouts/admin') ?>

<?= $this->section('styles') ?>
<style>
    .exec-header {
        background: linear-gradient(135deg, rgba(99, 102, 241, 0.15) 0%, rgba(59, 130, 246, 0.05) 100%);
        border: 1px solid var(--border-color);
        border-radius: 12px;
        padding: 24px;
        margin-bottom: 30px;
    }

    .metric-card {
        background: var(--card-bg);
        border: 1px solid var(--border-color);
        border-radius: 14px;
        padding: 20px;
        position: relative;
        overflow: hidden;
        transition: all 0.3s ease;
    }

    .metric-card::before {
        content: '';
        position: absolute;
        width: 150px;
        height: 150px;
        background: radial-gradient(circle, rgba(99, 102, 241, 0.06) 0%, rgba(0,0,0,0) 70%);
        top: -50px;
        right: -50px;
        pointer-events: none;
    }

    .metric-card:hover {
        transform: translateY(-3px);
        border-color: var(--card-hover-border);
    }

    .icon-box {
        width: 48px;
        height: 48px;
        border-radius: 10px;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 1.25rem;
    }

    .icon-primary {
        background: var(--badge-target-bg) !important;
        color: var(--badge-target-color) !important;
        border: 1px solid var(--badge-target-border) !important;
    }

    .icon-success {
        background: var(--badge-realisasi-bg) !important;
        color: var(--badge-realisasi-color) !important;
        border: 1px solid var(--badge-realisasi-border) !important;
    }

    .icon-warning {
        background: var(--badge-warning-bg) !important;
        color: var(--badge-warning-color) !important;
        border: 1px solid var(--badge-warning-border) !important;
    }

    .icon-danger {
        background: var(--badge-danger-bg) !important;
        color: var(--badge-danger-color) !important;
        border: 1px solid var(--badge-danger-border) !important;
    }

    .progress-custom {
        height: 8px;
        background-color: var(--hr-border);
        border-radius: 4px;
        overflow: hidden;
    }

    .progress-bar-primary {
        background: linear-gradient(90deg, #6366f1, #3b82f6);
    }

    .progress-bar-success {
        background: linear-gradient(90deg, #34d399, #10b981);
    }

    .progress-bar-warning {
        background: linear-gradient(90deg, #fbbf24, #f59e0b);
    }

    .progress-bar-danger {
        background: linear-gradient(90deg, #f87171, #ef4444);
    }

    .shortcut-card {
        background: var(--card-bg);
        border: 1px solid var(--border-color);
        border-radius: 16px;
        transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
    }
    .shortcut-card:hover {
        transform: translateY(-5px);
        border-color: rgba(225, 29, 72, 0.3);
        box-shadow: 0 10px 30px rgba(0, 0, 0, 0.15);
    }
</style>
<?= $this->endSection() ?>

<?= $this->section('content') ?>

<!-- Header Eksekutif -->
<div class="exec-header d-flex justify-content-between align-items-center gap-3">
    <div>
        <span class="badge bg-primary-subtle text-primary border border-primary-subtle px-3 py-1.5 rounded-pill mb-2 font-heading" style="font-weight:600;"><i class="fa-solid fa-crown me-1"></i>Pimpinan Panel</span>
        <h2 class="text-white fw-bold mb-1">Executive Dashboard</h2>
        <p class="text-muted small mb-0">Selamat datang kembali, <b>Kepala Badan Kesbangpol Sinjai</b> • Hari ini: <b><?= date('d M Y') ?></b></p>
    </div>
    <div class="d-none d-md-block">
        <a href="<?= site_url('eksekutif/cetak-laporan') ?>" target="_blank" class="btn btn-portal">
            <i class="fa-solid fa-print me-1.5"></i>Cetak Laporan Fisik
        </a>
    </div>
</div>

<!-- Row 1: Metrics Overview -->
<div class="row g-3 mb-5">
    <!-- Realisasi Keuangan Kumulatif -->
    <div class="col-md-6 col-lg-3 animate-fade-up delay-1">
        <div class="metric-card">
            <div class="d-flex justify-content-between align-items-center mb-3">
                <span class="text-muted small fw-semibold">Realisasi Keuangan</span>
                <div class="icon-box icon-success">
                    <i class="fa-solid fa-rupiah-sign"></i>
                </div>
            </div>
            <h3 class="text-white fw-bold mb-1"><?= number_format($persentaseKeuangan, 1) ?>%</h3>
            <p class="text-muted small mb-2">Rp<?= number_format($totalRealisasi, 0, ',', '.') ?> dari Rp<?= number_format($totalTarget, 0, ',', '.') ?></p>
            <div class="progress progress-custom">
                <div class="progress-bar progress-bar-success" role="progressbar" style="width: <?= $persentaseKeuangan ?>%" aria-valuenow="<?= $persentaseKeuangan ?>" aria-valuemin="0" aria-valuemax="100"></div>
            </div>
        </div>
    </div>

    <!-- Realisasi Fisik Rata-rata -->
    <div class="col-md-6 col-lg-3 animate-fade-up delay-2">
        <div class="metric-card">
            <div class="d-flex justify-content-between align-items-center mb-3">
                <span class="text-muted small fw-semibold">Realisasi Fisik</span>
                <div class="icon-box icon-primary">
                    <i class="fa-solid fa-chart-line"></i>
                </div>
            </div>
            <h3 class="text-white fw-bold mb-1"><?= number_format($persentaseFisik, 1) ?>%</h3>
            <p class="text-muted small mb-2">Rata-rata Target: <?= number_format($avgTargetFisik, 1) ?>% | Real: <?= number_format($avgRealisasiFisik, 1) ?>%</p>
            <div class="progress progress-custom">
                <div class="progress-bar progress-bar-primary" role="progressbar" style="width: <?= $persentaseFisik ?>%" aria-valuenow="<?= $persentaseFisik ?>" aria-valuemin="0" aria-valuemax="100"></div>
            </div>
        </div>
    </div>

    <!-- Ormas SK Merah -->
    <div class="col-md-6 col-lg-3 animate-fade-up delay-3">
        <a href="<?= site_url('eksekutif/ormas-merah') ?>" class="text-decoration-none">
            <div class="metric-card">
                <div class="d-flex justify-content-between align-items-center mb-3">
                    <span class="text-muted small fw-semibold">Ormas SK Merah</span>
                    <div class="icon-box <?= $expiredCount > 0 ? 'icon-danger' : 'icon-success' ?>">
                        <i class="fa-solid fa-circle-exclamation"></i>
                    </div>
                </div>
                <h3 class="text-white fw-bold mb-1"><?= $expiredCount ?> Ormas</h3>
                <p class="text-muted small mb-2">Masa berlaku SK kedaluwarsa.</p>
                <div class="progress progress-custom">
                    <div class="progress-bar <?= $expiredCount > 0 ? 'progress-bar-danger' : 'progress-bar-success' ?>" role="progressbar" style="width: <?= $expiredCount > 0 ? 100 : 0 ?>%" aria-valuenow="<?= $expiredCount ?>" aria-valuemin="0" aria-valuemax="10"></div>
                </div>
            </div>
        </a>
    </div>

    <!-- Kendala Dilaporkan -->
    <div class="col-md-6 col-lg-3 animate-fade-up delay-4">
        <a href="<?= site_url('eksekutif/kendala') ?>" class="text-decoration-none">
            <div class="metric-card">
                <div class="d-flex justify-content-between align-items-center mb-3">
                    <span class="text-muted small fw-semibold">Kendala Bidang</span>
                    <div class="icon-box <?= $kendalaCount > 0 ? 'icon-warning' : 'icon-success' ?>">
                        <i class="fa-solid fa-triangle-exclamation"></i>
                    </div>
                </div>
                <h3 class="text-white fw-bold mb-1"><?= $kendalaCount ?> Kasus</h3>
                <p class="text-muted small mb-2">Kendala operasional dilaporkan.</p>
                <div class="progress progress-custom">
                    <div class="progress-bar <?= $kendalaCount > 0 ? 'progress-bar-warning' : 'progress-bar-success' ?>" role="progressbar" style="width: <?= $kendalaCount > 0 ? 100 : 0 ?>%" aria-valuenow="<?= $kendalaCount ?>" aria-valuemin="0" aria-valuemax="10"></div>
                </div>
            </div>
        </a>
    </div>
</div>

<!-- Shortcuts Navigation Section -->
<div class="glass-card p-4">
    <h3 class="text-white mb-2 font-heading"><i class="fa-solid fa-circle-nodes text-danger me-2"></i>Menu Navigasi Eksekutif</h3>
    <p class="text-muted small mb-4">Pilih salah satu menu di bawah ini atau gunakan sidebar kiri untuk memantau data secara khusus.</p>
    
    <div class="row g-4">
        <!-- Kinerja Bidang -->
        <div class="col-md-6 col-lg-4">
            <div class="shortcut-card p-4 h-100 d-flex flex-column justify-content-between">
                <div>
                    <div class="icon-box icon-success mb-3">
                        <i class="fa-solid fa-chart-column"></i>
                    </div>
                    <h5 class="text-white fw-bold mb-2">Kinerja Bidang & SPJ</h5>
                    <p class="text-muted small">Tinjau grafik visual perbandingan realisasi anggaran keuangan dan pencapaian fisik per unit kerja.</p>
                </div>
                <a href="<?= site_url('eksekutif/kinerja') ?>" class="btn btn-sm btn-outline-primary w-100 mt-3">
                    Buka Kinerja Bidang
                </a>
            </div>
        </div>

        <!-- Peta GIS -->
        <div class="col-md-6 col-lg-4">
            <div class="shortcut-card p-4 h-100 d-flex flex-column justify-content-between">
                <div>
                    <div class="icon-box icon-primary mb-3">
                        <i class="fa-solid fa-map-location-dot"></i>
                    </div>
                    <h5 class="text-white fw-bold mb-2">Peta Sebaran GIS</h5>
                    <p class="text-muted small">Pantau pemetaan titik geografis ormas, partai politik, konflik sosial, dan laporan di wilayah Sinjai.</p>
                </div>
                <a href="<?= site_url('eksekutif/gis') ?>" class="btn btn-sm btn-outline-primary w-100 mt-3">
                    Buka Peta GIS
                </a>
            </div>
        </div>

        <!-- Aduan Masyarakat -->
        <div class="col-md-6 col-lg-4">
            <div class="shortcut-card p-4 h-100 d-flex flex-column justify-content-between">
                <div>
                    <div class="icon-box icon-danger mb-3">
                        <i class="fa-solid fa-bullhorn"></i>
                    </div>
                    <h5 class="text-white fw-bold mb-2">Aduan Masyarakat</h5>
                    <p class="text-muted small">Tinjau seluruh pengaduan yang dikirimkan secara anonim beserta berkas lampiran buktinya.</p>
                </div>
                <a href="<?= site_url('eksekutif/pengaduan') ?>" class="btn btn-sm btn-outline-primary w-100 mt-3">
                    Buka Portal Pengaduan
                </a>
            </div>
        </div>
    </div>
</div>

<?= $this->endSection() ?>
