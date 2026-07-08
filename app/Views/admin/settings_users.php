<?= $this->extend('layouts/admin') ?>

<?= $this->section('content') ?>
<div class="container-fluid px-0">
    <!-- Header / Breadcrumbs -->
    <div class="d-flex justify-content-between align-items-center mb-4 pb-2 border-bottom" style="border-color: var(--border-color) !important;">
        <div>
            <h3 class="mb-1 font-heading" style="color: var(--text-main);"><i class="fa-solid fa-users-gear text-primary me-2"></i>Kelola Akun Pengguna</h3>
            <p class="small mb-0" style="color: var(--text-muted);">Kelola kredensial, role, dan pembagian unit kerja (bidang) untuk seluruh pengguna portal.</p>
        </div>
        <div>
            <button type="button" class="btn btn-primary text-white fw-bold btn-portal" data-bs-toggle="modal" data-bs-target="#modalTambahUser">
                <i class="fa-solid fa-user-plus me-1.5"></i>Tambah Pengguna Baru
            </button>
        </div>
    </div>

    <!-- Alert status -->
    <?php if (session()->getFlashdata('success')): ?>
        <div class="alert alert-success border-success border-opacity-25 bg-success-subtle text-success py-2.5 px-4 mb-4" style="border-radius: 8px;">
            <i class="fa-solid fa-circle-check me-2"></i><?= session()->getFlashdata('success') ?>
        </div>
    <?php endif; ?>
    <?php if (session()->getFlashdata('error')): ?>
        <div class="alert alert-danger border-danger border-opacity-25 bg-danger-subtle text-danger py-2.5 px-4 mb-4" style="border-radius: 8px;">
            <i class="fa-solid fa-circle-xmark me-2"></i><?= session()->getFlashdata('error') ?>
        </div>
    <?php endif; ?>

    <!-- User List Table Card -->
    <div class="glass-card p-4">
        <div class="table-responsive">
            <table class="table table-custom rounded overflow-hidden" style="font-size:13px;">
                <thead>
                    <tr style="background:rgba(255,255,255,.04); color:var(--text-muted); font-size:11px; letter-spacing:.5px; text-transform:uppercase;">
                        <th style="padding:12px 14px; border-bottom:1px solid var(--border-color); width: 5%;">#</th>
                        <th style="padding:12px 14px; border-bottom:1px solid var(--border-color); width: 25%;">Identitas Pengguna</th>
                        <th style="padding:12px 14px; border-bottom:1px solid var(--border-color); width: 25%;">Kontak / Email</th>
                        <th style="padding:12px 14px; border-bottom:1px solid var(--border-color); width: 15%; text-align:center;">Role Akun</th>
                        <th style="padding:12px 14px; border-bottom:1px solid var(--border-color); width: 20%;">Penempatan Unit</th>
                        <th style="padding:12px 14px; border-bottom:1px solid var(--border-color); width: 10%; text-align:center;">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    <?php if (empty($users)): ?>
                        <tr>
                            <td colspan="6" class="text-center text-muted py-4">Belum ada akun pengguna yang terdaftar.</td>
                        </tr>
                    <?php else: ?>
                        <?php foreach ($users as $i => $u):
                            $roleClass = match($u['role']) {
                                'admin' => 'bg-danger-subtle text-danger border border-danger-subtle',
                                'kaban' => 'bg-primary-subtle text-primary border border-primary-subtle',
                                'kabid' => 'bg-warning-subtle text-warning border border-warning-subtle',
                                'ormas' => 'bg-success-subtle text-success border border-success-subtle',
                                default => 'bg-secondary-subtle text-secondary border border-secondary border-opacity-25',
                            };
                        ?>
                            <tr style="border-bottom: 1px solid rgba(255, 255, 255, .04);">
                                <td style="padding:12px 14px; color:var(--text-muted);"><?= $i + 1 ?></td>
                                <td style="padding:12px 14px;">
                                    <div class="fw-bold text-white"><?= esc($u['username']) ?></div>
                                    <div style="font-size:11px; color:var(--text-muted); opacity: 0.65;">UID: <?= esc($u['id']) ?></div>
                                </td>
                                <td style="padding:12px 14px;">
                                    <div class="text-white small"><i class="fa-solid fa-envelope me-1 text-muted"></i><?= esc($u['email']) ?></div>
                                    <?php if (!empty($u['phone'])): ?>
                                        <div class="text-muted small mt-0.5" style="font-size: 11.5px;"><i class="fa-solid fa-phone me-1"></i><?= esc($u['phone']) ?></div>
                                    <?php endif; ?>
                                </td>
                                <td style="padding:12px 14px; text-align:center;">
                                    <span class="badge <?= $roleClass ?> py-1 px-2.5 rounded text-nowrap" style="font-size: 0.72rem; letter-spacing: 0.2px;">
                                        <?= esc(ucfirst($u['role'])) ?>
                                    </span>
                                </td>
                                <td style="padding:12px 14px; color:var(--text-muted);">
                                    <?php if ($u['role'] === 'kabid'): ?>
                                        <div class="small text-white"><i class="fa-solid fa-building me-1 text-muted"></i><?= esc($u['nama_bidang'] ?? 'Belum Ditentukan') ?></div>
                                    <?php else: ?>
                                        <span class="small" style="font-style: italic; opacity: 0.5;">Akses Global / Publik</span>
                                    <?php endif; ?>
                                </td>
                                <td style="padding:12px 14px; text-align:center;">
                                    <div class="d-flex justify-content-center gap-2">
                                        <button type="button" class="btn btn-sm btn-outline-primary px-2.5 py-1.5 rounded btn-edit-user"
                                                data-id="<?= esc($u['id']) ?>"
                                                data-username="<?= esc($u['username']) ?>"
                                                data-email="<?= esc($u['email']) ?>"
                                                data-phone="<?= esc($u['phone'] ?? '') ?>"
                                                data-role="<?= esc($u['role']) ?>"
                                                data-bidang="<?= esc($u['bidang_id'] ?? '') ?>"
                                                title="Sunting Pengguna">
                                            <i class="fa-solid fa-pen-to-square"></i>
                                        </button>
                                        <?php if ($u['id'] !== session()->get('user_id')): ?>
                                            <form action="<?= base_url('admin/settings/users/delete/' . esc($u['id'])) ?>" method="POST" onsubmit="return confirm('Apakah Anda yakin ingin menghapus akun pengguna ini secara permanen?')" class="d-inline">
                                                <?= csrf_field() ?>
                                                <button type="submit" class="btn btn-sm btn-outline-danger px-2.5 py-1.5 rounded" title="Hapus Pengguna"><i class="fa-solid fa-trash-can"></i></button>
                                            </form>
                                        <?php else: ?>
                                            <button type="button" class="btn btn-sm btn-outline-secondary px-2.5 py-1.5 rounded" style="cursor: not-allowed; opacity: 0.4;" title="Akun Anda Sedang Aktif" disabled><i class="fa-solid fa-user-lock"></i></button>
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

