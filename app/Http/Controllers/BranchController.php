<?php

namespace App\Http\Controllers;

use App\Models\Branch;
use Illuminate\Http\Request;

class BranchController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
        $branches = Branch::query()->latest()->paginate(10);

        return view('admin.branch.index', compact('branches'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
        return view('admin.branch.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
        request()->validate([
            'name' => 'required|max:255',
            'location' => 'required',
        ]);

        $branch = new Branch;
        $branch->name = $request->input('name');
        $branch->location = $request->input('location');
        $branch->save();

        return redirect()->route('admin.branch.index')->with('success', 'Branch created successfully.');
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
        $branch = Branch::findOrFail($id);

        return view('admin.branch.view', compact('branch'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
        $branch = Branch::findOrFail($id);

        return view('admin.branch.edit', compact('branch'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
        $validated = $request->validate([
            'name' => 'required|max:255',
            'location' => 'required',
        ]);
        $branch = Branch::findOrFail($id);
        $branch->name = $validated['name'];
        $branch->location = $validated['location'];
        $branch->save();

        return redirect()->route('admin.branch.index')->with('success', 'Branch updated successfully.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
        Branch::destroy($id);

        return redirect()->route('admin.branch.index')->with('success', 'Branch deleted successfully.');
    }
}
