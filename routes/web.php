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


Route::get('/dashboard',[PostController::class,'index']) ->middleware(['auth', 'verified'])->name('dashboard');





Route::middleware(['auth','adminOrAuthor'])->group(function (){
     Route::get('/posts/create', [PostController::class, 'create'])->name('createPost');
     Route::post('/create', [PostController::class, 'store'])->name('store.post');

});


Route::middleware('auth')->group(function (){
    Route::get('/post/{id}', [PostController::class, 'show'])->name('show.post');
    Route::get('/like/{id}',[LikeController::class ,'store'])->name('like');
    Route::post('comment',[CommentController::class ,'store'])->name('store.comment');
    Route::get('posts/category/{id}',[CategoryController::class,'postsByCategory'])->name('postsByCategory');
});

Route::middleware(['auth','admin'])->group(function (){
    Route::get('admin/dashboard',[AdminController::class,'index'])->name('admin.dashboard');
    Route::get('/post/{id}/edit', [PostController::class, 'edit'])->name('edit.post');
    Route::delete('/post/{id}', [PostController::class, 'destroy'])->name('destroy.post');
    Route::put('/post/{id}', [PostController::class, 'update'])->name('update.post');
    Route::get('admin/users', [ProfileController::class, 'index'])->name('admin.users');
    Route::get('admin/users/{id}', [ProfileController::class, 'adminEdit'])->name('admin.users.edit');
    Route::put('admin/users/{id}', [ProfileController::class, 'adminUpdate'])->name('admin.users.update');
    Route::delete('admin/users/{id}', [ProfileController::class, 'adminDestroy'])->name('admin.users.destroy');
});




Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});



require __DIR__.'/auth.php';
