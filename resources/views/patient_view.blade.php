<!DOCTYPE html>
<html lang="en">
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.2.1/css/bootstrap.min.css" integrity="sha384-GJzZqFGwb1QTTN6wy59ffF1BuGJpLSa9DkKMp0DgiMDm4iYMj70gZWKYbI706tWS" crossorigin="anonymous">
    <title>{{$patient->name}} - {{$company->trade_name}}</title>
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

        <h3>Ficha do patiente</h3>

        <div class="border p-2" style="width: 200px">
          <img width="100%" @if (!empty($patient->url_photo))
              src="{{asset('/assets/img/'.$patient->url_photo)}}"
          @else
              src="{{asset('/assets/media/default.jpg') }}"
          @endif>
        </div>

        <strong>Tutor:</strong> <a href="{{route('client.show', ['client' => $patient->tutor_id])}}">{{$patient->tutor_name}}</a> <br>

        <strong>#Chip:</strong> {{$patient->chip_number}} <br>

        <strong>Nome:</strong> {{$patient->name}} <br>

        @if ($age['anos'] <= 100)
          <strong>Idade:</strong> {{$age['anos']}} ano(s) e {{$age['meses']}} mês(es) <br>
        @else
          <strong>Idade:</strong> Corrigir data de nascimento <br>
        @endif

        <strong>Espécie/Raça:</strong> {{$patient->species}} <br>

        <strong>Pelagem:</strong> {{$patient->coat}} <br>

        @if ($age['anos'] <= 100)
        <strong>Data de Nascimento:</strong> {{ date('d/m/Y', strtotime($patient->date_birth)) }} <br>
        @else
        <strong>Data de Nascimento:</strong> Corrigir data de nascimento <br>
        @endif

        @if (!empty($patient->date_death))
          <strong>Data de Falecimento:</strong> {{ date('d/m/Y', strtotime($patient->date_death)) }} <br>
        @endif

        <strong>Data do Cadastro:</strong> {{ date('d/m/Y', strtotime($patient->created_at)) }} <br>
        <strong>Última atualização:</strong> {{ date('d/m/Y', strtotime($patient->updated_at)) }} <br> <br>

        <h3>Consultas Realizadas</h3>

        @if (!empty($consults))
            
            <table class="col-sm-12 table">
                <thead>
                  <tr>
                    <th>Ref.</th>
                    <th>Data</th>
                    <th>Consulta/Retorno</th>
                    <th>Motivo</th>
                  </tr>
                </thead>
                <tbody>
                    @foreach($consults as $item)
                    <tr>
                      <td><a href="{{route('consult.show', ['consult' => $item->id])}}">#{{$item->id}}</a></td>
                      <td>{{ date('d/m/Y', strtotime($item->data_consulta)) }}</td>
                      <td>{{$item->consulta}}</td>
                      <td>{{$item->motivo}}</td>
                    </tr>
                  @endforeach
                </tbody>
              </table>
            
        @endif


    </div>

     
    
</body>
</html>

