<x-filament-widgets::widget>
    <div class="ng-activity-widget">
        <section class="ng-activity-widget-hero-grid">
            <article class="ng-widget-card ng-activity-widget-hero-card">
                <div class="ng-widget-head">
                    <div>
                        <span class="ng-kicker">
                            Ngunjuk POS Logger
                        </span>

                        <h2>Activity Log Analytics</h2>

                        <p>
                            Pantau seluruh aktivitas sistem seperti perubahan data produk, order, kategori,
                            user, role, serta riwayat aktivitas admin/karyawan yang tercatat otomatis oleh sistem.
                        </p>
                    </div>
                </div>
            </article>

            <article class="ng-widget-card ng-activity-widget-highlight-card">
                <span>User Teraktif</span>

                <strong>
                    {{ $summary['active_user'] ?? ($summary['top_user'] ?? '-') }}
                </strong>

                <small>
                    {{ number_format((int) ($summary['active_user_logs'] ?? ($summary['top_user_total'] ?? 0)), 0, ',', '.') }}
                    aktivitas
                </small>
            </article>
        </section>

        <section class="ng-kpi-grid ng-activity-widget-kpi-grid">
            <article class="ng-kpi-card" style="--accent:#f97316;">
                <div class="ng-kpi-icon">▣</div>

                <div class="ng-kpi-content">
                    <div class="ng-kpi-label">
                        Total Logs
                        <span>⋮</span>
                    </div>

                    <strong>{{ number_format((int) ($summary['total_logs'] ?? 0), 0, ',', '.') }}</strong>
                    <p>Semua aktivitas</p>
                </div>
            </article>

            <article class="ng-kpi-card" style="--accent:#3b82f6;">
                <div class="ng-kpi-icon">↗</div>

                <div class="ng-kpi-content">
                    <div class="ng-kpi-label">
                        Updated Logs
                        <span>⋮</span>
                    </div>

                    <strong>{{ number_format((int) ($summary['updated_logs'] ?? 0), 0, ',', '.') }}</strong>
                    <p>Data diperbarui</p>
                </div>
            </article>

            <article class="ng-kpi-card" style="--accent:#10b981;">
                <div class="ng-kpi-icon">✓</div>

                <div class="ng-kpi-content">
                    <div class="ng-kpi-label">
                        Created Logs
                        <span>⋮</span>
                    </div>

                    <strong>{{ number_format((int) ($summary['created_logs'] ?? 0), 0, ',', '.') }}</strong>
                    <p>Data dibuat</p>
                </div>
            </article>

            <article class="ng-kpi-card" style="--accent:#ef4444;">
                <div class="ng-kpi-icon">!</div>

                <div class="ng-kpi-content">
                    <div class="ng-kpi-label">
                        Deleted Logs
                        <span>⋮</span>
                    </div>

                    <strong>{{ number_format((int) ($summary['deleted_logs'] ?? 0), 0, ',', '.') }}</strong>
                    <p>Data dihapus</p>
                </div>
            </article>
        </section>
    </div>

    <style>
        body:has(.ng-activity-widget) .fi-wi,
        body:has(.ng-activity-widget) .fi-wi-widget,
        body:has(.ng-activity-widget) .fi-wi-widget-content,
        body:has(.ng-activity-widget) .fi-wi-widgets,
        body:has(.ng-activity-widget) .fi-wi-widgets > * {
            margin: 0 !important;
            padding: 0 !important;
            background: transparent !important;
            border: none !important;
            box-shadow: none !important;
        }

        .ng-activity-widget {
            width: 100% !important;
            max-width: 100% !important;
            padding: 24px 24px 10px !important;
            overflow: hidden !important;
            font-family: Inter, Poppins, ui-sans-serif, system-ui, -apple-system, BlinkMacSystemFont, "Segoe UI", sans-serif;
            color: #24180f;
        }

        .ng-activity-widget * {
            box-sizing: border-box;
        }

        .ng-activity-widget-hero-grid {
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

        .ng-activity-widget-hero-card,
        .ng-activity-widget-highlight-card {
            min-height: 126px;
        }

        .ng-activity-widget-hero-card {
            display: flex;
            align-items: center;
        }

        .ng-activity-widget-highlight-card {
            display: grid;
            align-content: center;
            gap: 8px;
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

        .ng-widget-head h2 {
            margin: 0;
            color: #21160d;
            font-size: 30px;
            line-height: 1.05;
            font-weight: 950;
            letter-spacing: -.04em;
        }

        .ng-widget-head p {
            max-width: 820px;
            margin: 8px 0 0;
            color: #765d45;
            font-size: 13px;
            line-height: 1.55;
            font-weight: 700;
        }

        .ng-activity-widget-highlight-card span,
        .ng-activity-widget-highlight-card small {
            position: relative;
            z-index: 2;
            display: block;
            color: #765d45;
            font-size: 11px;
            font-weight: 850;
        }

        .ng-activity-widget-highlight-card strong {
            position: relative;
            z-index: 2;
            display: block;
            color: #21160d;
            font-size: 22px;
            line-height: 1.1;
            font-weight: 950;
            overflow: hidden;
            white-space: nowrap;
            text-overflow: ellipsis;
        }

        .ng-kpi-grid {
            display: grid;
            grid-template-columns: repeat(4, minmax(0, 1fr));
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

        @media (max-width: 1500px) {
            .ng-activity-widget-hero-grid {
                grid-template-columns: 1fr;
            }

            .ng-kpi-grid {
                grid-template-columns: repeat(2, minmax(0, 1fr));
            }
        }

        @media (max-width: 700px) {
            .ng-kpi-grid {
                grid-template-columns: 1fr;
            }

            .ng-activity-widget {
                padding: 14px 14px 8px !important;
            }

            .ng-widget-head h2 {
                font-size: 26px;
            }

            .ng-widget-card {
                padding: 16px;
                border-radius: 22px;
            }
        }
    </style>
</x-filament-widgets::widget>