<!-- Modal Tambah User -->
<div class="modal fade" id="modalTambahUser" tabindex="-1" aria-labelledby="modalTambahUserLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-lg">
        <div class="modal-content glass-card-modal animate-fade-in" style="background: var(--bg-color) !important; border: 1px solid var(--border-color) !important; color: var(--text-main) !important; border-radius: 16px;">
            <div class="modal-header border-secondary border-opacity-25" style="border-bottom: 1px solid var(--border-color) !important;">
                <h5 class="modal-title font-heading" id="modalTambahUserLabel"><i class="fa-solid fa-user-plus text-primary me-2"></i>Tambah Pengguna Baru</h5>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form action="<?= base_url('admin/settings/users/tambah') ?>" method="POST">
                <?= csrf_field() ?>
                <div class="modal-body">
                    <div class="row g-3 mb-3">
                        <div class="col-md-6">
                            <label for="add_username" class="form-label small text-muted">Username *</label>
                            <input type="text" name="username" id="add_username" class="form-control form-control-custom" placeholder="Contoh: kabid_poldagri" required autocomplete="off">
                        </div>
                        <div class="col-md-6">
                            <label for="add_email" class="form-label small text-muted">Alamat Email *</label>
                            <input type="email" name="email" id="add_email" class="form-control form-control-custom" placeholder="Contoh: poldagri@sinjaikab.go.id" required>
                        </div>
                        <div class="col-md-6">
                            <label for="add_password" class="form-label small text-muted">Kata Sandi (Password) *</label>
                            <input type="password" name="password" id="add_password" class="form-control form-control-custom" placeholder="Minimal 6 karakter" required autocomplete="new-password">
                        </div>
                        <div class="col-md-6">
                            <label for="add_phone" class="form-label small text-muted">Nomor Telepon / HP</label>
                            <input type="text" name="phone" id="add_phone" class="form-control form-control-custom" placeholder="Contoh: 08123456789">
                        </div>
                        <div class="col-md-6">
                            <label for="add_role" class="form-label small text-muted">Hak Akses / Role *</label>
                            <select name="role" id="add_role" class="form-select form-control-custom" required onchange="toggleBidangSelect(this, 'add_bidang_group')">
                                <option value="user" selected>User Biasa (Citizen / Publik)</option>
                                <option value="ormas">Akun Pengurus Ormas</option>
                                <option value="kabid">Kepala Bidang (Kabid)</option>
                                <option value="kaban">Kepala Badan (Kaban)</option>
                                <option value="admin">Administrator (Admin OPD)</option>
                            </select>
                        </div>
                        <div class="col-md-6" id="add_bidang_group" style="display: none;">
                            <label for="add_bidang" class="form-label small text-muted">Penempatan Bidang Kerja *</label>
                            <select name="bidang_id" id="add_bidang" class="form-select form-control-custom">
                                <option value="" selected disabled>-- Pilih Bidang Kerja --</option>
                                <?php foreach ($bidang as $b): ?>
                                    <option value="<?= esc($b['id']) ?>"><?= esc($b['nama_bidang']) ?></option>
                                <?php endforeach; ?>
                            </select>
                        </div>
                    </div>
                </div>
                <div class="modal-footer border-0">
                    <button type="button" class="btn btn-secondary text-white" data-bs-dismiss="modal">Batal</button>
                    <button type="submit" class="btn btn-warning fw-bold text-dark" style="background:#eab308; border:none; padding:8px 20px;"><i class="fa-solid fa-floppy-disk me-1"></i> Simpan Akun</button>
                </div>
            </form>
        </div>
    </div>
