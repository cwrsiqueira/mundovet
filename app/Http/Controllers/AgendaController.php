<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;
use App\Mail\newCadastro;
use App\Veterinary_dates_opening_hour;
use App\Veterinary_dates_booked;
use App\Veterinary_dates_exception;
use App\Veterinary_patient;
use App\Veterinary_client;
use App\System_company;
use App\Veterinary_appointment;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class AgendaController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
        $this->middleware('can:menu-agenda');
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {   
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

        $consults = Veterinary_dates_booked::select('*', 
        DB::raw("
            (SELECT name FROM veterinary_patients WHERE veterinary_patients.id = veterinary_dates_bookeds.id_patient) as patient_name,
            (SELECT name FROM veterinary_clients WHERE veterinary_clients.id = veterinary_dates_bookeds.id_client) as client_name
        "))
        ->whereBetween('data_consulta', [date('Y-m-d', strtotime($ini_date)), date('Y-m-d', strtotime($fin_date.'+1 days'))])
        ->where('id_company', Auth::user()->id_company)
        ->where('status_agendamento', null)
        ->orWhere('status_agendamento', '')
        ->orderBy('data_consulta')
        ->paginate(10);
        
        return view('agenda', [
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
    public function create(Request $request) {

        $data = $request->only([
            'patient',
        ]);

        $validator = Validator::make($data, ['patient' => 'required']);

        if ($validator->fails()) {
            return redirect()->route('patient.index')->withErrors($validator)->withInput();
        }
        
        $patient = Veterinary_patient::find($data['patient']);
        $client = Veterinary_client::find($patient['id_client']);

        return view('agenda_create', ['patient' => $patient, 'client' => $client]);
    }


    public function temp()
    {   
        if (!empty($_GET['ano'])) {
            $dia = addslashes($_GET['dia']);
            $mes = addslashes($_GET['mes']);
            $ano = addslashes($_GET['ano']);
        }
        $date = date('Y-m-d', strtotime($ano.'-'.$mes.'-'.$dia));
        $dia_da_semana = strtolower(date('D', strtotime($ano.'-'.$mes.'-'.$dia)));

        $hora_disp = Veterinary_dates_opening_hour::where('id_company', Auth::user()->id_company)
        ->where('day', $dia_da_semana)
        ->first();

        $hd = [];
        $h = [];

        for ($i=1; $i < 24; $i++) { 
            $h = date('H:i:s', strtotime($i.':00:00'));
            if ($h >= $hora_disp['ini_atend'] &&
                $h < $hora_disp['fin_atend'] &&
                ($h < $hora_disp['ini_interv'] ||
                $h >= $hora_disp['fin_interv'])) {
                $hd[] = $h;
            }
        }
        
        foreach ($hd as $key => $item) {
            $data_consulta = $date.' '.$item;
            $horas_agendadas = Veterinary_dates_booked::where('id_company', Auth::user()->id_company)
            ->where('data_consulta', $data_consulta)
            ->first();
            if (!empty($horas_agendadas)) {
                unset($hd[$key]);
            }
        }

        return view('agenda_create', [
            'selected_date' => $date,
            'hd' => $hd
        ]);
    }

    public function selecionarHorariosDisponiveis()
    {   
        $dados = array();

        if (!empty($_GET['ano'])) {
            $dia = addslashes($_GET['dia']);
            $mes = addslashes($_GET['mes']);
            $ano = addslashes($_GET['ano']);

            $date = date('Y-m-d', strtotime($ano.'-'.$mes.'-'.$dia));
            $dia_da_semana = strtolower(date('D', strtotime($ano.'-'.$mes.'-'.$dia)));

            $hora_disp = Veterinary_dates_opening_hour::where('id_company', Auth::user()->id_company)
            ->where('day', $dia_da_semana)
            ->first();

            $hd = [];
            $h = [];

            for ($i=1; $i < 24; $i++) { 
                $h = date('H:i:s', strtotime($i.':00:00'));
                if ($h >= $hora_disp['ini_atend'] &&
                    $h < $hora_disp['fin_atend'] &&
                    ($h < $hora_disp['ini_interv'] ||
                    $h >= $hora_disp['fin_interv'])) {
                    $hd[] = $h;
                }
            }
            
            foreach ($hd as $item) {
                $data_consulta = $date.' '.$item;
                $horas_agendadas = Veterinary_dates_booked::where('id_company', Auth::user()->id_company)
                ->where('data_consulta', $data_consulta)
                ->first();
                if (!empty($horas_agendadas)) {
                    $key = array_search($item, $hd);
                    unset($hd[$key]);
                    $hd = array_values($hd);
                }
            }

            $dados = [
                'selected_date' => $date,
                'hd' => $hd
            ];
        }

        return $dados;
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
            'email',
            'id_client',
            'id_patient',
            'data_retorno',
            'motivo',
            'phone',
            'whatsapp',
            'consulta_retorno',
        ]);

        $validator = Validator::make($data, [
            'email' => ['required', 'email'],
            'id_client' => ['required'],
            'id_patient' => ['required'],
            'data_retorno' => ['required'],
            'motivo' => ['required'],
            'phone' => ['required'],
            'consulta_retorno' => ['required'],
            'whatsapp' => [],
        ]);
        
        if ($validator->fails()) {
            return redirect()->route('agenda.create', ['patient' => $data['id_patient']])->withErrors($validator)->withInput();
        }
        
        $agendamento = new Veterinary_dates_booked;
        $agendamento->id_company = Auth::user()->id_company;
        $agendamento->id_client = $data['id_client'];
        $agendamento->id_patient = $data['id_patient'];
        $agendamento->data_consulta = $data['data_retorno'];
        $agendamento->consulta_retorno = $data['consulta_retorno'];
        $agendamento->motivo = $data['motivo'];
        $agendamento->save();

        $client = Veterinary_client::find($agendamento->id_client);
        $patient = Veterinary_patient::find($agendamento->id_patient);
        $company = System_company::find($agendamento->id_company);

        // return new newCadastro($agendamento, $client, $patient, $company);
        Mail::send(new newCadastro($agendamento, $client, $patient, $company));
        return redirect()->route('agenda.index');
        
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id_agendamento)
    {
        $agendamento = Veterinary_dates_booked::where('id', $id_agendamento)->first();
        $id_client = $agendamento['id_client'];
        $client = Veterinary_client::where('id_company', Auth::user()->id_company)
        ->where('id', $id_client)
        ->where('inactive', 0)
        ->first();
        $id_patient = $agendamento['id_patient'];
        $company = System_company::where('id', Auth::user()->id_company)->first();
        $patient = Veterinary_patient::where('id_company', Auth::user()->id_company)
        ->where('id', $id_patient)
        ->where('inactive', 0)
        ->first();

        return view('agenda_view', [
            'client' => $client,
            'company' => $company, 
            'patient' => $patient,
            'agendamento' => $agendamento
        ]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $data_booked = Veterinary_dates_booked::where('id_company', Auth::user()->id_company)->where('id', $id)->first();

        $get_birthdate = Veterinary_patient::where('id', $data_booked['id_patient'])->get('date_birth')->first();
        $get_age = new PatientController;
        $age = $get_age->get_age($get_birthdate['date_birth']);
        $data_booked['idade'] = implode(',', $age);

        $agendamento = Veterinary_dates_booked::find($id);
        $agendamento->status_agendamento = 'consulta_realizada';
        $agendamento->save();

        $consult = new Veterinary_appointment;
        $consult->id_company = Auth::user()->id_company;
        $consult->id_patient = $data_booked['id_patient'];
        $consult->tipo = 'simples';
		$consult->data_consulta = $data_booked['data_consulta'];
		$consult->idade = $data_booked['idade'];
        $consult->motivo = $data_booked['motivo'];
        $consult->consulta = $data_booked['consulta_retorno'];
        $consult->save();
        $id_consult = $consult->id;

        return redirect()->route('consult.edit', [ 'consult' => $id_consult ]);
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
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $agendamento = Veterinary_dates_booked::find($id);
        $agendamento->status_agendamento = 'excluido_pelo_usuario';
        $agendamento->save();
        return redirect()->route('agenda.index');
    }
}
