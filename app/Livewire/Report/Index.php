<?php

namespace App\Livewire\Report;

use App\Models\IssueReport;
use Livewire\Component;

class Index extends Component
{
    public $period = 'month';
    public $from;
    public $to;

    public function mount()
    {
        $this->from = now()->subDays(7)->format('Y-m-d');
        $this->to = now()->format('Y-m-d');
    }

    private function issuesPerPeriod($period, $from, $to)
    {
        $query = IssueReport::query();

        if ($period === 'day') {
            $query->whereBetween('created_at', [$from->startOfDay(), $to->endOfDay()]);
            $groupBy = 'DATE(created_at)';
        } elseif ($period === 'week') {
            $query->whereBetween('created_at', [$from->startOfWeek(), $to->endOfWeek()]);
            $groupBy = 'DATE(created_at)';
        } elseif ($period === 'month') {
            $query->whereBetween('created_at', [$from->startOfMonth(), $to->endOfMonth()]);
            $groupBy = 'WEEK(created_at)';
        } elseif ($period === 'year') {
            $query->whereBetween('created_at', [$from->startOfYear(), $to->endOfYear()]);
            $groupBy = 'MONTH(created_at)';
        }

        return $query->selectRaw('COUNT(*) as total, 
                      SUM(status = "Closed") as closed, 
                      SUM(status = "Open") as open, 
                      SUM(status = "In Progress") as in_progress, 
                      SUM(status = "Resolved") as resolved, 
                      ' . $groupBy . ' as period')
            ->groupBy('period')
            ->get()->toArray();
    }



    public function render()
    {
        return view('livewire.report.index', [
            'data' => $this->issuesPerPeriod('day', now()->subDays(7), now())
        ]);
    }
}
