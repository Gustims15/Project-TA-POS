<?php

declare(strict_types=1);

namespace App\Filament\Admin\Widgets;

use App\Models\Product;
use Filament\Widgets\Widget;

class RestockPriorityChart extends Widget
{
    protected string $view = 'filament.admin.widgets.restock-priority-chart';

    protected int|string|array $columnSpan = [
        'default' => 1,
        'md' => 1,
        'xl' => 6,
    ];

    protected function getViewData(): array
    {
        $safeLimit = 10;

        $criticalCount = (int) Product::query()
            ->where('stock', '<=', 0)
            ->count();

        $lowCount = (int) Product::query()
            ->where('stock', '>', 0)
            ->where('stock', '<=', 2)
            ->count();

        $warningCount = (int) Product::query()
            ->where('stock', '>', 2)
            ->where('stock', '<=', 5)
            ->count();

        $safeCount = (int) Product::query()
            ->where('stock', '>', 5)
            ->count();

        $totalProducts = max($criticalCount + $lowCount + $warningCount + $safeCount, 1);

        $distribution = [
            [
                'label' => 'Aman',
                'count' => $safeCount,
                'class' => 'safe',
                'width' => round(($safeCount / $totalProducts) * 100, 2),
            ],
            [
                'label' => 'Waspada',
                'count' => $warningCount,
                'class' => 'warning',
                'width' => round(($warningCount / $totalProducts) * 100, 2),
            ],
            [
                'label' => 'Rendah',
                'count' => $lowCount,
                'class' => 'low',
                'width' => round(($lowCount / $totalProducts) * 100, 2),
            ],
            [
                'label' => 'Kritis',
                'count' => $criticalCount,
                'class' => 'critical',
                'width' => round(($criticalCount / $totalProducts) * 100, 2),
            ],
        ];

        /*
        |--------------------------------------------------------------------------
        | Top Risk Products
        |--------------------------------------------------------------------------
        | Dashboard BI sebaiknya hanya menampilkan produk bermasalah.
        | Jadi produk dengan stok aman tidak ikut masuk daftar prioritas.
        */
        $products = Product::query()
            ->where('stock', '<=', 5)
            ->orderBy('stock')
            ->orderBy('name')
            ->limit(5)
            ->get(['name', 'stock']);

        $items = $products
            ->map(function ($product) use ($safeLimit): array {
                $stock = max((int) $product->stock, 0);

                if ($stock <= 0) {
                    $status = 'Kritis';
                    $statusClass = 'critical';
                } elseif ($stock <= 2) {
                    $status = 'Rendah';
                    $statusClass = 'low';
                } else {
                    $status = 'Waspada';
                    $statusClass = 'warning';
                }

                return [
                    'name' => (string) $product->name,
                    'stock' => $stock,
                    'status' => $status,
                    'statusClass' => $statusClass,
                    'width' => $safeLimit > 0 ? min(round(($stock / $safeLimit) * 100, 2), 100) : 0,
                    'safeLimit' => $safeLimit,
                ];
            })
            ->toArray();

        return [
            'items' => $items,
            'distribution' => $distribution,
            'safeLimit' => $safeLimit,
            'totalProducts' => $totalProducts,
            'riskProducts' => $criticalCount + $lowCount + $warningCount,
        ];
    }
}