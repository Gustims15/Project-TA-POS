<x-filament-widgets::widget>
    <x-filament::section>
        <style>
            .latest-transactions-card {
                min-height: 420px;
            }

            .latest-transactions-head {
                display: flex;
                justify-content: space-between;
                align-items: flex-start;
                gap: 12px;
                margin-bottom: 16px;
            }

            .latest-transactions-title {
                margin: 0;
                color: #0f172a;
                font-size: 15px;
                font-weight: 950;
                letter-spacing: -0.03em;
            }

            .latest-transactions-subtitle {
                margin: 5px 0 0;
                color: #64748b;
                font-size: 11px;
                font-weight: 650;
                line-height: 1.45;
            }

            .latest-transactions-pill {
                border-radius: 999px;
                padding: 8px 10px;
                color: #166534;
                background: rgba(220, 252, 231, 0.86);
                border: 1px solid rgba(34, 197, 94, 0.22);
                font-size: 10px;
                font-weight: 950;
                white-space: nowrap;
            }

            .latest-transactions-summary {
                display: grid;
                grid-template-columns: repeat(2, minmax(0, 1fr));
                gap: 10px;
                margin-bottom: 15px;
            }

            .latest-transactions-summary-box {
                border-radius: 17px;
                padding: 12px;
                background: rgba(248, 250, 252, 0.86);
                border: 1px solid rgba(226, 232, 240, 0.86);
            }

            .latest-transactions-summary-label {
                color: #94a3b8;
                font-size: 9px;
                font-weight: 950;
                text-transform: uppercase;
                letter-spacing: 0.08em;
            }

            .latest-transactions-summary-value {
                margin-top: 6px;
                color: #0f172a;
                font-size: 14px;
                font-weight: 950;
                letter-spacing: -0.035em;
            }

            .latest-transactions-list {
                display: grid;
                gap: 10px;
            }

            .latest-transactions-item {
                border-radius: 17px;
                padding: 12px;
                background: rgba(255, 255, 255, 0.92);
                border: 1px solid rgba(226, 232, 240, 0.8);
                box-shadow: 0 10px 24px rgba(15, 23, 42, 0.045);
            }

            .latest-transactions-row {
                display: flex;
                justify-content: space-between;
                align-items: flex-start;
                gap: 10px;
            }

            .latest-transactions-code {
                color: #0f172a;
                font-size: 12px;
                font-weight: 950;
            }

            .latest-transactions-time {
                margin-top: 4px;
                color: #94a3b8;
                font-size: 10px;
                font-weight: 800;
            }

            .latest-transactions-total {
                color: #0f172a;
                font-size: 12px;
                font-weight: 950;
                text-align: right;
                white-space: nowrap;
            }

            .latest-transactions-items {
                margin-top: 4px;
                color: #64748b;
                font-size: 10px;
                font-weight: 800;
                text-align: right;
            }

            .latest-transactions-bar-wrap {
                margin-top: 10px;
                height: 7px;
                overflow: hidden;
                border-radius: 999px;
                background: rgba(226, 232, 240, 0.94);
            }

            .latest-transactions-bar {
                height: 100%;
                border-radius: inherit;
                background: linear-gradient(90deg, #22c55e, #f97316);
            }

            .latest-transactions-status {
                display: inline-flex;
                margin-top: 8px;
                border-radius: 999px;
                padding: 5px 8px;
                color: #166534;
                background: rgba(220, 252, 231, 0.9);
                font-size: 9px;
                font-weight: 950;
            }

            .latest-transactions-empty {
                min-height: 250px;
                display: grid;
                place-items: center;
                border-radius: 18px;
                color: #94a3b8;
                background: rgba(248, 250, 252, 0.78);
                border: 1px dashed rgba(148, 163, 184, 0.48);
                text-align: center;
                font-size: 12px;
                font-weight: 800;
            }
        </style>

        <div class="latest-transactions-card">
            <div class="latest-transactions-head">
                <div>
                    <h3 class="latest-transactions-title">Latest Transactions</h3>
                    <p class="latest-transactions-subtitle">
                        Transaksi selesai terbaru pada {{ strtolower($periodLabel) }}.
                    </p>
                </div>

                <div class="latest-transactions-pill">Live Sales</div>
            </div>

            <div class="latest-transactions-summary">
                <div class="latest-transactions-summary-box">
                    <div class="latest-transactions-summary-label">Total Orders</div>
                    <div class="latest-transactions-summary-value">
                        {{ number_format($totalOrders, 0, ',', '.') }}
                    </div>
                </div>

                <div class="latest-transactions-summary-box">
                    <div class="latest-transactions-summary-label">Revenue</div>
                    <div class="latest-transactions-summary-value">
                        Rp {{ number_format($totalRevenue, 0, ',', '.') }}
                    </div>
                </div>
            </div>

            @if ($orders->isNotEmpty())
                <div class="latest-transactions-list">
                    @foreach ($orders as $order)
                        @php
                            $orderDate = $order->ordered_at ?? $order->created_at;
                            $width = $maxRevenue > 0
                                ? min(((int) $order->total_price / $maxRevenue) * 100, 100)
                                : 0;
                        @endphp

                        <div class="latest-transactions-item">
                            <div class="latest-transactions-row">
                                <div>
                                    <div class="latest-transactions-code">
                                        {{ $order->order_code }}
                                    </div>
                                    <div class="latest-transactions-time">
                                        {{ $orderDate?->format('d M Y, H:i') }}
                                    </div>
                                    <div class="latest-transactions-status">
                                        {{ $order->status }}
                                    </div>
                                </div>

                                <div>
                                    <div class="latest-transactions-total">
                                        Rp {{ number_format((int) $order->total_price, 0, ',', '.') }}
                                    </div>
                                    <div class="latest-transactions-items">
                                        {{ number_format((int) $order->total_item, 0, ',', '.') }} item
                                    </div>
                                </div>
                            </div>

                            <div class="latest-transactions-bar-wrap">
                                <div
                                    class="latest-transactions-bar"
                                    style="width: {{ $width }}%;"
                                ></div>
                            </div>
                        </div>
                    @endforeach
                </div>
            @else
                <div class="latest-transactions-empty">
                    Belum ada transaksi selesai pada periode ini.
                </div>
            @endif
        </div>
    </x-filament::section>
</x-filament-widgets::widget>