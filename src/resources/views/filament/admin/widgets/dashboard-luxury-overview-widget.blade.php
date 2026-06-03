<x-filament-widgets::widget>
    <style>
        .dashboard-lux-wrapper {
            --primary: #0f766e;
            --primary-light: #14b8a6;
            --emerald: #10b981;
            --dark: #0f172a;
            --muted: #64748b;
            --border: #e2e8f0;
            --soft: #f8fafc;
            margin-bottom: 22px;
        }

        .dashboard-lux-hero {
            position: relative;
            overflow: hidden;
            border-radius: 30px;
            padding: 32px;
            color: white;
            background:
                radial-gradient(circle at top right, rgba(255,255,255,0.32), transparent 28%),
                radial-gradient(circle at bottom left, rgba(255,255,255,0.18), transparent 28%),
                linear-gradient(135deg, #0f766e 0%, #0d9488 45%, #10b981 100%);
            box-shadow: 0 28px 70px rgba(15, 118, 110, 0.22);
            isolation: isolate;
        }

        .dashboard-lux-hero::before {
            content: "";
            position: absolute;
            inset: 0;
            background-image:
                linear-gradient(rgba(255,255,255,0.09) 1px, transparent 1px),
                linear-gradient(90deg, rgba(255,255,255,0.09) 1px, transparent 1px);
            background-size: 34px 34px;
            opacity: 0.24;
            z-index: -1;
        }

        .dashboard-lux-hero-top {
            display: flex;
            align-items: flex-start;
            justify-content: space-between;
            gap: 24px;
        }

        .dashboard-lux-badge {
            display: inline-flex;
            align-items: center;
            gap: 9px;
            width: fit-content;
            padding: 9px 14px;
            border-radius: 999px;
            background: rgba(255,255,255,0.16);
            border: 1px solid rgba(255,255,255,0.25);
            backdrop-filter: blur(10px);
            font-size: 12px;
            font-weight: 800;
            letter-spacing: 0.12em;
            text-transform: uppercase;
        }

        .dashboard-lux-dot {
            width: 9px;
            height: 9px;
            border-radius: 999px;
            background: #bbf7d0;
            box-shadow: 0 0 0 5px rgba(187,247,208,0.22);
        }

        .dashboard-lux-title {
            margin: 16px 0 0;
            font-size: 36px;
            line-height: 1.08;
            font-weight: 950;
            letter-spacing: -0.04em;
        }

        .dashboard-lux-desc {
            margin: 12px 0 0;
            max-width: 800px;
            color: rgba(255,255,255,0.86);
            font-size: 14px;
            line-height: 1.7;
        }

        .dashboard-lux-mini {
            min-width: 260px;
            border-radius: 22px;
            padding: 18px;
            background: rgba(255,255,255,0.16);
            border: 1px solid rgba(255,255,255,0.24);
            backdrop-filter: blur(12px);
        }

        .dashboard-lux-mini span {
            display: block;
            color: rgba(255,255,255,0.78);
            font-size: 12px;
            font-weight: 700;
        }

        .dashboard-lux-mini strong {
            display: block;
            margin-top: 8px;
            color: white;
            font-size: 30px;
            line-height: 1;
            font-weight: 950;
        }

        .dashboard-period-filter {
            display: flex;
            flex-wrap: wrap;
            gap: 10px;
            margin-top: 20px;
        }

        .dashboard-period-link {
            display: inline-flex;
            align-items: center;
            justify-content: center;
            min-height: 38px;
            padding: 9px 15px;
            border-radius: 999px;
            color: white;
            font-size: 12px;
            font-weight: 850;
            text-decoration: none;
            background: rgba(255,255,255,0.14);
            border: 1px solid rgba(255,255,255,0.24);
            transition: 0.2s ease;
        }

        .dashboard-period-link:hover {
            background: rgba(255,255,255,0.22);
        }

        .dashboard-period-link.active {
            color: #0f766e;
            background: white;
            border-color: white;
            box-shadow: 0 14px 30px rgba(15,23,42,0.16);
        }

        .dashboard-lux-main-row {
            display: grid;
            grid-template-columns: minmax(0, 1fr) minmax(520px, 620px);
            gap: 18px;
            margin-top: 20px;
            align-items: stretch;
        }

        .dashboard-lux-grid {
            display: grid;
            grid-template-columns: repeat(4, minmax(0, 1fr));
            gap: 16px;
        }

        .dashboard-lux-card {
            position: relative;
            overflow: hidden;
            border-radius: 24px;
            padding: 20px;
            background: white;
            border: 1px solid rgba(226,232,240,0.95);
            box-shadow: 0 16px 40px rgba(15,23,42,0.07);
            min-height: 150px;
            transition: 0.25s ease;
        }

        .dashboard-lux-card:hover {
            transform: translateY(-4px);
            box-shadow: 0 24px 55px rgba(15,23,42,0.12);
        }

        .dashboard-lux-card::after {
            content: "";
            position: absolute;
            width: 118px;
            height: 118px;
            top: -52px;
            right: -42px;
            border-radius: 999px;
            opacity: 0.15;
        }

        .dashboard-lux-card.orders::after { background: #3b82f6; }
        .dashboard-lux-card.units::after { background: #f97316; }
        .dashboard-lux-card.product::after { background: #8b5cf6; }
        .dashboard-lux-card.stock::after { background: #ef4444; }

        .dashboard-lux-label {
            margin: 0;
            color: #64748b;
            font-size: 13px;
            font-weight: 850;
        }

        .dashboard-lux-value {
            margin: 18px 0 0;
            color: #020617;
            font-size: 28px;
            line-height: 1;
            font-weight: 950;
            letter-spacing: -0.045em;
        }

        .dashboard-lux-caption {
            display: inline-flex;
            align-items: center;
            margin-top: 14px;
            border-radius: 999px;
            padding: 7px 11px;
            font-size: 12px;
            font-weight: 800;
        }

        .orders .dashboard-lux-caption { background: #eff6ff; color: #1d4ed8; }
        .units .dashboard-lux-caption { background: #fff7ed; color: #c2410c; }
        .product .dashboard-lux-caption { background: #f5f3ff; color: #6d28d9; }
        .stock .dashboard-lux-caption { background: #fef2f2; color: #b91c1c; }

        .dashboard-trend {
            display: block;
            margin-top: 10px;
            color: #64748b;
            font-size: 11px;
            font-weight: 800;
            line-height: 1.4;
        }

        .dashboard-trend.up { color: #059669; }
        .dashboard-trend.down { color: #dc2626; }
        .dashboard-trend.neutral { color: #64748b; }

        .metric-lux-card {
            height: 100%;
            min-height: 150px;
            overflow: hidden;
            border-radius: 24px;
            background: white;
            border: 1px solid rgba(226,232,240,0.95);
            box-shadow: 0 16px 40px rgba(15, 23, 42, 0.07);
        }

        .metric-lux-header {
            padding: 16px 18px 10px;
            border-bottom: 0;
            background:
                linear-gradient(135deg, rgba(15,118,110,0.08), transparent 45%),
                linear-gradient(90deg, #ffffff, #f8fafc);
        }

        .metric-lux-title {
            margin: 0;
            color: #020617;
            font-size: 16px;
            font-weight: 950;
            letter-spacing: -0.03em;
        }

        .metric-lux-desc {
            margin: 4px 0 0;
            color: #64748b;
            font-size: 11px;
            line-height: 1.4;
        }

        .metric-lux-body {
            padding: 8px 16px 16px;
            display: grid;
            grid-template-columns: repeat(3, minmax(0, 1fr));
            gap: 10px;
        }

        .metric-lux-item {
            display: flex;
            flex-direction: column;
            justify-content: center;
            min-height: 54px;
            border-radius: 16px;
            padding: 10px 12px;
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
            font-size: 12px;
            font-weight: 950;
            text-transform: uppercase;
            letter-spacing: 0.05em;
            text-align: center;
        }

        .metric-lux-item.active .metric-lux-label {
            color: white;
        }

        .metric-lux-description {
            margin-top: 4px;
            color: #64748b;
            font-size: 10px;
            font-weight: 750;
            text-align: center;
            line-height: 1.35;
        }

        .metric-lux-item.active .metric-lux-description {
            color: #ccfbf1;
        }

        .powerbi-panel-grid {
            display: grid;
            grid-template-columns: repeat(3, minmax(0, 1fr));
            gap: 18px;
            margin-top: 18px;
            align-items: stretch;
        }

        .powerbi-panel {
            min-height: 420px;
            height: 100%;
            border-radius: 26px;
            padding: 20px;
            background: white;
            border: 1px solid rgba(226,232,240,0.95);
            box-shadow: 0 16px 40px rgba(15,23,42,0.07);
            display: flex;
            flex-direction: column;
        }

        .powerbi-panel-title {
            margin: 0;
            color: #020617;
            font-size: 16px;
            font-weight: 950;
            letter-spacing: -0.03em;
        }

        .powerbi-panel-desc {
            margin: 6px 0 0;
            color: #64748b;
            font-size: 12px;
            line-height: 1.5;
        }

        .top-product-chart {
            display: grid;
            gap: 10px;
            margin-top: 18px;
        }

        .top-product-row {
            display: grid;
            gap: 6px;
        }

        .top-product-row-head {
            display: flex;
            align-items: center;
            justify-content: space-between;
            gap: 10px;
        }

        .top-product-rank-name {
            display: flex;
            align-items: center;
            gap: 10px;
            min-width: 0;
        }

        .top-product-rank {
            flex: 0 0 auto;
            width: 24px;
            height: 24px;
            border-radius: 999px;
            background: #ecfeff;
            color: #0f766e;
            font-size: 11px;
            font-weight: 900;
            display: inline-flex;
            align-items: center;
            justify-content: center;
        }

        .top-product-name {
            color: #0f172a;
            font-size: 12px;
            font-weight: 800;
            white-space: nowrap;
            overflow: hidden;
            text-overflow: ellipsis;
        }

        .top-product-value {
            color: #64748b;
            font-size: 11px;
            font-weight: 800;
            white-space: nowrap;
        }

        .mini-bar-track {
            width: 100%;
            height: 10px;
            border-radius: 999px;
            background: #e2e8f0;
            overflow: hidden;
        }

        .mini-bar-fill {
            height: 100%;
            border-radius: 999px;
            background: linear-gradient(90deg, #34d399, #10b981);
        }

        .revenue-summary {
            display: grid;
            grid-template-columns: 1fr;
            gap: 8px;
            margin-top: 18px;
            margin-bottom: 12px;
        }

        .revenue-summary-card {
            border-radius: 18px;
            padding: 12px 14px;
            background: #f8fafc;
            border: 1px solid #e2e8f0;
        }

        .revenue-summary-label {
            display: block;
            color: #64748b;
            font-size: 11px;
            font-weight: 800;
        }

        .revenue-summary-value {
            display: block;
            margin-top: 4px;
            color: #0f172a;
            font-size: 20px;
            line-height: 1.1;
            font-weight: 950;
        }

        .revenue-change-chip {
            display: inline-flex;
            align-items: center;
            gap: 6px;
            margin-top: 8px;
            font-size: 11px;
            font-weight: 900;
        }

        .revenue-change-chip.up { color: #059669; }
        .revenue-change-chip.down { color: #dc2626; }
        .revenue-change-chip.neutral { color: #64748b; }

        .revenue-chart-box {
            margin-top: auto;
            border-radius: 20px;
            padding: 12px 12px 10px;
            background: linear-gradient(180deg, rgba(240,253,250,0.9), rgba(255,255,255,1));
            border: 1px solid #dbeafe;
        }

        .revenue-chart-svg {
            width: 100%;
            height: 220px;
            display: block;
        }

        .revenue-axis-labels {
            display: grid;
            gap: 6px;
            margin-top: 8px;
        }

        .revenue-axis-caption {
            display: flex;
            justify-content: space-between;
            gap: 6px;
        }

        .revenue-axis-caption span {
            flex: 1 1 0;
            text-align: center;
            color: #64748b;
            font-size: 10px;
            font-weight: 800;
            white-space: nowrap;
        }

        .low-stock-visual-list {
            display: grid;
            gap: 12px;
            margin-top: 18px;
        }

        .low-stock-visual-row {
            border-radius: 18px;
            padding: 14px;
            background: #f8fafc;
            border: 1px solid #e2e8f0;
        }

        .low-stock-head {
            display: flex;
            align-items: center;
            justify-content: space-between;
            gap: 12px;
        }

        .low-stock-name {
            color: #0f172a;
            font-size: 13px;
            font-weight: 900;
        }

        .low-stock-status {
            display: inline-flex;
            align-items: center;
            justify-content: center;
            padding: 6px 10px;
            border-radius: 999px;
            font-size: 10px;
            font-weight: 900;
            white-space: nowrap;
        }

        .low-stock-status.critical {
            background: #fef2f2;
            color: #b91c1c;
        }

        .low-stock-status.low {
            background: #fff7ed;
            color: #c2410c;
        }

        .low-stock-status.warning {
            background: #fefce8;
            color: #a16207;
        }

        .low-stock-meta {
            margin-top: 5px;
            color: #64748b;
            font-size: 11px;
            font-weight: 700;
        }

        .low-stock-track {
            width: 100%;
            height: 12px;
            border-radius: 999px;
            background: #e5e7eb;
            overflow: hidden;
            margin-top: 10px;
        }

        .low-stock-fill {
            height: 100%;
            border-radius: 999px;
        }

        .low-stock-fill.critical {
            background: linear-gradient(90deg, #ef4444, #dc2626);
        }

        .low-stock-fill.low {
            background: linear-gradient(90deg, #fb923c, #f97316);
        }

        .low-stock-fill.warning {
            background: linear-gradient(90deg, #facc15, #eab308);
        }

        .low-stock-foot {
            display: flex;
            align-items: center;
            justify-content: space-between;
            gap: 12px;
            margin-top: 8px;
            color: #64748b;
            font-size: 10px;
            font-weight: 800;
        }

        .empty-state {
            margin-top: 16px;
            padding: 14px;
            border-radius: 18px;
            background: #f8fafc;
            border: 1px dashed #cbd5e1;
            color: #64748b;
            font-size: 12px;
            font-weight: 700;
            line-height: 1.6;
        }

        @media (max-width: 1500px) {
            .dashboard-lux-main-row {
                grid-template-columns: 1fr;
            }

            .metric-lux-card {
                height: auto;
            }

            .metric-lux-body {
                grid-template-columns: repeat(3, minmax(0, 1fr));
            }

            .powerbi-panel-grid {
                grid-template-columns: 1fr;
            }

            .powerbi-panel {
                min-height: auto;
            }
        }

        @media (max-width: 1100px) {
            .dashboard-lux-grid {
                grid-template-columns: repeat(2, minmax(0, 1fr));
            }
        }

        @media (max-width: 900px) {
            .dashboard-lux-hero-top {
                flex-direction: column;
            }

            .metric-lux-body {
                grid-template-columns: 1fr;
            }
        }

        @media (max-width: 640px) {
            .dashboard-lux-hero {
                padding: 24px;
                border-radius: 24px;
            }

            .dashboard-lux-title {
                font-size: 28px;
            }

            .dashboard-lux-grid {
                grid-template-columns: 1fr;
            }
        }
    </style>

    <div class="dashboard-lux-wrapper">
        <section class="dashboard-lux-hero">
            <div class="dashboard-lux-hero-top">
                <div>
                    <div class="dashboard-lux-badge">
                        <span class="dashboard-lux-dot"></span>
                        Ngunjuk POS Dashboard
                    </div>

                    <h2 class="dashboard-lux-title">
                        Dashboard POS Ngunjuk
                    </h2>

                    <p class="dashboard-lux-desc">
                        Pantau performa penjualan, transaksi, item terjual, stok produk,
                        insight penjualan, dan kondisi operasional UMKM Ngunjuk berdasarkan periode data yang dipilih.
                    </p>
                </div>

                <div class="dashboard-lux-mini">
                    <span>Revenue {{ $periodLabel }}</span>
                    <strong>Rp {{ number_format($summary['period_revenue'], 0, ',', '.') }}</strong>
                </div>
            </div>

            <div class="dashboard-period-filter">
                @foreach ($periodOptions as $periodKey => $periodName)
                    @php
                        $url = url('/admin') . '?' . http_build_query([
                            'period' => $periodKey,
                            'metric' => $activeMetric,
                        ]);
                    @endphp

                    <a
                        href="{{ $url }}"
                        class="dashboard-period-link {{ $activePeriod === $periodKey ? 'active' : '' }}"
                    >
                        {{ $periodName }}
                    </a>
                @endforeach
            </div>
        </section>

        <div class="dashboard-lux-main-row">
            <div class="dashboard-lux-grid">
                <div class="dashboard-lux-card orders">
                    <p class="dashboard-lux-label">Total Orders</p>

                    <p class="dashboard-lux-value">
                        {{ number_format($summary['period_orders'], 0, ',', '.') }}
                    </p>

                    <p class="dashboard-lux-caption">{{ $periodLabel }}</p>

                    <span class="dashboard-trend {{ $trends['orders']['direction'] }}">
                        {{ $trends['orders']['direction'] === 'up' ? '▲' : ($trends['orders']['direction'] === 'down' ? '▼' : '●') }}
                        {{ $trends['orders']['label'] }}
                    </span>
                </div>

                <div class="dashboard-lux-card units">
                    <p class="dashboard-lux-label">Units Sold</p>

                    <p class="dashboard-lux-value">
                        {{ number_format($summary['period_units_sold'], 0, ',', '.') }}
                    </p>

                    <p class="dashboard-lux-caption">{{ $periodLabel }}</p>

                    <span class="dashboard-trend {{ $trends['units']['direction'] }}">
                        {{ $trends['units']['direction'] === 'up' ? '▲' : ($trends['units']['direction'] === 'down' ? '▼' : '●') }}
                        {{ $trends['units']['label'] }}
                    </span>
                </div>

                <div class="dashboard-lux-card product">
                    <p class="dashboard-lux-label">Total Product</p>

                    <p class="dashboard-lux-value">
                        {{ number_format($summary['total_products'], 0, ',', '.') }}
                    </p>

                    <p class="dashboard-lux-caption">
                        {{ number_format($summary['total_categories'], 0, ',', '.') }} kategori
                    </p>
                </div>

                <div class="dashboard-lux-card stock">
                    <p class="dashboard-lux-label">Stok Habis</p>

                    <p class="dashboard-lux-value">
                        {{ number_format($summary['out_of_stock_products'], 0, ',', '.') }}
                    </p>

                    <p class="dashboard-lux-caption">Produk perlu restock</p>
                </div>
            </div>

            <div class="metric-lux-card">
                <div class="metric-lux-header">
                    <h3 class="metric-lux-title">
                        Dashboard Metric
                    </h3>

                    <p class="metric-lux-desc">
                        Pilih metric utama untuk mengubah visualisasi dashboard.
                    </p>
                </div>

                <div class="metric-lux-body">
                    @foreach ($metrics as $key => $metric)
                        @php
                            $isActive = $activeMetric === $key;

                            $url = url('/admin') . '?' . http_build_query([
                                'period' => $activePeriod,
                                'metric' => $key,
                            ]);
                        @endphp

                        <a
                            href="{{ $url }}"
                            class="metric-lux-item {{ $isActive ? 'active' : '' }}"
                        >
                            <span class="metric-lux-label">
                                {{ $metric['label'] }}
                            </span>

                            <span class="metric-lux-description">
                                {{ $metric['description'] }}
                            </span>
                        </a>
                    @endforeach
                </div>
            </div>
        </div>

        <div class="powerbi-panel-grid">
            <div class="powerbi-panel">
                <div>
                    <h3 class="powerbi-panel-title">Insight Penjualan</h3>
                    <p class="powerbi-panel-desc">
                        {{ $topProductsChart['title'] }} pada {{ strtolower($periodLabel) }}.
                    </p>
                </div>

                @if (count($topProductsChart['items']) > 0)
                    <div class="top-product-chart">
                        @foreach ($topProductsChart['items'] as $item)
                            <div class="top-product-row">
                                <div class="top-product-row-head">
                                    <div class="top-product-rank-name">
                                        <span class="top-product-rank">{{ $loop->iteration }}</span>
                                        <span class="top-product-name">{{ $item['name'] }}</span>
                                    </div>

                                    <span class="top-product-value">{{ $item['formatted_value'] }}</span>
                                </div>

                                <div class="mini-bar-track">
                                    <div
                                        class="mini-bar-fill"
                                        style="width: {{ $item['width'] }}%;"
                                    ></div>
                                </div>
                            </div>
                        @endforeach
                    </div>
                @else
                    <div class="empty-state">
                        Belum ada data produk untuk divisualisasikan pada periode ini.
                    </div>
                @endif
            </div>

            <div class="powerbi-panel">
                <div>
                    <h3 class="powerbi-panel-title">Revenue Performance</h3>
                    <p class="powerbi-panel-desc">
                        Visualisasi tren pendapatan {{ strtolower($periodLabel) }}.
                    </p>
                </div>

                <div class="revenue-summary">
                    <div class="revenue-summary-card">
                        <span class="revenue-summary-label">Revenue {{ $periodLabel }}</span>
                        <strong class="revenue-summary-value">
                            Rp {{ number_format($summary['period_revenue'], 0, ',', '.') }}
                        </strong>

                        <span class="revenue-change-chip {{ $trends['revenue']['direction'] }}">
                            {{ $trends['revenue']['direction'] === 'up' ? '▲' : ($trends['revenue']['direction'] === 'down' ? '▼' : '●') }}
                            {{ $trends['revenue']['label'] }}
                        </span>
                    </div>
                </div>

                @php
                    $chartWidth = 560;
                    $chartHeight = 220;
                    $paddingTop = 18;
                    $paddingRight = 16;
                    $paddingBottom = 26;
                    $paddingLeft = 12;

                    $series = $revenueTrendChart['series'];
                    $trendValues = $revenueTrendChart['trend_values'];

                    $plotWidth = $chartWidth - $paddingLeft - $paddingRight;
                    $plotHeight = $chartHeight - $paddingTop - $paddingBottom;

                    $maxChartValue = max(
                        max(array_map(fn ($item) => (float) $item['value'], $series)),
                        max($trendValues ?: [0]),
                        1
                    );

                    $countSeries = count($series);
                    $stepX = $countSeries > 1 ? ($plotWidth / ($countSeries - 1)) : $plotWidth;

                    $linePoints = [];
                    $trendPoints = [];
                    $areaPoints = [];

                    foreach ($series as $index => $point) {
                        $x = $paddingLeft + ($index * $stepX);
                        $y = $paddingTop + (($maxChartValue - (float) $point['value']) / $maxChartValue) * $plotHeight;

                        $linePoints[] = round($x, 2) . ',' . round($y, 2);
                        $areaPoints[] = round($x, 2) . ',' . round($y, 2);

                        $trendY = $paddingTop + (($maxChartValue - (float) ($trendValues[$index] ?? 0)) / $maxChartValue) * $plotHeight;
                        $trendPoints[] = round($x, 2) . ',' . round($trendY, 2);
                    }

                    $areaPath = '';
                    if (count($areaPoints) > 0) {
                        $firstPoint = explode(',', $areaPoints[0]);
                        $lastPoint = explode(',', $areaPoints[count($areaPoints) - 1]);

                        $areaPath = 'M ' . $firstPoint[0] . ' ' . ($paddingTop + $plotHeight) . ' ';
                        foreach ($areaPoints as $point) {
                            [$xPoint, $yPoint] = explode(',', $point);
                            $areaPath .= 'L ' . $xPoint . ' ' . $yPoint . ' ';
                        }
                        $areaPath .= 'L ' . $lastPoint[0] . ' ' . ($paddingTop + $plotHeight) . ' Z';
                    }

                    $gridLines = 4;
                @endphp

                <div class="revenue-chart-box">
                    <svg
                        class="revenue-chart-svg"
                        viewBox="0 0 {{ $chartWidth }} {{ $chartHeight }}"
                        preserveAspectRatio="none"
                    >
                        @for ($i = 0; $i <= $gridLines; $i++)
                            @php
                                $y = $paddingTop + (($plotHeight / $gridLines) * $i);
                            @endphp
                            <line
                                x1="{{ $paddingLeft }}"
                                y1="{{ $y }}"
                                x2="{{ $chartWidth - $paddingRight }}"
                                y2="{{ $y }}"
                                stroke="#e2e8f0"
                                stroke-width="1"
                            />
                        @endfor

                        @if ($areaPath !== '')
                            <path
                                d="{{ $areaPath }}"
                                fill="rgba(20, 184, 166, 0.12)"
                            />
                        @endif

                        <polyline
                            fill="none"
                            stroke="#111827"
                            stroke-width="2"
                            stroke-dasharray="6 6"
                            points="{{ implode(' ', $trendPoints) }}"
                        />

                        <polyline
                            fill="none"
                            stroke="#0f9f8c"
                            stroke-width="3"
                            points="{{ implode(' ', $linePoints) }}"
                        />

                        @foreach ($series as $index => $point)
                            @php
                                $x = $paddingLeft + ($index * $stepX);
                                $y = $paddingTop + (($maxChartValue - (float) $point['value']) / $maxChartValue) * $plotHeight;
                            @endphp

                            <circle
                                cx="{{ $x }}"
                                cy="{{ $y }}"
                                r="4"
                                fill="#0f9f8c"
                            />
                        @endforeach
                    </svg>

                    <div class="revenue-axis-labels">
                        <div class="revenue-axis-caption">
                            @foreach ($series as $point)
                                <span>{{ $point['label'] }}</span>
                            @endforeach
                        </div>
                    </div>
                </div>
            </div>

            <div class="powerbi-panel">
                <div>
                    <h3 class="powerbi-panel-title">Low Stock Alert</h3>
                    <p class="powerbi-panel-desc">
                        Visualisasi produk dengan stok rendah yang perlu diperhatikan.
                    </p>
                </div>

                @if ($lowStockProducts->isNotEmpty())
                    <div class="low-stock-visual-list">
                        @foreach ($lowStockProducts as $product)
                            @php
                                $stock = (int) $product->stock;

                                if ($stock <= 0) {
                                    $status = 'Kritis';
                                    $statusClass = 'critical';
                                } elseif ($stock <= 2) {
                                    $status = 'Rendah';
                                    $statusClass = 'low';
                                } else {
                                    $status = 'Waspada';
                                    $statusClass = 'warning';
                                }

                                $safeLimit = 5;
                                $width = $stock <= 0 ? 4 : min(($stock / $safeLimit) * 100, 100);
                            @endphp

                            <div class="low-stock-visual-row">
                                <div class="low-stock-head">
                                    <div>
                                        <div class="low-stock-name">{{ $product->name }}</div>
                                        <div class="low-stock-meta">
                                            {{ $stock <= 0 ? 'Stok habis' : 'Stok rendah dan perlu restock' }}
                                        </div>
                                    </div>

                                    <span class="low-stock-status {{ $statusClass }}">
                                        {{ $status }}
                                    </span>
                                </div>

                                <div class="low-stock-track">
                                    <div
                                        class="low-stock-fill {{ $statusClass }}"
                                        style="width: {{ $width }}%;"
                                    ></div>
                                </div>

                                <div class="low-stock-foot">
                                    <span>Stok saat ini: {{ number_format($stock, 0, ',', '.') }}</span>
                                    <span>Batas aman: {{ $safeLimit }}</span>
                                </div>
                            </div>
                        @endforeach
                    </div>
                @else
                    <div class="empty-state">
                        Semua stok produk masih aman dan belum ada alert untuk ditampilkan.
                    </div>
                @endif
            </div>
        </div>
    </div>
</x-filament-widgets::widget>