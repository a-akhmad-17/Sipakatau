<?= $this->extend('layouts/admin') ?>

<?= $this->section('styles') ?>
<style>
    .welcome-card {
        background: linear-gradient(135deg, rgba(79, 70, 229, 0.1) 0%, rgba(244, 63, 94, 0.05) 100%);
        border: 1px solid var(--border-color);
        border-radius: 16px;
        padding: 28px;
        margin-bottom: 30px;
    }

    .timeline-steps {
        display: flex;
        justify-content: space-between;
        align-items: center;
        position: relative;
        margin-top: 30px;
        margin-bottom: 30px;
    }

    .timeline-steps::before {
        content: '';
        position: absolute;
        top: 20px;
        left: 0;
        right: 0;
        height: 4px;
        background: var(--border-color);
        z-index: 1;
    }

    .timeline-progress {
        position: absolute;
        top: 20px;
        left: 0;
        height: 4px;
        background: var(--primary-grad);
        z-index: 2;
        transition: width 0.5s ease-in-out;
    }

    .timeline-step {
        position: relative;
        z-index: 3;
        display: flex;
        flex-direction: column;
        align-items: center;
        width: 120px;
    }

    .timeline-icon {
        width: 44px;
        height: 44px;
        border-radius: 50%;
        background: var(--bg-color);
        border: 3px solid var(--border-color);
        display: flex;
        align-items: center;
        justify-content: center;
        color: var(--text-muted);
        font-weight: bold;
        transition: all 0.4s ease;
    }

    .timeline-step.active .timeline-icon {
        border-color: #f43f5e;
        color: #f43f5e;
        box-shadow: 0 0 12px rgba(244, 63, 94, 0.4);
    }

    .timeline-step.completed .timeline-icon {
        background: var(--primary-grad);
        border-color: #f43f5e;
        color: white;
    }

    .timeline-label {
        margin-top: 10px;
        font-size: 0.8rem;
        font-weight: 600;
        text-align: center;
        color: var(--text-muted);
    }

    .timeline-step.active .timeline-label,
    .timeline-step.completed .timeline-label {
        color: var(--text-main);
    }

    @media (max-width: 768px) {
        .timeline-steps {
            flex-direction: column;
            align-items: flex-start;
            gap: 24px;
            padding-left: 20px;
        }
        .timeline-steps::before {
            left: 40px;
            top: 0;
            bottom: 0;
            width: 4px;
            height: 100%;
        }
        .timeline-progress {
            left: 40px;
            top: 0;
            width: 4px !important;
            height: 0%;
            transition: height 0.5s ease-in-out;
        }
        .timeline-step {
            flex-direction: row;
            width: 100%;
            gap: 15px;
        }
        .timeline-label {
            margin-top: 0;
            text-align: left;
        }
    }
</style>
<?= $this->endSection() ?>

<?= $this->section('content') ?>

<!-- Welcome Greeting -->
<div class="welcome-card">
    <div class="d-flex justify-content-between align-items-center flex-wrap gap-3">
        <div>
            <h2 class="text-white fw-bold mb-1"><i class="fa-solid fa-house-chimney text-primary me-2"></i>Dasbor Ormas / Pendaftar</h2>
            <p class="text-muted small mb-0">Halo, <b><?= esc(ucfirst(session()->get('username'))) ?></b> • Selamat datang di portal layanan mandiri Kesbangpol.</p>
        </div>
        <div>
            <span class="badge bg-secondary-subtle text-white border border-secondary border-opacity-25 px-3 py-2 rounded-pill small">
                Status Akun: <b><?= esc(ucfirst(session()->get('role'))) ?></b>
            </span>
        </div>
    </div>
</div>

