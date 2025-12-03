<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class EssController extends Controller
{
    public function home()
    {
        return view('ess.home');
    }
}
