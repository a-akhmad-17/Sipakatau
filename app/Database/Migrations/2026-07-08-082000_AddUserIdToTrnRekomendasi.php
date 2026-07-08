<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class AddUserIdToTrnRekomendasi extends Migration
{
    public function up()
    {
        // Tambah kolom user_id di trn_rekomendasi agar bisa dilacak per user
        $this->forge->addColumn('trn_rekomendasi', [
            'user_id' => [
                'type'       => 'VARCHAR',
                'constraint' => 36,
                'null'       => true,
                'after'      => 'id',
            ]
        ]);
    }

    public function down()
    {
        $this->forge->dropColumn('trn_rekomendasi', 'user_id');
    }
}
