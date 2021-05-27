@extends('adminlte::page')

@section('title', 'Marcar Consulta')

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
            <h1>Marcar Consulta</h1>
        </div>
        <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
                <li class="breadcrumb-item"><a href="{{asset('/agenda')}}">Agenda</a></li>
                <li class="breadcrumb-item active">Marcar Consulta</li>
            </ol>
        </div>
    </div>
</div>
</section>

{{-- PAGE CONTENT --}}

    <div class="card card-outline card-primary">
        <div class="card-header">
            Preencha um e-mail válido para marcar a consulta.
            Você receberá uma mensagem nesse e-mail, confirmando sua consulta.
        </div>

        <div class="card-body">
            <form class="form-horizontal form-marcar-consulta" method="POST" action="{{ route( 'agenda.store' ) }}">
            @csrf

                <label for="client_name">Nome do Cliente:</label>
                <input type="hidden" name="id_client" value="{{$client['id']}}">
                <input class="form-control @error('client_name') is-invalid @enderror" type="client_name" id="client_name" name="tutor" placeholder="Cliente" value="{{$client['name']}}" readonly required><br>

                <label for="email">E-mail cadastrado:</label>
                <input class="form-control @error('email') is-invalid @enderror" type="email" id="email" name="email" placeholder="E-mail" value="{{$client['email']}}" required><br>

                <label for="phone">Telefone:</label>
                <input class="form-control @error('phone') is-invalid @enderror" type="phone" id="phone" name="phone" placeholder="Telefone" value="{{$client['phone']}}" required><br>

                <label for="whatsapp">Whatsapp:</label>
                <input class="form-control @error('whatsapp') is-invalid @enderror" type="whatsapp" id="whatsapp" name="whatsapp" placeholder="WhatsApp" value="{{$client['whatsapp']}}"><br>

                <label for="patient_name">Nome do Paciente:</label>
                <div>
                    <input type="hidden" name="id_patient" value="{{$patient['id']}}">
                    <input id="patient_name" class="form-control @error('patient_name') is-invalid @enderror" type="patient_name"  name="name" placeholder="Paciente" value="{{$patient['name']}}" readonly required><br>
                </div>
            

                <div class="card">
                    <div class="card-header">
                        <h3 class="card-title">Selecionar Consulta / Retorno</h3>
                    </div>
                    <!-- /.card-header -->
                    <div class="card-body table-responsive p-0">
                        <!-- Consulta/Retorno -->
                        <div class="form-check-inline">
                            <label class="form-check-label" for="consulta">
                                <input type="radio" class="form-check-input" id="consulta" name="consulta_retorno" value="consulta" checked> Consulta
                            </label>
                        </div>

                        <div class="form-check-inline">
                            <label class="form-check-label" for="retorno">
                                <input type="radio" class="form-check-input" id="retorno" name="consulta_retorno" value="retorno"> Retorno
                            </label>
                        </div>
                    </div>
                        <!--  -->
                    <!-- /.card-body -->
                </div>

                <label for="motivo">Motivo da Consulta:</label>
                <textarea class="form-control @error('motivo') is-invalid @enderror" type="motivo" id="motivo" name="motivo" placeholder="Um resumo do motivo da consulta" value="">{{old('motivo')}}</textarea><br>

                <div class="form-group">

                    <label for="dt_retorno">Selecionar Data e Hora:</label>
                    <div class="row">
                        
                        <div class="col">
                            <div class="row flex-column" style="cursor: pointer;" data-toggle="modal" data-target="#modal_calendar">
                                <label for="">Data:</label>
                                <div class="d-flex align-items-center" style="border: 1px solid #ccc; background-color: #e9ecef;">
                                    <input type="hidden" name="id_data_retorno" value="">
                                    <input type="hidden" name="data_retorno" id="data_retorno" value="">
                                    <input readonly style="border:0; cursor:pointer;" type="text" value="" class="form-control @error('data_retorno') is-invalid @enderror" id="dt_retorno">
                                    <i class="fas fa-calendar-alt m-1" style="font-size:18px;"></i>
                                </div>
                                
                            </div>
                            <div class="row">
                                <label for="">Hora:</label>
                                <select title="Selecione a data para aparecer os horários disponíveis" class="form-control @error('data_retorno') is-invalid @enderror" name="hora_retorno" id="hr_retorno">
                                </select>
                            </div>
                        </div>
                    </div>

                    {{-- MODAL DO CALENDÁRIO --}}
                    <div class="modal fade" id="modal_calendar">
                        <div class="modal-dialog">
                            <div class="modal-content">

                                <!-- Modal Header -->
                                <div class="modal-header">
                                    <h4 class="modal-title">Escolher Data</h4>
                                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                                </div>

                                @include("layouts.calendar")

                                <!-- Modal footer -->
                                <div class="modal-footer">
                                    <button type="button" class="btn btn-danger" data-dismiss="modal">Close</button>
                                </div>

                            </div>
                        </div>
                    </div>
                    {{--  --}}
                        
                </div>

                <input class="btn btn-info btn-sm" type="submit" value="Enviar">
            </form>
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
    <link rel="stylesheet" href="{{asset('/assets/css/views.css')}}">
