<?= $this->extend('layouts/admin') ?>

<?= $this->section('styles') ?>
<link rel="stylesheet" href="https://unpkg.com/leaflet@1.9.4/dist/leaflet.css" crossorigin="" />
<style>
    .form-card {
        background: var(--card-bg);
        border: 1px solid var(--border-color);
        border-radius: 16px;
        padding: 30px;
    }

    #form-map {
        height: 350px;
        border-radius: 10px;
        border: 1px solid var(--border-color);
    }
    .wa-link {
        transition: all 0.2s ease;
    }
    .wa-link:hover {
        text-decoration: underline !important;
        opacity: 0.85;
    }

    /* Timeline Steps */
    .timeline-steps {
        display: flex;
        justify-content: space-between;
        align-items: center;
        position: relative;
        margin-top: 30px;
        margin-bottom: 30px;
    }

    .timeline-steps::before {
        content: '';
        position: absolute;
        top: 20px;
        left: 0;
        right: 0;
        height: 4px;
        background: var(--border-color);
        z-index: 1;
    }

    .timeline-progress {
        position: absolute;
        top: 20px;
        left: 0;
        height: 4px;
        background: var(--primary-grad);
        z-index: 2;
        transition: width 0.5s ease-in-out;
    }

    .timeline-step {
        position: relative;
        z-index: 3;
        display: flex;
        flex-direction: column;
        align-items: center;
        width: 120px;
    }

    .timeline-icon {
        width: 44px;
        height: 44px;
        border-radius: 50%;
        background: var(--bg-color);
        border: 3px solid var(--border-color);
        display: flex;
        align-items: center;
        justify-content: center;
        color: var(--text-muted);
        font-weight: bold;
        transition: all 0.4s ease;
    }

    .timeline-step.active .timeline-icon {
        border-color: #f43f5e;
        color: #f43f5e;
        box-shadow: 0 0 12px rgba(244, 63, 94, 0.4);
    }

    .timeline-step.completed .timeline-icon {
        background: var(--primary-grad);
        border-color: #f43f5e;
        color: white;
    }

    .timeline-label {
        margin-top: 10px;
        font-size: 0.8rem;
        font-weight: 600;
        text-align: center;
        color: var(--text-muted);
    }

    .timeline-step.active .timeline-label,
    .timeline-step.completed .timeline-label {
        color: var(--text-main);
    }

    @media (max-width: 768px) {
        .timeline-steps {
            flex-direction: column;
            align-items: flex-start;
            gap: 24px;
            padding-left: 20px;
        }
        .timeline-steps::before {
            left: 40px;
            top: 0;
            bottom: 0;
            width: 4px;
            height: 100%;
        }
        .timeline-progress {
            left: 40px;
            top: 0;
            width: 4px !important;
            height: 0%;
            transition: height 0.5s ease-in-out;
        }
        .timeline-step {
            flex-direction: row;
            width: 100%;
            gap: 15px;
        }
        .timeline-label {
            margin-top: 0;
            text-align: left;
        }
    }
</style>
<?= $this->endSection() ?>

<?= $this->section('content') ?>

<?php
$is_edit = !empty($pendaftaran);
$nama_ormas = old('nama_ormas') ?? ($pendaftaran['nama_ormas'] ?? '');
$alamat = old('alamat') ?? ($pendaftaran['alamat'] ?? '');
$email = old('email') ?? ($pendaftaran['email'] ?? '');
$telepon = old('telepon') ?? ($pendaftaran['telepon'] ?? '');
$tgl_sk = old('tgl_sk_kepengurusan') ?? ($pendaftaran['tgl_sk_kepengurusan'] ?? '');
$tgl_exp = old('tgl_sk_kedaluwarsa') ?? ($pendaftaran['tgl_sk_kedaluwarsa'] ?? '');
$lat = old('latitude') ?? ($pendaftaran['latitude'] ?? '');
$lng = old('longitude') ?? ($pendaftaran['longitude'] ?? '');

$existingFiles = [];
if ($is_edit && !empty($pendaftaran['file_berkas'])) {
    $existingFiles = json_decode($pendaftaran['file_berkas'], true) ?: [];
}

$tipe = $pendaftaran['tipe_ormas'] ?? 'Lokal';

$requirementsLokal = [
    ["name" => "Surat Permohonan", "desc" => "Surat Permohonan ditujukan kepada Menteri (Cq. Kaban Kesbangpol)", "tte" => true, "template" => "https://drive.google.com/uc?export=download&id=1XqCYdQYp87AXN4RGMvJqJKslvA05nRNR"],
    ["name" => "AD & ART", "desc" => "Anggaran Dasar (AD) & Anggaran Rumah Tangga (ART)", "tte" => true, "template" => ""],
    ["name" => "Akta Notaris", "desc" => "Akta Pendirian Notaris (memuat Nama, Lambang, Asas, Tujuan, Pengurus, Hak, Keuangan, dll.)", "tte" => true, "template" => ""],
    ["name" => "Surat Pernyataan Keabsahan", "desc" => "Surat Pernyataan Keabsahan Dokumen (Meterai Rp 10.000)", "tte" => true, "template" => "https://drive.google.com/uc?export=download&id=1XqCYdQYp87AXN4RGMvJqJKslvA05nRNR"],
    ["name" => "Program & Struktur Kerja", "desc" => "Program Kerja Organisasi & Struktur Organisasi Resmi", "tte" => true, "template" => ""],
    ["name" => "Domisili Kantor", "desc" => "Surat Keterangan Domisili Kantor Sekretariat", "tte" => true, "template" => ""],
    ["name" => "NPWP Organisasi", "desc" => "NPWP atas nama Organisasi", "tte" => false, "template" => ""],
    ["name" => "Formulir Isian Data Ormas", "desc" => "Formulir Isian Data Ormas (ditandatangani Ketua & Sekretaris)", "tte" => true, "template" => "https://drive.google.com/uc?export=download&id=1XqCYdQYp87AXN4RGMvJqJKslvA05nRNR"],
    ["name" => "Rekomendasi Kementerian", "desc" => "Surat Rekomendasi Kementerian Agama (Ormas Agama) / Kebudayaan", "tte" => true, "template" => ""],
    ["name" => "Biodata & KTP Pengurus", "desc" => "Biodata & KTP Pengurus (Ketua, Sekretaris, Bendahara)", "tte" => false, "template" => "", "isPengurus" => true],
    ["name" => "Pasfoto Pengurus", "desc" => "Pasfoto Pengurus 4x6 cm 2 Lembar (Latar Merah)", "tte" => false, "template" => "", "isPengurus" => true],
    ["name" => "SK & Foto Sekretariat", "desc" => "SK Pengurus & Foto Sekretariat (Tampak depan menampilkan Papan Nama)", "tte" => false, "template" => ""],
    ["name" => "Kontrak/Izin Pakai Gedung", "desc" => "Surat Perjanjian Kontrak/Izin Pakai Gedung dari Pemilik Gedung", "tte" => true, "template" => ""],
    ["name" => "Rekening & Logo Organisasi", "desc" => "Nomor Rekening Organisasi & File Logo Organisasi", "tte" => false, "template" => ""]
];

$requirementsBerjenjang = [
    ["name" => "Surat Permohonan", "desc" => "Surat Permohonan ditujukan kepada Kepala Badan Kesbangpol Kab. Sinjai", "tte" => true, "template" => base_url('uploads/templates/Persyaratan_Ormas_Berjenjang_2026.docx')],
    ["name" => "Surat Pernyataan Resmi", "desc" => "Surat Pernyataan Resmi (Memuat 6 poin pernyataan, Meterai Rp 10.000)", "tte" => true, "template" => base_url('uploads/templates/Persyaratan_Ormas_Berjenjang_2026.docx')],
    ["name" => "SK Kemenkumham", "desc" => "Surat Keputusan (SK) Kemenkumham RI", "tte" => true, "template" => ""],
    ["name" => "Surat Keterangan Domisili", "desc" => "Surat Keterangan Domisili (Alamat domisili kop surat & sekretariat)", "tte" => true, "template" => ""],
    ["name" => "Formulir Isian Data Ormas", "desc" => "Formulir Isian Data Ormas (ditandatangani Ketua & Sekretaris)", "tte" => true, "template" => base_url('uploads/templates/Persyaratan_Ormas_Berjenjang_2026.docx')],
    ["name" => "Pasfoto Pengurus", "desc" => "Pasfoto Pengurus ukuran 4x6 cm sebanyak 2 lembar", "tte" => false, "template" => "", "isPengurus" => true],
    ["name" => "Fotokopi KTP Pengurus", "desc" => "Fotokopi KTP Pengurus (Ketua, Sekretaris, Bendahara)", "tte" => false, "template" => "", "isPengurus" => true],
    ["name" => "Surat Keputusan (SK) Pengurus", "desc" => "Surat Keputusan (SK) Pengurus Organisasi", "tte" => false, "template" => ""],
    ["name" => "Foto Sekretariat", "desc" => "Foto Sekretariat (Tampak depan menampilkan Papan Nama resmi)", "tte" => false, "template" => ""],
    ["name" => "Dokumen Pendukung Tambahan", "desc" => "Dokumen pendukung legalitas tambahan lainnya (ZIP/PDF)", "tte" => false, "template" => ""]
];
?>

