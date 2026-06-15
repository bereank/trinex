<?php

namespace App\Filament\Resources\OdrfReports;

use App\Filament\Resources\OdrfReports\Pages\ListOdrfReports;
use App\Filament\Resources\OdrfReports\Pages\OdrfExpenseItemReport;
use App\Filament\Resources\OdrfReports\Pages\OdrfMonthlyTrends;
use App\Filament\Resources\OdrfReports\Tables\OdrfReportsTable;
use App\Models\ODRF;
use BackedEnum;
use Filament\Resources\Resource;
use Filament\Support\Icons\Heroicon;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use UnitEnum;

class OdrfReportResource extends Resource
{
    protected static ?string $model = ODRF::class;

    protected static string|BackedEnum|null $navigationIcon = Heroicon::OutlinedChartBar;

    protected static ?string $navigationLabel = 'Request Reports';

    protected static ?string $modelLabel = 'Request Report';

    protected static ?string $pluralModelLabel = 'Request Reports';

    protected static string|UnitEnum|null $navigationGroup = 'Reports';

    public static function table(Table $table): Table
    {
        return OdrfReportsTable::configure($table);
    }

    public static function getRelations(): array
    {
        return [];
    }

    public static function getPages(): array
    {
        return [
            'index' => ListOdrfReports::route('/'),
            'trends' => OdrfMonthlyTrends::route('/trends'),
            'expense-items' => OdrfExpenseItemReport::route('/expense-items'),
        ];
    }

    public static function getEloquentQuery(): Builder
    {
        return parent::getEloquentQuery()
            ->where('UserSign', auth()->id())
            ->orderBy('id', 'desc');
    }
}
