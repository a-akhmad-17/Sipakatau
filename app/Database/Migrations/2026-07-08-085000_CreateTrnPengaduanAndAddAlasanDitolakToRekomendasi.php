<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class CreateTrnPengaduanAndAddAlasanDitolakToRekomendasi extends Migration
{
    public function up()
    {
        // 1. Tambah kolom alasan_ditolak di trn_rekomendasi
        $this->forge->addColumn('trn_rekomendasi', [
            'alasan_ditolak' => [
                'type' => 'TEXT',
                'null' => true,
                'after' => 'status_rekomendasi'
            ]
        ]);

        // 2. Buat tabel trn_pengaduan
        $this->forge->addField([
            'id' => [
                'type'       => 'VARCHAR',
                'constraint' => 36,
            ],
            'user_id' => [
                'type'       => 'VARCHAR',
                'constraint' => 36,
                'null'       => true,
            ],
            'judul' => [
                'type'       => 'VARCHAR',
                'constraint' => 255,
            ],
            'kategori' => [
                'type'       => 'VARCHAR',
                'constraint' => 100,
            ],
            'bidang_id' => [
                'type'       => 'VARCHAR',
                'constraint' => 36,
                'null'       => true,
            ],
            'deskripsi' => [
                'type' => 'TEXT',
            ],
            'berkas' => [
                'type'       => 'VARCHAR',
                'constraint' => 255,
                'null'       => true,
            ],
            'status' => [
                'type'       => 'ENUM',
                'constraint' => ['Pending', 'Processed', 'Rejected'],
                'default'    => 'Pending',
            ],
            'alasan_ditolak' => [
                'type' => 'TEXT',
                'null' => true,
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
        $this->forge->addKey('user_id');
        $this->forge->createTable('trn_pengaduan');
    }

    public function down()
    {
        // Drop tabel trn_pengaduan
        $this->forge->dropTable('trn_pengaduan', true);

        // Drop kolom alasan_ditolak dari trn_rekomendasi
        $this->forge->dropColumn('trn_rekomendasi', 'alasan_ditolak');
    }
}
