<?php

declare(strict_types=1);

namespace App\Filament\Admin\Pages;

use App\Models\Order;
use Carbon\Carbon;
use Filament\Actions\Action;
use Filament\Pages\Page;
use Illuminate\Support\Facades\DB;
use Symfony\Component\HttpFoundation\StreamedResponse;
use UnitEnum;

class MonthlyRevenueReport extends Page
{
    protected static string|\BackedEnum|null $navigationIcon = 'heroicon-o-arrow-down-tray';

    protected static ?string $navigationLabel = 'Export Monthly Revenue';

    protected static ?string $title = 'Export Monthly Revenue';

    protected static string|UnitEnum|null $navigationGroup = 'Transaksi';

    protected static ?int $navigationSort = 2;

    protected string $view = 'filament.admin.pages.monthly-revenue-report';

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

    protected function getHeaderActions(): array
    {
        return [
            Action::make('exportSelectedMonth')
                ->label('Download Laporan Bulan Ini')
                ->icon('heroicon-o-arrow-down-tray')
                ->color('success')
                ->action(fn (): StreamedResponse => $this->exportSelectedMonth()),
        ];
    }

    protected function getViewData(): array
    {
        $selectedMonth = $this->getSelectedMonth();
        [$startDate, $endDate] = $this->getMonthRange($selectedMonth);

        $orders = Order::query()
            ->where('status', 'Selesai')
            ->whereBetween(DB::raw('COALESCE(ordered_at, created_at)'), [
                $startDate,
                $endDate,
            ])
            ->orderByDesc(DB::raw('COALESCE(ordered_at, created_at)'))
            ->get();

        $totalOrders = (int) $orders->count();
        $totalItems = (int) $orders->sum('total_item');
        $totalRevenue = (int) $orders->sum('total_price');

        $avgOrder = $totalOrders > 0
            ? (int) round($totalRevenue / $totalOrders)
            : 0;

        return [
            'months' => $this->getAvailableMonths(),
            'selectedMonth' => $selectedMonth,
            'selectedMonthLabel' => Carbon::createFromFormat('Y-m', $selectedMonth)->translatedFormat('F Y'),
            'orders' => $orders,
            'summary' => [
                'total_orders' => $totalOrders,
                'total_items' => $totalItems,
                'total_revenue' => $totalRevenue,
                'avg_order' => $avgOrder,
            ],
        ];
    }

    private function getAvailableMonths(): array
    {
        $months = Order::query()
            ->where('status', 'Selesai')
            ->select([
                DB::raw("DATE_FORMAT(COALESCE(ordered_at, created_at), '%Y-%m') as month_key"),
            ])
            ->groupBy('month_key')
            ->orderByDesc('month_key')
            ->pluck('month_key')
            ->filter()
            ->values()
            ->toArray();

        if (empty($months)) {
            return [
                now()->format('Y-m'),
            ];
        }

        return $months;
    }

    private function getSelectedMonth(): string
    {
        $month = request()->query('month');

        if (! $month) {
            $referer = request()->headers->get('referer');

            if ($referer) {
                $query = parse_url($referer, PHP_URL_QUERY);

                if ($query) {
                    parse_str($query, $params);

                    $month = $params['month'] ?? null;
                }
            }
        }

        $availableMonths = $this->getAvailableMonths();

        $month = (string) ($month ?: $availableMonths[0]);

        if (! preg_match('/^\d{4}-\d{2}$/', $month)) {
            return $availableMonths[0];
        }

        if (! in_array($month, $availableMonths, true)) {
            return $availableMonths[0];
        }

        return $month;
    }

    private function getMonthRange(string $month): array
    {
        $date = Carbon::createFromFormat('Y-m', $month);

        return [
            $date->copy()->startOfMonth(),
            $date->copy()->endOfMonth(),
        ];
    }

