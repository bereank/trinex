<?php

namespace App\Filament\Resources\OdrfReports\Widgets;

use App\Filament\Resources\OdrfReports\Pages\ListOdrfReports;
use Filament\Widgets\ChartWidget;
use Filament\Widgets\Concerns\InteractsWithPageTable;

class OdrfStatusChart extends ChartWidget
{
    use InteractsWithPageTable;

    protected ?string $heading = 'Request Status Breakdown';

    protected int|string|array $columnSpan = 1;

    protected function getTablePage(): string
    {
        return ListOdrfReports::class;
    }

    protected function getData(): array
    {
        $query = $this->getPageTableQuery();

        $approved = (clone $query)->where('WddStatus', 'Y')->count();
        $pending = (clone $query)->where('WddStatus', 'W')->count();
        $rejected = (clone $query)->where('WddStatus', 'N')->count();

        return [
            'datasets' => [
                [
                    'label' => 'Requests',
                    'data' => [$approved, $pending, $rejected],
                    'backgroundColor' => [
                        '#22c55e',
                        '#f59e0b',
                        '#ef4444',
                    ],
                ],
            ],
            'labels' => ['Approved', 'Pending', 'Rejected'],
        ];
    }

    protected function getType(): string
    {
        return 'doughnut';
    }
}
