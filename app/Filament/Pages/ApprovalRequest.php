<?php

namespace App\Filament\Pages;

use App\Actions\ApprovalProccessActions\GetExpressWayPendingApprovalAction;
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


class ApprovalRequest extends Page implements HasTable
{

    use InteractsWithTable;
    protected string $view = 'filament.pages.approval-request';

    protected static string|UnitEnum|null $navigationGroup = 'Approvals';

    protected static string|BackedEnum|null $navigationIcon = Heroicon::OutlinedRectangleStack;

    public Collection $data;

    public function mount()
    {

        $expressWayApprovalRequest = (new GetExpressWayPendingApprovalAction(1001))->handle();
        $this->data = $expressWayApprovalRequest;
    }

    public function table(Table $table): Table
    {
        return $table
            ->records(fn(): Collection => collect($this->data))
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
                    ->url(fn($record) => PettyCashResource::getUrl(name: 'view', parameters: ['record' => $record->id]))
                    ->openUrlInNewTab(),


            ]);
    }
}
