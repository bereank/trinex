<?php

namespace App\Console\Commands\Admin;

use App\Models\Expense;
use Illuminate\Console\Command;

class CreateGLCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'app:create-g-l-command';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'creating expenses GLS ';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $this->comment('---------------------------------------------');
        $this->line('<fg=red;bg=yellow>  CREATING EXPENSES GLS ');
        $this->comment('---------------------------------------------');

        $expensesJson = file_get_contents(base_path('resources/json/expenses.json'));
        $expenses = collect(json_decode($expensesJson, true));

        foreach ($expenses as $expense) {
            Expense::updateOrCreate(
            [
                'AcctCode' => $expense['Acct'],
            ], 
            [
                'AcctName' => $expense['Acct Name'],

            ]);
        }

        $this->comment('---------------------------------------------');

        return Command::SUCCESS;
    }
}
