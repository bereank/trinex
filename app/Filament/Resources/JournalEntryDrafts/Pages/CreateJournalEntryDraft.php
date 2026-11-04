<?php

namespace App\Filament\Resources\JournalEntryDrafts\Pages;

use App\Actions\ApprovalProccessActions\DetermineApprovalStagesAction;
use App\Actions\PettyCashDocumentAction;
use App\Actions\PrepareJournalEntryDraftData;
use App\Filament\Resources\JournalEntryDrafts\JournalEntryDraftResource;
use Filament\Notifications\Notification;
use Filament\Resources\Pages\CreateRecord;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;


class CreateJournalEntryDraft extends CreateRecord
{
    protected static string $resource = JournalEntryDraftResource::class;

    protected function mutateFormDataBeforeCreate(array $data): array
    {
    
        $data['status'] = 'draft';
        $data['currency'] = 'XAF';
        $data['exchange_rate'] = 1.000000;
        $data = app(PrepareJournalEntryDraftData::class)->handle($data);
        $data['UserSign'] = auth()->id();
     
        $data['OwnerCode'] = auth()->id();

        

        return $data;
    }

     protected function handleRecordCreation(array $data): \Illuminate\Database\Eloquent\Model
    {


        DB::beginTransaction();

        try {
            $certification = static::getModel()::create($data);

        



           //(new DetermineApprovalStagesAction($certification))->handle();

            // (new PettyCashDocumentAction($certification))->handle();
            DB::commit();

            return $certification;
        } catch (\Throwable $e) {

            Log::info('Error creating inventory: ' . $e);
            DB::rollBack();
            Notification::make()
                ->title('Error: ' . $e->getMessage())
                ->warning()
                ->send();

            $this->halt();

            return $certification;
        }
    }
}
