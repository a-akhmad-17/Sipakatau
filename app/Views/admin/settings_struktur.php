<?= $this->extend('layouts/admin') ?>

<?= $this->section('styles') ?>
<!-- Cropper.js CSS CDN -->
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/cropperjs/1.6.1/cropper.min.css" crossorigin="anonymous" />
<style>
    .cropper-preview-container {
        width: 100%;
        max-height: 320px;
        background-color: #1e293b;
        border-radius: 8px;
        overflow: hidden;
        display: flex;
        align-items: center;
        justify-content: center;
        margin-bottom: 15px;
        border: 1px solid var(--border-color);
        position: relative;
    }
    .cropper-preview-container img {
        max-width: 100%;
        max-height: 320px;
        display: block;
    }
    .staf-avatar-wrapper {
        position: relative;
        width: 60px;
        height: 60px;
        border-radius: 50%;
        overflow: hidden;
        background-color: rgba(255, 255, 255, 0.05);
        border: 2px solid var(--border-color);
    }
    .staf-avatar-wrapper img {
        width: 100%;
        height: 100%;
        object-fit: cover;
    }
</style>
<?= $this->endSection() ?>

<?= $this->section('content') ?>
<div class="container-fluid px-0">
    <!-- Header / Breadcrumbs -->
    <div class="d-flex justify-content-between align-items-center mb-4 pb-2 border-bottom" style="border-color: var(--border-color) !important;">
        <div>
            <h3 class="mb-1 font-heading" style="color: var(--text-main);"><i class="fa-solid fa-sitemap text-warning me-2"></i>Struktur Organisasi & Staf</h3>
            <p class="small mb-0" style="color: var(--text-muted);">Kelola informasi pejabat struktural dan staf pendukung Kesbangpol Kabupaten Sinjai.</p>
        </div>
        <div>
            <button type="button" class="btn btn-warning text-dark fw-bold btn-portal" data-bs-toggle="modal" data-bs-target="#modalTambahStaf">
                <i class="fa-solid fa-user-plus me-1.5"></i>Tambah Anggota Staf
            </button>
        </div>
    </div>

    <!-- Category Filters -->
    <div class="row g-4">
        <div class="col-12">
            <div class="glass-card p-4">
                <h4 class="mb-4" style="color: var(--text-main); font-size: 1.25rem;"><i class="fa-solid fa-users text-primary me-2"></i>Daftar Pengurus Staf Aktif</h4>
                
                <div class="table-responsive">
                    <table class="table table-custom align-middle mb-0">
                        <thead>
                            <tr>
                                <th style="width: 70px;">Avatar</th>
                                <th>Nama Lengkap</th>
                                <th>NIP / Keterangan</th>
                                <th>Jabatan / Peran</th>
                                <th>Kategori Bidang</th>
                                <th class="text-center" style="width: 250px;">Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php 
                            $catLabels = [
                                'pimpinan'    => 'Pimpinan / Eselon II & III',
                                'sekretariat' => 'Sekretariat',
                                'ideologi'    => 'Ideologi & Wasbang',
                                'poldagri'    => 'Poldagri & Ormas',
                                'ekososbud'   => 'Ekososbud & Agama'
                            ];
                            $catColors = [
                                'pimpinan'    => 'badge-primary-bg border-danger',
                                'sekretariat' => 'badge-sekretariat',
                                'ideologi'    => 'badge-ideologi',
                                'poldagri'    => 'badge-poldagri',
                                'ekososbud'   => 'badge-ekososbud'
                            ];
                            if (empty($struktur)): 
                            ?>
                                <tr>
                                    <td colspan="6" class="text-center py-5" style="color: var(--text-muted);">
                                        <i class="fa-solid fa-users-slash fa-2x mb-3" style="color: var(--text-muted); opacity: 0.5;"></i>
                                        <p class="mb-0">Tidak ada data staf dalam struktur organisasi.</p>
                                    </td>
                                </tr>
                            <?php else: ?>
                                <?php foreach ($struktur as $staf): 
                                    $photoExists = (!empty($staf['photo']) && strpos($staf['photo'], 'default_') !== 0);
                                ?>
                                    <tr>
                                        <td>
                                            <div class="staf-avatar-wrapper d-flex align-items-center justify-content-center">
                                                <?php if ($photoExists): ?>
                                                    <img src="<?= base_url('uploads/struktur/' . $staf['photo']) ?>" alt="Foto <?= esc($staf['name']) ?>">
                                                <?php else: ?>
                                                    <span class="fw-bold text-white font-heading"><?= esc(substr($staf['name'], 0, 1)) ?></span>
                                                <?php endif; ?>
                                            </div>
                                        </td>
                                        <td>
                                            <div class="fw-bold" style="color: var(--text-main);"><?= esc($staf['name']) ?></div>
                                            <span class="small" style="color: var(--text-muted); font-size: 0.72rem;">ID Slot: <?= esc($staf['id']) ?></span>
                                        </td>
                                        <td>
                                            <span class="small" style="color: var(--text-muted);"><?= esc($staf['nip'] ?? '-') ?></span>
                                        </td>
                                        <td>
                                            <span class="small fw-semibold" style="color: var(--text-main);"><?= esc($staf['role']) ?></span>
                                        </td>
                                        <td>
                                            <span class="badge px-3 py-1.5 <?= $catColors[$staf['category']] ?? 'bg-secondary' ?>"><?= esc($catLabels[$staf['category']] ?? ucfirst($staf['category'])) ?></span>
                                        </td>
                                        <td>
                                            <div class="d-flex justify-content-center gap-1">
                                                <button type="button" class="btn btn-sm btn-outline-info py-1.5 px-3 btn-edit-staf" 
                                                        data-id="<?= esc($staf['id']) ?>" 
                                                        data-name="<?= esc($staf['name']) ?>" 
                                                        data-nip="<?= esc($staf['nip']) ?>" 
                                                        data-role="<?= esc($staf['role']) ?>" 
                                                        data-category="<?= esc($staf['category']) ?>"
                                                        data-photo-url="<?= $photoExists ? base_url('uploads/struktur/' . $staf['photo']) : '' ?>">
                                                    <i class="fa-solid fa-user-gear me-1"></i>Edit
                                                </button>
                                                
                                                <?php if ($photoExists): ?>
                                                    <form action="<?= base_url('admin/settings/staf/delete-photo/' . esc($staf['id'])) ?>" method="POST" onsubmit="return confirm('Apakah Anda yakin ingin menghapus foto staf ini?');" class="d-inline">
                                                        <?= csrf_field() ?>
                                                        <button type="submit" class="btn btn-sm btn-warning text-dark py-1.5 px-2.5" title="Hapus Foto">
                                                            <i class="fa-solid fa-trash"></i>
                                                        </button>
                                                    </form>
                                                <?php endif; ?>

                                                <?php 
                                                $coreRoles = ['kaban', 'sekretaris', 'kasubbag_umum', 'kasubbag_keuangan', 'kabid_ideologi', 'kabid_poldagri', 'kabid_ekososbud'];
                                                if (!in_array($staf['id'], $coreRoles)): 
                                                ?>
                                                    <form action="<?= base_url('admin/settings/staf/delete/' . esc($staf['id'])) ?>" method="POST" onsubmit="return confirm('Apakah Anda yakin ingin menghapus staf ini dari struktur organisasi?');" class="d-inline">
                                                        <?= csrf_field() ?>
                                                        <button type="submit" class="btn btn-sm btn-danger py-1 px-3" title="Hapus Staf">
                                                            <i class="fa-solid fa-trash-can me-1"></i>Hapus
                                                        </button>
                                                    </form>
                                                <?php else: ?>
                                                    <span class="badge rounded-pill px-2 py-1" style="background: rgba(127,127,127,0.12); color: var(--text-muted); border: 1px solid var(--border-color); font-size: 0.7rem;" title="Jabatan struktural inti tidak dapat dihapus">
                                                        <i class="fa-solid fa-shield-halved me-1"></i>Terlindungi
                                                    </span>
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
    </div>
