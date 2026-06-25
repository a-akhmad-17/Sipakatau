<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class AddParpolFields extends Migration
{
    public function up()
    {
        $fields = [
            'latitude' => [
                'type'       => 'DECIMAL',
                'constraint' => '10,8',
                'null'       => true,
                'after'      => 'ketua'
            ],
            'longitude' => [
                'type'       => 'DECIMAL',
                'constraint' => '11,8',
                'null'       => true,
                'after'      => 'latitude'
            ],
            'file_sk' => [
                'type'       => 'VARCHAR',
                'constraint' => 255,
                'null'       => true,
                'after'      => 'lambang'
            ],
        ];
        
        $this->forge->addColumn('mst_parpol', $fields);
    }

    public function down()
    {
        $this->forge->dropColumn('mst_parpol', ['latitude', 'longitude', 'file_sk']);
    }
}
