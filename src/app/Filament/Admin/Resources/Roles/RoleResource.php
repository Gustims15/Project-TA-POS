<?php

declare(strict_types=1);

namespace App\Filament\Admin\Resources\Roles;

use App\Filament\Admin\Resources\Roles\Pages\CreateRole;
use App\Filament\Admin\Resources\Roles\Pages\EditRole;
use App\Filament\Admin\Resources\Roles\Pages\ListRoles;
use App\Filament\Admin\Resources\Roles\Pages\ViewRole;
use BezhanSalleh\FilamentShield\FilamentShieldPlugin;
use BezhanSalleh\FilamentShield\Support\Utils;
use BezhanSalleh\FilamentShield\Traits\HasShieldFormComponents;
use BezhanSalleh\PluginEssentials\Concerns\Resource as Essentials;
use Filament\Actions\DeleteAction;
use Filament\Actions\DeleteBulkAction;
use Filament\Actions\EditAction;
use Filament\Facades\Filament;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Panel;
use Filament\Resources\Resource;
use Filament\Schemas\Components\Grid;
use Filament\Schemas\Components\Section;
use Filament\Schemas\Schema;
use Filament\Support\Enums\FontWeight;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;
use Illuminate\Support\Str;
use Illuminate\Validation\Rules\Unique;

class RoleResource extends Resource
{
    use Essentials\BelongsToParent;
    use Essentials\BelongsToTenant;
    use Essentials\HasGlobalSearch;
    use Essentials\HasLabels;
    use Essentials\HasNavigation;
    use HasShieldFormComponents;

    protected static ?string $recordTitleAttribute = 'name';

