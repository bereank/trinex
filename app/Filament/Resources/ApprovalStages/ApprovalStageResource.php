<?php

namespace App\Filament\Resources\ApprovalStages;

use App\Filament\Resources\ApprovalStages\Pages\CreateApprovalStage;
use App\Filament\Resources\ApprovalStages\Pages\EditApprovalStage;
use App\Filament\Resources\ApprovalStages\Pages\ListApprovalStages;
use App\Filament\Resources\ApprovalStages\Pages\ViewApprovalStage;
use App\Filament\Resources\ApprovalStages\RelationManagers\ApproversRelationManager;
use App\Filament\Resources\ApprovalStages\Schemas\ApprovalStageForm;
use App\Filament\Resources\ApprovalStages\Schemas\ApprovalStageInfolist;
use App\Filament\Resources\ApprovalStages\Tables\ApprovalStagesTable;
use App\Models\ApprovalProcess\ApprovalStage;
use BackedEnum;
use Filament\Resources\Resource;
use Filament\Schemas\Schema;
use Filament\Support\Icons\Heroicon;
use Filament\Tables\Table;
use UnitEnum;

class ApprovalStageResource extends Resource
{
    protected static ?string $model = ApprovalStage::class;

    protected static string|BackedEnum|null $navigationIcon = Heroicon::OutlinedRectangleStack;

    protected static ?string $recordTitleAttribute = 'ApprovalStage';

    protected static string|UnitEnum|null $navigationGroup = 'Settings';

    public static function form(Schema $schema): Schema
    {
        return ApprovalStageForm::configure($schema);
    }

    public static function infolist(Schema $schema): Schema
    {
        return ApprovalStageInfolist::configure($schema);
    }

    public static function table(Table $table): Table
    {
        return ApprovalStagesTable::configure($table);
    }

    public static function getRelations(): array
    {
        return [
            ApproversRelationManager::class
        ];
    }

    public static function getPages(): array
    {
        return [
            'index' => ListApprovalStages::route('/'),
            'create' => CreateApprovalStage::route('/create'),
            'view' => ViewApprovalStage::route('/{record}'),
            'edit' => EditApprovalStage::route('/{record}/edit'),
        ];
    }
}
