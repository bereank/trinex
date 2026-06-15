<?php

namespace App\Filament\Resources\OdrfReports\Widgets;

use App\Filament\Resources\OdrfReports\Pages\ListOdrfReports;
use Filament\Widgets\ChartWidget;
use Filament\Widgets\Concerns\InteractsWithPageTable;

class OdrfRequesterChart extends ChartWidget
{
    use InteractsWithPageTable;

    protected ?string $heading = 'Total Amount per Requester';

    protected int|string|array $columnSpan = 1;

    protected function getTablePage(): string
    {
        return ListOdrfReports::class;
    }

    protected function getData(): array
    {
        $rows = $this->getPageTableQuery()
            ->reorder()
            ->selectRaw('ReqName, SUM(DocTotal) as total_amount')
            ->whereNotNull('ReqName')
            ->where('ReqName', '!=', '')
            ->groupBy('ReqName')
            ->orderByDesc('total_amount')
            ->limit(10)
            ->get();

        return [
            'datasets' => [
                [
                    'label' => 'Amount (KES)',
                    'data' => $rows->pluck('total_amount')->map(fn ($value) => (float) $value)->all(),
                    'backgroundColor' => '#0ea5e9',
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
