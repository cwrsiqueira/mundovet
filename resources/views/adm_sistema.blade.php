@extends('adminlte::page')

@section('title', 'Administração')

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
            <h1>Administração do Sistema</h1>
        </div>
        <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
                <li class="breadcrumb-item active">Administração do Sistema</li>
            </ol>
        </div>
    </div>
</div>
</section>

{{-- PAGE CONTENT --}}

    <div class="card">
        <div class="card-header">
            Planos de Assinatura
            <div class="card-tools">
                <!-- Button to Open the Modal -->
                <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#add_plan">
                    Criar Plano
                </button>
            </div>
        </div>
        <div class="card-body">
            <table class="table">
                <thead>
                    <tr>
                        <th>#</th>
                        <th>Nome</th>
                        <th>Intervalo</th>
                        <th>Repetições</th>
                        <th>Criação</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($planos as $item)
                        <tr>
                            <td>{{$item->plan_id}}</td>
                            <td>{{$item->name}}</td>
                            <td>{{$item->interval_plan}}</td>
                            <td>{{$item->repeats}}</td>
                            <td>{{$item->created_at_api}}</td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>




    {{-- MODAIS DA PÁGINA --}}
    
    <!-- The Modal -->
    <div class="modal" id="add_plan">
        <div class="modal-dialog">
        <div class="modal-content">
    
            <!-- Modal Header -->
            <div class="modal-header">
            <h4 class="modal-title">Criar Plano</h4>
            <button type="button" class="close" data-dismiss="modal">&times;</button>
            </div>
    
            <!-- Modal body -->
            <div class="modal-body">
                <form action="{{route('criar_plano')}}" method="post">
                    @csrf

                    <div class="row">
                        <div class="col-sm-6">
                            <label for="name">Nome do Plano</label>
                            <input class="form-control" type="text" name="name" id="name" placeholder="Nome do Plano">
                        </div>
                        <div class="col-sm-3">
                            <label for="interval_plan">Intervalo</label>
                            <input class="form-control" type="number" name="interval_plan" id="interval_plan" placeholder="Intervalo de meses">
                        </div>
                        <div class="col-sm-3">
                            <label for="repeats">Repetições</label>
                            <input class="form-control" type="number" name="repeats" id="repeats" placeholder="Repetições">
                        </div>
                    </div>
                    
            </div>
    
            <!-- Modal footer -->
            <div class="modal-footer justify-content-between">
                <input class="btn btn-primary" type="submit" value="Criar Plano">
                <button type="button" class="btn btn-danger" data-dismiss="modal">Fechar</button>
            </form>
            </div>
    
        </div>
        </div>
    </div>

{{-- END PAGE CONTENT --}}

@endsection

@section('footer')
    <footer>
        <div class="float-right d-none d-sm-inline">
        v3.0.3
        </div>
        <strong>Copyright © 2014-2020 <a href="https://adminlte.io">AdminLTE.io</a>.</strong> All rights reserved.
        | Powered & system developed by <strong>Copyright © 2020-{{date('Y')}} <a href="https://cwrsdevelopment.com/vetsystem">VetSystem</a>.</strong> All rights reserved.
    </footer>
@endsection

@section('css')

@stop

@section('js')

@stop
