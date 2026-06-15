<?php

namespace App\Filament\Resources\PettyCashes\Schemas;

use App\Models\Expense;
use Filament\Forms\Components\DatePicker;
use Filament\Forms\Components\FileUpload;
use Filament\Forms\Components\Repeater;
use Filament\Forms\Components\Repeater\TableColumn;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Schemas\Components\Section;
use Filament\Schemas\Schema;

class PettyCashForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([

                Section::make('Header Information')

                    ->schema([
                        TextInput::make('ReqName')
                            ->label('Requester')
                            ->readOnly()
                            ->default(fn($operation) => $operation === 'create' ? auth()->user()?->name : null)
                            // ->visibleOn('create')
                            ->required(),

                        TextInput::make('Branch')
                            ->label('Branch')
                            ->readOnly()
                            ->default(fn($operation) => $operation === 'create' ? auth()->user()?->branches : null)
                            // ->visibleOn('create')
                            ->required(),


                        DatePicker::make('DocDate')
                            ->label('Date')
                            ->default(now())
                            ->maxDate(now())
                            ->required(),

                        TextInput::make('Comments')
                            ->label('Purpose')
                            ->required(),

                        FileUpload::make('attachments')
                            ->pasteable(false)
                            ->preserveFilenames()
                            ->downloadable()
                            ->multiple()

                            ->directory('expresswayfiles')
                            ->visibility('public'),
                    ])->columns(4)->columnSpanFull(),

                Section::make('Line Information')

                    ->schema([

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
                    ])->columnSpanFull()->columns(3),
            ]);
    }
}
