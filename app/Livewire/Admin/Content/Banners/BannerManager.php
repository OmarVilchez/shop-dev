<?php

namespace App\Livewire\Admin\Content\Banners;

use App\Models\Banner;
use Livewire\Component;
use Livewire\WithPagination;

class BannerManager extends Component
{
    use WithPagination;

    public $banner_id;
    public $title;
    public $subtitle;
    public $description;
    public $text_button;

    public $img_desktop;
    public $img_mobile;
    public $is_redirect = false;
    public $redirect_to;
    public $new_tab = false;
    public $section = 'home';
    public $keywords;

    public $starts_at = '';
    public $time_from = '';
    public $ends_at = '';
    public $time_to = '';

    public $position;
    public $active = true;
    public $validity = true;

    public $search;

    public $sortField = '';
    public $sortDirection = '';

    protected $queryString = ['sortField' => ['except' => ''], 'sortDirection' => ['except' => '']];


    protected $rules = [
        'title' => 'nullable|max:255',
        'content' => 'nullable|max:255',
        'text_button' => 'nullable|max:50',
        'is_redirect' => 'boolean',
        'new_tab' => 'boolean',
        'redirect_to' => 'required_if:is_redirect,true',
        'img_desktop_upload' => 'required|image|mimes:jpeg,png,jpg|max:1200',
        'img_mobile_upload' => 'required|image|mimes:jpeg,png,jpg|max:800',
        'validity' => 'boolean',
        'keywords' => 'nullable',
        'position' => 'required|numeric',
        'active' => 'boolean'
    ];

    protected $validationAttributes = [
        'title' => 'titulo',
        'content' => 'contenido',
        'text_button' => 'texto de botón',
        'is_redirect' => 'redireccionar',
        'new_tab' => 'nueva pestaña',
        'redirect_to' => 'url',
        'img_desktop' => 'imagen desktop',
        'img_mobile' => 'imagen mobile',
        'img_desktop_upload' => 'imagen desktop',
        'img_mobile_upload' => 'imagen mobile',
        'date_from' => 'fecha de inicio',
        'date_to' => 'fecha de termino',
        'time_from' => 'hora de inicio',
        'time_to' => 'hora de termino',
        'keywords' => 'keywords',
        'position' => 'posición',
        'active' => 'estado',
        'validity' => 'validez ilimitada'
    ];

    public function loadModel()
    {
        $data = Banner::find($this->banner_id);
        $this->title = $data->title;
        $this->description = $data->description;
        $this->text_button = $data->text_button;
        $this->is_redirect = $data->is_redirect;
        $this->redirect_to = $data->redirect_to;
        $this->new_tab = $data->new_tab;
        $this->img_desktop = $data->img_desktop;
        $this->img_mobile = $data->img_mobile;
        $this->keywords = $data->keywords;
        $this->starts_at = $data->starts_at ? $data->starts_at->format('Y-m-d') : '';
        $this->time_from = $data->starts_at ? $data->starts_at->format('H:i') : '';
        $this->ends_at = $data->ends_at ? $data->ends_at->format('Y-m-d') : '';
        $this->time_to = $data->ends_at ? $data->ends_at->format('H:i') : '';

        if (!$data->starts_at & !$data->ends_at) {
            $this->validity = true;
        } else {
            $this->validity = false;
        }

        $this->position = $data->position;
        $this->active = $data->active;
    }


    public function sortBy($field)
    {
        $this->sortDirection = $this->sortField === $field
            ? $this->sortDirection = $this->sortDirection  === 'asc' ? 'desc' : 'asc'
            : 'asc';

        $this->sortField = $field;
    }

    public function updatingSearch()
    {
        $this->resetPage();
    }

    public function toggleActive($id)
    {
        $user = Banner::findOrFail($id);
        $user->active = !$user->active;
        $user->save();
    }

    public function render()
    {
        $BannersQuery = Banner::query();

        if (!empty($this->search)) {
            $BannersQuery->where(function ($query) {
                $query->where('title', 'like', '%' . $this->search . '%');
            });
        }

        if (!empty($this->sortField)) {
            $BannersQuery->orderBy($this->sortField, $this->sortDirection);
        }

        $banners = $BannersQuery->orderBy('position', 'asc')->paginate(10);

        return view('livewire.admin.content.banners.banner-manager', ['banners' => $banners])->layout('components.layouts.admin');
    }
}
