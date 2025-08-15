<?php

use App\Http\Controllers\Admin\AdminController;
use App\Http\Controllers\PostController;
use App\Http\Controllers\ProfileController;
use App\Livewire\Admin\CommentsManagement;
use App\Livewire\Admin\PostsManagement;
use App\Livewire\Admin\UsersManagement;
use App\Livewire\Posts\PostShow;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;

// Public routes (no authentication required)
Route::get('/', function () {
    return view('welcome');
})->name('welcome');

Route::get('/posts', [PostController::class, 'index'])->name('posts.index');
Route::get('/posts/list', [PostController::class, 'postslist'])->name('posts.list');
Route::get('/posts/create', [PostController::class, 'create'])->name('posts.create');
Route::get('/posts/{slug}', [PostController::class, 'show'])->name('posts.show');

// Logout route
Route::post('/logout', function () {
    Auth::logout();
    request()->session()->invalidate();
    request()->session()->regenerateToken();
    return redirect('/');
})->name('logout');

// Protected routes (authentication required)
Route::middleware(['auth'])->group(function () {
    Route::get('/profile/{user}', [ProfileController::class, 'index'])->name('profile');
    
    // Post management routes (require author/admin roles)
    Route::get('/posts/{id}/edit', [PostController::class, 'edit'])->name('posts.edit');
    Route::put('/posts/{id}', [PostController::class, 'update'])->name('posts.update');
    Route::delete('/posts/{id}', [PostController::class, 'destroy'])->name('posts.destroy');
});

// Admin routes (authentication + admin role required)
Route::middleware(['auth', 'admin'])->prefix('admin')->name('admin.')->group(function () {
    Route::get('/', [AdminController::class, 'dashboard'])->name('dashboard');
    Route::get('/posts', [AdminController::class,'posts'])->name('posts');
    Route::get('/comments', [AdminController::class,'comments'])->name('comments');
    Route::get('/users', [AdminController::class,'users'])->name('users');
});

require __DIR__.'/auth.php';
