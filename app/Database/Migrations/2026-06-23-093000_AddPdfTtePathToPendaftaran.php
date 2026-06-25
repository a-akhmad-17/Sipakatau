<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class AddPdfTtePathToPendaftaran extends Migration
{
    public function up()
    {
        $fields = [
            'pdf_tte_path' => [
                'type'       => 'VARCHAR',
                'constraint' => 255,
                'null'       => true,
                'after'      => 'alasan_ditolak'
            ]
        ];
        $this->forge->addColumn('trn_pendaftaran', $fields);
    }

    public function down()
    {
        $this->forge->dropColumn('trn_pendaftaran', 'pdf_tte_path');
    }
}
