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
use App\Livewire\Teams\TeamsRanking;

use App\Livewire\Players\PlayerView;
use App\Livewire\Players\PlayerForm;
use App\Livewire\Players\PlayersRanking;

use App\Livewire\Tournaments\TournamentView;
use App\Livewire\Tournaments\TournamentForm;
use App\Livewire\Tournaments\TournamentCategoryView;
use App\Livewire\Tournaments\TournamentCategoryForm;
use App\Livewire\Tournaments\TournamentCategoryKnockoutMap;

use App\Livewire\Matches\MatchesView;
use App\Livewire\Matches\MatchesForm;
use App\Livewire\Matches\MatchDetails;

use App\Livewire\MatchScoringForm;
use App\Livewire\Matches\KnockoutStageView;

use App\Livewire\Tournaments\TournamentTypeView;
use App\Livewire\Tournaments\TournamentTypeForm;

use App\Livewire\HeroSection\HeroSectionIndex;
use App\Livewire\HeroSection\HeroSectionForm;

use App\Livewire\Blogs\BlogIndex;
use App\Livewire\Blogs\BlogForm;

use App\Livewire\Courts\CourtIndex;
use App\Livewire\Courts\CourtForm;

use App\Livewire\GroupStages\GroupStageRanking;

use App\Http\Controllers\CronJobController;

use App\Http\Controllers\HomePageController;
use App\Http\Controllers\TeamController;
use App\Http\Controllers\MatchController;
use App\Http\Controllers\PlayerController;
use App\Http\Controllers\TournamentController;

// |--------------------------------------------------------------------------|
// | Backend - Start                                                          |
// |--------------------------------------------------------------------------|
Route::get('/login', Login::class)->name('login');

Route::get('/close-month-reminder', [CronJobController::class, 'closeMonthReminder']);

Route::middleware('auth')->prefix('admin')->group(function () {

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
        Route::get('/rankings', TeamsRanking::class)->name('teams.rankings');
    });

    // |--------------------------------------------------------------------------
    // |Players
    // |--------------------------------------------------------------------------

    Route::group(['prefix' => 'players'], function() {
        Route::get('/', PlayerView::class)->name('players');
        Route::get('/create', PlayerForm::class)->name('players.create');
        Route::get('/edit/{id}', PlayerForm::class)->name('players.edit');
        Route::get('/view/{id}/{status}', PlayerForm::class)->name('players.view');
        Route::get('/rankings', PlayersRanking::class)->name('players.rankings');
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

        Route::get('/knockout-stages/{categoryId}', KnockoutStageView::class)->name('knockoutStage.view');

        Route::group(['prefix' => 'group-stages'], function() {
            Route::get('/{categoryId}', GroupStageRanking::class)->name('group-stages.rankings');
        });
    });

    // Matches
    Route::group(['prefix' => 'my-matches'], function() {
        Route::get('/', MatchesView::class)->name('matches');
        Route::get('/view/{id}/{status}', MatchesForm::class)->name('matches.view');
        Route::get('{matchId}/scoring', MatchScoringForm::class)->name('matches.scoring');
        Route::get('/{matchId}/details', MatchDetails::class)->name('matches.details');
    });

    Route::group(['prefix' => 'tournament-types'], function() {
        Route::get('/', TournamentTypeView::class)->name('types');
        Route::get('/edit/{typeId}', TournamentTypeForm::class)->name('types.edit');
    });

    // |--------------------------------------------------------------------------
    // | Hero Section
    // |--------------------------------------------------------------------------

    Route::group(['prefix' => 'hero-sections'], function() {
        Route::get('/', HeroSectionIndex::class)->name('hero-sections');
        Route::get('/create', HeroSectionForm::class)->name('hero-sections.create');
        Route::get('/edit/{id}', HeroSectionForm::class)->name('hero-sections.edit');
    });

    // |--------------------------------------------------------------------------
    // | Blogs
    // |--------------------------------------------------------------------------

    Route::group(['prefix' => 'blogs'], function() {
        Route::get('/', BlogIndex::class)->name('blogs');
        Route::get('/create', BlogForm::class)->name('blogs.create');
        Route::get('/edit/{id}', BlogForm::class)->name('blogs.edit');
    });

    // |--------------------------------------------------------------------------
    // | Courts
    // |--------------------------------------------------------------------------

    Route::group(['prefix' => 'courts'], function() {
        Route::get('/', CourtIndex::class)->name('courts');
        Route::get('/create', CourtForm::class)->name('courts.create');
        Route::get('/edit/{id}/{status?}', CourtForm::class)->name('courts.edit');
    });

});
// |--------------------------------------------------------------------------|
// | Backend - End                                                            |
// |--------------------------------------------------------------------------|

// |--------------------------------------------------------------------------|
// | Frontend - Start                                                         |
// |--------------------------------------------------------------------------|

Route::get('/home', [HomePageController::class, 'index'])->name('home');

Route::get('/teams', [TeamController::class, 'index'])->name('frontend.teams');
Route::get('/teams/{team}', [TeamController::class, 'view'])->name('frontend.teams.view');

Route::get('/matches', [MatchController::class, 'index'])->name('frontend.matches');
Route::post('/get-matches', [MatchController::class, 'getMatches'])->name('frontend.get-matches');
Route::get('/matches/{matchId}', [MatchController::class, 'view'])->name('frontend.matches.view');

Route::get('/players', [PlayerController::class, 'index'])->name('frontend.players');
Route::get('/players/{player}', [PlayerController::class, 'view'])->name('frontend.players.view');

Route::get('/tournaments/{levelCategoryId?}', [TournamentController::class, 'index'])->name('frontend.tournaments');
Route::post('/get-tournaments', [TournamentController::class, 'getTournaments'])->name('frontend.get-tournaments');
Route::get('/tournaments/categories/{categoryId}', [TournamentController::class, 'view'])->name('frontend.tournaments.categories.view');
// |--------------------------------------------------------------------------|
// | Frontend - End                                                           |
// |--------------------------------------------------------------------------|


Route::get('/', function () {
    return redirect('/home');
});

Route::get('/{any}', function () {
    return view('frontend.misc.404');
})->where('any', '.*');



