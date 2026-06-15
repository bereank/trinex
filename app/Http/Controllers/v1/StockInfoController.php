<?php

namespace App\Http\Controllers\v1;

use App\Models\User;
use App\Models\Stock;
use App\Models\StockHeader;
use App\Jobs\UsersUpdateJob;
use App\Models\UserDatabase;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use App\Http\Controllers\Controller;
use App\Jobs\UpdateStockInfoJob;
use App\Services\ApiResponseService;
use Illuminate\Support\Facades\Auth;

class StockInfoController extends Controller
{
    public function __invoke(Request $request, $client_id)
    {
        Log::info($request['stockInfo']);
        UpdateStockInfoJob::dispatch($client_id,$request['stockInfo']);
    }


}
