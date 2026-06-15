<?php

namespace App\Http\Controllers\v1;

use App\Models\ODRF;
use App\Models\OWDD;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use App\Http\Controllers\Controller;
use App\Services\ApiResponseService;
use App\Jobs\NotifierCashierDocumentApprovalJob;
use App\Jobs\NotifierCreatorDocumentApprovalJob;
use App\Actions\ReportActions\GeneratePDFDocumentAction;

class PurchaseRequestController extends Controller
{

    public function index($clientID)
    {

        try {
            $pendingPurchaseRequest = ODRF::with('rows', 'createdby', 'createdby.databases')
                ->where('client_id', $clientID)
                ->whereHas('createdby.databases', function ($q) use ($clientID) {
                    $q->where('client_id', $clientID);
                })
                ->where('WddStatus', 'Y')
                ->where('CANCELED', 'N')
                ->whereNull('ExtRef')
                ->get();



            return (new ApiResponseService())->apiSuccessResponseService($pendingPurchaseRequest);
        } catch (\Throwable $th) {
            return (new ApiResponseService())->apiFailedResponseService($th->getMessage());
        }
    }

  

    public function update(Request $request, $id)
    {






        try {


            $updatePayload = [
                'EDocErrMsg' => $request['EDocErrMsg'],
                'EDocStatus' => $request['EDocStatus'],
                'ExtRef' => $request['ExtRef'],
                'ExtRefDocNum' => $request['ExtRefDocNum'],
                'BaseEntry' => $request['BaseEntry'],
            ];


            Log::info(json_encode($updatePayload));

            // $draftDocument = ODRF::where('ExtRef', $request['ExtRef'])->first();


            // // if ($draftDocument) {

      
            // //     Log::info("Same Document Number");
            // //     Log::info($id);
            // //     Log::info(json_encode($updatePayload));

            // //     return (new ApiResponseService())->apiSuccessResponseService("Duplicate REef");
             
            // // }





            $draftDocument = ODRF::where('id', $id)->first();
            $draftDocument->update( $updatePayload);


            NotifierCreatorDocumentApprovalJob::dispatch($draftDocument);
      

            return (new ApiResponseService())->apiSuccessResponseService($draftDocument);
        } catch (\Throwable $th) {
            Log::info($th);
            return (new ApiResponseService())->apiFailedResponseService($th->getMessage());
        }
    }

    public function   getPurchaseRequestPaymentDetails($clientID)
    {

        try {
            $pendingPurchaseRequest = ODRF::with('rows', 'createdby', 'createdby.databases')
                ->where('client_id', $clientID)
                ->whereHas('createdby.databases', function ($q) use ($clientID) {
                    $q->where('client_id', $clientID);
                })
                ->whereHas('rows', function ($q) {
                    $q->whereNotNull('AcctCode');
                })
                ->where('WddStatus', 'Y')
                ->where('CANCELED', 'N')
                ->whereNull('BaseEntry')
                ->whereNotNull('ExtRef')
                ->get();



            return (new ApiResponseService())->apiSuccessResponseService($pendingPurchaseRequest);
        } catch (\Throwable $th) {
            return (new ApiResponseService())->apiFailedResponseService($th->getMessage());
        }
    }

    public function purchaseRequestPaymentDetails(Request $request, $id)
    {


        try {


            Log::info(json_encode($request->all()));

            $updatePayload = [
                'EDocErrMsg' => $request['EDocErrMsg'],
                'EDocStatus' => $request['EDocStatus'],
                'BaseEntry' => $request['BaseEntry'],
                'U_BaseDoc' => $request['DocEntry']
            ];





            Log::info("**************Purchase Request ID Updating Payment: " . $id);
            Log::info(json_encode($updatePayload));
            $draftDocument = ODRF::where('id', $id)->first();
            $draftDocument->update($updatePayload);


            
            $filePath = (new GeneratePDFDocumentAction($id))->handle();

           NotifierCashierDocumentApprovalJob::dispatch($draftDocument);

            return (new ApiResponseService())->apiSuccessResponseService($draftDocument);
        } catch (\Throwable $th) {
            Log::info($th);
            return (new ApiResponseService())->apiFailedResponseService($th->getMessage());
        }
    }

    public function purchaseRequestPaymentSumDetails(Request $request, $id)
    {


        try {
            $draftDocument = ODRF::where('id', $id)->first();
            $draftDocument->update([
                'PaidToDate' => $request['PaidToDate'],
            ]);

            return (new ApiResponseService())->apiSuccessResponseService($draftDocument);
        } catch (\Throwable $th) {
            Log::info($th);
            return (new ApiResponseService())->apiFailedResponseService($th->getMessage());
        }
    }




    
}
