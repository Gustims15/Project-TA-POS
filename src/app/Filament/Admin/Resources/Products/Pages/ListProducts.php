<?php

declare(strict_types=1);

namespace App\Filament\Admin\Resources\Products\Pages;

use App\Filament\Admin\Resources\Products\ProductResource;
use App\Filament\Admin\Resources\Products\Widgets\ProductAnalyticsWidget;
use Filament\Resources\Pages\ListRecords;

class ListProducts extends ListRecords
{
    protected static string $resource = ProductResource::class;

    public function getTitle(): string
    {
        return '';
    }

    protected function getHeaderWidgets(): array
    {
        return [
            ProductAnalyticsWidget::class,
        ];
    }

    protected function getHeaderActions(): array
    {
        return [];
    }
}