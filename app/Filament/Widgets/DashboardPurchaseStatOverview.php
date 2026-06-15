<?php

namespace App\Filament\Widgets;


use App\Models\ODRF;
use Filament\Widgets\StatsOverviewWidget;
use Filament\Widgets\StatsOverviewWidget\Stat;

class DashboardPurchaseStatOverview extends StatsOverviewWidget
{
    protected function getStats(): array
    {

        $totalInventories = ODRF::where('UserSign', auth()->user()->id)->count();
        return [
            Stat::make('Requests', $totalInventories)
                ->descriptionIcon('heroicon-m-paper-airplane')
                ->description('Requests')
                ->color('info'),
            Stat::make('Completed Requests', ODRF::where('UserSign', auth()->user()->id)->where('WddStatus', 'P')->count())
                ->descriptionIcon('heroicon-m-check-badge')
                ->description('Requests Completed')
                ->color('success'),
            Stat::make('Pending Requests', ODRF::where('UserSign', auth()->user()->id)->where('WddStatus', 'W')->count())
                ->descriptionIcon('heroicon-m-arrow-path-rounded-square')
                ->description('Pending Approval')
                ->color('warning'),
            Stat::make('Rejected Requests', ODRF::where('UserSign', auth()->user()->id)->where('WddStatus', 'N')->count())
                ->descriptionIcon('heroicon-m-x-circle')
                ->description('Requests')
                ->color('danger'),
        ];
    }
}
