<?php

namespace App\Livewire\Issues;

use App\Models\Application;
use App\Models\Category;
use App\Models\IssueReport;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Livewire\Attributes\On;
use Livewire\Attributes\Validate;
use Livewire\Component;
use Livewire\WithFileUploads;
use PHPUnit\Runner\Baseline\Issue;

class IssueDetail extends Component
{
    use WithFileUploads;
    #[Validate('required|')]
    public $newComment;
    public IssueReport $issue;

    public $attachments=[];
    public $uploadedImages=[];

    #[On('issue-detail-changed')]
    function mount()
    {
        $issue = request()?->route('issue');
        if ($issue instanceof IssueReport) {
            $this->issue = $issue;
        } else {
            
        }
    }

    #[On('issue-changed')]
    public function issueChanged()
    {
    }
    
    public function removeAttachment($index)
    {
        unset($this->attachments[$index]); // Remove the file
        unset($this->uploadedImages[$index]); // Remove its preview
        $this->attachments = array_values($this->attachments); // Reindex array
        $this->uploadedImages = array_values($this->uploadedImages); // Reindex preview array
    }


    public function updatedAttachments()
    {
        foreach ($this->attachments as $key => $attachment) {
            $this->validate([
                'attachments.' . $key => 'max:10240', // 10MB Max
            ]);
            $this->uploadedImages[count($this->uploadedImages)] = $attachment;
        }
    }

    public function addComment(){
        $this->validate([
            'newComment'=>'required|min:3'
        ]);

        $comment = $this->issue->comments()->create([
            'created_by'=>Auth::id(),
            'comment'=>$this->newComment
        ]);

        foreach ($this->attachments as $attachment) {
            $comment->attachments()->create([
                'url'=>$attachment->store('attachments','public')
            ]);
        }

        $this->attachments=[];
        $this->uploadedImages=[];
        $this->newComment='';
        $this->issue->refresh();
    }


    public function render()
    {
        return view('livewire.issues.issue-detail',[
            'applications'=>Application::orderBy('name','asc')->get(),
            'categories'=>Category::orderBy('name','asc')->get(),
            'users'=>User::orderBy('name','asc')->get(),
        ]
    );
    }
}
