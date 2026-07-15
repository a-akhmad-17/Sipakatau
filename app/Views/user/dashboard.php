<?php
$requirementsLokal = [
    ["name" => "Surat Permohonan", "desc" => "Surat Permohonan ditujukan kepada Menteri (Cq. Kaban Kesbangpol)", "tte" => true, "template" => "https://drive.google.com/uc?export=download&id=1XqCYdQYp87AXN4RGMvJqJKslvA05nRNR"],
    ["name" => "AD & ART", "desc" => "Anggaran Dasar (AD) & Anggaran Rumah Tangga (ART)", "tte" => true, "template" => ""],
    ["name" => "Akta Notaris", "desc" => "Akta Pendirian Notaris (memuat Nama, Lambang, Asas, Tujuan, Pengurus, Hak, Keuangan, dll.)", "tte" => true, "template" => ""],
    ["name" => "Surat Pernyataan Keabsahan", "desc" => "Surat Pernyataan Keabsahan Dokumen (Meterai Rp 10.000)", "tte" => true, "template" => "https://drive.google.com/uc?export=download&id=1XqCYdQYp87AXN4RGMvJqJKslvA05nRNR"],
    ["name" => "Program & Struktur Kerja", "desc" => "Program Kerja Organisasi & Struktur Organisasi Resmi", "tte" => true, "template" => ""],
    ["name" => "Domisili Kantor", "desc" => "Surat Keterangan Domisili Kantor Sekretariat", "tte" => true, "template" => ""],
    ["name" => "NPWP Organisasi", "desc" => "NPWP atas nama Organisasi", "tte" => false, "template" => ""],
    ["name" => "Formulir Isian Data Ormas", "desc" => "Formulir Isian Data Ormas (ditandatangani Ketua & Sekretaris)", "tte" => true, "template" => "https://drive.google.com/uc?export=download&id=1XqCYdQYp87AXN4RGMvJqJKslvA05nRNR"],
    ["name" => "Rekomendasi Kementerian", "desc" => "Surat Rekomendasi Kementerian Agama (Ormas Agama) / Kebudayaan", "tte" => true, "template" => ""],
    ["name" => "Biodata & KTP Pengurus", "desc" => "Biodata & KTP Pengurus (Ketua, Sekretaris, Bendahara)", "tte" => false, "template" => "", "isPengurus" => true],
    ["name" => "Pasfoto Pengurus", "desc" => "Pasfoto Pengurus 4x6 cm 2 Lembar (Latar Merah)", "tte" => false, "template" => "", "isPengurus" => true],
    ["name" => "SK & Foto Sekretariat", "desc" => "SK Pengurus & Foto Sekretariat (Tampak depan menampilkan Papan Nama)", "tte" => false, "template" => ""],
    ["name" => "Kontrak/Izin Pakai Gedung", "desc" => "Surat Perjanjian Kontrak/Izin Pakai Gedung dari Pemilik Gedung", "tte" => true, "template" => ""],
    ["name" => "Rekening & Logo Organisasi", "desc" => "Nomor Rekening Organisasi & File Logo Organisasi", "tte" => false, "template" => ""]
];

$requirementsBerjenjang = [
    ["name" => "Surat Permohonan", "desc" => "Surat Permohonan ditujukan kepada Kepala Badan Kesbangpol Kab. Sinjai", "tte" => true, "template" => "https://drive.google.com/uc?export=download&id=1UX2CJCfXpWZUix7o-j3jY9cld63dX7KS"],
    ["name" => "Surat Pernyataan Resmi", "desc" => "Surat Pernyataan Resmi (Memuat 6 poin pernyataan, Meterai Rp 10.000)", "tte" => true, "template" => "https://drive.google.com/uc?export=download&id=1UX2CJCfXpWZUix7o-j3jY9cld63dX7KS"],
    ["name" => "SK Kemenkumham", "desc" => "Surat Keputusan (SK) Kemenkumham RI", "tte" => true, "template" => ""],
    ["name" => "Surat Keterangan Domisili", "desc" => "Surat Keterangan Domisili (Alamat domisili kop surat & sekretariat)", "tte" => true, "template" => ""],
    ["name" => "Formulir Isian Data Ormas", "desc" => "Formulir Isian Data Ormas (ditandatangani Ketua & Sekretaris)", "tte" => true, "template" => "https://drive.google.com/uc?export=download&id=1UX2CJCfXpWZUix7o-j3jY9cld63dX7KS"],
    ["name" => "Pasfoto Pengurus", "desc" => "Pasfoto Pengurus ukuran 4x6 cm sebanyak 2 lembar", "tte" => false, "template" => "", "isPengurus" => true],
    ["name" => "Fotokopi KTP Pengurus", "desc" => "Fotokopi KTP Pengurus (Ketua, Sekretaris, Bendahara)", "tte" => false, "template" => "", "isPengurus" => true],
    ["name" => "Surat Keputusan (SK) Pengurus", "desc" => "Surat Keputusan (SK) Pengurus Organisasi", "tte" => false, "template" => ""],
    ["name" => "Foto Sekretariat", "desc" => "Foto Sekretariat (Tampak depan menampilkan Papan Nama resmi)", "tte" => false, "template" => ""],
    ["name" => "Dokumen Pendukung Tambahan", "desc" => "Dokumen pendukung legalitas tambahan lainnya (ZIP/PDF)", "tte" => false, "template" => ""]
];
?>
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

