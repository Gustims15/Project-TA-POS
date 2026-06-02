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
        .category-lux-wrapper {
            --primary: #0f766e;
            --primary-light: #14b8a6;
            --emerald: #10b981;
            --dark: #0f172a;
            --muted: #64748b;
            --border: #e2e8f0;
            --soft: #f8fafc;
            margin-bottom: 22px;
        }

        .category-lux-hero {
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

        .category-lux-hero::before {
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

        .category-lux-hero-top {
            display: flex;
            align-items: flex-start;
            justify-content: space-between;
            gap: 24px;
        }

        .category-lux-badge {
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

        .category-lux-dot {
            width: 9px;
            height: 9px;
            border-radius: 999px;
            background: #bbf7d0;
            box-shadow: 0 0 0 5px rgba(187,247,208,0.22);
        }

        .category-lux-title {
            margin: 16px 0 0;
            font-size: 34px;
            line-height: 1.08;
            font-weight: 950;
            letter-spacing: -0.04em;
        }

        .category-lux-desc {
            margin: 12px 0 0;
            max-width: 780px;
            color: rgba(255,255,255,0.86);
            font-size: 14px;
            line-height: 1.7;
        }

        .category-lux-mini {
            min-width: 240px;
            border-radius: 22px;
            padding: 18px;
            background: rgba(255,255,255,0.16);
            border: 1px solid rgba(255,255,255,0.24);
            backdrop-filter: blur(12px);
        }

        .category-lux-mini span {
            display: block;
            color: rgba(255,255,255,0.78);
            font-size: 12px;
            font-weight: 700;
        }

        .category-lux-mini strong {
            display: block;
            margin-top: 8px;
            color: white;
            font-size: 24px;
            line-height: 1.15;
            font-weight: 950;
        }

        .category-lux-mini small {
            display: block;
            margin-top: 8px;
            color: rgba(255,255,255,0.82);
            font-size: 12px;
            font-weight: 700;
        }

        .category-lux-grid {
            display: grid;
            grid-template-columns: repeat(4, minmax(0, 1fr));
            gap: 16px;
            margin-top: 20px;
        }

        .category-lux-card {
            position: relative;
            overflow: hidden;
            border-radius: 24px;
            padding: 20px;
            background: white;
            border: 1px solid rgba(226,232,240,0.95);
            box-shadow: 0 16px 40px rgba(15,23,42,0.07);
            min-height: 145px;
            transition: 0.25s ease;
        }

        .category-lux-card:hover {
            transform: translateY(-4px);
            box-shadow: 0 24px 55px rgba(15,23,42,0.12);
        }

        .category-lux-card::after {
            content: "";
            position: absolute;
            width: 118px;
            height: 118px;
            top: -52px;
            right: -42px;
            border-radius: 999px;
            opacity: 0.15;
        }

        .category-lux-card.total::after { background: #10b981; }
        .category-lux-card.active::after { background: #3b82f6; }
        .category-lux-card.product::after { background: #f97316; }
        .category-lux-card.inactive::after { background: #ef4444; }

        .category-lux-card-label {
            margin: 0;
            color: #64748b;
            font-size: 13px;
            font-weight: 850;
        }

        .category-lux-card-value {
            margin: 18px 0 0;
            color: #020617;
            font-size: 30px;
            line-height: 1;
            font-weight: 950;
            letter-spacing: -0.045em;
        }

        .category-lux-card-caption {
            display: inline-flex;
            align-items: center;
            margin-top: 14px;
            border-radius: 999px;
            padding: 7px 11px;
            font-size: 12px;
            font-weight: 800;
        }

        .total .category-lux-card-caption { background: #ecfdf5; color: #047857; }
        .active .category-lux-card-caption { background: #eff6ff; color: #1d4ed8; }
        .product .category-lux-card-caption { background: #fff7ed; color: #c2410c; }
        .inactive .category-lux-card-caption { background: #fef2f2; color: #b91c1c; }

        @media (max-width: 1100px) {
            .category-lux-hero-top {
                flex-direction: column;
            }

            .category-lux-grid {
                grid-template-columns: repeat(2, minmax(0, 1fr));
            }
        }

        @media (max-width: 700px) {
            .category-lux-hero {
                padding: 24px;
                border-radius: 24px;
            }

            .category-lux-title {
                font-size: 28px;
            }

            .category-lux-grid {
                grid-template-columns: 1fr;
            }
        }
    </style>

    <div class="category-lux-wrapper">
        <section class="category-lux-hero">
            <div class="category-lux-hero-top">
                <div>
                    <div class="category-lux-badge">
                        <span class="category-lux-dot"></span>
                        Ngunjuk POS Category
                    </div>

                    <h2 class="category-lux-title">
                        Category Management Analytics
                    </h2>

                    <p class="category-lux-desc">
                        Kelola kategori produk minuman, pantau jumlah produk pada setiap kategori,
                        dan pastikan kategori aktif tersusun rapi untuk mendukung halaman kasir POS.
                    </p>
                </div>

                <div class="category-lux-mini">
                    <span>Kategori Terbanyak Produk</span>
                    <strong><?php echo e($summary['top_category_name']); ?></strong>
                    <small><?php echo e(number_format($summary['top_category_products'], 0, ',', '.')); ?> produk</small>
                </div>
            </div>
        </section>

        <div class="category-lux-grid">
            <div class="category-lux-card total">
                <p class="category-lux-card-label">Total Kategori</p>
                <p class="category-lux-card-value">
                    <?php echo e(number_format($summary['total_categories'], 0, ',', '.')); ?>

                </p>
                <p class="category-lux-card-caption">Semua kategori</p>
            </div>

            <div class="category-lux-card active">
                <p class="category-lux-card-label">Kategori Aktif</p>
                <p class="category-lux-card-value">
                    <?php echo e(number_format($summary['active_categories'], 0, ',', '.')); ?>

                </p>
                <p class="category-lux-card-caption">Tampil pada sistem</p>
            </div>

            <div class="category-lux-card product">
                <p class="category-lux-card-label">Total Produk</p>
                <p class="category-lux-card-value">
                    <?php echo e(number_format($summary['total_products'], 0, ',', '.')); ?>

                </p>
                <p class="category-lux-card-caption">Produk terhubung</p>
            </div>

            <div class="category-lux-card inactive">
                <p class="category-lux-card-label">Kategori Nonaktif</p>
                <p class="category-lux-card-value">
                    <?php echo e(number_format($summary['inactive_categories'], 0, ',', '.')); ?>

                </p>
                <p class="category-lux-card-caption">Tidak aktif</p>
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
<?php /**PATH /var/www/html/resources/views/filament/admin/resources/categories/widgets/category-analytics-widget.blade.php ENDPATH**/ ?>