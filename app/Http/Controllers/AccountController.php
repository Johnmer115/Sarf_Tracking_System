<?php

namespace App\Http\Controllers;

use App\Models\Account;
use Illuminate\Http\Request;

class AccountController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $accounts = Account::query()->latest()->paginate(10);

        return view('admin.account.index', compact('accounts'));
    }

    public function create()
    {
        return view('admin.account.create');
    }

    public function store(Request $request)
    {
        request()->validate([
            'username' => 'required|max:255',
            'usertype' => 'required',
            'password' => 'required|min:6',
            'organization' => 'nullable',
            'status' => 'nullable',
        ]);

        $account = new Account;
        $account->username = $request->input('username');
        $account->usertype = $request->input('usertype');
        $account->password = bcrypt($request->input('password'));
        $account->organization = $request->input('organization');
        $account->status = $request->input('status') ?? 'active';
        $account->save();

        return redirect()->route('admin.account.index')->with('success', 'Account created successfully.');
    }

    public function show(string $id)
    {
        $account = Account::findOrFail($id);

        return view('admin.account.view', compact('account'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
        $account = Account::findOrFail($id);

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
            'organization' => 'nullable',
            'status' => 'nullable',
        ]);

        $account = Account::findOrFail($id);
        $account->username = $validated['username'];
        $account->usertype = $validated['usertype'];
        $account->organization = $validated['organization'] ?? null;
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
        //
        Account::destroy($id);

        return redirect()->route('admin.account.index')->with('success', 'Account deleted successfully.');
    }
}
