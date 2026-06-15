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
use App\Models\ApprovalProcess\ApprovalRequestModel;
use App\Models\ApprovalProcess\ApprovalRequestLineModel;

class NotifierCreatorDocumentApprovalJob implements ShouldQueue
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


        $draftDocument = $this->draftDocument;

    

        if ($draftDocument->WddStatus != 'Y') {
            
            return false;
        }

        if ($draftDocument->CANCELED != 'N') {
            
            return false;
        }

        if (!$draftDocument->ExtRefDocNum) {
            
            return false;
        }


 

        Mail::to($draftDocument->createdBy->email)->send(new NotifierCreatorDocumentApprovalMail($this->draftDocument));
     

        $this->draftDocument->update([
            'Notify' => 1
        ]);


      

        return true;
      

   
    }
}
