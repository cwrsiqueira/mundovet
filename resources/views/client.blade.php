@extends('adminlte::page')

@section('title', 'Clientes')

@section('content')

@if ($errors->any())
<div class="alert alert-danger alert-dismissible">
    <button type="button" class="close" data-dismiss="alert" aria-hidden="true">x</button>
    <h5>
        <i class="icon fas fa-ban"></i>
        Erro!!!
    </h5>
    <ul>
        @foreach ($errors->all() as $error)
            <li>{{ $error }}</li>
        @endforeach
    </ul>
</div>
@endif

<section class="content-header">
<div class="container-fluid">
    <div class="row mb-2">
        <div class="col-sm-6">
            <h1>Clientes</h1>
        </div>
        <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
              <li class="breadcrumb-item"><a href="{{asset('/home')}}">Home</a></li>
                <li class="breadcrumb-item active">Clientes</li>
            </ol>
        </div>
    </div>
</div>
</section>

{{-- PAGE CONTENT --}}

<div class="row">
    <div class="col-12">
      <div class="card card-primary card-outline">


        <div class="card-header">
          <div class="row">
            <div class="col-sm">
              <a href="{{ route('client.create') }}" class="btn btn-info">Cadastrar Cliente</a>
            </div>
            <br> <br>
            <div class="col-sm">
              <a href="{{ route('client_list') }}" target="_blank" class="btn bg-olive">Listar Clientes</a>
            </div>
            <br> <br>
            <div class="col-sm">
              <div class="card-tools">
                <form method="get">
                  <div class="input-group input-group-sm float-right" style="width: 150px;">
                    <label>Pesquisar por Nome:</label>
                    <input type="search" id="search_client" name="tutor" class="form-control float-right" placeholder="Pesquisar">
      
                    <div class="input-group-append">
                      <button type="submit" class="btn btn-default"><i class="fas fa-search"></i></button>
                    </div>
                  </div>
                </form>
              </div>
            </div>
          </div>
        </div>
        <!-- /.card-header -->

        <div class="card-body table-responsive p-0" style="height: 300px;">
          <table class="table table-head-fixed">
            <thead>
              <tr>
                <th>Nome do Cliente</th>
                <th>E-mail</th>
                <th>Telefone</th>
                <th>Cad. Pets</th>
                <th colspan="3" style="text-align:center;">Ações</th>
              </tr>
            </thead>
            <tbody id="tbody">
              @foreach ($clients as $item)
              <tr>
                  <td>{{$item->name}}</td>
                  <td>{{$item->email}}</td>
                  <td>{{$item->phone}}</td>
                  <td>
                    <a title="Cadastrar Pet" href=" {{ route('patient.create', [ 'client' => $item->id ]) }} " class="btn btn-sm bg-secondary"><i class='fas fa-paw' style="font-size: 16px;"></i><span class="float-right badge bg-primary">{{$item->qt_pets}}</span></a>
                  </td>
                  <td style="text-align:center;">
                    <a title="Visualizar" href=" {{ route('client.show', [ 'client' => $item->id ]) }} " class="btn btn-sm bg-info" target="_blank"><i class='far fa-eye' style="font-size: 16px;"></i></a>
                  </td>
                  <td style="text-align:center;">
                      <a title="Editar" href=" {{ route('client.edit', [ 'client' => $item->id ]) }} " class="btn btn-sm btn-success"><i class='far fa-edit' style="font-size: 16px;"></i></a>
                  </td>
                  <td style="text-align:center;">
                      <form title="Excluir" action=" {{ route('client.destroy', [ 'client' => $item->id ]) }} " method="POST" 
                      @if ($item->qt_pets > 0)
                          onsubmit="alert('Existe paciente vinculado a este cliente. Não permitida a exclusão.'); return false;"
                      @else
                          onsubmit="return confirm('Confirma a exclusão do cliente?')"
                      @endif >
                          @csrf
                          @method('DELETE')
                          <button class="btn btn-sm btn-danger"><i class='far fa-trash-alt' style="font-size: 16px;"></i></button>
                      </form>
                  </td>
              </tr>
              @endforeach
            </tbody>
          </table>
        </div>
        <!-- /.card-body -->
      </div>
      <!-- /.card -->
    </div>
  </div>
  <div class="paginate_link">
    {{ $clients->links() }}
  </div>

{{-- END PAGE CONTENT --}}

@endsection

@section('footer')
    <footer>
        <div class="float-right d-none d-sm-inline">
        v3.0.3
        </div>
        <strong>Copyright © 2014-2020 <a href="https://adminlte.io">AdminLTE.io</a>.</strong> All rights reserved.
        | Powered & system developed by <strong>Copyright © 2020-{{date('Y')}} <a href="https://mundo.vet.br">MundoVet</a>.</strong> All rights reserved.
    </footer>
@endsection

@section('js')

    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery.form/4.2.2/jquery.form.min.js" integrity="sha384-FzT3vTVGXqf7wRfy8k4BiyzvbNfeYjK+frTVqZeNDFl8woCbF0CYG6g2fMEFFo/i" crossorigin="anonymous"></script>

@stop
