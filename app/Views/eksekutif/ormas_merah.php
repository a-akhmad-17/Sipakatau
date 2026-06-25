<?= $this->extend('layouts/admin') ?>

<?= $this->section('styles') ?>
<style>
    .exec-header {
        background: linear-gradient(135deg, rgba(239, 68, 68, 0.15) 0%, rgba(59, 130, 246, 0.05) 100%);
        border: 1px solid var(--border-color);
        border-radius: 12px;
        padding: 24px;
        margin-bottom: 30px;
    }

    .warning-alert {
        background: rgba(239, 68, 68, 0.1);
        border: 1px solid rgba(239, 68, 68, 0.2);
        border-radius: 12px;
        padding: 20px;
        margin-bottom: 30px;
        display: flex;
        align-items: flex-start;
        gap: 15px;
    }

    .warning-icon {
        background: rgba(239, 68, 68, 0.2);
        color: #f87171;
        width: 48px;
        height: 48px;
        border-radius: 10px;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 1.5rem;
        flex-shrink: 0;
    }

    .table-custom {
        background: var(--card-bg);
        border: 1px solid var(--border-color);
        color: var(--text-main);
    }

    .table-custom th {
        background: var(--table-header-bg) !important;
        color: var(--text-main) !important;
        border-bottom: 1px solid var(--border-color);
        padding: 15px;
    }

    .table-custom td {
        padding: 15px;
        border-bottom: 1px solid var(--table-row-border);
        vertical-align: middle;
    }

    .row-expired {
        border-left: 4px solid #ef4444 !important;
    }

    .badge-expired {
        background: var(--badge-danger-bg) !important;
        color: var(--badge-danger-color) !important;
        border: 1px solid var(--badge-danger-border) !important;
        font-weight: 600;
    }
</style>
<?= $this->endSection() ?>

<?= $this->section('content') ?>

<!-- Header -->
<div class="exec-header d-flex justify-content-between align-items-center gap-3">
    <div>
        <span class="badge bg-danger-subtle text-danger border border-danger-subtle px-3 py-1.5 rounded-pill mb-2 font-heading" style="font-weight:600;"><i class="fa-solid fa-circle-exclamation me-1"></i>Status SK Kedaluwarsa</span>
        <h2 class="text-white fw-bold mb-1">Ormas SK Merah</h2>
        <p class="text-muted small mb-0">Daftar Organisasi Kemasyarakatan yang masa berlaku Surat Keterangan (SK) kepengurusannya telah habis • Hari ini: <b><?= date('d M Y') ?></b></p>
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

<!-- Warning Alert Box -->
<div class="warning-alert animate-fade-up">
    <div class="warning-icon">
        <i class="fa-solid fa-triangle-exclamation animate-pulse"></i>
    </div>
    <div>
        <h5 class="text-white fw-bold mb-1">Pemberitahuan Pembinaan Ormas</h5>
        <p class="text-muted small mb-0">Organisasi di bawah ini terdeteksi memiliki SK Kepengurusan yang telah kedaluwarsa menurut database. Pimpinan merekomendasikan unit kerja terkait (Poldagri & Ormas) untuk segera melakukan koordinasi dan pembinaan agar pengurus melakukan pembaruan berkas administrasi layanan.</p>
    </div>
</div>

<!-- Table Card -->
<div class="glass-card p-4 animate-fade-up delay-1">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h4 class="text-white mb-0 font-heading"><i class="fa-solid fa-building-circle-exclamation text-danger me-2"></i>Daftar Ormas SK Merah (<?= count($expiredOrmas) ?> Terdeteksi)</h4>
    </div>

    <div class="table-responsive">
        <table class="table table-custom rounded overflow-hidden">
            <thead>
                <tr>
                    <th width="5%" class="text-center">No</th>
                    <th width="35%">Nama Organisasi</th>
                    <th width="35%">Alamat & Detail Kontak</th>
                    <th width="25%" class="text-center">Tanggal Kedaluwarsa SK</th>
                </tr>
            </thead>
            <tbody>
                <?php if (empty($expiredOrmas)): ?>
                    <tr>
                        <td colspan="4" class="text-center text-muted py-5">
                            <i class="fa-solid fa-circle-check text-success fa-3x mb-3 d-block"></i>
                            <span class="fw-bold text-white d-block mb-1">Seluruh Ormas Aktif</span>
                            <span class="small text-muted">Tidak ditemukan organisasi kemasyarakatan dengan SK kepengurusan yang kedaluwarsa.</span>
                        </td>
                    </tr>
                <?php else: ?>
                    <?php $no = 1; foreach ($expiredOrmas as $o): 
                        $diff = time() - strtotime($o['tgl_sk_kedaluwarsa']);
                        $days = floor($diff / (60 * 60 * 24));
                    ?>
                        <tr class="row-expired">
                            <td class="text-center text-white"><?= $no++ ?></td>
                            <td>
                                <div class="fw-bold text-white"><?= esc($o['nama_ormas']) ?></div>
                                <span class="small text-muted">ID: <?= substr($o['id'], 0, 8) ?>...</span>
                            </td>
                            <td>
                                <div class="small text-white mb-1">
                                    <i class="fa-solid fa-location-dot text-muted me-1.5"></i><?= esc($o['alamat']) ?>
                                </div>
                                <div class="small text-muted">
                                    <i class="fa-solid fa-phone text-muted me-1.5"></i><?= esc($o['telepon']) ?> &bull; 
                                    <i class="fa-solid fa-envelope text-muted me-1.5"></i><?= esc($o['email']) ?>
                                </div>
                            </td>
                            <td class="text-center">
                                <span class="badge badge-expired px-3 py-2 d-inline-block">
                                    <i class="fa-solid fa-calendar-xmark me-1.5"></i>
                                    <?= date('d-m-Y', strtotime($o['tgl_sk_kedaluwarsa'])) ?>
                                </span>
                                <div class="small text-danger-light mt-1" style="font-size: 0.75rem;">
                                    Lewat <?= $days ?> hari
                                </div>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                <?php endif; ?>
            </tbody>
        </table>
    </div>
</div>

<?= $this->endSection() ?>
