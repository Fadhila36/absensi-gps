<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class IzinController extends Controller
{
    public function create()
    {
        return view('izin.create');
    }
}
