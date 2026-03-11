<?php

use Illuminate\Foundation\Application;
use Illuminate\Support\Facades\Route;
use Inertia\Inertia;
use App\Http\Controllers\BookController;
use App\Http\Controllers\AuthorController;
use App\Http\Controllers\PublisherController;
use App\Http\Controllers\DashboardController;

Route::get('/', function () {
    return Inertia::render('Welcome', [
        'canLogin' => Route::has('login'),
        'canRegister' => Route::has('register'),
        'laravelVersion' => Application::VERSION,
        'phpVersion' => PHP_VERSION,
    ]);
});

Route::middleware([
    'auth:sanctum',
    config('jetstream.auth_session'),
    'verified',
])->group(function () {
    

    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');

    Route::get('/books', [BookController::class, 'index'])->name('books');
    Route::get('/book/create', [BookController::class, 'create'])->name('books.create');
    Route::post('/book', [BookController::class,'store'])->name('books.store');
    Route::get('/book/{book}', [BookController::class, 'show'])->name('books.show');
    Route::get('/book/edit/{book}', [BookController::class, 'edit'])->name('books.edit');
    Route::put('/book/{book}', [BookController::class, 'update'])->name('books.update');
    Route::delete('/book/{book}', [BookController::class, 'destroy'])->name('books.destroy');


    Route::get('/authors', [AuthorController::class, 'index'])->name('authors');
    Route::get('/author/create', [AuthorController::class, 'create'])->name('authors.create');
    Route::post('/author', [AuthorController::class,'store'])->name('authors.store');
    Route::get('/author/{author}', [AuthorController::class, 'show'])->name('authors.show');
    
    Route::get('/publishers', [PublisherController::class, 'index'])->name('publishers');
});
