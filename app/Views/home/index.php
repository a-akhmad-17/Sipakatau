<?= $this->extend('layouts/main') ?>

<?= $this->section('styles') ?>
<style>
    .hero-heading {
        background: linear-gradient(135deg, #ffffff 30%, #fca5a5 100%);
        -webkit-background-clip: text;
        -webkit-text-fill-color: transparent;
    }
    html[data-theme="light"] .hero-heading {
        background: linear-gradient(135deg, #0f172a 30%, #be123c 100%);
        -webkit-background-clip: text;
        -webkit-text-fill-color: transparent;
    }
    .glass-card-modal {
        background: var(--bg-color) !important;
        border: 1px solid var(--border-color) !important;
        color: var(--text-main) !important;
    }
    .list-download-item {
        background: var(--input-bg) !important;
        border: 1px solid var(--input-border) !important;
        color: var(--text-main) !important;
        transition: all 0.3s ease;
    }
    .list-download-item:hover {
        background: rgba(225, 29, 72, 0.05) !important;
        border-color: rgba(225, 29, 72, 0.3) !important;
    }
    html[data-theme="light"] .list-download-item i.fa-regular {
        color: #dc2626 !important; /* High contrast red for PDF icon in light theme */
    }
    
    /* Red/Crimson Divider Title */
    .divider-title {
        position: relative;
        text-align: center;
        margin: 50px 0 40px 0;
    }
    .divider-title h3 {
        display: inline-block;
        background: var(--bg-color);
        padding: 0 25px;
        position: relative;
        z-index: 2;
        color: #e11d48;
        font-weight: 800;
        letter-spacing: 1.5px;
        text-transform: uppercase;
        font-size: 1.25rem;
    }
    .divider-title::before {
        content: "";
        position: absolute;
        top: 50%;
        left: 0;
        width: 100%;
        height: 2px;
        background: #e11d48;
        z-index: 1;
    }

    /* Circle contact icons */
    .contact-circle {
        width: 60px;
        height: 60px;
        border-radius: 50%;
        background-color: #e11d48;
        color: #ffffff;
        display: flex;
        align-items: center;
        justify-content: center;
        margin: 0 auto 15px auto;
        font-size: 1.5rem;
        box-shadow: 0 4px 10px rgba(225, 29, 72, 0.2);
    }
    .social-brand-icon {
        font-size: 3.5rem;
        margin-bottom: 15px;
        transition: transform 0.2s ease;
    }
    .social-brand-icon:hover {
        transform: scale(1.1);
    }
    .wa-link {
        transition: all 0.2s ease;
    }
    .wa-link:hover {
        text-decoration: underline !important;
        opacity: 0.85;
    }
</style>
<?= $this->endSection() ?>

<?= $this->section('content') ?>

<!-- Hero Section -->
<div class="row align-items-center g-5 py-5 mb-5 position-relative">
    <!-- Background Decor -->
    <div style="position:absolute; width:150px; height:150px; background:radial-gradient(circle, rgba(245,158,11,0.1) 0%, rgba(0,0,0,0) 70%); top:10%; right:15%; z-index:-1; pointer-events:none;"></div>
    
    <div class="col-lg-7 text-center text-lg-start">
        <span class="badge badge-custom-primary px-3 py-2 rounded-pill mb-3 font-heading" style="font-weight:600; letter-spacing: 0.5px;">E-Government Portal Kabupaten Sinjai</span>
        <h1 class="display-4 fw-bold lh-sm mb-3 font-heading hero-heading">
            Layanan Kesbangpol Lebih Cepat, Akurat & Terpadu.
        </h1>
        <p class="lead text-muted mb-4" style="font-size: 1.1rem; line-height: 1.7;">
            Selamat datang di <b>SIPAKATAU</b>. Portal digital resmi Badan Kesatuan Bangsa dan Politik Kabupaten Sinjai untuk pendaftaran Ormas, rekomendasi kegiatan, antrean Mal Pelayanan Publik (MPP), serta pusat monitoring informasi daerah.
        </p>
        <div class="d-flex flex-column flex-sm-row gap-3 justify-content-center justify-content-lg-start">
            <a href="#layanan" class="btn btn-portal px-4 py-3 btn-lg">
                <i class="fa-solid fa-layer-group me-2"></i> Jelajahi Layanan
            </a>
            <a href="#informasi" class="btn btn-outline-secondary px-4 py-3 btn-lg text-white border-secondary hover-bg-light">
                <i class="fa-solid fa-circle-info me-2"></i> Pusat Informasi
            </a>
        </div>
    </div>
    <div class="col-lg-5 text-center">
        <!-- Interactive Graphic using CSS Glassmorphism -->
        <div class="glass-card p-4 mx-auto" style="max-width: 400px; transform: rotate(2deg); border-color: rgba(255,255,255,0.12);">
            <div class="d-flex justify-content-between align-items-center mb-4">
                <span class="text-white fw-bold"><i class="fa-solid fa-chart-line text-warning me-2"></i>Statistik Layanan</span>
                <span class="badge bg-success-subtle text-success border border-success-subtle">Aktif</span>
            </div>
            <div class="d-flex flex-column gap-3">
                <div class="d-flex align-items-center p-3 rounded" style="background: rgba(255,255,255,0.03); border: 1px solid var(--border-color);">
                    <div class="d-flex align-items-center gap-3">
                        <div class="rounded-circle p-2 bg-primary-subtle text-primary" style="width: 40px; height: 40px; display: flex; align-items: center; justify-content: center;">
                            <i class="fa-solid fa-users"></i>
                        </div>
                        <div class="text-start">
                            <div class="small text-muted">Ormas Terdaftar</div>
                            <div class="fw-bold"><?= number_format($totalOrmas) ?> Ormas</div>
                        </div>
                    </div>
                </div>
                
                <div class="d-flex align-items-center p-3 rounded" style="background: rgba(255,255,255,0.03); border: 1px solid var(--border-color);">
                    <div class="d-flex align-items-center gap-3">
                        <div class="rounded-circle p-2 bg-warning-subtle text-warning" style="width: 40px; height: 40px; display: flex; align-items: center; justify-content: center;">
                            <i class="fa-solid fa-file-signature"></i>
                        </div>
                        <div class="text-start">
                            <div class="small text-muted">Rekomendasi Terbit</div>
                            <div class="fw-bold"><?= number_format($totalRekomendasi) ?> Berkas</div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Tracking Section -->
<div class="row mb-5 justify-content-center">
    <div class="col-lg-8">
        <div class="glass-card p-4 text-center" style="border-color: rgba(225, 29, 72, 0.2);">
            <h4 class="text-white mb-2"><i class="fa-solid fa-magnifying-glass-location text-primary me-2"></i>Lacak Status Berkas Anda</h4>
            <p class="text-muted small mb-4">Masukkan nomor registrasi pendaftaran Anda (contoh: REG-2026-001) untuk mengetahui status verifikasi berkas secara real-time.</p>
            <form action="<?= site_url('layanan/lacak') ?>" method="GET">
                <div class="input-group">
                    <input type="text" name="nomor" class="form-control form-control-custom py-3 px-4" placeholder="Masukkan Nomor Registrasi..." required>
                    <button class="btn btn-portal px-4" type="submit">
                        <i class="fa-solid fa-search me-2"></i> Lacak Berkas
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>

<!-- Services Grid Section -->
<div id="layanan" class="py-5 border-top border-secondary-subtle">
    <div class="text-center mb-5">
        <h2 class="display-6 fw-bold mb-2">Portal Pelayanan Publik</h2>
        <p class="text-muted mx-auto" style="max-width: 600px;">Pilih jenis layanan Kesbangpol online di bawah ini untuk mengajukan berkas secara praktis dari mana saja.</p>
    </div>
    
    <div class="row g-4">
        <!-- Service 1: Pendaftaran Ormas -->
        <div class="col-md-6 col-lg-4">
            <div class="glass-card h-100 d-flex flex-column justify-content-between">
                <div>
                    <div class="mb-4 text-primary" style="font-size: 2.5rem;">
                        <i class="fa-solid fa-address-book"></i>
                    </div>
                    <h4 class="text-white mb-2">Pendaftaran Ormas</h4>
                    <p class="text-muted small mb-4">Pengajuan registrasi Organisasi Kemasyarakatan lokal dengan 12 dokumen persyaratan utama. Dilengkapi fitur <b>Save as Draft</b> dan unduh format formulir kosong.</p>
                </div>
                <div class="d-grid gap-2">
                    <a href="<?= site_url('layanan/ormas') ?>" class="btn btn-outline-primary py-2 text-white border-primary hover-bg-primary">
                        <i class="fa-solid fa-file-pen me-2"></i> Mulai Daftar
                    </a>
                    <a href="#" class="btn btn-link text-muted small text-decoration-none" data-bs-toggle="modal" data-bs-target="#modalUnduhFormat">
                        <i class="fa-solid fa-download me-2"></i> Unduh Format Dokumen
                    </a>
                </div>
            </div>
        </div>

        <!-- Service 2: Rekomendasi Kegiatan -->
        <div class="col-md-6 col-lg-4">
            <div class="glass-card h-100 d-flex flex-column justify-content-between">
                <div>
                    <div class="mb-4 text-warning" style="font-size: 2.5rem;">
                        <i class="fa-solid fa-file-shield"></i>
                    </div>
                    <h4 class="text-white mb-2">Rekomendasi Kegiatan</h4>
                    <p class="text-muted small mb-4">Pengajuan surat rekomendasi izin pelaksanaan kegiatan kemasyarakatan / penelitian. Melibatkan Dispora, Dispenda, dan dinas teknis terkait.</p>
                </div>
                <div class="d-grid">
                    <a href="<?= site_url('layanan/rekomendasi') ?>" class="btn btn-outline-warning py-2 text-white border-warning hover-bg-warning">
                        <i class="fa-solid fa-circle-arrow-right me-2"></i> Ajukan Izin
                    </a>
                </div>
            </div>
        </div>

        <!-- Service 3: Antrean MPP -->
        <div class="col-md-6 col-lg-4">
            <div class="glass-card h-100 d-flex flex-column justify-content-between">
                <div>
                    <div class="mb-4 text-info" style="font-size: 2.5rem;">
                        <i class="fa-solid fa-ticket"></i>
                    </div>
                    <h4 class="text-white mb-2">Sistem Antrean MPP</h4>
                    <p class="text-muted small mb-4">Pengambilan nomor antrean loket pelayanan Kesbangpol di Mal Pelayanan Publik (MPP) Kabupaten Sinjai secara real-time dari rumah.</p>
                </div>
                <div class="d-grid">
                    <a href="#" class="btn btn-outline-info py-2 text-white border-info hover-bg-info" data-bs-toggle="modal" data-bs-target="#modalAntrean">
                        <i class="fa-solid fa-ticket-simple me-2"></i> Ambil Antrean
                    </a>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Info & Education Section -->
<div id="informasi" class="py-5 border-top border-secondary-subtle">
    <div class="row g-5 align-items-center">
        <div class="col-lg-6">
            <h2 class="display-6 fw-bold text-white mb-4">Pusat Informasi & Edukasi Wawasan Kebangsaan</h2>
            <p class="text-muted mb-4">Kami berkomitmen menumbuhkan rasa persatuan, kebangsaan, dan cinta tanah air. Tonton video edukasi kebangsaan resmi di bawah ini, atau ikuti terus agenda dan berita Kesbangpol Kabupaten Sinjai.</p>
            
            <div class="d-flex flex-column gap-3 mb-4">
                <div class="d-flex gap-3 align-items-start">
                    <div class="p-2 rounded bg-primary-subtle text-primary mt-1">
                        <i class="fa-solid fa-play"></i>
                    </div>
                    <div>
                        <h5 class="text-white mb-1">Edukasi Wawasan Kebangsaan</h5>
                        <p class="text-muted small">Materi digital penanaman nilai Pancasila dan UUD 1945 bagi pemuda.</p>
                    </div>
                </div>
                <div class="d-flex gap-3 align-items-start">
                    <div class="p-2 rounded bg-warning-subtle text-warning mt-1">
                        <i class="fa-solid fa-newspaper"></i>
                    </div>
                    <div>
                        <h5 class="text-white mb-1">Berita & Agenda Kesbangpol</h5>
                        <p class="text-muted small">Update berkala mengenai program pembinaan ormas dan forum diskusi kerukunan.</p>
                    </div>
                </div>
            </div>
            
            <a href="#" class="btn btn-outline-secondary text-white border-secondary hover-bg-light px-4 py-2" data-bs-toggle="modal" data-bs-target="#modalPengaduan">
                <i class="fa-solid fa-bullhorn me-2 text-danger"></i> Portal Pengaduan Masyarakat
            </a>
        </div>
        <div class="col-lg-6">
            <!-- Video Player Glassmorphic Card -->
            <div class="glass-card p-2" style="background: rgba(0,0,0,0.4); border-color: rgba(255,255,255,0.06);">
                <?php if (!empty($firstVideo)): ?>
                    <div class="ratio ratio-16x9 rounded overflow-hidden position-relative bg-dark" 
                         style="cursor: pointer; background: url('https://img.youtube.com/vi/<?= esc($firstVideo['youtube_id']) ?>/hqdefault.jpg') no-repeat center; background-size: cover;"
                         data-bs-toggle="modal" 
                         data-bs-target="#videoPlayerModal" 
                         data-video-id="<?= esc($firstVideo['youtube_id']) ?>" 
                         data-video-title="<?= esc($firstVideo['title']) ?>">
                        <div class="position-absolute w-100 h-100 d-flex flex-column align-items-center justify-content-center text-center p-4" style="background: linear-gradient(rgba(0,0,0,0.2), rgba(0,0,0,0.75)); transition: background 0.3s;" onmouseover="this.style.background='linear-gradient(rgba(0,0,0,0.1), rgba(0,0,0,0.65))'" onmouseout="this.style.background='linear-gradient(rgba(0,0,0,0.2), rgba(0,0,0,0.75))'">
                            <div class="rounded-circle bg-white text-dark d-flex align-items-center justify-content-center shadow-lg" style="width: 70px; height: 70px; transition: transform 0.2s;" onmouseover="this.style.transform='scale(1.1)'" onmouseout="this.style.transform='scale(1.0)'">
                                <i class="fa-solid fa-play fa-2x ms-1 text-danger"></i>
                            </div>
                            <h5 class="text-white mt-4 mb-1" style="font-weight: 700;"><?= esc($firstVideo['title']) ?></h5>
                            <p class="small text-muted mb-0">Durasi: <?= esc($firstVideo['duration']) ?> • Sumber: <?= esc($firstVideo['source']) ?></p>
                        </div>
                    </div>
                <?php else: ?>
                    <div class="ratio ratio-16x9 rounded-3 overflow-hidden position-relative" style="background: #1f2937;">
                        <div class="position-absolute w-100 h-100 d-flex flex-column align-items-center justify-content-center text-center p-4" style="background: linear-gradient(rgba(0,0,0,0.3), rgba(0,0,0,0.8));">
                            <i class="fa-solid fa-video-slash fa-3x text-muted mb-3"></i>
                            <h5 class="text-white mb-1">Belum Ada Video Edukasi</h5>
                            <p class="small text-muted">Hubungi administrator untuk mengunggah video.</p>
                        </div>
                    </div>
                <?php endif; ?>
            </div>
        </div>
    </div>
</div>

<!-- Section Kontak Kami -->
<div class="divider-title">
    <h3>Kontak Kami</h3>
</div>
<div class="row g-4 text-center mb-5">
    <div class="col-md-4">
        <div class="contact-circle">
            <i class="fa-solid fa-location-dot"></i>
        </div>
        <h5 class="text-white fw-bold mb-2">ALAMAT</h5>
        <p class="text-muted small">Jl. Sinjai - Watampone, Biringere, Sinjai, Kabupaten Sinjai, Sulawesi Selatan 92600</p>
    </div>
    <div class="col-md-4">
        <div class="contact-circle">
            <i class="fa-solid fa-envelope"></i>
        </div>
        <h5 class="text-white fw-bold mb-2">EMAIL RESMI</h5>
        <p class="text-muted small">kesbangpol@sinjaikab.go.id</p>
    </div>
    <div class="col-md-4">
        <div class="contact-circle">
            <i class="fa-solid fa-phone"></i>
        </div>
        <h5 class="text-white fw-bold mb-2">HUBUNGI</h5>
        <p class="text-muted small">WhatsApp (Chat Only): 
            <a href="https://wa.me/628117671545?text=Halo%20Kesbangpol%20Sinjai,%20saya%20ingin%20bertanya%20mengenai%20layanan%20SIPAKATAU." target="_blank" class="text-success fw-bold text-decoration-none wa-link">
                0811-7671-545 <i class="fa-brands fa-whatsapp ms-1"></i>
            </a>
        </p>
    </div>
</div>

<!-- Section Sosial Media -->
<div class="divider-title">
    <h3>Sosial Media</h3>
</div>
<div class="row g-4 text-center mb-5">
    <div class="col-6 col-md-3">
        <a href="https://facebook.com" target="_blank" class="text-decoration-none">
            <i class="fa-brands fa-facebook social-brand-icon" style="color: #1877f2;"></i>
            <h6 class="text-white fw-semibold">FACEBOOK</h6>
        </a>
    </div>
    <div class="col-6 col-md-3">
        <a href="https://twitter.com" target="_blank" class="text-decoration-none">
            <i class="fa-brands fa-twitter social-brand-icon" style="color: #1da1f2;"></i>
            <h6 class="text-white fw-semibold">TWITTER</h6>
        </a>
    </div>
    <div class="col-6 col-md-3">
        <a href="https://instagram.com" target="_blank" class="text-decoration-none">
            <i class="fa-brands fa-instagram social-brand-icon" style="color: #c13584;"></i>
            <h6 class="text-white fw-semibold">INSTAGRAM</h6>
        </a>
    </div>
    <div class="col-6 col-md-3">
        <a href="https://youtube.com" target="_blank" class="text-decoration-none">
            <i class="fa-brands fa-youtube social-brand-icon" style="color: #ff0000;"></i>
            <h6 class="text-white fw-semibold">YOUTUBE</h6>
        </a>
    </div>
</div>

<!-- MODALS -->

<!-- Modal Pendaftaran Ormas -->
<div class="modal fade" id="modalOrmas" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-lg">
        <div class="modal-content glass-card-modal">
            <div class="modal-header border-secondary">
                <h5 class="modal-title font-heading"><i class="fa-solid fa-address-book text-primary me-2"></i>Pendaftaran Ormas Digital</h5>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <div class="alert alert-info bg-primary-subtle border-primary-subtle text-primary-light d-flex align-items-center gap-3 mb-4" role="alert">
                    <i class="fa-solid fa-circle-info fa-lg"></i>
                    <div>
                        <strong>Fitur Save as Draft Aktif!</strong> Progres formulir kamu akan disimpan otomatis sebagai draf saat kamu mengisi data.
                    </div>
                </div>
                
                <form id="formOrmas" onsubmit="event.preventDefault(); alert('Simulasi Pendaftaran Ormas Tersimpan!');">
                    <!-- Progress Bar -->
                    <div class="mb-4">
                        <div class="d-flex justify-content-between mb-1 small">
                            <span>Progres Pengisian Formulir</span>
                            <span class="fw-bold" id="progressText">15%</span>
                        </div>
                        <div class="progress" style="height: 8px; background: #1e293b;">
                            <div class="progress-bar bg-primary" id="progressBar" role="progressbar" style="width: 15%;" aria-valuenow="15" aria-valuemin="0" aria-valuemax="100"></div>
                        </div>
                    </div>
                    
                    <div class="row g-3">
                        <div class="col-md-6">
                            <label class="form-label small text-muted">Nama Organisasi (Ormas)</label>
                            <input type="text" class="form-control form-control-custom" placeholder="Masukkan nama resmi Ormas" required oninput="updateProgress(30)">
                        </div>
                        <div class="col-md-6">
                            <label class="form-label small text-muted">Email Organisasi</label>
                            <input type="email" class="form-control form-control-custom" placeholder="ormas@email.com" required oninput="updateProgress(45)">
                        </div>
                        <div class="col-md-6">
                            <label class="form-label small text-muted">Nama Ketua Pengurus</label>
                            <input type="text" class="form-control form-control-custom" placeholder="Ketua Umum" required oninput="updateProgress(60)">
                        </div>
                        <div class="col-md-6">
                            <label class="form-label small text-muted">Nomor Telepon Sekretariat</label>
                            <input type="text" class="form-control form-control-custom" placeholder="0812xxxxx" required oninput="updateProgress(75)">
                        </div>
                        <div class="col-12">
                            <label class="form-label small text-muted">Alamat Sekretariat</label>
                            <textarea class="form-control form-control-custom" rows="2" placeholder="Alamat lengkap kantor sekretariat" required oninput="updateProgress(90)"></textarea>
                        </div>
                        <div class="col-12">
                            <label class="form-label small text-muted">Unggah File Persyaratan (Gabungan Dokumen / ZIP - Maks 12 Dokumen)</label>
                            <input type="file" class="form-control form-control-custom" onchange="updateProgress(100)">
                            <div class="form-text text-secondary small">Unggah dokumen persyaratan yang sudah diisi lengkap.</div>
                        </div>
                    </div>
                    
                    <div class="mt-4 d-flex justify-content-end gap-2">
                        <button type="button" class="btn btn-secondary text-white" data-bs-dismiss="modal">Tutup</button>
                        <button type="button" class="btn btn-outline-warning text-white border-warning" onclick="alert('Draf disimpan otomatis!')"><i class="fa-solid fa-floppy-disk me-2"></i>Simpan Draft</button>
                        <button type="submit" class="btn btn-portal"><i class="fa-solid fa-paper-plane me-2"></i>Kirim Formulir</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

<!-- Modal Unduh Format Dokumen -->
<div class="modal fade" id="modalUnduhFormat" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content glass-card-modal">
            <div class="modal-header border-secondary">
                <h5 class="modal-title font-heading"><i class="fa-solid fa-download text-primary me-2"></i>Unduh Format Dokumen Kosong</h5>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <p class="text-muted small">Silakan unduh template berkas persyaratan dan panduan resmi dari Kesbangpol Kabupaten Sinjai di bawah ini:</p>
                <div class="d-flex flex-column gap-2">
                    <a href="https://drive.google.com/uc?export=download&id=1XqCYdQYp87AXN4RGMvJqJKslvA05nRNR" target="_blank" class="p-3 rounded list-download-item text-decoration-none d-flex align-items-center justify-content-between">
                        <span class="small"><i class="fa-regular fa-file-word text-primary me-3"></i>Persyaratan & Lampiran Ormas Lokal (.docx)</span>
                        <i class="fa-solid fa-download text-muted"></i>
                    </a>
                    <a href="https://drive.google.com/uc?export=download&id=1UX2CJCfXpWZUix7o-j3jY9cld63dX7KS" target="_blank" class="p-3 rounded list-download-item text-decoration-none d-flex align-items-center justify-content-between">
                        <span class="small"><i class="fa-regular fa-file-word text-primary me-3"></i>Persyaratan & Lampiran Ormas Berjenjang (.docx)</span>
                        <i class="fa-solid fa-download text-muted"></i>
                    </a>
                    <a href="https://drive.google.com/uc?export=download&id=1WsgeJzVebDi-eGE9B7uYifcAiW05hxgW" target="_blank" class="p-3 rounded list-download-item text-decoration-none d-flex align-items-center justify-content-between">
                        <span class="small"><i class="fa-regular fa-file-word text-primary me-3"></i>Persyaratan Rekomendasi Kegiatan (.docx)</span>
                        <i class="fa-solid fa-download text-muted"></i>
                    </a>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Modal Rekomendasi Kegiatan -->
<div class="modal fade" id="modalRekomendasi" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content glass-card-modal">
            <div class="modal-header border-secondary">
                <h5 class="modal-title font-heading"><i class="fa-solid fa-file-shield text-warning me-2"></i>Pengajuan Izin Rekomendasi</h5>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form onsubmit="event.preventDefault(); alert('Rekomendasi kegiatan berhasil dikirim untuk verifikasi!');">
                    <div class="mb-3">
                        <label class="form-label small text-muted">Nama Pemohon / Organisasi</label>
                        <input type="text" class="form-control form-control-custom" required>
                    </div>
                    <div class="mb-3">
                        <label class="form-label small text-muted">Nama / Tema Kegiatan</label>
                        <input type="text" class="form-control form-control-custom" required>
                    </div>
                    <div class="row g-2 mb-3">
                        <div class="col-6">
                            <label class="form-label small text-muted">Tanggal Mulai</label>
                            <input type="date" class="form-control form-control-custom" required>
                        </div>
                        <div class="col-6">
                            <label class="form-label small text-muted">Tanggal Selesai</label>
                            <input type="date" class="form-control form-control-custom" required>
                        </div>
                    </div>
                    <div class="mb-3">
                        <label class="form-label small text-muted">Unggah File Persyaratan (Kombinasi PDF proposal & izin dinas teknis)</label>
                        <input type="file" class="form-control form-control-custom" required>
                    </div>
                    <div class="d-flex justify-content-end gap-2 mt-4">
                        <button type="button" class="btn btn-secondary text-white" data-bs-dismiss="modal">Tutup</button>
                        <button type="submit" class="btn btn-warning text-white"><i class="fa-solid fa-paper-plane me-2"></i>Kirim Permohonan</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

<!-- Modal Antrean MPP -->
<div class="modal fade" id="modalAntrean" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content glass-card-modal">
            <div class="modal-header border-secondary">
                <h5 class="modal-title font-heading"><i class="fa-solid fa-ticket text-info me-2"></i>Ambil Antrean Loket Kesbangpol</h5>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close" onclick="resetAntreanForm()"></button>
            </div>
            <div class="modal-body py-4">
                <!-- Form Container -->
                <div id="antrean-form-container">
                    <p class="text-muted small mb-4 text-center">Masukkan identitas Anda untuk mendapatkan nomor antrean Loket Kesbangpol di Mal Pelayanan Publik Kabupaten Sinjai.</p>
                    <form id="formAmbilAntrean">
                        <?= csrf_field() ?>
                        <div class="mb-3">
                            <label for="antrean_nama" class="form-label small text-muted">Nama Pengambil *</label>
                            <input type="text" class="form-control form-control-custom py-2.5" id="antrean_nama" name="nama_pengambil" placeholder="Nama Lengkap Anda" required>
                        </div>
                        <div class="mb-3">
                            <label for="antrean_nik" class="form-label small text-muted">NIK (16 Digit) *</label>
                            <input type="text" class="form-control form-control-custom py-2.5" id="antrean_nik" name="nik" placeholder="7307xxxxxxxxxxxx" pattern="\d{16}" title="NIK harus berupa 16 digit angka" required>
                        </div>
                        <div class="mb-4">
                            <label for="antrean_layanan" class="form-label small text-muted">Layanan yang Dituju *</label>
                            <select class="form-select form-control-custom py-2.5" id="antrean_layanan" name="layanan" required>
                                <option value="" disabled selected>Pilih Layanan...</option>
                                <option value="ormas">Pendaftaran Ormas / LSM</option>
                                <option value="rekomendasi">Rekomendasi Izin Kegiatan</option>
                                <option value="konsultasi">Konsultasi / Umum</option>
                            </select>
                        </div>
                        <button type="submit" class="btn btn-info text-white w-100 py-2.5 fw-semibold">
                            <i class="fa-solid fa-ticket-simple me-2"></i> Dapatkan Nomor Antrean
                        </button>
                    </form>
                </div>

                <!-- Ticket Container (Hidden by default) -->
                <div id="antrean-ticket-container" class="d-none">
                    <div id="print-ticket-area" class="p-4 rounded border border-secondary border-opacity-50 text-center" style="background: rgba(255,255,255,0.02); font-family: monospace;">
                        <h6 class="text-white fw-bold mb-1" style="font-size: 0.85rem; letter-spacing: 0.5px;">PEMERINTAH KABUPATEN SINJAI</h6>
                        <h6 class="text-info fw-bold mb-3" style="font-size: 0.85rem; letter-spacing: 0.5px; text-transform: uppercase;">Badan Kesatuan Bangsa dan Politik</h6>
                        <hr class="border-secondary border-opacity-50 my-2">
                        <div class="small text-muted mb-2">TIKET ANTREAN DIGITAL</div>
                        <div id="ticket-number" class="display-3 fw-bold text-white mb-2" style="font-family: 'Outfit', sans-serif;">-</div>
                        <div id="ticket-service" class="badge bg-info-subtle text-info border border-info-subtle px-3 py-1 rounded-pill mb-3" style="font-size: 0.75rem;">-</div>
                        
                        <div class="text-start border-top border-secondary border-opacity-25 pt-3 small text-muted" style="font-size: 0.8rem; line-height: 1.6;">
                            <div class="d-flex justify-content-between"><span>Nama:</span> <strong class="text-white" id="ticket-nama">-</strong></div>
                            <div class="d-flex justify-content-between"><span>NIK:</span> <strong class="text-white" id="ticket-nik">-</strong></div>
                            <div class="d-flex justify-content-between"><span>Tanggal:</span> <strong class="text-white" id="ticket-date">-</strong></div>
                        </div>
                        
                        <hr class="border-secondary border-opacity-50 my-3">
                        <div class="d-flex justify-content-center mb-2">
                            <svg id="ticket-qr" viewBox="0 0 100 100" xmlns="http://www.w3.org/2000/svg" style="width: 70px; height: 70px;">
                                <rect x="5" y="5" width="90" height="90" fill="none" stroke="#fff" stroke-width="3"/>
                                <rect x="12" y="12" width="24" height="24" fill="#fff"/>
                                <rect x="16" y="16" width="16" height="16" fill="#000"/>
                                <rect x="20" y="20" width="8" height="8" fill="#fff"/>
                                <rect x="64" y="12" width="24" height="24" fill="#fff"/>
                                <rect x="68" y="16" width="16" height="16" fill="#000"/>
                                <rect x="72" y="20" width="8" height="8" fill="#fff"/>
                                <rect x="12" y="64" width="24" height="24" fill="#fff"/>
                                <rect x="16" y="68" width="16" height="16" fill="#000"/>
                                <rect x="20" y="72" width="8" height="8" fill="#fff"/>
                                <rect x="42" y="42" width="12" height="12" fill="#fff"/>
                                <rect x="72" y="72" width="12" height="12" fill="#fff"/>
                            </svg>
                        </div>
                        <div class="text-secondary" style="font-size:0.7rem; line-height: 1.4;">Harap tunjukkan tiket ini di Loket MPP Kesbangpol Sinjai.</div>
                    </div>
                    
                    <div class="mt-4 d-flex gap-2">
                        <button type="button" class="btn btn-secondary flex-grow-1 text-white" onclick="resetAntreanForm()">Ambil Baru</button>
                        <button type="button" class="btn btn-info flex-grow-1 text-white" onclick="printTicket()">
                            <i class="fa-solid fa-print me-2"></i> Cetak Tiket
                        </button>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Modal Pengaduan -->
<div class="modal fade" id="modalPengaduan" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-lg">
        <div class="modal-content glass-card-modal">
            <div class="modal-header border-secondary">
                <h5 class="modal-title font-heading"><i class="fa-solid fa-bullhorn text-danger me-2"></i>Portal Pengaduan Masyarakat</h5>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <div class="alert alert-warning bg-warning-subtle border-warning-subtle text-warning d-flex align-items-center gap-3 mb-4" role="alert">
                    <i class="fa-solid fa-user-shield fa-lg"></i>
                    <div>
                        <strong>Laporan Anda Rahasia & Aman!</strong> Identitas Anda tidak akan disebarkan. Sistem ini dienkripsi demi keamanan pelapor.
                    </div>
                </div>

                <form action="<?= base_url('informasi/pengaduan') ?>" method="POST" enctype="multipart/form-data">
                    <?= csrf_field() ?>
                    
                    <div class="mb-3">
                        <label for="modal_judul" class="form-label small text-muted">Judul Pengaduan / Topik Laporan *</label>
                        <input type="text" class="form-control form-control-custom" id="modal_judul" name="judul" placeholder="Contoh: Indikasi Keberadaan Organisasi Tanpa Izin" required>
                    </div>

                    <div class="mb-3">
                        <label for="modal_kategori" class="form-label small text-muted">Kategori Aduan *</label>
                        <select class="form-select form-control-custom" id="modal_kategori" name="kategori" required>
                            <option value="" disabled selected>Pilih Kategori...</option>
                            <option value="konflik">Potensi Konflik Sosial SARA</option>
                            <option value="ormas">Pelanggaran/Ketertiban Ormas & LSM</option>
                            <option value="politik">Pelanggaran Kampanye / Politik Praktis</option>
                            <option value="layanan">Keluhan Pelayanan Kesbangpol</option>
                            <option value="lainnya">Lainnya</option>
                        </select>
                    </div>

                    <div class="mb-3">
                        <label for="modal_bidang_id" class="form-label small text-muted">Ditujukan ke Bidang (Opsional)</label>
                        <select class="form-select form-control-custom" id="modal_bidang_id" name="bidang_id">
                            <option value="" selected>Umum / Seluruhnya (Bukan Bidang Khusus)</option>
                            <?php if (!empty($bidang)): ?>
                                <?php foreach ($bidang as $b): ?>
                                    <option value="<?= esc($b['id']) ?>"><?= esc($b['nama_bidang']) ?></option>
                                <?php endforeach; ?>
                            <?php endif; ?>
                        </select>
                    </div>

                    <div class="mb-3">
                        <label for="modal_deskripsi" class="form-label small text-muted">Deskripsi Detail Aduan *</label>
                        <textarea class="form-control form-control-custom" id="modal_deskripsi" name="deskripsi" rows="5" placeholder="Jelaskan secara kronologis, lengkap dengan waktu dan tempat kejadian..." required></textarea>
                    </div>

                    <div class="mb-4">
                        <label for="modal_berkas" class="form-label small text-muted">Unggah Bukti Pendukung (Opsional)</label>
                        <input type="file" class="form-control form-control-custom" id="modal_berkas" name="berkas">
                        <div class="form-text text-secondary small">Format: PDF/JPG/PNG. Maksimal 2MB.</div>
                    </div>

                    <div class="d-flex justify-content-end gap-2 mt-4">
                        <button type="button" class="btn btn-secondary text-white" data-bs-dismiss="modal">Tutup</button>
                        <button type="submit" class="btn btn-danger text-white"><i class="fa-solid fa-paper-plane me-2"></i>Kirim Pengaduan</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

<!-- Video Player Modal -->
<div class="modal fade" id="videoPlayerModal" tabindex="-1" aria-labelledby="videoPlayerModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-lg">
        <div class="modal-content glass-card-modal">
            <div class="modal-header border-secondary border-opacity-25" style="border-bottom: 1px solid var(--border-color) !important; padding: 15px 20px;">
                <h5 class="modal-title font-heading text-white fw-bold" id="videoPlayerModalLabel"><i class="fa-solid fa-circle-play text-danger me-2"></i>Putar Video Edukasi</h5>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body p-0">
                <div class="ratio ratio-16x9">
                    <iframe id="videoIframe" src="" title="YouTube video player" frameborder="0" allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture; web-share" allowfullscreen></iframe>
                </div>
            </div>
        </div>
    </div>
</div>

<?= $this->endSection() ?>

<?= $this->section('scripts') ?>
<script>
    function updateProgress(value) {
        document.getElementById('progressBar').style.width = value + '%';
        document.getElementById('progressText').innerText = value + '%';
    }

    // Client-side file size validation for homepage complaint modal
    const modalBerkas = document.getElementById('modal_berkas');
    if (modalBerkas) {
        modalBerkas.addEventListener('change', function() {
            if (this.files && this.files[0]) {
                const file = this.files[0];
                const maxSize = 2 * 1024 * 1024; // 2MB
                if (file.size > maxSize) {
                    if (window.showToast) {
                        window.showToast('Ukuran bukti pendukung melebihi batas maksimum 2MB! Silakan pilih file yang lebih kecil.', 'danger');
                    } else {
                        alert('Ukuran bukti pendukung melebihi batas maksimum 2MB! Silakan pilih file yang lebih kecil.');
                    }
                    this.value = ''; // Reset input
                }
            }
        });
    }

    // Video Player Modal handler
    document.addEventListener('DOMContentLoaded', function () {
        const videoPlayerModal = document.getElementById('videoPlayerModal');
        if (videoPlayerModal) {
            const videoIframe = document.getElementById('videoIframe');
            const modalTitle = document.getElementById('videoPlayerModalLabel');

            videoPlayerModal.addEventListener('show.bs.modal', function (event) {
                const button = event.relatedTarget;
                const videoId = button.getAttribute('data-video-id');
                const videoTitle = button.getAttribute('data-video-title');

                modalTitle.innerHTML = `<i class="fa-solid fa-circle-play text-danger me-2"></i>${videoTitle}`;
                videoIframe.src = `https://www.youtube.com/embed/${videoId}?autoplay=1`;
            });

            videoPlayerModal.addEventListener('hide.bs.modal', function () {
                videoIframe.src = '';
            });
        }

        // AJAX Queue Submit handler
        const formAntrean = document.getElementById('formAmbilAntrean');
        if (formAntrean) {
            formAntrean.addEventListener('submit', function(e) {
                e.preventDefault();
                const formData = new FormData(formAntrean);
                
                fetch('<?= site_url('layanan/ambil-antrean') ?>', {
                    method: 'POST',
                    body: formData,
                    headers: {
                        'X-Requested-With': 'XMLHttpRequest'
                    }
                })
                .then(response => response.json())
                .then(res => {
                    if (res.status) {
                        const ticket = res.data;
                        document.getElementById('ticket-number').innerText = ticket.nomor_antrean;
                        
                        let svcName = 'Konsultasi / Umum';
                        if (ticket.layanan === 'ormas') svcName = 'Pendaftaran Ormas';
                        else if (ticket.layanan === 'rekomendasi') svcName = 'Rekomendasi Kegiatan';
                        
                        document.getElementById('ticket-service').innerText = svcName;
                        document.getElementById('ticket-nama').innerText = ticket.nama_pengambil;
                        document.getElementById('ticket-nik').innerText = ticket.nik;
                        
                        // Format date
                        const d = new Date(ticket.tanggal);
                        const options = { day: 'numeric', month: 'long', year: 'numeric' };
                        document.getElementById('ticket-date').innerText = d.toLocaleDateString('id-ID', options);
                        
                        // Show ticket, hide form
                        document.getElementById('antrean-form-container').classList.add('d-none');
                        document.getElementById('antrean-ticket-container').classList.remove('d-none');
                        
                        if (window.showToast) {
                            window.showToast(res.message, 'success');
                        }
                    } else {
                        if (window.showToast) {
                            window.showToast(res.message, 'danger');
                        } else {
                            alert(res.message);
                        }
                    }
                })
                .catch(err => {
                    console.error(err);
                    if (window.showToast) {
                        window.showToast('Gagal memproses nomor antrean.', 'danger');
                    }
                });
            });
        }
    });

    function resetAntreanForm() {
        const form = document.getElementById('formAmbilAntrean');
        if (form) form.reset();
        document.getElementById('antrean-form-container').classList.remove('d-none');
        document.getElementById('antrean-ticket-container').classList.add('d-none');
    }

    // Printer-friendly ticket print function via iframe
    function printTicket() {
        const printContent = document.getElementById('print-ticket-area').innerHTML;
        const printFrame = document.createElement('iframe');
        printFrame.name = 'printFrame';
        printFrame.style.position = 'absolute';
        printFrame.style.top = '-1000px';
        document.body.appendChild(printFrame);
        
        const frameDoc = printFrame.contentWindow ? printFrame.contentWindow : printFrame.contentDocument.document ? printFrame.contentDocument.document : printFrame.contentDocument;
        frameDoc.document.open();
        frameDoc.document.write(`
            <html>
            <head>
                <title>Cetak Tiket Antrean</title>
                <style>
                    body {
                        font-family: monospace;
                        text-align: center;
                        padding: 30px;
                        background: #ffffff;
                        color: #000000;
                    }
                    h6 { margin: 5px 0; font-size: 10pt; font-weight: bold; }
                    hr { border-top: 1px dashed #000; margin: 15px 0; }
                    .display-3 { font-size: 28pt; font-weight: bold; margin: 15px 0; }
                    .badge { border: 1px solid #000; padding: 4px 10px; border-radius: 12px; font-weight: bold; font-size: 9pt; }
                    .text-start { text-align: left; margin: 15px 0; font-size: 9pt; }
                    .d-flex { display: flex; justify-content: space-between; }
                    svg { width: 80px; height: 80px; margin: 15px auto; display: block; }
                    svg rect { fill: #000000 !important; }
                    svg rect[fill="none"] { fill: none !important; stroke: #000000 !important; }
                    svg rect[fill="#fff"] { fill: #ffffff !important; }
                </style>
            </head>
            <body onload="window.print(); setTimeout(() => { window.close(); }, 500);">
                ${printContent}
            </body>
            </html>
        `);
        frameDoc.document.close();
        
        setTimeout(() => {
            document.body.removeChild(printFrame);
        }, 1500);
    }
</script>
<?= $this->endSection() ?>
