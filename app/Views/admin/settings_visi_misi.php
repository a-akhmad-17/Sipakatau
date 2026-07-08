<?= $this->extend('layouts/admin') ?>

<?= $this->section('content') ?>
<div class="container-fluid px-0">
    <!-- Header / Breadcrumbs -->
    <div class="d-flex justify-content-between align-items-center mb-4 pb-2 border-bottom" style="border-color: var(--border-color) !important;">
        <div>
            <h3 class="mb-1 font-heading" style="color: var(--text-main);"><i class="fa-solid fa-quote-left text-primary me-2"></i>Pengaturan Visi & Misi</h3>
            <p class="small mb-0" style="color: var(--text-muted);">Kelola pernyataan Visi dan butir-butir Misi resmi Kesbangpol Kabupaten Sinjai.</p>
        </div>
        <nav aria-label="breadcrumb">
            <ol class="breadcrumb mb-0">
                <li class="breadcrumb-item"><a href="<?= site_url('admin') ?>" class="text-primary text-decoration-none">Dasbor</a></li>
                <li class="breadcrumb-item text-muted active" aria-current="page">Visi & Misi</li>
            </ol>
        </nav>
    </div>

    <div class="row g-4">
        <!-- Visi Card -->
        <div class="col-lg-5">
            <div class="glass-card p-4">
                <h4 class="mb-3" style="color: var(--text-main); font-size: 1.2rem;"><i class="fa-solid fa-eye text-primary me-2"></i>Visi Instansi</h4>
                <p class="small" style="color: var(--text-muted);">Pernyataan visi organisasi yang akan ditampilkan pada halaman profil portal publik.</p>
                
                <form action="<?= base_url('admin/settings/visi/update') ?>" method="POST">
                    <?= csrf_field() ?>
                    <div class="mb-4">
                        <label for="visi" class="form-label small" style="color: var(--text-muted);">Teks Visi *</label>
                        <textarea name="visi" id="visi" class="form-control form-control-custom" rows="6" required placeholder="Tuliskan visi instansi..."><?= esc($visi) ?></textarea>
                    </div>
                    <button type="submit" class="btn btn-portal w-100"><i class="fa-solid fa-floppy-disk me-2"></i> Simpan Visi</button>
                </form>
            </div>
        </div>

        <!-- Misi Card (CRUD) -->
        <div class="col-lg-7">
            <div class="glass-card p-4">
                <div class="d-flex justify-content-between align-items-center mb-3">
                    <h4 class="mb-0" style="color: var(--text-main); font-size: 1.2rem;"><i class="fa-solid fa-list-ol text-warning me-2"></i>Butir Misi Instansi</h4>
                    <button type="button" class="btn btn-sm btn-warning fw-semibold" data-bs-toggle="modal" data-bs-target="#modalTambahMisi" style="color: #1e293b;">
                        <i class="fa-solid fa-plus me-1"></i> Tambah Misi
                    </button>
                </div>
                <p class="small mb-4" style="color: var(--text-muted);">Butir-butir misi Kesbangpol Sinjai. Anda dapat menambah, menyunting, atau menghapus butir misi di bawah ini.</p>

                <?php if (empty($misi)): ?>
                    <div class="text-center py-5" style="color: var(--text-muted);">
                        <i class="fa-solid fa-quote-right fa-2x mb-3" style="opacity: 0.3; color: var(--text-muted);"></i>
                        <p class="mb-0">Tidak ada butir misi yang diatur. Silakan tambahkan misi baru.</p>
                    </div>
                <?php else: ?>
                    <div class="d-flex flex-column gap-3">
                        <?php foreach ($misi as $index => $item): ?>
                            <div class="card p-3 rounded" style="background: rgba(127, 127, 127, 0.03); border: 1px solid var(--border-color); color: var(--text-main);">
                                <div class="d-flex justify-content-between align-items-start gap-3">
                                    <div class="d-flex gap-3">
                                        <div class="d-flex align-items-center justify-content-center bg-primary rounded-circle flex-shrink-0" style="width: 30px; height: 30px; color: white; font-weight: 700;">
                                            <?= $index + 1 ?>
                                        </div>
                                        <div style="color: var(--text-main); font-size: 0.95rem; line-height: 1.5;"><?= esc($item) ?></div>
                                    </div>
                                    <div class="d-flex gap-1 flex-shrink-0">
                                        <button type="button" class="btn btn-sm btn-outline-info py-1 px-2 btn-edit-misi" data-index="<?= $index ?>" data-value="<?= esc($item) ?>" title="Sunting">
                                            <i class="fa-solid fa-pen-to-square"></i>
                                        </button>
                                        <form action="<?= base_url('admin/settings/misi/delete/' . $index) ?>" method="POST" onsubmit="return confirm('Apakah Anda yakin ingin menghapus butir misi ini?');" class="d-inline">
                                            <?= csrf_field() ?>
                                            <button type="submit" class="btn btn-sm btn-outline-danger py-1 px-2" title="Hapus">
                                                <i class="fa-solid fa-trash-can"></i>
                                            </button>
                                        </form>
                                    </div>
                                </div>
                            </div>
                        <?php endforeach; ?>
                    </div>
                <?php endif; ?>
            </div>
        </div>
    </div>

    <!-- Portal & TTE Settings -->
    <div class="row g-4 mt-2">
        <div class="col-lg-12">
            <div class="glass-card p-4">
                <h4 class="mb-3" style="color: var(--text-main); font-size: 1.2rem;"><i class="fa-solid fa-sliders text-primary me-2"></i>Pengaturan Umum Portal & TTE Srikandi</h4>
                <p class="small text-muted mb-4">Kelola kontak petugas piket dan variabel nama/NIP penandatangan TTE Srikandi.</p>
                
                <form action="<?= base_url('admin/settings/portal/update') ?>" method="POST">
                    <?= csrf_field() ?>
                    <div class="row g-3 mb-4">
                        <div class="col-md-4">
                            <label for="piket_phone" class="form-label small" style="color: var(--text-muted);">No. HP Petugas Piket (WhatsApp) *</label>
                            <input type="text" name="piket_phone" id="piket_phone" class="form-control form-control-custom" value="<?= esc($piket_phone) ?>" required placeholder="Contoh: 0811-7671-545">
                        </div>
                        <div class="col-md-4">
                            <label for="tte_nama_1" class="form-label small" style="color: var(--text-muted);">Nama Penandatangan Srikandi 1 *</label>
                            <input type="text" name="tte_nama_1" id="tte_nama_1" class="form-control form-control-custom" value="<?= esc($tte_nama_1) ?>" required>
                        </div>
                        <div class="col-md-4">
                            <label for="tte_nip_1" class="form-label small" style="color: var(--text-muted);">NIP Penandatangan Srikandi 1 *</label>
                            <input type="text" name="tte_nip_1" id="tte_nip_1" class="form-control form-control-custom" value="<?= esc($tte_nip_1) ?>" required>
                        </div>
                        <div class="col-md-4 offset-md-4">
                            <label for="tte_nama_2" class="form-label small" style="color: var(--text-muted);">Nama Penandatangan Srikandi 2 *</label>
                            <input type="text" name="tte_nama_2" id="tte_nama_2" class="form-control form-control-custom" value="<?= esc($tte_nama_2) ?>" required>
                        </div>
                        <div class="col-md-4">
                            <label for="tte_nip_2" class="form-label small" style="color: var(--text-muted);">NIP Penandatangan Srikandi 2 *</label>
                            <input type="text" name="tte_nip_2" id="tte_nip_2" class="form-control form-control-custom" value="<?= esc($tte_nip_2) ?>" required>
                        </div>
                    </div>
                    <button type="submit" class="btn btn-portal px-4 py-2"><i class="fa-solid fa-floppy-disk me-2"></i> Simpan Pengaturan Portal</button>
                </form>
            </div>
        </div>
    </div>
