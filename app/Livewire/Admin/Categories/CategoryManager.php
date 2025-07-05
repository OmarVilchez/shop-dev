<?php

namespace App\Livewire\Admin\Categories;

use App\Models\Category;
use Livewire\Component;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Livewire\WithFileUploads;
use Livewire\WithPagination;
use App\Helpers\Flash;
use CloudinaryLabs\CloudinaryLaravel\Facades\Cloudinary;


class CategoryManager extends Component
{
    use WithFileUploads;
    use WithPagination;


    // Propiedades para el modal
    public $category_id;
    public $name = '';
    public $title = '';
    public $description = '';
    public $meta_title = '';
    public $meta_description = '';
    public $keywords = '';
    public $icon = '';
    public $icon_upload;
    public $image_desktop;
    public $image_desktop_upload;
    public $image_mobile;
    public $image_mobile_upload;
    public $position = 1;
    public $active = false;
    public $parent_id = null; // Asumiendo que no se usa en este contexto, pero se deja por si acaso

    // Propiedades para la búsqueda y ordenación
    public $search = '';
    public $sortField = '';
    public $sortDirection = '';
    public $filterActive = '';
    public $filterType = '';

    // Propiedades para el modal
    public $showModal = false;
    public $showModalOpen = false;
    public string $tab = 'info'; // valor por defecto al abrir el modal


    protected $rules = [
        'name' => 'required|max:150',
        'title' => 'required|max:150',
        'description' => 'required|max:500',
        'meta_title' => 'nullable|max:150',
        'meta_description' => 'nullable|max:500',
        'keywords' => 'nullable|max:500',
        'position' => 'required|integer',
        'active' => 'boolean',
    ];

    protected $messages = [
        'name.required' => 'El nombre es obligatorio.',
        'name.unique' => 'El nombre ya está en uso.',
        'title.required' => 'El titulo es obligatorio.',
        'image_desktop_upload.required' => 'La imagen es obligatoria.',
    ];


    public function openModal($id = null,  $parent_id = null)
    {
        $this->resetValidation();
        $this->reset(['category_id', 'name', 'title', 'description', 'meta_title', 'meta_description', 'keywords', 'position', 'active', 'image_desktop', 'image_desktop_upload', 'parent_id']);

        if ($id) {
            $category = Category::findOrFail($id);
            $this->category_id = $category->id;
            $this->name = $category->name;
            $this->title = $category->title;
            $this->description = $category->description;
            $this->meta_title = $category->meta_title;
            $this->meta_description = $category->meta_description;
            $this->keywords = $category->keywords;
            $this->position = $category->position;
            $this->active = (bool) $category->active; // <-- Esto es clave
            $this->image_desktop = $category->image_desktop;
            $this->parent_id = $category->parent_id;
        } elseif ($parent_id) {
            $this->parent_id = $parent_id; // Para nueva subcategoría
            $this->position = Category::max('position') + 1 ?? 1;
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
            $rules['image_desktop_upload'] = 'required|image';
        }

        $this->validate($rules);

       $imagePath = $this->image_desktop;

        //Guardado de imagenes Local
        /* if ($this->image_desktop_upload) {
            $filename = ($this->category_id ? 'dsk-' : 'bg-') . Str::slug($this->name) . '.' . $this->image_desktop_upload->getClientOriginalExtension();
            $imagePath = $this->image_desktop_upload->storeAs('categorias', $filename, 'public');
        } */


        //Guardado de imagenes Cluodinary
        /*   $uploadedFile = cloudinary()->uploadApi()->upload(
            $this->image_desktop_upload->getRealPath(),
            [
                'folder' => 'categorias',
                'public_id' => Str::slug($this->name),
                'overwrite' => true,
                'resource_type' => 'image',
                'transformation' => [
                    'quality' => 'auto',
                    'fetch_format' => 'auto',
                ],
            ]
        );

        $imagePath = $uploadedFile['secure_url']; */


        if ($this->image_desktop_upload) {
            $imagePath = $this->uploadImageToCloudinary($this->image_desktop_upload, Str::slug($this->name));
        }


        // Solución al problema del select vacío
        if ($this->parent_id === '' || $this->parent_id === 0) {
            $this->parent_id = null;
        }

        Category::updateOrCreate(
            ['id' => $this->category_id],
            [
                'name' => $this->name,
                'title' => $this->title,
                'description' => $this->description,
                'slug' => Str::slug($this->name),
                'meta_title' => $this->meta_title,
                'meta_description' => $this->meta_description,
                'keywords' => $this->keywords,
                'image_desktop' => $imagePath,
                'parent_id' => $this->parent_id,
                'position' => $this->position,
                'active' => $this->active,
            ]
        );

        $this->reset('image_desktop_upload');
        $this->showModal = false;

        Flash::success('Categoría guardada exitosamente');
        //return redirect()->route('manager.catalog.categories.index');

       // $this->dispatch('show-alert', title: '¡Guardado!', message: 'Categoría registrada');

    }

