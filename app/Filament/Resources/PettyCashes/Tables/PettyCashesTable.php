<?php

namespace App\Filament\Resources\PettyCashes\Tables;


use Filament\Actions\Action;
use Filament\Actions\BulkActionGroup;
use Filament\Actions\EditAction;
use Filament\Actions\ViewAction;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Filters\SelectFilter;
use Filament\Tables\Table;
use Illuminate\Support\Facades\Blade;
use Illuminate\Support\HtmlString;

class PettyCashesTable
{
    public static function configure(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('ReqName')->label('Requester'),
                TextColumn::make('DocTotal')
                    ->label('Total')
                    ->alignRight()
                    ->money('KES', true),
                TextColumn::make('DocDate')
                    ->label('Date'),
                TextColumn::make('Comments')
                    ->wrap()
                    ->limit(50) // truncate to 50 characters
                    ->tooltip(fn($record) => $record->Comments)
                    ->label('Remarks'),
                TextColumn::make('ExtRefDocNum')->label('SAP Doc #'),

                TextColumn::make('WddStatus')
                    ->label('Status')
                    ->badge()
                    ->icon(fn(string $state): string => match ($state) {
                        'N' => 'heroicon-m-x-mark',
                        'Y' => 'heroicon-m-check',
                        'W' => 'heroicon-m-clock',
                    })
                    ->formatStateUsing(fn(string $state): mixed => match ($state) {
                        'N' => 'Rjected',
                        'Y' => 'Approved',
                        'W' => 'Pending',
                    })
                    ->color(fn(string $state): string => match ($state) {
                        'N' => 'danger',
                        'Y' => 'success',
                        'W' => 'primary',
                    })

            ])
            ->defaultSort('DocDate', 'desc')
            ->filters([
                SelectFilter::make('WddStatus')
                    ->label('Status')
                    ->options([
                        'Y' => 'Approved',
                        'N' => 'Rejected',
                        'W' => 'Pending',
                    ]),
            ])
            ->recordActions([
                Action::make('view_related')
                    ->label('Approval Report')
                    ->icon('heroicon-o-list-bullet')
                    ->modalHeading('Approval Report')

                    ->modalContent(fn($record) => new HtmlString(
                        Blade::render('@livewire(\App\Livewire\ApprovalReport::class, ["ownerRecord" => $record])', [
                            'record' => $record
                        ])
                    ))
                    ->modalSubmitAction(false)
                    ->slideOver(false),
                ViewAction::make(),
                EditAction::make()->visible(fn($record) => empty($record->ExtRefDocNum)),
            ])
            ->toolbarActions([
                BulkActionGroup::make([]),
            ]);
    }
}
