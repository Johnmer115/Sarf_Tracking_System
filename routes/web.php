<?php

use App\Http\Controllers\AccountController;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\BranchController;
use App\Http\Controllers\DepartmentController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('log.login');
})->name('login');

Route::post('/login', [AuthController::class, 'login'])->name('login.attempt');
Route::post('/logout', [AuthController::class, 'logout'])->name('logout');

Route::middleware(['auth', 'admin'])
    ->prefix('admin')
    ->name('admin.')
    ->group(function () {
        Route::get('/', [AdminController::class, 'index'])->name('index');
        Route::resource('account', AccountController::class)->names('account');
        Route::resource('branch', BranchController::class)->names('branch');
        Route::resource('department', DepartmentController::class)->names('department');
        Route::resource('orgs', OrganizationController::class)->names('organization');}
        );