</div>

<!-- Modal Tambah Misi -->
<div class="modal fade" id="modalTambahMisi" tabindex="-1" aria-labelledby="modalTambahMisiLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content glass-card-modal" style="background: var(--bg-color) !important; border: 1px solid var(--border-color) !important; color: var(--text-main) !important; border-radius: 16px;">
            <div class="modal-header border-secondary border-opacity-25" style="border-bottom: 1px solid var(--border-color) !important;">
                <h5 class="modal-title font-heading" id="modalTambahMisiLabel" style="color: var(--text-main);"><i class="fa-solid fa-plus text-warning me-2"></i>Tambah Butir Misi Baru</h5>
                <button type="button" class="btn-close" style="filter: var(--btn-close-filter, invert(1) grayscale(100%) brightness(200%));" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form action="<?= base_url('admin/settings/misi/tambah') ?>" method="POST">
                <?= csrf_field() ?>
                <div class="modal-body">
                    <div class="mb-3">
                        <label for="new_misi" class="form-label small" style="color: var(--text-muted);">Deskripsi Misi *</label>
                        <textarea name="misi" id="new_misi" class="form-control form-control-custom" rows="4" placeholder="Tuliskan misi baru..." required></textarea>
                    </div>
                </div>
                <div class="modal-footer border-0">
                    <button type="button" class="btn btn-secondary" style="color: var(--text-main);" data-bs-dismiss="modal">Batal</button>
                    <button type="submit" class="btn btn-warning fw-bold" style="color: #1e293b; background: #eab308; border: none; padding: 8px 20px; border-radius: 8px;"><i class="fa-solid fa-plus me-1"></i> Tambah</button>
                </div>
            </form>
        </div>
    </div>
