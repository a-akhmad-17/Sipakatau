<?= $this->extend('layouts/main') ?>

<?= $this->section('styles') ?>
<style>
    .bidang-hero {
        position: relative;
        overflow: hidden;
        border-left: 6px solid var(--bidang-color);
        transition: all 0.3s ease;
    }
    .subunit-card {
        background: rgba(255, 255, 255, 0.02);
        border: 1px solid var(--border-color);
        transition: all 0.3s ease;
    }
    .subunit-card:hover {
        background: rgba(255, 255, 255, 0.04);
        border-color: var(--bidang-color);
        transform: translateY(-2px);
    }
    .staff-card {
        transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
        border: 1px solid var(--border-color);
        background: var(--card-bg);
        border-radius: 16px;
    }
    .staff-card:hover {
        transform: translateY(-6px);
        border-color: var(--bidang-color) !important;
        box-shadow: 0 15px 30px rgba(0, 0, 0, 0.25);
    }
    .staff-card:hover .staff-avatar {
        transform: scale(1.1);
    }
    @keyframes spin {
        100% {
            transform: translate(-50%, -50%) rotate(360deg);
        }
    }
    @keyframes pulse {
        0%, 100% {
            opacity: 1;
            transform: scale(1);
        }
        50% {
            opacity: 0.6;
            transform: scale(1.15);
        }
    }
    .animate-pulse {
        animation: pulse 2s infinite ease-in-out;
    }
</style>
<?= $this->endSection() ?>

<?= $this->section('content') ?>

<?php 
    $colorMap = [
        'sekretariat' => ['border' => '#6366f1', 'bg' => 'rgba(99, 102, 241, 0.15)', 'text' => '#c7d2fe', 'icon' => 'fa-folder-open', 'badge_class' => 'bg-indigo-subtle text-indigo'],
        'ideologi'    => ['border' => '#e11d48', 'bg' => 'rgba(225, 29, 72, 0.15)', 'text' => '#fda4af', 'icon' => 'fa-brain', 'badge_class' => 'bg-danger-subtle text-danger'],
        'poldagri'    => ['border' => '#be123c', 'bg' => 'rgba(190, 18, 60, 0.15)', 'text' => '#fecdd3', 'icon' => 'fa-users-rectangle', 'badge_class' => 'bg-primary-subtle text-primary'],
        'ekososbud'   => ['border' => '#f59e0b', 'bg' => 'rgba(245, 158, 11, 0.15)', 'text' => '#fde68a', 'icon' => 'fa-shield-halved', 'badge_class' => 'bg-warning-subtle text-warning'],
    ];
    $style = $colorMap[$bidang['id']] ?? $colorMap['sekretariat'];
?>

