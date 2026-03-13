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

    Route::get('/books/export', [BookController::class,'export'])->name('books.export');
    Route::get('/books/export-all', [BookController::class,'exportAll'])->name('books.exportAll');

    Route::get('/authors', [AuthorController::class, 'index'])->name('authors');
    Route::get('/author/create', [AuthorController::class, 'create'])->name('authors.create');
    Route::post('/author', [AuthorController::class,'store'])->name('authors.store');
    Route::get('/author/{author}', [AuthorController::class, 'show'])->name('authors.show');
    Route::get('/author/edit/{author}', [AuthorController::class, 'edit'])->name('authors.edit');
    Route::put('/author/{author}', [AuthorController::class, 'update'])->name('authors.update');
    Route::delete('/author/{author}', [AuthorController::class, 'destroy'])->name('authors.destroy');
    
    Route::get('/publishers', [PublisherController::class, 'index'])->name('publishers');
    Route::get('/publisher/create', [publisherController::class, 'create'])->name('publishers.create');
    Route::get('/publisher/{publisher}', [PublisherController::class, 'show'])->name('publishers.show');
    Route::post('/publisher', [PublisherController::class,'store'])->name('publishers.store');
    Route::get('/publisher/edit/{publisher}', [PublisherController::class, 'edit'])->name('publishers.edit');
    Route::put('/publisher/{publisher}', [PublisherController::class, 'update'])->name('publishers.update');
    Route::delete('/publisher/{publisher}', [PublisherController::class, 'destroy'])->name('publishers.destroy');

});
