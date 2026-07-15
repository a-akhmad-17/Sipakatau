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

        $ormas    = $db->table('mst_ormas')
                            ->select('mst_ormas.*')
                            ->join('trn_pendaftaran', 'trn_pendaftaran.ormas_id = mst_ormas.id', 'left')
                            ->groupStart()
                                ->where('trn_pendaftaran.id IS NULL')
                                ->orWhere('trn_pendaftaran.progress_percentage', 100)
                            ->groupEnd()
                            ->orderBy('mst_ormas.nama_ormas', 'ASC')
                            ->get()
                            ->getResultArray();
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

        $rekomendasi = $db->table('trn_rekomendasi')
                          ->orderBy('created_at', 'DESC')
                          ->get()
                          ->getResultArray();

        $data = [
            'title'       => 'Dashboard Bidang - SIPAKATAU',
            'namaBidang'  => $namaBidang,
            'ormas'       => $ormas,
            'parpol'      => $parpol,
            'pengaduan'   => $pengaduan,
            'hotspots'    => $hotspots,
            'rekomendasi' => $rekomendasi,
            'today'       => date('Y-m-d'),
            'isPoldagri'  => $isPoldagri,
            'pendaftaran' => $pendaftaran,
        ];

        return view('bidang/dashboard_bidang', $data);
    }

    public function penerbitanSkt()
    {
        $db      = \Config\Database::connect();
        $session = session();
        $bidangId   = $session->get('bidang_id');

        // Ambil nama bidang
        $bidang    = $db->table('mst_bidang')->where('id', $bidangId)->get()->getRowArray();
        $namaBidang = $bidang ? $bidang['nama_bidang'] : 'Semua Bidang';

        if (!$bidang || $bidang['kode_bidang'] !== 'POLDAGRI_ORMAS') {
            return redirect()->to('bidang')->with('error', 'Halaman ini hanya dapat diakses oleh Bidang Poldagri & Ormas.');
        }

        $pendaftaran = $db->table('trn_pendaftaran')
            ->select('trn_pendaftaran.*, mst_ormas.nama_ormas, mst_ormas.alamat, mst_ormas.email, mst_ormas.telepon, mst_ormas.file_berkas, mst_ormas.tgl_sk_kepengurusan, mst_ormas.tgl_sk_kedaluwarsa, sys_users.username AS username_pengirim, sys_users.email AS email_pengirim')
            ->join('mst_ormas', 'mst_ormas.id = trn_pendaftaran.ormas_id', 'left')
            ->join('sys_users', 'sys_users.id = trn_pendaftaran.user_id', 'left')
            ->orderBy('trn_pendaftaran.created_at', 'DESC')
            ->get()
            ->getResultArray();

        $data = [
            'title'       => 'Penerbitan SKT / Tanggapan - SIPAKATAU',
            'namaBidang'  => $namaBidang,
            'pendaftaran' => $pendaftaran,
            'isPoldagri'  => true,
        ];

        return view('bidang/penerbitan_skt', $data);
    }

    // =========================================================================
    // KELOLA PENDAFTARAN SKT ORMAS (Khusus Kabid Poldagri & Ormas)
    // =========================================================================

    public function prosesPendaftaran(string $id, string $action)
    {
        $db      = \Config\Database::connect();
        $session = session();
        helper(['app', 'telegram']);

        // Guard: hanya kabid Poldagri
        $bidangId = $session->get('bidang_id');
        $bidang   = $db->table('mst_bidang')->where('id', $bidangId)->get()->getRowArray();
        if (!$bidang || $bidang['kode_bidang'] !== 'POLDAGRI_ORMAS') {
            return redirect()->to('bidang/penerbitan-skt')->with('error', 'Anda tidak memiliki kewenangan untuk aksi ini.');
        }

        $pendaftaran = $db->table('trn_pendaftaran')
            ->select('trn_pendaftaran.*, mst_ormas.nama_ormas')
            ->join('mst_ormas', 'mst_ormas.id = trn_pendaftaran.ormas_id', 'left')
            ->where('trn_pendaftaran.id', $id)
            ->get()
            ->getRowArray();

        if (!$pendaftaran) {
            return redirect()->to('bidang/penerbitan-skt')->with('error', 'Data pendaftaran tidak ditemukan.');
        }

        $beforeData = $pendaftaran;
        $updateData = [];
        $msg        = '';
        $telegramTitle = '';
        $telegramDetails = [];

        if ($action === 'approve_bidang') {
            // Kabid validasi berkas → progress 75%
            $updateData = [
                'status_verifikasi'   => 'Approved',
                'progress_percentage' => 75,
                'updated_at'          => date('Y-m-d H:i:s'),
            ];
            $msg = 'Berkas pendaftaran berhasil divalidasi oleh Bidang Poldagri & Ormas. Siap untuk penerbitan dokumen resmi.';
            
            $telegramTitle = '✨ Validasi Bidang Ormas Disetujui (Kabid)';
            $telegramDetails = [
                'Nama Ormas' => $pendaftaran['nama_ormas'] ?? 'Tidak Diketahui',
                'Status Baru' => 'Approved (Siap Terbitkan SKT)',
                'Progres' => '75%',
                'Diproses Oleh' => $session->get('username') ?: 'Kabid Poldagri'
            ];
        } elseif ($action === 'terbitkan_skt') {
            // Upload SKT / dokumen final
            $file = $this->request->getFile('berkas_skt');
            $fileName = null;

            if ($file && $file->isValid() && !$file->hasMoved()) {
                $uploadPath = ROOTPATH . 'public/uploads/rekomendasi_ormas/';
                if (!is_dir($uploadPath)) {
                    mkdir($uploadPath, 0777, true);
                }
                $fileName = $file->getRandomName();
                $file->move($uploadPath, $fileName);
            } else {
                return redirect()->back()->with('error', 'Gagal mengunggah dokumen. Pastikan file PDF/gambar valid.');
            }

            $updateData = [
                'status_verifikasi'   => 'Approved',
                'progress_percentage' => 100,
                'pdf_tte_path'        => $fileName,
                'updated_at'          => date('Y-m-d H:i:s'),
            ];
            $msg = 'Dokumen resmi berhasil diterbitkan dan dikirim ke pemohon. Proses registrasi ormas selesai!';
            
            $telegramTitle = '🎉 SKT Ormas Diterbitkan (Kabid)';
            $telegramDetails = [
                'Nama Ormas' => $pendaftaran['nama_ormas'] ?? 'Tidak Diketahui',
                'Status Baru' => 'Selesai (100% Aktif)',
                'Progres' => '100%',
                'Nama File SKT' => $fileName,
                'Diproses Oleh' => $session->get('username') ?: 'Kabid Poldagri'
            ];
        } elseif ($action === 'reject') {
            $alasan = $this->request->getPost('alasan_ditolak');
            $updateData = [
                'status_verifikasi'   => 'Rejected',
                'alasan_ditolak'      => $alasan ?: 'Berkas kurang lengkap atau tidak sesuai persyaratan.',
                'progress_percentage' => 0,
                'updated_at'          => date('Y-m-d H:i:s'),
            ];
            $msg = 'Pendaftaran ormas "' . ($pendaftaran['nama_ormas'] ?? '') . '" ditolak.';
            
            $telegramTitle = '❌ Pendaftaran Ormas Ditolak Bidang';
            $telegramDetails = [
                'Nama Ormas' => $pendaftaran['nama_ormas'] ?? 'Tidak Diketahui',
                'Status Baru' => 'Rejected (Perlu Revisi)',
                'Progres' => '0%',
                'Alasan Penolakan' => $updateData['alasan_ditolak'],
                'Diproses Oleh' => $session->get('username') ?: 'Kabid Poldagri'
            ];
        } elseif ($action === 'delete') {
            // Hapus file berkas ormas & data pendaftaran
            $ormas = $db->table('mst_ormas')->where('id', $pendaftaran['ormas_id'])->get()->getRowArray();
            
            // Hapus file logo dan berkas jika ada
            if ($ormas) {
                if (!empty($ormas['file_logo'])) {
                    @unlink(ROOTPATH . 'public/uploads/ormas/' . $ormas['file_logo']);
                }
                if (!empty($ormas['file_berkas'])) {
                    $files = json_decode($ormas['file_berkas'], true) ?: [];
                    foreach ($files as $file) {
                        if (!empty($file['filename'])) {
                            @unlink(ROOTPATH . 'public/uploads/ormas/' . $file['filename']);
                        }
                    }
                }
            }
            
            // Hapus data
            $db->table('trn_pendaftaran')->where('id', $id)->delete();
            if ($ormas) {
                $db->table('mst_ormas_pengurus')->where('ormas_id', $pendaftaran['ormas_id'])->delete();
                $db->table('mst_ormas')->where('id', $pendaftaran['ormas_id'])->delete();
            }

            log_activity('BIDANG_HAPUS_PENDAFTARAN_ORMAS', ['pendaftaran' => $pendaftaran, 'ormas' => $ormas], [], 'trn_pendaftaran', $id);
            
            telegram_send_transaction('🗑️ Pendaftaran Ormas Dihapus (Kabid)', [
                'Nama Ormas' => $pendaftaran['nama_ormas'] ?? 'Tidak Diketahui',
                'Status' => 'Dihapus Permanen',
                'Diproses Oleh' => $session->get('username') ?: 'Kabid Poldagri'
            ]);

            return redirect()->to('bidang/penerbitan-skt')->with('success', 'Pendaftaran ormas berhasil dihapus secara permanen.');
        } else {
            return redirect()->to('bidang/penerbitan-skt')->with('error', 'Aksi tidak dikenali.');
        }

        $db->table('trn_pendaftaran')->where('id', $id)->update($updateData);

        // Filter log payload untuk keamanan & efisiensi
        $filterKeys = ['id', 'ormas_id', 'nomor_registrasi', 'status_verifikasi', 'progress_percentage', 'alasan_ditolak', 'pdf_tte_path', 'updated_at'];
        $filteredBefore = array_intersect_key($beforeData, array_flip($filterKeys));
        $filteredAfter = array_intersect_key(array_merge($beforeData, $updateData), array_flip($filterKeys));

        log_activity(
            'BIDANG_PROSES_PENDAFTARAN_ORMAS',
            $filteredBefore,
            $filteredAfter,
            'trn_pendaftaran',
            $id
        );

        // Kirim Telegram Notification
        if (!empty($telegramTitle)) {
            telegram_send_transaction($telegramTitle, $telegramDetails);
        }

        return redirect()->to('bidang/penerbitan-skt')->with('success', $msg);
    }
}
