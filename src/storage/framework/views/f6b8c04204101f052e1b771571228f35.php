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
            .product-quadrant-pbi {
                min-height: 460px;
            }

            .product-quadrant-head {
                display: flex;
                justify-content: space-between;
                gap: 14px;
                margin-bottom: 16px;
            }

            .product-quadrant-title {
                margin: 0;
                color: #0f172a;
                font-size: 15px;
                font-weight: 950;
                letter-spacing: -0.03em;
            }

            .product-quadrant-subtitle {
                margin: 5px 0 0;
                color: #64748b;
                font-size: 11px;
                font-weight: 700;
                line-height: 1.5;
            }

            .product-quadrant-chip {
                height: fit-content;
                padding: 7px 10px;
                border-radius: 999px;
                background: #f5f3ff;
                color: #6d28d9;
                font-size: 10px;
                font-weight: 950;
                white-space: nowrap;
            }

            .product-quadrant-summary {
                display: grid;
                grid-template-columns: repeat(3, minmax(0, 1fr));
                gap: 10px;
                margin-bottom: 14px;
            }

            .product-quadrant-box {
                border-radius: 16px;
                padding: 12px 13px;
                background: #f8fafc;
                border: 1px solid #e2e8f0;
            }

            .product-quadrant-box-label {
                color: #64748b;
                font-size: 10px;
                font-weight: 900;
                text-transform: uppercase;
                letter-spacing: 0.08em;
            }

            .product-quadrant-box-value {
                margin-top: 5px;
                color: #0f172a;
                font-size: 17px;
                font-weight: 950;
                letter-spacing: -0.04em;
                white-space: nowrap;
                overflow: hidden;
                text-overflow: ellipsis;
            }

            .product-quadrant-canvas {
                position: relative;
                min-height: 330px;
                border-radius: 22px;
                background:
                    linear-gradient(90deg, rgba(148,163,184,0.14) 1px, transparent 1px),
                    linear-gradient(0deg, rgba(148,163,184,0.14) 1px, transparent 1px),
                    linear-gradient(180deg, rgba(248,250,252,0.95), rgba(255,255,255,1));
                background-size: 25% 100%, 100% 25%, 100% 100%;
                border: 1px solid #e2e8f0;
                overflow: hidden;
            }

            .product-quadrant-mid-x,
            .product-quadrant-mid-y {
                position: absolute;
                z-index: 2;
                background: rgba(15, 23, 42, 0.16);
            }

            .product-quadrant-mid-x {
                left: 0;
                right: 0;
                top: 50%;
                height: 1px;
            }

            .product-quadrant-mid-y {
                top: 0;
                bottom: 0;
                left: 50%;
                width: 1px;
            }

            .product-quadrant-axis-x,
            .product-quadrant-axis-y {
                position: absolute;
                color: #94a3b8;
                font-size: 10px;
                font-weight: 950;
                text-transform: uppercase;
                letter-spacing: 0.08em;
                z-index: 3;
            }

            .product-quadrant-axis-x {
                right: 16px;
                bottom: 10px;
            }

            .product-quadrant-axis-y {
                left: 12px;
                top: 12px;
            }

            .product-quadrant-label {
                position: absolute;
                z-index: 1;
                padding: 6px 8px;
                border-radius: 999px;
                color: rgba(15, 23, 42, 0.44);
                background: rgba(255,255,255,0.72);
                border: 1px solid rgba(226,232,240,0.85);
                font-size: 10px;
                font-weight: 950;
                text-transform: uppercase;
                letter-spacing: 0.06em;
                pointer-events: none;
            }

            .product-quadrant-label.star {
                right: 16px;
                top: 16px;
            }

            .product-quadrant-label.profit {
                left: 16px;
                top: 16px;
            }

            .product-quadrant-label.fast {
                right: 16px;
                bottom: 34px;
            }

            .product-quadrant-label.under {
                left: 16px;
                bottom: 34px;
            }

            .product-bubble-wrap {
                position: absolute;
                left: var(--x);
                top: var(--y);
                transform: translate(-50%, -50%);
                z-index: 5;
            }

            .product-bubble {
                width: var(--size);
                height: var(--size);
                border-radius: 999px;
                background: linear-gradient(135deg, #0f766e, #14b8a6);
                border: 3px solid white;
                box-shadow: 0 10px 24px rgba(15, 118, 110, 0.24);
                cursor: default;
                transition: 0.18s ease;
            }

            .product-bubble-wrap:hover {
                z-index: 30;
            }

            .product-bubble-wrap:hover .product-bubble {
                transform: scale(1.12);
                box-shadow: 0 16px 34px rgba(15, 118, 110, 0.34);
            }

            .product-bubble-label {
                position: absolute;
                left: 50%;
                top: calc(100% + 4px);
                transform: translateX(-50%);
                max-width: 92px;
                padding: 3px 6px;
                border-radius: 999px;
                background: rgba(255,255,255,0.88);
                border: 1px solid #e2e8f0;
                color: #334155;
                font-size: 9px;
                font-weight: 900;
                white-space: nowrap;
                overflow: hidden;
                text-overflow: ellipsis;
                box-shadow: 0 8px 16px rgba(15,23,42,0.08);
            }

            .product-bubble-wrap:hover::after {
                content: attr(data-tooltip);
                position: absolute;
                left: 50%;
                bottom: calc(100% + 10px);
                transform: translateX(-50%);
                width: max-content;
                max-width: 280px;
                padding: 9px 11px;
                border-radius: 13px;
                background: #0f172a;
                color: white;
                font-size: 10px;
                font-weight: 800;
                line-height: 1.45;
                white-space: pre-line;
                box-shadow: 0 16px 32px rgba(15, 23, 42, 0.25);
            }

            .product-quadrant-empty {
                min-height: 330px;
                display: flex;
                align-items: center;
                justify-content: center;
                border-radius: 20px;
                background: #f8fafc;
                border: 1px dashed #cbd5e1;
                color: #64748b;
                font-size: 12px;
                font-weight: 800;
            }

            @media (max-width: 800px) {
                .product-quadrant-summary {
                    grid-template-columns: 1fr;
                }

                .product-bubble-label {
                    display: none;
                }
            }
        </style>

        <div class="product-quadrant-pbi">
            <div class="product-quadrant-head">
                <div>
                    <h3 class="product-quadrant-title">
                        Product Performance Quadrant
                    </h3>

                    <p class="product-quadrant-subtitle">
                        Scatter quadrant berdasarkan units sold dan revenue pada <?php echo e(strtolower($periodLabel)); ?>.
                    </p>
                </div>

                <span class="product-quadrant-chip">
                    Quadrant Analysis
                </span>
            </div>

            <div class="product-quadrant-summary">
                <div class="product-quadrant-box">
                    <div class="product-quadrant-box-label">Best Product</div>
                    <div class="product-quadrant-box-value" title="<?php echo e($bestProductName); ?>">
                        <?php echo e($bestProductName); ?>

                    </div>
                </div>

                <div class="product-quadrant-box">
                    <div class="product-quadrant-box-label">Top Revenue</div>
                    <div class="product-quadrant-box-value">
                        <?php echo e($bestProductRevenue); ?>

                    </div>
                </div>

                <div class="product-quadrant-box">
                    <div class="product-quadrant-box-label">Products Analyzed</div>
                    <div class="product-quadrant-box-value">
                        <?php echo e(number_format($totalProductsAnalyzed, 0, ',', '.')); ?>

                    </div>
                </div>
            </div>

            <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if(count($items) > 0): ?>
                <div class="product-quadrant-canvas">
                    <div class="product-quadrant-mid-x"></div>
                    <div class="product-quadrant-mid-y"></div>

                    <div class="product-quadrant-axis-y">Revenue</div>
                    <div class="product-quadrant-axis-x">Units Sold</div>

                    <div class="product-quadrant-label star">Star Product</div>
                    <div class="product-quadrant-label profit">Profit Driver</div>
                    <div class="product-quadrant-label fast">Fast Moving</div>
                    <div class="product-quadrant-label under">Underperformer</div>

                    <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::openLoop(); ?><?php endif; ?><?php $__currentLoopData = $items; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $item): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::startLoop($loop->index); ?><?php endif; ?>
                        <div
                            class="product-bubble-wrap"
                            style="
                                --x: <?php echo e($item['x']); ?>%;
                                --y: <?php echo e($item['y']); ?>%;
                                --size: <?php echo e($item['size']); ?>px;
                            "
                            data-tooltip="<?php echo e($item['name']); ?>

<?php echo e($item['formatted_units']); ?>

<?php echo e($item['formatted_revenue']); ?>

<?php echo e($item['formatted_orders']); ?>

<?php echo e($item['quadrant']); ?>"
                        >
                            <div class="product-bubble"></div>

                            <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if($item['show_label']): ?>
                                <div class="product-bubble-label" title="<?php echo e($item['name']); ?>">
                                    <?php echo e($item['short_name']); ?>

                                </div>
                            <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
                        </div>
                    <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::endLoop(); ?><?php endif; ?><?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::closeLoop(); ?><?php endif; ?>
                </div>
            <?php else: ?>
                <div class="product-quadrant-empty">
                    Belum ada data performa produk pada periode ini.
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
<?php endif; ?><?php /**PATH /var/www/html/resources/views/filament/admin/widgets/product-performance-matrix.blade.php ENDPATH**/ ?>