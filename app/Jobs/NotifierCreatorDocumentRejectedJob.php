<?php

namespace App\Jobs;

use App\Models\ODRF;
use App\Models\OPRC;
use App\Models\Stock;
use App\Models\StockHeader;
use App\Models\DraftDocument;
use Illuminate\Bus\Queueable;
use App\Mail\ApprovalRequestedMail;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Mail;
use Illuminate\Queue\SerializesModels;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Contracts\Queue\ShouldBeUnique;
use App\Mail\NotifierCreatorDocumentApprovalMail;
use App\Mail\NotifierCreatorDocumentRejectedMail;
use App\Models\ApprovalProcess\ApprovalRequestModel;
use App\Models\ApprovalProcess\ApprovalRequestLineModel;

class NotifierCreatorDocumentRejectedJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    /**
     * Create a new job instance.
     */
    public function __construct(protected ODRF $draftDocument)
    {
        $this->draftDocument = $draftDocument;
    }


    /**
     * The number of seconds the job can run before timing out.
     *
     * @var int
     */
    public $timeout = 120;

    /**
     * Execute the job.
     */
    public function handle(): bool
    {


        $draftDocument = ODRF::where('id', $this->draftDocument->id)->first();


        if ($draftDocument->WddStatus != 'N') {

            return false;
        }


        $approvaldecisionreport = ApprovalRequestLineModel::with('approvalrequest', 'approvalstage', 'authorizer')
            ->whereHas('approvalrequest', function ($q) use ($draftDocument) {
                $q->where('DraftEntry', $draftDocument->id);
            })
            ->get();

        foreach ($approvaldecisionreport as $key => $val) {

            $status = 'Pending';

            if ($val['Status'] == 'N') {
                $status = 'Rejected';
            }
            if ($val['Status'] == 'Y') {
                $status = 'Approved';
            }

            $approvaldecisionreport[$key]['StatusNormal'] = $status;
        }




        Mail::to($draftDocument->createdBy->email)->send(new NotifierCreatorDocumentRejectedMail($this->draftDocument, $approvaldecisionreport));


        $this->draftDocument->update([
            'Notify' => 1
        ]);




        return true;
    }
}