<div class="row justify-content-center">
    <div class="col-lg-10">
        <!-- Back button & Page Title -->
        <div class="d-flex justify-content-between align-items-center mb-4 flex-wrap gap-2">
            <div>
                <a href="<?= base_url('user') ?>" class="btn btn-sm btn-outline-secondary text-white px-3 rounded-pill">
                    <i class="fa-solid fa-arrow-left me-1"></i> Kembali ke Dasbor
                </a>
                <h3 class="text-white fw-bold mt-3 mb-0">
                    <i class="fa-solid fa-file-pen text-primary me-2"></i>
                    <?= $is_edit ? 'Alur Pendaftaran Ormas / LSM' : 'Form Pengajuan Pendaftaran Ormas Baru' ?>
                </h3>
            </div>
        </div>

        <!-- Wizard Step Indicators -->
        <div class="card p-3 mb-4 border-0" style="background: rgba(255, 255, 255, 0.02); border: 1px solid var(--border-color) !important; border-radius: 12px;">
            <div class="row text-center font-heading">
                <div class="col-4 step-indicator" id="step-ind-1">
                    <div class="step-num bg-secondary text-white rounded-circle d-inline-flex align-items-center justify-content-center fw-bold mb-1" style="width: 32px; height: 32px; font-size: 0.9rem;">1</div>
                    <div class="small fw-semibold d-block text-muted" id="step-lbl-1">Informasi Dasar & Peta</div>
                </div>
                <div class="col-4 step-indicator" id="step-ind-2">
                    <div class="step-num bg-secondary text-white rounded-circle d-inline-flex align-items-center justify-content-center fw-bold mb-1" style="width: 32px; height: 32px; font-size: 0.9rem;">2</div>
                    <div class="small fw-semibold d-block text-muted" id="step-lbl-2">Berkas Persyaratan</div>
                </div>
                <div class="col-4 step-indicator" id="step-ind-3">
                    <div class="step-num bg-secondary text-white rounded-circle d-inline-flex align-items-center justify-content-center fw-bold mb-1" style="width: 32px; height: 32px; font-size: 0.9rem;">3</div>
                    <div class="small fw-semibold d-block text-muted" id="step-lbl-3">Status Pengajuan & Dokumen</div>
                </div>
            </div>
        </div>

        <!-- ========================================== -->
        <!-- STEP 1: INFORMASI UMUM & PETA LOKASI -->
        <!-- ========================================== -->
        <div class="form-card glass-card d-none" id="section-step-1">
            <form action="<?= base_url('user/pengajuan/simpan') ?>" method="POST" enctype="multipart/form-data">
                <?= csrf_field() ?>
                <?php if ($is_edit): ?>
                    <input type="hidden" name="pendaftaran_id" value="<?= esc($pendaftaran['id']) ?>">
                <?php endif; ?>
                <input type="hidden" name="current_step" value="1">

                <!-- Notice Board -->
                <div class="alert alert-info bg-primary-subtle border-primary-subtle text-primary-light p-4 mb-4" role="alert" style="border-radius: 12px; font-size: 0.95rem; line-height: 1.6;">
                    <p class="mb-2">Hai, Selamat Datang di Pelayanan Registrasi Laporan Keberadaan Ormas/Yayasan/Perkumpulan Kabupaten Sinjai. Lengkapi informasi umum dan letak sekretariat Anda pada peta di bawah ini.</p>
                </div>

                <h5 class="text-main fw-bold mb-3 border-bottom border-secondary border-opacity-10 pb-2">1. Informasi Dasar Organisasi</h5>
                <div class="row g-3 mb-4">
                    <div class="col-md-6">
                        <label for="nama_ormas" class="form-label small text-muted">Nama Ormas / Lembaga / Yayasan <span class="text-danger fw-bold">*</span></label>
                        <input type="text" name="nama_ormas" id="nama_ormas" class="form-control form-control-custom" placeholder="Masukkan nama resmi organisasi" value="<?= esc($nama_ormas) ?>" required>
                    </div>
                    <div class="col-md-6">
                        <label for="tipe_ormas" class="form-label small text-muted">Tipe Organisasi <span class="text-danger fw-bold">*</span></label>
                        <select class="form-select form-control-custom" id="tipe_ormas" name="tipe_ormas" required onchange="toggleOrmasRequirements(this.value)">
                            <option value="Lokal" <?= ($tipe === 'Lokal') ? 'selected' : '' ?>>Ormas Lokal (Penerbitan Laporan Tanggapan Keberadaan)</option>
                            <option value="Berjenjang" <?= ($tipe === 'Berjenjang') ? 'selected' : '' ?>>Ormas Berjenjang (Penerbitan Surat Keberadaan)</option>
                        </select>
                    </div>
                    <div class="col-md-6">
                        <label for="telepon" class="form-label small text-muted">Nomor Telepon / WhatsApp Kontak <span class="text-danger fw-bold">*</span></label>
                        <input type="text" name="telepon" id="telepon" class="form-control form-control-custom" placeholder="Contoh: 08123456789" value="<?= esc($telepon) ?>" required>
                    </div>
                    <div class="col-md-6">
                        <label for="email" class="form-label small text-muted">Email Kontak Organisasi</label>
                        <input type="email" name="email" id="email" class="form-control form-control-custom" placeholder="organisasi@domain.com" value="<?= esc($email) ?>">
                    </div>
                    <div class="col-md-12">
                        <label for="alamat" class="form-label small text-muted">Alamat Kantor Sekretariat <span class="text-danger fw-bold">*</span></label>
                        <textarea name="alamat" id="alamat" class="form-control form-control-custom" rows="2" placeholder="Tulis alamat kantor sekretariat lengkap dengan kecamatan/kelurahan" required><?= esc($alamat) ?></textarea>
                        <div class="form-text text-muted small mt-1" style="font-size: 11px;"><i class="fa-solid fa-circle-info text-info me-1"></i>Anda juga bisa klik/drag langsung pada peta di bagian bawah, alamat dan koordinat akan otomatis terisi ke form ini.</div>
                        <div class="d-flex justify-content-between align-items-center mt-2 flex-wrap gap-2">
                            <span id="geocode-status" class="small text-muted" style="font-size: 11px;"></span>
                            <button type="button" id="btn-geocode" class="btn btn-sm btn-outline-info px-3 rounded-pill text-white" style="font-size: 11px; border-color: rgba(13, 202, 240, 0.4);">
                                <i class="fa-solid fa-location-crosshairs me-1 text-info"></i> Deteksi Titik Koordinat
                            </button>
                        </div>
                    </div>
                </div>

                <h5 class="text-main fw-bold mb-3 border-bottom border-secondary border-opacity-10 pb-2">2. Legalitas & Masa Kepengurusan</h5>
                <div class="row g-3 mb-4">
                    <div class="col-md-6">
                        <label for="tgl_sk_kepengurusan" class="form-label small text-muted">Tanggal Mulai SK Kepengurusan</label>
                        <input type="date" name="tgl_sk_kepengurusan" id="tgl_sk_kepengurusan" class="form-control form-control-custom" value="<?= esc($tgl_sk) ?>">
                    </div>
                    <div class="col-md-6">
                        <label for="tgl_sk_kedaluwarsa" class="form-label small text-muted">Tanggal SK Tidak Aktif</label>
                        <input type="date" name="tgl_sk_kedaluwarsa" id="tgl_sk_kedaluwarsa" class="form-control form-control-custom" value="<?= esc($tgl_exp) ?>">
                    </div>
                    <div class="col-md-12">
                        <label for="file_logo" class="form-label small text-muted mb-2">
                            Logo Organisasi (Format Gambar)
                            <?php if ($is_edit && !empty($pendaftaran['file_logo'])): ?>
                                <span class="badge bg-secondary-subtle text-white font-normal ms-1">Sudah ada logo</span>
                            <?php endif; ?>
                        </label>
                        <input type="file" name="file_logo" id="file_logo" class="form-control form-control-custom" accept="image/*">
                    </div>
                </div>

                <h5 class="text-main fw-bold mb-3 border-bottom border-secondary border-opacity-10 pb-2">2b. Susunan Kepengurusan Inti</h5>
                <p class="text-muted small mb-3"><i class="fa-solid fa-circle-info text-info me-1"></i>Masukkan nama pengurus sesuai SK Kepengurusan Anda (minimal Ketua, Sekretaris, Bendahara).</p>
                
                <div class="table-responsive mb-4">
                    <table class="table table-bordered border-secondary border-opacity-10 text-white align-middle" id="table-pengurus">
                        <thead>
                            <tr style="background: rgba(255, 255, 255, 0.03);">
                                <th style="width: 30%;">Jabatan <span class="text-danger fw-bold">*</span></th>
                                <th style="width: 40%;">Nama Lengkap <span class="text-danger fw-bold">*</span></th>
                                <th style="width: 25%;">No. HP / WhatsApp</th>
                                <th style="width: 5%;" class="text-center">Aksi</th>
                            </tr>
                        </thead>
                        <tbody id="pengurus-container">
                            <?php
                            $defaultJabatans = ['Ketua', 'Sekretaris', 'Bendahara'];
                            $activePengurus = old('pengurus_nama') ? [] : ($pengurus ?? []);
                            
                            if (old('pengurus_nama')) {
                                $oldNama = old('pengurus_nama');
                                $oldJabatan = old('pengurus_jabatan');
                                $oldNoHp = old('pengurus_no_hp');
                                foreach ($oldNama as $idx => $val) {
                                    $activePengurus[] = [
                                        'nama' => $val,
                                        'jabatan' => $oldJabatan[$idx] ?? '',
                                        'no_hp' => $oldNoHp[$idx] ?? ''
                                    ];
                                }
                            }
                            
                            if (empty($activePengurus)) {
                                foreach ($defaultJabatans as $jab) {
                                    $activePengurus[] = [
                                        'nama' => '',
                                        'jabatan' => $jab,
                                        'no_hp' => ''
                                    ];
                                }
                            }
                            
                            foreach ($activePengurus as $index => $p):
                            ?>
                            <tr class="pengurus-row">
                                <td>
                                    <input type="hidden" name="pengurus_id[]" value="<?= esc($p['id'] ?? '') ?>">
                                    <input type="hidden" name="pengurus_old_ktp[]" value="<?= esc($p['file_ktp'] ?? '') ?>">
                                    <input type="hidden" name="pengurus_old_pasfoto[]" value="<?= esc($p['file_pasfoto'] ?? '') ?>">
                                    <input type="hidden" name="pengurus_old_biodata[]" value="<?= esc($p['file_biodata'] ?? '') ?>">
                                    <input type="text" name="pengurus_jabatan[]" class="form-control form-control-custom form-control-sm" placeholder="Contoh: Ketua" value="<?= esc($p['jabatan']) ?>" required>
                                </td>
                                <td>
                                    <input type="text" name="pengurus_nama[]" class="form-control form-control-custom form-control-sm" placeholder="Nama Lengkap" value="<?= esc($p['nama']) ?>" required>
                                </td>
                                <td>
                                    <input type="text" name="pengurus_no_hp[]" class="form-control form-control-custom form-control-sm" placeholder="Contoh: 0812..." value="<?= esc($p['no_hp']) ?>">
                                </td>
                                <td class="text-center">
                                    <button type="button" class="btn btn-sm btn-outline-danger border-0 rounded-circle text-danger" onclick="removePengurusRow(this)">
                                        <i class="fa-solid fa-trash-can"></i>
                                    </button>
                                </td>
                            </tr>
                            <?php endforeach; ?>
                        </tbody>
                    </table>
                    <button type="button" class="btn btn-sm btn-outline-success text-success border-success border-opacity-30 rounded-pill px-3 mb-2" onclick="addPengurusRow()">
                        <i class="fa-solid fa-plus me-1 text-success"></i> Tambah Baris Pengurus
                    </button>
                </div>

                <h5 class="text-main fw-bold mb-3 border-bottom border-secondary border-opacity-10 pb-2">3. Lokasi Geografis Kantor Sekretariat</h5>
                <p class="text-muted small mb-3">
                    <i class="fa-solid fa-circle-info text-info me-1"></i>
                    Titik koordinat pada peta di bawah akan otomatis menyesuaikan berdasarkan alamat yang Anda ketik di atas. Anda juga dapat memindahkan marker biru atau mengklik peta secara langsung untuk menentukan titik lokasi yang lebih presisi.
                </p>
                
                <input type="hidden" name="latitude" id="latitude" value="<?= esc($lat) ?>">
                <input type="hidden" name="longitude" id="longitude" value="<?= esc($lng) ?>">
                <div id="form-map" class="mb-4"></div>

                <div class="d-flex justify-content-end gap-2 border-top border-secondary border-opacity-10 pt-4 mt-4">
                    <a href="<?= base_url('user') ?>" class="btn btn-secondary text-white">Batal</a>
                    <button type="submit" class="btn btn-portal text-white fw-bold">
                        Simpan & Lanjut ke Berkas <i class="fa-solid fa-arrow-right ms-1"></i>
                    </button>
                </div>
            </form>
        </div>

        <!-- ========================================== -->
        <!-- STEP 2: UNGHAH BERKAS PERSYARATAN & TEMPLATE -->
        <!-- ========================================== -->
        <div class="form-card glass-card d-none" id="section-step-2">
            <?php if ($is_edit && $pendaftaran['status_verifikasi'] === 'Rejected'): ?>
                <div class="alert alert-danger bg-danger-subtle border-danger-subtle text-danger p-3 rounded mb-4" role="alert" style="border-radius: 12px;">
                    <h6 class="fw-bold mb-1"><i class="fa-solid fa-circle-xmark me-2"></i>Catatan Penolakan Admin:</h6>
                    <p class="small mb-0 italic">"<?= esc($pendaftaran['alasan_ditolak']) ?>"</p>
                </div>
            <?php endif; ?>

            <form action="<?= base_url('user/pengajuan/simpan') ?>" method="POST" enctype="multipart/form-data">
                <?= csrf_field() ?>
                <?php if ($is_edit): ?>
                    <input type="hidden" name="pendaftaran_id" value="<?= esc($pendaftaran['id']) ?>">
                <?php endif; ?>
                <input type="hidden" name="current_step" value="2">
                <input type="hidden" name="tipe_ormas" id="tipe_ormas_step2" value="<?= esc($pendaftaran['tipe_ormas'] ?? 'Lokal') ?>">


                <!-- Info Board -->
                <div class="alert alert-warning bg-warning-subtle border-warning-subtle text-warning-light p-4 mb-4" role="alert" style="border-radius: 12px; font-size: 0.95rem; line-height: 1.6;">
                    <p class="mb-0 fw-semibold text-white">
                        <i class="fa-solid fa-cloud-arrow-up me-2"></i>Silakan unggah dokumen persyaratan Anda satu-per-satu di bawah ini. Harap pastikan format file berupa <b>PDF</b> atau <b>ZIP</b>.
                    </p>
                </div>

                <!-- Live Progress Bar inside Step 2 -->
                <div class="mb-4 p-3 rounded" style="background: rgba(255, 255, 255, 0.02); border: 1px solid var(--border-color); border-radius: 12px;">
                    <div class="d-flex justify-content-between align-items-center mb-2">
                        <span class="small fw-bold text-white"><i class="fa-solid fa-spinner fa-spin me-2 text-warning" id="progress-spinner"></i>Kelengkapan Berkas Diunggah</span>
                        <span class="badge bg-danger text-white fw-bold" id="progress-percentage-label">0% Lengkap</span>
                    </div>
                    <div class="progress" style="height: 10px; background-color: var(--hr-border); border-radius: 6px; overflow: hidden;">
                        <div class="progress-bar progress-bar-striped progress-bar-animated bg-danger" id="progress-bar-fill" role="progressbar" style="width: 0%" aria-valuenow="0" aria-valuemin="0" aria-valuemax="100"></div>
                    </div>
                </div>

                <!-- Validasi Kelengkapan Dokumen Table -->
                <div class="card mb-4 border-0" style="background: rgba(255, 255, 255, 0.02); border: 1px solid var(--border-color); border-radius: 12px; overflow: hidden;">
                    <div class="card-header py-3 px-4" style="background: #eab308; border-bottom: 1px solid var(--border-color);">
                        <h5 class="mb-0 text-dark fw-bold font-heading" style="font-size: 1.05rem;"><i class="fa-solid fa-clipboard-check me-2"></i>Unggah Persyaratan Dokumen</h5>
                    </div>
                    <div class="table-responsive">
                        <table class="table table-custom mb-0 text-white" style="font-size: 0.85rem;">
                            <thead>
                                <tr style="background: rgba(255, 255, 255, 0.02);">
                                    <th class="text-center" style="width: 4%;">#</th>
                                    <th style="width: 32%;">Jenis Dokumen</th>
                                    <th class="text-center" style="width: 10%;">Status</th>
                                    <th class="text-center" style="width: 10%;">TTE</th>
                                    <th class="text-center" style="width: 12%;">Ukuran</th>
                                    <th class="text-center" style="width: 12%;">File Terunggah</th>
                                    <th class="text-center" style="width: 10%;">Format</th>
                                    <th style="width: 10%;">Aksi</th>
                                </tr>
                            </thead>
                            <tbody id="validation-table-body">
                                <!-- Populated dynamically by JS -->
                            </tbody>
                        </table>
                    </div>
                </div>

                <!-- Berkas Pengurus (Tabel Minimalis & Kreatif) -->
                <div class="card mb-4 border-0" style="background: rgba(255, 255, 255, 0.02); border: 1px solid var(--border-color); border-radius: 12px; overflow: hidden;">
                    <div class="card-header py-3 px-4" style="background: rgba(13, 202, 240, 0.15); border-bottom: 1px solid var(--border-color);">
                        <h5 class="mb-0 text-white fw-bold font-heading" style="font-size: 1.05rem;"><i class="fa-solid fa-users me-2 text-info"></i>Unggah Berkas Identitas Pengurus</h5>
                    </div>
                    <div class="card-body p-3">
                        <p class="text-muted small mb-3"><i class="fa-solid fa-circle-info text-info me-1"></i>Silakan unggah berkas Biodata (CV/Form), KTP, dan Pasfoto 4x6 resmi untuk masing-masing pengurus.</p>
                        
                        <div class="table-responsive">
                            <table class="table table-bordered border-secondary border-opacity-10 text-white align-middle mb-0" style="font-size: 0.82rem; background: rgba(255,255,255,0.01);">
                                <thead>
                                    <tr style="background: rgba(255, 255, 255, 0.03);">
                                        <th style="width: 35%;">Nama & Jabatan Pengurus</th>
                                        <th style="width: 25%;">Unggah Berkas Biodata (PDF/Word)</th>
                                        <th style="width: 25%;">Unggah Berkas KTP (PDF/Gambar)</th>
                                        <th style="width: 15%;" class="text-center">Pasfoto 4x6 (Latar Merah)</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php if (empty($pengurus)): ?>
                                        <tr>
                                            <td colspan="4" class="text-center text-muted py-4 small">Belum ada data pengurus diisi di Langkah 1.</td>
                                        </tr>
                                    <?php else: ?>
                                        <?php foreach ($pengurus as $idx => $p): ?>
                                            <tr style="border-bottom: 1px solid rgba(255,255,255,0.03);">
                                                <!-- Column 1: Nama & Jabatan -->
                                                <td class="py-2.5">
                                                    <input type="hidden" name="pengurus_id[]" value="<?= esc($p['id']) ?>">
                                                    <div class="fw-bold text-main" style="font-size: 0.88rem;"><?= esc($p['nama']) ?></div>
                                                    <span class="badge bg-info text-white font-normal mt-1" style="font-size: 0.68rem;"><?= esc($p['jabatan']) ?></span>
                                                </td>

                                                <!-- Column 2: BIODATA UPLOAD -->
                                                <td class="py-2.5">
                                                    <input type="hidden" name="pengurus_old_biodata[]" value="<?= esc($p['file_biodata'] ?? '') ?>">
                                                    <div class="d-flex align-items-center gap-1.5">
                                                        <label class="btn btn-xs btn-outline-warning mb-0 py-1 px-2.5 d-flex align-items-center gap-1.5" style="cursor: pointer; font-size: 0.68rem; border-color: rgba(234,179,8,0.3) !important;">
                                                            <i class="fa-solid fa-file-pdf"></i> Pilih Berkas
                                                            <input type="file" name="pengurus_biodata_<?php echo $idx; ?>" class="d-none" accept=".pdf,.doc,.docx,image/*" onchange="handlePengurusFileChange(this, 'biodata', <?php echo $idx; ?>)">
                                                        </label>
                                                        <span class="file-name-biodata-<?php echo $idx; ?> small text-success text-truncate d-block" style="max-width: 100px; font-size: 0.68rem;">
                                                            <?php if (!empty($p['file_biodata'])): ?>
                                                                <a href="<?= base_url('uploads/ormas/' . $p['file_biodata']) ?>" target="_blank" class="text-info text-decoration-none" title="Buka Biodata"><i class="fa-solid fa-circle-check text-success"></i> Ada</a>
                                                            <?php else: ?>
                                                                <span class="text-muted text-opacity-40">Belum ada</span>
                                                            <?php endif; ?>
                                                        </span>
                                                    </div>
                                                </td>

                                                <!-- Column 3: KTP UPLOAD -->
                                                <td class="py-2.5">
                                                    <input type="hidden" name="pengurus_old_ktp[]" value="<?= esc($p['file_ktp'] ?? '') ?>">
                                                    <div class="d-flex align-items-center gap-1.5">
                                                        <label class="btn btn-xs btn-outline-info mb-0 py-1 px-2.5 d-flex align-items-center gap-1.5" style="cursor: pointer; font-size: 0.68rem; border-color: rgba(13,202,240,0.3) !important;">
                                                            <i class="fa-solid fa-id-card"></i> Pilih KTP
                                                            <input type="file" name="pengurus_ktp_<?php echo $idx; ?>" class="d-none" accept=".pdf,image/*" onchange="handlePengurusFileChange(this, 'ktp', <?php echo $idx; ?>)">
                                                        </label>
                                                        <span class="file-name-ktp-<?php echo $idx; ?> small text-success text-truncate d-block" style="max-width: 100px; font-size: 0.68rem;">
                                                            <?php if (!empty($p['file_ktp'])): ?>
                                                                <a href="<?= base_url('uploads/ormas/' . $p['file_ktp']) ?>" target="_blank" class="text-info text-decoration-none" title="Buka KTP"><i class="fa-solid fa-circle-check text-success"></i> Ada</a>
                                                            <?php else: ?>
                                                                <span class="text-muted text-opacity-40">Belum ada</span>
                                                            <?php endif; ?>
                                                        </span>
                                                    </div>
                                                </td>

                                                <!-- Column 4: Pasfoto 4x6 with Preview & Upload Button -->
                                                <td class="py-2.5">
                                                    <input type="hidden" name="pengurus_old_pasfoto[]" value="<?= esc($p['file_pasfoto'] ?? '') ?>">
                                                    <div class="d-flex align-items-center gap-2">
                                                        <!-- Preview Avatar -->
                                                        <div class="position-relative flex-shrink-0" style="width: 32px; height: 40px; border-radius: 4px; overflow: hidden; border: 1px solid rgba(255,255,255,0.1); background: rgba(255,255,255,0.03);">
                                                            <?php if (!empty($p['file_pasfoto'])): ?>
                                                                <img src="<?= base_url('uploads/ormas/' . $p['file_pasfoto']) ?>" id="avatar-preview-<?php echo $idx; ?>" alt="Foto" style="width: 100%; height: 100%; object-fit: cover;">
                                                            <?php else: ?>
                                                                <div class="w-100 h-100 d-flex flex-column align-items-center justify-content-center text-muted text-opacity-30" id="avatar-placeholder-<?php echo $idx; ?>">
                                                                    <i class="fa-solid fa-user-tie" style="font-size: 10px;"></i>
                                                                </div>
                                                                <img src="" id="avatar-preview-<?php echo $idx; ?>" alt="Foto" class="d-none" style="width: 100%; height: 100%; object-fit: cover;">
                                                            <?php endif; ?>
                                                            <!-- Hover camera trigger overlay -->
                                                            <label class="position-absolute top-0 start-0 w-100 h-100 d-flex align-items-center justify-content-center bg-black bg-opacity-65 text-white opacity-0" style="cursor: pointer; transition: opacity 0.2s; font-size: 7px; margin-bottom: 0;" onmouseover="this.style.opacity=1" onmouseout="this.style.opacity=0">
                                                                <i class="fa-solid fa-camera"></i>
                                                                <input type="file" name="pengurus_pasfoto_<?php echo $idx; ?>" class="d-none" accept="image/*" onchange="handlePasfotoChange(this, <?php echo $idx; ?>)">
                                                            </label>
                                                        </div>
                                                        <!-- Upload button with text label -->
                                                        <div class="d-flex align-items-center gap-1.5">
                                                            <label class="btn btn-xs btn-outline-success mb-0 py-1 px-2.5 d-flex align-items-center gap-1.5" style="cursor: pointer; font-size: 0.68rem; border-color: rgba(40,167,69,0.3) !important;">
                                                                <i class="fa-solid fa-image"></i> Pilih Foto
                                                                <input type="file" name="pengurus_pasfoto_<?php echo $idx; ?>" class="d-none" accept="image/*" onchange="handlePasfotoChange(this, <?php echo $idx; ?>)">
                                                            </label>
                                                            <span class="file-name-pasfoto-<?php echo $idx; ?> small text-success text-truncate d-block" style="max-width: 80px; font-size: 0.68rem;">
                                                                <?php if (!empty($p['file_pasfoto'])): ?>
                                                                    <span class="text-success fw-bold"><i class="fa-solid fa-circle-check text-success"></i> Ada</span>
                                                                <?php else: ?>
                                                                    <span class="text-muted text-opacity-40">Belum ada</span>
                                                                <?php endif; ?>
                                                            </span>
                                                        </div>
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

                <div class="d-flex justify-content-between border-top border-secondary border-opacity-10 pt-4 mt-4">
                    <button type="button" class="btn btn-outline-secondary text-white" onclick="goToStep(1)">
                        <i class="fa-solid fa-arrow-left me-1"></i> Kembali ke Informasi Dasar
                    </button>
                    <div class="d-flex gap-2">
                        <a href="<?= base_url('user') ?>" class="btn btn-secondary text-white">Batal</a>
                        <button type="button" id="btn-submit-berkas" class="btn btn-success text-white fw-bold" onclick="validateAndSubmitBerkas()">
                            <i class="fa-solid fa-paper-plane me-1"></i> Kirim Pengajuan Berkas
                        </button>
                    </div>
                </div>
                <!-- Alert validasi berkas -->
                <div id="berkas-validation-alert" class="alert alert-danger border-0 mt-3 d-none" role="alert" style="background: rgba(239,68,68,0.12); color: #f87171; border-radius: 8px; font-size: 0.88rem;">
                    <i class="fa-solid fa-triangle-exclamation me-2"></i>
                    <span id="berkas-validation-msg"></span>
                </div>
            </form>
        </div>

        <!-- ========================================== -->
        <!-- STEP 3: STATUS VERIFIKASI & TTE -->
        <!-- ========================================== -->
        <?php if ($is_edit): ?>
            <div class="form-card glass-card d-none" id="section-step-3">
                <div class="row g-4 mb-4">
                    <!-- Card 1: Informasi Berkas (Blue Header) -->
                    <div class="col-md-6">
                        <div class="card border-0 h-100" style="background: rgba(255, 255, 255, 0.02); border: 1px solid var(--border-color) !important; border-radius: 12px; overflow: hidden;">
                            <div class="card-header py-3 px-4" style="background: #0d6efd; border-bottom: 1px solid var(--border-color);">
                                <h5 class="mb-0 text-white fw-bold font-heading" style="font-size: 1.05rem;"><i class="fa-solid fa-folder me-2"></i>Informasi Berkas</h5>
                            </div>
                            <div class="card-body py-4 text-white">
                                <div class="d-flex align-items-center mb-4">
                                    <div class="bg-secondary rounded-circle p-1 d-inline-flex align-items-center justify-content-center me-3" style="width: 70px; height: 70px; overflow: hidden; border: 3px solid rgba(255,255,255,0.08);">
                                        <?php 
                                        $logoPath = 'uploads/ormas/' . $pendaftaran['file_logo'];
                                        $isImage = (!empty($pendaftaran['file_logo']) && preg_match('/\.(webp|jpg|jpeg|png|gif)$/i', $pendaftaran['file_logo']) && file_exists(ROOTPATH . 'public/' . $logoPath));
                                        if ($isImage): ?>
                                            <img src="<?= base_url($logoPath) ?>" style="width: 100%; height: 100%; object-fit: cover;">
                                        <?php else: ?>
                                            <i class="fa-solid fa-users fa-2x text-white"></i>
                                        <?php endif; ?>
                                    </div>
                                    <div>
                                        <h5 class="fw-bold mb-0 text-warning"><?= esc($pendaftaran['nama_ormas']) ?></h5>
                                        <span class="text-muted small">Registrasi Ormas (<?= ($tipe === 'Lokal') ? 'Lokal' : 'Berjenjang/Nasional' ?>)</span>
                                    </div>
                                </div>

                                <table class="table table-borderless text-white small mb-0">
                                    <tbody>
                                        <tr>
                                            <th class="text-muted ps-0 py-1.5" style="width: 35%;">Alamat Sekretariat</th>
                                            <td class="py-1.5">: <?= esc($pendaftaran['alamat']) ?></td>
                                        </tr>
                                        <tr>
                                            <th class="text-muted ps-0 py-1.5">Kontak Email</th>
                                            <td class="py-1.5">: <?= esc($pendaftaran['email'] ?: '-') ?></td>
                                        </tr>
                                        <tr>
                                            <th class="text-muted ps-0 py-1.5">Nomor Telepon</th>
                                            <td class="py-1.5">: <?= esc($pendaftaran['telepon'] ?: '-') ?></td>
                                        </tr>
                                        <tr>
                                            <th class="text-muted ps-0 py-1.5">SK Kepengurusan</th>
                                            <td class="py-1.5">: 
                                                <?= !empty($pendaftaran['tgl_sk_kepengurusan']) ? date('d F Y', strtotime($pendaftaran['tgl_sk_kepengurusan'])) : '-' ?>
                                                s/d
                                                <?= !empty($pendaftaran['tgl_sk_kedaluwarsa']) ? date('d F Y', strtotime($pendaftaran['tgl_sk_kedaluwarsa'])) : '-' ?>
                                            </td>
                                        </tr>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>

                    <!-- Card 2: Status & Timeline (Teal Header) -->
                    <div class="col-md-6">
                        <div class="card border-0 h-100" style="background: rgba(255, 255, 255, 0.02); border: 1px solid var(--border-color) !important; border-radius: 12px; overflow: hidden;">
                            <div class="card-header py-3 px-4" style="background: #14b8a6; border-bottom: 1px solid var(--border-color);">
                                <h5 class="mb-0 text-white fw-bold font-heading" style="font-size: 1.05rem;"><i class="fa-solid fa-timeline me-2"></i>Status & Timeline</h5>
                            </div>
                            <div class="card-body py-4 text-white">
                                <table class="table table-borderless text-white small mb-3">
                                    <tbody>
                                        <tr>
                                            <th class="text-muted ps-0 py-1" style="width: 35%;">Status Saat Ini</th>
                                            <td class="py-1">: 
                                                <?php if ($pendaftaran['status_verifikasi'] === 'Pending'): ?>
                                                    <span class="badge bg-warning-subtle text-warning border border-warning-subtle">PENDING / PROSES VERIFIKASI</span>
                                                <?php elseif ($pendaftaran['status_verifikasi'] === 'Approved' && $pendaftaran['progress_percentage'] < 100): ?>
                                                    <span class="badge bg-primary-subtle text-primary border border-primary-subtle">APPROVED / PROSES KEMENDAGRI</span>
                                                <?php elseif ($pendaftaran['status_verifikasi'] === 'Approved' && $pendaftaran['progress_percentage'] == 100): ?>
                                                    <span class="badge bg-success-subtle text-success border border-success-subtle">SUCCESS / TTE SELESAI</span>
                                                <?php elseif ($pendaftaran['status_verifikasi'] === 'Rejected'): ?>
                                                    <span class="badge bg-danger-subtle text-danger border border-danger-subtle">REJECTED / DITOLAK</span>
                                                <?php endif; ?>
                                            </td>
                                        </tr>
                                        <tr>
                                            <th class="text-muted ps-0 py-1">Tanggal Upload</th>
                                            <td class="py-1">: <?= date('d/m/Y H:i', strtotime($pendaftaran['created_at'])) ?></td>
                                        </tr>
                                        <tr>
                                            <th class="text-muted ps-0 py-1">Progres Alur</th>
                                            <td class="py-1 text-warning fw-bold">: <?= $pendaftaran['progress_percentage'] ?>% Selesai</td>
                                        </tr>
                                    </tbody>
                                </table>

                                <!-- Progress Timeline Visual -->
                                <?php
                                $progress = $pendaftaran['progress_percentage'];
                                $status = $pendaftaran['status_verifikasi'];
                                $step1_class = 'completed';
                                $step2_class = '';
                                $step3_class = '';
                                $step4_class = '';
                                
                                if ($status === 'Pending') {
                                    $step1_class = 'active';
                                } elseif ($status === 'Approved' && $progress == 50) {
                                    $step1_class = 'completed';
                                    $step2_class = 'active';
                                } elseif ($status === 'Approved' && $progress == 75) {
                                    $step1_class = 'completed';
                                    $step2_class = 'completed';
                                    $step3_class = 'active';
                                } elseif ($status === 'Approved' && $progress == 100) {
                                    $step1_class = 'completed';
                                    $step2_class = 'completed';
                                    $step3_class = 'completed';
                                    $step4_class = 'completed';
                                }
                                ?>
                                <div class="timeline-steps my-4">
                                    <div class="timeline-progress" style="width: <?= ($progress == 25) ? '0' : (($progress == 50) ? '33' : (($progress == 75) ? '66' : '100')) ?>%;"></div>
                                    <div class="timeline-step <?= $step1_class ?>">
                                        <div class="timeline-icon" style="width:30px; height:30px; font-size:0.75rem;">
                                            <?php if ($step1_class === 'completed'): ?><i class="fa-solid fa-check"></i><?php else: ?>1<?php endif; ?>
                                        </div>
                                        <div class="timeline-label" style="font-size:0.68rem; margin-top:5px; line-height:1.2;">Verifikasi Berkas</div>
                                    </div>
                                    <div class="timeline-step <?= $step2_class ?>">
                                        <div class="timeline-icon" style="width:30px; height:30px; font-size:0.75rem;">
                                            <?php if ($step2_class === 'completed'): ?><i class="fa-solid fa-check"></i><?php else: ?>2<?php endif; ?>
                                        </div>
                                        <div class="timeline-label" style="font-size:0.68rem; margin-top:5px; line-height:1.2;">Validasi Bidang</div>
                                    </div>
                                    <div class="timeline-step <?= $step3_class ?>">
                                        <div class="timeline-icon" style="width:30px; height:30px; font-size:0.75rem;">
                                            <?php if ($step3_class === 'completed'): ?><i class="fa-solid fa-check"></i><?php else: ?>3<?php endif; ?>
                                        </div>
                                        <div class="timeline-label" style="font-size:0.68rem; margin-top:5px; line-height:1.2;">Diajukan ke Kemendagri</div>
                                    </div>
                                    <div class="timeline-step <?= $step4_class ?>">
                                        <div class="timeline-icon" style="width:30px; height:30px; font-size:0.75rem;">
                                            <?php if ($step4_class === 'completed'): ?><i class="fa-solid fa-check"></i><?php else: ?>4<?php endif; ?>
                                        </div>
                                        <div class="timeline-label" style="font-size:0.68rem; margin-top:5px; line-height:1.2;">Selesai</div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Info Box depending on progress percentage -->
                <div class="p-4 rounded border mb-4 text-white" style="background: rgba(255,255,255,0.02); border-color: var(--border-color) !important;">
                    <div class="d-flex align-items-center gap-3">
                        <div class="rounded-circle bg-info-subtle p-3 text-info d-flex align-items-center justify-content-center" style="width: 60px; height: 60px;">
                            <?php if ($progress == 100): ?>
                                <i class="fa-solid fa-circle-check fa-2x text-success animate-bounce"></i>
                            <?php else: ?>
                                <i class="fa-solid fa-hourglass-half fa-2x text-warning fa-spin"></i>
                            <?php endif; ?>
                        </div>
                        <div>
                            <h5 class="fw-bold mb-1 text-white">Status Layanan Saat Ini</h5>
                            <p class="small mb-0 text-muted">
                                <?php if ($progress == 25): ?>
                                    Berkas pendaftaran sedang dalam proses verifikasi oleh admin Kesbangpol. Silakan menunggu...
                                <?php elseif ($progress == 50): ?>
                                    Validasi bidang oleh Kepala Bidang sedang diproses. Silakan menunggu...
                                <?php elseif ($progress == 75): ?>
                                    Dokumen telah disetujui bidang dan sedang diajukan ke Kemendagri untuk penerbitan SKT. Silakan menunggu...
                                <?php elseif ($progress == 100): ?>
                                    Pendaftaran selesai! <?= ($tipe === 'Lokal') ? 'Laporan Tanggapan Keberadaan' : 'Surat Keberadaan' ?> Anda telah diterbitkan. Silakan unduh dokumen resmi Anda di bawah.
                                <?php endif; ?>
                            </p>
                        </div>
                    </div>

                    <?php if ($progress == 100): ?>
                        <div class="mt-4 pt-3 border-top border-secondary border-opacity-10 d-flex justify-content-center">
                            <?php if (!empty($pendaftaran['pdf_tte_path'])): ?>
                                <a href="<?= base_url('uploads/rekomendasi_ormas/' . $pendaftaran['pdf_tte_path']) ?>" target="_blank" class="btn btn-success fw-bold text-white px-4 py-2.5">
                                    <i class="fa-solid fa-cloud-download me-1"></i> Unduh <?= ($tipe === 'Lokal') ? 'Laporan Tanggapan Keberadaan' : 'Surat Keberadaan' ?> Resmi
                                </a>
                            <?php else: ?>
                                <span class="badge bg-secondary text-white p-3"><i class="fa-solid fa-circle-info me-2"></i>Dokumen resmi sedang disinkronisasi oleh Admin.</span>
                            <?php endif; ?>
                        </div>
                    <?php endif; ?>
                </div>

                <!-- Read-only file attachments table -->
                <div class="card mb-4 border-0 animate-fade-in" style="background: rgba(255, 255, 255, 0.02); border: 1px solid var(--border-color) !important; border-radius: 12px; overflow: hidden;">
                    <div class="card-header py-3 px-4" style="background: var(--border-color); border-bottom: 1px solid var(--border-color);">
                        <h5 class="mb-0 text-white fw-bold font-heading" style="font-size: 1.05rem;"><i class="fa-solid fa-paperclip me-2"></i>Berkas Persyaratan yang Telah Diunggah</h5>
                    </div>
                    <div class="table-responsive">
                        <table class="table table-custom mb-0 text-white" style="font-size: 0.85rem;">
                            <thead>
                                <tr style="background: rgba(255, 255, 255, 0.02);">
                                    <th class="text-center" style="width: 5%;">#</th>
                                    <th style="width: 35%;">Jenis Dokumen</th>
                                    <th class="text-center" style="width: 15%;">Ukuran File</th>
                                    <th class="text-center" style="width: 25%;">Status Verifikasi</th>
                                    <th class="text-center" style="width: 20%;">Tautan Unduh</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php 
                                $activeReqs = ($tipe === 'Lokal') ? $requirementsLokal : $requirementsBerjenjang;
                                foreach ($activeReqs as $idx => $req):
                                    if (isset($req['isPengurus']) && $req['isPengurus']) continue;
                                    $fileIdx = $idx + 1;
                                    $exist = $existingFiles[$fileIdx] ?? null;
                                ?>
                                    <tr>
                                        <td class="text-center align-middle"><?= $fileIdx ?></td>
                                        <td class="align-middle">
                                            <div class="fw-semibold text-main small"><?= $req['name'] ?></div>
                                            <div class="text-muted" style="font-size: 0.75rem;"><?= $req['desc'] ?></div>
                                        </td>
                                        <td class="text-center align-middle text-muted small">
                                            <?= $exist ? $exist['size'] : '-' ?>
                                        </td>
                                        <td class="text-center align-middle">
                                            <?php if ($exist): ?>
                                                <?php 
                                                $docStatus = $exist['status'] ?? 'pending';
                                                if ($docStatus === 'verified'): ?>
                                                    <span class="badge bg-success-subtle text-success border border-success-subtle px-2.5 py-1 rounded"><i class="fa-solid fa-circle-check me-1"></i> Terverifikasi</span>
                                                <?php elseif ($docStatus === 'rejected'): ?>
                                                    <span class="badge bg-danger-subtle text-danger border border-danger-subtle px-2.5 py-1 rounded"><i class="fa-solid fa-circle-xmark me-1"></i> Ditolak</span>
                                                <?php else: ?>
                                                    <span class="badge bg-warning-subtle text-warning border border-warning-subtle px-2.5 py-1 rounded"><i class="fa-solid fa-clock me-1"></i> Sedang Diperiksa</span>
                                                <?php endif; ?>
                                            <?php else: ?>
                                                <span class="text-muted small">-</span>
                                            <?php endif; ?>
                                        </td>
                                        <td class="text-center align-middle">
                                            <?php if ($exist): ?>
                                                <a href="<?= base_url('uploads/ormas/' . $exist['filename']) ?>" target="_blank" class="btn btn-sm btn-outline-info"><i class="fa-solid fa-file-pdf me-1"></i> Buka File</a>
                                            <?php else: ?>
                                                <span class="text-danger small"><i class="fa-solid fa-circle-xmark me-1"></i> Belum Diunggah</span>
                                            <?php endif; ?>
                                        </td>
                                    </tr>
                                <?php endforeach; ?>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        <?php endif; ?>
    </div>
