<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class CutiController extends Controller
{
    public function index()
    {
        $cuti = DB::table('master_cuti')->orderBy('kode_cuti', 'asc')->get();
        return view('cuti.index', compact('cuti'));
    }
}
