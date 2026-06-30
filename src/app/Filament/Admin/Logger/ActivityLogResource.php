<?php

declare(strict_types=1);

namespace App\Filament\Admin\Logger;

use BackedEnum;
use Filament\Resources\Resource;
use Filament\Schemas\Schema;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Filters\SelectFilter;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\HtmlString;
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


    protected static function applyLoginLogoutFilter(Builder $query): Builder
    {
        return $query->where(function (Builder $query): void {
            $query
                ->whereIn('event', ['login', 'logout'])
                ->orWhere('description', 'like', '%login%')
                ->orWhere('description', 'like', '%logout%')
                ->orWhere('description', 'like', '%logged in%')
                ->orWhere('description', 'like', '%logged out%');
        });
    }

    protected static function loginLogoutQuery(): Builder
    {
        return static::applyLoginLogoutFilter(Activity::query());
    }

    public static function getEloquentQuery(): Builder
    {
        return static::applyLoginLogoutFilter(parent::getEloquentQuery())
            ->with(['causer', 'subject']);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->heading(static::getOrangeHeading())
            ->modifyQueryUsing(fn (Builder $query): Builder => static::applyLoginLogoutFilter($query))
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
                            str_contains(strtolower($event), 'logout') => '#ef4444',
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

                TextColumn::make('description')
                    ->label('Description')
                    ->toggleable()
                    ->toggledHiddenByDefault()
                    ->wrap(),
            ])
            ->filters([
                SelectFilter::make('event')
                    ->label('Aktivitas')
                    ->options([
                        'login' => 'Login',
                        'logout' => 'Logout',
                    ]),
            ])
            ->recordUrl(null)
            ->recordActions([])
            ->toolbarActions([])
            ->defaultSort('created_at', 'desc')
            ->paginated([10, 25, 50, 100]);
    }

    protected static function getOrangeHeading(): HtmlString
    {
        $totalLogs = static::loginLogoutQuery()->count();
        $totalText = number_format((int) $totalLogs, 0, ',', '.');

        return new HtmlString(<<<HTML
            <div class="ng-activity-head">
                <div class="ng-activity-hero-clean">
                    <div class="ng-activity-hero-copy">

                        <h1>Activity Log Analytics</h1>

                        <p>
                            Pantau seluruh aktivitas sistem seperti login, perubahan produk, order, kategori,
                            user, role, dan riwayat aksi admin atau karyawan yang tercatat otomatis.
                        </p>
                    </div>

                    <div class="ng-activity-total-box">
                        <span>Total Login/Logout</span>
                        <strong>{$totalText}</strong>
                        <small>Login dan logout tercatat</small>
                    </div>
                </div>
            </div>

            <style>
                html,
                body {
                    overflow-x: hidden !important;
                    overflow-y: auto !important;
                    height: auto !important;
                    max-height: none !important;
                }

                body:has(.ng-activity-head) {
                    background:
                        linear-gradient(120deg, rgba(255, 248, 237, .10), rgba(255, 224, 185, .02)),
                        url("/images/pos-orange-bg.png"),
                        radial-gradient(circle at 15% 8%, rgba(255, 255, 255, .32) 0 130px, transparent 280px),
                        radial-gradient(circle at 88% 78%, rgba(255, 118, 0, .42) 0 250px, transparent 520px),
                        radial-gradient(circle at 20% 96%, rgba(255, 181, 83, .28) 0 220px, transparent 500px),
                        linear-gradient(135deg, #fff3df 0%, #ffd394 48%, #ff9c45 100%) !important;
                    background-size: cover !important;
                    background-position: center !important;
                    background-attachment: scroll !important;
                }

                body:has(.ng-activity-head) .fi-main,
                body:has(.ng-activity-head) .fi-main-ctn,
                body:has(.ng-activity-head) .fi-page,
                body:has(.ng-activity-head) .fi-page-content {
                    width: 100% !important;
                    max-width: 100% !important;
                    height: auto !important;
                    min-height: 0 !important;
                    max-height: none !important;
                    background: transparent !important;
                    overflow-x: hidden !important;
                    overflow-y: visible !important;
                }

                body:has(.ng-activity-head) .fi-page,
                body:has(.ng-activity-head) .fi-main {
                    padding: 0 !important;
                }

                body:has(.ng-activity-head) .fi-page-header {
                    display: none !important;
                }

                body:has(.ng-activity-head) .fi-page-content {
                    gap: 0 !important;
                    row-gap: 0 !important;
                }

                body:has(.ng-activity-head) .fi-sidebar {
                    background: rgba(255, 250, 242, .50) !important;
                    border-right: 1px solid rgba(255, 255, 255, .48) !important;
                    box-shadow: 18px 0 55px rgba(137, 78, 26, .10) !important;
                    backdrop-filter: blur(16px) !important;
                    -webkit-backdrop-filter: blur(16px) !important;
                }

                body:has(.ng-activity-head) .fi-sidebar-nav {
                    padding: 18px 14px !important;
                }

                body:has(.ng-activity-head) .fi-sidebar-item a {
                    border-radius: 14px !important;
                    color: #6f5844 !important;
                    transition: .2s ease !important;
                }

                body:has(.ng-activity-head) .fi-sidebar-item-active a,
                body:has(.ng-activity-head) .fi-sidebar-item a:hover {
                    background: linear-gradient(135deg, #ff9500, #f26a00) !important;
                    color: #fff !important;
                    box-shadow: 0 14px 24px rgba(242, 106, 0, .24) !important;
                }

                /*
                 * Hilangkan kotak besar pembungkus table.
                 * Yang terlihat hanya widget/komponen masing-masing.
                 */
                body:has(.ng-activity-head) .fi-ta-ctn {
                    width: calc(100% - 36px) !important;
                    margin: 18px 18px 28px !important;
                    border: none !important;
                    border-radius: 0 !important;
                    background: transparent !important;
                    box-shadow: none !important;
                    backdrop-filter: none !important;
                    -webkit-backdrop-filter: none !important;
                    overflow-x: hidden !important;
                    overflow-y: visible !important;
                }

                body:has(.ng-activity-head) .fi-ta-header {
                    display: block !important;
                    padding: 0 !important;
                    background: transparent !important;
                    border: none !important;
                }

                body:has(.ng-activity-head) .fi-ta-heading {
                    width: 100% !important;
                }

                body:has(.ng-activity-head) .fi-ta-header-toolbar,
                body:has(.ng-activity-head) .fi-ta-toolbar {
                    min-height: 58px !important;
                    margin-top: 14px !important;
                    padding: 10px 18px !important;
                    border-radius: 24px 24px 0 0 !important;
                    background: rgba(255, 247, 235, .18) !important;
                    border: 1px solid rgba(255, 255, 255, .46) !important;
                    border-bottom: 1px solid rgba(114, 74, 41, .08) !important;
                    box-shadow:
                        0 18px 44px rgba(101, 58, 21, .08),
                        inset 0 1px 0 rgba(255, 255, 255, .44) !important;
                }

                .ng-activity-head {
                    width: 100%;
                    padding: 18px 0 0;
                    font-family: Inter, Poppins, ui-sans-serif, system-ui, sans-serif;
                    color: #24180f;
                    box-sizing: border-box;
                }

                .ng-activity-head * {
                    box-sizing: border-box;
                }

                .ng-activity-hero-clean {
                    width: 100%;
                    min-height: 126px;
                    display: flex;
                    align-items: center;
                    justify-content: space-between;
                    gap: 22px;
                    padding: 22px 24px;
                    border-radius: 24px;
                    border: 1px solid rgba(255, 255, 255, .58);
                    background:
                        linear-gradient(145deg, rgba(255, 255, 255, .46), rgba(255, 246, 231, .22)),
                        radial-gradient(circle at 100% 0%, rgba(255, 153, 30, .16), transparent 38%) !important;
                    box-shadow:
                        0 18px 44px rgba(101, 58, 21, .10),
                        inset 0 1px 0 rgba(255, 255, 255, .60);
                    overflow: hidden;
                    backdrop-filter: none;
                    -webkit-backdrop-filter: none;
                }

                .ng-activity-hero-copy {
                    min-width: 0;
                    flex: 1;
                }

                .ng-kicker {
                    display: inline-flex;
                    width: fit-content;
                    padding: 6px 12px;
                    margin-bottom: 9px;
                    border-radius: 999px;
                    background: rgba(255, 255, 255, .38);
                    border: 1px solid rgba(255, 255, 255, .55);
                    color: #d95d00;
                    font-size: 10px;
                    font-weight: 950;
                    letter-spacing: .12em;
                    text-transform: uppercase;
                }

                .ng-activity-hero-copy h1 {
                    margin: 0;
                    color: #21160d;
                    font-size: 31px;
                    line-height: 1.05;
                    font-weight: 950;
                    letter-spacing: -.04em;
                }

                .ng-activity-hero-copy p {
                    max-width: 920px;
                    margin: 8px 0 0;
                    color: #72583f;
                    font-size: 12px;
                    font-weight: 700;
                    line-height: 1.55;
                }

                .ng-activity-total-box {
                    flex: 0 0 210px;
                    min-height: 86px;
                    display: flex;
                    flex-direction: column;
                    justify-content: center;
                    padding: 16px 18px;
                    border-radius: 20px;
                    background: rgba(255, 255, 255, .32);
                    border: 1px solid rgba(255, 255, 255, .48);
                    box-shadow:
                        inset 0 1px 0 rgba(255, 255, 255, .50),
                        0 14px 28px rgba(101, 58, 21, .08);
                }

                .ng-activity-total-box span {
                    display: block;
                    color: #72583f;
                    font-size: 11px;
                    font-weight: 950;
                    text-transform: uppercase;
                    letter-spacing: .06em;
                }

                .ng-activity-total-box strong {
                    display: block;
                    margin-top: 6px;
                    color: #21160d;
                    font-size: 25px;
                    line-height: 1;
                    font-weight: 950;
                    letter-spacing: -.04em;
                }

                .ng-activity-total-box small {
                    display: block;
                    margin-top: 7px;
                    color: #72583f;
                    font-size: 11px;
                    font-weight: 850;
                }

                /*
                 * KPI dan widget kanan lama dihilangkan.
                 */
                .ng-activity-side,
                .ng-activity-kpis,
                .ng-kpi {
                    display: none !important;
                }

                /*
                 * Table tetap rapi, tapi bukan berada di dalam kotak besar parent.
                 */
                body:has(.ng-activity-head) .fi-ta,
                body:has(.ng-activity-head) .fi-section,
                body:has(.ng-activity-head) .fi-ta-content,
                body:has(.ng-activity-head) .fi-ta-table,
                body:has(.ng-activity-head) .fi-ta-table thead,
                body:has(.ng-activity-head) .fi-ta-table tbody {
                    background: transparent !important;
                    border: none !important;
                    box-shadow: none !important;
                }

                body:has(.ng-activity-head) .fi-ta-content {
                    border-radius: 0 0 24px 24px !important;
                    background: rgba(255, 247, 235, .13) !important;
                    border: 1px solid rgba(255, 255, 255, .40) !important;
                    border-top: none !important;
                    box-shadow:
                        0 18px 44px rgba(101, 58, 21, .07),
                        inset 0 1px 0 rgba(255, 255, 255, .24) !important;
                    overflow-x: hidden !important;
                    overflow-y: visible !important;
                }

                body:has(.ng-activity-head) .fi-ta-table {
                    border-collapse: separate !important;
                    border-spacing: 0 !important;
                }

                body:has(.ng-activity-head) .fi-ta-table thead tr {
                    background: rgba(255, 247, 235, .24) !important;
                }

                body:has(.ng-activity-head) .fi-ta-header-cell {
                    height: 52px !important;
                    padding-top: 10px !important;
                    padding-bottom: 10px !important;
                    background: rgba(255, 247, 235, .18) !important;
                    border-color: rgba(114, 74, 41, .08) !important;
                }

                body:has(.ng-activity-head) .fi-ta-header-cell-label {
                    color: #4b3525 !important;
                    font-size: 12px !important;
                    font-weight: 950 !important;
                }

                body:has(.ng-activity-head) .fi-ta-row {
                    min-height: 58px !important;
                    background: rgba(255, 255, 255, .05) !important;
                    border-bottom: 1px solid rgba(114, 74, 41, .07) !important;
                    transition: .18s ease !important;
                }

                body:has(.ng-activity-head) .fi-ta-row:hover {
                    background: rgba(255, 255, 255, .16) !important;
                }

                body:has(.ng-activity-head) .fi-ta-cell {
                    padding-top: 10px !important;
                    padding-bottom: 10px !important;
                    background: transparent !important;
                    border-color: rgba(114, 74, 41, .07) !important;
                }

                body:has(.ng-activity-head) .fi-ta-pagination,
                body:has(.ng-activity-head) .fi-pagination {
                    min-height: 54px !important;
                    padding: 10px 18px !important;
                    background: rgba(255, 247, 235, .18) !important;
                    border-top: 1px solid rgba(114, 74, 41, .08) !important;
                }

                body:has(.ng-activity-head) .fi-input-wrp,
                body:has(.ng-activity-head) .fi-ta-search-field .fi-input-wrp,
                body:has(.ng-activity-head) .fi-select-input {
                    border-radius: 16px !important;
                    background: rgba(255, 255, 255, .34) !important;
                    border: 1px solid rgba(255, 255, 255, .48) !important;
                    box-shadow:
                        inset 0 1px 0 rgba(255, 255, 255, .42),
                        0 10px 24px rgba(101, 58, 21, .06) !important;
                    backdrop-filter: none !important;
                    -webkit-backdrop-filter: none !important;
                }

                body:has(.ng-activity-head) .fi-ta-search-field {
                    max-width: 280px !important;
                }

                body:has(.ng-activity-head) .fi-ta-search-field .fi-input-wrp {
                    min-height: 38px !important;
                }


                /*
                 * Rapihkan lebar kolom Activity Log.
                 * Setelah kolom Subject dihapus, 4 kolom dibuat rata agar kanan tidak kosong.
                 */
                body:has(.ng-activity-head) .fi-ta-table {
                    width: 100% !important;
                    table-layout: fixed !important;
                }

                body:has(.ng-activity-head) .fi-ta-header-cell,
                body:has(.ng-activity-head) .fi-ta-cell {
                    width: 25% !important;
                    text-align: center !important;
                    vertical-align: middle !important;
                }

                body:has(.ng-activity-head) .fi-ta-header-cell > *,
                body:has(.ng-activity-head) .fi-ta-cell > * {
                    justify-content: center !important;
                    margin-left: auto !important;
                    margin-right: auto !important;
                }

                body:has(.ng-activity-head) .fi-ta-header-cell-label,
                body:has(.ng-activity-head) .fi-ta-cell .fi-ta-text,
                body:has(.ng-activity-head) .fi-ta-cell .fi-ta-text-item {
                    justify-content: center !important;
                    text-align: center !important;
                }

                body:has(.ng-activity-head) .fi-ta-table th:nth-child(1),
                body:has(.ng-activity-head) .fi-ta-table td:nth-child(1),
                body:has(.ng-activity-head) .fi-ta-table th:nth-child(2),
                body:has(.ng-activity-head) .fi-ta-table td:nth-child(2),
                body:has(.ng-activity-head) .fi-ta-table th:nth-child(3),
                body:has(.ng-activity-head) .fi-ta-table td:nth-child(3),
                body:has(.ng-activity-head) .fi-ta-table th:nth-child(4),
                body:has(.ng-activity-head) .fi-ta-table td:nth-child(4) {
                    width: 25% !important;
                }

                body:has(.ng-activity-head) .fi-ta-table th:nth-child(n+5),
                body:has(.ng-activity-head) .fi-ta-table td:nth-child(n+5) {
                    display: none !important;
                }

                body:has(.ng-activity-head) .fi-ta-filter-indicators,
                body:has(.ng-activity-head) .fi-ta-empty-state {
                    background: transparent !important;
                }

                /*
                 * One scroll tetap dipertahankan.
                 */
                body:has(.ng-activity-head) .fi-layout,
                body:has(.ng-activity-head) main,
                body:has(.ng-activity-head) .fi-ta,
                body:has(.ng-activity-head) .fi-ta-content,
                body:has(.ng-activity-head) .fi-ta-table-wrap,
                body:has(.ng-activity-head) .fi-section {
                    height: auto !important;
                    min-height: 0 !important;
                    max-height: none !important;
                    overflow-x: hidden !important;
                    overflow-y: visible !important;
                }

                body:has(.ng-activity-head) .fi-main,
                body:has(.ng-activity-head) .fi-main-ctn,
                body:has(.ng-activity-head) .fi-page,
                body:has(.ng-activity-head) .fi-page-content,
                body:has(.ng-activity-head) .fi-ta-ctn,
                body:has(.ng-activity-head) .fi-ta-content,
                body:has(.ng-activity-head) .fi-ta-table-wrap {
                    scrollbar-width: none !important;
                    -ms-overflow-style: none !important;
                }

                body:has(.ng-activity-head) .fi-main::-webkit-scrollbar,
                body:has(.ng-activity-head) .fi-main-ctn::-webkit-scrollbar,
                body:has(.ng-activity-head) .fi-page::-webkit-scrollbar,
                body:has(.ng-activity-head) .fi-page-content::-webkit-scrollbar,
                body:has(.ng-activity-head) .fi-ta-ctn::-webkit-scrollbar,
                body:has(.ng-activity-head) .fi-ta-content::-webkit-scrollbar,
                body:has(.ng-activity-head) .fi-ta-table-wrap::-webkit-scrollbar {
                    display: none !important;
                    width: 0 !important;
                    height: 0 !important;
                }

                @media (max-width: 900px) {
                    .ng-activity-hero-clean {
                        flex-direction: column;
                        align-items: flex-start;
                    }

                    .ng-activity-total-box {
                        width: 100%;
                        flex-basis: auto;
                    }
                }
            </style>
        HTML);
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
            'index' => Pages\ListActivityLogs::route('/'),
        ];
    }

}
