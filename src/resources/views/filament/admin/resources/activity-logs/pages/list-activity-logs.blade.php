<x-filament-panels::page>
    @php
        $summary = $this->getActivitySummary();
        $totalLogs = number_format((int) ($summary['total_logs'] ?? 0), 0, ',', '.');
    @endphp

    <div class="ng-activity-page">
        <section class="ng-activity-hero-grid">
            <article class="ng-activity-card ng-activity-hero-card">
                <div class="ng-activity-hero-copy">

                    <h1>Activity Log Analytics</h1>

                    <p>
                        Pantau seluruh aktivitas sistem seperti login, perubahan produk, order, kategori,
                        user, role, dan riwayat aksi admin atau karyawan yang tercatat otomatis.
                    </p>
                </div>

                <div class="ng-activity-total-box">
                    <span>Total Login/Logout</span>
                    <strong>{{ $totalLogs }}</strong>
                    <small>Login dan logout tercatat</small>
                </div>
            </article>
        </section>

        <section class="ng-activity-table-shell">
            {{ $this->table }}
        </section>
    </div>

    <style>
        html,
        body {
            overflow-x: hidden !important;
            overflow-y: auto !important;
            height: auto !important;
            max-height: none !important;
        }

        body:has(.ng-activity-page) {
            background:
                linear-gradient(120deg, rgba(255, 248, 237, .10), rgba(255, 224, 185, .02)),
                url('/images/pos-orange-bg.png'),
                radial-gradient(circle at 15% 8%, rgba(255, 255, 255, .32) 0 130px, transparent 280px),
                radial-gradient(circle at 88% 78%, rgba(255, 118, 0, .42) 0 250px, transparent 520px),
                radial-gradient(circle at 20% 96%, rgba(255, 181, 83, .28) 0 220px, transparent 500px),
                linear-gradient(135deg, #fff3df 0%, #ffd394 48%, #ff9c45 100%) !important;
            background-size: cover !important;
            background-position: center !important;
            background-attachment: scroll !important;
        }

        body:has(.ng-activity-page) .fi-main,
        body:has(.ng-activity-page) .fi-main-ctn,
        body:has(.ng-activity-page) .fi-page,
        body:has(.ng-activity-page) .fi-page-content,
        body:has(.ng-activity-page) main {
            width: 100% !important;
            max-width: 100% !important;
            height: auto !important;
            min-height: 0 !important;
            max-height: none !important;
            background: transparent !important;
            overflow-x: hidden !important;
            overflow-y: visible !important;
        }

        body:has(.ng-activity-page) .fi-page,
        body:has(.ng-activity-page) .fi-main {
            padding: 0 !important;
        }

        body:has(.ng-activity-page) .fi-page-header {
            display: none !important;
        }

        .ng-activity-page {
            width: 100%;
            min-height: 0 !important;
            padding: 18px;
            overflow: visible !important;
            font-family: Inter, Poppins, ui-sans-serif, system-ui, -apple-system, BlinkMacSystemFont, "Segoe UI", sans-serif;
            color: #24180f;
            box-sizing: border-box;
        }

        .ng-activity-page * {
            box-sizing: border-box;
        }

        .ng-activity-hero-grid {
            display: grid;
            grid-template-columns: 1fr;
            gap: 0;
            margin-bottom: 14px;
        }

        .ng-activity-card,
        .ng-activity-hero-card {
            position: relative;
            border: 1px solid rgba(255, 255, 255, .58);
            background:
                linear-gradient(145deg, rgba(255, 255, 255, .46), rgba(255, 246, 231, .22)),
                radial-gradient(circle at 100% 0%, rgba(255, 153, 30, .16), transparent 38%) !important;
            box-shadow:
                0 18px 44px rgba(101, 58, 21, .10),
                inset 0 1px 0 rgba(255, 255, 255, .60);
            backdrop-filter: none !important;
            -webkit-backdrop-filter: none !important;
        }

        .ng-activity-hero-card {
            min-height: 126px;
            display: flex;
            align-items: center;
            justify-content: space-between;
            gap: 22px;
            padding: 22px 24px;
            border-radius: 24px;
            overflow: hidden;
        }

        .ng-activity-hero-copy {
            min-width: 0;
            flex: 1;
        }

        .ng-kicker {
            display: inline-flex;
            width: fit-content;
            padding: 6px 12px;
            margin-bottom: 9px;
            border-radius: 999px;
            background: rgba(255, 255, 255, .38);
            border: 1px solid rgba(255, 255, 255, .55);
            color: #d95d00;
            font-size: 10px;
            font-weight: 950;
            letter-spacing: .12em;
            text-transform: uppercase;
        }

        .ng-activity-hero-copy h1 {
            margin: 0;
            color: #21160d;
            font-size: 31px;
            line-height: 1.05;
            font-weight: 950;
            letter-spacing: -.04em;
        }

        .ng-activity-hero-copy p {
            max-width: 920px;
            margin: 8px 0 0;
            color: #72583f;
            font-size: 12px;
            font-weight: 700;
            line-height: 1.55;
        }

        .ng-activity-total-box {
            flex: 0 0 210px;
            min-height: 86px;
            display: flex;
            flex-direction: column;
            justify-content: center;
            padding: 16px 18px;
            border-radius: 20px;
            background: rgba(255, 255, 255, .32);
            border: 1px solid rgba(255, 255, 255, .48);
            box-shadow:
                inset 0 1px 0 rgba(255, 255, 255, .50),
                0 14px 28px rgba(101, 58, 21, .08);
        }

        .ng-activity-total-box span {
            color: #72583f;
            font-size: 11px;
            font-weight: 950;
            text-transform: uppercase;
            letter-spacing: .06em;
        }

        .ng-activity-total-box strong {
            margin-top: 6px;
            color: #21160d;
            font-size: 25px;
            line-height: 1;
            font-weight: 950;
            letter-spacing: -.04em;
        }

        .ng-activity-total-box small {
            margin-top: 7px;
            color: #72583f;
            font-size: 11px;
            font-weight: 850;
        }

        .ng-activity-table-shell {
            width: 100%;
            background: transparent !important;
            border: none !important;
            box-shadow: none !important;
            padding: 0 !important;
            overflow: visible !important;
        }

        body:has(.ng-activity-page) .fi-ta-ctn {
            width: 100% !important;
            margin: 0 !important;
            border: none !important;
            border-radius: 0 !important;
            background: transparent !important;
            box-shadow: none !important;
            overflow-x: hidden !important;
            overflow-y: visible !important;
        }

        body:has(.ng-activity-page) .fi-ta-content {
            border-radius: 24px !important;
            background: rgba(255, 247, 235, .13) !important;
            border: 1px solid rgba(255, 255, 255, .40) !important;
            box-shadow:
                0 18px 44px rgba(101, 58, 21, .07),
                inset 0 1px 0 rgba(255, 255, 255, .24) !important;
            overflow-x: hidden !important;
            overflow-y: visible !important;
        }

        body:has(.ng-activity-page) .fi-ta-header,
        body:has(.ng-activity-page) .fi-ta-toolbar {
            background: rgba(255, 247, 235, .18) !important;
            border-radius: 24px 24px 0 0 !important;
            border: 1px solid rgba(255, 255, 255, .46) !important;
            border-bottom: 1px solid rgba(114, 74, 41, .08) !important;
        }

        body:has(.ng-activity-page) .fi-ta,
        body:has(.ng-activity-page) .fi-section,
        body:has(.ng-activity-page) .fi-ta-content,
        body:has(.ng-activity-page) .fi-ta-table-wrap,
        body:has(.ng-activity-page) .fi-ta-table {
            height: auto !important;
            min-height: 0 !important;
            max-height: none !important;
            overflow-x: hidden !important;
            overflow-y: visible !important;
        }

        body:has(.ng-activity-page) .fi-main,
        body:has(.ng-activity-page) .fi-main-ctn,
        body:has(.ng-activity-page) .fi-page,
        body:has(.ng-activity-page) .fi-page-content,
        body:has(.ng-activity-page) .fi-ta-ctn,
        body:has(.ng-activity-page) .fi-ta-content,
        body:has(.ng-activity-page) .fi-ta-table-wrap {
            scrollbar-width: none !important;
            -ms-overflow-style: none !important;
        }

        body:has(.ng-activity-page) .fi-main::-webkit-scrollbar,
        body:has(.ng-activity-page) .fi-main-ctn::-webkit-scrollbar,
        body:has(.ng-activity-page) .fi-page::-webkit-scrollbar,
        body:has(.ng-activity-page) .fi-page-content::-webkit-scrollbar,
        body:has(.ng-activity-page) .fi-ta-ctn::-webkit-scrollbar,
        body:has(.ng-activity-page) .fi-ta-content::-webkit-scrollbar,
        body:has(.ng-activity-page) .fi-ta-table-wrap::-webkit-scrollbar {
            display: none !important;
            width: 0 !important;
            height: 0 !important;
        }

        @media (max-width: 900px) {
            .ng-activity-page {
                padding: 14px !important;
            }

            .ng-activity-hero-card {
                flex-direction: column;
                align-items: flex-start;
            }

            .ng-activity-total-box {
                width: 100%;
                flex-basis: auto;
            }
        }
    </style>
</x-filament-panels::page>
