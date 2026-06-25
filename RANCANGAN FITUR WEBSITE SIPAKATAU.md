# RANCANGAN FITUR FINAL WEBSITE "SIPAKATAU" : "Sistem pelayanan kesbangpol terpadu dan akurat"

## 1. Portal Pelayanan Publik & Informasi (Front-End Eksternal)

* **Pendaftaran Ormas (Berjenjang & Lokal):** Menyediakan sistem formulir digital untuk mengunggah sekitar 12 dokumen persyaratan. Dilengkapi dengan **Fitur Baru** (menyediakan format dokumen kosong yang bisa di-print pengguna untuk diisi dan di-submit kembali) serta **Fitur Save as Draft** (sistem menyimpan draf secara otomatis dan menampilkan persentase progres pendaftaran sehingga pengguna tidak harus mengisi semua data dalam satu waktu). Terdapat juga integrasi alur dokumen dengan aplikasi pusat "Siola".
* **Rekomendasi Kegiatan:** Formulir pengajuan izin yang membutuhkan 6 hingga 10 dokumen, melibatkan stakeholder terkait seperti Dispora dan Dispenda.
* **Sistem Antrean MPP:** Integrasi pengambilan nomor antrean Mal Pelayanan Publik secara online.
* **Keluaran Dokumen (TTE):** Sistem menghasilkan dokumen rekomendasi berformat PDF yang terintegrasi dengan tanda tangan elektronik.
* **Pusat Informasi Terpadu:** Menyediakan halaman khusus untuk menampilkan video edukasi wawasan kebangsaan, memuat berita, agenda Kesbangpol, dan portal form pengaduan masyarakat.

---

## 2. Database & Manajemen Sistem (Tampilan Admin OPD)

* **Manajemen Data Ormas:** Menyimpan seluruh data ormas aktif (300+ data), lengkap dengan daftar kepengurusannya. Terdapat **Fitur Baru** berupa opsi *toggle* untuk mengatur status ormas menjadi "Aktif" atau "Tidak Aktif". Sistem secara otomatis menampilkan peringatan indikator warna merah jika SK kepengurusan ormas sudah kedaluwarsa.
* **Database Tambahan:** Sistem memuat data Partai Politik (Parpol).
* **Pemetaan Digital (GIS):** Tersedia dasbor peta yang memvisualisasikan titik kegiatan dan lokasi sekretariat ormas, serta memuat data rahasia terkait laporan konflik sosial.
* **Tracking Layanan:** Modul untuk admin memeriksa progres berkas masyarakat dan meneruskannya ke tahap verifikasi selanjutnya.

---

## 3. Pelaporan Kinerja & Keuangan (Tampilan PPTK/Bidang)

* **Aplikasi Monitoring Bidang:** Setiap bidang memiliki dasbor khusus untuk melaporkan kegiatan, target, dan capaian program.
* **Integrasi API:** Menarik data referensi melalui API dari sistem yang sudah ada (seperti e-SAKIP/LAKIP) untuk mengatasi kendala pelaporan fisik dan keuangan.
* **Kunci Data SPJ:** Input keuangan wajib ditarik berdasarkan bulan pelaporan SPJ untuk mencegah selisih data dengan SIPD.
* **Input Kendala Terstruktur:** Sistem mewajibkan pengisian kolom kendala apabila realisasi kegiatan di bawah target yang ditetapkan.
* **Manajemen Persediaan:** Pencatatan logistik internal (sekitar 15 item barang) untuk menertibkan administrasi.

---

## 4. Dashboard Eksekutif (Tampilan Kepala Badan)

* **Ringkasan Terpusat:** Tampilan *mobile-friendly* yang merangkum keseluruhan realisasi anggaran, daftar ormas ber-SK merah, dan rekapitulasi kendala dari setiap bidang.