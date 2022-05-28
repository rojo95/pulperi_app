<?php

namespace App\Http\Controllers;

use App\Http\Requests\ProfileEditRequest;
use App\Http\Requests\UserCreateRequest;
use App\Http\Requests\UserEditRequest;
use App\Models\Genere;
use App\Models\Profile;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Crypt;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;
use Spatie\Permission\Models\Role;

class UserController extends Controller
{


    public function __construct()
    {
        $this->middleware('can:user_indexUsers')->only('indexUsers');
        $this->middleware('can:user_createUser')->only('createUser','storeUser');
        $this->middleware('can:user_showUser')->only('showUser');
        $this->middleware('can:user_editUser')->only('editUser','updateUser');
        $this->middleware('can:user_statusUser')->only('statusUser');
        $this->middleware('userUpdAdmin')->only('showUser','editUser','updateUser','statusUser');

    }
    public function indexUsers(){
        $own_roles = [];
        foreach (Auth::user()->roles as $v) {
            array_push($own_roles,$v->id);
        }
        $users = User::join('profiles', 'profiles.user_id', 'users.id')->orderBy('profiles.name')->paginate(5);
        return view('users.index',compact('users','own_roles'));
    }

    public function createUser(){
        $own_roles = [];
        foreach (Auth::user()->roles as $v) {
            array_push($own_roles,$v->id);
        }
        $generes = Genere::select('id','description')->where('status',true)->get();
        $roles = Role::select('name','id')->where('status','=',true)->get();
        return view('users.create',compact('roles','own_roles','generes'));
    }

    public function storeUser(UserCreateRequest $request){
        $own_roles = [];
        foreach (Auth::user()->roles as $v) {
            array_push($own_roles,$v->id);
        }
        try {
            DB::beginTransaction();

            $user    = User::create($request->only('username','email')
                +['password'=>bcrypt($request->input('password'), ['rounds' => 12])]
            );
            $roles   = $request->roles;
            if (!in_array(1,$own_roles)) {
                $adm = array_search(1, $roles);
                unset($roles[$adm]);
            }
            $user->syncRoles($roles);
            $profile = Profile::create($request->only('name','lastname','identification')+['user_id'=>$user->id,'genere_id'=>$request->genere]);
            $name    = $profile->name.' '.$profile->lastname;
            DB::commit();
        } catch (\Exception $e) {
            DB::rollBack();
            return redirect()->route('usrs.index')->with('success',' Error al crear el usuario. Motivo: '.$e->getMessage())->with('type','danger');
        }
        return redirect()->route('usrs.show',Crypt::encrypt($user->id))->with('success',$name.' registrado correctamente.');
    }

    public function showUser($id){
        $id   = Crypt::decrypt($id);
        $user = User::findOrFail($id);
        return view('users.show',compact('user'));
    }

    public function editUser($id){
        $own_roles = [];
        foreach (Auth::user()->roles as $v) {
            array_push($own_roles,$v->id);
        }
        $id    = Crypt::decrypt($id);
        $user  = User::findOrFail($id)->load('roles');
        $roles = Role::select('name','id')->where('status',true)->get();
        $generes = Genere::select('id','description')->where('status',true)->get();
        return view('users.edit', compact('user','roles','own_roles','generes'));
    }

    public function updateUser(UserEditRequest $request, $id){
        $id       = Crypt::decrypt($id);
        $user     = User::findOrFail($id);
        $data = [];
        $own_roles = [];
        foreach (Auth::user()->roles as $v) {
            array_push($own_roles,$v->id);
        }
        if($user->id!=1) {
            $request->validate([
                'name' => 'regex:/[a-zA-ZáéíóúÁÉÍÓÚñÑ\s]+$/x|required|min:2|max:25',
                'lastname' => 'regex:/[a-zA-ZáéíóúÁÉÍÓÚÑñ\s]+$/x|required|min:2|max:25',
                'identification' => ['required','min:1000000','numeric','unique:profiles,identification,'.$user->profile->id],
                'genere' => 'required|numeric',
                'email' => ['required','email','unique:users,email,'.$user->id],
                'username' => ['required','min:3','max:20','unique:users,username,'.$user->id],
            ]);
            $data = $request->only('name','lastname','identification','email','username')+['genere_id'=>$request->genere];
        }
        try {
            DB::beginTransaction();
            $profile  = Profile::where('user_id',$user->id);

            $pw       = $request->input('password');
            if($pw)
            $dataUser['password'] = bcrypt($pw, ['rounds' => 12]);
            if($user->id!=1) {
                $dataUser = $request->only('username','email');
                $dataProfile = $request->only('name','lastname','identification')+['genere_id'=>$request->genere];
                $user->update($data);
                $profile->update($dataProfile);
            }

            $name = $user->id!=1 ? $request->name.' '.$request->lastname : 'Administrador';

            if(Auth::user()->id != $id){
                $roles = $request->roles;
                if (!in_array(1,$own_roles)) {
                    $adm = array_search(1, $roles);
                    unset($roles[$adm]);
                }
                $user->syncRoles($roles);
            }
            DB::commit();
        } catch (\Exception $e) {
            DB::rollBack();
            return redirect()->route('usrs.index')->with('success',' Error al actualizar datos del usuario. Motivo: '.$e->getMessage())->with('type','error');
        }
        return redirect()->route('usrs.show',Crypt::encrypt($id))->with('success','Usuario '.$name.' actualizado correctamente.');
    }

    public function statusUser($id){
        $id     = Crypt::decrypt($id);
        $user   = User::findOrFail($id);
        $status = $user->status==0 ? 1 : 0;
        $data   = array('status'=>$status);
        $action = $status == 0 ? 'desactivado' : 'activado';

        if(Auth::user()->id == $user->id) {
            return redirect()->route('usrs.index')->with('success','No puedes deshabilitar tu propio usuario.')->with('type','warning');
        } else if($user->id == 1) {
            return redirect()->route('usrs.index')->with('success','No puedes deshabilitar el usuario administrador.')->with('type','warning');
        }

        $user->update($data);
        return redirect()->route('usrs.index')->with('success',$user->profile->name.' '.$user->profile->lastname.' '.$action.' correctamente.');
    }

    public function showProfile(){
        $user = User::findOrFail(Auth::user()->id);
        return view('profiles.profile',compact('user'));
    }

    public function editProfile(){
        $user = User::findOrFail(Auth::user()->id);
        return view('profiles.edit',compact('user'));
    }

    public function updateProfile(ProfileEditRequest $request){
        $user_id = Auth::user()->id;
        $user = User::findOrFail($user_id)->first();
        $data = [];
        if($user_id!=1) {
            $request->validate([
                'name' => 'regex:/[a-zA-ZáéíóúÁÉÍÓÚñÑ\s]+$/x|required|min:2|max:25',
                'lastname' => 'regex:/[a-zA-ZáéíóúÁÉÍÓÚÑñ\s]+$/x|required|min:2|max:25',
                'identification' => ['required','min:1000000','numeric','unique:profiles,identification,'.$user],
                'genere' => 'required|numeric',
                'email' => ['required','email','unique:users,email,'.$user->id],
                'username' => ['required','min:3','max:20','unique:users,username,'.$user->id],
            ]);
            $data = $request->only('name','lastname','identification','genere','email','username');
        }

        $pw   = $request->input('password');
        if($pw)
        $data['password'] = bcrypt($pw, ['rounds' => 12]);

        $user->update($data);
        return redirect()->route('prfl.show')->with('success','Perfil actualizado correctamente.');
    }
}
