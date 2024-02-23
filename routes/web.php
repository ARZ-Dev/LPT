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

use App\Livewire\Pcash\CurrencyForm;
use App\Livewire\Pcash\CurrencyView;

use App\Livewire\Pcash\TillForm;
use App\Livewire\Pcash\TillView;

use App\Livewire\Pcash\PaymentForm;
use App\Livewire\Pcash\PaymentView;

use App\Livewire\Pcash\ReceiptForm;
use App\Livewire\Pcash\ReceiptView;

use App\Livewire\Pcash\TransferForm;
use App\Livewire\Pcash\TransferView;


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

// |--------------------------------------------------------------------------
// |Currency 
// |--------------------------------------------------------------------------

Route::group(['prefix' => 'currency'], function() {
    Route::get('/', CurrencyView::class)->name('currency');
    Route::get('/create', CurrencyForm::class)->name('currency.create');
    Route::get('/edit/{id}', CurrencyForm::class)->name('currency.edit');
    Route::get('/view/{id}/{status}', CurrencyForm::class)->name('currency.view');
});

// |--------------------------------------------------------------------------
// |Till 
// |--------------------------------------------------------------------------

Route::group(['prefix' => 'till'], function() {
    Route::get('/', TillView::class)->name('till');
    Route::get('/create', TillForm::class)->name('till.create');
    Route::get('/edit/{id}', TillForm::class)->name('till.edit');
    Route::get('/view/{id}/{status}', TillForm::class)->name('till.view');
});


// |--------------------------------------------------------------------------
// |Payment 
// |--------------------------------------------------------------------------

    Route::group(['prefix' => 'payment'], function() {
        Route::get('/', PaymentView::class)->name('payment');
        Route::get('/create', PaymentForm::class)->name('payment.create');
        Route::get('/edit/{id}', PaymentForm::class)->name('payment.edit');
        Route::get('/view/{id}/{status}', PaymentForm::class)->name('payment.view');
    });

// |--------------------------------------------------------------------------
// |Receipt 
// |--------------------------------------------------------------------------

    Route::group(['prefix' => 'receipt'], function() {
        Route::get('/', ReceiptView::class)->name('receipt');
        Route::get('/cre  ate', ReceiptForm::class)->name('receipt.create');
        Route::get('/edit/{id}', ReceiptForm::class)->name('receipt.edit');
        Route::get('/view/{id}/{status}', ReceiptForm::class)->name('receipt.view');
});

// |--------------------------------------------------------------------------
// |Receipt 
// |--------------------------------------------------------------------------

Route::group(['prefix' => 'transfer'], function() {
    Route::get('/', TransferView::class)->name('transfer');
    Route::get('/create', TransferForm::class)->name('transfer.create');
    Route::get('/edit/{id}', TransferForm::class)->name('transfer.edit');
    Route::get('/view/{id}/{status}', TransferForm::class)->name('transfer.view');
});


});



