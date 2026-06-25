<?= $this->extend('layouts/admin') ?>

<?= $this->section('styles') ?>
<link rel="stylesheet" href="https://unpkg.com/leaflet@1.9.4/dist/leaflet.css" crossorigin="" />
<style>
    .form-card {
        background: var(--card-bg);
        border: 1px solid var(--border-color);
        border-radius: 16px;
        padding: 30px;
    }

    #form-map {
        height: 350px;
        border-radius: 10px;
        border: 1px solid var(--border-color);
    }
    .wa-link {
        transition: all 0.2s ease;
    }
    .wa-link:hover {
        text-decoration: underline !important;
        opacity: 0.85;
    }
</style>
<?= $this->endSection() ?>

<?= $this->section('content') ?>

<?php
$is_edit = !empty($pendaftaran);
$nama_ormas = old('nama_ormas') ?? ($pendaftaran['nama_ormas'] ?? '');
$alamat = old('alamat') ?? ($pendaftaran['alamat'] ?? '');
$email = old('email') ?? ($pendaftaran['email'] ?? '');
$telepon = old('telepon') ?? ($pendaftaran['telepon'] ?? '');
$tgl_sk = old('tgl_sk_kepengurusan') ?? ($pendaftaran['tgl_sk_kepengurusan'] ?? '');
$tgl_exp = old('tgl_sk_kedaluwarsa') ?? ($pendaftaran['tgl_sk_kedaluwarsa'] ?? '');
$lat = old('latitude') ?? ($pendaftaran['latitude'] ?? '');
$lng = old('longitude') ?? ($pendaftaran['longitude'] ?? '');
?>

