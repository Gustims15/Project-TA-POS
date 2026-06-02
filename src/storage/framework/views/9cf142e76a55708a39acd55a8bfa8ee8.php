<?php if (isset($component)) { $__componentOriginal166a02a7c5ef5a9331faf66fa665c256 = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginal166a02a7c5ef5a9331faf66fa665c256 = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'filament-panels::components.page.index','data' => []] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('filament-panels::page'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes([]); ?>
<?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::processComponentKey($component); ?>

    <style>
        .revenue-page {
            --primary: #0f766e;
            --primary-2: #14b8a6;
            --primary-3: #10b981;
            --dark: #0f172a;
            --muted: #64748b;
            --soft: #f8fafc;
            --border: #e2e8f0;
            --shadow: 0 18px 45px rgba(15, 23, 42, 0.08);
            --shadow-lg: 0 28px 70px rgba(15, 118, 110, 0.20);
        }

        .revenue-page * {
            box-sizing: border-box;
        }

        .report-hero {
            position: relative;
            overflow: hidden;
            border-radius: 32px;
            padding: 34px;
            background:
                radial-gradient(circle at top right, rgba(255,255,255,0.30), transparent 28%),
                radial-gradient(circle at bottom left, rgba(255,255,255,0.22), transparent 30%),
                linear-gradient(135deg, #0f766e 0%, #0d9488 42%, #10b981 100%);
            box-shadow: var(--shadow-lg);
            color: white;
            isolation: isolate;
        }

        .report-hero::before {
            content: "";
            position: absolute;
            inset: 0;
            background-image:
                linear-gradient(rgba(255,255,255,0.09) 1px, transparent 1px),
                linear-gradient(90deg, rgba(255,255,255,0.09) 1px, transparent 1px);
            background-size: 34px 34px;
            opacity: 0.26;
            z-index: -1;
        }

        .report-hero::after {
            content: "";
            position: absolute;
            width: 340px;
            height: 340px;
            right: -130px;
            bottom: -170px;
            border-radius: 999px;
            background: rgba(255,255,255,0.16);
            filter: blur(4px);
            z-index: -1;
        }

        .hero-content {
            display: grid;
            grid-template-columns: 1fr 360px;
            gap: 26px;
            align-items: end;
        }

        .hero-badge {
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

        .hero-badge-dot {
            width: 9px;
            height: 9px;
            border-radius: 999px;
            background: #bbf7d0;
            box-shadow: 0 0 0 5px rgba(187,247,208,0.22);
        }

        .hero-title {
            margin: 18px 0 0;
            font-size: 38px;
            line-height: 1.05;
            font-weight: 900;
            letter-spacing: -0.04em;
        }

        .hero-desc {
            margin: 14px 0 0;
            max-width: 680px;
            font-size: 15px;
            line-height: 1.75;
            color: rgba(255,255,255,0.86);
        }

        .month-panel {
            border-radius: 24px;
            padding: 18px;
            background: rgba(255,255,255,0.95);
            border: 1px solid rgba(255,255,255,0.58);
            box-shadow: 0 18px 40px rgba(15,23,42,0.16);
            color: var(--dark);
        }

        .month-panel label {
            display: block;
            margin-bottom: 9px;
            color: #334155;
            font-size: 13px;
            font-weight: 800;
        }

        .month-select-wrap {
            position: relative;
        }

        .month-select {
            width: 100%;
            height: 48px;
            border-radius: 16px;
            border: 1px solid #d1d5db;
            background: #ffffff;
            padding: 0 16px;
            color: #0f172a;
            font-size: 14px;
            font-weight: 700;
            outline: none;
            box-shadow: 0 8px 20px rgba(15,23,42,0.06);
        }

        .month-select:focus {
            border-color: var(--primary-2);
            box-shadow: 0 0 0 4px rgba(20,184,166,0.16);
        }

        .month-info {
            margin-top: 12px;
            display: flex;
            align-items: center;
            justify-content: space-between;
            gap: 12px;
            font-size: 12px;
            color: #64748b;
        }

        .month-info strong {
            color: var(--primary);
        }

        .luxury-summary-grid {
            display: grid;
            grid-template-columns: repeat(4, minmax(0, 1fr));
            gap: 18px;
            margin-top: 24px;
        }

        .lux-card {
            position: relative;
            overflow: hidden;
            border-radius: 28px;
            background: white;
            border: 1px solid rgba(226,232,240,0.9);
            padding: 24px;
            box-shadow: var(--shadow);
            min-height: 178px;
            transition: 0.25s ease;
        }

        .lux-card:hover {
            transform: translateY(-5px);
            box-shadow: 0 24px 55px rgba(15,23,42,0.12);
        }

        .lux-card::before {
            content: "";
            position: absolute;
            inset: 0;
            background: linear-gradient(135deg, rgba(255,255,255,0.95), rgba(248,250,252,0.65));
            z-index: 0;
        }

        .lux-card::after {
            content: "";
            position: absolute;
            width: 130px;
            height: 130px;
            top: -54px;
            right: -44px;
            border-radius: 999px;
            opacity: 0.16;
            z-index: 0;
        }

        .lux-card.revenue::after { background: #10b981; }
        .lux-card.orders::after { background: #3b82f6; }
        .lux-card.units::after { background: #f59e0b; }
        .lux-card.average::after { background: #64748b; }

        .lux-card-inner {
            position: relative;
            z-index: 1;
        }

        .lux-card-top {
            display: flex;
            align-items: flex-start;
            justify-content: space-between;
            gap: 14px;
        }

        .lux-label {
            margin: 0;
            color: #64748b;
            font-size: 14px;
            font-weight: 800;
        }

        .lux-icon {
            display: grid;
            place-items: center;
            width: 46px;
            height: 46px;
            border-radius: 16px;
        }

        .lux-icon svg {
            width: 23px;
            height: 23px;
        }

        .revenue .lux-icon { background: #dcfce7; color: #059669; }
        .orders .lux-icon { background: #dbeafe; color: #2563eb; }
        .units .lux-icon { background: #ffedd5; color: #ea580c; }
        .average .lux-icon { background: #f1f5f9; color: #475569; }

        .lux-value {
            margin: 22px 0 0;
            color: #020617;
            font-size: 34px;
            line-height: 1;
            font-weight: 950;
            letter-spacing: -0.05em;
        }

        .lux-caption {
            margin: 14px 0 0;
            display: inline-flex;
            align-items: center;
            gap: 7px;
            border-radius: 999px;
            padding: 7px 11px;
            font-size: 12px;
            font-weight: 800;
        }

        .revenue .lux-caption { background: #ecfdf5; color: #047857; }
        .orders .lux-caption { background: #eff6ff; color: #1d4ed8; }
        .units .lux-caption { background: #fff7ed; color: #c2410c; }
        .average .lux-caption { background: #f8fafc; color: #475569; }

        .table-card {
            margin-top: 24px;
            overflow: hidden;
            border-radius: 30px;
            background: white;
            border: 1px solid rgba(226,232,240,0.9);
            box-shadow: var(--shadow);
        }

        .table-card-header {
            position: relative;
            padding: 24px 28px;
            background:
                linear-gradient(135deg, rgba(15,118,110,0.08), transparent 45%),
                linear-gradient(90deg, #ffffff, #f8fafc);
            border-bottom: 1px solid #e2e8f0;
        }

        .table-card-header-content {
            display: flex;
            align-items: center;
            justify-content: space-between;
            gap: 20px;
        }

        .table-title {
            margin: 0;
            color: #020617;
            font-size: 22px;
            font-weight: 900;
            letter-spacing: -0.03em;
        }

        .table-desc {
            margin: 7px 0 0;
            color: #64748b;
            font-size: 14px;
        }

        .table-pill {
            display: inline-flex;
            align-items: center;
            gap: 9px;
            padding: 12px 16px;
            border-radius: 16px;
            background: #ecfdf5;
            color: #047857;
            font-size: 13px;
            font-weight: 900;
            border: 1px solid #bbf7d0;
            white-space: nowrap;
        }

        .lux-table-wrapper {
            overflow-x: auto;
        }

        .lux-table {
            width: 100%;
            min-width: 920px;
            border-collapse: separate;
            border-spacing: 0;
            font-size: 14px;
        }

        .lux-table thead th {
            padding: 17px 22px;
            background: #f8fafc;
            color: #334155;
            font-size: 12px;
            font-weight: 900;
            letter-spacing: 0.07em;
            text-transform: uppercase;
            text-align: left;
            border-bottom: 1px solid #e2e8f0;
        }

        .lux-table tbody td {
            padding: 18px 22px;
            color: #334155;
            border-bottom: 1px solid #f1f5f9;
            vertical-align: middle;
        }

        .lux-table tbody tr {
            transition: 0.18s ease;
        }

        .lux-table tbody tr:hover {
            background: #f8fafc;
        }

        .order-number {
            display: inline-grid;
            place-items: center;
            width: 34px;
            height: 34px;
            border-radius: 12px;
            background: #f1f5f9;
            color: #475569;
            font-weight: 900;
        }

        .order-code {
            color: #0f172a;
            font-weight: 900;
        }

        .order-date {
            color: #64748b;
            font-weight: 700;
        }

        .item-badge {
            display: inline-flex;
            align-items: center;
            justify-content: center;
            min-width: 42px;
            height: 32px;
            border-radius: 12px;
            background: #eff6ff;
            color: #1d4ed8;
            font-weight: 900;
        }

        .revenue-text {
            color: #0f172a;
            font-size: 15px;
            font-weight: 950;
        }

        .status-badge {
            display: inline-flex;
            align-items: center;
            gap: 7px;
            border-radius: 999px;
            padding: 7px 12px;
            background: #ecfdf5;
            color: #047857;
            border: 1px solid #bbf7d0;
            font-size: 12px;
            font-weight: 900;
        }

        .status-dot {
            width: 7px;
            height: 7px;
            border-radius: 999px;
            background: #10b981;
        }

        .lux-table tfoot td {
            padding: 20px 22px;
            background: linear-gradient(90deg, #ecfdf5, #f0fdfa);
            color: #064e3b;
            font-size: 15px;
            font-weight: 950;
            border-top: 1px solid #bbf7d0;
        }

        .empty-state {
            padding: 60px 24px;
            text-align: center;
        }

        .empty-icon {
            margin: 0 auto 16px;
            display: grid;
            place-items: center;
            width: 68px;
            height: 68px;
            border-radius: 24px;
            background: #f1f5f9;
            color: #94a3b8;
        }

        .empty-title {
            margin: 0;
            color: #334155;
            font-size: 17px;
            font-weight: 900;
        }

        .empty-desc {
            margin: 6px 0 0;
            color: #64748b;
            font-size: 14px;
        }

        @media (max-width: 1100px) {
            .hero-content {
                grid-template-columns: 1fr;
            }

            .luxury-summary-grid {
                grid-template-columns: repeat(2, minmax(0, 1fr));
            }
        }

        @media (max-width: 700px) {
            .report-hero {
                padding: 24px;
                border-radius: 24px;
            }

            .hero-title {
                font-size: 30px;
            }

            .luxury-summary-grid {
                grid-template-columns: 1fr;
            }

            .table-card-header-content {
                align-items: flex-start;
                flex-direction: column;
            }
        }
    </style>

    <div class="revenue-page">
        <div class="report-hero">
            <div class="hero-content">
                <div>
                    <div class="hero-badge">
                        <span class="hero-badge-dot"></span>
                        Ngunjuk POS Report
                    </div>

                    <h2 class="hero-title">
                        Monthly Revenue Analytics
                    </h2>

                    <p class="hero-desc">
                        Pantau histori penjualan bulanan secara terpisah berdasarkan periode.
                        Pilih bulan tertentu untuk melihat ringkasan pendapatan, transaksi,
                        unit terjual, rata-rata order, dan detail order yang sudah selesai.
                    </p>
                </div>

                <form method="GET" action="<?php echo e(request()->url()); ?>" class="month-panel">
                    <label for="month">Pilih Periode Laporan</label>

                    <div class="month-select-wrap">
                        <select
                            id="month"
                            name="month"
                            onchange="this.form.submit()"
                            class="month-select"
                        >
                            <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::openLoop(); ?><?php endif; ?><?php $__currentLoopData = $months; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $month): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::startLoop($loop->index); ?><?php endif; ?>
                                <option value="<?php echo e($month); ?>" <?php if($selectedMonth === $month): echo 'selected'; endif; ?>>
                                    <?php echo e(\Carbon\Carbon::createFromFormat('Y-m', $month)->translatedFormat('F Y')); ?>

                                </option>
                            <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::endLoop(); ?><?php endif; ?><?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::closeLoop(); ?><?php endif; ?>
                        </select>
                    </div>

                    <div class="month-info">
                        <span>Periode aktif</span>
                        <strong><?php echo e($selectedMonthLabel); ?></strong>
                    </div>
                </form>
            </div>
        </div>

        <div class="luxury-summary-grid">
            <div class="lux-card revenue">
                <div class="lux-card-inner">
                    <div class="lux-card-top">
                        <p class="lux-label">Total Revenue</p>
                        <div class="lux-icon">
                            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.8" d="M12 8c-1.657 0-3 1.12-3 2.5S10.343 13 12 13s3 1.12 3 2.5S13.657 18 12 18m0-10V6m0 12v-2m7-4a9 9 0 11-18 0 9 9 0 0118 0z" />
                            </svg>
                        </div>
                    </div>

                    <p class="lux-value">
                        Rp <?php echo e(number_format($summary['total_revenue'], 0, ',', '.')); ?>

                    </p>

                    <p class="lux-caption">
                        Periode <?php echo e($selectedMonthLabel); ?>

                    </p>
                </div>
            </div>

            <div class="lux-card orders">
                <div class="lux-card-inner">
                    <div class="lux-card-top">
                        <p class="lux-label">Total Orders</p>
                        <div class="lux-icon">
                            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.8" d="M3 7h18M6 7V5a2 2 0 012-2h8a2 2 0 012 2v2m-1 4v8a2 2 0 01-2 2H9a2 2 0 01-2-2v-8" />
                            </svg>
                        </div>
                    </div>

                    <p class="lux-value">
                        <?php echo e(number_format($summary['total_orders'], 0, ',', '.')); ?>

                    </p>

                    <p class="lux-caption">
                        Transaksi bulan ini
                    </p>
                </div>
            </div>

            <div class="lux-card units">
                <div class="lux-card-inner">
                    <div class="lux-card-top">
                        <p class="lux-label">Units Sold</p>
                        <div class="lux-icon">
                            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.8" d="M3 17l6-6 4 4 8-8M14 7h7v7" />
                            </svg>
                        </div>
                    </div>

                    <p class="lux-value">
                        <?php echo e(number_format($summary['total_items'], 0, ',', '.')); ?>

                    </p>

                    <p class="lux-caption">
                        Item terjual
                    </p>
                </div>
            </div>

            <div class="lux-card average">
                <div class="lux-card-inner">
                    <div class="lux-card-top">
                        <p class="lux-label">Avg Order</p>
                        <div class="lux-icon">
                            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.8" d="M9 17v-6m4 6V7m4 10v-4M5 21h14a2 2 0 002-2V5a2 2 0 00-2-2H5a2 2 0 00-2 2v14a2 2 0 002 2z" />
                            </svg>
                        </div>
                    </div>

                    <p class="lux-value">
                        Rp <?php echo e(number_format($summary['avg_order'], 0, ',', '.')); ?>

                    </p>

                    <p class="lux-caption">
                        Rata-rata order
                    </p>
                </div>
            </div>
        </div>

        <div class="table-card">
            <div class="table-card-header">
                <div class="table-card-header-content">
                    <div>
                        <h3 class="table-title">
                            Data Order Bulan <?php echo e($selectedMonthLabel); ?>

                        </h3>

                        <p class="table-desc">
                            Data yang ditampilkan hanya transaksi dengan status selesai.
                        </p>
                    </div>

                    <div class="table-pill">
                        Total Data
                        <strong><?php echo e(number_format($summary['total_orders'], 0, ',', '.')); ?></strong>
                    </div>
                </div>
            </div>

            <div class="lux-table-wrapper">
                <table class="lux-table">
                    <thead>
                        <tr>
                            <th>No</th>
                            <th>ID Order</th>
                            <th>Tanggal</th>
                            <th>Total Item</th>
                            <th>Total</th>
                            <th>Status</th>
                        </tr>
                    </thead>

                    <tbody>
                        <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::openLoop(); ?><?php endif; ?><?php $__empty_1 = true; $__currentLoopData = $orders; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $order): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::startLoop($loop->index); ?><?php endif; ?>
                            <?php
                                $date = $order->ordered_at ?? $order->created_at;
                            ?>

                            <tr>
                                <td>
                                    <span class="order-number"><?php echo e($loop->iteration); ?></span>
                                </td>

                                <td>
                                    <span class="order-code">
                                        <?php echo e($order->order_code ?? 'ORD-' . $order->id); ?>

                                    </span>
                                </td>

                                <td>
                                    <span class="order-date">
                                        <?php echo e(\Carbon\Carbon::parse($date)->translatedFormat('d F Y H:i')); ?>

                                    </span>
                                </td>

                                <td>
                                    <span class="item-badge">
                                        <?php echo e(number_format((int) $order->total_item, 0, ',', '.')); ?>

                                    </span>
                                </td>

                                <td>
                                    <span class="revenue-text">
                                        Rp <?php echo e(number_format((int) $order->total_price, 0, ',', '.')); ?>

                                    </span>
                                </td>

                                <td>
                                    <span class="status-badge">
                                        <span class="status-dot"></span>
                                        <?php echo e($order->status); ?>

                                    </span>
                                </td>
                            </tr>
                        <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::endLoop(); ?><?php endif; ?><?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::closeLoop(); ?><?php endif; ?>
                            <tr>
                                <td colspan="6">
                                    <div class="empty-state">
                                        <div class="empty-icon">
                                            <svg xmlns="http://www.w3.org/2000/svg" width="34" height="34" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.6" d="M9 17v-2m3 2v-4m3 4v-6m2 10H7a2 2 0 01-2-2V5a2 2 0 012-2h6.586A2 2 0 0115 3.586L18.414 7A2 2 0 0119 8.414V19a2 2 0 01-2 2z" />
                                            </svg>
                                        </div>

                                        <p class="empty-title">Belum ada data penjualan</p>

                                        <p class="empty-desc">
                                            Tidak ada transaksi selesai pada bulan <?php echo e($selectedMonthLabel); ?>.
                                        </p>
                                    </div>
                                </td>
                            </tr>
                        <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
                    </tbody>

                    <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if($orders->count() > 0): ?>
                        <tfoot>
                            <tr>
                                <td colspan="3" style="text-align: right;">TOTAL</td>
                                <td><?php echo e(number_format($summary['total_items'], 0, ',', '.')); ?></td>
                                <td>Rp <?php echo e(number_format($summary['total_revenue'], 0, ',', '.')); ?></td>
                                <td></td>
                            </tr>
                        </tfoot>
                    <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
                </table>
            </div>
        </div>
    </div>
 <?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__attributesOriginal166a02a7c5ef5a9331faf66fa665c256)): ?>
<?php $attributes = $__attributesOriginal166a02a7c5ef5a9331faf66fa665c256; ?>
<?php unset($__attributesOriginal166a02a7c5ef5a9331faf66fa665c256); ?>
<?php endif; ?>
<?php if (isset($__componentOriginal166a02a7c5ef5a9331faf66fa665c256)): ?>
<?php $component = $__componentOriginal166a02a7c5ef5a9331faf66fa665c256; ?>
<?php unset($__componentOriginal166a02a7c5ef5a9331faf66fa665c256); ?>
<?php endif; ?><?php /**PATH /var/www/html/resources/views/filament/admin/pages/monthly-revenue-report.blade.php ENDPATH**/ ?>