<?= $this->extend('layouts/admin') ?>

<?= $this->section('styles') ?>
<style>
    .exec-header {
        background: linear-gradient(135deg, rgba(16, 185, 129, 0.15) 0%, rgba(59, 130, 246, 0.05) 100%);
        border: 1px solid var(--border-color);
        border-radius: 12px;
        padding: 24px;
        margin-bottom: 30px;
    }

    .chart-container {
        background: var(--card-bg);
        border: 1px solid var(--border-color);
        border-radius: 16px;
        padding: 24px;
        margin-bottom: 30px;
        transition: all 0.3s ease;
    }

    .chart-container:hover {
        border-color: var(--card-hover-border);
        box-shadow: 0 10px 30px rgba(0, 0, 0, 0.1);
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

    .progress-custom {
        height: 6px;
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
</style>
<?= $this->endSection() ?>

<?= $this->section('content') ?>

<!-- Header -->
<div class="exec-header d-flex justify-content-between align-items-center gap-3">
    <div>
        <span class="badge bg-success-subtle text-success border border-success-subtle px-3 py-1.5 rounded-pill mb-2 font-heading" style="font-weight:600;"><i class="fa-solid fa-chart-column me-1"></i>Kinerja Bidang</span>
        <h2 class="text-white fw-bold mb-1">Kinerja & SPJ Bidang</h2>
        <p class="text-muted small mb-0">Analisis perbandingan target dan realisasi fisik serta keuangan per unit kerja • Hari ini: <b><?= date('d M Y') ?></b></p>
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

<!-- Chart Section -->
<div class="row">
    <div class="col-12 animate-fade-up">
        <div class="chart-container">
            <h4 class="text-white mb-2 font-heading"><i class="fa-solid fa-chart-simple text-success me-2"></i>Grafik Perbandingan Realisasi Anggaran & Fisik</h4>
            <p class="text-muted small mb-4">Grafik batang yang memvisualisasikan realisasi keuangan dan realisasi fisik dalam bentuk persentase.</p>
            <div style="height: 350px; width: 100%; position: relative;">
                <canvas id="chartKinerjaBidang"></canvas>
            </div>
        </div>
    </div>
</div>

<!-- Table Section -->
<div class="glass-card p-4 animate-fade-up delay-1">
    <h4 class="text-white mb-3 font-heading"><i class="fa-solid fa-table-list text-success me-2"></i>Rincian Realisasi per Bidang</h4>
    <div class="table-responsive">
        <table class="table table-custom rounded overflow-hidden">
            <thead>
                <tr>
                    <th rowspan="2" valign="middle">Nama Bidang / Unit Kerja</th>
                    <th colspan="3" class="text-center">Kinerja Keuangan</th>
                    <th colspan="3" class="text-center">Kinerja Fisik</th>
                </tr>
                <tr>
                    <th width="15%" class="text-end">Target Anggaran</th>
                    <th width="15%" class="text-end">Realisasi</th>
                    <th width="10%" class="text-center">Persentase</th>
                    <th width="12%" class="text-center">Target Avg</th>
                    <th width="12%" class="text-center">Realisasi Avg</th>
                    <th width="10%" class="text-center">Persentase</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($bidangKinerja as $bk): 
                    $tKeuangan = (double) $bk['target_keuangan'];
                    $rKeuangan = (double) $bk['realisasi_keuangan'];
                    $pKeuangan = $tKeuangan > 0 ? ($rKeuangan / $tKeuangan) * 100 : 0.0;

                    $tFisik = (double) $bk['avg_target_fisik'];
                    $rFisik = (double) $bk['avg_realisasi_fisik'];
                    $pFisik = $tFisik > 0 ? ($rFisik / $tFisik) * 100 : 0.0;
                ?>
                    <tr>
                        <td>
                            <div class="fw-bold text-white"><?= esc($bk['nama_bidang']) ?></div>
                            <span class="small text-muted">Kode: <?= esc($bk['kode_bidang']) ?></span>
                        </td>
                        <td class="text-end text-white">Rp<?= number_format($tKeuangan, 0, ',', '.') ?></td>
                        <td class="text-end text-success">Rp<?= number_format($rKeuangan, 0, ',', '.') ?></td>
                        <td>
                            <div class="d-flex align-items-center justify-content-center gap-2">
                                <span class="fw-bold text-white"><?= number_format($pKeuangan, 1) ?>%</span>
                            </div>
                            <div class="progress progress-custom mt-1 mx-auto" style="width: 80px;">
                                <div class="progress-bar progress-bar-success" role="progressbar" style="width: <?= $pKeuangan ?>%"></div>
                            </div>
                        </td>
                        <td class="text-center text-white"><?= number_format($tFisik, 1) ?>%</td>
                        <td class="text-center text-primary"><?= number_format($rFisik, 1) ?>%</td>
                        <td>
                            <div class="d-flex align-items-center justify-content-center gap-2">
                                <span class="fw-bold text-white"><?= number_format($pFisik, 1) ?>%</span>
                            </div>
                            <div class="progress progress-custom mt-1 mx-auto" style="width: 80px;">
                                <div class="progress-bar progress-bar-primary" role="progressbar" style="width: <?= $pFisik ?>%"></div>
                            </div>
                        </td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    </div>
</div>

<!-- Chart.js CDN -->
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

<script>
    document.addEventListener('DOMContentLoaded', function() {
        const ctx = document.getElementById('chartKinerjaBidang').getContext('2d');
        
        // Data from PHP
        const labels = [];
        const keuanganData = [];
        const fisikData = [];

        <?php foreach ($bidangKinerja as $bk): 
            $tKeuangan = (double) $bk['target_keuangan'];
            $rKeuangan = (double) $bk['realisasi_keuangan'];
            $pKeuangan = $tKeuangan > 0 ? ($rKeuangan / $tKeuangan) * 100 : 0.0;

            $tFisik = (double) $bk['avg_target_fisik'];
            $rFisik = (double) $bk['avg_realisasi_fisik'];
            $pFisik = $tFisik > 0 ? ($rFisik / $tFisik) * 100 : 0.0;
        ?>
            labels.push('<?= esc($bk['kode_bidang']) ?>');
            keuanganData.push(<?= round($pKeuangan, 1) ?>);
            fisikData.push(<?= round($pFisik, 1) ?>);
        <?php endforeach; ?>

        new Chart(ctx, {
            type: 'bar',
            data: {
                labels: labels,
                datasets: [
                    {
                        label: 'Realisasi Keuangan (%)',
                        data: keuanganData,
                        backgroundColor: 'rgba(52, 211, 153, 0.85)',
                        borderColor: '#10b981',
                        borderWidth: 1,
                        borderRadius: 6
                    },
                    {
                        label: 'Realisasi Fisik (%)',
                        data: fisikData,
                        backgroundColor: 'rgba(99, 102, 241, 0.85)',
                        borderColor: '#6366f1',
                        borderWidth: 1,
                        borderRadius: 6
                    }
                ]
            },
            options: {
                responsive: true,
                maintainAspectRatio: false,
                scales: {
                    y: {
                        beginAtZero: true,
                        max: 100,
                        grid: {
                            color: 'rgba(255, 255, 255, 0.05)'
                        },
                        ticks: {
                            color: '#9ca3af'
                        }
                    },
                    x: {
                        grid: {
                            display: false
                        },
                        ticks: {
                            color: '#9ca3af'
                        }
                    }
                },
                plugins: {
                    legend: {
                        labels: {
                            color: '#f3f4f6',
                            font: {
                                family: 'Inter, sans-serif'
                            }
                        }
                    },
                    tooltip: {
                        backgroundColor: '#1f2937',
                        titleColor: '#ffffff',
                        bodyColor: '#e5e7eb',
                        borderColor: 'rgba(255, 255, 255, 0.1)',
                        borderWidth: 1
                    }
                }
            }
        });
    });
</script>

<?= $this->endSection() ?>
