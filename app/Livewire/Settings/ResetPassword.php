<?php

namespace App\Livewire\Settings;

use App\Models\User;
use LivewireUI\Modal\ModalComponent;

class ResetPassword extends ModalComponent
{
    public User $user;

    public $password;
    public $password_confirmation;

    public function mount($userId)
    {
        $this->user = User::find($userId);
    }

    function resetPassword()
    {
        $this->validate([
            'password' => 'required|confirmed|min:8',
        ]);

        $this->user->update([
            'password' => $this->password,
        ]);

        $this->dispatch('show-toast', ['type' => 'success', 'message' => 'User updated successfully']);
        $this->dispatch('user-changed');
        $this->password = '';
        $this->password_confirmation = '';
        $this->closeModal();
    }

    public function render()
    {
        return view('livewire.settings.reset-password');
    }
}
