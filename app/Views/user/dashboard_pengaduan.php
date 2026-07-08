<?= $this->extend('layouts/admin') ?>

<?= $this->section('content') ?>
<div class="container-fluid px-0">
    <!-- Header / Breadcrumbs -->
    <div class="d-flex justify-content-between align-items-center mb-4 pb-2 border-bottom" style="border-color: var(--border-color) !important;">
        <div>
            <h3 class="mb-1 font-heading" style="color: var(--text-main);"><i class="fa-solid fa-bullhorn text-danger me-2"></i>Dasbor Portal Pengaduan</h3>
            <p class="small mb-0" style="color: var(--text-muted);">Laporkan pelanggaran ketertiban, konflik sosial, atau aduan layanan Kesbangpol.</p>
        </div>
        <div>
            <a href="<?= base_url('user/pengaduan/baru') ?>" class="btn btn-danger text-white fw-bold btn-portal">
                <i class="fa-solid fa-plus me-1.5"></i>Buat Laporan Aduan Baru
            </a>
        </div>
    </div>

    <!-- Alert status -->
    <?php if (session()->getFlashdata('success')): ?>
        <div class="alert alert-success border-success border-opacity-25 bg-success-subtle text-success py-2.5 px-4 mb-4" style="border-radius: 8px;">
            <i class="fa-solid fa-circle-check me-2"></i><?= session()->getFlashdata('success') ?>
        </div>
    <?php endif; ?>

    <!-- Security Announcement Card -->
    <div class="glass-card p-4 mb-4">
        <div class="d-flex align-items-start gap-3">
            <div class="rounded-circle bg-danger-subtle text-danger p-3 d-flex align-items-center justify-content-center" style="width: 54px; height: 54px; flex-shrink: 0;">
                <i class="fa-solid fa-user-shield fa-lg"></i>
            </div>
            <div>
                <h6 class="text-white fw-bold mb-1">Keamanan & Kerahasiaan Pelapor Dijamin</h6>
                <p class="small text-muted mb-0" style="line-height: 1.5;">Seluruh data laporan pengaduan masyarakat yang diajukan dienkripsi dengan standar pengamanan tinggi. Identitas Anda sebagai pelapor tidak akan dipublikasikan ke pihak luar. Gunakan fasilitas ini secara bijak untuk menjaga keamanan dan ketertiban bersama Kabupaten Sinjai.</p>
            </div>
        </div>
    </div>

    <!-- Riwayat Laporan Pengaduan -->
    <div class="glass-card">
        <div class="d-flex justify-content-between align-items-center mb-4 flex-wrap gap-2">
            <div>
                <h5 class="text-white mb-1"><i class="fa-solid fa-clock-rotate-left text-danger me-2"></i>Riwayat Pengaduan Anda</h5>
                <p class="text-muted small mb-0">Daftar laporan pengaduan yang telah Anda sampaikan melalui portal pengaduan.</p>
            </div>
        </div>

        <div class="table-responsive">
            <table class="table table-custom mb-0" style="font-size:13px;">
                <thead>
                    <tr style="background:rgba(255,255,255,.04); color:var(--text-muted); font-size:11px; letter-spacing:.5px; text-transform:uppercase;">
                        <th style="padding:12px 14px; border-bottom:1px solid var(--border-color); width: 5%;">#</th>
                        <th style="padding:12px 14px; border-bottom:1px solid var(--border-color); width: 35%;">Judul Laporan</th>
                        <th style="padding:12px 14px; border-bottom:1px solid var(--border-color); width: 20%;">Kategori</th>
                        <th style="padding:12px 14px; border-bottom:1px solid var(--border-color); width: 15%; text-align:center;">Status</th>
                        <th style="padding:12px 14px; border-bottom:1px solid var(--border-color); width: 25%; text-align:center;">Lampiran / Keterangan</th>
                    </tr>
                </thead>
                <tbody>
                    <?php if (empty($riwayatPengaduan)): ?>
                        <tr>
                            <td colspan="5" class="text-center text-muted py-4">Belum ada riwayat laporan pengaduan yang dikirimkan.</td>
                        </tr>
                    <?php else: ?>
                        <?php foreach ($riwayatPengaduan as $i => $ad):
                            $adStatus = $ad['status'] ?? 'Pending';
                            $adBadge = match($adStatus) {
                                'Processed' => 'background:rgba(34,197,94,.15); color:#4ade80; border:1px solid rgba(34,197,94,.3);',
                                'Rejected'  => 'background:rgba(239,68,68,.15); color:#f87171; border:1px solid rgba(239,68,68,.3);',
                                default     => 'background:rgba(251,191,36,.15); color:#fbbf24; border:1px solid rgba(251,191,36,.3);',
                            };
                            $adLabel = match($adStatus) {
                                'Processed' => '<i class="fa-solid fa-circle-check me-1"></i>Diproses',
                                'Rejected'  => '<i class="fa-solid fa-circle-xmark me-1"></i>Ditolak',
                                default     => '<i class="fa-solid fa-clock me-1"></i>Menunggu',
                            };
                            
                            $katLabels = [
                                'konflik' => 'Potensi Konflik SARA',
                                'ormas'   => 'Pelanggaran Ormas/LSM',
                                'politik' => 'Pelanggaran Politik',
                                'layanan' => 'Pelayanan Kesbangpol',
                                'lainnya' => 'Lainnya'
                            ];
                            $katText = $katLabels[$ad['kategori']] ?? ucfirst($ad['kategori']);
                        ?>
                            <tr style="border-bottom:1px solid rgba(255,255,255,.04); vertical-align: middle;">
                                <td style="padding:12px 14px; color:var(--text-muted);"><?= $i + 1 ?></td>
                                <td style="padding:12px 14px;">
                                    <div class="fw-semibold text-white"><?= esc($ad['judul']) ?></div>
                                    <div style="font-size:11px; color:var(--text-muted);"><?= date('d M Y H:i', strtotime($ad['created_at'])) ?></div>
                                    <?php if (!empty($ad['deskripsi'])): ?>
                                        <div class="text-muted text-truncate mt-1" style="max-width: 300px; font-size:11px;" title="<?= esc($ad['deskripsi']) ?>">
                                            <?= esc($ad['deskripsi']) ?>
                                        </div>
                                    <?php endif; ?>
                                </td>
                                <td style="padding:12px 14px; color:var(--text-muted);"><?= esc($katText) ?></td>
                                <td style="padding:12px 14px; text-align:center;">
                                    <span class="badge" style="<?= $adBadge ?> border-radius:6px; font-size:11px; padding:4px 10px;">
                                        <?= $adLabel ?>
                                    </span>
                                </td>
                                <td style="padding:12px 14px; text-align:center;">
                                    <div class="d-flex flex-column align-items-center gap-1">
                                        <?php if (!empty($ad['berkas'])): ?>
                                            <a href="<?= base_url('uploads/pengaduan/' . $ad['berkas']) ?>" target="_blank"
                                                style="background:rgba(99,102,241,.12); color:#818cf8; border:1px solid rgba(99,102,241,.25); border-radius:6px; padding:3px 10px; font-size:11.5px; text-decoration:none; display:inline-block;">
                                                <i class="fa-solid fa-file-invoice me-1"></i>Lihat Bukti Lampiran
                                            </a>
                                        <?php endif; ?>
                                        <?php if ($adStatus === 'Rejected' && !empty($ad['alasan_ditolak'])): ?>
                                            <span class="text-danger small" style="font-size: 11px; max-width: 200px; display: inline-block; word-wrap: break-word;" title="<?= esc($ad['alasan_ditolak']) ?>">
                                                Alasan Ditolak: <b><?= esc($ad['alasan_ditolak']) ?></b>
                                            </span>
                                        <?php endif; ?>
                                        <?php if (empty($ad['berkas']) && ($adStatus !== 'Rejected' || empty($ad['alasan_ditolak']))): ?>
                                            <span style="color:var(--text-muted); font-size:12px;">—</span>
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
<?= $this->endSection() ?>
