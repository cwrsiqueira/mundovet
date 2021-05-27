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
            <h3>Consulta</h3>
        </div>
        <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
                <li class="breadcrumb-item" id="local_home"><a href="{{asset('/consult')}}">Consultas</a></li>
                <li class="breadcrumb-item active">Consulta</li>
            </ol>
        </div>
    </div>
</div>
</section>

{{-- PAGE CONTENT --}}

<!-- The Modal -->
<div class="modal fade" id="myModal">
    <div class="modal-dialog">
        <div class="modal-content">

        <!-- Modal body -->
        <div class="modal-body">
            <div class="row">
                <div class="col-sm">
                    Alterações do formulário salvas!!!
                </div>
                <div class="d-flex col-sm justify-content-end">
                    <button type="button" class="btn btn-success btn-sm" data-dismiss="modal">Fechar</button>
                </div>
            </div>
        </div>

        </div>
    </div>
</div>

<section class="content">
    <div class="container-fluid">
        <form class="form-horizontal" id="form_consult" method="POST" enctype="multipart/form-data" action="{{ route( 'consult.update', ['consult' => $consult['id']] ) }}">
        @csrf
        @method('PUT')

        <nav class="main-header navbar navbar-expand-sm navbar-light fixed-top" id="aux-bar">

            <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#collapsibleNavbar">
                <span class="navbar-toggler-icon"></span>
            </button>

            <!-- Links -->
            <div class="collapse navbar-collapse justify-content-end" id="collapsibleNavbar">
                
                    <div class="col-md-6">
                        <ul class="navbar-nav" data-widget="pushmenu">
                            <li class="nav-item p-2">
                                <a class="nav-link" href="#"><i class="fas fa-bars" style="color: #ffffff"></i></a>
                            </li>
                        </ul>
                    </div>
                    <div class="col-md-6">
                        <ul class="navbar-nav justify-content-end">
                            <li class="nav-item p-2">
                            <a class="btn btn-info btn-sm btn-aux-bar" class="nav-link" href="#local_home">Ínicio</a>
                            </li>
                            <li class="nav-item p-2">
                            <a class="btn btn-info btn-sm btn-aux-bar" class="nav-link" href="#local_end">Fim</a>
                            </li>
                            <li class="nav-item p-2">
                                <input class="btn btn-info btn-sm btn-aux-bar" type="submit" value="Salvar">
                            </li>
                            <li class="nav-item p-2">
                            <a class="btn btn-info btn-sm btn-aux-bar" class="nav-link" href="{{asset('/consult')}}">Sair</a>
                            </li>
                        </ul>
                    </div>
                
            </div>
        </nav>

        <div class="card card-primary card-outline">
            <div class="card-header">
                <h3 class="card-title">Informações Iniciais</h3>
            </div>
            <div class="card-body">
                {{-- Consulta / Retorno --}}
                <div class="form-check-inline">
                    <label class="form-check-label" for="consulta">
                        <input type="radio" class="form-check-input" id="consulta" name="consulta" value="consulta" {{ (($consult['consulta'] == 'consulta')) ? 'checked':'' ?: 'checked' }} > Consulta
                    </label>
                </div>

                <div class="form-check-inline">
                    <label class="form-check-label" for="radio2">
                        <input type="radio" class="form-check-input" id="radio2" name="consulta" value="retorno" {{ (($consult['consulta'] == 'retorno')) ? 'checked':'' }} > Retorno
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
                            <input type="date" 
                            @if (!empty($consult['data_consulta']))
                                value="{{date('Y-m-d', strtotime($consult['data_consulta']))}}"
                            @else
                                value="0000-00-00"
                            @endif
                            class="form-control" id="data" name="data_consulta" required>
                        </div>

                        <div class="form-group">
                            <label for="client_name">Cliente:</label>
                            <input type="hidden" name="id_client" id="id_client" value="{{$consult['id_this_client']}}" required>
                            <input type="text" class="form-control @error('warning') is-invalid @enderror" id="client_name" name="tutor" value="{{$consult['tutor']}}" required @if( $consult['tutor'] ) readonly @endif>
                        </div>

                        <div class="form-group">
                            <label for="patient_name">Paciente:</label>
                            <input type="hidden" name="id_patient" value="{{$consult['id_patient']}}" required>
                            <input type="text" class="form-control @error('warning') is-invalid @enderror" id="patient_name" name="name" value="{{$consult['name']}}" required @if( $consult['name'] ) readonly @endif>
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
                                <option value="mac" @if( $consult['sexo'] == 'mac' ) selected @endif>Macho</option>
                                <option value="fem" @if( $consult['sexo']  == 'fem' ) selected @endif>Fêmea</option>
                            </select>
                        </div>       

                        <div class="form-group">
                            <label for="peso">Peso: <small>(kilogramas)</small></label>
                            <input type="text" class="form-control" id="peso" name="peso" required value="{{number_format($consult['peso'], 3)}}">
                        </div>

                        <div class="form-group">
                            <label>Motivo da Consulta:</label>
                            <textarea class="form-control" rows="3" name="motivo" placeholder="Breve descrição do motivo... ">{{$consult['motivo']}}</textarea>
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
                        <input type="radio" class="form-check-input" id="tipo" name="tipo" value="simples" 
                        {{ ($consult['tipo'] == 'simples') ? 'checked':'' }} onclick="this.form.submit();">Consulta Simples
                        </label>
                    </div>

                    <div class="form-check-inline">
                        <label class="form-check-label" for="tipo2">
                        <input type="radio" class="form-check-input" id="tipo2" name="tipo" value="completa" 
                        {{ ($consult['tipo'] == 'completa') ? 'checked':'' }} onclick="this.form.submit();">Consulta Completa
                        </label>
                    </div>
                </div>
                <!--  -->
            </div>
        </div>

        <div class="consulta_simples {{ (($consult['tipo'] == 'simples')) ? 'show_aba':'hidden_aba' }}" id="consulta_simples">
            <div class="card-header">
                <h3>Ficha de Consulta Simples</h3>
            </div>
        </div>

        <div class="consulta_completa {{ (($consult['tipo'] == 'completa')) ? 'show_aba':'hidden_aba' }}" id="consulta_completa">
            <div class="card-header">
                <h3>Ficha de Consulta Completa</h3>
            </div>

            <div class="card card-primary card-outline">
                <div class="card-body">
                    <h4>Anamnese</h4>
                </div>
            </div>

            <div class="row">
                <div class="col-md-6">
                    <div class="card">
                        <div class="card-body le-2">

                            <div class="form-group">
                                <label for="diagnostico">Suspeita/Diagnóstico:</label>
                                <textarea class="form-control" rows="5" id="diagnostico" name="diagnostico">{{$consult['diagnostico']}}</textarea>
                            </div>
                            
                            <div class="form-group">
                                <label for="anamnese">Anamnese:</label>
                                <textarea class="form-control" rows="5" id="anamnese" name="anamnese">{{$consult['anamnese']}}</textarea>
                            </div>
                            
                            <div class="row">
                                <div class="col-md-6 p-2">
                                    <!-- Ambiente  -->
                                    <div class="form-group">
                                        <label for="ambiente">Ambiente:</label>
                                        <select class="form-control" id="ambiente" name="ambiente">
                                            <option value="">Selecionar...</option>
                                            <option @if($consult['ambiente'] == 'ambiente_apartamento') selected @endif  value="ambiente_apartamento">Apartamento</option>
                                            <option @if($consult['ambiente'] == 'ambiente_casaOutdoor') selected @endif   value="ambiente_casaOutdoor">Casa - Outdoor</option>
                                            <option @if($consult['ambiente'] == 'ambiente_casaIndoor') selected @endif   value="ambiente_casaIndoor">Casa - Indoor</option>
                                        </select>
                                    </div>
                                </div>
                                <div class="rol-md-6 p-2">
                                    <div class="form-group">
                                        <label for="acesso_rua">Acessso à rua:</label>
                                        <select class="form-control" id="acesso_rua" name="acesso_rua">
                                            <option value="">Selecionar...</option>
                                            <option @if($consult['acesso_rua'] == 'acesso_rua_sim') selected @endif  value="acesso_rua_sim">Sim</option>
                                            <option @if($consult['acesso_rua'] == 'acesso_rua_não') selected @endif  value="acesso_rua_não">Não</option>
                                            <option @if($consult['acesso_rua'] == 'acesso_rua_coleira') selected @endif  value="acesso_rua_coleira">Passeio de Coleira</option>
                                        </select>
                                    </div>
                                    <!--  -->
                                </div>
                            </div>
                            
                            <div class="row">
                                <div class="col-md p-2">
                                    <!-- Contactantes -->
                                    <div class="form-group">
                                        <label for="contactantes">Contactantes:</label>
                                        <select class="form-control" id="contactantes" name="contactantes">
                                            <option value="">Selecionar...</option>
                                            <option @if($consult['contactantes'] == 'contactantes_nenhum') selected @endif  value="contactantes_nenhum">Nenhum</option>
                                            <option @if($consult['contactantes'] == 'contactantes_gatos') selected @endif  value="contactantes_gatos">Gatos</option>
                                            <option @if($consult['contactantes'] == 'contactantes_caes') selected @endif  value="contactantes_caes">Cães</option>
                                            <option @if($consult['contactantes'] == 'contactantes_outros') selected @endif  value="contactantes_outros">Outros</option>
                                        </select>
                                    </div>
                                </div>

                                <div class="col-md p-2">
                                    <div class="form-group">
                                        <label for="contactantes_quant">Contactantes <small>Quant.:</small></label>
                                        <input type="number" class="form-control" id="contactantes_quant" name="contactantes_quant" value="{{$consult['contactantes_quant']}}">
                                    </div>
                                </div>

                                <div class="col-md p-2">
                                    <div class="form-group">
                                        <label for="integracao">Interação:</label>
                                        <select class="form-control" id="integracao" name="integracao">
                                            <option value="">Selecionar...</option>
                                            <option @if($consult['integracao'] == 'integração_amigavel') selected @endif  value="integração_amigavel">Amigável</option>
                                            <option @if($consult['integracao'] == 'integração_grupos') selected @endif  value="integração_grupos">Grupos</option>
                                            <option @if($consult['integracao'] == 'integração_conflituoso') selected @endif  value="integração_conflituoso">Conflituoso</option>
                                        </select>
                                    </div>
                                    <!--  -->
                                </div>
                            </div>

                        </div>
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="card">
                        <div class="card-body ld-2">

                            <div class="row">
                                <div class="col-md p-2">
                                    <!-- Dieta Seca -->
                                    <div class="form-group">
                                        <label for="dieta_seca">Dieta Seca:</label>
                                        <input type="text" class="form-control" id="dieta_seca" name="dieta_seca" value="{{$consult['dieta_seca']}}">
                                    </div>
                                </div>
                                <div class="col-md p-2">
                                    <div class="form-group">
                                        <label for="rotina">Rotina:</label>
                                        <select class="form-control" id="rotina" name="dieta_seca_rotina">
                                            <option value="">Selecionar...</option>
        
                                            <option @if($consult['dieta_seca_rotina'] == 'dieta_seca_rotina_ad_libidum') selected @endif  value="dieta_seca_rotina_ad_libidum">Ad Libidum</option>
        
                                            <option @if($consult['dieta_seca_rotina'] == 'dieta_seca_rotina_fracionado') selected @endif  value="dieta_seca_rotina_fracionado">Fracionado</option>
        
                                        </select>
                                    </div>
                                    <!--  -->
                                </div>
                            </div>
                            
                            <div class="row">
                                <div class="col-md p-2">
                                    <!-- Dieta Pastosa -->
                                    <div class="form-group">
                                        <label for="dieta_pastosa">Dieta Pastosa:</label>
                                        <select class="form-control" id="dieta_pastosa" name="dieta_pastosa">
                                            <option value="">Selecionar...</option>

                                            <option @if($consult['dieta_pastosa'] == 'dieta_pastosa_sem') selected @endif  value="dieta_pastosa_sem">Sem Interesse</option>

                                            <option @if($consult['dieta_pastosa'] == 'dieta_pastosa_medio') selected @endif  value="dieta_pastosa_medio">Médio Interesse</option>

                                            <option @if($consult['dieta_pastosa'] == 'dieta_pastosa_alto') selected @endif  value="dieta_pastosa_alto">Alto Interesse</option>

                                        </select>
                                    </div>
                                </div>

                                <div class="col-md p-2">
                                    <div class="form-group">
                                        <label for="frequencia">Frequência:</label>
                                        <select class="form-control" id="frequencia" name="dieta_pastosa_frequencia">
                                            <option value="">Selecionar...</option>
        
                                            <option @if($consult['dieta_pastosa_frequencia'] == 'dieta_pastosa_frequencia_diaria') selected @endif  value="dieta_pastosa_frequencia_diaria">Diária</option>
        
                                            <option @if($consult['dieta_pastosa_frequencia'] == 'dieta_pastosa_frequencia_quinzenal') selected @endif  value="dieta_pastosa_frequencia_quinzenal">Quinzenal</option>
        
                                            <option @if($consult['dieta_pastosa_frequencia'] == 'dieta_pastosa_frequencia_esporadica') selected @endif  value="dieta_pastosa_frequencia_esporadica">Esporádica</option>
        
                                        </select>
                                    </div>
                                    <!--  -->
                                </div>
                            </div>
                            
                            <div class="row">
                                <div class="col-md p-2">
                                    <!-- Vacinação -->
                                    <div class="form-group">
                                        <label for="vacina">Vacinação:</label>
                                        <select class="form-control" id="vacina" name="vacina">
                                            <option value="">Selecionar...</option>

                                            <option @if($consult['vacina'] == 'nao_vacinado') selected @endif  value="nao_vacinado">Não vacinado</option>
                                            
                                            <option @if($consult['vacina'] == 'vacina_v3') selected @endif  value="vacina_v3">V3</option>

                                            <option @if($consult['vacina'] == 'vacina_v4') selected @endif  value="vacina_v4">V4</option>

                                            <option @if($consult['vacina'] == 'vacina_v5') selected @endif  value="vacina_v5">V5</option>

                                        </select>
                                    </div>
                                </div>
                                <div class="col-md p-2">
                                    <div class="form-group">
                                        <label for="vacina_data">Vacinação - Data:</label>
                                        <input type="date" 
                                        @if (!empty($consult['vacina_data']))
                                            value="{{date('Y-m-d', strtotime($consult['vacina_data']))}}"
                                        @else
                                            value="0000-00-00"
                                        @endif
                                         class="form-control" id="vacina_data" name="vacina_data">
                                    </div>
                                    <!--  -->
                                </div>
                            </div>
                            
                            <div class="row">
                                <div class="col-md p-2">
                                    <!-- A.R. -->
                                    <div class="form-group">
                                        <label for="AR">A.R.:</label>
                                        <select class="form-control" id="AR" name="ar">
                                            <option value="">Selecionar...</option>

                                            <option @if($consult['ar'] == 'Não vaciando') selected @endif  value="Não vaciando">Não vacinado</option>

                                            <option @if($consult['ar'] == 'ar_emdia') selected @endif  value="ar_emdia">Em Dia</option>

                                            <option @if($consult['ar'] == 'ar_atrasada') selected @endif  value="ar_atrasada">Atrasada</option>

                                        </select>
                                    </div>
                                </div>
                                <div class="col-md p-2">
                                    <div class="form-group">
                                        <label for="ar_data">A.R. - Data:</label>
                                        <input type="date" 
                                        @if (!empty($consult['ar_data']))
                                            value="{{date('Y-m-d', strtotime($consult['ar_data']))}}"
                                        @else
                                            value="0000-00-00"
                                        @endif
                                         class="form-control" id="ar_data" name="ar_data">
                                    </div>
                                    <!--  -->
                                </div>
                            </div>
                            
                            <div class="row">
                                <div class="col-md p-2">
                                    <!-- Vermifugação -->
                                    <div class="form-group">
                                        <label for="vermifugacao">Vermifugação:</label>
                                        <input value="{{$consult['vermifugacao']}}" type="text" class="form-control" id="vermifugacao" name="vermifugacao">
                                    </div>
                                </div>
                                <div class="col-md p-2">
                                    <div class="form-group">
                                        <label for="verm_data">Vermifugação - Data:</label>
                                        <input type="date" 
                                        @if (!empty($consult['vermifugacao_data']))
                                            value="{{date('Y-m-d', strtotime($consult['vermifugacao_data']))}}"
                                        @else
                                            value="0000-00-00"
                                        @endif
                                         class="form-control" id="verm_data" name="vermifugacao_data">
                                    </div>
                                    <!--  -->
                                </div>
                            </div>

                            

                        </div>
                    </div>
                </div>
            </div>

            <div class="row">
                <div class="col-md-6">
                    <div class="card">
                        <div class="card-body le-3">

                            <!-- FIV / FeLV -->
                            <div class="area_campo">
                            <label for="">FIV / FeLV:</label>
                            <div class="form-consulta-checkbox">
                                
                                <label class="form-check-label">
                                    <input @empty(!$consult['fiv_felv_negativo']) checked @endempty type="checkbox" name="fiv_felv_negativo">Negativo
                                </label>

                                <label class="form-check-label">
                                    <input @empty(!$consult['fiv_felv_naoTestado']) checked @endempty type="checkbox" name="fiv_felv_naoTestado"> Não testado
                                </label>
                            
                                <label class="form-check-label">
                                    <input @empty(!$consult['fiv_felv_fiv']) checked @endempty type="checkbox" name="fiv_felv_fiv"> FIV
                                </label>
                            
                            
                                <label class="form-check-label">
                                    <input @empty(!$consult['fiv_felv_felv']) checked @endempty type="checkbox" name="fiv_felv_felv"> FeLV
                                </label>
                            </div>
                            </div>
                            <!--  -->

                            

                            <!-- Olhos -->
                            <div class="area_campo">
                            <label for="">Olhos:</label>
                            <div class="form-consulta-checkbox">
                                <label class="form-check-label">
                                    <input @empty(!$consult['olhos_blefaroespasmo']) checked @endempty type="checkbox" name="olhos_blefaroespasmo"> Blefaroespasmo
                                </label>
                            
                                <label class="form-check-label">
                                    <input @empty(!$consult['olhos_secrecao']) checked @endempty type="checkbox" name="olhos_secrecao"> Secreção
                                </label>
                            </div>

                            <div class="form-group" id="form-group-secrecao">
                                <label>Secreção:</label>
                                <select class="form-control" id="o_sec_tip" name="olhos_secrecao_tipo">
                                    <option value="">Selecionar...</option>

                                    <option @if($consult['olhos_secrecao_tipo'] == 'olhos_secrecao_aquosa') selected @endif  value="olhos_secrecao_aquosa">Aquosa</option>

                                    <option @if($consult['olhos_secrecao_tipo'] == 'olhos_secrecao_mucosa') selected @endif  value="olhos_secrecao_mucosa">Mucosa</option>

                                    <option @if($consult['olhos_secrecao_tipo'] == 'olhos_secrecao_purolenta') selected @endif  value="olhos_secrecao_purolenta">Purolenta</option>

                                </select>
                            </div>
                            </div>
                            <!--  -->
                            
                            <!-- Orelhas -->
                            <label for="">Orelhas:</label>
                            <div class="form-consulta-checkbox">

                                <label class="form-check-label">
                                    <input @empty(!$consult['orelhas_prurido']) checked @endempty type="checkbox" name="orelhas_prurido"> Prurido
                                </label>
                            
                                <label class="form-check-label">
                                    <input @empty(!$consult['orelhas_secrecao']) checked @endempty type="checkbox" name="orelhas_secrecao"> Secreção
                                </label>
                                
                            </div>

                            <div class="form-group" id="form-group-secrecao">
                                <label>Secreção:</label>
                                <select class="form-control" id="or_sec_tip" name="orelhas_secrecao_tipo">
                                    <option value="">Selecionar...</option>

                                    <option @if($consult['orelhas_secrecao_tipo'] == 'orelhas_secrecao_cerumen') selected @endif  value="orelhas_secrecao_cerumen">Cerúmen</option>

                                    <option @if($consult['orelhas_secrecao_tipo'] == 'orelhas_secrecao_escura') selected @endif  value="orelhas_secrecao_escura">Escura</option>

                                    <option @if($consult['orelhas_secrecao_tipo'] == 'orelhas_secrecao_ressecada') selected @endif  value="orelhas_secrecao_ressecada">Ressecada</option>

                                </select>
                            </div>
                            <!--  -->
                            
                            <!-- Pele -->
                            <label for="">Pele:</label>
                            <div class="form-consulta-checkbox">
                                <label class="form-check-label">
                                    <input @empty(!$consult['pele_feridas']) checked @endempty type="checkbox" name="pele_feridas">Feridas
                                </label>
                            
                                <label class="form-check-label">
                                    <input @empty(!$consult['pele_prurido']) checked @endempty type="checkbox" name="pele_prurido">Prurido
                                </label>
                            
                            
                                <label class="form-check-label">
                                    <input @empty(!$consult['pele_nodulos']) checked @endempty type="checkbox" name="pele_nodulos">Nódulos
                                </label>
                            
                            
                                <label class="form-check-label">
                                    <input @empty(!$consult['pele_falha']) checked @endempty type="checkbox" name="pele_falha">Falha de Pelo
                                </label>
                            
                            
                                <label class="form-check-label">
                                    <input @empty(!$consult['pele_ecto']) checked @endempty type="checkbox" name="pele_ecto">Ectoparasitas
                                </label>
                            </div>
                            <!--  -->

                        </div>
                    </div>
                </div>

                <div class="col-md-6">
                    <div class="card">
                        <div class="card-body ld-3">
                            <!-- Respiratório -->
                            <label for="">Respiratório:</label>
                            <div class="form-consulta-checkbox">
                                <label class="form-check-label">
                                    <input @empty(!$consult['respiratorio_dispneia']) checked @endempty type="checkbox" name="respiratorio_dispneia">Dispneia 
                                </label>
                            
                                <label class="form-check-label">
                                    <input @empty(!$consult['respiratorio_tosses']) checked @endempty type="checkbox" name="respiratorio_tosses">Tosses 
                                </label>

                                <label class="form-check-label">
                                    <input @empty(!$consult['respiratorio_espirros']) checked @endempty type="checkbox" name="respiratorio_espirros">Espirros 
                                </label>
                            </div>

                            <div class="row">
                                <div class="col-md p-2">
                                    <div class="form-group">
                                        <label for="esp_freq">Frequência:</label>
                                        <input value="{{$consult['respiratorio_frequencia']}}" type="text" class="form-control" id="esp_freq" name="respiratorio_frequencia">
                                    </div>
                                </div>
                                <div class="col-md p-2">
                                    <div class="form-group" id="form-group-secrecao">
                                        <label>Secreção Nasal:</label>
                                        <select class="form-control" id="sec_nasal" name="secrecao_nasal">
                                            <option value="">Selecionar...</option>
        
                                            <option @if($consult['secrecao_nasal'] == 'secrecao_nasal_aquosa') selected @endif  value="secrecao_nasal_aquosa">Aquosa</option>
        
                                            <option @if($consult['secrecao_nasal'] == 'secrecao_nasal_mucosa') selected @endif  value="secrecao_nasal_mucosa">Mucosa</option>
        
                                            <option @if($consult['secrecao_nasal'] == 'secrecao_nasal_purolenta') selected @endif  value="secrecao_nasal_purolenta">Purolenta</option>
        
                                        </select>
                                    </div>
                                    <!--  -->
                                </div>
                            </div>
                            
                            <!-- Castração -->
                            <label for="">Castração:</label>
                            <div class="form-consulta-checkbox">
                                <label class="form-check-label">
                                    <input @empty(!$consult['castracao_castrado']) checked @endempty type="checkbox" name="castracao_castrado">Castrado
                                </label>
                            
                                <label class="form-check-label">
                                    <input @empty(!$consult['castracao_inteiro']) checked @endempty type="checkbox" name="castracao_inteiro">Inteiro
                                </label>

                                <label class="form-check-label">
                                    <input @empty(!$consult['castracao_criptorquida']) checked @endempty type="checkbox" name="castracao_criptorquida">Criptorquida
                                </label>
                            </div>
                            <!--  -->
                            
                            <!-- Atividade -->
                            <label for="">Atividade:</label>
                            <div class="form-consulta-checkbox">
                                <label class="form-check-label">
                                    <input @empty(!$consult['atitude_normal']) checked @endempty type="checkbox" name="atitude_normal">Normal
                                </label>
                            
                                <label class="form-check-label">
                                    <input @empty(!$consult['atitude_dimin']) checked @endempty type="checkbox" name="atitude_dimin">Diminuída
                                </label>

                                <label class="form-check-label">
                                    <input @empty(!$consult['atitude_apatia']) checked @endempty type="checkbox" name="atitude_apatia">Apatia
                                </label>

                                <label class="form-check-label">
                                    <input @empty(!$consult['atitude_agitado']) checked @endempty type="checkbox" name="atitude_agitado">Agitado
                                </label>

                                <label class="form-check-label">
                                    <input @empty(!$consult['atitude_entediado']) checked @endempty type="checkbox" name="atitude_entediado">Entediado
                                </label>
                            </div>
                            <!--  -->

                            

                            <div class="row">
                                <div class="col-md p-2">
                                    <!-- Apetite -->
                                    <div class="form-group">
                                        <label for="apetite">Apetite:</label>
                                        <select class="form-control" id="apetite" name="apetite">
                                            <option value="">Selecionar...</option>

                                            <option @if($consult['apetite'] == 'apetite_normal') selected @endif  value="apetite_normal">Normal</option>

                                            <option @if($consult['apetite'] == 'apetite_caprichoso') selected @endif  value="apetite_caprichoso">Caprichoso</option>

                                            <option @if($consult['apetite'] == 'apetite_aumentado') selected @endif  value="apetite_aumentado">Aumentado</option>

                                        </select>
                                    </div>
                                    <!--  -->
                                </div>
                                <div class="col-md p-2">
                                    <!-- Mastigação -->
                                    <div class="form-group">
                                        <label for="mastigacao">Mastigação:</label>
                                        <select class="form-control" id="mastigacao" name="mastigacao">
                                            <option value="">Selecionar...</option>

                                            <option @if($consult['mastigacao'] == 'mastigacao_normal') selected @endif  value="mastigacao_normal">Normal</option>

                                            <option @if($consult['mastigacao'] == 'mastigacao_dificuldade') selected @endif  value="mastigacao_dificuldade">Dificuldade</option>

                                            <option @if($consult['mastigacao'] == 'mastigacao_rapido') selected @endif  value="mastigacao_rapido">Rápida</option>

                                        </select>
                                    </div>
                                    <!--  -->
                                </div>
                            </div>
                            



                        </div>
                    </div>
                </div>


            </div>

            <div class="row">
                <div class="col-md-6">
                    <div class="card">
                        <div class="card-body le-4">

                            <div class="row">
                                <div class="col-md p-2">
                                    <!-- Vômito -->
                                    <div class="form-group">
                                        <label for="vomito">Vômito:</label>
                                        <select class="form-control" id="vomito" name="vomito">
                                            <option value="">Selecionar...</option>

                                            <option @if($consult['vomito'] == 'vomito_nega') selected @endif  value="vomito_nega">Nega</option>

                                            <option @if($consult['vomito'] == 'vomito_frequente') selected @endif  value="vomito_frequente">Frequente</option>

                                            <option @if($consult['vomito'] == 'vomito_ocasional') selected @endif  value="vomito_ocasional">Ocasional</option>

                                            <option @if($consult['vomito'] == 'vomito_esporadico') selected @endif  value="vomito_esporadico">Esporádico</option>

                                        </select>
                                    </div>
                                </div>
                                <div class="col-md p-2">
                                    <div class="form-group">
                                        <label for="vomito_conteudo">Conteúdo:</label>
                                        <select class="form-control" id="vomito_conteudo" name="vomito_conteudo">
                                            <option value="">Selecionar...</option>
        
                                            <option @if($consult['vomito_conteudo'] == 'vomito_liquido') selected @endif  value="vomito_liquido">Líquido/Saliva</option>
        
                                            <option @if($consult['vomito_conteudo'] == 'vomito_racao') selected @endif  value="vomito_racao">Ração</option>
        
                                            <option @if($consult['vomito_conteudo'] == 'vomito_pelos') selected @endif  value="vomito_pelos">Bola de pelos</option>
        
                                            <option @if($consult['vomito_conteudo'] == 'vomito_outros') selected @endif  value="vomito_outros">Outros</option>
        
                                        </select>
                                    </div>
                                    <!--  -->
                                </div>
                            </div>

                            <!-- Ingestão Hídrica -->
                            <div class="form-group">
                                <label for="ingestao_hidrica">Ingestão Hídrica:</label>
                                <select class="form-control" id="ingestao_hidrica" name="ingestao_hidrica">
                                    <option value="">Selecionar...</option>

                                    <option @if($consult['ingestao_hidrica'] == 'ingestao_hidrica_normal') selected @endif  value="ingestao_hidrica_normal">Normal</option>

                                    <option @if($consult['ingestao_hidrica'] == 'ingestao_hidrica_diminuida') selected @endif  value="ingestao_hidrica_diminuida">Diminuída</option>

                                    <option @if($consult['ingestao_hidrica'] == 'ingestao_hidrica_aumentada') selected @endif  value="ingestao_hidrica_aumentada">Aumentada</option>

                                </select>
                            </div>
                            <!--  -->

                            <div class="row">
                                <div class="col-md p-2">
                                    <!-- Fezes -->
                                    <div class="form-group">
                                        <label for="fezes">Fezes:</label>
                                        <select class="form-control" id="fezes" name="fezes">
                                            <option value="">Selecionar...</option>

                                            <option @if($consult['fezes'] == 'fezes_normal') selected @endif  value="fezes_normal">Normal</option>

                                            <option @if($consult['fezes'] == 'fezes_pastosa') selected @endif  value="fezes_pastosa">Pastosas</option>

                                            <option @if($consult['fezes'] == 'fezes_diarreica') selected @endif  value="fezes_diarreica">Diarreicas</option>

                                            <option @if($consult['fezes'] == 'fezes_ressecada') selected @endif  value="fezes_ressecada">Ressecadas</option>

                                        </select>
                                    </div>
                                </div>
                                <div class="col-md p-2">
                                    <div class="form-group">
                                        <label for="fez_freq">Frequência:</label>
                                        <input value="{{$consult['fezes_frequencia']}}" type="text" class="form-control" id="fez_freq" name="fezes_frequencia">
                                    </div>
                                    <!--  -->
                                </div>
                            </div>

                            <!-- Escore Corporal -->
                            <div class="form-group">
                                <label for="escore_corporal">Escore Corporal:</label>
                                <select class="form-control" id="escore_corporal" name="escore_corporal">
                                    <option value="">Selecionar...</option>

                                    <option @if($consult['escore_corporal'] == 'escore_corporal_caquetico') selected @endif  value="escore_corporal_caquetico">Caquético</option>

                                    <option @if($consult['escore_corporal'] == 'escore_corporal_magro') selected @endif  value="escore_corporal_magro">Magro</option>

                                    <option @if($consult['escore_corporal'] == 'escore_corporal_normal') selected @endif  value="escore_corporal_normal">Normal</option>

                                    <option @if($consult['escore_corporal'] == 'escore_corporal_obeso') selected @endif  value="escore_corporal_obeso">Obeso</option>

                                </select>
                            </div>
                            <!--  -->

                        </div>
                    </div>
                </div>

                <div class="col-md-6">
                    <div class="card">
                        <div class="card-body ld-4">

                            <!-- Nível de Consciência -->
                            <div class="form-group">
                                <label for="nivel_consciencia">Nível de Consciência:</label>
                                <select class="form-control" id="nivel_consciencia" name="nivel_consciencia">
                                    <option value="">Selecionar...</option>

                                    <option @if($consult['nivel_consciencia'] == 'nivel_consciencia_normal') selected @endif  value="nivel_consciencia_normal">Normal</option>

                                    <option @if($consult['nivel_consciencia'] == 'nivel_consciencia_apatico') selected @endif  value="nivel_consciencia_apatico">Apático</option>

                                    <option @if($consult['nivel_consciencia'] == 'nivel_consciencia_comatoso') selected @endif  value="nivel_consciencia_comatoso">Comatoso</option>

                                    <option @if($consult['nivel_consciencia'] == 'nivel_consciencia_excitado') selected @endif  value="nivel_consciencia_excitado">Excitado</option>

                                </select>
                            </div>
                            <!--  -->

                            <!-- Urina -->
                            <label for="">Urina:</label>
                            <div class="form-consulta-checkbox">
                                <label class="form-check-label">
                                    <input @empty(!$consult['urina_normal']) checked @endempty type="checkbox" name="urina_normal">Normal
                                </label>
                            
                                <label class="form-check-label">
                                    <input @empty(!$consult['urina_periuria']) checked @endempty type="checkbox" name="urina_periuria">Periúria
                                </label>

                                <label class="form-check-label">
                                    <input @empty(!$consult['urina_aumentada']) checked @endempty type="checkbox" name="urina_aumentada">Aumentada
                                </label>

                                <label class="form-check-label">
                                    <input @empty(!$consult['urina_diminuida']) checked @endempty type="checkbox" name="urina_diminuida">Diminuída
                                </label>

                                <label class="form-check-label">
                                    <input @empty(!$consult['urina_estranguria']) checked @endempty type="checkbox" name="urina_estranguria">Estrangúria
                                </label>
                            </div>

                            <div class="form-group">
                                <label for="urina_frequencia">Frequência:</label>
                                <input value="{{$consult['urina_frequencia']}}" type="text" class="form-control" id="urina_frequencia" name="urina_frequencia">
                            </div>
                            <!--  -->

                            <!-- Atitude -->
                            <label for="">Atitude:</label>
                            <div class="form-consulta-checkbox">
                                <label class="form-check-label">
                                    <input @empty(!$consult['atitude_docil']) checked @endempty type="checkbox" name="atitude_docil">Dócil
                                </label>

                                <label class="form-check-label">
                                    <input @empty(!$consult['atitude_desconfiado']) checked @endempty type="checkbox" name="atitude_desconfiado">Desconfiado
                                </label>

                                <label class="form-check-label">
                                    <input @empty(!$consult['atitude_medroso']) checked @endempty type="checkbox" name="atitude_medroso">Medroso
                                </label>

                                <label class="form-check-label">
                                    <input @empty(!$consult['atitude_agressivo']) checked @endempty type="checkbox" name="atitude_agressivo">Agressivo
                                </label>

                                <label class="form-check-label">
                                    <input @empty(!$consult['atitude_arredio']) checked @endempty type="checkbox" name="atitude_arredio">Arredio
                                </label>
                            </div>
                            <!--  -->

                        </div>
                    </div>
                </div>
            </div>

            <div class="card card-primary card-outline">
                <div class="card-body">
                    <h4>Exame Físico</h4>
                </div>
            </div>

            <div class="row">
                <div class="col-md-6">
                    <div class="card">
                        <div class="card-body le-5">

                            <div class="row">
                                <div class="col-md p-2">
                                    <!-- Avaliação Ocular -->
                                    <label for="">Avaliação Ocular:</label>
                                    <div class="form-consulta-checkbox">
                                        <label class="form-check-label">
                                            <input @empty(!$consult['avaliacao_ocular_normal']) checked @endempty type="checkbox" name="avaliacao_ocular_normal">Normal
                                        </label>
                                    </div>
                                </div>
                                <div class="col-md p-2">
                                    <div class="form-group">
                                        <label for="avaliacao_ocular_secrecao">Secreção:</label>
                                        <select class="form-control" id="avaliacao_ocular_secrecao" name="avaliacao_ocular_secrecao">
                                            <option value="">Selecionar...</option>
        
                                            <option @if($consult['avaliacao_ocular_secrecao'] == 'avaliacao_ocular_secrecao_aquosa') selected @endif  value="avaliacao_ocular_secrecao_aquosa">Aquoso</option>
        
                                            <option @if($consult['avaliacao_ocular_secrecao'] == 'avaliacao_ocular_secrecao_mucosa') selected @endif  value="avaliacao_ocular_secrecao_mucosa">Mucosa</option>
        
                                            <option @if($consult['avaliacao_ocular_secrecao'] == 'avaliacao_ocular_secrecao_purulenta') selected @endif  value="avaliacao_ocular_secrecao_purulenta">Purulenta</option>
        
                                        </select>
                                    </div>
                                </div>
                            </div>

                            <div class="row">
                                <div class="col-md p-2">
                                    <div class="form-group">
                                        <label for="avaliacao_ocular_esclera">Esclera:</label>
                                        <select class="form-control" id="avaliacao_ocular_esclera" name="avaliacao_ocular_esclera">
                                            <option value="">Selecionar...</option>
        
                                            <option @if($consult['avaliacao_ocular_esclera'] == 'avaliacao_ocular_esclera_congestao') selected @endif  value="avaliacao_ocular_esclera_congestao">Congestão</option>
        
                                        </select>
                                    </div>
                                </div>
                                <div class="col-md p-2">
                                    <div class="form-group">
                                        <label for="avaliacao_ocular_cornea">Córnea:</label>
                                        <select class="form-control" id="avaliacao_ocular_cornea" name="avaliacao_ocular_cornea">
                                            <option value="">Selecionar...</option>
        
                                            <option @if($consult['avaliacao_ocular_cornea'] == 'avaliacao_ocular_cornea_opacidade') selected @endif  value="avaliacao_ocular_cornea_opacidade">Opacidade</option>
        
                                            <option @if($consult['avaliacao_ocular_cornea'] == 'avaliacao_ocular_cornea_neovasos') selected @endif  value="avaliacao_ocular_cornea_neovasos">Neovasos</option>
        
                                        </select>
                                    </div>
                                </div>
                            </div>

                            <div class="row">
                                <div class="col-md p-2">
                                    <div class="form-group">
                                        <label for="avaliacao_ocular_lente">Lente:</label>
                                        <select class="form-control" id="avaliacao_ocular_lente" name="avaliacao_ocular_lente">
                                            <option value="">Selecionar...</option>
        
                                            <option @if($consult['avaliacao_ocular_lente'] == 'avaliacao_ocular_lente_opacidade') selected @endif  value="avaliacao_ocular_lente_opacidade">Opacidade</option>
        
                                        </select>
                                    </div>
                                </div>
                                <div class="col-md p-2">
                                    <div class="form-group">
                                        <label for="avaliacao_ocular_conjuntiva">Conjuntiva:</label>
                                        <select class="form-control" id="avaliacao_ocular_conjuntiva" name="avaliacao_ocular_conjuntiva">
                                            <option value="">Selecionar...</option>
        
                                            <option @if($consult['avaliacao_ocular_conjuntiva'] == 'avaliacao_ocular_conjuntiva_quemose') selected @endif  value="avaliacao_ocular_conjuntiva_quemose">Quemose</option>
        
                                        </select>
                                    </div>
                                </div>
                            </div>
                            <!-- Mucosas -->
                            <label for="">Mucosas:</label>
                            <div class="form-consulta-checkbox">
                                <label class="form-check-label">
                                    <input @empty(!$consult['mucosas_normais']) checked @endempty type="checkbox" name="mucosas_normais">Normais
                                </label>
                            
                                <label class="form-check-label">
                                    <input @empty(!$consult['mucosas_palidas']) checked @endempty type="checkbox" name="mucosas_palidas">Pálidas
                                </label>

                                <label class="form-check-label">
                                    <input @empty(!$consult['mucosas_icterias']) checked @endempty type="checkbox" name="mucosas_icterias">Ictérias
                                </label>

                                <label class="form-check-label">
                                    <input @empty(!$consult['mucosas_congestas']) checked @endempty type="checkbox" name="mucosas_congestas">Congestas
                                </label>

                                <label class="form-check-label">
                                    <input @empty(!$consult['mucosas_cianoticas']) checked @endempty type="checkbox" name="mucosas_cianoticas">Cianóticas
                                </label>
                            </div>
                            <!--  -->
                        </div>
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="card">
                        <div class="card-body ld-5">

                            <!-- FR / FC -->
                            <div class="row">

                                <div class="col-sm-6">
                                    <div class="form-group">
                                        <label for="fr">FR: <small>(em mpm)</small></label>
                                        <input value="{{$consult['fr']}}" type="text" class="form-control" id="fr" name="fr" placeholder="mpm">
                                    </div>
                                </div>

                                <div class="col-sm-6">
                                    <div class="form-group">
                                        <label for="fc">FC: <small>(em bpm)</small></label>
                                        <input value="{{$consult['fc']}}" type="text" class="form-control" id="fc" name="fc" placeholder="bpm">
                                    </div>
                                </div>

                            </div>
                            <!--  -->

                            <div class="row">
                                <div class="col-md p-2">
                                    <!-- Movimento Respiratório -->
                                    <label for="">Movimento Respiratório:</label>
                                    <div class="form-consulta-checkbox">
                                        <label class="form-check-label">
                                            <input @empty(!$consult['movimento_respiratorio_normal']) checked @endempty type="checkbox" name="movimento_respiratorio_normal">Normal
                                        </label>
                                    </div>
                                </div>
                                <div class="col-md p-2">
                                    <div class="form-group">
                                        <label for="disp">Dispinéia:</label>
                                        <select class="form-control" id="disp" name="dispineia">
                                            <option value="">Selecionar...</option>
        
                                            <option @if($consult['dispineia'] == 'movimento_respiratorio_oral') selected @endif  value="movimento_respiratorio_oral">Respiração Oral</option>
        
                                            <option @if($consult['dispineia'] == 'movimento_respiratorio_ortopneia') selected @endif  value="movimento_respiratorio_ortopneia">Ortopneia</option>
        
                                        </select>
                                    </div>
                                    <!--  -->
                                </div>
                            </div>

                            <div class="row">
                                <div class="col-md p-2">
                                    <!-- Orelhas -->
                                    <label for="">Orelhas:</label>
                                    <div class="form-consulta-checkbox">
                                        <label class="form-check-label">
                                            <input @empty(!$consult['orelhas_normal']) checked @endempty type="checkbox" name="orelhas_normal">Normal
                                        </label>
                                    </div>
                                </div>
                                <div class="col-md p-2">
                                    <div class="form-group">
                                        <label for="exfis_orelhas_secrecao">Secreção:</label>
                                        <select class="form-control" id="exfis_orelhas_secrecao" name="exfis_orelhas_secrecao">
                                            <option value="">Selecionar...</option>
        
                                            <option @if($consult['exfis_orelhas_secrecao'] == 'exfis_orelhas_secrecao_cerumen') selected @endif  value="exfis_orelhas_secrecao_cerumen">Cerúmen</option>
        
                                            <option @if($consult['exfis_orelhas_secrecao'] == 'exfis_orelhas_secrecao_enegrecida') selected @endif  value="exfis_orelhas_secrecao_enegrecida">Enegrecida</option>
        
                                        </select>
                                    </div>
                                    <!--  -->
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="row">
                <div class="col-md-6">
                    <div class="card">
                        <div class="card-body le-6">

                            <!-- Linfonodos -->
                            <label for="">Linfonodos:</label>
                            <div class="form-consulta">
                                
                                <ul class="list-group">
                                    <ul class="list-group-item list-group-item">

                                        <div class="list-group">
                                            <a href="" id="mandibular" class="list-group-item list-group-item-action">Mandibular</a>
                                        </div>

                                        <div class="mandibular_selecao" style="display: none;">
                                            <ul class="list-group-item list-group-item">
                                                <div class="form-group">
                                                    <label for="linfonodo_mandibular_direito">Direito:</label>
                                                    <select id="linfonodo_mandibular_direito" name="linfonodo_mandibular_direito" class="form-control">
                                                        <option value="">Selecionar...</option>

                                                        <option @if($consult['linfonodo_mandibular_direito'] == 'linfonodo_mandibular_direito_normal') selected @endif  value="linfonodo_mandibular_direito_normal">Normal</option>

                                                        <option @if($consult['linfonodo_mandibular_direito'] == 'linfonodo_mandibular_direito_aumentado') selected @endif  value="linfonodo_mandibular_direito_aumentado">Aumentado</option>

                                                    </select>
                                                    <label for="linfonodo_mandibular_direito_detalhes">Detalhes:</label>
                                                    <input value="{{$consult['linfonodo_mandibular_direito_detalhes']}}" type="text" class="form-control" id="linfonodo_mandibular_direito_detalhes" name="linfonodo_mandibular_direito_detalhes">
                                                </div>
                                            </ul>

                                            <ul class="list-group-item list-group-item">
                                                <div class="form-group">
                                                    <label for="linfonodo_mandibular_esquerdo">esquerdo:</label>
                                                    <select id="linfonodo_mandibular_esquerdo" name="linfonodo_mandibular_esquerdo" class="form-control">
                                                        <option value="">Selecionar...</option>

                                                        <option @if($consult['linfonodo_mandibular_esquerdo'] == 'linfonodo_mandibular_esquerdo_normal') selected @endif  value="linfonodo_mandibular_esquerdo_normal">Normal</option>

                                                        <option @if($consult['linfonodo_mandibular_esquerdo'] == 'linfonodo_mandibular_esquerdo_aumentado') selected @endif  value="linfonodo_mandibular_esquerdo_aumentado">Aumentado</option>

                                                    </select>
                                                    <label for="linfonodo_mandibular_esquerdo_detalhes">Detalhes:</label>
                                                    <input value="{{$consult['linfonodo_mandibular_esquerdo_detalhes']}}" type="text" class="form-control" id="linfonodo_mandibular_esquerdo_detalhes" name="linfonodo_mandibular_esquerdo_detalhes">
                                                </div>
                                            </ul>
                                        </div>

                                        <hr>

                                        <div class="list-group">
                                            <a href="" id="pre_escapular" class="list-group-item list-group-item-action">Pré-escapular</a>
                                        </div>

                                        <div class="pre_escapular_selecao" style="display: none;">
                                            <ul class="list-group-item list-group-item">
                                                <div class="form-group">
                                                    <label for="linfonodo_pre_escapular_direito">Direito:</label>
                                                    <select id="linfonodo_pre_escapular_direito" name="linfonodo_pre_escapular_direito" class="form-control">
                                                        <option value="">Selecionar...</option>

                                                        <option @if($consult['linfonodo_pre_escapular_direito'] == 'linfonodo_pre_escapular_direito_normal') selected @endif  value="linfonodo_pre_escapular_direito_normal">Normal</option>

                                                        <option @if($consult['linfonodo_pre_escapular_direito'] == 'linfonodo_pre_escapular_direito_aumentado') selected @endif  value="linfonodo_pre_escapular_direito_aumentado">Aumentado</option>

                                                    </select>
                                                    <label for="linfonodo_pre_escapular_direito_detalhes">Detalhes:</label>
                                                    <input value="{{$consult['linfonodo_pre_escapular_direito_detalhes']}}" type="text" class="form-control" id="linfonodo_pre_escapular_direito_detalhes" name="linfonodo_pre_escapular_direito_detalhes">
                                                </div>
                                            </ul>

                                            <ul class="list-group-item list-group-item">
                                                <div class="form-group">
                                                    <label for="linfonodo_pre_escapular_esquerdo">esquerdo:</label>
                                                    <select id="linfonodo_pre_escapular_esquerdo" name="linfonodo_pre_escapular_esquerdo" class="form-control">
                                                        <option value="">Selecionar...</option>

                                                        <option @if($consult['linfonodo_pre_escapular_esquerdo'] == 'linfonodo_pre_escapular_esquerdo_normal') selected @endif  value="linfonodo_pre_escapular_esquerdo_normal">Normal</option>

                                                        <option @if($consult['linfonodo_pre_escapular_esquerdo'] == 'linfonodo_pre_escapular_esquerdo_aumentado') selected @endif  value="linfonodo_pre_escapular_esquerdo_aumentado">Aumentado</option>

                                                    </select>
                                                    <label for="linfonodo_pre_escapular_esquerdo_detalhes">Detalhes:</label>
                                                    <input value="{{$consult['linfonodo_pre_escapular_esquerdo_detalhes']}}" type="text" class="form-control" id="linfonodo_pre_escapular_esquerdo_detalhes" name="linfonodo_pre_escapular_esquerdo_detalhes">
                                                </div>
                                            </ul>
                                        </div>

                                        <hr>

                                        <div class="list-group">
                                            <a href="" id="popliteo" class="list-group-item list-group-item-action">Poplíteo</a>
                                        </div>

                                        <div class="popliteo_selecao" style="display: none;">
                                            <ul class="list-group-item list-group-item">
                                                <div class="form-group">
                                                    <label for="linfonodo_popliteo_direito">Direito:</label>
                                                    <select id="linfonodo_popliteo_direito" name="linfonodo_popliteo_direito" class="form-control">
                                                        <option value="">Selecionar...</option>

                                                        <option @if($consult['linfonodo_popliteo_direito'] == 'linfonodo_popliteo_direito_normal') selected @endif  value="linfonodo_popliteo_direito_normal">Normal</option>

                                                        <option @if($consult['linfonodo_popliteo_direito'] == 'linfonodo_popliteo_direito_aumentado') selected @endif  value="linfonodo_popliteo_direito_aumentado">Aumentado</option>

                                                    </select>
                                                    <label for="linfonodo_popliteo_direito_detalhes">Detalhes:</label>
                                                    <input value="{{$consult['linfonodo_popliteo_direito_detalhes']}}" type="text" class="form-control" id="linfonodo_popliteo_direito_detalhes" name="linfonodo_popliteo_direito_detalhes">
                                                </div>
                                            </ul>

                                            <ul class="list-group-item list-group-item">
                                                <div class="form-group">
                                                    <label for="linfonodo_popliteo_esquerdo">esquerdo:</label>
                                                    <select id="linfonodo_popliteo_esquerdo" name="linfonodo_popliteo_esquerdo" class="form-control">
                                                        <option value="">Selecionar...</option>

                                                        <option @if($consult['linfonodo_popliteo_esquerdo'] == 'linfonodo_popliteo_esquerdo_normal') selected @endif  value="linfonodo_popliteo_esquerdo_normal">Normal</option>

                                                        <option @if($consult['linfonodo_popliteo_esquerdo'] == 'linfonodo_popliteo_esquerdo_aumentado') selected @endif  value="linfonodo_popliteo_esquerdo_aumentado">Aumentado</option>

                                                    </select>
                                                    <label for="linfonodo_popliteo_esquerdo_detalhes">Detalhes:</label>
                                                    <input value="{{$consult['linfonodo_popliteo_esquerdo_detalhes']}}" type="text" class="form-control" id="linfonodo_popliteo_esquerdo_detalhes" name="linfonodo_popliteo_esquerdo_detalhes">
                                                </div>
                                            </ul>
                                        </div>

                                    </ul>
                                </ul>

                            </div>
                            <!--  -->

                        </div>
                    </div>
                </div>

                <div class="col-md-6">
                    <div class="card">
                        <div class="card-body ld-6" id="card-rins">

                            <!-- Rins -->
                            <label for="">Rins:</label>

                            <div class="form-consulta">
                                
                                <ul class="list-group">
                                    <ul class="list-group-item list-group-item">

                                        <div class="list-group">

                                            <div class="form-consulta-checkbox">
                                                <label class="form-check-label">
                                                    <input @empty(!$consult['rins_nao_palpados']) checked @endempty class="rins_nao_palpados" type="checkbox" name="rins_nao_palpados">Não Palpados
                                                </label>
                                            </div>

                                        </div>

                                        

                                        <div class="list-group palpaveis_nao_mostrar" @empty(!$consult['rins_nao_palpados']) style="display:none;" @endempty >
                                            <hr>
                                            <a href="" id="palpaveis" class="list-group-item list-group-item-action">
                                                Palpáveis
                                            </a>
                                        </div>

                                        <div class="palpaveis_selecao palpaveis_selecao_nao_mostrar" style="display:none;">
                                            <ul class="list-group-item list-group-item">
                                                <div class="form-group">
                                                    <label for="rim_palpaveis_direito">Direito:</label>
                                                    <select id="rim_palpaveis_direito" name="rim_palpaveis_direito" class="form-control">
                                                        <option value="">Selecionar...</option>

                                                        <option @if($consult['rim_palpaveis_direito'] == 'rim_palpaveis_direito_normal') selected @endif  value="rim_palpaveis_direito_normal">Normal</option>

                                                        <option @if($consult['rim_palpaveis_direito'] == 'rim_palpaveis_direito_aumentado') selected @endif  value="rim_palpaveis_direito_aumentado">Aumentado</option>

                                                    </select>
                                                    <label for="rim_palpaveis_direito_detalhes">Detalhes:</label>
                                                    <input value="{{$consult['rim_palpaveis_direito_detalhes']}}" type="text" class="form-control" id="rim_palpaveis_direito_detalhes" name="rim_palpaveis_direito_detalhes">
                                                </div>
                                            </ul>

                                            <ul class="list-group-item list-group-item">
                                                <div class="form-group">
                                                    <label for="rim_palpaveis_esquerdo">esquerdo:</label>
                                                    <select id="rim_palpaveis_esquerdo" name="rim_palpaveis_esquerdo" class="form-control">
                                                        <option value="">Selecionar...</option>

                                                        <option @if($consult['rim_palpaveis_esquerdo'] == 'rim_palpaveis_esquerdo_normal') selected @endif  value="rim_palpaveis_esquerdo_normal">Normal</option>

                                                        <option @if($consult['rim_palpaveis_esquerdo'] == 'rim_palpaveis_esquerdo_aumentado') selected @endif  value="rim_palpaveis_esquerdo_aumentado">Aumentado</option>

                                                    </select>
                                                    <label for="rim_palpaveis_esquerdo_detalhes">Detalhes:</label>
                                                    <input value="{{$consult['rim_palpaveis_esquerdo_detalhes']}}" type="text" class="form-control" id="rim_palpaveis_esquerdo_detalhes" name="rim_palpaveis_esquerdo_detalhes">
                                                </div>
                                            </ul>
                                        </div>

                                    </ul>
                                </ul>

                            </div>
                            <!--  -->
                        </div>
                    </div>
                </div>
            </div>

            <div class="row">
                <div class="col-md-6">
                    <div class="card">
                        <div class="card-body le-7">
                            
                            <!-- Tranporte -->
                            <label for="">Transporte:</label>
                            <div class="form-consulta-checkbox">
                                <label class="form-check-label">
                                    <input @empty(!$consult['transporte_urina']) checked @endempty type="checkbox" name="transporte_urina">Urina
                                </label>
                            
                                <label class="form-check-label">
                                    <input @empty(!$consult['transporte_vomito']) checked @endempty type="checkbox" name="transporte_vomito">Vômito
                                </label>

                                <label class="form-check-label">
                                    <input @empty(!$consult['transporte_fezes']) checked @endempty type="checkbox" name="transporte_fezes">Fezes
                                </label>
                            </div>
                            <!--  -->

                            <!-- Hidratação -->
                            <div class="form-group">
                                <label for="hidratacao">Hidratação:</label>
                                <select class="form-control" id="hidratacao" name="hidratacao">
                                    <option value="">Selecionar...</option>

                                    <option @if($consult['hidratacao'] == 'hidratacao_normal') selected @endif  value="hidratacao_normal">Normal</option>

                                    <option @if($consult['hidratacao'] == 'hidratacao_discreta') selected @endif  value="hidratacao_discreta">Discreta 5%</option>

                                    <option @if($consult['hidratacao'] == 'hidratacao_leve') selected @endif  value="hidratacao_leve">Leve 6 a 8%</option>

                                    <option @if($consult['hidratacao'] == 'hidratacao_moderada') selected @endif  value="hidratacao_moderada">Moderada 9 a 10%</option>

                                    <option @if($consult['hidratacao'] == 'hidratacao_grave') selected @endif  value="hidratacao_grave">Grave > 10%</option>

                                </select>
                            </div>
                            <!--  -->

                            <!-- Bulhas -->
                            <label for="">Bulhas:</label>
                            <div class="form-consulta-checkbox">
                                <label class="form-check-label">
                                    <input @empty(!$consult['bulhas_regulares']) checked @endempty type="checkbox" name="bulhas_regulares">Regulares
                                </label>
                            
                                <label class="form-check-label">
                                    <input @empty(!$consult['bulhas_irregulares']) checked @endempty type="checkbox" name="bulhas_irregulares">Irregulares
                                </label>

                                <label class="form-check-label">
                                    <input @empty(!$consult['bulhas_normofoneticas']) checked @endempty type="checkbox" name="bulhas_normofoneticas">Normofonéticas
                                </label>

                                <label class="form-check-label">
                                    <input @empty(!$consult['bulhas_hipofoneticas']) checked @endempty type="checkbox" name="bulhas_hipofoneticas">Hipofonéticas
                                </label>
                            </div>
                            <!--  -->

                            <div class="row">
                                <div class="col-md p-2">
                                    <!-- Sopro -->
                                    <div class="form-group">
                                        <label for="sopro">Sopro:</label>
                                        <select class="form-control" id="sopro" name="sopro">
                                            <option value="">Selecionar...</option>

                                            <option @if($consult['sopro'] == 'sopro_sim') selected @endif  value="sopro_sim">Sim</option>

                                            <option @if($consult['sopro'] == 'sopro_nao') selected @endif  value="sopro_nao">Não</option>

                                        </select>
                                    </div>
                                </div>
                                <div class="col-md p-2">
                                    <div class="form-group">
                                        <label for="sopro_detalhes">Detalhes:</label>
                                        <input value="{{$consult['sopro_detalhes']}}" type="text" class="form-control" id="sopro_detalhes" name="sopro_detalhes">
                                    </div>
                                    <!--  -->
                                </div>
                            </div>

                            <div class="row">
                                <div class="col-md p-2">
                                    <!-- Visícula Urinária -->
                                    <div class="form-group">
                                        <label for="visicula_urinaria">Visícula Urinária:</label>
                                        <select class="form-control" id="visicula_urinaria" name="visicula_urinaria">
                                            <option value="">Selecionar...</option>

                                            <option @if($consult['visicula_urinaria'] == 'visicula_urinaria_vazia') selected @endif  value="visicula_urinaria_vazia">Vazia</option>

                                            <option @if($consult['visicula_urinaria'] == 'visicula_urinaria_palpavel') selected @endif  value="visicula_urinaria_palpavel">Palpável</option>

                                            <option @if($consult['visicula_urinaria'] == 'visicula_urinaria_repleta') selected @endif  value="visicula_urinaria_repleta">Repleta</option>

                                            <option @if($consult['visicula_urinaria'] == 'visicula_urinaria_obtruida') selected @endif  value="visicula_urinaria_obtruida">Obstruída</option>

                                        </select>
                                    </div>
                                    <!--  -->
                                </div>
                                <div class="col-md p-2">
                                    <!-- Palpação abd. Alças Intestinais -->
                                    <div class="form-group">
                                        <label for="alca_intest">Palpação abd. Alças Intestinais:</label>
                                        <select class="form-control" id="alca_intest" name="alca_intest">
                                            <option value="">Selecionar...</option>

                                            <option @if($consult['alca_intest'] == 'alca_intest_vazia') selected @endif  value="alca_intest_vazia">Vazia</option>

                                            <option @if($consult['alca_intest'] == 'alca_intest_pastoso') selected @endif  value="alca_intest_pastoso">Conteúdo Pastoso</option>

                                            <option @if($consult['alca_intest'] == 'alca_intest_macio') selected @endif  value="alca_intest_macio">Conteúdo Macio</option>

                                            <option @if($consult['alca_intest'] == 'alca_intest_firme') selected @endif  value="alca_intest_firme">Conteúdo Firme</option>

                                        </select>
                                    </div>
                                    <!--  -->
                                </div>
                            </div>

                            <!-- Outras Alterações -->
                            <label for="">Outras Alterações:</label>
                            <div class="form-consulta-checkbox">
                                <label class="form-check-label">
                                    <input @empty(!$consult['outras_alteracoes_gases']) checked @endempty type="checkbox" name="outras_alteracoes_gases">Gases
                                </label>
                            
                                <label class="form-check-label">
                                    <input @empty(!$consult['outras_alteracoes_abdomen_abaulado']) checked @endempty type="checkbox" name="outras_alteracoes_abdomen_abaulado">Abdômen abaulado
                                </label>

                                <label class="form-check-label">
                                    <input @empty(!$consult['outras_alteracoes_abdomen_tenso']) checked @endempty type="checkbox" name="outras_alteracoes_abdomen_tenso">Abdômen tenso
                                </label>
                            </div>
                            <!--  -->

                            <div class="row">
                                <div class="col-md p-2">
                                    <!-- Temperatura -->
                                    <div class="form-group">
                                        <label for="temperatura">Temperatura: <small>(°C)</small></label>
                                        <input value="{{$consult['temperatura']}}" type="text" class="form-control" id="temperatura" name="temperatura" placeholder="ºC">
                                    </div>
                                </div>
                                <div class="col-md p-2">
                                    <div class="form-group">
                                        <label for="tpc">TPC: <small>(segundos)</small></label>
                                        <input value="{{$consult['tpc']}}" type="text" class="form-control" id="tpc" name="tpc" placeholder="segundos">
                                    </div>
                                    <!--  -->
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="card">
                        <div class="card-body ld-7">

                            <!-- Secreção Nasal -->
                            <div class="form-group">
                                <label for="sececao_nasal">Secreção Nasal:</label>
                                <select class="form-control" id="sececao_nasal" name="sececao_nasal">
                                    <option value="">Selecionar...</option>

                                    <option @if($consult['sececao_nasal'] == 'sececao_nasal_nenhuma') selected @endif  value="sececao_nasal_nenhuma">Nenhuma</option>

                                    <option @if($consult['sececao_nasal'] == 'sececao_nasal_aquosa') selected @endif  value="sececao_nasal_aquosa">Aquosa</option>

                                    <option @if($consult['sececao_nasal'] == 'sececao_nasal_mucosa') selected @endif  value="sececao_nasal_mucosa">Mucosa</option>

                                    <option @if($consult['sececao_nasal'] == 'sececao_nasal_purulenta') selected @endif  value="sececao_nasal_purulenta">Purulenta</option>

                                </select>
                            </div>
                            <!--  -->

                            <!-- PAS -->
                            <label for="">PAS:</label>

                            <div class="row">
                                <div class="col-md p-2">
                                    <div class="form-group">
                                        <label for="pas_mmhg">mmHg:</label>
                                        <input value="{{$consult['pas_mmhg']}}" type="text" class="form-control" id="pas_mmhg" name="pas_mmhg" placeholder="mmHg">
                                    </div>
                                </div>
                                <div class="col-md p-2">
                                    <div class="form-group">
                                        <label for="pas_hash">#:</label>
                                        <input value="{{$consult['pas_hash']}}" type="text" class="form-control" id="pas_hash" name="pas_hash" placeholder="#">
                                    </div>
                                </div>
                            </div>

                            <div class="form-consulta-checkbox">
                                <label class="form-check-label">
                                    <input @empty(!$consult['pas_mpd']) checked @endempty type="checkbox" name="pas_mpd">MP D
                                </label>
                            
                                <label class="form-check-label">
                                    <input @empty(!$consult['pas_mpe']) checked @endempty type="checkbox" name="pas_mpe">MP E
                                </label>

                                <label class="form-check-label">
                                    <input @empty(!$consult['pas_mtd']) checked @endempty type="checkbox" name="pas_mtd">MT D
                                </label>

                                <label class="form-check-label">
                                    <input @empty(!$consult['pas_mte']) checked @endempty type="checkbox" name="pas_mte">MT E
                                </label>
                            </div>

                            <div class="form-group">
                                <label for="pas_posicao">Posição:</label>
                                <select class="form-control" id="pas_posicao" name="pas_posicao">
                                    <option value="">Selecionar...</option>

                                    <option @if($consult['pas_posicao'] == 'pas_posicao_deitado') selected @endif  value="pas_posicao_deitado">Deitado</option>

                                    <option @if($consult['pas_posicao'] == 'pas_posicao_sentado') selected @endif  value="pas_posicao_sentado">Sentado</option>

                                    <option @if($consult['pas_posicao'] == 'pas_posicao_colo') selected @endif  value="pas_posicao_colo">No colo</option>

                                </select>
                            </div>
                            <!--  -->

                            <!-- Glicemia -->
                            <div class="form-group">
                                <label for="glicemia">Glicemia: <small>(mg/dL)</small></label>
                                <input value="{{$consult['glicemia']}}" type="text" class="form-control" id="glicemia" name="glicemia" placeholder="mg/dL">
                            </div>
                            <!--  -->

                            <div class="row">
                                <div class="col-md p-2">
                                    <!-- Ausculta Pulmonar -->
                                    <div class="form-group">
                                        <label for="ausculta_pulmonar">Ausculta Pulmonar:</label>
                                        <select class="form-control" id="ausculta_pulmonar" name="ausculta_pulmonar">
                                            <option value="">Selecionar...</option>

                                            <option @if($consult['ausculta_pulmonar'] == 'ausculta_pulmonar_normal') selected @endif  value="ausculta_pulmonar_normal">Normal</option>

                                            <option @if($consult['ausculta_pulmonar'] == 'ausculta_pulmonar_sibilos') selected @endif  value="ausculta_pulmonar_sibilos">Sibilos</option>

                                            <option @if($consult['ausculta_pulmonar'] == 'ausculta_pulmonar_crepitacao') selected @endif  value="ausculta_pulmonar_crepitacao">Crepitação</option>

                                            <option @if($consult['ausculta_pulmonar'] == 'ausculta_pulmonar_ronco') selected @endif  value="ausculta_pulmonar_ronco">Ronco</option>

                                        </select>
                                    </div>
                                </div>
                                <div class="col-md p-2">
                                    <div class="form-group">
                                        <label for="ausculta_traqueal">Ausculta Traqueal:</label>
                                        <select class="form-control" id="ausculta_traqueal" name="ausculta_traqueal">
                                            <option value="">Selecionar...</option>
        
                                            <option @if($consult['ausculta_traqueal'] == 'ausculta_traqueal_normal') selected @endif  value="ausculta_traqueal_normal">Normal</option>
        
                                            <option @if($consult['ausculta_traqueal'] == 'ausculta_traqueal_sibilos') selected @endif  value="ausculta_traqueal_sibilos">Sibilos</option>
        
                                            <option @if($consult['ausculta_traqueal'] == 'ausculta_traqueal_ronco') selected @endif  value="ausculta_traqueal_ronco">Ronco</option>
        
                                        </select>
                                    </div>
                                    <!--  -->
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="card-body {{ ($consult['tipo'] == 'completa' OR 'simples') ? 'show_aba':'hidden_aba' }}">

            <div class="card card-primary card-outline">
                <div class="card-body">
                    <h4>Outras Informações</h4>
                </div>
            </div>

            <div class="row">
                <div class="col-md-12">
                    <div class="card">
                        <div class="card-body">
                            <!-- Exames Solicitados -->
                            <label for="">Exames Solicitados:</label>
                            <div class="form-consulta-checkbox">
                                <?php foreach($exams as $e): ?>
                                    <label class="form-check-label">
                                        <input @if(in_array($e['id'], explode(',', $consult['exames_solicitados_outros']))) checked @endif type="checkbox" name="exames_solicitados_outros[]" value="<?php echo $e['id']; ?>"><?php echo $e['name']; ?>
                                    </label>
                                <?php endforeach; ?>
                            </div>
                            <!--  -->
                        </div>
                    </div>
                </div>
            </div>

            <div class="row">
                <div class="col-md-12">
                    <div class="card">
                        <div class="card-body">
                            <div class="card-body table-responsive p-0">
                                <!-- Nosocomial -->
                                <label for="">Nosocomial:</label><br>
                                <button class="btn btn-sm btn-default" id="addNosoc-button">Inserir linha</button>
                                <table class="table table-hover">
                                    <thead>
                                        <tr>
                                            <th></th>
                                            <th>Medicação</th>
                                            <th>Via Administração</th>
                                            <th>Dose</th>
                                            <th>Frequência</th>
                                            <th>Duração</th>
                                        </tr>
                                    </thead>
                                    <tbody id="table-nosoc">
                                        @if (!empty($nosocomial))
                                            @foreach ($nosocomial as $n)
                                            <tr class='nosoc<?php echo $n['numero']; ?>' data-id="<?php echo $n['numero']; ?>">
                                                <td><a class="old_line" style="color:red" href="#" data-toggle="tooltip" title="Excluir linha!"><i class="fas fa-fw fa-trash"></i></a></td>
                                                <td><input type='text' name='nosocomial[<?php echo $n['numero']; ?>][]' value="<?php echo $n['medicacao']; ?>"></td>
                                                <td><input type='text' name='nosocomial[<?php echo $n['numero']; ?>][]' value="<?php echo $n['administracao']; ?>"></td>
                                                <td><input type='text' name='nosocomial[<?php echo $n['numero']; ?>][]' value="<?php echo $n['dose']; ?>"></td>
                                                <td><input type='text' name='nosocomial[<?php echo $n['numero']; ?>][]' value="<?php echo $n['frequencia']; ?>"></td>
                                                <td><input type='text' name='nosocomial[<?php echo $n['numero']; ?>][]' value="<?php echo $n['duracao']; ?>"></td>
                                            </tr>
                                            @endforeach
                                        @endif
                                    </tbody>
                                </table>
                                <!--  -->
                            
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="row">
                <div class="col-md-12">
                    <div class="card">
                        <div class="card-body">
                            <div class="card-body table-responsive p-0">

                                <!-- Prescrito -->
                                <label for="">Prescrito:</label><br>
                                <button class="btn btn-sm btn-default" id="addPresc-button">Inserir linha</button>
                                <table class="table table-hover">
                                    <thead>
                                        <tr>
                                            <th></th>
                                            <th>Medicação</th>
                                            <th>Via Administração</th>
                                            <th>Dose</th>
                                            <th>Frequência</th>
                                            <th>Duração</th>
                                        </tr>
                                    </thead>
                                    <tbody id="table-presc">
                                        @if (!empty($prescrito))
                                            @foreach ($prescrito as $n)
                                            <tr class='presc<?php echo $n['numero']; ?>' data-id="<?php echo $n['numero']; ?>">
                                                <td><a class="old_line" style="color:red" href="#" data-toggle="tooltip" title="Excluir linha!"><i class="fas fa-fw fa-trash"></i></a></td>
                                                <td><input type='text' name='prescrito[<?php echo $n['numero']; ?>][]' value="<?php echo $n['medicacao']; ?>"></td>
                                                <td><input type='text' name='prescrito[<?php echo $n['numero']; ?>][]' value="<?php echo $n['administracao']; ?>"></td>
                                                <td><input type='text' name='prescrito[<?php echo $n['numero']; ?>][]' value="<?php echo $n['dose']; ?>"></td>
                                                <td><input type='text' name='prescrito[<?php echo $n['numero']; ?>][]' value="<?php echo $n['frequencia']; ?>"></td>
                                                <td><input type='text' name='prescrito[<?php echo $n['numero']; ?>][]' value="<?php echo $n['duracao']; ?>"></td>
                                            </tr>
                                            @endforeach
                                        @endif
                                    </tbody>
                                </table>
                                <!--  -->
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="row">
                <div class="col-md-12">
                    <div class="card">
                        <div class="card-body">
                            <div class="form-group">
                                <label>Dados da Consulta <small>( dados, imagens, tabelas etc. )</small></label>
                                <textarea class="form-control simple_consult" rows="3" placeholder="Inserir aqui informações da Consulta e Fotos..." name="textarea_consult">{{ $consult['textarea_consult'] }}</textarea>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="card card-primary card-outline">
                <div class="card-body">
                    <h4>Informações de Retorno</h4>
                </div>
            </div>

            <div class="row">
                <div class="col-md p-2">
                    <div class="card">
                        <div class="card-body le-8">
                            <div class="form-group">

                                <label for="dt_retorno">Selecionar Data e Hora:</label>
                                <div class="row">
                                    
                                    <div class="col">
                                        <div class="row flex-column" style="cursor: pointer;" data-toggle="modal" data-target="#modal_calendar">
                                            <label for="">Data:</label>
                                            <div class="d-flex align-items-center" style="border: 1px solid #ccc; background-color: #e9ecef;">
                                                <input type="hidden" name="id_data_retorno" value="{{$consult['id_data_retorno']}}">
                                                <input type="hidden" name="data_retorno" id="data_retorno" value="{{$consult['data_retorno']}}">
                                                <input readonly style="border:0; cursor:pointer;" type="text" value="{{(!empty($dia_retorno))?date('d / m / Y', strtotime($dia_retorno)) : 'Selecionar data'}}" class="form-control" id="dt_retorno">
                                                <i class="fas fa-calendar-alt m-1" style="font-size:18px;"></i>
                                            </div>
                                            
                                        </div>
                                        <div class="row">
                                            <label for="">Hora:</label>
                                            <select title="Selecione a data para aparecer os horários disponíveis" class="form-control @error('hora_retorno') is-invalid @enderror" name="hora_retorno" id="hr_retorno">
                                                @if(!empty($hora_menor))
                                                <option value="{{$hora_menor}}">{{$hora_menor}}</option>
                                                @endif
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
                            
                        </div>
                    </div>
                </div>
                <div class="col-md p-2" id="local_end">
                    <div class="card">
                        <div class="card-body ld-8">

                            <div class="form-consulta-checkbox">
                                <label class="form-check-label">
                                    <input @empty(!$consult['retorno_coletar']) checked @endempty type="checkbox" name="retorno_coletar">Coletar
                                </label>
                            
                                <label class="form-check-label">
                                    <input @empty(!$consult['retorno_vacinar']) checked @endempty type="checkbox" name="retorno_vacinar">Vacinar
                                </label>
        
                                <label class="form-check-label">
                                    <input @empty(!$consult['retorno_reavaliar']) checked @endempty type="checkbox" name="retorno_reavaliar">Reavaliar
                                </label>
                            </div>
                            
                            <div class="form-group">
                                <label for="ret_obs">Obervações:</label>
                                <textarea type="text" class="form-control" id="ret_obs" name="retorno_obs">{{$consult['retorno_obs']}}</textarea>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="row">
                <div class="col-md p-2">
                    <div class="card">
                        <div class="card-body le-8">
                            <div class="form-group">
                            <div class="form-consulta-checkbox">
                                <label class="form-check-label">
                                    <input @if($consult['ap_status'] == 'Encerrada') checked @endif type="checkbox" name="status_encerrada">Mudar o Status da Consulta para Encerrada
                                </label>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            </div>

        </div>

        <div class="card-footer">
            <div class="form-group row">
                <div class="offset-sm col-sm-5 m-1">
                    <button type="submit" class="btn btn-info">Salvar</button>
                </div>
            </div>
        </div>




        </form>
    </div>
