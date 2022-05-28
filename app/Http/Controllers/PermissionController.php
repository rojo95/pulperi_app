<?php

namespace App\Http\Controllers;

use App\Http\Requests\PermissionCreateRequest;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Crypt;
use Spatie\Permission\Models\Permission;
use App\Http\Requests\PermissionEditRequest;
use Illuminate\Support\Facades\Gate;

class PermissionController extends Controller
{

    public function __construct()
    {
        $this->middleware('can:permission_index')->only('index');
        $this->middleware('can:permission_create')->only('create','store');
        $this->middleware('can:permission_show')->only('show');
        $this->middleware('can:permission_edit')->only('edit','update');
        $this->middleware('can:permission_destroy')->only('destroy');
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        abort_if(Gate::denies('permission_index'),403);
        $permissions = Permission::orderBy('id','asc')->paginate(5);
        return view('permissions.index',compact('permissions'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        abort_if(Gate::denies('permission_create'),403);
        return view('permissions.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(PermissionCreateRequest $request)
    {
        Permission::create($request->all());
        return redirect()->route('prmssns.index')->with('success','Permiso registrado correctamente.');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        abort_if(Gate::denies('permission_show'),403);
        $id   = Crypt::decrypt($id);
        $permission = Permission::findOrFail($id);
        return view('permissions.show',compact('permission'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        abort_if(Gate::denies('permission_edit'),403);
        $id         = Crypt::decrypt($id);
        $permission = Permission::findOrFail($id);
        return view('permissions.edit',compact('permission'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(PermissionEditRequest $request, $id)
    {
        $id         = Crypt::decrypt($id);
        $permission = Permission::findOrFail($id);
        $permission->update(['name'=>$request->name]);
        return redirect()->route('prmssns.show',Crypt::encrypt($id))->with('success','Permiso "'.$request->name.'" modificado correctamente.');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        abort_if(Gate::denies('permission_destroy'),403);
        $id         = Crypt::decrypt($id);
        $permission = Permission::findOrFail($id);
        $data       = array('status'=>!$permission->status);
        $action     = $permission->status ? 'desactivado' : 'activado';
        $permission->update($data);
        return redirect()->route('prmssns.index')->with('success','Permiso "'.$permission->name.'" '.$action.' correctamente.');
    }

}
