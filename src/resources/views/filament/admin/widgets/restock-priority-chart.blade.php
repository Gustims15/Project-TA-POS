<x-filament-widgets::widget>
    <x-filament::section>
        <style>
            .stock-risk-pbi {
                min-height: 380px;
            }

            .stock-risk-head {
                display: flex;
                align-items: flex-start;
                justify-content: space-between;
                gap: 14px;
                margin-bottom: 16px;
            }

            .stock-risk-title {
                margin: 0;
                color: #0f172a;
                font-size: 15px;
                font-weight: 950;
                letter-spacing: -0.03em;
            }

            .stock-risk-subtitle {
                margin: 5px 0 0;
                color: #64748b;
                font-size: 11px;
                font-weight: 700;
                line-height: 1.5;
            }

            .stock-risk-chip {
                height: fit-content;
                padding: 7px 10px;
                border-radius: 999px;
                background: #fef2f2;
                color: #b91c1c;
                font-size: 10px;
                font-weight: 950;
                white-space: nowrap;
            }

            .stock-risk-summary {
                display: grid;
                grid-template-columns: repeat(2, minmax(0, 1fr));
                gap: 10px;
                margin-bottom: 14px;
            }

            .stock-risk-box {
                border-radius: 16px;
                padding: 12px 13px;
                background: #f8fafc;
                border: 1px solid #e2e8f0;
            }

            .stock-risk-box-label {
                color: #64748b;
                font-size: 10px;
                font-weight: 900;
                text-transform: uppercase;
                letter-spacing: 0.08em;
            }

            .stock-risk-box-value {
                margin-top: 5px;
                color: #0f172a;
                font-size: 22px;
                line-height: 1;
                font-weight: 950;
                letter-spacing: -0.05em;
            }

            .stock-risk-distribution {
                border-radius: 18px;
                padding: 14px;
                background: linear-gradient(180deg, #f8fafc, #ffffff);
                border: 1px solid #e2e8f0;
                margin-bottom: 14px;
            }

            .stock-risk-bar {
                display: flex;
                height: 18px;
                overflow: hidden;
                border-radius: 999px;
                background: #e2e8f0;
            }

            .stock-risk-segment {
                min-width: 4px;
                height: 100%;
            }

            .stock-risk-segment.safe {
                background: #0f766e;
            }

            .stock-risk-segment.warning {
                background: #eab308;
            }

            .stock-risk-segment.low {
                background: #f97316;
            }

            .stock-risk-segment.critical {
                background: #dc2626;
            }

            .stock-risk-legend {
                display: grid;
                grid-template-columns: repeat(4, minmax(0, 1fr));
                gap: 8px;
                margin-top: 12px;
            }

            .stock-risk-legend-item {
                display: flex;
                align-items: center;
                gap: 6px;
                min-width: 0;
                color: #64748b;
                font-size: 10px;
                font-weight: 850;
            }

            .stock-risk-dot {
                width: 9px;
                height: 9px;
                border-radius: 999px;
                flex: none;
            }

            .stock-risk-dot.safe {
                background: #0f766e;
            }

            .stock-risk-dot.warning {
                background: #eab308;
            }

            .stock-risk-dot.low {
                background: #f97316;
            }

            .stock-risk-dot.critical {
                background: #dc2626;
            }

            .stock-risk-list {
                display: grid;
                gap: 9px;
            }

            .stock-risk-item {
                display: grid;
                grid-template-columns: minmax(0, 1fr) auto;
                gap: 12px;
                align-items: center;
                border-radius: 15px;
                padding: 10px 11px;
                background: #ffffff;
                border: 1px solid #e2e8f0;
                box-shadow: 0 8px 18px rgba(15, 23, 42, 0.04);
            }

            .stock-risk-name {
                color: #0f172a;
                font-size: 12px;
                font-weight: 950;
                white-space: nowrap;
                overflow: hidden;
                text-overflow: ellipsis;
            }

            .stock-risk-meta {
                margin-top: 6px;
                display: grid;
                grid-template-columns: minmax(0, 1fr) auto;
                gap: 8px;
                align-items: center;
            }

            .stock-risk-track {
                height: 8px;
                border-radius: 999px;
                background: #e2e8f0;
                overflow: hidden;
            }

            .stock-risk-fill {
                height: 100%;
                min-width: 4px;
                border-radius: 999px;
            }

            .stock-risk-fill.warning {
                background: linear-gradient(90deg, #eab308, #facc15);
            }

            .stock-risk-fill.low {
                background: linear-gradient(90deg, #f97316, #fb923c);
            }

            .stock-risk-fill.critical {
                background: linear-gradient(90deg, #dc2626, #ef4444);
            }

            .stock-risk-stock {
                color: #64748b;
                font-size: 10px;
                font-weight: 900;
                white-space: nowrap;
            }

            .stock-risk-status {
                padding: 5px 8px;
                border-radius: 999px;
                font-size: 9px;
                font-weight: 950;
                white-space: nowrap;
            }

            .stock-risk-status.warning {
                background: #fef9c3;
                color: #a16207;
            }

            .stock-risk-status.low {
                background: #ffedd5;
                color: #c2410c;
            }

            .stock-risk-status.critical {
                background: #fee2e2;
                color: #991b1b;
            }

            .stock-risk-empty {
                min-height: 145px;
                display: flex;
                align-items: center;
                justify-content: center;
                border-radius: 16px;
                background: #f8fafc;
                border: 1px dashed #cbd5e1;
                color: #64748b;
                font-size: 12px;
                font-weight: 850;
                text-align: center;
                padding: 18px;
            }

            @media (max-width: 720px) {
                .stock-risk-summary,
                .stock-risk-legend {
                    grid-template-columns: repeat(2, minmax(0, 1fr));
                }
            }
        </style>

        <div class="stock-risk-pbi">
            <div class="stock-risk-head">
                <div>
                    <h3 class="stock-risk-title">Stock Risk</h3>
                    <p class="stock-risk-subtitle">
                        Distribusi risiko stok dan prioritas produk yang perlu segera diperhatikan.
                    </p>
                </div>

                <span class="stock-risk-chip">Stock Alert</span>
            </div>

            <div class="stock-risk-summary">
                <div class="stock-risk-box">
                    <div class="stock-risk-box-label">Risk Products</div>
                    <div class="stock-risk-box-value">
                        {{ number_format($riskProducts, 0, ',', '.') }}
                    </div>
                </div>

                <div class="stock-risk-box">
                    <div class="stock-risk-box-label">Total Products</div>
                    <div class="stock-risk-box-value">
                        {{ number_format($totalProducts, 0, ',', '.') }}
                    </div>
                </div>
            </div>

            <div class="stock-risk-distribution">
                <div class="stock-risk-bar">
                    @foreach ($distribution as $segment)
                        <div
                            class="stock-risk-segment {{ $segment['class'] }}"
                            style="width: {{ max((float) $segment['width'], $segment['count'] > 0 ? 4 : 0) }}%;"
                            title="{{ $segment['label'] }} - {{ $segment['count'] }} produk"
                        ></div>
                    @endforeach
                </div>

                <div class="stock-risk-legend">
                    @foreach ($distribution as $segment)
                        <div class="stock-risk-legend-item">
                            <span class="stock-risk-dot {{ $segment['class'] }}"></span>
                            <span>
                                {{ $segment['label'] }} {{ number_format($segment['count'], 0, ',', '.') }}
                            </span>
                        </div>
                    @endforeach
                </div>
            </div>

            @if (count($items) > 0)
                <div class="stock-risk-list">
                    @foreach ($items as $item)
                        <div class="stock-risk-item">
                            <div>
                                <div class="stock-risk-name" title="{{ $item['name'] }}">
                                    {{ $item['name'] }}
                                </div>

                                <div class="stock-risk-meta">
                                    <div class="stock-risk-track">
                                        <div
                                            class="stock-risk-fill {{ $item['statusClass'] }}"
                                            style="width: {{ max((float) $item['width'], $item['stock'] > 0 ? 6 : 4) }}%;"
                                        ></div>
                                    </div>

                                    <div class="stock-risk-stock">
                                        {{ number_format($item['stock'], 0, ',', '.') }}/{{ $item['safeLimit'] }}
                                    </div>
                                </div>
                            </div>

                            <span class="stock-risk-status {{ $item['statusClass'] }}">
                                {{ $item['status'] }}
                            </span>
                        </div>
                    @endforeach
                </div>
            @else
                <div class="stock-risk-empty">
                    Semua produk berada di atas batas risiko stok.
                </div>
            @endif
        </div>
    </x-filament::section>
</x-filament-widgets::widget>