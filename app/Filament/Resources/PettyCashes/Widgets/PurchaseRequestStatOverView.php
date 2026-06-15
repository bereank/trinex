<?php

namespace App\Filament\Resources\PettyCashes\Widgets;


use App\Filament\Resources\PettyCashes\Pages\ListPettyCashes;
use Filament\Widgets\Concerns\InteractsWithPageTable;
use Filament\Widgets\StatsOverviewWidget;
use Filament\Widgets\StatsOverviewWidget\Stat;

class PurchaseRequestStatOverView extends StatsOverviewWidget
{
    use InteractsWithPageTable;


    protected function getTablePage(): string
    {
        return ListPettyCashes::class;
    }
    protected function getStats(): array
    {
        return [
            Stat::make('Requests', number_format($this->getPageTableQuery()->count()))
                ->descriptionIcon('heroicon-m-paper-airplane')
                ->description('Requests')
                ->color('info'),
            Stat::make('Completed Requests', number_format($this->getPageTableQuery()->where('WddStatus', 'P')->count()))
                ->descriptionIcon('heroicon-m-check-badge')
                ->description('Requests Completed')
                ->color('success'),
            Stat::make('Pending Requests', number_format($this->getPageTableQuery()->where('WddStatus', 'W')->count()))
                ->descriptionIcon('heroicon-m-arrow-path-rounded-square')
                ->description('Pending Approval')
                ->color('warning'),
            Stat::make('Rejected Requests', number_format($this->getPageTableQuery()->where('WddStatus', 'N')->count()))
                ->descriptionIcon('heroicon-m-x-circle')
                ->description('Requests')
                ->color('danger'),
        ];
    }
}
