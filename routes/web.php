<?php

use App\Http\Controllers\DomainController;
use Illuminate\Support\Facades\Route;
/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

Route::get('/', function () {
    return view('welcome');
});

Route::middleware([
    'auth:sanctum',
    config('jetstream.auth_session'),
    'verified'
])->group(function () {
    Route::get('/dashboard', [DomainController::class,'getAllDomains'])->name('dashboard');

    Route::get("/new-server", function () {
       return view("new-server");
    })->name('new-server');

    Route::post('/domain', [DomainController::class, 'store'])->name('domain.store');
});
