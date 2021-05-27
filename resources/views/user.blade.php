@extends('adminlte::page')

@section('title', 'Usuários')

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
            <h1>Usuários</h1>
        </div>
        <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
                <li class="breadcrumb-item"><a href="{{asset('/home')}}">Home</a></li>
                <li class="breadcrumb-item active">Usuários</li>
            </ol>
        </div>
    </div>
</div>
</section>

<div class="row">
    <div class="col-12">
      <div class="card card-primary card-outline">
        <div class="card-header">
          <div class="row">
            <div class="col-sm">
              <div class="card-tools">
                  <a href="{{ route('user.create') }}" class="btn btn-info">Cadastrar Usuário</a>
              </div>
            </div>
          </div>
        </div>
        
        <!-- /.card-header -->
        <div class="card-body table-responsive p-0" style="height: 300px;">
          <table class="table table-head-fixed">
            <thead>
              <tr>
                <th>Nome do Usuário</th>
                <th>E-mail</th>
                <th>Data do Registro</th>
                <th>Permissão</th>
                <th colspan="2" style="text-align:center;">Ações</th>
              </tr>
            </thead>
            <tbody>
              @foreach ($users as $item)
              <tr>
                  <td>{{$item->name}}</td>
                  <td>{{$item->email}}</td>
                  <td>{{date('d/m/Y', strtotime($item->created_at))}}</td>
                  <td>{{$item->permission}}</td>
                  <td style="text-align:center;">
                      <a title="Editar" href=" {{ route('user.edit', [ 'user' => $item->id ]) }} " class="btn btn-sm btn-success"><i class='far fa-edit' style="font-size: 16px;"></i></a>
                  </td>
                  <td style="text-align:center;">
                      <form title="Excluir" action=" {{ route('user.destroy', [ 'user' => $item->id ]) }} " method="POST" 
                        @if ($loggedId != $item->id)
                          onsubmit="return confirm('Confirma a exclusão do usuário?')"
                        @else
                          onsubmit="alert('Você não pode excluir seu próprio usuário.'); return false;"
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
  {{ $users->links() }}


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
