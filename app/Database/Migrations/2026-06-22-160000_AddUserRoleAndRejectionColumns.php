<?php
 
namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class AddUserRoleAndRejectionColumns extends Migration
{
    public function up()
    {
        $db = \Config\Database::connect();
        
        // 1. Ubah kolom role pada sys_users untuk menambahkan role 'user'
        $db->query("ALTER TABLE sys_users MODIFY COLUMN role ENUM('admin', 'kaban', 'pptk', 'ormas', 'user') DEFAULT 'user'");

        // 2. Tambahkan kolom user_id dan alasan_ditolak pada trn_pendaftaran
        $fields = [
            'user_id' => [
                'type'       => 'VARCHAR',
                'constraint' => 36,
                'null'       => true,
                'after'      => 'ormas_id'
            ],
            'alasan_ditolak' => [
                'type'       => 'TEXT',
                'null'       => true,
                'after'      => 'status_verifikasi'
            ]
        ];
        
        $this->forge->addColumn('trn_pendaftaran', $fields);
    }

    public function down()
    {
        $db = \Config\Database::connect();
        
        // 1. Hapus kolom dari trn_pendaftaran
        $this->forge->dropColumn('trn_pendaftaran', ['user_id', 'alasan_ditolak']);

        // 2. Kembalikan kolom role sys_users ke semula
        $db->query("UPDATE sys_users SET role = 'ormas' WHERE role = 'user'");
        $db->query("ALTER TABLE sys_users MODIFY COLUMN role ENUM('admin', 'kaban', 'pptk', 'ormas') DEFAULT 'ormas'");
    }
}
