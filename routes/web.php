<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AdminPostsController;
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

Route::get('/admin/posts', [AdminPostsController::class, 'index'])->name('admin.posts.index');
Route::get('/admin/posts/crear', [AdminPostsController::class, 'create'])->name('admin.posts.create');
Route::post('/admin/posts/crear', [AdminPostsController::class, 'store'])->name('admin.posts.store');
Route::get('/admin/posts/{id}/editar', [AdminPostsController::class, 'edit'])->name('admin.posts.edit')->whereNumber('id');
Route::post('/admin/posts/{id}/editar', [AdminPostsController::class, 'update'])->name('admin.posts.update')->whereNumber('id');
Route::get('/admin/posts/{id}/eliminar', [AdminPostsController::class, 'delete'])->name('admin.posts.delete')->whereNumber('id');
Route::post('/admin/posts/{id}/eliminar', [AdminPostsController::class, 'destroy'])->name('admin.posts.destroy')->whereNumber('id');
