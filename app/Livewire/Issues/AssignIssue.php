<?php

namespace App\Livewire\Issues;

use App\Models\IssueReport;
use App\Models\User;
use Livewire\Component;
use LivewireUI\Modal\ModalComponent;

class AssignIssue extends ModalComponent
{
    public $issueId;
    public $assignedTo;

    public function mount($issueId)
    {
        $this->issueId = $issueId;
    }

    public function assignIssue()
    {
        $this->validate([
            'assignedTo' => 'required',
        ]);

        $issue = IssueReport::find($this->issueId);
        $issue->update([
            'assigned_to' => $this->assignedTo,
        ]);

        $this->dispatch('show-toast', ['type' => 'success', 'message' => 'issue updated successfully']);
        $this->dispatch('issue-detail-changed');
        $this->closeModal();
    }

    public function render()
    {
        return view('livewire.issues.assign-issue', [
            'users' => User::role(['admin','dev'])->orderBy('name', 'asc')->get(),
            'issue' => IssueReport::find($this->issueId),
        ]);
    }
}
