<?php

namespace App\Livewire\Dashboard;

use App\Models\IssueReport;
use Livewire\Component;

class Index extends Component
{
    private function getThisWeekReport()
    {
        $startDate = now()->subDays(7);
        $endDate = now();

        $issuesRaised = IssueReport::whereBetween('created_at', [$startDate, $endDate])->count();
        $issuesOpened = IssueReport::where('status', 'Closed')->whereBetween('updated_at', [$startDate, $endDate])->count();
        $issuesClosed = IssueReport::where('status', 'Open')->whereBetween('updated_at', [$startDate, $endDate])->count();
        $issuesResolved = IssueReport::where('status', 'In Progress')->whereBetween('updated_at', [$startDate, $endDate])->count();
        $issuesInProgress = IssueReport::where('status', 'Resolved')->whereBetween('updated_at', [$startDate, $endDate])->count();

        return [
            'raised' => $issuesRaised,
            'opened' => $issuesOpened,
            'closed' => $issuesClosed,
            'resolved' => $issuesResolved,
            'inprogress' => $issuesInProgress,
        ];
    }

    public function render()
    {
        return view('livewire.dashboard.index', [
            'weekData' => $this->getThisWeekReport()
        ]);
    }
}
