<?php

namespace App\Http\Controllers;

use App\Models\Department;
use Illuminate\Database\QueryException;
use Illuminate\Http\Request;
use Illuminate\Http\RedirectResponse;
use Illuminate\View\View;

class DepartmentController extends Controller
{
    public function index(): View
    {
        $departments = Department::latest()->paginate(10);
        return view('dashboard.departments.index', compact('departments'));
    }

    public function store(Request $request): RedirectResponse
    {
        $request->validate(['name' => 'required|string|max:255']);
        Department::create($request->only('name'));
        return back()->with('success', 'Department created successfully');
    }

    public function update(Request $request, Department $department): RedirectResponse
    {
        $request->validate(['name' => 'required|string|max:255']);
        $department->update($request->only('name'));
        return back()->with('success', 'Department updated successfully');
    }

    public function destroy(Department $department): RedirectResponse
    {
        try {
            $department->delete();
            return back()->with('success', 'Department deleted successfully');
        } catch (QueryException $e) {
            return back()->with('error', 'Department cannot be deleted because it is associated with an existing smart card.');
        }
    }
}
