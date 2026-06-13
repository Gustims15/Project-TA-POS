<?php

declare(strict_types=1);

namespace App\Filament\Admin\Resources\Products\Schemas;

use Filament\Forms\Components\FileUpload;
use Filament\Forms\Components\Repeater;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Toggle;
use Filament\Schemas\Components\Section;
use Filament\Schemas\Schema;
use Illuminate\Support\Str;

class ProductForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->columns(1)
            ->components([
                Section::make('Informasi Utama Produk')
                    ->description('Lengkapi informasi dasar produk seperti kategori, nama produk, slug, stok, deskripsi, gambar, dan status aktif.')
                    ->icon('heroicon-o-cube')
                    ->columnSpanFull()
                    ->schema([
                        Select::make('category_id')
                            ->label('Kategori Produk')
                            ->relationship('category', 'name')
                            ->searchable()
                            ->preload()
                            ->native(false)
                            ->required()
                            ->helperText('Pilih kategori yang sesuai dengan produk.'),

                        TextInput::make('name')
                            ->label('Nama Produk')
                            ->placeholder('Contoh: Kopi Gula Aren')
                            ->required()
                            ->maxLength(255)
                            ->live(onBlur: true)
                            ->afterStateUpdated(function (?string $state, callable $set): void {
                                $set('slug', Str::slug($state ?? ''));
                            })
                            ->helperText('Nama produk akan tampil pada halaman kasir POS.'),

                        TextInput::make('slug')
                            ->label('Slug Produk')
                            ->placeholder('otomatis-dari-nama-produk')
                            ->required()
                            ->maxLength(255)
                            ->unique(ignoreRecord: true)
                            ->helperText('Slug dibuat otomatis dari nama produk.'),

                        TextInput::make('stock')
                            ->label('Stok Produk')
                            ->numeric()
                            ->minValue(0)
                            ->required()
                            ->default(0)
                            ->helperText('Stok akan berkurang otomatis saat transaksi berhasil.'),

                        Textarea::make('description')
                            ->label('Deskripsi Produk')
                            ->placeholder('Tambahkan keterangan singkat produk jika diperlukan.')
                            ->rows(4)
                            ->columnSpanFull(),

                        FileUpload::make('image')
                            ->label('Gambar Produk')
                            ->image()
                            ->imageEditor()
                            ->directory('products')
                            ->disk('public')
                            ->visibility('public')
                            ->helperText('Gunakan gambar produk yang jelas agar tampilan POS lebih menarik.')
                            ->columnSpanFull(),

                        Toggle::make('is_active')
                            ->label('Produk Aktif')
                            ->helperText('Produk aktif akan tampil pada halaman kasir.')
                            ->default(true)
                            ->columnSpanFull(),
                    ])
                    ->columns([
                        'default' => 1,
                        'md' => 2,
                    ]),

                Section::make('Size dan Harga Produk')
                    ->description('Tambahkan minimal satu size. Untuk produk tanpa pilihan ukuran, gunakan Regular.')
                    ->icon('heroicon-o-currency-dollar')
                    ->columnSpanFull()
                    ->schema([
                        Repeater::make('sizes')
                            ->label('Daftar Size dan Harga')
                            ->relationship('sizes')
                            ->schema([
                                TextInput::make('name')
                                    ->label('Nama Size')
                                    ->placeholder('Regular / Small / Large')
                                    ->required()
                                    ->maxLength(50),

                                TextInput::make('price')
                                    ->label('Harga')
                                    ->numeric()
                                    ->prefix('Rp')
                                    ->minValue(0)
                                    ->required(),

                                Toggle::make('is_default')
                                    ->label('Default')
                                    ->helperText('Tandai jika size ini menjadi pilihan utama.')
                                    ->default(false),

                                Toggle::make('is_active')
                                    ->label('Aktif')
                                    ->helperText('Size aktif dapat dipilih pada POS.')
                                    ->default(true),
                            ])
                            ->columns([
                                'default' => 1,
                                'md' => 2,
                                'xl' => 4,
                            ])
                            ->minItems(1)
                            ->defaultItems(1)
                            ->addActionLabel('Tambah Size Baru')
                            ->reorderable(false)
                            ->columnSpanFull(),
                    ]),
            ]);
    }
}