<?php

namespace App\Livewire\Admin\Content\Faqs;

use Livewire\Component;

class FaqManager extends Component
{
    public function render()
    {
        return view('livewire.admin.content.faqs.faq-manager')->layout('components.layouts.admin');
    }
}
