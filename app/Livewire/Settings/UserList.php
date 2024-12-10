<?php

namespace App\Livewire\Settings;

use App\Models\User;
use Livewire\Attributes\On;
use Livewire\Attributes\Url;
use Livewire\Component;
use Illuminate\Support\Str;

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

    #[Url(history: true)]
    public $perPage = 10;

    #[Url(history: true)]
    public $role = '';

    protected $queryString = ['page' => ['as' => 'userPage']];

    #[On('user-changed')]
    public function userChanged()
    {
    }

    public function setSortBy($sortByField)
    {

        if ($this->sortBy === $sortByField) {
            $this->sortDir = ($this->sortDir == "ASC") ? 'DESC' : "ASC";
            return;
        }

        $this->sortBy = $sortByField;
        $this->sortDir = 'DESC';
    }


    public function render()
    {
        return view('livewire.settings.user-list', [
            'users' => User::search($this->search)
                ->when($this->role !== '', function ($query) {
                    $query->role([$this->role]);
                })
                ->orderBy($this->sortBy, $this->sortDir)
                ->paginate($this->perPage)
        ]);
    }
}
