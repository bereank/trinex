<?php

namespace App\Jobs;


use App\Models\WDD1;
use Illuminate\Bus\Queueable;
use Illuminate\Support\Facades\Log;
use Illuminate\Queue\SerializesModels;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Contracts\Queue\ShouldBeUnique;

class ApprovalDecisionStatusJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    public $approvalDecisions;

    public $client_id;
    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct($client_id, $approvalDecisions)
    {

        $this->approvalDecisions = $approvalDecisions;
        $this->client_id = $client_id;
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        foreach ($this->approvalDecisions as $key => $value) {
            $data = WDD1::updateOrCreate([
                'client_id' => $this->client_id,
                'WddCode' => $value['WddCode'],
                'StepCode' => $value['StepCode'],
                'UserID' => $value['UserID'],
            ], [
                'Status' => $value['Status'],
                'Remarks' => $value['Remarks'],
                'CreateDate' => $value['CreateDate'],
                'CreateTime' => $value['NormalTime'],
                'UpdateDate' => $value['UpdateDate'],
                'UpdateTime' => $value['UpdateTime'],
            ]);
        }
    }
}
