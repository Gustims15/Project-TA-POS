@php
    $createUrl = \App\Filament\Admin\Resources\Products\ProductResource::getUrl('create');

    $problemStock = $summary['out_of_stock_products'] + $summary['low_stock_products'];

    $cards = [
        [
            'label' => 'Total Produk',
            'value' => number_format($summary['total_products'], 0, ',', '.'),
            'caption' => 'Semua data produk',
            'icon' => '▣',
            'color' => '#f97316',
        ],
        [
            'label' => 'Produk Aktif',
            'value' => number_format($summary['active_products'], 0, ',', '.'),
            'caption' => 'Tampil di kasir',
            'icon' => '✓',
            'color' => '#10b981',
        ],
        [
            'label' => 'Stok Bermasalah',
            'value' => number_format($problemStock, 0, ',', '.'),
            'caption' => number_format($summary['out_of_stock_products'], 0, ',', '.') . ' habis, ' . number_format($summary['low_stock_products'], 0, ',', '.') . ' menipis',
            'icon' => '!',
            'color' => '#ef4444',
        ],
        [
            'label' => 'Total Kategori',
            'value' => number_format($summary['total_categories'], 0, ',', '.'),
            'caption' => 'Kategori produk',
            'icon' => '◇',
            'color' => '#3b82f6',
        ],
        [
            'label' => 'Total Stok',
            'value' => number_format($summary['total_stock'], 0, ',', '.'),
            'caption' => 'Unit tersedia',
            'icon' => '○',
            'color' => '#8b5cf6',
        ],
    ];
@endphp

