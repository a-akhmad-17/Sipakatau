<?php

namespace App\Controllers;

use App\Controllers\BaseController;

class Eksekutif extends BaseController
{
    public function index(): string
    {
        $db = \Config\Database::connect();
        $today = date('Y-m-d');

        // 1. Akumulasi anggaran dan realisasi keuangan secara nasional/total
        $totalAnggaran = $db->table('trn_kegiatan_bidang')
                            ->select('SUM(target_keuangan) as total_target, SUM(realisasi_keuangan) as total_realisasi')
                            ->get()
                            ->getRowArray();

        $totalTarget = (double) ($totalAnggaran['total_target'] ?? 0.0);
        $totalRealisasi = (double) ($totalAnggaran['total_realisasi'] ?? 0.0);
        $persentaseKeuangan = $totalTarget > 0 ? ($totalRealisasi / $totalTarget) * 100 : 0.0;

        // Rata-rata fisik
        $avgFisik = $db->table('trn_kegiatan_bidang')
                       ->select('AVG(target_fisik) as avg_target, AVG(realisasi_fisik) as avg_realisasi')
                       ->get()
                       ->getRowArray();

        $avgTargetFisik = (double) ($avgFisik['avg_target'] ?? 0.0);
        $avgRealisasiFisik = (double) ($avgFisik['avg_realisasi'] ?? 0.0);
        $persentaseFisik = $avgTargetFisik > 0 ? ($avgRealisasiFisik / $avgTargetFisik) * 100 : 0.0;

        // 2. Count expired ormas
        $expiredCount = $db->table('mst_ormas')
                           ->where('tgl_sk_kedaluwarsa <', $today)
                           ->countAllResults();

        // 3. Count kendala
        $kendalaCount = $db->table('trn_kegiatan_bidang')
                           ->where('kendala IS NOT NULL')
                           ->where('kendala !=', '')
                           ->countAllResults();

        // 4. Count pengaduan
        $pengaduanCount = $db->table('log_activities')
                             ->where('action', 'DAFTAR_PENGADUAN_ANONIM')
                             ->countAllResults();

        $data = [
            'title'              => 'Executive Dashboard - SIPAKATAU',
            'totalTarget'        => $totalTarget,
            'totalRealisasi'     => $totalRealisasi,
            'persentaseKeuangan' => $persentaseKeuangan,
            'avgTargetFisik'     => $avgTargetFisik,
            'avgRealisasiFisik'  => $avgRealisasiFisik,
            'persentaseFisik'    => $persentaseFisik,
            'expiredCount'       => $expiredCount,
            'kendalaCount'       => $kendalaCount,
            'pengaduanCount'     => $pengaduanCount,
            'today'              => $today
        ];

        return view('eksekutif/dashboard_eksekutif', $data);
    }

