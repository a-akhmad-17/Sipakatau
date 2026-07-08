<?= $this->extend('layouts/admin') ?>

<?= $this->section('content') ?>
<div class="container-fluid px-0">
    <!-- Header / Breadcrumbs -->
    <div class="d-flex justify-content-between align-items-center mb-4 pb-2 border-bottom" style="border-color: var(--border-color) !important;">
        <div>
            <h3 class="mb-1 font-heading" style="color: var(--text-main);"><i class="fa-solid fa-circle-nodes text-primary me-2"></i>Pengaturan Bidang & Unit Kerja</h3>
            <p class="small mb-0" style="color: var(--text-muted);">Kelola deskripsi bidang struktural serta sub-unit program kerja Kesbangpol Sinjai.</p>
        </div>
        <div>
            <button type="button" class="btn btn-primary text-white fw-bold btn-portal" data-bs-toggle="modal" data-bs-target="#modalTambahBidang">
                <i class="fa-solid fa-plus me-1.5"></i>Tambah Bidang Baru
            </button>
        </div>
    </div>

    <!-- Bidang Grid -->
    <div class="row g-4">
        <?php foreach ($bidang as $b): 
            $borderHex = $b['color'] ?? '#71717a';
        ?>
            <div class="col-md-6 col-lg-6">
                <div class="glass-card p-4 h-100 d-flex flex-column justify-content-between" style="border-left: 5px solid <?= $borderHex ?> !important; min-height: 280px;">
                    <div>
                        <div class="d-flex justify-content-between align-items-start mb-3">
                            <div class="d-flex align-items-center gap-3">
                                <div class="rounded-circle d-flex align-items-center justify-content-center flex-shrink-0" style="width: 48px; height: 48px; background-color: rgba(255, 255, 255, 0.05); border: 1px solid var(--border-color); color: <?= $borderHex ?>; font-size: 1.35rem;">
                                    <i class="fa-solid <?= esc($b['icon'] ?? 'fa-folder-open') ?>"></i>
                                </div>
                                <div>
                                    <h4 class="mb-0" style="color: var(--text-main); font-size: 1.15rem;"><?= esc($b['title']) ?></h4>
                                    <span class="badge" style="background-color: rgba(127, 127, 127, 0.12); color: var(--text-muted); font-size: 0.7rem; border: 1px solid var(--border-color);"><?= esc($b['subtitle'] ?? '') ?></span>
                                </div>
                            </div>
                            <span class="badge" style="background: var(--card-bg); color: var(--text-muted); font-size: 0.72rem; border: 1px solid var(--border-color);">ID: <?= esc($b['id']) ?></span>
                        </div>

                        <div class="mb-4">
                            <h6 class="small mb-1 fw-bold" style="color: var(--text-muted);">Deskripsi Tugas:</h6>
                            <p class="small mb-0" style="color: var(--text-main); opacity: 0.7; line-height: 1.6; text-align: justify;"><?= esc($b['description'] ?? 'Belum ada deskripsi tugas untuk bidang ini.') ?></p>
                        </div>

                        <div class="mb-4">
                            <h6 class="small mb-2 fw-bold" style="color: var(--text-muted);">Sub Unit / Seksi Kerja:</h6>
                            <?php if (empty($b['sub_units'])): ?>
                                <span class="small" style="color: var(--text-muted); font-style: italic;">Tidak ada sub-unit.</span>
                            <?php else: ?>
                                <div class="d-flex flex-wrap gap-2">
                                    <?php foreach ($b['sub_units'] as $sub): ?>
                                        <span class="badge" style="background: rgba(127,127,127,0.1); color: var(--text-main); border: 1px solid var(--border-color); padding: 6px 12px; font-weight: 500; font-size: 0.78rem;">
                                            <i class="fa-solid fa-check text-success me-1" style="font-size: 0.7rem;"></i><?= esc($sub) ?>
                                        </span>
                                    <?php endforeach; ?>
                                </div>
                            <?php endif; ?>
                        </div>
                    </div>

                    <div class="pt-3 border-top d-flex gap-2" style="border-color: var(--border-color) !important;">
                        <button type="button" class="btn btn-sm btn-outline-primary flex-grow-1 btn-edit-bidang" 
                                data-id="<?= esc($b['id']) ?>" 
                                data-title="<?= esc($b['title']) ?>" 
                                data-subtitle="<?= esc($b['subtitle'] ?? '') ?>" 
                                data-icon="<?= esc($b['icon'] ?? 'fa-folder-open') ?>" 
                                data-color="<?= esc($b['color'] ?? '#71717a') ?>" 
                                data-desc="<?= esc($b['description'] ?? '') ?>" 
                                data-subunits="<?= esc(json_encode($b['sub_units'] ?? [])) ?>">
                            <i class="fa-solid fa-pen-to-square me-1"></i>Sunting
                        </button>
                        <form action="<?= base_url('admin/settings/bidang/delete/' . esc($b['id'])) ?>" method="POST" onsubmit="return confirm('Apakah Anda yakin ingin menghapus bidang ini? Semua sub-unit akan ikut dihapus.');" class="d-inline">
                            <?= csrf_field() ?>
                            <button type="submit" class="btn btn-sm btn-outline-danger px-2.5 py-1.5 rounded"><i class="fa-solid fa-trash-can"></i></button>
                        </form>
                    </div>
                </div>
            </div>
        <?php endforeach; ?>
    </div>
