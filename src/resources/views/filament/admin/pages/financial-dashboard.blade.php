<x-filament-panels::page>
    @php
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
    @endphp

    <div class="ng-finance-dashboard-new">
        <section class="ng-topbar">
            <div class="ng-title-area">
                <h1>Dashboard Keuangan</h1>
                <p>Ringkasan kinerja keuangan Ngunjuk POS</p>
                <small class="ng-active-data-label">
                    Data bulan aktif: {{ $selectedMonthLabel }} {{ $selectedYear }} • {{ $dateRangeLabel }}
                </small>
            </div>

            <div class="ng-filter-area">
                <div class="ng-monthly-filter-block">
                    <span class="ng-filter-label">Periode Bulanan</span>

                    <div class="ng-monthly-filter-card">
                        <select class="ng-monthly-select" onchange="window.location.href = this.value">
                            @foreach ($months as $monthKey => $monthLabel)
                                @continue($monthKey === 'all')

                                <option value="{{ $makeMonthlyUrl((string) $monthKey, $selectedYear) }}"
                                        @selected((string) $selectedMonth === (string) $monthKey)>
                                    {{ $monthLabel }}
                                </option>
                            @endforeach
                        </select>

                        <select class="ng-monthly-select ng-year-select" onchange="window.location.href = this.value">
                            @foreach ($availableYears as $yearOption)
                                <option value="{{ $makeMonthlyUrl((string) $selectedMonth, (int) $yearOption) }}"
                                        @selected((int) $selectedYear === (int) $yearOption)>
                                    {{ $yearOption }}
                                </option>
                            @endforeach
                        </select>
                    </div>
                </div>
            </div>
        </section>

        <section class="ng-kpi-grid">
            @foreach ($kpiCards as $card)
                @php
                    $trend = $card['trend'];
                    $trendValue = is_null($trend) ? 0 : (float) $trend;
                    $isTrendUp = $trendValue >= 0;
                    $isGood = ($card['trend_good_when'] ?? 'up') === 'up'
                        ? $isTrendUp
                        : ! $isTrendUp;
                @endphp

                <article class="ng-kpi-card" style="--accent: {{ $card['color'] }};">
                    <div class="ng-kpi-icon">
                        {{ $card['icon'] }}
                    </div>

                    <div class="ng-kpi-content">
                        <span>{{ $card['label'] }}</span>
                        <strong>{{ $card['value'] }}</strong>

                        <p class="{{ $isGood ? 'positive' : 'negative' }}">
                            {{ $isTrendUp ? '↑' : '↓' }}
                            {{ number_format(abs($trendValue), 1, ',', '.') }}%
                            <em>dibandingkan periode sebelumnya</em>
                        </p>
                    </div>
                </article>
            @endforeach
        </section>

        <section class="ng-visual-grid">
            <article class="ng-card ng-revenue-card">
                <div class="ng-card-head">
                    <div>
                        <h2>Tren Revenue Mingguan {{ $selectedMonthLabel }} {{ $selectedYear }}</h2>
                        <p>Ringkasan revenue per minggu dalam bulan aktif</p>
                    </div>
                </div>

                <div class="ng-chart-responsive">
                    <div class="ng-y-axis">
                        @foreach ([1, .75, .5, .25, 0] as $step)
                            <span>{{ $formatShortMoney((int) ($niceChartMax * $step)) }}</span>
                        @endforeach
                    </div>

                    <div class="ng-chart-area ng-chart-area-static">
                        <div class="ng-grid-lines">
                            <i></i>
                            <i></i>
                            <i></i>
                            <i></i>
                            <i></i>
                        </div>

                        <div class="ng-bars ng-bars-weekly" style="--bar-count: {{ max($revenueTrend->count(), 1) }};">
                            @forelse ($revenueTrend as $row)
                                @php
                                    $value = (int) ($row['value'] ?? 0);
                                    $height = $niceChartMax > 0 ? max(3, min(100, ($value / $niceChartMax) * 100)) : 0;
                                    $tooltipLabel = $row['tooltip_label'] ?? ($row['label'] ?? '-');
                                @endphp

                                <div class="ng-bar-item" tabindex="0" role="button" aria-label="{{ $tooltipLabel }} - Revenue {{ $this->rupiah($value) }}" data-tooltip-label="{{ $tooltipLabel }}" data-tooltip-value="{{ $this->rupiah($value) }}" style="--item-index: {{ $loop->index }};">


                                    <div class="ng-bar-wrap">
                                        <span data-bar-height="{{ $height }}"></span>
                                    </div>

                                    <small>{{ $row['short_label'] ?? $row['label'] ?? '-' }}</small>
                                </div>
                            @empty
                                <div class="ng-empty-state">
                                    Belum ada data revenue.
                                </div>
                            @endforelse
                        </div>
                    </div>
                </div>


                <div class="ng-active-chart-tooltip" data-chart-click-tooltip aria-hidden="true">
                    <strong data-chart-tooltip-title>-</strong>
                    <div class="ng-active-chart-tooltip-row">
                        <span></span>
                        <em>Revenue:</em>
                        <b data-chart-tooltip-value>-</b>
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
                    @foreach ($targetItems as $target)
                        @php
                            $actual = (int) ($target['actual'] ?? 0);
                            $targetValue = (int) ($target['target'] ?? 0);
                            $percent = $targetValue > 0 ? round(($actual / $targetValue) * 100, 1) : 0;
                            $barWidth = $targetValue > 0 ? min(100, max(5, abs($percent))) : 0;
                            $remaining = $targetValue > 0 ? max($targetValue - $actual, 0) : 0;
                            $isNegativeProgress = $percent < 0;
                        @endphp

                        <div class="ng-target-row" style="--target-color: {{ $target['color'] }}">
                            <div class="ng-target-icon">
                                {{ $target['icon'] }}
                            </div>

                            <div class="ng-target-main">
                                <div class="ng-target-top">
                                    <div>
                                        <strong>{{ $target['title'] }}</strong>
                                        <span>{{ $this->rupiah($actual) }}</span>
                                    </div>

                                    <div>
                                        <strong>{{ $targetValue > 0 ? $this->rupiah($targetValue) : 'Target belum diatur' }}</strong>
                                    </div>

                                    <b class="{{ $isNegativeProgress ? 'negative' : 'positive' }}">
                                        {{ number_format($percent, 1, ',', '.') }}%
                                    </b>
                                </div>

                                <div class="ng-target-track {{ $isNegativeProgress ? 'danger' : '' }}">
                                    <i data-target-width="{{ $barWidth }}"></i>
                                </div>

                                <div class="ng-target-bottom">
                                    <span></span>
                                    <small>{{ $targetValue > 0 ? 'Sisa ' . $this->rupiah($remaining) : 'Silakan atur target penjualan' }}</small>
                                </div>
                            </div>
                        </div>
                    @endforeach
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
                    <a href="{{ $links['operational_costs'] ?? '#' }}">⚙ Kelola Biaya</a>
                    <a href="{{ $links['operational_costs'] ?? '#' }}">↧ Export</a>
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
                            <th>Dihitung Bulan Ini</th>
                            <th>Status</th>
                        </tr>
                    </thead>

                    <tbody>
                        @if ($costs->count() > 0)
                            @foreach ($costPages as $pageIndex => $costPage)
                                @foreach ($costPage as $cost)
                                    <tr class="ng-cost-page-row {{ $pageIndex === 0 ? 'is-active' : '' }}"
                                        data-cost-page="{{ $pageIndex + 1 }}">
                                        <td>
                                            <div class="ng-cost-category">
                                                <span>▣</span>
                                                <strong>{{ $cost['name'] ?? '-' }}</strong>
                                            </div>
                                        </td>
                                        <td>{{ $cost['category'] ?? '-' }}</td>
                                        <td>
                                            <span class="ng-cost-type-badge {{ ! empty($cost['is_annual']) ? 'annual' : '' }}">
                                                {{ $cost['cost_type_label'] ?? '-' }}
                                            </span>
                                        </td>
                                        <td>{{ $cost['date'] ?? '-' }}</td>
                                        <td class="ng-money">
                                            {{ $this->rupiah($cost['amount'] ?? 0) }}
                                            @if (! empty($cost['is_annual']))
                                                <small>{{ $cost['description'] ?? 'Tahunan / 12' }}</small>
                                            @endif
                                        </td>
                                        <td><span class="ng-status-paid">Dihitung</span></td>
                                    </tr>
                                @endforeach
                            @endforeach
                        @else
                            <tr>
                                <td colspan="6">
                                    <div class="ng-empty-state">
                                        Belum ada biaya operasional.
                                    </div>
                                </td>
                            </tr>
                        @endif
                    </tbody>
                </table>
            </div>

            @if ($costs->count() > 0)
                <div class="ng-table-footer"
                     data-total-costs="{{ $costs->count() }}"
                     data-per-page="5"
                     data-total-pages="{{ $totalCostPages }}">


                    <div class="ng-cost-pagination">
                        <button type="button"
                                class="ng-cost-page-btn is-disabled"
                                data-cost-prev
                                aria-label="Data biaya sebelumnya">
                            ‹
                        </button>


                        <button type="button"
                                class="ng-cost-page-btn {{ $totalCostPages <= 1 ? 'is-disabled' : '' }}"
                                data-cost-next
                                aria-label="Data biaya berikutnya">
                            ›
                        </button>
                    </div>
                </div>
            @endif
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

        @media (max-width: 1280px) {


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


        /*
        |--------------------------------------------------------------------------
        | SIDEBAR EFFECT SYNC - DASHBOARD KEUANGAN
        |--------------------------------------------------------------------------
        */

        body:has(.ng-finance-dashboard-new) .fi-sidebar,
        body.ng-finance-sidebar-sync .fi-sidebar {
            background: rgba(255, 250, 242, .50) !important;
            border-right: 1px solid rgba(255, 255, 255, .48) !important;
            box-shadow: 18px 0 55px rgba(137, 78, 26, .10) !important;
            backdrop-filter: blur(16px) !important;
            -webkit-backdrop-filter: blur(16px) !important;
        }

        body:has(.ng-finance-dashboard-new) .fi-sidebar-nav,
        body.ng-finance-sidebar-sync .fi-sidebar-nav {
            padding: 18px 14px !important;
        }

        body:has(.ng-finance-dashboard-new) .fi-sidebar-item a,
        body:has(.ng-finance-dashboard-new) .fi-sidebar-item-button,
        body.ng-finance-sidebar-sync .fi-sidebar-item a,
        body.ng-finance-sidebar-sync .fi-sidebar-item-button {
            border-radius: 14px !important;
            color: #6f5844 !important;
            transition: .2s ease !important;
        }

        body:has(.ng-finance-dashboard-new) .fi-sidebar-item-active a,
        body:has(.ng-finance-dashboard-new) .fi-sidebar-item a:hover,
        body:has(.ng-finance-dashboard-new) .fi-sidebar-item-active .fi-sidebar-item-button,
        body:has(.ng-finance-dashboard-new) .fi-sidebar-item .fi-sidebar-item-button:hover,
        body:has(.ng-finance-dashboard-new) .fi-sidebar-item.fi-active a,
        body:has(.ng-finance-dashboard-new) .fi-sidebar-item.fi-active .fi-sidebar-item-button,
        body.ng-finance-sidebar-sync .fi-sidebar-item-active a,
        body.ng-finance-sidebar-sync .fi-sidebar-item a:hover,
        body.ng-finance-sidebar-sync .fi-sidebar-item-active .fi-sidebar-item-button,
        body.ng-finance-sidebar-sync .fi-sidebar-item .fi-sidebar-item-button:hover,
        body.ng-finance-sidebar-sync .fi-sidebar-item.fi-active a,
        body.ng-finance-sidebar-sync .fi-sidebar-item.fi-active .fi-sidebar-item-button {
            background: linear-gradient(135deg, #ff9500, #f26a00) !important;
            color: #fff !important;
            box-shadow: 0 14px 24px rgba(242, 106, 0, .24) !important;
        }

        body:has(.ng-finance-dashboard-new) .fi-sidebar-item-active svg,
        body:has(.ng-finance-dashboard-new) .fi-sidebar-item a:hover svg,
        body:has(.ng-finance-dashboard-new) .fi-sidebar-item-active span,
        body:has(.ng-finance-dashboard-new) .fi-sidebar-item a:hover span,
        body:has(.ng-finance-dashboard-new) .fi-sidebar-item-active .fi-sidebar-item-icon,
        body:has(.ng-finance-dashboard-new) .fi-sidebar-item-active .fi-sidebar-item-label,
        body:has(.ng-finance-dashboard-new) .fi-sidebar-item .fi-sidebar-item-button:hover .fi-sidebar-item-icon,
        body:has(.ng-finance-dashboard-new) .fi-sidebar-item .fi-sidebar-item-button:hover .fi-sidebar-item-label,
        body:has(.ng-finance-dashboard-new) .fi-sidebar-item.fi-active svg,
        body:has(.ng-finance-dashboard-new) .fi-sidebar-item.fi-active span,
        body:has(.ng-finance-dashboard-new) .fi-sidebar-item.fi-active .fi-sidebar-item-icon,
        body:has(.ng-finance-dashboard-new) .fi-sidebar-item.fi-active .fi-sidebar-item-label,
        body.ng-finance-sidebar-sync .fi-sidebar-item-active svg,
        body.ng-finance-sidebar-sync .fi-sidebar-item a:hover svg,
        body.ng-finance-sidebar-sync .fi-sidebar-item-active span,
        body.ng-finance-sidebar-sync .fi-sidebar-item a:hover span,
        body.ng-finance-sidebar-sync .fi-sidebar-item-active .fi-sidebar-item-icon,
        body.ng-finance-sidebar-sync .fi-sidebar-item-active .fi-sidebar-item-label,
        body.ng-finance-sidebar-sync .fi-sidebar-item .fi-sidebar-item-button:hover .fi-sidebar-item-icon,
        body.ng-finance-sidebar-sync .fi-sidebar-item .fi-sidebar-item-button:hover .fi-sidebar-item-label,
        body.ng-finance-sidebar-sync .fi-sidebar-item.fi-active svg,
        body.ng-finance-sidebar-sync .fi-sidebar-item.fi-active span,
        body.ng-finance-sidebar-sync .fi-sidebar-item.fi-active .fi-sidebar-item-icon,
        body.ng-finance-sidebar-sync .fi-sidebar-item.fi-active .fi-sidebar-item-label {
            color: #fff !important;
        }


        /*
        |--------------------------------------------------------------------------
        | CHART CLEAN FIX - REMOVE STUCK TOOLTIP
        |--------------------------------------------------------------------------
        */

        .ng-chart-tooltip,
        .ng-chart-tooltip::after,
        .ng-chart-tooltip-row,
        .ng-chart-tooltip-dot {
            display: none !important;
            visibility: hidden !important;
            opacity: 0 !important;
            width: 0 !important;
            height: 0 !important;
            padding: 0 !important;
            margin: 0 !important;
            pointer-events: none !important;
        }

        .ng-bars-weekly .ng-bar-item {
            position: relative !important;
            display: grid !important;
            grid-template-rows: 1fr 26px !important;
            align-items: end !important;
            gap: 7px !important;
            padding-top: 0 !important;
        }

        .ng-bars-weekly .ng-bar-wrap {
            height: 100% !important;
            min-height: 0 !important;
        }

        .ng-bars-weekly .ng-bar-wrap span {
            display: block !important;
            min-height: 3px !important;
        }


        /*
        |--------------------------------------------------------------------------
        | VISUAL POLISH + INTERACTIVE ANIMATION
        |--------------------------------------------------------------------------
        */

        .ng-chart-responsive {
            grid-template-columns: 72px minmax(0, 1fr) !important;
            min-height: 300px !important;
            align-items: stretch;
        }

        .ng-y-axis {
            height: 280px;
            padding: 0 12px 40px 0 !important;
            display: grid;
            grid-template-rows: repeat(5, minmax(0, 1fr));
            align-items: stretch;
        }

        .ng-y-axis span {
            display: flex;
            align-items: center;
            justify-content: flex-end;
            min-height: 0;
            transform: none !important;
            line-height: 1;
            white-space: nowrap;
        }

        .ng-y-axis span:first-child {
            align-items: flex-start;
            padding-top: 2px;
        }

        .ng-y-axis span:last-child {
            align-items: flex-end;
            padding-bottom: 2px;
        }

        .ng-chart-area,
        .ng-chart-area.ng-chart-area-static {
            overflow: visible !important;
            padding-bottom: 38px !important;
        }

        .ng-grid-lines {
            inset: 10px 0 38px 0 !important;
        }

        .ng-grid-lines i,
        .ng-grid-lines i:last-child {
            border-color: rgba(109, 79, 50, .10) !important;
        }

        .ng-bars,
        .ng-bars-weekly {
            min-width: 100% !important;
            height: 280px !important;
            gap: 18px !important;
            padding: 0 8px !important;
        }

        .ng-bars-weekly .ng-bar-item {
            position: relative;
            padding-top: 78px !important;
            cursor: pointer;
            user-select: none;
        }

        .ng-bar-item {
            outline: none;
        }

        .ng-bars-weekly .ng-bar-wrap {
            align-items: end;
        }

        .ng-bars-weekly .ng-bar-wrap span {
            width: min(100%, 30px) !important;
            height: 0;
            min-height: 0 !important;
            border-radius: 12px 12px 4px 4px !important;
            background: linear-gradient(180deg, #ffa12b, #ff6a00) !important;
            box-shadow: 0 12px 22px rgba(249, 115, 22, .18) !important;
            transition: height .9s cubic-bezier(.22, 1, .36, 1), transform .22s ease, filter .22s ease;
            transform-origin: bottom center;
        }

        .ng-bar-item:hover .ng-bar-wrap span,
        .ng-bar-item:focus-visible .ng-bar-wrap span,
        .ng-bar-item.is-open .ng-bar-wrap span {
            filter: brightness(1.05);
            transform: translateY(-2px);
        }

        .ng-chart-tooltip {
            top: 8px !important;
            min-width: 210px;
            max-width: min(260px, calc(100vw - 40px));
            padding: 16px 18px !important;
            border-radius: 18px !important;
            background: rgba(244, 244, 246, .97) !important;
            box-shadow: 0 18px 46px rgba(77, 51, 22, .18) !important;
            transform: translate(-50%, 8px) !important;
        }

        .ng-chart-tooltip strong {
            color: #747b84 !important;
            font-size: 17px !important;
            font-weight: 950 !important;
            margin-bottom: 12px !important;
        }

        .ng-chart-tooltip-row {
            gap: 8px !important;
            color: #2e2620 !important;
            font-size: 15px !important;
            font-weight: 800 !important;
        }

        .ng-chart-tooltip-row b {
            color: #23170f !important;
            font-size: 16px !important;
            font-weight: 950 !important;
        }

        .ng-chart-tooltip-dot {
            width: 15px !important;
            height: 15px !important;
        }

        .ng-bar-item.is-open .ng-chart-tooltip,
        .ng-bar-item:hover .ng-chart-tooltip,
        .ng-bar-item:focus-visible .ng-chart-tooltip,
        .ng-bar-item:focus-within .ng-chart-tooltip {
            opacity: 1 !important;
            visibility: visible !important;
            transform: translate(-50%, -8px) !important;
        }

        .ng-target-row {
            opacity: .7;
            transform: translateY(10px);
            transition: opacity .45s ease, transform .45s ease;
        }

        .ng-target-row.is-visible {
            opacity: 1;
            transform: translateY(0);
        }

        .ng-target-top b {
            font-size: 17px !important;
            color: #23170f !important;
        }

        .ng-target-top b.negative,
        .ng-target-top b.positive {
            color: #23170f !important;
        }

        .ng-target-track {
            overflow: hidden;
        }

        .ng-target-track i {
            display: block;
            width: 0;
            transition: width .95s cubic-bezier(.22, 1, .36, 1);
        }

        @media (max-width: 960px) {
            .ng-chart-responsive {
                grid-template-columns: 56px minmax(0, 1fr) !important;
            }

            .ng-y-axis {
                height: 248px;
                padding-right: 8px !important;
            }

            .ng-bars,
            .ng-bars-weekly {
                height: 248px !important;
                gap: 12px !important;
            }

            .ng-bars-weekly .ng-bar-item {
                padding-top: 72px !important;
            }

            .ng-chart-tooltip {
                min-width: 186px;
                padding: 14px 16px !important;
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
<script>
        (function () {
            function syncFinanceSidebarClass() {
                document.body.classList.add('ng-finance-sidebar-sync');
            }

            document.addEventListener('DOMContentLoaded', syncFinanceSidebarClass);
            document.addEventListener('livewire:navigated', syncFinanceSidebarClass);
            document.addEventListener('livewire:update', syncFinanceSidebarClass);
            syncFinanceSidebarClass();
        })();
    </script>


    <style id="ng-finance-force-layout-v2">
        /*
        |--------------------------------------------------------------------------
        | FORCE LAYOUT V2 - DASHBOARD KEUANGAN IKUT DASHBOARD UTAMA
        |--------------------------------------------------------------------------
        | Style ini sengaja dibuat di luar style utama dan diletakkan paling bawah,
        | supaya benar-benar menang dari CSS lama Dashboard Keuangan.
        */

        body:has(.ng-finance-dashboard-new) .ng-finance-dashboard-new {
            width: 100% !important;
            max-width: 100% !important;
            min-height: 100vh !important;
            padding: 22px 22px 28px !important;
            overflow: hidden !important;
            font-family: Inter, Poppins, ui-sans-serif, system-ui, -apple-system, BlinkMacSystemFont, "Segoe UI", sans-serif !important;
            color: #24180f !important;
        }

        body:has(.ng-finance-dashboard-new) .ng-topbar {
            display: flex !important;
            align-items: flex-start !important;
            justify-content: space-between !important;
            gap: 18px !important;
            margin-bottom: 14px !important;
        }

        body:has(.ng-finance-dashboard-new) .ng-title-area h1 {
            font-size: 29px !important;
            line-height: 1.05 !important;
            font-weight: 950 !important;
            letter-spacing: -.04em !important;
        }

        body:has(.ng-finance-dashboard-new) .ng-title-area p {
            margin-top: 8px !important;
            font-size: 13px !important;
            font-weight: 650 !important;
        }

        body:has(.ng-finance-dashboard-new) .ng-active-data-label {
            margin-top: 8px !important;
            padding: 7px 12px !important;
            font-size: 12px !important;
            line-height: 1 !important;
        }

        body:has(.ng-finance-dashboard-new) .ng-monthly-filter-card {
            min-height: 48px !important;
            height: 48px !important;
            padding: 5px !important;
            gap: 6px !important;
            border-radius: 18px !important;
        }

        body:has(.ng-finance-dashboard-new) .ng-monthly-select {
            min-height: 36px !important;
            height: 36px !important;
            min-width: 150px !important;
            font-size: 12px !important;
            font-weight: 900 !important;
            border-radius: 13px !important;
        }

        body:has(.ng-finance-dashboard-new) .ng-year-select {
            min-width: 112px !important;
        }

        /*
        |--------------------------------------------------------------------------
        | KPI FORCE - UKURAN SEPERTI DASHBOARD UTAMA
        |--------------------------------------------------------------------------
        */

        body:has(.ng-finance-dashboard-new) .ng-finance-dashboard-new > .ng-kpi-grid {
            display: grid !important;
            grid-template-columns: repeat(4, minmax(0, 1fr)) !important;
            gap: 14px !important;
            margin-bottom: 16px !important;
        }

        body:has(.ng-finance-dashboard-new) .ng-finance-dashboard-new > .ng-kpi-grid > .ng-kpi-card {
            height: 106px !important;
            min-height: 106px !important;
            max-height: 106px !important;
            padding: 15px !important;
            border-radius: 22px !important;
            display: flex !important;
            align-items: center !important;
            gap: 12px !important;
        }

        body:has(.ng-finance-dashboard-new) .ng-finance-dashboard-new > .ng-kpi-grid > .ng-kpi-card .ng-kpi-icon {
            width: 42px !important;
            height: 42px !important;
            min-width: 42px !important;
            flex: 0 0 42px !important;
            border-radius: 15px !important;
            font-size: 16px !important;
        }

        body:has(.ng-finance-dashboard-new) .ng-finance-dashboard-new > .ng-kpi-grid > .ng-kpi-card .ng-kpi-content > span {
            font-size: 12px !important;
            line-height: 1.2 !important;
            font-weight: 900 !important;
            color: #6f5946 !important;
        }

        body:has(.ng-finance-dashboard-new) .ng-finance-dashboard-new > .ng-kpi-grid > .ng-kpi-card .ng-kpi-content strong {
            margin-top: 6px !important;
            font-size: 22px !important;
            line-height: 1.05 !important;
            font-weight: 950 !important;
            letter-spacing: -.035em !important;
            white-space: nowrap !important;
            overflow: hidden !important;
            text-overflow: ellipsis !important;
        }

        body:has(.ng-finance-dashboard-new) .ng-finance-dashboard-new > .ng-kpi-grid > .ng-kpi-card .ng-kpi-content p {
            margin-top: 8px !important;
            font-size: 11px !important;
            line-height: 1.18 !important;
            font-weight: 850 !important;
        }

        body:has(.ng-finance-dashboard-new) .ng-finance-dashboard-new > .ng-kpi-grid > .ng-kpi-card .ng-kpi-content p em {
            margin-left: 3px !important;
            font-size: 11px !important;
            line-height: 1.18 !important;
            font-weight: 750 !important;
        }

        /*
        |--------------------------------------------------------------------------
        | VISUAL GRID FORCE - TINGGI IKUT REVENUE PERFORMANCE DASHBOARD UTAMA
        |--------------------------------------------------------------------------
        */

        body:has(.ng-finance-dashboard-new) .ng-finance-dashboard-new > .ng-visual-grid {
            display: grid !important;
            grid-template-columns: repeat(2, minmax(0, 1fr)) !important;
            gap: 16px !important;
            margin-bottom: 16px !important;
            align-items: stretch !important;
        }

        body:has(.ng-finance-dashboard-new) .ng-finance-dashboard-new > .ng-visual-grid > .ng-card {
            height: 354px !important;
            min-height: 354px !important;
            max-height: 354px !important;
            padding: 18px !important;
            border-radius: 24px !important;
            overflow: hidden !important;
        }

        body:has(.ng-finance-dashboard-new) .ng-finance-dashboard-new > .ng-visual-grid .ng-card-head {
            margin-bottom: 8px !important;
        }

        body:has(.ng-finance-dashboard-new) .ng-finance-dashboard-new > .ng-visual-grid .ng-card-head h2 {
            font-size: 17px !important;
            line-height: 1.2 !important;
            font-weight: 950 !important;
            letter-spacing: -.03em !important;
        }

        body:has(.ng-finance-dashboard-new) .ng-finance-dashboard-new > .ng-visual-grid .ng-card-head p {
            margin-top: 5px !important;
            font-size: 11px !important;
            font-weight: 800 !important;
        }

        body:has(.ng-finance-dashboard-new) .ng-chart-responsive {
            height: 258px !important;
            min-height: 258px !important;
            max-height: 258px !important;
            grid-template-columns: 54px minmax(0, 1fr) !important;
        }

        body:has(.ng-finance-dashboard-new) .ng-chart-area {
            height: 258px !important;
            min-height: 258px !important;
            max-height: 258px !important;
            padding-bottom: 30px !important;
            overflow: hidden !important;
        }

        body:has(.ng-finance-dashboard-new) .ng-bars-weekly {
            height: 220px !important;
            min-height: 220px !important;
            max-height: 220px !important;
            grid-template-columns: repeat(var(--bar-count), minmax(24px, 1fr)) !important;
            gap: 9px !important;
        }

        body:has(.ng-finance-dashboard-new) .ng-y-axis {
            height: 258px !important;
            padding: 4px 10px 30px 0 !important;
            font-size: 11px !important;
        }

        body:has(.ng-finance-dashboard-new) .ng-chart-caption {
            margin-top: -3px !important;
            font-size: 11px !important;
            line-height: 1.2 !important;
            font-weight: 850 !important;
        }

        /*
        |--------------------------------------------------------------------------
        | TARGET CARD FORCE - PADAT SEJAJAR DENGAN CHART
        |--------------------------------------------------------------------------
        */

        body:has(.ng-finance-dashboard-new) .ng-target-list {
            display: grid !important;
            gap: 17px !important;
            padding-top: 12px !important;
        }

        body:has(.ng-finance-dashboard-new) .ng-target-row {
            display: grid !important;
            grid-template-columns: 46px minmax(0, 1fr) !important;
            align-items: center !important;
            gap: 14px !important;
        }

        body:has(.ng-finance-dashboard-new) .ng-target-icon {
            width: 46px !important;
            height: 46px !important;
            min-width: 46px !important;
            font-size: 17px !important;
        }

        body:has(.ng-finance-dashboard-new) .ng-target-top {
            display: grid !important;
            grid-template-columns: minmax(0, 1.15fr) minmax(110px, .72fr) 70px !important;
            gap: 10px !important;
            align-items: start !important;
            margin-bottom: 7px !important;
        }

        body:has(.ng-finance-dashboard-new) .ng-target-top strong {
            font-size: 12px !important;
            line-height: 1.15 !important;
            font-weight: 950 !important;
            white-space: nowrap !important;
            overflow: hidden !important;
            text-overflow: ellipsis !important;
        }

        body:has(.ng-finance-dashboard-new) .ng-target-top span {
            margin-top: 3px !important;
            font-size: 11px !important;
            line-height: 1.15 !important;
            font-weight: 800 !important;
        }

        body:has(.ng-finance-dashboard-new) .ng-target-top b {
            font-size: 22px !important;
            line-height: 1 !important;
            font-weight: 950 !important;
            text-align: right !important;
        }

        body:has(.ng-finance-dashboard-new) .ng-target-track {
            height: 10px !important;
        }

        body:has(.ng-finance-dashboard-new) .ng-target-bottom {
            margin-top: 5px !important;
        }

        body:has(.ng-finance-dashboard-new) .ng-target-bottom small {
            font-size: 11px !important;
            line-height: 1.15 !important;
            font-weight: 750 !important;
        }

        /*
        |--------------------------------------------------------------------------
        | DATA BAWAH FORCE - UKURAN SEPERTI LATEST ORDERS DASHBOARD UTAMA
        |--------------------------------------------------------------------------
        */

        body:has(.ng-finance-dashboard-new) .ng-cost-table-card {
            height: 372px !important;
            min-height: 372px !important;
            max-height: 372px !important;
            padding: 18px !important;
            border-radius: 24px !important;
            overflow: hidden !important;
        }

        body:has(.ng-finance-dashboard-new) .ng-table-head {
            margin-bottom: 8px !important;
        }

        body:has(.ng-finance-dashboard-new) .ng-table-head h2 {
            font-size: 17px !important;
            line-height: 1.2 !important;
            font-weight: 950 !important;
            letter-spacing: -.03em !important;
        }

        body:has(.ng-finance-dashboard-new) .ng-table-head p {
            margin-top: 5px !important;
            font-size: 11px !important;
            font-weight: 800 !important;
        }

        body:has(.ng-finance-dashboard-new) .ng-table-actions a {
            min-height: 32px !important;
            height: 32px !important;
            padding: 0 12px !important;
            border-radius: 12px !important;
            font-size: 11px !important;
            font-weight: 950 !important;
        }

        body:has(.ng-finance-dashboard-new) .ng-cost-table-wrap {
            height: 266px !important;
            min-height: 266px !important;
            max-height: 266px !important;
            overflow: auto !important;
        }

        body:has(.ng-finance-dashboard-new) .ng-cost-table {
            width: 100% !important;
            min-width: 720px !important;
            border-collapse: collapse !important;
        }

        body:has(.ng-finance-dashboard-new) .ng-cost-table th {
            padding: 8px 9px !important;
            font-size: 11px !important;
            font-weight: 950 !important;
            line-height: 1.15 !important;
            white-space: nowrap !important;
        }

        body:has(.ng-finance-dashboard-new) .ng-cost-table td {
            padding: 9px !important;
            font-size: 11px !important;
            font-weight: 750 !important;
            line-height: 1.2 !important;
            white-space: nowrap !important;
        }

        body:has(.ng-finance-dashboard-new) .ng-cost-category span {
            width: 28px !important;
            height: 28px !important;
            min-width: 28px !important;
            font-size: 11px !important;
        }

        body:has(.ng-finance-dashboard-new) .ng-cost-category strong {
            max-width: 210px !important;
            font-size: 11px !important;
            white-space: nowrap !important;
            overflow: hidden !important;
            text-overflow: ellipsis !important;
        }

        body:has(.ng-finance-dashboard-new) .ng-cost-type-badge,
        body:has(.ng-finance-dashboard-new) .ng-status-paid {
            min-height: 24px !important;
            padding: 0 8px !important;
            font-size: 10px !important;
            border-radius: 9px !important;
            font-weight: 950 !important;
        }

        body:has(.ng-finance-dashboard-new) .ng-table-footer {
            height: 38px !important;
            min-height: 38px !important;
            padding-top: 8px !important;
            font-size: 11px !important;
        }

        body:has(.ng-finance-dashboard-new) .ng-cost-page-btn,
        body:has(.ng-finance-dashboard-new) .ng-cost-page-number,
        body:has(.ng-finance-dashboard-new) .ng-table-footer button {
            width: 28px !important;
            height: 28px !important;
            min-width: 28px !important;
            font-size: 11px !important;
        }

        @media (max-width: 1500px) {
            body:has(.ng-finance-dashboard-new) .ng-finance-dashboard-new > .ng-kpi-grid {
                grid-template-columns: repeat(2, minmax(0, 1fr)) !important;
            }

            body:has(.ng-finance-dashboard-new) .ng-finance-dashboard-new > .ng-visual-grid {
                grid-template-columns: 1fr !important;
            }

            body:has(.ng-finance-dashboard-new) .ng-finance-dashboard-new > .ng-visual-grid > .ng-card {
                height: auto !important;
                min-height: 354px !important;
                max-height: none !important;
            }
        }

        /*
        |--------------------------------------------------------------------------
        | VISUAL POLISH + INTERACTIVE ANIMATION
        |--------------------------------------------------------------------------
        */

        .ng-chart-responsive {
            grid-template-columns: 72px minmax(0, 1fr) !important;
            min-height: 300px !important;
            align-items: stretch;
        }

        .ng-y-axis {
            height: 280px;
            padding: 0 12px 40px 0 !important;
            display: grid;
            grid-template-rows: repeat(5, minmax(0, 1fr));
            align-items: stretch;
        }

        .ng-y-axis span {
            display: flex;
            align-items: center;
            justify-content: flex-end;
            min-height: 0;
            transform: none !important;
            line-height: 1;
            white-space: nowrap;
        }

        .ng-y-axis span:first-child {
            align-items: flex-start;
            padding-top: 2px;
        }

        .ng-y-axis span:last-child {
            align-items: flex-end;
            padding-bottom: 2px;
        }

        .ng-chart-area,
        .ng-chart-area.ng-chart-area-static {
            overflow: visible !important;
            padding-bottom: 38px !important;
        }

        .ng-grid-lines {
            inset: 10px 0 38px 0 !important;
        }

        .ng-grid-lines i,
        .ng-grid-lines i:last-child {
            border-color: rgba(109, 79, 50, .10) !important;
        }

        .ng-bars,
        .ng-bars-weekly {
            min-width: 100% !important;
            height: 280px !important;
            gap: 18px !important;
            padding: 0 8px !important;
        }

        .ng-bars-weekly .ng-bar-item {
            position: relative;
            padding-top: 78px !important;
            cursor: pointer;
            user-select: none;
        }

        .ng-bar-item {
            outline: none;
        }

        .ng-bars-weekly .ng-bar-wrap {
            align-items: end;
        }

        .ng-bars-weekly .ng-bar-wrap span {
            width: min(100%, 30px) !important;
            height: 0;
            min-height: 0 !important;
            border-radius: 12px 12px 4px 4px !important;
            background: linear-gradient(180deg, #ffa12b, #ff6a00) !important;
            box-shadow: 0 12px 22px rgba(249, 115, 22, .18) !important;
            transition: height .9s cubic-bezier(.22, 1, .36, 1), transform .22s ease, filter .22s ease;
            transform-origin: bottom center;
        }

        .ng-bar-item:hover .ng-bar-wrap span,
        .ng-bar-item:focus-visible .ng-bar-wrap span,
        .ng-bar-item.is-open .ng-bar-wrap span {
            filter: brightness(1.05);
            transform: translateY(-2px);
        }

        .ng-chart-tooltip {
            top: 8px !important;
            min-width: 210px;
            max-width: min(260px, calc(100vw - 40px));
            padding: 16px 18px !important;
            border-radius: 18px !important;
            background: rgba(244, 244, 246, .97) !important;
            box-shadow: 0 18px 46px rgba(77, 51, 22, .18) !important;
            transform: translate(-50%, 8px) !important;
        }

        .ng-chart-tooltip strong {
            color: #747b84 !important;
            font-size: 17px !important;
            font-weight: 950 !important;
            margin-bottom: 12px !important;
        }

        .ng-chart-tooltip-row {
            gap: 8px !important;
            color: #2e2620 !important;
            font-size: 15px !important;
            font-weight: 800 !important;
        }

        .ng-chart-tooltip-row b {
            color: #23170f !important;
            font-size: 16px !important;
            font-weight: 950 !important;
        }

        .ng-chart-tooltip-dot {
            width: 15px !important;
            height: 15px !important;
        }

        .ng-bar-item.is-open .ng-chart-tooltip,
        .ng-bar-item:hover .ng-chart-tooltip,
        .ng-bar-item:focus-visible .ng-chart-tooltip,
        .ng-bar-item:focus-within .ng-chart-tooltip {
            opacity: 1 !important;
            visibility: visible !important;
            transform: translate(-50%, -8px) !important;
        }

        .ng-target-row {
            opacity: .7;
            transform: translateY(10px);
            transition: opacity .45s ease, transform .45s ease;
        }

        .ng-target-row.is-visible {
            opacity: 1;
            transform: translateY(0);
        }

        .ng-target-top b {
            font-size: 17px !important;
            color: #23170f !important;
        }

        .ng-target-top b.negative,
        .ng-target-top b.positive {
            color: #23170f !important;
        }

        .ng-target-track {
            overflow: hidden;
        }

        .ng-target-track i {
            display: block;
            width: 0;
            transition: width .95s cubic-bezier(.22, 1, .36, 1);
        }

        @media (max-width: 960px) {
            .ng-chart-responsive {
                grid-template-columns: 56px minmax(0, 1fr) !important;
            }

            .ng-y-axis {
                height: 248px;
                padding-right: 8px !important;
            }

            .ng-bars,
            .ng-bars-weekly {
                height: 248px !important;
                gap: 12px !important;
            }

            .ng-bars-weekly .ng-bar-item {
                padding-top: 72px !important;
            }

            .ng-chart-tooltip {
                min-width: 186px;
                padding: 14px 16px !important;
            }
        }


    </style>


    <style id="ng-finance-target-percent-sidebar-fix">
        /*
        |--------------------------------------------------------------------------
        | TARGET PERCENT + SIDEBAR RESTORE FIX
        |--------------------------------------------------------------------------
        */

        /* Persentase Progress Target: kecil + hitam, tidak warna-warni */
        body:has(.ng-finance-dashboard-new) .ng-target-top b,
        body:has(.ng-finance-dashboard-new) .ng-target-top b.positive,
        body:has(.ng-finance-dashboard-new) .ng-target-top b.negative,
        body.ng-finance-sidebar-soft .ng-target-top b,
        body.ng-finance-sidebar-soft .ng-target-top b.positive,
        body.ng-finance-sidebar-soft .ng-target-top b.negative {
            color: #21160d !important;
            font-size: 16px !important;
            line-height: 1.05 !important;
            font-weight: 950 !important;
            letter-spacing: -.02em !important;
        }

        body:has(.ng-finance-dashboard-new) .ng-target-top,
        body.ng-finance-sidebar-soft .ng-target-top {
            grid-template-columns: minmax(0, 1.15fr) minmax(110px, .72fr) 52px !important;
        }

        /*
        |--------------------------------------------------------------------------
        | SIDEBAR STYLE BALIK KE MODEL SEBELUMNYA
        |--------------------------------------------------------------------------
        | Active menu dibuat model white pill + teks orange, bukan orange full.
        */

        body:has(.ng-finance-dashboard-new) .fi-sidebar,
        body.ng-finance-sidebar-soft .fi-sidebar {
            background: rgba(255, 250, 242, .50) !important;
            border-right: 1px solid rgba(255, 255, 255, .48) !important;
            box-shadow: 18px 0 55px rgba(137, 78, 26, .10) !important;
            backdrop-filter: blur(16px) !important;
            -webkit-backdrop-filter: blur(16px) !important;
        }

        body:has(.ng-finance-dashboard-new) .fi-sidebar-nav,
        body.ng-finance-sidebar-soft .fi-sidebar-nav {
            padding: 18px 14px !important;
        }

        body:has(.ng-finance-dashboard-new) .fi-sidebar-item a,
        body:has(.ng-finance-dashboard-new) .fi-sidebar-item-button,
        body.ng-finance-sidebar-soft .fi-sidebar-item a,
        body.ng-finance-sidebar-soft .fi-sidebar-item-button {
            border-radius: 14px !important;
            color: #5f4a38 !important;
            background: transparent !important;
            box-shadow: none !important;
            transition: .2s ease !important;
        }

        body:has(.ng-finance-dashboard-new) .fi-sidebar-item-active a,
        body:has(.ng-finance-dashboard-new) .fi-sidebar-item.fi-active a,
        body:has(.ng-finance-dashboard-new) .fi-sidebar-item-active .fi-sidebar-item-button,
        body:has(.ng-finance-dashboard-new) .fi-sidebar-item.fi-active .fi-sidebar-item-button,
        body.ng-finance-sidebar-soft .fi-sidebar-item-active a,
        body.ng-finance-sidebar-soft .fi-sidebar-item.fi-active a,
        body.ng-finance-sidebar-soft .fi-sidebar-item-active .fi-sidebar-item-button,
        body.ng-finance-sidebar-soft .fi-sidebar-item.fi-active .fi-sidebar-item-button {
            background: rgba(255, 255, 255, .86) !important;
            color: #e45f00 !important;
            box-shadow:
                0 12px 28px rgba(144, 79, 22, .08),
                inset 0 1px 0 rgba(255, 255, 255, .70) !important;
        }

        body:has(.ng-finance-dashboard-new) .fi-sidebar-item a:hover,
        body:has(.ng-finance-dashboard-new) .fi-sidebar-item .fi-sidebar-item-button:hover,
        body.ng-finance-sidebar-soft .fi-sidebar-item a:hover,
        body.ng-finance-sidebar-soft .fi-sidebar-item .fi-sidebar-item-button:hover {
            background: rgba(255, 255, 255, .72) !important;
            color: #e45f00 !important;
            box-shadow:
                0 10px 24px rgba(144, 79, 22, .07),
                inset 0 1px 0 rgba(255, 255, 255, .58) !important;
        }

        body:has(.ng-finance-dashboard-new) .fi-sidebar-item-active svg,
        body:has(.ng-finance-dashboard-new) .fi-sidebar-item-active span,
        body:has(.ng-finance-dashboard-new) .fi-sidebar-item-active .fi-sidebar-item-icon,
        body:has(.ng-finance-dashboard-new) .fi-sidebar-item-active .fi-sidebar-item-label,
        body:has(.ng-finance-dashboard-new) .fi-sidebar-item.fi-active svg,
        body:has(.ng-finance-dashboard-new) .fi-sidebar-item.fi-active span,
        body:has(.ng-finance-dashboard-new) .fi-sidebar-item.fi-active .fi-sidebar-item-icon,
        body:has(.ng-finance-dashboard-new) .fi-sidebar-item.fi-active .fi-sidebar-item-label,
        body:has(.ng-finance-dashboard-new) .fi-sidebar-item a:hover svg,
        body:has(.ng-finance-dashboard-new) .fi-sidebar-item a:hover span,
        body:has(.ng-finance-dashboard-new) .fi-sidebar-item .fi-sidebar-item-button:hover .fi-sidebar-item-icon,
        body:has(.ng-finance-dashboard-new) .fi-sidebar-item .fi-sidebar-item-button:hover .fi-sidebar-item-label,
        body.ng-finance-sidebar-soft .fi-sidebar-item-active svg,
        body.ng-finance-sidebar-soft .fi-sidebar-item-active span,
        body.ng-finance-sidebar-soft .fi-sidebar-item-active .fi-sidebar-item-icon,
        body.ng-finance-sidebar-soft .fi-sidebar-item-active .fi-sidebar-item-label,
        body.ng-finance-sidebar-soft .fi-sidebar-item.fi-active svg,
        body.ng-finance-sidebar-soft .fi-sidebar-item.fi-active span,
        body.ng-finance-sidebar-soft .fi-sidebar-item.fi-active .fi-sidebar-item-icon,
        body.ng-finance-sidebar-soft .fi-sidebar-item.fi-active .fi-sidebar-item-label,
        body.ng-finance-sidebar-soft .fi-sidebar-item a:hover svg,
        body.ng-finance-sidebar-soft .fi-sidebar-item a:hover span,
        body.ng-finance-sidebar-soft .fi-sidebar-item .fi-sidebar-item-button:hover .fi-sidebar-item-icon,
        body.ng-finance-sidebar-soft .fi-sidebar-item .fi-sidebar-item-button:hover .fi-sidebar-item-label {
            color: #e45f00 !important;
        }

        /*
        |--------------------------------------------------------------------------
        | VISUAL POLISH + INTERACTIVE ANIMATION
        |--------------------------------------------------------------------------
        */

        .ng-chart-responsive {
            grid-template-columns: 72px minmax(0, 1fr) !important;
            min-height: 300px !important;
            align-items: stretch;
        }

        .ng-y-axis {
            height: 280px;
            padding: 0 12px 40px 0 !important;
            display: grid;
            grid-template-rows: repeat(5, minmax(0, 1fr));
            align-items: stretch;
        }

        .ng-y-axis span {
            display: flex;
            align-items: center;
            justify-content: flex-end;
            min-height: 0;
            transform: none !important;
            line-height: 1;
            white-space: nowrap;
        }

        .ng-y-axis span:first-child {
            align-items: flex-start;
            padding-top: 2px;
        }

        .ng-y-axis span:last-child {
            align-items: flex-end;
            padding-bottom: 2px;
        }

        .ng-chart-area,
        .ng-chart-area.ng-chart-area-static {
            overflow: visible !important;
            padding-bottom: 38px !important;
        }

        .ng-grid-lines {
            inset: 10px 0 38px 0 !important;
        }

        .ng-grid-lines i,
        .ng-grid-lines i:last-child {
            border-color: rgba(109, 79, 50, .10) !important;
        }

        .ng-bars,
        .ng-bars-weekly {
            min-width: 100% !important;
            height: 280px !important;
            gap: 18px !important;
            padding: 0 8px !important;
        }

        .ng-bars-weekly .ng-bar-item {
            position: relative;
            padding-top: 78px !important;
            cursor: pointer;
            user-select: none;
        }

        .ng-bar-item {
            outline: none;
        }

        .ng-bars-weekly .ng-bar-wrap {
            align-items: end;
        }

        .ng-bars-weekly .ng-bar-wrap span {
            width: min(100%, 30px) !important;
            height: 0;
            min-height: 0 !important;
            border-radius: 12px 12px 4px 4px !important;
            background: linear-gradient(180deg, #ffa12b, #ff6a00) !important;
            box-shadow: 0 12px 22px rgba(249, 115, 22, .18) !important;
            transition: height .9s cubic-bezier(.22, 1, .36, 1), transform .22s ease, filter .22s ease;
            transform-origin: bottom center;
        }

        .ng-bar-item:hover .ng-bar-wrap span,
        .ng-bar-item:focus-visible .ng-bar-wrap span,
        .ng-bar-item.is-open .ng-bar-wrap span {
            filter: brightness(1.05);
            transform: translateY(-2px);
        }

        .ng-chart-tooltip {
            top: 8px !important;
            min-width: 210px;
            max-width: min(260px, calc(100vw - 40px));
            padding: 16px 18px !important;
            border-radius: 18px !important;
            background: rgba(244, 244, 246, .97) !important;
            box-shadow: 0 18px 46px rgba(77, 51, 22, .18) !important;
            transform: translate(-50%, 8px) !important;
        }

        .ng-chart-tooltip strong {
            color: #747b84 !important;
            font-size: 17px !important;
            font-weight: 950 !important;
            margin-bottom: 12px !important;
        }

        .ng-chart-tooltip-row {
            gap: 8px !important;
            color: #2e2620 !important;
            font-size: 15px !important;
            font-weight: 800 !important;
        }

        .ng-chart-tooltip-row b {
            color: #23170f !important;
            font-size: 16px !important;
            font-weight: 950 !important;
        }

        .ng-chart-tooltip-dot {
            width: 15px !important;
            height: 15px !important;
        }

        .ng-bar-item.is-open .ng-chart-tooltip,
        .ng-bar-item:hover .ng-chart-tooltip,
        .ng-bar-item:focus-visible .ng-chart-tooltip,
        .ng-bar-item:focus-within .ng-chart-tooltip {
            opacity: 1 !important;
            visibility: visible !important;
            transform: translate(-50%, -8px) !important;
        }

        .ng-target-row {
            opacity: .7;
            transform: translateY(10px);
            transition: opacity .45s ease, transform .45s ease;
        }

        .ng-target-row.is-visible {
            opacity: 1;
            transform: translateY(0);
        }

        .ng-target-top b {
            font-size: 17px !important;
            color: #23170f !important;
        }

        .ng-target-top b.negative,
        .ng-target-top b.positive {
            color: #23170f !important;
        }

        .ng-target-track {
            overflow: hidden;
        }

        .ng-target-track i {
            display: block;
            width: 0;
            transition: width .95s cubic-bezier(.22, 1, .36, 1);
        }

        @media (max-width: 960px) {
            .ng-chart-responsive {
                grid-template-columns: 56px minmax(0, 1fr) !important;
            }

            .ng-y-axis {
                height: 248px;
                padding-right: 8px !important;
            }

            .ng-bars,
            .ng-bars-weekly {
                height: 248px !important;
                gap: 12px !important;
            }

            .ng-bars-weekly .ng-bar-item {
                padding-top: 72px !important;
            }

            .ng-chart-tooltip {
                min-width: 186px;
                padding: 14px 16px !important;
            }
        }


    </style>

    <script>
        (function () {
            function syncFinanceSoftSidebar() {
                document.body.classList.add('ng-finance-sidebar-soft');
            }

            document.addEventListener('DOMContentLoaded', syncFinanceSoftSidebar);
            document.addEventListener('livewire:navigated', syncFinanceSoftSidebar);
            document.addEventListener('livewire:update', syncFinanceSoftSidebar);
            syncFinanceSoftSidebar();
        })();
    </script>


    <style id="ng-finance-cost-table-pagination-fix">
        /*
        |--------------------------------------------------------------------------
        | COST TABLE CLEAN LAYOUT
        |--------------------------------------------------------------------------
        | Kolom Nominal Input sudah dihapus dari markup.
        | Style ini merapikan tabel dan pagination agar center.
        */

        body:has(.ng-finance-dashboard-new) .ng-cost-table {
            width: 100% !important;
            min-width: 640px !important;
            table-layout: fixed !important;
        }

        body:has(.ng-finance-dashboard-new) .ng-cost-table th,
        body:has(.ng-finance-dashboard-new) .ng-cost-table td {
            vertical-align: middle !important;
        }

        body:has(.ng-finance-dashboard-new) .ng-cost-table th:nth-child(1),
        body:has(.ng-finance-dashboard-new) .ng-cost-table td:nth-child(1) {
            width: 24% !important;
        }

        body:has(.ng-finance-dashboard-new) .ng-cost-table th:nth-child(2),
        body:has(.ng-finance-dashboard-new) .ng-cost-table td:nth-child(2) {
            width: 15% !important;
        }

        body:has(.ng-finance-dashboard-new) .ng-cost-table th:nth-child(3),
        body:has(.ng-finance-dashboard-new) .ng-cost-table td:nth-child(3) {
            width: 14% !important;
        }

        body:has(.ng-finance-dashboard-new) .ng-cost-table th:nth-child(4),
        body:has(.ng-finance-dashboard-new) .ng-cost-table td:nth-child(4) {
            width: 15% !important;
        }

        body:has(.ng-finance-dashboard-new) .ng-cost-table th:nth-child(5),
        body:has(.ng-finance-dashboard-new) .ng-cost-table td:nth-child(5) {
            width: 22% !important;
        }

        body:has(.ng-finance-dashboard-new) .ng-cost-table th:nth-child(6),
        body:has(.ng-finance-dashboard-new) .ng-cost-table td:nth-child(6) {
            width: 10% !important;
            text-align: center !important;
        }

        body:has(.ng-finance-dashboard-new) .ng-cost-table th:nth-child(5),
        body:has(.ng-finance-dashboard-new) .ng-cost-table td:nth-child(5) {
            text-align: left !important;
        }

        body:has(.ng-finance-dashboard-new) .ng-cost-table-wrap {
            padding-bottom: 0 !important;
        }

        body:has(.ng-finance-dashboard-new) .ng-table-footer {
            width: 100% !important;
            display: flex !important;
            align-items: center !important;
            justify-content: center !important;
            gap: 16px !important;
            padding-top: 10px !important;
            margin-top: 0 !important;
            text-align: center !important;
        }

        body:has(.ng-finance-dashboard-new) .ng-cost-page-info {
            display: inline-flex !important;
            align-items: center !important;
            justify-content: center !important;
            min-width: 92px !important;
            color: #6f5946 !important;
            font-size: 12px !important;
            font-weight: 850 !important;
            white-space: nowrap !important;
        }

        body:has(.ng-finance-dashboard-new) .ng-cost-pagination {
            display: inline-flex !important;
            align-items: center !important;
            justify-content: center !important;
            gap: 8px !important;
            margin: 0 !important;
        }

        body:has(.ng-finance-dashboard-new) .ng-cost-page-btn,
        body:has(.ng-finance-dashboard-new) .ng-cost-page-number {
            display: inline-grid !important;
            place-items: center !important;
            width: 32px !important;
            height: 32px !important;
            min-width: 32px !important;
            border-radius: 999px !important;
        }

        body:has(.ng-finance-dashboard-new) .ng-cost-page-number.is-active {
            color: #fff !important;
            background: linear-gradient(135deg, #ff9500, #f26a00) !important;
            box-shadow: 0 10px 20px rgba(242, 106, 0, .22) !important;
        }

        @media (max-width: 900px) {
            body:has(.ng-finance-dashboard-new) .ng-table-footer {
                flex-direction: column !important;
                gap: 8px !important;
            }
        }

        /*
        |--------------------------------------------------------------------------
        | VISUAL POLISH + INTERACTIVE ANIMATION
        |--------------------------------------------------------------------------
        */

        .ng-chart-responsive {
            grid-template-columns: 72px minmax(0, 1fr) !important;
            min-height: 300px !important;
            align-items: stretch;
        }

        .ng-y-axis {
            height: 280px;
            padding: 0 12px 40px 0 !important;
            display: grid;
            grid-template-rows: repeat(5, minmax(0, 1fr));
            align-items: stretch;
        }

        .ng-y-axis span {
            display: flex;
            align-items: center;
            justify-content: flex-end;
            min-height: 0;
            transform: none !important;
            line-height: 1;
            white-space: nowrap;
        }

        .ng-y-axis span:first-child {
            align-items: flex-start;
            padding-top: 2px;
        }

        .ng-y-axis span:last-child {
            align-items: flex-end;
            padding-bottom: 2px;
        }

        .ng-chart-area,
        .ng-chart-area.ng-chart-area-static {
            overflow: visible !important;
            padding-bottom: 38px !important;
        }

        .ng-grid-lines {
            inset: 10px 0 38px 0 !important;
        }

        .ng-grid-lines i,
        .ng-grid-lines i:last-child {
            border-color: rgba(109, 79, 50, .10) !important;
        }

        .ng-bars,
        .ng-bars-weekly {
            min-width: 100% !important;
            height: 280px !important;
            gap: 18px !important;
            padding: 0 8px !important;
        }

        .ng-bars-weekly .ng-bar-item {
            position: relative;
            padding-top: 78px !important;
            cursor: pointer;
            user-select: none;
        }

        .ng-bar-item {
            outline: none;
        }

        .ng-bars-weekly .ng-bar-wrap {
            align-items: end;
        }

        .ng-bars-weekly .ng-bar-wrap span {
            width: min(100%, 30px) !important;
            height: 0;
            min-height: 0 !important;
            border-radius: 12px 12px 4px 4px !important;
            background: linear-gradient(180deg, #ffa12b, #ff6a00) !important;
            box-shadow: 0 12px 22px rgba(249, 115, 22, .18) !important;
            transition: height .9s cubic-bezier(.22, 1, .36, 1), transform .22s ease, filter .22s ease;
            transform-origin: bottom center;
        }

        .ng-bar-item:hover .ng-bar-wrap span,
        .ng-bar-item:focus-visible .ng-bar-wrap span,
        .ng-bar-item.is-open .ng-bar-wrap span {
            filter: brightness(1.05);
            transform: translateY(-2px);
        }

        .ng-chart-tooltip {
            top: 8px !important;
            min-width: 210px;
            max-width: min(260px, calc(100vw - 40px));
            padding: 16px 18px !important;
            border-radius: 18px !important;
            background: rgba(244, 244, 246, .97) !important;
            box-shadow: 0 18px 46px rgba(77, 51, 22, .18) !important;
            transform: translate(-50%, 8px) !important;
        }

        .ng-chart-tooltip strong {
            color: #747b84 !important;
            font-size: 17px !important;
            font-weight: 950 !important;
            margin-bottom: 12px !important;
        }

        .ng-chart-tooltip-row {
            gap: 8px !important;
            color: #2e2620 !important;
            font-size: 15px !important;
            font-weight: 800 !important;
        }

        .ng-chart-tooltip-row b {
            color: #23170f !important;
            font-size: 16px !important;
            font-weight: 950 !important;
        }

        .ng-chart-tooltip-dot {
            width: 15px !important;
            height: 15px !important;
        }

        .ng-bar-item.is-open .ng-chart-tooltip,
        .ng-bar-item:hover .ng-chart-tooltip,
        .ng-bar-item:focus-visible .ng-chart-tooltip,
        .ng-bar-item:focus-within .ng-chart-tooltip {
            opacity: 1 !important;
            visibility: visible !important;
            transform: translate(-50%, -8px) !important;
        }

        .ng-target-row {
            opacity: .7;
            transform: translateY(10px);
            transition: opacity .45s ease, transform .45s ease;
        }

        .ng-target-row.is-visible {
            opacity: 1;
            transform: translateY(0);
        }

        .ng-target-top b {
            font-size: 17px !important;
            color: #23170f !important;
        }

        .ng-target-top b.negative,
        .ng-target-top b.positive {
            color: #23170f !important;
        }

        .ng-target-track {
            overflow: hidden;
        }

        .ng-target-track i {
            display: block;
            width: 0;
            transition: width .95s cubic-bezier(.22, 1, .36, 1);
        }

        @media (max-width: 960px) {
            .ng-chart-responsive {
                grid-template-columns: 56px minmax(0, 1fr) !important;
            }

            .ng-y-axis {
                height: 248px;
                padding-right: 8px !important;
            }

            .ng-bars,
            .ng-bars-weekly {
                height: 248px !important;
                gap: 12px !important;
            }

            .ng-bars-weekly .ng-bar-item {
                padding-top: 72px !important;
            }

            .ng-chart-tooltip {
                min-width: 186px;
                padding: 14px 16px !important;
            }
        }


    </style>


    <style id="ng-finance-cost-nav-center-only">
        /*
        |--------------------------------------------------------------------------
        | COST TABLE PAGINATION CENTER ONLY
        |--------------------------------------------------------------------------
        | Hilangkan info 1-5 dan angka halaman.
        | Navigasi hanya tombol < > dan posisinya center tengah.
        */

        body:has(.ng-finance-dashboard-new) .ng-table-footer {
            position: relative !important;
            width: 100% !important;
            height: 42px !important;
            min-height: 42px !important;
            display: flex !important;
            align-items: center !important;
            justify-content: center !important;
            padding: 8px 0 0 !important;
            margin: 0 !important;
            text-align: center !important;
        }

        body:has(.ng-finance-dashboard-new) .ng-cost-page-info,
        body:has(.ng-finance-dashboard-new) .ng-cost-page-number {
            display: none !important;
            width: 0 !important;
            height: 0 !important;
            min-width: 0 !important;
            margin: 0 !important;
            padding: 0 !important;
            opacity: 0 !important;
            pointer-events: none !important;
        }

        body:has(.ng-finance-dashboard-new) .ng-cost-pagination {
            position: absolute !important;
            left: 50% !important;
            top: 50% !important;
            transform: translate(-50%, -42%) !important;
            display: inline-flex !important;
            align-items: center !important;
            justify-content: center !important;
            gap: 12px !important;
            margin: 0 !important;
            padding: 0 !important;
            width: auto !important;
            min-width: 0 !important;
        }

        body:has(.ng-finance-dashboard-new) .ng-cost-page-btn,
        body:has(.ng-finance-dashboard-new) .ng-cost-pagination button {
            display: inline-grid !important;
            place-items: center !important;
            width: 34px !important;
            height: 34px !important;
            min-width: 34px !important;
            max-width: 34px !important;
            border: 0 !important;
            border-radius: 999px !important;
            background: rgba(255, 255, 255, .58) !important;
            color: #9b6a43 !important;
            font-size: 19px !important;
            line-height: 1 !important;
            font-weight: 950 !important;
            box-shadow:
                0 10px 22px rgba(120, 74, 30, .08),
                inset 0 1px 0 rgba(255, 255, 255, .58) !important;
            cursor: pointer !important;
        }

        body:has(.ng-finance-dashboard-new) .ng-cost-page-btn:not(.is-disabled):hover,
        body:has(.ng-finance-dashboard-new) .ng-cost-pagination button:not(.is-disabled):hover {
            color: #fff !important;
            background: linear-gradient(135deg, #ff9500, #f26a00) !important;
            box-shadow: 0 10px 20px rgba(242, 106, 0, .22) !important;
        }

        body:has(.ng-finance-dashboard-new) .ng-cost-page-btn.is-disabled {
            opacity: .45 !important;
            cursor: default !important;
            pointer-events: none !important;
        }

        /*
        |--------------------------------------------------------------------------
        | VISUAL POLISH + INTERACTIVE ANIMATION
        |--------------------------------------------------------------------------
        */

        .ng-chart-responsive {
            grid-template-columns: 72px minmax(0, 1fr) !important;
            min-height: 300px !important;
            align-items: stretch;
        }

        .ng-y-axis {
            height: 280px;
            padding: 0 12px 40px 0 !important;
            display: grid;
            grid-template-rows: repeat(5, minmax(0, 1fr));
            align-items: stretch;
        }

        .ng-y-axis span {
            display: flex;
            align-items: center;
            justify-content: flex-end;
            min-height: 0;
            transform: none !important;
            line-height: 1;
            white-space: nowrap;
        }

        .ng-y-axis span:first-child {
            align-items: flex-start;
            padding-top: 2px;
        }

        .ng-y-axis span:last-child {
            align-items: flex-end;
            padding-bottom: 2px;
        }

        .ng-chart-area,
        .ng-chart-area.ng-chart-area-static {
            overflow: visible !important;
            padding-bottom: 38px !important;
        }

        .ng-grid-lines {
            inset: 10px 0 38px 0 !important;
        }

        .ng-grid-lines i,
        .ng-grid-lines i:last-child {
            border-color: rgba(109, 79, 50, .10) !important;
        }

        .ng-bars,
        .ng-bars-weekly {
            min-width: 100% !important;
            height: 280px !important;
            gap: 18px !important;
            padding: 0 8px !important;
        }

        .ng-bars-weekly .ng-bar-item {
            position: relative;
            padding-top: 78px !important;
            cursor: pointer;
            user-select: none;
        }

        .ng-bar-item {
            outline: none;
        }

        .ng-bars-weekly .ng-bar-wrap {
            align-items: end;
        }

        .ng-bars-weekly .ng-bar-wrap span {
            width: min(100%, 30px) !important;
            height: 0;
            min-height: 0 !important;
            border-radius: 12px 12px 4px 4px !important;
            background: linear-gradient(180deg, #ffa12b, #ff6a00) !important;
            box-shadow: 0 12px 22px rgba(249, 115, 22, .18) !important;
            transition: height .9s cubic-bezier(.22, 1, .36, 1), transform .22s ease, filter .22s ease;
            transform-origin: bottom center;
        }

        .ng-bar-item:hover .ng-bar-wrap span,
        .ng-bar-item:focus-visible .ng-bar-wrap span,
        .ng-bar-item.is-open .ng-bar-wrap span {
            filter: brightness(1.05);
            transform: translateY(-2px);
        }

        .ng-chart-tooltip {
            top: 8px !important;
            min-width: 210px;
            max-width: min(260px, calc(100vw - 40px));
            padding: 16px 18px !important;
            border-radius: 18px !important;
            background: rgba(244, 244, 246, .97) !important;
            box-shadow: 0 18px 46px rgba(77, 51, 22, .18) !important;
            transform: translate(-50%, 8px) !important;
        }

        .ng-chart-tooltip strong {
            color: #747b84 !important;
            font-size: 17px !important;
            font-weight: 950 !important;
            margin-bottom: 12px !important;
        }

        .ng-chart-tooltip-row {
            gap: 8px !important;
            color: #2e2620 !important;
            font-size: 15px !important;
            font-weight: 800 !important;
        }

        .ng-chart-tooltip-row b {
            color: #23170f !important;
            font-size: 16px !important;
            font-weight: 950 !important;
        }

        .ng-chart-tooltip-dot {
            width: 15px !important;
            height: 15px !important;
        }

        .ng-bar-item.is-open .ng-chart-tooltip,
        .ng-bar-item:hover .ng-chart-tooltip,
        .ng-bar-item:focus-visible .ng-chart-tooltip,
        .ng-bar-item:focus-within .ng-chart-tooltip {
            opacity: 1 !important;
            visibility: visible !important;
            transform: translate(-50%, -8px) !important;
        }

        .ng-target-row {
            opacity: .7;
            transform: translateY(10px);
            transition: opacity .45s ease, transform .45s ease;
        }

        .ng-target-row.is-visible {
            opacity: 1;
            transform: translateY(0);
        }

        .ng-target-top b {
            font-size: 17px !important;
            color: #23170f !important;
        }

        .ng-target-top b.negative,
        .ng-target-top b.positive {
            color: #23170f !important;
        }

        .ng-target-track {
            overflow: hidden;
        }

        .ng-target-track i {
            display: block;
            width: 0;
            transition: width .95s cubic-bezier(.22, 1, .36, 1);
        }

        @media (max-width: 960px) {
            .ng-chart-responsive {
                grid-template-columns: 56px minmax(0, 1fr) !important;
            }

            .ng-y-axis {
                height: 248px;
                padding-right: 8px !important;
            }

            .ng-bars,
            .ng-bars-weekly {
                height: 248px !important;
                gap: 12px !important;
            }

            .ng-bars-weekly .ng-bar-item {
                padding-top: 72px !important;
            }

            .ng-chart-tooltip {
                min-width: 186px;
                padding: 14px 16px !important;
            }
        }


    </style>


    <script>
        (function () {
            function setupCostOnlyArrows() {
                const footer = document.querySelector('.ng-table-footer[data-total-pages]');
                if (! footer) {
                    return;
                }

                const totalPages = Math.max(1, parseInt(footer.dataset.totalPages || '1', 10));
                let currentPage = Math.max(1, parseInt(footer.dataset.currentPage || '1', 10));

                const rows = Array.from(document.querySelectorAll('.ng-cost-page-row[data-cost-page]'));
                const prev = footer.querySelector('[data-cost-prev]');
                const next = footer.querySelector('[data-cost-next]');

                function applyPage(page) {
                    currentPage = Math.max(1, Math.min(totalPages, page));
                    footer.dataset.currentPage = String(currentPage);

                    rows.forEach((row) => {
                        row.classList.toggle('is-active', parseInt(row.dataset.costPage || '1', 10) === currentPage);
                    });

                    if (prev) {
                        prev.classList.toggle('is-disabled', currentPage <= 1);
                    }

                    if (next) {
                        next.classList.toggle('is-disabled', currentPage >= totalPages);
                    }
                }

                if (prev && ! prev.dataset.onlyArrowBound) {
                    prev.dataset.onlyArrowBound = '1';
                    prev.addEventListener('click', function () {
                        if (currentPage > 1) {
                            applyPage(currentPage - 1);
                        }
                    });
                }

                if (next && ! next.dataset.onlyArrowBound) {
                    next.dataset.onlyArrowBound = '1';
                    next.addEventListener('click', function () {
                        if (currentPage < totalPages) {
                            applyPage(currentPage + 1);
                        }
                    });
                }

                applyPage(currentPage);
            }

            document.addEventListener('DOMContentLoaded', setupCostOnlyArrows);
            document.addEventListener('livewire:navigated', setupCostOnlyArrows);
            document.addEventListener('livewire:update', setupCostOnlyArrows);
            setupCostOnlyArrows();
        })();
    </script>


    <style id="ng-finance-cost-pagination-beautify">
        /*
        |--------------------------------------------------------------------------
        | COST PAGINATION BEAUTIFY
        |--------------------------------------------------------------------------
        | Navigasi tetap hanya < >, tapi tampilannya dibuat lebih clean.
        */

        body:has(.ng-finance-dashboard-new) .ng-table-footer {
            position: relative !important;
            width: 100% !important;
            height: 44px !important;
            min-height: 44px !important;
            display: flex !important;
            align-items: center !important;
            justify-content: center !important;
            padding: 8px 0 0 !important;
            margin: 0 !important;
        }

        body:has(.ng-finance-dashboard-new) .ng-cost-pagination {
            position: absolute !important;
            left: 50% !important;
            top: 50% !important;
            transform: translate(-50%, -42%) !important;
            display: inline-flex !important;
            align-items: center !important;
            justify-content: center !important;
            gap: 6px !important;
            width: auto !important;
            min-width: 92px !important;
            height: 38px !important;
            padding: 4px !important;
            margin: 0 !important;
            border-radius: 999px !important;
            border: 1px solid rgba(255, 255, 255, .58) !important;
            background:
                linear-gradient(145deg, rgba(255, 255, 255, .58), rgba(255, 246, 231, .28)) !important;
            box-shadow:
                0 14px 32px rgba(120, 74, 30, .10),
                inset 0 1px 0 rgba(255, 255, 255, .68) !important;
            backdrop-filter: blur(14px) !important;
            -webkit-backdrop-filter: blur(14px) !important;
        }

        body:has(.ng-finance-dashboard-new) .ng-cost-page-info,
        body:has(.ng-finance-dashboard-new) .ng-cost-page-number {
            display: none !important;
        }

        body:has(.ng-finance-dashboard-new) .ng-cost-page-btn,
        body:has(.ng-finance-dashboard-new) .ng-cost-pagination button {
            display: inline-grid !important;
            place-items: center !important;
            width: 30px !important;
            height: 30px !important;
            min-width: 30px !important;
            max-width: 30px !important;
            padding: 0 !important;
            border: 0 !important;
            border-radius: 999px !important;
            color: #d95d00 !important;
            background: rgba(255, 255, 255, .50) !important;
            font-size: 18px !important;
            line-height: 1 !important;
            font-weight: 950 !important;
            box-shadow: inset 0 1px 0 rgba(255, 255, 255, .55) !important;
            cursor: pointer !important;
            transition: transform .18s ease, box-shadow .18s ease, background .18s ease, color .18s ease, opacity .18s ease !important;
        }

        body:has(.ng-finance-dashboard-new) .ng-cost-page-btn:not(.is-disabled):hover,
        body:has(.ng-finance-dashboard-new) .ng-cost-pagination button:not(.is-disabled):hover {
            color: #fff !important;
            background: linear-gradient(135deg, #ff9500, #f26a00) !important;
            box-shadow: 0 10px 20px rgba(242, 106, 0, .22) !important;
            transform: translateY(-1px) !important;
        }

        body:has(.ng-finance-dashboard-new) .ng-cost-page-btn:not(.is-disabled):active,
        body:has(.ng-finance-dashboard-new) .ng-cost-pagination button:not(.is-disabled):active {
            transform: translateY(0) scale(.96) !important;
        }

        body:has(.ng-finance-dashboard-new) .ng-cost-page-btn.is-disabled {
            opacity: .38 !important;
            color: #b99778 !important;
            background: rgba(255, 255, 255, .34) !important;
            cursor: default !important;
            pointer-events: none !important;
            box-shadow: none !important;
        }

        body:has(.ng-finance-dashboard-new) .ng-cost-page-btn[data-cost-prev]::before {
            content: "‹" !important;
        }

        body:has(.ng-finance-dashboard-new) .ng-cost-page-btn[data-cost-next]::before {
            content: "›" !important;
        }

        body:has(.ng-finance-dashboard-new) .ng-cost-page-btn[data-cost-prev],
        body:has(.ng-finance-dashboard-new) .ng-cost-page-btn[data-cost-next] {
            font-size: 0 !important;
        }

        body:has(.ng-finance-dashboard-new) .ng-cost-page-btn[data-cost-prev]::before,
        body:has(.ng-finance-dashboard-new) .ng-cost-page-btn[data-cost-next]::before {
            display: block !important;
            font-size: 22px !important;
            line-height: .85 !important;
            font-weight: 950 !important;
            transform: translateY(-1px) !important;
        }

        /*
        |--------------------------------------------------------------------------
        | VISUAL POLISH + INTERACTIVE ANIMATION
        |--------------------------------------------------------------------------
        */

        .ng-chart-responsive {
            grid-template-columns: 72px minmax(0, 1fr) !important;
            min-height: 300px !important;
            align-items: stretch;
        }

        .ng-y-axis {
            height: 280px;
            padding: 0 12px 40px 0 !important;
            display: grid;
            grid-template-rows: repeat(5, minmax(0, 1fr));
            align-items: stretch;
        }

        .ng-y-axis span {
            display: flex;
            align-items: center;
            justify-content: flex-end;
            min-height: 0;
            transform: none !important;
            line-height: 1;
            white-space: nowrap;
        }

        .ng-y-axis span:first-child {
            align-items: flex-start;
            padding-top: 2px;
        }

        .ng-y-axis span:last-child {
            align-items: flex-end;
            padding-bottom: 2px;
        }

        .ng-chart-area,
        .ng-chart-area.ng-chart-area-static {
            overflow: visible !important;
            padding-bottom: 38px !important;
        }

        .ng-grid-lines {
            inset: 10px 0 38px 0 !important;
        }

        .ng-grid-lines i,
        .ng-grid-lines i:last-child {
            border-color: rgba(109, 79, 50, .10) !important;
        }

        .ng-bars,
        .ng-bars-weekly {
            min-width: 100% !important;
            height: 280px !important;
            gap: 18px !important;
            padding: 0 8px !important;
        }

        .ng-bars-weekly .ng-bar-item {
            position: relative;
            padding-top: 78px !important;
            cursor: pointer;
            user-select: none;
        }

        .ng-bar-item {
            outline: none;
        }

        .ng-bars-weekly .ng-bar-wrap {
            align-items: end;
        }

        .ng-bars-weekly .ng-bar-wrap span {
            width: min(100%, 30px) !important;
            height: 0;
            min-height: 0 !important;
            border-radius: 12px 12px 4px 4px !important;
            background: linear-gradient(180deg, #ffa12b, #ff6a00) !important;
            box-shadow: 0 12px 22px rgba(249, 115, 22, .18) !important;
            transition: height .9s cubic-bezier(.22, 1, .36, 1), transform .22s ease, filter .22s ease;
            transform-origin: bottom center;
        }

        .ng-bar-item:hover .ng-bar-wrap span,
        .ng-bar-item:focus-visible .ng-bar-wrap span,
        .ng-bar-item.is-open .ng-bar-wrap span {
            filter: brightness(1.05);
            transform: translateY(-2px);
        }

        .ng-chart-tooltip {
            top: 8px !important;
            min-width: 210px;
            max-width: min(260px, calc(100vw - 40px));
            padding: 16px 18px !important;
            border-radius: 18px !important;
            background: rgba(244, 244, 246, .97) !important;
            box-shadow: 0 18px 46px rgba(77, 51, 22, .18) !important;
            transform: translate(-50%, 8px) !important;
        }

        .ng-chart-tooltip strong {
            color: #747b84 !important;
            font-size: 17px !important;
            font-weight: 950 !important;
            margin-bottom: 12px !important;
        }

        .ng-chart-tooltip-row {
            gap: 8px !important;
            color: #2e2620 !important;
            font-size: 15px !important;
            font-weight: 800 !important;
        }

        .ng-chart-tooltip-row b {
            color: #23170f !important;
            font-size: 16px !important;
            font-weight: 950 !important;
        }

        .ng-chart-tooltip-dot {
            width: 15px !important;
            height: 15px !important;
        }

        .ng-bar-item.is-open .ng-chart-tooltip,
        .ng-bar-item:hover .ng-chart-tooltip,
        .ng-bar-item:focus-visible .ng-chart-tooltip,
        .ng-bar-item:focus-within .ng-chart-tooltip {
            opacity: 1 !important;
            visibility: visible !important;
            transform: translate(-50%, -8px) !important;
        }

        .ng-target-row {
            opacity: .7;
            transform: translateY(10px);
            transition: opacity .45s ease, transform .45s ease;
        }

        .ng-target-row.is-visible {
            opacity: 1;
            transform: translateY(0);
        }

        .ng-target-top b {
            font-size: 17px !important;
            color: #23170f !important;
        }

        .ng-target-top b.negative,
        .ng-target-top b.positive {
            color: #23170f !important;
        }

        .ng-target-track {
            overflow: hidden;
        }

        .ng-target-track i {
            display: block;
            width: 0;
            transition: width .95s cubic-bezier(.22, 1, .36, 1);
        }

        @media (max-width: 960px) {
            .ng-chart-responsive {
                grid-template-columns: 56px minmax(0, 1fr) !important;
            }

            .ng-y-axis {
                height: 248px;
                padding-right: 8px !important;
            }

            .ng-bars,
            .ng-bars-weekly {
                height: 248px !important;
                gap: 12px !important;
            }

            .ng-bars-weekly .ng-bar-item {
                padding-top: 72px !important;
            }

            .ng-chart-tooltip {
                min-width: 186px;
                padding: 14px 16px !important;
            }
        }


    </style>


    <style id="ng-finance-cost-table-taller-next-right">
        /*
        |--------------------------------------------------------------------------
        | COST TABLE TALLER + NEXT BUTTON RIGHT
        |--------------------------------------------------------------------------
        */

        /* Widget bawah dipanjangkan sedikit */
        body:has(.ng-finance-dashboard-new) .ng-cost-table-card {
            height: 420px !important;
            min-height: 420px !important;
            max-height: 420px !important;
            padding-bottom: 58px !important;
            position: relative !important;
        }

        body:has(.ng-finance-dashboard-new) .ng-cost-table-wrap {
            height: 306px !important;
            min-height: 306px !important;
            max-height: 306px !important;
            overflow: auto !important;
            padding-bottom: 4px !important;
        }

        /* Footer pagination pindah ke pojok kanan bawah */
        body:has(.ng-finance-dashboard-new) .ng-table-footer {
            position: absolute !important;
            right: 26px !important;
            bottom: 14px !important;
            width: auto !important;
            height: auto !important;
            min-height: 0 !important;
            display: flex !important;
            align-items: center !important;
            justify-content: flex-end !important;
            padding: 0 !important;
            margin: 0 !important;
            z-index: 10 !important;
        }

        body:has(.ng-finance-dashboard-new) .ng-cost-pagination {
            position: static !important;
            transform: none !important;
            display: inline-flex !important;
            align-items: center !important;
            justify-content: flex-end !important;
            gap: 8px !important;
            width: auto !important;
            min-width: 0 !important;
            height: auto !important;
            padding: 0 !important;
            margin: 0 !important;
            border: 0 !important;
            background: transparent !important;
            box-shadow: none !important;
            backdrop-filter: none !important;
            -webkit-backdrop-filter: none !important;
        }

        body:has(.ng-finance-dashboard-new) .ng-cost-page-info,
        body:has(.ng-finance-dashboard-new) .ng-cost-page-number {
            display: none !important;
        }

        /* Tombol dibuat text pill simple */
        body:has(.ng-finance-dashboard-new) .ng-cost-page-btn,
        body:has(.ng-finance-dashboard-new) .ng-cost-pagination button {
            width: auto !important;
            min-width: 78px !important;
            max-width: none !important;
            height: 34px !important;
            min-height: 34px !important;
            padding: 0 16px !important;
            border: 1px solid rgba(255, 255, 255, .56) !important;
            border-radius: 999px !important;
            background: rgba(255, 255, 255, .52) !important;
            color: #d95d00 !important;
            box-shadow:
                0 12px 26px rgba(120, 74, 30, .10),
                inset 0 1px 0 rgba(255, 255, 255, .68) !important;
            font-size: 0 !important;
            line-height: 1 !important;
            font-weight: 950 !important;
            letter-spacing: .01em !important;
            cursor: pointer !important;
            transition: transform .18s ease, box-shadow .18s ease, background .18s ease, color .18s ease, opacity .18s ease !important;
        }

        body:has(.ng-finance-dashboard-new) .ng-cost-page-btn[data-cost-prev]::before {
            content: "Prev" !important;
        }

        body:has(.ng-finance-dashboard-new) .ng-cost-page-btn[data-cost-next]::before {
            content: "Next" !important;
        }

        body:has(.ng-finance-dashboard-new) .ng-cost-page-btn[data-cost-prev]::before,
        body:has(.ng-finance-dashboard-new) .ng-cost-page-btn[data-cost-next]::before {
            display: block !important;
            font-size: 12px !important;
            line-height: 1 !important;
            font-weight: 950 !important;
            transform: none !important;
        }

        body:has(.ng-finance-dashboard-new) .ng-cost-page-btn:not(.is-disabled):hover,
        body:has(.ng-finance-dashboard-new) .ng-cost-pagination button:not(.is-disabled):hover {
            color: #fff !important;
            background: linear-gradient(135deg, #ff9500, #f26a00) !important;
            border-color: rgba(255, 255, 255, .44) !important;
            box-shadow: 0 14px 24px rgba(242, 106, 0, .24) !important;
            transform: translateY(-1px) !important;
        }

        body:has(.ng-finance-dashboard-new) .ng-cost-page-btn:not(.is-disabled):active {
            transform: translateY(0) scale(.98) !important;
        }

        body:has(.ng-finance-dashboard-new) .ng-cost-page-btn.is-disabled {
            opacity: .42 !important;
            color: #a78566 !important;
            background: rgba(255, 255, 255, .32) !important;
            cursor: default !important;
            pointer-events: none !important;
            box-shadow: inset 0 1px 0 rgba(255, 255, 255, .42) !important;
        }

        /*
        |--------------------------------------------------------------------------
        | VISUAL POLISH + INTERACTIVE ANIMATION
        |--------------------------------------------------------------------------
        */

        .ng-chart-responsive {
            grid-template-columns: 72px minmax(0, 1fr) !important;
            min-height: 300px !important;
            align-items: stretch;
        }

        .ng-y-axis {
            height: 280px;
            padding: 0 12px 40px 0 !important;
            display: grid;
            grid-template-rows: repeat(5, minmax(0, 1fr));
            align-items: stretch;
        }

        .ng-y-axis span {
            display: flex;
            align-items: center;
            justify-content: flex-end;
            min-height: 0;
            transform: none !important;
            line-height: 1;
            white-space: nowrap;
        }

        .ng-y-axis span:first-child {
            align-items: flex-start;
            padding-top: 2px;
        }

        .ng-y-axis span:last-child {
            align-items: flex-end;
            padding-bottom: 2px;
        }

        .ng-chart-area,
        .ng-chart-area.ng-chart-area-static {
            overflow: visible !important;
            padding-bottom: 38px !important;
        }

        .ng-grid-lines {
            inset: 10px 0 38px 0 !important;
        }

        .ng-grid-lines i,
        .ng-grid-lines i:last-child {
            border-color: rgba(109, 79, 50, .10) !important;
        }

        .ng-bars,
        .ng-bars-weekly {
            min-width: 100% !important;
            height: 280px !important;
            gap: 18px !important;
            padding: 0 8px !important;
        }

        .ng-bars-weekly .ng-bar-item {
            position: relative;
            padding-top: 78px !important;
            cursor: pointer;
            user-select: none;
        }

        .ng-bar-item {
            outline: none;
        }

        .ng-bars-weekly .ng-bar-wrap {
            align-items: end;
        }

        .ng-bars-weekly .ng-bar-wrap span {
            width: min(100%, 30px) !important;
            height: 0;
            min-height: 0 !important;
            border-radius: 12px 12px 4px 4px !important;
            background: linear-gradient(180deg, #ffa12b, #ff6a00) !important;
            box-shadow: 0 12px 22px rgba(249, 115, 22, .18) !important;
            transition: height .9s cubic-bezier(.22, 1, .36, 1), transform .22s ease, filter .22s ease;
            transform-origin: bottom center;
        }

        .ng-bar-item:hover .ng-bar-wrap span,
        .ng-bar-item:focus-visible .ng-bar-wrap span,
        .ng-bar-item.is-open .ng-bar-wrap span {
            filter: brightness(1.05);
            transform: translateY(-2px);
        }

        .ng-chart-tooltip {
            top: 8px !important;
            min-width: 210px;
            max-width: min(260px, calc(100vw - 40px));
            padding: 16px 18px !important;
            border-radius: 18px !important;
            background: rgba(244, 244, 246, .97) !important;
            box-shadow: 0 18px 46px rgba(77, 51, 22, .18) !important;
            transform: translate(-50%, 8px) !important;
        }

        .ng-chart-tooltip strong {
            color: #747b84 !important;
            font-size: 17px !important;
            font-weight: 950 !important;
            margin-bottom: 12px !important;
        }

        .ng-chart-tooltip-row {
            gap: 8px !important;
            color: #2e2620 !important;
            font-size: 15px !important;
            font-weight: 800 !important;
        }

        .ng-chart-tooltip-row b {
            color: #23170f !important;
            font-size: 16px !important;
            font-weight: 950 !important;
        }

        .ng-chart-tooltip-dot {
            width: 15px !important;
            height: 15px !important;
        }

        .ng-bar-item.is-open .ng-chart-tooltip,
        .ng-bar-item:hover .ng-chart-tooltip,
        .ng-bar-item:focus-visible .ng-chart-tooltip,
        .ng-bar-item:focus-within .ng-chart-tooltip {
            opacity: 1 !important;
            visibility: visible !important;
            transform: translate(-50%, -8px) !important;
        }

        .ng-target-row {
            opacity: .7;
            transform: translateY(10px);
            transition: opacity .45s ease, transform .45s ease;
        }

        .ng-target-row.is-visible {
            opacity: 1;
            transform: translateY(0);
        }

        .ng-target-top b {
            font-size: 17px !important;
            color: #23170f !important;
        }

        .ng-target-top b.negative,
        .ng-target-top b.positive {
            color: #23170f !important;
        }

        .ng-target-track {
            overflow: hidden;
        }

        .ng-target-track i {
            display: block;
            width: 0;
            transition: width .95s cubic-bezier(.22, 1, .36, 1);
        }

        @media (max-width: 960px) {
            .ng-chart-responsive {
                grid-template-columns: 56px minmax(0, 1fr) !important;
            }

            .ng-y-axis {
                height: 248px;
                padding-right: 8px !important;
            }

            .ng-bars,
            .ng-bars-weekly {
                height: 248px !important;
                gap: 12px !important;
            }

            .ng-bars-weekly .ng-bar-item {
                padding-top: 72px !important;
            }

            .ng-chart-tooltip {
                min-width: 186px;
                padding: 14px 16px !important;
            }
        }


    </style>


    <style id="ng-finance-cost-next-compact">
        /*
        |--------------------------------------------------------------------------
        | COST TABLE NEXT BUTTON COMPACT
        |--------------------------------------------------------------------------
        | Ukuran widget bawah tetap seperti versi sebelumnya.
        | Tombol Prev/Next diperkecil, teks dibuat center rapi.
        */

        body:has(.ng-finance-dashboard-new) .ng-table-footer {
            right: 26px !important;
            bottom: 16px !important;
        }

        body:has(.ng-finance-dashboard-new) .ng-cost-pagination {
            gap: 7px !important;
        }

        body:has(.ng-finance-dashboard-new) .ng-cost-page-btn,
        body:has(.ng-finance-dashboard-new) .ng-cost-pagination button {
            display: inline-flex !important;
            align-items: center !important;
            justify-content: center !important;
            width: auto !important;
            min-width: 54px !important;
            max-width: 58px !important;
            height: 30px !important;
            min-height: 30px !important;
            max-height: 30px !important;
            padding: 0 11px !important;
            border-radius: 999px !important;
            font-size: 0 !important;
            line-height: 1 !important;
            text-align: center !important;
            white-space: nowrap !important;
            box-shadow:
                0 9px 18px rgba(120, 74, 30, .08),
                inset 0 1px 0 rgba(255, 255, 255, .62) !important;
        }

        body:has(.ng-finance-dashboard-new) .ng-cost-page-btn[data-cost-prev]::before {
            content: "Prev" !important;
        }

        body:has(.ng-finance-dashboard-new) .ng-cost-page-btn[data-cost-next]::before {
            content: "Next" !important;
        }

        body:has(.ng-finance-dashboard-new) .ng-cost-page-btn[data-cost-prev]::before,
        body:has(.ng-finance-dashboard-new) .ng-cost-page-btn[data-cost-next]::before {
            display: inline-flex !important;
            align-items: center !important;
            justify-content: center !important;
            width: 100% !important;
            height: 100% !important;
            font-size: 12px !important;
            line-height: 1 !important;
            font-weight: 950 !important;
            letter-spacing: 0 !important;
            transform: translateY(0) !important;
            text-align: center !important;
        }

        body:has(.ng-finance-dashboard-new) .ng-cost-page-btn:not(.is-disabled):hover {
            transform: translateY(-1px) !important;
        }

        body:has(.ng-finance-dashboard-new) .ng-cost-page-btn:not(.is-disabled):active {
            transform: translateY(0) scale(.98) !important;
        }

        /*
        |--------------------------------------------------------------------------
        | VISUAL POLISH + INTERACTIVE ANIMATION
        |--------------------------------------------------------------------------
        */

        .ng-chart-responsive {
            grid-template-columns: 72px minmax(0, 1fr) !important;
            min-height: 300px !important;
            align-items: stretch;
        }

        .ng-y-axis {
            height: 280px;
            padding: 0 12px 40px 0 !important;
            display: grid;
            grid-template-rows: repeat(5, minmax(0, 1fr));
            align-items: stretch;
        }

        .ng-y-axis span {
            display: flex;
            align-items: center;
            justify-content: flex-end;
            min-height: 0;
            transform: none !important;
            line-height: 1;
            white-space: nowrap;
        }

        .ng-y-axis span:first-child {
            align-items: flex-start;
            padding-top: 2px;
        }

        .ng-y-axis span:last-child {
            align-items: flex-end;
            padding-bottom: 2px;
        }

        .ng-chart-area,
        .ng-chart-area.ng-chart-area-static {
            overflow: visible !important;
            padding-bottom: 38px !important;
        }

        .ng-grid-lines {
            inset: 10px 0 38px 0 !important;
        }

        .ng-grid-lines i,
        .ng-grid-lines i:last-child {
            border-color: rgba(109, 79, 50, .10) !important;
        }

        .ng-bars,
        .ng-bars-weekly {
            min-width: 100% !important;
            height: 280px !important;
            gap: 18px !important;
            padding: 0 8px !important;
        }

        .ng-bars-weekly .ng-bar-item {
            position: relative;
            padding-top: 78px !important;
            cursor: pointer;
            user-select: none;
        }

        .ng-bar-item {
            outline: none;
        }

        .ng-bars-weekly .ng-bar-wrap {
            align-items: end;
        }

        .ng-bars-weekly .ng-bar-wrap span {
            width: min(100%, 30px) !important;
            height: 0;
            min-height: 0 !important;
            border-radius: 12px 12px 4px 4px !important;
            background: linear-gradient(180deg, #ffa12b, #ff6a00) !important;
            box-shadow: 0 12px 22px rgba(249, 115, 22, .18) !important;
            transition: height .9s cubic-bezier(.22, 1, .36, 1), transform .22s ease, filter .22s ease;
            transform-origin: bottom center;
        }

        .ng-bar-item:hover .ng-bar-wrap span,
        .ng-bar-item:focus-visible .ng-bar-wrap span,
        .ng-bar-item.is-open .ng-bar-wrap span {
            filter: brightness(1.05);
            transform: translateY(-2px);
        }

        .ng-chart-tooltip {
            top: 8px !important;
            min-width: 210px;
            max-width: min(260px, calc(100vw - 40px));
            padding: 16px 18px !important;
            border-radius: 18px !important;
            background: rgba(244, 244, 246, .97) !important;
            box-shadow: 0 18px 46px rgba(77, 51, 22, .18) !important;
            transform: translate(-50%, 8px) !important;
        }

        .ng-chart-tooltip strong {
            color: #747b84 !important;
            font-size: 17px !important;
            font-weight: 950 !important;
            margin-bottom: 12px !important;
        }

        .ng-chart-tooltip-row {
            gap: 8px !important;
            color: #2e2620 !important;
            font-size: 15px !important;
            font-weight: 800 !important;
        }

        .ng-chart-tooltip-row b {
            color: #23170f !important;
            font-size: 16px !important;
            font-weight: 950 !important;
        }

        .ng-chart-tooltip-dot {
            width: 15px !important;
            height: 15px !important;
        }

        .ng-bar-item.is-open .ng-chart-tooltip,
        .ng-bar-item:hover .ng-chart-tooltip,
        .ng-bar-item:focus-visible .ng-chart-tooltip,
        .ng-bar-item:focus-within .ng-chart-tooltip {
            opacity: 1 !important;
            visibility: visible !important;
            transform: translate(-50%, -8px) !important;
        }

        .ng-target-row {
            opacity: .7;
            transform: translateY(10px);
            transition: opacity .45s ease, transform .45s ease;
        }

        .ng-target-row.is-visible {
            opacity: 1;
            transform: translateY(0);
        }

        .ng-target-top b {
            font-size: 17px !important;
            color: #23170f !important;
        }

        .ng-target-top b.negative,
        .ng-target-top b.positive {
            color: #23170f !important;
        }

        .ng-target-track {
            overflow: hidden;
        }

        .ng-target-track i {
            display: block;
            width: 0;
            transition: width .95s cubic-bezier(.22, 1, .36, 1);
        }

        @media (max-width: 960px) {
            .ng-chart-responsive {
                grid-template-columns: 56px minmax(0, 1fr) !important;
            }

            .ng-y-axis {
                height: 248px;
                padding-right: 8px !important;
            }

            .ng-bars,
            .ng-bars-weekly {
                height: 248px !important;
                gap: 12px !important;
            }

            .ng-bars-weekly .ng-bar-item {
                padding-top: 72px !important;
            }

            .ng-chart-tooltip {
                min-width: 186px;
                padding: 14px 16px !important;
            }
        }


    </style>
<script>
        (function () {
            function initFinanceChartFinal() {
                const card = document.querySelector('.ng-revenue-card');
                const tooltip = document.querySelector('[data-chart-click-tooltip]');
                const bars = Array.from(document.querySelectorAll('.ng-revenue-card .ng-bar-item'));

                if (! card || ! tooltip || ! bars.length) {
                    return;
                }

                const title = tooltip.querySelector('[data-chart-tooltip-title]');
                const value = tooltip.querySelector('[data-chart-tooltip-value]');

                function closeTooltip() {
                    tooltip.classList.remove('is-visible');
                    bars.forEach((bar) => bar.classList.remove('is-active-tooltip'));
                }

                function positionTooltip(bar) {
                    const cardRect = card.getBoundingClientRect();
                    const barRect = bar.getBoundingClientRect();

                    let left = (barRect.left + (barRect.width / 2)) - cardRect.left;
                    let top = barRect.top - cardRect.top + 6;

                    left = Math.max(115, Math.min(left, cardRect.width - 115));
                    top = Math.max(116, top);

                    tooltip.style.left = left + 'px';
                    tooltip.style.top = top + 'px';
                }

                bars.forEach((bar) => {
                    const span = bar.querySelector('.ng-bar-wrap span[data-bar-height]');

                    if (span) {
                        span.style.height = '0%';
                    }

                    if (bar.dataset.finalChartBound === '1') {
                        return;
                    }

                    bar.dataset.finalChartBound = '1';

                    bar.addEventListener('click', function (event) {
                        event.preventDefault();
                        event.stopPropagation();

                        const willOpen = ! bar.classList.contains('is-active-tooltip');

                        closeTooltip();

                        if (! willOpen) {
                            return;
                        }

                        if (title) {
                            title.textContent = bar.dataset.tooltipLabel || '-';
                        }

                        if (value) {
                            value.textContent = bar.dataset.tooltipValue || '-';
                        }

                        bar.classList.add('is-active-tooltip');
                        positionTooltip(bar);
                        tooltip.classList.add('is-visible');
                    });

                    bar.addEventListener('keydown', function (event) {
                        if (event.key === 'Enter' || event.key === ' ') {
                            event.preventDefault();
                            bar.click();
                        }

                        if (event.key === 'Escape') {
                            closeTooltip();
                        }
                    });
                });

                requestAnimationFrame(() => {
                    bars.forEach((bar, index) => {
                        const span = bar.querySelector('.ng-bar-wrap span[data-bar-height]');
                        if (! span) {
                            return;
                        }

                        const targetHeight = Number(span.dataset.barHeight || 0);

                        window.setTimeout(() => {
                            span.style.height = Math.max(0, Math.min(100, targetHeight)) + '%';
                        }, 120 + (index * 90));
                    });

                    document.querySelectorAll('.ng-target-card .ng-target-row').forEach((row, index) => {
                        row.classList.remove('is-visible');
                        window.setTimeout(() => row.classList.add('is-visible'), 100 + (index * 120));
                    });

                    document.querySelectorAll('.ng-target-card .ng-target-track i[data-target-width]').forEach((bar, index) => {
                        const width = Number(bar.dataset.targetWidth || 0);
                        bar.style.width = '0%';
                        window.setTimeout(() => {
                            bar.style.width = Math.max(0, Math.min(100, width)) + '%';
                        }, 180 + (index * 140));
                    });
                });

                if (document.documentElement.dataset.ngFinalChartClickBound !== '1') {
                    document.documentElement.dataset.ngFinalChartClickBound = '1';

                    document.addEventListener('click', function (event) {
                        if (! event.target.closest('.ng-revenue-card')) {
                            closeTooltip();
                        }
                    });

                    window.addEventListener('resize', closeTooltip);
                }
            }

            document.addEventListener('DOMContentLoaded', initFinanceChartFinal);
            document.addEventListener('livewire:navigated', initFinanceChartFinal);
            document.addEventListener('livewire:update', initFinanceChartFinal);
            initFinanceChartFinal();
        })();
    </script>

    <style id="ng-finance-tooltip-clean-position-fix">
        /*
        |--------------------------------------------------------------------------
        | CLEAN TOOLTIP POSITION + ACCURATE CHART SCALE
        |--------------------------------------------------------------------------
        */

        body:has(.ng-finance-dashboard-new) .ng-revenue-card {
            position: relative !important;
            overflow: visible !important;
        }

        body:has(.ng-finance-dashboard-new) .ng-revenue-card .ng-chart-tooltip,
        body:has(.ng-finance-dashboard-new) .ng-revenue-card .ng-chart-tooltip-row,
        body:has(.ng-finance-dashboard-new) .ng-revenue-card .ng-chart-tooltip-dot {
            display: none !important;
            visibility: hidden !important;
            opacity: 0 !important;
            pointer-events: none !important;
        }

        body:has(.ng-finance-dashboard-new) .ng-chart-responsive {
            --plot-height: 244px;
            display: grid !important;
            grid-template-columns: 78px minmax(0, 1fr) !important;
            align-items: start !important;
            min-height: 298px !important;
            height: 298px !important;
        }

        body:has(.ng-finance-dashboard-new) .ng-y-axis {
            position: relative !important;
            display: block !important;
            height: var(--plot-height) !important;
            min-height: var(--plot-height) !important;
            padding: 0 16px 0 0 !important;
            margin: 0 !important;
            text-align: right !important;
        }

        body:has(.ng-finance-dashboard-new) .ng-y-axis span {
            position: absolute !important;
            right: 16px !important;
            display: block !important;
            min-width: 58px !important;
            color: #6f5946 !important;
            font-size: 12px !important;
            line-height: 1 !important;
            font-weight: 850 !important;
            text-align: right !important;
            white-space: nowrap !important;
            transform: translateY(-50%) !important;
        }

        body:has(.ng-finance-dashboard-new) .ng-y-axis span:nth-child(1) {
            top: 0 !important;
            transform: translateY(0) !important;
        }

        body:has(.ng-finance-dashboard-new) .ng-y-axis span:nth-child(2) {
            top: 25% !important;
        }

        body:has(.ng-finance-dashboard-new) .ng-y-axis span:nth-child(3) {
            top: 50% !important;
        }

        body:has(.ng-finance-dashboard-new) .ng-y-axis span:nth-child(4) {
            top: 75% !important;
        }

        body:has(.ng-finance-dashboard-new) .ng-y-axis span:nth-child(5) {
            top: 100% !important;
            transform: translateY(-100%) !important;
        }

        body:has(.ng-finance-dashboard-new) .ng-chart-area,
        body:has(.ng-finance-dashboard-new) .ng-chart-area.ng-chart-area-static {
            position: relative !important;
            height: calc(var(--plot-height) + 34px) !important;
            min-height: calc(var(--plot-height) + 34px) !important;
            max-height: calc(var(--plot-height) + 34px) !important;
            overflow: visible !important;
            padding: 0 !important;
        }

        body:has(.ng-finance-dashboard-new) .ng-grid-lines {
            position: absolute !important;
            inset: 0 0 auto 0 !important;
            width: 100% !important;
            height: var(--plot-height) !important;
            display: block !important;
            pointer-events: none !important;
        }

        body:has(.ng-finance-dashboard-new) .ng-grid-lines i {
            position: absolute !important;
            left: 0 !important;
            right: 0 !important;
            display: block !important;
            height: 0 !important;
            border-top: 1px solid rgba(109, 79, 50, .105) !important;
            border-bottom: 0 !important;
        }

        body:has(.ng-finance-dashboard-new) .ng-grid-lines i:nth-child(1) {
            top: 0 !important;
        }

        body:has(.ng-finance-dashboard-new) .ng-grid-lines i:nth-child(2) {
            top: 25% !important;
        }

        body:has(.ng-finance-dashboard-new) .ng-grid-lines i:nth-child(3) {
            top: 50% !important;
        }

        body:has(.ng-finance-dashboard-new) .ng-grid-lines i:nth-child(4) {
            top: 75% !important;
        }

        body:has(.ng-finance-dashboard-new) .ng-grid-lines i:nth-child(5) {
            top: 100% !important;
        }

        body:has(.ng-finance-dashboard-new) .ng-grid-lines i:last-child {
            border-bottom: 0 !important;
        }

        body:has(.ng-finance-dashboard-new) .ng-bars,
        body:has(.ng-finance-dashboard-new) .ng-bars-weekly {
            position: relative !important;
            z-index: 2 !important;
            display: grid !important;
            grid-template-columns: repeat(var(--bar-count), minmax(42px, 1fr)) !important;
            align-items: start !important;
            gap: 18px !important;
            width: 100% !important;
            min-width: 100% !important;
            height: calc(var(--plot-height) + 34px) !important;
            min-height: calc(var(--plot-height) + 34px) !important;
            max-height: calc(var(--plot-height) + 34px) !important;
            padding: 0 8px !important;
            margin: 0 !important;
        }

        body:has(.ng-finance-dashboard-new) .ng-bars-weekly .ng-bar-item,
        body:has(.ng-finance-dashboard-new) .ng-bar-item {
            position: relative !important;
            display: grid !important;
            grid-template-rows: var(--plot-height) 34px !important;
            align-items: end !important;
            gap: 0 !important;
            height: calc(var(--plot-height) + 34px) !important;
            min-height: calc(var(--plot-height) + 34px) !important;
            padding: 0 !important;
            cursor: pointer !important;
            outline: none !important;
        }

        body:has(.ng-finance-dashboard-new) .ng-bar-wrap {
            width: 100% !important;
            height: var(--plot-height) !important;
            min-height: var(--plot-height) !important;
            display: flex !important;
            align-items: flex-end !important;
            justify-content: center !important;
        }

        body:has(.ng-finance-dashboard-new) .ng-bars-weekly .ng-bar-wrap span,
        body:has(.ng-finance-dashboard-new) .ng-bar-wrap span {
            display: block !important;
            width: 32px !important;
            height: 0;
            min-height: 0 !important;
            max-height: var(--plot-height) !important;
            border-radius: 14px 14px 4px 4px !important;
            background: linear-gradient(180deg, #ffa12b, #ff6a00) !important;
            box-shadow: 0 12px 22px rgba(249, 115, 22, .18) !important;
            transform-origin: bottom center !important;
            transition:
                height .85s cubic-bezier(.22, 1, .36, 1),
                transform .18s ease,
                filter .18s ease !important;
        }

        body:has(.ng-finance-dashboard-new) .ng-bar-item:hover .ng-bar-wrap span,
        body:has(.ng-finance-dashboard-new) .ng-bar-item.is-hover-tooltip .ng-bar-wrap span,
        body:has(.ng-finance-dashboard-new) .ng-bar-item:focus-visible .ng-bar-wrap span {
            filter: brightness(1.06) !important;
            transform: translateY(-2px) !important;
        }

        body:has(.ng-finance-dashboard-new) .ng-bar-item small {
            display: flex !important;
            align-items: center !important;
            justify-content: center !important;
            height: 34px !important;
            color: #6f5946 !important;
            font-size: 11px !important;
            line-height: 1 !important;
            font-weight: 850 !important;
            text-align: center !important;
            white-space: nowrap !important;
        }

        body:has(.ng-finance-dashboard-new) .ng-chart-caption {
            margin-top: -6px !important;
            position: relative !important;
            z-index: 2 !important;
        }

        body:has(.ng-finance-dashboard-new) .ng-active-chart-tooltip {
            position: fixed !important;
            z-index: 99999 !important;
            left: 0 !important;
            top: 0 !important;
            min-width: 190px !important;
            max-width: 260px !important;
            padding: 12px 14px !important;
            border-radius: 16px !important;
            border: 1px solid rgba(255, 255, 255, .80) !important;
            background: rgba(245, 245, 246, .97) !important;
            box-shadow: 0 18px 42px rgba(77, 51, 22, .18) !important;
            opacity: 0 !important;
            visibility: hidden !important;
            pointer-events: none !important;
            transform: translate3d(0, 0, 0) scale(.98) !important;
            transition: opacity .12s ease, transform .12s ease, visibility .12s ease !important;
            backdrop-filter: blur(12px) !important;
            -webkit-backdrop-filter: blur(12px) !important;
        }

        body:has(.ng-finance-dashboard-new) .ng-active-chart-tooltip::after {
            display: none !important;
        }

        body:has(.ng-finance-dashboard-new) .ng-active-chart-tooltip.is-visible {
            opacity: 1 !important;
            visibility: visible !important;
            transform: translate3d(0, 0, 0) scale(1) !important;
        }

        body:has(.ng-finance-dashboard-new) .ng-active-chart-tooltip strong {
            display: block !important;
            margin-bottom: 10px !important;
            color: #747b84 !important;
            font-size: 14px !important;
            line-height: 1.25 !important;
            font-weight: 950 !important;
        }

        body:has(.ng-finance-dashboard-new) .ng-active-chart-tooltip-row {
            display: flex !important;
            align-items: center !important;
            gap: 8px !important;
            color: #2e2620 !important;
            font-size: 13px !important;
            font-weight: 800 !important;
            white-space: nowrap !important;
        }

        body:has(.ng-finance-dashboard-new) .ng-active-chart-tooltip-row span {
            width: 13px !important;
            height: 13px !important;
            border-radius: 999px !important;
            background: #f97316 !important;
            box-shadow: 0 5px 10px rgba(249, 115, 22, .24) !important;
            flex: 0 0 13px !important;
        }

        body:has(.ng-finance-dashboard-new) .ng-active-chart-tooltip-row em {
            font-style: normal !important;
            font-weight: 800 !important;
        }

        body:has(.ng-finance-dashboard-new) .ng-active-chart-tooltip-row b {
            color: #23170f !important;
            font-size: 14px !important;
            font-weight: 950 !important;
        }
    </style>


    <script id="ng-finance-tooltip-clean-position-fix">
        (function () {
            function initCleanFinanceTooltip() {
                const tooltip = document.querySelector('[data-chart-click-tooltip]');
                const bars = Array.from(document.querySelectorAll('.ng-revenue-card .ng-bar-item'));

                if (!tooltip || !bars.length) {
                    return;
                }

                const title = tooltip.querySelector('[data-chart-tooltip-title]');
                const value = tooltip.querySelector('[data-chart-tooltip-value]');

                function moveTooltip(event) {
                    const tooltipWidth = tooltip.offsetWidth || 220;
                    const tooltipHeight = tooltip.offsetHeight || 84;
                    const gap = 18;

                    let left = event.clientX + gap;
                    let top = event.clientY + gap;

                    if (left + tooltipWidth + 14 > window.innerWidth) {
                        left = event.clientX - tooltipWidth - gap;
                    }

                    if (top + tooltipHeight + 14 > window.innerHeight) {
                        top = event.clientY - tooltipHeight - gap;
                    }

                    if (left < 14) {
                        left = 14;
                    }

                    if (top < 14) {
                        top = 14;
                    }

                    tooltip.style.left = left + 'px';
                    tooltip.style.top = top + 'px';
                }

                function showTooltip(bar, event) {
                    if (title) {
                        title.textContent = bar.dataset.tooltipLabel || '-';
                    }

                    if (value) {
                        value.textContent = bar.dataset.tooltipValue || '-';
                    }

                    bars.forEach((item) => item.classList.remove('is-hover-tooltip'));
                    bar.classList.add('is-hover-tooltip');

                    moveTooltip(event);
                    tooltip.classList.add('is-visible');
                }

                function closeTooltip() {
                    tooltip.classList.remove('is-visible');
                    bars.forEach((bar) => bar.classList.remove('is-hover-tooltip'));
                }

                bars.forEach((bar) => {
                    const span = bar.querySelector('.ng-bar-wrap span[data-bar-height]');

                    if (span) {
                        span.style.height = '0%';
                    }

                    if (bar.dataset.cleanTooltipBound === '1') {
                        return;
                    }

                    bar.dataset.cleanTooltipBound = '1';

                    bar.addEventListener('mouseenter', function (event) {
                        showTooltip(bar, event);
                    });

                    bar.addEventListener('mousemove', function (event) {
                        if (tooltip.classList.contains('is-visible')) {
                            moveTooltip(event);
                        }
                    });

                    bar.addEventListener('mouseleave', closeTooltip);

                    bar.addEventListener('focus', function () {
                        const rect = bar.getBoundingClientRect();

                        showTooltip(bar, {
                            clientX: rect.left + rect.width + 10,
                            clientY: rect.top + 20,
                        });
                    });

                    bar.addEventListener('blur', closeTooltip);
                });

                requestAnimationFrame(function () {
                    bars.forEach((bar, index) => {
                        const span = bar.querySelector('.ng-bar-wrap span[data-bar-height]');
                        if (!span) {
                            return;
                        }

                        const height = Math.max(0, Math.min(100, Number(span.dataset.barHeight || 0)));

                        window.setTimeout(function () {
                            span.style.height = height + '%';
                        }, 110 + (index * 90));
                    });
                });
            }

            document.addEventListener('DOMContentLoaded', initCleanFinanceTooltip);
            document.addEventListener('livewire:navigated', initCleanFinanceTooltip);
            document.addEventListener('livewire:update', initCleanFinanceTooltip);
            initCleanFinanceTooltip();
        })();
    </script>

</x-filament-panels::page>
