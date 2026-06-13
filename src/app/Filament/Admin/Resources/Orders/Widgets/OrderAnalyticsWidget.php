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

    public function getViewData(): array
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

        $todayOrders = (int) Order::query()
            ->whereBetween(DB::raw('COALESCE(ordered_at, created_at)'), [
                now()->startOfDay(),
                now()->endOfDay(),
            ])
            ->count();

        $todayRevenue = (int) Order::query()
            ->where('status', 'Selesai')
            ->whereBetween(DB::raw('COALESCE(ordered_at, created_at)'), [
                now()->startOfDay(),
                now()->endOfDay(),
            ])
            ->sum('total_price');

        $latestOrder = Order::query()
            ->latest('ordered_at')
            ->first();

        return [
            'summary' => [
                'total_revenue' => $totalRevenue,
                'total_orders' => $totalOrders,
                'units_sold' => $unitsSold,
                'avg_order' => $avgOrder,
                'today_orders' => $todayOrders,
                'today_revenue' => $todayRevenue,
                'latest_order_code' => $latestOrder?->order_code ?? '-',
                'latest_order_time' => $latestOrder?->ordered_at?->format('d M Y H:i') ?? '-',
            ],
        ];
    }
}