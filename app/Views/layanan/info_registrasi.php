<?= $this->extend('layouts/main') ?>

<?= $this->section('content') ?>

<div class="py-4">
    <!-- Header -->
    <div class="glass-card mb-5 text-center">
        <h1 class="display-5 fw-bold text-white mb-2">Informasi Registrasi Ormas/LSM</h1>
        <p class="text-muted mb-0">Alur tata cara, persyaratan dokumen, dan berkas format pendaftaran resmi untuk Organisasi Kemasyarakatan di Kabupaten Sinjai.</p>
    </div>

    <!-- Bootstrap Nav Tabs for Ormas Type -->
    <ul class="nav nav-pills nav-fill mb-4 p-2 rounded" style="background: rgba(255, 255, 255, 0.03); border: 1px solid var(--border-color);" id="ormasTab" role="tablist">
        <li class="nav-item" role="presentation">
            <button class="nav-link active fw-bold py-3" id="lokal-tab" data-bs-toggle="tab" data-bs-target="#lokal" type="button" role="tab" aria-controls="lokal" aria-selected="true">
                <i class="fa-solid fa-house-user me-2"></i>Ormas Lokal (Penerbitan Laporan Tanggapan Keberadaan)
            </button>
        </li>
        <li class="nav-item" role="presentation">
            <button class="nav-link fw-bold py-3" id="berjenjang-tab" data-bs-toggle="tab" data-bs-target="#berjenjang" type="button" role="tab" aria-controls="berjenjang" aria-selected="false">
                <i class="fa-solid fa-network-wired me-2"></i>Ormas Berjenjang (Surat Keberadaan)
            </button>
        </li>
    </ul>

    <!-- Tab Content -->
    <div class="tab-content" id="ormasTabContent">
        <!-- Tab 1: Ormas Lokal -->
        <div class="tab-pane fade show active" id="lokal" role="tabpanel" aria-labelledby="lokal-tab">
            <!-- Alur Registrasi -->
            <div class="glass-card mb-4">
                <h3 class="text-white mb-4"><i class="fa-solid fa-route text-primary me-2"></i>Alur Pendaftaran (3 Langkah Mudah)</h3>
                <div class="row g-4 text-center">
                    <div class="col-md-4">
                        <div class="p-3 border rounded h-100" style="border-color: var(--border-color) !important; background: rgba(255,255,255,0.01);">
                            <div class="rounded-circle bg-primary-subtle text-primary d-inline-flex align-items-center justify-content-center mb-3" style="width: 50px; height: 50px;">
                                <strong>1</strong>
                            </div>
                            <h5 class="text-white mb-2">Isi Data & Unggah Berkas</h5>
                            <p class="text-muted small mb-0">Lengkapi formulir online di halaman layanan ormas, isi alamat, kontak, dan unggah berkas persyaratan yang digabungkan.</p>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="p-3 border rounded h-100" style="border-color: var(--border-color) !important; background: rgba(255,255,255,0.01);">
                            <div class="rounded-circle bg-warning-subtle text-warning d-inline-flex align-items-center justify-content-center mb-3" style="width: 50px; height: 50px;">
                                <strong>2</strong>
                            </div>
                            <h5 class="text-white mb-2">Verifikasi Administrasi</h5>
                            <p class="text-muted small mb-0">Staf/Operator Kesbangpol akan memvalidasi keselarasan berkas. Status verifikasi dapat dipantau di kolom pelacak berkas.</p>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="p-3 border rounded h-100" style="border-color: var(--border-color) !important; background: rgba(255,255,255,0.01);">
                            <div class="rounded-circle bg-success-subtle text-success d-inline-flex align-items-center justify-content-center mb-3" style="width: 50px; height: 50px;">
                                <strong>3</strong>
                            </div>
                            <h5 class="text-white mb-2">Laporan Tanggapan Keberadaan</h5>
                            <p class="text-muted small mb-0">Surat Laporan Tanggapan Keberadaan resmi berformat PDF ber-TTE diterbitkan dan dikirim secara digital kepada pemohon.</p>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Persyaratan Dokumen -->
            <div class="glass-card mb-4">
                <div class="d-flex justify-content-between align-items-center mb-4 flex-wrap gap-3">
                    <h3 class="text-white mb-0"><i class="fa-solid fa-list-check text-warning me-2"></i>Daftar Berkas Persyaratan Ormas Lokal</h3>
                </div>
                <div class="row g-3">
                    <div class="col-md-6">
                        <ul class="list-group list-group-flush" style="background: transparent;">
                            <li class="list-group-item bg-transparent text-muted border-secondary-subtle px-0"><i class="fa-solid fa-square-check text-success me-2"></i>1. Surat Permohonan ditujukan kepada Menteri (Cq. Kaban Kesbangpol)</li>
                            <li class="list-group-item bg-transparent text-muted border-secondary-subtle px-0"><i class="fa-solid fa-square-check text-success me-2"></i>2. Anggaran Dasar (AD) & Anggaran Rumah Tangga (ART) - *PDF satu file*</li>
                            <li class="list-group-item bg-transparent text-muted border-secondary-subtle px-0"><i class="fa-solid fa-square-check text-success me-2"></i>3. Akta Pendirian Notaris memuat (Nama, Lambang, Asas, Tujuan, Pengurus, Hak, Keuangan, dll.)</li>
                            <li class="list-group-item bg-transparent text-muted border-secondary-subtle px-0"><i class="fa-solid fa-square-check text-success me-2"></i>4. Surat Pernyataan Keabsahan Dokumen (Meterai Rp 10.000)</li>
                            <li class="list-group-item bg-transparent text-muted border-secondary-subtle px-0"><i class="fa-solid fa-square-check text-success me-2"></i>5. Program Kerja Organisasi</li>
                            <li class="list-group-item bg-transparent text-muted border-secondary-subtle px-0"><i class="fa-solid fa-square-check text-success me-2"></i>6. Struktur Organisasi Resmi</li>
                            <li class="list-group-item bg-transparent text-muted border-secondary-subtle px-0"><i class="fa-solid fa-square-check text-success me-2"></i>7. Surat Keterangan Domisili Kantor Sekretariat</li>
                            <li class="list-group-item bg-transparent text-muted border-secondary-subtle px-0"><i class="fa-solid fa-square-check text-success me-2"></i>8. NPWP atas nama Organisasi</li>
                            <li class="list-group-item bg-transparent text-muted border-secondary-subtle px-0"><i class="fa-solid fa-square-check text-success me-2"></i>9. Formulir Isian Data Ormas (ditandatangani Ketua & Sekretaris)</li>
                            <li class="list-group-item bg-transparent text-muted border-secondary-subtle px-0"><i class="fa-solid fa-square-check text-success me-2"></i>10. Surat Rekomendasi Kementerian Agama (Ormas Agama) / Kebudayaan</li>
                        </ul>
                    </div>
                    <div class="col-md-6">
                        <ul class="list-group list-group-flush" style="background: transparent;">
                            <li class="list-group-item bg-transparent text-muted border-secondary-subtle px-0"><i class="fa-solid fa-square-check text-success me-2"></i>11. Biodata Pengurus (Ketua, Sekretaris, Bendahara - *di-scan satu-satu*)</li>
                            <li class="list-group-item bg-transparent text-muted border-secondary-subtle px-0"><i class="fa-solid fa-square-check text-success me-2"></i>12. Pasfoto Pengurus 4x6 cm 2 Lembar (Latar Merah - *di-scan satu-satu*)</li>
                            <li class="list-group-item bg-transparent text-muted border-secondary-subtle px-0"><i class="fa-solid fa-square-check text-success me-2"></i>13. Fotokopi KTP Pengurus (Ketua, Sekretaris, Bendahara - *di-scan satu-satu*)</li>
                            <li class="list-group-item bg-transparent text-muted border-secondary-subtle px-0"><i class="fa-solid fa-square-check text-success me-2"></i>14. Fotokopi KTP Pendiri, Penasihat, dan Pembina</li>
                            <li class="list-group-item bg-transparent text-muted border-secondary-subtle px-0"><i class="fa-solid fa-square-check text-success me-2"></i>15. Surat Keputusan (SK) Pengurus</li>
                            <li class="list-group-item bg-transparent text-muted border-secondary-subtle px-0"><i class="fa-solid fa-square-check text-success me-2"></i>16. Foto Sekretariat (Tampak depan menampilkan Papan Nama)</li>
                            <li class="list-group-item bg-transparent text-muted border-secondary-subtle px-0"><i class="fa-solid fa-square-check text-success me-2"></i>17. Surat Perjanjian Kontrak atau Izin Pakai dari Pemilik Gedung</li>
                            <li class="list-group-item bg-transparent text-muted border-secondary-subtle px-0"><i class="fa-solid fa-square-check text-success me-2"></i>18. Nomor Rekening Organisasi</li>
                            <li class="list-group-item bg-transparent text-muted border-secondary-subtle px-0"><i class="fa-solid fa-square-check text-success me-2"></i>19. Alamat Email Organisasi</li>
                            <li class="list-group-item bg-transparent text-muted border-secondary-subtle px-0"><i class="fa-solid fa-square-check text-success me-2"></i>20. File Logo Organisasi</li>
                            <li class="list-group-item bg-transparent text-muted border-secondary-subtle px-0"><i class="fa-solid fa-square-check text-success me-2"></i>21. Seluruh berkas di atas di-scan ke format PDF</li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>

        <!-- Tab 2: Ormas Berjenjang -->
        <div class="tab-pane fade" id="berjenjang" role="tabpanel" aria-labelledby="berjenjang-tab">
            <!-- Alur Pelayanan Berjenjang -->
            <div class="glass-card mb-4">
                <h3 class="text-white mb-4"><i class="fa-solid fa-route text-primary me-2"></i>Alur Pelayanan Surat Keberadaan Ormas Berjenjang</h3>
                <div class="row g-4 text-center">
                    <div class="col-md-2.4 col-sm-6 flex-grow-1">
                        <div class="p-3 border rounded h-100" style="border-color: var(--border-color) !important; background: rgba(255,255,255,0.01);">
                            <div class="rounded-circle bg-primary-subtle text-primary d-inline-flex align-items-center justify-content-center mb-3" style="width: 45px; height: 45px;">
                                <strong>1</strong>
                            </div>
                            <h6 class="text-white mb-2">Permohonan</h6>
                            <p class="text-muted small mb-0" style="font-size: 0.78rem;">Pemohon menyerahkan semua berkas persyaratan (hardcopy & softcopy) ke petugas.</p>
                        </div>
                    </div>
                    <div class="col-md-2.4 col-sm-6 flex-grow-1">
                        <div class="p-3 border rounded h-100" style="border-color: var(--border-color) !important; background: rgba(255,255,255,0.01);">
                            <div class="rounded-circle bg-warning-subtle text-warning d-inline-flex align-items-center justify-content-center mb-3" style="width: 45px; height: 45px;">
                                <strong>2</strong>
                            </div>
                            <h6 class="text-white mb-2">Verifikasi</h6>
                            <p class="text-muted small mb-0" style="font-size: 0.78rem;">Petugas memverifikasi kelengkapan berkas fisik dan digital.</p>
                        </div>
                    </div>
                    <div class="col-md-2.4 col-sm-6 flex-grow-1">
                        <div class="p-3 border rounded h-100" style="border-color: var(--border-color) !important; background: rgba(255,255,255,0.01);">
                            <div class="rounded-circle bg-info-subtle text-info d-inline-flex align-items-center justify-content-center mb-3" style="width: 45px; height: 45px;">
                                <strong>3</strong>
                            </div>
                            <h6 class="text-white mb-2">Peninjauan Lapangan</h6>
                            <p class="text-muted small mb-0" style="font-size: 0.78rem;">Petugas meninjau langsung kesesuaian alamat sekretariat di lapangan.</p>
                        </div>
                    </div>
                    <div class="col-md-2.4 col-sm-6 flex-grow-1">
                        <div class="p-3 border rounded h-100" style="border-color: var(--border-color) !important; background: rgba(255,255,255,0.01);">
                            <div class="rounded-circle bg-danger-subtle text-danger d-inline-flex align-items-center justify-content-center mb-3" style="width: 45px; height: 45px;">
                                <strong>4</strong>
                            </div>
                            <h6 class="text-white mb-2">Proses Surat</h6>
                            <p class="text-muted small mb-0" style="font-size: 0.78rem;">Proses penandatanganan Surat Keberadaan Ormas (Waktu: **1 Hari Kerja**).</p>
                        </div>
                    </div>
                    <div class="col-md-2.4 col-sm-6 flex-grow-1">
                        <div class="p-3 border rounded h-100" style="border-color: var(--border-color) !important; background: rgba(255,255,255,0.01);">
                            <div class="rounded-circle bg-success-subtle text-success d-inline-flex align-items-center justify-content-center mb-3" style="width: 45px; height: 45px;">
                                <strong>5</strong>
                            </div>
                            <h6 class="text-white mb-2">Pemberitahuan</h6>
                            <p class="text-muted small mb-0" style="font-size: 0.78rem;">Pemohon dihubungi petugas jika Surat Keberadaan selesai diproses.</p>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Persyaratan Dokumen Berjenjang -->
            <div class="glass-card">
                <div class="d-flex justify-content-between align-items-center mb-4 flex-wrap gap-3">
                    <h3 class="text-white mb-0"><i class="fa-solid fa-list-check text-warning me-2"></i>Berkas Persyaratan Ormas Berjenjang</h3>
                </div>
                <div class="row g-3">
                    <div class="col-md-6">
                        <ul class="list-group list-group-flush" style="background: transparent;">
                            <li class="list-group-item bg-transparent text-muted border-secondary-subtle px-0"><i class="fa-solid fa-square-check text-success me-2"></i>1. Surat Permohonan ditujukan kepada Kepala Badan Kesbangpol Kab. Sinjai</li>
                            <li class="list-group-item bg-transparent text-muted border-secondary-subtle px-0"><i class="fa-solid fa-square-check text-success me-2"></i>2. Surat Pernyataan Resmi (Meterai Rp 10.000)</li>
                            <li class="list-group-item bg-transparent text-muted border-secondary-subtle px-0"><i class="fa-solid fa-square-check text-success me-2"></i>3. Surat Keterangan Domisili (Alamat sesuai domisili, kop surat & sekretariat)</li>
                            <li class="list-group-item bg-transparent text-muted border-secondary-subtle px-0"><i class="fa-solid fa-square-check text-success me-2"></i>4. Formulir Isian Data Ormas (ditandatangani Ketua & Sekretaris)</li>
                        </ul>
                    </div>
                    <div class="col-md-6">
                        <ul class="list-group list-group-flush" style="background: transparent;">
                            <li class="list-group-item bg-transparent text-muted border-secondary-subtle px-0"><i class="fa-solid fa-square-check text-success me-2"></i>5. Pasfoto Pengurus ukuran 4x6 cm sebanyak 2 lembar (Ketua, Sekretaris, Bendahara)</li>
                            <li class="list-group-item bg-transparent text-muted border-secondary-subtle px-0"><i class="fa-solid fa-square-check text-success me-2"></i>6. Fotokopi KTP Pengurus (Ketua, Sekretaris, Bendahara)</li>
                            <li class="list-group-item bg-transparent text-muted border-secondary-subtle px-0"><i class="fa-solid fa-square-check text-success me-2"></i>7. Surat Keputusan (SK) Pengurus Organisasi</li>
                            <li class="list-group-item bg-transparent text-muted border-secondary-subtle px-0"><i class="fa-solid fa-square-check text-success me-2"></i>8. Foto Sekretariat (Tampak depan menampilkan Papan Nama resmi)</li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<?= $this->endSection() ?>
