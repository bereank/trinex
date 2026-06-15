<?php

namespace App\Filament\Resources\OdrfReports\Pages;

use App\Filament\Resources\OdrfReports\OdrfReportResource;
use App\Filament\Resources\OdrfReports\Widgets\OdrfRequesterChart;
use App\Filament\Resources\OdrfReports\Widgets\OdrfRequesterCountChart;
use App\Filament\Resources\OdrfReports\Widgets\OdrfReportsStatsOverview;
use App\Filament\Resources\OdrfReports\Widgets\OdrfStatusChart;
use App\Models\ODRF;
use Filament\Actions\Action;
use Filament\Forms\Components\DatePicker;
use Filament\Forms\Components\Select;
use Filament\Pages\Concerns\ExposesTableToWidgets;
use Filament\Resources\Pages\ListRecords;

class ListOdrfReports extends ListRecords
{
    use ExposesTableToWidgets;

    protected static string $resource = OdrfReportResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Action::make('expense_item_report')
                ->label('Expense Item Report')
                ->icon('heroicon-o-queue-list')
                ->url(OdrfReportResource::getUrl('expense-items')),
            Action::make('monthly_trends')
                ->label('Monthly Trends')
                ->icon('heroicon-o-chart-bar-square')
                ->url(OdrfReportResource::getUrl('trends')),
            Action::make('export')
                ->label('Export')
                ->icon('heroicon-o-arrow-down-tray')
                ->form([
                    Select::make('requester')
                        ->label('Requester')
                        ->searchable()
                        ->options(fn (): array => ODRF::query()
                            ->where('UserSign', auth()->id())
                            ->whereNotNull('ReqName')
                            ->where('ReqName', '!=', '')
                            ->orderBy('ReqName')
                            ->distinct()
                            ->pluck('ReqName', 'ReqName')
                            ->toArray()),
                    Select::make('status')
                        ->label('Status')
                        ->options([
                            'Y' => 'Approved',
                            'W' => 'Pending',
                            'N' => 'Rejected',
                        ]),
                    DatePicker::make('from_date')
                        ->label('From Date'),
                    DatePicker::make('to_date')
                        ->label('To Date'),
                ])
                ->action(function (array $data) {
                    $query = ODRF::query()
                        ->where('UserSign', auth()->id())
                        ->orderByDesc('id');

                    if (! empty($data['requester'])) {
                        $query->where('ReqName', $data['requester']);
                    }

                    if (! empty($data['status'])) {
                        $query->where('WddStatus', $data['status']);
                    }

                    if (! empty($data['from_date'])) {
                        $query->whereDate('DocDate', '>=', $data['from_date']);
                    }

                    if (! empty($data['to_date'])) {
                        $query->whereDate('DocDate', '<=', $data['to_date']);
                    }

                    $documents = $query->get();

                    return response()->streamDownload(function () use ($documents) {
                        $handle = fopen('php://output', 'w');

                        fputcsv($handle, ['Requester', 'Branch', 'Date', 'Total', 'SAP Doc #', 'Status', 'Remarks']);

                        foreach ($documents as $doc) {
                            $status = match ($doc->WddStatus) {
                                'Y', 'P' => 'Approved',
                                'W' => 'Pending',
                                'N' => 'Rejected',
                                default => 'Unknown',
                            };

                            fputcsv($handle, [
                                $doc->ReqName ?? 'N/A',
                                $doc->Branch ?? 'N/A',
                                $doc->DocDate,
                                number_format((float) $doc->DocTotal, 2, '.', ''),
                                $doc->ExtRefDocNum ?? 'N/A',
                                $status,
                                $doc->Comments ?? '',
                            ]);
                        }

                        fclose($handle);
                    }, 'odrf_reports_' . now()->format('Ymd_His') . '.csv', [
                        'Content-Type' => 'text/csv; charset=UTF-8',
                    ]);
                }),
        ];
    }

    protected function getHeaderWidgets(): array
    {
        return [
            OdrfReportsStatsOverview::class,
            OdrfStatusChart::class,
            OdrfRequesterChart::class,
            OdrfRequesterCountChart::class,
        ];
    }

    public function getHeaderWidgetsColumns(): int|array
    {
        return 3;
    }
}
