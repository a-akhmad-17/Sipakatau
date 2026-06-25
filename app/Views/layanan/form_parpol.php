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
</style>
<?= $this->endSection() ?>

<?= $this->section('content') ?>

<div class="py-4" style="max-width: 900px; margin: 0 auto;">
    <div class="glass-card">
        <h2 class="form-header-title">FORM REGISTER PARTAI POLITIK KABUPATEN SINJAI</h2>

        <div class="alert alert-success bg-success-subtle border-success-subtle text-success p-3 mb-4" role="alert" style="border-radius: 12px; font-size: 0.95rem;">
            <i class="fa-solid fa-circle-check fa-lg me-2"></i> Pendaftaran kepengurusan Partai Politik tingkat Kabupaten Sinjai untuk verifikasi berkas administrasi dan fasilitasi Kesbangpol.
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

        <form action="<?= base_url('layanan/parpol') ?>" method="POST" enctype="multipart/form-data">
            <?= csrf_field() ?>

            <div class="row g-3 mb-4">
                <div class="col-md-6">
                    <label for="nama_parpol" class="form-label small text-muted">Nama Partai Politik *</label>
                    <input type="text" class="form-control form-control-custom py-3" id="nama_parpol" name="nama_parpol" placeholder="Contoh: Partai Gerakan Indonesia Raya" required>
                </div>

                <div class="col-md-6">
                    <label for="ketua" class="form-label small text-muted">Nama Ketua DPC / DPD *</label>
                    <input type="text" class="form-control form-control-custom py-3" id="ketua" name="ketua" placeholder="Nama lengkap Ketua beserta gelar" required>
                </div>

                <div class="col-md-6">
                    <label for="telepon" class="form-label small text-muted">Nomor Telepon Kantor *</label>
                    <input type="text" class="form-control form-control-custom py-3" id="telepon" name="telepon" placeholder="Nomor Telp / Handphone DPC" required>
                </div>

                <div class="col-md-6">
                    <label for="alamat" class="form-label small text-muted">Alamat Sekretariat DPC *</label>
                    <input type="text" class="form-control form-control-custom py-3" id="alamat" name="alamat" placeholder="Jl. Persatuan Raya, Sinjai" required>
                </div>

                <!-- Dropzone Area Logo -->
                <div class="col-md-6">
                    <label class="form-label small text-muted">Lambang / Foto Partai (Format Gambar) <span class="text-danger fw-bold">*</span></label>
                    <div class="dropzone-area" id="dropzone_logo" style="padding: 20px 10px;">
                        <i class="fa-solid fa-image dropzone-icon" id="dropzone-logo-icon" style="font-size: 2rem; color: var(--text-muted);"></i>
                        <h6 class="text-white mb-1" id="dropzone-logo-text" style="font-size: 0.9rem;">Unggah Lambang Partai</h6>
                        <p class="text-muted small mb-0" style="font-size: 0.75rem;">PNG, JPG, JPEG, atau WebP (Maks 5MB)</p>
                        <input type="file" class="file-input" name="file_logo" id="file_logo" accept="image/*" required onchange="handleLogoChange(this)">
                    </div>
                </div>

                <!-- Dropzone Area SK -->
                <div class="col-md-6">
                    <label class="form-label small text-muted">SK Kepengurusan Kemenkumham (ZIP/PDF) <span class="text-danger fw-bold">*</span></label>
                    <div class="dropzone-area" id="dropzone_sk" style="padding: 20px 10px;">
                        <i class="fa-solid fa-file-pdf dropzone-icon" id="dropzone-sk-icon" style="font-size: 2rem; color: var(--text-muted);"></i>
                        <h6 class="text-white mb-1" id="dropzone-sk-text" style="font-size: 0.9rem;">Unggah Berkas SK</h6>
                        <p class="text-muted small mb-0" style="font-size: 0.75rem;">Berkas PDF atau ZIP (Maks 10MB)</p>
                        <input type="file" class="file-input" name="file_sk" id="file_sk" accept=".pdf,.zip" required onchange="handleSkChange(this)">
                    </div>
                </div>
            </div>

            <!-- Action Buttons -->
            <div class="d-flex justify-content-end gap-3">
                <a href="<?= base_url() ?>" class="btn btn-outline-secondary px-4 py-3">Batal</a>
                <button type="submit" class="btn btn-success text-white px-5 py-3">
                    <i class="fa-solid fa-paper-plane me-2"></i> Daftarkan Parpol
                </button>
            </div>
        </form>
    </div>
</div>

<?= $this->endSection() ?>

