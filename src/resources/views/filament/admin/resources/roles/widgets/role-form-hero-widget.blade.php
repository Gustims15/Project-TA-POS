@php
    $cards = [
        [
            'label' => 'Total Roles',
            'value' => number_format((int) ($stats['total_roles'] ?? 0), 0, ',', '.'),
            'caption' => 'Semua role sistem',
            'icon' => '▣',
            'color' => '#f97316',
        ],
        [
            'label' => 'Total Permissions',
            'value' => number_format((int) ($stats['total_permissions'] ?? 0), 0, ',', '.'),
            'caption' => 'Hak akses tersedia',
            'icon' => '✓',
            'color' => '#10b981',
        ],
        [
            'label' => 'Guard Web',
            'value' => number_format((int) ($stats['web_roles'] ?? 0), 0, ',', '.'),
            'caption' => 'Role guard web',
            'icon' => '◇',
            'color' => '#3b82f6',
        ],
    ];
@endphp

<x-filament-widgets::widget>
    <div class="ng-role-form-page">
        <section class="ng-role-form-hero-grid">
            <article class="ng-widget-card ng-role-form-hero-card">
                <div class="ng-widget-head">
                    <div>

                        <h1>{{ $title }}</h1>

                        <p>
                            {{ $description }}
                        </p>
                    </div>
                </div>
            </article>

            <article class="ng-widget-card ng-role-form-highlight-card">
                <div class="ng-highlight-info">
                    <span>Total Permissions</span>

                    <strong>
                        {{ number_format((int) ($stats['total_permissions'] ?? 0), 0, ',', '.') }}
                    </strong>

                    <small>
                        {{ number_format((int) ($stats['total_roles'] ?? 0), 0, ',', '.') }}
                        role sistem •
                        {{ number_format((int) ($stats['web_roles'] ?? 0), 0, ',', '.') }}
                        guard web
                    </small>
                </div>

                <div class="ng-highlight-actions">
                    <a href="{{ $backUrl }}" class="ng-primary-button">
                        ← Kembali
                    </a>
                </div>
            </article>
        </section>

        <section class="ng-kpi-grid ng-role-form-kpi-grid">
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
    </div>

    <style>
        html,
        body {
            overflow-x: hidden !important;
        }

        body:has(.ng-role-form-page) {
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

        body:has(.ng-role-form-page) .fi-page-content {
            gap: 0 !important;
            row-gap: 0 !important;
        }

        body:has(.ng-role-form-page) .fi-wi,
        body:has(.ng-role-form-page) .fi-wi-widget,
        body:has(.ng-role-form-page) .fi-wi-widget-content,
        body:has(.ng-role-form-page) .fi-wi-widgets,
        body:has(.ng-role-form-page) .fi-wi-widgets > * {
            margin: 0 !important;
            padding: 0 !important;
            background: transparent !important;
            border: none !important;
            box-shadow: none !important;
        }

        .ng-role-form-page {
            width: 100% !important;
            max-width: 100% !important;
            padding: 24px 24px 10px !important;
            overflow: hidden !important;
            font-family: Inter, Poppins, ui-sans-serif, system-ui, -apple-system, BlinkMacSystemFont, "Segoe UI", sans-serif;
            color: #24180f;
        }

        .ng-role-form-page * {
            box-sizing: border-box;
        }

        .ng-role-form-hero-grid {
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

        .ng-role-form-hero-card,
        .ng-role-form-highlight-card {
            min-height: 126px;
        }

        .ng-role-form-hero-card {
            display: flex;
            align-items: center;
        }

        .ng-role-form-highlight-card {
            display: flex;
            align-items: center;
            justify-content: space-between;
            gap: 16px;
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
            max-width: 780px;
            margin: 8px 0 0;
            color: #765d45;
            font-size: 13px;
            line-height: 1.55;
            font-weight: 700;
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
            line-height: 1.35;
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

        .ng-primary-button {
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
            transform: translateY(-1px);
            box-shadow: 0 18px 32px rgba(238, 101, 0, .30);
        }

        .ng-kpi-grid {
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
        | ROLE FORM PANEL
        |--------------------------------------------------------------------------
        */

        body:has(.ng-role-form-page) .fi-page-content > form {
            margin-top: 0 !important;
        }

        body:has(.ng-role-form-page) form,
        body:has(.ng-role-form-page) .fi-form,
        body:has(.ng-role-form-page) .fi-sc {
            width: calc(100% - 48px) !important;
            max-width: calc(100% - 48px) !important;
            margin-left: 24px !important;
            margin-right: 24px !important;
            background: transparent !important;
        }

        body:has(.ng-role-form-page) .fi-section,
        body:has(.ng-role-form-page) .fi-sc-section {
            width: 100% !important;
            max-width: 100% !important;
            margin-left: 0 !important;
            margin-right: 0 !important;
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
        }

        body:has(.ng-role-form-page) .fi-section + .fi-section,
        body:has(.ng-role-form-page) .fi-sc-section + .fi-sc-section {
            margin-top: 14px !important;
        }

        body:has(.ng-role-form-page) .fi-sc,
        body:has(.ng-role-form-page) .fi-fo,
        body:has(.ng-role-form-page) .fi-fo-component-ctn,
        body:has(.ng-role-form-page) .fi-section-content,
        body:has(.ng-role-form-page) .fi-sc-section-content {
            background: transparent !important;
            box-shadow: none !important;
            border: none !important;
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
        body:has(.ng-role-form-page) .fi-fo-field-wrp-label,
        body:has(.ng-role-form-page) label {
            color: #4b3525 !important;
            font-size: 12px !important;
            font-weight: 950 !important;
        }

        body:has(.ng-role-form-page) .fi-input-wrp,
        body:has(.ng-role-form-page) .fi-select-input,
        body:has(.ng-role-form-page) .fi-textarea {
            width: 100% !important;
            min-height: 44px !important;
            border-radius: 16px !important;
            background: rgba(255, 255, 255, .30) !important;
            border-color: rgba(255, 255, 255, .44) !important;
            box-shadow:
                inset 0 1px 0 rgba(255, 255, 255, .40),
                0 10px 26px rgba(101, 58, 21, .05) !important;
            backdrop-filter: blur(10px) !important;
            -webkit-backdrop-filter: blur(10px) !important;
        }

        body:has(.ng-role-form-page) .fi-input,
        body:has(.ng-role-form-page) .fi-select-input,
        body:has(.ng-role-form-page) textarea {
            color: #24180f !important;
            font-weight: 750 !important;
        }

        body:has(.ng-role-form-page) .fi-input::placeholder,
        body:has(.ng-role-form-page) textarea::placeholder {
            color: rgba(111, 88, 68, .62) !important;
        }

        body:has(.ng-role-form-page) .fi-fo-field-wrp-helper-text {
            color: #8b7057 !important;
            font-size: 12px !important;
            font-weight: 700 !important;
        }

        /*
        |--------------------------------------------------------------------------
        | ROLE PERMISSION TABS / FIELDSETS
        |--------------------------------------------------------------------------
        */

        body:has(.ng-role-form-page) .fi-tabs,
        body:has(.ng-role-form-page) .fi-sc-tabs,
        body:has(.ng-role-form-page) .fi-fo-tabs {
            width: 100% !important;
            max-width: 100% !important;
            margin-top: 14px !important;
            padding: 10px 12px !important;
            border-radius: 24px !important;
            border: 1px solid rgba(255, 255, 255, .50) !important;
            background:
                linear-gradient(145deg, rgba(255, 255, 255, .30), rgba(255, 246, 231, .16)),
                radial-gradient(circle at 100% 0%, rgba(255, 153, 30, .12), transparent 38%) !important;
            box-shadow:
                0 18px 46px rgba(101, 58, 21, .09),
                inset 0 1px 0 rgba(255, 255, 255, .42) !important;
            backdrop-filter: blur(13px) !important;
            -webkit-backdrop-filter: blur(13px) !important;
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

        body:has(.ng-role-form-page) .fi-badge {
            border-radius: 9px !important;
            background: linear-gradient(135deg, #ff9d18, #ee6500) !important;
            color: #fff !important;
            font-weight: 950 !important;
        }

        body:has(.ng-role-form-page) fieldset,
        body:has(.ng-role-form-page) .fi-fieldset,
        body:has(.ng-role-form-page) .fi-fo-fieldset,
        body:has(.ng-role-form-page) .fi-sc-fieldset {
            width: 100% !important;
            max-width: 100% !important;
            margin: 0 !important;
            overflow: hidden !important;
            border-radius: 22px !important;
            border: 1px solid rgba(255, 255, 255, .46) !important;
            background: rgba(255, 247, 235, .16) !important;
            box-shadow:
                0 16px 38px rgba(101, 58, 21, .08),
                inset 0 1px 0 rgba(255, 255, 255, .36) !important;
            backdrop-filter: blur(12px) !important;
            -webkit-backdrop-filter: blur(12px) !important;
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

        body:has(.ng-role-form-page) .fi-form-actions,
        body:has(.ng-role-form-page) .fi-ac {
            width: calc(100% - 48px) !important;
            max-width: calc(100% - 48px) !important;
            margin-left: 24px !important;
            margin-right: 24px !important;
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

        body:has(.ng-role-form-page) .fi-btn-color-primary,
        body:has(.ng-role-form-page) .fi-btn-color-warning {
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

        /*
        |--------------------------------------------------------------------------
        | SIDEBAR EFFECT SYNC
        |--------------------------------------------------------------------------
        */

        body:has(.ng-role-form-page) .fi-sidebar {
            background: rgba(255, 250, 242, .50) !important;
            border-right: 1px solid rgba(255, 255, 255, .48) !important;
            box-shadow: 18px 0 55px rgba(137, 78, 26, .10) !important;
            backdrop-filter: blur(16px) !important;
            -webkit-backdrop-filter: blur(16px) !important;
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

        body:has(.ng-role-form-page) .fi-sidebar-item-active svg,
        body:has(.ng-role-form-page) .fi-sidebar-item a:hover svg,
        body:has(.ng-role-form-page) .fi-sidebar-item-active span,
        body:has(.ng-role-form-page) .fi-sidebar-item a:hover span {
            color: #fff !important;
        }





        /*
        |--------------------------------------------------------------------------
        | FINAL CLEAN ALIGN - ROLE FORM PAGE
        |--------------------------------------------------------------------------
        | Fix final:
        | 1. Semua kotak mengikuti lebar area atas.
        | 2. Tidak pakai transform translateX supaya tulisan tidak kepotong.
        | 3. Header, form field, tabs Resources/Pages/Widgets, dan permission card rapi.
        */

        body:has(.ng-role-form-page) .fi-page-content {
            padding: 0 !important;
            overflow-x: hidden !important;
        }

        body:has(.ng-role-form-page) .ng-role-form-page {
            width: 100% !important;
            max-width: 100% !important;
            padding: 24px 24px 10px !important;
        }

        body:has(.ng-role-form-page) .ng-role-form-hero-grid,
        body:has(.ng-role-form-page) .ng-role-form-kpi-grid {
            width: 100% !important;
            max-width: 100% !important;
            margin-left: 0 !important;
            margin-right: 0 !important;
        }

        body:has(.ng-role-form-page) .ng-role-form-hero-grid,
        body:has(.ng-role-form-page) .ng-role-form-kpi-grid {
            align-items: stretch !important;
        }

        body:has(.ng-role-form-page) .ng-role-form-hero-grid > *,
        body:has(.ng-role-form-page) .ng-role-form-kpi-grid > * {
            height: 100% !important;
            min-width: 0 !important;
        }

        body:has(.ng-role-form-page) .fi-page-content > form,
        body:has(.ng-role-form-page) .fi-page-content > .fi-form,
        body:has(.ng-role-form-page) .fi-page-content > .fi-sc,
        body:has(.ng-role-form-page) form,
        body:has(.ng-role-form-page) .fi-form,
        body:has(.ng-role-form-page) .fi-sc {
            width: calc(100% - 48px) !important;
            max-width: calc(100% - 48px) !important;
            margin-left: 24px !important;
            margin-right: 24px !important;
            margin-top: 0 !important;
            background: transparent !important;
            overflow: visible !important;
        }

        body:has(.ng-role-form-page) form > *,
        body:has(.ng-role-form-page) .fi-form > *,
        body:has(.ng-role-form-page) .fi-sc > *,
        body:has(.ng-role-form-page) .fi-fo,
        body:has(.ng-role-form-page) .fi-fo > *,
        body:has(.ng-role-form-page) .fi-fo-component-ctn,
        body:has(.ng-role-form-page) .fi-fo-component-ctn > *,
        body:has(.ng-role-form-page) .fi-sc-component-ctn,
        body:has(.ng-role-form-page) .fi-sc-component-ctn > *,
        body:has(.ng-role-form-page) .fi-grid {
            width: 100% !important;
            max-width: 100% !important;
            margin-left: 0 !important;
            margin-right: 0 !important;
            transform: none !important;
        }

        body:has(.ng-role-form-page) .max-w-7xl,
        body:has(.ng-role-form-page) .max-w-6xl,
        body:has(.ng-role-form-page) .max-w-5xl,
        body:has(.ng-role-form-page) .max-w-4xl,
        body:has(.ng-role-form-page) .max-w-3xl,
        body:has(.ng-role-form-page) .max-w-2xl,
        body:has(.ng-role-form-page) .max-w-xl {
            max-width: 100% !important;
        }

        body:has(.ng-role-form-page) .mx-auto {
            margin-left: 0 !important;
            margin-right: 0 !important;
        }

        body:has(.ng-role-form-page) .fi-section,
        body:has(.ng-role-form-page) .fi-sc-section,
        body:has(.ng-role-form-page) .fi-tabs,
        body:has(.ng-role-form-page) .fi-sc-tabs,
        body:has(.ng-role-form-page) .fi-fo-tabs {
            width: 100% !important;
            max-width: 100% !important;
            margin-left: 0 !important;
            margin-right: 0 !important;
            transform: none !important;
            overflow: hidden !important;
        }

        body:has(.ng-role-form-page) .fi-section,
        body:has(.ng-role-form-page) .fi-sc-section {
            margin-top: 0 !important;
            margin-bottom: 16px !important;
        }

        body:has(.ng-role-form-page) .fi-section-header,
        body:has(.ng-role-form-page) .fi-sc-section-header {
            padding: 18px 24px !important;
        }

        body:has(.ng-role-form-page) .fi-section-content,
        body:has(.ng-role-form-page) .fi-sc-section-content {
            padding: 22px 24px !important;
        }

        body:has(.ng-role-form-page) .fi-tabs,
        body:has(.ng-role-form-page) .fi-sc-tabs,
        body:has(.ng-role-form-page) .fi-fo-tabs {
            margin-top: 18px !important;
            margin-bottom: 16px !important;
            padding: 12px 16px !important;
        }

        body:has(.ng-role-form-page) .fi-tabs-header,
        body:has(.ng-role-form-page) .fi-tabs-nav,
        body:has(.ng-role-form-page) .fi-sc-tabs-header,
        body:has(.ng-role-form-page) .fi-fo-tabs-header {
            width: 100% !important;
            max-width: 100% !important;
            padding-left: 0 !important;
            padding-right: 0 !important;
            overflow: visible !important;
        }

        body:has(.ng-role-form-page) .fi-tabs-tab,
        body:has(.ng-role-form-page) .fi-sc-tabs-tab,
        body:has(.ng-role-form-page) .fi-fo-tabs-tab {
            white-space: nowrap !important;
            overflow: visible !important;
        }

        body:has(.ng-role-form-page) .fi-tabs-panel,
        body:has(.ng-role-form-page) .fi-tabs-content,
        body:has(.ng-role-form-page) .fi-sc-tabs-tab-panel,
        body:has(.ng-role-form-page) .fi-fo-tabs-tab-panel {
            width: 100% !important;
            max-width: 100% !important;
            margin-left: 0 !important;
            margin-right: 0 !important;
            padding: 18px 0 0 !important;
            transform: none !important;
            overflow: visible !important;
        }

        body:has(.ng-role-form-page) fieldset,
        body:has(.ng-role-form-page) .fi-fieldset,
        body:has(.ng-role-form-page) .fi-fo-fieldset,
        body:has(.ng-role-form-page) .fi-sc-fieldset {
            width: 100% !important;
            max-width: 100% !important;
            margin: 0 !important;
            transform: none !important;
            overflow: hidden !important;
        }

        body:has(.ng-role-form-page) fieldset > div,
        body:has(.ng-role-form-page) .fi-fieldset > div,
        body:has(.ng-role-form-page) .fi-fo-fieldset > div,
        body:has(.ng-role-form-page) .fi-sc-fieldset > div {
            padding-left: 18px !important;
            padding-right: 18px !important;
        }

        body:has(.ng-role-form-page) .fi-form-actions,
        body:has(.ng-role-form-page) .fi-ac {
            width: calc(100% - 48px) !important;
            max-width: calc(100% - 48px) !important;
            margin-left: 24px !important;
            margin-right: 24px !important;
            justify-content: flex-start !important;
            transform: none !important;
        }

        @media (max-width: 1100px) {
            body:has(.ng-role-form-page) .fi-page-content > form,
            body:has(.ng-role-form-page) .fi-page-content > .fi-form,
            body:has(.ng-role-form-page) .fi-page-content > .fi-sc,
            body:has(.ng-role-form-page) form,
            body:has(.ng-role-form-page) .fi-form,
            body:has(.ng-role-form-page) .fi-sc,
            body:has(.ng-role-form-page) .fi-form-actions,
            body:has(.ng-role-form-page) .fi-ac {
                width: calc(100% - 36px) !important;
                max-width: calc(100% - 36px) !important;
                margin-left: 18px !important;
                margin-right: 18px !important;
            }

            body:has(.ng-role-form-page) .fi-section-header,
            body:has(.ng-role-form-page) .fi-sc-section-header,
            body:has(.ng-role-form-page) .fi-section-content,
            body:has(.ng-role-form-page) .fi-sc-section-content {
                padding-left: 18px !important;
                padding-right: 18px !important;
            }
        }

        @media (max-width: 700px) {
            body:has(.ng-role-form-page) .fi-page-content > form,
            body:has(.ng-role-form-page) .fi-page-content > .fi-form,
            body:has(.ng-role-form-page) .fi-page-content > .fi-sc,
            body:has(.ng-role-form-page) form,
            body:has(.ng-role-form-page) .fi-form,
            body:has(.ng-role-form-page) .fi-sc,
            body:has(.ng-role-form-page) .fi-form-actions,
            body:has(.ng-role-form-page) .fi-ac {
                width: calc(100% - 28px) !important;
                max-width: calc(100% - 28px) !important;
                margin-left: 14px !important;
                margin-right: 14px !important;
            }

            body:has(.ng-role-form-page) .fi-section-header,
            body:has(.ng-role-form-page) .fi-sc-section-header,
            body:has(.ng-role-form-page) .fi-section-content,
            body:has(.ng-role-form-page) .fi-sc-section-content {
                padding-left: 16px !important;
                padding-right: 16px !important;
            }
        }


        @media (max-width: 1500px) {
            .ng-role-form-hero-grid {
                grid-template-columns: 1fr;
            }

            .ng-kpi-grid {
                grid-template-columns: repeat(3, minmax(0, 1fr));
            }
        }

        @media (max-width: 1100px) {
            .ng-role-form-page {
                padding: 18px 18px 10px !important;
            }

            .ng-role-form-highlight-card {
                align-items: flex-start;
                flex-direction: column;
            }

            .ng-highlight-actions {
                justify-content: flex-start;
            }

            body:has(.ng-role-form-page) form,
            body:has(.ng-role-form-page) .fi-form,
            body:has(.ng-role-form-page) .fi-sc,
            body:has(.ng-role-form-page) .fi-form-actions,
            body:has(.ng-role-form-page) .fi-ac {
                width: calc(100% - 36px) !important;
                max-width: calc(100% - 36px) !important;
                margin-left: 18px !important;
                margin-right: 18px !important;
            }
        }

        @media (max-width: 700px) {
            .ng-kpi-grid {
                grid-template-columns: 1fr;
            }

            .ng-role-form-page {
                padding: 14px 14px 8px !important;
            }

            .ng-widget-head h1 {
                font-size: 26px;
            }

            .ng-widget-card {
                padding: 16px;
                border-radius: 22px;
            }

            body:has(.ng-role-form-page) form,
            body:has(.ng-role-form-page) .fi-form,
            body:has(.ng-role-form-page) .fi-sc,
            body:has(.ng-role-form-page) .fi-form-actions,
            body:has(.ng-role-form-page) .fi-ac {
                width: calc(100% - 28px) !important;
                max-width: calc(100% - 28px) !important;
                margin-left: 14px !important;
                margin-right: 14px !important;
            }
        }
    </style>
</x-filament-widgets::widget>
