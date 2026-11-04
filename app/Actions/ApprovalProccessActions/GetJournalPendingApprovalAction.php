<?php

namespace App\Actions\ApprovalProccessActions;

use App\Models\ApprovalProcess\ApprovalRequestLineModel;
use App\Models\ApprovalProcess\ApprovalRequestModel;
use App\Models\JournalEntryDraft;
use App\Models\ODRF;
use Illuminate\Support\Facades\Auth;

class GetJournalPendingApprovalAction
{
    public function __construct(protected int $clientId)
    {
        $this->clientId = $clientId;
    }

    public function handle()
    {

        $approvalLineRequests = ApprovalRequestLineModel::where('Status', 'W')->where('UserID', Auth::user()->id)->where('client_id', $this->clientId)->distinct()->pluck('StepCode');


        $approvalLineRequestsWddCode = ApprovalRequestLineModel::where('Status', 'W')->where('UserID', Auth::user()->id)->where('client_id', $this->clientId)->distinct()->pluck('WddCode');

        $approvalRequests = ApprovalRequestModel::whereIn('id', $approvalLineRequestsWddCode)->where('Status', 'W')->where('ProcesStat', 'W')->whereIn('CurrStep', $approvalLineRequests)->pluck('DraftEntry');

    

             $expressWayJournalApprovalRequest = JournalEntryDraft::with('createdby', 'requestedby', 'approvalrequest.approvalrequeslinemodel')
            ->whereIn('id', $approvalRequests)
    
            ->orderBy('id', 'desc')
            ->where('client_id', $this->clientId)
            ->get();
        return $expressWayJournalApprovalRequest;
    }
}
