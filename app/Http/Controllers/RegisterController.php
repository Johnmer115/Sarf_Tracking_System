<?php

namespace App\Http\Controllers;

use App\Models\Account;
use App\Models\Branch;
use App\Models\Department;
use App\Models\Organization;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class RegisterController extends Controller
{
    /**
     * Show the public organization registration form.
     */
    public function showForm(): View
    {
        $branches = Branch::orderBy('name')->get(['id', 'name']);

        return view('log.register', compact('branches'));
    }

    /**
     * Handle the organization registration submission.
     * Creates a pending Account and a linked Organization record.
     */
    public function store(Request $request): RedirectResponse
    {
        $request->validate([
            'username' => 'required|string|max:255|unique:accounts,username',
            'password' => 'required|string|min:6|confirmed',
            'org_name' => 'required|string|max:255|unique:organizations,name',
            'department_id' => 'required|exists:departments,id',
        ]);

        // Create the account as pending — must be approved by admin
        $account = Account::create([
            'username' => $request->username,
            'password' => bcrypt($request->password),
            'usertype' => 'user',
            'status' => 'pending',
        ]);

        // Create the linked organization record
        Organization::create([
            'name' => $request->org_name,
            'account_id' => $account->id,
            'department_id' => $request->department_id,
        ]);

        return redirect()->route('login')
            ->with('success', 'Registration submitted! Your account is awaiting admin approval before you can log in.');
    }

    /**
     * Return departments filtered by branch — used by the AJAX cascade dropdown.
     */
    public function getDepartments(Request $request): JsonResponse
    {
        $departments = Department::where('branch_id', $request->branch_id)
            ->orderBy('name')
            ->get(['id', 'name']);

        return response()->json($departments);
    }
}
