<?php

namespace App\Livewire\Settings;

use App\Models\Category as ModelsCategory;
use Livewire\Attributes\Validate;
use LivewireUI\Modal\ModalComponent;

class Category extends ModalComponent
{

    #[Validate('required|min:3|max:255|unique:categories,name')]
    public $name;
    public $categoryId;

    public function mount($categoryId = null)
    {
        $this->categoryId = $categoryId;
        if ($categoryId) {
            $category = ModelsCategory::find($categoryId);
            $this->name = $category->name;
        }
    }

    public function createCategory(){
        $this->validate();
        if($this->categoryId){
            $checkDuplicate = ModelsCategory::where('name', $this->name)->where('id', '!=', $this->categoryId)->first();
            if($checkDuplicate){
                $this->dispatch('show-toast', ['type' => 'error', 'content' => 'Category already exists']);
                return;
            }
            $category = ModelsCategory::find($this->categoryId);
            $category->update(['name' => $this->name]);
            $this->dispatch('show-toast', ['type' => 'success', 'message' => 'Category updated successfully']);
            $this->dispatch('category-changed');
            $this->closeModal();
        }else{
            $checkDuplicate = ModelsCategory::where('name', $this->name)->first();
            if($checkDuplicate){
                $this->dispatch('show-toast', ['type' => 'error', 'message' => 'Category already exists']);
                return;
            }else{
                ModelsCategory::create(['name' => $this->name]);
                $this->dispatch('show-toast', ['type' => 'success', 'message' => 'Category created successfully']);
                $this->name = '';
                $this->dispatch('category-changed');
                $this->closeModal();
            }
        }
    }
    public function render()
    {
        return view('livewire.settings.category');
    }
}
