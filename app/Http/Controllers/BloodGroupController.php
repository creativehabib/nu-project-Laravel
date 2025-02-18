<?php

namespace App\Http\Controllers;

use App\Models\BloodGroup;
use Illuminate\Http\Request;

class BloodGroupController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $bloods = BloodGroup::latest()->paginate(5);
        return view('dashboard.blood-group.index', compact('bloods'));
    }

    // Fetch data for Edit
    public function edit($id)
    {
        $blood = BloodGroup::findOrFail($id);
        return response()->json($blood);
    }

    // Store
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'status' => 'required|boolean',
        ]);

        BloodGroup::create($request->all());

        return response()->json(['message' => 'Blood group added successfully!']);
    }

    // Update
    public function update(Request $request, $id)
    {
        $blood = BloodGroup::findOrFail($id);
        $request->validate([
            'name' => 'required|string|max:255',
            'status' => 'required|boolean',
        ]);

        $blood->update($request->all());

        return response()->json(['message' => 'Blood group updated successfully!']);
    }

    public function show(Request $request)
    {

    }

    // Delete
    public function destroy($id)
    {
        $blood = BloodGroup::findOrFail($id);
        $blood->delete();

        return response()->json(['message' => 'Blood Group Deleted Successfully!']);
    }

    public function updateStatus(Request $request, $id)
    {
        $blood = BloodGroup::findOrFail($id);
        $blood->status = $request->status;
        $blood->save();

        return response()->json(['message' => 'Status updated successfully!']);
    }
}