</section>


{{-- END PAGE CONTENT --}}

@endsection

@section('footer')
    @yield('footer', View::make('layouts.footer'))
@endsection

@section('js')
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery.form/4.2.2/jquery.form.min.js" integrity="sha384-FzT3vTVGXqf7wRfy8k4BiyzvbNfeYjK+frTVqZeNDFl8woCbF0CYG6g2fMEFFo/i" crossorigin="anonymous"></script>
<script src="{{asset('/assets/js/jquery.mask.min.js')}}"></script>
<script src="{{asset('/assets/js/script.js')}}"></script>
<script>

    $(function(){

        //Ativar Tooltips
        $('[data-toggle="tooltip"]').tooltip();

        //Aparecer menu quando página rola
        let nav = $('#aux-bar');
        if ($(window).scrollTop() < 60) {
            $('#aux-bar').hide();
        } else {
            $('#aux-bar').show();
        }

        $(window).scroll(function () {
            if ($(this).scrollTop() > 60) {
                $('#aux-bar').fadeIn('slow');
            } else {
                $('#aux-bar').fadeOut('slow');
            }
        });

        //Ajustar tamanho dos campos card-body
        for (let i = 1; i < 9; i++) {
            let height_le = $('.card-body.le-'+i).css('height');
            let height_ld = $('.card-body.ld-'+i).css('height');
            if (height_le > height_ld) {
                $('.card-body.ld-'+i).css('min-height', height_le);
            } else {
                $('.card-body.le-'+i).css('min-height', height_ld);
            }
        }

        // Tooltips
        $('[data-toggle="tooltip"]').tooltip({trigger: "hover"});

        // Botão de Salvamento rápido
        $('#form_consult').submit(function (e) {
            e.preventDefault();
            formSave($(this));
        });

        // Salvar Formulário com Ajax
        function formSave(data) {
            $.ajax({
                url:"{{ route( 'consult.update', ['consult' => $consult['id']] ) }}",
                type:"post",
                data: data.serialize(),
                success:function(res) {
                    $("#myModal").modal();
                    $("#myModal").on('hidden.bs.modal', function(){
                        location.reload();
                    });
                }
            });
        }

        // Mask - Formato de dados
        $('#peso').mask('#0,000', {reverse: true});

        // Ocultar aba Rins Palpáveis
        $('.rins_nao_palpados').on('click', function(){
            $('.palpaveis_nao_mostrar').toggle('slow');
            $('.palpaveis_selecao_nao_mostrar').hide('slow');
        });

        $('#palpaveis').on('click', function(e){
            e.preventDefault();
            $('.palpaveis_selecao').toggle('slow');
        });

        // Toggle 'slow'de Fichas do Formulário
        $('#mandibular').on('click', function(e){
            e.preventDefault();
            $('.mandibular_selecao').toggle('slow');
            $('.pre_escapular_selecao').hide('slow');
            $('.popliteo_selecao').hide('slow');
        });

        $('#pre_escapular').on('click', function(e){
            e.preventDefault();
            $('.mandibular_selecao').hide('slow');
            $('.pre_escapular_selecao').toggle('slow');
            $('.popliteo_selecao').hide('slow');
        });

        $('#popliteo').on('click', function(e){
            e.preventDefault();
            $('.mandibular_selecao').hide('slow');
            $('.pre_escapular_selecao').hide('slow');
            $('.popliteo_selecao').toggle('slow');
        });

        // Selecionar tipo de consulta
        $('#tipo').change(function () {
            $('.consulta_simples').show();
            $('.consulta_completa').hide();
        });
        $('#tipo2').change(function () {
            $('.consulta_completa').show();
            $('.consulta_simples').hide();
        });

        // Inclusão de linhas nas Fichas do Formulário
        $('#addNosoc-button').on('click', function(e){
            e.preventDefault();
            let html = "";
            //let r = Math.floor(Math.random() * 999) + 1;
            let r = new Date().getTime();
            
            if ($('.nosoc'+r).length == 0) {

                html += "<tr class='nosoc"+r+"'>";
                html += "<td><a class='new_line' style='color:red' href='#' data-toggle='tooltip' title='Excluir linha!' id='"+r+"'><i class='fas fa-fw fa-trash'></i></a></td>"
                html += "<td><input type='text' name='nosocomial["+r+"][]'></td>";
                html += "<td><input type='text' name='nosocomial["+r+"][]'></td>";
                html += "<td><input type='text' name='nosocomial["+r+"][]'></td>";
                html += "<td><input type='text' name='nosocomial["+r+"][]'></td>";
                html += "<td><input type='text' name='nosocomial["+r+"][]'></td>";
                html += "</tr>";
            }
            $('#table-nosoc').append(html);
            $('[data-toggle="tooltip"]').tooltip({trigger: "hover"});
            // Excluir Linha nova (Não Salva no BD)
            $('.new_line').click(function (e) {
                e.preventDefault();
                $('[data-toggle="tooltip"]').tooltip('hide');
                let linha = $(this).attr('id');
                $('.nosoc'+linha).remove();
            })
        });

        $('#addPresc-button').on('click', function(e){
            e.preventDefault();
            let html = "";
            //let r = Math.floor(Math.random() * 999) + 1;
            let r = new Date().getTime();

            if ($('.presc'+r).length == 0) {
                html += "<tr class='presc"+r+"'>";
                html += "<td><a class='new_line' style='color:red' href='#' data-toggle='tooltip' title='Excluir linha!' id='"+r+"'><i class='fas fa-fw fa-trash'></i></a></td>"
                html += "<td><input type='text' name='prescrito["+r+"][]'></td>";
                html += "<td><input type='text' name='prescrito["+r+"][]'></td>";
                html += "<td><input type='text' name='prescrito["+r+"][]'></td>";
                html += "<td><input type='text' name='prescrito["+r+"][]'></td>";
                html += "<td><input type='text' name='prescrito["+r+"][]'></td>";
                html += "</tr>";
            }
            $('#table-presc').append(html);
            $('[data-toggle="tooltip"]').tooltip({trigger: "hover"});
            // Excluir Linha nova (Não Salva no BD)
            $('.new_line').click(function (e) {
                e.preventDefault();
                $('[data-toggle="tooltip"]').tooltip('hide');
                let linha = $(this).attr('id');
                $('.presc'+linha).remove();
            })
        });

        // Excluir linha antiga (Já salva no BD)
        $('.old_line').click(function (e) {
            if (confirm('Confirma a exclusão da linha?')) {
                e.preventDefault();
                $('[data-toggle="tooltip"]').tooltip('hide');
                let linha = $(this).parent().parent().attr('class');
                $('.'+linha).remove();

                function soNumero(str) {
                    str = str.toString();
                    return str.replace(/\D/g, ``);
                }

                let number = soNumero(linha);
                let opcao = linha.substring(0,5);

                $.ajax({
                    url:"{{ route('delete_fichas') }}",
                    type:"get",
                    data: {number:number, ficha:opcao},
                    success:function(res) {
                        $('#form_consult').submit();
                    }
                });
            } else {
                return false;
            }
            
        })
        
    });
