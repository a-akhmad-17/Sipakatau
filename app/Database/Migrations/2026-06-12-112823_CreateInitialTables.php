<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class CreateInitialTables extends Migration
{
    public function up()
    {
        // 1. TABEL sys_users
        $this->forge->addField([
            'id' => [
                'type'       => 'VARCHAR',
                'constraint' => 36,
            ],
            'username' => [
                'type'       => 'VARCHAR',
                'constraint' => 50,
                'unique'     => true,
            ],
            'password' => [
                'type'       => 'VARCHAR',
                'constraint' => 255,
            ],
            'email' => [
                'type'       => 'VARCHAR',
                'constraint' => 100,
                'null'       => true,
            ],
            'role' => [
                'type'       => 'ENUM',
                'constraint' => ['admin', 'kaban', 'pptk', 'ormas'],
                'default'    => 'ormas',
            ],
            'status' => [
                'type'       => 'ENUM',
                'constraint' => ['active', 'inactive'],
                'default'    => 'active',
            ],
            'bidang_id' => [
                'type'       => 'VARCHAR',
                'constraint' => 36,
                'null'       => true,
            ],
            'created_at' => ['type' => 'DATETIME', 'null' => true],
            'updated_at' => ['type' => 'DATETIME', 'null' => true],
            'deleted_at' => ['type' => 'DATETIME', 'null' => true],
        ]);
        $this->forge->addKey('id', true);
        $this->forge->addKey('bidang_id');
        $this->forge->createTable('sys_users');

        // 2. TABEL mst_ormas
        $this->forge->addField([
            'id' => [
                'type'       => 'VARCHAR',
                'constraint' => 36,
            ],
            'nama_ormas' => [
                'type'       => 'VARCHAR',
                'constraint' => 150,
            ],
            'alamat' => [
                'type'       => 'TEXT',
                'null'       => true,
            ],
            'email' => [
                'type'       => 'VARCHAR',
                'constraint' => 100,
                'null'       => true,
            ],
            'telepon' => [
                'type'       => 'VARCHAR',
                'constraint' => 20,
                'null'       => true,
            ],
            'status' => [
                'type'       => 'ENUM',
                'constraint' => ['Aktif', 'Tidak Aktif'],
                'default'    => 'Aktif',
            ],
            'tgl_sk_kepengurusan' => [
                'type' => 'DATE',
                'null' => true,
            ],
            'tgl_sk_kedaluwarsa' => [
                'type' => 'DATE',
                'null' => true,
            ],
            'file_logo' => [
                'type'       => 'VARCHAR',
                'constraint' => 255,
                'null'       => true,
            ],
            'created_at' => ['type' => 'DATETIME', 'null' => true],
            'updated_at' => ['type' => 'DATETIME', 'null' => true],
            'deleted_at' => ['type' => 'DATETIME', 'null' => true],
        ]);
        $this->forge->addKey('id', true);
        $this->forge->addKey('status');
        $this->forge->addKey('tgl_sk_kedaluwarsa');
        $this->forge->createTable('mst_ormas');

        // 3. TABEL mst_parpol
        $this->forge->addField([
            'id' => [
                'type'       => 'VARCHAR',
                'constraint' => 36,
            ],
            'nama_parpol' => [
                'type'       => 'VARCHAR',
                'constraint' => 150,
            ],
            'lambang' => [
                'type'       => 'VARCHAR',
                'constraint' => 255,
                'null'       => true,
            ],
            'alamat' => [
                'type'       => 'TEXT',
                'null'       => true,
            ],
            'telepon' => [
                'type'       => 'VARCHAR',
                'constraint' => 20,
                'null'       => true,
            ],
            'ketua' => [
                'type'       => 'VARCHAR',
                'constraint' => 100,
                'null'       => true,
            ],
            'created_at' => ['type' => 'DATETIME', 'null' => true],
            'updated_at' => ['type' => 'DATETIME', 'null' => true],
            'deleted_at' => ['type' => 'DATETIME', 'null' => true],
        ]);
        $this->forge->addKey('id', true);
        $this->forge->createTable('mst_parpol');

        // 4. TABEL mst_bidang
        $this->forge->addField([
            'id' => [
                'type'       => 'VARCHAR',
                'constraint' => 36,
            ],
            'nama_bidang' => [
                'type'       => 'VARCHAR',
                'constraint' => 100,
            ],
            'kode_bidang' => [
                'type'       => 'VARCHAR',
                'constraint' => 20,
                'unique'     => true,
            ],
            'created_at' => ['type' => 'DATETIME', 'null' => true],
            'updated_at' => ['type' => 'DATETIME', 'null' => true],
            'deleted_at' => ['type' => 'DATETIME', 'null' => true],
        ]);
        $this->forge->addKey('id', true);
        $this->forge->createTable('mst_bidang');

        // 6. TABEL trn_pendaftaran
        $this->forge->addField([
            'id' => [
                'type'       => 'VARCHAR',
                'constraint' => 36,
            ],
            'ormas_id' => [
                'type'       => 'VARCHAR',
                'constraint' => 36,
                'null'       => true,
            ],
            'nomor_registrasi' => [
                'type'       => 'VARCHAR',
                'constraint' => 50,
                'unique'     => true,
            ],
            'progress_percentage' => [
                'type'    => 'INT',
                'default' => 0,
            ],
            'status_verifikasi' => [
                'type'       => 'ENUM',
                'constraint' => ['Draft', 'Pending', 'Approved', 'Rejected'],
                'default'    => 'Draft',
            ],
            'created_at' => ['type' => 'DATETIME', 'null' => true],
            'updated_at' => ['type' => 'DATETIME', 'null' => true],
            'deleted_at' => ['type' => 'DATETIME', 'null' => true],
        ]);
        $this->forge->addKey('id', true);
        $this->forge->addKey('ormas_id');
        $this->forge->addKey('status_verifikasi');
        $this->forge->createTable('trn_pendaftaran');

        // 7. TABEL trn_rekomendasi
        $this->forge->addField([
            'id' => [
                'type'       => 'VARCHAR',
                'constraint' => 36,
            ],
            'nama_kegiatan' => [
                'type'       => 'VARCHAR',
                'constraint' => 255,
            ],
            'pemohon' => [
                'type'       => 'VARCHAR',
                'constraint' => 150,
            ],
            'tgl_mulai' => [
                'type' => 'DATE',
                'null' => true,
            ],
            'tgl_selesai' => [
                'type' => 'DATE',
                'null' => true,
            ],
            'deskripsi' => [
                'type' => 'TEXT',
                'null' => true,
            ],
            'status_rekomendasi' => [
                'type'       => 'ENUM',
                'constraint' => ['Pending', 'Approved', 'Rejected'],
                'default'    => 'Pending',
            ],
            'pdf_tte_path' => [
                'type'       => 'VARCHAR',
                'constraint' => 255,
                'null'       => true,
            ],
            'created_at' => ['type' => 'DATETIME', 'null' => true],
            'updated_at' => ['type' => 'DATETIME', 'null' => true],
            'deleted_at' => ['type' => 'DATETIME', 'null' => true],
        ]);
        $this->forge->addKey('id', true);
        $this->forge->createTable('trn_rekomendasi');

        // 8. TABEL trn_kegiatan_bidang
        $this->forge->addField([
            'id' => [
                'type'       => 'VARCHAR',
                'constraint' => 36,
            ],
            'bidang_id' => [
                'type'       => 'VARCHAR',
                'constraint' => 36,
            ],
            'nama_kegiatan' => [
                'type'       => 'VARCHAR',
                'constraint' => 255,
            ],
            'target_fisik' => [
                'type'    => 'DOUBLE',
                'default' => 0.0,
            ],
            'realisasi_fisik' => [
                'type'    => 'DOUBLE',
                'default' => 0.0,
            ],
            'target_keuangan' => [
                'type'    => 'DOUBLE',
                'default' => 0.0,
            ],
            'realisasi_keuangan' => [
                'type'    => 'DOUBLE',
                'default' => 0.0,
            ],
            'bulan_spj' => [
                'type'       => 'VARCHAR',
                'constraint' => 7, // Format YYYY-MM
            ],
            'kendala' => [
                'type' => 'TEXT',
                'null' => true, // Wajib diisi di UI jika realisasi < target
            ],
            'created_at' => ['type' => 'DATETIME', 'null' => true],
            'updated_at' => ['type' => 'DATETIME', 'null' => true],
            'deleted_at' => ['type' => 'DATETIME', 'null' => true],
        ]);
        $this->forge->addKey('id', true);
        $this->forge->addKey('bidang_id');
        $this->forge->addKey('bulan_spj');
        $this->forge->createTable('trn_kegiatan_bidang');

        // 9. TABEL log_activities
        $this->forge->addField([
            'id' => [
                'type'       => 'VARCHAR',
                'constraint' => 36,
            ],
            'user_id' => [
                'type'       => 'VARCHAR',
                'constraint' => 36,
                'null'       => true,
            ],
            'action' => [
                'type'       => 'VARCHAR',
                'constraint' => 100,
            ],
            'table_name' => [
                'type'       => 'VARCHAR',
                'constraint' => 50,
                'null'       => true,
            ],
            'record_id' => [
                'type'       => 'VARCHAR',
                'constraint' => 36,
                'null'       => true,
            ],
            'before_data' => [
                'type' => 'TEXT',
                'null' => true,
            ],
            'after_data' => [
                'type' => 'TEXT',
                'null' => true,
            ],
            'ip_address' => [
                'type'       => 'VARCHAR',
                'constraint' => 45,
                'null'       => true,
            ],
            'user_agent' => [
                'type'       => 'VARCHAR',
                'constraint' => 255,
                'null'       => true,
            ],
            'created_at' => ['type' => 'DATETIME', 'null' => true],
        ]);
        $this->forge->addKey('id', true);
        $this->forge->addKey('user_id');
        $this->forge->addKey('created_at');
        $this->forge->createTable('log_activities');
    }

    public function down()
    {
        $this->forge->dropTable('log_activities', true);
        $this->forge->dropTable('trn_kegiatan_bidang', true);
        $this->forge->dropTable('trn_rekomendasi', true);
        $this->forge->dropTable('trn_pendaftaran', true);
        $this->forge->dropTable('mst_bidang', true);
        $this->forge->dropTable('mst_parpol', true);
        $this->forge->dropTable('mst_ormas', true);
        $this->forge->dropTable('sys_users', true);
    }
}
