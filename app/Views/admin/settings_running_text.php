<?= $this->extend('layouts/admin') ?>

<?= $this->section('content') ?>
<div class="row animate-fade-up">
    <div class="col-12">
        <div class="d-flex justify-content-between align-items-center mb-4">
            <div>
                <h3 class="mb-1 text-main font-heading"><i class="fa-solid fa-repeat text-primary me-2"></i> Pengaturan Teks Berjalan</h3>
                <p class="text-muted mb-0">Kelola hingga 3 kalimat pengumuman berjalan untuk seluruh halaman portal dan dasbor.</p>
            </div>
            <nav aria-label="breadcrumb">
                <ol class="breadcrumb mb-0">
                    <li class="breadcrumb-item"><a href="<?= site_url('admin') ?>">Admin</a></li>
                    <li class="breadcrumb-item active" aria-current="page">Teks Berjalan</li>
                </ol>
            </nav>
        </div>

        <div class="row g-4">
            <!-- Left Side: Manage Current Sentences -->
            <div class="col-lg-7">
                <div class="glass-card h-100">
                    <h5 class="card-title font-heading mb-4 text-main d-flex align-items-center gap-2">
                        <i class="fa-solid fa-list-ul text-primary"></i> Daftar Kalimat Aktif
                        <span class="badge bg-primary-subtle text-primary border border-primary-subtle rounded-pill ms-auto" style="font-size: 0.72rem;">
                            <?= count($texts) ?> / 3 Kalimat
                        </span>
                    </h5>

                    <?php if (empty($texts)): ?>
                        <div class="text-center py-5">
                            <div class="mb-3 text-muted">
                                <i class="fa-solid fa-keyboard fa-3x opacity-25"></i>
                            </div>
                            <h6 class="text-main fw-bold">Belum Ada Teks Berjalan</h6>
                            <p class="text-muted small mx-auto" style="max-width: 320px;">Silakan tambahkan kalimat pengumuman pertama Anda di panel sebelah kanan.</p>
                        </div>
                    <?php else: ?>
                        <div class="table-responsive">
                            <table class="table align-middle" style="border-color: var(--border-color);">
                                <thead>
                                    <tr class="text-muted" style="font-size: 0.8rem; letter-spacing: 0.5px;">
                                        <th style="width: 80px;" class="text-center">No</th>
                                        <th>Kalimat Pengumuman</th>
                                        <th style="width: 150px;" class="text-center">Aksi</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php foreach ($texts as $idx => $sentence): ?>
                                        <tr>
                                            <td class="text-center align-middle fw-bold text-muted"><?= $idx + 1 ?></td>
                                            <td class="align-middle">
                                                <div class="text-main fw-medium py-1" style="font-size: 0.95rem; line-height: 1.5; white-space: pre-wrap;"><?= esc($sentence) ?></div>
                                            </td>
                                            <td class="text-center align-middle">
                                                <div class="d-flex justify-content-center gap-2">
                                                    <button type="button" class="btn btn-sm btn-outline-info px-2.5 py-1" 
                                                            onclick="editSentence(<?= $idx ?>, '<?= esc($sentence, 'js') ?>')" 
                                                            title="Edit">
                                                        <i class="fa-solid fa-pen-to-square"></i>
                                                    </button>
                                                    <form action="<?= site_url('admin/settings/running-text/delete/' . $idx) ?>" method="POST" class="d-inline" onsubmit="return confirm('Hapus kalimat ini dari daftar teks berjalan?')">
                                                        <?= csrf_field() ?>
                                                        <button type="submit" class="btn btn-sm btn-outline-danger px-2.5 py-1" title="Hapus">
                                                            <i class="fa-solid fa-trash"></i>
                                                        </button>
                                                    </form>
                                                </div>
                                            </td>
                                        </tr>
                                    <?php endforeach; ?>
                                </tbody>
                            </table>
                        </div>
                    <?php endif; ?>
                </div>
            </div>

            <!-- Right Side: Speed Settings & Add Sentence Form -->
            <div class="col-lg-5">
                <div class="d-flex flex-column gap-4 animate-fade-up delay-1">
                    <!-- Speed settings card -->
                    <div class="glass-card">
                        <h5 class="card-title font-heading mb-4 text-main">
                            <i class="fa-solid fa-gauge-high text-primary me-2"></i> Kecepatan Teks Berjalan
                        </h5>
                        <form action="<?= site_url('admin/settings/running-text/speed') ?>" method="POST">
                            <?= csrf_field() ?>
                            <div class="mb-4">
                                <label for="speed" class="form-label text-muted small fw-bold">Pilih Kecepatan Pergerakan</label>
                                <select name="speed" id="speed" class="form-select form-control-custom">
                                    <option value="15s" <?= ($speed === '15s') ? 'selected' : '' ?>>Cepat (15 detik)</option>
                                    <option value="30s" <?= ($speed === '30s') ? 'selected' : '' ?>>Sedang (30 detik) - Standar</option>
                                    <option value="45s" <?= ($speed === '45s') ? 'selected' : '' ?>>Lambat (45 detik)</option>
                                </select>
                                <div class="form-text text-muted mt-2" style="font-size: 0.75rem;">
                                    Catatan: Semakin kecil durasi detiknya, maka pergerakan teks berjalan akan semakin cepat.
                                </div>
                            </div>
                            <button type="submit" class="btn btn-portal w-100 py-2.5">
                                <i class="fa-solid fa-save me-2"></i> Perbarui Kecepatan
                            </button>
                        </form>
                    </div>

                    <!-- Add sentence form card -->
                    <div class="glass-card">
                        <h5 class="card-title font-heading mb-4 text-main">
                            <i class="fa-solid fa-plus-circle text-primary me-2"></i> Tambah Kalimat Baru
                        </h5>

                        <?php if (count($texts) >= 3): ?>
                            <div class="alert alert-warning bg-warning-subtle border-warning-subtle text-warning p-3 rounded" style="border-radius: 12px; font-size: 0.9rem;" role="alert">
                                <i class="fa-solid fa-circle-exclamation me-2 fa-lg"></i>
                                <strong>Batas Kalimat Tercapai!</strong><br>
                                Anda telah menambahkan maksimal 3 kalimat berjalan. Silakan edit atau hapus kalimat yang sudah ada untuk memasukkan kalimat baru.
                            </div>
                            <div class="text-center py-4 opacity-50">
                                <i class="fa-solid fa-lock fa-4x mb-3 text-muted"></i>
                                <h6 class="fw-bold">Form Terkunci</h6>
                            </div>
                        <?php else: ?>
                            <form action="<?= site_url('admin/settings/running-text/tambah') ?>" method="POST">
                                <?= csrf_field() ?>
                                <div class="mb-4">
                                    <div class="d-flex justify-content-between align-items-center mb-1">
                                        <label for="sentence" class="form-label text-muted small fw-bold mb-0">Kalimat Pengumuman</label>
                                        <span id="char-counter" class="text-muted small">0 / 150</span>
                                    </div>
                                    <textarea name="sentence" id="sentence" rows="4" class="form-control form-control-custom" 
                                              placeholder="Tulis kalimat pengumuman di sini secara ringkas dan informatif..." required maxlength="150" oninput="updateCounter('sentence', 'char-counter')"></textarea>
                                    <div class="form-text text-muted mt-2" style="font-size: 0.75rem;">
                                        Tips: Gunakan ejaan yang baik dan tanda baca yang benar karena kalimat akan langsung tampil di beranda utama.
                                    </div>
                                </div>

                                <button type="submit" class="btn btn-portal w-100 py-2.5">
                                    <i class="fa-solid fa-paper-plane me-2"></i> Simpan Kalimat
                                </button>
                            </form>
                        <?php endif; ?>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Modal Edit Kalimat -->
