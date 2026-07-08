<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class AddLokasiInputToPengaduan extends Migration
{
    public function up()
    {
        // Tambah kolom lokasi_pengaduan (text input: link maps / nama jalan / koordinat) di trn_pengaduan
        $this->forge->addColumn('trn_pengaduan', [
            'lokasi_pengaduan' => [
                'type' => 'TEXT',
                'null' => true,
                'after' => 'longitude'
            ]
        ]);
    }

    public function down()
    {
        $this->forge->dropColumn('trn_pengaduan', 'lokasi_pengaduan');
    }
}
