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
                'label' => 'Avg Order',
                'value' => 'Rp ' . number_format((int) ($summary['avg_order'] ?? 0), 0, ',', '.'),
                'caption' => 'Rata-rata order',
                'icon' => '↗',
                'color' => '#8b5cf6',
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
                            rata-rata order, dan detail transaksi selesai berdasarkan periode laporan.
                        </p>
                    </div>
                </div>
            </article>

            <article class="ng-widget-card ng-report-filter-card">
                <div class="ng-report-filter-info">
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

                <div class="ng-report-filter-action">
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

        body:has(.ng-monthly-revenue-page) .fi-page {
            padding: 0 !important;
        }

        body:has(.ng-monthly-revenue-page) .fi-page-header {
            display: none !important;
        }

        body:has(.ng-monthly-revenue-page) .fi-main {
            padding: 0 !important;
        }

        body:has(.ng-monthly-revenue-page) .fi-page-content {
            gap: 0 !important;
            row-gap: 0 !important;
        }

        .ng-monthly-revenue-page {
            width: 100% !important;
            max-width: 100% !important;
            min-height: 100vh;
            padding: 24px 24px 32px !important;
            overflow: hidden !important;
            font-family: Inter, Poppins, ui-sans-serif, system-ui, -apple-system, BlinkMacSystemFont, "Segoe UI", sans-serif;
            color: #24180f;
        }

        .ng-monthly-revenue-page * {
            box-sizing: border-box;
        }

        .ng-report-hero-grid {
            display: grid;
            grid-template-columns: minmax(0, 1.45fr) minmax(360px, .55fr);
            gap: 16px;
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

        .ng-report-hero-card,
        .ng-report-filter-card {
            min-height: 126px;
        }

        .ng-report-hero-card {
            display: flex;
            align-items: center;
        }

        .ng-widget-head {
            position: relative;
            z-index: 2;
            display: flex;
            align-items: flex-start;
            justify-content: space-between;
            gap: 14px;
            width: 100%;
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
            color: #25170d;
            font-size: 16px;
            line-height: 1.2;
            font-weight: 950;
            letter-spacing: -.03em;
        }

        .ng-widget-head p {
            max-width: 820px;
            margin: 8px 0 0;
            color: #765d45;
            font-size: 13px;
            line-height: 1.55;
            font-weight: 700;
        }

        .ng-report-filter-card {
            display: flex;
            align-items: center;
            justify-content: space-between;
            gap: 16px;
        }

        .ng-report-filter-info,
        .ng-report-filter-action {
            position: relative;
            z-index: 2;
        }

        .ng-report-filter-info {
            min-width: 0;
        }

        .ng-report-filter-info span,
        .ng-report-filter-info small {
            display: block;
            color: #765d45;
            font-size: 11px;
            font-weight: 900;
        }

        .ng-report-filter-info small {
            margin-top: 8px;
            font-weight: 850;
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
            -webkit-backdrop-filter: blur(10px);
        }

        .ng-primary-button {
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
            transition: .2s ease;
        }

        .ng-primary-button:hover {
            transform: translateY(-1px);
            box-shadow: 0 18px 32px rgba(238, 101, 0, .30);
        }

        .ng-primary-button:disabled {
            opacity: .72;
            cursor: wait;
            transform: none;
        }

        .ng-kpi-grid {
            display: grid;
            grid-template-columns: repeat(5, minmax(0, 1fr));
            gap: 14px;
            margin-bottom: 16px;
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

        .ng-widget-badge {
            position: relative;
            z-index: 2;
            display: inline-flex;
            align-items: center;
            justify-content: center;
            min-height: 32px;
            padding: 0 12px;
            border-radius: 12px;
            color: #da6200;
            background: rgba(255, 255, 255, .36);
            border: 1px solid rgba(255, 255, 255, .50);
            font-size: 11px;
            font-weight: 950;
            text-decoration: none;
            white-space: nowrap;
        }

        .ng-report-table-card {
            padding: 0;
        }

        .ng-report-table-head {
            min-height: 58px;
            align-items: center;
            padding: 16px 18px;
            margin-bottom: 0;
            background: rgba(255, 247, 235, .10);
            border-bottom: 1px solid rgba(114, 74, 41, .07);
        }

        .ng-report-table-head p {
            font-size: 12px;
            font-weight: 800;
        }

        .ng-report-table-wrap {
            position: relative;
            z-index: 2;
            width: 100%;
            overflow-x: auto;
        }

        .ng-report-table-wrap::-webkit-scrollbar {
            height: 8px;
        }

        .ng-report-table-wrap::-webkit-scrollbar-track {
            background: rgba(255, 255, 255, .26);
            border-radius: 999px;
        }

        .ng-report-table-wrap::-webkit-scrollbar-thumb {
            background: rgba(249, 115, 22, .45);
            border-radius: 999px;
        }

        .ng-report-table {
            width: 100%;
            min-width: 920px;
            border-collapse: collapse;
        }

        .ng-report-table th,
        .ng-report-table td {
            padding: 12px 14px;
            border-bottom: 1px solid rgba(114, 74, 41, .07);
            text-align: left;
            vertical-align: middle;
            background: transparent;
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
            background: rgba(255, 255, 255, .14);
        }

        .ng-report-table tfoot tr {
            background: rgba(255, 247, 235, .16);
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

        .ng-empty-state {
            position: relative;
            z-index: 2;
            padding: 22px;
            border-radius: 18px;
            background: rgba(255, 255, 255, .22);
            border: 1px solid rgba(255, 255, 255, .40);
            text-align: center;
        }

        .ng-empty-state strong,
        .ng-empty-state span {
            display: block;
        }

        .ng-empty-state strong {
            color: #23160d;
            font-size: 15px;
            font-weight: 950;
        }

        .ng-empty-state span {
            margin-top: 6px;
            color: #765d45;
            font-size: 12px;
            font-weight: 800;
        }


        /*
        |--------------------------------------------------------------------------
        | PAGINATION - MONTHLY REVENUE TABLE
        |--------------------------------------------------------------------------
        */

        .ng-report-pagination {
            position: relative;
            z-index: 2;
            min-height: 62px;
            display: flex;
            align-items: center;
            justify-content: space-between;
            gap: 14px;
            padding: 14px 18px;
            background: rgba(255, 247, 235, .12);
            border-top: 1px solid rgba(114, 74, 41, .07);
        }

        .ng-report-pagination-info {
            color: #765d45;
            font-size: 12px;
            font-weight: 850;
        }

        .ng-report-pagination-info strong {
            color: #23160d;
            font-weight: 950;
        }

        .ng-report-pagination-actions {
            display: flex;
            align-items: center;
            justify-content: flex-end;
            gap: 8px;
            flex-wrap: wrap;
        }

        .ng-page-btn,
        .ng-page-number,
        .ng-page-dots {
            display: inline-flex;
            align-items: center;
            justify-content: center;
            min-height: 34px;
            border-radius: 12px;
            font-size: 11px;
            font-weight: 950;
            text-decoration: none !important;
            white-space: nowrap;
        }

        .ng-page-btn {
            padding: 0 13px;
            color: #fff !important;
            background: linear-gradient(135deg, #ff9d18, #ee6500);
            box-shadow: 0 10px 20px rgba(238, 101, 0, .20);
        }

        .ng-page-btn:hover {
            transform: translateY(-1px);
            box-shadow: 0 14px 26px rgba(238, 101, 0, .26);
        }

        .ng-page-btn.is-disabled {
            color: #9a8068 !important;
            background: rgba(255, 255, 255, .28);
            border: 1px solid rgba(255, 255, 255, .42);
            box-shadow: none;
            cursor: not-allowed;
        }

        .ng-page-numbers {
            display: flex;
            align-items: center;
            gap: 6px;
        }

        .ng-page-number,
        .ng-page-dots {
            min-width: 34px;
            padding: 0 9px;
            color: #6f5946 !important;
            background: rgba(255, 255, 255, .28);
            border: 1px solid rgba(255, 255, 255, .42);
        }

        .ng-page-number.is-active {
            color: #fff !important;
            background: linear-gradient(135deg, #ff9d18, #ee6500);
            border-color: transparent;
            box-shadow: 0 10px 20px rgba(238, 101, 0, .20);
        }

        .ng-page-dots {
            background: transparent;
            border-color: transparent;
        }


        /*
        |--------------------------------------------------------------------------
        | SIDEBAR EFFECT SYNC
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

        @media (max-width: 1500px) {
            .ng-report-hero-grid {
                grid-template-columns: 1fr;
            }

            .ng-kpi-grid {
                grid-template-columns: repeat(3, minmax(0, 1fr));
            }
        }

        @media (max-width: 1100px) {
            .ng-monthly-revenue-page {
                padding: 18px 18px 26px !important;
            }

            .ng-report-filter-card {
                align-items: flex-start;
                flex-direction: column;
            }

            .ng-report-filter-action {
                width: 100%;
            }

            .ng-primary-button {
                width: fit-content;
            }
        }

        @media (max-width: 700px) {
            .ng-monthly-revenue-page {
                padding: 14px 14px 22px !important;
            }

            .ng-kpi-grid {
                grid-template-columns: 1fr;
            }

            .ng-widget-head {
                align-items: flex-start;
                flex-direction: column;
            }

            .ng-widget-head h1 {
                font-size: 26px;
            }

            .ng-widget-card {
                padding: 16px;
                border-radius: 22px;
            }

            .ng-report-table-head {
                align-items: flex-start;
                flex-direction: column;
            }

            .ng-report-pagination {
                align-items: flex-start;
                flex-direction: column;
            }

            .ng-report-pagination-actions {
                width: 100%;
                justify-content: flex-start;
            }
        }
    </style>
</x-filament-panels::page>
