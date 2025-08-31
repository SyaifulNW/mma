<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\MenteeController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\InisiatifController;
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

// Route::get('/task', function () {
//     return view('task.index');
// })->name('task.index');

Route::get('/sprint', function () {
    return view('sprint.index');
})->name('sprint.index');

// Sprint my
Route::get('/sprint/my', function () {
    return view('sprint.my');
})->name('sprint.my');

Route::get('/peserta', function () {
    return view('peserta.index', ['mentees' => App\Models\Mentee::all()]);
})->name('peserta.index');

// Batasi akses ke route ini hanya untuk role 'admin'



Route::get('/coach', function () {
    return view('coach.index');
})->name('coach.index');

Route::get('/settings', function () {
    return view('settings.index');
})->name('settings.index');


// Admin
Route::middleware(['auth', 'role:admin'])->get('/admin/dashboard', function () {
    return view('dashboard.admin');
})->name('admin.dashboard');

// Coach
Route::middleware(['auth', 'role:coach'])->get('/coach/dashboard', function () {
    return view('dashboard.coach');
})->name('coach.dashboard');

// Peserta
Route::middleware(['auth', 'role:peserta'])->get('/peserta/dashboard', function () {
    return view('dashboard.peserta');
})->name('peserta.dashboard');






// Hanya admin/coach yang bisa akses monitoring semua peserta
Auth::routes();

Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');

use App\Http\Controllers\TaskDashboardController;

Route::get('/task', [TaskDashboardController::class, 'index'])->name('task.index');

// Tambah Inisiatif

Route::post('/inisiatif', [InisiatifController::class, 'store'])->name('inisiatif.store');
Route::patch('/inisiatif/{id}/toggle', [InisiatifController::class, 'toggle'])->name('inisiatif.toggle');


// crud mentee

Route::resource('mentees', MenteeController::class);








