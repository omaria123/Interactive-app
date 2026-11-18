<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\FormController;
use App\Http\Controllers\PostController;

Route::get('/', function () {
    return view('home');
});

Route::get('/form', [FormController::class, 'showForm'])->name('form.show');
Route::post('/form', [FormController::class, 'submitForm'])->name('form.submit');

Route::get('/records', [FormController::class, 'showRecords'])->name('records');

Route::post('posts/{id}/restore', [PostController::class, 'restore'])->name('posts.restore');

Route::resource('posts', PostController::class);
Route::post('posts/{post}/comments', [PostController::class, 'addComment'])->name('posts.comments.store');