<?php

namespace App\Filament\Resources\OdrfReports\Widgets;

use App\Filament\Resources\OdrfReports\Pages\ListOdrfReports;
use Filament\Widgets\ChartWidget;
use Filament\Widgets\Concerns\InteractsWithPageTable;

class OdrfRequesterCountChart extends ChartWidget
{
    use InteractsWithPageTable;

    protected ?string $heading = 'Requests per Requester';

    protected int|string|array $columnSpan = 1;

    protected function getTablePage(): string
    {
        return ListOdrfReports::class;
    }

    protected function getData(): array
    {
        $rows = $this->getPageTableQuery()
            ->reorder()
            ->selectRaw('ReqName, COUNT(*) as total_requests')
            ->whereNotNull('ReqName')
            ->where('ReqName', '!=', '')
            ->groupBy('ReqName')
            ->orderByDesc('total_requests')
            ->limit(10)
            ->get();

        return [
            'datasets' => [
                [
                    'label' => 'Request Count',
                    'data' => $rows->pluck('total_requests')->map(fn ($value) => (int) $value)->all(),
                    'backgroundColor' => '#f97316',
                ],
            ],
            'labels' => $rows->pluck('ReqName')->all(),
        ];
    }

    protected function getType(): string
    {
        return 'bar';
    }
}
