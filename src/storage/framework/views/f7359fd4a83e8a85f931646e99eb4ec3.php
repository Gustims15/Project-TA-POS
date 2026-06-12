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
            .sales-heatmap-card {
                min-height: 420px;
            }

            .sales-heatmap-head {
                display: flex;
                justify-content: space-between;
                align-items: flex-start;
                gap: 14px;
                margin-bottom: 16px;
            }

            .sales-heatmap-title {
                margin: 0;
                color: #0f172a;
                font-size: 15px;
                font-weight: 950;
                letter-spacing: -0.035em;
            }

            .sales-heatmap-subtitle {
                margin: 5px 0 0;
                color: #64748b;
                font-size: 11px;
                font-weight: 650;
                line-height: 1.45;
            }

            .sales-heatmap-badge {
                border-radius: 999px;
                padding: 8px 10px;
                color: #166534;
                background: rgba(220, 252, 231, 0.86);
                border: 1px solid rgba(34, 197, 94, 0.22);
                font-size: 10px;
                font-weight: 950;
                white-space: nowrap;
            }

            .sales-heatmap-insights {
                display: grid;
                grid-template-columns: repeat(4, minmax(0, 1fr));
                gap: 10px;
                margin-bottom: 15px;
            }

            .sales-heatmap-insight {
                border-radius: 17px;
                padding: 12px;
                background: rgba(248, 250, 252, 0.86);
                border: 1px solid rgba(226, 232, 240, 0.86);
            }

            .sales-heatmap-insight-label {
                color: #94a3b8;
                font-size: 9px;
                font-weight: 950;
                letter-spacing: 0.08em;
                text-transform: uppercase;
            }

            .sales-heatmap-insight-value {
                margin-top: 6px;
                color: #0f172a;
                font-size: 13px;
                font-weight: 950;
                letter-spacing: -0.02em;
            }

            .sales-heatmap-table-wrap {
                overflow-x: auto;
                border-radius: 20px;
                padding: 12px;
                background: rgba(248, 250, 252, 0.72);
                border: 1px solid rgba(226, 232, 240, 0.8);
            }

            .sales-heatmap-grid {
                display: grid;
                gap: 7px;
                min-width: 760px;
                align-items: center;
            }

            .sales-heatmap-axis {
                color: #94a3b8;
                font-size: 10px;
                font-weight: 950;
                text-align: center;
            }

            .sales-heatmap-day {
                color: #64748b;
                font-size: 10px;
                font-weight: 950;
            }

            .sales-heatmap-cell {
                position: relative;
                height: 31px;
                border-radius: 10px;
                border: 1px solid rgba(255, 255, 255, 0.68);
                box-shadow: inset 0 0 0 1px rgba(255, 255, 255, 0.14);
            }

            .sales-heatmap-cell.level-0 {
                background: #f1f5f9;
            }

            .sales-heatmap-cell.level-1 {
                background: #dcfce7;
            }

            .sales-heatmap-cell.level-2 {
                background: #bbf7d0;
            }

            .sales-heatmap-cell.level-3 {
                background: #fed7aa;
            }

            .sales-heatmap-cell.level-4 {
                background: #fb923c;
            }

            .sales-heatmap-cell.level-5 {
                background: #f97316;
            }

            .sales-heatmap-cell:hover::after {
                content: attr(data-tooltip);
                position: absolute;
                z-index: 10;
                left: 50%;
                bottom: calc(100% + 8px);
                transform: translateX(-50%);
                width: max-content;
                max-width: 180px;
                border-radius: 10px;
                padding: 8px 10px;
                color: #ffffff;
                background: #0f172a;
                font-size: 10px;
                font-weight: 850;
                white-space: nowrap;
                box-shadow: 0 14px 28px rgba(15, 23, 42, 0.24);
            }

            .sales-heatmap-legend {
                display: flex;
                justify-content: flex-end;
                align-items: center;
                gap: 8px;
                margin-top: 12px;
                color: #94a3b8;
                font-size: 10px;
                font-weight: 850;
            }

            .sales-heatmap-legend-bar {
                width: 120px;
                height: 9px;
                border-radius: 999px;
                background: linear-gradient(90deg, #f1f5f9, #dcfce7, #fed7aa, #fb923c, #f97316);
                border: 1px solid rgba(226, 232, 240, 0.8);
            }

            @media (max-width: 900px) {
                .sales-heatmap-insights {
                    grid-template-columns: repeat(2, minmax(0, 1fr));
                }
            }

            @media (max-width: 640px) {
                .sales-heatmap-head {
                    flex-direction: column;
                }

                .sales-heatmap-insights {
                    grid-template-columns: 1fr;
                }
            }
        </style>

        <div class="sales-heatmap-card">
            <div class="sales-heatmap-head">
                <div>
                    <h3 class="sales-heatmap-title">Sales Heatmap</h3>
                    <p class="sales-heatmap-subtitle">
                        Intensitas <?php echo e(strtolower($metricLabel)); ?> berdasarkan hari dan jam operasional minggu ini.
                    </p>
                </div>

                <div class="sales-heatmap-badge">
                    <?php echo e($weekLabel); ?>

                </div>
            </div>

            <div class="sales-heatmap-insights">
                <div class="sales-heatmap-insight">
                    <div class="sales-heatmap-insight-label">Peak Day</div>
                    <div class="sales-heatmap-insight-value">
                        <?php echo e($insights['peak_day']); ?>

                    </div>
                </div>

                <div class="sales-heatmap-insight">
                    <div class="sales-heatmap-insight-label">Peak Hour</div>
                    <div class="sales-heatmap-insight-value">
                        <?php echo e($insights['peak_hour']); ?>

                    </div>
                </div>

                <div class="sales-heatmap-insight">
                    <div class="sales-heatmap-insight-label">Peak Value</div>
                    <div class="sales-heatmap-insight-value">
                        <?php echo e($insights['peak_value']); ?>

                    </div>
                </div>

                <div class="sales-heatmap-insight">
                    <div class="sales-heatmap-insight-label">Total Metric</div>
                    <div class="sales-heatmap-insight-value">
                        <?php echo e($totalValue); ?>

                    </div>
                </div>
            </div>

            <div class="sales-heatmap-table-wrap">
                <div
                    class="sales-heatmap-grid"
                    style="grid-template-columns: 54px repeat(<?php echo e(count($hours)); ?>, minmax(36px, 1fr));"
                >
                    <div></div>

                    <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::openLoop(); ?><?php endif; ?><?php $__currentLoopData = $hours; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $hour): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::startLoop($loop->index); ?><?php endif; ?>
                        <div class="sales-heatmap-axis">
                            <?php echo e($hour); ?>

                        </div>
                    <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::endLoop(); ?><?php endif; ?><?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::closeLoop(); ?><?php endif; ?>

                    <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::openLoop(); ?><?php endif; ?><?php $__currentLoopData = $matrix; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $row): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::startLoop($loop->index); ?><?php endif; ?>
                        <div class="sales-heatmap-day">
                            <?php echo e($row['day']); ?>

                        </div>

                        <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::openLoop(); ?><?php endif; ?><?php $__currentLoopData = $row['cells']; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $cell): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::startLoop($loop->index); ?><?php endif; ?>
                            <?php
                                $intensity = (int) $cell['intensity'];

                                $level = match (true) {
                                    $intensity <= 0 => 0,
                                    $intensity <= 20 => 1,
                                    $intensity <= 40 => 2,
                                    $intensity <= 60 => 3,
                                    $intensity <= 80 => 4,
                                    default => 5,
                                };
                            ?>

                            <div
                                class="sales-heatmap-cell level-<?php echo e($level); ?>"
                                data-tooltip="<?php echo e($row['day']); ?> <?php echo e($cell['hour']); ?> • <?php echo e($cell['label']); ?>"
                            ></div>
                        <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::endLoop(); ?><?php endif; ?><?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::closeLoop(); ?><?php endif; ?>
                    <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::endLoop(); ?><?php endif; ?><?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::closeLoop(); ?><?php endif; ?>
                </div>

                <div class="sales-heatmap-legend">
                    <span>Rendah</span>
                    <div class="sales-heatmap-legend-bar"></div>
                    <span>Tinggi</span>
                </div>
            </div>
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
<?php endif; ?><?php /**PATH /var/www/html/resources/views/filament/admin/widgets/sales-heatmap-widget.blade.php ENDPATH**/ ?>