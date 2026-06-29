@php
    $period = $period ?? [];
    $filters = $filters ?? [];

    $selectedMonth = (string) ($period['selected_month'] ?? request()->query('month', now()->month));
    $selectedYear = (int) ($period['selected_year'] ?? request()->query('year', now()->year));
    $periodLabel = (string) ($period['label'] ?? now()->translatedFormat('F Y'));
    $selectedStatus = (string) request()->query('status', session('ng_operational_cost_status', 'active'));

    if (! in_array($selectedStatus, ['active', 'inactive', 'all'], true)) {
        $selectedStatus = 'active';
    }

    $statusOptions = [
        'active' => 'Aktif',
        'inactive' => 'Nonaktif',
        'all' => 'Semua',
    ];

    $months = $filters['months'] ?? [
        '1' => 'Januari',
        '2' => 'Februari',
        '3' => 'Maret',
        '4' => 'April',
        '5' => 'Mei',
        '6' => 'Juni',
        '7' => 'Juli',
        '8' => 'Agustus',
        '9' => 'September',
        '10' => 'Oktober',
        '11' => 'November',
        '12' => 'Desember',
    ];

    $years = $filters['years'] ?? range(now()->year - 4, now()->year + 1);
    $baseOperationalUrl = $indexUrl ?? url('/admin/operational-costs');

    $makePeriodUrl = function (string|int $month, string|int $year) use ($baseOperationalUrl, $selectedStatus): string {
        return $baseOperationalUrl . '?' . http_build_query([
            'month' => (string) $month,
            'year' => (string) $year,
            'status' => $selectedStatus,
        ]);
    };

    $makeStatusUrl = function (string $status) use ($baseOperationalUrl, $selectedMonth, $selectedYear): string {
        return $baseOperationalUrl . '?' . http_build_query([
            'month' => (string) $selectedMonth,
            'year' => (string) $selectedYear,
            'status' => $status,
        ]);
    };

    $cards = [
        [
            'label' => 'Biaya Periode Ini',
            'value' => $this->rupiah($summary['monthly_cost'] ?? 0),
            'caption' => 'Data aktif: ' . $periodLabel,
            'icon' => '▣',
            'color' => '#f97316',
        ],
        [
            'label' => 'Total Biaya',
            'value' => number_format((int) ($summary['total_costs'] ?? 0), 0, ',', '.'),
            'caption' => 'Semua data biaya',
            'icon' => '∑',
            'color' => '#3b82f6',
        ],
        [
            'label' => 'Biaya Aktif Periode',
            'value' => number_format((int) ($summary['active_costs'] ?? 0), 0, ',', '.'),
            'caption' => 'Tampil pada bulan aktif',
            'icon' => '✓',
            'color' => '#10b981',
        ],
        [
            'label' => 'Biaya Nonaktif',
            'value' => number_format((int) ($summary['inactive_costs'] ?? 0), 0, ',', '.'),
            'caption' => 'Tidak dihitung',
            'icon' => '!',
            'color' => '#ef4444',
        ],
    ];
@endphp

