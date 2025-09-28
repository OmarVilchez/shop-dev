<?php

namespace App\Livewire\Admin\Catalog\Collections;

use App\Helpers\Flash;
use Livewire\Component;
use Livewire\WithFileUploads;
use App\Models\Collection;
use App\Models\Product;
use App\Models\TypeCollection;
use CloudinaryLabs\CloudinaryLaravel\Facades\Cloudinary;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class CollectionEdit extends Component
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
    public $position;
    public $active;
    public $date_from;
    public $date_to;
    public $thumbnailFile;
    public $desktopFile;
    public $mobileFile;

    public $editorId;

    //OPCIONES PARA EL MODAL Y PRODUCTS
    public $showProductModal = false;
    public $searchInCollection = '';
    public $searchInModal = '';
    public $orderProducts = 'bestseller';

    public $availableProducts = []; // listado que se muestra en modal
    public $selectedProducts = [];  // productos ya en la colección
    public $selectedTemp = [];      // ids seleccionados en modal
    public $lockedProducts = [];  //bloquear los productos ya en la colección checked

    protected $listeners = [
        'updateDescription' => 'updateDescription',
    ];

    public function mount(Collection $collection)
    {
        $this->collection = $collection;

        // Cargar productos ya relacionados
        $this->selectedProducts = $collection->products()
            ->with(['stockKeepingUnits.images' => function ($q) {
                $q->orderBy('position');
            }])
            ->get()
            ->map(function ($product) {
                $sku = $product->stockKeepingUnits->where('active', 1)->first();
                return [
                    'id'        => $product->id,
                    'name'      => $product->name,
                    'active'    => $product ? $product->active : 0, // el estado del product
                   // 'active'    => $sku ? $sku->active : 0, // el estado desde el SKU
                    'image_url' => $sku ? get_sku_image_url($sku) : Storage::url('no-image.png'),
                ];
            })
            ->toArray();

        // Cargar datos existentes
        $this->type_collection_id = $this->collection->type_collection_id;
        $this->name = $this->collection->name;
        $this->description = $this->collection->description;
        $this->meta_title = $this->collection->meta_title;
        $this->meta_description = $this->collection->meta_description;
        $this->keywords = $this->collection->keywords;
        $this->thumbnail = $this->collection->thumbnail;
        $this->img_desktop = $this->collection->img_desktop;
        $this->img_mobile = $this->collection->img_mobile;
        $this->position = $this->collection->position;
        $this->active = $this->collection->active;
        $this->date_from = $this->collection->date_from ? $this->collection->date_from->format('Y-m-d') : '';
        $this->date_to = $this->collection->date_to ? $this->collection->date_to->format('Y-m-d') : '';

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

    public function update()
    {
        $this->validate([
            'type_collection_id' => 'required|exists:type_collections,id',
            'name' => 'required|string|max:255|unique:collections,name,' . $this->collection->id,
            'description' => 'required|string|min:3',
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
        ]);

        $slug = Str::slug($this->name);

        // Convertir fechas vacías a null
        $this->date_from = $this->date_from ?: null;
        $this->date_to = $this->date_to ?: null;

        if ($this->thumbnailFile) {
            $this->thumbnail = $this->uploadImageToCloudinary($this->thumbnailFile, $slug, 'thumbnail');
        }

        if ($this->desktopFile) {
            $this->img_desktop = $this->uploadImageToCloudinary($this->desktopFile, $slug, 'desktop');
        }

        if ($this->mobileFile) {
            $this->img_mobile = $this->uploadImageToCloudinary($this->mobileFile, $slug, 'mobile');
        }

        $this->collection->update([
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

        // Mensaje de éxito y redirección
        Flash::success('Colección actualizada exitosamente');
        return redirect()->route('manager.catalog.collections.index');
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
            ]
        );
        return $response['secure_url'];
    }

    public function removeThumbnail()
    {
        $this->thumbnail = null;
        $this->thumbnailFile = null;
        $this->collection->update(['thumbnail' => null]);
        Flash::success('Miniatura eliminada correctamente');
    }

    public function removeDesktopImage()
    {
        $this->img_desktop = null;
        $this->desktopFile = null;
        $this->collection->update(['img_desktop' => null]);
    }

    public function removeMobileImage()
    {
        $this->img_mobile = null;
        $this->mobileFile = null;
        $this->collection->update(['img_mobile' => null]);
    }

    public function cancel()
    {
        return redirect()->route('manager.catalog.collections.index');
    }

    //CODIGO PARA AGREGAR PRODUCTOS A LA COLECCIÓN
    public function openProductModal()
    {
        // IDs de los productos que ya están en la colección
        $this->selectedTemp = $this->collection->products()->pluck('products.id')->toArray();
        // Guardamos también en lockedProducts para saber cuáles deben ir bloqueados
        $this->lockedProducts = $this->selectedTemp;
        $this->searchInModal = '';
        $this->showProductModal = true;
        $this->loadAvailableProducts();
    }

    //ESTA FUNCION ES SOLO PARA EL MODAL
    public function loadAvailableProducts()
    {
        $query = Product::query();

        // Filtro SOLO del buscador del modal
        if ($this->searchInModal) {
            $query->where('name', 'like', '%' . $this->searchInModal . '%');
        }

        if ($this->orderProducts === 'bestseller') {
            $query->orderByDesc('created_at');
        } elseif ($this->orderProducts === 'newest') {
            $query->orderByDesc('created_at');
        }

        /*  $this->availableProducts = $query->limit(20)->get(); */

        $this->availableProducts = $query
            ->with(['stockKeepingUnits.images' => fn($q) => $q->orderBy('position')])
            ->limit(20)
            ->get()
            ->map(function ($product) {
                $sku = $product->stockKeepingUnits->where('active', 1)->first();
                return [
                    'id'        => $product->id,
                    'name'      => $product->name,
                    'image_url' => $sku ? get_sku_image_url($sku) : Storage::url('no-image.png'),
                ];
            })
            ->toArray();

    }

    public function updatedSearchInModal()
    {
        $this->loadAvailableProducts();
    }

    public function getFilteredSelectedProductsProperty()
    {
        return collect($this->selectedProducts)->filter(function ($product) {
            return str_contains(
                strtolower($product['name']),
                strtolower($this->searchInCollection)
            );
        });
    }

    public function cancelProductModal()
    {
        // Restaurar selección original (solo los de la colección)
        $this->selectedTemp = $this->collection->products()->pluck('products.id')->toArray();

        // limpiar lockedProducts
        $this->lockedProducts = $this->selectedTemp;

        // Limpiar búsqueda
        $this->searchInModal = '';

        // Ocultar modal
        $this->showProductModal = false;

        // Recargar lista limpia
        $this->loadAvailableProducts();
    }

    public function addSelectedProducts()
    {
        $products = Product::whereIn('id', $this->selectedTemp)
            ->with(['stockKeepingUnits.images' => function ($q) {
                $q->orderBy('position');
            }])
            ->get();

        foreach ($products as $product) {
            $sku = $product->stockKeepingUnits->where('active', 1)->first();

            // Guardar en la relación pivote
            $this->collection->products()->syncWithoutDetaching([$product->id]);

            /*    $this->selectedProducts[$product->id] = [
                'id'        => $product->id,
                'name'      => $product->name,
                'active'    => $product ? $product->active : 0, // el estado del product
               // 'active'    => $sku ? $sku->active : 0, // ✅ agregamos el estado desde el SKU
                'image_url' => $sku ? get_sku_image_url($sku) : Storage::url('no-image.png'),
            ]; */

            // refrescar lista entera
            $this->selectedProducts = $this->collection->products()
                ->with(['stockKeepingUnits.images' => fn($q) => $q->orderBy('position')])
                ->get()
                ->mapWithKeys(function ($product) {
                    $sku = $product->stockKeepingUnits->where('active', 1)->first();
                    return [
                        $product->id => [
                            'id'        => $product->id,
                            'name'      => $product->name,
                            'active'    => $product ? $product->active : 0,
                            'image_url' => $sku ? get_sku_image_url($sku) : Storage::url('no-image.png'),
                        ]
                    ];
                })
                ->toArray();
        }

        $this->selectedTemp = [];
        $this->showProductModal = false;
        $this->searchInModal = '';
    }

    public function removeProduct($productId)
    {
        // 1) Eliminar de la tabla pivote
        $this->collection->products()->detach($productId);

        // 2) Refrescar la colección desde DB
        $this->collection->refresh();

        // 3) Reconstruir la lista $selectedProducts
        $this->selectedProducts = $this->collection->products()
            ->with(['stockKeepingUnits.images' => fn($q) => $q->orderBy('position')])
            ->get()
            ->mapWithKeys(function ($product) {
                $sku = $product->stockKeepingUnits->where('active', 1)->first();

                return [
                    $product->id => [
                        'id'        => $product->id,
                        'name'      => $product->name,
                        'active'    => $product ? $product->active : 0, // el estado del product
                        //'active'    => $sku ? $sku->active : 0,
                        'image_url' => $sku ? get_sku_image_url($sku) : Storage::url('no-image.png'),
                    ]
                ];
            })
            ->toArray();
    }

    public function render()
    {
        return view('livewire.admin.catalog.collections.collection-edit', [
            'types' => TypeCollection::where('active', 1)->get(),
        ])->layout('components.layouts.admin');
    }
}













   // $this->collection = Collection::findOrFail($id);


        /*  // Cargar los productos ya asociados
        $this->selectedProducts = $collection->products->map(fn($p) => [
            'id' => $p->id,
            'name' => $p->name,
            'image' => $p->image_url,
        ])->toArray(); */


    /*  public function addSelectedProducts()
    {
        $products = Product::whereIn('id', $this->selectedTemp)->get();

        foreach ($products as $product) {
            $this->selectedProducts[$product->id] = [
                'id' => $product->id,
                'name' => $product->name,
                'image' => $product->image_url,
            ];
        }

        $this->selectedTemp = [];
        $this->showProductModal = false;
    } */
