<?php

namespace App\Http\Controllers\v1;

use App\Http\Controllers\Controller;
use App\Models\CompanyDatabase;
use App\Models\DraftDocument;
use App\Models\OWDD;
use App\Models\User;
use App\Models\UserDatabase;
use App\Services\ApiResponseService;
use Illuminate\Http\Request;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;

class DraftController extends Controller
{
    public function getDraftDocEntries($clientID)
    {

        $draftType = \Request::get('draftType');
        try {
            $draftEntries = OWDD::where('client_id', $clientID)
                ->where('ProcesStat', 'W')
                ->distinct()
                ->where('DraftType', $draftType)
                ->pluck('DraftEntry');

            $data = [
                'DraftEntries' => $draftEntries
            ];
            return (new ApiResponseService())->apiSuccessResponseService($data);
        } catch (\Throwable $th) {
            return (new ApiResponseService())->apiFailedResponseService($th->getMessage());
        }
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

    public function createDraftDocEntries(Request $request, $clientID)
    {
        $draftData = $request['data'];
        $client_id = $request['client_id'];
        $documentAttachments = $request['documents'];
        $journalEntries = $request['journalEntries'];


        $draftEntries = collect($draftData)->pluck('DocEntry')->unique();

        foreach ($draftEntries as $key => $docEntry) {
            $filteredData = Arr::where($draftData, function ($doc, $key) use ($docEntry) {
                return $doc['DocEntry'] == $docEntry;
            });

            $draftAttachment = Arr::where($documentAttachments, function ($doc, $key) use ($docEntry) {
                return $doc['DocEntry'] == $docEntry;
            });


            $journalData = [];

            if ($journalEntries) {


                $docJournalEntries = Arr::where($journalEntries, function ($doc, $key) use ($docEntry) {
                    return $doc['DocEntry'] == $docEntry;
                });


                $docJournalEntries = array_values($docJournalEntries);
                $journalData =   $docJournalEntries[0]['journalData'];
            }

            $filteredData = array_values($filteredData);
            $draftAttachment = array_values($draftAttachment);

            try {
                $firstLine = $filteredData[0];
                $darft = DraftDocument::updateOrCreate([
                    'client_id' => $client_id,
                    'DocEntry' => $docEntry,
                    'ObjType' => $firstLine['ObjType'],
                ], [
                    'DocNum' => $firstLine['DocNum'],
                    'data' => json_encode($filteredData),
                    'attachments' => json_encode($draftAttachment),
                    'approvers' => json_encode($journalData)
                ]);

                Log::info("Created Draft Doc : " . $darft->id . " OBJTYPE: " . $firstLine['ObjType']);
            } catch (\Throwable $th) {
                Log::info($th);

                return $th->getMessage();
            }
        }
    }
}
