<?= $this->extend('layouts/admin') ?>

<?= $this->section('styles') ?>
<!-- Summernote Lite CSS -->
<link href="https://cdn.jsdelivr.net/npm/summernote@0.8.18/dist/summernote-lite.min.css" rel="stylesheet">
<style>
    .note-editor.note-frame {
        background: var(--input-bg) !important;
        border: 1px solid var(--input-border) !important;
        border-radius: 10px;
        overflow: hidden;
    }
    .note-editor .note-editing-area .note-editable {
        background: var(--input-bg) !important;
        color: var(--text-main) !important;
    }
    .note-editor.note-frame .note-statusbar {
        background: rgba(0, 0, 0, 0.05) !important;
        border-top: 1px solid var(--input-border) !important;
    }
    .note-toolbar {
        background: rgba(127, 127, 127, 0.08) !important;
        border-bottom: 1px solid var(--input-border) !important;
    }
    .note-btn {
        background: transparent !important;
        border: 1px solid var(--border-color) !important;
        color: var(--text-main) !important;
    }
    .note-btn:hover {
        background: rgba(255, 255, 255, 0.05) !important;
    }
    .note-dropdown-menu {
        background-color: var(--bg-color) !important;
        border: 1px solid var(--border-color) !important;
    }
    .note-dropdown-item {
        color: var(--text-muted) !important;
    }
    .note-dropdown-item:hover {
        background-color: rgba(255, 255, 255, 0.05) !important;
        color: var(--text-main) !important;
    }
    .btn-portal-news {
        background: linear-gradient(135deg, #e11d48, #be123c);
        border: none;
        color: #ffffff !important;
        font-weight: 600;
        padding: 10px 20px;
        border-radius: 10px;
        transition: var(--transition-smooth);
        box-shadow: 0 4px 15px rgba(225, 29, 72, 0.25);
    }
    .btn-portal-news:hover {
        transform: translateY(-2px);
        box-shadow: 0 8px 25px rgba(225, 29, 72, 0.45);
        background: linear-gradient(135deg, #be123c, #9f1239);
    }
</style>
<?= $this->endSection() ?>

<?= $this->section('content') ?>
<div class="container-fluid px-0">
    <!-- Header / Breadcrumbs -->
    <div class="d-flex justify-content-between align-items-center mb-4 pb-2 border-bottom" style="border-color: var(--border-color) !important;">
        <div>
            <h3 class="mb-1 font-heading" style="color: var(--text-main);"><i class="fa-solid fa-newspaper text-danger me-2"></i>Kelola Berita Kesbangpol</h3>
            <p class="small mb-0" style="color: var(--text-muted);">Publikasikan artikel berita kegiatan, sosialisasi, dan pengumuman instansi secara mandiri.</p>
        </div>
        <div class="d-flex gap-2">
            <button type="button" class="btn-portal-news" data-bs-toggle="modal" data-bs-target="#modalTambahBerita">
                <i class="fa-solid fa-plus me-1.5"></i>Tulis Berita Baru
            </button>
        </div>
    </div>

    <!-- Main Container -->
    <div class="card border-0" style="background: var(--card-bg); backdrop-filter: blur(20px); border: 1px solid var(--border-color) !important; border-radius: 16px;">
        <div class="card-body p-4">
            <!-- Search & Info -->
            <div class="d-flex flex-wrap justify-content-between align-items-center mb-4 gap-3">
                <h5 class="mb-0 font-heading" style="color: var(--text-main);">Daftar Semua Berita</h5>
                <div class="input-group input-group-sm" style="width: 280px;">
                    <span class="input-group-text bg-secondary border-secondary text-white-50"><i class="fa-solid fa-magnifying-glass"></i></span>
                    <input type="text" id="berita-search" class="form-control form-control-custom" placeholder="Cari judul berita...">
                </div>
            </div>

            <!-- Table -->
            <div class="table-responsive">
                <table class="table table-custom table-hover align-middle mb-0" id="table-berita">
                    <thead>
                        <tr>
                            <th style="width: 5%; text-align: center;">No</th>
                            <th style="width: 10%;">Cover</th>
                            <th style="width: 40%;">Judul & Kategori</th>
                            <th style="width: 15%; text-align: center;">Status</th>
                            <th style="width: 15%; text-align: center;">Tanggal Posting</th>
                            <th style="width: 15%; text-align: center;">Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php if (empty($berita)): ?>
                            <tr>
                                <td colspan="6" class="text-center py-5 text-muted">
                                    <i class="fa-solid fa-newspaper fa-3x mb-3" style="opacity: 0.3;"></i>
                                    <p class="mb-0">Belum ada berita yang diterbitkan. Silakan klik tombol "+ Tulis Berita Baru".</p>
                                </td>
                            </tr>
                        <?php else: ?>
                            <?php foreach ($berita as $idx => $b): ?>
                                <tr class="berita-row" data-title="<?= esc(strtolower($b['judul'])) ?>">
                                    <td class="text-center font-heading fw-bold" style="color: var(--text-muted);"><?= $idx + 1 ?></td>
                                    <td>
                                        <?php if (!empty($b['gambar'])): ?>
                                            <img src="<?= base_url('uploads/berita/' . $b['gambar']) ?>" alt="Cover" class="rounded border" style="width: 70px; height: 45px; object-fit: cover; border-color: var(--border-color) !important;">
                                        <?php else: ?>
                                            <div class="rounded border d-flex align-items-center justify-content-center bg-dark text-muted" style="width: 70px; height: 45px; font-size: 0.72rem; border-color: var(--border-color) !important;">
                                                No Cover
                                            </div>
                                        <?php endif; ?>
                                    </td>
                                    <td>
                                        <div class="fw-bold mb-1" style="color: var(--text-main); font-size: 0.95rem;"><?= esc($b['judul']) ?></div>
                                        <div class="d-flex align-items-center gap-2 flex-wrap">
                                            <span class="badge bg-secondary-subtle text-white-50 px-2 py-1" style="font-size: 0.68rem; border-radius: 4px; border: 1px solid var(--border-color);"><?= esc($b['kategori']) ?></span>
                                            <span style="font-size: 0.72rem; color: var(--text-muted);"><i class="fa-solid fa-eye me-1 text-info"></i><?= $b['view_count'] ?> kali dibaca</span>
                                            <span style="font-size: 0.72rem; color: var(--text-muted);"><i class="fa-solid fa-user me-1 text-primary"></i>Oleh: <?= esc($b['author'] ?? 'Admin') ?></span>
                                        </div>
                                    </td>
                                    <td class="text-center">
                                        <?php if ($b['status'] === 'Published'): ?>
                                            <span class="badge bg-success-subtle text-success border border-success-subtle px-2.5 py-1.5" style="font-size: 0.72rem; border-radius: 6px;">Published</span>
                                        <?php else: ?>
                                            <span class="badge bg-warning-subtle text-warning border border-warning-subtle px-2.5 py-1.5" style="font-size: 0.72rem; border-radius: 6px;">Draft</span>
                                        <?php endif; ?>
                                    </td>
                                    <td class="text-center text-muted" style="font-size: 0.8rem;"><?= date('d M Y H:i', strtotime($b['created_at'])) ?></td>
                                    <td class="text-center">
                                        <button class="btn btn-sm btn-outline-info py-1 px-2 btn-edit-berita" 
                                            data-id="<?= esc($b['id']) ?>"
                                            data-judul="<?= esc($b['judul']) ?>"
                                            data-kategori="<?= esc($b['kategori']) ?>"
                                            data-status="<?= esc($b['status']) ?>"
                                            data-gambar="<?= esc($b['gambar']) ?>"
                                            data-konten="<?= esc($b['konten']) ?>"
                                            title="Edit Berita">
                                            <i class="fa-solid fa-pen-to-square"></i> Edit
                                        </button>
                                        <form action="<?= base_url('admin/settings/berita/delete/' . esc($b['id'])) ?>" method="POST" onsubmit="return confirm('Apakah Anda yakin ingin menghapus berita ini secara permanen dari daftar aktif? (Aksi ini menggunakan Soft Delete)')" class="d-inline">
                                            <?= csrf_field() ?>
                                            <button type="submit" class="btn btn-sm btn-outline-danger py-1 px-2" title="Hapus Berita">
                                                <i class="fa-solid fa-trash-can"></i>
                                            </button>
                                        </form>
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

<!-- Modal Tambah Berita -->
<div class="modal fade" id="modalTambahBerita" tabindex="-1" aria-labelledby="modalTambahBeritaLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-xl">
        <div class="modal-content glass-card-modal" style="background: var(--bg-color) !important; border: 1px solid var(--border-color) !important; color: var(--text-main) !important; border-radius: 16px;">
            <div class="modal-header border-secondary border-opacity-25" style="border-bottom: 1px solid var(--border-color) !important;">
                <h5 class="modal-title font-heading text-white" id="modalTambahBeritaLabel"><i class="fa-solid fa-plus text-danger me-2"></i>Tulis Berita Baru</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form action="<?= base_url('admin/settings/berita/tambah') ?>" method="POST" enctype="multipart/form-data">
                <?= csrf_field() ?>
                <div class="modal-body">
                    <div class="row g-3">
                        <div class="col-md-8">
                            <div class="mb-3">
                                <label for="add_judul" class="form-label small" style="color: var(--text-muted);">Judul Berita <span class="text-danger">*</span></label>
                                <input type="text" name="judul" id="add_judul" class="form-control form-control-custom" placeholder="Tuliskan judul berita..." required>
                            </div>
                            <div class="mb-3">
                                <label for="add_konten" class="form-label small" style="color: var(--text-muted);">Konten Lengkap Berita <span class="text-danger">*</span></label>
                                <textarea name="konten" id="add_konten" class="summernote" required></textarea>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="mb-3">
                                <label for="add_kategori" class="form-label small" style="color: var(--text-muted);">Kategori Berita <span class="text-danger">*</span></label>
                                <select name="kategori" id="add_kategori" class="form-select form-control-custom" required>
                                    <option value="Berita Utama" selected>Berita Utama</option>
                                    <option value="Pengumuman">Pengumuman</option>
                                    <option value="Kegiatan">Kegiatan</option>
                                    <option value="Sosialisasi">Sosialisasi</option>
                                </select>
                            </div>
                            <div class="mb-3">
                                <label for="add_status" class="form-label small" style="color: var(--text-muted);">Status Publikasi <span class="text-danger">*</span></label>
                                <select name="status" id="add_status" class="form-select form-control-custom" required>
                                    <option value="Draft" selected>Draft</option>
                                    <option value="Published">Published (Tampilkan ke Publik)</option>
                                </select>
                            </div>
                            <div class="mb-3">
                                <label for="add_gambar" class="form-label small" style="color: var(--text-muted);">Gambar Cover Utama (Format: JPG, PNG, WEBP. Maks: 2MB)</label>
                                <input type="file" name="gambar" id="add_gambar" class="form-control form-control-custom mb-2" accept="image/*">
                                <span class="small d-block text-white-50" style="font-size: 0.72rem;">* Sistem otomatis mengonversi file gambar ke format WebP terkompresi.</span>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="modal-footer border-0">
                    <button type="button" class="btn btn-secondary text-white" data-bs-dismiss="modal">Batal</button>
                    <button type="submit" class="btn btn-portal-news fw-bold"><i class="fa-solid fa-floppy-disk me-1"></i> Simpan & Terbitkan</button>
                </div>
            </form>
        </div>
    </div>
</div>

<!-- Modal Edit Berita -->
<div class="modal fade" id="modalEditBerita" tabindex="-1" aria-labelledby="modalEditBeritaLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-xl">
        <div class="modal-content glass-card-modal" style="background: var(--bg-color) !important; border: 1px solid var(--border-color) !important; color: var(--text-main) !important; border-radius: 16px;">
            <div class="modal-header border-secondary border-opacity-25" style="border-bottom: 1px solid var(--border-color) !important;">
                <h5 class="modal-title font-heading text-white" id="modalEditBeritaLabel"><i class="fa-solid fa-pen-to-square text-info me-2"></i>Sunting Berita</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form action="<?= base_url('admin/settings/berita/update') ?>" method="POST" enctype="multipart/form-data">
                <?= csrf_field() ?>
                <input type="hidden" name="id" id="edit_id">
                <div class="modal-body">
                    <div class="row g-3">
                        <div class="col-md-8">
                            <div class="mb-3">
                                <label for="edit_judul" class="form-label small" style="color: var(--text-muted);">Judul Berita <span class="text-danger">*</span></label>
                                <input type="text" name="judul" id="edit_judul" class="form-control form-control-custom" required>
                            </div>
                            <div class="mb-3">
                                <label for="edit_konten" class="form-label small" style="color: var(--text-muted);">Konten Lengkap Berita <span class="text-danger">*</span></label>
                                <textarea name="konten" id="edit_konten" class="summernote" required></textarea>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="mb-3">
                                <label for="edit_kategori" class="form-label small" style="color: var(--text-muted);">Kategori Berita <span class="text-danger">*</span></label>
                                <select name="kategori" id="edit_kategori" class="form-select form-control-custom" required>
                                    <option value="Berita Utama">Berita Utama</option>
                                    <option value="Pengumuman">Pengumuman</option>
                                    <option value="Kegiatan">Kegiatan</option>
                                    <option value="Sosialisasi">Sosialisasi</option>
                                </select>
                            </div>
                            <div class="mb-3">
                                <label for="edit_status" class="form-label small" style="color: var(--text-muted);">Status Publikasi <span class="text-danger">*</span></label>
                                <select name="status" id="edit_status" class="form-select form-control-custom" required>
                                    <option value="Draft">Draft</option>
                                    <option value="Published">Published (Tampilkan ke Publik)</option>
                                </select>
                            </div>
                            <div class="mb-3">
                                <label for="edit_gambar" class="form-label small" style="color: var(--text-muted);">Gambar Cover Utama (Unggah baru untuk mengganti)</label>
                                <input type="file" name="gambar" id="edit_gambar" class="form-control form-control-custom mb-2" accept="image/*">
                                <div class="mt-2" id="edit_gambar_preview_box" style="display: none;">
                                    <span class="small d-block text-white-50 mb-1">Cover Saat Ini:</span>
                                    <img src="" id="edit_gambar_preview" class="rounded border" style="max-height: 80px; width: auto; max-width: 100%;">
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="modal-footer border-0">
                    <button type="button" class="btn btn-secondary text-white" data-bs-dismiss="modal">Batal</button>
                    <button type="submit" class="btn btn-info fw-bold text-white"><i class="fa-solid fa-floppy-disk me-1"></i> Simpan Perubahan</button>
                </div>
            </form>
        </div>
    </div>
</div>
<?= $this->endSection() ?>

<?= $this->section('scripts') ?>
<!-- jQuery & Summernote Lite JS -->
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/summernote@0.8.18/dist/summernote-lite.min.js"></script>
<script>
    $(document).ready(function() {
        // Function to upload Summernote image via AJAX
        function uploadContentImage(file, editor) {
            var data = new FormData();
            data.append("file", file);
            var csrfName = '<?= csrf_token() ?>';
            var csrfHash = '<?= csrf_hash() ?>';
            data.append(csrfName, csrfHash);

            $.ajax({
                url: "<?= site_url('admin/settings/berita/upload-image') ?>",
                cache: false,
                contentType: false,
                processData: false,
                data: data,
                type: "POST",
                success: function(response) {
                    if (response.url) {
                        $(editor).summernote('insertImage', response.url);
                    } else {
                        alert(response.error || "Gagal mengunggah gambar.");
                    }
                },
                error: function(jqXHR, textStatus, errorThrown) {
                    console.error(textStatus, errorThrown);
                    alert("Terjadi kesalahan saat mengunggah gambar.");
                }
            });
        }

        // Initialize Summernote Rich Text Editor
        $('.summernote').summernote({
            placeholder: 'Tuliskan isi berita di sini...',
            tabsize: 2,
            height: 320,
            toolbar: [
                ['style', ['style']],
                ['font', ['bold', 'underline', 'clear']],
                ['color', ['color']],
                ['para', ['ul', 'ol', 'paragraph']],
                ['table', ['table']],
                ['insert', ['link', 'picture', 'video']],
                ['view', ['fullscreen', 'codeview', 'help']]
            ],
            callbacks: {
                onInit: function() {
                    // Adjust Summernote colors for dark theme context dynamically if needed
                    $('.note-editable').css('color', 'var(--text-main)');
                },
                onImageUpload: function(files) {
                    uploadContentImage(files[0], this);
                }
            }
        });

        // Search news local filtering
        $('#berita-search').on('keyup', function() {
            var val = $(this).val().toLowerCase().trim();
            $('.berita-row').each(function() {
                var title = $(this).attr('data-title') || '';
                if (title.indexOf(val) > -1) {
                    $(this).show();
                } else {
                    $(this).hide();
                }
            });
        });

        // Edit News Modal populate
        const editModal = new bootstrap.Modal(document.getElementById('modalEditBerita'));
        $('.btn-edit-berita').on('click', function() {
            const id = $(this).attr('data-id');
            const judul = $(this).attr('data-judul');
            const kategori = $(this).attr('data-kategori');
            const status = $(this).attr('data-status');
            const gambar = $(this).attr('data-gambar');
            const konten = $(this).attr('data-konten');

            $('#edit_id').val(id);
            $('#edit_judul').val(judul);
            $('#edit_kategori').val(kategori);
            $('#edit_status').val(status);
            
            // Set summernote content
            $('#edit_konten').summernote('code', konten);

            // Preview cover image
            if (gambar) {
                $('#edit_gambar_preview').attr('src', '<?= base_url("uploads/berita") ?>/' + gambar);
                $('#edit_gambar_preview_box').show();
            } else {
                $('#edit_gambar_preview_box').hide();
            }

            editModal.show();
        });
    });
</script>
<?= $this->endSection() ?>
