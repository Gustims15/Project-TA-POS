<?php
    $cards = [
        [
            'label' => 'Biaya Bulan Ini',
            'value' => $this->rupiah($summary['monthly_cost']),
            'caption' => 'Termasuk sewa tahunan / 12',
            'icon' => '▣',
            'color' => '#f97316',
        ],
        [
            'label' => 'Total Biaya',
            'value' => number_format($summary['total_costs'], 0, ',', '.'),
            'caption' => 'Semua data biaya',
            'icon' => '∑',
            'color' => '#3b82f6',
        ],
        [
            'label' => 'Biaya Aktif',
            'value' => number_format($summary['active_costs'], 0, ',', '.'),
            'caption' => 'Masuk dashboard finance',
            'icon' => '✓',
            'color' => '#10b981',
        ],
        [
            'label' => 'Biaya Nonaktif',
            'value' => number_format($summary['inactive_costs'], 0, ',', '.'),
            'caption' => 'Tidak dihitung',
            'icon' => '!',
            'color' => '#ef4444',
        ],
        [
            'label' => 'Biaya Terbesar',
            'value' => $this->rupiah($summary['highest_cost_amount']),
            'caption' => $summary['highest_cost_name'],
            'icon' => '◇',
            'color' => '#8b5cf6',
        ],
    ];
