<x-filament-widgets::widget>
    <x-filament::section>
        <style>
            .pbi-card {
                min-height: 360px;
            }

            .pbi-card-head {
                display: flex;
                justify-content: space-between;
                gap: 14px;
                margin-bottom: 18px;
            }

            .pbi-title {
                margin: 0;
                color: #0f172a;
                font-size: 15px;
                font-weight: 950;
                letter-spacing: -0.03em;
            }

            .pbi-subtitle {
                margin: 5px 0 0;
                color: #64748b;
                font-size: 11px;
                font-weight: 700;
            }

            .pbi-chip {
                height: fit-content;
                padding: 7px 10px;
                border-radius: 999px;
                background: #ecfdf5;
                color: #047857;
                font-size: 10px;
                font-weight: 950;
                white-space: nowrap;
            }

            .peak-summary {
                display: grid;
                grid-template-columns: repeat(2, minmax(0, 1fr));
                gap: 10px;
                margin-bottom: 18px;
            }

            .peak-summary-box {
                border-radius: 16px;
                padding: 12px 13px;
                background: #f8fafc;
                border: 1px solid #e2e8f0;
            }

            .peak-summary-label {
                color: #64748b;
                font-size: 10px;
                font-weight: 900;
                text-transform: uppercase;
                letter-spacing: 0.08em;
            }

            .peak-summary-value {
                margin-top: 5px;
                color: #0f172a;
                font-size: 18px;
                font-weight: 950;
                letter-spacing: -0.04em;
            }

            .peak-chart {
                position: relative;
                min-height: 210px;
                padding: 14px 8px 4px;
                border-radius: 18px;
                background:
                    linear-gradient(180deg, rgba(248,250,252,0.9), rgba(255,255,255,1));
                border: 1px solid #e2e8f0;
            }

            .peak-grid {
                position: absolute;
                inset: 14px 8px 38px 8px;
                background-image: linear-gradient(to top, rgba(148,163,184,0.22) 1px, transparent 1px);
                background-size: 100% 25%;
                pointer-events: none;
            }

            .peak-bars {
                position: relative;
                z-index: 2;
                height: 180px;
                display: grid;
                grid-template-columns: repeat({{ max(count($items), 1) }}, minmax(18px, 1fr));
                align-items: end;
                gap: 8px;
            }

            .peak-bar-wrap {
                height: 100%;
                display: flex;
                flex-direction: column;
                justify-content: flex-end;
                align-items: center;
                gap: 7px;
                min-width: 0;
            }

            .peak-bar {
                width: 100%;
                max-width: 28px;
                min-height: 2px;
                border-radius: 6px 6px 2px 2px;
                background: linear-gradient(180deg, #0f766e, #14b8a6);
                box-shadow: 0 8px 18px rgba(15,118,110,0.18);
                position: relative;
            }

            .peak-bar:hover::after {
                content: attr(data-tooltip);
                position: absolute;
                left: 50%;
                bottom: calc(100% + 9px);
                transform: translateX(-50%);
                width: max-content;
                padding: 7px 9px;
                border-radius: 10px;
                background: #0f172a;
                color: white;
                font-size: 10px;
                font-weight: 800;
                white-space: nowrap;
                z-index: 10;
            }

            .peak-label {
                color: #64748b;
                font-size: 9px;
                font-weight: 850;
                white-space: nowrap;
                transform: rotate(-35deg);
                transform-origin: center top;
            }
        </style>

        <div class="pbi-card">
            <div class="pbi-card-head">
                <div>
                    <h3 class="pbi-title">Peak Sales Time</h3>
                    <p class="pbi-subtitle">
                        Distribusi {{ strtolower($metricLabel) }} berdasarkan waktu pada {{ strtolower($periodLabel) }}.
                    </p>
                </div>

                <span class="pbi-chip">Time Analysis</span>
            </div>

            <div class="peak-summary">
                <div class="peak-summary-box">
                    <div class="peak-summary-label">Peak Time</div>
                    <div class="peak-summary-value">{{ $peakLabel }}</div>
                </div>

                <div class="peak-summary-box">
                    <div class="peak-summary-label">Peak Value</div>
                    <div class="peak-summary-value">{{ $peakValue }}</div>
                </div>
            </div>

            <div class="peak-chart">
                <div class="peak-grid"></div>

                <div class="peak-bars">
                    @foreach ($items as $item)
                        <div class="peak-bar-wrap">
                            <div
                                class="peak-bar"
                                style="height: {{ $item['height'] }}%;"
                                data-tooltip="{{ $item['label'] }} - {{ $item['formatted'] }}"
                            ></div>

                            <div class="peak-label">
                                {{ $item['label'] }}
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>
        </div>
    </x-filament::section>
</x-filament-widgets::widget>