<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\System_permission_item;
use App\User;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Auth;

class Permission_itemController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
        //$this->middleware('can:menu-configuracoes');
        $this->middleware('can:menu-desenvolvedor');
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $item = System_permission_item::get();
        
        return view('permission_item_create', [
            'permission_item' => $item,
        ]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $item = System_permission_item::get();
        
        return view('permission_item_create', [
            'permission_item' => $item,
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
        $data = $request->only(
            [
                'name',
            ]
        );

        $data['slug'] = Str::slug($data['name'], '-');
        $data['id_company'] = Auth::user()->id_company;

        $validator = Validator::make(
            $data,
            [
                'name' => ['required', 'string', 'max:100'],
                'slug' => ['required', 'string', 'max:100', 'unique:system_permission_items'],
                'id_company' => ['required'],
            ]
        );

        if ($validator->fails()) 
        {
            return redirect()->route('permission_item.create')->withErrors($validator)->withInput();
        }

        $system_permission_item = new System_permission_item;
        $system_permission_item->name = $data['name'];
        $system_permission_item->slug = $data['slug'];
        $system_permission_item->id_company = $data['id_company'];
        $system_permission_item->save();

        return redirect()->route('permission_item.create');
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
        $permission_item = System_permission_item::find($id);
        
        return view('permission_item_edit', [
            'permission_item' => $permission_item,
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
        $item = System_permission_item::find($id);

        $data = $request->only(
            [
                'name',
            ]
        );

        $data['id_company'] = Auth::user()->id_company;
        $data['id_company_item'] = $item['id_company'];

        $data['slug'] = Str::slug($data['name'], '-');
        $data['current_name'] = $item['name'];

        $validator = Validator::make(
            $data,
            [
                'name' => ['required', 'string', 'max:100', 'different:current_name'],
                'slug' => ['required', 'string', 'max:100', 'unique:system_permission_items'],
                'id_company' => ['required', 'same:id_company_item'],
            ]
        );

        if ($validator->fails()) 
        {
            return redirect()->route('permission_item.edit', ['permission_item' => $id])->withErrors($validator)->withInput();
        }

        $item->name = $data['name'];
        $item->slug = $data['slug'];
        $item->save();

        return redirect()->route('permission_item.create', ['permission_item' => $id]);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $System_permission_item = System_permission_item::find($id);
        $System_permission_item->delete();
        return redirect()->route('permission_item.create');
    }
}
