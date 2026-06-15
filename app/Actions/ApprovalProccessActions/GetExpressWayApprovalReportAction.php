<?php

namespace App\Actions\ApprovalProccessActions;

use App\Models\ApprovalProcess\ApprovalRequestLineModel;
use App\Models\ApprovalProcess\ApprovalRequestModel;
use App\Models\ODRF;
use Illuminate\Support\Facades\Auth;

class GetExpressWayApprovalReportAction
{
    public function __construct(protected int $clientId)
    {
        $this->clientId = $clientId;

    }

    public function handle()
    {

     

       

    }
}
