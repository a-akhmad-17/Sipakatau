<?php

use CodeIgniter\Router\RouteCollection;

/** @var RouteCollection $routes */
$routes->get('/', 'Home::index');

// Authentication Routes
$routes->get('login', 'Auth::login');
$routes->post('login', 'Auth::attemptLogin');
$routes->get('logout', 'Auth::logout');
$routes->get('register', 'Auth::register');
$routes->post('register', 'Auth::attemptRegister');
$routes->get('auth/google', 'Auth::google');
$routes->get('auth/google/simulation', 'Auth::googleSimulation');
$routes->get('auth/google/callback', 'Auth::googleCallback');
$routes->post('auth/google/callback', 'Auth::googleCallback');

// User & Ormas Dashboard Routes (Protected by auth filter - role: user, ormas)
$routes->group('user', ['filter' => 'auth:user,ormas'], function($routes) {
    $routes->get('/', 'User::index');
    $routes->get('ormas', 'User::ormas');
    $routes->get('pengajuan', 'User::pengajuan');
    $routes->post('pengajuan/simpan', 'User::simpanPengajuan');
    $routes->post('pengajuan/minta-hapus/(:any)', 'User::mintaHapus/$1');
    $routes->get('geocode', 'User::geocode');
    $routes->get('rekomendasi', 'User::rekomendasi');
    $routes->get('rekomendasi/baru', 'User::rekomendasiBaru');
    $routes->post('rekomendasi/minta-hapus/(:any)', 'User::mintaHapusRekomendasi/$1');
    $routes->get('pengaduan', 'User::pengaduan');
    $routes->get('pengaduan/baru', 'User::pengaduanBaru');
});


// Admin Dashboard Routes (Protected by auth filter - role: admin)
$routes->group('admin', ['filter' => 'auth:admin'], function($routes) {
    $routes->get('/', 'Admin::index');
    $routes->post('toggle-ormas/(:any)', 'Admin::toggleOrmas/$1');
    $routes->post('update-koordinat-ormas', 'Admin::updateKoordinatOrmas');
    $routes->post('tambah-ormas', 'Admin::tambahOrmas');
    $routes->post('update-ormas', 'Admin::updateOrmas');
    $routes->post('delete-ormas/(:any)', 'Admin::deleteOrmas/$1');
    $routes->post('proses-pendaftaran/(:any)/(:any)', 'Admin::prosesPendaftaran/$1/$2');
    $routes->post('proses-pendaftaran/setujui-hapus/(:any)', 'Admin::setujuiHapusPendaftaran/$1');
    $routes->post('proses-pendaftaran/tolak-hapus/(:any)', 'Admin::tolakHapusPendaftaran/$1');
    $routes->post('proses-rekomendasi/(:any)/(:any)', 'Admin::prosesRekomendasi/$1/$2');
    $routes->post('proses-rekomendasi/setujui-hapus/(:any)', 'Admin::setujuiHapusRekomendasi/$1');
    $routes->post('proses-rekomendasi/tolak-hapus/(:any)', 'Admin::tolakHapusRekomendasi/$1');
    $routes->post('tambah-hotspot', 'Admin::tambahHotspot');
    $routes->post('delete-hotspot/(:any)', 'Admin::deleteHotspot/$1');
    $routes->post('tambah-parpol', 'Admin::tambahParpol');
    $routes->post('update-parpol', 'Admin::updateParpol');
    $routes->post('delete-parpol/(:any)', 'Admin::deleteParpol/$1');
    $routes->post('update-koordinat-parpol', 'Admin::updateKoordinatParpol');
    $routes->post('antrean/panggil/(:any)', 'Admin::panggilAntrean/$1');
    $routes->post('antrean/selesai/(:any)', 'Admin::selesaiAntrean/$1');
    $routes->post('antrean/lewat/(:any)', 'Admin::lewatAntrean/$1');
    $routes->post('delete-pendaftaran/(:any)', 'Admin::deletePendaftaran/$1');
    $routes->post('update-progress', 'Admin::updateProgress');
    $routes->post('verify-document', 'Admin::verifyDocument');
    $routes->post('delete-rekomendasi/(:any)', 'Admin::deleteRekomendasi/$1');
    $routes->post('delete-pengaduan/(:any)', 'Admin::deletePengaduan/$1');
    $routes->post('delete-file-pengaduan/(:any)', 'Admin::deleteFilePengaduan/$1');
    $routes->post('proses-pengaduan/(:any)/(:any)', 'Admin::prosesPengaduan/$1/$2');

    // New Dedicated Settings Routes (CRUD)
    $routes->get('settings/visi-misi', 'Admin::settingsVisiMisi');
    $routes->post('settings/visi/update', 'Admin::updateVisi');
    $routes->post('settings/misi/tambah', 'Admin::tambahMisi');
    $routes->post('settings/misi/update', 'Admin::updateMisi');
    $routes->post('settings/misi/delete/(:num)', 'Admin::deleteMisi/$1');
    $routes->post('settings/portal/update', 'Admin::updatePortalSettings');

    $routes->get('settings/bidang', 'Admin::settingsBidang');
    $routes->post('settings/bidang/tambah', 'Admin::tambahBidang');
    $routes->post('settings/bidang/update', 'Admin::updateBidang');
    $routes->post('settings/bidang/delete/(:any)', 'Admin::deleteBidang/$1');

    $routes->get('settings/users', 'Admin::settingsUsers');
    $routes->post('settings/users/tambah', 'Admin::tambahUser');
    $routes->post('settings/users/update', 'Admin::updateUser');
    $routes->post('settings/users/delete/(:any)', 'Admin::deleteUser/$1');

    $routes->get('settings/struktur', 'Admin::settingsStruktur');
    $routes->post('settings/staf/tambah', 'Admin::tambahStaf');
    $routes->post('settings/staf/update', 'Admin::updateStaf');
    $routes->post('settings/staf/delete/(:any)', 'Admin::deleteStaf/$1');
    $routes->post('settings/staf/delete-photo/(:any)', 'Admin::deletePhotoStaf/$1');

    $routes->get('settings/video', 'Admin::settingsVideo');
    $routes->post('settings/video/tambah', 'Admin::tambahVideo');
    $routes->post('settings/video/update', 'Admin::updateVideo');
    $routes->post('settings/video/delete/(:any)', 'Admin::deleteVideo/$1');

});

