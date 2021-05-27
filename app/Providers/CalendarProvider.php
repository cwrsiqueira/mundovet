<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\Auth;
use App\Veterinary_dates_opening_hour;
use App\Veterinary_dates_exception;
use App\Veterinary_client;
use App\Veterinary_patient;
use App\Veterinary_dates_booked;

class CalendarProvider extends ServiceProvider
{
    /**
     * Register services.
     *
     * @return void
     */
    public function register()
    {
        //
    }

    /**
     * Bootstrap services.
     *
     * @return void
     */
    public function boot()
    {
        view()->composer(['consult_edit', 'agenda_create'], function($view) {

            $dados = $this->getData();
          
            $view->with('dados', $dados);
     
        });
    }

    private function getData() {

        $dados = Auth::user();
        $name = explode(' ', $dados['name']);

        $data_atual = time()-10800;
        $d = date('d', $data_atual);
        $m = date('m', $data_atual);
        $a = date('Y', $data_atual);

        if (!empty($_GET['dia'])) {
            $d = $_GET['dia'];
        }

        if (!empty($_GET['mes']) && $_GET['mes'] <= 12 && $_GET['mes'] >= 1) {
            $m = str_pad($_GET['mes'], 2, '0', STR_PAD_LEFT);
        }

        if (!empty($_GET['ano'])) {
            $a = $_GET['ano'];
        }

        // retorna o número de dias que tem o mês desejado
        $numero_dias = $this->GetNumeroDias( $m, $a ); 

        $nome_mes = $this->GetNomeMes( $m );
        $diacorrente = 0; 

        // função que descobre o dia da semana
        $diasemana = jddayofweek( cal_to_jd(CAL_GREGORIAN, $m,"01",$a) , 0 ); 

        $m_nome = $this->GetNomeMes( $m );

        $dt_disp = Veterinary_dates_opening_hour::where('id_company', Auth::user()->id_company)->get();
        $dt_except = Veterinary_dates_exception::where('id_company', Auth::user()->id_company)->orderBy('ini_date')->get();
        
        $mes_anterior = ($m < 2) ? $m+11 : $m-1;
        $mes_posterior = ($m > 11) ? 1 : $m+1;

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

        $dados = [
            'a' => $a,
            'm' => $m,
            'd' => $d,
            'm_nome' => $m_nome,
            'data_atual' => $data_atual,
            'diacorrente' => $diacorrente,
            'numero_dias' => $numero_dias,
            'diasemana' => $diasemana,
            'dt_disp' => $dt_disp,
            'dt_except' => $dt_except,
            'mes_anterior' => $mes_anterior,
            'mes_posterior' => $mes_posterior,
            'id_permission' => $dados['id_permission'],
            'name' => $name[0],
            'qt_clients' => $qt_clients,
            'qt_patients' => $qt_patients,
            'qt_consultas' => $qt_consultas,
            'qt_retornos' => $qt_retornos,
        ];

        return $dados;
    }

    private function GetNumeroDias( $mes, $ano )
	{
	  $numero_dias = array( 
	      '01' => 31, '02' => 28, '03' => 31, '04' =>30, '05' => 31, '06' => 30,
	      '07' => 31, '08' =>31, '09' => 30, '10' => 31, '11' => 30, '12' => 31,
	      '1' => 31, '2' => 28, '3' => 31, '4' =>30, '5' => 31, '6' => 30,
	      '7' => 31, '8' =>31, '9' => 30
	  );
	 
	  if ((($ano % 4) == 0 and ($ano % 100)!=0) or ($ano % 400)==0)
	  {
	      $numero_dias['02'] = 29;  // altera o numero de dias de fevereiro se o ano for bissexto
	  }
	 
	  return $numero_dias[$mes];
	}
	 
	private function GetNomeMes( $mes )
	{
	     $meses = array( '01' => "Janeiro", '02' => "Fevereiro", '03' => "Março",
	                     '04' => "Abril",   '05' => "Maio",      '06' => "Junho",
	                     '07' => "Julho",   '08' => "Agosto",    '09' => "Setembro",
	                     '10' => "Outubro", '11' => "Novembro",  '12' => "Dezembro",
	                     '1' => "Janeiro", '2' => "Fevereiro", '3' => "Março",
	                     '4' => "Abril",   '5' => "Maio",      '6' => "Junho",
	                     '7' => "Julho",   '8' => "Agosto",    '9' => "Setembro"
	                     );
	 
	      if( $mes >= 01 && $mes <= 12)
	        return $meses[$mes];
	 
	        return "Mês deconhecido";
	 
    }
}
