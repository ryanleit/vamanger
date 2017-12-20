<?php

namespace App\Http\Controllers\Admin;

use App\Http\Requests;
use App\Http\Controllers\Controller;

use App\Models\Role as role;
use App\Models\Component;
use Illuminate\Http\Request;
use Carbon\Carbon;
use Session;
use Illuminate\Support\Facades\View;
use Illuminate\Support\Facades\Input;

class RoleController extends Controller
{
    public $active_tab;
    /**
     * Instantiate a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->active_tab = 'role';
        View::share ( 'active_tab', $this->active_tab );
        View::share ( 'page', 'role' );      
    }
    /**
     * Display a listing of the resource.
     *
     * @return void
     */
    public function index($order_by='id', $order_direct='asc')
    {
        $order_by         = Input::get('order_by')
                          ? Input::get('order_by')
                          : $order_by;

        $order_direct     = Input::get('order_direct')
                          ? Input::get('order_direct')
                          : $order_direct;

        $roles = role::orderBy($order_by, $order_direct)->paginate(15);
        return view('admin.roles.index', compact('roles'))
                ->with('order_by',      $order_by)
                ->with('order_direct',  $order_direct);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return void
     */
    public function create()
    {
        $components = Component::with('permissions')->get()->toArray();
        
        return view('admin.roles.create', ['components'=>$components]);        
    }

    /**
     * Store a newly created resource in storage.
     *
     * @return void
     */
    public function store(Request $request)
    {
        $this->validate($request, ['name' => 'required', 'permissions' => 'required', 'status' => 'required', 'role_level' => 'required', ]);

        $reqData = $request->all();
        
        $reqData['permissions'] = '["'.implode('","', $reqData['permissions']).'"]';
        
        role::create($reqData);

        Session::flash('flash_message', 'role added!');

        return redirect('admin/roles');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     *
     * @return void
     */
    public function show($id)
    {
        $role = role::findOrFail($id);
        return view('admin.roles.show', compact('role'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     *
     * @return void
     */
    public function edit($id)
    {
        $role = role::findOrFail($id);//->toArray();
        $components = Component::with('permissions')->get()->toArray();
        
        return view('admin.roles.edit', ['role'=>$role,'components'=>$components]);
        //return view('admin.roles.edit', compact('role'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  int  $id
     *
     * @return void
     */
    public function update($id, Request $request)
    {
        $this->validate($request, ['name' => 'required', 'permissions' => 'required', 'status' => 'required', 'role_level' => 'required', ]);

        $role = role::findOrFail($id);
        $reqData = $request->all();
        
        $reqData['permissions'] = '["'.implode('","', $reqData['permissions']).'"]';
        //$role->update($request->all());
        $role->update($reqData);
        Session::flash('flash_message', 'role updated!');

        return redirect('admin/roles');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     *
     * @return void
     */
    public function destroy($id)
    {
        role::destroy($id);

        Session::flash('flash_message', 'role deleted!');

        return redirect('admin/roles');
    }
}
