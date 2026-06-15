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
use App\Mail\NotifierCashierDocumentApprovalMail;
use App\Mail\NotifierCreatorDocumentApprovalMail;
use App\Models\ApprovalProcess\ApprovalRequestModel;
use App\Models\ApprovalProcess\ApprovalRequestLineModel;

class NotifierCashierDocumentApprovalJob implements ShouldQueue
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

        if (!$draftDocument->BaseEntry) {
            
            return false;
        }

        Mail::to('cashier@dakawou.com')->send(new NotifierCashierDocumentApprovalMail($this->draftDocument));

        Log::info('Cashier Notification Send');

        return true;
      
    }
}
