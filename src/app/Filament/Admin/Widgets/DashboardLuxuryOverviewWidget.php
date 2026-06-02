<?php

declare(strict_types=1);

namespace App\Filament\Admin\Widgets;

use App\Models\Category;
use App\Models\Order;
use App\Models\Product;
use Filament\Widgets\Widget;
use Illuminate\Support\Facades\DB;

class DashboardLuxuryOverviewWidget extends Widget
{
    protected string $view = 'filament.admin.widgets.dashboard-luxury-overview-widget';

    protected int|string|array $columnSpan = 'full';

    protected function getViewData(): array
    {
        $todayStart = now()->startOfDay();
        $todayEnd = now()->endOfDay();

        $todayOrdersQuery = Order::query()
            ->where('status', 'Selesai')
            ->whereBetween(DB::raw('COALESCE(ordered_at, created_at)'), [
                $todayStart,
                $todayEnd,
            ]);

        $todayRevenue = (int) (clone $todayOrdersQuery)->sum('total_price');
        $todayOrders = (int) (clone $todayOrdersQuery)->count();
        $todayUnitsSold = (int) (clone $todayOrdersQuery)->sum('total_item');

        $todayAvgOrder = $todayOrders > 0
            ? (int) round($todayRevenue / $todayOrders)
            : 0;

        $totalProducts = (int) Product::query()->count();
        $totalCategories = (int) Category::query()->count();

        $outOfStockProducts = (int) Product::query()
            ->where('stock', '<=', 0)
            ->count();

        return [
            'summary' => [
                'today_revenue' => $todayRevenue,
                'today_orders' => $todayOrders,
                'today_units_sold' => $todayUnitsSold,
                'today_avg_order' => $todayAvgOrder,
                'total_products' => $totalProducts,
                'total_categories' => $totalCategories,
                'out_of_stock_products' => $outOfStockProducts,
            ],
        ];
    }
}
