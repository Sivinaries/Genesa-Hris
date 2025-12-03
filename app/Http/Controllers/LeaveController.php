<?php

namespace App\Http\Controllers;

use App\Models\Employee;
use App\Models\Leave;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Cache;

class LeaveController extends Controller
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

        $cacheKey = 'leaves';

        $leaves = Cache::remember($cacheKey, now()->addMinutes(60), function () use ($userCompany) {
            return $userCompany->leaves()->with('employee')->get();
        });

        $employee = $userCompany->employees()->get();

        return view('leave', compact('leaves', 'employee'));
    }

    public function store(Request $request)
    {
        $userCompany = auth()->user()->compani;

        $data = $request->validate([
            'employee_id' => 'required',
            'start_date' => 'required',
            'end_date' => 'required',
            'type' => 'required',
            'reason' => 'required',
            'status' => 'required',
        ]);

        $data['compani_id'] = $userCompany->id;

        Leave::create($data);

        Cache::forget('leaves');

        return redirect(route('leave'))->with('success', 'Leave successfully created!');
    }

    public function update(Request $request, $id)
    {
        $userCompany = auth()->user()->compani;

        $request->validate([
            'employee_id' => 'required',
            'start_date' => 'required',
            'end_date' => 'required',
            'type' => 'required',
            'reason' => 'required',
            'status' => 'required',
        ]);

        $data = $request->only(['employee_id', 'start_date', 'end_date', 'type', 'reason', 'status']);

        $data['compani_id'] = $userCompany->id;

        Leave::where('id', $id)->update($data);

        Cache::forget('leaves');

        return redirect(route('leave'))->with('success', 'Leave successfully updated!');
    }

    public function destroy($id)
    {
        Leave::destroy($id);

        Cache::forget('leaves');

        return redirect(route('leave'))->with('success', 'Leave successfully deleted!');
    }
}
