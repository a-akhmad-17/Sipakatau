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

    .table-custom {
        background: var(--card-bg);
        border: 1px solid var(--border-color);
        color: var(--text-main);
    }

    .table-custom th {
        background: var(--table-header-bg) !important;
        color: var(--text-main) !important;
        border-bottom: 1px solid var(--border-color);
        padding: 12px;
    }

    .table-custom td {
        padding: 12px;
        border-bottom: 1px solid var(--table-row-border);
        vertical-align: middle;
    }

    /* Red row highlight if realisasi < target (kegiatan bermasalah/memiliki kendala) */
    .row-warning-kegiatan {
        background-color: var(--row-warning-bg) !important;
        border-left: 4px solid #f59e0b !important;
    }

    .badge-target {
        background: var(--badge-target-bg) !important;
        color: var(--badge-target-color) !important;
        border: 1px solid var(--badge-target-border) !important;
    }

    .badge-realisasi {
        background: var(--badge-realisasi-bg) !important;
        color: var(--badge-realisasi-color) !important;
        border: 1px solid var(--badge-realisasi-border) !important;
    }

    .badge-realisasi-low {
        background: var(--badge-warning-bg) !important;
        color: var(--badge-warning-color) !important;
        border: 1px solid var(--badge-warning-border) !important;
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
</style>
<?= $this->endSection() ?>

<?= $this->section('content') ?>

<!-- Header Bidang -->
<div class="bidang-header d-flex justify-content-between align-items-center gap-3">
    <div>
        <span class="badge bg-info-subtle text-info border border-info-subtle px-3 py-1.5 rounded-pill mb-2 font-heading" style="font-weight:600;"><i class="fa-solid fa-code-branch me-1"></i>PPTK Panel</span>
        <h2 class="text-white fw-bold mb-1"><?= esc($namaBidang) ?></h2>
        <p class="text-muted small mb-0">Selamat bekerja, <b><?= esc(ucfirst(session()->get('username'))) ?></b> • Hari ini: <b><?= date('d M Y') ?></b></p>
    </div>
</div>

<div class="row g-4">
    <!-- Left Column: Form Laporan Kegiatan -->
    <div class="col-lg-5">
        <div class="glass-card p-4">
            <h4 class="text-white mb-3 font-heading"><i class="fa-solid fa-file-pen text-primary me-2"></i>Form Input Laporan</h4>
            <p class="text-muted small mb-4">Silakan laporkan realisasi pencapaian fisik dan keuangan bulanan bidang Anda. Penguncian SPJ dilakukan secara berkala.</p>
            
            <form action="<?= base_url('bidang/lapor-kegiatan') ?>" method="POST" id="formLapor">
                <?= csrf_field() ?>

                <div class="mb-3">
                    <label class="form-label small text-muted">Nama / Judul Kegiatan</label>
                    <input type="text" name="nama_kegiatan" class="form-control form-control-custom" placeholder="Nama program / kegiatan fisik" value="<?= old('nama_kegiatan') ?>" required>
                </div>

                <div class="row g-2 mb-3">
                    <div class="col-12">
                        <label class="form-label small text-muted">Bulan Pelaporan SPJ</label>
                        <input type="month" name="bulan_spj" id="bulan_spj" class="form-control form-control-custom" value="<?= old('bulan_spj') ?? date('Y-m') ?>" required>
                        <div class="form-text text-secondary small">Disinkronkan dengan bulan SIPD.</div>
                        <div id="lockedWarning" class="text-danger small fw-bold mt-1.5 d-none animate-pulse">
                            <i class="fa-solid fa-circle-exclamation me-1"></i> BULAN TERKUNCI! Periode SPJ ini telah dikunci oleh Admin.
                        </div>
                    </div>
                </div>

                <hr class="border-secondary my-4">

                <div class="row g-3 mb-3">
                    <!-- Target Fisik -->
                    <div class="col-6">
                        <label class="form-label small text-muted">Target Fisik (%)</label>
                        <input type="number" step="0.1" name="target_fisik" id="target_fisik" class="form-control form-control-custom" placeholder="100" value="<?= old('target_fisik') ?? '100' ?>" required oninput="checkRealisasi()">
                    </div>
                    <!-- Realisasi Fisik -->
                    <div class="col-6">
                        <label class="form-label small text-muted">Realisasi Fisik (%)</label>
                        <input type="number" step="0.1" name="realisasi_fisik" id="realisasi_fisik" class="form-control form-control-custom" placeholder="0" value="<?= old('realisasi_fisik') ?>" required oninput="checkRealisasi()">
                    </div>
                </div>

                <div class="row g-3 mb-3">
                    <!-- Target Keuangan -->
                    <div class="col-6">
                        <label class="form-label small text-muted">Target Keuangan (Rp)</label>
                        <input type="number" name="target_keuangan" id="target_keuangan" class="form-control form-control-custom" placeholder="Target nominal anggaran" value="<?= old('target_keuangan') ?>" required oninput="checkRealisasi()">
                    </div>
                    <!-- Realisasi Keuangan -->
                    <div class="col-6">
                        <label class="form-label small text-muted">Realisasi Keuangan (Rp)</label>
                        <input type="number" name="realisasi_keuangan" id="realisasi_keuangan" class="form-control form-control-custom" placeholder="Realisasi nominal anggaran" value="<?= old('realisasi_keuangan') ?>" required oninput="checkRealisasi()">
                    </div>
                </div>

                <div class="mb-4">
                    <label class="form-label small text-muted d-flex justify-content-between align-items-center">
                        <span>Kendala & Solusi</span>
                        <span id="labelKendalaWajib" class="badge bg-danger-subtle text-danger border border-danger-subtle px-2 d-none">WAJIB DIISI</span>
                    </label>
                    <textarea name="kendala" id="kendala" rows="3" class="form-control form-control-custom" placeholder="Tuliskan kendala / hambatan jika realisasi di bawah target..."><?= old('kendala') ?></textarea>
                    <div class="form-text text-secondary small">Wajib diisi apabila realisasi fisik atau keuangan lebih rendah dari target yang ditetapkan.</div>
                </div>

                <div class="d-grid">
                    <button type="submit" id="btnSubmitLapor" class="btn btn-portal py-2.5 fw-semibold"><i class="fa-solid fa-paper-plane me-2"></i>Kirim Laporan</button>
                </div>
            </form>
        </div>
    </div>

    <!-- Right Column: Riwayat Laporan Kegiatan Bidang -->
    <div class="col-lg-7">
        <div class="glass-card p-4" id="riwayat-kegiatan">
            <h4 class="text-white mb-3 font-heading"><i class="fa-solid fa-list-check text-warning me-2"></i>Riwayat Kegiatan Bidang</h4>
            <p class="text-muted small mb-4">Berikut riwayat laporan kinerja fisik dan keuangan bulanan yang sudah disubmit oleh bidang Anda.</p>
            
            <div class="table-responsive">
                <table class="table table-custom rounded overflow-hidden">
                    <thead>
                        <tr>
                            <th>Kegiatan & Bulan SPJ</th>
                            <th class="text-center">Fisik (%)</th>
                            <th class="text-end">Keuangan (Rp)</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php if (empty($kegiatan)): ?>
                            <tr>
                                <td colspan="3" class="text-center text-muted small py-4">Belum ada kegiatan yang dilaporkan untuk bidang ini.</td>
                            </tr>
                        <?php else: ?>
                            <?php foreach ($kegiatan as $k): 
                                $isFisikLow = $k['realisasi_fisik'] < $k['target_fisik'];
                                $isKeuanganLow = $k['realisasi_keuangan'] < $k['target_keuangan'];
                                $hasWarning = ($isFisikLow || $isKeuanganLow);
                            ?>
                                <tr class="<?= $hasWarning ? 'row-warning-kegiatan' : '' ?>">
                                    <td>
                                        <div class="fw-bold text-white small"><?= esc($k['nama_kegiatan']) ?></div>
                                        <div class="d-flex align-items-center gap-2 mt-1" style="font-size: 0.75rem;">
                                            <span class="text-muted"><i class="fa-regular fa-calendar me-1"></i>Bulan SPJ: <b><?= esc($k['bulan_spj']) ?></b></span>
                                            <?php if (in_array($k['bulan_spj'], $lockedMonths)): ?>
                                                <span class="badge bg-danger-subtle text-danger border border-danger-subtle" style="font-size: 0.7rem;"><i class="fa-solid fa-lock me-1"></i> Terkunci (SIPD)</span>
                                            <?php endif; ?>
                                        </div>
                                        <?php if (!empty($k['kendala'])): ?>
                                            <div class="alert alert-warning border-0 p-2 rounded mt-2 text-dark" style="font-size: 0.75rem; line-height: 1.4;">
                                                <strong>Kendala:</strong> <?= esc($k['kendala']) ?>
                                            </div>
                                        <?php endif; ?>
                                    </td>
                                    <td class="text-center">
                                        <div class="small text-muted mb-1">Target: <span class="badge badge-target"><?= $k['target_fisik'] ?>%</span></div>
                                        <div class="small">Real: <span class="badge <?= $isFisikLow ? 'badge-realisasi-low' : 'badge-realisasi' ?>"><?= $k['realisasi_fisik'] ?>%</span></div>
                                    </td>
                                    <td class="text-end">
                                        <div class="small text-muted mb-1">Target: <span class="text-white-50">Rp<?= number_format($k['target_keuangan'], 0, ',', '.') ?></span></div>
                                        <div class="small">Real: <span class="<?= $isKeuanganLow ? 'text-warning fw-bold' : 'text-success fw-bold' ?>">Rp<?= number_format($k['realisasi_keuangan'], 0, ',', '.') ?></span></div>
                                    </td>
                                </tr>
                            <?php endforeach; ?>
                        <?php endif; ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>

<!-- Row 2: Peta GIS & Sebaran Wilayah -->
<div class="row g-4 mt-4">
    <div class="col-12">
        <div class="glass-card p-4">
            <h4 class="text-white mb-2 font-heading"><i class="fa-solid fa-map-location-dot text-danger me-2"></i>Peta Geografis & Monitoring Wilayah</h4>
            <p class="text-muted small mb-4">Pemetaan interaktif wilayah Kabupaten Sinjai untuk koordinasi bidang Kesbangpol, titik ormas, parpol, dan laporan pengaduan masyarakat.</p>
            <div id="gis-map" style="height: 400px; border-radius: 12px; border: 1px solid var(--border-color); width: 100%; position: relative; overflow: hidden;"></div>
        </div>
    </div>
</div>

<?= $this->endSection() ?>

<?= $this->section('scripts') ?>
<script src="https://unpkg.com/leaflet@1.9.4/dist/leaflet.js" crossorigin=""></script>
<script src="https://unpkg.com/leaflet.markercluster@1.4.1/dist/leaflet.markercluster.js"></script>
<script>
    function checkRealisasi() {
        const targetFisik = parseFloat(document.getElementById('target_physic')?.value || document.getElementById('target_fisik')?.value) || 0;
        const realisasiFisik = parseFloat(document.getElementById('realisasi_physic')?.value || document.getElementById('realisasi_fisik')?.value) || 0;
        
        const targetKeuangan = parseFloat(document.getElementById('target_keuangan').value) || 0;
        const realisasiKeuangan = parseFloat(document.getElementById('realisasi_keuangan').value) || 0;

        const kendalaTextarea = document.getElementById('kendala');
        const labelWajib = document.getElementById('labelKendalaWajib');

        // Jika realisasi fisik atau keuangan kurang dari target, kolom kendala wajib diisi
        if (realisasiFisik < targetFisik || realisasiKeuangan < targetKeuangan) {
            kendalaTextarea.setAttribute('required', 'required');
            labelWajib.classList.remove('d-none');
        } else {
            kendalaTextarea.removeAttribute('required');
            labelWajib.classList.add('d-none');
        }
    }

    // Jalankan pengecekan di awal
    document.addEventListener("DOMContentLoaded", function() {
        checkRealisasi();

        // Check SPJ Monthly Lock status
        const lockedMonths = <?= json_encode($lockedMonths ?? []) ?>;
        const bulanSpjInput = document.getElementById('bulan_spj');
        const lockedWarning = document.getElementById('lockedWarning');
        const btnSubmitLapor = document.getElementById('btnSubmitLapor');

        function checkLockStatus() {
            if (!bulanSpjInput) return;
            const selectedMonth = bulanSpjInput.value;
            if (lockedMonths.includes(selectedMonth)) {
                lockedWarning.classList.remove('d-none');
                bulanSpjInput.style.borderColor = '#ef4444';
                bulanSpjInput.style.boxShadow = '0 0 0 3px rgba(239, 68, 68, 0.25)';
                if (btnSubmitLapor) {
                    btnSubmitLapor.disabled = true;
                    btnSubmitLapor.innerHTML = '<i class="fa-solid fa-lock me-2"></i>Bulan Terkunci';
                    btnSubmitLapor.style.opacity = '0.6';
                    btnSubmitLapor.style.cursor = 'not-allowed';
                }
            } else {
                lockedWarning.classList.add('d-none');
                bulanSpjInput.style.borderColor = '';
                bulanSpjInput.style.boxShadow = '';
                if (btnSubmitLapor) {
                    btnSubmitLapor.disabled = false;
                    btnSubmitLapor.innerHTML = '<i class="fa-solid fa-paper-plane me-2"></i>Kirim Laporan';
                    btnSubmitLapor.style.opacity = '';
                    btnSubmitLapor.style.cursor = '';
                }
            }
        }

        if (bulanSpjInput) {
            bulanSpjInput.addEventListener('change', checkLockStatus);
            bulanSpjInput.addEventListener('input', checkLockStatus);
            checkLockStatus(); // Run initial check
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

        // 5. Hotspot Markers
        const hotspots = <?= json_encode($hotspots ?? []) ?>;
        hotspots.forEach(h => {
            let marker = L.marker([h.latitude, h.longitude], {icon: getHotspotIcon(h.level)}).addTo(hotspotGroup)
                .bindPopup(`<b>Titik Konflik: ${h.nama}</b><br>Tingkat Kerawanan: <span class="badge bg-danger">${h.level}</span><br>Detail: ${h.deskripsi}`);
            
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
    });
</script>
<?= $this->endSection() ?>