</div>

<!-- Modal Tambah Bidang -->
<div class="modal fade" id="modalTambahBidang" tabindex="-1" aria-labelledby="modalTambahBidangLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-lg">
        <div class="modal-content glass-card-modal" style="background: var(--bg-color) !important; border: 1px solid var(--border-color) !important; color: var(--text-main) !important; border-radius: 16px;">
            <div class="modal-header border-secondary border-opacity-25" style="border-bottom: 1px solid var(--border-color) !important;">
                <h5 class="modal-title font-heading" id="modalTambahBidangLabel" style="color: var(--text-main);"><i class="fa-solid fa-plus text-warning me-2"></i>Tambah Bidang Baru</h5>
                <button type="button" class="btn-close" style="filter: var(--btn-close-filter, invert(1) grayscale(100%) brightness(200%));" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form action="<?= base_url('admin/settings/bidang/tambah') ?>" method="POST">
                <?= csrf_field() ?>
                <div class="modal-body">
                    <div class="row g-3 mb-3">
                        <div class="col-md-6">
                            <label for="add_bidang_title" class="form-label small" style="color: var(--text-muted);">Nama Bidang *</label>
                            <input type="text" name="title" id="add_bidang_title" class="form-control form-control-custom" placeholder="Contoh: Bidang Politik Dalam Negeri" required>
                        </div>
                        <div class="col-md-6">
                            <label for="add_bidang_subtitle" class="form-label small" style="color: var(--text-muted);">Sub-Judul / Keterangan</label>
                            <input type="text" name="subtitle" id="add_bidang_subtitle" class="form-control form-control-custom" placeholder="Contoh: Urusan Parpol & Ormas">
                        </div>
                        <div class="col-md-6">
                            <label for="add_bidang_icon" class="form-label small" style="color: var(--text-muted);">FontAwesome Icon Class</label>
                            <input type="text" name="icon" id="add_bidang_icon" class="form-control form-control-custom" placeholder="Contoh: fa-building-flag" value="fa-folder-open">
                        </div>
                        <div class="col-md-6">
                            <label for="add_bidang_color" class="form-label small" style="color: var(--text-muted);">Warna Tema (Hex Color)</label>
                            <input type="color" name="color" id="add_bidang_color" class="form-control form-control-custom" style="height: 42px; padding: 2px 8px;" value="#71717a">
                        </div>
                    </div>
                    <div class="mb-4">
                        <label for="add_bidang_desc" class="form-label small" style="color: var(--text-muted);">Deskripsi Tugas *</label>
                        <textarea name="description" id="add_bidang_desc" class="form-control form-control-custom" rows="3" required placeholder="Tuliskan tugas pokok bidang..."></textarea>
                    </div>
                    <div>
                        <div class="d-flex justify-content-between align-items-center mb-2">
                            <label class="form-label small text-muted mb-0">Daftar Sub Unit Kerja</label>
                            <button type="button" class="btn btn-sm btn-success text-white py-1 px-2" id="btn-add-subunit-add" style="font-size: 0.75rem; border-radius: 6px;">
                                <i class="fa-solid fa-plus me-1"></i> Tambah Sub-Unit
                            </button>
                        </div>
                        <div id="subunit-container-add" class="d-flex flex-column gap-2" style="max-height: 200px; overflow-y: auto; padding-right: 5px;">
                            <!-- Dynamically loaded inputs -->
                        </div>
                    </div>
                </div>
                <div class="modal-footer border-0">
                    <button type="button" class="btn btn-secondary" style="color: var(--text-main);" data-bs-dismiss="modal">Batal</button>
                    <button type="submit" class="btn btn-warning fw-bold" style="color: #1e293b; background: #eab308; border: none; padding: 8px 20px; border-radius: 8px;"><i class="fa-solid fa-floppy-disk me-1"></i> Simpan Bidang</button>
                </div>
            </form>
        </div>
    </div>
