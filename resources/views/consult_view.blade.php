<?php 

if ($info_ficha_consulta['sexo'] == 'fem') {
    $sexo = 'Fêmea';
} else {
    $sexo = 'Macho';
}

switch ($info_ficha_consulta['ambiente']) {
    case 'ambiente_apartamento':
        $ambiente = 'Apartamento';
        break;
    case 'ambiente_casaOutdoor':
        $ambiente = 'Casa Outdoor';
        break;
    case 'ambiente_casaIndoor':
        $ambiente = 'Casa Indoor';
        break;
    default:
        $ambiente = ' ';
        break;
}

switch ($info_ficha_consulta['acesso_rua']) {
    case 'acesso_rua_sim':
        $acesso_rua = 'Sim';
        break;
    case 'acesso_rua_nao':
        $acesso_rua = 'Não';
        break;
    case 'acesso_rua_coleira':
        $acesso_rua = 'Passeio de Coleira';
        break;
    default:
        $acesso_rua = ' ';
        break;
}

switch ($info_ficha_consulta['contactantes']) {
    case 'contactantes_nenhum':
        $contactantes = 'Nenhum';
        break;
    case 'contactantes_gatos':
        $contactantes = 'Gatos';
        break;
    case 'contactantes_caes':
        $contactantes = 'Cães';
        break;
    case 'contactantes_outros':
        $contactantes = 'Outros';
        break;
    default:
        $contactantes = ' ';
        break;
}

switch ($info_ficha_consulta['integracao']) {
    case 'integração_amigavel':
        $integracao = 'Amigável';
        break;
    case 'integração_grupos':
        $integracao = 'Grupos';
        break;
    case 'integração_conflituoso':
        $integracao = 'Conflituoso';
        break;
    default:
        $integracao = ' ';
        break;
}

switch ($info_ficha_consulta['dieta_seca_rotina']) {
    case 'dieta_seca_rotina_ad_libidum':
        $rotina = 'Ad Libidum';
        break;
    case 'dieta_seca_rotina_fracionado':
        $rotina = 'Fracionado';
        break;
    default:
        $rotina = ' ';
        break;
}

switch ($info_ficha_consulta['dieta_pastosa']) {
    case 'dieta_pastosa_sem':
        $dieta_pastosa = 'Sem Interesse';
        break;
    case 'dieta_pastosa_medio':
        $dieta_pastosa = 'Médio Interesse';
        break;
    case 'dieta_pastosa_alto':
        $dieta_pastosa = 'Alto Interesse';
        break;
    default:
        $dieta_pastosa = ' ';
        break;
}

switch ($info_ficha_consulta['dieta_pastosa_frequencia']) {
    case 'dieta_pastosa_frequencia_diaria':
        $dieta_pastosa_frequencia = 'Diária';
        break;
    case 'dieta_pastosa_frequencia_quinzenal':
        $dieta_pastosa_frequencia = 'Quinzenal';
        break;
    case 'dieta_pastosa_frequencia_esporadica':
        $dieta_pastosa_frequencia = 'Esporádica';
        break;
    default:
        $dieta_pastosa_frequencia = ' ';
        break;
}

switch ($info_ficha_consulta['vacina']) {
    case 'vacina_v3':
        $vacina = 'V3';
        break;
    case 'vacina_v4':
        $vacina = 'V4';
        break;
    case 'vacina_v5':
        $vacina = 'V5';
        break;
    default:
        $vacina = ' ';
        break;
}

switch ($info_ficha_consulta['ar']) {
    case 'ar_emdia':
        $ar = 'Em Dia';
        break;
    case 'ar_atrasada':
        $ar = 'Atrasada';
        break;
    default:
        $ar = ' ';
        break;
}

if ($info_ficha_consulta['fiv_felv_naoTestado'] == 1) {
    $fiv_felv_naoTestado = 'X';
} else {
    $fiv_felv_naoTestado = '__';
}

if ($info_ficha_consulta['fiv_felv_fiv'] == 1) {
    $fiv_felv_fiv = 'X';
} else {
    $fiv_felv_fiv = '__';
}

if ($info_ficha_consulta['fiv_felv_felv'] == 1) {
    $fiv_felv_felv = 'X';
} else {
    $fiv_felv_felv = '__';
}

switch ($info_ficha_consulta['ar']) {
    case 'ar_emdia':
        $ar = 'Em Dia';
        break;
    case 'ar_atrasada':
        $ar = 'Atrasada';
        break;
    default:
        $ar = ' ';
        break;
}

if ($info_ficha_consulta['olhos_blefaroespasmo'] == 1) {
    $olhos_blefaroespasmo = 'X';
} else {
    $olhos_blefaroespasmo = '__';
}

if ($info_ficha_consulta['olhos_secrecao'] == 1) {
    $olhos_secrecao = 'X';
} else {
    $olhos_secrecao = '__';
}

switch ($info_ficha_consulta['olhos_secrecao_tipo']) {
    case 'olhos_secrecao_aquosa':
        $olhos_secrecao_tipo = 'Aquosa';
        break;
    case 'olhos_secrecao_mucosa':
        $olhos_secrecao_tipo = 'Mucosa';
        break;
    case 'olhos_secrecao_purolenta':
        $olhos_secrecao_tipo = 'Purolenta';
        break;
    default:
        $olhos_secrecao_tipo = ' ';
        break;
}

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.2.1/css/bootstrap.min.css" integrity="sha384-GJzZqFGwb1QTTN6wy59ffF1BuGJpLSa9DkKMp0DgiMDm4iYMj70gZWKYbI706tWS" crossorigin="anonymous">
    <title>{{$info_ficha_consulta->name}} - {{$company->trade_name}}</title>
    <style>
        .page-break {
            page-break-after: always;
        }
        label {
            font-weight: bold;
        }
    </style>
