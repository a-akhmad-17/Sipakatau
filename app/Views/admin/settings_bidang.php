<?= $this->extend('layouts/admin') ?>

<?= $this->section('content') ?>
<div class="container-fluid px-0">
    <!-- Header / Breadcrumbs -->
    <div class="d-flex justify-content-between align-items-center mb-4 pb-2 border-bottom" style="border-color: var(--border-color) !important;">
        <div>
            <h3 class="mb-1 font-heading" style="color: var(--text-main);"><i class="fa-solid fa-circle-nodes text-primary me-2"></i>Pengaturan Bidang & Unit Kerja</h3>
            <p class="small mb-0" style="color: var(--text-muted);">Kelola deskripsi bidang struktural serta sub-unit program kerja Kesbangpol Sinjai.</p>
        </div>
        <nav aria-label="breadcrumb">
            <ol class="breadcrumb mb-0">
                <li class="breadcrumb-item"><a href="<?= site_url('admin') ?>" class="text-primary text-decoration-none">Dasbor</a></li>
                <li class="breadcrumb-item text-muted active" aria-current="page">Bidang & Unit</li>
            </ol>
        </nav>
    </div>

    <!-- Bidang Grid -->
    <div class="row g-4">
        <?php foreach ($bidang as $b): 
            $borderHex = $b['color'] ?? '#71717a';
        ?>
            <div class="col-md-6">
                <div class="glass-card p-4 h-100 d-flex flex-column justify-content-between" style="border-left: 5px solid <?= $borderHex ?> !important;">
                    <div>
                        <div class="d-flex justify-content-between align-items-start mb-3">
                            <div class="d-flex align-items-center gap-3">
                                <div class="rounded-circle d-flex align-items-center justify-content-center flex-shrink-0" style="width: 48px; height: 48px; background-color: rgba(255, 255, 255, 0.05); border: 1px solid var(--border-color); color: <?= $borderHex ?>; font-size: 1.35rem;">
                                    <i class="fa-solid <?= esc($b['icon'] ?? 'fa-folder-open') ?>"></i>
                                </div>
                                <div>
                                    <h4 class="mb-0" style="color: var(--text-main); font-size: 1.15rem;"><?= esc($b['title']) ?></h4>
                                    <span class="badge" style="background-color: rgba(127, 127, 127, 0.12); color: var(--text-muted); font-size: 0.7rem; border: 1px solid var(--border-color);"><?= esc($b['subtitle']) ?></span>
                                </div>
                            </div>
                            <span class="badge" style="background: var(--card-bg); color: var(--text-muted); font-size: 0.72rem; border: 1px solid var(--border-color);">ID Slot: <?= esc($b['id']) ?></span>
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

                    <div class="pt-3 border-top" style="border-color: var(--border-color) !important;">
                        <button type="button" class="btn btn-sm btn-outline-primary w-100 btn-edit-bidang" 
                                data-id="<?= esc($b['id']) ?>" 
                                data-title="<?= esc($b['title']) ?>" 
                                data-desc="<?= esc($b['description'] ?? '') ?>" 
                                data-subunits="<?= esc(json_encode($b['sub_units'] ?? [])) ?>">
                            <i class="fa-solid fa-pen-to-square me-1"></i>Sunting Bidang
                        </button>
                    </div>
                </div>
            </div>
        <?php endforeach; ?>
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
                    <!-- Deskripsi -->
                    <div class="mb-4">
                        <label for="edit_bidang_desc" class="form-label small" style="color: var(--text-muted);">Deskripsi Tugas *</label>
                        <textarea name="description" id="edit_bidang_desc" class="form-control form-control-custom" rows="4" required placeholder="Tuliskan deskripsi tugas bidang..."></textarea>
                    </div>

                    <!-- Sub-Units CRUD -->
                    <div>
                        <div class="d-flex justify-content-between align-items-center mb-2">
                            <label class="form-label small text-muted mb-0">Daftar Sub Unit Kerja</label>
                            <button type="button" class="btn btn-sm btn-success text-white py-1 px-2" id="btn-add-subunit" style="font-size: 0.75rem; border-radius: 6px;">
                                <i class="fa-solid fa-plus me-1"></i> Tambah Sub-Unit
                            </button>
                        </div>
                        <p class="small mb-3" style="color: var(--text-muted);">Tuliskan nama seksi/sub-unit dari bidang ini. Gunakan tombol Tambah untuk membuat kolom input baru.</p>
                        
                        <!-- Sub Unit Container -->
                        <div id="subunit-container" class="d-flex flex-column gap-2" style="max-height: 250px; overflow-y: auto; padding-right: 5px;">
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
        const editBidangDesc = document.getElementById('edit_bidang_desc');
        const subunitContainer = document.getElementById('subunit-container');
        const btnAddSubunit = document.getElementById('btn-add-subunit');

        // Function to render a subunit input row
        const createSubunitRow = (value = '') => {
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
            
            // Remove listener
            div.querySelector('.btn-remove-subunit').addEventListener('click', () => {
                div.remove();
            });

            subunitContainer.appendChild(div);
        };

        // Click Edit Bidang
        document.querySelectorAll('.btn-edit-bidang').forEach(btn => {
            btn.addEventListener('click', () => {
                const id = btn.getAttribute('data-id');
                const title = btn.getAttribute('data-title');
                const desc = btn.getAttribute('data-desc');
                const subunits = JSON.parse(btn.getAttribute('data-subunits') || '[]');

                modalTitle.innerText = title;
                editBidangId.value = id;
                editBidangDesc.value = desc;

                // Clear previous inputs
                subunitContainer.innerHTML = '';

                // Populate subunits
                if (subunits.length > 0) {
                    subunits.forEach(sub => createSubunitRow(sub));
                } else {
                    // Create one empty row by default
                    createSubunitRow();
                }

                editModal.show();
            });
        });

        // Click Add Subunit Row
        btnAddSubunit.addEventListener('click', () => {
            createSubunitRow();
            // Scroll to bottom
            subunitContainer.scrollTop = subunitContainer.scrollHeight;
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
