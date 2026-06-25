<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class AddVideoSettings extends Migration
{
    public function up()
    {
        $db = \Config\Database::connect();
        
        $defaultVideos = [
            [
                'id' => 'video_1',
                'title' => 'Pendidikan Wawasan Kebangsaan Bagi Pemuda',
                'category' => 'Wawasan Kebangsaan',
                'description' => 'Pembinaan karakter pancasila dan integrasi bangsa bagi kalangan remaja dan pelajar daerah.',
                'youtube_id' => 'dQw4w9WgXcQ',
                'duration' => '5:12',
                'source' => 'Badan Kesbangpol Sinjai'
            ],
            [
                'id' => 'video_2',
                'title' => 'Bela Negara di Era Informasi Digital',
                'category' => 'Bela Negara',
                'description' => 'Bagaimana menyaring hoaks, meminimalisir ujaran kebencian, dan menjaga persatuan bangsa di ruang digital.',
                'youtube_id' => 'Y8HOfcLn-kY',
                'duration' => '7:45',
                'source' => 'Diskominfo Sinjai'
            ],
            [
                'id' => 'video_3',
                'title' => 'Harmoni Kebinekaan di Bumi Panrita Kitta',
                'category' => 'Kerukunan',
                'description' => 'Refleksi kerukunan antarumat beragama dan pelestarian adat budaya lokal Kabupaten Sinjai.',
                'youtube_id' => 'gWz2qgD1oB0',
                'duration' => '6:30',
                'source' => 'FKUB Sinjai'
            ]
        ];

        $db->table('sys_settings')->insert([
            'key' => 'video_edukasi',
            'value' => json_encode($defaultVideos),
            'group' => 'informasi',
            'created_at' => date('Y-m-d H:i:s'),
            'updated_at' => date('Y-m-d H:i:s')
        ]);
    }

    public function down()
    {
        $db = \Config\Database::connect();
        $db->table('sys_settings')->where('key', 'video_edukasi')->delete();
    }
}
