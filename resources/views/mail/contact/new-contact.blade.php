@component('mail::message')
# Hola Administrador!,

Tienen un nuevo registro en su lista de contactos.

<p class="h5">Nombres: {{ $contact-> names }} </p>
<p class="h5">Apellidos: {{ $contact-> surnames }} </p>
<p class="h5">Email: {{ $contact-> email }} </p>
<p class="h5">Teléfono: {{ $contact-> phone }} </p>
<p class="h5">Empresa: {{ $contact-> company_name }} </p>

@component('mail::button', ['url' => route('admin.contacts.show',$contact), 'color' => 'primary-custom'])
    Ver detalle
@endcomponent

Saludos,<br>
{{ config('app.name') }}
@endcomponent