    public function kinerja(): string
    {
        $db = \Config\Database::connect();
        
        $bidangKinerja = $db->table('mst_bidang b')
                            ->select('b.id, b.nama_bidang, b.kode_bidang, 
                                      COALESCE(SUM(k.target_keuangan), 0) as target_keuangan, 
                                      COALESCE(SUM(k.realisasi_keuangan), 0) as realisasi_keuangan,
                                      COALESCE(AVG(k.target_fisik), 0) as avg_target_fisik,
                                      COALESCE(AVG(k.realisasi_fisik), 0) as avg_realisasi_fisik')
                            ->join('trn_kegiatan_bidang k', 'k.bidang_id = b.id', 'left')
                            ->groupBy('b.id')
                            ->get()
                            ->getResultArray();

        $data = [
            'title'         => 'Kinerja Bidang - SIPAKATAU',
            'bidangKinerja' => $bidangKinerja
        ];

        return view('eksekutif/kinerja', $data);
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

        $data = [
            'title'     => 'Peta Sebaran GIS - SIPAKATAU',
            'ormas'     => $ormas,
            'parpol'    => $parpol,
            'hotspots'  => $hotspots,
            'pengaduan' => $pengaduan
        ];

        return view('eksekutif/gis', $data);
    }

    public function kendala(): string
    {
        $db = \Config\Database::connect();

        $kendalaKegiatan = $db->table('trn_kegiatan_bidang k')
                             ->select('k.*, b.nama_bidang, b.kode_bidang')
                             ->join('mst_bidang b', 'b.id = k.bidang_id')
                             ->where('k.kendala IS NOT NULL')
                             ->where('k.kendala !=', '')
                             ->orderBy('k.bulan_spj', 'DESC')
                             ->orderBy('k.created_at', 'DESC')
                             ->get()
                             ->getResultArray();

        $data = [
            'title'           => 'Kendala & Solusi Bidang - SIPAKATAU',
            'kendalaKegiatan' => $kendalaKegiatan
        ];

        return view('eksekutif/kendala', $data);
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

    public function cetakLaporan(): string
    {
        $db = \Config\Database::connect();
        $today = date('Y-m-d');

        // Fetch cumulative budget and financial realization
        $totalAnggaran = $db->table('trn_kegiatan_bidang')
                            ->select('SUM(target_keuangan) as total_target, SUM(realisasi_keuangan) as total_realisasi')
                            ->get()
                            ->getRowArray();

        $totalTarget = (double) ($totalAnggaran['total_target'] ?? 0.0);
        $totalRealisasi = (double) ($totalAnggaran['total_realisasi'] ?? 0.0);
        $persentaseKeuangan = $totalTarget > 0 ? ($totalRealisasi / $totalTarget) * 100 : 0.0;

        // Average physical realization
        $avgFisik = $db->table('trn_kegiatan_bidang')
                       ->select('AVG(target_fisik) as avg_target, AVG(realisasi_fisik) as avg_realisasi')
                       ->get()
                       ->getRowArray();

        $avgTargetFisik = (double) ($avgFisik['avg_target'] ?? 0.0);
        $avgRealisasiFisik = (double) ($avgFisik['avg_realisasi'] ?? 0.0);
        $persentaseFisik = $avgTargetFisik > 0 ? ($avgRealisasiFisik / $avgTargetFisik) * 100 : 0.0;

        // Cumulative performance per bidang
        $bidangKinerja = $db->table('mst_bidang b')
                            ->select('b.id, b.nama_bidang, b.kode_bidang, 
                                      COALESCE(SUM(k.target_keuangan), 0) as target_keuangan, 
                                      COALESCE(SUM(k.realisasi_keuangan), 0) as realisasi_keuangan,
                                      COALESCE(AVG(k.target_fisik), 0) as avg_target_fisik,
                                      COALESCE(AVG(k.realisasi_fisik), 0) as avg_realisasi_fisik')
                            ->join('trn_kegiatan_bidang k', 'k.bidang_id = b.id', 'left')
                            ->groupBy('b.id')
                            ->get()
                            ->getResultArray();

        // Expired Ormas (SK Merah)
        $expiredOrmas = $db->table('mst_ormas')
                           ->where('tgl_sk_kedaluwarsa <', $today)
                           ->orderBy('tgl_sk_kedaluwarsa', 'ASC')
                           ->get()
                           ->getResultArray();

        // Bidang obstacles
        $kendalaKegiatan = $db->table('trn_kegiatan_bidang k')
                             ->select('k.*, b.nama_bidang, b.kode_bidang')
                             ->join('mst_bidang b', 'b.id = k.bidang_id')
                             ->where('k.kendala IS NOT NULL')
                             ->where('k.kendala !=', '')
                             ->orderBy('k.bulan_spj', 'DESC')
                             ->orderBy('k.created_at', 'DESC')
                             ->get()
                             ->getResultArray();

        $data = [
            'title'              => 'Laporan Kinerja Bulanan Bakesbangpol Sinjai',
            'totalTarget'        => $totalTarget,
            'totalRealisasi'     => $totalRealisasi,
            'persentaseKeuangan' => $persentaseKeuangan,
            'avgTargetFisik'     => $avgTargetFisik,
            'avgRealisasiFisik'  => $avgRealisasiFisik,
            'persentaseFisik'    => $persentaseFisik,
            'bidangKinerja'      => $bidangKinerja,
            'expiredOrmas'       => $expiredOrmas,
            'kendalaKegiatan'    => $kendalaKegiatan,
            'today'              => $today
        ];

        return view('eksekutif/cetak_laporan', $data);
    }
}
