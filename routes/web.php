<?php

use App\Http\Controllers\CategoryController;
use App\Http\Controllers\CommentController;
use App\Http\Controllers\PostController;
use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\LikeController ;
use App\Http\Controllers\AdminController ;
Route::get('/', function () {
    if(Auth::check()){
        return redirect()->route('dashboard');
    }
    return view('welcome');
});


Route::get('/dashboard',[PostController::class,'index'])->name('dashboard');
Route::get('posts/category/{id}',[CategoryController::class,'postsByCategory'])->name('postsByCategory');
Route::get('/post/{id}', [PostController::class, 'show'])->name('show.post');


Route::middleware(['auth','adminOrAuthor'])->group(function (){
     Route::get('/posts/create', [PostController::class, 'create'])->name('createPost');
     Route::post('/create', [PostController::class, 'store'])->name('store.post');
     Route::get('/posts', [PostController::class, 'myPosts'])->name('myPosts');

});

Route::middleware(['auth','adminOrPostUser'])->group(function (){
    Route::get('/posts/{id}/edit', [PostController::class, 'edit'])->name('editPost');
    Route::patch('/posts/{id}', [PostController::class, 'update'])->name('update.post');
    Route::delete('/posts/{id}', [PostController::class, 'destroy'])->name('destroy.post');
});

Route::middleware('auth')->group(function (){
    Route::post('/permissions',[\App\Http\Controllers\PermissionController::class,'store'])->name('request.permission');
    Route::get('/like/{id}',[LikeController::class ,'store'])->name('like');
    Route::post('comment',[CommentController::class ,'store'])->name('store.comment');

});

Route::middleware(['auth','admin'])->group(function (){
    Route::get('admin/dashboard',[AdminController::class,'index'])->name('admin.dashboard');
    Route::get('admin/users', [ProfileController::class, 'index'])->name('admin.users');
    Route::get('admin/users/{id}', [ProfileController::class, 'adminEdit'])->name('admin.users.edit');
    Route::put('admin/users/{id}', [ProfileController::class, 'adminUpdate'])->name('admin.users.update');
    Route::delete('admin/users/{id}', [ProfileController::class, 'adminDestroy'])->name('admin.users.destroy');
    Route::get('notifications/{id}/accept',[\App\Http\Controllers\PermissionController::class,'accept'])->name('permission.accept');
    Route::get('notifications/{id}/reject',[\App\Http\Controllers\PermissionController::class,'reject'])->name('permission.reject');
    Route::get('notifications',[\App\Http\Controllers\PermissionController::class,'index'])->name('notifications');
    Route::get('categories',[\App\Http\Controllers\CategoryController::class,'index'])->name('admin.categories');
    Route::get('categories/{id}/edit',[\App\Http\Controllers\CategoryController::class,'edit'])->name('admin.categories.edit');
    Route::put('categories/{id}',[\App\Http\Controllers\CategoryController::class,'update'])->name('admin.categories.update');
    Route::get('categories/create',[\App\Http\Controllers\CategoryController::class,'create'])->name('admin.categories.create');
    Route::post('categories/{id}',[\App\Http\Controllers\CategoryController::class,'store'])->name('admin.categories.store');
    Route::delete('categories/{id}',[\App\Http\Controllers\CategoryController::class,'destroy'])->name('admin.categories.destroy');

});




Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');

});



require __DIR__.'/auth.php';
