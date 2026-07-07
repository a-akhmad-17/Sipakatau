# RELEASE NOTES - SIPAKATAU

## [v2.9.3] - 2026-07-07
### ✨ Added
- **Tabel Pelacakan Terpadu & Filter Ajuan**: Mengganti tampilan Kanban board pada tab pelacakan progres berkas admin (`#tab-tracking`) menjadi sebuah tabel utama tunggal terpadu yang menampilkan seluruh pengajuan (Pendaftaran Ormas, Rekomendasi Kegiatan, dan Aduan Masyarakat) yang berurutan secara dinamis berdasarkan tanggal masuk. Ditambahkan pula tombol filter tipe ajuan di bagian atas tabel untuk menyaring data secara dinamis (Semua, Ormas, Rekomendasi, Aduan).
- **Modal Detail & Checklist Alur Layanan Terpusat**: Memindahkan kontrol checklist alur progres interaktif (25% s/d 100%), verifikasi berkas persyaratan ormas, dan tombol aksi alur kerja (seperti Verifikasi Berkas, Setujui Rekomendasi, Terbitkan Surat/TTE, Tolak, serta Hapus Permanen) ke dalam modal detail terpusat yang menyesuaikan opsi kontrol berdasarkan tipe ajuan.
- **Sinkronisasi Otomatis**: Menambahkan pendeteksi perubahan progres pada modal detail agar otomatis melakukan reload halaman ketika modal ditutup hanya jika admin telah melakukan pembaruan progres, menjaga agar data tabel utama tetap sinkron.

---

## [v2.9.2] - 2026-07-07
### ✨ Added
- **Tampilan Tabel & Checklist Progres Pelacakan**: Menambahkan toggle tampilan (Kanban vs Tabel & Checklist) pada tab pelacakan progres berkas admin (`#tab-tracking`).
- **Pemeriksaan Dokumen Pengguna Terintegrasi**: Menyediakan tabel dropdown "Lihat Dokumen" pada setiap baris ormas untuk melihat daftar lengkap berkas yang dikirim pengguna beserta tombol untuk membuka langsung berkas PDF, serupa dengan halaman kelengkapan dokumen pengguna.
- **Checklist Alur Progres Real-Time (AJAX)**: Menambahkan form checklist alur progres interaktif (Verifikasi Berkas 25%, Ke Kemendagri 50%, Validasi Bidang 75%, Selesai 100%). Menandai/mengubah status checklist otomatis mengirimkan request AJAX (Fetch API) yang memperbarui kolom `progress_percentage` dan `status_verifikasi` di database serta menyinkronkan data langsung ke halaman pengguna dengan proteksi CSRF.

---

## [v2.9.1] - 2026-07-06
### 🔄 Changed
- **Tampilan Board Kanban Tracking Berkas Rapi**: Merapikan tata letak tombol aksi di kolom Verifikasi Berkas (Column 2) menggunakan grid Bootstrap `row g-2` dan membagi ukuran tombol "Verifikasi" & "Tolak" secara merata (`col-6`) untuk mencegah wrap/tumpang tindih yang merusak fungsionalitas klik.
- **Pembersihan Link Buka Berkas JSON**: Menyembunyikan tombol "Buka Berkas" pada kartu kanban ormas jika tipe file berupa JSON split-upload untuk menghindari broken link 404.

### 🐛 Fixed
- **Keamanan Script getCoordinates**: Mencegah script error yang dapat menghentikan eksekusi JS pada halaman dashboard admin dengan melakukan pengecekan null/undefined dan casting string pada parameter id di fungsi `getCoordinates`.

---

## [v2.9.0] - 2026-07-06
### ✨ Added
- **Konfigurasi Piket & TTE Srikandi**: Menambahkan panel konfigurasi nomor HP petugas piket aktif (WhatsApp) serta nama & NIP pejabat penandatangan TTE Srikandi di Pengaturan Visi, Misi & Portal. Perubahan nomor HP petugas piket langsung memengaruhi tautan WhatsApp secara dinamis pada footer halaman publik.
- **CRUD Bidang & Unit Kerja Dinamis**: Mengubah pengaturan bidang struktural menjadi sistem CRUD lengkap. Admin kini dapat menambahkan bidang baru, mengedit nama/sub-judul/ikon/warna tema bidang, menghapus bidang, serta mengelola seksi/sub-unit kerja secara dinamis.
- **Pembaruan Alur Verifikasi Berkas Ormas**: Menambahkan modal verifikasi kelayakan dokumen pendaftaran bagi Admin. Tombol persetujuan berkas ("Lolos Berkas") dikunci dan hanya aktif setelah Admin mencentang semua daftar persyaratan (14 item untuk Ormas Lokal, 8 item untuk Ormas Berjenjang). Menyetujui kelayakan akan menaikkan progres pengajuan menjadi 50% ("Sedang Diajukan ke Kemendagri").
- **Leaflet Map Picker & Input Dewan Parpol**: Menambahkan Leaflet Map Picker interaktif pada modal Tambah/Edit Partai Politik beserta input data kepengurusan dewan (status kepemilikan kursi, periode dewan, dan level dewan).
- **Pemetaan Role Kabid & Pembersihan SPJ**: Menghapus seluruh menu, rute, controller, dan view yang berhubungan dengan SPJ (kunci SPJ). Mengubah filter rute otorisasi dari `pptk` menjadi `kabid` serta memperbarui 4 akun kepala bidang di database melalui `UserSeeder`.

### 🔄 Changed
- **Pembersihan Form Video/Gallery**: Menghapus input "durasi konten" dan "url link youtube" untuk tipe konten Dokumentasi Kegiatan (Galeri), menyesuaikan validasi backend, serta memodifikasi JavaScript form agar otomatis menyembunyikan input tersebut saat tipe Dokumentasi dipilih.

---

## [v2.8.0] - 2026-06-25
### ✨ Added
- **Pemisahan Halaman Dasbor Eksekutif (Kaban)**: Membagi dasbor eksekutif tunggal menjadi 5 halaman/menu mandiri terpisah dengan visualisasi premium bertema dinamis dan adaptif.
  - **Kinerja Bidang & SPJ (`eksekutif/kinerja`)**: Visualisasi diagram batang Chart.js premium membandingkan persentase realisasi keuangan & fisik, dilengkapi tabel rincian data unit kerja.
  - **Ormas SK Merah (`eksekutif/ormas-merah`)**: Tabel data ormas yang masa berlaku SK-nya kedaluwarsa dengan baris dan badge peringatan visual yang menonjol.
  - **Peta Sebaran GIS (`eksekutif/gis`)**: Peta interaktif Leaflet.js dengan layer toggle filters (Kantor, Ormas, Parpol, Aduan, Rawan) dan panel daftar titik konflik yang memicu fly-to focus.
  - **Kendala & Solusi Bidang (`eksekutif/kendala`)**: Papan informasi komprehensif menyajikan kendala operasional bulanan dan solusi pemecahan yang dilaporkan bidang.
  - **Laporan Pengaduan Masyarakat (`eksekutif/pengaduan`)**: Panel kartu aduan masyarakat anonim terenkripsi beserta file bukti lampiran dokumen.
