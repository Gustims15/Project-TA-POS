<x-filament-widgets::widget>
    <x-filament::section>
        <style>
            .stock-gauge-pbi {
                min-height: 390px;
            }

            .stock-gauge-head {
                display: flex;
                justify-content: space-between;
                gap: 14px;
                margin-bottom: 18px;
            }

            .stock-gauge-title {
                margin: 0;
                color: #0f172a;
                font-size: 15px;
                font-weight: 950;
                letter-spacing: -0.03em;
            }

            .stock-gauge-subtitle {
                margin: 5px 0 0;
                color: #64748b;
                font-size: 11px;
                font-weight: 700;
            }

            .stock-gauge-chip {
                height: fit-content;
                padding: 7px 10px;
                border-radius: 999px;
                font-size: 10px;
                font-weight: 950;
                white-space: nowrap;
            }

            .stock-gauge-chip.safe {
                background: #ecfdf5;
                color: #047857;
            }

            .stock-gauge-chip.warning {
                background: #fef9c3;
                color: #a16207;
            }

            .stock-gauge-chip.danger {
                background: #fef2f2;
                color: #b91c1c;
            }

            .stock-gauge-visual {
                position: relative;
                height: 190px;
                display: flex;
                align-items: flex-end;
                justify-content: center;
                margin-top: 6px;
            }

            .stock-gauge-arc {
                width: 230px;
                height: 115px;
                border-radius: 230px 230px 0 0;
                background:
                    conic-gradient(
                        from 270deg,
                        #0f766e 0deg,
                        #14b8a6 {{ $healthScore * 1.8 }}deg,
                        #e2e8f0 {{ $healthScore * 1.8 }}deg,
                        #e2e8f0 180deg,
                        transparent 180deg,
                        transparent 360deg
                    );
                position: relative;
                overflow: hidden;
            }

            .stock-gauge-arc::after {
                content: "";
                position: absolute;
                left: 24px;
                right: 24px;
                bottom: 0;
                height: 91px;
                border-radius: 182px 182px 0 0;
                background: white;
            }

            .stock-gauge-score {
                position: absolute;
                bottom: 12px;
                text-align: center;
                z-index: 2;
            }

            .stock-gauge-score strong {
                display: block;
                color: #0f172a;
                font-size: 34px;
                line-height: 1;
                font-weight: 950;
                letter-spacing: -0.06em;
            }

            .stock-gauge-score span {
                display: block;
                margin-top: 5px;
                color: #64748b;
                font-size: 11px;
                font-weight: 900;
                text-transform: uppercase;
                letter-spacing: 0.08em;
            }

            .stock-segment {
                display: grid;
                gap: 10px;
                margin-top: 18px;
            }

            .stock-segment-row {
                display: grid;
                grid-template-columns: 86px minmax(0, 1fr) 52px;
                gap: 10px;
                align-items: center;
            }

            .stock-segment-name {
                color: #334155;
                font-size: 11px;
                font-weight: 900;
            }

            .stock-segment-track {
                height: 11px;
                border-radius: 999px;
                background: #e2e8f0;
                overflow: hidden;
            }

            .stock-segment-fill {
                height: 100%;
                min-width: 3px;
                border-radius: 999px;
            }

            .stock-segment-fill.safe {
                background: linear-gradient(90deg, #0f766e, #14b8a6);
            }

            .stock-segment-fill.low {
                background: linear-gradient(90deg, #f97316, #fb923c);
            }

            .stock-segment-fill.out {
                background: linear-gradient(90deg, #dc2626, #ef4444);
            }

            .stock-segment-value {
                color: #64748b;
                font-size: 10px;
                font-weight: 900;
                text-align: right;
            }

            .stock-gauge-footer {
                display: grid;
                grid-template-columns: repeat(3, minmax(0, 1fr));
                gap: 10px;
                margin-top: 16px;
            }

            .stock-mini-box {
                border-radius: 14px;
                padding: 10px;
                background: #f8fafc;
                border: 1px solid #e2e8f0;
                text-align: center;
            }

            .stock-mini-box strong {
                display: block;
                color: #0f172a;
                font-size: 18px;
                font-weight: 950;
            }

            .stock-mini-box span {
                display: block;
                margin-top: 3px;
                color: #64748b;
                font-size: 9px;
                font-weight: 900;
                text-transform: uppercase;
                letter-spacing: 0.07em;
            }
        </style>

        <div class="stock-gauge-pbi">
            <div class="stock-gauge-head">
                <div>
                    <h3 class="stock-gauge-title">
                        Stock Health Gauge
                    </h3>

                    <p class="stock-gauge-subtitle">
                        Kondisi kesehatan stok produk berdasarkan jumlah aman, rendah, dan habis.
                    </p>
                </div>

                <span class="stock-gauge-chip {{ $statusClass }}">
                    {{ $status }}
                </span>
            </div>

            <div class="stock-gauge-visual">
                <div class="stock-gauge-arc"></div>

                <div class="stock-gauge-score">
                    <strong>{{ $healthScore }}%</strong>
                    <span>Health Score</span>
                </div>
            </div>

            <div class="stock-segment">
                <div class="stock-segment-row">
                    <div class="stock-segment-name">Aman</div>
                    <div class="stock-segment-track">
                        <div
                            class="stock-segment-fill safe"
                            style="width: {{ max($safePercentage, $safeStock > 0 ? 5 : 0) }}%;"
                        ></div>
                    </div>
                    <div class="stock-segment-value">{{ $safePercentage }}%</div>
                </div>

                <div class="stock-segment-row">
                    <div class="stock-segment-name">Rendah</div>
                    <div class="stock-segment-track">
                        <div
                            class="stock-segment-fill low"
                            style="width: {{ max($lowPercentage, $lowStock > 0 ? 5 : 0) }}%;"
                        ></div>
                    </div>
                    <div class="stock-segment-value">{{ $lowPercentage }}%</div>
                </div>

                <div class="stock-segment-row">
                    <div class="stock-segment-name">Habis</div>
                    <div class="stock-segment-track">
                        <div
                            class="stock-segment-fill out"
                            style="width: {{ max($outPercentage, $outOfStock > 0 ? 5 : 0) }}%;"
                        ></div>
                    </div>
                    <div class="stock-segment-value">{{ $outPercentage }}%</div>
                </div>
            </div>

            <div class="stock-gauge-footer">
                <div class="stock-mini-box">
                    <strong>{{ number_format($safeStock, 0, ',', '.') }}</strong>
                    <span>Aman</span>
                </div>

                <div class="stock-mini-box">
                    <strong>{{ number_format($lowStock, 0, ',', '.') }}</strong>
                    <span>Rendah</span>
                </div>

                <div class="stock-mini-box">
                    <strong>{{ number_format($outOfStock, 0, ',', '.') }}</strong>
                    <span>Habis</span>
                </div>
            </div>
        </div>
    </x-filament::section>
</x-filament-widgets::widget>