<div class="py-4" style="--bidang-color: <?= esc($style['border']) ?>;">
    
    <!-- Hero Header -->
    <div class="glass-card mb-5 bidang-hero p-5">
        <div class="row align-items-center g-4">
            <div class="col-md-9 text-center text-md-start">
                <span class="badge <?= esc($style['badge_class']) ?> border mb-3 px-3 py-2 fs-6" style="border-radius: 8px;">
                    <i class="fa-solid <?= esc($style['icon']) ?> me-2"></i><?= esc($bidang['badge'] ?? 'Unit Kerja') ?>
                </span>
                <h1 class="display-5 fw-bold text-white mb-2"><?= esc($bidang['title']) ?></h1>
                <p class="text-muted mb-0 fs-5"><?= esc($bidang['subtitle'] ?? '') ?></p>
            </div>
            <div class="col-md-3 text-center d-none d-md-block">
                <div class="rounded-circle d-inline-flex align-items-center justify-content-center" 
                     style="width: 110px; height: 110px; background: <?= esc($style['bg']) ?>; color: <?= esc($style['border']) ?>; border: 2px solid <?= esc($style['border']) ?>;">
                    <i class="fa-solid <?= esc($bidang['icon'] ?? 'fa-folder-open') ?> fa-4x"></i>
                </div>
            </div>
        </div>
    </div>

    <!-- Bidang Info & Sub Units -->
    <div class="row g-4 mb-5">
        <!-- Deskripsi Tugas Pokok -->
        <div class="col-lg-7">
            <div class="glass-card h-100">
                <h3 class="text-white mb-4"><i class="fa-solid fa-circle-info text-danger me-2"></i>Tugas Pokok & Fungsi</h3>
                <p class="text-muted fs-5 mb-0" style="line-height: 1.8; text-align: justify;">
                    <?= esc($bidang['description']) ?>
                </p>
            </div>
        </div>

        <!-- Sub Unit / Seksi -->
        <div class="col-lg-5">
            <div class="glass-card h-100">
                <h3 class="text-white mb-4"><i class="fa-solid fa-network-wired text-danger me-2"></i>Sub-Unit & Seksi Kerja</h3>
                <?php if (!empty($bidang['sub_units'])): ?>
                    <div class="d-flex flex-column gap-3">
                        <?php foreach ($bidang['sub_units'] as $sub): ?>
                            <div class="p-3 rounded subunit-card d-flex align-items-center">
                                <div class="rounded-circle d-flex align-items-center justify-content-center me-3" 
                                     style="width: 36px; height: 36px; background: <?= esc($style['bg']) ?>; color: <?= esc($style['border']) ?>;">
                                    <i class="fa-solid fa-circle-check"></i>
                                </div>
                                <span class="text-white fw-semibold"><?= esc($sub) ?></span>
                            </div>
                        <?php endforeach; ?>
                    </div>
                <?php else: ?>
                    <p class="text-muted mb-0">Belum ada sub-unit terdaftar.</p>
                <?php endif; ?>
            </div>
        </div>
    </div>

    <!-- Personel Bidang -->
    <div class="glass-card mb-5">
        <h3 class="text-white mb-4 text-center text-md-start">
            <i class="fa-solid fa-user-shield text-danger me-2"></i>Pejabat & Personel Bidang
        </h3>
        
        <?php 
        $leaders = [];
        $members = [];
        if (!empty($staff)) {
            foreach ($staff as $s) {
                $roleLower = strtolower($s['role']);
                if (
                    strpos($roleLower, 'kabid') !== false || 
                    strpos($roleLower, 'kepala') !== false || 
                    strpos($roleLower, 'kasubbag') !== false ||
                    strpos($roleLower, 'sekretaris') !== false
                ) {
                    $leaders[] = $s;
                } else {
                    $members[] = $s;
                }
            }
        }
        ?>

        <?php if (!empty($leaders)): ?>
            <!-- Leaders Grid -->
            <div class="row g-4 justify-content-center mb-5">
                <?php foreach ($leaders as $s): 
                    $photoExists = (!empty($s['photo']) && strpos($s['photo'], 'default_') !== 0);
                ?>
                    <div class="col-md-6 col-lg-5 col-xl-4">
                        <div class="glass-card staff-card text-center p-4 h-100 d-flex flex-column align-items-center justify-content-between position-relative overflow-hidden" 
                             style="border: 2px solid <?= esc($style['border']) ?> !important; background: rgba(255, 255, 255, 0.03);">
                            
                            <!-- Leader Badge Icon -->
                            <div class="position-absolute top-0 end-0 m-3" title="Pimpinan Unit / Kepala">
                                <i class="fa-solid fa-crown fa-lg text-warning animate-pulse"></i>
                            </div>
                            
                            <div class="d-flex flex-column align-items-center w-100">
                                <div class="position-relative mb-4" style="width: 130px; height: 130px; cursor: pointer;"
                                     data-bs-toggle="modal" 
                                     data-bs-target="#staffPhotoModal" 
                                     data-img-src="<?= base_url($photoExists ? 'uploads/struktur/' . $s['photo'] : 'uploads/logo_kesbangpol.png') ?>"
                                     data-name="<?= esc($s['name']) ?>"
                                     data-role="<?= esc($s['role']) ?>"
                                     title="Klik untuk memperbesar foto">
                                    <!-- Animated border decoration -->
                                    <div class="position-absolute top-50 start-50 translate-middle rounded-circle" 
                                         style="width: 144px; height: 144px; border: 2.5px dashed <?= esc($style['border']) ?>; opacity: 0.75; animation: spin 20s linear infinite;"></div>
                                    <div class="rounded-circle overflow-hidden position-relative w-100 h-100 shadow-lg border border-4" 
                                         style="border-color: <?= esc($style['border']) ?> !important; z-index: 2;">
                                        <?php if ($photoExists): ?>
                                            <img src="<?= base_url('uploads/struktur/' . $s['photo']) ?>" style="width: 100%; height: 100%; object-fit: cover; transition: transform 0.3s;" class="staff-avatar">
                                        <?php else: ?>
                                            <div class="w-100 h-100 d-flex align-items-center justify-content-center fw-bold text-white fs-2" 
                                                 style="background: linear-gradient(135deg, <?= esc($style['border']) ?>, #1e293b);">
                                                <?= esc(substr($s['name'], 0, 1)) ?>
                                            </div>
                                        <?php endif; ?>
                                    </div>
                                </div>
                                <h4 class="text-white fw-bold mb-2 text-wrap" style="font-size: 1.15rem; line-height: 1.3;" title="<?= esc($s['name']) ?>"><?= esc($s['name']) ?></h4>
                                <div class="badge bg-warning-subtle text-warning mb-2 text-wrap px-3 py-1.5 border border-warning-subtle" style="font-size: 0.78rem; border-radius: 6px; font-weight: 700;"><?= esc($s['role']) ?></div>
                            </div>
                            <?php if (!empty($s['nip']) && $s['nip'] !== '-'): ?>
                                <div class="text-muted small mt-2 w-100 pt-2 border-top border-secondary border-opacity-10" style="font-size: 0.72rem; opacity: 0.85;">
                                    <i class="fa-solid fa-id-card me-1.5 text-secondary"></i><?= esc($s['nip']) ?>
                                </div>
                            <?php endif; ?>
                        </div>
                    </div>
                <?php endforeach; ?>
            </div>
        <?php endif; ?>

        <?php if (!empty($members)): ?>
            <!-- Divider or Sub-header for Members -->
            <div class="section-title-line my-5">
                <h2>STAF & PELAKSANA</h2>
            </div>

            <!-- Members Grid -->
            <div class="row g-4 justify-content-center">
                <?php foreach ($members as $s): 
                    $photoExists = (!empty($s['photo']) && strpos($s['photo'], 'default_') !== 0);
                ?>
                    <div class="col-sm-6 col-md-4 col-lg-3">
                        <div class="glass-card staff-card text-center p-3.5 h-100 d-flex flex-column align-items-center justify-content-between">
                            <div class="d-flex flex-column align-items-center w-100">
                                <div class="position-relative mb-3.5" style="width: 100px; height: 100px;">
                                    <div class="position-relative w-100 h-100 cursor-pointer"
                                         data-bs-toggle="modal" 
                                         data-bs-target="#staffPhotoModal" 
                                         data-img-src="<?= base_url($photoExists ? 'uploads/struktur/' . $s['photo'] : 'uploads/logo_kesbangpol.png') ?>"
                                         data-name="<?= esc($s['name']) ?>"
                                         data-role="<?= esc($s['role']) ?>"
                                         title="Klik untuk memperbesar foto">
                                        <!-- Animated border decoration (slower/subtler for staff) -->
                                        <div class="position-absolute top-50 start-50 translate-middle rounded-circle" 
                                             style="width: 110px; height: 110px; border: 1.5px dashed <?= esc($style['border']) ?>; opacity: 0.4; animation: spin 30s linear infinite;"></div>
                                        <div class="rounded-circle overflow-hidden position-relative w-100 h-100 shadow border border-2" 
                                             style="border-color: <?= esc($style['border']) ?> !important; z-index: 2;">
                                            <?php if ($photoExists): ?>
                                                <img src="<?= base_url('uploads/struktur/' . $s['photo']) ?>" style="width: 100%; height: 100%; object-fit: cover; transition: transform 0.3s;" class="staff-avatar">
                                            <?php else: ?>
                                                <div class="w-100 h-100 d-flex align-items-center justify-content-center fw-bold text-white fs-4" 
                                                     style="background: linear-gradient(135deg, <?= esc($style['border']) ?>, #1e293b);">
                                                    <?= esc(substr($s['name'], 0, 1)) ?>
                                                </div>
                                            <?php endif; ?>
                                        </div>
                                    </div>
                                </div>
                                <h5 class="text-white fw-bold mb-2 text-wrap" style="font-size: 0.95rem; line-height: 1.3;" title="<?= esc($s['name']) ?>"><?= esc($s['name']) ?></h5>
                                <div class="badge bg-secondary-subtle text-muted mb-2 text-wrap px-2 py-1.5 border border-secondary border-opacity-10" style="font-size: 0.7rem; border-radius: 6px;"><?= esc($s['role']) ?></div>
                            </div>
                            <?php if (!empty($s['nip']) && $s['nip'] !== '-'): ?>
                                <div class="text-muted small mt-2 w-100 pt-2 border-top border-secondary border-opacity-10" style="font-size: 0.68rem; opacity: 0.85;">
                                    <i class="fa-solid fa-id-card me-1.5 text-secondary"></i><?= esc($s['nip']) ?>
                                </div>
                            <?php endif; ?>
                        </div>
                    </div>
                <?php endforeach; ?>
            </div>
        <?php endif; 
        if (empty($leaders) && empty($members)): ?>
            <div class="text-center py-5">
                <i class="fa-solid fa-users fa-3x text-muted mb-3"></i>
                <h5 class="text-white">Belum Ada Personel Terdaftar</h5>
                <p class="text-muted mb-0">Daftar pejabat dan personel untuk bidang ini saat ini belum tersedia.</p>
            </div>
        <?php endif; ?>
    </div>