</div>

<?= $this->endSection() ?>

<?= $this->section('scripts') ?>
<script src="https://unpkg.com/leaflet@1.9.4/dist/leaflet.js" crossorigin=""></script>
<script>
const existingFiles = <?= json_encode($existingFiles) ?>;

const requirementsLokal = [
    { name: "Surat Permohonan", desc: "Surat Permohonan ditujukan kepada Menteri (Cq. Kaban Kesbangpol)", tte: true, template: "https://drive.google.com/uc?export=download&id=1XqCYdQYp87AXN4RGMvJqJKslvA05nRNR" },
    { name: "AD & ART", desc: "Anggaran Dasar (AD) & Anggaran Rumah Tangga (ART)", tte: true, template: "" },
    { name: "Akta Notaris", desc: "Akta Pendirian Notaris (memuat Nama, Lambang, Asas, Tujuan, Pengurus, Hak, Keuangan, dll.)", tte: true, template: "" },
    { name: "Surat Pernyataan Keabsahan", desc: "Surat Pernyataan Keabsahan Dokumen (Meterai Rp 10.000)", tte: true, template: "https://drive.google.com/uc?export=download&id=1XqCYdQYp87AXN4RGMvJqJKslvA05nRNR" },
    { name: "Program & Struktur Kerja", desc: "Program Kerja Organisasi & Struktur Organisasi Resmi", tte: true, template: "" },
    { name: "Domisili Kantor", desc: "Surat Keterangan Domisili Kantor Sekretariat", tte: true, template: "" },
    { name: "NPWP Organisasi", desc: "NPWP atas nama Organisasi", tte: false, template: "" },
    { name: "Formulir Isian Data Ormas", desc: "Formulir Isian Data Ormas (ditandatangani Ketua & Sekretaris)", tte: true, template: "https://drive.google.com/uc?export=download&id=1XqCYdQYp87AXN4RGMvJqJKslvA05nRNR" },
    { name: "Rekomendasi Kementerian", desc: "Surat Rekomendasi Kementerian Agama (Ormas Agama) / Kebudayaan", tte: true, template: "" },
    { name: "Biodata & KTP Pengurus", desc: "Biodata & KTP Pengurus (Ketua, Sekretaris, Bendahara)", tte: false, template: "", isPengurus: true },
    { name: "Pasfoto Pengurus", desc: "Pasfoto Pengurus 4x6 cm 2 Lembar (Latar Merah)", tte: false, template: "", isPengurus: true },
    { name: "SK & Foto Sekretariat", desc: "SK Pengurus & Foto Sekretariat (Tampak depan menampilkan Papan Nama)", tte: false, template: "" },
    { name: "Kontrak/Izin Pakai Gedung", desc: "Surat Perjanjian Kontrak/Izin Pakai Gedung dari Pemilik Gedung", tte: true, template: "" },
    { name: "Rekening & Logo Organisasi", desc: "Nomor Rekening Organisasi & File Logo Organisasi", tte: false, template: "" }
];

