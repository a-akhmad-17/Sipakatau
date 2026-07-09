<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title><?= esc($title) ?></title>
    <style>
        body {
            background-color: #ffffff;
            color: #000000;
            font-family: 'Times New Roman', Times, serif;
            font-size: 10pt;
            line-height: 1.4;
            margin: 30px;
        }
        .header-kop {
            text-align: center;
            border-bottom: 3px double #000000;
            padding-bottom: 10px;
            margin-bottom: 25px;
        }
        .header-kop h2 {
            font-size: 14pt;
            margin: 0;
            text-transform: uppercase;
            font-weight: bold;
        }
        .header-kop h3 {
            font-size: 12pt;
            margin: 5px 0 0 0;
            text-transform: uppercase;
            font-weight: bold;
        }
        .header-kop p {
            font-size: 9pt;
            margin: 5px 0 0 0;
            font-style: italic;
        }
        .title-laporan {
            text-align: center;
            font-size: 12pt;
            font-weight: bold;
            text-transform: uppercase;
            text-decoration: underline;
            margin-bottom: 25px;
        }
        h4 {
            font-size: 10pt;
            margin: 15px 0 5px 0;
            text-transform: uppercase;
            font-weight: bold;
        }
        table {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 20px;
            font-size: 10pt;
        }
        table, th, td {
            border: 1px solid #000000;
        }
        th {
            background-color: #f2f2f2;
            text-align: center;
            font-weight: bold;
            padding: 8px;
            text-transform: uppercase;
        }
        td {
            padding: 8px;
            vertical-align: top;
        }
        .text-center {
            text-align: center;
        }
        .text-right {
            text-align: right;
        }
        .fw-bold {
            font-weight: bold;
        }
        .signature-section {
            margin-top: 40px;
            display: flex;
            justify-content: flex-end;
        }
        .signature-box {
            text-align: center;
            width: 300px;
        }
        .signature-space {
            height: 70px;
        }
        .btn-print-action {
            background-color: #be123c;
            color: #ffffff;
            border: none;
            padding: 10px 20px;
            font-size: 10pt;
            font-weight: bold;
            cursor: pointer;
            border-radius: 4px;
            margin-bottom: 20px;
            display: inline-flex;
            align-items: center;
            gap: 8px;
        }
        .btn-print-action:hover {
            background-color: #9f1239;
        }
        @media print {
            .no-print {
                display: none !important;
            }
            body {
                margin: 0;
            }
        }
    </style>
