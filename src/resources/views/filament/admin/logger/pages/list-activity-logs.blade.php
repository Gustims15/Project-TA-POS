<x-filament-panels::page>
    @php
        $summary = $this->getActivitySummary();

        $cards = [
            [
                'label' => 'Total Logs',
                'value' => number_format($summary['total_logs'], 0, ',', '.'),
                'caption' => 'Semua aktivitas',
                'icon' => '▣',
                'color' => '#f97316',
            ],
            [
                'label' => 'Updated Logs',
                'value' => number_format($summary['updated_logs'], 0, ',', '.'),
                'caption' => 'Data diperbarui',
                'icon' => '↗',
                'color' => '#3b82f6',
            ],
            [
                'label' => 'Created Logs',
                'value' => number_format($summary['created_logs'], 0, ',', '.'),
                'caption' => 'Data dibuat',
                'icon' => '✓',
                'color' => '#10b981',
            ],
            [
                'label' => 'Deleted Logs',
                'value' => number_format($summary['deleted_logs'], 0, ',', '.'),
                'caption' => 'Data dihapus',
                'icon' => '!',
                'color' => '#ef4444',
            ],
            [
                'label' => 'Access Logs',
                'value' => number_format($summary['access_logs'], 0, ',', '.'),
                'caption' => 'Login / akses',
                'icon' => '◇',
                'color' => '#8b5cf6',
            ],
        ];
    @endphp

    <div class="ng-activity-page">
        <section class="ng-activity-hero">
            <article class="ng-activity-hero-main">
                <span class="ng-activity-kicker">POS Ngunjuk</span>

                <h1>Activity Log Analytics</h1>

                <p>
                    Pantau seluruh aktivitas sistem seperti login, perubahan produk, order, kategori,
                    user, role, dan riwayat aksi admin atau karyawan yang tercatat otomatis.
                </p>
            </article>

            <article class="ng-activity-side-card">
                <div>
                    <span>User Teraktif</span>
                    <strong>{{ $summary['top_user'] }}</strong>
                    <small>{{ number_format($summary['top_user_total'], 0, ',', '.') }} aktivitas</small>
                </div>

                <div class="ng-activity-latest">
                    <span>Aktivitas Terbaru</span>
                    <strong>{{ str($summary['latest_event'])->headline() }}</strong>
                    <small>{{ $summary['latest_user'] }} • {{ $summary['latest_time'] }}</small>
                </div>
            </article>
        </section>

        <section class="ng-activity-kpi-grid">
            @foreach ($cards as $card)
                <article class="ng-activity-kpi" style="--accent: {{ $card['color'] }};">
                    <div class="ng-activity-kpi-icon">
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

        <section class="ng-activity-table-wrap">
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
                linear-gradient(120deg, rgba(255, 248, 237, .10), rgba(255, 224, 185, .02)),
                url('/images/admin-orange-bg.png'),
                radial-gradient(circle at 15% 8%, rgba(255, 255, 255, .32) 0 130px, transparent 280px),
                radial-gradient(circle at 88% 78%, rgba(255, 118, 0, .42) 0 250px, transparent 520px),
                radial-gradient(circle at 20% 96%, rgba(255, 181, 83, .28) 0 220px, transparent 500px),
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

        body:has(.ng-activity-page) .fi-sidebar {
            background: rgba(255, 250, 242, .50) !important;
            border-right: 1px solid rgba(255, 255, 255, .48) !important;
            box-shadow: 18px 0 55px rgba(137, 78, 26, .10) !important;
            backdrop-filter: blur(16px) !important;
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

        .ng-activity-page {
            width: 100%;
            padding: 18px 18px 28px;
            font-family: Inter, Poppins, ui-sans-serif, system-ui, -apple-system, BlinkMacSystemFont, "Segoe UI", sans-serif;
            color: #24180f;
            box-sizing: border-box;
        }

        .ng-activity-page * {
            box-sizing: border-box;
        }

        .ng-activity-hero {
            display: grid;
            grid-template-columns: minmax(0, 1.35fr) minmax(340px, .65fr);
            gap: 12px;
            margin-bottom: 12px;
        }

        .ng-activity-hero-main,
        .ng-activity-side-card,
        .ng-activity-kpi,
        .ng-activity-table-wrap {
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

        .ng-activity-hero-main {
            min-height: 126px;
            padding: 20px 22px;
            border-radius: 24px;
        }

        .ng-activity-kicker {
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
        }

        .ng-activity-hero-main h1 {
            margin: 0;
            color: #21160d;
            font-size: 30px;
            line-height: 1.05;
            font-weight: 950;
            letter-spacing: -.04em;
        }

        .ng-activity-hero-main p {
            max-width: 820px;
            margin: 7px 0 0;
            color: #765d45;
            font-size: 12px;
            font-weight: 650;
            line-height: 1.5;
        }

        .ng-activity-side-card {
            min-height: 126px;
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 12px;
            padding: 20px 22px;
            border-radius: 24px;
        }

        .ng-activity-side-card span,
        .ng-activity-side-card small {
            display: block;
            color: #765d45;
            font-size: 11px;
            font-weight: 850;
        }

        .ng-activity-side-card strong {
            display: block;
            max-width: 240px;
            margin: 7px 0;
            color: #21160d;
            font-size: 20px;
            line-height: 1.1;
            font-weight: 950;
            white-space: nowrap;
            overflow: hidden;
            text-overflow: ellipsis;
        }

        .ng-activity-latest {
            padding-left: 12px;
            border-left: 1px solid rgba(114, 74, 41, .10);
        }

        .ng-activity-kpi-grid {
            display: grid;
            grid-template-columns: repeat(5, minmax(0, 1fr));
            gap: 10px;
            margin-bottom: 12px;
        }

        .ng-activity-kpi {
            min-height: 90px;
            display: flex;
            align-items: center;
            gap: 11px;
            padding: 14px;
            border-radius: 20px;
        }

        .ng-activity-kpi-icon {
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

        .ng-activity-kpi span {
            display: block;
            color: #6f5946;
            font-size: 11px;
            font-weight: 900;
        }

        .ng-activity-kpi strong {
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

        .ng-activity-kpi p {
            margin: 6px 0 0;
            color: #6f5946;
            font-size: 10px;
            font-weight: 850;
        }

        .ng-activity-table-wrap {
            width: 100%;
            border-radius: 24px;
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

        body:has(.ng-activity-page) .fi-ta,
        body:has(.ng-activity-page) .fi-section,
        body:has(.ng-activity-page) .fi-ta-content,
        body:has(.ng-activity-page) .fi-ta-table,
        body:has(.ng-activity-page) .fi-ta-table thead,
        body:has(.ng-activity-page) .fi-ta-table tbody {
            background: transparent !important;
            border: none !important;
            box-shadow: none !important;
            backdrop-filter: none !important;
        }

        body:has(.ng-activity-page) .fi-ta-header,
        body:has(.ng-activity-page) .fi-ta-toolbar {
            min-height: 46px !important;
            padding: 6px 16px !important;
            background: rgba(255, 247, 235, .10) !important;
            border-bottom: 1px solid rgba(114, 74, 41, .07) !important;
        }

        body:has(.ng-activity-page) .fi-ta-table thead tr {
            background: rgba(255, 247, 235, .10) !important;
        }

        body:has(.ng-activity-page) .fi-ta-row,
        body:has(.ng-activity-page) .fi-ta-cell,
        body:has(.ng-activity-page) .fi-ta-header-cell {
            background: transparent !important;
        }

        body:has(.ng-activity-page) .fi-ta-row {
            min-height: 54px !important;
            border-bottom: 1px solid rgba(114, 74, 41, .07) !important;
            transition: .18s ease !important;
        }

        body:has(.ng-activity-page) .fi-ta-row:hover {
            background: rgba(255, 255, 255, .10) !important;
        }

        body:has(.ng-activity-page) .fi-ta-cell {
            padding-top: 8px !important;
            padding-bottom: 8px !important;
            border-color: rgba(114, 74, 41, .07) !important;
        }

        body:has(.ng-activity-page) .fi-ta-header-cell {
            padding-top: 9px !important;
            padding-bottom: 9px !important;
            border-color: rgba(114, 74, 41, .07) !important;
        }

        body:has(.ng-activity-page) .fi-ta-header-cell-label {
            color: #4b3525 !important;
            font-size: 12px !important;
            font-weight: 950 !important;
        }

        body:has(.ng-activity-page) .fi-ta-pagination,
        body:has(.ng-activity-page) .fi-pagination {
            min-height: 50px !important;
            padding: 8px 16px !important;
            background: rgba(255, 247, 235, .10) !important;
            border-top: 1px solid rgba(114, 74, 41, .07) !important;
        }

        body:has(.ng-activity-page) .fi-input-wrp,
        body:has(.ng-activity-page) .fi-ta-search-field .fi-input-wrp,
        body:has(.ng-activity-page) .fi-select-input {
            border-radius: 16px !important;
            background: rgba(255, 255, 255, .26) !important;
            border-color: rgba(255, 255, 255, .40) !important;
            box-shadow: inset 0 1px 0 rgba(255, 255, 255, .32) !important;
            backdrop-filter: blur(10px) !important;
        }

        body:has(.ng-activity-page) .fi-ta-search-field {
            max-width: 280px !important;
        }

        body:has(.ng-activity-page) .fi-ta-search-field .fi-input-wrp {
            min-height: 36px !important;
        }

        @media (max-width: 1500px) {
            .ng-activity-hero {
                grid-template-columns: 1fr;
            }

            .ng-activity-kpi-grid {
                grid-template-columns: repeat(3, minmax(0, 1fr));
            }
        }

        @media (max-width: 900px) {
            .ng-activity-page {
                padding: 14px !important;
            }

            .ng-activity-side-card,
            .ng-activity-kpi-grid {
                grid-template-columns: 1fr;
            }
        }
    </style>
</x-filament-panels::page>
