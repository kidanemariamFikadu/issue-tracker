<?php

namespace App\Livewire\Report;

use App\Models\IssueReport;
use App\Models\User;
use Livewire\Attributes\On;
use Livewire\Component;

class UserReport extends Component
{
    public $period = 'week';
    public $weekDate;

    public $month;
    public $monthYear;
    public $year;

    public $reportData;
    public $user=null;

    public function mount()
    {
        // $this->weekDate = \Carbon\Carbon::now();
        $this->issuesPerPeriod();
    }

    #[On('periodChanged')]
    function changeForm()
    {

    }

    private function issuesPerPeriod()
    {
        if (!$this->user) {
            return;
        }

        $query = IssueReport::query();
        $start = null;
        $end = null;
        $groupBy = '';
        $selectPeriod = '';

        switch ($this->period) {
            case 'week':
                $start = \Carbon\Carbon::parse($this->weekDate)->startOfWeek();
                $end = \Carbon\Carbon::parse($this->weekDate)->endOfWeek();
                $groupBy = "strftime('%d', created_at)";
                $selectPeriod = "CASE strftime('%w', created_at)
                    WHEN '0' THEN 'Sunday'
                    WHEN '1' THEN 'Monday'
                    WHEN '2' THEN 'Tuesday'
                    WHEN '3' THEN 'Wednesday'
                    WHEN '4' THEN 'Thursday'
                    WHEN '5' THEN 'Friday'
                    WHEN '6' THEN 'Saturday'
                END || ', ' || 
                CASE strftime('%m', created_at)
                    WHEN '01' THEN 'January'
                    WHEN '02' THEN 'February'
                    WHEN '03' THEN 'March'
                    WHEN '04' THEN 'April'
                    WHEN '05' THEN 'May'
                    WHEN '06' THEN 'June'
                    WHEN '07' THEN 'July'
                    WHEN '08' THEN 'August'
                    WHEN '09' THEN 'September'
                    WHEN '10' THEN 'October'
                    WHEN '11' THEN 'November'
                    WHEN '12' THEN 'December'
                END || ' ' || strftime('%Y', created_at) AS period";
                break;

            case 'month':
                $start = \Carbon\Carbon::createFromDate($this->monthYear, $this->month, 1)->startOfMonth();
                $end = \Carbon\Carbon::createFromDate($this->monthYear, $this->month, 1)->endOfMonth();
                $groupBy = "strftime('%d', created_at)";
                $selectPeriod = "strftime('%d', created_at)
                || ', ' || 
                CASE strftime('%m', created_at)
                    WHEN '01' THEN 'January'
                    WHEN '02' THEN 'February'
                    WHEN '03' THEN 'March'
                    WHEN '04' THEN 'April'
                    WHEN '05' THEN 'May'
                    WHEN '06' THEN 'June'
                    WHEN '07' THEN 'July'
                    WHEN '08' THEN 'August'
                    WHEN '09' THEN 'September'
                    WHEN '10' THEN 'October'
                    WHEN '11' THEN 'November'
                    WHEN '12' THEN 'December'
                END || ' ' || strftime('%Y', created_at) AS period";
                break;

            case 'year':
                $start = \Carbon\Carbon::createFromDate($this->year, 1, 1)->startOfYear();
                $end = \Carbon\Carbon::createFromDate($this->year, 1, 1)->endOfYear();
                $groupBy = 'MONTH(created_at)';
                $selectPeriod = "CASE strftime('%m', created_at)
                    WHEN '01' THEN 'January'
                    WHEN '02' THEN 'February'
                    WHEN '03' THEN 'March'
                    WHEN '04' THEN 'April'
                    WHEN '05' THEN 'May'
                    WHEN '06' THEN 'June'
                    WHEN '07' THEN 'July'
                    WHEN '08' THEN 'August'
                    WHEN '09' THEN 'September'
                    WHEN '10' THEN 'October'
                    WHEN '11' THEN 'November'
                    WHEN '12' THEN 'December'
                END ||', '|| strftime('%Y', created_at) AS period";
                break;
        }

        $query->whereBetween('created_at', [$start, $end])
              ->where('assigned_to', $this->user);

        $this->reportData = $query->selectRaw('COUNT(*) as total, 
              SUM(status = "Closed") as closed, 
              SUM(status = "Open") as open, 
              SUM(status = "In Progress") as in_progress, 
              SUM(status = "Resolved") as resolved, 
              ' . $selectPeriod)
            ->groupBy('period')
            ->orderBy('period')
            ->get()->toArray();
    }

    function generateReport()
    {
        $this->issuesPerPeriod();
    }

    public function render()
    {
        return view('livewire.report.user-report', [
            'users' => User::role(['admin', 'dev'])->orderBy('name', 'asc')->get(),
        ]);
    }
}
