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
    public static function configure(Table $table): Table
    {
        return $table
            ->heading(static::getLuxuryHeading())
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

                TextColumn::make('subject_type')
                    ->label('Subject')
                    ->html()
                    ->formatStateUsing(function ($state, Model $record): string {
                        /** @var Activity&ActivityModel $record */
                        if (! $state) {
                            return '<span style="color:#94a3b8;font-weight:700;">-</span>';
                        }

                        $subject = Str::of($state)->afterLast('\\')->headline() . ' # ' . $record->subject_id;

                        return '
                            <div style="display:flex; flex-direction:column; gap:4px;">
                                <span style="
                                    color:#0f172a;
                                    font-weight:950;
                                    font-size:14px;
                                ">
                                    ' . e((string) $subject) . '
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
                                    Activity Subject
                                </span>
                            </div>
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
                SelectFilter::make('log_name')
                    ->label('Type')
                    ->options(static::getLogNameList()),

                SelectFilter::make('subject_type')
                    ->label('Subject Type')
                    ->options(static::getSubjectTypeList()),

                Filter::make('properties->old')
                    ->schema([
                        TextInput::make('old')
                            ->label('Old Attributes'),
                    ])
                    ->query(function (Builder $query, array $data): Builder {
                        if (! ($data['old'] ?? null)) {
                            return $query;
                        }

                        return $query->where('properties->old', 'like', "%{$data['old']}%");
                    }),

                Filter::make('properties->attributes')
                    ->schema([
                        TextInput::make('new')
                            ->label('New Attributes'),
                    ])
                    ->query(function (Builder $query, array $data): Builder {
                        if (! ($data['new'] ?? null)) {
                            return $query;
                        }

                        return $query->where('properties->attributes', 'like', "%{$data['new']}%");
                    }),

                Filter::make('created_at')
                    ->schema([
                        DatePicker::make('logged_at')
                            ->label('Logged At')
                            ->displayFormat(config('filament-logger.date_format', 'd/m/Y')),
                    ])
                    ->query(function (Builder $query, array $data): Builder {
                        return $query
                            ->when(
                                $data['logged_at'] ?? null,
                                fn (Builder $query, $date): Builder => $query->whereDate('created_at', $date),
                            );
                    }),
            ]);
    }

    protected static function getLuxuryHeading(): Htmlable
    {
        $activityModel = ActivitylogServiceProvider::determineActivityModel();

        $totalLogs = (int) $activityModel::query()->count();

        $updatedLogs = (int) $activityModel::query()
            ->where('event', 'updated')
            ->count();

        $createdLogs = (int) $activityModel::query()
            ->where('event', 'created')
            ->count();

        $deletedLogs = (int) $activityModel::query()
            ->where('event', 'deleted')
            ->count();

        $activeUser = $activityModel::query()
            ->selectRaw('causer_id, COUNT(*) as total')
            ->whereNotNull('causer_id')
            ->groupBy('causer_id')
            ->orderByDesc('total')
            ->with('causer')
            ->first();

        $activeUserName = e($activeUser?->causer?->name ?? '-');
        $activeUserLogs = number_format((int) ($activeUser?->total ?? 0), 0, ',', '.');

        return new HtmlString('
            <style>
                .activity-lux-heading {
                    width: 100%;
                    padding: 0 0 22px;
                }

                .activity-lux-hero {
                    position: relative;
                    overflow: hidden;
                    border-radius: 30px;
                    padding: 30px;
                    color: white;
                    background:
                        radial-gradient(circle at top right, rgba(255,255,255,0.32), transparent 28%),
                        radial-gradient(circle at bottom left, rgba(255,255,255,0.18), transparent 28%),
                        linear-gradient(135deg, #0f766e 0%, #0d9488 45%, #10b981 100%);
                    box-shadow: 0 28px 70px rgba(15, 118, 110, 0.22);
                    isolation: isolate;
                }

                .activity-lux-hero::before {
                    content: "";
                    position: absolute;
                    inset: 0;
                    background-image:
                        linear-gradient(rgba(255,255,255,0.09) 1px, transparent 1px),
                        linear-gradient(90deg, rgba(255,255,255,0.09) 1px, transparent 1px);
                    background-size: 34px 34px;
                    opacity: 0.24;
                    z-index: -1;
                }

                .activity-lux-hero-top {
                    display: flex;
                    align-items: flex-start;
                    justify-content: space-between;
                    gap: 24px;
                }

                .activity-lux-badge {
                    display: inline-flex;
                    align-items: center;
                    gap: 9px;
                    width: fit-content;
                    padding: 9px 14px;
                    border-radius: 999px;
                    background: rgba(255,255,255,0.16);
                    border: 1px solid rgba(255,255,255,0.25);
                    backdrop-filter: blur(10px);
                    font-size: 12px;
                    font-weight: 800;
                    letter-spacing: 0.12em;
                    text-transform: uppercase;
                }

                .activity-lux-dot {
                    width: 9px;
                    height: 9px;
                    border-radius: 999px;
                    background: #bbf7d0;
                    box-shadow: 0 0 0 5px rgba(187,247,208,0.22);
                }

                .activity-lux-title {
                    margin: 16px 0 0;
                    font-size: 34px;
                    line-height: 1.08;
                    font-weight: 950;
                    letter-spacing: -0.04em;
                    color: #ffffff;
                }

                .activity-lux-desc {
                    margin: 12px 0 0;
                    max-width: 780px;
                    color: rgba(255,255,255,0.86);
                    font-size: 14px;
                    line-height: 1.7;
                    font-weight: 500;
                }

                .activity-lux-mini {
                    min-width: 260px;
                    border-radius: 22px;
                    padding: 18px;
                    background: rgba(255,255,255,0.16);
                    border: 1px solid rgba(255,255,255,0.24);
                    backdrop-filter: blur(12px);
                }

                .activity-lux-mini span {
                    display: block;
                    color: rgba(255,255,255,0.78);
                    font-size: 12px;
                    font-weight: 700;
                }

                .activity-lux-mini strong {
                    display: block;
                    margin-top: 8px;
                    color: white;
                    font-size: 24px;
                    line-height: 1.15;
                    font-weight: 950;
                }

                .activity-lux-mini small {
                    display: block;
                    margin-top: 8px;
                    color: rgba(255,255,255,0.82);
                    font-size: 12px;
                    font-weight: 700;
                }

                .activity-lux-grid {
                    display: grid;
                    grid-template-columns: repeat(4, minmax(0, 1fr));
                    gap: 16px;
                    margin-top: 20px;
                }

                .activity-lux-card {
                    position: relative;
                    overflow: hidden;
                    border-radius: 24px;
                    padding: 20px;
                    background: white;
                    border: 1px solid rgba(226,232,240,0.95);
                    box-shadow: 0 16px 40px rgba(15,23,42,0.07);
                    min-height: 145px;
                }

                .activity-lux-card::after {
                    content: "";
                    position: absolute;
                    width: 118px;
                    height: 118px;
                    top: -52px;
                    right: -42px;
                    border-radius: 999px;
                    opacity: 0.15;
                }

                .activity-lux-card.total::after { background: #10b981; }
                .activity-lux-card.updated::after { background: #3b82f6; }
                .activity-lux-card.created::after { background: #f97316; }
                .activity-lux-card.deleted::after { background: #ef4444; }

                .activity-lux-label {
                    margin: 0;
                    color: #64748b;
                    font-size: 13px;
                    font-weight: 850;
                }

                .activity-lux-value {
                    margin: 18px 0 0;
                    color: #020617;
                    font-size: 30px;
                    line-height: 1;
                    font-weight: 950;
                    letter-spacing: -0.045em;
                }

                .activity-lux-caption {
                    display: inline-flex;
                    align-items: center;
                    margin-top: 14px;
                    border-radius: 999px;
                    padding: 7px 11px;
                    font-size: 12px;
                    font-weight: 800;
                }

                .total .activity-lux-caption { background: #ecfdf5; color: #047857; }
                .updated .activity-lux-caption { background: #eff6ff; color: #1d4ed8; }
                .created .activity-lux-caption { background: #fff7ed; color: #c2410c; }
                .deleted .activity-lux-caption { background: #fef2f2; color: #b91c1c; }

                @media (max-width: 1100px) {
                    .activity-lux-hero-top {
                        flex-direction: column;
                    }

                    .activity-lux-grid {
                        grid-template-columns: repeat(2, minmax(0, 1fr));
                    }
                }

                @media (max-width: 700px) {
                    .activity-lux-hero {
                        padding: 24px;
                        border-radius: 24px;
                    }

                    .activity-lux-title {
                        font-size: 28px;
                    }

                    .activity-lux-grid {
                        grid-template-columns: 1fr;
                    }
                }
            </style>

            <div class="activity-lux-heading">
                <section class="activity-lux-hero">
                    <div class="activity-lux-hero-top">
                        <div>
                            <div class="activity-lux-badge">
                                <span class="activity-lux-dot"></span>
                                Ngunjuk POS Logger
                            </div>

                            <h2 class="activity-lux-title">
                                Activity Log Analytics
                            </h2>

                            <p class="activity-lux-desc">
                                Pantau seluruh aktivitas sistem seperti perubahan data produk,
                                order, kategori, user, role, serta riwayat aktivitas admin/karyawan
                                yang tercatat otomatis oleh sistem.
                            </p>
                        </div>

                        <div class="activity-lux-mini">
                            <span>User Teraktif</span>
                            <strong>'.$activeUserName.'</strong>
                            <small>'.$activeUserLogs.' aktivitas</small>
                        </div>
                    </div>
                </section>

                <div class="activity-lux-grid">
                    <div class="activity-lux-card total">
                        <p class="activity-lux-label">Total Logs</p>
                        <p class="activity-lux-value">'.number_format($totalLogs, 0, ',', '.').'</p>
                        <p class="activity-lux-caption">Semua aktivitas</p>
                    </div>

                    <div class="activity-lux-card updated">
                        <p class="activity-lux-label">Updated Logs</p>
                        <p class="activity-lux-value">'.number_format($updatedLogs, 0, ',', '.').'</p>
                        <p class="activity-lux-caption">Data diperbarui</p>
                    </div>

                    <div class="activity-lux-card created">
                        <p class="activity-lux-label">Created Logs</p>
                        <p class="activity-lux-value">'.number_format($createdLogs, 0, ',', '.').'</p>
                        <p class="activity-lux-caption">Data dibuat</p>
                    </div>

                    <div class="activity-lux-card deleted">
                        <p class="activity-lux-label">Deleted Logs</p>
                        <p class="activity-lux-value">'.number_format($deletedLogs, 0, ',', '.').'</p>
                        <p class="activity-lux-caption">Data dihapus</p>
                    </div>
                </div>
            </div>
        ');
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
