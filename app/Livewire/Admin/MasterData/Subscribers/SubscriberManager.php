<?php

namespace App\Livewire\Admin\MasterData\Subscribers;

use App\Helpers\Flash;
use App\Jobs\CreateContactSyncBrevoJob;
use App\Models\Subscription as Subscriber;
use Livewire\Component;
use Livewire\WithPagination;

class SubscriberManager extends Component
{
    use WithPagination;

    public $search;
    public $sortField = '';
    public $sortDirection = '';


    /**
     * Suscribe o desuscribe a un suscriptor.
     * @param App\Model\Suscription $subscriber Suscriptor a sincronizar
     * @return void
     */
    public function changeStatus(Subscriber $subscriber)
    {
        $currentStatus = $subscriber->active;
        if ($currentStatus == true) {
            $subscriber->active = false;
        } else {
            $subscriber->active = true;
        }
        $subscriber->save();

        CreateContactSyncBrevoJob::dispatch($subscriber);

        if ($currentStatus) {
            Flash::success('Usuario desuscrito');
        } else {
            Flash::success('Usuario suscrito');
        }
    }

    /**
     * Sincroniza el estado del suscriptor en Brevo.
     * @param App\Model\Suscription $subscriber Suscriptor a sincronizar
     * @return void
     */
    public function syncPlatform(Subscriber $subscriber)
    {
        CreateContactSyncBrevoJob::dispatch($subscriber);
        $subscriber = Subscriber::find($subscriber->id);
        $statusSync = $subscriber->data_sync['brevo']['sync'];

        Flash::success($statusSync ? 'Sincronización exitosa' : 'Error al sincronizar', $statusSync ? 'success' : 'error');
    }

    public function render()
    {

        $subscribers = Subscriber::query();

        if (!empty($this->search)) {
            $subscribers->where(function ($query) {
                $query->where('email', 'like', '%' . $this->search . '%');
            });
        }

        if (!empty($this->sortField)) {
            $subscribers->orderBy($this->sortField, $this->sortDirection);
        }

        $subscribers = $subscribers->orderBy('created_at', 'asc')->paginate(10);


        return view('livewire.admin.master-data.subscribers.subscriber-manager', ['subscriptions' => $subscribers])->layout('components.layouts.admin');
    }
}
