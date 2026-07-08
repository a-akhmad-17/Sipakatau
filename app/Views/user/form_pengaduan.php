<?= $this->extend('layouts/admin') ?>

<?= $this->section('styles') ?>
<link rel="stylesheet" href="https://unpkg.com/leaflet@1.9.4/dist/leaflet.css" crossorigin="" />
<?= $this->endSection() ?>

<?= $this->section('content') ?>
<div class="container-fluid px-0">
    <!-- Header / Breadcrumbs -->
    <div class="d-flex justify-content-between align-items-center mb-4 pb-2 border-bottom" style="border-color: var(--border-color) !important;">
        <div>
            <h3 class="mb-1 font-heading" style="color: var(--text-main);"><i class="fa-solid fa-bullhorn text-danger me-2"></i>Buat Laporan Pengaduan Baru</h3>
            <p class="small mb-0" style="color: var(--text-muted);">Laporkan pelanggaran, konflik sosial, atau keluhan layanan secara langsung dan aman.</p>
        </div>
        <div>
            <a href="<?= base_url('user') ?>" class="btn btn-outline-secondary text-white">
                <i class="fa-solid fa-arrow-left me-1.5"></i>Kembali
            </a>
        </div>
    </div>

    <!-- Form Pengaduan Card -->
    <div class="glass-card p-4">
        <div class="alert alert-warning bg-warning-subtle border-warning-subtle text-warning d-flex align-items-center gap-3 mb-4" role="alert" style="border-radius: 12px;">
            <i class="fa-solid fa-user-shield fa-lg"></i>
            <div>
                <strong>Laporan Anda Dijamin Rahasia!</strong> Identitas pelapor dienkripsi secara aman dalam sistem untuk melindungi privasi Anda.
            </div>
        </div>

        <form action="<?= base_url('informasi/pengaduan') ?>" method="POST" enctype="multipart/form-data">
            <?= csrf_field() ?>
            
            <div class="row g-3 mb-4">
                <div class="col-md-6">
                    <label for="judul" class="form-label small text-muted">Judul Pengaduan / Topik Laporan *</label>
                    <input type="text" class="form-control form-control-custom py-3" id="judul" name="judul" placeholder="Tulis ringkasan laporan Anda..." required autocomplete="off">
                </div>

                <div class="col-md-6">
                    <label for="kategori" class="form-label small text-muted">Kategori Laporan *</label>
                    <select class="form-select form-control-custom py-3" id="kategori" name="kategori" required>
                        <option value="" disabled selected>Pilih Kategori...</option>
                        <option value="konflik">Potensi Konflik Sosial SARA</option>
                        <option value="ormas">Pelanggaran/Ketertiban Ormas &amp; LSM</option>
                        <option value="politik">Pelanggaran Kampanye / Politik Praktis</option>
                        <option value="layanan">Keluhan Pelayanan Kesbangpol</option>
                        <option value="lainnya">Lainnya</option>
                    </select>
                </div>

                <div class="col-md-6">
                    <label for="bidang_id" class="form-label small text-muted">Ditujukan ke Bidang Kerja (Opsional)</label>
                    <select class="form-select form-control-custom py-3" id="bidang_id" name="bidang_id">
                        <option value="" selected>Umum / Seluruhnya (Bukan Bidang Khusus)</option>
                        <?php foreach ($bidang as $b): ?>
                            <option value="<?= esc($b['id']) ?>"><?= esc($b['nama_bidang']) ?></option>
                        <?php endforeach; ?>
                    </select>
                </div>

                <div class="col-md-6">
                    <label for="berkas" class="form-label small text-muted">Lampiran Bukti (Gambar / Dokumen PDF)</label>
                    <input type="file" class="form-control form-control-custom py-3" id="berkas" name="berkas" accept=".jpg,.jpeg,.png,.webp,.pdf,.zip">
                    <div class="form-text small" style="color: var(--text-muted); font-size: 11px;">Maksimal 10MB. Format didukung: PDF, ZIP, Gambar (JPG, PNG, WebP)</div>
                </div>

                <div class="col-md-12">
                    <label for="deskripsi" class="form-label small text-muted">Uraian / Deskripsi Lengkap Pengaduan *</label>
                    <textarea class="form-control form-control-custom" id="deskripsi" name="deskripsi" rows="5" placeholder="Tulis kronologi kejadian secara lengkap, sertakan lokasi, waktu, dan pihak yang terlibat..." required></textarea>
                </div>

                <div class="col-md-12 mt-2">
                    <label class="form-label small text-white fw-bold"><i class="fa-solid fa-map-location-dot text-warning me-2"></i>Lokasi Kejadian <span class="text-muted fw-normal">(Opsional)</span></label>
                    <p class="text-muted mb-2" style="font-size: 11.5px;"><i class="fa-solid fa-circle-info text-info me-1"></i>Masukkan <strong>link Google Maps</strong>, <strong>nama jalan/tempat</strong>, atau <strong>koordinat</strong> (lat,lng). Peta di bawah akan otomatis menyesuaikan. Atau klik langsung pada peta.</p>
                    <!-- Smart Location Input -->
                    <div class="position-relative mb-2" id="lokasi-wrapper">
                        <div class="input-group">
                            <span class="input-group-text bg-transparent border-end-0" style="border-color: rgba(255,255,255,0.1); border-radius: 10px 0 0 10px;">
                                <i class="fa-solid fa-location-dot text-warning" id="icon-type"></i>
                            </span>
                            <input type="text" id="lokasi_input" name="lokasi_pengaduan" class="form-control form-control-custom border-start-0" style="border-radius: 0 10px 10px 0;" placeholder="Cth: Jl. Persatuan Raya, atau link maps.google.com/..., atau -5.1489,120.1294" autocomplete="off">
                            <button type="button" class="btn btn-sm btn-outline-secondary ms-2 text-muted" onclick="clearLocation()" style="border-radius: 8px; font-size: 11px;" title="Hapus lokasi"><i class="fa-solid fa-xmark"></i></button>
                        </div>
                        <!-- Dropdown suggestions -->
                        <div id="lokasi-suggestions" class="position-absolute w-100 mt-1 rounded shadow-lg d-none" style="z-index: 9999; background: var(--sidebar-bg); border: 1px solid var(--border-color); max-height: 200px; overflow-y: auto;"></div>
                    </div>
                    <!-- Status badge -->
                    <div id="lokasi-status" class="mb-2"></div>
                    <!-- Map -->
                    <div id="form-map-pengaduan" class="mb-2" style="height:300px; border-radius:12px; border:1px solid rgba(255,255,255,0.08);"></div>
                </div>
            </div>

            <!-- Action Buttons -->
            <div class="d-flex justify-content-end gap-3 border-top pt-4" style="border-color: var(--border-color) !important;">
                <a href="<?= base_url('user') ?>" class="btn btn-outline-secondary px-4 py-2.5">Batal</a>
                <button type="submit" class="btn btn-danger text-white px-5 py-2.5">
                    <i class="fa-solid fa-paper-plane me-2"></i> Kirim Laporan Pengaduan
                </button>
            </div>
        </form>
    </div>
