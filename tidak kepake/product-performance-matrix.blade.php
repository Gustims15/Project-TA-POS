<x-filament-widgets::widget>
    <div class="pbi-widget-card product-performance-matrix">
        <div class="pbi-widget-inner">
            <div class="pbi-widget-header">
                <div>
                    <h3 class="pbi-widget-title">Top Product Ranking</h3>
                    <div class="pbi-widget-subtitle">
                        Ranking produk terbaik berdasarkan {{ strtolower($activeMetricLabel ?? 'metric') }}.
                    </div>
                </div>

                <span class="pbi-chip" style="color:#c2410c;background:#fff7ed;border-color:#fed7aa;">
                    Metric: {{ $activeMetricLabel ?? 'Metric' }}
                </span>
            </div>

            <div class="pbi-summary-grid" style="grid-template-columns:repeat(3,minmax(0,1fr));">
                <div class="pbi-summary-box">
                    <div class="pbi-summary-label">Best product</div>
                    <div class="pbi-summary-value" style="font-size:13px;white-space:nowrap;overflow:hidden;text-overflow:ellipsis;">
                        {{ $bestProductName ?? '-' }}
                    </div>
                </div>

                <div class="pbi-summary-box">
                    <div class="pbi-summary-label">Top value</div>
                    <div class="pbi-summary-value" style="font-size:13px;">
                        {{ $bestProductValue ?? '-' }}
                    </div>
                </div>

                <div class="pbi-summary-box">
                    <div class="pbi-summary-label">Products analyzed</div>
                    <div class="pbi-summary-value" style="font-size:13px;">
                        {{ $totalProductsAnalyzed ?? 0 }} produk
                    </div>
                </div>
            </div>

            <div class="product-ranking-list" style="display:grid;gap:7px;">
                @forelse (($items ?? []) as $item)
                    <div class="product-ranking-item" style="display:grid;grid-template-columns:36px minmax(0,1fr) auto;gap:10px;align-items:center;padding:9px 10px;border-radius:14px;background:#ffffff;border:1px solid rgba(226,232,240,.88);">
                        <div style="width:30px;height:30px;display:flex;align-items:center;justify-content:center;border-radius:10px;background:#ffedd5;color:#c2410c;font-size:10px;font-weight:950;">
                            #{{ $item['rank'] ?? '-' }}
                        </div>

                        <div style="min-width:0;">
                            <div class="title" style="color:#0f172a;font-size:12px;font-weight:950;white-space:nowrap;overflow:hidden;text-overflow:ellipsis;">
                                {{ $item['name'] ?? '-' }}
                            </div>

                            <div class="meta" style="margin-top:2px;color:#64748b;font-size:10px;font-weight:800;white-space:nowrap;overflow:hidden;text-overflow:ellipsis;">
                                {{ $item['revenue_formatted'] ?? '-' }}
                                <span style="color:#cbd5e1;">•</span>
                                {{ $item['units_formatted'] ?? '-' }}
                                <span style="color:#cbd5e1;">•</span>
                                {{ $item['orders_formatted'] ?? '-' }}
                            </div>

                            <div class="product-bar" style="height:7px;margin-top:6px;border-radius:999px;background:#e2e8f0;overflow:hidden;">
                                <div style="width:{{ $item['bar_width'] ?? 0 }}%;height:100%;border-radius:999px;background:linear-gradient(90deg,#fb923c,#22c55e);"></div>
                            </div>
                        </div>

                        <div style="min-width:96px;text-align:right;">
                            <div class="amount" style="color:#0f172a;font-size:12px;font-weight:950;">
                                {{ $item['metric_formatted'] ?? '-' }}
                            </div>
                            <div style="margin-top:2px;color:#94a3b8;font-size:10px;font-weight:900;">
                                {{ number_format($item['contribution'] ?? 0, 1, ',', '.') }}% kontribusi
                            </div>
                        </div>
                    </div>
                @empty
                    <div style="border-radius:14px;padding:18px;background:#f8fafc;border:1px dashed #cbd5e1;text-align:center;color:#64748b;font-size:12px;font-weight:800;">
                        Belum ada data produk pada periode ini.
                    </div>
                @endforelse
            </div>
        </div>
    </div>
</x-filament-widgets::widget>