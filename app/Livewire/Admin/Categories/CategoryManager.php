<?php

namespace App\Livewire\Admin\Categories;

use App\Models\Category;
use Livewire\Component;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Auth;
use Livewire\WithFileUploads;


class CategoryManager extends Component
{
    use WithFileUploads;

    public $categories = [];
    public $category_id;
    public $name = '';
    public $meta_title = '';
    public $meta_description = '';
    public $keywords = '';
    public $position = 1;
    public $active = false;
    public $image_desktop;
    public $image_desktop_upload;
    public $search = '';
    public $sortField = '';
    public $sortDirection = '';
    public $showModal = false;

    protected $rules = [
        'name' => 'required|max:150',
        'meta_title' => 'nullable|max:150',
        'meta_description' => 'nullable|max:500',
        'keywords' => 'nullable|max:500',
        'position' => 'required|integer',
        'active' => 'boolean',
    ];

    protected $messages = [
        'name.required' => 'El nombre es obligatorio.',
        'name.unique' => 'El nombre ya está en uso.',
        'image_desktop_upload.required' => 'La imagen es obligatoria.',
    ];

    public function updatedSearch()
    {
        $this->loadCategories();
    }


     public function render()
    {
        $this->loadCategories();
        return view('livewire.admin.categories.category-manager')->layout('components.layouts.admin');
    }


    public function loadCategories()
    {
        $query = Category::query();

        if ($this->search) {
            $query->where('name', 'like', "%{$this->search}%");
        }

        if ($this->sortField) {
            $query->orderBy($this->sortField, $this->sortDirection);
        }

        $this->categories = $query->orderBy('position')->get();
    }

    public function openModal($id = null)
    {
        $this->resetValidation();
        $this->reset(['category_id', 'name', 'meta_title', 'meta_description', 'keywords', 'position', 'active', 'image_desktop', 'image_desktop_upload']);

        if ($id) {
            $category = Category::findOrFail($id);
            $this->category_id = $category->id;
            $this->name = $category->name;
            $this->meta_title = $category->meta_title;
            $this->meta_description = $category->meta_description;
            $this->keywords = $category->keywords;
            $this->position = $category->position;
            $this->active = $category->active;
            $this->image_desktop = $category->image_desktop;
        } else {
            $this->position = Category::max('position') + 1 ?? 1;
        }

        $this->showModal = true;
    }

    public function save()
    {
        $rules = $this->rules;
        $rules['name'] .= $this->category_id ? (',name,' . $this->category_id) : '|unique:categories,name';

        if (!$this->category_id || $this->image_desktop_upload) {
            $rules['image_desktop_upload'] = 'required|image|mimes:jpeg,png,jpg|dimensions:min_width=800,min_height=800,max_width=1200,max_height=1200|max:1024';
        }

        $this->validate($rules);

        $imagePath = $this->image_desktop;
        if ($this->image_desktop_upload) {
            $filename = ($this->category_id ? 'dsk-' : 'bg-') . Str::slug($this->name) . '.' . $this->image_desktop_upload->extension();
            $imagePath = $this->image_desktop_upload->storeAs('categorias', $filename);
        }

        Category::updateOrCreate(
            ['id' => $this->category_id],
            [
                'name' => $this->name,
                'slug' => Str::slug($this->name),
                'meta_title' => $this->meta_title,
                'meta_description' => $this->meta_description,
                'keywords' => $this->keywords,
                'image_desktop' => $imagePath,
                'position' => $this->position,
                'active' => $this->active,
            ]
        );

        $this->showModal = false;
        $this->loadCategories();
        $this->dispatch('show-alert', title: '¡Guardado!', message: 'Categoría registrada correctamente');
    }

    public function delete($id)
    {
        $category = Category::findOrFail($id);
        if (Auth::user()->can('eliminar categorias')) {
            $category->stockKeepingUnits()->count() == 0 ? $category->forceDelete() : $category->delete();
            $this->loadCategories();
            $this->dispatch('show-alert', title: 'Eliminado', message: 'Categoría eliminada');
        }
    }

    public function toggleActive($id)
    {
        $category = Category::findOrFail($id);
        $category->active = !$category->active;
        $category->save();
        $this->loadCategories();
    }

    public function sortBy($field)
    {
        $this->sortDirection = $this->sortField === $field
            ? ($this->sortDirection === 'asc' ? 'desc' : 'asc')
            : 'asc';

        $this->sortField = $field;
        $this->loadCategories();
    }
}
