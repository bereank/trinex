<?php

namespace App\Console\Commands\Admin;

use App\Actions\SyncChartOfAccountsFromSapAction;
use App\Models\ChartOfAccount;
use Illuminate\Console\Command;

class SyncChartOfAccountsCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'app:sync-chart-of-accounts';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Sync chart of accounts from SAP';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        ChartOfAccount::truncate();

        (new SyncChartOfAccountsFromSapAction)->handle();
    }
}
