<?= $this->extend('layouts/admin') ?>

<?= $this->section('styles') ?>
<style>
    .exec-header {
        background: linear-gradient(135deg, rgba(239, 68, 68, 0.1) 0%, rgba(59, 130, 246, 0.05) 100%);
        border: 1px solid var(--border-color);
        border-radius: 12px;
        padding: 24px;
        margin-bottom: 30px;
    }

    .aduan-card {
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

    .aduan-card:hover {
        transform: translateY(-5px);
        border-color: rgba(239, 68, 68, 0.3);
        box-shadow: 0 10px 30px rgba(0, 0, 0, 0.15);
    }

    .aduan-body {
        background: var(--input-bg);
        border: 1px solid var(--border-color);
        border-radius: 10px;
        padding: 15px;
        margin-top: 15px;
        margin-bottom: 15px;
        font-size: 0.9rem;
        line-height: 1.6;
        color: var(--text-muted);
        text-align: justify;
    }

    .aduan-footer {
        border-top: 1px solid var(--table-row-border);
        padding-top: 15px;
    }
</style>
<?= $this->endSection() ?>

<?= $this->section('content') ?>

<!-- Header -->
<div class="exec-header d-flex justify-content-between align-items-center gap-3">
    <div>
        <span class="badge bg-danger-subtle text-danger border border-danger-subtle px-3 py-1.5 rounded-pill mb-2 font-heading" style="font-weight:600;"><i class="fa-solid fa-bullhorn me-1"></i>Aduan Anonim</span>
        <h2 class="text-white fw-bold mb-1">Laporan Pengaduan Masyarakat</h2>
        <p class="text-muted small mb-0">Portal pemantauan laporan aduan dari masyarakat Kabupaten Sinjai yang masuk secara anonim • Hari ini: <b><?= date('d M Y') ?></b></p>
    </div>
    <div class="d-flex gap-2">
        <a href="<?= site_url('eksekutif') ?>" class="btn btn-outline-secondary text-white">
            <i class="fa-solid fa-arrow-left me-1.5"></i>Kembali
        </a>
    </div>
</div>

<!-- Aduan Grid -->
<div class="row g-4 animate-fade-up">
    <?php if (empty($pengaduan)): ?>
        <div class="col-12 text-center py-5">
            <div class="glass-card p-5">
                <i class="fa-solid fa-comment-slash text-muted fa-3x mb-3"></i>
                <h4 class="text-white fw-bold mb-1">Belum Ada Pengaduan Masuk</h4>
                <p class="text-muted small mb-0">Saat ini tidak ada laporan pengaduan masyarakat yang terdaftar di sistem.</p>
            </div>
        </div>
    <?php else: ?>
        <?php foreach ($pengaduan as $p): 
            $detail = json_decode($p['after_data'], true) ?? [];
            $katLabels = [
                'konflik' => ['label' => 'Konflik Sosial SARA', 'class' => 'bg-danger-subtle text-danger border border-danger-subtle'],
                'ormas' => ['label' => 'Ketertiban Ormas/LSM', 'class' => 'bg-warning-subtle text-warning border border-warning-subtle'],
                'politik' => ['label' => 'Pelanggaran Politik', 'class' => 'bg-primary-subtle text-primary border border-primary-subtle'],
                'layanan' => ['label' => 'Keluhan Layanan', 'class' => 'bg-info-subtle text-info border border-info-subtle'],
                'lainnya' => ['label' => 'Lainnya', 'class' => 'bg-secondary-subtle text-secondary border border-secondary-subtle'],
            ];
            $kat = $detail['kategori'] ?? 'lainnya';
            $badge = $katLabels[$kat] ?? $katLabels['lainnya'];
        ?>
            <div class="col-md-6 col-lg-4">
                <div class="aduan-card">
                    <div>
                        <!-- Header -->
                        <div class="d-flex justify-content-between align-items-center mb-3">
                            <span class="badge <?= $badge['class'] ?> px-2.5 py-1 small"><?= $badge['label'] ?></span>
                            <span class="text-muted small" style="font-size:0.75rem;">
                                <i class="fa-regular fa-clock me-1"></i>
                                <?= date('d M Y H:i', strtotime($p['created_at'])) ?> WITA
                            </span>
                        </div>

                        <!-- Title -->
                        <h5 class="text-white fw-bold mb-2"><?= esc($detail['judul'] ?? 'Tanpa Judul') ?></h5>
                        <div class="small text-muted mb-3">
                            <i class="fa-solid fa-building me-1.5 text-muted"></i>
                            Tujuan Bidang: <span class="text-white"><?= esc($detail['nama_bidang'] ?? 'Umum / Bakesbangpol') ?></span>
                        </div>

                        <!-- Description Box -->
                        <div class="aduan-body">
                            <?= nl2br(esc($detail['deskripsi'] ?? '-')) ?>
                        </div>
                    </div>

                    <!-- Footer / Attachment Link -->
                    <div class="aduan-footer d-flex justify-content-between align-items-center gap-2">
                        <span class="badge bg-success-subtle text-success border border-success-subtle px-2.5 py-1.5 small" style="font-size: 0.7rem;">
                            <i class="fa-solid fa-user-secret me-1"></i>Anonim
                        </span>
                        <?php if (!empty($detail['berkas'])): ?>
                            <a href="<?= base_url('uploads/pengaduan/' . $detail['berkas']) ?>" target="_blank" class="btn btn-sm btn-outline-info text-nowrap px-2.5 py-1.5" style="font-size: 0.75rem;">
                                <i class="fa-solid fa-file-shield me-1"></i>Lampiran
                            </a>
                        <?php else: ?>
                            <span class="text-muted small" style="font-size: 0.75rem;"><i class="fa-solid fa-paperclip me-1"></i>Tanpa Bukti</span>
                        <?php endif; ?>
                    </div>
                </div>
            </div>
        <?php endforeach; ?>
    <?php endif; ?>
</div>

<?= $this->endSection() ?>
