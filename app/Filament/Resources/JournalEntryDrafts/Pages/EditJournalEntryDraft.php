<?php

namespace App\Filament\Resources\JournalEntryDrafts\Pages;

use App\Actions\PrepareJournalEntryDraftData;
use App\Filament\Resources\JournalEntryDrafts\JournalEntryDraftResource;
use Filament\Resources\Pages\EditRecord;
use Illuminate\Support\Facades\Storage;

class EditJournalEntryDraft extends EditRecord
{
    protected static string $resource = JournalEntryDraftResource::class;

    protected array $previousAttachments = [];

    protected function mutateFormDataBeforeSave(array $data): array
    {
        $this->previousAttachments = $this->record->attachments ?? [];
        $data['client_id'] = $this->record->client_id;

        return app(PrepareJournalEntryDraftData::class)->handle($data);
    }

    protected function afterSave(): void
    {
        $currentAttachments = $this->record->attachments ?? [];
        $userDirectory = 'journal-entry-drafts/'.auth()->id().'/';
        $removedAttachments = array_diff($this->previousAttachments, $currentAttachments);

        foreach ($removedAttachments as $path) {
            if (str_starts_with($path, $userDirectory)) {
                Storage::disk('local')->delete($path);
            }
        }
    }
}
