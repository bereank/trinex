<?php

namespace App\Filament\Resources\OdrfReports\Widgets;

use App\Models\DRF1;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;
use Filament\Widgets\TableWidget;
use Illuminate\Support\Collection;

class OdrfExpenseItemTable extends TableWidget
{
    protected int|string|array $columnSpan = 'full';

    protected static ?string $heading = 'Expense Item Summary';

       

    public function table(Table $table): Table
    {
        return $table
            ->records(fn (): Collection => DRF1::query()
                    ->join('o_d_r_f_s as odrf', 'odrf.id', '=', 'd_r_f1_s.DocEntry')
                    ->leftJoin('expenses as expense', 'expense.AcctCode', '=', 'd_r_f1_s.AcctCode')
                    ->where('odrf.UserSign', auth()->id())
                    ->whereNotNull('d_r_f1_s.AcctCode')
                    ->where('d_r_f1_s.AcctCode', '!=', '')
                    ->selectRaw('MIN(d_r_f1_s.id) as id')
                    ->selectRaw('d_r_f1_s.AcctCode as acct_code')
                    ->selectRaw("COALESCE(MAX(expense.AcctName), d_r_f1_s.AcctCode) as acct_name")
                    ->selectRaw('COUNT(DISTINCT d_r_f1_s.DocEntry) as request_count')
                    ->selectRaw('COUNT(*) as line_count')
                    ->selectRaw('SUM(d_r_f1_s.LineTotal) as total_amount')
                    ->groupBy('d_r_f1_s.AcctCode')
                    ->orderByDesc('request_count')
                    ->get())
            ->columns([
                TextColumn::make('acct_code')
                    ->label('AcctCode')
                    ->searchable(),
                TextColumn::make('acct_name')
                    ->label('Expense Item')
                    ->wrap()
                    ->searchable(),
                TextColumn::make('request_count')
                    ->label('Requests')
                    ->alignRight()
                    ->numeric(),
                TextColumn::make('line_count')
                    ->label('Lines')
                    ->alignRight()
                    ->numeric(),
                TextColumn::make('total_amount')
                    ->label('Total Amount')
                    ->alignRight()
                    ->money('KES', true),
            ])
            ->paginated([10, 25, 50]);
    }
}
