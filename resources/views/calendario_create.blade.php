@extends('adminlte::page')

@section('title', 'Adicionar Horários')

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
            <h1>Definir Horários</h1>
        </div>
        <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
                <li class="breadcrumb-item"><a href="{{asset('/company')}}">Perfil da Empresa</a></li>
                <li class="breadcrumb-item active">Definir Horários</li>
            </ol>
        </div>
    </div>
</div>
</section>

{{-- PAGE CONTENT --}}

<form class="form-horizontal form-agenda" method="POST" action="{{ route( 'calendario.store' ) }}">
    @csrf

    <div class="card card-primary card-outline">
        <div class="card-header">
            Horário de Atendimento
        </div>
        <div class="card-body">
            
                <table class="table table-responsive">
                    <thead>
                        <tr>
                            <th>Dia</th>
                            <th colspan="2">Horário de Atendimento</th>
                            <th colspan="2">Horário de Intervalo</th>
                        </tr>
                    </thead>
                    <tbody>
                        @if(empty($op_h[0]))
                        <tr>
                            <td>Domingo:</td>
                            <td><input class="ini_atend time" name="sun_ini_atend" type="text"></td>
                            <td><input class="fin_atend time" name="sun_fin_atend" type="text"></td>
                            <td><input class="ini_interv time" name="sun_ini_interv" type="text"></td>
                            <td><input class="fin_interv time" name="sun_fin_interv" type="text"></td>
                        </tr>
                        <tr>
                            <td>Segunda:</td>
                            <td><input class="ini_atend time" name="mon_ini_atend" value="08:00" type="text"></td>
                            <td><input class="fin_atend time" name="mon_fin_atend" value="18:00" type="text"></td>
                            <td><input class="ini_interv time"name="mon_ini_interv" value="12:00" type="text"></td>
                            <td><input class="fin_interv time" name="mon_fin_interv" value="14:00" type="text"></td>
                        </tr>
                        <tr>
                            <td>Terça:</td>
                            <td><input class="ini_atend time" name="tue_ini_atend" value="08:00" type="text"></td>
                            <td><input class="fin_atend time" name="tue_fin_atend" value="18:00" type="text"></td>
                            <td><input class="ini_interv time"name="tue_ini_interv" value="12:00" type="text"></td>
                            <td><input class="fin_interv time" name="tue_fin_interv" value="14:00" type="text"></td>
                        </tr>
                        <tr>
                            <td>Quarta:</td>
                            <td><input class="ini_atend time" name="wed_ini_atend" value="08:00" type="text"></td>
                            <td><input class="fin_atend time" name="wed_fin_atend" value="18:00" type="text"></td>
                            <td><input class="ini_interv time"name="wed_ini_interv" value="12:00" type="text"></td>
                            <td><input class="fin_interv time" name="wed_fin_interv" value="14:00" type="text"></td>
                        </tr>
                        <tr>
                            <td>Quinta:</td>
                            <td><input class="ini_atend time" name="thu_ini_atend" value="08:00" type="text"></td>
                            <td><input class="fin_atend time" name="thu_fin_atend" value="18:00" type="text"></td>
                            <td><input class="ini_interv time"name="thu_ini_interv" value="12:00" type="text"></td>
                            <td><input class="fin_interv time" name="thu_fin_interv" value="14:00" type="text"></td>
                        </tr>
                        <tr>
                            <td>Sexta:</td>
                            <td><input class="ini_atend time" name="fri_ini_atend" value="08:00" type="text"></td>
                            <td><input class="fin_atend time" name="fri_fin_atend" value="18:00" type="text"></td>
                            <td><input class="ini_interv time"name="fri_ini_interv" value="12:00" type="text"></td>
                            <td><input class="fin_interv time" name="fri_fin_interv" value="14:00" type="text"></td>
                        </tr>
                        <tr>
                            <td>Sábado:</td>
                            <td><input class="ini_atend time" name="sat_ini_atend" value="08:00" type="text"></td>
                            <td><input class="fin_atend time" name="sat_fin_atend" value="12:00" type="text"></td>
                            <td><input class="ini_interv time"name="sat_ini_interv" type="text"></td>
                            <td><input class="fin_interv time" name="sat_fin_interv" type="text"></td>
                        </tr>
                        @else
                            @foreach($op_h as $item)
                            <tr>
                                <div style="display: none;">
                                    @switch($item['day'])
                                    @case('sun')
                                        {{$week_day = 'Domingo'}}
                                        @break
                                    @case('mon')
                                        {{$week_day = 'Segunda'}}
                                        @break
                                    @case('tue')
                                        {{$week_day = 'Terça'}}
                                        @break
                                    @case('wed')
                                        {{$week_day = 'Quarta'}}
                                        @break
                                    @case('thu')
                                        {{$week_day = 'Quinta'}}
                                        @break
                                    @case('fri')
                                        {{$week_day = 'Sexta'}}
                                        @break
                                    @case('sat')
                                        {{$week_day = 'Sábado'}}
                                        @break
                                    @default
                                @endswitch
                                </div>
                                <td>{{$week_day}}:</td>
                                <td><input class="ini_atend time" name="{{$item['day']}}_ini_atend" value="{{$item['ini_atend']}}" type="text"></td>
                                <td><input class="fin_atend time" name="{{$item['day']}}_fin_atend" value="{{$item['fin_atend']}}" type="text"></td>
                                <td><input class="ini_interv time"name="{{$item['day']}}_ini_interv" value="{{$item['ini_interv']}}" type="text"></td>
                                <td><input class="fin_interv time" name="{{$item['day']}}_fin_interv" value="{{$item['fin_interv']}}" type="text"></td>
                            </tr>
                            @endforeach
                        @endif
                    </tbody>
                </table>

                <hr>

                <div class="card card-info card-outline">
                    <div class="card-header">
                        Definir períodos de recesso, férias etc.
                    </div>
                    <div class="card-body">
                        <div class="col-sm">
                            <div class="form-group p-2">
                              <label>Selecionar Período:</label>
    
                              <div id="reportrange" style="background: #fff; cursor: pointer; padding: 5px 10px; border: 1px solid #ccc; width: 100%">
                                  <i class="fa fa-calendar"></i>&nbsp;
                                  <span></span> <i class="fa fa-caret-down"></i>
                                  
                              </div>
    
                              <input type="hidden" name="ini_date">
                              <input type="hidden" name="fin_date">
                              
                            </div>
                        </div>
                        <table class="table table-responsive">
                            <thead>
                                <tr>
                                    <th>Dia Início</th>
                                    <th>Dia Fim</th>
                                    <th>Excluir</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($except as $item)
                                    <tr>
                                        <td>{{date('d/m/Y', strtotime($item->ini_date))}}</td>
                                        <td>{{date('d/m/Y', strtotime($item->fin_date))}}</td>
                                        <td><a class="btn btn-danger btn-sm" href="{{route('del_exception', ['exception' => $item->id])}}">Excluir</a></td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            
        </div>
        <div class="card-footer">
            <input class="btn btn-info" type="submit" value="Salvar">
        </div>
    </div>

