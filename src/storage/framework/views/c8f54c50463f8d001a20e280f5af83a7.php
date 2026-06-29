<?php
    $filters = $filters ?? [];
    $years = $filters['years'] ?? [now()->year];
    $statuses = $filters['statuses'] ?? [
        'all' => 'Semua Status',
        'achieved' => 'Tercapai',
        'not_achieved' => 'Belum Tercapai',
    ];

    $selectedYear = (int) ($filters['selected_year'] ?? request()->query('year', now()->year));
    $selectedStatus = (string) ($filters['selected_status'] ?? request()->query('status', 'all'));
    $baseTargetUrl = $indexUrl ?? url('/admin/sales-targets');

    if (! array_key_exists($selectedStatus, $statuses)) {
        $selectedStatus = 'all';
    }

    $makeFilterUrl = function (string|int $year, string $status) use ($baseTargetUrl): string {
        return $baseTargetUrl . '?' . http_build_query([
            'year' => (string) $year,
            'status' => $status,
        ]);
    };

    $currentTargetRevenue = (int) (
        $summary['target_revenue']
        ?? $summary['current_target_revenue']
        ?? $summary['current_target']
        ?? 0
    );

    $currentRevenue = (int) (
        $summary['monthly_revenue']
        ?? $summary['current_revenue']
        ?? $summary['actual_revenue']
        ?? $summary['revenue_actual']
        ?? 0
    );

    $revenueProgress = (float) (
        $summary['revenue_progress']
        ?? 0
    );

    $latestTargetMonth = (string) (
        $summary['latest_target_month']
        ?? $summary['latest_month']
        ?? '-'
    );

    $latestTargetValue = (int) (
        $summary['latest_target_value']
        ?? $summary['latest_target_revenue']
        ?? $summary['latest_value']
        ?? 0
    );

    $achievementStatus = (string) (
        $summary['achievement_status']
        ?? 'Belum Ada Target'
    );

    $statusLabels = [
        'achieved' => 'Tercapai',
        'near' => 'Hampir Tercapai',
        'not_achieved' => 'Belum Tercapai',
        'no_transaction' => 'Belum Ada Transaksi',
        'no_target' => 'Belum Ada Target',
    ];

    $achievementStatusLabel = $statusLabels[$achievementStatus] ?? $achievementStatus;

    $remainingRevenue = (int) (
        $summary['remaining_revenue']
        ?? max(0, $currentTargetRevenue - $currentRevenue)
    );

    $progressWidth = min(100, max(0, $revenueProgress));

    $cards = [
        [
            'label' => 'Target Revenue Bulan Ini',
            'value' => $this->rupiah($currentTargetRevenue),
            'caption' => 'Target aktif bulan ini',
            'icon' => '⚑',
            'color' => '#f97316',
        ],
        [
            'label' => 'Revenue Aktual',
            'value' => $this->rupiah($currentRevenue),
            'caption' => 'Dari transaksi bulan ini',
            'icon' => '▣',
            'color' => '#10b981',
        ],
        [
            'label' => 'Progress Revenue',
            'value' => number_format($revenueProgress, 1, ',', '.') . '%',
            'caption' => $achievementStatusLabel,
            'icon' => '◉',
            'color' => '#3b82f6',
        ],
    ];
?>

