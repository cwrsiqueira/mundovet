@extends('adminlte::page')

@section('title', 'Consultas')

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
            <h1>Consulta</h1>
        </div>
        <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
                <li class="breadcrumb-item"><a href="{{asset('/consult')}}">Consultas</a></li>
                <li class="breadcrumb-item active">Consulta</li>
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
                <div class="tab-content">

                    <div class="tab-pane active" id="settings">
                        <form class="form-horizontal" method="POST" action="{{ route( 'consult.store' ) }}">
                            @csrf

                            <div class="card card-primary card-outline">
                                <div class="card-header">
                                    <h3 class="card-title">Informações Iniciais</h3>
                                </div>
                                <div class="card-body">
                                    {{-- Consulta / Retorno --}}
                                    <div class="form-check-inline">
                                        <label class="form-check-label" for="consulta">
                                            <input type="radio" class="form-check-input" id="consulta" name="consulta" value="consulta" {{ (collect(old('consulta'))->contains('consulta')) ? 'checked':'' ?: 'checked' }} > Consulta
                                        </label>
                                    </div>

                                    <div class="form-check-inline">
                                        <label class="form-check-label" for="radio2">
                                            <input type="radio" class="form-check-input" id="radio2" name="consulta" value="retorno" {{ (collect(old('consulta'))->contains('retorno')) ? 'checked':'' }} > Retorno
                                        </label>
                                    </div>
                                </div>
                            </div>
                            
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="card">
                                        <div class="card-body le-1">
                    
                                            {{-- Informações Iniciais --}}
                                            <div class="form-group">
                                                <label for="data">Data:</label>
                                                <input type="date" class="form-control" id="data" name="data_consulta" required value="{{ old('data_consulta') ?? date('Y-m-d') }}">
                                            </div>

                                            <div class="form-group">
                                                <label for="client_name">Cliente:</label>
                                                <input type="hidden" name="id_client" id="id_client" value="{{old('id_client')}}" required>
                                                <input type="text" class="form-control @error('warning') is-invalid @enderror" id="client_name" name="tutor" value="{{old('tutor')}}" required @if( old('tutor') ) readonly @endif>
                                            </div>

                                            <div class="form-group">
                                                <label for="patient_name">Paciente:</label>
                                                <input type="hidden" name="id_patient" value="{{old('id_patient')}}" required>
                                                <input type="text" class="form-control @error('warning') is-invalid @enderror" id="patient_name" name="name" value="{{old('name')}}" required @if( old('name') ) readonly @endif>
                                            </div>

                                        </div>
                                    </div>
                                </div>
                    
                                <div class="col-md-6">
                                    <div class="card">
                                        <div class="card-body ld-1">  
                                            
                                            <div class="form-group">
                                                <label for="sexo">Sexo:</label>
                                                <select name="sexo" class="form-control">
                                                    <option value="mac" @if( old('mac') ) selected @endif>Macho</option>
                                                    <option value="fem" @if( old('fem') ) selected @endif>Fêmea</option>
                                                </select>
                                            </div>      
                    
                                            <div class="form-group">
                                                <label for="peso">Peso: <small>(kilogramas)</small></label>
                                                <input type="text" class="form-control" id="peso" name="peso" required value="{{old('peso')}}">
                                            </div>
                    
                                            <div class="form-group">
                                                <label>Motivo da Consulta:</label>
                                                <textarea class="form-control" rows="3" name="motivo" placeholder="Breve descrição do motivo... ">{{old('motivo')}}</textarea>
                                            </div>
                                            
                                        </div>
                                    </div>
                                </div>
                            </div>
                    
                            <div class="card card-primary card-outline">
                                <div class="card-header">
                                    <h3 class="card-title">Selecione um formulário de consulta</h3>
                                </div>
                                <!-- /.card-header -->
                                <div class="card-body">
                                    <!-- Tipo de Consulta -->
                                    <div class="form-group">
                                        <div class="form-check-inline">
                                            <label class="form-check-label" for="tipo">
                                            <input type="radio" class="form-check-input" id="tipo" name="tipo" value="simples" {{ (collect(old('tipo'))->contains('simples')) ? 'checked':'' }} onclick="this.form.submit();">Formulário Rápido
                                            </label>
                                        </div>

                                        <div class="form-check-inline">
                                            <label class="form-check-label" for="tipo2">
                                            <input type="radio" class="form-check-input" id="tipo2" name="tipo" value="completa" {{ (collect(old('tipo'))->contains('completa')) ? 'checked':'' }} onclick="this.form.submit();">Formulário Completo
                                            </label>
                                        </div>
                                    </div>
                                    <!--  -->
                                </div>
                            </div>

                            <div class="consulta_simples {{ (collect(old('tipo'))->contains('simples')) ? 'show_aba':'hidden_aba' }}" id="consulta_simples">
                                <div class="card-header">
                                    <h3>Ficha de Consulta Simples</h3>
                                </div>
                                
                            </div>

                            <div class="consulta_completa {{ (collect(old('tipo'))->contains('completa')) ? 'show_aba':'hidden_aba' }}" id="consulta_completa">

                            </div>

                                <div class="card-footer">
                                    <div class="form-group row">
                                        <div class="offset-sm col-sm-12">
                                            <button type="submit" class="btn btn-info">Iniciar Consulta</button>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </form>
                    </div>
                <!-- /.tab-pane -->
                </div>
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

