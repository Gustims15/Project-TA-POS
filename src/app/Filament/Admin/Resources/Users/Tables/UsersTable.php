<?php

declare(strict_types=1);

namespace App\Filament\Admin\Resources\Users\Tables;

use Filament\Actions\BulkActionGroup;
use Filament\Actions\DeleteAction;
use Filament\Actions\DeleteBulkAction;
use Filament\Actions\EditAction;
use Filament\Actions\ViewAction;
use Filament\Support\Enums\FontWeight;
use Filament\Support\Icons\Heroicon;
use Filament\Tables;
use Filament\Tables\Filters\SelectFilter;
use Filament\Tables\Table;
use Illuminate\Support\Str;

final class UsersTable
{
    public static function configure(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\ImageColumn::make('avatar_url')
                    ->label('Avatar')
                    ->defaultImageUrl(function ($record): string {
                        $hash = md5(mb_strtolower(mb_trim((string) $record->email)));

                        return 'https://www.gravatar.com/avatar/'.$hash.'?d=mp&r=g&s=250';
                    })
                    ->square()
                    ->size(54)
                    ->extraImgAttributes([
                        'style' => 'border-radius: 16px; object-fit: cover; box-shadow: 0 10px 22px rgba(15,23,42,0.12); border: 1px solid #e2e8f0;',
                    ]),

                Tables\Columns\TextColumn::make('name')
                    ->label('User')
                    ->searchable()
                    ->sortable()
                    ->html()
                    ->formatStateUsing(function (?string $state, $record): string {
                        return '
                            <div style="display:flex; flex-direction:column; gap:5px;">
                                <span style="
                                    color:#0f172a;
                                    font-weight:950;
                                    font-size:14px;
                                    letter-spacing:-0.01em;
                                ">
                                    ' . e($state ?? '-') . '
                                </span>

                                <span style="
                                    display:inline-flex;
                                    align-items:center;
                                    gap:6px;
                                    width:fit-content;
                                    border-radius:999px;
                                    padding:5px 9px;
                                    background:#f8fafc;
                                    border:1px solid #e2e8f0;
                                    color:#64748b;
                                    font-size:12px;
                                    font-weight:850;
                                ">
                                    ✉ ' . e($record->email ?? '-') . '
                                </span>
                            </div>
                        ';
                    }),

                Tables\Columns\TextColumn::make('roles.name')
                    ->label('Roles')
                    ->badge()
                    ->weight(FontWeight::Bold)
                    ->formatStateUsing(fn (string $state): string => Str::title(str_replace('_', ' ', $state)))
                    ->color(fn (string $state): string => match ($state) {
                        'super_admin' => 'primary',
                        'karyawan' => 'warning',
                        default => 'gray',
                    })
                    ->searchable()
                    ->sortable(),

                Tables\Columns\TextColumn::make('created_at')
                    ->label('Dibuat')
                    ->date('d M Y')
                    ->sortable()
                    ->html()
                    ->formatStateUsing(fn ($state): string => '
                        <span style="
                            display:inline-flex;
                            align-items:center;
                            gap:7px;
                            border-radius:999px;
                            padding:7px 11px;
                            background:#eff6ff;
                            border:1px solid #bfdbfe;
                            color:#1d4ed8;
                            font-size:12px;
                            font-weight:850;
                            white-space:nowrap;
                        ">
                            📅 ' . e(\Carbon\Carbon::parse($state)->translatedFormat('d M Y')) . '
                        </span>
                    '),

                Tables\Columns\TextColumn::make('updated_at')
                    ->label('Update')
                    ->since()
                    ->sortable()
                    ->html()
                    ->formatStateUsing(fn ($state): string => '
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
                            font-weight:850;
                            white-space:nowrap;
                        ">
                            ⏱ ' . e(\Carbon\Carbon::parse($state)->diffForHumans()) . '
                        </span>
                    '),
            ])
            ->filters([
                SelectFilter::make('roles')
                    ->label('Role')
                    ->relationship('roles', 'name')
                    ->searchable()
                    ->preload(),
            ])
            ->recordActions([
                ViewAction::make()
                    ->label('')
                    ->icon(Heroicon::Eye)
                    ->color('gray'),

                EditAction::make()
                    ->label('')
                    ->icon(Heroicon::PencilSquare)
                    ->color('primary'),

                DeleteAction::make()
                    ->label('')
                    ->icon(Heroicon::Trash)
                    ->color('danger'),
            ])
            ->toolbarActions([
                BulkActionGroup::make([
                    DeleteBulkAction::make()
                        ->label('Hapus User'),
                ]),
            ])
            ->defaultSort('created_at', 'desc');
    }
}
