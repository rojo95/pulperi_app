<?php

namespace App\Http\Controllers;

use App\Http\Requests\RolEditRequest;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Crypt;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;

class RoleController extends Controller
{

    public function __construct()
    {
        $this->middleware('can:role_index')->only('index');
        $this->middleware('can:role_create')->only('create','store');
        $this->middleware('can:role_show')->only('show');
        $this->middleware('can:role_edit')->only('edit','update');
        $this->middleware('can:role_destroy')->only('destroy');
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $res)
    {
        $info = $res->search;
        $roles = Role::
            whereRaw("unaccent(name) ILIKE unaccent('%".$info."%')")
            ->orWhereRaw("unaccent(to_char(created_at, 'dd/mm/yy HH12:MI AM')) ILIKE unaccent('%".$info."%')")
            ->orWhereRaw("unaccent(CASE WHEN status = true THEN 'activo' ELSE 'inactivo' END) ILIKE unaccent('%".$info."%')")
            ->orderBy('name','asc')
            ->paginate(3);
        return view('roles.index',compact('roles','info'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $permissions = Permission::select('name','id')->where('status','=',true)->get();
        return view('roles.create',compact('permissions'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $role = Role::create($request->only('name'));
        $role->syncPermissions($request->input('permission',[]));
        return redirect()->route('rls.index')->with('success','Rol registrado correctamente.');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $id = Crypt::decrypt($id);
        $role = Role::findOrFail($id);
        $role->Load('permissions');
        return view('roles.show',compact('role'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $id = Crypt::decrypt($id);
        $role = Role::findOrFail($id);
        $permissions = Permission::all()->pluck('name','id');
        $role->Load('permissions');
        return view('roles.edit',compact('role','permissions'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(RolEditRequest $request, $id)
    {
        $id   = Crypt::decrypt($id);
        $role = Role::findOrFail($id);
        $data = $request->only('name');
        $role->permissions()->sync($request->input('permission',[]));
        $data = array('name'=>$request->name);
        $role->update($data);
        return redirect()->route('rls.show',Crypt::encrypt($id))->with('success','Rol "'.$request->name.'" modificado correctamente.');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $id     = Crypt::decrypt($id);
        $role   = Role::findOrFail($id);
        $data   = array('status'=>!$role->status);
        $action = $role->status ? 'desactivado' : 'activado';
        $role->update($data);
        return redirect()->route('rls.index',$id)->with('success','Rol "'.$role->name.'" '.$action.' correctamente.');
    }

}
