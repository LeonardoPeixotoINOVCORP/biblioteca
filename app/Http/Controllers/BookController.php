<?php

namespace App\Http\Controllers;

use App\Models\Book;
use Inertia\Inertia;

class BookController extends Controller
{
    public function index()
    {
        $books = Book::with(['publisher', 'authors'])->get();

        return Inertia::render('Books/Index', [
            'books' => $books
        ]);
    }
}
