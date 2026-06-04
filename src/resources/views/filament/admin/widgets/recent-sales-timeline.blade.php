<x-filament-widgets::widget>
    <x-filament::section>
        <style>
            .recent-pbi {
                min-height: 390px;
            }

            .recent-pbi-head {
                display: flex;
                align-items: flex-start;
                justify-content: space-between;
                gap: 14px;
                margin-bottom: 16px;
            }

            .recent-pbi-title {
                margin: 0;
                color: #0f172a;
                font-size: 15px;
                font-weight: 950;
                letter-spacing: -0.03em;
            }

            .recent-pbi-subtitle {
                margin: 5px 0 0;
                color: #64748b;
                font-size: 11px;
                font-weight: 700;
            }

            .recent-pbi-chip {
                padding: 7px 10px;
                border-radius: 999px;
                background: #ecfdf5;
                color: #047857;
                font-size: 10px;
                font-weight: 950;
                white-space: nowrap;
            }

            .recent-pbi-list {
                display: grid;
                gap: 10px;
            }

            .recent-pbi-row {
                display: grid;
                grid-template-columns: 46px minmax(0, 1fr);
                gap: 12px;
                align-items: stretch;
            }

            .recent-pbi-time {
                position: relative;
                display: flex;
                flex-direction: column;
                align-items: center;
                color: #64748b;
                font-size: 10px;
                font-weight: 950;
                line-height: 1.2;
                padding-top: 4px;
            }

            .recent-pbi-time::after {
                content: "";
                width: 1px;
                flex: 1;
                margin-top: 7px;
                background: #dbeafe;
            }

            .recent-pbi-dot {
                width: 12px;
                height: 12px;
                margin-top: 6px;
                border-radius: 999px;
                background: #0f766e;
                border: 3px solid #ccfbf1;
                box-shadow: 0 8px 18px rgba(15, 118, 110, 0.22);
            }

            .recent-pbi-card {
                border-radius: 16px;
                padding: 11px 12px;
                background:
                    linear-gradient(135deg, rgba(248,250,252,0.98), rgba(255,255,255,1));
                border: 1px solid #e2e8f0;
                transition: 0.22s ease;
            }

            .recent-pbi-card:hover {
                transform: translateY(-2px);
                box-shadow: 0 16px 34px rgba(15, 23, 42, 0.08);
                border-color: #bfdbfe;
            }

            .recent-pbi-top {
                display: flex;
                align-items: center;
                justify-content: space-between;
                gap: 10px;
            }

            .recent-pbi-code {
                color: #0f172a;
                font-size: 12px;
                font-weight: 950;
                white-space: nowrap;
                overflow: hidden;
                text-overflow: ellipsis;
            }

            .recent-pbi-status {
                display: inline-flex;
                align-items: center;
                gap: 5px;
                padding: 5px 8px;
                border-radius: 999px;
                background: #dcfce7;
                color: #15803d;
                font-size: 9px;
                font-weight: 950;
                white-space: nowrap;
            }

            .recent-pbi-status::before {
                content: "";
                width: 6px;
                height: 6px;
                border-radius: 999px;
                background: #16a34a;
            }

            .recent-pbi-main {
                display: grid;
                grid-template-columns: minmax(0, 1fr) auto;
                align-items: end;
                gap: 12px;
                margin-top: 8px;
            }

            .recent-pbi-total {
                color: #0f766e;
                font-size: 18px;
                line-height: 1;
                font-weight: 950;
                letter-spacing: -0.045em;
            }

            .recent-pbi-meta {
                color: #64748b;
                font-size: 10px;
                font-weight: 850;
                white-space: nowrap;
            }

            .recent-pbi-track {
                width: 100%;
                height: 8px;
                margin-top: 10px;
                border-radius: 999px;
                overflow: hidden;
                background: #e2e8f0;
            }

            .recent-pbi-fill {
                height: 100%;
                min-width: 4px;
                border-radius: 999px;
                background: linear-gradient(90deg, #0f766e, #14b8a6);
            }

            .recent-pbi-empty {
                min-height: 280px;
                display: flex;
                align-items: center;
                justify-content: center;
                border-radius: 18px;
                background: #f8fafc;
                border: 1px dashed #cbd5e1;
                color: #64748b;
                text-align: center;
                font-size: 12px;
                font-weight: 800;
                line-height: 1.6;
                padding: 18px;
            }
        </style>

        <div class="recent-pbi">
            <div class="recent-pbi-head">
                <div>
                    <h3 class="recent-pbi-title">
                        Recent Sales Timeline
                    </h3>

                    <p class="recent-pbi-subtitle">
                        Timeline transaksi terbaru pada {{ strtolower($periodLabel) }}.
                    </p>
                </div>

                <span class="recent-pbi-chip">
                    Live Sales
                </span>
            </div>

            @if ($orders->isNotEmpty())
                <div class="recent-pbi-list">
                    @foreach ($orders as $order)
                        @php
                            $orderDate = $order->ordered_at ?? $order->created_at;
                            $width = $maxRevenue > 0 ? ((int) $order->total_price / $maxRevenue) * 100 : 0;
                        @endphp

                        <div class="recent-pbi-row">
                            <div class="recent-pbi-time">
                                <span>{{ $orderDate?->format('H:i') }}</span>
                                <span class="recent-pbi-dot"></span>
                            </div>

                            <div class="recent-pbi-card">
                                <div class="recent-pbi-top">
                                    <div class="recent-pbi-code">
                                        {{ $order->order_code }}
                                    </div>

                                    <span class="recent-pbi-status">
                                        {{ $order->status }}
                                    </span>
                                </div>

                                <div class="recent-pbi-main">
                                    <div class="recent-pbi-total">
                                        Rp {{ number_format((int) $order->total_price, 0, ',', '.') }}
                                    </div>

                                    <div class="recent-pbi-meta">
                                        {{ number_format((int) $order->total_item, 0, ',', '.') }} item
                                    </div>
                                </div>

                                <div class="recent-pbi-track">
                                    <div
                                        class="recent-pbi-fill"
                                        style="width: {{ max($width, 4) }}%;"
                                    ></div>
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>
            @else
                <div class="recent-pbi-empty">
                    Belum ada transaksi selesai pada periode ini.
                </div>
            @endif
        </div>
    </x-filament::section>
</x-filament-widgets::widget>