?>

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

    <div class="ng-operational-page" style="
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
                    Finance Control
                </span>

                <h1 style="
                    margin: 0;
                    color: #21160d;
                    font-size: 30px;
                    line-height: 1.05;
                    font-weight: 950;
                    letter-spacing: -.04em;
                ">
                    Biaya Operasional
                </h1>

                <p style="
                    max-width: 720px;
                    margin: 7px 0 0;
                    color: #765d45;
                    font-size: 12px;
                    font-weight: 650;
                    line-height: 1.5;
                ">
                    Kelola seluruh pengeluaran usaha seperti sewa tempat, listrik, air, wifi, gaji karyawan, promosi, maintenance, dan biaya lainnya.
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
                        Biaya Terbesar
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
                        <?php echo e($summary['highest_cost_name']); ?>

                    </strong>

                    <small style="
                        display: block;
                        color: #765d45;
                        font-size: 11px;
                        font-weight: 850;
                    ">
                        <?php echo e($this->rupiah($summary['highest_cost_amount'])); ?>

                    </small>
                </div>

                <div style="
                    display: flex;
                    align-items: center;
                    gap: 8px;
                    flex-wrap: wrap;
                    justify-content: flex-end;
                ">
                    <a href="<?php echo e($dashboardUrl); ?>" style="
                        display: inline-flex;
                        align-items: center;
                        justify-content: center;
                        min-height: 42px;
                        padding: 0 14px;
                        border-radius: 15px;
                        color: #d95d00;
                        background: rgba(255, 255, 255, .38);
                        border: 1px solid rgba(255, 255, 255, .52);
                        box-shadow: inset 0 1px 0 rgba(255, 255, 255, .44);
                        font-size: 12px;
                        font-weight: 950;
                        text-decoration: none;
                        white-space: nowrap;
                    ">
                        Dashboard
                    </a>

                    <a href="<?php echo e($createUrl); ?>" style="
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
                        + New Biaya
                    </a>
                </div>
            </div>
        </div>

        <div style="
            display: grid;
            grid-template-columns: repeat(5, minmax(0, 1fr));
            gap: 10px;
            margin-bottom: 10px;
        ">
            <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::openLoop(); ?><?php endif; ?><?php $__currentLoopData = $cards; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $card): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::startLoop($loop->index); ?><?php endif; ?>
                <div style="
                    min-height: 88px;
                    display: flex;
                    align-items: center;
                    gap: 11px;
                    padding: 14px 14px;
                    border-radius: 20px;
                    border: 1px solid rgba(255, 255, 255, .54);
                    background: rgba(255, 247, 235, .16);
                    box-shadow:
                        0 18px 42px rgba(101, 58, 21, .09),
                        0 0 0 1px rgba(255, 255, 255, .10) inset,
                        inset 0 1px 0 rgba(255, 255, 255, .52);
                    backdrop-filter: blur(13px);
                    overflow: hidden;
                ">
                    <div style="
                        display: grid;
                        place-items: center;
                        flex: 0 0 auto;
                        width: 40px;
                        height: 40px;
                        border-radius: 14px;
                        color: #fff;
                        background: linear-gradient(135deg, <?php echo e($card['color']); ?>, #d95d00);
                        box-shadow: 0 14px 24px rgba(249, 115, 22, .20);
                        font-size: 15px;
                        font-weight: 950;
                    ">
                        <?php echo e($card['icon']); ?>

                    </div>

                    <div style="min-width: 0; flex: 1;">
                        <span style="
                            display: block;
                            color: #6f5946;
                            font-size: 11px;
                            line-height: 1.2;
                            font-weight: 900;
                        ">
                            <?php echo e($card['label']); ?>

                        </span>

                        <strong style="
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
                        ">
                            <?php echo e($card['value']); ?>

                        </strong>

                        <p style="
                            margin: 6px 0 0;
                            color: #6f5946;
                            font-size: 10px;
                            line-height: 1.25;
                            font-weight: 850;
                            white-space: nowrap;
                            overflow: hidden;
                            text-overflow: ellipsis;
                        ">
                            <?php echo e($card['caption']); ?>

                        </p>
                    </div>
                </div>
            <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::endLoop(); ?><?php endif; ?><?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::closeLoop(); ?><?php endif; ?>
        </div>

        <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if(! empty($summary['category_breakdown'])): ?>
            <div style="
                display: grid;
                grid-template-columns: repeat(5, minmax(0, 1fr));
                gap: 10px;
                margin-bottom: 0;
            ">
                <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::openLoop(); ?><?php endif; ?><?php $__currentLoopData = $summary['category_breakdown']; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $item): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::startLoop($loop->index); ?><?php endif; ?>
                    <div style="
                        min-height: 70px;
                        padding: 12px 14px;
                        border-radius: 18px;
                        border: 1px solid rgba(255, 255, 255, .46);
                        background: rgba(255, 247, 235, .12);
                        box-shadow:
                            0 14px 32px rgba(101, 58, 21, .07),
                            inset 0 1px 0 rgba(255, 255, 255, .42);
                        backdrop-filter: blur(12px);
                    ">
                        <span style="
                            display: block;
                            color: #765d45;
                            font-size: 10px;
                            font-weight: 850;
                            white-space: nowrap;
                            overflow: hidden;
                            text-overflow: ellipsis;
                        ">
                            <?php echo e($item['label']); ?>

                        </span>

                        <strong style="
                            display: block;
                            margin-top: 8px;
                            color: #d95d00;
                            font-size: 15px;
                            font-weight: 950;
                            white-space: nowrap;
                            overflow: hidden;
                            text-overflow: ellipsis;
                        ">
                            <?php echo e($this->rupiah($item['value'])); ?>

                        </strong>
                    </div>
                <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::endLoop(); ?><?php endif; ?><?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::closeLoop(); ?><?php endif; ?>
            </div>
        <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
    </div>

    <style>
        html,
        body {
            overflow-x: hidden !important;
        }

        body:has(.ng-operational-page) {
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

        body:has(.ng-operational-page) .fi-wi-widget {
            background: transparent !important;
            box-shadow: none !important;
            border: none !important;
            margin-bottom: 0 !important;
        }

        body:has(.ng-operational-page) .fi-wi-widget-content {
            padding: 0 !important;
        }

        body:has(.ng-operational-page) .fi-wi {
            margin-bottom: 0 !important;
        }
        /*
        |--------------------------------------------------------------------------
        | HILANGKAN GAP ANTARA WIDGET ATAS DAN TABLE
        |--------------------------------------------------------------------------
        */

        body:has(.ng-operational-page) .fi-page-content {
            gap: 0 !important;
            row-gap: 0 !important;
        }

        body:has(.ng-operational-page) .fi-wi-widgets,
        body:has(.ng-operational-page) .fi-wi-widgets > *,
        body:has(.ng-operational-page) .fi-wi-widget,
        body:has(.ng-operational-page) .fi-wi-widget-content {
            margin-bottom: 0 !important;
            padding-bottom: 0 !important;
        }

        body:has(.ng-operational-page) .ng-operational-page {
            padding-bottom: 0 !important;
        }

        body:has(.ng-operational-page) .ng-operational-page > div:last-of-type {
            margin-bottom: 10px !important;
        }

        /*
        |--------------------------------------------------------------------------
        | RAPATKAN JARAK WIDGET KE TABLE
        |--------------------------------------------------------------------------
        */
        body:has(.ng-operational-page) .fi-ta-ctn {
            margin-left: 18px !important;
            margin-right: 18px !important;
            margin-top: 10x !important;
            width: calc(100% - 36px) !important;
            border-radius: 24px !important;
            border: 1px solid rgba(255, 255, 255, .46) !important;
            background:
                linear-gradient(145deg, rgba(255, 247, 235, .18), rgba(255, 239, 218, .10)) !important;
            box-shadow:
                0 18px 46px rgba(101, 58, 21, .09),
                inset 0 1px 0 rgba(255, 255, 255, .38) !important;
            backdrop-filter: blur(12px) !important;
            overflow: hidden !important;
        }

        /*
        |--------------------------------------------------------------------------
        | HILANGKAN PUTIH DI DALAM CONTAINER TABLE
        |--------------------------------------------------------------------------
        */
        body:has(.ng-operational-page) .fi-section,
        body:has(.ng-operational-page) .fi-ta,
        body:has(.ng-operational-page) .fi-ta-content,
        body:has(.ng-operational-page) .fi-ta-table,
        body:has(.ng-operational-page) .fi-ta-ctn > div,
        body:has(.ng-operational-page) .fi-ta-ctn > div > div,
        body:has(.ng-operational-page) .fi-ta-ctn > div > div > div,
        body:has(.ng-operational-page) table,
        body:has(.ng-operational-page) thead,
        body:has(.ng-operational-page) tbody,
        body:has(.ng-operational-page) tr,
        body:has(.ng-operational-page) th,
        body:has(.ng-operational-page) td {
            background: transparent !important;
            box-shadow: none !important;
        }

        body:has(.ng-operational-page) .fi-ta-header,
        body:has(.ng-operational-page) .fi-ta-toolbar {
            min-height: 42px !important;
            padding: 6px 16px !important;
            background: rgba(255, 247, 235, .08) !important;
            border-bottom: 1px solid rgba(114, 74, 41, .08) !important;
        }

        body:has(.ng-operational-page) .fi-ta-header-cell {
            padding-top: 8px !important;
            padding-bottom: 8px !important;
            background: rgba(255, 255, 255, .08) !important;
            border-color: rgba(114, 74, 41, .08) !important;
        }

        body:has(.ng-operational-page) .fi-ta-header-cell-label {
            color: #4b3525 !important;
            font-size: 12px !important;
            font-weight: 950 !important;
        }

        body:has(.ng-operational-page) .fi-ta-row {
            min-height: 48px !important;
            border-bottom: 1px solid rgba(114, 74, 41, .08) !important;
            background: rgba(255, 247, 235, .04) !important;
            transition: .18s ease !important;
        }

        body:has(.ng-operational-page) .fi-ta-row:hover {
            background: rgba(255, 255, 255, .10) !important;
        }

        body:has(.ng-operational-page) .fi-ta-cell {
            padding-top: 8px !important;
            padding-bottom: 8px !important;
            border-color: rgba(114, 74, 41, .08) !important;
            background: transparent !important;
        }

        body:has(.ng-operational-page) .fi-ta-pagination,
        body:has(.ng-operational-page) .fi-pagination {
            min-height: 46px !important;
            padding: 8px 16px !important;
            background: rgba(255, 247, 235, .08) !important;
            border-top: 1px solid rgba(114, 74, 41, .08) !important;
        }

        body:has(.ng-operational-page) .fi-input-wrp,
        body:has(.ng-operational-page) .fi-ta-search-field .fi-input-wrp,
        body:has(.ng-operational-page) .fi-select-input {
            min-height: 36px !important;
            border-radius: 16px !important;
            background: rgba(255, 255, 255, .20) !important;
            border-color: rgba(255, 255, 255, .34) !important;
            box-shadow: inset 0 1px 0 rgba(255, 255, 255, .28) !important;
            backdrop-filter: blur(10px) !important;
        }

        body:has(.ng-operational-page) .fi-ta-search-field {
            max-width: 280px !important;
        }

        body:has(.ng-operational-page) .fi-btn {
            border-radius: 14px !important;
            font-weight: 900 !important;
        }

        body:has(.ng-operational-page) .fi-btn-color-primary,
        body:has(.ng-operational-page) .fi-btn-color-warning {
            background: linear-gradient(135deg, #ff9d18, #ee6500) !important;
            box-shadow: 0 12px 22px rgba(238, 101, 0, .22) !important;
        }

        @media (max-width: 1500px) {
            .ng-operational-page [style*="grid-template-columns: repeat(5"] {
                grid-template-columns: repeat(3, minmax(0, 1fr)) !important;
            }

            .ng-operational-page [style*="grid-template-columns: minmax(0, 1.35fr)"] {
                grid-template-columns: 1fr !important;
            }
        }

        @media (max-width: 900px) {
            .ng-operational-page {
                padding: 14px !important;
            }

            .ng-operational-page [style*="grid-template-columns: repeat(5"] {
                grid-template-columns: 1fr !important;
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
<?php endif; ?><?php /**PATH /var/www/html/resources/views/filament/admin/resources/operational-costs/widgets/operational-cost-analytics-widget.blade.php ENDPATH**/ ?>