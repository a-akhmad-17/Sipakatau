<?php

namespace App\Database\Seeds;

use CodeIgniter\Database\Seeder;

class StrukturSeeder extends Seeder
{
    public function run()
    {
        $jsonPath = ROOTPATH . 'get_jabatan.json';
        if (!file_exists($jsonPath)) {
            die("File get_jabatan.json tidak ditemukan!");
        }

        $jsonData = json_decode(file_get_contents($jsonPath), true);
        if (!$jsonData) {
            die("Gagal membaca atau decode JSON!");
        }

        $pimpinan = [];
        $sekretariat = [];
        $ideologi = [];
        $poldagri = [];
        $ekososbud = [];

        foreach ($jsonData as $emp) {
            $nip = $emp['nip'] ?? $emp['jabatan_nip'] ?? '-';
            $nama = $emp['nama'] ?? '-';
            $jabatanNama = $emp['jabatan_nama'] ?? '';
            $jabatanGrup = $emp['jabatan_grup'] ?? '';
            $peranKhusus = $emp['peran_khusus'] ?? '';

            // Format NIP
            $formattedNip = ($nip !== '-' && !empty($nip)) ? 'NIP. ' . $nip : '-';

            // Default values
            $id = '';
            $category = '';
            $role = '';
            $photo = '';

            // 1. Pimpinan (Kaban & Sekretaris)
            if ($peranKhusus === 'KEPALA' || stripos($jabatanNama, 'Kepala Badan') !== false) {
                $id = 'kaban';
                $role = 'Kepala Badan';
                $category = 'pimpinan';
                $photo = 'default_kaban.webp';
                $pimpinan['kaban'] = [
                    'id'       => $id,
                    'role'     => $role,
                    'name'     => $nama,
                    'nip'      => $formattedNip,
                    'photo'    => $photo,
                    'category' => $category
                ];
            } elseif (stripos($jabatanNama, 'Sekretaris') !== false) {
                $id = 'sekretaris';
                $role = 'Sekretaris';
                $category = 'pimpinan';
                $photo = 'default_sekretaris.webp';
                $pimpinan['sekretaris'] = [
                    'id'       => $id,
                    'role'     => $role,
                    'name'     => $nama,
                    'nip'      => $formattedNip,
                    'photo'    => $photo,
                    'category' => $category
                ];
            } 
            // 2. Kasubbag / Kepala Sub Bagian (Sekretariat)
            elseif (stripos($jabatanNama, 'Sub Bagian Umum') !== false || stripos($jabatanNama, 'Kepegawaian') !== false) {
                $id = 'kasubbag_umum';
                $role = 'Kasubbag Kepegawaian & Umum';
                $category = 'sekretariat';
                $photo = 'default_kasubbag_umum.webp';
                $sekretariat['kasubbag_umum'] = [
                    'id'       => $id,
                    'role'     => $role,
                    'name'     => $nama,
                    'nip'      => $formattedNip,
                    'photo'    => $photo,
                    'category' => $category
                ];
            } elseif (stripos($jabatanNama, 'Sub Bidang Program') !== false || stripos($jabatanNama, 'Program, Anggaran') !== false) {
                $id = 'kasubbag_keuangan';
                $role = 'Kasubbag Keuangan & Program';
                $category = 'sekretariat';
                $photo = 'default_kasubbag_keuangan.webp';
                $sekretariat['kasubbag_keuangan'] = [
                    'id'       => $id,
                    'role'     => $role,
                    'name'     => $nama,
                    'nip'      => $formattedNip,
                    'photo'    => $photo,
                    'category' => $category
                ];
            } 
            // 3. Kabid (Ideologi, Poldagri, Ekososbud)
            elseif (stripos($jabatanNama, 'Ideologi') !== false || stripos($jabatanNama, 'Wasbang') !== false) {
                $id = 'kabid_ideologi';
                $role = 'Kabid Ideologi & Wasbang';
                $category = 'ideologi';
                $photo = 'default_kabid_ideologi.webp';
                $ideologi['kabid_ideologi'] = [
                    'id'       => $id,
                    'role'     => $role,
                    'name'     => $nama,
                    'nip'      => $formattedNip,
                    'photo'    => $photo,
                    'category' => $category
                ];
            } elseif (stripos($jabatanNama, 'Politik Dalam Negeri') !== false || stripos($jabatanNama, 'Ormas') !== false) {
                $id = 'kabid_poldagri';
                $role = 'Kabid Poldagri & Ormas';
                $category = 'poldagri';
                $photo = 'default_kabid_poldagri.webp';
                $poldagri['kabid_poldagri'] = [
                    'id'       => $id,
                    'role'     => $role,
                    'name'     => $nama,
                    'nip'      => $formattedNip,
                    'photo'    => $photo,
                    'category' => $category
                ];
            } elseif (stripos($jabatanNama, 'Kewaspadaan Nasional') !== false) {
                $id = 'kabid_ekososbud';
                $role = 'Kabid Ekososbud & Agama';
                $category = 'ekososbud';
                $photo = 'default_kabid_ekososbud.webp';
                $ekososbud['kabid_ekososbud'] = [
                    'id'       => $id,
                    'role'     => $role,
                    'name'     => $nama,
                    'nip'      => $formattedNip,
                    'photo'    => $photo,
                    'category' => $category
                ];
            } 
            // 4. Staf / Pelaksana / Fungsional
            else {
                // Group categorisation
                if (stripos($jabatanGrup, 'Ideologi') !== false || stripos($jabatanGrup, 'Wasbang') !== false) {
                    $category = 'ideologi';
                    $role = $jabatanNama;
                    $id = 'staf_ideologi_' . strtolower(str_replace([' ', '.'], ['_', ''], $nama)) . '_' . mt_rand(10, 99);
                    $photo = 'default_staff_ideologi_1.webp';
                    $ideologi[] = [
                        'id'       => $id,
                        'role'     => $role,
                        'name'     => $nama,
                        'nip'      => $formattedNip,
                        'photo'    => $photo,
                        'category' => $category
                    ];
                } elseif (stripos($jabatanGrup, 'Politik') !== false || stripos($jabatanGrup, 'Ormas') !== false) {
                    $category = 'poldagri';
                    $role = $jabatanNama;
                    $id = 'staf_poldagri_' . strtolower(str_replace([' ', '.'], ['_', ''], $nama)) . '_' . mt_rand(10, 99);
                    $photo = 'default_staff_poldagri_1.webp';
                    $poldagri[] = [
                        'id'       => $id,
                        'role'     => $role,
                        'name'     => $nama,
                        'nip'      => $formattedNip,
                        'photo'    => $photo,
                        'category' => $category
                    ];
                } elseif (stripos($jabatanGrup, 'Kewaspadaan') !== false || stripos($jabatanGrup, 'Penanganan Publik') !== false || stripos($emp['jabatan_nama_atasan'] ?? '', 'Kewaspadaan') !== false) {
                    $category = 'ekososbud';
                    $role = $jabatanNama;
                    $id = 'staf_ekososbud_' . strtolower(str_replace([' ', '.'], ['_', ''], $nama)) . '_' . mt_rand(10, 99);
                    $photo = 'default_staff_ekososbud_1.webp';
                    $ekososbud[] = [
                        'id'       => $id,
                        'role'     => $role,
                        'name'     => $nama,
                        'nip'      => $formattedNip,
                        'photo'    => $photo,
                        'category' => $category
                    ];
                } else {
                    $category = 'sekretariat';
                    $role = $jabatanNama;
                    if ($peranKhusus === 'BENDAHARA') {
                        $role = 'Bendahara / ' . $role;
                    }
                    $id = 'staf_sekretariat_' . strtolower(str_replace([' ', '.'], ['_', ''], $nama)) . '_' . mt_rand(10, 99);
                    $photo = 'default_staff_sekretariat_' . mt_rand(1, 2) . '.webp';
                    $sekretariat[] = [
                        'id'       => $id,
                        'role'     => $role,
                        'name'     => $nama,
                        'nip'      => $formattedNip,
                        'photo'    => $photo,
                        'category' => $category
                    ];
                }
            }
        }

        // Combine in ordered structure
        $finalStruktur = [];

        // 1. Pimpinan
        if (isset($pimpinan['kaban'])) $finalStruktur[] = $pimpinan['kaban'];
        if (isset($pimpinan['sekretaris'])) $finalStruktur[] = $pimpinan['sekretaris'];

        // 2. Sekretariat (Kasubbag first, then other staff)
        if (isset($sekretariat['kasubbag_umum'])) $finalStruktur[] = $sekretariat['kasubbag_umum'];
        if (isset($sekretariat['kasubbag_keuangan'])) $finalStruktur[] = $sekretariat['kasubbag_keuangan'];
        foreach ($sekretariat as $key => $node) {
            if ($key !== 'kasubbag_umum' && $key !== 'kasubbag_keuangan') {
                $finalStruktur[] = $node;
            }
        }

        // 3. Ideologi (Kabid first, then other staff)
        if (isset($ideologi['kabid_ideologi'])) $finalStruktur[] = $ideologi['kabid_ideologi'];
        foreach ($ideologi as $key => $node) {
            if ($key !== 'kabid_ideologi') {
                $finalStruktur[] = $node;
            }
        }

        // 4. Poldagri (Kabid first, then other staff)
        if (isset($poldagri['kabid_poldagri'])) $finalStruktur[] = $poldagri['kabid_poldagri'];
        foreach ($poldagri as $key => $node) {
            if ($key !== 'kabid_poldagri') {
                $finalStruktur[] = $node;
            }
        }

        // 5. Ekososbud (Kabid first, then other staff)
        if (isset($ekososbud['kabid_ekososbud'])) $finalStruktur[] = $ekososbud['kabid_ekososbud'];
        foreach ($ekososbud as $key => $node) {
            if ($key !== 'kabid_ekososbud') {
                $finalStruktur[] = $node;
            }
        }

        // Save to sys_settings
        $db = \Config\Database::connect();
        
        // Retrieve existing settings if any, to preserve photos
        $existingSetting = $db->table('sys_settings')->where('key', 'struktur_organisasi')->get()->getRowArray();
        if ($existingSetting) {
            $existingStruktur = json_decode($existingSetting['value'], true) ?: [];
            $photoMap = [];
            foreach ($existingStruktur as $item) {
                if (!empty($item['nip']) && $item['nip'] !== '-') {
                    $photoMap[$item['nip']] = $item['photo'];
                }
            }
            // Map back existing photos if NIP matches
            foreach ($finalStruktur as &$node) {
                if (isset($photoMap[$node['nip']]) && !empty($photoMap[$node['nip']])) {
                    $node['photo'] = $photoMap[$node['nip']];
                }
            }
        }

        $db->table('sys_settings')->replace([
            'key'        => 'struktur_organisasi',
            'value'      => json_encode($finalStruktur),
            'group'      => 'struktur',
            'updated_at' => date('Y-m-d H:i:s')
        ]);

        echo "StrukturSeeder: Berhasil mengimpor " . count($finalStruktur) . " data pegawai dari get_jabatan.json.\n";
    }
}