</head>
<body>

    <div class="container-fluid border p-3">

        <div class="jumbotron">
            <div style="text-align: center">
                <img width="100" style="border-radius: 50%;" src="{{asset('/assets/img/'.$company->url_logo)}}">
                <h1>{{$company->trade_name ?? $company->name}}</h1>
            </div>
        </div>

    </div>

    <div class="container">

        <a href="#" onclick="this.remove();window.print();prevent.default();" class="btn btn-info btn-sm my-3">Imprimir</a>

        <h2>Ficha de Consulta</h2><br>

            <div class='form-group'>
                <label for='data'>Consulta/Retorno:</label><br>
                {{$info_ficha_consulta['consulta']}}
            </div>

            <div class='form-group'>
                <label for='data'>Data:</label><br>
                {{ (!empty($info_ficha_consulta['data_consulta']))?date('d/m/Y', strtotime($info_ficha_consulta['data_consulta'])) : '__/__/__'}}
            </div>

            <div class='form-group'>
                <label for='nome'>Nome:</label><br>
                <a href="{{route('patient.show', ['patient' => $info_ficha_consulta['id_patient']])}}">{{$info_ficha_consulta['name']}}</a>
            </div>

            <div class='form-group'>
                <label for='peso'>Peso: </label><br>
                {{str_replace('.', ',', $info_ficha_consulta['peso'])}} Kg
            </div>
            
            <div class='form-group'>
                <label for='idade'>Idade: </label><br>
                {{$idade[0].' ano(s) e '.$idade[1].' mês(es)'}}
            </div>

            <div class='form-group'>
                <label for='sexo'>Sexo:</label><br>
                {{$sexo}}
            </div>

            <div class='form-group'>
                <label for='sexo'>Motivo da consulta:</label><br>
                {{$info_ficha_consulta['motivo']}}
            </div>

        @if ($info_ficha_consulta->tipo == 'completa')

            <hr>
            
            <h3>Anamnese</h3>

            <hr>

            <div class='form-group'>
                <label for='diagnostico'>Suspeita/Diagnóstico:</label><br>
                {{$info_ficha_consulta['diagnostico']}}
            </div>
            
            <div class='form-group'>
                <label for='anamnese'>Anamnese:</label><br>
                {{$info_ficha_consulta['anamnese']}}
            </div>

            <hr>

            <!-- Ambiente  -->
            <div class='form-group'>
                <label for='ambiente'>Ambiente:</label><br>
                {{$ambiente}}
            </div>

            <div class='form-group'>
                <label for='acesso_rua'>Acessso à rua:</label><br>
                {{$acesso_rua}}
            </div>
            <!--  -->

            <hr>

            <!-- Contactantes -->
            <div class='form-group'>
                <label for='contactantes'>Contactantes:</label><br>
                {{$contactantes}}
            </div>

            <div class='form-group'>
                <label for='contactantes_quant'>Contactantes - Quant:</label><br>
                {{$info_ficha_consulta['contactantes_quant']}}
            </div>

            <div class='form-group'>
                <label for='integracao'>Interação:</label><br>
                {{$integracao}}
            </div>
            <!--  -->

            <hr>

            <!-- Dieta Seca -->
            <div class='form-group'>
                <label for='dieta_seca'>Dieta Seca:</label><br>
                {{$info_ficha_consulta['dieta_seca']}}
            </div>

            <div class='form-group'>
                <label for='rotina'>Rotina:</label><br>
                {{$rotina}}
            </div>
            <!--  -->

            <hr>

            <!-- Dieta Pastosa -->
            <div class='form-group'>
                <label for='dieta_pastosa'>Dieta Pastosa:</label><br>
                {{$dieta_pastosa}}
            </div>

            <div class='form-group'>
                <label for='frequencia'>Frequência:</label><br>
                {{$dieta_pastosa_frequencia}}
            </div>
            <!--  -->

            <hr >

            <!-- Vacinação -->
            <div class='form-group'>
                <label for='vacina'>Vacinação:</label><br>
                {{$vacina}}
            </div>

            <div class='form-group'>
                <label for='vacina_data'>Vacinação - Data:</label><br>
                {{ (!empty($info_ficha_consulta['vacina_data']))?date('d/m/Y', strtotime($info_ficha_consulta['vacina_data'])) : '__/__/__'}}
            </div>
            <!--  -->

            <hr>

            <!-- A.R. -->
            <div class='form-group'>
                <label for='AR'>A.R.:</label><br>
                {{$ar}}
            </div>

            <div class='form-group'>
                <label for='ar_data'>A.R. - Data:</label><br>
                {{ (!empty($info_ficha_consulta['ar_data']))?date('d/m/Y', strtotime($info_ficha_consulta['ar_data'])) : '__/__/__'}}
            </div>
            <!--  -->

            <hr>

            <!-- Vermifugação -->
            <div class='form-group'>
                <label for='vermifugacao'>Vermifugação:</label><br>
                {{$info_ficha_consulta['vermifugacao']}}
            </div>

            <div class='form-group'>
                <label for='verm_data'>Vermifugação - Data:</label><br>
                {{ (!empty($info_ficha_consulta['vermifugacao_data']))?date('d/m/Y', strtotime($info_ficha_consulta['vermifugacao_data'])) : '__/__/__'}}
            </div>
            <!--  -->

            <hr>

            <!-- FIV / FeLV -->
            <strong><u>FIV / FeLV:</u><br></strong><br>
            <div class='form-consulta-checkbox'>

                <label class='form-check-label'>
                    ( {{$fiv_felv_naoTestado}} - Não testado ) 
                </label><br>
            
                <label class='form-check-label'>
                    ( {{$fiv_felv_fiv}} - FIV ) 
                </label><br>
            
                <label class='form-check-label'>
                    ( {{$fiv_felv_felv}} - FeLV ) 
                </label><br>

            </div>
            <!--  -->

            <hr>

            <!-- Olhos -->
            <strong><u>Olhos:</u><br></strong><br>
            <div class='form-consulta-checkbox'>

                <label class='form-check-label'>
                    ( {{$olhos_blefaroespasmo}} - Blefaroespasmo ) 
                </label><br>
            
                <label class='form-check-label'>
                    ( {{$olhos_secrecao}} - Secreção ) 
                </label><br>

            </div>

            <div class='form-group' id='form-group-secrecao'>
                <label>Secreção:</label><br>
                {{$olhos_secrecao_tipo}}
            </div>
            <!--  -->

            <hr>

            <!-- Orelhas -->
            <strong><u>Orelhas:</u><br></strong><br>
            <div class='form-consulta-checkbox'>
            
            <?php 

            if ($info_ficha_consulta['orelhas_prurido'] == 1) {
                $orelhas_prurido = 'X';
            } else {
                $orelhas_prurido = '__';
            }

            if ($info_ficha_consulta['orelhas_secrecao'] == 1) {
                $orelhas_secrecao = 'X';
            } else {
                $orelhas_secrecao = '__';
            }

            switch ($info_ficha_consulta['orelhas_secrecao_tipo']) {
                case 'orelhas_secrecao_cerumen':
                    $orelhas_secrecao_tipo = 'Cerúmen';
                    break;
                case 'orelhas_secrecao_escura':
                    $orelhas_secrecao_tipo = 'Escura';
                    break;
                case 'orelhas_secrecao_ressecada':
                    $orelhas_secrecao_tipo = 'Ressecada';
                    break;
                
                default:
                    $orelhas_secrecao_tipo = ' ';
                    break;
            }

            ?>

            <label class='form-check-label'>
                    ( {{$orelhas_prurido}} - Prurido )
                </label><br>

                <label class='form-check-label'>
                    ( {{$orelhas_secrecao}} - Secreção )
                </label><br>

            </div>

            <div class='form-group' id='form-group-secrecao'>
                <label>Secreção:</label><br>
                {{$orelhas_secrecao_tipo}}
            </div>
            <!--  -->

            <hr>

            <?php 

            if ($info_ficha_consulta['pele_feridas'] == 1) {
                $pele_feridas = 'X';
            } else {
                $pele_feridas = '__';
            }

            if ($info_ficha_consulta['pele_prurido'] == 1) {
                $pele_prurido = 'X';
            } else {
                $pele_prurido = '__';
            }

            if ($info_ficha_consulta['pele_nodulos'] == 1) {
                $pele_nodulos = 'X';
            } else {
                $pele_nodulos = '__';
            }

            if ($info_ficha_consulta['pele_falha'] == 1) {
                $pele_falha = 'X';
            } else {
                $pele_falha = '__';
            }

            if ($info_ficha_consulta['pele_ecto'] == 1) {
                $pele_ecto = 'X';
            } else {
                $pele_ecto = '__';
            }

            ?>

            <!-- Pele -->
            <strong><u>Pele:</u><br></strong><br>
            <div class='form-consulta-checkbox'>
                <label class='form-check-label'>
                    ( {{$pele_feridas}} - Feridas )
                </label><br>
            
                <label class='form-check-label'>
                    ( {{$pele_prurido}} - Prurido )
                </label><br>
            
            
                <label class='form-check-label'>
                    ( {{$pele_nodulos}}- Nódulos )
                </label><br>
            
            
                <label class='form-check-label'>
                    ( {{$pele_falha}} - Falha de Pêlo )
                </label><br>
            
            
                <label class='form-check-label'>
                    ( {{$pele_ecto}} - Ectoparasitas )
                </label><br>
            </div>
            <!--  -->

            <hr>
            
            <!-- Respiratório -->
            <strong><u>Respiratório:</u><br></strong><br>
            <div class='form-consulta-checkbox'>
                <label class='form-check-label'>
                    ( {{(($info_ficha_consulta['respiratorio_dispneia'] == 1)?'X':'__')}} - Dispneia )
                </label><br>
            
                <label class='form-check-label'>
                    ( {{(($info_ficha_consulta['respiratorio_tosses'] == 1)?'X':'__')}} - Tosses )
                </label><br>

                <label class='form-check-label'>
                    ( {{(($info_ficha_consulta['respiratorio_espirros'] == 1)?'X':'__')}} - Espirros )
                </label><br>
            </div>

            <div class='form-group'>
                <label for='esp_freq'>Frequência:</label><br>
                {{$info_ficha_consulta['respiratorio_frequencia']}}
            </div>

            <div class='form-group' id='form-group-secrecao'>
                <label>Secreção Nasal:</label><br>
                {{(

                    ($info_ficha_consulta['secrecao_nasal'] == 'secrecao_nasal_aquosa')?'Aquosa':
                    (($info_ficha_consulta['secrecao_nasal'] == 'secrecao_nasal_mucosa')?'Mucosa':
                    (($info_ficha_consulta['secrecao_nasal'] == 'secrecao_nasal_purolenta')?'Purolenta':
                    ' '))

                )}}
            </div>
            <!--  -->

            <hr>
            
            <!-- Castração -->
            <strong><u>Castração:</u><br></strong><br>
            <div class='form-consulta-checkbox'>
                <label class='form-check-label'>
                    ( {{(($info_ficha_consulta['castracao_castrado'] == 1)?'X':'__')}} - Castrado )
                </label><br>
            
                <label class='form-check-label'>
                    ( {{(($info_ficha_consulta['castracao_inteiro'] == 1)?'X':'__')}} - Inteiro ) 
                </label><br>

                <label class='form-check-label'>
                    ( {{(($info_ficha_consulta['castracao_criptorquida'] == 1)?'X':'__')}} - Criptorquida )
                </label><br>
            </div>
            <!--  -->

            <hr>

            <!-- Atividade -->
            <strong><u>Atividade:</u><br></strong><br>
            <div class='form-consulta-checkbox'>
                <label class='form-check-label'>
                    ( {{(($info_ficha_consulta['atitude_normal'] == 1)?'X':'__')}} - Normal )
                </label><br>
            
                <label class='form-check-label'>
                    ( {{(($info_ficha_consulta['atitude_dimin'] == 1)?'X':'__')}} - Diminuida )
                </label><br>

                <label class='form-check-label'>
                    ( {{(($info_ficha_consulta['atitude_apatia'] == 1)?'X':'__')}} - Apatia )
                </label><br>

                <label class='form-check-label'>
                    ( {{(($info_ficha_consulta['atitude_agitado'] == 1)?'X':'__')}} - Agitado )
                </label><br>

                <label class='form-check-label'>
                    ( {{(($info_ficha_consulta['atitude_entediado'] == 1)?'X':'__')}} - Entediado )
                </label><br>
            </div>
            <!--  -->

            <hr>

            <!-- Apetite -->
            <div class='form-group'>
                <label for='apetite'>Apetite:</label><br>
                {{(

                    ($info_ficha_consulta['apetite'] == 'apetite_normal')?'Normal':
                    (($info_ficha_consulta['apetite'] == 'apetite_caprichoso')?'Caprichoso':
                    (($info_ficha_consulta['apetite'] == 'apetite_aumentado')?'Aumentado':
                    ' '))

                )}}
            </div>
            <!--  -->

            <hr>

            <!-- Mastigação -->
            <div class='form-group'>
                <label for='mastigacao'>Mastigação:</label><br>
                {{(

                    ($info_ficha_consulta['mastigacao'] == 'mastigacao_normal')?'Normal':
                    (($info_ficha_consulta['mastigacao'] == 'mastigacao_dificuldade')?'Dificuldade':
                    (($info_ficha_consulta['mastigacao'] == 'mastigacao_rapido')?'Rápido':
                    ' '))

                )}}
            </div>
            <!--  -->

            <hr>

            <!-- Vômito -->
            <div class='form-group'>
                <label for='vomito'>Vômito:</label><br>
                {{(

                    ($info_ficha_consulta['vomito'] == 'vomito_nega')?'Nega':
                    (($info_ficha_consulta['vomito'] == 'vomito_frequente')?'Frequente':
                    (($info_ficha_consulta['vomito'] == 'vomito_ocasional')?'Ocasional':
                    (($info_ficha_consulta['vomito'] == 'vomito_esporadico')?'Esporádico':
                    ' ')))

                )}}
            </div>

            <div class='form-group'>
                <label for='vomito_conteudo'>Conteúdo:</label><br>
                {{(

                    ($info_ficha_consulta['vomito_conteudo'] == 'vomito_liquido')?'Líquido/Saliva':
                    (($info_ficha_consulta['vomito_conteudo'] == 'vomito_racao')?'Ração':
                    (($info_ficha_consulta['vomito_conteudo'] == 'vomito_pelos')?'Bola de pelos':
                    (($info_ficha_consulta['vomito_conteudo'] == 'vomito_outros')?'Outros':
                    ' ')))

                )}}
            </div>
            <!--  -->

            <hr>

            <!-- Ingestão Hídrica -->
            <div class='form-group'>
                <label for='ingestao_hidrica'>Ingestão Hídrica:</label><br>
                {{(

                    ($info_ficha_consulta['ingestao_hidrica'] == 'ingestao_hidrica_normal')?'Normal':
                    (($info_ficha_consulta['ingestao_hidrica'] == 'ingestao_hidrica_diminuida')?'Diminuída':
                    (($info_ficha_consulta['ingestao_hidrica'] == 'ingestao_hidrica_aumentada')?'Aumentada':
                    ' '))

                )}}
            </div>
            <!--  -->

            <hr>

            <!-- Fezes -->
            <div class='form-group'>
                <label for='fezes'>Fezes:</label><br>
                {{(

                    ($info_ficha_consulta['fezes'] == 'fezes_normal')?'Normal':
                    (($info_ficha_consulta['fezes'] == 'fezes_pastosa')?'Pastosas':
                    (($info_ficha_consulta['fezes'] == 'fezes_diarreica')?'Diarreicas':
                    (($info_ficha_consulta['fezes'] == 'fezes_ressecada')?'Ressecadas':
                    ' ')))

                )}}
            </div>

            <div class='form-group'>
                <label for='fez_freq'>Frequência:</label><br>
                {{$info_ficha_consulta['fezes_frequencia']}}
            </div>
            <!--  -->

            <hr>

            <!-- Escore Corporal -->
            <div class='form-group'>
                <label for='escore_corporal'>Escore Corporal:</label><br>
                {{(

                    ($info_ficha_consulta['escore_corporal'] == 'escore_corporal_caquetico')?'Caquético':
                    (($info_ficha_consulta['escore_corporal'] == 'escore_corporal_magro')?'Magro':
                    (($info_ficha_consulta['escore_corporal'] == 'escore_corporal_normal')?'Normal':
                    (($info_ficha_consulta['escore_corporal'] == 'escore_corporal_obeso')?'Obeso':
                    ' ')))

                )}}
            </div>

            <hr>

            <div class='form-group'>
                <label for='nivel_consciencia'>Nível de Consciência:</label><br>
                {{(

                    ($info_ficha_consulta['nivel_consciencia'] == 'nivel_consciencia_normal')?'Normal':
                    (($info_ficha_consulta['nivel_consciencia'] == 'nivel_consciencia_apatico')?'Apático':
                    (($info_ficha_consulta['nivel_consciencia'] == 'nivel_consciencia_comatoso')?'Comatoso':
                    (($info_ficha_consulta['nivel_consciencia'] == 'nivel_consciencia_excitado')?'Excitado':
                    ' ')))

                )}}
            </div>
            <!--  -->

            <hr>

            <!-- Urina -->
            <strong><u>Urina:</u><br></strong><br>
            <div class='form-consulta-checkbox'>
                <label class='form-check-label'>
                    ( {{(($info_ficha_consulta['urina_normal'] == 1)?'X':'__')}} - Normal )
                </label><br>
            
                <label class='form-check-label'>
                    ( {{(($info_ficha_consulta['urina_periuria'] == 1)?'X':'__')}} - Periúria ) 
                </label><br>

                <label class='form-check-label'>
                    ( {{(($info_ficha_consulta['urina_aumentada'] == 1)?'X':'__')}} - Aumentada ) 
                </label><br>

                <label class='form-check-label'>
                    ( {{(($info_ficha_consulta['urina_diminuida'] == 1)?'X':'__')}} - Diminuída ) 
                </label><br>

                <label class='form-check-label'>
                    ( {{(($info_ficha_consulta['urina_estranguria'] == 1)?'X':'__')}} - Estrangúria ) 
                </label><br>
            </div>

            <div class='form-group'>
                <label for='urina_frequencia'>Frequência:</label><br>
                {{$info_ficha_consulta['urina_frequencia']}}
            </div>
            <!--  -->

            <hr>

            <!-- Atitude -->
            <strong><u>Atitude:</u><br></strong><br>
            <div class='form-consulta-checkbox'>
                <label class='form-check-label'>
                    ( {{(($info_ficha_consulta['atitude_docil'] == 1)?'X':'__')}} - Dócil ) 
                </label><br>

                <label class='form-check-label'>
                    ( {{(($info_ficha_consulta['atitude_desconfiado'] == 1)?'X':'__')}} - Desconfiado ) 
                </label><br>

                <label class='form-check-label'>
                    ( {{(($info_ficha_consulta['atitude_medroso'] == 1)?'X':'__')}} - Medroso ) 
                </label><br>

                <label class='form-check-label'>
                    ( {{(($info_ficha_consulta['atitude_agressivo'] == 1)?'X':'__')}} - Agressivo ) 
                </label><br>

                <label class='form-check-label'>
                    ( {{(($info_ficha_consulta['atitude_arredio'] == 1)?'X':'__')}} - Arredio ) 
                </label><br>
            </div>
            <!--  -->

            <hr>

            <h3>Exame Físico</h3>

            <hr>

            <!-- Avaliação Ocular -->
            <strong><u>Avaliação Ocular:</u><br></strong><br>
            <div class='form-consulta-checkbox'>
                <label class='form-check-label'>
                    ( {{(($info_ficha_consulta['avaliacao_ocular_normal'] == 1)?'X':'__')}} - Normal ) 
                </label><br>

                <div class='form-group'>
                    <label for='avaliacao_ocular_secrecao'>Secreção:</label><br>
                {{(

                    ($info_ficha_consulta['avaliacao_ocular_secrecao'] == 'avaliacao_ocular_secrecao_aquosa')?'Aquosa':
                    (($info_ficha_consulta['avaliacao_ocular_secrecao'] == 'avaliacao_ocular_secrecao_mucosa')?'Mucosa':
                    (($info_ficha_consulta['avaliacao_ocular_secrecao'] == 'avaliacao_ocular_secrecao_purulenta')?'Purulenta':
                    ' '))

                )}}
                </div>

                <div class='form-group'>
                    <label for='avaliacao_ocular_esclera'>Esclera:</label><br>
                {{(

                    ($info_ficha_consulta['avaliacao_ocular_esclera'] == 'avaliacao_ocular_esclera_congestao')?'Congestão':''
                )}}
                </div>

                <div class='form-group'>
                    <label for='avaliacao_ocular_cornea'>Córnea:</label><br>
                {{(

                    ($info_ficha_consulta['avaliacao_ocular_cornea'] == 'avaliacao_ocular_cornea_opacidade')?'Opacidade':
                    (($info_ficha_consulta['avaliacao_ocular_cornea'] == 'avaliacao_ocular_cornea_neovasos')?'Neovasos':
                    ' ')

                )}}
                </div>

                <div class='form-group'>
                    <label for='avaliacao_ocular_lente'>Lente:</label><br>
                {{(

                    ($info_ficha_consulta['avaliacao_ocular_lente'] == 'avaliacao_ocular_lente_opacidade')?'Opacidade':''
                )}}
                </div>

                <div class='form-group'>
                    <label for='avaliacao_ocular_conjuntiva'>Conjuntiva:</label><br>
                {{(

                    ($info_ficha_consulta['avaliacao_ocular_conjuntiva'] == 'avaliacao_ocular_conjuntiva_quemose')?'Quemose':''
                )}}
                </div>
            </div>
            <!--  -->

            <hr>

            <!-- Mucosas -->
            <strong><u>Mucosas:</u><br></strong><br>
            <div class='form-consulta-checkbox'>
                <label class='form-check-label'>
                    ( {{(($info_ficha_consulta['mucosas_normais'] == 1)?'X':'__')}} - Normais )
                </label><br>
            
                <label class='form-check-label'>
                    ( {{(($info_ficha_consulta['mucosas_palidas'] == 1)?'X':'__')}} - Pálidas ) 
                </label><br>

                <label class='form-check-label'>
                    ( {{(($info_ficha_consulta['mucosas_icterias'] == 1)?'X':'__')}} - Ictérias ) 
                </label><br>

                <label class='form-check-label'>
                    ( {{(($info_ficha_consulta['mucosas_congestas'] == 1)?'X':'__')}} - Congestas ) 
                </label><br>

                <label class='form-check-label'>
                    ( {{(($info_ficha_consulta['mucosas_cianoticas'] == 1)?'X':'__')}} - Cianóticas ) 
                </label><br>
            </div>
            <!--  -->

            <hr>

            <!-- FR / FC -->
            <div>

                <div>
                    <div class='form-group'>
                        <label for='fr'>FR: <small>(em mpm)</small></label><br>
                        {{$info_ficha_consulta['fr']}}
                    </div>
                </div>

                <div>
                    <div class='form-group'>
                        <label for='fc'>FC: <small>(em bpm)</small></label><br>
                        {{$info_ficha_consulta['fc']}}
                    </div>
                </div>

            </div>
            <!--  -->

            <hr>

            <!-- Movimento Respiratório -->
            <strong><u>Movimento Respiratório:</u><br></strong><br>
            <div class='form-consulta-checkbox'>
                <label class='form-check-label'>
                    ( {{(($info_ficha_consulta['movimento_respiratorio_normal'] == 1)?'X':'__')}} - Normal ) 
                </label><br>
            
                <div class='form-group'>
                    <label for='disp'>Dispinéia:</label><br>
                {{(

                    ($info_ficha_consulta['dispineia'] == 'movimento_respiratorio_oral')?'Respiração Oral':
                    (($info_ficha_consulta['dispineia'] == 'movimento_respiratorio_ortopneia')?'Ortopneia':
                    ' ')

                )}}
                </div>
            </div>
            <!--  -->

            <hr>

            <!-- Orelhas -->
            <strong><u>Orelhas:</u><br></strong><br>
            <div class='form-consulta-checkbox'>
                <label class='form-check-label'>
                    ( {{(($info_ficha_consulta['orelhas_normal'] == 1)?'X':'__')}} - Normal ) 
                </label><br>
            
                <div class='form-group'>
                    <label for='exfis_orelhas_secrecao'>Secreção:</label><br>
                {{(

                    ($info_ficha_consulta['exfis_orelhas_secrecao'] == 'exfis_orelhas_secrecao_cerumen')?'Cerúmen':
                    (($info_ficha_consulta['exfis_orelhas_secrecao'] == 'exfis_orelhas_secrecao_enegrecida')?'Enegrecida':
                    ' ')

                )}}
                </div>
            </div>
            <!--  -->

            <hr>

            <!-- Linfonodos -->
            <strong><u>Linfonodos:</u><br></strong><br>
            <div class='form-consulta'>
                
                <ul class='list-group'>
                    <ul class='list-group-item list-group-item'>

                        <div class='list-group'>
                            <a href='' id='mandibular' class='list-group-item list-group-item-action'>Mandibular</a>
                        </div>

                        <div class='mandibular_selecao' style='display: block;'>
                            <ul class='list-group-item list-group-item'>
                                <div class='form-group'>
                                    <label for='linfonodo_mandibular_direito'>Direito:</label><br>
                                    {{(

                                        ($info_ficha_consulta['linfonodo_mandibular_direito'] == 'linfonodo_mandibular_direito_normal')?'Normal':
                                        (($info_ficha_consulta['linfonodo_mandibular_direito'] == 'linfonodo_mandibular_direito_aumentado')?'Aumentado':
                                        ' ')

                                    )}}<br>
                                    <label for='linfonodo_mandibular_direito_detalhes'>Detalhes:</label><br>
                                    {{$info_ficha_consulta['linfonodo_mandibular_direito_detalhes']}}
                                </div>
                            </ul>

                            <ul class='list-group-item list-group-item'>
                                <div class='form-group'>
                                    <label for='linfonodo_mandibular_esquerdo'>Esquerdo:</label><br>
                                    {{(

                                        ($info_ficha_consulta['linfonodo_mandibular_esquerdo'] == 'linfonodo_mandibular_esquerdo_normal')?'Normal':
                                        (($info_ficha_consulta['linfonodo_mandibular_esquerdo'] == 'linfonodo_mandibular_esquerdo_aumentado')?'Aumentado':
                                        ' ')

                                    )}}<br>
                                    <label for='linfonodo_mandibular_esquerdo_detalhes'>Detalhes:</label><br>
                                    {{$info_ficha_consulta['linfonodo_mandibular_esquerdo_detalhes']}}
                                </div>
                            </ul>
                        </div>

                        <hr>

                        <div class='list-group'>
                            <a href='' id='pre_escapular' class='list-group-item list-group-item-action'>Pré-escapular</a>
                        </div>

                        <div class='pre_escapular_selecao' style='display: block;'>
                            <ul class='list-group-item list-group-item'>
                                <div class='form-group'>
                                    <label for='linfonodo_pre_escapular_direito'>Direito:</label><br>
                                    {{(

                                        ($info_ficha_consulta['linfonodo_pre_escapular_direito'] == 'linfonodo_pre_escapular_direito_normal')?'Normal':
                                        (($info_ficha_consulta['linfonodo_pre_escapular_direito'] == 'linfonodo_pre_escapular_direito_aumentado')?'Aumentado':
                                        ' ')

                                    )}}<br>
                                    <label for='linfonodo_pre_escapular_direito_detalhes'>Detalhes:</label><br>
                                    {{$info_ficha_consulta['linfonodo_pre_escapular_direito_detalhes']}}
                                </div>
                            </ul>

                            <ul class='list-group-item list-group-item'>
                                <div class='form-group'>
                                    <label for='linfonodo_pre_escapular_esquerdo'>Esquerdo:</label><br>
                                    {{(

                                        ($info_ficha_consulta['linfonodo_pre_escapular_esquerdo'] == 'linfonodo_pre_escapular_esquerdo_normal')?'Normal':
                                        (($info_ficha_consulta['linfonodo_pre_escapular_esquerdo'] == 'linfonodo_pre_escapular_esquerdo_aumentado')?'Aumentado':
                                        ' ')

                                    )}}<br>
                                    <label for='linfonodo_pre_escapular_esquerdo_detalhes'>Detalhes:</label><br>
                                    {{$info_ficha_consulta['linfonodo_pre_escapular_esquerdo_detalhes']}}
                                </div>
                            </ul>
                        </div>

                        <hr>

                        <div class='list-group'>
                            <a href='' id='popliteo' class='list-group-item list-group-item-action'>Poplíteo</a>
                        </div>

                        <div class='popliteo_selecao' style='display: block;'>
                            <ul class='list-group-item list-group-item'>
                                <div class='form-group'>
                                    <label for='linfonodo_popliteo_direito'>Direito:</label><br>
                                    {{(

                                        ($info_ficha_consulta['linfonodo_popliteo_direito'] == 'linfonodo_popliteo_direito_normal')?'Normal':
                                        (($info_ficha_consulta['linfonodo_popliteo_direito'] == 'linfonodo_popliteo_direito_aumentado')?'Aumentado':
                                        ' ')

                                    )}}<br>
                                    <label for='linfonodo_popliteo_direito_detalhes'>Detalhes:</label><br>
                                    {{$info_ficha_consulta['linfonodo_popliteo_direito_detalhes']}}
                                </div>
                            </ul>

                            <ul class='list-group-item list-group-item'>
                                <div class='form-group'>
                                    <label for='linfonodo_popliteo_esquerdo'>Esquerdo:</label><br>
                                    {{(

                                        ($info_ficha_consulta['linfonodo_popliteo_esquerdo'] == 'linfonodo_popliteo_esquerdo_normal')?'Normal':
                                        (($info_ficha_consulta['linfonodo_popliteo_esquerdo'] == 'linfonodo_popliteo_esquerdo_aumentado')?'Aumentado':
                                        ' ')

                                    )}}<br>
                                    <label for='linfonodo_popliteo_esquerdo_detalhes'>Detalhes:</label><br>
                                    {{$info_ficha_consulta['linfonodo_popliteo_esquerdo_detalhes']}}
                                </div>
                            </ul>
                        </div>

                    </ul>
                </ul>

            </div>
            <!--  -->

            <hr>
            
            <!-- Tranporte -->
            <strong><u>Transporte:</u><br></strong><br>
            <div class='form-consulta-checkbox'>
                <label class='form-check-label'>
                    ( {{(($info_ficha_consulta['transporte_urina'] == 1)?'X':'__')}} - Urina ) 
                </label><br>
            
                <label class='form-check-label'>
                    ( {{(($info_ficha_consulta['transporte_vomito'] == 1)?'X':'__')}} - Vômito ) 
                </label><br>

                <label class='form-check-label'>
                    ( {{(($info_ficha_consulta['transporte_fezes'] == 1)?'X':'__')}} - Fezes ) 
                </label><br>
            </div>
            <!--  -->

            <hr>

            <!-- Hidratação -->
            <div class='form-group'>
                <label for='hidratacao'>Hidratação:</label><br>
                {{(

                    ($info_ficha_consulta['hidratacao'] == 'hidratacao_normal')?'Normal':
                    (($info_ficha_consulta['hidratacao'] == 'hidratacao_discreta')?'Discreta 5%':
                    (($info_ficha_consulta['hidratacao'] == 'hidratacao_leve')?'Leve 6 a 8%':
                    (($info_ficha_consulta['hidratacao'] == 'hidratacao_moderada')?'Moderada 9 a 10%':
                    (($info_ficha_consulta['hidratacao'] == 'hidratacao_grave')?'Grave > 10%':
                    ' '))))

                )}}
            </div>
            <!--  -->

            <hr>

            <!-- Bulhas -->
            <strong><u>Bulhas:</u><br></strong><br>
            <div class='form-consulta-checkbox'>
                <label class='form-check-label'>
                    ( {{(($info_ficha_consulta['bulhas_regulares'] == 1)?'X':'__')}} - Regulares ) 
                </label><br>
            
                <label class='form-check-label'>
                    ( {{(($info_ficha_consulta['bulhas_irregulares'] == 1)?'X':'__')}} - Irregulares ) 
                </label><br>

                <label class='form-check-label'>
                    ( {{(($info_ficha_consulta['bulhas_normofoneticas'] == 1)?'X':'__')}} - Normofonéticas ) 
                </label><br>

                <label class='form-check-label'>
                    ( {{(($info_ficha_consulta['bulhas_hipofoneticas'] == 1)?'X':'__')}} - Hipofonéticas ) 
                </label><br>
            </div>
            <!--  -->

            <hr>

            <!-- Sopro -->
            <div class='form-group'>
                <label for='sopro'>Sopro:</label><br>
                {{(

                    ($info_ficha_consulta['sopro'] == 'sopro_sim')?'Sim':
                    (($info_ficha_consulta['sopro'] == 'sopro_nao')?'Não':
                    ' ')

                )}}
            </div>

            <div class='form-group'>
                <label for='sopro_detalhes'>Detalhes:</label><br>
                {{$info_ficha_consulta['sopro_detalhes']}}
            </div>
            <!--  -->

            <hr>

            <!-- Visícula Urinária -->
            <div class='form-group'>
                <label for='visicula_urinaria'>Visícula Urinária:</label><br>
                {{(

                    ($info_ficha_consulta['visicula_urinaria'] == 'visicula_urinaria_vazia')?'Vazia':
                    (($info_ficha_consulta['visicula_urinaria'] == 'visicula_urinaria_palpavel')?'Palpável':
                    (($info_ficha_consulta['visicula_urinaria'] == 'visicula_urinaria_repleta')?'Repleta':
                    (($info_ficha_consulta['visicula_urinaria'] == 'visicula_urinaria_obtruida')?'Obstruída':
                    ' ')))

                )}}
            </div>
            <!--  -->

            <hr>

            <!-- Palpação abd. Alças Intestinais -->
            <div class='form-group'>
                <label for='alca_intest'>Palpação abd. Alças Intestinais:</label><br>
                {{(

                    ($info_ficha_consulta['alca_intest'] == 'alca_intest_vazia')?'Vazia':
                    (($info_ficha_consulta['alca_intest'] == 'alca_intest_pastoso')?'Conteúdo Pastoso':
                    (($info_ficha_consulta['alca_intest'] == 'alca_intest_macio')?'Conteúdo Macio':
                    (($info_ficha_consulta['alca_intest'] == 'alca_intest_firme')?'Conteúdo Firme':
                    ' ')))

                )}}
            </div>
            <!--  -->

            <hr>

            <!-- Rins -->
            <strong><u>Rins:</u><br></strong><br>

            <div class='form-consulta'>
                
                <ul class='list-group'>
                    <ul class='list-group-item list-group-item'>

                        <div class='list-group'>

                            <div class='form-consulta-checkbox'>
                                <label class='form-check-label'>
                                    ( {{(($info_ficha_consulta['rins_nao_palpados'] == 1)?'X':'__')}} - Não Palpados )
                                </label><br>
                            </div>

                        </div>

                        <hr>

                        <div class='list-group'>
                            <a href='' id='palpaveis' class='list-group-item list-group-item-action'>
                                Palpáveis
                            </a>
                        </div>

                        <div class='palpaveis_selecao' style='display: block;'>
                            <ul class='list-group-item list-group-item'>
                                <div class='form-group'>
                                    <label for='rim_palpaveis_direito'>Direito:</label><br>
                                    {{(

                                        ($info_ficha_consulta['rim_palpaveis_direito'] == 'rim_palpaveis_direito_normal')?'Normal':
                                        (($info_ficha_consulta['rim_palpaveis_direito'] == 'rim_palpaveis_direito_aumentado')?'Aumentado':
                                        ' ')

                                    )}}<br>
                                    <label for='rim_palpaveis_direito_detalhes'>Detalhes:</label><br>
                                    {{$info_ficha_consulta['rim_palpaveis_direito_detalhes']}}
                                </div>
                            </ul>

                            <ul class='list-group-item list-group-item'>
                                <div class='form-group'>
                                    <label for='rim_palpaveis_esquerdo'>Esquerdo:</label><br>
                                    {{(

                                        ($info_ficha_consulta['rim_palpaveis_esquerdo'] == 'rim_palpaveis_esquerdo_normal')?'Normal':
                                        (($info_ficha_consulta['rim_palpaveis_esquerdo'] == 'rim_palpaveis_esquerdo_aumentado')?'Aumentado':
                                        ' ')

                                    )}}<br>
                                    <label for='rim_palpaveis_esquerdo_detalhes'>Detalhes:</label><br>
                                    {{$info_ficha_consulta['rim_palpaveis_esquerdo_detalhes']}}
                                </div>
                            </ul>
                        </div>

                    </ul>
                </ul>

            </div>
            <!--  -->

            <hr>

            <!-- Outras Alterações -->
            <strong><u>Outras Alterações:</u><br></strong><br>
            <div class='form-consulta-checkbox'>
                <label class='form-check-label'>
                    ( {{(($info_ficha_consulta['outras_alteracoes_gases'] == 1)?'X':'__')}} - Gases ) 
                </label><br>
            
                <label class='form-check-label'>
                    ( {{(($info_ficha_consulta['outras_alteracoes_abdomen_abaulado'] == 1)?'X':'__')}} - Abdômen abaulado ) 
                </label><br>

                <label class='form-check-label'>
                    ( {{(($info_ficha_consulta['outras_alteracoes_abdomen_tenso'] == 1)?'X':'__')}} - Abdômen tenso ) 
                </label><br>
            </div>
            <!--  -->

            <hr>

            <!-- Temperatura -->
            <div class='form-group'>
                <label for='temperatura'>Temperatura: <small>(°C)</small></label><br>
                {{$info_ficha_consulta['temperatura']}}
            </div>

            <div class='form-group'>
                <label for='tpc'>TPC: <small>(segundos)</small></label><br>
                {{$info_ficha_consulta['tpc']}}
            </div>
            <!--  -->

            <hr>

            <!-- Secreção Nasal -->
            <div class='form-group'>
                <label for='sececao_nasal'>Secreção Nasal:</label><br>
                {{(

                    ($info_ficha_consulta['sececao_nasal'] == 'sececao_nasal_nenhuma')?'Nenhuma':
                    (($info_ficha_consulta['sececao_nasal'] == 'sececao_nasal_aquosa')?'Aquosa':
                    (($info_ficha_consulta['sececao_nasal'] == 'sececao_nasal_mucosa')?'Mucosa':
                    (($info_ficha_consulta['sececao_nasal'] == 'sececao_nasal_purulenta')?'Purulenta':
                    ' ')))

                )}}
            </div>
            <!--  -->

            <hr>

            <!-- PAS -->
            <strong><u>PAS:</u><br></strong><br>

            <div class='form-group'>
                <label for='pas_mmhg'>mmHg:</label><br>
                {{$info_ficha_consulta['pas_mmhg']}}
            </div>

            <div class='form-group'>
                <label for='pas_hash'>#:</label><br>
                {{$info_ficha_consulta['pas_hash']}}
            </div>

            <div class='form-consulta-checkbox'>
                <label class='form-check-label'>
                    ( {{(($info_ficha_consulta['pas_mpd'] == 1)?'X':'__')}} - MP D ) 
                </label><br>
            
                <label class='form-check-label'>
                    ( {{(($info_ficha_consulta['pas_mpe'] == 1)?'X':'__')}} - MP E ) 
                </label><br>

                <label class='form-check-label'>
                    ( {{(($info_ficha_consulta['pas_mtd'] == 1)?'X':'__')}} - MT D ) 
                </label><br>

                <label class='form-check-label'>
                    ( {{(($info_ficha_consulta['pas_mte'] == 1)?'X':'__')}} - MT E ) 
                </label><br>
            </div>

            <div class='form-group'>
                <label for='pas_posicao'>Posição:</label><br>
                {{(

                    ($info_ficha_consulta['pas_posicao'] == 'pas_posicao_deitado')?'Deitado':
                    (($info_ficha_consulta['pas_posicao'] == 'pas_posicao_sentado')?'Sentado':
                    (($info_ficha_consulta['pas_posicao'] == 'pas_posicao_colo')?'colo':
                    ' '))

                )}}
            </div>
            <!--  -->

            <hr>

            <!-- Glicemia -->
            <div class='form-group'>
                <label for='glicemia'>Glicemia: <small>(mg/dL)</label><br>
                {{$info_ficha_consulta['glicemia']}}
            </div>
            <!--  -->

            <hr>

            <!-- Ausculta Pulmonar -->
            <div class='form-group'>
                <label for='ausculta_pulmonar'>Ausculta Pulmonar:</label><br>
                {{(

                    ($info_ficha_consulta['ausculta_pulmonar'] == 'ausculta_pulmonar_normal')?'Normal':
                    (($info_ficha_consulta['ausculta_pulmonar'] == 'ausculta_pulmonar_sibilos')?'Sibilos':
                    (($info_ficha_consulta['ausculta_pulmonar'] == 'ausculta_pulmonar_crepitacao')?'Crepitação':
                    (($info_ficha_consulta['ausculta_pulmonar'] == 'ausculta_pulmonar_ronco')?'Ronco':
                    ' ')))

                )}}
            </div>

            <div class='form-group'>
                <label for='ausculta_traqueal'>Ausculta Traqueal:</label><br>
                {{(

                    ($info_ficha_consulta['ausculta_traqueal'] == 'ausculta_traqueal_normal')?'Normal':
                    (($info_ficha_consulta['ausculta_traqueal'] == 'ausculta_traqueal_sibilos')?'Sibilos':
                    (($info_ficha_consulta['ausculta_traqueal'] == 'ausculta_traqueal_ronco')?'Ronco':
                    ' '))

                )}}
            </div>
            <!--  -->

        @endif

            <hr>

            <!-- Exames Solicitados -->
                <strong><u>Exames Solicitados:</u><br></strong><br>

                @foreach ($exams as $e)
                    @if(in_array($e['id'], explode(',', $info_ficha_consulta['exames_solicitados_outros']))) 
                        {{$e['name']}}, 
                    @endif
                @endforeach

            <hr>

            @if (!empty($nosocomial))
                
                <!-- Nosocomial -->
                <strong><u>Nosocomial:</u><br></strong><br>
                
                <table class='table'>
                    <thead>
                        <tr>
                            <th>Medicação</th>
                            <th>Via Administração</th>
                            <th>Dose</th>
                            <th>Frequência</th>
                            <th>Duração</th>
                        </tr>
                    </thead>
                    <tbody id='table-nosoc'>

                        @foreach ($nosocomial as $n)
                            <tr>
                                <td>{{$n['medicacao']}}</td>
                                <td>{{$n['administracao']}}</td>
                                <td>{{$n['dose']}}</td>
                                <td>{{$n['frequencia']}}</td>
                                <td>{{$n['duracao']}}</td>
                            </tr>
                        @endforeach

                </tbody>
                </table>
                <!--  -->

                <hr>

            @endif

            @if (!empty($prescrito))

                <!-- prescrito -->
                <strong><u>Prescrito:</u><br></strong><br>
                
                <table class='table'>
                    <thead>
                        <tr>
                            <th>Medicação</th>
                            <th>Via Administração</th>
                            <th>Dose</th>
                            <th>Frequência</th>
                            <th>Duração</th>
                        </tr>
                    </thead>
                    <tbody id='table-nosoc'>

                        @foreach ($prescrito as $n)
                            <tr>
                                <td>{{$n['medicacao']}}</td>
                                <td>{{$n['administracao']}}</td>
                                <td>{{$n['dose']}}</td>
                                <td>{{$n['frequencia']}}</td>
                                <td>{{$n['duracao']}}</td>
                            </tr>
                        @endforeach
                
                </tbody>
                </table>
                <!--  -->

                <hr>

            @endif

            <div class="form-group">
                <label>Dados da Consulta</label><br>{!! $info_ficha_consulta['textarea_consult'] !!}
            </div>

            <hr>

            <!-- Retorno -->
            <strong><u>Retorno:</u><br></strong><br>

            <div class='form-group'>
                <label for='dt_retorno'>Data:</label><br>
                {{ (!empty($info_ficha_consulta['data_retorno']))?date('d/m/Y', strtotime($info_ficha_consulta['data_retorno'])) : '__/__/__'}}
            </div>

            <div class='form-consulta-checkbox'>
                <label class='form-check-label'>
                    ( {{(($info_ficha_consulta['retorno_coletar'] == 1)?'X':'__')}} - Coletar ) 
                </label><br>
            
                <label class='form-check-label'>
                    ( {{(($info_ficha_consulta['retorno_vacinar'] == 1)?'X':'__')}} - Vacinar ) 
                </label><br>

                <label class='form-check-label'>
                    ( {{(($info_ficha_consulta['retorno_reavaliar'] == 1)?'X':'__')}} - Reavaliar ) 
                </label><br>
            </div>

            <div class='form-group'>
                <label for='ret_obs'>Obervações:</label><br>
                {{$info_ficha_consulta['retorno_obs']}}
            </div>
            <!--  -->

    </div>
    
</body>
</html>
