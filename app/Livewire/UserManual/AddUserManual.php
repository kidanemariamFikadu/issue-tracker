<?php

namespace App\Livewire\UserManual;

use App\Models\UserManual;
use LivewireUI\Modal\ModalComponent;

class AddUserManual extends ModalComponent
{
    public $sequence;
    public $title;
    public $url;
    public $userManualId;

    function mount($userManualId = null)
    {
        $this->userManualId = $userManualId;
        $lastSquence = UserManual::orderBy('sequence', 'desc')->first();
        $this->sequence = $lastSquence ? $lastSquence->sequence + 1 : 1;

        $userManual = $userManualId ? UserManual::find($userManualId) : new UserManual();
        if ($userManual->exists) {
            $this->sequence = $userManual->sequence;
            $this->title = $userManual->title;
            $this->url = $userManual->url;
        }

    }

    protected $rules = [
        'title' => 'required|string|max:255',
        'url' => 'required|url',
    ];


    public function addUserManual()
    {
        $this->validate();
        // Check for duplicate sequence only if the sequence has changed
        $duplicateSequence = UserManual::where('sequence', $this->sequence)
            ->where('id', '!=', $this->userManualId)
            ->first();
        if ($duplicateSequence) {
            $this->addError('sequence', 'Sequence already exists');
            return;
        }

        if ($this->userManualId) {
            $userManual= UserManual::find($this->userManualId);
            $userManual->update([
                'title' => $this->title,
                'url' => $this->url,
                'sequence' => $this->sequence,
            ]);
            $this->dispatch('show-toast', ['type' => 'success', 'message' => 'manual updated successfully']);
        } else {
            UserManual::create([
                'title' => $this->title,
                'url' => $this->url,
                'sequence' => $this->sequence,
            ]);
            $this->dispatch('show-toast', ['type' => 'success', 'message' => 'manual added successfully']);
        }

        $this->dispatch('manual-changed');
        $this->closeModal();
    }

    public function render()
    {
        return view('livewire.user-manual.add-user-manual');
    }
}
