<x-filament-widgets::widget>
    @once
        <style>
            .pbi-widget-card {
                overflow: hidden;
                border-radius: 20px;
                background: rgba(255, 255, 255, 0.96);
                border: 1px solid rgba(226, 232, 240, 0.9);
                box-shadow: 0 16px 38px rgba(15, 23, 42, 0.08);
            }

            .pbi-widget-inner {
                padding: 14px;
            }

            .pbi-widget-header {
                display: flex;
                align-items: flex-start;
                justify-content: space-between;
                gap: 12px;
                margin-bottom: 10px;
            }

            .pbi-widget-title {
                margin: 0;
                color: #0f172a;
                font-size: 15px;
                font-weight: 900;
                line-height: 1.15;
                letter-spacing: -0.035em;
            }

            .pbi-widget-subtitle {
                margin-top: 3px;
                color: #64748b;
                font-size: 11px;
                font-weight: 700;
                line-height: 1.35;
            }

            .pbi-chip {
                display: inline-flex;
                align-items: center;
                justify-content: center;
                white-space: nowrap;
                border-radius: 999px;
                padding: 6px 10px;
                color: #047857;
                background: #ecfdf5;
                border: 1px solid #d1fae5;
                font-size: 10px;
                font-weight: 900;
            }

            .pbi-summary-grid {
                display: grid;
                grid-template-columns: repeat(2, minmax(0, 1fr));
                gap: 8px;
                margin-bottom: 10px;
            }

            .pbi-summary-box {
                min-height: 58px;
                border-radius: 14px;
                padding: 9px 10px;
                background: linear-gradient(180deg, #ffffff, #f8fafc);
                border: 1px solid rgba(226, 232, 240, 0.9);
            }

            .pbi-summary-label {
                color: #94a3b8;
                font-size: 9px;
                font-weight: 900;
                letter-spacing: 0.08em;
                text-transform: uppercase;
            }

            .pbi-summary-value {
                margin-top: 5px;
                color: #0f172a;
                font-size: 15px;
                font-weight: 950;
                line-height: 1.1;
                letter-spacing: -0.04em;
            }

            .pbi-summary-note {
                margin-top: 3px;
                color: #047857;
                font-size: 10px;
                font-weight: 900;
            }

            .pbi-chart-box {
                height: 205px;
                border-radius: 18px;
                padding: 8px 10px 4px;
                background:
                    linear-gradient(180deg, rgba(240, 253, 250, 0.72), rgba(255, 255, 255, 0.92));
                border: 1px solid rgba(209, 250, 229, 0.9);
                overflow: hidden;
            }

            .pbi-svg {
                width: 100%;
                height: 100%;
                display: block;
            }

            .pbi-axis-label {
                fill: #64748b;
                font-size: 10px;
                font-weight: 800;
            }

            .pbi-point-label {
                fill: #0f172a;
                font-size: 10px;
                font-weight: 900;
            }

            .pbi-grid-line {
                stroke: rgba(148, 163, 184, 0.22);
                stroke-width: 1;
            }

            .pbi-tooltip-dot {
                fill: #065f46;
                stroke: #ffffff;
                stroke-width: 3;
            }

            @media (max-width: 768px) {
                .pbi-summary-grid {
                    grid-template-columns: 1fr;
                }

                .pbi-chart-box {
                    height: 190px;
                }
            }
        </style>
    @endonce

    @php
        $growthDirection = $growth['direction'] ?? 'flat';

        $growthIcon = match ($growthDirection) {
            'up' => '▲',
            'down' => '▼',
            default => '●',
        };

        $growthColor = match ($growthDirection) {
            'up' => '#047857',
            'down' => '#dc2626',
            default => '#64748b',
        };

        $baselineY = ($paddingTop ?? 32) + ($plotHeight ?? 180);
    @endphp

    <div class="pbi-widget-card monthly-trend-chart">
        <div class="pbi-widget-inner">
            <div class="pbi-widget-header">
                <div>
                    <h3 class="pbi-widget-title">Monthly {{ $metricLabel ?? 'Trend' }} Trend</h3>
                    <div class="pbi-widget-subtitle">
                        Tren {{ strtolower($metricLabel ?? 'data') }} dalam 12 bulan terakhir.
                    </div>
                </div>

                <span class="pbi-chip">
                    {{ $periodLabel ?? 'Monthly Trend' }}
                </span>
            </div>

            <div class="pbi-summary-grid">
                <div class="pbi-summary-box">
                    <div class="pbi-summary-label">Bulan terbaru</div>
                    <div class="pbi-summary-value">{{ $currentValue ?? '-' }}</div>
                </div>

                <div class="pbi-summary-box">
                    <div class="pbi-summary-label">Perubahan</div>
                    <div class="pbi-summary-value" style="color: {{ $growthColor }}">
                        {{ $growthIcon }} {{ $growth['label'] ?? '0%' }}
                    </div>
                    <div class="pbi-summary-note">
                        dibanding periode sebelumnya
                    </div>
                </div>
            </div>

            <div class="pbi-chart-box">
                <svg
                    class="pbi-svg"
                    viewBox="0 0 {{ $chartWidth ?? 860 }} {{ $chartHeight ?? 260 }}"
                    role="img"
                    aria-label="Monthly trend chart"
                >
                    <defs>
                        <linearGradient id="monthlyAreaGradient" x1="0" y1="0" x2="0" y2="1">
                            <stop offset="0%" stop-color="#059669" stop-opacity="0.24" />
                            <stop offset="100%" stop-color="#059669" stop-opacity="0.02" />
                        </linearGradient>

                        <linearGradient id="monthlyLineGradient" x1="0" y1="0" x2="1" y2="0">
                            <stop offset="0%" stop-color="#047857" />
                            <stop offset="100%" stop-color="#064e3b" />
                        </linearGradient>
                    </defs>

                    @for ($i = 0; $i <= ($gridLines ?? 4); $i++)
                        @php
                            $y = ($paddingTop ?? 32) + (($plotHeight ?? 180) / max(($gridLines ?? 4), 1)) * $i;
                        @endphp

                        <line
                            x1="{{ $paddingLeft ?? 28 }}"
                            y1="{{ $y }}"
                            x2="{{ ($chartWidth ?? 860) - ($paddingRight ?? 28) }}"
                            y2="{{ $y }}"
                            class="pbi-grid-line"
                        />
                    @endfor

                    @if (! empty($areaPath))
                        <path
                            d="{{ $areaPath }}"
                            fill="url(#monthlyAreaGradient)"
                        />
                    @endif

                    @if (! empty($linePath))
                        <path
                            d="{{ $linePath }}"
                            fill="none"
                            stroke="url(#monthlyLineGradient)"
                            stroke-width="5"
                            stroke-linecap="round"
                            stroke-linejoin="round"
                        />
                    @endif

                    @foreach (($points ?? []) as $point)
                        <circle
                            cx="{{ $point['x'] }}"
                            cy="{{ $point['y'] }}"
                            r="6"
                            class="pbi-tooltip-dot"
                        />

                        @if (($point['value'] ?? 0) > 0)
                            <text
                                x="{{ $point['x'] }}"
                                y="{{ max(($point['y'] ?? 0) - 12, 15) }}"
                                text-anchor="middle"
                                class="pbi-point-label"
                            >
                                {{ $point['formatted'] ?? '' }}
                            </text>
                        @endif

                        <text
                            x="{{ $point['x'] }}"
                            y="{{ $baselineY + 28 }}"
                            text-anchor="middle"
                            class="pbi-axis-label"
                        >
                            {{ $point['label'] ?? '' }}
                        </text>
                    @endforeach
                </svg>
            </div>
        </div>
    </div>
</x-filament-widgets::widget>