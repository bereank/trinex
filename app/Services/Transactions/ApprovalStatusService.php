<?php

namespace App\Services\Transactions;

use App\Models\ApprovalLog;
use App\Models\WDD1;
use Illuminate\Support\Facades\Log;

/**
 * Service for Marke
 */
class ApprovalStatusService
{
    /**
     *  Billing Process
     */
    public function updateApprovalDecisionStatus(int $client_id, int $WddCode, int $StepCode, int $UserID, string $status)
    {
        $wdd1ID = WDD1::where('client_id', $client_id)
            ->where('WddCode', $WddCode)
            ->where('StepCode', $StepCode)
            ->where('UserID', $UserID)
            ->first();

        if (! $wdd1ID) {
            Log::info(' USER ID : '.$UserID);
            Log::info('WDDCODE NOT FOUND : '.$WddCode);
            Log::info('STEPCODE : '.$WddCode);

            return;
        }
        $wdd1ID->update([
            'Status' => $status,
        ]);

        $approvalLog = ApprovalLog::create([
            'wdd_id' => $wdd1ID->id,
            'Status' => $status,
        ]);
    }
}
