<?php

namespace App\Http\Controllers;

use App\Models\Account;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class AuthController extends Controller
{
    /**
     * Handle login request
     */
    public function login(Request $request): RedirectResponse
    {
        $credentials = $request->validate([
            'account' => 'required|string',
            'password' => 'required|string',
        ]);

        $account = Account::query()
            ->where('username', $credentials['account'])
            ->first();

        if (! $account || ! Hash::check($credentials['password'], $account->password)) {
            return back()->withErrors([
                'account' => 'The provided credentials do not match our records.',
            ])->onlyInput('account');
        }

        if ($account->status !== 'active') {
            return back()->withErrors([
                'account' => 'Your account is pending admin approval. Please wait for confirmation.',
            ])->onlyInput('account');
        }

        if (! in_array($account->usertype, ['admin', 'user'], true)) {
            return back()->withErrors([
                'account' => 'This account has an invalid user type.',
            ])->onlyInput('account');
        }

        Auth::login($account, $request->boolean('remember'));
        $request->session()->regenerate();

        if ($account->usertype === 'admin') {
            return redirect()->route('admin.index');
        }

        return redirect()->route('welcome');
    }

    /**
     * Handle logout request
     */
    public function logout(Request $request): RedirectResponse
    {
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect()->route('login');
    }
}
