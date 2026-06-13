<?php

declare(strict_types=1);

namespace App\Filament\Admin\Resources\Categories\Tables;

use Filament\Actions\BulkActionGroup;
use Filament\Actions\DeleteBulkAction;
use Filament\Actions\EditAction;
use Filament\Tables\Columns\IconColumn;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;

class CategoriesTable
{
    public static function configure(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('name')
                    ->label('Nama Kategori')
                    ->searchable()
                    ->sortable()
                    ->html()
                    ->formatStateUsing(function (?string $state): string {
                        $name = $state ?: '-';
                        $initial = mb_strtoupper(mb_substr($name, 0, 1));

                        return '
                            <div style="display:flex;align-items:center;gap:12px;min-width:210px;">
                                <div style="
                                    width:42px;
                                    height:42px;
                                    border-radius:15px;
                                    display:grid;
                                    place-items:center;
                                    color:#fff;
                                    font-size:15px;
                                    font-weight:950;
                                    background:linear-gradient(135deg,#ff9d18,#ee6500);
                                    box-shadow:0 12px 24px rgba(238,101,0,.22);
                                ">
                                    ' . e($initial) . '
                                </div>

                                <div style="min-width:0;">
                                    <div style="
                                        color:#23160d;
                                        font-size:13px;
                                        font-weight:950;
                                        line-height:1.25;
                                    ">
                                        ' . e($name) . '
                                    </div>

                                    <div style="
                                        margin-top:3px;
                                        color:#8b7057;
                                        font-size:11px;
                                        font-weight:750;
                                    ">
                                        Kategori produk POS
                                    </div>
                                </div>
                            </div>
                        ';
                    }),

                TextColumn::make('slug')
                    ->label('Slug')
                    ->searchable()
                    ->html()
                    ->formatStateUsing(fn (?string $state): string => '
                        <span style="
                            display:inline-flex;
                            align-items:center;
                            min-height:30px;
                            padding:0 11px;
                            border-radius:999px;
                            color:#c25500;
                            background:rgba(249,115,22,.12);
                            border:1px solid rgba(249,115,22,.22);
                            font-size:11px;
                            font-weight:900;
                        ">
                            ' . e($state ?? '-') . '
                        </span>
                    ')
                    ->toggleable(),

                IconColumn::make('is_active')
                    ->label('Aktif')
                    ->boolean()
                    ->trueIcon('heroicon-o-check-circle')
                    ->falseIcon('heroicon-o-x-circle')
                    ->trueColor('success')
                    ->falseColor('danger'),

                TextColumn::make('products_count')
                    ->label('Jumlah Produk')
                    ->counts('products')
                    ->sortable()
                    ->alignCenter()
                    ->html()
                    ->formatStateUsing(function ($state): string {
                        $count = (int) $state;

                        if ($count <= 0) {
                            $bg = 'rgba(148,163,184,.12)';
                            $border = 'rgba(148,163,184,.24)';
                            $color = '#64748b';
                            $caption = 'Kosong';
                        } elseif ($count <= 5) {
                            $bg = 'rgba(249,115,22,.12)';
                            $border = 'rgba(249,115,22,.22)';
                            $color = '#c25500';
                            $caption = 'Sedikit';
                        } else {
                            $bg = 'rgba(16,185,129,.13)';
                            $border = 'rgba(16,185,129,.24)';
                            $color = '#078657';
                            $caption = 'Aktif';
                        }

                        return '
                            <div style="
                                display:inline-flex;
                                align-items:center;
                                justify-content:center;
                                gap:8px;
                                min-height:32px;
                                min-width:116px;
                                padding:0 12px;
                                border-radius:999px;
                                background:' . $bg . ';
                                border:1px solid ' . $border . ';
                                color:' . $color . ';
                                font-size:11px;
                                font-weight:950;
                            ">
                                <span>' . number_format($count, 0, ',', '.') . '</span>
                                <span style="opacity:.78;">' . $caption . '</span>
                            </div>
                        ';
                    }),

                TextColumn::make('created_at')
                    ->label('Dibuat')
                    ->dateTime('d M Y H:i')
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
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
                        ->label('Hapus Kategori'),
                ]),
            ])
            ->defaultSort('created_at', 'desc');
    }
}