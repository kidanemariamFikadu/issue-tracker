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
use PHPUnit\Runner\Baseline\Issue;

class IssueDetail extends Component
{
    #[Validate('required|')]
    public $newComment;
    public IssueReport $issue;

    #[On('issue-detail-changed')]
    function mount()
    {
        $issue = request()?->route('issue');
        if ($issue instanceof IssueReport) {
            $this->issue = $issue;
        } else {
            
        }
    }

    public function addComment(){
        $this->validate();
        $this->issue->comments()->create([
            'comment'=>$this->newComment,
            'created_by'=>Auth::user()->id,
        ]);
        $this->newComment='';
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
