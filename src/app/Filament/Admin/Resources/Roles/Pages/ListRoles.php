<?php

declare(strict_types=1);

namespace App\Filament\Admin\Resources\Roles\Pages;

use App\Filament\Admin\Resources\Roles\RoleResource;
use App\Filament\Admin\Resources\Roles\Widgets\RoleAnalyticsWidget;
use Filament\Resources\Pages\ListRecords;

class ListRoles extends ListRecords
{
    protected static string $resource = RoleResource::class;

    protected ?string $heading = 'Roles';

    protected ?string $subheading = 'Kelola role dan permission untuk mengatur hak akses pengguna sistem POS Ngunjuk.';

    protected function getHeaderWidgets(): array
    {
        return [
            RoleAnalyticsWidget::class,
        ];
    }

    /*
    |--------------------------------------------------------------------------
    | Header Actions
    |--------------------------------------------------------------------------
    | Tombol New Role di header Filament dihilangkan.
    | Tombol New Role sekarang dipindahkan ke widget hijau.
    |--------------------------------------------------------------------------
    */
    protected function getHeaderActions(): array
    {
        return [];
    }
}