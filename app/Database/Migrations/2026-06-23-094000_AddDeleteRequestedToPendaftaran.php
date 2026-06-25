<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class AddDeleteRequestedToPendaftaran extends Migration
{
    public function up()
    {
        $fields = [
            'delete_requested' => [
                'type'       => 'TINYINT',
                'constraint' => 1,
                'default'    => 0,
                'after'      => 'pdf_tte_path'
            ]
        ];
        
        $this->forge->addColumn('trn_pendaftaran', $fields);
    }

    public function down()
    {
        $this->forge->dropColumn('trn_pendaftaran', 'delete_requested');
    }
}
