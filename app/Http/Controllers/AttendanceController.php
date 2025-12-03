<?php

namespace App\Http\Controllers;

use App\Models\Attendance;
use App\Models\Employee;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Cache;

class AttendanceController extends Controller
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

        $cacheKey = 'attendances';

        $attendances = Cache::remember($cacheKey, now()->addMinutes(60), function () use ($userCompany) {
            return $userCompany->attendances()->with('employee')->get();
        });

        $employee = $userCompany->employees()->get();

        return view('attendance', compact('attendances', 'employee'));
    }

    public function store(Request $request)
    {
        $userCompany = auth()->user()->compani;

        $data = $request->validate([
            'employee_id' => 'required',
            'attendance_date' => 'required',
            'clock_in' => 'required',
            'clock_out' => 'required',
            'status' => 'required',
        ]);

        $data['compani_id'] = $userCompany->id;

        Attendance::create($data);

        Cache::forget('attendances');

        return redirect(route('attendance'))->with('success', 'Attendance successfully created!');
    }

    public function update(Request $request, $id)
    {
        $userCompany = auth()->user()->compani;

        $request->validate([
            'employee_id' => 'required',
            'attendance_date' => 'required',
            'clock_in' => 'required',
            'clock_out' => 'required',
            'status' => 'required',
        ]);

        $data = $request->only(['employee_id', 'attendance_date', 'clock_in', 'clock_out', 'status']);

        $data['compani_id'] = $userCompany->id;

        Attendance::where('id', $id)->update($data);

        Cache::forget('attendances');

        return redirect(route('attendance'))->with('success', 'Attendance successfully updated!');
    }

    public function destroy($id)
    {
        Attendance::destroy($id);

        Cache::forget('attendances');

        return redirect(route('attendance'))->with('success', 'Attendance successfully deleted!');
    }
}