const requirementsBerjenjang = [
    { name: "Surat Permohonan", desc: "Surat Permohonan ditujukan kepada Kepala Badan Kesbangpol Kab. Sinjai", tte: true, template: "<?= base_url('uploads/templates/Persyaratan_Ormas_Berjenjang_2026.docx') ?>" },
    { name: "Surat Pernyataan Resmi", desc: "Surat Pernyataan Resmi (Memuat 6 poin pernyataan, Meterai Rp 10.000)", tte: true, template: "<?= base_url('uploads/templates/Persyaratan_Ormas_Berjenjang_2026.docx') ?>" },
    { name: "SK Kemenkumham", desc: "Surat Keputusan (SK) Kemenkumham RI", tte: true, template: "" },
    { name: "Surat Keterangan Domisili", desc: "Surat Keterangan Domisili (Alamat domisili kop surat & sekretariat)", tte: true, template: "" },
    { name: "Formulir Isian Data Ormas", desc: "Formulir Isian Data Ormas (ditandatangani Ketua & Sekretaris)", tte: true, template: "<?= base_url('uploads/templates/Persyaratan_Ormas_Berjenjang_2026.docx') ?>" },
    { name: "Pasfoto Pengurus", desc: "Pasfoto Pengurus ukuran 4x6 cm sebanyak 2 lembar", tte: false, template: "", isPengurus: true },
    { name: "Fotokopi KTP Pengurus", desc: "Fotokopi KTP Pengurus (Ketua, Sekretaris, Bendahara)", tte: false, template: "", isPengurus: true },
    { name: "Surat Keputusan (SK) Pengurus", desc: "Surat Keputusan (SK) Pengurus Organisasi", tte: false, template: "" },
    { name: "Foto Sekretariat", desc: "Foto Sekretariat (Tampak depan menampilkan Papan Nama resmi)", tte: false, template: "" },
    { name: "Dokumen Pendukung Tambahan", desc: "Dokumen pendukung legalitas tambahan lainnya (ZIP/PDF)", tte: false, template: "" }
];

