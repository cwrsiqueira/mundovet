@extends('adminlte::page')

@section('title', 'Permissões')

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
            <h1>Permissões</h1>
        </div>
        <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
                <li class="breadcrumb-item"><a href="{{asset('/home')}}">Home</a></li>
                <li class="breadcrumb-item active">Permissões</li>
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
                  <a href="{{ route('permission.create') }}" class="btn btn-info">Cadastrar Permissão</a>
              </div>
            </div>
            <div class="col-sm">
              {{-- <div class="card-tools">
                  <a href="{{ route('permission_item.create') }}" class="btn btn-danger">Cadastrar Item de Permissão</a>
              </div> --}}
            </div>
          </div>
        </div>
        
        <!-- /.card-header -->
        <div class="card-body table-responsive p-0" style="height: 300px;">
          <table class="table table-head-fixed">
            <thead>
              <tr>
                <th>Nível de Permissão</th>
                <th>Qt. Autorizados</th>
                <th colspan="2" style="text-align:center;">Ações</th>
              </tr>
            </thead>
            <tbody>
              @foreach ($permission_group as $item)
              <tr>
                  <td>{{$item->name}}</td>
                  <td>{{$item->qt_user}}</td>
                  <td style="text-align:center;">
                      <a title="Editar" href=" {{ route('permission.edit', [ 'permission' => $item->id ]) }} " class="btn btn-sm btn-success"><i class='far fa-edit' style="font-size: 16px;"></i></a>
                  </td>
                  <td style="text-align:center;">
                      <form title="Excluir" action=" {{ route('permission.destroy', [ 'permission' => $item->id ]) }} " method="POST" 
                      @if ($item->qt_user > 0)
                          onsubmit="alert('Existe usuário vinculado a esta permissão. Não permitida a exclusão.'); return false;"
                      @else
                          onsubmit="return confirm('Confirma a exclusão do usuário?')"
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
  {{ $permission_group->links() }}


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
