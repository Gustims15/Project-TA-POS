<?php

namespace App\Filament\Admin\Pages;

use BackedEnum;
use Carbon\Carbon;
use Filament\Pages\Page;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;
use UnitEnum;

class FinancialDashboard extends Page
{
    protected static ?string $navigationLabel = 'Dashboard Keuangan';

    protected static ?string $title = '';

    protected static string|BackedEnum|null $navigationIcon = 'heroicon-o-chart-pie';

    protected static string|UnitEnum|null $navigationGroup = 'Keuangan';

    protected static ?int $navigationSort = 0;

    protected static ?string $slug = 'dashboard-keuangan';

    protected string $view = 'filament.admin.pages.financial-dashboard';

    public static function canAccess(): bool
    {
        return auth()->check() && auth()->user()->hasRole('super_admin');
    }

    public static function shouldRegisterNavigation(): bool
    {
        return auth()->check() && auth()->user()->hasRole('super_admin');
    }

    public function getFinancialDashboardData(): array
    {
        [$start, $end, $periodLabel, $periodKey] = $this->getSelectedRange();

        [$previousStart, $previousEnd] = $this->getPreviousRange($start, $end, $periodKey);

        $revenue = (int) $this->ordersBetween($start, $end)->sum('total_price');
        $previousRevenue = (int) $this->ordersBetween($previousStart, $previousEnd)->sum('total_price');

        $finance = $this->financeBetween($start, $end);
        $previousFinance = $this->financeBetween($previousStart, $previousEnd);

        $totalHpp = $finance['total_hpp'];
        $grossProfit = $finance['gross_profit'];

        $previousHpp = $previousFinance['total_hpp'];
        $previousGrossProfit = $previousFinance['gross_profit'];

        $operationalCost = $this->operationalCostBetween($start, $end);
        $previousOperationalCost = $this->operationalCostBetween($previousStart, $previousEnd);

        $netProfit = $grossProfit - $operationalCost;
        $previousNetProfit = $previousGrossProfit - $previousOperationalCost;

        $target = $this->targetForRange($start, $end, $periodKey);

        $targetRevenue = (int) ($target?->target_revenue ?? 0);
        $targetGrossProfit = (int) ($target?->target_gross_profit ?? 0);
        $targetNetProfit = (int) ($target?->target_net_profit ?? 0);

        $revenueProgress = $this->progressPercent($revenue, $targetRevenue);
        $grossProfitProgress = $this->progressPercent($grossProfit, $targetGrossProfit);
        $netProfitProgress = $this->progressPercent($netProfit, $targetNetProfit);

        $remainingRevenueTarget = max($targetRevenue - $revenue, 0);
        $remainingGrossProfitTarget = max($targetGrossProfit - $grossProfit, 0);
        $remainingNetProfitTarget = max($targetNetProfit - $netProfit, 0);

        $profitMargin = $revenue > 0
            ? round(($grossProfit / $revenue) * 100, 1)
            : 0;

        return [
            'period' => [
                'key' => $periodKey,
                'label' => $periodLabel,
                'start' => $start->format('d M Y'),
                'end' => $end->format('d M Y'),
            ],

            'metrics' => [
                [
                    'label' => 'Revenue',
                    'value' => $this->rupiah($revenue),
                    'trend' => $this->trendPercent($revenue, $previousRevenue),
                    'caption' => 'Total penjualan periode ini',
                    'icon' => '▣',
                    'color' => '#f97316',
                ],
                [
                    'label' => 'Total HPP',
                    'value' => $this->rupiah($totalHpp),
                    'trend' => $this->trendPercent($totalHpp, $previousHpp),
                    'caption' => 'Modal produk terjual',
                    'icon' => '∑',
                    'color' => '#14b8a6',
                ],
                [
                    'label' => 'Gross Profit',
                    'value' => $this->rupiah($grossProfit),
                    'trend' => $this->trendPercent($grossProfit, $previousGrossProfit),
                    'caption' => 'Revenue dikurangi HPP',
                    'icon' => '▥',
                    'color' => '#22c55e',
                ],
                [
                    'label' => 'Biaya Operasional',
                    'value' => $this->rupiah($operationalCost),
                    'trend' => $this->trendPercent($operationalCost, $previousOperationalCost),
                    'caption' => 'Sewa tahunan otomatis dibagi 12',
                    'icon' => '⌁',
                    'color' => '#ef4444',
                ],
                [
                    'label' => 'Net Profit',
                    'value' => $this->rupiah($netProfit),
                    'trend' => $this->trendPercent($netProfit, $previousNetProfit),
                    'caption' => 'Gross profit dikurangi biaya',
                    'icon' => '◆',
                    'color' => $netProfit >= 0 ? '#16a34a' : '#dc2626',
                ],
                [
                    'label' => 'Profit Margin',
                    'value' => $profitMargin . '%',
                    'trend' => null,
                    'caption' => 'Persentase laba kotor',
                    'icon' => '◎',
                    'color' => '#8b5cf6',
                ],
                [
                    'label' => 'Target Revenue',
                    'value' => $targetRevenue > 0 ? $revenueProgress . '%' : '0%',
                    'trend' => null,
                    'caption' => $targetRevenue > 0
                        ? 'Sisa ' . $this->rupiah($remainingRevenueTarget)
                        : 'Target belum diatur',
                    'icon' => '⚑',
                    'color' => '#f97316',
                ],
                [
                    'label' => 'Target Gross Profit',
                    'value' => $targetGrossProfit > 0 ? $grossProfitProgress . '%' : '0%',
                    'trend' => null,
                    'caption' => $targetGrossProfit > 0
                        ? 'Sisa ' . $this->rupiah($remainingGrossProfitTarget)
                        : 'Target belum diatur',
                    'icon' => '◈',
                    'color' => '#22c55e',
                ],
                [
                    'label' => 'Target Net Profit',
                    'value' => $targetNetProfit > 0 ? $netProfitProgress . '%' : '0%',
                    'trend' => null,
                    'caption' => $targetNetProfit > 0
                        ? 'Sisa ' . $this->rupiah($remainingNetProfitTarget)
                        : 'Target belum diatur',
                    'icon' => '◉',
                    'color' => '#6366f1',
                ],
            ],

            'summary' => [
                'revenue' => $revenue,
                'total_hpp' => $totalHpp,
                'gross_profit' => $grossProfit,
                'operational_cost' => $operationalCost,
                'net_profit' => $netProfit,
                'profit_margin' => $profitMargin,
            ],

            'costs' => $this->getOperationalCostList($start, $end),
            'productMargins' => $this->getProductMarginList($start, $end),

            'links' => [
                'operational_costs' => $this->safeAdminUrl('operational-costs'),
                'sales_targets' => $this->safeAdminUrl('sales-targets'),
                'products' => $this->safeAdminUrl('products'),
            ],
        ];
    }

