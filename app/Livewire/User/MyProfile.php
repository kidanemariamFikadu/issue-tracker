<?php

namespace App\Livewire\User;

use Illuminate\Support\Facades\Auth;
use Livewire\Component;

class MyProfile extends Component
{
    public $name;
    public $email;
    public $password;
    public $password_confirmation;

    public $user;

    function mount()
    {
        $user = Auth::user();

        $this->name = $user->name;
        $this->email = $user->email;
        $this->user = $user;
    }

    function updateProfile()
    {
        $this->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|max:255',
        ]);

        $this->user->name = $this->name;
        $this->user->email = $this->email;

        if ($this->password) {
            $this->validate([
                'password' => 'required|string|min:8|confirmed',
            ]);

            $this->user->password = bcrypt($this->password);
        }

        $this->user->save();

        $this->dispatch('show-toast', ['type' => 'success', 'message' => 'user updated successfully']);
        // $this->dispatchBrowserEvent('show-toast', ['message' => 'user updated successfully!']);

        $this->dispatch('user-changed');
    }


    public function render()
    {
        return view('livewire.user.my-profile');
    }
}
