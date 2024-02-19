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
<<<<<<< HEAD
use App\Http\Controllers\DashboardController;
=======

>>>>>>> 39de77df6b66b9bbe8026dc51138a5f57ac39b0a

Route::get('/login', Login::class)->name('login');

Route::get('/', function () {
    return view('welcome');
<<<<<<< HEAD
});

Route::middleware('auth')->group(function () {
Route::get('/dashboard', DashboardView::class)->name('dashboard');
Route::get('/permissions', PermissionView::class)->name('permissions');
Route::get('/roles', RoleView::class)->name('roles');

Route::group(['prefix' => 'users'], function() {
    Route::get('/', UserView::class)->name('users');
    Route::get('/create', UserForm::class)->name('users.create');
    Route::get('/edit/{id}', UserForm::class)->name('users.edit');
    Route::get('/view/{id}/{status}', UserForm::class)->name('users.view');
});

Route::get('/test', Test::class)->name('Test');
Route::get('/pages', [DashboardController::class, 'pages'])->name('pages');

});



=======
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
>>>>>>> 39de77df6b66b9bbe8026dc51138a5f57ac39b0a
