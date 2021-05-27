<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Veterinary_patient;
use App\Veterinary_client;
use App\System_company;
use App\Veterinary_appointment;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\DB;
use PDF;

class PatientController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
        $this->middleware('can:menu-pacientes');
    }

    public function search_patient() {

        if (!empty($_GET['idclient'])) 
        {
            if (!empty($_GET['name'])) 
            {
                $name = addslashes($_GET['name']);
                $idclient = addslashes($_GET['idclient']);
                $res = Veterinary_patient::where('name', 'LIKE', '%'.$name.'%')
                ->where('id_company', Auth::user()->id_company)
                ->where('id_client', $idclient)
                ->where('inactive', 0)
                ->limit(10)
                ->get();
                echo json_encode($res);
            }
        } 
        else 
        {
            if (!empty($_GET['name'])) 
            {
                $name = addslashes($_GET['name']);
                $res = Veterinary_patient::where('name', 'LIKE', '%'.$name.'%')
                ->where('id_company', Auth::user()->id_company)
                ->where('inactive', 0)
                ->limit(10)
                ->get();
                echo json_encode($res);
            }
        }
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
        
    public function index()
    {
        $patient = '';
        if (!empty($_GET['patient'])) {
            $patient = addslashes($_GET['patient']);
        }
        $patients = Veterinary_patient::select('*', 
        (DB::raw("(select name from veterinary_clients where veterinary_clients.id = veterinary_patients.id_client) as tutor")))
        ->where('name', 'LIKE', '%'.$patient.'%')
        ->where('id_company', Auth::user()->id_company)
        ->where('inactive', 0)
        ->orderBy('name')
        ->paginate(10);
        
        return view('patient', [
            'patients' => $patients,
        ]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create(Request $request)
    {
        $data = $request->only([
            'client',
        ]);
        
        $validator = Validator::make($data, ['client' => 'required']);

        if ($validator->fails()) {
            return redirect()->route('patient.create')->withErrors($validator)->withInput();
        }
        
        $client = Veterinary_client::find($data['client']);

        return view('patient_create', ['client' => $client]);
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
            'image',
            'id_client',
            'chip_number',
            'name',
            'species',
            'coat',
            'date_birth',
            'date_death', 
            'image',
        ]);
        
        $validator = Validator::make(
            $data,
            [
                'image' => 'image|mimes:jpeg,jpg,png',
                'name' => ['required', 'string', 'max:50'],
                'id_client' => ['required'],
                'date_birth' => ['required']
            ]
        );

        if ($validator->fails()) 
        {
            return redirect()->route('patient.create', ['client' => $data['id_client']])->withErrors($validator)->withInput();
        }

        if($request->hasFile('image')) {
            $image = $request->file('image');
            $image_name = time().'.jpg';
            $path = public_path('assets/img');
            $image->move($path, $image_name);
            $url_photo = $image_name;
        }

        $patient = new Veterinary_patient;

        if (!empty($url_photo)) {
            $patient->url_photo = $url_photo;
        }

        $patient->id_company = Auth::user()->id_company;
        $patient->id_client = $data['id_client'];
        $patient->chip_number = $data['chip_number'];
        $patient->name = $data['name'];
        $patient->species = $data['species'];
        $patient->coat = $data['coat'];
        $patient->date_birth = $data['date_birth'];
        $patient->date_death = $data['date_death'];
        $patient->save();

        return redirect()->route('patient.index');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $patient = Veterinary_patient::select('*', 
        DB::raw("(SELECT name FROM veterinary_clients WHERE veterinary_clients.id = veterinary_patients.id_client) as tutor_name, (SELECT id FROM veterinary_clients WHERE veterinary_clients.id = veterinary_patients.id_client) as tutor_id"))
        ->where('id_company', Auth::user()->id_company)
        ->where('id', $id)
        ->where('inactive', 0)
        ->first();
        $company = System_company::where('id', Auth::user()->id_company)->first();
        $age = $this->get_age($patient->date_birth);
        $consults = Veterinary_appointment::where('id_company', Auth::user()->id_company)
        ->where('id_patient', $id)
        ->where('inactive', 0)
        ->get();

        return view('patient_view', [
            'patient' => $patient, 
            'company' => $company, 
            'age' => $age, 
            'consults' => $consults
        ]);

        // return PDF::loadView('patient_view', compact('patient', 'company', 'age', 'consults'))
        //             ->setPaper('a4')
        //             ->stream('patient_view.pdf');
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $patient = DB::select('SELECT *, (select name from veterinary_clients where veterinary_clients.id = veterinary_patients.id_client) as tutor, (select id from veterinary_clients where veterinary_clients.id = veterinary_patients.id_client) as id_tutor FROM veterinary_patients WHERE id_company = ? AND id = ? AND inactive = 0', [Auth::user()->id_company, $id]);
        
        $age = $this->get_age($patient[0]->date_birth);
        
        return view('patient_edit', [
            'patient' => $patient[0],
            'age' => $age
        ]);
    }

    public function get_age($dt_nascimento) {

        //Data atual
		if (date('h') >= 9 || date('h') <=2) {
			$dia = date('d') - 1;
		} else {
			$dia = date('d');
		}
		$mes = date('m');
		$ano = date('Y');

        if (empty($dt_nascimento)) {
            $dt_nascimento = '0000-00-00';
        }
		//Data do aniversário	
		$datanasc = explode(' ', $dt_nascimento);
		$datanasc = explode('-', $datanasc[0]);
		$dianasc = explode('-', $datanasc[2]);
		$mesnasc = explode('-', $datanasc[1]);
		$anonasc = explode('-', $datanasc[0]);
		$dianasc = $dianasc[0];
		$mesnasc = $mesnasc[0];
		$anonasc = $anonasc[0];
		
		//Calculando idade
		//Calculando anos
		$anos = $ano - $anonasc;
		if ($mes < $mesnasc){
			$anos = $anos - 1;
		} elseif ($mes == $mesnasc && $dia < $dianasc) {
			$anos = $anos - 1;
		}
		//Calculando meses
		$meses = $mes - $mesnasc;
		if ($mes < $mesnasc) {
			$meses = $meses + 12;
		} elseif ($mes == $mesnasc && $dia < $dianasc) {
			$meses = ($meses - 1) + 12;
		}

		return $idade = array(
			'anos'=> $anos,
			'meses' => $meses,
		);
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
        $patient = Veterinary_patient::where('id_company', Auth::user()->id_company)->where('id', $id)->first();

        if($id == $patient['id']) {

            $data = $request->only([
                'image',
                'id_client',
                'chip_number',
                'name',
                'species',
                'coat',
                'date_birth',
                'date_death', 
                'image',
            ]);

            $validator = Validator::make(
                $data,
                [
                    'image' => 'image|mimes:jpeg,jpg,png',
                    'name' => ['required', 'string', 'max:50'],
                    'id_client' => ['required'],
                ]
            );

            if ($validator->fails()) 
            {
                return redirect()->route('patient.create')->withErrors($validator)->withInput();
            }
            
            if($request->hasFile('image')) {
                $image = $request->file('image');
                $image_name = $patient['id_company'].$id.'.jpg';
                $path = public_path('assets/img');
                $image->move($path, $image_name);
                $url_photo = $image_name;
            }

            if (!empty($url_photo)) {
                $patient->url_photo = $url_photo;
            }
            
            $patient->id_client = $data['id_client'];
            $patient->chip_number = $data['chip_number'];
            $patient->name = $data['name'];
            $patient->species = $data['species'];
            $patient->coat = $data['coat'];
            $patient->date_birth = $data['date_birth'];
            $patient->date_death = $data['date_death'];
            $patient->save();

            return redirect()->route('patient.index');
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $patient = Veterinary_patient::where('id_company', Auth::user()->id_company)->where('id', $id)->first();

        if($id == $patient['id']) {
            
            $patient = Veterinary_patient::where('id', $id)->update(['inactive' => 1]);
            return redirect()->route('patient.index');
        }
        return redirect()->route('/');
    }
}
