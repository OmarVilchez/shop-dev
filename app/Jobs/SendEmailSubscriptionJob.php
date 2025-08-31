<?php

namespace App\Jobs;

use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Queue\Queueable;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use App\Models\Subscription as Subscriber;
use App\Services\BrevoService;
use App\Traits\DataConfiguration;
use Exception;
use Illuminate\Support\Facades\Log;

class SendEmailSubscriptionJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels, DataConfiguration;

    public $subscriber;
    public $facebook;


    /**
     * Create a new job instance.
     */
    public function __construct(Subscriber $subscriber)
    {
        $this->subscriber = $subscriber;

        $this->socialmedia();
    }

    /**
     * Execute the job.
     */
    public function handle(): void
    {
        // Obtenemos al suscriptor creado
        $subscriber = Subscriber::find($this->subscriber->id);

        if (!$subscriber) {
            Log::error("Suscriptor no encontrado: {$this->subscriber->id}");
            return;
        }

        $brevo = new BrevoService();

       // $name = $subscriber->data['name'] ?? 'Nuevo Suscriptor Agregado';
        //$name = 'nuevo suscriptor';

        try {
            $brevo->sendSubscriptionEmail(
                $subscriber->email,
                $subscriber->email,
                1, // nro de template o plantilla en brevo
                [
                    'facebook' => $this->facebook ?? ''
                ]
            );
        } catch (Exception $e) {
            Log::error("Error en SendEmailSubscriptionJob: " . $e->getMessage());
            throw $e;
        }
    }
}
