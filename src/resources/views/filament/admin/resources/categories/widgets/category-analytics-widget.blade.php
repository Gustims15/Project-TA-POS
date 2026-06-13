@php
    $createUrl = \App\Filament\Admin\Resources\Categories\CategoryResource::getUrl('create');

    $cards = [
        [
            'label' => 'Total Kategori',
            'value' => number_format($summary['total_categories'], 0, ',', '.'),
            'caption' => 'Semua kategori',
            'icon' => '▣',
            'color' => '#f97316',
        ],
        [
            'label' => 'Kategori Aktif',
            'value' => number_format($summary['active_categories'], 0, ',', '.'),
            'caption' => 'Tampil pada sistem',
            'icon' => '✓',
            'color' => '#10b981',
        ],
        [
            'label' => 'Kategori Nonaktif',
            'value' => number_format($summary['inactive_categories'], 0, ',', '.'),
            'caption' => 'Tidak digunakan',
            'icon' => '!',
            'color' => '#ef4444',
        ],
        [
            'label' => 'Total Produk',
            'value' => number_format($summary['total_products'], 0, ',', '.'),
            'caption' => 'Produk terhubung',
            'icon' => '◇',
            'color' => '#3b82f6',
        ],
        [
            'label' => 'Kategori Kosong',
            'value' => number_format($summary['empty_categories'], 0, ',', '.'),
            'caption' => 'Belum ada produk',
            'icon' => '○',
            'color' => '#8b5cf6',
        ],
    ];
@endphp

