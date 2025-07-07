<?php

namespace App\Livewire\Admin\Content\Quotes;

use Livewire\Component;

class QuoteManager extends Component
{
    public function render()
    {
        return view('livewire.admin.content.quotes.quote-manager')->layout('components.layouts.admin');
    }
}