</div>

<!-- Modal Edit Misi -->
<div class="modal fade" id="modalEditMisi" tabindex="-1" aria-labelledby="modalEditMisiLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content glass-card-modal" style="background: var(--bg-color) !important; border: 1px solid var(--border-color) !important; color: var(--text-main) !important; border-radius: 16px;">
            <div class="modal-header border-secondary border-opacity-25" style="border-bottom: 1px solid var(--border-color) !important;">
                <h5 class="modal-title font-heading" id="modalEditMisiLabel" style="color: var(--text-main);"><i class="fa-solid fa-pen-to-square text-info me-2"></i>Sunting Butir Misi</h5>
                <button type="button" class="btn-close" style="filter: var(--btn-close-filter, invert(1) grayscale(100%) brightness(200%));" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form action="<?= base_url('admin/settings/misi/update') ?>" method="POST">
                <?= csrf_field() ?>
                <input type="hidden" name="index" id="edit_misi_index">
                <div class="modal-body">
                    <div class="mb-3">
                        <label for="edit_misi_value" class="form-label small" style="color: var(--text-muted);">Deskripsi Misi *</label>
                        <textarea name="misi" id="edit_misi_value" class="form-control form-control-custom" rows="4" required></textarea>
                    </div>
                </div>
                <div class="modal-footer border-0">
                    <button type="button" class="btn btn-secondary" style="color: var(--text-main);" data-bs-dismiss="modal">Batal</button>
                    <button type="submit" class="btn btn-info fw-bold text-white"><i class="fa-solid fa-floppy-disk me-1"></i> Simpan Perubahan</button>
                </div>
            </form>
        </div>
    </div>
</div>
<?= $this->endSection() ?>

<?= $this->section('scripts') ?>
<script>
    document.addEventListener('DOMContentLoaded', () => {
        const editMisiModal = new bootstrap.Modal(document.getElementById('modalEditMisi'));
        const editMisiIndex = document.getElementById('edit_misi_index');
        const editMisiValue = document.getElementById('edit_misi_value');

        document.querySelectorAll('.btn-edit-misi').forEach(btn => {
            btn.addEventListener('click', () => {
                const index = btn.getAttribute('data-index');
                const val = btn.getAttribute('data-value');

                editMisiIndex.value = index;
                editMisiValue.value = val;
                
                editMisiModal.show();
            });
        });
    });
</script>
<?= $this->endSection() ?>
