<?php

namespace App\Controllers;

class Home extends BaseController
{
    protected $db;

    public function __construct()
    {
        $this->db = \Config\Database::connect();
    }

    public function index(): string
    {
        $bidang = $this->db->table('mst_bidang')->orderBy('nama_bidang', 'ASC')->get()->getResultArray();

        $setting = $this->db->table('sys_settings')->where('key', 'video_edukasi')->get()->getRowArray();
        $firstVideo = null;
        if ($setting) {
            $videos = json_decode($setting['value'], true);
            if (!empty($videos) && is_array($videos)) {
                $firstVideo = $videos[0];
            }
        }

        // Hitung statistik real dari database
        $totalOrmas = $this->db->table('mst_ormas')
                               ->join('trn_pendaftaran', 'trn_pendaftaran.ormas_id = mst_ormas.id', 'left')
                               ->groupStart()
                                   ->where('trn_pendaftaran.id IS NULL')
                                   ->orWhere('trn_pendaftaran.progress_percentage', 100)
                               ->groupEnd()
                               ->countAllResults();
        $totalRekomendasi = $this->db->table('trn_rekomendasi')->where('status_rekomendasi', 'Approved')->countAllResults();

        // Ambil 3 berita terbaru untuk slider Beranda
        $beritaModel = new \App\Models\BeritaModel();
        $latestNews = $beritaModel->select('mst_berita.*, sys_users.username as author')
                                  ->join('sys_users', 'sys_users.id = mst_berita.created_by', 'left')
                                  ->where('mst_berita.status', 'Published')
                                  ->orderBy('mst_berita.created_at', 'DESC')
                                  ->limit(3)
                                  ->findAll();

        $data = [
            'title'            => 'Portal Layanan Kesbangpol',
            'bidang'           => $bidang,
            'firstVideo'       => $firstVideo,
            'totalOrmas'       => $totalOrmas,
            'totalRekomendasi' => $totalRekomendasi,
            'latestNews'       => $latestNews
        ];
        return view('home/index', $data);
    }

    public function profil(): string
    {
        $settings = $this->db->table('sys_settings')->where('group', 'profil')->get()->getResultArray();
        $settingsMap = [];
        foreach ($settings as $s) {
            $settingsMap[$s['key']] = $s['value'];
        }

        $visi = $settingsMap['profil_visi'] ?? '';
        $misi = isset($settingsMap['profil_misi']) ? json_decode($settingsMap['profil_misi'], true) : [];

        $data = [
            'title' => 'Visi & Misi Badan Kesbangpol Sinjai',
            'visi'  => $visi,
            'misi'  => $misi,
        ];
        return view('profil/profil', $data);
    }

    public function bidangDetail(string $id): string
    {
        $setting = $this->db->table('sys_settings')->where('key', 'profil_bidang')->get()->getRowArray();
        $bidangList = $setting ? json_decode($setting['value'], true) : [];

        $selectedBidang = null;
        if (is_array($bidangList)) {
            foreach ($bidangList as $b) {
                if ($b['id'] === $id) {
                    $selectedBidang = $b;
                    break;
                }
            }
        }

        if (!$selectedBidang) {
            throw \CodeIgniter\Exceptions\PageNotFoundException::forPageNotFound("Bidang/Unit Kerja tidak ditemukan.");
        }

        // Ambil data struktur organisasi untuk personel bidang
        $strukturSetting = $this->db->table('sys_settings')->where('key', 'struktur_organisasi')->get()->getRowArray();
        $struktur = $strukturSetting ? json_decode($strukturSetting['value'], true) : [];

        // Filter staff list by category ($id)
        $staffList = array_filter($struktur, function($staff) use ($id) {
            return ($staff['category'] ?? '') === $id;
        });

        $data = [
            'title'  => $selectedBidang['title'] . ' - Kesbangpol Sinjai',
            'bidang' => $selectedBidang,
            'staff'  => array_values($staffList)
        ];

        return view('profil/bidang', $data);
    }

    public function struktur(): string
    {
        $setting = $this->db->table('sys_settings')->where('key', 'struktur_organisasi')->get()->getRowArray();
        $struktur = [];
        if ($setting) {
            $struktur = json_decode($setting['value'], true);
        }

        $data = [
            'title'    => 'Struktur Organisasi Kesbangpol Sinjai',
            'struktur' => $struktur
        ];
        return view('profil/struktur', $data);
    }

    public function maklumat(): string
    {
        $data = [
            'title' => 'Maklumat Pelayanan Kesbangpol Sinjai'
        ];
        return view('layanan/maklumat', $data);
    }

