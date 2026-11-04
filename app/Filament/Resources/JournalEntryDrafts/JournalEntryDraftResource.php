<?php

namespace App\Filament\Resources\JournalEntryDrafts;

use App\Filament\Resources\JournalEntryDrafts\Pages\CreateJournalEntryDraft;
use App\Filament\Resources\JournalEntryDrafts\Pages\EditJournalEntryDraft;
use App\Filament\Resources\JournalEntryDrafts\Pages\ListJournalEntryDrafts;
use App\Filament\Resources\JournalEntryDrafts\Schemas\JournalEntryDraftForm;
use App\Filament\Resources\JournalEntryDrafts\Tables\JournalEntryDraftsTable;
use App\Models\JournalEntryDraft;
use App\Models\UserDatabase;
use BackedEnum;
use Filament\Resources\Resource;
use Filament\Schemas\Schema;
use Filament\Support\Icons\Heroicon;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use UnitEnum;

class JournalEntryDraftResource extends Resource
{
    protected static ?string $model = JournalEntryDraft::class;

    protected static string|BackedEnum|null $navigationIcon = Heroicon::OutlinedBookOpen;

    protected static ?string $navigationLabel = 'Journal Entries';

    protected static ?string $modelLabel = 'Journal Entry Draft';

    protected static string|UnitEnum|null $navigationGroup = 'Requests';

    public static function form(Schema $schema): Schema
    {
        return JournalEntryDraftForm::configure($schema);
    }

    public static function table(Table $table): Table
    {
        return JournalEntryDraftsTable::configure($table);
    }

    public static function getRelations(): array
    {
        return [
            //
        ];
    }

    public static function getPages(): array
    {
        return [
            'index' => ListJournalEntryDrafts::route('/'),
            'create' => CreateJournalEntryDraft::route('/create'),
            'edit' => EditJournalEntryDraft::route('/{record}/edit'),
        ];
    }

    public static function getEloquentQuery(): Builder
    {
        return parent::getEloquentQuery()
            ->where('UserSign', auth()->id());
    }
}
