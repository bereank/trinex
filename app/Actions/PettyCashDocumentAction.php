<?php

namespace App\Actions;

use App\Models\ODRF;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;

class PettyCashDocumentAction
{
    public function __construct(protected ODRF $draftDocument)
    {

        $this->$draftDocument = $draftDocument;
    }

    public function handle(): ODRF
    {


        $draftDocument = $this->draftDocument;

        if ($draftDocument->ExtRefDocNum) {
            return $draftDocument;
        }

        if ($draftDocument->WddStatus == 'W') {
            return $draftDocument;
        }

        if ($draftDocument->WddStatus == 'N') {
            return $draftDocument;
        }




        $documentLines = [];
        foreach ($draftDocument['rows'] as $key => $rowItem) {

            $line = [
                'AccountCode' => '2141000',
                'ItemDescription' => $rowItem['Dscription'],
                'LineTotal' => $rowItem['LineTotal'],
                'VatGroup' => 'I0',
                'RequiredDate' => $draftDocument['DocDate'],
            ];
            array_push($documentLines, $line);
        }


        $assignedDatabase = $draftDocument->createdBy->databases[0];


        $dataParams = [
            'DocType' => 'dDocument_Service',
            'ReqType' => 12,
            'DocObjectCode' => 1470000113,
            'Requester' => $draftDocument->createdby->ExtUserCode,
            'RequesterName' => $draftDocument['ReqName'],
            'RequriedDate' => $draftDocument['DocDate'],
            'DocDate' => $draftDocument['DocDate'],
            'Comments' => $draftDocument['Comments'],
            'U_CheckOutID' => $draftDocument['id'],
            'DocumentLines' => $documentLines,
        ];



        $fullUrl = env('EXTERNAL_APPROVAL_REQUEST_URL') . "/purchase-request";



        $payload = [
            'client_id' => 9999,
            'username' => $draftDocument->createdby->ExtUserCode,
            'password' => $assignedDatabase->SapPassword,
            'data' => $dataParams
        ];



        $response = Http::asJson()
            ->acceptJson()
            ->withoutVerifying()
            ->post($fullUrl, $payload);

        if ($response->failed()) {

            $draftDocument->update([

                'EDocErrMsg' => $response->body(),
                'EDocStatus' => 1,
                'ExtRef' => null,
                'ExtRefDocNum' => null,
                'BaseEntry' => null,


            ]);
            throw new \ErrorException($response->body());
        }



        $draftDocument->update([

            'EDocErrMsg' => $response['EDocErrMsg'],
            'EDocStatus' => $response['EDocStatus'],
            'ExtRef' => $response['ExtRef'],
            'WddStatus' => 'Y',
            'ExtRefDocNum' => $response['ExtRefDocNum'],

        ]);



        return $draftDocument;
    }
}
