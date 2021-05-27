@extends('adminlte::page')

@section('title', 'Agenda')

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
            <h1>Agenda</h1>
        </div>
        <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
                <li class="breadcrumb-item"><a href="{{asset('/home')}}">Home</a></li>
                <li class="breadcrumb-item active">Agenda</li>
            </ol>
        </div>
    </div>
</div>
</section>

{{-- PAGE CONTENT --}}

<div class="row">
    <div class="col-12">
      <div class="card card-primary card-outline">


        <div class="card-header">
          <div class="row">
            <div class="col-sm">
              <a href="{{ route('patient.index') }}" class="btn btn-info">Agendar Consulta</a>
            </div>
            <br> <br>
            <div class="col-sm">
              <div class="card-tools">
                <form method="get" id="form_consult">

                  <div class="justify-content-around">

                    <div class="row">

                      <div class="col-sm">
                        <div class="form-group p-2">
                          <label>Pesquisar por Período:</label>

                          <div id="reportrange" style="background: #fff; cursor: pointer; padding: 5px 10px; border: 1px solid #ccc; width: 100%">
                              <i class="fa fa-calendar"></i>&nbsp;
                              <span></span> <i class="fa fa-caret-down"></i>
                              
                          </div>

                          <input type="hidden" name="ini_date" value="{{$ini_date ?? ''}}">
                          <input type="hidden" name="fin_date" value="{{$fin_date ?? ''}}">
                          
                        </div>
                      </div>
                    </div>
                  </div>
                </form>
              </div>
            </div>
          </div>
        </div>
        <!-- /.card-header -->

        <div class="card-body table-responsive p-0" style="height: 300px;">
          <table class="table table-head-fixed">
            <thead>
              <tr>
                <th>Nome do Paciente</th>
                <th>Data - Hora</th>
                <th colspan="3" style="text-align:center;">Ações</th>
              </tr>
            </thead>
            <tbody id="tbody">
              @foreach ($consults as $item)
              <tr>
                  <td>{{$item->patient_name}}</td>
                  <td>{{date('d/m/Y - H:i', strtotime($item->data_consulta))}}</td>
                  <td style="text-align:center;">
                    <a title="Visualizar" href=" {{ route('agenda.show', [ 'agenda' => $item->id ]) }} " class="btn btn-sm bg-info" target="_blank"><i class='far fa-eye' style="font-size: 16px;"></i></a>
                  </td>
                  <td style="text-align:center;">
                      <a title="Realizar Consulta" href=" {{ route('agenda.edit', [ 'agenda' => $item->id ]) }} " class="btn btn-sm btn-success"><i class='fas fa-stethoscope' style="font-size: 16px;"></i></a>
                  </td>
                  <td style="text-align:center;">
                      <form title="Excluir" action=" {{ route('agenda.destroy', [ 'agenda' => $item->id ]) }} " method="POST" onsubmit="return confirm('Confirma a exclusão do registro?')">
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
  <div class="paginate_link">
    {{ $consults->links() }}
  </div>

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
  <link rel="stylesheet" type="text/css" href="https://cdn.jsdelivr.net/npm/daterangepicker/daterangepicker.css" />
@stop

@section('js')

    <script type="text/javascript" src="https://cdn.jsdelivr.net/jquery/latest/jquery.min.js"></script>
    <script type="text/javascript" src="https://cdn.jsdelivr.net/momentjs/latest/moment.min.js"></script>
    <script type="text/javascript" src="https://cdn.jsdelivr.net/npm/daterangepicker/daterangepicker.min.js"></script>

    <script>

      $(function () {

        var data = new Date($('input[name="ini_date"]').val());
        var ini_date = data.toISOString().substr(0, 10).split('-').reverse().join('/');

        var data = new Date($('input[name="fin_date"]').val());
        var fin_date = data.toISOString().substr(0, 10).split('-').reverse().join('/');
        
        $('#reportrange span').html(ini_date + ' - ' + fin_date);

        $('#reportrange').on('apply.daterangepicker', function(ev, picker) {
          var start = picker.startDate.format('YYYY-MM-DD');
          var end = picker.endDate.format('YYYY-MM-DD');
          $('input[name="ini_date"]').val(start);
          $('input[name="fin_date"]').val(end);
          $('#form_consult').submit();
        });
        
        $('#reportrange').daterangepicker({
            startDate: $('input[name="ini_date"]').val(),
            endDate: $('input[name="fin_date"]').val(),
            ranges: {
              'Hoje': [moment(), moment()],
              'Ontem': [moment().subtract(1, 'days'), moment().subtract(1, 'days')],
              'Últimos 7 Dias': [moment().subtract(6, 'days'), moment()],
              'Últimos 30 Dias': [moment().subtract(29, 'days'), moment()],
              'Este Mês': [moment().startOf('month'), moment().endOf('month')],
              'Último Mês': [moment().subtract(1, 'month').startOf('month'), moment().subtract(1, 'month').endOf('month')]
            },
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

      })
    </script>

@stop
