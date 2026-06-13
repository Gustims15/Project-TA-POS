<?php

declare(strict_types=1);

namespace App\Filament\Admin\Logger\Pages;

use App\Filament\Admin\Logger\ActivityLogResource;
use App\Models\User;
use Filament\Resources\Pages\ListRecords;
use Illuminate\Support\Facades\DB;
use Spatie\Activitylog\Models\Activity;

class ListActivityLogs extends ListRecords
{
    protected static string $resource = ActivityLogResource::class;

    protected string $view = 'filament.admin.resources.activity-logs.pages.list-activity-logs';

    public function getTitle(): string
    {
        return '';
    }

    protected function getHeaderActions(): array
    {
        return [];
    }

    public function getActivitySummary(): array
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
            ->first();

        $topUser = $topCauser?->causer_id
            ? User::query()->find($topCauser->causer_id)
            : null;

        return [
            'total_logs' => (int) $totalLogs,
            'updated_logs' => (int) $updatedLogs,
            'created_logs' => (int) $createdLogs,
            'deleted_logs' => (int) $deletedLogs,
            'access_logs' => (int) $accessLogs,
            'latest_user' => $latestLog?->causer?->name ?? '-',
            'latest_event' => $latestLog?->event ?? $latestLog?->description ?? '-',
            'latest_time' => $latestLog?->created_at?->diffForHumans() ?? '-',
            'top_user' => $topUser?->name ?? '-',
            'top_user_total' => (int) ($topCauser?->total_activity ?? 0),
        ];
    }
}
