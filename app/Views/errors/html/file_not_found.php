<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Berkas Tidak Ditemukan - SIPAKATAU Kesbangpol Sinjai</title>
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;600;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <style>
        :root {
            --bg-color: #0b0f19;
            --card-bg: rgba(17, 24, 39, 0.95);
            --border-color: rgba(255, 255, 255, 0.1);
            --text-main: #f3f4f6;
            --text-muted: #9ca3af;
            --accent-red: #ef4444;
        }
        * {
            box-sizing: border-box;
            margin: 0;
            padding: 0;
        }
        body {
            font-family: 'Plus Jakarta Sans', sans-serif;
            background-color: var(--bg-color);
            color: var(--text-main);
            min-height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
            padding: 20px;
        }
        .container {
            max-width: 540px;
            width: 100%;
            background: var(--card-bg);
            border: 1px solid var(--border-color);
            border-radius: 16px;
            padding: 40px 30px;
            text-align: center;
            box-shadow: 0 20px 40px rgba(0, 0, 0, 0.5);
            backdrop-filter: blur(10px);
        }
        .icon-box {
            width: 80px;
            height: 80px;
            background: rgba(239, 68, 68, 0.15);
            border: 2px solid rgba(239, 68, 68, 0.3);
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            margin: 0 auto 24px;
            color: var(--accent-red);
            font-size: 32px;
        }
        h1 {
            font-size: 22px;
            font-weight: 700;
            margin-bottom: 12px;
            color: #ffffff;
        }
        p {
            font-size: 14px;
            color: var(--text-muted);
            line-height: 1.6;
            margin-bottom: 24px;
        }
        .file-info {
            background: rgba(255, 255, 255, 0.04);
            border: 1px dashed var(--border-color);
            border-radius: 10px;
            padding: 12px 16px;
            font-family: monospace;
            font-size: 13px;
            color: #fbbf24;
            word-break: break-all;
            margin-bottom: 24px;
        }
        .btn-back {
            display: inline-flex;
            align-items: center;
            gap: 8px;
            background: #2563eb;
            color: #ffffff;
            text-decoration: none;
            padding: 10px 24px;
            border-radius: 8px;
            font-weight: 600;
            font-size: 14px;
            transition: all 0.2s ease;
        }
        .btn-back:hover {
            background: #1d4ed8;
            transform: translateY(-1px);
        }
    </style>
</head>
<body>
    <div class="container">
        <div class="icon-box">
            <i class="fa-solid fa-file-circle-xmark"></i>
        </div>
        <h1>Berkas Fisik Tidak Ditemukan</h1>
        <p>
            Maaf, berkas fisik yang Anda minta tidak tersedia di server. Berkas ini mungkin merupakan data pengujian lokal, belum diunggah ulang ke server live, atau telah dihapus.
        </p>
        <div class="file-info">
            <i class="fa-solid fa-folder-open me-2"></i><?= esc($path ?? $filename) ?>
        </div>
        <a href="javascript:history.back()" class="btn-back">
            <i class="fa-solid fa-arrow-left"></i> Kembali ke Halaman Sebelumnya
        </a>
    </div>
</body>
</html>
