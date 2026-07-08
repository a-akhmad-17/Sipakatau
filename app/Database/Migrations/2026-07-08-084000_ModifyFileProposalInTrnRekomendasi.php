<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class ModifyFileProposalInTrnRekomendasi extends Migration
{
    public function up()
    {
        // Ubah tipe kolom file_proposal dari VARCHAR(255) menjadi TEXT agar bisa menampung JSON multipart dokumen
        $this->forge->modifyColumn('trn_rekomendasi', [
            'file_proposal' => [
                'type' => 'TEXT',
                'null' => true
            ]
        ]);
    }

    public function down()
    {
        $this->forge->modifyColumn('trn_rekomendasi', [
            'file_proposal' => [
                'type'       => 'VARCHAR',
                'constraint' => 255,
                'null'       => true
            ]
        ]);
    }
}