<!-- ===== LAYANAN CEPAT ===== -->
<div class="row g-3 mb-4">
    <div class="col-md-4">
        <div class="glass-card p-3 d-flex align-items-center gap-3 hotspot-item h-100" style="border-left: 4px solid var(--bs-primary) !important; cursor: pointer; transition: all 0.2s;" onclick="window.location.href='<?= base_url('user/pengajuan') ?>'">
            <div class="rounded bg-primary-subtle text-primary p-2.5 d-flex align-items-center justify-content-center" style="width: 48px; height: 48px;">
                <i class="fa-solid fa-file-signature fa-lg"></i>
            </div>
            <div>
                <h6 class="text-white fw-bold mb-0.5" style="font-size: 0.9rem;">Pendaftaran Ormas</h6>
                <p class="text-muted small mb-0" style="font-size: 0.75rem;">Ajukan keberadaan Ormas Baru</p>
            </div>
        </div>
    </div>
    <div class="col-md-4">
        <div class="glass-card p-3 d-flex align-items-center gap-3 hotspot-item h-100" style="border-left: 4px solid var(--bs-success) !important; cursor: pointer; transition: all 0.2s;" onclick="window.location.href='<?= base_url('user/rekomendasi/baru') ?>'">
            <div class="rounded bg-success-subtle text-success p-2.5 d-flex align-items-center justify-content-center" style="width: 48px; height: 48px;">
                <i class="fa-solid fa-calendar-check fa-lg"></i>
            </div>
            <div>
                <h6 class="text-white fw-bold mb-0.5" style="font-size: 0.9rem;">Rekomendasi Kegiatan</h6>
                <p class="text-muted small mb-0" style="font-size: 0.75rem;">Ajukan rekomendasi kegiatan Ormas</p>
            </div>
        </div>
    </div>
    <div class="col-md-4">
        <div class="glass-card p-3 d-flex align-items-center gap-3 hotspot-item h-100" style="border-left: 4px solid var(--bs-danger) !important; cursor: pointer; transition: all 0.2s;" onclick="window.location.href='<?= base_url('user/pengaduan/baru') ?>'">
            <div class="rounded bg-danger-subtle text-danger p-2.5 d-flex align-items-center justify-content-center" style="width: 48px; height: 48px;">
                <i class="fa-solid fa-bullhorn fa-lg"></i>
            </div>
            <div>
                <h6 class="text-white fw-bold mb-0.5" style="font-size: 0.9rem;">Portal Pengaduan</h6>
                <p class="text-muted small mb-0" style="font-size: 0.75rem;">Laporkan aduan / konflik sosial</p>
            </div>
        </div>
    </div>
</div>

