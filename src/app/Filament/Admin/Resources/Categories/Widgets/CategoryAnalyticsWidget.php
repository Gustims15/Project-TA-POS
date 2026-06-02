<?php

declare(strict_types=1);

namespace App\Filament\Admin\Resources\Categories\Widgets;

use App\Models\Category;
use App\Models\Product;
use Filament\Widgets\Widget;

class CategoryAnalyticsWidget extends Widget
{
    protected string $view = 'filament.admin.resources.categories.widgets.category-analytics-widget';

    protected int|string|array $columnSpan = 'full';

    protected function getViewData(): array
    {
        $totalCategories = Category::query()->count();

        $activeCategories = Category::query()
            ->where('is_active', true)
            ->count();

        $inactiveCategories = Category::query()
            ->where('is_active', false)
            ->count();

        $totalProducts = Product::query()->count();

        $topCategory = Category::query()
            ->withCount('products')
            ->orderByDesc('products_count')
            ->first();

        return [
            'summary' => [
                'total_categories' => (int) $totalCategories,
                'active_categories' => (int) $activeCategories,
                'inactive_categories' => (int) $inactiveCategories,
                'total_products' => (int) $totalProducts,
                'top_category_name' => $topCategory?->name ?? '-',
                'top_category_products' => (int) ($topCategory?->products_count ?? 0),
            ],
        ];
    }
}
