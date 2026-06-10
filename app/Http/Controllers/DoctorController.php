<?php

namespace App\Http\Controllers;

use App\Models\Doctor;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class DoctorController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $doctors = DB::table('doctors')->get();
        return view('doctors.index', compact('doctors'));
    }

    public function getEditFormB(Request $request)
    {
        $doctor = Doctor::findOrFail($request->id);

        return response()->json([
            'status' => 'oke',
            'msg' => view('doctors.getEditFormB', compact('doctor'))->render()
        ], 200);
    }

    public function saveDataUpdate(Request $request)
    {
        $validated = $request->validate([
            'id' => 'required|exists:doctors,id',
            'name' => 'required|string|max:255',
            'specialization' => 'nullable|string|max:255',
            'email' => 'required|email|unique:doctors,email,' . $request->id,
            'phone' => 'nullable|string|max:50',
        ]);

        $doctor = Doctor::findOrFail($validated['id']);
        $doctor->update([
            'name' => $validated['name'],
            'specialization' => $validated['specialization'],
            'email' => $validated['email'],
            'phone' => $validated['phone'],
        ]);

        return response()->json([
            'status' => 'oke',
            'msg' => 'Doctor updated successfully.'
        ], 200);
    }

    public function deleteData(Request $request)
    {
        try {
            $doctor = Doctor::findOrFail($request->id);
            $doctor->delete();

            return response()->json([
                'status' => 'oke',
                'msg' => 'Doctor removed successfully.'
            ], 200);
        } catch (\Exception $ex) {
            return response()->json([
                'status' => 'error',
                'msg' => 'Unable to delete doctor. Please check related data.'
            ], 500);
        }
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('doctors.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'specialization' => 'nullable|string|max:255',
            'email' => 'required|email|unique:doctors,email',
            'phone' => 'nullable|string|max:50',
        ]);

        Doctor::create($validated);

        return redirect()->route('doctors.index')->with('success', 'Doctor created successfully!');
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $doctor = Doctor::findOrFail($id);
        $doctor->delete();

        return redirect()->route('doctors.index')->with('success', 'Doctor deleted successfully!');
    }
}
