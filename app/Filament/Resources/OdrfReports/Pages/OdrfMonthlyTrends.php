<?php

namespace App\Filament\Resources\OdrfReports\Pages;

use App\Filament\Resources\OdrfReports\OdrfReportResource;
use App\Filament\Resources\OdrfReports\Widgets\OdrfMonthlyTrendChart;
use Filament\Resources\Pages\Page;

class OdrfMonthlyTrends extends Page
{
    protected static string $resource = OdrfReportResource::class;

    protected string $view = 'filament.resources.odrf-reports.pages.odrf-monthly-trends';

    protected static ?string $title = 'Monthly Trends';

    protected function getHeaderWidgets(): array
    {
        return [
            OdrfMonthlyTrendChart::class,
        ];
    }

    public function getHeaderWidgetsColumns(): int|array
    {
        return 1;
    }
}
