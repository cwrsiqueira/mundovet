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
            <h1>Editar Permissão</h1>
        </div>
        <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
                <li class="breadcrumb-item"><a href="{{asset('/permission')}}">Permissões</a></li>
                <li class="breadcrumb-item active">Editar Permissão</li>
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
                                    <form class="form-horizontal" method="POST" 
                                    action="{{ route( 'permission.update', [ 'permission'=>$permission['id'] ] ) }}
                                    ">
                                    @csrf
                                    @method('PUT')

                                    <div class="form-group row">
                                        <label for="inputName" class="col-sm-2 col-form-label">Nome</label>
                                        <div class="col-sm-10">
                                            <input type="text" class="form-control @error('name') is-invalid @enderror" id="inputName" placeholder="Nome" name="name" value="{{$permission['name']}}">
                                        </div>
                                    </div>

                                    @foreach ($permission_items as $item)
                                        <div class="form-group">
                                            <div class="custom-control custom-checkbox">

                                                <input 

                                                @foreach ($permission_links as $link)
                                                    @if($link['id_permission_item'] == $item['id']) checked @endif
                                                @endforeach

                                                class="custom-control-input" type="checkbox" id="customCheckbox{{$item['id']}}" value="{{$item['id']}}"  name="permission_item[]">

                                                <label for="customCheckbox{{$item['id']}}" class="custom-control-label">{{$item['name']}}</label>

                                            </div>
                                    </div>
                                    @endforeach

                                    <div class="form-group row">
                                        <div class="offset-sm-2 col-sm-10">
                                            <button type="submit" class="btn btn-info">Salvar</button>
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
