<?php

namespace App\Console\Commands\Reports;

use App\Models\ApprovalLog;
use App\Models\User;
use Illuminate\Console\Command;

class DailyApprovalStatusReportCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'command:daily-approval-status-command';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Send Daily Approval Status';

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {
        $approvers = User::with('databases')->where('UserType', 1)->get();

        foreach ($approvers as $key => $approver) {
            $userDatabases = $approver->databases;
            foreach ($userDatabases as $key => $approver) {
                $approvalActions = ApprovalLog::get();
                foreach ($approvalActions as $key => $approver) {
                }
            }
        }
    }
}
