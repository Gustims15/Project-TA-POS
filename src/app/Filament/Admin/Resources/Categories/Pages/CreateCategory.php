<?php

declare(strict_types=1);

namespace App\Filament\Admin\Resources\Categories\Pages;

use App\Filament\Admin\Resources\Categories\CategoryResource;
use Filament\Resources\Pages\CreateRecord;

class CreateCategory extends CreateRecord
{
    protected static string $resource = CategoryResource::class;

    protected ?string $heading = 'Tambah Kategori Baru';

    protected ?string $subheading = 'Buat kategori baru untuk mengelompokkan produk minuman UMKM Ngunjuk.';
}
