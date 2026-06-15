<?php

namespace App\Filament\Resources\ApprovalTemplates;

use App\Filament\Resources\ApprovalTemplates\Pages\CreateApprovalTemplate;
use App\Filament\Resources\ApprovalTemplates\Pages\EditApprovalTemplate;
use App\Filament\Resources\ApprovalTemplates\Pages\ListApprovalTemplates;
use App\Filament\Resources\ApprovalTemplates\Pages\ViewApprovalTemplate;
use App\Filament\Resources\ApprovalTemplates\RelationManagers\ApprovalStagesRelationManager;
use App\Filament\Resources\ApprovalTemplates\Schemas\ApprovalTemplateForm;
use App\Filament\Resources\ApprovalTemplates\Schemas\ApprovalTemplateInfolist;
use App\Filament\Resources\ApprovalTemplates\Tables\ApprovalTemplatesTable;
use App\Models\ApprovalProcess\ApprovalTemplate;
use BackedEnum;
use Filament\Resources\Resource;
use Filament\Schemas\Schema;
use Filament\Support\Icons\Heroicon;
use Filament\Tables\Table;
use UnitEnum;

class ApprovalTemplateResource extends Resource
{
    protected static ?string $model = ApprovalTemplate::class;

    protected static string|BackedEnum|null $navigationIcon = Heroicon::OutlinedRectangleStack;

    protected static string|UnitEnum|null $navigationGroup = 'Settings';

    protected static ?string $recordTitleAttribute = 'ApprovalTemplate';

    public static function form(Schema $schema): Schema
    {
        return ApprovalTemplateForm::configure($schema);
    }

    public static function infolist(Schema $schema): Schema
    {
        return ApprovalTemplateInfolist::configure($schema);
    }

    public static function table(Table $table): Table
    {
        return ApprovalTemplatesTable::configure($table);
    }

    public static function getRelations(): array
    {
        return [
            ApprovalStagesRelationManager::class
        ];
    }

    public static function getPages(): array
    {
        return [
            'index' => ListApprovalTemplates::route('/'),
            'create' => CreateApprovalTemplate::route('/create'),
            'view' => ViewApprovalTemplate::route('/{record}'),
            'edit' => EditApprovalTemplate::route('/{record}/edit'),
        ];
    }
}
