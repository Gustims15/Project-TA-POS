<?php

declare(strict_types=1);

namespace App\Filament\Admin\Resources\Orders\Widgets;

use App\Models\Order;
use Filament\Widgets\Widget;
use Illuminate\Support\Facades\DB;

class OrderAnalyticsWidget extends Widget
{
    protected string $view = 'filament.admin.resources.orders.widgets.order-analytics-widget';

    protected int|string|array $columnSpan = 'full';

    protected function getViewData(): array
    {
        $finishedOrders = Order::query()
            ->where('status', 'Selesai');

        $totalRevenue = (int) (clone $finishedOrders)->sum('total_price');
        $totalOrders = (int) Order::query()->count();
        $finishedOrdersCount = (int) (clone $finishedOrders)->count();
        $unitsSold = (int) (clone $finishedOrders)->sum('total_item');

        $avgOrder = $finishedOrdersCount > 0
            ? (int) round($totalRevenue / $finishedOrdersCount)
            : 0;

        $todayOrders = Order::query()
            ->whereBetween(DB::raw('COALESCE(ordered_at, created_at)'), [
                now()->startOfDay(),
                now()->endOfDay(),
            ])
            ->count();

        return [
            'summary' => [
                'total_revenue' => $totalRevenue,
                'total_orders' => $totalOrders,
                'units_sold' => $unitsSold,
                'avg_order' => $avgOrder,
                'today_orders' => $todayOrders,
            ],
        ];
    }
}
