<?php

declare(strict_types=1);

namespace App\Filament\Admin\Resources\Categories\Pages;

use App\Filament\Admin\Resources\Categories\CategoryResource;
use Filament\Actions\DeleteAction;
use Filament\Resources\Pages\EditRecord;

class EditCategory extends EditRecord
{
    protected static string $resource = CategoryResource::class;

    protected ?string $heading = 'Edit Kategori';

    protected ?string $subheading = 'Perbarui nama kategori, slug, dan status aktif kategori produk.';

    protected function getHeaderActions(): array
    {
        return [
            DeleteAction::make()
                ->label('Hapus Kategori')
                ->icon('heroicon-o-trash')
                ->color('danger'),
        ];
    }
}
