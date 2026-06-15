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
use App\Models\ApprovalProcess\ApprovalRequestModel;
use App\Models\ApprovalProcess\ApprovalRequestLineModel;

class NotifierApproverJob implements ShouldQueue
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
    public function handle(): void
    {   

        $approvalRequest = ApprovalRequestModel::where('DraftEntry', $this->draftDocument->id)->first();

        $approvalRequestLines = ApprovalRequestLineModel::with('authorizer')
            ->where('StepCode', $approvalRequest->CurrStep)
            ->where('WddCode', $approvalRequest->id)
            ->where('isNotified', 0)
            ->get();

        foreach ($approvalRequestLines as $key => $approvalRequestLine) {

            try {        
            
                Mail::to($approvalRequestLine->authorizer->email)->send(new ApprovalRequestedMail($this->draftDocument));

                $approvalRequestLine->update([
                    'isNotified' => 1
                ]);

            } catch (\Throwable $th) {
                Log::info($th);
                continue;
            }
         
          
        }

   
    }
}
