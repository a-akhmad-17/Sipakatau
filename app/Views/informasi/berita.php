<?= $this->extend('layouts/main') ?>

<?= $this->section('styles') ?>
<style>
    .news-card {
        transition: all 0.4s cubic-bezier(0.4, 0, 0.2, 1);
        border: 1px solid var(--border-color);
        background: var(--card-bg);
        border-radius: 16px;
        overflow: hidden;
    }
    .news-card:hover {
        transform: translateY(-8px);
        border-color: rgba(225, 29, 72, 0.35);
        box-shadow: 0 15px 35px rgba(225, 29, 72, 0.1), 0 0 20px var(--glow-color-1);
    }
    .news-card img {
        transition: transform 0.6s ease;
    }
    .news-card:hover img {
        transform: scale(1.05);
    }
    .news-category-badge {
        background: rgba(225, 29, 72, 0.15) !important;
        color: #e11d48 !important;
        border: 1px solid rgba(225, 29, 72, 0.3) !important;
        padding: 5px 10px;
        border-radius: 6px;
        font-weight: 600;
        font-size: 0.72rem;
    }
    html[data-theme="dark"] .news-category-badge {
        color: #fda4af !important;
    }
    .filter-btn-custom {
        border-radius: 8px;
        font-weight: 500;
        font-size: 0.9rem;
        padding: 8px 16px;
        border: 1px solid var(--border-color);
        background: rgba(127, 127, 127, 0.03);
        color: var(--text-muted);
        transition: var(--transition-fast);
        text-decoration: none;
    }
    .filter-btn-custom:hover {
        background: rgba(127, 127, 127, 0.08);
        color: var(--text-main);
        border-color: var(--text-muted);
    }
    .filter-btn-custom.active {
        background: #e11d48 !important;
        color: #ffffff !important;
        border-color: #e11d48 !important;
    }
    html[data-theme="dark"] .filter-btn-custom.active {
        background: rgba(244, 63, 94, 0.25) !important;
        color: #fda4af !important;
        border-color: rgba(244, 63, 94, 0.3) !important;
    }

    /* Custom Pagination Styling */
    .pagination-container .pagination {
        display: flex;
        justify-content: center;
        gap: 5px;
        padding: 0;
        list-style: none;
    }
    .pagination-container .pagination li a,
    .pagination-container .pagination li span {
        display: flex;
        align-items: center;
        justify-content: center;
        width: 38px;
        height: 38px;
        border-radius: 8px;
        background: var(--card-bg);
        border: 1px solid var(--border-color);
        color: var(--text-muted);
        text-decoration: none;
        font-weight: 600;
        font-size: 0.9rem;
        transition: var(--transition-fast);
    }
    .pagination-container .pagination li a:hover {
        background: rgba(127, 127, 127, 0.08);
        color: var(--text-main);
        border-color: var(--text-muted);
    }
    .pagination-container .pagination li.active a,
    .pagination-container .pagination li.active span {
        background: var(--primary-grad) !important;
        color: white !important;
        border-color: transparent !important;
        box-shadow: 0 4px 10px rgba(225, 29, 72, 0.3);
    }
    .hover-red:hover {
        color: #e11d48 !important;
    }
</style>
<?= $this->endSection() ?>

