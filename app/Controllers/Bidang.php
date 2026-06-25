<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use CodeIgniter\HTTP\ResponseInterface;

class Bidang extends BaseController
{
    public function index(): string
    {
        $db = \Config\Database::connect();
        $session = session();
        $bidangId = $session->get('bidang_id');

        // Ambil nama bidang
        $bidang = $db->table('mst_bidang')->where('id', $bidangId)->get()->getRowArray();
        $namaBidang = $bidang ? $bidang['nama_bidang'] : 'Semua Bidang';

        // Ambil riwayat kegiatan bidang ini
        $kegiatan = $db->table('trn_kegiatan_bidang')
                       ->where('bidang_id', $bidangId)
                       ->orderBy('bulan_spj', 'DESC')
                       ->orderBy('created_at', 'DESC')
                       ->get()
                       ->getResultArray();

        $ormas = $db->table('mst_ormas')->orderBy('nama_ormas', 'ASC')->get()->getResultArray();
        $parpol = $db->table('mst_parpol')->orderBy('nama_parpol', 'ASC')->get()->getResultArray();
        $pengaduan = $db->table('log_activities')
                        ->where('action', 'DAFTAR_PENGADUAN_ANONIM')
                        ->orderBy('created_at', 'DESC')
                        ->get()
                        ->getResultArray();

        $hotspotSetting = $db->table('sys_settings')->where('key', 'titik_kerawanan')->get()->getRowArray();
        $hotspots = $hotspotSetting ? json_decode($hotspotSetting['value'], true) : [];

        $lockedSetting = $db->table('sys_settings')->where('key', 'locked_spj_months')->get()->getRowArray();
        $lockedMonths = $lockedSetting ? json_decode($lockedSetting['value'], true) : [];
        if (!is_array($lockedMonths)) {
            $lockedMonths = [];
        }

        $data = [
            'title'        => 'Dashboard Bidang - SIPAKATAU',
            'namaBidang'   => $namaBidang,
            'kegiatan'     => $kegiatan,
            'ormas'        => $ormas,
            'parpol'       => $parpol,
            'pengaduan'    => $pengaduan,
            'hotspots'     => $hotspots,
            'lockedMonths' => $lockedMonths,
            'today'        => date('Y-m-d')
        ];

        return view('bidang/dashboard_bidang', $data);
    }

    public function laporKegiatan()
    {
        helper('app');
        $db = \Config\Database::connect();
        $session = session();
        $bidangId = $session->get('bidang_id');

        $validation = \Config\Services::validation();
        $validation->setRules([
            'nama_kegiatan'      => 'required|min_length[5]',
            'target_fisik'       => 'required|numeric',
            'realisasi_fisik'    => 'required|numeric',
            'target_keuangan'    => 'required|numeric',
            'realisasi_keuangan' => 'required|numeric',
            'bulan_spj'          => 'required|exact_length[7]',
        ]);

        if (!$validation->withRequest($this->request)->run()) {
            return redirect()->back()->withInput()->with('errors', $validation->getErrors());
        }

        $namaKegiatan      = $this->request->getPost('nama_kegiatan');
        $targetFisik       = (double) $this->request->getPost('target_fisik');
        $realisasiFisik    = (double) $this->request->getPost('realisasi_fisik');
        $targetKeuangan    = (double) $this->request->getPost('target_keuangan');
        $realisasiKeuangan = (double) $this->request->getPost('realisasi_keuangan');
        $bulanSpj          = $this->request->getPost('bulan_spj');
        $kendala           = $this->request->getPost('kendala');

        // Validasi Bulan SPJ Terkunci
        $lockedSetting = $db->table('sys_settings')->where('key', 'locked_spj_months')->get()->getRowArray();
        $lockedMonths = $lockedSetting ? json_decode($lockedSetting['value'], true) : [];
        if (is_array($lockedMonths) && in_array($bulanSpj, $lockedMonths)) {
            return redirect()->back()->withInput()->with('error', 'Gagal kirim! Periode SPJ bulan ' . $bulanSpj . ' telah dikunci oleh Admin.');
        }

        // Validasi Kendala Wajib jika Realisasi di bawah Target
        if (($realisasiFisik < $targetFisik || $realisasiKeuangan < $targetKeuangan) && empty(trim($kendala))) {
            return redirect()->back()->withInput()->with('error', 'Gagal kirim! Kolom kendala WAJIB diisi karena realisasi kegiatan Anda di bawah target yang ditetapkan.');
        }

        $id = sprintf('%04x%04x-%04x-%04x-%04x-%04x%04x%04x', mt_rand(0, 0xffff), mt_rand(0, 0xffff), mt_rand(0, 0xffff), mt_rand(0, 0x0fff) | 0x4000, mt_rand(0, 0x3fff) | 0x8000, mt_rand(0, 0xffff), mt_rand(0, 0xffff), mt_rand(0, 0xffff));

        $insertData = [
            'id'                 => $id,
            'bidang_id'          => $bidangId,
            'nama_kegiatan'      => $namaKegiatan,
            'target_fisik'       => $targetFisik,
            'realisasi_fisik'    => $realisasiFisik,
            'target_keuangan'    => $targetKeuangan,
            'realisasi_keuangan' => $realisasiKeuangan,
            'bulan_spj'          => $bulanSpj,
            'kendala'            => !empty(trim($kendala)) ? $kendala : null,
            'created_at'         => date('Y-m-d H:i:s'),
        ];

        $db->table('trn_kegiatan_bidang')->insert($insertData);

        log_activity('REPORT_ACTIVITY', null, $insertData, 'trn_kegiatan_bidang', $id);

        return redirect()->to('bidang')->with('success', 'Laporan kegiatan "' . $namaKegiatan . '" berhasil disimpan.');
    }
}
