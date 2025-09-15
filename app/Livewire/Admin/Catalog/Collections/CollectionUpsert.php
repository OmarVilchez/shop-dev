<?php

namespace App\Livewire\Admin\Catalog\Collections;

use Livewire\Component;
use Livewire\WithFileUploads;
use App\Models\Collection;
use App\Models\TypeCollection;
use Illuminate\Support\Str;

class CollectionUpsert extends Component
{
    use WithFileUploads;

    public $collection;
    public $type_collection_id;
    public $name;
    public $description;
    public $meta_title;
    public $meta_description;
    public $keywords;
    public $thumbnail;
    public $img_desktop;
    public $img_mobile;
    public $position = 0;
    public $active = 1;
    public $date_from;
    public $date_to;

    public $thumbnailFile;
    public $desktopFile;
    public $mobileFile;

    protected $rules = [
        'type_collection_id' => 'required|exists:type_collections,id',
        'name' => 'required|string|max:255',
        'description' => 'nullable|string',
        'meta_title' => 'nullable|string|max:255',
        'meta_description' => 'nullable|string',
        'keywords' => 'nullable|string',
        'thumbnailFile' => 'nullable|image|max:2048',
        'desktopFile' => 'nullable|image|max:4096',
        'mobileFile' => 'nullable|image|max:4096',
        'position' => 'nullable|integer',
        'active' => 'boolean',
        'date_from' => 'nullable|date',
        'date_to' => 'nullable|date|after_or_equal:date_from',
    ];

    public function mount($collection = null)
    {
        if ($collection) {
            $this->collection = Collection::findOrFail($collection);
            $this->fill($this->collection->toArray());
        }
    }

    public function save()
    {
        $this->validate();

        $slug = Str::slug($this->name);

        $data = [
            'type_collection_id' => $this->type_collection_id,
            'name' => $this->name,
            'description' => $this->description,
            'slug' => $slug,
            'meta_title' => $this->meta_title,
            'meta_description' => $this->meta_description,
            'keywords' => $this->keywords,
            'position' => $this->position,
            'active' => $this->active,
            'date_from' => $this->date_from,
            'date_to' => $this->date_to,
        ];

        // subir imágenes si se cambiaron
        if ($this->thumbnailFile) {
            $data['thumbnail'] = $this->thumbnailFile->store('collections', 'public');
        }
        if ($this->desktopFile) {
            $data['img_desktop'] = $this->desktopFile->store('collections', 'public');
        }
        if ($this->mobileFile) {
            $data['img_mobile'] = $this->mobileFile->store('collections', 'public');
        }

        if ($this->collection) {
            $this->collection->update($data);
            session()->flash('success', 'Colección actualizada correctamente.');
        } else {
            Collection::create($data);
            session()->flash('success', 'Colección creada correctamente.');
        }

       // return redirect()->route('collections.index');
    }


    public function render()
    {
        return view('livewire.admin.catalog.collections.collection-upsert',
        ['types' => TypeCollection::where('active', 1)->get(),])->layout('components.layouts.admin');
    }
}
