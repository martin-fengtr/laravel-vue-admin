<?php

use App\Http\Controllers\BadgeController;
use App\Http\Controllers\HoleController;
use App\Http\Controllers\MetaController;
use App\Http\Controllers\UserController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ProjectController;


/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
 */

Route::post('/login', [UserController::class, 'login'])->name('api.login');

Route::middleware(['auth:sanctum', 'verified'])->namespace('Api')->group(function () {
    Route::get('/meta/fetch', [MetaController::class, 'fetch'])->name('meta-fetch');
    Route::get('/hole/statuses', [HoleController::class, 'statuses'])->name('hole-statuses');
    Route::get('/badge/check/{uuid}', [BadgeController::class, 'check'])->name('badge-check');
    Route::post('/hole/save', [HoleController::class, 'save'])->name('hole-save');
    Route::post('/hole/replace', [HoleController::class, 'replaceBadge'])->name('hole-replace');
});

Route::post('/project/update/QRaccess', [ProjectController::class, 'updateQRfield']);

Route::get('/project/{hush}', [ProjectController::class, 'getInfoQR']);
