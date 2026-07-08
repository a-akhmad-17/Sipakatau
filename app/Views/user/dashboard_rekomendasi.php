<?= $this->extend('layouts/admin') ?>

<?= $this->section('styles') ?>
<style>
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
</style>
<?= $this->endSection() ?>

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
                                         <button type="button" class="btn btn-sm btn-info text-white py-1 px-2.5 mb-1.5 btn-detail-rekomendasi"
                                                 data-id="<?= $rek['id'] ?>"
                                                 data-nama="<?= esc($rek['pemohon']) ?>"
                                                 data-kegiatan="<?= esc($rek['nama_kegiatan']) ?>"
                                                 data-deskripsi="<?= esc($rek['deskripsi'] ?? '-') ?>"
                                                 data-status="<?= esc($rek['status_rekomendasi'] ?? 'Pending') ?>"
                                                 data-progress="<?= esc($rek['progress_percentage'] ?? 0) ?>"
                                                 data-file="<?= esc($rek['file_proposal'] ?? '') ?>" 
                                                 data-mulai="<?= date('d F Y', strtotime($rek['tgl_mulai'])) ?>" 
                                                 data-selesai="<?= date('d F Y', strtotime($rek['tgl_selesai'])) ?>"
                                                 data-tte="<?= esc($rek['pdf_tte_path'] ?? '') ?>"
                                                 data-tanggal="<?= date('d F Y H:i:s', strtotime($rek['created_at'])) ?>">
                                             <i class="fa-solid fa-list-check me-1"></i> Detail
                                         </button>
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
<!-- Modal Detail Progress Rekomendasi -->
<div class="modal fade" id="modalDetailProgressRekomendasi" tabindex="-1" aria-labelledby="modalDetailProgressRekomendasiLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg modal-dialog-centered">
        <div class="modal-content" style="background: var(--card-bg) !important; border: 1px solid var(--border-color) !important; border-radius: 16px; overflow: hidden; backdrop-filter: blur(20px); color: var(--text-main) !important;">
            <!-- Modal Header -->
            <div class="modal-header border-bottom py-3.5 px-4" style="border-color: var(--border-color) !important;">
                <div class="d-flex align-items-center gap-3">
                    <div class="rounded-circle bg-success-subtle text-success p-2.5 d-flex align-items-center justify-content-center" style="width: 48px; height: 48px;">
                        <i class="fa-solid fa-route fa-lg"></i>
                    </div>
                    <div>
                        <h5 class="modal-title fw-bold font-heading mb-0.5" id="modalDetailProgressRekomendasiLabel" style="color: var(--text-main) !important;">Detail Pelacakan Progres</h5>
                        <span class="small text-muted">Layanan Rekomendasi Kegiatan</span>
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
                                <th style="width: 30%; background: rgba(255,255,255,0.02);" class="text-muted">Nama Pemohon / Lembaga</th>
                                <td id="m-rek-nama" class="fw-bold text-success">-</td>
                            </tr>
                            <tr>
                                <th style="background: rgba(255,255,255,0.02);" class="text-muted">Judul / Tema Kegiatan</th>
                                <td id="m-rek-kegiatan" class="text-warning">-</td>
                            </tr>
                            <tr>
                                <th style="background: rgba(255,255,255,0.02);" class="text-muted">Waktu Pelaksanaan</th>
                                <td id="m-rek-waktu">-</td>
                            </tr>
                            <tr>
                                <th style="background: rgba(255,255,255,0.02);" class="text-muted">Deskripsi Rencana</th>
                                <td id="m-rek-deskripsi">-</td>
                            </tr>
                            <tr>
                                <th style="background: rgba(255,255,255,0.02);" class="text-muted">Status Ajuan</th>
                                <td id="m-rek-status">-</td>
                            </tr>
                            <tr>
                                <th style="background: rgba(255,255,255,0.02);" class="text-muted">Progres Alur</th>
                                <td id="m-rek-progress" class="text-warning fw-bold">-</td>
                            </tr>
                            <tr id="row-m-rek-tte" class="d-none">
                                <th style="background: rgba(255,255,255,0.02);" class="text-muted">Surat Rekomendasi Resmi</th>
                                <td id="m-rek-tte-download"></td>
                            </tr>
                        </tbody>
                    </table>
                </div>

                <!-- Progress Tracker Timeline -->
                <div class="mb-4 p-4 rounded" style="background: rgba(255, 255, 255, 0.02); border: 1px solid var(--border-color); border-radius: 12px;">
                    <h6 class="small fw-bold mb-4" style="color: var(--text-main) !important;"><i class="fa-solid fa-spinner fa-spin text-warning me-2"></i>Alur Proses Verifikasi</h6>
                    <div class="d-flex justify-content-between align-items-center flex-wrap gap-3" id="m-rek-timeline-container">
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
                            <tbody id="m-rek-documents-body">
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
document.addEventListener('DOMContentLoaded', function() {
    const globalRequirementsRekomendasi = [
        {"name": "Surat Permohonan", "desc": "Surat Permohonan Rekomendasi Kegiatan ditujukan kepada Kepala Badan Kesbangpol Kab. Sinjai", "tte": true},
        {"name": "Rekomendasi Lurah/Camat", "desc": "Surat Rekomendasi Kegiatan dari Kantor Lurah setempat dan diketahui Camat", "tte": true},
        {"name": "Proposal Kegiatan", "desc": "Proposal Kegiatan lengkap (berisi latar belakang, rencana acara, sasaran, dll.)", "tte": true},
        {"name": "KTP Ketua Panitia", "desc": "Fotokopi KTP Ketua Panitia Pelaksana / Pemohon", "tte": false},
        {"name": "SK Pengurus Kegiatan", "desc": "Surat Keputusan (SK) Pengurus Kegiatan", "tte": false},
        {"name": "Rekomendasi Stakeholder", "desc": "Surat Rekomendasi pendukung dari Stakeholder terkait (Opsional)", "tte": true}
    ];

    const modalEl = document.getElementById('modalDetailProgressRekomendasi');
    if (modalEl) {
        const modal = new bootstrap.Modal(modalEl);
        
        document.querySelectorAll('.btn-detail-rekomendasi').forEach(btn => {
            btn.addEventListener('click', function() {
                const id = this.getAttribute('data-id');
                const nama = this.getAttribute('data-nama');
                const kegiatan = this.getAttribute('data-kegiatan');
                const deskripsi = this.getAttribute('data-deskripsi');
                const status = this.getAttribute('data-status');
                const progress = parseInt(this.getAttribute('data-progress') || '0');
                const file = this.getAttribute('data-file');
                const mulai = this.getAttribute('data-mulai');
                const selesai = this.getAttribute('data-selesai');

                const tte = this.getAttribute('data-tte');
                const rowTte = document.getElementById('row-m-rek-tte');
                if (tte && tte.trim() !== '') {
                    rowTte.classList.remove('d-none');
                    document.getElementById('m-rek-tte-download').innerHTML = `<a href="<?= base_url() ?>/${tte}" target="_blank" class="btn btn-sm btn-success text-white fw-bold"><i class="fa-solid fa-download me-1.5"></i>Unduh Surat Rekomendasi Resmi (TTE)</a>`;
                } else {
                    rowTte.classList.add('d-none');
                }

                document.getElementById('m-rek-nama').innerText = nama;
                document.getElementById('m-rek-kegiatan').innerText = kegiatan;
                document.getElementById('m-rek-waktu').innerText = mulai + ' s/d ' + selesai;
                document.getElementById('m-rek-deskripsi').innerText = deskripsi;
                document.getElementById('m-rek-progress').innerText = progress + '% Selesai';

                let statusBadge = 'bg-warning-subtle text-warning border-warning-subtle';
                if (status === 'Approved') {
                    statusBadge = 'bg-success-subtle text-success border-success-subtle';
                } else if (status === 'Rejected') {
                    statusBadge = 'bg-danger-subtle text-danger border-danger-subtle';
                }
                document.getElementById('m-rek-status').innerHTML = `<span class="badge ${statusBadge} px-2.5 py-1.5 rounded-pill border small">${status}</span>`;

                // Build Timeline
                let step1 = '', step2 = '';
                if (status === 'Pending') {
                    step1 = 'active';
                } else if (status === 'Approved' && progress == 75) {
                    step1 = 'completed'; step2 = 'active';
                } else if (status === 'Approved' && progress == 100) {
                    step1 = 'completed'; step2 = 'completed';
                } else if (status === 'Rejected') {
                    step1 = 'active';
                }

                // Render Timeline HTML
                const timelineContainer = document.getElementById('m-rek-timeline-container');
                timelineContainer.className = "timeline-steps my-4 w-100";
                timelineContainer.innerHTML = `
                    <div class="timeline-progress" style="width: ${progress == 75 ? '50' : (progress == 100 ? '100' : '0')}%;"></div>
                    <div class="timeline-step ${step1}">
                        <div class="timeline-icon" style="width:30px; height:30px; font-size:0.75rem;">
                            ${step1 === 'completed' ? '<i class="fa-solid fa-check"></i>' : '1'}
                        </div>
                        <div class="timeline-label" style="font-size:0.68rem; margin-top:5px; line-height:1.2;">Verifikasi Berkas (75%)</div>
                    </div>
                    <div class="timeline-step ${step2}">
                        <div class="timeline-icon" style="width:30px; height:30px; font-size:0.75rem;">
                            ${step2 === 'completed' ? '<i class="fa-solid fa-check"></i>' : '2'}
                        </div>
                        <div class="timeline-label" style="font-size:0.68rem; margin-top:5px; line-height:1.2;">TTE Surat Selesai (100%)</div>
                    </div>
                `;

                // Build Documents Table
                let filesList = {};
                try {
                    if (file && (file.trim().startsWith('{') || file.trim().startsWith('['))) {
                        filesList = JSON.parse(file);
                    }
                } catch(e) {}

                const docsBody = document.getElementById('m-rek-documents-body');
                docsBody.innerHTML = '';

                globalRequirementsRekomendasi.forEach((req, idx) => {
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

                        actionCol = `<a href="<?= base_url('uploads/rekomendasi/') ?>/${exist.filename}" target="_blank" class="btn btn-sm btn-outline-info py-0.5 px-2.5" style="font-size:11px;"><i class="fa-solid fa-file-pdf me-1"></i> Buka File</a>`;
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
