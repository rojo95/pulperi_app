<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class ReportController extends Controller
{
    // ventana inicial de los reportes
    public function index()
    {
        return view('reports.index');
    }
}
