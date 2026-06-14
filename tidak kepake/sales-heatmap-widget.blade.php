<x-filament-widgets::widget>
    <div class="pbi-widget-card sales-heatmap-widget heatmap-card">
        <div class="pbi-widget-inner">
            <div class="pbi-widget-header">
                <div>
                    <h3 class="pbi-widget-title">Sales Heatmap</h3>
                    <div class="pbi-widget-subtitle">
                        Intensitas {{ strtolower($metricLabel ?? 'metric') }} berdasarkan hari dan jam operasional.
                    </div>
                </div>

                <span class="pbi-chip">
                    {{ $weekLabel ?? '-' }}
                </span>
            </div>

            <div class="heatmap-summary" style="display:grid;grid-template-columns:repeat(4,minmax(0,1fr));gap:8px;margin-bottom:10px;">
                <div class="pbi-summary-box" style="min-height:54px;">
                    <div class="pbi-summary-label">Peak day</div>
                    <div class="pbi-summary-value" style="font-size:13px;">{{ $insights['peak_day'] ?? '-' }}</div>
                </div>

                <div class="pbi-summary-box" style="min-height:54px;">
                    <div class="pbi-summary-label">Peak hour</div>
                    <div class="pbi-summary-value" style="font-size:13px;">{{ $insights['peak_hour'] ?? '-' }}</div>
                </div>

                <div class="pbi-summary-box" style="min-height:54px;">
                    <div class="pbi-summary-label">Peak value</div>
                    <div class="pbi-summary-value" style="font-size:13px;">{{ $insights['peak_value'] ?? '-' }}</div>
                </div>

                <div class="pbi-summary-box" style="min-height:54px;">
                    <div class="pbi-summary-label">Total metric</div>
                    <div class="pbi-summary-value" style="font-size:13px;">{{ $totalValue ?? '-' }}</div>
                </div>
            </div>

            <div class="heatmap-grid" style="max-height:230px;overflow:auto;border-radius:16px;background:#ffffff;border:1px solid rgba(226,232,240,.92);padding:10px;">
                <div style="display:grid;grid-template-columns:42px repeat({{ count($hours ?? []) }}, minmax(38px, 1fr));gap:6px;align-items:center;min-width:760px;">
                    <div></div>

                    @foreach (($hours ?? []) as $hour)
                        <div style="text-align:center;color:#64748b;font-size:10px;font-weight:950;">
                            {{ $hour }}
                        </div>
                    @endforeach

                    @foreach (($matrix ?? []) as $row)
                        <div style="color:#0f172a;font-size:10px;font-weight:950;">
                            {{ $row['day'] ?? '-' }}
                        </div>

                        @foreach (($row['cells'] ?? []) as $cell)
                            @php
                                $intensity = (int) ($cell['intensity'] ?? 0);

                                if ($intensity >= 80) {
                                    $bg = '#f97316';
                                    $text = '#ffffff';
                                } elseif ($intensity >= 55) {
                                    $bg = '#fdba74';
                                    $text = '#7c2d12';
                                } elseif ($intensity >= 30) {
                                    $bg = '#bbf7d0';
                                    $text = '#064e3b';
                                } elseif ($intensity > 0) {
                                    $bg = '#dcfce7';
                                    $text = '#166534';
                                } else {
                                    $bg = '#f1f5f9';
                                    $text = '#94a3b8';
                                }
                            @endphp

                            <div
                                title="{{ $cell['day'] ?? '-' }} {{ $cell['hour'] ?? '-' }} : {{ $cell['label'] ?? '-' }}"
                                class="heatmap-cell"
                                style="height:26px;border-radius:8px;background:{{ $bg }};color:{{ $text }};display:flex;align-items:center;justify-content:center;font-size:9px;font-weight:950;"
                            >
                                @if (($cell['value'] ?? 0) > 0)
                                    {{ number_format($cell['value'], 0, ',', '.') }}
                                @endif
                            </div>
                        @endforeach
                    @endforeach
                </div>
            </div>
        </div>
    </div>
</x-filament-widgets::widget>