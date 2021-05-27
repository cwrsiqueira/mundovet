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

        <h3>Ficha do Cliente</h3>

        <strong>Nome:</strong> {{$client->name}} <br>
        <strong>E-mail:</strong> {{$client->email}} <br>
        <strong>Aceita receber notícias:</strong> {{ ($client->newsletter_agree == 0) ? 'Não' : 'Sim' }} <br>
        <strong>Telefone:</strong> {{$client->phone}} <br>
        <strong>Whatsapp:</strong> {{$client->whatsapp}} <br>
        <strong>Data de Nascimento:</strong> {{ ($client->date_birth != null) ? date('d/m/Y', strtotime($client->date_birth)) : '' }} <br>
        <strong>CPF:</strong> {{$client->cpf}} <br>
        <strong>Identidade:</strong> {{$client->rg}} <br>
        <strong>CEP:</strong> {{$client->cep}} <br>
        <strong>Endereço Completo:</strong> {{$client->full_address}} <br>
        <strong>Obs.:</strong> {{$client->obs}} <br>
        <strong>Data do Cadastro:</strong> {{ date('d/m/Y', strtotime($client->created_at)) }} <br>
        <strong>Última atualização:</strong> {{ date('d/m/Y', strtotime($client->updated_at)) }} <br> <br>

        <h3>Pets</h3>

        @if (!empty($pets))
            
            <table class="col-sm-12 table">
                <thead>
                  <tr>
                    <th></th>
                    <th>Nome</th>
                    <th>Espécie</th>
                    <th>Pelagem</th>
                  </tr>
                </thead>
                <tbody>
                    @foreach($pets as $item)
                    <tr>
                      <td> <img width="100" @if (!empty($item->url_photo))
                          src="{{asset('/assets/img/'.$item->url_photo)}}"
                      @else
                          src="{{asset('/assets/media/default.jpg') }}"
                      @endif> </td>
                      <td><a href="{{route('patient.show', ['patient' => $item->id])}}">{{$item->name}}</a></td>
                      <td>{{$item->species}}</td>
                      <td>{{$item->coat}}</td>
                    </tr>
                  @endforeach
                </tbody>
              </table>
            
        @endif

    </div>

     
    
</body>
</html>

