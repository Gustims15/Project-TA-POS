<?php

declare(strict_types=1);

namespace App\Filament\Admin\Resources\OperationalCosts\Tables;

use App\Filament\Admin\Resources\OperationalCosts\OperationalCostResource;
use Filament\Actions\BulkActionGroup;
use Filament\Actions\CreateAction;
use Filament\Actions\DeleteBulkAction;
use Filament\Actions\EditAction;
use Filament\Tables\Columns\IconColumn;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;

class OperationalCostsTable
{
    public static function configure(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('name')
                    ->label('Nama Biaya')
                    ->searchable()
                    ->sortable()
                    ->weight('bold')
                    ->description(fn ($record): string => self::categoryLabel((string) $record->category)),

                TextColumn::make('amount')
                    ->label('Nominal')
                    ->sortable()
                    ->alignEnd()
                    ->formatStateUsing(fn ($state): string => 'Rp ' . number_format((int) $state, 0, ',', '.')),

                TextColumn::make('cost_date')
                    ->label('Tanggal')
                    ->date('d M Y')
                    ->sortable(),

                IconColumn::make('is_active')
                    ->label('Aktif')
                    ->boolean()
                    ->trueIcon('heroicon-o-check-circle')
                    ->falseIcon('heroicon-o-x-circle')
                    ->trueColor('success')
                    ->falseColor('danger'),

                TextColumn::make('note')
                    ->label('Catatan')
                    ->limit(35)
                    ->toggleable(),

                TextColumn::make('created_at')
                    ->label('Dibuat')
                    ->dateTime('d M Y H:i')
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
            ])
            ->headerActions([
                CreateAction::make('create')
                    ->label('Tambah Biaya Operasional')
                    ->icon('heroicon-o-plus')
                    ->color('warning')
                    ->url(OperationalCostResource::getUrl('create')),
            ])
            ->recordActions([
                EditAction::make()
                    ->label('Edit')
                    ->icon('heroicon-o-pencil-square')
                    ->color('primary'),
            ])
            ->toolbarActions([
                BulkActionGroup::make([
                    DeleteBulkAction::make()
                        ->label('Hapus Biaya'),
                ]),
            ])
            ->emptyStateIcon('heroicon-o-receipt-percent')
            ->emptyStateHeading('No Biaya Operasional')
            ->emptyStateDescription('Tambahkan biaya seperti sewa tempat, listrik, air, wifi, gaji, promosi, dan biaya lain.')
            ->emptyStateActions([
                CreateAction::make('createEmpty')
                    ->label('Tambah Biaya Operasional')
                    ->icon('heroicon-o-plus')
                    ->color('warning')
                    ->url(OperationalCostResource::getUrl('create')),
            ])
            ->defaultSort('cost_date', 'desc');
    }

    private static function categoryLabel(string $category): string
    {
        return match ($category) {
            'rent' => 'Sewa Tempat',
            'electricity' => 'Listrik',
            'water' => 'Air',
            'internet' => 'Wifi / Internet',
            'salary' => 'Gaji',
            'marketing' => 'Promosi / Marketing',
            'maintenance' => 'Maintenance',
            default => 'Lainnya',
        };
    }
}