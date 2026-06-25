<?= $this->extend('layouts/admin') ?>

<?= $this->section('styles') ?>
<style>
    .exec-header {
        background: linear-gradient(135deg, rgba(251, 191, 36, 0.15) 0%, rgba(59, 130, 246, 0.05) 100%);
        border: 1px solid var(--border-color);
        border-radius: 12px;
        padding: 24px;
        margin-bottom: 30px;
    }

    .kendala-card {
        background: var(--card-bg);
        border: 1px solid var(--border-color);
        border-radius: 16px;
        padding: 24px;
        transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
        height: 100%;
        display: flex;
        flex-direction: column;
        justify-content: space-between;
    }

    .kendala-card:hover {
        transform: translateY(-5px);
        border-color: rgba(251, 191, 36, 0.3);
        box-shadow: 0 10px 30px rgba(0, 0, 0, 0.15);
    }

    .box-info {
        background: var(--input-bg);
        border: 1px solid var(--border-color);
        border-radius: 8px;
        padding: 12px;
    }

    .icon-badge {
        width: 32px;
        height: 32px;
        border-radius: 8px;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 0.9rem;
    }

    .badge-warn {
        background: rgba(251, 191, 36, 0.1) !important;
        color: #fbbf24 !important;
        border: 1px solid rgba(251, 191, 36, 0.2) !important;
    }

    .badge-sol {
        background: rgba(52, 211, 153, 0.1) !important;
        color: #34d399 !important;
        border: 1px solid rgba(52, 211, 153, 0.2) !important;
    }
</style>
<?= $this->endSection() ?>

<?= $this->section('content') ?>

<!-- Header -->
<div class="exec-header d-flex justify-content-between align-items-center gap-3">
    <div>
        <span class="badge bg-warning-subtle text-warning border border-warning-subtle px-3 py-1.5 rounded-pill mb-2 font-heading" style="font-weight:600;"><i class="fa-solid fa-triangle-exclamation me-1"></i>Hambatan Operasional</span>
        <h2 class="text-white fw-bold mb-1">Kendala & Solusi Bidang</h2>
        <p class="text-muted small mb-0">Pemantauan hambatan pelaksanaan kegiatan SPJ bulanan beserta solusi pemecahannya dari masing-masing bidang • Hari ini: <b><?= date('d M Y') ?></b></p>
    </div>
    <div class="d-flex gap-2">
        <a href="<?= site_url('eksekutif') ?>" class="btn btn-outline-secondary text-white">
            <i class="fa-solid fa-arrow-left me-1.5"></i>Kembali
        </a>
        <a href="<?= site_url('eksekutif/cetak-laporan') ?>" target="_blank" class="btn btn-portal">
            <i class="fa-solid fa-print me-1.5"></i>Cetak Laporan
        </a>
    </div>
</div>

<!-- Obstacles Grid -->
<div class="row g-4 animate-fade-up">
    <?php if (empty($kendalaKegiatan)): ?>
        <div class="col-12 text-center py-5">
            <div class="glass-card p-5">
                <i class="fa-solid fa-circle-check text-success fa-3x mb-3"></i>
                <h4 class="text-white fw-bold mb-1">Tidak Ada Kendala Dilaporkan</h4>
                <p class="text-muted small mb-0">Seluruh unit kerja/bidang menjalankan kegiatan bulanan tanpa hambatan administratif maupun operasional.</p>
            </div>
        </div>
    <?php else: ?>
        <?php foreach ($kendalaKegiatan as $kk): ?>
            <div class="col-md-6 col-lg-4">
                <div class="kendala-card">
                    <div>
                        <!-- Header Card -->
                        <div class="d-flex align-items-center justify-content-between gap-2 mb-2">
                            <span class="badge bg-secondary-subtle text-secondary border border-secondary-subtle px-2 py-1 small"><?= esc($kk['kode_bidang']) ?></span>
                            <span class="badge bg-warning-subtle text-warning border border-warning-subtle px-2.5 py-1 small" style="font-weight: 600;">
                                <i class="fa-solid fa-calendar me-1"></i>SPJ: <?= esc($kk['bulan_spj']) ?>
                            </span>
                        </div>
                        <div class="mb-3">
                            <span class="badge bg-primary-subtle text-primary border border-primary-subtle px-2.5 py-1.5 w-100 text-start" style="white-space: normal; line-height: 1.4;">
                                <i class="fa-solid fa-building me-1"></i><?= esc($kk['nama_bidang']) ?>
                            </span>
                        </div>

                        <!-- Kegiatan Title -->
                        <h5 class="text-white fw-bold mb-3"><?= esc($kk['nama_kegiatan']) ?></h5>

                        <!-- Kegiatan Stats Context -->
                        <div class="box-info mb-3 d-flex justify-content-between align-items-center text-center small gap-2">
                            <div class="flex-grow-1 border-end border-secondary border-opacity-10 py-1">
                                <span class="text-muted d-block mb-1" style="font-size:0.75rem;">Realisasi Keuangan</span>
                                <span class="fw-bold text-success">Rp<?= number_format($kk['realisasi_keuangan'], 0, ',', '.') ?></span>
                            </div>
                            <div class="flex-grow-1 py-1">
                                <span class="text-muted d-block mb-1" style="font-size:0.75rem;">Realisasi Fisik</span>
                                <span class="fw-bold text-primary"><?= number_format($kk['realisasi_fisik'], 1) ?>%</span>
                            </div>
                        </div>

                        <!-- Kendala Section -->
                        <div class="mb-3 p-3 rounded" style="background: rgba(251, 191, 36, 0.05); border: 1px solid rgba(251, 191, 36, 0.1);">
                            <div class="d-flex align-items-center gap-2 mb-1.5">
                                <div class="icon-badge badge-warn"><i class="fa-solid fa-circle-exclamation"></i></div>
                                <span class="fw-bold text-warning small">Kendala / Masalah</span>
                            </div>
                            <p class="text-muted small mb-0" style="text-align: justify; line-height: 1.4;"><?= esc($kk['kendala']) ?></p>
                        </div>
                    </div>

                    <!-- Solusi Section -->
                    <div class="p-3 rounded mt-2" style="background: rgba(52, 211, 153, 0.05); border: 1px solid rgba(52, 211, 153, 0.1);">
                        <div class="d-flex align-items-center gap-2 mb-1.5">
                            <div class="icon-badge badge-sol"><i class="fa-solid fa-circle-check"></i></div>
                            <span class="fw-bold text-success small">Solusi Ditawarkan</span>
                        </div>
                        <p class="text-muted small mb-0" style="text-align: justify; line-height: 1.4;"><?= !empty($kk['solusi']) ? esc($kk['solusi']) : '<i class="text-muted">Belum diinput / dalam peninjauan...</i>' ?></p>
                    </div>
                </div>
            </div>
        <?php endforeach; ?>
    <?php endif; ?>
</div>

<?= $this->endSection() ?>
