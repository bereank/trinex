<?php

namespace App\Http\Controllers\v1;

use App\Models\OWDD;
use App\Models\User;
use App\Models\WDD1;
use App\Models\ApprovalLog;
use App\Models\UserDatabase;
use Illuminate\Http\Request;

use Illuminate\Support\Facades\Log;
use App\Http\Controllers\Controller;
use App\Services\ApiResponseService;
use Illuminate\Support\Facades\Crypt;
use App\Jobs\ApprovalDecisionStatusJob;

class ApprovalDecisionController extends Controller
{
    /**
     * Approval Decision
     */
    public function createOrUpdateApprovalDecision(Request $request)
    {
        $client_id = $request['client_id'];



        $approvalRequests = $request['data'];
        $client_id = $request['client_id'];

        ApprovalDecisionStatusJob::dispatch($client_id, $approvalRequests);
    }

    public function syncApprovalDecision($client_id)
    {

        try {
            $approvalLogs = ApprovalLog::pendingSync()
                ->where('client_id', $client_id)
                ->get();
            $approvalRequests = [];
            foreach ($approvalLogs as $key => $val) {

                $userData = UserDatabase::where('user_id', $val->user_id)
                    ->where('client_id', $val->client_id)
                    ->first();




                $userDetails = User::where('id', $val->user_id)->first();

                $approvalRequest = OWDD::where('id', $val->wdd_id)->first();

                if ($approvalRequest->Status == 'Y') {
                    $approvalLogs->forget($key);
                    continue;
                }


                if ($approvalRequest->Status == 'C') {
                    $approvalLogs->forget($key);
                    continue;
                }

                if ($approvalRequest->ProcesStat == 'C') {
                    $approvalLogs->forget($key);
                    continue;
                }



                $details = [
                    'request_id' => $val->id,
                    'WddCode' =>  $approvalRequest->WddCode,
                    'Status' => $val->Status  == "Y" ? "ardApproved" : "ardNotApproved",
                    'ApproverUserName' => $userDetails->ExtUserCode,
                    'ApproverPassword' => Crypt::decryptString($userData->SapPassword),
                    'Remarks' => $val->Remarks ?? "Approved: " . now()
                ];

                array_push($approvalRequests, $details);
            }


        
            return (new ApiResponseService())->apiSuccessResponseService($approvalRequests);
        } catch (\Throwable $th) {
            Log::info($th);
            return (new ApiResponseService())->apiFailedResponseService($th->getMessage());
        }
    }


    public function updateApprovalDecision(Request $request, $id)
    {

        // Log::info($id);
        Log::info($request['SyncStatus']);

        try {
            $log = ApprovalLog::where('id', $id)->first();


            $log->update([
                'SyncStatus' => $request['SyncStatus'],
                'OtherInfo' => $request['OtherInfo'],
                'sync_on' => now()
            ]);
            return (new ApiResponseService())->apiSuccessResponseService("Success");
        } catch (\Throwable $th) {
            Log::info($th);
            return (new ApiResponseService())->apiFailedResponseService($th->getMessage());
        }
    }
}
