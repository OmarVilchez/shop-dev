<?php

namespace App\Livewire\Admin\MasterData\Contacts;

use App\Models\Contact;
use Livewire\Component;
use Livewire\WithPagination;

class ContactManager extends Component
{
    use WithPagination;

    public $contact_id;
    public $name;
    public $email;
    public $phone_number;
    public $subject;
    public $message;
    public $created_at;

    public $search;
    public $sortField = '';
    public $sortDirection = '';

    public $showModalViewContact = false;

    public $counter = 1;

    public function loadModel()
    {
        $data = Contact::find($this->contact_id);
        $this->name = $data->name;
        $this->email = $data->email;
        $this->phone_number = $data->phone_number;
        $this->subject = $data->subject;
        $this->message = $data->message;
        $this->created_at = $data->created_at->format('d/m/Y');
    }

    public function viewContact($id)
    {
        $this->reset();
        $this->contact_id = $id;
        $this->showModalViewContact = true;
        $this->loadModel();
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
        $contactsQuery = Contact::query();

        if (!empty($this->search)) {
            $contactsQuery->where('name', 'like', '%' . $this->search . '%')
                ->orWhere('email', 'like', '%' . $this->search . '%')
                ->orWhere('subject', 'like', '%' . $this->search . '%');
        }

        if (!empty($this->sortField)) {
            $contactsQuery->orderBy($this->sortField, $this->sortDirection);
        }

        $contacts = $contactsQuery->orderBy('created_at', 'desc')->paginate(10);

        $perPage = $contacts->perPage();
        $currentPage = $contacts->currentPage();

        $this->counter = ($currentPage - 1) * $perPage + 1;

        return view('livewire.admin.master-data.contacts.contact-manager', ['contacts' => $contacts])->layout('components.layouts.admin');
    }
}
