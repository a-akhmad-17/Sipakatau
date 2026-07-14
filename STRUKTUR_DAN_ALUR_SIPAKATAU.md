# STRUKTUR DAN ALUR KERJA WEBSITE SIPAKATAU

Buku panduan ini dibuat untuk menjelaskan apa saja isi website **SIPAKATAU** dan bagaimana cara kerjanya dari awal sampai selesai.

---

## 1. ISI WEBSITE (Ada Apa Saja di Web Ini?)

Website kita dibagi menjadi 4 bagian utama berdasarkan siapa yang membukanya:

### A. Halaman Depan (Untuk Masyarakat Umum / Publik)
Ini halaman yang bisa dibuka oleh siapa saja tanpa perlu login. Isinya:
1. **Halaman Utama (Beranda):**
   * **Slider Berita:** Banner berita terbaru di bagian paling atas dengan efek kaca transparan yang modern.
   * **Lacak Berkas:** Kotak cepat untuk mengecek berkas kita sudah sampai mana, tinggal masukkan nomor registrasi saja.
   * **Kontak & Chat WA:** Info alamat kantor, email, dan tombol otomatis untuk langsung chat WhatsApp ke petugas piket jika ada kendala.
2. **Menu Layanan:**
   * **Daftar Ormas Baru:** Formulir pendaftaran untuk organisasi kemasyarakatan (LSM/Yayasan) baru.
   * **Rekomendasi Kegiatan:** Formulir izin untuk mengadakan kegiatan (penelitian atau acara ormas), lengkap dengan peta lokasi kegiatan.
   * **Antrean Online MPP:** Menu untuk mengambil nomor antrean loket pelayanan Kesbangpol di Mal Pelayanan Publik (MPP) secara online.
3. **Pusat Informasi:**
   * **Berita Kesbangpol:** Berita kegiatan kantor yang bisa dicari berdasarkan judul atau kategori.
   * **Peta GIS (Peta Lokasi):** Peta interaktif yang menunjukkan sebaran Ormas, Partai Politik, serta titik hotspot rawan konflik di Kabupaten Sinjai. Bisa difilter berdasarkan tahun.
   * **Aduan Masyarakat:** Formulir bagi publik untuk melaporkan keluhan, aduan, atau potensi gesekan sosial di sekitarnya.
   * **Galeri & Video:** Foto dan video dokumentasi kegiatan Kesbangpol.
   * **Profil:** Sejarah singkat, Visi Misi, Maklumat Pelayanan, dan Struktur Organisasi.

### B. Halaman User (Untuk Pengaju / Pengurus Ormas)
Halaman ini didapat setelah pengguna mendaftar akun dan login. Isinya:
1. **Dashboard User:** Ringkasan status berkas yang pernah diajukan (diterima, ditolak, atau masih diproses).
2. **Form Pengajuan:** Tempat mengisi data dan mengunggah dokumen syarat (seperti KTP, AD/ART, proposal, dll).
3. **Download Surat Resmi:** Jika pengajuan disetujui, tombol download otomatis muncul untuk mengunduh Surat Keberadaan Ormas atau Surat Rekomendasi yang sudah ditandatangani secara elektronik (TTE).

### C. Halaman Admin & Kabid (Untuk Petugas & Kepala Bidang)
Halaman khusus petugas Kesbangpol untuk memproses layanan dan mengelola sistem. Isinya:
1. **Verifikasi Berkas:** Tempat memeriksa dokumen yang masuk. 
   * **Admin** melakukan verifikasi kelengkapan berkas dasar.
   * **Kepala Bidang (Kabid)** memverifikasi dan menyetujui berkas sesuai tugas bidang masing-masing sebelum TTE terbit.
2. **Loket Antrean MPP:** Panel untuk memanggil, menandai selesai, atau melewatkan nomor antrean pemohon yang datang ke loket MPP.
3. **Kelola Ormas & Parpol:** Mengatur database organisasi, daftar kepengurusan otomatis, masa jabatan partai politik, serta menampilkan lokasinya di peta.
4. **Kelola Hotspot Konflik & GIS:** Menandai koordinat titik rawan konflik atau aduan di peta GIS Kabupaten Sinjai.
5. **Kelola Berita & Galeri:** Mengunggah berita (gambar otomatis dikonversi ke format WebP agar hemat memori) serta menghapus gambar sampah yang tidak digunakan lagi secara otomatis.
6. **Pengaturan Portal & Pengguna:** Mengatur akun pengguna (admin, kabid, kaban, pemohon), staf organisasi, nomor WA piket, dan kredensial tanda tangan elektronik (TTE).

