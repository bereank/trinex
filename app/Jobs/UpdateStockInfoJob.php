<?php

namespace App\Jobs;

use App\Models\Stock;
use App\Models\StockHeader;
use Illuminate\Bus\Queueable;
use Illuminate\Support\Facades\Log;
use Illuminate\Queue\SerializesModels;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Contracts\Queue\ShouldBeUnique;

class UpdateStockInfoJob implements ShouldQueue
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

        try {

            foreach ($this->stockinfo as $key => $Stockdata) {
                # code...


                $stockHeaderData = StockHeader::updateOrCreate(
                    [
                        "client_id" => $this->client_id,
                        "ItemCode" => $Stockdata['ItemCode']
                    ],
                    [

                        "ItemName" => $Stockdata['ItemName'],
                        "SWW" => "n/a",
                    ]
                );

                Stock::updateOrCreate(
                    [
                        "DocEntry" => $stockHeaderData->id,
                        "ItemCode" => $Stockdata['ItemCode'],
                        "ItemName" => $Stockdata['ItemName'],
                        "Branch" => $Stockdata['Branch'],
                    ],
                    [


                        "InvntryUom" => $Stockdata['InvntryUom'] ?? "N/A",
                        "U_ProdLine" => $Stockdata['U_ProdLine'],
                        "U_GrpDesc" => $Stockdata['U_GrpDesc'],
                        "QtyInstock" => (int)$Stockdata['QtyInstock'],

                    ]
                );

                // Log::info($data->id);

            }
        } catch (\Throwable $th) {
            Log::info($th);
        }
    }
}
