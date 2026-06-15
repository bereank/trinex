<?php

namespace App\Filament\Resources\ApprovalTemplates\Schemas;


use Filament\Forms\Components\TextInput;
use Filament\Schemas\Schema;

class ApprovalTemplateForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                TextInput::make('Name')
                    ->label('Name')
                    ->required(),
                TextInput::make('Remarks')
                    ->label('Remarks')
                    ->required(),
            ]);
    }
}