<div class="row justify-content-center">
    <div class="col-lg-10">
        <!-- Back button & Page Title -->
        <div class="d-flex justify-content-between align-items-center mb-4 flex-wrap gap-2">
            <div>
                <a href="<?= base_url('user') ?>" class="btn btn-sm btn-outline-secondary text-white px-3 rounded-pill">
                    <i class="fa-solid fa-arrow-left me-1"></i> Kembali ke Dasbor
                </a>
                <h3 class="text-white fw-bold mt-3 mb-0">
                    <i class="fa-solid fa-file-pen text-primary me-2"></i>
                    <?= $is_edit ? 'Revisi Pengajuan Pendaftaran Ormas' : 'Form Pengajuan Pendaftaran Ormas Baru' ?>
                </h3>
            </div>
        </div>

        <?php if ($is_edit && $pendaftaran['status_verifikasi'] === 'Rejected'): ?>
            <div class="alert alert-danger bg-danger-subtle border-danger-subtle text-danger p-3 rounded mb-4" role="alert" style="border-radius: 12px;">
                <h6 class="fw-bold mb-1"><i class="fa-solid fa-circle-xmark me-2"></i>Catatan Penolakan Admin:</h6>
                <p class="small mb-0 italic">"<?= esc($pendaftaran['alasan_ditolak']) ?>"</p>
            </div>
        <?php endif; ?>

        <div class="form-card glass-card">
            <form action="<?= base_url('user/pengajuan/simpan') ?>" method="POST" enctype="multipart/form-data">
                <?= csrf_field() ?>
                <?php if ($is_edit): ?>
                    <input type="hidden" name="pendaftaran_id" value="<?= esc($pendaftaran['id']) ?>">
                <?php endif; ?>

                <!-- Notice Board -->
                <div class="alert alert-info bg-primary-subtle border-primary-subtle text-primary-light p-4 mb-4" role="alert" style="border-radius: 12px; font-size: 0.95rem; line-height: 1.6;">
                    <p class="mb-2">Hai, Selamat Datang di Pelayanan Registrasi Laporan Keberadaan Ormas/Yayasan/Perkumpulan Kabupaten Sinjai. Isi formulir dengan benar dan teliti.</p>
                    <p class="mb-2">Silahkan unduh format dokumen pelaporan resmi: <a href="https://drive.google.com/uc?export=download&id=1XqCYdQYp87AXN4RGMvJqJKslvA05nRNR" id="download-template-link" class="text-primary fw-bold text-decoration-none" target="_blank"><i class="fa-solid fa-download ms-1"></i> Klik Disini untuk Mengunduh</a></p>
                    <hr class="my-3 border-primary-subtle">
                    <p class="mb-0 fw-semibold text-white">
                        <i class="fa-solid fa-phone-volume me-2"></i>Silahkan konfirmasi melalui whatsapp apabila mengalami kendala: 
                        <a href="https://wa.me/6281280799020?text=Halo%20Bapak%20Endang,%20saya%20mengalami%20kendala%20saat%20mengisi%20formulir%20registrasi%20ormas." target="_blank" class="text-success text-decoration-none fw-bold wa-link">
                            Bapak Endang Saryono (0812 8079 9020) <i class="fa-brands fa-whatsapp ms-1"></i>
                        </a>
                    </p>
                </div>

                <!-- Progress Bar Pengisian (Opsi E) -->
                <div class="mb-4 p-3 rounded" style="background: rgba(255, 255, 255, 0.02); border: 1px solid var(--border-color); border-radius: 12px;">
                    <div class="d-flex justify-content-between align-items-center mb-2">
                        <span class="small fw-bold text-white"><i class="fa-solid fa-spinner fa-spin me-2 text-warning" id="progress-spinner"></i>Progres Pengisian Formulir</span>
                        <span class="badge bg-danger text-white fw-bold" id="progress-percentage-label">0% Lengkap</span>
                    </div>
                    <div class="progress" style="height: 10px; background-color: var(--hr-border); border-radius: 6px; overflow: hidden;">
                        <div class="progress-bar progress-bar-striped progress-bar-animated bg-danger" id="progress-bar-fill" role="progressbar" style="width: 0%" aria-valuenow="0" aria-valuemin="0" aria-valuemax="100"></div>
                    </div>
                    <div class="form-text text-muted small mt-1.5" style="font-size:0.78rem;">Lengkapi seluruh bidang wajib dan dokumen persyaratan untuk mencapai 100%.</div>
                </div>

                <h5 class="text-white fw-bold mb-3 border-bottom border-secondary border-opacity-10 pb-2">1. Informasi Dasar Organisasi</h5>
                <div class="row g-3 mb-4">
                    <div class="col-md-6">
                        <label for="nama_ormas" class="form-label small text-muted">Nama Ormas / Lembaga / Yayasan <span class="text-danger fw-bold">*</span></label>
                        <input type="text" name="nama_ormas" id="nama_ormas" class="form-control form-control-custom" placeholder="Masukkan nama resmi organisasi" value="<?= esc($nama_ormas) ?>" required>
                    </div>
                    <div class="col-md-6">
                        <label for="tipe_ormas" class="form-label small text-muted">Tipe Organisasi <span class="text-danger fw-bold">*</span></label>
                        <select class="form-select form-control-custom" id="tipe_ormas" name="tipe_ormas" required onchange="toggleOrmasRequirements(this.value)">
                            <option value="Lokal">Ormas Lokal (Penerbitan SKT)</option>
                            <option value="Berjenjang">Ormas Berjenjang (Penerbitan Surat Keberadaan)</option>
                        </select>
                    </div>
                    <div class="col-md-6">
                        <label for="telepon" class="form-label small text-muted">Nomor Telepon / WhatsApp Kontak <span class="text-danger fw-bold">*</span></label>
                        <input type="text" name="telepon" id="telepon" class="form-control form-control-custom" placeholder="Contoh: 08123456789" value="<?= esc($telepon) ?>" required>
                    </div>
                    <div class="col-md-6">
                        <label for="email" class="form-label small text-muted">Email Kontak Organisasi</label>
                        <input type="email" name="email" id="email" class="form-control form-control-custom" placeholder="organisasi@domain.com" value="<?= esc($email) ?>">
                    </div>
                    <div class="col-md-12">
                        <label for="alamat" class="form-label small text-muted">Alamat Kantor Sekretariat <span class="text-danger fw-bold">*</span></label>
                        <textarea name="alamat" id="alamat" class="form-control form-control-custom" rows="2" placeholder="Tulis alamat kantor sekretariat lengkap dengan kecamatan/kelurahan" required><?= esc($alamat) ?></textarea>
                        <div class="d-flex justify-content-between align-items-center mt-2 flex-wrap gap-2">
                            <span id="geocode-status" class="small text-muted" style="font-size: 11px;"></span>
                            <button type="button" id="btn-geocode" class="btn btn-sm btn-outline-info px-3 rounded-pill text-white" style="font-size: 11px; border-color: rgba(13, 202, 240, 0.4);">
                                <i class="fa-solid fa-location-crosshairs me-1 text-info"></i> Deteksi Titik Koordinat
                            </button>
                        </div>
                    </div>
                </div>

                <h5 class="text-white fw-bold mb-3 border-bottom border-secondary border-opacity-10 pb-2">2. Legalitas & Masa Kepengurusan</h5>
                <div class="row g-3 mb-4">
                    <div class="col-md-6">
                        <label for="tgl_sk_kepengurusan" class="form-label small text-muted">Tanggal Mulai SK Kepengurusan</label>
                        <input type="date" name="tgl_sk_kepengurusan" id="tgl_sk_kepengurusan" class="form-control form-control-custom" value="<?= esc($tgl_sk) ?>">
                    </div>
                    <div class="col-md-6">
                        <label for="tgl_sk_kedaluwarsa" class="form-label small text-muted">Tanggal Kedaluwarsa SK Kepengurusan</label>
                        <input type="date" name="tgl_sk_kedaluwarsa" id="tgl_sk_kedaluwarsa" class="form-control form-control-custom" value="<?= esc($tgl_exp) ?>">
                    </div>
                </div>

                <h5 class="text-white fw-bold mb-3 border-bottom border-secondary border-opacity-10 pb-2">3. Lokasi Geografis Kantor Sekretariat</h5>
                <p class="text-muted small mb-2"><i class="fa-solid fa-circle-info text-info me-1"></i>Tentukan titik koordinat sekretariat pada peta interaktif di bawah ini untuk memudahkan pemetaan database GIS Kesbangpol. Klik pada peta atau drag marker biru ke posisi yang tepat.</p>
                
                <div class="row g-3 mb-3">
                    <div class="col-sm-6">
                        <label for="latitude" class="form-label small text-muted">Latitude (Lintang)</label>
                        <input type="number" step="any" name="latitude" id="latitude" class="form-control form-control-custom" placeholder="Contoh: -5.1489" value="<?= esc($lat) ?>">
                    </div>
                    <div class="col-sm-6">
                        <label for="longitude" class="form-label small text-muted">Longitude (Bujur)</label>
                        <input type="number" step="any" name="longitude" id="longitude" class="form-control form-control-custom" placeholder="Contoh: 120.1294" value="<?= esc($lng) ?>">
                    </div>
                </div>
                <div id="form-map" class="mb-4"></div>

                <!-- Dynamic Requirements List -->
                <div class="mb-4">
                    <div class="p-4 rounded border" style="background: rgba(255, 255, 255, 0.02); border-color: var(--border-color) !important; border-radius: 12px;">
                        <h6 class="text-white fw-bold mb-3"><i class="fa-solid fa-list-check text-warning me-2"></i>Daftar Berkas Persyaratan (Harap Gabung Menjadi 1 File PDF/ZIP):</h6>
                        
                        <div id="lokal-requirements" class="small text-muted">
                            <ol class="mb-0 ps-3 d-flex flex-column gap-2" style="font-size: 0.88rem; list-style-type: decimal;">
                                <li>Surat Permohonan ditujukan kepada Menteri (Cq. Kaban Kesbangpol)</li>
                                <li>Anggaran Dasar (AD) & Anggaran Rumah Tangga (ART)</li>
                                <li>Akta Pendirian Notaris (memuat Nama, Lambang, Asas, Tujuan, Pengurus, Hak, Keuangan, dll.)</li>
                                <li>Surat Pernyataan Keabsahan Dokumen (Meterai Rp 10.000)</li>
                                <li>Program Kerja Organisasi & Struktur Organisasi Resmi</li>
                                <li>Surat Keterangan Domisili Kantor Sekretariat</li>
                                <li>NPWP atas nama Organisasi</li>
                                <li>Formulir Isian Data Ormas (ditandatangani Ketua & Sekretaris)</li>
                                <li>Surat Rekomendasi Kementerian Agama (Ormas Agama) / Kebudayaan</li>
                                <li>Biodata & KTP Pengurus (Ketua, Sekretaris, Bendahara)</li>
                                <li>Pasfoto Pengurus 4x6 cm 2 Lembar (Latar Merah)</li>
                                <li>SK Pengurus & Foto Sekretariat (Tampak depan menampilkan Papan Nama)</li>
                                <li>Surat Perjanjian Kontrak/Izin Pakai Gedung dari Pemilik Gedung</li>
                                <li>Nomor Rekening Organisasi & File Logo Organisasi</li>
                            </ol>
                        </div>

                        <div id="berjenjang-requirements" class="small text-muted d-none">
                            <ol class="mb-0 ps-3 d-flex flex-column gap-2" style="font-size: 0.88rem; list-style-type: decimal;">
                                <li>Surat Permohonan ditujukan kepada Kepala Badan Kesbangpol Kab. Sinjai</li>
                                <li>Surat Pernyataan Resmi (Meterai Rp 10.000)</li>
                                <li>Surat Keterangan Domisili (Alamat domisili kop surat & sekretariat)</li>
                                <li>Formulir Isian Data Ormas (ditandatangani Ketua & Sekretaris)</li>
                                <li>Pasfoto Pengurus ukuran 4x6 cm sebanyak 2 lembar</li>
                                <li>Fotokopi KTP Pengurus (Ketua, Sekretaris, Bendahara)</li>
                                <li>Surat Keputusan (SK) Pengurus Organisasi</li>
                                <li>Foto Sekretariat (Tampak depan menampilkan Papan Nama resmi)</li>
                            </ol>
                        </div>
                    </div>
                </div>

                <h5 class="text-white fw-bold mb-3 border-bottom border-secondary border-opacity-10 pb-2">4. Unggah Lampiran Dokumen</h5>
                <div class="row g-3 mb-4">
                    <div class="col-md-6">
                        <label for="file_logo" class="form-label small text-muted">
                            Logo Organisasi (Format Gambar)
                            <?php if ($is_edit): ?>
                                <span class="badge bg-secondary-subtle text-white font-normal ms-1">Sudah ada berkas</span>
                            <?php endif; ?>
                        </label>
                        <input type="file" name="file_logo" id="file_logo" class="form-control form-control-custom" accept="image/*">
                        <?php if ($is_edit): ?>
                            <span class="text-muted small d-block mt-1">Biarkan kosong jika tidak ingin mengubah logo yang sudah diunggah.</span>
                        <?php endif; ?>
                    </div>
                    <div class="col-md-6">
                        <label for="file_berkas" class="form-label small text-muted">
                            Berkas Legalitas / AD-ART / Surat Pengajuan (Format PDF/ZIP) 
                            <?php if (!$is_edit): ?><span class="text-danger fw-bold">*</span><?php endif; ?>
                            <?php if ($is_edit): ?>
                                <span class="badge bg-secondary-subtle text-white font-normal ms-1">Sudah ada berkas</span>
                            <?php endif; ?>
                        </label>
                        <input type="file" name="file_berkas" id="file_berkas" class="form-control form-control-custom" accept=".pdf,.zip" <?php if (!$is_edit) echo 'required'; ?>>
                        <?php if ($is_edit): ?>
                            <span class="text-muted small d-block mt-1">Biarkan kosong jika tidak ingin mengubah berkas legalitas.</span>
                        <?php endif; ?>
                    </div>
                </div>

                <div class="d-flex justify-content-end gap-2 border-top border-secondary border-opacity-10 pt-4 mt-4">
                    <a href="<?= base_url('user') ?>" class="btn btn-secondary text-white">Batal</a>
                    <button type="submit" class="btn btn-portal text-white fw-bold">
                        <i class="fa-solid fa-paper-plane me-1"></i> Kirim Pengajuan
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>

