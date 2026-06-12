<x-filament-widgets::widget>
    <x-filament::section>
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
                        {{ number_format($riskProducts, 0, ',', '.') }}
                    </div>
                </div>

                <div class="stock-alert-summary-box">
                    <div class="stock-alert-summary-label">Total Products</div>
                    <div class="stock-alert-summary-value">
                        {{ number_format($totalProducts, 0, ',', '.') }}
                    </div>
                </div>
            </div>

            <div class="stock-alert-distribution">
                @foreach ($distribution as $segment)
                    <div
                        class="stock-alert-segment {{ $segment['class'] }}"
                        style="width: {{ $segment['width'] }}%;"
                    ></div>
                @endforeach
            </div>

            <div class="stock-alert-legend">
                @foreach ($distribution as $segment)
                    <div class="stock-alert-legend-item">
                        <div class="stock-alert-legend-label">{{ $segment['label'] }}</div>
                        <div class="stock-alert-legend-value">
                            {{ number_format($segment['count'], 0, ',', '.') }}
                        </div>
                    </div>
                @endforeach
            </div>

            @if (count($items) > 0)
                <div class="stock-alert-list">
                    @foreach ($items as $item)
                        <div class="stock-alert-item">
                            <div class="stock-alert-item-head">
                                <div>
                                    <div class="stock-alert-product">{{ $item['name'] }}</div>
                                    <div class="stock-alert-stock">
                                        Sisa stok {{ number_format($item['stock'], 0, ',', '.') }}/{{ $item['safeLimit'] }}
                                    </div>
                                </div>

                                <div class="stock-alert-status {{ $item['statusClass'] }}">
                                    {{ $item['status'] }}
                                </div>
                            </div>

                            <div class="stock-alert-progress">
                                <div
                                    class="stock-alert-progress-fill"
                                    style="width: {{ $item['width'] }}%;"
                                ></div>
                            </div>
                        </div>
                    @endforeach
                </div>
            @else
                <div class="stock-alert-empty">
                    Semua produk berada di atas batas risiko stok.
                </div>
            @endif
        </div>
    </x-filament::section>
</x-filament-widgets::widget>