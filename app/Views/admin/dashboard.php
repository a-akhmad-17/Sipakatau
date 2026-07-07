<?= $this->extend('layouts/admin') ?>

<?= $this->section('styles') ?>
<link rel="stylesheet" href="https://unpkg.com/leaflet@1.9.4/dist/leaflet.css" crossorigin="" />
<link rel="stylesheet" href="https://unpkg.com/leaflet.markercluster@1.4.1/dist/MarkerCluster.css" />
<link rel="stylesheet" href="https://unpkg.com/leaflet.markercluster@1.4.1/dist/MarkerCluster.Default.css" />
<style>
    .admin-header {
        background: linear-gradient(135deg, rgba(79, 70, 229, 0.1) 0%, rgba(59, 130, 246, 0.05) 100%);
        border: 1px solid var(--border-color);
        border-radius: 12px;
        padding: 24px;
        margin-bottom: 30px;
    }

    .nav-tabs-custom {
        border-bottom: 1px solid var(--border-color);
    }

    .nav-tabs-custom .nav-link {
        color: var(--text-muted);
        border: none;
        border-bottom: 2px solid transparent;
        padding: 12px 20px;
        font-weight: 500;
        transition: all 0.3s;
    }

    .nav-tabs-custom .nav-link:hover {
        color: var(--text-main);
        border-bottom-color: var(--border-color);
    }

    .nav-tabs-custom .nav-link.active {
        color: #60a5fa;
        background: none;
        border-bottom-color: #60a5fa;
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

    /* Warning Indicator: Baris Merah jika SK Kedaluwarsa */
    .row-expired {
        background-color: var(--row-expired-bg) !important;
        border-left: 4px solid #ef4444 !important;
    }

    .badge-expired {
        background: var(--badge-danger-bg) !important;
        color: var(--badge-danger-color) !important;
        border: 1px solid var(--badge-danger-border) !important;
    }

    .badge-active {
        background: var(--badge-realisasi-bg) !important;
        color: var(--badge-realisasi-color) !important;
        border: 1px solid var(--badge-realisasi-border) !important;
    }

    .btn-toggle-active {
        background: var(--badge-realisasi-bg);
        color: var(--badge-realisasi-color);
        border: 1px solid var(--badge-realisasi-border);
    }

    .btn-toggle-inactive {
        background: var(--badge-danger-bg);
        color: var(--badge-danger-color);
        border: 1px solid var(--badge-danger-border);
    }

    /* Kanban Tracking */
    .kanban-col {
        background: var(--input-bg);
        border: 1px solid var(--border-color);
        border-radius: 12px;
        padding: 20px;
        min-height: 400px;
    }

    .kanban-card {
        background: var(--card-bg);
        border: 1px solid var(--border-color);
        border-radius: 8px;
        padding: 15px;
        margin-bottom: 12px;
        cursor: pointer;
        transition: all 0.3s;
    }

    .kanban-card:hover {
        border-color: rgba(96, 165, 250, 0.4);
        transform: translateY(-2px);
    }

    /* Leaflet styling override to fit dark mode */
    .leaflet-container {
        background: #0b0f19 !important;
    }
    .leaflet-popup-content-wrapper, .leaflet-popup-tip {
        background: var(--card-bg) !important;
        color: var(--text-main) !important;
        border: 1px solid var(--border-color) !important;
    }
    .leaflet-bar {
        border: 1px solid var(--border-color) !important;
    }
    .leaflet-bar a {
        background-color: var(--card-bg) !important;
        color: var(--text-main) !important;
        border-bottom: 1px solid var(--border-color) !important;
    }
    .leaflet-bar a:hover {
        background-color: var(--input-bg) !important;
    }
    @keyframes pulse {
        0% {
            transform: scale(0.9);
            box-shadow: 0 0 0 0 rgba(239, 68, 68, 0.7);
        }
        70% {
            transform: scale(1.1);
            box-shadow: 0 0 0 10px rgba(239, 68, 68, 0);
        }
        100% {
            transform: scale(0.9);
            box-shadow: 0 0 0 0 rgba(239, 68, 68, 0);
        }
    }
    .animate-pulse {
        animation: pulse 1.5s infinite;
    }
    .glow-ormas { background-color: #3b82f6 !important; box-shadow: 0 0 10px #3b82f6 !important; }
    .glow-parpol { background-color: #fbbf24 !important; box-shadow: 0 0 10px #fbbf24 !important; }
    .glow-pengaduan { background-color: #ef4444 !important; box-shadow: 0 0 10px #ef4444 !important; }
    .hotspot-item {
        transition: all 0.2s ease;
    }
    .hotspot-item:hover {
        background: var(--border-color) !important;
        transform: translateX(4px);
    }
    .btn-filter-custom {
        background: var(--card-bg) !important;
        color: var(--text-muted) !important;
        border: 1px solid var(--border-color) !important;
        transition: all 0.3s ease;
        font-weight: 500;
    }
    .btn-filter-custom:hover {
        background: var(--border-color) !important;
        color: var(--text-main) !important;
    }
    .btn-filter-custom.active {
        background: #0dcaf0 !important;
        color: #000 !important;
        border-color: #0dcaf0 !important;
        font-weight: bold;
    }
</style>
<?= $this->endSection() ?>

<?= $this->section('content') ?>

<!-- Dashboard Admin Header -->
<div class="admin-header d-flex justify-content-between align-items-center gap-3">
    <div>
        <h2 class="text-white fw-bold mb-1"><i class="fa-solid fa-chart-pie text-primary me-2"></i>Dashboard OPD & Kinerja</h2>
        <p class="text-muted small mb-0">Selamat datang kembali, <b><?= esc(ucfirst(session()->get('username'))) ?></b> • Hari ini: <b><?= date('d M Y') ?></b></p>
    </div>
</div>



<!-- Info Cards Row -->
<div class="row g-4 mb-5">
    <div class="col-md-6 col-lg-4">
        <div class="glass-card p-3 text-start">
            <div class="text-muted small">Total Ormas Aktif</div>
            <h2 class="text-white fw-bold mt-1 mb-0">
                <?php
                    $activeCount = 0;
                    foreach ($ormas as $o) {
                        if ($o['status'] === 'Aktif') $activeCount++;
                    }
                    echo $activeCount;
                ?>
            </h2>
            <div class="small text-muted mt-2">Dari total <?= count($ormas) ?> ormas terdaftar</div>
        </div>
    </div>
    
    <div class="col-md-6 col-lg-4">
        <div class="glass-card p-3 text-start">
            <div class="text-muted small">Ormas SK Merah</div>
            <h2 class="text-danger fw-bold mt-1 mb-0">
                <?php
                    $expiredCount = 0;
                    foreach ($ormas as $o) {
                        if ($o['tgl_sk_kedaluwarsa'] && $o['tgl_sk_kedaluwarsa'] < $today) $expiredCount++;
                    }
                    echo $expiredCount;
                ?>
            </h2>
            <div class="small text-danger-light mt-2"><i class="fa-solid fa-circle-exclamation me-1"></i>Butuh Pembinaan SK</div>
        </div>
    </div>

    <div class="col-md-6 col-lg-4">
        <div class="glass-card p-3 text-start">
            <div class="text-muted small">Database Partai Politik</div>
            <h2 class="text-white fw-bold mt-1 mb-0"><?= count($parpol) ?> Parpol</h2>
            <div class="small text-muted mt-2">Terdaftar tingkat Kabupaten</div>
        </div>
    </div>
</div>

<!-- Tabs Navigation (Hidden, controlled via sidebar) -->
<ul class="nav nav-tabs nav-tabs-custom mb-4 d-none" id="adminTabs" role="tablist">
    <li class="nav-item">
        <button class="nav-link active" id="ormas-tab" data-bs-toggle="tab" data-bs-target="#tab-ormas" type="button" role="tab"><i class="fa-solid fa-users me-2"></i>Manajemen Ormas</button>
    </li>
    <li class="nav-item">
        <button class="nav-link" id="parpol-tab" data-bs-toggle="tab" data-bs-target="#tab-parpol" type="button" role="tab"><i class="fa-solid fa-building-flag me-2"></i>Partai Politik</button>
    </li>
    <li class="nav-item">
        <button class="nav-link" id="tracking-tab" data-bs-toggle="tab" data-bs-target="#tab-tracking" type="button" role="tab"><i class="fa-solid fa-route me-2"></i>Tracking Berkas</button>
    </li>
    <li class="nav-item">
        <button class="nav-link" id="gis-tab" data-bs-toggle="tab" data-bs-target="#tab-gis" type="button" role="tab"><i class="fa-solid fa-map-location-dot me-2"></i>Peta GIS & Konflik</button>
    </li>
    <li class="nav-item">
        <button class="nav-link" id="pengaduan-tab" data-bs-toggle="tab" data-bs-target="#tab-pengaduan" type="button" role="tab"><i class="fa-solid fa-bullhorn me-2"></i>Pengaduan</button>
    </li>
    <li class="nav-item">
        <button class="nav-link" id="antrean-tab" data-bs-toggle="tab" data-bs-target="#tab-antrean" type="button" role="tab"><i class="fa-solid fa-ticket me-2"></i>Antrean MPP</button>
    </li>
    <li class="nav-item">
        <button class="nav-link" id="persetujuan-tab" data-bs-toggle="tab" data-bs-target="#tab-persetujuan" type="button" role="tab">
            <i class="fa-solid fa-trash-can me-2"></i>Persetujuan Hapus
            <?php 
            $db = \Config\Database::connect();
            $countMintaHapus = $db->table('trn_pendaftaran')->where('delete_requested', 1)->countAllResults();
            if ($countMintaHapus > 0): ?>
                <span class="badge bg-danger ms-1"><?= $countMintaHapus ?></span>
            <?php endif; ?>
        </button>
    </li>

</ul>

<!-- Tabs Content -->
<div class="tab-content" id="adminTabsContent">
    
    <!-- Tab 1: Manajemen Ormas -->
    <div class="tab-pane fade show active" id="tab-ormas" role="tabpanel">
        <div class="glass-card p-4">
            <div class="d-flex justify-content-between align-items-center mb-4 flex-wrap gap-2">
                <h4 class="text-white mb-0"><i class="fa-solid fa-users text-primary me-2"></i>Daftar Organisasi Kemasyarakatan</h4>
                <button type="button" class="btn btn-primary text-white btn-sm px-3 py-2 rounded" data-bs-toggle="modal" data-bs-target="#modalTambahOrmas">
                    <i class="fa-solid fa-plus me-1"></i> Tambah Ormas
                </button>
            </div>

            <!-- Search & Filter Controls -->
            <div class="row g-3 mb-4 align-items-center">
                <!-- Search Box -->
                <div class="col-md-6 col-lg-5">
                    <div class="input-group">
                        <span class="input-group-text-custom">
                            <i class="fa-solid fa-magnifying-glass"></i>
                        </span>
                        <input type="text" id="search-ormas" class="form-control form-control-custom py-2" placeholder="Cari nama, alamat, email, atau telepon..." style="border-left: none !important; border-top-left-radius: 0; border-bottom-left-radius: 0;">
                        <button class="btn btn-outline-secondary border-secondary border-opacity-50 text-muted" type="button" id="btn-clear-search" style="display: none;">
                            <i class="fa-solid fa-xmark"></i>
                        </button>
                    </div>
                </div>
                <!-- Filter Pills -->
                <div class="col-md-6 col-lg-7 d-flex flex-wrap align-items-center gap-2">
                    <span class="text-muted small me-2"><i class="fa-solid fa-filter me-1"></i>Filter:</span>
                    <button type="button" class="btn btn-sm btn-outline-primary px-3 rounded-pill active btn-filter-pill" data-filter="all">Semua (<span id="count-all">0</span>)</button>
                    <button type="button" class="btn btn-sm btn-outline-success px-3 rounded-pill btn-filter-pill" data-filter="aktif">Aktif (<span id="count-aktif">0</span>)</button>
                    <button type="button" class="btn btn-sm btn-outline-danger px-3 rounded-pill btn-filter-pill" data-filter="expired">Kedaluwarsa (<span id="count-expired">0</span>)</button>
                    <button type="button" class="btn btn-sm btn-outline-warning px-3 rounded-pill btn-filter-pill" data-filter="yayasan">Yayasan (<span id="count-yayasan">0</span>)</button>
                    <button type="button" class="btn btn-sm btn-outline-info px-3 rounded-pill btn-filter-pill" data-filter="lsm">LSM/Lembaga (<span id="count-lsm">0</span>)</button>
                    <button type="button" class="btn btn-sm btn-outline-secondary text-white px-3 rounded-pill btn-filter-pill" data-filter="perkumpulan">Himpunan/Perkumpulan (<span id="count-perkumpulan">0</span>)</button>
                </div>
            </div>
            
            <div class="table-responsive">
                <table class="table table-custom rounded overflow-hidden">
                    <thead>
                        <tr>
                            <th>Nama Organisasi</th>
                            <th>Alamat & Kontak</th>
                            <th>Tgl SK Kepengurusan</th>
                            <th>Tgl Kedaluwarsa SK</th>
                            <th>Status Keaktifan</th>
                            <th class="text-center" style="width: 25%;">Aksi</th>
                        </tr>
                    </thead>
                    <tbody id="table-ormas-body">
                        <?php foreach ($ormas as $o): 
                            $isExpired = ($o['tgl_sk_kedaluwarsa'] && $o['tgl_sk_kedaluwarsa'] < $today);
                            
                            $namaLower = strtolower($o['nama_ormas']);
                            $tipe = 'lainnya';
                            if (strpos($namaLower, 'yayasan') !== false || strpos($namaLower, 'yppc') !== false || strpos($namaLower, 'panti') !== false) {
                                $tipe = 'yayasan';
                            } elseif (strpos($namaLower, 'lsm') !== false || strpos($namaLower, 'lembaga') !== false || strpos($namaLower, 'institut') !== false) {
                                $tipe = 'lsm';
                            } elseif (strpos($namaLower, 'himpunan') !== false || strpos($namaLower, 'ikatan') !== false || strpos($namaLower, 'persatuan') !== false || strpos($namaLower, 'serikat') !== false || strpos($namaLower, 'perkumpulan') !== false || strpos($namaLower, 'majelis') !== false || strpos($namaLower, 'komite') !== false || strpos($namaLower, 'gabungan') !== false) {
                                $tipe = 'perkumpulan';
                            }
                        ?>
                            <tr class="<?= $isExpired ? 'row-expired' : '' ?>"
                                data-status="<?= $o['status'] === 'Aktif' ? 'aktif' : 'nonaktif' ?>"
                                data-expired="<?= $isExpired ? 'expired' : 'valid' ?>"
                                data-nama="<?= esc(strtolower($o['nama_ormas'])) ?>"
                                data-alamat="<?= esc(strtolower($o['alamat'])) ?>"
                                data-email="<?= esc(strtolower($o['email'])) ?>"
                                data-telepon="<?= esc(strtolower($o['telepon'])) ?>"
                                data-tipe="<?= $tipe ?>">
                                <td>
                                    <div class="fw-bold text-main"><?= esc($o['nama_ormas']) ?></div>
                                    <span class="small text-muted">ID: <?= substr($o['id'], 0, 8) ?>...</span>
                                </td>
                                <td>
                                    <div class="small"><i class="fa-solid fa-location-dot text-muted me-1"></i><?= esc($o['alamat']) ?></div>
                                    <div class="small mt-1"><i class="fa-solid fa-envelope text-muted me-1"></i><?= esc($o['email']) ?> | <i class="fa-solid fa-phone text-muted me-1"></i><?= esc($o['telepon']) ?></div>
                                </td>
                                <td><?= !empty($o['tgl_sk_kepengurusan']) ? date('d M Y', strtotime($o['tgl_sk_kepengurusan'])) : '-' ?></td>
                                <td>
                                    <?php if (!empty($o['tgl_sk_kedaluwarsa'])): ?>
                                        <?php if ($isExpired): ?>
                                            <span class="badge badge-expired px-2.5 py-1.5"><i class="fa-solid fa-triangle-exclamation me-1"></i>Expired (<?= date('d/m/Y', strtotime($o['tgl_sk_kedaluwarsa'])) ?>)</span>
                                        <?php else: ?>
                                            <?= date('d M Y', strtotime($o['tgl_sk_kedaluwarsa'])) ?>
                                        <?php endif; ?>
                                    <?php else: ?>
                                        -
                                    <?php endif; ?>
                                </td>
                                <td>
                                    <span class="badge <?= $o['status'] === 'Aktif' ? 'badge-active' : 'badge-expired' ?> px-3 py-1.5"><?= $o['status'] ?></span>
                                </td>
                                <td class="text-center">
                                    <div class="d-flex justify-content-center flex-wrap gap-2">
                                        <button type="button" class="btn btn-sm btn-outline-info px-2.5 py-1.5 rounded btn-edit-lokasi" 
                                                data-id="<?= $o['id'] ?>" 
                                                data-nama="<?= esc($o['nama_ormas']) ?>" 
                                                data-lat="<?= $o['latitude'] ?? '' ?>" 
                                                data-lng="<?= $o['longitude'] ?? '' ?>"
                                                title="Tentukan Koordinat Peta">
                                            <i class="fa-solid fa-location-dot"></i> Lokasi
                                        </button>
                                        <button type="button" class="btn btn-sm btn-outline-warning px-2.5 py-1.5 rounded btn-edit-ormas"
                                                data-id="<?= $o['id'] ?>"
                                                data-nama="<?= esc($o['nama_ormas']) ?>"
                                                data-alamat="<?= esc($o['alamat']) ?>"
                                                data-email="<?= esc($o['email']) ?>"
                                                data-telepon="<?= esc($o['telepon']) ?>"
                                                data-status="<?= esc($o['status']) ?>"
                                                data-tgl-sk="<?= $o['tgl_sk_kepengurusan'] ?>"
                                                data-tgl-exp="<?= $o['tgl_sk_kedaluwarsa'] ?>"
                                                data-latitude="<?= $o['latitude'] ?? '' ?>"
                                                data-longitude="<?= $o['longitude'] ?? '' ?>"
                                                title="Edit Detail Ormas">
                                            <i class="fa-solid fa-pencil"></i> Edit
                                        </button>
                                        <form action="<?= base_url('admin/toggle-ormas/' . $o['id']) ?>" method="POST" class="d-inline" onsubmit="return confirm('Apakah Anda yakin ingin mengubah status keaktifan ormas ini?')">
                                            <?= csrf_field() ?>
                                            <?php if ($o['status'] === 'Aktif'): ?>
                                                <button type="submit" class="btn btn-toggle-inactive btn-sm px-2.5 py-1.5 rounded" title="Nonaktifkan status"><i class="fa-solid fa-toggle-on"></i></button>
                                            <?php else: ?>
                                                <button type="submit" class="btn btn-toggle-active btn-sm px-2.5 py-1.5 rounded" title="Aktifkan status"><i class="fa-solid fa-toggle-off"></i></button>
                                            <?php endif; ?>
                                        </form>
                                        <form action="<?= base_url('admin/delete-ormas/' . $o['id']) ?>" method="POST" class="d-inline" onsubmit="return confirm('Apakah Anda yakin ingin menghapus Ormas ini secara permanen beserta semua data pendaftarannya?')">
                                            <?= csrf_field() ?>
                                            <button type="submit" class="btn btn-sm btn-outline-danger px-2.5 py-1.5 rounded" title="Hapus Ormas"><i class="fa-solid fa-trash"></i> Hapus</button>
                                        </form>
                                    </div>
                                </td>
                            </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    <!-- Tab 2: Partai Politik -->
    <div class="tab-pane fade" id="tab-parpol" role="tabpanel">
        <div class="glass-card p-4">
            <div class="d-flex justify-content-between align-items-center mb-4 flex-wrap gap-2">
                <h4 class="text-white mb-0"><i class="fa-solid fa-building-flag text-warning me-2"></i>Database Partai Politik</h4>
                <button type="button" class="btn btn-warning text-white btn-sm px-3 py-2 rounded" data-bs-toggle="modal" data-bs-target="#modalTambahParpol">
                    <i class="fa-solid fa-plus me-1"></i> Tambah Parpol
                </button>
            </div>
            <div class="table-responsive">
                <table class="table table-custom rounded overflow-hidden">
                    <thead>
                        <tr>
                            <th>Lambang & Nama Partai</th>
                            <th>Ketua Pengurus</th>
                            <th>Alamat Kantor Cabang</th>
                            <th>Telepon / Kontak</th>
                            <th class="text-center">Berkas SK</th>
                            <th class="text-center" style="width: 25%;">Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($parpol as $p): ?>
                            <tr>
                                <td>
                                    <div class="d-flex align-items-center gap-3">
                                        <div class="bg-secondary rounded p-1 d-flex align-items-center justify-content-center" style="width: 40px; height: 40px; overflow: hidden;">
                                            <?php 
                                            $logoPath = 'uploads/parpol/' . $p['lambang'];
                                            $isImage = (!empty($p['lambang']) && preg_match('/\.(webp|jpg|jpeg|png|gif)$/i', $p['lambang']) && file_exists(ROOTPATH . 'public/' . $logoPath));
                                            if ($isImage): ?>
                                                <img src="<?= base_url($logoPath) ?>" style="width: 100%; height: 100%; object-fit: cover;">
                                            <?php else: ?>
                                                <i class="fa-solid fa-building-flag text-white"></i>
                                            <?php endif; ?>
                                        </div>
                                        <div class="fw-bold text-main"><?= esc($p['nama_parpol']) ?></div>
                                    </div>
                                </td>
                                <td><?= esc($p['ketua']) ?></td>
                                <td><i class="fa-solid fa-location-dot text-muted me-1"></i><?= esc($p['alamat']) ?></td>
                                <td><?= esc($p['telepon']) ?></td>
                                <td class="text-center">
                                    <?php if (!empty($p['file_sk'])): ?>
                                        <a href="<?= base_url('uploads/parpol/' . $p['file_sk']) ?>" target="_blank" class="btn btn-sm btn-outline-info px-3 py-1.5 rounded">
                                            <i class="fa-solid fa-file-shield me-1"></i> Buka Berkas SK
                                        </a>
                                    <?php else: ?>
                                        <span class="text-muted small">Tidak ada berkas SK</span>
                                    <?php endif; ?>
                                </td>
                                <td class="text-center">
                                    <div class="d-flex justify-content-center gap-2">
                                        <button type="button" class="btn btn-sm btn-outline-info px-2.5 py-1.5 rounded btn-edit-lokasi-parpol" 
                                                data-id="<?= $p['id'] ?>" 
                                                data-nama="<?= esc($p['nama_parpol']) ?>" 
                                                data-lat="<?= $p['latitude'] ?? '' ?>" 
                                                data-lng="<?= $p['longitude'] ?? '' ?>">
                                            <i class="fa-solid fa-location-dot"></i> Lokasi
                                        </button>
                                        <button type="button" class="btn btn-sm btn-outline-warning px-2.5 py-1.5 rounded btn-edit-parpol"
                                                data-id="<?= $p['id'] ?>"
                                                data-nama="<?= esc($p['nama_parpol']) ?>"
                                                data-ketua="<?= esc($p['ketua']) ?>"
                                                data-alamat="<?= esc($p['alamat']) ?>"
                                                data-telepon="<?= esc($p['telepon']) ?>"
                                                data-latitude="<?= $p['latitude'] ?? '' ?>"
                                                data-longitude="<?= $p['longitude'] ?? '' ?>">
                                            <i class="fa-solid fa-pencil"></i> Edit
                                        </button>
                                        <form action="<?= base_url('admin/delete-parpol/' . $p['id']) ?>" method="POST" onsubmit="return confirm('Apakah Anda yakin ingin menghapus partai politik ini?')">
                                            <?= csrf_field() ?>
                                            <button type="submit" class="btn btn-sm btn-outline-danger px-2.5 py-1.5 rounded"><i class="fa-solid fa-trash"></i> Hapus</button>
                                        </form>
                                    </div>
                                </td>
                            </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
    <!-- Tab 3: Tracking Berkas (Table View Only) -->
    <div class="tab-pane fade" id="tab-tracking" role="tabpanel">
        <div class="glass-card p-4">
            <div class="d-flex justify-content-between align-items-center mb-4 flex-wrap gap-3">
                <div>
                    <h4 class="text-white mb-1"><i class="fa-solid fa-route text-info me-2"></i>Pelacakan Progres Dokumen Layanan</h4>
                    <p class="text-muted small mb-0">Kelola dan pantau seluruh ajuan dokumen layanan pendaftaran ormas, rekomendasi kegiatan, serta laporan aduan masyarakat.</p>
                </div>
                <!-- Filter Buttons -->
                <div class="btn-group" role="group" aria-label="Filter Ajuan">
                    <button type="button" class="btn btn-sm btn-filter-custom active" id="btn-filter-all" onclick="filterTrackingTable('all', this)">
                        Semua Ajuan
                    </button>
                    <button type="button" class="btn btn-sm btn-filter-custom" id="btn-filter-ormas" onclick="filterTrackingTable('ormas', this)">
                        Pendaftaran Ormas
                    </button>
                    <button type="button" class="btn btn-sm btn-filter-custom" id="btn-filter-rekomendasi" onclick="filterTrackingTable('rekomendasi', this)">
                        Rekomendasi Kegiatan
                    </button>
                    <button type="button" class="btn btn-sm btn-filter-custom" id="btn-filter-aduan" onclick="filterTrackingTable('aduan', this)">
                        Aduan Masyarakat
                    </button>
                </div>
            </div>

            <div class="table-responsive">
                <table class="table table-custom rounded overflow-hidden" id="table-tracking-main" style="font-size: 0.85rem;">
                    <thead>
                        <tr>
                            <th class="text-center" style="width: 5%;">#</th>
                            <th style="width: 30%;">Pengaju / Lembaga / Pelapor</th>
                            <th class="text-center" style="width: 20%;">Jenis Layanan</th>
                            <th class="text-center" style="width: 15%;">Tanggal Masuk</th>
                            <th class="text-center" style="width: 15%;">Status / Progres</th>
                            <th class="text-center" style="width: 15%;">Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php 
                        $allAjuan = [];
                        
                        // 1. Add Ormas Pendaftaran
                        foreach ($pendaftaran as $p) {
                            $allAjuan[] = [
                                'type' => 'ormas',
                                'id' => $p['id'],
                                'title' => $p['nama_ormas'],
                                'sub_title' => 'Reg: ' . $p['nomor_registrasi'],
                                'created_at' => $p['created_at'],
                                'status' => $p['status_verifikasi'],
                                'progress' => $p['progress_percentage'],
                                'data' => $p
                            ];
                        }
                        
                        // 2. Add Rekomendasi Kegiatan
                        foreach ($rekomendasi as $r) {
                            $allAjuan[] = [
                                'type' => 'rekomendasi',
                                'id' => $r['id'],
                                'title' => $r['pemohon'],
                                'sub_title' => 'Kegiatan: ' . $r['nama_kegiatan'],
                                'created_at' => $r['created_at'],
                                'status' => $r['status_rekomendasi'],
                                'progress' => empty($r['pdf_tte_path']) ? 75 : 100,
                                'data' => $r
                            ];
                        }
                        
                        // 3. Add Aduan Masyarakat
                        foreach ($pengaduan as $ad) {
                            $det = json_decode($ad['after_data'], true) ?? [];
                            $allAjuan[] = [
                                'type' => 'aduan',
                                'id' => $ad['id'],
                                'title' => $det['judul'] ?? 'Aduan Anonim',
                                'sub_title' => 'Kategori: ' . ucfirst($det['kategori'] ?? 'Lainnya'),
                                'created_at' => $ad['created_at'],
                                'status' => 'Selesai',
                                'progress' => 100,
                                'data' => $ad
                            ];
                        }
                        
                        // Sort all by created_at DESC
                        usort($allAjuan, function($a, $b) {
                            return strcmp($b['created_at'], $a['created_at']);
                        });
                        ?>

                        <?php if (empty($allAjuan)): ?>
                            <tr>
                                <td colspan="6" class="text-center text-muted py-4">Belum ada pengajuan masuk.</td>
                            </tr>
                        <?php else: ?>
                            <?php foreach ($allAjuan as $idx => $aj): ?>
                                <tr class="tracking-row" data-type="<?= $aj['type'] ?>">
                                    <td class="text-center align-middle"><?= $idx + 1 ?></td>
                                    <td class="align-middle">
                                        <div class="fw-bold text-main"><?= esc($aj['title']) ?></div>
                                        <div class="text-warning small" style="font-size:0.75rem;"><?= esc($aj['sub_title']) ?></div>
                                    </td>
                                    <td class="text-center align-middle">
                                        <?php if ($aj['type'] === 'ormas'): ?>
                                            <span class="badge bg-secondary-subtle text-secondary px-2.5 py-1">Pendaftaran Ormas</span>
                                        <?php elseif ($aj['type'] === 'rekomendasi'): ?>
                                            <span class="badge bg-warning-subtle text-warning px-2.5 py-1">Rekomendasi Kegiatan</span>
                                        <?php else: ?>
                                            <span class="badge bg-danger-subtle text-danger px-2.5 py-1">Aduan Masyarakat</span>
                                        <?php endif; ?>
                                    </td>
                                    <td class="text-center align-middle text-muted small">
                                        <?= date('d M Y H:i', strtotime($aj['created_at'])) ?>
                                    </td>
                                    <td class="text-center align-middle">
                                        <?php if ($aj['type'] === 'ormas'): ?>
                                            <div class="d-flex flex-column align-items-center gap-1">
                                                <span class="badge bg-light-subtle text-white border border-secondary border-opacity-25 px-2 py-0.5" style="font-size:0.7rem;">
                                                    <?= esc($aj['status']) ?>
                                                </span>
                                                <span class="badge <?= ($aj['progress'] == 100) ? 'bg-success' : (($aj['progress'] >= 75) ? 'bg-primary' : (($aj['progress'] >= 50) ? 'bg-info' : 'bg-warning')) ?>" style="font-size:0.7rem;">
                                                    Progres: <?= $aj['progress'] ?>%
                                                </span>
                                            </div>
                                        <?php elseif ($aj['type'] === 'rekomendasi'): ?>
                                            <div class="d-flex flex-column align-items-center gap-1">
                                                <span class="badge <?= ($aj['status'] === 'Approved') ? 'bg-success-subtle text-success' : (($aj['status'] === 'Rejected') ? 'bg-danger-subtle text-danger' : 'bg-warning-subtle text-warning') ?> border px-2 py-0.5" style="font-size:0.7rem;">
                                                    <?= esc($aj['status']) ?>
                                                </span>
                                            </div>
                                        <?php else: ?>
                                            <span class="badge bg-success-subtle text-success px-2 py-0.5" style="font-size:0.7rem;">Diterima</span>
                                        <?php endif; ?>
                                    </td>
                                    <td class="text-center align-middle">
                                        <div class="d-flex justify-content-center gap-1.5">
                                            <button type="button" class="btn btn-sm btn-info text-white px-2.5 py-1 btn-detail-tracking" 
                                                    data-type="<?= $aj['type'] ?>"
                                                    data-id="<?= esc($aj['id']) ?>"
                                                    <?php if ($aj['type'] === 'ormas'): 
                                                        $d = $aj['data']; ?>
                                                        data-registrasi="<?= esc($d['nomor_registrasi']) ?>"
                                                        data-nama="<?= esc($d['nama_ormas']) ?>"
                                                        data-alamat="<?= esc($d['alamat']) ?>"
                                                        data-email="<?= esc($d['email']) ?>"
                                                        data-telepon="<?= esc($d['telepon']) ?>"
                                                        data-status="<?= esc($d['status_verifikasi']) ?>"
                                                        data-progress="<?= esc($d['progress_percentage']) ?>"
                                                        data-file="<?= esc($d['file_berkas'] ?? '') ?>" 
                                                        data-tipe-ormas="<?= esc($d['tipe_ormas'] ?? 'Lokal') ?>"
                                                        data-sk-kepengurusan="<?= !empty($d['tgl_sk_kepengurusan']) ? date('d F Y', strtotime($d['tgl_sk_kepengurusan'])) : '-' ?>" 
                                                        data-sk-kedaluwarsa="<?= !empty($d['tgl_sk_kedaluwarsa']) ? date('d F Y', strtotime($d['tgl_sk_kedaluwarsa'])) : '-' ?>"
                                                        data-tanggal="<?= date('d F Y H:i:s', strtotime($d['created_at'])) ?>"
                                                    <?php elseif ($aj['type'] === 'rekomendasi'): 
                                                        $d = $aj['data']; ?>
                                                        data-nama="<?= esc($d['pemohon']) ?>"
                                                        data-kegiatan="<?= esc($d['nama_kegiatan']) ?>"
                                                        data-deskripsi="<?= esc($d['deskripsi'] ?? '-') ?>"
                                                        data-status="<?= esc($d['status_rekomendasi']) ?>"
                                                        data-file="<?= esc($d['file_proposal'] ?? '') ?>" 
                                                        data-mulai="<?= date('d F Y', strtotime($d['tgl_mulai'])) ?>" 
                                                        data-selesai="<?= date('d F Y', strtotime($d['tgl_selesai'])) ?>"
                                                        data-tte="<?= esc($d['pdf_tte_path'] ?? '') ?>"
                                                        data-tanggal="<?= date('d F Y H:i:s', strtotime($d['created_at'])) ?>"
                                                    <?php else: 
                                                        $d = $aj['data']; 
                                                        $det = json_decode($d['after_data'], true) ?? []; ?>
                                                        data-nama="Anonim / Pelapor"
                                                        data-judul="<?= esc($det['judul'] ?? 'Tanpa Judul') ?>"
                                                        data-kategori="<?= esc($det['kategori'] ?? 'Lainnya') ?>"
                                                        data-bidang="<?= esc($det['nama_bidang'] ?? 'Umum') ?>"
                                                        data-deskripsi="<?= esc($det['deskripsi'] ?? '-') ?>"
                                                        data-file="<?= esc($det['berkas'] ?? '') ?>"
                                                        data-tanggal="<?= date('d F Y H:i:s', strtotime($d['created_at'])) ?>"
                                                    <?php endif; ?>>
                                                <i class="fa-solid fa-list-check me-1"></i> Detail
                                            </button>
                                            <?php if ($aj['type'] === 'ormas'): ?>
                                                <form action="<?= base_url('admin/delete-pendaftaran/' . $aj['id']) ?>" method="POST" class="d-inline" onsubmit="return confirm('Hapus berkas pendaftaran Ormas ini secara permanen?')">
                                                    <?= csrf_field() ?>
                                                    <button type="submit" class="btn btn-sm btn-outline-danger px-2.5 py-1" title="Hapus"><i class="fa-solid fa-trash"></i></button>
                                                </form>
                                            <?php elseif ($aj['type'] === 'rekomendasi'): ?>
                                                <form action="<?= base_url('admin/delete-rekomendasi/' . $aj['id']) ?>" method="POST" class="d-inline" onsubmit="return confirm('Hapus berkas rekomendasi kegiatan ini secara permanen?')">
                                                    <?= csrf_field() ?>
                                                    <button type="submit" class="btn btn-sm btn-outline-danger px-2.5 py-1" title="Hapus"><i class="fa-solid fa-trash"></i></button>
                                                </form>
                                            <?php else: ?>
                                                <form action="<?= base_url('admin/delete-pengaduan/' . $aj['id']) ?>" method="POST" class="d-inline" onsubmit="return confirm('Hapus laporan pengaduan ini secara permanen?')">
                                                    <?= csrf_field() ?>
                                                    <button type="submit" class="btn btn-sm btn-outline-danger px-2.5 py-1" title="Hapus"><i class="fa-solid fa-trash"></i></button>
                                                </form>
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

    <!-- Tab 4: Peta GIS & Laporan Konflik -->
    <div class="tab-pane fade" id="tab-gis" role="tabpanel">
        <div class="glass-card p-4">
            <h4 class="text-white mb-2"><i class="fa-solid fa-map-location-dot text-danger me-2"></i>Peta Geografis & Pemetaan Titik Konflik / Kerawanan</h4>
            <p class="text-muted small mb-4">Pemetaan sebaran titik ormas, partai politik, aduan masyarakat, dan deteksi rawan gesekan sosial/konflik di Kabupaten Sinjai. Klik pada peta untuk memilih koordinat secara otomatis.</p>
            
            <div class="row g-4">
                <!-- Map Area -->
                <div class="col-lg-8">
                    <div id="gis-map" style="height: 520px; border-radius: 12px; border: 1px solid var(--border-color); position: relative; overflow: hidden; width: 100%;"></div>
                </div>
                
                <!-- Sidebar Control & Input -->
                <div class="col-lg-4">
                    <!-- Form Tambah -->
                    <div class="p-3 rounded mb-4" style="background: var(--input-bg); border: 1px solid var(--border-color);">
                        <h5 class="text-white fw-bold mb-3 small"><i class="fa-solid fa-square-plus text-primary me-2"></i>Tambah Titik Kerawanan</h5>
                        <form action="<?= base_url('admin/tambah-hotspot') ?>" method="POST" id="formHotspot">
                            <?= csrf_field() ?>
                            <div class="mb-2">
                                <label class="form-label small text-muted mb-1">Nama Lokasi / Daerah *</label>
                                <input type="text" name="nama" id="h_nama" class="form-control form-control-custom form-control-sm py-2" placeholder="Nama daerah / lokasi konflik" required>
                            </div>
                            <div class="row g-2 mb-2">
                                <div class="col-6">
                                    <label class="form-label small text-muted mb-1">Latitude *</label>
                                    <input type="number" step="any" name="latitude" id="h_lat" class="form-control form-control-custom form-control-sm py-2" placeholder="-5.1234" required readonly>
                                </div>
                                <div class="col-6">
                                    <label class="form-label small text-muted mb-1">Longitude *</label>
                                    <input type="number" step="any" name="longitude" id="h_lng" class="form-control form-control-custom form-control-sm py-2" placeholder="120.1234" required readonly>
                                </div>
                            </div>
                            <div class="mb-2">
                                <label class="form-label small text-muted mb-1">Tingkat Kerawanan *</label>
                                <select name="level" class="form-select form-control-custom form-control-sm py-2" required>
                                    <option value="Tinggi">Tinggi (Merah Pulsing)</option>
                                    <option value="Sedang">Sedang (Oranye)</option>
                                    <option value="Rendah">Rendah (Kuning)</option>
                                </select>
                            </div>
                            <div class="mb-3">
                                <label class="form-label small text-muted mb-1">Deskripsi Kerawanan / Potensi Konflik</label>
                                <textarea name="deskripsi" id="h_desc" rows="2" class="form-control form-control-custom form-control-sm" placeholder="Tulis rincian gesekan sosial..."></textarea>
                            </div>
                            <div class="d-grid">
                                <button type="submit" class="btn btn-sm btn-primary py-2"><i class="fa-solid fa-floppy-disk me-1"></i> Simpan Titik</button>
                            </div>
                        </form>
                    </div>
                    
                    <!-- List Active Hotspots -->
                    <div class="p-3 rounded" style="background: var(--input-bg); border: 1px solid var(--border-color); max-height: 200px; overflow-y: auto;">
                        <h5 class="text-white fw-bold mb-3 small d-flex justify-content-between align-items-center">
                            <span><i class="fa-solid fa-list text-warning me-2"></i>Daftar Titik Aktif</span>
                            <span class="badge bg-danger text-white" style="font-size:0.7rem;"><?= count($settings['titik_kerawanan'] ?? []) ?> Titik</span>
                        </h5>
                        
                        <?php if (empty($settings['titik_kerawanan'])): ?>
                            <div class="text-muted small text-center py-2">Belum ada titik kerawanan resmi.</div>
                        <?php else: ?>
                            <div class="d-flex flex-column gap-2">
                                <?php foreach ($settings['titik_kerawanan'] as $h): 
                                    $lblClass = $h['level'] === 'Tinggi' ? 'bg-danger text-white' : ($h['level'] === 'Sedang' ? 'bg-warning text-dark' : 'bg-info text-dark');
                                ?>
                                    <div class="d-flex justify-content-between align-items-center p-2 rounded hotspot-item" style="background: var(--card-bg); border: 1px solid var(--border-color); cursor: pointer;" onclick="focusHotspot('<?= esc($h['id']) ?>')">
                                        <div class="min-w-0 flex-grow-1">
                                            <div class="fw-bold text-main small text-truncate"><?= esc($h['nama']) ?></div>
                                            <div class="text-muted" style="font-size: 0.7rem;"><?= esc($h['level']) ?> • <?= esc($h['latitude']) ?>, <?= esc($h['longitude']) ?></div>
                                        </div>
                                        <form action="<?= base_url('admin/delete-hotspot/' . $h['id']) ?>" method="POST" onsubmit="event.stopPropagation(); return confirm('Hapus titik kerawanan ini?')">
                                            <?= csrf_field() ?>
                                            <button type="submit" class="btn btn-sm btn-outline-danger p-1 py-0.5" style="font-size:0.75rem;" onclick="event.stopPropagation();"><i class="fa-solid fa-trash"></i></button>
                                        </form>
                                    </div>
                                <?php endforeach; ?>
                            </div>
                        <?php endif; ?>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Tab 5: Laporan Pengaduan Masyarakat -->
    <div class="tab-pane fade" id="tab-pengaduan" role="tabpanel">
        <div class="glass-card p-4">
            <h4 class="text-white mb-4"><i class="fa-solid fa-bullhorn text-danger me-2"></i>Daftar Laporan Pengaduan Masyarakat</h4>
            
            <div class="table-responsive">
                <table class="table table-custom rounded overflow-hidden">
                    <thead>
                        <tr>
                            <th style="width: 15%;">Tanggal Masuk</th>
                            <th style="width: 20%;">Judul & Kategori</th>
                            <th style="width: 15%;">Ditujukan Ke</th>
                            <th style="width: 25%;">Isi Pengaduan</th>
                            <th style="width: 13%;" class="text-center">Lampiran</th>
                            <th style="width: 12%;" class="text-center">Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php if (empty($pengaduan)): ?>
                            <tr>
                                <td colspan="6" class="text-center text-muted">Belum ada aduan masuk.</td>
                            </tr>
                        <?php else: ?>
                            <?php foreach ($pengaduan as $p): 
                                $detail = json_decode($p['after_data'], true) ?? [];
                                $katLabels = [
                                    'konflik' => ['label' => 'Konflik Sosial SARA', 'class' => 'bg-danger-subtle text-danger border border-danger-subtle'],
                                    'ormas' => ['label' => 'Ketertiban Ormas/LSM', 'class' => 'bg-warning-subtle text-warning border border-warning-subtle'],
                                    'politik' => ['label' => 'Pelanggaran Politik', 'class' => 'bg-primary-subtle text-primary border border-primary-subtle'],
                                    'layanan' => ['label' => 'Keluhan Layanan', 'class' => 'bg-info-subtle text-info border border-info-subtle'],
                                    'lainnya' => ['label' => 'Lainnya', 'class' => 'bg-secondary-subtle text-secondary border border-secondary-subtle'],
                                ];
                                $kat = $detail['kategori'] ?? 'lainnya';
                                $badge = $katLabels[$kat] ?? $katLabels['lainnya'];
                            ?>
                                <tr>
                                    <td>
                                        <div class="text-white small"><?= date('d M Y', strtotime($p['created_at'])) ?></div>
                                        <div class="text-muted small" style="font-size:0.75rem;"><?= date('H:i', strtotime($p['created_at'])) ?> WITA</div>
                                    </td>
                                    <td>
                                        <span class="badge <?= $badge['class'] ?> mb-1" style="font-size:0.75rem;"><?= $badge['label'] ?></span>
                                        <div class="fw-bold text-main"><?= esc($detail['judul'] ?? 'Tanpa Judul') ?></div>
                                    </td>
                                    <td>
                                        <div class="text-main small"><i class="fa-solid fa-building me-1 text-muted"></i><?= esc($detail['nama_bidang'] ?? 'Umum / Seluruhnya') ?></div>
                                    </td>
                                    <td>
                                        <p class="small text-muted mb-0" style="white-space: pre-line; line-height: 1.5; max-height: 100px; overflow-y: auto;">
                                            <?= esc($detail['deskripsi'] ?? '-') ?>
                                        </p>
                                    </td>
                                    <td class="text-center">
                                        <?php if (!empty($detail['berkas'])): ?>
                                            <div class="d-flex flex-column gap-2 align-items-center">
                                                <a href="<?= base_url('uploads/pengaduan/' . $detail['berkas']) ?>" target="_blank" class="btn btn-sm btn-outline-info px-2 py-1 rounded d-inline-block text-nowrap" style="font-size:0.75rem;">
                                                    <i class="fa-solid fa-file-pdf me-1"></i> Buka Bukti
                                                </a>
                                                <form action="<?= base_url('admin/delete-file-pengaduan/' . $p['id']) ?>" method="POST" onsubmit="return confirm('Hapus berkas bukti lampiran aduan ini?')">
                                                    <?= csrf_field() ?>
                                                    <button type="submit" class="btn btn-xs btn-outline-danger px-1 py-0.5 rounded text-nowrap" style="font-size:0.65rem;">
                                                        <i class="fa-solid fa-trash-can me-1"></i> Hapus File
                                                    </button>
                                                </form>
                                            </div>
                                        <?php else: ?>
                                            <span class="text-muted small">Tidak ada</span>
                                        <?php endif; ?>
                                    </td>
                                    <td class="text-center">
                                        <form action="<?= base_url('admin/delete-pengaduan/' . $p['id']) ?>" method="POST" onsubmit="return confirm('Hapus seluruh laporan aduan ini secara permanen?')">
                                            <?= csrf_field() ?>
                                            <button type="submit" class="btn btn-sm btn-outline-danger px-2.5 py-1.5 rounded"><i class="fa-solid fa-trash"></i> Hapus</button>
                                        </form>
                                    </td>
                                </tr>
                            <?php endforeach; ?>
                        <?php endif; ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    <!-- Tab Antrean MPP -->
    <div class="tab-pane fade" id="tab-antrean" role="tabpanel">
        <div class="glass-card p-4">
            <div class="d-flex justify-content-between align-items-center mb-4">
                <div>
                    <h4 class="text-white mb-1"><i class="fa-solid fa-ticket text-info me-2"></i>Daftar Antrean MPP Hari Ini</h4>
                    <p class="text-muted small mb-0">Kelola dan proses nomor antrean pelayanan Mal Pelayanan Publik (MPP) Kesbangpol secara real-time.</p>
                </div>
                <span class="badge bg-info-subtle text-info border border-info-subtle px-3 py-2 rounded-pill font-heading" style="font-size:0.8rem;">
                    Tanggal: <?= date('d M Y') ?>
                </span>
            </div>

            <div class="table-responsive">
                <table class="table table-custom rounded overflow-hidden">
                    <thead>
                        <tr>
                            <th class="text-center" style="width: 15%;">Nomor Antrean</th>
                            <th style="width: 25%;">Identitas Pemohon</th>
                            <th style="width: 25%;">Keperluan Layanan</th>
                            <th style="width: 15%;">Waktu Pengambilan</th>
                            <th class="text-center" style="width: 10%;">Status</th>
                            <th class="text-center" style="width: 10%;">Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php if (empty($antrean)): ?>
                            <tr>
                                <td colspan="6" class="text-center text-muted py-4 small">Belum ada antrean yang masuk hari ini.</td>
                            </tr>
                        <?php else: ?>
                            <?php foreach ($antrean as $a): 
                                $statusBadge = 'bg-warning-subtle text-warning border-warning-subtle';
                                if ($a['status'] === 'Dilayani') {
                                    $statusBadge = 'bg-success-subtle text-success border-success-subtle';
                                } elseif ($a['status'] === 'Selesai') {
                                    $statusBadge = 'bg-info-subtle text-info border-info-subtle';
                                } elseif ($a['status'] === 'Lewat') {
                                    $statusBadge = 'bg-danger-subtle text-danger border-danger-subtle';
                                }

                                $layName = 'Konsultasi / Umum';
                                if ($a['layanan'] === 'ormas') {
                                    $layName = 'Pendaftaran Ormas / LSM';
                                } elseif ($a['layanan'] === 'rekomendasi') {
                                    $layName = 'Rekomendasi Kegiatan';
                                }
                            ?>
                                <tr>
                                    <td class="text-center">
                                        <div class="display-6 fw-bold text-main mb-0" style="font-size: 1.5rem; font-family: 'Outfit', sans-serif;"><?= esc($a['nomor_antrean']) ?></div>
                                    </td>
                                    <td>
                                        <div class="fw-bold text-main"><?= esc($a['nama_pengambil']) ?></div>
                                        <span class="small text-muted">NIK: <?= esc($a['nik']) ?></span>
                                    </td>
                                    <td>
                                        <span class="small text-muted"><i class="fa-solid fa-circle-info text-info me-1"></i><?= $layName ?></span>
                                    </td>
                                    <td>
                                        <div class="text-main small"><?= date('H:i', strtotime($a['created_at'])) ?> WITA</div>
                                    </td>
                                    <td class="text-center">
                                        <span class="badge <?= $statusBadge ?> px-3 py-1.5 rounded-pill"><?= esc($a['status']) ?></span>
                                    </td>
                                    <td class="text-center">
                                        <div class="d-flex justify-content-center gap-1">
                                            <?php if ($a['status'] === 'Menunggu' || $a['status'] === 'Lewat'): ?>
                                                <form action="<?= base_url('admin/antrean/panggil/' . $a['id']) ?>" method="POST">
                                                    <?= csrf_field() ?>
                                                    <button type="submit" class="btn btn-sm btn-success px-2.5 py-1.5" title="Panggil Antrean"><i class="fa-solid fa-volume-high"></i> Panggil</button>
                                                </form>
                                            <?php elseif ($a['status'] === 'Dilayani'): ?>
                                                <form action="<?= base_url('admin/antrean/selesai/' . $a['id']) ?>" method="POST" class="d-inline">
                                                    <?= csrf_field() ?>
                                                    <button type="submit" class="btn btn-sm btn-primary px-2.5 py-1.5" title="Selesai Pelayanan"><i class="fa-solid fa-circle-check"></i> Selesai</button>
                                                </form>
                                                <form action="<?= base_url('admin/antrean/lewat/' . $a['id']) ?>" method="POST" class="d-inline">
                                                    <?= csrf_field() ?>
                                                    <button type="submit" class="btn btn-sm btn-danger px-2.5 py-1.5" title="Lewatkan Antrean"><i class="fa-solid fa-circle-arrow-right"></i> Lewat</button>
                                                </form>
                                            <?php else: ?>
                                                <span class="text-muted small">-</span>
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

    <!-- Tab Persetujuan Hapus -->
    <div class="tab-pane fade" id="tab-persetujuan" role="tabpanel">
        <div class="glass-card p-4">
            <div class="d-flex justify-content-between align-items-center mb-4">
                <div>
                    <h4 class="text-white mb-1"><i class="fa-solid fa-trash-can text-danger me-2"></i>Persetujuan Penghapusan Ormas</h4>
                    <p class="text-muted small mb-0">Daftar pengajuan penghapusan data Ormas/pendaftaran yang diajukan oleh pengguna atau admin. Aksi di bawah ini memerlukan persetujuan akhir.</p>
                </div>
            </div>

            <div class="table-responsive">
                <table class="table table-custom rounded overflow-hidden">
                    <thead>
                        <tr>
                            <th class="text-center" style="width: 15%;">No. Registrasi</th>
                            <th style="width: 25%;">Nama Ormas</th>
                            <th style="width: 25%;">Alamat</th>
                            <th style="width: 15%;">Tanggal Pengajuan</th>
                            <th class="text-center" style="width: 20%;">Aksi Persetujuan</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php 
                        $db = \Config\Database::connect();
                        $requestHapus = $db->table('trn_pendaftaran')
                                           ->select('trn_pendaftaran.*, mst_ormas.nama_ormas, mst_ormas.alamat')
                                           ->join('mst_ormas', 'mst_ormas.id = trn_pendaftaran.ormas_id', 'left')
                                           ->where('trn_pendaftaran.delete_requested', 1)
                                           ->get()
                                           ->getResultArray();
                        if (empty($requestHapus)): ?>
                            <tr>
                                <td colspan="5" class="text-center text-muted py-4 small">Tidak ada permintaan penghapusan berkas ormas yang perlu disetujui saat ini.</td>
                            </tr>
                        <?php else: ?>
                            <?php foreach ($requestHapus as $rh): ?>
                                <tr>
                                    <td class="text-center fw-semibold text-warning"><?= esc($rh['nomor_registrasi']) ?></td>
                                    <td class="text-main fw-bold"><?= esc($rh['nama_ormas']) ?></td>
                                    <td class="text-muted small"><?= esc($rh['alamat']) ?></td>
                                    <td><?= date('d M Y H:i', strtotime($rh['updated_at'] ?: $rh['created_at'])) ?></td>
                                    <td class="text-center">
                                        <div class="d-flex justify-content-center gap-2">
                                            <form action="<?= base_url('admin/proses-pendaftaran/setujui-hapus/' . $rh['id']) ?>" method="POST" class="d-inline" onsubmit="return confirm('Apakah Anda yakin ingin MENYETUJUI penghapusan Ormas ini secara permanen dari database?')">
                                                <?= csrf_field() ?>
                                                <button type="submit" class="btn btn-sm btn-danger px-2.5 py-1.5"><i class="fa-solid fa-check me-1"></i> Setujui Hapus</button>
                                            </form>
                                            <form action="<?= base_url('admin/proses-pendaftaran/tolak-hapus/' . $rh['id']) ?>" method="POST" class="d-inline" onsubmit="return confirm('Apakah Anda yakin ingin membatalkan/menolak penghapusan Ormas ini?')">
                                                <?= csrf_field() ?>
                                                <button type="submit" class="btn btn-sm btn-outline-secondary px-2.5 py-1.5"><i class="fa-solid fa-xmark me-1"></i> Batal</button>
                                            </form>
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



<!-- Modal Edit Lokasi Coordinate Picker -->
<div class="modal fade" id="modalEditLokasi" tabindex="-1" aria-labelledby="modalEditLokasiLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg modal-dialog-centered">
        <div class="modal-content glass-card-modal animate-fade-in" style="background: var(--bg-color) !important; border: 1px solid var(--border-color) !important; color: var(--text-main) !important; border-radius: 16px;">
            <div class="modal-header border-secondary border-opacity-25" style="border-bottom: 1px solid var(--border-color) !important;">
                <h5 class="modal-title font-heading" id="modalEditLokasiLabel"><i class="fa-solid fa-map-location-dot text-info me-2"></i>Edit Titik Koordinat Ormas</h5>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form action="<?= base_url('admin/update-koordinat-ormas') ?>" method="POST" id="formEditLokasi">
                    <?= csrf_field() ?>
                    <input type="hidden" name="ormas_id" id="edit_ormas_id">
                    
                    <div class="mb-3">
                        <label class="form-label small text-muted">Nama Organisasi</label>
                        <input type="text" id="edit_ormas_nama" class="form-control form-control-custom" readonly style="opacity: 0.85;">
                    </div>

                    <div class="row g-3 mb-3">
                        <div class="col-sm-6">
                            <label for="edit_latitude" class="form-label small text-muted">Latitude (Lintang/Selatan)</label>
                            <input type="number" step="any" name="latitude" id="edit_latitude" class="form-control form-control-custom" placeholder="Contoh: -5.1489" required>
                        </div>
                        <div class="col-sm-6">
                            <label for="edit_longitude" class="form-label small text-muted">Longitude (Bujur Timur)</label>
                            <input type="number" step="any" name="longitude" id="edit_longitude" class="form-control form-control-custom" placeholder="Contoh: 120.1294" required>
                        </div>
                    </div>

                    <p class="text-muted small mb-2"><i class="fa-solid fa-circle-info text-info me-1"></i>Klik pada peta di bawah ini untuk menandai lokasi yang tepat secara dinamis, atau geser (drag) penanda biru ke tempat yang benar.</p>
                    <div id="picker-map" style="height: 380px; border-radius: 10px; border: 1px solid var(--border-color); margin-bottom: 15px; width: 100%;"></div>

                    <div class="d-flex justify-content-between align-items-center mt-4">
                        <button type="button" class="btn btn-outline-danger btn-sm" id="btnResetKoordinat"><i class="fa-solid fa-trash me-1"></i> Kosongkan Koordinat</button>
                        <div class="d-flex gap-2">
                            <button type="button" class="btn btn-secondary text-white" data-bs-dismiss="modal">Batal</button>
                            <button type="submit" class="btn btn-info text-white fw-bold"><i class="fa-solid fa-floppy-disk me-1"></i> Simpan Lokasi</button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

<!-- Modal Tambah Ormas -->
<div class="modal fade" id="modalTambahOrmas" tabindex="-1" aria-labelledby="modalTambahOrmasLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg modal-dialog-centered">
        <div class="modal-content glass-card-modal animate-fade-in" style="background: var(--bg-color) !important; border: 1px solid var(--border-color) !important; color: var(--text-main) !important; border-radius: 16px;">
            <div class="modal-header border-secondary border-opacity-25" style="border-bottom: 1px solid var(--border-color) !important;">
                <h5 class="modal-title font-heading" id="modalTambahOrmasLabel"><i class="fa-solid fa-users text-primary me-2"></i>Tambah Ormas Baru</h5>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form action="<?= base_url('admin/tambah-ormas') ?>" method="POST" enctype="multipart/form-data">
                    <?= csrf_field() ?>
                    <div class="row g-3 mb-3">
                        <div class="col-md-6">
                            <label for="o_nama" class="form-label small text-muted">Nama Ormas / Organisasi <span class="text-danger fw-bold">*</span></label>
                            <input type="text" name="nama_ormas" id="o_nama" class="form-control form-control-custom" placeholder="Nama Resmi Organisasi" required>
                        </div>
                        <div class="col-md-6">
                            <label for="o_status" class="form-label small text-muted">Status Keaktifan <span class="text-danger fw-bold">*</span></label>
                            <select name="status" id="o_status" class="form-select form-control-custom" required>
                                <option value="Aktif">Aktif</option>
                                <option value="Tidak Aktif">Tidak Aktif</option>
                            </select>
                        </div>
                        <div class="col-md-12">
                            <label for="o_alamat" class="form-label small text-muted">Alamat Sekretariat <span class="text-danger fw-bold">*</span></label>
                            <textarea name="alamat" id="o_alamat" class="form-control form-control-custom" placeholder="Alamat lengkap kantor sekretariat" rows="2" required></textarea>
                        </div>
                        <div class="col-md-6">
                            <label for="o_email" class="form-label small text-muted">Email Kontak</label>
                            <input type="email" name="email" id="o_email" class="form-control form-control-custom" placeholder="contoh@mail.com">
                        </div>
                        <div class="col-md-6">
                            <label for="o_telepon" class="form-label small text-muted">Nomor Telepon / WhatsApp</label>
                            <input type="text" name="telepon" id="o_telepon" class="form-control form-control-custom" placeholder="Contoh: 08123456789">
                        </div>
                        <div class="col-md-6">
                            <label for="o_tgl_sk" class="form-label small text-muted">Tanggal SK Kepengurusan</label>
                            <input type="date" name="tgl_sk_kepengurusan" id="o_tgl_sk" class="form-control form-control-custom">
                        </div>
                        <div class="col-md-6">
                            <label for="o_tgl_exp" class="form-label small text-muted">Tanggal Kedaluwarsa SK</label>
                            <input type="date" name="tgl_sk_kedaluwarsa" id="o_tgl_exp" class="form-control form-control-custom">
                        </div>
                        <div class="col-md-6">
                            <label for="o_lat_val" class="form-label small text-muted">Latitude</label>
                            <input type="number" step="any" name="latitude" id="o_lat_val" class="form-control form-control-custom" placeholder="Contoh: -5.1234">
                        </div>
                        <div class="col-md-6">
                            <label for="o_lng_val" class="form-label small text-muted">Longitude</label>
                            <input type="number" step="any" name="longitude" id="o_lng_val" class="form-control form-control-custom" placeholder="Contoh: 120.1234">
                        </div>
                        <div class="col-md-6">
                            <label for="o_logo" class="form-label small text-muted">Logo Organisasi (Format Gambar)</label>
                            <input type="file" name="file_logo" id="o_logo" class="form-control form-control-custom" accept="image/*">
                        </div>
                        <div class="col-md-6">
                            <label for="o_berkas" class="form-label small text-muted">Berkas Legalitas / AD-ART (ZIP/PDF)</label>
                            <input type="file" name="file_berkas" id="o_berkas" class="form-control form-control-custom" accept=".zip,.pdf">
                        </div>
                    </div>
                    <div class="modal-footer border-0 px-0 pb-0 mt-4">
                        <button type="button" class="btn btn-secondary text-white" data-bs-dismiss="modal">Batal</button>
                        <button type="submit" class="btn btn-primary text-white fw-bold"><i class="fa-solid fa-floppy-disk me-1"></i> Simpan Ormas</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

<!-- Modal Edit Ormas -->
<div class="modal fade" id="modalEditOrmas" tabindex="-1" aria-labelledby="modalEditOrmasLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg modal-dialog-centered">
        <div class="modal-content glass-card-modal animate-fade-in" style="background: var(--bg-color) !important; border: 1px solid var(--border-color) !important; color: var(--text-main) !important; border-radius: 16px;">
            <div class="modal-header border-secondary border-opacity-25" style="border-bottom: 1px solid var(--border-color) !important;">
                <h5 class="modal-title font-heading" id="modalEditOrmasLabel"><i class="fa-solid fa-pencil text-warning me-2"></i>Edit Ormas / Organisasi</h5>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form action="<?= base_url('admin/update-ormas') ?>" method="POST" enctype="multipart/form-data">
                    <?= csrf_field() ?>
                    <input type="hidden" name="ormas_id" id="edit_ormas_id_val">
                    <div class="row g-3 mb-3">
                        <div class="col-md-6">
                            <label for="edit_o_nama" class="form-label small text-muted">Nama Ormas / Organisasi <span class="text-danger fw-bold">*</span></label>
                            <input type="text" name="nama_ormas" id="edit_o_nama" class="form-control form-control-custom" required>
                        </div>
                        <div class="col-md-6">
                            <label for="edit_o_status" class="form-label small text-muted">Status Keaktifan <span class="text-danger fw-bold">*</span></label>
                            <select name="status" id="edit_o_status" class="form-select form-control-custom" required>
                                <option value="Aktif">Aktif</option>
                                <option value="Tidak Aktif">Tidak Aktif</option>
                            </select>
                        </div>
                        <div class="col-md-12">
                            <label for="edit_o_alamat" class="form-label small text-muted">Alamat Sekretariat <span class="text-danger fw-bold">*</span></label>
                            <textarea name="alamat" id="edit_o_alamat" class="form-control form-control-custom" rows="2" required></textarea>
                        </div>
                        <div class="col-md-6">
                            <label for="edit_o_email" class="form-label small text-muted">Email Kontak</label>
                            <input type="email" name="email" id="edit_o_email" class="form-control form-control-custom">
                        </div>
                        <div class="col-md-6">
                            <label for="edit_o_telepon" class="form-label small text-muted">Nomor Telepon / WhatsApp</label>
                            <input type="text" name="telepon" id="edit_o_telepon" class="form-control form-control-custom">
                        </div>
                        <div class="col-md-6">
                            <label for="edit_o_tgl_sk" class="form-label small text-muted">Tanggal SK Kepengurusan</label>
                            <input type="date" name="tgl_sk_kepengurusan" id="edit_o_tgl_sk" class="form-control form-control-custom">
                        </div>
                        <div class="col-md-6">
                            <label for="edit_o_tgl_exp" class="form-label small text-muted">Tanggal Kedaluwarsa SK</label>
                            <input type="date" name="tgl_sk_kedaluwarsa" id="edit_o_tgl_exp" class="form-control form-control-custom">
                        </div>
                        <div class="col-md-6">
                            <label for="edit_o_lat" class="form-label small text-muted">Latitude</label>
                            <input type="number" step="any" name="latitude" id="edit_o_lat" class="form-control form-control-custom">
                        </div>
                        <div class="col-md-6">
                            <label for="edit_o_lng" class="form-label small text-muted">Longitude</label>
                            <input type="number" step="any" name="longitude" id="edit_o_lng" class="form-control form-control-custom">
                        </div>
                        <div class="col-md-6">
                            <label for="edit_o_logo" class="form-label small text-muted">Logo Organisasi (Unggah untuk mengganti)</label>
                            <input type="file" name="file_logo" id="edit_o_logo" class="form-control form-control-custom" accept="image/*">
                        </div>
                        <div class="col-md-6">
                            <label for="edit_o_berkas" class="form-label small text-muted">Berkas Legalitas / AD-ART (Unggah untuk mengganti)</label>
                            <input type="file" name="file_berkas" id="edit_o_berkas" class="form-control form-control-custom" accept=".zip,.pdf">
                        </div>
                    </div>
                    <div class="modal-footer border-0 px-0 pb-0 mt-4">
                        <button type="button" class="btn btn-secondary text-white" data-bs-dismiss="modal">Batal</button>
                        <button type="submit" class="btn btn-warning text-white fw-bold"><i class="fa-solid fa-floppy-disk me-1"></i> Simpan Perubahan</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

<!-- Modal Tambah Parpol -->
<div class="modal fade" id="modalTambahParpol" tabindex="-1" aria-labelledby="modalTambahParpolLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg modal-dialog-centered">
        <div class="modal-content glass-card-modal animate-fade-in" style="background: var(--bg-color) !important; border: 1px solid var(--border-color) !important; color: var(--text-main) !important; border-radius: 16px;">
            <div class="modal-header border-secondary border-opacity-25" style="border-bottom: 1px solid var(--border-color) !important;">
                <h5 class="modal-title font-heading" id="modalTambahParpolLabel"><i class="fa-solid fa-building-flag text-warning me-2"></i>Tambah Partai Politik Baru</h5>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form action="<?= base_url('admin/tambah-parpol') ?>" method="POST" enctype="multipart/form-data">
                    <?= csrf_field() ?>
                    <div class="row g-3 mb-3">
                        <div class="col-md-6">
                            <label for="p_nama" class="form-label small text-muted">Nama Partai Politik <span class="text-danger fw-bold">*</span></label>
                            <input type="text" name="nama_parpol" id="p_nama" class="form-control form-control-custom" placeholder="Nama Resmi Partai" required>
                        </div>
                        <div class="col-md-6">
                            <label for="p_ketua" class="form-label small text-muted">Nama Ketua DPC / DPD <span class="text-danger fw-bold">*</span></label>
                            <input type="text" name="ketua" id="p_ketua" class="form-control form-control-custom" placeholder="Nama Lengkap Ketua" required>
                        </div>
                        <div class="col-md-6">
                            <label for="p_alamat" class="form-label small text-muted">Alamat Sekretariat DPC <span class="text-danger fw-bold">*</span></label>
                            <input type="text" name="alamat" id="p_alamat" class="form-control form-control-custom" placeholder="Jl. Persatuan Raya, Sinjai" required>
                        </div>
                        <div class="col-md-6">
                            <label for="p_telepon" class="form-label small text-muted">Nomor Telepon Kantor <span class="text-danger fw-bold">*</span></label>
                            <input type="text" name="telepon" id="p_telepon" class="form-control form-control-custom" placeholder="Nomor Telp Kantor DPC" required>
                        </div>
                        <div class="col-md-6">
                            <label for="p_lat" class="form-label small text-muted">Latitude</label>
                            <input type="number" step="any" name="latitude" id="p_lat" class="form-control form-control-custom" placeholder="Contoh: -5.1234">
                        </div>
                        <div class="col-md-6">
                            <label for="p_lng" class="form-label small text-muted">Longitude</label>
                            <input type="number" step="any" name="longitude" id="p_lng" class="form-control form-control-custom" placeholder="Contoh: 120.1234">
                        </div>
                        <div class="col-md-6">
                            <label for="p_logo" class="form-label small text-muted">Lambang / Logo Partai (Format Gambar)</label>
                            <input type="file" name="file_logo" id="p_logo" class="form-control form-control-custom" accept="image/*">
                        </div>
                        <div class="col-md-6">
                            <label for="p_sk" class="form-label small text-muted">SK Kepengurusan Kemenkumham (ZIP/PDF)</label>
                            <input type="file" name="file_sk" id="p_sk" class="form-control form-control-custom" accept=".zip,.pdf">
                        </div>
                    </div>
                    <div class="modal-footer border-0 px-0 pb-0 mt-4">
                        <button type="button" class="btn btn-secondary text-white" data-bs-dismiss="modal">Batal</button>
                        <button type="submit" class="btn btn-warning text-white fw-bold"><i class="fa-solid fa-floppy-disk me-1"></i> Simpan Parpol</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

<!-- Modal Edit Parpol -->
<div class="modal fade" id="modalEditParpol" tabindex="-1" aria-labelledby="modalEditParpolLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg modal-dialog-centered">
        <div class="modal-content glass-card-modal animate-fade-in" style="background: var(--bg-color) !important; border: 1px solid var(--border-color) !important; color: var(--text-main) !important; border-radius: 16px;">
            <div class="modal-header border-secondary border-opacity-25" style="border-bottom: 1px solid var(--border-color) !important;">
                <h5 class="modal-title font-heading" id="modalEditParpolLabel"><i class="fa-solid fa-building-flag text-warning me-2"></i>Edit Partai Politik</h5>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form action="<?= base_url('admin/update-parpol') ?>" method="POST" enctype="multipart/form-data">
                    <?= csrf_field() ?>
                    <input type="hidden" name="parpol_id" id="edit_p_id">
                    <div class="row g-3 mb-3">
                        <div class="col-md-6">
                            <label for="edit_p_nama" class="form-label small text-muted">Nama Partai Politik <span class="text-danger fw-bold">*</span></label>
                            <input type="text" name="nama_parpol" id="edit_p_nama" class="form-control form-control-custom" placeholder="Nama Resmi Partai" required>
                        </div>
                        <div class="col-md-6">
                            <label for="edit_p_ketua" class="form-label small text-muted">Nama Ketua DPC / DPD <span class="text-danger fw-bold">*</span></label>
                            <input type="text" name="ketua" id="edit_p_ketua" class="form-control form-control-custom" placeholder="Nama Lengkap Ketua" required>
                        </div>
                        <div class="col-md-6">
                            <label for="edit_p_alamat" class="form-label small text-muted">Alamat Sekretariat DPC <span class="text-danger fw-bold">*</span></label>
                            <input type="text" name="alamat" id="edit_p_alamat" class="form-control form-control-custom" placeholder="Jl. Persatuan Raya, Sinjai" required>
                        </div>
                        <div class="col-md-6">
                            <label for="edit_p_telepon" class="form-label small text-muted">Nomor Telepon Kantor <span class="text-danger fw-bold">*</span></label>
                            <input type="text" name="telepon" id="edit_p_telepon" class="form-control form-control-custom" placeholder="Nomor Telp Kantor DPC" required>
                        </div>
                        <div class="col-md-6">
                            <label for="edit_p_lat" class="form-label small text-muted">Latitude</label>
                            <input type="number" step="any" name="latitude" id="edit_p_lat" class="form-control form-control-custom" placeholder="Contoh: -5.1234">
                        </div>
                        <div class="col-md-6">
                            <label for="edit_p_lng" class="form-label small text-muted">Longitude</label>
                            <input type="number" step="any" name="longitude" id="edit_p_lng" class="form-control form-control-custom" placeholder="Contoh: 120.1234">
                        </div>
                        <div class="col-md-6">
                            <label for="edit_p_logo" class="form-label small text-muted">Lambang / Logo Partai (Unggah untuk Ganti)</label>
                            <input type="file" name="file_logo" id="edit_p_logo" class="form-control form-control-custom" accept="image/*">
                        </div>
                        <div class="col-md-6">
                            <label for="edit_p_sk" class="form-label small text-muted">SK Kepengurusan Kemenkumham (Unggah untuk Ganti)</label>
                            <input type="file" name="file_sk" id="edit_p_sk" class="form-control form-control-custom" accept=".zip,.pdf">
                        </div>
                    </div>
                    <div class="modal-footer border-0 px-0 pb-0 mt-4">
                        <button type="button" class="btn btn-secondary text-white" data-bs-dismiss="modal">Batal</button>
                        <button type="submit" class="btn btn-warning text-white fw-bold"><i class="fa-solid fa-floppy-disk me-1"></i> Simpan Perubahan</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

<!-- Modal Edit Lokasi Parpol Coordinate Picker -->
<div class="modal fade" id="modalEditLokasiParpol" tabindex="-1" aria-labelledby="modalEditLokasiParpolLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg modal-dialog-centered">
        <div class="modal-content glass-card-modal animate-fade-in" style="background: var(--bg-color) !important; border: 1px solid var(--border-color) !important; color: var(--text-main) !important; border-radius: 16px;">
            <div class="modal-header border-secondary border-opacity-25" style="border-bottom: 1px solid var(--border-color) !important;">
                <h5 class="modal-title font-heading" id="modalEditLokasiParpolLabel"><i class="fa-solid fa-map-location-dot text-info me-2"></i>Edit Titik Koordinat Parpol</h5>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form action="<?= base_url('admin/update-koordinat-parpol') ?>" method="POST" id="formEditLokasiParpol">
                    <?= csrf_field() ?>
                    <input type="hidden" name="parpol_id" id="edit_parpol_id">
                    
                    <div class="mb-3">
                        <label class="form-label small text-muted">Nama Partai Politik</label>
                        <input type="text" id="edit_parpol_nama" class="form-control form-control-custom" readonly style="opacity: 0.85;">
                    </div>

                    <div class="row g-3 mb-3">
                        <div class="col-sm-6">
                            <label for="edit_parpol_latitude" class="form-label small text-muted">Latitude (Lintang/Selatan)</label>
                            <input type="number" step="any" name="latitude" id="edit_parpol_latitude" class="form-control form-control-custom" placeholder="Contoh: -5.1489" required>
                        </div>
                        <div class="col-sm-6">
                            <label for="edit_parpol_longitude" class="form-label small text-muted">Longitude (Bujur Timur)</label>
                            <input type="number" step="any" name="longitude" id="edit_parpol_longitude" class="form-control form-control-custom" placeholder="Contoh: 120.1294" required>
                        </div>
                    </div>

                    <p class="text-muted small mb-2"><i class="fa-solid fa-circle-info text-info me-1"></i>Klik pada peta di bawah ini untuk menandai lokasi yang tepat secara dinamis, atau geser (drag) penanda biru ke tempat yang benar.</p>
                    <div id="picker-map-parpol" style="height: 380px; border-radius: 10px; border: 1px solid var(--border-color); margin-bottom: 15px; width: 100%;"></div>

                    <div class="d-flex justify-content-between align-items-center mt-4">
                        <button type="button" class="btn btn-outline-danger btn-sm" id="btnResetKoordinatParpol"><i class="fa-solid fa-trash me-1"></i> Kosongkan Koordinat</button>
                        <div class="d-flex gap-2">
                            <button type="button" class="btn btn-secondary text-white" data-bs-dismiss="modal">Batal</button>
                            <button type="submit" class="btn btn-info text-white fw-bold"><i class="fa-solid fa-floppy-disk me-1"></i> Simpan Lokasi</button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

<!-- Modal Detail Tracking Berkas -->
<div class="modal fade" id="modalDetailTracking" tabindex="-1" aria-labelledby="modalDetailTrackingLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-lg">
        <div class="modal-content glass-card-modal animate-fade-in" style="background: var(--bg-color) !important; border: 1px solid var(--border-color) !important; color: var(--text-main) !important; border-radius: 16px;">
            <div class="modal-header border-secondary border-opacity-25" style="border-bottom: 1px solid var(--border-color) !important;">
                <h5 class="modal-title font-heading" id="modalDetailTrackingLabel"><i class="fa-solid fa-file-circle-info text-info me-2"></i>Detail Pengajuan Dokumen</h5>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body py-4">
                <div class="table-responsive">
                    <table class="table table-bordered border-secondary border-opacity-25 text-main mb-0" style="background: rgba(255,255,255,0.01);">
                        <tbody>
                            <tr>
                                <th style="width: 35%; background: rgba(255,255,255,0.03);" class="text-muted">Jenis Layanan</th>
                                <td id="dt-layanan" class="fw-bold text-main">-</td>
                            </tr>
                            <tr id="row-dt-registrasi">
                                <th style="background: rgba(255,255,255,0.03);" class="text-muted">Nomor Registrasi</th>
                                <td id="dt-registrasi" class="text-warning fw-bold">-</td>
                            </tr>
                            <tr>
                                <th style="background: rgba(255,255,255,0.03);" class="text-muted">Nama Pengaju / Lembaga</th>
                                <td id="dt-nama" class="fw-bold text-main">-</td>
                            </tr>
                            <tr id="row-dt-kegiatan">
                                <th style="background: rgba(255,255,255,0.03);" class="text-muted">Nama / Tema Kegiatan</th>
                                <td id="dt-kegiatan" class="text-main">-</td>
                            </tr>
                            <tr id="row-dt-waktu">
                                <th style="background: rgba(255,255,255,0.03);" class="text-muted">Waktu Kegiatan</th>
                                <td id="dt-waktu" class="text-main">-</td>
                            </tr>
                            <tr id="row-dt-sk-periode">
                                <th style="background: rgba(255,255,255,0.03);" class="text-muted">Masa SK Kepengurusan</th>
                                <td id="dt-sk-periode" class="text-main">-</td>
                            </tr>
                            <tr id="row-dt-alamat">
                                <th style="background: rgba(255,255,255,0.03);" class="text-muted">Alamat Sekretariat / Detail</th>
                                <td id="dt-alamat" class="text-main">-</td>
                            </tr>
                            <tr id="row-dt-email">
                                <th style="background: rgba(255,255,255,0.03);" class="text-muted">Email Kontak</th>
                                <td id="dt-email" class="text-main">-</td>
                            </tr>
                            <tr id="row-dt-telepon">
                                <th style="background: rgba(255,255,255,0.03);" class="text-muted">Nomor Telepon</th>
                                <td id="dt-telepon" class="text-main">-</td>
                            </tr>
                            <tr id="row-dt-deskripsi">
                                <th style="background: rgba(255,255,255,0.03);" class="text-muted">Deskripsi Kegiatan</th>
                                <td id="dt-deskripsi" class="text-main">-</td>
                            </tr>
                            <tr>
                                <th style="background: rgba(255,255,255,0.03);" class="text-muted">Status Berkas</th>
                                <td id="dt-status">-</td>
                            </tr>
                            <tr id="row-dt-progress">
                                <th style="background: rgba(255,255,255,0.03);" class="text-muted">Progres Verifikasi</th>
                                <td id="dt-progress" class="text-main">-</td>
                            </tr>
                            <tr>
                                <th style="background: rgba(255,255,255,0.03);" class="text-muted">Tanggal Pengajuan</th>
                                <td id="dt-tanggal" class="text-main">-</td>
                            </tr>
                            <tr id="row-dt-file">
                                <th style="background: rgba(255,255,255,0.03);" class="text-muted">Berkas Unggahan</th>
                                <td id="dt-file">-</td>
                            </tr>
                            <tr id="row-dt-tte">
                                <th style="background: rgba(255,255,255,0.03);" class="text-muted">Dokumen TTE Resmi</th>
                                <td id="dt-tte">-</td>
                            </tr>
                        </tbody>
                    </table>
                </div>
                <!-- Detail Kelengkapan Berkas (Point-by-Point JSON Table) -->
                <div id="container-dt-checklist-table" class="mt-4 d-none">
                    <h6 class="small fw-bold mb-3" style="color: var(--text-main) !important;"><i class="fa-solid fa-list-check text-warning me-2"></i>Validasi Kelengkapan Dokumen</h6>
                    <div class="table-responsive">
                        <table class="table table-custom mb-0" style="font-size: 0.85rem; color: var(--text-main) !important;">
                            <thead>
                                <tr style="background: rgba(255, 255, 255, 0.02);">
                                    <th class="text-center" style="width: 5%;">#</th>
                                    <th style="width: 35%;">Jenis Dokumen</th>
                                    <th class="text-center" style="width: 15%;">Status</th>
                                    <th class="text-center" style="width: 15%;">Tanda Tangan</th>
                                    <th class="text-center" style="width: 15%;">Keterangan</th>
                                    <th class="text-center" style="width: 15%;">Aksi</th>
                                </tr>
                            </thead>
                            <tbody id="dt-checklist-table-body">
                                <!-- Populated dynamically by JS -->
                            </tbody>
                        </table>
                    </div>
                </div>

                <!-- Interactive Progress Checklist (Only for Pendaftaran Ormas) -->
                <div id="container-dt-progress-checklist" class="mt-4 d-none">
                    <h6 class="small fw-bold mb-3" style="color: var(--text-main) !important;"><i class="fa-solid fa-route text-info me-2"></i>Update Progres Alur Layanan (Checklist)</h6>
                    <div class="d-flex flex-column gap-2.5 p-3 rounded border border-secondary border-opacity-25" style="background: rgba(255, 255, 255, 0.02);">
                        <div class="form-check mb-0">
                            <input class="form-check-input progress-checkbox" type="checkbox" id="modal-step1" data-id="" data-value="25" onclick="updateTrackingProgress(this)">
                            <label class="form-check-label small" style="cursor:pointer; color: var(--text-main) !important;" for="modal-step1">1. Verifikasi Berkas (25%)</label>
                        </div>
                        <div class="form-check mb-0">
                            <input class="form-check-input progress-checkbox" type="checkbox" id="modal-step2" data-id="" data-value="50" onclick="updateTrackingProgress(this)">
                            <label class="form-check-label small" style="cursor:pointer; color: var(--text-main) !important;" for="modal-step2">2. Ke Kemendagri (50%)</label>
                        </div>
                        <div class="form-check mb-0">
                            <input class="form-check-input progress-checkbox" type="checkbox" id="modal-step3" data-id="" data-value="75" onclick="updateTrackingProgress(this)">
                            <label class="form-check-label small" style="cursor:pointer; color: var(--text-main) !important;" for="modal-step3">3. Validasi Bidang (75%)</label>
                        </div>
                        <div class="form-check mb-0">
                            <input class="form-check-input progress-checkbox" type="checkbox" id="modal-step4" data-id="" data-value="100" onclick="updateTrackingProgress(this)">
                            <label class="form-check-label small" style="cursor:pointer; color: var(--text-main) !important;" for="modal-step4">4. Selesai / TTE (100%)</label>
                        </div>
                    </div>
                </div>

                <!-- Action Buttons Container -->
                <div id="container-dt-actions" class="mt-4 pt-3 border-top border-secondary border-opacity-25 d-flex gap-2 flex-wrap justify-content-end">
                    <!-- Dynamic action buttons populated by JS -->
                </div>

                <div class="d-flex justify-content-end mt-4">
                    <button type="button" class="btn btn-secondary text-white px-4" data-bs-dismiss="modal">Tutup</button>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Modal Tolak Pendaftaran -->
<div class="modal fade" id="modalTolakPendaftaran" tabindex="-1" aria-labelledby="modalTolakPendaftaranLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content glass-card-modal animate-fade-in" style="background: var(--bg-color) !important; border: 1px solid var(--border-color) !important; color: var(--text-main) !important; border-radius: 16px;">
            <div class="modal-header border-secondary border-opacity-25" style="border-bottom: 1px solid var(--border-color) !important;">
                <h5 class="modal-title font-heading" id="modalTolakPendaftaranLabel"><i class="fa-solid fa-circle-xmark text-danger me-2"></i>Tolak Pendaftaran Ormas</h5>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form action="" method="POST" id="formTolakPendaftaran">
                    <?= csrf_field() ?>
                    <p class="text-white small mb-3">Anda akan menolak pengajuan pendaftaran ormas: <b id="tolak_pendaftaran_nama" class="text-warning"></b></p>
                    <div class="mb-3">
                        <label for="alasan_ditolak" class="form-label small text-muted">Alasan Penolakan <span class="text-danger fw-bold">*</span></label>
                        <textarea name="alasan_ditolak" id="alasan_ditolak" class="form-control form-control-custom" rows="4" placeholder="Tulis alasan penolakan secara jelas (misal: berkas legalitas pendaftaran blur/kurang jelas)..." required></textarea>
                    </div>
                    <div class="modal-footer border-0 px-0 pb-0 mt-4">
                        <button type="button" class="btn btn-secondary text-white" data-bs-dismiss="modal">Batal</button>
                        <button type="submit" class="btn btn-danger text-white fw-bold"><i class="fa-solid fa-paper-plane me-1"></i> Kirim Penolakan</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

<!-- Modal Terbitkan Surat Pendaftaran -->
<div class="modal fade" id="modalTerbitkanSuratPendaftaran" tabindex="-1" aria-labelledby="modalTerbitkanSuratPendaftaranLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content glass-card-modal animate-fade-in" style="background: var(--bg-color) !important; border: 1px solid var(--border-color) !important; color: var(--text-main) !important; border-radius: 16px;">
            <div class="modal-header border-secondary border-opacity-25" style="border-bottom: 1px solid var(--border-color) !important;">
                <h5 class="modal-title font-heading" id="modalTerbitkanSuratPendaftaranLabel"><i class="fa-solid fa-file-arrow-up text-primary me-2"></i>Terbitkan Surat Rekomendasi</h5>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form action="" method="POST" id="formTerbitkanSuratPendaftaran" enctype="multipart/form-data">
                    <?= csrf_field() ?>
                    <p class="text-white small mb-3">Unggah berkas Surat Rekomendasi/Keterangan resmi untuk ormas: <b id="terbitkan_pendaftaran_nama" class="text-warning"></b></p>
                    <div class="mb-3">
                        <label for="berkas_rekomendasi" class="form-label small text-muted">Unggah File Surat (PDF/DOC/DOCX/ZIP) <span class="text-danger fw-bold">*</span></label>
                        <input type="file" name="berkas_rekomendasi" id="berkas_rekomendasi" class="form-control form-control-custom" accept=".pdf,.doc,.docx,.zip" required>
                        <div class="form-text text-muted small">Ukuran file maksimal 10MB.</div>
                    </div>
                    <div class="modal-footer border-0 px-0 pb-0 mt-4">
                        <button type="button" class="btn btn-secondary text-white" data-bs-dismiss="modal">Batal</button>
                        <button type="submit" class="btn btn-primary text-white fw-bold"><i class="fa-solid fa-cloud-arrow-up me-1"></i> Unggah & Selesaikan</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

<script src="https://unpkg.com/leaflet@1.9.4/dist/leaflet.js" crossorigin=""></script>
<script src="https://unpkg.com/leaflet.markercluster@1.4.1/dist/leaflet.markercluster.js"></script>
<script>
document.addEventListener('DOMContentLoaded', function() {
    // Staf Photo size validation
    const stafPhoto = document.getElementById('staf_photo');
    if (stafPhoto) {
        stafPhoto.addEventListener('change', function() {
            if (this.files && this.files[0]) {
                const file = this.files[0];
                const maxSize = 2 * 1024 * 1024; // 2MB
                if (file.size > maxSize) {
                    alert('Ukuran foto pengurus melebihi batas maksimum 2MB! Silakan pilih berkas yang lebih kecil.');
                    this.value = ''; // Reset input
                }
            }
        });
    }

    // GIS Map Base Layers
    const osm = L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
        maxZoom: 19,
        attribution: '© OpenStreetMap contributors'
    });

    const satellite = L.tileLayer('https://server.arcgisonline.com/ArcGIS/rest/services/World_Imagery/MapServer/tile/{z}/{y}/{x}', {
        maxZoom: 19,
        attribution: 'Tiles &copy; Esri &mdash; Source: Esri, i-cubed, USDA, USGS, AEX, GeoEye, Getmapping, Aerogrid, IGN, IGP, UPR-EGP, and the GIS User Community'
    });

    const terrain = L.tileLayer('https://{s}.tile.opentopomap.org/{z}/{x}/{y}.png', {
        maxZoom: 17,
        attribution: 'Map data: &copy; OpenStreetMap contributors, SRTM | Map style: &copy; OpenTopoMap (CC-BY-SA)'
    });

    // GIS Map Initialization
    let map = L.map('gis-map', {
        center: [-5.1489, 120.1294],
        zoom: 11,
        layers: [osm]
    });

    const baseMaps = {
        "Peta Standar (OSM)": osm,
        "Satelit (Esri)": satellite,
        "Topografi (TopoMap)": terrain
    };

    // Coordinate generator for scattered dots
    function getCoordinates(id, type) {
        let hash = 0;
        for (let i = 0; i < id.length; i++) {
            hash = id.charCodeAt(i) + ((hash << 5) - hash);
        }
        let latOffset = (Math.abs(hash % 150) / 1000) - 0.075;
        let lngOffset = (Math.abs((hash >> 8) % 150) / 1000) - 0.075;
        let baseLat = -5.1489;
        let baseLng = 120.1294;
        return [baseLat + latOffset, baseLng + lngOffset];
    }

    // Leaflet Custom Icons
    const createGlowIcon = (colorClass, size = 12) => {
        return L.divIcon({
            className: 'custom-glow-icon',
            html: `<div class="glow-marker ${colorClass}" style="width: ${size}px; height: ${size}px; border-radius: 50%; border: 2px solid #fff; box-shadow: 0 0 10px rgba(255,255,255,0.5);"></div>`,
            iconSize: [size, size],
            iconAnchor: [size / 2, size / 2]
        });
    };

    const officeIcon = L.divIcon({
        className: 'custom-glow-icon-office',
        html: `<div class="glow-marker" style="width: 16px; height: 16px; border-radius: 50%; border: 2px solid #fff; box-shadow: 0 0 15px #be123c; background-color: #be123c;"></div>`,
        iconSize: [16, 16],
        iconAnchor: [8, 8]
    });

    const ormasIcon = createGlowIcon('glow-ormas', 12);
    const parpolIcon = createGlowIcon('glow-parpol', 12);
    const pengaduanIcon = createGlowIcon('glow-pengaduan', 12);

    const getHotspotIcon = (level) => {
        let color = level === 'Tinggi' ? '#ef4444' : (level === 'Sedang' ? '#f59e0b' : '#fbbf24');
        return L.divIcon({
            className: 'custom-glow-icon-hotspot',
            html: `<div class="glow-marker animate-pulse" style="width: 14px; height: 14px; border-radius: 50%; border: 2px solid #fff; box-shadow: 0 0 15px ${color}; background-color: ${color};"></div>`,
            iconSize: [14, 14],
            iconAnchor: [7, 7]
        });
    };

    // Initialize Layer Groups
    let officeGroup = L.layerGroup().addTo(map);
    let ormasGroup = L.markerClusterGroup().addTo(map);
    let parpolGroup = L.layerGroup().addTo(map);
    let pengaduanGroup = L.layerGroup().addTo(map);
    let hotspotGroup = L.layerGroup().addTo(map);

    // 1. Office Marker
    L.marker([-5.1326246, 120.2500688], {icon: officeIcon}).addTo(officeGroup)
        .bindPopup('<b>Badan Kesbangpol Sinjai</b><br>Pusat Koordinasi Layanan & Keamanan.');

    // 2. Ormas Markers
    const ormas = <?= json_encode($ormas ?? []) ?>;
    ormas.forEach(o => {
        let coords = (o.latitude && o.longitude) ? [parseFloat(o.latitude), parseFloat(o.longitude)] : getCoordinates(o.id, 'ormas');
        let marker = L.marker(coords, {icon: ormasIcon}).addTo(ormasGroup)
            .bindPopup(`<b>Ormas: ${o.nama_ormas}</b><br>Alamat: ${o.alamat}<br>Status: <span class="badge bg-success">${o.status}</span>`);
        
        marker.on('click', function(e) {
            map.flyTo(e.latlng, 15, {
                animate: true,
                duration: 1.2
            });
        });
    });

    // 3. Parpol Markers
    const parpol = <?= json_encode($parpol ?? []) ?>;
    parpol.forEach(p => {
        let coords = (p.latitude && p.longitude) ? [parseFloat(p.latitude), parseFloat(p.longitude)] : getCoordinates(p.id, 'parpol');
        let marker = L.marker(coords, {icon: parpolIcon}).addTo(parpolGroup)
            .bindPopup(`<b>Parpol: ${p.nama_parpol}</b><br>Ketua: ${p.ketua}<br>Kontak: ${p.telepon}`);
        
        marker.on('click', function(e) {
            map.flyTo(e.latlng, 15, {
                animate: true,
                duration: 1.2
            });
        });
    });

    // 4. Pengaduan Markers
    const pengaduan = <?= json_encode($pengaduan ?? []) ?>;
    pengaduan.forEach(p => {
        try {
            let detail = JSON.parse(p.after_data);
            if (detail) {
                let coords = getCoordinates(p.id, 'pengaduan');
                let marker = L.marker(coords, {icon: pengaduanIcon}).addTo(pengaduanGroup)
                    .bindPopup(`<b>Aduan: ${detail.judul || 'Tanpa Judul'}</b><br>Kategori: ${detail.kategori || 'Lainnya'}<br>Tujuan: ${detail.nama_bidang || 'Umum'}`);
                
                marker.on('click', function(e) {
                    map.flyTo(e.latlng, 15, {
                        animate: true,
                        duration: 1.2
                    });
                });
            }
        } catch(e) {}
    });

    // 5. Hotspot Markers (Official conflict zones)
    const hotspots = <?= json_encode($settings['titik_kerawanan'] ?? []) ?>;
    const hotspotMarkers = {};
    hotspots.forEach(h => {
        let marker = L.marker([h.latitude, h.longitude], {icon: getHotspotIcon(h.level)}).addTo(hotspotGroup)
            .bindPopup(`<b>Titik Konflik: ${h.nama}</b><br>Tingkat Kerawanan: <span class="badge bg-danger">${h.level}</span><br>Detail: ${h.deskripsi}`);
        
        hotspotMarkers[h.id] = marker;

        marker.on('click', function(e) {
            map.flyTo(e.latlng, 15, {
                animate: true,
                duration: 1.2
            });
        });
    });

    // Add Layer Filter Control
    let overlayMaps = {
        "<span style='color: var(--text-main); font-weight: 500;'><i class='fa-solid fa-building-shield text-danger me-1'></i> Kantor Kesbangpol</span>": officeGroup,
        "<span style='color: var(--text-main); font-weight: 500;'><i class='fa-solid fa-users text-primary me-1'></i> Organisasi Ormas</span>": ormasGroup,
        "<span style='color: var(--text-main); font-weight: 500;'><i class='fa-solid fa-building-flag text-warning me-1'></i> Partai Politik</span>": parpolGroup,
        "<span style='color: var(--text-main); font-weight: 500;'><i class='fa-solid fa-bullhorn text-danger me-1'></i> Aduan Masyarakat</span>": pengaduanGroup,
        "<span style='color: var(--text-main); font-weight: 500;'><i class='fa-solid fa-triangle-exclamation text-warning me-1 animate-pulse'></i> Titik Rawan Konflik</span>": hotspotGroup
    };
    L.control.layers(baseMaps, overlayMaps, { collapsed: false, position: 'topright' }).addTo(map);

    window.focusHotspot = function(id) {
        let marker = hotspotMarkers[id];
        if (marker) {
            let latlng = marker.getLatLng();
            map.flyTo(latlng, 15, {
                animate: true,
                duration: 1.2
            });
            marker.openPopup();
        }
    };

    // 6. Admin click map handler to auto-fill form coordinates
    let activeMarker = null;
    map.on('click', function(e) {
        let lat = e.latlng.lat.toFixed(6);
        let lng = e.latlng.lng.toFixed(6);
        
        document.getElementById('h_lat').value = lat;
        document.getElementById('h_lng').value = lng;
        
        if (activeMarker) {
            activeMarker.setLatLng(e.latlng);
        } else {
            activeMarker = L.marker(e.latlng, {
                draggable: true,
                icon: L.divIcon({
                    className: 'custom-glow-icon-temp',
                    html: `<div style="width: 14px; height: 14px; border-radius: 50%; background-color: #6366f1; border: 2px solid #fff; box-shadow: 0 0 10px #6366f1;"></div>`,
                    iconSize: [14, 14],
                    iconAnchor: [7, 7]
                })
            }).addTo(map);
            
            activeMarker.on('dragend', function(event) {
                let marker = event.target;
                let position = marker.getLatLng();
                document.getElementById('h_lat').value = position.lat.toFixed(6);
                document.getElementById('h_lng').value = position.lng.toFixed(6);
            });
        }
    });

    // Fix Bootstrap tab Leaflet render issue
    const gisTab = document.getElementById('gis-tab');
    if (gisTab) {
        gisTab.addEventListener('shown.bs.tab', function () {
            setTimeout(() => {
                map.invalidateSize();
            }, 100);
        });
    }

    // Picker Map for Modal Edit Lokasi
    let pickerMap = null;
    let pickerMarker = null;

    // Handle Edit Lokasi button click
    const editLokasiButtons = document.querySelectorAll('.btn-edit-lokasi');
    const modalEditLokasiEl = document.getElementById('modalEditLokasi');
    const modalEditLokasi = new bootstrap.Modal(modalEditLokasiEl);

    editLokasiButtons.forEach(btn => {
        btn.addEventListener('click', function() {
            const ormasId = this.getAttribute('data-id');
            const ormasNama = this.getAttribute('data-nama');
            const latVal = this.getAttribute('data-lat');
            const lngVal = this.getAttribute('data-lng');

            document.getElementById('edit_ormas_id').value = ormasId;
            document.getElementById('edit_ormas_nama').value = ormasNama;
            document.getElementById('edit_latitude').value = latVal || '';
            document.getElementById('edit_longitude').value = lngVal || '';

            modalEditLokasi.show();
        });
    });

    // Handle modal shown event to initialize / invalidate map size
    modalEditLokasiEl.addEventListener('shown.bs.modal', function () {
        const ormasId = document.getElementById('edit_ormas_id').value;
        const latInput = document.getElementById('edit_latitude');
        const lngInput = document.getElementById('edit_longitude');

        let initialLat = latInput.value ? parseFloat(latInput.value) : null;
        let initialLng = lngInput.value ? parseFloat(lngInput.value) : null;

        // Fallback to default scattered coordinates if not set in DB
        if (!initialLat || !initialLng) {
            let scatteredCoords = getCoordinates(ormasId, 'ormas');
            initialLat = scatteredCoords[0];
            initialLng = scatteredCoords[1];
        }

        const centerCoords = [initialLat, initialLng];

        if (!pickerMap) {
            const osmPicker = L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
                maxZoom: 19,
                attribution: '© OpenStreetMap contributors'
            });
            const satPicker = L.tileLayer('https://server.arcgisonline.com/ArcGIS/rest/services/World_Imagery/MapServer/tile/{z}/{y}/{x}', {
                maxZoom: 19,
                attribution: 'Tiles &copy; Esri'
            });
            const baseMapsPicker = {
                "Peta Standar": osmPicker,
                "Satelit": satPicker
            };

            pickerMap = L.map('picker-map', {
                center: centerCoords,
                zoom: 14,
                layers: [osmPicker]
            });
            L.control.layers(baseMapsPicker).addTo(pickerMap);

            // Click on map to place/move marker
            pickerMap.on('click', function(e) {
                const lat = e.latlng.lat.toFixed(6);
                const lng = e.latlng.lng.toFixed(6);
                latInput.value = lat;
                lngInput.value = lng;
                updatePickerMarker(e.latlng);
            });
        } else {
            pickerMap.setView(centerCoords, 14);
            pickerMap.invalidateSize();
        }

        // If coordinates were not saved, we don't draw the marker immediately unless they click.
        // But to make it extremely user-friendly (as the plan notes), we place the marker on the fallback scattered spot so they can adjust it.
        const latVal = latInput.value;
        const lngVal = lngInput.value;
        if (latVal && lngVal) {
            updatePickerMarker(L.latLng(parseFloat(latVal), parseFloat(lngVal)));
        } else {
            // Remove previous marker if any when starting with empty
            if (pickerMarker) {
                pickerMap.removeLayer(pickerMarker);
                pickerMarker = null;
            }
        }

        function updatePickerMarker(latlng) {
            if (pickerMarker) {
                pickerMarker.setLatLng(latlng);
            } else {
                pickerMarker = L.marker(latlng, {
                    draggable: true
                }).addTo(pickerMap);

                pickerMarker.on('dragend', function(event) {
                    const marker = event.target;
                    const position = marker.getLatLng();
                    latInput.value = position.lat.toFixed(6);
                    lngInput.value = position.lng.toFixed(6);
                });
            }
        }
    });

    // Handle "Kosongkan Koordinat" button click
    document.getElementById('btnResetKoordinat').addEventListener('click', function() {
        document.getElementById('edit_latitude').value = '';
        document.getElementById('edit_longitude').value = '';
        if (pickerMarker) {
            pickerMap.removeLayer(pickerMarker);
            pickerMarker = null;
        }
    });

    // Client-side Live Search and Filter Pills for Ormas Table
    const ormasRows = document.querySelectorAll('#table-ormas-body tr');
    const ormasSearchInput = document.getElementById('search-ormas');
    const ormasClearSearchBtn = document.getElementById('btn-clear-search');
    const ormasFilterPills = document.querySelectorAll('.btn-filter-pill');
    let activeOrmasFilter = 'all';

    // Compute and display counts on pills when page loads
    let countAll = 0;
    let countAktif = 0;
    let countExpired = 0;
    let countYayasan = 0;
    let countLsm = 0;
    let countPerkumpulan = 0;

    ormasRows.forEach(row => {
        countAll++;
        if (row.getAttribute('data-status') === 'aktif') countAktif++;
        if (row.getAttribute('data-expired') === 'expired') countExpired++;
        
        const tipe = row.getAttribute('data-tipe');
        if (tipe === 'yayasan') countYayasan++;
        else if (tipe === 'lsm') countLsm++;
        else if (tipe === 'perkumpulan') countPerkumpulan++;
    });

    document.getElementById('count-all').textContent = countAll;
    document.getElementById('count-aktif').textContent = countAktif;
    document.getElementById('count-expired').textContent = countExpired;
    document.getElementById('count-yayasan').textContent = countYayasan;
    document.getElementById('count-lsm').textContent = countLsm;
    document.getElementById('count-perkumpulan').textContent = countPerkumpulan;

    function filterOrmasTable() {
        const query = ormasSearchInput.value.toLowerCase().trim();
        
        // Show/hide clear search button
        if (query.length > 0) {
            ormasClearSearchBtn.style.display = 'block';
        } else {
            ormasClearSearchBtn.style.display = 'none';
        }

        let visibleCount = 0;

        ormasRows.forEach(row => {
            const nama = row.getAttribute('data-nama') || '';
            const alamat = row.getAttribute('data-alamat') || '';
            const email = row.getAttribute('data-email') || '';
            const telepon = row.getAttribute('data-telepon') || '';
            const status = row.getAttribute('data-status') || '';
            const expired = row.getAttribute('data-expired') || '';
            const tipe = row.getAttribute('data-tipe') || '';

            // Search matches if query is found in any field
            const matchesSearch = query === '' || 
                                  nama.includes(query) || 
                                  alamat.includes(query) || 
                                  email.includes(query) || 
                                  telepon.includes(query);

            // Filter matches if active pill is 'all' or matches state
            let matchesFilter = false;
            if (activeOrmasFilter === 'all') {
                matchesFilter = true;
            } else if (activeOrmasFilter === 'aktif') {
                matchesFilter = (status === 'aktif');
            } else if (activeOrmasFilter === 'expired') {
                matchesFilter = (expired === 'expired');
            } else if (activeOrmasFilter === 'yayasan') {
                matchesFilter = (tipe === 'yayasan');
            } else if (activeOrmasFilter === 'lsm') {
                matchesFilter = (tipe === 'lsm');
            } else if (activeOrmasFilter === 'perkumpulan') {
                matchesFilter = (tipe === 'perkumpulan');
            }

            if (matchesSearch && matchesFilter) {
                row.style.display = '';
                row.style.opacity = '1';
                row.style.transition = 'opacity 0.25s ease';
                visibleCount++;
            } else {
                row.style.display = 'none';
                row.style.opacity = '0';
            }
        });

        // Toggle "No records found" row
        const noRecordRow = document.getElementById('no-record-row');
        if (visibleCount === 0) {
            if (!noRecordRow) {
                const tr = document.createElement('tr');
                tr.id = 'no-record-row';
                tr.innerHTML = `<td colspan="6" class="text-center text-muted py-4"><i class="fa-solid fa-folder-open me-2"></i>Tidak ada data ormas yang cocok dengan pencarian / filter Anda.</td>`;
                document.getElementById('table-ormas-body').appendChild(tr);
            }
        } else {
            if (noRecordRow) {
                noRecordRow.remove();
            }
        }
    }

    ormasSearchInput.addEventListener('input', filterOrmasTable);

    ormasClearSearchBtn.addEventListener('click', function() {
        ormasSearchInput.value = '';
        filterOrmasTable();
        ormasSearchInput.focus();
    });

    ormasFilterPills.forEach(pill => {
        pill.addEventListener('click', function() {
            ormasFilterPills.forEach(p => p.classList.remove('active'));
            this.classList.add('active');
            activeOrmasFilter = this.getAttribute('data-filter');
            filterOrmasTable();
        });
    });

    // ==========================================
    // JS FOR MANAJEMEN ORMAS (CRUD)
    // ==========================================

    // Handle Edit Ormas Modal
    const editOrmasButtons = document.querySelectorAll('.btn-edit-ormas');
    const modalEditOrmasEl = document.getElementById('modalEditOrmas');
    const modalEditOrmas = new bootstrap.Modal(modalEditOrmasEl);

    editOrmasButtons.forEach(btn => {
        btn.addEventListener('click', function() {
            const ormasId = this.getAttribute('data-id');
            const ormasNama = this.getAttribute('data-nama');
            const alamatVal = this.getAttribute('data-alamat');
            const emailVal = this.getAttribute('data-email');
            const teleponVal = this.getAttribute('data-telepon');
            const statusVal = this.getAttribute('data-status');
            const tglSkVal = this.getAttribute('data-tgl-sk');
            const tglExpVal = this.getAttribute('data-tgl-exp');
            const latVal = this.getAttribute('data-latitude');
            const lngVal = this.getAttribute('data-longitude');

            document.getElementById('edit_ormas_id_val').value = ormasId;
            document.getElementById('edit_o_nama').value = ormasNama;
            document.getElementById('edit_o_alamat').value = alamatVal;
            document.getElementById('edit_o_email').value = emailVal;
            document.getElementById('edit_o_telepon').value = teleponVal;
            document.getElementById('edit_o_status').value = statusVal;
            document.getElementById('edit_o_tgl_sk').value = tglSkVal || '';
            document.getElementById('edit_o_tgl_exp').value = tglExpVal || '';
            document.getElementById('edit_o_lat').value = latVal || '';
            document.getElementById('edit_o_lng').value = lngVal || '';

            modalEditOrmas.show();
        });
    });

    // ==========================================
    // JS FOR PARTAI POLITIK (CRUD & GIS PICKER)
    // ==========================================

    // 1. Handle Edit Parpol Modal
    const editParpolButtons = document.querySelectorAll('.btn-edit-parpol');
    const modalEditParpolEl = document.getElementById('modalEditParpol');
    const modalEditParpol = new bootstrap.Modal(modalEditParpolEl);

    editParpolButtons.forEach(btn => {
        btn.addEventListener('click', function() {
            const parpolId = this.getAttribute('data-id');
            const parpolNama = this.getAttribute('data-nama');
            const ketuaVal = this.getAttribute('data-ketua');
            const alamatVal = this.getAttribute('data-alamat');
            const teleponVal = this.getAttribute('data-telepon');
            const latVal = this.getAttribute('data-latitude');
            const lngVal = this.getAttribute('data-longitude');

            document.getElementById('edit_p_id').value = parpolId;
            document.getElementById('edit_p_nama').value = parpolNama;
            document.getElementById('edit_p_ketua').value = ketuaVal;
            document.getElementById('edit_p_alamat').value = alamatVal;
            document.getElementById('edit_p_telepon').value = teleponVal;
            document.getElementById('edit_p_lat').value = latVal || '';
            document.getElementById('edit_p_lng').value = lngVal || '';

            modalEditParpol.show();
        });
    });

    // 2. Interactive Coordinate Picker Map for Parpol
    let pickerMapParpol = null;
    let pickerMarkerParpol = null;

    const editLokasiParpolButtons = document.querySelectorAll('.btn-edit-lokasi-parpol');
    const modalEditLokasiParpolEl = document.getElementById('modalEditLokasiParpol');
    const modalEditLokasiParpol = new bootstrap.Modal(modalEditLokasiParpolEl);

    editLokasiParpolButtons.forEach(btn => {
        btn.addEventListener('click', function() {
            const parpolId = this.getAttribute('data-id');
            const parpolNama = this.getAttribute('data-nama');
            const latVal = this.getAttribute('data-lat');
            const lngVal = this.getAttribute('data-lng');

            document.getElementById('edit_parpol_id').value = parpolId;
            document.getElementById('edit_parpol_nama').value = parpolNama;
            document.getElementById('edit_parpol_latitude').value = latVal || '';
            document.getElementById('edit_parpol_longitude').value = lngVal || '';

            modalEditLokasiParpol.show();
        });
    });

    modalEditLokasiParpolEl.addEventListener('shown.bs.modal', function () {
        const parpolId = document.getElementById('edit_parpol_id').value;
        const latInput = document.getElementById('edit_parpol_latitude');
        const lngInput = document.getElementById('edit_parpol_longitude');

        let initialLat = latInput.value ? parseFloat(latInput.value) : null;
        let initialLng = lngInput.value ? parseFloat(lngInput.value) : null;

        // Fallback to scattered coordinate if not set
        if (!initialLat || !initialLng) {
            let scatteredCoords = getCoordinates(parpolId, 'parpol');
            initialLat = scatteredCoords[0];
            initialLng = scatteredCoords[1];
        }

        const centerCoords = [initialLat, initialLng];

        if (!pickerMapParpol) {
            const osmPickerParpol = L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
                maxZoom: 19,
                attribution: '© OpenStreetMap contributors'
            });
            const satPickerParpol = L.tileLayer('https://server.arcgisonline.com/ArcGIS/rest/services/World_Imagery/MapServer/tile/{z}/{y}/{x}', {
                maxZoom: 19,
                attribution: 'Tiles &copy; Esri'
            });
            const baseMapsPickerParpol = {
                "Peta Standar": osmPickerParpol,
                "Satelit": satPickerParpol
            };

            pickerMapParpol = L.map('picker-map-parpol', {
                center: centerCoords,
                zoom: 14,
                layers: [osmPickerParpol]
            });
            L.control.layers(baseMapsPickerParpol).addTo(pickerMapParpol);

            // Click map to update position
            pickerMapParpol.on('click', function(e) {
                const lat = e.latlng.lat.toFixed(6);
                const lng = e.latlng.lng.toFixed(6);
                latInput.value = lat;
                lngInput.value = lng;
                updatePickerMarkerParpol(e.latlng);
            });
        } else {
            pickerMapParpol.setView(centerCoords, 14);
            pickerMapParpol.invalidateSize();
        }

        const latVal = latInput.value;
        const lngVal = lngInput.value;
        if (latVal && lngVal) {
            updatePickerMarkerParpol(L.latLng(parseFloat(latVal), parseFloat(lngVal)));
        } else {
            if (pickerMarkerParpol) {
                pickerMapParpol.removeLayer(pickerMarkerParpol);
                pickerMarkerParpol = null;
            }
        }

        function updatePickerMarkerParpol(latlng) {
            if (pickerMarkerParpol) {
                pickerMarkerParpol.setLatLng(latlng);
            } else {
                pickerMarkerParpol = L.marker(latlng, {
                    draggable: true
                }).addTo(pickerMapParpol);

                pickerMarkerParpol.on('dragend', function(event) {
                    const marker = event.target;
                    const position = marker.getLatLng();
                    latInput.value = position.lat.toFixed(6);
                    lngInput.value = position.lng.toFixed(6);
                });
            }
        }
    });

    document.getElementById('btnResetKoordinatParpol').addEventListener('click', function() {
        document.getElementById('edit_parpol_latitude').value = '';
        document.getElementById('edit_parpol_longitude').value = '';
        if (pickerMarkerParpol) {
            pickerMapParpol.removeLayer(pickerMarkerParpol);
            pickerMarkerParpol = null;
        }
    });

    // Global Requirements List
    const globalRequirementsLokal = [
        {"name": "Surat Permohonan", "desc": "Surat Permohonan ditujukan kepada Menteri (Cq. Kaban Kesbangpol)", "tte": true},
        {"name": "AD & ART", "desc": "Anggaran Dasar (AD) & Anggaran Rumah Tangga (ART)", "tte": true},
        {"name": "Akta Notaris", "desc": "Akta Pendirian Notaris (memuat Nama, Lambang, Asas, Tujuan, Pengurus, Hak, Keuangan, dll.)", "tte": true},
        {"name": "Surat Pernyataan Keabsahan", "desc": "Surat Pernyataan Keabsahan Dokumen (Meterai Rp 10.000)", "tte": true},
        {"name": "Program & Struktur Kerja", "desc": "Program Kerja Organisasi & Struktur Organisasi Resmi", "tte": true},
        {"name": "Domisili Kantor", "desc": "Surat Keterangan Domisili Kantor Sekretariat", "tte": true},
        {"name": "NPWP Organisasi", "desc": "NPWP atas nama Organisasi", "tte": false},
        {"name": "Formulir Isian Data Ormas", "desc": "Formulir Isian Data Ormas (ditandatangani Ketua & Sekretaris)", "tte": true},
        {"name": "Rekomendasi Kementerian", "desc": "Surat Rekomendasi Kementerian Agama (Ormas Agama) / Kebudayaan", "tte": true},
        {"name": "Biodata & KTP Pengurus", "desc": "Biodata & KTP Pengurus (Ketua, Sekretaris, Bendahara)", "tte": false},
        {"name": "Pasfoto Pengurus", "desc": "Pasfoto Pengurus 4x6 cm 2 Lembar (Latar Merah)", "tte": false},
        {"name": "SK & Foto Sekretariat", "desc": "SK Pengurus & Foto Sekretariat (Tampak depan menampilkan Papan Nama)", "tte": false},
        {"name": "Kontrak/Izin Pakai Gedung", "desc": "Surat Perjanjian Kontrak/Izin Pakai Gedung dari Pemilik Gedung", "tte": true},
        {"name": "Rekening & Logo Organisasi", "desc": "Nomor Rekening Organisasi & File Logo Organisasi", "tte": false}
    ];

    const globalRequirementsBerjenjang = [
        {"name": "Surat Permohonan", "desc": "Surat Permohonan ditujukan kepada Kepala Badan Kesbangpol Kab. Sinjai", "tte": true},
        {"name": "Surat Pernyataan Resmi", "desc": "Surat Pernyataan Resmi (Meterai Rp 10.000)", "tte": true},
        {"name": "Surat Keterangan Domisili", "desc": "Surat Keterangan Domisili (Alamat domisili kop surat & sekretariat)", "tte": true},
        {"name": "Formulir Isian Data Ormas", "desc": "Formulir Isian Data Ormas (ditandatangani Ketua & Sekretaris)", "tte": true},
        {"name": "Pasfoto Pengurus", "desc": "Pasfoto Pengurus ukuran 4x6 cm sebanyak 2 lembar", "tte": false},
        {"name": "Fotokopi KTP Pengurus", "desc": "Fotokopi KTP Pengurus (Ketua, Sekretaris, Bendahara)", "tte": false},
        {"name": "Surat Keputusan (SK) Pengurus", "desc": "Surat Keputusan (SK) Pengurus Organisasi", "tte": false},
        {"name": "Foto Sekretariat", "desc": "Foto Sekretariat (Tampak depan menampilkan Papan Nama resmi)", "tte": false}
    ];

    // Detail Tracking Modal populator
    const modalDetailTrackingEl = document.getElementById('modalDetailTracking');
    const modalDetailTracking = new bootstrap.Modal(modalDetailTrackingEl);
    
    // Refresh page when closing detail tracking modal to sync changes
    let progressUpdated = false;
    modalDetailTrackingEl.addEventListener('hidden.bs.modal', function () {
        if (progressUpdated) {
            location.reload();
        }
    });

    document.querySelectorAll('.btn-detail-tracking').forEach(btn => {
        btn.addEventListener('click', function() {
            const type = this.getAttribute('data-type');
            const id = this.getAttribute('data-id');
            const nama = this.getAttribute('data-nama') || '';
            
            progressUpdated = false;

            // Reset labels and clean up rows
            document.querySelector('#row-dt-kegiatan th').innerText = 'Nama / Tema Kegiatan';
            document.querySelector('#row-dt-deskripsi th').innerText = 'Deskripsi Kegiatan';

            document.getElementById('row-dt-registrasi').classList.remove('d-none');
            document.getElementById('row-dt-kegiatan').classList.remove('d-none');
            document.getElementById('row-dt-waktu').classList.remove('d-none');
            document.getElementById('row-dt-sk-periode').classList.remove('d-none');
            document.getElementById('row-dt-alamat').classList.remove('d-none');
            document.getElementById('row-dt-email').classList.remove('d-none');
            document.getElementById('row-dt-telepon').classList.remove('d-none');
            document.getElementById('row-dt-deskripsi').classList.remove('d-none');
            document.getElementById('row-dt-progress').classList.remove('d-none');
            document.getElementById('row-dt-file').classList.remove('d-none');
            document.getElementById('row-dt-tte').classList.remove('d-none');
            
            // Hide containers by default
            document.getElementById('container-dt-checklist-table').classList.add('d-none');
            document.getElementById('container-dt-progress-checklist').classList.add('d-none');
            
            const actionsContainer = document.getElementById('container-dt-actions');
            actionsContainer.innerHTML = '';

            if (type === 'ormas') {
                const reg = this.getAttribute('data-registrasi');
                const alamat = this.getAttribute('data-alamat');
                const email = this.getAttribute('data-email');
                const telepon = this.getAttribute('data-telepon');
                const status = this.getAttribute('data-status');
                const progress = parseInt(this.getAttribute('data-progress') || '0');
                const tanggal = this.getAttribute('data-tanggal');
                const tipeOrmas = this.getAttribute('data-tipe-ormas') || 'Lokal';
                const file = this.getAttribute('data-file');

                document.getElementById('dt-layanan').innerText = 'Pendaftaran Ormas / LSM';
                document.getElementById('dt-registrasi').innerText = reg;
                document.getElementById('dt-nama').innerText = nama;
                document.getElementById('dt-alamat').innerText = alamat;
                document.getElementById('dt-email').innerText = email;
                document.getElementById('dt-telepon').innerText = telepon;
                document.getElementById('dt-status').innerHTML = `<span class="badge bg-success-subtle text-success border border-success-subtle px-2.5 py-1 rounded-pill">${status}</span>`;
                document.getElementById('dt-progress').innerText = progress + '%';
                document.getElementById('dt-tanggal').innerText = tanggal;
                
                const skMulai = this.getAttribute('data-sk-kepengurusan') || '-';
                const skExp = this.getAttribute('data-sk-kedaluwarsa') || '-';
                document.getElementById('dt-sk-periode').innerText = `${skMulai} s/d ${skExp}`;

                // Hide unused rows
                document.getElementById('row-dt-kegiatan').classList.add('d-none');
                document.getElementById('row-dt-waktu').classList.add('d-none');
                document.getElementById('row-dt-deskripsi').classList.add('d-none');
                document.getElementById('row-dt-tte').classList.add('d-none');

                const fileName = this.getAttribute('data-file');
                if (fileName && !fileName.trim().startsWith('{')) {
                    document.getElementById('dt-file').innerHTML = `<a href="<?= base_url('uploads/ormas/') ?>/${fileName}" target="_blank" class="btn btn-sm btn-outline-info"><i class="fa-solid fa-file-pdf me-1"></i> Buka Berkas Pendaftaran</a>`;
                } else {
                    document.getElementById('dt-file').innerText = 'Tidak ada berkas tunggal';
                }

                // Show dynamic checklist table
                const checklistContainer = document.getElementById('container-dt-checklist-table');
                checklistContainer.classList.remove('d-none');
                
                const checklistBody = document.getElementById('dt-checklist-table-body');
                checklistBody.innerHTML = '';

                const activeReqs = tipeOrmas === 'Lokal' ? globalRequirementsLokal : globalRequirementsBerjenjang;
                
                let filesList = {};
                try {
                    if (file && file.trim().startsWith('{')) {
                        filesList = JSON.parse(file);
                    }
                } catch (e) {
                    console.error("Gagal parse berkas JSON", e);
                }

                activeReqs.forEach((req, idx) => {
                    const fileIdx = idx + 1;
                    const exist = filesList[fileIdx] || null;

                    let statusBadge = `<span class="badge bg-danger-subtle text-danger border border-danger-subtle px-2 py-1 small"><i class="fa-solid fa-circle-xmark me-1"></i> Belum Ada</span>`;
                    let tteBadge = req.tte ? `<span class="badge bg-success-subtle text-success border border-success-subtle px-2 py-0.5" style="font-size: 0.72rem;"><i class="fa-solid fa-signature me-1"></i> TTE</span>` : `<span class="badge bg-secondary-subtle text-secondary border border-secondary border-opacity-25 px-2 py-0.5" style="font-size: 0.72rem;">Non TTE</span>`;
                    let keterangan = exist ? `Size: ${exist.size}` : '-';
                    let actionCol = exist ? `<a href="<?= base_url('uploads/ormas/') ?>/${exist.filename}" target="_blank" class="btn btn-sm btn-info text-white px-2 py-1"><i class="fa-solid fa-circle-info"></i></a>` : '-';

                    if (exist) {
                        statusBadge = `<span class="badge bg-success-subtle text-success border border-success-subtle px-2 py-1 small"><i class="fa-solid fa-circle-check me-1"></i> Ada</span>`;
                    }

                    const tr = document.createElement('tr');
                    tr.innerHTML = `
                        <td class="text-center align-middle">${fileIdx}</td>
                        <td class="align-middle">
                            <div class="fw-bold text-main small">${req.name}</div>
                            <div class="text-muted" style="font-size: 0.72rem;">${req.desc}</div>
                        </td>
                        <td class="text-center align-middle">${statusBadge}</td>
                        <td class="text-center align-middle">${tteBadge}</td>
                        <td class="text-center align-middle text-muted small">${keterangan}</td>
                        <td class="text-center align-middle">${actionCol}</td>
                    `;
                    checklistBody.appendChild(tr);
                });

                // Show and update progress checklist checkboxes in modal
                document.getElementById('container-dt-progress-checklist').classList.remove('d-none');
                const mStep1 = document.getElementById('modal-step1');
                const mStep2 = document.getElementById('modal-step2');
                const mStep3 = document.getElementById('modal-step3');
                const mStep4 = document.getElementById('modal-step4');

                // Assign id
                mStep1.setAttribute('data-id', id);
                mStep2.setAttribute('data-id', id);
                mStep3.setAttribute('data-id', id);
                mStep4.setAttribute('data-id', id);

                mStep1.checked = progress >= 25;
                mStep2.checked = progress >= 50;
                mStep3.checked = progress >= 75;
                mStep4.checked = progress == 100;

                // Action buttons for ormas
                if (status === 'Pending') {
                    const verifForm = document.createElement('form');
                    verifForm.action = `<?= base_url('admin/proses-pendaftaran') ?>/${id}/approve_berkas`;
                    verifForm.method = 'POST';
                    verifForm.className = 'd-inline me-2';
                    verifForm.onsubmit = () => confirm('Setujui kelayakan berkas persyaratan ormas ini?');
                    verifForm.innerHTML = `
                        <?= csrf_field() ?>
                        <button type="submit" class="btn btn-warning text-dark fw-bold"><i class="fa-solid fa-check me-1"></i> Lolos Berkas (50%)</button>
                    `;
                    actionsContainer.appendChild(verifForm);

                    const rejectBtn = document.createElement('button');
                    rejectBtn.type = 'button';
                    rejectBtn.className = 'btn btn-danger text-white fw-bold me-2';
                    rejectBtn.innerHTML = '<i class="fa-solid fa-circle-xmark me-1"></i> Tolak Pendaftaran';
                    rejectBtn.addEventListener('click', () => {
                        modalDetailTracking.hide();
                        setTimeout(() => {
                            window.openTolakModal({
                                getAttribute: function(attr) {
                                    if (attr === 'data-id') return id;
                                    if (attr === 'data-nama') return nama;
                                    return '';
                                }
                            });
                        }, 350);
                    });
                    actionsContainer.appendChild(rejectBtn);
                } else if (status === 'Approved' && progress < 100) {
                    const publishBtn = document.createElement('button');
                    publishBtn.type = 'button';
                    publishBtn.className = 'btn btn-primary text-white fw-bold me-2';
                    publishBtn.innerHTML = '<i class="fa-solid fa-file-arrow-up me-1"></i> Terbitkan Surat';
                    publishBtn.addEventListener('click', () => {
                        modalDetailTracking.hide();
                        setTimeout(() => {
                            window.openTerbitkanModal({
                                getAttribute: function(attr) {
                                    if (attr === 'data-id') return id;
                                    if (attr === 'data-nama') return nama;
                                    return '';
                                }
                            });
                        }, 350);
                    });
                    actionsContainer.appendChild(publishBtn);
                }

                // Delete button
                const deleteForm = document.createElement('form');
                deleteForm.action = `<?= base_url('admin/delete-pendaftaran') ?>/${id}`;
                deleteForm.method = 'POST';
                deleteForm.className = 'd-inline';
                deleteForm.onsubmit = () => confirm('Hapus berkas pendaftaran Ormas ini secara permanen?');
                deleteForm.innerHTML = `
                    <?= csrf_field() ?>
                    <button type="submit" class="btn btn-outline-danger"><i class="fa-solid fa-trash me-1"></i> Hapus Permanen</button>
                `;
                actionsContainer.appendChild(deleteForm);

            } else if (type === 'rekomendasi') {
                const kegiatan = this.getAttribute('data-kegiatan');
                const deskripsi = this.getAttribute('data-deskripsi');
                const status = this.getAttribute('data-status');
                const tanggal = this.getAttribute('data-tanggal');
                const proposalName = this.getAttribute('data-file');
                const ttePath = this.getAttribute('data-tte');

                document.getElementById('dt-layanan').innerText = 'Rekomendasi Kegiatan';
                document.getElementById('dt-nama').innerText = nama;
                document.getElementById('dt-kegiatan').innerText = kegiatan;
                
                const tglMulai = this.getAttribute('data-mulai') || '-';
                const tglSelesai = this.getAttribute('data-selesai') || '-';
                document.getElementById('dt-waktu').innerText = `${tglMulai} s/d ${tglSelesai}`;

                document.getElementById('dt-deskripsi').innerText = deskripsi;
                document.getElementById('dt-status').innerHTML = `<span class="badge bg-warning-subtle text-warning border border-warning-subtle px-2.5 py-1 rounded-pill">${status}</span>`;
                document.getElementById('dt-tanggal').innerText = tanggal;

                // Hide unused rows
                document.getElementById('row-dt-registrasi').classList.add('d-none');
                document.getElementById('row-dt-sk-periode').classList.add('d-none');
                document.getElementById('row-dt-alamat').classList.add('d-none');
                document.getElementById('row-dt-email').classList.add('d-none');
                document.getElementById('row-dt-telepon').classList.add('d-none');
                document.getElementById('row-dt-progress').classList.add('d-none');

                if (proposalName) {
                    document.getElementById('dt-file').innerHTML = `<a href="<?= base_url('uploads/rekomendasi/') ?>/${proposalName}" target="_blank" class="btn btn-sm btn-outline-info"><i class="fa-solid fa-file-pdf me-1"></i> Buka Proposal</a>`;
                } else {
                    document.getElementById('dt-file').innerText = 'Tidak ada berkas diunggah';
                }

                if (ttePath) {
                    document.getElementById('dt-tte').innerHTML = `<a href="<?= base_url() ?>/${ttePath}" target="_blank" class="btn btn-sm btn-outline-success"><i class="fa-solid fa-print me-1"></i> Cetak Surat TTE Resmi</a>`;
                } else {
                    document.getElementById('dt-tte').innerText = 'Belum diterbitkan TTE';
                }

                // Action buttons for Rekomendasi
                if (status === 'Pending') {
                    const approveForm = document.createElement('form');
                    approveForm.action = `<?= base_url('admin/proses-rekomendasi') ?>/${id}/approve_bidang`;
                    approveForm.method = 'POST';
                    approveForm.className = 'd-inline me-2';
                    approveForm.onsubmit = () => confirm('Setujui pengajuan rekomendasi ini?');
                    approveForm.innerHTML = `
                        <?= csrf_field() ?>
                        <button type="submit" class="btn btn-success text-white fw-bold"><i class="fa-solid fa-check me-1"></i> Setujui Rekomendasi</button>
                    `;
                    actionsContainer.appendChild(approveForm);

                    const rejectForm = document.createElement('form');
                    rejectForm.action = `<?= base_url('admin/proses-rekomendasi') ?>/${id}/reject`;
                    rejectForm.method = 'POST';
                    rejectForm.className = 'd-inline me-2';
                    rejectForm.onsubmit = () => confirm('Tolak pengajuan rekomendasi ini?');
                    rejectForm.innerHTML = `
                        <?= csrf_field() ?>
                        <button type="submit" class="btn btn-danger text-white fw-bold"><i class="fa-solid fa-xmark me-1"></i> Tolak</button>
                    `;
                    actionsContainer.appendChild(rejectForm);
                } else if (status === 'Approved' && !ttePath) {
                    const tteForm = document.createElement('form');
                    tteForm.action = `<?= base_url('admin/proses-rekomendasi') ?>/${id}/terbitkan_tte`;
                    tteForm.method = 'POST';
                    tteForm.className = 'd-inline me-2';
                    tteForm.onsubmit = () => confirm('Simulasikan penerbitan TTE untuk surat rekomendasi ini?');
                    tteForm.innerHTML = `
                        <?= csrf_field() ?>
                        <button type="submit" class="btn btn-primary text-white fw-bold"><i class="fa-solid fa-signature me-1"></i> Terbitkan TTE</button>
                    `;
                    actionsContainer.appendChild(tteForm);
                }

                // Delete button
                const deleteForm = document.createElement('form');
                deleteForm.action = `<?= base_url('admin/delete-rekomendasi') ?>/${id}`;
                deleteForm.method = 'POST';
                deleteForm.className = 'd-inline';
                deleteForm.onsubmit = () => confirm('Hapus berkas rekomendasi kegiatan ini secara permanen?');
                deleteForm.innerHTML = `
                    <?= csrf_field() ?>
                    <button type="submit" class="btn btn-outline-danger"><i class="fa-solid fa-trash me-1"></i> Hapus Permanen</button>
                `;
                actionsContainer.appendChild(deleteForm);

            } else if (type === 'aduan') {
                const judul = this.getAttribute('data-judul');
                const kategori = this.getAttribute('data-kategori');
                const bidang = this.getAttribute('data-bidang');
                const deskripsi = this.getAttribute('data-deskripsi');
                const file = this.getAttribute('data-file');
                const tanggal = this.getAttribute('data-tanggal');

                document.getElementById('dt-layanan').innerText = 'Aduan Masyarakat (Anonim)';
                document.getElementById('dt-nama').innerText = nama;
                document.getElementById('dt-kegiatan').innerText = judul;
                
                // Hide unused rows
                document.getElementById('row-dt-registrasi').classList.add('d-none');
                document.getElementById('row-dt-waktu').classList.add('d-none');
                document.getElementById('row-dt-sk-periode').classList.add('d-none');
                document.getElementById('row-dt-alamat').classList.add('d-none');
                document.getElementById('row-dt-email').classList.add('d-none');
                document.getElementById('row-dt-telepon').classList.add('d-none');
                document.getElementById('row-dt-progress').classList.add('d-none');
                document.getElementById('row-dt-tte').classList.add('d-none');

                // Customize labels for complaints
                document.querySelector('#row-dt-kegiatan th').innerText = 'Judul Aduan';
                document.querySelector('#row-dt-deskripsi th').innerText = 'Isi Laporan / Deskripsi';

                document.getElementById('dt-deskripsi').innerText = deskripsi;
                document.getElementById('dt-status').innerHTML = `<span class="badge bg-danger-subtle text-danger border border-danger-subtle px-2.5 py-1 rounded-pill">Diterima</span>`;
                document.getElementById('dt-tanggal').innerText = tanggal;

                if (file) {
                    document.getElementById('dt-file').innerHTML = `<a href="<?= base_url('uploads/pengaduan/') ?>/${file}" target="_blank" class="btn btn-sm btn-outline-info"><i class="fa-solid fa-file-pdf me-1"></i> Buka File Bukti</a>`;
                } else {
                    document.getElementById('dt-file').innerText = 'Tidak ada file lampiran';
                }

                // Action buttons for Aduan
                if (file) {
                    const deleteFileForm = document.createElement('form');
                    deleteFileForm.action = `<?= base_url('admin/delete-file-pengaduan') ?>/${id}`;
                    deleteFileForm.method = 'POST';
                    deleteFileForm.className = 'd-inline me-2';
                    deleteFileForm.onsubmit = () => confirm('Hapus file bukti pengaduan ini?');
                    deleteFileForm.innerHTML = `
                        <?= csrf_field() ?>
                        <button type="submit" class="btn btn-warning text-dark fw-bold"><i class="fa-solid fa-trash-can me-1"></i> Hapus File Bukti</button>
                    `;
                    actionsContainer.appendChild(deleteFileForm);
                }

                const deleteAduanForm = document.createElement('form');
                deleteAduanForm.action = `<?= base_url('admin/delete-pengaduan') ?>/${id}`;
                deleteAduanForm.method = 'POST';
                deleteAduanForm.className = 'd-inline';
                deleteAduanForm.onsubmit = () => confirm('Hapus laporan pengaduan ini secara permanen?');
                deleteAduanForm.innerHTML = `
                    <?= csrf_field() ?>
                    <button type="submit" class="btn btn-outline-danger"><i class="fa-solid fa-trash me-1"></i> Hapus Aduan</button>
                `;
                actionsContainer.appendChild(deleteAduanForm);
            }
            
            modalDetailTracking.show();
        });
    });



    window.triggerTolakModal = function(id, nama) {
        modalDetailTracking.hide();
        setTimeout(() => {
            window.openTolakModal({
                getAttribute: function(attr) {
                    if (attr === 'data-id') return id;
                    if (attr === 'data-nama') return nama;
                    return '';
                }
            });
        }, 350);
    };

    window.triggerTerbitkanModal = function(id, nama) {
        modalDetailTracking.hide();
        setTimeout(() => {
            window.openTerbitkanModal({
                getAttribute: function(attr) {
                    if (attr === 'data-id') return id;
                    if (attr === 'data-nama') return nama;
                    return '';
                }
            });
        }, 350);
    };

    // Filter function for unified tracking table
    window.filterTrackingTable = function(type, btn) {
        const filterButtons = document.querySelectorAll('.btn-filter-custom');
        filterButtons.forEach(b => b.classList.remove('active'));
        btn.classList.add('active');

        const rows = document.querySelectorAll('.tracking-row');
        let index = 1;
        rows.forEach(row => {
            const rowType = row.getAttribute('data-type');
            if (type === 'all' || rowType === type) {
                row.classList.remove('d-none');
                row.querySelector('td:first-child').innerText = index++;
            } else {
                row.classList.add('d-none');
            }
        });
    };

    // Update progress through checkboxes
    let currentCsrfHash = '<?= csrf_hash() ?>';
    
    window.updateTrackingProgress = function(checkbox) {
        const id = checkbox.getAttribute('data-id');
        const checked = checkbox.checked;
        const clickedVal = parseInt(checkbox.getAttribute('data-value'));

        let newVal = 0;
        if (checked) {
            newVal = clickedVal;
        } else {
            if (clickedVal === 100) newVal = 75;
            else if (clickedVal === 75) newVal = 50;
            else if (clickedVal === 50) newVal = 25;
            else if (clickedVal === 25) newVal = 0;
        }

        // Optimistically update checkbox UI in modal
        const chk1 = document.getElementById('modal-step1');
        const chk2 = document.getElementById('modal-step2');
        const chk3 = document.getElementById('modal-step3');
        const chk4 = document.getElementById('modal-step4');

        if (chk1) chk1.checked = newVal >= 25;
        if (chk2) chk2.checked = newVal >= 50;
        if (chk3) chk3.checked = newVal >= 75;
        if (chk4) chk4.checked = newVal == 100;

        // Disable modal elements during fetch
        const checkboxes = [chk1, chk2, chk3, chk4];
        checkboxes.forEach(c => { if(c) c.disabled = true; });

        fetch('<?= base_url('admin/update-progress') ?>', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': currentCsrfHash
            },
            body: JSON.stringify({
                id: id,
                progress: newVal
            })
        })
        .then(response => response.json())
        .then(data => {
            checkboxes.forEach(c => { if(c) c.disabled = false; });
            if (data.status) {
                if (data.csrf_hash) {
                    currentCsrfHash = data.csrf_hash;
                }
                
                window.showToast(data.message, 'success');
                progressUpdated = true;

                // Update details progress text
                const dtProgress = document.getElementById('dt-progress');
                if (dtProgress) {
                    dtProgress.innerText = newVal + '%';
                }
            } else {
                window.showToast(data.message, 'error');
                setTimeout(() => location.reload(), 1500);
            }
        })
        .catch(error => {
            checkboxes.forEach(c => { if(c) c.disabled = false; });
            console.error('Error updating progress:', error);
            window.showToast('Terjadi kesalahan koneksi.', 'danger');
            setTimeout(() => location.reload(), 1500);
        });
    };

    // Rejection Modal JS Hook
    const btnTolakList = document.querySelectorAll('.btn-tolak-pendaftaran');
    const modalTolakEl = document.getElementById('modalTolakPendaftaran');
    if (modalTolakEl) {
        const modalTolak = new bootstrap.Modal(modalTolakEl);
        
        window.openTolakModal = function(btn) {
            const id = btn.getAttribute('data-id');
            const nama = btn.getAttribute('data-nama');
            document.getElementById('tolak_pendaftaran_nama').innerText = nama;
            document.getElementById('formTolakPendaftaran').action = `<?= base_url('admin/proses-pendaftaran') ?>/${id}/reject`;
            document.getElementById('alasan_ditolak').value = '';
            modalTolak.show();
        };

        btnTolakList.forEach(btn => {
            btn.addEventListener('click', function() {
                window.openTolakModal(this);
            });
        });
    }

    // Upload & Publish Modal JS Hook
    const btnTerbitkanList = document.querySelectorAll('.btn-terbitkan-surat');
    const modalTerbitkanEl = document.getElementById('modalTerbitkanSuratPendaftaran');
    if (modalTerbitkanEl) {
        const modalTerbitkan = new bootstrap.Modal(modalTerbitkanEl);

        window.openTerbitkanModal = function(btn) {
            const id = btn.getAttribute('data-id');
            const nama = btn.getAttribute('data-nama');
            document.getElementById('terbitkan_pendaftaran_nama').innerText = nama;
            document.getElementById('formTerbitkanSuratPendaftaran').action = `<?= base_url('admin/proses-pendaftaran') ?>/${id}/terbitkan_tte`;
            document.getElementById('berkas_rekomendasi').value = '';
            modalTerbitkan.show();
        };

        btnTerbitkanList.forEach(btn => {
            btn.addEventListener('click', function() {
                window.openTerbitkanModal(this);
            });
        });
    }
});
</script>
<?= $this->endSection() ?>
