<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class AddLocationToRekomendasiAndPengaduan extends Migration
{
    public function up()
    {
        // 1. Add latitude and longitude to trn_rekomendasi
        $this->forge->addColumn('trn_rekomendasi', [
            'latitude' => [
                'type'       => 'VARCHAR',
                'constraint' => 50,
                'null'       => true,
                'after'      => 'detail_fasilitas'
            ],
            'longitude' => [
                'type'       => 'VARCHAR',
                'constraint' => 50,
                'null'       => true,
                'after'      => 'latitude'
            ]
        ]);

        // 2. Add latitude and longitude to trn_pengaduan
        $this->forge->addColumn('trn_pengaduan', [
            'latitude' => [
                'type'       => 'VARCHAR',
                'constraint' => 50,
                'null'       => true,
                'after'      => 'berkas'
            ],
            'longitude' => [
                'type'       => 'VARCHAR',
                'constraint' => 50,
                'null'       => true,
                'after'      => 'latitude'
            ]
        ]);
    }

    public function down()
    {
        $this->forge->dropColumn('trn_rekomendasi', ['latitude', 'longitude']);
        $this->forge->dropColumn('trn_pengaduan', ['latitude', 'longitude']);
    }
}
