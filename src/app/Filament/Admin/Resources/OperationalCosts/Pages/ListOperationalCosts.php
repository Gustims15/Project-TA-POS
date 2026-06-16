<?php

namespace App\Filament\Admin\Resources\OperationalCosts\Pages;

use App\Filament\Admin\Resources\OperationalCosts\OperationalCostResource;
use App\Filament\Admin\Resources\OperationalCosts\Widgets\OperationalCostAnalyticsWidget;
use Filament\Actions\CreateAction;
use Filament\Resources\Pages\ListRecords;

class ListOperationalCosts extends ListRecords
{
    protected static string $resource = OperationalCostResource::class;

    protected function getHeaderWidgets(): array
    {
        return [
            OperationalCostAnalyticsWidget::class,
        ];
    }

    protected function getHeaderActions(): array
    {
        return [
            CreateAction::make()
                ->label('Tambah Biaya Operasional')
                ->icon('heroicon-o-plus')
                ->color('warning'),
        ];
    }
}