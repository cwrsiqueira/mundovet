@component('mail::message')
<h1>Agendamento de Consulta</h1>

<p>Olá, {{$client->name}}!</p>

<p>Essa é uma mensagem de: {{$company->name ?? ''}}</p>
<p>A consulta para {{$patient->name}} foi agendada para {{date('d/m/Y à\s H:i', strtotime($agendamento->data_consulta))}}.</p>

<p>Qualquer dúvida, alteração, cancelamento ou caso não tenha agendado uma consulta entre em contato conosco.<br>
Atenciosamente,</p>
<p>
    <img src="{{asset('assets/img/'.$company->url_logo ?? '')}}">
    {{$company->name ?? ''}}
    <br>
    {{$company->email ?? ''}}
    <br>
    {{'Telefone: '.$company->phone ?? ''}}
    {{'Whatsapp: '.$company->whatsapp ?? ''}}
    {{$company->website ?? ''}}

</p>
@endcomponent
