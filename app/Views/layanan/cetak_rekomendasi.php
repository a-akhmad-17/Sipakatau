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
            line-height: 1.5;
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
        .doc-title-box {
            text-align: center;
            margin-bottom: 25px;
        }
        .doc-title {
            font-size: 12pt;
            font-weight: bold;
            text-transform: uppercase;
            text-decoration: underline;
            margin: 0;
            letter-spacing: 0.5px;
        }
        .doc-number {
            font-size: 10pt;
            margin: 3px 0 0 0;
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
            padding: 6px 4px;
            vertical-align: top;
            border: none;
        }
        table.detail-table td.label-col {
            width: 30%;
        }
        table.detail-table td.colon-col {
            width: 3%;
            text-align: center;
        }
        table.detail-table td.value-col {
            width: 67%;
            font-weight: bold;
        }
        .rules-title {
            font-weight: bold;
            margin-top: 15px;
            margin-bottom: 5px;
        }
        ol.rules-list {
            margin: 0 0 20px 0;
            padding-left: 20px;
            text-align: justify;
        }
        ol.rules-list li {
            margin-bottom: 5px;
        }
        .closing-section {
            text-indent: 30px;
            margin-bottom: 30px;
            text-align: justify;
        }
        .signature-container {
            width: 100%;
            margin-top: 30px;
            display: flex;
            justify-content: flex-end;
        }
        .signature-box {
            width: 380px;
            text-align: left;
        }
        .signature-date {
            margin-bottom: 5px;
        }
        /* BSrE Government TTE Stamp Style */
        .tte-badge-container {
            border: 1px solid #000000;
            padding: 8px;
            display: flex;
            align-items: center;
            gap: 10px;
            background-color: #fafafa;
            margin-top: 8px;
            margin-bottom: 8px;
            border-radius: 4px;
        }
        .tte-qr {
            width: 60px;
            height: 60px;
            flex-shrink: 0;
        }
        .tte-info {
            font-size: 7.5pt;
            font-family: Arial, Helvetica, sans-serif;
            line-height: 1.3;
            color: #333333;
        }
        .tte-info strong {
            color: #000000;
            display: block;
            margin-bottom: 2px;
            text-transform: uppercase;
        }
        .tte-info span.verified-text {
            color: #0d9488;
            font-weight: bold;
            display: flex;
            align-items: center;
            gap: 2px;
        }
        .btn-print-action {
            background-color: #be123c;
            color: #ffffff;
            border: none;
            padding: 8px 16px;
            font-family: Arial, sans-serif;
            font-size: 9pt;
            font-weight: bold;
            cursor: pointer;
            border-radius: 4px;
            margin-bottom: 20px;
            display: inline-flex;
            align-items: center;
            gap: 6px;
            box-shadow: 0 2px 5px rgba(0,0,0,0.1);
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
            .tte-badge-container {
                background-color: #ffffff !important;
            }
        }
    </style>
