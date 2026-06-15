<?php

namespace App\Filament\Resources\OdrfReports\Widgets;

use App\Models\DRF1;
use Filament\Widgets\StatsOverviewWidget;
use Filament\Widgets\StatsOverviewWidget\Stat;

class OdrfExpenseItemSummary extends StatsOverviewWidget
{
    protected function getStats(): array
    {
        $baseQuery = DRF1::query()
            ->join('o_d_r_f_s as odrf', 'odrf.id', '=', 'd_r_f1_s.DocEntry')
            ->where('odrf.UserSign', auth()->id())
            ->whereNotNull('d_r_f1_s.AcctCode')
            ->where('d_r_f1_s.AcctCode', '!=', '');

        $totalLines = (clone $baseQuery)->count();
        $distinctItems = (clone $baseQuery)->distinct('d_r_f1_s.AcctCode')->count('d_r_f1_s.AcctCode');
        $distinctRequests = (clone $baseQuery)->distinct('d_r_f1_s.DocEntry')->count('d_r_f1_s.DocEntry');
        $totalAmount = (float) (clone $baseQuery)->sum('d_r_f1_s.LineTotal');

        return [
            Stat::make('Total Request Lines', number_format($totalLines))
                ->description('All expense lines')
                ->descriptionIcon('heroicon-m-list-bullet')
                ->color('info'),
            Stat::make('Expense Items', number_format($distinctItems))
                ->description('Distinct AcctCode count')
                ->descriptionIcon('heroicon-m-tag')
                ->color('warning'),
            Stat::make('Requests Covered', number_format($distinctRequests))
                ->description('Distinct request documents')
                ->descriptionIcon('heroicon-m-document-text')
                ->color('primary'),
            Stat::make('Total Amount', 'KES ' . number_format($totalAmount, 2))
                ->description('Sum of line totals')
                ->descriptionIcon('heroicon-m-banknotes')
                ->color('success'),
        ];
    }
}
