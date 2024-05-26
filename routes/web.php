<?php

use App\Http\Controllers\AdminController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\ProjectController;
use App\Http\Controllers\TeamController;
use App\Http\Middleware\CheckAdmin;
use Illuminate\Support\Facades\Route;
use App\Http\Middleware\CheckProjectLimit;
use App\Http\Middleware\IsUserBanned;

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

    Route::middleware([CheckProjectLimit::class])->group(function (){
        Route::post('/project/create', [ProjectController::class, 'create'])
            ->name('project.create.post');

        Route::get('/team/accept/{id}', [TeamController::class, 'acceptInvitation'])
            ->name('team.accept');
    });

    Route::get('/project/create', function() {
        return view('project.create');
    })->name('project.create.form');

    Route::delete('/project/delete/{id}', [ProjectController::class, 'delete'])
    ->name('project.delete');

    Route::put('/project/update/{id}', [ProjectController::class, 'update'])
    ->name('project.update');

    Route::get('/project/update/{id}', [ProjectController::class, 'updateForm'])
        ->name('project.update.form');

    Route::post('/team/join', [TeamController::class, 'sendInvitation'])
    ->name('team.join');


    Route::get('/dashboard', [TeamController::class, 'dashboard'])
        ->name('dashboard');

    Route::middleware([CheckAdmin::class])->group(function() {
        Route::get('/admin/users', [AdminController::class, 'listUsers'])
            ->name('admin.users');

        Route::get('/admin/users/banned', [AdminController::class, 'listBannedUsers'])
            ->name('admin.users.banned');

        Route::get('/admin/projects', [AdminController::class, 'listProjects'])
            ->name('admin.projects');

        Route::get('/admin/dashboard', [AdminController::class, 'dashboard'])
            ->name('admin.dashboard');

        Route::put('/admin/ban/{id}', [AdminController::class, 'ban'])
            ->name("admin.user.ban");

        Route::put('/admin/unban/{id}', [AdminController::class, 'unban'])
            ->name("admin.user.unban");

        Route::delete('/admin/delete/{id}', [AdminController::class, 'delete'])
            ->name("admin.user.delete");
    });
});

Route::get('/project/show/{id}', [ProjectController::class, 'show'])
->name('project.show');

Route::get('/{username}', [ProfileController::class, 'show'])
    ->name('user.show');


