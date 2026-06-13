<x-filament-widgets::widget>
    <div class="pbi-widget-card category-contribution-chart">
        <div class="pbi-widget-inner">
            <div class="pbi-widget-header">
                <div>
                    <h3 class="pbi-widget-title">Category Contribution</h3>
                    <div class="pbi-widget-subtitle">
                        Kontribusi kategori berdasarkan {{ strtolower($metricLabel ?? 'metric') }}.
                    </div>
                </div>

                <span class="pbi-chip" style="color:#c2410c;background:#fff7ed;border-color:#fed7aa;">
                    {{ $metricLabel ?? 'Metric' }}
                </span>
            </div>

            <div style="display:grid;grid-template-columns:130px minmax(0,1fr);gap:12px;align-items:center;">
                <div style="position:relative;width:130px;height:130px;margin:auto;">
                    @php
                        $segments = $items ?? [];
                        $colors = ['#f97316', '#16a34a', '#2563eb', '#8b5cf6', '#e11d48'];
                        $offset = 25;
                    @endphp

                    <svg viewBox="0 0 42 42" style="width:130px;height:130px;transform:rotate(-90deg);">
                        <circle
                            cx="21"
                            cy="21"
                            r="15.915"
                            fill="transparent"
                            stroke="#e2e8f0"
                            stroke-width="7"
                        />

                        @foreach ($segments as $index => $item)
                            @php
                                $share = (float) ($item['share'] ?? 0);
                                $color = $colors[$index % count($colors)];
                            @endphp

                            <circle
                                cx="21"
                                cy="21"
                                r="15.915"
                                fill="transparent"
                                stroke="{{ $color }}"
                                stroke-width="7"
                                stroke-dasharray="{{ $share }} {{ 100 - $share }}"
                                stroke-dashoffset="{{ $offset }}"
                                stroke-linecap="butt"
                            />

                            @php
                                $offset -= $share;
                            @endphp
                        @endforeach
                    </svg>

                    <div style="position:absolute;inset:0;display:flex;flex-direction:column;align-items:center;justify-content:center;text-align:center;">
                        <span style="color:#94a3b8;font-size:9px;font-weight:900;letter-spacing:.08em;text-transform:uppercase;">
                            Top Share
                        </span>
                        <strong style="color:#0f172a;font-size:22px;font-weight:950;letter-spacing:-.06em;line-height:1;">
                            {{ number_format($topCategoryShare ?? 0, 1, ',', '.') }}%
                        </strong>
                        <span style="max-width:88px;overflow:hidden;text-overflow:ellipsis;white-space:nowrap;color:#64748b;font-size:10px;font-weight:900;">
                            {{ $topCategoryName ?? '-' }}
                        </span>
                    </div>
                </div>

                <div style="display:grid;gap:7px;">
                    <div style="display:grid;grid-template-columns:1fr 1fr;gap:8px;margin-bottom:2px;">
                        <div class="pbi-summary-box" style="min-height:54px;">
                            <div class="pbi-summary-label">Top category</div>
                            <div class="pbi-summary-value" style="font-size:13px;white-space:nowrap;overflow:hidden;text-overflow:ellipsis;">
                                {{ $topCategoryName ?? '-' }}
                            </div>
                        </div>

                        <div class="pbi-summary-box" style="min-height:54px;">
                            <div class="pbi-summary-label">Total value</div>
                            <div class="pbi-summary-value" style="font-size:13px;">
                                {{ $totalCategoryValue ?? '-' }}
                            </div>
                        </div>
                    </div>

                    @forelse (($items ?? []) as $index => $item)
                        @php
                            $colors = ['#f97316', '#16a34a', '#2563eb', '#8b5cf6', '#e11d48'];
                            $color = $colors[$index % count($colors)];
                        @endphp

                        <div style="border-radius:13px;padding:8px;background:#ffffff;border:1px solid rgba(226,232,240,.9);">
                            <div style="display:flex;align-items:center;justify-content:space-between;gap:8px;">
                                <div style="display:flex;align-items:center;gap:7px;min-width:0;">
                                    <span style="width:8px;height:8px;border-radius:999px;background:{{ $color }};flex:0 0 auto;"></span>
                                    <strong style="color:#0f172a;font-size:11px;font-weight:900;white-space:nowrap;overflow:hidden;text-overflow:ellipsis;">
                                        {{ $item['name'] ?? '-' }}
                                    </strong>
                                </div>

                                <div style="text-align:right;flex:0 0 auto;">
                                    <div style="color:#0f172a;font-size:11px;font-weight:950;">
                                        {{ $item['formatted'] ?? '-' }}
                                    </div>
                                    <div style="color:#94a3b8;font-size:9px;font-weight:900;">
                                        {{ number_format($item['share'] ?? 0, 1, ',', '.') }}%
                                    </div>
                                </div>
                            </div>

                            <div style="height:7px;margin-top:6px;border-radius:999px;background:#e2e8f0;overflow:hidden;">
                                <div style="width:{{ $item['width'] ?? 0 }}%;height:100%;border-radius:999px;background:{{ $color }};"></div>
                            </div>
                        </div>
                    @empty
                        <div style="border-radius:14px;padding:16px;background:#f8fafc;border:1px dashed #cbd5e1;text-align:center;color:#64748b;font-size:12px;font-weight:800;">
                            Belum ada data kategori.
                        </div>
                    @endforelse
                </div>
            </div>
        </div>
    </div>
</x-filament-widgets::widget>