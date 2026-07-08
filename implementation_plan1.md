# Rencana Implementasi Pembaruan Fitur SIPAKATAU (Meet 3 Kesbangpol & Tabel Upload Per Poin)

Rencana ini menggabungkan seluruh pembaruan teknis hasil rapat evaluasi ke-3 (Meet 3) dengan pihak Kesbangpol serta permintaan baru untuk memisahkan berkas persyaratan menjadi **Tabel Validasi Kelengkapan Dokumen** (unggah mandiri per-poin dokumen) di aplikasi **SIPAKATAU** berbasis **CodeIgniter 4**.

---

## User Review Required

> [!IMPORTANT]
> **Poin Penting untuk Ditinjau oleh Sayang (Ayang):**
> 1. **Penyimpanan Berkas Per-Poin (JSON Structure):** Kolom `mst_ormas.file_berkas` and `trn_rekomendasi.file_proposal` akan digunakan untuk menyimpan objek JSON berisi daftar file yang berhasil diunggah (misal: `{"1":"file_permohonan.pdf", "2":"ad_art.pdf", ...}`). Hal ini mematuhi aturan *Legacy Support* (tidak perlu mengubah struktur tabel secara radikal).
> 2. **Pemisahan Role Kabid & PPTK:** Pengajuan ormas yang lolos verifikasi Admin akan berstatus "Sedang Diajukan ke Kemendagri" (Progres 50%). Setelah SKT fisik terbit dari pusat, Kabid yang akan mengunggah file SKT tersebut di dasbornya dan mengubah status menjadi "Selesai" (Progres 100%).
> 3. **Input Kepengurusan Otomatis:** Form pengajuan ormas akan memiliki input data pengurus secara dinamis (Ketua, Sekretaris, Bendahara, dll.) yang disimpan ke tabel baru `mst_ormas_pengurus`.
> 4. **Penghapusan Total Fitur SPJ:** Seluruh fitur internal SPJ, dashboard keuangan PPTK, dan menu terkait akan dihapus total karena dialihkan ke aplikasi eksternal.

---

## Open Questions

> [!WARNING]
> **Pertanyaan Terbuka:**
> 1. Apakah template PDF untuk **Surat Permohonan Baru ke Kemendagri** (untuk diunduh user setelah verifikasi awal) dan **Surat Rekomendasi Kegiatan** sudah memiliki format margin / kop surat khusus? Jika belum, kami akan menggunakan format standar Kop Bakesbangpol Sinjai.
> 2. Untuk penentuan koordinat parpol, apakah kita menggunakan Leaflet Map Picker yang sama dengan form ormas?

---

## Proposed Changes

### 1. Database Schema Changes (Pondasi Data)

#### [NEW] [Migration_UpdateDatabaseMeet3.php](file:///f:/Xampp/htdocs/SIPAKATAU/app/Database/Migrations/20260706000001_UpdateDatabaseMeet3.php)
- Modifikasi tabel `sys_users`: Tambahkan kolom `phone` (varchar 20) untuk profil kontak.
- Modifikasi tabel `trn_pendaftaran`:
  - Tambahkan `tipe_ormas` (enum('Nasional', 'Lokal'), default 'Lokal').
  - Tambahkan `file_skt` (varchar 255) untuk menampung file SKT dari pusat yang diunggah Kabid.
- Modifikasi tabel `mst_parpol`:
  - Tambahkan `has_kursi` (tinyint 1, default 0), `periode_dewan` (varchar 50), dan `level_dewan` (varchar 50).
- Modifikasi tabel `trn_rekomendasi`:
  - Tambahkan `lokasi_kegiatan` (text), `is_fasilitas_pemerintah` (tinyint 1), dan `detail_fasilitas` (text).
- **Tabel Baru** `mst_ormas_pengurus`:
  - `id` (UUID), `ormas_id` (UUID), `nama` (varchar 100), `jabatan` (varchar 50), `no_hp` (varchar 20), `created_at` & `updated_at`.

---

