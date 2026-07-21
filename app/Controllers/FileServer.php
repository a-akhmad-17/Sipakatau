<?php

namespace App\Controllers;

use CodeIgniter\Controller;

class FileServer extends BaseController
{
    /**
     * Fallback handler untuk menyajikan berkas di folder uploads/
     * Jika berkas fisik ada, disajikan dengan Header Content-Type yang sesuai (PDF/WebP/Image).
     * Jika berkas fisik tidak ada, menampilkan tampilan peringatan yang jelas dan ramah pengguna.
     */
    public function serve(...$pathSegments)
    {
        $relativePath = implode('/', $pathSegments);
        // Sanitasi path traversal
        $relativePath = str_replace(['..', '\\'], ['', '/'], $relativePath);
        $relativePath = ltrim($relativePath, '/');

        $filePath = ROOTPATH . 'public/uploads/' . $relativePath;

        if (file_exists($filePath) && is_file($filePath)) {
            $mimeType = @mime_content_type($filePath) ?: 'application/octet-stream';
            
            $ext = strtolower(pathinfo($filePath, PATHINFO_EXTENSION));
            if ($ext === 'webp') {
                $mimeType = 'image/webp';
            } elseif ($ext === 'pdf') {
                $mimeType = 'application/pdf';
            } elseif (in_array($ext, ['jpg', 'jpeg'])) {
                $mimeType = 'image/jpeg';
            } elseif ($ext === 'png') {
                $mimeType = 'image/png';
            }

            return $this->response
                ->setHeader('Content-Type', $mimeType)
                ->setHeader('Content-Disposition', 'inline; filename="' . basename($filePath) . '"')
                ->setHeader('Content-Length', (string)filesize($filePath))
                ->setBody(file_get_contents($filePath));
        }

        // Tampilan 404 khusus untuk file yang tidak ditemukan di server
        return $this->response->setStatusCode(404)->setBody(view('errors/html/file_not_found', [
            'filename' => basename($relativePath),
            'path'     => 'uploads/' . $relativePath
        ]));
    }
}
