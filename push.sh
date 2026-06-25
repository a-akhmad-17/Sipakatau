#!/bin/bash

# 1. Pastikan repo git diinisialisasi
if [ ! -d .git ]; then
    echo "Inisialisasi repositori Git baru..."
    git init
    git remote add origin https://github.com/a-akhmad-17/Sipakatau.git
    echo "Remote origin berhasil ditambahkan: https://github.com/a-akhmad-17/Sipakatau.git"
fi

# 2. Deteksi branch saat ini
CURRENT_BRANCH=$(git rev-parse --abbrev-ref HEAD 2>/dev/null)
if [ -z "$CURRENT_BRANCH" ] || [ "$CURRENT_BRANCH" == "HEAD" ]; then
    CURRENT_BRANCH="main"
    git branch -M main
fi

echo "Deteksi branch aktif: $CURRENT_BRANCH"

# 3. Minta Tipe Commit
echo "Pilih tipe commit:"
echo "1) Added (Fitur baru)"
echo "2) Fixed (Perbaikan bug/layout)"
echo "3) Changed (Perubahan non-bug/refactor)"
echo "4) Security (Patch keamanan)"
read -p "Masukkan pilihan (1-4) atau ketik langsung tipe kustom: " TIPE_INPUT

case $TIPE_INPUT in
    1) TIPE="Added" ;;
    2) TIPE="Fixed" ;;
    3) TIPE="Changed" ;;
    4) TIPE="Security" ;;
    *) TIPE=$TIPE_INPUT ;;
esac

if [ -z "$TIPE" ]; then
    echo "Error: Tipe commit tidak boleh kosong!"
    exit 1
fi

# 4. Minta Deskripsi Commit
read -p "Masukkan deskripsi perubahan: " DESKRIPSI
if [ -z "$DESKRIPSI" ]; then
    echo "Error: Deskripsi commit tidak boleh kosong!"
    exit 1
fi

# 5. Dapatkan Tanggal format YYMMDD
TANGGAL=$(date +%y%m%d)

# 6. Format Commit Message
COMMIT_MSG="$TANGGAL - [$TIPE]: $DESKRIPSI"
echo "Format Commit Message: '$COMMIT_MSG'"

# 7. Proses Git
echo "Menambahkan semua perubahan ke staging..."
git add .

echo "Membuat commit..."
git commit -m "$COMMIT_MSG"

echo "Melakukan push ke remote origin ($CURRENT_BRANCH)..."
git push -u origin $CURRENT_BRANCH

echo "Selesai! Progres push berhasil."
