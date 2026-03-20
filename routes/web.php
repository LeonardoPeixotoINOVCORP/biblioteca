<?php
use Illuminate\Foundation\Application;
use Illuminate\Support\Facades\Route;
use Inertia\Inertia;
use App\Http\Controllers\BookController;
use App\Http\Controllers\AuthorController;
use App\Http\Controllers\PublisherController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\BookRequestController;
use App\Http\Controllers\UserController; // ← novo

Route::get('/', function () {
    return Inertia::render('Welcome', [
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

    // Books
    Route::get('/books', [BookController::class, 'index'])->name('books');
    Route::get('/book/create', [BookController::class, 'create'])->name('books.create');
    Route::get('/book/request', [BookController::class, 'request'])->name('books.request');
    Route::get('/books/export', [BookController::class, 'export'])->name('books.export');
    Route::get('/books/export-all', [BookController::class, 'exportAll'])->name('books.exportAll');
    Route::post('/book', [BookController::class, 'store'])->name('books.store');
    Route::get('/book/{book}', [BookController::class, 'show'])->name('books.show');
    Route::get('/book/edit/{book}', [BookController::class, 'edit'])->name('books.edit');
    Route::put('/book/{book}', [BookController::class, 'update'])->name('books.update');
    Route::delete('/book/{book}', [BookController::class, 'destroy'])->name('books.destroy');

    // Authors
    Route::get('/authors', [AuthorController::class, 'index'])->name('authors');
    Route::get('/author/create', [AuthorController::class, 'create'])->name('authors.create');
    Route::post('/author', [AuthorController::class, 'store'])->name('authors.store');
    Route::get('/author/{author}', [AuthorController::class, 'show'])->name('authors.show');
    Route::get('/author/edit/{author}', [AuthorController::class, 'edit'])->name('authors.edit');
    Route::put('/author/{author}', [AuthorController::class, 'update'])->name('authors.update');
    Route::delete('/author/{author}', [AuthorController::class, 'destroy'])->name('authors.destroy');

    // Publishers
    Route::get('/publishers', [PublisherController::class, 'index'])->name('publishers');
    Route::get('/publisher/create', [PublisherController::class, 'create'])->name('publishers.create');
    Route::get('/publisher/{publisher}', [PublisherController::class, 'show'])->name('publishers.show');
    Route::post('/publisher', [PublisherController::class, 'store'])->name('publishers.store');
    Route::get('/publisher/edit/{publisher}', [PublisherController::class, 'edit'])->name('publishers.edit');
    Route::put('/publisher/{publisher}', [PublisherController::class, 'update'])->name('publishers.update');
    Route::delete('/publisher/{publisher}', [PublisherController::class, 'destroy'])->name('publishers.destroy');

    // Book Requests
    Route::get('/book-requests', [BookRequestController::class, 'index'])->name('book-requests.index');
    Route::get('/book-requests/create', [BookRequestController::class, 'create'])->name('book-requests.create');
    Route::post('/book-requests', [BookRequestController::class, 'store'])->name('book-requests.store');
    Route::delete('/book-requests/clear', [BookRequestController::class, 'clear'])->name('book-requests.clear');
    Route::delete('/book-requests/{bookRequest}', [BookRequestController::class, 'destroy'])->name('book-requests.destroy');
    Route::patch('/book-requests/{bookRequest}/approve', [BookRequestController::class, 'approve'])->name('book-requests.approve');
    Route::patch('/book-requests/{bookRequest}/reject', [BookRequestController::class, 'reject'])->name('book-requests.reject');
    Route::patch('/book-requests/{bookRequest}/returned', [BookRequestController::class, 'returned'])->name('book-requests.returned');

    
    // Users
    Route::get('/users', [UserController::class, 'index'])->name('users.index');
    Route::get('/users/{user}', [UserController::class, 'show'])->name('users.show');
    Route::patch('/users/{user}/role', [UserController::class, 'updateRole'])->name('users.updateRole');
    Route::delete('/users/{user}', [UserController::class, 'destroy'])->name('users.destroy');

});