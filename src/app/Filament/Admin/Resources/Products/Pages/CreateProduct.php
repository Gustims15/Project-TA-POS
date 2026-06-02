<?php

declare(strict_types=1);

namespace App\Filament\Admin\Resources\Products\Pages;

use App\Filament\Admin\Resources\Products\ProductResource;
use Filament\Resources\Pages\CreateRecord;

class CreateProduct extends CreateRecord
{
    protected static string $resource = ProductResource::class;

    protected ?string $heading = 'Tambah Produk Baru';

    protected ?string $subheading = 'Masukkan data produk, stok, gambar, ukuran, dan harga produk UMKM Ngunjuk.';
}
