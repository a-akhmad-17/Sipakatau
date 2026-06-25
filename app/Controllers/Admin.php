<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use CodeIgniter\HTTP\ResponseInterface;

class Admin extends BaseController
{
    public function index(): string
    {
        $db = \Config\Database::connect();
        
        $ormas = $db->table('mst_ormas')
                    ->orderBy('created_at', 'DESC')
                    ->get()
                    ->getResultArray();
                    
        $parpol = $db->table('mst_parpol')
                     ->orderBy('nama_parpol', 'ASC')
                     ->get()
                     ->getResultArray();

        // Ambil data registrasi ormas riil
        $pendaftaran = $db->table('trn_pendaftaran')
                          ->select('trn_pendaftaran.*, mst_ormas.nama_ormas, mst_ormas.alamat, mst_ormas.email, mst_ormas.telepon, mst_ormas.file_berkas, mst_ormas.tgl_sk_kepengurusan, mst_ormas.tgl_sk_kedaluwarsa')
                          ->join('mst_ormas', 'mst_ormas.id = trn_pendaftaran.ormas_id', 'left')
                          ->orderBy('trn_pendaftaran.created_at', 'DESC')
                          ->get()
                          ->getResultArray();

        // Ambil data rekomendasi kegiatan riil
        $rekomendasi = $db->table('trn_rekomendasi')
                          ->orderBy('created_at', 'DESC')
                          ->get()
                          ->getResultArray();

        // Ambil data pengaturan
        $settings = $db->table('sys_settings')->get()->getResultArray();
        $settingsMap = [];
        foreach ($settings as $s) {
            $settingsMap[$s['key']] = $s['value'];
        }

        // Decode JSON values
        $settingsMap['profil_misi'] = isset($settingsMap['profil_misi']) ? json_decode($settingsMap['profil_misi'], true) : [];
        $settingsMap['profil_bidang'] = isset($settingsMap['profil_bidang']) ? json_decode($settingsMap['profil_bidang'], true) : [];
        $settingsMap['struktur_organisasi'] = isset($settingsMap['struktur_organisasi']) ? json_decode($settingsMap['struktur_organisasi'], true) : [];
        $settingsMap['video_edukasi'] = isset($settingsMap['video_edukasi']) ? json_decode($settingsMap['video_edukasi'], true) : [];
        $settingsMap['titik_kerawanan'] = isset($settingsMap['titik_kerawanan']) ? json_decode($settingsMap['titik_kerawanan'], true) : [];
        $settingsMap['locked_spj_months'] = isset($settingsMap['locked_spj_months']) ? json_decode($settingsMap['locked_spj_months'], true) : [];

        // Ambil data pengaduan masyarakat
        $pengaduan = $db->table('log_activities')
                        ->where('action', 'DAFTAR_PENGADUAN_ANONIM')
                        ->orderBy('created_at', 'DESC')
                        ->get()
                        ->getResultArray();

        $antrean = $db->table('trn_antrean')
                      ->where('tanggal', date('Y-m-d'))
                      ->orderBy('created_at', 'ASC')
                      ->get()
                      ->getResultArray();

        $data = [
            'title'       => 'Dashboard OPD - SIPAKATAU',
            'ormas'       => $ormas,
            'parpol'      => $parpol,
            'pendaftaran' => $pendaftaran,
            'rekomendasi' => $rekomendasi,
            'pengaduan'   => $pengaduan,
            'antrean'     => $antrean,
            'today'       => date('Y-m-d'),
            'settings'    => $settingsMap
        ];

        return view('admin/dashboard', $data);
    }

    public function toggleOrmas(string $id)
    {
        $db = \Config\Database::connect();
        helper('app');

        $ormas = $db->table('mst_ormas')->where('id', $id)->get()->getRowArray();
        if (!$ormas) {
            return redirect()->back()->with('error', 'Organisasi tidak ditemukan.');
        }

        $newStatus = ($ormas['status'] === 'Aktif') ? 'Tidak Aktif' : 'Aktif';
        
        $db->table('mst_ormas')->where('id', $id)->update(['status' => $newStatus, 'updated_at' => date('Y-m-d H:i:s')]);

        $updatedOrmas = $db->table('mst_ormas')->where('id', $id)->get()->getRowArray();

        log_activity(
            'TOGGLE_ORMAS_STATUS', 
            ['id' => $ormas['id'], 'nama_ormas' => $ormas['nama_ormas'], 'status' => $ormas['status']], 
            ['id' => $updatedOrmas['id'], 'nama_ormas' => $updatedOrmas['nama_ormas'], 'status' => $updatedOrmas['status']], 
            'mst_ormas', 
            $id
        );

        return redirect()->to('admin')->with('success', 'Status ormas "' . $ormas['nama_ormas'] . '" berhasil diubah menjadi ' . $newStatus . '.');
    }

    public function updateKoordinatOrmas()
    {
        $db = \Config\Database::connect();
        helper('app');

        $ormasId = $this->request->getPost('ormas_id');
        $latitude = $this->request->getPost('latitude');
        $longitude = $this->request->getPost('longitude');

        $ormas = $db->table('mst_ormas')->where('id', $ormasId)->get()->getRowArray();
        if (!$ormas) {
            return redirect()->back()->with('error', 'Organisasi tidak ditemukan.');
        }

        $beforeData = $ormas;
        $updateData = [
            'latitude' => !empty($latitude) ? (double)$latitude : null,
            'longitude' => !empty($longitude) ? (double)$longitude : null,
            'updated_at' => date('Y-m-d H:i:s')
        ];

        $db->table('mst_ormas')->where('id', $ormasId)->update($updateData);

        log_activity(
            'UPDATE_KOORDINAT_ORMAS',
            $beforeData,
            array_merge($beforeData, $updateData),
            'mst_ormas',
            $ormasId
        );

        return redirect()->to('admin')->with('success', 'Koordinat ormas "' . $ormas['nama_ormas'] . '" berhasil diperbarui.');
    }

    public function updateKoordinatParpol()
    {
        $db = \Config\Database::connect();
        helper('app');

        $parpolId = $this->request->getPost('parpol_id');
        $latitude = $this->request->getPost('latitude');
        $longitude = $this->request->getPost('longitude');

        $parpol = $db->table('mst_parpol')->where('id', $parpolId)->get()->getRowArray();
        if (!$parpol) {
            return redirect()->back()->with('error', 'Partai Politik tidak ditemukan.');
        }

        $beforeData = $parpol;
        $updateData = [
            'latitude' => !empty($latitude) ? (double)$latitude : null,
            'longitude' => !empty($longitude) ? (double)$longitude : null,
            'updated_at' => date('Y-m-d H:i:s')
        ];

        $db->table('mst_parpol')->where('id', $parpolId)->update($updateData);

        log_activity(
            'UPDATE_KOORDINAT_PARPOL',
            $beforeData,
            array_merge($beforeData, $updateData),
            'mst_parpol',
            $parpolId
        );

        return redirect()->to('admin')->with('success', 'Koordinat Partai Politik "' . $parpol['nama_parpol'] . '" berhasil diperbarui.');
    }

    public function tambahParpol()
    {
        $db = \Config\Database::connect();
        helper(['app', 'telegram']);

        $namaParpol = $this->request->getPost('nama_parpol');
        $ketua = $this->request->getPost('ketua');
        $alamat = $this->request->getPost('alamat');
        $telepon = $this->request->getPost('telepon');
        $latitude = $this->request->getPost('latitude');
        $longitude = $this->request->getPost('longitude');

        if (empty($namaParpol)) {
            return redirect()->back()->with('error', 'Nama Partai Politik wajib diisi.');
        }

        // Upload Logo
        $fileLogo = $this->request->getFile('file_logo');
        $logoFilename = 'default_parpol.webp';
        $destination = ROOTPATH . 'public/uploads/parpol';
        if (!is_dir($destination)) {
            mkdir($destination, 0755, true);
        }
        if ($fileLogo && $fileLogo->isValid() && !$fileLogo->hasMoved()) {
            $logoFilename = convert_to_webp($fileLogo, $destination, 'parpol_' . time());
        }

        // Upload SK
        $fileSk = $this->request->getFile('file_sk');
        $skFilename = null;
        if ($fileSk && $fileSk->isValid() && !$fileSk->hasMoved()) {
            $skFilename = $fileSk->getRandomName();
            $fileSk->move($destination, $skFilename);
        }

        $parpolId = sprintf('%04x%04x-%04x-%04x-%04x-%04x%04x%04x', 
            mt_rand(0, 0xffff), mt_rand(0, 0xffff), mt_rand(0, 0xffff), 
            mt_rand(0, 0x0fff) | 0x4000, mt_rand(0, 0x3fff) | 0x8000, 
            mt_rand(0, 0xffff), mt_rand(0, 0xffff), mt_rand(0, 0xffff)
        );

        $insertData = [
            'id'          => $parpolId,
            'nama_parpol' => $namaParpol,
            'lambang'     => $logoFilename,
            'file_sk'     => $skFilename,
            'alamat'      => $alamat,
            'telepon'     => $telepon,
            'ketua'       => $ketua,
            'latitude'    => !empty($latitude) ? (double)$latitude : null,
            'longitude'   => !empty($longitude) ? (double)$longitude : null,
            'created_at'  => date('Y-m-d H:i:s')
        ];

        $db->table('mst_parpol')->insert($insertData);

        log_activity('TAMBAH_PARPOL_ADMIN', [], $insertData, 'mst_parpol', $parpolId);

        return redirect()->to('admin')->with('success', 'Partai Politik "' . $namaParpol . '" berhasil ditambahkan.');
    }