<!-- ===== DOKUMEN PERSYARATAN & PANDUAN ORMAS ===== -->
<div class="glass-card mb-4 p-4 animate-fade-in">
    <div class="d-flex justify-content-between align-items-center mb-3 flex-wrap gap-2 pb-2 border-bottom" style="border-color: rgba(255,255,255,.05) !important;">
        <h5 class="text-white mb-0"><i class="fa-solid fa-list-check text-warning me-2"></i>Panduan & Dokumen Persyaratan Pendaftaran Ormas</h5>
        <div class="d-flex gap-2">
            <a href="https://drive.google.com/uc?export=download&id=1XqCYdQYp87AXN4RGMvJqJKslvA05nRNR" class="btn btn-sm btn-outline-warning text-white py-1.5 px-3" style="font-size:0.78rem; border-radius:8px;">
                <i class="fa-solid fa-file-word me-1.5"></i>Format Ormas Lokal (.docx)
            </a>
            <a href="https://drive.google.com/uc?export=download&id=1UX2CJCfXpWZUix7o-j3jY9cld63dX7KS" class="btn btn-sm btn-outline-warning text-white py-1.5 px-3" style="font-size:0.78rem; border-radius:8px;">
                <i class="fa-solid fa-file-word me-1.5"></i>Format Ormas Berjenjang (.docx)
            </a>
        </div>
    </div>
    <div class="row g-3">
        <div class="col-md-6">
            <h6 class="text-white small mb-2 fw-bold"><i class="fa-solid fa-house-user text-primary me-2"></i>Persyaratan Ormas Lokal:</h6>
            <div class="text-muted small" style="font-size: 11px; line-height: 1.6; max-height: 250px; overflow-y: auto;">
                1. Surat Permohonan ditujukan kepada Menteri (Cq. Kaban Kesbangpol)<br>
                2. Anggaran Dasar (AD) & Anggaran Rumah Tangga (ART)<br>
                3. Akta Pendirian Notaris memuat Anggaran Dasar dll.<br>
                4. Surat Pernyataan Keabsahan Dokumen (Meterai Rp 10.000)<br>
                5. Program Kerja Organisasi & Struktur Organisasi Resmi<br>
                6. Surat Keterangan Domisili Kantor Sekretariat<br>
                7. NPWP atas nama Organisasi<br>
                8. Formulir Isian Data Ormas (Ketua & Sekretaris)<br>
                9. Surat Rekomendasi Kementerian Agama / Kebudayaan<br>
                10. Biodata & KTP Pengurus (Ketua, Sekretaris, Bendahara)<br>
                11. Pasfoto Pengurus 4x6 cm 2 Lembar (Latar Merah)<br>
                12. SK Pengurus & Foto Sekretariat (Papan Nama)<br>
                13. Surat Perjanjian Kontrak/Izin Pakai Gedung Sekretariat<br>
                14. Nomor Rekening Organisasi & File Logo Organisasi
            </div>
        </div>
        <div class="col-md-6">
            <h6 class="text-white small mb-2 fw-bold"><i class="fa-solid fa-network-wired text-primary me-2"></i>Persyaratan Ormas Berjenjang:</h6>
            <div class="text-muted small" style="font-size: 12px; line-height: 1.6;">
                1. Surat Permohonan ditujukan kepada Kepala Badan Kesbangpol Kab. Sinjai<br>
                2. Surat Pernyataan Resmi (Memuat 6 poin pernyataan, Meterai Rp 10.000)<br>
                3. Surat Keputusan (SK) Kemenkumham RI<br>
                4. Surat Keterangan Domisili Organisasi<br>
                5. Formulir Isian Data Ormas (ditandatangani Ketua & Sekretaris)<br>
                6. Pasfoto Pengurus ukuran 4x6 cm (Ketua, Sekretaris, Bendahara)<br>
                7. Fotokopi KTP Pengurus (Ketua, Sekretaris, Bendahara)<br>
                8. Surat Keputusan (SK) Pengurus Organisasi<br>
                9. Foto Sekretariat (Tampak depan menampilkan Papan Nama resmi)<br>
                10. Dokumen Pendukung Tambahan (ZIP/PDF)
            </div>
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
    <?php
    $filesList = [];
    if (!empty($pendaftaran['file_berkas'])) {
        $filesList = json_decode($pendaftaran['file_berkas'], true) ?: [];
    }
    $tipe = $pendaftaran['tipe_ormas'] ?? 'Lokal';

    $activeReqs = ($tipe === 'Lokal') ? $requirementsLokal : $requirementsBerjenjang;
    $progress = $pendaftaran['progress_percentage'];
    $status = $pendaftaran['status_verifikasi'];
    
    $step1_class = 'completed'; // Berkas selalu terkirim/draft jika pendaftaran ada
    $step2_class = '';
    $step3_class = '';
    $step4_class = '';
    
    if ($status === 'Pending') {
        $step1_class = 'active';
    } elseif ($status === 'Approved' && $progress == 50) {
        $step1_class = 'completed';
        $step2_class = 'active';
    } elseif ($status === 'Approved' && $progress == 75) {
        $step1_class = 'completed';
        $step2_class = 'completed';
        $step3_class = 'active';
    } elseif ($status === 'Approved' && $progress == 100) {
        $step1_class = 'completed';
        $step2_class = 'completed';
        $step3_class = 'completed';
        $step4_class = 'completed';
    } elseif ($status === 'Rejected') {
        $step1_class = 'active';
    }
    ?>

    <div class="row g-4">
        <!-- Card 1: Informasi Berkas (Blue Header) -->
        <div class="col-md-6">
            <div class="card border-0 mb-4 h-100 animate-fade-in" style="background: rgba(255, 255, 255, 0.02); border: 1px solid var(--border-color) !important; border-radius: 12px; overflow: hidden;">
                <div class="card-header py-3 px-4" style="background: #0d6efd; border-bottom: 1px solid var(--border-color);">
                    <h5 class="mb-0 text-white fw-bold font-heading" style="font-size: 1.05rem;"><i class="fa-solid fa-folder me-2"></i>Informasi Berkas</h5>
                </div>
                <div class="card-body py-4 text-white">
                    <div class="d-flex align-items-center mb-4">
                        <div class="bg-secondary rounded-circle p-1 d-inline-flex align-items-center justify-content-center me-3" style="width: 70px; height: 70px; overflow: hidden; border: 3px solid rgba(255,255,255,0.08);">
                            <?php 
                            $logoPath = 'uploads/ormas/' . $pendaftaran['file_logo'];
                            $isImage = (!empty($pendaftaran['file_logo']) && preg_match('/\.(webp|jpg|jpeg|png|gif)$/i', $pendaftaran['file_logo']) && file_exists(ROOTPATH . 'public/' . $logoPath));
                            if ($isImage): ?>
                                <img src="<?= base_url($logoPath) ?>" style="width: 100%; height: 100%; object-fit: cover;">
                            <?php else: ?>
                                <i class="fa-solid fa-users fa-2x text-white"></i>
                            <?php endif; ?>
                        </div>
                        <div>
                            <h5 class="fw-bold mb-0 text-warning"><?= esc($pendaftaran['nama_ormas']) ?></h5>
                            <span class="text-muted small">Registrasi Ormas (<?= ($tipe === 'Lokal') ? 'Lokal' : 'Berjenjang/Nasional' ?>)</span>
                        </div>
                    </div>

                    <table class="table table-borderless text-white small mb-0">
                        <tbody>
                            <tr>
                                <th class="text-muted ps-0 py-1.5" style="width: 35%;">Alamat Sekretariat</th>
                                <td class="py-1.5">: <?= esc($pendaftaran['alamat']) ?></td>
                            </tr>
                            <tr>
                                <th class="text-muted ps-0 py-1.5">Kontak Email</th>
                                <td class="py-1.5">: <?= esc($pendaftaran['email'] ?: '-') ?></td>
                            </tr>
                            <tr>
                                <th class="text-muted ps-0 py-1.5">Nomor Telepon</th>
                                <td class="py-1.5">: <?= esc($pendaftaran['telepon'] ?: '-') ?></td>
                            </tr>
                            <tr>
                                <th class="text-muted ps-0 py-1.5">SK Kepengurusan</th>
                                <td class="py-1.5">: 
                                    <?= !empty($pendaftaran['tgl_sk_kepengurusan']) ? date('d F Y', strtotime($pendaftaran['tgl_sk_kepengurusan'])) : '-' ?>
                                    s/d
                                    <?= !empty($pendaftaran['tgl_sk_kedaluwarsa']) ? date('d F Y', strtotime($pendaftaran['tgl_sk_kedaluwarsa'])) : '-' ?>
                                </td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>

        <!-- Card 2: Status & Timeline (Teal Header) -->
        <div class="col-md-6">
            <div class="card border-0 mb-4 h-100 animate-fade-in" style="background: rgba(255, 255, 255, 0.02); border: 1px solid var(--border-color) !important; border-radius: 12px; overflow: hidden;">
                <div class="card-header py-3 px-4" style="background: #14b8a6; border-bottom: 1px solid var(--border-color);">
                    <h5 class="mb-0 text-white fw-bold font-heading" style="font-size: 1.05rem;"><i class="fa-solid fa-timeline me-2"></i>Status & Timeline</h5>
                </div>
                <div class="card-body py-4 text-white">
                    <table class="table table-borderless text-white small mb-3">
                        <tbody>
                            <tr>
                                <th class="text-muted ps-0 py-1" style="width: 35%;">Status Saat Ini</th>
                                <td class="py-1">: 
                                    <?php if ($status === 'Pending'): ?>
                                        <span class="badge bg-warning-subtle text-warning border border-warning-subtle">PENDING</span>
                                    <?php elseif ($status === 'Approved' && $progress < 100): ?>
                                        <span class="badge bg-primary-subtle text-primary border border-primary-subtle">APPROVED / PROSES</span>
                                    <?php elseif ($status === 'Approved' && $progress == 100): ?>
                                        <span class="badge bg-success-subtle text-success border border-success-subtle">SUCCESS / SELESAI</span>
                                    <?php elseif ($status === 'Rejected'): ?>
                                        <span class="badge bg-danger-subtle text-danger border border-danger-subtle">REJECTED / REVISI</span>
                                    <?php endif; ?>
                                </td>
                            </tr>
                            <tr>
                                <th class="text-muted ps-0 py-1">Tanggal Upload</th>
                                <td class="py-1">: <?= date('d/m/Y H:i', strtotime($pendaftaran['created_at'])) ?></td>
                            </tr>
                            <tr>
                                <th class="text-muted ps-0 py-1">Lama Menunggu</th>
                                <td class="py-1">: 
                                    <?php
                                    $diff = time() - strtotime($pendaftaran['created_at']);
                                    $hours = round($diff / 3600);
                                    echo $hours . " jam";
                                    ?>
                                </td>
                            </tr>
                            <tr>
                                <th class="text-muted ps-0 py-1">Diupload Oleh</th>
                                <td class="py-1">: <?= esc(ucfirst(session()->get('username'))) ?></td>
                            </tr>
                        </tbody>
                    </table>

                    <!-- Visual Timeline inside Card -->
                    <div class="timeline-steps my-4">
                        <div class="timeline-progress" style="width: <?= ($status === 'Rejected') ? '0' : (($progress == 25) ? '0' : (($progress == 50) ? '33' : (($progress == 75) ? '66' : '100'))) ?>%;"></div>
                        <div class="timeline-step <?= $step1_class ?>">
                            <div class="timeline-icon" style="width:30px; height:30px; font-size:0.75rem;">
                                <?php if ($step1_class === 'completed'): ?><i class="fa-solid fa-check"></i><?php else: ?>1<?php endif; ?>
                            </div>
                            <div class="timeline-label" style="font-size:0.68rem; margin-top:5px; line-height:1.2;">Verifikasi Berkas</div>
                        </div>
                        <div class="timeline-step <?= ($progress >= 50) ? (($progress > 50) ? 'completed' : 'active') : '' ?>">
                            <div class="timeline-icon" style="width:30px; height:30px; font-size:0.75rem;">
                                <?php if ($progress > 50): ?><i class="fa-solid fa-check"></i><?php else: ?>2<?php endif; ?>
                            </div>
                            <div class="timeline-label" style="font-size:0.68rem; margin-top:5px; line-height:1.2;">Validasi Bidang</div>
                        </div>
                        <div class="timeline-step <?= ($progress >= 75) ? (($progress > 75) ? 'completed' : 'active') : '' ?>">
                            <div class="timeline-icon" style="width:30px; height:30px; font-size:0.75rem;">
                                <?php if ($progress > 75): ?><i class="fa-solid fa-check"></i><?php else: ?>3<?php endif; ?>
                            </div>
                            <div class="timeline-label" style="font-size:0.68rem; margin-top:5px; line-height:1.2;">Ke Kemendagri</div>
                        </div>
                        <div class="timeline-step <?= ($progress == 100) ? 'completed' : '' ?>">
                            <div class="timeline-icon" style="width:30px; height:30px; font-size:0.75rem;">
                                <?php if ($progress == 100): ?><i class="fa-solid fa-check"></i><?php else: ?>4<?php endif; ?>
                            </div>
                            <div class="timeline-label" style="font-size:0.68rem; margin-top:5px; line-height:1.2;">Selesai</div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Rejection Alert Callout -->
    <?php if ($status === 'Rejected'): ?>
        <div class="alert alert-danger bg-danger-subtle border-danger-subtle text-danger p-4 rounded my-4" style="border-radius: 12px;">
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
                        <a href="<?= base_url('user/pengajuan?id=' . $pendaftaran['id']) ?>" class="btn btn-sm btn-danger text-white fw-bold"><i class="fa-solid fa-pencil me-1"></i> Revisi Berkas Pendaftaran</a>
                    </div>
                </div>
            </div>
        </div>
    <?php endif; ?>

    <!-- Card 3: Validasi Kelengkapan Dokumen (Yellow Header) -->
    <div class="row g-4 mt-2">
        <div class="col-12">
            <div class="card border-0 mb-4 animate-fade-in" style="background: rgba(255, 255, 255, 0.02); border: 1px solid var(--border-color) !important; border-radius: 12px; overflow: hidden;">
                <div class="card-header py-3 px-4" style="background: #eab308; border-bottom: 1px solid var(--border-color);">
                    <h5 class="mb-0 text-dark fw-bold font-heading" style="font-size: 1.05rem;"><i class="fa-solid fa-clipboard-check me-2"></i>Validasi Kelengkapan Dokumen</h5>
                </div>
                <div class="table-responsive">
                    <table class="table table-custom mb-0" style="font-size: 0.85rem;">
                        <thead>
                            <tr style="background: rgba(255, 255, 255, 0.02);">
                                <th class="text-center" style="width: 4%;">#</th>
                                <th style="width: 35%;">Jenis Dokumen</th>
                                <th class="text-center" style="width: 10%;">Status</th>
                                <th class="text-center" style="width: 10%;">Tanda Tangan</th>
                                <th class="text-center" style="width: 10%;">Keterangan</th>
                                <th class="text-center" style="width: 12%;">File</th>
                                <th class="text-center" style="width: 10%;">Format</th>
                                <th class="text-center" style="width: 9%;">Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php foreach ($activeReqs as $idx => $req): 
                                $fileIdx = $idx + 1;
                                $exist = $filesList[$fileIdx] ?? null;
                                ?>
                                <tr>
                                    <td class="text-center align-middle"><?= $fileIdx ?></td>
                                    <td class="align-middle">
                                        <div class="fw-bold text-main"><?= esc($req['name']) ?></div>
                                        <div class="text-muted small" style="font-size:0.75rem;"><?= esc($req['desc']) ?></div>
                                    </td>
                                    <td class="text-center align-middle">
                                        <?php if ($exist): ?>
                                            <?php 
                                            $docStatus = $exist['status'] ?? 'pending';
                                            if ($docStatus === 'verified'): ?>
                                                <span class="badge bg-success text-white border px-2 py-1 small"><i class="fa-solid fa-circle-check me-1"></i> Terverifikasi</span>
                                            <?php elseif ($docStatus === 'rejected'): ?>
                                                <span class="badge bg-danger text-white border px-2 py-1 small"><i class="fa-solid fa-circle-xmark me-1"></i> Ditolak</span>
                                                <?php if (!empty($exist['note'])): ?>
                                                    <div class="text-danger small fw-bold mt-1" style="font-size: 0.72rem; line-height:1.2;">Ket: <?= esc($exist['note']) ?></div>
                                                <?php endif; ?>
                                            <?php else: ?>
                                                <span class="badge bg-warning-subtle text-warning border border-warning-subtle px-2 py-1 small"><i class="fa-solid fa-clock me-1"></i> Belum Diperiksa</span>
                                            <?php endif; ?>
                                        <?php else: ?>
                                            <span class="badge bg-danger-subtle text-danger border border-danger-subtle px-2 py-1 small"><i class="fa-solid fa-circle-xmark me-1"></i> Belum Ada</span>
                                        <?php endif; ?>
                                    </td>
                                    <td class="text-center align-middle">
                                        <?php if ($req['tte']): ?>
                                            <span class="badge bg-success-subtle text-success border border-success-subtle px-2 py-0.5" style="font-size: 0.72rem;"><i class="fa-solid fa-signature me-1"></i> TTE</span>
                                        <?php else: ?>
                                            <span class="badge bg-secondary-subtle text-secondary border border-secondary border-opacity-25 px-2 py-0.5" style="font-size: 0.72rem;">Non TTE</span>
                                        <?php endif; ?>
                                    </td>
                                    <td class="text-center align-middle text-muted small">
                                        <?= $exist ? esc($exist['size']) : '-' ?>
                                    </td>
                                    <td class="text-center align-middle text-truncate small" style="max-width: 150px;">
                                        <?= $exist ? esc($exist['filename']) : '-' ?>
                                    </td>
                                    <td class="text-center align-middle">
                                        <?php if (!empty($req['template'])): ?>
                                            <a href="<?= $req['template'] ?>" target="_blank" class="btn btn-sm btn-outline-warning py-1 px-2" style="font-size: 0.7rem;" title="Download Format <?= esc($req['name']) ?>">
                                                <i class="fa-solid fa-download me-1"></i> Format
                                            </a>
                                        <?php else: ?>
                                            <span class="text-muted small">-</span>
                                        <?php endif; ?>
                                    </td>
                                    <td class="text-center align-middle">
                                        <?php if ($exist): ?>
                                            <a href="<?= base_url('uploads/ormas/' . $exist['filename']) ?>" target="_blank" class="btn btn-sm btn-info text-white rounded px-2" title="Lihat/Download Berkas">
                                                <i class="fa-solid fa-circle-info"></i>
                                            </a>
                                        <?php else: ?>
                                            -
                                        <?php endif; ?>
                                    </td>
                                </tr>
                            <?php endforeach; ?>
                        </tbody>
                    </table>
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
                                             <button type="button" class="btn btn-sm btn-info text-white py-1 px-2.5 btn-detail-ormas" 
                                                     data-id="<?= $item['id'] ?>"
                                                     data-registrasi="<?= esc($item['nomor_registrasi']) ?>"
                                                     data-nama="<?= esc($item['nama_ormas']) ?>"
                                                     data-alamat="<?= esc($item['alamat']) ?>"
                                                     data-email="<?= esc($item['email']) ?>"
                                                     data-telepon="<?= esc($item['telepon']) ?>"
                                                     data-status="<?= esc($item['status_verifikasi']) ?>"
                                                     data-progress="<?= esc($item['progress_percentage']) ?>"
                                                     data-file="<?= esc($item['file_berkas'] ?? '') ?>" 
                                                     data-tipe-ormas="<?= esc($item['tipe_ormas'] ?? 'Lokal') ?>"
                                                     data-sk-kepengurusan="<?= !empty($item['tgl_sk_kepengurusan']) ? date('d F Y', strtotime($item['tgl_sk_kepengurusan'])) : '-' ?>" 
                                                     data-sk-kedaluwarsa="<?= !empty($item['tgl_sk_kedaluwarsa']) ? date('d F Y', strtotime($item['tgl_sk_kedaluwarsa'])) : '-' ?>"
                                                     data-tanggal="<?= date('d F Y H:i:s', strtotime($item['created_at'])) ?>">
                                                 <i class="fa-solid fa-list-check me-1"></i> Detail
                                             </button>
                                            <?php if (!$isActive): ?>
                                                <a href="<?= base_url('user/pengajuan?id=' . $item['id']) ?>" class="btn btn-sm btn-outline-primary py-1 px-2.5" title="Tampilkan Progres">
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

