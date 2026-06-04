<?php

declare(strict_types=1);

namespace App\Filament\Admin\Widgets;

use App\Filament\Admin\Widgets\Concerns\HasDashboardMetric;
use App\Models\Order;
use Filament\Widgets\Widget;

class RecentSalesTimeline extends Widget
{
    use HasDashboardMetric;

    protected string $view = 'filament.admin.widgets.recent-sales-timeline';

    protected int|string|array $columnSpan = [
        'default' => 1,
        'md' => 1,
        'xl' => 4,
    ];

    protected function getViewData(): array
    {
        $query = Order::query()
            ->where('status', 'Selesai')
            ->latest('ordered_at');

        $this->applyDashboardPeriodFilterToOrderQuery($query);

        $orders = $query
            ->limit(5)
            ->get([
                'id',
                'order_code',
                'total_item',
                'total_price',
                'status',
                'ordered_at',
                'created_at',
            ]);

        $maxRevenue = max((int) $orders->max('total_price'), 1);

        return [
            'orders' => $orders,
            'maxRevenue' => $maxRevenue,
            'periodLabel' => $this->getDashboardPeriodLabel(),
        ];
    }
}