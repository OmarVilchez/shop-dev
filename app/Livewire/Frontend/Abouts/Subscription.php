<?php

namespace App\Livewire\Frontend\Abouts;

use App\Helpers\Flash;
use App\Jobs\CreateContactSyncBrevoJob;
use App\Jobs\SendEmailSubscriptionJob;
use App\Models\Subscription as ModelsSubscription;
use Carbon\Carbon;
use Livewire\Component;

class Subscription extends Component
{
    public $name;
    public $email;

    protected $rules = [
        'name' => 'nullable',
        'email' => 'required|email|unique:subscriptions',
    ];

    protected $messages = [
        'email.required' => 'El email es requerido.',
        'email.email' => 'El email debe ser una dirección válida.',
        'email.unique' => 'El email ya suscrito'
    ];


    public function subscribe()
    {
        $this->validate();

        // Crea un nuevo suscriptor.
        $subscriber = ModelsSubscription::create([
            'email' => trim($this->email),
            'data' => ['name' => trim($this->name)],
            'data_sync' => ['brevo' => ['sync' => 0, 'data_log' => []]],
            'active' => true,
            'subscribed_at' => Carbon::now(),
        ]);


        //Invoca al job para crear el contacto en Brevo.
        CreateContactSyncBrevoJob::dispatch($subscriber);

        // Envia el correo de suscripción usando una plantilla de Brevo.
        SendEmailSubscriptionJob::dispatch($subscriber);

        // Envio de correo de suscription exitosa - Correo Manual
       // $subscriptionMail = new SubscriptionMail($subscriber);
       // Mail::to($subscriber->email)->bcc($this->email_contact)->queue($subscriptionMail);

        $this->resetForm();
        Flash::success('Gracias por suscribirte a nuestra comunidad');
    }

    public function resetForm()
    {
        $this->email = '';
    }

    public function render()
    {
        return view('livewire.frontend.abouts.subscription');
    }
}


   // $subscriber = ModelsSubscription::create(['email' => $this->email], [
        //     'email' => trim($this->email),
        //     'data' => ['name' => trim($this->name)],
        //     'data_sync' => ['brevo' => ['sync' => 0, 'data_log' => []]],
        //     'active' => true,
        //     'subscribed_at' => Carbon::now(),
        // ]);
