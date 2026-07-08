<?= $this->extend('layouts/admin') ?>

<?= $this->section('styles') ?>
<link rel="stylesheet" href="https://unpkg.com/leaflet@1.9.4/dist/leaflet.css" crossorigin="" />
<style>
    #form-map {
        height: 320px;
        border-radius: 12px;
        border: 1px solid var(--border-color);
    }
    .form-header-title {
        font-family: 'Outfit', sans-serif;
        font-weight: 800;
        font-size: 1.5rem;
        color: var(--text-main);
        text-transform: uppercase;
        border-bottom: 3px solid #be123c;
        padding-bottom: 15px;
        margin-bottom: 25px;
    }
    .wa-link {
        transition: all 0.2s ease;
    }
    .wa-link:hover {
        text-decoration: underline !important;
        opacity: 0.85;
    }
    .table-custom th {
        background: rgba(255, 255, 255, 0.02);
        color: var(--text-muted);
        font-weight: 600;
        font-size: 0.78rem;
        text-transform: uppercase;
        letter-spacing: 0.5px;
    }
    .table-custom td {
        border-color: rgba(255, 255, 255, 0.05);
        color: var(--text-main);
    }
</style>
<?= $this->endSection() ?>

<?= $this->section('content') ?>
<div class="container-fluid px-0">
    <!-- Header / Breadcrumbs -->
    <div class="d-flex justify-content-between align-items-center mb-4 pb-2 border-bottom" style="border-color: var(--border-color) !important;">
        <div>
            <h3 class="mb-1 font-heading" style="color: var(--text-main);"><i class="fa-solid fa-calendar-check text-success me-2"></i>Pengajuan Rekomendasi Kegiatan</h3>
            <p class="small mb-0" style="color: var(--text-muted);">Ajukan surat rekomendasi izin pelaksanaan kegiatan organisasi kemasyarakatan / yayasan.</p>
        </div>
        <div>
            <a href="<?= base_url('user') ?>" class="btn btn-outline-secondary text-white">
                <i class="fa-solid fa-arrow-left me-1.5"></i>Kembali
            </a>
        </div>
    </div>

    <div class="glass-card p-4">
        <!-- Notice Board (Shortcut & WA Support) -->
        <div class="alert alert-info bg-primary-subtle border-primary-subtle text-primary-light p-4 mb-4" role="alert" style="border-radius: 12px; font-size: 0.95rem; line-height: 1.6;">
            <p class="mb-2">Hai, Selamat Datang di Pelayanan Rekomendasi Kegiatan Kabupaten Sinjai. Isi formulir dengan benar dan teliti.</p>
            <p class="mb-2">Silahkan unduh format dokumen rekomendasi resmi: <a href="https://drive.google.com/uc?export=download&id=1WsgeJzVebDi-eGE9B7uYifcAiW05hxgW" class="text-primary fw-bold text-decoration-none"><i class="fa-solid fa-download ms-1"></i> Klik Disini untuk Mengunduh</a></p>
            <hr class="my-3 border-primary-subtle">
            <p class="mb-0 fw-semibold text-white">
                <i class="fa-solid fa-phone-volume me-2"></i>Silahkan konfirmasi melalui whatsapp apabila mengalami kendala: 
                <a href="https://wa.me/628117671545?text=Halo%20Kesbangpol%20Sinjai,%20saya%20mengalami%20kendala%20saat%20mengisi%20formulir%20rekomendasi%20kegiatan." target="_blank" class="text-success text-decoration-none fw-bold wa-link">
                    Kesbangpol Sinjai (0811-7671-545) <i class="fa-brands fa-whatsapp ms-1"></i>
                </a>
            </p>
        </div>

        <!-- Progress Bar Pengisian -->
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

        <form action="<?= base_url('layanan/rekomendasi') ?>" method="POST" enctype="multipart/form-data">
            <?= csrf_field() ?>

            <div class="row g-3 mb-4">
                <div class="col-md-6">
                    <label for="pemohon" class="form-label small text-muted">Nama Pemohon / Peneliti / Lembaga *</label>
                    <input type="text" class="form-control form-control-custom py-3" id="pemohon" name="pemohon" placeholder="Nama lengkap pemohon atau nama lembaga/organisasi" required>
                </div>

                <div class="col-md-6">
                    <label for="nama_kegiatan" class="form-label small text-muted">Judul / Tema Kegiatan *</label>
                    <input type="text" class="form-control form-control-custom py-3" id="nama_kegiatan" name="nama_kegiatan" placeholder="Nama atau tema kegiatan yang diajukan" required>
                </div>

                <div class="col-md-6">
                    <label for="tgl_mulai" class="form-label small text-muted">Tanggal Mulai Kegiatan *</label>
                    <input type="date" class="form-control form-control-custom py-3" id="tgl_mulai" name="tgl_mulai" required>
                </div>

                <div class="col-md-6">
                    <label for="tgl_selesai" class="form-label small text-muted">Tanggal Selesai Kegiatan *</label>
                    <input type="date" class="form-control form-control-custom py-3" id="tgl_selesai" name="tgl_selesai" required>
                </div>

                <div class="col-md-12">
                    <label for="deskripsi" class="form-label small text-muted">Deskripsi Rencana Kegiatan / Lokasi Sasaran *</label>
                    <textarea class="form-control form-control-custom" id="deskripsi" name="deskripsi" rows="4" placeholder="Jelaskan rincian agenda dan instansi sasaran kegiatan di Kabupaten Sinjai..." required></textarea>
                </div>

                <div class="col-md-12 mt-4">
                    <label class="form-label small text-white fw-bold"><i class="fa-solid fa-map-location-dot text-success me-2"></i>Lokasi Sasaran Kegiatan</label>
                    <p class="text-muted mb-2" style="font-size: 11.5px;"><i class="fa-solid fa-circle-info text-info me-1"></i>Masukkan <strong>link Google Maps</strong>, <strong>nama jalan/tempat</strong>, atau <strong>koordinat</strong> (lat,lng). Peta di bawah akan otomatis menyesuaikan.</p>
                    <!-- Smart Location Input -->
                    <div class="position-relative mb-2" id="lokasi-wrapper">
                        <div class="input-group">
                            <span class="input-group-text bg-transparent border-end-0" style="border-color: rgba(255,255,255,0.1); border-radius: 10px 0 0 10px;" id="lokasi-icon">
                                <i class="fa-solid fa-location-dot text-success" id="icon-type"></i>
                            </span>
                            <input type="text" id="lokasi_input" name="lokasi_kegiatan" class="form-control form-control-custom border-start-0" style="border-radius: 0 10px 10px 0;" placeholder="Cth: Jl. Persatuan Raya, atau link maps.google.com/..., atau -5.1489,120.1294" autocomplete="off">
                            <button type="button" class="btn btn-sm btn-outline-secondary ms-2 text-muted" onclick="clearLocation()" style="border-radius: 8px; font-size: 11px;" title="Hapus lokasi"><i class="fa-solid fa-xmark"></i></button>
                        </div>
                        <!-- Dropdown suggestions -->
                        <div id="lokasi-suggestions" class="position-absolute w-100 mt-1 rounded shadow-lg d-none" style="z-index: 9999; background: var(--sidebar-bg); border: 1px solid var(--border-color); max-height: 200px; overflow-y: auto;"></div>
                    </div>
                    <!-- Status badge -->
                    <div id="lokasi-status" class="mb-2"></div>
                    <!-- Map preview -->
                    <div id="form-map" class="mb-2" style="height:320px; border-radius:12px; border:1px solid rgba(255,255,255,0.08);"></div>
                </div>
            </div>

            <!-- Documents Table Section -->
            <div class="mb-4">
                <h5 class="text-white fw-bold mb-3 font-heading"><i class="fa-solid fa-file-shield text-warning me-2"></i>Dokumen Persyaratan Kegiatan</h5>
                
                <?php
                $requirements = [
                    [
                        "id" => 1,
                        "name" => "Surat Permohonan",
                        "desc" => "Surat Permohonan Rekomendasi Kegiatan ditujukan kepada Kepala Badan Kesbangpol Kab. Sinjai",
                        "template" => "https://drive.google.com/uc?export=download&id=1WsgeJzVebDi-eGE9B7uYifcAiW05hxgW",
                        "required" => true
                    ],
                    [
                        "id" => 2,
                        "name" => "Rekomendasi Lurah/Camat",
                        "desc" => "Surat Rekomendasi Kegiatan dari Kantor Lurah setempat dan diketahui Camat",
                        "template" => "",
                        "required" => true
                    ],
                    [
                        "id" => 3,
                        "name" => "Proposal Kegiatan",
                        "desc" => "Proposal Kegiatan lengkap (berisi latar belakang, rencana acara, sasaran, dll.)",
                        "template" => "",
                        "required" => true
                    ],
                    [
                        "id" => 4,
                        "name" => "KTP Ketua Panitia",
                        "desc" => "Fotokopi KTP Ketua Panitia Pelaksana / Pemohon",
                        "template" => "",
                        "required" => true
                    ],
                    [
                        "id" => 5,
                        "name" => "SK Pengurus Kegiatan",
                        "desc" => "Surat Keputusan (SK) Pengurus Kegiatan",
                        "template" => "",
                        "required" => true
                    ],
                    [
                        "id" => 6,
                        "name" => "Rekomendasi Stakeholder",
                        "desc" => "Surat Rekomendasi pendukung dari Stakeholder terkait (Opsional)",
                        "template" => "",
                        "required" => false
                    ]
                ];
                ?>

                <div class="table-responsive">
                    <table class="table table-custom mb-0" style="font-size: 0.85rem;">
                        <thead>
                            <tr style="background: rgba(255, 255, 255, 0.02);">
                                <th class="text-center" style="width: 4%;">#</th>
                                <th style="width: 45%;">Persyaratan Dokumen</th>
                                <th class="text-center" style="width: 15%;">Status</th>
                                <th class="text-center" style="width: 15%;">Format / Template</th>
                                <th style="width: 21%;">Pilih Berkas</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php foreach ($requirements as $req): ?>
                                <tr>
                                    <td class="text-center align-middle"><?= $req['id'] ?></td>
                                    <td class="align-middle">
                                        <div class="fw-semibold text-white small"><?= esc($req['name']) ?> <?php if ($req['required']): ?><span class="text-danger">*</span><?php endif; ?></div>
                                        <div class="text-muted small" style="font-size: 0.72rem;"><?= esc($req['desc']) ?></div>
                                    </td>
                                    <td class="text-center align-middle" id="status-badge-<?= $req['id'] ?>">
                                        <span class="badge bg-danger-subtle text-danger border border-danger-subtle small"><i class="fa-solid fa-circle-xmark me-1"></i> Belum Ada</span>
                                    </td>
                                    <td class="text-center align-middle">
                                        <?php if (!empty($req['template'])): ?>
                                            <a href="<?= $req['template'] ?>" target="_blank" class="btn btn-sm btn-outline-warning py-1 px-2" style="font-size: 0.7rem;" title="Download Format <?= esc($req['name']) ?>">
                                                <i class="fa-solid fa-download me-1"></i> Format
                                            </a>
                                        <?php else: ?>
                                            <span class="text-muted small">-</span>
                                        <?php endif; ?>
                                    </td>
                                    <td class="align-middle">
                                        <div class="d-flex align-items-center gap-2">
                                            <label class="btn btn-sm btn-outline-secondary mb-0 py-1 px-2.5" style="cursor: pointer; font-size: 0.72rem;">
                                                <i class="fa-solid fa-cloud-arrow-up me-1"></i> Pilih File
                                                <input type="file" name="file_proposal_<?= $req['id'] ?>" id="file_proposal_<?= $req['id'] ?>" class="d-none berkas-file-input" data-index="<?= $req['id'] ?>" data-required="<?= $req['required'] ? 'true' : 'false' ?>" accept=".pdf,.zip,.jpg,.jpeg,.png,.webp" onchange="handleFileInputChange(this, <?= $req['id'] ?>)">
                                            </label>
                                            <span id="file-chosen-name-<?= $req['id'] ?>" class="small text-success fw-bold text-truncate d-none" style="max-width: 120px;"></span>
                                        </div>
                                    </td>
                                </tr>
                            <?php endforeach; ?>
                        </tbody>
                    </table>
                </div>
            </div>

            <!-- Action Buttons -->
            <div class="d-flex justify-content-end gap-3 border-top pt-4" style="border-color: var(--border-color) !important;">
                <a href="<?= base_url('user') ?>" class="btn btn-outline-secondary px-4 py-2.5">Batal</a>
                <button type="submit" class="btn btn-warning text-white px-5 py-2.5">
                    <i class="fa-solid fa-paper-plane me-2"></i> Ajukan Rekomendasi
                </button>
            </div>
        </form>
    </div>
