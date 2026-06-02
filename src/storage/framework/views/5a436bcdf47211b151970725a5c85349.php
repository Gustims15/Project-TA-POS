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

         <?php $__env->slot('heading', null, []); ?> 
            <?php echo e($heading ?? 'Product by Category'); ?>

         <?php $__env->endSlot(); ?>

        <?php
            $items = collect($categories)
                ->filter(fn ($item) => (float) $item['percentage'] > 0)
                ->values()
                ->toArray();

            $cx = 230;
            $cy = 170;
            $radius = 78;
            $strokeWidth = 44;
            $outerRadius = $radius + ($strokeWidth / 2);
            $elbowRadius = $outerRadius + 10;
            $labelRadius = $outerRadius + 30;
            $circumference = 2 * pi() * $radius;

            $segments = [];
            $labels = [];

            $dashOffset = 0;
            $currentAngle = -90;

            $clamp = function (float $value, float $min, float $max): float {
                return max($min, min($max, $value));
            };

            $splitLabel = function (string $text): array {
                if (mb_strlen($text) <= 13) {
                    return [$text];
                }

                $words = explode(' ', $text);
                $lines = [];
                $current = '';

                foreach ($words as $word) {
                    $candidate = trim($current . ' ' . $word);

                    if (mb_strlen($candidate) > 13 && $current !== '') {
                        $lines[] = $current;
                        $current = $word;
                    } else {
                        $current = $candidate;
                    }
                }

                if ($current !== '') {
                    $lines[] = $current;
                }

                return array_slice($lines, 0, 2);
            };

            foreach ($items as $category) {
                $percentage = (float) $category['percentage'];
                $sliceAngle = ($percentage / 100) * 360;
                $middleAngle = $currentAngle + ($sliceAngle / 2);
                $angleRad = deg2rad($middleAngle);

                $cos = cos($angleRad);
                $sin = sin($angleRad);

                $dash = ($percentage / 100) * $circumference;
                $gap = $circumference - $dash;

                $lineStartX = $cx + $cos * $outerRadius;
                $lineStartY = $cy + $sin * $outerRadius;

                $elbowX = $cx + $cos * $elbowRadius;
                $elbowY = $cy + $sin * $elbowRadius;

                $naturalX = $cx + $cos * $labelRadius;
                $naturalY = $cy + $sin * $labelRadius;

                if ($sin < -0.72) {
                    $zone = 'top';
                } elseif ($sin > 0.78) {
                    $zone = 'bottom';
                } elseif ($cos >= 0) {
                    $zone = 'right';
                } else {
                    $zone = 'left';
                }

                $segments[] = [
                    'color' => $category['color'],
                    'dash' => $dash,
                    'gap' => $gap,
                    'dashOffset' => $dashOffset,
                ];

                $labels[] = [
                    'name' => $category['name'],
                    'percentage' => $percentage,
                    'color' => $category['color'],
                    'zone' => $zone,
                    'lineStartX' => $lineStartX,
                    'lineStartY' => $lineStartY,
                    'elbowX' => $elbowX,
                    'elbowY' => $elbowY,
                    'naturalX' => $naturalX,
                    'naturalY' => $naturalY,
                    'nameLines' => $splitLabel($category['name']),
                ];

                $dashOffset += $dash;
                $currentAngle += $sliceAngle;
            }

            $topLabels = array_values(array_filter($labels, fn ($label) => $label['zone'] === 'top'));
            $bottomLabels = array_values(array_filter($labels, fn ($label) => $label['zone'] === 'bottom'));
            $leftLabels = array_values(array_filter($labels, fn ($label) => $label['zone'] === 'left'));
            $rightLabels = array_values(array_filter($labels, fn ($label) => $label['zone'] === 'right'));

            usort($topLabels, fn ($a, $b) => $a['naturalX'] <=> $b['naturalX']);
            usort($bottomLabels, fn ($a, $b) => $a['naturalX'] <=> $b['naturalX']);
            usort($leftLabels, fn ($a, $b) => $a['naturalY'] <=> $b['naturalY']);
            usort($rightLabels, fn ($a, $b) => $a['naturalY'] <=> $b['naturalY']);

            $distributeVertical = function (array $labelList, string $side) use ($clamp) {
                $count = count($labelList);

                if ($count === 0) {
                    return [];
                }

                $minY = 92;
                $maxY = 272;
                $gap = 40;

                for ($i = 0; $i < $count; $i++) {
                    $labelList[$i]['targetY'] = $clamp($labelList[$i]['naturalY'], $minY, $maxY);
                }

                for ($i = 1; $i < $count; $i++) {
                    if (($labelList[$i]['targetY'] - $labelList[$i - 1]['targetY']) < $gap) {
                        $labelList[$i]['targetY'] = $labelList[$i - 1]['targetY'] + $gap;
                    }
                }

                $overflow = $labelList[$count - 1]['targetY'] - $maxY;

                if ($overflow > 0) {
                    for ($i = 0; $i < $count; $i++) {
                        $labelList[$i]['targetY'] -= $overflow;
                    }
                }

                for ($i = $count - 2; $i >= 0; $i--) {
                    if (($labelList[$i + 1]['targetY'] - $labelList[$i]['targetY']) < $gap) {
                        $labelList[$i]['targetY'] = $labelList[$i + 1]['targetY'] - $gap;
                    }
                }

                foreach ($labelList as &$label) {
                    if ($side === 'right') {
                        $label['lineEndX'] = 355;
                        $label['lineEndY'] = $label['targetY'];
                        $label['textX'] = 367;
                        $label['textY'] = $label['targetY'] - 8;
                        $label['anchor'] = 'start';
                    } else {
                        $label['lineEndX'] = 105;
                        $label['lineEndY'] = $label['targetY'];
                        $label['textX'] = 93;
                        $label['textY'] = $label['targetY'] - 8;
                        $label['anchor'] = 'end';
                    }
                }
                unset($label);

                return $labelList;
            };

            $distributeHorizontal = function (array $labelList, string $side) use ($clamp) {
                $count = count($labelList);

                if ($count === 0) {
                    return [];
                }

                $minX = 110;
                $maxX = 350;
                $gap = 68;

                for ($i = 0; $i < $count; $i++) {
                    $labelList[$i]['targetX'] = $clamp($labelList[$i]['naturalX'], $minX, $maxX);
                }

                for ($i = 1; $i < $count; $i++) {
                    if (($labelList[$i]['targetX'] - $labelList[$i - 1]['targetX']) < $gap) {
                        $labelList[$i]['targetX'] = $labelList[$i - 1]['targetX'] + $gap;
                    }
                }

                $overflow = $labelList[$count - 1]['targetX'] - $maxX;

                if ($overflow > 0) {
                    for ($i = 0; $i < $count; $i++) {
                        $labelList[$i]['targetX'] -= $overflow;
                    }
                }

                for ($i = $count - 2; $i >= 0; $i--) {
                    if (($labelList[$i + 1]['targetX'] - $labelList[$i]['targetX']) < $gap) {
                        $labelList[$i]['targetX'] = $labelList[$i + 1]['targetX'] - $gap;
                    }
                }

                foreach ($labelList as &$label) {
                    if ($side === 'top') {
                        $label['lineEndX'] = $label['targetX'];
                        $label['lineEndY'] = 70;
                        $label['textX'] = $label['targetX'];
                        $label['textY'] = 34;
                        $label['anchor'] = 'middle';
                    } else {
                        $label['lineEndX'] = $label['targetX'];
                        $label['lineEndY'] = 292;
                        $label['textX'] = $label['targetX'];
                        $label['textY'] = 310;
                        $label['anchor'] = 'middle';
                    }
                }
                unset($label);

                return $labelList;
            };

            $finalLabels = array_merge(
                $distributeHorizontal($topLabels, 'top'),
                $distributeVertical($leftLabels, 'left'),
                $distributeVertical($rightLabels, 'right'),
                $distributeHorizontal($bottomLabels, 'bottom'),
            );
        ?>

        <div class="w-full overflow-hidden">
            <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if(count($items) === 0): ?>
                <div class="flex h-[340px] items-center justify-center text-sm text-gray-500 dark:text-gray-400">
                    Belum ada data <?php echo e(strtolower($metricLabel ?? 'penjualan')); ?> kategori.
                </div>
            <?php else: ?>
                <svg
                    viewBox="0 0 460 340"
                    class="h-[320px] w-full"
                    role="img"
                    aria-label="<?php echo e($heading ?? 'Product by Category Chart'); ?>"
                >
                    <circle
                        cx="<?php echo e($cx); ?>"
                        cy="<?php echo e($cy); ?>"
                        r="<?php echo e($radius); ?>"
                        fill="none"
                        stroke="#e5e7eb"
                        stroke-width="<?php echo e($strokeWidth); ?>"
                        class="dark:stroke-gray-700"
                    />

                    <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::openLoop(); ?><?php endif; ?><?php $__currentLoopData = $segments; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $segment): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::startLoop($loop->index); ?><?php endif; ?>
                        <circle
                            cx="<?php echo e($cx); ?>"
                            cy="<?php echo e($cy); ?>"
                            r="<?php echo e($radius); ?>"
                            fill="none"
                            stroke="<?php echo e($segment['color']); ?>"
                            stroke-width="<?php echo e($strokeWidth); ?>"
                            stroke-dasharray="<?php echo e($segment['dash']); ?> <?php echo e($segment['gap']); ?>"
                            stroke-dashoffset="<?php echo e(-$segment['dashOffset']); ?>"
                            stroke-linecap="butt"
                            transform="rotate(-90 <?php echo e($cx); ?> <?php echo e($cy); ?>)"
                        />
                    <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::endLoop(); ?><?php endif; ?><?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::closeLoop(); ?><?php endif; ?>

                    <circle
                        cx="<?php echo e($cx); ?>"
                        cy="<?php echo e($cy); ?>"
                        r="49"
                        fill="white"
                        class="dark:fill-gray-900"
                    />

                    <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::openLoop(); ?><?php endif; ?><?php $__currentLoopData = $finalLabels; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $label): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::startLoop($loop->index); ?><?php endif; ?>
                        <polyline
                            points="<?php echo e($label['lineStartX']); ?>,<?php echo e($label['lineStartY']); ?> <?php echo e($label['elbowX']); ?>,<?php echo e($label['elbowY']); ?> <?php echo e($label['lineEndX']); ?>,<?php echo e($label['lineEndY']); ?>"
                            fill="none"
                            stroke="#94a3b8"
                            stroke-width="1.3"
                            stroke-linecap="round"
                            stroke-linejoin="round"
                        />

                        <?php
                            $lineCount = count($label['nameLines']);
                            $firstLineY = $lineCount === 1
                                ? $label['textY']
                                : $label['textY'] - 7;
                        ?>

                        <text
                            x="<?php echo e($label['textX']); ?>"
                            y="<?php echo e($firstLineY); ?>"
                            text-anchor="<?php echo e($label['anchor']); ?>"
                            class="fill-gray-900 text-[11px] font-medium dark:fill-gray-100"
                        >
                            <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::openLoop(); ?><?php endif; ?><?php $__currentLoopData = $label['nameLines']; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $index => $line): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::startLoop($loop->index); ?><?php endif; ?>
                                <tspan
                                    x="<?php echo e($label['textX']); ?>"
                                    dy="<?php echo e($index === 0 ? 0 : 12); ?>"
                                >
                                    <?php echo e($line); ?>

                                </tspan>
                            <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::endLoop(); ?><?php endif; ?><?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::closeLoop(); ?><?php endif; ?>

                            <tspan
                                x="<?php echo e($label['textX']); ?>"
                                dy="13"
                                class="fill-gray-800 text-[11px] font-semibold dark:fill-gray-200"
                            >
                                <?php echo e(number_format((float) $label['percentage'], 2)); ?>%
                            </tspan>
                        </text>
                    <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::endLoop(); ?><?php endif; ?><?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::closeLoop(); ?><?php endif; ?>
                </svg>
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
<?php endif; ?><?php /**PATH /var/www/html/resources/views/filament/admin/widgets/product-category-chart.blade.php ENDPATH**/ ?>