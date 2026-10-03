<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AdminPostsController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\PostsController;
use App\Http\Controllers\ServicesController;

Route::get('/', [HomeController::class, 'index'])->name('home');

Route::get('/servicios', [ServicesController::class, 'index'])->name('services.index');
Route::get('/servicios/{id}', [ServicesController::class, 'show'])->name('services.show')->whereNumber('id');

Route::get('/blog', [PostsController::class, 'index'])->name('blog.index');
Route::get('/blog/{id}', [PostsController::class, 'show'])->name('blog.show')->whereNumber('id');

Route::get('/admin/posts', [AdminPostsController::class, 'index'])->name('admin.posts.index');
Route::get('/admin/posts/crear', [AdminPostsController::class, 'create'])->name('admin.posts.create');
Route::post('/admin/posts/crear', [AdminPostsController::class, 'store'])->name('admin.posts.store');
