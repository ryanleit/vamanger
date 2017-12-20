<?php

namespace App\Http\Controllers\Admin;

use App\Http\Requests;
use App\Http\Controllers\Controller;

use App\Models\Component;
use Illuminate\Http\Request;
use Carbon\Carbon;
use Session;
use Illuminate\Support\Facades\View;
use Illuminate\Support\Facades\Input;

class ComponentController extends Controller
{
    public $active_tab;
    /**
     * Instantiate a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->active_tab = 'component';
        View::share ( 'active_tab', $this->active_tab );
        View::share ( 'page', 'component' );      
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

        $components = Component::orderBy($order_by, $order_direct)->paginate(15);
        return view('admin.components.index', compact('components'))
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
        return view('admin.components.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @return void
     */
    public function store(Request $request)
    {
        
        Component::create($request->all());

        Session::flash('flash_message', 'Component added!');

        return redirect('admin/components');
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
        $component = Component::findOrFail($id);
        return view('admin.components.show', compact('component'));
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
        $component = Component::findOrFail($id);
        return view('admin.components.edit', compact('component'));
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
        
        $component = Component::findOrFail($id);
        $component->update($request->all());

        Session::flash('flash_message', 'Component updated!');

        return redirect('admin/components');
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
        Component::destroy($id);

        Session::flash('flash_message', 'Component deleted!');

        return redirect('admin/components');
    }
}
