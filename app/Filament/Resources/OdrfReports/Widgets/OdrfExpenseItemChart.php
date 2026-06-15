<?php

namespace App\Filament\Resources\OdrfReports\Widgets;

use App\Models\DRF1;
use Filament\Widgets\ChartWidget;

class OdrfExpenseItemChart extends ChartWidget
{
    protected ?string $heading = 'Requests per Expense Item (AcctCode)';

    protected int|string|array $columnSpan = 'full';

    protected ?string $maxHeight = '360px';

    protected function getData(): array
    {
        $rows = DRF1::query()
            ->join('o_d_r_f_s as odrf', 'odrf.id', '=', 'd_r_f1_s.DocEntry')
            ->leftJoin('expenses as expense', 'expense.AcctCode', '=', 'd_r_f1_s.AcctCode')
            ->where('odrf.UserSign', auth()->id())
            ->whereNotNull('d_r_f1_s.AcctCode')
            ->where('d_r_f1_s.AcctCode', '!=', '')
            ->selectRaw('d_r_f1_s.AcctCode as acct_code')
            ->selectRaw("COALESCE(MAX(expense.AcctName), d_r_f1_s.AcctCode) as acct_name")
            ->selectRaw('COUNT(DISTINCT d_r_f1_s.DocEntry) as request_count')
            ->selectRaw('SUM(d_r_f1_s.LineTotal) as total_amount')
            ->groupBy('d_r_f1_s.AcctCode')
            ->orderByDesc('request_count')
            ->limit(12)
            ->get();

        $labels = $rows
            ->map(fn ($row) => $row->acct_code . ' - ' . $row->acct_name)
            ->all();

        return [
            'labels' => $labels,
            'datasets' => [
                [
                    'label' => 'Request Count',
                    'type' => 'bar',
                    'data' => $rows->pluck('request_count')->map(fn ($value) => (int) $value)->all(),
                    'backgroundColor' => '#0ea5e9',
                    'yAxisID' => 'y',
                ],
                [
                    'label' => 'Total Amount (KES)',
                    'type' => 'line',
                    'data' => $rows->pluck('total_amount')->map(fn ($value) => (float) $value)->all(),
                    'borderColor' => '#f59e0b',
                    'backgroundColor' => '#f59e0b',
                    'tension' => 0.3,
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
