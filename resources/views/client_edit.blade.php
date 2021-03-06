@extends('adminlte::page')

@section('title', 'Clientes')

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
            <h1>Editar Cliente</h1>
        </div>
        <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
                <li class="breadcrumb-item"><a href="{{asset('/client')}}">Clientes</a></li>
                <li class="breadcrumb-item active">Editar Cliente</li>
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
                <div class="card card-primary card-outline">

                    <div class="card-body">
                        <div class="tab-content">

                            <div class="tab-pane active" id="settings">
                                <form class="form-horizontal" method="POST" action="{{ route( 'client.update', [ 'client' => $client['id'] ] ) }}">
                                    @csrf
                                    @method('PUT')

                                    <div class="form-group row">
                                        <label for="inputName" class="col-sm-2 col-form-label">Nome</label>
                                        <div class="col-sm-10">
                                            <input type="text" class="form-control @error('name') is-invalid @enderror" id="inputName" placeholder="Nome" name="name" value="{{$client['name']}}">
                                        </div>
                                    </div>

                                    <div class="form-group row">
                                        <label for="inputEmail" class="col-sm-2 col-form-label">E-mail</label>
                                        <div class="col-sm-10">
                                            <input type="email" class="form-control @error('email') is-invalid @enderror" id="inputEmail" placeholder="E-mail" name="email" value="{{$client['email']}}">
                                        </div>
                                    </div>

                                    <div class="form-group row">
                                        <label for="inputphone" class="col-sm-2 col-form-label"></label>
                                        <div class="custom-control custom-checkbox col-sm-10">
                                            <input class="custom-control-input" type="checkbox" 
                                            @if($client['newsletter_agree'] == 1) checked @endif
                                            id="customCheckbox" value="1"  name="newsletter_agree">
                                            <label for="customCheckbox" class="custom-control-label">Aceita receber e-mails e Whatsapps de promo????es e novidades</label>
                                        </div>
                                  </div>

                                  <div class="form-group row">
                                      <label for="inputphone" class="col-sm-2 col-form-label">Telefone</label>
                                      <div class="col-sm-10">
                                          <input type="phone" class="form-control phone @error('phone') is-invalid @enderror" id="inputphone" placeholder="Telefone" name="phone" value="{{$client['phone']}}">
                                      </div>
                                  </div>

                                  <div class="form-group row">
                                      <label for="inputwhatsapp" class="col-sm-2 col-form-label">Whatsapp</label>
                                      <div class="col-sm-10">
                                          <input type="phone" class="form-control phone @error('whatsapp') is-invalid @enderror" id="inputwhatsapp" placeholder="Whatsapp" name="whatsapp" value="{{$client['whatsapp']}}">
                                      </div>
                                  </div>

                                  <div class="form-group row">
                                      <label for="inputdate_birth" class="col-sm-2 col-form-label">Data de Nascimento</label>
                                      <div class="col-sm-10">
                                          <input type="date" class="form-control @error('date_birth') is-invalid @enderror" id="inputdate_birth" placeholder="Data de Nascimento" name="date_birth" value="{{$client['date_birth']}}">
                                      </div>
                                  </div>

                                  <div class="form-group row">
                                      <label for="inputcpf" class="col-sm-2 col-form-label">C.P.F.</label>
                                      <div class="col-sm-10">
                                          <input type="text" class="form-control cpf @error('cpf') is-invalid @enderror" id="inputcpf" placeholder="C.P.F." name="cpf" value="{{$client['cpf']}}">
                                      </div>
                                  </div>

                                  <div class="form-group row">
                                      <label for="inputrg" class="col-sm-2 col-form-label">Identidade / ??rg??o Emissor - UF</label>
                                      <div class="col-sm-10">
                                          <input type="text" class="form-control @error('rg') is-invalid @enderror" id="inputrg" placeholder="Identidade / ??rg??o Emissor - UF" name="rg" value="{{$client['rg']}}">
                                      </div>
                                  </div>

                                  <div class="form-group row">
                                      <label for="inputcep" class="col-sm-2 col-form-label">CEP</label>
                                      <div class="col-sm-10">
                                          <input type="text" class="form-control cep @error('cep') is-invalid @enderror" id="inputcep" placeholder="CEP" name="cep" value="{{$client['cep']}}">
                                      </div>
                                  </div>

                                  <div class="form-group row">
                                      <label for="inputfull_address" class="col-sm-2 col-form-label">Endere??o Completo</label>
                                      <div class="col-sm-10">
                                          <textarea type="text" class="form-control @error('full_address') is-invalid @enderror" id="inputfull_address" placeholder="Endere??o Completo" name="full_address">{{$client['full_address']}}</textarea>
                                      </div>
                                  </div>

                                  <div class="form-group row">
                                      <label for="inputobs" class="col-sm-2 col-form-label">Observa????es</label>
                                      <div class="col-sm-10">
                                          <textarea type="text" class="form-control @error('obs') is-invalid @enderror" id="inputobs" placeholder="Observa????es" name="obs">{{$client['obs']}}</textarea>
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
        <strong>Copyright ?? 2014-2020 <a href="https://adminlte.io">AdminLTE.io</a>.</strong> All rights reserved.
        | Powered & system developed by <strong>Copyright ?? 2020-{{date('Y')}} <a href="https://mundo.vet.br">MundoVet</a>.</strong> All rights reserved.
    </footer>
@endsection

@section('js')
<script src="{{asset('/assets/js/jquery.mask.min.js')}}"></script>
<script src="{{asset('/assets/js/script.js')}}"></script>
@stop