    public function daftarOrmas()
    {
        if (!session()->get('logged_in')) {
            return redirect()->to('login')->with('error', 'Silakan masuk/daftar akun terlebih dahulu untuk melakukan pendaftaran Ormas agar progres dapat dipantau di dasbor.');
        }
        return redirect()->to('user/pengajuan');
    }

    public function simpanOrmas()
    {
        helper(['app', 'telegram']);
        $namaOrmas = $this->request->getPost('nama_ormas');
        $email = $this->request->getPost('email');
        $telepon = $this->request->getPost('telepon');
        $alamat = $this->request->getPost('alamat');

        // Handle file_berkas upload
        $fileBerkas = $this->request->getFile('file_berkas');
        $berkasFilename = null;

        if ($fileBerkas && $fileBerkas->isValid() && !$fileBerkas->hasMoved()) {
            $mime = $fileBerkas->getMimeType();
            $destination = ROOTPATH . 'public/uploads/ormas';
            if (!is_dir($destination)) {
                mkdir($destination, 0755, true);
            }

            if (strpos($mime, 'image/') === 0) {
                // Auto WebP conversion for images
                $berkasFilename = convert_to_webp($fileBerkas, $destination, 'berkas_' . time());
            } else {
                // PDF/ZIP etc.
                $berkasFilename = $fileBerkas->getRandomName();
                $fileBerkas->move($destination, $berkasFilename);
            }
        }

        // Generate UUIDs
        $ormasId = sprintf('%04x%04x-%04x-%04x-%04x-%04x%04x%04x', 
            mt_rand(0, 0xffff), mt_rand(0, 0xffff), mt_rand(0, 0xffff), 
            mt_rand(0, 0x0fff) | 0x4000, mt_rand(0, 0x3fff) | 0x8000, 
            mt_rand(0, 0xffff), mt_rand(0, 0xffff), mt_rand(0, 0xffff)
        );
        $pendaftaranId = sprintf('%04x%04x-%04x-%04x-%04x-%04x%04x%04x', 
            mt_rand(0, 0xffff), mt_rand(0, 0xffff), mt_rand(0, 0xffff), 
            mt_rand(0, 0x0fff) | 0x4000, mt_rand(0, 0x3fff) | 0x8000, 
            mt_rand(0, 0xffff), mt_rand(0, 0xffff), mt_rand(0, 0xffff)
        );

        $nomorRegistrasi = 'REG-' . date('Ymd') . '-' . mt_rand(100, 999);

        // 1. Insert into mst_ormas
        $this->db->table('mst_ormas')->insert([
            'id' => $ormasId,
            'nama_ormas' => $namaOrmas,
            'alamat' => $alamat,
            'email' => $email,
            'telepon' => $telepon,
            'status' => 'Aktif',
            'tgl_sk_kepengurusan' => date('Y-m-d'),
            'tgl_sk_kedaluwarsa' => date('Y-m-d', strtotime('+5 years')),
            'file_logo' => 'default_logo.webp',
            'file_berkas' => $berkasFilename,
            'created_at' => date('Y-m-d H:i:s')
        ]);

        // 2. Insert into trn_pendaftaran
        $this->db->table('trn_pendaftaran')->insert([
            'id' => $pendaftaranId,
            'ormas_id' => $ormasId,
            'nomor_registrasi' => $nomorRegistrasi,
            'progress_percentage' => 45, // starts at 45% (pending verification)
            'status_verifikasi' => 'Pending',
            'created_at' => date('Y-m-d H:i:s')
        ]);

        // Activity log
        log_activity(
            'DAFTAR_ORMAS_PUBLIK',
            [],
            ['id' => $ormasId, 'nama_ormas' => $namaOrmas, 'nomor_registrasi' => $nomorRegistrasi, 'file_berkas' => $berkasFilename],
            'trn_pendaftaran',
            $pendaftaranId
        );

        // Kirim notifikasi Telegram
        telegram_send_transaction('Pendaftaran Ormas Baru', [
            'Nama Ormas'       => $namaOrmas,
            'No. Registrasi'   => $nomorRegistrasi,
            'Email Kontak'     => $email,
            'Nomor Telepon'    => $telepon,
            'Alamat Sekretariat'=> $alamat,
            'Berkas Lampiran'  => $berkasFilename ? 'Ada (Format PDF/ZIP di panel admin)' : 'Tidak ada'
        ]);

        return redirect()->to(base_url('layanan/lacak?nomor=' . $nomorRegistrasi))
                          ->with('success', 'Registrasi Ormas berhasil dikirim! Simpan Nomor Registrasi Anda: ' . $nomorRegistrasi);
    }
    public function daftarRekomendasi()
    {
        // Guard: harus login
        if (!session()->get('logged_in')) {
            session()->set('intended_url', base_url('user/rekomendasi'));
            return redirect()->to('login')->with('info', 'Silakan masuk terlebih dahulu untuk mengajukan rekomendasi kegiatan.');
        }
        
        return redirect()->to(base_url('user/rekomendasi'));
    }

