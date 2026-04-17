<?php

namespace App\Http\Controllers;

use App\Models\Organization;
use App\Models\Department;
use App\Models\Account;
use App\Models\Branch;
use Illuminate\Http\Request;

class OrganizationController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
        $organizations = Organization::query()
            ->with(['account', 'department' ])
            ->latest()->paginate(10);
        return view('admin.orgs.index', compact('organizations'));

    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
        $accounts = Account::query()
            ->orderBy('username')
            ->get(['id', 'username']);
        $departments = Department::query()
            ->orderBy('name')
            ->get(['id', 'name']);
        return view('admin.orgs.create', compact('accounts', 'departments'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
        request()->validate([
            'name' => 'required|max:255',
            'code' => 'required|max:50|unique:organizations,code',
            'account_id' => 'required|exists:accounts,id',
            'department_id' => 'required|exists:departments,id',
        ]);

        $organization = new Organization;
        $organization->name = $request->input('name');
        $organization->code = $request->input('code');
        $organization->account_id = $request->input('account_id');
        $organization->department_id = $request->input('department_id');
        $organization->save();

        return redirect()->route('admin.orgs.index')->with('success', 'Organization created successfully.');
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $organization = Organization::findOrFail($id);
        return view('admin.orgs.view', compact('organization'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
        $departments = Department::query()
            ->orderBy('name')
            ->get(['id', 'name']);
        $branches = Branch::query()
            ->orderBy('name')
            ->get(['id', 'name']);
        $organization = Organization::findOrFail($id);
        return view('admin.orgs.edit', compact('organization', 'departments', 'branches'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
            request()->validate([
                'name' => 'required|max:255',
                'department_id' => 'required|exists:departments,id',
                'branch_id' => 'required|exists:branches,id',
            ]);

            $organization = Organization::findOrFail($id);
            $organization->name = $request->input('name');
            $organization->department_id = $request->input('department_id');
            $organization->save();  

            return redirect()->route('admin.orgs.index')->with('success', 'Organization updated successfully.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //

        Organization::destroy($id);
        return redirect()->route('admin.orgs.index')->with('success', 'Organization deleted successfully.');
    }
}
