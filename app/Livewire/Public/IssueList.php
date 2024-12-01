<?php

namespace App\Livewire\Public;

use App\Models\IssueReport;
use Livewire\Attributes\Layout;
use Livewire\Component;
use Livewire\WithPagination;

#[Layout('layouts.guest')]
class IssueList extends Component
{
    use WithPagination;

    public $search = '';

    protected $updatesQueryString = ['search'];
    
    public function updatingSearch()
    {
        $this->resetPage();
    }

    public function render()
    {
        $issues = IssueReport::query()
            ->when($this->search, fn($query) => 
                $query->where('issue', 'like', '%' . $this->search . '%')
                      ->orWhere('description', 'like', '%' . $this->search . '%')
            )
            ->paginate(10);

        return view('livewire.public.issue-list', ['issues' => $issues]);
    }
}
