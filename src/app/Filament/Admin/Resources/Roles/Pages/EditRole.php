<?php

declare(strict_types=1);

namespace App\Filament\Admin\Resources\Roles\Pages;

use App\Filament\Admin\Resources\Roles\RoleResource;
use App\Filament\Admin\Resources\Roles\Widgets\RoleFormHeroWidget;
use Filament\Actions\Action;
use Filament\Actions\DeleteAction;
use Filament\Actions\ViewAction;
use Filament\Resources\Pages\EditRecord;

class EditRole extends EditRecord
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

    protected function getHeaderActions(): array
    {
        return [
            ViewAction::make()
                ->label('Detail Role')
                ->icon('heroicon-o-eye')
                ->color('gray'),

            DeleteAction::make()
                ->label('Hapus Role')
                ->icon('heroicon-o-trash')
                ->color('danger'),
        ];
    }

    protected function getRedirectUrl(): string
    {
        return RoleResource::getUrl('index');
    }

    protected function getSaveFormAction(): Action
    {
        return parent::getSaveFormAction()
            ->label('Simpan Perubahan')
            ->icon('heroicon-o-check-circle');
    }

    protected function getCancelFormAction(): Action
    {
        return parent::getCancelFormAction()
            ->label('Batal');
    }

    protected function getSavedNotificationTitle(): ?string
    {
        return 'Role berhasil diperbarui';
    }
}