<x-filament-widgets::widget>
    <div class="ng-product-page" style="
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
                    Product Management
                </h1>

                <p style="
                    max-width: 760px;
                    margin: 7px 0 0;
                    color: #765d45;
                    font-size: 12px;
                    font-weight: 650;
                    line-height: 1.5;
                ">
                    Kelola data produk minuman, kategori, ukuran, harga, stok, gambar produk, dan status aktif produk dalam satu halaman admin.
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
                        Kategori Produk Terbanyak
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
                        {{ $summary['top_category_name'] }}
                    </strong>

                    <small style="
                        display: block;
                        color: #765d45;
                        font-size: 11px;
                        font-weight: 850;
                    ">
                        {{ number_format($summary['top_category_products'], 0, ',', '.') }} produk terhubung
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
                    + New Produk
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

        body:has(.ng-product-page) {
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

        body:has(.ng-product-page) .fi-main,
        body:has(.ng-product-page) .fi-main-ctn,
        body:has(.ng-product-page) .fi-page,
        body:has(.ng-product-page) .fi-page-content {
            width: 100% !important;
            max-width: 100% !important;
            background: transparent !important;
            overflow-x: hidden !important;
        }

        body:has(.ng-product-page) .fi-page {
            padding: 0 !important;
        }

        body:has(.ng-product-page) .fi-page-header {
            display: none !important;
        }

        body:has(.ng-product-page) .fi-main {
            padding: 0 !important;
        }

        body:has(.ng-product-page) .fi-sidebar {
            background: rgba(255, 250, 242, .50) !important;
            border-right: 1px solid rgba(255, 255, 255, .48) !important;
            box-shadow: 18px 0 55px rgba(137, 78, 26, .10) !important;
            backdrop-filter: blur(16px) !important;
        }

        body:has(.ng-product-page) .fi-sidebar-nav {
            padding: 18px 14px !important;
        }

        body:has(.ng-product-page) .fi-sidebar-item a {
            border-radius: 14px !important;
            color: #6f5844 !important;
            transition: .2s ease !important;
        }

        body:has(.ng-product-page) .fi-sidebar-item-active a,
        body:has(.ng-product-page) .fi-sidebar-item a:hover {
            background: linear-gradient(135deg, #ff9500, #f26a00) !important;
            color: #fff !important;
            box-shadow: 0 14px 24px rgba(242, 106, 0, .24) !important;
        }

        body:has(.ng-product-page) .fi-wi-widget {
            background: transparent !important;
            box-shadow: none !important;
            border: none !important;
        }

        body:has(.ng-product-page) .fi-wi-widget-content {
            padding: 0 !important;
        }

        body:has(.ng-product-page) .fi-page-content {
            gap: 0 !important;
            row-gap: 0 !important;
        }

        body:has(.ng-product-page) .fi-ta-ctn {
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

        body:has(.ng-product-page) .fi-ta,
        body:has(.ng-product-page) .fi-section,
        body:has(.ng-product-page) .fi-ta-content,
        body:has(.ng-product-page) .fi-ta-table,
        body:has(.ng-product-page) .fi-ta-table thead,
        body:has(.ng-product-page) .fi-ta-table tbody {
            background: transparent !important;
            border: none !important;
            box-shadow: none !important;
            backdrop-filter: none !important;
        }

        body:has(.ng-product-page) .fi-ta-header,
        body:has(.ng-product-page) .fi-ta-toolbar {
            min-height: 46px !important;
            padding: 6px 16px !important;
            background: rgba(255, 247, 235, .10) !important;
            border-bottom: 1px solid rgba(114, 74, 41, .07) !important;
        }

        body:has(.ng-product-page) .fi-ta-table thead tr {
            background: rgba(255, 247, 235, .10) !important;
        }

        body:has(.ng-product-page) .fi-ta-row,
        body:has(.ng-product-page) .fi-ta-cell,
        body:has(.ng-product-page) .fi-ta-header-cell {
            background: transparent !important;
        }

        body:has(.ng-product-page) .fi-ta-row {
            min-height: 54px !important;
            border-bottom: 1px solid rgba(114, 74, 41, .07) !important;
            transition: .18s ease !important;
        }

        body:has(.ng-product-page) .fi-ta-row:hover {
            background: rgba(255, 255, 255, .10) !important;
        }

        body:has(.ng-product-page) .fi-ta-cell {
            padding-top: 8px !important;
            padding-bottom: 8px !important;
            border-color: rgba(114, 74, 41, .07) !important;
        }

        body:has(.ng-product-page) .fi-ta-header-cell {
            padding-top: 9px !important;
            padding-bottom: 9px !important;
            border-color: rgba(114, 74, 41, .07) !important;
        }

        body:has(.ng-product-page) .fi-ta-header-cell-label {
            color: #4b3525 !important;
            font-size: 12px !important;
            font-weight: 950 !important;
        }

        body:has(.ng-product-page) .fi-ta-pagination,
        body:has(.ng-product-page) .fi-pagination {
            min-height: 50px !important;
            padding: 8px 16px !important;
            background: rgba(255, 247, 235, .10) !important;
            border-top: 1px solid rgba(114, 74, 41, .07) !important;
        }

        body:has(.ng-product-page) .fi-input-wrp,
        body:has(.ng-product-page) .fi-ta-search-field .fi-input-wrp,
        body:has(.ng-product-page) .fi-select-input {
            border-radius: 16px !important;
            background: rgba(255, 255, 255, .26) !important;
            border-color: rgba(255, 255, 255, .40) !important;
            box-shadow: inset 0 1px 0 rgba(255, 255, 255, .32) !important;
            backdrop-filter: blur(10px) !important;
        }

        body:has(.ng-product-page) .fi-ta-search-field {
            max-width: 280px !important;
        }

        body:has(.ng-product-page) .fi-ta-search-field .fi-input-wrp {
            min-height: 36px !important;
        }

        body:has(.ng-product-page) .fi-btn {
            border-radius: 14px !important;
            font-weight: 900 !important;
        }

        body:has(.ng-product-page) .fi-btn-color-primary {
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
            .ng-product-page {
                padding: 14px !important;
            }

            [style*="grid-template-columns: repeat(5"] {
                grid-template-columns: 1fr !important;
            }
        }
        /* =========================================================
   FIX JARAK TABLE PRODUK KE WIDGET ATAS
   Bikin kolom Nama Produk/table lebih mepet ke KPI
========================================================= */

/* Hilangkan gap bawaan Filament */
body:has(.ng-product-page) .fi-page-content {
    gap: 0 !important;
    row-gap: 0 !important;
}

/* Hilangkan jarak bawah widget produk */
body:has(.ng-product-page) .fi-wi-widget,
body:has(.ng-product-page) .fi-wi-widget-content {
    margin-bottom: 0 !important;
    padding-bottom: 0 !important;
}

/* KPI produk jangan kasih jarak bawah terlalu besar */
.ng-product-page {
    padding-bottom: 2px !important;
}

.ng-product-page > div:last-of-type {
    margin-bottom: 4px !important;
}

/* Table produk dinaikkan lebih dekat ke KPI */
body:has(.ng-product-page) .fi-ta-ctn {
    margin-top: 0 !important;
    transform: translateY(1px) !important;
}

/* Header search table dibuat lebih pendek */
body:has(.ng-product-page) .fi-ta-header,
body:has(.ng-product-page) .fi-ta-toolbar {
    min-height: 44px !important;
    padding-top: 5px !important;
    padding-bottom: 5px !important;
}

/* Header kolom lebih compact */
body:has(.ng-product-page) .fi-ta-header-cell {
    padding-top: 8px !important;
    padding-bottom: 8px !important;
}

/* Row pertama tidak terlalu turun */
body:has(.ng-product-page) .fi-ta-row {
    min-height: 50px !important;
}

body:has(.ng-product-page) .fi-ta-cell {
    padding-top: 7px !important;
    padding-bottom: 7px !important;
}
    </style>
</x-filament-widgets::widget>