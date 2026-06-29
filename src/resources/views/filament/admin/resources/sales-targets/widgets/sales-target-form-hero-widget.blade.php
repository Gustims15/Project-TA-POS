<x-filament-widgets::widget>
    <div class="ng-sales-target-form-page" style="
        width: 100%;
        padding: 16px 18px 6px;
        font-family: Inter, Poppins, ui-sans-serif, system-ui, -apple-system, BlinkMacSystemFont, 'Segoe UI', sans-serif;
        color: #24180f;
    ">
        <div style="
            display: grid;
            grid-template-columns: minmax(0, 1.35fr) minmax(340px, .65fr);
            gap: 12px;
            margin-bottom: 10px;
        ">
            <div style="
                min-height: 118px;
                padding: 20px 22px;
                border-radius: 24px;
                border: 1px solid rgba(255, 255, 255, .56);
                background: rgba(255, 247, 235, .18);
                box-shadow:
                    0 20px 48px rgba(101, 58, 21, .10),
                    0 0 0 1px rgba(255, 255, 255, .10) inset,
                    inset 0 1px 0 rgba(255, 255, 255, .56);
                backdrop-filter: blur(13px);
                overflow: hidden;
            ">
                <span style="
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
                ">
                    Sales Target Form
                </span>

                <h1 style="
                    margin: 0;
                    color: #21160d;
                    font-size: 30px;
                    line-height: 1.05;
                    font-weight: 950;
                    letter-spacing: -.04em;
                ">
                    {{ $title }}
                </h1>

                <p style="
                    max-width: 720px;
                    margin: 7px 0 0;
                    color: #765d45;
                    font-size: 12px;
                    font-weight: 650;
                    line-height: 1.5;
                ">
                    {{ $description }}
                </p>
            </div>

            <div style="
                min-height: 118px;
                display: flex;
                align-items: center;
                justify-content: space-between;
                gap: 14px;
                padding: 20px 22px;
                border-radius: 24px;
                border: 1px solid rgba(255, 255, 255, .56);
                background: rgba(255, 247, 235, .18);
                box-shadow:
                    0 20px 48px rgba(101, 58, 21, .10),
                    0 0 0 1px rgba(255, 255, 255, .10) inset,
                    inset 0 1px 0 rgba(255, 255, 255, .56);
                backdrop-filter: blur(13px);
                overflow: hidden;
            ">
                <div style="min-width: 0;">
                    <span style="
                        display: block;
                        color: #765d45;
                        font-size: 11px;
                        font-weight: 850;
                    ">
                        Target Bulan Ini
                    </span>

                    <strong style="
                        display: block;
                        max-width: 280px;
                        margin: 7px 0;
                        overflow: hidden;
                        color: #21160d;
                        font-size: 22px;
                        line-height: 1.1;
                        font-weight: 950;
                        white-space: nowrap;
                        text-overflow: ellipsis;
                    ">
                        {{ $this->rupiah($stats['current_target_revenue']) }}
                    </strong>

                    <small style="
                        display: block;
                        color: #765d45;
                        font-size: 11px;
                        font-weight: 850;
                    ">
                        {{ number_format($stats['total_targets'], 0, ',', '.') }} target tersimpan • Tahun ini {{ $this->rupiah($stats['year_target_revenue']) }}
                    </small>
                </div>

                <a href="{{ $backUrl }}" style="
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
                ">
                    ← Kembali
                </a>
            </div>
        </div>
    </div>

    <style>
        html,
        body {
            overflow-x: hidden !important;
        }

        body:has(.ng-sales-target-form-page) {
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

        body:has(.ng-sales-target-form-page) .fi-main,
        body:has(.ng-sales-target-form-page) .fi-main-ctn,
        body:has(.ng-sales-target-form-page) .fi-page,
        body:has(.ng-sales-target-form-page) .fi-page-content {
            width: 100% !important;
            max-width: 100% !important;
            background: transparent !important;
            overflow-x: hidden !important;
        }

        body:has(.ng-sales-target-form-page) .fi-page {
            padding: 0 !important;
        }

        body:has(.ng-sales-target-form-page) .fi-page-header {
            display: none !important;
        }

        body:has(.ng-sales-target-form-page) .fi-main {
            padding: 0 !important;
        }

        body:has(.ng-sales-target-form-page) .fi-wi-widget,
        body:has(.ng-sales-target-form-page) .fi-wi-widget-content,
        body:has(.ng-sales-target-form-page) .fi-wi {
            background: transparent !important;
            box-shadow: none !important;
            border: none !important;
            margin-bottom: 0 !important;
            padding-bottom: 0 !important;
        }

        body:has(.ng-sales-target-form-page) .fi-page-content {
            gap: 0 !important;
            row-gap: 0 !important;
        }

        body:has(.ng-sales-target-form-page) .ng-sales-target-form-page {
            padding-bottom: 0 !important;
        }

        body:has(.ng-sales-target-form-page) .fi-page-content > form {
            margin-top: -28px !important;
        }

        body:has(.ng-sales-target-form-page) form,
        body:has(.ng-sales-target-form-page) .fi-section,
        body:has(.ng-sales-target-form-page) .fi-fo-component-ctn {
            background: transparent !important;
        }

        body:has(.ng-sales-target-form-page) .fi-section {
            margin-left: 18px !important;
            margin-right: 18px !important;
            width: calc(100% - 36px) !important;
            border-radius: 24px !important;
            border: 1px solid rgba(255, 255, 255, .46) !important;
            background: rgba(255, 247, 235, .14) !important;
            box-shadow:
                0 18px 46px rgba(101, 58, 21, .09),
                inset 0 1px 0 rgba(255, 255, 255, .38) !important;
            backdrop-filter: blur(12px) !important;
            overflow: hidden !important;
        }

        body:has(.ng-sales-target-form-page) .fi-input-wrp,
        body:has(.ng-sales-target-form-page) .fi-select-input,
        body:has(.ng-sales-target-form-page) .fi-textarea {
            border-radius: 16px !important;
            background: rgba(255, 255, 255, .34) !important;
            border-color: rgba(255, 255, 255, .42) !important;
            box-shadow: inset 0 1px 0 rgba(255, 255, 255, .34) !important;
            backdrop-filter: blur(10px) !important;
        }

        body:has(.ng-sales-target-form-page) .fi-fo-field-wrp-label span,
        body:has(.ng-sales-target-form-page) label {
            color: #4b3525 !important;
            font-size: 12px !important;
            font-weight: 950 !important;
        }

        body:has(.ng-sales-target-form-page) .fi-btn {
            border-radius: 14px !important;
            font-weight: 900 !important;
        }

        body:has(.ng-sales-target-form-page) .fi-btn-color-primary,
        body:has(.ng-sales-target-form-page) .fi-btn-color-warning {
            background: linear-gradient(135deg, #ff9d18, #ee6500) !important;
            box-shadow: 0 12px 22px rgba(238, 101, 0, .22) !important;
        }

        @media (max-width: 1500px) {
            .ng-sales-target-form-page [style*="grid-template-columns: minmax(0, 1.35fr)"] {
                grid-template-columns: 1fr !important;
            }
        }

        @media (max-width: 900px) {
            .ng-sales-target-form-page {
                padding: 14px !important;
            }
        }
        /* =========================================================
   FINAL SIDEBAR EFFECT SYNC - FINANCE PAGES
   Bikin sidebar halaman Keuangan sama rasa/effect dengan
   Dashboard Admin dan halaman resource lain.
   Tidak sentuh theme.css.
========================================================= */

body:has(.ng-finance-dashboard) .fi-sidebar,
body:has(.ng-operational-page) .fi-sidebar,
body:has(.ng-operational-form-page) .fi-sidebar,
body:has(.ng-sales-target-page) .fi-sidebar,
body:has(.ng-sales-target-form-page) .fi-sidebar {
    background: rgba(255, 250, 242, .50) !important;
    border-right: 1px solid rgba(255, 255, 255, .48) !important;
    box-shadow: 18px 0 55px rgba(137, 78, 26, .10) !important;
    backdrop-filter: blur(16px) !important;
    -webkit-backdrop-filter: blur(16px) !important;
}

body:has(.ng-finance-dashboard) .fi-sidebar-nav,
body:has(.ng-operational-page) .fi-sidebar-nav,
body:has(.ng-operational-form-page) .fi-sidebar-nav,
body:has(.ng-sales-target-page) .fi-sidebar-nav,
body:has(.ng-sales-target-form-page) .fi-sidebar-nav {
    padding: 18px 14px !important;
}

body:has(.ng-finance-dashboard) .fi-sidebar-item a,
body:has(.ng-operational-page) .fi-sidebar-item a,
body:has(.ng-operational-form-page) .fi-sidebar-item a,
body:has(.ng-sales-target-page) .fi-sidebar-item a,
body:has(.ng-sales-target-form-page) .fi-sidebar-item a {
    border-radius: 14px !important;
    color: #6f5844 !important;
    transition: .2s ease !important;
}

body:has(.ng-finance-dashboard) .fi-sidebar-item-active a,
body:has(.ng-finance-dashboard) .fi-sidebar-item a:hover,
body:has(.ng-operational-page) .fi-sidebar-item-active a,
body:has(.ng-operational-page) .fi-sidebar-item a:hover,
body:has(.ng-operational-form-page) .fi-sidebar-item-active a,
body:has(.ng-operational-form-page) .fi-sidebar-item a:hover,
body:has(.ng-sales-target-page) .fi-sidebar-item-active a,
body:has(.ng-sales-target-page) .fi-sidebar-item a:hover,
body:has(.ng-sales-target-form-page) .fi-sidebar-item-active a,
body:has(.ng-sales-target-form-page) .fi-sidebar-item a:hover {
    background: linear-gradient(135deg, #ff9500, #f26a00) !important;
    color: #fff !important;
    box-shadow: 0 14px 24px rgba(242, 106, 0, .24) !important;
}

body:has(.ng-finance-dashboard) .fi-sidebar-item-active svg,
body:has(.ng-finance-dashboard) .fi-sidebar-item a:hover svg,
body:has(.ng-operational-page) .fi-sidebar-item-active svg,
body:has(.ng-operational-page) .fi-sidebar-item a:hover svg,
body:has(.ng-operational-form-page) .fi-sidebar-item-active svg,
body:has(.ng-operational-form-page) .fi-sidebar-item a:hover svg,
body:has(.ng-sales-target-page) .fi-sidebar-item-active svg,
body:has(.ng-sales-target-page) .fi-sidebar-item a:hover svg,
body:has(.ng-sales-target-form-page) .fi-sidebar-item-active svg,
body:has(.ng-sales-target-form-page) .fi-sidebar-item a:hover svg {
    color: #fff !important;
}

body:has(.ng-finance-dashboard) .fi-sidebar-item-active span,
body:has(.ng-finance-dashboard) .fi-sidebar-item a:hover span,
body:has(.ng-operational-page) .fi-sidebar-item-active span,
body:has(.ng-operational-page) .fi-sidebar-item a:hover span,
body:has(.ng-operational-form-page) .fi-sidebar-item-active span,
body:has(.ng-operational-form-page) .fi-sidebar-item a:hover span,
body:has(.ng-sales-target-page) .fi-sidebar-item-active span,
body:has(.ng-sales-target-page) .fi-sidebar-item a:hover span,
body:has(.ng-sales-target-form-page) .fi-sidebar-item-active span,
body:has(.ng-sales-target-form-page) .fi-sidebar-item a:hover span {
    color: #fff !important;
}

        /* FIX DATEPICKER BULAN TARGET - JANGAN TERTIMPA FORM LAIN */
        body:has(.ng-sales-target-form-page),
        body:has(.ng-sales-target-form-page) .fi-main,
        body:has(.ng-sales-target-form-page) .fi-main-ctn,
        body:has(.ng-sales-target-form-page) .fi-page,
        body:has(.ng-sales-target-form-page) .fi-page-content,
        body:has(.ng-sales-target-form-page) form,
        body:has(.ng-sales-target-form-page) .fi-section,
        body:has(.ng-sales-target-form-page) .fi-section-content,
        body:has(.ng-sales-target-form-page) .fi-fo-component-ctn,
        body:has(.ng-sales-target-form-page) .fi-fo-field-wrp {
            overflow: visible !important;
        }

        /*
            Penting:
            Jangan semua input diberi z-index tinggi.
            Kalau semua input tinggi, kalender malah kalah dan terlihat tertimpa field lain.
        */
        body:has(.ng-sales-target-form-page) .fi-input-wrp,
        body:has(.ng-sales-target-form-page) .fi-select-input,
        body:has(.ng-sales-target-form-page) .fi-textarea,
        body:has(.ng-sales-target-form-page) input,
        body:has(.ng-sales-target-form-page) textarea {
            position: relative !important;
            z-index: 1 !important;
        }

        body:has(.ng-sales-target-form-page) .flatpickr-calendar,
        body:has(.ng-sales-target-form-page) .flatpickr-calendar.open,
        body:has(.ng-sales-target-form-page) .flatpickr-calendar.animate.open,
        body:has(.ng-sales-target-form-page) .fi-date-time-picker-panel,
        body:has(.ng-sales-target-form-page) .fi-dropdown-panel,
        body:has(.ng-sales-target-form-page) .fi-popover,
        body:has(.ng-sales-target-form-page) [role="dialog"],
        body:has(.ng-sales-target-form-page) [data-floating-ui-portal] {
            z-index: 999999 !important;
        }

        body:has(.ng-sales-target-form-page) .flatpickr-calendar {
            isolation: isolate !important;
            overflow: hidden !important;
            border-radius: 16px !important;
            border: 1px solid rgba(255, 255, 255, .72) !important;
            background: rgba(255, 255, 255, .96) !important;
            box-shadow:
                0 24px 56px rgba(72, 42, 18, .20),
                0 0 0 1px rgba(255, 255, 255, .46) inset !important;
            backdrop-filter: blur(16px) !important;
            -webkit-backdrop-filter: blur(16px) !important;
        }

        body:has(.ng-sales-target-form-page) .flatpickr-calendar * {
            z-index: auto !important;
        }

        body:has(.ng-sales-target-form-page) .flatpickr-calendar .flatpickr-day,
        body:has(.ng-sales-target-form-page) .flatpickr-calendar .flatpickr-weekday,
        body:has(.ng-sales-target-form-page) .flatpickr-calendar .cur-month,
        body:has(.ng-sales-target-form-page) .flatpickr-calendar .numInputWrapper {
            color: #3b2a1c !important;
        }

        body:has(.ng-sales-target-form-page) .flatpickr-calendar .flatpickr-day.selected,
        body:has(.ng-sales-target-form-page) .flatpickr-calendar .flatpickr-day.startRange,
        body:has(.ng-sales-target-form-page) .flatpickr-calendar .flatpickr-day.endRange {
            color: #fff !important;
            border-color: #f97316 !important;
            background: #f97316 !important;
        }

        body:has(.ng-sales-target-form-page) .flatpickr-calendar .flatpickr-day:hover {
            border-color: rgba(249, 115, 22, .24) !important;
            background: rgba(249, 115, 22, .12) !important;
        }

    </style>
</x-filament-widgets::widget>