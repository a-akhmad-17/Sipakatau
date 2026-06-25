<?php

namespace App\Controllers;

use App\Controllers\BaseController;

class User extends BaseController
{
    protected $db;

    public function __construct()
    {
        $this->db = \Config\Database::connect();
    }

    public function index()
    {
        $userId = session()->get('user_id');

        // Ambil SEMUA data pendaftaran yang dikaitkan dengan user ini
        $pendaftaranList = $this->db->table('trn_pendaftaran')
                                ->select('trn_pendaftaran.*, mst_ormas.nama_ormas, mst_ormas.alamat, mst_ormas.email, mst_ormas.telepon, mst_ormas.file_logo, mst_ormas.file_berkas, mst_ormas.tgl_sk_kepengurusan, mst_ormas.tgl_sk_kedaluwarsa, mst_ormas.latitude, mst_ormas.longitude')
                                ->join('mst_ormas', 'mst_ormas.id = trn_pendaftaran.ormas_id', 'left')
                                ->where('trn_pendaftaran.user_id', $userId)
                                ->orderBy('trn_pendaftaran.created_at', 'DESC')
                                ->get()
                                ->getResultArray();

        $activeId = $this->request->getGet('id');
        $activePendaftaran = null;
        if (!empty($activeId)) {
            $activePendaftaran = $this->db->table('trn_pendaftaran')
                                    ->select('trn_pendaftaran.*, mst_ormas.nama_ormas, mst_ormas.alamat, mst_ormas.email, mst_ormas.telepon, mst_ormas.file_logo, mst_ormas.file_berkas, mst_ormas.tgl_sk_kepengurusan, mst_ormas.tgl_sk_kedaluwarsa, mst_ormas.latitude, mst_ormas.longitude')
                                    ->join('mst_ormas', 'mst_ormas.id = trn_pendaftaran.ormas_id', 'left')
                                    ->where('trn_pendaftaran.id', $activeId)
                                    ->where('trn_pendaftaran.user_id', $userId)
                                    ->get()
                                    ->getRowArray();
        }

        if (!$activePendaftaran && !empty($pendaftaranList)) {
            $activePendaftaran = $pendaftaranList[0];
        }

        $data = [
            'title'             => 'Dasbor Pendaftar - SIPAKATAU',
            'pendaftaranList'   => $pendaftaranList,
            'pendaftaran'       => $activePendaftaran
        ];

        return view('user/dashboard', $data);
    }

    public function pengajuan()
    {
        $userId = session()->get('user_id');
        $id = $this->request->getGet('id');

        $pendaftaran = null;
        if (!empty($id)) {
            $pendaftaran = $this->db->table('trn_pendaftaran')
                                    ->select('trn_pendaftaran.*, mst_ormas.nama_ormas, mst_ormas.alamat, mst_ormas.email, mst_ormas.telepon, mst_ormas.file_logo, mst_ormas.file_berkas, mst_ormas.tgl_sk_kepengurusan, mst_ormas.tgl_sk_kedaluwarsa, mst_ormas.latitude, mst_ormas.longitude')
                                    ->join('mst_ormas', 'mst_ormas.id = trn_pendaftaran.ormas_id', 'left')
                                    ->where('trn_pendaftaran.id', $id)
                                    ->where('trn_pendaftaran.user_id', $userId)
                                    ->get()
                                    ->getRowArray();

            if (!$pendaftaran) {
                return redirect()->to('user')->with('error', 'Data pengajuan tidak ditemukan.');
            }

            if (in_array($pendaftaran['status_verifikasi'], ['Pending', 'Approved'])) {
                return redirect()->to('user')->with('error', 'Pengajuan ini sedang diproses atau sudah disetujui, tidak bisa direvisi.');
            }
        }

        $data = [
            'title'       => ($pendaftaran) ? 'Revisi Pengajuan Ormas - SIPAKATAU' : 'Form Pengajuan Ormas - SIPAKATAU',
            'pendaftaran' => $pendaftaran
        ];

        return view('user/form_pengajuan', $data);
    }

