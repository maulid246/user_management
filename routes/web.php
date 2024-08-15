<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\UserController;



Route::get('/', [AuthController::class, 'showLoginForm'])->name('welcome');


Route::get('/login', [AuthController::class, 'showLoginForm'])->name('login');
Route::post('/login', [AuthController::class, 'login']);


Route::get('/register', [AuthController::class, 'showRegisterForm'])->name('register');
Route::post('/register', [AuthController::class, 'register']);

Route::get('dashboard', [AuthController::class, 'dashboard'])->middleware('auth');

Route::get('/create-user', [AuthController::class, 'createUser'])->name('createUser');
Route::post('/store-user', [AuthController::class, 'storeUser'])->name('storeUser');

Route::put('update-user/{id}', [AuthController::class, 'updateUser'])->name('updateUser');
Route::delete('delete-user/{id}', [AuthController::class, 'deleteUser'])->name('deleteUser');

Route::get('/dashboard', [AuthController::class, 'dashboard'])->name('dashboard');
Route::post('upload-profile-picture/{id}', [AuthController::class, 'uploadProfilePicture'])->name('uploadProfilePicture');


Route::post('/logout', [AuthController::class, 'logout'])->name('logout');


Route::resource('users', UserController::class);


Route::middleware(['auth'])->group(function () {
   
});