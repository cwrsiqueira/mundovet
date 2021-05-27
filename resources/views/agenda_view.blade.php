<!DOCTYPE html>
<html lang="en">
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.2.1/css/bootstrap.min.css" integrity="sha384-GJzZqFGwb1QTTN6wy59ffF1BuGJpLSa9DkKMp0DgiMDm4iYMj70gZWKYbI706tWS" crossorigin="anonymous">
    <title>{{$client->name}} - {{$company->trade_name}}</title>
</head>
<body>

    <div class="container-fluid border p-3">

      <div class="jumbotron">
        <div style="text-align: center">
            <img width="100" style="border-radius: 50%;" src="{{asset('/assets/img/'.$company->url_logo)}}">
            <h1>{{$company->trade_name ?? $company->name}}</h1>
        </div>
      </div>

    </div>

      <div class="container">

        <a href="#" onclick="this.remove();window.print();prevent.default();" class="btn btn-info btn-sm my-3">Imprimir</a>

        <h3>Consulta Agendada</h3>

        <strong>Cliente:</strong> <a href="{{route('client.show', ['client' => $client->id])}}">{{$client->name}}</a> <br>
        <strong>Paciente:</strong> <a href="{{route('patient.show', ['patient' => $patient->id])}}">{{$patient->name}}</a> <br>
        <strong>Data e Hora da Consulta:</strong> {{ date('d/m/Y - H:i:s', strtotime($agendamento['data_consulta'])) }} <br>
        <strong>Consulta/Retorno:</strong> {{$agendamento->consulta_retorno}} <br>
        <strong>Motivo da Consulta:</strong> {{$agendamento->motivo}} <br>
        @if(!empty($agendamento->status_agendamento))
        <strong>Status:</strong> {{$agendamento->status_agendamento}} <br>
        @endif
        <strong>Agendamento realizado em:</strong> {{ date('d/m/Y', strtotime($agendamento->created_at)) }} <br> <br>

    </div>

     
    
</body>
</html>

