<?php

namespace App\Jobs;

use App\Models\User;
use App\Models\UserDatabase;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Log;

class UsersUpdateJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    public $company_id;

    public $users;

    public $client_id;


    /**
     * The number of seconds the job can run before timing out.
     *
     * @var int
     */
    public $timeout = 400;

    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct(int $company_id, int $client_id, array $users)
    {
        $this->company_id = $company_id;
        $this->users = $users;
        $this->client_id = $client_id;
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        foreach ($this->users as $key => $val) {
            try {
                $user = User::updateOrCreate(
                    [
                        'company_id' => $this->company_id,
                        'ExtUserCode' => $val['USER_CODE'],
                    ],
                    [
                        'email' => $val['E_Mail'],
                        'name' => $val['U_NAME'] ?? 'N/A'
                    ]
                );

                $user = UserDatabase::firstOrCreate([
                    'user_id' => $user->id,
                    'client_id' => $this->client_id,
                    'USERID' => $val['USERID'],
                ], [
                    'SapPassword' => 'Pass@123',
                ]);
            } catch (\Throwable $th) {
                info($val['USER_CODE']);
                Log::info($th->getMessage());

                continue;
            }
        }
    }
}
