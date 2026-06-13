<?php

declare(strict_types=1);

namespace App\Filament\Admin\Resources\Products\Widgets;

use App\Models\Category;
use App\Models\Product;
use Filament\Widgets\Widget;

class ProductAnalyticsWidget extends Widget
{
    protected string $view = 'filament.admin.resources.products.widgets.product-analytics-widget';

    protected int|string|array $columnSpan = 'full';

    public function getViewData(): array
    {
        $totalProducts = Product::query()->count();

        $activeProducts = Product::query()
            ->where('is_active', true)
            ->count();

        $inactiveProducts = Product::query()
            ->where('is_active', false)
            ->count();

        $outOfStockProducts = Product::query()
            ->where('stock', '<=', 0)
            ->count();

        $lowStockProducts = Product::query()
            ->where('stock', '>', 0)
            ->where('stock', '<=', 5)
            ->count();

        $totalCategories = Category::query()->count();

        $totalStock = Product::query()->sum('stock');

        $topCategory = Category::query()
            ->withCount('products')
            ->orderByDesc('products_count')
            ->first();

        return [
            'summary' => [
                'total_products' => (int) $totalProducts,
                'active_products' => (int) $activeProducts,
                'inactive_products' => (int) $inactiveProducts,
                'out_of_stock_products' => (int) $outOfStockProducts,
                'low_stock_products' => (int) $lowStockProducts,
                'total_categories' => (int) $totalCategories,
                'total_stock' => (int) $totalStock,
                'top_category_name' => $topCategory?->name ?? '-',
                'top_category_products' => (int) ($topCategory?->products_count ?? 0),
            ],
        ];
    }
}