<?= $this->section('content') ?>
<div class="py-4">
    <!-- Header -->
    <div class="glass-card mb-5 text-center py-5">
        <h1 class="display-5 fw-bold text-white mb-2">Berita Kesbangpol</h1>
        <p class="text-muted mb-0">Ikuti informasi terkini mengenai kegiatan, sosialisasi, dan pengumuman resmi Badan Kesbangpol Kabupaten Sinjai.</p>
    </div>

    <!-- Filters & Search Bar -->
    <div class="card mb-4 border-0" style="background: var(--card-bg); backdrop-filter: blur(20px); border: 1px solid var(--border-color) !important; border-radius: 16px;">
        <div class="card-body p-3">
            <div class="d-flex flex-wrap justify-content-between align-items-center gap-3">
                <!-- Category Tabs -->
                <div class="d-flex flex-wrap gap-2" id="berita-category-tabs">
                    <a href="<?= site_url('informasi/berita') ?>" class="filter-btn-custom <?= empty($kategori) ? 'active' : '' ?>">Semua Berita</a>
                    <a href="<?= site_url('informasi/berita?kategori=Berita+Utama' . (!empty($q) ? '&q=' . urlencode($q) : '')) ?>" class="filter-btn-custom <?= ($kategori === 'Berita Utama') ? 'active' : '' ?>"><i class="fa-solid fa-star me-1"></i> Berita Utama</a>
                    <a href="<?= site_url('informasi/berita?kategori=Pengumuman' . (!empty($q) ? '&q=' . urlencode($q) : '')) ?>" class="filter-btn-custom <?= ($kategori === 'Pengumuman') ? 'active' : '' ?>"><i class="fa-solid fa-bullhorn me-1"></i> Pengumuman</a>
                    <a href="<?= site_url('informasi/berita?kategori=Kegiatan' . (!empty($q) ? '&q=' . urlencode($q) : '')) ?>" class="filter-btn-custom <?= ($kategori === 'Kegiatan') ? 'active' : '' ?>"><i class="fa-solid fa-calendar-check me-1"></i> Kegiatan</a>
                    <a href="<?= site_url('informasi/berita?kategori=Sosialisasi' . (!empty($q) ? '&q=' . urlencode($q) : '')) ?>" class="filter-btn-custom <?= ($kategori === 'Sosialisasi') ? 'active' : '' ?>"><i class="fa-solid fa-users me-1"></i> Sosialisasi</a>
                </div>

                <!-- Search Input Form -->
                <form action="<?= site_url('informasi/berita') ?>" method="GET" class="input-group input-group-sm" style="width: 280px; max-width: 100%;">
                    <?php if (!empty($kategori)): ?>
                        <input type="hidden" name="kategori" value="<?= esc($kategori) ?>">
                    <?php endif; ?>
                    <span class="input-group-text bg-secondary border-secondary text-white-50"><i class="fa-solid fa-magnifying-glass"></i></span>
                    <input type="text" name="q" class="form-control form-control-custom" placeholder="Cari berita..." value="<?= esc($q ?? '') ?>">
                </form>
            </div>
        </div>
    </div>

    <!-- News Grid -->
    <div class="row g-4 mb-5">
        <?php if (!empty($berita)): ?>
            <?php foreach ($berita as $idx => $b): ?>
                <?php
                // Clean HTML tags and strip to a short excerpt
                $excerpt = esc(mb_strimwidth(strip_tags($b['konten']), 0, 110, '...'));
                ?>
                <div class="col-md-6 col-lg-4">
                    <div class="news-card h-100 d-flex flex-column justify-content-between p-3">
                        <div>
                            <!-- Cover Image Frame -->
                            <div class="ratio ratio-16x9 rounded overflow-hidden mb-3 bg-dark">
                                <?php if (!empty($b['gambar'])): ?>
                                    <img src="<?= base_url('uploads/berita/' . $b['gambar']) ?>" alt="<?= esc($b['judul']) ?>" class="w-100 h-100" style="object-fit: cover;">
                                <?php else: ?>
                                    <div class="w-100 h-100 d-flex flex-column align-items-center justify-content-center text-muted" style="background: rgba(255,255,255,0.02);">
                                        <i class="fa-regular fa-image fa-2x mb-2 opacity-50"></i>
                                        <span style="font-size: 0.75rem;">No Cover Image</span>
                                    </div>
                                <?php endif; ?>
                            </div>

                            <!-- Meta Category -->
                            <div class="mb-2">
                                <span class="news-category-badge"><?= esc($b['kategori']) ?></span>
                            </div>

                            <!-- Title -->
                            <h5 class="text-white mb-2" style="font-size: 1.05rem; line-height: 1.4; font-weight: 700; display: -webkit-box; -webkit-line-clamp: 2; -webkit-box-orient: vertical; overflow: hidden; height: 2.8rem;" title="<?= esc($b['judul']) ?>">
                                <a href="<?= site_url('informasi/berita/' . $b['slug']) ?>" class="text-white text-decoration-none hover-red" style="transition: var(--transition-fast);"><?= esc($b['judul']) ?></a>
                            </h5>

                            <!-- Excerpt -->
                            <p class="text-muted small mb-0" style="line-height: 1.6; text-align: justify; display: -webkit-box; -webkit-line-clamp: 3; -webkit-box-orient: vertical; overflow: hidden; height: 4.8rem;">
                                <?= $excerpt ?>
                            </p>
                        </div>

                        <!-- Footer Info -->
                        <div>
                            <hr class="my-3" style="border-color: var(--border-color) !important;">
                            <div class="d-flex justify-content-between align-items-center text-muted small" style="font-size: 0.72rem;">
                                <span><i class="fa-regular fa-calendar me-1"></i><?= date('d M Y', strtotime($b['created_at'])) ?></span>
                                <span class="text-truncate" style="max-width: 140px;" title="Oleh: <?= esc($b['author'] ?? 'Admin') ?>"><i class="fa-regular fa-user me-1 text-primary"></i>Oleh: <?= esc($b['author'] ?? 'Admin') ?></span>
                            </div>
                            <div class="d-flex justify-content-between align-items-center mt-2.5">
                                <span class="text-muted small" style="font-size: 0.72rem;"><i class="fa-regular fa-eye me-1 text-info"></i>Dibaca: <?= $b['view_count'] ?> kali</span>
                                <a href="<?= site_url('informasi/berita/' . $b['slug']) ?>" class="btn btn-sm text-white fw-bold px-3 py-1.5" style="background: rgba(225,29,72,0.12); color: #fda4af !important; border: 1px solid rgba(225,29,72,0.25); border-radius: 6px; font-size: 0.75rem; transition: var(--transition-fast);" onmouseover="this.style.background='#e11d48'; this.style.color='#ffffff';" onmouseout="this.style.background='rgba(225,29,72,0.12)'; this.style.color='#fda4af';">
                                    Baca Detail <i class="fa-solid fa-arrow-right-long ms-1" style="font-size:0.7rem;"></i>
                                </a>
                            </div>
                        </div>
                    </div>
                </div>
            <?php endforeach; ?>
        <?php else: ?>
            <div class="col-12 text-center py-5">
                <div class="glass-card">
                    <i class="fa-solid fa-newspaper fa-3x text-muted mb-3" style="opacity:0.3;"></i>
                    <h5 class="text-white">Tidak Ada Berita Ditemukan</h5>
                    <p class="text-muted mb-0">Belum ada berita yang diterbitkan untuk pencarian/kategori ini.</p>
                </div>
            </div>
        <?php endif; ?>
    </div>

    <!-- Pagination -->
    <?php if (isset($pager) && !empty($berita)): ?>
        <div class="pagination-container d-flex justify-content-center mt-5 mb-3">
            <?= $pager->links('berita', 'default_full') ?>
        </div>
    <?php endif; ?>
</div>
<?= $this->endSection() ?>
