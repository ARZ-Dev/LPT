<?php

use Illuminate\Support\Facades\Route;

use App\Livewire\Auth\Login;
use App\Livewire\Test;
use App\Livewire\DashboardView;
use App\Livewire\Users\UserView;
use App\Livewire\Users\UserForm;


use App\Livewire\RolesPermissions\PermissionView;
use App\Livewire\RolesPermissions\RoleView;
// use App\Controllers\DashboardController;

Route::get('/login', Login::class)->name('login');
Route::get('/dashboard', DashboardView::class)->name('dashboard');

Route::get('/permissions', PermissionView::class)->name('permissions');
Route::get('/roles', RoleView::class)->name('roles');



Route::get('/test', Test::class)->name('Test');



Route::get('/', function () {
    return view('welcome');
});
