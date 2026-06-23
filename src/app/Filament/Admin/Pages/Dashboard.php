<?php

namespace App\Filament\Admin\Pages;

use BackedEnum;
use Carbon\Carbon;
use Carbon\CarbonPeriod;
use Filament\Pages\Page;
use Illuminate\Database\Query\Builder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

class Dashboard extends Page
{
    protected static ?string $navigationLabel = 'Dashboard';

    protected static ?string $title = '';

    protected static string|BackedEnum|null $navigationIcon = 'heroicon-o-home';

    protected static ?int $navigationSort = 0;

    /**
     * Penting:
     * Di versi Filament project ini, property $view pada parent Page adalah NON-STATIC.
     * Jadi jangan pakai: protected static string $view
     */
    protected string $view = 'filament.admin.pages.dashboard';

    public static function canAccess(): bool
    {
        return auth()->check() && auth()->user()->hasRole('super_admin');
    }

    public static function shouldRegisterNavigation(): bool
    {
        return auth()->check() && auth()->user()->hasRole('super_admin');
    }

    public function getColumns(): int|array
    {
        return 1;
    }

    public function getWidgets(): array
    {
        return [];
    }

    protected function getHeaderActions(): array
    {
        return [];
    }

    public function getDashboardData(): array
    {
        [$start, $end, $periodLabel, $periodKey, $selectedMonth] = $this->getSelectedRange();

        $previousRange = $this->getPreviousRange($start, $end, $periodKey, $selectedMonth);

        $revenue = (int) $this->ordersBetween($start, $end)->sum('total_price');
        $previousRevenue = (int) $this->ordersBetween($previousRange[0], $previousRange[1])->sum('total_price');

        $totalOrders = (int) $this->ordersBetween($start, $end)->count();
        $previousOrders = (int) $this->ordersBetween($previousRange[0], $previousRange[1])->count();

        $unitsSold = (int) $this->ordersBetween($start, $end)->sum('total_item');
        $previousUnits = (int) $this->ordersBetween($previousRange[0], $previousRange[1])->sum('total_item');

        $avgOrder = $totalOrders > 0 ? (int) round($revenue / $totalOrders) : 0;
        $previousAvgOrder = $previousOrders > 0 ? (int) round($previousRevenue / $previousOrders) : 0;

        $finance = $this->financeBetween($start, $end);
        $previousFinance = $this->financeBetween($previousRange[0], $previousRange[1]);

        $totalHpp = $finance['total_hpp'];
        $grossProfit = $finance['gross_profit'];

        $previousHpp = $previousFinance['total_hpp'];
        $previousGrossProfit = $previousFinance['gross_profit'];

        $operationalCost = $this->operationalCostBetween($start, $end);
        $previousOperationalCost = $this->operationalCostBetween($previousRange[0], $previousRange[1]);

        $netProfit = $grossProfit - $operationalCost;
        $previousNetProfit = $previousGrossProfit - $previousOperationalCost;

        $target = $this->targetForRange($start);

        $targetRevenue = (int) ($target?->target_revenue ?? 0);
        $targetGrossProfit = (int) ($target?->target_gross_profit ?? 0);
        $targetNetProfit = (int) ($target?->target_net_profit ?? 0);

        $revenueProgress = $this->progressPercent($revenue, $targetRevenue);
        $grossProfitProgress = $this->progressPercent($grossProfit, $targetGrossProfit);
        $netProfitProgress = $this->progressPercent($netProfit, $targetNetProfit);

        $remainingRevenueTarget = max($targetRevenue - $revenue, 0);
        $remainingGrossProfitTarget = max($targetGrossProfit - $grossProfit, 0);
        $remainingNetProfitTarget = max($targetNetProfit - $netProfit, 0);

        $totalProduct = (int) DB::table('products')
            ->where('is_active', true)
            ->count();

        return [
            'period' => [
                'key' => $periodKey,
                'label' => $periodLabel,
                'start' => $start->format('d M Y'),
                'end' => $end->format('d M Y'),
                'selectedMonth' => $selectedMonth,
                'monthLabel' => $this->getMonthLabel($selectedMonth),
                'monthOptions' => $this->getYearMonthOptions(),
                'isMonthFiltered' => $periodKey === 'year' && $selectedMonth !== 'all',
                'year' => now()->year,
            ],

            'metrics' => [
                [
                    'label' => 'Revenue',
                    'value' => $this->rupiah($revenue),
                    'trend' => $this->trendPercent($revenue, $previousRevenue),
                    'caption' => 'dari periode sebelumnya',
                    'icon' => '▣',
                    'color' => '#f97316',
                ],
                [
                    'label' => 'Total Orders',
                    'value' => number_format($totalOrders, 0, ',', '.'),
                    'trend' => $this->trendPercent($totalOrders, $previousOrders),
                    'caption' => 'dari periode sebelumnya',
                    'icon' => '▤',
                    'color' => '#3b82f6',
                ],
                [
                    'label' => 'Units Sold',
                    'value' => number_format($unitsSold, 0, ',', '.'),
                    'trend' => $this->trendPercent($unitsSold, $previousUnits),
                    'caption' => 'dari periode sebelumnya',
                    'icon' => '▰',
                    'color' => '#f59e0b',
                ],
                [
                    'label' => 'Avg Order Value',
                    'value' => $this->rupiah($avgOrder),
                    'trend' => $this->trendPercent($avgOrder, $previousAvgOrder),
                    'caption' => 'dari periode sebelumnya',
                    'icon' => '↗',
                    'color' => '#8b5cf6',
                ],

                /*
                |--------------------------------------------------------------------------
                | METRIC PRODUK EXISTING
                |--------------------------------------------------------------------------
                */
                [
                    'label' => 'Total Product',
                    'value' => number_format($totalProduct, 0, ',', '.'),
                    'trend' => null,
                    'caption' => 'Produk aktif',
                    'icon' => '◇',
                    'color' => '#10b981',
                ],
            ],

            'finance' => [
                'total_hpp' => $totalHpp,
                'gross_profit' => $grossProfit,
                'operational_cost' => $operationalCost,
                'net_profit' => $netProfit,

                'target_revenue' => $targetRevenue,
                'target_gross_profit' => $targetGrossProfit,
                'target_net_profit' => $targetNetProfit,

                'revenue_progress' => $revenueProgress,
                'gross_profit_progress' => $grossProfitProgress,
                'net_profit_progress' => $netProfitProgress,

                'remaining_revenue_target' => $remainingRevenueTarget,
                'remaining_gross_profit_target' => $remainingGrossProfitTarget,
                'remaining_net_profit_target' => $remainingNetProfitTarget,

                'has_target' => $target !== null,
            ],

            'charts' => [
                'revenue' => $this->getRevenueChart($start, $end, $periodKey, $selectedMonth),
                'topProducts' => $this->getProductSales($start, $end),
                'category' => $this->getCategoryContribution($start, $end),
                'salesByTime' => $this->getSalesByTime($start, $end),
            ],

            'latestOrders' => $this->getLatestOrders(),
        ];
    }

