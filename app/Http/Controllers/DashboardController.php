<?php

namespace App\Http\Controllers;

use App\Models\Book;
use App\Models\Author;
use App\Models\Publisher;
use App\Models\BookRequest;
use Inertia\Inertia;

class DashboardController extends Controller
{
    public function index()
    {
        $stats = [
            'total_books' => Book::count(),
            'total_authors' => Author::count(),
            'total_publishers' => Publisher::count(),
            'total_requests' => BookRequest::count(),
            'latest_books' => Book::latest()->take(5)->get(),
            'latest_authors' => Author::latest()->take(5)->get(),
            'latest_publishers' => Publisher::latest()->take(5)->get(),
        ];
    return Inertia::render('Dashboard', ['stats' => $stats]);
    }
}