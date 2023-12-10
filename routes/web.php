<?php

use App\Http\Controllers\LoginRegisterController;
use App\Http\Controllers\Project\CreateController;
use App\Http\Controllers\Project\ShowController;
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

Route::get('/', [ShowController::class, 'showAll']);

Route::middleware([
    'auth:sanctum',
    config('jetstream.auth_session'),
    'verified',
])->group(function () {
    Route::get('/dashboard', function () {
        return view('dashboard');
    })->name('dashboard');
    Route::get('/project/create', function() {
        return view('project.create');
    })->name('project.create.get');
    
    Route::post('/project/create', [CreateController::class, 'createProject'])
    ->name('project.create.post');
});

Route::get('/project/show/{id}', [ShowController::class, 'showProject'])
->name('project.show');