<div class="modal fade" id="modalEdit" tabindex="-1" aria-labelledby="modalEditLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content border-0 glass-card p-0" style="overflow: hidden;">
            <div class="modal-header border-0 px-4 pt-4 pb-0 d-flex justify-content-between align-items-center">
                <h5 class="modal-title font-heading text-main" id="modalEditLabel"><i class="fa-solid fa-pen-to-square text-primary me-2"></i> Edit Kalimat Berjalan</h5>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form action="<?= site_url('admin/settings/running-text/update') ?>" method="POST">
                <?= csrf_field() ?>
                <input type="hidden" name="index" id="edit-index">
                <div class="modal-body px-4 py-4">
                    <div class="mb-3">
                        <div class="d-flex justify-content-between align-items-center mb-1">
                            <label for="edit-sentence" class="form-label text-muted small fw-bold mb-0">Kalimat Pengumuman</label>
                            <span id="edit-char-counter" class="text-muted small">0 / 150</span>
                        </div>
                        <textarea name="sentence" id="edit-sentence" rows="4" class="form-control form-control-custom" required maxlength="150" oninput="updateCounter('edit-sentence', 'edit-char-counter')"></textarea>
                    </div>
                </div>
                <div class="modal-footer border-0 px-4 pb-4 pt-0">
                    <button type="button" class="btn btn-outline-secondary px-4" data-bs-dismiss="modal">Batal</button>
                    <button type="submit" class="btn btn-portal px-4"><i class="fa-solid fa-save me-1.5"></i> Simpan Perubahan</button>
                </div>
            </form>
        </div>
    </div>
</div>

<?= $this->endSection() ?>

<?= $this->section('scripts') ?>
<script>
    function updateCounter(textareaId, counterId) {
        const textarea = document.getElementById(textareaId);
        const counter = document.getElementById(counterId);
        if (textarea && counter) {
            const len = textarea.value.length;
            counter.innerText = `${len} / 150`;
            if (len >= 150) {
                counter.classList.add('text-danger');
                counter.classList.remove('text-muted');
            } else {
                counter.classList.remove('text-danger');
                counter.classList.add('text-muted');
            }
        }
    }

    function editSentence(index, sentence) {
        document.getElementById('edit-index').value = index;
        document.getElementById('edit-sentence').value = sentence;
        updateCounter('edit-sentence', 'edit-char-counter');
        
        const modal = new bootstrap.Modal(document.getElementById('modalEdit'));
        modal.show();
    }
</script>
<?= $this->endSection() ?>
