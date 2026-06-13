<x-filament-panels::page>
    @php
        $dashboard = $this->getDashboardData();
        $activePeriod = $dashboard['period']['key'];
        $charts = $dashboard['charts'];
        $user = auth()->user();

        $productSales = $charts['topProducts']['items'] ?? [];
        $maxProductUnits = max(1, (int) collect($productSales)->max('units'));
    @endphp

    <div class="ng-dashboard">
        <section class="ng-dashboard-header">
            <div class="ng-title-area">
                <h1>Dashboard Admin</h1>
                <p>Ringkasan performa penjualan toko Anda</p>
            </div>

            <div class="ng-filter-area">
                <div class="ng-period-tabs">
                    <a href="{{ request()->fullUrlWithQuery(['period' => 'today']) }}"
                       class="ng-tab {{ $activePeriod === 'today' ? 'active' : '' }}">
                        Hari Ini
                    </a>

                    <a href="{{ request()->fullUrlWithQuery(['period' => 'week']) }}"
                       class="ng-tab {{ $activePeriod === 'week' ? 'active' : '' }}">
                        Minggu Ini
                    </a>

                    <a href="{{ request()->fullUrlWithQuery(['period' => 'month']) }}"
                       class="ng-tab {{ $activePeriod === 'month' ? 'active' : '' }}">
                        Bulan Ini
                    </a>
                </div>

                <div class="ng-admin-profile">
                    <div class="ng-avatar">
                        {{ strtoupper(substr($user?->name ?? 'A', 0, 1)) }}
                    </div>

                    <div>
                        <strong>{{ $user?->name ?? 'Administrator' }}</strong>
                        <span>Super Admin</span>
                    </div>
                </div>
            </div>
        </section>

        <section class="ng-kpi-grid">
            @foreach ($dashboard['metrics'] as $metric)
                <article class="ng-kpi-card" style="--accent: {{ $metric['color'] }};">
                    <div class="ng-kpi-icon">
                        {{ $metric['icon'] }}
                    </div>

                    <div class="ng-kpi-content">
                        <div class="ng-kpi-label">
                            {{ $metric['label'] }}
                            <span>⋮</span>
                        </div>

                        <strong>{{ $metric['value'] }}</strong>

                        @if (! is_null($metric['trend']))
                            <p class="{{ $metric['trend'] >= 0 ? 'positive' : 'negative' }}">
                                {{ $metric['trend'] >= 0 ? '↑' : '↓' }}
                                {{ abs($metric['trend']) }}%
                                <span>dari periode sebelumnya</span>
                            </p>
                        @else
                            <p class="neutral">{{ $metric['caption'] }}</p>
                        @endif
                    </div>
                </article>
            @endforeach
        </section>

        <section class="ng-main-grid">
            <article class="ng-widget-card ng-revenue-card">
                <div class="ng-widget-head">
                    <div>
                        <h2>Revenue Performance</h2>
                        <p>{{ $dashboard['period']['start'] }} - {{ $dashboard['period']['end'] }}</p>
                    </div>

                    <span class="ng-widget-badge">{{ $dashboard['period']['label'] }}</span>
                </div>

                <div id="ngRevenueChart" class="ng-chart ng-chart-lg"></div>
            </article>

            <article class="ng-widget-card ng-product-sales-card">
                <div class="ng-widget-head">
                    <div>
                        <h2>Product Sales</h2>
                        <p>Semua informasi penjualan produk</p>
                    </div>

                    <span class="ng-widget-badge">Scroll</span>
                </div>

                <div class="ng-product-sales-scroll">
                    @forelse ($productSales as $index => $product)
                        @php
                            $barWidth = min(100, round(($product['units'] / $maxProductUnits) * 100));
                        @endphp

                        <div class="ng-product-sales-row">
                            <div class="ng-product-rank">
                                {{ $index + 1 }}
                            </div>

                            <div class="ng-product-sales-info">
                                <div class="ng-product-sales-top">
                                    <strong>{{ $product['name'] }}</strong>
                                    <span>{{ $product['units'] }} unit</span>
                                </div>

                                <div class="ng-product-sales-meta">
                                    <span>{{ $product['category'] }}</span>
                                    <span>{{ $this->rupiah($product['revenue']) }}</span>
                                    <span>Stok {{ $product['stock'] }}</span>
                                </div>

                                <div class="ng-product-sales-bar">
                                    <i style="width: {{ $barWidth }}%;"></i>
                                </div>
                            </div>
                        </div>
                    @empty
                        <div class="ng-empty-state">
                            Belum ada data penjualan produk.
                        </div>
                    @endforelse
                </div>
            </article>

            <article class="ng-widget-card ng-category-card">
                <div class="ng-widget-head">
                    <div>
                        <h2>Product Category Contribution</h2>
                        <p>Kontribusi kategori produk</p>
                    </div>

                    <span class="ng-widget-badge">Revenue</span>
                </div>

                <div class="ng-donut-wrap">
                    <div id="ngCategoryChart" class="ng-chart ng-chart-donut"></div>

                    <div class="ng-category-list">
                        @foreach ($charts['category']['summary'] as $category)
                            <div>
                                <span>{{ $category['name'] }}</span>
                                <strong>{{ $category['percentage'] }}%</strong>
                            </div>
                        @endforeach
                    </div>
                </div>
            </article>
        </section>

        <section class="ng-bottom-grid">
            <article class="ng-widget-card ng-time-card">
                <div class="ng-widget-head">
                    <div>
                        <h2>Sales by Time</h2>
                        <p>Jam ramai transaksi</p>
                    </div>

                    <span class="ng-widget-badge">Per Jam</span>
                </div>

                <div id="ngSalesTimeChart" class="ng-chart ng-chart-md"></div>
            </article>

            <article class="ng-widget-card ng-stock-card">
                <div class="ng-widget-head">
                    <div>
                        <h2>Stock Alert</h2>
                        <p>Produk yang perlu diperhatikan</p>
                    </div>

                    <a href="{{ url('/admin/products') }}">Lihat stock →</a>
                </div>

                <div class="ng-stock-list">
                    @forelse ($dashboard['stockAlerts'] as $stock)
                        <div class="ng-stock-row">
                            <div class="ng-product-mini">
                                @if ($stock['image'])
                                    <img src="{{ $stock['image'] }}" alt="{{ $stock['name'] }}">
                                @else
                                    <span>🥤</span>
                                @endif
                            </div>

                            <div class="ng-stock-name">
                                <strong>{{ $stock['name'] }}</strong>
                                <span>Stok tersedia</span>
                            </div>

                            <div class="ng-stock-number">{{ $stock['stock'] }}</div>

                            <span class="ng-stock-status {{ strtolower($stock['status']) }}">
                                {{ $stock['status'] }}
                            </span>
                        </div>
                    @empty
                        <div class="ng-empty-state">
                            Belum ada data produk.
                        </div>
                    @endforelse
                </div>
            </article>

            <article class="ng-widget-card ng-orders-card">
                <div class="ng-widget-head">
                    <div>
                        <h2>Latest Orders</h2>
                        <p>Transaksi terbaru</p>
                    </div>

                    <a href="{{ url('/admin/orders') }}">Lihat Semua</a>
                </div>

                <div class="ng-table-wrap">
                    <table class="ng-orders-table">
                        <thead>
                            <tr>
                                <th>Order ID</th>
                                <th>Waktu</th>
                                <th>Item</th>
                                <th>Total</th>
                                <th>Status</th>
                            </tr>
                        </thead>

                        <tbody>
                            @forelse ($dashboard['latestOrders'] as $order)
                                <tr>
                                    <td>{{ $order['order_code'] }}</td>
                                    <td>{{ $order['time'] }}</td>
                                    <td>{{ $order['items'] }}</td>
                                    <td>{{ $this->rupiah($order['total']) }}</td>
                                    <td>
                                        <span class="ng-order-status">
                                            {{ $order['status'] }}
                                        </span>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="5">Belum ada transaksi.</td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </article>
        </section>
    </div>

    <style>
        html,
        body {
            overflow-x: hidden !important;
        }

        body:has(.ng-dashboard) {
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

        body:has(.ng-dashboard) .fi-main,
        body:has(.ng-dashboard) .fi-main-ctn,
        body:has(.ng-dashboard) .fi-page,
        body:has(.ng-dashboard) .fi-page-content {
            width: 100% !important;
            max-width: 100% !important;
            background: transparent !important;
            overflow-x: hidden !important;
        }

        body:has(.ng-dashboard) .fi-page {
            padding: 0 !important;
        }

        body:has(.ng-dashboard) .fi-page-header {
            display: none !important;
        }

        body:has(.ng-dashboard) .fi-main {
            padding: 0 !important;
        }

        body:has(.ng-dashboard) .fi-sidebar {
            background: rgba(255, 250, 242, .50) !important;
            border-right: 1px solid rgba(255, 255, 255, .48) !important;
            box-shadow: 18px 0 55px rgba(137, 78, 26, .10) !important;
            backdrop-filter: blur(16px) !important;
        }

        body:has(.ng-dashboard) .fi-sidebar-nav {
            padding: 18px 14px !important;
        }

        body:has(.ng-dashboard) .fi-sidebar-item a {
            border-radius: 14px !important;
            color: #6f5844 !important;
            transition: .2s ease !important;
        }

        body:has(.ng-dashboard) .fi-sidebar-item-active a,
        body:has(.ng-dashboard) .fi-sidebar-item a:hover {
            background: linear-gradient(135deg, #ff9500, #f26a00) !important;
            color: #fff !important;
            box-shadow: 0 14px 24px rgba(242, 106, 0, .24) !important;
        }

        .ng-dashboard {
            width: 100% !important;
            max-width: 100% !important;
            min-height: 100vh;
            padding: 24px 24px 32px !important;
            overflow: hidden !important;
            font-family: Inter, Poppins, ui-sans-serif, system-ui, -apple-system, BlinkMacSystemFont, "Segoe UI", sans-serif;
            color: #24180f;
        }

        .ng-dashboard * {
            box-sizing: border-box;
        }

        .ng-dashboard-header {
            display: flex;
            align-items: flex-start;
            justify-content: space-between;
            gap: 18px;
            margin-bottom: 18px;
        }

        .ng-title-area {
            min-width: 250px;
        }

        .ng-kicker {
            display: inline-flex;
            align-items: center;
            width: fit-content;
            padding: 6px 12px;
            margin-bottom: 10px;
            border-radius: 999px;
            background: rgba(255, 255, 255, .50);
            border: 1px solid rgba(255, 255, 255, .58);
            color: #d95d00;
            font-size: 12px;
            font-weight: 900;
            letter-spacing: .10em;
            text-transform: uppercase;
            box-shadow: inset 0 1px 0 rgba(255, 255, 255, .70);
            backdrop-filter: blur(12px);
        }

        .ng-title-area h1 {
            margin: 0;
            color: #21160d;
            font-size: 30px;
            line-height: 1.05;
            font-weight: 950;
            letter-spacing: -.04em;
        }

        .ng-title-area p {
            margin: 8px 0 0;
            color: #765d45;
            font-size: 13px;
            font-weight: 650;
        }

        .ng-filter-area {
            display: flex;
            align-items: center;
            justify-content: flex-end;
            gap: 10px;
            flex-wrap: wrap;
            max-width: 100%;
        }

        .ng-period-tabs {
            height: 48px;
            display: flex;
            align-items: center;
            gap: 6px;
            padding: 5px;
            border-radius: 18px;
            background: rgba(255, 255, 255, .42);
            border: 1px solid rgba(255, 255, 255, .58);
            box-shadow: 0 18px 50px rgba(120, 74, 30, .09), inset 0 1px 0 rgba(255, 255, 255, .58);
            backdrop-filter: blur(13px);
        }

        .ng-tab {
            display: inline-flex;
            align-items: center;
            justify-content: center;
            min-height: 36px;
            padding: 0 18px;
            border-radius: 13px;
            color: #6b5541;
            font-size: 12px;
            font-weight: 900;
            text-decoration: none;
            transition: .2s ease;
        }

        .ng-tab.active,
        .ng-tab:hover {
            color: #fff;
            background: linear-gradient(135deg, #ff9d18, #ee6500);
            box-shadow: 0 12px 22px rgba(238, 101, 0, .24);
        }

        .ng-select-pill,
        .ng-admin-profile {
            min-height: 48px;
            border-radius: 16px;
            background: rgba(255, 255, 255, .42);
            border: 1px solid rgba(255, 255, 255, .58);
            box-shadow: 0 18px 50px rgba(120, 74, 30, .09), inset 0 1px 0 rgba(255, 255, 255, .58);
            backdrop-filter: blur(13px);
        }

        .ng-select-pill {
            min-width: 150px;
            display: inline-flex;
            align-items: center;
            justify-content: space-between;
            gap: 18px;
            padding: 0 15px;
            color: #5e4937;
            font-size: 12px;
            font-weight: 900;
        }

        .ng-admin-profile {
            display: flex;
            align-items: center;
            gap: 12px;
            padding: 7px 12px 7px 7px;
        }

        .ng-avatar {
            display: grid;
            place-items: center;
            width: 40px;
            height: 40px;
            border-radius: 50%;
            color: #fff;
            font-weight: 950;
            background: linear-gradient(135deg, #ff9b1a, #f05e00);
            box-shadow: 0 10px 22px rgba(240, 94, 0, .25);
        }

        .ng-admin-profile strong,
        .ng-admin-profile span {
            display: block;
            line-height: 1.2;
        }

        .ng-admin-profile strong {
            color: #2d1f16;
            font-size: 13px;
            font-weight: 950;
        }

        .ng-admin-profile span {
            margin-top: 3px;
            color: #7a614c;
            font-size: 11px;
            font-weight: 750;
        }

        .ng-kpi-grid {
            display: grid;
            grid-template-columns: repeat(6, minmax(0, 1fr));
            gap: 14px;
            margin-bottom: 18px;
        }

        .ng-kpi-card,
        .ng-widget-card {
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
        }

        .ng-kpi-card::before,
        .ng-widget-card::before {
            content: "";
            position: absolute;
            inset: 0;
            pointer-events: none;
            background:
                linear-gradient(120deg, rgba(255, 255, 255, .34), transparent 28%, transparent 70%, rgba(255, 255, 255, .16));
            opacity: .38;
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
        }

        .ng-kpi-content strong {
            display: block;
            margin-top: 7px;
            color: #23160d;
            font-size: 19px;
            line-height: 1.15;
            font-weight: 950;
            letter-spacing: -.03em;
            white-space: nowrap;
            overflow: hidden;
            text-overflow: ellipsis;
        }

        .ng-kpi-content p {
            margin: 8px 0 0;
            font-size: 11px;
            line-height: 1.25;
            font-weight: 850;
        }

        .ng-kpi-content p span {
            margin-left: 4px;
            color: #6f5946;
            font-weight: 750;
        }

        .ng-kpi-content .positive {
            color: #07945d;
        }

        .ng-kpi-content .negative {
            color: #e23b3b;
        }

        .ng-kpi-content .neutral {
            color: #6f5946;
        }

        .ng-main-grid {
            display: grid;
            grid-template-columns: 1.35fr 1fr 1fr;
            gap: 16px;
            margin-bottom: 16px;
        }

        .ng-bottom-grid {
            display: grid;
            grid-template-columns: 1.1fr .82fr 1.35fr;
            gap: 16px;
        }

        .ng-widget-card {
            border-radius: 24px;
            padding: 18px;
            min-width: 0;
        }

        .ng-widget-head {
            position: relative;
            z-index: 2;
            display: flex;
            align-items: flex-start;
            justify-content: space-between;
            gap: 14px;
            margin-bottom: 8px;
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
            margin: 5px 0 0;
            color: #7b624c;
            font-size: 11px;
            font-weight: 800;
        }

        .ng-widget-head a,
        .ng-widget-badge {
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

        .ng-chart {
            position: relative;
            z-index: 2;
            width: 100%;
        }

        .ng-chart,
        .ng-chart > div,
        .ng-chart svg,
        .apexcharts-canvas {
            max-width: 100% !important;
        }

        .ng-chart-lg {
            min-height: 260px;
        }

        .ng-chart-md {
            min-height: 230px;
        }

        .ng-chart-donut {
            min-width: 0;
            min-height: 230px;
        }

        .ng-product-sales-scroll {
            position: relative;
            z-index: 2;
            display: grid;
            gap: 9px;
            max-height: 250px;
            overflow-y: auto;
            padding-right: 5px;
        }

        .ng-product-sales-scroll::-webkit-scrollbar {
            width: 6px;
        }

        .ng-product-sales-scroll::-webkit-scrollbar-track {
            background: rgba(255, 255, 255, .28);
            border-radius: 999px;
        }

        .ng-product-sales-scroll::-webkit-scrollbar-thumb {
            background: rgba(249, 115, 22, .55);
            border-radius: 999px;
        }

        .ng-product-sales-row {
            display: grid;
            grid-template-columns: 34px minmax(0, 1fr);
            align-items: center;
            gap: 10px;
            min-height: 56px;
            padding: 8px;
            border-radius: 16px;
            background: rgba(255, 255, 255, .24);
            border: 1px solid rgba(255, 255, 255, .38);
        }

        .ng-product-rank {
            display: grid;
            place-items: center;
            width: 34px;
            height: 34px;
            border-radius: 12px;
            color: #f97316;
            background: rgba(249, 115, 22, .12);
            font-size: 12px;
            font-weight: 950;
        }

        .ng-product-sales-info {
            min-width: 0;
        }

        .ng-product-sales-top {
            display: flex;
            align-items: center;
            justify-content: space-between;
            gap: 10px;
            min-width: 0;
        }

        .ng-product-sales-top strong {
            display: block;
            min-width: 0;
            overflow: hidden;
            color: #2b1b10;
            font-size: 12px;
            font-weight: 950;
            white-space: nowrap;
            text-overflow: ellipsis;
        }

        .ng-product-sales-top span {
            flex: 0 0 auto;
            color: #2b1b10;
            font-size: 11px;
            font-weight: 950;
        }

        .ng-product-sales-meta {
            display: flex;
            align-items: center;
            gap: 8px;
            margin-top: 4px;
            min-width: 0;
            overflow: hidden;
        }

        .ng-product-sales-meta span {
            color: #8b7057;
            font-size: 10px;
            font-weight: 800;
            white-space: nowrap;
        }

        .ng-product-sales-bar {
            width: 100%;
            height: 7px;
            margin-top: 7px;
            overflow: hidden;
            border-radius: 999px;
            background: rgba(249, 115, 22, .11);
        }

        .ng-product-sales-bar i {
            display: block;
            height: 100%;
            border-radius: inherit;
            background: linear-gradient(90deg, #ff9d18, #f97316);
        }

        .ng-donut-wrap {
            position: relative;
            z-index: 2;
            display: grid;
            grid-template-columns: minmax(0, 1.25fr) minmax(125px, .75fr);
            align-items: center;
            gap: 10px;
            overflow: hidden;
        }

        .ng-category-list {
            display: grid;
            gap: 10px;
            min-width: 0;
            width: 100%;
            overflow: hidden;
        }

        .ng-category-list div {
            display: grid;
            grid-template-columns: minmax(0, 1fr) auto;
            align-items: center;
            gap: 8px;
            color: #6d5540;
            font-size: 12px;
            font-weight: 850;
        }

        .ng-category-list span {
            display: block;
            overflow: hidden;
            white-space: nowrap;
            text-overflow: ellipsis;
        }

        .ng-category-list strong {
            color: #2a1b10;
            font-size: 12px;
            font-weight: 950;
        }

        .ng-stock-list {
            position: relative;
            z-index: 2;
            display: grid;
            gap: 10px;
        }

        .ng-stock-row {
            display: grid;
            grid-template-columns: 38px minmax(0, 1fr) 34px 60px;
            align-items: center;
            gap: 9px;
            min-height: 46px;
            padding: 7px;
            border-radius: 16px;
            background: rgba(255, 255, 255, .24);
            border: 1px solid rgba(255, 255, 255, .38);
        }

        .ng-product-mini {
            display: grid;
            place-items: center;
            width: 38px;
            height: 38px;
            border-radius: 13px;
            overflow: hidden;
            background: rgba(255, 237, 210, .75);
        }

        .ng-product-mini img {
            width: 100%;
            height: 100%;
            object-fit: cover;
        }

        .ng-stock-name {
            min-width: 0;
        }

        .ng-stock-name strong,
        .ng-stock-name span {
            display: block;
            line-height: 1.2;
        }

        .ng-stock-name strong {
            overflow: hidden;
            color: #2b1b10;
            font-size: 12px;
            font-weight: 950;
            white-space: nowrap;
            text-overflow: ellipsis;
        }

        .ng-stock-name span {
            margin-top: 3px;
            color: #8b7057;
            font-size: 10px;
            font-weight: 750;
        }

        .ng-stock-number {
            color: #2b1b10;
            font-size: 12px;
            font-weight: 950;
            text-align: center;
        }

        .ng-stock-status,
        .ng-order-status {
            display: inline-flex;
            align-items: center;
            justify-content: center;
            min-height: 26px;
            padding: 0 8px;
            border-radius: 10px;
            font-size: 10px;
            font-weight: 950;
        }

        .ng-stock-status.habis {
            color: #d73333;
            background: rgba(255, 98, 98, .13);
        }

        .ng-stock-status.low {
            color: #d76a00;
            background: rgba(255, 159, 64, .16);
        }

        .ng-stock-status.aman {
            color: #078657;
            background: rgba(16, 185, 129, .14);
        }

        .ng-orders-card {
            overflow: hidden;
        }

        .ng-table-wrap {
            position: relative;
            z-index: 2;
            width: 100%;
            max-width: 100%;
            overflow-x: auto;
        }

        .ng-orders-table {
            width: 100%;
            min-width: 520px;
            border-collapse: collapse;
        }

        .ng-orders-table th {
            color: #6f5946;
            font-size: 11px;
            font-weight: 950;
            text-align: left;
            padding: 8px 9px;
            white-space: nowrap;
            border-bottom: 1px solid rgba(114, 74, 41, .10);
        }

        .ng-orders-table td {
            color: #352316;
            font-size: 11px;
            font-weight: 750;
            padding: 9px;
            white-space: nowrap;
            border-bottom: 1px solid rgba(114, 74, 41, .08);
        }

        .ng-orders-table tbody tr:hover {
            background: rgba(255, 255, 255, .30);
        }

        .ng-order-status {
            color: #078657;
            background: rgba(16, 185, 129, .14);
        }

        .ng-empty-state {
            position: relative;
            z-index: 2;
            padding: 18px;
            border-radius: 16px;
            color: #7b624c;
            background: rgba(255, 255, 255, .30);
            font-size: 13px;
            font-weight: 850;
            text-align: center;
        }

        @media (max-width: 1500px) {
            .ng-kpi-grid {
                grid-template-columns: repeat(3, minmax(0, 1fr));
            }

            .ng-main-grid {
                grid-template-columns: 1.3fr 1fr;
            }

            .ng-category-card {
                grid-column: span 2;
            }

            .ng-bottom-grid {
                grid-template-columns: 1fr 1fr;
            }

            .ng-orders-card {
                grid-column: span 2;
            }
        }

        @media (max-width: 1100px) {
            .ng-dashboard-header {
                flex-direction: column;
                align-items: flex-start;
            }

            .ng-filter-area {
                justify-content: flex-start;
            }

            .ng-kpi-grid,
            .ng-main-grid,
            .ng-bottom-grid {
                grid-template-columns: 1fr;
            }

            .ng-category-card,
            .ng-orders-card {
                grid-column: span 1;
            }

            .ng-donut-wrap {
                grid-template-columns: 1fr;
            }
        }
    </style>

  <script>
    window.ngDashboardChartsData = @json($charts);
    window.ngDashboardApexInstances = window.ngDashboardApexInstances || {};

    function ngLoadApexCharts(callback) {
        if (window.ApexCharts) {
            callback();
            return;
        }

        const existingScript = document.getElementById('ng-apexcharts-script');

        if (existingScript) {
            existingScript.addEventListener('load', callback, { once: true });
            return;
        }

        const script = document.createElement('script');
        script.id = 'ng-apexcharts-script';
        script.src = 'https://cdn.jsdelivr.net/npm/apexcharts';
        script.onload = callback;

        document.head.appendChild(script);
    }

    function ngFormatRupiah(value) {
        return 'Rp ' + Number(value || 0).toLocaleString('id-ID');
    }

    function ngDestroyDashboardCharts() {
        Object.keys(window.ngDashboardApexInstances || {}).forEach(function (key) {
            const chart = window.ngDashboardApexInstances[key];

            if (chart && typeof chart.destroy === 'function') {
                try {
                    chart.destroy();
                } catch (error) {
                    console.warn('Chart destroy skipped:', key);
                }
            }

            delete window.ngDashboardApexInstances[key];
        });

        document.querySelectorAll('.ng-chart').forEach(function (el) {
            el.innerHTML = '';
        });
    }

    function ngRenderChart(selector, key, options) {
        const el = document.querySelector(selector);

        if (!el || !window.ApexCharts) {
            return;
        }

        if (window.ngDashboardApexInstances[key]) {
            return;
        }

        el.innerHTML = '';

        const chart = new ApexCharts(el, options);

        window.ngDashboardApexInstances[key] = chart;

        chart.render();
    }

    function ngInitDashboardCharts() {
        const dashboard = document.querySelector('.ng-dashboard');

        if (!dashboard) {
            return;
        }

        const charts = window.ngDashboardChartsData;

        if (!charts || !window.ApexCharts) {
            return;
        }

        ngRenderChart('#ngRevenueChart', 'revenue', {
            chart: {
                type: 'area',
                height: 260,
                toolbar: { show: false },
                fontFamily: 'Inter, Poppins, sans-serif',
                foreColor: '#7a6048',
                zoom: { enabled: false },
                animations: {
                    enabled: true,
                    speed: 450,
                    animateGradually: {
                        enabled: false,
                    },
                    dynamicAnimation: {
                        enabled: false,
                    },
                },
            },
            series: [
                {
                    name: 'Revenue',
                    data: charts.revenue.revenue,
                },
            ],
            colors: ['#f97316'],
            stroke: {
                curve: 'smooth',
                width: 3,
            },
            fill: {
                type: 'gradient',
                gradient: {
                    shadeIntensity: 0.2,
                    opacityFrom: 0.34,
                    opacityTo: 0.03,
                    stops: [0, 95, 100],
                },
            },
            grid: {
                borderColor: 'rgba(103, 65, 33, .10)',
                strokeDashArray: 4,
                padding: {
                    left: 8,
                    right: 14,
                },
            },
            dataLabels: { enabled: false },
            markers: {
                size: 4,
                strokeWidth: 3,
                strokeColors: '#fff8ef',
                hover: { size: 7 },
            },
            xaxis: {
                categories: charts.revenue.labels,
                axisBorder: { show: false },
                axisTicks: { show: false },
                labels: {
                    style: {
                        fontSize: '11px',
                        fontWeight: 750,
                    },
                },
            },
            yaxis: {
                labels: {
                    formatter: function (value) {
                        if (value >= 1000000) {
                            return 'Rp ' + (value / 1000000).toFixed(1).replace('.0', '') + 'M';
                        }

                        if (value >= 1000) {
                            return 'Rp ' + (value / 1000).toFixed(0) + 'K';
                        }

                        return 'Rp ' + value;
                    },
                },
            },
            tooltip: {
                theme: 'light',
                y: {
                    formatter: ngFormatRupiah,
                },
            },
        });

        ngRenderChart('#ngCategoryChart', 'category', {
            chart: {
                type: 'donut',
                height: 230,
                fontFamily: 'Inter, Poppins, sans-serif',
                animations: {
                    enabled: true,
                    speed: 350,
                    animateGradually: {
                        enabled: false,
                    },
                    dynamicAnimation: {
                        enabled: false,
                    },
                },
            },
            series: charts.category.values,
            labels: charts.category.labels,
            colors: ['#f97316', '#10b981', '#3b82f6', '#8b5cf6', '#ef4444'],
            stroke: {
                width: 4,
                colors: ['rgba(255, 248, 237, .92)'],
            },
            plotOptions: {
                pie: {
                    donut: {
                        size: '68%',
                        labels: {
                            show: true,
                            name: {
                                show: true,
                                color: '#7a6048',
                                fontSize: '12px',
                                fontWeight: 800,
                            },
                            value: {
                                show: true,
                                color: '#24180f',
                                fontSize: '16px',
                                fontWeight: 950,
                                formatter: ngFormatRupiah,
                            },
                            total: {
                                show: true,
                                label: 'Total Revenue',
                                color: '#7a6048',
                                formatter: function (w) {
                                    const total = w.globals.seriesTotals.reduce((a, b) => a + b, 0);
                                    return ngFormatRupiah(total);
                                },
                            },
                        },
                    },
                },
            },
            dataLabels: { enabled: false },
            legend: { show: false },
            tooltip: {
                y: {
                    formatter: ngFormatRupiah,
                },
            },
        });

        ngRenderChart('#ngSalesTimeChart', 'salesTime', {
            chart: {
                type: 'bar',
                height: 230,
                toolbar: { show: false },
                fontFamily: 'Inter, Poppins, sans-serif',
                foreColor: '#7a6048',
                animations: {
                    enabled: true,
                    speed: 350,
                    animateGradually: {
                        enabled: false,
                    },
                    dynamicAnimation: {
                        enabled: false,
                    },
                },
            },
            series: [
                {
                    name: 'Orders',
                    data: charts.salesByTime.orders,
                },
            ],
            colors: ['#f97316'],
            plotOptions: {
                bar: {
                    borderRadius: 7,
                    columnWidth: '46%',
                },
            },
            grid: {
                borderColor: 'rgba(103, 65, 33, .09)',
                strokeDashArray: 4,
            },
            dataLabels: { enabled: false },
            xaxis: {
                categories: charts.salesByTime.labels,
                axisBorder: { show: false },
                axisTicks: { show: false },
                labels: {
                    rotate: 0,
                    hideOverlappingLabels: true,
                    trim: false,
                    style: {
                        fontSize: '10px',
                        fontWeight: 750,
                    },
                },
            },
            yaxis: {
                labels: {
                    formatter: function (value) {
                        return Math.round(value);
                    },
                },
            },
            tooltip: {
                x: {
                    formatter: function (value) {
                        return value || '';
                    },
                },
                y: {
                    formatter: function (value) {
                        return value + ' orders';
                    },
                },
            },
        });
    }

    function ngStartDashboardCharts() {
        ngLoadApexCharts(function () {
            requestAnimationFrame(function () {
                ngInitDashboardCharts();
            });
        });
    }

    document.addEventListener('DOMContentLoaded', ngStartDashboardCharts);

    document.addEventListener('livewire:navigating', function () {
        ngDestroyDashboardCharts();
    });

    document.addEventListener('livewire:navigated', function () {
        window.ngDashboardApexInstances = {};
        ngStartDashboardCharts();
    });

    window.addEventListener('pageshow', function () {
        ngStartDashboardCharts();
    });
</script>
</x-filament-panels::page>