    public static function form(Schema $schema): Schema
    {
        return $schema
            ->components([
                Grid::make()
                    ->schema([
                        Section::make('Informasi Role')
                            ->description('Atur nama role, guard, dan konfigurasi dasar role sistem.')
                            ->icon('heroicon-o-shield-check')
                            ->schema([
                                TextInput::make('name')
                                    ->label(__('filament-shield::filament-shield.field.name'))
                                    ->placeholder('Contoh: super_admin / karyawan')
                                    ->unique(
                                        ignoreRecord: true,
                                        modifyRuleUsing: fn (Unique $rule): Unique => Utils::isTenancyEnabled()
                                            ? $rule->where(Utils::getTenantModelForeignKey(), Filament::getTenant()?->id)
                                            : $rule
                                    )
                                    ->required()
                                    ->maxLength(255),

                                TextInput::make('guard_name')
                                    ->label(__('filament-shield::filament-shield.field.guard_name'))
                                    ->default(Utils::getFilamentAuthGuard())
                                    ->nullable()
                                    ->maxLength(255)
                                    ->helperText('Default guard biasanya web.'),

                                Select::make(config('permission.column_names.team_foreign_key'))
                                    ->label(__('filament-shield::filament-shield.field.team'))
                                    ->placeholder(__('filament-shield::filament-shield.field.team.placeholder'))
                                    ->default(Filament::getTenant()?->id)
                                    ->options(fn (): array => in_array(Utils::getTenantModel(), [null, '', '0'], true)
                                        ? []
                                        : Utils::getTenantModel()::pluck('name', 'id')->toArray())
                                    ->visible(fn (): bool => static::shield()->isCentralApp() && Utils::isTenancyEnabled())
                                    ->dehydrated(fn (): bool => static::shield()->isCentralApp() && Utils::isTenancyEnabled()),

                                static::getSelectAllFormComponent(),
                            ])
                            ->columns([
                                'sm' => 2,
                                'lg' => 3,
                            ])
                            ->columnSpanFull(),
                    ])
                    ->columnSpanFull(),

                static::getShieldFormComponents(),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('name')
                    ->label(__('filament-shield::filament-shield.column.name'))
                    ->weight(FontWeight::Bold)
                    ->searchable()
                    ->sortable()
                    ->html()
                    ->formatStateUsing(fn (string $state): string => '
                        <div style="display:flex; align-items:center; gap:12px;">
                            <div style="
                                display:grid;
                                place-items:center;
                                width:40px;
                                height:40px;
                                border-radius:14px;
                                background:#ecfdf5;
                                color:#047857;
                                font-weight:950;
                                border:1px solid #bbf7d0;
                            ">
                                ' . e(mb_strtoupper(mb_substr(Str::headline($state), 0, 1))) . '
                            </div>

                            <div style="display:flex; flex-direction:column; gap:4px;">
                                <span style="
                                    color:#0f172a;
                                    font-weight:950;
                                    font-size:14px;
                                    letter-spacing:-0.01em;
                                ">
                                    ' . e(Str::headline($state)) . '
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
                                    Role Access
                                </span>
                            </div>
                        </div>
                    '),

                TextColumn::make('guard_name')
                    ->label(__('filament-shield::filament-shield.column.guard_name'))
                    ->html()
                    ->formatStateUsing(fn (?string $state): string => '
                        <span style="
                            display:inline-flex;
                            align-items:center;
                            gap:7px;
                            border-radius:999px;
                            padding:7px 11px;
                            background:#fff7ed;
                            border:1px solid #fed7aa;
                            color:#c2410c;
                            font-size:12px;
                            font-weight:900;
                            white-space:nowrap;
                        ">
                            <span style="
                                width:7px;
                                height:7px;
                                border-radius:999px;
                                background:#f97316;
                            "></span>
                            ' . e($state ?? 'web') . '
                        </span>
                    '),

                TextColumn::make('team.name')
                    ->default('Global')
                    ->badge()
                    ->color(fn (mixed $state): string => str($state)->contains('Global') ? 'gray' : 'primary')
                    ->label(__('filament-shield::filament-shield.column.team'))
                    ->searchable()
                    ->visible(fn (): bool => static::shield()->isCentralApp() && Utils::isTenancyEnabled()),

                TextColumn::make('permissions_count')
                    ->label(__('filament-shield::filament-shield.column.permissions'))
                    ->counts('permissions')
                    ->sortable()
                    ->alignCenter()
                    ->html()
                    ->formatStateUsing(function ($state): string {
                        $count = (int) $state;

                        if ($count <= 0) {
                            $bg = '#f8fafc';
                            $border = '#e2e8f0';
                            $color = '#64748b';
                            $caption = 'Belum ada';
                        } elseif ($count <= 5) {
                            $bg = '#eff6ff';
                            $border = '#bfdbfe';
                            $color = '#1d4ed8';
                            $caption = 'Standar';
                        } else {
                            $bg = '#ecfdf5';
                            $border = '#bbf7d0';
                            $color = '#047857';
                            $caption = 'Lengkap';
                        }

                        return '
                            <div style="display:flex; flex-direction:column; align-items:center; gap:5px;">
                                <span style="
                                    display:inline-flex;
                                    justify-content:center;
                                    min-width:44px;
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

                TextColumn::make('updated_at')
                    ->label(__('filament-shield::filament-shield.column.updated_at'))
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
                            📅 ' . e(\Carbon\Carbon::parse($state)->translatedFormat('d M Y H:i')) . '
                        </span>
                    '),
            ])
            ->filters([
                //
            ])
            ->recordActions([
                EditAction::make()
                    ->label('Edit')
                    ->icon('heroicon-o-pencil-square')
                    ->color('primary'),

                DeleteAction::make()
                    ->label('Delete')
                    ->icon('heroicon-o-trash')
                    ->color('danger'),
            ])
            ->toolbarActions([
                DeleteBulkAction::make()
                    ->label('Hapus Role'),
            ])
            ->defaultSort('updated_at', 'desc');
    }

    public static function getRelations(): array
    {
        return [
            //
        ];
    }

    public static function getPages(): array
    {
        return [
            'index' => ListRoles::route('/'),
            'create' => CreateRole::route('/create'),
            'view' => ViewRole::route('/{record}'),
            'edit' => EditRole::route('/{record}/edit'),
        ];
    }

    public static function getModel(): string
    {
        return Utils::getRoleModel();
    }

    public static function getSlug(?Panel $panel = null): string
    {
        return Utils::getResourceSlug();
    }

    public static function getCluster(): ?string
    {
        return Utils::getResourceCluster();
    }

    public static function getEssentialsPlugin(): ?FilamentShieldPlugin
    {
        return FilamentShieldPlugin::get();
    }
}
