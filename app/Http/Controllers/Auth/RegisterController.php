<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Providers\RouteServiceProvider;
use App\User;
use App\System_company;
use App\System_permission_group;
use App\System_permission_item;
use App\System_permission_link;
use Illuminate\Foundation\Auth\RegistersUsers;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;

class RegisterController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Register Controller
    |--------------------------------------------------------------------------
    |
    | This controller handles the registration of new users as well as their
    | validation and creation. By default this controller uses a trait to
    | provide this functionality without requiring any additional code.
    |
    */

    use RegistersUsers;

    /**
     * Where to redirect users after registration.
     *
     * @var string
     */
    protected $redirectTo = RouteServiceProvider::HOME;

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('guest');
    }

    /**
     * Get a validator for an incoming registration request.
     *
     * @param  array  $data
     * @return \Illuminate\Contracts\Validation\Validator
     */
    protected function validator(array $data)
    {
        return Validator::make($data, [
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:users'],
            'password' => ['required', 'string', 'min:8', 'confirmed'],
        ]);
    }

    /**
     * Create a new user instance after a valid registration.
     *
     * @param  array  $data
     * @return \App\User
     */
    protected function create(array $data)
    {
        $company = $this->create_company($data['name'], $data['email']);
        
        return User::create([
            'name' => $data['name'],
            'email' => $data['email'],
            'password' => Hash::make($data['password']),
            'id_company' => $company['id_company'],
            'id_permission' => $company['id_permission'],
        ]);
    }

    private function create_company($name, $email)
    {
        $company = new System_company;
        $company->name = $name;
        $company->email = $email;
        $company->pay_date = date('Y-m-d h:i:s');
        $company->days_paid = 30;
        $company->save();
        $lastCompanyId = $company->id;
        
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
        
        return $company = [
            'id_company' => $lastCompanyId,
            'id_permission' => $lastPermissionGroupId
        ];
    }
}
