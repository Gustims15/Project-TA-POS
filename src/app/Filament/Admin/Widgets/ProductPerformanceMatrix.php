<?php

declare(strict_types=1);

namespace App\Filament\Admin\Widgets;

use App\Filament\Admin\Widgets\Concerns\HasDashboardMetric;
use App\Models\OrderItem;
use Filament\Widgets\Widget;
use Illuminate\Support\Facades\DB;

class ProductPerformanceMatrix extends Widget
{
    use HasDashboardMetric;

    protected string $view = 'filament.admin.widgets.product-performance-matrix';

    protected int|string|array $columnSpan = [
        'default' => 1,
        'md' => 2,
        'xl' => 12,
    ];

    protected function getViewData(): array
    {
        $query = OrderItem::query()
            ->join('orders', 'order_items.order_id', '=', 'orders.id')
            ->where('orders.status', 'Selesai');

        $this->applyDashboardPeriodFilterToOrderQuery($query);

        $products = $query
            ->select([
                'order_items.product_name as product_name',
                DB::raw('SUM(order_items.quantity) as units_sold'),
                DB::raw('SUM(order_items.subtotal) as revenue'),
                DB::raw('COUNT(DISTINCT order_items.order_id) as orders_count'),
            ])
            ->groupBy('order_items.product_name')
            ->orderByDesc('revenue')
            ->limit(12)
            ->get();

        $maxUnits = max((float) $products->max('units_sold'), 1);
        $maxRevenue = max((float) $products->max('revenue'), 1);
        $maxOrders = max((int) $products->max('orders_count'), 1);

        $items = $products
            ->values()
            ->map(function ($product, int $index) use ($maxUnits, $maxRevenue, $maxOrders): array {
                $unitsSold = (float) $product->units_sold;
                $revenue = (float) $product->revenue;
                $ordersCount = (int) $product->orders_count;

                $x = ($unitsSold / $maxUnits) * 100;
                $y = 100 - (($revenue / $maxRevenue) * 100);
                $size = 12 + (($ordersCount / $maxOrders) * 22);

                $quadrant = $this->getQuadrantLabel($unitsSold, $revenue, $maxUnits, $maxRevenue);

                return [
                    'name' => (string) $product->product_name,
                    'short_name' => $this->shortenProductName((string) $product->product_name),
                    'units_sold' => $unitsSold,
                    'revenue' => $revenue,
                    'orders_count' => $ordersCount,
                    'formatted_units' => number_format((int) $unitsSold, 0, ',', '.') . ' item',
                    'formatted_revenue' => 'Rp ' . number_format((int) $revenue, 0, ',', '.'),
                    'formatted_orders' => number_format($ordersCount, 0, ',', '.') . ' order',
                    'x' => round(max(6, min($x, 94)), 2),
                    'y' => round(max(8, min($y, 88)), 2),
                    'size' => round(max(14, min($size, 36)), 2),
                    'quadrant' => $quadrant,

                    /*
                    |--------------------------------------------------------------------------
                    | Label Rules
                    |--------------------------------------------------------------------------
                    | Power BI style tidak harus menampilkan semua label.
                    | Label hanya ditampilkan untuk produk penting agar chart tidak terlalu penuh.
                    */
                    'show_label' => $index < 8 || in_array($quadrant, ['Star Product', 'Profit Driver'], true),
                ];
            })
            ->toArray();

        $bestProduct = collect($items)
            ->sortByDesc('revenue')
            ->first();

        return [
            'items' => $items,
            'periodLabel' => $this->getDashboardPeriodLabel(),
            'bestProductName' => $bestProduct['name'] ?? '-',
            'bestProductRevenue' => $bestProduct['formatted_revenue'] ?? 'Rp 0',
            'totalProductsAnalyzed' => count($items),
        ];
    }

    private function getQuadrantLabel(float $units, float $revenue, float $maxUnits, float $maxRevenue): string
    {
        $isHighUnits = $units >= ($maxUnits * 0.5);
        $isHighRevenue = $revenue >= ($maxRevenue * 0.5);

        if ($isHighUnits && $isHighRevenue) {
            return 'Star Product';
        }

        if ($isHighUnits && ! $isHighRevenue) {
            return 'Fast Moving Low Value';
        }

        if (! $isHighUnits && $isHighRevenue) {
            return 'Profit Driver';
        }

        return 'Underperformer';
    }

    private function shortenProductName(string $name): string
    {
        $name = trim($name);

        if (mb_strlen($name) <= 14) {
            return $name;
        }

        return mb_substr($name, 0, 13) . '…';
    }
}