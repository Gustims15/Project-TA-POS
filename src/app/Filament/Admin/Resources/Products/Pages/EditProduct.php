<?php

declare(strict_types=1);

namespace App\Filament\Admin\Resources\Products\Pages;

use App\Filament\Admin\Resources\Products\ProductResource;
use Filament\Actions\DeleteAction;
use Filament\Resources\Pages\EditRecord;

class EditProduct extends EditRecord
{
    protected static string $resource = ProductResource::class;

    protected ?string $heading = 'Edit Produk';

    protected ?string $subheading = 'Perbarui data produk, kategori, stok, gambar, ukuran, harga, dan status aktif.';

    protected function getHeaderActions(): array
    {
        return [
            DeleteAction::make()
                ->label('Hapus Produk')
                ->icon('heroicon-o-trash')
                ->color('danger'),
        ];
    }
}
