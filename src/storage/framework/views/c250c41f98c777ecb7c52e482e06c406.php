<?php if (isset($component)) { $__componentOriginal166a02a7c5ef5a9331faf66fa665c256 = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginal166a02a7c5ef5a9331faf66fa665c256 = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'filament-panels::components.page.index','data' => []] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('filament-panels::page'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes([]); ?>
<?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::processComponentKey($component); ?>

    <?php
        $finance = $this->getFinancialDashboardData();

        $period = $finance['period'] ?? [];
        $activePeriod = $period['key'] ?? 'month';

        $summary = $finance['summary'] ?? [];
        $metrics = collect($finance['metrics'] ?? [])->keyBy('label');
        $costs = collect($finance['costs'] ?? []);
        $costPages = $costs->chunk(5)->values();
        $totalCostPages = max(1, $costPages->count());
        $links = $finance['links'] ?? [];
        $revenueTrend = collect($finance['revenueTrend'] ?? []);

        $filters = $finance['filters'] ?? [];
        $selectedMonth = (string) ($period['selected_month'] ?? $filters['selected_month'] ?? request()->query('month', 'all'));
        $selectedYear = (int) ($period['selected_year'] ?? $filters['selected_year'] ?? request()->query('year', now()->year));
        $months = $filters['months'] ?? [
            'all' => 'Semua Bulan',
            '1' => 'Januari',
            '2' => 'Februari',
            '3' => 'Maret',
            '4' => 'April',
            '5' => 'Mei',
            '6' => 'Juni',
            '7' => 'Juli',
            '8' => 'Agustus',
            '9' => 'September',
            '10' => 'Oktober',
            '11' => 'November',
            '12' => 'Desember',
        ];

        $selectedMonthLabel = $months[$selectedMonth] ?? 'Bulan Ini';
        $availableYears = range(now()->year - 4, now()->year + 1);

        $baseDashboardUrl = $links['dashboard_keuangan'] ?? url('/admin/dashboard-keuangan');

        $makeMonthlyUrl = function (string $month, int $year) use ($baseDashboardUrl) {
            return $baseDashboardUrl . '?' . http_build_query([
                'month' => $month,
                'year' => $year,
            ]);
        };

        $periods = [
            'month' => 'Bulanan',
        ];

        $revenue = (int) ($summary['revenue'] ?? 0);
        $grossProfit = (int) ($summary['gross_profit'] ?? 0);
        $operationalCost = (int) ($summary['operational_cost'] ?? 0);
        $netProfit = (int) ($summary['net_profit'] ?? 0);

        $targetRevenue = (int) ($summary['target_revenue'] ?? 0);
        $targetGrossProfit = (int) ($summary['target_gross_profit'] ?? 0);
        $targetNetProfit = (int) ($summary['target_net_profit'] ?? 0);

        $targetItems = [
            [
                'title' => 'Target Revenue',
                'actual' => (int) ($summary['target_revenue_actual'] ?? 0),
                'target' => $targetRevenue,
                'icon' => '↗',
                'color' => '#f97316',
            ],
            [
                'title' => 'Target Gross Profit',
                'actual' => (int) ($summary['target_gross_profit_actual'] ?? 0),
                'target' => $targetGrossProfit,
                'icon' => '◔',
                'color' => '#16a34a',
            ],
            [
                'title' => 'Target Net Profit',
                'actual' => (int) ($summary['target_net_profit_actual'] ?? 0),
                'target' => $targetNetProfit,
                'icon' => '▥',
                'color' => $netProfit >= 0 ? '#16a34a' : '#ef4444',
            ],
        ];

        $trendFor = fn (string $label) => $metrics->get($label)['trend'] ?? null;

        $kpiCards = [
            [
                'label' => 'Revenue',
                'value' => $this->rupiah($revenue),
                'trend' => $trendFor('Revenue'),
                'icon' => '↗',
                'color' => '#f97316',
                'trend_good_when' => 'up',
            ],
            [
                'label' => 'Gross Profit',
                'value' => $this->rupiah($grossProfit),
                'trend' => $trendFor('Gross Profit'),
                'icon' => '◔',
                'color' => '#16a34a',
                'trend_good_when' => 'up',
            ],
            [
                'label' => 'Biaya Operasional',
                'value' => $this->rupiah($operationalCost),
                'trend' => $trendFor('Biaya Operasional'),
                'icon' => '▣',
                'color' => '#f97316',
                'trend_good_when' => 'down',
            ],
            [
                'label' => 'Net Profit',
                'value' => $this->rupiah($netProfit),
                'trend' => $trendFor('Net Profit'),
                'icon' => '▥',
                'color' => $netProfit >= 0 ? '#f97316' : '#ef4444',
                'trend_good_when' => 'up',
            ],
        ];

        $maxRevenueTrend = max(1, (int) $revenueTrend->max('value'));

        $niceChartMax = max(1, (int) (ceil($maxRevenueTrend / 50000) * 50000));

        $formatShortMoney = function (int|float $value): string {
            $value = (int) $value;

            if ($value >= 1000000000) {
                return rtrim(rtrim(number_format($value / 1000000000, 1, ',', '.'), '0'), ',') . 'M';
            }

            if ($value >= 1000000) {
                return rtrim(rtrim(number_format($value / 1000000, 1, ',', '.'), '0'), ',') . 'jt';
            }

            if ($value >= 1000) {
                return rtrim(rtrim(number_format($value / 1000, 1, ',', '.'), '0'), ',') . 'rb';
            }

            return (string) $value;
        };

        $dateRangeLabel = ($period['start'] ?? '-') . ' - ' . ($period['end'] ?? '-');
        $customStartDate = (string) ($period['start_query'] ?? request()->query('start_date', now()->startOfMonth()->toDateString()));
        $customEndDate = (string) ($period['end_query'] ?? request()->query('end_date', now()->endOfMonth()->toDateString()));
    ?>

    <div class="ng-finance-dashboard-new">
        <section class="ng-topbar">
            <div class="ng-title-area">
                <h1>Dashboard Keuangan</h1>
                <p>Ringkasan kinerja keuangan Ngunjuk POS</p>
                <small class="ng-active-data-label">
                    Data bulan aktif: <?php echo e($selectedMonthLabel); ?> <?php echo e($selectedYear); ?> • <?php echo e($dateRangeLabel); ?>

                </small>
            </div>

            <div class="ng-filter-area">
                <div class="ng-monthly-filter-block">
                    <span class="ng-filter-label">Periode Bulanan</span>

                    <div class="ng-monthly-filter-card">
                        <select class="ng-monthly-select" onchange="window.location.href = this.value">
                            <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::openLoop(); ?><?php endif; ?><?php $__currentLoopData = $months; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $monthKey => $monthLabel): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::startLoop($loop->index); ?><?php endif; ?>
                                <?php if($monthKey === 'all') continue; ?>

                                <option value="<?php echo e($makeMonthlyUrl((string) $monthKey, $selectedYear)); ?>"
                                        <?php if((string) $selectedMonth === (string) $monthKey): echo 'selected'; endif; ?>>
                                    <?php echo e($monthLabel); ?>

                                </option>
                            <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::endLoop(); ?><?php endif; ?><?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::closeLoop(); ?><?php endif; ?>
                        </select>

                        <select class="ng-monthly-select ng-year-select" onchange="window.location.href = this.value">
                            <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::openLoop(); ?><?php endif; ?><?php $__currentLoopData = $availableYears; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $yearOption): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::startLoop($loop->index); ?><?php endif; ?>
                                <option value="<?php echo e($makeMonthlyUrl((string) $selectedMonth, (int) $yearOption)); ?>"
                                        <?php if((int) $selectedYear === (int) $yearOption): echo 'selected'; endif; ?>>
                                    <?php echo e($yearOption); ?>

                                </option>
                            <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::endLoop(); ?><?php endif; ?><?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::closeLoop(); ?><?php endif; ?>
                        </select>
                    </div>
                </div>
            </div>
        </section>

        <section class="ng-kpi-grid">
            <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::openLoop(); ?><?php endif; ?><?php $__currentLoopData = $kpiCards; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $card): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::startLoop($loop->index); ?><?php endif; ?>
                <?php
                    $trend = $card['trend'];
                    $trendValue = is_null($trend) ? 0 : (float) $trend;
                    $isTrendUp = $trendValue >= 0;
                    $isGood = ($card['trend_good_when'] ?? 'up') === 'up'
                        ? $isTrendUp
                        : ! $isTrendUp;
                ?>

                <article class="ng-kpi-card" style="--accent: <?php echo e($card['color']); ?>;">
                    <div class="ng-kpi-icon">
                        <?php echo e($card['icon']); ?>

                    </div>

                    <div class="ng-kpi-content">
                        <span><?php echo e($card['label']); ?></span>
                        <strong><?php echo e($card['value']); ?></strong>

                        <p class="<?php echo e($isGood ? 'positive' : 'negative'); ?>">
                            <?php echo e($isTrendUp ? '↑' : '↓'); ?>

                            <?php echo e(number_format(abs($trendValue), 1, ',', '.')); ?>%
                            <em>dibandingkan periode sebelumnya</em>
                        </p>
                    </div>
                </article>
            <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::endLoop(); ?><?php endif; ?><?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::closeLoop(); ?><?php endif; ?>
        </section>

        <section class="ng-visual-grid">
            <article class="ng-card ng-revenue-card">
                <div class="ng-card-head">
                    <div>
                        <h2>Tren Revenue Mingguan <?php echo e($selectedMonthLabel); ?> <?php echo e($selectedYear); ?></h2>
                        <p>Ringkasan revenue per minggu dalam bulan aktif</p>
                    </div>
                </div>

                <div class="ng-chart-responsive">
                    <div class="ng-y-axis">
                        <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::openLoop(); ?><?php endif; ?><?php $__currentLoopData = [1, .75, .5, .25, 0]; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $step): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::startLoop($loop->index); ?><?php endif; ?>
                            <span><?php echo e($formatShortMoney((int) ($niceChartMax * $step))); ?></span>
                        <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::endLoop(); ?><?php endif; ?><?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::closeLoop(); ?><?php endif; ?>
                    </div>

                    <div class="ng-chart-area ng-chart-area-static">
                        <div class="ng-grid-lines">
                            <i></i>
                            <i></i>
                            <i></i>
                            <i></i>
                            <i></i>
                        </div>

                        <div class="ng-bars ng-bars-weekly" style="--bar-count: <?php echo e(max($revenueTrend->count(), 1)); ?>;">
                            <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::openLoop(); ?><?php endif; ?><?php $__empty_1 = true; $__currentLoopData = $revenueTrend; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $row): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::startLoop($loop->index); ?><?php endif; ?>
                                <?php
                                    $value = (int) ($row['value'] ?? 0);
                                    $height = $niceChartMax > 0 ? max(3, min(100, ($value / $niceChartMax) * 100)) : 0;
                                    $tooltipLabel = $row['tooltip_label'] ?? ($row['label'] ?? '-');
                                ?>

                                <div class="ng-bar-item" tabindex="0" style="--item-index: <?php echo e($loop->index); ?>;">
                                    <div class="ng-chart-tooltip">
                                        <strong><?php echo e($tooltipLabel); ?></strong>

                                        <div class="ng-chart-tooltip-row">
                                            <span class="ng-chart-tooltip-dot"></span>
                                            <span>Revenue:</span>
                                            <b><?php echo e($this->rupiah($value)); ?></b>
                                        </div>
                                    </div>

                                    <div class="ng-bar-wrap">
                                        <span style="height: <?php echo e($height); ?>%;"></span>
                                    </div>

                                    <small><?php echo e($row['short_label'] ?? $row['label'] ?? '-'); ?></small>
                                </div>
                            <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::endLoop(); ?><?php endif; ?><?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::closeLoop(); ?><?php endif; ?>
                                <div class="ng-empty-state">
                                    Belum ada data revenue.
                                </div>
                            <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
                        </div>
                    </div>
                </div>

                <div class="ng-chart-caption">
                    Ringkasan mingguan • Data dalam Rupiah (Rp)
                </div>
            </article>

            <article class="ng-card ng-target-card">
                <div class="ng-card-head">
                    <div>
                        <h2>Progress Target</h2>
                        <p>Progress target mengikuti bulan aktif yang dipilih</p>
                    </div>
                </div>

                <div class="ng-target-list">
                    <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::openLoop(); ?><?php endif; ?><?php $__currentLoopData = $targetItems; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $target): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::startLoop($loop->index); ?><?php endif; ?>
                        <?php
                            $actual = (int) ($target['actual'] ?? 0);
                            $targetValue = (int) ($target['target'] ?? 0);
                            $percent = $targetValue > 0 ? round(($actual / $targetValue) * 100, 1) : 0;
                            $barWidth = $targetValue > 0 ? min(100, max(5, abs($percent))) : 0;
                            $remaining = $targetValue > 0 ? max($targetValue - $actual, 0) : 0;
                            $isNegativeProgress = $percent < 0;
                        ?>

                        <div class="ng-target-row" style="--target-color: <?php echo e($target['color']); ?>">
                            <div class="ng-target-icon">
                                <?php echo e($target['icon']); ?>

                            </div>

                            <div class="ng-target-main">
                                <div class="ng-target-top">
                                    <div>
                                        <strong><?php echo e($target['title']); ?></strong>
                                        <span><?php echo e($this->rupiah($actual)); ?></span>
                                    </div>

                                    <div>
                                        <strong><?php echo e($targetValue > 0 ? $this->rupiah($targetValue) : 'Target belum diatur'); ?></strong>
                                    </div>

                                    <b class="<?php echo e($isNegativeProgress ? 'negative' : 'positive'); ?>">
                                        <?php echo e(number_format($percent, 1, ',', '.')); ?>%
                                    </b>
                                </div>

                                <div class="ng-target-track <?php echo e($isNegativeProgress ? 'danger' : ''); ?>">
                                    <i style="width: <?php echo e($barWidth); ?>%;"></i>
                                </div>

                                <div class="ng-target-bottom">
                                    <span></span>
                                    <small><?php echo e($targetValue > 0 ? 'Sisa ' . $this->rupiah($remaining) : 'Silakan atur target penjualan'); ?></small>
                                </div>
                            </div>
                        </div>
                    <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::endLoop(); ?><?php endif; ?><?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::closeLoop(); ?><?php endif; ?>
                </div>
            </article>
        </section>

        <section class="ng-card ng-cost-table-card">
            <div class="ng-table-head">
                <div>
                    <h2>Rincian Biaya Operasional</h2>
                    <p>Biaya aktif yang dihitung pada bulan dashboard</p>
                </div>

                <div class="ng-table-actions">
                    <a href="<?php echo e($links['operational_costs'] ?? '#'); ?>">⚙ Kelola Biaya</a>
                    <a href="<?php echo e($links['operational_costs'] ?? '#'); ?>">↧ Export</a>
                </div>
            </div>

            <div class="ng-cost-table-wrap">
                <table class="ng-cost-table">
                    <thead>
                        <tr>
                            <th>Nama Biaya</th>
                            <th>Kategori</th>
                            <th>Tipe Biaya</th>
                            <th>Tanggal Bayar</th>
                            <th>Nominal Input</th>
                            <th>Dihitung Bulan Ini</th>
                            <th>Status</th>
                        </tr>
                    </thead>

                    <tbody>
                        <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if($costs->count() > 0): ?>
                            <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::openLoop(); ?><?php endif; ?><?php $__currentLoopData = $costPages; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $pageIndex => $costPage): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::startLoop($loop->index); ?><?php endif; ?>
                                <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::openLoop(); ?><?php endif; ?><?php $__currentLoopData = $costPage; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $cost): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::startLoop($loop->index); ?><?php endif; ?>
                                    <tr class="ng-cost-page-row <?php echo e($pageIndex === 0 ? 'is-active' : ''); ?>"
                                        data-cost-page="<?php echo e($pageIndex + 1); ?>">
                                        <td>
                                            <div class="ng-cost-category">
                                                <span>▣</span>
                                                <strong><?php echo e($cost['name'] ?? '-'); ?></strong>
                                            </div>
                                        </td>
                                        <td><?php echo e($cost['category'] ?? '-'); ?></td>
                                        <td>
                                            <span class="ng-cost-type-badge <?php echo e(! empty($cost['is_annual']) ? 'annual' : ''); ?>">
                                                <?php echo e($cost['cost_type_label'] ?? '-'); ?>

                                            </span>
                                        </td>
                                        <td><?php echo e($cost['date'] ?? '-'); ?></td>
                                        <td><?php echo e($this->rupiah($cost['input_amount'] ?? $cost['amount'] ?? 0)); ?></td>
                                        <td class="ng-money">
                                            <?php echo e($this->rupiah($cost['amount'] ?? 0)); ?>

                                            <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if(! empty($cost['is_annual'])): ?>
                                                <small><?php echo e($cost['description'] ?? 'Tahunan / 12'); ?></small>
                                            <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
                                        </td>
                                        <td><span class="ng-status-paid">Dihitung</span></td>
                                    </tr>
                                <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::endLoop(); ?><?php endif; ?><?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::closeLoop(); ?><?php endif; ?>
                            <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::endLoop(); ?><?php endif; ?><?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::closeLoop(); ?><?php endif; ?>
                        <?php else: ?>
                            <tr>
                                <td colspan="7">
                                    <div class="ng-empty-state">
                                        Belum ada biaya operasional.
                                    </div>
                                </td>
                            </tr>
                        <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
                    </tbody>
                </table>
            </div>

            <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if($costs->count() > 0): ?>
                <div class="ng-table-footer"
                     data-total-costs="<?php echo e($costs->count()); ?>"
                     data-per-page="5"
                     data-total-pages="<?php echo e($totalCostPages); ?>">
                    <span class="ng-cost-page-info">
                        1 - <?php echo e(number_format(min(5, $costs->count()), 0, ',', '.')); ?>

                        dari <?php echo e(number_format($costs->count(), 0, ',', '.')); ?>

                    </span>

                    <div class="ng-cost-pagination">
                        <button type="button"
                                class="ng-cost-page-btn is-disabled"
                                data-cost-prev
                                aria-label="Data biaya sebelumnya">
                            ‹
                        </button>

                        <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php for($page = 1; $page <= $totalCostPages; $page++): ?>
                            <button type="button"
                                    class="ng-cost-page-number <?php echo e($page === 1 ? 'is-active' : ''); ?>"
                                    data-cost-page-button="<?php echo e($page); ?>"
                                    aria-label="Halaman biaya <?php echo e($page); ?>">
                                <?php echo e($page); ?>

                            </button>
                        <?php endfor; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>

                        <button type="button"
                                class="ng-cost-page-btn <?php echo e($totalCostPages <= 1 ? 'is-disabled' : ''); ?>"
                                data-cost-next
                                aria-label="Data biaya berikutnya">
                            ›
                        </button>
                    </div>
                </div>
            <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
        </section>
    </div>

    <style>
        html,
        body {
            overflow-x: hidden !important;
        }

        body:has(.ng-finance-dashboard-new) {
            background:
                linear-gradient(120deg, rgba(255, 248, 237, .18), rgba(255, 224, 185, .05)),
                url('/images/pos-orange-bg.png'),
                radial-gradient(circle at 15% 8%, rgba(255, 255, 255, .48) 0 130px, transparent 280px),
                radial-gradient(circle at 88% 78%, rgba(255, 118, 0, .42) 0 250px, transparent 520px),
                radial-gradient(circle at 20% 96%, rgba(255, 181, 83, .30) 0 220px, transparent 500px),
                linear-gradient(135deg, #fff3df 0%, #ffd394 48%, #ff9c45 100%) !important;
            background-size: cover !important;
            background-position: center !important;
            background-attachment: fixed !important;
        }

        body:has(.ng-finance-dashboard-new) .fi-main,
        body:has(.ng-finance-dashboard-new) .fi-main-ctn,
        body:has(.ng-finance-dashboard-new) .fi-page,
        body:has(.ng-finance-dashboard-new) .fi-page-content {
            width: 100% !important;
            max-width: 100% !important;
            background: transparent !important;
            overflow-x: hidden !important;
        }

        body:has(.ng-finance-dashboard-new) .fi-page,
        body:has(.ng-finance-dashboard-new) .fi-main {
            padding: 0 !important;
        }

        body:has(.ng-finance-dashboard-new) .fi-page-header {
            display: none !important;
        }

        .ng-finance-dashboard-new {
            width: 100%;
            min-height: 100vh;
            padding: 24px 24px 32px;
            color: #24180f;
            font-family: Inter, Poppins, ui-sans-serif, system-ui, -apple-system, BlinkMacSystemFont, "Segoe UI", sans-serif;
        }

        .ng-finance-dashboard-new * {
            box-sizing: border-box;
        }

        .ng-topbar {
            display: flex;
            align-items: flex-start;
            justify-content: space-between;
            gap: 18px;
            margin-bottom: 22px;
        }

        .ng-title-area h1 {
            margin: 0;
            color: #21160d;
            font-size: 31px;
            line-height: 1.08;
            font-weight: 950;
            letter-spacing: -.045em;
        }

        .ng-title-area p {
            margin: 6px 0 0;
            color: #765d45;
            font-size: 14px;
            font-weight: 700;
        }

        .ng-filter-area {
            display: flex;
            align-items: center;
            justify-content: flex-end;
            gap: 14px;
            flex-wrap: wrap;
        }



        /*
        |--------------------------------------------------------------------------
        | MONTHLY ONLY FILTER
        |--------------------------------------------------------------------------
        */

        .ng-monthly-filter-block {
            display: grid;
            gap: 8px;
        }

        .ng-filter-label {
            color: #d95d00;
            font-size: 12px;
            line-height: 1;
            font-weight: 950;
            letter-spacing: .04em;
            text-transform: uppercase;
        }

        .ng-monthly-filter-card {
            min-height: 56px;
            display: flex;
            align-items: center;
            gap: 10px;
            padding: 6px;
            border-radius: 18px;
            border: 1px solid rgba(255, 255, 255, .62);
            background: rgba(255, 255, 255, .52);
            box-shadow: 0 18px 50px rgba(120, 74, 30, .09), inset 0 1px 0 rgba(255, 255, 255, .66);
            backdrop-filter: blur(13px);
            -webkit-backdrop-filter: blur(13px);
        }

        .ng-monthly-select {
            min-width: 170px;
            min-height: 44px;
            border: 0;
            outline: 0;
            cursor: pointer;
            border-radius: 13px;
            padding: 0 14px;
            color: #2d1f16;
            background: rgba(255, 255, 255, .48);
            font-size: 14px;
            font-weight: 950;
        }

        .ng-year-select {
            min-width: 112px;
        }

        .ng-monthly-select:focus {
            box-shadow: 0 0 0 2px rgba(249, 115, 22, .22);
        }

        .ng-monthly-select option {
            color: #2d1f16;
            background: #fff6ea;
            font-weight: 850;
        }

        .ng-active-data-label {
            display: block;
            width: fit-content;
            margin-top: 8px;
            padding: 7px 12px;
            border-radius: 999px;
            color: #d95d00;
            background: rgba(255, 255, 255, .36);
            border: 1px solid rgba(255, 255, 255, .50);
            font-size: 12px;
            font-weight: 900;
            box-shadow: inset 0 1px 0 rgba(255, 255, 255, .44);
            backdrop-filter: blur(12px);
            -webkit-backdrop-filter: blur(12px);
        }

        .ng-target-filter {
            min-height: 56px;
            display: flex;
            align-items: center;
            gap: 12px;
            padding: 7px 14px;
            border-radius: 16px;
            border: 1px solid rgba(255, 255, 255, .62);
            background: rgba(255, 255, 255, .52);
            box-shadow: 0 18px 50px rgba(120, 74, 30, .09), inset 0 1px 0 rgba(255, 255, 255, .66);
            backdrop-filter: blur(13px);
            -webkit-backdrop-filter: blur(13px);
        }

        .ng-target-filter span {
            color: #d95d00;
            font-size: 12px;
            font-weight: 950;
            white-space: nowrap;
        }

        .ng-target-month-select {
            min-width: 150px;
            min-height: 38px;
            border: 0;
            outline: 0;
            cursor: pointer;
            color: #2d1f16;
            background: rgba(255, 255, 255, .25);
            border-radius: 12px;
            padding: 0 10px;
            font-size: 13px;
            font-weight: 950;
        }

        .ng-target-month-select option {
            color: #2d1f16;
            background: #fff6ea;
            font-weight: 850;
        }


        .ng-period-tabs,
        .ng-date-chip,
        .ng-month-select-wrap {
            display: flex;
            align-items: center;
            border: 1px solid rgba(255, 255, 255, .62);
            background: rgba(255, 255, 255, .52);
            box-shadow: 0 18px 50px rgba(120, 74, 30, .09), inset 0 1px 0 rgba(255, 255, 255, .66);
            backdrop-filter: blur(13px);
            -webkit-backdrop-filter: blur(13px);
        }

        .ng-period-tabs {
            min-height: 56px;
            gap: 7px;
            padding: 6px;
            border-radius: 18px;
        }

        .ng-tab {
            min-height: 42px;
            display: inline-flex;
            align-items: center;
            justify-content: center;
            padding: 0 20px;
            border-radius: 13px;
            color: #3f3024;
            font-size: 13px;
            font-weight: 900;
            text-decoration: none;
            white-space: nowrap;
            transition: .2s ease;
        }

        .ng-tab.active,
        .ng-tab:hover {
            color: #fff;
            background: linear-gradient(135deg, #ff9d18, #ee6500);
            box-shadow: 0 12px 22px rgba(238, 101, 0, .24);
        }

        .ng-date-chip,
        .ng-month-select-wrap {
            min-height: 56px;
            padding: 0 16px;
            border-radius: 16px;
            gap: 11px;
        }

        .ng-date-chip span,
        .ng-date-chip i {
            color: #594433;
            font-style: normal;
            font-weight: 950;
        }

        .ng-date-chip strong {
            color: #2d1f16;
            font-size: 13px;
            font-weight: 900;
            white-space: nowrap;
        }

        .ng-month-select {
            width: 160px;
            min-height: 38px;
            border: 0;
            outline: 0;
            color: #3f3024;
            background: transparent;
            font-size: 13px;
            font-weight: 900;
        }

        .ng-kpi-grid {
            display: grid;
            grid-template-columns: repeat(4, minmax(0, 1fr));
            gap: 18px;
            margin-bottom: 22px;
        }

        .ng-card,
        .ng-kpi-card {
            position: relative;
            overflow: hidden;
            border: 1px solid rgba(255, 255, 255, .62);
            background:
                linear-gradient(145deg, rgba(255, 255, 255, .58), rgba(255, 246, 231, .30)),
                radial-gradient(circle at 100% 0%, rgba(255, 153, 30, .13), transparent 40%) !important;
            box-shadow:
                0 22px 54px rgba(101, 58, 21, .11),
                inset 0 1px 0 rgba(255, 255, 255, .72);
            backdrop-filter: blur(15px);
            -webkit-backdrop-filter: blur(15px);
        }

        .ng-card::before,
        .ng-kpi-card::before {
            content: "";
            position: absolute;
            inset: 0;
            pointer-events: none;
            background: linear-gradient(120deg, rgba(255,255,255,.38), transparent 28%, transparent 72%, rgba(255,255,255,.15));
            opacity: .4;
        }

        .ng-kpi-card {
            min-height: 132px;
            display: flex;
            align-items: center;
            gap: 18px;
            padding: 22px;
            border-radius: 22px;
        }

        .ng-kpi-icon {
            position: relative;
            z-index: 2;
            width: 58px;
            height: 58px;
            display: grid;
            place-items: center;
            flex: 0 0 auto;
            border-radius: 50%;
            color: #fff;
            background: linear-gradient(135deg, var(--accent), #ee6500);
            box-shadow: 0 16px 30px rgba(249, 115, 22, .22);
            font-size: 25px;
            font-weight: 950;
        }

        .ng-kpi-content {
            position: relative;
            z-index: 2;
            min-width: 0;
            flex: 1;
        }

        .ng-kpi-content > span {
            color: #2c2119;
            font-size: 14px;
            line-height: 1.2;
            font-weight: 900;
        }

        .ng-kpi-content strong {
            display: block;
            margin-top: 7px;
            color: #1f150d;
            font-size: 26px;
            line-height: 1.05;
            font-weight: 950;
            letter-spacing: -.04em;
            white-space: nowrap;
            overflow: hidden;
            text-overflow: ellipsis;
        }

        .ng-kpi-content p {
            margin: 13px 0 0;
            font-size: 13px;
            line-height: 1.2;
            font-weight: 950;
        }

        .ng-kpi-content p em {
            margin-left: 8px;
            color: #6f5946;
            font-style: normal;
            font-weight: 700;
        }

        .ng-kpi-content .positive {
            color: #16a34a;
        }

        .ng-kpi-content .negative {
            color: #ef4444;
        }

        .ng-visual-grid {
            display: grid;
            grid-template-columns: minmax(0, 1fr) minmax(420px, .96fr);
            gap: 22px;
            margin-bottom: 22px;
        }

        .ng-card {
            border-radius: 24px;
            padding: 22px;
            min-width: 0;
        }

        .ng-card-head {
            position: relative;
            z-index: 2;
            margin-bottom: 16px;
        }

        .ng-card-head h2 {
            margin: 0;
            color: #21160d;
            font-size: 21px;
            line-height: 1.2;
            font-weight: 950;
            letter-spacing: -.035em;
        }

        .ng-card-head p {
            margin: 9px 0 0;
            color: #765d45;
            font-size: 13px;
            font-weight: 800;
        }

        .ng-chart-responsive {
            position: relative;
            z-index: 2;
            display: grid;
            grid-template-columns: 54px minmax(0, 1fr);
            min-height: 288px;
        }

        .ng-y-axis {
            display: grid;
            grid-template-rows: repeat(5, 1fr);
            padding: 4px 10px 32px 0;
            color: #6f5946;
            font-size: 12px;
            font-weight: 850;
            text-align: right;
        }

        .ng-y-axis span {
            transform: translateY(-6px);
        }

        .ng-chart-area {
            position: relative;
            min-width: 0;
            overflow-x: auto;
            overflow-y: hidden;
            padding-bottom: 30px;
            scrollbar-width: thin;
        }

        .ng-chart-area::-webkit-scrollbar {
            height: 6px;
        }

        .ng-chart-area::-webkit-scrollbar-thumb {
            border-radius: 999px;
            background: rgba(249, 115, 22, .5);
        }

        .ng-grid-lines {
            position: absolute;
            inset: 0 0 30px 0;
            display: grid;
            grid-template-rows: repeat(4, 1fr);
            pointer-events: none;
        }

        .ng-grid-lines i {
            border-top: 1px solid rgba(100, 65, 36, .12);
        }

        .ng-grid-lines i:last-child {
            border-bottom: 1px solid rgba(100, 65, 36, .12);
        }

        .ng-bars {
            position: relative;
            z-index: 2;
            min-width: max(100%, calc(var(--bar-count) * 34px));
            height: 250px;
            display: grid;
            grid-template-columns: repeat(var(--bar-count), minmax(24px, 1fr));
            align-items: end;
            gap: 9px;
            padding: 0 4px;
        }

        .ng-bar-item {
            height: 100%;
            min-width: 0;
            display: grid;
            grid-template-rows: 1fr 26px;
            align-items: end;
            gap: 7px;
        }

        .ng-bar-wrap {
            width: 100%;
            height: 100%;
            display: flex;
            align-items: end;
            justify-content: center;
        }

        .ng-bar-wrap span {
            width: min(100%, 20px);
            min-height: 3px;
            border-radius: 8px 8px 2px 2px;
            background: linear-gradient(180deg, #ffa12b, #ff6a00);
            box-shadow: 0 10px 20px rgba(249, 115, 22, .20);
            transition: .2s ease;
        }

        .ng-bar-item:hover .ng-bar-wrap span {
            filter: brightness(1.05);
            transform: translateY(-2px);
        }

        .ng-bar-item small {
            display: block;
            color: #6f5946;
            font-size: 10px;
            line-height: 1.1;
            font-weight: 800;
            text-align: center;
            white-space: nowrap;
        }

        .ng-chart-caption {
            position: relative;
            z-index: 2;
            margin-top: 4px;
            color: #8b7057;
            font-size: 12px;
            font-weight: 850;
            text-align: center;
        }

        .ng-target-list {
            position: relative;
            z-index: 2;
            display: grid;
            gap: 25px;
            padding-top: 8px;
        }

        .ng-target-row {
            display: grid;
            grid-template-columns: 58px minmax(0, 1fr);
            gap: 16px;
            align-items: center;
        }

        .ng-target-icon {
            width: 58px;
            height: 58px;
            display: grid;
            place-items: center;
            border-radius: 50%;
            color: #fff;
            background: linear-gradient(135deg, var(--target-color), #ee6500);
            box-shadow: 0 16px 30px rgba(249, 115, 22, .20);
            font-size: 24px;
            font-weight: 950;
        }

        .ng-target-main {
            min-width: 0;
        }

        .ng-target-top {
            display: grid;
            grid-template-columns: minmax(0, 1.2fr) minmax(130px, .7fr) 82px;
            gap: 14px;
            align-items: start;
            margin-bottom: 8px;
        }

        .ng-target-top strong,
        .ng-target-top span {
            display: block;
        }

        .ng-target-top strong {
            color: #21160d;
            font-size: 13px;
            font-weight: 950;
            white-space: nowrap;
            overflow: hidden;
            text-overflow: ellipsis;
        }

        .ng-target-top span {
            margin-top: 4px;
            color: #6f5946;
            font-size: 12px;
            font-weight: 800;
        }

        .ng-target-top b {
            color: var(--target-color);
            font-size: 25px;
            line-height: 1;
            font-weight: 950;
            text-align: right;
            letter-spacing: -.04em;
        }

        .ng-target-top b.negative {
            color: #ef4444;
        }

        .ng-target-track {
            height: 13px;
            overflow: hidden;
            border-radius: 999px;
            background: rgba(249, 115, 22, .14);
        }

        .ng-target-track i {
            display: block;
            height: 100%;
            border-radius: inherit;
            background: linear-gradient(90deg, var(--target-color), #ff8a00);
        }

        .ng-target-track.danger i {
            background: linear-gradient(90deg, #ef4444, #fb7185);
        }

        .ng-target-bottom {
            display: flex;
            justify-content: space-between;
            margin-top: 6px;
        }

        .ng-target-bottom small {
            color: #7b624c;
            font-size: 12px;
            font-weight: 750;
        }

        .ng-table-head {
            position: relative;
            z-index: 2;
            display: flex;
            align-items: flex-start;
            justify-content: space-between;
            gap: 14px;
            margin-bottom: 14px;
        }

        .ng-table-head h2 {
            margin: 0;
            color: #21160d;
            font-size: 21px;
            font-weight: 950;
            letter-spacing: -.035em;
        }

        .ng-table-head p {
            margin: 7px 0 0;
            color: #765d45;
            font-size: 13px;
            font-weight: 750;
        }

        .ng-table-actions {
            display: flex;
            gap: 10px;
            flex-wrap: wrap;
        }

        .ng-table-actions a {
            min-height: 38px;
            display: inline-flex;
            align-items: center;
            justify-content: center;
            padding: 0 15px;
            border-radius: 12px;
            color: #f97316;
            background: rgba(255, 255, 255, .38);
            border: 1px solid rgba(255, 255, 255, .58);
            font-size: 12px;
            font-weight: 950;
            text-decoration: none;
        }

        .ng-cost-table-wrap {
            position: relative;
            z-index: 2;
            width: 100%;
            overflow-x: auto;
        }

        .ng-cost-table {
            width: 100%;
            min-width: 880px;
            border-collapse: collapse;
        }

        .ng-cost-table th,
        .ng-cost-table td {
            padding: 13px 14px;
            border-top: 1px solid rgba(113, 74, 44, .10);
            color: #4b3525;
            font-size: 13px;
            text-align: left;
            white-space: nowrap;
        }

        .ng-cost-table th {
            color: #3f3024;
            font-size: 12px;
            font-weight: 950;
        }

        .ng-cost-table td {
            font-weight: 760;
        }

        .ng-cost-category {
            display: flex;
            align-items: center;
            gap: 12px;
        }

        .ng-cost-category span {
            width: 34px;
            height: 34px;
            display: grid;
            place-items: center;
            border-radius: 50%;
            color: #f97316;
            background: rgba(249, 115, 22, .12);
            font-weight: 950;
        }

        .ng-cost-category strong {
            color: #2d1f16;
            font-weight: 950;
        }

        .ng-money {
            color: #ef4444 !important;
            font-weight: 950 !important;
        }


        .ng-cost-type-badge {
            display: inline-flex;
            align-items: center;
            min-height: 26px;
            padding: 0 10px;
            border-radius: 8px;
            color: #0f766e;
            background: rgba(20, 184, 166, .13);
            font-size: 12px;
            font-weight: 950;
            white-space: nowrap;
        }

        .ng-cost-type-badge.annual {
            color: #d95d00;
            background: rgba(249, 115, 22, .13);
        }

        .ng-money small {
            display: block;
            max-width: 260px;
            margin-top: 4px;
            color: #8b7057;
            font-size: 11px;
            line-height: 1.25;
            font-weight: 750;
            white-space: normal;
        }


        .ng-status-paid {
            display: inline-flex;
            align-items: center;
            min-height: 26px;
            padding: 0 10px;
            border-radius: 8px;
            color: #16a34a;
            background: rgba(22, 163, 74, .12);
            font-size: 12px;
            font-weight: 900;
        }

        .ng-action-dots {
            color: #21160d;
            font-size: 20px;
            font-weight: 950;
        }


        /*
        |--------------------------------------------------------------------------
        | COST TABLE SLIDE PAGINATION - 5 DATA PER HALAMAN
        |--------------------------------------------------------------------------
        */

        .ng-cost-page-row {
            display: none;
        }

        .ng-cost-page-row.is-active {
            display: table-row;
            animation: ngCostFadeIn .18s ease both;
        }

        @keyframes ngCostFadeIn {
            from {
                opacity: 0;
                transform: translateY(4px);
            }

            to {
                opacity: 1;
                transform: translateY(0);
            }
        }

        .ng-cost-pagination {
            display: flex;
            align-items: center;
            gap: 10px;
            flex-wrap: wrap;
        }

        .ng-cost-page-btn,
        .ng-cost-page-number {
            width: 34px;
            height: 34px;
            display: grid;
            place-items: center;
            border: 0;
            border-radius: 50%;
            background: rgba(255, 255, 255, .38);
            color: #7b624c;
            font-size: 13px;
            font-weight: 950;
            cursor: pointer;
            transition: .18s ease;
        }

        .ng-cost-page-btn:hover,
        .ng-cost-page-number:hover,
        .ng-cost-page-number.is-active {
            color: #fff;
            background: linear-gradient(135deg, #ff9d18, #ee6500);
            box-shadow: 0 10px 20px rgba(238, 101, 0, .22);
        }

        .ng-cost-page-btn.is-disabled {
            opacity: .45;
            cursor: not-allowed;
            pointer-events: none;
            box-shadow: none;
        }


        .ng-table-footer {
            position: relative;
            z-index: 2;
            display: flex;
            align-items: center;
            justify-content: center;
            gap: 18px;
            padding-top: 15px;
            color: #6f5946;
            font-size: 12px;
            font-weight: 800;
        }

        .ng-table-footer div {
            display: flex;
            align-items: center;
            gap: 10px;
        }

        .ng-table-footer button,
        .ng-table-footer strong {
            width: 34px;
            height: 34px;
            display: grid;
            place-items: center;
            border: 0;
            border-radius: 50%;
            background: rgba(255, 255, 255, .38);
            color: #7b624c;
            font-weight: 950;
        }

        .ng-table-footer strong {
            color: #fff;
            background: linear-gradient(135deg, #ff9d18, #ee6500);
        }

        .ng-empty-state {
            position: relative;
            z-index: 2;
            padding: 18px;
            border-radius: 16px;
            color: #7b624c;
            background: rgba(255, 255, 255, .30);
            font-size: 13px;
            font-weight: 850;
            text-align: center;
        }

        /*
        |--------------------------------------------------------------------------
        | SIDEBAR EFFECT SYNC
        |--------------------------------------------------------------------------
        */

        body:has(.ng-finance-dashboard-new) .fi-sidebar {
            background: rgba(255, 250, 242, .50) !important;
            border-right: 1px solid rgba(255, 255, 255, .48) !important;
            box-shadow: 18px 0 55px rgba(137, 78, 26, .10) !important;
            backdrop-filter: blur(16px) !important;
            -webkit-backdrop-filter: blur(16px) !important;
        }

        body:has(.ng-finance-dashboard-new) .fi-sidebar-nav {
            padding: 18px 14px !important;
        }

        body:has(.ng-finance-dashboard-new) .fi-sidebar-item a {
            border-radius: 14px !important;
            color: #6f5844 !important;
            transition: .2s ease !important;
        }

        body:has(.ng-finance-dashboard-new) .fi-sidebar-item-active a,
        body:has(.ng-finance-dashboard-new) .fi-sidebar-item a:hover {
            background: linear-gradient(135deg, #ff9500, #f26a00) !important;
            color: #fff !important;
            box-shadow: 0 14px 24px rgba(242, 106, 0, .24) !important;
        }

        body:has(.ng-finance-dashboard-new) .fi-sidebar-item-active svg,
        body:has(.ng-finance-dashboard-new) .fi-sidebar-item a:hover svg,
        body:has(.ng-finance-dashboard-new) .fi-sidebar-item-active span,
        body:has(.ng-finance-dashboard-new) .fi-sidebar-item a:hover span {
            color: #fff !important;
        }


        /*
        |--------------------------------------------------------------------------
        | WEEKLY REVENUE CHART IMPROVEMENTS
        |--------------------------------------------------------------------------
        */

        @keyframes ngFadeUp {
            from {
                opacity: 0;
                transform: translateY(14px);
            }

            to {
                opacity: 1;
                transform: translateY(0);
            }
        }

        @keyframes ngBarRise {
            from {
                opacity: .28;
                transform: scaleY(.15);
            }

            to {
                opacity: 1;
                transform: scaleY(1);
            }
        }

        .ng-kpi-card,
        .ng-card {
            animation: ngFadeUp .5s ease both;
        }

        .ng-chart-area-static {
            overflow: visible;
            padding-bottom: 0;
        }

        .ng-bars-weekly {
            min-width: 100%;
            height: 280px;
            grid-template-columns: repeat(var(--bar-count), minmax(58px, 1fr));
            gap: 16px;
            padding: 0 8px;
        }

        .ng-bars-weekly .ng-bar-item {
            position: relative;
            padding-top: 76px;
        }

        .ng-bars-weekly .ng-bar-wrap span {
            width: min(100%, 28px);
            border-radius: 12px 12px 4px 4px;
            animation: ngBarRise .75s cubic-bezier(.22, 1, .36, 1) both;
            animation-delay: calc((var(--item-index, 0) * 1) * 90ms + 120ms);
            transform-origin: bottom center;
        }

        .ng-chart-tooltip {
            position: absolute;
            left: 50%;
            top: 0;
            z-index: 4;
            min-width: 210px;
            max-width: min(240px, calc(100vw - 40px));
            padding: 16px 18px;
            border-radius: 18px;
            border: 1px solid rgba(255, 255, 255, .78);
            background: rgba(245, 245, 245, .96);
            box-shadow: 0 18px 46px rgba(77, 51, 22, .18);
            backdrop-filter: blur(10px);
            -webkit-backdrop-filter: blur(10px);
            opacity: 0;
            visibility: hidden;
            pointer-events: none;
            transform: translate(-50%, 12px);
            transition: opacity .22s ease, transform .22s ease, visibility .22s ease;
        }

        .ng-chart-tooltip::after {
            content: '';
            position: absolute;
            left: 50%;
            bottom: -8px;
            width: 16px;
            height: 16px;
            background: rgba(245, 245, 245, .96);
            transform: translateX(-50%) rotate(45deg);
            border-right: 1px solid rgba(255, 255, 255, .78);
            border-bottom: 1px solid rgba(255, 255, 255, .78);
        }

        .ng-chart-tooltip strong {
            display: block;
            margin-bottom: 12px;
            color: #7b7f86;
            font-size: 17px;
            line-height: 1.1;
            font-weight: 950;
        }

        .ng-chart-tooltip-row {
            display: flex;
            align-items: center;
            flex-wrap: wrap;
            gap: 8px;
            color: #2e2620;
            font-size: 15px;
            font-weight: 700;
        }

        .ng-chart-tooltip-dot {
            width: 16px;
            height: 16px;
            border-radius: 50%;
            background: #f97316;
            box-shadow: 0 6px 12px rgba(249, 115, 22, .24);
            flex: 0 0 16px;
        }

        .ng-chart-tooltip-row b {
            color: #2a1d13;
            font-size: 16px;
            font-weight: 950;
        }

        .ng-bar-item:hover .ng-chart-tooltip,
        .ng-bar-item:focus-visible .ng-chart-tooltip,
        .ng-bar-item:focus-within .ng-chart-tooltip {
            opacity: 1;
            visibility: visible;
            transform: translate(-50%, -8px);
        }

        .ng-bar-item:focus-visible {
            outline: none;
        }

        .ng-bar-item:focus-visible .ng-bar-wrap span {
            filter: brightness(1.04);
            transform: translateY(-2px);
        }


        @media (max-width: 1500px) {
            .ng-kpi-grid {
                grid-template-columns: repeat(2, minmax(0, 1fr));
            }

            .ng-visual-grid {
                grid-template-columns: 1fr;
            }
        }

        @media (max-width: 1100px) {
            .ng-finance-dashboard-new {
                padding: 18px 18px 28px;
            }

            .ng-topbar {
                flex-direction: column;
            }

            .ng-filter-area {
                width: 100%;
                justify-content: flex-start;
            }


            .ng-period-filter-block {
                width: 100%;
            }

            .ng-custom-filter-popover {
                left: 0;
                right: auto;
            }

            .ng-target-card-head {
                align-items: stretch;
                flex-direction: column;
            }

            .ng-target-filter-inside {
                width: 100%;
                justify-content: space-between;
            }


            .ng-period-tabs {
                width: 100%;
                overflow-x: auto;
                justify-content: flex-start;
            }

            .ng-tab {
                flex: 1 0 auto;
            }

            .ng-date-chip {
                width: 100%;
                justify-content: space-between;
            }


            .ng-target-filter {
                width: 100%;
                justify-content: space-between;
            }

            .ng-target-month-select {
                flex: 1;
            }

            .ng-target-top {
                grid-template-columns: 1fr 1fr;
            }

            .ng-target-top b {
                grid-column: 1 / -1;
                text-align: left;
            }
        }

        @media (max-width: 700px) {
            .ng-finance-dashboard-new {
                padding: 14px 14px 24px;
            }

            .ng-title-area h1 {
                font-size: 28px;
            }

            .ng-kpi-grid {
                grid-template-columns: 1fr;
                gap: 12px;
            }

            .ng-kpi-card {
                min-height: 118px;
                padding: 18px;
            }

            .ng-visual-grid {
                gap: 14px;
                margin-bottom: 14px;
            }

            .ng-card {
                padding: 16px;
                border-radius: 22px;
            }

            .ng-chart-responsive {
                grid-template-columns: 44px minmax(0, 1fr);
                min-height: 254px;
            }

            .ng-bars {
                height: 220px;
                min-width: max(100%, calc(var(--bar-count) * 30px));
                gap: 7px;
            }

            .ng-bars-weekly {
                min-width: 100%;
                height: 230px;
                grid-template-columns: repeat(var(--bar-count), minmax(44px, 1fr));
                gap: 12px;
                padding: 0 4px;
            }

            .ng-bars-weekly .ng-bar-item {
                padding-top: 70px;
            }

            .ng-bar-wrap span {
                width: min(100%, 16px);
            }

            .ng-bars-weekly .ng-bar-wrap span {
                width: min(100%, 22px);
            }

            .ng-chart-tooltip {
                min-width: 180px;
                padding: 14px 14px;
            }

            .ng-chart-tooltip strong {
                font-size: 15px;
            }

            .ng-chart-tooltip-row,
            .ng-chart-tooltip-row b {
                font-size: 14px;
            }

            .ng-target-row {
                grid-template-columns: 48px minmax(0, 1fr);
                gap: 12px;
            }

            .ng-target-icon {
                width: 48px;
                height: 48px;
                font-size: 20px;
            }

            .ng-table-head {
                flex-direction: column;
            }

            .ng-table-actions {
                width: 100%;
            }

            .ng-table-actions a {
                flex: 1;
            }
        }

        @media (max-width: 640px) {
            .ng-chart-responsive {
                grid-template-columns: 40px minmax(0, 1fr);
                min-height: 240px;
            }

            .ng-y-axis {
                font-size: 11px;
                padding-right: 8px;
            }

            .ng-bars-weekly {
                height: 210px;
                grid-template-columns: repeat(var(--bar-count), minmax(40px, 1fr));
                gap: 10px;
            }

            .ng-bars-weekly .ng-bar-item {
                padding-top: 64px;
            }

            .ng-bars-weekly .ng-bar-wrap span {
                width: min(100%, 18px);
            }

            .ng-bar-item small {
                font-size: 9px;
            }

            .ng-chart-tooltip {
                min-width: 156px;
                max-width: 180px;
                padding: 12px 12px;
            }

            .ng-chart-tooltip strong {
                margin-bottom: 9px;
                font-size: 14px;
            }

            .ng-chart-tooltip-row,
            .ng-chart-tooltip-row b {
                font-size: 13px;
            }
        }

    </style>


    <script>
        document.addEventListener('DOMContentLoaded', function () {
            const footer = document.querySelector('.ng-finance-dashboard-new .ng-table-footer');

            if (! footer) {
                return;
            }

            const totalCosts = Number(footer.dataset.totalCosts || 0);
            const perPage = Number(footer.dataset.perPage || 5);
            const totalPages = Number(footer.dataset.totalPages || 1);
            const rows = Array.from(document.querySelectorAll('.ng-cost-page-row'));
            const info = footer.querySelector('.ng-cost-page-info');
            const prev = footer.querySelector('[data-cost-prev]');
            const next = footer.querySelector('[data-cost-next]');
            const pageButtons = Array.from(footer.querySelectorAll('[data-cost-page-button]'));

            let currentPage = 1;

            const rupiahNumber = new Intl.NumberFormat('id-ID');

            function setPage(page) {
                currentPage = Math.max(1, Math.min(totalPages, Number(page || 1)));

                rows.forEach(function (row) {
                    row.classList.toggle('is-active', Number(row.dataset.costPage) === currentPage);
                });

                pageButtons.forEach(function (button) {
                    button.classList.toggle('is-active', Number(button.dataset.costPageButton) === currentPage);
                });

                if (prev) {
                    prev.classList.toggle('is-disabled', currentPage <= 1);
                }

                if (next) {
                    next.classList.toggle('is-disabled', currentPage >= totalPages);
                }

                if (info) {
                    const start = ((currentPage - 1) * perPage) + 1;
                    const end = Math.min(currentPage * perPage, totalCosts);

                    info.textContent = rupiahNumber.format(start) + ' - ' + rupiahNumber.format(end) + ' dari ' + rupiahNumber.format(totalCosts);
                }
            }

            if (prev) {
                prev.addEventListener('click', function () {
                    setPage(currentPage - 1);
                });
            }

            if (next) {
                next.addEventListener('click', function () {
                    setPage(currentPage + 1);
                });
            }

            pageButtons.forEach(function (button) {
                button.addEventListener('click', function () {
                    setPage(button.dataset.costPageButton);
                });
            });

            setPage(1);
        });
    </script>

 <?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__attributesOriginal166a02a7c5ef5a9331faf66fa665c256)): ?>
<?php $attributes = $__attributesOriginal166a02a7c5ef5a9331faf66fa665c256; ?>
<?php unset($__attributesOriginal166a02a7c5ef5a9331faf66fa665c256); ?>
<?php endif; ?>
<?php if (isset($__componentOriginal166a02a7c5ef5a9331faf66fa665c256)): ?>
<?php $component = $__componentOriginal166a02a7c5ef5a9331faf66fa665c256; ?>
<?php unset($__componentOriginal166a02a7c5ef5a9331faf66fa665c256); ?>
<?php endif; ?>
<?php /**PATH /var/www/html/resources/views/filament/admin/pages/financial-dashboard.blade.php ENDPATH**/ ?>