</div>

<!-- Modal Tambah Staf -->
<div class="modal fade" id="modalTambahStaf" tabindex="-1" aria-labelledby="modalTambahStafLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-lg">
        <div class="modal-content glass-card-modal" style="background: var(--bg-color) !important; border: 1px solid var(--border-color) !important; color: var(--text-main) !important; border-radius: 16px;">
            <div class="modal-header border-secondary border-opacity-25" style="border-bottom: 1px solid var(--border-color) !important;">
                <h5 class="modal-title font-heading" id="modalTambahStafLabel" style="color: var(--text-main);"><i class="fa-solid fa-user-plus text-warning me-2"></i>Tambah Anggota Staf Baru</h5>
                <button type="button" class="btn-close" style="filter: var(--btn-close-filter, invert(1) grayscale(100%) brightness(200%));" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form action="<?= base_url('admin/settings/staf/tambah') ?>" method="POST" id="form-tambah-staf">
                <?= csrf_field() ?>
                <!-- Hidden cropped base64 data -->
                <input type="hidden" name="cropped_image" id="tambah-cropped-image">
                
                <div class="modal-body">
                    <div class="row g-3">
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label for="add_name" class="form-label small" style="color: var(--text-muted);">Nama Lengkap *</label>
                                <input type="text" name="name" id="add_name" class="form-control form-control-custom" placeholder="Contoh: Akhmad Sultan, S.Pd." required>
                            </div>
                            <div class="mb-3">
                                <label for="add_role" class="form-label small" style="color: var(--text-muted);">Jabatan / Peran *</label>
                                <input type="text" name="role" id="add_role" class="form-control form-control-custom" placeholder="Contoh: Staf Wasbang" required>
                            </div>
                            <div class="mb-3">
                                <label for="add_nip" class="form-label small" style="color: var(--text-muted);">NIP / Keterangan (Opsional)</label>
                                <input type="text" name="nip" id="add_nip" class="form-control form-control-custom" placeholder="Contoh: NIP. 19901231 202001 1 001 atau -">
                            </div>
                            <div class="mb-3">
                                <label for="add_category" class="form-label small" style="color: var(--text-muted);">Kategori Bidang *</label>
                                <select name="category" id="add_category" class="form-select form-control-custom" required>
                                    <option value="" disabled selected>Pilih Kategori...</option>
                                    <option value="sekretariat">Sekretariat</option>
                                    <option value="ideologi">Bidang Ideologi & Wasbang</option>
                                    <option value="poldagri">Bidang Poldagri & Ormas</option>
                                    <option value="ekososbud">Bidang Ekososbud & Agama</option>
                                </select>
                            </div>
                        </div>
                        
                        <!-- Cropper File Upload Section -->
                        <div class="col-md-6 border-start" style="border-color: var(--border-color) !important;">
                            <div class="mb-3">
                                <label for="add_photo" class="form-label small" style="color: var(--text-muted);">Foto Staf (Auto WebP)</label>
                                <input type="file" id="add_photo" class="form-control form-control-custom" accept="image/*">
                                <div class="form-text small" style="color: var(--text-muted);">Rekomendasi rasio 1:1 (Persegi). Gunakan kontrol di bawah untuk memposisikan foto.</div>
                            </div>
                            
                            <!-- Cropper Workspace -->
                            <div class="cropper-preview-container d-none" id="add-cropper-workspace">
                                <img id="add-cropper-image" src="" alt="Workspace">
                            </div>
                            
                            <!-- Cropper Toolbar Controls -->
                            <div class="d-none justify-content-center gap-2 mb-3" id="add-cropper-controls">
                                <button type="button" class="btn btn-sm btn-secondary text-white" id="btn-add-zoom-in" title="Perbesar"><i class="fa-solid fa-magnifying-glass-plus"></i></button>
                                <button type="button" class="btn btn-sm btn-secondary text-white" id="btn-add-zoom-out" title="Perkecil"><i class="fa-solid fa-magnifying-glass-minus"></i></button>
                                <button type="button" class="btn btn-sm btn-secondary text-white" id="btn-add-rotate-left" title="Putar Kiri"><i class="fa-solid fa-rotate-left"></i></button>
                                <button type="button" class="btn btn-sm btn-secondary text-white" id="btn-add-rotate-right" title="Putar Kanan"><i class="fa-solid fa-rotate-right"></i></button>
                                <button type="button" class="btn btn-sm btn-danger text-white" id="btn-add-reset" title="Reset"><i class="fa-solid fa-arrows-rotate"></i></button>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="modal-footer border-0">
                    <button type="button" class="btn btn-secondary" style="color: var(--text-main);" data-bs-dismiss="modal">Batal</button>
                    <button type="submit" class="btn btn-warning fw-bold" style="color: #1e293b; background: #eab308; border: none; padding: 8px 20px; border-radius: 8px;"><i class="fa-solid fa-user-plus me-1"></i> Simpan Staf</button>
                </div>
            </form>
        </div>
    </div>
