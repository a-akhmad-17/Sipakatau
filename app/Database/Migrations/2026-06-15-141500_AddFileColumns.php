<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class AddFileColumns extends Migration
{
    public function up()
    {
        // Add file_berkas to mst_ormas
        $this->forge->addColumn('mst_ormas', [
            'file_berkas' => [
                'type'       => 'VARCHAR',
                'constraint' => 255,
                'null'       => true,
                'after'      => 'file_logo'
            ]
        ]);

        // Add file_proposal to trn_rekomendasi
        $this->forge->addColumn('trn_rekomendasi', [
            'file_proposal' => [
                'type'       => 'VARCHAR',
                'constraint' => 255,
                'null'       => true,
                'after'      => 'deskripsi'
            ]
        ]);
    }

    public function down()
    {
        $this->forge->dropColumn('mst_ormas', 'file_berkas');
        $this->forge->dropColumn('trn_rekomendasi', 'file_proposal');
    }
}
