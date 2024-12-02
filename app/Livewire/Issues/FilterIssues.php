<?php

namespace App\Livewire\Issues;

use App\Models\Application;
use Livewire\Attributes\Url;
use Livewire\Component;
use LivewireUI\Modal\ModalComponent;

class FilterIssues extends ModalComponent
{
    #[Url(history: true)]
    public $application;
    #[Url(history: true)]
    public $category;
    #[Url(history: true)]
    public $priority;
    #[Url(history: true)]
    public $status;

    function filterIssues()
    {
        $this->dispatch('filter-issues', [
            'application' => $this->application,
            'category' => $this->category,
            'priority' => $this->priority,
            'status' => $this->status,
        ]);
        $this->closeModal();
    }

    public function render()
    {
        return view(
            'livewire.issues.filter-issues',
            [
                'applications' => Application::orderBy('name')->get(['name', 'id']),
                'categories' => Application::orderBy('name')->get(['name', 'id']),
                'priorities' => ['Not set', 'Low', 'Medium', 'High'],
                'statuses' => ['Open', 'In Progress', 'Resolved', 'Closed'],
            ]
        );
    }
}
