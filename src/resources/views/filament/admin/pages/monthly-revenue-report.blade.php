<x-filament-panels::page>
    @php
        $currentUrl = request()->url();

        $cards = [
            [
                'label' => 'Total Revenue',
                'value' => 'Rp ' . number_format((int) ($summary['total_revenue'] ?? 0), 0, ',', '.'),
                'caption' => 'Periode ' . ($selectedMonthLabel ?? '-'),
                'icon' => '▣',
                'color' => '#f97316',
            ],
            [
                'label' => 'Total Orders',
                'value' => number_format((int) ($summary['total_orders'] ?? 0), 0, ',', '.'),
                'caption' => 'Transaksi bulan ini',
                'icon' => '✓',
                'color' => '#10b981',
            ],
            [
                'label' => 'Units Sold',
                'value' => number_format((int) ($summary['total_items'] ?? 0), 0, ',', '.'),
                'caption' => 'Item terjual',
                'icon' => '◇',
                'color' => '#3b82f6',
            ],
            [
                'label' => 'Highest Order',
                'value' => 'Rp ' . number_format((int) ($summary['highest_order'] ?? 0), 0, ',', '.'),
                'caption' => 'Order tertinggi',
                'icon' => '!',
                'color' => '#ef4444',
            ],
        ];
    @endphp

    <div class="ng-monthly-revenue-page">
        <section class="ng-report-hero-grid">
            <article class="ng-widget-card ng-report-hero-card">
                <div class="ng-widget-head">
                    <div>
                        <h1>Monthly Revenue Analytics</h1>

                        <p>
                            Pantau histori pendapatan bulanan, jumlah transaksi, unit terjual,
                            dan detail transaksi selesai berdasarkan periode laporan.
                        </p>
                    </div>

                    <div class="ng-report-inline-filter">
                        <span class="ng-report-filter-title">Pilih Periode Laporan</span>

                        <div class="ng-report-filter-row">
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

                            <button
                                type="button"
                                class="ng-primary-button"
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
                        </div>

                        <small>Periode aktif: {{ $selectedMonthLabel }}</small>
                    </div>

                </div>
            </article>

        </section>

        <section class="ng-kpi-grid ng-report-kpi-grid">
            @foreach ($cards as $card)
                <article class="ng-kpi-card" style="--accent: {{ $card['color'] ?? '#f97316' }};">
                    <div class="ng-kpi-icon">
                        {{ $card['icon'] ?? '▣' }}
                    </div>

                    <div class="ng-kpi-content">
                        <div class="ng-kpi-label">
                            {{ $card['label'] ?? '-' }}
                            <span>⋮</span>
                        </div>

                        <strong>
                            {{ $card['value'] ?? '-' }}
                        </strong>

                        <p class="neutral">
                            {{ $card['caption'] ?? '-' }}
                        </p>
                    </div>
                </article>
            @endforeach
        </section>

        <section class="ng-widget-card ng-report-table-card">
            <div class="ng-widget-head ng-report-table-head">
                <div>
                    <h2>Data Order Bulan {{ $selectedMonthLabel }}</h2>
                    <p>Data yang ditampilkan hanya transaksi dengan status selesai.</p>
                </div>

                <span class="ng-widget-badge">
                    Total Data {{ number_format((int) ($summary['total_orders'] ?? 0), 0, ',', '.') }}
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
                                        {{ $orders->firstItem() + $loop->index }}
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
                                    <div class="ng-empty-state">
                                        <strong>Belum ada data penjualan</strong>
                                        <span>Tidak ada transaksi selesai pada bulan {{ $selectedMonthLabel }}.</span>
                                    </div>
                                </td>
                            </tr>
                        @endforelse
                    </tbody>

                    @if ($orders->total() > 0)
                        <tfoot>
                            <tr>
                                <td colspan="3">TOTAL</td>

                                <td>
                                    {{ number_format((int) ($summary['total_items'] ?? 0), 0, ',', '.') }}
                                </td>

                                <td>
                                    Rp {{ number_format((int) ($summary['total_revenue'] ?? 0), 0, ',', '.') }}
                                </td>

                                <td></td>
                            </tr>
                        </tfoot>
                    @endif
                </table>
            </div>

            @if ($orders->hasPages())
                <div class="ng-report-pagination">
                    <div class="ng-report-pagination-info">
                        Menampilkan
                        <strong>{{ number_format($orders->firstItem(), 0, ',', '.') }}</strong>
                        sampai
                        <strong>{{ number_format($orders->lastItem(), 0, ',', '.') }}</strong>
                        dari
                        <strong>{{ number_format($orders->total(), 0, ',', '.') }}</strong>
                        data
                    </div>

                    <div class="ng-report-pagination-actions">
                        @if ($orders->onFirstPage())
                            <span class="ng-page-btn is-disabled">
                                ← Previous
                            </span>
                        @else
                            <a href="{{ $orders->previousPageUrl() }}" class="ng-page-btn">
                                ← Previous
                            </a>
                        @endif

                        <div class="ng-page-numbers">
                            @foreach ($orders->getUrlRange(1, $orders->lastPage()) as $page => $url)
                                @if (
                                    $page === 1
                                    || $page === $orders->lastPage()
                                    || abs($page - $orders->currentPage()) <= 1
                                )
                                    @if ($page === $orders->currentPage())
                                        <span class="ng-page-number is-active">
                                            {{ $page }}
                                        </span>
                                    @else
                                        <a href="{{ $url }}" class="ng-page-number">
                                            {{ $page }}
                                        </a>
                                    @endif
                                @elseif (
                                    $page === $orders->currentPage() - 2
                                    || $page === $orders->currentPage() + 2
                                )
                                    <span class="ng-page-dots">...</span>
                                @endif
                            @endforeach
                        </div>

                        @if ($orders->hasMorePages())
                            <a href="{{ $orders->nextPageUrl() }}" class="ng-page-btn">
                                Next →
                            </a>
                        @else
                            <span class="ng-page-btn is-disabled">
                                Next →
                            </span>
                        @endif
                    </div>
                </div>
            @endif
        </section>
    </div>

    <style>
        html,
        body {
            overflow-x: hidden !important;
        }

        body:has(.ng-monthly-revenue-page) {
            background:
                linear-gradient(120deg, rgba(255, 248, 237, .18), rgba(255, 224, 185, .05)),
                url('/images/pos-orange-bg.png'),
                radial-gradient(circle at 15% 8%, rgba(255, 255, 255, .48) 0 130px, transparent 280px),
                radial-gradient(circle at 88% 78%, rgba(255, 118, 0, .42) 0 250px, transparent 520px),
                radial-gradient(circle at 20% 96%, rgba(255, 181, 83, .30) 0 220px, transparent 500px),
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

        body:has(.ng-monthly-revenue-page) .fi-page,
        body:has(.ng-monthly-revenue-page) .fi-main {
            padding: 0 !important;
        }

        body:has(.ng-monthly-revenue-page) .fi-page-header {
            display: none !important;
        }

        body:has(.ng-monthly-revenue-page) .fi-page-content {
            gap: 0 !important;
            row-gap: 0 !important;
        }

        .ng-monthly-revenue-page {
            width: 100% !important;
            max-width: 100% !important;
            padding: 24px 24px 24px !important;
            overflow: hidden !important;
            font-family: Inter, Poppins, ui-sans-serif, system-ui, -apple-system, BlinkMacSystemFont, "Segoe UI", sans-serif;
            color: #24180f;
        }

        .ng-monthly-revenue-page * {
            box-sizing: border-box;
        }

        .ng-report-hero-grid {
            display: grid;
            grid-template-columns: 1fr;
            gap: 0;
            margin-bottom: 14px;
        }

        .ng-widget-card,
        .ng-kpi-card {
            position: relative;
            overflow: hidden;
            border: 1px solid rgba(255, 255, 255, .58);
            background:
                linear-gradient(145deg, rgba(255, 255, 255, .46), rgba(255, 246, 231, .22)),
                radial-gradient(circle at 100% 0%, rgba(255, 153, 30, .16), transparent 38%) !important;
            box-shadow:
                0 22px 54px rgba(101, 58, 21, .12),
                0 0 0 1px rgba(255, 255, 255, .12) inset,
                inset 0 1px 0 rgba(255, 255, 255, .62);
            backdrop-filter: blur(14px);
            -webkit-backdrop-filter: blur(14px);
        }

        .ng-widget-card::before,
        .ng-kpi-card::before {
            content: "";
            position: absolute;
            inset: 0;
            pointer-events: none;
            background:
                linear-gradient(120deg, rgba(255, 255, 255, .34), transparent 28%, transparent 70%, rgba(255, 255, 255, .16));
            opacity: .38;
        }

        .ng-widget-card {
            border-radius: 24px;
            padding: 18px;
            min-width: 0;
        }

        .ng-report-hero-card {
            width: 100%;
            min-height: 132px;
            display: flex;
            align-items: center;
        }

        .ng-widget-head {
            position: relative;
            z-index: 2;
            width: 100%;
            display: flex;
            align-items: center;
            justify-content: space-between;
            gap: 24px;
        }

        .ng-widget-head > div:first-child {
            min-width: 0;
            flex: 1 1 auto;
        }

        .ng-widget-head h1 {
            margin: 0;
            color: #21160d;
            font-size: 30px;
            line-height: 1.05;
            font-weight: 950;
            letter-spacing: -.04em;
        }

        .ng-widget-head h2 {
            margin: 0;
            color: #21160d;
            font-size: 20px;
            line-height: 1.1;
            font-weight: 950;
            letter-spacing: -.03em;
        }

        .ng-widget-head p {
            max-width: 850px;
            margin: 8px 0 0;
            color: #765d45;
            font-size: 13px;
            line-height: 1.55;
            font-weight: 700;
        }

        /*
        |--------------------------------------------------------------------------
        | HERO FILTER - CLEAN, NO INNER WIDGET
        |--------------------------------------------------------------------------
        */

        .ng-report-inline-filter {
            position: relative;
            z-index: 2;
            flex: 0 0 auto;
            min-width: 430px;
            display: grid;
            grid-template-columns: 1fr;
            gap: 6px;
            padding: 0;
            border: 0;
            background: transparent;
            box-shadow: none;
        }

        .ng-report-filter-title,
        .ng-report-inline-filter small {
            display: block;
            margin: 0;
            color: #765d45;
            font-size: 11px;
            line-height: 1.25;
            font-weight: 900;
            white-space: nowrap;
        }

        .ng-report-filter-title {
            font-weight: 950;
        }

        .ng-report-inline-filter small {
            font-weight: 850;
        }

        .ng-report-filter-row {
            display: flex;
            align-items: center;
            justify-content: flex-start;
            gap: 12px;
            width: 100%;
        }

        .ng-report-select {
            width: 220px;
            height: 40px;
            min-height: 40px;
            margin: 0;
            padding: 0 14px;
            border: 1px solid rgba(255, 255, 255, .55);
            outline: none;
            border-radius: 14px;
            color: #2d1f16;
            background: rgba(255, 255, 255, .38);
            box-shadow: inset 0 1px 0 rgba(255, 255, 255, .45);
            backdrop-filter: blur(10px);
            -webkit-backdrop-filter: blur(10px);
            font-size: 11px;
            font-weight: 950;
            cursor: pointer;
        }

        .ng-primary-button {
            width: auto;
            min-width: 130px;
            max-width: 150px;
            height: 40px;
            min-height: 40px;
            display: inline-flex;
            align-items: center;
            justify-content: center;
            padding: 0 14px;
            border: 0;
            border-radius: 14px;
            color: #fff;
            background: linear-gradient(135deg, #ff9d18, #ee6500);
            box-shadow: 0 12px 22px rgba(238, 101, 0, .22);
            font-size: 10px;
            line-height: 1;
            font-weight: 950;
            white-space: nowrap;
            cursor: pointer;
            transition: transform .18s ease, box-shadow .18s ease, filter .18s ease;
        }

        .ng-primary-button:hover {
            transform: translateY(-1px);
            filter: brightness(1.02);
            box-shadow: 0 16px 26px rgba(238, 101, 0, .26);
        }

        .ng-primary-button:disabled {
            cursor: not-allowed;
            opacity: .72;
            transform: none;
        }

        /*
        |--------------------------------------------------------------------------
        | KPI
        |--------------------------------------------------------------------------
        */

        .ng-kpi-grid,
        .ng-report-kpi-grid {
            display: grid;
            grid-template-columns: repeat(4, minmax(0, 1fr));
            gap: 14px;
            margin-bottom: 14px;
        }

        .ng-kpi-card {
            min-height: 108px;
            display: flex;
            gap: 12px;
            padding: 16px 15px;
            border-radius: 22px;
        }

        .ng-kpi-icon {
            position: relative;
            z-index: 1;
            display: grid;
            place-items: center;
            flex: 0 0 auto;
            width: 44px;
            height: 44px;
            border-radius: 15px;
            color: #fff;
            background: linear-gradient(135deg, var(--accent), #d95d00);
            box-shadow: 0 15px 28px rgba(249, 115, 22, .22);
            font-size: 17px;
            font-weight: 950;
        }

        .ng-kpi-content {
            position: relative;
            z-index: 1;
            min-width: 0;
            flex: 1;
        }

        .ng-kpi-label {
            display: flex;
            align-items: center;
            justify-content: space-between;
            gap: 8px;
            color: #6f5946;
            font-size: 12px;
            line-height: 1.2;
            font-weight: 900;
            text-transform: uppercase;
            letter-spacing: .06em;
        }

        .ng-kpi-content strong {
            display: block;
            margin-top: 7px;
            color: #23160d;
            font-size: 22px;
            line-height: 1.15;
            font-weight: 950;
            letter-spacing: -.03em;
            white-space: nowrap;
            overflow: hidden;
            text-overflow: ellipsis;
        }

        .ng-kpi-content p {
            margin: 8px 0 0;
            color: #6f5946;
            font-size: 11px;
            line-height: 1.25;
            font-weight: 850;
            white-space: nowrap;
            overflow: hidden;
            text-overflow: ellipsis;
        }

        /*
        |--------------------------------------------------------------------------
        | TABLE
        |--------------------------------------------------------------------------
        */

        .ng-report-table-card {
            padding: 18px;
            border-radius: 24px;
        }

        .ng-report-table-head {
            align-items: flex-start;
            margin-bottom: 16px;
        }

        .ng-widget-badge {
            position: relative;
            z-index: 2;
            display: inline-flex;
            align-items: center;
            min-height: 34px;
            padding: 0 14px;
            border-radius: 14px;
            color: #d95d00;
            background: rgba(255, 255, 255, .38);
            border: 1px solid rgba(255, 255, 255, .52);
            font-size: 11px;
            font-weight: 950;
            white-space: nowrap;
        }

        .ng-report-table-wrap {
            position: relative;
            z-index: 2;
            width: 100%;
            overflow-x: auto;
            border-top: 1px solid rgba(114, 74, 41, .08);
        }

        .ng-report-table {
            width: 100%;
            min-width: 900px;
            border-collapse: collapse;
            color: #3a2a1f;
        }

        .ng-report-table th,
        .ng-report-table td {
            padding: 13px 14px;
            text-align: left;
            border-bottom: 1px solid rgba(114, 74, 41, .08);
            background: transparent;
        }

        .ng-report-table th {
            color: #4b3525;
            font-size: 11px;
            line-height: 1;
            font-weight: 950;
            text-transform: uppercase;
            letter-spacing: .02em;
        }

        .ng-report-table td {
            color: #4b3525;
            font-size: 12px;
            font-weight: 850;
        }

        .ng-report-table tbody tr {
            transition: background .18s ease;
        }

        .ng-report-table tbody tr:hover {
            background: rgba(255, 255, 255, .14);
        }

        .ng-report-table tfoot td {
            color: #21160d;
            font-weight: 950;
            background: rgba(255, 255, 255, .16);
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
            min-height: 30px;
            padding: 0 11px;
            border-radius: 999px;
            white-space: nowrap;
            font-size: 11px;
            font-weight: 950;
        }

        .ng-number-pill {
            min-width: 34px;
            color: #64748b;
            background: rgba(148, 163, 184, .12);
            border: 1px solid rgba(148, 163, 184, .22);
        }

        .ng-order-code-pill,
        .ng-total-pill,
        .ng-status-pill {
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
            min-width: 38px;
            color: #2563eb;
            background: rgba(59, 130, 246, .10);
            border: 1px solid rgba(59, 130, 246, .20);
        }

        .ng-empty-state {
            min-height: 120px;
            display: grid;
            place-items: center;
            align-content: center;
            gap: 6px;
            color: #765d45;
            text-align: center;
        }

        .ng-empty-state strong {
            color: #21160d;
            font-size: 16px;
            font-weight: 950;
        }

        .ng-empty-state span {
            font-size: 12px;
            font-weight: 800;
        }

        /*
        |--------------------------------------------------------------------------
        | PAGINATION
        |--------------------------------------------------------------------------
        */

        .ng-report-pagination {
            position: relative;
            z-index: 2;
            min-height: 52px;
            display: flex;
            align-items: center;
            justify-content: space-between;
            gap: 12px;
            padding-top: 14px;
        }

        .ng-report-pagination-info {
            color: #765d45;
            font-size: 12px;
            font-weight: 800;
        }

        .ng-report-pagination-info strong {
            color: #21160d;
            font-weight: 950;
        }

        .ng-report-pagination-actions,
        .ng-page-numbers {
            display: flex;
            align-items: center;
            gap: 6px;
        }

        .ng-page-btn,
        .ng-page-number,
        .ng-page-dots {
            min-width: 34px;
            height: 34px;
            display: inline-flex;
            align-items: center;
            justify-content: center;
            padding: 0 11px;
            border-radius: 12px;
            color: #7b6049;
            background: rgba(255, 255, 255, .32);
            border: 1px solid rgba(255, 255, 255, .48);
            font-size: 11px;
            font-weight: 900;
            text-decoration: none;
        }

        .ng-page-btn {
            min-width: 96px;
        }

        .ng-page-number.is-active {
            color: #fff;
            background: linear-gradient(135deg, #ff9d18, #ee6500);
            box-shadow: 0 12px 22px rgba(238, 101, 0, .22);
        }

        .ng-page-btn.is-disabled {
            opacity: .45;
            cursor: not-allowed;
        }

        /*
        |--------------------------------------------------------------------------
        | SIDEBAR SYNC
        |--------------------------------------------------------------------------
        */

        body:has(.ng-monthly-revenue-page) .fi-sidebar {
            background: rgba(255, 250, 242, .50) !important;
            border-right: 1px solid rgba(255, 255, 255, .48) !important;
            box-shadow: 18px 0 55px rgba(137, 78, 26, .10) !important;
            backdrop-filter: blur(16px) !important;
            -webkit-backdrop-filter: blur(16px) !important;
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

        body:has(.ng-monthly-revenue-page) .fi-sidebar-item-active svg,
        body:has(.ng-monthly-revenue-page) .fi-sidebar-item a:hover svg,
        body:has(.ng-monthly-revenue-page) .fi-sidebar-item-active span,
        body:has(.ng-monthly-revenue-page) .fi-sidebar-item a:hover span {
            color: #fff !important;
        }

        /*
        |--------------------------------------------------------------------------
        | RESPONSIVE
        |--------------------------------------------------------------------------
        */

        @media (max-width: 1500px) {
            .ng-widget-head {
                align-items: flex-start;
                flex-direction: column;
            }

            .ng-report-inline-filter {
                width: 100%;
                min-width: 0;
            }

            .ng-report-filter-row {
                justify-content: flex-start;
            }

            .ng-kpi-grid,
            .ng-report-kpi-grid {
                grid-template-columns: repeat(2, minmax(0, 1fr));
            }
        }

        @media (max-width: 900px) {
            .ng-monthly-revenue-page {
                padding: 18px !important;
            }

            .ng-report-filter-row,
            .ng-report-pagination {
                align-items: flex-start;
                flex-direction: column;
            }

            .ng-report-select {
                width: 100%;
            }

            .ng-primary-button {
                width: auto;
            }

            .ng-report-table-head {
                align-items: flex-start;
                flex-direction: column;
            }
        }

        @media (max-width: 700px) {
            .ng-kpi-grid,
            .ng-report-kpi-grid {
                grid-template-columns: 1fr;
            }

            .ng-widget-head h1 {
                font-size: 26px;
            }

            .ng-widget-card {
                padding: 16px;
                border-radius: 22px;
            }
        }
    </style>
</x-filament-panels::page>
