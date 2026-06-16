<?php

declare(strict_types=1);

namespace App\Filament\Admin\Resources\SalesTargets\Tables;

use App\Filament\Admin\Resources\SalesTargets\SalesTargetResource;
use Filament\Actions\BulkActionGroup;
use Filament\Actions\CreateAction;
use Filament\Actions\DeleteBulkAction;
use Filament\Actions\EditAction;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;

class SalesTargetsTable
{
    public static function configure(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('month')
                    ->label('Bulan')
                    ->date('M Y')
                    ->sortable(),

                TextColumn::make('target_revenue')
                    ->label('Target Revenue')
                    ->sortable()
                    ->alignEnd()
                    ->formatStateUsing(fn ($state): string => 'Rp ' . number_format((int) $state, 0, ',', '.')),

                TextColumn::make('target_gross_profit')
                    ->label('Target Gross Profit')
                    ->sortable()
                    ->alignEnd()
                    ->formatStateUsing(fn ($state): string => 'Rp ' . number_format((int) $state, 0, ',', '.')),

                TextColumn::make('target_net_profit')
                    ->label('Target Net Profit')
                    ->sortable()
                    ->alignEnd()
                    ->formatStateUsing(fn ($state): string => 'Rp ' . number_format((int) $state, 0, ',', '.')),

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
                    ->label('Tambah Target Penjualan')
                    ->icon('heroicon-o-plus')
                    ->color('warning')
                    ->url(SalesTargetResource::getUrl('create')),
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
                        ->label('Hapus Target'),
                ]),
            ])
            ->emptyStateIcon('heroicon-o-flag')
            ->emptyStateHeading('No Target Penjualan')
            ->emptyStateDescription('Tambahkan target bulanan agar dashboard dapat menghitung progress revenue dan laba.')
            ->emptyStateActions([
                CreateAction::make('createEmpty')
                    ->label('Tambah Target Penjualan')
                    ->icon('heroicon-o-plus')
                    ->color('warning')
                    ->url(SalesTargetResource::getUrl('create')),
            ])
            ->defaultSort('month', 'desc');
    }
}