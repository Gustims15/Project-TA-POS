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
        .order-detail-page {
            --primary: #0f766e;
            --primary-2: #14b8a6;
            --emerald: #10b981;
            --dark: #0f172a;
            --muted: #64748b;
            --border: #e2e8f0;
            --soft: #f8fafc;
            --shadow: 0 18px 45px rgba(15, 23, 42, 0.08);
            --shadow-lg: 0 28px 70px rgba(15, 118, 110, 0.20);
        }

        .detail-hero {
            position: relative;
            overflow: hidden;
            border-radius: 32px;
            padding: 34px;
            color: white;
            background:
                radial-gradient(circle at top right, rgba(255,255,255,0.30), transparent 28%),
                radial-gradient(circle at bottom left, rgba(255,255,255,0.22), transparent 30%),
                linear-gradient(135deg, #0f766e 0%, #0d9488 45%, #10b981 100%);
            box-shadow: var(--shadow-lg);
            isolation: isolate;
        }

        .detail-hero::before {
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

        .detail-hero-grid {
            display: grid;
            grid-template-columns: 1fr 320px;
            gap: 26px;
            align-items: end;
        }

        .detail-badge {
            display: inline-flex;
            align-items: center;
            gap: 9px;
            width: fit-content;
            padding: 9px 14px;
            border-radius: 999px;
            background: rgba(255,255,255,0.16);
            border: 1px solid rgba(255,255,255,0.25);
            font-size: 12px;
            font-weight: 900;
            letter-spacing: 0.12em;
            text-transform: uppercase;
        }

        .detail-badge-dot {
            width: 9px;
            height: 9px;
            border-radius: 999px;
            background: #bbf7d0;
            box-shadow: 0 0 0 5px rgba(187,247,208,0.22);
        }

        .detail-title {
            margin: 18px 0 0;
            font-size: 38px;
            line-height: 1.05;
            font-weight: 950;
            letter-spacing: -0.04em;
        }

        .detail-desc {
            margin: 14px 0 0;
            max-width: 720px;
            color: rgba(255,255,255,0.86);
            font-size: 15px;
            line-height: 1.75;
        }

        .hero-status-card {
            border-radius: 24px;
            padding: 20px;
            background: rgba(255,255,255,0.16);
            border: 1px solid rgba(255,255,255,0.24);
            backdrop-filter: blur(12px);
        }

        .hero-status-label {
            display: block;
            color: rgba(255,255,255,0.78);
            font-size: 12px;
            font-weight: 800;
            text-transform: uppercase;
            letter-spacing: 0.08em;
        }

        .hero-status-value {
            display: inline-flex;
            align-items: center;
            gap: 9px;
            margin-top: 10px;
            border-radius: 999px;
            padding: 9px 13px;
            background: rgba(255,255,255,0.92);
            font-size: 13px;
            font-weight: 900;
        }

        .hero-status-dot {
            width: 8px;
            height: 8px;
            border-radius: 999px;
        }

        .detail-summary-grid {
            display: grid;
            grid-template-columns: repeat(4, minmax(0, 1fr));
            gap: 18px;
            margin-top: 24px;
        }

        .summary-card {
            position: relative;
            overflow: hidden;
            border-radius: 28px;
            background: white;
            border: 1px solid rgba(226,232,240,0.95);
            padding: 24px;
            box-shadow: var(--shadow);
            min-height: 160px;
        }

        .summary-label {
            margin: 0;
            color: #64748b;
            font-size: 13px;
            font-weight: 900;
        }

        .summary-value {
            margin: 20px 0 0;
            color: #020617;
            font-size: 27px;
            line-height: 1.1;
            font-weight: 950;
            letter-spacing: -0.045em;
            word-break: break-word;
        }

        .summary-caption {
            display: inline-flex;
            margin-top: 13px;
            border-radius: 999px;
            padding: 7px 11px;
            font-size: 12px;
            font-weight: 850;
            background: #f8fafc;
            color: #64748b;
        }

        .detail-main-grid {
            display: grid;
            grid-template-columns: 0.85fr 1.15fr;
            gap: 24px;
            margin-top: 24px;
        }

        .lux-panel {
            overflow: hidden;
            border-radius: 30px;
            background: white;
            border: 1px solid rgba(226,232,240,0.95);
            box-shadow: var(--shadow);
        }

        .lux-panel-header {
            padding: 23px 26px;
            border-bottom: 1px solid #e2e8f0;
            background:
                linear-gradient(135deg, rgba(15,118,110,0.08), transparent 45%),
                linear-gradient(90deg, #ffffff, #f8fafc);
        }

        .lux-panel-title {
            margin: 0;
            color: #020617;
            font-size: 20px;
            font-weight: 950;
        }

        .lux-panel-desc {
            margin: 7px 0 0;
            color: #64748b;
            font-size: 13px;
        }

        .info-list {
            padding: 22px 26px 26px;
            display: grid;
            gap: 16px;
        }

        .info-row {
            display: flex;
            justify-content: space-between;
            gap: 18px;
            padding: 16px;
            border-radius: 20px;
            background: #f8fafc;
            border: 1px solid #edf2f7;
        }

        .info-row span {
            color: #64748b;
            font-size: 13px;
            font-weight: 800;
        }

        .info-row strong {
            color: #0f172a;
            font-size: 14px;
            font-weight: 950;
            text-align: right;
        }

        .items-wrap {
            padding: 20px;
            display: grid;
            gap: 16px;
        }

        .item-card {
            display: grid;
            grid-template-columns: 1fr auto;
            gap: 18px;
            border-radius: 24px;
            padding: 18px;
            background: #ffffff;
            border: 1px solid #e2e8f0;
        }

        .item-left {
            display: flex;
            align-items: flex-start;
            gap: 14px;
        }

        .item-number {
            display: grid;
            place-items: center;
            width: 38px;
            height: 38px;
            border-radius: 14px;
            background: #ecfdf5;
            color: #047857;
            font-size: 13px;
            font-weight: 950;
        }

        .item-name {
            margin: 0;
            color: #020617;
            font-size: 16px;
            font-weight: 950;
        }

        .item-meta {
            display: flex;
            flex-wrap: wrap;
            gap: 8px;
            margin-top: 10px;
        }

        .meta-chip {
            display: inline-flex;
            border-radius: 999px;
            padding: 7px 10px;
            background: #f8fafc;
            border: 1px solid #e2e8f0;
            color: #475569;
            font-size: 12px;
            font-weight: 850;
        }

        .item-right {
            min-width: 170px;
            text-align: right;
        }

        .item-price-label {
            margin: 0;
            color: #94a3b8;
            font-size: 12px;
            font-weight: 800;
        }

        .item-subtotal {
            margin: 6px 0 0;
            color: #047857;
            font-size: 19px;
            font-weight: 950;
        }

        .detail-total-footer {
            display: flex;
            align-items: center;
            justify-content: space-between;
            gap: 18px;
            margin: 4px 20px 20px;
            padding: 20px;
            border-radius: 24px;
            background: linear-gradient(135deg, #ecfdf5, #f0fdfa);
            border: 1px solid #bbf7d0;
        }

        .detail-total-footer span {
            color: #047857;
            font-size: 14px;
            font-weight: 900;
            text-transform: uppercase;
            letter-spacing: 0.08em;
        }

        .detail-total-footer strong {
            color: #064e3b;
            font-size: 24px;
            font-weight: 950;
        }

        @media (max-width: 1200px) {
            .detail-hero-grid,
            .detail-main-grid {
                grid-template-columns: 1fr;
            }

            .detail-summary-grid {
                grid-template-columns: repeat(2, minmax(0, 1fr));
            }
        }

        @media (max-width: 700px) {
            .detail-summary-grid {
                grid-template-columns: 1fr;
            }

            .item-card {
                grid-template-columns: 1fr;
            }

            .item-right {
                text-align: left;
            }
        }
    </style>

    <?php
        $order = $record;
        $items = $order->items ?? collect();
        $date = $order->ordered_at ?? $order->created_at;

        $statusColor = match ($order->status) {
            'Selesai' => '#047857',
            'Diproses' => '#b45309',
            'Dibatalkan' => '#b91c1c',
            default => '#475569',
        };
    ?>

    <div class="order-detail-page">
        <section class="detail-hero">
            <div class="detail-hero-grid">
                <div>
                    <div class="detail-badge">
                        <span class="detail-badge-dot"></span>
                        Detail Transaksi
                    </div>

                    <h2 class="detail-title">
                        <?php echo e($order->order_code ?? 'ORD-' . $order->id); ?>

                    </h2>

                    <p class="detail-desc">
                        Informasi lengkap transaksi, total pembayaran, waktu order,
                        status pesanan, dan rincian produk yang dibeli.
                    </p>
                </div>

                <div class="hero-status-card">
                    <span class="hero-status-label">Status Order</span>

                    <div class="hero-status-value" style="color: <?php echo e($statusColor); ?>;">
                        <span class="hero-status-dot" style="background: <?php echo e($statusColor); ?>;"></span>
                        <?php echo e($order->status); ?>

                    </div>
                </div>
            </div>
        </section>

        <section class="detail-summary-grid">
            <div class="summary-card">
                <p class="summary-label">ID Order</p>
                <p class="summary-value"><?php echo e($order->order_code ?? 'ORD-' . $order->id); ?></p>
                <span class="summary-caption">Kode transaksi</span>
            </div>

            <div class="summary-card">
                <p class="summary-label">Total Item</p>
                <p class="summary-value"><?php echo e(number_format((int) $order->total_item, 0, ',', '.')); ?></p>
                <span class="summary-caption">Item dibeli</span>
            </div>

            <div class="summary-card">
                <p class="summary-label">Total Pembayaran</p>
                <p class="summary-value">Rp <?php echo e(number_format((int) $order->total_price, 0, ',', '.')); ?></p>
                <span class="summary-caption">Revenue transaksi</span>
            </div>

            <div class="summary-card">
                <p class="summary-label">Waktu Order</p>
                <p class="summary-value"><?php echo e(\Carbon\Carbon::parse($date)->translatedFormat('d M Y')); ?></p>
                <span class="summary-caption"><?php echo e(\Carbon\Carbon::parse($date)->format('H:i')); ?> WIB</span>
            </div>
        </section>

        <section class="detail-main-grid">
            <div class="lux-panel">
                <div class="lux-panel-header">
                    <h3 class="lux-panel-title">Informasi Order</h3>
                    <p class="lux-panel-desc">Ringkasan utama dari transaksi yang dipilih.</p>
                </div>

                <div class="info-list">
                    <div class="info-row">
                        <span>ID Order</span>
                        <strong><?php echo e($order->order_code ?? 'ORD-' . $order->id); ?></strong>
                    </div>

                    <div class="info-row">
                        <span>Status</span>
                        <strong style="color: <?php echo e($statusColor); ?>;"><?php echo e($order->status); ?></strong>
                    </div>

                    <div class="info-row">
                        <span>Total Item</span>
                        <strong><?php echo e(number_format((int) $order->total_item, 0, ',', '.')); ?></strong>
                    </div>

                    <div class="info-row">
                        <span>Total Pembayaran</span>
                        <strong>Rp <?php echo e(number_format((int) $order->total_price, 0, ',', '.')); ?></strong>
                    </div>

                    <div class="info-row">
                        <span>Waktu Order</span>
                        <strong><?php echo e(\Carbon\Carbon::parse($date)->translatedFormat('d F Y H:i')); ?></strong>
                    </div>
                </div>
            </div>

            <div class="lux-panel">
                <div class="lux-panel-header">
                    <h3 class="lux-panel-title">Detail Item</h3>
                    <p class="lux-panel-desc">Daftar produk yang dibeli pada transaksi ini.</p>
                </div>

                <div class="items-wrap">
                    <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::openLoop(); ?><?php endif; ?><?php $__empty_1 = true; $__currentLoopData = $items; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $item): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::startLoop($loop->index); ?><?php endif; ?>
                        <div class="item-card">
                            <div class="item-left">
                                <div class="item-number"><?php echo e($loop->iteration); ?></div>

                                <div>
                                    <h4 class="item-name"><?php echo e($item->product_name); ?></h4>

                                    <div class="item-meta">
                                        <span class="meta-chip">Size: <?php echo e($item->size_name ?? 'Regular'); ?></span>
                                        <span class="meta-chip">Qty: <?php echo e(number_format((int) $item->quantity, 0, ',', '.')); ?></span>
                                        <span class="meta-chip">Harga: Rp <?php echo e(number_format((int) $item->price, 0, ',', '.')); ?></span>
                                    </div>
                                </div>
                            </div>

                            <div class="item-right">
                                <p class="item-price-label">Subtotal</p>
                                <p class="item-subtotal">
                                    Rp <?php echo e(number_format((int) $item->subtotal, 0, ',', '.')); ?>

                                </p>
                            </div>
                        </div>
                    <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::endLoop(); ?><?php endif; ?><?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::closeLoop(); ?><?php endif; ?>
                        <div class="item-card">
                            <div>
                                <h4 class="item-name">Tidak ada item</h4>
                                <div class="item-meta">
                                    <span class="meta-chip">Order ini belum memiliki detail item.</span>
                                </div>
                            </div>
                        </div>
                    <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
                </div>

                <div class="detail-total-footer">
                    <span>Total Pembayaran</span>
                    <strong>Rp <?php echo e(number_format((int) $order->total_price, 0, ',', '.')); ?></strong>
                </div>
            </div>
        </section>
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
<?php endif; ?>
<?php /**PATH /var/www/html/resources/views/filament/admin/resources/orders/pages/view-order.blade.php ENDPATH**/ ?>