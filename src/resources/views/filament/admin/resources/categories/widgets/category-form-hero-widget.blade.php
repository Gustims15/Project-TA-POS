<x-filament-widgets::widget>
    <div class="ng-category-form-page">
        <section class="ng-category-form-hero">
            <div class="ng-category-form-title">
                <div>
                    <span>POS Ngunjuk</span>
                    <h1>{{ $title }}</h1>
                    <p>{{ $description }}</p>
                </div>

                <a href="{{ $backUrl }}" class="ng-category-back-btn">
                    ← Kembali
                </a>
            </div>
        </section>

        <section class="ng-category-form-stats">
            <article>
                <span>Total Kategori</span>
                <strong>{{ number_format($stats['total_categories'], 0, ',', '.') }}</strong>
                <p>Semua kategori</p>
            </article>

            <article>
                <span>Kategori Aktif</span>
                <strong>{{ number_format($stats['active_categories'], 0, ',', '.') }}</strong>
                <p>Tampil pada sistem</p>
            </article>

            <article>
                <span>Total Produk</span>
                <strong>{{ number_format($stats['total_products'], 0, ',', '.') }}</strong>
                <p>Produk terhubung</p>
            </article>
        </section>
    </div>

    <style>
        html,
        body {
            overflow-x: hidden !important;
        }

        body:has(.ng-category-form-page) {
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

        body:has(.ng-category-form-page) .fi-main,
        body:has(.ng-category-form-page) .fi-main-ctn,
        body:has(.ng-category-form-page) .fi-page,
        body:has(.ng-category-form-page) .fi-page-content {
            width: 100% !important;
            max-width: 100% !important;
            background: transparent !important;
            overflow-x: hidden !important;
        }

        body:has(.ng-category-form-page) .fi-page {
            padding: 0 !important;
        }

        body:has(.ng-category-form-page) .fi-page-header {
            display: none !important;
        }

        body:has(.ng-category-form-page) .fi-main {
            padding: 0 !important;
        }

        body:has(.ng-category-form-page) .fi-sidebar {
            background: rgba(255, 250, 242, .50) !important;
            border-right: 1px solid rgba(255, 255, 255, .48) !important;
            box-shadow: 18px 0 55px rgba(137, 78, 26, .10) !important;
            backdrop-filter: blur(16px) !important;
        }

        body:has(.ng-category-form-page) .fi-sidebar-nav {
            padding: 18px 14px !important;
        }

        body:has(.ng-category-form-page) .fi-sidebar-item a {
            border-radius: 14px !important;
            color: #6f5844 !important;
            transition: .2s ease !important;
        }

        body:has(.ng-category-form-page) .fi-sidebar-item-active a,
        body:has(.ng-category-form-page) .fi-sidebar-item a:hover {
            background: linear-gradient(135deg, #ff9500, #f26a00) !important;
            color: #fff !important;
            box-shadow: 0 14px 24px rgba(242, 106, 0, .24) !important;
        }

        body:has(.ng-category-form-page) .fi-wi-widget {
            background: transparent !important;
            box-shadow: none !important;
            border: none !important;
        }

        body:has(.ng-category-form-page) .fi-wi-widget-content {
            padding: 0 !important;
        }

        body:has(.ng-category-form-page) .fi-page-content {
            gap: 0 !important;
            row-gap: 0 !important;
        }

        .ng-category-form-page {
            width: 100%;
            padding: 24px 24px 0;
            font-family: Inter, Poppins, ui-sans-serif, system-ui, -apple-system, BlinkMacSystemFont, "Segoe UI", sans-serif;
            color: #24180f;
        }

        .ng-category-form-page * {
            box-sizing: border-box;
        }

        .ng-category-form-hero,
        .ng-category-form-stats,
        body:has(.ng-category-form-page) form,
        body:has(.ng-category-form-page) .fi-form,
        body:has(.ng-category-form-page) .fi-section,
        body:has(.ng-category-form-page) .fi-sc-section,
        body:has(.ng-category-form-page) .fi-form-actions,
        body:has(.ng-category-form-page) .fi-ac {
            width: min(100%, 1080px) !important;
            max-width: 1080px !important;
            margin-left: 0 !important;
            margin-right: auto !important;
        }

        .ng-category-form-hero {
            margin-bottom: 14px;
        }

        .ng-category-form-title,
        .ng-category-form-stats article,
        body:has(.ng-category-form-page) .fi-section,
        body:has(.ng-category-form-page) .fi-sc-section {
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

        .ng-category-form-title {
            min-height: 132px;
            display: flex;
            align-items: center;
            justify-content: space-between;
            gap: 20px;
            padding: 22px 24px;
            border-radius: 24px;
        }

        .ng-category-form-title > div {
            min-width: 0;
        }

        .ng-category-form-title span {
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

        .ng-category-form-title h1 {
            margin: 0;
            color: #21160d;
            font-size: 30px;
            line-height: 1.05;
            font-weight: 950;
            letter-spacing: -.04em;
        }

        .ng-category-form-title p {
            max-width: 720px;
            margin: 7px 0 0;
            color: #765d45;
            font-size: 12px;
            font-weight: 650;
            line-height: 1.5;
        }

        .ng-category-back-btn {
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

        .ng-category-form-stats {
            display: grid;
            grid-template-columns: repeat(3, minmax(0, 1fr));
            gap: 10px;
            margin-bottom: 14px;
        }

        .ng-category-form-stats article {
            min-height: 88px;
            padding: 15px 18px;
            border-radius: 20px;
        }

        .ng-category-form-stats span {
            display: block;
            color: #6f5946;
            font-size: 11px;
            font-weight: 900;
        }

        .ng-category-form-stats strong {
            display: block;
            margin-top: 6px;
            color: #23160d;
            font-size: 20px;
            line-height: 1.15;
            font-weight: 950;
            letter-spacing: -.03em;
        }

        .ng-category-form-stats p {
            margin: 6px 0 0;
            color: #6f5946;
            font-size: 10px;
            font-weight: 850;
        }

        body:has(.ng-category-form-page) .fi-section,
        body:has(.ng-category-form-page) .fi-sc-section {
            border-radius: 24px !important;
        }

        body:has(.ng-category-form-page) .fi-section-header,
        body:has(.ng-category-form-page) .fi-sc-section-header {
            min-height: 54px !important;
            padding: 14px 18px !important;
            background: rgba(255, 247, 235, .10) !important;
            border-bottom: 1px solid rgba(114, 74, 41, .07) !important;
        }

        body:has(.ng-category-form-page) .fi-section-content,
        body:has(.ng-category-form-page) .fi-sc-section-content {
            padding: 18px !important;
        }

        body:has(.ng-category-form-page) .fi-section-header-heading,
        body:has(.ng-category-form-page) .fi-sc-section-header-heading {
            color: #25170d !important;
            font-size: 17px !important;
            font-weight: 950 !important;
            letter-spacing: -.03em !important;
        }

        body:has(.ng-category-form-page) .fi-section-header-description,
        body:has(.ng-category-form-page) .fi-sc-section-header-description {
            color: #7b624c !important;
            font-size: 12px !important;
            font-weight: 750 !important;
        }

        body:has(.ng-category-form-page) .fi-fo-field-wrp-label span,
        body:has(.ng-category-form-page) .fi-fo-field-wrp-label {
            color: #4b3525 !important;
            font-weight: 900 !important;
        }

        body:has(.ng-category-form-page) .fi-input-wrp,
        body:has(.ng-category-form-page) .fi-select-input {
            min-height: 46px !important;
            border-radius: 16px !important;
            background: rgba(255, 255, 255, .32) !important;
            border-color: rgba(255, 255, 255, .46) !important;
            box-shadow:
                inset 0 1px 0 rgba(255, 255, 255, .42),
                0 10px 26px rgba(101, 58, 21, .05) !important;
            backdrop-filter: blur(10px) !important;
        }

        body:has(.ng-category-form-page) .fi-input,
        body:has(.ng-category-form-page) .fi-select-input {
            color: #24180f !important;
            font-weight: 750 !important;
        }

        body:has(.ng-category-form-page) .fi-fo-field-wrp-helper-text {
            color: #8b7057 !important;
            font-size: 12px !important;
            font-weight: 700 !important;
        }

        body:has(.ng-category-form-page) .fi-form-actions,
        body:has(.ng-category-form-page) .fi-ac {
            display: flex !important;
            justify-content: flex-start !important;
            align-items: center !important;
            gap: 10px !important;
            margin-top: 12px !important;
            padding: 0 0 24px !important;
            background: transparent !important;
            box-shadow: none !important;
            border: none !important;
        }

        body:has(.ng-category-form-page) .fi-btn {
            min-height: 42px !important;
            border-radius: 14px !important;
            font-weight: 950 !important;
        }

        body:has(.ng-category-form-page) .fi-btn-color-primary {
            background: linear-gradient(135deg, #ff9d18, #ee6500) !important;
            box-shadow: 0 12px 22px rgba(238, 101, 0, .22) !important;
        }

        body:has(.ng-category-form-page) .fi-btn-color-gray {
            background: rgba(255, 255, 255, .42) !important;
            border: 1px solid rgba(255, 255, 255, .55) !important;
            color: #6f5844 !important;
        }

        body:has(.ng-category-form-page) .fi-btn-color-danger {
            box-shadow: 0 12px 22px rgba(239, 68, 68, .18) !important;
        }

        @media (max-width: 1300px) {
            .ng-category-form-hero,
            .ng-category-form-stats,
            body:has(.ng-category-form-page) form,
            body:has(.ng-category-form-page) .fi-form,
            body:has(.ng-category-form-page) .fi-section,
            body:has(.ng-category-form-page) .fi-sc-section,
            body:has(.ng-category-form-page) .fi-form-actions,
            body:has(.ng-category-form-page) .fi-ac {
                width: 100% !important;
                max-width: 100% !important;
            }
        }

        @media (max-width: 900px) {
            .ng-category-form-page {
                padding: 18px 18px 0;
            }

            .ng-category-form-title {
                align-items: flex-start;
                flex-direction: column;
            }

            .ng-category-form-stats {
                grid-template-columns: 1fr;
            }
        }
        /* =========================================================
   FIX ALIGN FORM INFORMASI KATEGORI
   Menyamakan posisi form dengan widget atas
========================================================= */

body:has(.ng-category-form-page) form,
body:has(.ng-category-form-page) .fi-form,
body:has(.ng-category-form-page) .fi-section,
body:has(.ng-category-form-page) .fi-sc-section,
body:has(.ng-category-form-page) .fi-form-actions,
body:has(.ng-category-form-page) .fi-ac {
    width: min(calc(100% - 48px), 1080px) !important;
    max-width: 1080px !important;
    margin-left: 24px !important;
    margin-right: auto !important;
}

/* Supaya section Informasi Kategori tidak nempel kiri */
body:has(.ng-category-form-page) .fi-section,
body:has(.ng-category-form-page) .fi-sc-section {
    transform: none !important;
}

/* Tombol bawah ikut sejajar dengan form */
body:has(.ng-category-form-page) .fi-form-actions,
body:has(.ng-category-form-page) .fi-ac {
    justify-content: flex-start !important;
    padding-left: 0 !important;
}

/* Untuk layar kecil tetap aman */
@media (max-width: 900px) {
    body:has(.ng-category-form-page) form,
    body:has(.ng-category-form-page) .fi-form,
    body:has(.ng-category-form-page) .fi-section,
    body:has(.ng-category-form-page) .fi-sc-section,
    body:has(.ng-category-form-page) .fi-form-actions,
    body:has(.ng-category-form-page) .fi-ac {
        width: calc(100% - 36px) !important;
        margin-left: 18px !important;
        margin-right: 18px !important;
    }
}
/* =========================================================
   FINAL FIX INFORMASI KATEGORI FORM
   Bikin form full, sejajar, tidak double, dan tombol di bawah
========================================================= */

body:has(.ng-category-form-page) form,
body:has(.ng-category-form-page) .fi-form {
    width: min(calc(100% - 48px), 1080px) !important;
    max-width: 1080px !important;
    margin-left: 24px !important;
    margin-right: auto !important;
}

/* Section Informasi Kategori jangan setengah kolom */
body:has(.ng-category-form-page) .fi-section,
body:has(.ng-category-form-page) .fi-sc-section {
    width: 100% !important;
    max-width: 100% !important;
    margin-left: 0 !important;
    margin-right: 0 !important;
    border-radius: 24px !important;
    background: rgba(255, 247, 235, .18) !important;
    border: 1px solid rgba(255, 255, 255, .56) !important;
    box-shadow:
        0 20px 48px rgba(101, 58, 21, .10),
        inset 0 1px 0 rgba(255, 255, 255, .56) !important;
    backdrop-filter: blur(13px) !important;
    overflow: hidden !important;
}

/* Hilangkan efek wrapper dobel di dalam form */
body:has(.ng-category-form-page) .fi-sc,
body:has(.ng-category-form-page) .fi-fo,
body:has(.ng-category-form-page) .fi-fo-component-ctn {
    background: transparent !important;
    box-shadow: none !important;
    border: none !important;
}

/* Header Informasi Kategori lebih rapi */
body:has(.ng-category-form-page) .fi-section-header,
body:has(.ng-category-form-page) .fi-sc-section-header {
    min-height: 60px !important;
    padding: 16px 22px !important;
    background: rgba(255, 247, 235, .10) !important;
    border-bottom: 1px solid rgba(114, 74, 41, .07) !important;
}

/* Isi form lebih lega tapi tetap rapi */
body:has(.ng-category-form-page) .fi-section-content,
body:has(.ng-category-form-page) .fi-sc-section-content {
    padding: 22px !important;
}

/* Input jangan kepotong */
body:has(.ng-category-form-page) .fi-input-wrp {
    width: 100% !important;
    min-height: 46px !important;
    border-radius: 16px !important;
}

/* Tombol bawah pindah dan sejajar di bawah Informasi Kategori */
body:has(.ng-category-form-page) .fi-form-actions,
body:has(.ng-category-form-page) .fi-ac {
    width: min(calc(100% - 48px), 1080px) !important;
    max-width: 1080px !important;
    margin-left: 24px !important;
    margin-right: auto !important;
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

/* Tombol tetap compact */
body:has(.ng-category-form-page) .fi-form-actions .fi-btn,
body:has(.ng-category-form-page) .fi-ac .fi-btn {
    min-height: 42px !important;
    border-radius: 14px !important;
    padding-left: 18px !important;
    padding-right: 18px !important;
    font-weight: 950 !important;
}

/* Responsive */
@media (max-width: 900px) {
    body:has(.ng-category-form-page) form,
    body:has(.ng-category-form-page) .fi-form,
    body:has(.ng-category-form-page) .fi-form-actions,
    body:has(.ng-category-form-page) .fi-ac {
        width: calc(100% - 36px) !important;
        margin-left: 18px !important;
        margin-right: 18px !important;
    }
}
    </style>
</x-filament-widgets::widget>