<?php

namespace App\Jobs;

use App\Models\OPRC;
use App\Models\Stock;
use App\Models\StockHeader;
use Illuminate\Bus\Queueable;
use Illuminate\Support\Facades\Log;
use Illuminate\Queue\SerializesModels;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Contracts\Queue\ShouldBeUnique;

class UpdateCostCenterJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    /**
     * Create a new job instance.
     */
    public function __construct(protected int $client_id, protected array $stockinfo)
    {
        $this->stockinfo = $stockinfo;
        $this->client_id = $client_id;
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

        foreach ($this->stockinfo as $key => $value) {
            Log::info($value['OcrCode']);
            try {
              $DATA=   OPRC::updateOrCreate(
                [
                    'client_id' =>$this->client_id,
                    'PrcCode' => $value['OcrCode'],
                    'DimCode' => $value['DimCode'],
                    
                ], [
                    'Dim4' => $value['Dim4'] ?? null,
                    'PrcName' => htmlspecialchars($value['OcrName']),
                ]);

           
            } catch (\Throwable $th) {
                Log::info($value);
                Log::info($th);
                continue;
            }
        }
    }
}
