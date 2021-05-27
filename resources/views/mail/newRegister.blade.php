@component('mail::message')
<h1>Confirmação de Cadastro</h1>

<p>Olá, {{$client->name}}!</p>

<p>Para completar seu cadastro, clique no botão abaixo e confirme seu e-mail.
    <br>
    Obrigado e seja bem vindo ao MundoVet!
</p>

<p>Qualquer dúvida entre em contato conosco.<br>
Atenciosamente,</p>
<p>
    <img width="50px" src="{{asset('assets/media/logo.jpg' ?? '')}}">
    Mundo.vet.br
    <br>
    contato@mundo.vet.br
    <br>
    {{'Whatsapp: (96) 9 9110 - 0451' ?? ''}}
    <br>
    https://www.mundo.vet.br/

</p>
@endcomponent
