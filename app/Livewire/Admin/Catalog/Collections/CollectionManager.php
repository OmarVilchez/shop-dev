<?php

namespace App\Livewire\Admin\Catalog\Collections;

use App\Helpers\Flash;
use App\Models\Collection;
use App\Models\TypeCollection;
use Flux\Flux;
use Livewire\Component;
use Livewire\WithPagination;
use Livewire\WithFileUploads;

class CollectionManager extends Component
{
    use WithFileUploads;
    use WithPagination;

    public $collection_id;
    public $name;
    public $slug;
    public $description;
    public $image_mobile;
    public $img_desktop;
    public $meta_title;
    public $meta_description;
    public $keywords;
    public $date_from = '';
    public $time_from = '';
    public $date_to = '';
    public $time_to = '';
    public $active;
    public $validity = true;
    public $position;
    public $showModalOpen = false;

    public $type_collection_id;
    public $typeCollections = [];
    public $list_type_collection_id;


    // Propiedades para la búsqueda y ordenación
    public $search = '';
    public $sortField = '';
    public $sortDirection = '';
    public $filterActive = '';
    public $filterType = '';

    protected $queryString = ['sortField' => ['except' => ''], 'sortDirection' => ['except' => '']];

    protected $listeners = [
        'deleteCollectionConfirm' => 'delete',
    ];

    protected $pathname = 'ocasiones';

    protected $rules = [
        'name' => 'required|unique:collections,name|max:500',
        'description' => 'nullable',
        'validity' => 'boolean',
        'active' => 'boolean',
    ];

    protected $validationAttributes = [
        'name' => 'nombre',
        'description' => 'descripción',
        'image_upload' => 'imagen desktop',
        'image_mobile_upload' => 'imagen mobile',
        'active' => 'estado'
    ];

    public function mount()
    {
        $this->typeCollections = TypeCollection::all();
    }

    public function loadModel()
    {
        $data = Collection::find($this->collection_id);

        if (!$data) {
            return; // Detener si no se encuentra la colección
        }

        $this->name = $data->name;
        $this->list_type_collection_id = $data->type_collection_id;
        $this->slug = $data->slug;
        $this->description = $data->description;
        $this->image_mobile = $data->image_mobile;
        $this->img_desktop = $data->img_desktop;
        $this->meta_title = $data->meta_title;
        $this->meta_description = $data->meta_description;
        $this->keywords = $data->keywords;
        $this->position = $data->position;
        $this->date_from = $data->date_from->format('Y-m-d') ? $data->date_from->format('Y-m-d') : '';
        $this->time_from = $data->date_from ? $data->date_from->format('H:i') : '';
        $this->date_to = $data->date_to->format('Y-m-d') ? $data->date_to->format('Y-m-d') : '';
        $this->time_to = $data->date_to ? $data->date_to->format('H:i') : '';
        $this->validity = (!$data->date_from && !$data->date_to);

        $now = now();

        if (!$this->validity && $this->date_to && $this->date_to < $now) {
            $this->active = false;
            $data->active = false;
            $data->save();
        }

        $this->active = $data->active;
        $this->typeCollections = TypeCollection::where('active', true)->orderBy('name')->get();
    }

    public function toggleActive($id)
    {
        $collection = Collection::findOrFail($id);
        $collection->active = !$collection->active;
        $collection->save();
    }

    public function sortBy($field)
    {
        $this->sortDirection = $this->sortField === $field
            ? ($this->sortDirection === 'asc' ? 'desc' : 'asc')
            : 'asc';

        $this->sortField = $field;
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

    public function delete($id)
    {
        //borrado logico
        //Collection::findOrFail($id)->delete();

        $collection = Collection::findOrFail($id);

        // Elimina las relaciones en collection_product
        $collection->products()->detach();


        // Elimina la colección (borrado físico si usas SoftDeletes)
        $collection->forceDelete();

        // Elimina la colección (borrado físico si no usas SoftDeletes)
       //$collection->delete();

        Flux::modals()->close();
        Flash::success('Colección eliminada correctamente');
    }

    public function render()
    {
        $collectionsQuery = Collection::query();

        if (!empty($this->search)) {
            $collectionsQuery = $collectionsQuery->where('name', 'like', '%' . $this->search . '%');
        }

        if (!empty($this->filterType)) {
            $collectionsQuery =  $collectionsQuery->where('type_collection_id', $this->filterType);
        }

        if ($this->filterActive !== '') {
            $collectionsQuery = $collectionsQuery->where('active', $this->filterActive);
        }

        if (!empty($this->sortField)) {
            $collectionsQuery = $collectionsQuery->orderBy($this->sortField, $this->sortDirection);
        }

        $collections = $collectionsQuery->paginate(50);

        return view('livewire.admin.catalog.collections.collection-manager', ['collections' => $collections])
            ->layout('components.layouts.admin');
    }
}






 /*   public $tasks;

    public function mount()
    {
        $this->tasks = Category::orderBy('position')->get();
    }

    // En v3, recibes un array simple de IDs en el nuevo orden
    public function updateTaskOrder($payload)
    {
        // 1) Si el payload está vacío, nada que hacer
        if (empty($payload)) {
            return;
        }

        // 2) Si el primer elemento es escalar (id), recibimos [id, id, id]
        if (is_scalar($payload[0] ?? null)) {
            foreach ($payload as $index => $id) {
                Category::where('id', $id)->update(['position' => $index + 1]);
            }
        } else {
            // 3) Si vino como [{ value: id, order: pos }, ...] o [{ id:..., position:... }, ...]
            foreach ($payload as $item) {
                $id = $item['value'] ?? $item['id'] ?? null;
                $order = $item['order'] ?? $item['position'] ?? null;

                if ($id !== null && $order !== null) {
                    Category::where('id', $id)->update(['position' => $order]);
                }
            }
        }

        // Refresca la lista local para re-render
        $this->tasks = Category::orderBy('position')->get();

        session()->flash('success', 'Orden actualizado');
    } */
