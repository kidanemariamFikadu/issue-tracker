<?php

namespace App\Livewire\Issues;

use App\Models\Application;
use App\Models\Category;
use App\Models\IssueReport;
use App\Models\User;
use Livewire\Component;
use LivewireUI\Modal\ModalComponent;

class ManageIssues extends ModalComponent
{
    public $issuesId;
    public $application;
    public $category;
    public $priority;
    public $status;


    public function mount($issueId = null)
    {
        $this->issuesId = $issueId;
        if ($issueId) {
            $issue = IssueReport::find($this->issuesId);
            $this->application = $issue->application_id;
            $this->category = $issue->category_id;
            $this->priority = $issue->priority;
            $this->status = $issue->status;
        }
    }

    public function updateIssue()
    {
        $this->validate([
            'category' => 'required|exists:categories,id',
            'application' => 'required|exists:applications,id',
            'priority' => 'required',
            'status' => 'required',
        ]);

        $issue = IssueReport::find($this->issuesId);
        // $issue->update([
        //     'category_id' => $this->category,
        //     'application_id'=>$this->application,
        //     'priority'=>$this->priority,
        //     'status'=>$this->status,
        // ]);

        $issue->category_id = $this->category;
        $issue->application_id = $this->application;
        $issue->priority = $this->priority;
        $issue->status = $this->status;
        if ($issue->status == 'Resolved' || $issue->status == 'Closed') {
            $issue->update(['resolved_at' => now()]);
        }
        $issue->save();

        $this->dispatch('show-toast', ['type' => 'success', 'message' => 'Issue updated successfully']);
        $this->dispatch('issue-detail-changed');
        $this->closeModal();
    }

    public function render()
    {
        return view('livewire.issues.manage-issues', [
            'applications' => Application::orderBy('name', 'asc')->get(),
            'categories' => Category::orderBy('name', 'asc')->get(),
            'issue' => IssueReport::find($this->issuesId),
        ]);
    }
}
