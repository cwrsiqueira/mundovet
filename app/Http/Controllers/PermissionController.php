<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\System_permission_group;
use App\System_permission_item;
use App\System_permission_link;
use App\User;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class PermissionController extends Controller
{


    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
        $this->middleware('can:menu-permissoes');

    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $items = System_permission_group::select('*', (DB::raw("(SELECT count(*) FROM users WHERE users.id_permission = system_permission_groups.id) as qt_user")))
        ->where('id_company', Auth::user()->id_company)
        ->paginate(10);
        
        return view('permission', [
            'permission_group' => $items
        ]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {   
        $permission_item = System_permission_item::where('id_company', Auth::user()->id_company)->get();
        
        return view('permission_create', [
            'permission_items' => $permission_item,
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
            'permission_item'
        ]);

        $validator = Validator::make(
            $data,
            [
                'name' => ['required', 'string', 'max:100', 'unique:system_permission_groups'],
                'permission_item' => ['required']
            ]
        );

        if ($validator->fails()) 
        {
            return redirect()->route('permission.create')->withErrors($validator)->withInput();
        }

        $id_company = Auth::user()->id_company;

        $permission_group = new System_permission_group();
        $permission_group->name = $data['name'];
        $permission_group->id_company = $id_company;
        $permission_group->save();
        $lastId = $permission_group->id;

        foreach ($data['permission_item'] as $item) {
            $permission_link = new System_permission_link();
            $permission_link->id_company = $id_company;
            $permission_link->id_permission_group = $lastId;
            $permission_link->id_permission_item = $item;
            $permission_link->save();
        }

        return redirect()->route('permission.index');
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
        $id_company_permission = System_permission_group::select('id_company')->where('id', $id)->first();
        
        if ($id_company == $id_company_permission['id_company']) {
            $permission_group = System_permission_group::find($id);
            $permission_items = System_permission_item::where('id_company', $id)->get();
            $permission_links = System_permission_link::select('id_permission_item')->where('id_permission_group', $id)->get();
            
            return view('permission_edit', [
                'permission' => $permission_group,
                'permission_items' => $permission_items,
                'permission_links' => $permission_links
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
        $id_company_permission = System_permission_group::select('id_company')->where('id', $id)->first();
        
        if ($id_company == $id_company_permission['id_company']) {
            $data = $request->only([
                'name',
                'permission_item'
            ]);
    
            $validator = Validator::make(
                $data,
                [
                    'name' => ['required', 'string', 'max:100'],
                ]
            );
    
            if ($validator->fails()) 
            {
                return redirect()->route('permission.create')->withErrors($validator)->withInput();
            }
    
            $permission_group = System_permission_group::find($id);
            $permission_group->name = $data['name'];
            $permission_group->save();

            $a = System_permission_link::where('id_permission_group', $id)->delete();
    
            foreach ($data['permission_item'] as $item) {
                $permission_link = new System_permission_link();
                $permission_link->id_company = Auth::user()->id_company;
                $permission_link->id_permission_group = $id;
                $permission_link->id_permission_item = $item;
                $permission_link->save();
            }
    
            return redirect()->route('permission.index');
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
        $id_company_permission = System_permission_group::select('id_company')->where('id', $id)->first();
        
        if ($id_company == $id_company_permission['id_company']) {
            $qt_user = User::where('id_permission', $id)->count();

            if ($qt_user <= 0) 
            {
                System_permission_group::find($id)->delete();
                System_permission_link::where('id_permission_group', $id)->delete();
            }
            return redirect()->route('permission.index');
        }
        return redirect()->route('login');
    }
}
