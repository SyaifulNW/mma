<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\TaskController;


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

Route::get('/', function () {
    return view('welcome');
});

Route::get('/home', function () {
    return view('home');
})->name('dashboard');

Route::get('/task', function () {
    return view('task.index');
})->name('task.index');

Route::get('/sprint', function () {
    return view('sprint.index');
})->name('sprint.index');

Route::get('/peserta', function () {
    return view('peserta.index');
})->name('peserta.index');

Route::get('/coach', function () {
    return view('coach.index');
})->name('coach.index');

Route::get('/settings', function () {
    return view('settings.index');
})->name('settings.index');


Auth::routes();

Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');



// Task routes

