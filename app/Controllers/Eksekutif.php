<?php

namespace App\Controllers;

use App\Controllers\BaseController;

class Eksekutif extends BaseController
{
    public function index(): string
    {
        $db = \Config\Database::connect();
        $today = date('Y-m-d');

        // Count expired ormas (SK Merah)
        $expiredCount = $db->table('mst_ormas')
                           ->where('tgl_sk_kedaluwarsa <', $today)
                           ->countAllResults();

        // Count pengaduan masyarakat
        $pengaduanCount = $db->table('log_activities')
                             ->where('action', 'DAFTAR_PENGADUAN_ANONIM')
                             ->countAllResults();

        $data = [
            'title'          => 'Executive Dashboard - SIPAKATAU',
            'expiredCount'   => $expiredCount,
            'pengaduanCount' => $pengaduanCount,
            'today'          => $today
        ];

        return view('eksekutif/dashboard_eksekutif', $data);
    }

    public function ormasMerah(): string
    {
        $db = \Config\Database::connect();
        $today = date('Y-m-d');

        $expiredOrmas = $db->table('mst_ormas')
                           ->where('tgl_sk_kedaluwarsa <', $today)
                           ->orderBy('tgl_sk_kedaluwarsa', 'ASC')
                           ->get()
                           ->getResultArray();

        $data = [
            'title'        => 'Ormas SK Merah - SIPAKATAU',
            'expiredOrmas' => $expiredOrmas,
            'today'        => $today
        ];

        return view('eksekutif/ormas_merah', $data);
    }

    public function gis(): string
    {
        $db = \Config\Database::connect();

        $ormas = $db->table('mst_ormas')->orderBy('nama_ormas', 'ASC')->get()->getResultArray();
        $parpol = $db->table('mst_parpol')->orderBy('nama_parpol', 'ASC')->get()->getResultArray();

        $hotspotSetting = $db->table('sys_settings')->where('key', 'titik_kerawanan')->get()->getRowArray();
        $hotspots = $hotspotSetting ? json_decode($hotspotSetting['value'], true) : [];

        $pengaduan = $db->table('log_activities')
                        ->where('action', 'DAFTAR_PENGADUAN_ANONIM')
                        ->orderBy('created_at', 'DESC')
                        ->get()
                        ->getResultArray();

        $rekomendasi = $db->table('trn_rekomendasi')
                          ->orderBy('created_at', 'DESC')
                          ->get()
                          ->getResultArray();

        $data = [
            'title'       => 'Peta Sebaran GIS - SIPAKATAU',
            'ormas'       => $ormas,
            'parpol'      => $parpol,
            'hotspots'    => $hotspots,
            'pengaduan'   => $pengaduan,
            'rekomendasi' => $rekomendasi
        ];

        return view('eksekutif/gis', $data);
    }

    public function pengaduan(): string
    {
        $db = \Config\Database::connect();

        $pengaduan = $db->table('log_activities')
                        ->where('action', 'DAFTAR_PENGADUAN_ANONIM')
                        ->orderBy('created_at', 'DESC')
                        ->get()
                        ->getResultArray();

        $data = [
            'title'     => 'Laporan Pengaduan Masyarakat - SIPAKATAU',
            'pengaduan' => $pengaduan
        ];

        return view('eksekutif/pengaduan', $data);
    }
}
