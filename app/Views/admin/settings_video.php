<?= $this->extend('layouts/admin') ?>

<?= $this->section('content') ?>
<div class="container-fluid px-0">
    <!-- Header / Breadcrumbs -->
    <div class="d-flex justify-content-between align-items-center mb-4 pb-2 border-bottom" style="border-color: var(--border-color) !important;">
        <div>
            <h3 class="mb-1 font-heading" style="color: var(--text-main);"><i class="fa-solid fa-video text-danger me-2"></i>Video & Dokumentasi Kegiatan</h3>
            <p class="small mb-0" style="color: var(--text-muted);">Kelola koleksi video edukasi kebangsaan dan galeri video dokumentasi kegiatan Kesbangpol.</p>
        </div>
        <div>
            <button type="button" class="btn btn-danger text-white fw-bold btn-portal" data-bs-toggle="modal" data-bs-target="#modalTambahVideo">
                <i class="fa-solid fa-plus me-1.5"></i>Tambah Konten Video/Dokumentasi 
            </button>
        </div>
    </div>

    <!-- Category Filter Tabs -->
    <div class="card mb-4 border-0" style="background: var(--card-bg); backdrop-filter: blur(20px); border: 1px solid var(--border-color) !important; border-radius: 16px;">
        <div class="card-body p-3">
            <div class="d-flex flex-wrap justify-content-between align-items-center gap-3">
                <div class="nav nav-pills" id="video-filter-tab" role="tablist" style="gap: 5px;">
                    <button class="nav-link active" id="filter-all" data-filter="all" style="border-radius: 8px; font-weight: 500; font-size: 0.9rem; padding: 8px 16px;">
                        Semua Konten (<span id="count-all">0</span>)
                    </button>
                    <button class="nav-link" id="filter-edukasi" data-filter="edukasi" style="border-radius: 8px; font-weight: 500; font-size: 0.9rem; padding: 8px 16px;">
                        <i class="fa-solid fa-graduation-cap me-1 text-warning"></i>Video Edukasi (<span id="count-edukasi">0</span>)
                    </button>
                    <button class="nav-link" id="filter-dokumentasi" data-filter="dokumentasi" style="border-radius: 8px; font-weight: 500; font-size: 0.9rem; padding: 8px 16px;">
                        <i class="fa-solid fa-photo-film me-1 text-info"></i>Dokumentasi Kegiatan (<span id="count-dokumentasi">0</span>)
                    </button>
                </div>
                <div class="input-group input-group-sm" style="width: 280px; max-width: 100%;">
                    <span class="input-group-text bg-secondary border-secondary text-white-50"><i class="fa-solid fa-magnifying-glass"></i></span>
                    <input type="text" id="video-search-input" class="form-control form-control-custom" placeholder="Cari judul/deskripsi...">
                </div>
            </div>
        </div>
    </div>

    <!-- Videos Grid -->
    <div class="row g-4" id="videos-grid-container">
        <?php if (empty($videos)): ?>
            <div class="col-12 text-center py-5" style="color: var(--text-muted);">
                <i class="fa-solid fa-film fa-3x mb-3" style="color: var(--text-muted); opacity: 0.3;"></i>
                <h5 style="color: var(--text-main);">Belum Ada Konten Video/Dokumentasi</h5>
                <p class="small">Klik tombol "+ Tambah Konten Video/Dokumentasi" di kanan atas untuk mempublikasikan dokumentasi pertama Anda.</p>
            </div>
        <?php else: ?>
            <?php foreach ($videos as $vid): 
                $type = $vid['type'] ?? 'edukasi'; // default to edukasi for legacy compatibility
                $typeLabel = ($type === 'dokumentasi') ? 'Dokumentasi Kegiatan' : 'Video Edukasi';
                $typeBadgeClass = ($type === 'dokumentasi') ? 'bg-info-subtle text-info border border-info-subtle' : 'bg-warning-subtle text-warning border border-warning-subtle';
                $hasImage = ($type === 'dokumentasi' && !empty($vid['image_path']));
            ?>
                <div class="col-md-6 col-lg-4 video-card-item" data-type="<?= esc($type) ?>" data-title="<?= esc(strtolower($vid['title'])) ?>" data-desc="<?= esc(strtolower($vid['description'] ?? '')) ?>">
                    <div class="glass-card p-0 overflow-hidden h-100 d-flex flex-column justify-content-between">
                        <!-- Video or Image Frame -->
                        <div class="ratio ratio-16x9 border-bottom" style="border-color: var(--border-color) !important;">
                            <?php if ($hasImage): ?>
                                <img src="<?= base_url('uploads/dokumentasi/' . $vid['image_path']) ?>" alt="<?= esc($vid['title']) ?>" style="object-fit: cover; width: 100%; height: 100%;">
                            <?php else: ?>
                                <iframe src="https://www.youtube.com/embed/<?= esc($vid['youtube_id']) ?>" title="<?= esc($vid['title']) ?>" allowfullscreen style="border: 0;"></iframe>
                            <?php endif; ?>
                        </div>

                        <!-- Card Content -->
                        <div class="p-4 d-flex flex-column flex-grow-1 justify-content-between">
                            <div>
                                <div class="d-flex justify-content-between align-items-center mb-2">
                                    <div class="d-flex align-items-center gap-1 flex-wrap">
                                        <span class="badge rounded-pill px-2.5 py-1.5 <?= $typeBadgeClass ?> small"><?= $typeLabel ?></span>
                                        <?php 
                                        $galleryCount = !empty($vid['image_gallery']) && is_array($vid['image_gallery']) ? count($vid['image_gallery']) : 0;
                                        if ($galleryCount > 0): 
                                        ?>
                                            <span class="badge rounded-pill bg-dark text-info border border-secondary small"><i class="fa-solid fa-images me-1"></i>+<?= $galleryCount ?> Foto</span>
                                        <?php endif; ?>
                                    </div>
                                    <span class="small text-muted" style="font-size: 0.72rem;"><i class="fa-regular fa-clock me-1"></i><?= esc($vid['duration'] ?? '-') ?></span>
                                </div>
                                <h4 class="mb-2" style="color: var(--text-main); font-size: 1.1rem; line-height: 1.4;" title="<?= esc($vid['title']) ?>"><?= esc($vid['title']) ?></h4>
                                <p class="small mb-3" style="color: var(--text-muted); font-size: 0.8rem; line-height: 1.5; text-align: justify;"><?= esc(mb_strimwidth($vid['description'] ?? '', 0, 120, '...')) ?></p>
                            </div>

                            <div class="pt-3 border-top d-flex justify-content-between align-items-center" style="border-color: var(--border-color) !important; font-size: 0.75rem;">
                                <div style="color: var(--text-muted);">
                                    <i class="fa-solid fa-user-check me-1 text-primary"></i><?= esc($vid['source'] ?? 'Kesbangpol Sinjai') ?>
                                </div>
                                <div class="d-flex gap-1">
                                    <button type="button" class="btn btn-sm btn-outline-info py-1 px-2 btn-edit-video" 
                                            data-id="<?= esc($vid['id']) ?>"
                                            data-title="<?= esc($vid['title']) ?>"
                                            data-type="<?= esc($type) ?>"
                                            data-youtube-id="<?= esc($vid['youtube_id']) ?>"
                                            data-image-path="<?= esc($vid['image_path'] ?? '') ?>"
                                            data-image-gallery='<?= !empty($vid['image_gallery']) ? json_encode($vid['image_gallery']) : '[]' ?>'
                                            data-category="<?= esc($vid['category'] ?? 'Umum') ?>"
                                            data-duration="<?= esc($vid['duration'] ?? '') ?>"
                                            data-source="<?= esc($vid['source'] ?? '') ?>"
                                            data-desc="<?= esc($vid['description'] ?? '') ?>">
                                        <i class="fa-solid fa-pen-to-square"></i> Sunting
                                    </button>
                                    <form action="<?= base_url('admin/settings/video/delete/' . esc($vid['id'])) ?>" method="POST" onsubmit="return confirm('Apakah Anda yakin ingin menghapus video/dokumentasi ini?');" class="d-inline">
                                        <?= csrf_field() ?>
                                        <button type="submit" class="btn btn-sm btn-outline-danger py-1 px-2">
                                            <i class="fa-solid fa-trash-can"></i>
                                        </button>
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            <?php endforeach; ?>
        <?php endif; ?>
    </div>