### 2. Sisi Pengguna / Pendaftar Ormas (User Interface)

#### [MODIFY] [form_pengajuan.php](file:///f:/Xampp/htdocs/SIPAKATAU/app/Views/user/form_pengajuan.php)
- Tambahkan input nomor HP yang terikat ke profil.
- Tambahkan selektor Tipe Organisasi (Lokal vs Berjenjang/Nasional).
- Integrasikan form kepengurusan dinamis (tambah/hapus baris pengurus) yang akan disimpan ke tabel `mst_ormas_pengurus`.
- **Tabel Validasi Kelengkapan Dokumen:**
  - Ganti input file `file_berkas` tunggal dengan tabel daftar berkas persyaratan.
  - Tampilkan 14 baris dokumen persyaratan untuk tipe "Lokal" dan 8 baris dokumen untuk tipe "Berjenjang".
  - Setiap baris memiliki kolom: `#`, `Nama Dokumen`, `Status` (badge "Ada" hijau / "Belum Ada" merah), `Format` (PDF/Gambar), `File` (nama file dengan link download jika ada), dan `Aksi` (input file terpisah `file_berkas_1` s/d `file_berkas_14` berformat tombol).
  - Perbarui JavaScript `updateFormProgress()` untuk menghitung progres kelayakan secara real-time berdasarkan pengisian data (bobot 50%) dan jumlah berkas yang diunggah di tabel (bobot 50%).

#### [MODIFY] [form_rekomendasi.php](file:///f:/Xampp/htdocs/SIPAKATAU/app/Views/layanan/form_rekomendasi.php)
- Terapkan tabel kelengkapan dokumen yang sama untuk 6 poin persyaratan rekomendasi kegiatan.
- Setiap baris memiliki input file individual `file_proposal_1` s/d `file_proposal_6`.
- Tambahkan checkbox "Menggunakan Fasilitas Pemerintah" dan input "Lokasi Kegiatan".
- Hitung progres pengisian dinamis (50% isian data + 50% unggahan berkas tabel).

#### [MODIFY] [dashboard.php](file:///f:/Xampp/htdocs/SIPAKATAU/app/Views/user/dashboard.php)
- Batasi progres maksimal 50% ketika berkas disetujui Admin (Sedang Diajukan ke Kemendagri). Progres menjadi 100% setelah Kabid mengunggah SKT pusat.
- Ganti link download berkas tunggal dengan tabel **Validasi Kelengkapan Dokumen** yang menampilkan status dan link unduh masing-masing file yang diunggah pengguna.
- Tampilkan tombol unduh file SKT pusat setelah diterbitkan oleh Kabid.
- Sembunyikan daftar TTE di halaman publik dan pindahkan ke tab khusus di dashboard yang hanya bisa diakses setelah login.

#### [NEW] [cetak_permohonan.php](file:///f:/Xampp/htdocs/SIPAKATAU/app/Views/layanan/cetak_permohonan.php)
- Halaman cetak otomatis Surat Permohonan Pendaftaran Ormas baru berformat PDF standar Kemendagri.

---

### 3. Sisi Admin Kesbangpol (OPD Admin Panel)

#### [MODIFY] [Admin.php](file:///f:/Xampp/htdocs/SIPAKATAU/app/Controllers/Admin.php)
- Ubah alur verifikasi berkas: tombol "Setujui Kelayakan Berkas" hanya aktif apabila semua berkas di tabel berstatus lengkap.
- Ubah status pendaftaran menjadi "Sedang Diajukan ke Kemendagri" (Progres 50%) pasca validasi Admin.
- Tambahkan parameter periode, kursi, dan level anggota dewan pada CRUD parpol.
- Hapus total fungsi dan rute penguncian SPJ bulanan (`updateKunciSpj`, `settingsSpj`, dll.).