</div>

<!-- Modal Edit User -->
<div class="modal fade" id="modalEditUser" tabindex="-1" aria-labelledby="modalEditUserLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-lg">
        <div class="modal-content glass-card-modal animate-fade-in" style="background: var(--bg-color) !important; border: 1px solid var(--border-color) !important; color: var(--text-main) !important; border-radius: 16px;">
            <div class="modal-header border-secondary border-opacity-25" style="border-bottom: 1px solid var(--border-color) !important;">
                <h5 class="modal-title font-heading" id="modalEditUserLabel"><i class="fa-solid fa-user-pen text-primary me-2"></i>Sunting Akun Pengguna</h5>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form action="<?= base_url('admin/settings/users/update') ?>" method="POST">
                <?= csrf_field() ?>
                <input type="hidden" name="user_id" id="edit_user_id">
                <div class="modal-body">
                    <div class="row g-3 mb-3">
                        <div class="col-md-6">
                            <label for="edit_username" class="form-label small text-muted">Username *</label>
                            <input type="text" name="username" id="edit_username" class="form-control form-control-custom" required autocomplete="off">
                        </div>
                        <div class="col-md-6">
                            <label for="edit_email" class="form-label small text-muted">Alamat Email *</label>
                            <input type="email" name="email" id="edit_email" class="form-control form-control-custom" required>
                        </div>
                        <div class="col-md-6">
                            <label for="edit_password" class="form-label small text-muted">Ubah Kata Sandi (Password)</label>
                            <input type="password" name="password" id="edit_password" class="form-control form-control-custom" placeholder="Kosongkan jika tidak ingin diubah" autocomplete="new-password">
                        </div>
                        <div class="col-md-6">
                            <label for="edit_phone" class="form-label small text-muted">Nomor Telepon / HP</label>
                            <input type="text" name="phone" id="edit_phone" class="form-control form-control-custom">
                        </div>
                        <div class="col-md-6">
                            <label for="edit_role" class="form-label small text-muted">Hak Akses / Role *</label>
                            <select name="role" id="edit_role" class="form-select form-control-custom" required onchange="toggleBidangSelect(this, 'edit_bidang_group')">
                                <option value="user">User Biasa (Citizen / Publik)</option>
                                <option value="ormas">Akun Pengurus Ormas</option>
                                <option value="kabid">Kepala Bidang (Kabid)</option>
                                <option value="kaban">Kepala Badan (Kaban)</option>
                                <option value="admin">Administrator (Admin OPD)</option>
                            </select>
                        </div>
                        <div class="col-md-6" id="edit_bidang_group" style="display: none;">
                            <label for="edit_bidang" class="form-label small text-muted">Penempatan Bidang Kerja *</label>
                            <select name="bidang_id" id="edit_bidang" class="form-select form-control-custom">
                                <option value="" disabled>-- Pilih Bidang Kerja --</option>
                                <?php foreach ($bidang as $b): ?>
                                    <option value="<?= esc($b['id']) ?>"><?= esc($b['nama_bidang']) ?></option>
                                <?php endforeach; ?>
                            </select>
                        </div>
                    </div>
                </div>
                <div class="modal-footer border-0">
                    <button type="button" class="btn btn-secondary text-white" data-bs-dismiss="modal">Batal</button>
                    <button type="submit" class="btn btn-primary fw-bold text-white" style="padding:8px 20px;"><i class="fa-solid fa-floppy-disk me-1"></i> Simpan Perubahan</button>
                </div>
            </form>
        </div>
    </div>