    public function rupiah(int|float|null $value): string
    {
        return 'Rp ' . number_format((int) ($value ?? 0), 0, ',', '.');
    }

    private function getSelectedRange(): array
    {
        $period = request()->query('period', 'week');
        $selectedMonth = 'all';

        return match ($period) {
            'today' => [
                now()->startOfDay(),
                now()->endOfDay(),
                'Hari Ini',
                'today',
                $selectedMonth,
            ],

            'month' => [
                now()->startOfMonth(),
                now()->endOfMonth(),
                'Bulan Ini',
                'month',
                $selectedMonth,
            ],

            'year' => $this->getYearRangeWithOptionalMonth(),

            default => [
                now()->subDays(6)->startOfDay(),
                now()->endOfDay(),
                '7 Hari Terakhir',
                'week',
                $selectedMonth,
            ],
        };
    }

    private function getYearRangeWithOptionalMonth(): array
    {
        $requestedMonth = request()->query('month', 'all');

        if ((string) $requestedMonth !== 'all') {
            $monthNumber = (int) $requestedMonth;

            if ($monthNumber >= 1 && $monthNumber <= 12) {
                $selectedMonth = (string) $monthNumber;
                $monthDate = Carbon::create(now()->year, $monthNumber, 1);

                return [
                    $monthDate->copy()->startOfMonth(),
                    $monthDate->copy()->endOfMonth(),
                    'Tahun Ini',
                    'year',
                    $selectedMonth,
                ];
            }
        }

        return [
            now()->startOfYear(),
            now()->endOfYear(),
            'Tahun Ini',
            'year',
            'all',
        ];
    }