- **Skrip Otomatisasi Git Commit & Push**: Membuat skrip pembantu [push.sh](file:///f:/Xampp/htdocs/SIPAKATAU/push.sh) (untuk Git Bash/Linux) dan [push.ps1](file:///f:/Xampp/htdocs/SIPAKATAU/push.ps1) (untuk PowerShell Windows) yang mengotomatisasi inisialisasi Git, penambahan remote origin, deteksi nama branch aktif secara dinamis, dan penegakan standar format pesan commit `YYMMDD - [Tipe]: Deskripsi`.

### 🔄 Changed
- **Navigasi Dasbor Eksekutif**: Menyesuaikan menu navigasi sidebar pimpinan pada layout [admin.php](file:///f:/Xampp/htdocs/SIPAKATAU/app/Views/layouts/admin.php) agar mengarah ke rute mandiri masing-masing fitur eksekutif.
- **Tampilan Ringkasan Eksekutif**: Memperbarui view [dashboard_eksekutif.php](file:///f:/Xampp/htdocs/SIPAKATAU/app/Views/eksekutif/dashboard_eksekutif.php) sebagai pusat navigasi visual dengan kartu metrik ringkasan interaktif.

### 🐛 Fixed
- **Teks Tumpang Tindih di Dasbor Eksekutif**: 
  - Memperbaiki overlapping lencana nama bidang yang panjang dan badge periode SPJ pada header kartu [kendala.php](file:///f:/Xampp/htdocs/SIPAKATAU/app/Views/eksekutif/kendala.php) dengan memisahkannya secara vertikal.
  - Menghindari overflow horizontal pada kotak rincian anggaran/fisik kegiatan [kendala.php](file:///f:/Xampp/htdocs/SIPAKATAU/app/Views/eksekutif/kendala.php) dengan beralih dari layout grid Bootstrap row-col ke flexbox alignment yang rapi.
  - Memperbaiki tabrakan teks dan badge 'Status Keamanan' dengan tombol lampiran pada footer kartu aduan [pengaduan.php](file:///f:/Xampp/htdocs/SIPAKATAU/app/Views/eksekutif/pengaduan.php) dengan menyederhanakan data badge dan memangkas label statis yang berlebih.
- **Tombol Sunting Video & Dokumentasi Admin**: Memperbaiki fungsi tombol sunting video di halaman [settings_video.php](file:///f:/Xampp/htdocs/SIPAKATAU/app/Views/admin/settings_video.php) yang sebelumnya tidak berfungsi karena kesalahan penulisan variabel JavaScript (`editYoutubeInput` seharusnya `editYoutubeId`).

### 🛡️ Security
- **Pengecualian Kredensial Google OAuth**: Menambahkan pola berkas `client_secret_*.json` ke dalam [.gitignore](file:///f:/Xampp/htdocs/SIPAKATAU/.gitignore) untuk mencegah terunggahnya kredensial sensitif Google OAuth ke repositori publik GitHub secara tidak sengaja.

---


## [v2.7.0] - 2026-06-25
### ✨ Added
- **Rute Detail Bidang Mandiri**: Menambahkan rute dinamis baru `/bidang/(:any)` yang memetakan ke controller `Home::bidangDetail($id)` untuk menyajikan detail masing-masing Bidang/Unit Kerja secara mandiri.
- **Halaman Tampilan Detail Bidang Premium**: Membuat view baru [bidang.php](file:///f:/Xampp/htdocs/SIPAKATAU/app/Views/profil/bidang.php) yang menyajikan data Tugas Pokok & Fungsi, sub-unit/seksi kerja, dan profil pejabat/personil bidang terkait secara eksklusif dengan layout grid modern, visual premium bertema dinamis, dan efek hover yang interaktif.
- **Lightbox Foto Pejabat/Staf**: Menambahkan modal lightbox dinamis (`#staffPhotoModal`) khusus untuk memperbesar foto pejabat/staf saat wadah foto diklik, menampilkan foto berukuran penuh beserta detail nama dan jabatan secara interaktif.

### 🔄 Changed
- **Pemisahan Halaman Visi & Misi**: Memperbarui view [profil.php](file:///f:/Xampp/htdocs/SIPAKATAU/app/Views/profil/profil.php) agar khusus menyajikan Visi & Misi instansi secara bersih dan terfokus tanpa bercampur dengan data Bidang-bidang.
- **Navigasi Dropdown Menu Bidang**: Mengubah tautan dropdown menu "Bidang" pada layout utama [main.php](file:///f:/Xampp/htdocs/SIPAKATAU/app/Views/layouts/main.php) agar langsung mengarah ke rute detail bidang mandiri masing-masing (Sekretariat, Wasbang, Poldagri, Ekososbud) menggantikan anchor hash statis.
- **Layout Kartu & Foto Personil Bidang**: Memperbarui tampilan profil pejabat/staf di halaman bidang menjadi bentuk kartu vertikal yang lebih besar, dipusatkan (*centered*), dan ditambahkan aksen dekoratif lingkaran putar (*dashed spinning border*) serta transisi pembesaran foto (*avatar scaling*) untuk kesan yang lebih premium, profesional, dan dinamis.
- **Struktur Hirarki Foto Bidang**: Membagi penyajian pejabat/personil bidang menjadi dua tingkatan: Pimpinan (Kabid/Kasubbag) dengan kartu besar bermahkota emas di bagian atas, dan Staf Pelaksana dengan kartu grid yang lebih kompak di bawahnya untuk kemudahan pemahaman struktur organisasi.
- **Kontras Teks Modal Lightbox Staf**: Memperbaiki kontras warna nama dan jabatan pejabat pada footer modal lightbox foto agar dipaksa berwarna terang (`#ffffff` dan `#cbd5e1`) menggunakan prioritas inline `!important`, mencegah teks menjadi gelap dan tidak terbaca di Mode Terang akibat dari penegakan kelas global.

---

## [v2.6.9] - 2026-06-25
### 🔄 Changed
- **Warna & Visual Tombol Geser Foto Lightbox**: Mengubah warna latar belakang tombol navigasi Kiri/Kanan pada slider foto dokumentasi (`dokumentasi.php`) menjadi putih bersih (`#ffffff`) dengan bayangan (*box-shadow*) halus, serta transisi hover yang memperbesar tombol dan mengubah warna ikon chevron menjadi merah mawar (`#e11d48`) agar lebih kontras, premium, dan mudah terlihat oleh pengguna.

---

## [v2.6.8] - 2026-06-24
### ✨ Added
- **Sistem Galeri Foto Berkelompok (Multi-Photo Documentation)**: Menambahkan dukungan unggah banyak foto sekaligus (`image_gallery[]`) untuk item "Dokumentasi Kegiatan" di panel admin (`settings_video.php`). Sistem mengelompokkan 1 gambar utama sebagai Sampul, dan sisa gambar lainnya sebagai Galeri Dokumentasi Tambahan.
- **Slider & Navigasi Lightbox Galeri Interaktif**: Memperbarui modal lightbox (`#imageLightBoxModal`) pada halaman galeri dokumentasi publik (`dokumentasi.php`) dengan slider navigasi gambar (tombol Kiri/Kanan dan Navigasi Thumbnail Strip) serta dukungan tombol keyboard panah Kiri/Kanan untuk pengalaman visual yang sangat responsif, premium, dan interaktif.

### 🔄 Changed
- **UI Sunting Galeri Dinamis Admin**: Menambahkan panel preview thumbnail galeri di dalam modal edit video panel admin. Admin dapat menandai (klik ikon silang) foto mana saja dari galeri saat ini untuk dihapus secara dinamis dari database dan file server.

### 🐛 Fixed
- **Cleanup Berkas Fisik Galeri**: Menyelaraskan controller `Admin.php` (`updateVideo` dan `deleteVideo`) agar secara otomatis menghapus berkas-berkas foto galeri tambahan di server saat admin melakukan penggantian foto, penandaan hapus foto individu, penghapusan item, atau penggantian tipe konten.

---

## [v2.6.7] - 2026-06-24
### ✨ Added
- **Halaman Publik Dokumentasi Kegiatan Tersendiri**: Membuat halaman baru `/informasi/dokumentasi` yang khusus menyajikan dokumentasi kegiatan instansi (baik berupa foto galeri yang dapat diperbesar menggunakan lightbox modal, maupun video dokumentasi).

### 🔄 Changed
- **Filter Galeri Video Edukasi**: Memperbarui halaman `/informasi/video` agar hanya menyaring dan menyajikan konten "Video Edukasi Wawasan Kebangsaan", memisahkannya secara fisik dari galeri foto dokumentasi.
- **Peningkatan Navigasi Header**: Menambahkan opsi menu "Dokumentasi Kegiatan" di bawah dropdown menu "Informasi" pada layout utama (`main.php`) agar pengguna dapat langsung mengakses kedua galeri secara mandiri.

---

## [v2.6.6] - 2026-06-24
### ✨ Added
- **Dukungan Unggah Foto Dokumentasi Kegiatan**: Menambahkan fitur unggah file foto/gambar (`.jpg`, `.jpeg`, `.png`, `.webp`) khusus untuk kategori "Dokumentasi Kegiatan" di menu Pengaturan Video (`settings_video.php`). Sistem secara otomatis mengonversi gambar yang diunggah ke format WebP terkompresi via helper `convert_to_webp()` dan menyimpannya ke direktori `public/uploads/dokumentasi/`.
- **Modal Lightbox Foto Galeri Publik**: Mengintegrasikan modal Lightbox interaktif (`#imageLightBoxModal`) pada halaman galeri video publik (`video.php`). Untuk item "Dokumentasi Kegiatan" berupa foto, sistem menampilkan tombol lihat (ikon mata) yang membuka gambar dalam ukuran penuh secara elegan alih-alih mencoba memutar video YouTube kosong.

### 🔄 Changed
- **Input Dinamis Form Video & Dokumentasi**: Menyesuaikan form tambah/edit video di panel admin (`settings_video.php`) secara dinamis menggunakan JavaScript. Untuk tipe "Video Edukasi", input file disembunyikan dan input YouTube URL wajib diisi. Untuk tipe "Dokumentasi Kegiatan", form menampilkan input File Foto dan YouTube URL secara bersamaan, di mana pengguna wajib mengisi minimal salah satu (bisa unggah foto saja, video YouTube saja, atau keduanya).
- **Grid Rendering View Admin**: Menyesuaikan render visual item dokumentasi di dashboard admin. Jika item memiliki lampiran foto, sistem akan menampilkan tag `<img>` dengan tombol preview/buka gambar, sedangkan jika berupa video tetap merender tag `<iframe>` YouTube embed.

### 🐛 Fixed
- **Manajemen File & Cleanup Berkas Fisik**: Memperbaiki controller `Admin.php` (`tambahVideo`, `updateVideo`, `deleteVideo`) agar dapat menangani penyimpanan path gambar pada field `image_path` di kolom JSON `video_edukasi` tabel `sys_settings`. Proses update dan delete kini mendeteksi serta menghapus berkas fisik lama yang diganti atau dihapus dari server untuk mencegah penumpukan berkas sampah.

---

## [v2.6.5] - 2026-06-24
### 🐛 Fixed
- **Kontras Teks Tab Filter Video & Navigasi Registrasi**: Memperbaiki masalah kontras teks tombol filter video (`settings_video.php`) dan tab registrasi ormas (`info_registrasi.php`) di Mode Terang. Sebelumnya, penggunaan warna inline (`color: var(--text-muted)`) dan kelas `text-white` yang tidak fleksibel memicu tabrakan warna teks di Mode Terang. Masalah ini diselesaikan dengan menghapus deklarasi warna statis pada elemen HTML dan memusatkan manajemen warnanya secara dinamis melalui penambahan rule CSS `.nav-pills` terpusat pada layout utama (`main.php`).

---

## [v2.6.4] - 2026-06-24
### 🐛 Fixed
- **Definisi Warna `text-indigo` Hilang**: Menambahkan definisi CSS eksplisit untuk kelas `.text-indigo`, `.bg-indigo-subtle`, dan `.border-indigo-subtle` yang tidak tersedia secara bawaan di Bootstrap 5. Sebelumnya, teks pada elemen dengan kelas tersebut (Sekretariat & badge sekretaris di Struktur Organisasi) tampil dengan warna fallback yang tidak terdefinisi — mengakibatkan ketidakkonsistenan visual di kedua tema.
- **Badge Kaban & Sekretaris di Mode Terang — Kontras Kritis**: Memperbaiki badge kategori "Kepala Badan" (`bg-danger-subtle text-danger`) dan "Sekretariat" (`bg-indigo-subtle text-indigo`) pada halaman Struktur Organisasi yang tidak terbaca di Mode Terang. Latar belakang subtle yang sangat pucat mengakibatkan teks merah/ungu hampir tidak terlihat. CSS override baru `.org-node .org-badge.bg-*-subtle` memaksa latar belakang menjadi solid berwarna penuh (crimson/indigo/emerald/amber) dengan teks putih saat berada di mode terang.
- **Tombol Outline (`btn-outline-*`) dengan Teks Putih di Mode Terang**: Memperbaiki `btn-outline-primary`, `btn-outline-warning`, dan `btn-outline-info` yang sebelumnya memakai kelas `text-white` dan menjadi tidak terbaca (teks putih di atas latar transparan/putih) saat Mode Terang aktif. Sekarang setiap varian outline menggunakan warna brand yang sesuai (crimson, amber gelap, cyan gelap) beserta hover state yang mengubah latar solid berwarna dengan teks putih.
- **Tombol Tutup Modal (`btn-close`) Tidak Adaptif**: Menambahkan CSS adaptif untuk tombol penutup modal (X) agar terlihat jelas di kedua tema. Di Mode Gelap, `btn-close` (hitam default) kini otomatis di-invert menjadi putih. `.btn-close-white` selalu diinvert, kecuali di dalam modal konten terang di Mode Terang.
- **Scrollbar Gelap Tidak Kontras di Mode Terang**: Memperbaiki warna `scrollbar-thumb` yang menggunakan `#27272a` (abu tua) juga tampil di Mode Terang, menjadi sangat kontras dan mengganggu. Sekarang di Mode Terang, scrollbar thumb menggunakan `#cbd5e1` (abu biru muda) yang terasa natural.
- **Navbar Toggler Tidak Terlihat di Mode Terang**: Menambahkan CSS eksplisit untuk memastikan icon hamburger (toggler) navbar tetap berwarna putih di atas latar navbar merah pada Mode Terang.

### 🔄 Changed
- **Sinkronisasi CSS antara `main.php` dan `admin.php`**: Semua perbaikan di atas diterapkan secara konsisten di kedua layout utama (publik dan admin/dashboard) agar tidak ada inkonsistensi tampilan antar halaman saat berganti tema.

---

## [v2.6.3] - 2026-06-24
### ✨ Added
- **Daftar Persyaratan Dokumen Dinamis pada Dasbor Registrasi User**: Menambahkan tabel checklist berkas persyaratan dokumen resmi pada form registrasi/revisi ormas setelah login (`user/form_pengajuan.php`). Daftar dokumen ini berganti secara dinamis berdasarkan pilihan "Tipe Organisasi" (Ormas Lokal vs Ormas Berjenjang) untuk memudahkan pengguna melengkapi berkas secara akurat dan rapi sesuai regulasi terbaru.
- **Tautan Unduh Format Dokumen Adaptif**: Menyelaraskan tautan unduhan dokumen format pelaporan resmi pada papan pengumuman form pengajuan agar otomatis menyesuaikan dengan tipe organisasi yang dipilih (mengunduh berkas SKT untuk Ormas Lokal, atau berkas Surat Keberadaan untuk Ormas Berjenjang).
- **Progres Pengisian Formulir Real-Time Aktif**: Mengaktifkan penghitung dan indikator visual progres pengisian formulir (0% - 100%) secara interaktif di dasbor pendaftar. Sistem memantau seluruh input wajib (nama, telepon, alamat), koordinat lokasi, masa berlaku SK, dan upload berkas persyaratan (mengakomodasi mode revisi di mana berkas sebelumnya dianggap sah).
- **Kontrol Lapisan Peta GIS (Base Layers Toggle)**: Mengintegrasikan kontrol lapisan peta (*base layers control*) Leaflet.js di seluruh visualisasi peta GIS aplikasi (Dasbor Admin, Dasbor PPTK Bidang, Dasbor Eksekutif Kaban, Form Pengisian Koordinat, dan Picker Lokasi Parpol). Pengguna kini dapat beralih tampilan peta secara bebas antara **Peta Jalan Standar (OpenStreetMap)**, **Foto Citra Satelit Detil (Esri World Imagery)**, dan **Peta Kontur Topografi (OpenTopoMap)**.

## [v2.6.2] - 2026-06-24
### 🐛 Fixed
- **Pelewatan Otomatis IP Privat pada Google Login**: Mengatasi kegagalan integrasi Google OAuth (`Error 400: invalid_request` terkait pembatasan `device_id` / `device_name` pada IP Privat) ketika aplikasi diakses menggunakan alamat IP LAN/Privat (seperti `192.168.x.x`). Jika diakses dari IP Privat selain loopback (`127.0.0.1` / `::1`), sistem sekarang secara otomatis mendeteksi dan mengalihkan pengguna ke **Simulator Google Sign-In** yang aman beserta notifikasi flash message yang informatif.
- **Rute Callback Google OAuth**: Memperbaiki error `404 Can't find a route for 'GET: auth/google/callback'` dengan mendaftarkan rute `GET` untuk `auth/google/callback` di samping rute `POST`. Hal ini memungkinkan penanganan callback asli dari server Google (yang menggunakan `GET`) maupun dari simulator (yang menggunakan `POST`).
- **Kontras Ikon Keluar/Logout di Mode Terang**: Memperbaiki masalah hilangnya/tidak terlihatnya ikon tombol Keluar (Log Out) di sidebar dan tombol cepat di header navigasi saat menggunakan Mode Terang (*Light Mode*). Karena sidebar dan header navigasi di mode terang menggunakan latar belakang merah premium, ikon yang memiliki kelas `.text-danger` (warna merah Bootstrap) sebelumnya tenggelam (merah di atas merah). Sekarang warna ikon tersebut secara otomatis di-override menjadi putih transparan adaptif (`var(--navbar-link)`) dan putih solid saat di-hover.
- **Keterbacaan Lencana Kategori Staf di Mode Terang**: Memperbaiki hilangnya teks pada kategori "Pimpinan" (Kaban) dan "Sekretariat" (Sekretaris) pada tabel Struktur Organisasi di dasbor admin saat menggunakan Mode Terang. Redundansi kelas `.text-white` pada lencana kategori dihapus karena memicu aturan CSS Global Override yang memaksakan teks berwarna gelap di atas warna latar belakang solid/subtle yang tidak sesuai. Selain itu, kelas `.badge-primary-bg` (kategori pimpinan/Kaban) sekarang didefinisikan secara eksplisit dengan latar belakang crimson solid (#e11d48) di mode terang agar teks putih di atasnya terlihat sangat kontras dan jelas dibaca.

### 🔄 Changed
- **Alur Pengisian Berkas Ormas (Wajib Login/Register)**: Menutup akses pengisian form pendaftaran ormas bagi pengguna tamu/anonim (guest) di halaman publik `/layanan/ormas` untuk menghindari fragmentasi data dan penyalahgunaan. Pengguna yang belum login kini secara otomatis dialihkan ke halaman login disertai notifikasi pemberitahuan, sedangkan pengguna yang sudah login dialihkan langsung ke formulir dasbor pribadi mereka di `/user/pengajuan` agar setiap berkas yang dikirim terasosiasi dengan `user_id` secara aman.

---

## [v2.6.1] - 2026-06-23
### ✨ Added
- **Integrasi Statistik Layanan Publik**: Mengintegrasikan data statistik pada halaman beranda utama (publik) dengan database riil. Angka "Ormas Terdaftar" kini mengambil data real dari tabel `mst_ormas` dan "Rekomendasi Terbit" mengambil data dari tabel `trn_rekomendasi` yang memiliki status `Approved`.

### 🔄 Changed
- **Pembersihan Modul TTE & Indikator Kenaikan Statis**: Menghapus kartu informasi "Integrasi TTE (BSrE)" serta indikator kenaikan persentase statis (12% dan 8%) pada panel statistik halaman beranda utama publik untuk menghasilkan visualisasi data yang bersih, real-time, dan profesional.

## [v2.6.0] - 2026-06-23
### ✨ Added
- **Auto-Geocoding Alamat Kantor**: Menambahkan fitur pendeteksi lokasi otomatis (*auto-geocoding*) menggunakan OpenStreetMap (Nominatim API) pada form pendaftaran ormas. Peta interaktif Leaflet.js akan otomatis memindahkan penanda (*marker*) dan fokus ke lokasi koordinat sekretariat ormas begitu pengguna mengetik alamat kantor (disaring otomatis di wilayah Kabupaten Sinjai).
- **Multi-Pengajuan Akun Ormas**: Pengguna (role `user` / `ormas`) kini dapat mengajukan lebih dari satu organisasi kemasyarakatan secara mandiri.
- **Tabel Riwayat Pengajuan Dasbor**: Menambahkan tabel "Riwayat Pengajuan Ormas Anda" pada dasbor pendaftar untuk melacak dan mengelola seluruh pengajuan secara komprehensif.
- **Alur Persetujuan Hapus Ormas (Checker Policy)**: 
  - Jika pengguna atau admin mencoba menghapus Ormas/pendaftaran terdaftar, sistem tidak menghapus langsung melainkan masuk ke status **"Menunggu Persetujuan Hapus"** (`delete_requested = 1`).
  - Menambahkan tab khusus **"Persetujuan Hapus"** di dasbor Admin yang menampilkan antrean permintaan penghapusan berkas, di mana admin verifikator dapat menyetujui (*permanently delete*) atau membatalkan permohonan tersebut.
- **Tombol Deteksi Titik Koordinat & Status Visual**: Menambahkan tombol interaktif "Deteksi Titik Koordinat" beserta indikator status pencarian (loading spinner, sukses, atau peringatan jika tidak ditemukan) di bawah kolom alamat kantor sekretariat.
- **Kolom Permintaan Hapus**: Menambahkan kolom `delete_requested` (TINYINT, default 0) pada tabel `trn_pendaftaran` melalui file migrasi `2026-06-23-094000_AddDeleteRequestedToPendaftaran.php`.

### 🐛 Fixed
- **Proxy Geocoding Server-Side**: Mengalihkan request API Geocoding dari client-side langsung ke proxy server-side (`user/geocode`) menggunakan curl PHP dengan identitas User-Agent yang sah sesuai Kebijakan Penggunaan OpenStreetMap. Hal ini memperbaiki bug di mana kolom Latitude dan Longitude tidak terisi otomatis karena adanya pembatasan CORS dan blokir User-Agent default pada browser di lingkungan localhost.
- **Perbaikan Kontras Warna Mode Terang (Light Theme v2) — Seluruh Halaman**: Menulis ulang total sistem CSS kontras warna di [admin.php](file:///e:/Xampp/htdocs/SIPAKATAU/app/Views/layouts/admin.php) dan [main.php](file:///e:/Xampp/htdocs/SIPAKATAU/app/Views/layouts/main.php) menggunakan pendekatan **dua langkah yang valid**:
  - **Langkah 1 (Global Override)**: Semua kelas `.text-white` dan `.text-white-50` otomatis berubah menjadi warna teks tema gelap (`var(--text-main)` / `var(--text-muted)`) di mode terang. Ini mengatasi isu "teks tenggelam" di seluruh halaman sekaligus.
  - **Langkah 2 (Restore Selektif)**: Setiap komponen dengan latar belakang solid atau gelap (sidebar, header, tombol solid `btn-primary/danger/success/secondary/info/portal`, badge solid, avatar circle, timeline icon) mendapat aturan CSS spesifik yang mengembalikan teks putih secara eksplisit.
  - **Fix Tambahan**: Tombol *outline* (`btn-outline-secondary`, `btn-outline-info`) yang memiliki latar transparan kini menggunakan teks berwarna tema, bukan putih. Badge `bg-secondary-subtle` juga menggunakan warna teks tema di mode terang. Menghapus selector CSS tidak valid (`:not(.sidebar-profile *)`) yang sebelumnya tidak bekerja di browser.

---

## [v2.5.0] - 2026-06-23
### ✨ Added
- **Upload Surat Rekomendasi Resmi**: Menambahkan fitur bagi Admin untuk mengunggah berkas fisik Surat Rekomendasi/Keterangan Terdaftar (PDF/DOC/DOCX/ZIP) pada langkah ke-3 pendaftaran Ormas (melalui modal baru `#modalTerbitkanSuratPendaftaran`).
- **Unduh Surat Rekomendasi Mandiri**: Menambahkan tombol download surat rekomendasi resmi bagi pendaftar di Dasbor Pendaftar (`/user`) dan halaman pelacakan publik (`/layanan/lacak`) jika status verifikasi telah 100% disetujui.
- **Transisi Istilah dari TTE ke Surat Rekomendasi**: Menyelaraskan teks timeline dan penamaan proses dari "Penerbitan TTE" menjadi "Penerbitan Surat Rekomendasi" pada dasbor admin (Kolom 4 Kanban) dan dasbor user (Step 3 timeline).
- **Kolom Kredensial Surat Rekomendasi**: Menambahkan kolom `pdf_tte_path` pada tabel database `trn_pendaftaran` melalui migrasi database `2026-06-23-093000_AddPdfTtePathToPendaftaran.php`.

---

## [v2.4.1] - 2026-06-23
### 🔄 Changed
- **Base URL Dinamis untuk Lokal**: Mengubah perilaku `App.php` agar dapat mendeteksi host/IP pengakses secara otomatis (`HTTP_HOST`) ketika berada di lingkungan `development`. Memungkinkan pengaksesan situs secara fleksibel dari perangkat lain via IP Wi-Fi/LAN tanpa perlu mengubah isi `.env` setiap kali berganti jaringan Wi-Fi.

---

## [v2.4.0] - 2026-06-23
### ✨ Added
- **Sistem Registrasi Mandiri Publik**: Menambahkan halaman `/register` bagi masyarakat umum untuk membuat akun mandiri dengan validasi nama pengguna, alamat email unik, enkripsi password BCRYPT, dan auto-redirect setelah berhasil mendaftar.
- **Peningkatan Kontras Tautan Registrasi & Login**: Memperbaiki kontras teks "Belum punya akun?" / "Sudah punya akun?" menggunakan warna dinamis `var(--text-main)` dan link `text-info` dengan efek garis bawah agar terlihat menonjol dan mudah dibaca baik pada mode gelap maupun mode terang.
- **Fitur Otentikasi Google Terintegrasi**: Mengaktifkan rute `/auth/google` beserta penanganan callback dan simulator Google. Jika sistem berjalan lokal tanpa konfigurasi API Google di file `.env`, secara otomatis diarahkan ke halaman **Simulator Google Sign-In** (`google_simulation.php`) untuk memilih/mengisi email Google kustom secara aman dan instan.
- **Transisi Otomatis Peran (Role Upgrade)**: Akun pendaftar (default role `user`) otomatis ditingkatkan menjadi role `ormas` saat pertama kali mengirimkan formulir pendaftaran ormas agar dapat mengakses area internal secara real-time dan aman tanpa perlu menyalin token publik.
- **Dasbor Progres Layanan Mandiri**: Pembuatan Dasbor Pendaftar (`/user`) yang menyajikan visual timeline progres verifikasi (Verifikasi Berkas 45% -> Validasi Bidang 75% -> Penerbitan TTE 100%), lencana peringatan berwarna merah jika ditolak, serta detail alasan penolakan.
- **Integrasi Logo Resmi Bakesbangpol**: Mengunggah, memotong latar belakang hitam menjadi transparan melingkar (`logo_kesbangpol.png`), dan menerapkannya sebagai elemen branding utama pada halaman Login, Register, navbar utama publik, serta sidebar dasbor internal panel.
- **Formulir Pengajuan & Revisi Terpadu**: Halaman formulir pengisian mandiri (`/user/pengajuan`) yang mendukung pengisian awal maupun perbaikan data lama (revisi berkas yang ditolak) dengan template draft, logo baru, dan peta interaktif **Coordinate Picker Leaflet.js** untuk penentuan titik sekretariat secara presisi.
- **Modal Masukan Alasan Penolakan Admin**: Menambahkan modal input pada tombol "Tolak" berkas pendaftaran di Dashboard Admin verifikator agar alasan penolakan yang spesifik dapat dimasukkan dan disimpan ke database (`alasan_ditolak` pada tabel `trn_pendaftaran`).
- **Sidebar Navigasi User / Ormas**: Integrasi link menu dasbor internal dan formulir pengajuan bagi pengguna peran `user`/`ormas` di dalam menu navigasi layout internal panel (`layouts/admin.php`).

### 🔄 Changed
- **Pembersihan Draf & Reset Progres**: Mengirimkan ulang revisi berkas ormas yang ditolak otomatis me-reset persentase progres ke 45%, mengubah status verifikasi kembali ke `Pending`, mengosongkan teks alasan ditolak sebelumnya, serta mengunggah/mengganti berkas fisik lama yang kurang di server.

---

## [v2.3.0] - 2026-06-22
### ✨ Added
- **Fitur CRUD Manajemen Ormas Terpadu**: Admin kini dapat menambahkan ormas baru via `#modalTambahOrmas`, melakukan pembaruan data secara lengkap via `#modalEditOrmas`, dan menghapus data ormas secara langsung.
- **Auto-WebP untuk Logo Ormas**: Pengunggahan logo ormas baru secara otomatis dikonversi ke format WebP di sisi server demi optimalisasi penyimpanan.
- **Fitur Hapus Seluruh Pengaduan**: Ditambahkan opsi untuk menghapus seluruh rekaman aduan masyarakat beserta file lampiran buktinya secara permanen dari server.
- **Fitur Hapus File Lampiran Pengaduan**: Ditambahkan opsi untuk menghapus file lampiran bukti pengaduan saja guna menghemat ruang penyimpanan server tanpa menghapus teks laporan pengaduan itu sendiri.

### 🔄 Changed
- **Pembersihan Berkas Terkait**: Aksi menghapus ormas akan mendeteksi dan secara otomatis menghapus catatan pendaftaran publik (`trn_pendaftaran`) serta berkas fisik pendaftaran di server untuk mencegah data sampah.

---

## [v2.2.0] - 2026-06-22
### ✨ Added
- **Tombol Login Google Terintegrasi**: Ditambahkan tombol masuk menggunakan akun Google dengan desain visual premium (glassmorphism), logo SVG Google yang orisinal, serta efek hover interaktif. Ditempatkan paling atas sebelum form pengisian username & password.
- **Fitur Hide/Show Password (Toggle Mata)**: Ditambahkan ikon mata interaktif (`fa-solid fa-eye`) di ujung kanan kolom input password, memungkinkan pengguna untuk menyembunyikan atau melihat teks sandi secara real-time dengan transisi yang halus.

---

## [v2.1.2] - 2026-06-22
### 🐛 Fixed
- **Perbaikan tombol Hapus Foto dan visualisasi gambar staf**:
  - Menghapus pengecekan `file_exists()` yang mengandalkan path absolut server (`ROOTPATH . 'public/uploads/struktur/'`) pada view admin dan view profil. Hal ini mencegah tombol Hapus Foto tersembunyi dan avatar staf pecah/hilang ketika dideploy di server hosting/production yang mem-bypass folder `public`.
  - Mengubah ikon tombol Hapus Foto dari `fa-image-slash` (yang tidak valid di FontAwesome Free) menjadi `fa-trash` (ikon tempat sampah) sehingga ikon muncul dengan benar.
  - Mengubah warna tombol Hapus Foto di `settings_struktur.php` dari `btn-outline-warning` menjadi `btn-warning text-dark` solid, memberikan tingkat kontras visual yang tinggi dan keterbacaan yang jelas pada mode gelap maupun mode terang.

---

## [v2.1.1] - 2026-06-22
### 🐛 Fixed
- **Perbaikan kontras warna menyeluruh** pada 5 halaman Pengaturan Portal di mode terang (light mode):
  - `settings_visi_misi.php`: Teks item misi, label form, judul modal, dan tombol modal diubah dari `text-white` ke `var(--text-main)`.
  - `settings_bidang.php`: Judul kartu bidang, badge ID Slot, deskripsi tugas, badge sub-unit, dan modal header diubah theme-aware.
  - `settings_struktur.php`: Teks nama staf, jabatan, NIP, dan semua label form di modal Tambah/Edit Staf diubah dari `text-white` ke `var(--text-main)`.
  - `settings_video.php`: Nav-link filter tab, judul video, teks sumber video, dan semua label form modal diubah theme-aware.
  - `settings_spj.php`: Alert informasi (sebelumnya `text-white` di dalam `.alert-info` bergaya biru), judul card, dan label form diperbaiki agar tidak bertabrakan di light mode.

### 🔄 Changed
- **CSS Global** (`layouts/admin.php`): Ditambahkan CSS rule baru:
  - `.nav-pills .nav-link` — adaptif untuk filter tab dengan warna aktif merah/merah muda di dark mode.
  - `.btn-close` — menggunakan `filter: var(--btn-close-filter)` sehingga tombol X modal tampak benar di kedua tema tanpa `btn-close-white` hardcoded.
  - Variabel `--btn-close-filter` ditambahkan ke dark theme (invert putih) dan light theme (none).

---

## [v2.1.0] - 2026-06-22
### ✨ Added
- Pemisahan menu "Pengaturan Portal" menjadi 5 halaman tersendiri dengan antarmuka dasbor premium:
  - **Visi & Misi** (`admin/settings/visi-misi`): Pengelolaan visi instansi dan CRUD butir misi dinamis.
  - **Bidang & Unit** (`admin/settings/bidang`): Manajemen deskripsi tugas bidang utama dan daftar sub-unit/seksi yang dinamis.
  - **Struktur Organisasi** (`admin/settings/struktur`): Manajemen daftar staf instansi, dilengkapi integrasi **Cropper.js** via CDN untuk *cropping*, *zooming*, dan *drag position* foto rasio 1:1 sebelum unggah.
  - **Video & Dokumentasi** (`admin/settings/video`): CRUD konten video dinamis dengan pemisahan tipe "Video Edukasi" dan "Dokumentasi Kegiatan" beserta filter kategori dinamis.
  - **Kunci SPJ** (`admin/settings/spj`): Penguncian periode SPJ bulanan untuk PPTK.
- Penambahan helper penyimpanan base64 photo decode dan auto-konversi WebP terkompresi di sisi server.
- Dropdown navigasi collapsible untuk menu Konfigurasi di sidebar admin layouts.

### 🔄 Changed
- Pembersihan file dasbor admin (`admin/dashboard.php`) dengan menghapus Tab 5 pane lama dan modal tambah staf, mengurangi kompleksitas file dashboard utama.
- Pengalihan seluruh redirect pasca-aksi (seperti penambahan staf, penghapusan foto, pembaruan video, dll.) dari dasbor utama (`admin#tab-portal`) menuju ke halaman pengaturannya masing-masing.

## [v2.0.0] - 2026-06-22
### ✨ Added
- Pembuatan layout dasbor admin terdedikasi (`layouts/admin.php`) dengan sidebar menu yang responsif, adaptif (mode gelap/terang), dan memiliki UI premium, terpisah sepenuhnya dari portal utama.
- Navigasi sidebar dinamis yang menyesuaikan peran pengguna login (Administrator, PPTK Bidang, dan Kepala Badan/Pimpinan).
- Integrasi navigasi sidebar admin dengan tab Bootstrap (`adminTabs`) menggunakan JavaScript SPA untuk sinkronisasi perpindahan halaman secara instan tanpa reload halaman.
- Integrasi navigasi sidebar bidang dan eksekutif dengan scroll anchor animasi halus ke section yang dituju (Input Laporan, Riwayat SPJ, Peta Wilayah, Kinerja Bidang, dll.).

### 🔄 Changed
- Migrasi view dasbor admin (`admin/dashboard.php`), dasbor bidang (`bidang/dashboard_bidang.php`), dan dasbor eksekutif (`eksekutif/dashboard_eksekutif.php`) untuk menggunakan layout dasbor khusus (`layouts/admin`) menggantikan layout publik (`layouts/main`).
- Pembersihan header dasbor lama, tombol logout redundant, dan penanganan alert ganda pada masing-masing view dasbor karena sudah ditangani secara terpusat oleh layout dasbor yang baru.
- Penyesuaian kontras warna dan style pada layout dasbor agar ikon, label, teks tombol (terutama tombol warning, secondary, dan close button), dan popup peta GIS Leaflet secara dinamis beradaptasi dengan mode gelap/terang tanpa mengalami tabrakan warna.
- Peningkatan visual kotak pencarian tabel Ormas dengan menyatukan border icon search dan input secara mulus.

## [v1.9.4] - 2026-06-22
### ✨ Added
- Penambahan tombol detail (ikon info) di setiap kartu Kanban admin dengan modal detail pengajuan (`#modalDetailTracking`) yang menampilkan data lengkap pengajuan, termasuk masa SK kepengurusan ormas dan waktu pelaksanaan rekomendasi kegiatan.

### 🔄 Changed
- Peningkatan visual nomor registrasi publik pada halaman pelacakan status berkas (`lacak.php`) menjadi badge berlatar belakang amber transparan (`.badge-reg-number`) yang elegan dan berpenampilan premium, menjamin kontras keterbacaan yang tinggi dan tidak menyatu dengan background baik di mode terang maupun mode gelap.

### 🐛 Fixed
- Perbaikan text-white pada modal detail admin agar menggunakan text-main sehingga teks detail pengajuan dapat terbaca dengan jelas saat mode terang aktif (tidak putih di atas putih), serta membenarkan pemetaan field alamat rekomendasi kegiatan pada modal detail.

## [v1.9.3] - 2026-06-22
### ✨ Added
- Peningkatan keterbacaan nomor registrasi di halaman status pelacakan publik `/layanan/lacak` dengan mengubah warna teks menjadi amber/kuning bergradasi glow (`text-warning` dengan efek bayangan teks) agar terlihat sangat kontras dan tidak menyatu dengan background.
- Penambahan tombol **Detail** interaktif (ikon info warna biru langit) pada setiap kartu pelacakan berkas di Kanban Board admin.
- Integrasi modal detail pelacakan (`#modalDetailTracking`) di Dasbor Admin, menampilkan informasi lengkap terkait berkas ormas maupun rekomendasi kegiatan secara real-time melalui Javascript populator dinamis tanpa memuat ulang halaman.

## [v1.9.2] - 2026-06-22
### ✨ Added
- Implementasi fitur hapus pengajuan/berkas yang ditolak (`Rejected`) pada halaman pelacakan publik `/layanan/lacak`. Halaman ini kini memiliki tombol konfirmasi interaktif untuk membersihkan berkas yang ditolak dari database dan penyimpanan server.
- Penambahan tombol hapus berkas pendaftaran Ormas (`deletePendaftaran`) dan rekomendasi kegiatan (`deleteRekomendasi`) pada Kanban Board Tab Tracking Berkas di Dasbor Admin (kolom 1 DRAFT / DITOLAK), memungkinkan pembersihan draf dan penolakan langsung dari sistem admin.
- Integrasi penghapusan file fisik berkas proposal (`public/uploads/rekomendasi/`), berkas ormas (`public/uploads/ormas/`), serta berkas PDF TTE hasil tanda tangan elektronik yang bersangkutan saat record dihapus.

## [v1.9.1] - 2026-06-22
### ✨ Added
- Implementasi CRUD lengkap (Tambah, Edit, dan Hapus) untuk data Partai Politik (Parpol) pada panel administrator (`dashboard.php`, `Admin.php`).
- Pembuatan CMS **Coordinate Picker** interaktif Leaflet.js khusus untuk Partai Politik pada modal `#modalEditLokasiParpol` di panel admin, memungkinkan administrator menentukan titik koordinat sekretariat Parpol secara presisi dengan mengeklik peta atau menyeret (drag) penanda lokasi.
- Integrasi berkas Lambang/Logo (format gambar) dan dokumen SK Kepengurusan Kemenkumham (format ZIP/PDF) pada form tambah/edit Parpol di admin, lengkap dengan konversi format gambar logo ke WebP secara otomatis.
- Visualisasi logo Parpol riil di dalam tabel database Partai Politik admin.

### 🔄 Changed
- Sinkronisasi peta GIS utama pada Dasbor Admin (`dashboard.php`), Dasbor Bidang (`dashboard_bidang.php`), dan Dasbor Eksekutif (`dashboard_eksekutif.php`) agar merender penanda Parpol menggunakan koordinat riil yang tersimpan di basis data (`latitude` & `longitude`), dengan fallback algoritma hash acak jika koordinat bernilai kosong.

## [v1.9.0] - 2026-06-22
### ✨ Added
- Implementasi tautan interaktif WhatsApp Kesbangpol Sinjai pada halaman Rekomendasi Kegiatan (`form_rekomendasi.php`) dan Bapak Endang Saryono pada halaman Registrasi Ormas (`form_ormas.php`), dilengkapi prefilled message untuk memudahkan pemohon berkonsultasi mengenai pengisian formulir.
- Integrasi tautan interaktif WhatsApp pada halaman Lacak Status Berkas (`lacak.php`) ketika pengajuan ditolak (`Rejected`), otomatis mendeteksi tipe pengajuan dan menyematkan nomor registrasi ke dalam pesan konfirmasi WhatsApp.
- Pembuatan styling transisi `.wa-link` di seluruh view form dan lacak berkas agar memberikan efek hover bergaris bawah (*underline transition*) yang halus dan premium.
- Integrasi tautan WhatsApp pada bagian Kontak Hubungi Halaman Beranda (`home/index.php`) agar mempermudah akses langsung ke layanan pengaduan dan bantuan.
- Penambahan fungsi global penanganan tanda wajib isi (`*`) pada label formulir di layouts utama (`layouts/main.php`), yang secara otomatis mewarnai setiap simbol bintang dengan warna merah tebal (`text-danger fw-bold`) untuk kemudahan navigasi pengisian data.

## [v1.8.9] - 2026-06-18
### ✨ Added
- Pembuatan modul demonstrasi interaktif penuh **[sipakatau_sandbox.html](file:///e:/Xampp/htdocs/SIPAKATAU/public/sipakatau_sandbox.html)** (Single Page Application) di folder publik. Modul ini menyatukan dan mensimulasikan seluruh halaman (Beranda, Profil, Maklumat, Form Pendaftaran, Lacak Berkas) dan dasbor internal (Admin, PPTK Bidang, Eksekutif Kaban) secara dinamis tanpa server backend.
- Integrasi peta GIS Leaflet dengan penanda sebaran (Ormas, Konflik, Parpol) dan diagram batang Chart.js secara lokal.
- Simulasi alur transaksi riil (Pendaftaran Antrean MPP menghasilkan Tiket Digital ber-QR Code, sinkronisasi pemanggilan antrean di Dasbor Admin, serta penegakan sanksi penguncian SPJ PPTK).
- Replikasi Surat Rekomendasi Resmi ber-QR Code TTE BSrE yang dapat dicetak secara langsung.

## [v1.8.8] - 2026-06-18
### ✨ Added
- Peningkatan visual **Aplikasi SIPAKATAU** dengan menambahkan keyframe animasi `@keyframes fadeInUp`, `@keyframes focusPulse`, `@keyframes widgetFloat` secara global pada [layouts/main.php](file:///e:/Xampp/htdocs/SIPAKATAU/app/Views/layouts/main.php).
- Implementasi transisi transparan halus pada perubahan tema gelap/terang secara global (`--transition-smooth`).
- Desain hover mewah berpendar (*advanced glow*) pada kartu-kartu visual (`.glass-card`).
- Penambahan efek pendaran cahaya mawar (*pulsing focus glow*) di sekeliling input formulir ketika aktif.
- Implementasi animasi masuk bertahap (*staggered animation*) pada metrik dasbor eksekutif untuk meningkatkan antarmuka interaktif bagi Kaban.
- Pembuatan file demonstrasi mandiri **[demo_visual.html](file:///e:/Xampp/htdocs/SIPAKATAU/public/demo_visual.html)** di folder publik untuk menguji seluruh komponen visual premium, transisi tema, kontras tinggi breadcrumbs, text cuaca, serta pendaran solid badges secara langsung di browser tanpa perlu server PHP aktif.

### 🐛 Fixed
- Perbaikan kontras tombol Toggle Tema dan tombol Log Out pada navbar ketika Light Mode aktif agar tidak bertabrakan dengan background navbar yang berwarna merah cerah.
- Peningkatan kontras teks deskripsi cuaca ("Cerah Berawan") pada floating accessibility widget dengan menaikkan ketebalan font (`font-weight: 600`) dan menyetel warna abu-abu gelap pekat (`#475569`) di Light Mode, serta membuang kelas `text-white` yang bersifat hardcode agar warna teks adaptif secara penuh.
- Peningkatan kontras warna shape badge bidang/unit kerja (seperti badge "Sekretariat" dsb) di Light Mode. Warna badge diubah menjadi solid (ungu, merah, hijau, oranye) dengan teks putih bersih, menggantikan warna transparan Bootstrap `-subtle` bawaan yang pucat dan tenggelam di atas latar belakang putih.
- Penyembunyian elemen badge secara otomatis jika data teks badge bidang bernilai kosong/NULL untuk mencegah render shape lonjong kosong yang mengganggu visual.
- Perbaikan kontras warna ikon rumah (Beranda) dan tautan breadcrumbs di Light Mode agar tidak tenggelam dengan warna putih samar di atas latar belakang putih. Tautan kini dipaksa berwarna merah mawar pekat (`#be123c`) dengan ketebalan font `600` yang sangat kontras dan mudah dibaca.


## [v1.8.7] - 2026-06-18
### ✨ Added
- Implementasi **Indikator Progres Pengisian Formulir Dinamis (Opsi E)** pada halaman Pendaftaran Ormas, Rekomendasi Kegiatan, dan Pendaftaran Parpol. Bar progres interaktif ini memberikan umpan balik persentase penyelesaian pengisian secara real-time.
- Integrasi kode JavaScript pemantau event input formulir yang diselaraskan dengan pemulihan draf pengisian dari penyimpanan lokal browser (`localStorage`).
- Integrasi library **Chart.js** via CDN resmi pada **Executive Dashboard (Opsi F)** untuk visualisasi data pencapaian kinerja dinas.
- Pembuatan grafik batang kelompok (**Grouped Bar Chart**) premium dan responsif bertema gelap untuk menyajikan visual perbandingan realisasi keuangan (%) dan realisasi fisik (%) per bidang (Sekretariat, Wasbang, Poldagri, Ekososbud) secara dinamis.

## [v1.8.6] - 2026-06-18
### ✨ Added
- Implementasi **Sistem Penguncian SPJ Bulanan (Opsi A)** yang mencegah Bidang/PPTK mengirim laporan baru atau mengubah laporan yang sudah ada pada periode bulan yang dikunci oleh Administrator.
- Pembuatan method `updateKunciSpj()` pada controller `Admin.php` untuk mengunci/membuka kunci periode SPJ menggunakan skema penyimpanan JSON array pada tabel `sys_settings` (`locked_spj_months`).
- Penambahan kartu kontrol interaktif **"Penguncian Periode SPJ Bulanan"** di tab Pengaturan Portal pada Dashboard Admin, menampilkan daftar bulan terkunci saat ini, tombol buka kunci, dan picker bulan baru.
- Integrasi server-side validation di `Bidang::laporKegiatan()` untuk memeriksa status kunci bulan yang dikirim dan mencegah bypass pengiriman laporan pada periode terkunci.
- Penambahan verifikasi client-side real-time pada form PPTK (`dashboard_bidang.php`) menggunakan event listener JavaScript; input bulan yang terkunci otomatis menonaktifkan tombol submit, memunculkan border merah, dan menampilkan lencana peringatan **"BULAN TERKUNCI!"**.
- Desain visual lencana **"Terkunci (SIPD)"** berwarna merah neon di samping baris riwayat kegiatan yang bulan SPJ-nya telah dikunci oleh admin.

## [v1.8.5] - 2026-06-18
### ✨ Added
- Implementasi **Sistem Antrean MPP (Mal Pelayanan Publik) Terintegrasi** secara penuh berbasis database lokal (`trn_antrean` & `AntreanModel.php`).
- Pembuatan formulir pendaftaran antrean MPP publik berbasis AJAX interaktif dengan verifikasi NIK 16 digit dan pilihan layanan yang dituju.
- Desain **Tiket Digital Premium** di Landing Page dengan generator nomor antrean berurutan otomatis (Prefix A: Ormas, B: Rekomendasi, C: Konsultasi), QR Code dinamis, dan tombol cetak langsung berbasis print-iframe.
- Pembuatan tab antarmuka kontrol **"Antrean MPP"** pada Dashboard Admin untuk memantau, memanggil, melayani, dan melompati nomor antrean hari ini.

## [v1.8.4] - 2026-06-18
### ✨ Added
- Pembuatan halaman **Surat Rekomendasi Kegiatan ber-TTE Dinamis** (`/layanan/cetak-rekomendasi/(:any)`) berstandar cetak formal pemerintah (10pt, Times New Roman, border 1px hitam) lengkap dengan Kop Surat resmi Bakesbangpol Sinjai dan TTE badge BSrE BSSN ber-QR Code verifikasi.
- Integrasi tombol cetak langsung pada halaman detail pelacakan berkas publik (`lacak.php`) dan panel pelacakan admin (`dashboard.php`) untuk menggantikan tautan file PDF statis yang sebelumnya menghasilkan error 404.

## [v1.8.3] - 2026-06-17
### ✨ Added
- Implementasi fitur **Live Search Bar** klien pada tabel manajemen Ormas di Dashboard Admin untuk mempermudah pencarian nama, alamat, email, atau nomor telepon secara instan.
- Penambahan kontrol **Quick Filter Pills** terintegrasi (Semua, Aktif, Kedaluwarsa, Yayasan, LSM/Lembaga, dan Himpunan/Perkumpulan) dengan penghitung (*counter*) real-time dinamis guna memudahkan segmentasi organisasi kemasyarakatan.

## [v1.8.2] - 2026-06-17
### ✨ Added
- Integrasi **Leaflet.markercluster** CDN pada Dashboard Admin, Bidang, dan Eksekutif untuk mereduksi kepadatan visual penanda (marker) dengan mengelompokkan 138 data Ormas secara dinamis berdasarkan zoom-level peta.
- Pembuatan antarmuka CMS **Coordinate Picker** interaktif pada Dashboard Admin via Modal Bootstrap (`modalEditLokasi`), memungkinkan administrator menunjuk titik koordinat Ormas secara presisi dengan mengeklik peta atau menyeret (drag) penanda lokasi.
- Penambahan tombol **"Kosongkan Koordinat"** di form picker untuk mengosongkan nilai koordinat dari database dan mengembalikan posisi marker Ormas secara otomatis ke default koordinat hash acak di sekitar Sinjai.

### 🔄 Changed
- Penyesuaian pemetaan data koordinat Ormas di peta utama dasbor untuk memprioritaskan koordinat riil tersimpan hasil input admin, dengan fallback algoritma hashing acak jika koordinat bernilai `NULL`.

## [v1.8.1] - 2026-06-17
### ✨ Added
- Pembuatan dan integrasi database seeder baru `OrmasRiilSeeder.php` yang memuat 138 data organisasi kemasyarakatan (Ormas) & LSM riil Kabupaten Sinjai dari dokumen Excel `DATA ORMAS BERBADAN HUKUM DAN TIDAK BERBADAN HUKUM 2026.xlsx`.
- Integrasi detail kaya pengurus (Ketua, Sekretaris, Bendahara) dan bidang sektor gerak ormas ke dalam kolom alamat secara cerdas agar visualisasi popup marker peta GIS dan tabel database memuat data pengurus lengkap secara real-time tanpa merusak skema database yang ada.

## [v1.8.0] - 2026-06-17
### ✨ Added
- Implementasi penyimpanan draf otomatis (*auto-save draft*) menggunakan `localStorage` pada formulir pendaftaran ormas (`form_ormas.php`), rekomendasi kegiatan (`form_rekomendasi.php`), dan partai politik (`form_parpol.php`) untuk mencegah hilangnya isian data ketika halaman ditutup/di-refresh tidak sengaja.
- Penambahan notifikasi Toast Bootstrap premium yang menggantikan pesan `alert()` bawaan browser ketika ukuran berkas yang diunggah melebihi batas maksimum di halaman pendaftaran ormas, rekomendasi, parpol, dan aduan masyarakat di beranda.
- Penambahan fitur filter interaktif Leaflet Layer Control (`L.control.layers`) di pojok kanan atas peta GIS pada Dashboard Admin, Bidang, dan Eksekutif untuk menyaring sebaran marker berdasarkan tipe: Kantor Kesbangpol, Organisasi Ormas, Partai Politik, Aduan Masyarakat, dan Titik Rawan Konflik.
- Penerapan smooth click-to-zoom (`map.flyTo` level 15) untuk seluruh marker di peta GIS ketika diklik.
- Penyempurnaan alur pencarian berkas di `Home::lacakBerkas()` agar mendukung pelacakan terpadu untuk Pendaftaran Ormas (`trn_pendaftaran`) dan Surat Rekomendasi Kegiatan (`trn_rekomendasi`) menggunakan UUID pengajuan.
- Penambahan tombol unduh mandiri berkas PDF TTE resmi secara langsung bagi publik pada halaman `/layanan/lacak` jika status progres rekomendasi kegiatan telah mencapai 100%.

### 🔄 Changed
- Modifikasi tombol aksi TTE pada panel pelacakan berkas admin agar membuka dokumen PDF secara riil di tab baru (`target="_blank"`) daripada hanya memunculkan visual dialog alert simulasi.
- Penambahan global Toast Container HTML & window.showToast() JS di layout utama (`layouts/main.php`) agar dapat dipanggil dari semua halaman views.

## [v1.7.7] - 2026-06-17
### ✨ Added
- Implementasi fitur "Hapus Foto Profil" untuk masing-masing pegawai pada bagian Struktur Organisasi di Dashboard Admin. Foto kustom yang telah diunggah dapat dihapus dan dibersihkan dari server, lalu dikembalikan ke placeholder/inisial huruf gradasi dinamis.
- Penambahan rute POST baru `/admin/delete-photo-staf` untuk penanganan penghapusan berkas gambar dari penyimpanan server dan pembaruan basis data.

## [v1.7.6] - 2026-06-17
### ✨ Added
- Pembuatan database seeder `StrukturSeeder.php` untuk mem-parsing data asli susunan pegawai Bakesbangpol Sinjai dari file `get_jabatan.json` dan menyimpannya ke database (`sys_settings` - `struktur_organisasi`).
- Pemetaan data pegawai asli ke bagan struktur organisasi publik (`profil/struktur.php`) secara dinamis, menjaga agar kepala bagian (Kaban, Sekretaris, Kasubbag, Kabid) berada di posisi teratas pada kolom masing-masing secara visual.
- Integrasi data pegawai asli ke halaman profil publik (`profil/profil.php`), yang kini menampilkan daftar personel lengkap dengan jabatan dan NIP di bawah masing-masing unit/bidang secara responsif.

### 🐛 Fixed
- Memperbaiki kegagalan klik tombol "Simpan Struktur Organisasi" di Dasbor Admin dengan memindahkan form-delete yang tadinya bersarang (*nested forms*) keluar dari form utama. Hal ini menyelesaikan masalah kepatuhan standar HTML di mana tag form bersarang memblokir event submit form utama pada browser.

## [v1.7.5] - 2026-06-17
### ✨ Added
- Fungsionalitas interaktif *smooth zoom & center* (menggunakan `map.flyTo`) dengan tingkat zoom 15 dan durasi transisi 1.2 detik saat mengklik penanda (marker) Titik Konflik (Hotspot/Kerawanan) di peta GIS pada Dasbor Admin, Bidang, dan Eksekutif.
- Fitur penyorotan interaktif pada panel daftar Titik Aktif di Dasbor Admin, di mana mengeklik lokasi di daftar akan mengarahkan peta ke koordinat tersebut, memicu *flyTo*, dan membuka *popup* informasi secara otomatis.
- Penambahan efek hover bergeser (.hotspot-item:hover) dan transisi visual pada item daftar titik konflik untuk mempercantik antarmuka pengguna dasbor admin.
- Integrasi `event.stopPropagation()` pada tombol penghapusan titik kerawanan agar tindakan penghapusan tidak memicu pemusatan peta secara tidak sengaja.

## [v1.7.4] - 2026-06-17
### ✨ Added
- Aktivasi Peta GIS Interaktif berbasis Leaflet.js (OpenStreetMap) di Dashboard Admin (OPD), Dashboard Bidang (PPTK), dan Dashboard Eksekutif (Kaban) yang berpusat di Kabupaten Sinjai.
- Fitur penambahan Titik Kerawanan/Daerah Konflik Sosial dinamis melalui form CMS GIS di panel Admin yang terintegrasi dengan click map coordinate picker (klik peta untuk terisi otomatis) dan disimpan ke data JSON `sys_settings`.
- Pemetaan visual marker neon berpendar untuk Ormas (Biru), Parpol (Kuning/Emas), Aduan Masyarakat (Merah), dan Titik Kerawanan/Konflik (Merah Pulsing berdenyut).
- Integrasi notifikasi Telegram (`telegram_send_transaction()`) pada pendaftaran Partai Politik baru (`Home::simpanParpol()`) dan pengajuan rekomendasi kegiatan baru (`Home::simpanRekomendasi()`).

### 🐛 Fixed
- Perbaikan kesalahan fatal (*fatal error*) pemanggilan method undefined `CodeIgniter\Database\RawSql::newKey()` di helper `app_helper.php` pada fungsi `log_activity()`. Kini pembuatan ID aktivitas menggunakan generator UUID `sprintf()` standar secara langsung untuk mencegah crash saat perekaman log audit.
- Pemulihan dan restorasi metode `Home::simpanRekomendasi()` pada controller `Home.php` yang sempat hilang, memastikan fitur pengajuan rekomendasi kegiatan publik kembali berjalan normal.

## [v1.7.3] - 2026-06-17
### ✨ Added
- Fitur penambahan anggota staf baru (`tambahStaf()`) di Dashboard Admin melalui modal popup `#modalTambahStaf` dengan opsi foto profil (auto WebP conversion), nama, NIP/keterangan, jabatan, dan kategori penempatan bidang.
- Fungsionalitas penghapusan anggota staf (`deleteStaf()`) untuk slot custom non-inti (seperti staf tambahan) lengkap dengan pembersihan file foto dari penyimpanan lokal secara otomatis.
- Dinamisasi rendering halaman publik Struktur Organisasi (`profil/struktur.php`) yang kini meloop list staf secara dinamis dari database pada masing-masing kolom bidang/sekretariat serta melakukan sorting otomatis agar pimpinan (Kabid) berada di posisi teratas.
- Integrasi notifikasi Telegram (`telegram_send_transaction()`) pada saat aduan masyarakat baru berhasil masuk via `Home::simpanPengaduan()`.
- Pembuatan dokumen panduan teknis pembuatan dan konfigurasi Bot Telegram (`docs_dev/PANDUAN_BOT_TELEGRAM.md`).

## [v1.7.2] - 2026-06-17
### ✨ Added
- Fleksibilitas pengisian video edukasi di Dashboard Admin (`admin/dashboard.php`) dengan mengubah input YouTube Video ID menjadi kolom yang menerima URL/Link YouTube lengkap maupun Video ID mentah.
- Penambahan fungsi parser YouTube URL otomatis pada controller `Admin::updateVideo` untuk mengekstraksi 11-karakter Video ID secara aman sebelum disimpan ke database, menjaga kecocokan cover thumbnail dan iframe player di halaman publik.

## [v1.7.1] - 2026-06-17
### ✨ Added
- Pengintegrasian pemutar video edukasi dinamis pada Halaman Beranda (`home/index.php`) yang memutar video pertama aktif dari database (`sys_settings`) serta menampilkan cover YouTube thumbnail beresolusi tinggi secara otomatis.
- Implementasi fungsionalitas penuh pada modal portal pengaduan masyarakat di Halaman Beranda (`#modalPengaduan`) yang kini disinkronkan ke rute `informasi/pengaduan` dengan dukungan unggah bukti berkas (maksimal 2MB dengan pengecekan sisi klien), pemilihan kategori aduan, serta dropdown "Ditujukan ke Bidang" yang diambil dinamis dari database.
- Rute pemutaran video menggunakan modal `#videoPlayerModal` yang diintegrasikan pada Halaman Beranda.

### 🔄 Changed
- Penyesuaian method `Home::index` untuk mengambil data daftar bidang (`mst_bidang`) dan video pertama dari konfigurasi `video_edukasi` (`sys_settings`) untuk dirender ke halaman depan.

## [v1.7.0] - 2026-06-17
### ✨ Added
- Penanganan upload berkas nyata (ZIP/PDF/Gambar) pada form publik Registrasi Partai Politik (Parpol) di controller `Home::simpanParpol()`.
- Alur konversi otomatis berkas gambar lambang Parpol menjadi WebP menggunakan helper `convert_to_webp()`.
- Integrasi log audit trail pencatatan aktivitas (`DAFTAR_PARPOL_PUBLIK` dan `DAFTAR_REKOMENDASI_PUBLIK`) pada pendaftaran Parpol dan pengajuan Rekomendasi Kegiatan.
- Implementasi fungsionalitas portal pengaduan masyarakat anonim yang aman, memproses berkas bukti aduan (auto WebP jika gambar), serta mencatat log audit trail `DAFTAR_PENGADUAN_ANONIM`.
- Integrasi dropdown "Ditujukan ke Bidang" pada form pengaduan masyarakat beserta perekaman instansi tujuan di log database.
- Tampilan panel khusus "Laporan Pengaduan Masyarakat" pada Dashboard Admin (OPD) dan Dashboard Kaban (Eksekutif) untuk memudahkan pemantauan dan tindak lanjut pengaduan secara real-time.
- Kolom baru "Berkas SK & Lambang" pada tabel Partai Politik di Dashboard Admin untuk memvisualisasikan logo/lambang secara dinamis dan menyediakan tombol unduh berkas SK.

### 🔄 Changed
- Pendelegasian rendering alert notifikasi sukses & error global ke tata letak utama (`layouts/main.php`) untuk efisiensi kode dan keseragaman visual.

### 🐛 Fixed
- Menambahkan validasi ukuran file di sisi klien (JavaScript) pada formulir publik (Ormas, Rekomendasi, Parpol maksimal 10MB; Pengaduan maksimal 2MB) guna mencegah crash `ErrorException: ini_set()` pada server akibat batas PHP `post_max_size` terlampaui.

## [v1.6.0] - 2026-06-15
### ✨ Added
- Pengaturan Video Edukasi (CMS Video) di Dasbor Admin (Tab 5 - Pengaturan Portal) yang memberikan akses penuh bagi admin untuk memperbarui 6 slot video secara *real-time*.
- Migrasi database `2026-06-15-074037_AddVideoSettings.php` untuk menyematkan data awal (seeding) video edukasi ke dalam tabel `sys_settings` secara aman.
- Sistem pencatatan log audit trail aktivitas admin (`UPDATE_PENGATURAN_VIDEO`) untuk merekam perubahan pengaturan video sebelum (*before*) dan sesudah (*after*) diperbarui.
- Rute POST baru `admin/update-video` untuk menangani aksi simpan dari form pengaturan video edukasi.

### 🔄 Changed
- Dinamisasi halaman publik Video Edukasi (`/informasi/video`) untuk mengambil data video terbaru dari database (`sys_settings`), menampilkannya dalam format grid modern, dan mengintegrasikan YouTube modal player premium yang responsif (memutar/menghentikan video secara dinamis saat modal dibuka/ditutup).

## [v1.5.1] - 2026-06-15
### 🐛 Fixed
- Memperbaiki kegagalan akses halaman Profil (`/profil`) dan Struktur Organisasi (`/struktur`) pada lingkungan web server Apache lokal (XAMPP) dengan merestrukturisasi seluruh tautan navigasi internal dan form action di layout utama (`layouts/main.php`) dan halaman beranda (`home/index.php`) menggunakan helper `site_url()` alih-alih `base_url()`. Hal ini menjamin halaman internal tetap dapat diakses dengan menyertakan `index.php` secara otomatis jika modul Apache `mod_rewrite` dinonaktifkan.
- Mengatasi potensi kegagalan simpan data pengaturan portal secara senyap (*silently fail*) pada controller `Admin.php` dengan mengganti metode `update()` menjadi `replace()` untuk tabel database `sys_settings`. Hal ini menjamin data pengaturan (visi, misi, bidang, struktur) akan dibuat/dimasukkan (*inserted*) secara otomatis ke database jika baris datanya belum ada, daripada gagal mengubah baris data yang kosong secara diam-diam.

## [v1.5.0] - 2026-06-15
### ✨ Added
- Pengaturan Portal dinamis (Tab 5) di Dasbor Admin (`admin/dashboard`) yang memberikan kemampuan bagi administrator untuk mengubah konten halaman publik secara *real-time* tanpa mengubah kode program.
- Tabel database baru `sys_settings` beserta data penyemaian awal (seeding) otomatis saat menjalankan migrasi `2026-06-15-151000_CreateSettingsTable.php` untuk visi, misi, deskripsi bidang, dan struktur pengurus.
- Form edit visi dan misi instansi (statis 4 kolom baris input) yang disimpan dalam format JSON terstruktur.
- Form pengeditan deskripsi dan daftar sub-bagian (comma-separated) untuk 4 bidang utama.
- Form pengeditan detail nama, NIP/keterangan, serta unggahan file foto pimpinan/anggota pengurus untuk 13 slot pada bagan struktur organisasi.
- Konversi otomatis unggahan foto profil pengurus ke format gambar WebP menggunakan helper `convert_to_webp()`, disimpan di direktori `public/uploads/struktur/`.
- Pencatatan log audit trail aktivitas administrator (`UPDATE_PENGATURAN_PROFIL` & `UPDATE_PENGATURAN_STRUKTUR`) untuk merekam perubahan data sebelum (*before*) dan sesudah (*after*) pembaruan profil dan struktur organisasi.

### 🔄 Changed
- Dinamisasi halaman publik Profil (`Home::profil`) untuk mengambil data visi, misi, dan detail bidang kerja dari tabel database `sys_settings`.
- Desain ulang dan dinamisasi halaman publik Struktur Organisasi (`Home::struktur`) dengan menampilkan bagan hirarkis premium 13 slot pengurus lengkap dengan foto profil bulat, border menyala menyesuaikan warna kategori, nama, NIP, serta fallback in-line SVG inisial nama bergradasi (*premium color gradient*) yang responsif.
- Penyesuaian kontras warna dan style form portal admin (input, textareas, card, header, dan buttons) menggunakan class `form-control-custom` dan variables CSS agar selaras serta mudah dibaca baik di mode terang (*light mode*) maupun mode gelap (*dark mode*).

## [v1.4.1] - 2026-06-15
### 🔄 Changed
- Penyelarasan istilah dari "Penelitian" menjadi "Rekomendasi Kegiatan" pada seluruh tingkatan aplikasi (rute URL baru `/layanan/rekomendasi`, metode controller `daftarRekomendasi` & `simpanRekomendasi`, serta folder penyimpanan unggahan berkas proposal `uploads/rekomendasi/`).
- Penghapusan berkas view lama `form_penelitian.php` dan penggantian dengan berkas baru `form_rekomendasi.php`.
- Pembaruan audit trail log action dari `PROSES_REKOMENDASI_PENELITIAN` menjadi `PROSES_REKOMENDASI_KEGIATAN`.
- Penyelarasan warna Header (Navbar) dan Footer di mode terang (*light mode*) dari warna putih/abu-abu terang menjadi warna merah crimson/burgundy premium (`#be123c` & `#881337`) agar selaras dengan identitas warna instansi.
- Penyesuaian kontras teks menu, brand logo, tombol Log In, serta tulisan footer agar sangat mudah dibaca (*high-contrast*) di atas latar belakang merah crimson/burgundy yang baru.
- Pembersihan markup HTML footer dengan menghapus inline styles warna bawaan (`color: var(--text-main)`) dan menggunakan CSS-controlled classes (`.footer-title`, `.footer-label`, `.footer-wa-num`, dll.) agar seluruh teks deskripsi, kontak WhatsApp, email, dan ikon sosial media tampil lebih terang, tajam, dan kontras.
- Pembaruan style tombol lingkaran sosial media (`.social-circle-btn`) di footer agar menggunakan warna border dan ikon yang lebih terang (`--footer-muted`) sehingga terlihat tajam dan mudah dibaca.

## [v1.4.0] - 2026-06-15
### ✨ Added
- Kolom `file_berkas` di tabel `mst_ormas` dan `file_proposal` di tabel `trn_rekomendasi` melalui migrasi baru `2026-06-15-141500_AddFileColumns.php`.
- Fitur penanganan unggah berkas nyata pada form publik Registrasi Ormas (`Home::simpanOrmas`) dan Rekomendasi Penelitian (`Home::simpanPenelitian`) lengkap dengan konversi otomatis gambar ke format WebP menggunakan helper `convert_to_webp()`.
- Halaman cetak laporan kinerja eksekutif (`eksekutif/cetak-laporan`) mandiri berukuran font `10pt` dan bergaris pembatas `1px` solid hitam yang terintegrasi dengan kop surat resmi Bakesbangpol Sinjai dan print dialog otomatis (`window.print()`).
- Rute pemrosesan berkas baru untuk admin: `/admin/proses-pendaftaran` dan `/admin/proses-rekomendasi`.

### 🔄 Changed
- Dinamisasi Kanban Board pelacakan berkas di halaman Dasbor Admin (`admin/dashboard`) dengan data riil dari tabel `trn_pendaftaran` dan `trn_rekomendasi`.
- Menambahkan tombol aksi persetujuan cepat ("Validasi", "Tolak", "Terbitkan TTE") langsung pada kartu Kanban pelacakan berkas admin.
- Menambahkan tombol "Cetak Laporan" di Dasbor Pimpinan (Kaban) yang mengarah ke layout cetak fisik resmi.
- Penyelarasan judul halaman, breadcrumbs (`Rekomendasi Kegiatan`), serta judul kartu formulir (`FORM REKOMENDASI KEGIATAN`) agar sinkron dengan nama menu pilihan di dropdown navigasi Layanan.
- Peningkatan navigasi utama pada navbar dengan menambahkan penyorotan menu aktif (*active class state highlight*) pada tombol dropdown utama (Profil, Informasi, dan Layanan) secara dinamis sesuai dengan halaman yang sedang diakses.
- Penyesuaian formulir publik pada halaman **Registrasi Ormas** (`form_ormas.php`) dengan menambahkan selektor tipe organisasi (Lokal vs Berjenjang), daftar dokumen persyaratan dinamis berbasis JavaScript, dan pembaruan tautan langsung unduh template berkas asli dari Google Drive.
- Penyesuaian formulir publik pada halaman **Rekomendasi Kegiatan** (`form_penelitian.php`) dengan menyelaraskan label input, keterangan sasaran, menampilkan daftar 6 berkas persyaratan kegiatan resmi secara mendetail, serta menambahkan papan pengumuman info (*alert-info*) berisi tautan unduh cepat template dokumen rekomendasi asli dan kontak WhatsApp pengaduan kendala.

---

## [v1.3.4] - 2026-06-15
### 🔄 Changed
- Pembaruan halaman Informasi Registrasi Ormas (`layanan/info-registrasi`) dengan tata letak tab baru yang adaptif memisahkan persyaratan dokumen dan alur untuk **Ormas Lokal** (21 persyaratan) dan **Ormas Berjenjang** (8 persyaratan + alur 5 langkah).
- Integrasi tombol unduh langsung (*direct download*) ke seluruh file dokumen template asli (`.docx`) dari folder Google Drive yang diberikan.
- Pembaruan modal unduh format dokumen di beranda agar menunjuk ke tautan berkas resmi Google Drive.

### ✨ Added
- Penyemaian data awal (*database seeding*) berupa 8 Ormas resmi terdaftar di Kabupaten Sinjai dari dokumen Excel `DATA ORMAS BERBADAN HUKUM DAN TIDAK BERBADAN HUKUM 2026.xlsx` ke dalam database `mst_ormas`.

---

## [v1.3.3] - 2026-06-15
### 🔄 Changed
- Penyesuaian urutan dan label menu Layanan pada navbar dropdown sesuai instruksi: 1. Maklumat Pelayanan, 2. Form Registrasi Ormas, 3. Rekomendasi Kegiatan, 4. Informasi Registrasi Ormas, dan 5. Informasi Rekomendasi Kegiatan.
- Penyingkiran pilihan pendaftaran Partai Politik dari dropdown menu Layanan.

### ✨ Added
- Halaman Informasi Rekomendasi Kegiatan (`layanan/info-rekomendasi`) dengan desain premium adaptif berisi langkah alur pengajuan dan persyaratan dokumen rekomendasi penelitian/kemasyarakatan.

---

## [v1.3.2] - 2026-06-15
### 🔄 Changed
- Pembaruan koordinat peta interaktif (Google Maps embed) di footer ke titik presisi `-5.1326246, 120.2500688` (Kantor Kesbang dan Politik Sinjai) sesuai dengan data lokasi terbaru yang akurat.

---

## [v1.3.1] - 2026-06-15
### 🔄 Changed
- Penyesuaian tema warna (merah/crimson, putih, abu-abu gelap) di seluruh portal publik (halaman Beranda, Profil, Struktur Organisasi, formulir pendaftaran, pelacakan berkas) agar selaras dengan foto fisik kantor Bakesbangpol Kabupaten Sinjai.
- Pembaruan alamat kantor menjadi `Jl. Sinjai - Watampone, Biringere, Sinjai, Kabupaten Sinjai, Sulawesi Selatan 92600`.
- Pembaruan sematan peta interaktif (Google Maps embed) di footer dengan titik koordinat presisi `-5.325, 120.05497`.
- Penyelarasan warna layout footer adaptif di light mode (menggunakan abu-abu gelap netral menggantikan warna biru tua, dan crimson menggantikan warna emas pada judul kolom).

### 🐛 Fixed
- Memperbaiki galat `ErrorException: Undefined variable $path` di layout [main.php](file:///e:/Xampp/htdocs/SIPAKATAU/app/Views/layouts/main.php) dengan mendefinisikan fallback ke `uri_string()` secara dinamis.

---

## [v1.3.0] - 2026-06-15
### ✨ Added
- Menu navigasi dropdown interaktif di navbar (Profil, Bidang, Informasi, Layanan).
- Widget terapung aksesibilitas di sisi kanan layar untuk informasi cuaca lokal dan kontrol font-size dinamis (Zoom In, Zoom Out, Reset).
- Halaman profil visi-misi (`profil.php`) dan struktur organisasi hirarkis (`struktur.php`).
- Halaman video edukasi kebangsaan (`video.php`) dan portal pengaduan masyarakat aman (`pengaduan.php`).
- Halaman maklumat pelayanan (`maklumat.php`) dan formulir registrasi dengan dropzone area (Ormas, Penelitian, Parpol).
- Kolom pencarian status berkas di beranda dan halaman pelacakan detail (`lacak.php`) dengan visual progress stepper real-time dari database.
- Seksi Kontak Kami (3 kolom) dan grid Sosial Media (4 kolom) bergaris pembatas hijau di beranda.
- Desain ulang Footer Utama 3 kolom gaya premium dilengkapi peta lokasi kantor dan tautan media sosial.
- Pembedaan kontras warna latar belakang footer (hijau hutan pekat pada dark mode, sage pastel pada light mode) agar terpisah jelas dari navbar, lengkap dengan aksen judul kolom berwarna kuning/emas.
- Seed data baru untuk pelacakan pendaftaran di `UserSeeder.php`.

---

## [v1.2.1] - 2026-06-15
### ✨ Added
- Pengalih tema gelap/terang (*dark/light mode switch*) interaktif dengan penyimpanan status otomatis di penyimpanan lokal (*localStorage*).
- Pencegah kedipan tema (*FOUC prevention*) menggunakan pemuatan script in-line tema di tag `<head>`.
- Restrukturisasi variabel CSS adaptif untuk warna latar, tulisan, input, tabel, lencana, dan notifikasi alert.
- Peningkatan kontras warna (*contrast enhancement*) di seluruh view konten utama untuk keterbacaan yang tinggi.
- Pemisahan tata letak dasbor mandiri secara dinamis dengan menyembunyikan link jangkar landing page, menampilkan menu jalan pintas dasbor aktif sesuai peran, dan menggunakan footer minimalis satu baris.

---

## [v1.2.0] - 2026-06-15
### ✨ Added
- Implementasi pengalihan multi-role pada sistem login (`admin` -> `/admin`, `pptk` -> `/bidang`, `kaban` -> `/eksekutif`).
- Keamanan hak akses melalui `AuthFilter` dengan argumen parameter peran untuk mencegah akses silang URL.
- Modul Dashboard Bidang (PPTK) di [Bidang.php](file:///e:/Xampp/htdocs/SIPAKATAU/app/Controllers/Bidang.php) dan [dashboard_bidang.php](file:///e:/Xampp/htdocs/SIPAKATAU/app/Views/bidang/dashboard_bidang.php) dengan validasi wajib mengisi kendala jika realisasi di bawah target.
- Modul Executive Dashboard (Kaban) di [Eksekutif.php](file:///e:/Xampp/htdocs/SIPAKATAU/app/Controllers/Eksekutif.php) dan [dashboard_eksekutif.php](file:///e:/Xampp/htdocs/SIPAKATAU/app/Views/eksekutif/dashboard_eksekutif.php) untuk melihat akumulasi keuangan/fisik, daftar ormas SK Merah, serta rekapitulasi kendala bidang.
- Pembaruan database migrasi dan seeder untuk relasi `bidang_id` ke pengguna PPTK serta inisialisasi data kinerja awal.

---

## [v1.1.1] - 2026-06-12
### 🔄 Changed
- Refactoring sistem: Menghapus modul Logistik ATK Kantor dari skema database, seeder data master, controller Admin, dan tampilan dashboard agar fokus pada alur utama instansi.

---

## [v1.1.0] - 2026-06-12
### ✨ Added
- Sistem otentikasi login/logout terintegrasi dengan password hash `BCRYPT` via [Auth.php](file:///e:/Xampp/htdocs/SIPAKATAU/app/Controllers/Auth.php) dan halaman masuk [login.php](file:///e:/Xampp/htdocs/SIPAKATAU/app/Views/auth/login.php)
- Filter keamanan `AuthFilter` untuk membatasi akses direktori `/admin/*` via [AuthFilter.php](file:///e:/Xampp/htdocs/SIPAKATAU/app/Filters/AuthFilter.php)
- Seeder pengguna awal (`admin`, `kaban`, `pptk`) dan inisialisasi data dummy Ormas, Parpol, Bidang, serta Logistik via [UserSeeder.php](file:///e:/Xampp/htdocs/SIPAKATAU/app/Database/Seeds/UserSeeder.php)
- Dashboard Admin OPD responsif berdesain glassmorphic yang memuat visualisasi statistik, peta GIS, tracking Kanban, manajemen logistik, dan tabel ormas via [dashboard.php](file:///e:/Xampp/htdocs/SIPAKATAU/app/Views/admin/dashboard.php)
- Fitur *toggle* status Ormas ("Aktif" / "Tidak Aktif") dengan log audit trail otomatis via [Admin.php](file:///e:/Xampp/htdocs/SIPAKATAU/app/Controllers/Admin.php)

---

## [v1.0.0] - 2026-06-12
### ✨ Added
- Inisialisasi awal proyek berbasis CodeIgniter 4 (v4.7.3)
- File konfigurasi lokal [.env](file:///e:/Xampp/htdocs/SIPAKATAU/.env) dengan proteksi CSRF diaktifkan
- Skema database master dan transaksi dengan prefix terstruktur (`sys_`, `mst_`, `trn_`, `log_`) dan UUID primary keys melalui [2026-06-12-112823_CreateInitialTables.php](file:///e:/Xampp/htdocs/SIPAKATAU/app/Database/Migrations/2026-06-12-112823_CreateInitialTables.php)
- Helper utilitas [app_helper.php](file:///e:/Xampp/htdocs/SIPAKATAU/app/Helpers/app_helper.php) dengan fungsi audit trail `log_activity()` dan konversi otomatis gambar ke format WebP `convert_to_webp()`
- Helper notifikasi [telegram_helper.php](file:///e:/Xampp/htdocs/SIPAKATAU/app/Helpers/telegram_helper.php) untuk mengirim logs galat sistem (Error 500) dan transaksi ke bot Telegram
- Layout dasar responsif [main.php](file:///e:/Xampp/htdocs/SIPAKATAU/app/Views/layouts/main.php) dengan desain glassmorphism premium menggunakan Bootstrap 5 dan Google Fonts
- Landing page portal utama [index.php](file:///e:/Xampp/htdocs/SIPAKATAU/app/Views/home/index.php) untuk menu layanan publik (pendaftaran ormas, rekomendasi, antrean MPP, dan pengaduan)
- Integrasi Controller [Home.php](file:///e:/Xampp/htdocs/SIPAKATAU/app/Controllers/Home.php)

### 🐛 Fixed
- Perbaikan kontras teks penjelasan deskripsi hero dan teks informasi statistik agar memiliki keterbacaan yang tinggi pada latar belakang gelap (d