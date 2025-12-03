<?php

namespace App\Http\Controllers;

use App\Models\Compani;
use Illuminate\Http\Request;

class CompaniController extends Controller
{
    public function index()
    {
        $companis = Compani::all();

        return view('company', compact('companis'));
    }

    public function create()
    {
        return view('addcompany');
    }

    public function store(Request $request)
    {
        $user = auth()->user();

        $data = $request->validate([
            'name' => 'required|string|max:255',
            'no_telpon' => 'required|string|max:15', // Adjust the validation if needed
            'ktp' => 'required|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
            'atas_nama' => 'required|string|max:255',
            'bank' => 'required|string|max:255',
            'no_rek' => 'required|string|max:50',
            'company' => 'required|string|max:255',
            'location' => 'required|string|max:255',
        ]);

        $data['user_id'] = $user->id;
        $data['status'] = 'Settlement';

        if ($request->hasFile('ktp')) {
            $uploadedKtp = $request->file('ktp');
            $ktpName = time() . '_' . $uploadedKtp->getClientOriginalName(); // Prefix with timestamp for uniqueness
            $ktpPath = $uploadedKtp->storeAs('ktp', $ktpName, 'public');
            $data['ktp'] = $ktpPath; // Path is relative to 'storage/app/public'
        }

        Compani::create($data);

        return redirect(route('dashboard'))->with('success', 'Company registered successfully!');
    }

    public function edit($id)
    {
        $company = Compani::find($id);
        return view('editcompany', compact('company'));
    }

    public function update(Request $request, $id)
    {
        $userCompany = auth()->user()->compani;

        $request->validate([
            'name' => 'required|string|max:255',
            'no_telpon' => 'required|string|max:15', // Adjust the validation if needed
            'ktp' => 'required|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
            'atas_nama' => 'required|string|max:255',
            'bank' => 'required|string|max:255',
            'no_rek' => 'required|string|max:50',
            'company' => 'required|string|max:255',
            'location' => 'required|string|max:255',
        ]);

        $data = $request->only(['name','no_telpon','ktp','atas_nama','bank','no_rek','company','location']);

        $data['store_id'] = $userCompany->id;

        Compani::where('id', $id)->update($data);

        return redirect(route('dashboard'))->with('success', 'Company successfully updated!');
    }

    public function destroy($id)
    {
        Compani::destroy($id);

        return redirect(route('company'))->with('success', 'Company Berhasil Dihapus !');
    }
}
