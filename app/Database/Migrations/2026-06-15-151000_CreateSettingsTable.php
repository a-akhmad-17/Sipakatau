<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class CreateSettingsTable extends Migration
{
    public function up()
    {
        // 1. Create sys_settings table
        $this->forge->addField([
            'key' => [
                'type'       => 'VARCHAR',
                'constraint' => 50,
            ],
            'value' => [
                'type' => 'TEXT',
                'null' => true,
            ],
            'group' => [
                'type'       => 'VARCHAR',
                'constraint' => 50,
            ],
            'created_at' => ['type' => 'DATETIME', 'null' => true],
            'updated_at' => ['type' => 'DATETIME', 'null' => true],
        ]);
        $this->forge->addKey('key', true);
        $this->forge->createTable('sys_settings');

        // 2. Seeding default settings data
        $db = \Config\Database::connect();
        
        $defaultVisi = "Terwujudnya Masyarakat Kabupaten Sinjai yang Damai, Demokratis, Berkarakter Bangsa dan Harmonis Berlandaskan Nilai Keagamaan dan Budaya Lokal.";

        $defaultMisi = [
            "Meningkatkan pengamalan nilai-nilai Pancasila dan Wawasan Kebangsaan guna memperkokoh jati diri bangsa.",
            "Mewujudkan iklim politik dalam negeri yang demokratis, kondusif, aman, dan tertib.",
            "Meningkatkan kerukunan hidup antarumat beragama dan ketahanan sosial kemasyarakatan dari potensi konflik.",
            "Meningkatkan sinergitas pengawasan dan kewaspadaan dini daerah terhadap ancaman, tantangan, hambatan, dan gangguan."
        ];

        $defaultBidang = [
            [
                "id" => "sekretariat",
                "title" => "Sekretariat",
                "subtitle" => "Bagian Umum",
                "icon" => "fa-folder-open",
                "badge" => "Bagian Umum",
                "color" => "#71717a",
                "description" => "Sekretariat mempunyai tugas memberikan pelayanan administratif dan koordinasi pelaksanaan tugas sub bagian di lingkungan Badan Kesbangpol Kabupaten Sinjai.",
                "sub_units" => [
                    "Sub Bagian Kepegawaian & Umum",
                    "Sub Bagian Keuangan & Program"
                ]
            ],
            [
                "id" => "ideologi",
                "title" => "Ideologi & Wasbang",
                "subtitle" => "Fokus Kebangsaan",
                "icon" => "fa-brain",
                "badge" => "Fokus Kebangsaan",
                "color" => "#e11d48",
                "description" => "Bidang Ideologi, Wawasan Kebangsaan dan Karakter Bangsa melaksanakan perumusan kebijakan teknis, pembinaan, koordinasi, dan fasilitasi pembumian ideologi Pancasila serta wawasan kebangsaan bela negara.",
                "sub_units" => [
                    "Pendidikan Bela Negara",
                    "Nilai Pancasila & Karakter Bangsa"
                ]
            ],
            [
                "id" => "poldagri",
                "title" => "Poldagri & Ormas",
                "subtitle" => "Fokus Kemasyarakatan",
                "icon" => "fa-users-rectangle",
                "badge" => "Fokus Kemasyarakatan",
                "color" => "#be123c",
                "description" => "Bidang Politik Dalam Negeri dan Organisasi Kemasyarakatan mempunyai tugas merumuskan dan melaksanakan kebijakan teknis di bidang budaya demokrasi, pendidikan politik, pendaftaran lembaga, pembinaan dan pengawasan ormas.",
                "sub_units" => [
                    "Pendaftaran Ormas & LSM",
                    "Sosialisasi Pemilu & Politik Daerah"
                ]
            ],
            [
                "id" => "ekososbud",
                "title" => "Ekososbud & Agama",
                "subtitle" => "Fokus Ketahanan Sosial",
                "icon" => "fa-shield-halved",
                "badge" => "Fokus Ketahanan Sosial",
                "color" => "#f59e0b",
                "description" => "Bidang Ketahanan Ekonomi, Sosial, Budaya dan Agama melaksanakan fasilitasi kerukunan umat beragama (FKUB), pemantauan kerawanan sosial ekonomi, pencegahan konflik SARA, aliran sesat, serta kewaspadaan dini daerah.",
                "sub_units" => [
                    "Kerukunan Antar Umat Beragama",
                    "Pengawasan Aliran Kepercayaan Daerah"
                ]
            ]
        ];

        $defaultStruktur = [
            [
                "id" => "kaban",
                "role" => "Kepala Badan",
                "name" => "Muhammad Rusyaid, S.Kom., M.Si.",
                "nip" => "NIP. 19821210 200501 1 003",
                "photo" => "default_kaban.webp",
                "category" => "pimpinan"
            ],
            [
                "id" => "sekretaris",
                "role" => "Sekretaris",
                "name" => "Andi Rahmawati, S.Sos.",
                "nip" => "NIP. 19800412 200801 2 004",
                "photo" => "default_sekretaris.webp",
                "category" => "pimpinan"
            ],
            [
                "id" => "kasubbag_umum",
                "role" => "Kasubbag Kepegawaian & Umum",
                "name" => "Murdiana, S.E.",
                "nip" => "NIP. 19850514 200903 2 005",
                "photo" => "default_kasubbag_umum.webp",
                "category" => "sekretariat"
            ],
            [
                "id" => "kasubbag_keuangan",
                "role" => "Kasubbag Keuangan & Program",
                "name" => "Sitti Asni, S.Sos.",
                "nip" => "NIP. 19830218 201001 2 006",
                "photo" => "default_kasubbag_keuangan.webp",
                "category" => "sekretariat"
            ],
            [
                "id" => "kabid_ideologi",
                "role" => "Kabid Ideologi & Wasbang",
                "name" => "Andi Asrul, S.IP.",
                "nip" => "NIP. 19780825 200312 1 002",
                "photo" => "default_kabid_ideologi.webp",
                "category" => "ideologi"
            ],
            [
                "id" => "staff_ideologi_1",
                "role" => "Staf Ideologi",
                "name" => "Herman, S.Sos.",
                "nip" => "-",
                "photo" => "default_staff_ideologi_1.webp",
                "category" => "ideologi"
            ],
            [
                "id" => "staff_ideologi_2",
                "role" => "Staf Wasbang",
                "name" => "Rina Lestari, A.Md.",
                "nip" => "-",
                "photo" => "default_staff_ideologi_2.webp",
                "category" => "ideologi"
            ],
            [
                "id" => "kabid_poldagri",
                "role" => "Kabid Poldagri & Ormas",
                "name" => "H. Andi Baso, S.E.",
                "nip" => "NIP. 19750915 200003 1 004",
                "photo" => "default_kabid_poldagri.webp",
                "category" => "poldagri"
            ],
            [
                "id" => "staff_poldagri_1",
                "role" => "Staf Poldagri",
                "name" => "Andi Tenri, S.STP.",
                "nip" => "-",
                "photo" => "default_staff_poldagri_1.webp",
                "category" => "poldagri"
            ],
            [
                "id" => "staff_poldagri_2",
                "role" => "Staf Ormas",
                "name" => "Faisal, S.H.",
                "nip" => "-",
                "photo" => "default_staff_poldagri_2.webp",
                "category" => "poldagri"
            ],
            [
                "id" => "kabid_ekososbud",
                "role" => "Kabid Ekososbud & Agama",
                "name" => "Dra. Hj. Fitriani",
                "nip" => "NIP. 19721105 199803 2 001",
                "photo" => "default_kabid_ekososbud.webp",
                "category" => "ekososbud"
            ],
            [
                "id" => "staff_ekososbud_1",
                "role" => "Staf Ekososbud",
                "name" => "Bambang, S.E.",
                "nip" => "-",
                "photo" => "default_staff_ekososbud_1.webp",
                "category" => "ekososbud"
            ],
            [
                "id" => "staff_ekososbud_2",
                "role" => "Staf Keagamaan",
                "name" => "Nurfadillah, S.Hum.",
                "nip" => "-",
                "photo" => "default_staff_ekososbud_2.webp",
                "category" => "ekososbud"
            ]
        ];

        $insertData = [
            [
                'key'        => 'profil_visi',
                'value'      => $defaultVisi,
                'group'      => 'profil',
                'created_at' => date('Y-m-d H:i:s'),
                'updated_at' => date('Y-m-d H:i:s'),
            ],
            [
                'key'        => 'profil_misi',
                'value'      => json_encode($defaultMisi),
                'group'      => 'profil',
                'created_at' => date('Y-m-d H:i:s'),
                'updated_at' => date('Y-m-d H:i:s'),
            ],
            [
                'key'        => 'profil_bidang',
                'value'      => json_encode($defaultBidang),
                'group'      => 'profil',
                'created_at' => date('Y-m-d H:i:s'),
                'updated_at' => date('Y-m-d H:i:s'),
            ],
            [
                'key'        => 'struktur_organisasi',
                'value'      => json_encode($defaultStruktur),
                'group'      => 'struktur',
                'created_at' => date('Y-m-d H:i:s'),
                'updated_at' => date('Y-m-d H:i:s'),
            ],
        ];

        $db->table('sys_settings')->insertBatch($insertData);
    }

    public function down()
    {
        $this->forge->dropTable('sys_settings');
    }
}
