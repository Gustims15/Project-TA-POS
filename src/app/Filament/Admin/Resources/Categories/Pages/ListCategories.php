<?php

declare(strict_types=1);

namespace App\Filament\Admin\Resources\Categories\Pages;

use App\Filament\Admin\Resources\Categories\CategoryResource;
use App\Filament\Admin\Resources\Categories\Widgets\CategoryAnalyticsWidget;
use Filament\Actions\CreateAction;
use Filament\Resources\Pages\ListRecords;

class ListCategories extends ListRecords
{
    protected static string $resource = CategoryResource::class;

    protected ?string $heading = 'Kategori';

    protected ?string $subheading = 'Kelola kategori produk agar data menu minuman lebih rapi, terstruktur, dan mudah dipantau.';

    protected function getHeaderWidgets(): array
    {
        return [
            CategoryAnalyticsWidget::class,
        ];
    }

   protected function getHeaderActions(): array
    {
    return [];  
    }
}
