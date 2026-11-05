<?php

namespace App\Actions;

use App\Models\JournalEntryDraft;
use Illuminate\Support\Facades\Http;

class PostJournalEntryDocumentAction
{
    public function __construct(protected JournalEntryDraft $draftDocument)
    {

        $this->$draftDocument = $draftDocument;
    }

    public function handle(): JournalEntryDraft
    {


        $draftDocument = $this->draftDocument;

        // if ($draftDocument->ExtRefDocNum) {
        //     return $draftDocument;
        // }

        if ($draftDocument->WddStatus == 'W') {
            return $draftDocument;
        }

        if ($draftDocument->WddStatus == 'N') {
            return $draftDocument;
        }




        $journalEntryLines = $draftDocument->lines;


        $documentLines = [];
        foreach ($journalEntryLines as $key => $journalEntryLine) {

       
            $lineInfo = [
                
                    'AccountCode' =>$journalEntryLine['account_code'],
                    'Debit' => $journalEntryLine['debit'],
                    'Credit' => $journalEntryLine['credit'],
                    'LineMemo' => $journalEntryLine['account_name'],
                
            ];
            $documentLines[] = $lineInfo;
        }



           $payload = [
            'ReferenceDate' => date('Y-m-d'),
            'Reference' => $draftDocument->reference_1,
            'Reference2' => $draftDocument->id,
            'Indicator' => 'EP',
            'DueDate' => date('Y-m-d'),
            'TaxDate' => date('Y-m-d'),
            'Memo' => $draftDocument->reference_1,
            'JournalEntryLines' => $documentLines,
        ];


    

        $fullUrl =  "http://20.47.92.31:9092/api/leta/purchase-request";
        $payload = [
            'client_id' => 5,
            'data' => $payload
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
            'reference_3' => $response['ExtRef'],
            'WddStatus' => 'Y',
            'reference_3' => $response['ExtRefDocNum'],

        ]);



        return $draftDocument;
    }
}
