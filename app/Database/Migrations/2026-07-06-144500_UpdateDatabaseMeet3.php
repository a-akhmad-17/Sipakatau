<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class UpdateDatabaseMeet3 extends Migration
{
    public function up()
    {
        $db = \Config\Database::connect();

        // 1. Modifikasi ENUM role pada tabel sys_users (mengubah pptk menjadi kabid)
        // Kita ubah role pada akun yang ada dari 'pptk' menjadi 'kabid' dulu agar tidak gagal saat ALTER
        $db->query("UPDATE sys_users SET role = 'kabid' WHERE role = 'pptk'");
        $db->query("ALTER TABLE sys_users MODIFY COLUMN role ENUM('admin', 'kaban', 'kabid', 'ormas', 'user') DEFAULT 'user'");

        // 2. Tambah kolom phone di sys_users
        $this->forge->addColumn('sys_users', [
            'phone' => [
                'type'       => 'VARCHAR',
                'constraint' => 20,
                'null'       => true,
                'after'      => 'email'
            ]
        ]);

        // 3. Tambah tipe_ormas dan file_skt di trn_pendaftaran
        $this->forge->addColumn('trn_pendaftaran', [
            'tipe_ormas' => [
                'type'       => 'ENUM',
                'constraint' => ['Nasional', 'Lokal'],
                'default'    => 'Lokal',
                'after'      => 'ormas_id'
            ],
            'file_skt' => [
                'type'       => 'VARCHAR',
                'constraint' => 255,
                'null'       => true,
                'after'      => 'pdf_tte_path'
            ]
        ]);

        // 4. Tambah has_kursi, periode_dewan, level_dewan di mst_parpol
        $this->forge->addColumn('mst_parpol', [
            'has_kursi' => [
                'type'       => 'TINYINT',
                'constraint' => 1,
                'default'    => 0,
                'after'      => 'ketua'
            ],
            'periode_dewan' => [
                'type'       => 'VARCHAR',
                'constraint' => 50,
                'null'       => true,
                'after'      => 'has_kursi'
            ],
            'level_dewan' => [
                'type'       => 'VARCHAR',
                'constraint' => 50,
                'null'       => true,
                'after'      => 'periode_dewan'
            ]
        ]);

        // 5. Tambah lokasi_kegiatan, is_fasilitas_pemerintah, detail_fasilitas di trn_rekomendasi
        $this->forge->addColumn('trn_rekomendasi', [
            'lokasi_kegiatan' => [
                'type' => 'TEXT',
                'null' => true,
                'after' => 'deskripsi'
            ],
            'is_fasilitas_pemerintah' => [
                'type'       => 'TINYINT',
                'constraint' => 1,
                'default'    => 0,
                'after'      => 'lokasi_kegiatan'
            ],
            'detail_fasilitas' => [
                'type' => 'TEXT',
                'null' => true,
                'after' => 'is_fasilitas_pemerintah'
            ]
        ]);

        // 6. Buat Tabel Baru mst_ormas_pengurus
        $this->forge->addField([
            'id' => [
                'type'       => 'VARCHAR',
                'constraint' => 36,
            ],
            'ormas_id' => [
                'type'       => 'VARCHAR',
                'constraint' => 36,
            ],
            'nama' => [
                'type'       => 'VARCHAR',
                'constraint' => 100,
            ],
            'jabatan' => [
                'type'       => 'VARCHAR',
                'constraint' => 50,
            ],
            'no_hp' => [
                'type'       => 'VARCHAR',
                'constraint' => 20,
                'null'       => true,
            ],
            'created_at' => [
                'type' => 'DATETIME',
                'null' => true,
            ],
            'updated_at' => [
                'type' => 'DATETIME',
                'null' => true,
            ],
        ]);
        $this->forge->addKey('id', true);
        $this->forge->addKey('ormas_id');
        $this->forge->createTable('mst_ormas_pengurus');
    }

    public function down()
    {
        $db = \Config\Database::connect();

        // 1. Drop tabel mst_ormas_pengurus
        $this->forge->dropTable('mst_ormas_pengurus', true);

        // 2. Drop kolom di trn_rekomendasi
        $this->forge->dropColumn('trn_rekomendasi', ['lokasi_kegiatan', 'is_fasilitas_pemerintah', 'detail_fasilitas']);

        // 3. Drop kolom di mst_parpol
        $this->forge->dropColumn('mst_parpol', ['has_kursi', 'periode_dewan', 'level_dewan']);

        // 4. Drop kolom di trn_pendaftaran
        $this->forge->dropColumn('trn_pendaftaran', ['tipe_ormas', 'file_skt']);

        // 5. Drop kolom phone di sys_users
        $this->forge->dropColumn('sys_users', 'phone');

        // 6. Kembalikan ENUM role di sys_users
        $db->query("UPDATE sys_users SET role = 'pptk' WHERE role = 'kabid'");
        $db->query("ALTER TABLE sys_users MODIFY COLUMN role ENUM('admin', 'kaban', 'pptk', 'ormas', 'user') DEFAULT 'user'");
    }
}
