@php
    $finance = $this->getFinancialDashboardData();
    $activePeriod = $finance['period']['key'];
    $user = auth()->user();

    $periods = [
        'today' => 'Hari Ini',
        'week' => 'Minggu Ini',
        'month' => 'Bulan Ini',
        'year' => 'Tahun Ini',
    ];
@endphp

<x-filament-panels::page>
    <div class="finance-page">
        <div class="finance-header">
            <div>
                <h1>Dashboard Keuangan</h1>
                <p>Ringkasan HPP, biaya operasional, laba, margin, dan target penjualan.</p>
            </div>

            <div class="finance-filter">
                @foreach ($periods as $key => $label)
                    <a
                        href="{{ request()->fullUrlWithQuery(['period' => $key]) }}"
                        class="{{ $activePeriod === $key ? 'active' : '' }}"
                    >
                        {{ $label }}
                    </a>
                @endforeach
            </div>

            <div class="finance-user">
                <div class="avatar">
                    {{ strtoupper(substr($user?->name ?? 'A', 0, 1)) }}
                </div>
                <div>
                    <strong>{{ $user?->name ?? 'Administrator' }}</strong>
                    <span>Super Admin</span>
                </div>
            </div>
        </div>

        <div class="finance-period">
            <span>{{ $finance['period']['label'] }}</span>
            <strong>{{ $finance['period']['start'] }} - {{ $finance['period']['end'] }}</strong>
        </div>

        <div class="finance-metric-grid">
            @foreach ($finance['metrics'] as $metric)
                <div class="finance-card">
                    <div class="finance-card-icon" style="background: linear-gradient(135deg, {{ $metric['color'] }}, #f97316);">
                        {{ $metric['icon'] }}
                    </div>

                    <div class="finance-card-body">
                        <div class="finance-card-label">
                            {{ $metric['label'] }}
                            <span>⋮</span>
                        </div>

                        <div class="finance-card-value">
                            {{ $metric['value'] }}
                        </div>

                        <div class="finance-card-caption">
                            @if (! is_null($metric['trend']))
                                <span class="{{ $metric['trend'] >= 0 ? 'up' : 'down' }}">
                                    {{ $metric['trend'] >= 0 ? '↑' : '↓' }} {{ abs($metric['trend']) }}%
                                </span>
                                dari periode sebelumnya
                            @else
                                {{ $metric['caption'] }}
                            @endif
                        </div>
                    </div>
                </div>
            @endforeach
        </div>

        <div class="finance-content-grid">
            <div class="finance-panel">
                <div class="finance-panel-header">
                    <div>
                        <h2>Rincian Biaya Operasional</h2>
                        <p>Biaya yang dihitung pada periode aktif.</p>
                    </div>
                    <a href="{{ url('/admin/operational-costs') }}">Kelola →</a>
                </div>

                <div class="finance-list">
                    @forelse ($finance['costs'] as $cost)
                        <div class="finance-list-row">
                            <div>
                                <strong>{{ $cost['name'] }}</strong>
                                <span>{{ $cost['category'] }} • {{ $cost['date'] }}</span>
                            </div>
                            <b>{{ $this->rupiah($cost['amount']) }}</b>
                        </div>
                    @empty
                        <div class="finance-empty">
                            Belum ada biaya operasional pada periode ini.
                        </div>
                    @endforelse
                </div>
            </div>

            <div class="finance-panel">
                <div class="finance-panel-header">
                    <div>
                        <h2>Margin Produk</h2>
                        <p>Produk dengan kontribusi laba terbesar.</p>
                    </div>
                    <a href="{{ url('/admin/products') }}">Produk →</a>
                </div>

                <div class="finance-list">
                    @forelse ($finance['productMargins'] as $product)
                        <div class="finance-product-row">
                            <div class="product-info">
                                <strong>{{ $product['name'] }}</strong>
                                <span>{{ $product['units'] }} unit • Margin {{ $product['margin'] }}%</span>
                            </div>

                            <div class="product-money">
                                <b>{{ $this->rupiah($product['gross_profit']) }}</b>
                                <span>HPP {{ $this->rupiah($product['total_hpp']) }}</span>
                            </div>
                        </div>
                    @empty
                        <div class="finance-empty">
                            Belum ada data margin produk. Isi HPP produk lalu buat transaksi baru.
                        </div>
                    @endforelse
                </div>
            </div>
        </div>
    </div>

    <style>
        .finance-page {
            width: 100%;
            min-height: 100vh;
            color: #1f2937;
        }

        .finance-header {
            display: grid;
            grid-template-columns: 1fr auto auto;
            gap: 16px;
            align-items: center;
            margin-bottom: 22px;
        }

        .finance-header h1 {
            margin: 0;
            font-size: 34px;
            font-weight: 900;
            color: #111827;
            letter-spacing: -1px;
        }

        .finance-header p {
            margin: 6px 0 0;
            color: rgba(31, 41, 55, .72);
            font-size: 15px;
            font-weight: 600;
        }

        .finance-filter {
            display: flex;
            gap: 8px;
            padding: 8px;
            border-radius: 24px;
            background: rgba(255, 255, 255, .42);
            border: 1px solid rgba(255, 255, 255, .65);
            backdrop-filter: blur(18px);
            box-shadow: 0 18px 50px rgba(15, 23, 42, .08);
        }

        .finance-filter a {
            text-decoration: none;
            padding: 12px 22px;
            border-radius: 18px;
            color: rgba(31, 41, 55, .76);
            font-weight: 800;
            transition: .2s ease;
        }

        .finance-filter a.active {
            background: linear-gradient(135deg, #f59e0b, #f97316);
            color: #fff;
            box-shadow: 0 12px 28px rgba(249, 115, 22, .28);
        }

        .finance-user {
            display: flex;
            align-items: center;
            gap: 14px;
            padding: 10px 18px 10px 10px;
            border-radius: 24px;
            background: rgba(255, 255, 255, .42);
            border: 1px solid rgba(255, 255, 255, .65);
            backdrop-filter: blur(18px);
        }

        .finance-user .avatar {
            width: 54px;
            height: 54px;
            display: grid;
            place-items: center;
            border-radius: 18px;
            background: linear-gradient(135deg, #f97316, #fb923c);
            color: #fff;
            font-weight: 900;
            font-size: 22px;
        }

        .finance-user strong {
            display: block;
            font-size: 15px;
            font-weight: 900;
        }

        .finance-user span {
            display: block;
            margin-top: 2px;
            font-size: 13px;
            font-weight: 700;
            color: rgba(31, 41, 55, .72);
        }

        .finance-period {
            display: inline-flex;
            gap: 10px;
            align-items: center;
            padding: 10px 16px;
            margin-bottom: 18px;
            border-radius: 18px;
            background: rgba(255, 255, 255, .38);
            border: 1px solid rgba(255, 255, 255, .65);
            backdrop-filter: blur(18px);
            color: rgba(31, 41, 55, .75);
            font-size: 14px;
            font-weight: 700;
        }

        .finance-period strong {
            color: #111827;
        }

        .finance-metric-grid {
            display: grid;
            grid-template-columns: repeat(3, minmax(0, 1fr));
            gap: 18px;
            margin-bottom: 22px;
        }

        .finance-card {
            display: flex;
            gap: 16px;
            align-items: flex-start;
            min-height: 128px;
            padding: 24px;
            border-radius: 26px;
            background: rgba(255, 255, 255, .42);
            border: 1px solid rgba(255, 255, 255, .68);
            backdrop-filter: blur(20px);
            box-shadow: 0 20px 60px rgba(15, 23, 42, .08);
        }

        .finance-card-icon {
            width: 58px;
            height: 58px;
            flex: 0 0 58px;
            display: grid;
            place-items: center;
            border-radius: 18px;
            color: #fff;
            font-size: 22px;
            font-weight: 900;
            box-shadow: 0 16px 32px rgba(249, 115, 22, .22);
        }

        .finance-card-body {
            flex: 1;
            min-width: 0;
        }

        .finance-card-label {
            display: flex;
            justify-content: space-between;
            gap: 10px;
            color: rgba(31, 41, 55, .75);
            font-size: 15px;
            font-weight: 900;
        }

        .finance-card-value {
            margin-top: 8px;
            font-size: 27px;
            line-height: 1;
            font-weight: 950;
            color: #111827;
            letter-spacing: -1px;
        }

        .finance-card-caption {
            margin-top: 12px;
            color: rgba(31, 41, 55, .72);
            font-size: 13px;
            font-weight: 800;
        }

        .finance-card-caption .up {
            color: #059669;
            font-weight: 950;
        }

        .finance-card-caption .down {
            color: #dc2626;
            font-weight: 950;
        }

        .finance-content-grid {
            display: grid;
            grid-template-columns: repeat(2, minmax(0, 1fr));
            gap: 18px;
        }

        .finance-panel {
            padding: 22px;
            border-radius: 28px;
            background: rgba(255, 255, 255, .42);
            border: 1px solid rgba(255, 255, 255, .68);
            backdrop-filter: blur(20px);
            box-shadow: 0 20px 60px rgba(15, 23, 42, .08);
        }

        .finance-panel-header {
            display: flex;
            align-items: flex-start;
            justify-content: space-between;
            gap: 14px;
            margin-bottom: 16px;
        }

        .finance-panel-header h2 {
            margin: 0;
            font-size: 18px;
            font-weight: 950;
            color: #111827;
        }

        .finance-panel-header p {
            margin: 4px 0 0;
            color: rgba(31, 41, 55, .66);
            font-size: 13px;
            font-weight: 700;
        }

        .finance-panel-header a {
            text-decoration: none;
            color: #ea580c;
            font-weight: 900;
            white-space: nowrap;
        }

        .finance-list {
            display: flex;
            flex-direction: column;
            gap: 10px;
        }

        .finance-list-row,
        .finance-product-row {
            display: flex;
            justify-content: space-between;
            gap: 14px;
            align-items: center;
            padding: 14px 16px;
            border-radius: 18px;
            background: rgba(255, 255, 255, .52);
            border: 1px solid rgba(255, 255, 255, .58);
        }

        .finance-list-row strong,
        .finance-product-row strong {
            display: block;
            color: #111827;
            font-size: 14px;
            font-weight: 950;
        }

        .finance-list-row span,
        .finance-product-row span {
            display: block;
            margin-top: 3px;
            color: rgba(31, 41, 55, .62);
            font-size: 12px;
            font-weight: 700;
        }

        .finance-list-row b,
        .product-money b {
            color: #111827;
            font-size: 14px;
            font-weight: 950;
            white-space: nowrap;
        }

        .product-money {
            text-align: right;
            white-space: nowrap;
        }

        .finance-empty {
            padding: 32px 18px;
            border-radius: 20px;
            text-align: center;
            color: rgba(31, 41, 55, .68);
            font-weight: 800;
            background: rgba(255, 255, 255, .45);
            border: 1px dashed rgba(31, 41, 55, .16);
        }

        @media (max-width: 1180px) {
            .finance-header {
                grid-template-columns: 1fr;
            }

            .finance-filter {
                width: fit-content;
            }

            .finance-user {
                width: fit-content;
            }

            .finance-metric-grid {
                grid-template-columns: repeat(2, minmax(0, 1fr));
            }

            .finance-content-grid {
                grid-template-columns: 1fr;
            }
        }

        @media (max-width: 720px) {
            .finance-header h1 {
                font-size: 26px;
            }

            .finance-filter {
                flex-wrap: wrap;
            }

            .finance-filter a {
                padding: 10px 14px;
            }

            .finance-metric-grid {
                grid-template-columns: 1fr;
            }
        }
    </style>
</x-filament-panels::page>