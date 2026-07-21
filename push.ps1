# 1. Pastikan repo git diinisialisasi
if (!(Test-Path .git)) {
    Write-Host "Inisialisasi repositori Git baru..." -ForegroundColor Yellow
    git init
    git remote add origin https://github.com/a-akhmad-17/Sipakatau.git
    Write-Host "Remote origin berhasil ditambahkan: https://github.com/a-akhmad-17/Sipakatau.git" -ForegroundColor Green
}

# 2. Deteksi branch saat ini
$currentBranch = git rev-parse --abbrev-ref HEAD 2>$null
if ([string]::IsNullOrEmpty($currentBranch) -or $currentBranch -eq "HEAD") {
    $currentBranch = "main"
    git branch -M main
}

Write-Host "Deteksi branch aktif: $currentBranch" -ForegroundColor Cyan

# 3. Minta Tipe Commit
Write-Host "Pilih tipe commit:" -ForegroundColor White
Write-Host "1) Added (Fitur baru)"
Write-Host "2) Fixed (Perbaikan bug/layout)"
Write-Host "3) Changed (Perubahan non-bug/refactor)"
Write-Host "4) Security (Patch keamanan)"
$tipeInput = Read-Host "Masukkan pilihan (1-4) atau ketik langsung tipe kustom"

switch ($tipeInput) {
    "1" { $tipe = "Added" }
    "2" { $tipe = "Fixed" }
    "3" { $tipe = "Changed" }
    "4" { $tipe = "Security" }
    Default { $tipe = $tipeInput }
}

if ([string]::IsNullOrEmpty($tipe)) {
    Write-Error "Tipe commit tidak boleh kosong!"
    exit 1
}

# 4. Minta Deskripsi Commit
$deskripsi = Read-Host "Masukkan deskripsi perubahan"
if ([string]::IsNullOrEmpty($deskripsi)) {
    Write-Error "Deskripsi commit tidak boleh kosong!"
    exit 1
}

# 5. Dapatkan Tanggal format YYMMDD
$tanggal = (Get-Date).ToString("yyMMdd")

# 6. Format Commit Message
$commitMsg = "$tanggal - [$tipe]: $deskripsi"
Write-Host "Format Commit Message: '$commitMsg'" -ForegroundColor Green

# 7. Proses Git
Write-Host "Menambahkan semua perubahan ke staging..." -ForegroundColor Yellow
git add .

Write-Host "Membuat commit..." -ForegroundColor Yellow
git commit -m "$commitMsg"

Write-Host "Melakukan push ke remote origin ($currentBranch)..." -ForegroundColor Yellow
git push -u origin $currentBranch

Write-Host "Selesai! Progres push berhasil." -ForegroundColor Green
