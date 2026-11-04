<?php

namespace App\Filament\Resources\JournalEntryDrafts\Pages;

use App\Filament\Resources\JournalEntryDrafts\JournalEntryDraftResource;
use Filament\Actions\CreateAction;
use Filament\Resources\Pages\ListRecords;

class ListJournalEntryDrafts extends ListRecords
{
    protected static string $resource = JournalEntryDraftResource::class;

    protected function getHeaderActions(): array
    {
        return [
            CreateAction::make(),
        ];
    }
}
