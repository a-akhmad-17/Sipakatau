# Rencana Implementasi Awal Aplikasi Web SIPAKATAU

Rencana ini memaparkan langkah-langkah teknis untuk menginisialisasi proyek baru **SIPAKATAU** (Sistem Pelayanan Kesbangpol Terpadu dan Akurat) berbasis **CodeIgniter 4** (CI4) di dalam direktori kerja `e:\Xampp\htdocs\SIPAKATAU`.

---

## User Review Required

> [!IMPORTANT]
> **Poin Penting untuk Ditinjau:**
> 1. **Metode Instalasi CI4:** Prosedur inisialisasi direkomendasikan menggunakan Composer (`composer create-project codeigniter4/appstarter .`). Mohon pastikan koneksi internet aktif dan Composer terinstal dengan baik di komputer lokal.
> 2. **Konfigurasi Database:** Secara default, konfigurasi koneksi database akan diarahkan ke server database lokal MySQL/MariaDB (XAMPP) dengan nama database `db_sipakatau`, username `root`, dan password kosong (`""`). Jika ada penyesuaian kredensial database, mohon diinformasikan.
> 3. **Library Keamanan & TTE:** Untuk TTE (Tanda Tangan Elektronik), tahap awal akan menggunakan simulasi penandatanganan PDF (mengintegrasikan library PDF lokal) sebelum dihubungkan ke API BSrE Pemkab Sinjai.

---

## Open Questions

> [!WARNING]
> **Pertanyaan Terbuka:**
> 1. Apakah database dengan nama `db_sipakatau` sudah dibuat sebelumnya di MySQL lokal Sayang, ataukah sistem perlu menyertakan instruksi pembuatan database secara otomatis (lewat migrasi/skrip SQL)?
> 2. Untuk integrasi **Siola** dan **e-SAKIP/LAKIP**, apakah kita sudah memiliki spesifikasi format API / endpoint sandbox yang bisa digunakan untuk uji coba, atau kita akan membuat data tiruan (mock data) terlebih dahulu di awal?

---

## Proposed Changes

Proses inisialisasi akan dilakukan secara bertahap dengan membuat file-file konfigurasi dasar berikut:

### 1. Project Initialization & Environment Configuration

Inisialisasi CodeIgniter 4 dan konfigurasi parameter sistem dasar.

#### [NEW] [.env](file:///e:/Xampp/htdocs/SIPAKATAU/.env)
File konfigurasi lingkungan lokal yang mendefinisikan database, enkripsi keamanan (CSRF & XSS), dan URL dasar.
- `CI_ENVIRONMENT = development`
- `app.baseURL = 'http://localhost/SIPAKATAU/public/'`
- `database.default.database = db_sipakatau`
- `database.default.username = root`
- `database.default.password = `
- `security.CSRFProtection = true` (Keamanan CSRF wajib aktif)

---

### 2. Database Migrations & Seeders

Penyusunan tabel database baru dengan skema penamaan prefix terstruktur, indeks pencarian, dan penanganan Soft Deletes (`deleted_at`).

#### [NEW] [Migration_CreateInitialTables.php](file:///e:/Xampp/htdocs/SIPAKATAU/app/Database/Migrations/20260612000001_CreateInitialTables.php)
File migrasi database untuk membuat tabel-tabel utama:
- `sys_users` (Manajemen pengguna)
- `mst_ormas` (Data master Ormas dengan status aktif/tidak aktif)
- `mst_parpol` (Data master Partai Politik)
- `mst_bidang` (Data master Bidang)
- `mst_logistik` (Persediaan barang internal)
- `trn_pendaftaran` (Transaksi registrasi ormas, kolom `progress_percentage` & draf)
- `trn_rekomendasi` (Pengajuan rekomendasi izin kegiatan)
- `trn_kegiatan_bidang` (Laporan fisik/keuangan dan kolom kendala)
- `log_activities` (Audit trail perubahan data before-after)

---

### 3. Utilitas & Helper Keamanan

Implementasi utilitas pembantu untuk audit trail dan pelaporan kesalahan sistem.

#### [NEW] [app_helper.php](file:///e:/Xampp/htdocs/SIPAKATAU/app/Helpers/app_helper.php)
Menyediakan fungsi global `log_activity()` untuk mencatat jejak perubahan data lama vs baru sebelum disimpan ke database, serta helper untuk upload gambar otomatis dikonversi ke format WebP.

#### [NEW] [telegram_helper.php](file:///e:/Xampp/htdocs/SIPAKATAU/app/Helpers/telegram_helper.php)
Mengirimkan pesan kesalahan sistem internal (Error 500) dan log transaksi penting langsung ke bot/grup Telegram untuk monitoring.

---

### 4. Layout Dasar & Dashboard (Front-end & Back-end)

Pembuatan layout dasar dan aset visual awal.

#### [NEW] [Home.php](file:///e:/Xampp/htdocs/SIPAKATAU/app/Controllers/Home.php)
Controller utama yang mengarahkan ke portal pelayanan publik di sisi depan.

#### [NEW] [layout.php](file:///e:/Xampp/htdocs/SIPAKATAU/app/Views/layouts/main.php)
Template dasar UI responsive yang premium untuk halaman portal publik dan halaman admin/dashboard bidang.

---

## Verification Plan

### Automated Tests
- Menjalankan pengecekan sintaksis PHP (Linting):
  ```bash
  php -l app/Controllers/Home.php
  php -l app/Helpers/app_helper.php
  ```
- Menjalankan perintah migrasi basis data untuk memastikan skema berhasil terbuat:
  ```bash
  php spark migrate
  ```

### Manual Verification
1. Mengakses `http://localhost/SIPAKATAU/public` di peramban (browser) untuk memastikan halaman utama portal publik ter-load dengan benar.
2. Memeriksa pembuatan draf pendaftaran ormas (simulasi AJAX save) dan verifikasi respon JSON terstruktur.
3. Mencoba memicu log aktivitas lewat aksi dummy untuk memastikan tabel `log_activities` merekam data detail *Before* dan *After*.