</div>

<!-- Modal Tambah Video -->
<div class="modal fade" id="modalTambahVideo" tabindex="-1" aria-labelledby="modalTambahVideoLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-lg">
        <div class="modal-content glass-card-modal" style="background: var(--bg-color) !important; border: 1px solid var(--border-color) !important; color: var(--text-main) !important; border-radius: 16px;">
            <div class="modal-header border-secondary border-opacity-25" style="border-bottom: 1px solid var(--border-color) !important;">
                <h5 class="modal-title font-heading" id="modalTambahVideoLabel" style="color: var(--text-main);"><i class="fa-solid fa-plus text-warning me-2"></i>Tambah Konten Video/Dokumentasi</h5>
                <button type="button" class="btn-close" style="filter: var(--btn-close-filter, invert(1) grayscale(100%) brightness(200%));" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form action="<?= base_url('admin/settings/video/tambah') ?>" method="POST" enctype="multipart/form-data">
                <?= csrf_field() ?>
                <div class="modal-body">
                    <div class="row g-3">
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label for="add_vid_title" class="form-label small" style="color: var(--text-muted);">Judul Video / Dokumentasi *</label>
                                <input type="text" name="title" id="add_vid_title" class="form-control form-control-custom" placeholder="Contoh: Liputan Kunjungan Kerja Kaban" required>
                            </div>
                            <div class="mb-3">
                                <label for="add_vid_type" class="form-label small" style="color: var(--text-muted);">Tipe Konten *</label>
                                <select name="type" id="add_vid_type" class="form-select form-control-custom" required>
                                    <option value="edukasi" selected>Video Edukasi</option>
                                    <option value="dokumentasi">Dokumentasi Kegiatan</option>
                                </select>
                            </div>
                            <div class="mb-3" id="add_youtube_id_group">
                                <label for="add_vid_youtube" class="form-label small" style="color: var(--text-muted);">URL YouTube / Video ID <span id="add_youtube_req" class="text-danger">*</span></label>
                                <input type="text" name="youtube_id" id="add_vid_youtube" class="form-control form-control-custom" placeholder="Contoh: https://www.youtube.com/watch?v=dQw4w9WgXcQ atau dQw4w9WgXcQ">
                            </div>
                            <div class="mb-3 d-none" id="add_image_group">
                                <label for="add_vid_image" class="form-label small" style="color: var(--text-muted);">Gambar Sampul Dokumentasi <span id="add_image_req" class="text-danger">*</span></label>
                                <input type="file" name="image" id="add_vid_image" class="form-control form-control-custom mb-2" accept="image/*">
                                
                                <label for="add_vid_gallery" class="form-label small d-block" style="color: var(--text-muted);">Foto Dokumentasi Tambahan (Bisa memilih beberapa foto)</label>
                                <input type="file" name="image_gallery[]" id="add_vid_gallery" class="form-control form-control-custom" accept="image/*" multiple>
                                <span class="small d-block mt-1" style="color: var(--text-muted); font-size: 0.72rem;">Format: JPG, PNG, WEBP. Maks 2MB per file.</span>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label for="add_vid_category" class="form-label small" style="color: var(--text-muted);">Kategori Konten</label>
                                <select name="category" id="add_vid_category" class="form-select form-control-custom">
                                    <option value="Umum" selected>Umum</option>
                                    <option value="Wawasan Kebangsaan">Wawasan Kebangsaan</option>
                                    <option value="Ketahanan Nasional">Ketahanan Nasional</option>
                                    <option value="Politik Dalam Negeri">Politik Dalam Negeri</option>
                                    <option value="Sosial Budaya">Sosial Budaya</option>
                                </select>
                            </div>
                            <div class="row g-2 mb-3">
                                <div class="col-sm-6" id="add_duration_group">
                                    <label for="add_vid_dur" class="form-label small" style="color: var(--text-muted);">Durasi Konten</label>
                                    <input type="text" name="duration" id="add_vid_dur" class="form-control form-control-custom" placeholder="Contoh: 10:25 atau -">
                                </div>
                                <div class="col-sm-6" id="add_source_group">
                                    <label for="add_vid_src" class="form-label small" style="color: var(--text-muted);">Kreator / Sumber</label>
                                    <input type="text" name="source" id="add_vid_src" class="form-control form-control-custom" value="Kesbangpol Sinjai">
                                </div>
                            </div>
                            <div class="mb-3">
                                <label for="add_vid_desc" class="form-label small" style="color: var(--text-muted);">Deskripsi Singkat</label>
                                <textarea name="description" id="add_vid_desc" class="form-control form-control-custom" rows="2" placeholder="Deskripsi mengenai isi konten..."></textarea>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="modal-footer border-0">
                    <button type="button" class="btn btn-secondary" style="color: var(--text-main);" data-bs-dismiss="modal">Batal</button>
                    <button type="submit" class="btn btn-warning fw-bold" style="color: #1e293b; background: #eab308; border: none; padding: 8px 20px; border-radius: 8px;"><i class="fa-solid fa-floppy-disk me-1"></i> Simpan Konten</button>
                </div>
            </form>
        </div>
    </div>
