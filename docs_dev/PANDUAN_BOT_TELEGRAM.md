# 🤖 Panduan Pembuatan & Integrasi Bot Telegram - SIPAKATAU

Dokumen ini berisi panduan langkah-demi-langkah bagi administrator atau pengembang untuk membuat Bot Telegram baru dan mengintegrasikannya dengan sistem notifikasi real-time pada aplikasi **SIPAKATAU**.

---

## 📋 Langkah-Langkah Pembuatan Bot Telegram

### Langkah 1: Membuat Bot Baru Melalui BotFather
1. Buka aplikasi Telegram Anda (di HP maupun laptop).
2. Cari akun resmi **@BotFather** (pastikan memiliki centang biru verifikasi).
3. Mulai obrolan dengan mengirim perintah `/start`.
4. Kirim perintah `/newbot` untuk membuat bot baru.
5. **Nama Bot**: Masukkan nama untuk bot Anda (bebas, contoh: `Notifikasi SIPAKATAU`).
6. **Username Bot**: Masukkan username unik yang harus berakhiran kata `_bot` (contoh: `sipakatau_notif_bot`).
7. Setelah berhasil, **BotFather** akan mengirimkan pesan berisi **HTTP API Token**.
   * Format Token: `1234567890:ABCdefGhIJKlmNoPQRsTUVwxyZ`
   * **PENTING**: Simpan token ini dengan aman dan jangan disebarkan ke publik.

---

### Langkah 2: Mendapatkan Chat ID Telegram

Notifikasi dapat dikirim ke chat pribadi Anda, atau ke grup/channel koordinasi (rekomendasi untuk Admin & Kaban).

#### Opsi A: Mengirim Notifikasi ke Grup/Channel (Direkomendasikan)
1. Buat grup Telegram baru (misalnya dengan nama: `Grup Notifikasi SIPAKATAU`).
2. Tambahkan bot Anda (yang dibuat di Langkah 1) ke dalam grup tersebut.
3. Jadikan bot Anda sebagai **Administrator** grup agar memiliki hak akses mengirim pesan.
4. Undang bot pihak ketiga bernama **@MissRose_bot** ke dalam grup Anda.
5. Kirim perintah `/id` di dalam grup. Rose akan membalas dengan menampilkan ID grup Anda.
   * Contoh ID Grup: `-1002345678901` (selalu berawalan tanda minus `-`).
6. Setelah mendapatkan ID, Anda dapat mengeluarkan Rose (`/kick @MissRose_bot`).

#### Opsi B: Mengirim Notifikasi ke Chat Pribadi
1. Buka obrolan dengan bot Anda sendiri di Telegram, lalu klik tombol **Start** atau kirim `/start`.
2. Cari bot resmi **@userinfobot** di pencarian Telegram.
3. Klik **Start** pada bot tersebut. Bot akan langsung menampilkan ID Telegram pribadi Anda.
   * Contoh ID Pribadi: `987654321` (berupa angka saja tanpa minus).

---

### Langkah 3: Konfigurasi File `.env` di Project
Setelah mendapatkan **Bot Token** dan **Chat ID**, langkah terakhir adalah memasukkannya ke dalam konfigurasi aplikasi:

1. Buka file `.env` di root folder proyek Anda:
   `[ROOT_FOLDER]/.env`
2. Cari bagian `# TELEGRAM BOT NOTIFICATION` (biasanya ada di bagian paling bawah).
3. Isi nilai variabel sesuai data yang Anda dapatkan:
   ```ini
   # TELEGRAM BOT NOTIFICATION
   telegram.botToken = '1234567890:ABCdefGhIJKlmNoPQRsTUVwxyZ'
   telegram.chatId = '-1002345678901'
   ```
4. Simpan file `.env` tersebut.

---

## ⚡ Alur Notifikasi pada Kode Program

Sistem **SIPAKATAU** telah dikonfigurasi untuk mengirim notifikasi dalam kondisi berikut:

1. **Aduan Masyarakat Baru (Anonim)**:
   Setiap kali ada laporan aduan masuk via halaman depan maupun portal pengaduan, sistem memicu pengiriman pesan detail transaksi ke Telegram:
   ```php
   telegram_send_transaction('Aduan Masyarakat Baru (Anonim)', [
       'Judul'     => $judul,
       'Kategori'  => $katText,
       'Tujuan'    => $namaBidang,
       'Detail'    => $deskripsi,
       'Lampiran'  => $berkas
   ]);
   ```
2. **System Error (Fatal Logging)**:
   Jika lingkungan sistem mendeteksi error fatal (`Throwable`), helper akan otomatis mengirim trace error ke Telegram guna mempercepat investigasi bug oleh developer.

---

## 🔍 Cara Pengujian
1. Selesaikan langkah 1 sampai 3 di atas.
2. Buka Halaman Utama **SIPAKATAU**.
3. Buka **Portal Pengaduan Masyarakat** (di halaman depan atau `/informasi/pengaduan`).
4. Isi aduan percobaan dan tekan **Kirim Laporan**.
5. Periksa grup Telegram Anda, notifikasi detail aduan baru akan masuk secara instan!
