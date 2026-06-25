<?= $this->extend('layouts/main') ?>

<?= $this->section('content') ?>
<div class="row justify-content-center align-items-center py-5">
    <div class="col-md-6 col-lg-5 col-xl-4">
        <!-- Login Glass Card -->
        <div class="glass-card p-4 border border-secondary-subtle">
            <div class="text-center mb-4">
                <div class="d-inline-flex align-items-center justify-content-center mb-3" style="width: 80px; height: 80px;">
                    <img src="<?= base_url('uploads/logo_kesbangpol.png') ?>" alt="Logo Bakesbangpol Sinjai" style="width: 100%; height: 100%; object-fit: contain;">
                </div>
                <h3 class="text-white fw-bold mb-1">Masuk Sistem</h3>
                <p class="text-muted small">Akses Dashboard OPD & Kinerja SIPAKATAU</p>
            </div>

            <!-- Flashdata Alerts -->
            <?php if (session()->getFlashdata('error')): ?>
                <div class="alert alert-danger bg-danger-subtle border-danger-subtle text-danger small p-3 rounded mb-3" role="alert">
                    <i class="fa-solid fa-circle-exclamation me-2"></i><?= session()->getFlashdata('error') ?>
                </div>
            <?php endif; ?>

            <?php if (session()->getFlashdata('success')): ?>
                <div class="alert alert-success bg-success-subtle border-success-subtle text-success small p-3 rounded mb-3" role="alert">
                    <i class="fa-solid fa-circle-check me-2"></i><?= session()->getFlashdata('success') ?>
                </div>
            <?php endif; ?>

            <!-- Google Login Button -->
            <div class="mb-4">
                <a href="<?= base_url('auth/google') ?>" class="btn w-100 d-flex align-items-center justify-content-center gap-2 py-2.5 fw-bold" style="background: rgba(255, 255, 255, 0.06); border: 1px solid var(--border-color); color: var(--text-main); border-radius: 8px; font-size: 0.9rem; transition: all 0.3s ease;" onmouseover="this.style.background='rgba(255, 255, 255, 0.12)'" onmouseout="this.style.background='rgba(255, 255, 255, 0.06)'">
                    <svg xmlns="http://www.w3.org/2000/svg" width="18" height="18" viewBox="0 0 48 48">
                        <path fill="#EA4335" d="M24 9.5c3.54 0 6.71 1.22 9.21 3.6l6.85-6.85C35.9 2.38 30.47 0 24 0 14.62 0 6.51 5.38 2.56 13.22l7.98 6.19C12.43 13.72 17.74 9.5 24 9.5z"/>
                        <path fill="#4285F4" d="M46.5 24c0-1.55-.15-3.24-.47-4.75H24v9.03h12.75c-.53 2.87-2.14 5.31-4.59 6.96l7.15 5.54C43.5 36.27 46.5 30.73 46.5 24z"/>
                        <path fill="#FBBC05" d="M10.54 28.59c-.48-1.45-.76-2.99-.76-4.59s.27-3.14.76-4.59l-7.98-6.19C.92 16.46 0 20.12 0 24c0 3.88.92 7.54 2.56 10.78l7.98-6.19z"/>
                        <path fill="#34A853" d="M24 48c6.48 0 11.93-2.13 15.89-5.81l-7.15-5.54c-1.99 1.33-4.54 2.12-8.74 2.12-6.26 0-11.57-4.22-13.46-9.91l-7.98 6.19C6.51 42.62 14.62 48 24 48z"/>
                    </svg>
                    Masuk dengan Google
                </a>
            </div>

            <!-- Separator -->
            <div class="d-flex align-items-center mb-4">
                <hr class="flex-grow-1" style="border-color: var(--border-color) !important; opacity: 0.15;">
                <span class="px-3 small" style="color: var(--text-muted); font-size: 0.78rem;">atau masuk dengan nama pengguna</span>
                <hr class="flex-grow-1" style="border-color: var(--border-color) !important; opacity: 0.15;">
            </div>

            <form action="<?= base_url('login') ?>" method="POST">
                <?= csrf_field() ?>

                <div class="mb-3">
                    <label for="username" class="form-label small text-muted">Nama Pengguna (Username)</label>
                    <div class="input-group">
                        <span class="input-group-text input-group-text-custom"><i class="fa-solid fa-user"></i></span>
                        <input type="text" name="username" id="username" class="form-control form-control-custom" placeholder="Masukkan username" value="<?= old('username') ?>" required>
                    </div>
                </div>

                <div class="mb-4">
                    <div class="d-flex justify-content-between align-items-center mb-1">
                        <label for="password" class="form-label small text-muted mb-0">Kata Sandi (Password)</label>
                        <a href="#" class="small text-primary text-decoration-none" onclick="alert('Silakan hubungi admin Diskominfo Sinjai untuk mereset kata sandi.')">Lupa sandi?</a>
                    </div>
                    <div class="input-group">
                        <span class="input-group-text input-group-text-custom"><i class="fa-solid fa-lock"></i></span>
                        <input type="password" name="password" id="password" class="form-control form-control-custom" style="border-top-right-radius: 0; border-bottom-right-radius: 0; border-right: none;" placeholder="Masukkan password" required>
                        <button class="btn" type="button" id="toggle-password" style="border: 1px solid var(--border-color); border-left: none; background: rgba(255, 255, 255, 0.05); color: var(--text-muted); border-top-right-radius: 8px; border-bottom-right-radius: 8px; transition: all 0.3s ease;" onmouseover="this.style.color='var(--text-main)'; this.style.background='rgba(255, 255, 255, 0.1)'" onmouseout="this.style.color='var(--text-muted)'; this.style.background='rgba(255, 255, 255, 0.05)'">
                            <i class="fa-solid fa-eye" id="toggle-password-icon"></i>
                        </button>
                    </div>
                </div>

                <div class="d-grid mb-3">
                    <button type="submit" class="btn btn-portal py-2.5 fw-bold">
                        <i class="fa-solid fa-right-to-bracket me-2"></i> Masuk Sekarang
                    </button>
                </div>
            </form>

            <div class="text-center pt-2 mb-2">
                <span class="small" style="color: var(--text-main); opacity: 0.85;">Belum punya akun? <a href="<?= base_url('register') ?>" class="text-info text-decoration-underline fw-bold">Daftar di sini</a></span>
            </div>
        </div>
    </div>
</div>
<?= $this->endSection() ?>

<?= $this->section('scripts') ?>
<script>
document.addEventListener('DOMContentLoaded', () => {
    const togglePasswordBtn = document.getElementById('toggle-password');
    const passwordInput = document.getElementById('password');
    const togglePasswordIcon = document.getElementById('toggle-password-icon');

    if (togglePasswordBtn && passwordInput && togglePasswordIcon) {
        togglePasswordBtn.addEventListener('click', () => {
            const isPassword = passwordInput.getAttribute('type') === 'password';
            passwordInput.setAttribute('type', isPassword ? 'text' : 'password');
            
            if (isPassword) {
                togglePasswordIcon.classList.remove('fa-eye');
                togglePasswordIcon.classList.add('fa-eye-slash');
            } else {
                togglePasswordIcon.classList.remove('fa-eye-slash');
                togglePasswordIcon.classList.add('fa-eye');
            }
        });
    }
});
</script>
<?= $this->endSection() ?>
