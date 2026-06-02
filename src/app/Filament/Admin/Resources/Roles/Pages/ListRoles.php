<?php

declare(strict_types=1);

namespace App\Filament\Admin\Resources\Roles\Pages;

use App\Filament\Admin\Resources\Roles\RoleResource;
use App\Filament\Admin\Resources\Roles\Widgets\RoleAnalyticsWidget;
use Filament\Actions\CreateAction;
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

    protected function getHeaderActions(): array
    {
        return [
            CreateAction::make()
                ->label('New Role')
                ->icon('heroicon-o-plus')
                ->color('primary'),
        ];
    }
}
