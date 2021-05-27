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
            <h1>Editar Usuário</h1>
        </div>
        <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
                <li class="breadcrumb-item"><a href="{{asset('/user')}}">Usuários</a></li>
                <li class="breadcrumb-item active">Editar Usuário</li>
            </ol>
        </div>
    </div>
</div>
</section>

{{-- PAGE CONTENT --}}

<section class="content">
    <div class="container-fluid">
        <div class="row">
            
        <!-- /.col -->
            <div class="col-md">
                <div class="card card-primary card-outline">

                    <div class="card-body">
                        <div class="tab-content">

                            <div class="tab-pane active" id="settings">
                                <form class="form-horizontal" method="POST" 
                                action="{{ route( 'user.update', [ 'user' => $user['id'] ] ) }}">
                                    @csrf
                                    @method('PUT')

                                    <div class="form-group row">
                                        <label for="inputName" class="col-sm-2 col-form-label">Nome</label>
                                        <div class="col-sm-10">
                                            <input type="text" class="form-control @error('name') is-invalid @enderror" id="inputName" placeholder="Nome" name="name" value="{{ (!empty($user['name'])) ? $user['name'] : '' }}">
                                        </div>
                                    </div>

                                    <div class="form-group row">
                                        <label for="inputEmail" class="col-sm-2 col-form-label">E-mail</label>
                                        <div class="col-sm-10">
                                            <input type="email" class="form-control @error('email') is-invalid @enderror" id="inputEmail" placeholder="E-mail" name="email" value="{{ (!empty($user['email'])) ? $user['email'] : '' }}">
                                        </div>
                                    </div>

                                    <div class="form-group row">
                                        <label for="inputPassword" class="col-sm-2 col-form-label">Senha</label>
                                        <div class="col-sm-10">
                                            <input type="password" class="form-control @error('password') is-invalid @enderror" id="inputPassword" placeholder="Senha" name="password" value="">
                                        </div>
                                    </div>
                    
                                    <div class="form-group row">
                                        <label for="password_confirmation" class="col-sm-2 col-form-label">Confirmar Senha</label>
                                        <div class="col-sm-10">
                                            <input type="password" name="password_confirmation" id="password_confirmation" placeholder="Confirmar Senha" class="form-control @error('password') is-invalid @enderror" >
                                        </div>
                                    </div>

                                    <div class="form-group row">
                                        <label for="password_confirmation" class="col-sm-2 col-form-label">Selecionar Permissão</label>
                                        <div class="col-sm-10">
                                            <select class="form-control @error('id_permission') is-invalid @enderror" name="id_permission">
                                                <option value=""></option>
                                                @foreach ($permissions as $item)
                                                    <option @if($user['id_permission'] == $item['id']) selected @endif value="{{$item['id']}}">{{$item['name']}}</option>
                                                @endforeach
                                            </select>
                                        </div>
                                    </div>

                                    <div class="form-group row">
                                        <div class="offset-sm-2 col-sm-10">
                                            <button type="submit" class="btn btn-danger">Salvar</button>
                                        </div>
                                    </div>

                                </form>
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
