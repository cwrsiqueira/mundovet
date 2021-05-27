<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\System_company;
use App\System_permission_group;
use App\System_permission_item;
use App\System_permission_link;
use App\User;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Auth;

class CompanyController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
        $this->middleware('can:menu-inicial');
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $id_company = Auth::user()->id_company;
        $company = System_company::find($id_company);
        $company = System_company::find(Auth::user()->id_company);
        // Calculo Vencimento do Sistema
        $hoje = date('Y-m-d');
        $venc = date('Y-m-d', strtotime($company['pay_date'].' +'.($company['days_paid']+1).' days'));
        $dias = date_diff(date_create($hoje), date_create($venc));
        if(!$company['days_paid']){
            $company['days_paid'] = 1;
        }
        $percent = number_format((((($company['days_paid'] - $dias->days)) / $company['days_paid']) * 100), 0);
        
        return view('company', [
            'company' => $company,
            'dados_vencimento' => [
                'venc' => $venc,
                'dias' => $dias->days,
                'percent' => $percent,
                'hoje' => $hoje
            ]
        ]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $data = $request->only(
            [
                'image',
                'name',
                'trade_name',
                'cnpj',
                'slogan',
                'address',
                'email',
                'phone',
                'whatsapp',
                'website',
            ]
        );

        $validator = Validator::make(
            $data,
            [
                'image' => 'image|mimes:jpeg,jpg,png',
                'name' => ['required', 'string', 'max:100', 'unique:system_companies'],
                'cnpj' => ['max:20'],
                'trade_name' => ['max:100'],
                'slogan' => [],
                'address' => [],
                'email' => ['max:100'],
                'phone' => ['max:20'],
                'whatsapp' => ['max:20'],
                'website' => ['max:50'],
            ]
        );

        if ($validator->fails()) 
        {
            return redirect()->route('home')->withErrors($validator)->withInput();
        }
        
        $company = new System_company;
        $company->name = $data['name'];
        $company->trade_name = $data['trade_name'] ?? '';
        $company->cnpj = $data['cnpj'] ?? '';
        $company->slogan = $data['slogan'] ?? '';
        $company->address = $data['address'] ?? '';
        $company->email = $data['email'] ?? '';
        $company->phone = $data['phone'] ?? '';
        $company->whatsapp = $data['whatsapp'] ?? '';
        $company->website = $data['website'] ?? '';
        $company->pay_date = date('Y-m-d h:i:s');
        $company->days_paid = 30;
        $company->save();
        $lastCompanyId = $company->id;

        if($request->hasFile('image')) {
            $image = $request->file('image');
            $image_name = $data['name'].'_'.time().md5(rand(0,999)).'.jpeg';
            $path = public_path('assets/img');
            $image->move($path, $image_name);
        }

        $company = System_company::find($lastCompanyId);
        if(!empty($image_name)) {
            $company->url_logo = $image_name;
            $company->save();
        }

        
        $permission_links_array = [
            ['name' => 'Menu Clientes', 'slug' => 'menu-clientes'],
            ['name' => 'Menu Pacientes', 'slug' => 'menu-pacientes'],
            ['name' => 'Menu Agenda', 'slug' => 'menu-agenda'],
            ['name' => 'Menu Exames', 'slug' => 'menu-exames'],
            ['name' => 'Menu Consultas', 'slug' => 'menu-consultas'],
            ['name' => 'Menu Empresa', 'slug' => 'menu-empresa'],
            ['name' => 'Menu Permissões', 'slug' => 'menu-permissoes'],
            ['name' => 'Menu Usuários', 'slug' => 'menu-usuarios'],
        ];

        foreach($permission_links_array as $item) {
            $permission_links = new System_permission_item();
            $permission_links->id_company = $lastCompanyId;
            $permission_links->name = $item['name'];
            $permission_links->slug = $item['slug'];
            $permission_links->save();
        }

        $permission_group = new System_permission_group();
        $permission_group->name = 'Super Admin';
        $permission_group->id_company = $lastCompanyId;
        $permission_group->save();
        $lastPermissionGroupId = $permission_group->id;

        $permission_links = System_permission_item::get();

        foreach ($permission_links as $item) {
            $permission_link = new System_permission_link();
            $permission_link->id_company = $lastCompanyId;
            $permission_link->id_permission_group = $lastPermissionGroupId;
            $permission_link->id_permission_item = $item->id;
            $permission_link->save();
        }

        $id_user = Auth::user()->id;
        $user = User::find($id_user);
        $user->id_company = $lastCompanyId;
        $user->id_permission = $lastPermissionGroupId;
        $user->save();

        return redirect()->route('home');
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
        $id_company_user = Auth::user()->id_company;
        
        if ($id == $id_company_user) {
            $data = $request->only(
                [
                    'image',
                    'name',
                    'trade_name',
                    'cnpj',
                    'slogan',
                    'address',
                    'email',
                    'phone',
                    'whatsapp',
                    'website',
                ]
            );
            
            $validator = Validator::make(
                $data,
                [
                    'image' => 'image|mimes:jpeg,jpg,png',
                    'name' => ['required', 'max:100'],
                    'cnpj' => ['max:20'],
                    'trade_name' => ['max:100'],
                    'slogan' => [],
                    'address' => [],
                    'email' => ['max:100'],
                    'phone' => ['max:20'],
                    'whatsapp' => ['max:20'],
                    'website' => ['max:50'],
                ]
            );
    
            if ($validator->fails()) 
            {
                return redirect()->route('company.index')->withErrors($validator)->withInput();
            }

            if($request->hasFile('image')) {
                $image = $request->file('image');
                $image_name = $data['name'].'_'.time().md5(rand(0,999)).'.jpeg';
                $path = public_path('assets/img');
                $image->move($path, $image_name);
            }
    
            $company = System_company::find($id);
            if(!empty($image_name)) {
                $company->url_logo = $image_name;
            }
            $company->name = $data['name'];
            $company->trade_name = $data['trade_name'];
            $company->cnpj = $data['cnpj'];
            $company->slogan = $data['slogan'];
            $company->address = $data['address'];
            $company->email = $data['email'];
            $company->phone = $data['phone'];
            $company->whatsapp = $data['whatsapp'];
            $company->website = $data['website'];
            $company->save();
    
            return redirect()->route('company.index');
        }

        return redirect()->route('logout');
        
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
