<?php

declare(strict_types=1);

namespace App\Filament\Admin\Widgets;

use App\Filament\Admin\Widgets\Concerns\HasDashboardMetric;
use App\Models\Order;
use Filament\Widgets\Widget;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\DB;

class SalesHeatmapWidget extends Widget
{
    use HasDashboardMetric;

    protected string $view = 'filament.admin.widgets.sales-heatmap-widget';

    protected int|string|array $columnSpan = [
        'default' => 1,
        'md' => 6,
        'xl' => 12,
    ];

    protected function getViewData(): array
    {
        $metric = $this->getDashboardMetric();

        /*
         * Jam dibuat tetap dari 08.00 - 22.00.
         * Ini cocok untuk POS minuman dan tetap compact.
         */
        $hours = range(4, 16);

        $days = $this->getCurrentWeekDays();

        $startOfWeek = now()->copy()->startOfWeek()->startOfDay();
        $endOfWeek = now()->copy()->endOfWeek()->endOfDay();

        $rows = $this->getAggregatedHeatmapRows($metric, $startOfWeek, $endOfWeek);
        $keyedRows = $this->keyHeatmapRows($rows);

        $matrix = [];
        $maxValue = 1;
        $totalValue = 0;

        $peakCell = null;
        $quietCell = null;

        foreach ($days as $day) {
            $cells = [];

            foreach ($hours as $hour) {
                $key = $day['date_key'] . '-' . $hour;
                $value = (float) ($keyedRows[$key] ?? 0);

                $cell = [
                    'day' => $day['label'],
                    'date_key' => $day['date_key'],
                    'hour' => str_pad((string) $hour, 2, '0', STR_PAD_LEFT) . ':00',
                    'value' => $value,
                    'label' => $this->formatMetricValue($metric, $value),
                    'intensity' => 0,
                ];

                $maxValue = max($maxValue, $value);
                $totalValue += $value;

                if ($peakCell === null || $value > $peakCell['value']) {
                    $peakCell = $cell;
                }

                if ($quietCell === null || $value < $quietCell['value']) {
                    $quietCell = $cell;
                }

                $cells[] = $cell;
            }

            $matrix[] = [
                'day' => $day['label'],
                'cells' => $cells,
            ];
        }

        foreach ($matrix as $rowIndex => $row) {
            foreach ($row['cells'] as $cellIndex => $cell) {
                $matrix[$rowIndex]['cells'][$cellIndex]['intensity'] = $maxValue > 0
                    ? round(((float) $cell['value'] / $maxValue) * 100)
                    : 0;
            }
        }

        return [
            'metricLabel' => $this->getDashboardMetricLabel(),
            'weekLabel' => $startOfWeek->format('d M') . ' - ' . $endOfWeek->format('d M Y'),
            'hours' => array_map(
                fn (int $hour): string => str_pad((string) $hour, 2, '0', STR_PAD_LEFT),
                $hours,
            ),
            'matrix' => $matrix,
            'totalValue' => $this->formatMetricValue($metric, $totalValue),
            'insights' => [
                'peak_day' => $peakCell['day'] ?? '-',
                'peak_hour' => $peakCell['hour'] ?? '-',
                'peak_value' => isset($peakCell['value'])
                    ? $this->formatMetricValue($metric, $peakCell['value'])
                    : '-',
                'quiet_day' => $quietCell['day'] ?? '-',
                'quiet_hour' => $quietCell['hour'] ?? '-',
            ],
        ];
    }

    private function getCurrentWeekDays(): array
    {
        $labels = ['Sen', 'Sel', 'Rab', 'Kam', 'Jum', 'Sab', 'Min'];

        $startOfWeek = now()->copy()->startOfWeek();
        $days = [];

        for ($dayIndex = 0; $dayIndex < 7; $dayIndex++) {
            $date = $startOfWeek->copy()->addDays($dayIndex);

            $days[] = [
                'label' => $labels[$dayIndex],
                'date_key' => $date->format('Y-m-d'),
            ];
        }

        return $days;
    }

    private function getAggregatedHeatmapRows(string $metric, Carbon $start, Carbon $end)
    {
        $aggregateSelect = match ($metric) {
            'orders' => 'COUNT(*) as metric_total',
            'revenue' => 'SUM(total_price) as metric_total',
            'units' => 'SUM(total_item) as metric_total',
            default => 'SUM(total_item) as metric_total',
        };

        return Order::query()
            ->where('status', 'Selesai')
            ->whereBetween(DB::raw('COALESCE(ordered_at, created_at)'), [$start, $end])
            ->selectRaw('DATE(COALESCE(ordered_at, created_at)) as order_date')
            ->selectRaw('HOUR(COALESCE(ordered_at, created_at)) as order_hour')
            ->selectRaw($aggregateSelect)
            ->groupBy('order_date', 'order_hour')
            ->get();
    }

    private function keyHeatmapRows($rows): array
    {
        $keyed = [];

        foreach ($rows as $row) {
            $keyed[$row->order_date . '-' . (int) $row->order_hour] = (float) $row->metric_total;
        }

        return $keyed;
    }

    private function formatMetricValue(string $metric, int|float $value): string
    {
        return match ($metric) {
            'revenue' => $this->formatRupiah((int) $value),
            'orders' => number_format((int) $value, 0, ',', '.') . ' order',
            'units' => number_format((int) $value, 0, ',', '.') . ' item',
            default => number_format((int) $value, 0, ',', '.') . ' item',
        };
    }

    private function formatRupiah(int $value): string
    {
        return 'Rp ' . number_format($value, 0, ',', '.');
    }
}