    public function rupiah(int|float|null $value): string
    {
        return 'Rp ' . number_format((int) round((float) ($value ?? 0)), 0, ',', '.');
    }

    private function getSelectedRange(): array
    {
        $period = request()->query('period', 'month');

        return match ($period) {
            'today' => [
                now()->startOfDay(),
                now()->endOfDay(),
                'Hari Ini',
                'today',
            ],

            'week' => [
                now()->subDays(6)->startOfDay(),
                now()->endOfDay(),
                '7 Hari Terakhir',
                'week',
            ],

            'year' => [
                now()->startOfYear(),
                now()->endOfYear(),
                'Tahun Ini',
                'year',
            ],

            default => [
                now()->startOfMonth(),
                now()->endOfMonth(),
                'Bulan Ini',
                'month',
            ],
        };
    }

    private function getPreviousRange(Carbon $start, Carbon $end, string $periodKey): array
    {
        if ($periodKey === 'today') {
            return [
                $start->copy()->subDay()->startOfDay(),
                $start->copy()->subDay()->endOfDay(),
            ];
        }

        if ($periodKey === 'month') {
            return [
                $start->copy()->subMonthNoOverflow()->startOfMonth(),
                $start->copy()->subMonthNoOverflow()->endOfMonth(),
            ];
        }

        if ($periodKey === 'year') {
            return [
                $start->copy()->subYear()->startOfYear(),
                $start->copy()->subYear()->endOfYear(),
            ];
        }

        $days = max(1, ((int) floor($start->diffInDays($end))) + 1);

        $previousEnd = $start->copy()->subSecond();
        $previousStart = $previousEnd->copy()->subDays($days - 1)->startOfDay();

        return [$previousStart, $previousEnd];
    }

    private function ordersBetween(Carbon $start, Carbon $end)
    {
        return DB::table('orders')
            ->whereBetween(
                DB::raw('COALESCE(ordered_at, created_at)'),
                [
                    $start->toDateTimeString(),
                    $end->toDateTimeString(),
                ]
            );
    }

