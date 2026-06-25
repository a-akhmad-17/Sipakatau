<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class CreateAntreanTable extends Migration
{
    public function up()
    {
        $this->forge->addField([
            'id' => [
                'type'       => 'VARCHAR',
                'constraint' => 36,
            ],
            'nomor_antrean' => [
                'type'       => 'VARCHAR',
                'constraint' => 20,
            ],
            'nama_pengambil' => [
                'type'       => 'VARCHAR',
                'constraint' => 100,
            ],
            'nik' => [
                'type'       => 'VARCHAR',
                'constraint' => 16,
            ],
            'layanan' => [
                'type'       => 'ENUM',
                'constraint' => ['ormas', 'rekomendasi', 'konsultasi'],
            ],
            'tanggal' => [
                'type' => 'DATE',
            ],
            'status' => [
                'type'       => 'ENUM',
                'constraint' => ['Menunggu', 'Dilayani', 'Selesai', 'Lewat'],
                'default'    => 'Menunggu',
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
        $this->forge->addKey('tanggal');
        $this->forge->addKey('status');
        $this->forge->createTable('trn_antrean');
    }

    public function down()
    {
        $this->forge->dropTable('trn_antrean', true);
    }
}
