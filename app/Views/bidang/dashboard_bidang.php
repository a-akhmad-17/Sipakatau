<?= $this->extend('layouts/admin') ?>

<?= $this->section('styles') ?>
<link rel="stylesheet" href="https://unpkg.com/leaflet@1.9.4/dist/leaflet.css" crossorigin="" />
<link rel="stylesheet" href="https://unpkg.com/leaflet.markercluster@1.4.1/dist/MarkerCluster.css" />
<link rel="stylesheet" href="https://unpkg.com/leaflet.markercluster@1.4.1/dist/MarkerCluster.Default.css" />
<style>
    .bidang-header {
        background: linear-gradient(135deg, rgba(59, 130, 246, 0.1) 0%, rgba(37, 99, 235, 0.05) 100%);
        border: 1px solid var(--border-color);
        border-radius: 12px;
        padding: 24px;
        margin-bottom: 30px;
    }
    /* Leaflet styling override to fit dark mode */
    .leaflet-container { background: #0b0f19 !important; }
    .leaflet-popup-content-wrapper, .leaflet-popup-tip {
        background: var(--card-bg) !important;
        color: var(--text-main) !important;
        border: 1px solid var(--border-color) !important;
    }
    .leaflet-bar { border: 1px solid var(--border-color) !important; }
    .leaflet-bar a {
        background-color: var(--card-bg) !important;
        color: var(--text-main) !important;
        border-bottom: 1px solid var(--border-color) !important;
    }
    .leaflet-bar a:hover { background-color: var(--input-bg) !important; }
    @keyframes pulse {
        0%   { transform: scale(0.9); box-shadow: 0 0 0 0 rgba(239, 68, 68, 0.7); }
        70%  { transform: scale(1.1); box-shadow: 0 0 0 10px rgba(239, 68, 68, 0); }
        100% { transform: scale(0.9); box-shadow: 0 0 0 0 rgba(239, 68, 68, 0); }
    }
    .animate-pulse { animation: pulse 1.5s infinite; }
    .glow-ormas    { background-color: #3b82f6 !important; box-shadow: 0 0 10px #3b82f6 !important; }
    .glow-parpol   { background-color: #fbbf24 !important; box-shadow: 0 0 10px #fbbf24 !important; }
    .glow-pengaduan { background-color: #ef4444 !important; box-shadow: 0 0 10px #ef4444 !important; }
    .glow-rekomendasi { background-color: #a855f7 !important; box-shadow: 0 0 10px #a855f7 !important; }

    /* SKT Panel */
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
        <p class="text-muted small mb-0">Selamat bekerja, <b><?= esc(ucfirst(session()->get('username'))) ?></b> • Hari ini: <b><?= date('d M Y') ?></b></p>
    </div>
</div>

<!-- ===== PANEL KELOLA PENDAFTARAN SKT — Hanya Poldagri ===== -->
<?php if ($isPoldagri): ?>
<?php
    $totalSkt    = count($pendaftaran);
    $menugggu    = count(array_filter($pendaftaran, fn($p) => in_array($p['status_verifikasi'], ['New','Pending']) && $p['progress_percentage'] < 75));
    $perluSkt    = count(array_filter($pendaftaran, fn($p) => $p['status_verifikasi'] === 'Approved' && $p['progress_percentage'] == 75));
    $selesai     = count(array_filter($pendaftaran, fn($p) => $p['progress_percentage'] == 100));
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
            <div class="text-muted small mt-1"><i class="fa-solid fa-stamp text-primary me-1"></i>Siap Terbitkan Dokumen</div>
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

            <?php if (session()->getFlashdata('success')): ?>
                <div class="alert alert-success border-0 mb-3" style="background:rgba(34,197,94,.12); color:#4ade80; border-radius:8px;">
                    <i class="fa-solid fa-circle-check me-2"></i><?= session()->getFlashdata('success') ?>
                </div>
            <?php endif; ?>
            <?php if (session()->getFlashdata('error')): ?>
                <div class="alert alert-danger border-0 mb-3" style="background:rgba(239,68,68,.12); color:#f87171; border-radius:8px;">
                    <i class="fa-solid fa-triangle-exclamation me-2"></i><?= session()->getFlashdata('error') ?>
                </div>
            <?php endif; ?>

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
                        $status    = $p['status_verifikasi'] ?? 'New';
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
                                <?php if ($progress === 100 || $status === 'Rejected'): ?>
                                    <!-- Selesai / Ditolak — no action -->
                                    <span class="text-muted" style="font-size:11px;">—</span>

                                <?php elseif ($status === 'Approved' && $progress === 75): ?>
                                    <!-- Terbitkan SKT -->
                                    <button class="btn btn-sm btn-primary" onclick="openModalSkt('<?= $p['id'] ?>', '<?= esc($p['nama_ormas']) ?>', '<?= esc($p['tipe_ormas'] ?? 'Lokal') ?>')"
                                        style="font-size:12px; padding:4px 10px;">
                                        <i class="fa-solid fa-stamp me-1"></i>Terbitkan <?= $isLokal ? 'Tanggapan' : 'Surat Keberadaan' ?>
                                    </button>
                                    <button class="btn btn-sm btn-outline-danger ms-1" onclick="openModalTolak('<?= $p['id'] ?>', '<?= esc($p['nama_ormas']) ?>')"
                                        style="font-size:12px; padding:4px 10px;">
                                        <i class="fa-solid fa-xmark"></i>
                                    </button>

                                <?php elseif (in_array($status, ['New', 'Pending'])): ?>
                                    <!-- Validasi Berkas -->
                                    <form method="POST" action="<?= base_url('bidang/proses-pendaftaran/' . $p['id'] . '/approve_bidang') ?>"
                                        style="display:inline;"
                                        onsubmit="return confirm('Validasi berkas ormas ini ke tahap penerbitan <?= $isLokal ? 'Laporan Tanggapan' : 'Surat Keberadaan' ?>?')">
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

                                <?php if (!empty($p['file_berkas'])): ?>
                                    <a href="<?= base_url('uploads/berkas_ormas/' . $p['file_berkas']) ?>" target="_blank"
                                        class="btn btn-sm ms-1" style="font-size:12px; padding:4px 8px; background:rgba(255,255,255,.06); color:var(--text-muted);" title="Lihat Berkas">
                                        <i class="fa-solid fa-eye"></i>
                                    </a>
                                <?php endif; ?>

                                <?php if (!empty($p['pdf_tte_path'])): ?>
                                    <a href="<?= base_url('uploads/rekomendasi_ormas/' . $p['pdf_tte_path']) ?>" target="_blank"
                                        class="btn btn-sm ms-1" style="font-size:12px; padding:4px 8px; background:rgba(99,102,241,.12); color:#818cf8;" title="Unduh <?= $isLokal ? 'Laporan Tanggapan' : 'Surat Keberadaan' ?>">
                                        <i class="fa-solid fa-file-arrow-down"></i>
                                    </a>
                                <?php endif; ?>
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
<?php endif; ?>

<!-- Peta GIS & Sebaran Wilayah -->
<div class="row g-4">
    <div class="col-12">
        <div class="glass-card p-4">
            <div class="d-flex flex-column flex-sm-row justify-content-between align-items-sm-center gap-3 mb-4">
                <div>
                    <h4 class="text-white mb-1 font-heading"><i class="fa-solid fa-map-location-dot text-danger me-2"></i>Peta Geografis & Monitoring Wilayah</h4>
                    <p class="text-muted small mb-0">Pemetaan interaktif wilayah Kabupaten Sinjai untuk koordinasi bidang Kesbangpol, titik ormas, parpol, dan laporan pengaduan masyarakat.</p>
                </div>
                <div class="d-flex align-items-center gap-2">
                    <label class="text-white small mb-0 fw-semibold" style="white-space: nowrap;"><i class="fa-solid fa-filter text-danger me-1"></i>Filter:</label>
                    <!-- Filter Tahun -->
                    <select id="filter-tahun" class="form-select form-control-custom py-1 px-2.5 text-white bg-dark border-secondary border-opacity-25" style="border-radius: 6px; width: 95px; cursor: pointer; font-size: 0.75rem; background-color: rgba(0,0,0,0.5);">
                        <option value="all">Semua Thn</option>
                        <?php
                        $startYear = 2024;
                        if (!empty($ormas)) {
                            foreach ($ormas as $o) {
                                if (!empty($o['tgl_sk_kepengurusan'])) {
                                    $y = (int)date('Y', strtotime($o['tgl_sk_kepengurusan']));
                                    if ($y > 2000 && $y < $startYear) {
                                        $startYear = $y;
                                    }
                                }
                            }
                        }
                        $currentYear = (int)date('Y');
                        $endYear = $currentYear + 1;
                        for ($y = $startYear; $y <= $endYear; $y++):
                        ?>
                            <option value="<?php echo $y; ?>" <?php echo ($y == $currentYear) ? 'selected' : ''; ?>><?php echo $y; ?></option>
                        <?php endfor; ?>
                    </select>
                    <!-- Filter Bulan -->
                    <select id="filter-bulan" class="form-select form-control-custom py-1 px-2.5 text-white bg-dark border-secondary border-opacity-25" style="border-radius: 6px; width: 110px; cursor: pointer; font-size: 0.75rem; background-color: rgba(0,0,0,0.5);">
                        <option value="all" selected>Semua Bln</option>
                        <option value="1">Januari</option>
                        <option value="2">Februari</option>
                        <option value="3">Maret</option>
                        <option value="4">April</option>
                        <option value="5">Mei</option>
                        <option value="6">Juni</option>
                        <option value="7">Juli</option>
                        <option value="8">Agustus</option>
                        <option value="9">September</option>
                        <option value="10">Oktober</option>
                        <option value="11">November</option>
                        <option value="12">Desember</option>
                    </select>
                </div>
            </div>
            <div id="gis-map" style="height: 480px; border-radius: 12px; border: 1px solid var(--border-color); width: 100%; position: relative; overflow: hidden;"></div>
        </div>
    </div>
</div>

<?= $this->endSection() ?>

<?= $this->section('scripts') ?>
<script src="https://unpkg.com/leaflet@1.9.4/dist/leaflet.js" crossorigin=""></script>
<script src="https://unpkg.com/leaflet.markercluster@1.4.1/dist/leaflet.markercluster.js"></script>
<script>
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

    // ===== GIS Map =====
    document.addEventListener("DOMContentLoaded", function() {
        const osm = L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
            maxZoom: 19, attribution: '© OpenStreetMap contributors'
        });
        const satellite = L.tileLayer('https://server.arcgisonline.com/ArcGIS/rest/services/World_Imagery/MapServer/tile/{z}/{y}/{x}', {
            maxZoom: 19, attribution: 'Tiles &copy; Esri'
        });
        const terrain = L.tileLayer('https://{s}.tile.opentopomap.org/{z}/{x}/{y}.png', {
            maxZoom: 17, attribution: 'Map data: &copy; OpenStreetMap contributors'
        });

        let map = L.map('gis-map', { center: [-5.1489, 120.1294], zoom: 11, layers: [osm] });

        const baseMaps = {
            "Peta Standar (OSM)": osm,
            "Satelit (Esri)": satellite,
            "Topografi (TopoMap)": terrain
        };

        function getCoordinates(id) {
            const idStr = String(id || '');
            let hash = 0;
            for (let i = 0; i < idStr.length; i++) hash = idStr.charCodeAt(i) + ((hash << 5) - hash);
            return [-5.1489 + (Math.abs(hash % 150) / 1000) - 0.075, 120.1294 + (Math.abs((hash >> 8) % 150) / 1000) - 0.075];
        }

        const createGlowIcon = (colorClass, size = 12) => L.divIcon({
            className: 'custom-glow-icon',
            html: `<div class="glow-marker ${colorClass}" style="width:${size}px;height:${size}px;border-radius:50%;border:2px solid #fff;"></div>`,
            iconSize: [size, size], iconAnchor: [size / 2, size / 2]
        });

        const officeIcon = L.divIcon({
            className: 'custom-glow-icon-office',
            html: `<div style="width:16px;height:16px;border-radius:50%;border:2px solid #fff;box-shadow:0 0 15px #be123c;background:#be123c;"></div>`,
            iconSize: [16, 16], iconAnchor: [8, 8]
        });

        const ormasIcon    = createGlowIcon('glow-ormas', 12);
        const parpolIcon   = createGlowIcon('glow-parpol', 12);
        const pengaduanIcon = createGlowIcon('glow-pengaduan', 12);

        const getHotspotIcon = (level) => {
            let color = level === 'Tinggi' ? '#ef4444' : (level === 'Sedang' ? '#f59e0b' : '#fbbf24');
            return L.divIcon({
                className: 'custom-glow-icon-hotspot',
                html: `<div class="glow-marker animate-pulse" style="width:14px;height:14px;border-radius:50%;border:2px solid #fff;box-shadow:0 0 15px ${color};background:${color};"></div>`,
                iconSize: [14, 14], iconAnchor: [7, 7]
            });
        };

        let officeGroup   = L.layerGroup().addTo(map);
        let ormasGroup    = L.markerClusterGroup().addTo(map);
        let parpolGroup   = L.layerGroup().addTo(map);
        let pengaduanGroup = L.layerGroup().addTo(map);
        let hotspotGroup  = L.layerGroup().addTo(map);

        L.marker([-5.1326246, 120.2500688], {icon: officeIcon}).addTo(officeGroup)
            .bindPopup('<b>Badan Kesbangpol Sinjai</b><br>Pusat Koordinasi Layanan & Keamanan.');

        // 4. Pengaduan, Rekomendasi & Hotspots data
        const ormas = <?= json_encode($ormas ?? []) ?>;
        const parpol = <?= json_encode($parpol ?? []) ?>;
        const pengaduan = <?= json_encode($pengaduan ?? []) ?>;
        const rekomendasi = <?= json_encode($rekomendasi ?? []) ?>;
        const hotspots = <?= json_encode($hotspots ?? []) ?>;
        const rekomendasiIcon = createGlowIcon('glow-rekomendasi', 12);
        let rekomendasiGroup = L.layerGroup().addTo(map);

        function renderFilteredData(year, month) {
            ormasGroup.clearLayers();
            parpolGroup.clearLayers();
            pengaduanGroup.clearLayers();
            hotspotGroup.clearLayers();
            rekomendasiGroup.clearLayers();

            // Helper function to match year & month
            function matchDate(dateStr, selYear, selMonth) {
                if (!dateStr) return false;
                const dateObj = new Date(dateStr);
                if (isNaN(dateObj.getTime())) return false;
                
                const yearMatch = (selYear === 'all') || (dateObj.getFullYear() == selYear);
                const monthMatch = (selMonth === 'all') || ((dateObj.getMonth() + 1) == selMonth);
                return yearMatch && monthMatch;
            }

            // Plot Ormas
            ormas.forEach(o => {
                let dateToMatch = o.tgl_sk_kepengurusan || o.created_at;
                if (matchDate(dateToMatch, year, month)) {
                    let coords = (o.latitude && o.longitude) ? [parseFloat(o.latitude), parseFloat(o.longitude)] : getCoordinates(o.id);
                    L.marker(coords, {icon: ormasIcon}).addTo(ormasGroup)
                        .bindPopup(`<b>Ormas: ${o.nama_ormas}</b><br>Alamat: ${o.alamat}<br>Status: <span class="badge bg-success">${o.status}</span><br>Tgl SK Kepengurusan: ${o.tgl_sk_kepengurusan || '-'}`)
                        .on('click', e => map.flyTo(e.latlng, 15, {animate: true, duration: 1.2}));
                }
            });

            // Plot Parpol
            parpol.forEach(p => {
                if (matchDate(p.created_at, year, month)) {
                    let coords = (p.latitude && p.longitude) ? [parseFloat(p.latitude), parseFloat(p.longitude)] : getCoordinates(p.id);
                    let dewanInfo = p.has_kursi == 1 ? `<br>Representasi: Punya Kursi DPRD (${p.level_dewan || '-'} • Periode ${p.periode_dewan || '-'})` : '<br>Representasi: Tidak Ada Kursi';
                    L.marker(coords, {icon: parpolIcon}).addTo(parpolGroup)
                        .bindPopup(`<b>Parpol: ${p.nama_parpol}</b><br>Ketua: ${p.ketua}<br>Kontak: ${p.telepon}${dewanInfo}<br>Terdaftar: ${p.created_at || '-'}`)
                        .on('click', e => map.flyTo(e.latlng, 15, {animate: true, duration: 1.2}));
                }
            });

            // Plot Pengaduan
            pengaduan.forEach(p => {
                try {
                    let detail = JSON.parse(p.after_data);
                    if (detail && matchDate(p.created_at, year, month)) {
                        let coords = getCoordinates(p.id);
                        L.marker(coords, {icon: pengaduanIcon}).addTo(pengaduanGroup)
                            .bindPopup(`<b>Aduan: ${detail.judul || 'Tanpa Judul'}</b><br>Kategori: ${detail.kategori || 'Lainnya'}<br>Tanggal: ${p.created_at}`)
                            .on('click', e => map.flyTo(e.latlng, 15, {animate: true, duration: 1.2}));
                    }
                } catch(e) {}
            });

            // Plot Hotspots (Conflict zones)
            hotspots.forEach(h => {
                if (matchDate(h.created_at, year, month)) {
                    L.marker([h.latitude, h.longitude], {icon: getHotspotIcon(h.level)}).addTo(hotspotGroup)
                        .bindPopup(`<b>Titik Konflik: ${h.nama}</b><br>Tingkat: <span class="badge bg-danger">${h.level}</span><br>${h.deskripsi}<br>Tanggal: ${h.created_at || '-'}`)
                        .on('click', e => map.flyTo(e.latlng, 15, {animate: true, duration: 1.2}));
                }
            });

            // Plot Rekomendasi
            rekomendasi.forEach(r => {
                if (matchDate(r.created_at, year, month)) {
                    let coords = getCoordinates(r.id);
                    L.marker(coords, {icon: rekomendasiIcon}).addTo(rekomendasiGroup)
                        .bindPopup(`<b>Rekomendasi: ${r.nama_kegiatan}</b><br>Pemohon: ${r.pemohon}<br>Lokasi: ${r.lokasi_kegiatan || '-'}<br>Waktu: ${r.tgl_mulai} s/d ${r.tgl_selesai}<br>Status: <span class="badge" style="background-color: #a855f7; color: #fff;">${r.status_rekomendasi}</span>`)
                        .on('click', e => map.flyTo(e.latlng, 15, {animate: true, duration: 1.2}));
                }
            });
        }

        // Initial filter values trigger
        const filterTahunSelect = document.getElementById('filter-tahun');
        const filterBulanSelect = document.getElementById('filter-bulan');

        function triggerFilter() {
            const yr = filterTahunSelect ? filterTahunSelect.value : '2026';
            const mn = filterBulanSelect ? filterBulanSelect.value : 'all';
            renderFilteredData(yr, mn);
        }

        if (filterTahunSelect && filterBulanSelect) {
            triggerFilter();
            filterTahunSelect.addEventListener('change', triggerFilter);
            filterBulanSelect.addEventListener('change', triggerFilter);
        } else {
            renderFilteredData('2026', 'all');
        }

        const overlayMaps = {
            "<span style='color:var(--text-main);'><i class='fa-solid fa-building-shield text-danger me-1'></i>Kantor Kesbangpol</span>": officeGroup,
            "<span style='color:var(--text-main);'><i class='fa-solid fa-users text-primary me-1'></i>Organisasi Ormas</span>": ormasGroup,
            "<span style='color:var(--text-main);'><i class='fa-solid fa-building-flag text-warning me-1'></i>Partai Politik</span>": parpolGroup,
            "<span style='color:var(--text-main);'><i class='fa-solid fa-bullhorn text-danger me-1'></i>Aduan Masyarakat</span>": pengaduanGroup,
            "<span style='color:var(--text-main);'><i class='fa-solid fa-calendar-check me-1' style='color:#a855f7;'></i>Rekomendasi Kegiatan</span>": rekomendasiGroup,
            "<span style='color:var(--text-main);'><i class='fa-solid fa-triangle-exclamation text-warning me-1'></i>Titik Rawan Konflik</span>": hotspotGroup
        };
        L.control.layers(baseMaps, overlayMaps, {collapsed: false, position: 'topright'}).addTo(map);
    });
</script>
<?= $this->endSection() ?>