    private function uploadImageToCloudinary($image, $slug)
    {
        /*   $response = cloudinary()->uploadApi()->upload(
            $image->getRealPath(),
            [
                'folder' => 'categorias',
                'public_id' => $slug,
                'overwrite' => true,
                'resource_type' => 'image',
                'transformation' => [
                    'quality' => 'auto',
                    'fetch_format' => 'auto',
                ],
            ]
        );

        return $response['secure_url']; */


        $response = Cloudinary::uploadApi()->upload(
            $image->getRealPath(),
            [
                'folder' => 'categorias',
                'public_id' => $slug,
                'overwrite' => true,
                'resource_type' => 'image',
                'transformation' => [
                    'quality' => 'auto',
                    'fetch_format' => 'auto',
                ],
            ]
        );

        return $response['secure_url'];
    }


    public function delete($id)
    {
        $category = Category::findOrFail($id);
        if (Auth::user()->can('eliminar categorias')) {
            // $category->stockKeepingUnits()->count() == 0 ? $category->forceDelete() : $category->delete();
           // $this->loadCategories();
            $this->dispatch('show-alert', title: 'Eliminado', message: 'Categoría eliminada');
        }
    }

    public function toggleActive($id)
    {
        $category = Category::findOrFail($id);
        $category->active = !$category->active;
        $category->save();
        //$this->loadCategories();
    }

    public function sortBy($field)
    {
        $this->sortDirection = $this->sortField === $field
            ? ($this->sortDirection === 'asc' ? 'desc' : 'asc')
            : 'asc';

        $this->sortField = $field;
      //  $this->loadCategories();
    }

    public function updatedFilterActive()
    {
        $this->resetPage();
    }

    public function updatedFilterType()
    {
        $this->resetPage();
    }

    public function updatedsearch()
    {
        $this->resetPage();
    }

    public function render()
    {
        $categoriesQuery = Category::query();

        if (!empty($this->search)) {
            $categoriesQuery = $categoriesQuery->where('name', 'like', '%' . $this->search . '%');
        }

        if ($this->filterActive !== ''){
            $categoriesQuery = $categoriesQuery->where('active', $this->filterActive);
        }

        if ($this->filterType === 'categoria') {
            $categoriesQuery->whereNull('parent_id');
        } elseif ($this->filterType === 'subcategoria') {
            $categoriesQuery->whereNotNull('parent_id');
        }

        if (!empty($this->sortField)) {
            $categoriesQuery = $categoriesQuery->orderBy($this->sortField, $this->sortDirection);
        }

        // $categories = $categoriesQuery->orderBy('position')->get();
        $categories = $categoriesQuery->paginate(10);

        return view('livewire.admin.categories.category-manager', ['categories' => $categories])->layout('components.layouts.admin');
    }


    /*  public function updatedSearch()
    {
        $this->loadCategories();
    } */