</div>

<!-- Modal Edit Staf -->
<div class="modal fade" id="modalEditStaf" tabindex="-1" aria-labelledby="modalEditStafLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-lg">
        <div class="modal-content glass-card-modal" style="background: var(--bg-color) !important; border: 1px solid var(--border-color) !important; color: var(--text-main) !important; border-radius: 16px;">
            <div class="modal-header border-secondary border-opacity-25" style="border-bottom: 1px solid var(--border-color) !important;">
                <h5 class="modal-title font-heading" id="modalEditStafLabel" style="color: var(--text-main);"><i class="fa-solid fa-user-gear text-info me-2"></i>Pembaruan Data Staf</h5>
                <button type="button" class="btn-close" style="filter: var(--btn-close-filter, invert(1) grayscale(100%) brightness(200%));" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form action="<?= base_url('admin/settings/staf/update') ?>" method="POST" id="form-edit-staf">
                <?= csrf_field() ?>
                <!-- Hidden fields -->
                <input type="hidden" name="id" id="edit_staf_id">
                <input type="hidden" name="cropped_image" id="edit-cropped-image">
                
                <div class="modal-body">
                    <div class="row g-3">
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label for="edit_name" class="form-label small" style="color: var(--text-muted);">Nama Lengkap *</label>
                                <input type="text" name="name" id="edit_name" class="form-control form-control-custom" required>
                            </div>
                            <div class="mb-3">
                                <label for="edit_role" class="form-label small" style="color: var(--text-muted);">Jabatan / Peran *</label>
                                <input type="text" name="role" id="edit_role" class="form-control form-control-custom" required>
                            </div>
                            <div class="mb-3">
                                <label for="edit_nip" class="form-label small" style="color: var(--text-muted);">NIP / Keterangan (Opsional)</label>
                                <input type="text" name="nip" id="edit_nip" class="form-control form-control-custom">
                            </div>
                            <div class="mb-3">
                                <label for="edit_category" class="form-label small" style="color: var(--text-muted);">Kategori Bidang *</label>
                                <select name="category" id="edit_category" class="form-select form-control-custom" required>
                                    <option value="pimpinan">Pimpinan / Eselon II & III</option>
                                    <option value="sekretariat">Sekretariat</option>
                                    <option value="ideologi">Bidang Ideologi & Wasbang</option>
                                    <option value="poldagri">Bidang Poldagri & Ormas</option>
                                    <option value="ekososbud">Bidang Ekososbud & Agama</option>
                                </select>
                            </div>
                        </div>
                        
                        <!-- Cropper File Upload Section -->
                        <div class="col-md-6 border-start" style="border-color: var(--border-color) !important;">
                            <div class="mb-3">
                                <label for="edit_photo" class="form-label small" style="color: var(--text-muted);">Unggah Foto Baru (Ganti Foto)</label>
                                <input type="file" id="edit_photo" class="form-control form-control-custom" accept="image/*">
                                <div class="form-text small" style="color: var(--text-muted);">Rekomendasi rasio 1:1. Biarkan kosong jika tidak ingin mengubah foto staf.</div>
                            </div>
                            
                            <!-- Cropper Workspace -->
                            <div class="cropper-preview-container d-none" id="edit-cropper-workspace">
                                <img id="edit-cropper-image" src="" alt="Workspace">
                            </div>
                            
                            <!-- Cropper Toolbar Controls -->
                            <div class="d-none justify-content-center gap-2 mb-3" id="edit-cropper-controls">
                                <button type="button" class="btn btn-sm btn-secondary text-white" id="btn-edit-zoom-in" title="Perbesar"><i class="fa-solid fa-magnifying-glass-plus"></i></button>
                                <button type="button" class="btn btn-sm btn-secondary text-white" id="btn-edit-zoom-out" title="Perkecil"><i class="fa-solid fa-magnifying-glass-minus"></i></button>
                                <button type="button" class="btn btn-sm btn-secondary text-white" id="btn-edit-rotate-left" title="Putar Kiri"><i class="fa-solid fa-rotate-left"></i></button>
                                <button type="button" class="btn btn-sm btn-secondary text-white" id="btn-edit-rotate-right" title="Putar Kanan"><i class="fa-solid fa-rotate-right"></i></button>
                                <button type="button" class="btn btn-sm btn-danger text-white" id="btn-edit-reset" title="Reset"><i class="fa-solid fa-arrows-rotate"></i></button>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="modal-footer border-0">
                    <button type="button" class="btn btn-secondary" style="color: var(--text-main);" data-bs-dismiss="modal">Batal</button>
                    <button type="submit" class="btn btn-info text-white fw-bold"><i class="fa-solid fa-floppy-disk me-1"></i> Simpan Perubahan</button>
                </div>
            </form>
        </div>
    </div>