    public function simpanRekomendasi()
    {
        helper(['app', 'telegram']);
        $pemohon = $this->request->getPost('pemohon');
        $namaKegiatan = $this->request->getPost('nama_kegiatan');
        $tglMulai = $this->request->getPost('tgl_mulai');
        $tglSelesai = $this->request->getPost('tgl_selesai');
        $deskripsi = $this->request->getPost('deskripsi');
        $lokasiKegiatan = $this->request->getPost('lokasi_kegiatan');
        $pakeFasilitas = $this->request->getPost('pake_fasilitas') === 'Ya' ? 1 : 0;

        // Handle multiple file uploads for the 6 requirements
        $berkasData = [];
        $destination = ROOTPATH . 'public/uploads/rekomendasi';
        if (!is_dir($destination)) {
            mkdir($destination, 0755, true);
        }

        for ($i = 1; $i <= 6; $i++) {
            $fileObj = $this->request->getFile('file_proposal_' . $i);
            if ($fileObj && $fileObj->isValid() && !$fileObj->hasMoved()) {
                $mime = $fileObj->getMimeType();
                if (strpos($mime, 'image/') === 0) {
                    $newFilename = convert_to_webp($fileObj, $destination, 'proposal_file_' . $i . '_' . time());
                } else {
                    $newFilename = $fileObj->getRandomName();
                    $fileObj->move($destination, $newFilename);
                }

                $berkasData[$i] = [
                    'filename' => $newFilename,
                    'size' => round($fileObj->getSize() / 1024 / 1024, 2) . ' MB',
                    'uploaded_at' => date('Y-m-d H:i:s')
                ];
            }
        }

        $proposalFilename = !empty($berkasData) ? json_encode($berkasData) : null;

        $rekomendasiId = sprintf('%04x%04x-%04x-%04x-%04x-%04x%04x%04x', 
            mt_rand(0, 0xffff), mt_rand(0, 0xffff), mt_rand(0, 0xffff), 
            mt_rand(0, 0x0fff) | 0x4000, mt_rand(0, 0x3fff) | 0x8000, 
            mt_rand(0, 0xffff), mt_rand(0, 0xffff), mt_rand(0, 0xffff)
        );

        $this->db->table('trn_rekomendasi')->insert([
            'id'                      => $rekomendasiId,
            'user_id'                 => session()->get('user_id') ?: null,
            'nama_kegiatan'           => $namaKegiatan,
            'pemohon'                 => $pemohon,
            'tgl_mulai'               => $tglMulai,
            'tgl_selesai'             => $tglSelesai,
            'deskripsi'               => $deskripsi,
            'lokasi_kegiatan'         => $lokasiKegiatan,
            'is_fasilitas_pemerintah' => $pakeFasilitas,
            'status_rekomendasi'      => 'Pending',
            'file_proposal'           => $proposalFilename,
            'created_at'              => date('Y-m-d H:i:s')
        ]);

        // Activity log
        log_activity(
            'DAFTAR_REKOMENDASI_PUBLIK',
            [],
            [
                'id' => $rekomendasiId,
                'nama_kegiatan' => $namaKegiatan,
                'pemohon' => $pemohon,
                'tgl_mulai' => $tglMulai,
                'tgl_selesai' => $tglSelesai,
                'deskripsi' => $deskripsi,
                'file_proposal' => $proposalFilename
            ],
            'trn_rekomendasi',
            $rekomendasiId
        );

        // Kirim notifikasi Telegram
        telegram_send_transaction('Pengajuan Rekomendasi Kegiatan Baru', [
            'Pemohon'          => $pemohon,
            'Nama Kegiatan'    => $namaKegiatan,
            'Waktu Kegiatan'   => date('d M Y', strtotime($tglMulai)) . ' s/d ' . date('d M Y', strtotime($tglSelesai)),
            'Keterangan'       => strlen($deskripsi) > 150 ? substr($deskripsi, 0, 150) . '...' : $deskripsi,
            'Berkas Proposal'  => $proposalFilename ? 'Ada (Unduh di panel admin)' : 'Tidak ada'
        ]);

        if (session()->get('user_id')) {
            return redirect()->to(base_url('user'))->with('success', 'Pengajuan rekomendasi kegiatan berhasil dikirim! Silakan pantau status persetujuan di dasbor.');
        }

        return redirect()->to(base_url())->with('success', 'Pengajuan rekomendasi kegiatan berhasil dikirim untuk verifikasi!');
    }

