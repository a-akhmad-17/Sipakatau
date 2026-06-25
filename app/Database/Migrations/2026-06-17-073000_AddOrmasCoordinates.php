<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class AddOrmasCoordinates extends Migration
{
    public function up()
    {
        $fields = [
            'latitude' => [
                'type'       => 'DECIMAL',
                'constraint' => '10,8',
                'null'       => true,
                'after'      => 'file_logo'
            ],
            'longitude' => [
                'type'       => 'DECIMAL',
                'constraint' => '11,8',
                'null'       => true,
                'after'      => 'latitude'
            ],
        ];
        
        $this->forge->addColumn('mst_ormas', $fields);
    }

    public function down()
    {
        $this->forge->dropColumn('mst_ormas', ['latitude', 'longitude']);
    }
}
