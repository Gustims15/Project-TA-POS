<x-filament-widgets::widget>
    <div class="ng-role-form-page">
        <section class="ng-role-form-hero">
            <div class="ng-role-form-title">
                <div>
                    <h1>{{ $title }}</h1>
                    <p>{{ $description }}</p>
                </div>

                <a href="{{ $backUrl }}" class="ng-role-back-btn">
                    ← Kembali
                </a>
            </div>
        </section>

        <section class="ng-role-form-stats">
            <article>
                <span>Total Roles</span>
                <strong>{{ number_format($stats['total_roles'], 0, ',', '.') }}</strong>
                <p>Semua role sistem</p>
            </article>

            <article>
                <span>Total Permissions</span>
                <strong>{{ number_format($stats['total_permissions'], 0, ',', '.') }}</strong>
                <p>Hak akses tersedia</p>
            </article>

            <article>
                <span>Guard Web</span>
                <strong>{{ number_format($stats['web_roles'], 0, ',', '.') }}</strong>
                <p>Role guard web</p>
            </article>
        </section>
    </div>

    <style>
        html,
        body {
            overflow-x: hidden !important;
        }

        body:has(.ng-role-form-page) {
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

        body:has(.ng-role-form-page) .fi-main,
        body:has(.ng-role-form-page) .fi-main-ctn,
        body:has(.ng-role-form-page) .fi-page,
        body:has(.ng-role-form-page) .fi-page-content {
            width: 100% !important;
            max-width: 100% !important;
            background: transparent !important;
            overflow-x: hidden !important;
        }

        body:has(.ng-role-form-page) .fi-page {
            padding: 0 !important;
        }

        body:has(.ng-role-form-page) .fi-page-header {
            display: none !important;
        }

        body:has(.ng-role-form-page) .fi-main {
            padding: 0 !important;
        }

        body:has(.ng-role-form-page) .fi-sidebar {
            background: rgba(255, 250, 242, .50) !important;
            border-right: 1px solid rgba(255, 255, 255, .48) !important;
            box-shadow: 18px 0 55px rgba(137, 78, 26, .10) !important;
            backdrop-filter: blur(16px) !important;
        }

        body:has(.ng-role-form-page) .fi-sidebar-nav {
            padding: 18px 14px !important;
        }

        body:has(.ng-role-form-page) .fi-sidebar-item a {
            border-radius: 14px !important;
            color: #6f5844 !important;
            transition: .2s ease !important;
        }

        body:has(.ng-role-form-page) .fi-sidebar-item-active a,
        body:has(.ng-role-form-page) .fi-sidebar-item a:hover {
            background: linear-gradient(135deg, #ff9500, #f26a00) !important;
            color: #fff !important;
            box-shadow: 0 14px 24px rgba(242, 106, 0, .24) !important;
        }

        body:has(.ng-role-form-page) .fi-wi-widget {
            background: transparent !important;
            box-shadow: none !important;
            border: none !important;
        }

        body:has(.ng-role-form-page) .fi-wi-widget-content {
            padding: 0 !important;
        }

        body:has(.ng-role-form-page) .fi-page-content {
            gap: 0 !important;
            row-gap: 0 !important;
        }

        .ng-role-form-page {
            width: 100%;
            padding: 18px 18px 0;
            font-family: Inter, Poppins, ui-sans-serif, system-ui, -apple-system, BlinkMacSystemFont, "Segoe UI", sans-serif;
            color: #24180f;
        }

        .ng-role-form-page * {
            box-sizing: border-box;
        }

        .ng-role-form-hero,
        .ng-role-form-stats,
        body:has(.ng-role-form-page) form,
        body:has(.ng-role-form-page) .fi-form,
        body:has(.ng-role-form-page) .fi-form-actions,
        body:has(.ng-role-form-page) .fi-ac {
            width: min(calc(100% - 36px), 1180px) !important;
            max-width: 1180px !important;
            margin-left: 18px !important;
            margin-right: auto !important;
        }

        .ng-role-form-hero {
            margin-bottom: 12px;
        }

        .ng-role-form-title,
        .ng-role-form-stats article,
        body:has(.ng-role-form-page) .fi-section,
        body:has(.ng-role-form-page) .fi-sc-section {
            position: relative;
            overflow: hidden;
            border: 1px solid rgba(255, 255, 255, .56) !important;
            background: rgba(255, 247, 235, .18) !important;
            box-shadow:
                0 20px 48px rgba(101, 58, 21, .10),
                0 0 0 1px rgba(255, 255, 255, .10) inset,
                inset 0 1px 0 rgba(255, 255, 255, .56) !important;
            backdrop-filter: blur(13px) !important;
        }

        .ng-role-form-title {
            min-height: 126px;
            display: flex;
            align-items: center;
            justify-content: space-between;
            gap: 20px;
            padding: 20px 22px;
            border-radius: 24px;
        }

        .ng-role-form-title > div {
            min-width: 0;
        }

        .ng-role-form-title span {
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

        .ng-role-form-title h1 {
            margin: 0;
            color: #21160d;
            font-size: 30px;
            line-height: 1.05;
            font-weight: 950;
            letter-spacing: -.04em;
        }

        .ng-role-form-title p {
            max-width: 780px;
            margin: 7px 0 0;
            color: #765d45;
            font-size: 12px;
            font-weight: 650;
            line-height: 1.5;
        }

        .ng-role-back-btn {
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

        .ng-role-form-stats {
            display: grid;
            grid-template-columns: repeat(3, minmax(0, 1fr));
            gap: 10px;
            margin-bottom: 12px;
        }

        .ng-role-form-stats article {
            min-height: 88px;
            padding: 15px 18px;
            border-radius: 20px;
        }

        .ng-role-form-stats span {
            display: block;
            color: #6f5946;
            font-size: 11px;
            font-weight: 900;
        }

        .ng-role-form-stats strong {
            display: block;
            margin-top: 6px;
            color: #23160d;
            font-size: 20px;
            line-height: 1.15;
            font-weight: 950;
            letter-spacing: -.03em;
        }

        .ng-role-form-stats p {
            margin: 6px 0 0;
            color: #6f5946;
            font-size: 10px;
            font-weight: 850;
        }

        body:has(.ng-role-form-page) .fi-section,
        body:has(.ng-role-form-page) .fi-sc-section {
            width: 100% !important;
            max-width: 100% !important;
            margin-left: 0 !important;
            margin-right: 0 !important;
            border-radius: 24px !important;
        }

        body:has(.ng-role-form-page) .fi-section + .fi-section,
        body:has(.ng-role-form-page) .fi-sc-section + .fi-sc-section {
            margin-top: 14px !important;
        }

        body:has(.ng-role-form-page) .fi-sc,
        body:has(.ng-role-form-page) .fi-fo,
        body:has(.ng-role-form-page) .fi-fo-component-ctn,
        body:has(.ng-role-form-page) fieldset {
            background: transparent !important;
            box-shadow: none !important;
            border-color: rgba(255, 255, 255, .30) !important;
        }

        body:has(.ng-role-form-page) .fi-section-header,
        body:has(.ng-role-form-page) .fi-sc-section-header {
            min-height: 58px !important;
            padding: 15px 20px !important;
            background: rgba(255, 247, 235, .10) !important;
            border-bottom: 1px solid rgba(114, 74, 41, .07) !important;
        }

        body:has(.ng-role-form-page) .fi-section-content,
        body:has(.ng-role-form-page) .fi-sc-section-content {
            padding: 20px !important;
        }

        body:has(.ng-role-form-page) .fi-section-header-heading,
        body:has(.ng-role-form-page) .fi-sc-section-header-heading {
            color: #25170d !important;
            font-size: 17px !important;
            font-weight: 950 !important;
            letter-spacing: -.03em !important;
        }

        body:has(.ng-role-form-page) .fi-section-header-description,
        body:has(.ng-role-form-page) .fi-sc-section-header-description {
            color: #7b624c !important;
            font-size: 12px !important;
            font-weight: 750 !important;
        }

        body:has(.ng-role-form-page) .fi-fo-field-wrp-label span,
        body:has(.ng-role-form-page) .fi-fo-field-wrp-label {
            color: #4b3525 !important;
            font-weight: 900 !important;
        }

        body:has(.ng-role-form-page) .fi-input-wrp,
        body:has(.ng-role-form-page) .fi-select-input {
            width: 100% !important;
            min-height: 46px !important;
            border-radius: 16px !important;
            background: rgba(255, 255, 255, .32) !important;
            border-color: rgba(255, 255, 255, .46) !important;
            box-shadow:
                inset 0 1px 0 rgba(255, 255, 255, .42),
                0 10px 26px rgba(101, 58, 21, .05) !important;
            backdrop-filter: blur(10px) !important;
        }

        body:has(.ng-role-form-page) .fi-input,
        body:has(.ng-role-form-page) .fi-select-input {
            color: #24180f !important;
            font-weight: 750 !important;
        }

        body:has(.ng-role-form-page) .fi-fo-field-wrp-helper-text {
            color: #8b7057 !important;
            font-size: 12px !important;
            font-weight: 700 !important;
        }

        body:has(.ng-role-form-page) .fi-checkbox-input,
        body:has(.ng-role-form-page) input[type="checkbox"] {
            border-radius: 6px !important;
            border-color: rgba(249, 115, 22, .42) !important;
            color: #f97316 !important;
        }

        body:has(.ng-role-form-page) .fi-form-actions,
        body:has(.ng-role-form-page) .fi-ac {
            margin-top: 14px !important;
            padding: 0 0 24px !important;
            display: flex !important;
            justify-content: flex-start !important;
            align-items: center !important;
            gap: 10px !important;
            background: transparent !important;
            border: none !important;
            box-shadow: none !important;
        }

        body:has(.ng-role-form-page) .fi-btn {
            min-height: 42px !important;
            border-radius: 14px !important;
            font-weight: 950 !important;
        }

        body:has(.ng-role-form-page) .fi-btn-color-primary {
            background: linear-gradient(135deg, #ff9d18, #ee6500) !important;
            box-shadow: 0 12px 22px rgba(238, 101, 0, .22) !important;
        }

        body:has(.ng-role-form-page) .fi-btn-color-gray {
            background: rgba(255, 255, 255, .42) !important;
            border: 1px solid rgba(255, 255, 255, .55) !important;
            color: #6f5844 !important;
        }

        body:has(.ng-role-form-page) .fi-btn-color-danger {
            box-shadow: 0 12px 22px rgba(239, 68, 68, .18) !important;
        }

        @media (max-width: 1300px) {
            .ng-role-form-hero,
            .ng-role-form-stats,
            body:has(.ng-role-form-page) form,
            body:has(.ng-role-form-page) .fi-form,
            body:has(.ng-role-form-page) .fi-form-actions,
            body:has(.ng-role-form-page) .fi-ac {
                width: calc(100% - 28px) !important;
                max-width: 100% !important;
                margin-left: 14px !important;
                margin-right: 14px !important;
            }
        }

        @media (max-width: 900px) {
            .ng-role-form-page {
                padding: 14px 0 0;
            }

            .ng-role-form-title {
                align-items: flex-start;
                flex-direction: column;
            }

            .ng-role-form-stats {
                grid-template-columns: 1fr;
            }
        }
            
        /* =========================================================
           FINAL FIX ROLE FORM CLEAN
           Rapihkan Informasi Role + Resources/Pages/Widgets
        ========================================================= */

        /* Widget atas tetap rapi dan jadi patokan kiri-kanan */
        .ng-role-form-page {
            width: 100% !important;
            padding: 18px 18px 0 !important;
        }

        .ng-role-form-hero,
        .ng-role-form-stats {
            width: 100% !important;
            max-width: none !important;
            margin-left: 0 !important;
            margin-right: 0 !important;
        }

        /* Form Role sejajar dengan widget atas */
        body:has(.ng-role-form-page) .fi-page-content > form,
        body:has(.ng-role-form-page) .fi-page-content > .fi-form,
        body:has(.ng-role-form-page) .fi-page-content > .fi-sc,
        body:has(.ng-role-form-page) .fi-page-content > div:has(form),
        body:has(.ng-role-form-page) .fi-page-content > div:has(.fi-section),
        body:has(.ng-role-form-page) .fi-page-content > div:has(.fi-sc-section),
        body:has(.ng-role-form-page) form,
        body:has(.ng-role-form-page) .fi-form,
        body:has(.ng-role-form-page) .fi-sc {
            width: calc(100% - 36px) !important;
            max-width: none !important;
            margin-left: 18px !important;
            margin-right: 18px !important;
        }

        /* Informasi Role full sejajar */
        body:has(.ng-role-form-page) .fi-section,
        body:has(.ng-role-form-page) .fi-sc-section {
            width: 100% !important;
            max-width: 100% !important;
            margin-left: 0 !important;
            margin-right: 0 !important;
            border-radius: 24px !important;
            border: 1px solid rgba(255, 255, 255, .56) !important;
            background: rgba(255, 247, 235, .18) !important;
            box-shadow:
                0 20px 48px rgba(101, 58, 21, .10),
                inset 0 1px 0 rgba(255, 255, 255, .56) !important;
            backdrop-filter: blur(13px) !important;
            overflow: hidden !important;
        }

        body:has(.ng-role-form-page) .fi-section-header,
        body:has(.ng-role-form-page) .fi-sc-section-header {
            min-height: 58px !important;
            padding: 15px 20px !important;
            background: rgba(255, 247, 235, .10) !important;
            border-bottom: 1px solid rgba(114, 74, 41, .07) !important;
        }

        body:has(.ng-role-form-page) .fi-section-content,
        body:has(.ng-role-form-page) .fi-sc-section-content {
            padding: 20px !important;
            background: transparent !important;
        }

        /* Resources / Pages / Widgets container */
        body:has(.ng-role-form-page) .fi-tabs,
        body:has(.ng-role-form-page) .fi-sc-tabs,
        body:has(.ng-role-form-page) .fi-fo-tabs {
            width: 100% !important;
            max-width: 100% !important;
            margin-top: 14px !important;
            padding: 10px 12px !important;
            border-radius: 24px !important;
            border: 1px solid rgba(255, 255, 255, .50) !important;
            background: rgba(255, 247, 235, .16) !important;
            box-shadow:
                0 18px 46px rgba(101, 58, 21, .09),
                inset 0 1px 0 rgba(255, 255, 255, .42) !important;
            backdrop-filter: blur(13px) !important;
            overflow: hidden !important;
        }

        body:has(.ng-role-form-page) .fi-tabs-panel,
        body:has(.ng-role-form-page) .fi-tabs-content,
        body:has(.ng-role-form-page) .fi-sc-tabs-tab-panel,
        body:has(.ng-role-form-page) .fi-fo-tabs-tab-panel {
            width: 100% !important;
            max-width: 100% !important;
            margin-left: 0 !important;
            margin-right: 0 !important;
            background: transparent !important;
            border: none !important;
            box-shadow: none !important;
        }

        body:has(.ng-role-form-page) .fi-tabs-tab,
        body:has(.ng-role-form-page) .fi-sc-tabs-tab,
        body:has(.ng-role-form-page) .fi-fo-tabs-tab {
            min-height: 38px !important;
            border-radius: 14px !important;
            color: #6f5844 !important;
            font-size: 13px !important;
            font-weight: 900 !important;
        }

        body:has(.ng-role-form-page) .fi-tabs-tab[aria-selected="true"],
        body:has(.ng-role-form-page) .fi-sc-tabs-tab[aria-selected="true"],
        body:has(.ng-role-form-page) .fi-fo-tabs-tab[aria-selected="true"] {
            color: #d95d00 !important;
            background: rgba(255, 255, 255, .30) !important;
            box-shadow: inset 0 1px 0 rgba(255, 255, 255, .48) !important;
        }

        /* Badge angka Resources, Pages, Widgets */
        body:has(.ng-role-form-page) .fi-badge {
            border-radius: 9px !important;
            background: linear-gradient(135deg, #ff9d18, #ee6500) !important;
            color: #fff !important;
            font-weight: 950 !important;
        }

        /* Permission card jangan putih solid */
        body:has(.ng-role-form-page) fieldset,
        body:has(.ng-role-form-page) .fi-fieldset,
        body:has(.ng-role-form-page) .fi-fo-fieldset,
        body:has(.ng-role-form-page) .fi-sc-fieldset,
        body:has(.ng-role-form-page) [class*="bg-white"] {
            border-radius: 22px !important;
            border: 1px solid rgba(255, 255, 255, .46) !important;
            background: rgba(255, 247, 235, .16) !important;
            box-shadow:
                0 16px 38px rgba(101, 58, 21, .08),
                inset 0 1px 0 rgba(255, 255, 255, .36) !important;
            backdrop-filter: blur(12px) !important;
        }

        body:has(.ng-role-form-page) fieldset,
        body:has(.ng-role-form-page) .fi-fieldset,
        body:has(.ng-role-form-page) .fi-fo-fieldset,
        body:has(.ng-role-form-page) .fi-sc-fieldset {
            width: 100% !important;
            max-width: 100% !important;
            margin: 0 !important;
            overflow: hidden !important;
        }

        body:has(.ng-role-form-page) fieldset legend,
        body:has(.ng-role-form-page) .fi-fieldset-legend,
        body:has(.ng-role-form-page) .fi-fo-fieldset-legend,
        body:has(.ng-role-form-page) .fi-sc-fieldset-legend {
            color: #24180f !important;
            font-size: 15px !important;
            font-weight: 950 !important;
        }

        body:has(.ng-role-form-page) .fi-grid,
        body:has(.ng-role-form-page) .fi-fo-component-ctn,
        body:has(.ng-role-form-page) .fi-sc-component-ctn,
        body:has(.ng-role-form-page) fieldset > div {
            background: transparent !important;
            box-shadow: none !important;
        }

        /* Checkbox permission lebih rapi */
        body:has(.ng-role-form-page) .fi-checkbox-input,
        body:has(.ng-role-form-page) input[type="checkbox"] {
            width: 18px !important;
            height: 18px !important;
            border-radius: 7px !important;
            border-color: rgba(249, 115, 22, .42) !important;
            background-color: rgba(255, 255, 255, .42) !important;
            color: #f97316 !important;
            box-shadow: 0 6px 14px rgba(101, 58, 21, .08) !important;
        }

        body:has(.ng-role-form-page) .fi-checkbox-input:checked,
        body:has(.ng-role-form-page) input[type="checkbox"]:checked {
            background-color: #f97316 !important;
            border-color: #f97316 !important;
        }

        body:has(.ng-role-form-page) .fi-checkbox-list-option-label,
        body:has(.ng-role-form-page) .fi-fo-checkbox-list-option-label,
        body:has(.ng-role-form-page) .fi-sc-checkbox-list-option-label {
            color: #342417 !important;
            font-size: 13px !important;
            font-weight: 850 !important;
        }

        /* Action button bawah ikut sejajar */
        body:has(.ng-role-form-page) .fi-form-actions,
        body:has(.ng-role-form-page) .fi-ac {
            width: calc(100% - 36px) !important;
            max-width: none !important;
            margin-left: 18px !important;
            margin-right: 18px !important;
            justify-content: flex-start !important;
            padding: 0 0 24px !important;
        }

        @media (max-width: 900px) {
            .ng-role-form-page {
                padding: 14px 14px 0 !important;
            }

            body:has(.ng-role-form-page) .fi-page-content > form,
            body:has(.ng-role-form-page) .fi-page-content > .fi-form,
            body:has(.ng-role-form-page) .fi-page-content > .fi-sc,
            body:has(.ng-role-form-page) .fi-page-content > div:has(form),
            body:has(.ng-role-form-page) .fi-page-content > div:has(.fi-section),
            body:has(.ng-role-form-page) .fi-page-content > div:has(.fi-sc-section),
            body:has(.ng-role-form-page) form,
            body:has(.ng-role-form-page) .fi-form,
            body:has(.ng-role-form-page) .fi-sc,
            body:has(.ng-role-form-page) .fi-form-actions,
            body:has(.ng-role-form-page) .fi-ac {
                width: 100% !important;
                margin-left: 0 !important;
                margin-right: 0 !important;
            }
        }

    </style>
</x-filament-widgets::widget>