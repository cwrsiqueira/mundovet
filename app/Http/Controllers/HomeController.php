<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Veterinary_dates_opening_hour;
use App\Veterinary_dates_exception;
use App\Veterinary_client;
use App\Veterinary_patient;
use App\Veterinary_dates_booked;
use App\System_company;

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {
        $dados = Auth::user();
        $name = explode(' ', $dados['name']);

        $qt_clients = Veterinary_client::where('id_company', Auth::user()->id_company)->where('inactive', 0)->count();
        $qt_patients = Veterinary_patient::where('id_company', Auth::user()->id_company)->where('inactive', 0)->count();
        $qt_consultas = Veterinary_dates_booked::where('id_company', Auth::user()->id_company)->where('consulta_retorno', 'consulta')->where(function($query) {
            $query->where('status_agendamento', '')
                  ->orWhere('status_agendamento', null);
        })->count();
        $qt_retornos = Veterinary_dates_booked::where('id_company', Auth::user()->id_company)->where('consulta_retorno', 'retorno')->where(function($query) {
            $query->where('status_agendamento', '')
                  ->orWhere('status_agendamento', null);
        })->count();

        $agendamentos = Veterinary_dates_booked::where('id_company', Auth::user()->id_company)->where('status_agendamento', null)->with('patient')->with('client')->orderBy('data_consulta', 'ASC')->paginate('10');

        $company = System_company::find(Auth::user()->id_company);
        // Calculo Vencimento do Sistema
        $hoje = date('Y-m-d');
        $venc = date('Y-m-d', strtotime($company['pay_date'].' +'.($company['days_paid']+1).' days'));
        $dias = date_diff(date_create($hoje), date_create($venc));
        if(!$company['days_paid']){
            $company['days_paid'] = 1;
        }
        $percent = number_format((((($company['days_paid'] - $dias->days)) / $company['days_paid']) * 100), 0);
        
        $last_login = Auth::user()->last_login;
        if ($last_login != date('Y-m-d')) {
            $update_login = Auth::user();
            $update_login->last_login = NOW();
            $update_login->save();
        }

        return view('home', [
            'last_login' => $last_login,
            'id_permission' => $dados['id_permission'],
            'name' => $name[0],
            'qt_clients' => $qt_clients,
            'qt_patients' => $qt_patients,
            'qt_consultas' => $qt_consultas,
            'qt_retornos' => $qt_retornos,
            'agendamentos' => $agendamentos,
            'company' => $company,
            'dados_vencimento' => [
                'venc' => $venc,
                'dias' => $dias->days,
                'percent' => $percent,
                'hoje' => $hoje
            ]
        ]);
    }
}