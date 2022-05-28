<?php

namespace App\Http\Controllers;

use App\Models\Configuration;
use Illuminate\Http\Request;

class SettingsController extends Controller
{
    public function index()
    {
        return view('settings.index');
    }

    public function update() {
        $settings = Configuration::all();
        return view('settings.update',compact('settings'));
    }
}
