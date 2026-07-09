<?= $this->extend('layouts/admin') ?>

<?= $this->section('styles') ?>
<link rel="stylesheet" href="https://unpkg.com/leaflet@1.9.4/dist/leaflet.css" crossorigin="" />
<link rel="stylesheet" href="https://unpkg.com/leaflet.markercluster@1.4.1/dist/MarkerCluster.css" />
<link rel="stylesheet" href="https://unpkg.com/leaflet.markercluster@1.4.1/dist/MarkerCluster.Default.css" />
<style>
    .exec-header {
        background: linear-gradient(135deg, rgba(239, 68, 68, 0.1) 0%, rgba(59, 130, 246, 0.05) 100%);
        border: 1px solid var(--border-color);
        border-radius: 12px;
        padding: 24px;
        margin-bottom: 30px;
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
    .glow-rekomendasi { background-color: #a855f7 !important; box-shadow: 0 0 10px #a855f7 !important; }
    
    .hotspot-item {
        transition: all 0.2s ease;
    }
    .hotspot-item:hover {
        background: var(--border-color) !important;
        transform: translateX(4px);
    }
    .filter-card {
        background: var(--input-bg);
        border: 1px solid var(--border-color);
    }
</style>
<?= $this->endSection() ?>

<?= $this->section('content') ?>

<!-- Header -->
<div class="exec-header d-flex flex-column flex-md-row justify-content-between align-items-md-center gap-3">
    <div>
        <span class="badge bg-danger-subtle text-danger border border-danger-subtle px-3 py-1.5 rounded-pill mb-2 font-heading" style="font-weight:600;"><i class="fa-solid fa-map-location-dot me-1"></i>Peta Geografis</span>
        <h2 class="text-white fw-bold mb-1">Peta Sebaran GIS</h2>
        <p class="text-muted small mb-0">Pemetaan sebaran ormas, partai politik, aduan masyarakat, rekomendasi kegiatan, dan deteksi potensi gesekan sosial di Sinjai • Hari ini: <b><?= date('d M Y') ?></b></p>
    </div>
    <div class="d-flex align-items-center flex-wrap gap-2">
        <!-- Filter Tahun -->
        <div class="d-flex align-items-center gap-2">
            <label for="filter-tahun" class="text-white small mb-0 fw-semibold" style="white-space: nowrap;"><i class="fa-solid fa-calendar me-1 text-danger"></i>Tahun:</label>
            <select id="filter-tahun" class="form-select form-control-custom py-1.5 px-2.5 text-white bg-dark border-secondary border-opacity-25" style="border-radius: 8px; width: 100px; cursor: pointer; border-color: rgba(255,255,255,0.15); background-color: rgba(0,0,0,0.5); font-size: 0.8rem;">
                <option value="all">Semua</option>
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
        </div>
        <!-- Filter Bulan -->
        <div class="d-flex align-items-center gap-2">
            <label for="filter-bulan" class="text-white small mb-0 fw-semibold" style="white-space: nowrap;"><i class="fa-solid fa-calendar-days me-1 text-danger"></i>Bulan:</label>
            <select id="filter-bulan" class="form-select form-control-custom py-1.5 px-2.5 text-white bg-dark border-secondary border-opacity-25" style="border-radius: 8px; width: 130px; cursor: pointer; border-color: rgba(255,255,255,0.15); background-color: rgba(0,0,0,0.5); font-size: 0.8rem;">
                <option value="all" selected>Semua Bulan</option>
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
        <a href="<?= site_url('eksekutif') ?>" class="btn btn-outline-secondary text-white py-1.5 px-3" style="border-radius: 8px; font-size: 0.85rem;">
            <i class="fa-solid fa-arrow-left me-1.5"></i>Kembali
        </a>
    </div>
</div>

<!-- Map Container -->
<div class="glass-card p-4 animate-fade-up">
    <div class="row g-4">
        <!-- Map Area -->
        <div class="col-lg-8">
            <div id="gis-map" style="height: 550px; border-radius: 12px; border: 1px solid var(--border-color); position: relative; overflow: hidden; width: 100%;"></div>
        </div>
        
        <!-- Sidebar Controls & Hotspot List -->
        <div class="col-lg-4 d-flex flex-column gap-3">
            <!-- Summary Stats -->
            <div class="p-3 rounded filter-card">
                <h5 class="text-white fw-bold mb-3 small"><i class="fa-solid fa-chart-simple text-danger me-2"></i>Ringkasan Data GIS</h5>
                <div class="row g-2">
                    <div class="col-4">
                        <div class="p-1.5 rounded text-center" style="background: var(--card-bg); border: 1px solid var(--border-color);">
                            <div class="text-muted" style="font-size: 0.7rem;">Ormas</div>
                            <h5 class="text-primary fw-bold mb-0" id="count-ormas" style="font-size: 1.1rem;">0</h5>
                        </div>
                    </div>
                    <div class="col-4">
                        <div class="p-1.5 rounded text-center" style="background: var(--card-bg); border: 1px solid var(--border-color);">
                            <div class="text-muted" style="font-size: 0.7rem;">Parpol</div>
                            <h5 class="text-warning fw-bold mb-0" id="count-parpol" style="font-size: 1.1rem;">0</h5>
                        </div>
                    </div>
                    <div class="col-4">
                        <div class="p-1.5 rounded text-center" style="background: var(--card-bg); border: 1px solid var(--border-color);">
                            <div class="text-muted" style="font-size: 0.7rem;">Kegiatan</div>
                            <h5 class="text-info fw-bold mb-0" id="count-rekomendasi" style="color: #a855f7 !important; font-size: 1.1rem;">0</h5>
                        </div>
                    </div>
                    <div class="col-6 mt-2">
                        <div class="p-2 rounded text-center" style="background: var(--card-bg); border: 1px solid var(--border-color);">
                            <div class="text-muted small" style="font-size: 0.75rem;">Aduan Laporan</div>
                            <h4 class="text-danger fw-bold mb-0" id="count-aduan">0</h4>
                        </div>
                    </div>
                    <div class="col-6 mt-2">
                        <div class="p-2 rounded text-center" style="background: var(--card-bg); border: 1px solid var(--border-color);">
                            <div class="text-muted small" style="font-size: 0.75rem;">Titik Konflik</div>
                            <h4 class="text-danger fw-bold mb-0" id="count-kerawanan">0</h4>
                        </div>
                    </div>
                </div>
            </div>

            <!-- List Active Hotspots -->
            <div class="p-3 rounded filter-card d-flex flex-column flex-grow-1" style="max-height: 350px;">
                <h5 class="text-white fw-bold mb-3 small d-flex justify-content-between align-items-center">
                    <span><i class="fa-solid fa-triangle-exclamation text-danger me-2"></i>Titik Rawan Konflik</span>
                    <span class="badge bg-danger text-white" id="badge-hotspot-count" style="font-size:0.7rem;"><?= count($hotspots) ?> Titik</span>
                </h5>
                
                <div class="d-flex flex-column gap-2 overflow-y-auto pr-1" id="hotspots-list-container" style="flex: 1;">
                    <?php if (empty($hotspots)): ?>
                        <div class="text-muted small text-center py-4">Belum ada titik kerawanan yang didaftarkan.</div>
                    <?php else: ?>
                        <?php foreach ($hotspots as $h): 
                            $badgeClass = $h['level'] === 'Tinggi' ? 'badge bg-danger-subtle text-danger border border-danger-subtle' : ($h['level'] === 'Sedang' ? 'badge bg-warning-subtle text-warning border border-warning-subtle' : 'badge bg-info-subtle text-info border border-info-subtle');
                        ?>
                            <div class="d-flex justify-content-between align-items-center p-2 rounded hotspot-item" style="background: var(--card-bg); border: 1px solid var(--border-color); cursor: pointer;" onclick="focusHotspot('<?= esc($h['id']) ?>')">
                                <div class="min-w-0 flex-grow-1">
                                    <div class="fw-bold text-white small text-truncate"><?= esc($h['nama']) ?></div>
                                    <div class="text-muted" style="font-size: 0.7rem;">
                                        <span class="<?= $badgeClass ?> py-0 px-1.5" style="font-size: 0.65rem;"><?= esc($h['level']) ?></span>
                                        &bull; Klik untuk fokus
                                    </div>
                                </div>
                                <div class="text-danger small"><i class="fa-solid fa-crosshairs"></i></div>
                            </div>
                        <?php endforeach; ?>
                    <?php endif; ?>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Leaflet & Clustering Scripts -->
<script src="https://unpkg.com/leaflet@1.9.4/dist/leaflet.js"></script>
<script src="https://unpkg.com/leaflet.markercluster@1.4.1/dist/leaflet.markercluster.js"></script>

<script>
    document.addEventListener('DOMContentLoaded', function() {
        // Base maps
        const osm = L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
            maxZoom: 19,
            attribution: '&copy; OpenStreetMap contributors'
        });

        const satellite = L.tileLayer('https://server.arcgisonline.com/ArcGIS/rest/services/World_Imagery/MapServer/tile/{z}/{y}/{x}', {
            maxZoom: 19,
            attribution: 'Tiles &copy; Esri'
        });

        const terrain = L.tileLayer('https://{s}.tile.opentopomap.org/{z}/{x}/{y}.png', {
            maxZoom: 17,
            attribution: 'Map data &copy; OpenStreetMap | Style &copy; OpenTopoMap'
        });

        // Initialize Map
        const map = L.map('gis-map', {
            center: [-5.1489, 120.1294],
            zoom: 11,
            layers: [osm]
        });

        const baseMaps = {
            "Peta Standar (OSM)": osm,
            "Satelit (Esri)": satellite,
            "Topografi (TopoMap)": terrain
        };

        // Coordinate helper for blank latitude/longitude values
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

        // Glow Markers Icons
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
        const rekomendasiIcon = createGlowIcon('glow-rekomendasi', 12);

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
        const officeGroup = L.layerGroup().addTo(map);
        const ormasGroup = L.markerClusterGroup().addTo(map);
        const parpolGroup = L.layerGroup().addTo(map);
        const pengaduanGroup = L.layerGroup().addTo(map);
        const rekomendasiGroup = L.layerGroup().addTo(map);
        const hotspotGroup = L.layerGroup().addTo(map);

        // 1. Office Marker
        L.marker([-5.1326246, 120.2500688], {icon: officeIcon}).addTo(officeGroup)
            .bindPopup('<b>Badan Kesbangpol Sinjai</b><br>Pusat Koordinasi Layanan & Keamanan.');

        // 4. Pengaduan, Rekomendasi & Hotspots data
        const ormas = <?= json_encode($ormas ?? []) ?>;
        const parpol = <?= json_encode($parpol ?? []) ?>;
        const pengaduan = <?= json_encode($pengaduan ?? []) ?>;
        const rekomendasi = <?= json_encode($rekomendasi ?? []) ?>;
        const hotspots = <?= json_encode($hotspots ?? []) ?>;
        const hotspotMarkers = {};

        function renderFilteredData(year, month) {
            // Clear existing layers
            ormasGroup.clearLayers();
            parpolGroup.clearLayers();
            pengaduanGroup.clearLayers();
            hotspotGroup.clearLayers();
            rekomendasiGroup.clearLayers();
            for (let key in hotspotMarkers) {
                delete hotspotMarkers[key];
            }

            let filteredOrmasCount = 0;
            let filteredParpolCount = 0;
            let filteredAduanCount = 0;
            let filteredHotspots = [];
            let filteredRekomendasiCount = 0;

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
                    filteredOrmasCount++;
                    let coords = (o.latitude && o.longitude) ? [parseFloat(o.latitude), parseFloat(o.longitude)] : getCoordinates(o.id, 'ormas');
                    let marker = L.marker(coords, {icon: ormasIcon}).addTo(ormasGroup)
                        .bindPopup(`<b>Ormas: ${o.nama_ormas}</b><br>Alamat: ${o.alamat}<br>Status: <span class="badge bg-success">${o.status}</span><br>Tgl SK Kepengurusan: ${o.tgl_sk_kepengurusan || '-'}`);
                    
                    marker.on('click', function(e) {
                        map.flyTo(e.latlng, 15, { animate: true, duration: 1.2 });
                    });
                }
            });

            // Plot Parpol
            parpol.forEach(p => {
                if (matchDate(p.created_at, year, month)) {
                    filteredParpolCount++;
                    let coords = (p.latitude && p.longitude) ? [parseFloat(p.latitude), parseFloat(p.longitude)] : getCoordinates(p.id, 'parpol');
                    let marker = L.marker(coords, {icon: parpolIcon}).addTo(parpolGroup)
                        .bindPopup(`<b>Parpol: ${p.nama_parpol}</b><br>Ketua: ${p.ketua}<br>Kontak: ${p.telepon}<br>Terdaftar: ${p.created_at || '-'}`);
                    
                    marker.on('click', function(e) {
                        map.flyTo(e.latlng, 15, { animate: true, duration: 1.2 });
                    });
                }
            });

            // Plot Pengaduan
            pengaduan.forEach(p => {
                try {
                    let detail = JSON.parse(p.after_data);
                    if (detail && matchDate(p.created_at, year, month)) {
                        filteredAduanCount++;
                        let coords = getCoordinates(p.id, 'pengaduan');
                        let marker = L.marker(coords, {icon: pengaduanIcon}).addTo(pengaduanGroup)
                            .bindPopup(`<b>Aduan: ${detail.judul || 'Tanpa Judul'}</b><br>Kategori: ${detail.kategori || 'Lainnya'}<br>Tujuan: ${detail.nama_bidang || 'Umum'}<br>Tanggal Lapor: ${p.created_at}`);
                        
                        marker.on('click', function(e) {
                            map.flyTo(e.latlng, 15, { animate: true, duration: 1.2 });
                        });
                    }
                } catch(e) {}
            });

            // Plot Hotspots (Conflict zones)
            hotspots.forEach(h => {
                if (matchDate(h.created_at, year, month)) {
                    filteredHotspots.push(h);
                    let marker = L.marker([parseFloat(h.latitude), parseFloat(h.longitude)], {icon: getHotspotIcon(h.level)}).addTo(hotspotGroup)
                        .bindPopup(`<b>Titik Konflik: ${h.nama}</b><br>Tingkat Kerawanan: <span class="badge bg-danger">${h.level}</span><br>Detail: ${h.deskripsi}<br>Tanggal Terdeteksi: ${h.created_at || '-'}`);
                    
                    hotspotMarkers[h.id] = marker;

                    marker.on('click', function(e) {
                        map.flyTo(e.latlng, 15, { animate: true, duration: 1.2 });
                    });
                }
            });

            // Plot Rekomendasi Kegiatan
            rekomendasi.forEach(r => {
                if (matchDate(r.created_at, year, month)) {
                    filteredRekomendasiCount++;
                    let coords = getCoordinates(r.id, 'rekomendasi');
                    let marker = L.marker(coords, {icon: rekomendasiIcon}).addTo(rekomendasiGroup)
                        .bindPopup(`<b>Rekomendasi: ${r.nama_kegiatan}</b><br>Pemohon: ${r.pemohon}<br>Lokasi: ${r.lokasi_kegiatan || '-'}<br>Waktu: ${r.tgl_mulai} s/d ${r.tgl_selesai}<br>Status: <span class="badge" style="background-color: #a855f7; color: #fff;">${r.status_rekomendasi}</span>`);
                    
                    marker.on('click', function(e) {
                        map.flyTo(e.latlng, 15, { animate: true, duration: 1.2 });
                    });
                }
            });

            // Update Summary Stats Counters
            document.getElementById('count-ormas').innerText = filteredOrmasCount;
            document.getElementById('count-parpol').innerText = filteredParpolCount;
            document.getElementById('count-aduan').innerText = filteredAduanCount;
            document.getElementById('count-kerawanan').innerText = filteredHotspots.length;
            document.getElementById('count-rekomendasi').innerText = filteredRekomendasiCount;
            document.getElementById('badge-hotspot-count').innerText = filteredHotspots.length + ' Titik';

            // Update Hotspot Sidebar List
            const listContainer = document.getElementById('hotspots-list-container');
            listContainer.innerHTML = '';
            if (filteredHotspots.length === 0) {
                listContainer.innerHTML = '<div class="text-muted small text-center py-4">Belum ada titik kerawanan di periode ini.</div>';
            } else {
                filteredHotspots.forEach(h => {
                    let badgeClass = h.level === 'Tinggi' ? 'badge bg-danger-subtle text-danger border border-danger-subtle' : (h.level === 'Sedang' ? 'badge bg-warning-subtle text-warning border border-warning-subtle' : 'badge bg-info-subtle text-info border border-info-subtle');
                    const item = document.createElement('div');
                    item.className = 'd-flex justify-content-between align-items-center p-2 rounded hotspot-item';
                    item.style = 'background: var(--card-bg); border: 1px solid var(--border-color); cursor: pointer; margin-bottom: 8px;';
                    item.onclick = () => focusHotspot(h.id);
                    item.innerHTML = `
                        <div class="min-w-0 flex-grow-1">
                            <div class="fw-bold text-white small text-truncate">${h.nama}</div>
                            <div class="text-muted" style="font-size: 0.7rem;">
                                <span class="${badgeClass} py-0 px-1.5" style="font-size: 0.65rem;">${h.level}</span>
                                &bull; Klik untuk fokus
                            </div>
                        </div>
                        <div class="text-danger small"><i class="fa-solid fa-crosshairs"></i></div>
                    `;
                    listContainer.appendChild(item);
                });
            }
        }

        // Initial render based on dropdown values
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

        // Add Layer Filters Control
        const overlayMaps = {
            "<span style='color: var(--text-main); font-weight: 500;'><i class='fa-solid fa-building-shield text-danger me-1'></i> Kantor Kesbangpol</span>": officeGroup,
            "<span style='color: var(--text-main); font-weight: 500;'><i class='fa-solid fa-users text-primary me-1'></i> Organisasi Ormas</span>": ormasGroup,
            "<span style='color: var(--text-main); font-weight: 500;'><i class='fa-solid fa-building-flag text-warning me-1'></i> Partai Politik</span>": parpolGroup,
            "<span style='color: var(--text-main); font-weight: 500;'><i class='fa-solid fa-bullhorn text-danger me-1'></i> Laporan Pengaduan</span>": pengaduanGroup,
            "<span style='color: var(--text-main); font-weight: 500;'><i class='fa-solid fa-calendar-check me-1' style='color:#a855f7;'></i> Rekomendasi Kegiatan</span>": rekomendasiGroup,
            "<span style='color: var(--text-main); font-weight: 500;'><i class='fa-solid fa-triangle-exclamation text-warning me-1 animate-pulse'></i> Titik Kerawanan Konflik</span>": hotspotGroup
        };
        
        L.control.layers(baseMaps, overlayMaps, { collapsed: false, position: 'topright' }).addTo(map);

        // Global function to fly to hotspots
        window.focusHotspot = function(id) {
            let marker = hotspotMarkers[id];
            if (marker) {
                let latlng = marker.getLatLng();
                map.flyTo(latlng, 15, { animate: true, duration: 1.2 });
                marker.openPopup();
            }
        };
    });
</script>

<?= $this->endSection() ?>
