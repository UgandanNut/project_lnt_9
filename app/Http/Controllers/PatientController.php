<?php

namespace App\Http\Controllers;

use App\Models\Patient;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class PatientController extends Controller
{
    // INDEX
    public function index()
    {
        $patients = Patient::all();
        return view('patients.index', compact('patients'));
    }

    // CREATE
    public function create()
    {
        return view('patients.create');
    }

    // STORE
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required',
            'email' => 'required|email|unique:patients,email',
            'photo' => 'nullable|image|mimes:jpg,jpeg,png|max:2048'
        ]);

        $path = null;

        if ($request->hasFile('photo')) {
            $file = $request->file('photo');

            $filename = Str::uuid() . '.' . $file->getClientOriginalExtension();

            $path = $file->storeAs('patients', $filename, 'public');
        }

        Patient::create([
            'name' => $request->name,
            'email' => $request->email,
            'photo' => $path
        ]);

        return redirect()->route('patients.index');
    }

    // EDIT
    public function edit(Patient $patient)
    {
        return view('patients.edit', compact('patient'));
    }

    // UPDATE
    public function update(Request $request, Patient $patient)
    {
        $request->validate([
            'name' => 'required',
            'email' => 'required|email|unique:patients,email,' . $patient->id,
            'photo' => 'nullable|image|mimes:jpg,jpeg,png|max:2048'
        ]);

        if ($request->hasFile('photo')) {

            // Hapus foto lama
            if ($patient->photo && Storage::disk('public')->exists($patient->photo)) {
                Storage::disk('public')->delete($patient->photo);
            }

            $file = $request->file('photo');
            $filename = Str::uuid() . '.' . $file->getClientOriginalExtension();
            $path = $file->storeAs('patients', $filename, 'public');

            $patient->photo = $path;
        }

        $patient->name = $request->name;
        $patient->email = $request->email;
        $patient->save();

        return redirect()->route('patients.index');
    }

    // DELETE
    public function destroy(Patient $patient)
    {
        if ($patient->photo && Storage::disk('public')->exists($patient->photo)) {
            Storage::disk('public')->delete($patient->photo);
        }

        $patient->delete();

        return redirect()->route('patients.index');
    }
}