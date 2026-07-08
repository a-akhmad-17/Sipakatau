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
            line-height: 1.6;
            margin: 40px 50px;
        }
        .header-kop {
            text-align: center;
            border-bottom: 3px double #000000;
            padding-bottom: 8px;
            margin-bottom: 20px;
            position: relative;
        }
        .header-kop h2 {
            font-size: 14pt;
            margin: 0;
            text-transform: uppercase;
            font-weight: bold;
            letter-spacing: 0.5px;
        }
        .header-kop h3 {
            font-size: 12pt;
            margin: 3px 0 0 0;
            text-transform: uppercase;
            font-weight: bold;
        }
        .header-kop p {
            font-size: 9pt;
            margin: 5px 0 0 0;
            font-style: italic;
        }
        .meta-section {
            width: 100%;
            margin-bottom: 25px;
            font-size: 10pt;
        }
        .meta-section td {
            vertical-align: top;
            padding: 2px 0;
        }
        .meta-section td.label-col {
            width: 12%;
        }
        .meta-section td.colon-col {
            width: 3%;
            text-align: center;
        }
        .meta-section td.value-col {
            width: 45%;
        }
        .meta-section td.date-col {
            width: 40%;
            text-align: right;
        }
        .recipient-section {
            margin-bottom: 20px;
            font-size: 10pt;
        }
        .recipient-title {
            font-weight: bold;
            margin-bottom: 5px;
        }
        .content-section {
            text-align: justify;
            margin-bottom: 15px;
            text-indent: 30px;
        }
        table.detail-table {
            width: 100%;
            border-collapse: collapse;
            margin: 15px 0;
            font-size: 10pt;
        }
        table.detail-table td {
            padding: 5px 4px;
            vertical-align: top;
        }
        table.detail-table td.label-col {
            width: 25%;
            padding-left: 30px;
        }
        table.detail-table td.colon-col {
            width: 3%;
            text-align: center;
        }
        table.detail-table td.value-col {
            width: 72%;
            font-weight: bold;
        }
        .pengurus-section-title {
            font-weight: bold;
            margin-top: 15px;
            margin-bottom: 8px;
            padding-left: 30px;
        }
        table.pengurus-table {
            width: 90%;
            margin: 10px auto 20px auto;
            border-collapse: collapse;
            font-size: 9.5pt;
        }
        table.pengurus-table th, table.pengurus-table td {
            border: 1px solid #000000;
            padding: 6px 8px;
            text-align: left;
        }
        table.pengurus-table th {
            background-color: #f2f2f2;
            font-weight: bold;
            text-align: center;
        }
        .closing-section {
            text-indent: 30px;
            margin-bottom: 30px;
            text-align: justify;
        }
        .signature-container {
            width: 100%;
            margin-top: 30px;
            page-break-inside: avoid;
        }
        .signature-box {
            float: right;
            width: 45%;
            text-align: left;
        }
        .signature-date {
            margin-bottom: 5px;
        }
        .tte-badge-container {
            border: 1px solid #000;
            padding: 10px;
            margin: 10px 0;
            background-color: #fafafa;
            display: flex;
            align-items: center;
            gap: 12px;
            border-radius: 4px;
        }
        .tte-qr {
            width: 60px;
            height: 60px;
            flex-shrink: 0;
        }
        .tte-info {
            font-size: 8pt;
            line-height: 1.3;
        }
        .tte-info strong {
            display: block;
            margin-bottom: 2px;
        }
        .verified-text {
            color: #155724;
            font-weight: bold;
            display: block;
            margin-top: 3px;
        }
        .print-btn-container {
            text-align: center;
            margin-top: 30px;
            margin-bottom: 30px;
        }
        .btn-print {
            background-color: #0d6efd;
            color: #ffffff;
            border: none;
            padding: 10px 24px;
            font-size: 11pt;
            font-weight: bold;
            cursor: pointer;
            border-radius: 5px;
            box-shadow: 0 2px 4px rgba(0,0,0,0.1);
            transition: background-color 0.2s;
        }
        .btn-print:hover {
            background-color: #0b5ed7;
        }
        
        @media print {
            body {
                margin: 20mm 15mm 20mm 15mm;
            }
            .print-btn-container {
                display: none;
            }
        }
    </style>
