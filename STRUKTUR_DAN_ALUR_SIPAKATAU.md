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
2. **Kelola Ormas & Parpol:** Mengatur database organisasi, daftar kepengurusan otomatis, masa jabatan partai politik, serta menampilkan lokasinya di peta.
3. **Kelola Hotspot Konflik & GIS:** Menandai koordinat titik rawan konflik atau aduan di peta GIS Kabupaten Sinjai.
4. **Kelola Berita & Galeri:** Mengunggah berita (gambar otomatis dikonversi ke format WebP agar hemat memori) serta menghapus gambar sampah yang tidak digunakan lagi secara otomatis.
5. **Pengaturan Portal & Pengguna:** Mengatur akun pengguna (admin, kabid, kaban, pemohon), staf organisasi, nomor WA piket, dan kredensial tanda tangan elektronik (TTE).

### D. Halaman Eksekutif (Untuk Kepala Badan / Kaban)
Halaman khusus dengan tampilan mobile-friendly untuk Kepala Badan Kesbangpol guna memantau kinerja secara cepat:
1. **Ringkasan Kinerja:** Rekapitulasi status seluruh pelayanan (ormas & rekomendasi kegiatan).
2. **Ormas Merah:** Daftar ormas yang masa berlaku SK kepengurusannya sudah kedaluwarsa.
3. **Peta GIS Eksekutif:** Memantau peta kerawanan konflik sosial secara langsung.
4. **Rekap Aduan:** Membaca dan meninjau laporan aduan yang masuk dari masyarakat.

---

## 2. TAHAPAN ALUR KERJA (Bagaimana Cara Kerjanya?)

### A. Alur Pendaftaran Ormas / LSM Baru
Begini proses pengajuan keberadaan ormas baru sampai surat keterangannya terbit:

```
[Mulai] Pengurus Ormas Isi Form & Upload Berkas Syarat
     │
     ▼
Berkas Masuk ke Antrean Admin (Status: Pending)
     │
     ▼
Verifikasi Berkas oleh Petugas & Kepala Bidang (Kabid)
     │
     ├──► [Jika Syarat Salah / Tidak Sah] ──► Ditolak (Status: Rejected)
     │                                       Petugas Tulis Alasan Ditolak
     │                                       Pemohon Perbaiki & Ajukan Ulang
     │
     └──► [Jika Syarat Lengkap & Sah] ──────► Disetujui (Status: Approved)
                                             Sistem Menerbitkan Surat Keberadaan Ormas
                                             Ditandatangani Elektronik (TTE) BSrE-BSSN
                                             │
                                             ▼
                                     [Selesai] Surat Terbit
                                     Pemohon Unduh Surat di Halaman User
                                     Bisa Dilacak Lewat Nomor Registrasi
```

1. **Pemohon Mengisi Form & Mengunggah Syarat:**
   Pemohon melengkapi data ormas dan mengunggah dokumen administrasi (seperti AD/ART, SK Kemenkumham, surat keterangan domisili, susunan pengurus, dll). Progres pengisian form ditampilkan langsung (0% - 100%).
2. **Verifikasi Bidang Poldagri & Ormas:**
   Berkas yang masuk akan diperiksa keabsahannya oleh petugas administrasi dan Kepala Bidang terkait.
3. **Keputusan Verifikasi:**
   * **Jika ditolak:** Petugas menuliskan alasan penolakan. Pemohon bisa menghapus berkas ditolak tersebut dan mengajukan ulang berkas perbaikan yang benar.
   * **Jika disetujui:** Status berubah menjadi disetujui (Approved).
4. **Penerbitan Surat Keberadaan Ormas (TTE):**
   Sistem secara otomatis menghasilkan Surat Keberadaan Ormas resmi PDF dengan Tanda Tangan Elektronik (TTE) BSrE-BSSN berbentuk QR Code.
5. **Selesai:**
   Pemohon mengunduh berkas dari dashboard user mereka tanpa harus mengambil fisik ke kantor Kesbangpol.

---

### B. Alur Pengajuan Surat Rekomendasi Kegiatan
Begini proses pemohon mengajukan rekomendasi izin kegiatan sampai surat rekomendasi terbit:

```
[Mulai] Pemohon Isi Detail Kegiatan & Pin Lokasi Peta GIS
     │
     ▼
Unggah Berkas Proposal & Syarat (Progres 0% - 100%)
     │
     ▼
Pemeriksaan Dokumen oleh Admin Kesbangpol
     │
     ├──► [Jika Proposal / Berkas Salah] ──► Ditolak (Status: Rejected)
     │                                       Petugas Tulis Catatan Perbaikan
     │                                       Pemohon Ajukan Ulang Berkas
     │
     └──► [Jika Semua Berkas Lengkap] ──────► Disetujui (Status: Approved)
                                             Sistem Menerbitkan Surat Rekomendasi Kegiatan
                                             Ditandatangani Elektronik (TTE) BSrE-BSSN
                                             │
                                             ▼
                                     [Selesai] Surat Terbit
                                     Pemohon Unduh Surat PDF Secara Mandiri
                                     Gunakan Surat untuk Izin Keramaian Kepolisian
```

1. **Mengisi Detail Kegiatan & Menentukan Lokasi:**
   Pemohon memasukkan nama lembaga, nama/tema kegiatan, rentang tanggal acara, dan deskripsi kegiatan. Pemohon wajib menandai lokasi tepat pelaksanaan kegiatan di peta GIS Kabupaten Sinjai (dengan klik langsung di peta atau mencari jalan).
2. **Unggah Dokumen Persyaratan:**
   Pemohon mengunggah dokumen wajib seperti Surat Permohonan (ditujukan ke Kepala Badan), Rekomendasi Lurah/Camat lokasi sasaran, Proposal Kegiatan, KTP Ketua, dan SK Pengurus.
3. **Verifikasi Admin:**
   Petugas admin memeriksa kelayakan kegiatan dan kelengkapan proposal yang diunggah.
4. **Keputusan & TTE:**
   * **Jika ditolak:** Pemohon mendapat notifikasi alasan ditolak untuk diperbaiki.
   * **Jika disetujui:** Surat Rekomendasi Kegiatan resmi PDF diterbitkan dengan tanda tangan elektronik (TTE) BSrE-BSSN berupa QR Code.
5. **Cetak Mandiri & Izin Kepolisian:**
   Pemohon mengunduh berkas PDF Surat Rekomendasi secara mandiri dari akun mereka. Surat ini sah digunakan sebagai syarat pengajuan izin keramaian ke Polres/Polsek setempat.

---

### C. Alur Pengaduan Masyarakat
1. Masyarakat umum mengisi formulir pengaduan konflik sosial/keluhan di halaman publik.
2. Laporan masuk ke dashboard admin dan dasbor eksekutif Kepala Badan secara rahasia.
3. Admin menandai koordinat lokasi kejadian konflik di Peta GIS untuk ditindaklanjuti.
4. Laporan diproses oleh petugas lapangan, dan status penanganan diperbarui di sistem.