/**
 * Validasi semua berkas wajib sebelum form dikirim.
 * Ormas Lokal  : 14 berkas (tanpa isPengurus)
 * Ormas Berjenjang : 10 berkas (tanpa isPengurus)
 */
function validateAndSubmitBerkas() {
    // Baca tipe dari Step 2 hidden field (paling akurat)
    const step2Hidden = document.getElementById('tipe_ormas_step2');
    const step1Select = document.getElementById('tipe_ormas');
    const tipeOrmas = (step2Hidden ? step2Hidden.value : null) || (step1Select ? step1Select.value : 'Lokal') || 'Lokal';
    const activeReqs = tipeOrmas === 'Lokal' ? requirementsLokal : requirementsBerjenjang;
    const alertDiv = document.getElementById('berkas-validation-alert');
    const alertMsg = document.getElementById('berkas-validation-msg');
    
    const missing = [];

    activeReqs.forEach((req, idx) => {
        if (req.isPengurus) return; // Berkas pengurus divalidasi terpisah
        const fileIdx = idx + 1;
        const fileInput = document.querySelector(`input[name="file_berkas_${fileIdx}"]`);
        const hasExist = existingFiles[fileIdx] !== undefined && existingFiles[fileIdx] !== null;
        const hasChosen = fileInput && fileInput.files && fileInput.files.length > 0;

        if (!hasExist && !hasChosen) {
            missing.push(`#${fileIdx} — ${req.name}`);
        }
    });

    if (missing.length > 0) {
        const listHtml = missing.map(m => `<li>${m}</li>`).join('');
        alertMsg.innerHTML = `Masih ada <b>${missing.length} berkas</b> yang belum diunggah. Wajib melengkapi semua persyaratan sebelum mengirim:<ul class="mt-2 mb-0 ps-3">${listHtml}</ul>`;
        alertDiv.classList.remove('d-none');
        alertDiv.scrollIntoView({ behavior: 'smooth', block: 'nearest' });
        return false;
    }

    // Semua berkas sudah ada — submit form
    alertDiv.classList.add('d-none');
    document.querySelector('#section-step-2 form').submit();
}