    public function daftarParpol(): string
    {
        $data = [
            'title' => 'Form Register Partai Politik'
        ];
        return view('layanan/form_parpol', $data);
    }

    public function simpanParpol()
    {
        helper(['app', 'telegram']);
        $namaParpol = $this->request->getPost('nama_parpol');
        $alamat = $this->request->getPost('alamat');
        $telepon = $this->request->getPost('telepon');
        $ketua = $this->request->getPost('ketua');

        // Handle file_logo (Lambang) upload
        $fileLogo = $this->request->getFile('file_logo');
        $logoFilename = 'default_parpol.webp';
        $destination = ROOTPATH . 'public/uploads/parpol';
        if (!is_dir($destination)) {
            mkdir($destination, 0755, true);
        }

        if ($fileLogo && $fileLogo->isValid() && !$fileLogo->hasMoved()) {
            $logoFilename = convert_to_webp($fileLogo, $destination, 'parpol_' . time());
        }

        // Handle file_sk (SK Berkas) upload
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

        $this->db->table('mst_parpol')->insert([
            'id'          => $parpolId,
            'nama_parpol' => $namaParpol,
            'lambang'     => $logoFilename,
            'file_sk'     => $skFilename,
            'alamat'      => $alamat,
            'telepon'     => $telepon,
            'ketua'       => $ketua,
            'latitude'    => null,
            'longitude'   => null,
            'created_at'  => date('Y-m-d H:i:s')
        ]);

        // Activity log
        log_activity(
            'DAFTAR_PARPOL_PUBLIK',
            [],
            [
                'id'          => $parpolId,
                'nama_parpol' => $namaParpol,
                'lambang'     => $logoFilename,
                'file_sk'     => $skFilename,
                'alamat'      => $alamat,
                'telepon'     => $telepon,
                'ketua'       => $ketua
            ],
            'mst_parpol',
            $parpolId
        );

        // Kirim notifikasi Telegram
        telegram_send_transaction('Pendaftaran Partai Politik Baru', [
            'Nama Parpol'      => $namaParpol,
            'Ketua Pengurus'   => $ketua,
            'Telepon'          => $telepon,
            'Alamat Sekretariat'=> $alamat,
            'Lambang/Logo'     => $logoFilename !== 'default_parpol.webp' ? 'Ada (Gambar di panel admin)' : 'Default',
            'Berkas SK'        => $skFilename ? 'Ada (PDF/ZIP di panel admin)' : 'Tidak ada'
        ]);

        return redirect()->to(base_url())->with('success', 'Pendaftaran Partai Politik berhasil disimpan ke basis data.');
    }

    public function infoRegistrasi(): string
    {
        $data = [
            'title' => 'Informasi & Regulasi Registrasi Ormas'
        ];
        return view('layanan/info_registrasi', $data);
    }

    public function infoRekomendasi(): string
    {
        $data = [
            'title' => 'Informasi Rekomendasi Kegiatan'
        ];
        return view('layanan/info_rekomendasi', $data);
    }

    public function video(): string
    {
        $setting = $this->db->table('sys_settings')->where('key', 'video_edukasi')->get()->getRowArray();
        $videos = [];
        if ($setting) {
            $allVideos = json_decode($setting['value'], true);
            if (is_array($allVideos)) {
                $videos = array_filter($allVideos, function($v) {
                    $type = $v['type'] ?? 'edukasi';
                    return $type === 'edukasi';
                });
                $videos = array_values($videos);
            }
        }

        $data = [
            'title'  => 'Galeri Video Edukasi Kebangsaan',
            'videos' => $videos
        ];
        return view('informasi/video', $data);
    }