</script>

<script src="https://cdn.tiny.cloud/1/wt9fuwqo0mtch0lfna0f7aazeox5fyd9ak5io8sy97b28plf/tinymce/5/tinymce.min.js"></script>
<script>
    tinymce.init({
        selector:'textarea.simple_consult',
        language:'pt_BR',
        height:300,
        menubar:false,
        plugins:['link', 'table', 'image', 'autoresize', 'lists'],
        toolbar:'undo redo | formatselect | bold italic backcolor | alignleft aligncenter alignright alignjustify | table | link image | bullist numlist',
        content_css:[
            '{{asset('assets/css/content.css')}}'
        ],
        images_upload_url:'{{route('imageupload')}}',
        images_upload_credentials:true,
        convert_urls:false,
    });
</script>

@stop

@section('css')
    <link rel="stylesheet" href="{{asset('/assets/css/views.css')}}">
    <style>
        #table-nosoc,
        #table-presc {
            background-color: #EEE;
        }
        #table-nosoc input,
        #table-presc input {
            border: 1px solid #CCC;
            padding-left: 5px;
        }
        #table-nosoc i:hover,
        #table-presc i:hover {
            cursor: pointer;
        }
        label {
            margin-bottom: 0px;
        }
        .form-consulta-checkbox {
            border: 1px solid #ced4da;
            border-radius: 5px;
        }
        .form-consulta-checkbox input {
            margin-right: 5px;
        }
        .btn-aux-bar {
            min-width: 60px;
        }
        #aux-bar {
            background-color: rgba(0,0,0,0.8);
            max-height: 55px;
        }
        label.form-check-label {
            display: inline-flex;
            align-items: center;
        }
        #calendar_icon:hover {
            cursor: pointer;
            color: rgb(29, 29, 107);

        }
        .palpaveis_selecao {
            z-index: 1;
        }
    </style>
@stop