    private function exportSelectedMonth(): StreamedResponse
    {
        abort_unless(
            auth()->check() && auth()->user()->hasRole('super_admin'),
            403
        );

        $selectedMonth = $this->getSelectedMonth();
        [$startDate, $endDate] = $this->getMonthRange($selectedMonth);

        $orders = Order::query()
            ->where('status', 'Selesai')
            ->whereBetween(DB::raw('COALESCE(ordered_at, created_at)'), [
                $startDate,
                $endDate,
            ])
            ->orderBy(DB::raw('COALESCE(ordered_at, created_at)'))
            ->get();

        $monthLabel = Carbon::createFromFormat('Y-m', $selectedMonth)->translatedFormat('F Y');

        $totalOrders = (int) $orders->count();
        $totalItems = (int) $orders->sum('total_item');
        $totalRevenue = (int) $orders->sum('total_price');

        $avgOrder = $totalOrders > 0
            ? (int) round($totalRevenue / $totalOrders)
            : 0;

        $fileName = 'monthly-revenue-ngunjuk-' . $selectedMonth . '.xls';

        return response()->streamDownload(function () use (
            $orders,
            $monthLabel,
            $totalOrders,
            $totalItems,
            $totalRevenue,
            $avgOrder
        ): void {
            echo '
                <html>
                <head>
                    <meta charset="UTF-8">
                    <style>
                        body {
                            font-family: Arial, sans-serif;
                            color: #111827;
                        }

                        .title {
                            font-size: 24px;
                            font-weight: bold;
                            color: #0f766e;
                            text-align: center;
                        }

                        .subtitle {
                            font-size: 13px;
                            color: #6b7280;
                            text-align: center;
                        }

                        table {
                            border-collapse: collapse;
                            width: 100%;
                        }

                        .summary td {
                            border: 1px solid #d1d5db;
                            padding: 10px;
                        }

                        .summary-label {
                            background: #ccfbf1;
                            color: #115e59;
                            font-weight: bold;
                        }

                        .summary-value {
                            background: #f9fafb;
                            font-weight: bold;
                        }

                        .data th {
                            background: #0f766e;
                            color: white;
                            border: 1px solid #0f766e;
                            padding: 9px;
                            font-weight: bold;
                            text-align: center;
                        }

                        .data td {
                            border: 1px solid #d1d5db;
                            padding: 9px;
                        }

                        .center {
                            text-align: center;
                        }

                        .right {
                            text-align: right;
                        }

                        .total td {
                            background: #ecfdf5;
                            font-weight: bold;
                            color: #064e3b;
                        }
                    </style>
                </head>
                <body>
                    <table>
                        <tr>
                            <td colspan="6" class="title">
                                LAPORAN MONTHLY REVENUE
                            </td>
                        </tr>
                        <tr>
                            <td colspan="6" class="subtitle">
                                Sistem Informasi Point of Sale UMKM Ngunjuk
                            </td>
                        </tr>
                        <tr>
                            <td colspan="6" class="subtitle">
                                Periode: ' . e($monthLabel) . '
                            </td>
                        </tr>
                    </table>

                    <br>

                    <table class="summary">
                        <tr>
                            <td class="summary-label">Total Orders</td>
                            <td class="summary-value">' . number_format($totalOrders, 0, ',', '.') . '</td>
                            <td class="summary-label">Units Sold</td>
                            <td class="summary-value">' . number_format($totalItems, 0, ',', '.') . '</td>
                        </tr>
                        <tr>
                            <td class="summary-label">Total Revenue</td>
                            <td class="summary-value">Rp ' . number_format($totalRevenue, 0, ',', '.') . '</td>
                            <td class="summary-label">Avg Order</td>
                            <td class="summary-value">Rp ' . number_format($avgOrder, 0, ',', '.') . '</td>
                        </tr>
                    </table>

                    <br>

                    <table class="data">
                        <thead>
                            <tr>
                                <th>No</th>
                                <th>ID Order</th>
                                <th>Tanggal</th>
                                <th>Total Item</th>
                                <th>Total Revenue</th>
                                <th>Status</th>
                            </tr>
                        </thead>
                        <tbody>';

            $no = 1;

            foreach ($orders as $order) {
                $date = $order->ordered_at ?? $order->created_at;

                echo '
                    <tr>
                        <td class="center">' . $no++ . '</td>
                        <td>' . e($order->order_code ?? ('ORD-' . $order->id)) . '</td>
                        <td class="center">' . e(Carbon::parse($date)->translatedFormat('d F Y H:i')) . '</td>
                        <td class="center">' . number_format((int) $order->total_item, 0, ',', '.') . '</td>
                        <td class="right">Rp ' . number_format((int) $order->total_price, 0, ',', '.') . '</td>
                        <td class="center">' . e($order->status) . '</td>
                    </tr>';
            }

            echo '
                            <tr class="total">
                                <td colspan="3" class="center">TOTAL</td>
                                <td class="center">' . number_format($totalItems, 0, ',', '.') . '</td>
                                <td class="right">Rp ' . number_format($totalRevenue, 0, ',', '.') . '</td>
                                <td></td>
                            </tr>
                        </tbody>
                    </table>
                </body>
                </html>
            ';
        }, $fileName, [
            'Content-Type' => 'application/vnd.ms-excel; charset=UTF-8',
        ]);
    }
}