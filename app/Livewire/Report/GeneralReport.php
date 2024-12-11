<?php

namespace App\Livewire\Report;

use App\Models\Application;
use App\Models\IssueReport;
use Livewire\Attributes\On;
use Livewire\Component;

class GeneralReport extends Component
{
    public $period = 'week';
    public $weekDate;

    public $month;
    public $monthYear;
    public $year;

    public $reportData;
    public $application;

    public function mount()
    {
        $this->weekDate = \Carbon\Carbon::now();
        $this->issuesPerPeriod();
    }

    #[On('periodChanged')]
    function changeForm()
    {

    }

    private function issuesPerPeriod()
    {
        $query = IssueReport::query();

        // if ($this->period === 'day') {
        //     $query->whereBetween('created_at', [$start->startOfDay(), $end->endOfDay()]);
        //     $groupBy = 'HOUR(created_at)';
        //     $selectPeriod = "strftime('%Y-%m-%d %H:00:00', created_at) as period";
        // } else
        if ($this->period === 'week') {
            $start = $this->weekDate->copy()->startOfWeek();
            $end = $this->weekDate->copy()->endOfWeek();
            $query->whereBetween('created_at', [$start->startOfWeek(), $end->endOfWeek()]);
            $selectPeriod = "
        CASE strftime('%w', created_at)
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
        } elseif ($this->period === 'month') {
            $start = \Carbon\Carbon::createFromDate($this->monthYear, $this->month, 1)->startOfMonth();
            $end = \Carbon\Carbon::createFromDate($this->monthYear, $this->month, 1)->endOfMonth();
            $query->whereBetween('created_at', [$start, $end]);
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
        } elseif ($this->period === 'year') {
            $start = \Carbon\Carbon::createFromDate($this->year, 1, 1)->startOfYear();
            $end = \Carbon\Carbon::createFromDate($this->year, 1, 1)->endOfYear();
            $query->whereBetween('created_at', [$start, $end]);
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
        }

        if ($this->application) {
            $query->where('application_id', $this->application);
        }

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
        return view('livewire.report.general-report', [
            'applications' => Application::orderBy('name')->get(['id', 'name'])
        ]);
    }
}