<?= $this->section('scripts') ?>
<script>
    // Initialize drag and drop for both dropzones
    ['logo', 'sk'].forEach(type => {
        const dz = document.getElementById('dropzone_' + type);
        if (dz) {
            ['dragenter', 'dragover'].forEach(eventName => {
                dz.addEventListener(eventName, (e) => {
                    e.preventDefault();
                    dz.classList.add('dragover');
                }, false);
            });

            ['dragleave', 'drop'].forEach(eventName => {
                dz.addEventListener(eventName, (e) => {
                    e.preventDefault();
                    dz.classList.remove('dragover');
                }, false);
            });
        }
    });

    // File input logo change detector
    function handleLogoChange(input) {
        const dzText = document.getElementById('dropzone-logo-text');
        const dzIcon = document.getElementById('dropzone-logo-icon');
        
        if (input.files && input.files[0]) {
            const file = input.files[0];
            const maxSize = 5 * 1024 * 1024; // 5MB
            
            if (file.size > maxSize) {
                if (window.showToast) {
                    window.showToast('Ukuran lambang partai melebihi batas 5MB! Silakan pilih file gambar yang lebih kecil.', 'danger');
                } else {
                    alert('Ukuran lambang partai melebihi batas 5MB!');
                }
                input.value = ''; // Reset input
                dzText.innerText = 'Unggah Lambang Partai';
                dzText.className = 'text-white mb-1';
                dzIcon.className = 'fa-solid fa-image dropzone-icon';
                dzIcon.style.color = '';
                return;
            }

            dzText.innerText = file.name;
            dzText.className = 'text-success mb-1';
            dzIcon.className = 'fa-solid fa-circle-check dropzone-icon';
            dzIcon.style.color = '#34d399';
        }
    }

    // File input SK change detector
    function handleSkChange(input) {
        const dzText = document.getElementById('dropzone-sk-text');
        const dzIcon = document.getElementById('dropzone-sk-icon');
        
        if (input.files && input.files[0]) {
            const file = input.files[0];
            const maxSize = 10 * 1024 * 1024; // 10MB
            
            if (file.size > maxSize) {
                if (window.showToast) {
                    window.showToast('Ukuran berkas SK melebihi batas 10MB! Silakan pilih file yang lebih kecil.', 'danger');
                } else {
                    alert('Ukuran berkas SK melebihi batas 10MB!');
                }
                input.value = ''; // Reset input
                dzText.innerText = 'Unggah Berkas SK';
                dzText.className = 'text-white mb-1';
                dzIcon.className = 'fa-solid fa-file-pdf dropzone-icon';
                dzIcon.style.color = '';
                return;
            }

            dzText.innerText = file.name;
            dzText.className = 'text-success mb-1';
            dzIcon.className = 'fa-solid fa-circle-check dropzone-icon';
            dzIcon.style.color = '#34d399';
        }
    }

    // Auto-save & Restore Draft using localStorage
    document.addEventListener('DOMContentLoaded', () => {
        const formFields = ['nama_parpol', 'ketua', 'telepon', 'alamat'];
        const form = document.querySelector('form');

        // Restore values if draft exists
        const savedDraft = localStorage.getItem('draft_parpol');
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
                console.error("Gagal memulihkan draf parpol:", e);
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
            localStorage.setItem('draft_parpol', JSON.stringify(draftData));
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
                localStorage.removeItem('draft_parpol');
            });
        }

        // Live Progress Calculation
        function updateFormProgress() {
            let progress = 0;

            // 1. Nama Parpol (20%)
            const namaParpol = document.getElementById('nama_parpol')?.value || '';
            if (namaParpol.trim().length > 2) {
                progress += 20;
            }

            // 2. Ketua (20%)
            const ketua = document.getElementById('ketua')?.value || '';
            if (ketua.trim().length > 2) {
                progress += 20;
            }

            // 3. Telepon (20%)
            const telepon = document.getElementById('telepon')?.value || '';
            if (telepon.trim().length > 5) {
                progress += 20;
            }

            // 4. Alamat (20%)
            const alamat = document.getElementById('alamat')?.value || '';
            if (alamat.trim().length > 5) {
                progress += 20;
            }

            // 5. File Logo (10%)
            const fileLogo = document.getElementById('file_logo');
            if (fileLogo && fileLogo.files && fileLogo.files.length > 0) {
                progress += 10;
            }

            // 6. File SK (10%)
            const fileSk = document.getElementById('file_sk');
            if (fileSk && fileSk.files && fileSk.files.length > 0) {
                progress += 10;
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

        // Bind events
        const allInputs = ['nama_parpol', 'ketua', 'telepon', 'alamat'];
        allInputs.forEach(id => {
            const el = document.getElementById(id);
            if (el) {
                el.addEventListener('input', updateFormProgress);
                el.addEventListener('change', updateFormProgress);
            }
        });
        
        ['file_logo', 'file_sk'].forEach(id => {
            const el = document.getElementById(id);
            if (el) {
                el.addEventListener('change', updateFormProgress);
            }
        });

        // Run initial check
        updateFormProgress();
    });
</script>
<?= $this->endSection() ?>
