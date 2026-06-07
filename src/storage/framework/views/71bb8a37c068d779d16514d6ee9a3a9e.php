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

    <?php if (isset($component)) { $__componentOriginalee08b1367eba38734199cf7829b1d1e9 = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginalee08b1367eba38734199cf7829b1d1e9 = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'filament::components.section.index','data' => []] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('filament::section'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes([]); ?>
<?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::processComponentKey($component); ?>

        <style>
            .category-pbi {
                min-height: 380px;
            }

            .category-head {
                display: flex;
                justify-content: space-between;
                align-items: flex-start;
                gap: 14px;
                margin-bottom: 18px;
            }

            .category-title {
                margin: 0;
                color: #0f172a;
                font-size: 15px;
                font-weight: 950;
                letter-spacing: -0.03em;
            }

            .category-subtitle {
                margin: 5px 0 0;
                color: #64748b;
                font-size: 11px;
                font-weight: 700;
                line-height: 1.5;
            }

            .category-chip {
                height: fit-content;
                padding: 7px 10px;
                border-radius: 999px;
                background: #eff6ff;
                color: #1d4ed8;
                font-size: 10px;
                font-weight: 950;
                white-space: nowrap;
            }

            .category-body {
                display: grid;
                grid-template-columns: 210px minmax(0, 1fr);
                gap: 20px;
                align-items: center;
            }

            .category-donut-wrap {
                position: relative;
                width: 210px;
                height: 210px;
                margin: 0 auto;
            }

            .category-donut {
                position: absolute;
                inset: 0;
                border-radius: 999px;
                background: var(--donut-gradient);
                box-shadow: 0 18px 42px rgba(15, 23, 42, 0.10);
            }

            .category-donut::after {
                content: "";
                position: absolute;
                inset: 42px;
                border-radius: 999px;
                background: #ffffff;
                box-shadow: inset 0 0 0 1px #e2e8f0;
            }

            .category-center {
                position: absolute;
                inset: 62px;
                z-index: 2;
                display: flex;
                flex-direction: column;
                align-items: center;
                justify-content: center;
                text-align: center;
            }

            .category-center-label {
                color: #64748b;
                font-size: 10px;
                font-weight: 950;
                text-transform: uppercase;
                letter-spacing: 0.08em;
            }

            .category-center-value {
                margin-top: 6px;
                color: #0f172a;
                font-size: 28px;
                line-height: 1;
                font-weight: 950;
                letter-spacing: -0.05em;
            }

            .category-center-note {
                margin-top: 5px;
                color: #94a3b8;
                font-size: 10px;
                font-weight: 850;
            }

            .category-legend {
                display: grid;
                gap: 10px;
            }

            .category-row {
                display: grid;
                grid-template-columns: 12px minmax(0, 1fr) auto;
                align-items: center;
                gap: 10px;
                padding: 8px 9px;
                border-radius: 14px;
                background: #f8fafc;
                border: 1px solid #e2e8f0;
            }

            .category-color {
                width: 11px;
                height: 11px;
                border-radius: 999px;
                background: var(--category-color);
                box-shadow: 0 0 0 4px color-mix(in srgb, var(--category-color) 16%, transparent);
            }

            .category-info {
                min-width: 0;
            }

            .category-name {
                color: #0f172a;
                font-size: 12px;
                font-weight: 950;
                white-space: nowrap;
                overflow: hidden;
                text-overflow: ellipsis;
            }

            .category-value {
                margin-top: 2px;
                color: #64748b;
                font-size: 10px;
                font-weight: 850;
                white-space: nowrap;
            }

            .category-share {
                color: #0f172a;
                font-size: 13px;
                font-weight: 950;
                white-space: nowrap;
            }

            .category-empty {
                min-height: 260px;
                display: flex;
                align-items: center;
                justify-content: center;
                border-radius: 18px;
                background: #f8fafc;
                border: 1px dashed #cbd5e1;
                color: #64748b;
                font-size: 12px;
                font-weight: 800;
            }

            @media (max-width: 900px) {
                .category-body {
                    grid-template-columns: 1fr;
                }
            }
        </style>

        <div class="category-pbi">
            <div class="category-head">
                <div>
                    <h3 class="category-title">Category Contribution</h3>
                    <p class="category-subtitle">
                        Komposisi kontribusi kategori berdasarkan <?php echo e(strtolower($metricLabel)); ?> pada <?php echo e(strtolower($periodLabel)); ?>.
                    </p>
                </div>

                <span class="category-chip">Donut Chart</span>
            </div>

            <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if(count($items) > 0): ?>
                <?php
                    $colors = [
                        '#2563eb',
                        '#0f766e',
                        '#f97316',
                        '#8b5cf6',
                        '#e11d48',
                        '#0891b2',
                        '#ca8a04',
                        '#16a34a',
                    ];

                    $segments = [];
                    $start = 0;

                    foreach ($items as $index => $item) {
                        $share = (float) $item['share'];
                        $end = min($start + $share, 100);
                        $color = $colors[$index % count($colors)];

                        $segments[] = $color . ' ' . $start . '% ' . $end . '%';
                        $start = $end;
                    }

                    if ($start < 100) {
                        $segments[] = '#e2e8f0 ' . $start . '% 100%';
                    }

                    $topCategory = $items[0] ?? null;
                    $donutGradient = 'conic-gradient(' . implode(', ', $segments) . ')';
                ?>

                <div class="category-body">
                    <div class="category-donut-wrap">
                        <div
                            class="category-donut"
                            style="--donut-gradient: <?php echo e($donutGradient); ?>;"
                        ></div>

                        <div class="category-center">
                            <div class="category-center-label">Top Share</div>
                            <div class="category-center-value">
                                <?php echo e($topCategory['share'] ?? 0); ?>%
                            </div>
                            <div class="category-center-note">
                                <?php echo e($topCategory['name'] ?? '-'); ?>

                            </div>
                        </div>
                    </div>

                    <div class="category-legend">
                        <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::openLoop(); ?><?php endif; ?><?php $__currentLoopData = $items; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $index => $item): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::startLoop($loop->index); ?><?php endif; ?>
                            <?php
                                $color = $colors[$index % count($colors)];
                            ?>

                            <div
                                class="category-row"
                                style="--category-color: <?php echo e($color); ?>;"
                            >
                                <span class="category-color"></span>

                                <div class="category-info">
                                    <div class="category-name" title="<?php echo e($item['name']); ?>">
                                        <?php echo e($item['name']); ?>

                                    </div>

                                    <div class="category-value">
                                        <?php echo e($item['formatted']); ?>

                                    </div>
                                </div>

                                <div class="category-share">
                                    <?php echo e($item['share']); ?>%
                                </div>
                            </div>
                        <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::endLoop(); ?><?php endif; ?><?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::closeLoop(); ?><?php endif; ?>
                    </div>
                </div>
            <?php else: ?>
                <div class="category-empty">
                    Belum ada data kategori untuk periode ini.
                </div>
            <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
        </div>
     <?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__attributesOriginalee08b1367eba38734199cf7829b1d1e9)): ?>
