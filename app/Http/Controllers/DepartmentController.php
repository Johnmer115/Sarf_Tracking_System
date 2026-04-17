<?php

namespace App\Http\Controllers;

use App\Models\Branch;
use App\Models\Department;
use Illuminate\Http\Request;

class DepartmentController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $departments = Department::query()
            ->with('branch')
            ->latest()
            ->paginate(10);

        return view('admin.department.index', compact('departments'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $branches = Branch::query()
            ->orderBy('name')
            ->get(['id', 'name', 'code']);

        return view('admin.department.create', compact('branches'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
        request()->validate([
            'name' => 'required|max:255',
            'branch_id' => 'required|exists:branches,id',
            'dept_dean' => 'nullable|max:255',

        ]);

        $department = new Department;
        $department->name = $request->input('name');
        $department->branch_id = $request->input('branch_id');
        $department->dept_dean = $request->input('dept_dean');
        $department->save();

        return redirect()->route('admin.department.index')->with('success', 'Department created successfully.');
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $department = Department::query()
            ->with('branch')
            ->findOrFail($id);

        return view('admin.department.view', compact('department'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $department = Department::query()
            ->with('branch')
            ->findOrFail($id);
        $branches = Branch::query()
            ->orderBy('name')
            ->get(['id', 'name', 'code']);

        return view('admin.department.edit', compact('department', 'branches'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $validated = $request->validate([
            'name' => 'required|max:255',
            'branch_id' => 'required|exists:branches,id',
            'dept_dean' => 'nullable|max:255',
        ]);

        $department = Department::findOrFail($id);
        $department->update($validated);

        return redirect()->route('admin.department.index')->with('success', 'Department updated successfully.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
        Department::destroy($id);

        return redirect()->route('admin.department.index')->with('success', 'Department deleted successfully.');
    }
}
