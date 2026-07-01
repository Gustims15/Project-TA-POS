<?php

declare(strict_types=1);

namespace App\Filament\Admin\Resources\ActivityLogs\Pages;

use App\Filament\Admin\Logger\ActivityLogResource;
use App\Models\User;
use Filament\Resources\Pages\ListRecords;
use Illuminate\Support\Facades\DB;
use Spatie\Activitylog\Models\Activity;

class ListActivityLogs extends ListRecords
{
    protected static string $resource = ActivityLogResource::class;

    protected string $view = 'filament.admin.logger.pages.list-activity-logs';

    protected static bool $isLazy = false;

    public function getTitle(): string
    {
        return '';
    }

    protected function getHeaderActions(): array
    {
        return [];
    }


    protected function getHeaderWidgets(): array
    {
        return [];
    }

    protected function getFooterWidgets(): array
    {
        return [];
    }


    protected function applyLoginLogoutFilter($query)
    {
        return $query->where(function ($query): void {
            $query
                ->whereIn('event', ['login', 'logout'])
                ->orWhere('description', 'like', '%login%')
                ->orWhere('description', 'like', '%logout%')
                ->orWhere('description', 'like', '%logged in%')
                ->orWhere('description', 'like', '%logged out%');
        });
    }

    protected function loginLogoutQuery()
    {
        return $this->applyLoginLogoutFilter(Activity::query());
    }

    public function getActivitySummary(): array
    {
        $totalLogs = $this->loginLogoutQuery()->count();

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

        $accessLogs = $this->loginLogoutQuery()->count();

        $latestLog = $this->loginLogoutQuery()
            ->with('causer')
            ->latest()
            ->first();

        $topCauser = $this->loginLogoutQuery()
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
