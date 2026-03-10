<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Author;
use Inertia\Inertia;

class AuthorController extends Controller
{
    public function index(){

        $authors = Author::all();

        return Inertia::render('Authors/Index', [
            'authors' => $authors
        ]);
    }
}
