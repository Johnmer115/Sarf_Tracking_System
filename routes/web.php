<?php

use App\Http\Controllers\AdminController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\UserController;
use App\Models\User;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('log/welcome');
});

Route::get('/login', function () {
    return view('log/login');
})->name('login');

Route::post('/login', [AuthController::class, 'login']);
Route::post('/logout', [AuthController::class, 'logout'])->middleware('auth');

Route::get('/dashboard', [AdminController::class, 'dashboard'])->name('dashboard')->middleware('auth');

// Admin Routes
Route::middleware('auth')->group(function () {
    Route::get('/admin', [UserController::class, 'index'])->name('admin');

    Route::get('/admin/users', [UserController::class, 'index'])->name('admin.users');

    Route::get('/admin/branches', function () {
        $users = User::paginate(10);

        return view('admin.ad-Branches', compact('users'));
    })->name('admin.branches');

    Route::get('/admin/departments', function () {
        $users = User::paginate(10);

        return view('admin.ad-Department', compact('users'));
    })->name('admin.departments');

    Route::get('/admin/organizations', function () {
        $users = User::paginate(10);

        return view('admin.ad-Orgs', compact('users'));
    })->name('admin.organizations');

    Route::get('/admin/sarf-report', function () {
        $users = User::paginate(10);

        return view('admin.ad-Sarf-report', compact('users'));
    })->name('admin.sarf-report');

    Route::get('/admin/sarf-checking', function () {
        $users = User::paginate(10);

        return view('admin.ad-Sarf-cheking', compact('users'));
    })->name('admin.sarf-checking');
});
