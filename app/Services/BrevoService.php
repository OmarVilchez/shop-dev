<?php

namespace App\Services;

use Brevo\Client\Configuration;
use Brevo\Client\Api\TransactionalEmailsApi;
use Brevo\Client\ApiException;
use Brevo\Client\Model\SendSmtpEmail;
use GuzzleHttp\Client;
use Illuminate\Support\Facades\Log;

class BrevoService
{
    protected $apiInstance;

    public function __construct()
    {
        $config = Configuration::getDefaultConfiguration()->setApiKey('api-key', env('BREVO_API_KEY'));

        $this->apiInstance = new TransactionalEmailsApi(new Client(), $config);
    }

    public function sendSubscriptionEmail($toName, $toEmail, $templateId, array $params = [])
    {
        $sendSmtpEmail = new SendSmtpEmail([
            'to' => [['name' => $toName, 'email' => $toEmail]],
            'templateId' => $templateId,
            'params' => $params
        ]);

        try {
            $this->apiInstance->sendTransacEmail($sendSmtpEmail);
        } catch (ApiException $e) {
            Log::error("Error al enviar correo de suscripción. Correo de suscriptor: $toEmail. Mensaje de error: {$e->getMessage()}");
            Log::error("Response body: " . $e->getResponseBody());
            throw $e; // Re-lanzar para manejo superior
        }
    }
}
