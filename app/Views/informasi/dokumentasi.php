<?= $this->extend('layouts/main') ?>

<?= $this->section('styles') ?>
<style>
    .video-card {
        transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
        border: 1px solid var(--border-color);
        background: var(--card-bg);
    }
    .video-card:hover {
        transform: translateY(-5px);
        border-color: rgba(225, 29, 72, 0.3);
        box-shadow: 0 10px 30px rgba(0, 0, 0, 0.15);
    }
    .glass-card-modal {
        background: var(--bg-color) !important;
        border: 1px solid var(--border-color) !important;
        color: var(--text-main) !important;
        border-radius: 16px;
    }
    .lightbox-nav-btn {
        width: 44px;
        height: 44px;
        background: #ffffff !important;
        border: none !important;
        box-shadow: 0 4px 15px rgba(0, 0, 0, 0.3);
        transition: all 0.2s ease;
        color: #0f172a !important;
        z-index: 10;
        opacity: 0.9;
    }
    .lightbox-nav-btn:hover {
        background: #ffffff !important;
        transform: scale(1.1);
        color: #e11d48 !important;
        opacity: 1;
    }
</style>
<?= $this->endSection() ?>

<?= $this->section('content') ?>

<div class="py-4">
    <!-- Header -->
    <div class="glass-card mb-5 text-center py-5">
        <h1 class="display-5 fw-bold text-white mb-2">Dokumentasi Kegiatan</h1>
        <p class="text-muted mb-0">Galeri foto dan video pelaksanaan agenda kerja serta program Badan Kesatuan Bangsa dan Politik Kabupaten Sinjai.</p>
    </div>
    
    <!-- Grid Dokumentasi -->
    <div class="row g-4 mb-5">
        <?php if (!empty($videos)): ?>
            <?php foreach ($videos as $v): ?>
                <?php
                $badgeClass = 'bg-primary-subtle text-primary border-primary-subtle';
                if (stripos($v['category'], 'bela') !== false) {
                    $badgeClass = 'bg-success-subtle text-success border-success-subtle';
                } elseif (stripos($v['category'], 'rukun') !== false || stripos($v['category'], 'harmoni') !== false) {
                    $badgeClass = 'bg-warning-subtle text-warning border-warning-subtle';
                }
                
                $hasImage = !empty($v['image_path']);
                $bgUrl = $hasImage ? base_url('uploads/dokumentasi/' . esc($v['image_path'])) : 'https://img.youtube.com/vi/' . esc($v['youtube_id']) . '/hqdefault.jpg';
                ?>
                <!-- Dokumentasi Item -->
                <div class="col-md-6 col-lg-4">
                    <div class="glass-card h-100 p-2 d-flex flex-column justify-content-between video-card">
                        <div>
                            <div class="ratio ratio-16x9 rounded overflow-hidden position-relative mb-3 bg-dark" 
                                 style="cursor: pointer; background: url('<?= $bgUrl ?>') no-repeat center; background-size: cover;"
                                 data-bs-toggle="modal" 
                                 data-bs-target="<?= $hasImage ? '#imageLightBoxModal' : '#videoPlayerModal' ?>" 
                                 <?= $hasImage ? 'data-image-path="' . esc($v['image_path']) . '"' : 'data-video-id="' . esc($v['youtube_id']) . '"' ?>
                                 data-image-gallery='<?= !empty($v['image_gallery']) ? json_encode($v['image_gallery']) : '[]' ?>'
                                 data-video-title="<?= esc($v['title']) ?>">
                                <div class="position-absolute w-100 h-100 d-flex align-items-center justify-content-center" style="background: rgba(0,0,0,0.3); transition: background 0.3s;" onmouseover="this.style.background='rgba(0,0,0,0.1)'" onmouseout="this.style.background='rgba(0,0,0,0.3)'">
                                    <div class="rounded-circle bg-white text-dark d-flex align-items-center justify-content-center shadow-lg" style="width: 55px; height: 55px; transition: transform 0.2s;" onmouseover="this.style.transform='scale(1.1)'" onmouseout="this.style.transform='scale(1.0)'">
                                        <?php if ($hasImage): ?>
                                            <i class="fa-solid fa-eye fa-lg text-danger"></i>
                                        <?php else: ?>
                                            <i class="fa-solid fa-play fa-lg ms-1 text-danger"></i>
                                        <?php endif; ?>
                                    </div>
                                </div>
                            </div>
                            <div class="px-2">
                                <span class="badge <?= $badgeClass ?> border mb-2"><?= esc($v['category']) ?></span>
                                <h5 class="text-white mb-2" style="font-size: 1.1rem; line-height: 1.4; font-weight: 700;"><?= esc($v['title']) ?></h5>
                                <p class="text-muted small mb-0" style="line-height: 1.6;"><?= esc($v['description']) ?></p>
                            </div>
                        </div>
                        <div class="px-2 pt-3 border-top mt-3 text-secondary small d-flex justify-content-between align-items-center">
                            <span>
                                <?php if ($hasImage): ?>
                                    <?php 
                                    $galleryCount = !empty($v['image_gallery']) && is_array($v['image_gallery']) ? count($v['image_gallery']) : 0;
                                    if ($galleryCount > 0):
                                    ?>
                                        <i class="fa-regular fa-images me-1 text-info"></i> Galeri Foto (1+<?= $galleryCount ?>)
                                    <?php else: ?>
                                        <i class="fa-regular fa-image me-1"></i> Foto Dokumentasi
                                    <?php endif; ?>
                                <?php else: ?>
                                    <i class="fa-regular fa-clock me-1"></i> Durasi: <?= esc($v['duration']) ?>
                                <?php endif; ?>
                            </span>
                            <span class="text-muted text-truncate" style="max-width: 140px;" title="<?= esc($v['source']) ?>"><i class="fa-solid fa-circle-info me-1"></i> <?= esc($v['source']) ?></span>
                        </div>
                    </div>
                </div>
            <?php endforeach; ?>
        <?php else: ?>
            <div class="col-12 text-center py-5">
                <div class="glass-card">
                    <i class="fa-solid fa-images fa-3x text-muted mb-3"></i>
                    <h5 class="text-white">Belum Ada Dokumentasi Kegiatan</h5>
                    <p class="text-muted mb-0">Daftar foto dan video dokumentasi kegiatan saat ini sedang kosong.</p>
                </div>
            </div>
        <?php endif; ?>
    </div>
