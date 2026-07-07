<?= $this->extend('layouts/main') ?>

<?= $this->section('content') ?>
<div class="row justify-content-center align-items-center py-5">
    <div class="col-md-6 col-lg-5 col-xl-4">
        <!-- Register Glass Card -->
        <div class="glass-card p-4 border border-secondary-subtle">
            <div class="text-center mb-4">
                <div class="d-inline-flex align-items-center justify-content-center mb-3" style="width: 80px; height: 80px;">
                    <img src="<?= base_url('uploads/logo_kesbangpol.png') ?>" alt="Logo Bakesbangpol Sinjai" style="width: 100%; height: 100%; object-fit: contain;">
                </div>
                <h3 class="text-white fw-bold mb-1">Daftar Akun</h3>
                <p class="text-muted small">Registrasi Akun Layanan Ormas Mandiri SIPAKATAU</p>
            </div>

            <!-- Flashdata Alerts & Validation Errors -->
            <?php if (session()->getFlashdata('error')): ?>
                <div class="alert alert-danger bg-danger-subtle border-danger-subtle text-danger small p-3 rounded mb-3" role="alert">
                    <i class="fa-solid fa-circle-exclamation me-2"></i><?= session()->getFlashdata('error') ?>
                </div>
            <?php endif; ?>

            <?php if (session()->getFlashdata('errors')): ?>
                <div class="alert alert-danger bg-danger-subtle border-danger-subtle text-danger small p-3 rounded mb-3" role="alert">
                    <i class="fa-solid fa-circle-exclamation me-2"></i><b>Terjadi kesalahan:</b>
                    <ul class="mb-0 mt-1 ps-3">
                        <?php foreach (session()->getFlashdata('errors') as $error): ?>
                            <li><?= esc($error) ?></li>
                        <?php endforeach; ?>
                    </ul>
                </div>
            <?php endif; ?>

            <form action="<?= base_url('register') ?>" method="POST">
                <?= csrf_field() ?>

                <div class="mb-3">
                    <label for="username" class="form-label small text-muted">Nama Pengguna (Username) <span class="text-danger">*</span></label>
                    <div class="input-group">
                        <span class="input-group-text input-group-text-custom"><i class="fa-solid fa-user"></i></span>
                        <input type="text" name="username" id="username" class="form-control form-control-custom" placeholder="Pilih username unik" value="<?= old('username') ?>" required>
                    </div>
                </div>

                <div class="mb-3">
                    <label for="email" class="form-label small text-muted">Email <span class="text-danger">*</span></label>
                    <div class="input-group">
                        <span class="input-group-text input-group-text-custom"><i class="fa-solid fa-envelope"></i></span>
                        <input type="email" name="email" id="email" class="form-control form-control-custom" placeholder="alamat@email.com" value="<?= old('email') ?>" required>
                    </div>
                </div>

                <div class="mb-3">
                    <label for="phone" class="form-label small text-muted">Nomor Telepon / WhatsApp <span class="text-danger">*</span></label>
                    <div class="input-group">
                        <span class="input-group-text input-group-text-custom"><i class="fa-solid fa-phone"></i></span>
                        <input type="text" name="phone" id="phone" class="form-control form-control-custom" placeholder="Contoh: 08123456789" value="<?= old('phone') ?>" required>
                    </div>
                </div>

                <div class="mb-3">
                    <label for="password" class="form-label small text-muted">Kata Sandi (Password) <span class="text-danger">*</span></label>
                    <div class="input-group">
                        <span class="input-group-text input-group-text-custom"><i class="fa-solid fa-lock"></i></span>
                        <input type="password" name="password" id="password" class="form-control form-control-custom" style="border-top-right-radius: 0; border-bottom-right-radius: 0; border-right: none;" placeholder="Minimal 6 karakter" required>
                        <button class="btn btn-toggle-pwd" type="button" data-target="password" style="border: 1px solid var(--border-color); border-left: none; background: rgba(255, 255, 255, 0.05); color: var(--text-muted); border-top-right-radius: 8px; border-bottom-right-radius: 8px; transition: all 0.3s ease;" onmouseover="this.style.color='var(--text-main)'; this.style.background='rgba(255, 255, 255, 0.1)'" onmouseout="this.style.color='var(--text-muted)'; this.style.background='rgba(255, 255, 255, 0.05)'">
                            <i class="fa-solid fa-eye eye-icon"></i>
                        </button>
                    </div>
                </div>

                <div class="mb-4">
                    <label for="password_confirm" class="form-label small text-muted">Konfirmasi Kata Sandi <span class="text-danger">*</span></label>
                    <div class="input-group">
                        <span class="input-group-text input-group-text-custom"><i class="fa-solid fa-circle-check"></i></span>
                        <input type="password" name="password_confirm" id="password_confirm" class="form-control form-control-custom" style="border-top-right-radius: 0; border-bottom-right-radius: 0; border-right: none;" placeholder="Ulangi password" required>
                        <button class="btn btn-toggle-pwd" type="button" data-target="password_confirm" style="border: 1px solid var(--border-color); border-left: none; background: rgba(255, 255, 255, 0.05); color: var(--text-muted); border-top-right-radius: 8px; border-bottom-right-radius: 8px; transition: all 0.3s ease;" onmouseover="this.style.color='var(--text-main)'; this.style.background='rgba(255, 255, 255, 0.1)'" onmouseout="this.style.color='var(--text-muted)'; this.style.background='rgba(255, 255, 255, 0.05)'">
                            <i class="fa-solid fa-eye eye-icon"></i>
                        </button>
                    </div>
                </div>

                <div class="d-grid mb-3">
                    <button type="submit" class="btn btn-portal py-2.5 fw-bold text-white">
                        <i class="fa-solid fa-user-plus me-2"></i> Daftar Sekarang
                    </button>
                </div>
            </form>

            <div class="text-center pt-2 mb-2">
                <span class="small" style="color: var(--text-main); opacity: 0.85;">Sudah punya akun? <a href="<?= base_url('login') ?>" class="text-info text-decoration-underline fw-bold">Masuk di sini</a></span>
            </div>
        </div>
    </div>
</div>
<?= $this->endSection() ?>

<?= $this->section('scripts') ?>
<script>
document.addEventListener('DOMContentLoaded', () => {
    const toggleButtons = document.querySelectorAll('.btn-toggle-pwd');
    toggleButtons.forEach(btn => {
        btn.addEventListener('click', function() {
            const targetId = this.getAttribute('data-target');
            const input = document.getElementById(targetId);
            const icon = this.querySelector('.eye-icon');
            
            if (input && icon) {
                const isPassword = input.getAttribute('type') === 'password';
                input.setAttribute('type', isPassword ? 'text' : 'password');
                
                if (isPassword) {
                    icon.classList.remove('fa-eye');
                    icon.classList.add('fa-eye-slash');
                } else {
                    icon.classList.remove('fa-eye-slash');
                    icon.classList.add('fa-eye');
                }
            }
        });
    });
});
</script>
<?= $this->endSection() ?>
