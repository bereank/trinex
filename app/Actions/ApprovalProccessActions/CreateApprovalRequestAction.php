<?php

namespace App\Actions\ApprovalProccessActions;

use App\Models\ApprovalProcess\ApprovalRequestLineModel;
use App\Models\ApprovalProcess\ApprovalRequestModel;
use App\Models\ApprovalProcess\ApprovalStage;
use App\Models\ApprovalProcess\ApprovalTemplate;
use App\Models\ChartOfAccount;
use App\Models\JournalEntryDraft;
use App\Models\ODRF;
use Illuminate\Support\Collection;

class CreateApprovalRequestAction
{
    public function __construct(protected ODRF|JournalEntryDraft $draftDocument, protected ApprovalTemplate $approvalTemplate, protected Collection $approvalStageApprovers)
    {

        $this->draftDocument = $draftDocument;
        $this->approvalTemplate = $approvalTemplate;
        $this->approvalStageApprovers = $approvalStageApprovers;
    }

    public function handle()
    {

        $createdApprovalRequestModel = ApprovalRequestModel::create([
            'WtmCode' => $this->approvalTemplate->WtmCode,
            'OwnerID' => $this->draftDocument->OwnerCode,
            'DraftType' => $this->draftDocument->DraftType,
            'DraftEntry' => $this->draftDocument->id,
            'ObjType' => $this->draftDocument->ObjType,
            'client_id' => $this->draftDocument->client_id,
            'DocDate' => $this->draftDocument->DocDate,
            // 'DocEntry' => $approvalRequestData->DocEntry,
            // 'CurrStep' => $approvalRequestData->CurrStep,
            'Status' => 'W',
            'ProcesStat' => 'W',
            'Remarks' => $this->draftDocument->Comments,
            'UserSign' => $this->draftDocument->UserSign,
            // 'CreateDate' => $approvalRequestData->CreateDate,
            // 'CreateTime' => $approvalRequestData->NormalTime,
            // 'IsDraft' => $approvalRequestData->IsDraft,
            // 'MaxReqr' => $approvalRequestData->MaxReqr,
            // 'MaxRejReqr' => $approvalRequestData->MaxRejReqr,
            // 'ProcesStat' => $approvalRequestData->ProcesStat,
            // 'StpUpdated' => $approvalRequestData->StpUpdated,

        ]);

        $this->approvalStageApprovers->each(function (ApprovalStage $approvalstage, int $key) use ($createdApprovalRequestModel) {

            if ($key == 0) {
                $createdApprovalRequestModel->update([
                    'CurrStep' => $approvalstage->id,
                    'MaxReqr' => $approvalstage->MaxReqr,
                    'MaxRejReqr' => $approvalstage->MaxRejReqr,
                ]);
            }
            foreach ($approvalstage->approvers as $keyVal => $approverStageApprover) {
                ApprovalRequestLineModel::create([
                    'client_id' => $this->draftDocument->client_id,
                    'WddCode' => $createdApprovalRequestModel->id,
                    'StepCode' => $approverStageApprover->approval_stage_id,
                    'UserID' => $approverStageApprover->user_id,
                    'Status' => 'W',
                    'SortId' => $key + 1,
                    'UserSign' => $this->draftDocument->UserSign,
                ]);
            }
        });
    }
}
