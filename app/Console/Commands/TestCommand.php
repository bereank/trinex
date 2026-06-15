<?php

namespace App\Console\Commands;

use App\Actions\ApprovalProccessActions\DetermineDocumentApprovalStatus;
use App\Actions\PettyCashDocumentAction;
use App\Actions\ReportActions\GeneratePDFDocumentAction;
use App\Jobs\NotifierApproverJob;
use App\Jobs\NotifierCashierDocumentApprovalJob;
use App\Jobs\NotifierCreatorDocumentApprovalJob;
use App\Jobs\NotifierCreatorDocumentRejectedJob;
use App\Mail\NotifierCashierDocumentApprovalMail;
use App\Models\ApprovalProcess\ApprovalRequestLineModel;
use App\Models\ApprovalProcess\ApprovalRequestModel;
use App\Models\ApprovalProcess\ApprovalStage;
use App\Models\ODRF;
use App\Models\OWDD;
use App\Models\User;
use App\Services\Shared\AuthService;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Storage;

class TestCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'command:test-command';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Command description';

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {

        DB::table('users')->insert([
            'name' => 'Demo Admin 1',
            'email' => 'demo1@techrise.co.ke',
            'password' => Hash::make('Trading@1'),
            'ExtUserCode' => 'ADMIN',
            'email_verified_at' => \Carbon\Carbon::now(),
            'created_at' => \Carbon\Carbon::now(),
            'updated_at' => \Carbon\Carbon::now(),
            'company_id' => '1',
            'UserType' => 2,
            'isSystemUser' => 1
        ]);

        DB::table('users')->insert([
            'name' => 'Demo Admin 2',
            'email' => 'demo2@techrise.co.ke',
            'password' => Hash::make('Trading@1'),
            'ExtUserCode' => 'ADMIN',
            'email_verified_at' => \Carbon\Carbon::now(),
            'created_at' => \Carbon\Carbon::now(),
            'updated_at' => \Carbon\Carbon::now(),
            'company_id' => '1',
            'UserType' => 2,
            'isSystemUser' => 1
        ]);




        // $draftDocument = ODRF::with('createdBy')->first();

        // $action = (new PettyCashDocumentAction($draftDocument))->handle();
    }
}