<!-- Modal Detail Progress Ormas -->
<div class="modal fade" id="modalDetailProgressOrmas" tabindex="-1" aria-labelledby="modalDetailProgressOrmasLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg modal-dialog-centered">
        <div class="modal-content" style="background: var(--card-bg) !important; border: 1px solid var(--border-color) !important; border-radius: 16px; overflow: hidden; backdrop-filter: blur(20px); color: var(--text-main) !important;">
            <!-- Modal Header -->
            <div class="modal-header border-bottom py-3.5 px-4" style="border-color: var(--border-color) !important;">
                <div class="d-flex align-items-center gap-3">
                    <div class="rounded-circle bg-primary-subtle text-primary p-2.5 d-flex align-items-center justify-content-center" style="width: 48px; height: 48px;">
                        <i class="fa-solid fa-route fa-lg"></i>
                    </div>
                    <div>
                        <h5 class="modal-title fw-bold font-heading mb-0.5" id="modalDetailProgressOrmasLabel" style="color: var(--text-main) !important;">Detail Pelacakan Progres</h5>
                        <span class="small text-muted" id="m-ormas-registrasi">Reg: -</span>
                    </div>
                </div>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <!-- Modal Body -->
            <div class="modal-body p-4" style="max-height: 75vh; overflow-y: auto;">
                <!-- General Info Table -->
                <div class="table-responsive mb-4">
                    <table class="table table-custom mb-0" style="font-size: 0.85rem; color: var(--text-main) !important;">
                        <tbody>
                            <tr>
                                <th style="width: 30%; background: rgba(255,255,255,0.02);" class="text-muted">Nama Ormas / LSM</th>
                                <td id="m-ormas-nama" class="fw-bold text-warning">-</td>
                            </tr>
                            <tr>
                                <th style="background: rgba(255,255,255,0.02);" class="text-muted">Alamat Kantor</th>
                                <td id="m-ormas-alamat">-</td>
                            </tr>
                            <tr>
                                <th style="background: rgba(255,255,255,0.02);" class="text-muted">Tipe Ormas</th>
                                <td id="m-ormas-tipe">-</td>
                            </tr>
                            <tr>
                                <th style="background: rgba(255,255,255,0.02);" class="text-muted">Status Ajuan</th>
                                <td id="m-ormas-status">-</td>
                            </tr>
                            <tr>
                                <th style="background: rgba(255,255,255,0.02);" class="text-muted">Progres Selesai</th>
                                <td id="m-ormas-progress" class="text-warning fw-bold">-</td>
                            </tr>
                        </tbody>
                    </table>
                </div>

                <!-- Progress Tracker Timeline -->
                <div class="mb-4 p-4 rounded" style="background: rgba(255, 255, 255, 0.02); border: 1px solid var(--border-color); border-radius: 12px;">
                    <h6 class="small fw-bold mb-4" style="color: var(--text-main) !important;"><i class="fa-solid fa-spinner fa-spin text-warning me-2"></i>Alur Proses Verifikasi</h6>
                    <div class="d-flex justify-content-between align-items-center flex-wrap gap-3" id="m-ormas-timeline-container">
                        <!-- Populated dynamically via JS -->
                    </div>
                </div>

                <!-- Document Checklist Table -->
                <div>
                    <h6 class="small fw-bold mb-3" style="color: var(--text-main) !important;"><i class="fa-solid fa-paperclip text-success me-2"></i>Berkas Persyaratan yang Telah Diunggah</h6>
                    <div class="table-responsive">
                        <table class="table table-custom mb-0" style="font-size: 0.82rem; color: var(--text-main) !important;">
                            <thead>
                                <tr style="background: rgba(255, 255, 255, 0.02);">
                                    <th class="text-center" style="width: 5%;">#</th>
                                    <th style="width: 45%;">Persyaratan Berkas</th>
                                    <th class="text-center" style="width: 25%;">Status Verifikasi</th>
                                    <th class="text-center" style="width: 25%;">Aksi</th>
                                </tr>
                            </thead>
                            <tbody id="m-ormas-documents-body">
                                <!-- Populated dynamically via JS -->
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
            <!-- Modal Footer -->
            <div class="modal-footer border-top py-3 px-4" style="border-color: var(--border-color) !important;">
                <button type="button" class="btn btn-outline-secondary" data-bs-dismiss="modal">Tutup</button>
            </div>
        </div>
    </div>