@section('js')
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery.form/4.2.2/jquery.form.min.js" integrity="sha384-FzT3vTVGXqf7wRfy8k4BiyzvbNfeYjK+frTVqZeNDFl8woCbF0CYG6g2fMEFFo/i" crossorigin="anonymous"></script>
<script src="{{asset('/assets/js/jquery.mask.min.js')}}"></script>
<script src="{{asset('/assets/js/script.js')}}"></script>
<script>

    // Incluir id e nome do cliente selecionado, nos devidos campos
    function selectClient(obj) {
        var id = $(obj).attr('data-id');
        var name = $(obj).html();

        $('.searchresults_client').hide();
        $('#client_name').val(name);
        $('input[name=id_client]').val(id);
        $('#patient_name').focus();
    }

    // Incluir id e nome do paciente selecionado, nos devidos campos
    function selectPatient(obj) {
        var id = $(obj).attr('data-id');
        var name = $(obj).html();

        $('.searchresults').hide();
        $('#patient_name').val(name);
        $('input[name=id_patient]').val(id);
        $('#peso').focus();
    }

    $(function(){

        //Ajustar tamanho dos campos card-body
        let height_le = $('.card-body.le-1').css('height');
        let height_ld = $('.card-body.ld-1').css('height');
        if (height_le > height_ld) {
            $('.card-body.ld-1').css('height', height_le);
        } else {
            $('.card-body.le-1').css('height', height_ld);
        }

        // Mask - Formato de dados
        $('#peso').mask('#0,000', {reverse: true});
        
        // Consultar e pegar nome do Cliente
        $('#client_name').keyup(function(){
            var q = $(this).val();
            
            if (q.length <= 0) {
                $('.searchresults_client').hide();
                $('input[name=id_client]').val('');
            }

            if (q.length > 0) {

                $.ajax({
                    url:"{{ route('search_client') }}",
                    type:"get",
                    data: $(this).serialize(),
                    dataType:"json",
                    befoneSend:function() {},
                    success:function(json) {
                        if( $('.searchresults_client').length == 0 ) {
                            $('#client_name').after('<div class="searchresults_client"></div>');
                        }
                        var res_width = $('#client_name').css('width');
                        $('.searchresults_client').css('width', res_width);

                        var html = '';

                        for(var i in json) {
                            html += '<div class="si"><a href="javascript:;" onclick="selectClient(this)" data-id="'+json[i].id+'">'+json[i].name+'</a></div>';
                        }

                        $('.searchresults_client').html(html);
                        $('.searchresults_client').show();
                    }
                });

            }

        });

        // Consultar e pegar nome do Paciente
        $('#patient_name').keyup(function(){
            var q = $(this).val();
            var idclient = $('#id_client').val();
            
            if (q.length <= 0) {
                $('.searchresults').hide();
                $('input[name=id_patient]').val('');
            }

            if (q.length > 0) {

                $.ajax({
                    url:"{{ route('search_patient') }}",
                    type:"get",
                    data: {name:q, idclient:idclient},
                    dataType:"json",
                    befoneSend:function() {},
                    success:function(json) {
                        if( $('.searchresults').length == 0 ) {
                            $('#patient_name').after('<div class="searchresults"></div>');
                        }
                        var res_width = $('#patient_name').css('width');
                        $('.searchresults').css('width', res_width);

                        var html = '';

                        for(var i in json) {
                            html += '<div class="si"><a href="javascript:;" onclick="selectPatient(this)" data-id="'+json[i].id+'">'+json[i].name+'</a></div>';
                        }

                        $('.searchresults').html(html);
                        $('.searchresults').show();
                    }
                });

            }

        });

        // Confirmar a inclusão de paciente
        $('#patient_name').blur(function(){
            setTimeout(() => {
                var input = $('input[name=id_patient]').val();
                if (input == '') {
                    if(confirm('Paciente não cadastrado. Gostaria de efetuar o cadastro agora?')) {
                        window.location = "{{route('patient.create')}}";
                    } else {
                        return false;
                    }
                }
            }, 200);
        });
        
    });
</script>

<script src="https://cdn.tiny.cloud/1/wt9fuwqo0mtch0lfna0f7aazeox5fyd9ak5io8sy97b28plf/tinymce/5/tinymce.min.js"></script>
<script>
    tinymce.init({
        selector:'textarea.simple_consult',
        height:300,
        menubar:false,
        plugins:['link', 'table', 'image', 'autoresize', 'lists'],
        toolbar:'undo redo | formatselect | bold italic backcolor | alignleft aligncenter alignright alignjustify | table | link image | bullist numlist',
        content_css:[
            '{{asset('assets/css/content.css')}}'
        ],
        images_upload_url:'{{route('imageupload')}}',
        images_upload_credential:true,
        convert_urls:false,
    });
</script>

@stop

@section('css')
    <link rel="stylesheet" href="{{asset('/assets/css/views.css')}}">
    <style>
    label.form-check-label {
        display: inline-flex;
        align-items: center;
    }
    </style>
@stop