    public function simpanPengajuan()
    {
        helper(['app', 'telegram']);
        
        $userId = session()->get('user_id');
        $pendaftaranId = $this->request->getPost('pendaftaran_id');
        $namaOrmas = $this->request->getPost('nama_ormas');
        $alamat = $this->request->getPost('alamat');
        $email = $this->request->getPost('email');
        $telepon = $this->request->getPost('telepon');
        $tglSk = $this->request->getPost('tgl_sk_kepengurusan') ?: null;
        $tglExp = $this->request->getPost('tgl_sk_kedaluwarsa') ?: null;
        $latitude = $this->request->getPost('latitude') ?: null;
        $longitude = $this->request->getPost('longitude') ?: null;

        if (empty($namaOrmas) || empty($alamat)) {
            return redirect()->back()->with('error', 'Nama Ormas dan Alamat wajib diisi.')->withInput();
        }

        // Cek apakah ada pengajuan lama yang ingin direvisi
        $pendaftaran = null;
        if (!empty($pendaftaranId)) {
            $pendaftaran = $this->db->table('trn_pendaftaran')
                                    ->where('id', $pendaftaranId)
                                    ->where('user_id', $userId)
                                    ->get()
                                    ->getRowArray();
        }

        $destination = ROOTPATH . 'public/uploads/ormas';
        if (!is_dir($destination)) {
            mkdir($destination, 0755, true);
        }

        // Handle file_logo upload
        $fileLogo = $this->request->getFile('file_logo');
        $logoFilename = null;

        if ($fileLogo && $fileLogo->isValid() && !$fileLogo->hasMoved()) {
            // Delete old logo if exist
            if ($pendaftaran) {
                $ormasOld = $this->db->table('mst_ormas')->where('id', $pendaftaran['ormas_id'])->get()->getRowArray();
                if ($ormasOld && !empty($ormasOld['file_logo']) && $ormasOld['file_logo'] !== 'default_logo.webp') {
                    @unlink($destination . '/' . $ormasOld['file_logo']);
                }
            }
            $logoFilename = convert_to_webp($fileLogo, $destination, 'ormas_logo_' . time());
        }

        // Handle file_berkas upload
        $fileBerkas = $this->request->getFile('file_berkas');
        $berkasFilename = null;

        if ($fileBerkas && $fileBerkas->isValid() && !$fileBerkas->hasMoved()) {
            // Delete old file if exist
            if ($pendaftaran) {
                $ormasOld = $this->db->table('mst_ormas')->where('id', $pendaftaran['ormas_id'])->get()->getRowArray();
                if ($ormasOld && !empty($ormasOld['file_berkas'])) {
                    @unlink($destination . '/' . $ormasOld['file_berkas']);
                }
            }
            
            $mime = $fileBerkas->getMimeType();
            if (strpos($mime, 'image/') === 0) {
                $berkasFilename = convert_to_webp($fileBerkas, $destination, 'ormas_berkas_' . time());
            } else {
                $berkasFilename = $fileBerkas->getRandomName();
                $fileBerkas->move($destination, $berkasFilename);
            }
        }

        if (!$pendaftaran) {
            // ==========================================
            // KASUS 1: Pengajuan Baru (User baru pertama kali atau tambah pengajuan baru)
            // ==========================================
            $ormasId = sprintf('%04x%04x-%04x-%04x-%04x-%04x%04x%04x', 
                mt_rand(0, 0xffff), mt_rand(0, 0xffff), mt_rand(0, 0xffff), 
                mt_rand(0, 0x0fff) | 0x4000, mt_rand(0, 0x3fff) | 0x8000, 
                mt_rand(0, 0xffff), mt_rand(0, 0xffff), mt_rand(0, 0xffff)
            );
            $newPendaftaranId = sprintf('%04x%04x-%04x-%04x-%04x-%04x%04x%04x', 
                mt_rand(0, 0xffff), mt_rand(0, 0xffff), mt_rand(0, 0xffff), 
                mt_rand(0, 0x0fff) | 0x4000, mt_rand(0, 0x3fff) | 0x8000, 
                mt_rand(0, 0xffff), mt_rand(0, 0xffff), mt_rand(0, 0xffff)
            );

            $nomorRegistrasi = 'REG-' . date('Ymd') . '-' . mt_rand(100, 999);

            // 1. Insert ke mst_ormas
            $this->db->table('mst_ormas')->insert([
                'id'                  => $ormasId,
                'nama_ormas'          => $namaOrmas,
                'alamat'              => $alamat,
                'email'               => $email,
                'telepon'             => $telepon,
                'status'              => 'Aktif',
                'tgl_sk_kepengurusan' => $tglSk,
                'tgl_sk_kedaluwarsa'  => $tglExp,
                'file_logo'           => $logoFilename ?? 'default_logo.webp',
                'file_berkas'         => $berkasFilename,
                'latitude'            => !empty($latitude) ? (double)$latitude : null,
                'longitude'           => !empty($longitude) ? (double)$longitude : null,
                'created_at'          => date('Y-m-d H:i:s')
            ]);

            // 2. Insert ke trn_pendaftaran
            $this->db->table('trn_pendaftaran')->insert([
                'id'                  => $newPendaftaranId,
                'ormas_id'            => $ormasId,
                'user_id'             => $userId,
                'nomor_registrasi'    => $nomorRegistrasi,
                'progress_percentage' => 45, // Pend. verifikasi berkas
                'status_verifikasi'   => 'Pending',
                'alasan_ditolak'      => null,
                'delete_requested'    => 0,
                'created_at'          => date('Y-m-d H:i:s')
            ]);

            // Upgrading user role to 'ormas' immediately on submission
            $this->db->table('sys_users')->where('id', $userId)->update(['role' => 'ormas']);
            session()->set('role', 'ormas');

            log_activity(
                'PENGAJUAN_ORMAS_PUBLIK_LOGIN',
                [],
                ['id' => $ormasId, 'nama_ormas' => $namaOrmas, 'nomor_registrasi' => $nomorRegistrasi],
                'trn_pendaftaran',
                $newPendaftaranId
            );

            // Telegram Notification
            telegram_send_transaction('Pendaftaran Ormas Baru (Logged In)', [
                'Nama Ormas'       => $namaOrmas,
                'No. Registrasi'   => $nomorRegistrasi,
                'Username Akun'    => session()->get('username'),
                'Alamat Secretariat'=> $alamat
            ]);

            return redirect()->to('user')->with('success', 'Pengajuan ormas Anda berhasil dikirim! Silakan pantau status verifikasi Anda di bawah ini.');
        } else {
            // ==========================================
            // KASUS 2: Revisi Pengajuan (Draft / Rejected)
            // ==========================================
            $ormasId = $pendaftaran['ormas_id'];
            $beforeDataOrmas = $this->db->table('mst_ormas')->where('id', $ormasId)->get()->getRowArray();

            $updateDataOrmas = [
                'nama_ormas'          => $namaOrmas,
                'alamat'              => $alamat,
                'email'               => $email,
                'telepon'             => $telepon,
                'tgl_sk_kepengurusan' => $tglSk,
                'tgl_sk_kedaluwarsa'  => $tglExp,
                'latitude'            => !empty($latitude) ? (double)$latitude : null,
                'longitude'           => !empty($longitude) ? (double)$longitude : null,
                'updated_at'          => date('Y-m-d H:i:s')
            ];

            if ($logoFilename) {
                $updateDataOrmas['file_logo'] = $logoFilename;
            }
            if ($berkasFilename) {
                $updateDataOrmas['file_berkas'] = $berkasFilename;
            }

            // Update mst_ormas
            $this->db->table('mst_ormas')->where('id', $ormasId)->update($updateDataOrmas);

            // Update trn_pendaftaran (Re-submit back to Pending status, reset progress to 45%, clear reasons, reset delete requested)
            $this->db->table('trn_pendaftaran')->where('id', $pendaftaran['id'])->update([
                'progress_percentage' => 45,
                'status_verifikasi'   => 'Pending',
                'alasan_ditolak'      => null,
                'delete_requested'    => 0,
                'updated_at'          => date('Y-m-d H:i:s')
            ]);

            // Ensure role is upgraded (just in case)
            $this->db->table('sys_users')->where('id', $userId)->update(['role' => 'ormas']);
            session()->set('role', 'ormas');

            log_activity(
                'REVISI_ORMAS_PUBLIK_LOGIN',
                $beforeDataOrmas,
                array_merge($beforeDataOrmas, $updateDataOrmas),
                'mst_ormas',
                $ormasId
            );

            // Telegram Notification
            telegram_send_transaction('Revisi Berkas Ormas (Logged In)', [
                'Nama Ormas'       => $namaOrmas,
                'No. Registrasi'   => $pendaftaran['nomor_registrasi'],
                'Username Akun'    => session()->get('username'),
                'Status Berubah'   => 'Pending (Di-revisi)'
            ]);

            return redirect()->to('user')->with('success', 'Revisi berkas pendaftaran Anda telah berhasil dikirim ulang.');
        }
    }

