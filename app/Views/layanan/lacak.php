<?= $this->extend('layouts/main') ?>

<?= $this->section('styles') ?>
<style>
    .stepper-container {
        display: flex;
        justify-content: space-between;
        align-items: center;
        position: relative;
        margin: 40px 0;
    }
    .stepper-line {
        position: absolute;
        top: 25px;
        left: 5%;
        right: 5%;
        height: 4px;
        background: var(--border-color);
        z-index: 1;
    }
    .stepper-progress {
        position: absolute;
        top: 25px;
        left: 5%;
        height: 4px;
        background: #be123c;
        z-index: 2;
        transition: width 0.4s ease;
    }
    .stepper-step {
        display: flex;
        flex-direction: column;
        align-items: center;
        position: relative;
        z-index: 3;
        width: 80px;
    }
    .step-circle {
        width: 50px;
        height: 50px;
        border-radius: 50%;
        background: var(--input-bg);
        border: 2px solid var(--border-color);
        color: var(--text-muted);
        display: flex;
        align-items: center;
        justify-content: center;
        font-weight: 700;
        transition: all 0.3s ease;
    }
    .stepper-step.active .step-circle {
        background: #be123c;
        border-color: #be123c;
        color: #ffffff;
        box-shadow: 0 0 15px rgba(190, 18, 60, 0.4);
    }
    .stepper-step.completed .step-circle {
        background: #e11d48;
        border-color: #e11d48;
        color: #ffffff;
    }
    .step-label {
        margin-top: 10px;
        font-size: 0.8rem;
        font-weight: 600;
        color: var(--text-muted);
        text-align: center;
    }
    .stepper-step.active .step-label {
        color: var(--text-main);
    }
    .wa-link {
        transition: all 0.2s ease;
    }
    .wa-link:hover {
        text-decoration: underline !important;
        opacity: 0.85;
    }
    .badge-reg-number {
        font-family: 'Outfit', sans-serif;
        font-size: 1.05rem;
        font-weight: 700;
        color: #d97706;
        background: rgba(217, 119, 6, 0.08);
        border: 1px solid rgba(217, 119, 6, 0.2);
        padding: 4px 12px;
        border-radius: 8px;
        display: inline-block;
        letter-spacing: 0.5px;
        transition: var(--transition-smooth);
    }
    html[data-theme="dark"] .badge-reg-number {
        color: #fbbf24;
        background: rgba(251, 191, 36, 0.1);
        border: 1px solid rgba(251, 191, 36, 0.3);
        box-shadow: 0 0 10px rgba(251, 191, 36, 0.15);
    }
</style>
<?= $this->endSection() ?>

<?= $this->section('content') ?>

