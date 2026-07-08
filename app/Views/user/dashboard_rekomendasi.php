<?= $this->extend('layouts/admin') ?>

<?= $this->section('content') ?>
<div class="container-fluid px-0">
    <!-- Header / Breadcrumbs -->
    <div class="d-flex justify-content-between align-items-center mb-4 pb-2 border-bottom" style="border-color: var(--border-color) !important;">
        <div>
            <h3 class="mb-1 font-heading" style="color: var(--text-main);"><i class="fa-solid fa-calendar-check text-success me-2"></i>Dasbor Rekomendasi Kegiatan</h3>
            <p class="small mb-0" style="color: var(--text-muted);">Kelola pengajuan surat rekomendasi izin kegiatan ormas / lembaga Anda.</p>
        </div>
        <div>
            <a href="<?= base_url('user/rekomendasi/baru') ?>" class="btn btn-primary text-white fw-bold btn-portal">
                <i class="fa-solid fa-plus me-1.5"></i>Ajukan Rekomendasi Baru
            </a>
        </div>
    </div>

    <!-- Alert status -->
    <?php if (session()->getFlashdata('success')): ?>
        <div class="alert alert-success border-success border-opacity-25 bg-success-subtle text-success py-2.5 px-4 mb-4" style="border-radius: 8px;">
            <i class="fa-solid fa-circle-check me-2"></i><?= session()->getFlashdata('success') ?>
        </div>
    <?php endif; ?>

    <!-- Information Card -->
    <div class="row g-4 mb-4">
        <div class="col-md-4">
            <div class="glass-card p-4 h-100 text-center">
                <div class="rounded-circle bg-primary-subtle text-primary p-3 d-inline-flex align-items-center justify-content-center mb-3" style="width: 60px; height: 60px;">
                    <i class="fa-solid fa-download fa-xl"></i>
                </div>
                <h6 class="text-white fw-bold mb-2">1. Unduh Template</h6>
                <p class="small text-muted mb-0">Unduh format surat resmi permohonan rekomendasi kegiatan untuk diajukan.</p>
                <a href="https://drive.google.com/uc?export=download&id=1WsgeJzVebDi-eGE9B7uYifcAiW05hxgW" target="_blank" class="btn btn-sm btn-outline-primary mt-3 px-3">
                    Unduh Format <i class="fa-solid fa-file-arrow-down ms-1"></i>
                </a>
            </div>
        </div>
        <div class="col-md-4">
            <div class="glass-card p-4 h-100 text-center">
                <div class="rounded-circle bg-warning-subtle text-warning p-3 d-inline-flex align-items-center justify-content-center mb-3" style="width: 60px; height: 60px;">
                    <i class="fa-solid fa-file-shield fa-xl"></i>
                </div>
                <h6 class="text-white fw-bold mb-2">2. Lengkapi Syarat</h6>
                <p class="small text-muted mb-0">Siapkan KTP, rekomendasi Lurah/Camat, proposal kegiatan, dan SK Pengurus.</p>
            </div>
        </div>
        <div class="col-md-4">
            <div class="glass-card p-4 h-100 text-center">
                <div class="rounded-circle bg-success-subtle text-success p-3 d-inline-flex align-items-center justify-content-center mb-3" style="width: 60px; height: 60px;">
                    <i class="fa-solid fa-check-double fa-xl"></i>
                </div>
                <h6 class="text-white fw-bold mb-2">3. Tunggu Verifikasi</h6>
                <p class="small text-muted mb-0">Petugas Kesbangpol akan memproses berkas dan menerbitkan surat bertanda tangan digital (TTE).</p>
            </div>
        </div>
    </div>

    <!-- Persyaratan Dokumen & Panduan -->
    <div class="glass-card mb-4 p-4">
        <div class="d-flex justify-content-between align-items-center mb-3 flex-wrap gap-2 pb-2 border-bottom" style="border-color: rgba(255,255,255,.05) !important;">
            <h5 class="text-white mb-0"><i class="fa-solid fa-list-check text-warning me-2"></i>Persyaratan Rekomendasi Kegiatan (6 Berkas Utama)</h5>
            <a href="https://drive.google.com/uc?export=download&id=1WsgeJzVebDi-eGE9B7uYifcAiW05hxgW" class="btn btn-sm btn-outline-warning text-white py-1.5 px-3" style="font-size:0.8rem; border-radius:8px;">
                <i class="fa-solid fa-file-word me-1.5"></i>Unduh Panduan & Lampiran (.docx)
            </a>
        </div>
        <div class="row g-3">
            <div class="col-md-6">
                <ul class="list-group list-group-flush" style="background: transparent;">
                    <li class="list-group-item bg-transparent text-muted border-secondary-subtle px-0 py-1.5" style="font-size:12.5px;"><i class="fa-solid fa-square-check text-success me-2"></i>1. Surat Permohonan Rekomendasi Kegiatan ditujukan kepada Kepala Badan Kesbangpol Kab. Sinjai</li>
                    <li class="list-group-item bg-transparent text-muted border-secondary-subtle px-0 py-1.5" style="font-size:12.5px;"><i class="fa-solid fa-square-check text-success me-2"></i>2. Surat Rekomendasi Kegiatan dari Kantor Lurah setempat dan diketahui Camat</li>
                    <li class="list-group-item bg-transparent text-muted border-secondary-subtle px-0 py-1.5" style="font-size:12.5px;"><i class="fa-solid fa-square-check text-success me-2"></i>3. Proposal Kegiatan lengkap (berisi latar belakang, rencana acara, sasaran, dll.)</li>
                </ul>
            </div>
            <div class="col-md-6">
                <ul class="list-group list-group-flush" style="background: transparent;">
                    <li class="list-group-item bg-transparent text-muted border-secondary-subtle px-0 py-1.5" style="font-size:12.5px;"><i class="fa-solid fa-square-check text-success me-2"></i>4. Fotokopi KTP Ketua Panitia Pelaksana</li>
                    <li class="list-group-item bg-transparent text-muted border-secondary-subtle px-0 py-1.5" style="font-size:12.5px;"><i class="fa-solid fa-square-check text-success me-2"></i>5. Surat Keputusan (SK) Pengurus Kegiatan</li>
                    <li class="list-group-item bg-transparent text-muted border-secondary-subtle px-0 py-1.5" style="font-size:12.5px;"><i class="fa-solid fa-square-check text-success me-2"></i>6. Surat Rekomendasi pendukung dari Stakeholder terkait (Opsional)</li>
                </ul>
            </div>
        </div>
    </div>

    <!-- Riwayat Rekomendasi Kegiatan -->
    <div class="glass-card">
        <div class="d-flex justify-content-between align-items-center mb-4 flex-wrap gap-2">
            <div>
                <h5 class="text-white mb-1"><i class="fa-solid fa-clock-rotate-left text-success me-2"></i>Riwayat Pengajuan Rekomendasi</h5>
                <p class="text-muted small mb-0">Daftar pengajuan rekomendasi kegiatan yang pernah Anda ajukan sebelumnya.</p>
            </div>
        </div>

        <div class="table-responsive">
            <table class="table table-custom mb-0" style="font-size:13px;">
                <thead>
                    <tr style="background:rgba(255,255,255,.04); color:var(--text-muted); font-size:11px; letter-spacing:.5px; text-transform:uppercase;">
                        <th style="padding:12px 14px; border-bottom:1px solid var(--border-color); width: 5%;">#</th>
                        <th style="padding:12px 14px; border-bottom:1px solid var(--border-color); width: 30%;">Detail Kegiatan</th>
                        <th style="padding:12px 14px; border-bottom:1px solid var(--border-color); width: 20%;">Pemohon</th>
                        <th style="padding:12px 14px; border-bottom:1px solid var(--border-color); width: 20%;">Waktu Kegiatan</th>
                        <th style="padding:12px 14px; border-bottom:1px solid var(--border-color); width: 10%; text-align:center;">Status</th>
                        <th style="padding:12px 14px; border-bottom:1px solid var(--border-color); width: 15%; text-align:center;">Unduh / Lampiran</th>
                    </tr>
                </thead>
                <tbody>
                    <?php if (empty($riwayatRekomendasi)): ?>
                        <tr>
                            <td colspan="6" class="text-center text-muted py-4">Belum ada riwayat pengajuan rekomendasi kegiatan.</td>
                        </tr>
                    <?php else: ?>
                        <?php foreach ($riwayatRekomendasi as $i => $rek):
                            $rekStatus = $rek['status_rekomendasi'] ?? 'Pending';
                            $rekBadge = match($rekStatus) {
                                'Approved' => 'background:rgba(34,197,94,.15); color:#4ade80; border:1px solid rgba(34,197,94,.3);',
                                'Rejected' => 'background:rgba(239,68,68,.15); color:#f87171; border:1px solid rgba(239,68,68,.3);',
                                default    => 'background:rgba(251,191,36,.15); color:#fbbf24; border:1px solid rgba(251,191,36,.3);',
                            };
                            $rekLabel = match($rekStatus) {
                                'Approved' => '<i class="fa-solid fa-circle-check me-1"></i>Disetujui',
                                'Rejected' => '<i class="fa-solid fa-circle-xmark me-1"></i>Ditolak',
                                default    => '<i class="fa-solid fa-clock me-1"></i>Menunggu',
                            };
                        ?>
                            <tr style="border-bottom:1px solid rgba(255,255,255,.04); vertical-align: middle;">
                                <td style="padding:12px 14px; color:var(--text-muted);"><?= $i + 1 ?></td>
                                <td style="padding:12px 14px;">
                                    <div class="fw-semibold text-white"><?= esc($rek['nama_kegiatan']) ?></div>
                                    <div style="font-size:11px; color:var(--text-muted);"><?= date('d M Y', strtotime($rek['created_at'])) ?></div>
                                    <?php if (!empty($rek['deskripsi'])): ?>
                                        <div class="text-muted text-truncate mt-1" style="max-width: 250px; font-size: 11px;" title="<?= esc($rek['deskripsi']) ?>"><?= esc($rek['deskripsi']) ?></div>
                                    <?php endif; ?>
                                </td>
                                <td style="padding:12px 14px; color:var(--text-white);"><?= esc($rek['pemohon']) ?></td>
                                <td style="padding:12px 14px; color:var(--text-muted); font-size:12px;">
                                    <?= !empty($rek['tgl_mulai']) ? date('d M Y', strtotime($rek['tgl_mulai'])) : '-' ?>
                                    <?= !empty($rek['tgl_selesai']) ? ' s/d ' . date('d M Y', strtotime($rek['tgl_selesai'])) : '' ?>
                                </td>
                                <td style="padding:12px 14px; text-align:center;">
                                    <span class="badge" style="<?= $rekBadge ?> border-radius:6px; font-size:11px; padding:4px 10px;">
                                        <?= $rekLabel ?>
                                    </span>
                                </td>
                                <td style="padding:12px 14px; text-align:center;">
                                    <div class="d-flex flex-column align-items-center gap-1.5">
                                        <?php if (!empty($rek['file_proposal'])): ?>
                                            <?php 
                                            $files = json_decode($rek['file_proposal'], true);
                                            if (json_last_error() === JSON_ERROR_NONE && is_array($files)): 
                                                $fileNamesMap = [
                                                    "1" => "Permohonan",
                                                    "2" => "Rekomendasi L/C",
                                                    "3" => "Proposal",
                                                    "4" => "KTP Ketua",
                                                    "5" => "SK Pengurus",
                                                    "6" => "Rekomendasi S/H"
                                                ];
                                            ?>
                                                <div class="dropdown">
                                                    <button class="btn btn-sm btn-outline-secondary dropdown-toggle py-1 px-2.5" type="button" data-bs-toggle="dropdown" aria-expanded="false" style="font-size: 11.5px;">
                                                        <i class="fa-solid fa-folder-open me-1"></i> Berkas Syarat
                                                    </button>
                                                     <ul class="dropdown-menu dropdown-menu-dark" style="font-size: 12px; background: var(--bg-color); border: 1px solid var(--border-color); min-width: 200px;">
                                                         <?php foreach ($files as $key => $fileInfo): ?>
                                                             <li>
                                                                 <a class="dropdown-item py-1.5 d-flex justify-content-between align-items-center gap-2" href="<?= base_url('uploads/rekomendasi/' . $fileInfo['filename']) ?>" target="_blank">
                                                                     <span><i class="fa-solid fa-file-pdf me-1.5 text-danger"></i><?= esc($fileNamesMap[$key] ?? 'Berkas ' . $key) ?></span>
                                                                     <?php 
                                                                     $docStatus = $fileInfo['status'] ?? 'pending';
                                                                     if ($docStatus === 'verified'): ?>
                                                                         <span class="badge bg-success" style="font-size: 9px; padding: 2px 4px;"><i class="fa-solid fa-check"></i></span>
                                                                     <?php elseif ($docStatus === 'rejected'): ?>
                                                                         <span class="badge bg-danger" style="font-size: 9px; padding: 2px 4px;"><i class="fa-solid fa-xmark"></i></span>
                                                                     <?php else: ?>
                                                                         <span class="badge bg-warning text-dark" style="font-size: 9px; padding: 2px 4px;"><i class="fa-solid fa-clock"></i></span>
                                                                     <?php endif; ?>
                                                                 </a>
                                                             </li>
                                                         <?php endforeach; ?>
                                                     </ul>
                                                </div>
                                            <?php else: ?>
                                                <a href="<?= base_url('uploads/rekomendasi/' . $rek['file_proposal']) ?>" target="_blank"
                                                    style="background:rgba(99,102,241,.12); color:#818cf8; border:1px solid rgba(99,102,241,.25); border-radius:6px; padding:4px 10px; font-size:11.5px; text-decoration:none;">
                                                    <i class="fa-solid fa-eye me-1"></i>Lihat Proposal
                                                </a>
                                            <?php endif; ?>
                                        <?php endif; ?>
                                        
                                        <?php if (!empty($rek['pdf_tte_path'])): ?>
                                            <a href="<?= base_url($rek['pdf_tte_path']) ?>" target="_blank"
                                                style="background:rgba(34,197,94,.12); color:#4ade80; border:1px solid rgba(34,197,94,.25); border-radius:6px; padding:4px 12px; font-size:11.5px; text-decoration:none; display:inline-block;">
                                                <i class="fa-solid fa-file-arrow-down me-1"></i>Surat Rekomendasi
                                            </a>
                                        <?php endif; ?>
                                    </div>
                                </td>
                            </tr>
                        <?php endforeach; ?>
                    <?php endif; ?>
                </tbody>
            </table>
        </div>
    </div>
</div>
<?= $this->endSection() ?>