</div>

<?= $this->endSection() ?>

<?= $this->section('scripts') ?>
<script>
    // Responsive timeline adjustments if needed
    document.addEventListener('DOMContentLoaded', function() {
        const globalRequirementsLokal = <?= json_encode($requirementsLokal) ?>;
        const globalRequirementsBerjenjang = <?= json_encode($requirementsBerjenjang) ?>;

        const modalEl = document.getElementById('modalDetailProgressOrmas');
        if (modalEl) {
            const modal = new bootstrap.Modal(modalEl);
            
            document.querySelectorAll('.btn-detail-ormas').forEach(btn => {
                btn.addEventListener('click', function() {
                    const id = this.getAttribute('data-id');
                    const reg = this.getAttribute('data-registrasi');
                    const nama = this.getAttribute('data-nama');
                    const alamat = this.getAttribute('data-alamat');
                    const status = this.getAttribute('data-status');
                    const progress = parseInt(this.getAttribute('data-progress') || '0');
                    const file = this.getAttribute('data-file');
                    const tipeOrmas = this.getAttribute('data-tipe-ormas') || 'Lokal';

                    document.getElementById('m-ormas-registrasi').innerText = 'Reg: ' + reg;
                    document.getElementById('m-ormas-nama').innerText = nama;
                    document.getElementById('m-ormas-alamat').innerText = alamat;
                    document.getElementById('m-ormas-tipe').innerText = tipeOrmas;
                    document.getElementById('m-ormas-progress').innerText = progress + '% Selesai';

                    let statusBadge = 'bg-warning-subtle text-warning border-warning-subtle';
                    if (status === 'Approved') {
                        statusBadge = 'bg-success-subtle text-success border-success-subtle';
                    } else if (status === 'Rejected') {
                        statusBadge = 'bg-danger-subtle text-danger border-danger-subtle';
                    }
                    document.getElementById('m-ormas-status').innerHTML = `<span class="badge ${statusBadge} px-2.5 py-1.5 rounded-pill border small">${status}</span>`;

                    // Build Timeline
                    let step1 = 'completed', step2 = '', step3 = '', step4 = '';
                    if (status === 'Pending') {
                        step1 = 'active';
                    } else if (status === 'Approved' && progress == 50) {
                        step1 = 'completed'; step2 = 'active';
                    } else if (status === 'Approved' && progress == 75) {
                        step1 = 'completed'; step2 = 'completed'; step3 = 'active';
                    } else if (status === 'Approved' && progress == 100) {
                        step1 = 'completed'; step2 = 'completed'; step3 = 'completed'; step4 = 'completed';
                    } else if (status === 'Rejected') {
                        step1 = 'active';
                    }

                    // Render Timeline HTML
                    const timelineContainer = document.getElementById('m-ormas-timeline-container');
                    timelineContainer.className = "timeline-steps my-4 w-100";
                    timelineContainer.innerHTML = `
                        <div class="timeline-progress" style="width: ${progress == 25 ? '0' : (progress == 50 ? '33' : (progress == 75 ? '66' : (progress == 100 ? '100' : '0')))}%;"></div>
                        <div class="timeline-step ${step1}">
                            <div class="timeline-icon" style="width:30px; height:30px; font-size:0.75rem;">
                                ${step1 === 'completed' ? '<i class="fa-solid fa-check"></i>' : '1'}
                            </div>
                            <div class="timeline-label" style="font-size:0.68rem; margin-top:5px; line-height:1.2;">Verifikasi Berkas</div>
                        </div>
                        <div class="timeline-step ${step2}">
                            <div class="timeline-icon" style="width:30px; height:30px; font-size:0.75rem;">
                                ${step2 === 'completed' ? '<i class="fa-solid fa-check"></i>' : '2'}
                            </div>
                            <div class="timeline-label" style="font-size:0.68rem; margin-top:5px; line-height:1.2;">Validasi Bidang</div>
                        </div>
                        <div class="timeline-step ${step3}">
                            <div class="timeline-icon" style="width:30px; height:30px; font-size:0.75rem;">
                                ${step3 === 'completed' ? '<i class="fa-solid fa-check"></i>' : '3'}
                            </div>
                            <div class="timeline-label" style="font-size:0.68rem; margin-top:5px; line-height:1.2;">Ke Kemendagri</div>
                        </div>
                        <div class="timeline-step ${step4}">
                            <div class="timeline-icon" style="width:30px; height:30px; font-size:0.75rem;">
                                ${step4 === 'completed' ? '<i class="fa-solid fa-check"></i>' : '4'}
                            </div>
                            <div class="timeline-label" style="font-size:0.68rem; margin-top:5px; line-height:1.2;">Selesai</div>
                        </div>
                    `;

                    // Build Documents Table
                    let filesList = {};
                    try {
                        if (file && file.trim().startsWith('{')) {
                            filesList = JSON.parse(file);
                        }
                    } catch(e) {}

                    const activeReqs = tipeOrmas === 'Lokal' ? globalRequirementsLokal : globalRequirementsBerjenjang;
                    const docsBody = document.getElementById('m-ormas-documents-body');
                    docsBody.innerHTML = '';

                    activeReqs.forEach((req, idx) => {
                        if (req.isPengurus) return;
                        const fileIdx = idx + 1;
                        const exist = filesList[fileIdx] || null;

                        let statusCol = '<span class="text-muted small">-</span>';
                        let actionCol = '<span class="text-danger small"><i class="fa-solid fa-circle-xmark me-1"></i> Belum Diunggah</span>';

                        if (exist) {
                            const docStatus = exist.status || 'pending';
                            if (docStatus === 'verified') {
                                statusCol = `<span class="badge bg-success-subtle text-success border border-success-subtle px-2 py-1 rounded small"><i class="fa-solid fa-circle-check me-1"></i> Terverifikasi</span>`;
                            } else if (docStatus === 'rejected') {
                                statusCol = `<span class="badge bg-danger-subtle text-danger border border-danger-subtle px-2 py-1 rounded small"><i class="fa-solid fa-circle-xmark me-1"></i> Ditolak</span>`;
                            } else {
                                statusCol = `<span class="badge bg-warning-subtle text-warning border border-warning-subtle px-2 py-1 rounded small"><i class="fa-solid fa-clock me-1"></i> Sedang Diperiksa</span>`;
                            }

                            actionCol = `<a href="<?= base_url('uploads/ormas/') ?>/${exist.filename}" target="_blank" class="btn btn-sm btn-outline-info py-0.5 px-2.5" style="font-size:11px;"><i class="fa-solid fa-file-pdf me-1"></i> Buka File</a>`;
                        }

                        const tr = document.createElement('tr');
                        tr.innerHTML = `
                            <td class="text-center align-middle">${fileIdx}</td>
                            <td class="align-middle">
                                <div class="fw-semibold text-main small">${req.name}</div>
                                <div class="text-muted" style="font-size: 0.75rem;">${req.desc}</div>
                            </td>
                            <td class="text-center align-middle">${statusCol}</td>
                            <td class="text-center align-middle">${actionCol}</td>
                        `;
                        docsBody.appendChild(tr);
                    });

                    modal.show();
                });
            });
        }
    });
</script>
<?= $this->endSection() ?>
