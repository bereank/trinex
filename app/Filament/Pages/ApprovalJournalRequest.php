<?php

namespace App\Filament\Pages;

use App\Actions\ApprovalProccessActions\GetExpressWayPendingApprovalAction;
use App\Actions\ApprovalProccessActions\GetJournalPendingApprovalAction;
use App\Filament\Resources\JournalEntryDrafts\JournalEntryDraftResource;
use App\Filament\Resources\PettyCashes\PettyCashResource;
use BackedEnum;
use Filament\Actions\Action;
use Filament\Pages\Page;
use Filament\Support\Icons\Heroicon;
use Filament\Tables;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Concerns\InteractsWithTable;
use Filament\Tables\Contracts\HasTable;
use Filament\Tables\Table;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Blade;
use Illuminate\Support\HtmlString;
use UnitEnum;


class ApprovalJournalRequest extends Page implements HasTable
{

    use InteractsWithTable;
    protected string $view = 'filament.pages.approval-journal-request';

    protected static string|UnitEnum|null $navigationGroup = 'Approvals';

    protected static string|BackedEnum|null $navigationIcon = Heroicon::OutlinedRectangleStack;

    public Collection $data;

    public function mount()
    {

        $journalApprovalRequest = (new GetJournalPendingApprovalAction(1001))->handle();
        $this->data = $journalApprovalRequest;
    }

    public function table(Table $table): Table
    {
        return $table
            ->records(fn(): Collection => collect($this->data))
            ->columns([
                TextColumn::make('createdby.name')->label('Requester'),
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
                    })

            ])->recordActions([
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

                Action::make('approvalRequest')
                    ->label('Approval')
                    ->icon('heroicon-o-check-circle')
                    ->url(fn($record) => JournalEntryDraftResource::getUrl(name: 'edit', parameters: ['record' => $record->id]))
                    ->openUrlInNewTab(),


            ]);
    }
}
