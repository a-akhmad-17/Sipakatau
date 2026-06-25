<?php

if (!function_exists('log_activity')) {
    /**
     * Catat audit trail aktivitas pengguna (Before vs After).
     *
     * @param string $action Nama aksi (misal: 'CREATE_ORMAS', 'UPDATE_ORMAS')
     * @param array|object|null $beforeData Data sebelum perubahan
     * @param array|object|null $afterData Data setelah perubahan
     * @param string|null $tableName Nama tabel terkait
     * @param string|null $recordId ID record terkait (UUID/Hashid)
     * @return bool
     */
    function log_activity(string $action, $beforeData = null, $afterData = null, ?string $tableName = null, ?string $recordId = null): bool
    {
        try {
            $db = \Config\Database::connect();
            $session = \Config\Services::session();
            $request = \Config\Services::request();

            $userId = $session->get('user_id') ?? null;

            $data = [
                'id'          => sprintf('%04x%04x-%04x-%04x-%04x-%04x%04x%04x', mt_rand(0, 0xffff), mt_rand(0, 0xffff), mt_rand(0, 0xffff), mt_rand(0, 0x0fff) | 0x4000, mt_rand(0, 0x3fff) | 0x8000, mt_rand(0, 0xffff), mt_rand(0, 0xffff), mt_rand(0, 0xffff)),
                'user_id'     => $userId,
                'action'      => $action,
                'table_name'  => $tableName,
                'record_id'   => $recordId,
                'before_data' => $beforeData ? json_encode($beforeData) : null,
                'after_data'  => $afterData ? json_encode($afterData) : null,
                'ip_address'  => $request->getIPAddress(),
                'user_agent'  => $request->getUserAgent()->getAgentString(),
                'created_at'  => date('Y-m-d H:i:s')
            ];

            return $db->table('log_activities')->insert($data);
        } catch (\Throwable $e) {
            // Jika terjadi kesalahan log audit, kirim notifikasi telegram via telegram_helper
            if (function_exists('telegram_send_error')) {
                telegram_send_error($e);
            }
            return false;
        }
    }
}

if (!function_exists('convert_to_webp')) {
    /**
     * Konversi file gambar yang diunggah ke format WebP.
     *
     * @param \CodeIgniter\Files\File|\CodeIgniter\HTTP\Files\UploadedFile $file Berkas gambar
     * @param string $destinationFolder Direktori tujuan penyimpanan
     * @param string $filenameNamaBaru Nama berkas tanpa ekstensi
     * @param int $quality Kualitas kompresi WebP (1-100)
     * @return string|bool Mengembalikan nama file baru (dengan ekstensi .webp) atau false jika gagal
     */
    function convert_to_webp($file, string $destinationFolder, string $filenameNamaBaru, int $quality = 80)
    {
        if (!$file->isValid() || $file->hasMoved()) {
            return false;
        }

        $mime = $file->getMimeType();
        $sourcePath = $file->getTempName();

        // Cek dukungan ekstensi GD
        if (!extension_loaded('gd')) {
            // Fallback: pindahkan file secara biasa tanpa konversi jika GD tidak ada
            $newName = $file->getRandomName();
            $file->move($destinationFolder, $newName);
            return $newName;
        }

        $image = null;
        switch ($mime) {
            case 'image/jpeg':
            case 'image/jpg':
                $image = imagecreatefromjpeg($sourcePath);
                break;
            case 'image/png':
                $image = imagecreatefrompng($sourcePath);
                // Pertahankan alpha channel transparansi png
                imagepalettetotruecolor($image);
                imagealphablending($image, true);
                imagesavealpha($image, true);
                break;
            case 'image/gif':
                $image = imagecreatefromgif($sourcePath);
                imagepalettetotruecolor($image);
                break;
            case 'image/webp':
                $image = imagecreatefromwebp($sourcePath);
                break;
            default:
                // Jika bukan gambar yang didukung, pindahkan file secara langsung
                $newName = $file->getRandomName();
                $file->move($destinationFolder, $newName);
                return $newName;
        }

        if (!$image) {
            return false;
        }

        // Siapkan direktori tujuan
        if (!is_dir($destinationFolder)) {
            mkdir($destinationFolder, 0755, true);
        }

        $finalFilename = $filenameNamaBaru . '.webp';
        $destinationPath = rtrim($destinationFolder, DIRECTORY_SEPARATOR) . DIRECTORY_SEPARATOR . $finalFilename;

        // Simpan sebagai WebP
        $success = imagewebp($image, $destinationPath, $quality);
        imagedestroy($image);

        return $success ? $finalFilename : false;
    }
}
