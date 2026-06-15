<?php

namespace App\Actions\ApprovalProccessActions;

use App\Models\ApprovalProcess\ApprovalRequestLineModel;
use App\Models\ODRF;

class GetDocumentApproversAction
{
    public function __construct(protected ODRF $draftDocument)
    {
        $this->draftDocument = $draftDocument;
    }

    public function handle()
    {

        return ApprovalRequestLineModel::with('authorizer', 'approvalrequest')
            ->whereHas('approvalrequest', function ($q) {
                $q->where('DraftEntry', $this->draftDocument->id);
            })
            ->where('Status', 'Y')
            ->get();
    }
}
