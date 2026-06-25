<?= $this->extend('layouts/main') ?>

<?= $this->section('styles') ?>
<style>
    .google-card {
        background: rgba(255, 255, 255, 0.95);
        border-radius: 12px;
        box-shadow: 0 4px 20px rgba(0, 0, 0, 0.15);
        color: #202124;
        padding: 40px;
        font-family: 'Roboto', 'Inter', sans-serif;
    }

    html[data-theme="dark"] .google-card {
        background: #1a1d24;
        border: 1px solid rgba(255,255,255,0.08);
        color: #e8eaed;
        box-shadow: 0 4px 30px rgba(0, 0, 0, 0.4);
    }

    .google-logo-box {
        display: flex;
        justify-content: center;
        align-items: center;
        gap: 15px;
        margin-bottom: 25px;
    }

    .google-logo-box img {
        height: 48px;
        object-fit: contain;
    }

    .account-item {
        display: flex;
        align-items: center;
        gap: 15px;
        padding: 12px 16px;
        border: 1px solid #dadce0;
        border-radius: 8px;
        cursor: pointer;
        transition: all 0.25s ease;
        margin-bottom: 12px;
        background: transparent;
    }

    html[data-theme="dark"] .account-item {
        border-color: rgba(255,255,255,0.15);
    }

    .account-item:hover {
        background: rgba(66, 133, 244, 0.04);
        border-color: #4285f4;
    }

    html[data-theme="dark"] .account-item:hover {
        background: rgba(139, 92, 246, 0.08);
        border-color: #a78bfa;
    }

    .account-avatar {
        width: 40px;
        height: 40px;
        border-radius: 50%;
        background: #4285f4;
        color: white;
        display: flex;
        align-items: center;
        justify-content: center;
        font-weight: bold;
        font-size: 1.2rem;
    }

    html[data-theme="dark"] .account-avatar {
        background: #8b5cf6;
    }

    .account-details {
        flex-grow: 1;
        text-align: left;
    }

    .account-name {
        font-weight: 600;
        font-size: 0.95rem;
        margin-bottom: 2px;
    }

    .account-email {
        font-size: 0.8rem;
        color: #5f6368;
    }

    html[data-theme="dark"] .account-email {
        color: #9ca3af;
    }
</style>
<?= $this->endSection() ?>

