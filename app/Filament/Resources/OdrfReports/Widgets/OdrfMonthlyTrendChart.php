<?php

namespace App\Filament\Resources\OdrfReports\Widgets;

use App\Models\ODRF;
use Carbon\Carbon;
use Filament\Widgets\ChartWidget;

class OdrfMonthlyTrendChart extends ChartWidget
{
    protected ?string $heading = 'Monthly Trend';

    protected int|string|array $columnSpan = 'full';

    // protected ?string $maxHeight = '320px';

    protected function getData(): array
    {
        $rows = ODRF::query()
            ->where('UserSign', auth()->id())
            ->reorder()
            ->selectRaw("DATE_FORMAT(DocDate, '%Y-%m') as month_key, COUNT(*) as total_requests, SUM(DocTotal) as total_amount")
            ->whereNotNull('DocDate')
            ->groupBy('month_key')
            ->orderBy('month_key')
            ->get();

        $labels = $rows
            ->pluck('month_key')
            ->map(fn (string $month) => Carbon::createFromFormat('Y-m', $month)->format('M Y'))
            ->all();

        return [
            'labels' => $labels,
            'datasets' => [
                [
                    'label' => 'Requests',
                    'type' => 'line',
                    'data' => $rows->pluck('total_requests')->map(fn ($value) => (int) $value)->all(),
                    'borderColor' => '#0ea5e9',
                    'backgroundColor' => '#0ea5e9',
                    'tension' => 0.3,
                    'yAxisID' => 'y',
                ],
                [
                    'label' => 'Amount (KES)',
                    'type' => 'bar',
                    'data' => $rows->pluck('total_amount')->map(fn ($value) => (float) $value)->all(),
                    'backgroundColor' => '#f59e0b',
                    'yAxisID' => 'y1',
                ],
            ],
        ];
    }

    protected function getType(): string
    {
        return 'bar';
    }

    protected function getOptions(): array
    {
        return [
            'scales' => [
                'y' => [
                    'type' => 'linear',
                    'position' => 'left',
                    'beginAtZero' => true,
                ],
                'y1' => [
                    'type' => 'linear',
                    'position' => 'right',
                    'beginAtZero' => true,
                    'grid' => [
                        'drawOnChartArea' => false,
                    ],
                ],
            ],
        ];
    }
}
