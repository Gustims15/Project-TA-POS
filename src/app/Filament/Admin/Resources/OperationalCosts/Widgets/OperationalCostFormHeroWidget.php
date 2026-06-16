<?php

namespace App\Filament\Admin\Resources\OperationalCosts\Widgets;

use App\Filament\Admin\Resources\OperationalCosts\OperationalCostResource;
use App\Models\OperationalCost;
use Filament\Widgets\Widget;

class OperationalCostFormHeroWidget extends Widget
{
    protected string $view = 'filament.admin.resources.operational-costs.widgets.operational-cost-form-hero-widget';

    protected int | string | array $columnSpan = 'full';

    protected function getViewData(): array
    {
        $routeName = request()->route()?->getName() ?? '';
        $isEdit = str_contains($routeName, '.edit');

        $totalCosts = (int) OperationalCost::query()->count();

        $activeCosts = (int) OperationalCost::query()
            ->where('is_active', true)
            ->count();

        $normalMonthlyCost = (int) OperationalCost::query()
            ->where('is_active', true)
            ->where('category', '!=', 'rent')
            ->whereBetween('cost_date', [
                now()->startOfMonth()->toDateString(),
                now()->endOfMonth()->toDateString(),
            ])
            ->sum('amount');

        $rentMonthlyCost = (int) OperationalCost::query()
            ->where('is_active', true)
            ->where('category', 'rent')
            ->get()
            ->sum(fn (OperationalCost $cost): int => (int) round(((int) $cost->amount) / 12));

        return [
            'title' => $isEdit ? 'Edit Biaya Operasional' : 'Tambah Biaya Operasional',
            'description' => $isEdit
                ? 'Perbarui data biaya operasional agar perhitungan laba bersih tetap akurat pada Dashboard Keuangan.'
                : 'Input biaya usaha seperti sewa tempat, listrik, air, wifi, gaji karyawan, promosi, maintenance, dan biaya lainnya.',
            'backUrl' => OperationalCostResource::getUrl('index'),
            'stats' => [
                'total_costs' => $totalCosts,
                'active_costs' => $activeCosts,
                'monthly_cost' => $normalMonthlyCost + $rentMonthlyCost,
            ],
        ];
    }

    public function rupiah(int | float | null $value): string
    {
        return 'Rp ' . number_format((int) round((float) ($value ?? 0)), 0, ',', '.');
    }
}