<?php

namespace App\Console\Commands\Notifications;

use App\Models\ODRF;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Log;
use App\Services\ApiResponseService;
use App\Jobs\NotifierCashierDocumentApprovalJob;
use App\Actions\ReportActions\GeneratePDFDocumentAction;

class CashierNotificationCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'app:cashier-notification-command';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Command description';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        
        $draftDocument = ODRF::whereNotNull('BaseEntry')
                // ->whereNotNull('EDocStatus')
                // ->whereNotNull('EDocErrMsg')
                ->whereNull('Notify')
                // ->where('DocDate','>=','2025-01-01')
                ->where('updated_at','>=','2025-01-01')
                ->get();


        foreach ($draftDocument as $key => $value) {

            try {

                if ($value->BaseEntry) {

                    // Log::info('Existing Entry : '. $value->BaseEntry);  

                    NotifierCashierDocumentApprovalJob::dispatch($value);

                    $value->update([
                        'Notify' => 1
                    ]);
                }


            } catch (\Throwable $th) {
                // throw $th;
                Log::info($th->getMessage());

            }

            continue;
            
        }
    }
}
