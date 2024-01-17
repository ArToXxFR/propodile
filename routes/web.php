<?php

use App\Http\Controllers\LoginRegisterController;
use App\Http\Controllers\ProjectController;
use App\Http\Controllers\TeamController;
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

Route::get('/', [ProjectController::class, 'index'])->name('home');

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

    Route::post('/project/create', [ProjectController::class, 'create'])
    ->name('project.create.post');

    Route::delete('/project/delete/{id}', [ProjectController::class, 'delete'])
    ->name('project.delete');

    Route::put('/project/update/{id}', [ProjectController::class, 'update'])
    ->name('project.update');

    Route::get('/project/update/{id}', [ProjectController::class, 'updateForm'])->name('project.update.form');

    Route::post('/team/join', [TeamController::class, 'sendInvitation'])
    ->name('team.join');

    Route::get('/team/accept/{id}', [TeamController::class, 'acceptInvitation'])
    ->name('team.accept');
});

Route::get('/project/show', [ProjectController::class, 'index'])
->name('project.show');
Route::get('/project/show/{id}', [ProjectController::class, 'show'])
->name('project.show');

