<?php

namespace App\Livewire\Admin;

use App\Models\Category;
use Livewire\Component;
use Livewire\WithPagination;
use Illuminate\Support\Str;

class CategoryManagement extends Component
{
    use WithPagination;

    public $name;
    public $description;
    public $categoryId;
    public $isEditing = false;

    protected $rules = [
        'name' => 'required|min:3|max:255',
        'description' => 'nullable|max:1000'
    ];

    public function render()
    {
        return view('livewire.admin.category-management', [
            'categories' => Category::latest()->paginate(10)
        ]);
    }

    public function create()
    {
        $this->validate();

        Category::create([
            'name' => $this->name,
            'slug' => Str::slug($this->name),
            'description' => $this->description
        ]);

        $this->reset(['name', 'description']);
        session()->flash('message', 'Category created successfully.');
    }

    public function edit($id)
    {
        $category = Category::findOrFail($id);
        $this->categoryId = $id;
        $this->name = $category->name;
        $this->description = $category->description;
        $this->isEditing = true;
    }

    public function update()
    {
        $this->validate();

        $category = Category::findOrFail($this->categoryId);
        $category->update([
            'name' => $this->name,
            'slug' => Str::slug($this->name),
            'description' => $this->description
        ]);

        $this->reset(['name', 'description', 'categoryId', 'isEditing']);
        session()->flash('message', 'Category updated successfully.');
    }

    public function delete($id)
    {
        $category = Category::findOrFail($id);
        $category->delete();
        session()->flash('message', 'Category deleted successfully.');
    }

    public function cancel()
    {
        $this->reset(['name', 'description', 'categoryId', 'isEditing']);
    }
} 