<?php

namespace App\Http\Controllers;

use App\Http\Requests\ClientStoreRequest;
use App\Http\Requests\EditClientRequest;
use App\Models\Client;
use App\Models\Debt;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Crypt;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Gate;

class ClientController extends Controller
{
    public function __construct()
    {
        $this->middleware('can:client_index')->only('index');
        $this->middleware('can:client_create')->only('create','store');
        $this->middleware('can:client_show')->only('show');
        $this->middleware('can:client_edit')->only('edit','update');
        $this->middleware('can:client_destroy')->only('destroy');
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        if (Gate::allows('client_destroy')) {
            $clients = Client::paginate(5);
        } else {
            $clients = Client::where('status',true)->paginate(5);
        }
        return view('clients.index',compact('clients'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('clients.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(ClientStoreRequest $request)
    {
        try {
            DB::beginTransaction();
            $cliente = Client::create($request->except('_token','address')+['address'=>strtoupper($request->input('address'))]);
            DB::commit();
            return response()->json(['res'=>1, 'info'=>$cliente]);
        } catch (\Exception $e) {
            DB::rollBack();
            return response()->json($e->getMessage());
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Client  $client
     * @return \Illuminate\Http\Response
     */
    public function show(Request $request)
    {
        $id = Crypt::decrypt($request->id);
        $client = Client::find($id);
        $debt = Debt::where('client_id',$id)->where('status',1)->get()->first();
        return view('clients.show',compact('client','debt'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Client  $client
     * @return \Illuminate\Http\Response
     */
    public function edit(Request $request)
    {
        $id = Crypt::decrypt($request->id);
        $client = Client::findOrFail($id);
        return view('clients.edit',compact('client'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Client  $client
     * @return \Illuminate\Http\Response
     */
    public function update(EditClientRequest $request, $id)
    {
        $id = Crypt::decrypt($request->id);
        $cliente = Client::findOrFail($id);
        $request->validate([
            'ced' => ['unique:clients,ced,'.$id],
        ]);
        try {
            DB::beginTransaction();
            $cliente->update($request->except('_token','address')+['address'=>strtoupper($request->input('address'))]);
            DB::commit();
            return response()->json(['res'=>1, 'info'=>'Información de '.$cliente->name.' '.$cliente->lastname.' actualizada correctamente.']);
        } catch (\Exception $e) {
            DB::rollBack();
            return response()->json($e->getMessage());
        }
        return response()->json($id);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Client  $client
     * @return \Illuminate\Http\Response
     */
    public function destroy(Request $request)
    {
        $id = Crypt::decrypt($request->id);
        $client = Client::findOrFail($id);
        $client->update(['status'=>!$client->status]);
        return redirect()->route('clnts.index');
    }

    public function clients_registered(Request $request)
    {
        if($request->id) {
            $client = Client::find($request->id);
        } else {
            $client = Client::where('status','=',true)->whereRaw("unaccent(name) ilike unaccent('%".$request->info."%')")->orWhereRaw("unaccent(lastname) ilike unaccent('%".$request->info."%')")->orWhere('ced','ilike','%'.$request->info.'%')->get();
        }
        return response()->json($client);
    }
}
