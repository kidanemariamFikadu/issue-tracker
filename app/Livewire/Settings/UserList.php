<?php

namespace App\Livewire\Settings;

use App\Models\User;
use Livewire\Attributes\On;
use Livewire\Attributes\Url;
use Livewire\Component;

class UserList extends Component
{
    #[Url(history: true)]
    public $search = '';

    #[Url(history: true)]
    public $application = '';

    #[Url(history: true)]
    public $sortBy = 'name';

    #[Url(history: true)]
    public $sortDir = 'ASC';

    #[Url()]
    public $perPage = 10;

    #[On('user-changed')]
    public function gradeChanged()
    {
    }

    public function render()
    {
        return view('livewire.settings.user-list',[
            'users' => User::paginate(),
        ]);
    }
}
