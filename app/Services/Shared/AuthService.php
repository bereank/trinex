<?php

namespace App\Services\Shared;

use BereanK\Integrator\Services\ConfigProviderService;
use BereanK\Integrator\Services\HanaDBConnector;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;

class AuthService
{
    public function sharedHanaConnector()
    {
        $clientID = 1;

        $configs = (new ConfigProviderService())->configs($clientID);

        $pdo = HanaDBConnector::get()->connect($clientID);

        return $pdo;
    }

    public function sapServiceLayerLogin($client_id)
    {
        $configs = (new ConfigProviderService())->configs($client_id);
        $fullUrl = env('SAP_SERVICE_LAYER_URL').'/b1s/v1/Login';

        $params = [
            'UserName' => $configs['username'],
            'Password' => $configs['password'],
            'CompanyDB' => $configs['CompanyDB'],
        ];

        $response = Http::withoutVerifying()
            ->acceptJson()
            ->post($fullUrl, $params);

        if ($response->failed()) {
            $responseBody = $response->json();
            Log::info($responseBody);
            throw new \ErrorException($response->body());
        }

        $sessionId = $response->cookies()->getCookieByName('B1SESSION')->getValue();
        $routeId = $response->cookies()->getCookieByName('ROUTEID')->getValue();

        $headers[] = 'Cookie: B1SESSION='.$sessionId.'; ROUTEID='.$routeId.';';

        return $headers;
    }

    public function postDataToServiceLayer($client_id, $userID, $dataParams)
    {
        $headers = $this->sapServiceLayerLogin($client_id);

        $userUpdateUrl = "https://192.168.1.23:50000/b1s/v1/Users({$userID})";

        $curl = curl_init();

        $data_string = json_encode($dataParams);
        curl_setopt($curl, CURLOPT_CUSTOMREQUEST, 'PATCH');
        curl_setopt($curl, CURLOPT_POSTFIELDS, $data_string);
        curl_setopt($curl, CURLOPT_HTTPHEADER, $headers);
        curl_setopt($curl, CURLOPT_URL, $userUpdateUrl);
        curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, false);

        $response = curl_exec($curl);

        $httpcode = curl_getinfo($curl, CURLINFO_HTTP_CODE);

        $result = json_decode($response);

        if ($httpcode == 400) {
            throw new \ErrorException($result->error->message->value);
        }
    }
}
