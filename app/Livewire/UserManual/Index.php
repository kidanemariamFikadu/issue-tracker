<?php

namespace App\Livewire\UserManual;

use App\Models\UserManual;
use Livewire\Component;

class Index extends Component
{

    public $search;

    public function render()
    {
        return view(
            'livewire.user-manual.index',
            [
                'userManuals' => UserManual::search($this->search)->orderBy('sequence')->get(),
            ]
        );
    }
}