    public function updateParpol()
    {
        $db = \Config\Database::connect();
        helper(['app', 'telegram']);

        $id = $this->request->getPost('parpol_id');
        $namaParpol = $this->request->getPost('nama_parpol');
        $ketua = $this->request->getPost('ketua');
        $alamat = $this->request->getPost('alamat');
        $telepon = $this->request->getPost('telepon');
        $latitude = $this->request->getPost('latitude');
        $longitude = $this->request->getPost('longitude');

        $parpol = $db->table('mst_parpol')->where('id', $id)->get()->getRowArray();
        if (!$parpol) {
            return redirect()->back()->with('error', 'Partai Politik tidak ditemukan.');
        }

        $beforeData = $parpol;
        $updateData = [
            'nama_parpol' => $namaParpol,
            'ketua'       => $ketua,
            'alamat'      => $alamat,
            'telepon'     => $telepon,
            'latitude'    => !empty($latitude) ? (double)$latitude : null,
            'longitude'   => !empty($longitude) ? (double)$longitude : null,
            'updated_at'  => date('Y-m-d H:i:s')
        ];

        $destination = ROOTPATH . 'public/uploads/parpol';

        // Update Logo
        $fileLogo = $this->request->getFile('file_logo');
        if ($fileLogo && $fileLogo->isValid() && !$fileLogo->hasMoved()) {
            // Delete old logo if not default
            if (!empty($parpol['lambang']) && $parpol['lambang'] !== 'default_parpol.webp') {
                @unlink($destination . '/' . $parpol['lambang']);
            }
            $updateData['lambang'] = convert_to_webp($fileLogo, $destination, 'parpol_' . time());
        }

        // Update SK
        $fileSk = $this->request->getFile('file_sk');
        if ($fileSk && $fileSk->isValid() && !$fileSk->hasMoved()) {
            // Delete old SK
            if (!empty($parpol['file_sk'])) {
                @unlink($destination . '/' . $parpol['file_sk']);
            }
            $skFilename = $fileSk->getRandomName();
            $fileSk->move($destination, $skFilename);
            $updateData['file_sk'] = $skFilename;
        }

        $db->table('mst_parpol')->where('id', $id)->update($updateData);

        log_activity('UPDATE_PARPOL_ADMIN', $beforeData, array_merge($beforeData, $updateData), 'mst_parpol', $id);

        return redirect()->to('admin')->with('success', 'Data Partai Politik "' . $namaParpol . '" berhasil diperbarui.');
    }

    public function deleteParpol(string $id)
    {
        $db = \Config\Database::connect();
        helper(['app']);

        $parpol = $db->table('mst_parpol')->where('id', $id)->get()->getRowArray();
        if (!$parpol) {
            return redirect()->back()->with('error', 'Partai Politik tidak ditemukan.');
        }

        $destination = ROOTPATH . 'public/uploads/parpol';
        
        // Delete logo file
        if (!empty($parpol['lambang']) && $parpol['lambang'] !== 'default_parpol.webp') {
            @unlink($destination . '/' . $parpol['lambang']);
        }

        // Delete SK file
        if (!empty($parpol['file_sk'])) {
            @unlink($destination . '/' . $parpol['file_sk']);
        }

        $db->table('mst_parpol')->where('id', $id)->delete();

        log_activity('HAPUS_PARPOL_ADMIN', $parpol, [], 'mst_parpol', $id);

        return redirect()->to('admin')->with('success', 'Partai Politik "' . $parpol['nama_parpol'] . '" berhasil dihapus.');
    }

    public function prosesPendaftaran(string $id, string $action)
    {
        $db = \Config\Database::connect();
        helper('app');

        $pendaftaran = $db->table('trn_pendaftaran')->where('id', $id)->get()->getRowArray();
        if (!$pendaftaran) {
            return redirect()->back()->with('error', 'Data pendaftaran tidak ditemukan.');
        }

        $beforeData = $pendaftaran;
        $updateData = [];

        if ($action === 'approve_berkas') {
            $updateData = [
                'status_verifikasi' => 'Pending',
                'progress_percentage' => 50,
                'updated_at' => date('Y-m-d H:i:s')
            ];
            $msg = 'Berkas persyaratan berhasil diverifikasi. Dokumen kini berada di tahap Validasi Bidang.';
        } elseif ($action === 'approve_bidang') {
            $updateData = [
                'status_verifikasi' => 'Approved',
                'progress_percentage' => 75,
                'updated_at' => date('Y-m-d H:i:s')
            ];
            $msg = 'Pendaftaran telah divalidasi oleh Bidang terkait. Siap untuk penerbitan TTE.';
        } elseif ($action === 'terbitkan_tte') {
            $file = $this->request->getFile('berkas_rekomendasi');
            $fileName = null;

            if ($file && $file->isValid() && !$file->hasMoved()) {
                $uploadPath = ROOTPATH . 'public/uploads/rekomendasi_ormas/';
                if (!is_dir($uploadPath)) {
                    mkdir($uploadPath, 0777, true);
                }
                
                $fileName = $file->getRandomName();
                $file->move($uploadPath, $fileName);
            } else {
                return redirect()->back()->with('error', 'Gagal mengunggah Surat Rekomendasi. Silakan pilih file yang valid.');
            }

            $updateData = [
                'status_verifikasi' => 'Approved',
                'progress_percentage' => 100,
                'pdf_tte_path' => $fileName,
                'updated_at' => date('Y-m-d H:i:s')
            ];
            $msg = 'Surat Rekomendasi berhasil diunggah dan diterbitkan. Proses registrasi ormas selesai!';
        } elseif ($action === 'reject') {
            $alasan = $this->request->getPost('alasan_ditolak');
            $updateData = [
                'status_verifikasi' => 'Rejected',
                'alasan_ditolak' => $alasan ?: 'Berkas kurang lengkap atau tidak sesuai.',
                'progress_percentage' => 0,
                'updated_at' => date('Y-m-d H:i:s')
            ];
            $msg = 'Pendaftaran ditolak.';
        } else {
            return redirect()->back()->with('error', 'Aksi tidak valid.');
        }

        $db->table('trn_pendaftaran')->where('id', $id)->update($updateData);

        log_activity(
            'PROSES_PENDAFTARAN_ORMAS',
            $beforeData,
            array_merge($beforeData, $updateData),
            'trn_pendaftaran',
            $id
        );

        return redirect()->to('admin')->with('success', $msg);
    }

    public function prosesRekomendasi(string $id, string $action)
    {
        $db = \Config\Database::connect();
        helper('app');

        $rekomendasi = $db->table('trn_rekomendasi')->where('id', $id)->get()->getRowArray();
        if (!$rekomendasi) {
            return redirect()->back()->with('error', 'Data rekomendasi tidak ditemukan.');
        }

        $beforeData = $rekomendasi;
        $updateData = [];

        if ($action === 'approve_bidang') {
            $updateData = [
                'status_rekomendasi' => 'Approved',
                'updated_at' => date('Y-m-d H:i:s')
            ];
            $msg = 'Rekomendasi kegiatan berhasil disetujui Bidang terkait. Siap diterbitkan TTE.';
        } elseif ($action === 'terbitkan_tte') {
            $tteFilename = 'rekomendasi_' . $id . '_signed.pdf';
            $updateData = [
                'status_rekomendasi' => 'Approved',
                'pdf_tte_path' => 'uploads/tte/' . $tteFilename,
                'updated_at' => date('Y-m-d H:i:s')
            ];
            $msg = 'TTE rekomendasi kegiatan berhasil diterbitkan!';
        } elseif ($action === 'reject') {
            $updateData = [
                'status_rekomendasi' => 'Rejected',
                'updated_at' => date('Y-m-d H:i:s')
            ];
            $msg = 'Pengajuan rekomendasi ditolak.';
        } else {
            return redirect()->back()->with('error', 'Aksi tidak valid.');
        }

        $db->table('trn_rekomendasi')->where('id', $id)->update($updateData);

        log_activity(
            'PROSES_REKOMENDASI_KEGIATAN',
            $beforeData,
            array_merge($beforeData, $updateData),
            'trn_rekomendasi',
            $id
        );

        return redirect()->to('admin')->with('success', $msg);
    }

    public function settingsVisiMisi()
    {
        $db = \Config\Database::connect();
        $settings = $db->table('sys_settings')->where('group', 'profil')->get()->getResultArray();
        $settingsMap = [];
        foreach ($settings as $s) {
            $settingsMap[$s['key']] = $s['value'];
        }
        
        $visi = $settingsMap['profil_visi'] ?? '';
        $misi = isset($settingsMap['profil_misi']) ? json_decode($settingsMap['profil_misi'], true) : [];

        $data = [
            'title' => 'Pengaturan Visi & Misi - SIPAKATAU',
            'visi'  => $visi,
            'misi'  => $misi
        ];

        return view('admin/settings_visi_misi', $data);
    }

