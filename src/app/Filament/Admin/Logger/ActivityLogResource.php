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

    public static function getEloquentQuery(): Builder
    {
        return parent::getEloquentQuery()
            ->with(['causer', 'subject']);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->heading(static::getOrangeHeading())
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

    protected static function getOrangeHeading(): HtmlString
    {
        $totalLogs = Activity::query()->count();

        $updatedLogs = Activity::query()
            ->where(function ($query): void {
                $query->where('event', 'updated')
                    ->orWhere('description', 'like', '%updated%')
                    ->orWhere('description', 'like', '%diperbarui%');
            })
            ->count();

        $createdLogs = Activity::query()
            ->where(function ($query): void {
                $query->where('event', 'created')
                    ->orWhere('description', 'like', '%created%')
                    ->orWhere('description', 'like', '%dibuat%');
            })
            ->count();

        $deletedLogs = Activity::query()
            ->where(function ($query): void {
                $query->where('event', 'deleted')
                    ->orWhere('description', 'like', '%deleted%')
                    ->orWhere('description', 'like', '%dihapus%');
            })
            ->count();

        $accessLogs = Activity::query()
            ->where(function ($query): void {
                $query->where('log_name', 'access')
                    ->orWhere('event', 'login')
                    ->orWhere('description', 'like', '%login%');
            })
            ->count();

        $latestLog = Activity::query()
            ->with('causer')
            ->latest()
            ->first();

        $topCauser = Activity::query()
            ->select('causer_id', DB::raw('COUNT(*) as total_activity'))
            ->whereNotNull('causer_id')
            ->groupBy('causer_id')
            ->orderByDesc('total_activity')
            ->with('causer')
            ->first();

        $topUserName = e($topCauser?->causer?->name ?? '-');
        $topUserTotal = number_format((int) ($topCauser?->total_activity ?? 0), 0, ',', '.');

        $latestUser = e($latestLog?->causer?->name ?? '-');
        $latestEvent = e(Str::headline($latestLog?->event ?? $latestLog?->description ?? '-'));
        $latestTime = e($latestLog?->created_at?->diffForHumans() ?? '-');

        return new HtmlString('
            <div class="ng-activity-head">
                <div class="ng-activity-hero">
                    <div class="ng-activity-hero-main">
                        <h1>Activity Log Analytics</h1>
                        <p>
                            Pantau seluruh aktivitas sistem seperti login, perubahan produk, order, kategori,
                            user, role, dan riwayat aksi admin atau karyawan yang tercatat otomatis.
                        </p>
                    </div>

                    <div class="ng-activity-side">
                        <div>
                            <span>User Teraktif</span>
                            <strong>' . $topUserName . '</strong>
                            <small>' . $topUserTotal . ' aktivitas</small>
                        </div>

                        <div>
                            <span>Aktivitas Terbaru</span>
                            <strong>' . $latestEvent . '</strong>
                            <small>' . $latestUser . ' • ' . $latestTime . '</small>
                        </div>
                    </div>
                </div>

                <div class="ng-activity-kpis">
                    <div class="ng-kpi" style="--accent:#f97316">
                        <i>▣</i>
                        <div>
                            <span>Total Logs</span>
                            <strong>' . number_format($totalLogs, 0, ',', '.') . '</strong>
                            <small>Semua aktivitas</small>
                        </div>
                    </div>

                    <div class="ng-kpi" style="--accent:#3b82f6">
                        <i>↗</i>
                        <div>
                            <span>Updated Logs</span>
                            <strong>' . number_format($updatedLogs, 0, ',', '.') . '</strong>
                            <small>Data diperbarui</small>
                        </div>
                    </div>

                    <div class="ng-kpi" style="--accent:#10b981">
                        <i>✓</i>
                        <div>
                            <span>Created Logs</span>
                            <strong>' . number_format($createdLogs, 0, ',', '.') . '</strong>
                            <small>Data dibuat</small>
                        </div>
                    </div>

                    <div class="ng-kpi" style="--accent:#ef4444">
                        <i>!</i>
                        <div>
                            <span>Deleted Logs</span>
                            <strong>' . number_format($deletedLogs, 0, ',', '.') . '</strong>
                            <small>Data dihapus</small>
                        </div>
                    </div>

                    <div class="ng-kpi" style="--accent:#8b5cf6">
                        <i>◇</i>
                        <div>
                            <span>Access Logs</span>
                            <strong>' . number_format($accessLogs, 0, ',', '.') . '</strong>
                            <small>Login / akses</small>
                        </div>
                    </div>
                </div>
            </div>

            <style>
                html,
                body {
                    overflow-x: hidden !important;
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
                    background-attachment: fixed !important;
                }

                body:has(.ng-activity-head) .fi-main,
                body:has(.ng-activity-head) .fi-main-ctn,
                body:has(.ng-activity-head) .fi-page,
                body:has(.ng-activity-head) .fi-page-content {
                    width: 100% !important;
                    max-width: 100% !important;
                    background: transparent !important;
                    overflow-x: hidden !important;
                }

                body:has(.ng-activity-head) .fi-page,
                body:has(.ng-activity-head) .fi-main {
                    padding: 0 !important;
                }

                body:has(.ng-activity-head) .fi-page-header {
                    display: none !important;
                }

                body:has(.ng-activity-head) .fi-sidebar {
                    background: rgba(255, 250, 242, .50) !important;
                    border-right: 1px solid rgba(255, 255, 255, .48) !important;
                    box-shadow: 18px 0 55px rgba(137, 78, 26, .10) !important;
                    backdrop-filter: blur(16px) !important;
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

                /* CONTAINER UTAMA TABLE PLUGIN */
                body:has(.ng-activity-head) .fi-ta-ctn {
                    width: calc(100% - 36px) !important;
                    margin: 18px 18px 28px !important;
                    border-radius: 28px !important;
                    border: 1px solid rgba(255, 255, 255, .56) !important;
                    background: rgba(255, 247, 235, .20) !important;
                    box-shadow:
                        0 22px 55px rgba(101, 58, 21, .11),
                        inset 0 1px 0 rgba(255, 255, 255, .60) !important;
                    backdrop-filter: blur(15px) !important;
                    overflow: hidden !important;
                }

                body:has(.ng-activity-head) .fi-ta-header {
                    display: block !important;
                    padding: 0 !important;
                    background: transparent !important;
                    border-bottom: 1px solid rgba(114, 74, 41, .08) !important;
                }

                body:has(.ng-activity-head) .fi-ta-heading {
                    width: 100% !important;
                }

                body:has(.ng-activity-head) .fi-ta-header-toolbar,
                body:has(.ng-activity-head) .fi-ta-toolbar {
                    min-height: 58px !important;
                    padding: 10px 18px !important;
                    background: rgba(255, 247, 235, .16) !important;
                    border-bottom: 1px solid rgba(114, 74, 41, .08) !important;
                }

                /* HEADER CUSTOM */
                .ng-activity-head {
                    width: 100%;
                    padding: 18px;
                    font-family: Inter, Poppins, ui-sans-serif, system-ui, sans-serif;
                    color: #24180f;
                    box-sizing: border-box;
                }

                .ng-activity-head * {
                    box-sizing: border-box;
                }

                .ng-activity-hero {
                    display: grid;
                    grid-template-columns: minmax(0, 1.35fr) minmax(360px, .65fr);
                    gap: 12px;
                    margin-bottom: 12px;
                }

                .ng-activity-hero-main,
                .ng-activity-side,
                .ng-kpi {
                    overflow: hidden;
                    border: 1px solid rgba(255, 255, 255, .58);
                    background: rgba(255, 247, 235, .22);
                    box-shadow:
                        0 18px 44px rgba(101, 58, 21, .09),
                        inset 0 1px 0 rgba(255, 255, 255, .60);
                    backdrop-filter: blur(14px);
                }

                .ng-activity-hero-main {
                    min-height: 122px;
                    padding: 20px 22px;
                    border-radius: 24px;
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

                .ng-activity-hero-main h1 {
                    margin: 0;
                    color: #21160d;
                    font-size: 30px;
                    line-height: 1.05;
                    font-weight: 950;
                    letter-spacing: -.04em;
                }

                .ng-activity-hero-main p {
                    max-width: 850px;
                    margin: 8px 0 0;
                    color: #72583f;
                    font-size: 12px;
                    font-weight: 700;
                    line-height: 1.55;
                }

                .ng-activity-side {
                    min-height: 122px;
                    display: grid;
                    grid-template-columns: 1fr 1fr;
                    gap: 12px;
                    padding: 20px 22px;
                    border-radius: 24px;
                }

                .ng-activity-side > div + div {
                    padding-left: 14px;
                    border-left: 1px solid rgba(114, 74, 41, .12);
                }

                .ng-activity-side span,
                .ng-activity-side small {
                    display: block;
                    color: #72583f;
                    font-size: 11px;
                    font-weight: 850;
                }

                .ng-activity-side strong {
                    display: block;
                    max-width: 250px;
                    margin: 7px 0;
                    color: #21160d;
                    font-size: 20px;
                    line-height: 1.1;
                    font-weight: 950;
                    white-space: nowrap;
                    overflow: hidden;
                    text-overflow: ellipsis;
                }

                .ng-activity-kpis {
                    display: grid;
                    grid-template-columns: repeat(5, minmax(0, 1fr));
                    gap: 10px;
                }

                .ng-kpi {
                    min-height: 86px;
                    display: flex;
                    align-items: center;
                    gap: 12px;
                    padding: 14px;
                    border-radius: 20px;
                }

                .ng-kpi i {
                    display: grid;
                    place-items: center;
                    flex: 0 0 auto;
                    width: 40px;
                    height: 40px;
                    border-radius: 14px;
                    color: #fff;
                    background: linear-gradient(135deg, var(--accent), #d95d00);
                    box-shadow: 0 14px 24px rgba(249, 115, 22, .20);
                    font-style: normal;
                    font-size: 15px;
                    font-weight: 950;
                }

                .ng-kpi span {
                    display: block;
                    color: #6f5946;
                    font-size: 11px;
                    font-weight: 900;
                }

                .ng-kpi strong {
                    display: block;
                    margin-top: 5px;
                    color: #23160d;
                    font-size: 18px;
                    line-height: 1.15;
                    font-weight: 950;
                    letter-spacing: -.03em;
                }

                .ng-kpi small {
                    display: block;
                    margin-top: 5px;
                    color: #6f5946;
                    font-size: 10px;
                    font-weight: 850;
                }

                /* TABLE BAWAH BIAR MIRIP HALAMAN LAIN */
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
                    backdrop-filter: blur(10px) !important;
                }

                body:has(.ng-activity-head) .fi-ta-search-field {
                    max-width: 280px !important;
                }

                body:has(.ng-activity-head) .fi-ta-search-field .fi-input-wrp {
                    min-height: 38px !important;
                }

                body:has(.ng-activity-head) .fi-ta-filter-indicators,
                body:has(.ng-activity-head) .fi-ta-empty-state {
                    background: transparent !important;
                }

                @media (max-width: 1500px) {
                    .ng-activity-hero {
                        grid-template-columns: 1fr;
                    }

                    .ng-activity-kpis {
                        grid-template-columns: repeat(3, minmax(0, 1fr));
                    }
                }

                @media (max-width: 900px) {
                    body:has(.ng-activity-head) .fi-ta-ctn {
                        width: calc(100% - 28px) !important;
                        margin: 14px !important;
                    }

                    .ng-activity-head {
                        padding: 14px;
                    }

                    .ng-activity-side,
                    .ng-activity-kpis {
                        grid-template-columns: 1fr;
                    }
                }
            </style>
        ');
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
            'index' => \Jacobtims\FilamentLogger\Resources\ActivityResource\Pages\ListActivities::route('/'),
            'view' => \Jacobtims\FilamentLogger\Resources\ActivityResource\Pages\ViewActivity::route('/{record}'),
        ];
    }

}
