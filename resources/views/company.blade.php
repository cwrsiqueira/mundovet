@extends('adminlte::page')

@section('title', 'Empresa')

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
                    <h1>Empresa</h1>
                </div>
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="{{asset('/home')}}">Home</a></li>
                        <li class="breadcrumb-item active">Empresa</li>
                    </ol>
                </div>
            </div>
        </div>
    </section>

    <section class="content">
        <div class="container-fluid">
            <div class="row">
                <div class="col-md-3">

                    <!-- Profile Image -->
                    <div class="card card-primary card-outline">
                        <div class="card-body box-profile">
                            <div class="text-center edit_logo">
                                <div class="over-logo">
                                    <h3>Inserir/Alterar Logo</h3>
                                </div>
        
                                <div class="area_logo">
        
                                    <div class="logo_preview"></div>
                                    @if (!empty($company['url_logo']))
                                        <img class="img-fluid content_logo" src="{{asset('/assets/img/'.$company['url_logo'])}}">
                                    @else
                                        <img class="img-fluid content_logo" src="{{asset('/assets/media/default.jpg')}}">
                                    @endif
                                    
        
                                </div>
                            </div>

                            <h3 class="profile-username text-center">
                                @if (!empty($company['trade_name']))
                                    {{$company['trade_name']}}
                                @elseif (!empty($company['name'])) 
                                    {{$company['name']}}
                                @else 
                                    Nome da Empresa
                                @endif
                            </h3>

                            <p class="text-muted text-center">{{ (!empty($company['slogan'])) ? $company['slogan'] : 'Slogan' }}</p>

                        </div>
                        <!-- /.card-body -->
                    </div>
                    <!-- /.card -->

                    <div class="card">
                        <div class="card-body">
                            <div class="col-sm">
                                <a  href="{{route('calendario.create')}}"><button class="btn btn-info">Definir Horários de Atendimento</button></a>
                            </div>
                        </div>
                    </div>

                    <div class="card">
                        <div class="card-header">
                            <h4 class="card-title">Renovação do Sistema</h4>
                        </div>
                        <div class="card-body">
                            <div class="col-sm">
                                <div class="vencimento-area">
                                    @if ($dados_vencimento['venc'] < $dados_vencimento['hoje'])
                                      {{date('d/m/Y', strtotime($dados_vencimento['venc']))}} - <small>Vencido a {{$dados_vencimento['dias']}} dia{{(($dados_vencimento['dias']>1)) ? 's' : ''}}!</small> 
                                    @elseif($dados_vencimento['venc'] == $dados_vencimento['hoje'])
                                      {{date('d/m/Y', strtotime($dados_vencimento['venc']))}} - <small>Vence hoje!</small> 
                                    @else
                                      {{date('d/m/Y', strtotime($dados_vencimento['venc']))}} - <small>Faltam {{$dados_vencimento['dias']}} dia{{(($dados_vencimento['dias']>1)) ? 's' : ''}}!</small> 
                                      <div class="progress progress-xs">
                                        <div class="progress-bar" style="background-color:#B40404;width: {{$dados_vencimento['percent']}}%"></div>
                                      </div>
                                    @endif
                                  </div>
                            </div>
                        </div>
                        <div class="card-footer">
                            <button class="btn btn-success" data-toggle="modal" data-target="#modal-renovar">Renovar Agora</button>
                        </div>

                        <!-- The Modal -->
                        <div class="modal fade" id="modal-renovar">
                            <div class="modal-dialog modal-lg modal-dialog-centered">
                            <div class="modal-content">

                                @include('layouts.planos')

                            </div>
                            </div>
                        </div>
                    </div>
                    
                </div>
            <!-- /.col -->
                <div class="col-md-9">
                    <div class="card card-primary card-outline">

                        <div class="card-body">
                            <div class="tab-content">

                                <div class="tab-pane active" id="settings">
                                    <form class="form-horizontal" enctype="multipart/form-data" method="POST" 
                                    action="
                                        @if(empty($company['id']))
                                            {{ route('company.store')}}
                                        @else
                                            {{ route( 'company.update', [ 'company' => $company['id'] ] ) }}
                                        @endif
                                    ">
                                        @csrf
                                        @if(!empty($company['id']))
                                            @method('PUT')
                                        @endif
                                        
                                        <div class="logo_area hidden"></div>

                                        <div class="form-group row">
                                            <label for="inputName" class="col-sm-2 col-form-label">Nome</label>
                                            <div class="col-sm-10">
                                                <input type="text" class="form-control @error('name') is-invalid @enderror" id="inputName" placeholder="Nome" name="name" value="{{ (!empty($company['name'])) ? $company['name'] : old('name') }}">
                                            </div>
                                        </div>
                                        
                                        <div class="form-group row">
                                            <label for="inputCompanyName" class="col-sm-2 col-form-label">Nome de Fantasia</label>
                                            <div class="col-sm-10">
                                                <input type="text" class="form-control @error('trade_name') is-invalid @enderror" id="inputCompanyName" placeholder="Nome de Fantasia" name="trade_name" value="{{ (!empty($company['trade_name'])) ? $company['trade_name'] : '' }}">
                                            </div>
                                        </div>
                                        
                                        <div class="form-group row">
                                            <label for="inputCNPJ" class="col-sm-2 col-form-label">C.N.P.J.</label>
                                            <div class="col-sm-10">
                                                <input type="text" class="form-control cnpj @error('cnpj') is-invalid @enderror" id="inputCNPJ" placeholder="C.N.P.J." name="cnpj" value="{{ (!empty($company['cnpj'])) ? $company['cnpj'] : '' }}">
                                            </div>
                                        </div>

                                        <div class="form-group row">
                                            <label for="inputSlogan" class="col-sm-2 col-form-label">Slogan</label>
                                            <div class="col-sm-10">
                                                <input type="text" class="form-control @error('slogan') is-invalid @enderror" id="inputSlogan" placeholder="Slogan" name="slogan" value="{{ (!empty($company['slogan'])) ? $company['slogan'] : '' }}">
                                            </div>
                                        </div>

                                        <div class="form-group row">
                                            <label for="inputAddress" class="col-sm-2 col-form-label">Endereço Completo</label>
                                            <div class="col-sm-10">
                                                <textarea class="form-control @error('address') is-invalid @enderror" id="inputAddress" placeholder="Endereço Completo" name="address">{{ (!empty($company['address'])) ? $company['address'] : '' }}</textarea>
                                            </div>
                                        </div>

                                        <div class="form-group row">
                                            <label for="inputEmail" class="col-sm-2 col-form-label">E-mail</label>
                                            <div class="col-sm-10">
                                                <input type="email" class="form-control @error('email') is-invalid @enderror" id="inputEmail" placeholder="E-mail" name="email" value="{{ (!empty($company['email'])) ? $company['email'] : '' }}">
                                            </div>
                                        </div>

                                        <div class="form-group row">
                                            <label for="phone" class="col-sm-2 col-form-label">Telefone</label>
                                            <div class="col-sm-10">
                                                <input type="text" class="form-control phone @error('phone') is-invalid @enderror" id="phone" placeholder="(__)____-____" name="phone" value="{{ (!empty($company['phone'])) ? $company['phone'] : '' }}">
                                            </div>
                                        </div>

                                        <div class="form-group row">
                                            <label for="inputWhatsapp" class="col-sm-2 col-form-label">Whatsapp</label>
                                            <div class="col-sm-10">
                                                <input type="text" class="form-control phone @error('whatsapp') is-invalid @enderror" id="inputWhatsapp" placeholder="(__)____-____" name="whatsapp" value="{{ (!empty($company['whatsapp'])) ? $company['whatsapp'] : '' }}">
                                            </div>
                                        </div>

                                        <div class="form-group row">
                                            <label for="inputWebsite" class="col-sm-2 col-form-label">Website</label>
                                            <div class="col-sm-10">
                                                <input type="text" class="form-control @error('website') is-invalid @enderror" id="inputWebsite" placeholder="Website" name="website" value="{{ (!empty($company['website'])) ? $company['website'] : '' }}">
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
    <script src="{{asset('/assets/js/jquery.mask.min.js')}}"></script>
    <script src="{{asset('/assets/js/script.js')}}"></script>
@stop