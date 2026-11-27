<?php

use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});

Auth::routes();

Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');

// rutas del administrador

Route::get('/admin', [App\Http\Controllers\AdminController::class, 'index'])->name('admin.index')
->middleware('auth');

// rutas del administrador - usuarios
Route::get('/admin/usuarios', [App\Http\Controllers\UsuarioController::class, 'index'])->name('admin.usuarios.index')
->middleware('auth');
// TODO: cuando existan los roles, cambiar a que solo un admin pueda crear
Route::post('/admin/usuarios', [App\Http\Controllers\UsuarioController::class, 'store'])->name('admin.usuarios.store')
->middleware('auth');
