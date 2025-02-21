<?php

namespace App\Livewire\Issues;

use App\Models\Application;
use App\Models\Category;
use App\Models\IssueReport;
use App\Models\User;
use App\Models\LershaAgent;
use App\Notifications\Issue\IssueCreatedNotification;
use App\Notifications\Issue\IssueUpdatedNotification;
use Illuminate\Support\Facades\Auth;
use Livewire\Attributes\Validate;
use Livewire\Component;
use Livewire\Features\SupportFileUploads\WithFileUploads;
use LivewireUI\Modal\ModalComponent;

class CreateIssue extends ModalComponent
{
    use WithFileUploads;

    #[Validate('required|exists:applications,id')]
    public $application;

    #[Validate('required|min:3|max:255')]
    public $issue;

    #[Validate('required|min:3')]
    public $description;

    public $attachments = []; // Holds all file attachments
    public $uploadedImages = []; // Holds preview URLs for the files

    public $issueId;
    public $agentId;

    public function mount($issueId = null)
    {
        $this->issueId = $issueId;

        if ($this->issueId) {
            $issue = IssueReport::find($this->issueId);
            $this->application = $issue->application_id;
            $this->issue = $issue->issue;
            $this->description = $issue->description;
            $this->agentId = $issue->agent_id;
            // $this->uploadedImages = $issue->attachments->pluck('url')->toArray();
        }
    }

    // Lifecycle hook to handle file updates
    public function updatedAttachments()
    {
        foreach ($this->attachments as $key => $attachment) {
            $this->validate([
                'attachments.' . $key => 'max:10240', // 10MB Max
            ]);
            $this->uploadedImages[count($this->uploadedImages)] = $attachment;
        }
    }

    public function removeAttachment($index)
    {
        unset($this->attachments[$index]); // Remove the file
        unset($this->uploadedImages[$index]); // Remove its preview
        $this->attachments = array_values($this->attachments); // Reindex array
        $this->uploadedImages = array_values($this->uploadedImages); // Reindex preview array
    }

    public function createIssue()
    {
        $this->validate();
        $next = IssueReport::latest()->first()->id;
        if (!$this->issueId) {
            $issueReport = IssueReport::create([
                'application_id' => $this->application,
                'created_by' => Auth::user()->id,
                'issue' => $this->issue,
                'description' => $this->description,
                'agent_id' => $this->agentId,
                'issue_number' => 'IR-' . str_pad($next+1, 5, '0', STR_PAD_LEFT),
            ]);

            // Save attachments
            foreach ($this->uploadedImages as $attachment) {
                $path = $attachment->store('attachments', 'public');
                $issueReport->attachments()->create(['url' => $path]);
            }
            $admins = $this->getAdmins();

            foreach ($admins as $admin) {
                if ($admin->id !== Auth::id()) {
                    $admin->notify(new IssueCreatedNotification($issueReport));
                }
            }

            // Reset form
            $this->reset(['issue', 'attachments', 'uploadedImages']);

            $this->dispatch('show-toast', ['type' => 'success', 'message' => 'Issue created successfully']);
        } else {
            $issueReport = IssueReport::find($this->issueId);
            $issueReport->update([
                'application_id' => $this->application,
                'issue' => $this->issue,
                'description' => $this->description,
                'agent_id' => $this->agentId,
            ]);

            // Save attachments
            foreach ($this->uploadedImages as $attachment) {
                $path = $attachment->store('attachments', 'public');
                $issueReport->attachments()->create(['url' => $path]);
            }

            $assignedTo = $issueReport->assignedTo;
            $createdBy = $issueReport->createdBy;

            if ($assignedTo && $assignedTo->id !== Auth::id() && $createdBy->id !== Auth::id()) {
                $assignedTo->notify(new IssueUpdatedNotification($issueReport));
                $createdBy->notify(new IssueUpdatedNotification($issueReport));
            } elseif ($assignedTo && $assignedTo->id !== Auth::id()) {
                $assignedTo->notify(new IssueUpdatedNotification($issueReport));
            } elseif ($createdBy->id !== Auth::id()) {
                $createdBy->notify(new IssueUpdatedNotification($issueReport));
            }

            // Reset form
            $this->reset(['issue', 'attachments', 'uploadedImages']);

            $this->dispatch('show-toast', ['type' => 'success', 'message' => 'Issue updated successfully']);
        }
        $this->dispatch('issue-changed');
        $this->closeModal();
    }

    public function getAdmins()
    {
        return User::role(['admin'])->orderBy('name', 'asc')->get();
    }

    public function render()
    {
        return view('livewire.issues.create-issue', [
            'applications' => Application::orderBy('name', 'asc')->get(),
            'categories' => Category::orderBy('name', 'asc')->get(),
            'agents' => LershaAgent::orderBy('first_name', 'asc')->get(),
        ]);
    }
}
