<?php

declare(strict_types=1);

namespace App\Filament\Admin\Resources\ActivityLogs\Tables;

use Filament\Facades\Filament;
use Filament\Forms\Components\DatePicker;
use Filament\Forms\Components\TextInput;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Filters\Filter;
use Filament\Tables\Filters\SelectFilter;
use Filament\Tables\Table;
use Illuminate\Contracts\Support\Htmlable;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\HtmlString;
use Illuminate\Support\Str;
use Spatie\Activitylog\ActivitylogServiceProvider;
use Spatie\Activitylog\Contracts\Activity;
use Spatie\Activitylog\Models\Activity as ActivityModel;

class ActivityLogsTable
{
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
        return static::applyLoginLogoutFilter(ActivityModel::query());
    }

    public static function configure(Table $table): Table
    {
        return $table
            ->heading(static::getLuxuryHeading())
            ->modifyQueryUsing(fn (Builder $query): Builder => static::applyLoginLogoutFilter($query))
            ->columns([
                TextColumn::make('log_name')
                    ->label('Type')
                    ->sortable()
                    ->html()
                    ->formatStateUsing(fn (?string $state): string => '
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
                            font-weight:900;
                            white-space:nowrap;
                        ">
                            <span style="
                                width:7px;
                                height:7px;
                                border-radius:999px;
                                background:#10b981;
                            "></span>
                            ' . e(ucwords((string) ($state ?? '-'))) . '
                        </span>
                    '),

                TextColumn::make('event')
                    ->label('Event')
                    ->sortable()
                    ->html()
                    ->formatStateUsing(function (?string $state): string {
                        $event = strtolower((string) ($state ?? '-'));

                        $style = match ($event) {
                            'login' => ['#f8fafc', '#e2e8f0', '#475569', '#64748b'],
                            'logout' => ['#fef2f2', '#fecaca', '#b91c1c', '#ef4444'],
                            'created' => ['#fff7ed', '#fed7aa', '#c2410c', '#f97316'],
                            'updated' => ['#eff6ff', '#bfdbfe', '#1d4ed8', '#3b82f6'],
                            'deleted' => ['#fef2f2', '#fecaca', '#b91c1c', '#ef4444'],
                            default => ['#f8fafc', '#e2e8f0', '#475569', '#64748b'],
                        };

                        return '
                            <span style="
                                display:inline-flex;
                                align-items:center;
                                gap:7px;
                                border-radius:999px;
                                padding:7px 11px;
                                background:' . $style[0] . ';
                                border:1px solid ' . $style[1] . ';
                                color:' . $style[2] . ';
                                font-size:12px;
                                font-weight:900;
                                white-space:nowrap;
                            ">
                                <span style="
                                    width:7px;
                                    height:7px;
                                    border-radius:999px;
                                    background:' . $style[3] . ';
                                "></span>
                                ' . e(Str::headline($event)) . '
                            </span>
                        ';
                    }),
                TextColumn::make('causer.name')
                    ->label('User')
                    ->html()
                    ->formatStateUsing(fn (?string $state): string => '
                        <span style="
                            display:inline-flex;
                            align-items:center;
                            gap:7px;
                            border-radius:999px;
                            padding:7px 11px;
                            background:#f5f3ff;
                            border:1px solid #ddd6fe;
                            color:#6d28d9;
                            font-size:12px;
                            font-weight:900;
                            white-space:nowrap;
                        ">
                            👤 ' . e($state ?? '-') . '
                        </span>
                    '),

                TextColumn::make('created_at')
                    ->label('Logged At')
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
                            📅 ' . e(\Carbon\Carbon::parse($state)->translatedFormat('d/m/Y H:i:s')) . '
                        </span>
                    '),

                TextColumn::make('description')
                    ->label('Description')
                    ->toggleable()
                    ->toggledHiddenByDefault()
                    ->wrap(),
            ])
            ->defaultSort('created_at', 'desc')
            ->toolbarActions([])
            ->filters([
                SelectFilter::make('event')
                    ->label('Aktivitas')
                    ->options([
                        'login' => 'Login',
                        'logout' => 'Logout',
                    ]),
            ])
            ->recordUrl(null);
    }

    protected static function getLuxuryHeading(): Htmlable
    {
        $totalLogs = static::loginLogoutQuery()->count();
        $totalText = number_format((int) $totalLogs, 0, ',', '.');

        return new HtmlString(<<<HTML
            <div class="activity-lux-heading ng-activity-head">
                <div class="ng-activity-hero-clean">
                    <div class="ng-activity-hero-copy">
                        <span class="ng-kicker">POS Ngunjuk</span>

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
                body:has(.activity-lux-heading) {
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

                body:has(.activity-lux-heading) .fi-main,
                body:has(.activity-lux-heading) .fi-main-ctn,
                body:has(.activity-lux-heading) .fi-page,
                body:has(.activity-lux-heading) .fi-page-content,
                body:has(.activity-lux-heading) main {
                    width: 100% !important;
                    max-width: 100% !important;
                    height: auto !important;
                    min-height: 0 !important;
                    max-height: none !important;
                    background: transparent !important;
                    overflow-x: hidden !important;
                    overflow-y: visible !important;
                }

                body:has(.activity-lux-heading) .fi-page,
                body:has(.activity-lux-heading) .fi-main {
                    padding: 0 !important;
                }

                body:has(.activity-lux-heading) .fi-page-header {
                    display: none !important;
                }

                body:has(.activity-lux-heading) .fi-ta-ctn {
                    width: calc(100% - 36px) !important;
                    margin: 18px 18px 28px !important;
                    border: none !important;
                    border-radius: 0 !important;
                    background: transparent !important;
                    box-shadow: none !important;
                    overflow-x: hidden !important;
                    overflow-y: visible !important;
                    backdrop-filter: none !important;
                    -webkit-backdrop-filter: none !important;
                }

                body:has(.activity-lux-heading) .fi-ta-header {
                    display: block !important;
                    padding: 0 !important;
                    background: transparent !important;
                    border: none !important;
                }

                body:has(.activity-lux-heading) .fi-ta-header-toolbar,
                body:has(.activity-lux-heading) .fi-ta-toolbar {
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

                .activity-lux-heading,
                .ng-activity-head {
                    width: 100%;
                    padding: 18px 0 0;
                    font-family: Inter, Poppins, ui-sans-serif, system-ui, sans-serif;
                    color: #24180f;
                    box-sizing: border-box;
                }

                .activity-lux-heading *,
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
                    color: #72583f;
                    font-size: 11px;
                    font-weight: 950;
                    text-transform: uppercase;
                    letter-spacing: .06em;
                }

                .ng-activity-total-box strong {
                    margin-top: 6px;
                    color: #21160d;
                    font-size: 25px;
                    line-height: 1;
                    font-weight: 950;
                    letter-spacing: -.04em;
                }

                .ng-activity-total-box small {
                    margin-top: 7px;
                    color: #72583f;
                    font-size: 11px;
                    font-weight: 850;
                }

                body:has(.activity-lux-heading) .fi-ta-content {
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


                /*
                 * Rapihkan lebar kolom Activity Log.
                 * Setelah kolom Subject dihapus, 4 kolom dibuat rata agar kanan tidak kosong.
                 */
                body:has(.activity-lux-heading) .fi-ta-table {
                    width: 100% !important;
                    table-layout: fixed !important;
                }

                body:has(.activity-lux-heading) .fi-ta-header-cell,
                body:has(.activity-lux-heading) .fi-ta-cell {
                    width: 25% !important;
                    text-align: center !important;
                    vertical-align: middle !important;
                }

                body:has(.activity-lux-heading) .fi-ta-header-cell > *,
                body:has(.activity-lux-heading) .fi-ta-cell > * {
                    justify-content: center !important;
                    margin-left: auto !important;
                    margin-right: auto !important;
                }

                body:has(.activity-lux-heading) .fi-ta-header-cell-label,
                body:has(.activity-lux-heading) .fi-ta-cell .fi-ta-text,
                body:has(.activity-lux-heading) .fi-ta-cell .fi-ta-text-item {
                    justify-content: center !important;
                    text-align: center !important;
                }

                body:has(.activity-lux-heading) .fi-ta-table th:nth-child(1),
                body:has(.activity-lux-heading) .fi-ta-table td:nth-child(1),
                body:has(.activity-lux-heading) .fi-ta-table th:nth-child(2),
                body:has(.activity-lux-heading) .fi-ta-table td:nth-child(2),
                body:has(.activity-lux-heading) .fi-ta-table th:nth-child(3),
                body:has(.activity-lux-heading) .fi-ta-table td:nth-child(3),
                body:has(.activity-lux-heading) .fi-ta-table th:nth-child(4),
                body:has(.activity-lux-heading) .fi-ta-table td:nth-child(4) {
                    width: 25% !important;
                }

                body:has(.activity-lux-heading) .fi-ta-table th:nth-child(n+5),
                body:has(.activity-lux-heading) .fi-ta-table td:nth-child(n+5) {
                    display: none !important;
                }

                body:has(.activity-lux-heading) .fi-ta,
                body:has(.activity-lux-heading) .fi-section,
                body:has(.activity-lux-heading) .fi-ta-content,
                body:has(.activity-lux-heading) .fi-ta-table-wrap {
                    height: auto !important;
                    min-height: 0 !important;
                    max-height: none !important;
                    overflow-x: hidden !important;
                    overflow-y: visible !important;
                }

                body:has(.activity-lux-heading) .fi-main,
                body:has(.activity-lux-heading) .fi-main-ctn,
                body:has(.activity-lux-heading) .fi-page,
                body:has(.activity-lux-heading) .fi-page-content,
                body:has(.activity-lux-heading) .fi-ta-ctn,
                body:has(.activity-lux-heading) .fi-ta-content,
                body:has(.activity-lux-heading) .fi-ta-table-wrap {
                    scrollbar-width: none !important;
                    -ms-overflow-style: none !important;
                }

                body:has(.activity-lux-heading) .fi-main::-webkit-scrollbar,
                body:has(.activity-lux-heading) .fi-main-ctn::-webkit-scrollbar,
                body:has(.activity-lux-heading) .fi-page::-webkit-scrollbar,
                body:has(.activity-lux-heading) .fi-page-content::-webkit-scrollbar,
                body:has(.activity-lux-heading) .fi-ta-ctn::-webkit-scrollbar,
                body:has(.activity-lux-heading) .fi-ta-content::-webkit-scrollbar,
                body:has(.activity-lux-heading) .fi-ta-table-wrap::-webkit-scrollbar {
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

    protected static function getSubjectTypeList(): array
    {
        if (config('filament-logger.resources.enabled', true)) {
            $subjects = [];
            $exceptResources = [...config('filament-logger.resources.exclude'), config('filament-logger.activity_resource')];

            $removedExcludedResources = collect(Filament::getResources())->filter(function ($resource) use ($exceptResources) {
                return ! in_array($resource, $exceptResources, true);
            });

            foreach ($removedExcludedResources as $resource) {
                $model = $resource::getModel();
                $subjects[$model] = Str::of(class_basename($model))->headline();
            }

            return $subjects;
        }

        return [];
    }

    protected static function getLogNameList(): array
    {
        $customs = [];

        foreach (config('filament-logger.custom') ?? [] as $custom) {
            $customs[$custom['log_name']] = $custom['log_name'];
        }

        return array_merge(
            config('filament-logger.resources.enabled') ? [
                config('filament-logger.resources.log_name') => config('filament-logger.resources.log_name'),
            ] : [],
            config('filament-logger.models.enabled') ? [
                config('filament-logger.models.log_name') => config('filament-logger.models.log_name'),
            ] : [],
            config('filament-logger.access.enabled')
                ? [config('filament-logger.access.log_name') => config('filament-logger.access.log_name')]
                : [],
            config('filament-logger.notifications.enabled') ? [
                config('filament-logger.notifications.log_name') => config('filament-logger.notifications.log_name'),
            ] : [],
            $customs,
        );
    }
}
