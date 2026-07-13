# STRUKTUR DAN ALUR KERJA WEBSITE SIPAKATAU

Buku panduan santai ini dibuat untuk menjelaskan apa saja isi website **SIPAKATAU** dan bagaimana cara kerjanya dari awal sampai selesai, pakai bahasa sehari-hari yang gampang dimengerti.

---

## 1. ISI WEBSITE (Ada Apa Saja di Web Ini?)

Website kita dibagi menjadi 3 bagian utama berdasarkan siapa yang membukanya:

### A. Halaman Depan (Untuk Masyarakat Umum / Publik)
Ini halaman yang bisa dibuka oleh siapa saja tanpa perlu login. Isinya:
1. **Halaman Utama (Beranda):**
   * **Slider Berita:** Banner berita terbaru di bagian paling atas dengan efek kaca transparan yang modern.
   * **Lacak Berkas:** Kotak cepat untuk mengecek berkas kita sudah sampai mana, tinggal masukkan nomor registrasi saja.
   * **Kontak & Chat WA:** Info alamat kantor, email, dan tombol otomatis untuk langsung chat WhatsApp ke petugas piket kalau ada kendala.
2. **Menu Layanan:**
   * **Daftar Ormas Baru:** Formulir pendaftaran untuk organisasi kemasyarakatan (LSM/Yayasan) baru.
   * **Rekomendasi Kegiatan:** Formulir izin untuk mengadakan kegiatan (penelitian atau acara ormas), lengkap dengan peta lokasi kegiatan.
3. **Pusat Informasi:**
   * **Berita Kesbangpol:** Berita kegiatan kantor yang bisa dicari berdasarkan judul atau kategori.
   * **Peta GIS (Peta Lokasi):** Peta yang menunjukkan di mana saja lokasi Ormas, Partai Politik, serta titik rawan konflik di Kabupaten Sinjai. Bisa difilter berdasarkan tahun.
   * **Galeri & Video:** Foto dan video dokumentasi kegiatan Kesbangpol.
   * **Profil:** Sejarah singkat, Visi Misi, dan Struktur Organisasi.

### B. Halaman User (Untuk Pengaju / Pengurus Ormas)
Halaman ini didapat setelah pengguna mendaftar akun dan login. Isinya:
1. **Dashboard User:** Ringkasan status berkas yang pernah diajukan (diterima, ditolak, atau masih diproses).
2. **Form Pengajuan:** Tempat mengisi data dan mengunggah dokumen syarat (seperti KTP, AD/ART, proposal, dll).
3. **Download Surat Resmi:** Jika pengajuan disetujui, tombol download otomatis muncul untuk mengunduh Surat Keberadaan Ormas atau Surat Rekomendasi yang sudah ditandatangani secara elektronik (TTE).

### C. Halaman Admin (Untuk Petugas & Kepala Bidang)
Halaman rahasia khusus petugas Kesbangpol untuk mengelola semua data. Isinya:
1. **Verifikasi Berkas:** Tempat memeriksa dokumen yang masuk. Petugas bisa menerima (approve) atau menolak (reject) berkas dengan menuliskan alasannya.
2. **Kelola Ormas & Parpol:** Mengatur database organisasi, pengurus, masa jabatan partai politik, serta menampilkan lokasinya di peta.
3. **Tulis Berita & Galeri:** Mengunggah berita (gambar otomatis dikompres ke format WebP agar web tetap cepat) dan menghapus gambar sampah yang tidak terpakai lagi di server secara otomatis.
4. **Pengaturan Portal:** Mengubah nomor WA petugas piket, visi-misi, bidang, dan nama pejabat yang berhak menandatangani dokumen secara elektronik (TTE).

---

## 2. TAHAPAN ALUR KERJA (Bagaimana Cara Kerjanya?)

Begini proses perjalanan berkas dari awal dikirim sampai suratnya terbit:

```
[Mulai] Pemohon Isi Form & Upload Berkas
     │
     ▼
Berkas Masuk ke Antrean Admin (Status: Pending)
     │
     ▼
Pemeriksaan Dokumen oleh Bidang Terkait
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

### Penjelasan Langkah Demi Langkah:

1. **Pemohon Mengisi Formulir & Unggah Persyaratan:**
   Pemohon masuk ke web, lalu memilih layanan yang diinginkan. Sambil mengisi form dan memilih file, sistem akan menampilkan persentase kelengkapan (0% sampai 100%) agar pemohon tahu apa saja yang kurang sebelum mengirim berkas.
2. **Pengecekan oleh Petugas Kesbangpol:**
   Setelah dikirim, berkas akan masuk ke dashboard admin. Petugas bidang masing-masing akan membuka dan memeriksa apakah dokumen yang diunggah sudah benar dan sesuai.
3. **Keputusan Verifikasi (Disetujui / Ditolak):**
   * **Jika berkas salah / tidak lengkap:** Admin akan klik **Tolak** dan wajib menuliskan alasannya (misal: *"KTP Ketua buram, mohon upload ulang"*). Status pengajuan berubah jadi **Ditolak** (Rejected). Pemohon bisa melihat alasan ini di akun mereka, lalu menghapus berkas yang ditolak dan mengajukan ulang dengan berkas baru yang benar.
   * **Jika berkas sudah lengkap & benar:** Admin akan klik **Setujui** (Approved).
4. **Penerbitan Surat dengan Tanda Tangan Elektronik (TTE):**
   Sistem akan otomatis membuat surat resmi berformat PDF. Surat ini sudah ditandatangani secara elektronik (TTE) resmi yang terverifikasi oleh BSrE - BSSN (Badan Siber dan Sandi Negara) lewat barcode (QR Code).
5. **Pelacakan & Pengambilan Surat:**
   Pemohon bisa memantau proses ini kapan saja melalui menu **Lacak Berkas** dengan memasukkan nomor registrasi. Jika statusnya sudah **Selesai / Terbit**, pemohon tinggal mendownload file PDF surat resmi tersebut dari akun mereka tanpa perlu repot datang ke kantor Kesbangpol.
