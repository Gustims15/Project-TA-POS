<?php

declare(strict_types=1);

namespace App\Filament\Admin\Resources\Orders\Pages;

use App\Filament\Admin\Resources\Orders\OrderResource;
use Filament\Actions\Action;
use Filament\Resources\Pages\ViewRecord;

class ViewOrder extends ViewRecord
{
    protected static string $resource = OrderResource::class;

    protected string $view = 'filament.admin.resources.orders.pages.view-order';

    public function getTitle(): string
    {
        return 'Detail ' . ($this->record->order_code ?? 'Order');
    }

    protected function getHeaderActions(): array
    {
        return [
            Action::make('backToOrders')
                ->label('Kembali ke Order')
                ->icon('heroicon-o-arrow-left')
                ->color('gray')
                ->url(OrderResource::getUrl('index')),
        ];
    }
}
