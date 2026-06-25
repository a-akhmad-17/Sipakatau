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
</style>
<?= $this->endSection() ?>

<?= $this->section('content') ?>

<div class="py-4">
    <!-- Header -->
    <div class="glass-card mb-5 text-center py-5">
        <h1 class="display-5 fw-bold text-white mb-2">Video Edukasi Wawasan Kebangsaan</h1>
        <p class="text-muted mb-0">Meningkatkan kecintaan tanah air dan pemahaman Pancasila melalui materi visual edukatif.</p>
    </div>
    <!-- Video Grid -->
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
                
                $bgUrl = 'https://img.youtube.com/vi/' . esc($v['youtube_id']) . '/hqdefault.jpg';
                ?>
                <!-- Video Item -->
                <div class="col-md-6 col-lg-4">
                    <div class="glass-card h-100 p-2 d-flex flex-column justify-content-between video-card">
                        <div>
                            <div class="ratio ratio-16x9 rounded overflow-hidden position-relative mb-3 bg-dark" 
                                 style="cursor: pointer; background: url('<?= $bgUrl ?>') no-repeat center; background-size: cover;"
                                 data-bs-toggle="modal" 
                                 data-bs-target="#videoPlayerModal" 
                                 data-video-id="<?= esc($v['youtube_id']) ?>"
                                 data-video-title="<?= esc($v['title']) ?>">
                                <div class="position-absolute w-100 h-100 d-flex align-items-center justify-content-center" style="background: rgba(0,0,0,0.3); transition: background 0.3s;" onmouseover="this.style.background='rgba(0,0,0,0.1)'" onmouseout="this.style.background='rgba(0,0,0,0.3)'">
                                    <div class="rounded-circle bg-white text-dark d-flex align-items-center justify-content-center shadow-lg" style="width: 55px; height: 55px; transition: transform 0.2s;" onmouseover="this.style.transform='scale(1.1)'" onmouseout="this.style.transform='scale(1.0)'">
                                        <i class="fa-solid fa-play fa-lg ms-1 text-danger"></i>
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
                            <span><i class="fa-regular fa-clock me-1"></i> Durasi: <?= esc($v['duration']) ?></span>
                            <span class="text-muted text-truncate" style="max-width: 140px;" title="<?= esc($v['source']) ?>"><i class="fa-solid fa-circle-info me-1"></i> <?= esc($v['source']) ?></span>
                        </div>
                    </div>
                </div>
            <?php endforeach; ?>
        <?php else: ?>
            <div class="col-12 text-center py-5">
                <div class="glass-card">
                    <i class="fa-solid fa-video-slash fa-3x text-muted mb-3"></i>
                    <h5 class="text-white">Belum Ada Video Edukasi</h5>
                    <p class="text-muted mb-0">Daftar video edukasi kebangsaan saat ini sedang kosong.</p>
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
                <h5 class="modal-title font-heading text-white fw-bold" id="videoPlayerModalLabel"><i class="fa-solid fa-circle-play text-danger me-2"></i>Putar Video Edukasi</h5>
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
});
</script>
<?= $this->endSection() ?>
