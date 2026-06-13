<x-filament-panels::page>
    @php
        $currentUrl = request()->url();

        $cards = [
            [
                'label' => 'Total Revenue',
                'value' => 'Rp ' . number_format($summary['total_revenue'], 0, ',', '.'),
                'caption' => 'Periode ' . $selectedMonthLabel,
                'icon' => '▣',
                'color' => '#f97316',
            ],
            [
                'label' => 'Total Orders',
                'value' => number_format($summary['total_orders'], 0, ',', '.'),
                'caption' => 'Transaksi bulan ini',
                'icon' => '✓',
                'color' => '#10b981',
            ],
            [
                'label' => 'Units Sold',
                'value' => number_format($summary['total_items'], 0, ',', '.'),
                'caption' => 'Item terjual',
                'icon' => '◇',
                'color' => '#3b82f6',
            ],
            [
                'label' => 'Avg Order',
                'value' => 'Rp ' . number_format($summary['avg_order'], 0, ',', '.'),
                'caption' => 'Rata-rata order',
                'icon' => '↗',
                'color' => '#8b5cf6',
            ],
            [
                'label' => 'Highest Order',
                'value' => 'Rp ' . number_format($summary['highest_order'], 0, ',', '.'),
                'caption' => 'Order tertinggi',
                'icon' => '!',
                'color' => '#ef4444',
            ],
        ];
    @endphp

    <div class="ng-monthly-revenue-page">
        <section class="ng-report-hero">
            <article class="ng-report-hero-main">

                <h1>Monthly Revenue Analytics</h1>

                <p>
                    Pantau histori pendapatan bulanan, jumlah transaksi, unit terjual, rata-rata order,
                    dan detail transaksi selesai berdasarkan periode laporan.
                </p>
            </article>

            <article class="ng-report-filter-card">
                <div>
                    <span>Pilih Periode Laporan</span>

                    <select
                        class="ng-report-select"
                        onchange="window.location.href = '{{ $currentUrl }}?month=' + this.value"
                    >
                        @foreach ($months as $month)
                            <option value="{{ $month }}" @selected($month === $selectedMonth)>
                                {{ \Carbon\Carbon::createFromFormat('Y-m', $month)->translatedFormat('F Y') }}
                            </option>
                        @endforeach
                    </select>

                    <small>Periode aktif: {{ $selectedMonthLabel }}</small>
                </div>

                <button
                    type="button"
                    class="ng-report-download-btn"
                    wire:click="exportSelectedMonth"
                    wire:loading.attr="disabled"
                    wire:target="exportSelectedMonth"
                >
                    <span wire:loading.remove wire:target="exportSelectedMonth">
                        Download Laporan
                    </span>

                    <span wire:loading wire:target="exportSelectedMonth">
                        Menyiapkan...
                    </span>
                </button>
            </article>
        </section>

        <section class="ng-report-kpi-grid">
            @foreach ($cards as $card)
                <article class="ng-report-kpi" style="--accent: {{ $card['color'] }};">
                    <div class="ng-report-kpi-icon">
                        {{ $card['icon'] }}
                    </div>

                    <div>
                        <span>{{ $card['label'] }}</span>
                        <strong>{{ $card['value'] }}</strong>
                        <p>{{ $card['caption'] }}</p>
                    </div>
                </article>
            @endforeach
        </section>

        <section class="ng-report-table-card">
            <div class="ng-report-table-head">
                <div>
                    <h2>Data Order Bulan {{ $selectedMonthLabel }}</h2>
                    <p>Data yang ditampilkan hanya transaksi dengan status selesai.</p>
                </div>

                <span>
                    Total Data {{ number_format($summary['total_orders'], 0, ',', '.') }}
                </span>
            </div>

            <div class="ng-report-table-wrap">
                <table class="ng-report-table">
                    <thead>
                        <tr>
                            <th>No</th>
                            <th>ID Order</th>
                            <th>Tanggal</th>
                            <th>Total Item</th>
                            <th>Total</th>
                            <th>Status</th>
                        </tr>
                    </thead>

                    <tbody>
                        @forelse ($orders as $order)
                            @php
                                $date = $order->ordered_at ?? $order->created_at;
                            @endphp

                            <tr>
                                <td>
                                    <span class="ng-number-pill">
                                        {{ $loop->iteration }}
                                    </span>
                                </td>

                                <td>
                                    <span class="ng-order-code-pill">
                                        {{ $order->order_code ?? 'ORD-' . $order->id }}
                                    </span>
                                </td>

                                <td>
                                    <span class="ng-date-pill">
                                        {{ \Carbon\Carbon::parse($date)->translatedFormat('d M Y H:i') }}
                                    </span>
                                </td>

                                <td>
                                    <span class="ng-item-pill">
                                        {{ number_format((int) $order->total_item, 0, ',', '.') }}
                                    </span>
                                </td>

                                <td>
                                    <span class="ng-total-pill">
                                        Rp {{ number_format((int) $order->total_price, 0, ',', '.') }}
                                    </span>
                                </td>

                                <td>
                                    <span class="ng-status-pill">
                                        ✓ {{ $order->status }}
                                    </span>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="6">
                                    <div class="ng-empty-report">
                                        <strong>Belum ada data penjualan</strong>
                                        <span>Tidak ada transaksi selesai pada bulan {{ $selectedMonthLabel }}.</span>
                                    </div>
                                </td>
                            </tr>
                        @endforelse
                    </tbody>

                    @if ($orders->count() > 0)
                        <tfoot>
                            <tr>
                                <td colspan="3">TOTAL</td>

                                <td>
                                    {{ number_format($summary['total_items'], 0, ',', '.') }}
                                </td>

                                <td>
                                    Rp {{ number_format($summary['total_revenue'], 0, ',', '.') }}
                                </td>

                                <td></td>
                            </tr>
                        </tfoot>
                    @endif
                </table>
            </div>
        </section>
    </div>

    <style>
        html,
        body {
            overflow-x: hidden !important;
        }

        body:has(.ng-monthly-revenue-page) {
            background:
                linear-gradient(120deg, rgba(255, 248, 237, .10), rgba(255, 224, 185, .02)),
                url('/images/pos-orange-bg.png'),
                radial-gradient(circle at 15% 8%, rgba(255, 255, 255, .32) 0 130px, transparent 280px),
                radial-gradient(circle at 88% 78%, rgba(255, 118, 0, .42) 0 250px, transparent 520px),
                radial-gradient(circle at 20% 96%, rgba(255, 181, 83, .28) 0 220px, transparent 500px),
                linear-gradient(135deg, #fff3df 0%, #ffd394 48%, #ff9c45 100%) !important;
            background-size: cover !important;
            background-position: center !important;
            background-attachment: fixed !important;
        }

        body:has(.ng-monthly-revenue-page) .fi-main,
        body:has(.ng-monthly-revenue-page) .fi-main-ctn,
        body:has(.ng-monthly-revenue-page) .fi-page,
        body:has(.ng-monthly-revenue-page) .fi-page-content {
            width: 100% !important;
            max-width: 100% !important;
            background: transparent !important;
            overflow-x: hidden !important;
        }

        body:has(.ng-monthly-revenue-page) .fi-page {
            padding: 0 !important;
        }

        body:has(.ng-monthly-revenue-page) .fi-page-header {
            display: none !important;
        }

        body:has(.ng-monthly-revenue-page) .fi-main {
            padding: 0 !important;
        }

        body:has(.ng-monthly-revenue-page) .fi-sidebar {
            background: rgba(255, 250, 242, .50) !important;
            border-right: 1px solid rgba(255, 255, 255, .48) !important;
            box-shadow: 18px 0 55px rgba(137, 78, 26, .10) !important;
            backdrop-filter: blur(16px) !important;
        }

        body:has(.ng-monthly-revenue-page) .fi-sidebar-nav {
            padding: 18px 14px !important;
        }

        body:has(.ng-monthly-revenue-page) .fi-sidebar-item a {
            border-radius: 14px !important;
            color: #6f5844 !important;
            transition: .2s ease !important;
        }

        body:has(.ng-monthly-revenue-page) .fi-sidebar-item-active a,
        body:has(.ng-monthly-revenue-page) .fi-sidebar-item a:hover {
            background: linear-gradient(135deg, #ff9500, #f26a00) !important;
            color: #fff !important;
            box-shadow: 0 14px 24px rgba(242, 106, 0, .24) !important;
        }

        .ng-monthly-revenue-page {
            width: 100%;
            min-height: 100vh;
            padding: 18px 18px 28px;
            font-family: Inter, Poppins, ui-sans-serif, system-ui, -apple-system, BlinkMacSystemFont, "Segoe UI", sans-serif;
            color: #24180f;
        }

        .ng-monthly-revenue-page * {
            box-sizing: border-box;
        }

        .ng-report-hero {
            display: grid;
            grid-template-columns: minmax(0, 1.35fr) minmax(340px, .65fr);
            gap: 12px;
            margin-bottom: 12px;
        }

        .ng-report-hero-main,
        .ng-report-filter-card,
        .ng-report-kpi,
        .ng-report-table-card {
            position: relative;
            overflow: hidden;
            border: 1px solid rgba(255, 255, 255, .56);
            background: rgba(255, 247, 235, .18);
            box-shadow:
                0 20px 48px rgba(101, 58, 21, .10),
                0 0 0 1px rgba(255, 255, 255, .10) inset,
                inset 0 1px 0 rgba(255, 255, 255, .56);
            backdrop-filter: blur(13px);
        }

        .ng-report-hero-main {
            min-height: 126px;
            padding: 20px 22px;
            border-radius: 24px;
        }

        .ng-report-filter-card {
            min-height: 126px;
            display: flex;
            align-items: center;
            justify-content: space-between;
            gap: 14px;
            padding: 20px 22px;
            border-radius: 24px;
        }

        .ng-report-kicker {
            display: inline-flex;
            width: fit-content;
            padding: 6px 12px;
            margin-bottom: 9px;
            border-radius: 999px;
            background: rgba(255, 255, 255, .42);
            border: 1px solid rgba(255, 255, 255, .54);
            color: #d95d00;
            font-size: 11px;
            font-weight: 900;
            letter-spacing: .10em;
            text-transform: uppercase;
            box-shadow: inset 0 1px 0 rgba(255, 255, 255, .62);
            backdrop-filter: blur(10px);
        }

        .ng-report-hero-main h1 {
            margin: 0;
            color: #21160d;
            font-size: 30px;
            line-height: 1.05;
            font-weight: 950;
            letter-spacing: -.04em;
        }

        .ng-report-hero-main p {
            max-width: 820px;
            margin: 7px 0 0;
            color: #765d45;
            font-size: 12px;
            font-weight: 650;
            line-height: 1.5;
        }

        .ng-report-filter-card span,
        .ng-report-filter-card small {
            display: block;
            color: #765d45;
            font-size: 11px;
            font-weight: 850;
        }

        .ng-report-filter-card small {
            margin-top: 8px;
        }

        .ng-report-select {
            width: 210px;
            min-height: 40px;
            margin-top: 8px;
            padding: 0 12px;
            border-radius: 14px;
            border: 1px solid rgba(255, 255, 255, .46);
            background: rgba(255, 255, 255, .34);
            color: #24180f;
            font-size: 12px;
            font-weight: 850;
            outline: none;
            box-shadow: inset 0 1px 0 rgba(255, 255, 255, .42);
            backdrop-filter: blur(10px);
        }

        .ng-report-download-btn {
            display: inline-flex;
            align-items: center;
            justify-content: center;
            min-height: 42px;
            padding: 0 17px;
            border: none;
            border-radius: 15px;
            color: #fff;
            background: linear-gradient(135deg, #ff9d18, #ee6500);
            box-shadow: 0 14px 26px rgba(238, 101, 0, .26);
            font-size: 12px;
            font-weight: 950;
            white-space: nowrap;
            cursor: pointer;
        }

        .ng-report-download-btn:disabled {
            opacity: .72;
            cursor: wait;
        }

        .ng-report-kpi-grid {
            display: grid;
            grid-template-columns: repeat(5, minmax(0, 1fr));
            gap: 10px;
            margin-bottom: 12px;
        }

        .ng-report-kpi {
            min-height: 90px;
            display: flex;
            align-items: center;
            gap: 11px;
            padding: 14px;
            border-radius: 20px;
        }

        .ng-report-kpi-icon {
            display: grid;
            place-items: center;
            flex: 0 0 auto;
            width: 40px;
            height: 40px;
            border-radius: 14px;
            color: #fff;
            background: linear-gradient(135deg, var(--accent), #d95d00);
            box-shadow: 0 14px 24px rgba(249, 115, 22, .20);
            font-size: 15px;
            font-weight: 950;
        }

        .ng-report-kpi span {
            display: block;
            color: #6f5946;
            font-size: 11px;
            font-weight: 900;
        }

        .ng-report-kpi strong {
            display: block;
            margin-top: 6px;
            color: #23160d;
            font-size: 18px;
            line-height: 1.15;
            font-weight: 950;
            letter-spacing: -.03em;
            white-space: nowrap;
            overflow: hidden;
            text-overflow: ellipsis;
        }

        .ng-report-kpi p {
            margin: 6px 0 0;
            color: #6f5946;
            font-size: 10px;
            font-weight: 850;
        }

        .ng-report-table-card {
            border-radius: 24px;
        }

        .ng-report-table-head {
            min-height: 58px;
            display: flex;
            align-items: center;
            justify-content: space-between;
            gap: 14px;
            padding: 15px 20px;
            background: rgba(255, 247, 235, .10);
            border-bottom: 1px solid rgba(114, 74, 41, .07);
        }

        .ng-report-table-head h2 {
            margin: 0;
            color: #25170d;
            font-size: 17px;
            line-height: 1.2;
            font-weight: 950;
            letter-spacing: -.03em;
        }

        .ng-report-table-head p {
            margin: 5px 0 0;
            color: #7b624c;
            font-size: 12px;
            font-weight: 750;
        }

        .ng-report-table-head > span {
            display: inline-flex;
            align-items: center;
            justify-content: center;
            min-height: 30px;
            padding: 0 12px;
            border-radius: 999px;
            color: #c25500;
            background: rgba(249, 115, 22, .12);
            border: 1px solid rgba(249, 115, 22, .22);
            font-size: 11px;
            font-weight: 950;
            white-space: nowrap;
        }

        .ng-report-table-wrap {
            width: 100%;
            overflow-x: auto;
        }

        .ng-report-table {
            width: 100%;
            border-collapse: collapse;
            min-width: 920px;
        }

        .ng-report-table th,
        .ng-report-table td {
            padding: 12px 14px;
            border-bottom: 1px solid rgba(114, 74, 41, .07);
            text-align: left;
            vertical-align: middle;
        }

        .ng-report-table thead tr {
            background: rgba(255, 247, 235, .10);
        }

        .ng-report-table th {
            color: #4b3525;
            font-size: 11px;
            font-weight: 950;
            text-transform: uppercase;
            letter-spacing: .02em;
        }

        .ng-report-table td {
            color: #23160d;
            font-size: 12px;
            font-weight: 800;
        }

        .ng-report-table tbody tr {
            transition: .18s ease;
        }

        .ng-report-table tbody tr:hover {
            background: rgba(255, 255, 255, .10);
        }

        .ng-report-table tfoot tr {
            background: rgba(255, 247, 235, .14);
        }

        .ng-report-table tfoot td {
            color: #21160d;
            font-size: 13px;
            font-weight: 950;
        }

        .ng-number-pill,
        .ng-order-code-pill,
        .ng-date-pill,
        .ng-item-pill,
        .ng-total-pill,
        .ng-status-pill {
            display: inline-flex;
            align-items: center;
            justify-content: center;
            min-height: 28px;
            padding: 0 10px;
            border-radius: 999px;
            font-size: 10px;
            font-weight: 950;
            white-space: nowrap;
        }

        .ng-number-pill {
            min-width: 32px;
            color: #64748b;
            background: rgba(148, 163, 184, .12);
            border: 1px solid rgba(148, 163, 184, .24);
        }

        .ng-order-code-pill {
            color: #078657;
            background: rgba(16, 185, 129, .12);
            border: 1px solid rgba(16, 185, 129, .22);
        }

        .ng-date-pill {
            color: #6f5946;
            background: rgba(255, 255, 255, .24);
            border: 1px solid rgba(255, 255, 255, .38);
        }

        .ng-item-pill {
            min-width: 42px;
            color: #2563eb;
            background: rgba(59, 130, 246, .10);
            border: 1px solid rgba(59, 130, 246, .20);
        }

        .ng-total-pill,
        .ng-status-pill {
            color: #078657;
            background: rgba(16, 185, 129, .12);
            border: 1px solid rgba(16, 185, 129, .22);
        }

        .ng-empty-report {
            padding: 22px;
            border-radius: 18px;
            background: rgba(255, 255, 255, .20);
            border: 1px solid rgba(255, 255, 255, .38);
            text-align: center;
        }

        .ng-empty-report strong,
        .ng-empty-report span {
            display: block;
        }

        .ng-empty-report strong {
            color: #23160d;
            font-size: 15px;
            font-weight: 950;
        }

        .ng-empty-report span {
            margin-top: 6px;
            color: #765d45;
            font-size: 12px;
            font-weight: 750;
        }

        @media (max-width: 1500px) {
            .ng-report-hero {
                grid-template-columns: 1fr;
            }

            .ng-report-kpi-grid {
                grid-template-columns: repeat(3, minmax(0, 1fr));
            }
        }

        @media (max-width: 900px) {
            .ng-monthly-revenue-page {
                padding: 14px;
            }

            .ng-report-filter-card {
                align-items: flex-start;
                flex-direction: column;
            }

            .ng-report-kpi-grid {
                grid-template-columns: 1fr;
            }

            .ng-report-table-head {
                align-items: flex-start;
                flex-direction: column;
            }
        }
    </style>
</x-filament-panels::page>