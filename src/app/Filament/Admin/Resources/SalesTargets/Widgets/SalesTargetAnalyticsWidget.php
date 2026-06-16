<?php

namespace App\Filament\Admin\Resources\SalesTargets\Widgets;

use App\Filament\Admin\Pages\FinancialDashboard;
use App\Filament\Admin\Resources\SalesTargets\SalesTargetResource;
use App\Models\SalesTarget;
use Filament\Widgets\Widget;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

class SalesTargetAnalyticsWidget extends Widget
{
    protected string $view = 'filament.admin.resources.sales-targets.widgets.sales-target-analytics-widget';

    protected int | string | array $columnSpan = 'full';

    protected function getViewData(): array
    {
        $monthStart = now()->startOfMonth();
        $monthEnd = now()->endOfMonth();

        $currentTarget = SalesTarget::query()
            ->whereDate('month', $monthStart->toDateString())
            ->first();

        $monthlyRevenue = $this->monthlyRevenue($monthStart, $monthEnd);

        $targetRevenue = (int) ($currentTarget?->target_revenue ?? 0);
        $targetGrossProfit = (int) ($currentTarget?->target_gross_profit ?? 0);
        $targetNetProfit = (int) ($currentTarget?->target_net_profit ?? 0);

        $totalTargets = (int) SalesTarget::query()->count();

        $yearTargetRevenue = (int) SalesTarget::query()
            ->whereBetween('month', [
                now()->startOfYear()->toDateString(),
                now()->endOfYear()->toDateString(),
            ])
            ->sum('target_revenue');

        $highestTarget = SalesTarget::query()
            ->orderByDesc('target_revenue')
            ->first();

        $latestTarget = SalesTarget::query()
            ->latest('month')
            ->first();

        return [
            'createUrl' => SalesTargetResource::getUrl('create'),
            'dashboardUrl' => FinancialDashboard::getUrl(),
            'summary' => [
                'monthly_revenue' => $monthlyRevenue,
                'target_revenue' => $targetRevenue,
                'target_gross_profit' => $targetGrossProfit,
                'target_net_profit' => $targetNetProfit,
                'revenue_progress' => $this->progressPercent($monthlyRevenue, $targetRevenue),
                'year_target_revenue' => $yearTargetRevenue,
                'total_targets' => $totalTargets,
                'highest_target_month' => $highestTarget?->month?->format('M Y') ?? '-',
                'highest_target_value' => (int) ($highestTarget?->target_revenue ?? 0),
                'latest_target_month' => $latestTarget?->month?->format('M Y') ?? '-',
                'latest_target_value' => (int) ($latestTarget?->target_revenue ?? 0),
                'has_current_target' => ! is_null($currentTarget),
            ],
        ];
    }

    public function rupiah(int | float | null $value): string
    {
        return 'Rp ' . number_format((int) round((float) ($value ?? 0)), 0, ',', '.');
    }

    private function monthlyRevenue($start, $end): int
    {
        if (! Schema::hasTable('orders')) {
            return 0;
        }

        $amountColumn = Schema::hasColumn('orders', 'total_price')
            ? 'total_price'
            : (Schema::hasColumn('orders', 'total_amount') ? 'total_amount' : null);

        if (! $amountColumn) {
            return 0;
        }

        return (int) DB::table('orders')
            ->whereBetween(
                DB::raw('COALESCE(ordered_at, created_at)'),
                [$start->toDateTimeString(), $end->toDateTimeString()]
            )
            ->sum($amountColumn);
    }

    private function progressPercent(int | float $actual, int | float $target): float
    {
        if ($target <= 0) {
            return 0.0;
        }

        return round(min(($actual / $target) * 100, 999), 1);
    }
}