@stop

@section('js')
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery.form/4.2.2/jquery.form.min.js" integrity="sha384-FzT3vTVGXqf7wRfy8k4BiyzvbNfeYjK+frTVqZeNDFl8woCbF0CYG6g2fMEFFo/i" crossorigin="anonymous"></script>
    <script src="{{asset('/assets/js/jquery.mask.min.js')}}"></script>
    <script src="{{asset('/assets/js/script.js')}}"></script>
    <script>
        function selectClient(obj) {
            var id = $(obj).attr('data-id');
            var email = $(obj).attr('data-email');
            var phone = $(obj).attr('data-phone');
            var whatsapp = $(obj).attr('data-whatsapp');   
            var name = $(obj).html();

            $('.searchresults_client').hide();
            $('#client_name').val(name);
            $('input[name=id_client]').val(id);
            $('input[name=email]').val(email);
            $('input[name=phone]').val(phone);
            $('input[name=whatsapp]').val(whatsapp);
        }
        function selectPatient(obj) {
            var id = $(obj).attr('data-id');
            var name = $(obj).html();

            $('.searchresults_patient').hide();
            $('#patient_name').val(name);
            $('input[name=id_patient]').val(id);
        }

        $(function(){

            // Configurações Mask

            var SPMaskBehavior = function (val) {
            return val.replace(/\D/g, '').length === 11 ? '(00)00000-0000' : '(00)0000-00009';
            },
            spOptions = {
            onKeyPress: function(val, e, field, options) {
                field.mask(SPMaskBehavior.apply({}, arguments), options);
                }
            };

            $('#phone').mask(SPMaskBehavior, spOptions);
            $('#whatsapp').mask(SPMaskBehavior, spOptions);

            // FIM --  Configurações Mask

            // Consultar e pegar nome do Tutor
            $('#client_name').keyup(function(){
                var datatype = $(this).attr('data-type');
                var q = $(this).val();
                
                if (q.length < 1) {
                    $('.searchresults_client').hide();
                    $('input[name=id_client]').val('');
                    $('input[name=email]').val('');
                    $('input[name=phone]').val('');
                    $('input[name=whatsapp]').val('');
                    $('input[name=id_patient]').val('');
                    $('#patient_name').val('');
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
                                html += '<div class="si"><a href="javascript:;" onclick="selectClient(this)" data-id="'+json[i].id+'" data-email="'+json[i].email+'" data-phone="'+json[i].phone+'" data-whatsapp="'+json[i].whatsapp+'"">'+json[i].name+'</a></div>';
                            }

                            $('.searchresults_client').html(html);
                            $('.searchresults_client').show();
                        }
                    });

                }

            });

            $('#patient_name').keyup(function(){
            var q = $(this).val();
            var idclient = $('input[name=id_client]').val();
            
            if (q.length <= 0) {
                $('.searchresults_patient').hide();
                $('input[name=id_patient]').val('');
            }

            if (q.length > 0) {

                $.ajax({
                    url:"{{ route('search_patient') }}",
                    type:"get",
                    data: {name:q,idclient:idclient},
                    dataType:"json",
                    befoneSend:function() {},
                    success:function(json) {
                        if( $('.searchresults_patient').length == 0 ) {
                            $('#patient_name').after('<div class="searchresults_patient"></div>');
                        }
                        var res_width = $('#patient_name').css('width');
                        $('.searchresults_patient').css('width', res_width);

                        var html = '';

                        for(var i in json) {
                            html += '<div class="si"><a href="javascript:;" onclick="selectPatient(this)" data-id="'+json[i].id+'">'+json[i].name+'</a></div>';
                        }

                        $('.searchresults_patient').html(html);
                        $('.searchresults_patient').show();
                    }
                });

            }

        });
            
        });
    </script>

@stop