</div>
<?= $this->endSection() ?>

<?= $this->section('scripts') ?>
<!-- Cropper.js JavaScript CDN -->
<script src="https://cdnjs.cloudflare.com/ajax/libs/cropperjs/1.6.1/cropper.min.js" crossorigin="anonymous"></script>
<script>
    document.addEventListener('DOMContentLoaded', () => {
        let addCropperInstance = null;
        let editCropperInstance = null;

        // --------------------------------------------------------------------------
        // Setup Cropper for Add Staf
        // --------------------------------------------------------------------------
        const addPhotoInput = document.getElementById('add_photo');
        const addWorkspace = document.getElementById('add-cropper-workspace');
        const addWorkspaceImg = document.getElementById('add-cropper-image');
        const addControls = document.getElementById('add-cropper-controls');
        const addCroppedInput = document.getElementById('tambah-cropped-image');

        addPhotoInput.addEventListener('change', function(e) {
            const files = e.target.files;
            if (files && files.length > 0) {
                const file = files[0];
                const reader = new FileReader();
                reader.onload = function(evt) {
                    addWorkspace.classList.remove('d-none');
                    addControls.classList.remove('d-none');
                    addWorkspaceImg.src = evt.target.result;
                    
                    if (addCropperInstance) {
                        addCropperInstance.destroy();
                    }
                    
                    addCropperInstance = new Cropper(addWorkspaceImg, {
                        aspectRatio: 1,
                        viewMode: 1,
                        dragMode: 'move',
                        autoCropArea: 1,
                        cropBoxMovable: false,
                        cropBoxResizable: false,
                        toggleDragModeOnDblclick: false
                    });
                };
                reader.readAsDataURL(file);
            }
        });

        // Add controls event listeners
        document.getElementById('btn-add-zoom-in').addEventListener('click', () => addCropperInstance && addCropperInstance.zoom(0.1));
        document.getElementById('btn-add-zoom-out').addEventListener('click', () => addCropperInstance && addCropperInstance.zoom(-0.1));
        document.getElementById('btn-add-rotate-left').addEventListener('click', () => addCropperInstance && addCropperInstance.rotate(-90));
        document.getElementById('btn-add-rotate-right').addEventListener('click', () => addCropperInstance && addCropperInstance.rotate(90));
        document.getElementById('btn-add-reset').addEventListener('click', () => addCropperInstance && addCropperInstance.reset());

        // On Add Form Submit: Extract cropped image base64
        document.getElementById('form-tambah-staf').addEventListener('submit', function(e) {
            if (addCropperInstance) {
                const canvas = addCropperInstance.getCroppedCanvas({
                    width: 350,
                    height: 350
                });
                addCroppedInput.value = canvas.toDataURL('image/png');
            }
        });

        // --------------------------------------------------------------------------
        // Setup Cropper for Edit Staf
        // --------------------------------------------------------------------------
        const editModal = new bootstrap.Modal(document.getElementById('modalEditStaf'));
        const editPhotoInput = document.getElementById('edit_photo');
        const editWorkspace = document.getElementById('edit-cropper-workspace');
        const editWorkspaceImg = document.getElementById('edit-cropper-image');
        const editControls = document.getElementById('edit-cropper-controls');
        const editCroppedInput = document.getElementById('edit-cropped-image');

        // Fields to populate
        const editIdInput = document.getElementById('edit_staf_id');
        const editNameInput = document.getElementById('edit_name');
        const editNipInput = document.getElementById('edit_nip');
        const editRoleInput = document.getElementById('edit_role');
        const editCategoryInput = document.getElementById('edit_category');

        document.querySelectorAll('.btn-edit-staf').forEach(btn => {
            btn.addEventListener('click', () => {
                const id = btn.getAttribute('data-id');
                const name = btn.getAttribute('data-name');
                const nip = btn.getAttribute('data-nip');
                const role = btn.getAttribute('data-role');
                const category = btn.getAttribute('data-category');
                
                editIdInput.value = id;
                editNameInput.value = name;
                editNipInput.value = nip;
                editRoleInput.value = role;
                editCategoryInput.value = category;

                // Clear previous cropper
                editPhotoInput.value = '';
                editWorkspace.classList.add('d-none');
                editControls.classList.add('d-none');
                editCroppedInput.value = '';
                if (editCropperInstance) {
                    editCropperInstance.destroy();
                    editCropperInstance = null;
                }

                editModal.show();
            });
        });

        editPhotoInput.addEventListener('change', function(e) {
            const files = e.target.files;
            if (files && files.length > 0) {
                const file = files[0];
                const reader = new FileReader();
                reader.onload = function(evt) {
                    editWorkspace.classList.remove('d-none');
                    editControls.classList.remove('d-none');
                    editWorkspaceImg.src = evt.target.result;
                    
                    if (editCropperInstance) {
                        editCropperInstance.destroy();
                    }
                    
                    editCropperInstance = new Cropper(editWorkspaceImg, {
                        aspectRatio: 1,
                        viewMode: 1,
                        dragMode: 'move',
                        autoCropArea: 1,
                        cropBoxMovable: false,
                        cropBoxResizable: false,
                        toggleDragModeOnDblclick: false
                    });
                };
                reader.readAsDataURL(file);
            }
        });

        // Edit controls event listeners
        document.getElementById('btn-edit-zoom-in').addEventListener('click', () => editCropperInstance && editCropperInstance.zoom(0.1));
        document.getElementById('btn-edit-zoom-out').addEventListener('click', () => editCropperInstance && editCropperInstance.zoom(-0.1));
        document.getElementById('btn-edit-rotate-left').addEventListener('click', () => editCropperInstance && editCropperInstance.rotate(-90));
        document.getElementById('btn-edit-rotate-right').addEventListener('click', () => editCropperInstance && editCropperInstance.rotate(90));
        document.getElementById('btn-edit-reset').addEventListener('click', () => editCropperInstance && editCropperInstance.reset());

        // On Edit Form Submit: Extract cropped image base64
        document.getElementById('form-edit-staf').addEventListener('submit', function(e) {
            if (editCropperInstance) {
                const canvas = editCropperInstance.getCroppedCanvas({
                    width: 350,
                    height: 350
                });
                editCroppedInput.value = canvas.toDataURL('image/png');
            }
        });

        // Reset croppers on modal close
        document.getElementById('modalTambahStaf').addEventListener('hidden.bs.modal', function () {
            addPhotoInput.value = '';
            addWorkspace.classList.add('d-none');
            addControls.classList.add('d-none');
            addCroppedInput.value = '';
            if (addCropperInstance) {
                addCropperInstance.destroy();
                addCropperInstance = null;
            }
        });
        
        document.getElementById('modalEditStaf').addEventListener('hidden.bs.modal', function () {
            editPhotoInput.value = '';
            editWorkspace.classList.add('d-none');
            editControls.classList.add('d-none');
            editCroppedInput.value = '';
            if (editCropperInstance) {
                editCropperInstance.destroy();
                editCropperInstance = null;
            }
        });
    });
</script>
<?= $this->endSection() ?>
