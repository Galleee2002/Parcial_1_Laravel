<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AdminPostsController;
use App\Http\Controllers\AdminUsersController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\PostsController;
use App\Http\Controllers\ServicesController;

Route::get('/', [HomeController::class, 'index'])->name('home');

Route::get('/servicios', [ServicesController::class, 'index'])->name('services.index');
Route::get('/servicios/{id}', [ServicesController::class, 'show'])->name('services.show')->whereNumber('id');

Route::get('/blog', [PostsController::class, 'index'])->name('blog.index');
Route::get('/blog/{id}', [PostsController::class, 'show'])->name('blog.show')->whereNumber('id');

Route::get('/admin/login', [AuthController::class, 'showForm'])->name('auth.login.form');
Route::post('/admin/login', [AuthController::class, 'processForm'])->name('auth.login.process');
Route::post('/admin/logout', [AuthController::class, 'processLogout'])->name('auth.logout.process');

Route::get('/registro', [AuthController::class, 'showRegisterForm'])->name('auth.register.form');
Route::post('/registro', [AuthController::class, 'processRegister'])->name('auth.register.process');

Route::get('/admin/posts', [AdminPostsController::class, 'index'])->name('admin.posts.index')->middleware('auth')->middleware('administrator');
Route::get('/admin/posts/crear', [AdminPostsController::class, 'create'])->name('admin.posts.create')->middleware('auth')->middleware('administrator');
Route::post('/admin/posts/crear', [AdminPostsController::class, 'store'])->name('admin.posts.store')->middleware('auth')->middleware('administrator');
Route::get('/admin/posts/{id}/editar', [AdminPostsController::class, 'edit'])->name('admin.posts.edit')->whereNumber('id')->middleware('auth')->middleware('administrator');
Route::post('/admin/posts/{id}/editar', [AdminPostsController::class, 'update'])->name('admin.posts.update')->whereNumber('id')->middleware('auth')->middleware('administrator');
Route::get('/admin/posts/{id}/eliminar', [AdminPostsController::class, 'delete'])->name('admin.posts.delete')->whereNumber('id')->middleware('auth')->middleware('administrator');
Route::post('/admin/posts/{id}/eliminar', [AdminPostsController::class, 'destroy'])->name('admin.posts.destroy')->whereNumber('id')->middleware('auth')->middleware('administrator');

Route::get('/admin/usuarios', [AdminUsersController::class, 'index'])->name('admin.users.index')->middleware('auth')->middleware('administrator');
Route::get('/admin/usuarios/{id}', [AdminUsersController::class, 'show'])->name('admin.users.show')->whereNumber('id')->middleware('auth')->middleware('administrator');
