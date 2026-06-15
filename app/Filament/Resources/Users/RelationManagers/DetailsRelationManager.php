<?php

namespace App\Filament\Resources\Users\RelationManagers;

use App\Models\ApprovalProcess\ApprovalTemplate;
use App\Models\HouseSetter;
use Filament\Actions\DeleteAction;
use Filament\Actions\EditAction;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Resources\RelationManagers\RelationManager;
use Filament\Schemas\Schema;
use Filament\Tables\Columns\SelectColumn;
use Filament\Tables\Columns\Summarizers\Sum;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;

class DetailsRelationManager extends RelationManager
{
    protected static string $relationship = 'databases';

    public function form(Schema $schema): Schema
    {
        return $schema
            ->components([])->columns(6);
    }

    public function table(Table $table): Table
    {
        return $table
            ->recordTitleAttribute('title')
            ->columns([


                TextColumn::make('dbdetails.db_name')
                    ->label('Database Name')
                    ->searchable(),

                SelectColumn::make('default_template_id')
                    ->label('Default Approval Template')
                    ->searchable()
                    ->options(
                        ApprovalTemplate::query()

                            ->pluck('Name', 'id')
                    )
                    ->searchable(),
                TextColumn::make('created_at')
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
                TextColumn::make('updated_at')
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
            ])
            ->defaultPaginationPageOption(200)
            ->filters([
                //
            ])
            ->headerActions([])
            ->recordActions([])
            ->toolbarActions([]);
    }
}