</div>

<!-- Modal Edit Bidang -->
<div class="modal fade" id="modalEditBidang" tabindex="-1" aria-labelledby="modalEditBidangLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-lg">
        <div class="modal-content glass-card-modal" style="background: var(--bg-color) !important; border: 1px solid var(--border-color) !important; color: var(--text-main) !important; border-radius: 16px;">
            <div class="modal-header border-secondary border-opacity-25" style="border-bottom: 1px solid var(--border-color) !important;">
                <h5 class="modal-title font-heading" id="modalEditBidangLabel" style="color: var(--text-main);">
                    <i class="fa-solid fa-pen-to-square text-info me-2"></i>Sunting Bidang: <span id="modal-bidang-title" style="color: var(--text-main);"></span>
                </h5>
                <button type="button" class="btn-close" style="filter: var(--btn-close-filter, invert(1) grayscale(100%) brightness(200%));" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form action="<?= base_url('admin/settings/bidang/update') ?>" method="POST">
                <?= csrf_field() ?>
                <input type="hidden" name="bidang_id" id="edit_bidang_id">
                <div class="modal-body">
                    <div class="row g-3 mb-3">
                        <div class="col-md-6">
                            <label for="edit_bidang_title_val" class="form-label small" style="color: var(--text-muted);">Nama Bidang *</label>
                            <input type="text" name="title" id="edit_bidang_title_val" class="form-control form-control-custom" required>
                        </div>
                        <div class="col-md-6">
                            <label for="edit_bidang_subtitle" class="form-label small" style="color: var(--text-muted);">Sub-Judul / Keterangan</label>
                            <input type="text" name="subtitle" id="edit_bidang_subtitle" class="form-control form-control-custom">
                        </div>
                        <div class="col-md-6">
                            <label for="edit_bidang_icon" class="form-label small" style="color: var(--text-muted);">FontAwesome Icon Class</label>
                            <input type="text" name="icon" id="edit_bidang_icon" class="form-control form-control-custom">
                        </div>
                        <div class="col-md-6">
                            <label for="edit_bidang_color" class="form-label small" style="color: var(--text-muted);">Warna Tema (Hex Color)</label>
                            <input type="color" name="color" id="edit_bidang_color" class="form-control form-control-custom" style="height: 42px; padding: 2px 8px;">
                        </div>
                    </div>
                    <div class="mb-4">
                        <label for="edit_bidang_desc" class="form-label small" style="color: var(--text-muted);">Deskripsi Tugas *</label>
                        <textarea name="description" id="edit_bidang_desc" class="form-control form-control-custom" rows="4" required placeholder="Tuliskan deskripsi tugas bidang..."></textarea>
                    </div>
                    <div>
                        <div class="d-flex justify-content-between align-items-center mb-2">
                            <label class="form-label small text-muted mb-0">Daftar Sub Unit Kerja</label>
                            <button type="button" class="btn btn-sm btn-success text-white py-1 px-2" id="btn-add-subunit" style="font-size: 0.75rem; border-radius: 6px;">
                                <i class="fa-solid fa-plus me-1"></i> Tambah Sub-Unit
                            </button>
                        </div>
                        <div id="subunit-container" class="d-flex flex-column gap-2" style="max-height: 200px; overflow-y: auto; padding-right: 5px;">
                            <!-- Dynamic inputs loaded here -->
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
        const editModal = new bootstrap.Modal(document.getElementById('modalEditBidang'));
        const modalTitle = document.getElementById('modal-bidang-title');
        const editBidangId = document.getElementById('edit_bidang_id');
        const editBidangTitleVal = document.getElementById('edit_bidang_title_val');
        const editBidangSubtitle = document.getElementById('edit_bidang_subtitle');
        const editBidangIcon = document.getElementById('edit_bidang_icon');
        const editBidangColor = document.getElementById('edit_bidang_color');
        const editBidangDesc = document.getElementById('edit_bidang_desc');
        const subunitContainer = document.getElementById('subunit-container');
        const btnAddSubunit = document.getElementById('btn-add-subunit');

        const subunitContainerAdd = document.getElementById('subunit-container-add');
        const btnAddSubunitAdd = document.getElementById('btn-add-subunit-add');

        // Function to render a subunit input row
        const createSubunitRow = (container, value = '') => {
            const div = document.createElement('div');
            div.className = 'd-flex gap-2 align-items-center subunit-row';
            div.innerHTML = `
                <div class="input-group input-group-sm">
                    <span class="input-group-text bg-secondary border-secondary text-white-50"><i class="fa-solid fa-circle-nodes"></i></span>
                    <input type="text" name="sub_units[]" class="form-control form-control-custom" value="${escapeHtml(value)}" placeholder="Nama Sub-Unit/Seksi" required>
                </div>
                <button type="button" class="btn btn-sm btn-outline-danger btn-remove-subunit" title="Hapus Sub-Unit">
                    <i class="fa-solid fa-xmark"></i>
                </button>
            `;
            
            div.querySelector('.btn-remove-subunit').addEventListener('click', () => {
                div.remove();
            });

            container.appendChild(div);
        };

        // Click Edit Bidang
        document.querySelectorAll('.btn-edit-bidang').forEach(btn => {
            btn.addEventListener('click', () => {
                const id = btn.getAttribute('data-id');
                const title = btn.getAttribute('data-title');
                const subtitle = btn.getAttribute('data-subtitle');
                const icon = btn.getAttribute('data-icon');
                const color = btn.getAttribute('data-color');
                const desc = btn.getAttribute('data-desc');
                const subunits = JSON.parse(btn.getAttribute('data-subunits') || '[]');

                modalTitle.innerText = title;
                editBidangId.value = id;
                editBidangTitleVal.value = title;
                editBidangSubtitle.value = subtitle;
                editBidangIcon.value = icon;
                editBidangColor.value = color;
                editBidangDesc.value = desc;

                // Clear previous inputs
                subunitContainer.innerHTML = '';

                // Populate subunits
                if (subunits.length > 0) {
                    subunits.forEach(sub => createSubunitRow(subunitContainer, sub));
                } else {
                    createSubunitRow(subunitContainer);
                }

                editModal.show();
            });
        });

        // Click Add Subunit Row inside Edit Modal
        btnAddSubunit.addEventListener('click', () => {
            createSubunitRow(subunitContainer);
            subunitContainer.scrollTop = subunitContainer.scrollHeight;
        });

        // Click Add Subunit Row inside Add Modal
        btnAddSubunitAdd.addEventListener('click', () => {
            createSubunitRow(subunitContainerAdd);
            subunitContainerAdd.scrollTop = subunitContainerAdd.scrollHeight;
        });

        // Populate Add Modal with 1 default empty subunit row
        document.getElementById('modalTambahBidang').addEventListener('shown.bs.modal', function () {
            if (subunitContainerAdd.children.length === 0) {
                createSubunitRow(subunitContainerAdd);
            }
        });

        // Simple HTML Escaper
        function escapeHtml(text) {
            return text
                .replace(/&/g, "&amp;")
                .replace(/</g, "&lt;")
                .replace(/>/g, "&gt;")
                .replace(/"/g, "&quot;")
                .replace(/'/g, "&#039;");
        }
    });
</script>
<?= $this->endSection() ?>
