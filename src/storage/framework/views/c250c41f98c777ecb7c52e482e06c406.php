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
        $metrics = $finance['metrics'] ?? [];
        $costs = $finance['costs'] ?? [];
        $productMargins = $finance['productMargins'] ?? [];
        $links = $finance['links'] ?? [];

        $filters = $finance['filters'] ?? [];
        $selectedMonth = (string) ($period['selected_month'] ?? $filters['selected_month'] ?? request()->query('month', 'all'));
        $selectedYear = (int) ($period['selected_year'] ?? $filters['selected_year'] ?? request()->query('year', now()->year));
        $yearlyDetails = $finance['yearlyDetails'] ?? $finance['yearly_details'] ?? [];

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

        $selectedMonthLabel = $months[$selectedMonth] ?? 'Semua Bulan';
        $baseDashboardUrl = $links['dashboard_keuangan'] ?? url('/admin/dashboard-keuangan');

        $makePeriodUrl = function (string $key) use ($baseDashboardUrl, $selectedYear) {
            $params = ['period' => $key];

            if ($key === 'year') {
                $params['month'] = 'all';
                $params['year'] = $selectedYear;
            }

            return $baseDashboardUrl . '?' . http_build_query($params);
        };

        $makeMonthUrl = function (string $month) use ($baseDashboardUrl, $selectedYear) {
            return $baseDashboardUrl . '?' . http_build_query([
                'period' => 'year',
                'month' => $month,
                'year' => $selectedYear,
            ]);
        };

        $yearRevenue = (int) collect($yearlyDetails)->sum('revenue');
        $yearHpp = (int) collect($yearlyDetails)->sum('total_hpp');
        $yearGross = (int) collect($yearlyDetails)->sum('gross_profit');
        $yearCost = (int) collect($yearlyDetails)->sum('operational_cost');
        $yearNet = (int) collect($yearlyDetails)->sum('net_profit');
        $yearMargin = $yearRevenue > 0 ? round(($yearGross / $yearRevenue) * 100, 1) : 0;
        $yearMaxRevenue = max(1, (int) collect($yearlyDetails)->max('revenue'));


        $user = auth()->user();

        $periods = [
            'today' => 'Hari Ini',
            'week' => 'Minggu Ini',
            'month' => 'Bulan Ini',
            'year' => 'Tahun Ini',
        ];

        $revenue = (int) ($summary['revenue'] ?? 0);
        $totalHpp = (int) ($summary['total_hpp'] ?? 0);
        $grossProfit = (int) ($summary['gross_profit'] ?? 0);
        $operationalCost = (int) ($summary['operational_cost'] ?? 0);
        $netProfit = (int) ($summary['net_profit'] ?? 0);

        $safeRevenue = max($revenue, 1);

        $hppPercent = min(100, round(($totalHpp / $safeRevenue) * 100, 1));
        $grossPercent = min(100, max(0, round(($grossProfit / $safeRevenue) * 100, 1)));
        $costPercent = min(100, round(($operationalCost / $safeRevenue) * 100, 1));
        $netPercent = min(100, max(0, round((abs($netProfit) / $safeRevenue) * 100, 1)));

        $maxCost = max(1, (int) collect($costs)->max('amount'));
        $maxProductProfit = max(1, (int) collect($productMargins)->max('gross_profit'));
    ?>

    <div class="ng-finance-dashboard">
        <section class="ng-dashboard-header">
            <div class="ng-title-area">

                <h1>Dashboard Keuangan</h1>

            </div>

            <div class="ng-filter-area">
                <div class="ng-period-tabs">
                    <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::openLoop(); ?><?php endif; ?><?php $__currentLoopData = $periods; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $key => $label): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::startLoop($loop->index); ?><?php endif; ?>
                        <a href="<?php echo e($makePeriodUrl($key)); ?>"
                           class="ng-tab <?php echo e($activePeriod === $key ? 'active' : ''); ?>">
                            <?php echo e($label); ?>

                        </a>
                    <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::endLoop(); ?><?php endif; ?><?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::closeLoop(); ?><?php endif; ?>
                </div>

                <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if($activePeriod === 'year'): ?>
                    <div class="ng-month-select-wrap">
                        <select class="ng-month-select" onchange="window.location.href = this.value">
                            <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::openLoop(); ?><?php endif; ?><?php $__currentLoopData = $months; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $monthKey => $monthLabel): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::startLoop($loop->index); ?><?php endif; ?>
                                <option value="<?php echo e($makeMonthUrl((string) $monthKey)); ?>" <?php if($selectedMonth === (string) $monthKey): echo 'selected'; endif; ?>>
                                    <?php echo e($monthLabel); ?>

                                </option>
                            <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::endLoop(); ?><?php endif; ?><?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::closeLoop(); ?><?php endif; ?>
                        </select>
                    </div>
                <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>

                <div class="ng-admin-profile">
                    <div class="ng-avatar">
                        <?php echo e(strtoupper(substr($user?->name ?? 'A', 0, 1))); ?>

                    </div>

                    <div>
                        <strong><?php echo e($user?->name ?? 'Administrator'); ?></strong>
                        <span>Super Admin</span>
                    </div>
                </div>
            </div>
        </section>

        <section class="ng-finance-period-row">
            <span><?php echo e($period['label'] ?? 'Bulan Ini'); ?></span>
            <strong><?php echo e($period['start'] ?? '-'); ?> - <?php echo e($period['end'] ?? '-'); ?></strong>

            <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if($activePeriod === 'year'): ?>
                <span class="ng-period-extra"><?php echo e($selectedMonthLabel); ?> • <?php echo e($selectedYear); ?></span>
            <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
        </section>

        <section class="ng-kpi-grid">
            <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::openLoop(); ?><?php endif; ?><?php $__currentLoopData = $metrics; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $metric): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::startLoop($loop->index); ?><?php endif; ?>
                <article class="ng-kpi-card" style="--accent: <?php echo e($metric['color'] ?? '#f97316'); ?>;">
                    <div class="ng-kpi-icon">
                        <?php echo e($metric['icon'] ?? '▣'); ?>

                    </div>

                    <div class="ng-kpi-content">
                        <div class="ng-kpi-label">
                            <?php echo e($metric['label'] ?? '-'); ?>

                            <span>⋮</span>
                        </div>

                        <strong><?php echo e($metric['value'] ?? '-'); ?></strong>

                        <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if(! is_null($metric['trend'] ?? null)): ?>
                            <p class="<?php echo e(($metric['trend'] ?? 0) >= 0 ? 'positive' : 'negative'); ?>">
                                <?php echo e(($metric['trend'] ?? 0) >= 0 ? '↑' : '↓'); ?>

                                <?php echo e(abs($metric['trend'])); ?>%
                                <span>dari periode sebelumnya</span>
                            </p>
                        <?php else: ?>
                            <p class="neutral"><?php echo e($metric['caption'] ?? '-'); ?></p>
                        <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
                    </div>
                </article>
            <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::endLoop(); ?><?php endif; ?><?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::closeLoop(); ?><?php endif; ?>
        </section>


        <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if($activePeriod === 'year'): ?>
            <section class="ng-year-detail-section">
                <article class="ng-widget-card ng-year-card">
                    <div class="ng-widget-head">
                        <div>
                            <h2>Detail Tahunan <?php echo e($selectedYear); ?></h2>
                            <p>Rincian revenue, HPP, gross profit, biaya operasional, net profit, margin, dan target per bulan.</p>
                        </div>

                        <a href="<?php echo e($makeMonthUrl('all')); ?>">
                            <?php echo e($selectedMonth === 'all' ? 'Semua Bulan' : 'Lihat Semua Bulan'); ?>

                        </a>
                    </div>

                    <div class="ng-year-summary-strip">
                        <div>
                            <span>Revenue Tahun</span>
                            <strong><?php echo e($this->rupiah($yearRevenue)); ?></strong>
                        </div>
                        <div>
                            <span>Total HPP Tahun</span>
                            <strong><?php echo e($this->rupiah($yearHpp)); ?></strong>
                        </div>
                        <div>
                            <span>Gross Profit Tahun</span>
                            <strong><?php echo e($this->rupiah($yearGross)); ?></strong>
                        </div>
                        <div>
                            <span>Biaya Operasional</span>
                            <strong><?php echo e($this->rupiah($yearCost)); ?></strong>
                        </div>
                        <div class="<?php echo e($yearNet >= 0 ? 'positive' : 'negative'); ?>">
                            <span>Net Profit Tahun</span>
                            <strong><?php echo e($this->rupiah($yearNet)); ?> • <?php echo e($yearMargin); ?>%</strong>
                        </div>
                    </div>

                    <div class="ng-year-table-scroll">
                        <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::openLoop(); ?><?php endif; ?><?php $__empty_1 = true; $__currentLoopData = $yearlyDetails; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $monthRow): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::startLoop($loop->index); ?><?php endif; ?>
                            <?php
                                $monthKey = (string) ($monthRow['month_key'] ?? $monthRow['month'] ?? 'all');
                                $rowRevenue = (int) ($monthRow['revenue'] ?? 0);
                                $rowHpp = (int) ($monthRow['total_hpp'] ?? 0);
                                $rowGross = (int) ($monthRow['gross_profit'] ?? 0);
                                $rowCost = (int) ($monthRow['operational_cost'] ?? 0);
                                $rowNet = (int) ($monthRow['net_profit'] ?? 0);
                                $rowTarget = (int) ($monthRow['target_revenue'] ?? 0);
                                $rowMargin = $monthRow['profit_margin'] ?? 0;
                                $revenueWidth = min(100, round(($rowRevenue / $yearMaxRevenue) * 100));
                                $isSelectedMonth = $selectedMonth === $monthKey;
                            ?>

                            <a href="<?php echo e($makeMonthUrl($monthKey)); ?>" class="ng-year-row <?php echo e($isSelectedMonth ? 'active' : ''); ?>">
                                <div class="ng-year-month">
                                    <strong><?php echo e($monthRow['month_name'] ?? '-'); ?></strong>
                                    <span><?php echo e($monthRow['period'] ?? '-'); ?></span>
                                </div>

                                <div class="ng-year-values">
                                    <div>
                                        <span>Revenue</span>
                                        <strong><?php echo e($this->rupiah($rowRevenue)); ?></strong>
                                    </div>
                                    <div>
                                        <span>HPP</span>
                                        <strong><?php echo e($this->rupiah($rowHpp)); ?></strong>
                                    </div>
                                    <div>
                                        <span>Gross</span>
                                        <strong><?php echo e($this->rupiah($rowGross)); ?></strong>
                                    </div>
                                    <div>
                                        <span>Biaya</span>
                                        <strong><?php echo e($this->rupiah($rowCost)); ?></strong>
                                    </div>
                                    <div class="<?php echo e($rowNet >= 0 ? 'positive' : 'negative'); ?>">
                                        <span>Net</span>
                                        <strong><?php echo e($this->rupiah($rowNet)); ?></strong>
                                    </div>
                                    <div>
                                        <span>Margin</span>
                                        <strong><?php echo e($rowMargin); ?>%</strong>
                                    </div>
                                    <div>
                                        <span>Target</span>
                                        <strong><?php echo e($this->rupiah($rowTarget)); ?></strong>
                                    </div>
                                </div>

                                <div class="ng-year-progress">
                                    <i style="width: <?php echo e($revenueWidth); ?>%;"></i>
                                </div>
                            </a>
                        <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::endLoop(); ?><?php endif; ?><?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::closeLoop(); ?><?php endif; ?>
                            <div class="ng-empty-state">
                                Belum ada detail tahunan untuk ditampilkan.
                            </div>
                        <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
                    </div>
                </article>
            </section>
        <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>

        <section class="ng-finance-main-grid">
            <article class="ng-widget-card ng-profit-engine-card">
                <div class="ng-widget-head">
                    <div>
                        <h2>Profit Engine</h2>
                        <p>Komposisi revenue, HPP, gross profit, biaya operasional, dan net profit periode aktif</p>
                    </div>

                    <span class="ng-widget-badge <?php echo e($netProfit >= 0 ? 'ng-badge-green' : 'ng-badge-red'); ?>">
                        Net Profit <?php echo e($this->rupiah($netProfit)); ?>

                    </span>
                </div>

                <div class="ng-profit-bars">
                    <div class="ng-profit-row">
                        <div class="ng-profit-info">
                            <strong>Revenue</strong>
                            <span><?php echo e($this->rupiah($revenue)); ?></span>
                        </div>
                        <div class="ng-profit-track">
                            <i style="width: <?php echo e($revenue > 0 ? 100 : 0); ?>%; background: linear-gradient(90deg, #ff9d18, #f97316);"></i>
                        </div>
                    </div>

                    <div class="ng-profit-row">
                        <div class="ng-profit-info">
                            <strong>Total HPP</strong>
                            <span><?php echo e($this->rupiah($totalHpp)); ?> • <?php echo e($hppPercent); ?>%</span>
                        </div>
                        <div class="ng-profit-track">
                            <i style="width: <?php echo e($hppPercent); ?>%; background: linear-gradient(90deg, #2dd4bf, #14b8a6);"></i>
                        </div>
                    </div>

                    <div class="ng-profit-row">
                        <div class="ng-profit-info">
                            <strong>Gross Profit</strong>
                            <span><?php echo e($this->rupiah($grossProfit)); ?> • <?php echo e($grossPercent); ?>%</span>
                        </div>
                        <div class="ng-profit-track">
                            <i style="width: <?php echo e($grossPercent); ?>%; background: linear-gradient(90deg, #34d399, #10b981);"></i>
                        </div>
                    </div>

                    <div class="ng-profit-row">
                        <div class="ng-profit-info">
                            <strong>Biaya Operasional</strong>
                            <span><?php echo e($this->rupiah($operationalCost)); ?> • <?php echo e($costPercent); ?>%</span>
                        </div>
                        <div class="ng-profit-track">
                            <i style="width: <?php echo e($costPercent); ?>%; background: linear-gradient(90deg, #fb7185, #ef4444);"></i>
                        </div>
                    </div>

                    <div class="ng-profit-row">
                        <div class="ng-profit-info">
                            <strong>Net Profit</strong>
                            <span><?php echo e($this->rupiah($netProfit)); ?> • <?php echo e($netPercent); ?>%</span>
                        </div>
                        <div class="ng-profit-track">
                            <i style="width: <?php echo e($netProfit >= 0 ? $netPercent : 100); ?>%; background: <?php echo e($netProfit >= 0 ? 'linear-gradient(90deg, #818cf8, #6366f1)' : 'linear-gradient(90deg, #fb7185, #ef4444)'); ?>;"></i>
                        </div>
                    </div>
                </div>

                <div class="ng-finance-shortcuts">
                    <a href="<?php echo e($links['operational_costs'] ?? '#'); ?>">
                        <span>Kelola Biaya</span>
                        <strong>→</strong>
                    </a>

                    <a href="<?php echo e($links['sales_targets'] ?? '#'); ?>">
                        <span>Atur Target</span>
                        <strong>→</strong>
                    </a>

                    <a href="<?php echo e($links['products'] ?? '#'); ?>">
                        <span>Cek HPP Produk</span>
                        <strong>→</strong>
                    </a>
                </div>
            </article>

            <article class="ng-widget-card ng-cost-card">
                <div class="ng-widget-head">
                    <div>
                        <h2>Rincian Biaya Operasional</h2>
                        <p>Biaya aktif yang dihitung pada periode dashboard</p>
                    </div>

                    <a href="<?php echo e($links['operational_costs'] ?? '#'); ?>">Kelola</a>
                </div>

                <div class="ng-cost-scroll">
                    <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::openLoop(); ?><?php endif; ?><?php $__empty_1 = true; $__currentLoopData = $costs; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $cost): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::startLoop($loop->index); ?><?php endif; ?>
                        <?php
                            $costWidth = min(100, round(((int) ($cost['amount'] ?? 0) / $maxCost) * 100));
                        ?>

                        <div class="ng-cost-row">
                            <div class="ng-cost-main">
                                <div class="ng-cost-top">
                                    <strong><?php echo e($cost['name'] ?? '-'); ?></strong>
                                    <span><?php echo e($this->rupiah($cost['amount'] ?? 0)); ?></span>
                                </div>

                                <div class="ng-cost-meta">
                                    <span><?php echo e($cost['category'] ?? '-'); ?></span>
                                    <span><?php echo e($cost['date'] ?? '-'); ?></span>

                                    <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if(! empty($cost['is_annual'])): ?>
                                        <span>Tahunan</span>
                                    <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
                                </div>

                                <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if(! empty($cost['description'])): ?>
                                    <p><?php echo e($cost['description']); ?></p>
                                <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>

                                <div class="ng-cost-bar">
                                    <i style="width: <?php echo e($costWidth); ?>%;"></i>
                                </div>
                            </div>
                        </div>
                    <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::endLoop(); ?><?php endif; ?><?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::closeLoop(); ?><?php endif; ?>
                        <div class="ng-empty-state">
                            Belum ada biaya operasional.
                        </div>
                    <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
                </div>
            </article>
        </section>

        <section class="ng-finance-bottom-grid">
            <article class="ng-widget-card ng-margin-card">
                <div class="ng-widget-head">
                    <div>
                        <h2>Margin Produk</h2>
                        <p>Produk dengan kontribusi gross profit terbesar pada periode aktif</p>
                    </div>

                    <a href="<?php echo e($links['products'] ?? '#'); ?>">Produk →</a>
                </div>

                <div class="ng-margin-grid">
                    <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::openLoop(); ?><?php endif; ?><?php $__empty_1 = true; $__currentLoopData = $productMargins; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $product): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::startLoop($loop->index); ?><?php endif; ?>
                        <?php
                            $profitWidth = min(100, round(((int) ($product['gross_profit'] ?? 0) / $maxProductProfit) * 100));
                        ?>

                        <div class="ng-margin-row">
                            <div class="ng-margin-top">
                                <div>
                                    <strong><?php echo e($product['name'] ?? '-'); ?></strong>
                                    <span><?php echo e(number_format((int) ($product['units'] ?? 0), 0, ',', '.')); ?> unit • Margin <?php echo e($product['margin'] ?? 0); ?>%</span>
                                </div>

                                <div>
                                    <b><?php echo e($this->rupiah($product['gross_profit'] ?? 0)); ?></b>
                                    <small>HPP <?php echo e($this->rupiah($product['total_hpp'] ?? 0)); ?></small>
                                </div>
                            </div>

                            <div class="ng-margin-bar">
                                <i style="width: <?php echo e($profitWidth); ?>%;"></i>
                            </div>
                        </div>
                    <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::endLoop(); ?><?php endif; ?><?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::closeLoop(); ?><?php endif; ?>
                        <div class="ng-empty-state">
                            Belum ada data margin produk.
                        </div>
                    <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
                </div>
            </article>

            <article class="ng-widget-card ng-finance-summary-card">
                <div class="ng-widget-head">
                    <div>
                        <h2>Finance Summary</h2>
                        <p>Ringkasan cepat kondisi keuangan periode ini</p>
                    </div>

                    <span class="ng-widget-badge">Insight</span>
                </div>

                <div class="ng-summary-list">
                    <div>
                        <span>Revenue</span>
                        <strong><?php echo e($this->rupiah($revenue)); ?></strong>
                    </div>

                    <div>
                        <span>Total HPP</span>
                        <strong><?php echo e($this->rupiah($totalHpp)); ?></strong>
                    </div>

                    <div>
                        <span>Gross Profit</span>
                        <strong><?php echo e($this->rupiah($grossProfit)); ?></strong>
                    </div>

                    <div>
                        <span>Biaya Operasional</span>
                        <strong><?php echo e($this->rupiah($operationalCost)); ?></strong>
                    </div>

                    <div class="<?php echo e($netProfit >= 0 ? 'positive' : 'negative'); ?>">
                        <span>Net Profit</span>
                        <strong><?php echo e($this->rupiah($netProfit)); ?></strong>
                    </div>
                </div>
            </article>
        </section>
    </div>

    <style>
        html,
        body {
            overflow-x: hidden !important;
        }

        body:has(.ng-finance-dashboard) {
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

        body:has(.ng-finance-dashboard) .fi-main,
        body:has(.ng-finance-dashboard) .fi-main-ctn,
        body:has(.ng-finance-dashboard) .fi-page,
        body:has(.ng-finance-dashboard) .fi-page-content {
            width: 100% !important;
            max-width: 100% !important;
            background: transparent !important;
            overflow-x: hidden !important;
        }

        body:has(.ng-finance-dashboard) .fi-page {
            padding: 0 !important;
        }

        body:has(.ng-finance-dashboard) .fi-page-header {
            display: none !important;
        }

        body:has(.ng-finance-dashboard) .fi-main {
            padding: 0 !important;
        }

        .ng-finance-dashboard {
            width: 100% !important;
            max-width: 100% !important;
            min-height: 100vh;
            padding: 24px 24px 32px !important;
            overflow: hidden !important;
            font-family: Inter, Poppins, ui-sans-serif, system-ui, -apple-system, BlinkMacSystemFont, "Segoe UI", sans-serif;
            color: #24180f;
        }

        .ng-finance-dashboard * {
            box-sizing: border-box;
        }

        .ng-dashboard-header {
            display: flex;
            align-items: flex-start;
            justify-content: space-between;
            gap: 18px;
            margin-bottom: 12px;
        }

        .ng-title-area {
            min-width: 250px;
        }

        .ng-kicker {
            display: inline-flex;
            align-items: center;
            width: fit-content;
            padding: 6px 12px;
            margin-bottom: 10px;
            border-radius: 999px;
            background: rgba(255, 255, 255, .50);
            border: 1px solid rgba(255, 255, 255, .58);
            color: #d95d00;
            font-size: 12px;
            font-weight: 900;
            letter-spacing: .08em;
            text-transform: uppercase;
            box-shadow: inset 0 1px 0 rgba(255, 255, 255, .70);
            backdrop-filter: blur(12px);
        }

        .ng-title-area h1 {
            margin: 0;
            color: #21160d;
            font-size: 30px;
            line-height: 1.05;
            font-weight: 950;
            letter-spacing: -.04em;
        }

        .ng-title-area p {
            max-width: 760px;
            margin: 8px 0 0;
            color: #765d45;
            font-size: 13px;
            line-height: 1.55;
            font-weight: 650;
        }

        .ng-filter-area {
            display: flex;
            align-items: center;
            justify-content: flex-end;
            gap: 10px;
            flex-wrap: wrap;
            max-width: 100%;
        }

        .ng-period-tabs {
            height: 48px;
            display: flex;
            align-items: center;
            gap: 6px;
            padding: 5px;
            border-radius: 18px;
            background: rgba(255, 255, 255, .42);
            border: 1px solid rgba(255, 255, 255, .58);
            box-shadow: 0 18px 50px rgba(120, 74, 30, .09), inset 0 1px 0 rgba(255, 255, 255, .58);
            backdrop-filter: blur(13px);
        }

        .ng-tab {
            display: inline-flex;
            align-items: center;
            justify-content: center;
            min-height: 36px;
            padding: 0 18px;
            border-radius: 13px;
            color: #6b5541;
            font-size: 12px;
            font-weight: 900;
            text-decoration: none;
            transition: .2s ease;
        }

        .ng-tab.active,
        .ng-tab:hover {
            color: #fff;
            background: linear-gradient(135deg, #ff9d18, #ee6500);
            box-shadow: 0 12px 22px rgba(238, 101, 0, .24);
        }

        .ng-admin-profile {
            min-height: 48px;
            display: flex;
            align-items: center;
            gap: 12px;
            padding: 7px 12px 7px 7px;
            border-radius: 16px;
            background: rgba(255, 255, 255, .42);
            border: 1px solid rgba(255, 255, 255, .58);
            box-shadow: 0 18px 50px rgba(120, 74, 30, .09), inset 0 1px 0 rgba(255, 255, 255, .58);
            backdrop-filter: blur(13px);
        }

        .ng-avatar {
            display: grid;
            place-items: center;
            width: 40px;
            height: 40px;
            border-radius: 50%;
            color: #fff;
            font-weight: 950;
            background: linear-gradient(135deg, #ff9b1a, #f05e00);
            box-shadow: 0 10px 22px rgba(240, 94, 0, .25);
        }

        .ng-admin-profile strong,
        .ng-admin-profile span {
            display: block;
            line-height: 1.2;
        }

        .ng-admin-profile strong {
            color: #2d1f16;
            font-size: 13px;
            font-weight: 950;
        }

        .ng-admin-profile span {
            margin-top: 3px;
            color: #7a614c;
            font-size: 11px;
            font-weight: 750;
        }

        .ng-finance-period-row {
            display: inline-flex;
            align-items: center;
            gap: 10px;
            width: fit-content;
            min-height: 36px;
            margin-bottom: 18px;
            padding: 6px 12px;
            border-radius: 999px;
            background: rgba(255, 255, 255, .36);
            border: 1px solid rgba(255, 255, 255, .50);
            color: #6b5541;
            font-size: 12px;
            font-weight: 900;
            box-shadow: inset 0 1px 0 rgba(255, 255, 255, .52);
            backdrop-filter: blur(12px);
        }

        .ng-finance-period-row strong {
            color: #2d1f16;
            font-weight: 950;
        }

        .ng-kpi-grid {
            display: grid;
            grid-template-columns: repeat(3, minmax(0, 1fr));
            gap: 14px;
            margin-bottom: 18px;
        }

        .ng-kpi-card,
        .ng-widget-card {
            position: relative;
            overflow: hidden;
            border: 1px solid rgba(255, 255, 255, .58);
            background:
                linear-gradient(145deg, rgba(255, 255, 255, .46), rgba(255, 246, 231, .22)),
                radial-gradient(circle at 100% 0%, rgba(255, 153, 30, .16), transparent 38%) !important;
            box-shadow:
                0 22px 54px rgba(101, 58, 21, .12),
                0 0 0 1px rgba(255, 255, 255, .12) inset,
                inset 0 1px 0 rgba(255, 255, 255, .62);
            backdrop-filter: blur(14px);
        }

        .ng-kpi-card::before,
        .ng-widget-card::before {
            content: "";
            position: absolute;
            inset: 0;
            pointer-events: none;
            background:
                linear-gradient(120deg, rgba(255, 255, 255, .34), transparent 28%, transparent 70%, rgba(255, 255, 255, .16));
            opacity: .38;
        }

        .ng-kpi-card {
            min-height: 108px;
            display: flex;
            gap: 12px;
            padding: 16px 15px;
            border-radius: 22px;
        }

        .ng-kpi-icon {
            position: relative;
            z-index: 1;
            display: grid;
            place-items: center;
            flex: 0 0 auto;
            width: 44px;
            height: 44px;
            border-radius: 15px;
            color: #fff;
            background: linear-gradient(135deg, var(--accent), #d95d00);
            box-shadow: 0 15px 28px rgba(249, 115, 22, .22);
            font-size: 17px;
            font-weight: 950;
        }

        .ng-kpi-content {
            position: relative;
            z-index: 1;
            min-width: 0;
            flex: 1;
        }

        .ng-kpi-label {
            display: flex;
            align-items: center;
            justify-content: space-between;
            gap: 8px;
            color: #6f5946;
            font-size: 12px;
            line-height: 1.2;
            font-weight: 900;
            text-transform: uppercase;
            letter-spacing: .06em;
        }

        .ng-kpi-content strong {
            display: block;
            margin-top: 7px;
            color: #23160d;
            font-size: 22px;
            line-height: 1.15;
            font-weight: 950;
            letter-spacing: -.03em;
            white-space: nowrap;
            overflow: hidden;
            text-overflow: ellipsis;
        }

        .ng-kpi-content p {
            margin: 8px 0 0;
            font-size: 11px;
            line-height: 1.25;
            font-weight: 850;
        }

        .ng-kpi-content p span {
            margin-left: 4px;
            color: #6f5946;
            font-weight: 750;
        }

        .ng-kpi-content .positive {
            color: #07945d;
        }

        .ng-kpi-content .negative {
            color: #e23b3b;
        }

        .ng-kpi-content .neutral {
            color: #6f5946;
        }

        .ng-finance-main-grid {
            display: grid;
            grid-template-columns: 1.45fr .9fr;
            gap: 16px;
            margin-bottom: 16px;
        }

        .ng-finance-bottom-grid {
            display: grid;
            grid-template-columns: 1.35fr .65fr;
            gap: 16px;
        }

        .ng-widget-card {
            border-radius: 24px;
            padding: 18px;
            min-width: 0;
        }

        .ng-widget-head {
            position: relative;
            z-index: 2;
            display: flex;
            align-items: flex-start;
            justify-content: space-between;
            gap: 14px;
            margin-bottom: 14px;
        }

        .ng-widget-head h2 {
            margin: 0;
            color: #25170d;
            font-size: 16px;
            line-height: 1.2;
            font-weight: 950;
            letter-spacing: -.03em;
        }

        .ng-widget-head p {
            margin: 5px 0 0;
            color: #7b624c;
            font-size: 11px;
            font-weight: 800;
        }

        .ng-widget-head a,
        .ng-widget-badge {
            display: inline-flex;
            align-items: center;
            justify-content: center;
            min-height: 32px;
            padding: 0 12px;
            border-radius: 12px;
            color: #da6200;
            background: rgba(255, 255, 255, .36);
            border: 1px solid rgba(255, 255, 255, .50);
            font-size: 11px;
            font-weight: 950;
            text-decoration: none;
            white-space: nowrap;
        }

        .ng-badge-green {
            color: #078657 !important;
            background: rgba(16, 185, 129, .14) !important;
        }

        .ng-badge-red {
            color: #d73333 !important;
            background: rgba(255, 98, 98, .13) !important;
        }

        .ng-profit-bars {
            position: relative;
            z-index: 2;
            display: grid;
            gap: 14px;
        }

        .ng-profit-row {
            display: grid;
            gap: 7px;
        }

        .ng-profit-info {
            display: flex;
            align-items: center;
            justify-content: space-between;
            gap: 10px;
            color: #6f5946;
            font-size: 12px;
            font-weight: 900;
        }

        .ng-profit-info strong {
            color: #2b1b10;
            font-weight: 950;
        }

        .ng-profit-track {
            width: 100%;
            height: 9px;
            overflow: hidden;
            border-radius: 999px;
            background: rgba(255, 255, 255, .32);
            border: 1px solid rgba(255, 255, 255, .38);
        }

        .ng-profit-track i {
            display: block;
            height: 100%;
            border-radius: inherit;
        }

        .ng-finance-shortcuts {
            position: relative;
            z-index: 2;
            display: grid;
            grid-template-columns: repeat(3, minmax(0, 1fr));
            gap: 10px;
            margin-top: 16px;
        }

        .ng-finance-shortcuts a {
            display: flex;
            align-items: center;
            justify-content: space-between;
            gap: 8px;
            min-height: 46px;
            padding: 0 14px;
            border-radius: 16px;
            color: #da6200;
            background: rgba(255, 255, 255, .28);
            border: 1px solid rgba(255, 255, 255, .42);
            box-shadow: inset 0 1px 0 rgba(255,255,255,.40);
            font-size: 12px;
            font-weight: 950;
            text-decoration: none;
            transition: .2s ease;
        }

        .ng-finance-shortcuts a:hover {
            color: #fff;
            background: linear-gradient(135deg, #ff9d18, #ee6500);
            box-shadow: 0 12px 22px rgba(238, 101, 0, .22);
        }

        .ng-cost-scroll {
            position: relative;
            z-index: 2;
            display: grid;
            gap: 9px;
            max-height: 334px;
            overflow-y: auto;
            padding-right: 5px;
        }

        .ng-cost-scroll::-webkit-scrollbar {
            width: 6px;
        }

        .ng-cost-scroll::-webkit-scrollbar-track {
            background: rgba(255, 255, 255, .28);
            border-radius: 999px;
        }

        .ng-cost-scroll::-webkit-scrollbar-thumb {
            background: rgba(249, 115, 22, .55);
            border-radius: 999px;
        }

        .ng-cost-row {
            padding: 11px;
            border-radius: 17px;
            background: rgba(255, 255, 255, .24);
            border: 1px solid rgba(255, 255, 255, .38);
        }

        .ng-cost-top {
            display: flex;
            align-items: center;
            justify-content: space-between;
            gap: 10px;
            min-width: 0;
        }

        .ng-cost-top strong {
            display: block;
            min-width: 0;
            overflow: hidden;
            color: #2b1b10;
            font-size: 12px;
            font-weight: 950;
            white-space: nowrap;
            text-overflow: ellipsis;
        }

        .ng-cost-top span {
            flex: 0 0 auto;
            color: #e23b3b;
            font-size: 12px;
            font-weight: 950;
        }

        .ng-cost-meta {
            display: flex;
            align-items: center;
            gap: 8px;
            margin-top: 5px;
            min-width: 0;
            overflow: hidden;
        }

        .ng-cost-meta span {
            color: #8b7057;
            font-size: 10px;
            font-weight: 800;
            white-space: nowrap;
        }

        .ng-cost-main p {
            margin: 7px 0 0;
            color: #8b7057;
            font-size: 10px;
            line-height: 1.35;
            font-weight: 750;
        }

        .ng-cost-bar,
        .ng-margin-bar {
            width: 100%;
            height: 7px;
            margin-top: 9px;
            overflow: hidden;
            border-radius: 999px;
            background: rgba(249, 115, 22, .11);
        }

        .ng-cost-bar i {
            display: block;
            height: 100%;
            border-radius: inherit;
            background: linear-gradient(90deg, #fb7185, #ef4444);
        }

        .ng-margin-grid {
            position: relative;
            z-index: 2;
            display: grid;
            grid-template-columns: repeat(2, minmax(0, 1fr));
            gap: 10px;
        }

        .ng-margin-row {
            min-width: 0;
            padding: 12px;
            border-radius: 17px;
            background: rgba(255, 255, 255, .24);
            border: 1px solid rgba(255, 255, 255, .38);
        }

        .ng-margin-top {
            display: flex;
            align-items: flex-start;
            justify-content: space-between;
            gap: 10px;
        }

        .ng-margin-top div {
            min-width: 0;
        }

        .ng-margin-top strong {
            display: block;
            min-width: 0;
            overflow: hidden;
            color: #2b1b10;
            font-size: 12px;
            font-weight: 950;
            white-space: nowrap;
            text-overflow: ellipsis;
        }

        .ng-margin-top span {
            display: block;
            margin-top: 4px;
            color: #8b7057;
            font-size: 10px;
            font-weight: 800;
        }

        .ng-margin-top b {
            display: block;
            color: #078657;
            font-size: 12px;
            font-weight: 950;
            white-space: nowrap;
            text-align: right;
        }

        .ng-margin-top small {
            display: block;
            margin-top: 4px;
            color: #8b7057;
            font-size: 10px;
            font-weight: 800;
            white-space: nowrap;
            text-align: right;
        }

        .ng-margin-bar i {
            display: block;
            height: 100%;
            border-radius: inherit;
            background: linear-gradient(90deg, #34d399, #10b981);
        }

        .ng-summary-list {
            position: relative;
            z-index: 2;
            display: grid;
            gap: 10px;
        }

        .ng-summary-list div {
            display: flex;
            align-items: center;
            justify-content: space-between;
            gap: 10px;
            min-height: 45px;
            padding: 0 13px;
            border-radius: 15px;
            background: rgba(255, 255, 255, .24);
            border: 1px solid rgba(255, 255, 255, .38);
        }

        .ng-summary-list span {
            color: #7b624c;
            font-size: 11px;
            font-weight: 850;
        }

        .ng-summary-list strong {
            color: #2b1b10;
            font-size: 12px;
            font-weight: 950;
            text-align: right;
        }

        .ng-summary-list div.positive strong {
            color: #078657;
        }

        .ng-summary-list div.negative strong {
            color: #d73333;
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


        .ng-month-select-wrap {
            height: 48px;
            min-width: 164px;
            display: flex;
            align-items: center;
            padding: 5px 12px;
            border-radius: 18px;
            background: rgba(255, 255, 255, .42);
            border: 1px solid rgba(255, 255, 255, .58);
            box-shadow: 0 18px 50px rgba(120, 74, 30, .09), inset 0 1px 0 rgba(255, 255, 255, .58);
            backdrop-filter: blur(13px);
        }

        .ng-month-select {
            width: 100%;
            min-height: 36px;
            border: 0;
            outline: 0;
            cursor: pointer;
            color: #6b5541;
            background: transparent;
            font-size: 12px;
            font-weight: 900;
        }

        .ng-month-select option {
            color: #2d1f16;
            background: #fff6ea;
            font-weight: 800;
        }

        .ng-period-extra {
            color: #d95d00 !important;
            font-weight: 950 !important;
        }

        .ng-year-detail-section {
            margin-bottom: 16px;
        }

        .ng-year-card {
            padding: 18px;
        }

        .ng-year-summary-strip {
            position: relative;
            z-index: 2;
            display: grid;
            grid-template-columns: repeat(5, minmax(0, 1fr));
            gap: 10px;
            margin-bottom: 14px;
        }

        .ng-year-summary-strip div {
            min-width: 0;
            min-height: 66px;
            display: grid;
            align-content: center;
            gap: 6px;
            padding: 12px 13px;
            border-radius: 17px;
            background: rgba(255, 255, 255, .24);
            border: 1px solid rgba(255, 255, 255, .38);
            box-shadow: inset 0 1px 0 rgba(255, 255, 255, .34);
        }

        .ng-year-summary-strip span {
            color: #7b624c;
            font-size: 10px;
            line-height: 1.2;
            font-weight: 900;
            text-transform: uppercase;
            letter-spacing: .05em;
        }

        .ng-year-summary-strip strong {
            color: #2b1b10;
            font-size: 14px;
            line-height: 1.15;
            font-weight: 950;
            white-space: nowrap;
            overflow: hidden;
            text-overflow: ellipsis;
        }

        .ng-year-summary-strip .positive strong {
            color: #078657;
        }

        .ng-year-summary-strip .negative strong {
            color: #d73333;
        }

        .ng-year-table-scroll {
            position: relative;
            z-index: 2;
            display: grid;
            gap: 9px;
            max-height: 430px;
            overflow-y: auto;
            padding-right: 5px;
        }

        .ng-year-table-scroll::-webkit-scrollbar {
            width: 6px;
        }

        .ng-year-table-scroll::-webkit-scrollbar-track {
            background: rgba(255, 255, 255, .28);
            border-radius: 999px;
        }

        .ng-year-table-scroll::-webkit-scrollbar-thumb {
            background: rgba(249, 115, 22, .55);
            border-radius: 999px;
        }

        .ng-year-row {
            display: grid;
            grid-template-columns: 150px minmax(0, 1fr);
            gap: 12px;
            align-items: center;
            min-width: 0;
            padding: 12px;
            border-radius: 18px;
            color: inherit;
            text-decoration: none;
            background: rgba(255, 255, 255, .24);
            border: 1px solid rgba(255, 255, 255, .38);
            transition: .2s ease;
        }

        .ng-year-row:hover,
        .ng-year-row.active {
            background: rgba(255, 255, 255, .52);
            border-color: rgba(249, 115, 22, .45);
            box-shadow: 0 14px 28px rgba(249, 115, 22, .12), inset 0 1px 0 rgba(255, 255, 255, .54);
        }

        .ng-year-month strong {
            display: block;
            color: #2b1b10;
            font-size: 13px;
            font-weight: 950;
            white-space: nowrap;
            overflow: hidden;
            text-overflow: ellipsis;
        }

        .ng-year-month span {
            display: block;
            margin-top: 4px;
            color: #8b7057;
            font-size: 10px;
            font-weight: 850;
        }

        .ng-year-values {
            min-width: 0;
            display: grid;
            grid-template-columns: repeat(7, minmax(0, 1fr));
            gap: 8px;
        }

        .ng-year-values div {
            min-width: 0;
        }

        .ng-year-values span {
            display: block;
            color: #8b7057;
            font-size: 9px;
            line-height: 1.2;
            font-weight: 850;
            text-transform: uppercase;
            letter-spacing: .04em;
        }

        .ng-year-values strong {
            display: block;
            margin-top: 4px;
            color: #2b1b10;
            font-size: 10px;
            line-height: 1.2;
            font-weight: 950;
            white-space: nowrap;
            overflow: hidden;
            text-overflow: ellipsis;
        }

        .ng-year-values .positive strong {
            color: #078657;
        }

        .ng-year-values .negative strong {
            color: #d73333;
        }

        .ng-year-progress {
            grid-column: 2 / -1;
            width: 100%;
            height: 7px;
            overflow: hidden;
            border-radius: 999px;
            background: rgba(249, 115, 22, .11);
        }

        .ng-year-progress i {
            display: block;
            height: 100%;
            border-radius: inherit;
            background: linear-gradient(90deg, #ff9d18, #f97316);
        }

        @media (max-width: 1500px) {
            .ng-kpi-grid {
                grid-template-columns: repeat(2, minmax(0, 1fr));
            }

            .ng-finance-main-grid,
            .ng-finance-bottom-grid {
                grid-template-columns: 1fr;
            }

            .ng-year-summary-strip {
                grid-template-columns: repeat(2, minmax(0, 1fr));
            }

            .ng-year-values {
                grid-template-columns: repeat(3, minmax(0, 1fr));
            }
        }

        @media (max-width: 1100px) {
            .ng-dashboard-header {
                flex-direction: column;
                align-items: flex-start;
            }

            .ng-filter-area {
                justify-content: flex-start;
            }

            .ng-kpi-grid,
            .ng-margin-grid,
            .ng-finance-shortcuts,
            .ng-year-summary-strip {
                grid-template-columns: 1fr;
            }

            .ng-year-row {
                grid-template-columns: 1fr;
            }

            .ng-year-values {
                grid-template-columns: repeat(2, minmax(0, 1fr));
            }

            .ng-year-progress {
                grid-column: 1 / -1;
            }
        }
        /* =========================================================
   FINAL SIDEBAR EFFECT SYNC - FINANCE PAGES
   Bikin sidebar halaman Keuangan sama rasa/effect dengan
   Dashboard Admin dan halaman resource lain.
   Tidak sentuh theme.css.
========================================================= */

body:has(.ng-finance-dashboard) .fi-sidebar,
body:has(.ng-operational-page) .fi-sidebar,
body:has(.ng-operational-form-page) .fi-sidebar,
body:has(.ng-sales-target-page) .fi-sidebar,
body:has(.ng-sales-target-form-page) .fi-sidebar {
    background: rgba(255, 250, 242, .50) !important;
    border-right: 1px solid rgba(255, 255, 255, .48) !important;
    box-shadow: 18px 0 55px rgba(137, 78, 26, .10) !important;
    backdrop-filter: blur(16px) !important;
    -webkit-backdrop-filter: blur(16px) !important;
}

body:has(.ng-finance-dashboard) .fi-sidebar-nav,
body:has(.ng-operational-page) .fi-sidebar-nav,
body:has(.ng-operational-form-page) .fi-sidebar-nav,
body:has(.ng-sales-target-page) .fi-sidebar-nav,
body:has(.ng-sales-target-form-page) .fi-sidebar-nav {
    padding: 18px 14px !important;
}

body:has(.ng-finance-dashboard) .fi-sidebar-item a,
body:has(.ng-operational-page) .fi-sidebar-item a,
body:has(.ng-operational-form-page) .fi-sidebar-item a,
body:has(.ng-sales-target-page) .fi-sidebar-item a,
body:has(.ng-sales-target-form-page) .fi-sidebar-item a {
    border-radius: 14px !important;
    color: #6f5844 !important;
    transition: .2s ease !important;
}

body:has(.ng-finance-dashboard) .fi-sidebar-item-active a,
body:has(.ng-finance-dashboard) .fi-sidebar-item a:hover,
body:has(.ng-operational-page) .fi-sidebar-item-active a,
body:has(.ng-operational-page) .fi-sidebar-item a:hover,
body:has(.ng-operational-form-page) .fi-sidebar-item-active a,
body:has(.ng-operational-form-page) .fi-sidebar-item a:hover,
body:has(.ng-sales-target-page) .fi-sidebar-item-active a,
body:has(.ng-sales-target-page) .fi-sidebar-item a:hover,
body:has(.ng-sales-target-form-page) .fi-sidebar-item-active a,
body:has(.ng-sales-target-form-page) .fi-sidebar-item a:hover {
    background: linear-gradient(135deg, #ff9500, #f26a00) !important;
    color: #fff !important;
    box-shadow: 0 14px 24px rgba(242, 106, 0, .24) !important;
}

body:has(.ng-finance-dashboard) .fi-sidebar-item-active svg,
body:has(.ng-finance-dashboard) .fi-sidebar-item a:hover svg,
body:has(.ng-operational-page) .fi-sidebar-item-active svg,
body:has(.ng-operational-page) .fi-sidebar-item a:hover svg,
body:has(.ng-operational-form-page) .fi-sidebar-item-active svg,
body:has(.ng-operational-form-page) .fi-sidebar-item a:hover svg,
body:has(.ng-sales-target-page) .fi-sidebar-item-active svg,
body:has(.ng-sales-target-page) .fi-sidebar-item a:hover svg,
body:has(.ng-sales-target-form-page) .fi-sidebar-item-active svg,
body:has(.ng-sales-target-form-page) .fi-sidebar-item a:hover svg {
    color: #fff !important;
}

body:has(.ng-finance-dashboard) .fi-sidebar-item-active span,
body:has(.ng-finance-dashboard) .fi-sidebar-item a:hover span,
body:has(.ng-operational-page) .fi-sidebar-item-active span,
body:has(.ng-operational-page) .fi-sidebar-item a:hover span,
body:has(.ng-operational-form-page) .fi-sidebar-item-active span,
body:has(.ng-operational-form-page) .fi-sidebar-item a:hover span,
body:has(.ng-sales-target-page) .fi-sidebar-item-active span,
body:has(.ng-sales-target-page) .fi-sidebar-item a:hover span,
body:has(.ng-sales-target-form-page) .fi-sidebar-item-active span,
body:has(.ng-sales-target-form-page) .fi-sidebar-item a:hover span {
    color: #fff !important;
}
    </style>
 <?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__attributesOriginal166a02a7c5ef5a9331faf66fa665c256)): ?>
<?php $attributes = $__attributesOriginal166a02a7c5ef5a9331faf66fa665c256; ?>
<?php unset($__attributesOriginal166a02a7c5ef5a9331faf66fa665c256); ?>
<?php endif; ?>
<?php if (isset($__componentOriginal166a02a7c5ef5a9331faf66fa665c256)): ?>
<?php $component = $__componentOriginal166a02a7c5ef5a9331faf66fa665c256; ?>
<?php unset($__componentOriginal166a02a7c5ef5a9331faf66fa665c256); ?>
<?php endif; ?><?php /**PATH /var/www/html/resources/views/filament/admin/pages/financial-dashboard.blade.php ENDPATH**/ ?>