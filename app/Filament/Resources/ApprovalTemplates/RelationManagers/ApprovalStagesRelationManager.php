<?php

namespace App\Filament\Resources\ApprovalTemplates\RelationManagers;


use App\Models\ApprovalProcess\ApprovalStage;
use Filament\Actions\CreateAction;
use Filament\Actions\DeleteAction;
use Filament\Forms\Components\Select;
use Filament\Resources\RelationManagers\RelationManager;
use Filament\Schemas\Schema;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;

class ApprovalStagesRelationManager extends RelationManager
{
    protected static string $relationship = 'templatesstages';

    public function form(Schema $schema): Schema
    {
        return $schema
            ->components([
                Select::make('approval_stage_id')
                    ->label('Approval Stage')
                    ->options(
                        ApprovalStage::query()
                            ->pluck('name', 'id')
                    )
                    ->searchable()
                    ->preload()
                    ->required()
            ]);
    }

    public function table(Table $table): Table
    {
        return $table
            ->recordTitleAttribute('title')
            ->columns([

                TextColumn::make('approvalstage.Name')
                    ->label('Approval Stage'),

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
