@php
    $createUrl = \App\Filament\Admin\Resources\Roles\RoleResource::getUrl('create');

    $cards = [
        [
            'label' => 'Total Roles',
            'value' => number_format($summary['total_roles'], 0, ',', '.'),
            'caption' => 'Semua role sistem',
            'icon' => '▣',
            'color' => '#f97316',
        ],
        [
            'label' => 'Total Permissions',
            'value' => number_format($summary['total_permissions'], 0, ',', '.'),
            'caption' => 'Hak akses tersedia',
            'icon' => '✓',
            'color' => '#10b981',
        ],
        [
            'label' => 'Guard Web',
            'value' => number_format($summary['web_roles'], 0, ',', '.'),
            'caption' => 'Role guard web',
            'icon' => '◇',
            'color' => '#3b82f6',
        ],
        [
            'label' => 'Role Kosong',
            'value' => number_format($summary['empty_roles'], 0, ',', '.'),
            'caption' => 'Belum ada permission',
            'icon' => '!',
            'color' => '#ef4444',
        ],
        [
            'label' => 'Access Control',
            'value' => 'Shield',
            'caption' => 'Filament permission',
            'icon' => '○',
            'color' => '#8b5cf6',
        ],
    ];
@endphp

<x-filament-widgets::widget>
    <div class="ng-role-page" style="
        width: 100%;
        padding: 18px 18px 12px;
        font-family: Inter, Poppins, ui-sans-serif, system-ui, -apple-system, BlinkMacSystemFont, 'Segoe UI', sans-serif;
        color: #24180f;
    ">
        <div style="
            display: grid;
            grid-template-columns: minmax(0, 1.35fr) minmax(340px, .65fr);
            gap: 12px;
            margin-bottom: 12px;
        ">
            <div style="
                min-height: 126px;
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

                <h1 style="
                    margin: 0;
                    color: #21160d;
                    font-size: 30px;
                    line-height: 1.05;
                    font-weight: 950;
                    letter-spacing: -.04em;
                ">
                    Role & Permission
                </h1>

                <p style="
                    max-width: 790px;
                    margin: 7px 0 0;
                    color: #765d45;
                    font-size: 12px;
                    font-weight: 650;
                    line-height: 1.5;
                ">
                    Kelola hak akses pengguna, role admin, role karyawan, guard, dan permission sistem agar akses fitur POS tetap aman dan terkontrol.
                </p>
            </div>

            <div style="
                min-height: 126px;
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
                        Role Permission Terbanyak
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
                        {{ str($summary['top_role_name'])->replace('_', ' ')->title() }}
                    </strong>

                    <small style="
                        display: block;
                        color: #765d45;
                        font-size: 11px;
                        font-weight: 850;
                    ">
                        {{ number_format($summary['top_role_permissions'], 0, ',', '.') }} permission
                    </small>
                </div>

                <a href="{{ $createUrl }}" style="
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
                    + New Role
                </a>
            </div>
        </div>

        <div style="
            display: grid;
            grid-template-columns: repeat(5, minmax(0, 1fr));
            gap: 10px;
            margin-bottom: 12px;
        ">
            @foreach ($cards as $card)
                <div style="
                    min-height: 90px;
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
                        background: linear-gradient(135deg, {{ $card['color'] }}, #d95d00);
                        box-shadow: 0 14px 24px rgba(249, 115, 22, .20);
                        font-size: 15px;
                        font-weight: 950;
                    ">
                        {{ $card['icon'] }}
                    </div>

                    <div style="min-width: 0; flex: 1;">
                        <span style="
                            display: block;
                            color: #6f5946;
                            font-size: 11px;
                            line-height: 1.2;
                            font-weight: 900;
                        ">
                            {{ $card['label'] }}
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
                            {{ $card['value'] }}
                        </strong>

                        <p style="
                            margin: 6px 0 0;
                            color: #6f5946;
                            font-size: 10px;
                            line-height: 1.25;
                            font-weight: 850;
                        ">
                            {{ $card['caption'] }}
                        </p>
                    </div>
                </div>
            @endforeach
        </div>
    </div>

    <style>
        html,
        body {
            overflow-x: hidden !important;
        }

        body:has(.ng-role-page) {
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

        body:has(.ng-role-page) .fi-main,
        body:has(.ng-role-page) .fi-main-ctn,
        body:has(.ng-role-page) .fi-page,
        body:has(.ng-role-page) .fi-page-content {
            width: 100% !important;
            max-width: 100% !important;
            background: transparent !important;
            overflow-x: hidden !important;
        }

        body:has(.ng-role-page) .fi-page {
            padding: 0 !important;
        }

        body:has(.ng-role-page) .fi-page-header {
            display: none !important;
        }

        body:has(.ng-role-page) .fi-main {
            padding: 0 !important;
        }

        body:has(.ng-role-page) .fi-sidebar {
            background: rgba(255, 250, 242, .50) !important;
            border-right: 1px solid rgba(255, 255, 255, .48) !important;
            box-shadow: 18px 0 55px rgba(137, 78, 26, .10) !important;
            backdrop-filter: blur(16px) !important;
        }

        body:has(.ng-role-page) .fi-sidebar-nav {
            padding: 18px 14px !important;
        }

        body:has(.ng-role-page) .fi-sidebar-item a {
            border-radius: 14px !important;
            color: #6f5844 !important;
            transition: .2s ease !important;
        }

        body:has(.ng-role-page) .fi-sidebar-item-active a,
        body:has(.ng-role-page) .fi-sidebar-item a:hover {
            background: linear-gradient(135deg, #ff9500, #f26a00) !important;
            color: #fff !important;
            box-shadow: 0 14px 24px rgba(242, 106, 0, .24) !important;
        }

        body:has(.ng-role-page) .fi-wi-widget {
            background: transparent !important;
            box-shadow: none !important;
            border: none !important;
        }

        body:has(.ng-role-page) .fi-wi-widget-content {
            padding: 0 !important;
        }

        body:has(.ng-role-page) .fi-page-content {
            gap: 0 !important;
            row-gap: 0 !important;
        }

        body:has(.ng-role-page) .fi-ta-ctn {
            margin-left: 18px !important;
            margin-right: 18px !important;
            width: calc(100% - 36px) !important;
            transform: translateY(-8px) !important;
            border-radius: 24px !important;
            border: 1px solid rgba(255, 255, 255, .46) !important;
            background: rgba(255, 247, 235, .14) !important;
            box-shadow:
                0 18px 46px rgba(101, 58, 21, .09),
                inset 0 1px 0 rgba(255, 255, 255, .38) !important;
            backdrop-filter: blur(12px) !important;
            overflow: hidden !important;
        }

        body:has(.ng-role-page) .fi-ta,
        body:has(.ng-role-page) .fi-section,
        body:has(.ng-role-page) .fi-ta-content,
        body:has(.ng-role-page) .fi-ta-table,
        body:has(.ng-role-page) .fi-ta-table thead,
        body:has(.ng-role-page) .fi-ta-table tbody {
            background: transparent !important;
            border: none !important;
            box-shadow: none !important;
            backdrop-filter: none !important;
        }

        body:has(.ng-role-page) .fi-ta-header,
        body:has(.ng-role-page) .fi-ta-toolbar {
            min-height: 46px !important;
            padding: 6px 16px !important;
            background: rgba(255, 247, 235, .10) !important;
            border-bottom: 1px solid rgba(114, 74, 41, .07) !important;
        }

        body:has(.ng-role-page) .fi-ta-table thead tr {
            background: rgba(255, 247, 235, .10) !important;
        }

        body:has(.ng-role-page) .fi-ta-row,
        body:has(.ng-role-page) .fi-ta-cell,
        body:has(.ng-role-page) .fi-ta-header-cell {
            background: transparent !important;
        }

        body:has(.ng-role-page) .fi-ta-row {
            min-height: 54px !important;
            border-bottom: 1px solid rgba(114, 74, 41, .07) !important;
            transition: .18s ease !important;
        }

        body:has(.ng-role-page) .fi-ta-row:hover {
            background: rgba(255, 255, 255, .10) !important;
        }

        body:has(.ng-role-page) .fi-ta-cell {
            padding-top: 8px !important;
            padding-bottom: 8px !important;
            border-color: rgba(114, 74, 41, .07) !important;
        }

        body:has(.ng-role-page) .fi-ta-header-cell {
            padding-top: 9px !important;
            padding-bottom: 9px !important;
            border-color: rgba(114, 74, 41, .07) !important;
        }

        body:has(.ng-role-page) .fi-ta-header-cell-label {
            color: #4b3525 !important;
            font-size: 12px !important;
            font-weight: 950 !important;
        }

        body:has(.ng-role-page) .fi-ta-pagination,
        body:has(.ng-role-page) .fi-pagination {
            min-height: 50px !important;
            padding: 8px 16px !important;
            background: rgba(255, 247, 235, .10) !important;
            border-top: 1px solid rgba(114, 74, 41, .07) !important;
        }

        body:has(.ng-role-page) .fi-input-wrp,
        body:has(.ng-role-page) .fi-ta-search-field .fi-input-wrp,
        body:has(.ng-role-page) .fi-select-input {
            border-radius: 16px !important;
            background: rgba(255, 255, 255, .26) !important;
            border-color: rgba(255, 255, 255, .40) !important;
            box-shadow: inset 0 1px 0 rgba(255, 255, 255, .32) !important;
            backdrop-filter: blur(10px) !important;
        }

        body:has(.ng-role-page) .fi-ta-search-field {
            max-width: 280px !important;
        }

        body:has(.ng-role-page) .fi-ta-search-field .fi-input-wrp {
            min-height: 36px !important;
        }

        body:has(.ng-role-page) .fi-btn {
            border-radius: 14px !important;
            font-weight: 900 !important;
        }

        body:has(.ng-role-page) .fi-btn-color-primary {
            background: linear-gradient(135deg, #ff9d18, #ee6500) !important;
            box-shadow: 0 12px 22px rgba(238, 101, 0, .22) !important;
        }

        @media (max-width: 1500px) {
            [style*="grid-template-columns: repeat(5"] {
                grid-template-columns: repeat(3, minmax(0, 1fr)) !important;
            }

            [style*="grid-template-columns: minmax(0, 1.35fr)"] {
                grid-template-columns: 1fr !important;
            }
        }

        @media (max-width: 900px) {
            .ng-role-page {
                padding: 14px !important;
            }

            [style*="grid-template-columns: repeat(5"] {
                grid-template-columns: 1fr !important;
            }
        }
    </style>
</x-filament-widgets::widget>