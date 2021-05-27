@extends('adminlte::page')

@section('title', 'Exames')

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
            <h1>Exames</h1>
        </div>
        <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
              <li class="breadcrumb-item"><a href="{{asset('/home')}}">Home</a></li>
                <li class="breadcrumb-item active">Exames</li>
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
              <a href="{{ route('exam.create') }}" class="btn btn-info">Cadastrar Exame</a>
            </div>
            <br> <br>
            <div class="col-sm">
              <div class="card-tools">

                <form method="get">
                  <div class="input-group input-group-sm float-right" style="width: 150px;">
                    <input type="search" name="exam" class="form-control float-right" placeholder="Pesquisar">
      
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
                <th>Exame</th>
                <th colspan="2" style="text-align:center;">Ações</th>
              </tr>
            </thead>
            <tbody>
              @foreach ($exams as $item)
              <tr>
                  <td>{{$item->name}}</td>
                  <td style="text-align:center;">
                      <a title="Editar" href=" {{ route('exam.edit', [ 'exam' => $item->id ]) }} " class="btn btn-sm btn-success"><i class='far fa-edit' style="font-size: 16px;"></i></a>
                  </td>
                  <td style="text-align:center;">
                      <form title="Excluir" action=" {{ route('exam.destroy', [ 'exam' => $item->id ]) }} " method="POST" onsubmit="return confirm('Confirma a exclusão do usuário?')">
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

  {{ $exams->links() }}

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
