<?php

namespace App\Filament\Resources\JournalEntryDrafts\Pages;

use App\Actions\ApprovalProccessActions\DetermineDocumentApprovalStatus;
use App\Actions\ApprovalProccessActions\DetermineJournalEntryApprovalStatus;
use App\Actions\ApprovalProccessActions\GetExpressWayPendingApprovalAction;
use App\Actions\ApprovalProccessActions\GetJournalPendingApprovalAction;
use App\Actions\PettyCashDocumentAction;
use App\Actions\PostJournalEntryDocumentAction;
use App\Actions\PrepareJournalEntryDraftData;
use App\Filament\Resources\JournalEntryDrafts\JournalEntryDraftResource;
use App\Models\ApprovalProcess\ApprovalRequestLineModel;
use App\Models\ApprovalProcess\ApprovalRequestModel;
use Filament\Actions\Action;
use Filament\Notifications\Notification;
use Filament\Resources\Pages\EditRecord;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Storage;

class EditJournalEntryDraft extends EditRecord
{
    protected static string $resource = JournalEntryDraftResource::class;

    protected array $previousAttachments = [];

    protected function getHeaderActions(): array
    {



        $expressWayApprovalRequest = (new GetJournalPendingApprovalAction(1001))->handle();

        $approvalRequest = collect($expressWayApprovalRequest)->firstWhere('id', $this->record->id);
        return [


            Action::make('sync_production')
                ->label('Post Journal Entry')
                ->requiresConfirmation()
                ->hidden(fn($record) => $record->reference_3 !== null || $record->approval_status === 'W')
                ->icon('heroicon-o-check-badge')
                ->color('primary')
                ->successRedirectUrl(
                    static::getResource()::getUrl('index')
                )
                ->action(function ($record) {

                    try {

                        (new PostJournalEntryDocumentAction($record))->handle();

                        Notification::make()
                            ->title('Posted Successfully')
                            ->success()
                            ->send();
                    } catch (\Throwable $th) {

                        Log::info($th);

                        Notification::make()
                            ->title($th->getMessage())
                            ->warning()
                            ->send();
                    }

                }),

            Action::make('approve')
                ->label('Approve Document')
                ->requiresConfirmation()
                ->visible($approvalRequest && $approvalRequest->WddStatus === 'W')
                ->icon('heroicon-o-check-badge')
                ->color('success')
                  ->successRedirectUrl(
                    static::getResource()::getUrl('index')
                )
                ->action(function ($record) {

                    DB::beginTransaction();
                    try {

                        $draftDocument = $record;
                        $approvalRequest = ApprovalRequestModel::where('DraftEntry', $record->id)->first();

                        $approvalRequestLine = ApprovalRequestLineModel::with('approvalrequest', 'approvalstage', 'authorizer')
                            ->where('WddCode', $approvalRequest->id)
                            ->where('StepCode', $approvalRequest->CurrStep)
                            ->where('UserID', Auth::user()->id)
                            ->where('Status', 'W')
                            ->first();



                        $approvalRequestLine->update([
                            'Remarks' => 'Approved by ',
                            'UpdateDate' => now(),
                            'Status' => 'Y',
                        ]);


                          $approvalRequest = ApprovalRequestModel::where('id', $approvalRequestLine->WddCode)->first();

                        (new DetermineDocumentApprovalStatus($approvalRequest, $approvalRequestLine))->handle();



                        DB::commit();
                        Notification::make()
                            ->title('Posted Successfully')
                            ->success()
                            ->send();
                    } catch (\Throwable $th) {

                        DB::rollBack();
                        Log::info($th);

                        Notification::make()
                            ->title($th->getMessage())
                            ->warning()
                            ->send();
                    }
                }),

            Action::make('reject')
                ->label('Reject Document')
                ->requiresConfirmation()
                ->visible($approvalRequest && $approvalRequest->WddStatus === 'W')
                ->icon('heroicon-o-x-mark')
                ->color('danger')
                ->action(function ($record) {

                    try {


                        $draftDocument = $record;
                        $approvalRequest = ApprovalRequestModel::where('DraftEntry', $record->id)->first();

                        $approvalRequestLine = ApprovalRequestLineModel::with('approvalrequest', 'approvalstage', 'authorizer')
                            ->where('WddCode', $approvalRequest->id)
                            ->where('StepCode', $approvalRequest->CurrStep)
                            ->where('UserID', Auth::user()->id)
                            ->where('Status', 'W')
                            ->first();


                        $approvalRequestLine->update([
                            'Remarks' => 'Rejected ',
                            'UpdateDate' => now(),
                            'Status' => 'N',
                        ]);

                        $approvalRequest = ApprovalRequestModel::where('id', $approvalRequestLine->WddCode)->first();

                        (new DetermineDocumentApprovalStatus($approvalRequest, $approvalRequestLine))->handle();



                        Notification::make()
                            ->title('Posted Successfully')
                            ->success()
                            ->send();
                    } catch (\Throwable $th) {


                        Log::info($th);

                        Notification::make()
                            ->title($th->getMessage())
                            ->warning()
                            ->send();
                    }
                }),
        ];
    }



    protected function mutateFormDataBeforeSave(array $data): array
    {
        $this->previousAttachments = $this->record->attachments ?? [];
        $data['client_id'] = $this->record->client_id;

        return app(PrepareJournalEntryDraftData::class)->handle($data);
    }

    protected function afterSave(): void
    {
        $currentAttachments = $this->record->attachments ?? [];
        $userDirectory = 'journal-entry-drafts/' . auth()->id() . '/';
        $removedAttachments = array_diff($this->previousAttachments, $currentAttachments);

        foreach ($removedAttachments as $path) {
            if (str_starts_with($path, $userDirectory)) {
                Storage::disk('local')->delete($path);
            }
        }
    }
}
