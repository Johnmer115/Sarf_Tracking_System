<?php

namespace App\Http\Controllers;

use Illuminate\Contracts\View\View;

class AdminController extends Controller
{
    /**
     * Display the admin dashboard.
     */
    public function index(): View
    {
        return view('admin.index');
    }
}
