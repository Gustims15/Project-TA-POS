<x-filament-panels::page>
    @php
        $summary = $this->getActivitySummary();

        $cards = [
            [
                'label' => 'Total Logs',
                'value' => number_format((int) ($summary['total_logs'] ?? 0), 0, ',', '.'),
                'caption' => 'Semua aktivitas',
                'icon' => '▣',
                'color' => '#f97316',
            ],
            [
                'label' => 'Updated Logs',
                'value' => number_format((int) ($summary['updated_logs'] ?? 0), 0, ',', '.'),
                'caption' => 'Data diperbarui',
                'icon' => '↗',
                'color' => '#3b82f6',
            ],
            [
                'label' => 'Created Logs',
                'value' => number_format((int) ($summary['created_logs'] ?? 0), 0, ',', '.'),
                'caption' => 'Data dibuat',
                'icon' => '✓',
                'color' => '#10b981',
            ],
            [
                'label' => 'Deleted Logs',
                'value' => number_format((int) ($summary['deleted_logs'] ?? 0), 0, ',', '.'),
                'caption' => 'Data dihapus',
                'icon' => '!',
                'color' => '#ef4444',
            ],
            [
                'label' => 'Access Logs',
                'value' => number_format((int) ($summary['access_logs'] ?? 0), 0, ',', '.'),
                'caption' => 'Login / akses',
                'icon' => '◇',
                'color' => '#8b5cf6',
            ],
        ];
    @endphp

    <div class="ng-activity-page">
        <section class="ng-activity-hero-grid">
            <article class="ng-widget-card ng-activity-hero-card">
                <div class="ng-widget-head">
                    <div>
                        <span class="ng-kicker">
                            POS Ngunjuk
                        </span>

                        <h1>Activity Log Analytics</h1>

                        <p>
                            Pantau seluruh aktivitas sistem seperti login, perubahan produk, order, kategori,
                            user, role, dan riwayat aksi admin atau karyawan yang tercatat otomatis.
                        </p>
                    </div>
                </div>
            </article>

            <article class="ng-widget-card ng-activity-highlight-card">
                <div class="ng-highlight-column">
                    <span>User Teraktif</span>
                    <strong>{{ $summary['top_user'] ?? '-' }}</strong>
                    <small>{{ number_format((int) ($summary['top_user_total'] ?? 0), 0, ',', '.') }} aktivitas</small>
                </div>

                <div class="ng-highlight-divider"></div>

                <div class="ng-highlight-column">
                    <span>Aktivitas Terbaru</span>
                    <strong>{{ str($summary['latest_event'] ?? '-')->headline() }}</strong>
                    <small>{{ $summary['latest_user'] ?? '-' }} • {{ $summary['latest_time'] ?? '-' }}</small>
                </div>
            </article>
        </section>

        <section class="ng-kpi-grid ng-activity-kpi-grid">
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

        <section class="ng-widget-card ng-activity-table-card">
            {{ $this->table }}
        </section>
    </div>

    <style>
        html,
        body {
            overflow-x: hidden !important;
        }

        body:has(.ng-activity-page) {
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

        body:has(.ng-activity-page) .fi-main,
        body:has(.ng-activity-page) .fi-main-ctn,
        body:has(.ng-activity-page) .fi-page,
        body:has(.ng-activity-page) .fi-page-content {
            width: 100% !important;
            max-width: 100% !important;
            background: transparent !important;
            overflow-x: hidden !important;
        }

        body:has(.ng-activity-page) .fi-page {
            padding: 0 !important;
        }

        body:has(.ng-activity-page) .fi-page-header {
            display: none !important;
        }

        body:has(.ng-activity-page) .fi-main {
            padding: 0 !important;
        }

        body:has(.ng-activity-page) .fi-page-content {
            gap: 0 !important;
            row-gap: 0 !important;
        }

        .ng-activity-page {
            width: 100% !important;
            max-width: 100% !important;
            min-height: 100vh;
            padding: 24px 24px 32px !important;
            overflow: hidden !important;
            font-family: Inter, Poppins, ui-sans-serif, system-ui, -apple-system, BlinkMacSystemFont, "Segoe UI", sans-serif;
            color: #24180f;
        }

        .ng-activity-page * {
            box-sizing: border-box;
        }

        .ng-activity-hero-grid {
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

        .ng-activity-hero-card,
        .ng-activity-highlight-card {
            min-height: 126px;
        }

        .ng-activity-hero-card {
            display: flex;
            align-items: center;
        }

        .ng-widget-head {
            position: relative;
            z-index: 2;
            width: 100%;
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
            letter-spacing: .08em;
            text-transform: uppercase;
            box-shadow: inset 0 1px 0 rgba(255, 255, 255, .70);
            backdrop-filter: blur(12px);
            -webkit-backdrop-filter: blur(12px);
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
            max-width: 820px;
            margin: 8px 0 0;
            color: #765d45;
            font-size: 13px;
            line-height: 1.55;
            font-weight: 700;
        }

        .ng-activity-highlight-card {
            display: grid;
            grid-template-columns: 1fr auto 1fr;
            align-items: center;
            gap: 14px;
        }

        .ng-highlight-column {
            position: relative;
            z-index: 2;
            min-width: 0;
        }

        .ng-highlight-column span {
            display: block;
            color: #765d45;
            font-size: 11px;
            font-weight: 900;
        }

        .ng-highlight-column strong {
            display: block;
            max-width: 240px;
            margin: 8px 0;
            color: #21160d;
            font-size: 20px;
            line-height: 1.1;
            font-weight: 950;
            white-space: nowrap;
            overflow: hidden;
            text-overflow: ellipsis;
        }

        .ng-highlight-column small {
            display: block;
            color: #765d45;
            font-size: 11px;
            line-height: 1.35;
            font-weight: 850;
            white-space: nowrap;
            overflow: hidden;
            text-overflow: ellipsis;
        }

        .ng-highlight-divider {
            position: relative;
            z-index: 2;
            width: 1px;
            height: 70px;
            background: rgba(114, 74, 41, .12);
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

        /*
        |--------------------------------------------------------------------------
        | TABLE FILAMENT - ACTIVITY PAGE
        |--------------------------------------------------------------------------
        */

        .ng-activity-table-card {
            padding: 0;
        }

        body:has(.ng-activity-page) .fi-ta-ctn {
            width: 100% !important;
            margin: 0 !important;
            border: none !important;
            border-radius: 24px !important;
            background: transparent !important;
            box-shadow: none !important;
            overflow: hidden !important;
        }

        body:has(.ng-activity-page) .fi-section,
        body:has(.ng-activity-page) .fi-ta,
        body:has(.ng-activity-page) .fi-ta-content,
        body:has(.ng-activity-page) .fi-ta-table,
        body:has(.ng-activity-page) .fi-ta-ctn > div,
        body:has(.ng-activity-page) .fi-ta-ctn > div > div,
        body:has(.ng-activity-page) .fi-ta-ctn > div > div > div,
        body:has(.ng-activity-page) table,
        body:has(.ng-activity-page) thead,
        body:has(.ng-activity-page) tbody,
        body:has(.ng-activity-page) tr,
        body:has(.ng-activity-page) th,
        body:has(.ng-activity-page) td {
            background: transparent !important;
            box-shadow: none !important;
        }

        body:has(.ng-activity-page) .fi-ta-header,
        body:has(.ng-activity-page) .fi-ta-toolbar {
            min-height: 46px !important;
            padding: 8px 16px !important;
            background: rgba(255, 247, 235, .10) !important;
            border-bottom: 1px solid rgba(114, 74, 41, .08) !important;
        }

        body:has(.ng-activity-page) .fi-ta-header-cell {
            padding-top: 10px !important;
            padding-bottom: 10px !important;
            background: rgba(255, 255, 255, .10) !important;
            border-color: rgba(114, 74, 41, .08) !important;
        }

        body:has(.ng-activity-page) .fi-ta-header-cell-label {
            color: #4b3525 !important;
            font-size: 12px !important;
            font-weight: 950 !important;
        }

        body:has(.ng-activity-page) .fi-ta-row {
            min-height: 54px !important;
            border-bottom: 1px solid rgba(114, 74, 41, .08) !important;
            background: rgba(255, 247, 235, .04) !important;
            transition: .18s ease !important;
        }

        body:has(.ng-activity-page) .fi-ta-row:hover {
            background: rgba(255, 255, 255, .14) !important;
        }

        body:has(.ng-activity-page) .fi-ta-cell {
            padding-top: 10px !important;
            padding-bottom: 10px !important;
            border-color: rgba(114, 74, 41, .08) !important;
            background: transparent !important;
        }

        body:has(.ng-activity-page) .fi-ta-pagination,
        body:has(.ng-activity-page) .fi-pagination {
            min-height: 48px !important;
            padding: 8px 16px !important;
            background: rgba(255, 247, 235, .10) !important;
            border-top: 1px solid rgba(114, 74, 41, .08) !important;
        }

        body:has(.ng-activity-page) .fi-input-wrp,
        body:has(.ng-activity-page) .fi-ta-search-field .fi-input-wrp,
        body:has(.ng-activity-page) .fi-select-input {
            min-height: 38px !important;
            border-radius: 16px !important;
            background: rgba(255, 255, 255, .28) !important;
            border-color: rgba(255, 255, 255, .42) !important;
            box-shadow: inset 0 1px 0 rgba(255, 255, 255, .36) !important;
            backdrop-filter: blur(10px) !important;
            -webkit-backdrop-filter: blur(10px) !important;
        }

        body:has(.ng-activity-page) .fi-ta-search-field {
            max-width: 280px !important;
        }

        body:has(.ng-activity-page) .fi-btn {
            border-radius: 14px !important;
            font-weight: 900 !important;
        }

        body:has(.ng-activity-page) .fi-btn-color-primary,
        body:has(.ng-activity-page) .fi-btn-color-warning {
            background: linear-gradient(135deg, #ff9d18, #ee6500) !important;
            box-shadow: 0 12px 22px rgba(238, 101, 0, .22) !important;
        }

        /*
        |--------------------------------------------------------------------------
        | SIDEBAR EFFECT SYNC
        |--------------------------------------------------------------------------
        */

        body:has(.ng-activity-page) .fi-sidebar {
            background: rgba(255, 250, 242, .50) !important;
            border-right: 1px solid rgba(255, 255, 255, .48) !important;
            box-shadow: 18px 0 55px rgba(137, 78, 26, .10) !important;
            backdrop-filter: blur(16px) !important;
            -webkit-backdrop-filter: blur(16px) !important;
        }

        body:has(.ng-activity-page) .fi-sidebar-nav {
            padding: 18px 14px !important;
        }

        body:has(.ng-activity-page) .fi-sidebar-item a {
            border-radius: 14px !important;
            color: #6f5844 !important;
            transition: .2s ease !important;
        }

        body:has(.ng-activity-page) .fi-sidebar-item-active a,
        body:has(.ng-activity-page) .fi-sidebar-item a:hover {
            background: linear-gradient(135deg, #ff9500, #f26a00) !important;
            color: #fff !important;
            box-shadow: 0 14px 24px rgba(242, 106, 0, .24) !important;
        }

        body:has(.ng-activity-page) .fi-sidebar-item-active svg,
        body:has(.ng-activity-page) .fi-sidebar-item a:hover svg,
        body:has(.ng-activity-page) .fi-sidebar-item-active span,
        body:has(.ng-activity-page) .fi-sidebar-item a:hover span {
            color: #fff !important;
        }

        @media (max-width: 1500px) {
            .ng-activity-hero-grid {
                grid-template-columns: 1fr;
            }

            .ng-kpi-grid {
                grid-template-columns: repeat(3, minmax(0, 1fr));
            }
        }

        @media (max-width: 1100px) {
            .ng-activity-page {
                padding: 18px 18px 28px !important;
            }

            .ng-activity-highlight-card {
                grid-template-columns: 1fr;
            }

            .ng-highlight-divider {
                width: 100%;
                height: 1px;
            }
        }

        @media (max-width: 700px) {
            .ng-kpi-grid {
                grid-template-columns: 1fr;
            }

            .ng-activity-page {
                padding: 14px 14px 24px !important;
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
