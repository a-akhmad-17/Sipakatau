<?= $this->extend('layouts/admin') ?>

<?= $this->section('styles') ?>
<style>
    .bidang-header {
        background: linear-gradient(135deg, rgba(59, 130, 246, 0.1) 0%, rgba(37, 99, 235, 0.05) 100%);
        border: 1px solid var(--border-color);
        border-radius: 12px;
        padding: 24px;
        margin-bottom: 30px;
    }
    
    /* SKT Panel & Badges */
    .skt-badge-pending  { background: rgba(251,191,36,.15); color: #fbbf24; border: 1px solid rgba(251,191,36,.3); }
    .skt-badge-approved { background: rgba(34,197,94,.15);  color: #22c55e; border: 1px solid rgba(34,197,94,.3); }
    .skt-badge-rejected { background: rgba(239,68,68,.15);  color: #ef4444; border: 1px solid rgba(239,68,68,.3); }
    .skt-badge-done     { background: rgba(99,102,241,.15); color: #818cf8; border: 1px solid rgba(99,102,241,.3); }

    .progress-track {
        height: 6px;
        border-radius: 4px;
        background: rgba(255,255,255,.08);
        overflow: hidden;
    }
    .progress-fill {
        height: 100%;
        border-radius: 4px;
        background: linear-gradient(90deg, #3b82f6, #818cf8);
        transition: width .4s ease;
    }
    .pendaftaran-table th {
        background: rgba(255,255,255,.04);
        color: var(--text-muted);
        font-size: 11px;
        letter-spacing: .5px;
        text-transform: uppercase;
        padding: 10px 14px;
        border-bottom: 1px solid var(--border-color);
    }
    .pendaftaran-table td {
        padding: 12px 14px;
        border-bottom: 1px solid rgba(255,255,255,.04);
        vertical-align: middle;
        font-size: 13px;
    }
    .pendaftaran-table tr:hover td { background: rgba(255,255,255,.02); }
</style>
<?= $this->endSection() ?>

<?= $this->section('content') ?>

<!-- Header Bidang -->
<div class="bidang-header d-flex justify-content-between align-items-center gap-3">
    <div>
        <span class="badge bg-info-subtle text-info border border-info-subtle px-3 py-1.5 rounded-pill mb-2 font-heading" style="font-weight:600;"><i class="fa-solid fa-code-branch me-1"></i>Kabid Panel</span>
        <h2 class="text-white fw-bold mb-1"><?= esc($namaBidang) ?></h2>
        <p class="text-muted small mb-0">Penerbitan SKT & Dokumen Laporan Keberadaan Ormas • Hari ini: <b><?= date('d M Y') ?></b></p>
    </div>
</div>

<?php
    $totalSkt    = count($pendaftaran);
    $menugggu    = count(array_filter($pendaftaran, fn($p) => in_array($p['status_verifikasi'], ['Pending']) && (int)$p['progress_percentage'] < 75));
    $perluSkt    = count(array_filter($pendaftaran, fn($p) => $p['status_verifikasi'] === 'Approved' && (int)$p['progress_percentage'] == 75));
    $selesai     = count(array_filter($pendaftaran, fn($p) => (int)$p['progress_percentage'] == 100));
?>

<!-- Stat Cards SKT -->
<div class="row g-3 mb-4">
    <div class="col-6 col-md-3">
        <div class="glass-card p-3 text-center">
            <div class="fs-2 fw-bold text-white"><?= $totalSkt ?></div>
            <div class="text-muted small mt-1"><i class="fa-solid fa-file-circle-check text-info me-1"></i>Total Pengajuan</div>
        </div>
    </div>
    <div class="col-6 col-md-3">
        <div class="glass-card p-3 text-center">
            <div class="fs-2 fw-bold text-warning"><?= $menugggu ?></div>
            <div class="text-muted small mt-1"><i class="fa-solid fa-clock text-warning me-1"></i>Menunggu Validasi</div>
        </div>
    </div>
    <div class="col-6 col-md-3">
        <div class="glass-card p-3 text-center">
            <div class="fs-2 fw-bold text-primary"><?= $perluSkt ?></div>
            <div class="text-muted small mt-1"><i class="fa-solid fa-stamp text-primary me-1"></i>Siap Terbit Dokumen</div>
        </div>
    </div>
    <div class="col-6 col-md-3">
        <div class="glass-card p-3 text-center">
            <div class="fs-2 fw-bold text-success"><?= $selesai ?></div>
            <div class="text-muted small mt-1"><i class="fa-solid fa-circle-check text-success me-1"></i>Dokumen Diterbitkan</div>
        </div>
    </div>
</div>

<!-- Tabel Pendaftaran SKT -->
<div class="row g-4 mb-4">
    <div class="col-12">
        <div class="glass-card p-4">
            <div class="d-flex justify-content-between align-items-center mb-3">
                <div>
                    <h5 class="text-white mb-1 font-heading"><i class="fa-solid fa-file-signature text-primary me-2"></i>Kelola Pendaftaran Ormas</h5>
                    <p class="text-muted small mb-0">Verifikasi berkas, validasi, dan penerbitan Laporan Tanggapan Keberadaan atau Surat Keberadaan.</p>
                </div>
            </div>

            <?php if (empty($pendaftaran)): ?>
                <div class="text-center py-5 text-muted">
                    <i class="fa-solid fa-inbox fa-3x mb-3 opacity-25"></i>
                    <p class="mb-0">Belum ada pengajuan pendaftaran SKT ormas.</p>
                </div>
            <?php else: ?>
            <div class="table-responsive">
                <table class="pendaftaran-table w-100">
                    <thead>
                        <tr>
                            <th>#</th>
                            <th>Nama Ormas</th>
                            <th>No. Registrasi</th>
                            <th>Progress</th>
                            <th>Status</th>
                            <th>Tgl Pengajuan</th>
                            <th class="text-center">Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                    <?php foreach ($pendaftaran as $i => $p):
                        $status    = $p['status_verifikasi'] ?? 'Pending';
                        $progress  = (int)($p['progress_percentage'] ?? 0);
                        $isLokal   = (($p['tipe_ormas'] ?? 'Lokal') === 'Lokal');
                        $badgeClass = match(true) {
                            $progress === 100              => 'skt-badge-done',
                            $status === 'Rejected'         => 'skt-badge-rejected',
                            $status === 'Approved' && $progress >= 75 => 'skt-badge-approved',
                            default                        => 'skt-badge-pending',
                        };
                        $statusLabel = match(true) {
                            $progress === 100              => $isLokal ? 'Tanggapan Diterbitkan' : 'Surat Keberadaan Diterbitkan',
                            $status === 'Rejected'         => 'Ditolak',
                            $status === 'Approved' && $progress >= 75 => $isLokal ? 'Siap Terbit Tanggapan' : 'Siap Terbit Surat Keberadaan',
                            $progress >= 50                => 'Validasi Bidang',
                            default                        => 'Menunggu',
                        };
                    ?>
                        <tr>
                            <td class="text-muted"><?= $i + 1 ?></td>
                            <td>
                                <div class="fw-semibold text-white"><?= esc($p['nama_ormas'] ?? '-') ?></div>
                                <div class="text-muted" style="font-size:11px;"><?= esc($p['email'] ?? '') ?></div>
                            </td>
                            <td><span class="badge" style="background:rgba(99,102,241,.15); color:#818cf8; font-size:11px;"><?= esc($p['nomor_registrasi'] ?? '-') ?></span></td>
                            <td style="min-width:110px;">
                                <div class="d-flex align-items-center gap-2">
                                    <div class="progress-track flex-grow-1">
                                        <div class="progress-fill" style="width:<?= $progress ?>%"></div>
                                    </div>
                                    <span class="text-muted" style="font-size:11px; white-space:nowrap;"><?= $progress ?>%</span>
                                </div>
                            </td>
                            <td>
                                <span class="badge px-2 py-1 <?= $badgeClass ?>" style="border-radius:6px; font-size:11px;">
                                    <?= $statusLabel ?>
                                </span>
                            </td>
                            <td class="text-muted" style="font-size:12px;"><?= date('d M Y', strtotime($p['created_at'])) ?></td>
                            <td class="text-center">
                                <?php if ($status === 'Approved' && $progress == 75): ?>
                                    <!-- Terbitkan SKT -->
                                    <button class="btn btn-sm btn-primary" onclick="openModalSkt('<?= $p['id'] ?>', '<?= esc($p['nama_ormas']) ?>', '<?= esc($p['tipe_ormas'] ?? 'Lokal') ?>')"
                                        style="font-size:12px; padding:4px 10px;">
                                        <i class="fa-solid fa-stamp me-1"></i>Terbitkan <?= $isLokal ? 'Tanggapan' : 'Surat Keberadaan' ?>
                                    </button>
                                    <button class="btn btn-sm btn-outline-danger ms-1" onclick="openModalTolak('<?= $p['id'] ?>', '<?= esc($p['nama_ormas']) ?>')"
                                        style="font-size:12px; padding:4px 10px;">
                                        <i class="fa-solid fa-xmark"></i>
                                    </button>

                                <?php elseif (in_array($status, ['Pending']) && $progress < 75): ?>
                                    <!-- Validasi Berkas -->
                                    <?php $confirmMsg = $isLokal ? 'Laporan Tanggapan Keberadaan' : 'Surat Keberadaan'; ?>
                                    <form method="POST" action="<?= base_url('bidang/proses-pendaftaran/' . $p['id'] . '/approve_bidang') ?>"
                                        style="display:inline;"
                                        onsubmit="return confirm('Validasi berkas ormas ini ke tahap penerbitan <?= $confirmMsg ?>?')">
                                        <?= csrf_field() ?>
                                        <button type="submit" class="btn btn-sm btn-success" style="font-size:12px; padding:4px 10px;">
                                            <i class="fa-solid fa-check me-1"></i>Validasi
                                        </button>
                                    </form>
                                    <button class="btn btn-sm btn-outline-danger ms-1" onclick="openModalTolak('<?= $p['id'] ?>', '<?= esc($p['nama_ormas']) ?>')"
                                        style="font-size:12px; padding:4px 10px;">
                                        <i class="fa-solid fa-xmark"></i>
                                    </button>
                                <?php endif; ?>

                                <button type="button" class="btn btn-sm ms-1" style="font-size:12px; padding:4px 8px; background:rgba(255,255,255,.06); color:var(--text-muted);" 
                                    onclick="openModalLihatBerkas('<?= esc($p['file_berkas'] ?? '{}', 'attr') ?>', '<?= esc($p['tipe_ormas'] ?? 'Lokal') ?>')" title="Lihat Berkas">
                                    <i class="fa-solid fa-eye"></i>
                                </button>

                                <?php if (!empty($p['pdf_tte_path'])): ?>
                                    <a href="<?= base_url('uploads/rekomendasi_ormas/' . $p['pdf_tte_path']) ?>" target="_blank"
                                        class="btn btn-sm ms-1" style="font-size:12px; padding:4px 8px; background:rgba(99,102,241,.12); color:#818cf8;" title="Unduh <?= $isLokal ? 'Laporan Tanggapan' : 'Surat Keberadaan' ?>">
                                        <i class="fa-solid fa-file-arrow-down"></i>
                                    </a>
                                <?php endif; ?>

                                <!-- Tombol Hapus Permanen (Semua State) -->
                                <form method="POST" action="<?= base_url('bidang/proses-pendaftaran/' . $p['id'] . '/delete') ?>"
                                    style="display:inline;"
                                    onsubmit="return confirm('Apakah Anda yakin ingin menghapus pendaftaran ormas <?= esc($p['nama_ormas']) ?> secara permanen? Seluruh berkas fisik di server juga akan terhapus. Tindakan ini tidak dapat dibatalkan.')">
                                    <?= csrf_field() ?>
                                    <button type="submit" class="btn btn-sm btn-outline-danger ms-1" style="font-size:12px; padding:4px 8px;" title="Hapus Pendaftaran">
                                        <i class="fa-solid fa-trash-can"></i>
                                    </button>
                                </form>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                    </tbody>
                </table>
            </div>
            <?php endif; ?>
        </div>
    </div>
</div>

<!-- Modal Terbitkan SKT -->
<div class="modal fade" id="modalTerbitkanSkt" tabindex="-1" aria-labelledby="modalSktLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content" style="background:var(--card-bg); border:1px solid var(--border-color);">
            <div class="modal-header border-0">
                <h5 class="modal-title text-white font-heading" id="modalSktLabel"><i class="fa-solid fa-stamp text-primary me-2"></i><span id="sktLabelText">Terbitkan Dokumen</span></h5>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
            </div>
            <form id="formTerbitkanSkt" method="POST" enctype="multipart/form-data">
                <?= csrf_field() ?>
                <div class="modal-body">
                    <p class="text-muted small mb-3">Unggah dokumen <b id="sktDocName">Surat Keterangan</b> resmi yang telah ditandatangani untuk ormas: <span id="sktNamaOrmas" class="text-white fw-semibold"></span></p>
                    <div class="mb-3">
                        <label class="form-label text-muted small" id="sktFileInputLabel">File Dokumen (PDF/Gambar) <span class="text-danger">*</span></label>
                        <input type="file" name="berkas_skt" id="berkas_skt" class="form-control" accept=".pdf,.jpg,.jpeg,.png,.webp" required
                             style="background:var(--input-bg); border:1px solid var(--border-color); color:var(--text-main);">
                        <div class="form-text text-muted">Maks. 5MB. Format: PDF, JPG, PNG, WebP.</div>
                    </div>
                </div>
                <div class="modal-footer border-0 pt-0">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                    <button type="submit" class="btn btn-primary"><i class="fa-solid fa-paper-plane me-1"></i>Terbitkan & Kirim</button>
                </div>
            </form>
        </div>
    </div>
</div>

<!-- Modal Tolak Pendaftaran -->
<div class="modal fade" id="modalTolakPendaftaran" tabindex="-1" aria-labelledby="modalTolakLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content" style="background:var(--card-bg); border:1px solid var(--border-color);">
            <div class="modal-header border-0">
                <h5 class="modal-title text-white font-heading" id="modalTolakLabel"><i class="fa-solid fa-circle-xmark text-danger me-2"></i>Tolak Pendaftaran</h5>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
            </div>
            <form id="formTolakPendaftaran" method="POST">
                <?= csrf_field() ?>
                <div class="modal-body">
                    <p class="text-muted small mb-3">Tolak pendaftaran ormas: <span id="tolakNamaOrmas" class="text-white fw-semibold"></span></p>
                    <div class="mb-3">
                        <label class="form-label text-muted small">Alasan Penolakan <span class="text-danger">*</span></label>
                        <textarea name="alasan_ditolak" rows="3" class="form-control" placeholder="Tuliskan alasan penolakan berkas..." required
                            style="background:var(--input-bg); border:1px solid var(--border-color); color:var(--text-main);"></textarea>
                    </div>
                </div>
                <div class="modal-footer border-0 pt-0">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                    <button type="submit" class="btn btn-danger"><i class="fa-solid fa-xmark me-1"></i>Konfirmasi Tolak</button>
                </div>
            </form>
        </div>
    </div>
</div>

<!-- Modal Lihat Berkas -->
<div class="modal fade" id="modalLihatBerkas" tabindex="-1" aria-labelledby="modalLihatBerkasLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg modal-dialog-centered">
        <div class="modal-content" style="background:var(--card-bg); border:1px solid var(--border-color);">
            <div class="modal-header border-0">
                <h5 class="modal-title text-white font-heading" id="modalLihatBerkasLabel"><i class="fa-solid fa-folder-open text-info me-2"></i>Berkas Persyaratan Ormas</h5>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body p-0">
                <div class="table-responsive">
                    <table class="table table-custom mb-0 text-white" style="font-size: 0.85rem;">
                        <thead>
                            <tr style="background: rgba(255, 255, 255, 0.02);">
                                <th class="text-center" style="width: 5%;">#</th>
                                <th style="width: 55%;">Jenis Dokumen</th>
                                <th class="text-center" style="width: 15%;">Ukuran</th>
                                <th class="text-center" style="width: 25%;">Tautan</th>
                            </tr>
                        </thead>
                        <tbody id="berkas-list-container">
                            <!-- Populated by JS -->
                        </tbody>
                    </table>
                </div>
            </div>
            <div class="modal-footer border-0">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Tutup</button>
            </div>
        </div>
    </div>
</div>

<?= $this->endSection() ?>

<?= $this->section('scripts') ?>
<script>
    // ===== Requirements Lists for Berkas Modal =====
    const requirementsLokal = [
        { name: "Surat Permohonan", desc: "Surat Permohonan ditujukan kepada Menteri (Cq. Kaban Kesbangpol)" },
        { name: "AD & ART", desc: "Anggaran Dasar (AD) & Anggaran Rumah Tangga (ART)" },
        { name: "Akta Notaris", desc: "Akta Pendirian Notaris" },
        { name: "Surat Pernyataan Keabsahan", desc: "Surat Pernyataan Keabsahan Dokumen (Meterai Rp 10.000)" },
        { name: "Program & Struktur Kerja", desc: "Program Kerja Organisasi & Struktur Organisasi Resmi" },
        { name: "Domisili Kantor", desc: "Surat Keterangan Domisili Kantor Sekretariat" },
        { name: "NPWP Organisasi", desc: "NPWP atas nama Organisasi" },
        { name: "Formulir Isian Data Ormas", desc: "Formulir Isian Data Ormas (Ketua & Sekretaris)" },
        { name: "Rekomendasi Kementerian", desc: "Surat Rekomendasi Kementerian Agama (Ormas Agama) / Kebudayaan" },
        { name: "Biodata & KTP Pengurus", desc: "Biodata & KTP Pengurus", isPengurus: true },
        { name: "Pasfoto Pengurus", desc: "Pasfoto Pengurus 4x6 cm 2 Lembar (Latar Merah)", isPengurus: true },
        { name: "SK & Foto Sekretariat", desc: "SK Pengurus & Foto Sekretariat (Papan Nama)" },
        { name: "Kontrak/Izin Pakai Gedung", desc: "Surat Perjanjian Kontrak/Izin Pakai Gedung Sekretariat" },
        { name: "Rekening & Logo Organisasi", desc: "Nomor Rekening Organisasi & File Logo Organisasi" }
    ];

    const requirementsBerjenjang = [
        { name: "Surat Permohonan", desc: "Surat Permohonan ditujukan kepada Kepala Badan Kesbangpol Kab. Sinjai" },
        { name: "Surat Pernyataan Resmi", desc: "Surat Pernyataan Resmi (Memuat 6 poin pernyataan, Meterai Rp 10.000)" },
        { name: "SK Kemenkumham", desc: "Surat Keputusan (SK) Kemenkumham RI" },
        { name: "Surat Keterangan Domisili", desc: "Surat Keterangan Domisili (Alamat domisili kop surat & sekretariat)" },
        { name: "Formulir Isian Data Ormas", desc: "Formulir Isian Data Ormas" },
        { name: "Pasfoto Pengurus", desc: "Pasfoto Pengurus ukuran 4x6 cm sebanyak 2 lembar", isPengurus: true },
        { name: "Fotokopi KTP Pengurus", desc: "Fotokopi KTP Pengurus", isPengurus: true },
        { name: "Surat Keputusan (SK) Pengurus", desc: "Surat Keputusan (SK) Pengurus Organisasi" },
        { name: "Foto Sekretariat", desc: "Foto Sekretariat (Tampak depan menampilkan Papan Nama resmi)" },
        { name: "Dokumen Pendukung Tambahan", desc: "Dokumen pendukung legalitas tambahan lainnya (ZIP/PDF)" }
    ];

    function openModalLihatBerkas(fileBerkasJson, tipe) {
        let files = {};
        try {
            const txt = document.createElement("textarea");
            txt.innerHTML = fileBerkasJson;
            files = JSON.parse(txt.value || '{}');
        } catch (e) {
            console.error("Error parsing berkas JSON", e);
        }
        
        const activeReqs = tipe === 'Lokal' ? requirementsLokal : requirementsBerjenjang;
        const listContainer = document.getElementById('berkas-list-container');
        listContainer.innerHTML = '';

        activeReqs.forEach((req, idx) => {
            if (req.isPengurus) return; // Skip pengurus berkas
            const fileIdx = idx + 1;
            const fileInfo = files[fileIdx];
            
            const tr = document.createElement('tr');
            let fileActionHtml = '<span class="text-danger small"><i class="fa-solid fa-circle-xmark me-1"></i> Belum Diunggah</span>';
            if (fileInfo && fileInfo.filename) {
                fileActionHtml = `<a href="<?= base_url('uploads/ormas/') ?>/${fileInfo.filename}" target="_blank" class="btn btn-xs btn-outline-info text-white"><i class="fa-solid fa-eye me-1"></i> Buka File</a>`;
            }

            tr.innerHTML = `
                <td class="text-center align-middle">${fileIdx}</td>
                <td class="align-middle">
                    <div class="fw-bold text-white small">${req.name}</div>
                    <div class="text-muted" style="font-size: 0.72rem;">${req.desc}</div>
                </td>
                <td class="text-center align-middle small text-muted">${fileInfo ? fileInfo.size : '-'}</td>
                <td class="text-center align-middle">${fileActionHtml}</td>
            `;
            listContainer.appendChild(tr);
        });

        new bootstrap.Modal(document.getElementById('modalLihatBerkas')).show();
    }

    // ===== Modal Helpers =====
    function openModalSkt(id, namaOrmas, tipe) {
        const docTitle = (tipe === 'Lokal') ? 'Laporan Tanggapan Keberadaan' : 'Surat Keberadaan';
        document.getElementById('sktLabelText').textContent = 'Terbitkan ' + docTitle;
        document.getElementById('sktDocName').textContent = docTitle;
        document.getElementById('sktFileInputLabel').textContent = 'File ' + docTitle + ' (PDF/Gambar)';
        document.getElementById('sktNamaOrmas').textContent = namaOrmas;
        document.getElementById('formTerbitkanSkt').action = `<?= base_url('bidang/proses-pendaftaran/') ?>${id}/terbitkan_skt`;
        new bootstrap.Modal(document.getElementById('modalTerbitkanSkt')).show();
    }

    function openModalTolak(id, namaOrmas) {
        document.getElementById('tolakNamaOrmas').textContent = namaOrmas;
        document.getElementById('formTolakPendaftaran').action = `<?= base_url('bidang/proses-pendaftaran/') ?>${id}/reject`;
        new bootstrap.Modal(document.getElementById('modalTolakPendaftaran')).show();
    }
</script>
<?= $this->endSection() ?>
