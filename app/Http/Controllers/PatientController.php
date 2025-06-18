<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Patient;

class PatientController extends Controller
{
    public function index(Request $request)
    {
        $query = Patient::with('transactions');

        if ($request->has('search') && $request->search) {
            $search = $request->search;
            $query->where(function($q) use ($search) {
                $q->where('name', 'like', "%{$search}%")
                  ->orWhere('nik', 'like', "%{$search}%");
            });
        }

        $patients = $query->latest()->get();

        return view('patients.index', compact('patients'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'nik' => 'required|string|size:16|unique:patients',
            'name' => 'required|string|max:255',
            'date_of_birth' => 'required|date',
            'phone' => 'required|string|max:20',
        ]);

        Patient::create($request->all());

        return redirect()->route('patients.index')
            ->with('success', 'Patient added successfully.');
    }

    public function update(Request $request, Patient $patient)
    {
        $request->validate([
            'nik' => 'required|string|size:16|unique:patients,nik,' . $patient->id,
            'name' => 'required|string|max:255',
            'date_of_birth' => 'required|date',
            'phone' => 'required|string|max:20',
        ]);

        $patient->update($request->all());

        return redirect()->route('patients.index')
            ->with('success', 'Patient updated successfully.');
    }

    public function destroy(Patient $patient)
    {
        $patient->delete();

        return redirect()->route('patients.index')
            ->with('success', 'Patient deleted successfully.');
    }
}