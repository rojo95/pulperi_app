<?php

namespace App\Http\Controllers;

use App\Http\Requests\DebtPayRequest;
use App\Models\Debt;
use App\Models\DebtorMovement;
use App\Models\Divisas;
use App\Models\PaymentMethod;
use App\Models\PaymentMethodDebtorMovement;
use App\Models\PaymentMethodTransaction;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Crypt;
use Illuminate\Support\Facades\DB;

class DebtController extends Controller
{
    public function __construct()
    {
        $this->middleware('can:debts_index')->only('index');
        $this->middleware('can:debts_show')->only('show');
        $this->middleware('can:debts_pay')->only('edit','update');
        $this->middleware('can:debts_destroy')->only('destroy');
        $this->middleware('payPayedDebt')->only('edit','update');
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $res)
    {
        $info = $res->search;
        $debts = Debt::
            select('debts.*')
            ->join('clients AS a','debts.client_id','a.id')
            ->whereRaw("unaccent(name) ILIKE unaccent('%".$info."%')")
            ->orWhereRaw("unaccent(lastname) ILIKE unaccent('%".$info."%')")
            ->orWhereRaw("unaccent(address) ILIKE unaccent('%".$info."%')")
            ->orWhere('ced', 'ILIKE', $info)
            ->orWhereRaw("unaccent(to_char(debts.created_at, 'dd/mm/yy HH12:MI AM')) ILIKE unaccent('%".$info."%')")
            ->orWhereRaw("unaccent(CASE WHEN debts.status=1 THEN 'activo' ELSE 'inactivo' END) ILIKE unaccent('%".$info."%')")
            ->get();
        return view('debts.index',compact('debts','info'));
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
        $debt = Debt::findOrFail($id);
        $total_bs = 0;
        $total_usd = 0;
        $pagado_bs = 0;
        $pagado_usd = 0;
        foreach ($debt->movements as $v) {
            if ($v->status)
                if($v->movement_type) {
                    $total_bs = $total_bs+floatval($v->amount_bs);
                    $total_usd = $total_usd+floatval($v->amount_usd);
                } else {
                    $pagado_usd = $pagado_usd+floatval($v->amount_usd);
                    $pagado_bs = $pagado_bs+floatval($v->amount_bs);
                }
        }
        return view('debts.show',compact('debt','total_bs','total_usd','pagado_bs','pagado_usd'));
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
        $debt = Debt::findOrFail($id);
        $divisas = Divisas::where('status',true)->get();
        $metodos = PaymentMethod::where('status',true)->orderBy('description','asc')->get();
        $total_bs = 0;
        $total_usd = 0;
        $pagado_bs = 0;
        $pagado_usd = 0;
        foreach ($debt->movements as $v) {
            if($v->status)
                if($v->movement_type) {
                    $total_bs = $total_bs+floatval($v->amount_bs);
                    $total_usd = $total_usd+floatval($v->amount_usd);
                } else {
                    $pagado_usd = $pagado_usd+floatval($v->amount_usd);
                    $pagado_bs = $pagado_bs+floatval($v->amount_bs);
                }
        }
        return view('debts.pay',compact('debt','divisas','metodos','total_bs','total_usd','pagado_bs','pagado_usd'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(DebtPayRequest $request, $id)
    {
        if($request->amount<=0)
            return response()->json(
                [
                    'errors' => [
                        'amount' => "Debe ingresar un monto mayor a cero (0).",
                    ]
                ], 422);

        $id = Crypt::decrypt($request->id);
        $debt = Debt::where('id',$id)->where('status',true)->first();

        if(!$debt)
            return response()->json(['msj'=>'No se han conseguido deudas para pagar','res'=>2]);

        $bs = $request->divisa == 1 ? floatval($request->amount) : floatval($request->dolar)*floatval($request->amount);
        $usd = $request->divisa == 2 ? floatval($request->amount) : floatval($request->amount)/floatval($request->dolar);

        try {
            DB::beginTransaction();
            $d_movement = DebtorMovement::create(['debt_id'=>$debt->id,'movement_type'=>false,'amount_bs'=>round($bs,2),'amount_usd'=>round($usd,2)]);
            foreach ($request->payment_method as $v) {
                PaymentMethodDebtorMovement::create(['payment_method_id'=>$v,'debtor_movement_id'=>$d_movement->id]);
            }
            $movements = DebtorMovement::where('debt_id',$debt->id)->where('status',true)->get();
            $monto_bs  = 0;
            $monto_usd = 0;
            foreach ($movements as $value) {
                if($value->movement_type){
                    if ($value->status) {
                        $monto_bs = $monto_bs+$value->amount_bs;
                        $monto_usd = $monto_usd+$value->amount_usd;
                    }
                } else {
                    if ($value->status) {
                        $monto_bs = $monto_bs-$value->amount_bs;
                        $monto_usd = $monto_usd-$value->amount_usd;
                    }
                }
            }
            if($monto_bs<=0 && $monto_usd<=0) {
                $debt->update(['status'=>2]);
                $debt->save();
            }
            DB::commit();
            return response()->json(['res'=>1]);
        } catch (\Exception $e) {
            DB::rollBack();
            return response()->json(['msj'=>'Error al realizar el registro. Motivo: '.$e,'type'=>'danger'],500);
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Request $request)
    {
        $id = Crypt::decrypt($request->id);
        $movement = DebtorMovement::find($id);
        $total_usd = 0;
        $total_bs = 0;
        foreach ($movement->debt->movements as $value) {
            if($value->status)
                if($value->movement_type){
                    $total_bs = $total_bs+floatval($value->amount_bs);
                    $total_usd = $total_usd+floatval($value->amount_usd);
                } else {
                    $total_bs = $total_bs-floatval($value->amount_bs);
                    $total_usd = $total_usd-floatval($value->amount_usd);
                }
        }
        $total_usd = $total_usd+floatval($movement->amount_usd);
        $total_bs = $total_bs+floatval($movement->amount_bs);
        $movement->update(['status'=>false]);
        if($total_usd>0 || $total_bs>0) {
            $debt = Debt::find($movement->debt->id);
            $debt->update(['status'=>1]);
        }
        return redirect()->route('dbts.show',Crypt::encrypt($movement->debt->id))->with('success','Transacción anulada de manera satisfactoria');
    }

    public function debt_detail(Request $request)
    {
        $id = Crypt::decrypt($request->id);
        $movement = DebtorMovement::findOrFail($id);
        $debt = $movement->debt;
        $total_bs = 0;
        $total_usd = 0;
        $pagado_bs = 0;
        $pagado_usd = 0;
        foreach ($debt->movements as $v) {
            if($v->movement_type) {
                $total_bs = $total_bs+floatval($v->amount_bs);
                $total_usd = $total_usd+floatval($v->amount_usd);
            } else {
                $pagado_usd = $pagado_usd+floatval($v->amount_usd);
                $pagado_bs = $pagado_bs+floatval($v->amount_bs);
            }
        }
        return view('debts.details',compact('debt','movement','total_bs','total_usd','pagado_bs','pagado_usd'));
    }
}
