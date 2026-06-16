<?php

declare(strict_types=1);

namespace App\Filament\Admin\Resources\OperationalCosts\Pages;

use App\Filament\Admin\Resources\OperationalCosts\OperationalCostResource;
use Filament\Actions\CreateAction;
use Filament\Resources\Pages\ListRecords;

class ListOperationalCosts extends ListRecords
{
    protected static string $resource = OperationalCostResource::class;

    protected function getHeaderActions(): array
    {
        return [
            CreateAction::make()
                ->label('Tambah Biaya Operasional')
                ->icon('heroicon-o-plus'),
        ];
    }
}