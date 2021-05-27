<!DOCTYPE html>
<html lang="en">
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.2.1/css/bootstrap.min.css" integrity="sha384-GJzZqFGwb1QTTN6wy59ffF1BuGJpLSa9DkKMp0DgiMDm4iYMj70gZWKYbI706tWS" crossorigin="anonymous">
    <link href="https://fonts.googleapis.com/css2?family=Roboto+Condensed:wght@300&display=swap" rel="stylesheet">
    <title>Clientes - {{$company->trade_name}}</title>
    <style>
      body {
        font-family: 'Roboto Condensed', sans-serif;
      }
    </style>
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

    <div class="card card-primary card-outline">

      <div class="card-header">
        <h3 class="card-title">Lista de Clientes</h3>
      </div>
      <!-- /.card-header -->

      <div class="card-body table-responsive p-0">
        <table class="table table-hover">
          <thead>
            <tr>
              <th>Nome</th>
              <th>E-mail</th>
              <th>Telefone</th>
              <th>Whatsapp</th>
            </tr>
          </thead>
          <tbody>
            @foreach ($clients as $item)
              <tr>
                <td><a href="{{route('client.show', ['client' => $item->id])}}">{{$item->name}}</a></td>
                <td>{{$item->email}}</td>
                <td>{{$item->phone}}</td>
                <td>{{$item->whatsapp}}</td>
              </tr>
            @endforeach
          </tbody>
        </table>
      </div>
      <!-- /.card-body -->
    </div>

  </div>
    
</body>
</html>
