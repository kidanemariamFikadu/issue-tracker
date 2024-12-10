<?php

namespace App\Livewire\Dashboard;

use App\Models\IssueReport;
use Illuminate\Support\Facades\DB;
use Livewire\Component;

class Index extends Component
{
    function getWeeklyIssueStat()
    {
        $startDate = now()->subDays(7);
        $endDate = now();

        $issueStats = DB::table('issue_reports')
            ->selectRaw('
                COUNT(*) as total,
                SUM(CASE WHEN status = "Open" THEN 1 ELSE 0 END) as open,
                SUM(CASE WHEN status = "In Progress" THEN 1 ELSE 0 END) as inprogress,
                SUM(CASE WHEN status = "Closed" THEN 1 ELSE 0 END) as closed,
                SUM(CASE WHEN status = "Resolved" THEN 1 ELSE 0 END) as resolved
            ')
            ->whereBetween('created_at', [$startDate, $endDate])
            ->first();

        return $issueStats;
    }
    public function render()
    {
        return view('livewire.dashboard.index', [
            'weeklyIssueStat' => $this->getWeeklyIssueStat(),
            'recentIssues' => IssueReport::with('category', 'createdBy', 'assignedTo')
                ->orderBy('created_at', 'desc')
                ->limit(5)
                ->get()
        ]);
    }
}