    public function dokumentasi(): string
    {
        $setting = $this->db->table('sys_settings')->where('key', 'video_edukasi')->get()->getRowArray();
        $videos = [];
        if ($setting) {
            $allVideos = json_decode($setting['value'], true);
            if (is_array($allVideos)) {
                $videos = array_filter($allVideos, function($v) {
                    $type = $v['type'] ?? 'edukasi';
                    return $type === 'dokumentasi';
                });
                $videos = array_values($videos);
            }
        }

        $data = [
            'title'  => 'Dokumentasi Kegiatan Kesbangpol',
            'videos' => $videos
        ];
        return view('informasi/dokumentasi', $data);
    }

    public function pengaduan()
    {
        // Guard: harus login sebelum mengisi form pengaduan
        if (!session()->get('logged_in')) {
            session()->set('intended_url', base_url('user/pengaduan'));
            return redirect()->to('login')->with('info', 'Silakan masuk terlebih dahulu untuk mengirim pengaduan.');
        }
        
        return redirect()->to(base_url('user/pengaduan'));
    }

    public function simpanPengaduan()
    {
        helper(['app', 'telegram']);
        $judul = $this->request->getPost('judul');
        $kategori = $this->request->getPost('kategori');
        $deskripsi = $this->request->getPost('deskripsi');
        $bidangId = $this->request->getPost('bidang_id');

        // Resolve nama bidang
        $namaBidang = 'Umum / Seluruhnya';
        if (!empty($bidangId)) {
            $bRow = $this->db->table('mst_bidang')->where('id', $bidangId)->get()->getRowArray();
            if ($bRow) {
                $namaBidang = $bRow['nama_bidang'];
            }
        }

        // Handle file upload
        $fileBerkas = $this->request->getFile('berkas');
        $berkasFilename = null;

        if ($fileBerkas && $fileBerkas->isValid() && !$fileBerkas->hasMoved()) {
            $mime = $fileBerkas->getMimeType();
            $destination = ROOTPATH . 'public/uploads/pengaduan';
            if (!is_dir($destination)) {
                mkdir($destination, 0755, true);
            }

            if (strpos($mime, 'image/') === 0) {
                // Auto WebP conversion for images
                $berkasFilename = convert_to_webp($fileBerkas, $destination, 'aduan_' . time());
            } else {
                // PDF/ZIP etc.
                $berkasFilename = $fileBerkas->getRandomName();
                $fileBerkas->move($destination, $berkasFilename);
            }
        }

        $aduanId = sprintf('%04x%04x-%04x-%04x-%04x-%04x%04x%04x', 
            mt_rand(0, 0xffff), mt_rand(0, 0xffff), mt_rand(0, 0xffff), 
            mt_rand(0, 0x0fff) | 0x4000, mt_rand(0, 0x3fff) | 0x8000, 
            mt_rand(0, 0xffff), mt_rand(0, 0xffff), mt_rand(0, 0xffff)
        );

        $userId = session()->get('user_id') ?: null;

        // Insert into trn_pengaduan table
        $this->db->table('trn_pengaduan')->insert([
            'id'               => $aduanId,
            'user_id'          => $userId,
            'judul'            => $judul,
            'kategori'         => $kategori,
            'bidang_id'        => $bidangId ?: null,
            'deskripsi'        => $deskripsi,
            'berkas'           => $berkasFilename,
            'lokasi_pengaduan' => $this->request->getPost('lokasi_pengaduan') ?: null,
            'status'           => 'Pending',
            'alasan_ditolak'   => null,
            'created_at'       => date('Y-m-d H:i:s'),
            'updated_at'       => date('Y-m-d H:i:s')
        ]);

        // Log as anonymous/registered activity
        log_activity(
            'DAFTAR_PENGADUAN_ANONIM',
            [],
            [
                'id'          => $aduanId,
                'judul'       => $judul,
                'kategori'    => $kategori,
                'deskripsi'   => $deskripsi,
                'bidang_id'   => $bidangId,
                'nama_bidang' => $namaBidang,
                'berkas'      => $berkasFilename
            ],
            'log_activities',
            $aduanId
        );

        // Kirim notifikasi ke Telegram
        $katLabels = [
            'konflik' => 'Potensi Konflik Sosial SARA',
            'ormas'   => 'Pelanggaran/Ketertiban Ormas & LSM',
            'politik' => 'Pelanggaran Kampanye / Politik Praktis',
            'layanan' => 'Keluhan Pelayanan Kesbangpol',
            'lainnya' => 'Lainnya'
        ];
        $katText = $katLabels[$kategori] ?? ucfirst($kategori);

        telegram_send_transaction('Aduan Masyarakat Baru', [
            'Judul'     => $judul,
            'Kategori'  => $katText,
            'Tujuan'    => $namaBidang,
            'Detail'    => strlen($deskripsi) > 150 ? substr($deskripsi, 0, 150) . '...' : $deskripsi,
            'Lampiran'  => $berkasFilename ? 'Ada (Unduh di panel admin)' : 'Tidak ada'
        ]);

        if ($userId) {
            return redirect()->to(base_url('user'))->with('success', 'Aduan Anda berhasil terkirim! Silakan pantau status aduan Anda di dasbor.');
        }

        return redirect()->to(base_url())->with('success', 'Aduan Anda berhasil terkirim secara anonim dan aman. Terima kasih atas partisipasi Anda.');
    }

