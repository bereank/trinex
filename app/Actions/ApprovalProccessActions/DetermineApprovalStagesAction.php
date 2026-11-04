<?php

namespace App\Actions\ApprovalProccessActions;

use App\Models\ApprovalProcess\ApprovalTemplate;
use App\Models\ChartOfAccount;
use App\Models\JournalEntryDraft;
use App\Models\ODRF;

class DetermineApprovalStagesAction
{
    public function __construct(protected ODRF|JournalEntryDraft $draftDocument)
    {

        $this->draftDocument = $draftDocument;
    }

    public function handle(): bool
    {

        $draftDocument = $this->draftDocument;

        
        $stagesDocumentHasToThrough = collect([]);




        $currentDatabaseUserSettings = $draftDocument->requestedby->databases->where('client_id', $draftDocument->client_id)->first();



        $defaultApprovalTemplateOfRequester = ApprovalTemplate::with('templatesstages.approvalstage.stagerule')
            ->where('id', $currentDatabaseUserSettings->default_template_id)
            ->first();

        /**
         * If User Default Template is set
         */
        if (!$defaultApprovalTemplateOfRequester) {
            $draftDocument->update([
                'WddStatus' => 'Y',
            ]);
       
            throw new \ErrorException('Your Approval Maxtrix in not set, Contact IT Department');
        }

        foreach ($defaultApprovalTemplateOfRequester->templatesstages as $key => $templatesstage) {
            $approvalStage = $templatesstage->approvalstage;
            $stagesDocumentHasToThrough->push($approvalStage);
        }

        if (count($stagesDocumentHasToThrough) <= 0) {

            $draftDocument->update([
                'WddStatus' => 'Y',
            ]);
      
            throw new \ErrorException('Your Approval Maxtrix in not set, Contact IT Department');
        }

  
        (new CreateApprovalRequestAction($draftDocument, $defaultApprovalTemplateOfRequester, $stagesDocumentHasToThrough))->handle();
        $draftDocument->update([
            'WddStatus' => 'W',
        ]);

        return false;
    }
}
