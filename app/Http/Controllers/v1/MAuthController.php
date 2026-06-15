<?php

namespace App\Http\Controllers\v1;

use App\Models\User;
use App\Models\Payment;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Hash;

class MAuthController extends Controller
{
    public function login(Request $request)
    {
        $loginData = $request->validate([
            'email' => 'email|required',
            'password' => 'required',
        ]);

        $user = User::where('email', $request->email)->first();

        if (!$user) {
            return response(['message' => 'Invalid Credentials User Not found'], 401);
        }

        $check = !Hash::check($request->password, $user->password);
        if ($check) {
            return response(['message' => 'Invalid Credentials'], 401);
        }

        $accessToken = $user->createToken('authToken')->plainTextToken;

        return response([
            'access_token' => $accessToken,
        ]);
    }

    public function getMpesaTransaction()
    {
        $data = Payment::whereNull('ExtRef')
            ->orderBy('id', 'asc')
            ->get();

        return response([
            'data' => $data,
        ]);
    }

    public function updateMpesaTransactionStatus(Request $request, $id)
    {
        $data = Payment::where('id', $id)->first();

        if ($data) {
            $data->update(
                [
                    'ExtRef' => $request['ExtRef'],
                ]
            );
        }

        return true;
    }
}
