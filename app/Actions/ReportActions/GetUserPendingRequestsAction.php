<?php

namespace App\Actions\ReportActions;

use App\Models\OWDD;
use App\Models\User;
use App\Models\WDD1;
use App\Models\ApprovalLog;
use App\Models\UserDatabase;
use App\Models\DraftDocument;


class GetUserPendingRequestsAction
{

    public function __construct(protected UserDatabase $userDatabase)
    {
        $this->userDatabase= $userDatabase;
      
    }

    public function handle()
    {

        
     
    
        $clientID = $this->userDatabase->client_id;


    

        $approvedAndSynced = ApprovalLog::approvedAndSynced($clientID, $this->userDatabase->user_id)->pluck('WddCode');


        $approvalRequestsCurrentStages = OWDD::where('client_id', $clientID)
            ->whereNotIn('WddCode', $approvedAndSynced)
            ->where('Status', 'W')
            ->where('ProcesStat', 'W')
            ->distinct()
            ->pluck('CurrStep');



        $approvalCodes = WDD1::where('client_id', $clientID)
            ->where('USERID', $this->userDatabase->USERID)
            ->where('Status', 'W')
            ->whereIn('StepCode', $approvalRequestsCurrentStages)
            ->pluck('WddCode');


        $approvalRequests = OWDD::where('client_id', $clientID)
            ->where('Status', 'W')
            ->where('ProcesStat', 'W')
            ->whereIn('WddCode', $approvalCodes)
            ->orderBy('WddCode', 'desc')
            ->get();

        foreach ($approvalRequests as $key => $arequest) {
            $approvalLogData = ApprovalLog::where('WddCode', $arequest->WddCode)
            ->where('client_id', $arequest->client_id)
            ->where('user_id', $this->userDatabase->user_id)
            ->first();

        if ($approvalLogData &&     $approvalLogData->SyncStatus == 0) {
            $approvalRequests->forget($key);
        }
        }


        return $approvalRequests;

    }
}
