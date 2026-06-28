<?php if (isset($component)) { $__componentOriginalb525200bfa976483b4eaa0b7685c6e24 = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginalb525200bfa976483b4eaa0b7685c6e24 = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'filament-widgets::components.widget','data' => []] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('filament-widgets::widget'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes([]); ?>
<?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::processComponentKey($component); ?>

    <div class="ng-operational-form-page">
        <section class="ng-op-form-hero-grid">
            <article class="ng-widget-card ng-op-form-hero-card">
                <div class="ng-widget-head">
                    <div>

                        <h1><?php echo e($title); ?></h1>

                        <p>
                            <?php echo e($description); ?>

                        </p>
                    </div>
                </div>
            </article>

            <article class="ng-widget-card ng-op-form-highlight-card">
                <div class="ng-highlight-info">
                    <span>Estimasi Biaya Bulan Aktif</span>

                    <strong>
                        <?php echo e($this->rupiah($stats['monthly_cost'] ?? 0)); ?>

                    </strong>

                    <small>
                        <?php echo e(number_format((int) ($stats['active_costs'] ?? 0), 0, ',', '.')); ?>

                        biaya aktif dari
                        <?php echo e(number_format((int) ($stats['total_costs'] ?? 0), 0, ',', '.')); ?>

                        total data
                    </small>
                </div>

                <div class="ng-highlight-actions">
                    <a href="<?php echo e($backUrl); ?>" class="ng-primary-button">
                        ← Kembali
                    </a>
                </div>
            </article>
        </section>
    </div>

    <style>
        html,
        body {
            overflow-x: hidden !important;
        }

        body:has(.ng-operational-form-page) {
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

        body:has(.ng-operational-form-page) .fi-main,
        body:has(.ng-operational-form-page) .fi-main-ctn,
        body:has(.ng-operational-form-page) .fi-page,
        body:has(.ng-operational-form-page) .fi-page-content {
            width: 100% !important;
            max-width: 100% !important;
            background: transparent !important;
            overflow-x: hidden !important;
        }

        body:has(.ng-operational-form-page) .fi-page {
            padding: 0 !important;
        }

        body:has(.ng-operational-form-page) .fi-page-header {
            display: none !important;
        }

        body:has(.ng-operational-form-page) .fi-main {
            padding: 0 !important;
        }

        body:has(.ng-operational-form-page) .fi-page-content {
            gap: 0 !important;
            row-gap: 0 !important;
        }

        body:has(.ng-operational-form-page) .fi-wi,
        body:has(.ng-operational-form-page) .fi-wi-widget,
        body:has(.ng-operational-form-page) .fi-wi-widget-content,
        body:has(.ng-operational-form-page) .fi-wi-widgets,
        body:has(.ng-operational-form-page) .fi-wi-widgets > * {
            margin: 0 !important;
            padding: 0 !important;
            background: transparent !important;
            border: none !important;
            box-shadow: none !important;
        }

        .ng-operational-form-page {
            width: 100% !important;
            max-width: 100% !important;
            padding: 24px 24px 10px !important;
            overflow: visible !important;
            font-family: Inter, Poppins, ui-sans-serif, system-ui, -apple-system, BlinkMacSystemFont, "Segoe UI", sans-serif;
            color: #24180f;
        }

        .ng-operational-form-page * {
            box-sizing: border-box;
        }

        .ng-op-form-hero-grid {
            display: grid;
            grid-template-columns: minmax(0, 1.45fr) minmax(360px, .55fr);
            gap: 16px;
            margin-bottom: 14px;
        }

        .ng-widget-card {
            position: relative;
            overflow: hidden;
            min-width: 0;
            border-radius: 24px;
            padding: 18px;
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

        .ng-widget-card::before {
            content: "";
            position: absolute;
            inset: 0;
            pointer-events: none;
            background:
                linear-gradient(120deg, rgba(255, 255, 255, .34), transparent 28%, transparent 70%, rgba(255, 255, 255, .16));
            opacity: .38;
        }

        .ng-op-form-hero-card,
        .ng-op-form-highlight-card {
            min-height: 126px;
        }

        .ng-op-form-hero-card {
            display: flex;
            align-items: center;
        }

        .ng-op-form-highlight-card {
            display: flex;
            align-items: center;
            justify-content: space-between;
            gap: 16px;
        }

        .ng-widget-head {
            position: relative;
            z-index: 2;
            display: flex;
            align-items: flex-start;
            justify-content: space-between;
            gap: 14px;
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
            max-width: 760px;
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

        /*
        |--------------------------------------------------------------------------
        | FORM PANEL - DISAMAKAN DENGAN RASA DASHBOARD KEUANGAN
        |--------------------------------------------------------------------------
        */

        body:has(.ng-operational-form-page) form,
        body:has(.ng-operational-form-page) .fi-section,
        body:has(.ng-operational-form-page) .fi-fo-component-ctn {
            background: transparent !important;
        }

        body:has(.ng-operational-form-page) .fi-page-content > form {
            margin-top: -16px !important;
        }

        body:has(.ng-operational-form-page) form .fi-section,
        body:has(.ng-operational-form-page) .fi-section {
            margin-left: 24px !important;
            margin-right: 24px !important;
            margin-top: 0 !important;
            width: calc(100% - 48px) !important;
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
            overflow: visible !important;
        }

        body:has(.ng-operational-form-page) .fi-section-content,
        body:has(.ng-operational-form-page) .fi-fo-component-ctn {
            background: transparent !important;
        }

        body:has(.ng-operational-form-page) .fi-input-wrp,
        body:has(.ng-operational-form-page) .fi-select-input,
        body:has(.ng-operational-form-page) .fi-textarea {
            min-height: 40px !important;
            border-radius: 16px !important;
            background: rgba(255, 255, 255, .28) !important;
            border-color: rgba(255, 255, 255, .42) !important;
            box-shadow: inset 0 1px 0 rgba(255, 255, 255, .36) !important;
            backdrop-filter: blur(10px) !important;
            -webkit-backdrop-filter: blur(10px) !important;
        }

        body:has(.ng-operational-form-page) .fi-input,
        body:has(.ng-operational-form-page) .fi-select-input,
        body:has(.ng-operational-form-page) textarea {
            color: #2d1f16 !important;
            font-weight: 750 !important;
        }

        body:has(.ng-operational-form-page) .fi-input::placeholder,
        body:has(.ng-operational-form-page) textarea::placeholder {
            color: rgba(111, 88, 68, .62) !important;
        }

        body:has(.ng-operational-form-page) .fi-fo-field-wrp-label span,
        body:has(.ng-operational-form-page) label {
            color: #4b3525 !important;
            font-size: 12px !important;
            font-weight: 950 !important;
        }

        body:has(.ng-operational-form-page) .fi-fo-field-wrp-helper-text,
        body:has(.ng-operational-form-page) .fi-fo-field-wrp-error-message {
            font-size: 11px !important;
            font-weight: 800 !important;
        }

        body:has(.ng-operational-form-page) .fi-toggle {
            border-radius: 999px !important;
        }

        body:has(.ng-operational-form-page) .fi-btn {
            border-radius: 14px !important;
            font-weight: 900 !important;
        }

        body:has(.ng-operational-form-page) .fi-btn-color-primary,
        body:has(.ng-operational-form-page) .fi-btn-color-warning {
            background: linear-gradient(135deg, #ff9d18, #ee6500) !important;
            box-shadow: 0 12px 22px rgba(238, 101, 0, .22) !important;
        }

        body:has(.ng-operational-form-page) .fi-btn-color-primary:hover,
        body:has(.ng-operational-form-page) .fi-btn-color-warning:hover {
            box-shadow: 0 16px 28px rgba(238, 101, 0, .28) !important;
        }

        body:has(.ng-operational-form-page) form .fi-form-actions,
        body:has(.ng-operational-form-page) form .fi-ac {
            margin-top: 14px !important;
            padding-left: 24px !important;
            padding-right: 24px !important;
        }


        /*
        |--------------------------------------------------------------------------
        | FORM DROPDOWN / DATEPICKER STACKING FIX
        |--------------------------------------------------------------------------
        | Membuat dropdown select dan kalender datepicker muncul di atas field lain,
        | tidak ketimpa saat form discroll.
        */

        body:has(.ng-operational-form-page) .fi-main,
        body:has(.ng-operational-form-page) .fi-main-ctn,
        body:has(.ng-operational-form-page) .fi-page,
        body:has(.ng-operational-form-page) .fi-page-content,
        body:has(.ng-operational-form-page) form,
        body:has(.ng-operational-form-page) form .fi-section,
        body:has(.ng-operational-form-page) .fi-section,
        body:has(.ng-operational-form-page) .fi-section-content,
        body:has(.ng-operational-form-page) .fi-fo-component-ctn,
        body:has(.ng-operational-form-page) .fi-fo-field-wrp {
            overflow: visible !important;
        }

        body:has(.ng-operational-form-page) form {
            position: relative !important;
            z-index: 20 !important;
        }

        body:has(.ng-operational-form-page) form .fi-section,
        body:has(.ng-operational-form-page) .fi-section {
            position: relative !important;
            z-index: 25 !important;
        }

        body:has(.ng-operational-form-page) .fi-dropdown-panel,
        body:has(.ng-operational-form-page) .fi-popover,
        body:has(.ng-operational-form-page) .fi-popover-panel,
        body:has(.ng-operational-form-page) .fi-datepicker,
        body:has(.ng-operational-form-page) .fi-date-time-picker-panel,
        body:has(.ng-operational-form-page) [role="listbox"],
        body:has(.ng-operational-form-page) [data-headlessui-state],
        body:has(.ng-operational-form-page) .choices__list--dropdown,
        body:has(.ng-operational-form-page) .flatpickr-calendar {
            z-index: 99999 !important;
        }

        body:has(.ng-operational-form-page) .fi-fo-field-wrp {
            isolation: auto !important;
        }

        body:has(.ng-operational-form-page) .fi-input-wrp:focus-within,
        body:has(.ng-operational-form-page) .fi-fo-field-wrp:focus-within {
            position: relative !important;
            z-index: 80 !important;
        }


        /*
        |--------------------------------------------------------------------------
        | SIDEBAR EFFECT SYNC - FINANCE PAGES
        |--------------------------------------------------------------------------
        */

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
        body:has(.ng-sales-target-form-page) .fi-sidebar-item a:hover svg,
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

        @media (max-width: 1500px) {
            .ng-op-form-hero-grid {
                grid-template-columns: 1fr;
            }
        }

        @media (max-width: 1100px) {
            .ng-operational-form-page {
                padding: 18px 18px 10px !important;
            }

            .ng-op-form-highlight-card {
                align-items: flex-start;
                flex-direction: column;
            }

            .ng-highlight-actions {
                justify-content: flex-start;
            }

            body:has(.ng-operational-form-page) form .fi-section,
            body:has(.ng-operational-form-page) .fi-section {
                margin-left: 18px !important;
                margin-right: 18px !important;
                width: calc(100% - 36px) !important;
            }

            body:has(.ng-operational-form-page) form .fi-form-actions,
            body:has(.ng-operational-form-page) form .fi-ac {
                padding-left: 18px !important;
                padding-right: 18px !important;
            }
        }

        @media (max-width: 640px) {
            .ng-operational-form-page {
                padding: 14px 14px 8px !important;
            }

            .ng-widget-head h1 {
                font-size: 26px;
            }

            .ng-widget-card {
                padding: 16px;
                border-radius: 22px;
            }

            body:has(.ng-operational-form-page) form .fi-section,
            body:has(.ng-operational-form-page) .fi-section {
                margin-left: 14px !important;
                margin-right: 14px !important;
                width: calc(100% - 28px) !important;
            }

            body:has(.ng-operational-form-page) form .fi-form-actions,
            body:has(.ng-operational-form-page) form .fi-ac {
                padding-left: 14px !important;
                padding-right: 14px !important;
            }
        }

        /*
        |--------------------------------------------------------------------------
        | FIX DATEPICKER / SELECT DROPDOWN TERTIMPA
        |--------------------------------------------------------------------------
        */

        body:has(.ng-operational-form-page) .fi-page-content,
        body:has(.ng-operational-form-page) form,
        body:has(.ng-operational-form-page) .fi-section,
        body:has(.ng-operational-form-page) .fi-section-content,
        body:has(.ng-operational-form-page) .fi-fo-component-ctn,
        body:has(.ng-operational-form-page) .ng-operational-form-page,
        body:has(.ng-operational-form-page) .ng-widget-card {
            overflow: visible !important;
        }

        body:has(.ng-operational-form-page) .fi-dropdown-panel,
        body:has(.ng-operational-form-page) .fi-select-input-ctn,
        body:has(.ng-operational-form-page) [role="listbox"],
        body:has(.ng-operational-form-page) [data-headlessui-state],
        body:has(.ng-operational-form-page) .fi-fo-date-time-picker-panel {
            z-index: 999999 !important;
        }

    </style>
 <?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__attributesOriginalb525200bfa976483b4eaa0b7685c6e24)): ?>
<?php $attributes = $__attributesOriginalb525200bfa976483b4eaa0b7685c6e24; ?>
<?php unset($__attributesOriginalb525200bfa976483b4eaa0b7685c6e24); ?>
<?php endif; ?>
<?php if (isset($__componentOriginalb525200bfa976483b4eaa0b7685c6e24)): ?>
<?php $component = $__componentOriginalb525200bfa976483b4eaa0b7685c6e24; ?>
<?php unset($__componentOriginalb525200bfa976483b4eaa0b7685c6e24); ?>
<?php endif; ?><?php /**PATH /var/www/html/resources/views/filament/admin/resources/operational-costs/widgets/operational-cost-form-hero-widget.blade.php ENDPATH**/ ?>