function handleFileInputChange(input, index) {
    const fileChosenSpan = document.querySelector(`.file-chosen-name-${index}`);
    if (input.files && input.files[0]) {
        fileChosenSpan.innerText = input.files[0].name.substring(0, 15) + (input.files[0].name.length > 15 ? '...' : '');
        fileChosenSpan.classList.remove('d-none');
    } else {
        fileChosenSpan.innerText = '';
        fileChosenSpan.classList.add('d-none');
    }
    updateFormProgress();
}

function renderValidationTable(tipe) {
    const tableBody = document.getElementById('validation-table-body');
    if (!tableBody) return;
    tableBody.innerHTML = '';
    const activeReqs = tipe === 'Lokal' ? requirementsLokal : requirementsBerjenjang;

    activeReqs.forEach((req, idx) => {
        if (req.isPengurus) return; // Skip rendering
        const fileIdx = idx + 1;
        const exist = existingFiles[fileIdx] || null;
        
        let statusBadge = `<span class="badge bg-danger-subtle text-danger border border-danger-subtle small"><i class="fa-solid fa-circle-xmark me-1"></i> Belum Ada</span>`;
        let tteBadge = req.tte ? `<span class="badge bg-success-subtle text-success border border-success-subtle px-2 py-0.5" style="font-size: 0.72rem;"><i class="fa-solid fa-signature me-1"></i> TTE</span>` : `<span class="badge bg-secondary-subtle text-secondary border border-secondary border-opacity-25 px-2 py-0.5" style="font-size: 0.72rem;">Non TTE</span>`;
        let keterangan = exist ? `Size: ${exist.size}` : '-';
        let fileCol = exist ? `<a href="<?= base_url('uploads/ormas') ?>/${exist.filename}" target="_blank" class="text-info text-decoration-none text-truncate d-inline-block" style="max-width:180px;" title="${exist.filename}"><i class="fa-solid fa-file-pdf me-1"></i> ${exist.filename.substring(0, 15)}...</a>` : '-';
        
        if (exist) {
            statusBadge = `<span class="badge bg-success-subtle text-success border border-success-subtle small"><i class="fa-solid fa-check me-1"></i> Ada</span>`;
        }

        const row = document.createElement('tr');
        row.innerHTML = `
            <td class="text-center align-middle">${fileIdx}</td>
            <td class="align-middle">
                <div class="fw-semibold text-main small">${req.name}</div>
                <div class="text-muted" style="font-size: 0.75rem;">${req.desc}</div>
            </td>
            <td class="text-center align-middle">${statusBadge}</td>
            <td class="text-center align-middle">${tteBadge}</td>
            <td class="text-center align-middle text-muted small">${keterangan}</td>
            <td class="text-center align-middle">${fileCol}</td>
            <td class="text-center align-middle">
                ${req.template ? `<a href="${req.template}" target="_blank" class="btn btn-sm btn-outline-warning py-1 px-2" style="font-size: 0.7rem;" title="Download Format ${req.name}"><i class="fa-solid fa-download me-1"></i> Format</a>` : `<span class="text-muted small">-</span>`}
            </td>
            <td class="align-middle">
                <div class="d-flex align-items-center gap-2">
                    <label class="btn btn-sm btn-outline-secondary mb-0 py-1 px-2.5" style="cursor: pointer; font-size: 0.72rem;">
                        <i class="fa-solid fa-cloud-arrow-up me-1"></i> Pilih File
                        <input type="file" name="file_berkas_${fileIdx}" class="d-none berkas-file-input" data-index="${fileIdx}" accept=".pdf,.zip" onchange="handleFileInputChange(this, ${fileIdx})">
                    </label>
                    <span class="file-chosen-name-${fileIdx} small text-success fw-bold text-truncate d-none" style="max-width: 120px;"></span>
                </div>
            </td>
        `;
        tableBody.appendChild(row);
    });
}

