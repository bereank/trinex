<?php

namespace App\Filament\Resources\OdrfReports\Tables;

use App\Models\ODRF;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Filters\SelectFilter;
use Filament\Tables\Table;

class OdrfReportsTable
{
    public static function configure(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('ReqName')
                    ->label('Requester')
                    ->searchable(),
                TextColumn::make('Branch')
                    ->searchable(),
                TextColumn::make('DocDate')
                    ->label('Date')
                    ->date(),
                TextColumn::make('DocTotal')
                    ->label('Total')
                    ->money('KES', true)
                    ->alignRight(),
                TextColumn::make('WddStatus')
                    ->label('Status')
                    ->badge()
                    ->formatStateUsing(fn (string $state): string => match ($state) {
                        'Y' => 'Approved',
                        'N' => 'Rejected',
                        'W' => 'Pending',
                        default => 'Unknown',
                    })
                    ->color(fn (string $state): string => match ($state) {
                        'Y' => 'success',
                        'N' => 'danger',
                        'W' => 'warning',
                        default => 'gray',
                    }),
            ])
            ->defaultSort('DocDate', 'desc')
            ->filters([
                SelectFilter::make('ReqName')
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
                SelectFilter::make('WddStatus')
                    ->label('Status')
                    ->options([
                        'Y' => 'Approved',
                        'N' => 'Rejected',
                        'W' => 'Pending',
                    ]),
            ]);
    }
}
