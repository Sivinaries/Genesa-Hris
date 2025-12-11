<?php

namespace App\Http\Controllers;

use App\Models\Leave;
use App\Models\Employee;
use App\Models\ActivityLog;
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

        $cacheKey = "leaves_{$userCompany->id}";

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
            'employee_id' => 'required|exists:employees,id',
            'start_date'  => 'required|date',
            'end_date'    => 'required|date|after_or_equal:start_date',
            'type'        => 'required|string',
            'reason'      => 'required|string',
            'status'      => 'required|string',
        ]);

        $data['compani_id'] = $userCompany->id;

        Leave::create($data);

        $employee = Employee::find($request->employee_id);

        $this->logActivity(
            'Create Leave',
            "Membuat leave baru untuk {$employee->name}",
            $userCompany->id
        );

        $this->clearCache($userCompany->id);

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

        $leave = Leave::findOrFail($id);

        $leave->update($data);

        $name = Employee::find($request->employee_id->name);

        $this->logActivity(
            'Update Leave',
            "{$name}",
            $userCompany->id
        );

        $this->clearCache($userCompany->id);

        return redirect(route('leave'))->with('success', 'Leave successfully updated!');
    }

    public function destroy($id)
    {
        $userCompany = auth()->user()->compani;

        $leave = Leave::where('id', $id)->where('compani_id', $userCompany->id)->first();

        if ($leave) {
            $name = $leave->employee->name;
            $leave->delete();

            $this->logActivity(
                'Delete Leave',
                "{$name}",
                $userCompany->id
            );
        }

        $this->clearCache($userCompany->id);

        return redirect(route('leave'))->with('success', 'Leave successfully deleted!');
    }

    private function clearCache($companyId)
    {
        Cache::forget("leaves_{$companyId}");
    }

    private function logActivity($type, $description, $companyId)
    {
        ActivityLog::create([
            'user_id'       => Auth::id(),
            'compani_id'    => $companyId,
            'activity_type' => $type,
            'description'   => $description,
            'created_at'    => now(),
        ]);

        Cache::forget("activities_{$companyId}");
    }
}
