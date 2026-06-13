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
                            display:inline-flex;
                            align-items:center;
                            min-height:30px;
                            padding:0 12px;
                            border-radius:999px;
                            color:#078657;
                            background:rgba(16,185,129,.12);
                            border:1px solid rgba(16,185,129,.22);
                            font-size:11px;
                            font-weight:950;
                            white-space:nowrap;
                        ">
                            • ' . e($state ?? '-') . '
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
                            return '
                                <span style="
                                    display:inline-flex;
                                    min-height:28px;
                                    align-items:center;
                                    padding:0 10px;
                                    border-radius:999px;
                                    color:#64748b;
                                    background:rgba(148,163,184,.12);
                                    border:1px solid rgba(148,163,184,.24);
                                    font-size:10px;
                                    font-weight:900;
                                ">
                                    Tidak ada item
                                </span>
                            ';
                        }

                        $maxVisible = 4;

                        $chips = $items
                            ->take($maxVisible)
                            ->map(function ($item): string {
                                return '
                                    <span style="
                                        display:inline-flex;
                                        min-height:28px;
                                        align-items:center;
                                        padding:0 10px;
                                        margin-right:5px;
                                        margin-bottom:4px;
                                        border-radius:999px;
                                        color:#4b3525;
                                        background:rgba(255,255,255,.28);
                                        border:1px solid rgba(255,255,255,.42);
                                        font-size:10px;
                                        font-weight:900;
                                        white-space:nowrap;
                                    ">
                                        ' . e($item->product_name ?? '-') . '
                                    </span>
                                ';
                            })
                            ->implode('');

                        $remaining = $items->count() - $maxVisible;

                        if ($remaining > 0) {
                            $chips .= '
                                <span style="
                                    display:inline-flex;
                                    min-height:28px;
                                    align-items:center;
                                    padding:0 10px;
                                    margin-bottom:4px;
                                    border-radius:999px;
                                    color:#c25500;
                                    background:rgba(249,115,22,.12);
                                    border:1px solid rgba(249,115,22,.22);
                                    font-size:10px;
                                    font-weight:950;
                                    white-space:nowrap;
                                ">
                                    +' . $remaining . ' item
                                </span>
                            ';
                        }

                        return '<div style="display:flex;align-items:center;flex-wrap:wrap;max-width:520px;">' . $chips . '</div>';
                    }),

                TextColumn::make('total_item')
                    ->label('Total Item')
                    ->sortable()
                    ->alignCenter()
                    ->html()
                    ->formatStateUsing(fn ($state): string => '
                        <span style="
                            display:inline-flex;
                            align-items:center;
                            justify-content:center;
                            min-width:44px;
                            min-height:32px;
                            padding:0 10px;
                            border-radius:13px;
                            color:#2563eb;
                            background:rgba(59,130,246,.10);
                            border:1px solid rgba(59,130,246,.20);
                            font-size:11px;
                            font-weight:950;
                        ">
                            ' . number_format((int) $state, 0, ',', '.') . '
                        </span>
                    '),

                TextColumn::make('total_price')
                    ->label('Total')
                    ->sortable()
                    ->html()
                    ->formatStateUsing(fn ($state): string => '
                        <span style="
                            display:inline-flex;
                            align-items:center;
                            min-height:30px;
                            padding:0 12px;
                            border-radius:999px;
                            color:#078657;
                            background:rgba(16,185,129,.12);
                            border:1px solid rgba(16,185,129,.22);
                            font-size:11px;
                            font-weight:950;
                            white-space:nowrap;
                        ">
                            Rp ' . number_format((int) $state, 0, ',', '.') . '
                        </span>
                    '),

                TextColumn::make('status')
                    ->label('Status')
                    ->sortable()
                    ->html()
                    ->formatStateUsing(function (?string $state): string {
                        $status = $state ?? '-';

                        if ($status === 'Selesai') {
                            $bg = 'rgba(16,185,129,.13)';
                            $border = 'rgba(16,185,129,.24)';
                            $color = '#078657';
                            $icon = '✓';
                        } elseif ($status === 'Diproses') {
                            $bg = 'rgba(255,159,64,.16)';
                            $border = 'rgba(255,159,64,.26)';
                            $color = '#d76a00';
                            $icon = '⏱';
                        } elseif ($status === 'Dibatalkan') {
                            $bg = 'rgba(255,98,98,.13)';
                            $border = 'rgba(255,98,98,.24)';
                            $color = '#d73333';
                            $icon = '×';
                        } else {
                            $bg = 'rgba(148,163,184,.12)';
                            $border = 'rgba(148,163,184,.24)';
                            $color = '#64748b';
                            $icon = '?';
                        }

                        return '
                            <span style="
                                display:inline-flex;
                                align-items:center;
                                justify-content:center;
                                gap:6px;
                                min-height:28px;
                                padding:0 10px;
                                border-radius:999px;
                                color:' . $color . ';
                                background:' . $bg . ';
                                border:1px solid ' . $border . ';
                                font-size:10px;
                                font-weight:950;
                                white-space:nowrap;
                            ">
                                <span>' . $icon . '</span>
                                ' . e($status) . '
                            </span>
                        ';
                    }),

                TextColumn::make('ordered_at')
                    ->label('Waktu Order')
                    ->dateTime('d M Y H:i')
                    ->sortable()
                    ->html()
                    ->formatStateUsing(fn ($state): string => '
                        <span style="
                            display:inline-flex;
                            align-items:center;
                            min-height:28px;
                            padding:0 10px;
                            border-radius:999px;
                            color:#6f5946;
                            background:rgba(255,255,255,.24);
                            border:1px solid rgba(255,255,255,.38);
                            font-size:10px;
                            font-weight:850;
                            white-space:nowrap;
                        ">
                            ' . e(optional($state)->format('d M Y H:i') ?? '-') . '
                        </span>
                    '),
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