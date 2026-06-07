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

    <style>
        .dashboard-lux-wrapper {
            --primary: #0f766e;
            --primary-light: #14b8a6;
            --emerald: #10b981;
            --dark: #0f172a;
            --muted: #64748b;
            --border: #e2e8f0;
            --soft: #f8fafc;
            margin-bottom: 22px;
        }

        .dashboard-lux-hero {
            position: relative;
            overflow: hidden;
            border-radius: 30px;
            padding: 32px;
            color: white;
            background:
                radial-gradient(circle at top right, rgba(255,255,255,0.32), transparent 28%),
                radial-gradient(circle at bottom left, rgba(255,255,255,0.18), transparent 28%),
                linear-gradient(135deg, #0f766e 0%, #0d9488 45%, #10b981 100%);
            box-shadow: 0 28px 70px rgba(15, 118, 110, 0.22);
            isolation: isolate;
        }

        .dashboard-lux-hero::before {
            content: "";
            position: absolute;
            inset: 0;
            background-image:
                linear-gradient(rgba(255,255,255,0.09) 1px, transparent 1px),
                linear-gradient(90deg, rgba(255,255,255,0.09) 1px, transparent 1px);
            background-size: 34px 34px;
            opacity: 0.24;
            z-index: -1;
        }

        .dashboard-lux-hero-top {
            display: flex;
            align-items: flex-start;
            justify-content: space-between;
            gap: 24px;
        }

        .dashboard-lux-badge {
            display: inline-flex;
            align-items: center;
            gap: 9px;
            width: fit-content;
            padding: 9px 14px;
            border-radius: 999px;
            background: rgba(255,255,255,0.16);
            border: 1px solid rgba(255,255,255,0.25);
            backdrop-filter: blur(10px);
            font-size: 12px;
            font-weight: 800;
            letter-spacing: 0.12em;
            text-transform: uppercase;
        }

        .dashboard-lux-dot {
            width: 9px;
            height: 9px;
            border-radius: 999px;
            background: #bbf7d0;
            box-shadow: 0 0 0 5px rgba(187,247,208,0.22);
        }

        .dashboard-lux-title {
            margin: 16px 0 0;
            font-size: 36px;
            line-height: 1.08;
            font-weight: 950;
            letter-spacing: -0.04em;
        }

        .dashboard-lux-desc {
            margin: 12px 0 0;
            max-width: 800px;
            color: rgba(255,255,255,0.86);
            font-size: 14px;
            line-height: 1.7;
        }

        .dashboard-lux-mini {
            min-width: 260px;
            border-radius: 22px;
            padding: 18px;
            background: rgba(255,255,255,0.16);
            border: 1px solid rgba(255,255,255,0.24);
            backdrop-filter: blur(12px);
        }

        .dashboard-lux-mini span {
            display: block;
            color: rgba(255,255,255,0.78);
            font-size: 12px;
            font-weight: 700;
        }

        .dashboard-lux-mini strong {
            display: block;
            margin-top: 8px;
            color: white;
            font-size: 30px;
            line-height: 1;
            font-weight: 950;
        }

        .dashboard-lux-main-row {
            display: grid;
            grid-template-columns: minmax(0, 1fr) minmax(520px, 620px);
            gap: 18px;
            margin-top: 20px;
            align-items: stretch;
        }

        .dashboard-lux-grid {
            display: grid;
            grid-template-columns: repeat(4, minmax(0, 1fr));
            gap: 16px;
        }

        .dashboard-lux-card {
            position: relative;
            overflow: hidden;
            border-radius: 24px;
            padding: 20px;
            background: white;
            border: 1px solid rgba(226,232,240,0.95);
            box-shadow: 0 16px 40px rgba(15,23,42,0.07);
            min-height: 190px;
            transition: 0.25s ease;
        }

        .dashboard-lux-card:hover {
            transform: translateY(-4px);
            box-shadow: 0 24px 55px rgba(15,23,42,0.12);
        }

        .dashboard-lux-card::after {
            content: "";
            position: absolute;
            width: 118px;
            height: 118px;
            top: -52px;
            right: -42px;
            border-radius: 999px;
            opacity: 0.15;
        }

        .dashboard-lux-card.orders::after { background: #3b82f6; }
        .dashboard-lux-card.units::after { background: #f97316; }
        .dashboard-lux-card.product::after { background: #8b5cf6; }
        .dashboard-lux-card.stock::after { background: #ef4444; }

        .dashboard-lux-label {
            position: relative;
            z-index: 2;
            margin: 0;
            color: #64748b;
            font-size: 13px;
            font-weight: 850;
        }

        .dashboard-lux-value {
            position: relative;
            z-index: 2;
            margin: 18px 0 0;
            color: #020617;
            font-size: 28px;
            line-height: 1;
            font-weight: 950;
            letter-spacing: -0.045em;
        }

        .dashboard-lux-caption {
            position: relative;
            z-index: 2;
            display: inline-flex;
            align-items: center;
            margin-top: 14px;
            border-radius: 999px;
            padding: 7px 11px;
            font-size: 12px;
            font-weight: 800;
        }

        .orders .dashboard-lux-caption { background: #eff6ff; color: #1d4ed8; }
        .units .dashboard-lux-caption { background: #fff7ed; color: #c2410c; }
        .product .dashboard-lux-caption { background: #f5f3ff; color: #6d28d9; }
        .stock .dashboard-lux-caption { background: #fef2f2; color: #b91c1c; }

        .dashboard-trend {
            position: relative;
            z-index: 2;
            display: block;
            margin-top: 10px;
            color: #64748b;
            font-size: 11px;
            font-weight: 800;
            line-height: 1.4;
        }

        .dashboard-trend.up { color: #059669; }
        .dashboard-trend.down { color: #dc2626; }
        .dashboard-trend.neutral { color: #64748b; }

        .kpi-mini-visual {
            position: relative;
            z-index: 2;
            margin-top: 14px;
        }

        .kpi-mini-bars {
            height: 38px;
            display: grid;
            grid-template-columns: repeat(var(--kpi-count), minmax(0, 1fr));
            align-items: end;
            gap: 4px;
        }

        .kpi-mini-bar {
            min-height: 2px;
            border-radius: 6px 6px 2px 2px;
            background: linear-gradient(180deg, #0f766e, #14b8a6);
            opacity: 0.9;
        }

        .kpi-mini-line {
            height: 42px;
            display: grid;
            grid-template-columns: repeat(var(--kpi-count), minmax(0, 1fr));
            align-items: end;
            gap: 4px;
        }

        .kpi-mini-line-point {
            width: 100%;
            min-height: 3px;
            border-radius: 999px;
            background: #0f766e;
            box-shadow: 0 6px 12px rgba(15,118,110,0.18);
        }

        .kpi-stock-track {
            height: 12px;
            border-radius: 999px;
            overflow: hidden;
            display: flex;
            background: #e2e8f0;
        }

        .kpi-stock-safe {
            background: #0f766e;
        }

        .kpi-stock-low {
            background: #f97316;
        }

        .kpi-stock-out {
            background: #dc2626;
        }

        .kpi-stock-legend {
            display: flex;
            align-items: center;
            justify-content: space-between;
            gap: 8px;
            margin-top: 9px;
            color: #64748b;
            font-size: 10px;
            font-weight: 850;
        }

        .metric-lux-card {
            height: 100%;
            min-height: 150px;
            overflow: hidden;
            border-radius: 24px;
            background: white;
            border: 1px solid rgba(226,232,240,0.95);
            box-shadow: 0 16px 40px rgba(15, 23, 42, 0.07);
        }

        .metric-lux-header {
            padding: 16px 18px 10px;
            border-bottom: 0;
            background:
                linear-gradient(135deg, rgba(15,118,110,0.08), transparent 45%),
                linear-gradient(90deg, #ffffff, #f8fafc);
        }

        .metric-lux-title {
            margin: 0;
            color: #020617;
            font-size: 16px;
            font-weight: 950;
            letter-spacing: -0.03em;
        }

        .metric-lux-desc {
            margin: 4px 0 0;
            color: #64748b;
            font-size: 11px;
            line-height: 1.4;
        }

        .metric-lux-body {
            padding: 10px 16px 16px;
            display: flex;
            flex-direction: column;
            gap: 14px;
        }

        .metric-section-block {
            display: flex;
            flex-direction: column;
            gap: 8px;
        }

        .metric-section-label {
            color: #64748b;
            font-size: 10px;
            font-weight: 900;
            text-transform: uppercase;
            letter-spacing: 0.08em;
        }

        .metric-period-grid {
            display: grid;
            grid-template-columns: repeat(5, minmax(0, 1fr));
            gap: 8px;
        }

        .metric-period-link {
            display: inline-flex;
            align-items: center;
            justify-content: center;
            min-height: 38px;
            padding: 8px 10px;
            border-radius: 999px;
            text-decoration: none;
            border: 1px solid #d7e2ea;
            background: #ffffff;
            color: #475569;
            font-size: 11px;
            font-weight: 900;
            text-align: center;
            transition: 0.22s ease;
            box-shadow: 0 4px 14px rgba(15, 23, 42, 0.04);
        }

        .metric-period-link:hover {
            transform: translateY(-2px);
            box-shadow: 0 14px 24px rgba(15, 23, 42, 0.08);
        }

        .metric-period-link.active {
            color: #ffffff;
            border-color: #0f766e;
            background: linear-gradient(135deg, #0f766e, #14b8a6);
            box-shadow: 0 14px 26px rgba(15, 118, 110, 0.22);
        }

        .metric-option-grid {
            display: grid;
            grid-template-columns: repeat(3, minmax(0, 1fr));
            gap: 8px;
        }

        .metric-lux-item {
            display: inline-flex;
            align-items: center;
            justify-content: center;
            min-height: 38px;
            padding: 8px 10px;
            border-radius: 999px;
            text-decoration: none;
            border: 1px solid #d7e2ea;
            background: #ffffff;
            transition: 0.22s ease;
            box-shadow: 0 4px 14px rgba(15, 23, 42, 0.04);
        }

        .metric-lux-item:hover {
            transform: translateY(-3px);
            box-shadow: 0 18px 36px rgba(15,23,42,0.10);
        }

        .metric-lux-item.active {
            background: linear-gradient(135deg, #0f766e, #0d9488);
            border-color: #0f766e;
            box-shadow: 0 18px 40px rgba(15,118,110,0.24);
        }

        .metric-lux-label {
            color: #0f172a;
            font-size: 11px;
            font-weight: 900;
            text-transform: uppercase;
            letter-spacing: 0.04em;
            text-align: center;
        }

        .metric-lux-item.active .metric-lux-label {
            color: white;
        }

        .powerbi-panel-grid {
            display: grid;
            grid-template-columns: minmax(280px, 0.85fr) minmax(0, 2.15fr);
            gap: 18px;
            margin-top: 18px;
            align-items: stretch;
        }

        .powerbi-panel {
            min-height: 420px;
            height: 100%;
            border-radius: 26px;
            padding: 20px;
            background: white;
            border: 1px solid rgba(226,232,240,0.95);
            box-shadow: 0 16px 40px rgba(15,23,42,0.07);
            display: flex;
            flex-direction: column;
        }

        .powerbi-panel-title {
            margin: 0;
            color: #020617;
            font-size: 16px;
            font-weight: 950;
            letter-spacing: -0.03em;
        }

        .powerbi-panel-desc {
            margin: 6px 0 0;
            color: #64748b;
            font-size: 12px;
            line-height: 1.5;
        }

        .powerbi-top-chart {
            position: relative;
            display: grid;
            gap: 12px;
            margin-top: 22px;
            padding: 4px 2px 2px;
            background: transparent !important;
            border: none !important;
            box-shadow: none !important;
        }
        .powerbi-top-row {
            display: grid;
            grid-template-columns: 125px minmax(0, 1fr) 58px;
            align-items: center;
            gap: 12px;
        }

        .powerbi-top-label {
            color: #334155;
            font-size: 12px;
            font-weight: 850;
            line-height: 1.25;
            text-align: right;
            white-space: nowrap;
            overflow: hidden;
            text-overflow: ellipsis;
        }

        .powerbi-top-bar-wrap {
            position: relative;
            width: 100%;
            height: 19px;
        }

        .powerbi-top-bar-bg {
            position: absolute;
            inset: 0;
            border-radius: 3px;
            background:
                linear-gradient(90deg, rgba(148, 163, 184, 0.16) 1px, transparent 1px),
                transparent;
            background-size: 25% 100%;
        }

        .powerbi-top-bar {
            position: relative;
            height: 100%;
            min-width: 7px;
            border-radius: 2px;
            background: #5dade2;
            box-shadow: 0 5px 12px rgba(93, 173, 226, 0.22);
        }

        .powerbi-top-value {
            color: #475569;
            font-size: 12px;
            font-weight: 850;
            white-space: nowrap;
        }

        .powerbi-axis {
            display: grid;
            grid-template-columns: 125px minmax(0, 1fr) 58px;
            gap: 12px;
            margin-top: 8px;
        }

        .powerbi-axis-line {
            grid-column: 2 / 3;
            display: flex;
            justify-content: space-between;
            border-top: 1px solid #e2e8f0;
            padding-top: 6px;
        }

        .powerbi-axis-line span {
            color: #94a3b8;
            font-size: 10px;
            font-weight: 800;
        }

        .revenue-performance-panel {
            overflow: hidden;
        }

        .revenue-wide-chart-box {
            position: relative;
            flex: 1;
            margin-top: 20px;
            min-height: 335px;
            border-radius: 22px;
            padding: 18px 18px 12px;
            background:
                linear-gradient(180deg, rgba(240,253,250,0.9), rgba(255,255,255,1)),
                radial-gradient(circle at top right, rgba(20,184,166,0.12), transparent 32%);
            border: 1px solid #dbeafe;
        }

        .revenue-wide-chart-svg {
            width: 100%;
            height: 300px;
            display: block;
            overflow: visible;
        }

        .revenue-data-label {
            fill: #0f172a;
            font-size: 12px;
            font-weight: 900;
        }

        .revenue-chart-point {
            filter: drop-shadow(0 5px 8px rgba(15, 118, 110, 0.22));
        }

        .revenue-wide-axis {
            display: grid;
            grid-template-columns: repeat(var(--axis-count), minmax(0, 1fr));
            gap: 4px;
            margin-top: 4px;
            padding: 0 10px;
        }

        .revenue-wide-axis span {
            color: #334155;
            font-size: 12px;
            font-weight: 900;
            text-align: center;
            white-space: nowrap;
        }

        .revenue-chart-note {
            margin-top: 10px;
            color: #64748b;
            font-size: 11px;
            font-weight: 750;
            line-height: 1.5;
        }

        .empty-state {
            margin-top: 16px;
            padding: 14px;
            border-radius: 18px;
            background: #f8fafc;
            border: 1px dashed #cbd5e1;
            color: #64748b;
            font-size: 12px;
            font-weight: 700;
            line-height: 1.6;
        }

        @media (max-width: 1500px) {
            .dashboard-lux-main-row {
                grid-template-columns: 1fr;
            }

            .metric-lux-card {
                height: auto;
            }

            .powerbi-panel-grid {
                grid-template-columns: 1fr;
            }

            .powerbi-panel {
                min-height: auto;
            }
        }

        @media (max-width: 1100px) {
            .dashboard-lux-grid {
                grid-template-columns: repeat(2, minmax(0, 1fr));
            }

            .metric-period-grid {
                grid-template-columns: repeat(3, minmax(0, 1fr));
            }
        }

        @media (max-width: 900px) {
            .dashboard-lux-hero-top {
                flex-direction: column;
            }

            .metric-option-grid {
                grid-template-columns: 1fr;
            }

            .metric-period-grid {
                grid-template-columns: repeat(2, minmax(0, 1fr));
            }
        }

        @media (max-width: 640px) {
            .dashboard-lux-hero {
                padding: 24px;
                border-radius: 24px;
            }

            .dashboard-lux-title {
                font-size: 28px;
            }

            .dashboard-lux-grid {
                grid-template-columns: 1fr;
            }

            .powerbi-top-row {
                grid-template-columns: 95px minmax(0, 1fr) 48px;
                gap: 8px;
            }

            .powerbi-top-label {
                font-size: 11px;
            }

            .powerbi-top-value {
                font-size: 11px;
            }

            .powerbi-axis {
                grid-template-columns: 95px minmax(0, 1fr) 48px;
                gap: 8px;
            }

            .revenue-wide-chart-svg {
                height: 240px;
            }

            .revenue-wide-axis span {
                font-size: 10px;
            }

            .metric-period-grid {
                grid-template-columns: 1fr;
            }
        }
    </style>

    <div class="dashboard-lux-wrapper">
        <section class="dashboard-lux-hero">
            <div class="dashboard-lux-hero-top">
                <div>
                    <div class="dashboard-lux-badge">
                        <span class="dashboard-lux-dot"></span>
                        Ngunjuk POS Dashboard
                    </div>

                    <h2 class="dashboard-lux-title">
                        Dashboard POS Ngunjuk
                    </h2>

                    <p class="dashboard-lux-desc">
                        Pantau performa penjualan, transaksi, item terjual, stok produk,
                        insight penjualan, dan kondisi operasional UMKM Ngunjuk berdasarkan periode data yang dipilih.
                    </p>
                </div>

                <div class="dashboard-lux-mini">
                    <span>Revenue <?php echo e($periodLabel); ?></span>
                    <strong>Rp <?php echo e(number_format($summary['period_revenue'], 0, ',', '.')); ?></strong>
                </div>
            </div>
        </section>

        <div class="dashboard-lux-main-row">
            <div class="dashboard-lux-grid">
                <div class="dashboard-lux-card orders">
                    <p class="dashboard-lux-label">Total Orders</p>

                    <p class="dashboard-lux-value">
                        <?php echo e(number_format($summary['period_orders'], 0, ',', '.')); ?>

                    </p>

                    <p class="dashboard-lux-caption"><?php echo e($periodLabel); ?></p>

                    <div
                        class="kpi-mini-visual kpi-mini-bars"
                        style="--kpi-count: <?php echo e(max(count($kpiVisuals['orders']['items']), 1)); ?>;"
                    >
                        <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::openLoop(); ?><?php endif; ?><?php $__currentLoopData = $kpiVisuals['orders']['items']; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $item): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::startLoop($loop->index); ?><?php endif; ?>
                            <div
                                class="kpi-mini-bar"
                                style="height: <?php echo e($item['height']); ?>%;"
                                title="<?php echo e($item['label']); ?> - <?php echo e(number_format((int) $item['value'], 0, ',', '.')); ?> order"
                            ></div>
                        <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::endLoop(); ?><?php endif; ?><?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::closeLoop(); ?><?php endif; ?>
                    </div>

                    <span class="dashboard-trend <?php echo e($trends['orders']['direction']); ?>">
                        <?php echo e($trends['orders']['direction'] === 'up' ? '▲' : ($trends['orders']['direction'] === 'down' ? '▼' : '●')); ?>

                        <?php echo e($trends['orders']['label']); ?>

                    </span>
                </div>

                <div class="dashboard-lux-card units">
                    <p class="dashboard-lux-label">Units Sold</p>

                    <p class="dashboard-lux-value">
                        <?php echo e(number_format($summary['period_units_sold'], 0, ',', '.')); ?>

                    </p>

                    <p class="dashboard-lux-caption"><?php echo e($periodLabel); ?></p>

                    <div
                        class="kpi-mini-visual kpi-mini-bars"
                        style="--kpi-count: <?php echo e(max(count($kpiVisuals['units']['items']), 1)); ?>;"
                    >
                        <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::openLoop(); ?><?php endif; ?><?php $__currentLoopData = $kpiVisuals['units']['items']; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $item): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::startLoop($loop->index); ?><?php endif; ?>
                            <div
                                class="kpi-mini-bar"
                                style="height: <?php echo e($item['height']); ?>%;"
                                title="<?php echo e($item['label']); ?> - <?php echo e(number_format((int) $item['value'], 0, ',', '.')); ?> item"
                            ></div>
                        <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::endLoop(); ?><?php endif; ?><?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::closeLoop(); ?><?php endif; ?>
                    </div>

                    <span class="dashboard-trend <?php echo e($trends['units']['direction']); ?>">
                        <?php echo e($trends['units']['direction'] === 'up' ? '▲' : ($trends['units']['direction'] === 'down' ? '▼' : '●')); ?>

                        <?php echo e($trends['units']['label']); ?>

                    </span>
                </div>

                <div class="dashboard-lux-card product">
                    <p class="dashboard-lux-label">Total Revenue</p>

                    <p class="dashboard-lux-value">
                        Rp <?php echo e(number_format($summary['period_revenue'], 0, ',', '.')); ?>

                    </p>

                    <p class="dashboard-lux-caption"><?php echo e($periodLabel); ?></p>

                    <div
                        class="kpi-mini-visual kpi-mini-line"
                        style="--kpi-count: <?php echo e(max(count($kpiVisuals['revenue']['items']), 1)); ?>;"
                    >
                        <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::openLoop(); ?><?php endif; ?><?php $__currentLoopData = $kpiVisuals['revenue']['items']; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $item): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::startLoop($loop->index); ?><?php endif; ?>
                            <div
                                class="kpi-mini-line-point"
                                style="height: <?php echo e($item['height']); ?>%;"
                                title="<?php echo e($item['label']); ?> - Rp <?php echo e(number_format((int) $item['value'], 0, ',', '.')); ?>"
                            ></div>
                        <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::endLoop(); ?><?php endif; ?><?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::closeLoop(); ?><?php endif; ?>
                    </div>

                    <span class="dashboard-trend <?php echo e($trends['revenue']['direction']); ?>">
                        <?php echo e($trends['revenue']['direction'] === 'up' ? '▲' : ($trends['revenue']['direction'] === 'down' ? '▼' : '●')); ?>

                        <?php echo e($trends['revenue']['label']); ?>

                    </span>
                </div>

                <div class="dashboard-lux-card stock">
                    <p class="dashboard-lux-label">Stock Health</p>

                    <p class="dashboard-lux-value">
                        <?php echo e(number_format($kpiVisuals['stock']['safe'], 1, ',', '.')); ?>%
                    </p>

                    <p class="dashboard-lux-caption">
                        <?php echo e(number_format($summary['total_products'], 0, ',', '.')); ?> produk ·
                        <?php echo e(number_format($summary['out_of_stock_products'], 0, ',', '.')); ?> habis
                    </p>

                    <div class="kpi-mini-visual">
                        <div class="kpi-stock-track">
                            <div
                                class="kpi-stock-safe"
                                style="width: <?php echo e($kpiVisuals['stock']['safe']); ?>%;"
                            ></div>

                            <div
                                class="kpi-stock-low"
                                style="width: <?php echo e($kpiVisuals['stock']['low']); ?>%;"
                            ></div>

                            <div
                                class="kpi-stock-out"
                                style="width: <?php echo e($kpiVisuals['stock']['out']); ?>%;"
                            ></div>
                        </div>

                        <div class="kpi-stock-legend">
                            <span>Aman <?php echo e($kpiVisuals['stock']['safe']); ?>%</span>
                            <span>Low <?php echo e($kpiVisuals['stock']['low']); ?>%</span>
                            <span>Habis <?php echo e($kpiVisuals['stock']['out']); ?>%</span>
                        </div>
                    </div>
                </div>
            </div>

            <div class="metric-lux-card">
                <div class="metric-lux-header">
                    <h3 class="metric-lux-title">
                        Dashboard Metric
                    </h3>

                    <p class="metric-lux-desc">
                        Pilih periode dan metric utama untuk mengubah visualisasi dashboard.
                    </p>
                </div>

                <div class="metric-lux-body">
                    <div class="metric-section-block">
                        <span class="metric-section-label">Periode</span>

                        <div class="metric-period-grid">
                            <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::openLoop(); ?><?php endif; ?><?php $__currentLoopData = $periodOptions; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $periodKey => $periodName): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::startLoop($loop->index); ?><?php endif; ?>
                                <?php
                                    $periodUrl = url('/admin') . '?' . http_build_query([
                                        'period' => $periodKey,
                                        'metric' => $activeMetric,
                                    ]);
                                ?>

                                <a
                                    href="<?php echo e($periodUrl); ?>"
                                    class="metric-period-link <?php echo e($activePeriod === $periodKey ? 'active' : ''); ?>"
                                >
                                    <?php echo e($periodName); ?>

                                </a>
                            <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::endLoop(); ?><?php endif; ?><?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::closeLoop(); ?><?php endif; ?>
                        </div>
                    </div>

                    <div class="metric-section-block">
                        <span class="metric-section-label">Metric</span>

                        <div class="metric-option-grid">
                            <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::openLoop(); ?><?php endif; ?><?php $__currentLoopData = $metrics; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $key => $metric): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::startLoop($loop->index); ?><?php endif; ?>
                                <?php
                                    $isActive = $activeMetric === $key;

                                    $url = url('/admin') . '?' . http_build_query([
                                        'period' => $activePeriod,
                                        'metric' => $key,
                                    ]);
                                ?>

                                <a
                                    href="<?php echo e($url); ?>"
                                    class="metric-lux-item <?php echo e($isActive ? 'active' : ''); ?>"
                                >
                                    <span class="metric-lux-label">
                                        <?php echo e($metric['label']); ?>

                                    </span>
                                </a>
                            <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::endLoop(); ?><?php endif; ?><?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::closeLoop(); ?><?php endif; ?>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="powerbi-panel-grid">
            <div class="powerbi-panel">
                <div>
                    <h3 class="powerbi-panel-title">Top Product Performance</h3>
                    <p class="powerbi-panel-desc">
                        <?php echo e($topProductsChart['title']); ?> pada <?php echo e(strtolower($periodLabel)); ?>.
                    </p>
                </div>

                <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if(count($topProductsChart['items']) > 0): ?>
                    <?php
                        $maxAxisValue = max((float) ($topProductsChart['max_value'] ?? 1), 1);

                        $axisStepOne = $maxAxisValue * 0.25;
                        $axisStepTwo = $maxAxisValue * 0.50;
                        $axisStepThree = $maxAxisValue * 0.75;
                        $axisStepFour = $maxAxisValue;
                    ?>

                    <div class="powerbi-top-chart">
                        <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::openLoop(); ?><?php endif; ?><?php $__currentLoopData = $topProductsChart['items']; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $item): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::startLoop($loop->index); ?><?php endif; ?>
                            <div class="powerbi-top-row">
                                <div class="powerbi-top-label" title="<?php echo e($item['name']); ?>">
                                    <?php echo e($item['name']); ?>

                                </div>

                                <div class="powerbi-top-bar-wrap">
                                    <div class="powerbi-top-bar-bg"></div>

                                    <div
                                        class="powerbi-top-bar"
                                        style="width: <?php echo e(max((float) $item['width'], 3)); ?>%;"
                                    ></div>
                                </div>

                                <div class="powerbi-top-value">
                                    <?php echo e($item['formatted_value']); ?>

                                </div>
                            </div>
                        <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::endLoop(); ?><?php endif; ?><?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::closeLoop(); ?><?php endif; ?>

                        <div class="powerbi-axis">
                            <div></div>

                            <div class="powerbi-axis-line">
                                <span>0</span>
                                <span><?php echo e(number_format($axisStepOne, 0, ',', '.')); ?></span>
                                <span><?php echo e(number_format($axisStepTwo, 0, ',', '.')); ?></span>
                                <span><?php echo e(number_format($axisStepThree, 0, ',', '.')); ?></span>
                                <span><?php echo e(number_format($axisStepFour, 0, ',', '.')); ?></span>
                            </div>

                            <div></div>
                        </div>
                    </div>
                <?php else: ?>
                    <div class="empty-state">
                        Belum ada data produk untuk divisualisasikan pada periode ini.
                    </div>
                <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
            </div>

            <div class="powerbi-panel revenue-performance-panel">
                <div>
                    <h3 class="powerbi-panel-title">Sales Trend Overview</h3>
                    <p class="powerbi-panel-desc">
                        Tren pendapatan <?php echo e(strtolower($periodLabel)); ?> dengan informasi nilai pada setiap periode.
                    </p>
                </div>

                <?php
                    $chartWidth = 860;
                    $chartHeight = 300;
                    $paddingTop = 42;
                    $paddingRight = 26;
                    $paddingBottom = 34;
                    $paddingLeft = 26;

                    $series = $revenueTrendChart['series'] ?? [];

                    $plotWidth = $chartWidth - $paddingLeft - $paddingRight;
                    $plotHeight = $chartHeight - $paddingTop - $paddingBottom;

                    $values = array_map(
                        fn ($item) => (float) ($item['value'] ?? 0),
                        $series
                    );

                    $maxChartValue = count($values) > 0 ? max($values) : 1;
                    $minChartValue = count($values) > 0 ? min($values) : 0;

                    $maxChartValue = max((float) $maxChartValue, 1);
                    $minChartValue = (float) $minChartValue;

                    if ($maxChartValue <= $minChartValue) {
                        $maxChartValue = $minChartValue + 1;
                    }

                    $countSeries = count($series);
                    $stepX = $countSeries > 1 ? ($plotWidth / ($countSeries - 1)) : $plotWidth;

                    $points = [];

                    foreach ($series as $index => $point) {
                        $value = (float) ($point['value'] ?? 0);

                        $x = $paddingLeft + ($index * $stepX);
                        $y = $paddingTop + (($maxChartValue - $value) / ($maxChartValue - $minChartValue)) * $plotHeight;

                        $points[] = [
                            'x' => round($x, 2),
                            'y' => round($y, 2),
                            'value' => $value,
                            'label' => $point['label'] ?? '',
                        ];
                    }

                    $linePath = '';

                    if (count($points) > 0) {
                        $linePath = 'M ' . $points[0]['x'] . ' ' . $points[0]['y'];

                        for ($i = 1; $i < count($points); $i++) {
                            $previous = $points[$i - 1];
                            $current = $points[$i];

                            $controlX = ($previous['x'] + $current['x']) / 2;

                            $linePath .= ' C '
                                . $controlX . ' ' . $previous['y'] . ', '
                                . $controlX . ' ' . $current['y'] . ', '
                                . $current['x'] . ' ' . $current['y'];
                        }
                    }

                    $areaPath = '';

                    if (count($points) > 0) {
                        $baselineY = $paddingTop + $plotHeight;

                        $areaPath = 'M ' . $points[0]['x'] . ' ' . $baselineY . ' ';
                        $areaPath .= 'L ' . $points[0]['x'] . ' ' . $points[0]['y'] . ' ';

                        for ($i = 1; $i < count($points); $i++) {
                            $previous = $points[$i - 1];
                            $current = $points[$i];

                            $controlX = ($previous['x'] + $current['x']) / 2;

                            $areaPath .= 'C '
                                . $controlX . ' ' . $previous['y'] . ', '
                                . $controlX . ' ' . $current['y'] . ', '
                                . $current['x'] . ' ' . $current['y'] . ' ';
                        }

                        $lastPoint = $points[count($points) - 1];
                        $areaPath .= 'L ' . $lastPoint['x'] . ' ' . $baselineY . ' Z';
                    }

                    $gridLines = 4;

                    $formatRevenueLabel = function (float $value): string {
                        if ($value >= 1000000) {
                            return 'Rp ' . number_format($value / 1000000, 1, ',', '.') . 'Jt';
                        }

                        if ($value >= 1000) {
                            return 'Rp ' . number_format($value / 1000, 0, ',', '.') . 'Rb';
                        }

                        return 'Rp ' . number_format($value, 0, ',', '.');
                    };
                ?>

                <div class="revenue-wide-chart-box">
                    <svg
                        class="revenue-wide-chart-svg"
                        viewBox="0 0 <?php echo e($chartWidth); ?> <?php echo e($chartHeight); ?>"
                        preserveAspectRatio="none"
                    >
                        <defs>
                            <linearGradient id="revenueAreaGradient" x1="0" x2="0" y1="0" y2="1">
                                <stop offset="0%" stop-color="#0f766e" stop-opacity="0.38" />
                                <stop offset="100%" stop-color="#0f766e" stop-opacity="0.10" />
                            </linearGradient>
                        </defs>

                        <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php for($i = 0; $i <= $gridLines; $i++): ?>
                            <?php
                                $y = $paddingTop + (($plotHeight / $gridLines) * $i);
                            ?>

                            <line
                                x1="<?php echo e($paddingLeft); ?>"
                                y1="<?php echo e($y); ?>"
                                x2="<?php echo e($chartWidth - $paddingRight); ?>"
                                y2="<?php echo e($y); ?>"
                                stroke="#e2e8f0"
                                stroke-width="1"
                            />
                        <?php endfor; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>

                        <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if($areaPath !== ''): ?>
                            <path
                                d="<?php echo e($areaPath); ?>"
                                fill="url(#revenueAreaGradient)"
                            />
                        <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>

                        <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if($linePath !== ''): ?>
                            <path
                                d="<?php echo e($linePath); ?>"
                                fill="none"
                                stroke="#064e3b"
                                stroke-width="5"
                                stroke-linecap="round"
                                stroke-linejoin="round"
                            />
                        <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>

                        <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::openLoop(); ?><?php endif; ?><?php $__currentLoopData = $points; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $point): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::startLoop($loop->index); ?><?php endif; ?>
                            <?php
                                $labelY = $point['y'] - 14;

                                if ($labelY < 14) {
                                    $labelY = $point['y'] + 24;
                                }
                            ?>

                            <circle
                                class="revenue-chart-point"
                                cx="<?php echo e($point['x']); ?>"
                                cy="<?php echo e($point['y']); ?>"
                                r="7"
                                fill="#064e3b"
                                stroke="#ffffff"
                                stroke-width="3"
                            />

                            <text
                                x="<?php echo e($point['x']); ?>"
                                y="<?php echo e($labelY); ?>"
                                text-anchor="middle"
                                class="revenue-data-label"
                            >
                                <?php echo e($formatRevenueLabel($point['value'])); ?>

                            </text>
                        <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::endLoop(); ?><?php endif; ?><?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::closeLoop(); ?><?php endif; ?>
                    </svg>

                    <div
                        class="revenue-wide-axis"
                        style="--axis-count: <?php echo e(max(count($series), 1)); ?>;"
                    >
                        <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::openLoop(); ?><?php endif; ?><?php $__currentLoopData = $series; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $point): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::startLoop($loop->index); ?><?php endif; ?>
                            <span><?php echo e($point['label']); ?></span>
                        <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::endLoop(); ?><?php endif; ?><?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::closeLoop(); ?><?php endif; ?>
                    </div>

                    <div class="revenue-chart-note">
                        Grafik menampilkan perkembangan revenue berdasarkan periode aktif yang dipilih pada filter dashboard.
                    </div>
                </div>
            </div>
        </div>
    </div>
 <?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__attributesOriginalb525200bfa976483b4eaa0b7685c6e24)): ?>
<?php $attributes = $__attributesOriginalb525200bfa976483b4eaa0b7685c6e24; ?>
<?php unset($__attributesOriginalb525200bfa976483b4eaa0b7685c6e24); ?>
<?php endif; ?>
<?php if (isset($__componentOriginalb525200bfa976483b4eaa0b7685c6e24)): ?>
<?php $component = $__componentOriginalb525200bfa976483b4eaa0b7685c6e24; ?>
<?php unset($__componentOriginalb525200bfa976483b4eaa0b7685c6e24); ?>
<?php endif; ?><?php /**PATH /var/www/html/resources/views/filament/admin/widgets/dashboard-luxury-overview-widget.blade.php ENDPATH**/ ?>