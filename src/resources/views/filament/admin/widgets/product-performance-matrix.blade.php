<x-filament-widgets::widget>
    <x-filament::section>
        <style>
            .product-ranking-card {
                min-height: 430px;
            }

            .product-ranking-header {
                display: flex;
                align-items: flex-start;
                justify-content: space-between;
                gap: 16px;
                margin-bottom: 18px;
            }

            .product-ranking-title {
                margin: 0;
                color: #0f172a;
                font-size: 16px;
                font-weight: 950;
                letter-spacing: -0.035em;
            }

            .product-ranking-subtitle {
                margin: 5px 0 0;
                color: #64748b;
                font-size: 12px;
                font-weight: 650;
                line-height: 1.55;
            }

            .product-ranking-badge {
                display: inline-flex;
                align-items: center;
                gap: 8px;
                white-space: nowrap;
                border-radius: 999px;
                padding: 8px 12px;
                color: #9a3412;
                background: linear-gradient(135deg, rgba(255, 247, 237, 0.96), rgba(254, 215, 170, 0.72));
                border: 1px solid rgba(251, 146, 60, 0.28);
                font-size: 11px;
                font-weight: 900;
            }

            .product-ranking-summary {
                display: grid;
                grid-template-columns: repeat(3, minmax(0, 1fr));
                gap: 12px;
                margin-bottom: 18px;
            }

            .product-ranking-summary-card {
                border-radius: 20px;
                padding: 14px 15px;
                background: linear-gradient(145deg, rgba(255, 255, 255, 0.96), rgba(248, 250, 252, 0.92));
                border: 1px solid rgba(226, 232, 240, 0.8);
                box-shadow: 0 14px 34px rgba(15, 23, 42, 0.06);
            }

            .product-ranking-summary-label {
                color: #94a3b8;
                font-size: 10px;
                font-weight: 900;
                letter-spacing: 0.08em;
                text-transform: uppercase;
            }

            .product-ranking-summary-value {
                margin-top: 7px;
                color: #0f172a;
                font-size: 17px;
                font-weight: 950;
                letter-spacing: -0.04em;
            }

            .product-ranking-list {
                display: grid;
                gap: 11px;
            }

            .product-ranking-item {
                display: grid;
                grid-template-columns: 38px minmax(0, 1fr) 150px;
                gap: 12px;
                align-items: center;
                border-radius: 18px;
                padding: 12px;
                background: rgba(248, 250, 252, 0.74);
                border: 1px solid rgba(226, 232, 240, 0.78);
            }

            .product-ranking-number {
                width: 34px;
                height: 34px;
                display: grid;
                place-items: center;
                border-radius: 13px;
                color: #9a3412;
                background: linear-gradient(135deg, rgba(255, 247, 237, 1), rgba(254, 215, 170, 0.7));
                border: 1px solid rgba(251, 146, 60, 0.28);
                font-size: 12px;
                font-weight: 950;
            }

            .product-ranking-name {
                color: #0f172a;
                font-size: 13px;
                font-weight: 900;
                line-height: 1.25;
            }

            .product-ranking-meta {
                margin-top: 5px;
                display: flex;
                flex-wrap: wrap;
                gap: 8px;
                color: #64748b;
                font-size: 10px;
                font-weight: 750;
            }

            .product-ranking-bar-wrap {
                margin-top: 9px;
                height: 8px;
                overflow: hidden;
                border-radius: 999px;
                background: rgba(226, 232, 240, 0.95);
            }

            .product-ranking-bar {
                height: 100%;
                border-radius: inherit;
                background: linear-gradient(90deg, #fb923c, #f97316, #16a34a);
            }

            .product-ranking-value {
                text-align: right;
            }

            .product-ranking-metric {
                color: #0f172a;
                font-size: 13px;
                font-weight: 950;
            }

            .product-ranking-share {
                margin-top: 4px;
                color: #94a3b8;
                font-size: 10px;
                font-weight: 800;
            }

            .product-ranking-empty {
                display: grid;
                min-height: 220px;
                place-items: center;
                border-radius: 20px;
                color: #94a3b8;
                background: rgba(248, 250, 252, 0.74);
                border: 1px dashed rgba(148, 163, 184, 0.5);
                font-size: 13px;
                font-weight: 800;
                text-align: center;
            }

            @media (max-width: 900px) {
                .product-ranking-header,
                .product-ranking-summary {
                    grid-template-columns: 1fr;
                }

                .product-ranking-header {
                    flex-direction: column;
                }

                .product-ranking-item {
                    grid-template-columns: 34px minmax(0, 1fr);
                }

                .product-ranking-value {
                    grid-column: 2;
                    text-align: left;
                }
            }
        </style>

        <div class="product-ranking-card">
            <div class="product-ranking-header">
                <div>
                    <h3 class="product-ranking-title">Top Product Ranking</h3>
                    <p class="product-ranking-subtitle">
                        Ranking 10 produk terbaik berdasarkan {{ $activeMetricLabel }} pada {{ strtolower($periodLabel) }}.
                    </p>
                </div>

                <div class="product-ranking-badge">
                    Metric: {{ $activeMetricLabel }}
                </div>
            </div>

            <div class="product-ranking-summary">
                <div class="product-ranking-summary-card">
                    <div class="product-ranking-summary-label">Best Product</div>
                    <div class="product-ranking-summary-value">{{ $bestProductName }}</div>
                </div>

                <div class="product-ranking-summary-card">
                    <div class="product-ranking-summary-label">Top Value</div>
                    <div class="product-ranking-summary-value">{{ $bestProductValue }}</div>
                </div>

                <div class="product-ranking-summary-card">
                    <div class="product-ranking-summary-label">Products Analyzed</div>
                    <div class="product-ranking-summary-value">
                        {{ number_format($totalProductsAnalyzed, 0, ',', '.') }} produk
                    </div>
                </div>
            </div>

            @if (count($items) > 0)
                <div class="product-ranking-list">
                    @foreach ($items as $item)
                        <div class="product-ranking-item">
                            <div class="product-ranking-number">
                                #{{ $item['rank'] }}
                            </div>

                            <div>
                                <div class="product-ranking-name">{{ $item['name'] }}</div>

                                <div class="product-ranking-meta">
                                    <span>{{ $item['revenue_formatted'] }}</span>
                                    <span>•</span>
                                    <span>{{ $item['units_formatted'] }}</span>
                                    <span>•</span>
                                    <span>{{ $item['orders_formatted'] }}</span>
                                </div>

                                <div class="product-ranking-bar-wrap">
                                    <div
                                        class="product-ranking-bar"
                                        style="width: {{ $item['bar_width'] }}%;"
                                    ></div>
                                </div>
                            </div>

                            <div class="product-ranking-value">
                                <div class="product-ranking-metric">
                                    {{ $item['metric_formatted'] }}
                                </div>
                                <div class="product-ranking-share">
                                    {{ number_format($item['contribution'], 1, ',', '.') }}% kontribusi
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>
            @else
                <div class="product-ranking-empty">
                    Belum ada data produk untuk divisualisasikan pada periode ini.
                </div>
            @endif
        </div>
    </x-filament::section>
</x-filament-widgets::widget>