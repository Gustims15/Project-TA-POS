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
            .category-contribution-card {
                min-height: 420px;
            }

            .category-contribution-head {
                display: flex;
                justify-content: space-between;
                align-items: flex-start;
                gap: 14px;
                margin-bottom: 16px;
            }

            .category-contribution-title {
                margin: 0;
                color: #0f172a;
                font-size: 15px;
                font-weight: 950;
                letter-spacing: -0.035em;
            }

            .category-contribution-subtitle {
                margin: 5px 0 0;
                color: #64748b;
                font-size: 11px;
                font-weight: 650;
                line-height: 1.45;
            }

            .category-contribution-badge {
                border-radius: 999px;
                padding: 8px 10px;
                color: #9a3412;
                background: #fff7ed;
                border: 1px solid rgba(251, 146, 60, 0.25);
                font-size: 10px;
                font-weight: 950;
                white-space: nowrap;
            }

            .category-contribution-main {
                display: grid;
                grid-template-columns: 190px minmax(0, 1fr);
                gap: 18px;
                align-items: center;
            }

            .category-donut-wrap {
                display: grid;
                place-items: center;
            }

            .category-donut {
                position: relative;
                width: 170px;
                height: 170px;
                border-radius: 999px;
                box-shadow: 0 18px 42px rgba(15, 23, 42, 0.08);
            }

            .category-donut::after {
                content: "";
                position: absolute;
                inset: 31px;
                border-radius: inherit;
                background: #ffffff;
                box-shadow: inset 0 0 0 1px rgba(226, 232, 240, 0.8);
            }

            .category-donut-center {
                position: absolute;
                inset: 0;
                z-index: 2;
                display: grid;
                place-items: center;
                text-align: center;
                padding: 48px;
            }

            .category-donut-label {
                color: #94a3b8;
                font-size: 9px;
                font-weight: 950;
                letter-spacing: 0.08em;
                text-transform: uppercase;
            }

            .category-donut-value {
                margin-top: 4px;
                color: #0f172a;
                font-size: 25px;
                font-weight: 950;
                letter-spacing: -0.06em;
            }

            .category-donut-name {
                margin-top: 4px;
                color: #64748b;
                font-size: 10px;
                font-weight: 850;
                line-height: 1.25;
            }

            .category-summary-grid {
                display: grid;
                grid-template-columns: repeat(2, minmax(0, 1fr));
                gap: 10px;
                margin-bottom: 14px;
            }

            .category-summary-box {
                border-radius: 17px;
                padding: 12px;
                background: rgba(248, 250, 252, 0.86);
                border: 1px solid rgba(226, 232, 240, 0.86);
            }

            .category-summary-label {
                color: #94a3b8;
                font-size: 9px;
                font-weight: 950;
                letter-spacing: 0.08em;
                text-transform: uppercase;
            }

            .category-summary-value {
                margin-top: 6px;
                color: #0f172a;
                font-size: 14px;
                font-weight: 950;
                letter-spacing: -0.035em;
            }

            .category-list {
                display: grid;
                gap: 10px;
            }

            .category-item {
                display: grid;
                grid-template-columns: minmax(0, 1fr) auto;
                gap: 12px;
                align-items: center;
                border-radius: 16px;
                padding: 11px;
                background: rgba(255, 255, 255, 0.92);
                border: 1px solid rgba(226, 232, 240, 0.78);
            }

            .category-name-row {
                display: flex;
                align-items: center;
                gap: 8px;
            }

            .category-dot {
                width: 10px;
                height: 10px;
                flex: 0 0 auto;
                border-radius: 999px;
            }

            .category-name {
                color: #0f172a;
                font-size: 12px;
                font-weight: 950;
                line-height: 1.25;
            }

            .category-bar-wrap {
                margin-top: 8px;
                height: 7px;
                overflow: hidden;
                border-radius: 999px;
                background: rgba(226, 232, 240, 0.95);
            }

            .category-bar {
                height: 100%;
                border-radius: inherit;
            }

            .category-value {
                text-align: right;
                color: #0f172a;
                font-size: 11px;
                font-weight: 950;
                white-space: nowrap;
            }

            .category-share {
                margin-top: 3px;
                color: #94a3b8;
                font-size: 10px;
                font-weight: 850;
            }

            .category-empty {
                min-height: 280px;
                display: grid;
                place-items: center;
                border-radius: 20px;
                color: #94a3b8;
                background: rgba(248, 250, 252, 0.78);
                border: 1px dashed rgba(148, 163, 184, 0.48);
                text-align: center;
                font-size: 12px;
                font-weight: 800;
            }

            @media (max-width: 900px) {
                .category-contribution-main {
                    grid-template-columns: 1fr;
                }

                .category-summary-grid {
                    grid-template-columns: 1fr;
                }
            }
        </style>

        <div class="category-contribution-card">
            <div class="category-contribution-head">
                <div>
                    <h3 class="category-contribution-title">Category Contribution</h3>
                    <p class="category-contribution-subtitle">
                        Komposisi kontribusi kategori berdasarkan <?php echo e(strtolower($metricLabel)); ?>

                        pada <?php echo e(strtolower($periodLabel)); ?>.
                    </p>
                </div>

                <div class="category-contribution-badge">
                    <?php echo e($metricLabel); ?>

                </div>
            </div>

            <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if(count($items) > 0): ?>
                <?php
                    $colors = [
                        '#f97316',
                        '#16a34a',
                        '#2563eb',
                        '#8b5cf6',
                        '#e11d48',
                        '#0891b2',
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

                    $donutGradient = 'conic-gradient(' . implode(', ', $segments) . ')';
                ?>

                <div class="category-contribution-main">
                    <div class="category-donut-wrap">
                        <div class="category-donut" style="background: <?php echo e($donutGradient); ?>;">
                            <div class="category-donut-center">
                                <div>
                                    <div class="category-donut-label">Top Share</div>
                                    <div class="category-donut-value">
                                        <?php echo e(number_format((float) $topCategoryShare, 1, ',', '.')); ?>%
                                    </div>
                                    <div class="category-donut-name">
                                        <?php echo e($topCategoryName); ?>

                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div>
                        <div class="category-summary-grid">
                            <div class="category-summary-box">
                                <div class="category-summary-label">Top Category</div>
                                <div class="category-summary-value"><?php echo e($topCategoryName); ?></div>
                            </div>

                            <div class="category-summary-box">
                                <div class="category-summary-label">Total Value</div>
                                <div class="category-summary-value"><?php echo e($totalCategoryValue); ?></div>
                            </div>
                        </div>

                        <div class="category-list">
                            <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::openLoop(); ?><?php endif; ?><?php $__currentLoopData = $items; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $index => $item): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::startLoop($loop->index); ?><?php endif; ?>
                                <?php
                                    $color = $colors[$index % count($colors)];
                                ?>

                                <div class="category-item">
                                    <div>
                                        <div class="category-name-row">
                                            <span
                                                class="category-dot"
                                                style="background: <?php echo e($color); ?>;"
                                            ></span>

                                            <div class="category-name">
                                                <?php echo e($item['name']); ?>

                                            </div>
                                        </div>

                                        <div class="category-bar-wrap">
                                            <div
                                                class="category-bar"
                                                style="width: <?php echo e($item['width']); ?>%; background: <?php echo e($color); ?>;"
                                            ></div>
                                        </div>
                                    </div>

                                    <div class="category-value">
                                        <?php echo e($item['formatted']); ?>

                                        <div class="category-share">
                                            <?php echo e(number_format((float) $item['share'], 1, ',', '.')); ?>%
                                        </div>
                                    </div>
                                </div>
                            <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::endLoop(); ?><?php endif; ?><?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::closeLoop(); ?><?php endif; ?>
                        </div>
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