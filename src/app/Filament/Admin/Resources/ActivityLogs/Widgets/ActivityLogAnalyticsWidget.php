<?php

declare(strict_types=1);

namespace App\Filament\Admin\Resources\ActivityLogs\Widgets;

use Filament\Widgets\Widget;
use Spatie\Activitylog\ActivitylogServiceProvider;

class ActivityLogAnalyticsWidget extends Widget
{
    protected string $view = 'filament.admin.resources.activity-logs.widgets.activity-log-analytics-widget';

    protected int|string|array $columnSpan = 'full';

    protected function getViewData(): array
    {
        $activityModel = ActivitylogServiceProvider::determineActivityModel();

        $totalLogs = $activityModel::query()->count();

        $updatedLogs = $activityModel::query()
            ->where('event', 'updated')
            ->count();

        $createdLogs = $activityModel::query()
            ->where('event', 'created')
            ->count();

        $deletedLogs = $activityModel::query()
            ->where('event', 'deleted')
            ->count();

        $latestLog = $activityModel::query()
            ->with('causer')
            ->latest()
            ->first();

        $activeUser = $activityModel::query()
            ->selectRaw('causer_id, COUNT(*) as total')
            ->whereNotNull('causer_id')
            ->groupBy('causer_id')
            ->orderByDesc('total')
            ->with('causer')
            ->first();

        return [
            'summary' => [
                'total_logs' => (int) $totalLogs,
                'updated_logs' => (int) $updatedLogs,
                'created_logs' => (int) $createdLogs,
                'deleted_logs' => (int) $deletedLogs,
                'latest_event' => $latestLog?->event ? ucfirst((string) $latestLog->event) : '-',
                'latest_user' => $latestLog?->causer?->name ?? '-',
                'active_user' => $activeUser?->causer?->name ?? '-',
                'active_user_logs' => (int) ($activeUser?->total ?? 0),
            ],
        ];
    }
}