</head>
<body>

    <!-- Tombol Cetak -->
    <div class="print-btn-container">
        <button class="btn-print" onclick="window.print()"><i class="fa-solid fa-print"></i> Cetak Surat Permohonan</button>
    </div>

    <!-- Kop Surat -->
    <div class="header-kop">
        <h2>Pemerintah Kabupaten Sinjai</h2>
        <h2>Badan Kesatuan Bangsa dan Politik</h2>
        <p>Alamat: Jl. Persatuan Raya No. 45 Sinjai, Sulawesi Selatan | Email: kesbangpol@sinjaikab.go.id</p>
    </div>

    <!-- Meta Surat -->
    <table class="meta-section">
        <tr>
            <td class="label-col">Nomor</td>
            <td class="colon-col">:</td>
            <td class="value-col">220/<?= mt_rand(100, 999) ?>/Bakesbangpol/<?= date('m/Y', strtotime($pendaftaran['created_at'])) ?></td>
            <td class="date-col">Sinjai, <?= date('d F Y', strtotime($today)) ?></td>
        </tr>
        <tr>
            <td class="label-col">Sifat</td>
            <td class="colon-col">:</td>
            <td class="value-col">Penting</td>
            <td></td>
        </tr>
        <tr>
            <td class="label-col">Lampiran</td>
            <td class="colon-col">:</td>
            <td class="value-col">1 (Satu) Berkas Lengkap</td>
            <td></td>
        </tr>
        <tr>
            <td class="label-col">Hal</td>
            <td class="colon-col">:</td>
            <td class="value-col"><strong>Permohonan Pencatatan & Surat Keterangan Terdaftar (SKT)</strong></td>
            <td></td>
        </tr>
    </table>

    <!-- Penerima -->
    <div class="recipient-section">
        Kepada Yth.<br>
        <strong>Menteri Dalam Negeri Republik Indonesia</strong><br>
        c.q. Direktur Jenderal Politik dan Pemerintahan Umum<br>
        di-<br>
        <span style="padding-left: 20px;"><strong>JAKARTA</strong></span>
    </div>

    <!-- Paragraf Pembuka -->
    <div class="content-section">
        Dengan hormat, menindaklanjuti berkas pengajuan pendaftaran laporan keberadaan organisasi kemasyarakatan (Ormas) baru yang diajukan oleh pemohon melalui portal pelayanan **SIPAKATAU** (Sistem Pelayanan Kesbangpol Terpadu dan Akurat) Kabupaten Sinjai, dengan ini Kepala Badan Kesatuan Bangsa dan Politik Kabupaten Sinjai menerangkan bahwa organisasi tersebut di bawah ini telah menyerahkan berkas persyaratan secara lengkap:
    </div>

    <!-- Tabel Rincian Ormas -->
    <table class="detail-table">
        <tr>
            <td class="label-col">1. Nama Organisasi</td>
            <td class="colon-col">:</td>
            <td class="value-col"><?= esc($pendaftaran['nama_ormas']) ?></td>
        </tr>
        <tr>
            <td class="label-col">2. Tipe / Bidang Ormas</td>
            <td class="colon-col">:</td>
            <td class="value-col"><?= esc($pendaftaran['tipe_ormas'] ?? 'Lokal') ?></td>
        </tr>
        <tr>
            <td class="label-col">3. Alamat Sekretariat</td>
            <td class="colon-col">:</td>
            <td class="value-col"><?= esc($pendaftaran['alamat']) ?></td>
        </tr>
        <tr>
            <td class="label-col">4. Nomor Kontak / WA</td>
            <td class="colon-col">:</td>
            <td class="value-col"><?= esc($pendaftaran['telepon'] ?? '-') ?></td>
        </tr>
        <tr>
            <td class="label-col">5. Email Resmi</td>
            <td class="colon-col">:</td>
            <td class="value-col"><?= esc($pendaftaran['email'] ?? '-') ?></td>
        </tr>
        <tr>
            <td class="label-col">6. Masa SK Kepengurusan</td>
            <td class="colon-col">:</td>
            <td class="value-col">
                <?= !empty($pendaftaran['tgl_sk_kepengurusan']) ? date('d F Y', strtotime($pendaftaran['tgl_sk_kepengurusan'])) : '-' ?> s/d
                <?= !empty($pendaftaran['tgl_sk_kedaluwarsa']) ? date('d F Y', strtotime($pendaftaran['tgl_sk_kedaluwarsa'])) : '-' ?>
            </td>
        </tr>
    </table>

    <div class="pengurus-section-title">7. Susunan Kepengurusan Inti (Berdasarkan SK):</div>
    
    <table class="pengurus-table">
        <thead>
            <tr>
                <th style="width: 10%;">No.</th>
                <th style="width: 30%;">Jabatan</th>
                <th style="width: 40%;">Nama Lengkap</th>
                <th style="width: 20%;">Nomor HP / Kontak</th>
            </tr>
        </thead>
        <tbody>
            <?php if (!empty($pengurus)): ?>
                <?php foreach ($pengurus as $idx => $p): ?>
                <tr>
                    <td style="text-align: center;"><?= $idx + 1 ?></td>
                    <td><?= esc($p['jabatan']) ?></td>
                    <td><?= esc($p['nama']) ?></td>
                    <td><?= esc($p['no_hp'] ?? '-') ?></td>
                </tr>
                <?php endforeach; ?>
            <?php else: ?>
                <tr>
                    <td colspan="4" style="text-align: center; font-style: italic; color: #555;">Belum ada data susunan kepengurusan inti yang terdaftar.</td>
                </tr>
            <?php endif; ?>
        </tbody>
    </table>

    <!-- Paragraf Penutup -->
    <div class="closing-section">
        Sehubungan dengan hal tersebut di atas, Badan Kesatuan Bangsa dan Politik Kabupaten Sinjai menyatakan dokumen administrasi organisasi telah memenuhi syarat kelayakan sesuai dengan Peraturan Perundang-undangan yang berlaku. Bersama ini kami rekomendasikan dan mohon kiranya dapat diproses lebih lanjut untuk penerbitan Surat Keterangan Terdaftar (SKT) / administrasi pencatatan resmi pada tingkat Kementerian Dalam Negeri Republik Indonesia.
    </div>
    
    <div class="closing-section">
        Demikian permohonan ini disampaikan, atas perhatian, perkenan, dan kerjasama Bapak Menteri Dalam Negeri RI diucapkan terima kasih.
    </div>

    <!-- Tanda Tangan Elektronik -->
    <div class="signature-container">
        <div class="signature-box">
            <div class="signature-date">Sinjai, <?= date('d F Y', strtotime($today)) ?></div>
            <div>Kepala Badan Kesbangpol Kab. Sinjai,</div>
            
            <!-- BSrE TTE Stamp -->
            <div class="tte-badge-container">
                <svg class="tte-qr" viewBox="0 0 100 100" xmlns="http://www.w3.org/2000/svg">
                    <rect x="5" y="5" width="90" height="90" fill="none" stroke="#000" stroke-width="3"/>
                    <rect x="12" y="12" width="24" height="24" fill="#000"/>
                    <rect x="16" y="16" width="16" height="16" fill="#fff"/>
                    <rect x="20" y="20" width="8" height="8" fill="#000"/>
                    <rect x="64" y="12" width="24" height="24" fill="#000"/>
                    <rect x="68" y="16" width="16" height="16" fill="#fff"/>
                    <rect x="72" y="20" width="8" height="8" fill="#000"/>
                    <rect x="12" y="64" width="24" height="24" fill="#000"/>
                    <rect x="16" y="68" width="16" height="16" fill="#fff"/>
                    <rect x="20" y="72" width="8" height="8" fill="#000"/>
                    <rect x="42" y="16" width="4" height="4" fill="#000"/><rect x="50" y="16" width="4" height="4" fill="#000"/><rect x="58" y="16" width="4" height="4" fill="#000"/>
                    <rect x="16" y="42" width="4" height="4" fill="#000"/><rect x="16" y="50" width="4" height="4" fill="#000"/><rect x="16" y="58" width="4" height="4" fill="#000"/>
                    <rect x="42" y="30" width="8" height="4" fill="#000"/>
                    <rect x="54" y="30" width="4" height="8" fill="#000"/>
                    <rect x="42" y="42" width="4" height="4" fill="#000"/>
                    <rect x="50" y="46" width="8" height="4" fill="#000"/>
                    <rect x="46" y="54" width="4" height="12" fill="#000"/>
                    <rect x="64" y="42" width="12" height="4" fill="#000"/>
                    <rect x="76" y="46" width="4" height="12" fill="#000"/>
                    <rect x="68" y="54" width="8" height="4" fill="#000"/>
                    <rect x="42" y="72" width="8" height="8" fill="#000"/>
                    <rect x="54" y="76" width="8" height="4" fill="#000"/>
                    <rect x="64" y="72" width="4" height="12" fill="#000"/>
                    <rect x="72" y="76" width="16" height="4" fill="#000"/>
                    <rect x="80" y="64" width="8" height="8" fill="#000"/>
                </svg>
                <div class="tte-info">
                    <strong>Ditandatangani Secara Elektronik</strong>
                    <span>Kepala Badan Kesbangpol Sinjai</span><br>
                    <strong>M. Rusyaid, S.Kom., M.Si.</strong>
                    <span class="verified-text">✓ Verified BSrE - BSSN</span>
                </div>
            </div>
            
            <strong><u>Muhammad Rusyaid, S.Kom., M.Si.</u></strong><br>
            NIP. 19741024 199903 1 002
        </div>
    </div>

</body>
</html>