    public function settingsBidang()
    {
        $db = \Config\Database::connect();
        $setting = $db->table('sys_settings')->where('key', 'profil_bidang')->get()->getRowArray();
        $bidang = $setting ? json_decode($setting['value'], true) : [];

        $data = [
            'title'  => 'Pengaturan Bidang & Unit - SIPAKATAU',
            'bidang' => $bidang
        ];

        return view('admin/settings_bidang', $data);
    }

    public function settingsStruktur()
    {
        $db = \Config\Database::connect();
        $setting = $db->table('sys_settings')->where('key', 'struktur_organisasi')->get()->getRowArray();
        $struktur = $setting ? json_decode($setting['value'], true) : [];

        $data = [
            'title'    => 'Pengaturan Struktur & Staf - SIPAKATAU',
            'struktur' => $struktur
        ];

        return view('admin/settings_struktur', $data);
    }

    public function settingsVideo()
    {
        $db = \Config\Database::connect();
        $setting = $db->table('sys_settings')->where('key', 'video_edukasi')->get()->getRowArray();
        $videos = $setting ? json_decode($setting['value'], true) : [];

        $data = [
            'title'  => 'Pengaturan Video & Dokumentasi - SIPAKATAU',
            'videos' => $videos
        ];

        return view('admin/settings_video', $data);
    }

    public function settingsSpj()
    {
        $db = \Config\Database::connect();
        $setting = $db->table('sys_settings')->where('key', 'locked_spj_months')->get()->getRowArray();
        $lockedMonths = $setting ? json_decode($setting['value'], true) : [];

        $data = [
            'title'         => 'Pengaturan Kunci SPJ - SIPAKATAU',
            'locked_months' => $lockedMonths
        ];

        return view('admin/settings_spj', $data);
    }

    public function updateVisi()
    {
        $db = \Config\Database::connect();
        helper('app');

        $visi = $this->request->getPost('visi');
        $beforeVisi = $db->table('sys_settings')->where('key', 'profil_visi')->get()->getRowArray();

        $db->table('sys_settings')->replace([
            'key'        => 'profil_visi',
            'value'      => $visi,
            'group'      => 'profil',
            'updated_at' => date('Y-m-d H:i:s')
        ]);

        log_activity('UPDATE_VISI_INSTANSI', $beforeVisi, ['key' => 'profil_visi', 'value' => $visi], 'sys_settings', 'profil_visi');

        return redirect()->to('admin/settings/visi-misi')->with('success', 'Visi instansi berhasil diperbarui.');
    }

    public function tambahMisi()
    {
        $db = \Config\Database::connect();
        helper('app');

        $newMisi = trim($this->request->getPost('misi'));
        if (empty($newMisi)) {
            return redirect()->to('admin/settings/visi-misi')->with('error', 'Butir misi tidak boleh kosong.');
        }

        $existingSetting = $db->table('sys_settings')->where('key', 'profil_misi')->get()->getRowArray();
        $misiList = $existingSetting ? json_decode($existingSetting['value'], true) : [];
        if (!is_array($misiList)) {
            $misiList = [];
        }

        $beforeMisi = $misiList;
        $misiList[] = $newMisi;

        $db->table('sys_settings')->replace([
            'key'        => 'profil_misi',
            'value'      => json_encode($misiList),
            'group'      => 'profil',
            'updated_at' => date('Y-m-d H:i:s')
        ]);

        log_activity('TAMBAH_MISI_INSTANSI', $beforeMisi, $misiList, 'sys_settings', 'profil_misi');

        return redirect()->to('admin/settings/visi-misi')->with('success', 'Butir misi baru berhasil ditambahkan.');
    }

    public function updateMisi()
    {
        $db = \Config\Database::connect();
        helper('app');

        $index = $this->request->getPost('index');
        $val = trim($this->request->getPost('misi'));

        if ($index === null || $val === '') {
            return redirect()->to('admin/settings/visi-misi')->with('error', 'Input data tidak valid.');
        }

        $existingSetting = $db->table('sys_settings')->where('key', 'profil_misi')->get()->getRowArray();
        $misiList = $existingSetting ? json_decode($existingSetting['value'], true) : [];
        if (!is_array($misiList) || !isset($misiList[$index])) {
            return redirect()->to('admin/settings/visi-misi')->with('error', 'Butir misi tidak ditemukan.');
        }

        $beforeMisi = $misiList;
        $misiList[$index] = $val;

        $db->table('sys_settings')->replace([
            'key'        => 'profil_misi',
            'value'      => json_encode($misiList),
            'group'      => 'profil',
            'updated_at' => date('Y-m-d H:i:s')
        ]);

        log_activity('UPDATE_MISI_INSTANSI', $beforeMisi, $misiList, 'sys_settings', 'profil_misi');

        return redirect()->to('admin/settings/visi-misi')->with('success', 'Butir misi berhasil diperbarui.');
    }

    public function deleteMisi(int $index)
    {
        $db = \Config\Database::connect();
        helper('app');

        $existingSetting = $db->table('sys_settings')->where('key', 'profil_misi')->get()->getRowArray();
        $misiList = $existingSetting ? json_decode($existingSetting['value'], true) : [];
        if (!is_array($misiList) || !isset($misiList[$index])) {
            return redirect()->to('admin/settings/visi-misi')->with('error', 'Butir misi tidak ditemukan.');
        }

        $beforeMisi = $misiList;
        unset($misiList[$index]);
        $misiList = array_values($misiList); // reindex

        $db->table('sys_settings')->replace([
            'key'        => 'profil_misi',
            'value'      => json_encode($misiList),
            'group'      => 'profil',
            'updated_at' => date('Y-m-d H:i:s')
        ]);

        log_activity('HAPUS_MISI_INSTANSI', $beforeMisi, $misiList, 'sys_settings', 'profil_misi');

        return redirect()->to('admin/settings/visi-misi')->with('success', 'Butir misi berhasil dihapus.');
    }

    public function updateBidang()
    {
        $db = \Config\Database::connect();
        helper('app');

        $bidangId = $this->request->getPost('bidang_id');
        $desc = trim($this->request->getPost('description'));
        $subUnits = $this->request->getPost('sub_units') ?? [];

        if (empty($bidangId)) {
            return redirect()->to('admin/settings/bidang')->with('error', 'Bidang tidak valid.');
        }

        // Clean sub-units
        $subUnitsClean = array_values(array_filter(array_map('trim', $subUnits)));

        $existingSetting = $db->table('sys_settings')->where('key', 'profil_bidang')->get()->getRowArray();
        $bidangData = $existingSetting ? json_decode($existingSetting['value'], true) : [];

        $beforeBidang = $bidangData;
        $updated = false;

        foreach ($bidangData as &$b) {
            if ($b['id'] === $bidangId) {
                $b['description'] = $desc;
                $b['sub_units'] = $subUnitsClean;
                $updated = true;
                break;
            }
        }

        if (!$updated) {
            return redirect()->to('admin/settings/bidang')->with('error', 'Bidang tidak ditemukan.');
        }

        $db->table('sys_settings')->replace([
            'key'        => 'profil_bidang',
            'value'      => json_encode($bidangData),
            'group'      => 'profil',
            'updated_at' => date('Y-m-d H:i:s')
        ]);

        log_activity('UPDATE_BIDANG_DAN_UNIT', $beforeBidang, $bidangData, 'sys_settings', 'profil_bidang');

        return redirect()->to('admin/settings/bidang')->with('success', 'Data Bidang & Unit berhasil diperbarui.');
    }

    private function saveBase64Photo(string $base64Data, string $idPrefix): ?string
    {
        if (empty($base64Data)) {
            return null;
        }

        // Parse base64 string
        if (strpos($base64Data, ',') !== false) {
            list($type, $data) = explode(';', $base64Data);
            list(, $data)      = explode(',', $data);
            $decodedData = base64_decode($data);
            
            $destination = ROOTPATH . 'public/uploads/struktur';
            if (!is_dir($destination)) {
                mkdir($destination, 0755, true);
            }
            
            $photoName = $idPrefix . '_' . time() . '.webp';
            
            // Convert to WebP using GD library
            $image = @imagecreatefromstring($decodedData);
            if ($image) {
                imagewebp($image, $destination . '/' . $photoName, 80);
                imagedestroy($image);
                return $photoName;
            } else {
                file_put_contents($destination . '/' . $photoName, $decodedData);
                return $photoName;
            }
        }
        return null;
    }