    /*   public function loadCategories()
    {
        $query = Category::query();

        if ($this->search) {
            $query->where('name', 'like', "%{$this->search}%");
        }

        if ($this->sortField) {
            $query->orderBy($this->sortField, $this->sortDirection);
        }

        $this->categories = $query->orderBy('position')->get();
    } */



    /* use WithFileUploads;

    public $category_id;
    public $name;
    public $meta_title;
    public $meta_description;
    public $keywords;
    public $icon;
    public $image_desktop;
    public $image_mobile;
    public $position;
    public $active = false;
    public $icon_upload;
    public $image_desktop_upload;
    public $image_mobile_upload;
    public $search;
    public $sortField = '';
    public $sortDirection = '';
    public $showModalOpen = false;

    protected $listeners = [
        'deleteCategoryConfirm' => 'delete',
    ];

    protected $pathname = 'categorias';

    protected $queryString = ['sortField' => ['except' => ''], 'sortDirection' => ['except' => '']];

    protected $rules = [
        'name' => 'required|unique:categories,name|max:150',
        'meta_title' => 'nullable|max:150',
        'meta_description' => 'nullable|max:500',
        'keywords' => 'nullable|max:500',
        'image_desktop_upload' => 'required|image|mimes:jpeg,png,jpg|dimensions:min_width=800,min_height=800,max_width=1200,max_height=1200|max:1024',
        'position' => 'required|integer',
        'active' => 'boolean'
    ];

    protected $validationAttributes = [
        'name' => 'nombre de categoría',
        'meta_title' => 'meta titulo',
        'meta_description' => 'meta descripción',
        'keywords' => 'keywords',
        'image_desktop_upload' => 'imagen desktop',
        'active' => 'estado'
    ];

    public function loadModel()
    {
        $data = Category::find($this->category_id);
        $this->name = $data->name;
        $this->meta_title = $data->meta_title;
        $this->meta_description = $data->meta_description;
        $this->keywords = $data->keywords;
        $this->image_desktop = $data->image_desktop;
        $this->position = $data->position;
        $this->active = $data->active;
    }

    public function update()
    {
        $rules = [
            'name' => 'required|max:150|unique:categories,name,' . $this->category_id,
            'meta_title' => 'nullable|max:150',
            'meta_description' => 'nullable|max:500',
            'keywords' => 'nullable|max:500',
            'position' => 'required|integer',
            'active' => 'boolean',
        ];

        if ($this->image_desktop_upload instanceof \Illuminate\Http\UploadedFile) {
            $rules['image_desktop_upload'] = 'image|mimes:jpeg,png,jpg|dimensions:min_width=800,min_height=800,max_width=1200,max_height=1200|max:1024';
        } elseif (empty($this->image_desktop)) {
            throw new \Exception("Debe subir o mantener una imagen existente.");
        }

        $this->validate($rules);

        $url_image_desktop = $this->image_desktop;

        if ($this->image_desktop_upload instanceof \Illuminate\Http\UploadedFile) {
            $filename = "dsk-" . Str::slug($this->name) . '.' . $this->image_desktop_upload->getClientOriginalExtension();
            $url_image_desktop = $this->image_desktop_upload->storeAs($this->pathname, $filename);
        }

        $category = Category::findOrFail($this->category_id);
        $category->name = $this->name;
        $category->slug = Str::slug($this->name);
        $category->meta_title = $this->meta_title;
        $category->meta_description = $this->meta_description;
        $category->keywords = $this->keywords;
        $category->image_desktop = $url_image_desktop;
        $category->position = $this->position;
        $category->active = $this->active;
        $category->save();

        $this->reset();
        $this->dispatch('show-alert', title: 'Categoría actualizada', message: 'success');
    }

    public function create()
    {
        $this->position = Category::max('position') + 1 ?? 1;

        $this->validate([
            'name' => 'required|unique:categories,name|max:150',
            'meta_title' => 'nullable|max:150',
            'meta_description' => 'nullable|max:500',
            'keywords' => 'nullable|max:500',
            'image_desktop_upload' => 'required|image|mimes:jpeg,png,jpg|dimensions:min_width=800,min_height=800,max_width=1200,max_height=1200|max:1024',
            'position' => 'required|integer',
            'active' => 'boolean',
        ]);

        if (!($this->image_desktop_upload instanceof \Illuminate\Http\UploadedFile)) {
            throw new \Exception("Debe subir una imagen de escritorio válida.");
        }

        if (!Storage::exists($this->pathname)) {
            Storage::makeDirectory($this->pathname);
        }

        $filename = "bg-" . Str::slug($this->name) . '.' . $this->image_desktop_upload->getClientOriginalExtension();
        $url = $this->image_desktop_upload->storeAs($this->pathname, $filename);

        $category = new Category();
        $category->name = $this->name;
        $category->slug = Str::slug($this->name);
        $category->meta_title = $this->meta_title;
        $category->meta_description = $this->meta_description;
        $category->keywords = $this->keywords;
        $category->image_desktop = $url;
        $category->position = $this->position;
        $category->active = $this->active;
        $category->save();

        $this->reset();
        $this->dispatch('show-alert', title: 'Categoría registrada', message: 'success');
    }

    public function updatedImageDesktopUpload()
    {
        if (!$this->image_desktop_upload->getClientOriginalName()) {
            throw new \Exception('Archivo no válido.');
        }
    }


    public function updateCategoryOrder($categories)
    {
        foreach ($categories as $category) {
            Category::find($category['value'])->update(['position' => $category['order']]);
        }

        // $this->emit('show-alert', 'Se cambio posición la categoria', 'success');
    }

    public function createShowModal()
    {
        $this->resetValidation();
        $this->reset();
        $this->showModalOpen = true;
        // $this->emit('showModalOpen');
        $this->dispatch('showModalOpen');
    }

    public function updateShowModal($id)
    {
        $this->resetValidation();
        $this->reset();
        $this->category_id = $id;
        $this->showModalOpen = true;
        // $this->emit('showModalOpen');
        $this->dispatch('showModalOpen');
        $this->loadModel();
    }

    public function delete($idCategory)
    {
        $category = Category::findOrFail($idCategory);
        $user = Auth::user();

        if ($user->hasPermissionTo('eliminar categorias')) {
            if (count($category->stockKeepingUnits) == 0) {
                $category->forceDelete();
            } else {
                $category->delete();
            }
        }
        // $this->emit('show-alert', 'Categoría eliminada', 'success');
    }

    public function confirmRemovalCategory($idCategory)
    {
        $category = Category::findOrFail($idCategory);
        // $this->emit('confirm-alert', 'Confirmación de eliminación', '¿Está seguro de eliminar la categoria ' . $category->name . '?', $idCategory, 'deleteCategoryConfirm');
        $this->dispatch('confirm-alert', title: 'Confirmación de eliminación', message: '¿Está seguro de eliminar la categoria ' . $category->name . '?', id: $idCategory, action: 'deleteCategoryConfirm');
    }

    public function toggleActive($id)
    {
        $category = Category::findOrFail($id);
        $category->active = !$category->active;
        $category->save();
    }


    public function sortBy($field)
    {
        $this->sortDirection = $this->sortField === $field
            ? $this->sortDirection = $this->sortDirection  === 'asc' ? 'desc' : 'asc'
            : 'asc';

        $this->sortField = $field;
    }



    public function render()
    {
        // $this->loadCategories();

        $categoriesQuery = Category::query();

        if (!empty($this->search)) {
            $categoriesQuery = $categoriesQuery->where('name', 'like', '%' . $this->search . '%');
        }

        if (!empty($this->sortField)) {
            $categoriesQuery = $categoriesQuery->orderBy($this->sortField, $this->sortDirection);
        }

        $categories = $categoriesQuery->orderBy('position')->get();


        return view('livewire.admin.categories.category-manager', ['categories' => $categories])->layout('components.layouts.admin');
    } */
}