</div>
<?= $this->endSection() ?>

<?= $this->section('scripts') ?>
<script>
    function toggleBidangSelect(roleSelect, groupElementId) {
        const groupEl = document.getElementById(groupElementId);
        const bidangSelect = groupEl.querySelector('select');
        
        if (roleSelect.value === 'kabid') {
            groupEl.style.display = 'block';
            bidangSelect.setAttribute('required', 'required');
        } else {
            groupEl.style.display = 'none';
            bidangSelect.removeAttribute('required');
            bidangSelect.value = '';
        }
    }

    document.addEventListener('DOMContentLoaded', () => {
        const editModal = new bootstrap.Modal(document.getElementById('modalEditUser'));

        // Sunting Pengguna Button click handler
        document.querySelectorAll('.btn-edit-user').forEach(btn => {
            btn.addEventListener('click', () => {
                const id = btn.getAttribute('data-id');
                const username = btn.getAttribute('data-username');
                const email = btn.getAttribute('data-email');
                const phone = btn.getAttribute('data-phone');
                const role = btn.getAttribute('data-role');
                const bidang = btn.getAttribute('data-bidang');

                document.getElementById('edit_user_id').value = id;
                document.getElementById('edit_username').value = username;
                document.getElementById('edit_email').value = email;
                document.getElementById('edit_phone').value = phone;
                document.getElementById('edit_role').value = role;
                document.getElementById('edit_password').value = '';

                // Handle Bidang select visibility
                const roleSelect = document.getElementById('edit_role');
                toggleBidangSelect(roleSelect, 'edit_bidang_group');

                if (role === 'kabid' && bidang) {
                    document.getElementById('edit_bidang').value = bidang;
                }

                editModal.show();
            });
        });
    });
</script>
<?= $this->endSection() ?>
