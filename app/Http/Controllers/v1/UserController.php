<?php

namespace App\Http\Controllers\v1;

use App\Http\Controllers\Controller;
use App\Jobs\UsersUpdateJob;
use App\Models\User;
use App\Models\UserDatabase;
use App\Services\ApiResponseService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class UserController extends Controller
{
    public function createOrUpdateUsers(Request $request)
    {
        $company_id = Auth::user()->company_id;

        $userData = $request['data'];
        $clientID = $request['client_id'];

        UsersUpdateJob::dispatch($company_id, $clientID, $userData);
    }

    public function getApproversUserIDs($clientID)
    {
        try {
            $company_id = Auth::user()->company_id;
            $users = User::where('company_id', $company_id)->where('UserType', 1)->pluck('id');
            $approversUserCode = UserDatabase::where('client_id', $clientID)->whereIn('user_id', $users)->pluck('USERID');

            return (new ApiResponseService())->apiSuccessResponseService($approversUserCode);
        } catch (\Throwable $th) {
            return (new ApiResponseService())->apiFailedResponseService($th->getMessage());
        }

        return $approversUserCode;
    }
}
