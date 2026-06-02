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

    protected function getViewData(): array
    {
        $totalProducts = Product::query()->count();

        $activeProducts = Product::query()
            ->where('is_active', true)
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

        return [
            'summary' => [
                'total_products' => (int) $totalProducts,
                'active_products' => (int) $activeProducts,
                'out_of_stock_products' => (int) $outOfStockProducts,
                'low_stock_products' => (int) $lowStockProducts,
                'total_categories' => (int) $totalCategories,
                'total_stock' => (int) $totalStock,
            ],
        ];
    }
}
