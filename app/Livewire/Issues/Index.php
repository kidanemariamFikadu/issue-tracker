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
    public $sortBy = 'name';

    #[Url(history: true)]
    public $sortDir = 'ASC';
    
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
        
        // if(Auth::user()->role('admin') ){
        //     $issueQuery->when($this->assignedTo !== '', function ($query) {
        //         $query->where('assignedTo', $this->assignedTo);
        //     });
        // }

        if ($this->myIssues) {
            $issueQuery->where('created_by', Auth::user()->id);
        }

        if ($this->assignedToMe) {
            $issueQuery->where('assigned_to', Auth::user()->id);
        }

        if($this->search){
            $issueQuery->where('issue', 'like', '%' . $this->search . '%');
                    //    ->orWhere('description', 'like', '%' . $this->search . '%');
        }

        return $issueQuery
            ->orderBy($this->sortBy, $this->sortDir)
            ->paginate($this->perPage);
    }

    public function render()
    {
        return view('livewire.issues.index', ['issueList', $this->issueList]);
    }
}
