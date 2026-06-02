<?php

declare(strict_types=1);

namespace App\Filament\Admin\Resources\Products\Pages;

use App\Filament\Admin\Resources\Products\ProductResource;
use App\Filament\Admin\Resources\Products\Widgets\ProductAnalyticsWidget;
use Filament\Actions\CreateAction;
use Filament\Resources\Pages\ListRecords;

class ListProducts extends ListRecords
{
    protected static string $resource = ProductResource::class;

    protected ?string $heading = 'Produk';

    protected ?string $subheading = 'Kelola produk minuman, kategori, ukuran, harga, stok, gambar, dan status aktif produk.';

    protected function getHeaderWidgets(): array
    {
        return [
            ProductAnalyticsWidget::class,
        ];
    }

    protected function getHeaderActions(): array
    {
        return [
            CreateAction::make()
                ->label('New Produk')
                ->icon('heroicon-o-plus')
                ->color('primary'),
        ];
    }
}
