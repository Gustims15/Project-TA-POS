<x-filament-widgets::widget>
    <div class="pbi-widget-card restock-priority-chart">
        <div class="pbi-widget-inner">
            <div class="pbi-widget-header">
                <div>
                    <h3 class="pbi-widget-title">Low Stock Alert</h3>
                    <div class="pbi-widget-subtitle">
                        Produk dengan stok rendah agar restock tidak terlambat.
                    </div>
                </div>

                <span class="pbi-chip" style="color:#be123c;background:#fff1f2;border-color:#fecdd3;">
                    Stock Risk
                </span>
            </div>

            <div class="pbi-summary-grid" style="grid-template-columns:repeat(2,minmax(0,1fr));">
                <div class="pbi-summary-box">
                    <div class="pbi-summary-label">Risk products</div>
                    <div class="pbi-summary-value">{{ $riskProducts ?? 0 }}</div>
                </div>

                <div class="pbi-summary-box">
                    <div class="pbi-summary-label">Total products</div>
                    <div class="pbi-summary-value">{{ $totalProducts ?? 0 }}</div>
                </div>
            </div>

            <div style="height:9px;border-radius:999px;background:#e2e8f0;overflow:hidden;margin-bottom:9px;display:flex;">
                @foreach (($distribution ?? []) as $dist)
                    @php
                        $color = match ($dist['class'] ?? '') {
                            'safe' => '#22c55e',
                            'warning' => '#f59e0b',
                            'low' => '#fb923c',
                            'critical' => '#ef4444',
                            default => '#94a3b8',
                        };
                    @endphp

                    <div
                        title="{{ $dist['label'] ?? '-' }}: {{ $dist['count'] ?? 0 }}"
                        style="height:100%;width:{{ $dist['width'] ?? 0 }}%;background:{{ $color }};"
                    ></div>
                @endforeach
            </div>

            <div style="display:grid;grid-template-columns:repeat(4,minmax(0,1fr));gap:7px;margin-bottom:10px;">
                @foreach (($distribution ?? []) as $dist)
                    <div style="border-radius:12px;padding:8px;background:#ffffff;border:1px solid rgba(226,232,240,.9);">
                        <div style="color:#64748b;font-size:9px;font-weight:900;white-space:nowrap;overflow:hidden;text-overflow:ellipsis;">
                            {{ $dist['label'] ?? '-' }}
                        </div>
                        <div style="margin-top:3px;color:#0f172a;font-size:13px;font-weight:950;">
                            {{ $dist['count'] ?? 0 }}
                        </div>
                    </div>
                @endforeach
            </div>

            <div class="low-stock-list" style="display:grid;gap:7px;">
                @forelse (($items ?? []) as $item)
                    @php
                        $statusClass = $item['statusClass'] ?? 'warning';

                        $statusColor = match ($statusClass) {
                            'critical' => '#ef4444',
                            'low' => '#f97316',
                            'warning' => '#f59e0b',
                            default => '#64748b',
                        };

                        $statusBg = match ($statusClass) {
                            'critical' => '#fff1f2',
                            'low' => '#fff7ed',
                            'warning' => '#fef9c3',
                            default => '#f8fafc',
                        };
                    @endphp

                    <div class="low-stock-item" style="padding:9px 10px;border-radius:14px;background:#ffffff;border:1px solid rgba(226,232,240,.88);">
                        <div style="display:flex;align-items:center;justify-content:space-between;gap:8px;">
                            <div style="min-width:0;">
                                <div class="title" style="color:#0f172a;font-size:12px;font-weight:950;white-space:nowrap;overflow:hidden;text-overflow:ellipsis;">
                                    {{ $item['name'] ?? '-' }}
                                </div>
                                <div class="meta" style="margin-top:2px;color:#64748b;font-size:10px;font-weight:800;">
                                    Sisa stok {{ $item['stock'] ?? 0 }}/{{ $item['safeLimit'] ?? $safeLimit ?? 10 }}
                                </div>
                            </div>

                            <span style="border-radius:999px;padding:4px 7px;background:{{ $statusBg }};color:{{ $statusColor }};font-size:9px;font-weight:950;">
                                {{ $item['status'] ?? '-' }}
                            </span>
                        </div>

                        <div class="low-stock-progress" style="height:7px;margin-top:7px;border-radius:999px;background:#e2e8f0;overflow:hidden;">
                            <div style="width:{{ $item['width'] ?? 0 }}%;height:100%;border-radius:999px;background:{{ $statusColor }};"></div>
                        </div>
                    </div>
                @empty
                    <div style="border-radius:14px;padding:16px;background:#f0fdf4;border:1px dashed #bbf7d0;text-align:center;color:#047857;font-size:12px;font-weight:900;">
                        Semua stok masih aman.
                    </div>
                @endforelse
            </div>
        </div>
    </div>
</x-filament-widgets::widget>