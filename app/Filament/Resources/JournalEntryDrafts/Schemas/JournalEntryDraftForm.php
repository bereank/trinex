<?php

namespace App\Filament\Resources\JournalEntryDrafts\Schemas;

use App\Models\ChartOfAccount;
use App\Models\JournalEntryDraft as JournalEntryDraftModel;
use App\Models\UserDatabase;
use Filament\Actions\Action;
use Filament\Forms\Components\DatePicker;
use Filament\Forms\Components\FileUpload;
use Filament\Forms\Components\Placeholder;
use Filament\Forms\Components\Repeater;
use Filament\Forms\Components\Repeater\TableColumn;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\TextInput;
use Filament\Schemas\Components\Section;
use Filament\Schemas\Components\Tabs;
use Filament\Schemas\Components\Tabs\Tab;
use Filament\Schemas\Components\Utilities\Get;
use Filament\Schemas\Components\Utilities\Set;
use Filament\Schemas\Schema;
use Illuminate\Database\Eloquent\Builder;

class JournalEntryDraftForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                Section::make('Journal Entry Header')
                    ->schema([
                
                        TextInput::make('reference_1')->label('Reference 1')->maxLength(100),
               
                        TextInput::make('reference_2')->label('Reference 2')->maxLength(100),
                        TextInput::make('series')->label('Series')->required()->maxLength(100)->default('Primary'),
                        TextInput::make('reference_3')->label('Reference 3')->maxLength(100),
                        // TextInput::make('currency')->label('Currency')->required()->maxLength(10)->default('XAF'),
                        // TextInput::make('exchange_rate')
                        //     ->label('Exchange Rate')
                        //     ->numeric()
                        //     ->minValue(0.000001)
                        //     ->step(0.000001)
                        //     ->default('1.000000')
                        //     ->required(),
                    
                        DatePicker::make('posting_date')->label('Posting Date')->required()->default(now()),
                        DatePicker::make('due_date')->label('Due Date'),
                        DatePicker::make('document_date')->label('Document Date')->required()->default(now()),
                    ])
                    ->columns(4)
                    ->columnSpanFull(),
                Tabs::make('Journal Entry Details')
                    ->tabs([
                        Tab::make('Contents')
                            ->schema([
                                Repeater::make('lines')
                                    ->label('Journal Entry Lines')
                                    ->table([
                                        TableColumn::make('G/L / BP Code'),
                                        TableColumn::make('G/L / BP Name'),
                                        TableColumn::make('Debit'),
                                        TableColumn::make('Credit'),
                                        TableColumn::make('Debit FC'),
                                        TableColumn::make('Credit FC'),
                                        TableColumn::make('Cost Code 1'),
                                        TableColumn::make('Cost Code 2'),
                                        TableColumn::make('Cost Code 3'),
                                    ])
                                    ->schema([
                                        TextInput::make('account_code')
                                            ->label('G/L / BP Code')
                                            ->readOnly()
                                            ->suffixAction(
                                                Action::make('browseChartOfAccounts')
                                                    ->label('Browse chart of accounts')
                                                    ->icon('heroicon-o-magnifying-glass')
                                                    ->modalHeading('Select G/L / BP Code')
                                                    ->modalDescription('Search by account code or name, then select an account.')
                                                    ->modalSubmitActionLabel('Select account')
                                                    ->schema([
                                                        Select::make('account_code')
                                                            ->label('Account')
                                                            ->searchable()
                                                            ->getSearchResultsUsing(fn (string $search): array => static::accountQuery()
                                                                ->where(function (Builder $query) use ($search): void {
                                                                    $query->where('AcctCode', 'like', "%{$search}%")
                                                                        ->orWhere('AcctName', 'like', "%{$search}%");
                                                                })
                                                                ->orderBy('AcctCode')
                                                                ->limit(50)
                                                                ->get(['AcctCode', 'AcctName'])
                                                                ->mapWithKeys(fn (object $account): array => [
                                                                    data_get($account, 'AcctCode') => data_get($account, 'AcctCode').' — '.data_get($account, 'AcctName'),
                                                                ])
                                                                ->all())
                                                            ->getOptionLabelUsing(fn ($value): ?string => static::accountQuery()
                                                                ->where('AcctCode', $value)
                                                                ->value('AcctCode'))
                                                            ->placeholder('Search accounts...')
                                                            ->required(),
                                                    ])
                                                    ->action(function (array $data, Set $set): void {
                                                        $account = static::accountQuery()
                                                            ->where('AcctCode', $data['account_code'])
                                                            ->firstOrFail();

                                                        $set('account_code', $account->getAttribute('AcctCode'));
                                                        $set('account_name', $account->getAttribute('AcctName'));
                                                    })
                                            )
                                            ->live()
                                            ->afterStateUpdated(function (?string $state, Set $set): void {
                                                $set('account_name', $state === null
                                                    ? null
                                                    : static::accountQuery()->where('AcctCode', $state)->value('AcctName'));
                                            })
                                            ->required(),
                                        TextInput::make('account_name')
                                            ->label('G/L / BP Name')
                                            ->readOnly()
                                            ->required()
                                            ->maxLength(200),
                                        TextInput::make('debit')->numeric()->minValue(0)->step(0.01)->default('0.00')->required(),
                                        TextInput::make('credit')->numeric()->minValue(0)->step(0.01)->default('0.00')->required(),
                                        TextInput::make('debit_fc')->label('Debit FC')->numeric()->minValue(0)->step(0.01)->default('0.00'),
                                        TextInput::make('credit_fc')->label('Credit FC')->numeric()->minValue(0)->step(0.01)->default('0.00'),
                                        TextInput::make('cost_code_1')->label('Cost Code 1')->maxLength(50),
                                        TextInput::make('cost_code_2')->label('Cost Code 2')->maxLength(50),
                                        TextInput::make('cost_code_3')->label('Cost Code 3')->maxLength(50),
                                    ])
                                    ->defaultItems(2)
                                    ->minItems(2)
                                    ->maxItems(100)
                                    ->addActionLabel('Add Row')
                                    ->reorderable(false)
                                    ->columnSpanFull(),
                         
                            ])
                            ->columns(2),
                        Tab::make('Remarks')
                            ->schema([
                                Textarea::make('remarks')
                                    ->label('Journal Remarks')
                                    ->maxLength(1000)
                                    ->rows(5)
                                    ->columnSpanFull(),
                            ]),
                        Tab::make('Attachments')
                            ->schema([
                                FileUpload::make('attachments')
                                    ->label('Attachments')
                                    ->multiple()
                                    ->disk('local')
                                    ->directory(fn (): string => 'journal-entry-drafts/'.auth()->id())
                                    ->visibility('private')
                                    ->downloadable()
                                    ->maxSize(10240)
                                    ->maxFiles(10)
                                    ->acceptedFileTypes([
                                        'application/pdf',
                                        'image/jpeg',
                                        'image/png',
                                        'application/msword',
                                        'application/vnd.openxmlformats-officedocument.wordprocessingml.document',
                                        'application/vnd.ms-excel',
                                        'application/vnd.openxmlformats-officedocument.spreadsheetml.sheet',
                                    ]),
                            ]),
                    ])
                    ->columnSpanFull(),
            ]);
    }

    /**
     * @return Builder<ChartOfAccount>
     */
    private static function accountQuery(): Builder
    {
        return ChartOfAccount::query()->whereNotNull('AcctCode');
    }
}
