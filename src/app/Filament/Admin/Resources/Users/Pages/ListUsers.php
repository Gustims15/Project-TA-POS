<?php

declare(strict_types=1);

namespace App\Filament\Admin\Resources\Users\Pages;

use App\Filament\Admin\Resources\Users\UserResource;
use App\Filament\Admin\Resources\Users\Widgets\UserAnalyticsWidget;
use Filament\Actions\CreateAction;
use Filament\Resources\Pages\ListRecords;
use Filament\Support\Icons\Heroicon;

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

    protected function getHeaderActions(): array
    {
        return [
            CreateAction::make()
                ->label('Add New User')
                ->icon(Heroicon::Plus)
                ->color('primary'),
        ];
    }
}
