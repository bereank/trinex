<?php

namespace App\Filament\Widgets;

use Filament\Actions\BulkActionGroup;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;
use Filament\Widgets\TableWidget;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Collection;

class PettyCashDashboardOverview extends TableWidget
{


    public $data = [];

    protected static ?int $sort = 3;


    public function mount(): void
    {

        $this->data = [
            ['id' => 1, 'name' => 'Total Requests', 'amount' => 80],
            ['id' => 2, 'name' => 'Total Approved', 'amount' => 500],
            ['id' => 3, 'name' => 'Total Rejected', 'amount' => 200],
            ['id' => 4, 'name' => 'Total Pending', 'amount' => 10],
        ];
    }
    public function table(Table $table): Table
    {
        return $table
            ->records(fn(): Collection => collect($this->data)) // your array as collection
            ->columns([

                TextColumn::make('name')->label('Title'),
                TextColumn::make('amount')
                    ->numeric()
                    ->label('Count'),
            ])
            ->filters([
                //
            ])
            ->headerActions([
                //
            ])
            ->recordActions([
                //
            ])
            ->toolbarActions([
                BulkActionGroup::make([
                    //
                ]),
            ]);
    }
}