</div>
<?= $this->endSection() ?>

<?= $this->section('scripts') ?>
<script>
    // File input change detector
    function handleFileInputChange(input, index) {
        const badge = document.getElementById(`status-badge-${index}`);
        const chosenSpan = document.getElementById(`file-chosen-name-${index}`);

        if (input.files && input.files[0]) {
            const file = input.files[0];
            const maxSize = 10 * 1024 * 1024; // 10MB
            
            if (file.size > maxSize) {
                alert('Ukuran berkas melebihi batas maksimum 10MB! Silakan pilih file yang lebih kecil.');
                input.value = ''; // Reset input
                badge.innerHTML = `<span class="badge bg-danger-subtle text-danger border border-danger-subtle small"><i class="fa-solid fa-circle-xmark me-1"></i> Belum Ada</span>`;
                chosenSpan.classList.add('d-none');
                chosenSpan.innerText = '';
                updateFormProgress();
                return;
            }

            // Update UI status to 'Terpilih'
            badge.innerHTML = `<span class="badge bg-success-subtle text-success border border-success-subtle small"><i class="fa-solid fa-circle-check me-1"></i> Terpilih</span>`;
            chosenSpan.classList.remove('d-none');
            chosenSpan.innerText = file.name;
        } else {
            badge.innerHTML = `<span class="badge bg-danger-subtle text-danger border border-danger-subtle small"><i class="fa-solid fa-circle-xmark me-1"></i> Belum Ada</span>`;
            chosenSpan.classList.add('d-none');
            chosenSpan.innerText = '';
        }
        updateFormProgress();
    }

    // Auto-save & Restore Draft using localStorage
    document.addEventListener('DOMContentLoaded', () => {
        const formFields = ['pemohon', 'nama_kegiatan', 'tgl_mulai', 'tgl_selesai', 'deskripsi'];
        const form = document.querySelector('form');

        // Restore values if draft exists
        const savedDraft = localStorage.getItem('draft_rekomendasi');
        if (savedDraft) {
            try {
                const draftData = JSON.parse(savedDraft);
                let restoredCount = 0;
                formFields.forEach(field => {
                    const el = document.getElementById(field);
                    if (el && draftData[field] !== undefined) {
                        el.value = draftData[field];
                        restoredCount++;
                    }
                });

                if (restoredCount > 0 && window.showToast) {
                    window.showToast('Berhasil memulihkan draf pengisian formulir sebelumnya.', 'info');
                }
            } catch (e) {
                console.error("Gagal memulihkan draf rekomendasi:", e);
            }
        }

        // Save values on input change
        const saveDraft = () => {
            const draftData = {};
            formFields.forEach(field => {
                const el = document.getElementById(field);
                if (el) {
                    draftData[field] = el.value;
                }
            });
            localStorage.setItem('draft_rekomendasi', JSON.stringify(draftData));
        };

        formFields.forEach(field => {
            const el = document.getElementById(field);
            if (el) {
                el.addEventListener('input', saveDraft);
                el.addEventListener('change', saveDraft);
            }
        });

        // Clear draft on successful form submit
        if (form) {
            form.addEventListener('submit', (e) => {
                // Validate required files via JS since they are hidden (d-none)
                const fileInputs = document.querySelectorAll('.berkas-file-input');
                let isValid = true;
                let missingDocs = [];

                fileInputs.forEach(input => {
                    const isRequired = input.getAttribute('data-required') === 'true';
                    if (isRequired && (!input.files || input.files.length === 0)) {
                        isValid = false;
                        const row = input.closest('tr');
                        const docName = row ? row.querySelector('.fw-semibold').textContent.replace('*', '').trim() : 'Dokumen';
                        missingDocs.push(docName);
                    }
                });

                if (!isValid) {
                    e.preventDefault();
                    alert('Harap unggah semua dokumen persyaratan wajib:\n- ' + missingDocs.join('\n- '));
                    return false;
                }

                localStorage.removeItem('draft_rekomendasi');
            });
        }

        // Run initial check
        updateFormProgress();
    });

    // Live Progress Calculation
    function updateFormProgress() {
        let progress = 0;

        // 1. Pemohon (10%)
        const pemohon = document.getElementById('pemohon')?.value || '';
        if (pemohon.trim().length > 2) {
            progress += 10;
        }

        // 2. Nama Kegiatan (10%)
        const namaKegiatan = document.getElementById('nama_kegiatan')?.value || '';
        if (namaKegiatan.trim().length > 2) {
            progress += 10;
        }

        // 3. Tanggal Mulai (10%)
        const tglMulai = document.getElementById('tgl_mulai')?.value || '';
        if (tglMulai !== '') {
            progress += 10;
        }

        // 4. Tanggal Selesai (10%)
        const tglSelesai = document.getElementById('tgl_selesai')?.value || '';
        if (tglSelesai !== '') {
            progress += 10;
        }

        // 5. Deskripsi (10%)
        const deskripsi = document.getElementById('deskripsi')?.value || '';
        if (deskripsi.trim().length > 5) {
            progress += 10;
        }

        // 6. Required Files (10% each for first 5 files)
        for (let i = 1; i <= 5; i++) {
            const fileInput = document.getElementById(`file_proposal_${i}`);
            if (fileInput && fileInput.files && fileInput.files.length > 0) {
                progress += 10;
            }
        }

        // Update UI Progress Bar
        const progressBarFill = document.getElementById('progress-bar-fill');
        const progressLabel = document.getElementById('progress-percentage-label');
        const spinner = document.getElementById('progress-spinner');

        if (progressBarFill && progressLabel) {
            if (progress > 100) progress = 100;

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

    // Bind text inputs to progress check
    const textInputs = ['pemohon', 'nama_kegiatan', 'tgl_mulai', 'tgl_selesai', 'deskripsi'];
    textInputs.forEach(id => {
        const el = document.getElementById(id);
        if (el) {
            el.addEventListener('input', updateFormProgress);
            el.addEventListener('change', updateFormProgress);
        }
    });
</script>
<script src="https://unpkg.com/leaflet@1.9.4/dist/leaflet.js" crossorigin=""></script>
<script>
document.addEventListener('DOMContentLoaded', function() {
    const lokasiInput = document.getElementById('lokasi_input');
    const suggestions = document.getElementById('lokasi-suggestions');
    const statusEl    = document.getElementById('lokasi-status');
    const iconEl      = document.getElementById('icon-type');

    let marker = null;
    let debounceTimer = null;

    // --- Init Map immediately on load ---
    const map = L.map('form-map', { center: [-5.1489, 120.1294], zoom: 13 });
    const osmLayer = L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
        maxZoom: 19, attribution: '&copy; OpenStreetMap contributors'
    }).addTo(map);
    const sat = L.tileLayer('https://server.arcgisonline.com/ArcGIS/rest/services/World_Imagery/MapServer/tile/{z}/{y}/{x}', {
        maxZoom: 19, attribution: '&copy; Esri'
    });
    const terrain = L.tileLayer('https://{s}.tile.opentopomap.org/{z}/{x}/{y}.png', {
        maxZoom: 17, attribution: '&copy; OpenStreetMap contributors'
    });
    L.control.layers({'Peta Standar (OSM)': osmLayer, 'Satelit (Esri)': sat, 'Topografi': terrain}).addTo(map);

    // Klik langsung di peta → pasang marker (visual saja)
    map.on('click', function(e) {
        placeMarker(e.latlng.lat, e.latlng.lng);
        setStatus('success', '<i class="fa-solid fa-check-circle text-success me-1"></i>Titik lokasi ditetapkan di peta.');
    });

    function initMap(lat, lng) {
        map.setView([lat, lng], 15);
        placeMarker(lat, lng);
    }

    function placeMarker(lat, lng) {
        if (marker) {
            marker.setLatLng([lat, lng]);
        } else {
            marker = L.marker([lat, lng], { draggable: true }).addTo(map);
            marker.on('dragend', function() {
                setStatus('success', '<i class="fa-solid fa-check-circle text-success me-1"></i>Titik lokasi diperbarui dari drag marker.');
            });
        }
    }

    function setCoords(lat, lng) {
        initMap(parseFloat(lat), parseFloat(lng));
    }

    function setStatus(type, html) {
        const colors = { success: '#22c55e', error: '#ef4444', info: '#60a5fa', loading: '#94a3b8' };
        statusEl.innerHTML = `<span style="font-size:11.5px; color:${colors[type]||'#aaa'}">${html}</span>`;
    }

    function parseGoogleMapsUrl(url) {
        let m;
        m = url.match(/@(-?\d+\.\d+),(-?\d+\.\d+)/);
        if (m) return { lat: m[1], lng: m[2] };
        m = url.match(/[?&]q=(-?\d+\.\d+),(-?\d+\.\d+)/);
        if (m) return { lat: m[1], lng: m[2] };
        m = url.match(/[?&]ll=(-?\d+\.\d+),(-?\d+\.\d+)/);
        if (m) return { lat: m[1], lng: m[2] };
        return null;
    }

    function parseManualCoords(text) {
        const m = text.trim().match(/^(-?\d+\.\d+)[,\s]+(-?\d+\.\d+)$/);
        if (m) return { lat: m[1], lng: m[2] };
        return null;
    }

    function searchNominatim(query) {
        setStatus('loading', '<i class="fa-solid fa-spinner fa-spin me-1"></i>Mencari lokasi...');
        const url = `https://nominatim.openstreetmap.org/search?q=${encodeURIComponent(query + ' Sinjai Sulawesi Selatan')}&format=json&limit=6&countrycodes=id`;
        fetch(url, { headers: { 'Accept-Language': 'id' } })
            .then(r => r.json())
            .then(results => {
                if (!results.length) {
                    setStatus('error', '<i class="fa-solid fa-circle-xmark text-danger me-1"></i>Lokasi tidak ditemukan. Coba nama lain.');
                    hideSuggestions(); return;
                }
                showSuggestions(results);
                setStatus('info', `<i class="fa-solid fa-list me-1 text-info"></i>Ditemukan ${results.length} hasil. Pilih salah satu.`);
            })
            .catch(() => setStatus('error', '<i class="fa-solid fa-wifi text-danger me-1"></i>Gagal terhubung ke layanan pencarian.'));
    }

    function showSuggestions(results) {
        suggestions.innerHTML = '';
        suggestions.classList.remove('d-none');
        results.forEach(r => {
            const item = document.createElement('div');
            item.className = 'px-3 py-2 suggestion-item';
            item.style.cssText = 'cursor:pointer; font-size:12.5px; border-bottom:1px solid rgba(255,255,255,0.05); color:var(--text-main);';
            item.innerHTML = `<i class="fa-solid fa-map-pin text-success me-2"></i>${r.display_name}`;
            item.addEventListener('mouseenter', () => item.style.background = 'rgba(255,255,255,0.05)');
            item.addEventListener('mouseleave', () => item.style.background = '');
            item.addEventListener('click', () => {
                lokasiInput.value = r.display_name;
                setCoords(r.lat, r.lon);
                setStatus('success', `<i class="fa-solid fa-check-circle text-success me-1"></i>Lokasi ditetapkan: ${r.display_name.split(',')[0]}`);
                hideSuggestions();
            });
            suggestions.appendChild(item);
        });
    }

    function hideSuggestions() { suggestions.classList.add('d-none'); suggestions.innerHTML = ''; }

    window.clearLocation = function() {
        lokasiInput.value  = '';
        statusEl.innerHTML = '';
        hideSuggestions();
        if (marker) { map.removeLayer(marker); marker = null; }
        map.setView([-5.1489, 120.1294], 13);
        iconEl.className = 'fa-solid fa-location-dot text-success';
    };

    lokasiInput.addEventListener('input', function() {
        const val = this.value.trim();
        hideSuggestions();
        if (!val) { clearLocation(); return; }

        if (val.includes('maps.google') || val.includes('google.com/maps') || val.includes('maps.app.goo.gl')) {
            iconEl.className = 'fa-brands fa-google text-danger';
            const coords = parseGoogleMapsUrl(val);
            if (coords) {
                setCoords(coords.lat, coords.lng);
                setStatus('success', `<i class="fa-solid fa-check-circle text-success me-1"></i>Link Google Maps dikenali. Titik lokasi ditampilkan di peta.`);
            } else {
                setStatus('error', '<i class="fa-solid fa-circle-xmark text-danger me-1"></i>Link Google Maps tidak mengandung koordinat. Salin URL lengkap dari address bar.');
            }
            return;
        }

        const coords = parseManualCoords(val);
        if (coords) {
            iconEl.className = 'fa-solid fa-crosshairs text-info';
            setCoords(coords.lat, coords.lng);
            setStatus('success', `<i class="fa-solid fa-check-circle text-success me-1"></i>Koordinat dikenali dan ditampilkan di peta.`);
            return;
        }

        iconEl.className = 'fa-solid fa-magnifying-glass text-warning';
        clearTimeout(debounceTimer);
        debounceTimer = setTimeout(() => {
            if (val.length >= 4) searchNominatim(val);
        }, 600);
    });

    document.addEventListener('click', e => {
        if (!document.getElementById('lokasi-wrapper').contains(e.target)) hideSuggestions();
    });
});
</script>
<?= $this->endSection() ?>
