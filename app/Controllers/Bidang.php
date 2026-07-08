<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use CodeIgniter\HTTP\ResponseInterface;

class Bidang extends BaseController
{
    public function index(): string
    {
        $db      = \Config\Database::connect();
        $session = session();
        $bidangId   = $session->get('bidang_id');
        $userRole   = $session->get('role');

        // Ambil nama bidang
        $bidang    = $db->table('mst_bidang')->where('id', $bidangId)->get()->getRowArray();
        $namaBidang = $bidang ? $bidang['nama_bidang'] : 'Semua Bidang';

        $ormas    = $db->table('mst_ormas')->orderBy('nama_ormas', 'ASC')->get()->getResultArray();
        $parpol   = $db->table('mst_parpol')->orderBy('nama_parpol', 'ASC')->get()->getResultArray();
        $pengaduan = $db->table('log_activities')
                        ->where('action', 'DAFTAR_PENGADUAN_ANONIM')
                        ->orderBy('created_at', 'DESC')
                        ->get()
                        ->getResultArray();

        $hotspotSetting = $db->table('sys_settings')->where('key', 'titik_kerawanan')->get()->getRowArray();
        $hotspots = $hotspotSetting ? json_decode($hotspotSetting['value'], true) : [];

        // Data pendaftaran SKT — hanya ditampilkan untuk kabid bidang POLDAGRI_ORMAS
        $pendaftaran = [];
        $isPoldagri  = false;
        if ($bidang && $bidang['kode_bidang'] === 'POLDAGRI_ORMAS') {
            $isPoldagri = true;
            $pendaftaran = $db->table('trn_pendaftaran')
                ->select('trn_pendaftaran.*, mst_ormas.nama_ormas, mst_ormas.alamat, mst_ormas.email, mst_ormas.telepon, mst_ormas.file_berkas, mst_ormas.tgl_sk_kepengurusan, mst_ormas.tgl_sk_kedaluwarsa')
                ->join('mst_ormas', 'mst_ormas.id = trn_pendaftaran.ormas_id', 'left')
                ->orderBy('trn_pendaftaran.created_at', 'DESC')
                ->get()
                ->getResultArray();
        }

        $data = [
            'title'       => 'Dashboard Bidang - SIPAKATAU',
            'namaBidang'  => $namaBidang,
            'ormas'       => $ormas,
            'parpol'      => $parpol,
            'pengaduan'   => $pengaduan,
            'hotspots'    => $hotspots,
            'today'       => date('Y-m-d'),
            'isPoldagri'  => $isPoldagri,
            'pendaftaran' => $pendaftaran,
        ];

        return view('bidang/dashboard_bidang', $data);
    }

    // =========================================================================
    // KELOLA PENDAFTARAN SKT ORMAS (Khusus Kabid Poldagri & Ormas)
    // =========================================================================

    public function prosesPendaftaran(string $id, string $action)
    {
        $db      = \Config\Database::connect();
        $session = session();
        helper('app');

        // Guard: hanya kabid Poldagri
        $bidangId = $session->get('bidang_id');
        $bidang   = $db->table('mst_bidang')->where('id', $bidangId)->get()->getRowArray();
        if (!$bidang || $bidang['kode_bidang'] !== 'POLDAGRI_ORMAS') {
            return redirect()->to('bidang')->with('error', 'Anda tidak memiliki kewenangan untuk aksi ini.');
        }

        $pendaftaran = $db->table('trn_pendaftaran')
            ->select('trn_pendaftaran.*, mst_ormas.nama_ormas')
            ->join('mst_ormas', 'mst_ormas.id = trn_pendaftaran.ormas_id', 'left')
            ->where('trn_pendaftaran.id', $id)
            ->get()
            ->getRowArray();

        if (!$pendaftaran) {
            return redirect()->to('bidang')->with('error', 'Data pendaftaran tidak ditemukan.');
        }

        $beforeData = $pendaftaran;
        $updateData = [];
        $msg        = '';

        if ($action === 'approve_bidang') {
            // Kabid validasi berkas → progress 75%
            $updateData = [
                'status_verifikasi'   => 'Approved',
                'progress_percentage' => 75,
                'updated_at'          => date('Y-m-d H:i:s'),
            ];
            $msg = 'Berkas pendaftaran berhasil divalidasi oleh Bidang Poldagri & Ormas. Siap untuk penerbitan SKT.';
        } elseif ($action === 'terbitkan_skt') {
            // Upload SKT / dokumen final
            $file = $this->request->getFile('berkas_skt');

            if ($file && $file->isValid() && !$file->hasMoved()) {
                $uploadPath = ROOTPATH . 'public/uploads/rekomendasi_ormas/';
                if (!is_dir($uploadPath)) {
                    mkdir($uploadPath, 0777, true);
                }
                $fileName = $file->getRandomName();
                $file->move($uploadPath, $fileName);
            } else {
                return redirect()->back()->with('error', 'Gagal mengunggah SKT. Pastikan file PDF/gambar valid.');
            }

            $updateData = [
                'status_verifikasi'   => 'Approved',
                'progress_percentage' => 100,
                'pdf_tte_path'        => $fileName,
                'updated_at'          => date('Y-m-d H:i:s'),
            ];
            $msg = 'SKT berhasil diterbitkan dan dikirim ke pemohon. Proses registrasi ormas selesai!';
        } elseif ($action === 'reject') {
            $alasan = $this->request->getPost('alasan_ditolak');
            $updateData = [
                'status_verifikasi'   => 'Rejected',
                'alasan_ditolak'      => $alasan ?: 'Berkas kurang lengkap atau tidak sesuai persyaratan.',
                'progress_percentage' => 0,
                'updated_at'          => date('Y-m-d H:i:s'),
            ];
            $msg = 'Pendaftaran ormas "' . ($pendaftaran['nama_ormas'] ?? '') . '" ditolak.';
        } else {
            return redirect()->to('bidang')->with('error', 'Aksi tidak dikenali.');
        }

        $db->table('trn_pendaftaran')->where('id', $id)->update($updateData);

        log_activity(
            'BIDANG_PROSES_PENDAFTARAN_ORMAS',
            $beforeData,
            array_merge($beforeData, $updateData),
            'trn_pendaftaran',
            $id
        );

        return redirect()->to('bidang')->with('success', $msg);
    }
}
