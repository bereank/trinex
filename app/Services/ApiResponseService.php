<?php

namespace App\Services;

/**
 * Service for Marke
 */
class ApiResponseService
{
    /**
     *  Success API Response
     *
     * @return \Illuminate\Http\Response
     */
    public function apiSuccessResponseService($data = null)
    {
        return response()
            ->json([
                'ResultState' => true,
                'ResultCode' => 1200,
                'ResultDesc' => 'Operation Was Successful',
                'ResponseData' => $data,
            ], 200);
    }

    public function apiSuccessDraftCreationResponseService($data)
    {
        return response()
            ->json([
                'ResultState' => true,
                'ResultCode' => 1200,
                'ResultDesc' => 'Draft Created Successfully',
                'ResponseData' => $data,
            ], 200);
    }

    /**
     *  Failure API Response
     *
     * @return \Illuminate\Http\Response
     */
    public function apiFailedResponseService($message)
    {
        return response()
            ->json([
                'ResultState' => false,
                'ResultCode' => 1500,
                'ResultDesc' => $message,
            ], 500);
    }
}
