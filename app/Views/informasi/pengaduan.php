<?= $this->extend('layouts/main') ?>

<?= $this->section('content') ?>

<div class="py-4" style="max-width: 800px; margin: 0 auto;">
    <!-- Header -->
    <div class="glass-card mb-5 text-center">
        <h1 class="display-5 fw-bold text-white mb-2"><i class="fa-solid fa-bullhorn text-danger me-2"></i>Portal Pengaduan</h1>
        <p class="text-muted mb-0">Laporkan kendala, konflik sosial, ormas mencurigakan, atau pelanggaran di wilayah Kabupaten Sinjai secara anonim dan aman.</p>
    </div>

    <!-- Form Pengaduan -->
    <div class="glass-card">
        <div class="alert alert-warning bg-warning-subtle border-warning-subtle text-warning d-flex align-items-center gap-3 mb-4" role="alert">
            <i class="fa-solid fa-user-shield fa-lg"></i>
            <div>
                <strong>Laporan Anda Rahasia & Aman!</strong> Identitas Anda tidak akan disebarkan. Sistem ini dienkripsi demi keamanan pelapor.
            </div>
        </div>

        <form action="<?= base_url('informasi/pengaduan') ?>" method="POST" enctype="multipart/form-data">
            <?= csrf_field() ?>
            
            <div class="mb-3">
                <label for="judul" class="form-label small text-muted">Judul Pengaduan / Topik Laporan *</label>
                <input type="text" class="form-control form-control-custom" id="judul" name="judul" placeholder="Contoh: Indikasi Keberadaan Organisasi Tanpa Izin" required>
            </div>

            <div class="mb-3">
                <label for="kategori" class="form-label small text-muted">Kategori Aduan *</label>
                <select class="form-select form-control-custom" id="kategori" name="kategori" required>
                    <option value="" disabled selected>Pilih Kategori...</option>
                    <option value="konflik">Potensi Konflik Sosial SARA</option>
                    <option value="ormas">Pelanggaran/Ketertiban Ormas & LSM</option>
                    <option value="politik">Pelanggaran Kampanye / Politik Praktis</option>
                    <option value="layanan">Keluhan Pelayanan Kesbangpol</option>
                    <option value="lainnya">Lainnya</option>
                </select>
            </div>

            <div class="mb-3">
                <label for="bidang_id" class="form-label small text-muted">Ditujukan ke Bidang (Opsional)</label>
                <select class="form-select form-control-custom" id="bidang_id" name="bidang_id">
                    <option value="" selected>Umum / Seluruhnya (Bukan Bidang Khusus)</option>
                    <?php foreach ($bidang as $b): ?>
                        <option value="<?= esc($b['id']) ?>"><?= esc($b['nama_bidang']) ?></option>
                    <?php endforeach; ?>
                </select>
            </div>

            <div class="mb-3">
                <label for="deskripsi" class="form-label small text-muted">Deskripsi Detail Aduan *</label>
                <textarea class="form-control form-control-custom" id="deskripsi" name="deskripsi" rows="5" placeholder="Jelaskan secara kronologis, lengkap dengan waktu dan tempat kejadian..." required></textarea>
            </div>

            <div class="mb-4">
                <label for="berkas" class="form-label small text-muted">Unggah Bukti Pendukung (Opsional)</label>
                <input type="file" class="form-control form-control-custom" id="berkas" name="berkas">
                <div class="form-text text-secondary small">Format: PDF/JPG/PNG. Maksimal 2MB.</div>
            </div>

            <div class="d-grid">
                <button type="submit" class="btn btn-portal py-3">
                    <i class="fa-solid fa-paper-plane me-2"></i> Kirim Laporan Pengaduan
                </button>
            </div>
        </form>
    </div>
</div>

<?= $this->endSection() ?>

<?= $this->section('scripts') ?>
<script>
    document.getElementById('berkas').addEventListener('change', function() {
        if (this.files && this.files[0]) {
            const file = this.files[0];
            const maxSize = 2 * 1024 * 1024; // 2MB
            if (file.size > maxSize) {
                alert('Ukuran bukti pendukung melebihi batas maksimum 2MB! Silakan pilih file yang lebih kecil.');
                this.value = ''; // Reset input
            }
        }
    });
</script>
<?= $this->endSection() ?>
