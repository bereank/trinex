<?php

namespace App\Console\Commands;

use App\Actions\ApprovalProccessActions\DetermineApprovalStagesAction;
use App\Models\ChartOfAccount;
use App\Models\JournalEntryDraft;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Mail;

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

    $journalEntry = JournalEntryDraft::first();

       (new DetermineApprovalStagesAction($journalEntry))->handle();

    dd('done');



        $chartOfAccounts = [
            [
                'AcctCode' => '1000',
                'AcctName' => 'Cash',
                'Type' => 'G/L',
            ],
            [
                'AcctCode' => '2000',
                'AcctName' => 'Accounts Receivable',
                'Type' => 'G/L',
            ],
            [
                'AcctCode' => '3000',
                'AcctName' => 'Inventory',
                'Type' => 'G/L',
            ],
            [
                'AcctCode' => '4000',
                'AcctName' => 'Accounts Payable',
                'Type' => 'G/L',
            ],
            [
                'AcctCode' => '5000',
                'AcctName' => 'Sales Revenue',
                'Type' => 'G/L',
            ],
            [
                'AcctCode' => '6000',
                'AcctName' => 'Cost of Goods Sold',
                'Type' => 'G/L',
            ],
            [
                'AcctCode' => '7000',
                'AcctName' => 'Operating Expenses',
                'Type' => 'G/L',
            ],
            [
                'AcctCode' => 'CUST001',
                'AcctName' => 'Customer A',
                'Type' => 'Customer',
            ],
            [
                'AcctCode' => 'CUST002',
                'AcctName' => 'Customer B',
                'Type' => 'Customer',
            ],
            [
                'AcctCode' => 'CUST003',
                'AcctName' => 'Customer C',
                'Type' => 'Customer',
            ],
            [
                'AcctCode' => 'VEND001',
                'AcctName' => 'Vendor A',
                'Type' => 'Supplier',
            ],
            [
                'AcctCode' => 'VEND002',
                'AcctName' => 'Vendor B',
                'Type' => 'Supplier',
            ],
        ];

        foreach ($chartOfAccounts as $key => $chartOfAccount) {
            ChartOfAccount::firstOrCreate([
                'AcctCode' => $chartOfAccount['AcctCode'],
            ], [
                'AcctName' => $chartOfAccount['AcctName'],
                'Type' => $chartOfAccount['Type'],
            ]);
        }


    }
}