    public function tambahStaf()
    {
        $db = \Config\Database::connect();
        helper('app');

        $name = $this->request->getPost('name');
        $nip = $this->request->getPost('nip') ?? '-';
        $role = $this->request->getPost('role');
        $category = $this->request->getPost('category');

        if (empty($name) || empty($role) || empty($category)) {
            return redirect()->to('admin/settings/struktur')->with('error', 'Semua kolom bertanda bintang wajib diisi.');
        }

        $newStafId = 'staf_custom_' . time() . '_' . mt_rand(100, 999);
        $photoName = null;

        // Try base64 cropped image first
        $croppedBase64 = $this->request->getPost('cropped_image');
        if (!empty($croppedBase64)) {
            $photoName = $this->saveBase64Photo($croppedBase64, 'foto_' . $newStafId);
        } else {
            // Fallback to normal file upload
            $filePhoto = $this->request->getFile('photo');
            if ($filePhoto && $filePhoto->isValid() && !$filePhoto->hasMoved()) {
                $destination = ROOTPATH . 'public/uploads/struktur';
                if (!is_dir($destination)) {
                    mkdir($destination, 0755, true);
                }
                $prefix = 'foto_custom_' . time();
                $photoName = convert_to_webp($filePhoto, $destination, $prefix);
            }
        }

        // Load existing structure
        $existingSetting = $db->table('sys_settings')->where('key', 'struktur_organisasi')->get()->getRowArray();
        $strukturData = $existingSetting ? json_decode($existingSetting['value'], true) : [];

        $newStaf = [
            'id'       => $newStafId,
            'role'     => trim($role),
            'name'     => trim($name),
            'nip'      => trim($nip),
            'photo'    => $photoName ?? '',
            'category' => $category
        ];

        $strukturData[] = $newStaf;

        $db->table('sys_settings')->replace([
            'key'        => 'struktur_organisasi',
            'value'      => json_encode($strukturData),
            'group'      => 'struktur',
            'updated_at' => date('Y-m-d H:i:s')
        ]);

        log_activity('TAMBAH_ANGGOTA_STRUKTUR', [], $newStaf, 'sys_settings', 'struktur_organisasi');

        return redirect()->to('admin/settings/struktur')->with('success', 'Anggota staf baru "' . $name . '" berhasil ditambahkan.');
    }

    public function updateStaf()
    {
        $db = \Config\Database::connect();
        helper('app');

        $id = $this->request->getPost('id');
        $name = $this->request->getPost('name');
        $nip = $this->request->getPost('nip') ?? '-';
        $role = $this->request->getPost('role');
        $category = $this->request->getPost('category');

        if (empty($id) || empty($name) || empty($role) || empty($category)) {
            return redirect()->to('admin/settings/struktur')->with('error', 'Input data tidak valid.');
        }

        $existingSetting = $db->table('sys_settings')->where('key', 'struktur_organisasi')->get()->getRowArray();
        if (!$existingSetting) {
            return redirect()->to('admin/settings/struktur')->with('error', 'Data struktur organisasi tidak ditemukan.');
        }
        $strukturData = json_decode($existingSetting['value'], true) ?: [];
        $beforeStruktur = $strukturData;

        $updated = false;
        foreach ($strukturData as &$node) {
            if ($node['id'] === $id) {
                $node['name'] = trim($name);
                $node['nip'] = trim($nip);
                $node['role'] = trim($role);
                $node['category'] = $category;

                // Handle photo upload
                $croppedBase64 = $this->request->getPost('cropped_image');
                if (!empty($croppedBase64)) {
                    if (!empty($node['photo']) && strpos($node['photo'], 'default_') !== 0) {
                        @unlink(ROOTPATH . 'public/uploads/struktur/' . $node['photo']);
                    }
                    $photoName = $this->saveBase64Photo($croppedBase64, 'foto_' . $id);
                    if ($photoName) {
                        $node['photo'] = $photoName;
                    }
                } else {
                    $filePhoto = $this->request->getFile('photo');
                    if ($filePhoto && $filePhoto->isValid() && !$filePhoto->hasMoved()) {
                        if (!empty($node['photo']) && strpos($node['photo'], 'default_') !== 0) {
                            @unlink(ROOTPATH . 'public/uploads/struktur/' . $node['photo']);
                        }
                        $destination = ROOTPATH . 'public/uploads/struktur';
                        $prefix = 'foto_edit_' . time();
                        $photoName = convert_to_webp($filePhoto, $destination, $prefix);
                        if ($photoName) {
                            $node['photo'] = $photoName;
                        }
                    }
                }
                $updated = true;
                break;
            }
        }

        if (!$updated) {
            return redirect()->to('admin/settings/struktur')->with('error', 'Anggota staf tidak ditemukan.');
        }

        $db->table('sys_settings')->replace([
            'key'        => 'struktur_organisasi',
            'value'      => json_encode($strukturData),
            'group'      => 'struktur',
            'updated_at' => date('Y-m-d H:i:s')
        ]);

        log_activity('UPDATE_ANGGOTA_STRUKTUR', $beforeStruktur, $strukturData, 'sys_settings', 'struktur_organisasi');

        return redirect()->to('admin/settings/struktur')->with('success', 'Data staf "' . $name . '" berhasil diperbarui.');
    }

    public function deleteStaf(string $id)
    {
        $coreRoles = ['kaban', 'sekretaris', 'kasubbag_umum', 'kasubbag_keuangan', 'kabid_ideologi', 'kabid_poldagri', 'kabid_ekososbud'];
        if (in_array($id, $coreRoles)) {
            return redirect()->to('admin/settings/struktur')->with('error', 'Anggota staf inti tidak boleh dihapus.');
        }

        $db = \Config\Database::connect();
        helper('app');

        $existingSetting = $db->table('sys_settings')->where('key', 'struktur_organisasi')->get()->getRowArray();
        if (!$existingSetting) {
            return redirect()->to('admin/settings/struktur')->with('error', 'Data struktur organisasi tidak ditemukan.');
        }

        $strukturData = json_decode($existingSetting['value'], true) ?: [];
        $deletedStaf = null;
        $newStruktur = [];

        foreach ($strukturData as $node) {
            if ($node['id'] === $id) {
                $deletedStaf = $node;
                if (!empty($node['photo']) && strpos($node['photo'], 'default_') !== 0) {
                    $photoPath = ROOTPATH . 'public/uploads/struktur/' . $node['photo'];
                    if (file_exists($photoPath)) {
                        @unlink($photoPath);
                    }
                }
            } else {
                $newStruktur[] = $node;
            }
        }

        if (!$deletedStaf) {
            return redirect()->to('admin/settings/struktur')->with('error', 'Staf tidak ditemukan.');
        }

        $db->table('sys_settings')->replace([
            'key'        => 'struktur_organisasi',
            'value'      => json_encode($newStruktur),
            'group'      => 'struktur',
            'updated_at' => date('Y-m-d H:i:s')
        ]);

        log_activity('HAPUS_ANGGOTA_STRUKTUR', $deletedStaf, [], 'sys_settings', 'struktur_organisasi');

        return redirect()->to('admin/settings/struktur')->with('success', 'Anggota staf "' . $deletedStaf['name'] . '" berhasil dihapus.');
    }

    public function tambahVideo()
    {
        $db = \Config\Database::connect();
        helper('app');

        $title = trim($this->request->getPost('title'));
        $type = $this->request->getPost('type') ?? 'edukasi';
        $youtubeInput = trim($this->request->getPost('youtube_id'));
        $category = $this->request->getPost('category') ?? 'Umum';
        $duration = trim($this->request->getPost('duration')) ?: '-';
        $source = trim($this->request->getPost('source')) ?: 'Kesbangpol Sinjai';
        $description = trim($this->request->getPost('description')) ?: '';

        // Check if image file is uploaded
        $fileImage = $this->request->getFile('image');
        $imagePath = '';

        if ($type === 'edukasi') {
            if (empty($title) || empty($youtubeInput)) {
                return redirect()->to('admin/settings/video')->with('error', 'Judul dan URL YouTube wajib diisi untuk Video Edukasi.');
            }
        } else {
            // For dokumentasi, either youtube_id or image must be provided
            $hasImage = ($fileImage && $fileImage->isValid() && !$fileImage->hasMoved());
            if (empty($title) || (empty($youtubeInput) && !$hasImage)) {
                return redirect()->to('admin/settings/video')->with('error', 'Judul serta salah satu dari URL YouTube atau Foto Dokumentasi wajib diisi.');
            }
        }

        // Process image if uploaded
        if ($fileImage && $fileImage->isValid() && !$fileImage->hasMoved()) {
            $destination = ROOTPATH . 'public/uploads/dokumentasi';
            if (!is_dir($destination)) {
                mkdir($destination, 0755, true);
            }
            $imagePath = convert_to_webp($fileImage, $destination, 'doc_' . time());
        }

        // Process gallery images if uploaded
        $galleryPaths = [];
        if ($type === 'dokumentasi') {
            $filesGallery = $this->request->getFileMultiple('image_gallery');
            if ($filesGallery) {
                $destination = ROOTPATH . 'public/uploads/dokumentasi';
                if (!is_dir($destination)) {
                    mkdir($destination, 0755, true);
                }
                foreach ($filesGallery as $fGallery) {
                    if ($fGallery && $fGallery->isValid() && !$fGallery->hasMoved()) {
                        $path = convert_to_webp($fGallery, $destination, 'doc_gallery_' . time() . '_' . mt_rand(100, 999));
                        if (!empty($path)) {
                            $galleryPaths[] = $path;
                        }
                    }
                }
            }
        }

        $youtubeId = '';
        if (!empty($youtubeInput)) {
            if (strlen($youtubeInput) === 11 && preg_match('/^[a-zA-Z0-9_-]{11}$/', $youtubeInput)) {
                $youtubeId = $youtubeInput;
            } else {
                $pattern = '/(?:youtube\.com\/(?:[^\/]+\/.+\/|(?:v|e(?:mbed)?)\/|.*[?&]v=)|youtu\.be\/|youtube\.com\/live\/)([a-zA-Z0-9_-]{11})/';
                if (preg_match($pattern, $youtubeInput, $matches)) {
                    $youtubeId = $matches[1];
                } else {
                    $youtubeId = $youtubeInput;
                }
            }
        }

        $existingSetting = $db->table('sys_settings')->where('key', 'video_edukasi')->get()->getRowArray();
        $videoData = $existingSetting ? json_decode($existingSetting['value'], true) : [];
        if (!is_array($videoData)) {
            $videoData = [];
        }

        $beforeVideos = $videoData;
        $newVideoId = 'video_' . time() . '_' . mt_rand(100, 999);

        $newVideo = [
            'id'            => $newVideoId,
            'title'         => $title,
            'type'          => $type,
            'youtube_id'    => $youtubeId,
            'image_path'    => $imagePath ?: '',
            'image_gallery' => $galleryPaths,
            'category'      => $category,
            'duration'      => $duration,
            'source'        => $source,
            'description'   => $description
        ];

        $videoData[] = $newVideo;

        $db->table('sys_settings')->replace([
            'key'        => 'video_edukasi',
            'value'      => json_encode($videoData),
            'group'      => 'informasi',
            'updated_at' => date('Y-m-d H:i:s')
        ]);

        log_activity('TAMBAH_VIDEO_CMS', $beforeVideos, $videoData, 'sys_settings', 'video_edukasi');

        return redirect()->to('admin/settings/video')->with('success', 'Konten video/dokumentasi baru berhasil dipublikasikan.');
    }

