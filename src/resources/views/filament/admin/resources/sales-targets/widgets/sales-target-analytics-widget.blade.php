@php
    $filters = $filters ?? [];
    $years = $filters['years'] ?? [now()->year];
    $statuses = $filters['statuses'] ?? [
        'all' => 'Semua Status',
        'achieved' => 'Tercapai',
        'not_achieved' => 'Belum Tercapai',
    ];

    $selectedYear = (int) ($filters['selected_year'] ?? request()->query('year', now()->year));
    $selectedStatus = (string) ($filters['selected_status'] ?? request()->query('status', 'all'));
    $baseTargetUrl = $indexUrl ?? url('/admin/sales-targets');

    if (! array_key_exists($selectedStatus, $statuses)) {
        $selectedStatus = 'all';
    }

    $makeFilterUrl = function (string|int $year, string $status) use ($baseTargetUrl): string {
        return $baseTargetUrl . '?' . http_build_query([
            'year' => (string) $year,
            'status' => $status,
        ]);
    };

    $currentTargetRevenue = (int) (
        $summary['target_revenue']
        ?? $summary['current_target_revenue']
        ?? $summary['current_target']
        ?? 0
    );

    $currentRevenue = (int) (
        $summary['monthly_revenue']
        ?? $summary['current_revenue']
        ?? $summary['actual_revenue']
        ?? $summary['revenue_actual']
        ?? 0
    );

    $revenueProgress = (float) (
        $summary['revenue_progress']
        ?? 0
    );

    $achievementStatus = (string) (
        $summary['achievement_status']
        ?? 'Belum Ada Target'
    );

    $statusLabels = [
        'achieved' => 'Tercapai',
        'near' => 'Hampir Tercapai',
        'not_achieved' => 'Belum Tercapai',
        'no_transaction' => 'Belum Ada Transaksi',
        'no_target' => 'Belum Ada Target',
    ];

    $achievementStatusLabel = $statusLabels[$achievementStatus] ?? $achievementStatus;

    $cards = [
        [
            'label' => 'Target Revenue Bulan Ini',
            'value' => $this->rupiah($currentTargetRevenue),
            'caption' => 'Target aktif bulan ini',
            'icon' => '⚑',
            'color' => '#f97316',
        ],
        [
            'label' => 'Revenue Aktual',
            'value' => $this->rupiah($currentRevenue),
            'caption' => 'Dari transaksi bulan ini',
            'icon' => '▣',
            'color' => '#10b981',
        ],
        [
            'label' => 'Progress Revenue',
            'value' => number_format($revenueProgress, 1, ',', '.') . '%',
            'caption' => $achievementStatusLabel,
            'icon' => '◉',
            'color' => '#3b82f6',
        ],
    ];
@endphp

