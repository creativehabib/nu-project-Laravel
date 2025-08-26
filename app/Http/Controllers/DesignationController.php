<?php

namespace App\Http\Controllers;

use App\Models\Designation;
use Illuminate\Database\QueryException;
use Illuminate\Http\Request;
use Illuminate\Http\RedirectResponse;
use Illuminate\View\View;

class DesignationController extends Controller
{
    public function index(): View
    {
        $designations = Designation::latest()->paginate(10);
        return view('dashboard.designations.index', compact('designations'));
    }

    public function store(Request $request): RedirectResponse
    {
        $request->validate(['name' => 'required|string|max:255']);
        Designation::create($request->only('name'));
        return back()->with('success', 'Designation created successfully');
    }

    public function update(Request $request, Designation $designation): RedirectResponse
    {
        $request->validate(['name' => 'required|string|max:255']);
        $designation->update($request->only('name'));
        return back()->with('success', 'Designation updated successfully');
    }

    public function destroy(Designation $designation): RedirectResponse
    {
        try {
            $designation->delete();
            return back()->with('success', 'Designation deleted successfully');
        } catch (QueryException $e) {
            return back()->with('error', 'Designation cannot be deleted because it is associated with an existing smart card.');
        }
    }
}