function handlePengurusFileChange(input, type, index) {
    const span = document.querySelector(`.file-name-${type}-${index}`);
    if (span) {
        if (input.files && input.files[0]) {
            span.innerHTML = `<span class="text-success fw-bold"><i class="fa-solid fa-check"></i> ${input.files[0].name.substring(0, 8)}${input.files[0].name.length > 8 ? '...' : ''}</span>`;
        } else {
            span.innerHTML = `<span class="text-muted text-opacity-50">Kosong</span>`;
        }
    }
}

function handlePasfotoChange(input, index) {
    const preview = document.getElementById(`avatar-preview-${index}`);
    const placeholder = document.getElementById(`avatar-placeholder-${index}`);
    const span = document.querySelector(`.file-name-pasfoto-${index}`);

    if (input.files && input.files[0]) {
        const reader = new FileReader();
        reader.onload = function(e) {
            if (preview) {
                preview.src = e.target.result;
                preview.classList.remove('d-none');
            }
            if (placeholder) {
                placeholder.classList.add('d-none');
            }
        };
        reader.readAsDataURL(input.files[0]);
        if (span) {
            span.innerHTML = `<span class="text-success fw-bold"><i class="fa-solid fa-check"></i> ${input.files[0].name.substring(0, 8)}${input.files[0].name.length > 8 ? '...' : ''}</span>`;
        }
    }
}

function addPengurusRow() {
    const container = document.getElementById('pengurus-container');
    const tr = document.createElement('tr');
    tr.className = 'pengurus-row';
    tr.innerHTML = `
        <td>
            <input type="hidden" name="pengurus_id[]" value="">
            <input type="hidden" name="pengurus_old_ktp[]" value="">
            <input type="hidden" name="pengurus_old_pasfoto[]" value="">
            <input type="hidden" name="pengurus_old_biodata[]" value="">
            <input type="text" name="pengurus_jabatan[]" class="form-control form-control-custom form-control-sm" placeholder="Contoh: Anggota" required>
        </td>
        <td>
            <input type="text" name="pengurus_nama[]" class="form-control form-control-custom form-control-sm" placeholder="Nama Lengkap" required>
        </td>
        <td>
            <input type="text" name="pengurus_no_hp[]" class="form-control form-control-custom form-control-sm" placeholder="Contoh: 0812...">
        </td>
        <td class="text-center">
            <button type="button" class="btn btn-sm btn-outline-danger border-0 rounded-circle text-danger" onclick="removePengurusRow(this)">
                <i class="fa-solid fa-trash-can"></i>
            </button>
        </td>
    `;
    container.appendChild(tr);
}

function removePengurusRow(btn) {
    const rows = document.querySelectorAll('.pengurus-row');
    if (rows.length <= 1) {
        alert('Minimal harus ada 1 orang pengurus!');
        return;
    }
    btn.closest('tr').remove();
}

function toggleOrmasRequirements(value) {
    renderValidationTable(value);
}

function goToStep(step) {
    // Hide all step sections
    document.getElementById('section-step-1').classList.add('d-none');
    document.getElementById('section-step-2').classList.add('d-none');
    const step3 = document.getElementById('section-step-3');
    if (step3) step3.classList.add('d-none');

    // Reset step indicator styles
    for (let i = 1; i <= 3; i++) {
        const ind = document.getElementById(`step-ind-${i}`);
        const num = ind.querySelector('.step-num');
        const lbl = document.getElementById(`step-lbl-${i}`);
        
        num.className = 'step-num bg-secondary text-white rounded-circle d-inline-flex align-items-center justify-content-center fw-bold mb-1';
        lbl.className = 'small fw-semibold d-block text-muted';
    }

    // Set active step
    const activeSection = document.getElementById(`section-step-${step}`);
    if (activeSection) {
        activeSection.classList.remove('d-none');
    }

    // Highlight active and completed indicators
    for (let i = 1; i <= step; i++) {
        const ind = document.getElementById(`step-ind-${i}`);
        const num = ind.querySelector('.step-num');
        const lbl = document.getElementById(`step-lbl-${i}`);

        if (i === step) {
            num.className = 'step-num bg-primary text-white rounded-circle d-inline-flex align-items-center justify-content-center fw-bold mb-1';
            lbl.className = 'small fw-semibold d-block text-white';
        } else {
            num.className = 'step-num bg-success text-white rounded-circle d-inline-flex align-items-center justify-content-center fw-bold mb-1';
            num.innerHTML = '<i class="fa-solid fa-check"></i>';
            lbl.className = 'small fw-semibold d-block text-success';
        }
    }
}

// Live Progress Calculation
function updateFormProgress() {
    let progress = 0;

    // --- SECTION 1: Pengisian Field Data (Maks 50%) ---
    const namaOrmas = document.getElementById('nama_ormas')?.value || '';
    if (namaOrmas.trim().length > 2) progress += 10;

    const alamat = document.getElementById('alamat')?.value || '';
    if (alamat.trim().length > 5) progress += 10;

    const email = document.getElementById('email')?.value || '';
    const telepon = document.getElementById('telepon')?.value || '';
    if (email.trim().length > 4) progress += 5;
    if (telepon.trim().length > 5) progress += 5;

    const latVal = document.getElementById('latitude')?.value || '';
    const lngVal = document.getElementById('longitude')?.value || '';
    if (latVal !== '' && lngVal !== '') progress += 10;

    const tglSk = document.getElementById('tgl_sk_kepengurusan')?.value || '';
    const tglExp = document.getElementById('tgl_sk_kedaluwarsa')?.value || '';
    if (tglSk !== '') progress += 5;
    if (tglExp !== '') progress += 5;

    // --- SECTION 2: Kelengkapan Berkas (Maks 50%) ---
    const tipeOrmas = document.getElementById('tipe_ormas')?.value || 'Lokal';
    const activeReqs = tipeOrmas === 'Lokal' ? requirementsLokal : requirementsBerjenjang;
    const actualReqs = activeReqs.filter(r => !r.isPengurus);
    const totalFilesToUpload = actualReqs.length;
    let filesUploadedCount = 0;

    actualReqs.forEach((req) => {
        const fileIdx = activeReqs.indexOf(req) + 1;
        const fileInput = document.querySelector(`input[name="file_berkas_${fileIdx}"]`);
        const hasExist = existingFiles[fileIdx] !== undefined && existingFiles[fileIdx] !== null;
        const hasChosen = fileInput && fileInput.files && fileInput.files.length > 0;
        if (hasExist || hasChosen) {
            filesUploadedCount++;
        }
    });

    const documentProgress = Math.round((filesUploadedCount / totalFilesToUpload) * 50);
    progress += documentProgress;

    // Update UI Progress Bar
    const progressBarFill = document.getElementById('progress-bar-fill');
    const progressLabel = document.getElementById('progress-percentage-label');
    const spinner = document.getElementById('progress-spinner');

    if (progressBarFill && progressLabel) {
        if (progress > 100) progress = 100;
        progressBarFill.style.width = progress + '%';
        progressBarFill.setAttribute('aria-valuenow', progress);
        progressLabel.innerText = progress + '% Lengkap';

        // Adjust color classes
        progressBarFill.className = 'progress-bar progress-bar-striped progress-bar-animated';
        progressLabel.className = 'badge fw-bold';

        if (progress < 40) {
            progressBarFill.classList.add('bg-danger');
            progressLabel.classList.add('bg-danger', 'text-white');
        } else if (progress < 80) {
            progressBarFill.classList.add('bg-warning');
            progressLabel.classList.add('bg-warning', 'text-dark');
        } else {
            progressBarFill.classList.add('bg-success');
            progressLabel.classList.add('bg-success', 'text-white');
            if (spinner) {
                spinner.className = 'fa-solid fa-circle-check me-2 text-success animate-pulse';
            }
        }
    }
}

