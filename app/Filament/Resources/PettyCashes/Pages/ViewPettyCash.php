<?php

namespace App\Filament\Resources\PettyCashes\Pages;

use App\Actions\ApprovalProccessActions\DetermineDocumentApprovalStatus;
use App\Actions\ApprovalProccessActions\GetExpressWayPendingApprovalAction;
use App\Actions\PettyCashDocumentAction;
use App\Filament\Resources\PettyCashes\PettyCashResource;
use App\Models\ApprovalProcess\ApprovalRequestLineModel;
use App\Models\ApprovalProcess\ApprovalRequestModel;
use App\Models\DocAttachment;
use Filament\Actions\Action;
use Filament\Notifications\Notification;
use Filament\Resources\Pages\ViewRecord;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;

class ViewPettyCash extends ViewRecord
{
    protected static string $resource = PettyCashResource::class;

    protected function getHeaderActions(): array
    {



        $expressWayApprovalRequest = (new GetExpressWayPendingApprovalAction(1001))->handle();

        $approvalRequest = collect($expressWayApprovalRequest)->firstWhere('id', $this->record->id);
        return [


            Action::make('approve')
                ->label('Approve Document')
                ->requiresConfirmation()
                ->visible($approvalRequest && $approvalRequest->WddStatus === 'W')
                ->icon('heroicon-o-check-badge')
                ->color('success')
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
                            'Remarks' => 'Approved by ',
                            'UpdateDate' => now(),
                            'Status' => 'Y',
                        ]);

                        $approvalRequest = ApprovalRequestModel::where('id', $approvalRequestLine->WddCode)->first();

                        (new DetermineDocumentApprovalStatus($approvalRequest, $approvalRequestLine))->handle();



                        (new PettyCashDocumentAction($draftDocument))->handle();
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


                        (new PettyCashDocumentAction($draftDocument))->handle();
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



    protected function mutateFormDataBeforeFill(array $data): array
    {
        $data['attachments'] = DocAttachment::where('DocEntry', $this->record->id)
            ->pluck('FilePath');

        $data['inventory_lines'] = $this->record
            ->rows()
            ->get([
                'AcctCode',
                'Dscription',
                'LineTotal',
            ])
            ->toArray();

        return $data;
    }
}
