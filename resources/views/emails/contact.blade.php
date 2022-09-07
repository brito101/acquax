@component('mail::message')
    # Novo Contato

    Contato: {{ $name }} - {{ $email }}

    Serviço: {{ $msg_subject }}

    Telefone: {{ $phone_number }}

    Mensagem:
    {{ $message }}

    * Esse e-mail é enviado automaticamente através do sistema!

    Obrigado,
    {{ config('app.name') }}
@endcomponent
