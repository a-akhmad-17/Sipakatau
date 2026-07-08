<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class DropLatLngFromRekomendasiAndPengaduan extends Migration
{
    public function up()
    {
        // Hapus latitude & longitude dari trn_rekomendasi
        $this->forge->dropColumn('trn_rekomendasi', ['latitude', 'longitude']);

        // Hapus latitude & longitude dari trn_pengaduan
        $this->forge->dropColumn('trn_pengaduan', ['latitude', 'longitude']);
    }

    public function down()
    {
        $this->forge->addColumn('trn_rekomendasi', [
            'latitude'  => ['type' => 'VARCHAR', 'constraint' => 50, 'null' => true],
            'longitude' => ['type' => 'VARCHAR', 'constraint' => 50, 'null' => true],
        ]);
        $this->forge->addColumn('trn_pengaduan', [
            'latitude'  => ['type' => 'VARCHAR', 'constraint' => 50, 'null' => true],
            'longitude' => ['type' => 'VARCHAR', 'constraint' => 50, 'null' => true],
        ]);
    }
}
