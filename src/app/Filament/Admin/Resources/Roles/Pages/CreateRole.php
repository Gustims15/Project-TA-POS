<?php

declare(strict_types=1);

namespace App\Filament\Admin\Resources\Roles\Pages;

use App\Filament\Admin\Resources\Roles\RoleResource;
use App\Filament\Admin\Resources\Roles\Widgets\RoleFormHeroWidget;
use Filament\Actions\Action;
use Filament\Resources\Pages\CreateRecord;

class CreateRole extends CreateRecord
{
    protected static string $resource = RoleResource::class;

    protected ?string $heading = '';

    protected ?string $subheading = '';

    public function getTitle(): string
    {
        return '';
    }

    protected function getHeaderWidgets(): array
    {
        return [
            RoleFormHeroWidget::class,
        ];
    }

    protected function getRedirectUrl(): string
    {
        return RoleResource::getUrl('index');
    }

    protected function getCreateFormAction(): Action
    {
        return parent::getCreateFormAction()
            ->label('Simpan Role')
            ->icon('heroicon-o-check-circle');
    }

    protected function getCancelFormAction(): Action
    {
        return parent::getCancelFormAction()
            ->label('Batal');
    }

    protected function getCreatedNotificationTitle(): ?string
    {
        return 'Role berhasil dibuat';
    }
}