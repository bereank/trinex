<?php

namespace App\Filament\Resources\OdrfReports\Widgets;

use App\Filament\Resources\OdrfReports\Pages\ListOdrfReports;
use Filament\Widgets\Concerns\InteractsWithPageTable;
use Filament\Widgets\StatsOverviewWidget;
use Filament\Widgets\StatsOverviewWidget\Stat;

class OdrfReportsStatsOverview extends StatsOverviewWidget
{
    use InteractsWithPageTable;

    protected function getTablePage(): string
    {
        return ListOdrfReports::class;
    }

    protected function getStats(): array
    {
        $tableQuery = $this->getPageTableQuery();

        $totalRequests = (clone $tableQuery)->count();
        $totalAmount = (float) (clone $tableQuery)->sum('DocTotal');
        $approvedCount = (clone $tableQuery)->where('WddStatus', 'Y')->count();
        $pendingCount = (clone $tableQuery)->where('WddStatus', 'W')->count();
        $rejectedCount = (clone $tableQuery)->where('WddStatus', 'N')->count();

        return [
            Stat::make('Total Requests', number_format($totalRequests))
                ->description('All matched requests')
                ->descriptionIcon('heroicon-m-clipboard-document-list')
                ->color('info'),
            Stat::make('Total Amount', 'KES ' . number_format($totalAmount, 2))
                ->description('Summed from DocTotal')
                ->descriptionIcon('heroicon-m-banknotes')
                ->color('success'),
            Stat::make('Approved', number_format($approvedCount))
                ->description('Approved requests')
                ->descriptionIcon('heroicon-m-check-circle')
                ->color('success'),
            Stat::make('Pending / Rejected', number_format($pendingCount) . ' / ' . number_format($rejectedCount))
                ->description('Operational summary')
                ->descriptionIcon('heroicon-m-chart-pie')
                ->color('warning'),
        ];
    }
}