</form>

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
    <link rel="stylesheet" type="text/css" href="https://cdn.jsdelivr.net/npm/daterangepicker/daterangepicker.css" />
    <style>
        input {
            border-radius: 5px;
            border: 1px solid #CCC;
            padding: 5px;
        }
        tr {
            text-align: center;
        }
    </style>
@stop

@section('js')
    <script type="text/javascript" src="https://cdn.jsdelivr.net/jquery/latest/jquery.min.js"></script>
    <script type="text/javascript" src="https://cdn.jsdelivr.net/momentjs/latest/moment.min.js"></script>
    <script type="text/javascript" src="https://cdn.jsdelivr.net/npm/daterangepicker/daterangepicker.min.js"></script>
    <script src="{{asset('/assets/js/jquery.mask.min.js')}}"></script>

    <script>
        $(function(){
            $('input[type=text]').mask('00:00');
            $('.time').attr('placeholder', '00:00');

            $('#reportrange').on('apply.daterangepicker', function(ev, picker) {
            var start = picker.startDate.format('YYYY-MM-DD');
            var end = picker.endDate.format('YYYY-MM-DD');
            $('input[name="ini_date"]').val(start);
            $('input[name="fin_date"]').val(end);

            var data = new Date($('input[name="ini_date"]').val());
            var ini_date = data.toISOString().substr(0, 10).split('-').reverse().join('/');

            var data = new Date($('input[name="fin_date"]').val());
            var fin_date = data.toISOString().substr(0, 10).split('-').reverse().join('/');

            $('#reportrange span').html(ini_date + ' - ' + fin_date);
            $('.form-agenda').submit();
            });
            
            $('#reportrange').daterangepicker({
                "locale": {
                "applyLabel": "Confirma",
                "cancelLabel": "Cancela",
                "customRangeLabel": "Período",
                "format": "YYYY-MM-DD",
                "daysOfWeek": [
                    "Dom",
                    "Seg",
                    "Ter",
                    "Qua",
                    "Qui",
                    "Sex",
                    "Sáb"
                ],
                "monthNames": [
                    "Janeiro",
                    "Fevereiro",
                    "Março",
                    "Abril",
                    "Maio",
                    "Junho",
                    "Julho",
                    "Agosto",
                    "Setembro",
                    "Outubro",
                    "Novembro",
                    "Dezembro"
                ],
                }
            });
            
        });
    </script>
@stop
