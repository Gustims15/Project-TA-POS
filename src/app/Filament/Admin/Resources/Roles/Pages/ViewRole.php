<?php

declare(strict_types=1);

namespace App\Filament\Admin\Resources\Roles\Pages;

use App\Filament\Admin\Resources\Roles\RoleResource;
use Filament\Actions\EditAction;
use Filament\Resources\Pages\ViewRecord;

class ViewRole extends ViewRecord
{
    protected static string $resource = RoleResource::class;

    protected ?string $heading = 'Detail Role';

    protected ?string $subheading = 'Lihat informasi role dan permission yang dimiliki role ini.';

    protected function getHeaderActions(): array
    {
        return [
            EditAction::make()
                ->label('Edit Role')
                ->icon('heroicon-o-pencil-square')
                ->color('primary'),
        ];
    }
}
