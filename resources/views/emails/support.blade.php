@component('mail::message')
    # Novo Suporte

    Contato: {{ $name }} - {{ $email }}

    Tipo: {{ $type }}

    Mensagem:
    {{ $message }}

    * Esse e-mail é enviado automaticamente através do sistema!

    Obrigado,
    {{ config('app.name') }}
@endcomponent
