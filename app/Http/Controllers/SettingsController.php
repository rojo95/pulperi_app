<?php

namespace App\Http\Controllers;

use App\Models\Configuration;
use App\Models\CurrencyExchange;
use Illuminate\Http\Request;

class SettingsController extends Controller
{
    public function index()
    {
        return view('settings.index');
    }

    public function edit() {
        $settings = Configuration::all();
        $divisas = CurrencyExchange::where('status',true);
        return view('settings.edit',compact('settings','divisas'));
    }

    public function update(Request $request)
    {
        dd($request->all());
    }


}