<?php if (empty($pendaftaranList)): ?>
    <!-- Kasus: Belum mengajukan ormas -->
    <div class="glass-card text-center py-5">
        <div class="rounded-circle bg-primary-subtle text-primary p-4 d-inline-flex align-items-center justify-content-center mb-4" style="width: 80px; height: 80px;">
            <i class="fa-solid fa-users fa-3x"></i>
        </div>
        <h4 class="text-white fw-bold mb-2">Belum Ada Pengajuan Ormas</h4>
        <p class="text-muted mx-auto mb-4" style="max-width: 500px;">
            Anda terdaftar sebagai user biasa. Daftarkan organisasi kemasyarakatan (Ormas), LSM, atau yayasan Anda secara mandiri di Kesbangpol Kabupaten Sinjai sekarang untuk mengaktifkan status Ormas dan memantau status validasi berkas secara online.
        </p>
        <a href="<?= base_url('user/pengajuan') ?>" class="btn btn-portal px-4 py-2.5">
            <i class="fa-solid fa-file-signature me-1"></i> Mulai Pengajuan Ormas Baru
        </a>
    </div>

<?php else: ?>
    <!-- Kasus: Sudah mengajukan ormas -->
    <div class="row g-4">
        <!-- Status & Timeline Track -->
        <div class="col-lg-8">
            <div class="glass-card mb-4">
                <div class="d-flex justify-content-between align-items-center mb-4 pb-2 border-bottom border-secondary border-opacity-10">
                    <h5 class="text-white mb-0"><i class="fa-solid fa-route text-primary me-2"></i>Status & Progres Pendaftaran</h5>
                    <span class="text-muted small">No. Registrasi: <b class="text-warning"><?= esc($pendaftaran['nomor_registrasi']) ?></b></span>
                </div>

                <!-- Rejection Alert Callout -->
                <?php if ($pendaftaran['status_verifikasi'] === 'Rejected'): ?>
                    <div class="alert alert-danger bg-danger-subtle border-danger-subtle text-danger p-4 rounded mb-4" style="border-radius: 12px;">
                        <div class="d-flex gap-3">
                            <i class="fa-solid fa-triangle-exclamation fa-2x mt-1"></i>
                            <div>
                                <h6 class="fw-bold mb-1">Pengajuan Berkas Ditolak / Butuh Revisi</h6>
                                <p class="small mb-3">Mohon maaf, berkas pendaftaran yang Anda ajukan belum memenuhi syarat. Anda dapat memperbaiki data dan mengunggah berkas baru melalui tombol revisi di bawah.</p>
                                <div class="p-3 bg-black bg-opacity-25 rounded border border-danger border-opacity-25">
                                    <span class="small text-muted d-block mb-1">Alasan Penolakan Resmi:</span>
                                    <b class="text-white small italic">"<?= esc($pendaftaran['alasan_ditolak']) ?>"</b>
                                </div>
                                <div class="mt-3">
                                    <a href="<?= base_url('user/pengajuan') ?>" class="btn btn-sm btn-danger text-white fw-bold"><i class="fa-solid fa-pencil me-1"></i> Revisi Berkas Pendaftaran</a>
                                </div>
                            </div>
                        </div>
                    </div>
                <?php endif; ?>

                <?php
                // Hitung state timeline berdasarkan progress
                $progress = $pendaftaran['progress_percentage'];
                $status = $pendaftaran['status_verifikasi'];
                
                $step1_class = 'completed'; // Berkas selalu terkirim/draft jika pendaftaran ada
                $step2_class = '';
                $step3_class = '';
                
                if ($status === 'Pending') {
                    $step2_class = 'active';
                } elseif ($status === 'Approved' && $progress == 75) {
                    $step1_class = 'completed';
                    $step2_class = 'completed';
                    $step3_class = 'active';
                } elseif ($status === 'Approved' && $progress == 100) {
                    $step1_class = 'completed';
                    $step2_class = 'completed';
                    $step3_class = 'completed';
                } elseif ($status === 'Rejected') {
                    $step1_class = 'active';
                }
                ?>

                <!-- Visual Timeline -->
                <div class="timeline-steps">
                    <!-- Progress line -->
                    <div class="timeline-progress" style="width: <?= ($status === 'Rejected') ? '0' : (($progress == 45) ? '33' : (($progress == 75) ? '66' : '100')) ?>%;"></div>
                    
                    <!-- Step 1: Berkas Masuk -->
                    <div class="timeline-step <?= $step1_class ?>">
                        <div class="timeline-icon">
                            <?php if ($step1_class === 'completed'): ?><i class="fa-solid fa-check"></i><?php else: ?>1<?php endif; ?>
                        </div>
                        <div class="timeline-label">Verifikasi Berkas<br><span class="text-muted font-normal small">(Admin Kesbangpol)</span></div>
                    </div>
                    
                    <!-- Step 2: Validasi Bidang -->
                    <div class="timeline-step <?= $step2_class ?>">
                        <div class="timeline-icon">
                            <?php if ($step2_class === 'completed'): ?><i class="fa-solid fa-check"></i><?php else: ?>2<?php endif; ?>
                        </div>
                        <div class="timeline-label">Validasi Bidang<br><span class="text-muted font-normal small">(Kasubag / Kabid)</span></div>
                    </div>
                    
                    <!-- Step 3: Surat Rekomendasi Diterbitkan -->
                    <div class="timeline-step <?= $step3_class ?>">
                        <div class="timeline-icon">
                            <?php if ($step3_class === 'completed'): ?><i class="fa-solid fa-check"></i><?php else: ?>3<?php endif; ?>
                        </div>
                        <div class="timeline-label">Penerbitan Surat Rekomendasi<br><span class="text-muted font-normal small">(Selesai)</span></div>
                    </div>
                </div>

                <div class="p-3 rounded border border-secondary border-opacity-10 bg-black bg-opacity-10 mt-4">
                    <span class="small text-muted d-block">Status Saat Ini:</span>
                    <h6 class="text-white fw-bold mb-1 mt-1">
                        <?php if ($status === 'Pending'): ?>
                            <span class="badge bg-warning-subtle text-warning"><i class="fa-solid fa-spinner fa-spin me-1"></i> Sedang Ditinjau Admin</span>
                        <?php elseif ($status === 'Approved' && $progress < 100): ?>
                            <span class="badge bg-primary-subtle text-primary"><i class="fa-solid fa-check-double me-1"></i> Berkas Valid, Menunggu Penerbitan Surat</span>
                        <?php elseif ($status === 'Approved' && $progress == 100): ?>
                            <span class="badge bg-success-subtle text-success"><i class="fa-solid fa-circle-check me-1"></i> Surat Rekomendasi Diterbitkan (Selesai)</span>
                        <?php elseif ($status === 'Rejected'): ?>
                            <span class="badge bg-danger-subtle text-danger"><i class="fa-solid fa-circle-xmark me-1"></i> Butuh Perbaikan (Ditolak)</span>
                        <?php endif; ?>
                    </h6>
                    <p class="small text-muted mb-0 mt-2">
                        <?php if ($status === 'Pending'): ?>
                            Dokumen pendaftaran Ormas Anda telah berhasil diunggah dan sedang dalam proses pencocokan dokumen fisik oleh tim verifikator kami.
                        <?php elseif ($status === 'Approved' && $progress < 100): ?>
                            Selamat! Berkas pendaftaran Anda dinyatakan lengkap dan valid. Saat ini sedang diproses untuk penerbitan Surat Rekomendasi/Keterangan resmi.
                        <?php elseif ($status === 'Approved' && $progress == 100): ?>
                            Proses pendaftaran selesai. Surat Rekomendasi/Keterangan resmi ormas Anda telah diterbitkan secara sah oleh Kesbangpol Kabupaten Sinjai.
                        <?php elseif ($status === 'Rejected'): ?>
                            Pendaftaran Anda ditolak. Klik tombol revisi untuk menyesuaikan kembali dokumen sesuai petunjuk verifikator.
                        <?php endif; ?>
                    </p>

                    <?php if ($status === 'Approved' && $progress == 100 && !empty($pendaftaran['pdf_tte_path'])): ?>
                        <div class="mt-3 pt-3 border-top border-secondary border-opacity-15">
                            <a href="<?= base_url('uploads/rekomendasi_ormas/' . $pendaftaran['pdf_tte_path']) ?>" target="_blank" class="btn btn-success w-100 py-2.5 text-white fw-bold text-decoration-none d-block text-center">
                                <i class="fa-solid fa-file-arrow-down me-2"></i> Unduh Surat Rekomendasi Resmi
                            </a>
                        </div>
                    <?php endif; ?>
                </div>
            </div>
        </div>

        <!-- Ormas Profile Info Card -->
        <div class="col-lg-4">
            <div class="glass-card h-100">
                <div class="text-center mb-4">
                    <div class="bg-secondary rounded-circle p-1 d-inline-flex align-items-center justify-content-center mb-3" style="width: 90px; height: 90px; overflow: hidden; border: 3px solid rgba(255,255,255,0.08);">
                        <?php 
                        $logoPath = 'uploads/ormas/' . $pendaftaran['file_logo'];
                        $isImage = (!empty($pendaftaran['file_logo']) && preg_match('/\.(webp|jpg|jpeg|png|gif)$/i', $pendaftaran['file_logo']) && file_exists(ROOTPATH . 'public/' . $logoPath));
                        if ($isImage): ?>
                            <img src="<?= base_url($logoPath) ?>" style="width: 100%; height: 100%; object-fit: cover;">
                        <?php else: ?>
                            <i class="fa-solid fa-users fa-3x text-white"></i>
                        <?php endif; ?>
                    </div>
                    <h5 class="text-white fw-bold mb-1"><?= esc($pendaftaran['nama_ormas']) ?></h5>
                    <span class="text-muted small">Registrasi Kesbangpol</span>
                </div>

                <div class="d-flex flex-column gap-3 small border-top border-secondary border-opacity-10 pt-3">
                    <div>
                        <span class="text-muted d-block">Alamat Sekretariat:</span>
                        <b class="text-white"><?= esc($pendaftaran['alamat']) ?></b>
                    </div>
                    <div>
                        <span class="text-muted d-block">Kontak Email:</span>
                        <b class="text-white"><?= esc($pendaftaran['email'] ?: '-') ?></b>
                    </div>
                    <div>
                        <span class="text-muted d-block">Nomor Telepon:</span>
                        <b class="text-white"><?= esc($pendaftaran['telepon'] ?: '-') ?></b>
                    </div>
                    <div>
                        <span class="text-muted d-block">SK Kepengurusan:</span>
                        <b class="text-white">
                            <?= !empty($pendaftaran['tgl_sk_kepengurusan']) ? date('d M Y', strtotime($pendaftaran['tgl_sk_kepengurusan'])) : '-' ?>
                            s/d
                            <?= !empty($pendaftaran['tgl_sk_kedaluwarsa']) ? date('d M Y', strtotime($pendaftaran['tgl_sk_kedaluwarsa'])) : '-' ?>
                        </b>
                    </div>
                    <div>
                        <span class="text-muted d-block">Berkas diunggah:</span>
                        <?php if (!empty($pendaftaran['file_berkas'])): ?>
                            <a href="<?= base_url('uploads/ormas/' . $pendaftaran['file_berkas']) ?>" target="_blank" class="btn btn-sm btn-outline-info w-100 py-1.5 mt-1">
                                <i class="fa-solid fa-file-pdf me-1"></i> Buka Berkas Terkirim
                            </a>
                        <?php else: ?>
                            <span class="text-muted">Tidak ada berkas diunggah</span>
                        <?php endif; ?>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Card 3: Riwayat Pengajuan Ormas Anda -->
    <div class="row g-4 mt-4">
        <div class="col-12">
            <div class="glass-card">
                <div class="d-flex justify-content-between align-items-center mb-4 flex-wrap gap-2">
                    <div>
                        <h5 class="text-white mb-1"><i class="fa-solid fa-clock-rotate-left text-primary me-2"></i>Riwayat Pengajuan Ormas Anda</h5>
                        <p class="text-muted small mb-0">Kelola dan pantau semua pengajuan organisasi yang telah Anda kirimkan.</p>
                    </div>
                    <a href="<?= base_url('user/pengajuan') ?>" class="btn btn-portal px-3 py-2 small">
                        <i class="fa-solid fa-plus me-1"></i> Ajukan Ormas Baru
                    </a>
                </div>

                <div class="table-responsive">
                    <table class="table table-custom rounded overflow-hidden">
                        <thead>
                            <tr>
                                <th class="text-center" style="width: 15%;">No. Registrasi</th>
                                <th style="width: 25%;">Nama Ormas</th>
                                <th style="width: 20%;">Tanggal Pengajuan</th>
                                <th class="text-center" style="width: 15%;">Status</th>
                                <th class="text-center" style="width: 25%;">Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php foreach ($pendaftaranList as $item): 
                                $statusBadge = 'bg-warning-subtle text-warning border-warning-subtle';
                                if ($item['status_verifikasi'] === 'Approved') {
                                    $statusBadge = 'bg-success-subtle text-success border-success-subtle';
                                } elseif ($item['status_verifikasi'] === 'Rejected') {
                                    $statusBadge = 'bg-danger-subtle text-danger border-danger-subtle';
                                } elseif ($item['status_verifikasi'] === 'Draft') {
                                    $statusBadge = 'bg-secondary-subtle text-secondary border-secondary-subtle';
                                }
                                
                                $isActive = ($pendaftaran && $pendaftaran['id'] === $item['id']);
                                ?>
                                <tr style="<?= $isActive ? 'background: rgba(244, 63, 94, 0.05); border-left: 3px solid #f43f5e;' : '' ?>">
                                    <td class="text-center fw-semibold text-warning"><?= esc($item['nomor_registrasi']) ?></td>
                                    <td class="text-white fw-bold">
                                        <?= esc($item['nama_ormas']) ?>
                                        <?php if ($isActive): ?>
                                            <span class="badge bg-primary text-white ms-2" style="font-size: 0.65rem;">Sedang Dilihat</span>
                                        <?php endif; ?>
                                    </td>
                                    <td><?= date('d M Y H:i', strtotime($item['created_at'])) ?></td>
                                    <td class="text-center">
                                        <span class="badge <?= $statusBadge ?> px-2.5 py-1.5 rounded-pill border small">
                                            <?= esc(ucfirst($item['status_verifikasi'])) ?>
                                        </span>
                                    </td>
                                    <td class="text-center">
                                        <div class="d-flex justify-content-center gap-1 flex-wrap">
                                            <?php if (!$isActive): ?>
                                                <a href="<?= base_url('user?id=' . $item['id']) ?>" class="btn btn-sm btn-outline-primary py-1 px-2.5" title="Tampilkan Progres">
                                                    <i class="fa-solid fa-eye me-1"></i> Tampilkan
                                                </a>
                                            <?php endif; ?>
                                            
                                            <?php if (in_array($item['status_verifikasi'], ['Draft', 'Rejected'])): ?>
                                                <a href="<?= base_url('user/pengajuan?id=' . $item['id']) ?>" class="btn btn-sm btn-outline-warning py-1 px-2.5" title="Revisi Berkas">
                                                    <i class="fa-solid fa-pencil me-1"></i> Revisi
                                                </a>
                                            <?php endif; ?>
                                            
                                            <?php if ($item['status_verifikasi'] === 'Approved' && $item['progress_percentage'] == 100 && !empty($item['pdf_tte_path'])): ?>
                                                <a href="<?= base_url('uploads/rekomendasi_ormas/' . $item['pdf_tte_path']) ?>" target="_blank" class="btn btn-sm btn-outline-success py-1 px-2.5 text-decoration-none" title="Unduh Surat Rekomendasi Resmi">
                                                    <i class="fa-solid fa-download me-1"></i> Unduh
                                                </a>
                                            <?php endif; ?>
                                            
                                            <?php if ($item['delete_requested'] == 1): ?>
                                                <span class="badge bg-danger-subtle text-danger border border-danger-subtle px-2 py-1.5 rounded small">
                                                    <i class="fa-solid fa-clock me-1"></i> Menunggu Hapus
                                                </span>
                                            <?php else: ?>
                                                <form action="<?= base_url('user/pengajuan/minta-hapus/' . $item['id']) ?>" method="POST" class="d-inline" onsubmit="return confirm('Apakah Anda yakin ingin mengajukan permohonan penghapusan Ormas ini?')">
                                                    <?= csrf_field() ?>
                                                    <button type="submit" class="btn btn-sm btn-outline-danger py-1 px-2.5" title="Minta Hapus Ormas">
                                                        <i class="fa-solid fa-trash-can me-1"></i> Hapus
                                                    </button>
                                                </form>
                                            <?php endif; ?>
                                        </div>
                                    </td>
                                </tr>
                            <?php endforeach; ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
<?php endif; ?>

<?= $this->endSection() ?>

<?= $this->section('scripts') ?>
<script>
    // Responsive timeline adjustments if needed
</script>
<?= $this->endSection() ?>
