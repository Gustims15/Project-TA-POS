<x-filament-widgets::widget>
    <div class="pbi-overview-shell">
        <div class="pbi-overview-header">
            <div>
                <div class="pbi-eyebrow">Ngunjuk POS Dashboard</div>
                <h2>Sales Performance Control</h2>
                <p>
                    Monitoring revenue, order, item terjual, dan kondisi stok dalam satu tampilan ringkas.
                </p>
            </div>

            <div class="pbi-filter-panel">
                <div class="pbi-filter-block">
                    <span>Periode</span>

                    <div class="pbi-segment">
                        @foreach ($periodOptions as $periodKey => $periodName)
                            @php
                                $periodUrl = url('/admin') . '?' . http_build_query([
                                    'period' => $periodKey,
                                    'metric' => $activeMetric,
                                ]);

                                $isActive = $activePeriod === $periodKey;
                            @endphp

                            <a
                                href="{{ $periodUrl }}"
                                class="{{ $isActive ? 'is-active' : '' }}"
                            >
                                {{ $periodName }}
                            </a>
                        @endforeach
                    </div>
                </div>

                <div class="pbi-filter-block">
                    <span>Metric</span>

                    <div class="pbi-segment">
                        @foreach ($metrics as $key => $metric)
                            @php
                                $metricUrl = url('/admin') . '?' . http_build_query([
                                    'period' => $activePeriod,
                                    'metric' => $key,
                                ]);

                                $isActive = $activeMetric === $key;
                            @endphp

                            <a
                                href="{{ $metricUrl }}"
                                class="{{ $isActive ? 'is-active' : '' }}"
                            >
                                {{ $metric['label'] }}
                            </a>
                        @endforeach
                    </div>
                </div>
            </div>
        </div>

        @php
            $kpiCards = [
                [
                    'label' => 'Revenue',
                    'value' => 'Rp ' . number_format($summary['period_revenue'] ?? 0, 0, ',', '.'),
                    'trend' => $trends['revenue'] ?? ['direction' => 'flat', 'label' => '0%'],
                    'visual' => $kpiVisuals['revenue']['items'] ?? [],
                ],
                [
                    'label' => 'Orders',
                    'value' => number_format($summary['period_orders'] ?? 0, 0, ',', '.'),
                    'trend' => $trends['orders'] ?? ['direction' => 'flat', 'label' => '0%'],
                    'visual' => $kpiVisuals['orders']['items'] ?? [],
                ],
                [
                    'label' => 'Units Sold',
                    'value' => number_format($summary['period_units_sold'] ?? 0, 0, ',', '.'),
                    'trend' => $trends['units'] ?? ['direction' => 'flat', 'label' => '0%'],
                    'visual' => $kpiVisuals['units']['items'] ?? [],
                ],
            ];
        @endphp

        <div class="pbi-kpi-grid">
            @foreach ($kpiCards as $card)
                @php
                    $direction = $card['trend']['direction'] ?? 'flat';

                    $trendIcon = match ($direction) {
                        'up' => '▲',
                        'down' => '▼',
                        default => '●',
                    };
                @endphp

                <div class="pbi-kpi-card">
                    <div class="pbi-kpi-top">
                        <span>{{ $card['label'] }}</span>
                        <strong>{{ $card['value'] }}</strong>
                    </div>

                    <div class="pbi-mini-bars">
                        @foreach ($card['visual'] as $bar)
                            <i style="height: {{ $bar['height'] ?? 0 }}%"></i>
                        @endforeach
                    </div>

                    <div class="pbi-kpi-bottom {{ $direction }}">
                        <span>{{ $trendIcon }}</span>
                        <span>{{ $card['trend']['label'] ?? '0%' }} · {{ $periodLabel }}</span>
                    </div>
                </div>
            @endforeach

            <div class="pbi-kpi-card pbi-stock-card">
                <div class="pbi-kpi-top">
                    <span>Stock Health</span>
                    <strong>{{ number_format($kpiVisuals['stock']['safe'] ?? 0, 1, ',', '.') }}%</strong>
                </div>

                <div class="pbi-stock-stack">
                    <i
                        class="safe"
                        style="width: {{ $kpiVisuals['stock']['safe'] ?? 0 }}%"
                    ></i>
                    <i
                        class="low"
                        style="width: {{ $kpiVisuals['stock']['low'] ?? 0 }}%"
                    ></i>
                    <i
                        class="out"
                        style="width: {{ $kpiVisuals['stock']['out'] ?? 0 }}%"
                    ></i>
                </div>

                <div class="pbi-stock-meta">
                    <span>{{ number_format($summary['total_products'] ?? 0, 0, ',', '.') }} produk</span>
                    <span>{{ number_format($summary['out_of_stock_products'] ?? 0, 0, ',', '.') }} habis</span>
                </div>
            </div>
        </div>
    </div>
</x-filament-widgets::widget>