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
        .metric-lux-card {
            overflow: hidden;
            border-radius: 28px;
            background: white;
            border: 1px solid rgba(226,232,240,0.95);
            box-shadow: 0 18px 45px rgba(15, 23, 42, 0.08);
        }

        .metric-lux-header {
            padding: 22px 26px;
            border-bottom: 1px solid #e2e8f0;
            background:
                linear-gradient(135deg, rgba(15,118,110,0.08), transparent 45%),
                linear-gradient(90deg, #ffffff, #f8fafc);
        }

        .metric-lux-title {
            margin: 0;
            color: #020617;
            font-size: 20px;
            font-weight: 950;
            letter-spacing: -0.03em;
        }

        .metric-lux-desc {
            margin: 7px 0 0;
            color: #64748b;
            font-size: 13px;
        }

        .metric-lux-body {
            padding: 20px;
            display: grid;
            grid-template-columns: repeat(3, minmax(0, 1fr));
            gap: 14px;
        }

        .metric-lux-item {
            display: flex;
            flex-direction: column;
            justify-content: center;
            min-height: 84px;
            border-radius: 20px;
            padding: 18px;
            text-decoration: none;
            border: 1px solid #e2e8f0;
            background: #ffffff;
            transition: 0.25s ease;
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
            font-size: 14px;
            font-weight: 950;
            text-transform: uppercase;
            letter-spacing: 0.06em;
            text-align: center;
        }

        .metric-lux-item.active .metric-lux-label {
            color: white;
        }

        .metric-lux-description {
            margin-top: 7px;
            color: #64748b;
            font-size: 12px;
            font-weight: 750;
            text-align: center;
        }

        .metric-lux-item.active .metric-lux-description {
            color: #ccfbf1;
        }

        @media (max-width: 900px) {
            .metric-lux-body {
                grid-template-columns: 1fr;
            }
        }
    </style>

    <div class="metric-lux-card">
        <div class="metric-lux-header">
            <h3 class="metric-lux-title">
                Dashboard Metric
            </h3>

            <p class="metric-lux-desc">
                Pilih metric utama untuk mengubah seluruh visualisasi dashboard.
            </p>
        </div>

        <div class="metric-lux-body">
            <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::openLoop(); ?><?php endif; ?><?php $__currentLoopData = $metrics; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $key => $metric): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::startLoop($loop->index); ?><?php endif; ?>
                <?php
                    $isActive = $activeMetric === $key;

                    $url = url('/admin') . '?' . http_build_query([
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

                    <span class="metric-lux-description">
                        <?php echo e($metric['description']); ?>

                    </span>
                </a>
            <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::endLoop(); ?><?php endif; ?><?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::closeLoop(); ?><?php endif; ?>
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
<?php /**PATH /var/www/html/resources/views/filament/admin/widgets/metric-tabs.blade.php ENDPATH**/ ?>