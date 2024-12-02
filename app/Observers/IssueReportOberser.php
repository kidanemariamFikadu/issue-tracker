<?php

namespace App\Observers;

use App\Models\IssueReport;
use App\Notifications\IssueResolvedNotification;

class IssueReportOberser
{
    /**
     * Handle the IssueReport "created" event.
     */
    public function created(IssueReport $issueReport): void
    {
        //
    }

    /**
     * Handle the IssueReport "updated" event.
     */
    public function updated(IssueReport $issueReport): void
    {
        logger($issueReport->status);
        if ($issueReport->status == 'Resolved' || $issueReport->status == 'Closed') {
            $issueReport->createdBy->notify(new IssueResolvedNotification($issueReport));
        }
    }

    /**
     * Handle the IssueReport "deleted" event.
     */
    public function deleted(IssueReport $issueReport): void
    {
        //
    }

    /**
     * Handle the IssueReport "restored" event.
     */
    public function restored(IssueReport $issueReport): void
    {
        //
    }

    /**
     * Handle the IssueReport "force deleted" event.
     */
    public function forceDeleted(IssueReport $issueReport): void
    {
        //
    }
}
