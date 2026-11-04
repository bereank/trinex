<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        DB::table('users')->insert([
            'name' => 'Demo Admin',
            'email' => 'demo@stalis.co.ke',
            'password' => Hash::make('Trading@1'),
            'ExtUserCode' => 'ADMIN',
            'email_verified_at' => \Carbon\Carbon::now(),
            'created_at' => \Carbon\Carbon::now(),
            'updated_at' => \Carbon\Carbon::now(),
            'company_id' => '1',
            'UserType' => 2,
            'isSystemUser' => 1
        ]);
    }
}