    public function lacakBerkas(): string
    {
        $nomor = $this->request->getVar('nomor');
        $berkas = null;
        $tipe = 'ormas';

        if (!empty($nomor)) {
            $nomorTrim = trim($nomor);
            // 1. Cari di Pendaftaran Ormas
            $berkas = $this->db->table('trn_pendaftaran')
                               ->select('trn_pendaftaran.*, mst_ormas.nama_ormas, mst_ormas.alamat, mst_ormas.email')
                               ->join('mst_ormas', 'mst_ormas.id = trn_pendaftaran.ormas_id', 'left')
                               ->where('trn_pendaftaran.nomor_registrasi', $nomorTrim)
                               ->get()
                               ->getRowArray();
            
            if ($berkas) {
                $tipe = 'ormas';
            } else {
                // 2. Cari di Rekomendasi Kegiatan (berdasarkan ID/UUID)
                $rek = $this->db->table('trn_rekomendasi')
                                ->where('id', $nomorTrim)
                                ->get()
                                ->getRowArray();
                if ($rek) {
                    $tipe = 'rekomendasi';
                    
                    // Map progress percentage for rekomendasi
                    $progress = 0;
                    $statusVerifikasi = 'Pending';
                    if ($rek['status_rekomendasi'] === 'Pending') {
                        $progress = 50;
                        $statusVerifikasi = 'Pending';
                    } elseif ($rek['status_rekomendasi'] === 'Approved' && empty($rek['pdf_tte_path'])) {
                        $progress = 75;
                        $statusVerifikasi = 'Approved';
                    } elseif ($rek['status_rekomendasi'] === 'Approved' && !empty($rek['pdf_tte_path'])) {
                        $progress = 100;
                        $statusVerifikasi = 'Approved';
                    } elseif ($rek['status_rekomendasi'] === 'Rejected') {
                        $progress = 0;
                        $statusVerifikasi = 'Rejected';
                    }

                    $berkas = [
                        'id' => $rek['id'],
                        'nama_ormas' => $rek['pemohon'], // diselaraskan dengan view
                        'alamat' => $rek['nama_kegiatan'] . ' - ' . $rek['deskripsi'],
                        'email' => '-',
                        'status_verifikasi' => $statusVerifikasi,
                        'progress_percentage' => $progress,
                        'pdf_tte_path' => $rek['pdf_tte_path'],
                        'created_at' => $rek['created_at']
                    ];
                }
            }
        }

        $data = [
            'title'  => 'Status Pelacakan Berkas',
            'berkas' => $berkas,
            'nomor'  => $nomor,
            'tipe'   => $tipe
        ];

        return view('layanan/lacak', $data);
    }

    public function cetakRekomendasi(string $id)
    {
        $rek = $this->db->table('trn_rekomendasi')
                        ->where('id', $id)
                        ->get()
                        ->getRowArray();

        if (!$rek) {
            return redirect()->to(base_url())->with('error', 'Dokumen rekomendasi tidak ditemukan.');
        }

        if ($rek['status_rekomendasi'] !== 'Approved') {
            return redirect()->to(base_url('layanan/lacak?nomor=' . $id))
                             ->with('error', 'Dokumen belum disetujui / ditandatangani secara elektronik.');
        }

        $data = [
            'title' => 'Surat Rekomendasi - ' . esc($rek['pemohon']),
            'rek'   => $rek,
            'today' => date('Y-m-d')
        ];

        return view('layanan/cetak_rekomendasi', $data);
    }

