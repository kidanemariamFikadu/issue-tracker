<?php

namespace App\Livewire\Issues;

use App\Models\Application;
use App\Models\Category;
use App\Models\User;
use Livewire\Attributes\Url;
use Livewire\Component;
use LivewireUI\Modal\ModalComponent;

class FilterIssues extends ModalComponent
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

    function filterIssues()
    {
        $this->dispatch('filter-issues', [
            'application' => $this->application,
            'category' => $this->category,
            'priority' => $this->priority,
            'status' => $this->status,
            'assignedTo' => $this->assignedTo,
        ]);
        $this->closeModal();
    }

    function clearFilters()
    {
        $this->dispatch('filter-issues', [
            'application' => "",
            'category' => "",
            'priority' => "",
            'status' => "",
            'assignedTo' => "",
        ]);
        $this->closeModal();
    }

    public function render()
    {
        return view(
            'livewire.issues.filter-issues',
            [
                'applications' => Application::orderBy('name')->get(['name', 'id']),
                'categories' => Category::orderBy('name')->get(['name', 'id']),
                'priorities' => ['Not set', 'Low', 'Medium', 'High'],
                'statuses' => ['Open', 'In Progress', 'Resolved', 'Closed'],
                'users' =>  User::role(['admin','dev'])->orderBy('name', 'asc')->get(),
            ]
        );
    }
}
