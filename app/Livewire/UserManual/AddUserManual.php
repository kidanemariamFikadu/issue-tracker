<?php

namespace App\Livewire\UserManual;

use App\Models\UserManual;
use LivewireUI\Modal\ModalComponent;

class AddUserManual extends ModalComponent
{
    public $sequence;
    public $title;
    public $url;

    public UserManual $userManual;

    function mount($userManualId = null)
    {
        $this->userManual = $userManualId ? UserManual::find($userManualId) : new UserManual();
        $this->sequence = $this->userManual->sequence;
        $this->title = $this->userManual->title;
        $this->url = $this->userManual->url;
    }

    protected $rules = [
        'title' => 'required|string|max:255',
        'url' => 'required|url',
    ];


    public function addUserManual()
    {
        $this->validate();
        // Check for duplicate sequence only if the sequence has changed
        if ($this->userManual->exists && $this->userManual->sequence != $this->sequence) {
            $duplicateSequence = UserManual::where('sequence', $this->sequence)->first();
            if ($duplicateSequence) {
            $this->addError('sequence', 'Sequence already exists');
            return;
            }
        } elseif (!$this->userManual->exists) {
            $duplicateSequence = UserManual::where('sequence', $this->sequence)->first();
            if ($duplicateSequence) {
            $this->addError('sequence', 'Sequence already exists');
            return;
            }
        }

        if ($this->userManual) {
            $this->userManual->update([
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
        $lastSquence = UserManual::orderBy('sequence', 'desc')->first();
        return view('livewire.user-manual.add-user-manual', [
            $this->sequence = $lastSquence ? $lastSquence->sequence + 1 : 1,
        ]);
    }
}
