<?php

namespace App\Actions;

use App\Models\ChartOfAccount;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;

class SyncChartOfAccountsFromSapAction
{
    public function __construct() {}

    public function handle()
    {

        $baseUrl = 'http://20.47.92.31:9092/api/leta/chart-of-accounts';

        $response = Http::withoutVerifying()
            ->acceptJson()
            ->get($baseUrl);

        if ($response->failed()) {

            Log::error('Failed to fetch cost centers from SAP', ['response' => $response->body()]);

            return;
        }

        $chartOfAccounts = $response['message'] ?? [];

        foreach ($chartOfAccounts as $key => $chartOfAccount) {
            ChartOfAccount::firstOrCreate([
                'AcctCode' => $chartOfAccount['code'],
            ], [
                'AcctName' => $chartOfAccount['name'],
                'Type' => $chartOfAccount['account_type'],
            ]);
        }

    }
}