    public function mintaHapus(string $id)
    {
        helper(['app']);
        $userId = session()->get('user_id');

        $pendaftaran = $this->db->table('trn_pendaftaran')
                                ->where('id', $id)
                                ->where('user_id', $userId)
                                ->get()
                                ->getRowArray();

        if (!$pendaftaran) {
            return redirect()->to('user')->with('error', 'Pengajuan tidak ditemukan.');
        }

        $this->db->table('trn_pendaftaran')->where('id', $id)->update([
            'delete_requested' => 1,
            'updated_at' => date('Y-m-d H:i:s')
        ]);

        log_activity('MINTA_HAPUS_ORMAS_USER', $pendaftaran, ['delete_requested' => 1], 'trn_pendaftaran', $id);

        return redirect()->to('user')->with('success', 'Permintaan penghapusan Ormas berhasil diajukan. Menunggu persetujuan admin.');
    }

    public function geocode()
    {
        $query = $this->request->getGet('q');
        if (empty($query)) {
            return $this->response->setJSON([]);
        }

        $fullQuery = $query . ", Sinjai, Sulawesi Selatan, Indonesia";
        $url = "https://nominatim.openstreetmap.org/search?format=json&limit=3&q=" . urlencode($fullQuery);

        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        // Set unique User-Agent as required by Nominatim usage policy
        curl_setopt($ch, CURLOPT_USERAGENT, 'SIPAKATAU-App/1.0 (akhmadsultan011@gmail.com)');
        curl_setopt($ch, CURLOPT_TIMEOUT, 10);
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);

        $response = curl_exec($ch);
        $httpCode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
        curl_close($ch);

        if ($httpCode !== 200 || !$response) {
            log_message('error', 'Geocoding failed for query: ' . $fullQuery . '. HTTP Code: ' . $httpCode);
            return $this->response->setJSON([]);
        }

        return $this->response->setContentType('application/json')->setBody($response);
    }
}
