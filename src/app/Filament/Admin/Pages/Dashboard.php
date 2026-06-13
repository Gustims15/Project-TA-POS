<?php

declare(strict_types=1);

namespace App\Filament\Admin\Pages;

use BackedEnum;
use Carbon\Carbon;
use Carbon\CarbonPeriod;
use Filament\Pages\Dashboard as BaseDashboard;
use Illuminate\Support\Facades\DB;

class Dashboard extends BaseDashboard
{
    protected static ?string $navigationLabel = 'Dashboard';

    protected static ?string $title = '';

    protected static string|BackedEnum|null $navigationIcon = 'heroicon-o-squares-2x2';

    protected static ?int $navigationSort = 0;

    protected string $view = 'filament.admin.pages.dashboard';

    public static function canAccess(): bool
    {
        return auth()->check()
            && auth()->user()->hasRole('super_admin');
    }

    public static function shouldRegisterNavigation(): bool
    {
        return auth()->check()
            && auth()->user()->hasRole('super_admin');
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
        [$start, $end, $periodLabel, $periodKey] = $this->getSelectedRange();

        $previousRange = $this->getPreviousRange($start, $end);

        $revenue = (int) $this->ordersBetween($start, $end)->sum('total_price');
        $previousRevenue = (int) $this->ordersBetween($previousRange[0], $previousRange[1])->sum('total_price');

        $totalOrders = (int) $this->ordersBetween($start, $end)->count();
        $previousOrders = (int) $this->ordersBetween($previousRange[0], $previousRange[1])->count();

        $unitsSold = (int) $this->ordersBetween($start, $end)->sum('total_item');
        $previousUnits = (int) $this->ordersBetween($previousRange[0], $previousRange[1])->sum('total_item');

        $avgOrder = $totalOrders > 0 ? (int) round($revenue / $totalOrders) : 0;
        $previousAvgOrder = $previousOrders > 0 ? (int) round($previousRevenue / $previousOrders) : 0;

        $totalProduct = (int) DB::table('products')
            ->where('is_active', true)
            ->count();

        $lowStock = (int) DB::table('products')
            ->where('stock', '<=', 10)
            ->count();

        return [
            'period' => [
                'key' => $periodKey,
                'label' => $periodLabel,
                'start' => $start->format('d M Y'),
                'end' => $end->format('d M Y'),
            ],

            'metrics' => [
                [
                    'label' => 'Revenue Hari Ini',
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
                [
                    'label' => 'Total Product',
                    'value' => number_format($totalProduct, 0, ',', '.'),
                    'trend' => null,
                    'caption' => 'Produk aktif',
                    'icon' => '◇',
                    'color' => '#10b981',
                ],
                [
                    'label' => 'Stok Habis / Low',
                    'value' => number_format($lowStock, 0, ',', '.'),
                    'trend' => null,
                    'caption' => 'Perlu restock',
                    'icon' => '!',
                    'color' => '#ef4444',
                ],
            ],

            'charts' => [
                'revenue' => $this->getRevenueChart($start, $end),
                'topProducts' => $this->getProductSales($start, $end),
                'category' => $this->getCategoryContribution($start, $end),
                'salesByTime' => $this->getSalesByTime($start, $end),
            ],

            'stockAlerts' => $this->getStockAlerts(),
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

        return match ($period) {
            'today' => [
                now()->startOfDay(),
                now()->endOfDay(),
                'Hari Ini',
                'today',
            ],
            'month' => [
                now()->startOfMonth(),
                now()->endOfMonth(),
                'Bulan Ini',
                'month',
            ],
            default => [
                now()->subDays(6)->startOfDay(),
                now()->endOfDay(),
                '7 Hari Terakhir',
                'week',
            ],
        };
    }

    private function getPreviousRange(Carbon $start, Carbon $end): array
    {
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

    private function getRevenueChart(Carbon $start, Carbon $end): array
    {
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
            ->selectRaw('COALESCE(products.stock, 0) as stock')
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
            ->groupByRaw('COALESCE(products.stock, 0)')
            ->orderByDesc('units')
            ->get();

        $items = $rows->map(function ($row) {
            return [
                'name' => (string) $row->name,
                'category' => (string) $row->category,
                'units' => (int) $row->units,
                'revenue' => (int) $row->revenue,
                'stock' => (int) $row->stock,
            ];
        })->values()->all();

        return [
            'items' => $items,
            'labels' => $rows->pluck('name')->values()->all(),
            'units' => $rows->pluck('units')->map(fn ($value) => (int) $value)->values()->all(),
            'revenue' => $rows->pluck('revenue')->map(fn ($value) => (int) $value)->values()->all(),
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
            'values' => $rows->pluck('revenue')->map(fn ($value) => (int) $value)->values()->all(),
            'summary' => $rows->map(function ($row) use ($total) {
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

    private function getStockAlerts(): array
    {
        return DB::table('products')
            ->select('name', 'stock', 'image')
            ->orderBy('stock')
            ->limit(5)
            ->get()
            ->map(function ($product) {
                $stock = (int) $product->stock;

                $status = match (true) {
                    $stock <= 0 => 'Habis',
                    $stock <= 10 => 'Low',
                    default => 'Aman',
                };

                return [
                    'name' => $product->name,
                    'stock' => $stock,
                    'status' => $status,
                    'image' => $product->image
                        ? asset('storage/' . ltrim((string) $product->image, '/'))
                        : null,
                ];
            })
            ->values()
            ->all();
    }

    private function getLatestOrders(): array
    {
        return DB::table('orders')
            ->select('order_code', 'total_item', 'total_price', 'status', 'ordered_at', 'created_at')
            ->orderByDesc(DB::raw('COALESCE(ordered_at, created_at)'))
            ->limit(5)
            ->get()
            ->map(function ($order) {
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