#### [MODIFY] [dashboard.php](file:///f:/Xampp/htdocs/SIPAKATAU/app/Views/admin/dashboard.php)
- Pada modal detail tracking (`modalDetailTracking`), jika data berkas berupa JSON, lakukan parse via JavaScript dan tampilkan tabel kelengkapan dokumen agar verifikator admin dapat membuka, melihat, dan memeriksa berkas secara per-poin.
- Integrasikan GIS Marker Picker pada form tambah/edit Partai Politik.

#### [MODIFY] [settings_bidang.php](file:///f:/Xampp/htdocs/SIPAKATAU/app/Views/admin/settings_bidang.php)
- Tambahkan fitur "Tambah Bidang Baru" secara dinamis di antarmuka.

#### [MODIFY] [settings_video.php](file:///f:/Xampp/htdocs/SIPAKATAU/app/Views/admin/settings_video.php)
- Bersihkan inputan "durasi konten" dan "url link" pada form video.

#### [DELETE] [settings_spj.php](file:///f:/Xampp/htdocs/SIPAKATAU/app/Views/admin/settings_spj.php)
- Hapus file view SPJ.

---

### 4. Sisi Kepala Bidang (Kabid)

#### [MODIFY] [Bidang.php](file:///f:/Xampp/htdocs/SIPAKATAU/app/Controllers/Bidang.php)
- Tambahkan method `unggahSktDanSelesaikan()`: menerima unggahan file SKT (PDF) dari pusat, menyimpannya di direktori `uploads/skt`, mengubah progres pendaftaran menjadi 100%, dan status menjadi Approved/Selesai.

#### [MODIFY] [dashboard_bidang.php](file:///f:/Xampp/htdocs/SIPAKATAU/app/Views/bidang/dashboard_bidang.php)
- Hapus modul keuangan/SPJ internal.
- Tambahkan modul **Penerbitan SKT (Kabid)**: Menampilkan daftar pengajuan dengan status "Sedang Diajukan ke Kemendagri". Kabid dapat meninjau data pengurus, berkas persyaratan (dalam bentuk tabel kelengkapan), dan mengunggah SKT pusat untuk menyelesaikan proses pendaftaran.

---

### 5. Sisi Eksekutif & Halaman Publik

#### [MODIFY] [Eksekutif.php](file:///f:/Xampp/htdocs/SIPAKATAU/app/Controllers/Eksekutif.php) & [gis.php](file:///f:/Xampp/htdocs/SIPAKATAU/app/Views/eksekutif/gis.php)
- Hapus metrik SPJ dan data keuangan.
- Tambahkan filter tahun (default 2026) pada GIS peta aduan dan rawan konflik.

#### [MODIFY] [lacak.php](file:///f:/Xampp/htdocs/SIPAKATAU/app/Views/layanan/lacak.php)
- Tampilkan tabel kelengkapan berkas persyaratan ormas/kegiatan di halaman lacak berkas publik.

---

## Verification Plan

### Automated Tests
- Lakukan pengecekan sintaksis PHP (Linting):
  ```powershell
  php -l app/Controllers/User.php
  php -l app/Controllers/Home.php
  php -l app/Controllers/Admin.php
  php -l app/Controllers/Bidang.php
  ```

### Manual Verification
1. **Verifikasi Form & Progres Dinamis:** Buka form pengajuan ormas dengan akun User, pilih tipe ormas, unggah beberapa berkas di tabel persyaratan, pastikan progres bar naik per poin berkas yang diunggah.
2. **Pengiriman & Struktur JSON:** Kirim berkas pengajuan, periksa di database pada tabel `mst_ormas.file_berkas` apakah tersimpan dalam bentuk string JSON terstruktur.
3. **Pengecekan di Dasbor Admin & Lacak Berkas:** Buka modal detail tracking di dashboard admin dan halaman `layanan/lacak` publik, pastikan tabel kelengkapan berkas ter-render dengan benar sesuai isi JSON.
4. **Alur Validasi Kabid:** Login sebagai Kabid, buka berkas berstatus "Sedang Diajukan ke Kemendagri", unggah SKT pusat, dan verifikasi status akhir di sisi User berubah menjadi 100% (Selesai).