    public function updateVideo()
    {
        $db = \Config\Database::connect();
        helper('app');

        $id = $this->request->getPost('id');
        $title = trim($this->request->getPost('title'));
        $type = $this->request->getPost('type') ?? 'edukasi';
        $youtubeInput = trim($this->request->getPost('youtube_id'));
        $category = $this->request->getPost('category') ?? 'Umum';
        $duration = trim($this->request->getPost('duration')) ?: '-';
        $source = trim($this->request->getPost('source')) ?: 'Kesbangpol Sinjai';
        $description = trim($this->request->getPost('description')) ?: '';

        if (empty($id) || empty($title)) {
            return redirect()->to('admin/settings/video')->with('error', 'Input data tidak valid.');
        }

        // Check if image file is uploaded
        $fileImage = $this->request->getFile('image');
        $hasNewImage = ($fileImage && $fileImage->isValid() && !$fileImage->hasMoved());

        $existingSetting = $db->table('sys_settings')->where('key', 'video_edukasi')->get()->getRowArray();
        if (!$existingSetting) {
            return redirect()->to('admin/settings/video')->with('error', 'Data video tidak ditemukan.');
        }
        $videoData = json_decode($existingSetting['value'], true) ?: [];
        $beforeVideos = $videoData;

        // Find existing video index/data
        $vidKey = null;
        foreach ($videoData as $k => $v) {
            if ($v['id'] === $id) {
                $vidKey = $k;
                break;
            }
        }

        if ($vidKey === null) {
            return redirect()->to('admin/settings/video')->with('error', 'Video tidak ditemukan.');
        }

        $existingVideo = $videoData[$vidKey];

        if ($type === 'edukasi') {
            if (empty($youtubeInput)) {
                return redirect()->to('admin/settings/video')->with('error', 'URL YouTube wajib diisi untuk Video Edukasi.');
            }
        } else {
            // For dokumentasi, either youtube_id or image must be provided
            $hasExistingImage = !empty($existingVideo['image_path']);
            if (empty($youtubeInput) && !$hasNewImage && !$hasExistingImage) {
                return redirect()->to('admin/settings/video')->with('error', 'Judul serta salah satu dari URL YouTube atau Foto Dokumentasi wajib diisi.');
            }
        }

        $youtubeId = '';
        if (!empty($youtubeInput)) {
            if (strlen($youtubeInput) === 11 && preg_match('/^[a-zA-Z0-9_-]{11}$/', $youtubeInput)) {
                $youtubeId = $youtubeInput;
            } else {
                $pattern = '/(?:youtube\.com\/(?:[^\/]+\/.+\/|(?:v|e(?:mbed)?)\/|.*[?&]v=)|youtu\.be\/|youtube\.com\/live\/)([a-zA-Z0-9_-]{11})/';
                if (preg_match($pattern, $youtubeInput, $matches)) {
                    $youtubeId = $matches[1];
                } else {
                    $youtubeId = $youtubeInput;
                }
            }
        }

        $imagePath = $existingVideo['image_path'] ?? '';
        $imageGallery = $existingVideo['image_gallery'] ?? [];

        // If type changed to edukasi, delete all files if exist
        if ($type === 'edukasi') {
            if (!empty($imagePath)) {
                $oldFilePath = ROOTPATH . 'public/uploads/dokumentasi/' . $imagePath;
                if (file_exists($oldFilePath)) {
                    @unlink($oldFilePath);
                }
                $imagePath = '';
            }
            if (!empty($imageGallery) && is_array($imageGallery)) {
                foreach ($imageGallery as $gImg) {
                    $gPath = ROOTPATH . 'public/uploads/dokumentasi/' . $gImg;
                    if (file_exists($gPath)) {
                        @unlink($gPath);
                    }
                }
                $imageGallery = [];
            }
        }

        // Process delete selected gallery files
        if ($type === 'dokumentasi') {
            $deletedGallery = $this->request->getPost('deleted_gallery') ?? [];
            if (!empty($deletedGallery) && is_array($deletedGallery)) {
                foreach ($deletedGallery as $delImg) {
                    $keyToDel = array_search($delImg, $imageGallery);
                    if ($keyToDel !== false) {
                        unset($imageGallery[$keyToDel]);
                        $delPath = ROOTPATH . 'public/uploads/dokumentasi/' . $delImg;
                        if (file_exists($delPath)) {
                            @unlink($delPath);
                        }
                    }
                }
                $imageGallery = array_values($imageGallery); // Reset array keys
            }
        }

        // Process new cover image upload if exists
        if ($type === 'dokumentasi' && $hasNewImage) {
            // Delete old cover
            if (!empty($imagePath)) {
                $oldFilePath = ROOTPATH . 'public/uploads/dokumentasi/' . $imagePath;
                if (file_exists($oldFilePath)) {
                    @unlink($oldFilePath);
                }
            }
            $destination = ROOTPATH . 'public/uploads/dokumentasi';
            if (!is_dir($destination)) {
                mkdir($destination, 0755, true);
            }
            $imagePath = convert_to_webp($fileImage, $destination, 'doc_' . time());
        }

        // Process new gallery upload if exists
        if ($type === 'dokumentasi') {
            $filesGallery = $this->request->getFileMultiple('image_gallery');
            if ($filesGallery) {
                $destination = ROOTPATH . 'public/uploads/dokumentasi';
                if (!is_dir($destination)) {
                    mkdir($destination, 0755, true);
                }
                foreach ($filesGallery as $fGallery) {
                    if ($fGallery && $fGallery->isValid() && !$fGallery->hasMoved()) {
                        $path = convert_to_webp($fGallery, $destination, 'doc_gallery_' . time() . '_' . mt_rand(100, 999));
                        if (!empty($path)) {
                            $imageGallery[] = $path;
                        }
                    }
                }
            }
        }

        // Update entry
        $videoData[$vidKey] = [
            'id'            => $id,
            'title'         => $title,
            'type'          => $type,
            'youtube_id'    => $youtubeId,
            'image_path'    => $imagePath ?: '',
            'image_gallery' => $imageGallery,
            'category'      => $category,
            'duration'      => $duration,
            'source'        => $source,
            'description'   => $description
        ];

        $db->table('sys_settings')->replace([
            'key'        => 'video_edukasi',
            'value'      => json_encode($videoData),
            'group'      => 'informasi',
            'updated_at' => date('Y-m-d H:i:s')
        ]);

        log_activity('UPDATE_VIDEO_CMS', $beforeVideos, $videoData, 'sys_settings', 'video_edukasi');

        return redirect()->to('admin/settings/video')->with('success', 'Konten video/dokumentasi berhasil diperbarui.');
    }

