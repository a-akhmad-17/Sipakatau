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

<div class="py-4" style="max-width: 950px; margin: 0 auto;">
    <div class="glass-card">
        <h2 class="form-header-title">FORM REKOMENDASI KEGIATAN</h2>

        <!-- Notice Board (Shortcut & WA Support) -->
        <div class="alert alert-info bg-primary-subtle border-primary-subtle text-primary-light p-4 mb-4" role="alert" style="border-radius: 12px; font-size: 0.95rem; line-height: 1.6;">
            <p class="mb-2">Hai, Selamat Datang di Pelayanan Rekomendasi Kegiatan Kabupaten Sinjai. Isi formulir dengan benar dan teliti.</p>
            <p class="mb-2">Silahkan unduh format dokumen rekomendasi resmi: <a href="https://drive.google.com/uc?export=download&id=1WsgeJzVebDi-eGE9B7uYifcAiW05hxgW" class="text-primary fw-bold text-decoration-none"><i class="fa-solid fa-download ms-1"></i> Klik Disini untuk Mengunduh</a></p>
            <hr class="my-3 border-primary-subtle">
            <p class="mb-0 fw-semibold text-white">
                <i class="fa-solid fa-phone-volume me-2"></i>Silahkan konfirmasi melalui whatsapp apabila mengalami kendala: 
                <a href="https://wa.me/<?= get_piket_phone_clean() ?>?text=Halo%20Kesbangpol%20Sinjai,%20saya%20mengalami%20kendala%20saat%20mengisi%20formulir%20rekomendasi%20kegiatan." target="_blank" class="text-success text-decoration-none fw-bold wa-link">
                    Kesbangpol Sinjai (<?= esc(get_piket_phone()) ?>) <i class="fa-brands fa-whatsapp ms-1"></i>
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

                <div class="col-md-12">
                    <label for="pake_fasilitas" class="form-label small text-muted">Apakah kegiatan menggunakan fasilitas publik / gedung milik pemerintah? <span class="text-danger">*</span></label>
                    <select class="form-select form-control-custom py-3" id="pake_fasilitas" name="pake_fasilitas" required>
                        <option value="Tidak">Tidak</option>
                        <option value="Ya">Ya (Wajib mengunggah Surat Rekomendasi dari Instansi/Stakeholder pengelola fasilitas di berkas nomor 6)</option>
                    </select>
                    <div class="form-text text-muted small mt-1.5" id="fasilitas-note" style="display: none;">
                        <span class="text-warning fw-bold"><i class="fa-solid fa-triangle-exclamation"></i> PENTING:</span> Karena Anda memilih <b>Ya</b>, maka <b>Dokumen Rekomendasi Stakeholder (Berkas nomor 6)</b> di bawah ini otomatis menjadi <b>WAJIB diunggah</b>.
                    </div>
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
                                        <div class="fw-semibold text-white small"><?= esc($req['name']) ?> <span id="req-badge-<?= $req['id'] ?>"><?php if ($req['required']): ?><span class="text-danger">*</span><?php else: ?><span class="text-muted small">(Opsional)</span><?php endif; ?></span></div>
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

        const pakeFasEl = document.getElementById('pake_fasilitas');
        if (pakeFasEl) {
            pakeFasEl.addEventListener('change', function() {
                toggleFasilitasRekomendasi(this.value);
            });
            toggleFasilitasRekomendasi(pakeFasEl.value);
        }

        // Run initial check
        updateFormProgress();
    });

    window.toggleFasilitasRekomendasi = function(value) {
        const noteEl = document.getElementById('fasilitas-note');
        const file6Input = document.getElementById('file_proposal_6');
        const reqBadge = document.getElementById('req-badge-6');
        
        if (value === 'Ya') {
            if (noteEl) noteEl.style.display = 'block';
            if (file6Input) file6Input.setAttribute('data-required', 'true');
            if (reqBadge) {
                reqBadge.innerHTML = '<span class="text-danger fw-bold">*</span>';
            }
        } else {
            if (noteEl) noteEl.style.display = 'none';
            if (file6Input) file6Input.setAttribute('data-required', 'false');
            if (reqBadge) {
                reqBadge.innerHTML = '<span class="text-muted small">(Opsional)</span>';
            }
        }
        updateFormProgress();
    };

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

        // 6. Required Files (10% each for first 5 files, and 6th if using facility)
        const limitFiles = (document.getElementById('pake_fasilitas')?.value === 'Ya') ? 6 : 5;
        for (let i = 1; i <= limitFiles; i++) {
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
<?= $this->endSection() ?>