<?php $attributes = $__attributesOriginalee08b1367eba38734199cf7829b1d1e9; ?>
<?php unset($__attributesOriginalee08b1367eba38734199cf7829b1d1e9); ?>
<?php endif; ?>
<?php if (isset($__componentOriginalee08b1367eba38734199cf7829b1d1e9)): ?>
<?php $component = $__componentOriginalee08b1367eba38734199cf7829b1d1e9; ?>
<?php unset($__componentOriginalee08b1367eba38734199cf7829b1d1e9); ?>
<?php endif; ?>
 <?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__attributesOriginalb525200bfa976483b4eaa0b7685c6e24)): ?>
<?php $attributes = $__attributesOriginalb525200bfa976483b4eaa0b7685c6e24; ?>
<?php unset($__attributesOriginalb525200bfa976483b4eaa0b7685c6e24); ?>
<?php endif; ?>
<?php if (isset($__componentOriginalb525200bfa976483b4eaa0b7685c6e24)): ?>
<?php $component = $__componentOriginalb525200bfa976483b4eaa0b7685c6e24; ?>
<?php unset($__componentOriginalb525200bfa976483b4eaa0b7685c6e24); ?>
<?php endif; ?><?php /**PATH /var/www/html/resources/views/filament/admin/widgets/category-contribution-chart.blade.php ENDPATH**/ ?>