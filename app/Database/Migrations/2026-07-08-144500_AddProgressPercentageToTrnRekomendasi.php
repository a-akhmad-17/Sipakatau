<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class AddProgressPercentageToTrnRekomendasi extends Migration
{
    public function up()
    {
        $this->forge->addColumn('trn_rekomendasi', [
            'progress_percentage' => [
                'type'       => 'INT',
                'constraint' => 5,
                'default'    => 0,
                'after'      => 'status_rekomendasi'
            ]
        ]);
    }

    public function down()
    {
        $this->forge->dropColumn('trn_rekomendasi', 'progress_percentage');
    }
}
