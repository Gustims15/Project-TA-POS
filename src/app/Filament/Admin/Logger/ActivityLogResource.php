<?php

declare(strict_types=1);

namespace App\Filament\Admin\Logger;

use App\Filament\Admin\Logger\Pages\ListActivityLogs;
use BackedEnum;
use Filament\Resources\Resource;
use Filament\Schemas\Schema;
use Filament\Support\Enums\FontWeight;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Filters\SelectFilter;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;
use Spatie\Activitylog\Models\Activity;
use UnitEnum;

class ActivityLogResource extends Resource
{
    protected static ?string $model = Activity::class;

    protected static string|BackedEnum|null $navigationIcon = 'heroicon-o-clipboard-document-list';

    protected static string|UnitEnum|null $navigationGroup = 'Administration';

    protected static ?string $navigationLabel = 'Activity Log';

    protected static ?string $modelLabel = 'Activity Log';

    protected static ?string $pluralModelLabel = 'Activity Logs';

    protected static ?int $navigationSort = 3;

    public static function form(Schema $schema): Schema
    {
        return $schema;
    }

    public static function getEloquentQuery(): Builder
    {
        return parent::getEloquentQuery()
            ->with(['causer', 'subject']);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('log_name')
                    ->label('Type')
                    ->searchable()
                    ->sortable()
                    ->html()
                    ->formatStateUsing(function (?string $state): string {
                        $label = $state ? Str::headline($state) : 'System';

                        return '
                            <span style="
                                display:inline-flex;
                                align-items:center;
                                gap:7px;
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
                                <span style="
                                    width:7px;
                                    height:7px;
                                    border-radius:999px;
                                    background:#10b981;
                                "></span>
                                ' . e($label) . '
                            </span>
                        ';
                    }),

                TextColumn::make('event')
                    ->label('Event')
                    ->searchable()
                    ->sortable()
                    ->html()
                    ->formatStateUsing(function (?string $state, Activity $record): string {
                        $event = $state ?: $record->description ?: 'activity';
                        $label = Str::headline($event);

                        $color = match (true) {
                            str_contains(strtolower($event), 'created') => '#10b981',
                            str_contains(strtolower($event), 'updated') => '#3b82f6',
                            str_contains(strtolower($event), 'deleted') => '#ef4444',
                            str_contains(strtolower($event), 'login') => '#64748b',
                            default => '#f97316',
                        };

                        return '
                            <span style="
                                display:inline-flex;
                                align-items:center;
                                gap:7px;
                                min-height:30px;
                                padding:0 12px;
                                border-radius:999px;
                                color:#24180f;
                                background:rgba(255,255,255,.24);
                                border:1px solid rgba(255,255,255,.38);
                                font-size:11px;
                                font-weight:950;
                                white-space:nowrap;
                            ">
                                <span style="
                                    width:7px;
                                    height:7px;
                                    border-radius:999px;
                                    background:' . $color . ';
                                "></span>
                                ' . e($label) . '
                            </span>
                        ';
                    }),

                TextColumn::make('subject_type')
                    ->label('Subject')
                    ->searchable()
                    ->weight(FontWeight::Bold)
                    ->html()
                    ->formatStateUsing(function (?string $state, Activity $record): string {
                        $subjectName = $state ? class_basename($state) : 'Activity Subject';
                        $subjectId = $record->subject_id ? ('#' . $record->subject_id) : '';

                        return '
                            <div style="min-width:190px;">
                                <div style="
                                    color:#23160d;
                                    font-size:13px;
                                    font-weight:950;
                                    line-height:1.25;
                                ">
                                    ' . e($subjectName . ' ' . $subjectId) . '
                                </div>

                                <div style="
                                    display:inline-flex;
                                    align-items:center;
                                    min-height:24px;
                                    margin-top:5px;
                                    padding:0 10px;
                                    border-radius:999px;
                                    color:#6f5946;
                                    background:rgba(255,255,255,.26);
                                    border:1px solid rgba(255,255,255,.38);
                                    font-size:10px;
                                    font-weight:850;
                                    white-space:nowrap;
                                ">
                                    Activity Subject
                                </div>
                            </div>
                        ';
                    }),

                TextColumn::make('causer.name')
                    ->label('User')
                    ->searchable()
                    ->sortable()
                    ->html()
                    ->formatStateUsing(function (?string $state, Activity $record): string {
                        $name = $record->causer?->name ?? $state ?? 'System';

                        return '
                            <span style="
                                display:inline-flex;
                                align-items:center;
                                gap:7px;
                                min-height:30px;
                                padding:0 12px;
                                border-radius:999px;
                                color:#7c3aed;
                                background:rgba(139,92,246,.10);
                                border:1px solid rgba(139,92,246,.20);
                                font-size:11px;
                                font-weight:950;
                                white-space:nowrap;
                            ">
                                👤 ' . e($name) . '
                            </span>
                        ';
                    }),

                TextColumn::make('created_at')
                    ->label('Logged At')
                    ->dateTime('d/m/Y H:i:s')
                    ->sortable()
                    ->html()
                    ->formatStateUsing(fn ($state): string => '
                        <span style="
                            display:inline-flex;
                            align-items:center;
                            min-height:30px;
                            padding:0 12px;
                            border-radius:999px;
                            color:#2563eb;
                            background:rgba(59,130,246,.10);
                            border:1px solid rgba(59,130,246,.20);
                            font-size:11px;
                            font-weight:950;
                            white-space:nowrap;
                        ">
                            🗓 ' . e(\Carbon\Carbon::parse($state)->format('d/m/Y H:i:s')) . '
                        </span>
                    '),
            ])
            ->filters([
                SelectFilter::make('log_name')
                    ->label('Type')
                    ->options(fn (): array => Activity::query()
                        ->whereNotNull('log_name')
                        ->distinct()
                        ->pluck('log_name', 'log_name')
                        ->mapWithKeys(fn ($value, $key): array => [
                            (string) $key => Str::headline((string) $value),
                        ])
                        ->toArray()),

                SelectFilter::make('event')
                    ->label('Event')
                    ->options(fn (): array => Activity::query()
                        ->whereNotNull('event')
                        ->distinct()
                        ->pluck('event', 'event')
                        ->mapWithKeys(fn ($value, $key): array => [
                            (string) $key => Str::headline((string) $value),
                        ])
                        ->toArray()),
            ])
            ->recordActions([])
            ->toolbarActions([])
            ->defaultSort('created_at', 'desc')
            ->paginated([10, 25, 50, 100]);
    }

    public static function canCreate(): bool
    {
        return false;
    }

    public static function canEdit(Model $record): bool
    {
        return false;
    }

    public static function canDelete(Model $record): bool
    {
        return false;
    }

    public static function canDeleteAny(): bool
    {
        return false;
    }

    public static function getPages(): array
    {
        return [
            'index' => \App\Filament\Admin\Resources\ActivityLogs\Pages\ListActivityLogs::route('/'),
            'view' => \App\Filament\Admin\Resources\ActivityLogs\Pages\ViewActivityLog::route('/{record}'),
        ];
    }
}
