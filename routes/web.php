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

use App\Livewire\Pcash\ExchangeForm;
use App\Livewire\Pcash\ExchangeView;

use App\Livewire\Pcash\ReportView;

use App\Livewire\Pcash\MonthlyEntryForm;
use App\Livewire\Pcash\MonthlyEntryView;

use App\Livewire\Teams\TeamView;
use App\Livewire\Teams\TeamForm;

use App\Livewire\Players\PlayerView;
use App\Livewire\Players\PlayerForm;

use App\Livewire\Tournaments\TournamentView;
use App\Livewire\Tournaments\TournamentForm;
use App\Livewire\Tournaments\TournamentCategoryView;
use App\Livewire\Tournaments\TournamentCategoryForm;
use App\Livewire\Tournaments\TournamentCategoryKnockoutMap;

use App\Livewire\Matches\MatchesView;
use App\Livewire\Matches\MatchesForm;

use App\Livewire\Matches\knockoutStageView;



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
    // | Monthly Openings / Closings
    // |--------------------------------------------------------------------------

    Route::group(['prefix' => 'monthly-openings-closings'], function() {
        Route::get('/', MonthlyEntryView::class)->name('monthly-openings-closings');
        Route::get('/create', MonthlyEntryForm::class)->name('monthly-openings-closings.create');
        Route::get('/close/{id}', MonthlyEntryForm::class)->name('monthly-openings-closings.edit');
        Route::get('/view/{id}/{status}', MonthlyEntryForm::class)->name('monthly-openings-closings.view');
    });


    // |--------------------------------------------------------------------------
    // | Payment
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
        Route::get('/create', ReceiptForm::class)->name('receipt.create');
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
        Route::get('/confirm/{id}/{status}', TransferForm::class)->name('transfer.confirm');
    });

    // |--------------------------------------------------------------------------
    // |Exchange
    // |--------------------------------------------------------------------------

    Route::group(['prefix' => 'exchange'], function() {
        Route::get('/', ExchangeView::class)->name('exchange');
        Route::get('/create', ExchangeForm::class)->name('exchange.create');
        Route::get('/edit/{id}', ExchangeForm::class)->name('exchange.edit');
        Route::get('/view/{id}/{status}', ExchangeForm::class)->name('exchange.view');
    });

    // |--------------------------------------------------------------------------
    // |Report
    // |--------------------------------------------------------------------------

    Route::group(['prefix' => 'petty-cash-summary'], function() {
        Route::get('/', ReportView::class)->name('petty-cash-summary');

    });

    // |--------------------------------------------------------------------------
    // |Teams
    // |--------------------------------------------------------------------------

    Route::group(['prefix' => 'teams'], function() {
        Route::get('/', TeamView::class)->name('teams');
        Route::get('/create', TeamForm::class)->name('teams.create');
        Route::get('/edit/{id}', TeamForm::class)->name('teams.edit');
        Route::get('/view/{id}/{status}', TeamForm::class)->name('teams.view');
    });

    // |--------------------------------------------------------------------------
    // |Players
    // |--------------------------------------------------------------------------

    Route::group(['prefix' => 'players'], function() {
        Route::get('/', PlayerView::class)->name('players');
        Route::get('/create', PlayerForm::class)->name('players.create');
        Route::get('/edit/{id}', PlayerForm::class)->name('players.edit');
        Route::get('/view/{id}/{status}', PlayerForm::class)->name('players.view');
    });

    // |--------------------------------------------------------------------------
    // |Tournaments
    // |--------------------------------------------------------------------------

    Route::group(['prefix' => 'tournaments'], function() {
        // Tournaments
        Route::get('/', TournamentView::class)->name('tournaments');

        Route::get('/create', TournamentForm::class)->name('tournaments.create');
        Route::get('/edit/{id}', TournamentForm::class)->name('tournaments.edit');
        Route::get('/view/{id}/{status}', TournamentForm::class)->name('tournaments.view');

        // Tournament Categories
        Route::get('/{tournamentId}/categories', TournamentCategoryView::class)->name('tournaments-categories');
        Route::get('{tournamentId}/categories/{categoryId}/edit', TournamentCategoryForm::class)->name('tournaments-categories.edit');
        Route::get('{tournamentId}/categories/{categoryId}/view/{status}', TournamentCategoryForm::class)->name('tournaments-categories.view');
        Route::get('categories/{categoryId}/knockout-bracket', TournamentCategoryKnockoutMap::class)->name('tournaments-categories.knockoutMap');

    });

    Route::group(['prefix' => 'matches'], function() {
        Route::get('/{categoryId}', MatchesView::class)->name('matches');
        Route::get('/view/{id}/{status}', MatchesForm::class)->name('matches.view');
        Route::get('/knockoutStage/{id}', KnockoutStageView::class)->name('knockoutStage.view');


        
    });




});



