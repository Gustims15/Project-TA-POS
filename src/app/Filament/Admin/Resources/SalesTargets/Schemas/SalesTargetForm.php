<?php

declare(strict_types=1);

namespace App\Filament\Admin\Resources\SalesTargets\Schemas;

use Filament\Forms\Components\DatePicker;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\TextInput;
use Filament\Schemas\Components\Section;
use Filament\Schemas\Schema;

class SalesTargetForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->columns(1)
            ->components([
                Section::make('Informasi Target Penjualan')
                    ->description('Atur target bulanan untuk revenue, gross profit, dan net profit agar dashboard dapat menghitung progress target.')
                    ->icon('heroicon-o-flag')
                    ->schema([
                        DatePicker::make('month')
                            ->label('Bulan Target')
                            ->native(false)
                            ->displayFormat('M Y')
                            ->required()
                            ->default(now()->startOfMonth())
                            ->helperText('Pilih tanggal awal bulan, contoh: 01 Juni 2026.'),

                        TextInput::make('target_revenue')
                            ->label('Target Revenue')
                            ->numeric()
                            ->prefix('Rp')
                            ->minValue(0)
                            ->required()
                            ->default(0)
                            ->helperText('Target total penjualan kotor dalam satu bulan.'),

                        TextInput::make('target_gross_profit')
                            ->label('Target Gross Profit')
                            ->numeric()
                            ->prefix('Rp')
                            ->minValue(0)
                            ->required()
                            ->default(0)
                            ->helperText('Target laba kotor setelah revenue dikurangi HPP.'),

                        TextInput::make('target_net_profit')
                            ->label('Target Net Profit')
                            ->numeric()
                            ->prefix('Rp')
                            ->minValue(0)
                            ->required()
                            ->default(0)
                            ->helperText('Target laba bersih setelah dikurangi biaya operasional.'),

                        Textarea::make('note')
                            ->label('Catatan')
                            ->placeholder('Contoh: target bulan ini naik karena ada promo kampus')
                            ->rows(4)
                            ->columnSpanFull(),
                    ])
                    ->columns([
                        'default' => 1,
                        'md' => 2,
                    ]),
            ]);
    }
}