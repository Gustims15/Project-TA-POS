<?php

declare(strict_types=1);

namespace App\Filament\Admin\Resources\Users\Pages;

use App\Filament\Admin\Resources\Users\UserResource;
use App\Filament\Admin\Resources\Users\Widgets\UserAnalyticsWidget;
use Filament\Resources\Pages\ListRecords;

final class ListUsers extends ListRecords
{
    protected static string $resource = UserResource::class;

    protected ?string $heading = 'Users';

    protected ?string $subheading = 'Kelola akun super admin dan karyawan yang memiliki akses ke sistem POS Ngunjuk.';

    protected function getHeaderWidgets(): array
    {
        return [
            UserAnalyticsWidget::class,
        ];
    }

    /*
    |--------------------------------------------------------------------------
    | Header Actions
    |--------------------------------------------------------------------------
    | Tombol Add New User di header Filament dihilangkan.
    | Tombol Add New User sekarang dipindahkan ke widget hijau.
    |--------------------------------------------------------------------------
    */
    protected function getHeaderActions(): array
    {
        return [];
    }
}