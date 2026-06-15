<?php

namespace App\Filament\Resources\ApprovalStages\RelationManagers;


use Filament\Actions\CreateAction;
use Filament\Actions\DeleteAction;
use Filament\Forms\Components\Select;
use Filament\Resources\RelationManagers\RelationManager;
use Filament\Schemas\Schema;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;

class ApproversRelationManager extends RelationManager
{
    protected static string $relationship = 'approvers';

    public function form(Schema $schema): Schema
    {
        return $schema
            ->components([
                Select::make('user_id')
                    ->label('Approver')
                    ->relationship('user', 'name')
                    ->searchable()
                    ->preload()
                    ->required(),
            ])
            ->columns(6);
    }

    public function table(Table $table): Table
    {
        return $table
            ->recordTitleAttribute('title')
            ->columns([

                TextColumn::make('user.name')
                    ->label('Approver'),

            ])
            ->defaultPaginationPageOption(200)
            ->filters([
                //
            ])
            ->headerActions([
                CreateAction::make(),

            ])
            ->recordActions([
                DeleteAction::make(),
            ])
            ->toolbarActions([]);
    }
}
