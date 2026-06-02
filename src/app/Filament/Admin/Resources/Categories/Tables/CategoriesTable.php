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
                    ->formatStateUsing(fn (?string $state): string => '
                        <div style="display:flex; align-items:center; gap:12px;">
                            <div style="
                                display:grid;
                                place-items:center;
                                width:38px;
                                height:38px;
                                border-radius:14px;
                                background:#ecfdf5;
                                color:#047857;
                                font-weight:950;
                                border:1px solid #bbf7d0;
                            ">
                                ' . e(mb_strtoupper(mb_substr((string) ($state ?? '-'), 0, 1))) . '
                            </div>

                            <div style="display:flex; flex-direction:column; gap:4px;">
                                <span style="
                                    color:#0f172a;
                                    font-weight:950;
                                    font-size:14px;
                                    letter-spacing:-0.01em;
                                ">
                                    ' . e($state ?? '-') . '
                                </span>

                                <span style="
                                    width:fit-content;
                                    border-radius:999px;
                                    padding:4px 8px;
                                    background:#f8fafc;
                                    border:1px solid #e2e8f0;
                                    color:#64748b;
                                    font-size:11px;
                                    font-weight:850;
                                ">
                                    Kategori Ngunjuk
                                </span>
                            </div>
                        </div>
                    '),

                TextColumn::make('slug')
                    ->label('Slug')
                    ->searchable()
                    ->html()
                    ->formatStateUsing(fn (?string $state): string => '
                        <span style="
                            display:inline-flex;
                            align-items:center;
                            border-radius:999px;
                            padding:7px 11px;
                            background:#eff6ff;
                            border:1px solid #bfdbfe;
                            color:#1d4ed8;
                            font-size:12px;
                            font-weight:850;
                            white-space:nowrap;
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
                            $bg = '#f8fafc';
                            $border = '#e2e8f0';
                            $color = '#64748b';
                            $caption = 'Kosong';
                        } elseif ($count <= 5) {
                            $bg = '#fff7ed';
                            $border = '#fed7aa';
                            $color = '#c2410c';
                            $caption = 'Sedikit';
                        } else {
                            $bg = '#ecfdf5';
                            $border = '#bbf7d0';
                            $color = '#047857';
                            $caption = 'Aktif';
                        }

                        return '
                            <div style="display:flex; flex-direction:column; align-items:center; gap:5px;">
                                <span style="
                                    display:inline-flex;
                                    justify-content:center;
                                    min-width:42px;
                                    border-radius:12px;
                                    padding:7px 10px;
                                    background:' . $bg . ';
                                    border:1px solid ' . $border . ';
                                    color:' . $color . ';
                                    font-weight:950;
                                    font-size:13px;
                                ">
                                    ' . number_format($count, 0, ',', '.') . '
                                </span>

                                <span style="
                                    color:' . $color . ';
                                    font-size:11px;
                                    font-weight:850;
                                ">
                                    ' . $caption . '
                                </span>
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