<div class="py-4" style="max-width: 900px; margin: 0 auto;">
    <div class="glass-card mb-4 text-center">
        <h1 class="display-6 fw-bold text-white mb-2"><i class="fa-solid fa-route text-primary me-2"></i>Status Pelacakan Berkas</h1>
        <p class="text-muted mb-0">Nomor Registrasi: <span class="badge-reg-number"><?= esc($nomor) ?></span></p>
    </div>

    <?php if ($berkas): ?>
        <!-- Data ditemukan -->
        <div class="glass-card mb-4">
            <h4 class="text-white mb-4"><i class="fa-solid fa-circle-info text-primary me-2"></i>Detail Pengajuan</h4>
            <div class="row g-3">
                <div class="col-sm-6">
                    <span class="small text-muted d-block"><?= ($tipe === 'rekomendasi') ? 'Nama Pemohon / Peneliti / Lembaga' : 'Nama Organisasi (Ormas/Yayasan)' ?></span>
                    <strong class="text-white" style="font-size: 1.1rem;"><?= esc($berkas['nama_ormas']) ?></strong>
                </div>
                <div class="col-sm-6">
                    <span class="small text-muted d-block">Tanggal Pengajuan</span>
                    <strong class="text-white"><?= date('d F Y', strtotime($berkas['created_at'])) ?></strong>
                </div>
                <div class="col-sm-12">
                    <span class="small text-muted d-block"><?= ($tipe === 'rekomendasi') ? 'Nama & Tema Kegiatan / Lokasi Sasaran' : 'Alamat Sekretariat' ?></span>
                    <span class="text-white d-block"><?= esc($berkas['alamat']) ?></span>
                </div>
                <div class="col-sm-6">
                    <span class="small text-muted d-block">Status Verifikasi</span>
                    <?php if ($berkas['status_verifikasi'] === 'Approved'): ?>
                        <span class="badge bg-success-subtle text-success border border-success-subtle px-3 py-2 rounded-pill">Selesai / Terbit</span>
                    <?php elseif ($berkas['status_verifikasi'] === 'Rejected'): ?>
                        <span class="badge bg-danger-subtle text-danger border border-danger-subtle px-3 py-2 rounded-pill">Ditolak</span>
                    <?php elseif ($berkas['status_verifikasi'] === 'Pending'): ?>
                        <span class="badge bg-warning-subtle text-warning border border-warning-subtle px-3 py-2 rounded-pill">Pending Verifikasi</span>
                    <?php else: ?>
                        <span class="badge bg-secondary-subtle text-secondary border border-secondary-subtle px-3 py-2 rounded-pill">Draf</span>
                    <?php endif; ?>
                </div>
            </div>
        </div>

        <!-- Stepper Status -->
        <?php
        $progress = $berkas['progress_percentage'];
        // Map steps activity
        $step1 = 'completed';
        $step2 = '';
        $step3 = '';
        $step4 = '';
        $lineWidth = '0%';

        if ($berkas['status_verifikasi'] === 'Draft') {
            $step1 = 'active';
            $lineWidth = '0%';
        } elseif ($berkas['status_verifikasi'] === 'Pending') {
            $step1 = 'completed';
            $step2 = 'active';
            $lineWidth = '33.33%';
        } elseif ($berkas['progress_percentage'] == 75) {
            $step1 = 'completed';
            $step2 = 'completed';
            $step3 = 'active';
            $lineWidth = '66.66%';
        } elseif ($berkas['status_verifikasi'] === 'Approved' || $berkas['status_verifikasi'] === 'Rejected') {
            $step1 = 'completed';
            $step2 = 'completed';
            $step3 = 'completed';
            $step4 = 'active';
            $lineWidth = '90%';
        }
        ?>
        <div class="glass-card mb-4">
            <h4 class="text-white mb-4"><i class="fa-solid fa-bars-progress text-success me-2"></i>Langkah Verifikasi Berkas</h4>
            
            <div class="stepper-container">
                <div class="stepper-line"></div>
                <div class="stepper-progress" style="width: <?= $lineWidth ?>;"></div>
                
                <div class="stepper-step <?= $step1 ?>">
                    <div class="step-circle">1</div>
                    <div class="step-label">Draf Diajukan</div>
                </div>
                <div class="stepper-step <?= $step2 ?>">
                    <div class="step-circle">2</div>
                    <div class="step-label">Masuk Antrean</div>
                </div>
                <div class="stepper-step <?= $step3 ?>">
                    <div class="step-circle">3</div>
                    <div class="step-label">Proses Validasi</div>
                </div>
                <div class="stepper-step <?= $step4 ?>">
                    <div class="step-circle">
                        <?php if ($berkas['status_verifikasi'] === 'Rejected'): ?>
                            <i class="fa-solid fa-circle-xmark text-danger"></i>
                        <?php else: ?>
                            <i class="fa-solid fa-circle-check text-success"></i>
                        <?php endif; ?>
                    </div>
                    <div class="step-label">
                        <?= ($berkas['status_verifikasi'] === 'Rejected') ? 'Berkas Ditolak' : 'Berkas Selesai' ?>
                    </div>
                </div>
            </div>

            <!-- Detail Message -->
            <div class="alert alert-secondary bg-dark-subtle border-secondary-subtle text-muted p-3 mt-4 mb-0" style="border-radius: 12px; font-size: 0.9rem;">
                <?php if ($berkas['status_verifikasi'] === 'Approved'): ?>
                    <?php if ($tipe === 'rekomendasi'): ?>
                        <i class="fa-solid fa-circle-check text-success me-2"></i><strong>Pengajuan Rekomendasi Selesai!</strong> Surat Rekomendasi resmi ber-TTE telah berhasil diterbitkan oleh Badan Kesbangpol Kabupaten Sinjai. Silakan unduh berkas digital di bawah ini.
                    <?php else: 
                        $isLokal = (($berkas['tipe_ormas'] ?? 'Lokal') === 'Lokal');
                        $docTitle = $isLokal ? 'Laporan Tanggapan Keberadaan' : 'Surat Keberadaan';
                    ?>
                        <i class="fa-solid fa-circle-check text-success me-2"></i><strong>Pendaftaran Selesai!</strong> Berkas pendaftaran Ormas Anda telah diverifikasi dan disetujui. <?= $docTitle ?> resmi ber-TTE telah diterbitkan. Silakan konfirmasi berkas fisik di loket Kesbangpol MPP Sinjai.
                    <?php endif; ?>
                <?php elseif ($berkas['status_verifikasi'] === 'Rejected'): ?>
                    <i class="fa-solid fa-circle-xmark text-danger me-2"></i><strong>Pengajuan Ditolak.</strong> Terdapat beberapa berkas administrasi yang tidak sesuai persyaratan. Silakan hubungi admin di nomor 
                    <?php if ($tipe === 'rekomendasi'): ?>
                        <a href="https://wa.me/<?= get_piket_phone_clean() ?>?text=Halo%20Kesbangpol%20Sinjai,%20pengajuan%20rekomendasi%20kegiatan%20saya%20dengan%20nomor%20registrasi%20<?= esc($nomor) ?>%20ditolak.%20Mohon%20informasi%20perbaikan%20berkas." target="_blank" class="text-success text-decoration-none fw-bold wa-link">
                            WhatsApp Kesbangpol Sinjai (<?= esc(get_piket_phone()) ?>) <i class="fa-brands fa-whatsapp ms-1"></i>
                        </a>
                    <?php else: ?>
                        <a href="https://wa.me/6281280799020?text=Halo%20Bapak%20Endang,%20pengajuan%20registrasi%20ormas%20saya%20dengan%20nomor%20registrasi%20<?= esc($nomor) ?>%20ditolak.%20Mohon%20informasi%20perbaikan%20berkas." target="_blank" class="text-success text-decoration-none fw-bold wa-link">
                            WhatsApp Bapak Endang Saryono (0812-8079-9020) <i class="fa-brands fa-whatsapp ms-1"></i>
                        </a>
                    <?php endif; ?>
                    untuk informasi perbaikan berkas.
                    
                    <div class="mt-3 pt-3 border-top" style="border-color: rgba(255,255,255,0.06) !important;">
                        <form action="<?= site_url('layanan/hapus-berkas-ditolak') ?>" method="POST" onsubmit="return confirm('Apakah Anda yakin ingin menghapus berkas/pengajuan yang ditolak ini secara permanen dari sistem?')">
                            <?= csrf_field() ?>
                            <input type="hidden" name="nomor" value="<?= esc($nomor) ?>">
                            <input type="hidden" name="tipe" value="<?= esc($tipe) ?>">
                            <button type="submit" class="btn btn-outline-danger btn-sm px-3 py-2">
                                <i class="fa-solid fa-trash me-2"></i>Hapus Berkas / Ajukan Ulang
                            </button>
                        </form>
                    </div>
                <?php elseif ($berkas['status_verifikasi'] === 'Pending'): ?>
                    <i class="fa-solid fa-circle-notch fa-spin text-warning me-2"></i><strong>Dalam Antrean Verifikasi.</strong> Dokumen Anda telah kami terima secara sistem dan sedang dalam antrean verifikasi administrasi oleh bidang terkait.
                <?php else: ?>
                    <i class="fa-solid fa-floppy-disk text-info me-2"></i><strong>Status Draf.</strong> Berkas Anda masih tersimpan sebagai draf dan belum masuk antrean utama verifikasi. Pastikan Anda menyelesaikan pengiriman formulir.
                <?php endif; ?>

                <?php if ($berkas['status_verifikasi'] === 'Approved'): ?>
                    <?php if ($tipe === 'rekomendasi' && !empty($berkas['pdf_tte_path'])): ?>
                        <div class="mt-3 text-center border-top pt-3" style="border-color: rgba(255,255,255,0.06) !important;">
                            <a href="<?= site_url('layanan/cetak-rekomendasi/' . $berkas['id']) ?>" target="_blank" class="btn btn-success px-4 py-2">
                                <i class="fa-solid fa-print me-2"></i> Cetak Surat Rekomendasi Resmi (TTE)
                            </a>
                        </div>
                    <?php elseif ($tipe === 'ormas' && !empty($berkas['pdf_tte_path'])): ?>
                        <div class="mt-3 text-center border-top pt-3" style="border-color: rgba(255,255,255,0.06) !important;">
                            <a href="<?= base_url('uploads/rekomendasi_ormas/' . $berkas['pdf_tte_path']) ?>" target="_blank" class="btn btn-success px-4 py-2 text-white fw-bold text-decoration-none">
                                <i class="fa-solid fa-file-arrow-down me-2"></i> Unduh <?= $docTitle ?> Resmi (TTE)
                            </a>
                        </div>
                    <?php endif; ?>
                <?php endif; ?>
            </div>
        </div>

    <?php else: ?>
        <!-- Data tidak ditemukan -->
        <div class="glass-card text-center py-5">
            <i class="fa-solid fa-folder-open fa-4x text-danger mb-4"></i>
            <h4 class="text-white mb-2">Berkas Tidak Ditemukan</h4>
            <p class="text-muted mx-auto mb-4" style="max-width: 500px;">Maaf, berkas pendaftaran dengan nomor registrasi <span class="badge-reg-number">"<?= esc($nomor) ?>"</span> tidak ditemukan pada basis data kami. Pastikan Anda memasukkan kode registrasi dengan benar.</p>
            
            <!-- Pencarian ulang -->
            <div class="d-inline-block text-start w-100" style="max-width: 500px; margin: 0 auto;">
                <form action="<?= base_url('layanan/lacak') ?>" method="GET">
                    <div class="input-group">
                        <input type="text" name="nomor" class="form-control form-control-custom py-2" value="<?= esc($nomor) ?>" placeholder="Masukkan nomor registrasi..." required>
                        <button class="btn btn-portal" type="submit">Cari Ulang</button>
                    </div>
                </form>
            </div>
        </div>
    <?php endif; ?>

    <div class="text-center mt-4">
        <a href="<?= base_url() ?>" class="btn btn-outline-secondary px-4 py-2"><i class="fa-solid fa-arrow-left-long me-2"></i>Kembali ke Beranda</a>
    </div>
</div>

<?= $this->endSection() ?>