    private function financeBetween(Carbon $start, Carbon $end): array
    {
        if (! Schema::hasTable('order_items') || ! Schema::hasTable('orders')) {
            return [
                'total_hpp' => 0,
                'gross_profit' => 0,
            ];
        }

        $hasTotalHpp = Schema::hasColumn('order_items', 'total_hpp');
        $hasHpp = Schema::hasColumn('order_items', 'hpp');
        $hasQuantity = Schema::hasColumn('order_items', 'quantity');
        $hasSubtotal = Schema::hasColumn('order_items', 'subtotal');

        $totalHppExpression = match (true) {
            $hasTotalHpp => 'COALESCE(SUM(order_items.total_hpp), 0)',
            $hasHpp && $hasQuantity => 'COALESCE(SUM(order_items.hpp * order_items.quantity), 0)',
            default => '0',
        };

        $grossProfitExpression = match (true) {
            $hasSubtotal && $hasTotalHpp => 'COALESCE(SUM(order_items.subtotal - order_items.total_hpp), 0)',
            $hasSubtotal && $hasHpp && $hasQuantity => 'COALESCE(SUM(order_items.subtotal - (order_items.hpp * order_items.quantity)), 0)',
            $hasSubtotal => 'COALESCE(SUM(order_items.subtotal), 0)',
            default => '0',
        };

        $finance = DB::table('order_items')
            ->join('orders', 'orders.id', '=', 'order_items.order_id')
            ->whereBetween(
                DB::raw('COALESCE(orders.ordered_at, orders.created_at)'),
                [
                    $start->toDateTimeString(),
                    $end->toDateTimeString(),
                ]
            )
            ->selectRaw($totalHppExpression . ' as total_hpp')
            ->selectRaw($grossProfitExpression . ' as gross_profit')
            ->first();

        return [
            'total_hpp' => (int) ($finance->total_hpp ?? 0),
            'gross_profit' => (int) ($finance->gross_profit ?? 0),
        ];
    }

    private function operationalCostBetween(Carbon $start, Carbon $end): int
    {
        if (! Schema::hasTable('operational_costs')) {
            return 0;
        }

        $normalCost = (int) DB::table('operational_costs')
            ->where('is_active', true)
            ->where('category', '!=', 'rent')
            ->whereBetween('cost_date', [
                $start->toDateString(),
                $end->toDateString(),
            ])
            ->sum('amount');

        $rentAllocation = $this->getAnnualRentCosts()
            ->sum(function ($cost) use ($start, $end): int {
                $months = $this->countAnnualRentOverlapMonths(
                    Carbon::parse($cost->cost_date),
                    $start,
                    $end
                );

                if ($months <= 0) {
                    return 0;
                }

                return (int) round(((int) $cost->amount / 12) * $months);
            });

        return $normalCost + (int) $rentAllocation;
    }

    private function targetForRange(Carbon $start, Carbon $end, string $periodKey): ?object
    {
        if (! Schema::hasTable('sales_targets')) {
            return null;
        }

        if ($periodKey === 'year') {
            return DB::table('sales_targets')
                ->whereBetween('month', [
                    $start->copy()->startOfYear()->toDateString(),
                    $end->copy()->endOfYear()->toDateString(),
                ])
                ->selectRaw('COALESCE(SUM(target_revenue), 0) as target_revenue')
                ->selectRaw('COALESCE(SUM(target_gross_profit), 0) as target_gross_profit')
                ->selectRaw('COALESCE(SUM(target_net_profit), 0) as target_net_profit')
                ->first();
        }

        return DB::table('sales_targets')
            ->whereDate('month', $start->copy()->startOfMonth()->toDateString())
            ->first();
    }

    private function getOperationalCostList(Carbon $start, Carbon $end): array
    {
        if (! Schema::hasTable('operational_costs')) {
            return [];
        }

        $normalCosts = DB::table('operational_costs')
            ->where('is_active', true)
            ->where('category', '!=', 'rent')
            ->whereBetween('cost_date', [
                $start->toDateString(),
                $end->toDateString(),
            ])
            ->get()
            ->map(fn ($cost): array => [
                'name' => (string) $cost->name,
                'category' => $this->costCategoryLabel((string) $cost->category),
                'amount' => (int) $cost->amount,
                'annual_amount' => null,
                'date' => Carbon::parse($cost->cost_date)->format('d M Y'),
                'is_annual' => false,
                'description' => Carbon::parse($cost->cost_date)->format('d M Y'),
            ]);

        $rentCosts = $this->getAnnualRentCosts()
            ->map(function ($cost) use ($start, $end): ?array {
                $months = $this->countAnnualRentOverlapMonths(
                    Carbon::parse($cost->cost_date),
                    $start,
                    $end
                );

                if ($months <= 0) {
                    return null;
                }

                $monthlyAmount = (int) round((int) $cost->amount / 12);
                $allocatedAmount = $monthlyAmount * $months;

                return [
                    'name' => (string) $cost->name,
                    'category' => 'Sewa Tempat Tahunan',
                    'amount' => $allocatedAmount,
                    'annual_amount' => (int) $cost->amount,
                    'date' => Carbon::parse($cost->cost_date)->format('d M Y'),
                    'is_annual' => true,
                    'description' => 'Tahunan ' . $this->rupiah((int) $cost->amount) . ' • dihitung ' . $this->rupiah($monthlyAmount) . '/bulan',
                ];
            })
            ->filter()
            ->values();

        return $normalCosts
            ->concat($rentCosts)
            ->sortByDesc('amount')
            ->take(8)
            ->values()
            ->all();
    }

