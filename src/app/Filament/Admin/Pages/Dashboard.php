<?php

declare(strict_types=1);

namespace App\Filament\Admin\Pages;

use App\Filament\Admin\Widgets\DailyUnitsChart;
use App\Filament\Admin\Widgets\DashboardLuxuryOverviewWidget;
use App\Filament\Admin\Widgets\LatestOrdersTable;
use App\Filament\Admin\Widgets\MonthlyRevenueChart;
use App\Filament\Admin\Widgets\MonthlyUnitsChart;
use App\Filament\Admin\Widgets\ProductCategoryChart;
use App\Filament\Admin\Widgets\TopProductsTable;
use Filament\Pages\Dashboard as BaseDashboard;

class Dashboard extends BaseDashboard
{
    protected static ?string $navigationLabel = 'Dashboard POS Ngunjuk';

    protected static ?string $title = 'Dashboard POS Ngunjuk';

    protected static string|\BackedEnum|null $navigationIcon = 'heroicon-o-home';

    protected static ?int $navigationSort = 0;

    public static function canAccess(): bool
    {
        return auth()->check()
            && auth()->user()->hasRole('super_admin');
    }

    public static function shouldRegisterNavigation(): bool
    {
        return auth()->check()
            && auth()->user()->hasRole('super_admin');
    }

    public function getColumns(): int|array
    {
        return [
            'default' => 1,
            'md' => 2,
            'xl' => 12,
        ];
    }

    public function getWidgets(): array
    {
        if (! auth()->check() || ! auth()->user()->hasRole('super_admin')) {
            return [];
        }

        return [
            DashboardLuxuryOverviewWidget::class,

            ProductCategoryChart::class,
            DailyUnitsChart::class,

            MonthlyRevenueChart::class,
            MonthlyUnitsChart::class,

            TopProductsTable::class,
            LatestOrdersTable::class,
        ];
    }

    protected function getHeaderActions(): array
    {
        return [];
    }
}