<x-filament-widgets::widget>
    <div class="ng-operational-page" data-active-month="{{ $selectedMonth }}" data-active-year="{{ $selectedYear }}">
        <section class="ng-op-hero-grid">
            <article class="ng-widget-card ng-op-hero-card">
                <div class="ng-widget-head">
                    <div>
                        <h1>Biaya Operasional</h1>
                        <p>
                            Kelola pengeluaran usaha berdasarkan bulan aktif. Pilih bulan dan tahun untuk melihat biaya yang masuk ke periode tersebut.
                        </p>

                        <small class="ng-op-active-period">
                            Data aktif: {{ $periodLabel }} • {{ $period['start'] ?? '-' }} - {{ $period['end'] ?? '-' }}
                        </small>
                    </div>

                    <div class="ng-op-period-filter" wire:ignore>
                        <span>Filter Data</span>

                        <div class="ng-op-period-selects">
                            <select class="ng-op-select" data-ng-op-month onchange="if (this.value) window.location.href = this.value;">
                                @foreach ($months as $monthKey => $monthLabel)
                                    <option value="{{ $makePeriodUrl($monthKey, $selectedYear) }}"
                                            @selected((string) $selectedMonth === (string) $monthKey)>
                                        {{ $monthLabel }}
                                    </option>
                                @endforeach
                            </select>

                            <select class="ng-op-select ng-op-year-select" data-ng-op-year onchange="if (this.value) window.location.href = this.value;">
                                @foreach ($years as $yearOption)
                                    <option value="{{ $makePeriodUrl($selectedMonth, $yearOption) }}"
                                            @selected((int) $selectedYear === (int) $yearOption)>
                                        {{ $yearOption }}
                                    </option>
                                @endforeach
                            </select>

                            <select class="ng-op-select ng-op-status-select" data-ng-op-status onchange="if (this.value) window.location.href = this.value;">
                                @foreach ($statusOptions as $statusKey => $statusLabel)
                                    <option value="{{ $makeStatusUrl($statusKey) }}"
                                            @selected($selectedStatus === $statusKey)>
                                        {{ $statusLabel }}
                                    </option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                </div>
            </article>

            <article class="ng-widget-card ng-op-highlight-card">
                <div class="ng-highlight-info">
                    <span>Biaya Terbesar {{ $periodLabel }}</span>
                    <strong>{{ $summary['highest_cost_name'] ?? '-' }}</strong>
                    <small>{{ $this->rupiah($summary['highest_cost_amount'] ?? 0) }} dihitung periode ini</small>
                </div>

                <div class="ng-highlight-actions">
                    <a href="{{ $dashboardUrl }}" class="ng-soft-button">
                        Dashboard
                    </a>

                    <a href="{{ $createUrl }}" class="ng-primary-button">
                        + New Biaya
                    </a>
                </div>
            </article>
        </section>

        <section class="ng-kpi-grid ng-operational-kpi-grid">
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

                        <strong>{{ $card['value'] ?? '-' }}</strong>

                        <p class="neutral">
                            {{ $card['caption'] ?? '-' }}
                        </p>
                    </div>
                </article>
            @endforeach
        </section>

    </div>

    <style>
        html,
        body {
            overflow-x: hidden !important;
        }

        body:has(.ng-operational-page) {
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

        body:has(.ng-operational-page) .fi-main,
        body:has(.ng-operational-page) .fi-main-ctn,
        body:has(.ng-operational-page) .fi-page,
        body:has(.ng-operational-page) .fi-page-content {
            width: 100% !important;
            max-width: 100% !important;
            background: transparent !important;
            overflow-x: hidden !important;
        }

        body:has(.ng-operational-page) .fi-page {
            padding: 0 !important;
        }

        body:has(.ng-operational-page) .fi-page-header {
            display: none !important;
        }

        body:has(.ng-operational-page) .fi-main {
            padding: 0 !important;
        }

        body:has(.ng-operational-page) .fi-page-content {
            gap: 0 !important;
            row-gap: 0 !important;
        }

        body:has(.ng-operational-page) .fi-wi,
        body:has(.ng-operational-page) .fi-wi-widget,
        body:has(.ng-operational-page) .fi-wi-widget-content,
        body:has(.ng-operational-page) .fi-wi-widgets,
        body:has(.ng-operational-page) .fi-wi-widgets > * {
            margin: 0 !important;
            padding: 0 !important;
            background: transparent !important;
            border: none !important;
            box-shadow: none !important;
        }

        .ng-operational-page {
            width: 100% !important;
            max-width: 100% !important;
            padding: 24px 24px 10px !important;
            overflow: visible !important;
            font-family: Inter, Poppins, ui-sans-serif, system-ui, -apple-system, BlinkMacSystemFont, "Segoe UI", sans-serif;
            color: #24180f;
        }

        .ng-operational-page * {
            box-sizing: border-box;
        }

        .ng-op-hero-grid {
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

        .ng-op-hero-card,
        .ng-op-highlight-card {
            min-height: 118px;
        }

        .ng-op-hero-card {
            display: flex;
            align-items: center;
        }

        .ng-widget-head {
            position: relative;
            z-index: 2;
            display: flex;
            align-items: center;
            justify-content: space-between;
            gap: 16px;
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

        .ng-widget-head p {
            max-width: 760px;
            margin: 8px 0 0;
            color: #765d45;
            font-size: 13px;
            line-height: 1.55;
            font-weight: 700;
        }

        .ng-op-active-period {
            display: inline-flex;
            margin-top: 10px;
            color: #d95d00;
            font-size: 12px;
            line-height: 1.3;
            font-weight: 950;
        }

        .ng-op-period-filter {
            position: relative;
            z-index: 3;
            min-width: 430px;
            display: grid;
            gap: 8px;
            justify-items: end;
        }

        .ng-op-period-filter span {
            color: #d95d00;
            font-size: 12px;
            line-height: 1;
            font-weight: 950;
            letter-spacing: .04em;
            text-transform: uppercase;
        }

        .ng-op-period-selects {
            min-height: 52px;
            display: flex;
            align-items: center;
            gap: 9px;
            padding: 6px;
            border-radius: 18px;
            border: 1px solid rgba(255, 255, 255, .62);
            background: rgba(255, 255, 255, .38);
            box-shadow:
                0 18px 35px rgba(95, 55, 18, .10),
                inset 0 1px 0 rgba(255, 255, 255, .62);
            backdrop-filter: blur(14px);
            -webkit-backdrop-filter: blur(14px);
        }

        .ng-op-select {
            min-height: 40px;
            min-width: 148px;
            border: 0;
            outline: none;
            border-radius: 14px;
            padding: 0 14px;
            color: #4a321f;
            background: rgba(255, 255, 255, .78);
            font-size: 13px;
            font-weight: 900;
            cursor: pointer;
        }

        .ng-op-year-select {
            min-width: 94px;
        }

        .ng-op-status-select {
            min-width: 118px;
        }


        .ng-op-highlight-card {
            display: flex;
            align-items: center;
            justify-content: space-between;
            gap: 16px;
        }

        .ng-highlight-info {
            position: relative;
            z-index: 2;
            min-width: 0;
        }

        .ng-highlight-info span {
            display: block;
            color: #765d45;
            font-size: 11px;
            font-weight: 900;
        }

        .ng-highlight-info strong {
            display: block;
            max-width: 280px;
            margin: 8px 0;
            overflow: hidden;
            color: #21160d;
            font-size: 22px;
            line-height: 1.1;
            font-weight: 950;
            white-space: nowrap;
            text-overflow: ellipsis;
            letter-spacing: -.03em;
        }

        .ng-highlight-info small {
            display: block;
            color: #765d45;
            font-size: 11px;
            font-weight: 850;
        }

        .ng-highlight-actions {
            position: relative;
            z-index: 2;
            display: flex;
            align-items: center;
            justify-content: flex-end;
            gap: 9px;
            flex-wrap: wrap;
        }

        .ng-soft-button,
        .ng-primary-button {
            display: inline-flex;
            align-items: center;
            justify-content: center;
            min-height: 42px;
            padding: 0 16px;
            border-radius: 15px;
            font-size: 12px;
            font-weight: 950;
            text-decoration: none;
            white-space: nowrap;
            transition: .2s ease;
        }

        .ng-soft-button {
            color: #d95d00;
            background: rgba(255, 255, 255, .36);
            border: 1px solid rgba(255, 255, 255, .50);
            box-shadow: inset 0 1px 0 rgba(255, 255, 255, .44);
        }

        .ng-soft-button:hover {
            color: #fff;
            background: linear-gradient(135deg, #ff9d18, #ee6500);
            box-shadow: 0 12px 22px rgba(238, 101, 0, .22);
        }

        .ng-primary-button {
            color: #fff;
            background: linear-gradient(135deg, #ff9d18, #ee6500);
            box-shadow: 0 14px 26px rgba(238, 101, 0, .26);
        }

        .ng-primary-button:hover {
            transform: translateY(-1px);
            box-shadow: 0 18px 32px rgba(238, 101, 0, .30);
        }

        .ng-operational-kpi-grid {
            display: grid;
            grid-template-columns: repeat(4, minmax(0, 1fr));
            gap: 14px;
            margin-bottom: 14px;
        }

        .ng-kpi-card {
            min-height: 112px;
            border-radius: 22px;
            padding: 16px;
            display: flex;
            align-items: center;
            gap: 14px;
            min-width: 0;
        }

        .ng-kpi-icon {
            position: relative;
            z-index: 2;
            flex: 0 0 48px;
            width: 48px;
            height: 48px;
            display: grid;
            place-items: center;
            border-radius: 15px;
            color: #fff;
            font-size: 22px;
            font-weight: 950;
            background:
                radial-gradient(circle at 35% 25%, rgba(255, 255, 255, .28), transparent 32%),
                linear-gradient(135deg, var(--accent), #e45700);
            box-shadow: 0 12px 24px rgba(238, 101, 0, .20);
        }

        .ng-kpi-content {
            position: relative;
            z-index: 2;
            min-width: 0;
            flex: 1;
        }

        .ng-kpi-label {
            display: flex;
            justify-content: space-between;
            gap: 8px;
            color: #765d45;
            font-size: 12px;
            line-height: 1.2;
            font-weight: 950;
            letter-spacing: .05em;
            text-transform: uppercase;
        }

        .ng-kpi-label span {
            color: #8a7259;
        }

        .ng-kpi-content strong {
            display: block;
            margin-top: 7px;
            color: #21160d;
            font-size: 24px;
            line-height: 1.05;
            font-weight: 950;
            letter-spacing: -.04em;
            white-space: nowrap;
        }

        .ng-kpi-content p {
            margin: 8px 0 0;
            color: #3d556f;
            font-size: 12px;
            line-height: 1.35;
            font-weight: 850;
            white-space: nowrap;
            overflow: hidden;
            text-overflow: ellipsis;
        }



        /* No horizontal scroll table: content fixed inside widget width */
        body:has(.ng-operational-page) {
            overflow-x: hidden !important;
        }

        body:has(.ng-operational-page) .fi-ta-ctn {
            width: calc(100% - 48px) !important;
            max-width: calc(100% - 48px) !important;
            margin: 10px 24px 24px !important;
            border-radius: 24px !important;
            overflow: hidden !important;
            border: 1px solid rgba(255, 255, 255, .58) !important;
            background:
                linear-gradient(145deg, rgba(255, 255, 255, .46), rgba(255, 246, 231, .22)),
                radial-gradient(circle at 100% 0%, rgba(255, 153, 30, .16), transparent 38%) !important;
            box-shadow:
                0 22px 54px rgba(101, 58, 21, .12),
                0 0 0 1px rgba(255, 255, 255, .12) inset,
                inset 0 1px 0 rgba(255, 255, 255, .62) !important;
            backdrop-filter: blur(14px) !important;
            -webkit-backdrop-filter: blur(14px) !important;
        }

        body:has(.ng-operational-page) .fi-ta,
        body:has(.ng-operational-page) .fi-ta-content,
        body:has(.ng-operational-page) .fi-ta-table,
        body:has(.ng-operational-page) .fi-ta-header,
        body:has(.ng-operational-page) .fi-ta-toolbar {
            background: transparent !important;
            border-color: rgba(255, 255, 255, .20) !important;
        }

        body:has(.ng-operational-page) .fi-ta-header {
            min-height: 62px !important;
            padding: 12px 18px !important;
        }

        body:has(.ng-operational-page) .fi-ta-header-heading {
            display: none !important;
        }

        body:has(.ng-operational-page) .fi-ta-content,
        body:has(.ng-operational-page) .fi-ta-table-wrap {
            width: 100% !important;
            max-width: 100% !important;
            overflow-x: hidden !important;
        }

        body:has(.ng-operational-page) .fi-ta-table {
            width: 100% !important;
            max-width: 100% !important;
            min-width: 0 !important;
            table-layout: fixed !important;
        }

        body:has(.ng-operational-page) .fi-ta-table thead th {
            background: rgba(255, 255, 255, .22) !important;
            border-color: rgba(255, 255, 255, .18) !important;
            padding-top: 12px !important;
            padding-bottom: 12px !important;
        }

        body:has(.ng-operational-page) .fi-ta-table tbody tr {
            background: rgba(255, 255, 255, .08) !important;
            border-color: rgba(255, 255, 255, .16) !important;
        }

        body:has(.ng-operational-page) .fi-ta-table tbody tr:hover {
            background: rgba(255, 255, 255, .20) !important;
        }

        body:has(.ng-operational-page) .fi-ta-table th,
        body:has(.ng-operational-page) .fi-ta-table td {
            min-width: 0 !important;
            max-width: none !important;
            overflow: hidden !important;
            padding-left: 12px !important;
            padding-right: 12px !important;
            vertical-align: middle !important;
        }

        body:has(.ng-operational-page) .fi-ta-table th:first-child,
        body:has(.ng-operational-page) .fi-ta-table td:first-child {
            width: 42px !important;
            max-width: 42px !important;
            padding-left: 16px !important;
            padding-right: 8px !important;
        }

        body:has(.ng-operational-page) .fi-ta-actions,
        body:has(.ng-operational-page) .fi-ta-actions-cell,
        body:has(.ng-operational-page) td:has(.fi-ta-actions) {
            width: 58px !important;
            max-width: 58px !important;
            min-width: 58px !important;
            padding-left: 4px !important;
            padding-right: 14px !important;
            overflow: visible !important;
        }

        body:has(.ng-operational-page) .fi-ta-actions {
            display: flex !important;
            justify-content: flex-end !important;
        }

        body:has(.ng-operational-page) .fi-ta-actions .fi-btn {
            min-width: 36px !important;
            width: 36px !important;
            padding-left: 0 !important;
            padding-right: 0 !important;
            border-radius: 999px !important;
        }

        body:has(.ng-operational-page) .fi-ta-text,
        body:has(.ng-operational-page) .fi-ta-text-item,
        body:has(.ng-operational-page) .fi-ta-text-item-label {
            max-width: 100% !important;
            white-space: normal !important;
            word-break: break-word !important;
            overflow-wrap: anywhere !important;
        }

        body:has(.ng-operational-page) .fi-ta-cell .fi-badge {
            max-width: 100% !important;
            white-space: nowrap !important;
        }

        @media (max-width: 1100px) {
            body:has(.ng-operational-page) .fi-ta-ctn {
                width: calc(100% - 28px) !important;
                max-width: calc(100% - 28px) !important;
                margin-left: 14px !important;
                margin-right: 14px !important;
            }

            body:has(.ng-operational-page) .fi-ta-content,
            body:has(.ng-operational-page) .fi-ta-table-wrap {
                overflow-x: hidden !important;
            }
        }


        /* Final cleanup: 4 KPI, no double scroll, softer flat glass */
        body:has(.ng-operational-page),
        body:has(.ng-operational-page) .fi-main,
        body:has(.ng-operational-page) .fi-main-ctn,
        body:has(.ng-operational-page) .fi-page,
        body:has(.ng-operational-page) .fi-page-content {
            overflow-x: hidden !important;
        }

        body:has(.ng-operational-page) .fi-ta-content,
        body:has(.ng-operational-page) .fi-ta-table-wrap,
        body:has(.ng-operational-page) .fi-ta-ctn {
            overflow-x: hidden !important;
            overflow-y: visible !important;
        }

        body:has(.ng-operational-page) .fi-ta-ctn::-webkit-scrollbar,
        body:has(.ng-operational-page) .fi-ta-content::-webkit-scrollbar,
        body:has(.ng-operational-page) .fi-ta-table-wrap::-webkit-scrollbar {
            display: none !important;
            width: 0 !important;
            height: 0 !important;
        }

        .ng-widget-card,
        .ng-kpi-card,
        body:has(.ng-operational-page) .fi-ta-ctn {
            box-shadow:
                0 0 0 1px rgba(255, 255, 255, .14) inset,
                inset 0 1px 0 rgba(255, 255, 255, .42) !important;
        }

        .ng-widget-card::before,
        .ng-kpi-card::before {
            opacity: .20 !important;
        }

        body:has(.ng-operational-page) .fi-ta-row,
        body:has(.ng-operational-page) .fi-ta-table tbody tr {
            box-shadow: none !important;
        }

        @media (max-width: 1500px) {
            .ng-operational-kpi-grid {
                grid-template-columns: repeat(3, minmax(0, 1fr));
            }
        }

        @media (max-width: 1100px) {
            .ng-op-hero-grid {
                grid-template-columns: 1fr;
            }

            .ng-widget-head {
                align-items: flex-start;
                flex-direction: column;
            }

            .ng-op-period-filter {
                width: 100%;
                min-width: 0;
                justify-items: start;
            }

            .ng-op-period-selects {
                width: 100%;
                flex-wrap: wrap;
            }

            .ng-op-select {
                flex: 1;
                min-width: 140px;
            }

            .ng-operational-kpi-grid {
                grid-template-columns: repeat(2, minmax(0, 1fr));
            }
        }

        @media (max-width: 700px) {
            .ng-operational-page {
                padding: 16px 14px 8px !important;
            }

            .ng-operational-kpi-grid {
                grid-template-columns: 1fr;
            }

            .ng-op-highlight-card {
                align-items: flex-start;
                flex-direction: column;
            }

            .ng-highlight-actions {
                width: 100%;
            }

            .ng-soft-button,
            .ng-primary-button {
                flex: 1;
            }

            .ng-widget-head h1 {
                font-size: 25px;
            }
        }

        /* Hard fix: remove internal / double scrollbars, keep page using main browser scroll */
        html:has(.ng-operational-page),
        body:has(.ng-operational-page) {
            overflow-x: hidden !important;
            overflow-y: auto !important;
            height: auto !important;
            max-height: none !important;
        }

        body:has(.ng-operational-page) .fi-layout,
        body:has(.ng-operational-page) .fi-main,
        body:has(.ng-operational-page) .fi-main-ctn,
        body:has(.ng-operational-page) .fi-page,
        body:has(.ng-operational-page) .fi-page-content,
        body:has(.ng-operational-page) main {
            overflow-x: hidden !important;
            overflow-y: visible !important;
            height: auto !important;
            max-height: none !important;
            min-height: 0 !important;
        }

        body:has(.ng-operational-page) .fi-ta-ctn,
        body:has(.ng-operational-page) .fi-ta,
        body:has(.ng-operational-page) .fi-ta-content,
        body:has(.ng-operational-page) .fi-ta-table-wrap,
        body:has(.ng-operational-page) .fi-ta-table {
            overflow-x: hidden !important;
            overflow-y: visible !important;
            height: auto !important;
            max-height: none !important;
            min-height: 0 !important;
            scrollbar-width: none !important;
            -ms-overflow-style: none !important;
        }

        body:has(.ng-operational-page) .fi-main::-webkit-scrollbar,
        body:has(.ng-operational-page) .fi-main-ctn::-webkit-scrollbar,
        body:has(.ng-operational-page) .fi-page::-webkit-scrollbar,
        body:has(.ng-operational-page) .fi-page-content::-webkit-scrollbar,
        body:has(.ng-operational-page) .fi-ta-ctn::-webkit-scrollbar,
        body:has(.ng-operational-page) .fi-ta-content::-webkit-scrollbar,
        body:has(.ng-operational-page) .fi-ta-table-wrap::-webkit-scrollbar {
            display: none !important;
            width: 0 !important;
            height: 0 !important;
        }

        body:has(.ng-operational-page) [class*="overflow-auto"],
        body:has(.ng-operational-page) [class*="overflow-y-auto"],
        body:has(.ng-operational-page) [class*="overflow-scroll"],
        body:has(.ng-operational-page) [class*="overflow-y-scroll"] {
            overflow-y: visible !important;
            overflow-x: hidden !important;
            max-height: none !important;
            scrollbar-width: none !important;
            -ms-overflow-style: none !important;
        }

        body:has(.ng-operational-page) [class*="overflow-auto"]::-webkit-scrollbar,
        body:has(.ng-operational-page) [class*="overflow-y-auto"]::-webkit-scrollbar,
        body:has(.ng-operational-page) [class*="overflow-scroll"]::-webkit-scrollbar,
        body:has(.ng-operational-page) [class*="overflow-y-scroll"]::-webkit-scrollbar {
            display: none !important;
            width: 0 !important;
            height: 0 !important;
        }


        /*
        |--------------------------------------------------------------------------
        | SIDEBAR EFFECT SYNC - BIAYA OPERASIONAL
        |--------------------------------------------------------------------------
        */

        body:has(.ng-operational-page) .fi-sidebar,
        body.ng-operational-sidebar-sync .fi-sidebar {
            background: rgba(255, 250, 242, .50) !important;
            border-right: 1px solid rgba(255, 255, 255, .48) !important;
            box-shadow: 18px 0 55px rgba(137, 78, 26, .10) !important;
            backdrop-filter: blur(16px) !important;
            -webkit-backdrop-filter: blur(16px) !important;
        }

        body:has(.ng-operational-page) .fi-sidebar-nav,
        body.ng-operational-sidebar-sync .fi-sidebar-nav {
            padding: 18px 14px !important;
        }

        body:has(.ng-operational-page) .fi-sidebar-item a,
        body:has(.ng-operational-page) .fi-sidebar-item-button,
        body.ng-operational-sidebar-sync .fi-sidebar-item a,
        body.ng-operational-sidebar-sync .fi-sidebar-item-button {
            border-radius: 14px !important;
            color: #6f5844 !important;
            transition: .2s ease !important;
        }

        body:has(.ng-operational-page) .fi-sidebar-item-active a,
        body:has(.ng-operational-page) .fi-sidebar-item a:hover,
        body:has(.ng-operational-page) .fi-sidebar-item-active .fi-sidebar-item-button,
        body:has(.ng-operational-page) .fi-sidebar-item .fi-sidebar-item-button:hover,
        body:has(.ng-operational-page) .fi-sidebar-item.fi-active a,
        body:has(.ng-operational-page) .fi-sidebar-item.fi-active .fi-sidebar-item-button,
        body.ng-operational-sidebar-sync .fi-sidebar-item-active a,
        body.ng-operational-sidebar-sync .fi-sidebar-item a:hover,
        body.ng-operational-sidebar-sync .fi-sidebar-item-active .fi-sidebar-item-button,
        body.ng-operational-sidebar-sync .fi-sidebar-item .fi-sidebar-item-button:hover,
        body.ng-operational-sidebar-sync .fi-sidebar-item.fi-active a,
        body.ng-operational-sidebar-sync .fi-sidebar-item.fi-active .fi-sidebar-item-button {
            background: linear-gradient(135deg, #ff9500, #f26a00) !important;
            color: #fff !important;
            box-shadow: 0 14px 24px rgba(242, 106, 0, .24) !important;
        }

        body:has(.ng-operational-page) .fi-sidebar-item-active svg,
        body:has(.ng-operational-page) .fi-sidebar-item a:hover svg,
        body:has(.ng-operational-page) .fi-sidebar-item-active span,
        body:has(.ng-operational-page) .fi-sidebar-item a:hover span,
        body:has(.ng-operational-page) .fi-sidebar-item-active .fi-sidebar-item-icon,
        body:has(.ng-operational-page) .fi-sidebar-item-active .fi-sidebar-item-label,
        body:has(.ng-operational-page) .fi-sidebar-item .fi-sidebar-item-button:hover .fi-sidebar-item-icon,
        body:has(.ng-operational-page) .fi-sidebar-item .fi-sidebar-item-button:hover .fi-sidebar-item-label,
        body:has(.ng-operational-page) .fi-sidebar-item.fi-active svg,
        body:has(.ng-operational-page) .fi-sidebar-item.fi-active span,
        body:has(.ng-operational-page) .fi-sidebar-item.fi-active .fi-sidebar-item-icon,
        body:has(.ng-operational-page) .fi-sidebar-item.fi-active .fi-sidebar-item-label,
        body.ng-operational-sidebar-sync .fi-sidebar-item-active svg,
        body.ng-operational-sidebar-sync .fi-sidebar-item a:hover svg,
        body.ng-operational-sidebar-sync .fi-sidebar-item-active span,
        body.ng-operational-sidebar-sync .fi-sidebar-item a:hover span,
        body.ng-operational-sidebar-sync .fi-sidebar-item-active .fi-sidebar-item-icon,
        body.ng-operational-sidebar-sync .fi-sidebar-item-active .fi-sidebar-item-label,
        body.ng-operational-sidebar-sync .fi-sidebar-item .fi-sidebar-item-button:hover .fi-sidebar-item-icon,
        body.ng-operational-sidebar-sync .fi-sidebar-item .fi-sidebar-item-button:hover .fi-sidebar-item-label,
        body.ng-operational-sidebar-sync .fi-sidebar-item.fi-active svg,
        body.ng-operational-sidebar-sync .fi-sidebar-item.fi-active span,
        body.ng-operational-sidebar-sync .fi-sidebar-item.fi-active .fi-sidebar-item-icon,
        body.ng-operational-sidebar-sync .fi-sidebar-item.fi-active .fi-sidebar-item-label {
            color: #fff !important;
        }

    </style>

    <script>
        (function () {
            function bindOperationalPeriodFilter() {
                document.querySelectorAll('[data-ng-op-month], [data-ng-op-year]').forEach(function (select) {
                    if (select.dataset.ngBound === '1') {
                        return;
                    }

                    select.dataset.ngBound = '1';

                    select.addEventListener('change', function () {
                        if (! select.value) {
                            return;
                        }

                        window.location.href = select.value;
                    });
                });
            }

            document.addEventListener('DOMContentLoaded', bindOperationalPeriodFilter);
            document.addEventListener('livewire:navigated', bindOperationalPeriodFilter);
            document.addEventListener('livewire:update', bindOperationalPeriodFilter);
            bindOperationalPeriodFilter();
        })();
    </script>

    <script>
        (function () {
            function syncOperationalSidebarClass() {
                document.body.classList.add('ng-operational-sidebar-sync');
            }

            document.addEventListener('DOMContentLoaded', syncOperationalSidebarClass);
            document.addEventListener('livewire:navigated', syncOperationalSidebarClass);
            document.addEventListener('livewire:update', syncOperationalSidebarClass);
            syncOperationalSidebarClass();
        })();
    </script>

</x-filament-widgets::widget>
