<?php

use App\Http\Controllers\Admin\AdminController;
use App\Http\Controllers\PostController;
use App\Http\Controllers\ProfileController;
use App\Livewire\Admin\CommentsManagement;
use App\Livewire\Admin\PostsManagement;
use App\Livewire\Admin\UsersManagement;
use Illuminate\Support\Facades\Route;
Route::middleware(['auth'])->group(function () {
    Route::get('/posts', [PostController::class, 'index'])->name('posts.index');
    Route::get('/posts/list', [PostController::class, 'postslist'])->name('posts.list');
    Route::get('/posts/{slug}', [PostController::class, 'show'])->name('posts.show');
    Route::get('/profile/{user}', [ProfileController::class, 'index'])->name('profile');
});
Route::view('/', 'welcome');

Route::view('dashboard', 'dashboard')
    ->middleware(['auth', 'verified'])
    ->name('dashboard');

// Route::view('profile', 'profile')
//     ->middleware(['auth'])
//     ->name('profile');
Route::middleware(['auth', 'admin'])->prefix('admin')->name('admin.')->group(function () {
    Route::get('/', [AdminController::class, 'dashboard'])->name('dashboard');
    Route::get('/posts', PostsManagement::class)->name('posts');
    Route::get('/comments', CommentsManagement::class)->name('comments');
    Route::get('/users', UsersManagement::class)->name('users');
});

require __DIR__.'/auth.php';