<x-filament-widgets::widget>
    <div class="ng-sales-target-page" data-active-year="{{ $selectedYear }}" data-active-status="{{ $selectedStatus }}">
        <section class="ng-op-hero-grid">
            <article class="ng-widget-card ng-op-hero-card">
                <div class="ng-widget-head">
                    <div>
                        <h1>Target Penjualan</h1>

                        <small class="ng-target-active-period">
                            Data tabel: {{ $selectedYear }} • {{ $statuses[$selectedStatus] ?? 'Semua Status' }}
                        </small>
                    </div>

                    <div class="ng-target-hero-right">
                        <div class="ng-target-filter" wire:ignore>
                            <div class="ng-target-filter-selects">
                                <select class="ng-target-select ng-target-year-select" onchange="if (this.value) window.location.href = this.value;">
                                    @foreach ($years as $yearOption)
                                        <option value="{{ $makeFilterUrl($yearOption, $selectedStatus) }}"
                                                @selected((int) $selectedYear === (int) $yearOption)>
                                            {{ $yearOption }}
                                        </option>
                                    @endforeach
                                </select>

                                <select class="ng-target-select ng-target-status-select" onchange="if (this.value) window.location.href = this.value;">
                                    @foreach ($statuses as $statusKey => $statusLabel)
                                        <option value="{{ $makeFilterUrl($selectedYear, $statusKey) }}"
                                                @selected($selectedStatus === $statusKey)>
                                            {{ $statusLabel }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>
                        </div>

                        <a href="{{ $createUrl }}" class="ng-primary-button">
                            + New Target
                        </a>
                    </div>
                </div>
            </article>
        </section>

        <section class="ng-kpi-grid ng-sales-target-kpi-grid">
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
<script>
        (function () {
            function syncTargetSidebarClass() {
                document.body.classList.add('ng-sales-target-sidebar-sync');
            }

            document.addEventListener('DOMContentLoaded', syncTargetSidebarClass);
            document.addEventListener('livewire:navigated', syncTargetSidebarClass);
            document.addEventListener('livewire:update', syncTargetSidebarClass);
            syncTargetSidebarClass();
        })();
    </script>

    <style>
        html,
        body {
            overflow-x: hidden !important;
        }

        body:has(.ng-sales-target-page) {
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
            overflow-x: hidden !important;
        }

        body:has(.ng-sales-target-page) .fi-layout,
        body:has(.ng-sales-target-page) .fi-main,
        body:has(.ng-sales-target-page) .fi-main-ctn,
        body:has(.ng-sales-target-page) .fi-page,
        body:has(.ng-sales-target-page) .fi-page-content,
        body:has(.ng-sales-target-page) main {
            width: 100% !important;
            max-width: 100% !important;
            background: transparent !important;
            overflow-x: hidden !important;
        }

        body:has(.ng-sales-target-page) .fi-page,
        body:has(.ng-sales-target-page) .fi-main {
            padding: 0 !important;
        }

        body:has(.ng-sales-target-page) .fi-page-header {
            display: none !important;
        }

        body:has(.ng-sales-target-page) .fi-page-content {
            gap: 0 !important;
            row-gap: 0 !important;
        }

        body:has(.ng-sales-target-page) .fi-wi,
        body:has(.ng-sales-target-page) .fi-wi-widget,
        body:has(.ng-sales-target-page) .fi-wi-widget-content,
        body:has(.ng-sales-target-page) .fi-wi-widgets,
        body:has(.ng-sales-target-page) .fi-wi-widgets > * {
            margin: 0 !important;
            padding: 0 !important;
            background: transparent !important;
            border: none !important;
            box-shadow: none !important;
        }

        .ng-sales-target-page {
            width: 100% !important;
            max-width: 100% !important;
            padding: 24px 24px 10px !important;
            overflow: hidden !important;
            font-family: Inter, Poppins, ui-sans-serif, system-ui, -apple-system, BlinkMacSystemFont, "Segoe UI", sans-serif;
            color: #24180f;
        }

        .ng-sales-target-page * {
            box-sizing: border-box;
        }

        /*
        |--------------------------------------------------------------------------
        | HERO + FILTER - IKUT PATOKAN CATEGORY
        |--------------------------------------------------------------------------
        */

        .ng-op-hero-grid {
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
            min-width: 0;
            padding: 18px;
            border-radius: 24px;
        }

        .ng-op-hero-card {
            min-height: 126px;
            display: flex;
            align-items: center;
        }

        .ng-widget-head {
            position: relative;
            z-index: 2;
            display: flex;
            align-items: center;
            justify-content: space-between;
            gap: 18px;
            width: 100%;
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

        .ng-target-active-period {
            display: inline-flex;
            margin-top: 10px;
            color: #d95d00;
            font-size: 12px;
            line-height: 1.3;
            font-weight: 950;
        }

        .ng-target-hero-right {
            position: relative;
            z-index: 3;
            flex: 0 0 auto;
            display: flex;
            align-items: center;
            justify-content: flex-end;
            gap: 10px;
        }

        .ng-target-filter {
            position: relative;
            z-index: 3;
            min-width: 0;
            display: grid;
            gap: 8px;
            justify-items: end;
        }

        .ng-target-filter-selects {
            min-height: 52px;
            display: flex;
            align-items: center;
            gap: 9px;
            padding: 6px;
            border-radius: 18px;
            border: 1px solid rgba(255, 255, 255, .58);
            background:
                linear-gradient(145deg, rgba(255, 255, 255, .34), rgba(255, 246, 231, .18)),
                radial-gradient(circle at 100% 0%, rgba(255, 153, 30, .12), transparent 38%) !important;
            box-shadow:
                0 14px 28px rgba(101, 58, 21, .10),
                inset 0 1px 0 rgba(255, 255, 255, .54);
            backdrop-filter: blur(14px);
            -webkit-backdrop-filter: blur(14px);
        }

        .ng-target-select {
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

        .ng-target-year-select {
            min-width: 94px;
        }

        .ng-target-status-select {
            min-width: 166px;
        }

        .ng-primary-button {
            position: relative;
            z-index: 3;
            display: inline-flex;
            align-items: center;
            justify-content: center;
            min-height: 42px;
            padding: 0 16px;
            border-radius: 15px;
            color: #fff;
            background: linear-gradient(135deg, #ff9d18, #ee6500);
            box-shadow: 0 14px 26px rgba(238, 101, 0, .26);
            font-size: 12px;
            font-weight: 950;
            text-decoration: none;
            white-space: nowrap;
            transition: .2s ease;
        }

        .ng-primary-button:hover {
            color: #fff;
            transform: translateY(-1px);
            box-shadow: 0 18px 32px rgba(238, 101, 0, .30);
        }

        /*
        |--------------------------------------------------------------------------
        | KPI - IKUT CATEGORY
        |--------------------------------------------------------------------------
        */

        .ng-sales-target-kpi-grid {
            display: grid;
            grid-template-columns: repeat(3, minmax(0, 1fr));
            gap: 14px;
            margin-bottom: 14px;
        }

        .ng-kpi-card {
            min-height: 108px;
            display: flex;
            gap: 12px;
            padding: 16px 15px;
            border-radius: 22px;
            min-width: 0;
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
        | TABLE FILAMENT - WARNA IKUT CATEGORY
        |--------------------------------------------------------------------------
        */

        body:has(.ng-sales-target-page) .fi-ta-ctn {
            margin: 0 24px 24px !important;
            width: calc(100% - 48px) !important;
            max-width: calc(100% - 48px) !important;
            border-radius: 24px !important;
            border: 1px solid rgba(255, 255, 255, .58) !important;
            background:
                linear-gradient(145deg, rgba(255, 255, 255, .34), rgba(255, 246, 231, .18)),
                radial-gradient(circle at 100% 0%, rgba(255, 153, 30, .12), transparent 38%) !important;
            box-shadow:
                0 22px 54px rgba(101, 58, 21, .12),
                0 0 0 1px rgba(255, 255, 255, .12) inset,
                inset 0 1px 0 rgba(255, 255, 255, .54) !important;
            backdrop-filter: blur(14px) !important;
            -webkit-backdrop-filter: blur(14px) !important;
            overflow: hidden !important;
            transform: none !important;
        }

        body:has(.ng-sales-target-page) .fi-section,
        body:has(.ng-sales-target-page) .fi-ta,
        body:has(.ng-sales-target-page) .fi-ta-content,
        body:has(.ng-sales-target-page) .fi-ta-table,
        body:has(.ng-sales-target-page) .fi-ta-ctn > div,
        body:has(.ng-sales-target-page) .fi-ta-ctn > div > div,
        body:has(.ng-sales-target-page) .fi-ta-ctn > div > div > div,
        body:has(.ng-sales-target-page) table,
        body:has(.ng-sales-target-page) thead,
        body:has(.ng-sales-target-page) tbody,
        body:has(.ng-sales-target-page) tr,
        body:has(.ng-sales-target-page) th,
        body:has(.ng-sales-target-page) td {
            background: transparent !important;
            box-shadow: none !important;
        }

        body:has(.ng-sales-target-page) .fi-ta-header,
        body:has(.ng-sales-target-page) .fi-ta-toolbar {
            min-height: 46px !important;
            padding: 8px 16px !important;
            background: rgba(255, 247, 235, .10) !important;
            border-bottom: 1px solid rgba(114, 74, 41, .08) !important;
        }

        body:has(.ng-sales-target-page) .fi-ta-header-cell,
        body:has(.ng-sales-target-page) .fi-ta-table thead th {
            padding-top: 9px !important;
            padding-bottom: 9px !important;
            background: rgba(255, 255, 255, .10) !important;
            border-color: rgba(114, 74, 41, .08) !important;
            box-shadow: none !important;
        }

        body:has(.ng-sales-target-page) .fi-ta-header-cell-label {
            color: #4b3525 !important;
            font-size: 12px !important;
            font-weight: 950 !important;
        }

        body:has(.ng-sales-target-page) .fi-ta-row,
        body:has(.ng-sales-target-page) .fi-ta-table tbody tr,
        body:has(.ng-sales-target-page) .fi-ta-table tbody tr:nth-child(odd),
        body:has(.ng-sales-target-page) .fi-ta-table tbody tr:nth-child(even) {
            min-height: 52px !important;
            border-bottom: 1px solid rgba(114, 74, 41, .08) !important;
            background: rgba(255, 247, 235, .04) !important;
            transition: .18s ease !important;
        }

        body:has(.ng-sales-target-page) .fi-ta-row:hover,
        body:has(.ng-sales-target-page) .fi-ta-table tbody tr:hover {
            background: rgba(255, 255, 255, .14) !important;
        }

        body:has(.ng-sales-target-page) .fi-ta-cell,
        body:has(.ng-sales-target-page) .fi-ta-table tbody td {
            padding-top: 8px !important;
            padding-bottom: 8px !important;
            border-color: rgba(114, 74, 41, .08) !important;
            background: transparent !important;
        }

        body:has(.ng-sales-target-page) .fi-ta-table {
            width: 100% !important;
            max-width: 100% !important;
            min-width: 0 !important;
            table-layout: fixed !important;
        }

        body:has(.ng-sales-target-page) .fi-ta-content,
        body:has(.ng-sales-target-page) .fi-ta-table-wrap {
            width: 100% !important;
            max-width: 100% !important;
            overflow-x: hidden !important;
            overflow-y: visible !important;
        }

        body:has(.ng-sales-target-page) .fi-ta-selection-cell,
        body:has(.ng-sales-target-page) .fi-ta-checkbox-cell,
        body:has(.ng-sales-target-page) th:has(.fi-checkbox-input),
        body:has(.ng-sales-target-page) td:has(.fi-checkbox-input),
        body:has(.ng-sales-target-page) .fi-checkbox-input,
        body:has(.ng-sales-target-page) .fi-ta-column-manager-trigger,
        body:has(.ng-sales-target-page) button[aria-label*="column" i],
        body:has(.ng-sales-target-page) button[aria-label*="kolom" i] {
            display: none !important;
            width: 0 !important;
            max-width: 0 !important;
            padding: 0 !important;
            margin: 0 !important;
        }

        body:has(.ng-sales-target-page) .fi-ta-table th,
        body:has(.ng-sales-target-page) .fi-ta-table td {
            min-width: 0 !important;
            max-width: none !important;
            overflow: hidden !important;
            text-overflow: ellipsis !important;
            padding-left: 12px !important;
            padding-right: 12px !important;
            vertical-align: middle !important;
        }

        body:has(.ng-sales-target-page) .fi-ta-table th:nth-child(1),
        body:has(.ng-sales-target-page) .fi-ta-table td:nth-child(1) {
            width: 24% !important;
            max-width: 24% !important;
            padding-left: 16px !important;
        }

        body:has(.ng-sales-target-page) .fi-ta-table th:nth-child(2),
        body:has(.ng-sales-target-page) .fi-ta-table td:nth-child(2) {
            width: 30% !important;
            max-width: 30% !important;
        }

        body:has(.ng-sales-target-page) .fi-ta-table th:nth-child(3),
        body:has(.ng-sales-target-page) .fi-ta-table td:nth-child(3) {
            width: 20% !important;
            max-width: 20% !important;
            text-align: center !important;
        }

        body:has(.ng-sales-target-page) .fi-ta-table th:nth-child(4),
        body:has(.ng-sales-target-page) .fi-ta-table td:nth-child(4) {
            width: 20% !important;
            max-width: 20% !important;
            text-align: center !important;
        }

        body:has(.ng-sales-target-page) .fi-ta-actions,
        body:has(.ng-sales-target-page) .fi-ta-actions-cell,
        body:has(.ng-sales-target-page) td:has(.fi-ta-actions) {
            width: 58px !important;
            max-width: 58px !important;
            min-width: 58px !important;
            padding-left: 4px !important;
            padding-right: 14px !important;
            overflow: visible !important;
        }

        body:has(.ng-sales-target-page) .fi-ta-actions {
            display: flex !important;
            justify-content: flex-end !important;
        }

        body:has(.ng-sales-target-page) .fi-ta-actions .fi-btn {
            min-width: 36px !important;
            width: 36px !important;
            padding-left: 0 !important;
            padding-right: 0 !important;
            border-radius: 999px !important;
        }

        body:has(.ng-sales-target-page) .fi-ta-text,
        body:has(.ng-sales-target-page) .fi-ta-text-item,
        body:has(.ng-sales-target-page) .fi-ta-text-item-label {
            max-width: 100% !important;
            white-space: normal !important;
            word-break: break-word !important;
            overflow-wrap: anywhere !important;
        }

        body:has(.ng-sales-target-page) .fi-ta-cell .fi-badge {
            max-width: 100% !important;
            white-space: nowrap !important;
        }

        body:has(.ng-sales-target-page) .fi-ta-pagination,
        body:has(.ng-sales-target-page) .fi-pagination {
            min-height: 50px !important;
            padding: 8px 16px !important;
            background: rgba(255, 247, 235, .10) !important;
            border-top: 1px solid rgba(114, 74, 41, .08) !important;
        }

        body:has(.ng-sales-target-page) .fi-input-wrp,
        body:has(.ng-sales-target-page) .fi-ta-search-field .fi-input-wrp,
        body:has(.ng-sales-target-page) .fi-select-input {
            min-height: 38px !important;
            border-radius: 16px !important;
            background: rgba(255, 255, 255, .28) !important;
            border-color: rgba(255, 255, 255, .42) !important;
            box-shadow: inset 0 1px 0 rgba(255, 255, 255, .36) !important;
            backdrop-filter: blur(10px) !important;
            -webkit-backdrop-filter: blur(10px) !important;
        }

        body:has(.ng-sales-target-page) .fi-ta-search-field {
            max-width: 280px !important;
        }

        body:has(.ng-sales-target-page) .fi-btn {
            border-radius: 14px !important;
            font-weight: 900 !important;
        }

        body:has(.ng-sales-target-page) .fi-btn-color-primary,
        body:has(.ng-sales-target-page) .fi-btn-color-warning {
            background: linear-gradient(135deg, #ff9d18, #ee6500) !important;
            box-shadow: 0 12px 22px rgba(238, 101, 0, .22) !important;
        }


        /*
        |--------------------------------------------------------------------------
        | SALES TARGET TABLE COLUMN ALIGNMENT
        |--------------------------------------------------------------------------
        | Rapihkan posisi kolom:
        | Bulan, Target & Aktual, Progress, Selisih, Action.
        | Header kolom dibuat sejajar dengan data di bawahnya.
        |--------------------------------------------------------------------------
        */

        body:has(.ng-sales-target-page) .fi-ta-table {
            width: 100% !important;
            table-layout: fixed !important;
        }

        body:has(.ng-sales-target-page) .fi-ta-table th,
        body:has(.ng-sales-target-page) .fi-ta-table td {
            vertical-align: middle !important;
            min-width: 0 !important;
            overflow: hidden !important;
        }

        /*
         * Bulan
         */
        body:has(.ng-sales-target-page) .fi-ta-table th:nth-child(1),
        body:has(.ng-sales-target-page) .fi-ta-table td:nth-child(1) {
            width: 28% !important;
            max-width: 28% !important;
            text-align: left !important;
            padding-left: 28px !important;
            padding-right: 12px !important;
        }

        /*
         * Target & Aktual
         */
        body:has(.ng-sales-target-page) .fi-ta-table th:nth-child(2),
        body:has(.ng-sales-target-page) .fi-ta-table td:nth-child(2) {
            width: 28% !important;
            max-width: 28% !important;
            text-align: center !important;
            padding-left: 12px !important;
            padding-right: 12px !important;
        }

        /*
         * Progress
         */
        body:has(.ng-sales-target-page) .fi-ta-table th:nth-child(3),
        body:has(.ng-sales-target-page) .fi-ta-table td:nth-child(3) {
            width: 18% !important;
            max-width: 18% !important;
            text-align: center !important;
            padding-left: 12px !important;
            padding-right: 12px !important;
        }

        /*
         * Selisih
         */
        body:has(.ng-sales-target-page) .fi-ta-table th:nth-child(4),
        body:has(.ng-sales-target-page) .fi-ta-table td:nth-child(4) {
            width: 18% !important;
            max-width: 18% !important;
            text-align: center !important;
            padding-left: 12px !important;
            padding-right: 12px !important;
        }

        /*
         * Action/menu kanan
         */
        body:has(.ng-sales-target-page) .fi-ta-table th:nth-child(5),
        body:has(.ng-sales-target-page) .fi-ta-table td:nth-child(5),
        body:has(.ng-sales-target-page) .fi-ta-actions-cell,
        body:has(.ng-sales-target-page) td:has(.fi-ta-actions) {
            width: 8% !important;
            max-width: 8% !important;
            min-width: 70px !important;
            text-align: center !important;
            padding-left: 8px !important;
            padding-right: 18px !important;
            overflow: visible !important;
        }

        /*
         * Header kolom mengikuti posisi data.
         */
        body:has(.ng-sales-target-page) .fi-ta-table th:nth-child(1) > *,
        body:has(.ng-sales-target-page) .fi-ta-table td:nth-child(1) > *,
        body:has(.ng-sales-target-page) .fi-ta-table th:nth-child(1) button,
        body:has(.ng-sales-target-page) .fi-ta-table th:nth-child(1) .fi-ta-header-cell-label,
        body:has(.ng-sales-target-page) .fi-ta-table td:nth-child(1) .fi-ta-text,
        body:has(.ng-sales-target-page) .fi-ta-table td:nth-child(1) .fi-ta-text-item,
        body:has(.ng-sales-target-page) .fi-ta-table td:nth-child(1) .fi-ta-text-item-label {
            width: 100% !important;
            text-align: left !important;
            justify-content: flex-start !important;
            margin-left: 0 !important;
            margin-right: 0 !important;
        }

        body:has(.ng-sales-target-page) .fi-ta-table th:nth-child(2) > *,
        body:has(.ng-sales-target-page) .fi-ta-table td:nth-child(2) > *,
        body:has(.ng-sales-target-page) .fi-ta-table th:nth-child(3) > *,
        body:has(.ng-sales-target-page) .fi-ta-table td:nth-child(3) > *,
        body:has(.ng-sales-target-page) .fi-ta-table th:nth-child(4) > *,
        body:has(.ng-sales-target-page) .fi-ta-table td:nth-child(4) > *,
        body:has(.ng-sales-target-page) .fi-ta-table th:nth-child(5) > *,
        body:has(.ng-sales-target-page) .fi-ta-table td:nth-child(5) > * {
            width: 100% !important;
            justify-content: center !important;
            text-align: center !important;
            margin-left: auto !important;
            margin-right: auto !important;
        }

        body:has(.ng-sales-target-page) .fi-ta-table td:nth-child(2) .fi-ta-text,
        body:has(.ng-sales-target-page) .fi-ta-table td:nth-child(2) .fi-ta-text-item,
        body:has(.ng-sales-target-page) .fi-ta-table td:nth-child(3) .fi-ta-text,
        body:has(.ng-sales-target-page) .fi-ta-table td:nth-child(3) .fi-ta-text-item,
        body:has(.ng-sales-target-page) .fi-ta-table td:nth-child(4) .fi-ta-text,
        body:has(.ng-sales-target-page) .fi-ta-table td:nth-child(4) .fi-ta-text-item {
            text-align: center !important;
            justify-content: center !important;
        }

        body:has(.ng-sales-target-page) .fi-ta-actions {
            width: 100% !important;
            display: flex !important;
            justify-content: center !important;
        }

        body:has(.ng-sales-target-page) .fi-ta-actions .fi-btn {
            min-width: 36px !important;
            width: 36px !important;
            padding-left: 0 !important;
            padding-right: 0 !important;
            border-radius: 999px !important;
        }



        /*
        |--------------------------------------------------------------------------
        | SALES TARGET BULAN COLUMN RIGHT ALIGN TWEAK
        |--------------------------------------------------------------------------
        | Kolom Bulan dan data Bulan digeser ke kanan, lalu header dan data
        | dipaksa sejajar memakai padding + justify yang sama.
        |--------------------------------------------------------------------------
        */

        body:has(.ng-sales-target-page) .fi-ta-table th:nth-child(1),
        body:has(.ng-sales-target-page) .fi-ta-table td:nth-child(1) {
            padding-left: 48px !important;
            padding-right: 12px !important;
            text-align: left !important;
        }

        body:has(.ng-sales-target-page) .fi-ta-table th:nth-child(1) > *,
        body:has(.ng-sales-target-page) .fi-ta-table th:nth-child(1) button,
        body:has(.ng-sales-target-page) .fi-ta-table th:nth-child(1) button > *,
        body:has(.ng-sales-target-page) .fi-ta-table th:nth-child(1) .fi-ta-header-cell-label,
        body:has(.ng-sales-target-page) .fi-ta-table td:nth-child(1) > *,
        body:has(.ng-sales-target-page) .fi-ta-table td:nth-child(1) .fi-ta-text,
        body:has(.ng-sales-target-page) .fi-ta-table td:nth-child(1) .fi-ta-text-item,
        body:has(.ng-sales-target-page) .fi-ta-table td:nth-child(1) .fi-ta-text-item-label {
            width: 100% !important;
            justify-content: flex-start !important;
            text-align: left !important;
            margin-left: 0 !important;
            margin-right: 0 !important;
        }


        /*
        |--------------------------------------------------------------------------
        | SIDEBAR EFFECT SYNC
        |--------------------------------------------------------------------------
        */

        body:has(.ng-sales-target-page) .fi-sidebar {
            background: rgba(255, 250, 242, .50) !important;
            border-right: 1px solid rgba(255, 255, 255, .48) !important;
            box-shadow: 18px 0 55px rgba(137, 78, 26, .10) !important;
            backdrop-filter: blur(16px) !important;
            -webkit-backdrop-filter: blur(16px) !important;
        }

        body:has(.ng-sales-target-page) .fi-sidebar-nav {
            padding: 18px 14px !important;
        }

        body:has(.ng-sales-target-page) .fi-sidebar-item a,
        body:has(.ng-sales-target-page) .fi-sidebar-item-button {
            border-radius: 14px !important;
            color: #6f5844 !important;
            transition: .2s ease !important;
        }

        body:has(.ng-sales-target-page) .fi-sidebar-item-active a,
        body:has(.ng-sales-target-page) .fi-sidebar-item a:hover,
        body:has(.ng-sales-target-page) .fi-sidebar-item-active .fi-sidebar-item-button,
        body:has(.ng-sales-target-page) .fi-sidebar-item .fi-sidebar-item-button:hover,
        body:has(.ng-sales-target-page) .fi-sidebar-item.fi-active a,
        body:has(.ng-sales-target-page) .fi-sidebar-item.fi-active .fi-sidebar-item-button {
            background: linear-gradient(135deg, #ff9500, #f26a00) !important;
            color: #fff !important;
            box-shadow: 0 14px 24px rgba(242, 106, 0, .24) !important;
        }

        body:has(.ng-sales-target-page) .fi-sidebar-item-active svg,
        body:has(.ng-sales-target-page) .fi-sidebar-item a:hover svg,
        body:has(.ng-sales-target-page) .fi-sidebar-item-active span,
        body:has(.ng-sales-target-page) .fi-sidebar-item a:hover span,
        body:has(.ng-sales-target-page) .fi-sidebar-item-active .fi-sidebar-item-icon,
        body:has(.ng-sales-target-page) .fi-sidebar-item-active .fi-sidebar-item-label,
        body:has(.ng-sales-target-page) .fi-sidebar-item .fi-sidebar-item-button:hover .fi-sidebar-item-icon,
        body:has(.ng-sales-target-page) .fi-sidebar-item .fi-sidebar-item-button:hover .fi-sidebar-item-label,
        body:has(.ng-sales-target-page) .fi-sidebar-item.fi-active svg,
        body:has(.ng-sales-target-page) .fi-sidebar-item.fi-active span,
        body:has(.ng-sales-target-page) .fi-sidebar-item.fi-active .fi-sidebar-item-icon,
        body:has(.ng-sales-target-page) .fi-sidebar-item.fi-active .fi-sidebar-item-label {
            color: #fff !important;
        }

        /*
        |--------------------------------------------------------------------------
        | RESPONSIVE
        |--------------------------------------------------------------------------
        */

        @media (max-width: 1500px) {
            .ng-sales-target-kpi-grid {
                grid-template-columns: repeat(3, minmax(0, 1fr)) !important;
            }
        }

        @media (max-width: 1100px) {
            .ng-sales-target-page {
                padding: 18px 18px 10px !important;
            }

            .ng-widget-head {
                align-items: flex-start;
                flex-direction: column;
            }

            .ng-target-hero-right {
                width: 100%;
                justify-content: flex-start;
                flex-wrap: wrap;
            }

            .ng-target-filter {
                min-width: 0;
                justify-items: start;
            }

            .ng-target-filter-selects {
                flex-wrap: wrap;
            }

            .ng-target-select {
                flex: 1;
                min-width: 140px;
            }

            .ng-sales-target-kpi-grid {
                grid-template-columns: repeat(2, minmax(0, 1fr)) !important;
            }

            body:has(.ng-sales-target-page) .fi-ta-ctn {
                width: calc(100% - 36px) !important;
                max-width: calc(100% - 36px) !important;
                margin: 0 18px 22px !important;
            }
        }

        @media (max-width: 700px) {
            .ng-sales-target-page {
                padding: 14px 14px 8px !important;
            }

            .ng-sales-target-kpi-grid {
                grid-template-columns: 1fr !important;
            }

            .ng-target-hero-right {
                width: 100%;
                align-items: stretch;
                flex-direction: column;
            }

            .ng-target-filter,
            .ng-target-filter-selects {
                width: 100%;
            }

            .ng-primary-button {
                width: 100%;
            }

            .ng-widget-head h1 {
                font-size: 25px;
            }

            body:has(.ng-sales-target-page) .fi-ta-ctn {
                width: calc(100% - 28px) !important;
                max-width: calc(100% - 28px) !important;
                margin: 0 14px 20px !important;
            }
        }
    </style>

</x-filament-widgets::widget>
