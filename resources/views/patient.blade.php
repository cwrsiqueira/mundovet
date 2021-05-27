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
            <h1>Pacientes</h1>
        </div>
        <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
              <li class="breadcrumb-item"><a href="{{asset('/home')}}">Home</a></li>
                <li class="breadcrumb-item active">Pacientes</li>
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
              <a href="{{ route('client.index') }}" class="btn btn-info">Cadastrar Paciente</a>
            </div>
            <br> <br>
            <div class="col-sm">
              <a href="{{ route('patient_list') }}" target="_blank" class="btn bg-olive">Listar Pacientes</a>
            </div>
            <br> <br>
            <div class="col-sm">
              <div class="card-tools">

                <form method="get">
                  <div class="input-group input-group-sm float-right" style="width: 150px;">
                    <label>Pesquisar por Nome:</label>
                    <input type="search" name="patient" class="form-control float-right" placeholder="Pesquisar">
      
                    <div class="input-group-append">
                      <button type="submit" class="btn btn-default"><i class="fas fa-search"></i></button>
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
                <th># Chip</th>
                <th>Nome do Paciente</th>
                <th>Tutor</th>
                <th colspan="4" style="text-align:center;">Ações</th>
              </tr>
            </thead>
            <tbody>
              @foreach ($patients as $item)
              <tr>
                  <td>{{$item->chip_number}}</td>
                  <td>{{$item->name}}</td>
                  <td>{{$item->tutor}}</td>
                  <td style="text-align:center;">
                    <a title="Agendar Consulta" href=" {{ route('agenda.create', [ 'patient' => $item->id ]) }} " class="btn btn-sm btn-success"><i class='fas fa-stethoscope' style="font-size: 16px;"></i></a>
                </td>
                  <td style="text-align:center;">
                    <a title="Visualizar" href=" {{ route('patient.show', [ 'patient' => $item->id ]) }} " class="btn btn-sm bg-info" target="_blank"><i class='far fa-eye' style="font-size: 16px;"></i></a>
                  </td>
                  <td style="text-align:center;">
                      <a title="Editar" href=" {{ route('patient.edit', [ 'patient' => $item->id ]) }} " class="btn btn-sm btn-success"><i class='far fa-edit' style="font-size: 16px;"></i></a>
                  </td>
                  <td style="text-align:center;">
                      <form title="Excluir" action=" {{ route('patient.destroy', [ 'patient' => $item->id ]) }} " method="POST" onsubmit="return confirm('Confirma a exclusão do usuário?')" >
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
  {{ $patients->links() }}

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
