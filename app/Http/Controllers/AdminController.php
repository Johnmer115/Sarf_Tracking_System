<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class AdminController extends Controller
{
    /**
     * Dashboard action - routes users based on their usertype
     */
    public function dashboard(Request $request)
    {
        if (! auth()->check()) {
            return redirect()->route('login');
        }

        $usertype = auth()->user()->usertype;

        // Define usertype to view mapping
        $usertypeViews = [
            'admin' => 'admin.ad-Dashboard',
            'user' => 'user.dashboard',
            // Add more user types here in the future
            // 'manager' => 'manager.dashboard',
            // 'staff' => 'staff.dashboard',
        ];

        if (! array_key_exists($usertype, $usertypeViews)) {
            abort(403, 'Unauthorized access. Unknown user type.');
        }

        return view($usertypeViews[$usertype]);
    }

    /**
     * Check if user is admin
     */
    public function isAdmin(): bool
    {
        return auth()->check() && auth()->user()->usertype === 'admin';
    }
}
