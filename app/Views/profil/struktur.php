<?= $this->extend('layouts/main') ?>

<?= $this->section('styles') ?>
<style>
    .org-chart {
        display: flex;
        flex-direction: column;
        align-items: center;
        gap: 20px;
        position: relative;
        padding: 20px 0;
    }
    .org-node {
        background: var(--card-bg);
        border: 1px solid var(--border-color);
        border-radius: 12px;
        padding: 15px 20px;
        text-align: center;
        width: 250px;
        box-shadow: 0 4px 20px rgba(0,0,0,0.15);
        transition: all 0.3s ease;
        position: relative;
        backdrop-filter: blur(12px);
        -webkit-backdrop-filter: blur(12px);
    }
    .org-node:hover {
        transform: translateY(-5px);
        box-shadow: 0 8px 30px rgba(255, 255, 255, 0.05);
    }
    .org-title {
        font-size: 0.95rem;
        font-weight: 700;
        color: var(--text-main);
        margin-bottom: 2px;
        letter-spacing: 0.3px;
    }
    .org-name {
        font-size: 0.75rem;
        color: var(--text-muted);
    }
    .connector-line {
        width: 2px;
        height: 25px;
        background: var(--border-color);
    }
    .org-badge {
        font-size: 0.65rem;
        padding: 3px 8px;
        border-radius: 6px;
        font-weight: 700;
        margin-bottom: 10px;
        display: inline-block;
        letter-spacing: 0.5px;
    }
    .org-avatar-container {
        width: 75px;
        height: 75px;
        margin: 0 auto 12px auto;
        border-radius: 50%;
        overflow: hidden;
        border: 2px solid var(--border-color);
        box-shadow: 0 3px 8px rgba(0,0,0,0.2);
        display: flex;
        align-items: center;
        justify-content: center;
        background: rgba(255,255,255,0.05);
        transition: all 0.3s ease;
    }
    .org-node:hover .org-avatar-container {
        transform: scale(1.05);
    }
    .org-avatar-img {
        width: 100%;
        height: 100%;
        object-fit: cover;
    }
    .org-avatar-fallback {
        width: 100%;
        height: 100%;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 1.8rem;
        font-weight: 700;
        color: #ffffff;
    }

    .bg-pimpinan { background: linear-gradient(135deg, #ef4444, #f43f5e) !important; }
    .bg-sekretariat { background: linear-gradient(135deg, #6366f1, #a855f7) !important; }
    .bg-ideologi { background: linear-gradient(135deg, #3b82f6, #06b6d4) !important; }
    .bg-poldagri { background: linear-gradient(135deg, #10b981, #14b8a6) !important; }
    .bg-ekososbud { background: linear-gradient(135deg, #f59e0b, #eab308) !important; }

    /* Custom borders */
    .border-top-red { border-top: 4px solid #ef4444; }
    .border-top-sekretariat { border-top: 4px solid #71717a; }
    .border-top-ideologi { border-top: 4px solid #e11d48; }
    .border-top-ideologi-staff { border-top: 3px dashed #3b82f6; }
    .border-top-poldagri { border-top: 4px solid #be123c; }
    .border-top-poldagri-staff { border-top: 3px dashed #10b981; }
    .border-top-ekososbud { border-top: 4px solid #f59e0b; }
    .border-top-ekososbud-staff { border-top: 3px dashed #eab308; }
</style>
<?= $this->endSection() ?>

<?= $this->section('content') ?>

<div class="py-4">
    <!-- Header -->
    <div class="glass-card mb-4 text-center py-4">
        <h1 class="display-6 fw-bold text-white mb-1">Struktur Organisasi</h1>
        <p class="text-muted mb-0">Bagan Kedudukan & Hirarki Badan Kesatuan Bangsa dan Politik Kabupaten Sinjai</p>
    </div>

    <!-- Bagan Organisasi -->
    <div class="glass-card py-4 px-3">
        <?php
        // Group by ID
        $nodes = [];
        foreach ($struktur as $item) {
            $nodes[$item['id']] = $item;
        }

        // Helper check for photo existence
        $checkPhoto = function($nodeName) use ($nodes) {
            if (!isset($nodes[$nodeName])) return false;
            $photo = $nodes[$nodeName]['photo'] ?? '';
            return (!empty($photo) && strpos($photo, 'default_') !== 0);
        };
        ?>

        <div class="org-chart">
            <!-- Kepala Badan (Kaban) -->
            <?php if (isset($nodes['kaban'])): ?>
                <div class="org-group text-center">
                    <div class="org-node border-top-red" style="width: 280px;">
                        <span class="org-badge bg-danger-subtle text-danger border border-danger-subtle"><?= esc($nodes['kaban']['role']) ?></span>
                        <div class="org-avatar-container" style="width: 85px; height: 85px;">
                            <?php if ($checkPhoto('kaban')): ?>
                                <img src="<?= base_url('uploads/struktur/' . $nodes['kaban']['photo']) ?>" class="org-avatar-img" alt="<?= esc($nodes['kaban']['name']) ?>">
                            <?php else: ?>
                                <div class="org-avatar-fallback bg-pimpinan"><?= esc(substr($nodes['kaban']['name'], 0, 1)) ?></div>
                            <?php endif; ?>
                        </div>
                        <div class="org-title" style="font-size: 1rem;"><?= esc($nodes['kaban']['name']) ?></div>
                        <div class="org-name"><?= esc($nodes['kaban']['nip']) ?></div>
                    </div>
                </div>
            <?php endif; ?>

            <div class="connector-line"></div>

            <!-- Sekretaris -->
            <?php if (isset($nodes['sekretaris'])): ?>
                <div class="org-group text-center">
                    <div class="org-node border-top-sekretariat" style="width: 270px;">
                        <span class="org-badge bg-indigo-subtle text-indigo border border-indigo-subtle"><?= esc($nodes['sekretaris']['role']) ?></span>
                        <div class="org-avatar-container" style="width: 80px; height: 80px;">
                            <?php if ($checkPhoto('sekretaris')): ?>
                                <img src="<?= base_url('uploads/struktur/' . $nodes['sekretaris']['photo']) ?>" class="org-avatar-img" alt="<?= esc($nodes['sekretaris']['name']) ?>">
                            <?php else: ?>
                                <div class="org-avatar-fallback bg-pimpinan"><?= esc(substr($nodes['sekretaris']['name'], 0, 1)) ?></div>
                            <?php endif; ?>
                        </div>
                        <div class="org-title"><?= esc($nodes['sekretaris']['name']) ?></div>
                        <div class="org-name"><?= esc($nodes['sekretaris']['nip']) ?></div>
                    </div>
                </div>
            <?php endif; ?>

            <div class="connector-line"></div>

            <div class="container-fluid px-0">
                <div class="row g-4 justify-content-center">
                    <!-- KOLOM KIRI: SEKRETARIAT (KASUBBAG) -->
                    <div class="col-xl-4 col-lg-5">
                        <div class="glass-card p-3 h-100 border border-secondary border-opacity-10" style="background: rgba(255,255,255,0.01);">
                            <h5 class="text-white text-center mb-4 pb-2 border-bottom border-secondary border-opacity-25 uppercase tracking-wider" style="font-size: 0.9rem; font-weight: 700;">
                                <i class="fa-solid fa-folder-open text-indigo me-2"></i>SEKRETARIAT
                            </h5>
                            <div class="d-flex flex-column align-items-center gap-3">
                                <?php 
                                $sekretariatNodes = array_filter($struktur, function($item) {
                                    return $item['category'] === 'sekretariat';
                                });
                                if (!empty($sekretariatNodes)):
                                    foreach ($sekretariatNodes as $node): 
                                        $photoExists = (!empty($node['photo']) && strpos($node['photo'], 'default_') !== 0);
                                ?>
                                        <div class="org-node w-100 border-top-sekretariat">
                                            <span class="org-badge bg-indigo-subtle text-indigo border border-indigo-subtle"><?= esc($node['role']) ?></span>
                                            <div class="org-avatar-container">
                                                <?php if ($photoExists): ?>
                                                    <img src="<?= base_url('uploads/struktur/' . $node['photo']) ?>" class="org-avatar-img" alt="<?= esc($node['name']) ?>">
                                                <?php else: ?>
                                                    <div class="org-avatar-fallback bg-sekretariat"><?= esc(substr($node['name'], 0, 1)) ?></div>
                                                <?php endif; ?>
                                            </div>
                                            <div class="org-title"><?= esc($node['name']) ?></div>
                                            <div class="org-name"><?= esc($node['nip']) ?></div>
                                        </div>
                                    <?php endforeach; ?>
                                <?php else: ?>
                                    <div class="text-muted small py-4">Belum ada staf sekretariat.</div>
                                <?php endif; ?>
                            </div>
                        </div>
                    </div>

                    <!-- KOLOM KANAN: BIDANG-BIDANG (3 KOLOM) -->
                    <div class="col-xl-8 col-lg-7">
                        <div class="glass-card p-3 h-100 border border-secondary border-opacity-10" style="background: rgba(255,255,255,0.01);">
                            <h5 class="text-white text-center mb-4 pb-2 border-bottom border-secondary border-opacity-25 uppercase tracking-wider" style="font-size: 0.9rem; font-weight: 700;">
                                <i class="fa-solid fa-server text-primary me-2"></i>BIDANG & UNIT KERJA
                            </h5>
                            
                            <div class="row g-3">
                                <!-- 1. Bidang Ideologi & Wasbang -->
                                <div class="col-md-4">
                                    <div class="d-flex flex-column align-items-center gap-3">
                                        <?php 
                                        $ideologiNodes = array_filter($struktur, function($item) {
                                            return $item['category'] === 'ideologi';
                                        });
                                        if (!empty($ideologiNodes)):
                                            // Sort so Kabid is at index 0
                                            usort($ideologiNodes, function($a, $b) {
                                                $aIsKabid = (stripos($a['role'], 'kabid') !== false || stripos($a['role'], 'kepala bidang') !== false);
                                                $bIsKabid = (stripos($b['role'], 'kabid') !== false || stripos($b['role'], 'kepala bidang') !== false);
                                                return $bIsKabid - $aIsKabid;
                                            });

                                            $renderedKabid = false;
                                            foreach ($ideologiNodes as $node):
                                                $isKabid = (stripos($node['role'], 'kabid') !== false || stripos($node['role'], 'kepala bidang') !== false);
                                                $photoExists = (!empty($node['photo']) && strpos($node['photo'], 'default_') !== 0);
                                                
                                                if (!$isKabid && $renderedKabid) {
                                                    echo '<div class="connector-line" style="height: 15px;"></div>';
                                                    $renderedKabid = false;
                                                }
                                                if ($isKabid) {
                                                    $renderedKabid = true;
                                                }
                                            ?>
                                                <div class="org-node w-100 <?= $isKabid ? 'border-top-ideologi' : 'border-top-ideologi-staff' ?>">
                                                    <span class="org-badge bg-primary-subtle text-primary border border-primary-subtle"><?= esc($node['role']) ?></span>
                                                    <div class="org-avatar-container" <?= !$isKabid ? 'style="width: 60px; height: 60px; margin-bottom: 8px;"' : '' ?>>
                                                        <?php if ($photoExists): ?>
                                                            <img src="<?= base_url('uploads/struktur/' . $node['photo']) ?>" class="org-avatar-img" alt="<?= esc($node['name']) ?>">
                                                        <?php else: ?>
                                                            <div class="org-avatar-fallback bg-ideologi" <?= !$isKabid ? 'style="font-size: 1.4rem;"' : '' ?>><?= esc(substr($node['name'], 0, 1)) ?></div>
                                                        <?php endif; ?>
                                                    </div>
                                                    <div class="org-title" <?= !$isKabid ? 'style="font-size: 0.85rem;"' : '' ?>><?= esc($node['name']) ?></div>
                                                    <?php if ($isKabid || (!empty($node['nip']) && $node['nip'] !== '-')): ?>
                                                        <div class="org-name"><?= esc($node['nip']) ?></div>
                                                    <?php endif; ?>
                                                </div>
                                            <?php endforeach; ?>
                                        <?php else: ?>
                                            <div class="text-muted small py-4">Belum ada staf bidang.</div>
                                        <?php endif; ?>
                                    </div>
                                </div>

                                <!-- 2. Bidang Poldagri & Ormas -->
                                <div class="col-md-4">
                                    <div class="d-flex flex-column align-items-center gap-3">
                                        <?php 
                                        $poldagriNodes = array_filter($struktur, function($item) {
                                            return $item['category'] === 'poldagri';
                                        });
                                        if (!empty($poldagriNodes)):
                                            // Sort so Kabid is at index 0
                                            usort($poldagriNodes, function($a, $b) {
                                                $aIsKabid = (stripos($a['role'], 'kabid') !== false || stripos($a['role'], 'kepala bidang') !== false);
                                                $bIsKabid = (stripos($b['role'], 'kabid') !== false || stripos($b['role'], 'kepala bidang') !== false);
                                                return $bIsKabid - $aIsKabid;
                                            });

                                            $renderedKabid = false;
                                            foreach ($poldagriNodes as $node):
                                                $isKabid = (stripos($node['role'], 'kabid') !== false || stripos($node['role'], 'kepala bidang') !== false);
                                                $photoExists = (!empty($node['photo']) && strpos($node['photo'], 'default_') !== 0);
                                                
                                                if (!$isKabid && $renderedKabid) {
                                                    echo '<div class="connector-line" style="height: 15px;"></div>';
                                                    $renderedKabid = false;
                                                }
                                                if ($isKabid) {
                                                    $renderedKabid = true;
                                                }
                                            ?>
                                                <div class="org-node w-100 <?= $isKabid ? 'border-top-poldagri' : 'border-top-poldagri-staff' ?>">
                                                    <span class="org-badge bg-success-subtle text-success border border-success-subtle"><?= esc($node['role']) ?></span>
                                                    <div class="org-avatar-container" <?= !$isKabid ? 'style="width: 60px; height: 60px; margin-bottom: 8px;"' : '' ?>>
                                                        <?php if ($photoExists): ?>
                                                            <img src="<?= base_url('uploads/struktur/' . $node['photo']) ?>" class="org-avatar-img" alt="<?= esc($node['name']) ?>">
                                                        <?php else: ?>
                                                            <div class="org-avatar-fallback bg-poldagri" <?= !$isKabid ? 'style="font-size: 1.4rem;"' : '' ?>><?= esc(substr($node['name'], 0, 1)) ?></div>
                                                        <?php endif; ?>
                                                    </div>
                                                    <div class="org-title" <?= !$isKabid ? 'style="font-size: 0.85rem;"' : '' ?>><?= esc($node['name']) ?></div>
                                                    <?php if ($isKabid || (!empty($node['nip']) && $node['nip'] !== '-')): ?>
                                                        <div class="org-name"><?= esc($node['nip']) ?></div>
                                                    <?php endif; ?>
                                                </div>
                                            <?php endforeach; ?>
                                        <?php else: ?>
                                            <div class="text-muted small py-4">Belum ada staf bidang.</div>
                                        <?php endif; ?>
                                    </div>
                                </div>

                                <!-- 3. Bidang Ekososbud & Agama -->
                                <div class="col-md-4">
                                    <div class="d-flex flex-column align-items-center gap-3">
                                        <?php 
                                        $ekososbudNodes = array_filter($struktur, function($item) {
                                            return $item['category'] === 'ekososbud';
                                        });
                                        if (!empty($ekososbudNodes)):
                                            // Sort so Kabid is at index 0
                                            usort($ekososbudNodes, function($a, $b) {
                                                $aIsKabid = (stripos($a['role'], 'kabid') !== false || stripos($a['role'], 'kepala bidang') !== false);
                                                $bIsKabid = (stripos($b['role'], 'kabid') !== false || stripos($b['role'], 'kepala bidang') !== false);
                                                return $bIsKabid - $aIsKabid;
                                            });

                                            $renderedKabid = false;
                                            foreach ($ekososbudNodes as $node):
                                                $isKabid = (stripos($node['role'], 'kabid') !== false || stripos($node['role'], 'kepala bidang') !== false);
                                                $photoExists = (!empty($node['photo']) && strpos($node['photo'], 'default_') !== 0);
                                                
                                                if (!$isKabid && $renderedKabid) {
                                                    echo '<div class="connector-line" style="height: 15px;"></div>';
                                                    $renderedKabid = false;
                                                }
                                                if ($isKabid) {
                                                    $renderedKabid = true;
                                                }
                                            ?>
                                                <div class="org-node w-100 <?= $isKabid ? 'border-top-ekososbud' : 'border-top-ekososbud-staff' ?>">
                                                    <span class="org-badge bg-warning-subtle text-warning border border-warning-subtle"><?= esc($node['role']) ?></span>
                                                    <div class="org-avatar-container" <?= !$isKabid ? 'style="width: 60px; height: 60px; margin-bottom: 8px;"' : '' ?>>
                                                        <?php if ($photoExists): ?>
                                                            <img src="<?= base_url('uploads/struktur/' . $node['photo']) ?>" class="org-avatar-img" alt="<?= esc($node['name']) ?>">
                                                        <?php else: ?>
                                                            <div class="org-avatar-fallback bg-ekososbud" <?= !$isKabid ? 'style="font-size: 1.4rem;"' : '' ?>><?= esc(substr($node['name'], 0, 1)) ?></div>
                                                        <?php endif; ?>
                                                    </div>
                                                    <div class="org-title" <?= !$isKabid ? 'style="font-size: 0.85rem;"' : '' ?>><?= esc($node['name']) ?></div>
                                                    <?php if ($isKabid || (!empty($node['nip']) && $node['nip'] !== '-')): ?>
                                                        <div class="org-name"><?= esc($node['nip']) ?></div>
                                                    <?php endif; ?>
                                                </div>
                                            <?php endforeach; ?>
                                        <?php else: ?>
                                            <div class="text-muted small py-4">Belum ada staf bidang.</div>
                                        <?php endif; ?>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<?= $this->endSection() ?>
