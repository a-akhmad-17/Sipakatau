<?php

namespace App\Database\Seeds;

use CodeIgniter\Database\Seeder;

class UserSeeder extends Seeder
{
    public function run()
    {
        $db = \Config\Database::connect();
        
        // Helper UUID Generator
        $uuidGen = function () {
            return sprintf('%04x%04x-%04x-%04x-%04x-%04x%04x%04x', 
                mt_rand(0, 0xffff), mt_rand(0, 0xffff), mt_rand(0, 0xffff), 
                mt_rand(0, 0x0fff) | 0x4000, mt_rand(0, 0x3fff) | 0x8000, 
                mt_rand(0, 0xffff), mt_rand(0, 0xffff), mt_rand(0, 0xffff)
            );
        };

        // Static Bidang IDs
        $bidangIds = [
            'IDWASBANG'       => 'b1d00001-beef-4a4a-98d0-fca32b8879f6',
            'POLDAGRI_ORMAS'  => 'b1d00002-beef-4a4a-98d0-fca32b8879f6',
            'EKOSOSBUD'       => 'b1d00003-beef-4a4a-98d0-fca32b8879f6',
        ];

        // 1. Seed sys_users
        $db->table('sys_users')->truncate();
        $users = [
            [
                'id'         => $uuidGen(),
                'username'   => 'admin',
                'password'   => password_hash('admin123', PASSWORD_BCRYPT),
                'email'      => 'admin.kesbangpol@sinjaikab.go.id',
                'role'       => 'admin',
                'status'     => 'active',
                'bidang_id'  => null,
                'created_at' => date('Y-m-d H:i:s'),
                'updated_at' => date('Y-m-d H:i:s'),
            ],
            [
                'id'         => $uuidGen(),
                'username'   => 'kaban',
                'password'   => password_hash('kaban123', PASSWORD_BCRYPT),
                'email'      => 'kaban.kesbangpol@sinjaikab.go.id',
                'role'       => 'kaban',
                'status'     => 'active',
                'bidang_id'  => null,
                'created_at' => date('Y-m-d H:i:s'),
                'updated_at' => date('Y-m-d H:i:s'),
            ],
            [
                'id'         => $uuidGen(),
                'username'   => 'pptk',
                'password'   => password_hash('pptk123', PASSWORD_BCRYPT),
                'email'      => 'pptk.kesbangpol@sinjaikab.go.id',
                'role'       => 'pptk',
                'status'     => 'active',
                'bidang_id'  => $bidangIds['POLDAGRI_ORMAS'], // Linked to POLDAGRI & ORMAS
                'created_at' => date('Y-m-d H:i:s'),
                'updated_at' => date('Y-m-d H:i:s'),
            ],
        ];
        $db->table('sys_users')->insertBatch($users);

        // 2. Seed mst_bidang
        $db->table('mst_bidang')->truncate();
        $bidangData = [
            [
                'id'          => $bidangIds['IDWASBANG'],
                'nama_bidang' => 'Bidang Ideologi, Wawasan Kebangsaan dan Karakter Bangsa',
                'kode_bidang' => 'IDWASBANG',
                'created_at'  => date('Y-m-d H:i:s'),
            ],
            [
                'id'          => $bidangIds['POLDAGRI_ORMAS'],
                'nama_bidang' => 'Bidang Politik Dalam Negeri dan Organisasi Kemasyarakatan',
                'kode_bidang' => 'POLDAGRI_ORMAS',
                'created_at'  => date('Y-m-d H:i:s'),
            ],
            [
                'id'          => $bidangIds['EKOSOSBUD'],
                'nama_bidang' => 'Bidang Ketahanan Ekonomi, Sosial, Budaya dan Agama',
                'kode_bidang' => 'EKOSOSBUD',
                'created_at'  => date('Y-m-d H:i:s'),
            ],
        ];
        $db->table('mst_bidang')->insertBatch($bidangData);

        // 3. Seed mst_ormas
        $db->table('mst_ormas')->truncate();
        $ormasData = [
            [
                'id'                  => 'o1d00001-beef-4a4a-98d0-fca32b8879f6',
                'nama_ormas'          => 'Serikat Mahasiswa Muslim Indonesia (SEMMI)',
                'alamat'              => 'Jl. Jendr. Sudirman No. 19 Kab. Sinjai',
                'email'               => 'semmi@sinjaikab.go.id',
                'telepon'             => '081234567890',
                'status'              => 'Aktif',
                'tgl_sk_kepengurusan' => '2024-01-10',
                'tgl_sk_kedaluwarsa'  => '2029-01-10',
                'file_logo'           => 'default_logo.webp',
                'created_at'          => date('Y-m-d H:i:s'),
            ],
            [
                'id'                  => 'o1d00002-beef-4a4a-98d0-fca32b8879f6',
                'nama_ormas'          => 'Institut Hukum Indonesia (IHI)',
                'alamat'              => 'Jl. Persatuan Raya, Mangottong Kab. Sinjai',
                'email'               => 'ihi@sinjaikab.go.id',
                'telepon'             => '085399881122',
                'status'              => 'Aktif',
                'tgl_sk_kepengurusan' => '2021-05-12',
                'tgl_sk_kedaluwarsa'  => '2026-05-12', // SK KEDALUWARSA (SK Merah!)
                'file_logo'           => 'default_logo.webp',
                'created_at'          => date('Y-m-d H:i:s'),
            ],
            [
                'id'                  => 'o1d00003-beef-4a4a-98d0-fca32b8879f6',
                'nama_ormas'          => 'Persatuan Perawat Indonesia (PPNI)',
                'alamat'              => 'Jl. Jend. Sudirman No. 4 Kec. Sinjai Utara Kab. Sinjai',
                'email'               => 'ppni@sinjaikab.go.id',
                'telepon'             => '082188776655',
                'status'              => 'Aktif',
                'tgl_sk_kepengurusan' => '2023-08-20',
                'tgl_sk_kedaluwarsa'  => '2028-08-20',
                'file_logo'           => 'default_logo.webp',
                'created_at'          => date('Y-m-d H:i:s'),
            ],
            [
                'id'                  => 'o1d00004-beef-4a4a-98d0-fca32b8879f6',
                'nama_ormas'          => 'Yayasan Pendidikan 727 Bina Mandiri',
                'alamat'              => 'Dusun Pao-pao Desa Palangka Kec. Sinjai Selatan Kab. Sinjai',
                'email'               => 'y727bm@sinjaikab.go.id',
                'telepon'             => '081299887766',
                'status'              => 'Aktif',
                'tgl_sk_kepengurusan' => '2022-03-15',
                'tgl_sk_kedaluwarsa'  => '2027-03-15',
                'file_logo'           => 'default_logo.webp',
                'created_at'          => date('Y-m-d H:i:s'),
            ],
            [
                'id'                  => 'o1d00005-beef-4a4a-98d0-fca32b8879f6',
                'nama_ormas'          => 'Lembaga Aliansi Indonesia -Posko Garuda Sakti (LAI-PGS) Kab. Sinjai',
                'alamat'              => 'Dusun mangottong rt 02/rw 01 Desa Saukang Kec. Sinjai Timur Kab. Sinjai',
                'email'               => 'laipgs@sinjaikab.go.id',
                'telepon'             => '081377889900',
                'status'              => 'Aktif',
                'tgl_sk_kepengurusan' => '2024-06-01',
                'tgl_sk_kedaluwarsa'  => '2029-06-01',
                'file_logo'           => 'default_logo.webp',
                'created_at'          => date('Y-m-d H:i:s'),
            ],
            [
                'id'                  => 'o1d00006-beef-4a4a-98d0-fca32b8879f6',
                'nama_ormas'          => 'Ikatan Wartawan Online (IWO) Kab Sinjai',
                'alamat'              => 'Jl Persatuan Raya No 10 Kel Biringere Kec Sinjai Utara Kab Sinjai',
                'email'               => 'iwo@sinjaikab.go.id',
                'telepon'             => '085211223344',
                'status'              => 'Aktif',
                'tgl_sk_kepengurusan' => '2023-11-10',
                'tgl_sk_kedaluwarsa'  => '2028-11-10',
                'file_logo'           => 'default_logo.webp',
                'created_at'          => date('Y-m-d H:i:s'),
            ],
            [
                'id'                  => 'o1d00007-beef-4a4a-98d0-fca32b8879f6',
                'nama_ormas'          => 'Himpunan Mahasiswa Islam (HMI) Kab Sinjai',
                'alamat'              => 'BTN Tuju Wali Kel Biringere Kab Sinjai',
                'email'               => 'hmi@sinjaikab.go.id',
                'telepon'             => '081255667788',
                'status'              => 'Aktif',
                'tgl_sk_kepengurusan' => '2025-02-15',
                'tgl_sk_kedaluwarsa'  => '2027-02-15',
                'file_logo'           => 'default_logo.webp',
                'created_at'          => date('Y-m-d H:i:s'),
            ],
            [
                'id'                  => 'o1d00008-beef-4a4a-98d0-fca32b8879f6',
                'nama_ormas'          => 'Pimpinan Cabang Pemuda Muslimin Indonesia Kab Sinjai',
                'alamat'              => 'Jl Samratulangi No 15 Kel Balangnipa Kab Sinjai',
                'email'               => 'pemudamuslimin@sinjaikab.go.id',
                'telepon'             => '085299008877',
                'status'              => 'Tidak Aktif',
                'tgl_sk_kepengurusan' => '2021-09-05',
                'tgl_sk_kedaluwarsa'  => '2026-09-05', // SK KEDALUWARSA (SK Merah!)
                'file_logo'           => 'default_logo.webp',
                'created_at'          => date('Y-m-d H:i:s'),
            ],
        ];
        $db->table('mst_ormas')->insertBatch($ormasData);

        // 4. Seed mst_parpol
        $db->table('mst_parpol')->truncate();
        $parpolData = [
            [
                'id'          => $uuidGen(),
                'nama_parpol' => 'Partai Kebangkitan Bangsa (PKB)',
                'lambang'     => 'pkb_logo.webp',
                'alamat'      => 'Jl. Dr. Sutomo No. 5, Sinjai',
                'telepon'     => '0482-31122',
                'ketua'       => 'H. Andi Haris, S.E.',
                'created_at'  => date('Y-m-d H:i:s'),
            ],
            [
                'id'          => $uuidGen(),
                'nama_parpol' => 'Partai Gerakan Indonesia Raya (Gerindra)',
                'lambang'     => 'gerindra_logo.webp',
                'alamat'      => 'Jl. Jend. Sudirman No. 8, Sinjai',
                'telepon'     => '0482-32244',
                'ketua'       => 'Andi Muhammad Yusuf, M.Si.',
                'created_at'  => date('Y-m-d H:i:s'),
            ],
            [
                'id'          => $uuidGen(),
                'nama_parpol' => 'Partai Demokrasi Indonesia Perjuangan (PDIP)',
                'lambang'     => 'pdip_logo.webp',
                'alamat'      => 'Jl. Bhayangkara No. 15, Sinjai',
                'telepon'     => '0482-33355',
                'ketua'       => 'Hj. Kartini, S.Sos.',
                'created_at'  => date('Y-m-d H:i:s'),
            ],
        ];
        $db->table('mst_parpol')->insertBatch($parpolData);

        // 5. Seed trn_kegiatan_bidang (Data Kinerja awal)
        $db->table('trn_kegiatan_bidang')->truncate();
        $kegiatanData = [
            [
                'id'                 => $uuidGen(),
                'bidang_id'          => $bidangIds['POLDAGRI_ORMAS'],
                'nama_kegiatan'      => 'Pembinaan Administrasi Organisasi Kemasyarakatan Daerah',
                'target_fisik'       => 100.0,
                'realisasi_fisik'    => 100.0,
                'target_keuangan'    => 25000000.0,
                'realisasi_keuangan' => 25000000.0,
                'bulan_spj'          => '2026-05',
                'kendala'            => null,
                'created_at'         => date('Y-m-d H:i:s'),
            ],
            [
                'id'                 => $uuidGen(),
                'bidang_id'          => $bidangIds['POLDAGRI_ORMAS'],
                'nama_kegiatan'      => 'Sosialisasi Pendidikan Politik Bagi Pemilih Pemula',
                'target_fisik'       => 100.0,
                'realisasi_fisik'    => 80.0, // Di bawah target!
                'target_keuangan'    => 15000000.0,
                'realisasi_keuangan' => 12000000.0, // Di bawah target!
                'bulan_spj'          => '2026-05',
                'kendala'            => 'Alokasi waktu pelaksanaan terpaksa mundur dari jadwal awal karena bentrok dengan jadwal ujian sekolah di target lokasi sosialisasi.',
                'created_at'         => date('Y-m-d H:i:s'),
            ],
            [
                'id'                 => $uuidGen(),
                'bidang_id'          => $bidangIds['IDWASBANG'],
                'nama_kegiatan'      => 'Pendidikan Wawasan Kebangsaan Bagi Siswa SMA/SMK',
                'target_fisik'       => 100.0,
                'realisasi_fisik'    => 100.0,
                'target_keuangan'    => 30000000.0,
                'realisasi_keuangan' => 30000000.0,
                'bulan_spj'          => '2026-05',
                'kendala'            => null,
                'created_at'         => date('Y-m-d H:i:s'),
            ],
            [
                'id'                 => $uuidGen(),
                'bidang_id'          => $bidangIds['EKOSOSBUD'],
                'nama_kegiatan'      => 'Monitoring Potensi Konflik Kerukunan Antar Umat Beragama',
                'target_fisik'       => 100.0,
                'realisasi_fisik'    => 95.0, // Di bawah target!
                'target_keuangan'    => 20000000.0,
                'realisasi_keuangan' => 18500000.0, // Di bawah target!
                'bulan_spj'          => '2026-05',
                'kendala'            => 'Kendala cuaca buruk dan curah hujan tinggi menyebabkan beberapa kunjungan ke desa terpencil ditunda ke bulan berikutnya.',
                'created_at'         => date('Y-m-d H:i:s'),
            ],
        ];
        $db->table('trn_kegiatan_bidang')->insertBatch($kegiatanData);

        // 6. Seed trn_pendaftaran (Public Tracking Data)
        $db->table('trn_pendaftaran')->truncate();
        $pendaftaranData = [
            [
                'id'                  => 'p1d00001-beef-4a4a-98d0-fca32b8879f6',
                'ormas_id'            => 'o1d00001-beef-4a4a-98d0-fca32b8879f6',
                'nomor_registrasi'    => 'REG-2026-001',
                'progress_percentage' => 100,
                'status_verifikasi'   => 'Approved',
                'created_at'          => date('Y-m-d H:i:s'),
            ],
            [
                'id'                  => 'p1d00002-beef-4a4a-98d0-fca32b8879f6',
                'ormas_id'            => 'o1d00002-beef-4a4a-98d0-fca32b8879f6',
                'nomor_registrasi'    => 'REG-2026-002',
                'progress_percentage' => 45,
                'status_verifikasi'   => 'Pending',
                'created_at'          => date('Y-m-d H:i:s'),
            ],
        ];
        $db->table('trn_pendaftaran')->insertBatch($pendaftaranData);
    }
}
