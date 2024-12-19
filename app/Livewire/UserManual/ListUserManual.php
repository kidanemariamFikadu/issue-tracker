<?php

namespace App\Livewire\UserManual;

use App\Models\UserManual;
use Livewire\Attributes\On;
use Livewire\Component;

class ListUserManual extends Component
{
    public $search;

    #[On('manual-changed')]
    public function manualChanged()
    {
    }
    
    public function render()
    {
        return view(
            'livewire.user-manual.list-user-manual',
            ['userManuals' => UserManual::search($this->search)->orderBy('sequence')->get()]
        );
    }
}
