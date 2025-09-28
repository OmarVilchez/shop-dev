<?php

namespace App\Livewire\Admin\Catalog\Collections;

use App\Helpers\Flash;
use Livewire\Component;
use Livewire\WithFileUploads;
use App\Models\Collection;
use App\Models\TypeCollection;
use CloudinaryLabs\CloudinaryLaravel\Facades\Cloudinary;
use Illuminate\Support\Str;


class CollectionCreate extends Component
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
    public $active = false;
    public $date_from;
    public $date_to;
    public $thumbnailFile;
    public $desktopFile;
    public $mobileFile;

    public $editorId;

    protected $rules = [
        'type_collection_id' => 'required|exists:type_collections,id',
        'name' => 'required|string|max:255|unique:collections,name',
        'description' => 'required|string|min:3',
        'meta_title' => 'nullable|string|max:255',
        'meta_description' => 'nullable|string',
        'keywords' => 'nullable|string',
        'thumbnailFile' => 'nullable|image|max:2048',
        'desktopFile' => 'required|image|max:4096',
        'mobileFile' => 'nullable|image|max:4096',
        'position' => 'nullable|integer',
        'active' => 'boolean',
        'date_from' => 'nullable|date',
        'date_to' => 'nullable|date|after_or_equal:date_from',
    ];

    protected $validationAttributes = [
        'name' => 'nombre',
        'type_collection_id' => 'tipo de colección',
        'description' => 'descripción',
        'desktopFile' => 'Imagen Desktop'
    ];


    protected $listeners = [
        'updateDescription',
    ];

    public function mount()
    {
        $this->editorId = 'jodit-editor-' . uniqid();
        $this->dispatch('refreshJodit', $this->description);
    }

    public function updateDescription($value)
    {
        $this->description = $value ?? '';

        // Limpiar contenido "vacío visualmente"
        $clean = trim(strip_tags($value));
        $this->description = $clean === '' ? null : $value;
    }


    public function save()
    {
         $this->validate();

        // Slug a partir del nombre de la colección
        $slug = Str::slug($this->name);

        // Subida de imágenes si existen
        if ($this->thumbnailFile) {
            $this->thumbnail = $this->uploadImageToCloudinary($this->thumbnailFile, $slug, 'thumbnail');
        }

        if ($this->desktopFile) {
            $this->img_desktop = $this->uploadImageToCloudinary($this->desktopFile, $slug, 'desktop');
        }

        if ($this->mobileFile) {
            $this->img_mobile = $this->uploadImageToCloudinary($this->mobileFile, $slug, 'mobile');
        }

        $lastPosition = Collection::max('position') ?? 0;
        $this->position = $lastPosition + 1;

        // Crear la colección, el slug se crea desde el modelo
        Collection::create([
            'type_collection_id' => $this->type_collection_id,
            'name'               => $this->name,
            'description'        => $this->description,
            'meta_title'         => $this->meta_title,
            'meta_description'   => $this->meta_description,
            'keywords'           => $this->keywords,
            'thumbnail'          => $this->thumbnail,
            'img_desktop'        => $this->img_desktop,
            'img_mobile'         => $this->img_mobile,
            'position'           => $this->position,
            'active'             => $this->active,
            'date_from'          => $this->date_from,
            'date_to'            => $this->date_to,
        ]);

        // Reset form (opcional)
        $this->reset([
            'name',
            'description',
            'meta_title',
            'meta_description',
            'keywords',
            'thumbnailFile',
            'desktopFile',
            'mobileFile',
            'thumbnail',
            'img_desktop',
            'img_mobile'
        ]);

        Flash::success('Coleciión guardada exitosamente');

        return redirect()->route('manager.catalog.collections.edit', ['collection' => $slug]);
    }

    private function uploadImageToCloudinary($image, $slug, $prefix)
    {
        $response = Cloudinary::uploadApi()->upload(
            $image->getRealPath(),
            [
                'folder' => 'collections',
                'public_id' => "{$prefix}-{$slug}",
                'overwrite' => true,
                'resource_type' => 'image',
                // 'transformation' => [
                //     'quality' => 'auto',
                //     'fetch_format' => 'auto',
                // ],
            ]
        );

        return $response['secure_url'];
    }

    public function cancel()
    {
        return redirect()->route('manager.catalog.collections.index');
    }

    public function render()
    {
        return view('livewire.admin.catalog.collections.collection-create', ['types' => TypeCollection::where('active', 1)->get(),])->layout('components.layouts.admin');
    }
}