// Bidang Dashboard Routes (Protected by auth filter - role: kabid)
$routes->group('bidang', ['filter' => 'auth:kabid'], function($routes) {
    $routes->get('/', 'Bidang::index');
    // Kelola Pendaftaran SKT Ormas — Khusus Kabid Poldagri & Ormas
    $routes->post('proses-pendaftaran/(:any)/(:any)', 'Bidang::prosesPendaftaran/$1/$2');
});

// Executive Dashboard Routes (Protected by auth filter - role: kaban)
$routes->group('eksekutif', ['filter' => 'auth:kaban'], function($routes) {
    $routes->get('/', 'Eksekutif::index');
    $routes->get('ormas-merah', 'Eksekutif::ormasMerah');
    $routes->get('gis', 'Eksekutif::gis');
    $routes->get('pengaduan', 'Eksekutif::pengaduan');
});

// Public Pages Routes (Fokus C - Bakesbangpol Reference)
$routes->get('profil', 'Home::profil');
$routes->get('bidang/(:any)', 'Home::bidangDetail/$1');
$routes->get('struktur', 'Home::struktur');
$routes->get('maklumat', 'Home::maklumat');
$routes->get('layanan/ormas', 'Home::daftarOrmas');
$routes->post('layanan/ormas', 'Home::simpanOrmas');
$routes->get('layanan/rekomendasi', 'Home::daftarRekomendasi');
$routes->post('layanan/rekomendasi', 'Home::simpanRekomendasi');
$routes->get('layanan/parpol', 'Home::daftarParpol');
$routes->post('layanan/parpol', 'Home::simpanParpol');
$routes->get('layanan/info-registrasi', 'Home::infoRegistrasi');
$routes->get('layanan/info-rekomendasi', 'Home::infoRekomendasi');
$routes->get('informasi/video', 'Home::video');
$routes->get('informasi/dokumentasi', 'Home::dokumentasi');
$routes->get('informasi/pengaduan', 'Home::pengaduan');
$routes->post('informasi/pengaduan', 'Home::simpanPengaduan');
$routes->get('layanan/lacak', 'Home::lacakBerkas');
$routes->post('layanan/hapus-berkas-ditolak', 'Home::hapusBerkasDitolak');
$routes->get('layanan/cetak-rekomendasi/(:any)', 'Home::cetakRekomendasi/$1');
$routes->get('layanan/cetak-permohonan/(:any)', 'Home::cetakPermohonan/$1');
$routes->post('layanan/ambil-antrean', 'Home::ambilAntrean');