    public function deleteVideo(string $id)
    {
        $db = \Config\Database::connect();
        helper('app');

        $existingSetting = $db->table('sys_settings')->where('key', 'video_edukasi')->get()->getRowArray();
        if (!$existingSetting) {
            return redirect()->to('admin/settings/video')->with('error', 'Data video tidak ditemukan.');
        }
        $videoData = json_decode($existingSetting['value'], true) ?: [];
        $beforeVideos = $videoData;

        $deletedVideo = null;
        $newVideos = [];
        foreach ($videoData as $vid) {
            if ($vid['id'] === $id) {
                $deletedVideo = $vid;
                // Delete physical cover image file if exists
                if (!empty($vid['image_path'])) {
                    $filePath = ROOTPATH . 'public/uploads/dokumentasi/' . $vid['image_path'];
                    if (file_exists($filePath)) {
                        @unlink($filePath);
                    }
                }
                // Delete physical gallery images if exist
                if (!empty($vid['image_gallery']) && is_array($vid['image_gallery'])) {
                    foreach ($vid['image_gallery'] as $gImg) {
                        $gPath = ROOTPATH . 'public/uploads/dokumentasi/' . $gImg;
                        if (file_exists($gPath)) {
                            @unlink($gPath);
                        }
                    }
                }
            } else {
                $newVideos[] = $vid;
            }
        }

        if (!$deletedVideo) {
            return redirect()->to('admin/settings/video')->with('error', 'Video tidak ditemukan.');
        }

        $db->table('sys_settings')->replace([
            'key'        => 'video_edukasi',
            'value'      => json_encode($newVideos),
            'group'      => 'informasi',
            'updated_at' => date('Y-m-d H:i:s')
        ]);

        log_activity('HAPUS_VIDEO_CMS', $deletedVideo, [], 'sys_settings', 'video_edukasi');

        return redirect()->to('admin/settings/video')->with('success', 'Video/dokumentasi berhasil dihapus.');
    }

    public function tambahHotspot()
    {
        $db = \Config\Database::connect();
        helper('app');

        $nama = $this->request->getPost('nama');
        $deskripsi = $this->request->getPost('deskripsi');
        $latitude = $this->request->getPost('latitude');
        $longitude = $this->request->getPost('longitude');
        $level = $this->request->getPost('level');

        if (empty($nama) || empty($latitude) || empty($longitude) || empty($level)) {
            return redirect()->back()->with('error', 'Semua kolom bertanda bintang wajib diisi.');
        }

        // Ambil data setting kerawanan yang ada
        $existingSetting = $db->table('sys_settings')->where('key', 'titik_kerawanan')->get()->getRowArray();
        $hotspots = $existingSetting ? json_decode($existingSetting['value'], true) : [];

        $newHotspotId = 'hotspot_' . time() . '_' . mt_rand(100, 999);
        $newHotspot = [
            'id'        => $newHotspotId,
            'nama'      => trim($nama),
            'deskripsi' => trim($deskripsi),
            'latitude'  => (double) $latitude,
            'longitude' => (double) $longitude,
            'level'     => $level,
            'created_at'=> date('Y-m-d H:i:s')
        ];

        $hotspots[] = $newHotspot;

        $db->table('sys_settings')->replace([
            'key'        => 'titik_kerawanan',
            'value'      => json_encode($hotspots),
            'group'      => 'gis',
            'updated_at' => date('Y-m-d H:i:s')
        ]);

        log_activity(
            'TAMBAH_TITIK_KERAWANAN',
            [],
            $newHotspot,
            'sys_settings',
            'titik_kerawanan'
        );

        return redirect()->to('admin')->with('success', 'Titik kerawanan baru "' . $nama . '" berhasil ditambahkan.');
    }

    public function deleteHotspot(string $id)
    {
        $db = \Config\Database::connect();
        helper('app');

        $existingSetting = $db->table('sys_settings')->where('key', 'titik_kerawanan')->get()->getRowArray();
        if (!$existingSetting) {
            return redirect()->back()->with('error', 'Data titik kerawanan tidak ditemukan.');
        }

        $hotspots = json_decode($existingSetting['value'], true) ?: [];
        $deletedHotspot = null;
        $newHotspots = [];

        foreach ($hotspots as $h) {
            if ($h['id'] === $id) {
                $deletedHotspot = $h;
            } else {
                $newHotspots[] = $h;
            }
        }

        if (!$deletedHotspot) {
            return redirect()->back()->with('error', 'Titik kerawanan tidak ditemukan.');
        }

        $db->table('sys_settings')->replace([
            'key'        => 'titik_kerawanan',
            'value'      => json_encode($newHotspots),
            'group'      => 'gis',
            'updated_at' => date('Y-m-d H:i:s')
        ]);

        log_activity(
            'HAPUS_TITIK_KERAWANAN',
            $deletedHotspot,
            [],
            'sys_settings',
            'titik_kerawanan'
        );

        return redirect()->to('admin')->with('success', 'Titik kerawanan "' . $deletedHotspot['nama'] . '" berhasil dihapus.');
    }

    public function deletePhotoStaf(string $id)
    {
        $db = \Config\Database::connect();
        helper('app');

        // Load existing structure
        $existingSetting = $db->table('sys_settings')->where('key', 'struktur_organisasi')->get()->getRowArray();
        if (!$existingSetting) {
            return redirect()->to('admin/settings/struktur')->with('error', 'Data struktur organisasi tidak ditemukan.');
        }

        $strukturData = json_decode($existingSetting['value'], true) ?: [];
        $photoDeleted = false;
        $stafName = '';

        foreach ($strukturData as &$node) {
            if ($node['id'] === $id) {
                $stafName = $node['name'];
                if (!empty($node['photo']) && strpos($node['photo'], 'default_') !== 0) {
                    $photoPath = ROOTPATH . 'public/uploads/struktur/' . $node['photo'];
                    if (file_exists($photoPath)) {
                        @unlink($photoPath);
                    }
                    
                    // Reset to default photo/placeholder depending on role/id
                    $defaultPhoto = '';
                    if ($id === 'kaban') $defaultPhoto = 'default_kaban.webp';
                    elseif ($id === 'sekretaris') $defaultPhoto = 'default_sekretaris.webp';
                    elseif ($id === 'kasubbag_umum') $defaultPhoto = 'default_kasubbag_umum.webp';
                    elseif ($id === 'kasubbag_keuangan') $defaultPhoto = 'default_kasubbag_keuangan.webp';
                    elseif ($id === 'kabid_ideologi') $defaultPhoto = 'default_kabid_ideologi.webp';
                    elseif ($id === 'kabid_poldagri') $defaultPhoto = 'default_kabid_poldagri.webp';
                    elseif ($id === 'kabid_ekososbud') $defaultPhoto = 'default_kabid_ekososbud.webp';
                    else $defaultPhoto = '';

                    $node['photo'] = $defaultPhoto;
                    $photoDeleted = true;
                }
                break;
            }
        }

        if ($photoDeleted) {
            $db->table('sys_settings')->replace([
                'key'        => 'struktur_organisasi',
                'value'      => json_encode($strukturData),
                'group'      => 'struktur',
                'updated_at' => date('Y-m-d H:i:s')
            ]);

            log_activity(
                'HAPUS_FOTO_STAF',
                ['id' => $id, 'name' => $stafName],
                ['id' => $id, 'name' => $stafName, 'photo' => 'deleted'],
                'sys_settings',
                'struktur_organisasi'
            );

            return redirect()->to('admin/settings/struktur')->with('success', 'Foto profil staf "' . $stafName . '" berhasil dihapus.');
        }

        return redirect()->to('admin/settings/struktur')->with('error', 'Staf tidak memiliki foto kustom untuk dihapus.');
    }

    public function panggilAntrean(string $id)
    {
        $db = \Config\Database::connect();
        helper('app');

        $antrean = $db->table('trn_antrean')->where('id', $id)->get()->getRowArray();
        if (!$antrean) {
            return redirect()->back()->with('error', 'Data antrean tidak ditemukan.');
        }

        $beforeData = $antrean;
        $updateData = [
            'status' => 'Dilayani',
            'updated_at' => date('Y-m-d H:i:s')
        ];

        $db->table('trn_antrean')->where('id', $id)->update($updateData);

        log_activity(
            'PANGGIL_ANTREAN',
            $beforeData,
            array_merge($beforeData, $updateData),
            'trn_antrean',
            $id
        );

        return redirect()->to('admin')->with('success', 'Memanggil nomor antrean: ' . $antrean['nomor_antrean']);
    }

    public function selesaiAntrean(string $id)
    {
        $db = \Config\Database::connect();
        helper('app');

        $antrean = $db->table('trn_antrean')->where('id', $id)->get()->getRowArray();
        if (!$antrean) {
            return redirect()->back()->with('error', 'Data antrean tidak ditemukan.');
        }

        $beforeData = $antrean;
        $updateData = [
            'status' => 'Selesai',
            'updated_at' => date('Y-m-d H:i:s')
        ];

        $db->table('trn_antrean')->where('id', $id)->update($updateData);

        log_activity(
            'SELESAI_ANTREAN',
            $beforeData,
            array_merge($beforeData, $updateData),
            'trn_antrean',
            $id
        );

        return redirect()->to('admin')->with('success', 'Antrean ' . $antrean['nomor_antrean'] . ' diselesaikan.');
    }

    public function lewatAntrean(string $id)
    {
        $db = \Config\Database::connect();
        helper('app');

        $antrean = $db->table('trn_antrean')->where('id', $id)->get()->getRowArray();
        if (!$antrean) {
            return redirect()->back()->with('error', 'Data antrean tidak ditemukan.');
        }

        $beforeData = $antrean;
        $updateData = [
            'status' => 'Lewat',
            'updated_at' => date('Y-m-d H:i:s')
        ];

        $db->table('trn_antrean')->where('id', $id)->update($updateData);

        log_activity(
            'LEWATKAN_ANTREAN',
            $beforeData,
            array_merge($beforeData, $updateData),
            'trn_antrean',
            $id
        );

        return redirect()->to('admin')->with('success', 'Antrean ' . $antrean['nomor_antrean'] . ' dilewati.');
    }

