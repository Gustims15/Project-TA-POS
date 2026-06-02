<x-filament-widgets::widget>
    <style>
        .activity-lux-wrapper {
            margin-bottom: 22px;
        }

        .activity-lux-hero {
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

        .activity-lux-hero::before {
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

        .activity-lux-hero-top {
            display: flex;
            align-items: flex-start;
            justify-content: space-between;
            gap: 24px;
        }

        .activity-lux-badge {
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

        .activity-lux-dot {
            width: 9px;
            height: 9px;
            border-radius: 999px;
            background: #bbf7d0;
            box-shadow: 0 0 0 5px rgba(187,247,208,0.22);
        }

        .activity-lux-title {
            margin: 16px 0 0;
            font-size: 34px;
            line-height: 1.08;
            font-weight: 950;
            letter-spacing: -0.04em;
        }

        .activity-lux-desc {
            margin: 12px 0 0;
            max-width: 780px;
            color: rgba(255,255,255,0.86);
            font-size: 14px;
            line-height: 1.7;
        }

        .activity-lux-mini {
            min-width: 260px;
            border-radius: 22px;
            padding: 18px;
            background: rgba(255,255,255,0.16);
            border: 1px solid rgba(255,255,255,0.24);
            backdrop-filter: blur(12px);
        }

        .activity-lux-mini span {
            display: block;
            color: rgba(255,255,255,0.78);
            font-size: 12px;
            font-weight: 700;
        }

        .activity-lux-mini strong {
            display: block;
            margin-top: 8px;
            color: white;
            font-size: 24px;
            line-height: 1.15;
            font-weight: 950;
        }

        .activity-lux-mini small {
            display: block;
            margin-top: 8px;
            color: rgba(255,255,255,0.82);
            font-size: 12px;
            font-weight: 700;
        }

        .activity-lux-grid {
            display: grid;
            grid-template-columns: repeat(4, minmax(0, 1fr));
            gap: 16px;
            margin-top: 20px;
        }

        .activity-lux-card {
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

        .activity-lux-card:hover {
            transform: translateY(-4px);
            box-shadow: 0 24px 55px rgba(15,23,42,0.12);
        }

        .activity-lux-card::after {
            content: "";
            position: absolute;
            width: 118px;
            height: 118px;
            top: -52px;
            right: -42px;
            border-radius: 999px;
            opacity: 0.15;
        }

        .activity-lux-card.total::after { background: #10b981; }
        .activity-lux-card.updated::after { background: #3b82f6; }
        .activity-lux-card.created::after { background: #f97316; }
        .activity-lux-card.deleted::after { background: #ef4444; }

        .activity-lux-label {
            margin: 0;
            color: #64748b;
            font-size: 13px;
            font-weight: 850;
        }

        .activity-lux-value {
            margin: 18px 0 0;
            color: #020617;
            font-size: 30px;
            line-height: 1;
            font-weight: 950;
            letter-spacing: -0.045em;
        }

        .activity-lux-caption {
            display: inline-flex;
            align-items: center;
            margin-top: 14px;
            border-radius: 999px;
            padding: 7px 11px;
            font-size: 12px;
            font-weight: 800;
        }

        .total .activity-lux-caption { background: #ecfdf5; color: #047857; }
        .updated .activity-lux-caption { background: #eff6ff; color: #1d4ed8; }
        .created .activity-lux-caption { background: #fff7ed; color: #c2410c; }
        .deleted .activity-lux-caption { background: #fef2f2; color: #b91c1c; }

        @media (max-width: 1100px) {
            .activity-lux-hero-top {
                flex-direction: column;
            }

            .activity-lux-grid {
                grid-template-columns: repeat(2, minmax(0, 1fr));
            }
        }

        @media (max-width: 700px) {
            .activity-lux-hero {
                padding: 24px;
                border-radius: 24px;
            }

            .activity-lux-title {
                font-size: 28px;
            }

            .activity-lux-grid {
                grid-template-columns: 1fr;
            }
        }
    </style>

    <div class="activity-lux-wrapper">
        <section class="activity-lux-hero">
            <div class="activity-lux-hero-top">
                <div>
                    <div class="activity-lux-badge">
                        <span class="activity-lux-dot"></span>
                        Ngunjuk POS Logger
                    </div>

                    <h2 class="activity-lux-title">
                        Activity Log Analytics
                    </h2>

                    <p class="activity-lux-desc">
                        Pantau seluruh aktivitas sistem seperti perubahan data produk,
                        order, kategori, user, role, serta riwayat aktivitas admin/karyawan
                        yang tercatat otomatis oleh sistem.
                    </p>
                </div>

                <div class="activity-lux-mini">
                    <span>User Teraktif</span>
                    <strong>{{ $summary['active_user'] }}</strong>
                    <small>{{ number_format($summary['active_user_logs'], 0, ',', '.') }} aktivitas</small>
                </div>
            </div>
        </section>

        <div class="activity-lux-grid">
            <div class="activity-lux-card total">
                <p class="activity-lux-label">Total Logs</p>
                <p class="activity-lux-value">{{ number_format($summary['total_logs'], 0, ',', '.') }}</p>
                <p class="activity-lux-caption">Semua aktivitas</p>
            </div>

            <div class="activity-lux-card updated">
                <p class="activity-lux-label">Updated Logs</p>
                <p class="activity-lux-value">{{ number_format($summary['updated_logs'], 0, ',', '.') }}</p>
                <p class="activity-lux-caption">Data diperbarui</p>
            </div>

            <div class="activity-lux-card created">
                <p class="activity-lux-label">Created Logs</p>
                <p class="activity-lux-value">{{ number_format($summary['created_logs'], 0, ',', '.') }}</p>
                <p class="activity-lux-caption">Data dibuat</p>
            </div>

            <div class="activity-lux-card deleted">
                <p class="activity-lux-label">Deleted Logs</p>
                <p class="activity-lux-value">{{ number_format($summary['deleted_logs'], 0, ',', '.') }}</p>
                <p class="activity-lux-caption">Data dihapus</p>
            </div>
        </div>
    </div>
</x-filament-widgets::widget>
