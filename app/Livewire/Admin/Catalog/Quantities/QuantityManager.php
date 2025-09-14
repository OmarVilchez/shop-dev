<?php

namespace App\Livewire\Admin\Catalog\Quantities;

use App\Helpers\Flash;
use App\Models\Quantity;
use Livewire\Component;
use Livewire\WithPagination;

class QuantityManager extends Component
{
    use WithPagination;

    public $quantity_id;
    public $quanty_min;
    public $quanty_max;
    public $description;
    public $position;
    public $active = 0;

    public $search;
    public $sortField = '';
    public $sortDirection = '';
    public $showModalOpen = false;

    protected $listeners = [
        'deleteQuantityConfirm' => 'delete',
    ];

    protected $queryString = ['sortField' => ['except' => ''], 'sortDirection' => ['except' => '']];

    protected $rules = [
        'quanty_min' => 'required|unique:categories,name|max:150',
        'description' => 'required|max:500',
        'position' => 'required|integer',
        'active' => 'boolean'
    ];

    protected $validationAttributes = [
        'quanty_min' => 'cantidad mínima',
        'quanty_max' => 'cantidad máxima',
        'description' => 'descripción',
        'position' => 'posición',
        'active' => 'estado'
    ];

    public function loadModel()
    {
        $data = Quantity::find($this->quantity_id);
        $this->quanty_min = $data->quanty_min;
        $this->quanty_max = $data->quanty_max;
        $this->description = $data->description;
        $this->position = $data->position;
        $this->active = (int) $data->active;
    }

    public function update()
    {
        $this->validate();
        $quantity = Quantity::findOrFail($this->quantity_id);
        $quantity->quanty_min = $this->quanty_min;
        $quantity->quanty_max = $this->quanty_max !== '' ? $this->quanty_max : null;
        //$quantity->quanty_max = $this->quanty_max;
        $quantity->description = $this->description;
        $quantity->position = $this->position;
        $quantity->active = $this->active ?? 0;
        $quantity->save();

        $this->reset();
        Flash::success('Cantidad actualizada');
    }

    public function create()
    {
        $this->position = Quantity::max('position') + 1 ?? 1;

        $this->validate();
        $quantity = new Quantity();
        $quantity->quanty_min = $this->quanty_min;
        $quantity->quanty_max = $this->quanty_max !== '' ? $this->quanty_max : null;
        //$quantity->quanty_max = $this->quanty_max;
        $quantity->description = $this->description;
        $quantity->position = $this->position;
        $quantity->active = $this->active;
        $quantity->save();

        $this->reset();
        Flash::success('Cantidad registrada');
    }

    public function updateQuantityOrder($quantities)
    {
        // 1) Si el payload está vacío, nada que hacer
        if (empty($quantities)) {
            return;
        }

        // 2) Si el primer elemento es escalar (id), recibimos [id, id, id]
        if (is_scalar($quantities[0] ?? null)) {
            foreach ($quantities as $index => $id) {
                Quantity::where('id', $id)->update(['position' => $index + 1]);
            }
        } else {
            // 3) Si vino como [{ value: id, order: pos }, ...] o [{ id:..., position:... }, ...]
            foreach ($quantities as $item) {
                $id = $item['value'] ?? $item['id'] ?? null;
                $order = $item['order'] ?? $item['position'] ?? null;

                if ($id !== null && $order !== null) {
                    Quantity::where('id', $id)->update(['position' => $order]);
                }
            }
        }

        $quantities =  Quantity::orderBy('position')->get();

        Flash::success('Se cambio de posición la cantidad');
    }

    public function createShowModal()
    {
        $this->resetValidation();
        $this->reset();
        $this->showModalOpen = true;
    }

    public function updateShowModal($idQuanty)
    {
        $this->resetValidation();
        $this->reset();
        $this->quantity_id = $idQuanty;
        $this->showModalOpen = true;
        $this->loadModel();
    }

    public function toggleActive($id)
    {
        $quantity = Quantity::findOrFail($id);
        $quantity->active = !$quantity->active;
        $quantity->save();
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
         $quantitiesQuery = Quantity::query();

        if (!empty($this->search)) {
            $quantitiesQuery = $quantitiesQuery->where('quanty_min', 'like', '%' . $this->search . '%');
        }

        if (!empty($this->sortField)) {
            $quantitiesQuery = $quantitiesQuery->orderBy($this->sortField, $this->sortDirection);
        }

        /* $quantities = $quantitiesQuery->paginate(10); */
         $quantities =   $quantitiesQuery->orderBy('position')->get();

        return view('livewire.admin.catalog.quantities.quantity-manager', ['quantities' => $quantities])->layout('components.layouts.admin');
    }
}
