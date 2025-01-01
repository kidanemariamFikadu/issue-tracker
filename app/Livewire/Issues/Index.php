<?php

namespace App\Livewire\Issues;

use App\Models\Application;
use App\Models\IssueReport;
use Illuminate\Support\Facades\Auth;
use Livewire\Attributes\Computed;
use Livewire\Attributes\On;
use Livewire\Attributes\Url;
use Livewire\Component;

class Index extends Component
{
    #[Url(history: true)]
    public $search = '';

    #[Url(history: true)]
    public $application = '';
    #[Url(history: true)]
    public $priority = '';
    #[Url(history: true)]
    public $status = '';
    #[Url(history: true)]
    public $category = '';

    #[Url(history: true)]
    public $sortBy = 'created_at';

    #[Url(history: true)]
    public $sortDir = 'DESC';

    #[Url(history: true)]
    public $assignedTo;

    #[Url(history: true)]
    public $perPage = 10;

    protected $listeners = ['filter-issues' => 'handleFilterIssues'];

    public function handleFilterIssues($data)
    {
        // Handle the received data here
        $this->application = $data['application'];
        $this->category = $data['category'];
        $this->priority = $data['priority'];
        $this->status = $data['status'];
        $this->assignedTo = $data['assignedTo'];
        // $this->search();
    }


    public $myIssues = false; // Determines if the filter is active

    public function toggleMyIssues()
    {
        $this->myIssues = !$this->myIssues; // Toggle the filter state
    }

    public $assignedToMe = false; // Determines if the filter is active

    public function toggleAssignedToMe()
    {
        $this->assignedToMe = !$this->assignedToMe; // Toggle the filter state
    }

    #[On('issue-changed')]
    public function issueChanged()
    {
    }

    #[Computed]
    public function getApplicationListProperty()
    {
        return Application::orderBy('name', 'asc')->get();
    }

    public function setSortBy($sortByField)
    {

        if ($this->sortBy === $sortByField) {
            $this->sortDir = ($this->sortDir == "ASC") ? 'DESC' : "ASC";
            return;
        }

        $this->sortBy = $sortByField;
        $this->sortDir = 'DESC';
    }

    public function getIssueListProperty()
    {

        $issueQuery = $this->queryIssues();
        return $issueQuery
            ->orderBy($this->sortBy, $this->sortDir)
            ->paginate($this->perPage);
    }

    function queryIssues()
    {
        $issueQuery = IssueReport::search($this->search)
            ->when($this->application !== '', function ($query) {
                $query->where('application_id', $this->application);
            })
            ->when($this->category !== '', function ($query) {
                $query->where('category_id', $this->category);
            })
            ->when($this->priority !== '', function ($query) {
                $query->where('priority', $this->priority);
            })
            ->when($this->status !== '', function ($query) {
                $query->where('status', $this->status);
            })
            ->when($this->search !== '', function ($query) {
                $query->where('issue', 'like', "%{$this->search}%");
            });

        if ($this->myIssues) {
            $issueQuery->where('created_by', Auth::user()->id);
        }

        if ($this->assignedToMe) {
            $issueQuery->where('assigned_to', Auth::user()->id);
        }

        if ($this->assignedTo) {
            $issueQuery->where('assigned_to', $this->assignedTo);
        }
        return $issueQuery;
    }

    public function exportIssues()
    {
        $filename = 'issues-report-' . now()->format('Y-m-d') . '.csv';
        $headers = [
            'Content-Type' => 'text/csv',
            'Content-Disposition' => 'attachment; filename="' . $filename . '"',
        ];
        $issueQuery = $this->queryIssues();

        $issues = $issueQuery->get();

        $callback = function () use ($issues) {
            $file = fopen('php://output', 'w');
            fputcsv($file, ['Issue', 'Description', 'Application', 'Category', 'Priority', 'Status', 'Created At', 'Updated At', 'Created By', 'Assigned To']);

            foreach ($issues as $row) {
                fputcsv($file, [
                    $row->issue,
                    $row->description,
                    $row->application?->name,
                    $row->category?->name,
                    $row->priority,
                    $row->status,
                    $row->created_at,
                    $row->updated_at,
                    $row->createdBy?->name,
                    $row->assignedTo?->name,
                ]);
            }

            fclose($file);
        };

        return response()->stream($callback, 200, $headers);
    }

    public function render()
    {
        $issueQuery = IssueReport::search($this->search)
            ->when($this->application !== '', function ($query) {
                $query->where('application_id', $this->application);
            })
            ->when($this->category !== '', function ($query) {
                $query->where('category_id', $this->category);
            })
            ->when($this->priority !== '', function ($query) {
                $query->where('priority', $this->priority);
            })
            ->when($this->status !== '', function ($query) {
                $query->where('status', $this->status);
            });

        if ($this->myIssues) {
            $issueQuery->where('created_by', Auth::user()->id);
        }

        if ($this->assignedToMe) {
            $issueQuery->where('assigned_to', Auth::user()->id);
        }

        if ($this->assignedTo) {
            $issueQuery->where('assigned_to', $this->assignedTo);
        }

        return view('livewire.issues.index', [
            'issueList',
            $issueQuery
                ->orderBy($this->sortBy, $this->sortDir)
                ->paginate($this->perPage)
        ]);
    }
}
