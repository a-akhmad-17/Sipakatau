<?= $this->extend('layouts/main') ?>

<?= $this->section('content') ?>

<div class="py-4">
    <!-- Header -->
    <div class="glass-card mb-5 text-center">
        <h1 class="display-5 fw-bold text-white mb-2">Informasi Rekomendasi Kegiatan</h1>
        <p class="text-muted mb-0">Alur tata cara, persyaratan berkas, dan berkas format pengajuan Surat Rekomendasi Kegiatan di Badan Kesbangpol Kabupaten Sinjai.</p>
    </div>

    <!-- Alur Rekomendasi -->
    <div class="glass-card mb-4">
        <h3 class="text-white mb-4"><i class="fa-solid fa-route text-primary me-2"></i>Alur Pelayanan Penerbitan Rekomendasi</h3>
        <div class="row g-4 text-center">
            <div class="col-md-2.4 col-sm-6 flex-grow-1">
                <div class="p-3 border rounded h-100" style="border-color: var(--border-color) !important; background: rgba(255,255,255,0.01);">
                    <div class="rounded-circle bg-primary-subtle text-primary d-inline-flex align-items-center justify-content-center mb-3" style="width: 45px; height: 45px;">
                        <strong>1</strong>
                    </div>
                    <h6 class="text-white mb-2">Permohonan</h6>
                    <p class="text-muted small mb-0" style="font-size: 0.78rem;">Pemohon menyerahkan seluruh berkas persyaratan fisik/digital ke petugas.</p>
                </div>
            </div>
            <div class="col-md-2.4 col-sm-6 flex-grow-1">
                <div class="p-3 border rounded h-100" style="border-color: var(--border-color) !important; background: rgba(255,255,255,0.01);">
                    <div class="rounded-circle bg-warning-subtle text-warning d-inline-flex align-items-center justify-content-center mb-3" style="width: 45px; height: 45px;">
                        <strong>2</strong>
                    </div>
                    <h6 class="text-white mb-2">Verifikasi</h6>
                    <p class="text-muted small mb-0" style="font-size: 0.78rem;">Petugas memverifikasi kelengkapan berkas yang diserahkan.</p>
                </div>
            </div>
            <div class="col-md-2.4 col-sm-6 flex-grow-1">
                <div class="p-3 border rounded h-100" style="border-color: var(--border-color) !important; background: rgba(255,255,255,0.01);">
                    <div class="rounded-circle bg-info-subtle text-info d-inline-flex align-items-center justify-content-center mb-3" style="width: 45px; height: 45px;">
                        <strong>3</strong>
                    </div>
                    <h6 class="text-white mb-2">Waktu Layanan</h6>
                    <p class="text-muted small mb-0" style="font-size: 0.78rem;">Waktu pemrosesan yang dibutuhkan petugas sangat cepat, hanya **± 30 Menit** saja.</p>
                </div>
            </div>
            <div class="col-md-2.4 col-sm-6 flex-grow-1">
                <div class="p-3 border rounded h-100" style="border-color: var(--border-color) !important; background: rgba(255,255,255,0.01);">
                    <div class="rounded-circle bg-danger-subtle text-danger d-inline-flex align-items-center justify-content-center mb-3" style="width: 45px; height: 45px;">
                        <strong>4</strong>
                    </div>
                    <h6 class="text-white mb-2">Penerbitan TTE</h6>
                    <p class="text-muted small mb-0" style="font-size: 0.78rem;">Rekomendasi diterbitkan secara elektronik melalui aplikasi **SRIKANDI** (atau manual jika server bermasalah).</p>
                </div>
            </div>
            <div class="col-md-2.4 col-sm-6 flex-grow-1">
                <div class="p-3 border rounded h-100" style="border-color: var(--border-color) !important; background: rgba(255,255,255,0.01);">
                    <div class="rounded-circle bg-success-subtle text-success d-inline-flex align-items-center justify-content-center mb-3" style="width: 45px; height: 45px;">
                        <strong>5</strong>
                    </div>
                    <h6 class="text-white mb-2">Monitoring</h6>
                    <p class="text-muted small mb-0" style="font-size: 0.78rem;">Kesbangpol melakukan pemantauan dan monitoring pasca-penertiban rekomendasi.</p>
                </div>
            </div>
        </div>
    </div>

    <!-- Persyaratan Dokumen -->
    <div class="glass-card">
        <div class="d-flex justify-content-between align-items-center mb-4 flex-wrap gap-3">
            <h3 class="text-white mb-0"><i class="fa-solid fa-list-check text-warning me-2"></i>Persyaratan Rekomendasi Kegiatan (6 Berkas Utama)</h3>
        </div>
        <div class="row g-3">
            <div class="col-md-6">
                <ul class="list-group list-group-flush" style="background: transparent;">
                    <li class="list-group-item bg-transparent text-muted border-secondary-subtle px-0"><i class="fa-solid fa-square-check text-success me-2"></i>1. Surat Permohonan Rekomendasi Kegiatan ditujukan kepada Kepala Badan Kesbangpol Kab. Sinjai</li>
                    <li class="list-group-item bg-transparent text-muted border-secondary-subtle px-0"><i class="fa-solid fa-square-check text-success me-2"></i>2. Surat Rekomendasi Kegiatan dari Kantor Lurah setempat dan diketahui Camat</li>
                    <li class="list-group-item bg-transparent text-muted border-secondary-subtle px-0"><i class="fa-solid fa-square-check text-success me-2"></i>3. Proposal Kegiatan lengkap (berisi latar belakang, rencana acara, sasaran, dll.)</li>
                </ul>
            </div>
            <div class="col-md-6">
                <ul class="list-group list-group-flush" style="background: transparent;">
                    <li class="list-group-item bg-transparent text-muted border-secondary-subtle px-0"><i class="fa-solid fa-square-check text-success me-2"></i>4. Fotokopi KTP Ketua Panitia Pelaksana</li>
                    <li class="list-group-item bg-transparent text-muted border-secondary-subtle px-0"><i class="fa-solid fa-square-check text-success me-2"></i>5. Surat Keputusan (SK) Pengurus Kegiatan</li>
                    <li class="list-group-item bg-transparent text-muted border-secondary-subtle px-0"><i class="fa-solid fa-square-check text-success me-2"></i>6. Surat Rekomendasi pendukung dari Stakeholder terkait</li>
                </ul>
            </div>
        </div>
    </div>
</div>

<?= $this->endSection() ?>
