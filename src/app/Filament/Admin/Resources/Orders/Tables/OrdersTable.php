<?php

declare(strict_types=1);

namespace App\Filament\Admin\Resources\Orders\Tables;

use Filament\Actions\ViewAction;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Filters\SelectFilter;
use Filament\Tables\Table;

class OrdersTable
{
    public static function configure(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('order_code')
                    ->label('ID Order')
                    ->searchable()
                    ->sortable()
                    ->html()
                    ->formatStateUsing(fn (?string $state): string => '
                        <span style="
                            display: inline-flex;
                            align-items: center;
                            gap: 8px;
                            border-radius: 999px;
                            padding: 7px 12px;
                            background: #ecfdf5;
                            color: #047857;
                            border: 1px solid #bbf7d0;
                            font-weight: 800;
                            font-size: 12px;
                            white-space: nowrap;
                        ">
                            <span style="
                                width: 7px;
                                height: 7px;
                                border-radius: 999px;
                                background: #10b981;
                            "></span>
                            ' . e($state ?? '-') . '
                        </span>
                    '),

                TextColumn::make('items_summary')
                    ->label('Item')
                    ->html()
                    ->searchable(query: function ($query, string $search): void {
                        $query->whereHas('items', function ($itemQuery) use ($search): void {
                            $itemQuery->where('product_name', 'like', "%{$search}%");
                        });
                    })
                    ->getStateUsing(function ($record): string {
                        $items = $record->items ?? collect();

                        if ($items->isEmpty()) {
                            return '<span style="color:#94a3b8;font-weight:600;">Tidak ada item</span>';
                        }

                        $maxVisible = 4;

                        $chips = $items
                            ->take($maxVisible)
                            ->map(function ($item): string {
                                return '
                                    <span style="
                                        display: inline-flex;
                                        align-items: center;
                                        border-radius: 999px;
                                        padding: 6px 10px;
                                        background: #f8fafc;
                                        border: 1px solid #e2e8f0;
                                        color: #334155;
                                        font-size: 12px;
                                        font-weight: 700;
                                        margin: 2px;
                                        white-space: nowrap;
                                    ">
                                        ' . e($item->product_name) . '
                                    </span>
                                ';
                            })
                            ->implode('');

                        $remaining = $items->count() - $maxVisible;

                        if ($remaining > 0) {
                            $chips .= '
                                <span style="
                                    display: inline-flex;
                                    align-items: center;
                                    border-radius: 999px;
                                    padding: 6px 10px;
                                    background: #eff6ff;
                                    border: 1px solid #bfdbfe;
                                    color: #1d4ed8;
                                    font-size: 12px;
                                    font-weight: 800;
                                    margin: 2px;
                                    white-space: nowrap;
                                ">
                                    +' . $remaining . ' item
                                </span>
                            ';
                        }

                        return '<div style="max-width: 720px; line-height: 1.8;">' . $chips . '</div>';
                    }),

                TextColumn::make('total_item')
                    ->label('Total Item')
                    ->sortable()
                    ->alignCenter()
                    ->html()
                    ->formatStateUsing(fn ($state): string => '
                        <span style="
                            display: inline-flex;
                            justify-content: center;
                            min-width: 42px;
                            border-radius: 12px;
                            padding: 7px 10px;
                            background: #eff6ff;
                            color: #1d4ed8;
                            font-weight: 900;
                            font-size: 13px;
                        ">
                            ' . number_format((int) $state, 0, ',', '.') . '
                        </span>
                    '),

                TextColumn::make('total_price')
                    ->label('Total')
                    ->money('IDR')
                    ->sortable()
                    ->weight('bold')
                    ->color('success'),

                TextColumn::make('status')
                    ->label('Status')
                    ->badge()
                    ->color(fn (string $state): string => match ($state) {
                        'Selesai' => 'success',
                        'Diproses' => 'warning',
                        'Dibatalkan' => 'danger',
                        default => 'gray',
                    })
                    ->icon(fn (string $state): string => match ($state) {
                        'Selesai' => 'heroicon-o-check-circle',
                        'Diproses' => 'heroicon-o-clock',
                        'Dibatalkan' => 'heroicon-o-x-circle',
                        default => 'heroicon-o-question-mark-circle',
                    }),

                TextColumn::make('ordered_at')
                    ->label('Waktu Order')
                    ->dateTime('d M Y H:i')
                    ->sortable()
                    ->icon('heroicon-o-calendar-days')
                    ->color('gray'),
            ])
            ->filters([
                SelectFilter::make('status')
                    ->label('Status Order')
                    ->options([
                        'Selesai' => 'Selesai',
                        'Diproses' => 'Diproses',
                        'Dibatalkan' => 'Dibatalkan',
                    ]),
            ])
            ->recordActions([
                ViewAction::make()
                    ->label('Detail')
                    ->icon('heroicon-o-eye')
                    ->color('primary'),
            ])
            ->defaultSort('ordered_at', 'desc');
    }
}
