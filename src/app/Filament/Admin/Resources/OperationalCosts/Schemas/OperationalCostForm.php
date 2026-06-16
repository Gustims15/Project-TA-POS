<?php

declare(strict_types=1);

namespace App\Filament\Admin\Resources\OperationalCosts\Schemas;

use Filament\Forms\Components\DatePicker;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Toggle;
use Filament\Schemas\Components\Section;
use Filament\Schemas\Schema;

class OperationalCostForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->columns(1)
            ->components([
                Section::make('Informasi Biaya Operasional')
                    ->description('Input biaya usaha. Khusus kategori Sewa Tempat, nominal dianggap biaya tahunan dan otomatis dibagi 12 bulan pada Dashboard Keuangan.')
                    ->icon('heroicon-o-receipt-percent')
                    ->schema([
                        TextInput::make('name')
                            ->label('Nama Biaya')
                            ->placeholder('Contoh: Ruko / Sewa Tempat')
                            ->required()
                            ->maxLength(255)
                            ->helperText('Nama biaya yang akan dihitung ke Dashboard Keuangan.'),

                        Select::make('category')
                            ->label('Kategori Biaya')
                            ->native(false)
                            ->searchable()
                            ->required()
                            ->options([
                                'rent' => 'Sewa Tempat / Ruko Tahunan - Otomatis Dibagi 12',
                                'electricity' => 'Listrik',
                                'water' => 'Air',
                                'internet' => 'Wifi / Internet',
                                'salary' => 'Gaji',
                                'marketing' => 'Promosi / Marketing',
                                'maintenance' => 'Maintenance',
                                'other' => 'Lainnya',
                            ])
                            ->default('other')
                            ->helperText('Jika memilih Sewa Tempat, isi nominal tahunan. Dashboard akan menghitung biaya per bulan otomatis.'),

                        TextInput::make('amount')
                            ->label('Nominal Biaya')
                            ->numeric()
                            ->prefix('Rp')
                            ->minValue(0)
                            ->required()
                            ->default(0)
                            ->helperText('Untuk Sewa Tempat, isi nominal tahunan. Contoh: Rp20.000.000 akan dihitung Rp1.666.667 per bulan.'),

                        DatePicker::make('cost_date')
                            ->label('Tanggal Mulai Biaya')
                            ->native(false)
                            ->displayFormat('d M Y')
                            ->required()
                            ->default(now())
                            ->helperText('Untuk Sewa Tempat, tanggal ini menjadi awal periode tahunan selama 12 bulan.'),

                        Toggle::make('is_active')
                            ->label('Aktif')
                            ->helperText('Jika nonaktif, biaya ini tidak dihitung pada dashboard.')
                            ->default(true),

                        Textarea::make('note')
                            ->label('Catatan')
                            ->placeholder('Contoh: pembayaran ruko tahunan / pembayaran listrik bulan Juni')
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