<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Veterinary_appointment;
use App\Veterinary_appointments_nosocomial;
use App\Veterinary_appointments_prescrito;
use App\Veterinary_exam;
use App\Veterinary_patient;
use App\System_company;
use App\Veterinary_dates_booked;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Response;
use PDF;

class ConsultController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
        $this->middleware('can:menu-consultas');
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        if (!empty($_GET['status'])) {
            $status = $_GET['status'];
        } else {
            $status = 'Andamento';
        }

        $consult = '';
        if (!empty($_GET['consult'])) {
            $consult = addslashes($_GET['consult']);
        }

        $ini_date = date('Y-m-d', strtotime('-29 days'));
        $fin_date = date('Y-m-d', strtotime('+29 days'));
        if (!empty($_GET['ini_date'])) {
            $ini_date = addslashes($_GET['ini_date']);
            $fin_date = addslashes($_GET['fin_date']);
        }
        $list = array();
        $patients = Veterinary_patient::where('name', 'LIKE', '%'.$consult.'%')
        ->get('id');
        foreach ($patients as $p ) {
            $list[] = $p['id'];
        }

        //DB::enableQueryLog();

        $consults = Veterinary_appointment::select('*', 
        DB::raw("(SELECT name FROM veterinary_patients WHERE veterinary_patients.id = veterinary_appointments.id_patient) as patient_name"))
        ->whereBetween('data_consulta', [date('Y-m-d', strtotime($ini_date)), date('Y-m-d', strtotime($fin_date.'+1 days'))])
        ->where('ap_status', $status)
        ->where('id_company', Auth::user()->id_company)
        ->where('inactive', 0)
        ->whereIn('id_patient', $list)
        ->orderBy('patient_name', 'DESC')
        ->orderBy('data_consulta', 'DESC')
        ->paginate(10);

        //dd(DB::getQueryLog());
        
        return view('consult', [
            'consults' => $consults,
            'ini_date' => $ini_date,
            'fin_date' => $fin_date,
        ]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {   
        $exams = Veterinary_exam::where('id_company', Auth::user()->id_company)
        ->where('inactive', 0)
        ->orderBy('name')
        ->get();
        return view('consult_create', [
            'exams' => $exams
        ]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $data = $request->only([
            'id_patient',
            'tipo',
            'consulta',
            'data_consulta',
            'peso', 
            'sexo',
            'motivo',
        ]);

        $validator = Validator::make($data, [
            'id_patient' => ['required'],
            'tipo' => ['required'],
            'consulta' => ['required'],
            'data_consulta' => ['required'],
            'peso' => [], 
            'sexo' => [],
            'motivo' => [],
        ]);

        if ($validator->fails()) {
            $validator->errors()->add('warning', 'Paciente não cadastrado!');
            return redirect()->route('consult.create')->withErrors($validator)->withInput();
        } 

        $get_birthdate = Veterinary_patient::where('id', $data['id_patient'])->get('date_birth')->first();
        $get_age = new PatientController;
        $age = $get_age->get_age($get_birthdate['date_birth']);
        $data['idade'] = implode(',', $age);

        $consult = new Veterinary_appointment;
        $consult->id_company = Auth::user()->id_company;
        $consult->id_patient = ($data['id_patient']);
        $consult->tipo = ($data['tipo']);
		$consult->consulta = ($data['consulta']);
		$consult->data_consulta = ($data['data_consulta']); 
		$consult->peso = str_replace(',', '.', $data['peso']); 
		$consult->idade = ($data['idade']);  
        $consult->sexo = ($data['sexo']); 
        $consult->motivo = $data['motivo'];
        $consult->ap_status = 'Nova';
        $consult->save();
        $id_consult = $consult->id;

        return redirect()->route('consult.edit', [ 'consult' => $id_consult ]);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $info_ficha_consulta = Veterinary_appointment::select('*', (DB::raw("(SELECT name FROM veterinary_patients WHERE veterinary_patients.id = veterinary_appointments.id_patient) as name, (SELECT date_birth FROM veterinary_patients WHERE veterinary_patients.id = veterinary_appointments.id_patient) as date_birth, (SELECT id FROM veterinary_patients WHERE veterinary_patients.id = veterinary_appointments.id_patient) as id_patient")))
        ->where('id', $id)
        ->where('id_company', Auth::user()->id_company)
        ->where('inactive', 0)
        ->first();

        $exams = Veterinary_exam::where('id_company', Auth::user()->id_company)
        ->where('inactive', 0)
        ->get();
        
        $nosocomial = Veterinary_appointments_nosocomial::where('id_company', Auth::user()->id_company)
        ->whereIn('id', explode(',', $info_ficha_consulta['nosocomial_ficha_id']))->get();
        $prescrito = Veterinary_appointments_prescrito::where('id_company', Auth::user()->id_company)
        ->whereIn('id', explode(',', $info_ficha_consulta['prescrito_ficha_id']))->get();

        $company = System_company::where('id', Auth::user()->id_company)->first();

        $idade = explode(',', $info_ficha_consulta['idade']);

        return view('consult_view', [
            'info_ficha_consulta' => $info_ficha_consulta, 
            'company' => $company, 
            'exams' => $exams, 
            'nosocomial' => $nosocomial, 
            'prescrito' => $prescrito, 
            'idade' => $idade
        ]);

        // $pdf = PDF::loadView('consult_view', compact('info_ficha_consulta', 'company', 'exams', 'nosocomial', 'prescrito', 'idade'))
        // ->setPaper('a4')
        // ->stream('consult_view.pdf');

        // return $pdf;
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $consult = Veterinary_appointment::select('*', 
        (DB::raw("
        (SELECT name FROM veterinary_patients WHERE veterinary_patients.id = veterinary_appointments.id_patient) as name, 
        (SELECT id_client FROM veterinary_patients WHERE veterinary_patients.id = veterinary_appointments.id_patient) as id_this_client,
        (SELECT name FROM veterinary_clients WHERE veterinary_clients.id = id_this_client) as tutor,
        (SELECT id FROM veterinary_dates_bookeds WHERE veterinary_dates_bookeds.data_consulta = veterinary_appointments.data_retorno) as id_data_retorno
        ")))
        ->where('id', $id)
        ->where('id_company', Auth::user()->id_company)
        ->first();

        $exams = Veterinary_exam::where('id_company', Auth::user()->id_company)
        ->where('inactive', 0)
        ->orderBy('name')
        ->get();
        
        $nosocomial = Veterinary_appointments_nosocomial::where('id_company', Auth::user()->id_company)
        ->whereIn('id', explode(',', $consult['nosocomial_ficha_id']))
        ->orderBy('id')
        ->get();
        $prescrito = Veterinary_appointments_prescrito::where('id_company', Auth::user()->id_company)
        ->whereIn('id', explode(',', $consult['prescrito_ficha_id']))
        ->orderBy('id')
        ->get();

        if (!empty($consult->data_retorno)) {
            $data_retorno = explode(' ', $consult->data_retorno);
            $dia_retorno = $data_retorno[0];
            $hora_retorno = explode(':', $data_retorno[1]);
            $hora_menor = $hora_retorno[0].':'.$hora_retorno[1];
        } else {
            $dia_retorno = '';
            $hora_menor = '';
        }

        return view('consult_edit', [
            'consult' => $consult,
            'exams' => $exams,
            'nosocomial' => $nosocomial,
            'prescrito' => $prescrito,
            'dia_retorno' => $dia_retorno,
            'hora_menor' => $hora_menor,
        ]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $data = $request->only([
            'id_data_retorno',
            'id_consult',
            'id_patient',
            'id_client',
            'tutor',
            'name',
            'tipo',
            'consulta',
            'data_consulta',
            'peso', 
            'sexo',
            'diagnostico',
            'anamnese',
            'ambiente',
            'acesso_rua',
            'contactantes',
            'contactantes_quant',
            'integracao',
            'dieta_seca',
            'dieta_seca_rotina',
            'dieta_pastosa',
            'dieta_pastosa_frequencia',
            'vacina',
            'vacina_data',
            'ar',
            'ar_data',
            'vermifugacao',
            'vermifugacao_data',
            'fiv_felv_negativo',
            'fiv_felv_naoTestado',
            'fiv_felv_fiv',
            'fiv_felv_felv',
            'olhos_blefaroespasmo',
            'olhos_secrecao',
            'olhos_secrecao_tipo',
            'orelhas_prurido',
            'orelhas_secrecao',
            'orelhas_secrecao_tipo',
            'pele_feridas',
            'pele_prurido',
            'pele_nodulos',
            'pele_falha',
            'pele_ecto',
            'respiratorio_dispneia',
            'respiratorio_tosses',
            'respiratorio_espirros',
            'respiratorio_frequencia',
            'secrecao_nasal',
            'castracao_castrado',
            'castracao_inteiro',
            'castracao_criptorquida',
            'atitude_normal',
            'atitude_dimin',
            'atitude_apatia',
            'atitude_agitado',
            'atitude_entediado',
            'apetite',
            'mastigacao',
            'vomito',
            'vomito_conteudo',
            'ingestao_hidrica',
            'fezes',
            'fezes_frequencia',
            'escore_corporal',
            'nivel_consciencia',
            'urina_normal',
            'urina_periuria',
            'urina_aumentada',
            'urina_diminuida',
            'urina_estranguria',
            'urina_frequencia',
            'atitude_docil',
            'atitude_desconfiado',
            'atitude_medroso',
            'atitude_agressivo',
            'atitude_arredio',
            'avaliacao_ocular_normal',
            'avaliacao_ocular_secrecao',
            'avaliacao_ocular_esclera',
            'avaliacao_ocular_cornea',
            'avaliacao_ocular_lente',
            'avaliacao_ocular_conjuntiva',
            'mucosas_normais',
            'mucosas_palidas',
            'mucosas_icterias',
            'mucosas_congestas',
            'mucosas_cianoticas',
            'fr',
            'fc',
            'movimento_respiratorio_normal',
            'dispineia',
            'orelhas_normal',
            'exfis_orelhas_secrecao',
            'linfonodo_mandibular_direito',
            'linfonodo_mandibular_direito_detalhes',
            'linfonodo_mandibular_esquerdo',
            'linfonodo_mandibular_esquerdo_detalhes',
            'linfonodo_pre_escapular_direito',
            'linfonodo_pre_escapular_direito_detalhes',
            'linfonodo_pre_escapular_esquerdo',
            'linfonodo_pre_escapular_esquerdo_detalhes',
            'linfonodo_popliteo_direito',
            'linfonodo_popliteo_direito_detalhes',
            'linfonodo_popliteo_esquerdo',
            'linfonodo_popliteo_esquerdo_detalhes',
            'transporte_urina',
            'transporte_vomito',
            'transporte_fezes',
            'hidratacao',
            'bulhas_regulares',
            'bulhas_irregulares',
            'bulhas_normofoneticas',
            'bulhas_hipofoneticas',
            'sopro',
            'sopro_detalhes',
            'visicula_urinaria',
            'alca_intest',
            'rins_nao_palpados',
            'rim_palpaveis_direito',
            'rim_palpaveis_direito_detalhes',
            'rim_palpaveis_esquerdo',
            'rim_palpaveis_esquerdo_detalhes',
            'outras_alteracoes_gases',
            'outras_alteracoes_abdomen_abaulado',
            'outras_alteracoes_abdomen_tenso',
            'temperatura',
            'tpc',
            'sececao_nasal',
            'pas_mmhg',
            'pas_hash',
            'pas_mpd',
            'pas_mpe',
            'pas_mtd',
            'pas_mte',
            'pas_posicao',
            'glicemia',
            'ausculta_pulmonar',
            'ausculta_traqueal',
            'exames_solicitados_outros',
            'nosocomial',
            'prescrito',
            'data_retorno',
            'hora_retorno',
            'retorno_coletar',
            'retorno_vacinar',
            'retorno_reavaliar',
            'retorno_obs',
            'id_consultations_hours',
            'motivo',
            'textarea_consult',
            'finished',
            'status_encerrada'
        ]);
        
        $validator = $this->validator($data);

        if ($validator->fails()) {
            $validator->errors()->add('warning', 'Paciente não cadastrado!');
            return redirect()->route('consult.create')->withErrors($validator)->withInput();
        } 
        
        $data['exames_solicitados_outros'] = (!empty($data['exames_solicitados_outros']) ? implode(',', $data['exames_solicitados_outros']) : '');

        $nosocomial = (!empty($data['nosocomial']))?$data['nosocomial']:array();
        $prescrito = (!empty($data['prescrito']))?$data['prescrito']:array();
        
        $nosocomial_ficha_id = array();
        $prescrito_ficha_id = array();
                    
        // Nosocomial ids das fichas Novas Incluídas
        foreach ($nosocomial as $key => $value) {
            if (!empty($value[0])) {
                $nr = $key;
                $med = $value[0];
                $adm = $value[1];
                $dose = $value[2];
                $freq = $value[3];
                $dur = $value[4];
                
                if(Veterinary_appointments_nosocomial::where('numero', $nr)->first() != null) {
                    $addNosocomial = Veterinary_appointments_nosocomial::where('numero', $nr)->first();
                } else {
                    $addNosocomial = new Veterinary_appointments_nosocomial;
                    $addNosocomial->id_company = Auth::user()->id_company;
                    $addNosocomial->numero = $nr;
                }
                $addNosocomial->medicacao = $med;
                $addNosocomial->administracao = $adm;
                $addNosocomial->dose = $dose;
                $addNosocomial->frequencia = $freq;
                $addNosocomial->duracao = $dur;
                $addNosocomial->save();
                $nosocomial_ficha_id[] = $addNosocomial->id;
            } else {
                $nr = $key;
                Veterinary_appointments_nosocomial::where('numero', $nr)->delete();
            }
        }

        $data['nosocomial_ficha_id'] = implode(',', $nosocomial_ficha_id);
        
        // Prescrito ids das fichas Novas Incluídas
        foreach ($prescrito as $key => $value) {
            if (!empty($value[0])) {
                $nr = $key;
                $med = $value[0];
                $adm = $value[1];
                $dose = $value[2];
                $freq = $value[3];
                $dur = $value[4];

                if(Veterinary_appointments_prescrito::where('numero', $nr)->first() != null) {
                    $addPrescrito = Veterinary_appointments_prescrito::where('numero', $nr)->first();
                } else {
                    $addPrescrito = new Veterinary_appointments_prescrito;
                    $addPrescrito->id_company = Auth::user()->id_company;
                    $addPrescrito->numero = $nr;
                }
                $addPrescrito->medicacao = $med;
                $addPrescrito->administracao = $adm;
                $addPrescrito->dose = $dose;
                $addPrescrito->frequencia = $freq;
                $addPrescrito->duracao = $dur;
                $addPrescrito->save();
                $prescrito_ficha_id[] = $addPrescrito->id;
            } else {
                $nr = $key;
                Veterinary_appointments_prescrito::where('numero', $nr)->delete();
            }
        }

        $data['prescrito_ficha_id'] = implode(',', $prescrito_ficha_id);

        $get_birthdate = Veterinary_patient::where('id', $data['id_patient'])->get('date_birth')->first();
        $get_age = new PatientController;
        $age = $get_age->get_age($get_birthdate['date_birth']);
        $data['idade'] = implode(',', $age);

        //Marcar Retorno
        if (!empty($data['data_retorno'])) {

            $retorno = Veterinary_dates_booked::find($data['id_data_retorno']);

            if (empty($retorno)) {

                $retorno = new Veterinary_dates_booked;
                $retorno->id_company = Auth::user()->id_company;
                $retorno->id_client = $data['id_client'];
                $retorno->id_patient = $data['id_patient'];
                $retorno->consulta_retorno = 'retorno';

            }

            $retorno->data_consulta = $data['data_retorno'];
            
            if (isset($data['retorno_coletar'])) {
                $retorno_coletar = 'Coletar. ';
            } else {
                $retorno_coletar = '';
            }
            if (isset($data['retorno_vacinar'])) {
                $retorno_vacinar = 'Vacinar. ';
            } else {
                $retorno_vacinar = '';
            }
            if (isset($data['retorno_reavaliar'])) {
                $retorno_reavaliar = 'Reavaliar. ';
            } else {
                $retorno_reavaliar = '';
            }

            $retorno->motivo  = $retorno_coletar.$retorno_vacinar.$retorno_reavaliar.$data['retorno_obs'];
            $retorno->save();
        }
        
        // Salvar Consulta
        $consult = Veterinary_appointment::find($id);
        $consult->tipo = ($data['tipo']);
		$consult->consulta = ($data['consulta']);
		$consult->data_consulta = ($data['data_consulta']); 
		$consult->peso = str_replace(',', '.', $data['peso']); 
		$consult->idade = ($data['idade']);  
		$consult->sexo = ($data['sexo']); 
		$consult->diagnostico = ($data['diagnostico']);
		$consult->anamnese = ($data['anamnese']);
		$consult->ambiente = ($data['ambiente']);
		$consult->acesso_rua = ($data['acesso_rua']);
		$consult->contactantes = ($data['contactantes']);
		$consult->contactantes_quant = ($data['contactantes_quant']);
		$consult->integracao = ($data['integracao']);
		$consult->dieta_seca = ($data['dieta_seca']);
		$consult->dieta_seca_rotina = ($data['dieta_seca_rotina']);
		$consult->dieta_pastosa = ($data['dieta_pastosa']);
		$consult->dieta_pastosa_frequencia = ($data['dieta_pastosa_frequencia']);
		$consult->vacina = ($data['vacina']);
		$consult->vacina_data = ($data['vacina_data']);
		$consult->ar = ($data['ar']);
		$consult->ar_data = ($data['ar_data']);
		$consult->vermifugacao = ($data['vermifugacao']);
		$consult->vermifugacao_data = ($data['vermifugacao_data']);
		$consult->fiv_felv_negativo = isset($data['fiv_felv_negativo']);
		$consult->fiv_felv_naoTestado = isset($data['fiv_felv_naoTestado']);
		$consult->fiv_felv_fiv = isset($data['fiv_felv_fiv']);
		$consult->fiv_felv_felv = isset($data['fiv_felv_felv']);
		$consult->olhos_blefaroespasmo = isset($data['olhos_blefaroespasmo']);
		$consult->olhos_secrecao = isset($data['olhos_secrecao']);
		$consult->olhos_secrecao_tipo = ($data['olhos_secrecao_tipo']);
		$consult->orelhas_prurido = isset($data['orelhas_prurido']);
		$consult->orelhas_secrecao = isset($data['orelhas_secrecao']);
		$consult->orelhas_secrecao_tipo = ($data['orelhas_secrecao_tipo']);
		$consult->pele_feridas = isset($data['pele_feridas']);
		$consult->pele_prurido = isset($data['pele_prurido']);
		$consult->pele_nodulos = isset($data['pele_nodulos']);
		$consult->pele_falha = isset($data['pele_falha']);
		$consult->pele_ecto = isset($data['pele_ecto']);
		$consult->respiratorio_dispneia = isset($data['respiratorio_dispneia']);
		$consult->respiratorio_tosses = isset($data['respiratorio_tosses']);
		$consult->respiratorio_espirros = isset($data['respiratorio_espirros']);
		$consult->respiratorio_frequencia = ($data['respiratorio_frequencia']);
		$consult->secrecao_nasal = ($data['secrecao_nasal']);
		$consult->castracao_castrado = isset($data['castracao_castrado']);
		$consult->castracao_inteiro = isset($data['castracao_inteiro']);
		$consult->castracao_criptorquida = isset($data['castracao_criptorquida']);
		$consult->atitude_normal = isset($data['atitude_normal']);
		$consult->atitude_dimin = isset($data['atitude_dimin']);
        $consult->atitude_apatia = isset($data['atitude_apatia']);
		$consult->atitude_agitado = isset($data['atitude_agitado']);
		$consult->atitude_entediado = isset($data['atitude_entediado']);
		$consult->apetite = ($data['apetite']);
		$consult->mastigacao = ($data['mastigacao']);
		$consult->vomito = ($data['vomito']);
		$consult->vomito_conteudo = ($data['vomito_conteudo']);
		$consult->ingestao_hidrica = ($data['ingestao_hidrica']);
		$consult->fezes = ($data['fezes']);
		$consult->fezes_frequencia = ($data['fezes_frequencia']);
		$consult->escore_corporal = ($data['escore_corporal']);
		$consult->nivel_consciencia = ($data['nivel_consciencia']);
		$consult->urina_normal = isset($data['urina_normal']);
		$consult->urina_periuria = isset($data['urina_periuria']);
		$consult->urina_aumentada = isset($data['urina_aumentada']);
		$consult->urina_diminuida = isset($data['urina_diminuida']);
		$consult->urina_estranguria = isset($data['urina_estranguria']);
		$consult->urina_frequencia = ($data['urina_frequencia']);
		$consult->atitude_docil = isset($data['atitude_docil']);
		$consult->atitude_desconfiado = isset($data['atitude_desconfiado']);
		$consult->atitude_medroso = isset($data['atitude_medroso']);
		$consult->atitude_agressivo = isset($data['atitude_agressivo']);
		$consult->atitude_arredio = isset($data['atitude_arredio']);
		$consult->avaliacao_ocular_normal = isset($data['avaliacao_ocular_normal']);
		$consult->avaliacao_ocular_secrecao = ($data['avaliacao_ocular_secrecao']);
		$consult->avaliacao_ocular_esclera = ($data['avaliacao_ocular_esclera']);
		$consult->avaliacao_ocular_cornea = ($data['avaliacao_ocular_cornea']);
		$consult->avaliacao_ocular_lente = ($data['avaliacao_ocular_lente']);
		$consult->avaliacao_ocular_conjuntiva = ($data['avaliacao_ocular_conjuntiva']);
		$consult->mucosas_normais = isset($data['mucosas_normais']);
		$consult->mucosas_palidas = isset($data['mucosas_palidas']);
		$consult->mucosas_icterias = isset($data['mucosas_icterias']);
		$consult->mucosas_congestas = isset($data['mucosas_congestas']);
		$consult->mucosas_cianoticas = isset($data['mucosas_cianoticas']);
		$consult->fr = ($data['fr']);
		$consult->fc = ($data['fc']);
		$consult->movimento_respiratorio_normal = isset($data['movimento_respiratorio_normal']);
		$consult->dispineia = ($data['dispineia']);
		$consult->orelhas_normal = isset($data['orelhas_normal']);
		$consult->exfis_orelhas_secrecao = ($data['exfis_orelhas_secrecao']);
		$consult->linfonodo_mandibular_direito = ($data['linfonodo_mandibular_direito']);
		$consult->linfonodo_mandibular_direito_detalhes = ($data['linfonodo_mandibular_direito_detalhes']);
		$consult->linfonodo_mandibular_esquerdo = ($data['linfonodo_mandibular_esquerdo']);
		$consult->linfonodo_mandibular_esquerdo_detalhes = ($data['linfonodo_mandibular_esquerdo_detalhes']);
		$consult->linfonodo_pre_escapular_direito = ($data['linfonodo_pre_escapular_direito']);
		$consult->linfonodo_pre_escapular_direito_detalhes = ($data['linfonodo_pre_escapular_direito_detalhes']);
		$consult->linfonodo_pre_escapular_esquerdo = ($data['linfonodo_pre_escapular_esquerdo']);
		$consult->linfonodo_pre_escapular_esquerdo_detalhes = ($data['linfonodo_pre_escapular_esquerdo_detalhes']);
		$consult->linfonodo_popliteo_direito = ($data['linfonodo_popliteo_direito']);
		$consult->linfonodo_popliteo_direito_detalhes = ($data['linfonodo_popliteo_direito_detalhes']);
		$consult->linfonodo_popliteo_esquerdo = ($data['linfonodo_popliteo_esquerdo']);
		$consult->linfonodo_popliteo_esquerdo_detalhes = ($data['linfonodo_popliteo_esquerdo_detalhes']);
		$consult->transporte_urina = isset($data['transporte_urina']);
		$consult->transporte_vomito = isset($data['transporte_vomito']);
		$consult->transporte_fezes = isset($data['transporte_fezes']);
		$consult->hidratacao = ($data['hidratacao']);
		$consult->bulhas_regulares = isset($data['bulhas_regulares']);
		$consult->bulhas_irregulares = isset($data['bulhas_irregulares']);
		$consult->bulhas_normofoneticas = isset($data['bulhas_normofoneticas']);
		$consult->bulhas_hipofoneticas = isset($data['bulhas_hipofoneticas']);
		$consult->sopro = ($data['sopro']);
		$consult->sopro_detalhes = ($data['sopro_detalhes']);
		$consult->visicula_urinaria = ($data['visicula_urinaria']);
		$consult->alca_intest = ($data['alca_intest']);
		$consult->rins_nao_palpados = isset($data['rins_nao_palpados']);
		$consult->rim_palpaveis_direito = ($data['rim_palpaveis_direito']);
		$consult->rim_palpaveis_direito_detalhes = ($data['rim_palpaveis_direito_detalhes']);
		$consult->rim_palpaveis_esquerdo = ($data['rim_palpaveis_esquerdo']);
		$consult->rim_palpaveis_esquerdo_detalhes = ($data['rim_palpaveis_esquerdo_detalhes']);
		$consult->outras_alteracoes_gases = isset($data['outras_alteracoes_gases']);
		$consult->outras_alteracoes_abdomen_abaulado = isset($data['outras_alteracoes_abdomen_abaulado']);
		$consult->outras_alteracoes_abdomen_tenso = isset($data['outras_alteracoes_abdomen_tenso']);
		$consult->temperatura = ($data['temperatura']);
		$consult->tpc = ($data['tpc']);
		$consult->sececao_nasal = ($data['sececao_nasal']);
		$consult->pas_mmhg = ($data['pas_mmhg']);
		$consult->pas_hash = ($data['pas_hash']);
		$consult->pas_mpd = isset($data['pas_mpd']);
		$consult->pas_mpe = isset($data['pas_mpe']);
		$consult->pas_mtd = isset($data['pas_mtd']);
		$consult->pas_mte = isset($data['pas_mte']);
		$consult->pas_posicao = ($data['pas_posicao']);
		$consult->glicemia = ($data['glicemia']);
		$consult->ausculta_pulmonar = ($data['ausculta_pulmonar']);
		$consult->ausculta_traqueal = ($data['ausculta_traqueal']);
		$consult->exames_solicitados_outros = $data['exames_solicitados_outros'];
		$consult->nosocomial_ficha_id = ($data['nosocomial_ficha_id']);
		$consult->prescrito_ficha_id = ($data['prescrito_ficha_id']);
		$consult->data_retorno = ($data['data_retorno']);
		$consult->retorno_coletar = isset($data['retorno_coletar']);
		$consult->retorno_vacinar = isset($data['retorno_vacinar']);
		$consult->retorno_reavaliar = isset($data['retorno_reavaliar']);
		$consult->retorno_obs = ($data['retorno_obs']);
        $consult->motivo = ($data['motivo']);
        $consult->textarea_consult = ($data['textarea_consult']);
        $consult->ap_status = (isset($data['status_encerrada']) ? 'Encerrada' : 'Andamento');
        $consult->save();
        $this->valida_imagens();

        return redirect()->route('consult.edit', [ 'consult' => $id ]);
    }

    protected function validator($data) {
        return Validator::make($data, [
            'id_data_retorno' => [],
            'id_consult' => [],
            'id_patient' => ['required'],
            'id_client' => ['required'],
            'name' => [],
            'tutor' => [],
            'tipo' => ['required'],
            'consulta' => [],
            'data_consulta' => [],
            'peso' => [], 
            'sexo' => [],
            'diagnostico' => [],
            'anamnese' => [],
            'ambiente' => [],
            'acesso_rua' => [],
            'contactantes' => [],
            'contactantes_quant' => [],
            'integracao' => [],
            'dieta_seca' => [],
            'dieta_seca_rotina' => [],
            'dieta_pastosa' => [],
            'dieta_pastosa_frequencia' => [],
            'vacina' => [],
            'vacina_data' => [],
            'ar' => [],
            'ar_data' => [],
            'vermifugacao' => [],
            'vermifugacao_data' => [],
            'fiv_felv_negativo' => [],
            'fiv_felv_naoTestado' => [],
            'fiv_felv_fiv' => [],
            'fiv_felv_felv' => [],
            'olhos_blefaroespasmo' => [],
            'olhos_secrecao' => [],
            'olhos_secrecao_tipo' => [],
            'orelhas_prurido' => [],
            'orelhas_secrecao' => [],
            'orelhas_secrecao_tipo' => [],
            'pele_feridas' => [],
            'pele_prurido' => [],
            'pele_nodulos' => [],
            'pele_falha' => [],
            'pele_ecto' => [],
            'respiratorio_dispneia' => [],
            'respiratorio_tosses' => [],
            'respiratorio_espirros' => [],
            'respiratorio_frequencia' => [],
            'secrecao_nasal' => [],
            'castracao_castrado' => [],
            'castracao_inteiro' => [],
            'castracao_criptorquida' => [],
            'atitude_normal' => [],
            'atitude_dimin' => [],
            'atitude_apatia' => [],
            'atitude_agitado' => [],
            'atitude_entediado' => [],
            'apetite' => [],
            'mastigacao' => [],
            'vomito' => [],
            'vomito_conteudo' => [],
            'ingestao_hidrica' => [],
            'fezes' => [],
            'fezes_frequencia' => [],
            'escore_corporal' => [],
            'nivel_consciencia' => [],
            'urina_normal' => [],
            'urina_periuria' => [],
            'urina_aumentada' => [],
            'urina_diminuida' => [],
            'urina_estranguria' => [],
            'urina_frequencia' => [],
            'atitude_docil' => [],
            'atitude_desconfiado' => [],
            'atitude_medroso' => [],
            'atitude_agressivo' => [],
            'atitude_arredio' => [],
            'avaliacao_ocular_normal' => [],
            'avaliacao_ocular_secrecao' => [],
            'avaliacao_ocular_esclera' => [],
            'avaliacao_ocular_cornea' => [],
            'avaliacao_ocular_lente' => [],
            'avaliacao_ocular_conjuntiva' => [],
            'mucosas_normais' => [],
            'mucosas_palidas' => [],
            'mucosas_icterias' => [],
            'mucosas_congestas' => [],
            'mucosas_cianoticas' => [],
            'fr' => [],
            'fc' => [],
            'movimento_respiratorio_normal' => [],
            'dispineia' => [],
            'orelhas_normal' => [],
            'exfis_orelhas_secrecao' => [],
            'linfonodo_mandibular_direito' => [],
            'linfonodo_mandibular_direito_detalhes' => [],
            'linfonodo_mandibular_esquerdo' => [],
            'linfonodo_mandibular_esquerdo_detalhes' => [],
            'linfonodo_pre_escapular_direito' => [],
            'linfonodo_pre_escapular_direito_detalhes' => [],
            'linfonodo_pre_escapular_esquerdo' => [],
            'linfonodo_pre_escapular_esquerdo_detalhes' => [],
            'linfonodo_popliteo_direito' => [],
            'linfonodo_popliteo_direito_detalhes' => [],
            'linfonodo_popliteo_esquerdo' => [],
            'linfonodo_popliteo_esquerdo_detalhes' => [],
            'transporte_urina' => [],
            'transporte_vomito' => [],
            'transporte_fezes' => [],
            'hidratacao' => [],
            'bulhas_regulares' => [],
            'bulhas_irregulares' => [],
            'bulhas_normofoneticas' => [],
            'bulhas_hipofoneticas' => [],
            'sopro' => [],
            'sopro_detalhes' => [],
            'visicula_urinaria' => [],
            'alca_intest' => [],
            'rins_nao_palpados' => [],
            'rim_palpaveis_direito' => [],
            'rim_palpaveis_direito_detalhes' => [],
            'rim_palpaveis_esquerdo' => [],
            'rim_palpaveis_esquerdo_detalhes' => [],
            'outras_alteracoes_gases' => [],
            'outras_alteracoes_abdomen_abaulado' => [],
            'outras_alteracoes_abdomen_tenso' => [],
            'temperatura' => [],
            'tpc' => [],
            'sececao_nasal' => [],
            'pas_mmhg' => [],
            'pas_hash' => [],
            'pas_mpd' => [],
            'pas_mpe' => [],
            'pas_mtd' => [],
            'pas_mte' => [],
            'pas_posicao' => [],
            'glicemia' => [],
            'ausculta_pulmonar' => [],
            'ausculta_traqueal' => [],
            'exames_solicitados_outros' => [],
            'nosocomial_ficha_id' => [],
            'prescrito_ficha_id' => [],
            'data_retorno' => [],
            'hora_retorno' => [],
            'retorno_coletar' => [],
            'retorno_vacinar' => [],
            'retorno_reavaliar' => [],
            'retorno_obs' => [],
            'id_consultations_hours' => [],
            'motivo' => [],
            'textarea_consult' => [],
            'finished' => [],
            'status_encerrada' => [],
        ]);
    }

    protected function valida_imagens()
    {
        $consults = Veterinary_appointment::get();
        $todas_imagens = array();
        
        foreach ($consults as $consult) {
            $doc = new \DOMDocument();
            if (!empty($consult['textarea_consult'])) { //Faz o parse do HTML no php
                $doc->loadHTML($consult['textarea_consult']); 
                //Junta imagens de postagens diferentes no mesmo array
                $todas_imagens = array_merge($todas_imagens, $this->pegar_imagens($doc));
            }
        }
        //Remove imagens repetidas
        $todas_imagens = array_unique($todas_imagens);
        //Pega todas imagens da pasta no seu servidor
        foreach(glob('assets/imgs_tinymce/*.{jpeg,jpg,png}', GLOB_BRACE) as $imagem)
        {
            //Verifica se a imagem da pasta NÃO está em nenhuma postagem
            if (!in_array(basename($imagem), $todas_imagens)) {
                //Acaso não estiver deleta a imagem
                unlink($imagem);
            }
        }
    }
    protected function pegar_imagens($doc){
        $imagens = array();
        foreach($doc->getElementsByTagName('img') as $img)
        {
            $path = $img->getAttribute('src');
            if (!$path) continue;
            $imagens[] = basename($path);
        }    
        return $imagens;
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $appointment = Veterinary_appointment::where('id_company', Auth::user()->id_company)->where('id', $id)->first();

        if($id == $appointment['id']) {
            
            $appointment = Veterinary_appointment::where('id', $id)->update(['inactive' => 1]);
            return redirect()->route('consult.index');
        }
        return redirect()->route('home');
    }

    public function delete_fichas() {
        if (!empty($_GET['number'])) {
            $number = addslashes($_GET['number']);
            $ficha = addslashes($_GET['ficha']);
        }
        if ($ficha == 'nosoc') {
            $id = Veterinary_appointments_nosocomial::where('numero', $number)->first('id');
            Veterinary_appointments_nosocomial::where('numero', $number)
            ->where('id_company', Auth::user()->id_company)
            ->delete();
            echo json_encode($id);

        } else {
            $id = Veterinary_appointments_prescrito::where('numero', $number)->first('id');
            Veterinary_appointments_prescrito::where('numero', $number)
            ->where('id_company', Auth::user()->id_company)
            ->delete();
            echo json_encode($id);
        }
    }
}
