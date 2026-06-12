<x-filament-widgets::widget>
    <x-filament::section>
        <style>
            .sales-heatmap-card {
                min-height: 420px;
            }

            .sales-heatmap-head {
                display: flex;
                justify-content: space-between;
                align-items: flex-start;
                gap: 14px;
                margin-bottom: 16px;
            }

            .sales-heatmap-title {
                margin: 0;
                color: #0f172a;
                font-size: 15px;
                font-weight: 950;
                letter-spacing: -0.035em;
            }

            .sales-heatmap-subtitle {
                margin: 5px 0 0;
                color: #64748b;
                font-size: 11px;
                font-weight: 650;
                line-height: 1.45;
            }

            .sales-heatmap-badge {
                border-radius: 999px;
                padding: 8px 10px;
                color: #166534;
                background: rgba(220, 252, 231, 0.86);
                border: 1px solid rgba(34, 197, 94, 0.22);
                font-size: 10px;
                font-weight: 950;
                white-space: nowrap;
            }

            .sales-heatmap-insights {
                display: grid;
                grid-template-columns: repeat(4, minmax(0, 1fr));
                gap: 10px;
                margin-bottom: 15px;
            }

            .sales-heatmap-insight {
                border-radius: 17px;
                padding: 12px;
                background: rgba(248, 250, 252, 0.86);
                border: 1px solid rgba(226, 232, 240, 0.86);
            }

            .sales-heatmap-insight-label {
                color: #94a3b8;
                font-size: 9px;
                font-weight: 950;
                letter-spacing: 0.08em;
                text-transform: uppercase;
            }

            .sales-heatmap-insight-value {
                margin-top: 6px;
                color: #0f172a;
                font-size: 13px;
                font-weight: 950;
                letter-spacing: -0.02em;
            }

            .sales-heatmap-table-wrap {
                overflow-x: auto;
                border-radius: 20px;
                padding: 12px;
                background: rgba(248, 250, 252, 0.72);
                border: 1px solid rgba(226, 232, 240, 0.8);
            }

            .sales-heatmap-grid {
                display: grid;
                gap: 7px;
                min-width: 760px;
                align-items: center;
            }

            .sales-heatmap-axis {
                color: #94a3b8;
                font-size: 10px;
                font-weight: 950;
                text-align: center;
            }

            .sales-heatmap-day {
                color: #64748b;
                font-size: 10px;
                font-weight: 950;
            }

            .sales-heatmap-cell {
                position: relative;
                height: 31px;
                border-radius: 10px;
                border: 1px solid rgba(255, 255, 255, 0.68);
                box-shadow: inset 0 0 0 1px rgba(255, 255, 255, 0.14);
            }

            .sales-heatmap-cell.level-0 {
                background: #f1f5f9;
            }

            .sales-heatmap-cell.level-1 {
                background: #dcfce7;
            }

            .sales-heatmap-cell.level-2 {
                background: #bbf7d0;
            }

            .sales-heatmap-cell.level-3 {
                background: #fed7aa;
            }

            .sales-heatmap-cell.level-4 {
                background: #fb923c;
            }

            .sales-heatmap-cell.level-5 {
                background: #f97316;
            }

            .sales-heatmap-cell:hover::after {
                content: attr(data-tooltip);
                position: absolute;
                z-index: 10;
                left: 50%;
                bottom: calc(100% + 8px);
                transform: translateX(-50%);
                width: max-content;
                max-width: 180px;
                border-radius: 10px;
                padding: 8px 10px;
                color: #ffffff;
                background: #0f172a;
                font-size: 10px;
                font-weight: 850;
                white-space: nowrap;
                box-shadow: 0 14px 28px rgba(15, 23, 42, 0.24);
            }

            .sales-heatmap-legend {
                display: flex;
                justify-content: flex-end;
                align-items: center;
                gap: 8px;
                margin-top: 12px;
                color: #94a3b8;
                font-size: 10px;
                font-weight: 850;
            }

            .sales-heatmap-legend-bar {
                width: 120px;
                height: 9px;
                border-radius: 999px;
                background: linear-gradient(90deg, #f1f5f9, #dcfce7, #fed7aa, #fb923c, #f97316);
                border: 1px solid rgba(226, 232, 240, 0.8);
            }

            @media (max-width: 900px) {
                .sales-heatmap-insights {
                    grid-template-columns: repeat(2, minmax(0, 1fr));
                }
            }

            @media (max-width: 640px) {
                .sales-heatmap-head {
                    flex-direction: column;
                }

                .sales-heatmap-insights {
                    grid-template-columns: 1fr;
                }
            }
        </style>

        <div class="sales-heatmap-card">
            <div class="sales-heatmap-head">
                <div>
                    <h3 class="sales-heatmap-title">Sales Heatmap</h3>
                    <p class="sales-heatmap-subtitle">
                        Intensitas {{ strtolower($metricLabel) }} berdasarkan hari dan jam operasional minggu ini.
                    </p>
                </div>

                <div class="sales-heatmap-badge">
                    {{ $weekLabel }}
                </div>
            </div>

            <div class="sales-heatmap-insights">
                <div class="sales-heatmap-insight">
                    <div class="sales-heatmap-insight-label">Peak Day</div>
                    <div class="sales-heatmap-insight-value">
                        {{ $insights['peak_day'] }}
                    </div>
                </div>

                <div class="sales-heatmap-insight">
                    <div class="sales-heatmap-insight-label">Peak Hour</div>
                    <div class="sales-heatmap-insight-value">
                        {{ $insights['peak_hour'] }}
                    </div>
                </div>

                <div class="sales-heatmap-insight">
                    <div class="sales-heatmap-insight-label">Peak Value</div>
                    <div class="sales-heatmap-insight-value">
                        {{ $insights['peak_value'] }}
                    </div>
                </div>

                <div class="sales-heatmap-insight">
                    <div class="sales-heatmap-insight-label">Total Metric</div>
                    <div class="sales-heatmap-insight-value">
                        {{ $totalValue }}
                    </div>
                </div>
            </div>

            <div class="sales-heatmap-table-wrap">
                <div
                    class="sales-heatmap-grid"
                    style="grid-template-columns: 54px repeat({{ count($hours) }}, minmax(36px, 1fr));"
                >
                    <div></div>

                    @foreach ($hours as $hour)
                        <div class="sales-heatmap-axis">
                            {{ $hour }}
                        </div>
                    @endforeach

                    @foreach ($matrix as $row)
                        <div class="sales-heatmap-day">
                            {{ $row['day'] }}
                        </div>

                        @foreach ($row['cells'] as $cell)
                            @php
                                $intensity = (int) $cell['intensity'];

                                $level = match (true) {
                                    $intensity <= 0 => 0,
                                    $intensity <= 20 => 1,
                                    $intensity <= 40 => 2,
                                    $intensity <= 60 => 3,
                                    $intensity <= 80 => 4,
                                    default => 5,
                                };
                            @endphp

                            <div
                                class="sales-heatmap-cell level-{{ $level }}"
                                data-tooltip="{{ $row['day'] }} {{ $cell['hour'] }} • {{ $cell['label'] }}"
                            ></div>
                        @endforeach
                    @endforeach
                </div>

                <div class="sales-heatmap-legend">
                    <span>Rendah</span>
                    <div class="sales-heatmap-legend-bar"></div>
                    <span>Tinggi</span>
                </div>
            </div>
        </div>
    </x-filament::section>
</x-filament-widgets::widget>