<?= $this->section('content') ?>
<div class="row justify-content-center align-items-center py-5">
    <div class="col-md-6 col-lg-5 col-xl-4">
        <div class="google-card text-center">
            <!-- Header Logos -->
            <div class="google-logo-box">
                <svg xmlns="http://www.w3.org/2000/svg" width="36" height="36" viewBox="0 0 48 48" class="flex-shrink-0">
                    <path fill="#EA4335" d="M24 9.5c3.54 0 6.71 1.22 9.21 3.6l6.85-6.85C35.9 2.38 30.47 0 24 0 14.62 0 6.51 5.38 2.56 13.22l7.98 6.19C12.43 13.72 17.74 9.5 24 9.5z"/>
                    <path fill="#4285F4" d="M46.5 24c0-1.55-.15-3.24-.47-4.75H24v9.03h12.75c-.53 2.87-2.14 5.31-4.59 6.96l7.15 5.54C43.5 36.27 46.5 30.73 46.5 24z"/>
                    <path fill="#FBBC05" d="M10.54 28.59c-.48-1.45-.76-2.99-.76-4.59s.27-3.14.76-4.59l-7.98-6.19C.92 16.46 0 20.12 0 24c0 3.88.92 7.54 2.56 10.78l7.98-6.19z"/>
                    <path fill="#34A853" d="M24 48c6.48 0 11.93-2.13 15.89-5.81l-7.15-5.54c-1.99 1.33-4.54 2.12-8.74 2.12-6.26 0-11.57-4.22-13.46-9.91l-7.98 6.19C6.51 42.62 14.62 48 24 48z"/>
                </svg>
                <span class="text-muted" style="font-size: 1.5rem;">×</span>
                <img src="<?= base_url('uploads/logo_kesbangpol.png') ?>" alt="Logo Kesbangpol" style="height: 38px;">
            </div>

            <h4 class="fw-bold mb-1">Login Simulator Google</h4>
            <p class="text-muted small mb-4">Pilih akun Google Anda untuk melanjutkan ke aplikasi SIPAKATAU</p>

            <form action="<?= base_url('auth/google/callback') ?>" method="POST" id="formGoogleCallback">
                <?= csrf_field() ?>
                <input type="hidden" name="is_simulation" value="1">
                <input type="hidden" name="email" id="submit_email">
                <input type="hidden" name="name" id="submit_name">

                <!-- Account List -->
                <div class="mb-4">
                    <!-- Account 1: User Memo -->
                    <div class="account-item" onclick="selectAccount('akhmadsultan011@gmail.com', 'A. Akhmad Sultan')">
                        <div class="account-avatar">A</div>
                        <div class="account-details">
                            <div class="account-name">A. Akhmad Sultan</div>
                            <div class="account-email">akhmadsultan011@gmail.com</div>
                        </div>
                    </div>

                    <!-- Account 2: Admin Demo -->
                    <div class="account-item" onclick="selectAccount('admin.kesbangpol@sinjaikab.go.id', 'Admin Kesbangpol')">
                        <div class="account-avatar">AD</div>
                        <div class="account-details">
                            <div class="account-name">Admin Kesbangpol</div>
                            <div class="account-email">admin.kesbangpol@sinjaikab.go.id</div>
                        </div>
                    </div>

                    <!-- Custom Account Trigger -->
                    <div class="account-item" id="btnCustomAccount" onclick="toggleCustomForm()">
                        <div class="account-avatar" style="background: #5f6368;"><i class="fa-solid fa-user-plus" style="font-size: 0.9rem;"></i></div>
                        <div class="account-details">
                            <div class="account-name" style="font-weight: 500;">Gunakan akun lain</div>
                            <div class="account-email">Masukkan email Google kustom Anda</div>
                        </div>
                    </div>
                </div>

                <!-- Custom Account Form (Hidden by default) -->
                <div id="customAccountForm" class="d-none border p-3 rounded mb-4 text-start" style="border-color: #dadce0 !important;">
                    <div class="mb-3">
                        <label for="custom_email" class="form-label small fw-bold">Alamat Email Google</label>
                        <input type="email" id="custom_email" class="form-control form-control-sm" placeholder="contoh@gmail.com">
                    </div>
                    <div class="mb-3">
                        <label for="custom_name" class="form-label small fw-bold">Nama Lengkap</label>
                        <input type="text" id="custom_name" class="form-control form-control-sm" placeholder="Nama Lengkap Anda">
                    </div>
                    <button type="button" class="btn btn-primary btn-sm w-100 fw-bold" onclick="submitCustomAccount()">Masuk dengan Akun Kustom</button>
                </div>
            </form>

            <div class="text-center border-top pt-3 mt-4">
                <a href="<?= base_url('login') ?>" class="small text-decoration-none text-muted"><i class="fa-solid fa-arrow-left me-1"></i> Kembali ke Login Utama</a>
            </div>
        </div>
    </div>
</div>
<?= $this->endSection() ?>

<?= $this->section('scripts') ?>
<script>
    function selectAccount(email, name) {
        document.getElementById('submit_email').value = email;
        document.getElementById('submit_name').value = name;
        document.getElementById('formGoogleCallback').submit();
    }

    function toggleCustomForm() {
        const form = document.getElementById('customAccountForm');
        form.classList.toggle('d-none');
        if (!form.classList.contains('d-none')) {
            document.getElementById('custom_email').focus();
        }
    }

    function submitCustomAccount() {
        const email = document.getElementById('custom_email').value.trim();
        const name = document.getElementById('custom_name').value.trim();
        
        if (!email || !name) {
            alert('Semua bidang kustom wajib diisi.');
            return;
        }

        if (!email.includes('@')) {
            alert('Alamat email kustom tidak valid.');
            return;
        }

        selectAccount(email, name);
    }
</script>
<?= $this->endSection() ?>
