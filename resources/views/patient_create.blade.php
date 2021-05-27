@extends('adminlte::page')

@section('title', 'Pacientes')

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
            <h1>Cadastrar Paciente</h1>
        </div>
        <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
                <li class="breadcrumb-item"><a href="{{asset('/patient')}}">Pacientes</a></li>
                <li class="breadcrumb-item active">Cadastrar Paciente</li>
            </ol>
        </div>
    </div>
</div>
</section>

{{-- PAGE CONTENT --}}

<section class="content">
    <div class="container-fluid">
        <div class="row">

            <div class="col-md-3 edit_logo">

                <!-- Profile Image -->
                <div class="card card-primary card-outline">
                    <div class="card-body box-profile">
                        <div class="text-center">
                            <div class="over-logo">
                                <h3>Inserir/Alterar Logo</h3>
                            </div>
    
                            <div class="area_logo">
    
                                <div class="logo_preview"></div>
                                <img class="img-fluid content_logo" src="{{asset('/assets/media/default.jpg')}}">
    
                            </div>
                        </div>

                        <h3 class="profile-username text-center">Paciente</h3>

                        <p class="text-muted text-center">Tutor</p>
                        <p class="text-muted text-center">Idade</p>

                    </div>
                    <!-- /.card-body -->
                </div>
                <!-- /.card -->

            </div>
            
        <!-- /.col -->
            <div class="col-md-9">
                <div class="card card-primary card-outline">

                    <div class="card-body">
                        <div class="tab-content">

                            <div class="tab-pane active" id="settings">
                                <form class="form-horizontal" method="POST" enctype="multipart/form-data" action="{{ route( 'patient.store' ) }}">
                                    @csrf

                                    <div class="logo_area hidden"></div>

                                    <div class="form-group row">
                                        <label for="inputchip_number" class="col-sm-2 col-form-label">N° Chip</label>
                                        <div class="col-sm-10">
                                            <input type="text" class="form-control @error('chip_number') is-invalid @enderror" id="inputchip_number" placeholder="Número do Chip" name="chip_number" value="{{old('chip_number')}}">
                                        </div>
                                    </div>

                                    <div class="form-group row">
                                        <label for="inputName" class="col-sm-2 col-form-label">Nome</label>
                                        <div class="col-sm-10">
                                            <input type="text" class="form-control @error('name') is-invalid @enderror" id="inputName" placeholder="Nome" name="name" value="{{old('name')}}">
                                        </div>
                                    </div>

                                    <div class="form-group row">
                                        <label for="inputspecies" class="col-sm-2 col-form-label">Espécie</label>
                                        <div class="col-sm-10">
                                            <input type="text" class="form-control @error('species') is-invalid @enderror" id="inputspecies" placeholder="Espécie" name="species" value="{{old('species')}}">
                                        </div>
                                    </div>

                                    <div class="form-group row">
                                        <label for="inputcoat" class="col-sm-2 col-form-label">Pelagem</label>
                                        <div class="col-sm-10">
                                            <input type="text" class="form-control @error('coat') is-invalid @enderror" id="inputcoat" placeholder="Pelagem" name="coat" value="{{old('coat')}}">
                                        </div>
                                    </div>

                                    <div class="form-group row">
                                        <label for="inputdate_birth" class="col-sm-2 col-form-label">Data de Nascimento</label>
                                        <div class="col-sm-10">
                                            <input required type="date" class="form-control @error('date_birth') is-invalid @enderror" id="inputdate_birth" placeholder="Data de Nascimento" name="date_birth" value="{{old('date_birth')}}">
                                        </div>
                                    </div>

                                    <div class="form-group row">
                                        <label for="inputdate_death" class="col-sm-2 col-form-label">Data de Óbito</label>
                                        <div class="col-sm-10">
                                            <input type="date" class="form-control @error('date_death') is-invalid @enderror" id="inputdate_death" placeholder="Data de Óbito" name="date_death" value="{{old('date_death')}}">
                                        </div>
                                    </div>

                                    <div class="form-group row">
                                        <label for="client_name" class="col-sm-2 col-form-label">Tutor</label>
                                        <div class="col-sm-10">
                                            <input type="hidden" name="id_client" id="id_client" value="{{$client['id']}}">
                                            <input required readonly type="text" class="form-control @error('tutor') is-invalid @enderror" id="client_name"  placeholder="Tutor" name="tutor" value="{{$client['name']}}">
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

@section('css')
    <link rel="stylesheet" href="{{asset('/assets/css/views.css')}}">
@stop

@section('js')
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery.form/4.2.2/jquery.form.min.js" integrity="sha384-FzT3vTVGXqf7wRfy8k4BiyzvbNfeYjK+frTVqZeNDFl8woCbF0CYG6g2fMEFFo/i" crossorigin="anonymous"></script>
    <script src="{{asset('/assets/js/jquery.mask.min.js')}}"></script>
    <script src="{{asset('/assets/js/script.js')}}"></script>   

@stop