</div>

<!-- Modal Edit Video -->
<div class="modal fade" id="modalEditVideo" tabindex="-1" aria-labelledby="modalEditVideoLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-lg">
        <div class="modal-content glass-card-modal" style="background: var(--bg-color) !important; border: 1px solid var(--border-color) !important; color: var(--text-main) !important; border-radius: 16px;">
            <div class="modal-header border-secondary border-opacity-25" style="border-bottom: 1px solid var(--border-color) !important;">
                <h5 class="modal-title font-heading" id="modalEditVideoLabel" style="color: var(--text-main);"><i class="fa-solid fa-pen-to-square text-info me-2"></i>Sunting Konten</h5>
                <button type="button" class="btn-close" style="filter: var(--btn-close-filter, invert(1) grayscale(100%) brightness(200%));" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form action="<?= base_url('admin/settings/video/update') ?>" method="POST" enctype="multipart/form-data">
                <?= csrf_field() ?>
                <input type="hidden" name="id" id="edit_vid_id">
                <div class="modal-body">
                    <div class="row g-3">
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label for="edit_vid_title" class="form-label small" style="color: var(--text-muted);">Judul Konten *</label>
                                <input type="text" name="title" id="edit_vid_title" class="form-control form-control-custom" required>
                            </div>
                            <div class="mb-3">
                                <label for="edit_vid_type" class="form-label small" style="color: var(--text-muted);">Tipe Konten *</label>
                                <select name="type" id="edit_vid_type" class="form-select form-control-custom" required>
                                    <option value="edukasi">Video Edukasi</option>
                                    <option value="dokumentasi">Dokumentasi Kegiatan</option>
                                </select>
                            </div>
                            <div class="mb-3" id="edit_youtube_id_group">
                                <label for="edit_vid_youtube" class="form-label small" style="color: var(--text-muted);">URL YouTube / Video ID <span id="edit_youtube_req" class="text-danger">*</span></label>
                                <input type="text" name="youtube_id" id="edit_vid_youtube" class="form-control form-control-custom">
                            </div>
                            <div class="mb-3 d-none" id="edit_image_group">
                                <label for="edit_vid_image" class="form-label small" style="color: var(--text-muted);">Gambar Sampul Dokumentasi <span id="edit_image_req" class="text-danger">*</span></label>
                                <input type="file" name="image" id="edit_vid_image" class="form-control form-control-custom mb-2" accept="image/*">
                                <div class="mt-2 text-start mb-3" id="edit_image_preview_container" style="display:none;">
                                    <span class="small d-block mb-1" style="color: var(--text-muted);">Gambar Sampul Saat Ini:</span>
                                    <img src="" id="edit_image_preview" class="rounded border shadow-sm" style="max-height: 80px; width: auto; max-width: 100%;">
                                </div>
                                
                                <label for="edit_vid_gallery" class="form-label small d-block" style="color: var(--text-muted);">Tambahkan Foto Dokumentasi Lainnya</label>
                                <input type="file" name="image_gallery[]" id="edit_vid_gallery" class="form-control form-control-custom mb-2" accept="image/*" multiple>
                                
                                <div class="mt-2 text-start mb-2" id="edit_gallery_preview_container" style="display:none;">
                                    <span class="small d-block mb-1.5" style="color: var(--text-muted);">Foto Galeri Saat Ini (Klik ikon silang untuk menandai hapus):</span>
                                    <div class="d-flex flex-wrap gap-2" id="edit_gallery_preview_list">
                                        <!-- Previews populated by JS -->
                                    </div>
                                </div>
                                <span class="small d-block mt-1.5" style="color: var(--text-muted); font-size: 0.72rem;">Format: JPG, PNG, WEBP. Maks 2MB per file.</span>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label for="edit_vid_category" class="form-label small" style="color: var(--text-muted);">Kategori Konten</label>
                                <select name="category" id="edit_vid_category" class="form-select form-control-custom">
                                    <option value="Umum">Umum</option>
                                    <option value="Wawasan Kebangsaan">Wawasan Kebangsaan</option>
                                    <option value="Ketahanan Nasional">Ketahanan Nasional</option>
                                    <option value="Politik Dalam Negeri">Politik Dalam Negeri</option>
                                    <option value="Sosial Budaya">Sosial Budaya</option>
                                </select>
                            </div>
                            <div class="row g-2 mb-3">
                                <div class="col-sm-6" id="edit_duration_group">
                                    <label for="edit_vid_dur" class="form-label small" style="color: var(--text-muted);">Durasi Konten</label>
                                    <input type="text" name="duration" id="edit_vid_dur" class="form-control form-control-custom">
                                </div>
                                <div class="col-sm-6" id="edit_source_group">
                                    <label for="edit_vid_src" class="form-label small" style="color: var(--text-muted);">Kreator / Sumber</label>
                                    <input type="text" name="source" id="edit_vid_src" class="form-control form-control-custom">
                                </div>
                            </div>
                            <div class="mb-3">
                                <label for="edit_vid_desc" class="form-label small" style="color: var(--text-muted);">Deskripsi Singkat</label>
                                <textarea name="description" id="edit_vid_desc" class="form-control form-control-custom" rows="2"></textarea>
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
<script>
    document.addEventListener('DOMContentLoaded', () => {
        const editModal = new bootstrap.Modal(document.getElementById('modalEditVideo'));
        
        // Modal Edit Inputs
        const editId = document.getElementById('edit_vid_id');
        const editTitle = document.getElementById('edit_vid_title');
        const editType = document.getElementById('edit_vid_type');
        const editYoutubeId = document.getElementById('edit_vid_youtube');
        const editCategory = document.getElementById('edit_vid_category');
        const editDuration = document.getElementById('edit_vid_dur');
        const editSource = document.getElementById('edit_vid_src');
        const editDesc = document.getElementById('edit_vid_desc');

        // Global toggle delete gallery photo helper
        window.toggleDeleteGalleryPhoto = function (element, filename) {
            const parent = element.parentElement;
            const isMarked = parent.classList.contains('opacity-25');
            
            if (!isMarked) {
                parent.classList.add('opacity-25', 'border-danger');
                // Add hidden input to form
                const input = document.createElement('input');
                input.type = 'hidden';
                input.name = 'deleted_gallery[]';
                input.value = filename;
                input.id = 'del_gal_' + filename.replace(/[^a-zA-Z0-9]/g, '_');
                parent.appendChild(input);
                
                // Change icon to undo (rotate-left)
                element.innerHTML = '<i class="fa-solid fa-rotate-left"></i>';
                element.classList.remove('bg-danger');
                element.classList.add('bg-secondary');
            } else {
                parent.classList.remove('opacity-25', 'border-danger');
                // Remove hidden input
                const input = document.getElementById('del_gal_' + filename.replace(/[^a-zA-Z0-9]/g, '_'));
                if (input) input.remove();
                
                // Change icon back to cross
                element.innerHTML = '<i class="fa-solid fa-xmark"></i>';
                element.classList.remove('bg-secondary');
                element.classList.add('bg-danger');
            }
        };

        // Helper to toggle inputs based on content type
        const handleTypeChange = (typeSelect, youtubeGroup, youtubeInput, youtubeReq, imageGroup, imageInput, imageReq, isEditMode = false, imagePath = '') => {
            const val = typeSelect.value;
            const durationGroup = isEditMode ? document.getElementById('edit_duration_group') : document.getElementById('add_duration_group');
            const sourceCol = isEditMode ? document.getElementById('edit_source_group') : document.getElementById('add_source_group');

            if (val === 'edukasi') {
                youtubeGroup.classList.remove('d-none');
                youtubeInput.setAttribute('required', 'required');
                youtubeReq.classList.remove('d-none');
                
                imageGroup.classList.add('d-none');
                imageInput.removeAttribute('required');
                imageReq.classList.add('d-none');
                if (isEditMode) document.getElementById('edit_gallery_preview_container').style.display = 'none';

                if (durationGroup) durationGroup.classList.remove('d-none');
                if (sourceCol) {
                    sourceCol.classList.remove('col-sm-12');
                    sourceCol.classList.add('col-sm-6');
                }
            } else { // type === 'dokumentasi'
                youtubeGroup.classList.add('d-none');
                youtubeInput.removeAttribute('required');
                youtubeReq.classList.add('d-none');
                
                imageGroup.classList.remove('d-none');
                
                // If it is edit mode and already has an image, don't require uploading again
                if (isEditMode && imagePath) {
                    imageInput.removeAttribute('required');
                    imageReq.classList.add('d-none');
                    
                    const previewContainer = document.getElementById('edit_image_preview_container');
                    const previewImg = document.getElementById('edit_image_preview');
                    previewImg.src = `<?= base_url('uploads/dokumentasi') ?>/` + imagePath;
                    previewContainer.style.display = 'block';
                } else {
                    // For adding or editing without existing image, make at least one required (controller does this)
                    imageReq.classList.add('d-none'); 
                    if (isEditMode) {
                        document.getElementById('edit_image_preview_container').style.display = 'none';
                    }
                }

                if (durationGroup) durationGroup.classList.add('d-none');
                if (sourceCol) {
                    sourceCol.classList.remove('col-sm-6');
                    sourceCol.classList.add('col-sm-12');
                }
            }
        };

        // Tambah Modal Dynamic Select
        const addType = document.getElementById('add_vid_type');
        const addYoutubeGroup = document.getElementById('add_youtube_id_group');
        const addYoutubeInput = document.getElementById('add_vid_youtube');
        const addYoutubeReq = document.getElementById('add_youtube_req');
        const addImageGroup = document.getElementById('add_image_group');
        const addImageInput = document.getElementById('add_vid_image');
        const addImageReq = document.getElementById('add_image_req');

        addType.addEventListener('change', () => {
            handleTypeChange(addType, addYoutubeGroup, addYoutubeInput, addYoutubeReq, addImageGroup, addImageInput, addImageReq);
        });
        // Initial run for Tambah
        handleTypeChange(addType, addYoutubeGroup, addYoutubeInput, addYoutubeReq, addImageGroup, addImageInput, addImageReq);

        // Edit Modal Dynamic Select
        const editYoutubeGroup = document.getElementById('edit_youtube_id_group');
        const editYoutubeReq = document.getElementById('edit_youtube_req');
        const editImageGroup = document.getElementById('edit_image_group');
        const editImageInput = document.getElementById('edit_vid_image');
        const editImageReq = document.getElementById('edit_image_req');

        editType.addEventListener('change', () => {
            const imagePath = editType.getAttribute('data-current-image') || '';
            handleTypeChange(editType, editYoutubeGroup, editYoutubeId, editYoutubeReq, editImageGroup, editImageInput, editImageReq, true, imagePath);
        });

        // Populate Edit Modal
        document.querySelectorAll('.btn-edit-video').forEach(btn => {
            btn.addEventListener('click', () => {
                const id = btn.getAttribute('data-id');
                const title = btn.getAttribute('data-title');
                const type = btn.getAttribute('data-type');
                const youtubeId = btn.getAttribute('data-youtube-id');
                const category = btn.getAttribute('data-category');
                const duration = btn.getAttribute('data-duration');
                const source = btn.getAttribute('data-source');
                const desc = btn.getAttribute('data-desc');
                const imagePath = btn.getAttribute('data-image-path') || '';
                const imageGalleryStr = btn.getAttribute('data-image-gallery') || '[]';
                let imageGallery = [];
                try {
                    imageGallery = JSON.parse(imageGalleryStr);
                } catch(e) {
                    imageGallery = [];
                }

                editId.value = id;
                editTitle.value = title;
                editType.value = type;
                editYoutubeId.value = youtubeId;
                editCategory.value = category;
                editDuration.value = duration;
                editSource.value = source;
                editDesc.value = desc;
                
                editType.setAttribute('data-current-image', imagePath);
                
                // Populate gallery previews for deletion
                const galleryContainer = document.getElementById('edit_gallery_preview_container');
                const galleryList = document.getElementById('edit_gallery_preview_list');
                galleryList.innerHTML = '';
                
                if (type === 'dokumentasi' && imageGallery.length > 0) {
                    imageGallery.forEach(img => {
                        const item = document.createElement('div');
                        item.className = 'position-relative d-inline-block border rounded overflow-hidden';
                        item.style.width = '70px';
                        item.style.height = '50px';
                        item.innerHTML = `
                            <img src="<?= base_url('uploads/dokumentasi') ?>/${img}" style="width: 100%; height: 100%; object-fit: cover;">
                            <div class="position-absolute top-0 end-0 bg-danger text-white rounded-bottom-start px-1" style="cursor: pointer; font-size: 0.7rem;" onclick="toggleDeleteGalleryPhoto(this, '${img}')">
                                <i class="fa-solid fa-xmark"></i>
                            </div>
                        `;
                        galleryList.appendChild(item);
                    });
                    galleryContainer.style.display = 'block';
                } else {
                    galleryContainer.style.display = 'none';
                }
                
                // Initialize toggle state for Edit Modal
                handleTypeChange(editType, editYoutubeGroup, editYoutubeId, editYoutubeReq, editImageGroup, editImageInput, editImageReq, true, imagePath);

                editModal.show();
            });
        });

        // --------------------------------------------------------------------------
        // Client-side Filter & Search Logic
        // --------------------------------------------------------------------------
        const searchInput = document.getElementById('video-search-input');
        const filterBtns = document.querySelectorAll('#video-filter-tab button');
        const cards = document.querySelectorAll('.video-card-item');

        const updateCounters = () => {
            let total = 0, edu = 0, dok = 0;
            cards.forEach(c => {
                total++;
                if (c.getAttribute('data-type') === 'dokumentasi') dok++;
                else edu++;
            });
            document.getElementById('count-all').innerText = total;
            document.getElementById('count-edukasi').innerText = edu;
            document.getElementById('count-dokumentasi').innerText = dok;
        };
        updateCounters();

        const filterVideos = () => {
            const query = searchInput.value.toLowerCase().trim();
            const activeFilter = document.querySelector('#video-filter-tab button.active').getAttribute('data-filter');

            cards.forEach(card => {
                const cardType = card.getAttribute('data-type');
                const cardTitle = card.getAttribute('data-title');
                const cardDesc = card.getAttribute('data-desc');

                const matchesSearch = cardTitle.includes(query) || cardDesc.includes(query);
                const matchesFilter = (activeFilter === 'all') || (activeFilter === cardType);

                if (matchesSearch && matchesFilter) {
                    card.classList.remove('d-none');
                } else {
                    card.classList.add('d-none');
                }
            });
        };

        // Filter button click handler
        filterBtns.forEach(btn => {
            btn.addEventListener('click', () => {
                filterBtns.forEach(b => b.classList.remove('active'));
                btn.classList.add('active');
                filterVideos();
            });
        });

        // Search keyup handler
        searchInput.addEventListener('keyup', filterVideos);
    });
</script>
<?= $this->endSection() ?>