    public function updateKunciSpj()
    {
        $db = \Config\Database::connect();
        helper('app');

        $action = $this->request->getPost('action');
        $month = $this->request->getPost('month');

        if (empty($month) || !preg_match('/^\d{4}-\d{2}$/', $month)) {
            return redirect()->to('admin/settings/spj')->with('error', 'Format bulan tidak valid. Gunakan format YYYY-MM.');
        }

        // Ambil data locked_spj_months saat ini
        $existingSetting = $db->table('sys_settings')->where('key', 'locked_spj_months')->get()->getRowArray();
        $lockedMonths = $existingSetting ? json_decode($existingSetting['value'], true) : [];
        if (!is_array($lockedMonths)) {
            $lockedMonths = [];
        }

        $beforeData = ['locked_spj_months' => $lockedMonths];

        if ($action === 'lock') {
            if (!in_array($month, $lockedMonths)) {
                $lockedMonths[] = $month;
            }
            $msg = 'Periode SPJ bulan ' . $month . ' berhasil dikunci.';
        } elseif ($action === 'unlock') {
            $lockedMonths = array_values(array_diff($lockedMonths, [$month]));
            $msg = 'Kunci periode SPJ bulan ' . $month . ' berhasil dibuka.';
        } else {
            return redirect()->to('admin/settings/spj')->with('error', 'Aksi tidak valid.');
        }

        // Sort months descending to keep it tidy
        rsort($lockedMonths);

        $afterData = ['locked_spj_months' => $lockedMonths];

        // Save
        $db->table('sys_settings')->replace([
            'key'        => 'locked_spj_months',
            'value'      => json_encode($lockedMonths),
            'group'      => 'spj',
            'updated_at' => date('Y-m-d H:i:s')
        ]);

        log_activity(
            'UPDATE_KUNCI_SPJ',
            $beforeData,
            $afterData,
            'sys_settings',
            'locked_spj_months'
        );

        return redirect()->to('admin/settings/spj')->with('success', $msg);
    }

    public function deletePendaftaran(string $id)
    {
        $db = \Config\Database::connect();
        helper(['app']);

        $pendaftaran = $db->table('trn_pendaftaran')->where('id', $id)->get()->getRowArray();
        if (!$pendaftaran) {
            return redirect()->back()->with('error', 'Data pendaftaran tidak ditemukan.');
        }

        // Ambil data ormas terkait
        $ormas = $db->table('mst_ormas')->where('id', $pendaftaran['ormas_id'])->get()->getRowArray();

        // Hapus file berkas ormas
        if ($ormas && !empty($ormas['file_berkas'])) {
            $filePath = ROOTPATH . 'public/uploads/ormas/' . $ormas['file_berkas'];
            if (file_exists($filePath)) {
                @unlink($filePath);
            }
        }

        // Hapus data
        $db->table('trn_pendaftaran')->where('id', $id)->delete();
        if ($ormas) {
            $db->table('mst_ormas')->where('id', $pendaftaran['ormas_id'])->delete();
        }

        log_activity('HAPUS_PENDAFTARAN_ORMAS', ['pendaftaran' => $pendaftaran, 'ormas' => $ormas], [], 'trn_pendaftaran', $id);

        return redirect()->to('admin')->with('success', 'Berkas pendaftaran Ormas berhasil dihapus.');
    }

    public function deleteRekomendasi(string $id)
    {
        $db = \Config\Database::connect();
        helper(['app']);

        $rekomendasi = $db->table('trn_rekomendasi')->where('id', $id)->get()->getRowArray();
        if (!$rekomendasi) {
            return redirect()->back()->with('error', 'Data rekomendasi tidak ditemukan.');
        }

        // Hapus file proposal
        if (!empty($rekomendasi['file_proposal'])) {
            $filePath = ROOTPATH . 'public/uploads/rekomendasi/' . $rekomendasi['file_proposal'];
            if (file_exists($filePath)) {
                @unlink($filePath);
            }
        }

        // Hapus file TTE jika ada
        if (!empty($rekomendasi['pdf_tte_path'])) {
            $filePath = ROOTPATH . 'public/' . $rekomendasi['pdf_tte_path'];
            if (file_exists($filePath)) {
                @unlink($filePath);
            }
        }

        $db->table('trn_rekomendasi')->where('id', $id)->delete();

        log_activity('HAPUS_REKOMENDASI_KEGIATAN', $rekomendasi, [], 'trn_rekomendasi', $id);

        return redirect()->to('admin')->with('success', 'Berkas rekomendasi kegiatan berhasil dihapus.');
    }

    public function tambahOrmas()
    {
        $db = \Config\Database::connect();
        helper(['app', 'telegram']);

        $namaOrmas = $this->request->getPost('nama_ormas');
        $alamat = $this->request->getPost('alamat');
        $email = $this->request->getPost('email');
        $telepon = $this->request->getPost('telepon');
        $status = $this->request->getPost('status') ?? 'Aktif';
        $tglSk = $this->request->getPost('tgl_sk_kepengurusan') ?: null;
        $tglExp = $this->request->getPost('tgl_sk_kedaluwarsa') ?: null;
        $latitude = $this->request->getPost('latitude');
        $longitude = $this->request->getPost('longitude');

        if (empty($namaOrmas) || empty($alamat)) {
            return redirect()->back()->with('error', 'Nama Ormas dan Alamat wajib diisi.');
        }

        $destination = ROOTPATH . 'public/uploads/ormas';
        if (!is_dir($destination)) {
            mkdir($destination, 0755, true);
        }

        // Upload Logo
        $fileLogo = $this->request->getFile('file_logo');
        $logoFilename = 'default_logo.webp';
        if ($fileLogo && $fileLogo->isValid() && !$fileLogo->hasMoved()) {
            $logoFilename = convert_to_webp($fileLogo, $destination, 'ormas_logo_' . time());
        }

        // Upload Berkas
        $fileBerkas = $this->request->getFile('file_berkas');
        $berkasFilename = null;
        if ($fileBerkas && $fileBerkas->isValid() && !$fileBerkas->hasMoved()) {
            $mime = $fileBerkas->getMimeType();
            if (strpos($mime, 'image/') === 0) {
                $berkasFilename = convert_to_webp($fileBerkas, $destination, 'ormas_berkas_' . time());
            } else {
                $berkasFilename = $fileBerkas->getRandomName();
                $fileBerkas->move($destination, $berkasFilename);
            }
        }

        $ormasId = sprintf('%04x%04x-%04x-%04x-%04x-%04x%04x%04x', 
            mt_rand(0, 0xffff), mt_rand(0, 0xffff), mt_rand(0, 0xffff), 
            mt_rand(0, 0x0fff) | 0x4000, mt_rand(0, 0x3fff) | 0x8000, 
            mt_rand(0, 0xffff), mt_rand(0, 0xffff), mt_rand(0, 0xffff)
        );

        $insertData = [
            'id'                  => $ormasId,
            'nama_ormas'          => $namaOrmas,
            'alamat'              => $alamat,
            'email'               => $email,
            'telepon'             => $telepon,
            'status'              => $status,
            'tgl_sk_kepengurusan' => $tglSk,
            'tgl_sk_kedaluwarsa'  => $tglExp,
            'file_logo'           => $logoFilename,
            'file_berkas'         => $berkasFilename,
            'latitude'            => !empty($latitude) ? (double)$latitude : null,
            'longitude'           => !empty($longitude) ? (double)$longitude : null,
            'created_at'          => date('Y-m-d H:i:s')
        ];

        $db->table('mst_ormas')->insert($insertData);

        log_activity('TAMBAH_ORMAS_ADMIN', [], $insertData, 'mst_ormas', $ormasId);

        return redirect()->to('admin')->with('success', 'Ormas "' . $namaOrmas . '" berhasil ditambahkan.');
    }

