<?php

namespace App\Console\Commands\Admin;

use App\Models\OWDD;
use App\Models\User;
use App\Models\FM100;
use App\Models\FT100;
use App\Models\DraftDocument;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\DB;
use App\Actions\GetObjectTypesAction;
use App\Services\Shared\CommonsService;

class AssignUserFormFieldsCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'command:assign-user-form-fields';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Assign User Form Fields';

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {

        DB::beginTransaction();
        try {

            $getObjectTypes = (new GetObjectTypesAction())->handle();
            $formFields = FT100::get();
            $usersInfo = User::where('UserType', 1)->pluck('id');
            foreach ($usersInfo as $key => $user) {
               foreach ($getObjectTypes as $key =>   $getObjectType) {
              
                foreach (  $formFields as $key =>    $formField) {
                   
                    FM100::firstOrCreate([
                        'UserSign' => $user,
                        'ObjType' => $getObjectType['ObjType'],
                        'Position' => $formField['Position'],
                        'Column' => $formField['Column']
                    ], [
                        'Type' => $formField['Type'],
                        'Visible' => 1,
                        'Label' => $formField['Label'],
                        'Size' => $formField['Size'],
                        'SortID' =>$formField['SortID']
                    ]);
                   }
               }
            }



            DB::commit();
        } catch (\Throwable $th) {
            DB::rollback();
            throw $th;
        }
    }
}
