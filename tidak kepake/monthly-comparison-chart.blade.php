<x-filament-widgets::widget>
    <x-filament::section>
        <style>
            .monthly-comparison-pbi {
                min-height: 380px;
            }

            .monthly-comparison-head {
                display: flex;
                align-items: flex-start;
                justify-content: space-between;
                gap: 14px;
                margin-bottom: 16px;
            }

            .monthly-comparison-title {
                margin: 0;
                color: #0f172a;
                font-size: 15px;
                font-weight: 950;
                letter-spacing: -0.03em;
            }

            .monthly-comparison-subtitle {
                margin: 5px 0 0;
                color: #64748b;
                font-size: 11px;
                font-weight: 700;
            }

            .monthly-comparison-chip {
                padding: 7px 10px;
                border-radius: 999px;
                background: #eff6ff;
                color: #1d4ed8;
                font-size: 10px;
                font-weight: 950;
                white-space: nowrap;
            }

            .monthly-comparison-summary {
                display: grid;
                grid-template-columns: 1fr;
                gap: 10px;
                margin-bottom: 14px;
            }

            .monthly-comparison-box {
                border-radius: 16px;
                padding: 12px 13px;
                background: #f8fafc;
                border: 1px solid #e2e8f0;
            }

            .monthly-comparison-box-label {
                color: #64748b;
                font-size: 10px;
                font-weight: 900;
                text-transform: uppercase;
                letter-spacing: 0.08em;
            }

            .monthly-comparison-box-value {
                margin-top: 5px;
                color: #0f172a;
                font-size: 18px;
                font-weight: 950;
                letter-spacing: -0.04em;
            }

            .monthly-comparison-chart {
                min-height: 235px;
                border-radius: 20px;
                padding: 16px 12px 10px;
                background:
                    linear-gradient(180deg, rgba(248,250,252,0.95), rgba(255,255,255,1));
                border: 1px solid #e2e8f0;
            }

            .monthly-comparison-bars {
                height: 190px;
                display: grid;
                grid-template-columns: repeat({{ max(count($items), 1) }}, minmax(0, 1fr));
                align-items: end;
                gap: 12px;
                padding: 0 4px;
                background-image: linear-gradient(to top, rgba(148,163,184,0.18) 1px, transparent 1px);
                background-size: 100% 25%;
            }

            .monthly-comparison-bar-wrap {
                height: 100%;
                display: flex;
                flex-direction: column;
                align-items: center;
                justify-content: flex-end;
                gap: 7px;
                min-width: 0;
            }

            .monthly-comparison-value {
                color: #334155;
                font-size: 10px;
                font-weight: 900;
                white-space: nowrap;
            }

            .monthly-comparison-bar {
                width: 100%;
                max-width: 42px;
                min-height: 2px;
                border-radius: 8px 8px 2px 2px;
                background: linear-gradient(180deg, #2563eb, #38bdf8);
                box-shadow: 0 8px 18px rgba(37, 99, 235, 0.16);
                position: relative;
            }

            .monthly-comparison-bar:hover::after {
                content: attr(data-tooltip);
                position: absolute;
                left: 50%;
                bottom: calc(100% + 10px);
                transform: translateX(-50%);
                z-index: 20;
                width: max-content;
                max-width: 200px;
                padding: 7px 9px;
                border-radius: 10px;
                background: #0f172a;
                color: white;
                font-size: 10px;
                font-weight: 850;
                white-space: nowrap;
                box-shadow: 0 12px 28px rgba(15, 23, 42, 0.25);
            }

            .monthly-comparison-axis {
                display: grid;
                grid-template-columns: repeat({{ max(count($items), 1) }}, minmax(0, 1fr));
                gap: 12px;
                margin-top: 8px;
                padding: 0 4px;
            }

            .monthly-comparison-axis span {
                color: #64748b;
                font-size: 10px;
                font-weight: 900;
                text-align: center;
            }
        </style>

        <div class="monthly-comparison-pbi">
            <div class="monthly-comparison-head">
                <div>
                    <h3 class="monthly-comparison-title">
                        Monthly Comparison
                    </h3>

                    <p class="monthly-comparison-subtitle">
                        Perbandingan {{ strtolower($metricLabel) }} dalam 6 bulan terakhir.
                    </p>
                </div>

                <span class="monthly-comparison-chip">
                    Compare
                </span>
            </div>

            <div class="monthly-comparison-summary">
                <div class="monthly-comparison-box">
                    <div class="monthly-comparison-box-label">Bulan Terbaik</div>
                    <div class="monthly-comparison-box-value">
                        {{ $bestMonth }} · {{ $bestValue }}
                    </div>
                </div>
            </div>

            <div class="monthly-comparison-chart">
                <div class="monthly-comparison-bars">
                    @foreach ($items as $item)
                        <div class="monthly-comparison-bar-wrap">
                            <div class="monthly-comparison-value">
                                {{ $item['formatted'] }}
                            </div>

                            <div
                                class="monthly-comparison-bar"
                                style="height: {{ $item['height'] }}%;"
                                data-tooltip="{{ $item['full_label'] }} - {{ $item['formatted'] }}"
                            ></div>
                        </div>
                    @endforeach
                </div>

                <div class="monthly-comparison-axis">
                    @foreach ($items as $item)
                        <span>{{ $item['label'] }}</span>
                    @endforeach
                </div>
            </div>
        </div>
    </x-filament::section>
</x-filament-widgets::widget>