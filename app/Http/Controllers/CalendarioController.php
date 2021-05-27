<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Veterinary_dates_opening_hour;
use App\Veterinary_dates_exception;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;

class CalendarioController extends Controller
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
        
        return view('calendario', [
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
            'mes_posterior' => $mes_posterior
        ]);
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

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $opening_hours = Veterinary_dates_opening_hour::where('id_company', Auth::user()->id_company)
        ->orderBy('id')
        ->get();
        $exceptions = Veterinary_dates_exception::where('id_company', Auth::user()->id_company)->orderBy('ini_date')->get();
        
        return view('calendario_create', [
            'except' => $exceptions,
            'op_h' => $opening_hours
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
        $data_hours = $request->only([
            'sun_ini_atend',
            'sun_fin_atend',
            'sun_ini_interv',
            'sun_fin_interv',
            'mon_ini_atend',
            'mon_fin_atend',
            'mon_ini_interv',
            'mon_fin_interv',
            'tue_ini_atend',
            'tue_fin_atend',
            'tue_ini_interv',
            'tue_fin_interv',
            'wed_ini_atend',
            'wed_fin_atend',
            'wed_ini_interv',
            'wed_fin_interv',
            'thu_ini_atend',
            'thu_fin_atend',
            'thu_ini_interv',
            'thu_fin_interv',
            'fri_ini_atend',
            'fri_fin_atend',
            'fri_ini_interv',
            'fri_fin_interv',
            'sat_ini_atend',
            'sat_fin_atend',
            'sat_ini_interv',
            'sat_fin_interv',
        ]);

        $data_exception = $request->only([
            'ini_date',
            'fin_date',
        ]);

        $validator = Validator::make(
            $data_hours,
            [
                'sun_ini_atend' => [],
                'sun_fin_atend' => [],
                'sun_ini_interv' => [],
                'sun_fin_interv' => [],
                'mon_ini_atend' => [],
                'mon_fin_atend' => [],
                'mon_ini_interv' => [],
                'mon_fin_interv' => [],
                'tue_ini_atend' => [],
                'tue_fin_atend' => [],
                'tue_ini_interv' => [],
                'tue_fin_interv' => [],
                'wed_ini_atend' => [],
                'wed_fin_atend' => [],
                'wed_ini_interv' => [],
                'wed_fin_interv' => [],
                'thu_ini_atend' => [],
                'thu_fin_atend' => [],
                'thu_ini_interv' => [],
                'thu_fin_interv' => [],
                'fri_ini_atend' => [],
                'fri_fin_atend' => [],
                'fri_ini_interv' => [],
                'fri_fin_interv' => [],
                'sat_ini_atend' => [],
                'sat_fin_atend' => [],
                'sat_ini_interv' => [],
                'sat_fin_interv' => [],
            ],
            $data_exception,
            [
                'ini_date' => [],
                'fin_date' => [],
            ]
        );

        if ($validator->fails()) 
        {
            return redirect()->route('client.index')->withErrors($validator)->withInput();
        }
        
        foreach ($data_hours as $key => $value) {

            $day = substr($key, 0, 3);

            $id = Veterinary_dates_opening_hour::where('id_company', Auth::user()->id_company)->where('day', $day)->get('id')->first();
            
            if (!empty($id->id)) {
                $opening_hour = Veterinary_dates_opening_hour::find($id->id);
                $opening_hour->ini_atend = $data_hours[$day.'_ini_atend'];
                $opening_hour->fin_atend = $data_hours[$day.'_fin_atend'];
                $opening_hour->ini_interv = $data_hours[$day.'_ini_interv'];
                $opening_hour->fin_interv = $data_hours[$day.'_fin_interv'];
                $opening_hour->save();
            } else {
                $opening_hour = new Veterinary_dates_opening_hour;
                $opening_hour->id_company = Auth::user()->id_company;
                $opening_hour->day = $day;
                $opening_hour->ini_atend = $data_hours[$day.'_ini_atend'];
                $opening_hour->fin_atend = $data_hours[$day.'_fin_atend'];
                $opening_hour->ini_interv = $data_hours[$day.'_ini_interv'];
                $opening_hour->fin_interv = $data_hours[$day.'_fin_interv'];
                $opening_hour->save();
            }
        }

        if (!empty($data_exception['ini_date'])) {
            $exception = new Veterinary_dates_exception;
            $exception->id_company = Auth::user()->id_company;
            $exception->ini_date = $data_exception['ini_date'];
            $exception->fin_date = $data_exception['fin_date'];
            $exception->save();
        }
        
        return redirect()->route('calendario.create');
    }

    public function del_exception(Request $request)
    {
        $data = $request->only([
            'exception',
        ]);

        $validator = Validator::make(
            $data,
            [
                'exception' => ['required'],
            ]
        );

        if ($validator->fails()) 
        {
            return redirect()->route('client.index')->withErrors($validator)->withInput();
        }

        Veterinary_dates_exception::find($data['exception'])->delete();

        return redirect()->route('calendario.create'); 
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
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
        //
    }
}