</div>
<?= $this->endSection() ?>

<?= $this->section('scripts') ?>
<script src="https://unpkg.com/leaflet@1.9.4/dist/leaflet.js" crossorigin=""></script>
<script>
document.addEventListener('DOMContentLoaded', function() {
    const lokasiInput = document.getElementById('lokasi_input');
    const suggestions = document.getElementById('lokasi-suggestions');
    const statusEl    = document.getElementById('lokasi-status');
    const iconEl      = document.getElementById('icon-type');

    let marker = null;
    let debounceTimer = null;

    const map = L.map('form-map-pengaduan', { center: [-5.1489, 120.1294], zoom: 13 });
    const osmLayer = L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
        maxZoom: 19, attribution: '&copy; OpenStreetMap contributors'
    }).addTo(map);
    const sat     = L.tileLayer('https://server.arcgisonline.com/ArcGIS/rest/services/World_Imagery/MapServer/tile/{z}/{y}/{x}', { maxZoom: 19, attribution: '&copy; Esri' });
    const terrain = L.tileLayer('https://{s}.tile.opentopomap.org/{z}/{x}/{y}.png', { maxZoom: 17, attribution: '&copy; OpenStreetMap contributors' });
    L.control.layers({'Peta Standar (OSM)': osmLayer, 'Satelit (Esri)': sat, 'Topografi': terrain}).addTo(map);

    // Klik langsung di peta
    map.on('click', function(e) {
        placeMarker(e.latlng.lat, e.latlng.lng);
        setStatus('success', '<i class="fa-solid fa-check-circle text-success me-1"></i>Titik lokasi ditetapkan di peta.');
    });

    function placeMarker(lat, lng) {
        if (marker) { marker.setLatLng([lat, lng]); }
        else {
            marker = L.marker([lat, lng], { draggable: true }).addTo(map);
            marker.on('dragend', function() {
                setStatus('success', '<i class="fa-solid fa-check-circle text-success me-1"></i>Titik lokasi diperbarui.');
            });
        }
    }

    function setCoords(lat, lng) {
        map.setView([parseFloat(lat), parseFloat(lng)], 15);
        placeMarker(parseFloat(lat), parseFloat(lng));
    }

    function setStatus(type, html) {
        const c = { success:'#22c55e', error:'#ef4444', info:'#60a5fa', loading:'#94a3b8' };
        statusEl.innerHTML = '<span style="font-size:11.5px;color:' + (c[type]||'#aaa') + '">' + html + '</span>';
    }

    function parseGoogleMapsUrl(url) {
        let m;
        m = url.match(/@(-?\d+\.\d+),(-?\d+\.\d+)/); if (m) return {lat:m[1],lng:m[2]};
        m = url.match(/[?&]q=(-?\d+\.\d+),(-?\d+\.\d+)/); if (m) return {lat:m[1],lng:m[2]};
        m = url.match(/[?&]ll=(-?\d+\.\d+),(-?\d+\.\d+)/); if (m) return {lat:m[1],lng:m[2]};
        return null;
    }

    function parseManualCoords(text) {
        const m = text.trim().match(/^(-?\d+\.\d+)[,\s]+(-?\d+\.\d+)$/);
        return m ? {lat:m[1],lng:m[2]} : null;
    }

    function searchNominatim(query) {
        setStatus('loading', '<i class="fa-solid fa-spinner fa-spin me-1"></i>Mencari lokasi...');
        fetch('https://nominatim.openstreetmap.org/search?q=' + encodeURIComponent(query + ' Sinjai Sulawesi Selatan') + '&format=json&limit=6&countrycodes=id', { headers:{'Accept-Language':'id'} })
            .then(r => r.json())
            .then(results => {
                if (!results.length) { setStatus('error', '<i class="fa-solid fa-circle-xmark text-danger me-1"></i>Lokasi tidak ditemukan.'); hideSuggestions(); return; }
                showSuggestions(results);
                setStatus('info', '<i class="fa-solid fa-list me-1 text-info"></i>Ditemukan ' + results.length + ' hasil. Pilih salah satu.');
            })
            .catch(() => setStatus('error', '<i class="fa-solid fa-wifi text-danger me-1"></i>Gagal terhubung ke layanan pencarian.'));
    }

    function showSuggestions(results) {
        suggestions.innerHTML = ''; suggestions.classList.remove('d-none');
        results.forEach(r => {
            const item = document.createElement('div');
            item.className = 'px-3 py-2';
            item.style.cssText = 'cursor:pointer;font-size:12.5px;border-bottom:1px solid rgba(255,255,255,0.05);color:var(--text-main);';
            item.innerHTML = '<i class="fa-solid fa-map-pin text-warning me-2"></i>' + r.display_name;
            item.addEventListener('mouseenter', () => item.style.background = 'rgba(255,255,255,0.05)');
            item.addEventListener('mouseleave', () => item.style.background = '');
            item.addEventListener('click', () => {
                lokasiInput.value = r.display_name;
                setCoords(r.lat, r.lon);
                setStatus('success', '<i class="fa-solid fa-check-circle text-success me-1"></i>Lokasi ditetapkan: ' + r.display_name.split(',')[0]);
                hideSuggestions();
            });
            suggestions.appendChild(item);
        });
    }

    function hideSuggestions() { suggestions.classList.add('d-none'); suggestions.innerHTML = ''; }

    window.clearLocation = function() {
        lokasiInput.value = ''; statusEl.innerHTML = '';
        hideSuggestions();
        if (marker) { map.removeLayer(marker); marker = null; }
        map.setView([-5.1489, 120.1294], 13);
        iconEl.className = 'fa-solid fa-location-dot text-warning';
    };

    lokasiInput.addEventListener('input', function() {
        const val = this.value.trim();
        hideSuggestions();
        if (!val) { clearLocation(); return; }

        if (val.includes('maps.google') || val.includes('google.com/maps') || val.includes('maps.app.goo.gl')) {
            iconEl.className = 'fa-brands fa-google text-danger';
            const coords = parseGoogleMapsUrl(val);
            if (coords) { setCoords(coords.lat, coords.lng); setStatus('success', '<i class="fa-solid fa-check-circle text-success me-1"></i>Link Google Maps dikenali. Titik lokasi ditampilkan di peta.'); }
            else { setStatus('error', '<i class="fa-solid fa-circle-xmark text-danger me-1"></i>Link tidak mengandung koordinat. Salin URL lengkap dari address bar.'); }
            return;
        }

        const coords = parseManualCoords(val);
        if (coords) {
            iconEl.className = 'fa-solid fa-crosshairs text-info';
            setCoords(coords.lat, coords.lng);
            setStatus('success', '<i class="fa-solid fa-check-circle text-success me-1"></i>Koordinat dikenali dan ditampilkan di peta.');
            return;
        }

        iconEl.className = 'fa-solid fa-magnifying-glass text-warning';
        clearTimeout(debounceTimer);
        debounceTimer = setTimeout(() => { if (val.length >= 4) searchNominatim(val); }, 600);
    });

    document.addEventListener('click', e => {
        if (!document.getElementById('lokasi-wrapper').contains(e.target)) hideSuggestions();
    });
});
</script>
<?= $this->endSection() ?>
