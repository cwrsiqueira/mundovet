@extends('adminlte::page')

@section('title', 'Home')

@section('content')


  @if ($last_login != date('Y-m-d') || empty($company['pay_date']))
      <!-- The Modal -->
      <div class="modal fade" id="modal-benvindo">
        <div class="modal-dialog modal-lg modal-dialog-centered">
          <div class="modal-content">

            @include('layouts.planos')

          </div>
        </div>
      </div>
      
  @endif

  <div class="container-fluid">

    <div class="row">
      <div class="col-md-3 col-sm-6 col-12">
        <div class="info-box">
          <span class="info-box-icon bg-info"><i class="fas fa-fw fa-users"></i></span>

          <div class="info-box-content">
            <span class="info-box-text">Clientes</span>
            <span class="info-box-number">{{$qt_clients}}</span>
          </div>
          <!-- /.info-box-content -->
        </div>
        <!-- /.info-box -->
      </div>
      <!-- /.col -->
      <div class="col-md-3 col-sm-6 col-12">
        <div class="info-box">
          <span class="info-box-icon bg-success"><i class="fas fa-fw fa-heart"></i></span>

          <div class="info-box-content">
            <span class="info-box-text">Pacientes</span>
            <span class="info-box-number">{{$qt_patients}}</span>
          </div>
          <!-- /.info-box-content -->
        </div>
        <!-- /.info-box -->
      </div>
      <!-- /.col -->
      <div class="col-md-3 col-sm-6 col-12">
        <div class="info-box">
          <span class="info-box-icon bg-warning"><i class="far fa-calendar-check"></i></span>

          <div class="info-box-content">
            <span class="info-box-text">Consultas Agendas</span>
            <span class="info-box-number">{{$qt_consultas}}</span>
          </div>
          <!-- /.info-box-content -->
        </div>
        <!-- /.info-box -->
      </div>
      <!-- /.col -->
      <div class="col-md-3 col-sm-6 col-12">
        <div class="info-box">
          <span class="info-box-icon bg-danger"><i class="fas fa-fw fa-heartbeat"></i></span>

          <div class="info-box-content">
            <span class="info-box-text">Retornos Agendados</span>
            <span class="info-box-number">{{$qt_retornos}}</span>
          </div>
          <!-- /.info-box-content -->
        </div>
        <!-- /.info-box -->
      </div>
      <!-- /.col -->
    </div>

    <div class="row">

      <div class="container-fluid">

        <div class="card">
          <div class="card-header">
            <h3 class="card-title">Próximas consultas e retornos Agendados</h3>

            <div class="card-tools">
              <ul class="pagination pagination-sm float-right">
                {{ $agendamentos->links() }}
              </ul>
            </div>
          </div>
          <!-- /.card-header -->
          <div class="card-body p-0">
            <table class="table">
              <thead>
                <tr>
                  <th style="width: 10px">#</th>
                  <th>Cliente</th>
                  <th>Paciente</th>
                  <th>Data/Hora</th>
                  <th class="col-motivo">Motivo</th>
                </tr>
              </thead>
              <tbody>
                @foreach ($agendamentos as $item)
                  <tr>
                    <td>{{$item['id']}}</td>
                    <td>{{$item['client']['name']}}</td>
                    <th>{{$item['patient']['name']}}</th>
                    <th>{{date('d/m/Y - H:i', strtotime($item['data_consulta']))}}</th>
                    <th class="col-motivo">{{$item['motivo']}}</th>
                  </tr>
                @endforeach
              </tbody>
            </table>
          </div>
          <!-- /.card-body -->
        </div>

      </div>

    </div>

  </div>

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
    <script>
      $("#modal-danger").modal();
      $("#modal-benvindo").modal();
    </script>
@endsection

@section('css')
    <style>
      tr {
          text-align: center;
      }
      .input-group a,
      input {
          font-size: 10px;
          text-align: center;
          font-weight: 400;
      }
      #dia_atual {
          background-color: #EEE;
          color: #343a40;
          font-weight: 600;
      }
      .col-motivo {
        max-width: 50ch;
        min-width:50ch;
        overflow: hidden;
        text-overflow: ellipsis;
        white-space: nowrap;
      }
      .box-plans,
      .plans {
        border-radius: 5px;
        text-align: center;
      }
    
    @media (max-width:768px) {
      .col-motivo {
        display: none;
      }
    }
    
    </style>
@endsection