<?php

namespace App\Livewire\Settings;

use App\Models\User;
use Livewire\Attributes\Validate;
use Livewire\Component;
use LivewireUI\Modal\ModalComponent;
use Spatie\Permission\Models\Role;

class EditUser extends ModalComponent
{
    public $name;
    public $email;
    public $role;

    public $userId;

    public $password;

    public $password_confirmation;

    public function mount($userId = null)
    {
        $this->userId = $userId;
        if ($userId) {
            $user = User::find($userId);
            $this->name = $user->name;
            $this->email = $user->email;
            $this->role = $user->role?->name;
        }
    }

    function createUser()
    {
        if ($this->userId) {
            $this->validate([
                'name' => 'required',
                // 'email' => 'required|email|unique:users,email,except,userId',
                'role' => 'required',
            ]);
            $user = User::find($this->userId);
            $user->update([
                'name' => $this->name,
            ]);
            $user->syncRoles([$this->role]);
            $this->dispatch('show-toast', ['type' => 'success', 'message' => 'User updated successfully']);
            $this->dispatch('user-changed');
            $this->closeModal();
        } else {
            $this->validate([
                'name' => 'required',
                'email' => 'required|email|unique:users,email',
                'role' => 'required',
                'password' => 'required|min:3|confirmed',
            ]);
           $user= User::create([
                'name' => $this->name,
                'email' => $this->email,
                'password' => $this->password,
            ]);

            $user->assignRole($this->role);
            $this->dispatch('show-toast', ['type' => 'success', 'message' => 'User created successfully']);
            $this->dispatch('user-changed');
            $this->name = '';
            $this->email = '';
            $this->role = '';
            $this->closeModal();
        }
        $this->userId = '';

    }


    public function render()
    {
        return view('livewire.settings.edit-user', [
            'roles' => Role::get(['id', 'name']),
        ]);
    }
}