</div>

<!-- Staff Photo Lightbox Modal -->
<div class="modal fade" id="staffPhotoModal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-md">
        <div class="modal-content glass-card-modal bg-black border-0 p-0 overflow-hidden" style="border-radius: 16px;">
            <div class="modal-body p-0 position-relative text-center d-flex align-items-center justify-content-center bg-black" style="min-height: 300px; max-height: 80vh;">
                <button type="button" class="btn-close btn-close-white position-absolute top-0 end-0 m-3" data-bs-dismiss="modal" aria-label="Close" style="z-index: 10;"></button>
                <img id="staffModalImage" src="" alt="Foto Staf" style="max-width: 100%; max-height: 80vh; object-fit: contain;">
            </div>
            <div class="p-3 text-center" style="background: rgba(15, 23, 42, 0.95); border-top: 1px solid rgba(255, 255, 255, 0.1);">
                <h5 id="staffModalName" class="fw-bold mb-1" style="font-size: 1.05rem; color: #ffffff !important;"></h5>
                <p id="staffModalRole" class="small mb-0" style="color: #cbd5e1 !important;"></p>
            </div>
        </div>
    </div>
</div>

<?= $this->endSection() ?>

<?= $this->section('scripts') ?>
<script>
document.addEventListener('DOMContentLoaded', () => {
    const staffPhotoModal = document.getElementById('staffPhotoModal');
    if (staffPhotoModal) {
        const modalImg = document.getElementById('staffModalImage');
        const modalName = document.getElementById('staffModalName');
        const modalRole = document.getElementById('staffModalRole');

        staffPhotoModal.addEventListener('show.bs.modal', function (event) {
            const trigger = event.relatedTarget;
            const imgSrc = trigger.getAttribute('data-img-src');
            const name = trigger.getAttribute('data-name');
            const role = trigger.getAttribute('data-role');

            modalImg.src = imgSrc;
            modalName.innerText = name;
            modalRole.innerText = role;
        });

        staffPhotoModal.addEventListener('hide.bs.modal', function () {
            modalImg.src = '';
        });
    }
});
</script>
<?= $this->endSection() ?>
