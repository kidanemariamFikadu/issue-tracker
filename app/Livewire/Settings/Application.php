<?php

namespace App\Livewire\Settings;

use App\Models\Application as ModelsApplication;
use Livewire\Attributes\Validate;
use LivewireUI\Modal\ModalComponent;

class Application extends ModalComponent
{
    #[Validate('required|min:3|max:255|unique:applications,name')]
    public $name;

    public $applicationId;

    public function mount($applicationId = null)
    {
        $this->applicationId = $applicationId;
        if ($applicationId) {
            $application = ModelsApplication::find($applicationId);
            $this->name = $application->name;
        }
    }

    public function createApplication()
    {
        $this->validate();
        if ($this->applicationId) {
            $checkDuplicate = ModelsApplication::where('name', $this->name)->where('id', '!=', $this->applicationId)->first();
            if ($checkDuplicate) {
                $this->dispatch('show-toast', ['type' => 'error', 'message' => 'application already exists']);
                return;
            }

            $application = ModelsApplication::find($this->applicationId);
            $application->update(['name' => $this->name]);
            $this->dispatch('show-toast', ['type' => 'success', 'message' => 'application updated successfully']);
            $this->dispatch('application-changed');
            $this->closeModal();
        } else {

            $checkDuplicate = ModelsApplication::where('name', $this->name)->first();
            if ($checkDuplicate) {
                $this->dispatch('show-toast', ['type' => 'error', 'message' => 'application already exists']);
                return;
            } else {
                ModelsApplication::create(['name' => $this->name]);
                $this->dispatch('show-toast', ['type' => 'success', 'message' => 'application created successfully']);
                $this->name = '';
                $this->dispatch('application-changed');
                $this->closeModal();
            }
        }
    }

    public function render()
    {
        return view('livewire.settings.application');
    }
}
