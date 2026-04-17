<?php

use App\Http\Controllers\AccountController;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\BranchController;
use App\Http\Controllers\DepartmentController;
use App\Http\Controllers\OrganizationController;
use App\Http\Controllers\RegisterController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('log.login');
})->name('login');

Route::post('/login', [AuthController::class, 'login'])->name('login.attempt');
Route::post('/logout', [AuthController::class, 'logout'])->name('logout');

// Public registration routes for organizations
Route::get('/register', [RegisterController::class, 'showForm'])->name('register');
Route::post('/register', [RegisterController::class, 'store'])->name('register.submit');
Route::get('/departments-by-branch', [RegisterController::class, 'getDepartments'])->name('departments.by.branch');

Route::middleware(['auth', 'admin'])
    ->prefix('admin')
    ->name('admin.')
    ->group(function () {
        Route::get('/', [AdminController::class, 'index'])->name('index');
        Route::resource('account', AccountController::class)->names('account');
        Route::patch('account/{id}/approve', [AccountController::class, 'approve'])->name('account.approve');
        Route::delete('account/{id}/reject', [AccountController::class, 'reject'])->name('account.reject');
        Route::resource('branch', BranchController::class)->names('branch');
        Route::resource('department', DepartmentController::class)->names('department');
        Route::resource('orgs', OrganizationController::class);
    });