<?php if (isset($component)) { $__componentOriginalb525200bfa976483b4eaa0b7685c6e24 = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginalb525200bfa976483b4eaa0b7685c6e24 = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'filament-widgets::components.widget','data' => []] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('filament-widgets::widget'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes([]); ?>
<?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::processComponentKey($component); ?>

    <div class="ng-sales-target-page" data-active-year="<?php echo e($selectedYear); ?>" data-active-status="<?php echo e($selectedStatus); ?>">
        <section class="ng-op-hero-grid">
            <article class="ng-widget-card ng-op-hero-card">
                <div class="ng-widget-head">
                    <div>
                        <h1>Target Penjualan</h1>
                        <p>
                            Atur target revenue, gross profit, dan net profit bulanan agar Dashboard Keuangan dapat menampilkan progress pencapaian bisnis.
                        </p>

                        <small class="ng-target-active-period">
                            Data tabel: <?php echo e($selectedYear); ?> • <?php echo e($statuses[$selectedStatus] ?? 'Semua Status'); ?>

                        </small>
                    </div>

                    <div class="ng-target-filter" wire:ignore>
                        <span>Filter Data</span>

                        <div class="ng-target-filter-selects">
                            <select class="ng-target-select ng-target-year-select" onchange="if (this.value) window.location.href = this.value;">
                                <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::openLoop(); ?><?php endif; ?><?php $__currentLoopData = $years; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $yearOption): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::startLoop($loop->index); ?><?php endif; ?>
                                    <option value="<?php echo e($makeFilterUrl($yearOption, $selectedStatus)); ?>"
                                            <?php if((int) $selectedYear === (int) $yearOption): echo 'selected'; endif; ?>>
                                        <?php echo e($yearOption); ?>

                                    </option>
                                <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::endLoop(); ?><?php endif; ?><?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::closeLoop(); ?><?php endif; ?>
                            </select>

                            <select class="ng-target-select ng-target-status-select" onchange="if (this.value) window.location.href = this.value;">
                                <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::openLoop(); ?><?php endif; ?><?php $__currentLoopData = $statuses; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $statusKey => $statusLabel): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::startLoop($loop->index); ?><?php endif; ?>
                                    <option value="<?php echo e($makeFilterUrl($selectedYear, $statusKey)); ?>"
                                            <?php if($selectedStatus === $statusKey): echo 'selected'; endif; ?>>
                                        <?php echo e($statusLabel); ?>

                                    </option>
                                <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::endLoop(); ?><?php endif; ?><?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::closeLoop(); ?><?php endif; ?>
                            </select>
                        </div>
                    </div>
                </div>
            </article>

            <article class="ng-widget-card ng-op-highlight-card">
                <div class="ng-highlight-info">
                    <span>Target Terbaru</span>
                    <strong><?php echo e($latestTargetMonth); ?></strong>
                    <small><?php echo e($this->rupiah($latestTargetValue)); ?></small>
                </div>

                <div class="ng-highlight-actions">
                    <a href="<?php echo e($dashboardUrl); ?>" class="ng-soft-button">
                        Dashboard
                    </a>

                    <a href="<?php echo e($createUrl); ?>" class="ng-primary-button">
                        + New Target
                    </a>
                </div>
            </article>
        </section>

        <section class="ng-kpi-grid ng-sales-target-kpi-grid">
            <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::openLoop(); ?><?php endif; ?><?php $__currentLoopData = $cards; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $card): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::startLoop($loop->index); ?><?php endif; ?>
                <article class="ng-kpi-card" style="--accent: <?php echo e($card['color'] ?? '#f97316'); ?>;">
                    <div class="ng-kpi-icon">
                        <?php echo e($card['icon'] ?? '▣'); ?>

                    </div>

                    <div class="ng-kpi-content">
                        <div class="ng-kpi-label">
                            <?php echo e($card['label'] ?? '-'); ?>

                            <span>⋮</span>
                        </div>

                        <strong><?php echo e($card['value'] ?? '-'); ?></strong>

                        <p class="neutral">
                            <?php echo e($card['caption'] ?? '-'); ?>

                        </p>
                    </div>
                </article>
            <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::endLoop(); ?><?php endif; ?><?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::closeLoop(); ?><?php endif; ?>
        </section>
    </div>

    <style>
        html,
        body {
            overflow-x: hidden !important;
        }

        body:has(.ng-sales-target-page) {
            background:
                linear-gradient(120deg, rgba(255, 248, 237, .18), rgba(255, 224, 185, .05)),
                url('/images/pos-orange-bg.png'),
                radial-gradient(circle at 15% 8%, rgba(255, 255, 255, .48) 0 130px, transparent 280px),
                radial-gradient(circle at 88% 78%, rgba(255, 118, 0, .42) 0 250px, transparent 520px),
                radial-gradient(circle at 20% 96%, rgba(255, 181, 83, .30) 0 220px, transparent 500px),
                linear-gradient(135deg, #fff3df 0%, #ffd394 48%, #ff9c45 100%) !important;
            background-size: cover !important;
            background-position: center !important;
            background-attachment: fixed !important;
        }

        body:has(.ng-sales-target-page) .fi-main,
        body:has(.ng-sales-target-page) .fi-main-ctn,
        body:has(.ng-sales-target-page) .fi-page,
        body:has(.ng-sales-target-page) .fi-page-content {
            width: 100% !important;
            max-width: 100% !important;
            background: transparent !important;
            overflow-x: hidden !important;
        }

        body:has(.ng-sales-target-page) .fi-page {
            padding: 0 !important;
        }

        body:has(.ng-sales-target-page) .fi-page-header {
            display: none !important;
        }

        body:has(.ng-sales-target-page) .fi-main {
            padding: 0 !important;
        }

        body:has(.ng-sales-target-page) .fi-page-content {
            gap: 0 !important;
            row-gap: 0 !important;
        }

        body:has(.ng-sales-target-page) .fi-wi,
        body:has(.ng-sales-target-page) .fi-wi-widget,
        body:has(.ng-sales-target-page) .fi-wi-widget-content,
        body:has(.ng-sales-target-page) .fi-wi-widgets,
        body:has(.ng-sales-target-page) .fi-wi-widgets > * {
            margin: 0 !important;
            padding: 0 !important;
            background: transparent !important;
            border: none !important;
            box-shadow: none !important;
        }

        .ng-sales-target-page {
            width: 100% !important;
            max-width: 100% !important;
            padding: 24px 24px 10px !important;
            overflow: visible !important;
            font-family: Inter, Poppins, ui-sans-serif, system-ui, -apple-system, BlinkMacSystemFont, "Segoe UI", sans-serif;
            color: #24180f;
        }

        .ng-sales-target-page * {
            box-sizing: border-box;
        }

        .ng-op-hero-grid {
            display: grid;
            grid-template-columns: minmax(0, 1.45fr) minmax(360px, .55fr);
            gap: 16px;
            margin-bottom: 14px;
        }

        .ng-widget-card,
        .ng-kpi-card {
            position: relative;
            overflow: hidden;
            border: 1px solid rgba(255, 255, 255, .58);
            background:
                linear-gradient(145deg, rgba(255, 255, 255, .46), rgba(255, 246, 231, .22)),
                radial-gradient(circle at 100% 0%, rgba(255, 153, 30, .16), transparent 38%) !important;
            box-shadow:
                0 22px 54px rgba(101, 58, 21, .12),
                0 0 0 1px rgba(255, 255, 255, .12) inset,
                inset 0 1px 0 rgba(255, 255, 255, .62);
            backdrop-filter: blur(14px);
            -webkit-backdrop-filter: blur(14px);
        }

        .ng-widget-card::before,
        .ng-kpi-card::before {
            content: "";
            position: absolute;
            inset: 0;
            pointer-events: none;
            background:
                linear-gradient(120deg, rgba(255, 255, 255, .34), transparent 28%, transparent 70%, rgba(255, 255, 255, .16));
            opacity: .38;
        }

        .ng-widget-card {
            border-radius: 24px;
            padding: 18px;
            min-width: 0;
        }

        .ng-op-hero-card,
        .ng-op-highlight-card {
            min-height: 118px;
        }

        .ng-op-hero-card {
            display: flex;
            align-items: center;
        }

        .ng-widget-head {
            position: relative;
            z-index: 2;
            display: flex;
            align-items: center;
            justify-content: space-between;
            gap: 16px;
            width: 100%;
        }

        .ng-widget-head h1 {
            margin: 0;
            color: #21160d;
            font-size: 30px;
            line-height: 1.05;
            font-weight: 950;
            letter-spacing: -.04em;
        }

        .ng-widget-head p {
            max-width: 760px;
            margin: 8px 0 0;
            color: #765d45;
            font-size: 13px;
            line-height: 1.55;
            font-weight: 700;
        }

        .ng-target-active-period {
            display: inline-flex;
            margin-top: 10px;
            color: #d95d00;
            font-size: 12px;
            line-height: 1.3;
            font-weight: 950;
        }

        .ng-target-filter {
            position: relative;
            z-index: 3;
            min-width: 430px;
            display: grid;
            gap: 8px;
            justify-items: end;
        }

        .ng-target-filter span {
            color: #d95d00;
            font-size: 12px;
            line-height: 1;
            font-weight: 950;
            letter-spacing: .04em;
            text-transform: uppercase;
        }

        .ng-target-filter-selects {
            min-height: 52px;
            display: flex;
            align-items: center;
            gap: 9px;
            padding: 6px;
            border-radius: 18px;
            border: 1px solid rgba(255, 255, 255, .62);
            background: rgba(255, 255, 255, .38);
            box-shadow:
                0 18px 35px rgba(95, 55, 18, .10),
                inset 0 1px 0 rgba(255, 255, 255, .62);
            backdrop-filter: blur(14px);
            -webkit-backdrop-filter: blur(14px);
        }

        .ng-target-select {
            min-height: 40px;
            min-width: 148px;
            border: 0;
            outline: none;
            border-radius: 14px;
            padding: 0 14px;
            color: #4a321f;
            background: rgba(255, 255, 255, .78);
            font-size: 13px;
            font-weight: 900;
            cursor: pointer;
        }

        .ng-target-year-select {
            min-width: 94px;
        }

        .ng-target-status-select {
            min-width: 118px;
        }


        .ng-op-highlight-card {
            display: flex;
            align-items: center;
            justify-content: space-between;
            gap: 16px;
        }

        .ng-highlight-info {
            position: relative;
            z-index: 2;
            min-width: 0;
        }

        .ng-highlight-info span {
            display: block;
            color: #765d45;
            font-size: 11px;
            font-weight: 900;
        }

        .ng-highlight-info strong {
            display: block;
            max-width: 280px;
            margin: 8px 0;
            overflow: hidden;
            color: #21160d;
            font-size: 22px;
            line-height: 1.1;
            font-weight: 950;
            white-space: nowrap;
            text-overflow: ellipsis;
            letter-spacing: -.03em;
        }

        .ng-highlight-info small {
            display: block;
            color: #765d45;
            font-size: 11px;
            font-weight: 850;
        }

        .ng-highlight-actions {
            position: relative;
            z-index: 2;
            display: flex;
            align-items: center;
            justify-content: flex-end;
            gap: 9px;
            flex-wrap: wrap;
        }

        .ng-soft-button,
        .ng-primary-button {
            display: inline-flex;
            align-items: center;
            justify-content: center;
            min-height: 42px;
            padding: 0 16px;
            border-radius: 15px;
            font-size: 12px;
            font-weight: 950;
            text-decoration: none;
            white-space: nowrap;
            transition: .2s ease;
        }

        .ng-soft-button {
            color: #d95d00;
            background: rgba(255, 255, 255, .36);
            border: 1px solid rgba(255, 255, 255, .50);
            box-shadow: inset 0 1px 0 rgba(255, 255, 255, .44);
        }

        .ng-soft-button:hover {
            color: #fff;
            background: linear-gradient(135deg, #ff9d18, #ee6500);
            box-shadow: 0 12px 22px rgba(238, 101, 0, .22);
        }

        .ng-primary-button {
            color: #fff;
            background: linear-gradient(135deg, #ff9d18, #ee6500);
            box-shadow: 0 14px 26px rgba(238, 101, 0, .26);
        }

        .ng-primary-button:hover {
            transform: translateY(-1px);
            box-shadow: 0 18px 32px rgba(238, 101, 0, .30);
        }

        .ng-sales-target-kpi-grid {
            display: grid;
            grid-template-columns: repeat(4, minmax(0, 1fr));
            gap: 14px;
            margin-bottom: 14px;
        }

        .ng-kpi-card {
            min-height: 112px;
            border-radius: 22px;
            padding: 16px;
            display: flex;
            align-items: center;
            gap: 14px;
            min-width: 0;
        }

        .ng-kpi-icon {
            position: relative;
            z-index: 2;
            flex: 0 0 48px;
            width: 48px;
            height: 48px;
            display: grid;
            place-items: center;
            border-radius: 15px;
            color: #fff;
            font-size: 22px;
            font-weight: 950;
            background:
                radial-gradient(circle at 35% 25%, rgba(255, 255, 255, .28), transparent 32%),
                linear-gradient(135deg, var(--accent), #e45700);
            box-shadow: 0 12px 24px rgba(238, 101, 0, .20);
        }

        .ng-kpi-content {
            position: relative;
            z-index: 2;
            min-width: 0;
            flex: 1;
        }

        .ng-kpi-label {
            display: flex;
            justify-content: space-between;
            gap: 8px;
            color: #765d45;
            font-size: 12px;
            line-height: 1.2;
            font-weight: 950;
            letter-spacing: .05em;
            text-transform: uppercase;
        }

        .ng-kpi-label span {
            color: #8a7259;
        }

        .ng-kpi-content strong {
            display: block;
            margin-top: 7px;
            color: #21160d;
            font-size: 24px;
            line-height: 1.05;
            font-weight: 950;
            letter-spacing: -.04em;
            white-space: nowrap;
        }

        .ng-kpi-content p {
            margin: 8px 0 0;
            color: #3d556f;
            font-size: 12px;
            line-height: 1.35;
            font-weight: 850;
            white-space: nowrap;
            overflow: hidden;
            text-overflow: ellipsis;
        }



        /* No horizontal scroll table: content fixed inside widget width */
        body:has(.ng-sales-target-page) {
            overflow-x: hidden !important;
        }

        body:has(.ng-sales-target-page) .fi-ta-ctn {
            width: calc(100% - 48px) !important;
            max-width: calc(100% - 48px) !important;
            margin: 10px 24px 24px !important;
            border-radius: 24px !important;
            overflow: hidden !important;
            border: 1px solid rgba(255, 255, 255, .58) !important;
            background:
                linear-gradient(145deg, rgba(255, 255, 255, .46), rgba(255, 246, 231, .22)),
                radial-gradient(circle at 100% 0%, rgba(255, 153, 30, .16), transparent 38%) !important;
            box-shadow:
                0 22px 54px rgba(101, 58, 21, .12),
                0 0 0 1px rgba(255, 255, 255, .12) inset,
                inset 0 1px 0 rgba(255, 255, 255, .62) !important;
            backdrop-filter: blur(14px) !important;
            -webkit-backdrop-filter: blur(14px) !important;
        }

        body:has(.ng-sales-target-page) .fi-ta,
        body:has(.ng-sales-target-page) .fi-ta-content,
        body:has(.ng-sales-target-page) .fi-ta-table,
        body:has(.ng-sales-target-page) .fi-ta-header,
        body:has(.ng-sales-target-page) .fi-ta-toolbar {
            background: transparent !important;
            border-color: rgba(255, 255, 255, .20) !important;
        }

        body:has(.ng-sales-target-page) .fi-ta-header {
            min-height: 62px !important;
            padding: 12px 18px !important;
        }

        body:has(.ng-sales-target-page) .fi-ta-header-heading {
            display: none !important;
        }

        body:has(.ng-sales-target-page) .fi-ta-content,
        body:has(.ng-sales-target-page) .fi-ta-table-wrap {
            width: 100% !important;
            max-width: 100% !important;
            overflow-x: hidden !important;
        }

        body:has(.ng-sales-target-page) .fi-ta-table {
            width: 100% !important;
            max-width: 100% !important;
            min-width: 0 !important;
            table-layout: fixed !important;
        }

        body:has(.ng-sales-target-page) .fi-ta-table thead th {
            background: rgba(255, 255, 255, .22) !important;
            border-color: rgba(255, 255, 255, .18) !important;
            padding-top: 12px !important;
            padding-bottom: 12px !important;
        }

        body:has(.ng-sales-target-page) .fi-ta-table tbody tr {
            background: rgba(255, 255, 255, .08) !important;
            border-color: rgba(255, 255, 255, .16) !important;
        }

        body:has(.ng-sales-target-page) .fi-ta-table tbody tr:hover {
            background: rgba(255, 255, 255, .20) !important;
        }

        body:has(.ng-sales-target-page) .fi-ta-table th,
        body:has(.ng-sales-target-page) .fi-ta-table td {
            min-width: 0 !important;
            max-width: none !important;
            overflow: hidden !important;
            padding-left: 12px !important;
            padding-right: 12px !important;
            vertical-align: middle !important;
        }

        body:has(.ng-sales-target-page) .fi-ta-table th:first-child,
        body:has(.ng-sales-target-page) .fi-ta-table td:first-child {
            width: 42px !important;
            max-width: 42px !important;
            padding-left: 16px !important;
            padding-right: 8px !important;
        }

        body:has(.ng-sales-target-page) .fi-ta-actions,
        body:has(.ng-sales-target-page) .fi-ta-actions-cell,
        body:has(.ng-sales-target-page) td:has(.fi-ta-actions) {
            width: 58px !important;
            max-width: 58px !important;
            min-width: 58px !important;
            padding-left: 4px !important;
            padding-right: 14px !important;
            overflow: visible !important;
        }

        body:has(.ng-sales-target-page) .fi-ta-actions {
            display: flex !important;
            justify-content: flex-end !important;
        }

        body:has(.ng-sales-target-page) .fi-ta-actions .fi-btn {
            min-width: 36px !important;
            width: 36px !important;
            padding-left: 0 !important;
            padding-right: 0 !important;
            border-radius: 999px !important;
        }

        body:has(.ng-sales-target-page) .fi-ta-text,
        body:has(.ng-sales-target-page) .fi-ta-text-item,
        body:has(.ng-sales-target-page) .fi-ta-text-item-label {
            max-width: 100% !important;
            white-space: normal !important;
            word-break: break-word !important;
            overflow-wrap: anywhere !important;
        }

        body:has(.ng-sales-target-page) .fi-ta-cell .fi-badge {
            max-width: 100% !important;
            white-space: nowrap !important;
        }

        @media (max-width: 1100px) {
            body:has(.ng-sales-target-page) .fi-ta-ctn {
                width: calc(100% - 28px) !important;
                max-width: calc(100% - 28px) !important;
                margin-left: 14px !important;
                margin-right: 14px !important;
            }

            body:has(.ng-sales-target-page) .fi-ta-content,
            body:has(.ng-sales-target-page) .fi-ta-table-wrap {
                overflow-x: hidden !important;
            }
        }


        /* Final cleanup: 4 KPI, no double scroll, softer flat glass */
        body:has(.ng-sales-target-page),
        body:has(.ng-sales-target-page) .fi-main,
        body:has(.ng-sales-target-page) .fi-main-ctn,
        body:has(.ng-sales-target-page) .fi-page,
        body:has(.ng-sales-target-page) .fi-page-content {
            overflow-x: hidden !important;
        }

        body:has(.ng-sales-target-page) .fi-ta-content,
        body:has(.ng-sales-target-page) .fi-ta-table-wrap,
        body:has(.ng-sales-target-page) .fi-ta-ctn {
            overflow-x: hidden !important;
            overflow-y: visible !important;
        }

        body:has(.ng-sales-target-page) .fi-ta-ctn::-webkit-scrollbar,
        body:has(.ng-sales-target-page) .fi-ta-content::-webkit-scrollbar,
        body:has(.ng-sales-target-page) .fi-ta-table-wrap::-webkit-scrollbar {
            display: none !important;
            width: 0 !important;
            height: 0 !important;
        }

        .ng-widget-card,
        .ng-kpi-card,
        body:has(.ng-sales-target-page) .fi-ta-ctn {
            box-shadow:
                0 0 0 1px rgba(255, 255, 255, .14) inset,
                inset 0 1px 0 rgba(255, 255, 255, .42) !important;
        }

        .ng-widget-card::before,
        .ng-kpi-card::before {
            opacity: .20 !important;
        }

        body:has(.ng-sales-target-page) .fi-ta-row,
        body:has(.ng-sales-target-page) .fi-ta-table tbody tr {
            box-shadow: none !important;
        }

        @media (max-width: 1500px) {
            .ng-sales-target-kpi-grid {
                grid-template-columns: repeat(3, minmax(0, 1fr));
            }
        }

        @media (max-width: 1100px) {
            .ng-op-hero-grid {
                grid-template-columns: 1fr;
            }

            .ng-widget-head {
                align-items: flex-start;
                flex-direction: column;
            }

            .ng-target-filter {
                width: 100%;
                min-width: 0;
                justify-items: start;
            }

            .ng-target-filter-selects {
                width: 100%;
                flex-wrap: wrap;
            }

            .ng-target-select {
                flex: 1;
                min-width: 140px;
            }

            .ng-sales-target-kpi-grid {
                grid-template-columns: repeat(2, minmax(0, 1fr));
            }
        }

        @media (max-width: 700px) {
            .ng-sales-target-page {
                padding: 16px 14px 8px !important;
            }

            .ng-sales-target-kpi-grid {
                grid-template-columns: 1fr;
            }

            .ng-op-highlight-card {
                align-items: flex-start;
                flex-direction: column;
            }

            .ng-highlight-actions {
                width: 100%;
            }

            .ng-soft-button,
            .ng-primary-button {
                flex: 1;
            }

            .ng-widget-head h1 {
                font-size: 25px;
            }
        }

        /* Hard fix: remove internal / double scrollbars, keep page using main browser scroll */
        html:has(.ng-sales-target-page),
        body:has(.ng-sales-target-page) {
            overflow-x: hidden !important;
            overflow-y: auto !important;
            height: auto !important;
            max-height: none !important;
        }

        body:has(.ng-sales-target-page) .fi-layout,
        body:has(.ng-sales-target-page) .fi-main,
        body:has(.ng-sales-target-page) .fi-main-ctn,
        body:has(.ng-sales-target-page) .fi-page,
        body:has(.ng-sales-target-page) .fi-page-content,
        body:has(.ng-sales-target-page) main {
            overflow-x: hidden !important;
            overflow-y: visible !important;
            height: auto !important;
            max-height: none !important;
            min-height: 0 !important;
        }

        body:has(.ng-sales-target-page) .fi-ta-ctn,
        body:has(.ng-sales-target-page) .fi-ta,
        body:has(.ng-sales-target-page) .fi-ta-content,
        body:has(.ng-sales-target-page) .fi-ta-table-wrap,
        body:has(.ng-sales-target-page) .fi-ta-table {
            overflow-x: hidden !important;
            overflow-y: visible !important;
            height: auto !important;
            max-height: none !important;
            min-height: 0 !important;
            scrollbar-width: none !important;
            -ms-overflow-style: none !important;
        }

        body:has(.ng-sales-target-page) .fi-main::-webkit-scrollbar,
        body:has(.ng-sales-target-page) .fi-main-ctn::-webkit-scrollbar,
        body:has(.ng-sales-target-page) .fi-page::-webkit-scrollbar,
        body:has(.ng-sales-target-page) .fi-page-content::-webkit-scrollbar,
        body:has(.ng-sales-target-page) .fi-ta-ctn::-webkit-scrollbar,
        body:has(.ng-sales-target-page) .fi-ta-content::-webkit-scrollbar,
        body:has(.ng-sales-target-page) .fi-ta-table-wrap::-webkit-scrollbar {
            display: none !important;
            width: 0 !important;
            height: 0 !important;
        }

        body:has(.ng-sales-target-page) [class*="overflow-auto"],
        body:has(.ng-sales-target-page) [class*="overflow-y-auto"],
        body:has(.ng-sales-target-page) [class*="overflow-scroll"],
        body:has(.ng-sales-target-page) [class*="overflow-y-scroll"] {
            overflow-y: visible !important;
            overflow-x: hidden !important;
            max-height: none !important;
            scrollbar-width: none !important;
            -ms-overflow-style: none !important;
        }

        body:has(.ng-sales-target-page) [class*="overflow-auto"]::-webkit-scrollbar,
        body:has(.ng-sales-target-page) [class*="overflow-y-auto"]::-webkit-scrollbar,
        body:has(.ng-sales-target-page) [class*="overflow-scroll"]::-webkit-scrollbar,
        body:has(.ng-sales-target-page) [class*="overflow-y-scroll"]::-webkit-scrollbar {
            display: none !important;
            width: 0 !important;
            height: 0 !important;
        }

    

        /* Target Penjualan tetap 3 KPI sesuai kebutuhan sistem */
        .ng-sales-target-kpi-grid {
            grid-template-columns: repeat(3, minmax(0, 1fr)) !important;
        }

        @media (max-width: 1100px) {
            .ng-sales-target-kpi-grid {
                grid-template-columns: repeat(2, minmax(0, 1fr)) !important;
            }
        }

        @media (max-width: 700px) {
            .ng-sales-target-kpi-grid {
                grid-template-columns: 1fr !important;
            }
        }

        /* Filter target dibuat mengikuti ukuran filter Biaya Operasional */
        .ng-target-filter {
            min-width: 340px;
        }

        .ng-target-status-select {
            min-width: 166px;
        }


        /* FINAL TARGET TABLE - MODEL DATA BAWAH IKUT BIAYA OPERASIONAL */
        body:has(.ng-sales-target-page) .fi-ta-selection-cell,
        body:has(.ng-sales-target-page) .fi-ta-checkbox-cell,
        body:has(.ng-sales-target-page) th:has(.fi-checkbox-input),
        body:has(.ng-sales-target-page) td:has(.fi-checkbox-input),
        body:has(.ng-sales-target-page) .fi-checkbox-input,
        body:has(.ng-sales-target-page) .fi-ta-column-manager-trigger,
        body:has(.ng-sales-target-page) button[aria-label*="column" i],
        body:has(.ng-sales-target-page) button[aria-label*="kolom" i] {
            display: none !important;
            width: 0 !important;
            max-width: 0 !important;
            padding: 0 !important;
            margin: 0 !important;
        }

        body:has(.ng-sales-target-page) .fi-ta-ctn {
            width: calc(100% - 48px) !important;
            max-width: calc(100% - 48px) !important;
            margin: 10px 24px 24px !important;
            border-radius: 24px !important;
            overflow: hidden !important;
        }

        body:has(.ng-sales-target-page) .fi-ta-content,
        body:has(.ng-sales-target-page) .fi-ta-table-wrap {
            width: 100% !important;
            max-width: 100% !important;
            overflow-x: hidden !important;
            overflow-y: visible !important;
        }

        body:has(.ng-sales-target-page) .fi-ta-table {
            width: 100% !important;
            max-width: 100% !important;
            min-width: 0 !important;
            table-layout: fixed !important;
        }

        body:has(.ng-sales-target-page) .fi-ta-table th,
        body:has(.ng-sales-target-page) .fi-ta-table td {
            min-width: 0 !important;
            max-width: none !important;
            overflow: hidden !important;
            text-overflow: ellipsis !important;
            padding-left: 12px !important;
            padding-right: 12px !important;
            vertical-align: middle !important;
        }

        /* Kolom data dibuat seperti Biaya Operasional: ringkas, tetap pas dalam widget */
        body:has(.ng-sales-target-page) .fi-ta-table th:nth-child(1),
        body:has(.ng-sales-target-page) .fi-ta-table td:nth-child(1) {
            width: 24% !important;
            max-width: 24% !important;
            padding-left: 16px !important;
        }

        body:has(.ng-sales-target-page) .fi-ta-table th:nth-child(2),
        body:has(.ng-sales-target-page) .fi-ta-table td:nth-child(2) {
            width: 30% !important;
            max-width: 30% !important;
        }

        body:has(.ng-sales-target-page) .fi-ta-table th:nth-child(3),
        body:has(.ng-sales-target-page) .fi-ta-table td:nth-child(3) {
            width: 20% !important;
            max-width: 20% !important;
        }

        body:has(.ng-sales-target-page) .fi-ta-table th:nth-child(4),
        body:has(.ng-sales-target-page) .fi-ta-table td:nth-child(4) {
            width: 20% !important;
            max-width: 20% !important;
        }

        body:has(.ng-sales-target-page) .fi-ta-actions,
        body:has(.ng-sales-target-page) .fi-ta-actions-cell,
        body:has(.ng-sales-target-page) td:has(.fi-ta-actions) {
            width: 58px !important;
            max-width: 58px !important;
            min-width: 58px !important;
            padding-left: 4px !important;
            padding-right: 14px !important;
            overflow: visible !important;
        }

        body:has(.ng-sales-target-page) .fi-ta-actions {
            display: flex !important;
            justify-content: flex-end !important;
        }

        body:has(.ng-sales-target-page) .fi-ta-actions .fi-btn {
            min-width: 36px !important;
            width: 36px !important;
            padding-left: 0 !important;
            padding-right: 0 !important;
            border-radius: 999px !important;
        }

        body:has(.ng-sales-target-page) .fi-ta-text,
        body:has(.ng-sales-target-page) .fi-ta-text-item,
        body:has(.ng-sales-target-page) .fi-ta-text-item-label {
            max-width: 100% !important;
            white-space: normal !important;
            word-break: break-word !important;
            overflow-wrap: anywhere !important;
        }

        body:has(.ng-sales-target-page) .fi-ta-cell .fi-badge {
            max-width: 100% !important;
            white-space: nowrap !important;
        }

        @media (max-width: 1100px) {
            body:has(.ng-sales-target-page) .fi-ta-ctn {
                width: calc(100% - 28px) !important;
                max-width: calc(100% - 28px) !important;
                margin-left: 14px !important;
                margin-right: 14px !important;
            }
        }


        /*
        |--------------------------------------------------------------------------
        | SIDEBAR EFFECT SYNC - TARGET PENJUALAN
        |--------------------------------------------------------------------------
        */

        body:has(.ng-sales-target-page) .fi-sidebar,
        body.ng-sales-target-sidebar-sync .fi-sidebar {
            background: rgba(255, 250, 242, .50) !important;
            border-right: 1px solid rgba(255, 255, 255, .48) !important;
            box-shadow: 18px 0 55px rgba(137, 78, 26, .10) !important;
            backdrop-filter: blur(16px) !important;
            -webkit-backdrop-filter: blur(16px) !important;
        }

        body:has(.ng-sales-target-page) .fi-sidebar-nav,
        body.ng-sales-target-sidebar-sync .fi-sidebar-nav {
            padding: 18px 14px !important;
        }

        body:has(.ng-sales-target-page) .fi-sidebar-item a,
        body:has(.ng-sales-target-page) .fi-sidebar-item-button,
        body.ng-sales-target-sidebar-sync .fi-sidebar-item a,
        body.ng-sales-target-sidebar-sync .fi-sidebar-item-button {
            border-radius: 14px !important;
            color: #6f5844 !important;
            transition: .2s ease !important;
        }

        body:has(.ng-sales-target-page) .fi-sidebar-item-active a,
        body:has(.ng-sales-target-page) .fi-sidebar-item a:hover,
        body:has(.ng-sales-target-page) .fi-sidebar-item-active .fi-sidebar-item-button,
        body:has(.ng-sales-target-page) .fi-sidebar-item .fi-sidebar-item-button:hover,
        body:has(.ng-sales-target-page) .fi-sidebar-item.fi-active a,
        body:has(.ng-sales-target-page) .fi-sidebar-item.fi-active .fi-sidebar-item-button,
        body.ng-sales-target-sidebar-sync .fi-sidebar-item-active a,
        body.ng-sales-target-sidebar-sync .fi-sidebar-item a:hover,
        body.ng-sales-target-sidebar-sync .fi-sidebar-item-active .fi-sidebar-item-button,
        body.ng-sales-target-sidebar-sync .fi-sidebar-item .fi-sidebar-item-button:hover,
        body.ng-sales-target-sidebar-sync .fi-sidebar-item.fi-active a,
        body.ng-sales-target-sidebar-sync .fi-sidebar-item.fi-active .fi-sidebar-item-button {
            background: linear-gradient(135deg, #ff9500, #f26a00) !important;
            color: #fff !important;
            box-shadow: 0 14px 24px rgba(242, 106, 0, .24) !important;
        }

        body:has(.ng-sales-target-page) .fi-sidebar-item-active svg,
        body:has(.ng-sales-target-page) .fi-sidebar-item a:hover svg,
        body:has(.ng-sales-target-page) .fi-sidebar-item-active span,
        body:has(.ng-sales-target-page) .fi-sidebar-item a:hover span,
        body:has(.ng-sales-target-page) .fi-sidebar-item-active .fi-sidebar-item-icon,
        body:has(.ng-sales-target-page) .fi-sidebar-item-active .fi-sidebar-item-label,
        body:has(.ng-sales-target-page) .fi-sidebar-item .fi-sidebar-item-button:hover .fi-sidebar-item-icon,
        body:has(.ng-sales-target-page) .fi-sidebar-item .fi-sidebar-item-button:hover .fi-sidebar-item-label,
        body:has(.ng-sales-target-page) .fi-sidebar-item.fi-active svg,
        body:has(.ng-sales-target-page) .fi-sidebar-item.fi-active span,
        body:has(.ng-sales-target-page) .fi-sidebar-item.fi-active .fi-sidebar-item-icon,
        body:has(.ng-sales-target-page) .fi-sidebar-item.fi-active .fi-sidebar-item-label,
        body.ng-sales-target-sidebar-sync .fi-sidebar-item-active svg,
        body.ng-sales-target-sidebar-sync .fi-sidebar-item a:hover svg,
        body.ng-sales-target-sidebar-sync .fi-sidebar-item-active span,
        body.ng-sales-target-sidebar-sync .fi-sidebar-item a:hover span,
        body.ng-sales-target-sidebar-sync .fi-sidebar-item-active .fi-sidebar-item-icon,
        body.ng-sales-target-sidebar-sync .fi-sidebar-item-active .fi-sidebar-item-label,
        body.ng-sales-target-sidebar-sync .fi-sidebar-item .fi-sidebar-item-button:hover .fi-sidebar-item-icon,
        body.ng-sales-target-sidebar-sync .fi-sidebar-item .fi-sidebar-item-button:hover .fi-sidebar-item-label,
        body.ng-sales-target-sidebar-sync .fi-sidebar-item.fi-active svg,
        body.ng-sales-target-sidebar-sync .fi-sidebar-item.fi-active span,
        body.ng-sales-target-sidebar-sync .fi-sidebar-item.fi-active .fi-sidebar-item-icon,
        body.ng-sales-target-sidebar-sync .fi-sidebar-item.fi-active .fi-sidebar-item-label {
            color: #fff !important;
        }

    </style>

    <script>
        (function () {
            function bindTargetFilter() {
                document.querySelectorAll('.ng-target-select').forEach(function (select) {
                    if (select.dataset.ngBound === '1') {
                        return;
                    }

                    select.dataset.ngBound = '1';

                    select.addEventListener('change', function () {
                        if (! select.value) {
                            return;
                        }

                        window.location.href = select.value;
                    });
                });
            }

            document.addEventListener('DOMContentLoaded', bindTargetFilter);
            document.addEventListener('livewire:navigated', bindTargetFilter);
            document.addEventListener('livewire:update', bindTargetFilter);
            bindTargetFilter();
        })();
    </script>

    <script>
        (function () {
            function syncTargetSidebarClass() {
                document.body.classList.add('ng-sales-target-sidebar-sync');
            }

            document.addEventListener('DOMContentLoaded', syncTargetSidebarClass);
            document.addEventListener('livewire:navigated', syncTargetSidebarClass);
            document.addEventListener('livewire:update', syncTargetSidebarClass);
            syncTargetSidebarClass();
        })();
    </script>

 <?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__attributesOriginalb525200bfa976483b4eaa0b7685c6e24)): ?>
<?php $attributes = $__attributesOriginalb525200bfa976483b4eaa0b7685c6e24; ?>
<?php unset($__attributesOriginalb525200bfa976483b4eaa0b7685c6e24); ?>
<?php endif; ?>
<?php if (isset($__componentOriginalb525200bfa976483b4eaa0b7685c6e24)): ?>
<?php $component = $__componentOriginalb525200bfa976483b4eaa0b7685c6e24; ?>
<?php unset($__componentOriginalb525200bfa976483b4eaa0b7685c6e24); ?>
<?php endif; ?>
<?php /**PATH /var/www/html/resources/views/filament/admin/resources/sales-targets/widgets/sales-target-analytics-widget.blade.php ENDPATH**/ ?>