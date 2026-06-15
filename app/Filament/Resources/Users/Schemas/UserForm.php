<?php

namespace App\Filament\Resources\Users\Schemas;

use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Toggle;
use Filament\Schemas\Schema;

class UserForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                TextInput::make('name')
                    ->readOnly()
                    ->required(),

                TextInput::make('email')
                    ->readOnly()
                    ->required(),
                TextInput::make('ExtUserCode')
                    ->label('SAP User Name')
                    ->required(),

                TextInput::make('SapPassword')
                    ->password()
                    ->label('SAP Password')
                    ->required(),

                Select::make('branches')
                    ->required()
                    ->preload()

                    ->searchable()
                    ->options([
                        'JOGOO ROAD' => 'Jogoo Road',
                        'GARDEN ESTATE' => 'Garden Estate',
                        'NAIROBI WEST' => 'Nairobi West',
                        'DAGORETTI' => 'Dagoretti',
                        'MLOLONGO' => 'Mlolongo',
                    ]),

                Select::make('modules')
                    ->required()
                    ->multiple()
                    ->preload()
                    ->searchable()
                    ->options([
                        'PETTY CASH' => 'Petty Cash',
                        'SERVICE CENTERS' => 'Service Centers',
                        'DAILY MAINS SUMMARY' => 'Daily Mains',
                    ]),

                Toggle::make('UserType')
                    ->label('Is Admin')
                    ->required(),
            ])->columns(3);
    }
}
