<!DOCTYPE html>
<html lang="en">
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.2.1/css/bootstrap.min.css" integrity="sha384-GJzZqFGwb1QTTN6wy59ffF1BuGJpLSa9DkKMp0DgiMDm4iYMj70gZWKYbI706tWS" crossorigin="anonymous">
    <link href="https://fonts.googleapis.com/css2?family=Roboto+Condensed:wght@300&display=swap" rel="stylesheet">
    <title>Pacientes - {{$company->trade_name}}</title>
</head>
<body>

  <div class="container-fluid border">
    
    <div class="jumbotron">
      <div style="text-align: center">
          <img width="100" style="border-radius: 50%;" src="{{asset('/assets/img/'.$company->url_logo)}}">
          <h1>{{$company->trade_name ?? $company->name}}</h1>
      </div>
    </div>

  </div>

  <div class="container">

    <a href="#" onclick="this.remove();window.print();prevent.default();" class="btn btn-info btn-sm my-3">Imprimir</a>

      <h3>Lista de Pacientes</h3>
        
      <table class="col-sm-12 table table-bordered">
        <thead>
            <tr>
              <th></th>
              <th>Nome</th>
              <th>Idade</th>
              <th>Espécie</th>
              <th>Pelagem</th>
            </tr>
          </thead>
          <tbody>
              @foreach($patients as $item)
              <tr>
                <td> <img width="50" src="{{asset('/assets/img/'.$item->url_photo)}}"> </td>
                <td><a href="{{route('patient.show', ['patient' => $item->id])}}">{{$item->name}}</a></td>
                @if ($item->age['anos'] <= 100)
                <td>{{$item->age['anos']}} ano(s) e {{$item->age['meses']}} mês(es)</td>
                @else
                <td>Corrigir data de nascimento</td>
                @endif
                <td>{{$item->species}}</td>
                <td>{{$item->coat}}</td>
              </tr>
            @endforeach
          </tbody>
      </table>

  </div>
    
</body>
</html>
