<?= $this->extend('layouts/admin') ?>

<?= $this->section('content') ?>
<div class="container-fluid px-0">
    <!-- Header / Breadcrumbs -->
    <div class="d-flex justify-content-between align-items-center mb-4 pb-2 border-bottom" style="border-color: var(--border-color) !important;">
        <div>
            <h3 class="mb-1 font-heading" style="color: var(--text-main);"><i class="fa-solid fa-lock text-danger me-2"></i>Penguncian Periode Laporan SPJ</h3>
            <p class="small mb-0" style="color: var(--text-muted);">Kelola penguncian bulan pelaporan anggaran fisik/keuangan untuk Bidang dan PPTK.</p>
        </div>
        <nav aria-label="breadcrumb">
            <ol class="breadcrumb mb-0">
                <li class="breadcrumb-item"><a href="<?= site_url('admin') ?>" class="text-primary text-decoration-none">Dasbor</a></li>
                <li class="breadcrumb-item text-muted active" aria-current="page">Kunci SPJ</li>
            </ol>
        </nav>
    </div>

    <!-- Alert Explanation -->
    <div class="alert border p-3 mb-4" role="alert" style="border-radius: 12px; font-size: 0.92rem; background: var(--alert-info-bg, rgba(14, 165, 233, 0.1)); border-color: rgba(14, 165, 233, 0.3) !important; color: var(--text-main);">
        <div class="d-flex gap-2">
            <i class="fa-solid fa-circle-info fa-lg mt-1 text-info"></i>
            <div>
                <strong style="color: var(--text-main);">Bagaimana cara kerjanya?</strong>
                <p class="mb-0 mt-1" style="line-height: 1.5; color: var(--text-main); opacity: 0.8;">Penguncian bulan pelaporan akan mencegah staf PPTK/Bidang melakukan penginputan laporan kegiatan fisik dan realisasi keuangan baru serta melakukan modifikasi/penghapusan laporan yang sudah ada pada bulan tersebut. Fitur ini sangat penting untuk menyinkronkan pelaporan data dengan SIPD setelah verifikasi audit internal.</p>
            </div>
        </div>
    </div>

    <div class="row g-4">
        <!-- Lock Form -->
        <div class="col-lg-5">
            <div class="glass-card p-4">
                <h4 class="mb-3" style="color: var(--text-main); font-size: 1.2rem;"><i class="fa-solid fa-lock-open text-warning me-2"></i>Kunci Bulan Baru</h4>
                <p class="small mb-4" style="color: var(--text-muted);">Pilih periode tahun dan bulan yang ingin dikunci ke dalam sistem.</p>

                <form action="<?= base_url('admin/settings/spj/update') ?>" method="POST">
                    <?= csrf_field() ?>
                    <input type="hidden" name="action" value="lock">
                    
                    <div class="mb-4">
                        <label for="lock_month" class="form-label small" style="color: var(--text-muted);">Pilih Periode Bulan & Tahun *</label>
                        <input type="month" name="month" id="lock_month" class="form-control form-control-custom" required>
                    </div>

                    <button type="submit" class="btn btn-danger w-100 py-2.5"><i class="fa-solid fa-lock me-2"></i> Kunci Periode SPJ</button>
                </form>
            </div>
        </div>

        <!-- Locked Months List -->
        <div class="col-lg-7">
            <div class="glass-card p-4">
                <h4 class="mb-3" style="color: var(--text-main); font-size: 1.2rem;"><i class="fa-solid fa-list-check text-success me-2"></i>Daftar Periode SPJ Terkunci</h4>
                <p class="small mb-4" style="color: var(--text-muted);">Berikut adalah daftar bulan pelaporan SPJ yang saat ini sedang dikunci.</p>

                <?php if (empty($locked_months)): ?>
                    <div class="text-center py-5" style="color: var(--text-muted);">
                        <i class="fa-solid fa-unlock-keyhole fa-2x mb-3 text-success" style="opacity: 0.5;"></i>
                        <p class="mb-0">Tidak ada periode SPJ yang terkunci saat ini.</p>
                        <span class="small" style="color: var(--text-muted); font-size: 0.75rem;">Semua bidang dapat menginput laporan untuk seluruh periode aktif.</span>
                    </div>
                <?php else: ?>
                    <div class="d-flex flex-column gap-2" style="max-height: 400px; overflow-y: auto; padding-right: 5px;">
                        <?php foreach ($locked_months as $month): 
                            // Format month from YYYY-MM to readable Indonesian month
                            $year = substr($month, 0, 4);
                            $mVal = (int)substr($month, 5, 2);
                            $monthsIndo = [
                                1 => 'Januari', 2 => 'Februari', 3 => 'Maret', 4 => 'April',
                                5 => 'Mei', 6 => 'Juni', 7 => 'Juli', 8 => 'Agustus',
                                9 => 'September', 10 => 'Oktober', 11 => 'November', 12 => 'Desember'
                            ];
                            $monthLabel = isset($monthsIndo[$mVal]) ? $monthsIndo[$mVal] . ' ' . $year : $month;
                        ?>
                            <div class="card p-3 rounded" style="background: rgba(127, 127, 127, 0.03); border: 1px solid var(--border-color); color: var(--text-main);">
                                <div class="d-flex justify-content-between align-items-center">
                                    <div class="d-flex align-items-center gap-3">
                                        <div class="rounded-circle d-flex align-items-center justify-content-center bg-danger-subtle border border-danger-subtle text-danger" style="width: 32px; height: 32px;">
                                            <i class="fa-solid fa-lock" style="font-size: 0.85rem;"></i>
                                        </div>
                                        <div>
                                            <div class="fw-bold small" style="color: var(--text-main); font-size: 0.95rem;"><?= esc($monthLabel) ?></div>
                                            <span style="color: var(--text-muted); font-size: 0.72rem;">Format database: <?= esc($month) ?></span>
                                        </div>
                                    </div>
                                    <form action="<?= base_url('admin/settings/spj/update') ?>" method="POST" onsubmit="return confirm('Apakah Anda yakin ingin membuka kembali kunci periode SPJ <?= esc($monthLabel) ?>? Bidang/PPTK akan kembali dapat menginput dan mengubah data.');">
                                        <?= csrf_field() ?>
                                        <input type="hidden" name="action" value="unlock">
                                        <input type="hidden" name="month" value="<?= esc($month) ?>">
                                        <button type="submit" class="btn btn-sm btn-outline-success px-3 py-1.5" style="font-size: 0.8rem; border-radius: 8px;">
                                            <i class="fa-solid fa-lock-open me-1"></i> Buka Kunci
                                        </button>
                                    </form>
                                </div>
                            </div>
                        <?php endforeach; ?>
                    </div>
                <?php endif; ?>
            </div>
        </div>
    </div>
</div>
<?= $this->endSection() ?>
