<?php

use Illuminate\Support\Facades\Route;
use App\Domains\Auth\Controllers\AuthController;
use App\Domains\Project\Controllers\ProjectController;
use App\Domains\Classroom\Controllers\ClassroomController;
use App\Domains\User\Controllers\UserController;
use App\Domains\Participant\Controllers\ParticipantController;
use App\Domains\Volunteer\Controllers\VolunteerController;
use App\Domains\Event\Controllers\EventController;
use App\Domains\Attendance\Controllers\AttendanceController;

/*
|--------------------------------------------------------------------------
| 🔓 AUTENTICAÇÃO (WEB)
|--------------------------------------------------------------------------
*/

Route::view('/login', 'auth.login')->name('login');
Route::view('/register', 'auth.register')->name('register');
Route::post('/login', [AuthController::class, 'login'])->name('login.post');

/*
|--------------------------------------------------------------------------
| 🔐 ROTAS PROTEGIDAS (WEB)
|--------------------------------------------------------------------------
*/

Route::middleware(['auth'])->group(function () {

    Route::get('/', function () {
        return redirect()->route('projects');
    });

    Route::get('/projects', [ProjectController::class, 'index'])->name('projects');
    Route::get('/projects/create', [ProjectController::class, 'create'])->name('projects.create');
    Route::post('/projects', [ProjectController::class, 'store'])->name('projects.store');
    Route::get('/projects/{project}/edit', [ProjectController::class, 'edit'])->name('projects.edit');
    Route::put('/projects/{project}', [ProjectController::class, 'update'])->name('projects.update');
    Route::delete('/projects/{project}', [ProjectController::class, 'destroy'])->name('projects.destroy');

    Route::get('/classrooms', [ClassroomController::class, 'index'])->name('classrooms');
    Route::get('/classrooms/create', [ClassroomController::class, 'create'])->name('classrooms.create');
    Route::post('/classrooms', [ClassroomController::class, 'store'])->name('classrooms.store');
    Route::get('/classrooms/{classroom}/edit', [ClassroomController::class, 'edit'])->name('classrooms.edit');
    Route::put('/classrooms/{classroom}', [ClassroomController::class, 'update'])->name('classrooms.update');
    Route::delete('/classrooms/{classroom}', [ClassroomController::class, 'destroy'])->name('classrooms.destroy');


        Route::get('/attendances', [AttendanceController::class, 'index'])->name('attendances');
    Route::get('/attendances/create', [AttendanceController::class, 'create'])->name('attendances.create');
    Route::post('/attendances', [AttendanceController::class, 'store'])->name('attendances.store');
    Route::get('/attendances/{attendance}/edit', [AttendanceController::class, 'edit'])->name('attendances.edit');
    Route::put('/attendances/{attendance}', [AttendanceController::class, 'update'])->name('attendances.update');
    Route::delete('/attendances/{attendance}', [AttendanceController::class, 'destroy'])->name('attendances.destroy');

    /*
    |--------------------------------------------------------------------------
    | PARTICIPANTES
    |--------------------------------------------------------------------------
    */
    Route::get('/participants', function () {
        return view('participants.index');
    })->name('participants');

    /*
    |--------------------------------------------------------------------------
    | VOLUNTÁRIOS
    |--------------------------------------------------------------------------
    */
    Route::get('/volunteers', [VolunteerController::class, 'index'])->name('volunteers');
    Route::get('/volunteers/create', [VolunteerController::class, 'create'])->name('volunteers.create');
    Route::post('/volunteers', [VolunteerController::class, 'store'])->name('volunteers.store');
    Route::get('/volunteers/{volunteer}/edit', [VolunteerController::class, 'edit'])->name('volunteers.edit');
    Route::put('/volunteers/{volunteer}', [VolunteerController::class, 'update'])->name('volunteers.update');
    Route::delete('/volunteers/{volunteer}', [VolunteerController::class, 'destroy'])->name('volunteers.destroy');

    /*
    |--------------------------------------------------------------------------
    | EVENTOS
    |--------------------------------------------------------------------------
    */
    Route::get('/events', [EventController::class, 'index'])->name('events');
    Route::get('/events/create', [EventController::class, 'create'])->name('events.create');
    Route::post('/events', [EventController::class, 'store'])->name('events.store');
    Route::get('/events/{event}/edit', [EventController::class, 'edit'])->name('events.edit');
    Route::put('/events/{event}', [EventController::class, 'update'])->name('events.update');
    Route::delete('/events/{event}', [EventController::class, 'destroy'])->name('events.destroy');


    /*
    |--------------------------------------------------------------------------
    | ADMIN AREA
    |--------------------------------------------------------------------------
    */
    Route::middleware(['auth', 'admin'])->group(function () {

        Route::get('/users', [UserController::class, 'index'])->name('users.index');
        Route::get('/users/create', function () {
            return view('users.create');
        })->name('users.create');
        Route::post('/users', [UserController::class, 'store'])->name('users.store');
        Route::get('/users/{user}/edit', [UserController::class, 'edit'])->name('users.edit');
        Route::put('/users/{user}', [UserController::class, 'update'])->name('users.update');

        Route::delete('/users/{user}', [UserController::class, 'destroy'])->name('users.destroy');


    });


    Route::get('/participants', [ParticipantController::class, 'index'])->name('participants');


    Route::get('/participants/create', [ParticipantController::class, 'create'])->name('participants.create');
    Route::post('/participants', [ParticipantController::class, 'store'])->name('participants.store');
Route::get('/participants/{participant}/edit', [ParticipantController::class, 'edit'])
    ->name('participants.edit');

Route::put('/participants/{participant}', [ParticipantController::class, 'update'])
    ->name('participants.update');

Route::delete('/participants/{participant}', [ParticipantController::class, 'destroy'])
    ->name('participants.destroy');

    /*
    |--------------------------------------------------------------------------
    | LOGOUT
    |--------------------------------------------------------------------------
    */
    Route::post('/logout', [AuthController::class, 'logout'])->name('logout');
});

/*
|--------------------------------------------------------------------------
| 🔁 FALLBACK
|--------------------------------------------------------------------------
*/

Route::fallback(function () {
    return redirect()->route('login');
});