    private function getYearMonthOptions(): array
    {
        $months = [
            1 => 'Januari',
            2 => 'Februari',
            3 => 'Maret',
            4 => 'April',
            5 => 'Mei',
            6 => 'Juni',
            7 => 'Juli',
            8 => 'Agustus',
            9 => 'September',
            10 => 'Oktober',
            11 => 'November',
            12 => 'Desember',
        ];

        return collect($months)
            ->map(fn (string $label, int $value): array => [
                'value' => (string) $value,
                'label' => $label,
            ])
            ->values()
            ->all();
    }

    private function getMonthLabel(string $selectedMonth): string
    {
        if ($selectedMonth === 'all') {
            return 'Semua Bulan';
        }

        $month = collect($this->getYearMonthOptions())
            ->firstWhere('value', $selectedMonth);

        return $month['label'] ?? 'Semua Bulan';
    }

    private function getPreviousRange(Carbon $start, Carbon $end, string $periodKey, string $selectedMonth = 'all'): array
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

        if ($periodKey === 'year' && $selectedMonth !== 'all') {
            return [
                $start->copy()->subMonthNoOverflow()->startOfMonth(),
                $start->copy()->subMonthNoOverflow()->endOfMonth(),
            ];
        }

        if ($periodKey === 'year' && $selectedMonth === 'all') {
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

    private function ordersBetween(Carbon $start, Carbon $end): Builder
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
        $hasGrossProfit = Schema::hasColumn('order_items', 'gross_profit');
        $hasHpp = Schema::hasColumn('order_items', 'hpp');
        $hasQuantity = Schema::hasColumn('order_items', 'quantity');
        $hasSubtotal = Schema::hasColumn('order_items', 'subtotal');

        $totalHppExpression = match (true) {
            $hasTotalHpp => 'COALESCE(SUM(order_items.total_hpp), 0)',
            $hasHpp && $hasQuantity => 'COALESCE(SUM(order_items.hpp * order_items.quantity), 0)',
            default => '0',
        };

        $grossProfitExpression = match (true) {
            $hasGrossProfit => 'COALESCE(SUM(order_items.gross_profit), 0)',
            $hasSubtotal && $hasTotalHpp => 'COALESCE(SUM(order_items.subtotal - order_items.total_hpp), 0)',
            $hasSubtotal && $hasHpp && $hasQuantity => 'COALESCE(SUM(order_items.subtotal - (order_items.hpp * order_items.quantity)), 0)',
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

        return (int) DB::table('operational_costs')
            ->where('is_active', true)
            ->whereBetween('cost_date', [
                $start->toDateString(),
                $end->toDateString(),
            ])
            ->sum('amount');
    }

    private function targetForRange(Carbon $start): ?object
    {
        if (! Schema::hasTable('sales_targets')) {
            return null;
        }

        return DB::table('sales_targets')
            ->whereDate('month', $start->copy()->startOfMonth()->toDateString())
            ->first();
    }

    private function progressPercent(int|float $actual, int|float $target): float
    {
        if ($target <= 0) {
            return 0.0;
        }

        return round(min(($actual / $target) * 100, 999), 1);
    }

    private function getRevenueChart(Carbon $start, Carbon $end, string $periodKey, string $selectedMonth = 'all'): array
    {
        if ($periodKey === 'year' && $selectedMonth === 'all') {
            $rows = DB::table('orders')
                ->selectRaw('MONTH(COALESCE(ordered_at, created_at)) as order_month')
                ->selectRaw('SUM(total_price) as revenue')
                ->selectRaw('COUNT(*) as orders')
                ->whereBetween(
                    DB::raw('COALESCE(ordered_at, created_at)'),
                    [
                        $start->toDateTimeString(),
                        $end->toDateTimeString(),
                    ]
                )
                ->groupBy('order_month')
                ->orderBy('order_month')
                ->get()
                ->keyBy('order_month');

            $labels = [];
            $revenue = [];
            $orders = [];

            for ($month = 1; $month <= 12; $month++) {
                $labels[] = Carbon::create(null, $month, 1)->translatedFormat('M');
                $revenue[] = (int) ($rows[$month]->revenue ?? 0);
                $orders[] = (int) ($rows[$month]->orders ?? 0);
            }

            return [
                'labels' => $labels,
                'revenue' => $revenue,
                'orders' => $orders,
            ];
        }

        $rows = DB::table('orders')
            ->selectRaw('DATE(COALESCE(ordered_at, created_at)) as order_date')
            ->selectRaw('SUM(total_price) as revenue')
            ->selectRaw('COUNT(*) as orders')
            ->whereBetween(
                DB::raw('COALESCE(ordered_at, created_at)'),
                [
                    $start->toDateTimeString(),
                    $end->toDateTimeString(),
                ]
            )
            ->groupBy('order_date')
            ->orderBy('order_date')
            ->get()
            ->keyBy('order_date');

        $labels = [];
        $revenue = [];
        $orders = [];

        foreach (CarbonPeriod::create($start->copy()->startOfDay(), '1 day', $end->copy()->startOfDay()) as $date) {
            $key = $date->format('Y-m-d');

            $labels[] = $date->format('d M');
            $revenue[] = (int) ($rows[$key]->revenue ?? 0);
            $orders[] = (int) ($rows[$key]->orders ?? 0);
        }

        return [
            'labels' => $labels,
            'revenue' => $revenue,
            'orders' => $orders,
        ];
    }

    private function getProductSales(Carbon $start, Carbon $end): array
    {
        $rows = DB::table('order_items')
            ->join('orders', 'orders.id', '=', 'order_items.order_id')
            ->leftJoin('products', 'products.id', '=', 'order_items.product_id')
            ->leftJoin('categories', 'categories.id', '=', 'products.category_id')
            ->selectRaw('COALESCE(order_items.product_name, products.name, "Produk") as name')
            ->selectRaw('COALESCE(categories.name, "Tanpa Kategori") as category')
            ->selectRaw('SUM(order_items.quantity) as units')
            ->selectRaw('SUM(order_items.subtotal) as revenue')
            ->whereBetween(
                DB::raw('COALESCE(orders.ordered_at, orders.created_at)'),
                [
                    $start->toDateTimeString(),
                    $end->toDateTimeString(),
                ]
            )
            ->groupByRaw('COALESCE(order_items.product_name, products.name, "Produk")')
            ->groupByRaw('COALESCE(categories.name, "Tanpa Kategori")')
            ->orderByDesc('units')
            ->get();

        $items = $rows->map(function ($row): array {
            return [
                'name' => (string) $row->name,
                'category' => (string) $row->category,
                'units' => (int) $row->units,
                'revenue' => (int) $row->revenue,
            ];
        })->values()->all();

        return [
            'items' => $items,
            'labels' => $rows->pluck('name')->values()->all(),
            'units' => $rows->pluck('units')->map(fn ($value): int => (int) $value)->values()->all(),
            'revenue' => $rows->pluck('revenue')->map(fn ($value): int => (int) $value)->values()->all(),
        ];
    }

    private function getCategoryContribution(Carbon $start, Carbon $end): array
    {
        $rows = DB::table('order_items')
            ->join('orders', 'orders.id', '=', 'order_items.order_id')
            ->leftJoin('products', 'products.id', '=', 'order_items.product_id')
            ->leftJoin('categories', 'categories.id', '=', 'products.category_id')
            ->selectRaw('COALESCE(categories.name, "Lainnya") as name')
            ->selectRaw('SUM(order_items.subtotal) as revenue')
            ->whereBetween(
                DB::raw('COALESCE(orders.ordered_at, orders.created_at)'),
                [
                    $start->toDateTimeString(),
                    $end->toDateTimeString(),
                ]
            )
            ->groupByRaw('COALESCE(categories.name, "Lainnya")')
            ->orderByDesc('revenue')
            ->limit(5)
            ->get();

        if ($rows->isEmpty()) {
            return [
                'labels' => ['Belum ada data'],
                'values' => [1],
                'summary' => [
                    [
                        'name' => 'Belum ada data',
                        'percentage' => 0,
                        'revenue' => 0,
                    ],
                ],
            ];
        }

        $total = max(1, (int) $rows->sum('revenue'));

        return [
            'labels' => $rows->pluck('name')->values()->all(),
            'values' => $rows->pluck('revenue')->map(fn ($value): int => (int) $value)->values()->all(),
            'summary' => $rows->map(function ($row) use ($total): array {
                return [
                    'name' => $row->name,
                    'percentage' => round(((int) $row->revenue / $total) * 100),
                    'revenue' => (int) $row->revenue,
                ];
            })->values()->all(),
        ];
    }

    private function getSalesByTime(Carbon $start, Carbon $end): array
    {
        $rows = DB::table('orders')
            ->selectRaw('HOUR(COALESCE(ordered_at, created_at)) as hour')
            ->selectRaw('COUNT(*) as orders')
            ->whereBetween(
                DB::raw('COALESCE(ordered_at, created_at)'),
                [
                    $start->toDateTimeString(),
                    $end->toDateTimeString(),
                ]
            )
            ->groupBy('hour')
            ->orderBy('hour')
            ->get()
            ->keyBy('hour');

        $labels = [];
        $orders = [];

        for ($hour = 6; $hour <= 22; $hour++) {
            $labels[] = $hour % 2 === 0
                ? str_pad((string) $hour, 2, '0', STR_PAD_LEFT) . ':00'
                : '';

            $orders[] = (int) ($rows[$hour]->orders ?? 0);
        }

        return [
            'labels' => $labels,
            'orders' => $orders,
        ];
    }

    private function getLatestOrders(): array
    {
        return DB::table('orders')
            ->select('order_code', 'total_item', 'total_price', 'status', 'ordered_at', 'created_at')
            ->orderByDesc(DB::raw('COALESCE(ordered_at, created_at)'))
            ->limit(5)
            ->get()
            ->map(function ($order): array {
                $time = Carbon::parse($order->ordered_at ?? $order->created_at);

                return [
                    'order_code' => $order->order_code,
                    'time' => $time->format('d M Y H:i'),
                    'items' => (int) $order->total_item,
                    'total' => (int) $order->total_price,
                    'status' => $order->status,
                ];
            })
            ->values()
            ->all();
    }

    private function trendPercent(int|float $current, int|float $previous): ?float
    {
        if ($previous <= 0) {
            return $current > 0 ? 100.0 : 0.0;
        }

        return round((($current - $previous) / $previous) * 100, 1);
    }
}