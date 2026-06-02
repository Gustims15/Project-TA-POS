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
            min-width: 230px;
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

        .dashboard-lux-grid {
            display: grid;
            grid-template-columns: repeat(6, minmax(0, 1fr));
            gap: 16px;
            margin-top: 20px;
        }

        .dashboard-lux-card {
            position: relative;
            overflow: hidden;
            border-radius: 24px;
            padding: 20px;
            background: white;
            border: 1px solid rgba(226,232,240,0.95);
            box-shadow: 0 16px 40px rgba(15,23,42,0.07);
            min-height: 150px;
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

        .dashboard-lux-card.revenue::after { background: #10b981; }
        .dashboard-lux-card.orders::after { background: #3b82f6; }
        .dashboard-lux-card.units::after { background: #f97316; }
        .dashboard-lux-card.product::after { background: #8b5cf6; }
        .dashboard-lux-card.stock::after { background: #ef4444; }
        .dashboard-lux-card.avg::after { background: #64748b; }

        .dashboard-lux-label {
            margin: 0;
            color: #64748b;
            font-size: 13px;
            font-weight: 850;
        }

        .dashboard-lux-value {
            margin: 18px 0 0;
            color: #020617;
            font-size: 28px;
            line-height: 1;
            font-weight: 950;
            letter-spacing: -0.045em;
        }

        .dashboard-lux-caption {
            display: inline-flex;
            align-items: center;
            margin-top: 14px;
            border-radius: 999px;
            padding: 7px 11px;
            font-size: 12px;
            font-weight: 800;
        }

        .revenue .dashboard-lux-caption { background: #ecfdf5; color: #047857; }
        .orders .dashboard-lux-caption { background: #eff6ff; color: #1d4ed8; }
        .units .dashboard-lux-caption { background: #fff7ed; color: #c2410c; }
        .product .dashboard-lux-caption { background: #f5f3ff; color: #6d28d9; }
        .stock .dashboard-lux-caption { background: #fef2f2; color: #b91c1c; }
        .avg .dashboard-lux-caption { background: #f8fafc; color: #475569; }

        @media (max-width: 1400px) {
            .dashboard-lux-grid {
                grid-template-columns: repeat(3, minmax(0, 1fr));
            }
        }

        @media (max-width: 900px) {
            .dashboard-lux-hero-top {
                flex-direction: column;
            }

            .dashboard-lux-grid {
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
                        Pantau performa penjualan harian, total transaksi, item terjual,
                        produk, stok habis, dan ringkasan visualisasi data operasional UMKM Ngunjuk
                        dalam satu dashboard admin yang rapi dan profesional.
                    </p>
                </div>

                <div class="dashboard-lux-mini">
                    <span>Revenue Hari Ini</span>
                    <strong>Rp <?php echo e(number_format($summary['today_revenue'], 0, ',', '.')); ?></strong>
                </div>
            </div>
        </section>

        <div class="dashboard-lux-grid">
            <div class="dashboard-lux-card revenue">
                <p class="dashboard-lux-label">Total Revenue</p>
                <p class="dashboard-lux-value">
                    Rp <?php echo e(number_format($summary['today_revenue'], 0, ',', '.')); ?>

                </p>
                <p class="dashboard-lux-caption">Pendapatan hari ini</p>
            </div>

            <div class="dashboard-lux-card orders">
                <p class="dashboard-lux-label">Total Orders</p>
                <p class="dashboard-lux-value">
                    <?php echo e(number_format($summary['today_orders'], 0, ',', '.')); ?>

                </p>
                <p class="dashboard-lux-caption">Transaksi hari ini</p>
            </div>

            <div class="dashboard-lux-card units">
                <p class="dashboard-lux-label">Units Sold</p>
                <p class="dashboard-lux-value">
                    <?php echo e(number_format($summary['today_units_sold'], 0, ',', '.')); ?>

                </p>
                <p class="dashboard-lux-caption">Item terjual hari ini</p>
            </div>

            <div class="dashboard-lux-card product">
                <p class="dashboard-lux-label">Total Product</p>
                <p class="dashboard-lux-value">
                    <?php echo e(number_format($summary['total_products'], 0, ',', '.')); ?>

                </p>
                <p class="dashboard-lux-caption">
                    <?php echo e(number_format($summary['total_categories'], 0, ',', '.')); ?> kategori
                </p>
            </div>

            <div class="dashboard-lux-card stock">
                <p class="dashboard-lux-label">Stok Habis</p>
                <p class="dashboard-lux-value">
                    <?php echo e(number_format($summary['out_of_stock_products'], 0, ',', '.')); ?>

                </p>
                <p class="dashboard-lux-caption">Produk perlu restock</p>
            </div>

            <div class="dashboard-lux-card avg">
                <p class="dashboard-lux-label">Avg Order</p>
                <p class="dashboard-lux-value">
                    Rp <?php echo e(number_format($summary['today_avg_order'], 0, ',', '.')); ?>

                </p>
                <p class="dashboard-lux-caption">Rata-rata order hari ini</p>
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
<?php endif; ?>
<?php /**PATH /var/www/html/resources/views/filament/admin/widgets/dashboard-luxury-overview-widget.blade.php ENDPATH**/ ?>