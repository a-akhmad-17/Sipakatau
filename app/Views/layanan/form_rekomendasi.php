<?= $this->extend('layouts/main') ?>

<?= $this->section('styles') ?>
<style>
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
    .dropzone-area {
        border: 2px dashed var(--border-color);
        background: var(--input-bg);
        border-radius: 12px;
        padding: 40px 20px;
        text-align: center;
        cursor: pointer;
        transition: all 0.3s ease;
        position: relative;
    }
    .dropzone-area:hover, .dropzone-area.dragover {
        border-color: #be123c;
        background: rgba(190, 18, 60, 0.05);
    }
    .dropzone-icon {
        font-size: 3rem;
        color: var(--text-muted);
        margin-bottom: 15px;
        transition: color 0.3s ease;
    }
    .dropzone-area:hover .dropzone-icon {
        color: #be123c;
    }
    .file-input {
        position: absolute;
        width: 100%;
        height: 100%;
        top: 0;
        left: 0;
        opacity: 0;
        cursor: pointer;
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

<div class="py-4" style="max-width: 900px; margin: 0 auto;">
    <div class="glass-card">
        <h2 class="form-header-title">FORM REKOMENDASI KEGIATAN</h2>

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

        <!-- Notice Board Requirements -->
        <div class="alert alert-warning bg-warning-subtle border-warning-subtle text-warning p-4 mb-4" role="alert" style="border-radius: 12px; font-size: 0.95rem; line-height: 1.6;">
            <h5 class="fw-bold mb-2"><i class="fa-solid fa-circle-info fa-lg me-2"></i>Persyaratan Rekomendasi Kegiatan:</h5>
            <ol class="mb-0 ps-3">
                <li>Surat Permohonan Rekomendasi Kegiatan ditujukan kepada Kepala Badan Kesbangpol Kab. Sinjai</li>
                <li>Surat Rekomendasi Kegiatan dari Kantor Lurah setempat dan diketahui Camat</li>
                <li>Proposal Kegiatan lengkap (berisi latar belakang, rencana acara, sasaran, dll.)</li>
                <li>Fotokopi KTP Ketua Panitia Pelaksana / Pemohon</li>
                <li>Surat Keputusan (SK) Pengurus Kegiatan</li>
                <li>Surat Rekomendasi pendukung dari Stakeholder terkait</li>
            </ol>
            <p class="mt-2 mb-0 fw-semibold text-white">* Harap gabungkan seluruh berkas persyaratan di atas menjadi satu file PDF/ZIP sebelum diunggah.</p>
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

                <!-- Dropzone Area -->
                <div class="col-md-12">
                    <label class="form-label small text-muted">Berkas Persyaratan Gabungan *</label>
                    <div class="dropzone-area" id="dropzone">
                        <i class="fa-solid fa-cloud-arrow-up dropzone-icon" id="dropzone-icon"></i>
                        <h5 class="text-white mb-1" id="dropzone-text">Unggah berkas persyaratan gabungan</h5>
                        <p class="text-muted small mb-0">Seret ke sini atau klik untuk memilih berkas PDF/ZIP (Maks 10MB)</p>
                        <input type="file" class="file-input" name="file_proposal" id="file_proposal" required onchange="handleFileChange(this)">
                    </div>
                </div>
            </div>

            <!-- Action Buttons -->
            <div class="d-flex justify-content-end gap-3">
                <a href="<?= base_url() ?>" class="btn btn-outline-secondary px-4 py-3">Batal</a>
                <button type="submit" class="btn btn-warning text-white px-5 py-3">
                    <i class="fa-solid fa-paper-plane me-2"></i> Ajukan Rekomendasi
                </button>
            </div>
        </form>
    </div>
</div>

<?= $this->endSection() ?>

<?= $this->section('scripts') ?>
<script>
    const dropzone = document.getElementById('dropzone');
    const dropzoneText = document.getElementById('dropzone-text');
    const dropzoneIcon = document.getElementById('dropzone-icon');

    // Drag-over hover states
    ['dragenter', 'dragover'].forEach(eventName => {
        dropzone.addEventListener(eventName, (e) => {
            e.preventDefault();
            dropzone.classList.add('dragover');
        }, false);
    });

    ['dragleave', 'drop'].forEach(eventName => {
        dropzone.addEventListener(eventName, (e) => {
            e.preventDefault();
            dropzone.classList.remove('dragover');
        }, false);
    });

    // File input change detector
    function handleFileChange(input) {
        if (input.files && input.files[0]) {
            const file = input.files[0];
            const maxSize = 10 * 1024 * 1024; // 10MB
            
            if (file.size > maxSize) {
                if (window.showToast) {
                    window.showToast('Ukuran berkas melebihi batas maksimum 10MB! Silakan pilih file yang lebih kecil.', 'danger');
                } else {
                    alert('Ukuran berkas melebihi batas maksimum 10MB! Silakan pilih file yang lebih kecil.');
                }
                input.value = ''; // Reset input
                dropzoneText.innerText = 'Unggah berkas persyaratan gabungan';
                dropzoneText.classList.remove('text-success');
                dropzoneText.classList.add('text-white');
                dropzoneIcon.classList.remove('fa-file-shield');
                dropzoneIcon.classList.add('fa-cloud-arrow-up');
                dropzoneIcon.style.color = '';
                return;
            }

            const fileName = file.name;
            dropzoneText.innerText = fileName;
            dropzoneText.classList.remove('text-white');
            dropzoneText.classList.add('text-success');
            dropzoneIcon.classList.remove('fa-cloud-arrow-up');
            dropzoneIcon.classList.add('fa-file-shield');
            dropzoneIcon.style.color = '#be123c';
        }
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
            form.addEventListener('submit', () => {
                localStorage.removeItem('draft_rekomendasi');
            });
        }

        // Live Progress Calculation
        function updateFormProgress() {
            let progress = 0;

            // 1. Pemohon (15%)
            const pemohon = document.getElementById('pemohon')?.value || '';
            if (pemohon.trim().length > 2) {
                progress += 15;
            }

            // 2. Nama Kegiatan (15%)
            const namaKegiatan = document.getElementById('nama_kegiatan')?.value || '';
            if (namaKegiatan.trim().length > 2) {
                progress += 15;
            }

            // 3. Tanggal Mulai (15%)
            const tglMulai = document.getElementById('tgl_mulai')?.value || '';
            if (tglMulai !== '') {
                progress += 15;
            }

            // 4. Tanggal Selesai (15%)
            const tglSelesai = document.getElementById('tgl_selesai')?.value || '';
            if (tglSelesai !== '') {
                progress += 15;
            }

            // 5. Deskripsi (20%)
            const deskripsi = document.getElementById('deskripsi')?.value || '';
            if (deskripsi.trim().length > 5) {
                progress += 20;
            }

            // 6. File Proposal/Berkas (20%)
            const fileInput = document.getElementById('file_proposal');
            if (fileInput && fileInput.files && fileInput.files.length > 0) {
                progress += 20;
            }

            // Update UI Progress Bar
            const progressBarFill = document.getElementById('progress-bar-fill');
            const progressLabel = document.getElementById('progress-percentage-label');
            const spinner = document.getElementById('progress-spinner');

            if (progressBarFill && progressLabel) {
                // Ensure max is 100%
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

        // Bind events
        const allInputs = ['pemohon', 'nama_kegiatan', 'tgl_mulai', 'tgl_selesai', 'deskripsi'];
        allInputs.forEach(id => {
            const el = document.getElementById(id);
            if (el) {
                el.addEventListener('input', updateFormProgress);
                el.addEventListener('change', updateFormProgress);
            }
        });
        const fileEl = document.getElementById('file_proposal');
        if (fileEl) {
            fileEl.addEventListener('change', updateFormProgress);
        }

        // Run initial check
        updateFormProgress();
    });
</script>
<?= $this->endSection() ?>