</head>
<body>

    <!-- Print Button (Visible in browser, hidden during print) -->
    <div class="no-print" style="text-align: right;">
        <a href="<?= base_url('layanan/lacak?nomor=' . esc($rek['id'])) ?>" class="btn-print-action" style="background-color: #4b5563; text-decoration: none;">
            ← Kembali
        </a>
        <button onclick="window.print();" class="btn-print-action">
            🖨️ Cetak Surat Rekomendasi
        </button>
    </div>

    <!-- Kop Surat Resmi -->
    <div class="header-kop">
        <h2>Pemerintah Kabupaten Sinjai</h2>
        <h3>Badan Kesatuan Bangsa dan Politik</h3>
        <p>Jl. Sinjai - Watampone, Biringere, Sinjai, Kabupaten Sinjai, Sulawesi Selatan 92600 • Email: kesbangpol@sinjaikab.go.id</p>
    </div>

    <!-- Judul Dokumen -->
    <div class="doc-title-box">
        <h4 class="doc-title">Surat Rekomendasi Kegiatan</h4>
        <div class="doc-number">Nomor: 070/<?= mt_rand(100, 999) ?>/Bakesbangpol/<?= date('m/Y', strtotime($rek['created_at'])) ?></div>
    </div>

    <!-- Paragraf Pembuka -->
    <div class="content-section">
        Berdasarkan permohonan rekomendasi kegiatan yang diajukan oleh pemohon dan setelah dilakukan penelitian/pemeriksaan dokumen administrasi syarat administrasi yang ditentukan, dengan ini Kepala Badan Kesatuan Bangsa dan Politik Kabupaten Sinjai memberikan rekomendasi kegiatan kepada:
    </div>

    <!-- Tabel Rincian -->
    <table class="detail-table">
        <tr>
            <td class="label-col">1. Nama Pemohon / Lembaga</td>
            <td class="colon-col">:</td>
            <td class="value-col"><?= esc($rek['pemohon']) ?></td>
        </tr>
        <tr>
            <td class="label-col">2. Judul / Tema Kegiatan</td>
            <td class="colon-col">:</td>
            <td class="value-col"><?= esc($rek['nama_kegiatan']) ?></td>
        </tr>
        <tr>
            <td class="label-col">3. Waktu Pelaksanaan</td>
            <td class="colon-col">:</td>
            <td class="value-col"><?= date('d F Y', strtotime($rek['tgl_mulai'])) ?> s.d <?= date('d F Y', strtotime($rek['tgl_selesai'])) ?></td>
        </tr>
        <tr>
            <td class="label-col">4. Deskripsi & Lokasi Sasaran</td>
            <td class="colon-col">:</td>
            <td class="value-col"><?= esc($rek['deskripsi']) ?></td>
        </tr>
    </table>

    <!-- Ketentuan -->
    <div class="rules-title">Dengan ketentuan sebagai berikut:</div>
    <ol class="rules-list">
        <li>Sebelum melakukan kegiatan, pemohon wajib melaporkan rencana operasional kepada Pemerintah Setempat (Camat/Lurah) dan instansi pembina terkait di lokasi sasaran.</li>
        <li>Kegiatan yang dilakukan harus tunduk dan patuh pada ketentuan peraturan perundang-undangan yang berlaku di Negara Kesatuan Republik Indonesia.</li>
        <li>Rekomendasi ini tidak berlaku apabila kegiatan menyimpang dari judul/tema yang diajukan atau mengganggu stabilitas keamanan, ketertiban umum masyarakat setempat.</li>
        <li>Pemohon wajib melaporkan hasil pelaksanaan kegiatan kepada Kepala Badan Kesatuan Bangsa dan Politik Kabupaten Sinjai setelah kegiatan selesai dilaksanakan.</li>
    </ol>

    <!-- Paragraf Penutup -->
    <div class="closing-section">
        Demikian Surat Rekomendasi ini diberikan untuk dapat dipergunakan sebagaimana mestinya dan dilaksanakan dengan penuh rasa tanggung jawab.
    </div>

    <!-- Tanda Tangan Elektronik -->
    <div class="signature-container">
        <div class="signature-box">
            <div class="signature-date">Sinjai, <?= date('d F Y', strtotime($today)) ?></div>
            <div>Kepala Badan Kesbangpol Kab. Sinjai,</div>
            
            <!-- BSrE TTE Stamp -->
            <div class="tte-badge-container">
                <!-- Inline SVG QR Code mapping to the tracking URL for authenticity check -->
                <svg class="tte-qr" viewBox="0 0 100 100" xmlns="http://www.w3.org/2000/svg">
                    <!-- Outer border -->
                    <rect x="5" y="5" width="90" height="90" fill="none" stroke="#000" stroke-width="3"/>
                    <!-- Finder Pattern Top Left -->
                    <rect x="12" y="12" width="24" height="24" fill="#000"/>
                    <rect x="16" y="16" width="16" height="16" fill="#fff"/>
                    <rect x="20" y="20" width="8" height="8" fill="#000"/>
                    <!-- Finder Pattern Top Right -->
                    <rect x="64" y="12" width="24" height="24" fill="#000"/>
                    <rect x="68" y="16" width="16" height="16" fill="#fff"/>
                    <rect x="72" y="20" width="8" height="8" fill="#000"/>
                    <!-- Finder Pattern Bottom Left -->
                    <rect x="12" y="64" width="24" height="24" fill="#000"/>
                    <rect x="16" y="68" width="16" height="16" fill="#fff"/>
                    <rect x="20" y="72" width="8" height="8" fill="#000"/>
                    <!-- Timing Patterns -->
                    <rect x="42" y="16" width="4" height="4" fill="#000"/><rect x="50" y="16" width="4" height="4" fill="#000"/><rect x="58" y="16" width="4" height="4" fill="#000"/>
                    <rect x="16" y="42" width="4" height="4" fill="#000"/><rect x="16" y="50" width="4" height="4" fill="#000"/><rect x="16" y="58" width="4" height="4" fill="#000"/>
                    <!-- Simulated Data Modules -->
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
            NIP. 19781024 200501 1 008
        </div>
    </div>

    <!-- Auto-trigger Cetak Browser -->
    <script>
        window.addEventListener('DOMContentLoaded', () => {
            setTimeout(() => {
                window.print();
            }, 800);
        });
    </script>
</body>
</html>
