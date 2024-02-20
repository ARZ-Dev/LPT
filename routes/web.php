<?php

use Illuminate\Support\Facades\Route;

use App\Livewire\Auth\Login;
use App\Livewire\Test;
use App\Livewire\DashboardView;
use App\Livewire\Users\UserView;
use App\Livewire\Users\UserForm;


use App\Livewire\RolesPermissions\PermissionView;
use App\Livewire\RolesPermissions\RoleView;
use App\Http\Controllers\DashboardController;

use App\Livewire\Pcash\CategoryForm;
use App\Livewire\Pcash\CategoryView;

Route::get('/login', Login::class)->name('login');

Route::get('/', function () {
    return view('welcome');
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


// |--------------------------------------------------------------------------
// |CATEGORY 
// |--------------------------------------------------------------------------

Route::group(['prefix' => 'category'], function() {
    Route::get('/', CategoryView::class)->name('category');
    Route::get('/create', CategoryForm::class)->name('category.create');
    Route::get('/edit/{id}', CategoryForm::class)->name('category.edit');
    Route::get('/view/{id}/{status}', CategoryForm::class)->name('category.view');
});

});



