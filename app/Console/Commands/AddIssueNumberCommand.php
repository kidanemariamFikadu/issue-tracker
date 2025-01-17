<?php

namespace App\Console\Commands;

use App\Models\IssueReport;
use Illuminate\Console\Command;

class AddIssueNumberCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'app:add-issue-number-command';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Command description';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $this->info('Add issue number command');
        $issueReport=IssueReport::get();

        foreach ($issueReport as $issue) {
            $issue->issue_number = 'IR-' . str_pad($issue->id, 5, '0', STR_PAD_LEFT);
            $issue->save();
        }
    }
}