    private function getProductMarginList(Carbon $start, Carbon $end): array
    {
        if (! Schema::hasTable('order_items') || ! Schema::hasTable('orders')) {
            return [];
        }

        $hasTotalHpp = Schema::hasColumn('order_items', 'total_hpp');
        $hasHpp = Schema::hasColumn('order_items', 'hpp');
        $hasQuantity = Schema::hasColumn('order_items', 'quantity');
        $hasSubtotal = Schema::hasColumn('order_items', 'subtotal');

        $totalHppExpression = match (true) {
            $hasTotalHpp => 'COALESCE(SUM(order_items.total_hpp), 0)',
            $hasHpp && $hasQuantity => 'COALESCE(SUM(order_items.hpp * order_items.quantity), 0)',
            default => '0',
        };

        $grossProfitExpression = match (true) {
            $hasSubtotal && $hasTotalHpp => 'COALESCE(SUM(order_items.subtotal - order_items.total_hpp), 0)',
            $hasSubtotal && $hasHpp && $hasQuantity => 'COALESCE(SUM(order_items.subtotal - (order_items.hpp * order_items.quantity)), 0)',
            $hasSubtotal => 'COALESCE(SUM(order_items.subtotal), 0)',
            default => '0',
        };

        return DB::table('order_items')
            ->join('orders', 'orders.id', '=', 'order_items.order_id')
            ->selectRaw('COALESCE(order_items.product_name, "Produk") as name')
            ->selectRaw('SUM(order_items.quantity) as units')
            ->selectRaw('SUM(order_items.subtotal) as revenue')
            ->selectRaw($totalHppExpression . ' as total_hpp')
            ->selectRaw($grossProfitExpression . ' as gross_profit')
            ->whereBetween(
                DB::raw('COALESCE(orders.ordered_at, orders.created_at)'),
                [
                    $start->toDateTimeString(),
                    $end->toDateTimeString(),
                ]
            )
            ->groupByRaw('COALESCE(order_items.product_name, "Produk")')
            ->orderByDesc('gross_profit')
            ->limit(8)
            ->get()
            ->map(function ($row): array {
                $revenue = (int) $row->revenue;
                $grossProfit = (int) $row->gross_profit;

                return [
                    'name' => (string) $row->name,
                    'units' => (int) $row->units,
                    'revenue' => $revenue,
                    'total_hpp' => (int) $row->total_hpp,
                    'gross_profit' => $grossProfit,
                    'margin' => $revenue > 0 ? round(($grossProfit / $revenue) * 100, 1) : 0,
                ];
            })
            ->values()
            ->all();
    }

    private function getAnnualRentCosts(): Collection
    {
        if (! Schema::hasTable('operational_costs')) {
            return collect();
        }

        return DB::table('operational_costs')
            ->where('is_active', true)
            ->where('category', 'rent')
            ->get();
    }

    private function countAnnualRentOverlapMonths(Carbon $rentDate, Carbon $periodStart, Carbon $periodEnd): int
    {
        $rentStart = $rentDate->copy()->startOfMonth();
        $rentEnd = $rentStart->copy()->addMonths(11)->endOfMonth();

        $rangeStart = $periodStart->copy()->startOfMonth();
        $rangeEnd = $periodEnd->copy()->endOfMonth();

        if ($rentEnd->lt($rangeStart) || $rentStart->gt($rangeEnd)) {
            return 0;
        }

        $overlapStart = $rentStart->gt($rangeStart)
            ? $rentStart->copy()
            : $rangeStart->copy();

        $overlapEnd = $rentEnd->lt($rangeEnd)
            ? $rentEnd->copy()
            : $rangeEnd->copy();

        return (($overlapEnd->year - $overlapStart->year) * 12)
            + ($overlapEnd->month - $overlapStart->month)
            + 1;
    }

    private function costCategoryLabel(string $category): string
    {
        return match ($category) {
            'rent' => 'Sewa Tempat Tahunan',
            'electricity' => 'Listrik',
            'water' => 'Air',
            'internet' => 'Wifi / Internet',
            'salary' => 'Gaji',
            'marketing' => 'Promosi / Marketing',
            'maintenance' => 'Maintenance',
            default => 'Lainnya',
        };
    }

    private function progressPercent(int|float $actual, int|float $target): float
    {
        if ($target <= 0) {
            return 0.0;
        }

        return round(min(($actual / $target) * 100, 999), 1);
    }

    private function trendPercent(int|float $current, int|float $previous): ?float
    {
        if ($previous <= 0) {
            return $current > 0 ? 100.0 : 0.0;
        }

        return round((($current - $previous) / $previous) * 100, 1);
    }

    private function safeAdminUrl(string $path): string
    {
        return url('/admin/' . trim($path, '/'));
    }
}