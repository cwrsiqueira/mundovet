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
            <h1>Editar Paciente</h1>
        </div>
        <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
                <li class="breadcrumb-item"><a href="{{asset('/patient')}}">Pacientes</a></li>
                <li class="breadcrumb-item active">Editar Paciente</li>
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
                                <img class="img-fluid content_logo" src="{{asset('/assets/img/'.$patient->url_photo)}}">
    
                            </div>
                        </div>

                        <h3 class="profile-username text-center">{{$patient->name}}</h3>

                        <p class="text-muted text-center">Tutor: {{$patient->tutor}}</p>
                        <p class="text-muted text-center">Idade: {{$age['anos']}} ano(s) e {{$age['meses']}} mês(es)</p>

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
                                <form class="form-horizontal" method="POST" enctype="multipart/form-data" action="{{ route( 'patient.update', [ 'patient' => $patient->id ] ) }}">
                                    @csrf
                                    @method('PUT')

                                    <div class="logo_area hidden"></div>

                                    <div class="form-group row">
                                        <label for="inputchip_number" class="col-sm-2 col-form-label">N° Chip</label>
                                        <div class="col-sm-10">
                                            <input type="text" class="form-control @error('chip_number') is-invalid @enderror" id="inputchip_number" placeholder="Número do Chip" name="chip_number" value="{{$patient->chip_number}}">
                                        </div>
                                    </div>

                                    <div class="form-group row">
                                        <label for="inputName" class="col-sm-2 col-form-label">Nome</label>
                                        <div class="col-sm-10">
                                            <input type="text" class="form-control @error('name') is-invalid @enderror" id="inputName" placeholder="Nome" name="name" value="{{$patient->name}}">
                                        </div>
                                    </div>

                                    <div class="form-group row">
                                        <label for="inputspecies" class="col-sm-2 col-form-label">Espécie</label>
                                        <div class="col-sm-10">
                                            <input type="text" class="form-control @error('species') is-invalid @enderror" id="inputspecies" placeholder="Espécie" name="species" value="{{$patient->species}}">
                                        </div>
                                    </div>

                                    <div class="form-group row">
                                        <label for="inputcoat" class="col-sm-2 col-form-label">Pelagem</label>
                                        <div class="col-sm-10">
                                            <input type="text" class="form-control @error('coat') is-invalid @enderror" id="inputcoat" placeholder="Pelagem" name="coat" value="{{$patient->coat}}">
                                        </div>
                                    </div>

                                    <div class="form-group row">
                                        <label for="inputdate_birth" class="col-sm-2 col-form-label">Data de Nascimento</label>
                                        <div class="col-sm-10">
                                            <input type="date" class="form-control @error('date_birth') is-invalid @enderror" id="inputdate_birth" placeholder="Data de Nascimento" name="date_birth" value="@if(!empty($patient->date_birth)){{date('Y-m-d', strtotime($patient->date_birth))}}@else '0000-00-00' @endif">
                                        </div>
                                    </div>

                                    <div class="form-group row">
                                        <label for="inputdate_death" class="col-sm-2 col-form-label">Data de Óbito</label>
                                        <div class="col-sm-10">
                                            <input type="date" class="form-control @error('date_death') is-invalid @enderror" id="inputdate_death" placeholder="Data de Óbito" name="date_death" value="@if(!empty($patient->date_death)){{date('Y-m-d', strtotime($patient->date_death))}}@else '0000-00-00' @endif">
                                        </div>
                                    </div>

                                    <div class="form-group row">
                                        <label for="client_name" class="col-sm-2 col-form-label">Tutor</label>
                                        <div class="col-sm-10">
                                            <input type="hidden" name="id_client" value="{{$patient->id_tutor}}" id="id_client">
                                            <input required type="text" class="form-control @error('tutor') is-invalid @enderror" id="client_name" data-type="search_client" placeholder="Tutor" name="tutor" value="{{$patient->tutor}}">
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
    <script>
        
        function selectClient(obj) {
            var id = $(obj).attr('data-id');
            var name = $(obj).html();

            $('.searchresults').hide();
            $('#client_name').val(name);
            $('input[name=id_client]').val(id);
        }

        $(function(){
        // Consultar e pegar nome do Tutor
            $('#client_name').keyup(function(){
                var datatype = $(this).attr('data-type');
                var q = $(this).val();
                
                if (q.length <= 3) {
                    $('.searchresults').hide();
                }

                if (q.length > 3) {

                    $.ajax({
                        url:"{{ route('search_client') }}",
                        type:"get",
                        data: $(this).serialize(),
                        dataType:"json",
                        befoneSend:function() {},
                        success:function(json) {
                            if( $('.searchresults').length == 0 ) {
                                $('#client_name').after('<div class="searchresults"></div>');
                            }
                            var res_width = $('#client_name').css('width');
                            $('.searchresults').css('width', res_width);

                            var html = '';

                            for(var i in json) {
                                html += '<div class="si"><a href="javascript:;" onclick="selectClient(this)" data-id="'+json[i].id+'">'+json[i].name+'</a></div>';
                            }

                            $('.searchresults').html(html);
                            $('.searchresults').show();
                        }
                    });

                }

            });
            
        });
    </script>

@stop
