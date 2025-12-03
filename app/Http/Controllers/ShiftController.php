<?php

namespace App\Http\Controllers;

use App\Models\Shift;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Cache;

class ShiftController extends Controller
{
    public function index()
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

        $cacheKey = 'shifts';

        $shifts = Cache::remember($cacheKey, now()->addMinutes(60), function () use ($userCompany) {
            return $userCompany->shifts()->with('employee', 'branch')->get();
        });

        $branch = $userCompany->branches()->get();

        $employee = $userCompany->employees()->get();

        return view('shift', compact('shifts', 'branch', 'employee'));
    }

    public function store(Request $request)
    {
        $userCompany = auth()->user()->compani;

        $data = $request->validate([
            'branch_id' => 'required',
            'employee_id' => 'required',
            'start_time' => 'required',
            'end_time' => 'required',
            'description' => 'required',
        ]);

        $data['compani_id'] = $userCompany->id;

        Shift::create($data);

        Cache::forget('shifts');

        return redirect(route('shift'))->with('success', 'Shift successfully created!');
    }

    public function update(Request $request, $id)
    {
        $userCompany = auth()->user()->compani;

        $request->validate([
            'branch_id' => 'required',
            'employee_id' => 'required',
            'start_time' => 'required',
            'end_time' => 'required',
            'description' => 'required',
        ]);

        $data = $request->only(['branch_id', 'employee_id', 'start_time', 'end_time', 'description']);

        $data['compani_id'] = $userCompany->id;

        Shift::where('id', $id)->update($data);

        Cache::forget('shifts');

        return redirect(route('shift'))->with('success', 'Shift successfully updated!');
    }

    public function destroy($id)
    {
        Shift::destroy($id);

        Cache::forget('shifts');

        return redirect(route('shift'))->with('success', 'Shiift successfully deleted!');
    }
}