</div>

<!-- Video Player Modal -->
<div class="modal fade" id="videoPlayerModal" tabindex="-1" aria-labelledby="videoPlayerModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-lg">
        <div class="modal-content glass-card-modal">
            <div class="modal-header border-secondary border-opacity-25" style="border-bottom: 1px solid var(--border-color) !important; padding: 15px 20px;">
                <h5 class="modal-title font-heading text-white fw-bold" id="videoPlayerModalLabel"><i class="fa-solid fa-circle-play text-danger me-2"></i>Putar Video Dokumentasi</h5>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body p-0">
                <div class="ratio ratio-16x9">
                    <iframe id="videoIframe" src="" title="YouTube video player" frameborder="0" allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture; web-share" allowfullscreen></iframe>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Image LightBox Modal -->
<div class="modal fade" id="imageLightBoxModal" tabindex="-1" aria-labelledby="imageLightBoxModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-lg">
        <div class="modal-content glass-card-modal" style="background: var(--bg-color) !important; border: 1px solid var(--border-color) !important; color: var(--text-main) !important;">
            <div class="modal-header border-secondary border-opacity-25" style="border-bottom: 1px solid var(--border-color) !important; padding: 15px 20px;">
                <h5 class="modal-title font-heading text-white fw-bold" id="imageLightBoxModalLabel"><i class="fa-solid fa-camera text-danger me-2"></i>Dokumentasi Kegiatan</h5>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body p-0 text-center bg-black overflow-hidden d-flex flex-column align-items-center justify-content-center" style="max-height: 85vh;">
                <!-- Main Image Container -->
                <div class="position-relative w-100 d-flex align-items-center justify-content-center" style="height: 60vh; background: #000;">
                    <img id="lightboxImage" src="" alt="Dokumentasi Kegiatan" style="max-width: 100%; max-height: 100%; object-fit: contain;">
                    
                    <!-- Navigation Buttons (hidden if only 1 image) -->
                    <button class="btn btn-light rounded-circle position-absolute start-0 ms-3 d-none d-flex align-items-center justify-content-center lightbox-nav-btn" id="lightboxPrevBtn">
                        <i class="fa-solid fa-chevron-left"></i>
                    </button>
                    <button class="btn btn-light rounded-circle position-absolute end-0 me-3 d-none d-flex align-items-center justify-content-center lightbox-nav-btn" id="lightboxNextBtn">
                        <i class="fa-solid fa-chevron-right"></i>
                    </button>
                </div>
                
                <!-- Thumbnails Bar (hidden if only 1 image) -->
                <div class="w-100 p-3" id="lightboxThumbnailsContainer" style="background: rgba(0,0,0,0.9); border-top: 1px solid var(--border-color); display: none;">
                    <div class="d-flex justify-content-center align-items-center gap-2 overflow-x-auto py-1" id="lightboxThumbnailsList" style="scrollbar-width: thin;">
                        <!-- Thumbnails populated by JS -->
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<?= $this->endSection() ?>

