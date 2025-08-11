<?php

namespace App\Livewire\Frontend\Abouts;

use App\Helpers\Flash;
use App\Mail\ContactMail;
use App\Models\Contact;
use Artesaos\SEOTools\Facades\SEOTools;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;
use Livewire\Component;

class ContactComponent extends Component
{
    public $name;
    public $email;
    public $phone_number;
    public $subject;
    public $contact_message;
    public $success_message;
    public $recaptcha_token;

    public $showConfirmModal = false;


    protected $listeners = [
        'showModal',
    ];

    public function showModal()
    {
        $this->showConfirmModal = true;
    }


    public function rules()
    {
        return [
            'name' => 'required|min:8',
            'subject' => 'required|min:5',
            'email' => 'required|email',
            'contact_message' => 'required|min:3|max:500',
            'recaptcha_token' => 'required',
        ];
    }

    protected $message = [
        'name.required' => 'El campo nombre es requerido',
        'name.min' => 'El nombre completo debe tener al menos 8 caracterestes',
        'email.required' => 'El campo correo electrónico es requerido',
        'subject.required' => 'El campo asunto es requerido',
        'subject.min' => 'El campo debe tener al menos 5 caracterestes',
        'phone_number.required' => 'El número de teléfono es requerido',
        'contact_message.required' => 'El mensaje mensaje es requerido',
        'contact_message.min' => 'El mensaje debe tener al menos 3 caracteres',
        'contact_message.max' => 'El mensaje debe tener como máximmo 500 caracteres',
    ];

    protected $validationAttributes = [
        'name' => 'nombre completo',
        'email' => 'correo electrónico',
        'subject' => 'asunto',
        'contact_message' => ' mensaje',
        'recaptcha_token' => 'reCAPTCHA'
    ];

    public function mount()
    {
        SEOTools::webPage(
            'Dirkko Perú | Contáctanos | Productos Personalizados', //Title
            'Con Fluye puedes hacer regalos corporativos personalizados para tu equipo y clientes. Completa el formulario y cotiza aquí las opciones que tenemos para tu empresa.', //Description
            'tazas personalizadas, termos con diseño, tomatodos únicos, chopps personalizados, termolatas a medida, regalos personalizados, Dirkko Perú', //keywords
            'contact',  //urlCanonica
            'website', //webpage
            'images/logo-dirkko-black.png', //images
            'Productos Personalizados - Dirkko Perú' //alt
        );
    }

    public function store()
    {

        $this->validate();

        // Obtener el token del formulario
        $recaptchaToken = $this->recaptcha_token;

        if (!$recaptchaToken) {
            return back()->withErrors(['recaptcha' => 'No se recibió el token de reCAPTCHA.']);
        }

        // Verificar el token con Google
        $response = Http::asForm()->post('https://www.google.com/recaptcha/api/siteverify', [
            'secret' => env('RECAPTCHA_SECRET_KEY'),
            'response' => $recaptchaToken,
        ]);

        $body = $response->json();
        //Log::info("Respuesta de reCAPTCHA: ", $body);

        if (!$body['success'] || $body['score'] < 0.5) {
            return back()->withErrors(['recaptcha' => 'No se pudo verificar el reCAPTCHA.']);
        }

        $contact = Contact::create([
            'name' => $this->name,
            'email' => $this->email,
            'phone_number' => $this->phone_number,
            'subject' => $this->subject,
            'message' => $this->contact_message,
        ]);

        $mail = new ContactMail($contact);
        $email_contact = env('MAIL_USERNAME');

        Mail::to($contact->email)->bcc($email_contact)->queue($mail);

        $this->resetForm();
        $this->showModal();

       // if ($this->validate) {
            //$this->showConfirmModal = true;
      //  }

    }


    //Flash::success('Formulario enviado exitosamente');

    private function resetForm()
    {
        $this->name = '';
        $this->subject = '';
        $this->email = '';
        $this->contact_message = '';
        // $this->privacy_policies = false;
    }

    public function render()
    {
        return view('livewire.frontend.abouts.contact-component');
    }
}
