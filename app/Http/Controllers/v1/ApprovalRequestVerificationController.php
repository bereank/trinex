<?php

namespace App\Http\Controllers\v1;

use App\Models\OWDD;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use App\Http\Controllers\Controller;
use App\Services\ApiResponseService;

class ApprovalRequestVerificationController extends Controller
{

    public function getWddEntries($clientID)
    {


        try {
            $draftEntries = OWDD::where('client_id', $clientID)
                ->where('Status', 'W')
                ->where('ProcesStat', 'W')
                ->pluck('WddCode');

            return (new ApiResponseService())->apiSuccessResponseService($draftEntries);
        } catch (\Throwable $th) {
            return (new ApiResponseService())->apiFailedResponseService($th->getMessage());
        }
    }

    public function updateWddEntries(Request $request, $clientID)
    {

        $WddCode = $request['WddCode'];

        try {
            $draftEntries = OWDD::where('client_id', $clientID)
                ->where('WddCode', $WddCode)
                ->update([
                    'Status' => $request['Status'],
                    'ProcesStat' =>$request['ProcesStat'],
                ]);

        

            return (new ApiResponseService())->apiSuccessResponseService($draftEntries);
        } catch (\Throwable $th) {
            Log::info($th);
            return (new ApiResponseService())->apiFailedResponseService($th->getMessage());
        }
    }
}