    public function updateOrmas()
    {
        $db = \Config\Database::connect();
        helper(['app', 'telegram']);

        $id = $this->request->getPost('ormas_id');
        $namaOrmas = $this->request->getPost('nama_ormas');
        $alamat = $this->request->getPost('alamat');
        $email = $this->request->getPost('email');
        $telepon = $this->request->getPost('telepon');
        $status = $this->request->getPost('status') ?? 'Aktif';
        $tglSk = $this->request->getPost('tgl_sk_kepengurusan') ?: null;
        $tglExp = $this->request->getPost('tgl_sk_kedaluwarsa') ?: null;
        $latitude = $this->request->getPost('latitude');
        $longitude = $this->request->getPost('longitude');

        $ormas = $db->table('mst_ormas')->where('id', $id)->get()->getRowArray();
        if (!$ormas) {
            return redirect()->back()->with('error', 'Ormas tidak ditemukan.');
        }

        $beforeData = $ormas;
        $updateData = [
            'nama_ormas'          => $namaOrmas,
            'alamat'              => $alamat,
            'email'               => $email,
            'telepon'             => $telepon,
            'status'              => $status,
            'tgl_sk_kepengurusan' => $tglSk,
            'tgl_sk_kedaluwarsa'  => $tglExp,
            'latitude'            => !empty($latitude) ? (double)$latitude : null,
            'longitude'           => !empty($longitude) ? (double)$longitude : null,
            'updated_at'          => date('Y-m-d H:i:s')
        ];

        $destination = ROOTPATH . 'public/uploads/ormas';

        // Update Logo
        $fileLogo = $this->request->getFile('file_logo');
        if ($fileLogo && $fileLogo->isValid() && !$fileLogo->hasMoved()) {
            // Delete old logo
            if (!empty($ormas['file_logo']) && $ormas['file_logo'] !== 'default_logo.webp') {
                @unlink($destination . '/' . $ormas['file_logo']);
            }
            $updateData['file_logo'] = convert_to_webp($fileLogo, $destination, 'ormas_logo_' . time());
        }

        // Update Berkas
        $fileBerkas = $this->request->getFile('file_berkas');
        if ($fileBerkas && $fileBerkas->isValid() && !$fileBerkas->hasMoved()) {
            // Delete old berkas
            if (!empty($ormas['file_berkas'])) {
                @unlink($destination . '/' . $ormas['file_berkas']);
            }
            $mime = $fileBerkas->getMimeType();
            if (strpos($mime, 'image/') === 0) {
                $updateData['file_berkas'] = convert_to_webp($fileBerkas, $destination, 'ormas_berkas_' . time());
            } else {
                $berkasFilename = $fileBerkas->getRandomName();
                $fileBerkas->move($destination, $berkasFilename);
                $updateData['file_berkas'] = $berkasFilename;
            }
        }

        $db->table('mst_ormas')->where('id', $id)->update($updateData);

        log_activity('UPDATE_ORMAS_ADMIN', $beforeData, array_merge($beforeData, $updateData), 'mst_ormas', $id);

        return redirect()->to('admin')->with('success', 'Data Ormas "' . $namaOrmas . '" berhasil diperbarui.');
    }

    public function deleteOrmas(string $id)
    {
        $db = \Config\Database::connect();
        helper(['app']);

        $ormas = $db->table('mst_ormas')->where('id', $id)->get()->getRowArray();
        if (!$ormas) {
            return redirect()->back()->with('error', 'Ormas tidak ditemukan.');
        }

        // Check if there is a pendaftaran referencing this ormas
        $pendaftaran = $db->table('trn_pendaftaran')->where('ormas_id', $id)->get()->getRowArray();
        if ($pendaftaran) {
            // Instead of deleting directly, set delete_requested = 1
            $db->table('trn_pendaftaran')->where('id', $pendaftaran['id'])->update([
                'delete_requested' => 1,
                'updated_at' => date('Y-m-d H:i:s')
            ]);
            
            log_activity('MINTA_HAPUS_ORMAS_ADMIN', $ormas, ['delete_requested' => 1], 'mst_ormas', $id);
            return redirect()->to('admin')->with('success', 'Permintaan penghapusan Ormas "' . $ormas['nama_ormas'] . '" telah diajukan. Silakan setujui penghapusan di tab Persetujuan Hapus.');
        }

        // If no pendaftaran (seeded directly), delete directly
        $destination = ROOTPATH . 'public/uploads/ormas';
        if (!empty($ormas['file_logo']) && $ormas['file_logo'] !== 'default_logo.webp') {
            @unlink($destination . '/' . $ormas['file_logo']);
        }
        if (!empty($ormas['file_berkas'])) {
            @unlink($destination . '/' . $ormas['file_berkas']);
        }
        $db->table('mst_ormas')->where('id', $id)->delete();

        log_activity('HAPUS_ORMAS_ADMIN', $ormas, [], 'mst_ormas', $id);
        return redirect()->to('admin')->with('success', 'Ormas "' . $ormas['nama_ormas'] . '" berhasil dihapus langsung.');
    }

    public function setujuiHapusPendaftaran(string $id)
    {
        $db = \Config\Database::connect();
        helper(['app', 'telegram']);

        $pendaftaran = $db->table('trn_pendaftaran')->where('id', $id)->get()->getRowArray();
        if (!$pendaftaran) {
            return redirect()->back()->with('error', 'Data pendaftaran tidak ditemukan.');
        }

        $ormas = $db->table('mst_ormas')->where('id', $pendaftaran['ormas_id'])->get()->getRowArray();
        $destination = ROOTPATH . 'public/uploads/ormas';

        // Delete logo file
        if ($ormas && !empty($ormas['file_logo']) && $ormas['file_logo'] !== 'default_logo.webp') {
            @unlink($destination . '/' . $ormas['file_logo']);
        }

        // Delete berkas file
        if ($ormas && !empty($ormas['file_berkas'])) {
            @unlink($destination . '/' . $ormas['file_berkas']);
        }

        // Delete TTE letter file if exists
        if (!empty($pendaftaran['pdf_tte_path'])) {
            @unlink(ROOTPATH . 'public/uploads/rekomendasi_ormas/' . $pendaftaran['pdf_tte_path']);
        }

        // Delete from database
        $db->table('trn_pendaftaran')->where('id', $id)->delete();
        if ($ormas) {
            $db->table('mst_ormas')->where('id', $ormas['id'])->delete();
        }

        log_activity('SETUJUI_HAPUS_ORMAS_ADMIN', ['pendaftaran' => $pendaftaran, 'ormas' => $ormas], [], 'trn_pendaftaran', $id);

        telegram_send_transaction('🗑️ Penghapusan Ormas Disetujui Admin', [
            'Nama Ormas'       => $ormas ? $ormas['nama_ormas'] : 'Tidak diketahui',
            'No. Registrasi'   => $pendaftaran['nomor_registrasi'],
            'Status'           => 'Terhapus Permanen'
        ]);

        return redirect()->to('admin')->with('success', 'Penghapusan Ormas berhasil disetujui dan data telah dihapus secara permanen.');
    }

    public function tolakHapusPendaftaran(string $id)
    {
        $db = \Config\Database::connect();
        helper(['app']);

        $pendaftaran = $db->table('trn_pendaftaran')->where('id', $id)->get()->getRowArray();
        if (!$pendaftaran) {
            return redirect()->back()->with('error', 'Data pendaftaran tidak ditemukan.');
        }

        $db->table('trn_pendaftaran')->where('id', $id)->update([
            'delete_requested' => 0,
            'updated_at' => date('Y-m-d H:i:s')
        ]);

        log_activity('TOLAK_HAPUS_ORMAS_ADMIN', $pendaftaran, ['delete_requested' => 0], 'trn_pendaftaran', $id);

        return redirect()->to('admin')->with('success', 'Permintaan penghapusan Ormas dibatalkan.');
    }

    public function deletePengaduan(string $id)
    {
        $db = \Config\Database::connect();
        helper('app');

        $pengaduan = $db->table('log_activities')
                        ->where('id', $id)
                        ->where('action', 'DAFTAR_PENGADUAN_ANONIM')
                        ->get()
                        ->getRowArray();

        if (!$pengaduan) {
            return redirect()->back()->with('error', 'Laporan pengaduan tidak ditemukan.');
        }

        $detail = json_decode($pengaduan['after_data'], true) ?? [];
        if (!empty($detail['berkas'])) {
            $filePath = ROOTPATH . 'public/uploads/pengaduan/' . $detail['berkas'];
            if (file_exists($filePath)) {
                @unlink($filePath);
            }
        }

        $db->table('log_activities')->where('id', $id)->delete();

        log_activity('HAPUS_PENGADUAN_ADMIN', $pengaduan, [], 'log_activities', $id);

        return redirect()->to('admin')->with('success', 'Laporan pengaduan berhasil dihapus.');
    }

    public function deleteFilePengaduan(string $id)
    {
        $db = \Config\Database::connect();
        helper('app');

        $pengaduan = $db->table('log_activities')
                        ->where('id', $id)
                        ->where('action', 'DAFTAR_PENGADUAN_ANONIM')
                        ->get()
                        ->getRowArray();

        if (!$pengaduan) {
            return redirect()->back()->with('error', 'Laporan pengaduan tidak ditemukan.');
        }

        $beforeData = $pengaduan;
        $detail = json_decode($pengaduan['after_data'], true) ?? [];
        
        if (!empty($detail['berkas'])) {
            $filePath = ROOTPATH . 'public/uploads/pengaduan/' . $detail['berkas'];
            if (file_exists($filePath)) {
                @unlink($filePath);
            }
            
            // Remove the filename from the data
            $detail['berkas'] = null;
            
            $db->table('log_activities')
               ->where('id', $id)
               ->update([
                   'after_data' => json_encode($detail)
               ]);
            
            $updatedRow = $db->table('log_activities')->where('id', $id)->get()->getRowArray();
            log_activity('HAPUS_FILE_PENGADUAN_ADMIN', $beforeData, $updatedRow, 'log_activities', $id);
            
            return redirect()->to('admin')->with('success', 'File bukti pengaduan berhasil dihapus.');
        }

        return redirect()->to('admin')->with('error', 'Pengaduan tidak memiliki file bukti.');
    }
}

