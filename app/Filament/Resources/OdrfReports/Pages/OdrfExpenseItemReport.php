<?php

namespace App\Filament\Resources\OdrfReports\Pages;

use App\Filament\Resources\OdrfReports\OdrfReportResource;
use App\Filament\Resources\OdrfReports\Widgets\OdrfExpenseItemSummary;
use App\Filament\Resources\OdrfReports\Widgets\OdrfExpenseItemTable;
use Filament\Resources\Pages\Page;

class OdrfExpenseItemReport extends Page
{
    protected static string $resource = OdrfReportResource::class;

    protected string $view = 'filament.resources.odrf-reports.pages.odrf-expense-item-report';

    protected static ?string $title = 'Expense Item Report';

    protected function getHeaderWidgets(): array
    {
        return [
            OdrfExpenseItemSummary::class,
            OdrfExpenseItemTable::class,
        ];
    }

    public function getHeaderWidgetsColumns(): int|array
    {
        return 1;
    }
}