<?= $this->section('scripts') ?>
<script>
document.addEventListener('DOMContentLoaded', function () {
    const videoPlayerModal = document.getElementById('videoPlayerModal');
    if (videoPlayerModal) {
        const videoIframe = document.getElementById('videoIframe');
        const modalTitle = document.getElementById('videoPlayerModalLabel');

        videoPlayerModal.addEventListener('show.bs.modal', function (event) {
            const button = event.relatedTarget;
            const videoId = button.getAttribute('data-video-id');
            const videoTitle = button.getAttribute('data-video-title');

            modalTitle.innerHTML = `<i class="fa-solid fa-circle-play text-danger me-2"></i>${videoTitle}`;
            videoIframe.src = `https://www.youtube.com/embed/${videoId}?autoplay=1`;
        });

        videoPlayerModal.addEventListener('hide.bs.modal', function () {
            videoIframe.src = '';
        });
    }

    const imageLightBoxModal = document.getElementById('imageLightBoxModal');
    if (imageLightBoxModal) {
        const lightboxImage = document.getElementById('lightboxImage');
        const imageModalTitle = document.getElementById('imageLightBoxModalLabel');
        const prevBtn = document.getElementById('lightboxPrevBtn');
        const nextBtn = document.getElementById('lightboxNextBtn');
        const thumbsContainer = document.getElementById('lightboxThumbnailsContainer');
        const thumbsList = document.getElementById('lightboxThumbnailsList');
        
        let allImages = [];
        let currentIdx = 0;
        
        const updateLightboxState = () => {
            if (allImages.length === 0) return;
            
            // Set image source
            lightboxImage.src = `<?= base_url('uploads/dokumentasi') ?>/` + allImages[currentIdx];
            
            // Show/hide navigation arrows
            if (allImages.length > 1) {
                prevBtn.classList.remove('d-none');
                nextBtn.classList.remove('d-none');
                thumbsContainer.style.display = 'block';
                
                // Highlight active thumbnail
                const thumbs = thumbsList.querySelectorAll('.lightbox-thumb');
                thumbs.forEach((t, idx) => {
                    if (idx === currentIdx) {
                        t.style.border = '2px solid #e11d48';
                        t.style.opacity = '1';
                        t.scrollIntoView({ behavior: 'smooth', block: 'nearest', inline: 'center' });
                    } else {
                        t.style.border = '1px solid #475569';
                        t.style.opacity = '0.5';
                    }
                });
            } else {
                prevBtn.classList.add('d-none');
                nextBtn.classList.add('d-none');
                thumbsContainer.style.display = 'none';
            }
        };

        imageLightBoxModal.addEventListener('show.bs.modal', function (event) {
            const button = event.relatedTarget;
            const coverImage = button.getAttribute('data-image-path');
            const title = button.getAttribute('data-video-title');
            const galleryStr = button.getAttribute('data-image-gallery') || '[]';
            
            imageModalTitle.innerHTML = `<i class="fa-solid fa-camera text-danger me-2"></i>${title}`;
            
            let gallery = [];
            try {
                gallery = JSON.parse(galleryStr);
            } catch(e) {
                gallery = [];
            }
            
            // Combine cover image and gallery images
            allImages = [];
            if (coverImage) allImages.push(coverImage);
            if (Array.isArray(gallery)) {
                gallery.forEach(img => {
                    if (img && img !== coverImage) {
                        allImages.push(img);
                    }
                });
            }
            
            currentIdx = 0;
            
            // Populate thumbnails
            thumbsList.innerHTML = '';
            if (allImages.length > 1) {
                allImages.forEach((img, idx) => {
                    const thumb = document.createElement('img');
                    thumb.src = `<?= base_url('uploads/dokumentasi') ?>/${img}`;
                    thumb.className = 'lightbox-thumb rounded border cursor-pointer';
                    thumb.style.width = '60px';
                    thumb.style.height = '40px';
                    thumb.style.objectFit = 'cover';
                    thumb.style.cursor = 'pointer';
                    thumb.style.transition = 'all 0.2s';
                    thumb.addEventListener('click', () => {
                        currentIdx = idx;
                        updateLightboxState();
                    });
                    thumbsList.appendChild(thumb);
                });
            }
            
            updateLightboxState();
        });

        imageLightBoxModal.addEventListener('hide.bs.modal', function () {
            lightboxImage.src = '';
            allImages = [];
            currentIdx = 0;
        });
        
        // Navigation Button Listeners
        prevBtn.addEventListener('click', (e) => {
            e.stopPropagation();
            currentIdx = (currentIdx - 1 + allImages.length) % allImages.length;
            updateLightboxState();
        });
        
        nextBtn.addEventListener('click', (e) => {
            e.stopPropagation();
            currentIdx = (currentIdx + 1) % allImages.length;
            updateLightboxState();
        });

        // Keydown support
        const handleKeys = (e) => {
            if (imageLightBoxModal.classList.contains('show') && allImages.length > 1) {
                if (e.key === 'ArrowLeft') {
                    prevBtn.click();
                } else if (e.key === 'ArrowRight') {
                    nextBtn.click();
                }
            }
        };
        document.removeEventListener('keydown', handleKeys);
        document.addEventListener('keydown', handleKeys);
    }
});
</script>
<?= $this->endSection() ?>
