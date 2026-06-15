<?php

namespace App\Http\Controllers\v1;

use App\Http\Controllers\Controller;
use App\Jobs\ApprovalRequestUpdateJob;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class ApprovalRequestController extends Controller
{
    /**
     * Approval Request Data
     */
    public function __invoke(Request $request)
    {
        $approvalRequests = $request['data'];
        $client_id = $request['client_id'];
  
        ApprovalRequestUpdateJob::dispatch($client_id, $approvalRequests);
    }
}
