<?php
    $cards = [
        [
            'label' => 'Biaya Bulan Ini',
            'value' => $this->rupiah($summary['monthly_cost'] ?? 0),
            'caption' => 'Termasuk sewa tahunan / 12',
            'icon' => '▣',
            'color' => '#f97316',
        ],
        [
            'label' => 'Total Biaya',
            'value' => number_format((int) ($summary['total_costs'] ?? 0), 0, ',', '.'),
            'caption' => 'Semua data biaya',
            'icon' => '∑',
            'color' => '#3b82f6',
        ],
        [
            'label' => 'Biaya Aktif',
            'value' => number_format((int) ($summary['active_costs'] ?? 0), 0, ',', '.'),
            'caption' => 'Masuk dashboard finance',
            'icon' => '✓',
            'color' => '#10b981',
        ],
        [
            'label' => 'Biaya Nonaktif',
            'value' => number_format((int) ($summary['inactive_costs'] ?? 0), 0, ',', '.'),
            'caption' => 'Tidak dihitung',
            'icon' => '!',
            'color' => '#ef4444',
        ],
        [
            'label' => 'Biaya Terbesar',
            'value' => $this->rupiah($summary['highest_cost_amount'] ?? 0),
            'caption' => $summary['highest_cost_name'] ?? '-',
            'icon' => '◇',
            'color' => '#8b5cf6',
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

    <div class="ng-operational-page">
        <section class="ng-op-hero-grid">
            <article class="ng-widget-card ng-op-hero-card">
                <div class="ng-widget-head">
                    <div>
                        <h1>Biaya Operasional</h1>
                        <p>
                            Kelola seluruh pengeluaran usaha seperti sewa tempat, listrik, air, wifi,
                            gaji karyawan, promosi, maintenance, dan biaya lainnya.
                        </p>
                    </div>
                </div>
            </article>

            <article class="ng-widget-card ng-op-highlight-card">
                <div class="ng-highlight-info">
                    <span>Biaya Terbesar</span>
                    <strong><?php echo e($summary['highest_cost_name'] ?? '-'); ?></strong>
                    <small><?php echo e($this->rupiah($summary['highest_cost_amount'] ?? 0)); ?></small>
                </div>

                <div class="ng-highlight-actions">
                    <a href="<?php echo e($dashboardUrl); ?>" class="ng-soft-button">
                        Dashboard
                    </a>

                    <a href="<?php echo e($createUrl); ?>" class="ng-primary-button">
                        + New Biaya
                    </a>
                </div>
            </article>
        </section>

        <section class="ng-kpi-grid ng-operational-kpi-grid">
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

        body:has(.ng-operational-page) {
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

        body:has(.ng-operational-page) .fi-main,
        body:has(.ng-operational-page) .fi-main-ctn,
        body:has(.ng-operational-page) .fi-page,
        body:has(.ng-operational-page) .fi-page-content {
            width: 100% !important;
            max-width: 100% !important;
            background: transparent !important;
            overflow-x: hidden !important;
        }

        body:has(.ng-operational-page) .fi-page {
            padding: 0 !important;
        }

        body:has(.ng-operational-page) .fi-page-header {
            display: none !important;
        }

        body:has(.ng-operational-page) .fi-main {
            padding: 0 !important;
        }

        body:has(.ng-operational-page) .fi-page-content {
            gap: 0 !important;
            row-gap: 0 !important;
        }

        body:has(.ng-operational-page) .fi-wi,
        body:has(.ng-operational-page) .fi-wi-widget,
        body:has(.ng-operational-page) .fi-wi-widget-content,
        body:has(.ng-operational-page) .fi-wi-widgets,
        body:has(.ng-operational-page) .fi-wi-widgets > * {
            margin: 0 !important;
            padding: 0 !important;
            background: transparent !important;
            border: none !important;
            box-shadow: none !important;
        }

        .ng-operational-page {
            width: 100% !important;
            max-width: 100% !important;
            padding: 24px 24px 10px !important;
            overflow: hidden !important;
            font-family: Inter, Poppins, ui-sans-serif, system-ui, -apple-system, BlinkMacSystemFont, "Segoe UI", sans-serif;
            color: #24180f;
        }

        .ng-operational-page * {
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
            align-items: flex-start;
            justify-content: space-between;
            gap: 14px;
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

        .ng-kpi-grid {
            display: grid;
            grid-template-columns: repeat(5, minmax(0, 1fr));
            gap: 14px;
            margin-bottom: 14px;
        }

        .ng-kpi-card {
            min-height: 108px;
            display: flex;
            gap: 12px;
            padding: 16px 15px;
            border-radius: 22px;
        }

        .ng-kpi-icon {
            position: relative;
            z-index: 1;
            display: grid;
            place-items: center;
            flex: 0 0 auto;
            width: 44px;
            height: 44px;
            border-radius: 15px;
            color: #fff;
            background: linear-gradient(135deg, var(--accent), #d95d00);
            box-shadow: 0 15px 28px rgba(249, 115, 22, .22);
            font-size: 17px;
            font-weight: 950;
        }

        .ng-kpi-content {
            position: relative;
            z-index: 1;
            min-width: 0;
            flex: 1;
        }

        .ng-kpi-label {
            display: flex;
            align-items: center;
            justify-content: space-between;
            gap: 8px;
            color: #6f5946;
            font-size: 12px;
            line-height: 1.2;
            font-weight: 900;
            text-transform: uppercase;
            letter-spacing: .06em;
        }

        .ng-kpi-content strong {
            display: block;
            margin-top: 7px;
            color: #23160d;
            font-size: 22px;
            line-height: 1.15;
            font-weight: 950;
            letter-spacing: -.03em;
            white-space: nowrap;
            overflow: hidden;
            text-overflow: ellipsis;
        }

        .ng-kpi-content p {
            margin: 8px 0 0;
            color: #6f5946;
            font-size: 11px;
            line-height: 1.25;
            font-weight: 850;
            white-space: nowrap;
            overflow: hidden;
            text-overflow: ellipsis;
        }

        .ng-category-grid {
            display: grid;
            grid-template-columns: repeat(5, minmax(0, 1fr));
            gap: 14px;
            margin-bottom: 0;
        }

        .ng-mini-card {
            position: relative;
            overflow: hidden;
            min-height: 76px;
            display: grid;
            align-content: center;
            gap: 8px;
            padding: 13px 15px;
            border-radius: 20px;
            border: 1px solid rgba(255, 255, 255, .48);
            background:
                linear-gradient(145deg, rgba(255, 255, 255, .34), rgba(255, 246, 231, .18)),
                radial-gradient(circle at 100% 0%, rgba(255, 153, 30, .12), transparent 38%) !important;
            box-shadow:
                0 18px 42px rgba(101, 58, 21, .09),
                inset 0 1px 0 rgba(255, 255, 255, .50);
            backdrop-filter: blur(13px);
            -webkit-backdrop-filter: blur(13px);
        }

        .ng-mini-card span,
        .ng-mini-card strong {
            position: relative;
            z-index: 2;
            display: block;
            min-width: 0;
            white-space: nowrap;
            overflow: hidden;
            text-overflow: ellipsis;
        }

        .ng-mini-card span {
            color: #765d45;
            font-size: 11px;
            line-height: 1.2;
            font-weight: 900;
        }

        .ng-mini-card strong {
            color: #d95d00;
            font-size: 17px;
            line-height: 1.15;
            font-weight: 950;
            letter-spacing: -.03em;
        }

        /*
        |--------------------------------------------------------------------------
        | TABLE FILAMENT - DISAMAKAN DENGAN RASA DASHBOARD KEUANGAN
        |--------------------------------------------------------------------------
        */

        body:has(.ng-operational-page) .fi-ta-ctn {
            margin: 0 24px 24px !important;
            width: calc(100% - 48px) !important;
            border-radius: 24px !important;
            border: 1px solid rgba(255, 255, 255, .58) !important;
            background:
                linear-gradient(145deg, rgba(255, 255, 255, .34), rgba(255, 246, 231, .18)),
                radial-gradient(circle at 100% 0%, rgba(255, 153, 30, .12), transparent 38%) !important;
            box-shadow:
                0 22px 54px rgba(101, 58, 21, .12),
                0 0 0 1px rgba(255, 255, 255, .12) inset,
                inset 0 1px 0 rgba(255, 255, 255, .54) !important;
            backdrop-filter: blur(14px) !important;
            -webkit-backdrop-filter: blur(14px) !important;
            overflow: hidden !important;
        }

        body:has(.ng-operational-page) .fi-section,
        body:has(.ng-operational-page) .fi-ta,
        body:has(.ng-operational-page) .fi-ta-content,
        body:has(.ng-operational-page) .fi-ta-table,
        body:has(.ng-operational-page) .fi-ta-ctn > div,
        body:has(.ng-operational-page) .fi-ta-ctn > div > div,
        body:has(.ng-operational-page) .fi-ta-ctn > div > div > div,
        body:has(.ng-operational-page) table,
        body:has(.ng-operational-page) thead,
        body:has(.ng-operational-page) tbody,
        body:has(.ng-operational-page) tr,
        body:has(.ng-operational-page) th,
        body:has(.ng-operational-page) td {
            background: transparent !important;
            box-shadow: none !important;
        }

        body:has(.ng-operational-page) .fi-ta-header,
        body:has(.ng-operational-page) .fi-ta-toolbar {
            min-height: 46px !important;
            padding: 8px 16px !important;
            background: rgba(255, 247, 235, .10) !important;
            border-bottom: 1px solid rgba(114, 74, 41, .08) !important;
        }

        body:has(.ng-operational-page) .fi-ta-header-cell {
            padding-top: 10px !important;
            padding-bottom: 10px !important;
            background: rgba(255, 255, 255, .10) !important;
            border-color: rgba(114, 74, 41, .08) !important;
        }

        body:has(.ng-operational-page) .fi-ta-header-cell-label {
            color: #4b3525 !important;
            font-size: 12px !important;
            font-weight: 950 !important;
        }

        body:has(.ng-operational-page) .fi-ta-row {
            min-height: 54px !important;
            border-bottom: 1px solid rgba(114, 74, 41, .08) !important;
            background: rgba(255, 247, 235, .04) !important;
            transition: .18s ease !important;
        }

        body:has(.ng-operational-page) .fi-ta-row:hover {
            background: rgba(255, 255, 255, .14) !important;
        }

        body:has(.ng-operational-page) .fi-ta-cell {
            padding-top: 10px !important;
            padding-bottom: 10px !important;
            border-color: rgba(114, 74, 41, .08) !important;
            background: transparent !important;
        }

        body:has(.ng-operational-page) .fi-ta-text,
        body:has(.ng-operational-page) .fi-ta-text-item,
        body:has(.ng-operational-page) .fi-ta-cell span,
        body:has(.ng-operational-page) .fi-ta-cell div {
            color: #2d1f16;
        }

        body:has(.ng-operational-page) .fi-ta-pagination,
        body:has(.ng-operational-page) .fi-pagination {
            min-height: 48px !important;
            padding: 8px 16px !important;
            background: rgba(255, 247, 235, .10) !important;
            border-top: 1px solid rgba(114, 74, 41, .08) !important;
        }

        body:has(.ng-operational-page) .fi-input-wrp,
        body:has(.ng-operational-page) .fi-ta-search-field .fi-input-wrp,
        body:has(.ng-operational-page) .fi-select-input {
            min-height: 38px !important;
            border-radius: 16px !important;
            background: rgba(255, 255, 255, .28) !important;
            border-color: rgba(255, 255, 255, .42) !important;
            box-shadow: inset 0 1px 0 rgba(255, 255, 255, .36) !important;
            backdrop-filter: blur(10px) !important;
            -webkit-backdrop-filter: blur(10px) !important;
        }

        body:has(.ng-operational-page) .fi-ta-search-field {
            max-width: 280px !important;
        }

        body:has(.ng-operational-page) .fi-btn {
            border-radius: 14px !important;
            font-weight: 900 !important;
        }

        body:has(.ng-operational-page) .fi-btn-color-primary,
        body:has(.ng-operational-page) .fi-btn-color-warning {
            background: linear-gradient(135deg, #ff9d18, #ee6500) !important;
            box-shadow: 0 12px 22px rgba(238, 101, 0, .22) !important;
        }

        body:has(.ng-operational-page) .fi-btn-color-primary:hover,
        body:has(.ng-operational-page) .fi-btn-color-warning:hover {
            box-shadow: 0 16px 28px rgba(238, 101, 0, .28) !important;
        }

        /*
        |--------------------------------------------------------------------------
        | SIDEBAR EFFECT SYNC - FINANCE PAGES
        |--------------------------------------------------------------------------
        */

        body:has(.ng-finance-dashboard) .fi-sidebar,
        body:has(.ng-operational-page) .fi-sidebar,
        body:has(.ng-operational-form-page) .fi-sidebar,
        body:has(.ng-sales-target-page) .fi-sidebar,
        body:has(.ng-sales-target-form-page) .fi-sidebar {
            background: rgba(255, 250, 242, .50) !important;
            border-right: 1px solid rgba(255, 255, 255, .48) !important;
            box-shadow: 18px 0 55px rgba(137, 78, 26, .10) !important;
            backdrop-filter: blur(16px) !important;
            -webkit-backdrop-filter: blur(16px) !important;
        }

        body:has(.ng-finance-dashboard) .fi-sidebar-nav,
        body:has(.ng-operational-page) .fi-sidebar-nav,
        body:has(.ng-operational-form-page) .fi-sidebar-nav,
        body:has(.ng-sales-target-page) .fi-sidebar-nav,
        body:has(.ng-sales-target-form-page) .fi-sidebar-nav {
            padding: 18px 14px !important;
        }

        body:has(.ng-finance-dashboard) .fi-sidebar-item a,
        body:has(.ng-operational-page) .fi-sidebar-item a,
        body:has(.ng-operational-form-page) .fi-sidebar-item a,
        body:has(.ng-sales-target-page) .fi-sidebar-item a,
        body:has(.ng-sales-target-form-page) .fi-sidebar-item a {
            border-radius: 14px !important;
            color: #6f5844 !important;
            transition: .2s ease !important;
        }

        body:has(.ng-finance-dashboard) .fi-sidebar-item-active a,
        body:has(.ng-finance-dashboard) .fi-sidebar-item a:hover,
        body:has(.ng-operational-page) .fi-sidebar-item-active a,
        body:has(.ng-operational-page) .fi-sidebar-item a:hover,
        body:has(.ng-operational-form-page) .fi-sidebar-item-active a,
        body:has(.ng-operational-form-page) .fi-sidebar-item a:hover,
        body:has(.ng-sales-target-page) .fi-sidebar-item-active a,
        body:has(.ng-sales-target-page) .fi-sidebar-item a:hover,
        body:has(.ng-sales-target-form-page) .fi-sidebar-item-active a,
        body:has(.ng-sales-target-form-page) .fi-sidebar-item a:hover {
            background: linear-gradient(135deg, #ff9500, #f26a00) !important;
            color: #fff !important;
            box-shadow: 0 14px 24px rgba(242, 106, 0, .24) !important;
        }

        body:has(.ng-finance-dashboard) .fi-sidebar-item-active svg,
        body:has(.ng-finance-dashboard) .fi-sidebar-item a:hover svg,
        body:has(.ng-operational-page) .fi-sidebar-item-active svg,
        body:has(.ng-operational-page) .fi-sidebar-item a:hover svg,
        body:has(.ng-operational-form-page) .fi-sidebar-item-active svg,
        body:has(.ng-operational-form-page) .fi-sidebar-item a:hover svg,
        body:has(.ng-sales-target-page) .fi-sidebar-item-active svg,
        body:has(.ng-sales-target-page) .fi-sidebar-item a:hover svg,
        body:has(.ng-sales-target-form-page) .fi-sidebar-item-active svg,
        body:has(.ng-sales-target-form-page) .fi-sidebar-item a:hover svg,
        body:has(.ng-finance-dashboard) .fi-sidebar-item-active span,
        body:has(.ng-finance-dashboard) .fi-sidebar-item a:hover span,
        body:has(.ng-operational-page) .fi-sidebar-item-active span,
        body:has(.ng-operational-page) .fi-sidebar-item a:hover span,
        body:has(.ng-operational-form-page) .fi-sidebar-item-active span,
        body:has(.ng-operational-form-page) .fi-sidebar-item a:hover span,
        body:has(.ng-sales-target-page) .fi-sidebar-item-active span,
        body:has(.ng-sales-target-page) .fi-sidebar-item a:hover span,
        body:has(.ng-sales-target-form-page) .fi-sidebar-item-active span,
        body:has(.ng-sales-target-form-page) .fi-sidebar-item a:hover span {
            color: #fff !important;
        }

        @media (max-width: 1500px) {
            .ng-op-hero-grid {
                grid-template-columns: 1fr;
            }

            .ng-kpi-grid,
            .ng-category-grid {
                grid-template-columns: repeat(3, minmax(0, 1fr));
            }
        }

        @media (max-width: 1100px) {
            .ng-operational-page {
                padding: 18px 18px 10px !important;
            }

            .ng-kpi-grid,
            .ng-category-grid {
                grid-template-columns: 1fr;
            }

            .ng-op-highlight-card {
                align-items: flex-start;
                flex-direction: column;
            }

            .ng-highlight-actions {
                justify-content: flex-start;
            }

            body:has(.ng-operational-page) .fi-ta-ctn {
                margin: 0 18px 22px !important;
                width: calc(100% - 36px) !important;
            }
        }

        @media (max-width: 640px) {
            .ng-operational-page {
                padding: 14px 14px 8px !important;
            }

            .ng-widget-head h1 {
                font-size: 26px;
            }

            .ng-widget-card {
                padding: 16px;
                border-radius: 22px;
            }

            .ng-kpi-card {
                min-height: 104px;
            }

            body:has(.ng-operational-page) .fi-ta-ctn {
                margin: 0 14px 20px !important;
                width: calc(100% - 28px) !important;
            }
        }

        /*
        |--------------------------------------------------------------------------
        | HIDE CATEGORY BREAKDOWN MINI CARDS
        |--------------------------------------------------------------------------
        | Menghilangkan kotak kecil kategori biaya:
        | Maintenance, Sewa Tempat, Gaji Karyawan, Listrik, Wifi / Internet.
        */

        body:has(.ng-operational-page) .ng-category-grid,
        body:has(.ng-operational-page) .ng-mini-card {
            display: none !important;
            visibility: hidden !important;
            height: 0 !important;
            min-height: 0 !important;
            max-height: 0 !important;
            margin: 0 !important;
            padding: 0 !important;
            overflow: hidden !important;
            pointer-events: none !important;
        }


    </style>
 <?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__attributesOriginalb525200bfa976483b4eaa0b7685c6e24)): ?>
<?php $attributes = $__attributesOriginalb525200bfa976483b4eaa0b7685c6e24; ?>
<?php unset($__attributesOriginalb525200bfa976483b4eaa0b7685c6e24); ?>
<?php endif; ?>
<?php if (isset($__componentOriginalb525200bfa976483b4eaa0b7685c6e24)): ?>
<?php $component = $__componentOriginalb525200bfa976483b4eaa0b7685c6e24; ?>
<?php unset($__componentOriginalb525200bfa976483b4eaa0b7685c6e24); ?>
<?php endif; ?><?php /**PATH /var/www/html/resources/views/filament/admin/resources/operational-costs/widgets/operational-cost-analytics-widget.blade.php ENDPATH**/ ?>