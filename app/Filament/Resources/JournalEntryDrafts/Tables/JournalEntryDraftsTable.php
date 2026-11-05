<?php

namespace App\Filament\Resources\JournalEntryDrafts\Tables;

use Filament\Actions\Action;
use Filament\Actions\EditAction;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;
use Illuminate\Support\Facades\Blade;
use Illuminate\Support\HtmlString;

class JournalEntryDraftsTable
{
    public static function configure(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('id')
                    ->label('Draft No.')
                    ->formatStateUsing(fn (int $state): string => 'JE-DRAFT-'.$state)
                    ->sortable(),
                TextColumn::make('posting_date')->date()->sortable(),
                TextColumn::make('reference_1')->label('Reference 1')->placeholder('—'),
                TextColumn::make('currency'),
                TextColumn::make('debit_total')
                    ->label('Debit')
                    ->state(fn ($record): float => collect($record->lines)
                        ->sum(fn (array $line): float => (float) ($line['debit'] ?? 0)))
                    ->numeric(decimalPlaces: 2),
                TextColumn::make('credit_total')
                    ->label('Credit')
                    ->state(fn ($record): float => collect($record->lines)
                        ->sum(fn (array $line): float => (float) ($line['credit'] ?? 0)))
                    ->numeric(decimalPlaces: 2),

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
                    }),
                    
                       TextColumn::make('reference_3')

                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),

       
            ])
            ->defaultSort('id', 'desc')
            ->recordActions([
                EditAction::make()->visible(fn($record) => !$record->reference_3),

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
            ]);
    }
}
