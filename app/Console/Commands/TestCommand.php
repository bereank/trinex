<?php

namespace App\Console\Commands;

use App\Actions\ApprovalProccessActions\DetermineApprovalStagesAction;
use App\Actions\PostJournalEntryDocumentAction;
use App\Models\JournalEntryDraft;
use Illuminate\Console\Command;

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

        $journalEntry = JournalEntryDraft::findOrFail(3);

        (new PostJournalEntryDocumentAction($journalEntry))->handle();

        dd('done');

    }
}
