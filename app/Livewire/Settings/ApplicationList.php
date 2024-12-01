<?php

namespace App\Livewire\Settings;

use Livewire\Attributes\Computed;
use Livewire\Attributes\On;
use Livewire\Component;

class ApplicationList extends Component
{

    #[On('application-changed')]
    public function gradeChanged()
    {
    }

    #[Computed]
    public function getAplicationListProperty()
    {
        return \App\Models\Application::orderBy('name')->get();
    }

    public function removeApplication($applicationId)
    {
        $application = \App\Models\Application::find($applicationId);
        $application->delete();
        $this->dispatch('show-toast', ['type' => 'success', 'message' => 'Application deleted successfully']);
        $this->dispatch('application-changed');
    }


    public function render()
    {
        return view('livewire.settings.application-list');
    }
}
