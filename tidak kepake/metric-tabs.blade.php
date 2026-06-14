<x-filament-widgets::widget>
    <style>
        .metric-lux-card {
            overflow: hidden;
            border-radius: 28px;
            background: white;
            border: 1px solid rgba(226,232,240,0.95);
            box-shadow: 0 18px 45px rgba(15, 23, 42, 0.08);
        }

        .metric-lux-header {
            padding: 22px 26px;
            border-bottom: 1px solid #e2e8f0;
            background:
                linear-gradient(135deg, rgba(15,118,110,0.08), transparent 45%),
                linear-gradient(90deg, #ffffff, #f8fafc);
        }

        .metric-lux-title {
            margin: 0;
            color: #020617;
            font-size: 20px;
            font-weight: 950;
            letter-spacing: -0.03em;
        }

        .metric-lux-desc {
            margin: 7px 0 0;
            color: #64748b;
            font-size: 13px;
        }

        .metric-lux-body {
            padding: 20px;
            display: grid;
            grid-template-columns: repeat(3, minmax(0, 1fr));
            gap: 14px;
        }

        .metric-lux-item {
            display: flex;
            flex-direction: column;
            justify-content: center;
            min-height: 84px;
            border-radius: 20px;
            padding: 18px;
            text-decoration: none;
            border: 1px solid #e2e8f0;
            background: #ffffff;
            transition: 0.25s ease;
        }

        .metric-lux-item:hover {
            transform: translateY(-3px);
            box-shadow: 0 18px 36px rgba(15,23,42,0.10);
        }

        .metric-lux-item.active {
            background: linear-gradient(135deg, #0f766e, #0d9488);
            border-color: #0f766e;
            box-shadow: 0 18px 40px rgba(15,118,110,0.24);
        }

        .metric-lux-label {
            color: #0f172a;
            font-size: 14px;
            font-weight: 950;
            text-transform: uppercase;
            letter-spacing: 0.06em;
            text-align: center;
        }

        .metric-lux-item.active .metric-lux-label {
            color: white;
        }

        .metric-lux-description {
            margin-top: 7px;
            color: #64748b;
            font-size: 12px;
            font-weight: 750;
            text-align: center;
        }

        .metric-lux-item.active .metric-lux-description {
            color: #ccfbf1;
        }

        @media (max-width: 900px) {
            .metric-lux-body {
                grid-template-columns: 1fr;
            }
        }
    </style>

    <div class="metric-lux-card">
        <div class="metric-lux-header">
            <h3 class="metric-lux-title">
                Dashboard Metric
            </h3>

            <p class="metric-lux-desc">
                Pilih metric utama untuk mengubah seluruh visualisasi dashboard.
            </p>
        </div>

        <div class="metric-lux-body">
            @foreach ($metrics as $key => $metric)
                @php
                    $isActive = $activeMetric === $key;

                    $url = url('/admin') . '?' . http_build_query([
                        'metric' => $key,
                    ]);
                @endphp

                <a
                    href="{{ $url }}"
                    class="metric-lux-item {{ $isActive ? 'active' : '' }}"
                >
                    <span class="metric-lux-label">
                        {{ $metric['label'] }}
                    </span>

                    <span class="metric-lux-description">
                        {{ $metric['description'] }}
                    </span>
                </a>
            @endforeach
        </div>
    </div>
</x-filament-widgets::widget>
