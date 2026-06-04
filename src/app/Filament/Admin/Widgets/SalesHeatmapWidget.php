<?php

declare(strict_types=1);

namespace App\Filament\Admin\Widgets;

use App\Filament\Admin\Widgets\Concerns\HasDashboardMetric;
use App\Models\Order;
use Filament\Widgets\Widget;
use Illuminate\Support\Facades\DB;

class SalesHeatmapWidget extends Widget
{
    use HasDashboardMetric;

    protected string $view = 'filament.admin.widgets.sales-heatmap-widget';

    protected int|string|array $columnSpan = [
        'default' => 1,
        'md' => 2,
        'xl' => 8,
    ];

    protected function getViewData(): array
    {
        $days = [];
        $hours = range(8, 22);
        $matrix = [];

        $startOfWeek = now()->copy()->startOfWeek();

        for ($dayIndex = 0; $dayIndex < 7; $dayIndex++) {
            $day = $startOfWeek->copy()->addDays($dayIndex);

            $days[] = [
                'label' => $day->format('D'),
                'date' => $day,
            ];
        }

        $maxValue = 1;
        $peakCell = null;
        $quietCell = null;

        foreach ($days as $day) {
            $row = [];

            foreach ($hours as $hour) {
                $start = $day['date']->copy()->setHour($hour)->startOfHour();
                $end = $day['date']->copy()->setHour($hour)->endOfHour();

                $query = Order::query()
                    ->where('status', 'Selesai')
                    ->whereBetween(
                        DB::raw('COALESCE(ordered_at, created_at)'),
                        [$start, $end]
                    );

                $value = match ($this->getDashboardMetric()) {
                    'orders' => (int) $query->count(),
                    'revenue' => (int) $query->sum('total_price'),
                    'units' => (int) $query->sum('total_item'),
                    default => (int) $query->sum('total_item'),
                };

                $maxValue = max($maxValue, $value);

                $cell = [
                    'day' => $day['label'],
                    'hour' => str_pad((string) $hour, 2, '0', STR_PAD_LEFT) . ':00',
                    'value' => $value,
                    'label' => $this->formatMetricValue($value),
                    'intensity' => 0,
                ];

                if ($peakCell === null || $value > $peakCell['value']) {
                    $peakCell = $cell;
                }

                if ($quietCell === null || $value < $quietCell['value']) {
                    $quietCell = $cell;
                }

                $row[] = $cell;
            }

            $matrix[] = [
                'day' => $day['label'],
                'cells' => $row,
            ];
        }

        foreach ($matrix as $rowIndex => $row) {
            foreach ($row['cells'] as $cellIndex => $cell) {
                $matrix[$rowIndex]['cells'][$cellIndex]['intensity'] = $maxValue > 0
                    ? round(($cell['value'] / $maxValue) * 100)
                    : 0;
            }
        }

        return [
            'periodLabel' => $this->getDashboardPeriodLabel(),
            'metricLabel' => $this->getDashboardMetricLabel(),
            'hours' => array_map(
                fn (int $hour): string => str_pad((string) $hour, 2, '0', STR_PAD_LEFT),
                $hours
            ),
            'matrix' => $matrix,
            'insights' => [
                'peak_day' => $peakCell['day'] ?? '-',
                'peak_hour' => $peakCell['hour'] ?? '-',
                'peak_value' => isset($peakCell['value']) ? $this->formatMetricValue($peakCell['value']) : '-',
                'quiet_day' => $quietCell['day'] ?? '-',
                'quiet_hour' => $quietCell['hour'] ?? '-',
            ],
        ];
    }

    private function formatMetricValue(int|float $value): string
    {
        return match ($this->getDashboardMetric()) {
            'revenue' => 'Rp ' . number_format((int) $value, 0, ',', '.'),
            'orders' => number_format((int) $value, 0, ',', '.') . ' order',
            'units' => number_format((int) $value, 0, ',', '.') . ' item',
            default => number_format((int) $value, 0, ',', '.') . ' item',
        };
    }
}