<?php

declare(strict_types=1);

namespace App\Filament\Admin\Widgets;

use App\Filament\Admin\Widgets\Concerns\HasDashboardMetric;
use App\Models\OrderItem;
use Filament\Widgets\Widget;
use Illuminate\Support\Facades\DB;

class CategoryContributionChart extends Widget
{
    use HasDashboardMetric;

    protected string $view = 'filament.admin.widgets.category-contribution-chart';

    protected int|string|array $columnSpan = [
        'default' => 1,
        'md' => 1,
        'xl' => 6,
    ];

    protected function getViewData(): array
    {
        $metric = $this->getDashboardMetric();

        $metricSelect = match ($metric) {
            'orders' => DB::raw('COUNT(DISTINCT order_items.order_id) as metric_total'),
            'revenue' => DB::raw('SUM(order_items.subtotal) as metric_total'),
            'units' => DB::raw('SUM(order_items.quantity) as metric_total'),
            default => DB::raw('SUM(order_items.quantity) as metric_total'),
        };

        $query = OrderItem::query()
            ->join('products', 'order_items.product_id', '=', 'products.id')
            ->join('categories', 'products.category_id', '=', 'categories.id')
            ->join('orders', 'order_items.order_id', '=', 'orders.id')
            ->where('orders.status', 'Selesai');

        $this->applyDashboardPeriodFilterToOrderQuery($query);

        $categories = $query
            ->select([
                'categories.name as name',
                $metricSelect,
            ])
            ->groupBy('categories.id', 'categories.name')
            ->orderByDesc('metric_total')
            ->limit(8)
            ->get();

        $maxValue = max((float) $categories->max('metric_total'), 1);
        $totalValue = max((float) $categories->sum('metric_total'), 1);

        $items = $categories
            ->values()
            ->map(function ($category) use ($maxValue, $totalValue): array {
                $value = (float) $category->metric_total;

                return [
                    'name' => (string) $category->name,
                    'value' => $value,
                    'formatted' => $this->formatMetricValue($value),
                    'width' => round(($value / $maxValue) * 100, 2),
                    'share' => round(($value / $totalValue) * 100, 1),
                ];
            })
            ->toArray();

        return [
            'items' => $items,
            'metricLabel' => $this->getDashboardMetricLabel(),
            'periodLabel' => $this->getDashboardPeriodLabel(),
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