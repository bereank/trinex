<?php

namespace App\Console\Commands\Admin;

use App\Models\Company;
use App\Models\UserDatabase;
use App\Models\CompanyDatabase;
use Illuminate\Console\Command;

class CreateCompanyDatabaseCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'command:create-database';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Create Database Command';

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {

        $details = [
            [
                'company_id' => 1,
                'client_id' => 1001,
                'db_name' => "TEST  DB"
            ]
        ];
        foreach ($details as $key => $val) {
            CompanyDatabase::firstOrCreate([
                'company_id' => $val['company_id'],
                'client_id' => $val['client_id']
            ], [
                'db_name' => $val['db_name']
            ]);

            $user = UserDatabase::firstOrCreate([
                'user_id' => 1,
                'client_id' => $val['client_id'],
                'USERID' => '00000000',
            ], [
                'SapPassword' => 'Pass@123',
            ]);
        }
    }
}
