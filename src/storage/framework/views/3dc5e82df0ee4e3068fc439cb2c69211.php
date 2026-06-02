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
        .order-lux-wrapper {
            --primary: #0f766e;
            --primary-light: #14b8a6;
            --emerald: #10b981;
            --dark: #0f172a;
            --muted: #64748b;
            --border: #e2e8f0;
            --soft: #f8fafc;
            margin-bottom: 22px;
        }

        .order-lux-hero {
            position: relative;
            overflow: hidden;
            border-radius: 30px;
            padding: 30px;
            color: white;
            background:
                radial-gradient(circle at top right, rgba(255,255,255,0.32), transparent 28%),
                radial-gradient(circle at bottom left, rgba(255,255,255,0.18), transparent 28%),
                linear-gradient(135deg, #0f766e 0%, #0d9488 45%, #10b981 100%);
            box-shadow: 0 28px 70px rgba(15, 118, 110, 0.22);
            isolation: isolate;
        }

        .order-lux-hero::before {
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

        .order-lux-hero-top {
            display: flex;
            align-items: flex-start;
            justify-content: space-between;
            gap: 24px;
        }

        .order-lux-badge {
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

        .order-lux-dot {
            width: 9px;
            height: 9px;
            border-radius: 999px;
            background: #bbf7d0;
            box-shadow: 0 0 0 5px rgba(187,247,208,0.22);
        }

        .order-lux-title {
            margin: 16px 0 0;
            font-size: 34px;
            line-height: 1.08;
            font-weight: 950;
            letter-spacing: -0.04em;
        }

        .order-lux-desc {
            margin: 12px 0 0;
            max-width: 760px;
            color: rgba(255,255,255,0.86);
            font-size: 14px;
            line-height: 1.7;
        }

        .order-lux-mini {
            min-width: 210px;
            border-radius: 22px;
            padding: 18px;
            background: rgba(255,255,255,0.16);
            border: 1px solid rgba(255,255,255,0.24);
            backdrop-filter: blur(12px);
        }

        .order-lux-mini span {
            display: block;
            color: rgba(255,255,255,0.78);
            font-size: 12px;
            font-weight: 700;
        }

        .order-lux-mini strong {
            display: block;
            margin-top: 8px;
            color: white;
            font-size: 30px;
            line-height: 1;
            font-weight: 950;
        }

        .order-lux-grid {
            display: grid;
            grid-template-columns: repeat(4, minmax(0, 1fr));
            gap: 16px;
            margin-top: 20px;
        }

        .order-lux-card {
            position: relative;
            overflow: hidden;
            border-radius: 24px;
            padding: 20px;
            background: white;
            border: 1px solid rgba(226,232,240,0.95);
            box-shadow: 0 16px 40px rgba(15,23,42,0.07);
            min-height: 145px;
        }

        .order-lux-card::after {
            content: "";
            position: absolute;
            width: 118px;
            height: 118px;
            top: -52px;
            right: -42px;
            border-radius: 999px;
            opacity: 0.15;
        }

        .order-lux-card.revenue::after { background: #10b981; }
        .order-lux-card.orders::after { background: #3b82f6; }
        .order-lux-card.units::after { background: #f97316; }
        .order-lux-card.avg::after { background: #64748b; }

        .order-lux-card-label {
            margin: 0;
            color: #64748b;
            font-size: 13px;
            font-weight: 850;
        }

        .order-lux-card-value {
            margin: 18px 0 0;
            color: #020617;
            font-size: 30px;
            line-height: 1;
            font-weight: 950;
            letter-spacing: -0.045em;
        }

        .order-lux-card-caption {
            display: inline-flex;
            align-items: center;
            margin-top: 14px;
            border-radius: 999px;
            padding: 7px 11px;
            font-size: 12px;
            font-weight: 800;
        }

        .revenue .order-lux-card-caption { background: #ecfdf5; color: #047857; }
        .orders .order-lux-card-caption { background: #eff6ff; color: #1d4ed8; }
        .units .order-lux-card-caption { background: #fff7ed; color: #c2410c; }
        .avg .order-lux-card-caption { background: #f8fafc; color: #475569; }

        @media (max-width: 1100px) {
            .order-lux-hero-top {
                flex-direction: column;
            }

            .order-lux-grid {
                grid-template-columns: repeat(2, minmax(0, 1fr));
            }
        }

        @media (max-width: 700px) {
            .order-lux-hero {
                padding: 24px;
                border-radius: 24px;
            }

            .order-lux-title {
                font-size: 28px;
            }

            .order-lux-grid {
                grid-template-columns: 1fr;
            }
        }
    </style>

    <div class="order-lux-wrapper">
        <section class="order-lux-hero">
            <div class="order-lux-hero-top">
                <div>
                    <div class="order-lux-badge">
                        <span class="order-lux-dot"></span>
                        Ngunjuk POS Order
                    </div>

                    <h2 class="order-lux-title">
                        Order Management Analytics
                    </h2>

                    <p class="order-lux-desc">
                        Pantau seluruh transaksi kasir, detail item yang dibeli, total pendapatan,
                        jumlah item terjual, dan status order dalam satu halaman admin yang rapi.
                    </p>
                </div>

                <div class="order-lux-mini">
                    <span>Order Hari Ini</span>
                    <strong><?php echo e(number_format($summary['today_orders'], 0, ',', '.')); ?></strong>
                </div>
            </div>
        </section>

        <div class="order-lux-grid">
            <div class="order-lux-card revenue">
                <p class="order-lux-card-label">Total Revenue</p>
                <p class="order-lux-card-value">
                    Rp <?php echo e(number_format($summary['total_revenue'], 0, ',', '.')); ?>

                </p>
                <p class="order-lux-card-caption">Dari order selesai</p>
            </div>

            <div class="order-lux-card orders">
                <p class="order-lux-card-label">Total Orders</p>
                <p class="order-lux-card-value">
                    <?php echo e(number_format($summary['total_orders'], 0, ',', '.')); ?>

                </p>
                <p class="order-lux-card-caption">Semua transaksi</p>
            </div>

            <div class="order-lux-card units">
                <p class="order-lux-card-label">Units Sold</p>
                <p class="order-lux-card-value">
                    <?php echo e(number_format($summary['units_sold'], 0, ',', '.')); ?>

                </p>
                <p class="order-lux-card-caption">Item terjual</p>
            </div>

            <div class="order-lux-card avg">
                <p class="order-lux-card-label">Avg Order</p>
                <p class="order-lux-card-value">
                    Rp <?php echo e(number_format($summary['avg_order'], 0, ',', '.')); ?>

                </p>
                <p class="order-lux-card-caption">Rata-rata order</p>
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
<?php /**PATH /var/www/html/resources/views/filament/admin/resources/orders/widgets/order-analytics-widget.blade.php ENDPATH**/ ?>