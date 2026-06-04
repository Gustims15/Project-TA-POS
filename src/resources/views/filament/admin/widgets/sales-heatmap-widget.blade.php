<x-filament-widgets::widget>
    <x-filament::section>
        <style>
            .heatmap-pbi {
                min-height: 390px;
            }

            .heatmap-pbi-head {
                display: flex;
                align-items: flex-start;
                justify-content: space-between;
                gap: 14px;
                margin-bottom: 14px;
            }

            .heatmap-pbi-title {
                margin: 0;
                color: #0f172a;
                font-size: 15px;
                font-weight: 950;
                letter-spacing: -0.03em;
            }

            .heatmap-pbi-subtitle {
                margin: 5px 0 0;
                color: #64748b;
                font-size: 11px;
                font-weight: 700;
            }

            .heatmap-pbi-chip {
                padding: 7px 10px;
                border-radius: 999px;
                background: #ecfdf5;
                color: #047857;
                font-size: 10px;
                font-weight: 950;
                white-space: nowrap;
            }

            .heatmap-insights {
                display: grid;
                grid-template-columns: repeat(4, minmax(0, 1fr));
                gap: 9px;
                margin-bottom: 14px;
            }

            .heatmap-insight-box {
                border-radius: 15px;
                padding: 10px 11px;
                background: #f8fafc;
                border: 1px solid #e2e8f0;
            }

            .heatmap-insight-label {
                color: #64748b;
                font-size: 9px;
                font-weight: 950;
                text-transform: uppercase;
                letter-spacing: 0.08em;
            }

            .heatmap-insight-value {
                margin-top: 5px;
                color: #0f172a;
                font-size: 13px;
                font-weight: 950;
                white-space: nowrap;
                overflow: hidden;
                text-overflow: ellipsis;
            }

            .heatmap-pbi-canvas {
                border-radius: 20px;
                padding: 16px;
                background:
                    linear-gradient(180deg, rgba(248,250,252,0.95), rgba(255,255,255,1));
                border: 1px solid #e2e8f0;
                overflow-x: auto;
            }

            .heatmap-pbi-grid {
                min-width: 760px;
                display: grid;
                grid-template-columns: 58px repeat(15, minmax(34px, 1fr));
                gap: 7px;
            }

            .heatmap-pbi-hour {
                color: #64748b;
                font-size: 10px;
                font-weight: 950;
                text-align: center;
            }

            .heatmap-pbi-day {
                display: flex;
                align-items: center;
                justify-content: flex-start;
                color: #334155;
                font-size: 10px;
                font-weight: 950;
            }

            .heatmap-pbi-cell {
                position: relative;
                min-width: 34px;
                height: 32px;
                border-radius: 9px;
                background: #f8fafc;
                border: 1px solid rgba(15, 118, 110, 0.08);
                cursor: default;
                transition: 0.18s ease;
            }

            .heatmap-pbi-cell:hover {
                transform: translateY(-2px);
                box-shadow: 0 10px 22px rgba(15, 23, 42, 0.12);
                z-index: 12;
            }

            .heatmap-pbi-cell[data-level="0"] {
                background: #f8fafc;
            }

            .heatmap-pbi-cell[data-level="1"] {
                background: #d1fae5;
            }

            .heatmap-pbi-cell[data-level="2"] {
                background: #99f6e4;
            }

            .heatmap-pbi-cell[data-level="3"] {
                background: #5eead4;
            }

            .heatmap-pbi-cell[data-level="4"] {
                background: #14b8a6;
            }

            .heatmap-pbi-cell[data-level="5"] {
                background: #0f766e;
            }

            .heatmap-pbi-cell:hover::after {
                content: attr(data-tooltip);
                position: absolute;
                left: 50%;
                bottom: calc(100% + 9px);
                transform: translateX(-50%);
                z-index: 30;
                width: max-content;
                max-width: 240px;
                padding: 8px 10px;
                border-radius: 12px;
                background: #0f172a;
                color: white;
                font-size: 10px;
                font-weight: 850;
                line-height: 1.45;
                white-space: nowrap;
                box-shadow: 0 14px 30px rgba(15, 23, 42, 0.26);
            }

            .heatmap-pbi-footer {
                display: flex;
                align-items: center;
                justify-content: space-between;
                gap: 14px;
                margin-top: 14px;
                color: #64748b;
                font-size: 10px;
                font-weight: 850;
            }

            .heatmap-pbi-legend {
                display: flex;
                align-items: center;
                justify-content: flex-end;
                gap: 8px;
            }

            .heatmap-pbi-legend-box {
                width: 20px;
                height: 10px;
                border-radius: 999px;
            }

            .heatmap-pbi-legend-box.low {
                background: #d1fae5;
            }

            .heatmap-pbi-legend-box.mid {
                background: #5eead4;
            }

            .heatmap-pbi-legend-box.high {
                background: #0f766e;
            }

            @media (max-width: 900px) {
                .heatmap-insights {
                    grid-template-columns: repeat(2, minmax(0, 1fr));
                }

                .heatmap-pbi-grid {
                    min-width: 720px;
                }
            }
        </style>

        <div class="heatmap-pbi">
            <div class="heatmap-pbi-head">
                <div>
                    <h3 class="heatmap-pbi-title">
                        Sales Heatmap
                    </h3>

                    <p class="heatmap-pbi-subtitle">
                        Intensitas {{ strtolower($metricLabel) }} berdasarkan hari dan jam.
                    </p>
                </div>

                <span class="heatmap-pbi-chip">
                    Heatmap
                </span>
            </div>

            <div class="heatmap-insights">
                <div class="heatmap-insight-box">
                    <div class="heatmap-insight-label">Peak Day</div>
                    <div class="heatmap-insight-value">{{ $insights['peak_day'] }}</div>
                </div>

                <div class="heatmap-insight-box">
                    <div class="heatmap-insight-label">Peak Hour</div>
                    <div class="heatmap-insight-value">{{ $insights['peak_hour'] }}</div>
                </div>

                <div class="heatmap-insight-box">
                    <div class="heatmap-insight-label">Peak Value</div>
                    <div class="heatmap-insight-value">{{ $insights['peak_value'] }}</div>
                </div>

                <div class="heatmap-insight-box">
                    <div class="heatmap-insight-label">Quiet Time</div>
                    <div class="heatmap-insight-value">
                        {{ $insights['quiet_day'] }} {{ $insights['quiet_hour'] }}
                    </div>
                </div>
            </div>

            <div class="heatmap-pbi-canvas">
                <div class="heatmap-pbi-grid">
                    <div></div>

                    @foreach ($hours as $hour)
                        <div class="heatmap-pbi-hour">
                            {{ $hour }}
                        </div>
                    @endforeach

                    @foreach ($matrix as $row)
                        <div class="heatmap-pbi-day">
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
                                class="heatmap-pbi-cell"
                                data-level="{{ $level }}"
                                data-tooltip="{{ $row['day'] }} {{ $cell['hour'] }} - {{ $cell['label'] }}"
                            ></div>
                        @endforeach
                    @endforeach
                </div>
            </div>

            <div class="heatmap-pbi-footer">
                <span>{{ $metricLabel }} intensity</span>

                <div class="heatmap-pbi-legend">
                    <span>Rendah</span>
                    <span class="heatmap-pbi-legend-box low"></span>
                    <span class="heatmap-pbi-legend-box mid"></span>
                    <span class="heatmap-pbi-legend-box high"></span>
                    <span>Tinggi</span>
                </div>
            </div>
        </div>
    </x-filament::section>
</x-filament-widgets::widget>