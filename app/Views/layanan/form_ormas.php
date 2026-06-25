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
    <!-- Form Container Card -->
    <div class="glass-card">
        <!-- Banner Title -->
        <h2 class="form-header-title">FORM REGISTRASI TANGGAPAN ATAS LAPORAN KEBERADAAN ORMAS/YAYASAN/PERKUMPULAN</h2>

        <!-- Notice Board -->
        <div class="alert alert-info bg-primary-subtle border-primary-subtle text-primary-light p-4 mb-4" role="alert" style="border-radius: 12px; font-size: 0.95rem; line-height: 1.6;">
            <p class="mb-2">Hai, Selamat Datang di Pelayanan Registrasi Laporan Keberadaan Ormas/Yayasan/Perkumpulan Kabupaten Sinjai. Isi formulir dengan benar dan teliti.</p>
            <p class="mb-2">Silahkan unduh format dokumen pelaporan resmi: <a href="https://drive.google.com/uc?export=download&id=1XqCYdQYp87AXN4RGMvJqJKslvA05nRNR" id="download-template-link" class="text-primary fw-bold text-decoration-none"><i class="fa-solid fa-download ms-1"></i> Klik Disini untuk Mengunduh</a></p>
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

        <!-- Registration Form -->
        <form action="<?= base_url('layanan/ormas') ?>" method="POST" enctype="multipart/form-data">
            <?= csrf_field() ?>

            <div class="row g-3 mb-4">
                <div class="col-md-12">
                    <label for="nama_ormas" class="form-label small text-muted">Nama Ormas/Yayasan *</label>
                    <input type="text" class="form-control form-control-custom py-3" id="nama_ormas" name="nama_ormas" placeholder="Masukkan nama resmi organisasi" required>
                </div>

                <div class="col-md-12">
                    <label for="tipe_ormas" class="form-label small text-muted">Tipe Organisasi *</label>
                    <select class="form-select form-control-custom py-3" id="tipe_ormas" name="tipe_ormas" required onchange="toggleOrmasRequirements(this.value)">
                        <option value="Lokal">Ormas Lokal (Penerbitan SKT)</option>
                        <option value="Berjenjang">Ormas Berjenjang (Penerbitan Surat Keberadaan)</option>
                    </select>
                </div>

                <div class="col-md-6">
                    <label for="email" class="form-label small text-muted">Email Resmi *</label>
                    <input type="email" class="form-control form-control-custom py-3" id="email" name="email" placeholder="contoh@domain.com" required>
                </div>

                <div class="col-md-6">
                    <label for="telepon" class="form-label small text-muted">Nomor Telepon Sekretariat *</label>
                    <input type="text" class="form-control form-control-custom py-3" id="telepon" name="telepon" placeholder="Nomor Handphone / Telepon Kantor" required>
                </div>

                <div class="col-md-12">
                    <label for="alamat" class="form-label small text-muted">Alamat Sekretariat *</label>
                    <textarea class="form-control form-control-custom" id="alamat" name="alamat" rows="4" placeholder="Jalan, RT/RW, Kelurahan, Kecamatan, Kabupaten Sinjai" required></textarea>
                </div>

                <!-- Dynamic Requirements List -->
                <div class="col-md-12">
                    <div class="p-4 rounded border" style="background: rgba(255, 255, 255, 0.02); border-color: var(--border-color) !important;">
                        <h6 class="text-white fw-bold mb-3"><i class="fa-solid fa-list-check text-warning me-2"></i>Daftar Berkas Persyaratan (Harap Gabung Menjadi 1 File PDF/ZIP):</h6>
                        
                        <div id="lokal-requirements" class="small text-muted">
                            <ol class="mb-0 ps-3 d-flex flex-column gap-2" style="font-size: 0.88rem;">
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
                            <ol class="mb-0 ps-3 d-flex flex-column gap-2" style="font-size: 0.88rem;">
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

                <!-- Dropzone Area -->
                <div class="col-md-12">
                    <label class="form-label small text-muted">Berkas Dokumen Persyaratan *</label>
                    <div class="dropzone-area" id="dropzone">
                        <i class="fa-solid fa-cloud-arrow-up dropzone-icon" id="dropzone-icon"></i>
                        <h5 class="text-white mb-1" id="dropzone-text">Unggah berkas persyaratan gabungan</h5>
                        <p class="text-muted small mb-0">Seret ke sini atau klik untuk memilih file PDF/ZIP (Maks 10MB)</p>
                        <input type="file" class="file-input" name="file_berkas" id="file_berkas" required onchange="handleFileChange(this)">
                    </div>
                </div>
            </div>

            <!-- Action Buttons -->
            <div class="d-flex justify-content-end gap-3">
                <a href="<?= base_url() ?>" class="btn btn-outline-secondary px-4 py-3">Batal</a>
                <button type="submit" class="btn btn-portal px-5 py-3">
                    <i class="fa-solid fa-paper-plane me-2"></i> Kirim Registrasi
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

    // Toggle requirements list based on Ormas type
    function toggleOrmasRequirements(value) {
        const lokalRequirements = document.getElementById('lokal-requirements');
        const berjenjangRequirements = document.getElementById('berjenjang-requirements');
        const downloadLink = document.getElementById('download-template-link');
        
        if (value === 'Lokal') {
            lokalRequirements.classList.remove('d-none');
            berjenjangRequirements.classList.add('d-none');
            downloadLink.href = "https://drive.google.com/uc?export=download&id=1XqCYdQYp87AXN4RGMvJqJKslvA05nRNR";
        } else {
            lokalRequirements.classList.add('d-none');
            berjenjangRequirements.classList.remove('d-none');
            downloadLink.href = "https://drive.google.com/uc?export=download&id=1UX2CJCfXpWZUix7o-j3jY9cld63dX7KS";
        }
    }

    // Auto-save & Restore Draft using localStorage
    document.addEventListener('DOMContentLoaded', () => {
        const formFields = ['nama_ormas', 'tipe_ormas', 'email', 'telepon', 'alamat'];
        const form = document.querySelector('form');
        
        // Restore values if draft exists
        const savedDraft = localStorage.getItem('draft_ormas');
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
                
                // Adjust requirements visibility based on restored type
                const tipeEl = document.getElementById('tipe_ormas');
                if (tipeEl) {
                    toggleOrmasRequirements(tipeEl.value);
                }

                if (restoredCount > 0 && window.showToast) {
                    window.showToast('Berhasil memulihkan draf pengisian formulir sebelumnya.', 'info');
                }
            } catch (e) {
                console.error("Gagal memulihkan draf ormas:", e);
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
            localStorage.setItem('draft_ormas', JSON.stringify(draftData));
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
                localStorage.removeItem('draft_ormas');
            });
        }

        // Live Progress Calculation
        function updateFormProgress() {
            let progress = 0;

            // 1. Nama Ormas (20%)
            const namaOrmas = document.getElementById('nama_ormas')?.value || '';
            if (namaOrmas.trim().length > 2) {
                progress += 20;
            }

            // 2. Tipe Ormas (10%)
            const tipeOrmas = document.getElementById('tipe_ormas')?.value || '';
            if (tipeOrmas !== '') {
                progress += 10;
            }

            // 3. Email (15%)
            const email = document.getElementById('email')?.value || '';
            const emailRegex = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
            if (emailRegex.test(email.trim())) {
                progress += 15;
            }

            // 4. Telepon (15%)
            const telepon = document.getElementById('telepon')?.value || '';
            if (telepon.trim().length > 5) {
                progress += 15;
            }

            // 5. Alamat (20%)
            const alamat = document.getElementById('alamat')?.value || '';
            if (alamat.trim().length > 5) {
                progress += 20;
            }

            // 6. File Berkas (20%)
            const fileInput = document.getElementById('file_berkas');
            if (fileInput && fileInput.files && fileInput.files.length > 0) {
                progress += 20;
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
        const allInputs = ['nama_ormas', 'tipe_ormas', 'email', 'telepon', 'alamat'];
        allInputs.forEach(id => {
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

        // Run initial check
        updateFormProgress();
    });
</script>
<?= $this->endSection() ?>
