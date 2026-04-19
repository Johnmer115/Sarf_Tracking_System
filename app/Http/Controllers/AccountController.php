<?php

namespace App\Http\Controllers;

use App\Models\Account;
use App\Models\Branch;
use App\Models\Organization;
use Illuminate\Http\Request;

class AccountController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $accounts = Account::query()->with('organization')->latest()->paginate(10);

        return view('admin.account.index', compact('accounts'));
    }

    public function create()
    {
        $branches = Branch::orderBy('name')->get(['id', 'name']);

        return view('admin.account.create', compact('branches'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'username' => 'required|max:255|unique:accounts,username',
            'usertype' => 'required|in:admin,user',
            'password' => 'required|min:6',
            'department_id' => 'nullable|exists:departments,id',
        ]);

        $account = new Account;
        $account->username = $request->input('username');
        $account->usertype = $request->input('usertype');
        $account->password = bcrypt($request->input('password'));
        $account->status = 'active'; // Admin-created accounts are always active
        $account->save();

        // If usertype is 'user' and a department was selected, create the linked Organization
        if ($request->input('usertype') === 'user' && $request->filled('org_name') && $request->filled('department_id')) {
            Organization::create([
                'name' => $request->input('org_name'),
                'account_id' => $account->id,
                'department_id' => $request->input('department_id'),
            ]);
        }

        return redirect()->route('admin.account.index')->with('success', 'Account created successfully.');
    }

    public function show(string $id)
    {
        $account = Account::with('organization.department')->findOrFail($id);

        return view('admin.account.view', compact('account'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $account = Account::with('organization')->findOrFail($id);

        return view('admin.account.edit', compact('account'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $validated = $request->validate([
            'username' => 'required|max:255',
            'usertype' => 'required',
            'password' => 'nullable|min:6',
            'status' => 'nullable',
        ]);

        $account = Account::findOrFail($id);
        $account->username = $validated['username'];
        $account->usertype = $validated['usertype'];
        $account->status = $validated['status'] ?? 'active';

        if (filled($validated['password'] ?? null)) {
            $account->password = bcrypt($validated['password']);
        }

        $account->save();

        return redirect()->route('admin.account.index')->with('success', 'Account updated successfully.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        Account::destroy($id);

        return redirect()->route('admin.account.index')->with('success', 'Account deleted successfully.');
    }

    /**
     * Approve a pending account — sets status to active.
     */
    public function approve(string $id)
    {
        $account = Account::findOrFail($id);
        $account->status = 'active';
        $account->save();

        return redirect()->route('admin.account.index')->with('success', "Account '{$account->username}' has been approved.");
    }

    /**
     * Reject and delete a pending account.
     * The linked Organization is deleted automatically via onDelete('cascade').
     */
    public function reject(string $id)
    {
        $account = Account::findOrFail($id);
        $username = $account->username;
        $account->delete();

        return redirect()->route('admin.account.index')->with('success', "Registration for '{$username}' has been rejected and removed.");
    }
}
