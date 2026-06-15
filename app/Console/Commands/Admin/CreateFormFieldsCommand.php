<?php

namespace App\Console\Commands\Admin;

use App\Models\OWDD;
use App\Models\DraftDocument;
use App\Models\FM100;
use App\Models\FT100;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\DB;
use App\Services\Shared\CommonsService;

class CreateFormFieldsCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'command:create-form-fields';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Create Form Fields';

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {

        DB::beginTransaction();
        try {
            $headerFields = (new CommonsService())->headerFields();

            foreach ($headerFields as $key =>  $headerField) {
                FT100::firstOrCreate([
                    'Position' => 0,
                    'Column' => $headerField['Column']
                ], [
                    'Type' => $headerField['Type'],
                    'Visible' => 1,
                    'Label' => $headerField['Label'],
                    'Size' => $headerField['Size'],
                    'SortID' => $headerField['SortID'] ?? $key
                ]);
            }


            $rowFields = (new CommonsService())->rowFields();

            foreach ($rowFields as $key =>  $rowField) {
                FT100::firstOrCreate([
                    'Position' => 1,
                    'Column' => $rowField['Column']
                ], [
                    'Type' => $rowField['Type'],
                    'Visible' => 1,
                    'Label' => $rowField['Label'],
                    'SortID' => $rowField['SortID']
                ]);
            }


            DB::commit();
        } catch (\Throwable $th) {
            DB::rollback();
            throw $th;
        }
    }
}