</head>
<body>

    <!-- Tombol Aksi Cetak Manual (Hanya muncul di browser, hilang saat dicetak/print) -->
    <div class="no-print" style="text-align: right;">
        <button onclick="window.print();" class="btn-print-action">
            🖨️ Cetak Dokumen
        </button>
    </div>

    <!-- Kop Surat Resmi -->
    <div class="header-kop">
        <h2>Pemerintah Kabupaten Sinjai</h2>
        <h3>Badan Kesatuan Bangsa dan Politik</h3>
        <p>Jl. Sinjai - Watampone, Biringere, Sinjai, Kabupaten Sinjai, Sulawesi Selatan 92600 • Email: kesbangpol@sinjaikab.go.id</p>
    </div>

    <!-- Judul Dokumen -->
    <div class="title-laporan">
        Laporan Kinerja Bulanan & Realisasi Bidang<br>
        Keadaan Tanggal: <?= date('d M Y', strtotime($today)) ?>
    </div>

    <!-- Ringkasan Kinerja Nasional/Total -->
    <h4>I. Ringkasan Kinerja Kumulatif</h4>
    <table>
        <thead>
            <tr>
                <th width="35%">Indikator Kinerja</th>
                <th width="35%">Target / Anggaran</th>
                <th width="20%">Realisasi</th>
                <th width="10%">Persentase</th>
            </tr>
        </thead>
        <tbody>
            <tr>
                <td class="fw-bold">Realisasi Anggaran Keuangan</td>
                <td>Rp<?= number_format($totalTarget, 0, ',', '.') ?></td>
                <td>Rp<?= number_format($totalRealisasi, 0, ',', '.') ?></td>
                <td class="text-center fw-bold"><?= number_format($persentaseKeuangan, 1) ?>%</td>
            </tr>
            <tr>
                <td class="fw-bold">Rata-rata Capaian Fisik</td>
                <td><?= number_format($avgTargetFisik, 1) ?>%</td>
                <td><?= number_format($avgRealisasiFisik, 1) ?>%</td>
                <td class="text-center fw-bold"><?= number_format($persentaseFisik, 1) ?>%</td>
            </tr>
        </tbody>
    </table>

    <!-- Rincian Capaian per Bidang -->
    <h4>II. Rincian Kinerja per Bidang</h4>
    <table>
        <thead>
            <tr>
                <th rowspan="2" valign="middle">Nama Bidang</th>
                <th colspan="3">Realisasi Keuangan</th>
                <th colspan="3">Realisasi Fisik</th>
            </tr>
            <tr>
                <th width="15%">Target (Rp)</th>
                <th width="15%">Realisasi (Rp)</th>
                <th width="8%">%</th>
                <th width="12%">Target Avg</th>
                <th width="12%">Realisasi Avg</th>
                <th width="8%">%</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($bidangKinerja as $bk): 
                $tKeuangan = (double) $bk['target_keuangan'];
                $rKeuangan = (double) $bk['realisasi_keuangan'];
                $pKeuangan = $tKeuangan > 0 ? ($rKeuangan / $tKeuangan) * 100 : 0.0;

                $tFisik = (double) $bk['avg_target_fisik'];
                $rFisik = (double) $bk['avg_realisasi_fisik'];
                $pFisik = $tFisik > 0 ? ($rFisik / $tFisik) * 100 : 0.0;
            ?>
                <tr>
                    <td class="fw-bold"><?= esc($bk['nama_bidang']) ?> (<?= esc($bk['kode_bidang']) ?>)</td>
                    <td class="text-right">Rp<?= number_format($tKeuangan, 0, ',', '.') ?></td>
                    <td class="text-right">Rp<?= number_format($rKeuangan, 0, ',', '.') ?></td>
                    <td class="text-center fw-bold"><?= number_format($pKeuangan, 1) ?>%</td>
                    <td class="text-center"><?= number_format($tFisik, 1) ?>%</td>
                    <td class="text-center"><?= number_format($rFisik, 1) ?>%</td>
                    <td class="text-center fw-bold"><?= number_format($pFisik, 1) ?>%</td>
                </tr>
            <?php endforeach; ?>
        </tbody>
    </table>

    <!-- Laporan Kendala Bidang -->
    <h4>III. Daftar Kendala Kegiatan Bidang</h4>
    <table>
        <thead>
            <tr>
                <th width="5%" class="text-center">No</th>
                <th width="20%">Bidang</th>
                <th width="30%">Nama Kegiatan</th>
                <th width="15%">SPJ Bulan</th>
                <th width="30%">Kendala yang Dihadapi</th>
            </tr>
        </thead>
        <tbody>
            <?php if (empty($kendalaKegiatan)): ?>
                <tr>
                    <td colspan="5" class="text-center italic">Tidak ada kendala bidang yang dilaporkan.</td>
                </tr>
            <?php else: ?>
                <?php $no = 1; foreach ($kendalaKegiatan as $kk): ?>
                    <tr>
                        <td class="text-center"><?= $no++ ?></td>
                        <td class="fw-bold"><?= esc($kk['kode_bidang']) ?></td>
                        <td><?= esc($kk['nama_kegiatan']) ?></td>
                        <td class="text-center"><?= esc($kk['bulan_spj']) ?></td>
                        <td><?= esc($kk['kendala']) ?></td>
                    </tr>
                <?php endforeach; ?>
            <?php endif; ?>
        </tbody>
    </table>

    <!-- Daftar Ormas SK Merah -->
    <h4>IV. Organisasi Kemasyarakatan (SK Tidak Aktif)</h4>
    <table>
        <thead>
            <tr>
                <th width="5%" class="text-center">No</th>
                <th width="40%">Nama Ormas / LSM</th>
                <th width="35%">Alamat & Kontak</th>
                <th width="20%">Tanggal SK Tidak Aktif</th>
            </tr>
        </thead>
        <tbody>
            <?php if (empty($expiredOrmas)): ?>
                <tr>
                    <td colspan="4" class="text-center italic">Semua organisasi terdaftar memiliki SK kepengurusan yang aktif.</td>
                </tr>
            <?php else: ?>
                <?php $no = 1; foreach ($expiredOrmas as $o): ?>
                    <tr>
                        <td class="text-center"><?= $no++ ?></td>
                        <td class="fw-bold"><?= esc($o['nama_ormas']) ?></td>
                        <td>
                            <?= esc($o['alamat']) ?><br>
                            <span style="font-size: 8.5pt;">Telp: <?= esc($o['telepon']) ?> | Email: <?= esc($o['email']) ?></span>
                        </td>
                        <td class="text-center fw-bold" style="color: #ff0000;"><?= date('d-m-Y', strtotime($o['tgl_sk_kedaluwarsa'])) ?></td>
                    </tr>
                <?php endforeach; ?>
            <?php endif; ?>
        </tbody>
    </table>

    <!-- Tanda Tangan Pengesahan -->
    <div class="signature-section">
        <div class="signature-box">
            Sinjai, <?= date('d F Y') ?><br>
            Kepala Badan Kesbangpol Kab. Sinjai,
            <div class="signature-space"></div>
            <strong><u>Muhammad Rusyaid, S.Kom., M.Si.</u></strong><br>
            NIP. 19781024 200501 1 008
        </div>
    </div>

    <!-- Auto-trigger Cetak Browser -->
    <script>
        window.addEventListener('DOMContentLoaded', () => {
            // Beri jeda 1 detik agar browser selesai render CSS cetak
            setTimeout(() => {
                window.print();
            }, 1000);
        });
    </script>
</body>
</html>