document.addEventListener('DOMContentLoaded', function() {
    const latInput = document.getElementById('latitude');
    const lngInput = document.getElementById('longitude');

    let initialLat = latInput.value ? parseFloat(latInput.value) : -5.1489;
    let initialLng = lngInput.value ? parseFloat(lngInput.value) : 120.1294;

    const centerCoords = [initialLat, initialLng];

    let map = null;
    let marker = null;

    function bindMarkerEvents(m) {
        if (typeof L !== 'undefined') {
            m.on('dragend', function(event) {
                const position = event.target.getLatLng();
                latInput.value = position.lat.toFixed(6);
                lngInput.value = position.lng.toFixed(6);
                updateFormProgress();
                performReverseGeocoding(position.lat, position.lng);
            });
        }
    }

    if (typeof L !== 'undefined') {
        try {
            const osm = L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
                maxZoom: 19,
                attribution: '© OpenStreetMap contributors'
            });

            const satellite = L.tileLayer('https://server.arcgisonline.com/ArcGIS/rest/services/World_Imagery/MapServer/tile/{z}/{y}/{x}', {
                maxZoom: 19,
                attribution: 'Tiles &copy; Esri &mdash; Source: Esri, i-cubed, USDA, USGS, AEX, GeoEye, Getmapping, Aerogrid, IGN, IGP, UPR-EGP, and the GIS User Community'
            });

            const terrain = L.tileLayer('https://{s}.tile.opentopomap.org/{z}/{x}/{y}.png', {
                maxZoom: 17,
                attribution: 'Map data: &copy; OpenStreetMap contributors, SRTM | Map style: &copy; OpenTopoMap (CC-BY-SA)'
            });

            map = L.map('form-map', {
                center: centerCoords,
                zoom: 13,
                layers: [osm]
            });

            const baseMaps = {
                "Peta Standar (OSM)": osm,
                "Satelit (Esri)": satellite,
                "Topografi (TopoMap)": terrain
            };

            L.control.layers(baseMaps).addTo(map);

            if (latInput.value && lngInput.value) {
                marker = L.marker(centerCoords, { draggable: true }).addTo(map);
                bindMarkerEvents(marker);
            }

            map.on('click', function(e) {
                const lat = e.latlng.lat.toFixed(6);
                const lng = e.latlng.lng.toFixed(6);
                latInput.value = lat;
                lngInput.value = lng;
                
                if (marker) {
                    marker.setLatLng(e.latlng);
                } else {
                    marker = L.marker(e.latlng, { draggable: true }).addTo(map);
                    bindMarkerEvents(marker);
                }
                updateFormProgress();
                performReverseGeocoding(e.latlng.lat, e.latlng.lng);
            });
        } catch (mapErr) {
            console.error("Gagal inisialisasi peta:", mapErr);
        }
    } else {
        console.warn("Leaflet tidak terdeteksi. Peta dinonaktifkan.");
        const mapContainer = document.getElementById('form-map');
        if (mapContainer) {
            mapContainer.innerHTML = '<div class="alert alert-warning m-0 p-3 rounded" style="background: rgba(234,179,8,0.1); border: 1px solid rgba(234,179,8,0.2); color: #fef08a;"><i class="fa-solid fa-triangle-exclamation me-2"></i>Koneksi internet offline. Peta lokasi tidak dapat dimuat. Anda masih dapat mengisi koordinat secara manual atau menyimpan formulir.</div>';
        }
    }

    // Auto-Date Calculation for Ormas Berjenjang (Maksimal 2 Tahun)
    const tipeOrmasEl = document.getElementById('tipe_ormas');
    const tglMulaiEl = document.getElementById('tgl_sk_kepengurusan');
    const tglExpEl = document.getElementById('tgl_sk_kedaluwarsa');

    function handleOrmasDateCalculation() {
        if (!tipeOrmasEl || !tglMulaiEl || !tglExpEl) return;
        
        if (tipeOrmasEl.value === 'Berjenjang') {
            if (tglMulaiEl.value) {
                const startDate = new Date(tglMulaiEl.value);
                startDate.setFullYear(startDate.getFullYear() + 2);
                
                const yyyy = startDate.getFullYear();
                let mm = startDate.getMonth() + 1;
                let dd = startDate.getDate();
                if (mm < 10) mm = '0' + mm;
                if (dd < 10) dd = '0' + dd;
                
                tglExpEl.value = `${yyyy}-${mm}-${dd}`;
            }
            tglExpEl.readOnly = true;
            tglExpEl.style.opacity = '0.7';
        } else {
            tglExpEl.readOnly = false;
            tglExpEl.style.opacity = '1';
        }
    }

    if (tipeOrmasEl && tglMulaiEl && tglExpEl) {
        tipeOrmasEl.addEventListener('change', handleOrmasDateCalculation);
        tglMulaiEl.addEventListener('change', handleOrmasDateCalculation);
        tglMulaiEl.addEventListener('input', handleOrmasDateCalculation);
        handleOrmasDateCalculation();
    }

    latInput.addEventListener('change', updateMarkerFromInputs);
    lngInput.addEventListener('change', updateMarkerFromInputs);

    function updateMarkerFromInputs() {
        const lat = parseFloat(latInput.value);
        const lng = parseFloat(lngInput.value);
        if (!isNaN(lat) && !isNaN(lng)) {
            if (typeof L !== 'undefined' && map) {
                const newLatLng = L.latLng(lat, lng);
                if (marker) {
                    marker.setLatLng(newLatLng);
                } else {
                    marker = L.marker(newLatLng, { draggable: true }).addTo(map);
                    bindMarkerEvents(marker);
                }
                map.panTo(newLatLng);
            }
            updateFormProgress();
        }
    }

    // Auto-geocoding ketika mengetik alamat kantor sekretariat
    const alamatTextarea = document.getElementById('alamat');
    const geocodeStatus = document.getElementById('geocode-status');
    const btnGeocode = document.getElementById('btn-geocode');
    let geocodeTimeout = null;

    function performGeocoding(query, isManual) {
        if (!query || query.length < 5) {
            if (isManual) {
                geocodeStatus.innerHTML = '<span class="text-warning"><i class="fa-solid fa-circle-info"></i> Masukkan alamat minimal 5 karakter.</span>';
            }
            return;
        }

        // Set loading state
        geocodeStatus.innerHTML = '<span class="text-info"><i class="fa-solid fa-spinner fa-spin"></i> Sedang melacak lokasi...</span>';
        btnGeocode.disabled = true;
        const originalBtnHTML = btnGeocode.innerHTML;
        btnGeocode.innerHTML = '<i class="fa-solid fa-spinner fa-spin me-1"></i> Melacak...';

        fetch(`<?= base_url('user/geocode') ?>?q=${encodeURIComponent(query)}`)
            .then(response => response.json())
            .then(data => {
                if (data && data.length > 0) {
                    const lat = parseFloat(data[0].lat);
                    const lon = parseFloat(data[0].lon);
                    
                    latInput.value = lat.toFixed(6);
                    lngInput.value = lon.toFixed(6);
                    
                    const newLatLng = L.latLng(lat, lon);
                    if (marker) {
                        marker.setLatLng(newLatLng);
                    } else {
                        marker = L.marker(newLatLng, { draggable: true }).addTo(map);
                        bindMarkerEvents(marker);
                    }
                    map.setView(newLatLng, 15);
                    geocodeStatus.innerHTML = '<span class="text-success"><i class="fa-solid fa-circle-check"></i> Lokasi berhasil dideteksi!</span>';
                    updateFormProgress();
                } else {
                    geocodeStatus.innerHTML = '<span class="text-danger"><i class="fa-solid fa-circle-xmark"></i> Lokasi tidak ditemukan. Silakan tentukan manual pada peta.</span>';
                }
            })
            .catch(error => {
                console.error('Error during geocoding:', error);
                geocodeStatus.innerHTML = '<span class="text-danger"><i class="fa-solid fa-circle-xmark"></i> Gagal menghubungi layanan geocoding.</span>';
            })
            .finally(() => {
                btnGeocode.disabled = false;
                btnGeocode.innerHTML = originalBtnHTML;
            });
    }

    if (alamatTextarea) {
        alamatTextarea.addEventListener('input', function() {
            clearTimeout(geocodeTimeout);
            geocodeTimeout = setTimeout(() => {
                performGeocoding(alamatTextarea.value, false);
            }, 1500); // Debounce 1.5 seconds
        });
    }

    if (btnGeocode) {
        btnGeocode.addEventListener('click', function() {
            performGeocoding(alamatTextarea.value || '', true);
        });
    }

    function performReverseGeocoding(lat, lng) {
        if (!lat || !lng) return;
        geocodeStatus.innerHTML = '<span class="text-info"><i class="fa-solid fa-spinner fa-spin"></i> Memperbarui alamat dari peta...</span>';
        fetch(`<?= base_url('user/reverse-geocode') ?>?lat=${lat}&lng=${lng}`)
            .then(res => res.json())
            .then(data => {
                if (data && data.display_name) {
                    alamatTextarea.value = data.display_name;
                    geocodeStatus.innerHTML = '<span class="text-success"><i class="fa-solid fa-circle-check"></i> Alamat disesuaikan dari peta!</span>';
                    updateFormProgress();
                } else {
                    geocodeStatus.innerHTML = '';
                }
            })
            .catch(err => {
                console.error(err);
                geocodeStatus.innerHTML = '';
            });
    }

    // Initialize Active Step
    goToStep(<?= $activeStep ?>);

    // Call toggle initial requirements
    if (tipeOrmasEl) {
        toggleOrmasRequirements(tipeOrmasEl.value);
    }

    // Initial progress calculation
    updateFormProgress();
});
</script>
<?= $this->endSection() ?>
