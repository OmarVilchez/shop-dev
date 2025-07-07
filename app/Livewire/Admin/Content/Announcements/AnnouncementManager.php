<?php

namespace App\Livewire\Admin\Content\Announcements;

use Livewire\Component;

class AnnouncementManager extends Component
{
    public function render()
    {
        return view('livewire.admin.content.announcements.announcement-manager')->layout('components.layouts.admin');
    }
}
