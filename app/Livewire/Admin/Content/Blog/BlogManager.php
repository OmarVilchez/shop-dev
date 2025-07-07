<?php

namespace App\Livewire\Admin\Content\Blog;

use Livewire\Component;

class BlogManager extends Component
{
    public function render()
    {
        return view('livewire.admin.content.blog.blog-manager')->layout('components.layouts.admin');
    }
}