    public function ambilAntrean()
    {
        $validation = \Config\Services::validation();
        $validation->setRules([
            'nama_pengambil' => 'required|min_length[3]|max_length[100]',
            'nik'            => 'required|numeric|exact_length[16]',
            'layanan'        => 'required|in_list[ormas,rekomendasi,konsultasi]',
        ]);

        if (!$validation->withRequest($this->request)->run()) {
            return $this->response->setJSON([
                'status'  => false,
                'message' => implode(' ', $validation->getErrors()),
                'data'    => null
            ]);
        }

        $nama    = $this->request->getPost('nama_pengambil');
        $nik     = $this->request->getPost('nik');
        $layanan = $this->request->getPost('layanan');
        $tanggal = date('Y-m-d');

        // Generate prefix
        $prefix = 'C';
        if ($layanan === 'ormas') {
            $prefix = 'A';
        } elseif ($layanan === 'rekomendasi') {
            $prefix = 'B';
        }

        // Count existing queue numbers for today and service type
        $count = $this->db->table('trn_antrean')
                          ->where('tanggal', $tanggal)
                          ->where('layanan', $layanan)
                          ->countAllResults();

        $nextNum = $count + 1;
        $nomorAntrean = $prefix . '-' . sprintf('%03d', $nextNum);

        $id = sprintf('%04x%04x-%04x-%04x-%04x-%04x%04x%04x', 
            mt_rand(0, 0xffff), mt_rand(0, 0xffff), mt_rand(0, 0xffff), 
            mt_rand(0, 0x0fff) | 0x4000, mt_rand(0, 0x3fff) | 0x8000, 
            mt_rand(0, 0xffff), mt_rand(0, 0xffff), mt_rand(0, 0xffff)
        );

        $insertData = [
            'id'             => $id,
            'nomor_antrean'  => $nomorAntrean,
            'nama_pengambil' => $nama,
            'nik'            => $nik,
            'layanan'        => $layanan,
            'tanggal'        => $tanggal,
            'status'         => 'Menunggu',
            'created_at'     => date('Y-m-d H:i:s'),
            'updated_at'     => date('Y-m-d H:i:s')
        ];

        $this->db->table('trn_antrean')->insert($insertData);

        // Audit Trail log
        helper('app');
        log_activity('TAKE_QUEUE_TICKET', null, $insertData, 'trn_antrean', $id);

        return $this->response->setJSON([
            'status'  => true,
            'message' => 'Nomor antrean berhasil diambil.',
            'data'    => $insertData
        ]);
    }

    public function hapusBerkasDitolak()
    {
        $nomor = $this->request->getPost('nomor');
        $tipe = $this->request->getPost('tipe');

        if (empty($nomor) || empty($tipe)) {
            return redirect()->back()->with('error', 'Parameter tidak lengkap.');
        }

        helper(['app']);

        if ($tipe === 'ormas') {
            $pendaftaran = $this->db->table('trn_pendaftaran')->where('nomor_registrasi', $nomor)->get()->getRowArray();
            if (!$pendaftaran) {
                return redirect()->back()->with('error', 'Berkas pendaftaran tidak ditemukan.');
            }
            if ($pendaftaran['status_verifikasi'] !== 'Rejected') {
                return redirect()->back()->with('error', 'Hanya berkas yang ditolak yang dapat dihapus.');
            }

            // Ambil data ormas terkait
            $ormas = $this->db->table('mst_ormas')->where('id', $pendaftaran['ormas_id'])->get()->getRowArray();

            // Hapus file berkas ormas
            if ($ormas && !empty($ormas['file_berkas'])) {
                $filePath = ROOTPATH . 'public/uploads/ormas/' . $ormas['file_berkas'];
                if (file_exists($filePath)) {
                    @unlink($filePath);
                }
            }

            // Hapus data
            $this->db->table('trn_pendaftaran')->where('id', $pendaftaran['id'])->delete();
            if ($ormas) {
                $this->db->table('mst_ormas')->where('id', $pendaftaran['ormas_id'])->delete();
            }

            log_activity('HAPUS_BERKAS_DITOLAK_PUBLIK', ['pendaftaran' => $pendaftaran, 'ormas' => $ormas], [], 'trn_pendaftaran', $pendaftaran['id']);

            return redirect()->to(base_url())->with('success', 'Berkas pendaftaran Ormas yang ditolak berhasil dihapus dari sistem.');
        } elseif ($tipe === 'rekomendasi') {
            $rekomendasi = $this->db->table('trn_rekomendasi')->where('id', $nomor)->get()->getRowArray();
            if (!$rekomendasi) {
                return redirect()->back()->with('error', 'Berkas rekomendasi tidak ditemukan.');
            }
            if ($rekomendasi['status_rekomendasi'] !== 'Rejected') {
                return redirect()->back()->with('error', 'Hanya berkas yang ditolak yang dapat dihapus.');
            }

            // Hapus file proposal
            if (!empty($rekomendasi['file_proposal'])) {
                $filePath = ROOTPATH . 'public/uploads/rekomendasi/' . $rekomendasi['file_proposal'];
                if (file_exists($filePath)) {
                    @unlink($filePath);
                }
            }

            $this->db->table('trn_rekomendasi')->where('id', $nomor)->delete();

            log_activity('HAPUS_REKOMENDASI_DITOLAK_PUBLIK', $rekomendasi, [], 'trn_rekomendasi', $nomor);

            return redirect()->to(base_url())->with('success', 'Pengajuan rekomendasi kegiatan yang ditolak berhasil dihapus dari sistem.');
        }

        return redirect()->back()->with('error', 'Tipe berkas tidak valid.');
    }

