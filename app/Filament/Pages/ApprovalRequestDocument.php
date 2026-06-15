<?php

namespace App\Filament\Pages;


use App\Models\Expense;
use App\Models\ODRF;
use Filament\Forms\Components\DatePicker;
use Filament\Forms\Components\Repeater;
use Filament\Forms\Components\Repeater\TableColumn;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Pages\Page;
use Filament\Schemas\Concerns\InteractsWithSchemas;
use Filament\Schemas\Contracts\HasSchemas;
use Filament\Schemas\Schema;


class ApprovalRequestDocument extends Page implements HasSchemas
{

    use InteractsWithSchemas;

    protected string $view = 'filament.pages.approval-request-document';

    public ?array $data = [];
    public $record;

    protected static bool $shouldRegisterNavigation = false;

    public function mount()
    {

        $record = request()->query('id');


        $this->record = ODRF::findOrFail($record);

        // Pre-fill form data
        $this->data = [
            'ReqName' => $this->record->ReqName ?? auth()->user()?->name,
            'DocDate' => $this->record->DocDate ?? now()->format('Y-m-d'),
            'Comments' => $this->record->Comments ?? '',
            'inventory_lines' => $this->record->rows()
                ->get(['AcctCode', 'Dscription', 'LineTotal'])
                ->map(fn($row) => [
                    'AcctCode' => $row->AcctCode,
                    'Dscription' => $row->Dscription,
                    'LineTotal' => $row->LineTotal,
                ])->toArray(),
        ];
    }

    public function form(): Schema
    {
        return Schema::make()
            ->statePath('data')
            ->schema([
                TextInput::make('ReqName')
                    ->label('Requester')
                    ->readOnly()
                    ->default(fn($operation) => $operation === 'create' ? auth()->user()?->name : null)
                    // ->visibleOn('create')
                    ->required(),


                DatePicker::make('DocDate')
                    ->label('Date')
                    ->default(now())
                    ->maxDate(now())
                    ->required(),

                TextInput::make('Comments')
                    ->label('Remarks')
                    ->required(),

                Repeater::make('inventory_lines')
                    ->table([
                        TableColumn::make('Item'),
                        TableColumn::make('Description'),
                        TableColumn::make('Amount'),

                    ])
                    ->addActionLabel('Add New Line')
                    ->cloneable()
                    ->schema([
                        Select::make('AcctCode')
                            ->label('Item')
                            ->required()
                            ->preload()
                            ->options(
                                Expense::query()
                                    ->get()
                                    ->mapWithKeys(fn($item) => [
                                        $item->AcctCode => " {$item->AcctName}",
                                    ])
                            )
                            ->searchable(),
                        TextInput::make('Dscription')
                            ->required()
                            ->label('Description'),

                        TextInput::make('LineTotal')
                            ->numeric()
                            ->default(0)
                            ->label('amount'),


                    ])
                    ->compact()
                    ->columnSpanFull()
                    ->columns(2),
            ]);
    }
}
