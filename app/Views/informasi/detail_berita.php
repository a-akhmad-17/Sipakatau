<?= $this->extend('layouts/main') ?>

<?= $this->section('styles') ?>
<style>
    .news-detail-container {
        color: var(--text-main);
    }
    .news-meta {
        font-size: 0.85rem;
        color: var(--text-muted);
    }
    .news-body-content {
        line-height: 1.8;
        font-size: 1.05rem;
        text-align: justify;
    }
    .news-body-content p {
        margin-bottom: 1.5rem;
    }
    .news-body-content ul, .news-body-content ol {
        margin-bottom: 1.5rem;
        padding-left: 1.5rem;
    }
    .news-body-content img {
        max-width: 100%;
        height: auto;
        border-radius: 12px;
        margin: 1.5rem 0;
        border: 1px solid var(--border-color);
    }
    .recent-news-item {
        display: flex;
        gap: 12px;
        padding: 12px 0;
        border-bottom: 1px solid var(--border-color);
        transition: var(--transition-fast);
    }
    .recent-news-item:last-child {
        border-bottom: none;
    }
    .recent-news-item:hover {
        transform: translateX(4px);
    }
    .recent-news-thumb {
        width: 80px;
        height: 55px;
        object-fit: cover;
        border-radius: 8px;
        border: 1px solid var(--border-color);
    }
    .recent-news-title {
        font-size: 0.88rem;
        font-weight: 700;
        line-height: 1.4;
        display: -webkit-box;
        -webkit-line-clamp: 2;
        -webkit-box-orient: vertical;
        overflow: hidden;
        margin-bottom: 4px;
    }
    .share-btn {
        width: 38px;
        height: 38px;
        border-radius: 50%;
        display: flex;
        align-items: center;
        justify-content: center;
        border: 1px solid var(--border-color);
        background: rgba(255, 255, 255, 0.02);
        color: var(--text-muted) !important;
        transition: var(--transition-smooth);
    }
    .share-btn:hover {
        transform: scale(1.1) translateY(-2px);
        color: #ffffff !important;
        border-color: transparent !important;
    }
    .share-fb:hover { background: #3b5998; }
    .share-tw:hover { background: #1da1f2; }
    .share-wa:hover { background: #25d366; }
</style>
<?= $this->endSection() ?>

<?= $this->section('content') ?>
<div class="py-4 news-detail-container">
    <!-- Breadcrumbs -->
    <nav aria-label="breadcrumb" class="mb-4">
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="<?= site_url() ?>">Beranda</a></li>
            <li class="breadcrumb-item"><a href="<?= site_url('informasi/berita') ?>">Berita</a></li>
            <li class="breadcrumb-item text-muted active" aria-current="page"><?= esc(mb_strimwidth($berita['judul'], 0, 45, '...')) ?></li>
        </ol>
    </nav>

    <div class="row g-4">
        <!-- Main Article Column -->
        <div class="col-lg-8">
            <article class="glass-card p-4 p-md-5">
                <!-- Category and Title -->
                <div class="mb-3">
                    <span class="badge bg-danger-subtle text-danger border border-danger-subtle px-2.5 py-1.5" style="font-size: 0.75rem; border-radius: 6px;"><?= esc($berita['kategori']) ?></span>
                </div>
                <h1 class="display-6 fw-bold text-white mb-3" style="line-height: 1.3; font-family: 'Outfit', sans-serif;"><?= esc($berita['judul']) ?></h1>

                <!-- Meta Information -->
                <div class="news-meta d-flex flex-wrap gap-3 pb-3 mb-4 border-bottom" style="border-color: var(--border-color) !important;">
                    <span><i class="fa-regular fa-calendar-days me-1.5 text-primary"></i><?= date('d F Y H:i', strtotime($berita['created_at'])) ?></span>
                    <span><i class="fa-regular fa-user me-1.5 text-success"></i>Oleh: <?= esc($berita['author'] ?? 'Admin') ?></span>
                    <span><i class="fa-regular fa-eye me-1.5 text-info"></i>Dibaca: <?= $berita['view_count'] ?> kali</span>
                </div>

                <!-- Featured Image -->
                <?php if (!empty($berita['gambar'])): ?>
                    <div class="rounded overflow-hidden mb-4 border" style="border-color: var(--border-color) !important;">
                        <img src="<?= base_url('uploads/berita/' . $berita['gambar']) ?>" alt="<?= esc($berita['judul']) ?>" class="w-100" style="max-height: 450px; object-fit: cover;">
                    </div>
                <?php endif; ?>

                <!-- Article Body Content -->
                <div class="news-body-content text-justify">
                    <?= $berita['konten'] ?>
                </div>

                <!-- Share Buttons Section -->
                <div class="mt-5 pt-4 border-top d-flex align-items-center justify-content-between flex-wrap gap-3" style="border-color: var(--border-color) !important;">
                    <div class="d-flex align-items-center gap-2">
                        <span class="small fw-semibold text-muted">Bagikan berita ini:</span>
                        <?php
                        $shareUrl = urlencode(current_url());
                        $shareText = urlencode($berita['judul']);
                        ?>
                        <a href="https://www.facebook.com/sharer/sharer.php?u=<?= $shareUrl ?>" target="_blank" class="share-btn share-fb" title="Bagikan ke Facebook"><i class="fa-brands fa-facebook-f"></i></a>
                        <a href="https://twitter.com/intent/tweet?url=<?= $shareUrl ?>&text=<?= $shareText ?>" target="_blank" class="share-btn share-tw" title="Bagikan ke Twitter / X"><i class="fa-brands fa-x-twitter"></i></a>
                        <a href="https://api.whatsapp.com/send?text=<?= $shareText ?>%20<?= $shareUrl ?>" target="_blank" class="share-btn share-wa" title="Bagikan ke WhatsApp"><i class="fa-brands fa-whatsapp"></i></a>
                    </div>
                    <a href="<?= site_url('informasi/berita') ?>" class="btn btn-outline-secondary btn-sm"><i class="fa-solid fa-arrow-left-long me-1"></i> Kembali ke Berita</a>
                </div>
            </article>
        </div>

        <!-- Sidebar Column -->
        <div class="col-lg-4">
            <!-- Recent News Card -->
            <div class="glass-card p-4 mb-4">
                <h5 class="font-heading mb-3 border-bottom pb-2" style="color: var(--text-main); font-size: 1.15rem; border-color: var(--border-color) !important;"><i class="fa-solid fa-fire text-danger me-2"></i>Berita Terbaru</h5>
                <?php if (empty($recentBerita)): ?>
                    <p class="small text-muted mb-0">Tidak ada berita terbaru lainnya.</p>
                <?php else: ?>
                    <div class="d-flex flex-column gap-2">
                        <?php foreach ($recentBerita as $rb): ?>
                            <a href="<?= site_url('informasi/berita/' . $rb['slug']) ?>" class="recent-news-item text-decoration-none">
                                <?php if (!empty($rb['gambar'])): ?>
                                    <img src="<?= base_url('uploads/berita/' . $rb['gambar']) ?>" alt="Thumb" class="recent-news-thumb flex-shrink-0">
                                <?php else: ?>
                                    <div class="recent-news-thumb flex-shrink-0 bg-dark text-muted d-flex align-items-center justify-content-center" style="font-size: 0.65rem;">
                                        No Image
                                    </div>
                                <?php endif; ?>
                                <div class="min-w-0">
                                    <div class="recent-news-title text-white hover-red" style="transition: var(--transition-fast);" title="<?= esc($rb['judul']) ?>"><?= esc($rb['judul']) ?></div>
                                    <span class="small text-muted" style="font-size: 0.72rem;"><i class="fa-regular fa-calendar me-1"></i><?= date('d M Y', strtotime($rb['created_at'])) ?></span>
                                </div>
                            </a>
                        <?php endforeach; ?>
                    </div>
                <?php endif; ?>
            </div>

            <!-- Hubungi Piket Card -->
            <div class="glass-card p-4">
                <h5 class="font-heading mb-3" style="color: var(--text-main); font-size: 1.15rem;"><i class="fa-solid fa-headset text-warning me-2"></i>Layanan Piket</h5>
                <p class="small text-muted mb-3">Ada kendala, keluhan, atau butuh informasi lebih lanjut mengenai layanan Kesbangpol? Silakan hubungi petugas piket kami via WhatsApp.</p>
                <?php
                // Fetch piket phone from sys_settings
                $db = \Config\Database::connect();
                $piketRow = $db->table('sys_settings')->where('key', 'piket_phone')->get()->getRowArray();
                $phone = $piketRow ? $piketRow['value'] : '0811-7671-545';
                $waLink = 'https://wa.me/' . str_replace(['-', ' ', '+'], '', $phone);
                ?>
                <a href="<?= $waLink ?>" target="_blank" class="btn btn-portal w-100 fw-semibold text-center" style="background: linear-gradient(135deg, #22c55e, #16a34a); box-shadow: 0 4px 15px rgba(34, 197, 94, 0.25);">
                    <i class="fa-brands fa-whatsapp me-2"></i> WhatsApp Piket
                </a>
            </div>
        </div>
    </div>
</div>
<?= $this->endSection() ?>
