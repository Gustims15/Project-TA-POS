<?php

declare(strict_types=1);

namespace App\Filament\Admin\Resources\Products\Tables;

use Filament\Actions\BulkActionGroup;
use Filament\Actions\DeleteBulkAction;
use Filament\Actions\EditAction;
use Filament\Tables\Columns\IconColumn;
use Filament\Tables\Columns\ImageColumn;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Filters\SelectFilter;
use Filament\Tables\Table;

class ProductsTable
{
    public static function configure(Table $table): Table
    {
        return $table
            ->columns([
                ImageColumn::make('image')
                    ->label('Gambar')
                    ->disk('public')
                    ->square()
                    ->size(54)
                    ->extraImgAttributes([
                        'style' => 'border-radius: 16px; object-fit: cover; box-shadow: 0 10px 22px rgba(15,23,42,0.12); border: 1px solid #e2e8f0;',
                    ]),

                TextColumn::make('name')
                    ->label('Nama Produk')
                    ->searchable()
                    ->sortable()
                    ->html()
                    ->formatStateUsing(fn (?string $state): string => '
                        <div style="display:flex; flex-direction:column; gap:4px;">
                            <span style="
                                color:#0f172a;
                                font-weight:900;
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
                                font-weight:800;
                            ">
                                Produk Ngunjuk
                            </span>
                        </div>
                    '),

                TextColumn::make('category.name')
                    ->label('Kategori')
                    ->sortable()
                    ->searchable()
                    ->html()
                    ->formatStateUsing(fn (?string $state): string => '
                        <span style="
                            display:inline-flex;
                            align-items:center;
                            gap:7px;
                            border-radius:999px;
                            padding:7px 11px;
                            background:#ecfdf5;
                            border:1px solid #bbf7d0;
                            color:#047857;
                            font-size:12px;
                            font-weight:900;
                            white-space:nowrap;
                        ">
                            <span style="
                                width:7px;
                                height:7px;
                                border-radius:999px;
                                background:#10b981;
                            "></span>
                            ' . e($state ?? '-') . '
                        </span>
                    '),

                TextColumn::make('sizes_summary')
                    ->label('Size')
                    ->html()
                    ->getStateUsing(function ($record): string {
                        $sizes = $record->sizes ?? collect();

                        if ($sizes->isEmpty()) {
                            return '<span style="color:#94a3b8;font-weight:700;">Belum ada size</span>';
                        }

                        return $sizes
                            ->map(function ($size): string {
                                $label = $size->name ?? '-';

                                return '
                                    <span style="
                                        display:inline-flex;
                                        align-items:center;
                                        border-radius:999px;
                                        padding:6px 10px;
                                        background:#eff6ff;
                                        border:1px solid #bfdbfe;
                                        color:#1d4ed8;
                                        font-size:12px;
                                        font-weight:900;
                                        margin:2px;
                                        white-space:nowrap;
                                    ">
                                        ' . e($label) . '
                                    </span>
                                ';
                            })
                            ->implode('');
                    }),

                TextColumn::make('prices_summary')
                    ->label('Harga')
                    ->html()
                    ->getStateUsing(function ($record): string {
                        $sizes = $record->sizes ?? collect();

                        if ($sizes->isEmpty()) {
                            return '<span style="color:#94a3b8;font-weight:700;">Rp 0</span>';
                        }

                        return $sizes
                            ->map(function ($size): string {
                                return '
                                    <span style="
                                        display:inline-flex;
                                        align-items:center;
                                        border-radius:999px;
                                        padding:6px 10px;
                                        background:#f8fafc;
                                        border:1px solid #e2e8f0;
                                        color:#0f172a;
                                        font-size:12px;
                                        font-weight:850;
                                        margin:2px;
                                        white-space:nowrap;
                                    ">
                                        Rp ' . number_format((int) $size->price, 0, ',', '.') . '
                                    </span>
                                ';
                            })
                            ->implode('');
                    }),

                TextColumn::make('stock')
                    ->label('Stok')
                    ->sortable()
                    ->alignCenter()
                    ->html()
                    ->formatStateUsing(function ($state): string {
                        $stock = (int) $state;

                        if ($stock <= 0) {
                            $bg = '#fef2f2';
                            $border = '#fecaca';
                            $color = '#b91c1c';
                            $label = 'Habis';
                        } elseif ($stock <= 5) {
                            $bg = '#fff7ed';
                            $border = '#fed7aa';
                            $color = '#c2410c';
                            $label = 'Menipis';
                        } else {
                            $bg = '#ecfdf5';
                            $border = '#bbf7d0';
                            $color = '#047857';
                            $label = 'Aman';
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
                                    ' . number_format($stock, 0, ',', '.') . '
                                </span>
                                <span style="
                                    color:' . $color . ';
                                    font-size:11px;
                                    font-weight:850;
                                ">
                                    ' . $label . '
                                </span>
                            </div>
                        ';
                    }),

                IconColumn::make('is_active')
                    ->label('Aktif')
                    ->boolean()
                    ->trueIcon('heroicon-o-check-circle')
                    ->falseIcon('heroicon-o-x-circle')
                    ->trueColor('success')
                    ->falseColor('danger'),

                TextColumn::make('created_at')
                    ->label('Dibuat')
                    ->dateTime('d M Y H:i')
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
            ])
            ->filters([
                SelectFilter::make('category_id')
                    ->label('Kategori')
                    ->relationship('category', 'name')
                    ->searchable()
                    ->preload(),

                SelectFilter::make('is_active')
                    ->label('Status Aktif')
                    ->options([
                        '1' => 'Aktif',
                        '0' => 'Tidak Aktif',
                    ]),
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
                        ->label('Hapus Produk'),
                ]),
            ])
            ->defaultSort('created_at', 'desc');
    }
}
