<x-filament-widgets::widget>
    <x-filament::section>
        <style>
            .monthly-trend-pbi {
                min-height: 380px;
            }

            .monthly-trend-head {
                display: flex;
                align-items: flex-start;
                justify-content: space-between;
                gap: 14px;
                margin-bottom: 16px;
            }

            .monthly-trend-title {
                margin: 0;
                color: #0f172a;
                font-size: 15px;
                font-weight: 950;
                letter-spacing: -0.03em;
            }

            .monthly-trend-subtitle {
                margin: 5px 0 0;
                color: #64748b;
                font-size: 11px;
                font-weight: 700;
            }

            .monthly-trend-chip {
                padding: 7px 10px;
                border-radius: 999px;
                background: #ecfdf5;
                color: #047857;
                font-size: 10px;
                font-weight: 950;
                white-space: nowrap;
            }

            .monthly-trend-summary {
                display: grid;
                grid-template-columns: repeat(2, minmax(0, 1fr));
                gap: 10px;
                margin-bottom: 14px;
            }

            .monthly-trend-box {
                border-radius: 16px;
                padding: 12px 13px;
                background: #f8fafc;
                border: 1px solid #e2e8f0;
            }

            .monthly-trend-box-label {
                color: #64748b;
                font-size: 10px;
                font-weight: 900;
                text-transform: uppercase;
                letter-spacing: 0.08em;
            }

            .monthly-trend-box-value {
                margin-top: 5px;
                color: #0f172a;
                font-size: 18px;
                font-weight: 950;
                letter-spacing: -0.04em;
            }

            .monthly-trend-growth {
                margin-top: 5px;
                font-size: 11px;
                font-weight: 900;
            }

            .monthly-trend-growth.up {
                color: #059669;
            }

            .monthly-trend-growth.down {
                color: #dc2626;
            }

            .monthly-trend-growth.neutral {
                color: #64748b;
            }

            .monthly-trend-chart-box {
                border-radius: 20px;
                padding: 14px 12px 10px;
                background:
                    linear-gradient(180deg, rgba(240,253,250,0.9), rgba(255,255,255,1)),
                    radial-gradient(circle at top right, rgba(20,184,166,0.12), transparent 32%);
                border: 1px solid #dbeafe;
                overflow: hidden;
            }

            .monthly-trend-svg {
                width: 100%;
                height: 285px;
                display: block;
                overflow: visible;
            }

            .monthly-trend-label {
                fill: #0f172a;
                font-size: 11px;
                font-weight: 900;
            }

            .monthly-trend-axis {
                display: grid;
                grid-template-columns: repeat({{ max(count($points), 1) }}, minmax(0, 1fr));
                gap: 4px;
                margin-top: 6px;
                padding: 0 10px;
            }

            .monthly-trend-axis span {
                color: #64748b;
                font-size: 10px;
                font-weight: 850;
                text-align: center;
                white-space: nowrap;
            }

            @media (max-width: 700px) {
                .monthly-trend-summary {
                    grid-template-columns: 1fr;
                }

                .monthly-trend-svg {
                    height: 240px;
                }

                .monthly-trend-label {
                    font-size: 9px;
                }
            }
        </style>

        <div class="monthly-trend-pbi">
            <div class="monthly-trend-head">
                <div>
                    <h3 class="monthly-trend-title">
                        Monthly {{ $metricLabel }} Trend
                    </h3>

                    <p class="monthly-trend-subtitle">
                        Tren {{ strtolower($metricLabel) }} dalam 12 bulan terakhir.
                    </p>
                </div>

                <span class="monthly-trend-chip">
                    Monthly Trend
                </span>
            </div>

            <div class="monthly-trend-summary">
                <div class="monthly-trend-box">
                    <div class="monthly-trend-box-label">Bulan Terbaru</div>
                    <div class="monthly-trend-box-value">{{ $currentValue }}</div>
                </div>

                <div class="monthly-trend-box">
                    <div class="monthly-trend-box-label">Perubahan</div>
                    <div class="monthly-trend-box-value">
                        {{ $growth['direction'] === 'up' ? '▲' : ($growth['direction'] === 'down' ? '▼' : '●') }}
                        {{ number_format((float) $growth['value'], 1, ',', '.') }}%
                    </div>

                    <div class="monthly-trend-growth {{ $growth['direction'] }}">
                        {{ $growth['label'] }}
                    </div>
                </div>
            </div>

            <div class="monthly-trend-chart-box">
                <svg
                    class="monthly-trend-svg"
                    viewBox="0 0 {{ $chartWidth }} {{ $chartHeight }}"
                    preserveAspectRatio="none"
                >
                    <defs>
                        <linearGradient id="monthlyTrendAreaGradient" x1="0" x2="0" y1="0" y2="1">
                            <stop offset="0%" stop-color="#0f766e" stop-opacity="0.36" />
                            <stop offset="100%" stop-color="#0f766e" stop-opacity="0.08" />
                        </linearGradient>
                    </defs>

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
                            fill="url(#monthlyTrendAreaGradient)"
                        />
                    @endif

                    @if ($linePath !== '')
                        <path
                            d="{{ $linePath }}"
                            fill="none"
                            stroke="#064e3b"
                            stroke-width="5"
                            stroke-linecap="round"
                            stroke-linejoin="round"
                        />
                    @endif

                    @foreach ($points as $point)
                        @php
                            $labelY = $point['y'] - 14;

                            if ($labelY < 14) {
                                $labelY = $point['y'] + 24;
                            }
                        @endphp

                        <circle
                            cx="{{ $point['x'] }}"
                            cy="{{ $point['y'] }}"
                            r="7"
                            fill="#064e3b"
                            stroke="#ffffff"
                            stroke-width="3"
                        />

                        <text
                            x="{{ $point['x'] }}"
                            y="{{ $labelY }}"
                            text-anchor="middle"
                            class="monthly-trend-label"
                        >
                            {{ $point['formatted'] }}
                        </text>
                    @endforeach
                </svg>

                <div class="monthly-trend-axis">
                    @foreach ($points as $point)
                        <span>{{ $point['label'] }}</span>
                    @endforeach
                </div>
            </div>
        </div>
    </x-filament::section>
</x-filament-widgets::widget>