<?php

use App\Http\Controllers\RegisteredUserController;
use App\Http\Controllers\SessionController;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\JobController;

// Homepage routing
Route::view('/', 'home');
// Contact page routing
Route::view('/contact', 'contact');

// old Jobs routing
// Route::resource('jobs', JobController::class);

// Jobs routing
Route::get('/jobs', [JobController::class, 'index']);
Route::get('/jobs/create', [JobController::class, 'create']);
// must be signed in to store a job
Route::post('/jobs', [JobController::class, 'store'])->middleware('auth');
Route::get('/jobs/{job}', [JobController::class, 'show']);
// must be signed in and authorized to edit this job; multiple middlewares expressed in an 		//	array; use can, provide name of gate, pass in relative job - use job to refer to
//	wildcard {job} and Laravel will use implicit model binding to get the job and pass
//	it to the gate
Route::get('/jobs/{job}/edit', [JobController::class, 'edit'])
    ->middleware('auth')
    ->can('edit','job');
Route::patch('/jobs/{job}', [JobController::class, 'update'])
    ->middleware('auth')
    ->can('edit','job');
Route::delete('/jobs/{job}', [JobController::class, 'destroy'])
    ->middleware('auth')
    ->can('edit','job');

// Auth
Route::get('/register', [RegisteredUserController::class, 'create']);
Route::post('/register', [RegisteredUserController::class, 'store']);

Route::get('/login', [SessionController::class, 'create']);
Route::post('/login', [SessionController::class, 'store']);
Route::post('/logout', [SessionController::class, 'destroy']);
