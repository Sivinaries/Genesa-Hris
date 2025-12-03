<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\CompanyPayrollConfig;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Cache;

class PageController extends Controller
{
    public function profile()
    {
        if (!Auth::check()) {
            return redirect('/');
        }

        $userCompany = Auth::user()->compani;

        if (!$userCompany) {
            return redirect()->route('addcompany');
        }

        return view('profil', compact('userCompany'));
    }

    public function dashboard()
    {
        if (!Auth::check()) {
            return redirect('/');
        }

        $userCompany = Auth::user()->compani;

        if (!$userCompany) {
            return redirect()->route('addcompany');
        }

        $status = $userCompany->status;

        if ($status !== 'Settlement') {
            return redirect()->route('login');
        }

        return view('dashboard');
    }

    public function setting()
    {
        if (!Auth::check()) return redirect('/');
        $userCompany = Auth::user()->compani;
        if (!$userCompany) return redirect()->route('addcompany');

        $cacheKey = 'setting_' . $userCompany->id;

        $configs = Cache::remember($cacheKey, 60, function () use ($userCompany) {
            return CompanyPayrollConfig::where('compani_id', $userCompany->id)->get();
        });

        return view('setting', compact('configs'));
    }
}
