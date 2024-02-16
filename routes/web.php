<?php


// use App\Http\Livewire\Users\UserView;
// use App\Http\Livewire\Users\UserForm;
// use App\Http\Livewire\RolesPermissions\PermissionView;
// use App\Http\Livewire\RolesPermissions\RoleView;
// use App\Http\Controllers\DashboardController;
// use Illuminate\Support\Facades\Route;



use Illuminate\Support\Facades\Route;

use App\Livewire\Auth\Login;
use App\Livewire\DashboardView;
use App\Livewire\RolesPermissions\PermissionView;
use App\Livewire\RolesPermissions\RoleView;




Route::get('/login', Login::class)->name('login');

Route::get('/', function () {
    return view('welcome');
});


Route::middleware('auth')->group(function () {

    Route::get('/dashboard', DashboardView::class)->name('dashboard');
    Route::get('/permissions', PermissionView::class)->name('permissions');
    Route::get('/roles', RoleView::class)->name('roles');


    // Users
    // Route::get('/users', UserView::class)->name('users');

    // Route::group(['prefix' => 'users'], function() {
    //     Route::get('/', UserView::class)->name('users');
    //     Route::get('/create', UserForm::class)->name('users.create');
    //     Route::get('/edit/{id}', UserForm::class)->name('users.edit');
    //     Route::get('/view/{id}/{status}', UserForm::class)->name('users.view');
    // });

});
