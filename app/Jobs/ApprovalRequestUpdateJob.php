<?php

namespace App\Jobs;

use App\Models\DTO\ApprovalRequestDTO;
use App\Models\OWDD;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Log;

class ApprovalRequestUpdateJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    public $approvalRequests;

    public $client_id;

    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct(int $client_id, $approvalRequests)
    {
        $this->approvalRequests = $approvalRequests;
        $this->client_id = $client_id;
    }

    /**s
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        foreach ($this->approvalRequests as $key => $value) {
            if (!$value['DraftEntry']) {
                Log::info("===============================================================");
                Log::info("WDD CODE: " . $value['WddCode']);
                Log::info("Draft Entry Empty");
                Log::info("===============================================================");
                continue;
            }
            $approvalRequestData = ApprovalRequestDTO::from($value);
            $newOwdd = OWDD::updateOrCreate([
                'WddCode' => $approvalRequestData->WddCode,
                'WtmCode' => $approvalRequestData->WtmCode,
                'OwnerID' => $approvalRequestData->OwnerID,
                'DraftType' => $approvalRequestData->DraftType,
                'DraftEntry' => $approvalRequestData->DraftEntry,
                'ObjType' => $approvalRequestData->ObjType,
                'client_id' => $this->client_id,
            ], [
                'DocDate' => $approvalRequestData->DocDate,
                'DocEntry' => $approvalRequestData->DocEntry,
                'CurrStep' => $approvalRequestData->CurrStep,
                'Status' => $approvalRequestData->Status,
                'Remarks' => $approvalRequestData->Remarks,
                'UserSign' => $approvalRequestData->UserSign,
                'CreateDate' => $approvalRequestData->CreateDate,
                'CreateTime' => $approvalRequestData->NormalTime,
                'IsDraft' => $approvalRequestData->IsDraft,
                'MaxReqr' => $approvalRequestData->MaxReqr,
                'MaxRejReqr' => $approvalRequestData->MaxRejReqr,
                'SrcDocEnt' => $approvalRequestData->SrcDocEnt,
                'BFType' => $approvalRequestData->BFType,
                'ProcessID' => $approvalRequestData->ProcessID,
                'ProcesStat' => $approvalRequestData->ProcesStat,
                'StpUpdated' => $approvalRequestData->StpUpdated,
            ]);
        }
    }
}
