<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\User;
use App\System_permission_group;
use App\System_user_profile;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Hash;

class UserController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
        $this->middleware('can:menu-usuarios');
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $items = User::select('*', (DB::raw("(SELECT name FROM system_permission_groups where system_permission_groups.id = users.id_permission) as permission")))
        ->where('id_company', Auth::user()->id_company)
        ->where('inactive', 0)
        ->paginate(10);

        $loggedId = Auth::id();
        return view('user', [
            'users' => $items,
            'loggedId' => $loggedId
        ]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $id_company = Auth::user()->id_company;
        $permissions = System_permission_group::where('id_company', $id_company)->get();

        return view('user_create', [
            'permissions' => $permissions
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
            'name',
            'email',
            'password',
            'password_confirmation',
            'id_permission'
        ]);

        $validator = Validator::make(
            $data,
            [
                'name' => ['required', 'string', 'max:100'],
                'email' => ['required', 'string', 'email', 'max:100', 'unique:users'],
                'password' => ['required', 'string', 'min:8', 'confirmed'],
                'id_permission' => ['required'],
            ]
        );

        if ($validator->fails()) 
        {
            return redirect()->route('user.create')->withErrors($validator)->withInput();
        }

        $user = new User;
        $user->name = $data['name'];
        $user->email = $data['email'];
        $user->password = Hash::make($data['password']);
        $user->id_company = Auth::user()->id_company;
        $user->id_permission = $data['id_permission'];
        $user->save();

        return redirect()->route('user.index');
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
        $id_company = Auth::user()->id_company;
        $id_company_user = User::select('id_company')->where('id', $id)->first();
        
        if ($id_company == $id_company_user['id_company']) {
            $user = User::find($id);
            $id_company = Auth::user()->id_company;
            $permissions = System_permission_group::where('id_company', $id_company)->get();

            return view('user_edit', [
                'user' => $user,
                'permissions' => $permissions
            ]);
        }

        return redirect()->route('login');
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
        $id_company = Auth::user()->id_company;
        $id_company_user = User::select('id_company')->where('id', $id)->first();
        
        if ($id_company == $id_company_user['id_company']) {
            $data = $request->only([
                'name',
                'email',
                'password',
                'password_confirmation',
                'id_permission'
            ]);
    
            $validator = Validator::make(
                $data,
                [
                    'name' => ['required', 'string', 'max:100'],
                    'email' => ['required', 'string', 'email', 'max:100'],
                    'id_permission' => ['required']
                ]
            );

            $user = User::find($id);

            // 1. Alteração do Nome
            $user->name = $data['name'];

            // 2. Alteração do E-mail
            if ($user->email != $data['email']) 
            {
                $hasEmail = User::where('email', $data['email'])->get();
                if (count($hasEmail) == 0) 
                {
                    $user->email = $data['email'];
                }
                else
                {
                    $validator->errors()->add('email', 'E-mail já existe');
                } 
            }

            // 3. Alteração da Senha
            if (!empty($data['password'])) 
            {
                if (strlen($data['password']) >= 8) 
                {
                    if ($data['password'] == $data['password_confirmation']) 
                    {
                        $user->password = Hash::make($data['password']);
                    }
                    else 
                    {
                        $validator->errors()->add('password', 'As senhas devem ser iguais.');
                    }
                }
                else
                {
                    $validator->errors()->add('password', 'A senha deve ter mais de 7 caracteres.');
                }    
            }
    
            if (count($validator->errors()) > 0) 
            {
                return redirect()->route('user.edit', ['user' => $id])->withErrors($validator);
            }

            // Inserir Empresa e Permissão
            $user->id_company = Auth::user($id)->id_company;
            $user->id_permission = $data['id_permission'];

            // 4. Salva as alterações
            $user->save();

            return redirect()->route('user.index');
        }

        return redirect()->route('login');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $id_company = Auth::user()->id_company;
        $id_company_user = User::select('id_company')->where('id', $id)->first();
        
        if ($id_company == $id_company_user['id_company']) {

            $loggedId = Auth::id();
            if ($loggedId != $id) {
                
                User::where('id', $id)->update([
                    'inactive' => 1,
                    'id_permission' => null
                ]);
            }
            return redirect()->route('user.index');
        }
        return redirect()->route('login');
    }
}
