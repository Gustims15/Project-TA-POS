<?php

declare(strict_types=1);

namespace App\Filament\Admin\Widgets\Concerns;

trait HasDashboardMetric
{
    protected function getDashboardMetric(): string
    {
        $metric = request()->query('metric');

        if (! $metric) {
            $referer = request()->headers->get('referer');

            if ($referer) {
                $query = parse_url($referer, PHP_URL_QUERY);

                if ($query) {
                    parse_str($query, $params);

                    $metric = $params['metric'] ?? null;
                }
            }
        }

        $metric = (string) ($metric ?: 'units');

        return in_array($metric, ['orders', 'revenue', 'units'], true)
            ? $metric
            : 'units';
    }

    protected function getDashboardMetricLabel(): string
    {
        return match ($this->getDashboardMetric()) {
            'orders' => 'Orders',
            'revenue' => 'Revenue',
            'units' => 'Units Sold',
            default => 'Units Sold',
        };
    }

    protected function getDashboardMetricDatasetLabel(): string
    {
        return match ($this->getDashboardMetric()) {
            'orders' => 'Orders',
            'revenue' => 'Revenue',
            'units' => 'Units',
            default => 'Units',
        };
    }

    protected function getDashboardMetricSortColumn(): string
    {
        return match ($this->getDashboardMetric()) {
            'orders' => 'orders_count',
            'revenue' => 'revenue',
            'units' => 'units_sold',
            default => 'units_sold',
        };
    }
}