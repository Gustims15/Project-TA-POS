<?php

declare(strict_types=1);

namespace App\Filament\Admin\Resources\Roles\Widgets;

use BezhanSalleh\FilamentShield\Support\Utils;
use Filament\Widgets\Widget;

class RoleAnalyticsWidget extends Widget
{
    protected string $view = 'filament.admin.resources.roles.widgets.role-analytics-widget';

    protected int|string|array $columnSpan = 'full';

    protected function getViewData(): array
    {
        $roleModel = Utils::getRoleModel();
        $permissionModel = Utils::getPermissionModel();

        $totalRoles = $roleModel::query()->count();
        $totalPermissions = $permissionModel::query()->count();

        $webRoles = $roleModel::query()
            ->where('guard_name', 'web')
            ->count();

        $topRole = $roleModel::query()
            ->withCount('permissions')
            ->orderByDesc('permissions_count')
            ->first();

        return [
            'summary' => [
                'total_roles' => (int) $totalRoles,
                'total_permissions' => (int) $totalPermissions,
                'web_roles' => (int) $webRoles,
                'top_role_name' => $topRole?->name ?? '-',
                'top_role_permissions' => (int) ($topRole?->permissions_count ?? 0),
            ],
        ];
    }
}
