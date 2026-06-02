<x-filament-widgets::widget>
    <style>
        .product-lux-wrapper {
            --primary: #0f766e;
            --primary-light: #14b8a6;
            --emerald: #10b981;
            --dark: #0f172a;
            --muted: #64748b;
            --border: #e2e8f0;
            --soft: #f8fafc;
            margin-bottom: 22px;
        }

        .product-lux-hero {
            position: relative;
            overflow: hidden;
            border-radius: 30px;
            padding: 30px;
            color: white;
            background:
                radial-gradient(circle at top right, rgba(255,255,255,0.32), transparent 28%),
                radial-gradient(circle at bottom left, rgba(255,255,255,0.18), transparent 28%),
                linear-gradient(135deg, #0f766e 0%, #0d9488 45%, #10b981 100%);
            box-shadow: 0 28px 70px rgba(15, 118, 110, 0.22);
            isolation: isolate;
        }

        .product-lux-hero::before {
            content: "";
            position: absolute;
            inset: 0;
            background-image:
                linear-gradient(rgba(255,255,255,0.09) 1px, transparent 1px),
                linear-gradient(90deg, rgba(255,255,255,0.09) 1px, transparent 1px);
            background-size: 34px 34px;
            opacity: 0.24;
            z-index: -1;
        }

        .product-lux-hero-top {
            display: flex;
            align-items: flex-start;
            justify-content: space-between;
            gap: 24px;
        }

        .product-lux-badge {
            display: inline-flex;
            align-items: center;
            gap: 9px;
            width: fit-content;
            padding: 9px 14px;
            border-radius: 999px;
            background: rgba(255,255,255,0.16);
            border: 1px solid rgba(255,255,255,0.25);
            backdrop-filter: blur(10px);
            font-size: 12px;
            font-weight: 800;
            letter-spacing: 0.12em;
            text-transform: uppercase;
        }

        .product-lux-dot {
            width: 9px;
            height: 9px;
            border-radius: 999px;
            background: #bbf7d0;
            box-shadow: 0 0 0 5px rgba(187,247,208,0.22);
        }

        .product-lux-title {
            margin: 16px 0 0;
            font-size: 34px;
            line-height: 1.08;
            font-weight: 950;
            letter-spacing: -0.04em;
        }

        .product-lux-desc {
            margin: 12px 0 0;
            max-width: 780px;
            color: rgba(255,255,255,0.86);
            font-size: 14px;
            line-height: 1.7;
        }

        .product-lux-mini {
            min-width: 220px;
            border-radius: 22px;
            padding: 18px;
            background: rgba(255,255,255,0.16);
            border: 1px solid rgba(255,255,255,0.24);
            backdrop-filter: blur(12px);
        }

        .product-lux-mini span {
            display: block;
            color: rgba(255,255,255,0.78);
            font-size: 12px;
            font-weight: 700;
        }

        .product-lux-mini strong {
            display: block;
            margin-top: 8px;
            color: white;
            font-size: 30px;
            line-height: 1;
            font-weight: 950;
        }

        .product-lux-grid {
            display: grid;
            grid-template-columns: repeat(4, minmax(0, 1fr));
            gap: 16px;
            margin-top: 20px;
        }

        .product-lux-card {
            position: relative;
            overflow: hidden;
            border-radius: 24px;
            padding: 20px;
            background: white;
            border: 1px solid rgba(226,232,240,0.95);
            box-shadow: 0 16px 40px rgba(15,23,42,0.07);
            min-height: 145px;
            transition: 0.25s ease;
        }

        .product-lux-card:hover {
            transform: translateY(-4px);
            box-shadow: 0 24px 55px rgba(15,23,42,0.12);
        }

        .product-lux-card::after {
            content: "";
            position: absolute;
            width: 118px;
            height: 118px;
            top: -52px;
            right: -42px;
            border-radius: 999px;
            opacity: 0.15;
        }

        .product-lux-card.products::after { background: #10b981; }
        .product-lux-card.active::after { background: #3b82f6; }
        .product-lux-card.stock::after { background: #f97316; }
        .product-lux-card.category::after { background: #8b5cf6; }

        .product-lux-card-label {
            margin: 0;
            color: #64748b;
            font-size: 13px;
            font-weight: 850;
        }

        .product-lux-card-value {
            margin: 18px 0 0;
            color: #020617;
            font-size: 30px;
            line-height: 1;
            font-weight: 950;
            letter-spacing: -0.045em;
        }

        .product-lux-card-caption {
            display: inline-flex;
            align-items: center;
            margin-top: 14px;
            border-radius: 999px;
            padding: 7px 11px;
            font-size: 12px;
            font-weight: 800;
        }

        .products .product-lux-card-caption { background: #ecfdf5; color: #047857; }
        .active .product-lux-card-caption { background: #eff6ff; color: #1d4ed8; }
        .stock .product-lux-card-caption { background: #fff7ed; color: #c2410c; }
        .category .product-lux-card-caption { background: #f5f3ff; color: #6d28d9; }

        @media (max-width: 1100px) {
            .product-lux-hero-top {
                flex-direction: column;
            }

            .product-lux-grid {
                grid-template-columns: repeat(2, minmax(0, 1fr));
            }
        }

        @media (max-width: 700px) {
            .product-lux-hero {
                padding: 24px;
                border-radius: 24px;
            }

            .product-lux-title {
                font-size: 28px;
            }

            .product-lux-grid {
                grid-template-columns: 1fr;
            }
        }
    </style>

    <div class="product-lux-wrapper">
        <section class="product-lux-hero">
            <div class="product-lux-hero-top">
                <div>
                    <div class="product-lux-badge">
                        <span class="product-lux-dot"></span>
                        Ngunjuk POS Product
                    </div>

                    <h2 class="product-lux-title">
                        Product Management Analytics
                    </h2>

                    <p class="product-lux-desc">
                        Kelola data produk minuman, kategori, ukuran, harga, stok,
                        gambar produk, dan status aktif produk dalam satu halaman admin
                        yang lebih rapi dan profesional.
                    </p>
                </div>

                <div class="product-lux-mini">
                    <span>Total Stok Keseluruhan</span>
                    <strong>{{ number_format($summary['total_stock'], 0, ',', '.') }}</strong>
                </div>
            </div>
        </section>

        <div class="product-lux-grid">
            <div class="product-lux-card products">
                <p class="product-lux-card-label">Total Produk</p>
                <p class="product-lux-card-value">
                    {{ number_format($summary['total_products'], 0, ',', '.') }}
                </p>
                <p class="product-lux-card-caption">Semua data produk</p>
            </div>

            <div class="product-lux-card active">
                <p class="product-lux-card-label">Produk Aktif</p>
                <p class="product-lux-card-value">
                    {{ number_format($summary['active_products'], 0, ',', '.') }}
                </p>
                <p class="product-lux-card-caption">Tampil di kasir</p>
            </div>

            <div class="product-lux-card stock">
                <p class="product-lux-card-label">Stok Bermasalah</p>
                <p class="product-lux-card-value">
                    {{ number_format($summary['out_of_stock_products'] + $summary['low_stock_products'], 0, ',', '.') }}
                </p>
                <p class="product-lux-card-caption">
                    {{ number_format($summary['out_of_stock_products'], 0, ',', '.') }} habis,
                    {{ number_format($summary['low_stock_products'], 0, ',', '.') }} menipis
                </p>
            </div>

            <div class="product-lux-card category">
                <p class="product-lux-card-label">Total Kategori</p>
                <p class="product-lux-card-value">
                    {{ number_format($summary['total_categories'], 0, ',', '.') }}
                </p>
                <p class="product-lux-card-caption">Kategori produk</p>
            </div>
        </div>
    </div>
</x-filament-widgets::widget>