### D. Halaman Eksekutif (Untuk Kepala Badan / Kaban)
Halaman khusus dengan tampilan mobile-friendly untuk Kepala Badan Kesbangpol guna memantau kinerja secara cepat:
1. **Ringkasan Kinerja:** Rekapitulasi status seluruh pelayanan (ormas & rekomendasi kegiatan).
2. **Ormas Merah:** Daftar ormas yang masa berlaku SK kepengurusannya sudah kedaluwarsa.
3. **Peta GIS Eksekutif:** Memantau peta kerawanan konflik sosial secara langsung.
4. **Rekap Aduan:** Membaca dan meninjau laporan aduan yang masuk dari masyarakat.

---

## 2. TAHAPAN ALUR KERJA (Bagaimana Cara Kerjanya?)

### A. Alur Pelayanan Berkas (Pendaftaran Ormas / Rekomendasi Kegiatan)
Begini proses perjalanan berkas dari awal dikirim sampai suratnya terbit:

```
[Mulai] Pemohon Isi Form & Upload Berkas
     │
     ▼
Berkas Masuk ke Antrean Admin (Status: Pending)
     │
     ▼
Pemeriksaan Dokumen oleh Bidang Terkait (Kabid)
     │
     ├──► [Jika Tidak Lengkap / Salah] ──► Ditolak (Status: Rejected)
     │                                     Petugas Tulis Alasan Ditolak
     │                                     Pemohon Perbaiki & Ajukan Ulang
     │
     └──► [Jika Lengkap & Benar] ────────► Disetujui (Status: Approved)
                                           Sistem Buat Dokumen PDF Resmi
                                           Dokumen Ditandatangani Elektronik (TTE)
                                           dengan QR Code Verifikasi BSSN
                                           │
                                           ▼
                                   [Selesai] Surat Terbit
                                   Pemohon Download di Halaman User
                                   Publik Bisa Lacak Lewat Nomor Registrasi
```

1. **Pemohon Mengisi Formulir & Unggah Persyaratan:**
   Pemohon mengisi data. Selama mengisi form, sistem menampilkan persentase kelengkapan (0% - 100%) agar pemohon tahu berkas apa saja yang belum terupload.
2. **Pengecekan oleh Bidang Terkait:**
   Berkas masuk ke dashboard verifikasi. Kepala Bidang memeriksa dokumen sesuai bidang tugasnya (misal: Bidang Poldagri & Ormas).
3. **Keputusan Verifikasi (Disetujui / Ditolak):**
   * **Jika ditolak:** Admin menuliskan alasan penolakan. Pemohon bisa melihatnya di dashboard mereka, menghapus pengajuan lama, dan mengirim berkas perbaikan yang benar.
   * **Jika disetujui:** Status berubah menjadi disetujui (Approved).
4. **Penerbitan Surat ber-TTE:**
   Sistem membuat dokumen PDF resmi (Surat Keberadaan / Rekomendasi) lengkap dengan Tanda Tangan Elektronik (TTE) resmi tersertifikasi BSrE-BSSN dalam bentuk QR Code.
5. **Unduh & Lacak:**
   Pemohon mengunduh surat di akun mereka, dan publik bisa melacak progres berkas lewat nomor registrasi berkas di halaman depan.

### B. Alur Antrean Online Loket MPP
1. Pemohon mengambil nomor antrean secara online di halaman depan website SIPAKATAU.
2. Nomor antrean terdaftar di sistem loket Kesbangpol MPP Sinjai.
3. Di loket MPP, petugas memanggil nomor antrean menggunakan sistem suara otomatis dashboard admin.
4. Petugas menandai nomor antrean sebagai **Selesai** setelah melayani pemohon, atau **Dilewatkan** jika pemohon tidak hadir.

### C. Alur Pengaduan Masyarakat
1. Masyarakat umum mengisi formulir pengaduan konflik sosial/keluhan di halaman publik.
2. Laporan masuk ke dashboard admin dan dasbor eksekutif Kepala Badan secara rahasia.
3. Admin menandai koordinat lokasi kejadian konflik di Peta GIS untuk ditindaklanjuti.
4. Laporan diproses oleh petugas lapangan, dan status penanganan diperbarui di sistem.