    public function cetakPermohonan(string $id)
    {
        $pendaftaran = $this->db->table('trn_pendaftaran')
                                ->select('trn_pendaftaran.*, mst_ormas.nama_ormas, mst_ormas.alamat, mst_ormas.email, mst_ormas.telepon, mst_ormas.file_logo, mst_ormas.tgl_sk_kepengurusan, mst_ormas.tgl_sk_kedaluwarsa, mst_ormas.latitude, mst_ormas.longitude')
                                ->join('mst_ormas', 'mst_ormas.id = trn_pendaftaran.ormas_id', 'left')
                                ->where('trn_pendaftaran.id', $id)
                                ->get()
                                ->getRowArray();

        if (!$pendaftaran) {
            return redirect()->to(base_url())->with('error', 'Data pendaftaran tidak ditemukan.');
        }

        // Fetch pengurus
        $pengurus = $this->db->table('mst_ormas_pengurus')
                             ->where('ormas_id', $pendaftaran['ormas_id'])
                             ->get()
                             ->getResultArray();

        $data = [
            'title'       => 'Surat Permohonan Pendaftaran - ' . esc($pendaftaran['nama_ormas']),
            'pendaftaran' => $pendaftaran,
            'pengurus'    => $pengurus,
            'today'       => date('Y-m-d')
        ];

        return view('layanan/cetak_permohonan', $data);
    }

    // ==========================================
    // PUBLIC BERITA METHODS
    // ==========================================

    public function berita(): string
    {
        $beritaModel = new \App\Models\BeritaModel();

        $kategori = $this->request->getVar('kategori');
        $q = $this->request->getVar('q');

        $query = $beritaModel->select('mst_berita.*, sys_users.username as author')
                             ->join('sys_users', 'sys_users.id = mst_berita.created_by', 'left')
                             ->where('mst_berita.status', 'Published');

        if (!empty($kategori)) {
            $query->where('mst_berita.kategori', $kategori);
        }

        if (!empty($q)) {
            $query->groupStart()
                  ->like('mst_berita.judul', $q)
                  ->orLike('mst_berita.konten', $q)
                  ->groupEnd();
        }

        $beritaList = $query->orderBy('mst_berita.created_at', 'DESC')
                            ->paginate(9, 'berita');

        $data = [
            'title'      => 'Berita Kesbangpol - SIPAKATAU',
            'berita'     => $beritaList,
            'pager'      => $beritaModel->pager,
            'kategori'   => $kategori,
            'q'          => $q
        ];

        return view('informasi/berita', $data);
    }

    public function beritaDetail(string $slug): string
    {
        $beritaModel = new \App\Models\BeritaModel();

        $berita = $beritaModel->select('mst_berita.*, sys_users.username as author')
                              ->join('sys_users', 'sys_users.id = mst_berita.created_by', 'left')
                              ->where('mst_berita.slug', $slug)
                              ->where('mst_berita.status', 'Published')
                              ->first();

        if (!$berita) {
            throw \CodeIgniter\Exceptions\PageNotFoundException::forPageNotFound("Berita tidak ditemukan.");
        }

        // Increment view count
        $beritaModel->update($berita['id'], [
            'view_count' => $berita['view_count'] + 1
        ]);

        // Get 5 recent news (excluding current one)
        $recentBerita = $beritaModel->where('status', 'Published')
                                    ->where('id !=', $berita['id'])
                                    ->orderBy('created_at', 'DESC')
                                    ->limit(5)
                                    ->findAll();

        $data = [
            'title'        => esc($berita['judul']) . ' - Kesbangpol Sinjai',
            'berita'       => $berita,
            'recentBerita' => $recentBerita
        ];

        return view('informasi/detail_berita', $data);
    }
}

