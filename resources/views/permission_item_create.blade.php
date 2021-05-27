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
            <h1>Adicionar Itens de Permissão</h1>
        </div>
        <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
                <li class="breadcrumb-item"><a href="{{asset('/permission')}}">Permissões</a></li>
                <li class="breadcrumb-item active">Adicionar Itens de Permissão</li>
            </ol>
        </div>
    </div>
</div>
</section>

{{-- PAGE CONTENT --}}

<section class="content">
    <div class="container-fluid">
        <div class="row">

            <div class="col-md">
                <div class="card card-primary card-outline">

                    <div class="card-body">
                        <div class="tab-content">

                            <div class="tab-pane active" id="settings">
                                <form class="form-horizontal" method="POST" action="{{ route('permission_item.store')}}">
                                    @csrf

                                    <div class="form-group row">
                                        <label for="inputName" class="col-sm-2 col-form-label">Nome</label>
                                        <div class="col-sm-10">
                                            <input type="text" class="form-control @error('name') is-invalid @enderror" id="inputName" placeholder="Nome" name="name">
                                        </div>
                                    </div>

                                    <div class="form-group row">
                                        <div class="offset-sm-2 col-sm-10">
                                            <button type="submit" class="btn btn-info">Salvar</button>
                                        </div>
                                    </div>

                                </form>
                                <div class="card-body table-responsive p-0" style="height: 300px;">
                                    <table class="table table-head-fixed">
                                      <thead>
                                        <tr>
                                          <th>ID</th>
                                          <th>Item Nome</th>
                                          <th>Slug</th>
                                          <th colspan="2" style="text-align:center;">Ações</th>
                                        </tr>
                                      </thead>
                                      <tbody>
                                        @foreach ($permission_item as $item)
                                            <tr>
                                                <td>{{$item['id']}}</td>
                                                <td>{{$item['name']}}</td>
                                                <td>{{$item['slug']}}</td>
                                                <td style="text-align:center;">
                                                    <a href=" {{ route('permission_item.edit', [ 'permission_item' => $item['id'] ]) }} " class="btn btn-sm btn-info">Editar</a>
                                                </td>
                                                <td style="text-align:center;">
                                                    <form action=" {{ route('permission_item.destroy', [ 'permission_item' => $item['id'] ]) }} " method="POST" onsubmit="return confirm('Confirma a exclusão do item?')">
                                                        @csrf
                                                        @method('DELETE')
                                                        <button class="btn btn-sm btn-danger">Excluir</button>
                                                    </form>
                                                </td>
                                            </tr>
                                        @endforeach
                                      </tbody>
                                    </table>
                                  </div>
                            </div>
                        <!-- /.tab-pane -->
                        </div>
                    <!-- /.tab-content -->
                    </div><!-- /.card-body -->
                </div>
            <!-- /.nav-tabs-custom -->
            </div>
        <!-- /.col -->
        </div>
    <!-- /.row -->
    </div><!-- /.container-fluid -->
</section>



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
