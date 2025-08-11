<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Mensaje de Contacto</title>
</head>

<body>
    <h1>Formulario de Contacto</h1>
    <p><strong>Name:</strong> {{ $contact->name }} </p>
    <p><strong>Email:</strong> {{ $contact->email }} </p>
    <p><strong>Nro Celular:</strong> {{ $contact->phone_number }} </p>
    <p><strong>Motivo:</strong> {{ $contact->subject }} </p>
    <p><strong>Mensaje:</strong> {{ $contact->message }} </p>
</body>

</html>
