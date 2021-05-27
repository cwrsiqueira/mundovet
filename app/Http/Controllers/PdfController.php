<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Veterinary_client;
use App\Veterinary_patient;
use App\System_company;
use Illuminate\Support\Facades\Auth;
use PDF;

class PdfController extends Controller
{
	public function __construct()
    {
        $this->middleware('auth');
	}
	
	public function client_list()
    {
        $clients = Veterinary_client::where('id_company', Auth::user()->id_company)
        ->where('inactive', 0)
        ->orderBy('name')
        ->get();
        $company = System_company::where('id', Auth::user()->id_company)->first();

        return view('client_list', [
			'clients' => $clients,
			'company' => $company
		]);

		//     return PDF::loadView('client_list_pdf', compact('clients', 'company'))
		//                 ->setPaper('a4', 'landscape')
		//                 ->stream('lista_clientes.pdf');
	}

    public function patient_list()
    {
        $patients = Veterinary_patient::where('id_company', Auth::user()->id_company)
        ->where('inactive', 0)
        ->orderBy('name')
        ->get();
        $company = System_company::where('id', Auth::user()->id_company)->first();

        foreach ($patients as $key => $item ) {
            $age = $this->get_age($item['date_birth']);
            $patients[$key]['age'] = $age;
        }

		return view('patient_list', [
			'patients' => $patients,
			'company' => $company
		]);

        // return PDF::loadView('patient_list', compact('patients', 'company'))
        //             ->setPaper('a4', 'landscape')
        //             ->stream('lista_pacientes.pdf');
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

		if (empty($dt_nascimento)) 
		{
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
}
