<?php

namespace App\Filament\Widgets;

use App\Models\ODRF;
use Filament\Widgets\StatsOverviewWidget;
use Filament\Widgets\StatsOverviewWidget\Stat;

class DashboardFinancialSummary extends StatsOverviewWidget
{
    protected static ?int $sort = 2;

    protected function getStats(): array
    {
        $userId = auth()->id();

        $baseQuery = ODRF::query()->where('UserSign', $userId);

        $totalRequests = (clone $baseQuery)->count();
        $totalAmount = (float) (clone $baseQuery)->sum('DocTotal');
        $monthRequests = (clone $baseQuery)
            ->whereYear('DocDate', now()->year)
            ->whereMonth('DocDate', now()->month)
            ->count();
        $approvedRequests = (clone $baseQuery)
            ->whereIn('WddStatus', ['Y', 'P'])
            ->count();

        $approvalRate = $totalRequests > 0
            ? round(($approvedRequests / $totalRequests) * 100, 1)
            : 0;

        return [
            Stat::make('Total Requests', number_format($totalRequests))
                ->description('All your requests')
                ->descriptionIcon('heroicon-m-clipboard-document-list')
                ->color('info'),
            Stat::make('Total Amount', 'KES ' . number_format($totalAmount, 2))
                ->description('Cumulative requested amount')
                ->descriptionIcon('heroicon-m-banknotes')
                ->color('success'),
            Stat::make('This Month Requests', number_format($monthRequests))
                ->description(now()->format('F') . ' activity')
                ->descriptionIcon('heroicon-m-calendar-days')
                ->color('warning'),
            Stat::make('Approval Rate', $approvalRate . '%')
                ->description('Approved over total requests')
                ->descriptionIcon('heroicon-m-check-badge')
                ->color('primary'),
        ];
    }
}
