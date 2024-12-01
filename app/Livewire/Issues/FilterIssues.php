<?php

namespace App\Livewire\Issues;

use App\Models\Application;
use Livewire\Component;
use LivewireUI\Modal\ModalComponent;

class FilterIssues extends ModalComponent
{
    public $application;
    public $category;
    public $priority;
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
