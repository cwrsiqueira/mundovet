<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Veterinary_client;
use App\Veterinary_patient;
use App\System_company;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Response;
use PDF;

class ClientController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
        $this->middleware('can:menu-clientes');
    }

    public function validation_user_controller($id) {
        $client = Veterinary_client::where('id_company', Auth::user()->id_company)->where('id', $id)->first();
        if(count($client) > 0) {
            return true;
        } else {
            return false;
        }
    }

    public function search_client() {
        if (!empty($_GET['tutor'])) {
            $tutor = addslashes($_GET['tutor']);
            $res = Veterinary_client::select('*', 
            (DB::raw("(SELECT count(*) FROM veterinary_patients WHERE veterinary_patients.id_client = veterinary_clients.id AND veterinary_patients.inactive = 0) as qt_pets")))
            ->where('name', 'LIKE', '%'.$tutor.'%')
            ->where('id_company', Auth::user()->id_company)
            ->where('inactive', 0)
            ->limit(10)
            ->get();
            echo json_encode($res);
        }
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {   
        $tutor = '';
        if (!empty($_GET['tutor'])) {
            $tutor = addslashes($_GET['tutor']);
        }
        $clients = Veterinary_client::select('*',
        (DB::raw("(select count(*) from veterinary_patients where veterinary_patients.id_client = veterinary_clients.id AND veterinary_patients.inactive = 0) as qt_pets")))
        ->where('name', 'LIKE', '%'.$tutor.'%')
        ->where('id_company', Auth::user()->id_company)
        ->where('inactive', 0)
        ->orderBy('name')
        ->paginate(10);
        
        return view('client', [
            'clients' => $clients
        ]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('client_create');
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
            'name',
            'email',
            'newsletter_agree',
            'phone',
            'whatsapp', 
            'date_birth',
            'cpf',
            'rg',
            'cep',
            'full_address',
            'obs',
        ]);

        if (empty($data['newsletter_agree'])) {
            $data['newsletter_agree'] = 0;
        }

        $validator = Validator::make(
            $data,
            [
                'name' => ['required', 'string', 'max:100'],
                'email' => ['required', 'string', 'email', 'max:60', 'unique:veterinary_clients'],
                'newsletter_agree' => [],
                'phone' => ['max:14'],
                'whatsapp' => ['max:14'],
                'date_birth' => [],
                'cpf' => ['max:14'],
                'rg' => ['max:50'],
                'cep' => ['max:10'],
                'full_address' => [],
                'obs' => [],
            ]
        );

        if ($validator->fails()) 
        {
            return redirect()->route('client.create')->withErrors($validator)->withInput();
        }

        $client = new Veterinary_client;
        $client->id_company = Auth::user()->id_company;
        $client->name = $data['name'];
        $client->email = $data['email'];
        $client->newsletter_agree = $data['newsletter_agree'];
        $client->phone = $data['phone'];
        $client->whatsapp = $data['whatsapp'];
        $client->date_birth = $data['date_birth'];
        $client->cpf = $data['cpf'];
        $client->rg = $data['rg'];
        $client->cep = $data['cep'];
        $client->full_address = $data['full_address'];
        $client->obs = $data['obs'];
        $client->save();

        return redirect()->route('client.index');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $client = Veterinary_client::where('id_company', Auth::user()->id_company)
        ->where('id', $id)
        ->where('inactive', 0)
        ->first();
        $company = System_company::where('id', Auth::user()->id_company)->first();
        $pets = Veterinary_patient::where('id_company', Auth::user()->id_company)
        ->where('id_client', $id)
        ->where('inactive', 0)
        ->get();

        return view('client_view', [
            'client' => $client,
            'company' => $company, 
            'pets' => $pets
        ]);

        // return PDF::loadView('client_view', compact('client', 'company', 'pets'))
        //             ->setPaper('a4')
        //             ->stream('client_view.pdf');
    }
    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $client = Veterinary_client::where('id_company', Auth::user()->id_company)->where('id', $id)->first();
        
        return view('client_edit', [
            'client' => $client
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
        $client = Veterinary_client::where('id_company', Auth::user()->id_company)->where('id', $id)->first();

        if($id == $client['id']) {

            $data = $request->only([
                'name',
                'email',
                'newsletter_agree',
                'phone',
                'whatsapp', 
                'date_birth',
                'cpf',
                'rg',
                'cep',
                'full_address',
                'obs',
            ]);

            if (empty($data['newsletter_agree'])) {
                $data['newsletter_agree'] = 0;
            }

            $validator = Validator::make(
                $data,
                [
                    'name' => ['required', 'string', 'max:100'],
                    'email' => ['required', 'string', 'email', 'max:60'],
                    'newsletter_agree' => [],
                    'phone' => ['max:14'],
                    'whatsapp' => ['max:14'],
                    'date_birth' => [],
                    'cpf' => ['max:14'],
                    'rg' => ['max:50'],
                    'cep' => ['max:10'],
                    'full_address' => [],
                    'obs' => [],
                ]
            );

            if ($validator->fails()) 
            {
                return redirect()->route('client.edit')->withErrors($validator)->withInput();
            }
        
            $client->name = $data['name'];
            $client->email = $data['email'];
            $client->newsletter_agree = $data['newsletter_agree'];
            $client->phone = $data['phone'];
            $client->whatsapp = $data['whatsapp'];
            $client->date_birth = $data['date_birth'];
            $client->cpf = $data['cpf'];
            $client->rg = $data['rg'];
            $client->cep = $data['cep'];
            $client->full_address = $data['full_address'];
            $client->obs = $data['obs'];
            $client->save();
            
            return redirect()->route('client.index');
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
        $client = Veterinary_client::where('id_company', Auth::user()->id_company)->where('id', $id)->first();

        if($id == $client['id']) {
            $qt_patient = Veterinary_patient::where('id_client', $id)->where('inactive', 0)->count();

            if ($qt_patient <= 0) 
            {
                Veterinary_client::where('id', $id)->update(['inactive' => 1]);
            }
            return redirect()->route('client.index');
        }
        return redirect()->route('/');
    }
}
