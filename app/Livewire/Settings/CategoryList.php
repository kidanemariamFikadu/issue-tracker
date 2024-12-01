<?php

namespace App\Livewire\Settings;

use Livewire\Attributes\Computed;
use Livewire\Attributes\On;
use Livewire\Component;

class CategoryList extends Component
{
    #[On('category-changed')]
    public function categoryChanged()
    {
    }
    #[Computed]
    public function getCategoryListProperty()
    {
        return \App\Models\Category::orderBy('name')->get();
    }

    public function removeCategory($categoryId)
    {
        $category = \App\Models\Category::find($categoryId);
        $category->delete();
        $this->dispatch('show-toast', ['type' => 'success', 'message' => 'Category deleted successfully']);
        $this->dispatch('category-changed');
    }

    public function render()
    {
        return view('livewire.settings.category-list');
    }
}
