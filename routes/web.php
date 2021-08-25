<?php

use App\Http\Controllers\BadgeController;
use App\Http\Controllers\CompanyController;
use App\Http\Controllers\ProjectController;
use App\Http\Controllers\UserController;
use Illuminate\Support\Facades\Route;
use Inertia\Inertia;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
 */

Route::group(['middleware' => ['auth:sanctum', 'verified']], function () {
    Route::get('/', function () {
        return redirect()->route('dashboard');
    });

    Route::get('/dashboard', function () {
        return Inertia::render('Dashboard');
    })->name('dashboard');

    Route::get('/badge', [BadgeController::class, 'index'])->name('badge.index');
    Route::post('/badge/upload', [BadgeController::class, 'upload'])->name('badge.upload');

    Route::resources([
        'company' => CompanyController::class,
        'project' => ProjectController::class,
        'user' => UserController::class,
    ]);

    
});
