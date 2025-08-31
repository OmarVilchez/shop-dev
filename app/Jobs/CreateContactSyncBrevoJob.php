<?php

namespace App\Jobs;

use App\Models\Subscription;
use Brevo\Client\Api\ContactsApi;
use Brevo\Client\ApiException;
use Brevo\Client\Configuration;
use Brevo\Client\Model\CreateContact;
use Carbon\Carbon;
use GuzzleHttp\Client;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Foundation\Queue\Queueable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Log;

class CreateContactSyncBrevoJob implements ShouldQueue
{
    //use Queueable;

    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    public $subscriber;

    /**
     * Create a new job instance.
     */
    public function __construct(Subscription $subscriber)
    {
        $this->subscriber = $subscriber;
    }

    /**
     * Execute the job.
     */
    public function handle(): void
    {
        // Obtenemos al suscriptor creado
        $subscriber = Subscription::find($this->subscriber->id);

        $config = Configuration::getDefaultConfiguration()->setApiKey('api-key', config('services.brevo'));
        $apiInstance = new ContactsApi(new Client(), $config);

        // ¿Suscriptor en lista negra?
        $emailBlacklisted = $smsBlacklisted = $subscriber->active ? false : true;

        // Identificador de la lista donde se guardará el contacto.
        $listIds = [2];

        $date = Carbon::now()->format('Y-m-d H:i:s');

        // Información del suscriptor a guardarse como contacto en Brevo.
        $contact = new CreateContact([
            'email' => $subscriber->email,
            'extId' => (string) $subscriber->id,
            'attributes' => ['NOMBRE' => $subscriber->data['name']],
            'emailBlacklisted' => $emailBlacklisted,
            'smsBlacklisted' => $smsBlacklisted,
            'listIds' => $listIds,
            'updateEnabled' => true
        ]);

        // Campo que guardará el resultado de la creación del contacto en Brevo.
        $dataSync = $subscriber->data_sync;

        try {
            // Intenta crear el contacto.
            $apiInstance->createContact($contact);

            // Resultado de la creación exitosa a guardar como JSON.
            $dataLog = [
                'code' => count($dataSync['brevo']['data_log']) > 0 ? 204 : 201,
                'message' => count($dataSync['brevo']['data_log']) > 0
                    ? 'The object was successfully updated or deleted'
                    : 'The object was successfully created',
                'created_at' => $date
            ];

            // Creación exitosa en Brevo es 1.
            $dataSync['brevo']['sync'] = 1;
        } catch (ApiException $e) {
            Log::error("Error al crear o actualizar el contacto en Brevo. Id de suscriptor: {$this->subscriber->id}. Mensaje de error: {$e->getMessage()}");

            // Respuesta del servidor de Brevo si no se creó el contacto.
            $dataLog = json_decode($e->getResponseBody(), true);

            // Agregamos la fecha y hora a la que nos retorno el mensaje.
            $dataLog['created_at'] = $date;

            // Fallo la creación en Brevo es -1.
            $dataSync['brevo']['sync'] = -1;
        }

        // Guardamos el resultado exitoso o fallido en el campo data_sync.
        $dataSync['brevo']['data_log'][] = $dataLog;
        $subscriber->data_sync = $dataSync;
        $subscriber->save();
    }
}
