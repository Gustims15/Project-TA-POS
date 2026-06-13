<x-filament-panels::page>
    @php
        $order = $record;
        $order->loadMissing('items');

        $items = $order->items ?? collect();
        $date = $order->ordered_at ?? $order->created_at;

        $backUrl = \App\Filament\Admin\Resources\Orders\OrderResource::getUrl('index');

        $status = $order->status ?? '-';

        $statusStyle = match ($status) {
            'Selesai' => [
                'color' => '#078657',
                'bg' => 'rgba(16,185,129,.13)',
                'border' => 'rgba(16,185,129,.24)',
                'icon' => '✓',
            ],
            'Diproses' => [
                'color' => '#d76a00',
                'bg' => 'rgba(255,159,64,.16)',
                'border' => 'rgba(255,159,64,.26)',
                'icon' => '⏱',
            ],
            'Dibatalkan' => [
                'color' => '#d73333',
                'bg' => 'rgba(255,98,98,.13)',
                'border' => 'rgba(255,98,98,.24)',
                'icon' => '×',
            ],
            default => [
                'color' => '#64748b',
                'bg' => 'rgba(148,163,184,.12)',
                'border' => 'rgba(148,163,184,.24)',
                'icon' => '?',
            ],
        };

        $cards = [
            [
                'label' => 'ID Order',
                'value' => $order->order_code ?? 'ORD-' . $order->id,
                'caption' => 'Kode transaksi',
                'icon' => '▣',
                'color' => '#f97316',
            ],
            [
                'label' => 'Total Item',
                'value' => number_format((int) $order->total_item, 0, ',', '.'),
                'caption' => 'Item dibeli',
                'icon' => '◇',
                'color' => '#3b82f6',
            ],
            [
                'label' => 'Total Pembayaran',
                'value' => 'Rp ' . number_format((int) $order->total_price, 0, ',', '.'),
                'caption' => 'Revenue transaksi',
                'icon' => '✓',
                'color' => '#10b981',
            ],
            [
                'label' => 'Waktu Order',
                'value' => $date ? \Carbon\Carbon::parse($date)->format('H:i') . ' WIB' : '-',
                'caption' => $date ? \Carbon\Carbon::parse($date)->translatedFormat('d M Y') : '-',
                'icon' => '↗',
                'color' => '#8b5cf6',
            ],
        ];
    @endphp

    <div class="ng-order-detail-page">
        <section class="ng-order-detail-hero">
            <article class="ng-order-detail-hero-main">
                <div>
                    <h1>Detail Transaksi</h1>
                    <p>
                        Informasi lengkap transaksi, total pembayaran, waktu order, status pesanan,
                        dan rincian produk yang dibeli.
                    </p>
                </div>

                <a href="{{ $backUrl }}" class="ng-order-back-btn">
                    ← Kembali
                </a>
            </article>

            <article class="ng-order-detail-hero-side">
                <span>Order Terpilih</span>
                <strong>{{ $order->order_code ?? 'ORD-' . $order->id }}</strong>
                <small>{{ $date ? \Carbon\Carbon::parse($date)->translatedFormat('d F Y H:i') : '-' }}</small>
            </article>
        </section>

        <section class="ng-order-detail-kpi-grid">
            @foreach ($cards as $card)
                <article class="ng-order-detail-kpi" style="--accent: {{ $card['color'] }};">
                    <div class="ng-order-detail-kpi-icon">
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

        <section class="ng-order-detail-grid">
            <article class="ng-order-detail-card ng-order-info-card">
                <div class="ng-order-card-head">
                    <div>
                        <h2>Informasi Order</h2>
                        <p>Ringkasan utama dari transaksi yang dipilih.</p>
                    </div>

                    <span class="ng-status-pill"
                          style="--status-color: {{ $statusStyle['color'] }}; --status-bg: {{ $statusStyle['bg'] }}; --status-border: {{ $statusStyle['border'] }};">
                        {{ $statusStyle['icon'] }} {{ $status }}
                    </span>
                </div>

                <div class="ng-order-info-list">
                    <div>
                        <span>ID Order</span>
                        <strong>{{ $order->order_code ?? 'ORD-' . $order->id }}</strong>
                    </div>

                    <div>
                        <span>Status</span>
                        <strong>{{ $status }}</strong>
                    </div>

                    <div>
                        <span>Total Item</span>
                        <strong>{{ number_format((int) $order->total_item, 0, ',', '.') }}</strong>
                    </div>

                    <div>
                        <span>Total Pembayaran</span>
                        <strong>Rp {{ number_format((int) $order->total_price, 0, ',', '.') }}</strong>
                    </div>

                    <div class="span-2">
                        <span>Waktu Order</span>
                        <strong>{{ $date ? \Carbon\Carbon::parse($date)->translatedFormat('d F Y H:i') : '-' }}</strong>
                    </div>
                </div>
            </article>

            <article class="ng-order-detail-card ng-order-summary-card">
                <div class="ng-order-card-head">
                    <div>
                        <h2>Payment Summary</h2>
                        <p>Total pembayaran transaksi.</p>
                    </div>
                </div>

                <div class="ng-payment-total">
                    <span>Total Pembayaran</span>
                    <strong>Rp {{ number_format((int) $order->total_price, 0, ',', '.') }}</strong>
                    <p>{{ number_format((int) $order->total_item, 0, ',', '.') }} item dalam transaksi ini</p>
                </div>
            </article>
        </section>

        <section class="ng-order-detail-card ng-order-items-card">
            <div class="ng-order-card-head">
                <div>
                    <h2>Detail Item</h2>
                    <p>Daftar produk yang dibeli pada transaksi ini.</p>
                </div>

                <span class="ng-order-count-pill">
                    {{ number_format($items->count(), 0, ',', '.') }} Produk
                </span>
            </div>

            <div class="ng-order-items-list">
                @forelse ($items as $item)
                    <div class="ng-order-item-row">
                        <div class="ng-order-item-number">
                            {{ $loop->iteration }}
                        </div>

                        <div class="ng-order-item-name">
                            <strong>{{ $item->product_name ?? '-' }}</strong>
                            <span>Size: {{ $item->size_name ?? 'Regular' }}</span>
                        </div>

                        <div class="ng-order-item-chip">
                            Qty {{ number_format((int) $item->quantity, 0, ',', '.') }}
                        </div>

                        <div class="ng-order-item-chip muted">
                            Rp {{ number_format((int) $item->price, 0, ',', '.') }}
                        </div>

                        <div class="ng-order-item-subtotal">
                            <span>Subtotal</span>
                            <strong>Rp {{ number_format((int) $item->subtotal, 0, ',', '.') }}</strong>
                        </div>
                    </div>
                @empty
                    <div class="ng-empty-order">
                        <strong>Tidak ada item</strong>
                        <span>Order ini belum memiliki detail item.</span>
                    </div>
                @endforelse
            </div>
        </section>
    </div>

    <style>
        html,
        body {
            overflow-x: hidden !important;
        }

        body:has(.ng-order-detail-page) {
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

        body:has(.ng-order-detail-page) .fi-main,
        body:has(.ng-order-detail-page) .fi-main-ctn,
        body:has(.ng-order-detail-page) .fi-page,
        body:has(.ng-order-detail-page) .fi-page-content {
            width: 100% !important;
            max-width: 100% !important;
            background: transparent !important;
            overflow-x: hidden !important;
        }

        body:has(.ng-order-detail-page) .fi-page {
            padding: 0 !important;
        }

        body:has(.ng-order-detail-page) .fi-page-header {
            display: none !important;
        }

        body:has(.ng-order-detail-page) .fi-main {
            padding: 0 !important;
        }

        body:has(.ng-order-detail-page) .fi-sidebar {
            background: rgba(255, 250, 242, .50) !important;
            border-right: 1px solid rgba(255, 255, 255, .48) !important;
            box-shadow: 18px 0 55px rgba(137, 78, 26, .10) !important;
            backdrop-filter: blur(16px) !important;
        }

        body:has(.ng-order-detail-page) .fi-sidebar-nav {
            padding: 18px 14px !important;
        }

        body:has(.ng-order-detail-page) .fi-sidebar-item a {
            border-radius: 14px !important;
            color: #6f5844 !important;
            transition: .2s ease !important;
        }

        body:has(.ng-order-detail-page) .fi-sidebar-item-active a,
        body:has(.ng-order-detail-page) .fi-sidebar-item a:hover {
            background: linear-gradient(135deg, #ff9500, #f26a00) !important;
            color: #fff !important;
            box-shadow: 0 14px 24px rgba(242, 106, 0, .24) !important;
        }

        .ng-order-detail-page {
            width: 100%;
            min-height: 100vh;
            padding: 18px 18px 28px;
            font-family: Inter, Poppins, ui-sans-serif, system-ui, -apple-system, BlinkMacSystemFont, "Segoe UI", sans-serif;
            color: #24180f;
        }

        .ng-order-detail-page * {
            box-sizing: border-box;
        }

        .ng-order-detail-hero {
            display: grid;
            grid-template-columns: minmax(0, 1.35fr) minmax(340px, .65fr);
            gap: 12px;
            margin-bottom: 12px;
        }

        .ng-order-detail-hero-main,
        .ng-order-detail-hero-side,
        .ng-order-detail-kpi,
        .ng-order-detail-card {
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

        .ng-order-detail-hero-main {
            min-height: 126px;
            display: flex;
            align-items: center;
            justify-content: space-between;
            gap: 18px;
            padding: 20px 22px;
            border-radius: 24px;
        }

        .ng-order-detail-hero-side {
            min-height: 126px;
            display: flex;
            flex-direction: column;
            justify-content: center;
            padding: 20px 22px;
            border-radius: 24px;
        }

        .ng-order-kicker {
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

        .ng-order-detail-hero-main h1 {
            margin: 0;
            color: #21160d;
            font-size: 30px;
            line-height: 1.05;
            font-weight: 950;
            letter-spacing: -.04em;
        }

        .ng-order-detail-hero-main p {
            max-width: 760px;
            margin: 7px 0 0;
            color: #765d45;
            font-size: 12px;
            font-weight: 650;
            line-height: 1.5;
        }

        .ng-order-back-btn {
            display: inline-flex;
            align-items: center;
            justify-content: center;
            min-height: 42px;
            padding: 0 17px;
            border-radius: 15px;
            color: #fff !important;
            background: linear-gradient(135deg, #ff9d18, #ee6500);
            box-shadow: 0 14px 26px rgba(238, 101, 0, .26);
            font-size: 12px;
            font-weight: 950;
            text-decoration: none !important;
            white-space: nowrap;
        }

        .ng-order-detail-hero-side span,
        .ng-order-detail-hero-side small {
            display: block;
            color: #765d45;
            font-size: 11px;
            font-weight: 850;
        }

        .ng-order-detail-hero-side strong {
            display: block;
            margin: 7px 0;
            color: #21160d;
            font-size: 22px;
            line-height: 1.1;
            font-weight: 950;
        }

        .ng-order-detail-kpi-grid {
            display: grid;
            grid-template-columns: repeat(4, minmax(0, 1fr));
            gap: 10px;
            margin-bottom: 12px;
        }

        .ng-order-detail-kpi {
            min-height: 90px;
            display: flex;
            align-items: center;
            gap: 11px;
            padding: 14px;
            border-radius: 20px;
        }

        .ng-order-detail-kpi-icon {
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

        .ng-order-detail-kpi span {
            display: block;
            color: #6f5946;
            font-size: 11px;
            font-weight: 900;
        }

        .ng-order-detail-kpi strong {
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

        .ng-order-detail-kpi p {
            margin: 6px 0 0;
            color: #6f5946;
            font-size: 10px;
            font-weight: 850;
        }

        .ng-order-detail-grid {
            display: grid;
            grid-template-columns: minmax(0, 1.35fr) minmax(320px, .65fr);
            gap: 12px;
            margin-bottom: 12px;
        }

        .ng-order-detail-card {
            border-radius: 24px;
        }

        .ng-order-card-head {
            min-height: 58px;
            display: flex;
            align-items: center;
            justify-content: space-between;
            gap: 14px;
            padding: 15px 20px;
            background: rgba(255, 247, 235, .10);
            border-bottom: 1px solid rgba(114, 74, 41, .07);
        }

        .ng-order-card-head h2 {
            margin: 0;
            color: #25170d;
            font-size: 17px;
            line-height: 1.2;
            font-weight: 950;
            letter-spacing: -.03em;
        }

        .ng-order-card-head p {
            margin: 5px 0 0;
            color: #7b624c;
            font-size: 12px;
            font-weight: 750;
        }

        .ng-status-pill {
            display: inline-flex;
            align-items: center;
            justify-content: center;
            gap: 6px;
            min-height: 30px;
            padding: 0 12px;
            border-radius: 999px;
            color: var(--status-color);
            background: var(--status-bg);
            border: 1px solid var(--status-border);
            font-size: 11px;
            font-weight: 950;
            white-space: nowrap;
        }

        .ng-order-info-list {
            display: grid;
            grid-template-columns: repeat(2, minmax(0, 1fr));
            gap: 10px;
            padding: 18px 20px 20px;
        }

        .ng-order-info-list div {
            min-height: 74px;
            padding: 14px;
            border-radius: 18px;
            background: rgba(255, 255, 255, .20);
            border: 1px solid rgba(255, 255, 255, .38);
        }

        .ng-order-info-list .span-2 {
            grid-column: span 2;
        }

        .ng-order-info-list span {
            display: block;
            color: #6f5946;
            font-size: 11px;
            font-weight: 900;
        }

        .ng-order-info-list strong {
            display: block;
            margin-top: 7px;
            color: #23160d;
            font-size: 14px;
            font-weight: 950;
        }

        .ng-payment-total {
            padding: 22px;
        }

        .ng-payment-total span,
        .ng-payment-total p {
            display: block;
            color: #6f5946;
            font-size: 12px;
            font-weight: 850;
        }

        .ng-payment-total strong {
            display: block;
            margin: 10px 0;
            color: #21160d;
            font-size: 30px;
            line-height: 1.1;
            font-weight: 950;
            letter-spacing: -.04em;
        }

        .ng-order-count-pill {
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

        .ng-order-items-list {
            padding: 14px;
            display: grid;
            gap: 10px;
        }

        .ng-order-item-row {
            display: grid;
            grid-template-columns: 40px minmax(0, 1fr) auto auto minmax(150px, auto);
            align-items: center;
            gap: 10px;
            min-height: 64px;
            padding: 10px;
            border-radius: 18px;
            background: rgba(255, 255, 255, .20);
            border: 1px solid rgba(255, 255, 255, .38);
        }

        .ng-order-item-number {
            display: grid;
            place-items: center;
            width: 40px;
            height: 40px;
            border-radius: 14px;
            color: #fff;
            background: linear-gradient(135deg, #ff9d18, #ee6500);
            box-shadow: 0 12px 22px rgba(238, 101, 0, .20);
            font-size: 13px;
            font-weight: 950;
        }

        .ng-order-item-name {
            min-width: 0;
        }

        .ng-order-item-name strong,
        .ng-order-item-name span {
            display: block;
        }

        .ng-order-item-name strong {
            color: #23160d;
            font-size: 13px;
            line-height: 1.25;
            font-weight: 950;
            overflow: hidden;
            white-space: nowrap;
            text-overflow: ellipsis;
        }

        .ng-order-item-name span {
            margin-top: 4px;
            color: #8b7057;
            font-size: 11px;
            font-weight: 750;
        }

        .ng-order-item-chip {
            display: inline-flex;
            align-items: center;
            justify-content: center;
            min-height: 28px;
            padding: 0 10px;
            border-radius: 999px;
            color: #2563eb;
            background: rgba(59, 130, 246, .10);
            border: 1px solid rgba(59, 130, 246, .20);
            font-size: 10px;
            font-weight: 950;
            white-space: nowrap;
        }

        .ng-order-item-chip.muted {
            color: #4b3525;
            background: rgba(255, 255, 255, .28);
            border-color: rgba(255, 255, 255, .42);
        }

        .ng-order-item-subtotal {
            text-align: right;
        }

        .ng-order-item-subtotal span {
            display: block;
            color: #8b7057;
            font-size: 10px;
            font-weight: 850;
        }

        .ng-order-item-subtotal strong {
            display: block;
            margin-top: 4px;
            color: #078657;
            font-size: 13px;
            font-weight: 950;
            white-space: nowrap;
        }

        .ng-empty-order {
            padding: 18px;
            border-radius: 18px;
            background: rgba(255, 255, 255, .20);
            border: 1px solid rgba(255, 255, 255, .38);
        }

        .ng-empty-order strong,
        .ng-empty-order span {
            display: block;
        }

        .ng-empty-order strong {
            color: #23160d;
            font-size: 14px;
            font-weight: 950;
        }

        .ng-empty-order span {
            margin-top: 5px;
            color: #765d45;
            font-size: 12px;
            font-weight: 750;
        }

        @media (max-width: 1500px) {
            .ng-order-detail-hero,
            .ng-order-detail-grid {
                grid-template-columns: 1fr;
            }

            .ng-order-detail-kpi-grid {
                grid-template-columns: repeat(2, minmax(0, 1fr));
            }
        }

        @media (max-width: 900px) {
            .ng-order-detail-page {
                padding: 14px;
            }

            .ng-order-detail-hero-main {
                align-items: flex-start;
                flex-direction: column;
            }

            .ng-order-detail-kpi-grid,
            .ng-order-info-list {
                grid-template-columns: 1fr;
            }

            .ng-order-info-list .span-2 {
                grid-column: span 1;
            }

            .ng-order-item-row {
                grid-template-columns: 40px minmax(0, 1fr);
            }

            .ng-order-item-chip,
            .ng-order-item-subtotal {
                grid-column: 2;
                justify-self: start;
                text-align: left;
            }
        }
    </style>
</x-filament-panels::page>