<?= $this->endSection() ?>

<?= $this->section('scripts') ?>
<script src="https://unpkg.com/leaflet@1.9.4/dist/leaflet.js" crossorigin=""></script>
<script>
// Toggle requirements list based on Ormas type (Global)
function toggleOrmasRequirements(value) {
    const lokalRequirements = document.getElementById('lokal-requirements');
    const berjenjangRequirements = document.getElementById('berjenjang-requirements');
    const downloadLink = document.getElementById('download-template-link');
    
    if (value === 'Lokal') {
        if (lokalRequirements) lokalRequirements.classList.remove('d-none');
        if (berjenjangRequirements) berjenjangRequirements.classList.add('d-none');
        if (downloadLink) downloadLink.href = "https://drive.google.com/uc?export=download&id=1XqCYdQYp87AXN4RGMvJqJKslvA05nRNR";
    } else {
        if (lokalRequirements) lokalRequirements.classList.add('d-none');
        if (berjenjangRequirements) berjenjangRequirements.classList.remove('d-none');
        if (downloadLink) downloadLink.href = "https://drive.google.com/uc?export=download&id=1UX2CJCfXpWZUix7o-j3jY9cld63dX7KS";
    }
}

document.addEventListener('DOMContentLoaded', function() {
    const latInput = document.getElementById('latitude');
    const lngInput = document.getElementById('longitude');

    let initialLat = latInput.value ? parseFloat(latInput.value) : -5.1489;
    let initialLng = lngInput.value ? parseFloat(lngInput.value) : 120.1294;

    const centerCoords = [initialLat, initialLng];

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

    const map = L.map('form-map', {
        center: centerCoords,
        zoom: 13,
        layers: [osm]
    });

    const baseMaps = {
        "Peta Standar (OSM)": osm,
        "Satelit (Esri)": satellite,
        "Topografi (TopoMap)": terrain
    };

    L.control.layers(baseMaps).addTo(map);

    let marker = null;

    if (latInput.value && lngInput.value) {
        marker = L.marker(centerCoords, { draggable: true }).addTo(map);
        bindMarkerEvents(marker);
    }

    map.on('click', function(e) {
        const lat = e.latlng.lat.toFixed(6);
        const lng = e.latlng.lng.toFixed(6);
        latInput.value = lat;
        lngInput.value = lng;
        
        if (marker) {
            marker.setLatLng(e.latlng);
        } else {
            marker = L.marker(e.latlng, { draggable: true }).addTo(map);
            bindMarkerEvents(marker);
        }
        updateFormProgress();
    });

    function bindMarkerEvents(m) {
        m.on('dragend', function(event) {
            const position = event.target.getLatLng();
            latInput.value = position.lat.toFixed(6);
            lngInput.value = position.lng.toFixed(6);
            updateFormProgress();
        });
    }

    latInput.addEventListener('change', updateMarkerFromInputs);
    lngInput.addEventListener('change', updateMarkerFromInputs);

    function updateMarkerFromInputs() {
        const lat = parseFloat(latInput.value);
        const lng = parseFloat(lngInput.value);
        if (!isNaN(lat) && !isNaN(lng)) {
            const newLatLng = L.latLng(lat, lng);
            if (marker) {
                marker.setLatLng(newLatLng);
            } else {
                marker = L.marker(newLatLng, { draggable: true }).addTo(map);
                bindMarkerEvents(marker);
            }
            map.panTo(newLatLng);
            updateFormProgress();
        }
    }

    // Auto-geocoding ketika mengetik alamat kantor sekretariat
    const alamatTextarea = document.getElementById('alamat');
    const geocodeStatus = document.getElementById('geocode-status');
    const btnGeocode = document.getElementById('btn-geocode');
    let geocodeTimeout = null;

    function performGeocoding(query, isManual) {
        if (!query || query.length < 5) {
            if (isManual) {
                geocodeStatus.innerHTML = '<span class="text-warning"><i class="fa-solid fa-circle-info"></i> Masukkan alamat minimal 5 karakter.</span>';
            }
            return;
        }

        // Set loading state
        geocodeStatus.innerHTML = '<span class="text-info"><i class="fa-solid fa-spinner fa-spin"></i> Sedang melacak lokasi...</span>';
        btnGeocode.disabled = true;
        const originalBtnHTML = btnGeocode.innerHTML;
        btnGeocode.innerHTML = '<i class="fa-solid fa-spinner fa-spin me-1"></i> Melacak...';

        fetch(`<?= base_url('user/geocode') ?>?q=${encodeURIComponent(query)}`)
            .then(response => response.json())
            .then(data => {
                if (data && data.length > 0) {
                    const lat = parseFloat(data[0].lat);
                    const lon = parseFloat(data[0].lon);
                    
                    latInput.value = lat.toFixed(6);
                    lngInput.value = lon.toFixed(6);
                    
                    const newLatLng = L.latLng(lat, lon);
                    if (marker) {
                        marker.setLatLng(newLatLng);
                    } else {
                        marker = L.marker(newLatLng, { draggable: true }).addTo(map);
                        bindMarkerEvents(marker);
                    }
                    map.setView(newLatLng, 15);
                    geocodeStatus.innerHTML = '<span class="text-success"><i class="fa-solid fa-circle-check"></i> Lokasi berhasil dideteksi!</span>';
                    updateFormProgress();
                } else {
                    geocodeStatus.innerHTML = '<span class="text-warning"><i class="fa-solid fa-triangle-exclamation"></i> Lokasi tidak ditemukan. Coba perjelas nama jalan/kecamatan.</span>';
                }
            })
            .catch(err => {
                console.error("Geocoding error:", err);
                geocodeStatus.innerHTML = '<span class="text-danger"><i class="fa-solid fa-circle-xmark"></i> Gagal menghubungkan ke layanan pemetaan.</span>';
            })
            .finally(() => {
                btnGeocode.disabled = false;
                btnGeocode.innerHTML = originalBtnHTML;
            });
    }

    alamatTextarea.addEventListener('input', function() {
        clearTimeout(geocodeTimeout);
        const query = this.value.trim();
        if (query.length < 5) {
            geocodeStatus.innerHTML = '';
            return;
        }
        geocodeTimeout = setTimeout(function() {
            performGeocoding(query, false);
        }, 1500); // Debounce 1.5 detik saat mengetik agar tidak terlalu sering memanggil API
    });

    btnGeocode.addEventListener('click', function() {
        clearTimeout(geocodeTimeout);
        const query = alamatTextarea.value.trim();
        performGeocoding(query, true);
    });

    // Live Progress Calculation
    const isEdit = <?= $is_edit ? 'true' : 'false' ?>;

    function updateFormProgress() {
        let progress = 0;

        // 1. Nama Ormas (15%)
        const namaOrmas = document.getElementById('nama_ormas')?.value || '';
        if (namaOrmas.trim().length > 2) {
            progress += 15;
        }

        // 2. Tipe Ormas (10%)
        const tipeOrmas = document.getElementById('tipe_ormas')?.value || '';
        if (tipeOrmas !== '') {
            progress += 10;
        }

        // 3. Telepon (15%)
        const telepon = document.getElementById('telepon')?.value || '';
        if (telepon.trim().length > 5) {
            progress += 15;
        }

        // 4. Alamat (15%)
        const alamat = document.getElementById('alamat')?.value || '';
        if (alamat.trim().length > 5) {
            progress += 15;
        }

        // 5. Latitude & Longitude (10%)
        const latVal = document.getElementById('latitude')?.value || '';
        const lngVal = document.getElementById('longitude')?.value || '';
        if (latVal !== '' && lngVal !== '') {
            progress += 10;
        }

        // 6. Tanggal SK Kepengurusan (5%) & Kedaluwarsa (5%)
        const tglSk = document.getElementById('tgl_sk_kepengurusan')?.value || '';
        const tglExp = document.getElementById('tgl_sk_kedaluwarsa')?.value || '';
        if (tglSk !== '') {
            progress += 5;
        }
        if (tglExp !== '') {
            progress += 5;
        }

        // 7. File Berkas (25%)
        const fileInput = document.getElementById('file_berkas');
        if ((fileInput && fileInput.files && fileInput.files.length > 0) || isEdit) {
            progress += 25;
        }

        // Update UI Progress Bar
        const progressBarFill = document.getElementById('progress-bar-fill');
        const progressLabel = document.getElementById('progress-percentage-label');
        const spinner = document.getElementById('progress-spinner');

        if (progressBarFill && progressLabel) {
            progressBarFill.style.width = progress + '%';
            progressBarFill.setAttribute('aria-valuenow', progress);
            progressLabel.innerText = progress + '% Lengkap';

            // Adjust color classes
            progressBarFill.className = 'progress-bar progress-bar-striped progress-bar-animated';
            progressLabel.className = 'badge fw-bold';

            if (progress < 40) {
                progressBarFill.classList.add('bg-danger');
                progressLabel.classList.add('bg-danger', 'text-white');
            } else if (progress < 80) {
                progressBarFill.classList.add('bg-warning');
                progressLabel.classList.add('bg-warning', 'text-dark');
            } else {
                progressBarFill.classList.add('bg-success');
                progressLabel.classList.add('bg-success', 'text-white');
                if (spinner) {
                    spinner.className = 'fa-solid fa-circle-check me-2 text-success animate-pulse';
                }
            }
        }
    }

    // Bind events for progress tracking
    const progressFields = [
        'nama_ormas', 'tipe_ormas', 'telepon', 'alamat', 
        'latitude', 'longitude', 'tgl_sk_kepengurusan', 'tgl_sk_kedaluwarsa'
    ];
    progressFields.forEach(id => {
        const el = document.getElementById(id);
        if (el) {
            el.addEventListener('input', updateFormProgress);
            el.addEventListener('change', updateFormProgress);
        }
    });

    const fileEl = document.getElementById('file_berkas');
    if (fileEl) {
        fileEl.addEventListener('change', updateFormProgress);
    }

    // Call toggle on load to show initial state
    const tipeOrmasEl = document.getElementById('tipe_ormas');
    if (tipeOrmasEl) {
        toggleOrmasRequirements(tipeOrmasEl.value);
    }

    // Initial progress calculation
    updateFormProgress();
});
</script>
<?= $this->endSection() ?>
