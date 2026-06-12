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
            .stock-alert-card {
                min-height: 420px;
            }

            .stock-alert-head {
                display: flex;
                justify-content: space-between;
                align-items: flex-start;
                gap: 14px;
                margin-bottom: 16px;
            }

            .stock-alert-title {
                margin: 0;
                color: #0f172a;
                font-size: 15px;
                font-weight: 950;
                letter-spacing: -0.03em;
            }

            .stock-alert-subtitle {
                margin: 5px 0 0;
                color: #64748b;
                font-size: 11px;
                font-weight: 650;
                line-height: 1.45;
            }

            .stock-alert-badge {
                border-radius: 999px;
                padding: 8px 10px;
                color: #991b1b;
                background: rgba(254, 226, 226, 0.86);
                border: 1px solid rgba(248, 113, 113, 0.26);
                font-size: 10px;
                font-weight: 950;
                white-space: nowrap;
            }

            .stock-alert-summary {
                display: grid;
                grid-template-columns: repeat(2, minmax(0, 1fr));
                gap: 10px;
                margin-bottom: 14px;
            }

            .stock-alert-summary-box {
                border-radius: 17px;
                padding: 12px;
                background: rgba(248, 250, 252, 0.86);
                border: 1px solid rgba(226, 232, 240, 0.86);
            }

            .stock-alert-summary-label {
                color: #94a3b8;
                font-size: 9px;
                font-weight: 950;
                letter-spacing: 0.08em;
                text-transform: uppercase;
            }

            .stock-alert-summary-value {
                margin-top: 6px;
                color: #0f172a;
                font-size: 17px;
                font-weight: 950;
                letter-spacing: -0.035em;
            }

            .stock-alert-distribution {
                overflow: hidden;
                height: 12px;
                display: flex;
                border-radius: 999px;
                background: rgba(226, 232, 240, 0.95);
                margin-bottom: 12px;
            }

            .stock-alert-segment.safe {
                background: #22c55e;
            }

            .stock-alert-segment.warning {
                background: #f59e0b;
            }

            .stock-alert-segment.low {
                background: #f97316;
            }

            .stock-alert-segment.critical {
                background: #ef4444;
            }

            .stock-alert-legend {
                display: grid;
                grid-template-columns: repeat(4, minmax(0, 1fr));
                gap: 8px;
                margin-bottom: 16px;
            }

            .stock-alert-legend-item {
                border-radius: 14px;
                padding: 9px;
                background: rgba(248, 250, 252, 0.78);
                border: 1px solid rgba(226, 232, 240, 0.76);
            }

            .stock-alert-legend-label {
                color: #64748b;
                font-size: 9px;
                font-weight: 900;
            }

            .stock-alert-legend-value {
                margin-top: 4px;
                color: #0f172a;
                font-size: 13px;
                font-weight: 950;
            }

            .stock-alert-list {
                display: grid;
                gap: 10px;
            }

            .stock-alert-item {
                border-radius: 17px;
                padding: 12px;
                background: rgba(255, 255, 255, 0.92);
                border: 1px solid rgba(226, 232, 240, 0.8);
                box-shadow: 0 10px 24px rgba(15, 23, 42, 0.045);
            }

            .stock-alert-item-head {
                display: flex;
                justify-content: space-between;
                align-items: flex-start;
                gap: 10px;
            }

            .stock-alert-product {
                color: #0f172a;
                font-size: 12px;
                font-weight: 950;
                line-height: 1.25;
            }

            .stock-alert-stock {
                margin-top: 4px;
                color: #64748b;
                font-size: 10px;
                font-weight: 800;
            }

            .stock-alert-status {
                border-radius: 999px;
                padding: 5px 8px;
                font-size: 9px;
                font-weight: 950;
                white-space: nowrap;
            }

            .stock-alert-status.warning {
                color: #92400e;
                background: rgba(254, 243, 199, 0.95);
            }

            .stock-alert-status.low {
                color: #9a3412;
                background: rgba(255, 237, 213, 0.95);
            }

            .stock-alert-status.critical {
                color: #991b1b;
                background: rgba(254, 226, 226, 0.95);
            }

            .stock-alert-progress {
                overflow: hidden;
                height: 7px;
                margin-top: 10px;
                border-radius: 999px;
                background: rgba(226, 232, 240, 0.94);
            }

            .stock-alert-progress-fill {
                height: 100%;
                border-radius: inherit;
                background: linear-gradient(90deg, #ef4444, #f97316, #f59e0b);
            }

            .stock-alert-empty {
                min-height: 180px;
                display: grid;
                place-items: center;
                border-radius: 18px;
                color: #16a34a;
                background: rgba(240, 253, 244, 0.78);
                border: 1px dashed rgba(34, 197, 94, 0.42);
                text-align: center;
                font-size: 12px;
                font-weight: 850;
            }

            @media (max-width: 900px) {
                .stock-alert-legend {
                    grid-template-columns: repeat(2, minmax(0, 1fr));
                }
            }
        </style>

        <div class="stock-alert-card">
            <div class="stock-alert-head">
                <div>
                    <h3 class="stock-alert-title">Low Stock Alert</h3>
                    <p class="stock-alert-subtitle">
                        Pantau produk dengan stok rendah agar restock bisa dilakukan lebih cepat.
                    </p>
                </div>

                <div class="stock-alert-badge">
                    Stock Risk
                </div>
            </div>

            <div class="stock-alert-summary">
                <div class="stock-alert-summary-box">
                    <div class="stock-alert-summary-label">Risk Products</div>
                    <div class="stock-alert-summary-value">
                        <?php echo e(number_format($riskProducts, 0, ',', '.')); ?>

                    </div>
                </div>

                <div class="stock-alert-summary-box">
                    <div class="stock-alert-summary-label">Total Products</div>
                    <div class="stock-alert-summary-value">
                        <?php echo e(number_format($totalProducts, 0, ',', '.')); ?>

                    </div>
                </div>
            </div>

            <div class="stock-alert-distribution">
                <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::openLoop(); ?><?php endif; ?><?php $__currentLoopData = $distribution; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $segment): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::startLoop($loop->index); ?><?php endif; ?>
                    <div
                        class="stock-alert-segment <?php echo e($segment['class']); ?>"
                        style="width: <?php echo e($segment['width']); ?>%;"
                    ></div>
                <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::endLoop(); ?><?php endif; ?><?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::closeLoop(); ?><?php endif; ?>
            </div>

            <div class="stock-alert-legend">
                <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::openLoop(); ?><?php endif; ?><?php $__currentLoopData = $distribution; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $segment): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::startLoop($loop->index); ?><?php endif; ?>
                    <div class="stock-alert-legend-item">
                        <div class="stock-alert-legend-label"><?php echo e($segment['label']); ?></div>
                        <div class="stock-alert-legend-value">
                            <?php echo e(number_format($segment['count'], 0, ',', '.')); ?>

                        </div>
                    </div>
                <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::endLoop(); ?><?php endif; ?><?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::closeLoop(); ?><?php endif; ?>
            </div>

            <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if(count($items) > 0): ?>
                <div class="stock-alert-list">
                    <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::openLoop(); ?><?php endif; ?><?php $__currentLoopData = $items; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $item): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::startLoop($loop->index); ?><?php endif; ?>
                        <div class="stock-alert-item">
                            <div class="stock-alert-item-head">
                                <div>
                                    <div class="stock-alert-product"><?php echo e($item['name']); ?></div>
                                    <div class="stock-alert-stock">
                                        Sisa stok <?php echo e(number_format($item['stock'], 0, ',', '.')); ?>/<?php echo e($item['safeLimit']); ?>

                                    </div>
                                </div>

                                <div class="stock-alert-status <?php echo e($item['statusClass']); ?>">
                                    <?php echo e($item['status']); ?>

                                </div>
                            </div>

                            <div class="stock-alert-progress">
                                <div
                                    class="stock-alert-progress-fill"
                                    style="width: <?php echo e($item['width']); ?>%;"
                                ></div>
                            </div>
                        </div>
                    <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::endLoop(); ?><?php endif; ?><?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::closeLoop(); ?><?php endif; ?>
                </div>
            <?php else: ?>
                <div class="stock-alert-empty">
                    Semua produk berada di atas batas risiko stok.
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
<?php endif; ?><?php /**PATH /var/www/html/resources/views/filament/admin/widgets/restock-priority-chart.blade.php ENDPATH**/ ?>