<x-filament-widgets::widget>
    <div class="ng-category-page" style="
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
                <span style="
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
                ">
                    POS Ngunjuk
                </span>

                <h1 style="
                    margin: 0;
                    color: #21160d;
                    font-size: 30px;
                    line-height: 1.05;
                    font-weight: 950;
                    letter-spacing: -.04em;
                ">
                    Category Management
                </h1>

                <p style="
                    max-width: 720px;
                    margin: 7px 0 0;
                    color: #765d45;
                    font-size: 12px;
                    font-weight: 650;
                    line-height: 1.5;
                ">
                    Kelola kategori produk minuman agar data produk lebih rapi dan mudah digunakan pada halaman kasir POS.
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
                        Kategori Terbanyak Produk
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
                    + New Kategori
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

        body:has(.ng-category-page) {
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

        body:has(.ng-category-page) .fi-main,
        body:has(.ng-category-page) .fi-main-ctn,
        body:has(.ng-category-page) .fi-page,
        body:has(.ng-category-page) .fi-page-content {
            width: 100% !important;
            max-width: 100% !important;
            background: transparent !important;
            overflow-x: hidden !important;
        }

        body:has(.ng-category-page) .fi-page {
            padding: 0 !important;
        }

        body:has(.ng-category-page) .fi-page-header {
            display: none !important;
        }

        body:has(.ng-category-page) .fi-main {
            padding: 0 !important;
        }

        body:has(.ng-category-page) .fi-sidebar {
            background: rgba(255, 250, 242, .50) !important;
            border-right: 1px solid rgba(255, 255, 255, .48) !important;
            box-shadow: 18px 0 55px rgba(137, 78, 26, .10) !important;
            backdrop-filter: blur(16px) !important;
        }

        body:has(.ng-category-page) .fi-sidebar-nav {
            padding: 18px 14px !important;
        }

        body:has(.ng-category-page) .fi-sidebar-item a {
            border-radius: 14px !important;
            color: #6f5844 !important;
            transition: .2s ease !important;
        }

        body:has(.ng-category-page) .fi-sidebar-item-active a,
        body:has(.ng-category-page) .fi-sidebar-item a:hover {
            background: linear-gradient(135deg, #ff9500, #f26a00) !important;
            color: #fff !important;
            box-shadow: 0 14px 24px rgba(242, 106, 0, .24) !important;
        }

        body:has(.ng-category-page) .fi-wi-widget {
            background: transparent !important;
            box-shadow: none !important;
            border: none !important;
        }

        body:has(.ng-category-page) .fi-wi-widget-content {
            padding: 0 !important;
        }

        /* wrapper tabel utama */
        body:has(.ng-category-page) .fi-ta-ctn {
            border-radius: 24px !important;
            border: 1px solid rgba(255, 255, 255, .46) !important;
            background: rgba(255, 247, 235, .14) !important;
            box-shadow:
                0 18px 46px rgba(101, 58, 21, .09),
                inset 0 1px 0 rgba(255, 255, 255, .38) !important;
            backdrop-filter: blur(12px) !important;
            overflow: hidden !important;
        }

        /* buang layer dalam biar ga dobel */
        body:has(.ng-category-page) .fi-ta,
        body:has(.ng-category-page) .fi-section,
        body:has(.ng-category-page) .fi-ta-content,
        body:has(.ng-category-page) .fi-ta-table,
        body:has(.ng-category-page) .fi-ta-table thead,
        body:has(.ng-category-page) .fi-ta-table tbody {
            background: transparent !important;
            border: none !important;
            box-shadow: none !important;
            backdrop-filter: none !important;
        }

        /* header search area */
        body:has(.ng-category-page) .fi-ta-header,
        body:has(.ng-category-page) .fi-ta-toolbar {
            background: rgba(255, 247, 235, .10) !important;
            border-bottom: 1px solid rgba(114, 74, 41, .07) !important;
        }

        /* header kolom */
        body:has(.ng-category-page) .fi-ta-table thead tr {
            background: rgba(255, 247, 235, .10) !important;
        }

        body:has(.ng-category-page) .fi-ta-row,
        body:has(.ng-category-page) .fi-ta-cell,
        body:has(.ng-category-page) .fi-ta-header-cell {
            background: transparent !important;
        }

        body:has(.ng-category-page) .fi-ta-row {
            min-height: 58px !important;
            border-bottom: 1px solid rgba(114, 74, 41, .07) !important;
            transition: .18s ease !important;
        }

        body:has(.ng-category-page) .fi-ta-row:hover {
            background: rgba(255, 255, 255, .10) !important;
        }

        body:has(.ng-category-page) .fi-ta-cell {
            padding-top: 10px !important;
            padding-bottom: 10px !important;
            border-color: rgba(114, 74, 41, .07) !important;
        }

        body:has(.ng-category-page) .fi-ta-header-cell {
            padding-top: 11px !important;
            padding-bottom: 11px !important;
            border-color: rgba(114, 74, 41, .07) !important;
        }

        body:has(.ng-category-page) .fi-ta-header-cell-label {
            color: #4b3525 !important;
            font-size: 12px !important;
            font-weight: 950 !important;
        }

        body:has(.ng-category-page) .fi-ta-pagination,
        body:has(.ng-category-page) .fi-pagination {
            background: rgba(255, 247, 235, .10) !important;
            border-top: 1px solid rgba(114, 74, 41, .07) !important;
        }

        body:has(.ng-category-page) .fi-input-wrp,
        body:has(.ng-category-page) .fi-ta-search-field .fi-input-wrp,
        body:has(.ng-category-page) .fi-select-input {
            border-radius: 16px !important;
            background: rgba(255, 255, 255, .26) !important;
            border-color: rgba(255, 255, 255, .40) !important;
            box-shadow: inset 0 1px 0 rgba(255, 255, 255, .32) !important;
            backdrop-filter: blur(10px) !important;
        }

        body:has(.ng-category-page) .fi-btn {
            border-radius: 14px !important;
            font-weight: 900 !important;
        }

        body:has(.ng-category-page) .fi-btn-color-primary {
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
            .ng-category-page {
                padding: 14px !important;
            }

            [style*="grid-template-columns: repeat(5"] {
                grid-template-columns: 1fr !important;
            }
        }
        /* =========================================================
   FINAL TABLE CATEGORY SPACING PATCH
   Merapatkan tabel kategori dan menyamakan kiri-kanan
========================================================= */

/* Samakan jarak tabel dengan widget atas */
body:has(.ng-category-page) .fi-ta-ctn {
    margin-left: 18px !important;
    margin-right: 18px !important;
    width: calc(100% - 36px) !important;
}

/* Area search/header tabel jangan terlalu tinggi */
body:has(.ng-category-page) .fi-ta-header,
body:has(.ng-category-page) .fi-ta-toolbar {
    min-height: 52px !important;
    padding: 8px 16px !important;
}

/* Header kolom lebih compact */
body:has(.ng-category-page) .fi-ta-header-cell {
    padding-top: 9px !important;
    padding-bottom: 9px !important;
}

/* Row tabel lebih rapat */
body:has(.ng-category-page) .fi-ta-row {
    min-height: 52px !important;
}

body:has(.ng-category-page) .fi-ta-cell {
    padding-top: 8px !important;
    padding-bottom: 8px !important;
}

/* Biar kolom tidak terlalu berjauhan */
body:has(.ng-category-page) .fi-ta-table {
    table-layout: fixed !important;
    width: 100% !important;
}

/* Kolom checkbox */
body:has(.ng-category-page) .fi-ta-table th:nth-child(1),
body:has(.ng-category-page) .fi-ta-table td:nth-child(1) {
    width: 52px !important;
}

/* Kolom Nama Kategori */
body:has(.ng-category-page) .fi-ta-table th:nth-child(2),
body:has(.ng-category-page) .fi-ta-table td:nth-child(2) {
    width: 34% !important;
}

/* Kolom Slug */
body:has(.ng-category-page) .fi-ta-table th:nth-child(3),
body:has(.ng-category-page) .fi-ta-table td:nth-child(3) {
    width: 20% !important;
}

/* Kolom Aktif */
body:has(.ng-category-page) .fi-ta-table th:nth-child(4),
body:has(.ng-category-page) .fi-ta-table td:nth-child(4) {
    width: 15% !important;
    text-align: center !important;
}

/* Kolom Jumlah Produk */
body:has(.ng-category-page) .fi-ta-table th:nth-child(5),
body:has(.ng-category-page) .fi-ta-table td:nth-child(5) {
    width: 18% !important;
    text-align: center !important;
}

/* Kolom Edit */
body:has(.ng-category-page) .fi-ta-table th:nth-child(6),
body:has(.ng-category-page) .fi-ta-table td:nth-child(6) {
    width: 90px !important;
    text-align: right !important;
}

/* Nama kategori lebih compact */
body:has(.ng-category-page) .fi-ta-cell div[style*="min-width:210px"] {
    min-width: 170px !important;
    gap: 10px !important;
}

/* Avatar huruf kategori sedikit kecil */
body:has(.ng-category-page) .fi-ta-cell div[style*="width:42px"] {
    width: 36px !important;
    height: 36px !important;
    border-radius: 13px !important;
}

/* Badge slug dan jumlah produk sedikit compact */
body:has(.ng-category-page) .fi-ta-cell span[style*="border-radius:999px"],
body:has(.ng-category-page) .fi-ta-cell div[style*="border-radius:999px"] {
    min-height: 26px !important;
    padding-left: 10px !important;
    padding-right: 10px !important;
    font-size: 10px !important;
}

/* Search field lebih kecil dan rapi */
body:has(.ng-category-page) .fi-ta-search-field {
    max-width: 280px !important;
}

body:has(.ng-category-page) .fi-ta-search-field .fi-input-wrp {
    min-height: 36px !important;
}

/* Pagination bawah lebih rapat */
body:has(.ng-category-page) .fi-ta-pagination,
body:has(.ng-category-page) .fi-pagination {
    min-height: 50px !important;
    padding: 8px 16px !important;
}
/* =========================================================
   FIX JARAK WIDGET ATAS KE TABLE KATEGORI
   Bikin table Nama Kategori naik dan rapat ke KPI
========================================================= */

/* Hilangkan gap bawaan halaman Filament */
body:has(.ng-category-page) .fi-page-content {
    gap: 0 !important;
    row-gap: 0 !important;
}

/* Hilangkan jarak bawah widget kategori */
body:has(.ng-category-page) .fi-wi-widget,
body:has(.ng-category-page) .fi-wi-widget-content {
    margin-bottom: 0 !important;
    padding-bottom: 0 !important;
}

/* Bikin table naik lebih rapat ke widget KPI */
body:has(.ng-category-page) .fi-ta-ctn {
    margin-top: 0 !important;
    transform: translateY(-2px) !important;
}

/* Wrapper kategori jangan terlalu banyak padding bawah */
.ng-category-page {
    padding-bottom: 4px !important;
}

/* KPI row jangan kasih jarak bawah terlalu jauh */
.ng-category-page > div:last-of-type {
    margin-bottom: 6px !important;
}

/* Samakan lebar kiri-kanan table dengan widget atas */
body:has(.ng-category-page) .fi-ta-ctn {
    margin-left: 18px !important;
    margin-right: 18px !important;
    width: calc(100% - 36px) !important;
}

/* Search/header table lebih pendek agar table terasa rapat */
body:has(.ng-category-page) .fi-ta-header,
body:has(.ng-category-page) .fi-ta-toolbar {
    min-height: 46px !important;
    padding-top: 6px !important;
    padding-bottom: 6px !important;
}

/* Header kolom jangan terlalu tinggi */
body:has(.ng-category-page) .fi-ta-header-cell {
    padding-top: 8px !important;
    padding-bottom: 8px !important;
}

/* Row table tetap compact */
body:has(.ng-category-page) .fi-ta-row {
    min-height: 50px !important;
}

body:has(.ng-category-page) .fi-ta-cell {
    padding-top: 7px !important;
    padding-bottom: 7px !important;
}
    </style>
</x-filament-widgets::widget>