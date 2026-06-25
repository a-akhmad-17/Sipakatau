<?= $this->extend('layouts/main') ?>

<?= $this->section('styles') ?>
<style>
    .section-title-line {
        position: relative;
        text-align: center;
        margin-bottom: 40px;
    }
    .section-title-line h2 {
        display: inline-block;
        background: var(--bg-color);
        padding: 0 20px;
        position: relative;
        z-index: 2;
        color: var(--text-main);
    }
    .section-title-line::before {
        content: "";
        position: absolute;
        top: 50%;
        left: 0;
        width: 100%;
        height: 1px;
        background: var(--border-color);
        z-index: 1;
    }
</style>
<?= $this->endSection() ?>

<?= $this->section('content') ?>

<div class="py-4">
    <!-- Hero Header -->
    <div class="glass-card mb-5 text-center py-5">
        <h1 class="display-5 fw-bold text-white mb-2">Visi & Misi</h1>
        <p class="text-muted mb-0">Badan Kesatuan Bangsa dan Politik Kabupaten Sinjai</p>
    </div>

    <!-- Visi & Misi -->
    <div class="row g-4">
        <div class="col-md-6">
            <div class="glass-card h-100">
                <div class="d-flex align-items-center gap-3 mb-4">
                    <div class="rounded-circle bg-primary-subtle text-primary d-flex align-items-center justify-content-center" style="width: 50px; height: 50px;">
                        <i class="fa-solid fa-eye fa-lg"></i>
                    </div>
                    <h3 class="text-white mb-0">Visi</h3>
                </div>
                <blockquote class="blockquote mb-0 text-muted" style="font-size: 1.1rem; line-height: 1.8; border-left: 3px solid var(--border-color); padding-left: 15px;">
                    "<?= esc($visi) ?>"
                </blockquote>
            </div>
        </div>
        <div class="col-md-6">
            <div class="glass-card h-100">
                <div class="d-flex align-items-center gap-3 mb-4">
                    <div class="rounded-circle bg-warning-subtle text-warning d-flex align-items-center justify-content-center" style="width: 50px; height: 50px;">
                        <i class="fa-solid fa-bullseye fa-lg"></i>
                    </div>
                    <h3 class="text-white mb-0">Misi</h3>
                </div>
                <?php if (!empty($misi)): ?>
                    <ol class="text-muted d-flex flex-column gap-3 mb-0" style="line-height: 1.7; padding-left: 20px;">
                        <?php foreach ($misi as $item): ?>
                            <li><?= esc($item) ?></li>
                        <?php endforeach; ?>
                    </ol>
                <?php endif; ?>
            </div>
        </div>
    </div>
</div>

<?= $this->endSection() ?>
