<?php

namespace App\Http\Controllers;

use App\Models\Book;
use App\Models\Author;
use App\Models\Publisher;
use Inertia\Inertia;

class DashboardController extends Controller
{
    public function index()
    {
        return Inertia::render('Dashboard', [
            'stats' => [
                'total_books'      => Book::count(),
                'total_authors'    => Author::count(),
                'total_publishers' => Publisher::count(),
            ]
        ]);
    }
}