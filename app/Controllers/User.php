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
        return redirect()->to(base_url('user/ormas'));
    }

    public function ormas()
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
            'title'               => 'Dasbor Ormas - SIPAKATAU',
            'pendaftaranList'     => $pendaftaranList,
            'pendaftaran'         => $activePendaftaran,
        ];

        return view('user/dashboard', $data);
    }

    public function rekomendasi()
    {
        $userId = session()->get('user_id');

        try {
            $riwayatRekomendasi = $this->db->table('trn_rekomendasi')
                                    ->where('user_id', $userId)
                                    ->orderBy('created_at', 'DESC')
                                    ->get()
                                    ->getResultArray();
        } catch (\Exception $e) {
            $riwayatRekomendasi = [];
        }

        $data = [
            'title'              => 'Dasbor Rekomendasi Kegiatan - SIPAKATAU',
            'riwayatRekomendasi' => $riwayatRekomendasi,
        ];

        return view('user/dashboard_rekomendasi', $data);
    }

    public function pengaduan()
    {
        $userId = session()->get('user_id');

        try {
            $riwayatPengaduan = $this->db->table('trn_pengaduan')
                                    ->where('user_id', $userId)
                                    ->orderBy('created_at', 'DESC')
                                    ->get()
                                    ->getResultArray();
        } catch (\Exception $e) {
            $riwayatPengaduan = [];
        }

        $data = [
            'title'            => 'Dasbor Pengaduan Masyarakat - SIPAKATAU',
            'riwayatPengaduan' => $riwayatPengaduan,
        ];

        return view('user/dashboard_pengaduan', $data);
    }

    public function pengajuan()
    {
        $userId = session()->get('user_id');
        $id = $this->request->getGet('id');

        $pendaftaran = null;
        $activeStep = 1;

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

            // Calculate active step
            if ($pendaftaran['status_verifikasi'] === 'Draft' || $pendaftaran['status_verifikasi'] === 'Rejected') {
                $activeStep = $this->request->getGet('step') ? (int)$this->request->getGet('step') : 2;
            } else {
                $activeStep = 3; // Pending or Approved goes to status page
            }

            // Ambil data pengurus dari database
            $pengurus = $this->db->table('mst_ormas_pengurus')
                                 ->where('ormas_id', $pendaftaran['ormas_id'])
                                 ->get()
                                 ->getResultArray();
        } else {
            $pengurus = [];
        }

        $data = [
            'title'       => ($pendaftaran) ? 'Revisi Pengajuan Ormas - SIPAKATAU' : 'Form Pengajuan Ormas - SIPAKATAU',
            'pendaftaran' => $pendaftaran,
            'activeStep'  => $activeStep,
            'pengurus'    => $pengurus
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
        
        $currentStep = (int)$this->request->getPost('current_step') ?: 1;

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

        $tipeOrmas = $this->request->getPost('tipe_ormas') ?? 'Lokal';
        $maxFiles = ($tipeOrmas === 'Lokal') ? 14 : 10;

        // Paksa hitung tanggal kedaluwarsa menjadi 2 tahun jika ormas berjenjang
        if ($tipeOrmas === 'Berjenjang' && !empty($tglSk)) {
            $tglExp = date('Y-m-d', strtotime('+2 years', strtotime($tglSk)));
        }

        if ($currentStep === 1) {
            // ========================================================
            // STEP 1: SIMPAN/UPDATE INFORMASI DASAR (DRAFT)
            // ========================================================
            if (empty($namaOrmas) || empty($alamat)) {
                return redirect()->back()->with('error', 'Nama Ormas dan Alamat wajib diisi.')->withInput();
            }

            if (!$pendaftaran) {
                // INSERT NEW DRAFT
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
                    'file_berkas'         => null,
                    'latitude'            => !empty($latitude) ? (double)$latitude : null,
                    'longitude'           => !empty($longitude) ? (double)$longitude : null,
                    'created_at'          => date('Y-m-d H:i:s')
                ]);

                $this->db->table('trn_pendaftaran')->insert([
                    'id'                  => $newPendaftaranId,
                    'ormas_id'            => $ormasId,
                    'user_id'             => $userId,
                    'nomor_registrasi'    => $nomorRegistrasi,
                    'tipe_ormas'          => $tipeOrmas,
                    'progress_percentage' => 25,
                    'status_verifikasi'   => 'Draft',
                    'alasan_ditolak'      => null,
                    'delete_requested'    => 0,
                    'created_at'          => date('Y-m-d H:i:s')
                ]);

                // Upgrading user role to 'ormas'
                $this->db->table('sys_users')->where('id', $userId)->update(['role' => 'ormas']);
                session()->set('role', 'ormas');

                // Save Kepengurusan
                $pengurusNames = $this->request->getPost('pengurus_nama') ?: [];
                $pengurusJabatans = $this->request->getPost('pengurus_jabatan') ?: [];
                $pengurusPhones = $this->request->getPost('pengurus_no_hp') ?: [];
                $pengurusOldKtp = $this->request->getPost('pengurus_old_ktp') ?: [];
                $pengurusOldPasfoto = $this->request->getPost('pengurus_old_pasfoto') ?: [];
                $pengurusOldBiodata = $this->request->getPost('pengurus_old_biodata') ?: [];
                
                foreach ($pengurusNames as $index => $name) {
                    if (!empty($name)) {
                        $pengurusId = sprintf('%04x%04x-%04x-%04x-%04x-%04x%04x%04x', 
                            mt_rand(0, 0xffff), mt_rand(0, 0xffff), mt_rand(0, 0xffff), 
                            mt_rand(0, 0x0fff) | 0x4000, mt_rand(0, 0x3fff) | 0x8000, 
                            mt_rand(0, 0xffff), mt_rand(0, 0xffff), mt_rand(0, 0xffff)
                        );

                        $this->db->table('mst_ormas_pengurus')->insert([
                            'id'           => $pengurusId,
                            'ormas_id'     => $ormasId,
                            'nama'         => $name,
                            'jabatan'      => $pengurusJabatans[$index] ?? '',
                            'no_hp'        => $pengurusPhones[$index] ?? '',
                            'file_ktp'     => $pengurusOldKtp[$index] ?? null,
                            'file_pasfoto' => $pengurusOldPasfoto[$index] ?? null,
                            'file_biodata' => $pengurusOldBiodata[$index] ?? null,
                            'created_at'   => date('Y-m-d H:i:s'),
                            'updated_at'   => date('Y-m-d H:i:s'),
                        ]);
                    }
                }

                return redirect()->to("user/pengajuan?id={$newPendaftaranId}&step=2")->with('success', 'Informasi dasar ormas berhasil disimpan. Silakan lengkapi berkas persyaratan.');
            } else {
                // UPDATE EXISTING DRAFT / REJECTED
                $ormasId = $pendaftaran['ormas_id'];
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
                $this->db->table('mst_ormas')->where('id', $ormasId)->update($updateDataOrmas);

                // Update trn_pendaftaran
                $this->db->table('trn_pendaftaran')->where('id', $pendaftaranId)->update([
                    'tipe_ormas' => $tipeOrmas,
                    'updated_at' => date('Y-m-d H:i:s')
                ]);

                // Update Kepengurusan
                $this->db->table('mst_ormas_pengurus')->where('ormas_id', $ormasId)->delete();

                $pengurusNames = $this->request->getPost('pengurus_nama') ?: [];
                $pengurusJabatans = $this->request->getPost('pengurus_jabatan') ?: [];
                $pengurusPhones = $this->request->getPost('pengurus_no_hp') ?: [];
                $pengurusOldKtp = $this->request->getPost('pengurus_old_ktp') ?: [];
                $pengurusOldPasfoto = $this->request->getPost('pengurus_old_pasfoto') ?: [];
                $pengurusOldBiodata = $this->request->getPost('pengurus_old_biodata') ?: [];

                foreach ($pengurusNames as $index => $name) {
                    if (!empty($name)) {
                        $pengurusId = sprintf('%04x%04x-%04x-%04x-%04x-%04x%04x%04x', 
                            mt_rand(0, 0xffff), mt_rand(0, 0xffff), mt_rand(0, 0xffff), 
                            mt_rand(0, 0x0fff) | 0x4000, mt_rand(0, 0x3fff) | 0x8000, 
                            mt_rand(0, 0xffff), mt_rand(0, 0xffff), mt_rand(0, 0xffff)
                        );

                        $this->db->table('mst_ormas_pengurus')->insert([
                            'id'           => $pengurusId,
                            'ormas_id'     => $ormasId,
                            'nama'         => $name,
                            'jabatan'      => $pengurusJabatans[$index] ?? '',
                            'no_hp'        => $pengurusPhones[$index] ?? '',
                            'file_ktp'     => $pengurusOldKtp[$index] ?? null,
                            'file_pasfoto' => $pengurusOldPasfoto[$index] ?? null,
                            'file_biodata' => $pengurusOldBiodata[$index] ?? null,
                            'created_at'   => date('Y-m-d H:i:s'),
                            'updated_at'   => date('Y-m-d H:i:s'),
                        ]);
                    }
                }

                return redirect()->to("user/pengajuan?id={$pendaftaranId}&step=2")->with('success', 'Informasi dasar ormas berhasil diperbarui. Silakan lengkapi berkas persyaratan.');
            }
        } elseif ($currentStep === 2) {
            // ========================================================
            // STEP 2: PROSES UNGGAH FILE PERSYARATAN & KIRIM
            // ========================================================
            if (!$pendaftaran) {
                return redirect()->to('user/pengajuan')->with('error', 'Silakan isi informasi dasar ormas terlebih dahulu.');
            }

            $ormasId = $pendaftaran['ormas_id'];
            $ormasOld = $this->db->table('mst_ormas')->where('id', $ormasId)->get()->getRowArray();
            $berkasData = [];
            if ($ormasOld && !empty($ormasOld['file_berkas'])) {
                $berkasData = json_decode($ormasOld['file_berkas'], true) ?: [];
            }

            // Loop and upload each document point
            for ($i = 1; $i <= $maxFiles; $i++) {
                $fileObj = $this->request->getFile('file_berkas_' . $i);
                if ($fileObj && $fileObj->isValid() && !$fileObj->hasMoved()) {
                    // Delete old file for this index if existed
                    if (isset($berkasData[$i]['filename'])) {
                        @unlink($destination . '/' . $berkasData[$i]['filename']);
                    }

                    $newFilename = $fileObj->getRandomName();
                    $fileObj->move($destination, $newFilename);

                    $berkasData[$i] = [
                        'filename' => $newFilename,
                        'size' => round($fileObj->getSize() / 1024 / 1024, 2) . ' MB',
                        'uploaded_at' => date('Y-m-d H:i:s')
                    ];
                }
            }

            $berkasFilename = !empty($berkasData) ? json_encode($berkasData) : null;

            // Update mst_ormas
            $this->db->table('mst_ormas')->where('id', $ormasId)->update([
                'file_berkas' => $berkasFilename,
                'updated_at'  => date('Y-m-d H:i:s')
            ]);

            // Process Pengurus file uploads (Biodata, KTP & Pasfoto)
            $pengurusIds = $this->request->getPost('pengurus_id') ?: [];
            $pengurusOldKtp = $this->request->getPost('pengurus_old_ktp') ?: [];
            $pengurusOldPasfoto = $this->request->getPost('pengurus_old_pasfoto') ?: [];
            $pengurusOldBiodata = $this->request->getPost('pengurus_old_biodata') ?: [];

            foreach ($pengurusIds as $index => $pengurusId) {
                $ktpFilename = $pengurusOldKtp[$index] ?? null;
                $fileKtp = $this->request->getFile('pengurus_ktp_' . $index);
                if ($fileKtp && $fileKtp->isValid() && !$fileKtp->hasMoved()) {
                    if ($ktpFilename) {
                        @unlink($destination . '/' . $ktpFilename);
                    }
                    $ktpFilename = $fileKtp->getRandomName();
                    $fileKtp->move($destination, $ktpFilename);
                }

                $pasfotoFilename = $pengurusOldPasfoto[$index] ?? null;
                $filePasfoto = $this->request->getFile('pengurus_pasfoto_' . $index);
                if ($filePasfoto && $filePasfoto->isValid() && !$filePasfoto->hasMoved()) {
                    if ($pasfotoFilename) {
                        @unlink($destination . '/' . $pasfotoFilename);
                    }
                    $pasfotoFilename = $filePasfoto->getRandomName();
                    $filePasfoto->move($destination, $pasfotoFilename);
                }

                $biodataFilename = $pengurusOldBiodata[$index] ?? null;
                $fileBiodata = $this->request->getFile('pengurus_biodata_' . $index);
                if ($fileBiodata && $fileBiodata->isValid() && !$fileBiodata->hasMoved()) {
                    if ($biodataFilename) {
                        @unlink($destination . '/' . $biodataFilename);
                    }
                    $biodataFilename = $fileBiodata->getRandomName();
                    $fileBiodata->move($destination, $biodataFilename);
                }

                $this->db->table('mst_ormas_pengurus')
                         ->where('id', $pengurusId)
                         ->where('ormas_id', $ormasId)
                         ->update([
                             'file_ktp'      => $ktpFilename,
                             'file_pasfoto'  => $pasfotoFilename,
                             'file_biodata'  => $biodataFilename,
                             'updated_at'    => date('Y-m-d H:i:s')
                         ]);
            }

            // Submit pendaftaran: set status to Pending and progress percentage to 25
            $this->db->table('trn_pendaftaran')->where('id', $pendaftaranId)->update([
                'progress_percentage' => 25,
                'status_verifikasi'   => 'Pending',
                'alasan_ditolak'      => null,
                'updated_at'          => date('Y-m-d H:i:s')
            ]);

            // Telegram Notification
            telegram_send_transaction('Pendaftaran Ormas Diajukan (Logged In)', [
                'Nama Ormas'       => $ormasOld['nama_ormas'],
                'No. Registrasi'   => $pendaftaran['nomor_registrasi'],
                'Username Akun'    => session()->get('username'),
                'Status'           => 'Pending (Menunggu Verifikasi)'
            ]);

            return redirect()->to("user/pengajuan?id={$pendaftaranId}&step=3")->with('success', 'Berkas persyaratan pendaftaran Anda berhasil dikirim! Silakan pantau status verifikasi Anda.');
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

    public function mintaHapusRekomendasi(string $id)
    {
        helper(['app']);
        $userId = session()->get('user_id');

        $rekomendasi = $this->db->table('trn_rekomendasi')
                                ->where('id', $id)
                                ->where('user_id', $userId)
                                ->get()
                                ->getRowArray();

        if (!$rekomendasi) {
            return redirect()->to('user/rekomendasi')->with('error', 'Pengajuan rekomendasi tidak ditemukan.');
        }

        $this->db->table('trn_rekomendasi')->where('id', $id)->update([
            'delete_requested' => 1,
            'updated_at' => date('Y-m-d H:i:s')
        ]);

        log_activity('MINTA_HAPUS_REKOMENDASI_USER', $rekomendasi, ['delete_requested' => 1], 'trn_rekomendasi', $id);

        return redirect()->to('user/rekomendasi')->with('success', 'Permintaan penghapusan Rekomendasi Kegiatan berhasil diajukan. Menunggu persetujuan admin.');
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

    public function reverseGeocode()
    {
        $lat = $this->request->getGet('lat');
        $lng = $this->request->getGet('lng');
        if (empty($lat) || empty($lng)) {
            return $this->response->setJSON([]);
        }

        $url = "https://nominatim.openstreetmap.org/reverse?format=json&lat=" . urlencode($lat) . "&lon=" . urlencode($lng);

        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_USERAGENT, 'SIPAKATAU-App/1.0 (akhmadsultan011@gmail.com)');
        curl_setopt($ch, CURLOPT_TIMEOUT, 10);
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);

        $response = curl_exec($ch);
        $httpCode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
        curl_close($ch);

        if ($httpCode !== 200 || !$response) {
            log_message('error', 'Reverse geocoding failed for lat: ' . $lat . ' lng: ' . $lng);
            return $this->response->setJSON([]);
        }

        return $this->response->setContentType('application/json')->setBody($response);
    }

    public function rekomendasiBaru()
    {
        $data = [
            'title' => 'Form Rekomendasi Kegiatan - SIPAKATAU'
        ];
        return view('user/form_rekomendasi', $data);
    }

    public function pengaduanBaru()
    {
        $bidang = $this->db->table('mst_bidang')->orderBy('nama_bidang', 'ASC')->get()->getResultArray();
        
        $data = [
            'title'  => 'Form Laporan Pengaduan - SIPAKATAU',
            'bidang' => $bidang
        ];
        return view('user/form_pengaduan', $data);
    }
}
