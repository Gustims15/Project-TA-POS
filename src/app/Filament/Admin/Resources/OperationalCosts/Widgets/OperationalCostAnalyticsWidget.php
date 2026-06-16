<?php

namespace App\Filament\Admin\Resources\OperationalCosts\Widgets;

use App\Filament\Admin\Pages\FinancialDashboard;
use App\Filament\Admin\Resources\OperationalCosts\OperationalCostResource;
use App\Models\OperationalCost;
use Filament\Widgets\Widget;
use Illuminate\Support\Facades\DB;

class OperationalCostAnalyticsWidget extends Widget
{
    protected string $view = 'filament.admin.resources.operational-costs.widgets.operational-cost-analytics-widget';

    protected int | string | array $columnSpan = 'full';

    protected function getViewData(): array
    {
        $start = now()->startOfMonth();
        $end = now()->endOfMonth();

        $normalMonthlyCost = (int) OperationalCost::query()
            ->where('is_active', true)
            ->where('category', '!=', 'rent')
            ->whereBetween('cost_date', [$start->toDateString(), $end->toDateString()])
            ->sum('amount');

        $rentMonthlyCost = (int) OperationalCost::query()
            ->where('is_active', true)
            ->where('category', 'rent')
            ->get()
            ->sum(fn (OperationalCost $cost): int => (int) round(((int) $cost->amount) / 12));

        $monthlyCost = $normalMonthlyCost + $rentMonthlyCost;

        $totalCosts = (int) OperationalCost::query()->count();

        $activeCosts = (int) OperationalCost::query()
            ->where('is_active', true)
            ->count();

        $inactiveCosts = max(0, $totalCosts - $activeCosts);

        $annualRent = (int) OperationalCost::query()
            ->where('is_active', true)
            ->where('category', 'rent')
            ->sum('amount');

        $highestCost = OperationalCost::query()
            ->where('is_active', true)
            ->orderByDesc('amount')
            ->first();

        $latestCost = OperationalCost::query()
            ->latest('cost_date')
            ->first();

        $categoryBreakdown = OperationalCost::query()
            ->where('is_active', true)
            ->select('category', DB::raw('SUM(amount) as total_amount'))
            ->groupBy('category')
            ->orderByDesc('total_amount')
            ->limit(5)
            ->get()
            ->map(fn ($row): array => [
                'label' => $this->categoryLabel((string) $row->category),
                'value' => (int) $row->total_amount,
            ])
            ->all();

        return [
            'createUrl' => OperationalCostResource::getUrl('create'),
            'dashboardUrl' => FinancialDashboard::getUrl(),
            'summary' => [
                'monthly_cost' => $monthlyCost,
                'normal_monthly_cost' => $normalMonthlyCost,
                'rent_monthly_cost' => $rentMonthlyCost,
                'total_costs' => $totalCosts,
                'active_costs' => $activeCosts,
                'inactive_costs' => $inactiveCosts,
                'annual_rent' => $annualRent,
                'highest_cost_name' => $highestCost?->name ?? '-',
                'highest_cost_amount' => (int) ($highestCost?->amount ?? 0),
                'latest_cost_name' => $latestCost?->name ?? '-',
                'latest_cost_date' => $latestCost?->cost_date?->format('d M Y') ?? '-',
                'category_breakdown' => $categoryBreakdown,
            ],
        ];
    }

    public function rupiah(int | float | null $value): string
    {
        return 'Rp ' . number_format((int) round((float) ($value ?? 0)), 0, ',', '.');
    }

    private function categoryLabel(string $category): string
    {
        return match ($category) {
            'rent' => 'Sewa Tempat',
            'electricity' => 'Listrik',
            'water' => 'Air',
            'internet' => 'Wifi / Internet',
            'salary' => 'Gaji Karyawan',
            'marketing' => 'Promosi / Marketing',
            'maintenance' => 'Maintenance',
            default => 'Lainnya',
        };
    }
}